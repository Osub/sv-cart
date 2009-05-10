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