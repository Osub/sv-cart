<?php
/*****************************************************************************
 * SV-Cart 包装管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: packages_controller.php 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/
class PackagesController extends AppController {

	var $name = 'Packages';
	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("Packaging","PackagingI18n");

	function index(){
		/*判断权限*/
		$this->operator_privilege('package_view');
		/*end*/
		$this->pageTitle = "包装"." - ".$this->configs['shop_name'];
		
		$this->navigations[] = array('name'=>'包装','url'=>'/packagings/');
		$this->set('navigations',$this->navigations);
		$packaging_list=$this->Packaging->findAll();
   		
   		$this->Packaging->set_locale($this->locale);
   	    $condition='';
   	    $total = count($this->Packaging->find("all",array("conditions"=>$condition,"fields"=>"DISTINCT Packaging.id")));

	    $sortClass='Packaging';
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters=Array($rownum,$page);
	    $options=Array();
	 	$page  = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
   	    $packaging_list=$this->Packaging->findAll($condition,'',"order by Packaging.orderby",$rownum,$page);
   		
   		
   		$this->set('package_list',$packaging_list);	
	}
	
	function edit( $id ){
		/*判断权限*/
		$this->operator_privilege('package_operation');
		/*end*/
		$this->pageTitle = "编辑包装 - 包装管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'包装管理','url'=>'/packages/');
		$this->navigations[] = array('name'=>'编辑包装','url'=>'');
		
		if($this->RequestHandler->isPost()){
			$this->data['Packaging']['orderby'] = !empty($this->data['Packaging']['orderby'])?$this->data['Packaging']['orderby']:50;
			$this->data['Packaging']['fee'] = !empty($this->data['Packaging']['fee'])?$this->data['Packaging']['fee']:0;
			$this->data['Packaging']['free_money'] = !empty($this->data['Packaging']['free_money'])?$this->data['Packaging']['free_money']:0;

			foreach($this->data['PackagingI18n'] as $v){
              	     $packagingI18n_info=array(
		                           'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'packaging_id'=> isset($v['packaging_id'])?$v['packaging_id']:$id,
		                           'name'=>	isset($v['name'])?$v['name']:'',
		                           'description'=>	$v['description']
		              );
		         $this->PackagingI18n->saveall(array('PackagingI18n'=>$packagingI18n_info));//更新多语言
             }
			$this->Packaging->save( $this->data );
			
			foreach( $this->data['PackagingI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			$id=$this->Packaging->id;
            //操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑包装:'.$userinformation_name ,'operation');
    	    }
			$this->flash("包装  ".$userinformation_name." 编辑成功。点击继续编辑该包装。",'/packages/edit/'.$id,10);

			
			
		}
		$packaging = $this->Packaging->localeformat( $id );
		$this->set("packaging",$packaging);
		
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$packaging["PackagingI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	
	function add(){
		$this->pageTitle = "添加包装 - 包装管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'包装管理','url'=>'/packages/');
		$this->navigations[] = array('name'=>'添加包装','url'=>'');
		$this->set('navigations',$this->navigations);
		
		if($this->RequestHandler->isPost()){

			$this->data['Packaging']['orderby'] = !empty($this->data['Packaging']['orderby'])?$this->data['Packaging']['orderby']:50;
			$this->data['Packaging']['fee'] = !empty($this->data['Packaging']['fee'])?$this->data['Packaging']['fee']:0;
			$this->data['Packaging']['free_money'] = !empty($this->data['Packaging']['free_money'])?$this->data['Packaging']['free_money']:0;

			$this->Packaging->save( $this->data );
			$id=$this->Packaging->id;
			//新增多语言
			   	if(is_array($this->data['PackagingI18n']))
			          foreach($this->data['PackagingI18n'] as $k => $v){
				            $v['packaging_id']=$id;
				            $this->PackagingI18n->id='';
				            $this->PackagingI18n->save($v); 
			           }
			foreach( $this->data['PackagingI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			$id=$this->Packaging->id;
            //操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加包装:'.$userinformation_name ,'operation');
    	    }
			$this->flash("包装  ".$userinformation_name." 添加成功。点击继续编辑该包装。",'/packages/edit/'.$id,10);
		}
	}
	
	function remove( $id){
		/*判断权限*/
		$this->operator_privilege('package_operation');
		/*end*/
		$pn = $this->PackagingI18n->find('list',array('fields' => array('PackagingI18n.packaging_id','PackagingI18n.name'),'conditions'=> 
                                 array('PackagingI18n.packaging_id'=>$id,'PackagingI18n.locale'=>$this->locale)));
		$condition=array("Packaging.id"=>$id);
		$this->Packaging->deleteAll( $condition );
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除包装:'.$pn[$id] ,'operation');
    	}
		$this->flash("删除成功",'/packages/','');
	}
}

?>