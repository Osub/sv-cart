<?php
/*****************************************************************************
 * SV-Cart 商品
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: product.php 1141 2009-04-29 11:28:49Z zhengli $
*****************************************************************************/
class ProductAttribute extends AppModel
{
	var $name = 'ProductAttribute';
	var $hasOne = array('ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 ) ,
					   		
					   		'ProviderProduct' =>array
												(
										          'className'     => 'ProviderProduct',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	),
							
                 	   );




}
?>