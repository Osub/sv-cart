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
 * $Id: payment.php 1283 2009-05-10 13:48:29Z huangbo $
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
	    return $this->findall(" Payment.status = '1' and Payment.order_use_flag = '1' and PaymentI18n.status = '1'",'','Payment.orderby asc');
 	}
}
?>