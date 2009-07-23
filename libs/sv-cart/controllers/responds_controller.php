<?php
/*****************************************************************************
 * SV-Cart 支付响应页面
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: responds_controller.php 2952 2009-07-16 09:56:25Z huangbo $
*****************************************************************************/
class RespondsController extends AppController {
	var $name = 'Responds';
	var $helpers = array('Html','Flash');
	var $uses = array('Product','Flash','Payment','Order','UserBalanceLog','UserPointLog','PaymentApiLog','User','UserAccount','OrderProduct','Coupon','CouponType');
	
	function index($code){
		$this->pageTitle = $this->languages['payment_result']." - ".$this->configs['shop_title'];
		/* start */
		$pay = $this->Payment->findbycode($code);
		eval($pay['Payment']['php_code']);  
		$str = "\$pay_class = new ".$pay['Payment']['code']."();";
		eval($str);	
		
		if($pay_class->respond($this)){
			$msg = $this->languages['successfully'];
		}else{
			$fail = 1;
			$msg = $this->languages['failed'];
			$this->set('fail',$fail);
		}
		
		$this->set('msg',$msg);
		$this->set('languages',$this->locale);
		$this->page_init();
		$this->set('categories_tree',$categories_tree = array());
		$this->set('brands',$brands = array());
		$this->layout = 'default_full';
	}
	
	function update_balance($payment_log,$account){
			   $payment_log['PaymentApiLog']['is_paid'] = '1';
			   $this->PaymentApiLog->save($payment_log);
			   
			   $balance_log = array(
			   						"id"=>'',
			   						"user_id"=>$account['UserAccount']['user_id'],
			   						"amount"=>$account['UserAccount']['amount'],
			   						"log_type" => "B",
			   						"system_note" => "用户充值",
			   						"type_id"=>$payment_log['PaymentApiLog']['type_id']
			   						);
			   $this->UserBalanceLog->save($balance_log);
			
			   $user_info = $this->User->findbyid($account['UserAccount']['user_id']);
			   $user_info['User']['balance'] += $account['UserAccount']['amount'];
			   $this->User->save($user_info);
			   $account['UserAccount']['paid_time'] = date("Y-m-d H:i:s");
		       $account['UserAccount']['status'] = 1;
			   $this->UserAccount->save($account);
	}
	
	
	function update_order($payment_log,$order_total){
            /* 改变订单状态 */
			$payment_log['PaymentApiLog']['is_paid'] = '1';
			$order_total['Order']['payment_status'] = '2';
			$order_total['Order']['money_paid'] = $c_orderamount;
			$order_total['Order']['payment_time'] = date("Y-m-d H:i:s");
			$this->PaymentApiLog->save($payment_log);
			$this->Order->save($order_total);
			// 超过订单金额赠送积分
			if($this->configs['order_smallest'] <= $order_total['Order']['subtotal'] && $this->configs['out_order_points']>0){
				$user_info = $this->User->findbyid($order_total['Order']['user_id']);
				$user_info['User']['point'] += $this->configs['out_order_points'];
				$user_info['User']['user_point'] +=$this->configs['out_order_points'];
				$this->User->save($user_info);
				$point_log = array(	"id"=>"",
									"user_id" => $order_total['Order']['user_id'],
									"point" => $this->configs['out_order_points'],
									"log_type" => "B",
									"system_note" => "超过订单金额 ".$this->configs['order_smallest']." 赠送积分",
									"type_id" => $order_total['Order']['id']
									);
				$this->UserPointLog->save($point_log);
			}
						//下单是否送积分
			if($this->configs['order_gift_points'] == 1 && $this->configs['order_points']){
				$user_info = $this->User->findbyid($order_total['Order']['user_id']);
				$user_info['User']['point'] += $this->configs['order_points'];
				$user_info['User']['user_point'] +=$this->configs['order_points'];
				$this->User->save($user_info);
				$point_log = array("id"=>"",
									"user_id" => $order_total['Order']['user_id'],
									"point" => $this->configs['order_points'],
									"log_type" => "B",
									"system_note" => "下单送积分",
									"type_id" => $order_total['Order']['id']
									);
				$this->UserPointLog->save($point_log);
			} 
			// 商品送积分

			$product_ids = $this->OrderProduct->findbyorder_id($order_total['Order']['id']);
            $product_point = array();
			$send_coupon = array();
            foreach($product_ids as $k=>$v){
            	$product = $this->Product->findbyid($v['OrderProduct']['product_id']);
				$product_point[$k] = array(
											'point' => $product['Product']['point']*$v['OrderProduct']['product_quntity'],
											'name' => $product['ProductI18n']['name']
											);            	
				if($product['Product']['coupon_type_id'] > 0){
					$send_coupon[] = $product['Product']['coupon_type_id'];
            	}
            }
            
	        if(is_array($product_point) && sizeof($product_point)>0){
	           	foreach($product_point as $k=>$v){
	           		if($v['point'] > 0){
						$user_info = $this->User->findbyid($order_total['Order']['user_id']);
						$user_info['User']['point'] += $v['point'];
						$user_info['User']['user_point'] += $v['point'];

						$this->User->save($user_info);
						$point_log = array("id"=>"",
											"user_id" => $order_total['Order']['user_id'],
											"point" => $v['point'],
											"log_type" => "B",
											"system_note" => "商品 ".$v['name']." 送积分",
											"type_id" => $order_total['Order']['id']
											);
						$this->UserPointLog->save($point_log);
					}
				}
            }
//coupon            
	            //是否送优惠券
	            if(isset($this->configs['send_coupons']) && $this->configs['send_coupons'] == 1){
	          	 	$this->CouponType->set_locale($this->locale);
	            	$order_coupon_type = $this->CouponType->findall("CouponType.send_type = 2 and CouponType.send_start_date <= '".$now."' and CouponType.send_end_date >= '".$now."'");
	            	if(is_array($order_coupon_type) && sizeof($order_coupon_type)>0){
			//	$coupon_arr = $this->Coupon->findall("1=1",'DISTINCT Coupon.sn_code');
				$coupon_arr_list = $this->Coupon->find('list',array('conditions'=>array("1=1"),'fields' => array('Coupon.sn_code')));
				$coupon_arr = array();
				if(is_array($coupon_arr_list) && sizeof($coupon_arr_list)>0){
					foreach($coupon_arr_list as $k=>$v){
						$coupon_arr[] = $v;
					}
				}
						$coupon_count = count($coupon_arr);
						$num = 0;
						if($coupon_count > 0){
							$num = $coupon_arr[$coupon_count - 1];
						}         		
	            		
	            		foreach($order_coupon_type as $k=>$v){
	            			if($v['CouponType']['min_products_amount'] < $order_total['Order']['subtotal']){
		            			if(isset($coupon_sn)){
									$num = $coupon_sn;
								}
								
								$num = substr($num,2, 10);
								$num = $num ? floor($num / 10000) : 100000;
								$coupon_sn = $v['CouponType']['prefix'].$num.str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);	   
		            			$order_coupon = array(
		            								'id' => '',
		            								'coupon_type_id' => $v['CouponType']['id'],
		            								'user_id' => $order_total['Order']['user_id'],
		            								'sn_code' => $coupon_sn
		            								);
		            			$this->Coupon->save($order_coupon);
	            			}
	            		}
	            	}// order send end
	            	
	            	if(is_array($send_coupon) && sizeof($send_coupon)>0){
			//	$coupon_arr = $this->Coupon->findall("1=1",'DISTINCT Coupon.sn_code');
				$coupon_arr_list = $this->Coupon->find('list',array('conditions'=>array("1=1"),'fields' => array('Coupon.sn_code')));
				$coupon_arr = array();
				if(is_array($coupon_arr_list) && sizeof($coupon_arr_list)>0){
					foreach($coupon_arr_list as $k=>$v){
						$coupon_arr[] = $v;
					}
				}
						$coupon_count = count($coupon_arr);
						$num = 0;
						if($coupon_count > 0){
							$num = $coupon_arr[$coupon_count - 1];
						}
	            		foreach($send_coupon as $type_id){
	            			if(isset($coupon_sn)){
								$num = $coupon_sn;
							}
	            			$pro_coupon_type = $this->CouponType->findbyid($type_id);
							$num = substr($num,2, 10);
							$num = $num ? floor($num / 10000) : 100000;
							$coupon_sn = $pro_coupon_type['CouponType']['prefix'].$num.str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);	   
	            			$pro_coupon = array(
	            								'id' => '',
	            								'coupon_type_id' => $pro_coupon_type['CouponType']['id'],
	            								'user_id' => $order_total['Order']['user_id'],
	            								'sn_code' => $coupon_sn
	            								);
	            			$this->Coupon->save($pro_coupon);
	            		}
	            	}
	            }  	
	
	
	
	}
	
	
	
}
?>