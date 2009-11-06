<?php
/*****************************************************************************
 * SV-Cart 配送地区
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: shipping_area.php 3133 2009-07-21 06:37:32Z huangbo $
*****************************************************************************/
class ShippingArea extends AppModel
{
	var $name = 'ShippingArea';

 	function fee_calculation_other($weight,$info,$subtotal){
 		$fee = 0;
 		if($subtotal < $info['free_subtotal'] || $info['free_subtotal'] == 0){
 			$fee_areas=explode(";",$info['fee_configures']);
 			foreach($fee_areas as $k=> $v){
 				$weight_fees=explode(":",$v);
 				if(is_array($weight_fees) && $weight_fees[0]>=0 && isset($weight_fees[1]))
 					$weight_fee_areas[$weight_fees[0]]=$weight_fees[1];
 			}
 		}
 			
 		if(isset($weight_fee_areas)){
	 		ksort($weight_fee_areas);
	 		foreach($weight_fee_areas as $k => $v){
	 			if($weight > $k){
	 				$fee = $v;
	 			}
	 		}
 		}
 		if($fee == ""){
 			$fee = 0;
 		}
 		
 		return $fee;
 	}
 	 function fee_calculation($weight,$info,$subtotal){
 		$fee_info = @unserialize(StripSlashes($info['fee_configures']));
 		$fee = 0;
 		if($subtotal < $info['free_subtotal'] || $info['free_subtotal'] == 0){
			if($weight <= 1000 && isset($fee_info['0']['value'])){
				return $fee_info['0']['value'];
			}else if($weight <= 5000  && isset($fee_info['0']['value'])  && isset($fee_info['1']['value'])){
				$other_fee =  ceil(($weight-1000)/500)*$fee_info['1']['value'];
				return $fee_info['0']['value']+$other_fee;
			}else if(isset($fee_info['0']['value']) && isset($fee_info['2']['value'])){
				$other_fee =  ceil(($weight-1000)/500)*$fee_info['2']['value'];
				return $fee_info['0']['value']+$other_fee;
			}
 		}
 		return $fee;
 	}
 	
}
?>