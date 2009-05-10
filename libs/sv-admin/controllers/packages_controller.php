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
 * $Id: packages_controller.php 943 2009-04-23 10:38:44Z huangbo $
*****************************************************************************/
class PackagesController extends AppController {

	var $name = 'Packages';
	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("Packaging","PackagingI18n");

	function index(){
		$this->pageTitle = "包装"." - ".$this->configs['shop_name'];
		
		$this->navigations[] = array('name'=>'包装','url'=>'/packagings/');
		$this->set('navigations',$this->navigations);
		$packaging_list=$this->Packaging->findAll();
   		
   		$this->Packaging->set_locale($this->locale);
   	    $condition='';
   	    $total = $this->Packaging->findCount($condition,0);
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
		$this->pageTitle = "编辑包装 - 包装管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'包装管理','url'=>'/packages/');
		$this->navigations[] = array('name'=>'编辑包装','url'=>'');
		$this->set('navigations',$this->navigations);
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
			$this->flash("编辑成功",'/packages/edit/'.$id,'');
		}
		$packaging = $this->Packaging->localeformat( $id );
		$this->set("packaging",$packaging);
		//pr( $packaging );
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
			$this->flash("添加成功",'/packages/edit/'.$id,'');
		}
	}
	
	function remove( $id ){
		$condition=array("Packaging.id"=>$id);
		$this->Packaging->deleteAll( $condition );
		$this->flash("删除成功",'/packages/','');
	}
}

?>