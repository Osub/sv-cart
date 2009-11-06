<?php
/*****************************************************************************
 * SV-Cart 导航设置
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: navigations_controller.php 4691 2009-09-28 10:11:57Z huangbo $
*****************************************************************************/
class NavigationsController extends AppController {
	var $name = 'Navigations';

	var $helpers = array('Html','Pagination');

	var $components = array ('Pagination','Cookie','RequestHandler');
	
	var $uses = array('Navigation','NavigationI18n','SystemResource');

	function index(){
		/*判断权限*/
		$this->operator_privilege('navigation_view');
		/*end*/
	   	$this->checkSession();
	   	
	   	
	   	$condition="1=1";
	  	//导航筛选查询条件
	   	$type = '';
	   	$controller = '';
	   	$navigation_name = '';
	   	if(isset($this->params['url']['type']) && $this->params['url']['type'] != ''){
	   	   	$condition .=" and Navigation.type= '".$this->params['url']['type']."'";
	   	   	$type = $this->params['url']['type'];
	   	}
	   	if(isset($this->params['url']['controller']) && $this->params['url']['controller'] != ''){
	   	   	$condition .=" and Navigation.controller= '".$this->params['url']['controller']."'";
	   	   	$controller = $this->params['url']['controller'];
	   	}
	   	if(isset($this->params['url']['navigation_name']) && $this->params['url']['navigation_name'] != ''){
			$condition2 = " NavigationI18n.name like '%".$this->params['url']['navigation_name']."%'";
			$navigation_name = $this->params['url']['navigation_name'];
			$navigationid = $this->NavigationI18n->find('list', array('fields'=>array('NavigationI18n.navigation_id'),'conditions'=>$condition2));
			$navigationid[] = 0;
			$condition .= " and Navigation.id in (".implode(',',$navigationid).")";
	    }
		$this->pageTitle = "导航设置"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理','url'=>'');
		$this->navigations[] = array('name'=>'导航设置','url'=>'/navigations/');
		
		$this->set('navigations',$this->navigations);
   	    $total = count($this->Navigation->find("all",array("conditions"=>$condition)));
	    $sortClass='Navigation';
	    $page=1;
	    $rownum=200000;//isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters=Array($rownum,$page);
	    $options=Array();
		$page  = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		$orderby = 'Navigation.type,Navigation.orderby,Navigation.id';
		$data = $this->Navigation->alltree($condition,$orderby,$rownum,$page,$this->locale);
		
		//资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(false);//find("first",array("conditions"=>array("code"=>"order_status")));
       	//
		$this->set("systemresource_info",$systemresource_info);
		$this->set('navigations2',$data);
		$this->set('type',$type);
		$this->set('controller',$controller);
		$this->set('navigation_name',$navigation_name);
		
		$this->set('types',$systemresource_info["navigation_type"]);
		$this->set('controllers',array('pages'=>'首页','categories'=>'分类','brands'=>'品牌','products'=>'商品','articles'=>'文章','cars'=>'购物车'));

	}
	
	function edit($id){
		/*判断权限*/
		$this->operator_privilege('navigation_edit');
		/*end*/
		$this->pageTitle = "编辑导航设置 - 导航设置"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理','url'=>'');
		$this->navigations[] = array('name'=>'导航设置','url'=>'/navigations/');
		$this->navigations[] = array('name'=>'编辑导航设置','url'=>'');
		
		
		if($this->RequestHandler->isPost()){
			$this->data['Navigation']['orderby'] = !empty($this->data['Navigation']['orderby'])?$this->data['Navigation']['orderby']:"50";
			//$this->NavigationI18n->deleteAll("navigation_id='".$this->data['Navigation']['id']."'",false);
			foreach($this->data['NavigationI18n'] as $v){
              	     	    $navigationI18n_info=array(
		                           'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'navigation_id'=> isset($v['navigation_id'])?$v['navigation_id']:$id,
		                           'name'=>	isset($v['name'])?$v['name']:'',
		                           'url'=> $v['url'],
		                           'description'=>	$v['description']
		                     );
		                     $this->NavigationI18n->saveall(array('NavigationI18n'=>$navigationI18n_info));//更新多语言
            }
			$this->Navigation->save($this->data);
			
			
			foreach( $this->data['NavigationI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑导航设置:'.$userinformation_name ,'operation');
    	    }
			$this->flash("导航设置 ".$userinformation_name." 编辑成功。点击这里继续编辑该导航设置。",'/navigations/edit/'.$id,10);

		}
		$this->data = $this->Navigation->localeformat($id);
		$navigation_data = $this->Navigation->find("all",array("conditions"=>array("Navigation.parent_id"=>"0")));
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$this->data["NavigationI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);
	    $this->set('navigation_data',$navigation_data);

	}

	function add(){
		/*判断权限*/
		$this->operator_privilege('navigation_add');
		/*end*/
		$this->pageTitle = "添加导航栏 - 导航设置"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理','url'=>'');
		$this->navigations[] = array('name'=>'导航设置','url'=>'/navigations/');
		$this->navigations[] = array('name'=>'添加导航栏','url'=>'');
		$this->set('navigations',$this->navigations);
		
		if($this->RequestHandler->isPost()){
			$this->data['Navigation']['orderby'] = !empty($this->data['Navigation']['orderby'])?$this->data['Navigation']['orderby']:"50";
		
			$this->Navigation->saveall(array("Navigation"=>$this->data['Navigation']));

			$id = $this->Navigation->id;
			if( !empty($this->data['NavigationI18n']) ){
				foreach($this->data['NavigationI18n'] as $k=>$v){
					$v['navigation_id'] = $id;
					
					$this->NavigationI18n->saveall(array("NavigationI18n"=>$v));
				}
			}
			foreach( $this->data['NavigationI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加导航设置:'.$userinformation_name ,'operation');
    	    }
			$this->flash("导航设置 ".$userinformation_name."  编辑成功。点击这里继续编辑该导航设置。",'/navigations/edit/'.$id,10);

		}
		$navigation_data = $this->Navigation->find("all",array("conditions"=>array("Navigation.parent_id"=>"0")));
	    $this->set('navigation_data',$navigation_data);
	}
	function remove($id){
		/*判断权限*/
		$this->operator_privilege('navigation_edit');
		/*end*/
		$pn = $this->NavigationI18n->find('list',array('fields' => array('NavigationI18n.navigation_id','NavigationI18n.name'),'conditions'=> 
                           array('NavigationI18n.navigation_id'=>$id,'NavigationI18n.locale'=>$this->locale)));
		$this->Navigation->deleteAll("Navigation.id='".$id."'");
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除导航设置:'.$pn[$id] ,'operation');
    	}
		$this->flash('删除成功','/navigations',5);
	}
}

?>