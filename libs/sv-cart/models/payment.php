<?php
/*****************************************************************************
 * SV-Cart ֧����ʽ
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: payment.php 2952 2009-07-16 09:56:25Z huangbo $
*****************************************************************************/
class Payment extends AppModel
{
	var $name = 'Payment';
	var $hasOne = array('PaymentI18n'     =>array
												( 
												  'className'    => 'PaymentI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'payment_id'
					                        	 ) 
                 	   );
    
    
    function set_locale($locale){
    	$conditions = " PaymentI18n.locale = '".$locale."'";
    	$this->hasOne['PaymentI18n']['conditions'] = $conditions;
        
    }
    
 	function availables(){
	    $payments = $this->find('all',array('order'=>array('Payment.orderby asc'),
	    'conditions'=>array('Payment.status'=>1,'Payment.order_use_flag'=>1,'PaymentI18n.status'=>1),
	    'fields'=>array('Payment.id','Payment.code','PaymentI18n.status','Payment.fee','Payment.is_cod','Payment.is_online','Payment.supply_use_flag','Payment.order_use_flag'
	    ,'PaymentI18n.name','PaymentI18n.description'
	    )));
	    
	    return $payments;
	    //return $this->findall(" Payment.status = '1' and Payment.order_use_flag = '1' and PaymentI18n.status = '1'",'','Payment.orderby asc');
 	}
}
?>