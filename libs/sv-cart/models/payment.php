<?php
/*****************************************************************************
 * SV-Cart 支付方式
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
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