<?php
/*****************************************************************************
 * SV-Cart ���͵���
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * �������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: shipping_area.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class ShippingArea extends AppModel
{
	var $name = 'ShippingArea';
	var $hasMany = array('ShippingAreaI18n'     =>array
												( 
												  'className'    => 'ShippingAreaI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'shipping_area_id'
					                        	 ) ,
		
                 	   );
    

}
?>