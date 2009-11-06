<?php
/*****************************************************************************
 * SV-Cart 货币管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: categories_controller.php 3399 2009-07-30 03:50:54Z shenyunfeng $
*****************************************************************************/
class CurrenciesController extends AppController {
	var $name = 'Currencies';
	var $helpers = array('Html');
	var $uses = array("Currency","CurrencyI18n");
	var $components = array('RequestHandler');
 
 	function index(){
        $this->pageTitle = "货币管理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'功能管理','url'=>'');
        $this->navigations[] = array('name' => '货币管理','url' => '/currencies/');
        $this->set('navigations',$this->navigations);
        $this->Currency->set_locale($this->locale);
		$currency_list = $this->Currency->find("all");
		//pr($currency_list);
		$this->set("currency_list",$currency_list);
	}
	function add(){
        $this->pageTitle = "货币管理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'功能管理','url'=>'');
        $this->navigations[] = array('name' => '货币管理','url' => '/currencies/');
        $this->navigations[] = array('name' => '新增货币','url' => '/');
        $this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->Currency->saveAll(array("Currency"=>$this->data["Currency"]));
			foreach( $this->data["CurrencyI18n"] as $k=>$v ){
				$v["currency_id"] = $this->Currency->getLastInsertId();
				$this->CurrencyI18n->saveAll(array("CurrencyI18n"=>$v));
				if($v["locale"] == $this->locale){
					$thisname = $v["name"];
				}
			}

			$this->flash("货币 ".$thisname." 添加成功，点击这里继续编辑该货币。",'/currencies/edit/'.$this->Currency->getLastInsertId(),10);
		}
	}
	
	function edit($id){
        $this->pageTitle = "货币管理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'功能管理','url'=>'');
        $this->navigations[] = array('name' => '货币管理','url' => '/currencies/');
        $this->navigations[] = array('name' => '编辑货币','url' => '/');
        $this->set('navigations',$this->navigations);
		
		if($this->RequestHandler->isPost()){
			$this->Currency->save(array("Currency"=>$this->data["Currency"]));
			foreach( $this->data["CurrencyI18n"] as $k=>$v ){
				$this->CurrencyI18n->save(array("CurrencyI18n"=>$v));
				if($v["locale"] == $this->locale){
					$thisname = $v["name"];
				}
			}
			$this->flash("货币 ".$thisname." 编辑成功，点击这里继续编辑该货币。",'/currencies/edit/'.$this->data['Currency']['id'],10);
		}
		$currency_info = $this->Currency->localeformat($id);

		$this->set("currency_info",$currency_info);
		
	}
	function remove($id){
		$this->Currency->del($id);
		die();
	}
} 

?>