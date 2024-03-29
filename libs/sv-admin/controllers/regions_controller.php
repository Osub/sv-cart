<?php
/*****************************************************************************
 * SV-Cart 区域控制
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: regions_controller.php 1861 2009-05-31 09:38:18Z zhengli $
*****************************************************************************/
class RegionsController extends AppController {
	var $name = 'Regions';
	var $helpers = array('Html','Form');
	var $components = array('RequestHandler');
	
	var $uses = array('RegionI18n','Region','VirtualCard','Shipping','Order','OrderProduct','UserAddress','Payment','Shipping','OrderProduct','User','Product','OrderAction','Category','Brand','ProductAttribute','ProductTypeAttribute','UserBalanceLog','ShippingArea','MailTemplate','UserConfig','UserPointLog','UserBalanceLog');//,'UserPointLog','PaymentApiLog','User'


	function choice(){
		
//		if($this->RequestHandler->isPost()){
			$this->Region->set_locale($this->locale);
			$regions = $this->Region->find("threaded");
//			pr($regions);
			$str = "";
			if(isset($_POST['str'])){
				$str = $_POST['str'];
			}
			$this->children($regions,$str);
			for($i=0;$i<4;$i++){
				if(isset($this->regions_selects) && sizeof($this->regions_selects)>0 && isset($this->regions_selects[sizeof($this->regions_selects)-1])){
					if(isset($this->regions_selects[sizeof($this->regions_selects)-1]['select']) && sizeof($this->regions_selects[sizeof($this->regions_selects)-1]['select']) ==2){
						foreach($this->regions_selects[sizeof($this->regions_selects)-1]['select'] as $a=>$b){
							if($a != $this->languages['please_choose']){
								$str .= " ".$a;
								$this->regions_selects = array();
								$this->children($regions,$str);
							}
						}
					}
				}
			}			
			$this->set('regions_selects',$this->regions_selects);
			if(isset($_POST['address_id'])){
				$this->set('address_id',$_POST['address_id']);
			}
//			pr($this->regions_selects);
//		}
Configure::write('debug',0);
		$this->layout="ajax";
 	}
 	
 	function children($tree,$str){
 		$region_id_array=explode(" ",trim($str));
 		$region_str = "";
 	//	pr($region_id_array);
 		if(sizeof($region_id_array)>0){
	 		foreach($region_id_array as $k=>$v){
	 			$region_info = $this->Region->findbyid($v);
	 			if($k < sizeof($region_id_array)-1){
	 			$region_str .= $region_info['Region']['id']." ";
	 			}else{
	 			$region_str .= $region_info['Region']['id'];
	 			}
	 		}
 		}
 		$region_array = explode(" ",trim($region_str));
 		$deep=sizeof($region_array);
// 		pr($region_array);
		$select['default']=$region_array[0];
		foreach($tree as $k=>$v){
		//	$select['select'][$v['RegionI18n']['region_id']]=$v['RegionI18n']['name'];
		    $select['select']['请选择']= "请选择";
			$select['select'][$v['Region']['id']]=$v['RegionI18n']['name'];
		//	$select['select'][$v['RegionI18n']['name']]=$v['RegionI18n']['name'];
		
		//	if($region_array[0]==$v['RegionI18n']['name'] && isset($v['children'])){
			if($region_array[0]==$v['Region']['id'] && isset($v['children'])){
				$subtree = $v['children'];
			}
 		}
 		Configure::write('debug',0);
 		$this->regions_selects[]=$select;
 		if($deep >= 1 && isset($subtree) && sizeof($subtree)){
			$this->children($subtree,implode(" ",array_slice($region_array,1)));
 		}
 	}

 	function twochoice(){
//		if($this->RequestHandler->isPost()){
			$this->Region->set_locale($this->locale);
			$regions = $this->Region->find("threaded");
			$str = "";
			if(isset($_POST['str'])){
				$str = $_POST['str'];
			}	
			$this->children($regions,$str);
			for($i=0;$i<4;$i++){
				if(isset($this->regions_selects) && sizeof($this->regions_selects)>0 && isset($this->regions_selects[sizeof($this->regions_selects)-1])){
					if(isset($this->regions_selects[sizeof($this->regions_selects)-1]['select']) && sizeof($this->regions_selects[sizeof($this->regions_selects)-1]['select']) ==2){
						foreach($this->regions_selects[sizeof($this->regions_selects)-1]['select'] as $a=>$b){
							if($a != $this->languages['please_choose']){
								$str .= " ".$a;
								$this->regions_selects = array();
								$this->children($regions,$str);
							}
						}
					}
				}
			}			
			$this->set('regions_selects',$this->regions_selects);
			if(isset($_POST['updateaddress_id'])){
				$this->set('updateaddress_id',$_POST['updateaddress_id']);
			}
	//		pr($this->regions_selects);
//		}
		Configure::write('debug',0);
		$this->layout="ajax";
 	}

}

?>