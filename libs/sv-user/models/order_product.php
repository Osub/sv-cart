<?php
/*****************************************************************************
 * SV-Cart �ѹ�����Ϣ
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: order_product.php 3428 2009-07-31 11:48:18Z huangbo $
*****************************************************************************/
class OrderProduct extends AppModel
{
	var $name = 'OrderProduct';
		var $hasOne = array(
		'Product' =>array 
							(
							  'className'     => 'Product',   
			                                      'conditions'   => 'Product.id=OrderProduct.product_id',
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => ''
					       	),
			      'ProductI18n' =>array
							(
							  'className'     => 'ProductI18n',   
			                                      'conditions'   => 'ProductI18n.product_id=OrderProduct.product_id',
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => ''
					       	)
				);

    }
?>