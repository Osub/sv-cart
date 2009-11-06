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
 * $Id: responds_controller.php 5527 2009-11-05 02:07:24Z huangbo $
*****************************************************************************/
class RespondsController extends AppController {
	var $name = 'Responds';
	var $helpers = array('Html','Flash');
	var $uses = array('Product','Flash','Payment','Order','ProductAlsobought','UserBalanceLog','UserPointLog','PaymentApiLog','User','UserAccount','OrderProduct','Coupon','CouponType','OrderAction','VirtualCard','MailTemplate','MailSendQueue');
	var $components = array('RequestHandler','Email');
	
	function index($code){
		$this->pageTitle = $this->languages['payment_result']." - ".$this->configs['shop_title'];
		/* start */
		$pay = $this->Payment->findbycode($code);
		eval($pay['Payment']['php_code']);  
		$str = "\$pay_class = new ".$pay['Payment']['code']."();";
		eval($str);	
		
		if($code == "moneybookers"){
			if(isset($_GET['status']) && $_GET['status'] == md5("ok".$_GET['oid']) && isset($_GET['oid'])){
        		$payment_log = $this->PaymentApiLog->findbyid($_GET['oid']);
			    $order_total = $this->Order->findbyid($payment_log['PaymentApiLog']['type_id']);
				if($payment_log['PaymentApiLog']['type'] > 0){
					$account = $this->UserAccount->findbyid($payment_log['PaymentApiLog']['type_id']);
					$this->update_balance($payment_log,$account);        			           
				}
				if($payment_log['PaymentApiLog']['type'] < 1){
       				$order_total = $db->Order->findbyid($payment_log['PaymentApiLog']['type_id']);
       				$this->virtual_card($order_total);
					$this->update_order($payment_log,$order_total);       
				}				
				$msg = $this->languages['successful_to_pay'];
			}else{
				$fail = 1;
				$msg = $this->languages['failure_to_pay'];
				$this->set('fail',$fail);				
			}
		}else{
			 $result = $pay_class->respond($this);
			 if($result){
				if($result === "is_paid"){
					$msg = "已成功支付";
				}else{
					$msg = $this->languages['successful_to_pay'];
				}
			}else{
				$fail = 1;
				$msg = $this->languages['failure_to_pay'];
				$this->set('fail',$fail);
			}
		}
		$this->set('msg',$msg);
		$this->set('languages',$this->locale);
		$this->page_init();
		$this->set('categories_tree',$categories_tree = array());
		$this->set('brands',$brands = array());
		$this->layout = 'default_full';
	}
	
	function update_point($payment_log,$account){
			   $payment_log['PaymentApiLog']['is_paid'] = '1';
			   $this->PaymentApiLog->save($payment_log);
			   
			  /* $balance_log = array(
			   						"id"=>'',
			   						"user_id"=>$account['UserAccount']['user_id'],
			   						"amount"=>$account['UserAccount']['amount'],
			   						"log_type" => "B",
			   						"system_note" => "用户充值",
			   						"type_id"=>$payment_log['PaymentApiLog']['type_id']
			   						);
			   $this->UserBalanceLog->save($balance_log);*/
			
			   $user_info = $this->User->findbyid($account['UserAccount']['user_id']);
			   $user_info['User']['point'] += $account['UserAccount']['amount']*$this->configs['buy_point_proportion'];
			   $this->User->save($user_info);
			   $account['UserAccount']['paid_time'] = date("Y-m-d H:i:s");
		       $account['UserAccount']['status'] = 1;
			   $this->UserAccount->save($account);
	}
	
	//虚拟卡发邮件
	function virtual_card($order_total){
		$order_products = $this->OrderProduct->findallbyorder_id($order_total['Order']['id']);
		$virtualcards_info = "";
		
		if(isset($order_products) && sizeof($order_products)>0){
		//	pr($order_products);
			foreach($order_products as $k=>$v){
				if($v['OrderProduct']['extension_code']=='virtual_card'){
					$VirtualCards = $this->VirtualCard->find('all',array("conditions"=>array("VirtualCard.product_id='".$v['OrderProduct']['product_id']."' and VirtualCard.order_id='0'"),'limit'=>$v['OrderProduct']['product_quntity']));
				
					if(!empty($VirtualCards))foreach($VirtualCards as $kk=>$vv){
						$vv['VirtualCard']['is_saled'] = 1;
						$vv['VirtualCard']['order_id'] = $order_total['Order']['id'];
						$this->VirtualCard->save($vv['VirtualCard']);					
						/* 解密 */
						if($vv['VirtualCard']['crc32'] == 0 || $vv['VirtualCard']['crc32'] == crc32(AUTH_KEY)){
							$vv['VirtualCard']['card_sn'] = $this->decrypt($vv['VirtualCard']['card_sn']);
							$vv['VirtualCard']['card_password'] = $this->decrypt($vv['VirtualCard']['card_password']);							
						    $virtualcards_info.="------------------------------------- <br />";
				            $virtualcards_info.="卡号：".$vv['VirtualCard']['card_sn']."<br />";
				            $virtualcards_info.="卡片密码：".$vv['VirtualCard']['card_password']."<br />";
				            $virtualcards_info.="截至日期：".$vv['VirtualCard']['end_date']."<br />";
				            $virtualcards_info.="------------------------------------- <br />";
						}
					}
				}
			}
		}	
		if(!empty($virtualcards_info)){
			
		        $consignee=$order_total['Order']['consignee'];//template
		        $order_sn=$order_total['Order']['order_code'];//template
		        $product_name='';//template
		        $shop_name=$this->configs['shop_name'];//template
		        $shop_url=$this->server_host.$this->cart_webroot;//template
		        $send_date=date('Y-m-d H:m:s');//template
				//读模板
				$template='virtual_vard';
				$this->MailTemplate->set_locale($this->locale);
				$template=$this->MailTemplate->find("code = '$template' and status = '1'");
				//模板赋值
				$html_body=$template['MailTemplateI18n']['html_body'];
				eval("\$html_body = \"$html_body\";");
		        $text_body=$template['MailTemplateI18n']['text_body'];
		        eval("\$text_body = \"$text_body\";");
		        //主题赋值
		        $title = $template['MailTemplateI18n']['title'];
		        eval("\$title = \"$title\";");
		        if($this->configs['enable_auto_send_mail'] == 0){
			        $mailsendqueue = array(
			       		"sender_name"=>$shop_name,//发送从姓名
			       		"receiver_email"=>$consignee.";".$order_total['Order']['email'],//接收人姓名;接收人地址
			         	"cc_email"=>";",//抄送人
			         	"bcc_email"=>";",//暗送人
			          	"title"=>$title,//主题 
			           	"html_body"=>$html_body,//内容
			          	"text_body"=>$text_body,//内容
			         	"sendas"=>"html"
			     	);
			    	$this->MailSendQueue->saveAll(array("MailSendQueue"=>$mailsendqueue));//保存邮件队列
				}else{
					$subject = $template['MailTemplateI18n']['title'];
					eval("\$subject = \"$subject\";");
					$mailsendqueue = array(
						"sender_name"=>$shop_name,//发送从姓名
						"receiver_email"=>";".$to_email,//接收人姓名;接收人地址
					 	"cc_email"=>";",//抄送人
					 	"bcc_email"=>";",//暗送人
					  	"title"=>$subject,//主题 
					   	"html_body"=>$template_str,//内容
					  	"text_body"=>$text_body,//内容
					 	"sendas"=>"html"
					);
					$this->Email->send_mail($this->locale,$this->configs['email_the_way'], $mailsendqueue);

					
					
					
				}
		}
	}
	
	function decrypt($str, $key = AUTH_KEY)
	{
	    $coded = '';
	    $keylength = strlen($key);
	    $str = base64_decode($str);

	    for ($i = 0, $count = strlen($str); $i < $count; $i += $keylength)
	    {
	        $coded .= substr($str, $i, $keylength) ^ $key;
	    }

	    return $coded;
	}	
	
	function test($id = ''){
		$this->pageTitle = $this->languages['payment_result']." - ".$this->configs['shop_title'];
		if($id != ''){
			$msg = $this->languages['payment_result'].":".$this->languages['successfully'];
		}else{
			$fail = 1;
			$msg = $this->languages['payment_result'].":".$this->languages['failed'];
			$this->set('fail',$fail);
		}
		$this->set('msg',$msg);
		$this->page_init();
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
			$order_total['Order']['status'] = '1';
			$order_total['Order']['money_paid'] = $payment_log['PaymentApiLog']['amount'];
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

			$product_ids = $this->OrderProduct->findallbyorder_id($order_total['Order']['id']);
            $product_point = array();
			$send_coupon = array();
			$mun = 0;
			$product_alsobought = array();
			$product_size = sizeof($product_ids);
			if(isset($product_ids) && sizeof($product_ids)>0){
	            foreach($product_ids as $k=>$v){
					//ProductAlsobought
					if(isset($also) && isset($product_ids[$also]['OrderProduct']['product_id']) && $product_ids[$also]['OrderProduct']['product_id'] !="" && isset($v['OrderProduct']['product_id']) && $v['OrderProduct']['product_id'] != ""){
						if($product_size >0 && $mun > 0){
							$product_alsobought[$mun] = array('id'=>'','product_id'=>$product_ids[$also]['OrderProduct']['product_id'],'alsobought_product_id'=>$v['OrderProduct']['product_id']);
						}else{
							$also = $k;
						}
						$mun++;
					}
	            	
	            	$product = $this->Product->findbyid($v['OrderProduct']['product_id']);
					$product_point[$k] = array(
												'point' => $product['Product']['point']*$v['OrderProduct']['product_quntity'],
												'name' => $product['ProductI18n']['name']
												);            	
					if($product['Product']['coupon_type_id'] > 0){
						$send_coupon[] = $product['Product']['coupon_type_id'];
	            	}
	            }
            }
            if(isset($product_alsobought) && sizeof($product_alsobought)>0){
					$this->ProductAlsobought->saveall($product_alsobought);
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
	            	$now = date("Y-m-d H:i:s");
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