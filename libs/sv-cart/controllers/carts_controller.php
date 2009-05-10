<?php
/*****************************************************************************
 * SV-Cart 购物流程
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: carts_controller.php 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
class CartsController extends AppController {
	var $name = 'Carts';
	var $helpers = array('Html');
	var $uses = array('Cart','Product','Region','Shipping','ShippingArea','ShippingAreaRegion','Payment','User','UserAddress','Order','OrderProduct','Packaging','Card','OrderPackaging','OrderCard','Promotion','PromotionProduct','UserRank','ProductRank','PaymentApiLog','UserBalanceLog','UserPointLog','OrderCard','OrderPackaging','Coupon','CouponType');
	var $components = array('RequestHandler','Cookie','Session');
	
 	function index(){
	    $this->page_init();
 		$this->Product->set_locale($this->locale);
		if(!isset($_SESSION['svcart']['products']) && isset($_COOKIE['CakeCookie']['cart_cookie'])){
			$cookie = unserialize(StripSlashes($_COOKIE['CakeCookie']['cart_cookie']));
			$_SESSION['svcart'] = $cookie;
		}
 		//取得促销商品
 		$promotion_products = $this->Product->promotion($this->configs['promotion_count']);
 		foreach($promotion_products as $k=>$v){
 			$promotion_products[$k]['Product']['user_price'] = $this->Product->user_price($k,$v,$this);
 		}	
 		
		$this->set('promotion_products',$promotion_products);
		if(isset($this->configs['enable_buy_packing']) && $this->configs['enable_buy_packing'] == 1){
			//取得包装信息
			$this->Packaging->set_locale($this->locale);
			$this->set('packages',$this->Packaging->findAll("status = 1"));
		}
		if(isset($this->configs['enable_buy_card']) && $this->configs['enable_buy_card'] == 1){
			//取得贺卡信息
			$this->Card->set_locale($this->locale);
			$this->set('cards',$this->Card->findAll("status = 1"));
		}
		//输出SV-Cart里的信息
		if(isset($_SESSION['svcart']['products'])){
			$this->statistic_svcart();
			$this->set('all_virtual',$_SESSION['svcart']['cart_info']['all_virtual']);
			$this->set('svcart',$_SESSION['svcart']);
		}
		$this->pageTitle = $this->languages['cart']." - ".$this->configs['shop_title'];
		$this->navigations[] = array('name'=>$this->languages['cart'],'url'=>"/carts/");
		if(isset($this->configs['enable_one_step_buy']) && $this->configs['enable_one_step_buy'] == 1){
			$js_languages = array("enable_one_step_buy" => "1");
			$this->set('js_languages',$js_languages);
		}else{
			$js_languages = array("enable_one_step_buy" => "0");
			$this->set('js_languages',$js_languages);
		}
		$this->set('locations',$this->navigations);
	}
	
	function checkout(){
	    $this->page_init();
		if(isset($_SESSION['User']))
		{
			//	unset($_SESSION['svcart']);
				if(isset($_SESSION['svcart']['cart_info'])){
					$_SESSION['svcart']['cart_info']['total'] = $_SESSION['svcart']['cart_info']['sum_subtotal'];
				}	
				
				if(!isset($_SESSION['svcart']['products']) && isset($_COOKIE['CakeCookie']['cart_cookie'])){
					$cookie = unserialize(StripSlashes($_COOKIE['CakeCookie']['cart_cookie']));
					$_SESSION['svcart'] = $cookie;
				}
			//	pr($_SESSION['svcart']);
			//	$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
				/*
				if(isset($_SESSION['svcart']['address'])){
					unset($_SESSION['svcart']['address']);
				}
				if(isset($_SESSION['svcart']['shipping'])){
					unset($_SESSION['svcart']['shipping']);
				}
				if(isset($_SESSION['svcart']['payment'])){
					unset($_SESSION['svcart']['payment']);
				}
				if(isset($_SESSION['svcart']['promotion'])){
					unset($_SESSION['svcart']['promotion']);
				}
				if(isset($_SESSION['svcart']['cart_info']['old_total'])){
					unset($_SESSION['svcart']['cart_info']['old_total']);
				}
				if(isset($_SESSION['svcart']['Product_by_Promotion'])){
					unset($_SESSION['svcart']['Product_by_Promotion']);
				}
				if(isset($_SESSION['svcart']['point'])){
					unset($_SESSION['svcart']['point']);
				}
				if(isset($_SESSION['svcart']['coupon'])){
					unset($_SESSION['svcart']['coupon']);
				}*/
				//	unset($_SESSION['svcart']);			

				if($this->configs['order_smallest'] <= $_SESSION['svcart']['cart_info']['sum_subtotal']){
					$send_point['order_smallest'] = $this->configs['out_order_points'];
				}
				if($this->configs['order_gift_points'] == 1){
					$send_point['order_gift_points'] = $this->configs['order_points'];
				}
				$now = date("Y-m-d H:i:s");
				$product_point = array();
				$send_coupon = array();
				foreach($_SESSION['svcart']['products'] as $k=>$v)
				{
				$product_point[$k]['name'] = $v['ProductI18n']['name'];
				$product_point[$k]['point'] = $v['Product']['point']*$v['quantity'];
					if($v['Product']['coupon_type_id'] > 0){
					//	for($i =0;$i<$v['quantity'];$i++){
						$send_coupon[$k]['coupon'] = $v['Product']['coupon_type_id'];
						$send_coupon[$k]['name'] = $v['ProductI18n']['name'];
						$send_coupon[$k]['quantity'] = $v['Product']['quantity'];
				//		}
					}
				}
				$this->set('send_point',$send_point);
				$this->set('product_point',$product_point);
	            if(isset($this->configs['send_coupons']) && $this->configs['send_coupons'] == 1){
					$order_coupon = array();
	          	 	$this->CouponType->set_locale($this->locale);
	            	$order_coupon_type = $this->CouponType->findall("CouponType.send_type = 2 and CouponType.send_start_date <= '".$now."' and CouponType.send_end_date >= '".$now."'");
	            	if(is_array($order_coupon_type) && sizeof($order_coupon_type)>0){
	            		foreach($order_coupon_type as $k=>$v){
							if($v['CouponType']['min_products_amount'] < $_SESSION['svcart']['cart_info']['sum_subtotal']){
							//	$send_coupon_count++;
								$order_coupon[$k]['name'] = $v['CouponTypeI18n']['name'];							
								$order_coupon[$k]['fee'] = $v['CouponType']['money'];							
							}
						}
					}
				$this->set('order_coupon',$order_coupon);
	           // order send end
	           $product_coupon = array();
	            if(is_array($send_coupon) && sizeof($send_coupon)>0){
	            	foreach($send_coupon as $key => $value){
	            		$pro_coupon_type = $this->CouponType->findbyid($value['coupon']);
						$product_coupon[$key]['name'] = $value['name'];
						$product_coupon[$key]['fee'] = $pro_coupon_type['CouponType']['money'];	
						$product_coupon[$key]['quantity'] = $value['quantity'];	
	            	}
	            }
				$this->set('product_coupon',$product_coupon);
				
				 }
			if(!(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0)){
				$this->pageTitle = $this->languages['no_products_in_cart']." - ".$this->configs['shop_title'];
				$this->flash($this->languages['no_products_in_cart']," ","/",5);
			}else{
				//pr($_SESSION);
				//初始化session
	    		$this->statistic_svcart();
				$this->set('all_virtual',$_SESSION['svcart']['cart_info']['all_virtual']);
				//取得地址簿
				$this->Region->set_locale($this->locale);
				$addresses_count = $this->UserAddress->find("count",array('conditions' =>"UserAddress.user_id = '".$_SESSION['User']['User']['id']."'"));
				if($addresses_count == 0 ){
					$checkout_address = "new_address";
					$address['UserAddress']['id'] = 'null';
				}elseif($addresses_count == 1){
					$checkout_address = "confirm_address";
					$address = $this->UserAddress->findbyuser_id($_SESSION['User']['User']['id']);
					$_SESSION['svcart']['address']=$address['UserAddress'];
					$region_array = explode(" ",trim($address['UserAddress']['regions']));
					$address['UserAddress']['regions'] = "";
					foreach($region_array as $k=>$region_id){
						$region_info = $this->Region->findbyid($region_id);
						if($k < sizeof($region_array)-1){
							$address['UserAddress']['regions'] .= $region_info['RegionI18n']['name']." ";
						}else{
							$address['UserAddress']['regions'] .= $region_info['RegionI18n']['name'];
						}
					}
					
					$_SESSION['svcart']['address']['regionI18n'] = $address['UserAddress']['regions'];
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
				}else{
					$checkout_address = "select_address";
					$addresses = $this->UserAddress->findAllbyuser_id($_SESSION['User']['User']['id']);
					foreach($addresses as $key=>$address){
					$region_array = explode(" ",trim($address['UserAddress']['regions']));
					$addresses[$key]['UserAddress']['regions'] = "";
						foreach($region_array as $k=>$region_id){
							$region_info = $this->Region->findbyid($region_id);
							if($k < sizeof($region_array)-1){
								$addresses[$key]['UserAddress']['regions'] .= $region_info['RegionI18n']['name']." ";
							}else{
								$addresses[$key]['UserAddress']['regions'] .= $region_info['RegionI18n']['name'];
							}
						}
					}
					
					$this->set('addresses',$addresses);
					$address['UserAddress']['id'] = 'null';
				}
				$this->set('checkout_address',$checkout_address);
				$this->set('address',$address);
				$this->set('addresses_count',$addresses_count);
				$this->set('shipping_type',0);
				
				if($checkout_address == "confirm_address"){
					if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
						$weight = 0;
						foreach($_SESSION['svcart']['products'] as $k=>$v){
							$weight += $v['Product']['weight'];
						}
					}
					
					$address = $this->UserAddress->findbyuser_id($_SESSION['User']['User']['id']);
					if(trim($address['UserAddress']['regions']) != ""){
						$this->show_shipping_by_address($address['UserAddress']['id'],$weight);
					}
				}
				
				//取得可用的支付方式
				$this->Payment->set_locale($this->locale);
				$payments = $this->Payment->availables();
				$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
				if(isset($payments) && sizeof($payments) == 1 && (!isset($_SESSION['svcart']['cart_info']['all_virtual'])|| $_SESSION['svcart']['cart_info']['all_virtual'] == 0)){
					if($payments[0]['Payment']['code'] == 'account_pay' && $_SESSION['svcart']['cart_info']['total'] <= $user_info['User']['balance']){
						$_SESSION['svcart']['payment'] = array(
																'payment_id' =>$payments[0]['Payment']['id'],
																'payment_fee' =>$payments[0]['Payment']['fee'],
																'payment_name' =>$payments[0]['PaymentI18n']['name'],
																'payment_description' =>$payments[0]['PaymentI18n']['description'],
																'not_show_change' => '1',
																'is_cod' =>$payments[0]['Payment']['is_cod'],
																'code' => $payments[0]['Payment']['code']
																);
						
					}else{
						$_SESSION['svcart']['payment'] = array(
																'payment_id' =>$payments[0]['Payment']['id'],
																'payment_fee' =>$payments[0]['Payment']['fee'],
																'payment_name' =>$payments[0]['PaymentI18n']['name'],
																'payment_description' =>$payments[0]['PaymentI18n']['description'],
																'not_show_change' => '1',
																'is_cod' =>$payments[0]['Payment']['is_cod'],
																'code' => $payments[0]['Payment']['code']
																);
					}
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['payment']['payment_fee'];
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
				}
				
				
				
				$this->set('payments',$payments);
				//pr($_SESSION);
				//促销
				$promotions = $this->findpromotions();
				//pr($promotions);
				// 获得积分参数
				$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
				$use_point=0;
				$use_point = round($_SESSION['svcart']['cart_info']['sum_subtotal']/100*$this->configs['proportion_point']);
				//pr($_SESSION['svcart']['products']);
				$product_use_point =0;
				foreach($_SESSION['svcart']['products'] as $k=>$v){
					$product_use_point += $v['Product']['point_fee']*$v['quantity'];
				}
				if($product_use_point < $use_point){
					$this->set('can_use_point',$product_use_point);
				}else{
					$this->set('can_use_point',$use_point);
				}
				//pr($product_use_point);
				//我的优惠券
				$coupons = $this->Coupon->findall('Coupon.user_id ='.$_SESSION['User']['User']['id'].' and Coupon.order_id = 0');
				if(is_array($coupons) && sizeof($coupons) >0){
					$this->CouponType->set_locale($this->locale);
					foreach($coupons as $k=>$v){
						$coupon_type = $this->CouponType->findbyid($v['Coupon']['coupon_type_id']);
						$coupons[$k]['Coupon']['name'] = $coupon_type['CouponTypeI18n']['name'];
						$coupons[$k]['Coupon']['fee'] = $coupon_type['CouponType']['money'];
					}
					$this->set('coupons',$coupons);
				}
				
				
				$this->set('user_info',$user_info);
				$this->set('svcart',$_SESSION['svcart']);
                $this->set('promotions',$promotions);
			}
		}
		else
		{
			$_SESSION['back_url'] = "/carts/checkout/";
			$this->redirect('/user/login/');
			exit;
		}
						/* 判断是否需要显示配送方式 */
				if((isset($_SESSION['svcart']['cart_info']['all_virtual']) && $_SESSION['svcart']['cart_info']['all_virtual']==0) 
					|| (isset($_SESSION['svcart']['promotion']['all_virtual']) && $_SESSION['svcart']['promotion']['all_virtual'] == 0))
					$this->set('all_virtual',0);
				else $this->set('all_virtual',1);
				
                $this->pageTitle = $this->languages['checkout_center']." - ".$this->configs['shop_title'];
				$this->layout = 'default_full';
				$js_languages = array("address_label_not_empty" => $this->languages['address'].$this->languages['label'].$this->languages['can_not_empty'],
									"consignee_name_not_empty" => $this->languages['consignee'].$this->languages['name'].$this->languages['can_not_empty'],
									"address_detail_not_empty" => $this->languages['address'].$this->languages['can_not_empty'],
									"mobile_phone_not_empty" => $this->languages['mobile'].$this->languages['can_not_empty'],
									"tel_number_not_empty" => $this->languages['telephone'].$this->languages['can_not_empty'],
									"zip_code_not_empty" => $this->languages['post_code'].$this->languages['can_not_empty'],
									"order_note_not_empty" => $this->languages['order'].$this->languages['remark'].$this->languages['can_not_empty'],
									"invalid_email" => $this->languages['email'].$this->languages['not_correct'],
									"please_choose" => $this->languages['please_choose'],
									"choose_area" => $this->languages['please_choose'].$this->languages['area'],
									"invalid_tel_number" => $this->languages['telephone'].$this->languages['not_correct'],
									"not_less_eight_characters" => $this->languages['not_less_eight_characters'],
									"telephone_or_mobile" => $this->languages['telephone_or_mobile'],
									"exceed_max_value_can_use " => $this->languages['exceed_max_value_can_use'],
									"point_not_empty" => $this->languages['point'].$this->languages['can_not_empty'],
									"coupon_phone_not_empty" => $this->languages['coupon'].$this->languages['can_not_empty'],					
									"invalid_mobile_number" => $this->languages['mobile'].$this->languages['not_correct']
										);
				$this->set('js_languages',$js_languages);
	}
	
	function buy_now(){
		$result=array();
		$result['is_refresh'] = 0;
		if($this->RequestHandler->isPost()){
			if(isset($this->configs['enable_guest_buy']) && $this->configs['enable_guest_buy'] == 0){
				if(!isset($_SESSION['User']['User'])){
					$flag = 0;
				}else{
					$flag = 1;
				}
			}else{
					$flag = 1;
			}

			if($flag){
				$this->Packaging->set_locale($this->locale);
				$this->Card->set_locale($this->locale);
				$this->Product->set_locale($this->locale);		//加商品	
				if($_POST['type'] == 'product'){
					if($this->configs['cart_confirm_notice'] == 0 && !(isset($_POST['sure']))){
						$product_info = $this->Product->findbyid($_POST['id']);//商品属性待处理！
						$product_info['quantity'] = $_POST['quantity'];
						if($this->is_promotion($product_info)){
						$product_info['is_promotion'] = 1;
						}
						$this->set('product_info',$product_info);
						$result['type'] = 4;
					}else{
					//取得商品信息
						$product_info = $this->Product->findbyid($_POST['id']);//商品属性待处理！
					//添加到SVCART
						if($this->is_promotion($product_info)){
						$product_info['is_promotion'] = 1;
						}
						$result = $this->addto_svcart($product_info,$_POST['quantity']);
						$result['is_refresh'] = 0;
						if(isset($_SESSION['svcart']['products'][$_POST['id']])){
							/* 获取老标记 */
							$old_tag = isset($_SESSION['svcart']['cart_info']['all_virtual']) ? $_SESSION['svcart']['cart_info']['all_virtual'] : '';
							$this->statistic_svcart(); 				//计算金额
							
						//	pr($_SESSION['svcart']['products']);
							/* 纯虚拟商品标记的改变需要刷新页面 */
							if(sizeof($_SESSION['svcart']['products']) == 1|| $old_tag != $_SESSION['svcart']['cart_info']['all_virtual']){
								$result['is_refresh'] = 1;
							}
							$this->set('svcart',$_SESSION['svcart']);
							$this->set('product_id',$_POST['id']);
							$this->set('product_info',$_SESSION['svcart']['products'][$_POST['id']]);
						}else{
							$this->set('product_info',$product_info);
						}
						if(isset($_POST['page']) && $_POST['page']=="cart"){
							$result['page'] = $_POST['page'];
							$this->ajax_page_init();
			 			}
			 			$result['buy_id'] = $_POST['id'];
						$result['buy_type'] = 'product';
					}
				}

				//加包装
				if($_POST['type'] == 'packaging'){
				//取得包装信息
					$product_info = $this->Packaging->findbyid($_POST['id']);//包装属性待处理！
				//添加到SVCART
					$result = $this->addto_svcart($product_info,$_POST['quantity']);
					
					if(isset($_SESSION['svcart']['packagings'][$_POST['id']])){
						$this->statistic_svcart('packaging');
						$this->set('svcart',$_SESSION['svcart']);
						$this->set('packaging_id',$_POST['id']);
						$this->set('product_info',$_SESSION['svcart']['packagings'][$_POST['id']]);
					}else{
						$this->set('product_info',$product_info);
					}
					
					if(isset($_POST['page']) && $_POST['page']=="cart"){
						$result['page'] = $_POST['page'];
						$this->ajax_page_init();
		 			}
		 			$result['buy_id'] = $_POST['id'];
		 			$result['buy_type'] = 'packaging';
				}
				
				//加贺卡
				if($_POST['type'] == 'card'){
				//取得贺卡信息
					$product_info = $this->Card->findbyid($_POST['id']);//贺卡属性待处理！
				//添加到SVCART
					$result = $this->addto_svcart($product_info,$_POST['quantity']);
				
					if(isset($_SESSION['svcart']['cards'][$_POST['id']])){
						$this->statistic_svcart('card');
						$this->set('svcart',$_SESSION['svcart']);
						$this->set('card_id',$_POST['id']);
						$this->set('product_info',$_SESSION['svcart']['cards'][$_POST['id']]);
					}else{
						$this->set('product_info',$product_info);
					}
					
					if(isset($_POST['page']) && $_POST['page']=="cart"){
						$result['page'] = $_POST['page'];
						$this->ajax_page_init();
		 			}
		 			$result['buy_id'] = $_POST['id'];
		 			$result['buy_type'] = 'card';
					}
					if(isset($this->configs['enable_one_step_buy']) && $this->configs['enable_one_step_buy'] == 1){
						$js_languages = array("enable_one_step_buy" => "1");
				    	$this->set('js_languages',$js_languages);
					}
			}else{
				$result['type']= 5;
				$result['message']=$this->languages['time_out_relogin'];
			}
	 			$this->set('type',$_POST['type']);
				$this->set('result',$result);
				$this->layout = 'ajax';
		}
	}
	
	function addto_svcart($product_info,$quantity){
		if($_POST['type'] == 'product'){
		$result['type'] = 2;
		//判断状态
		if($product_info['Product']['status']!=1 || $product_info['Product']['forsale']!=1){
			$result['type']=1;
			$result['message']= $this->languages['products_add_cart_failed'];
			return $result;
		}
		
		if(isset($this->configs['enable_stock_manage']) && $this->configs['enable_stock_manage'] == 1){
			if($quantity > $product_info['Product']['quantity']){
				$result['type']=1;
				$result['message']= $this->languages['stock_is_not_enough'];
				return $result;
			}
		}

		
		//判断是否在购物车
		if($this->in_svcart($product_info['Product']['id'])){
			if($_SESSION['svcart']['products'][$product_info['Product']['id']]['quantity'] + $quantity > $product_info['Product']['max_buy']){
				$result['type']=1;
				$result['message']= $this->languages['expand_max_number'];
				return $result;
			}elseif($_SESSION['svcart']['products'][$product_info['Product']['id']]['quantity'] + $quantity > $product_info['Product']['quantity']){
				$result['type']=1;
				$result['message']= $this->languages['stock_is_not_enough'];
				return $result; 
			}else{
				$_SESSION['svcart']['products'][$product_info['Product']['id']]['quantity'] += $quantity;
				if(isset($this->configs['enable_decrease_stock_time']) && $this->configs['enable_decrease_stock_time'] == 0){
					$product_quantity = $product_info['Product']['quantity'] - $quantity;
					$product_info['Product']['quantity'] = $product_quantity;
					$this->Product->save($product_info);
				}
				$result['type']=0;
			}
		}else{
			if($quantity < $product_info['Product']['min_buy']){
				$result['type']=1;
				$result['message']=$this->languages['least_number'].$product_info['Product']['min_buy'];
				return $result;
			}else{
				$_SESSION['svcart']['products'][$product_info['Product']['id']] = $product_info;
				$_SESSION['svcart']['products'][$product_info['Product']['id']]['quantity'] = $quantity;
				$_SESSION['svcart']['products'][$product_info['Product']['id']]['Product']['quantity'] = $quantity;
 				$categorys = $this->Category->findbyid($product_info['Product']['category_id']);
				if(isset($categorys['CategoryI18n']['name'])){
					$_SESSION['svcart']['products'][$product_info['Product']['id']]['category_name'] = $categorys['CategoryI18n']['name'];
					$_SESSION['svcart']['products'][$product_info['Product']['id']]['category_id'] = $categorys['Category']['id'];
				}
				$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

				if(isset($this->configs['enable_decrease_stock_time']) && $this->configs['enable_decrease_stock_time'] == 0){
					$product_quantity = $product_info['Product']['quantity'] - $quantity;
					$product_info['Product']['quantity'] = $product_quantity;
					$this->Product->save($product_info);
				}
				
				$result['type']=0;
				}
			}
		}
		
	if($_POST['type'] == 'packaging'){
		$result['type'] = 0;
		//判断状态
		if($product_info['Packaging']['status']!=1){
			$result['type']=1;
			$result['message']=$this->languages['package_add_cart_failed'];
			return $result;
		}
		$_SESSION['svcart']['packagings'][$product_info['Packaging']['id']] = $product_info;
		$_SESSION['svcart']['packagings'][$product_info['Packaging']['id']]['quantity'] = $quantity;
		$_SESSION['svcart']['packagings'][$product_info['Packaging']['id']]['Packaging']['quantity'] = $quantity;
		$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
	
		$result['type'] = 0;
		}
		
	if($_POST['type'] == 'card'){
		$result['type'] = 0;
		//判断状态
		if($product_info['Card']['status']!=1){
			$result['type']=1;
			$result['message'] = $this->languages['package_add_cart_failed'];
			return $result;
		}
		$_SESSION['svcart']['cards'][$product_info['Card']['id']] = $product_info;
		$_SESSION['svcart']['cards'][$product_info['Card']['id']]['quantity'] = $quantity;
		$_SESSION['svcart']['cards'][$product_info['Card']['id']]['Card']['quantity'] = $quantity;
		$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
	
		$result['type'] = 0;
		}
		return $result;
	}
	
	function remove(){
		$result=array();
		if($this->RequestHandler->isPost()){
			if($_POST['type'] == 'product'){
				if(isset($_SESSION['svcart']['products'][$_POST['product_id']])){
					$this->set("product_info",$_SESSION['svcart']['products'][$_POST['product_id']]);
					$result['type']=0;
				}else{
					$result['type']=1;
					$result['message']=$this->languages['product_not_in_cart'];
				} 
				$result['type'] = $_POST['type'];
			}
			
			if($_POST['type'] == 'packaging'){
				if(isset($_SESSION['svcart']['packagings'][$_POST['product_id']])){
					$this->set("product_info",$_SESSION['svcart']['packagings'][$_POST['product_id']]);
					$result['type']=0;
				}else{
					$result['type']=1;
					$result['message']= $this->languages['product_not_in_cart'];
				}
				$result['type'] = $_POST['type'];
			}
			
			if($_POST['type'] == 'card'){
				if(isset($_SESSION['svcart']['cards'][$_POST['product_id']])){
					$this->set("product_info",$_SESSION['svcart']['cards'][$_POST['product_id']]);
					$result['type']=0;
				}else{
					$result['type']=1;
					$result['message']= $this->languages['product_not_in_cart'];
				}
				$result['type'] = $_POST['type'];
			}
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function act_remove(){
		$result=array();
		$result['is_refresh'] = 0;
		if($this->RequestHandler->isPost()){
			$result['no_product'] = 1;
			if($_POST['type'] == 'product'){
			//将商品从SV-Cart中删除
				if(isset($_SESSION['svcart']['products'][$_POST['product_id']])){
					$result['type']=0;
					$this->set('product_info',$_SESSION['svcart']['products'][$_POST['product_id']]);
					$this->ajax_page_init();
					if(count($_SESSION['svcart']['products'])>1){
						unset($_SESSION['svcart']['products'][$_POST['product_id']]);
						$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
					}else{
						unset($_SESSION['svcart']['products']);
						$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
 						$result['no_product'] = 0;
					}
				}else{
					$result['type']=1;
					$result['message']=$this->languages['product_not_in_cart'];
				}
				//SV-Cart里的信息
				
				$old_tag = isset($_SESSION['svcart']['cart_info']['all_virtual']) ? $_SESSION['svcart']['cart_info']['all_virtual'] : '';
				$this->statistic_svcart(); 
				/* 纯虚拟商品标记的改变需要刷新页面 */
				if($old_tag != $_SESSION['svcart']['cart_info']['all_virtual'])
					$result['is_refresh'] = 1;
				$this->statistic_svcart('product');
				if(isset($_SESSION['svcart'])){
				$this->set('svcart',$_SESSION['svcart']);
				}
			}
			
			if($_POST['type'] == 'packaging'){
			//将包装从SV-Cart中删除
				if(isset($_SESSION['svcart']['packagings'][$_POST['product_id']])){
					$result['type']=0;
					$this->set('product_info',$_SESSION['svcart']['packagings'][$_POST['product_id']]);
					$this->ajax_page_init();
					if(count($_SESSION['svcart']['packagings'])>1){
						unset($_SESSION['svcart']['packagings'][$_POST['product_id']]);
					}else{
						unset($_SESSION['svcart']['packagings']);
					}
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
 				}else{
					$result['type']=1;
					$result['message']=$this->languages['product_not_in_cart'];
				}
				//SV-Cart里的信息
				$this->statistic_svcart('packaging');
				if(isset($_SESSION['svcart'])){
				$this->set('svcart',$_SESSION['svcart']);
				}
			}
			
			if($_POST['type'] == 'card'){
			//将贺卡从SV-Cart中删除
				if(isset($_SESSION['svcart']['cards'][$_POST['product_id']])){
					$result['type']=0;
					$this->set('product_info',$_SESSION['svcart']['cards'][$_POST['product_id']]);
					$this->ajax_page_init('card');
					if(count($_SESSION['svcart']['cards'])>1){
						unset($_SESSION['svcart']['cards'][$_POST['product_id']]);
					}else{
						unset($_SESSION['svcart']['cards']);
					}
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
				}else{
					$result['type']=1;
					$result['message']=$this->languages['product_not_in_cart'];
				}
				//SV-Cart里的信息
				$this->statistic_svcart('card');
				if(isset($_SESSION['svcart'])){
				$this->set('svcart',$_SESSION['svcart']);
				}
			}
		}
		/* 如果全部为虚拟商品删除包装和贺卡 */
		if(!empty($_SESSION['svcart']['cart_info']['all_virtual'])){
			if(isset($_SESSION['svcart']['cards']))
				unset($_SESSION['svcart']['cards']);
			if(isset($_SESSION['svcart']['packagings']))
				unset($_SESSION['svcart']['packagings']);
		}
		$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function act_quantity_change(){
		$result=array();
		if($this->RequestHandler->isPost()){
			if($_POST['type'] == 'product'){
			//将商品从SV-Cart中删除
				if($this->in_svcart($_POST['product_id'])){
					$product_info = $this->Product->findbyid($_POST['product_id']);//商品属性待处理！
						//$_SESSION['svcart']['products'][$product_id]['quantity']
					if($_POST['quantity'] > $product_info['Product']['max_buy']){
						$result['type']=1;
						$result['message']=$this->languages['expand_max_number'];
					}elseif($_POST['quantity'] < $product_info['Product']['min_buy']){
						$result['type']=1;
						$result['message']=$this->languages['least_number'].$product_info['Product']['min_buy'];
					}elseif($_POST['quantity'] > $product_info['Product']['quantity']){
						$result['type']=1;
						$result['message']= $this->languages['stock_is_not_enough'];
					}else{
						$result['type']=0;
						$_SESSION['svcart']['products'][$_POST['product_id']]['quantity'] = $_POST['quantity'];
						$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

						$this->ajax_page_init();
					}
				}else{
					$result['type']=1;
					$result['message']=$this->languages['product_not_in_cart'];
				}
			
				//SV-Cart里的信息
				if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
					$this->statistic_svcart();
					$this->set('svcart',$_SESSION['svcart']);
				}else{
					unset($_SESSION['svcart']['products']);
				}
			}

			if($_POST['type'] == 'packaging'){
			//将商品从SV-Cart中删除
				if($this->in_svcart_packaging($_POST['product_id'])){
					$product_info = $this->Packaging->findbyid($_POST['product_id']);//商品属性待处理！
					$result['type']=0;
					$_SESSION['svcart']['packagings'][$_POST['product_id']]['quantity'] = $_POST['quantity'];
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
				
					$this->ajax_page_init();
				}else{
					$result['type']=1;
					$result['message']=$this->languages['product_not_in_cart'];
				}
			
				//SV-Cart里的信息
				if(isset($_SESSION['svcart']['packagings']) && sizeof($_SESSION['svcart']['packagings'])>0){
					$this->statistic_svcart('packaging');
					$this->set('svcart',$_SESSION['svcart']);
				}else{
					unset($_SESSION['svcart']['packagings']);
				}
			}
			
			if($_POST['type'] == 'card'){
			//将商品从SV-Cart中删除
				if($this->in_svcart_card($_POST['product_id'])){
					$product_info = $this->Card->findbyid($_POST['product_id']);//商品属性待处理！
					$result['type']=0;
					$_SESSION['svcart']['cards'][$_POST['product_id']]['quantity'] = $_POST['quantity'];
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
					
					
					$this->ajax_page_init();
				}else{
					$result['type']=1;
					$result['message']=$this->languages['product_not_in_cart'];
				}
				//SV-Cart里的信息
				if(isset($_SESSION['svcart']['cards']) && sizeof($_SESSION['svcart']['cards'])>0){
					$this->statistic_svcart('card');
					$this->set('svcart',$_SESSION['svcart']);
				}else{
					unset($_SESSION['svcart']['cards']);
				}
			}			
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}	
	
	function in_svcart($product_id){
		return (isset($_SESSION['svcart']['products'][$product_id]) && $_SESSION['svcart']['products'][$product_id]['quantity']>0);
	}
	function in_svcart_packaging($product_id){
		return (isset($_SESSION['svcart']['packagings'][$product_id]) && $_SESSION['svcart']['packagings'][$product_id]['quantity']>0);
	}
	function in_svcart_card($product_id){
		return (isset($_SESSION['svcart']['cards'][$product_id]) && $_SESSION['svcart']['cards'][$product_id]['quantity']>0);
	}
	
	function is_promotion($product_info){
		return ($product_info['Product']['promotion_status'] == 1 && $product_info['Product']['promotion_start'] <= date("Y-m-d H:i:s") && $product_info['Product']['promotion_end'] >= date("Y-m-d H:i:s"));
	}
	
	function statistic_svcart($type = 'product'){
		//总现合计
		$_SESSION['svcart']['cart_info']['sum_subtotal'] = 0;
		//总原合计
		$_SESSION['svcart']['cart_info']['sum_market_subtotal'] = 0;
		//pr($_SESSION);
		if($type == 'product'){
			//是否全为虚拟商品
			$_SESSION['svcart']['cart_info']['all_virtual'] = 1;
			
			if(isset($_SESSION['svcart']['products'])){	
				foreach($_SESSION['svcart']['products'] as $i=>$p){
					if(empty($p['Product']['extension_code'])){
						$_SESSION['svcart']['cart_info']['all_virtual'] = 0;
					}
					//获得是否有会员价
					if(isset($_SESSION['User'])){
						/*
						$product_rank = $this->ProductRank->findbyid($p['Product']['product_rank_id']);
						if(isset($product_rank['ProductRank']['is_default_rank'])){
							if($product_rank['ProductRank']['is_default_rank'] == 0){
								$p['Product']['product_rank_price'] = $product_rank['ProductRank']['product_price'];
							}

							if($product_rank['ProductRank']['is_default_rank'] == 1){
								$user_rank = $this->UserRank->findbyid($product_rank['ProductRank']['rank_id']);
								$p['Product']['product_rank_price'] = round($p['Product']['shop_price']*$user_rank['UserRank']['discount']/100,2);
							}
						}*/
						
					$p['Product']['product_rank_price'] = 	$this->Product->user_price($i,$p,$this);
						
						/*
						$user_rank_list=$this->UserRank->findrank();

						foreach($user_rank_list as $k=>$v){
							  $user_rank_list[$k]['UserRank']['user_price']=($user_rank_list[$k]['UserRank']['discount']/100)*($_SESSION['svcart']['products'][$i]['Product']['shop_price']);			  
							  if(isset($_SESSION['User']['User']['rank']) && $v['UserRank']['id'] == $_SESSION['User']['User']['rank']){
							  		$p['Product']['product_rank_price'] = $user_rank_list[$k]['UserRank']['user_price'];
							  		$_SESSION['svcart']['products'][$i]['product_rank_price'] = $user_rank_list[$k]['UserRank']['user_price'];
							  }
						}*/
						}else{
					//如果会员未登录 删除SESSION中残留的product_rank_price
						if(isset($p['Product']['product_rank_price']) || isset($_SESSION['svcart']['products'][$i]['product_rank_price'])){
							unset($p['Product']['product_rank_price']);
							unset($_SESSION['svcart']['products'][$i]['product_rank_price']);
						}
					}
					
					//有会员价
					if(isset($p['Product']['product_rank_price'])){
						$promotion_price = $p['Product']['product_rank_price'];
						$_SESSION['svcart']['products'][$i]['product_rank_price'] = $promotion_price;
					//	pr($p['Product']['product_rank_price']);
					//	$this->set('product_rank_price',$promotion_price);
						$_SESSION['svcart']['cart_info']['sum_subtotal'] += $p['Product']['product_rank_price']*$p['quantity'];
					}else{
						if($this->is_promotion($p)){
							//该商品现价
							$promotion_price = $p['Product']['promotion_price'];
							//全部商品现价合计
							
							$_SESSION['svcart']['cart_info']['sum_subtotal'] += $p['Product']['promotion_price']*$p['quantity'];
						
							$_SESSION['svcart']['products'][$i]['is_promotion'] = 1;
						}else{
							$promotion_price = $p['Product']['shop_price'];
							//总现合计
							$_SESSION['svcart']['cart_info']['sum_subtotal'] += $p['Product']['shop_price']*$p['quantity'];
							$_SESSION['svcart']['products'][$i]['is_promotion'] = 0;
						}
					}
					//该商品原价
					$_SESSION['svcart']['products'][$i]['market_subtotal'] = $p['Product']['market_price']*$p['quantity'];
					//该商品小计
					$_SESSION['svcart']['products'][$i]['subtotal'] = $promotion_price*$p['quantity'];
					//全部商品原价合计
					$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['products'][$i]['market_subtotal'];
					//该商品差价
					$_SESSION['svcart']['products'][$i]['discount_price'] = $p['Product']['market_price'] - $promotion_price;
					//该商品折扣%?
					if($promotion_price > 0){
					$_SESSION['svcart']['products'][$i]['discount_rate'] = round($promotion_price/$p['Product']['market_price'],2)*100 ;
					}else{
					$_SESSION['svcart']['products'][$i]['discount_rate'] = 100;
					}
				}
			}
			if(isset($_SESSION['svcart']['cart_info']['all_virtual'])){
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

			}
				//判断是否有贺卡和包装
				if(isset($_SESSION['svcart']['packagings'])){
					foreach($_SESSION['svcart']['packagings'] as $i=>$p){
						//包装小计
						$_SESSION['svcart']['packagings'][$i]['subtotal'] = $p['Packaging']['fee']*$p['quantity'];
						//加上包装费的总价
						$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['packagings'][$i]['subtotal'];
						$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['packagings'][$i]['subtotal'];
					}
				}
				if(isset($_SESSION['svcart']['cards'])){
					foreach($_SESSION['svcart']['cards'] as $i=>$p){
						//贺卡小计
						$_SESSION['svcart']['cards'][$i]['subtotal'] = $p['Card']['fee']*$p['quantity'];
						//加上贺卡费的总价
						$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['cards'][$i]['subtotal'];
						$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['cards'][$i]['subtotal'];
					}
				}
			if($_SESSION['svcart']['cart_info']['sum_subtotal'] == 0){
				$_SESSION['svcart']['cart_info']['discount_rate'] = 0;
			}else{
				$_SESSION['svcart']['cart_info']['discount_rate'] = round($_SESSION['svcart']['cart_info']['sum_subtotal']/$_SESSION['svcart']['cart_info']['sum_market_subtotal'],2)*100 ;
			}
			$_SESSION['svcart']['cart_info']['discount_price'] = $_SESSION['svcart']['cart_info']['sum_market_subtotal'] - $_SESSION['svcart']['cart_info']['sum_subtotal'];
		}
		
		if($type == 'packaging'){
			if(isset($_SESSION['svcart']['packagings'])){
				foreach($_SESSION['svcart']['packagings'] as $i=>$p){
					//包装小计
					$_SESSION['svcart']['packagings'][$i]['subtotal'] = $p['Packaging']['fee']*$p['quantity'];
					$_SESSION['svcart']['packagings'][$i]['is_promotion'] = 0;
					//总现合计
					$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['packagings'][$i]['subtotal'];
					//总原合计
					$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['packagings'][$i]['subtotal'];
				}
			}
			//判断是否有商品和贺卡
			if(isset($_SESSION['svcart']['products'])){
				foreach($_SESSION['svcart']['products'] as $i=>$p){
					$_SESSION['svcart']['products'][$i]['subtotal'] = 0;
					if(isset($_SESSION['User']) && $this->configs['show_member_level_price'] == 1){
						$product_rank = $this->ProductRank->findbyid($p['Product']['product_rank_id']);
						if(isset($product_rank['ProductRank']['is_default_rank'])){
							if($product_rank['ProductRank']['is_default_rank'] == 0){
								$p['Product']['product_rank_price'] = $product_rank['ProductRank']['product_price'];					
							}
							if($product_rank['ProductRank']['is_default_rank'] == 1){
								$user_rank = $this->UserRank->findbyid($product_rank['ProductRank']['rank_id']);
								$p['Product']['product_rank_price'] = round($p['Product']['shop_price']*$user_rank['UserRank']['discount']/100,2);					
							}
						}
					}else{
					//如果会员未登录 删除SESSION中残留的product_rank_price
						if(isset($p['Product']['product_rank_price']) || isset($_SESSION['svcart']['products'][$i]['product_rank_price'])){
							unset($p['Product']['product_rank_price']);
							unset($_SESSION['svcart']['products'][$i]['product_rank_price']);
						}
					}						
					if(isset($p['Product']['product_rank_price'])){
						$_SESSION['svcart']['products'][$i]['subtotal'] += $p['Product']['product_rank_price']*$p['quantity'];//小计
					}else{
						if($this->is_promotion($p)){
							$_SESSION['svcart']['products'][$i]['subtotal'] += $p['Product']['promotion_price']*$p['quantity'];//小计
							$_SESSION['svcart']['products'][$i]['is_promotion'] = 1;
						}else{
							$_SESSION['svcart']['products'][$i]['subtotal'] += $p['Product']['shop_price']*$p['quantity'];//小计
							$_SESSION['svcart']['products'][$i]['is_promotion'] = 0;
						}
					}
						$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['products'][$i]['subtotal'];
						$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $p['Product']['market_price']*$p['quantity'];
					}
				if($_SESSION['svcart']['cart_info']['sum_subtotal'] == 0){
					$_SESSION['svcart']['cart_info']['discount_rate'] = 0;
				}else{
					$_SESSION['svcart']['cart_info']['discount_rate'] = round($_SESSION['svcart']['cart_info']['sum_subtotal']/$_SESSION['svcart']['cart_info']['sum_market_subtotal'],2)*100 ;
				}
			}

			if(isset($_SESSION['svcart']['cards'])){
				foreach($_SESSION['svcart']['cards'] as $i=>$p){
					$_SESSION['svcart']['cards'][$i]['subtotal'] = $p['Card']['fee']*$p['quantity'];//小计
					$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['cards'][$i]['subtotal'];
					$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['cards'][$i]['subtotal'];
				}
			}
		}
	
		if($type == 'card'){
			if(isset($_SESSION['svcart']['cards'])){
				foreach($_SESSION['svcart']['cards'] as $i=>$p){
						$_SESSION['svcart']['cards'][$i]['subtotal'] = $p['Card']['fee']*$p['quantity'];//小计
						$_SESSION['svcart']['cards'][$i]['is_promotion'] = 0;
					//总现合计
					$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['cards'][$i]['subtotal'];
					//总原合计
					$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['cards'][$i]['subtotal'];
				}
			}
			if(isset($_SESSION['svcart']['products'])){
				foreach($_SESSION['svcart']['products'] as $i=>$p){
					$_SESSION['svcart']['products'][$i]['subtotal'] = 0;
					if(isset($_SESSION['User']) && $this->configs['show_member_level_price'] == 1){
						$product_rank = $this->ProductRank->findbyid($p['Product']['product_rank_id']);
						if(isset($product_rank['ProductRank']['is_default_rank'])){
							if($product_rank['ProductRank']['is_default_rank'] == 0){
								$p['Product']['product_rank_price'] = $product_rank['ProductRank']['product_price'];					
							}
							if($product_rank['ProductRank']['is_default_rank'] == 1){
								$user_rank = $this->UserRank->findbyid($product_rank['ProductRank']['rank_id']);
								$p['Product']['product_rank_price'] = round($p['Product']['shop_price']*$user_rank['UserRank']['discount']/100,2);					
							}
						}
					}else{
					//如果会员未登录 删除SESSION中残留的product_rank_price
						if(isset($p['Product']['product_rank_price']) || isset($_SESSION['svcart']['products'][$i]['product_rank_price'])){
							unset($p['Product']['product_rank_price']);
							unset($_SESSION['svcart']['products'][$i]['product_rank_price']);
						}
					}if(isset($p['Product']['product_rank_price'])){
						$_SESSION['svcart']['products'][$i]['subtotal'] += $p['Product']['product_rank_price']*$p['quantity'];//小计
					}else{
						if($this->is_promotion($p)){
							$_SESSION['svcart']['products'][$i]['subtotal'] += $p['Product']['promotion_price']*$p['quantity'];//小计
							$_SESSION['svcart']['products'][$i]['is_promotion'] = 1;
						}else{
							$_SESSION['svcart']['products'][$i]['subtotal'] += $p['Product']['shop_price']*$p['quantity'];//小计
							$_SESSION['svcart']['products'][$i]['is_promotion'] = 0;
						}
					}
						$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['products'][$i]['subtotal'];
						$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $p['Product']['market_price']*$p['quantity'];
					}
				if($_SESSION['svcart']['cart_info']['sum_subtotal'] == 0){
					$_SESSION['svcart']['cart_info']['discount_rate'] = 0;
				}else{
					$_SESSION['svcart']['cart_info']['discount_rate'] = round($_SESSION['svcart']['cart_info']['sum_subtotal']/$_SESSION['svcart']['cart_info']['sum_market_subtotal'],2)*100 ;
				}
			}
			
			if(isset($_SESSION['svcart']['packagings'])){
				foreach($_SESSION['svcart']['packagings'] as $i=>$p){
					$_SESSION['svcart']['packagings'][$i]['subtotal'] = $p['Packaging']['fee']*$p['quantity'];
					$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['packagings'][$i]['subtotal'];
					$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['packagings'][$i]['subtotal'];
				}
			}
		}
		//节省
		$_SESSION['svcart']['cart_info']['discount_price'] = $_SESSION['svcart']['cart_info']['sum_market_subtotal'] - $_SESSION['svcart']['cart_info']['sum_subtotal'];
		$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

	}
	
	function done(){
		$do_action = 1;
		
		if(!(isset($_SESSION['User']))){
			$_SESSION['back_url'] = "/carts/done/";
			$this->redirect('/user/login/');
			exit;
		}
		$error_arr = array();
		if(!(isset($_SESSION['svcart']['products']))){
			$error_arr[] = $this->languages['no_products_in_cart'];
			$this->set('fail',1);
			$do_action = 0;
		}
		
		if(!isset($_SESSION['svcart']['shipping']['shipping_id'])&&empty($_SESSION['svcart']['cart_info']['all_virtual'])){
			$error_arr[] = $this->languages['please_choose'].$this->languages['shipping_method'];
			$this->set('fail',1);
			$do_action = 0;
		}
		
		if(!isset($_SESSION['svcart']['payment']['payment_id'])){
			$error_arr[] = $this->languages['please_choose'].$this->languages['payment'];
			$this->set('fail',1);
			$do_action = 0;
		}
		
		if(isset($this->configs['min_buy_amount']) && isset($_SESSION['svcart']['cart_info']['total'])){
			if($_SESSION['svcart']['cart_info']['total'] < $this->configs['min_buy_amount']){
				//$this->flash("订单金额低于最小购物金额"," ","/",5);
				$error_arr[] = $this->languages['order_amount_under_min'];
				$this->set('fail',1);
				$do_action = 0;
			}
		}
		$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);

		if(isset($_SESSION['svcart']['payment']['payment_id']) && isset($_SESSION['svcart']['products']) && $_SESSION['svcart']['payment']['code'] == "account_pay" && $_SESSION['svcart']['cart_info']['total'] > $user_info['User']['balance']){
				$error_arr[] = $this->languages['lack_balance_supply_first'];
				$this->set('fail',1);
				$do_action = 0;
		}

		if($this->RequestHandler->isPost() && $do_action){
			
			$this->Payment->set_locale($this->locale);
			$payment_info = $this->Payment->findbyid($_SESSION['svcart']['payment']['payment_id']);
			$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
			$order = array();
			$order['user_id']					= $_SESSION['User']['User']['id'];
			$order['status'] 					= 0;														//订单状态-应该去系统参数里面取
			$order['consignee'] 				= $_SESSION['svcart']['address']['consignee'];
       		$now = date("Y-m-d H:i:s");
			$order['created'] 					= $now;
			if(isset($_SESSION['svcart']['order_remark'])){
				$order['note'] 				= $_SESSION['svcart']['order_remark'];
			}
			/* 判断是否需要配送方式 */
			if((isset($_SESSION['svcart']['cart_info']['all_virtual']) && $_SESSION['svcart']['cart_info']['all_virtual']==0) 
				|| (isset($_SESSION['svcart']['promotion']['all_virtual']) && $_SESSION['svcart']['promotion']['all_virtual'] == 0)){
				$order['shipping_id'] 				= isset($_SESSION['svcart']['shipping']['shipping_id']) ? $_SESSION['svcart']['shipping']['shipping_id'] : -1;
				$order['shipping_name'] 			= isset($_SESSION['svcart']['shipping']['shipping_name']) ? $_SESSION['svcart']['shipping']['shipping_name'] : '';
				$order['shipping_fee'] 				= isset($_SESSION['svcart']['shipping']['shipping_fee']) ? $_SESSION['svcart']['shipping']['shipping_fee'] : 0;
				$order['regions'] 					= $_SESSION['svcart']['address']['regions'];
				$order['address']					= $_SESSION['svcart']['address']['address'];
				$order['zipcode'] 					= $_SESSION['svcart']['address']['zipcode'];
				$order['best_time']					= $_SESSION['svcart']['address']['best_time'];
				$order['sign_building'] 			= $_SESSION['svcart']['address']['sign_building'];
			}
			else
				$order['shipping_id'] 				= -1;
			
			$order['payment_id'] 				= $_SESSION['svcart']['payment']['payment_id'];
			$order['payment_name'] 				= $payment_info['PaymentI18n']['name'];	
			//余额支付 修改支付状态		
			if($_SESSION['svcart']['payment']['code'] == "account_pay"){
				$order['payment_status'] 			= 2;												//支付状态-应该去系统参数里面取
				$order['payment_time']				= date("Y-m-d H:i:s");								//支付时间-应该根据具体支付方法来设
				$order['money_paid'] = $_SESSION['svcart']['cart_info']['total']; 						//已付金额
			}
		    $pay = $this->Payment->findbyid($_SESSION['svcart']['payment']['payment_id']);
			if($pay['Payment']['code'] == "post"){  
				$order['payment_status'] 			= 1;											
			}
			if($pay['Payment']['code'] == "bank"){ 
				$order['payment_status'] 			= 1;												
			}
			if(isset($_SESSION['svcart']['coupon']['coupon'])){
				$order['coupon_id'] =  $_SESSION['svcart']['coupon']['coupon'];
			}

			$order['payment_fee'] 				= $payment_info['Payment']['fee'];

			$order['telephone'] 				= $_SESSION['svcart']['address']['telephone'];
			$order['mobile'] 					= $_SESSION['svcart']['address']['mobile'];
			$order['email'] 					= $_SESSION['svcart']['address']['email'];

//			$order['postscript'] 				= '';													//不知道去哪取	
//			$order['invoice_no'] 				= '';													//不知道去哪取
//			$order['note'] 						= '';													//暂时没有
//			$order['money_paid'] 				= 0;													//已付金额

//			$order['discount'] 					= $_SESSION['svcart']['cart_info']['discount_rate'];	//折扣
			$order['discount'] 					= 0;
			$order['subtotal'] 					= $_SESSION['svcart']['cart_info']['sum_subtotal'];		//纯商品总计
			$order['total'] 					= $_SESSION['svcart']['cart_info']['total'];			//总计
//			$order['from_ad'] 					= '';													//广告来源
//			$order['referer'] 					= '';													//订单来源
			if(isset($_SESSION['svcart']['point']['point'])){
			$order['point_fee'] = $_SESSION['svcart']['point']['fee'];
			$order['point_use'] = $_SESSION['svcart']['point']['point'];
			}
			$order['order_code'] = $this->get_order_code();
			$order_code = $this->Order->findbyorder_code($order['order_code']);
			if(isset($order_code) && count($order_code) > 0){
				$order['order_code'] = $this->get_order_code();
			}
			
			$this->Order->save($order);
			$this->set("order_code",$order['order_code']);
			$order_id = $this->Order->id;
			$order['id'] = $order_id;
			$this->set('order_id',$order_id);
						//是否使用了积分
			if(isset($_SESSION['svcart']['point']['point'])){
				$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
				$user_info['User']['point'] -= $_SESSION['svcart']['point']['point'];
				$this->User->save($user_info);
				$point_log = array("id"=>"",
									"user_id" => $_SESSION['User']['User']['id'],
									"point" => $_SESSION['svcart']['point']['point'],
									"log_type" => "O",
									"type_id" => $order_id
									);
				$this->UserPointLog->save($point_log);
			}
			
			if(isset($_SESSION['svcart']['packagings'])){
					$sum_packagings = 0;
					foreach($_SESSION['svcart']['packagings'] as $k=>$v){
					$orderpackaging = array();
					$orderpackaging['id'] = '';
					$orderpackaging['order_id'] = $order_id;
					$orderpackaging['packaging_id'] = $v['Packaging']['id'];
					$orderpackaging['packaging_name'] = $v['PackagingI18n']['name'];
					$orderpackaging['packaging_fee'] = $v['Packaging']['fee'];
					$orderpackaging['packaging_quantity'] = $v['quantity'];
					$sum_packagings += $v['Packaging']['fee'];
					if(isset($v['Packaging']['note'])){
						$orderpackaging['note'] = $v['Packaging']['note'];
					}
					$this->OrderPackaging->save(array('OrderPackaging'=>$orderpackaging));
					unset($orderpackaging);
				}
			}
			
			if(isset($_SESSION['svcart']['cards'])){
					$sum_cards = 0;
				foreach($_SESSION['svcart']['cards'] as $k=>$v){
					$ordercard = array();
					$ordercard['id'] = '';
					$ordercard['order_id'] = $order_id;
					$ordercard['card_id'] = $v['Card']['id'];
					$ordercard['card_name'] = $v['CardI18n']['name'];
					$ordercard['card_fee'] = $v['Card']['fee'];
					$sum_cards += $v['Card']['fee'];
					$ordercard['card_quantity'] = $v['quantity'];
					if(isset($v['Card']['note'])){
						$ordercard['note'] = $v['Card']['note'];
					}
					$this->OrderCard->save(array('OrderCard'=>$ordercard));
					unset($ordercard);
				}
			}

			$product_point = 0;
			$is_show_virtual_msg = 0;
			$send_coupon = array();
			foreach($_SESSION['svcart']['products'] as $k=>$v)
			{
				$product_point += $v['Product']['point']*$v['quantity'];
				$orderproduct = array();
				$orderproduct['id'] = '';
				$orderproduct['order_id'] = $order_id;
				$orderproduct['product_id'] = $v['Product']['id'];
				$orderproduct['product_name'] = $v['ProductI18n']['name'];
				$orderproduct['product_code'] = $v['Product']['code'];
				$orderproduct['product_quntity'] = $v['quantity'];
				$orderproduct['extension_code'] = $v['Product']['extension_code'];
				if($v['Product']['coupon_type_id'] > 0){
					$send_coupon[] = $v['Product']['coupon_type_id'];
				}
				if($v['Product']['extension_code'] == "virtual_card"){
					$check_virtual_product = $this->Product->findbyid($v['Product']['id']);
					if($check_virtual_product['Product']['quantity'] < $v['quantity']){
						$is_show_virtual_msg = 1;
					}
				}
				if(isset($v['Product']['note'])){
					$orderproduct['note'] = $v['Product']['note'];
				}
				if(isset($v['product_rank_price'])){
						$price = $v['product_rank_price'];
				}else if(isset($v['is_promotion'])){
					if($v['is_promotion'] == 1){
						$price = $v['Product']['promotion_price'];
					}else{
						$price = $v['Product']['shop_price'];
					}
				}
				$orderproduct['product_price'] = $price;
				if(isset($this->configs['enable_decrease_stock_time']) && $this->configs['enable_decrease_stock_time'] == 1){
					$update_proudct = $this->Product->findbyid($v['Product']['id']);
					$update_proudct['Product']['sale_stat'] += $v['quantity'];
					$update_proudct['Product']['quantity'] -=$v['quantity'];
					$this->Product->save($update_proudct);
				}
				$orderproduct['product_attrbute'] = '';												
				$this->OrderProduct->save(array('OrderProduct'=>$orderproduct));					//暂时没有商品属性
				unset($orderproduct);
			}
			$this->set('is_show_virtual_msg',$is_show_virtual_msg);
			//pr($product_point);
			if(isset($_SESSION['svcart']['coupon']['coupon'])){
				$coupon = $this->Coupon->findbyid($_SESSION['svcart']['coupon']['coupon']);
				$this->CouponType->set_locale($this->locale);
				$coupon_type = $this->CouponType->findbyid($coupon['Coupon']['coupon_type_id']);
				if($coupon_type['CouponType']['send_type'] == 5){
					$coupon['Coupon']['max_use_quantity'] += 1;
				}else{
					$coupon['Coupon']['user_id'] = $_SESSION['User']['User']['id'];
					$coupon['Coupon']['order_id'] = $order_id;
					$coupon['Coupon']['used_time'] = $now;
				}
				$this->Coupon->save($coupon['Coupon']);
			}
			$update_order = $this->Order->findbyid($order_id);
			if(isset($sum_cards)){
				$update_order['Order']['card_fee'] = $sum_cards;
			}
			if(isset($sum_packagings)){
				$update_order['Order']['pack_fee'] = $sum_packagings;
			}
			$this->Order->save($update_order);
			//促销活动 商品
			if(isset($_SESSION['svcart']['Product_by_Promotion']) && count($_SESSION['svcart']['Product_by_Promotion'])>0){
				
				foreach($_SESSION['svcart']['Product_by_Promotion'] as $k=>$v){
					$orderproduct = array();
					$orderproduct['id'] = '';
					$orderproduct['order_id'] = $order_id;
					$orderproduct['product_id'] = $k;
					if(isset($orderproduct['product_id'])){
					//$pro_product =$this->Product->findbyid($orderproduct['product_id']);
						$orderproduct['product_name'] = $v['ProductI18n']['name'];
					}
					$orderproduct['product_code'] = $v['Product']['code'];
					$orderproduct['product_quntity'] = "1";  //暂时为1				
					$orderproduct['product_price'] = $v['Product']['now_fee'];
					$orderproduct['product_attrbute'] = '';	
					//$order['subtotal'] +=	$orderproduct['product_price'];
					$this->OrderProduct->save(array('OrderProduct'=>$orderproduct));
					unset($orderproduct);
				}
				//$this->Order->save($order);
			}
			if($_SESSION['svcart']['payment']['code'] == "account_pay"){
				//减用户金额
				$user_info = $this->User->findbyid($update_order['Order']['user_id']);
				$user_info['User']['balance'] -= $_SESSION['svcart']['cart_info']['total'];
				$this->User->save($user_info);
				//UserBalanceLog
				$balance_log = array(
			   						"id"=>'',
			   						"user_id"=>$user_info['User']['id'],
			   						"amount"=>$_SESSION['svcart']['cart_info']['total'],
			   						"log_type" => "O",
			   						"type_id"=>$order_id
			   						);
			   $this->UserBalanceLog->save($balance_log);				
			   //如果是余额支付  付款送积分
			   
				// 超过订单金额赠送积分
				if($this->configs['order_smallest'] <= $update_order['Order']['subtotal']){
					$user_info = $this->User->findbyid($update_order['Order']['user_id']);
					$user_info['User']['point'] += $this->configs['out_order_points'];
					$this->User->save($user_info);
					$point_log = array("id"=>"",
										"user_id" => $update_order['Order']['user_id'],
										"point" => $this->configs['out_order_points'],
										"log_type" => "B",
										"type_id" => $update_order['Order']['id']
										);
					$this->UserPointLog->save($point_log);
				}
							//下单是否送积分
				if($this->configs['order_gift_points'] == 1){
					$user_info = $this->User->findbyid($update_order['Order']['user_id']);
					$user_info['User']['point'] += $this->configs['order_points'];
					$this->User->save($user_info);
					$point_log = array("id"=>"",
										"user_id" => $update_order['Order']['user_id'],
										"point" => $this->configs['order_points'],
										"log_type" => "B",
										"type_id" => $update_order['Order']['id']
										);
					$this->UserPointLog->save($point_log);
				} 
				// 商品送积分
				//$order_total['Order']['id']
	            if($product_point>0){
					$user_info = $this->User->findbyid($update_order['Order']['user_id']);
					$user_info['User']['point'] += $product_point;
					$this->User->save($user_info);
					$point_log = array("id"=>"",
										"user_id" => $update_order['Order']['user_id'],
										"point" => $product_point,
										"log_type" => "B",
										"type_id" => $update_order['Order']['id']
										);
					$this->UserPointLog->save($point_log);
	            }		
	            //是否送优惠券
	            if(isset($this->configs['send_coupons']) && $this->configs['send_coupons'] == 1){
	          	 	$this->CouponType->set_locale($this->locale);
	            	$order_coupon_type = $this->CouponType->findall("CouponType.send_type = 2 and CouponType.send_start_date <= '".$now."' and CouponType.send_end_date >= '".$now."'");
	            	if(is_array($order_coupon_type) && sizeof($order_coupon_type)>0){
						$coupon_arr = $this->Coupon->findall("1=1",'DISTINCT Coupon.sn_code');
						$coupon_count = count($coupon_arr);
						$num = 0;
						if($coupon_count > 0){
							$num = $coupon_arr[$coupon_count - 1]['Coupon']['sn_code'];
						}         		
	            		
	            		foreach($order_coupon_type as $k=>$v){
	            			if($v['CouponType']['min_products_amount'] < $update_order['Order']['subtotal']){
		            			if(isset($coupon_sn)){
									$num = $coupon_sn;
								}
								$num = substr($num,2, 10);
								$num = $num ? floor($num / 10000) : 100000;
								$coupon_sn = $v['CouponType']['prefix'].$num.str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);	   
		            			$order_coupon = array(
		            								'id' => '',
		            								'coupon_type_id' => $v['CouponType']['id'],
		            								'user_id' => $_SESSION['User']['User']['id'],
		            								'sn_code' => $coupon_sn
		            								);
		            			$this->Coupon->save($order_coupon);
		            		}
	            		}
	            	}// order send end
	            	
	            	if(is_array($send_coupon) && sizeof($send_coupon)>0){
						$coupon_arr = $this->Coupon->findall("1=1",'DISTINCT Coupon.sn_code');
						$coupon_count = count($coupon_arr);
						$num = 0;
						if($coupon_count > 0){
							$num = $coupon_arr[$coupon_count - 1]['Coupon']['sn_code'];
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
	            								'user_id' => $_SESSION['User']['User']['id'],
	            								'sn_code' => $coupon_sn
	            								);
	            			$this->Coupon->save($pro_coupon);
	            		}
	            	}
	            }
	            
	            		
			}
			
			$pay_log = array();
			$pay_log['payment_code'] = $pay['Payment']['code'];
			$pay_log['type'] = 0;
			$pay_log['type_id'] = $order['id'];
			$pay_log['amount'] = $order['total'];
			$pay_log['is_paid'] = 0;
			$this->PaymentApiLog->save($pay_log);
			$order['log_id'] = $this->PaymentApiLog->id;
			
			$pay_php = $pay['Payment']['php_code'];
			
			if($pay['Payment']['code'] == "alipay"){  //支付宝
				eval($pay_php);    // - -! 执行数据库取出的php代码
				$pay_class = new alipay();	
				$url = $pay_class->get_code($order,$pay,$this);
				
				$this->set('pay_button',$url);
			}
			
			if($pay['Payment']['code'] == "chinapay"){  //银联电子支付
				eval($pay_php);
				$pay_class = new chinapay();	
				$form = $pay_class->get_code($order,$pay);
				$this->set('pay_form',$form);
			}

			if($pay['Payment']['code'] == "bank"){  //银行转账
				eval($pay_php);
				$pay_message = $pay['PaymentI18n']['description'];
				$this->set('pay_message',$pay_message);
			}
			
			if($pay['Payment']['code'] == "post"){  //邮局汇款
				eval($pay_php);
				$pay_message = $pay['PaymentI18n']['description'];
				$this->set('pay_message',$pay_message);
			}
			if($pay['Payment']['code'] == "paypalcn"){  //贝宝
				eval($pay_php);
				$pay_message = $pay['PaymentI18n']['description'];
				$pay_class = new paypal();	
				$form = $pay_class->get_code($order,$pay,$this);
				$this->set('pay_form',$form);
			}
			if($pay['Payment']['code'] == "paypal"){  //贝宝
				eval($pay_php);
				$pay_message = $pay['PaymentI18n']['description'];
				$pay_class = new paypal();	
				$form = $pay_class->get_code($order,$pay,$this);
				$this->set('pay_form',$form);
			}
			unset($_SESSION['svcart']);
			$this->Cookie->del('cart_cookie'); 
		
		}else{
			$this->set('error_arr',$error_arr);
		}
			$this->page_init();
			$this->pageTitle = $this->languages['confirm'].$this->languages['order']." - ".$this->configs['shop_title'];
			$this->layout = 'default_full';
	}
	
	function svcart_save(){
		$svcart=array();
		$svcart['products']=$_SESSION['svcart']['products'];
		$svcart['cart']['subtotal'] = 0; //商品现价小计
		$svcart['cart']['market_subtotal'] = 0; //商品市场价小计

		if(is_array($svcart['products'])){
			$categories = $this->Category->findassoc();
			$brands = $this->Brand->findassoc();
			
			foreach($svcart['products'] as $k=>$p){
				$_SESSION['svcart']['products'][$product_id]['CategoryInfo'] = $this->Category->findbyid($product_info['ProductsCategory']['id']);
				$_SESSION['svcart']['products'][$product_id]['BrandInfo'] = $this->Brand->findbyid($product_info['Product']['brand_id']);
				
				if($product_info['is_promotion'] == 1)
					$_SESSION['svcart']['products'][$product_id]['subtotal'] = $product_info['Product']['promotion_price']*$product_info['quantity'];//小计
				else
					$_SESSION['svcart']['products'][$product_id]['subtotal'] = $product_info['Product']['shop_price']*$product_info['quantity'];//小计
				
				//原合计
				$_SESSION['svcart']['products'][$product_id]['market_subtotal'] = $product_info['Product']['market_price']*$product_info['quantity'];
				//总现合计
				$_SESSION['svcart']['cart_info']['now_count_fee'] += $_SESSION['svcart']['products'][$product_id]['subtotal'];
				//总原合计
				$_SESSION['svcart']['cart_info']['market_count_fee'] += $_SESSION['svcart']['products'][$product_id]['market_subtotal'];
			}
		}
		
		//总折扣
		$_SESSION['svcart']['cart_info']['discount_price'] = round($_SESSION['svcart']['cart_info']['now_count_fee']/$_SESSION['svcart']['cart_info']['market_count_fee'],2)*100 ;
		//总节省
		$_SESSION['svcart']['cart_info']['save_price'] = $_SESSION['svcart']['cart_info']['market_count_fee'] - $_SESSION['svcart']['cart_info']['now_count_fee'];	
	}

	function ajax_page_init(){
		
		//分类信息
		$this->Category->set_locale($this->locale);
		$this->Category->tree('P',0);
		$this->set('categories', $this->Category->allinfo['assoc']);
		//品牌信息
		$this->Brand->set_locale($this->locale);
		$this->set('brands',$this->Brand->findassoc());
	}
	
	function confirm_address(){
	//	$_POST['address_id']=41;
		$result=array();
		if(isset($_SESSION['User']['User']['id'])){
			$address = $this->UserAddress->findbyid($_POST['address_id']);
			if($address['UserAddress']['user_id'] == $_SESSION['User']['User']['id']){
				$addresses_count = $this->UserAddress->find("count",array('conditions' =>"UserAddress.user_id = '".$_SESSION['User']['User']['id']."'"));
				$_SESSION['svcart']['address'] = $address['UserAddress'];
				$result['type']=0;
				$this->Region->set_locale($this->locale);
					$region_array = explode(" ",trim($address['UserAddress']['regions']));
					$address['UserAddress']['regions'] = "";
					foreach($region_array as $k=>$region_id){
						$region_info = $this->Region->findbyid($region_id);
						if($k < sizeof($region_array)-1){
							$address['UserAddress']['regions'] .= $region_info['RegionI18n']['name']." ";
						}else{
							$address['UserAddress']['regions'] .= $region_info['RegionI18n']['name'];
						}
					}
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

				if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
					$weight = 0;
					foreach($_SESSION['svcart']['products'] as $k=>$v){
						$weight += $v['Product']['weight'];
					}
				}
				//通过地址找配送方式
				$this->show_shipping_by_address($_POST['address_id'],$weight);
				$this->set('address',$address);
				$this->set('svcart',$_SESSION['svcart']);
				$this->set('addresses_count',$addresses_count);
			}else{
				$result['type']=1;
				$result['message']=$this->languages['invalid_address'];
			}
			/* 判断是否需要显示配送方式 */
			if((isset($_SESSION['svcart']['cart_info']['all_virtual']) && $_SESSION['svcart']['cart_info']['all_virtual']==0) 
				|| (isset($_SESSION['svcart']['promotion']['all_virtual']) && $_SESSION['svcart']['promotion']['all_virtual'] == 0))
				$this->set('all_virtual',0);
			else $this->set('all_virtual',1);
		//	pr($_SESSION['svcart']['address']);
			$this->set('result',$result);
			$this->layout = 'ajax';
		}
	}
	
	function confirm_shipping(){
	//	$_POST['address_id']=41;
		$result=array();
		if(isset($_SESSION['User']['User']['id'])){
			$payment_fee = 0 ;
			$shipping_type = 0;
	//		if(isset($_SESSION['svcart']['payment']['payment_fee'])){
	//			$payment_fee = $_SESSION['svcart']['payment']['payment_fee'];
	//		}
	//		$_SESSION['svcart']['cart_info']['shipping_fee'] = $_SESSION['svcart']['shipping']['shipping_fee'];
	//		$_SESSION['svcart']['cart_info']['total'] = $_SESSION['svcart']['shipping']['shipping_fee']+$_SESSION['svcart']['cart_info']['sum_subtotal']+$payment_fee;
	//		pr($_POST['support_cod']."-".$_SESSION['svcart']['payment']['is_cod']);
			if(isset($_SESSION['svcart']['payment']['is_cod']) && $_POST['support_cod'] == 0 &&  $_SESSION['svcart']['payment']['is_cod'] == 1){
				$result['type'] = 1;
				$result['message'] = $this->languages['shipping_no_support'];
			}else{
				$_SESSION['svcart']['shipping'] = $_POST;
				if($_SESSION['svcart']['shipping']['free_subtotal']>0 && $_SESSION['svcart']['shipping']['free_subtotal'] < $_SESSION['svcart']['cart_info']['sum_subtotal']){
					$_SESSION['svcart']['shipping']['shipping_fee'] = 0;
				}else{
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['shipping']['shipping_fee'];
				}
				//$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['shipping']['free_subtotal'];
				//$_SESSION['svcart']['shipping']['shipping_fee'] -= $_SESSION['svcart']['shipping']['free_subtotal'];
				$result['type'] = 0;
				$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
			
				$this->set('svcart',$_SESSION['svcart']);
				$this->set('shipping_type',$shipping_type);
			}
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function edit_address(){
		if($this->RequestHandler->isPost()){
			$address = $this->UserAddress->findbyid($_POST['id']);
			$tel = $address['UserAddress']['telephone'];
        	$arr = explode("-",$tel);
			if(isset($arr) && count($arr)>1){
			$this->set('tel_arr',$arr);
			}else{
			$tel_arr =array();
			$tel_arr[1] = $tel;
			$this->set('tel_arr',$tel_arr);
			}
			$result['type'] = 1;
			if(isset($address)){
				$result['id'] = $_POST['id'];
				$result['type'] = 0;
				$result['str'] = $address['UserAddress']['regions'];
				$this->set('address',$address);
			}
			/* 判断是否需要显示配送方式 */
			if((isset($_SESSION['svcart']['cart_info']['all_virtual']) && $_SESSION['svcart']['cart_info']['all_virtual']==0) 
				|| (isset($_SESSION['svcart']['promotion']['all_virtual']) && $_SESSION['svcart']['promotion']['all_virtual'] == 0))
				$result['all_virtual'] = 0;
			else $result['all_virtual'] = 1;
			$this->set('result',$result);
			$this->layout = 'ajax';
		}
	}
	
	function edit_address_act(){
		if($this->RequestHandler->isPost()){
			$result['type'] = 1;
			$address=(array)json_decode(StripSlashes($_POST['address']));
			if(isset($address)){
				$address['user_id']=$_SESSION['User']['User']['id'];
				$this->UserAddress->save($address);
				$result['type'] = 0;
				$result['id'] = $this->UserAddress->id;
			}
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

			if(isset($_SESSION['svcart']['shipping']['shipping_fee'])){
				unset($_SESSION['svcart']['shipping']['shipping_fee']);
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

			}
			$this->set('svcart',$_SESSION['svcart']);
			$this->set('result',$result);
			$this->layout = 'ajax';
		}
	}
	
	//加地址
	function checkout_address_add(){
		$result=array();
//		$result['type']=1;
		if($this->RequestHandler->isPost()){
			if(isset($_SESSION['User']['User']['id'])){
				$address=(array)json_decode(StripSlashes($_POST['address']));
				$address['user_id']=$_SESSION['User']['User']['id'];
				$this->UserAddress->save($address);
				$result['type']=0;
				$result['id']=$this->UserAddress->id;
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
				
			}else{
				$result['type']=1;
				$result['message']=$this->languages['time_out_relogin'];
			}
		}
		if(isset($_SESSION['svcart']['shipping']['shipping_fee'])){
			unset($_SESSION['svcart']['shipping']['shipping_fee']);
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

		}
		$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
	}

	function show_shipping_by_address($id,$weight){
		//取得可用的配送方式
		$address = $this->UserAddress->findbyid($id);
		//$this->Region->set_locale($this->locale); 
		$region = $this->Region->findall();
		$region_ids = explode(" ",trim($address['UserAddress']['regions']));
	//	$region_ids=$this->Region->strtoids($address['UserAddress']['regions']);
		//print_r($region_ids); //1 10 110
		//$last_name = array_pop(explode(" ",trim($address['UserAddress']['regions'])));
		//print("<br />".$last_name); shanghai
		$shipping_area_region_ids = $this->ShippingAreaRegion->find("list",array("conditions"=>array("ShippingAreaRegion.region_id" =>$region_ids)));

		foreach($shipping_area_region_ids as $shipping_area_region_id){
			$shipping_area_region =  $this->ShippingAreaRegion->findbyid($shipping_area_region_id);
			$shipping_area_ids[$shipping_area_region_id] = $shipping_area_region['ShippingAreaRegion']['shipping_area_id'];
		}
		if(isset($shipping_area_ids)){
			$shipping_areas = $this->ShippingArea->findall(array("id"=>$shipping_area_ids),null,"shipping_id,orderby");
		}
		$shipping_ids =array();
		if(isset($shipping_areas)){
			foreach($shipping_areas as $k=> $v){
				if(!isset($shipping_ids[$v['ShippingArea']['shipping_id']])){
					$shipping_ids[$v['ShippingArea']['shipping_id']]= $v['ShippingArea']['shipping_id'];
					$shipping_areas_distinct[$v['ShippingArea']['shipping_id']]=$v['ShippingArea'];
				}
			}
		}
		$this->ShippingAreaRegion->findall();
		if(isset($shipping_ids) && sizeof($shipping_ids)>0){
			$this->Shipping->set_locale($this->locale);
			$shippings = $this->Shipping->findall(array("Shipping.status" => '1',"Shipping.id"=>$shipping_ids),'','Shipping.orderby asc');
			foreach($shippings as $k=> $v){
			//	pr($shipping_areas_distinct[$v['Shipping']['id']]);
				$shippings[$k]['ShippingArea'] = $shipping_areas_distinct[$v['Shipping']['id']];
				$shippings[$k]['ShippingArea']['fee'] = $this->ShippingArea->fee_calculation($weight,$shipping_areas_distinct[$v['Shipping']['id']],$_SESSION['svcart']['cart_info']['sum_subtotal']);
			}
			//	pr($shippings);
		$this->set('shipping_type',1);
		if(isset($shippings) && sizeof($shippings) == 1){
				$_SESSION['svcart']['shipping'] = array(
														'shipping_id' => $shippings[0]['Shipping']['id'],
														'shipping_fee' => $shippings[0]['ShippingArea']['fee'],
														'shipping_name' => $shippings[0]['ShippingI18n']['name'],
														'free_subtotal' =>  $shippings[0]['ShippingArea']['free_subtotal'],
														'support_cod' => $shippings[0]['Shipping']['support_cod'],
														'not_show_change' => '1',
														'shipping_description' => $shippings[0]['ShippingI18n']['description']
														);
				if($_SESSION['svcart']['shipping']['free_subtotal']>0 && $_SESSION['svcart']['shipping']['free_subtotal'] < $_SESSION['svcart']['cart_info']['sum_subtotal']){
					$_SESSION['svcart']['shipping']['shipping_fee'] = 0;
				}else{
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['shipping']['shipping_fee'];
				}
			$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
		}
		$this->set('shippings',$shippings);
		}else{
			$this->set('shippings','nothing');
		}
	}
	
	function confirm_payment(){
		$result=array();
		if(isset($_SESSION['User']['User']['id'])){
		//	$payment_total = $_POST;  ??
			$shipping_fee = 0;
		//	if(isset($_SESSION['svcart']['shipping']['shipping_fee'])){
		//		$shipping_fee = $_SESSION['svcart']['shipping']['shipping_fee'];
		//	}
		//	$_SESSION['svcart']['cart_info']['payment_fee'] = $_SESSION['svcart']['payment']['payment_fee'];
		//	$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['payment']['payment_fee']+$_SESSION['svcart']['cart_info']['sum_subtotal']+$shipping_fee;
			/* 该判断增加了全部购买物品为虚拟物品的判断 */
			//||( $_POST['is_cod']>0 && $_SESSION['svcart']['cart_info']['all_virtual'])
			
			if($_POST['is_cod']>0 && $_SESSION['svcart']['cart_info']['all_virtual']){
				$result['type'] = 1;
				$result['message'] = $this->languages['payment_no_support'];
			}else if((isset($_SESSION['svcart']['shipping']['support_cod']) && $_POST['is_cod']== 1 && $_SESSION['svcart']['shipping']['support_cod'] == 0)){
				$result['type'] = 1;
				$result['message'] = $this->languages['payment_no_support'];
			}else if($_POST['code'] == "account_pay"){
				$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
				if($_SESSION['svcart']['cart_info']['total'] <= $user_info['User']['balance']){
					$_SESSION['svcart']['payment'] = $_POST;
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['payment']['payment_fee'];
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
				
					$result['type'] = 0;
					$this->set('svcart',$_SESSION['svcart']);
				}else{
					$result['type'] = 1;
					$result['message'] = $this->languages['lack_balance_supply_first'];
				}
			}else{
			$_SESSION['svcart']['payment'] = $_POST;
			$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['payment']['payment_fee'];
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
					
			$result['type'] = 0;
			$this->set('svcart',$_SESSION['svcart']);
			}
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function change_shipping(){
		if(isset($_SESSION['User']['User']['id'])){
			if(isset($_SESSION['svcart']['shipping']['shipping_fee'])){
			
			if($_SESSION['svcart']['shipping']['free_subtotal'] < $_SESSION['svcart']['cart_info']['sum_subtotal']){
				$_SESSION['svcart']['shipping']['shipping_fee'] = 0;
			}else{
				$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['shipping']['shipping_fee'];
			}				
			//$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['shipping']['free_subtotal'];
			unset($_SESSION['svcart']['shipping']);
				$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
			}
			if(isset($_SESSION['svcart']['address'])){
				if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
					$weight = 0;
					foreach($_SESSION['svcart']['products'] as $k=>$v){
						$weight += $v['Product']['weight'];
					}
				}				
				$this->show_shipping_by_address($_SESSION['svcart']['address']['id'],$weight);
				$result['type'] = 0;
			}else{
				$result['type'] = 1;
				$result['message'] = $this->languages['no_shipping_method'];
			}			
		}

		$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function change_payment(){
		if(isset($_SESSION['User']['User']['id'])){
			if(isset($_SESSION['svcart']['payment']['payment_fee'])){
				$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['payment']['payment_fee'];
				unset($_SESSION['svcart']['payment']);
			}
			
			$this->Payment->set_locale($this->locale);
			$payments = $this->Payment->availables();
			if(isset($payments)){
				$result['type'] = 0; 
				$this->set('payments',$payments);
			}else{
				$result['type'] = 1; 
				$result['message'] = $this->languages['no_paying_method'];
			}
		}
		if(isset($_SESSION['svcart']['payment']['payment_fee'])){
			unset($_SESSION['svcart']['payment']);
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

		}
		$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function add_note(){
		if($this->RequestHandler->isPost()){
			if($_POST['type'] == 'product'){
				$_SESSION['svcart']['products'][$_POST['id']]['Product']['note'] = $_POST['note'];
				$result['type'] = 0;
			}
		
			if($_POST['type'] == 'packaging'){
				$_SESSION['svcart']['packagings'][$_POST['id']]['Packaging']['note'] = $_POST['note'];
				$result['type'] = 0;
			}
			
			if($_POST['type'] == 'card'){
				$_SESSION['svcart']['cards'][$_POST['id']]['Card']['note'] = $_POST['note'];
				$result['type'] = 0;
			}
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function findpromotions($id=''){
		$info_subtotal = $_SESSION['svcart']['cart_info']['sum_subtotal'];
    //  $info_total = $_SESSION['svcart']['cart_info']['total'];
        $conditions = "1=1 and Promotion.status = 1 ";
        $now_time = date("Y-m-d H:i:s");
    	$conditions .= " and Promotion.start_time <= '".$now_time."'";
      	$conditions .= " and Promotion.end_time >= '".$now_time."'";
        $conditions .= " and Promotion.min_amount <= $info_subtotal ";
        $conditions .= " and Promotion.max_amount >= $info_subtotal ";
        if($id != ''){
        $conditions .= " and Promotion.id = $id ";
        }
        $this->Promotion->set_locale($this->locale);
                
        $promotions = $this->Promotion->findall($conditions,"","Promotion.orderby asc");
                //特惠品信息
        if(isset($promotions) && count($promotions)>0){
    		foreach($promotions as $k=>$v){
    			if($v['Promotion']['type'] == 2){
    		    	$PromotionProducts[$k] = $this->PromotionProduct->findallbypromotion_id($v['Promotion']['id']);
    				if(isset($PromotionProducts[$k]) && count($PromotionProducts[$k])>0){
    					//	$i = 0;
    						foreach($PromotionProducts[$k] as $key=>$value){
    						$this->Product->set_locale($this->locale);
    						$promotions[$k]['products'][$value['PromotionProduct']['product_id']] = $this->Product->findbyid($value['PromotionProduct']['product_id']);
    						$promotions[$k]['products'][$value['PromotionProduct']['product_id']]['Product']['now_fee'] = $value['PromotionProduct']['price'];
    					//	$p[$k][$i] = $promotions[$k]['products'][$key];
    						//$i++;
    					}
    				}
    			}
    		}
    	}
    	return $promotions;
	}
	
	function confirm_promotion(){
		if($this->RequestHandler->isPost()){
			if($_POST['type'] == 0){
				$_SESSION['svcart']['cart_info']['total'] -= $_POST['type_ext'];
				$result['type'] = 0;
			}
			if($_POST['type'] == 1){
				if(isset($_SESSION['svcart']['payment'])){
					$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['payment']['payment_fee'];
				}
				if(isset($_SESSION['svcart']['shipping'])){
					$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['shipping']['shipping_fee'];
				}
				if(isset($_SESSION['svcart']['point']['fee'])){
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['point']['fee'];
				}
				$_SESSION['svcart']['cart_info']['old_total'] = $_SESSION['svcart']['cart_info']['total'];
				$_SESSION['svcart']['cart_info']['total'] = round($_SESSION['svcart']['cart_info']['total']*$_POST['type_ext']/100,2);
				if(isset($_SESSION['svcart']['payment'])){
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['payment']['payment_fee'];
				}
				if(isset($_SESSION['svcart']['shipping'])){
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['shipping']['shipping_fee'];
				}
				$result['type'] = 0;
			}
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
			
			$result['promotion']['title'] = $_POST['title'];
			$result['promotion']['type'] = $_POST['type'];
			$result['promotion']['promotion_fee'] = $_POST['type_ext'];
			$result['promotion']['meta_description'] = $_POST['meta_description'];
			$_SESSION['svcart']['promotion'] = $result['promotion'];
		//	$_SESSION['svcart']['promotion']['promotion_fee'] = $_POST['type_ext'];
		}
		$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function change_promotion(){
		if($this->RequestHandler->isPost()){
			$promotions = $this->findpromotions();
			$result['type'] = 3;
			if(isset($_SESSION['svcart']['promotion']['type'])){
				if($_SESSION['svcart']['promotion']['type'] == 0){
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['promotion']['promotion_fee'];
					$result['type'] = 0;
				}
				if($_SESSION['svcart']['promotion']['type'] == 1){
					$_SESSION['svcart']['cart_info']['total'] = $_SESSION['svcart']['cart_info']['old_total'];
				if(isset($_SESSION['svcart']['payment'])){
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['payment']['payment_fee'];
				}
				if(isset($_SESSION['svcart']['shipping'])){
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['shipping']['shipping_fee'];
				}
				if(isset($_SESSION['svcart']['point']['fee'])){
					$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['point']['fee'];
				}				
					unset($_SESSION['svcart']['cart_info']['old_total']);
						$result['type'] = 0;
				}
				if($_SESSION['svcart']['promotion']['type'] == 2){
					if(isset($_SESSION['svcart']['Product_by_Promotion'])){
						$_SESSION['svcart']['promotion']['product_fee'] = 0;
						foreach($_SESSION['svcart']['Product_by_Promotion'] as $kkk=>$vvv){
							$_SESSION['svcart']['cart_info']['total'] -= $vvv['Product']['now_fee'];
							}
						}
				    	unset($_SESSION['svcart']['Product_by_Promotion']);
						$result['type'] = 0;
				}
				
			}else{
						$result['type'] = 3;
			}
		}
		unset($_SESSION['svcart']['promotion']);
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

		/* 判断是否需要显示配送方式 */
		if((isset($_SESSION['svcart']['cart_info']['all_virtual']) && $_SESSION['svcart']['cart_info']['all_virtual']==0) 
			|| (isset($_SESSION['svcart']['promotion']['all_virtual']) && $_SESSION['svcart']['promotion']['all_virtual'] == 0))
			$result['shipping_display'] = 1;
		else $result['shipping_display'] = 0;
		$this->set('promotions',$promotions);
		$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	//重选地址
	
    function change_address(){
    	//Configure::write('debug',2);
        if(isset($_SESSION['User']['User']['id'])){
            if($this->RequestHandler->isPost()){
                $addresses_count = $this->UserAddress->find("count",array('conditions' =>"UserAddress.user_id = '".$_SESSION['User']['User']['id']."'"));
                if($addresses_count == 1){
                    $result['type'] = 3;
                }else{
                    $addresses = $this->UserAddress->findAllbyuser_id($_SESSION['User']['User']['id']);
					foreach($addresses as $key=>$address){
					$region_array = explode(" ",trim($address['UserAddress']['regions']));
					$addresses[$key]['UserAddress']['regions'] = "";
						foreach($region_array as $k=>$region_id){
							$region_info = $this->Region->findbyid($region_id);
							if($k < sizeof($region_array)-1){
								$addresses[$key]['UserAddress']['regions'] .= $region_info['RegionI18n']['name']." ";
							}else{
								$addresses[$key]['UserAddress']['regions'] .= $region_info['RegionI18n']['name'];
							}
						}
					}                    
                    $result['type'] = 0;
                    $this->set('addresses',$addresses);
					unset($_SESSION['svcart']['address']);
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

						if(isset($_SESSION['svcart']['shipping']['shipping_fee'])){
						$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['shipping']['shipping_fee'];
						unset($_SESSION['svcart']['shipping']);
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

					}
					
                }
           	$this->set('svcart',$_SESSION['svcart']);
			$this->set('result',$result);
			$this->layout = 'ajax';
            }
        }
    }
    
    //选优惠品
    function add_promotion_product(){
    	if(isset($_SESSION['User']['User']['id'])){
        	if($this->RequestHandler->isPost()){
        		$result['type'] = 2;
				$this->Promotion->set_locale($this->locale);
				$promotions = $this->findpromotions($_POST['promotion_id']);
				foreach($promotions as $k=>$v){
					if($v['Promotion']['id'] == $_POST['promotion_id']){
						$result['promotion'] = $v;
						$result['promotion']['id'] = $v['Promotion']['id'];
						$result['promotion']['title'] = $v['PromotionI18n']['title'];
						$result['promotion']['meta_description'] = $v['PromotionI18n']['meta_description'];
						$result['promotion']['type'] = $v['Promotion']['type'];
						$_SESSION['svcart']['promotion']= $result['promotion'];
						if(isset($_SESSION['svcart']['Product_by_Promotion']) && count($_SESSION['svcart']['Product_by_Promotion'])>0){
							foreach($_SESSION['svcart']['Product_by_Promotion'] as $kk=>$vv){
								unset($result['promotion']['products'][$vv['Product']['id']]);
							}
						}
						
						if(isset($_SESSION['svcart']['Product_by_Promotion'])){
							if(count($_SESSION['svcart']['Product_by_Promotion'])+1 <= $v['Promotion']['type_ext']){
								foreach($v['products'] as $key=>$value){
									if($value['Product']['id'] == $_POST['product_id']){
										$_SESSION['svcart']['Product_by_Promotion'][$key] = $value;
										$_SESSION['svcart']['cart_info']['total'] += $value['Product']['now_fee'];
									
										unset($result['promotion']['products'][$key]);
									}
								}
								if(isset($_SESSION['svcart']['Product_by_Promotion'])){
									$_SESSION['svcart']['promotion']['product_fee'] = 0;
									$_SESSION['svcart']['promotion']['all_virtual'] = 1;//纯虚拟商品标记
									foreach($_SESSION['svcart']['Product_by_Promotion'] as $kkk=>$vvv){
										$_SESSION['svcart']['promotion']['product_fee'] += $vvv['Product']['now_fee'];
										$result['type'] = 0;
										$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
										
										if(empty($vvv['Product']['extension_code']))
											$_SESSION['svcart']['promotion']['all_virtual'] = 0;//纯虚拟商品标记
									}
								}
							}else{
								$result['type'] = 3;
							}
						}else{
							foreach($v['products'] as $key=>$value){
								if($value['Product']['id'] == $_POST['product_id']){
									$_SESSION['svcart']['Product_by_Promotion'][$key] = $value;
									$_SESSION['svcart']['cart_info']['total'] += $value['Product']['now_fee'];
									unset($result['promotion']['products'][$key]);
								}
							}
							if(isset($_SESSION['svcart']['Product_by_Promotion'])){
								$_SESSION['svcart']['promotion']['product_fee'] = 0;
								$_SESSION['svcart']['promotion']['all_virtual'] = 1;//纯虚拟商品标记
								foreach($_SESSION['svcart']['Product_by_Promotion'] as $kkk=>$vvv){
									$_SESSION['svcart']['promotion']['product_fee'] += $vvv['Product']['now_fee'];
									$result['type'] = 0;
									$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
										
									if(empty($vvv['Product']['extension_code']))
										$_SESSION['svcart']['promotion']['all_virtual'] = 0;//纯虚拟商品标记
								}
							}
						}
					}
				}
				/* 判断是否需要显示配送方式 */
				if((isset($_SESSION['svcart']['cart_info']['all_virtual']) && $_SESSION['svcart']['cart_info']['all_virtual']==0) 
					|| (isset($_SESSION['svcart']['promotion']['all_virtual']) && $_SESSION['svcart']['promotion']['all_virtual'] == 0))
					$result['shipping_display'] = 1;
				else $result['shipping_display'] = 0;
				
				$_SESSION['svcart']['promotion']['products'] = $result['promotion']['products'];
				$this->set('svcart',$_SESSION['svcart']);
				$this->set('result',$result);
				$this->layout = 'ajax';
        	}
        }
    }
    /*
    function select_coupon(){
    
    
    }*/
    
    function usecoupon(){
 		$result['type'] = 2;
 		$result['msg'] = $this->languages['use'].$this->languages['coupon'].$this->languages['failed'];
        if($this->RequestHandler->isPost()){
	    	$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
	    	if(isset($_POST['is_id'])){
			$_SESSION['svcart']['coupon']['is_id'] = 1;
	    	$coupon = $this->Coupon->findbyid($_POST['coupon']);
	    	}else{
	    	$coupon = $this->Coupon->findbysn_code($_POST['coupon']);
	    	}
			$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
	    	if(isset($coupon['Coupon'])){
	    		$now = date("Y-m-d H:i:s");
	    		$this->CouponType->set_locale($this->locale);
	    		$coupon_type = $this->CouponType->findbyid($coupon['Coupon']['coupon_type_id']);
	    		if($coupon_type['CouponType']['send_type'] == 5 && $coupon['Coupon']['max_buy_quantity'] <= $coupon['Coupon']['max_use_quantity']){
 					$result['type'] = 1;
 					$result['msg'] = $this->languages['coupon'].$this->languages['not_correct'];
	    		}else if($coupon_type['CouponType']['send_type'] == 3 && $coupon['Coupon']['order_id'] > 0){
 					$result['type'] = 1;
 					$result['msg'] = $this->languages['coupon'].$this->languages['not_correct'];
 	    		}else if($coupon_type['CouponType']['use_start_date'] <= $now && $coupon_type['CouponType']['use_end_date'] >= $now && $_SESSION['svcart']['cart_info']['sum_subtotal'] >= $coupon_type['CouponType']['min_amount']){
 					$result['type'] = 0;
	    			$result['point'] = $_POST['coupon'];
	    			$_SESSION['svcart']['coupon']['cha_fee'] = 0;
					$_SESSION['svcart']['coupon']['coupon'] = $coupon['Coupon']['id'];
					$_SESSION['svcart']['coupon']['sn_code'] = $coupon['Coupon']['sn_code'];
					$old = $_SESSION['svcart']['cart_info']['total'];
					$_SESSION['svcart']['cart_info']['total'] = round(($_SESSION['svcart']['cart_info']['total'] - $coupon_type['CouponType']['money'])*$coupon['Coupon']['order_amount_discount']/100,2);
					$_SESSION['svcart']['coupon']['cha_fee'] = $old - $_SESSION['svcart']['cart_info']['total'];
					$_SESSION['svcart']['coupon']['discount'] = $coupon['Coupon']['order_amount_discount'];
					$_SESSION['svcart']['coupon']['fee'] = $coupon_type['CouponType']['money'];

					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
													
	    		}else{
 					$result['type'] = 1;
 					if($_SESSION['svcart']['cart_info']['sum_subtotal'] < $coupon_type['CouponType']['min_amount']){
 						$result['msg'] = $this->languages['goods_amount_less_coupon_min'].sprintf($coupon_type['CouponType']['min_amount'],$this->configs['price_format']);	    		
	    			}else{
 						$result['msg'] = $this->languages['coupon'].$this->languages['not_correct'];
	    			}
	    		}
	    	}else{
 					$result['type'] = 1;
 					$result['msg'] = $this->languages['coupon'].$this->languages['not_correct'];
 	    	}
    	}
    	$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';    
    }
    
    
    function usepoint(){
 		$result['type'] = 2;
 		$result['msg'] = $this->languages['use'].$this->languages['point'].$this->languages['failed'];
        if($this->RequestHandler->isPost()){
	    	$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
			$can_use_point = round($_SESSION['svcart']['cart_info']['sum_subtotal']/100*$this->configs['proportion_point']);
			$product_use_point =0;
			foreach($_SESSION['svcart']['products'] as $k=>$v){
				$product_use_point += $v['Product']['point_fee']*$v['quantity'];
			}
			if($product_use_point < $can_use_point){
				$this->set('can_use_point',$product_use_point);
			}else{
				$this->set('can_use_point',$can_use_point);
			}
			$this->set('user_info',$user_info);
	    	$result['point'] = $_POST['point'];
			$_SESSION['svcart']['point']['point'] = $_POST['point'];
	    	$result['fee'] = $_POST['point']*$this->configs['conversion_ratio_point']/100;
	    	$_SESSION['svcart']['point']['fee'] = $_POST['point']*$this->configs['conversion_ratio_point']/100;
			$_SESSION['svcart']['cart_info']['total'] -= $_POST['point']*$this->configs['conversion_ratio_point']/100;
			$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 
    	
	    	$result['type'] = 0;
    	}
    	$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
    }
    
    
	function change_coupon(){
 		$result['type'] = 2;
 		$result['msg'] = $this->languages['use'].$this->languages['coupon'].$this->languages['failed'];
        if($this->RequestHandler->isPost()){

			if(isset($_SESSION['svcart']['coupon']['fee'])){
				$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['coupon']['cha_fee'];
			//	$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['coupon']['fee'];
			}
			unset($_SESSION['svcart']['coupon']);
			$coupons = $this->Coupon->findall('Coupon.user_id ='.$_SESSION['User']['User']['id'].' and Coupon.order_id = 0');
			if(is_array($coupons) && sizeof($coupons) >0){
				$this->CouponType->set_locale($this->locale);
				foreach($coupons as $k=>$v){
					$coupon_type = $this->CouponType->findbyid($v['Coupon']['coupon_type_id']);
					$coupons[$k]['Coupon']['name'] = $coupon_type['CouponTypeI18n']['name'];
					$coupons[$k]['Coupon']['fee'] = $coupon_type['CouponType']['money'];
				}
				$this->set('coupons',$coupons);
			}
			$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

    		$result['type'] = 0;
    	}
    	$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
    }    
    
    
    
    function change_point(){
 		$result['type'] = 2;
 		$result['msg'] = $this->languages['use'].$this->languages['point'].$this->languages['failed'];
        if($this->RequestHandler->isPost()){
	    	$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
				$use_point=0;
				$use_point = round($_SESSION['svcart']['cart_info']['sum_subtotal']/100*$this->configs['proportion_point']);
				//pr($_SESSION['svcart']['products']);
				$product_use_point =0;
			if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
				foreach($_SESSION['svcart']['products'] as $k=>$v){
					$product_use_point += $v['Product']['point_fee']*$v['quantity'];
				}
			}
			if($product_use_point < $use_point){
				$this->set('can_use_point',$product_use_point);
			}else{
				$this->set('can_use_point',$use_point);
			}
			$this->set('user_info',$user_info);
			if(isset($_SESSION['svcart']['point']['fee'])){       	
				$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['point']['fee'];
			}
			unset($_SESSION['svcart']['point']);
			$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

    		$result['type'] = 0;
    	}
    	$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
    }
    
    function checkout_order(){
    	$result['type'] = 0;
    	$error_arr = array();
    	if($this->RequestHandler->isPost()){	
			if(isset($_SESSION['User'])){
	    		if(!(isset($_SESSION['svcart']['products']))){
	    							$result['type'] = 2;
	    			$error_arr[] =$this->languages['no_products_in_cart'];
	    		}
	    		/* 增加纯虚拟商品判断 */
				if(!isset($_SESSION['svcart']['shipping']['shipping_id'])
					&&(empty($_SESSION['svcart']['cart_info']['all_virtual'])||(isset($_SESSION['svcart']['promotion']['all_virtual'])&&empty($_SESSION['svcart']['promotion']['all_virtual'])))){
									$result['type'] = 2;
					$error_arr[] = $this->languages['please_choose'].$this->languages['shipping_method'];
				}
				if(!isset($_SESSION['svcart']['payment']['payment_id'])){
									$result['type'] = 2;
					$error_arr[] = $this->languages['please_choose'].$this->languages['payment'];
				}
				if(isset($this->configs['min_buy_amount'])){
					if($_SESSION['svcart']['cart_info']['total'] < $this->configs['min_buy_amount']){
										$result['type'] = 2;
						$error_arr[] = $this->languages['order_amount_under_min'];
					}
				}	
				$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
				if(isset($_SESSION['svcart']['payment']['payment_id']) && isset($_SESSION['svcart']['products']) && $_SESSION['svcart']['payment']['code'] == "account_pay" && $_SESSION['svcart']['cart_info']['total'] > $user_info['User']['balance']){
						$error_arr[] = $this->languages['lack_balance_supply_first'];
						$result['type'] = 2;
				}
				if(empty($_SESSION['svcart']['address']) || $_SESSION['svcart']['address']['consignee'] == ""){//虚拟商品同样处理
						$error_arr[] = $this->languages['consignee'].$this->languages['name'].$this->languages['can_not_empty'];
						$result['type'] = 2;
				}
				if(isset($_SESSION['svcart']['address']) && $_SESSION['svcart']['address']['regions'] == "" && (empty($_SESSION['svcart']['cart_info']['all_virtual'])||(isset($_SESSION['svcart']['promotion']['all_virtual'])&&empty($_SESSION['svcart']['promotion']['all_virtual'])))){
						$error_arr[] = $this->languages['please_choose'].$this->languages['area'];
						$result['type'] = 2;
				}
				if(isset($_SESSION['svcart']['coupon']['coupon'])){
	    				$coupon = $this->Coupon->findbyid($_SESSION['svcart']['coupon']['coupon']);
	    				$this->CouponType->set_locale($this->locale);
	    				$coupon_type = $this->CouponType->findbyid($coupon['Coupon']['coupon_type_id']);
	    				$now = date("Y-m-d H:i:s");
						if($coupon_type['CouponType']['send_type'] == 5 && $coupon['Coupon']['max_buy_quantity'] <= $coupon['Coupon']['max_use_quantity']){
		 					$error_arr[] = $this->languages['coupon'].$this->languages['not_correct'];
							$result['type'] = 2;
			    		}else if($coupon_type['CouponType']['send_type'] == 3 && $coupon['Coupon']['order_id'] > 0){
		 					$error_arr[] = $this->languages['coupon'].$this->languages['not_correct'];
							$result['type'] = 2;
 	    				}else if($coupon['Coupon']['order_id'] > 0){
		 					$error_arr[] = $this->languages['coupon'].$this->languages['not_correct'];
							$result['type'] = 2;
 	    				}			    				
				}
				if(isset($_SESSION['svcart']['point']['point'])){
	    				$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
						
						if($user_info['User']['point'] < $_SESSION['svcart']['point']['point']){
		 					$error_arr[] = $this->languages['exceed_max_value_can_use'];
							$result['type'] = 2;
 	    				}			    				
				}				
				
			//	pr($_SESSION['svcart']['address']);
			}else{
				$result['type'] = 1;
				$result['message'] .=$this->languages['time_out_relogin'];
			}
		}
		$this->set('error_arr',$error_arr);
		$this->set('result',$result);
		$this->layout="ajax";
    }
    
    function add_remark(){
    	$result['type'] = 2;
 		$result['msg'] = $this->languages['add'].$this->languages['remark'].$this->languages['failed'];
    	if($this->RequestHandler->isPost()){	
			if(isset($_SESSION['User'])){
				$_SESSION['svcart']['order_remark'] = $_POST['order_note'];
				$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

				$result['type'] = 0;
			}else{
				$result['type'] = 1;
				$result['msg'] .=$this->languages['time_out_relogin'];
			}
		}
		$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout="ajax";
    }
    
    function change_remark(){
    	$result['type'] = 2;
    	if($this->RequestHandler->isPost()){	
			if(isset($_SESSION['User'])){
				unset($_SESSION['svcart']['order_remark']);
					$this->Cookie->write('cart_cookie',serialize($_SESSION['svcart']),false,time()+3600 * 24 * 365); 

				$result['type'] = 0;			
			}else{
				$result['type'] = 1;
				$result['msg'] .=$this->languages['time_out_relogin'];
			}
		}
		$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout="ajax";    
    }
   	
    function get_order_code()
	{
	    mt_srand((double) microtime() * 1000000);
		$sn=date('Ymd') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
		$a = 0;
		$b = 0;
		$c = 0;
		for($i=1;$i<=12;$i++){
			if($i%2){
				$b += substr($sn,$i-1,1);
			}else{
				$a += substr($sn,$i-1,1);
			}
		}

		$c = (10-($a*3+$b)%10)%10;
	    return $sn.$c;
	}
	
    function del_cart_product(){
		if($this->RequestHandler->isPost()){
		Configure::write('debug', 0);
    		unset($_SESSION['svcart']);
    		$this->Cookie->del('products');
    		$result['type'] = 1 ;
    		die($result);
    	}
    }
}
?>