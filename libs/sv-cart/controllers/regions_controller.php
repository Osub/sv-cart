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
 * $Id: regions_controller.php 1028 2009-04-24 12:23:26Z huangbo $
*****************************************************************************/
class RegionsController extends AppController {
	var $name = 'Regions';
	var $helpers = array('Html','Form');
	var $components = array('RequestHandler');
	
	var $regions_selects =array();

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
			$this->set('regions_selects',$this->regions_selects);
			if(isset($_POST['address_id'])){
				$this->set('address_id',$_POST['address_id']);
			}
//			pr($this->regions_selects);
//		}
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
		    $select['select']['请选择']= $this->languages['please_choose'];
			$select['select'][$v['Region']['id']]=$v['RegionI18n']['name'];
		//	$select['select'][$v['RegionI18n']['name']]=$v['RegionI18n']['name'];
		
		//	if($region_array[0]==$v['RegionI18n']['name'] && isset($v['children'])){
			if($region_array[0]==$v['Region']['id'] && isset($v['children'])){
				$subtree = $v['children'];
			}
 		}
 		$this->regions_selects[]=$select;
 		if($deep >= 1 && isset($subtree) && sizeof($subtree)){
			$this->children($subtree,implode(" ",array_slice($region_array,1)));
 		}
 	}

 	function twochoice(){
//		if($this->RequestHandler->isPost()){
			$this->Region->set_locale($this->locale);
			$regions = $this->Region->find("threaded");
	//		pr($regions);
			$this->children($regions,$_POST['str']);
			$this->set('regions_selects',$this->regions_selects);
			if(isset($_POST['updateaddress_id'])){
				$this->set('updateaddress_id',$_POST['updateaddress_id']);
			}
	//		pr($this->regions_selects);
//		}
		$this->layout="ajax";
 	}
 	
 

}

?>