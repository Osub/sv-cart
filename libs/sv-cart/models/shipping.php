<?php
/*****************************************************************************
 * SV-Cart 配送方式
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: shipping.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Shipping extends AppModel
{
	var $name = 'Shipping';
	var $hasOne = array('ShippingI18n'     =>array(
												  'className'    => 'ShippingI18n', 
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'shipping_id'
					                        	 ) 
                 	   );
    
    function set_locale($locale){
    	$conditions = " ShippingI18n.locale = '".$locale."'";
    	$this->hasOne['ShippingI18n']['conditions'] = $conditions;
    }
    
    function availables(){
    	$lists=$this->findall("Shipping.status = '1' ",'','Shipping.orderby asc');
    	foreach($lists as $k => $v){
    		$lists[$k]['Shipping']['fee']=0;
    		
    	}
	    return $lists;
 	}
}
?>