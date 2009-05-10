<?php
/*****************************************************************************
 * SV-Cart ���ͷ�ʽ
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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