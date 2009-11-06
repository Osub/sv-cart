<?php
/*****************************************************************************
 * SV-Cart �ҵĶ���
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: order.php 3673 2009-08-17 09:57:45Z huangbo $
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
			$condition=" Order.created >= '".$end_time."' and Order.created <= '".$start_time."' and Order.user_id=".$_SESSION['User']['User']['id'];
			$orders=$this->findCount($condition);
			return $orders;
    }
    
    function new_orders($start_time,$end_time){
			$condition="Order.user_id=".$_SESSION['User']['User']['id'];
			$orders=$this->find('all',array('conditions'=>$condition,'order'=>'Order.created DESC','recursive' => -1,'fields'=>array('Order.id','Order.order_code','Order.status','Order.payment_status','Order.shipping_status'),'limit'=>4));
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