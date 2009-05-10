<?php
/*****************************************************************************
 * SV-Cart 支付
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: payment.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Payment extends AppModel
{
	var $name = 'Payment';
	var $hasOne = array('PaymentI18n'=>
						array('className'  => 'PaymentI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'payment_id'	
						)
					);
	
	
	function set_locale($locale){
    	$conditions = " PaymentI18n.locale = '".$locale."'";
    	$this->hasOne['PaymentI18n']['conditions'] = $conditions;
        
    }
    
    //数组结构调整
    function localeformat($id){
		$lists=$this->findAll("Payment.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Payment']=$v['Payment'];
				 $lists_formated['PaymentI18n'][]=$v['PaymentI18n'];
				 foreach($lists_formated['PaymentI18n'] as $key=>$val){
				 	  $lists_formated['PaymentI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
	
	function payment_list(){
		$payment_arr = $this->findAll();
		return $payment_arr;
	}
}
?>