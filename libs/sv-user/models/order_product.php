<?php
/*****************************************************************************
 * SV-Cart 已购买信息
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: order_product.php 945 2009-04-23 11:34:23Z tangyu $
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