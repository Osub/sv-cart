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
 * $Id: navigations_controller.php 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
class NavigationsController extends AppController {
	var $name = 'Navigations';

	var $helpers = array('Html','Pagination');

	var $components = array ('Pagination','Cookie','RequestHandler');
	
	var $uses = array('Navigation','NavigationI18n');

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
		$this->navigations[] = array('name'=>'界面管理');
		$this->navigations[] = array('name'=>'导航设置','url'=>'/navigations/');
		
		$this->set('navigations',$this->navigations);
   	    $total = count($this->Navigation->find("all",array("conditions"=>$condition)));
	    $sortClass='Navigation';
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters=Array($rownum,$page);
	    $options=Array();
		$page  = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		
		$orderby = 'Navigation.type,Navigation.orderby,Navigation.id';
		$data = $this->Navigation->getdata($condition,$orderby,$rownum,$page,$this->locale);
		$this->set('navigations2',$data);
		$this->set('type',$type);
		$this->set('controller',$controller);
		$this->set('navigation_name',$navigation_name);
		$this->set('types',array('H'=>'帮助栏目','T'=>'顶部','B'=>'底部','M'=>'中间'));
		$this->set('controllers',array('pages'=>'首页','categories'=>'分类','brands'=>'品牌','products'=>'商品','articles'=>'文章','cars'=>'购物车'));

	}
	
	function edit($id){
		/*判断权限*/
		$this->operator_privilege('navigation_edit');
		/*end*/
		$this->pageTitle = "编辑导航设置 - 导航设置"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理');
		$this->navigations[] = array('name'=>'导航设置','url'=>'/navigations/');
		$this->navigations[] = array('name'=>'编辑导航设置','url'=>'');
		$this->set('navigations',$this->navigations);

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
			$this->flash("导航设置 ".$userinformation_name." 编辑成功。点击继续编辑该导航设置。",'/navigations/edit/'.$id,10);

		}
		$this->data = $this->Navigation->localeformat($id);
		//pr($this->data);
	}

	function add(){
		/*判断权限*/
		$this->operator_privilege('navigation_add');
		/*end*/
		$this->pageTitle = "添加导航栏 - 导航设置"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理');
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
			$this->flash("导航设置 ".$userinformation_name."  编辑成功。点击继续编辑该导航设置。",'/navigations/edit/'.$id,10);

		}
	}
	function remove($id){
		/*判断权限*/
		$this->operator_privilege('navigation_edit');
		/*end*/
		$this->Navigation->deleteAll("Navigation.id='".$id."'");
		$this->flash('删除成功','/navigations',5);
	}
}

?>