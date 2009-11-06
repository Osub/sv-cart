<?php
/*****************************************************************************
 * SV-Cart 友情链接
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: links_controller.php 4691 2009-09-28 10:11:57Z huangbo $
*****************************************************************************/
class LinksController extends AppController {
	var $name = 'Links';
	var $helpers = array('Html','Pagination');
	var $components = array('Pagination','RequestHandler');
	var $uses = array('Link','LinkI18n');

	function index(){
		/*判断权限*/
		$this->operator_privilege('friendly_link_view');
		/*end*/
		$this->pageTitle = '友情链接'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理','url'=>'');
		$this->navigations[] = array('name'=>'友情链接','url'=>'/links/');
		$this->set('navigations',$this->navigations);
		
		$this->Link->set_locale($this->locale);
		$condition = " ";
		$page = 1;
		$rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$parameters = array($rownum,$page);		
		$options = array();
   	    $total = count($this->Link->find("all",array("conditions"=>$condition,"fields"=>"DISTINCT Link.id")));

		$sortClass = 'Link';
		$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		
		$data = $this->Link->find('all',array('page'=>$page,'limit'=>$rownum,'conditions'=>$condition,'order'=>'Link.orderby,Link.created,Link.id'));
		
		foreach( $data as $k=>$v ){
			if(strlen($v['LinkI18n']['img01'])>18){
				$data[$k]['LinkI18n']['img01'] = substr($v['LinkI18n']['img01'], 0, 18)."...";
			}
			if(strlen($v['LinkI18n']['url'])>18){
				$data[$k]['LinkI18n']['url'] = substr($v['LinkI18n']['url'], 0, 18)."...";
			}
		}
		
		
		
		$this->set('links',$data);
	}
	function edit( $id ){
		/*判断权限*/
		$this->operator_privilege('friendly_link_operation');
		/*end*/
		$this->pageTitle = "编辑友情链接 - 友情链接"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理','url'=>'');
		$this->navigations[] = array('name'=>'友情链接','url'=>'/links/');
		$this->navigations[] = array('name'=>'编辑友情链接','url'=>'');
		
		if($this->RequestHandler->isPost()){
			foreach($this->data['LinkI18n'] as $v){
              	     	    $linkI18n_info=array(
		                           'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'link_id'=> isset($v['link_id'])?$v['link_id']:$id,
		                           'name'=>	isset($v['name'])?$v['name']:'',
		                           'url'=>$v['url'],
		                           'description'=>$v['description'],
		                           'img01'=>	$v['img01'],
		                           'img02'=>	$v['img02']
		                     );
		                     $this->LinkI18n->saveall(array('LinkI18n'=>$linkI18n_info));//更新多语言
             }
			$this->Link->save($this->data); //关联保存
			foreach( $this->data['LinkI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑友情链接:'.$userinformation_name ,'operation');
    	    }
			$this->flash("友情链接  ".$userinformation_name." 编辑成功。点击这里继续编辑该友情链接。",'/links/edit/'.$id,10);

		}
		$link = $this->Link->localeformat( $id );
		$this->set("link",$link);
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$link["LinkI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	
	function add(){
		/*判断权限*/
		$this->operator_privilege('friendly_link_add');
		/*end*/
		$this->pageTitle = "添加友情链接 - 友情链接"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理','url'=>'');
		$this->navigations[] = array('name'=>'友情链接','url'=>'/links/');
		$this->navigations[] = array('name'=>'添加友情链接','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->data['Link']['orderby'] = !empty($this->data['Link']['orderby'])?$this->data['Link']['orderby']:"50";

			$this->Link->save($this->data); //关联保存
			$id=$this->Link->id;
			   //新增多语言
			   
			   	if(is_array($this->data['LinkI18n']))
			          foreach($this->data['LinkI18n'] as $k => $v){
				            $v['link_id']=$id;
				            $this->LinkI18n->id='';
				            $this->LinkI18n->save($v); 
			           }
			foreach( $this->data['LinkI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加友情链接:'.$userinformation_name ,'operation');
    	    }
			$this->flash("友情链接 ".$userinformation_name."  添加成功。点击这里继续编辑该友情链接。",'/links/edit/'.$id,10);

		}
	
	}
	
	function remove( $id){
		/*判断权限*/
		$this->operator_privilege('friendly_link_operation');
		/*end*/
		
		$pn = $this->LinkI18n->find('list',array('fields' => array('LinkI18n.link_id','LinkI18n.name'),'conditions'=> 
                                        array('LinkI18n.link_id'=>$id,'LinkI18n.locale'=>$this->locale)));
        
		$this->Link->deleteall("Link.id = '".$id."'",false);
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除友情链接:'.$pn[$id] ,'operation');
    	}
	//	$this->LinkI18n->deleteall("link_id = '".$id."'",false);
		$this->flash("删除成功",'/links/',10);
	}
}

?>