<?php
/*****************************************************************************
 * SV-Cart 我的订单
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: order.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Order extends AppModel
{
	var $name = 'Order';
	var $hasMany = array('OrderProduct' =>

                         array('className'     => 'OrderProduct',

                               'conditions'    => '',

                               'order'         => 'OrderProduct.product_id DESC',

                               'limit'         => '',

                               'foreignKey'    => 'order_id',

                               'dependent'     => true,

                               'exclusive'     => false,

                               'finderQuery'   => '',
                               	
                               'joinTable'=>'svcart_order_products'
                              


                         )

                  );
    function time_orders($start_time,$end_time){
    	    $start_time=(!isset($start_time))?date("Y-m-d H:m:s"):$start_time;
			$middle_time=(strtotime($start_time))-(30*24*60*60);
			$end_time=date("Y-m-d H:m:s",$middle_time);
			$condition=" Order.created >= '".$end_time."' and Order.created <= '".$start_time."' and Order.user_id='".$_SESSION['User']['User']['id']."'";
			$orders=$this->findCount($condition);
			return $orders;
    }
     function findassoc($orders_id){
		$condition = array("Order.id"=>$orders_id);
		
		$lists=$this->findAll($condition);
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['Order']['id']]=$v;
			}
		
		return $lists_formated;
	}

}
?>