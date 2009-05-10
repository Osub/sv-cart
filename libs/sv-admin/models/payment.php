<?php
/*****************************************************************************
 * SV-Cart ֧��
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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
    
    //����ṹ����
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