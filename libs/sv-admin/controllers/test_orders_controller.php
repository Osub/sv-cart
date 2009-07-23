<?php
/*****************************************************************************
 * SV-Cart 订单管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: test_orders_controller.php 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
class OrdersController extends AppController
{
	var $name='Orders';
	var $components=array('Pagination','RequestHandler','Email');
	var $helpers=array('Pagination');
	var $uses=array('Order','Config','UnionUser','UnionReffererOrder');
	//添加网站联盟订单提成
	function add_union_refferer_orders($order_id){
		$this->Order->bindModel(array(
						'belongsTo' => array( 'UnionUser' =>
	                        array('className'    => 'UnionUser',
	                              'order'        => '',
	                              'dependent'    =>  true,
	                              'foreignKey'   => 'union_user_id'
	                        )
	    				),
						'hasOne' => array('UnionReffererOrder' =>   
	                        array('className'    => 'UnionReffererOrder', 
	                        	'conditions'    =>  '',  
	                              'order'        => '',   
	                              'dependent'    =>  true,   
	                              'foreignKey'   => 'order_id'  
	                     	)
       					)
        				));
        //pr($this->UnionReffererOrder->findAll());
        //pr($this->Order);
		$order = $this->Order->findById($order_id);
	//	pr($order);exit;
		
		if(!empty($order) && $order['Order']['shipping_status']==2 && $order['Order']['union_user_id'] && $order['Order']['payment_status']==2){//判断订单状态是否为收货确认，是否通过加盟店下的单
			$union_user = $this->UnionUser->findbyid($order['Order']['union_user_id']);
			if($union_user){//判断是否存在该加盟店id，是否有效
				$union_refferer_order = $this->UnionReffererOrder->find("UnionReffererOrder.union_user_id=" . $order['Order']['union_user_id']." and UnionReffererOrder.order_id=".$order_id);
				if($union_refferer_order){//判断改订单的提成是否已经存在
					return false;
				}
				else {
				    $this->Config->set_locale($this->locale);
				   	$tax = $this->configs['union_tax_percent'];//税率
					$union_rebate_percent = $this->UnionUser->findbyid($order['Order']['union_user_id']);//提成率
					$rebate = $union_rebate_percent['UnionUser']['rebate_percent'];
					$commission = $order['Order']['total']*$rebate/100*(1-$tax/100);//提成后所得
					$tax = $order['Order']['total'] * $tax/100;//税费
					$rebate = $order['Order']['total']*$rebate/100;//未扣税的提成金额
					$add_refferer_order = array(
						'id' => '',
				        'union_user_id' => $order['Order']['union_user_id'],
				        'order_id' => $order['Order']['id'],
				        'amount' => $order['Order']['total'],
				        'rebate' => $rebate,
				        'tax' => $tax,
				        'commission' => $commission,
				        'created '=> date('Y-m-d H:i:s'),
				   		'modified '=> date('Y-m-d H:i:s')
				     );
				    $commission = $union_user['UnionUser']['rebate_balance'] + $commission;
			        $this->UnionReffererOrder->save(array('UnionReffererOrder'=>$add_refferer_order));
			        $this->UnionUser->save(array('id'=>$order['Order']['union_user_id'],'rebate_balance'=> $commission));
					return true;
				}
			}
		}
		return false;
	}
	
}
?>