<?php
/*****************************************************************************
 * SV-Cart 订单商品管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: order_product_controller.php 786 2009-04-18 15:38:32Z huangbo $
*****************************************************************************/
class OrderProductController extends AppController {
	var $name = 'OrderProduct';
	var $helpers = array('Html');
	var $uses = array('OrderProduct','Product');

	function index(){
	}
	//更新状态改变商品库存
	function change_order_products_storage($order_id, $is_dec = true){
	     $res=$this->OrderProduct->findAll("OrderProduct.order = '".$order_id."'");
	               foreach($res as $k=>$v){
                                     $product_info=$this->Product->findbyid($v['OrderProduct']['product_id']);
                                     //修改商品库存
                                     if($is_dec){
    	   	                               $product=array(
		                                          'id'=> $v['OrderProduct']['product_id'],
		                                          'quantity'=>$product_info['Product']['quantity']-$v['OrderProduct']['product_quntity']
		                                   );
		                             }
		                             else{
		                             	   $product=array(
		                                          'id'=> $v['OrderProduct']['product_id'],
		                                          'quantity'=>$product_info['Product']['quantity']+$v['OrderProduct']['product_quntity']
		                                   );
		                             }
		                             $this->Product->save(array('Product'=>$product));
                  }
	
}

?>