<?php
/*****************************************************************************
 * SV-Cart 商品类型管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: productstypes_controller.php 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
class ProductstypesController extends AppController {
	var $name = 'Productstypes';

	var $helpers = array('Html','Pagination');
	
	var $components = array('Pagination','RequestHandler');
	
	var $uses = array('ProductType','ProductTypeI18n','ProductTypeAttribute','ProductTypeAttributeI18n');

	function index(){
		/*判断权限*/
		$this->operator_privilege('goods_type_view');
		/*end*/
		$this->pageTitle = '商品类型管理'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商品类型管理','url'=>'/productstypes/');
		$this->set('navigations',$this->navigations);
		$condition = '';
		$page = 1;
		$rownum = 10;
		$parameters = array($rownum,$page);		
		$options = array();
		$total = $this->ProductType->findCount($condition,0);
		$sortClass = 'ProductType';
		list($page) = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		$data = $this->ProductType->find('all',array('page'=>$page,'limit'=>$rownum,'conditions'=>$condition,'order'=>'ProductType.orderby,ProductType.created,ProductType.id'));

		foreach($data as $k=>$v){
			$data[$k]['ProductType']['name'] = '';
			$data[$k]['ProductType']['num'] = count($v['ProductTypeAttribute']);
			if(!empty($v['ProductTypeI18n']))foreach($v['ProductTypeI18n'] as $vv){
				if($vv['locale'] == $this->locale){
					$data[$k]['ProductType']['name'] = $vv['name']  ;
				}
			}
		}
		$this->set('productstype',$data);	
	}
	function edit($id){
		/*判断权限*/
		$this->operator_privilege('goods_type_view');
		/*end*/
		$this->pageTitle = "编辑商品类型 - 商品类型管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商品类型管理','url'=>'/productstypes/');
		$this->navigations[] = array('name'=>'编辑商品类型','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->ProductTypeI18n->deleteAll("type_id='".$this->data['ProductType']['id']."'",false);
			$this->ProductType->saveAll($this->data);
			foreach( $this->data['ProductTypeI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			$id=$this->ProductType->id;

			$this->flash("商品类型  ".$userinformation_name." 编辑成功。点击继续编辑该商品类型。",'/productstypes/edit/'.$id,10);

		}
		$this->data = $this->ProductType->findById($id);
		foreach($this->data['ProductTypeI18n'] as $k=>$v){
			$this->data['ProductTypeI18n'][$v['locale']] = $v;
		}
	}
	function add(){
		/*判断权限*/
		$this->operator_privilege('goods_type_add');
		/*end*/
		$this->pageTitle = "编辑商品类型 - 商品类型管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商品类型管理','url'=>'/productstypes/');
		$this->navigations[] = array('name'=>'编辑商品类型','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->ProductType->saveAll($this->data);
			foreach( $this->data['ProductTypeI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			$id=$this->ProductType->id;

			$this->flash("商品类型  ".$userinformation_name." 添加成功。点击继续编辑该商品类型。",'/productstypes/edit/'.$id,10);

		}

	}
	function look( $id ){
		$this->pageTitle = '属性列表'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'属性列表','url'=>'/productstypes/');
		//$this->ProductType->set_locale($this->locale);
		$this->ProductTypeAttribute->set_locale($this->locale);
		$ProductType_info = $this->ProductType->findById($id);
//		pr($ProductType_info);
		foreach( $ProductType_info['ProductTypeI18n'] as $k=>$v ){
			if($v['locale']==$this->locale){
				$name = $v['name'];
			}
		}
		$this->navigations[] = array('name'=>$name,'url'=>'/productstypes/');
		$this->set('navigations',$this->navigations);
//		$this->ProductTypeAttribute->hasOne = array();
		$attribute = $this->ProductTypeAttribute->findAll(array("product_type_id"=>$id));
		$datas = $this->ProductType->findById( $id );
		//pr($attribute);
		$id_arr = array();
		foreach( $attribute as $k=>$v ){
			$attribute[$k]["ProductTypeAttribute"]["name"] = "";
			$attribute[$k]["ProductTypeAttribute"]["typename"] = "";
			if(!in_array($v['ProductTypeAttribute']['id'],$id_arr)){
				$id_arr[] = $v['ProductTypeAttribute']['id'];
				foreach( $v['ProductTypeAttributeI18n'] as $kk=>$vv ){
					if( $vv['locale'] == $this->locale ){
						$attribute[$k]["ProductTypeAttributeI18n"]["name"] = $vv['name'];
					}
				}
				foreach( $datas['ProductTypeI18n'] as $kkk=>$vvv ){
					if( $vvv['locale'] == $this->locale ){
						$attribute[$k]["ProductTypeAttribute"]["typename"] = $vvv["name"];
					}
				}
			}else{
				unset($attribute[$k]);
			}
		}
		//pr( $attribute );
		$this->set("id",$id);
		$this->set("attribute",$attribute);
	}
	function lookedit( $id ,$ids){
		$this->pageTitle = "编辑属性 - 属性管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'属性管理','url'=>'/productstypes/look/');
		$this->navigations[] = array('name'=>'编辑属性','url'=>'');
		$this->set('navigations',$this->navigations);
		
//		$this->ProductTypeAttribute->hasOne = array();
		
		if($this->RequestHandler->isPost()){
			$this->data['ProductTypeAttribute']['orderby'] = !empty($this->data['ProductTypeAttribute']['orderby'])?$this->data['ProductTypeAttribute']['orderby']:50;
			$this->ProductTypeAttributeI18n->deleteAll("ProductTypeAttributeI18n.product_type_attribute_id='".$this->data['ProductTypeAttribute']['id']."'",false);
			$this->ProductTypeAttribute->deleteAll("ProductTypeAttribute.id='".$this->data['ProductTypeAttribute']['id']."'",false);
			$this->ProductTypeAttribute->saveAll($this->data['ProductTypeAttribute']);
			foreach($this->data['ProductTypeAttributeI18n'] as $v){
              	     $p_I18n_info=array(
		                           'id'				=>	'',
		                           'locale'			=>	$v['locale'],
		                           'product_type_attribute_id'		=> 	$this->data['ProductTypeAttribute']['id'],
		                           'name'	=> 	$v['name']
		              );
		        $this->ProductTypeAttributeI18n->saveall(array('ProductTypeAttributeI18n'=>$p_I18n_info));//更新多语言
            }			
			
			
			$this->flash('编辑成功','/productstypes/look/'.$_POST['back_id'],'');
			
			//pr($this->data);
		}
		
		$this->ProductTypeAttribute->set_locale($this->locale);
		$attribute = $this->ProductTypeAttribute->findById( $id );
		$attribute['ProductTypeAttribute']['name'] = "";
		$attribute['ProductTypeAttribute']['namess'] = "";
		$attribute['ProductTypeAttribute']['names'] = "";
		$datas = $this->ProductType->findById( $attribute['ProductTypeAttribute']['product_type_id'] );
		$dataes = $this->ProductType->findAll();
		$s = "";
		foreach( $dataes as $k=>$v ){
			foreach( $v["ProductTypeI18n"] as $kk=>$vv ){
				$s= $vv['name'];
			}
			$ss[$v['ProductType']['id']] = $s;
			$s = "";
		}
		$attribute['ProductTypeAttribute']['names'] = $ss;
		foreach($datas['ProductTypeI18n'] as $kkk=>$vvv){
			$attribute['ProductTypeAttribute']['name'].= $vvv['name']."|";
		}
		$i18n = $this->ProductTypeAttributeI18n->findallByproduct_type_attribute_id( $id );
	//	pr($i18n);
		foreach($i18n as $kkkk=>$vvvv){
			$attribute['ProductTypeAttribute']['namess'].= $vvvv['ProductTypeAttributeI18n']['name']."|";
			$attribute['ProductTypeAttributeI18n'][$vvvv['ProductTypeAttributeI18n']['locale']] = $vvvv['ProductTypeAttributeI18n'];
		}
		$this->set("attribute",$attribute);
		$this->set("ids",$ids);
	}
	
	function lookadd($id){
		$this->pageTitle = "编辑属性 - 属性管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'属性管理','url'=>'/productstypes/look/');
		$this->navigations[] = array('name'=>'编辑属性','url'=>'');
		$this->set('navigations',$this->navigations);
//		$this->ProductTypeAttribute->hasOne = array();
		if($this->RequestHandler->isPost()){
			$this->data['ProductTypeAttribute']['orderby'] = !empty($this->data['ProductTypeAttribute']['orderby'])?$this->data['ProductTypeAttribute']['orderby']:50;
			$this->ProductTypeAttribute->save($this->data['ProductTypeAttribute']);
			$pid = $this->ProductTypeAttribute->id;
			foreach($this->data['ProductTypeAttributeI18n'] as $v){
              	     $p_I18n_info=array(
		                           'id'				=>	'',
		                           'locale'			=>	$v['locale'],
		                           'product_type_attribute_id'		=> 	$pid,
		                           'name'	=> 	$v['name']
		              );
		             
		        $this->ProductTypeAttributeI18n->saveall(array('ProductTypeAttributeI18n'=>$p_I18n_info));//更新多语言
            }					
			$this->flash('编辑成功','/productstypes/look/'.$_POST['back_id'],'');
			
		}
		
		
		$dataes = $this->ProductType->findAll();
		$s="";
		foreach( $dataes as $k=>$v ){
			foreach( $v["ProductTypeI18n"] as $kk=>$vv ){
				if($vv['locale'] == $this->locale){
					$s= $vv['name'];
				}
			}
			$ss[$v['ProductType']['id']] = $s;
			$s = "";
		}
		$this->set("ss",$ss);
		$this->set("id",$id);
	}
	function remove($id){
		/*判断权限*/
		$this->operator_privilege('goods_type_view');
		/*end*/
		$this->ProductType->deleteAll("ProductType.id='".$id."'");
		$this->flash('删除成功','/productstypes',5);
	}
	function lookremove($id,$ids){
		$this->ProductTypeAttribute->deleteAll("ProductTypeAttribute.id='".$id."'");
		$this->flash('删除成功','/productstypes/look/'.$ids,5);
	}
}

?>