<?php
/*****************************************************************************
 * SV-Cart ���͵���
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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