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
 * $Id: shipping_area.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class ShippingArea extends AppModel
{
	var $name = 'ShippingArea';

 	function fee_calculation($weight,$info,$subtotal){
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
 		return $fee;
 	}
 	
 	
}
?>