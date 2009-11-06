<?php
/*****************************************************************************
 * SV-Cart 发票类型管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: votes_controller.php 3636 2009-08-14 09:26:56Z huangbo $
*****************************************************************************/
class InvoiceTypesController extends AppController {

	var $name = 'InvoiceTypes';
    var $components = array ('Pagination','RequestHandler');
    var $helpers = array('Pagination');
	var $uses = array("InvoiceType","InvoiceTypeI18n");
	
	function index(){
		/*判断权限*/
		$this->operator_privilege('invoice_type_view');
		/*end*/
	   	$this->pageTitle = "发票类型管理" ." - ".$this->configs['shop_name'];
	   	$this->navigations[] = array('name'=>'系统管理','url'=>'');
		$this->navigations[] = array('name'=>'发票类型管理','url'=>'/invoice_types/');
		$this->set('navigations',$this->navigations);
		$this->InvoiceType->set_locale($this->locale);
		$invoice_type_data = $this->InvoiceType->find("all");
		$this->set("invoice_type_data",$invoice_type_data);
	}
	
	function add(){
		/*判断权限*/
		$this->operator_privilege('invoice_type_edit_view');
		/*end*/
	   	$this->pageTitle = "发票类型管理" ." - ".$this->configs['shop_name'];
	   	$this->navigations[] = array('name'=>'系统管理','url'=>'');
		$this->navigations[] = array('name'=>'发票类型管理','url'=>'/invoice_types/');
		$this->navigations[] = array('name'=>'新增发票类型','url'=>'/invoice_types/');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->InvoiceType->saveAll(array("InvoiceType"=>$this->data["InvoiceType"]));
			foreach( $this->data["InvoiceTypeI18n"] as $k=>$v ){
				$v["invoice_type_id"] = $this->InvoiceType->getLastInsertId();
				$this->InvoiceTypeI18n->saveAll(array("InvoiceTypeI18n"=>$v));
				if($v["locale"] == $this->locale){
					$thisname = $v["name"];
				}
			}

			$this->flash("发票类型 ".$thisname." 添加成功，点击这里继续编辑该发票类型。",'/invoice_types/edit/'.$this->InvoiceType->getLastInsertId(),10);
		}

	
	}
	function edit($id){
		/*判断权限*/
		$this->operator_privilege('invoice_type_edit_view');
		/*end*/
	   	$this->pageTitle = "发票类型管理" ." - ".$this->configs['shop_name'];
	   	$this->navigations[] = array('name'=>'系统管理','url'=>'');
		$this->navigations[] = array('name'=>'发票类型管理','url'=>'/invoice_types/');
		$this->navigations[] = array('name'=>'编辑发票类型','url'=>'/invoice_types/');

		if($this->RequestHandler->isPost()){
			$this->InvoiceType->saveAll(array("InvoiceType"=>$this->data["InvoiceType"]));
			foreach( $this->data["InvoiceTypeI18n"] as $k=>$v ){
				$v["invoice_type_id"] = $id;
				$this->InvoiceTypeI18n->saveAll(array("InvoiceTypeI18n"=>$v));
				if($v["locale"] == $this->locale){
					$thisname = $v["name"];
				}
			}

			$this->flash("发票类型 ".$thisname." 编辑成功，点击这里继续编辑该发票类型。",'/invoice_types/edit/'.$id,10);
		}
		$invoice_type_data = $this->InvoiceType->localeformat($id);
		foreach($invoice_type_data["InvoiceTypeI18n"] as $k=>$v){
			if( $v["locale"] == $this->locale){
				$thisname = $v["name"];
			}
		}
		$this->navigations[] = array('name'=>$thisname,'url'=>'');
		$this->set('navigations',$this->navigations);
		
		$this->set('invoice_type_data',$invoice_type_data);
	}
}

?>