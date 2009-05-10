<?php
/*****************************************************************************
 * SV-Cart ������Ʒ
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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
    //�����е�������Ʒ
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