<?php
/*****************************************************************************
 * SV-Cart �ѹ�����Ϣ
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * �������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: order_product.php 946 2009-04-24 00:36:19Z huangbo $
*****************************************************************************/
class OrderProduct extends AppModel
{
	var $name = 'OrderProduct';
	var $hasOne = array('Product' =>array
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