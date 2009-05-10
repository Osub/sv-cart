<?php
/*****************************************************************************
 * SV-Cart 订单商品
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: order_product.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class OrderProduct extends AppModel{
	var $name = 'OrderProduct';
	var $hasOne = array('Product' =>   
                        array('className'    => 'Product', 
                              'conditions'    =>  'Product.id = OrderProduct.product_id',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => ''  
                        )
                  );
    //订单中的虚拟商品
    function get_virtual_products($order_id){
    	
    	$virtual_products_list = $this->findAll(array("OrderProduct.order_id"=>$order_id,"OrderProduct.extension_code >"=>""));
    	$new_virtual_products_list  = array();
    	foreach( $virtual_products_list as $k=>$v ){
    		if($v['OrderProduct']['product_quntity']-$v['OrderProduct']['send_quntity']>0){
    			$new_virtual_products_list[$k] = $virtual_products_list[$k];
    			$new_virtual_products_list[$k]['OrderProduct']['num'] = $v['OrderProduct']['product_quntity']-$v['OrderProduct']['send_quntity'];
    		}
    	}
    	$virtual_products_lists = array();
    	foreach( $new_virtual_products_list as $k=>$v ){
    		$virtual_products_lists[$v['OrderProduct']['extension_code']][] = $v;
    	
    	}
    	return $virtual_products_lists;
    }
}
?>