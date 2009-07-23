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
 * $Id: carts_controller.php 3233 2009-07-22 11:41:02Z huangbo $
*****************************************************************************/
class CartsController extends AppController {
	var $name = 'Carts';
	var $helpers = array('Html');
	var $uses = array('Cart','Category','Product','ProductI18n','Region','Shipping','ShippingArea','ShippingAreaRegion','Payment','User','UserAddress','Order','OrderProduct','Packaging','Card','OrderPackaging','OrderCard','Promotion','PromotionProduct','UserRank','ProductRank','PaymentApiLog','UserBalanceLog','UserPointLog','OrderCard','OrderPackaging','Coupon','CouponType','ProductShippingFee','ProductAttribute','ProductLocalePrice','Cart','ProdcutVolume');
	var $components = array('RequestHandler','Cookie','Session');
 	function index(){
 	//	pr($_SESSION['svcart']);
		if(isset($_SESSION['User']['User']['id'])){
			//取cart 表数据
			$cart_products =	$this->Cart->findall("Cart.user_id = ".$_SESSION['User']['User']['id']." and Cart.session_id = '".session_id()."'");
			$p_ids =array();
			$p_lists = array();
		 	$this->Category->set_locale($this->locale);
 			$this->Category->tree('P',0,$this->locale);
			unset($_SESSION['svcart']['products']);
			if(isset($cart_products) && sizeof($cart_products)>0){
				foreach($cart_products as $k=>$v){
					if(!in_array($v['Cart']['product_id'],$p_ids)){
						$p_ids[] = $v['Cart']['product_id'];
					} 
				}
				if(empty($p_ids)){
					$p_ids[] =0;
				}
				$product_attr = $this->ProductAttribute->find('all',array(
				'fields' =>	array('ProductAttribute.id','ProductAttribute.product_id','ProductAttribute.product_type_attribute_id','ProductAttribute.product_type_attribute_value','ProductAttribute.product_type_attribute_price'),			
				'conditions'=>array('ProductAttribute.product_id' => $p_ids)));
				$this->Product->set_locale($this->locale);
				$svcart_products = $this->Product->find('all',
				array( 
						'fields' =>	array('Product.id','Product.recommand_flag','Product.status','Product.img_thumb'
									,'Product.market_price'
									,'Product.shop_price','Product.promotion_price'
									,'Product.promotion_start'
									,'Product.promotion_end'
									,'Product.promotion_status'
									,'Product.code','Product.point','Product.point_fee'
									,'Product.product_rank_id'
									,'Product.quantity'
									,'ProductI18n.name','Product.extension_code','Product.weight','Product.frozen_quantity','Product.product_type_id','Product.brand_id','Product.coupon_type_id','Product.category_id'
									),				
				'conditions'=>array('Product.id'=>$p_ids)));
				
				$svcart_products_list = array();
				if(isset($svcart_products) && sizeof($svcart_products)>0){
					foreach($svcart_products as $k=>$v){
						$svcart_products_list[$v['Product']['id']] = $v;
					}
				}
								
				$product_attr_lists = array();
				if(isset($product_attr) && sizeof($product_attr)>0){
					foreach($product_attr as $k=>$v){
						$product_attr_lists[$v['ProductAttribute']['product_id']][$v['ProductAttribute']['product_type_attribute_value']] = $v;
					}
				}
				foreach($cart_products as $k=>$v){
					if(isset($svcart_products_list[$v['Cart']['product_id']])){
						if($v['Cart']['product_attrbute'] == ""){
							$new_id = $v['Cart']['product_id'];
						}else{
							$this_attr = explode(',',$v['Cart']['product_attrbute']);
							$new_id = $v['Cart']['product_id'];
							$attributes = $v['Cart']['product_attrbute'];
							foreach($this_attr as $val){
								if(trim($val) != "" &&  isset($product_attr_lists[$v['Cart']['product_id']][trim($val)])){
									$new_id.= '.'.$product_attr_lists[$v['Cart']['product_id']][trim($val)]['ProductAttribute']['id'];
							//		$attributes .= $val.",";
								}
							//	$attributes = substr($val,0,-1);
							}
							$_SESSION['svcart']['products'][$new_id]['attributes'] = $attributes;
						}
						$_SESSION['svcart']['products'][$new_id]['Product'] = array(
						'id'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['id'],'code'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['code'],'weight'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['weight'],'market_price'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['market_price'],'shop_price'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['shop_price'],'promotion_price'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['promotion_price'],'promotion_start'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['promotion_start'],'promotion_end'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['promotion_end'],'promotion_status'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['promotion_status'],'product_rank_id'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['product_rank_id'],'extension_code'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['extension_code'],'frozen_quantity'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['frozen_quantity'],'product_type_id'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['product_type_id'],'brand_id'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['brand_id'],'coupon_type_id'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['coupon_type_id'],'point'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['point'],'img_thumb'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['img_thumb'],'point_fee'=>$svcart_products_list[$v['Cart']['product_id']]['Product']['point_fee']
						);
			            $_SESSION['svcart']['products'][$new_id]['quantity'] = $v['Cart']['product_quantity'];
			            $_SESSION['svcart']['products'][$new_id]['category_name'] = isset($this->Category->allinfo['assoc'][$svcart_products_list[$v['Cart']['product_id']]['Product']['category_id']])?$this->Category->allinfo['assoc'][$svcart_products_list[$v['Cart']['product_id']]['Product']['category_id']]['CategoryI18n']['name']:'';
			            $_SESSION['svcart']['products'][$new_id]['category_id'] = $svcart_products_list[$v['Cart']['product_id']]['Product']['category_id'];
	 					$_SESSION['svcart']['products'][$new_id]['use_point'] = 0;
			            $_SESSION['svcart']['products'][$new_id]['save_cart'] = $v['Cart']['id'];
						$_SESSION['svcart']['products'][$new_id]['ProductI18n'] = array('name'=>$svcart_products_list[$v['Cart']['product_id']]['ProductI18n']['name']);
					}
				}
		    }
			//pr($product_attr_lists);
		}
		$this->statistic_svcart(); 				//计算金额
 		//unset($_SESSION['svcart']['address']);
 		$this->Cookie->del('cart_cookie');
 	//	unset($_SESSION['svcart']['products']);
		$this->page_init();
 		$this->Product->set_locale($this->locale);
		if(!isset($_SESSION['svcart']['products']) && isset($_COOKIE['CakeCookie']['cart_cookie'])){
			$_SESSION['svcart'] = @unserialize(StripSlashes($this->Cookie->read('cart_cookie')));
		}
		$product_ranks = $this->ProductRank->findall_ranks();
		if(isset($_SESSION['User']['User'])){
			$user_rank_list=$this->UserRank->findrank();		
		}
		$this->order_price();
		
 		//取得促销商品
 		$promotion_products = $this->Product->promotion($this->configs['promotion_count'],$this->locale);
 		if(isset($promotion_products) && sizeof($promotion_products)>0){
 			$pid_array = array();
 			foreach($promotion_products as $k=>$v){
 				$pid_array[] = $v['Product']['id'];
 			}
 			
		// 商品多语言
			$productI18ns_list =array();
				$productI18ns = $this->ProductI18n->find('all',array( 
				'fields' =>	array('ProductI18n.id','ProductI18n.name','ProductI18n.product_id'),
				'conditions'=>array('ProductI18n.product_id'=>$pid_array,'ProductI18n.locale'=>$this->locale)));
			if(isset($productI18ns) && sizeof($productI18ns)>0){
				foreach($productI18ns as $k=>$v){
					$productI18ns_list[$v['ProductI18n']['product_id']] = $v;
				}
			}
 		}
 		
 		foreach($promotion_products as $k=>$v){
			if(isset($productI18ns_list[$v['Product']['id']])){
				$promotion_products[$k]['ProductI18n'] = $productI18ns_list[$v['Product']['id']]['ProductI18n'];
			}else{
				$promotion_products[$k]['ProductI18n']['name'] = "";
			}	 			
 			
 	//		$promotion_products[$k]['Product']['user_price'] = $this->Product->user_price($k,$v,$this);
			if(isset($product_ranks[$v['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']])){
				if(isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
				  $promotion_products[$k]['Product']['user_price']= $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
				}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
				  $promotion_products[$k]['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($v['Product']['shop_price']);			  
				}
			} 			
 		}	
 		
		$this->set('promotion_products',$promotion_products);
		if(isset($this->configs['enable_buy_packing']) && $this->configs['enable_buy_packing'] == 1){
			//取得包装信息
			$this->Packaging->set_locale($this->locale);
			$packaging_lists = $this->Packaging->find('all',array(
			'fields' =>array('Packaging.id','Packaging.img01','Packaging.fee','Packaging.free_money','PackagingI18n.name','PackagingI18n.description'),
			'order'=>array("Packaging.created desc"),'conditions'=>array('Packaging.status'=>1)));
		//	pr($packaging_lists);
			//$this->Packaging->findAll("status = '1'","","Packaging.created desc","")
			$this->set('packages',$packaging_lists);
		}
		if(isset($this->configs['enable_buy_card']) && $this->configs['enable_buy_card'] == 1){
			//取得贺卡信息
			$this->Card->set_locale($this->locale);
			$card_lists = $this->Card->find('all',
			array(
			'fields' =>array('Card.id','Card.img01','Card.fee','Card.free_money','CardI18n.name','CardI18n.description'),
			'order'=>array("Card.created desc"),'conditions'=>array('Card.status'=>1)));
			//$this->Card->findAll("status = '1'","","Card.created desc","")
			$this->set('cards',$card_lists);
		}
		//输出SV-Cart里的信息
		if(isset($_SESSION['svcart']['products'])){
			$this->statistic_svcart();
			$this->set('all_virtual',$_SESSION['svcart']['cart_info']['all_virtual']);
			if($this->configs['use_sku'] == 1){
				foreach($_SESSION['svcart']['products'] as $k=>$v){
					$this->Category->set_locale($this->locale);						
					$info = $this->Category->findbyid($v['Product']['category_id']);						
					$_SESSION['svcart']['products'][$k]['use_sku'] = 1;
					if($info['Category']['parent_id']>0){
						$parent_info = $this->Category->findbyid($info['Category']['parent_id']);
						if(isset($parent_info['Category'])){
							$parent_info['CategoryI18n']['name'] = str_replace(" ","-",$parent_info['CategoryI18n']['name']);
							$parent_info['CategoryI18n']['name'] = str_replace("/","-",$parent_info['CategoryI18n']['name']);
							$_SESSION['svcart']['products'][$k]['parent'] = $parent_info['CategoryI18n']['name'];
						}
					}
				}			
			}
			$this->set('svcart',$_SESSION['svcart']);
		}
		$this->pageTitle = $this->languages['cart']." - ".$this->configs['shop_title'];
		$this->navigations[] = array('name'=>$this->languages['cart'],'url'=>"/carts/");
		
		if(isset($_SESSION['svcart']['cart_info']['sum_subtotal'])){
			$promotions = $this->findpromotions();
		//	pr($promotions);
			$this->set('promotions',$promotions);
		}
		if(isset($this->configs['enable_one_step_buy']) && $this->configs['enable_one_step_buy'] == 1){
			$js_languages = array("enable_one_step_buy" => "1",'exceed_upper_limit_products'=>$this->languages['exceed_upper_limit_products']);
			$this->set('js_languages',$js_languages);
		}else{
			$js_languages = array("enable_one_step_buy" => "0",'exceed_upper_limit_products'=>$this->languages['exceed_upper_limit_products']);
			$this->set('js_languages',$js_languages);
		}
		$this->set('locations',$this->navigations);
	}
	function order_price(){
		//pr($_SESSION['svcart']);
		//统计商品价格
		$_SESSION['svcart']['cart_info']['sum_subtotal'] = 0;
		$_SESSION['svcart']['cart_info']['sum_market_subtotal'] = 0;
		if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
			foreach($_SESSION['svcart']['products'] as $k=>$v){
				$_SESSION['svcart']['cart_info']['sum_subtotal'] += $v['subtotal'] ;
				$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $v['market_subtotal'] ;
			}
			$_SESSION['svcart']['cart_info']['all_product'] = $_SESSION['svcart']['cart_info']['sum_subtotal'];
		}
		if(isset($_SESSION['svcart']['cards']) && sizeof($_SESSION['svcart']['cards'])>0){
			foreach($_SESSION['svcart']['cards'] as $k=>$v){
				$_SESSION['svcart']['cart_info']['sum_subtotal'] += $v['subtotal'] ;
				$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $v['subtotal'] ;
			}
		}		
		if(isset($_SESSION['svcart']['packagings']) && sizeof($_SESSION['svcart']['packagings'])>0){
			foreach($_SESSION['svcart']['packagings'] as $k=>$v){
				$_SESSION['svcart']['cart_info']['sum_subtotal'] += $v['subtotal'] ;
				$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $v['subtotal'] ;
			}
		}
		if($_SESSION['svcart']['cart_info']['sum_market_subtotal'] > 0){
			$_SESSION['svcart']['cart_info']['discount_rate'] = round($_SESSION['svcart']['cart_info']['sum_subtotal']/$_SESSION['svcart']['cart_info']['sum_market_subtotal']*100);
		}else{
			$_SESSION['svcart']['cart_info']['discount_rate'] = 100;
		}
		$_SESSION['svcart']['cart_info']['discount_price'] = $_SESSION['svcart']['cart_info']['sum_market_subtotal']-$_SESSION['svcart']['cart_info']['sum_subtotal'];
		$_SESSION['svcart']['cart_info']['total'] = $_SESSION['svcart']['cart_info']['sum_subtotal'];
		if(isset($_SESSION['svcart']['shipping']['shipping_fee'])){
			$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['shipping']['shipping_fee'];
		}
		if(isset($_SESSION['svcart']['shipping']['insure_fee_confirm'])){
			$_SESSION['svcart']['cart_info']['total']  += $_SESSION['svcart']['shipping']['insure_fee_confirm'];
		}	
		if(isset($_SESSION['svcart']['payment']['payment_fee'])){
			$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['payment']['payment_fee'];
		}
		if(isset($_SESSION['svcart']['promotion'])){
			if($_SESSION['svcart']['promotion']['type'] == 1){
		//		$_SESSION['svcart']['cart_info']['total'] = round($_SESSION['svcart']['cart_info']['total']*$_SESSION['svcart']['promotion']['promotion_fee']/100,2);
				$_SESSION['svcart']['cart_info']['all_product'] = round($_SESSION['svcart']['cart_info']['all_product']*$_SESSION['svcart']['promotion']['promotion_fee']/100,2);
				$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['cart_info']['all_product'];
				
			}
			if($_SESSION['svcart']['promotion']['type'] == 0){
				$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['promotion']['promotion_fee'];
			}	
			
			if($_SESSION['svcart']['promotion']['type'] == 2 && isset($_SESSION['svcart']['promotion']['product_fee'])){
				//foreach(){
				$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['promotion']['product_fee'];
				//}
			}				
		}
		if(isset($_SESSION['svcart']['point']['fee'])){
			$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['point']['fee'];
		}			
		if(isset($_SESSION['svcart']['coupon']['fee'])){
			$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['coupon']['fee'];
		}				
	}
	
	function checkout(){
		if(isset($_SESSION['svcart']['promotion'])){
			unset($_SESSION['svcart']['promotion']);
		}
		//pr($_SESSION['svcart']['packagings']);
		if(isset($_POST['promotion_id'])){
			$promotions = $this->findpromotions($_POST['promotion_id']);
			if(isset($promotions[0]['Promotion']['id'])){
				if($promotions[0]['Promotion']['type'] == 2){
					if(isset($_POST['product_id'][$_POST['promotion_id']]) && sizeof($_POST['product_id'][$_POST['promotion_id']])>0){
						foreach($_POST['product_id'][$_POST['promotion_id']] as $k=>$v){
							$set_promotion = array(
												'promotion_id' => $_POST['promotion_id'],
												'product_id' => $v
												);
							
							$this->add_promotion_product($set_promotion);
						}
					}
				}else{
					$set_promotion = array(
											'type_ext'	=>	$promotions[0]['Promotion']['type_ext'],
											'meta_description'	=>	$promotions[0]['PromotionI18n']['meta_description'],
											'type'	=>	$promotions[0]['Promotion']['type'],
											'title'	=>	$promotions[0]['PromotionI18n']['title'],
											);
					$this->confirm_promotion($set_promotion);
				}
			}
			
			
		}
		//header("Cache-Control: no-cache, must-revalidate"); 
		if(isset($_POST['order_note']) && $_POST['order_note'] != ""){
			$_SESSION['svcart']['order_note'] = $_POST['order_note'];
		}
	//	$this->statistic_svcart();
		$this->page_init();
		if(isset($_SESSION['User']))
		{
			//	unset($_SESSION['svcart']);
			if(isset($_SESSION['svcart']['cart_info']) && !isset($_SESSION['svcart']['cart_info']['total'])){
				$_SESSION['svcart']['cart_info']['total'] = $_SESSION['svcart']['cart_info']['sum_subtotal'];
			}else if(!isset($_SESSION['svcart']['products']) && isset($_COOKIE['CakeCookie']['cart_cookie'])){
				$_SESSION['svcart'] = @unserialize($this->Cookie->read('cart_cookie'));
			}
			$this->order_price();
			if(!(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0)){
				$this->pageTitle = $this->languages['no_products_in_cart']." - ".$this->configs['shop_title'];
				$this->flash($this->languages['no_products_in_cart']," ","/",5);
			}else{
				$send_point = array();
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
						$send_coupon[$k]['quantity'] = $v['quantity'];
				//		}
					}
				}
				$this->set('send_point',$send_point);
				$this->set('product_point',$product_point);
	       	 	$this->CouponType->set_locale($this->locale);
				$cache_key = md5('find_coupon_types'.'_'.$this->locale);
				$coupon_types = cache::read($cache_key);	
				if(!$coupon_types){	
					$coupon_type_arr = $this->CouponType->find('all',array('conditions'=>array('1=1')
					,'fields'=>array('CouponType.id','CouponType.money','CouponType.prefix','CouponType.use_end_date','CouponType.use_start_date','CouponTypeI18n.name')));
					$coupon_types = array();
					if(is_array($coupon_type_arr) && sizeof($coupon_type_arr)>0){
						foreach($coupon_type_arr as $k=>$v){
							$coupon_types[$v['CouponType']['id']] = $v;
						}
					}
					cache::write($cache_key,$coupon_types);	
				}				
		//		pr($coupon_types);
				
				
	            if(isset($this->configs['send_coupons']) && $this->configs['send_coupons'] == 1){
					$order_coupon = array();
	            //	$order_coupon_type = $this->CouponType->findall("CouponType.send_type = '2' and CouponType.send_start_date <= '".$now."' and CouponType.send_end_date >= '".$now."'");
	            	$order_coupon_type = $this->CouponType->find("all",array(
	            	"fields"=>array('CouponType.id','CouponType.min_products_amount','CouponType.money','CouponType.prefix','CouponType.use_end_date','CouponType.use_start_date','CouponTypeI18n.name'),
	            	"conditions"=>array("CouponType.send_type = '2' and CouponType.send_start_date <= '".$now."' and CouponType.send_end_date >= '".$now."'")));
	            //	pr($order_coupon_type);
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
	            		if(isset($coupon_types[$value['coupon']])){
	            		//$pro_coupon_type = $this->CouponType->findbyid($value['coupon']);
						$pro_coupon_type = $coupon_types[$value['coupon']];
						$product_coupon[$key]['name'] = $value['name'];
						$product_coupon[$key]['fee'] = $pro_coupon_type['CouponType']['money'];	
						$product_coupon[$key]['quantity'] = $value['quantity'];	
	            		}
	            	}
	            }
				$this->set('product_coupon',$product_coupon);
				
				}		
		
				//pr($_SESSION);
				//初始化session
	    	//	$this->statistic_svcart();
				$this->set('all_virtual',$_SESSION['svcart']['cart_info']['all_virtual']);
				//取得地址簿
						/* 判断是否需要显示配送方式 */
				if((isset($_SESSION['svcart']['cart_info']['all_virtual']) && $_SESSION['svcart']['cart_info']['all_virtual']==0) 
					|| (isset($_SESSION['svcart']['promotion']['all_virtual']) && $_SESSION['svcart']['promotion']['all_virtual'] == 0)){
					$this->set('all_virtual',0);
					$all_virtual = 0;
				}else{ 
					$this->set('all_virtual',1);
					$all_virtual = 1;
				}					
				
				$this->Region->set_locale($this->locale);
				$addresses_count = $this->UserAddress->find("count",array('conditions' =>"UserAddress.user_id = '".$_SESSION['User']['User']['id']."'"));
				$need_new_address = 0;
				if($addresses_count == 0 ){
					unset($_SESSION['svcart']['address']);
					$checkout_address = "new_address";
					$address['UserAddress']['id'] = 'null';
					$need_new_address = 1;
				}elseif($addresses_count == 1){
					$checkout_address = "confirm_address";
					$address = $this->UserAddress->findbyuser_id($_SESSION['User']['User']['id']);
					$_SESSION['svcart']['address']=$address['UserAddress'];
					$region_array = explode(" ",trim($address['UserAddress']['regions']));
					if(is_array($region_array) && sizeof($region_array)>0){
						foreach($region_array as $a=>$b){
							if($b == $this->languages['please_choose']){
								unset($region_array[$a]);
							}
						}
					}else{
						$region_array[] = 0;
					}					
					$address['UserAddress']['regions'] = "";
			//		$region_name_arr = $this->Region->find('all',array('conditions'=>array('Region.id'=>$region_array)));
					$region_name_arr = $this->Region->find('all',array('fields'=>array('Region.id','Region.parent_id','Region.level','RegionI18n.name'),'conditions'=>array('Region.id'=>$region_array)));
			
					if(is_array($region_name_arr) && sizeof($region_name_arr)>0){
						foreach($region_name_arr as $k=>$v){
							$address['UserAddress']['regions'].= isset($v['RegionI18n']['name'])?$v['RegionI18n']['name']." ":"";
						}
					}
					
					if($address['UserAddress']['mobile'] =='' &&  $address['UserAddress']['telephone'] =='' &&  $address['UserAddress']['address'] == '' && $all_virtual == 0)	{
						$need_new_address = 1;
						unset($_SESSION['svcart']['address']);
					}				
					
					
					//pr($region_name_arr);
				/*	foreach($region_array as $k=>$region_id){
						if($region_id != '' && $region_id != $this->languages['please_choose']){
							$region_info = $this->Region->findbyid($region_id);
							if($k < sizeof($region_array)-1){
								$address['UserAddress']['regions'] .= $region_info['RegionI18n']['name']." ";
							}else{
								$address['UserAddress']['regions'] .= $region_info['RegionI18n']['name'];
							}
						}
					}*/
					
					$_SESSION['svcart']['address']['regionI18n'] = $address['UserAddress']['regions'];
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
				}else{
					$checkout_address = "select_address";
					$addresses = $this->UserAddress->findAllbyuser_id($_SESSION['User']['User']['id']);
					foreach($addresses as $key=>$address){
					if(isset($region_array) && sizeof($region_array)>0){
						foreach($region_array as $a=>$b){
							if($b == $this->languages['please_choose']){
								unset($region_array[$a]);
							}
						}
					}else{
						$region_array[] = 0;
					}	
					$region_array = explode(" ",trim($address['UserAddress']['regions']));
					$addresses[$key]['UserAddress']['regions'] = "";
						
	//				$region_name_arr = $this->Region->find('all',array('conditions'=>array('Region.id'=>$region_array)));
					$region_name_arr = $this->Region->find('all',array('fields'=>array('Region.id','Region.parent_id','Region.level','RegionI18n.name'),'conditions'=>array('Region.id'=>$region_array)));
	
					if(is_array($region_name_arr) && sizeof($region_name_arr)>0){
						foreach($region_name_arr as $k=>$v){
							$addresses[$key]['UserAddress']['regions'].= isset($v['RegionI18n']['name'])?$v['RegionI18n']['name']." ":"";
						}
					}						
						/*foreach($region_array as $k=>$region_id){
							if($region_id!='' && $region_id != $this->languages['please_choose']){
								$region_info = $this->Region->findbyid($region_id);
								if($k < sizeof($region_array)-1){
									$addresses[$key]['UserAddress']['regions'] .= $region_info['RegionI18n']['name']." ";
								}else{
									$addresses[$key]['UserAddress']['regions'] .= $region_info['RegionI18n']['name'];
								}
							}
						}*/
					}
					
					$this->set('addresses',$addresses);
					$address['UserAddress']['id'] = 'null';
				}
				$this->set('checkout_address',$checkout_address);
				$this->set('address',$address);
				$this->set('addresses_count',$addresses_count);
				$this->set('shipping_type',0);
				
					if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
						$weight = 0;
						foreach($_SESSION['svcart']['products'] as $k=>$v){
							$weight += $v['Product']['weight'];
						}
					}
				
		//		pr($_SESSION['User']['User']);
				
				if($checkout_address == "confirm_address" && ((isset($_SESSION['svcart']['address']['telephone']) && $_SESSION['svcart']['address']['telephone'] != "") || (isset($_SESSION['svcart']['address']['mobile']) && $_SESSION['svcart']['address']['mobile'] != ""))){
					$address = $this->UserAddress->findbyuser_id($_SESSION['User']['User']['id']);
					if(trim($address['UserAddress']['regions']) != "" && trim($address['UserAddress']['regions']) != $this->languages['please_choose'] && !isset($_SESSION['svcart']['shipping']['shipping_fee'])){
						$this->show_shipping_by_address($address['UserAddress']['id'],$weight);
					}
				}elseif(isset($_SESSION['svcart']['address']['id']) && trim($_SESSION['svcart']['address']['regions']) != "" &&  trim($_SESSION['svcart']['address']['regions']) != $this->languages['please_choose'] &&((isset($_SESSION['svcart']['address']['telephone']) && $_SESSION['svcart']['address']['telephone'] != "") || (isset($_SESSION['svcart']['address']['mobile']) && $_SESSION['svcart']['address']['mobile'] != "")) && !isset($_SESSION['svcart']['shipping']['shipping_fee'])){
						$this->show_shipping_by_address($_SESSION['svcart']['address']['id'],$weight);
				}
				if(isset($_SESSION['svcart']['address']['id']) && trim($_SESSION['svcart']['address']['regions']) != "" &&  trim($_SESSION['svcart']['address']['regions']) != $this->languages['please_choose']){
						$this->show_shipping_by_address($_SESSION['svcart']['address']['id'],$weight);
				}
		//		pr($checkout_address);
				//取得可用的配送方式
				$this->Shipping->set_locale($this->locale);
		//		$ships = $this->Shipping->find('all',array('fields'=>array('Shipping.id','Shipping.code','Shipping.insure',)));
				
			//	pr($ships);
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
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
				}else{
					$_SESSION['svcart']['payment']['not_show_change'] = '0';
				}
				
				
				$this->set('need_new_address',$need_new_address);
				$this->set('payments',$payments);
		//		$this->set('ships',$ships);
				//促销
			//	$promotions = $this->findpromotions();
				//pr($promotions);
				// 获得积分参数
		//		$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
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
				$coupons = $this->Coupon->findall("Coupon.user_id =".$_SESSION['User']['User']['id']." and Coupon.order_id = '0'");
	    		$now = date("Y-m-d H:i:s");
				if(is_array($coupons) && sizeof($coupons) >0){
					$this->CouponType->set_locale($this->locale);
					foreach($coupons as $k=>$v){
					//	$coupon_type = $this->CouponType->findbyid($v['Coupon']['coupon_type_id']);
					//	            		if(isset($coupon_types[$value['coupon']])){
						if(isset($coupon_types[$v['Coupon']['coupon_type_id']]) && $coupon_types[$v['Coupon']['coupon_type_id']]['CouponType']['use_start_date'] <= $now && $coupon_types[$v['Coupon']['coupon_type_id']]['CouponType']['use_end_date'] >= $now){
							$coupons[$k]['Coupon']['name'] = $coupon_types[$v['Coupon']['coupon_type_id']]['CouponTypeI18n']['name'];
							$coupons[$k]['Coupon']['fee'] = $coupon_types[$v['Coupon']['coupon_type_id']]['CouponType']['money'];
						}else{
							unset($coupons[$k]);
						}
					}
					$this->set('coupons',$coupons);
				}
				
				$this->set('user_info',$user_info);
				$this->set('svcart',$_SESSION['svcart']);
        //        $this->set('promotions',$promotions);
			}
		}
		else
		{
			$_SESSION['back_url'] = $this->server_host.$this->cart_webroot."carts/checkout/";
			
			$this->redirect($this->server_host.$this->user_webroot.'login/');
			exit;
		}

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
									"please_choose_payment" => $this->languages['please_choose'].$this->languages['payment'],
									"please_choose_shipping" => $this->languages['please_choose'].$this->languages['shipping_method'],
									"choose_area" => $this->languages['please_choose'].$this->languages['area'],
									"invalid_tel_number" => $this->languages['telephone'].$this->languages['not_correct'],
									"not_less_eight_characters" => $this->languages['not_less_eight_characters'],
									"telephone_or_mobile" => $this->languages['telephone_or_mobile'],
									"exceed_max_value_can_use " => $this->languages['exceed_max_value_can_use'],
									"point_not_empty" => $this->languages['point'].$this->languages['can_not_empty'],
									"coupon_phone_not_empty" => $this->languages['coupon'].$this->languages['can_not_empty'],					
									"invalid_mobile_number" => $this->languages['mobile'].$this->languages['not_correct'],
									"cart_cancel" => $this->languages['cancel'],
									"cart_confirm" => $this->languages['confirm'],
					//				"updating_please_wait" => $this->languages['updating_please_wait'],
									"orders_submitting_please_wait" => $this->languages['orders_submitting_please_wait'],
									"please_wait_consignee_information" => sprintf($this->languages['updating_please_wait'],$this->languages['consignee'].$this->languages['information']),
									"please_wait_shipping_method" => sprintf($this->languages['updating_please_wait'],$this->languages['shipping_method']),
									"please_wait_payment" => sprintf($this->languages['updating_please_wait'],$this->languages['payment']),
									"please_wait_point" => sprintf($this->languages['updating_please_wait'],$this->languages['point']),
									"please_wait_coupon" => sprintf($this->languages['updating_please_wait'],$this->languages['coupon']),
									"support_value_or_not" => $this->languages['support_value_or_not']
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
						
						$i = 0;
						while(true){
							if(!isset($_POST['attributes_'.$i])){
								break;
							}
							$product_attributes = $this->ProductAttribute->findbyid($_POST['attributes_'.$i]);
							$attributes[$i] = $_POST['attributes_'.$i];
							$i++;
				 		}						
						
						if(isset($attributes)){
							$this->set('attributes',$attributes);
						}
						if(isset($_POST['is_exchange'])){
							$this->set('is_exchange',$_POST['is_exchange']);   //是否从积分商场 购买
						}
						if($this->is_promotion($product_info)){
							$product_info['is_promotion'] = 1;
						}
						
						$this->set('product_info',$product_info);
						$result['type'] = 4;
					}else{
					//取得商品信息
						$product_info = $this->Product->findbyid($_POST['id']);//商品属性待处理！
					//	$product_info['Product']['shop_price'] =$this->Product->locale_price($product_info['Product']['id'],$product_info['Product']['shop_price'],$this);
						if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($product_info['ProductLocalePrice']['product_price'])){
							$product_info['Product']['shop_price'] = $product_info['ProductLocalePrice']['product_price'];
						}						
				/*		
						if(isset($this->configs['enable_out_of_stock_handle']) && sizeof($this->configs['enable_out_of_stock_handle'])>0){
							$product_info['Product']['frozen_quantity'] += $_POST['quantity'];
							$this->Product->save($product_info['Product']);
						}*/
					//	pr($_POST);exit;
						$i = 0;
						while(true){
							if(!isset($_POST['attributes_'.$i])){
								break;
							}
							$product_attributes = $this->ProductAttribute->findbyid($_POST['attributes_'.$i]);
							$product_info['Product']['attributes'][$_POST['attributes_'.$i]] =$product_attributes['ProductAttribute']['product_type_attribute_value'];
							$i++;
				 		}
						if(isset($product_info['Product']['attributes'])  && sizeof($product_info['Product']['attributes'])>0){
							$p_id = $_POST['id'];
						/*	$product_info['ProductI18n']['name'] .=" (";
							foreach($product_info['Product']['attributes'] as $k=>$v){
								$p_id .= $k;
								$product_info['ProductI18n']['name'] .= $v." ";
							}
							$product_info['ProductI18n']['name'] .=" )";*/
							$product_info['attributes'] = " ";
							$attr_num = 0;
							foreach($product_info['Product']['attributes'] as $k=>$v){
								$p_id .= ".".$k;
								$product_info['attributes'] .= $v;
								if($attr_num < sizeof($product_info['Product']['attributes'])-1){
									$product_info['attributes'] .=",";
								}
								$attr_num++;
							}
						}else{
							$p_id = $_POST['id'];
						}
					//pr($product_info['Product']['attributes']);
					//添加到SVCART
						if($this->is_promotion($product_info)){
							$product_info['is_promotion'] = 1;
						}
						
						$result = $this->addto_svcart($product_info,$_POST['quantity']);
						$result['is_refresh'] = 0;
						if(isset($_SESSION['svcart']['products'][$p_id])){
							/* 获取老标记 */
							$old_tag = isset($_SESSION['svcart']['cart_info']['all_virtual']) ? $_SESSION['svcart']['cart_info']['all_virtual'] : '';
							$this->statistic_svcart(); 				//计算金额
							if(!isset($_SESSION['svcart']['products'][$p_id]['save_cart'])){
								$this->save_cart($_SESSION['svcart']['products'][$p_id],$p_id);
							}
						//	pr($_SESSION['svcart']['products']);
							/* 纯虚拟商品标记的改变需要刷新页面 */
							if(sizeof($_SESSION['svcart']['products']) == 1 || $old_tag != $_SESSION['svcart']['cart_info']['all_virtual']){
								$result['is_refresh'] = 1;
							}
							$_SESSION['svcart']['products'][$p_id]['use_point'] = isset($_SESSION['svcart']['products'][$p_id]['use_point'])?$_SESSION['svcart']['products'][$p_id]['use_point']:0;									
							//是否从积分商场 购买
							if(isset($_POST['is_exchange'])){
								if(isset($_SESSION['User']['User']['id'])){
									$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
									if(!isset($_SESSION['svcart']['point']['fee']) || !isset($_SESSION['svcart']['point']['point'])){
										$_SESSION['svcart']['point']['fee'] = 0;
										$_SESSION['svcart']['point']['point'] = 0;
									}
									//可以用的 积分
									$can_use_point = round($_SESSION['svcart']['products'][$p_id]['subtotal']/$_SESSION['svcart']['products'][$p_id]['quantity']/100*$this->configs['proportion_point']);
								//	$can_use_point = round($_SESSION['svcart']['cart_info']['sum_subtotal']/100*$this->configs['proportion_point']);
									if($_SESSION['svcart']['products'][$p_id]['use_point'] > 0 && ($_SESSION['svcart']['products'][$p_id]['use_point'] + $_SESSION['svcart']['products'][$p_id]['Product']['point_fee']) > $can_use_point){
										$buy_point = $can_use_point - $_SESSION['svcart']['products'][$p_id]['use_point'];
									}else if(($_SESSION['svcart']['products'][$p_id]['Product']['point_fee']+$_SESSION['svcart']['point']['point']) <=$can_use_point){
										$buy_point = $_SESSION['svcart']['products'][$p_id]['Product']['point_fee'];
									}else{
										$buy_point = $can_use_point - $_SESSION['svcart']['point']['point'];
									}
									$point_fee = round($buy_point/100*$this->configs['conversion_ratio_point']);
									if($user_info['User']['point'] >= $buy_point){
										$_SESSION['svcart']['point']['point'] += $buy_point;
										$_SESSION['svcart']['point']['fee'] += $point_fee;
										$_SESSION['svcart']['products'][$p_id]['use_point'] += $buy_point;
									}else{
										$_SESSION['svcart']['point']['point'] += $user_info['User']['point'];
										$_SESSION['svcart']['point']['fee'] += round($user_info['User']['point']/100*$this->configs['conversion_ratio_point']);
										$_SESSION['svcart']['products'][$p_id]['use_point'] += $user_info['User']['point'];
									}
								}else{
									$_SESSION['svcart']['products'][$p_id]['is_exchange'] = 1;
								}
							}								
							
							$this->set('svcart',$_SESSION['svcart']);
							$this->set('product_id',$_POST['id']);
							$this->set('product_info',$_SESSION['svcart']['products'][$p_id]);
							$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
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
			if(!isset($_POST['is_ajax'])){
				if($result['type'] < 1){					
					header("Location:".$this->server_host.$this->cart_webroot."carts");
				}else{
					$this->page_init();
					$this->pageTitle = isset($result['message'])?$result['message']:''." - ".$this->configs['shop_title'];
					$this->flash(isset($result['message'])?$result['message']:'',isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'/'.$id,10);									
				}
			}

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
		if(isset($this->configs['enable_out_of_stock_handle']) && sizeof($this->configs['enable_out_of_stock_handle'])>0){
			$can_by_quantity = ($product_info['Product']['quantity']-$product_info['Product']['frozen_quantity']);
		}else{
			$can_by_quantity = $product_info['Product']['quantity'];
		}		
		//判断是否在购物车
		if(isset($product_info['Product']['attributes'])  && sizeof($product_info['Product']['attributes'])>0){
			$p_id = $product_info['Product']['id'];
			foreach($product_info['Product']['attributes'] as $k=>$v){
				$p_id .= ".".$k;
			}
		}else{
			$p_id = $product_info['Product']['id'];
			$product_info['Product']['attributes'] = array();
		}	
		if($this->in_svcart($p_id,$product_info['Product']['attributes'])){
			$num = 0;
			foreach($_SESSION['svcart']['products'] as $k=>$v){
				if($v['Product']['id'] == $product_info['Product']['id']){
					$num += $v['quantity'];
				}
			}
			
			if($_SESSION['svcart']['products'][$p_id]['quantity'] + $quantity > $product_info['Product']['max_buy']){
				$result['type']=1;
				$result['message']= $this->languages['expand_max_number'];
				return $result;
			}elseif($_SESSION['svcart']['products'][$p_id]['quantity'] + $quantity > $can_by_quantity){
				$result['type']=1;
				$result['message']= $this->languages['stock_is_not_enough'];
				return $result; 
			}else{
				$_SESSION['svcart']['products'][$p_id]['quantity'] += $quantity;
				if(isset($this->configs['enable_decrease_stock_time']) && $this->configs['enable_decrease_stock_time'] == 0){
					$product_quantity = $product_info['Product']['quantity'] - $quantity;
					$product_info['Product']['quantity'] = $product_quantity;
					$this->Product->save($product_info);
				}
				$result['type']=0;
				if(isset($this->configs['enable_out_of_stock_handle']) && sizeof($this->configs['enable_out_of_stock_handle'])>0){
					$product_info['Product']['frozen_quantity'] += $quantity;
					$this->Product->save($product_info['Product']);
				}		
			}
		}else{
			if($quantity < $product_info['Product']['min_buy']){
				$result['type']=1;
				$result['message']=$this->languages['least_number'].$product_info['Product']['min_buy'];
				return $result;
			}else if($quantity > $can_by_quantity){
				$result['type']=1;
				$result['message']= $this->languages['stock_is_not_enough'];
				return $result; 
			}else{
				$_SESSION['svcart']['products'][$p_id] = array(
				'Product'=>array('id'=>$product_info['Product']['id'],
								'code'=>$product_info['Product']['code'],
								'weight'=>$product_info['Product']['weight'],
								'market_price'=>$product_info['Product']['market_price'],
							    'shop_price'=>$product_info['Product']['shop_price'],
							    'promotion_price'=>$product_info['Product']['promotion_price'],
							    'promotion_start'=>$product_info['Product']['promotion_start'],
							    'promotion_end'=>$product_info['Product']['promotion_end'],
							    'promotion_status'=>$product_info['Product']['promotion_status'],
							    'product_rank_id'=>$product_info['Product']['product_rank_id'],
							    'extension_code'=>$product_info['Product']['extension_code'],
							    'frozen_quantity'=>$product_info['Product']['frozen_quantity'],
							    'product_type_id'=>$product_info['Product']['product_type_id'],
							    'brand_id'=>$product_info['Product']['brand_id'],
								'coupon_type_id'=>$product_info['Product']['coupon_type_id'],
								'point'=>$product_info['Product']['point'],
							    'img_thumb'=>$product_info['Product']['img_thumb'],
								'buy_time'=>date("Y-m-d H:i:s"),
							    'point_fee'=>$product_info['Product']['point_fee']
							    ),
					'attributes'=> isset($product_info['attributes'])?$product_info['attributes']:'',		    	
				'ProductI18n'=>array('name'=>$product_info['ProductI18n']['name'])
							    );//$product_info['Product'][''];
				$_SESSION['svcart']['products'][$p_id]['quantity'] = $quantity;
				$_SESSION['svcart']['products'][$p_id]['Product']['quantity'] = $quantity;
 				$categorys = $this->Category->findbyid($product_info['Product']['category_id']);
				if(isset($categorys['CategoryI18n']['name'])){
					$_SESSION['svcart']['products'][$p_id]['category_name'] = $categorys['CategoryI18n']['name'];
					$_SESSION['svcart']['products'][$p_id]['category_id'] = $categorys['Category']['id'];
				}
				$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   

				if(isset($this->configs['enable_decrease_stock_time']) && $this->configs['enable_decrease_stock_time'] == 0){
					$product_quantity = $product_info['Product']['quantity'] - $quantity;
					$product_info['Product']['quantity'] = $product_quantity;
					$this->Product->save($product_info);
				}
				if(isset($this->configs['enable_out_of_stock_handle']) && sizeof($this->configs['enable_out_of_stock_handle'])>0){
							$product_info['Product']['frozen_quantity'] += $quantity;
							$this->Product->save($product_info['Product']);
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
		$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
	
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
		$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
	
		$result['type'] = 0;
		}
		return $result;
	}
	
	function remove(){
		//header("Cache-Control: no-cache, must-revalidate"); 
		$result=array();
		if($this->RequestHandler->isPost()){
			if($_POST['type'] == 'product'){
				if(isset($_SESSION['svcart']['products'][$_POST['product_id']])){
					$this->set("product_info",$_SESSION['svcart']['products'][$_POST['product_id']]);
					$this->set("product_info_id",$_POST['product_id']);
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
	
	function act_remove($type= '', $pid =''){
		if($type !="" || $pid != ""){
			$is_ajax = 0;
			$_POST['type'] = $type;
			$_POST['product_id'] = $pid;
		}else{
			$is_ajax = 1;
		}
		$result=array();
		$result['is_refresh'] = 0;
	//	if($this->RequestHandler->isPost()){
			$result['no_product'] = 1;
			if($_POST['type'] == 'product'){
			//将商品从SV-Cart中删除
				if(isset($_SESSION['svcart']['products'][$_POST['product_id']])){
					$result['type']=0;
					$this->set('product_info',$_SESSION['svcart']['products'][$_POST['product_id']]);
					$this->ajax_page_init();
					//删除商品使用的积分
					if(isset($_SESSION['svcart']['products'][$_POST['product_id']]['use_point']) && isset($_SESSION['svcart']['point']['point']) && $_SESSION['svcart']['products'][$_POST['product_id']]['use_point'] <= $_SESSION['svcart']['point']['point']){
						$_SESSION['svcart']['point']['point'] -= $_SESSION['svcart']['products'][$_POST['product_id']]['use_point'];
						$_SESSION['svcart']['point']['fee'] -= round($_SESSION['svcart']['products'][$_POST['product_id']]['use_point']/100*$this->configs['conversion_ratio_point']);
					}
					if(isset($_SESSION['svcart']['products'][$_POST['product_id']]['save_cart'])){
					//	$cart_info = $this->Cart->findbyid($_SESSION['svcart']['products'][$_POST['product_id']]['save_cart']);
						$condition=array("Cart.id"=>$_SESSION['svcart']['products'][$_POST['product_id']]['save_cart']);
						$this->Cart->deleteAll($condition);
					}
					$product_info = $this->Product->findbyid($_SESSION['svcart']['products'][$_POST['product_id']]['Product']['id']);
					if(isset($this->configs['enable_out_of_stock_handle']) && sizeof($this->configs['enable_out_of_stock_handle'])>0){
						$product_info['Product']['frozen_quantity'] -= $_SESSION['svcart']['products'][$_POST['product_id']]['quantity'];
						$this->Product->save($product_info['Product']);					
					}
					
					if(count($_SESSION['svcart']['products'])>1){
						unset($_SESSION['svcart']['products'][$_POST['product_id']]);
						$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
					}else{
						unset($_SESSION['svcart']['products']);
						$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
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
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
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
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
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
	//	}
		/* 如果全部为虚拟商品删除包装和贺卡 */
		if(!empty($_SESSION['svcart']['cart_info']['all_virtual'])){
			if(isset($_SESSION['svcart']['cards']))
				unset($_SESSION['svcart']['cards']);
			if(isset($_SESSION['svcart']['packagings']))
				unset($_SESSION['svcart']['packagings']);
		}
		if($is_ajax == 0){
			$this->page_init();
			$this->pageTitle = isset($result['message'])?$result['message']:$this->languages['delete'].$this->languages['successfully']." - ".$this->configs['shop_title'];;
			$this->flash(isset($result['message'])?$result['message']:$this->languages['delete'].$this->languages['successfully'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"/carts/",10);					
		}
		
		$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function act_quantity_change($id='',$q='',$type=''){
		if($id !='' || $q !='' || $type !=''){
			$_POST['type'] = $type;
			$_POST['product_id'] = $id;
			$_POST['quantity'] = $q;
			$is_ajax = 0;
		}else{
			$is_ajax = 1;
		}
		$result=array();
		if($this->RequestHandler->isPost()){
			if($_POST['type'] == 'product'){
			//将商品从SV-Cart中删除
		//		if($this->in_svcart($_POST['product_id'])){
				if(isset($_SESSION['svcart']['products'][$_POST['product_id']])){
					$product_info = $this->Product->findbyid($_SESSION['svcart']['products'][$_POST['product_id']]['Product']['id']);//商品属性待处理！
					if(isset($this->configs['enable_out_of_stock_handle']) && sizeof($this->configs['enable_out_of_stock_handle'])>0){
						$can_by_quantity = ($product_info['Product']['quantity']-$product_info['Product']['frozen_quantity']);
					}else{
						$can_by_quantity = $product_info['Product']['quantity'];
					}
						//$_SESSION['svcart']['products'][$product_id]['quantity']
					if($_POST['quantity'] > $product_info['Product']['max_buy']){
						$result['type']=1;
						$result['message']=$this->languages['expand_max_number'];
					}elseif($_POST['quantity'] < $product_info['Product']['min_buy']){
						$result['type']=1;
						$result['message']=$this->languages['least_number'].$product_info['Product']['min_buy'];
					}elseif($_POST['quantity'] > $can_by_quantity){
						$result['type']=1;
						$result['message']= $this->languages['stock_is_not_enough'];
					}else{
						$result['type']=0;
						if($_SESSION['svcart']['products'][$_POST['product_id']]['quantity'] < $_POST['quantity']){
							$act_type =  "is_add";
							$change = $_POST['quantity'] - $_SESSION['svcart']['products'][$_POST['product_id']]['quantity'];
						}
							$change = $_POST['quantity'] - $_SESSION['svcart']['products'][$_POST['product_id']]['quantity'];
					
						$_SESSION['svcart']['products'][$_POST['product_id']]['quantity'] = $_POST['quantity'];
					//	pr($_POST['quantity']);
						if(isset($_SESSION['svcart']['products'][$_POST['product_id']]['save_cart'])){
						//	$cart_info = $this->Cart->findbyid($_SESSION['svcart']['products'][$_POST['product_id']]['save_cart']);
							$cart_info['product_quantity'] = $_POST['quantity'];
							$cart_info['id'] = $_SESSION['svcart']['products'][$_POST['product_id']]['save_cart'];
							$this->Cart->save($cart_info);
						}
						if(isset($this->configs['enable_out_of_stock_handle']) && sizeof($this->configs['enable_out_of_stock_handle'])>0){
							$product_info['Product']['frozen_quantity'] += $change;
							$this->Product->save($product_info['Product']);
						}
						
						$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);  
						$this->ajax_page_init();
					}
				}else{
					$result['type']=1;
					$result['message']=$this->languages['no_products_in_cart'];
				}
			

				//SV-Cart里的信息
				if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
					$this->statistic_svcart();
					if($result['type']== 0){
						if(!isset($_SESSION['svcart']['point']['fee']) || !isset($_SESSION['svcart']['point']['point'])){
							$_SESSION['svcart']['point']['fee'] = 0;
							$_SESSION['svcart']['point']['point'] = 0;
						}						
						if(isset($_SESSION['User']['User']['id']) && $_SESSION['svcart']['products'][$_POST['product_id']]['use_point'] >0 && isset($act_type) && $act_type == "is_add"){
							$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
							//可以用的 积分
							$can_use_point = round($_SESSION['svcart']['products'][$p_id]['subtotal']/$_SESSION['svcart']['products'][$_POST['product_id']]['quantity']/100*$this->configs['proportion_point']);
						//	$can_use_point = round($_SESSION['svcart']['cart_info']['sum_subtotal']/100*$this->configs['proportion_point']);
							$_SESSION['svcart']['products'][$_POST['product_id']]['use_point'] = isset($_SESSION['svcart']['products'][$_POST['product_id']]['use_point'])?$_SESSION['svcart']['products'][$_POST['product_id']]['use_point']:0;									
						//1 该商品已使用的积分是否大于可用积分
						//2 商品
						//3
							if($_SESSION['svcart']['products'][$_POST['product_id']]['use_point'] > 0 && ($_SESSION['svcart']['products'][$_POST['product_id']]['use_point'] + $_SESSION['svcart']['products'][$_POST['product_id']]['Product']['point_fee']) > $can_use_point){
								$buy_point = $can_use_point -$_SESSION['svcart']['products'][$_POST['product_id']]['use_point'];
							}else if(($_SESSION['svcart']['products'][$_POST['product_id']]['Product']['point_fee']+$_SESSION['svcart']['point']['point']) <=$can_use_point){
								$buy_point = $_SESSION['svcart']['products'][$_POST['product_id']]['Product']['point_fee'];
							}else{
								$buy_point = $can_use_point - $_SESSION['svcart']['point']['point'];
							}
							$point_fee = round($buy_point/100*$this->configs['conversion_ratio_point']);
							if($user_info['User']['point'] >= $buy_point){
								$_SESSION['svcart']['point']['point'] += $buy_point;
								$_SESSION['svcart']['point']['fee'] += $point_fee;
								$_SESSION['svcart']['products'][$_POST['product_id']]['use_point'] += $buy_point;
							}else{
								$_SESSION['svcart']['point']['point'] += $user_info['User']['point'];
								$_SESSION['svcart']['point']['fee'] += round($user_info['User']['point']/100*$this->configs['conversion_ratio_point']);
								$_SESSION['svcart']['products'][$_POST['product_id']]['use_point'] += $user_info['User']['point'];
							}
						}else{
					//		if(){
								if(isset($_SESSION['svcart']['products'][$_POST['product_id']]['use_point']) && $_SESSION['svcart']['products'][$_POST['product_id']]['use_point'] >0 && $_SESSION['svcart']['products'][$_POST['product_id']]['use_point'] >= $_SESSION['svcart']['products'][$_POST['product_id']]['Product']['point_fee']){
									$_SESSION['svcart']['products'][$_POST['product_id']]['use_point'] -= $_SESSION['svcart']['products'][$_POST['product_id']]['Product']['point_fee'];
									$_SESSION['svcart']['point']['point'] -= $_SESSION['svcart']['products'][$_POST['product_id']]['Product']['point_fee'];
									$_SESSION['svcart']['point']['fee'] -= round($_SESSION['svcart']['products'][$_POST['product_id']]['Product']['point_fee']/100*$this->configs['conversion_ratio_point']);
								}else{
									$_SESSION['svcart']['products'][$_POST['product_id']]['use_point'] = 0;
									$_SESSION['svcart']['point']['point'] -= $_SESSION['svcart']['products'][$_POST['product_id']]['use_point'];
									$_SESSION['svcart']['point']['fee'] -= round($_SESSION['svcart']['products'][$_POST['product_id']]['use_point']/100*$this->configs['conversion_ratio_point']);
								}
					//		}
						}
					}
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
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
				
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
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
					
					
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
		if($is_ajax == 1){
			$this->layout = 'ajax';
		}else{
			return $result['type'];
		}
	}	
	
	function in_svcart($product_id,$attributes = ""){
		if($attributes == ""){
			if(isset($_SESSION['svcart']['products'][$product_id]) && $_SESSION['svcart']['products'][$product_id]['quantity']>0){
				if(isset($_SESSION['svcart']['products'][$product_id]['Product']['attributes']) && sizeof($_SESSION['svcart']['products'][$product_id]['Product']['attributes'])>0){
					return false;
				}else{
					return true;
				}
			}else{
				return false;
			}
		}else{
			if(isset($_SESSION['svcart']['products'][$product_id]) && $_SESSION['svcart']['products'][$product_id]['quantity']>0){
				if(isset($_SESSION['svcart']['products'][$product_id]['Product']['attributes']) && sizeof($_SESSION['svcart']['products'][$product_id]['Product']['attributes'])>0 && is_array($attributes) && sizeof($attributes)>0){
					$is_attributes =0;
					foreach($attributes as $k=>$v){
						if(in_array($v,$_SESSION['svcart']['products'][$product_id]['Product']['attributes'])){
							$is_attributes ++;
						}
					}
					if($is_attributes == sizeof($_SESSION['svcart']['products'][$product_id]['Product']['attributes'])){
						return true;
					}else{
						return false;
					}
				}else{
					return true;
				}
			}else{
				return false;
			}			
		}
	}
	
	function in_svcart_packaging($product_id){
		return (isset($_SESSION['svcart']['packagings'][$product_id]) && $_SESSION['svcart']['packagings'][$product_id]['quantity']>0);
	}
	function in_svcart_card($product_id){
		return (isset($_SESSION['svcart']['cards'][$product_id]) && $_SESSION['svcart']['cards'][$product_id]['quantity']>0);
	}
	
	function is_promotion($product_info){
		return ($product_info['Product']['promotion_status'] == '1' && $product_info['Product']['promotion_start'] <= date("Y-m-d H:i:s") && $product_info['Product']['promotion_end'] >= date("Y-m-d H:i:s"));
	}
	
	function statistic_svcart($type = 'product'){
		//总现合计
		$_SESSION['svcart']['cart_info']['sum_subtotal'] = 0;
		//总原合计
		$_SESSION['svcart']['cart_info']['sum_market_subtotal'] = 0;
		$_SESSION['svcart']['cart_info']['sum_weight'] = 0;
		
		//pr($_SESSION);
		if($type == 'product'){
			$product_ranks = $this->ProductRank->findall_ranks();
			if(isset($_SESSION['User']['User'])){
				$user_rank_list=$this->UserRank->findrank();		
			}
			$_SESSION['svcart']['cart_info']['product_subtotal'] = 0;
			//是否全为虚拟商品
			$_SESSION['svcart']['cart_info']['all_virtual'] = 1;

			if(isset($_SESSION['svcart']['products'])){	
				foreach($_SESSION['svcart']['products'] as $i=>$p){
					if(isset($this->configs['volume_setting']) && $this->configs['volume_setting'] == 1){
						$product_volume = $this->ProdcutVolume->find(array('ProdcutVolume.product_id'=>$p['Product']['id'],'ProdcutVolume.volume_number '=>$p['quantity']));
						if(isset($product_volume['ProdcutVolume'])){
							$volume_price = $product_volume['ProdcutVolume']['volume_price'];
						}
					}					
					
					$_SESSION['svcart']['cart_info']['sum_weight'] += $p['Product']['weight']*$p['quantity'];
					if(empty($p['Product']['extension_code'])){
						$_SESSION['svcart']['cart_info']['all_virtual'] = 0;
					}
					//获得是否有会员价
					if(isset($_SESSION['User'])){
						if(isset($product_ranks[$p['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$p['Product']['id']][$_SESSION['User']['User']['rank']])){
							if(isset($product_ranks[$p['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$p['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
							  $p['Product']['product_rank_price']= $product_ranks[$p['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
							}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
							  $p['Product']['product_rank_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($p['Product']['shop_price']);			  
							}
						}						
						
					//	$p['Product']['product_rank_price'] = 	$this->Product->user_price($i,$p,$this);

						
						
					}else{
					//如果会员未登录 删除SESSION中残留的product_rank_price
						if(isset($p['Product']['product_rank_price']) || isset($_SESSION['svcart']['products'][$i]['product_rank_price'])){
							unset($p['Product']['product_rank_price']);
							unset($_SESSION['svcart']['products'][$i]['product_rank_price']);
						}
					}
					
					//有会员价
					if(isset($volume_price)){
						$promotion_price = $volume_price;
						$_SESSION['svcart']['cart_info']['sum_subtotal'] += $volume_price*$p['quantity'];					
					}elseif(isset($p['Product']['product_rank_price'])){
						$promotion_price = $p['Product']['product_rank_price'];
						$_SESSION['svcart']['products'][$i]['product_rank_price'] = $promotion_price;
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
					$_SESSION['svcart']['cart_info']['product_subtotal'] += $promotion_price*$p['quantity'];
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
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   

			}
				//判断是否有贺卡和包装
				if(isset($_SESSION['svcart']['packagings'])){
					foreach($_SESSION['svcart']['packagings'] as $i=>$p){
						//包装小计
						if(isset($_SESSION['svcart']['cart_info']['product_subtotal']) && ($p['Packaging']['free_money'] == 0 || $_SESSION['svcart']['cart_info']['product_subtotal'] < $p['Packaging']['free_money'])){
							$_SESSION['svcart']['packagings'][$i]['subtotal'] = $p['Packaging']['fee']*$p['quantity'];
							//加上包装费的总价
							$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['packagings'][$i]['subtotal'];
							$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['packagings'][$i]['subtotal'];
							unset($_SESSION['svcart']['packagings'][$i]['Packaging']['fee_free']);
						}else{
							$_SESSION['svcart']['packagings'][$i]['Packaging']['fee_free'] = 0;
							$_SESSION['svcart']['packagings'][$i]['subtotal'] = 0;
						}
					}
				}
				if(isset($_SESSION['svcart']['cards'])){
					foreach($_SESSION['svcart']['cards'] as $i=>$p){
						if(isset($_SESSION['svcart']['cart_info']['product_subtotal']) && ($p['Card']['free_money'] == 0 || $_SESSION['svcart']['cart_info']['product_subtotal'] < $p['Card']['free_money'])){
							//贺卡小计
							$_SESSION['svcart']['cards'][$i]['subtotal'] = $p['Card']['fee']*$p['quantity'];
							//加上贺卡费的总价
							$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['cards'][$i]['subtotal'];
							$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['cards'][$i]['subtotal'];
							unset($_SESSION['svcart']['cards'][$i]['Card']['fee_free']);
						}else{
							$_SESSION['svcart']['cards'][$i]['Card']['fee_free'] = 0;
							$_SESSION['svcart']['cards'][$i]['subtotal'] = 0;
						}
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
					if(isset($_SESSION['svcart']['cart_info']['product_subtotal']) && ($p['Packaging']['free_money'] == 0 || $_SESSION['svcart']['cart_info']['product_subtotal'] < $p['Packaging']['free_money'])){
						//包装小计
						$_SESSION['svcart']['packagings'][$i]['subtotal'] = $p['Packaging']['fee']*$p['quantity'];
						$_SESSION['svcart']['packagings'][$i]['is_promotion'] = 0;
						//总现合计
						$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['packagings'][$i]['subtotal'];
						//总原合计
						$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['packagings'][$i]['subtotal'];
						unset($_SESSION['svcart']['packagings'][$i]['Packaging']['fee_free']);
					}else{
						$_SESSION['svcart']['packagings'][$i]['Packaging']['fee_free'] = 0;
						$_SESSION['svcart']['packagings'][$i]['subtotal'] = 0;
						$_SESSION['svcart']['packagings'][$i]['is_promotion'] = 0;
					}
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
					if(isset($_SESSION['svcart']['cart_info']['product_subtotal']) && ($p['Card']['free_money'] == 0 && $_SESSION['svcart']['cart_info']['product_subtotal'] < $p['Card']['free_money'])){
						$_SESSION['svcart']['cards'][$i]['subtotal'] = $p['Card']['fee']*$p['quantity'];//小计
						$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['cards'][$i]['subtotal'];
						$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['cards'][$i]['subtotal'];
						unset($_SESSION['svcart']['cards'][$i]['Card']['fee_free']);
					}else{
						$_SESSION['svcart']['cards'][$i]['subtotal'] = 0;//小计
						$_SESSION['svcart']['cards'][$i]['Card']['fee_free'] = 0;
					}
				}
			}
		}
	
		if($type == 'card'){
			if(isset($_SESSION['svcart']['cards'])){
				foreach($_SESSION['svcart']['cards'] as $i=>$p){
					if(isset($_SESSION['svcart']['cart_info']['product_subtotal']) && ($p['Card']['free_money'] == 0 && $_SESSION['svcart']['cart_info']['product_subtotal'] < $p['Card']['free_money'])){
						$_SESSION['svcart']['cards'][$i]['subtotal'] = $p['Card']['fee']*$p['quantity'];//小计
						$_SESSION['svcart']['cards'][$i]['is_promotion'] = 0;
						//总现合计
						$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['cards'][$i]['subtotal'];
						//总原合计
						$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['cards'][$i]['subtotal'];
						unset($_SESSION['svcart']['cards'][$i]['Card']['fee_free']);
					}else{
						$_SESSION['svcart']['cards'][$i]['subtotal'] = 0;//小计
						$_SESSION['svcart']['cards'][$i]['is_promotion'] = 0;		
						$_SESSION['svcart']['cards'][$i]['Card']['fee_free'] = 0;
					}
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
					if(isset($_SESSION['svcart']['cart_info']['product_subtotal']) && ($p['Packaging']['free_money'] >0 || $_SESSION['svcart']['cart_info']['product_subtotal'] < $p['Packaging']['free_money'])){
						$_SESSION['svcart']['packagings'][$i]['subtotal'] = $p['Packaging']['fee']*$p['quantity'];
						$_SESSION['svcart']['cart_info']['sum_subtotal'] += $_SESSION['svcart']['packagings'][$i]['subtotal'];
						$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['packagings'][$i]['subtotal'];
						unset($_SESSION['svcart']['packagings'][$i]['Packaging']['fee_free']);
					}else{
						$_SESSION['svcart']['packagings'][$i]['subtotal'] = 0;
						$_SESSION['svcart']['packagings'][$i]['Packaging']['fee_free'] = 0;
					}
				}
			}
		}
		//节省
		$_SESSION['svcart']['cart_info']['discount_price'] = $_SESSION['svcart']['cart_info']['sum_market_subtotal'] - $_SESSION['svcart']['cart_info']['sum_subtotal'];
		$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   

	}
	
	function done(){
		$weight = 0;
		if(isset($_POST['no_ajax'])){
			if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
				foreach($_SESSION['svcart']['products'] as $k=>$v){
					$weight += $v['Product']['weight'];
				}
			}
			if(isset($_SESSION['svcart']['packagings']) && sizeof($_SESSION['svcart']['packagings']) > 0){
				foreach($_SESSION['svcart']['packagings'] as $k=>$v){
					if(isset($_POST['packaging'][$v['Packaging']['id']])){
						$_SESSION['svcart']['packagings'][$k]['Packaging']['note'] = $_POST['packaging'][$v['Packaging']['id']];
					}
				}
			}
			if(isset($_SESSION['svcart']['cards']) && sizeof($_SESSION['svcart']['cards']) > 0){
				foreach($_SESSION['svcart']['cards'] as $k=>$v){
					if(isset($_POST['card'][$v['Card']['id']])){
						$_SESSION['svcart']['cards'][$k]['Card']['note'] = $_POST['card'][$v['Card']['id']];
					}
				}
			}
			
			if(isset($_POST['payment_id']) && $_POST['payment_id'] > 0){
				$this->confirm_payment($_POST['payment_id']);
			}
			if(isset($_POST['use_point']) && $_POST['use_point'] > 0){
				$this->usepoint($_POST['use_point']);
			}
			if(isset($_POST['select_coupon']) && $_POST['select_coupon'] >0){
				$this->usecoupon($_POST['select_coupon'],'is_id');
			}else if(isset($_POST['use_coupon']) && $_POST['use_coupon'] != ""){
				$this->usecoupon($_POST['use_coupon'],'is_sn');
			}


			if(isset($_POST['shipping_id']) && $_POST['shipping_id'] > 0){
				$shippings = $this->show_shipping_by_address($_SESSION['svcart']['address']['id'],$weight,$is_ajax=0);
				if(is_array($shippings) && sizeof($shippings)>0){
					foreach($shippings as $k=>$v){
						if($_POST['shipping_id'] == $v['Shipping']['id']){
							$select_shipping = array(
											"shipping_id" => $v['Shipping']['id'],
											"shipping_fee" => $v['ShippingArea']['fee'],
											"free_subtotal" => $v['ShippingArea']['free_subtotal'],
											"support_cod" => $v['Shipping']['support_cod']
													);
							if(isset($_POST['shipping_id_insure']) && $_POST['shipping_id_insure'] == $_POST['shipping_id']){
								$select_shipping['insure_fee'] = $v['Shipping']['insure_fee'];
							}else{
								$select_shipping['insure_fee'] = 0;
							}
						}
					}
				}
				$this->confirm_shipping($select_shipping);
			}
		}
		//header("Cache-Control: no-cache, must-revalidate"); 
		$do_action = 1;
		$this->order_price();
		if(!(isset($_SESSION['User']))){
			$_SESSION['back_url'] = $this->server_host.$this->cart_webroot."carts/checkout/";
			$this->redirect($this->server_host.$this->user_webroot.'login/');
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
		//	pr($_POST);
			if(isset($_POST['payment_id'])){
				$this->Payment->set_locale($this->locale);
				$post_pay = $this->Payment->findbyid($_POST['payment_id']);
				if(isset($post_pay['Payment']['code']) && $post_pay['Payment']['code'] == "account_pay"){
						$error_arr[] = $this->languages['lack_balance_supply_first'];
				}else{
						$error_arr[] = $this->languages['please_choose'].$this->languages['payment'];
				}
			}else{
				$error_arr[] = $this->languages['please_choose'].$this->languages['payment'];
			}
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
			//$order['id']						=  "";
			$order['user_id']					= $_SESSION['User']['User']['id'];
			$order['status'] 					= 0;														//订单状态-应该去系统参数里面取
			$order['consignee'] 				= $_SESSION['svcart']['address']['consignee'];
       		$now = date("Y-m-d H:i:s");
			$order['created'] 					= $now;
			if(isset($_POST['order_note'])){
				$order['note'] 				=   $_POST['order_note'];
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
			$order['total'] 					= $_SESSION['svcart']['cart_info']['total'];			//总计
			//余额支付 修改支付状态		
			if($_SESSION['svcart']['payment']['code'] == "account_pay"){
				$order['payment_status'] 			= 2;												//支付状态-应该去系统参数里面取
				$order['status'] 					= 1;
				$order['payment_time']				= date("Y-m-d H:i:s");								//支付时间-应该根据具体支付方法来设
				$order['money_paid'] = $_SESSION['svcart']['cart_info']['total']; 						//已付金额
			}
		    $pay = $this->Payment->findbyid($_SESSION['svcart']['payment']['payment_id']);
			if($pay['Payment']['code'] == "post"){  
				$order['payment_status'] 			= 0;											
			}
			if($pay['Payment']['code'] == "bank"){ 
				$order['payment_status'] 			= 0;												
			}
			if(isset($_SESSION['svcart']['coupon']['coupon'])){
				$order['coupon_id'] =  $_SESSION['svcart']['coupon']['coupon'];
				$order['total'] += $_SESSION['svcart']['coupon']['fee']; 
			}
			
			if(isset($_SESSION['svcart']['shipping']['insure_fee'])){
				$order['insure_fee']  = $_SESSION['svcart']['shipping']['insure_fee'];
			}
			$order['order_locale']              = $this->locale;		//订单语言
			$this->Payment->set_locale($this->locale);
			$pay_type = $this->Payment->findbycode('paypal');
	 		eval($pay_type['Payment']['config']);
			if(@isset($payment_arr['languages_type']['value'][$this->locale]['value'])){
				$order['order_currency']            = $payment_arr['languages_type']['value'][$this->locale]['value'];		//订单货币
				$order_currency						= $payment_arr['languages_type']['value'][$this->locale]['value'];
			}
			$order['order_domain']              = $this->server_host;				//订单域名
			
			
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
//			$order['from_ad'] 					= '';													//广告来源

			if(isset($_COOKIE['CakeCookie']['referer'])){
				$order['referer'] 						= $_COOKIE['CakeCookie']['referer'];					//订单来源
			}
			if(isset($_COOKIE['CakeCookie']['union_source'])){
				$order['union_user_id'] 				= $_COOKIE['CakeCookie']['union_source'];					
			}			
			
			if(isset($_SESSION['svcart']['point']['point'])){
				$order['point_fee'] = $_SESSION['svcart']['point']['fee'];
				$order['point_use'] = $_SESSION['svcart']['point']['point'];
				$order['total'] += $_SESSION['svcart']['point']['fee']; 
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
			if(isset($_SESSION['svcart']['point']['point']) && $_SESSION['svcart']['point']['point'] > 0){
				$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
				$user_info['User']['point'] -= $_SESSION['svcart']['point']['point'];
				$this->User->save($user_info);
				$point_log = array("id"=>"",
									"user_id" => $_SESSION['User']['User']['id'],
									"point" => 0-$_SESSION['svcart']['point']['point'],
									"log_type" => "O",
									"system_note" => "订单消费",
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
					if($_SESSION['svcart']['cart_info']['sum_subtotal'] >=  $v['Packaging']['free_money'] && $v['Packaging']['free_money'] > 0){
						$orderpackaging['packaging_fee'] = 0;
					}else{
						$orderpackaging['packaging_fee'] = $v['Packaging']['fee'];
					}
					$orderpackaging['packaging_quantity'] = $v['quantity'];
					$sum_packagings += $orderpackaging['packaging_fee'];
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
					//$ordercard['card_fee'] = $v['Card']['fee'];
					if($_SESSION['svcart']['cart_info']['sum_subtotal'] >=  $v['Card']['free_money'] && $v['Card']['free_money'] > 0){
						$ordercard['card_fee'] = 0;
					}else{
						$ordercard['card_fee'] = $v['Card']['fee'];
					}
					$sum_cards += $ordercard['card_fee'];
					$ordercard['card_quantity'] = $v['quantity'];
					if(isset($v['Card']['note'])){
						$ordercard['note'] = $v['Card']['note'];
					}
					$this->OrderCard->save(array('OrderCard'=>$ordercard));
					unset($ordercard);
				}
			}

			$product_point = array();
			$is_show_virtual_msg = 0;
			$send_coupon = array();
			foreach($_SESSION['svcart']['products'] as $k=>$v)
			{
				$product_point[$k] = array(
											'point' => $v['Product']['point']*$v['quantity'],
											'name' => $v['ProductI18n']['name']
											);
				$orderproduct = array();
				$orderproduct['id'] = '';
				$orderproduct['order_id'] = $order_id;
				$orderproduct['product_id'] = $v['Product']['id'];
				$orderproduct['product_name'] = $v['ProductI18n']['name'];
				$orderproduct['product_code'] = $v['Product']['code'];
				$orderproduct['product_quntity'] = $v['quantity'];
				$orderproduct['product_weight'] = $v['quantity']*$v['Product']['weight'];
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
				
				if(isset($v['attributes'])){
					$orderproduct['product_attrbute'] = $v['attributes'];	
				}
				$this->OrderProduct->save(array('OrderProduct'=>$orderproduct));					
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
			   						"amount"=>0-$_SESSION['svcart']['cart_info']['total'],
			   						"log_type" => "O",
			   						"system_note" => "订单消费",
			   						"type_id"=>$order_id
			   						);
			   $this->UserBalanceLog->save($balance_log);				
			   //如果是余额支付  付款送积分
			   
				// 超过订单金额赠送积分
				if($this->configs['order_smallest'] <= $update_order['Order']['subtotal'] && $this->configs['out_order_gift_points'] == 1 && $this->configs['out_order_points']>0){
					$user_info = $this->User->findbyid($update_order['Order']['user_id']);
					$user_info['User']['point'] += $this->configs['out_order_points'];
					$user_info['User']['user_point'] += $this->configs['out_order_points'];
					$this->User->save($user_info);
					$point_log = array("id"=>"",
										"user_id" => $update_order['Order']['user_id'],
										"point" => $this->configs['out_order_points'],
										"log_type" => "B",
										"system_note" => "超过订单金额 ".$this->configs['order_smallest']." 赠送积分",
										"type_id" => $update_order['Order']['id']
										);
					$this->UserPointLog->save($point_log);
				}
							//下单是否送积分
				if($this->configs['order_gift_points'] == 1 && $this->configs['order_points'] >0){
					$user_info = $this->User->findbyid($update_order['Order']['user_id']);
					$user_info['User']['point'] += $this->configs['order_points'];
					$user_info['User']['user_point'] += $this->configs['order_points'];
					$this->User->save($user_info);
					$point_log = array("id"=>"",
										"user_id" => $update_order['Order']['user_id'],
										"point" => $this->configs['order_points'],
										"log_type" => "B",
										"system_note" => "下单送积分",
										"type_id" => $update_order['Order']['id']
										);
					$this->UserPointLog->save($point_log);
				} 
				// 商品送积分
				//$order_total['Order']['id']
	            if(is_array($product_point) && sizeof($product_point)>0){
	            	foreach($product_point as $k=>$v){
	            		if($v['point'] > 0){
							$user_info = $this->User->findbyid($update_order['Order']['user_id']);
							$user_info['User']['point'] += $v['point'];
							$user_info['User']['user_point'] += $v['point'];
							$this->User->save($user_info);
							$point_log = array("id"=>"",
												"user_id" => $update_order['Order']['user_id'],
												"point" => $v['point'],
												"log_type" => "B",
												"system_note" => "商品 ".$v['name']." 送积分",
												"type_id" => $update_order['Order']['id']
												);
							$this->UserPointLog->save($point_log);
						}
					}
	            }		
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
			if(isset($_SESSION['svcart']['coupon']['fee'])){
				$pay_log['amount'] -= $_SESSION['svcart']['coupon']['fee'];
				$order['total'] -= $_SESSION['svcart']['coupon']['fee'];
			}
			if(isset($_SESSION['svcart']['point']['fee'])){
				$pay_log['amount'] -= $_SESSION['svcart']['point']['fee'];
				$order['total'] -= $_SESSION['svcart']['point']['fee'];
			}			
			$pay_log['is_paid'] = 0;
			$this->PaymentApiLog->save($pay_log);
			$order['log_id'] = $this->PaymentApiLog->id;
			if(isset($payment_arr) && isset($payment_arr['languages_type']['value'][$this->locale]['value'])){
				$order['currency_code'] =$payment_arr['languages_type']['value'][$this->locale]['value'];
			}
			$pay_php = $pay['Payment']['php_code'];
			
			$str = "\$pay_class = new ".$pay['Payment']['code']."();";
			if($pay['Payment']['code'] == "bank" || $pay['Payment']['code'] == "post" || $pay['Payment']['code'] == "COD" ||  $pay['Payment']['code'] == "account_pay"){
				$pay_message = $pay['PaymentI18n']['description'];
				$this->set('pay_message',$pay_message);
			}else if($pay['Payment']['code'] == "alipay"){
				eval($pay_php);
				@eval($str);
				$url = $pay_class->get_code($order,$pay,$this);
				$this->set('pay_button',$url);
			}else{
				eval($pay_php);
				@eval($str);
				$url = $pay_class->get_code($order,$pay,$this);
				$this->set('pay_message',$url);
			}
			$this->del_cart_product("done");
		//	unset($_SESSION['svcart']);
		//	$this->Cookie->del('cart_cookie');
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
			$categories = $this->Category->findassoc($this->locae);
			$brands = $this->Brand->findassoc($this->locale);
			
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
		$this->Category->tree('P',0,$this->locale);
		$this->set('categories', $this->Category->allinfo['assoc']);
		//品牌信息
		$this->Brand->set_locale($this->locale);
		$this->set('brands',$this->Brand->findassoc($this->locale));
	}
	
	function confirm_address($a_id="",$type = 0){
	//	if(isset($this->configs['use_ajax']) && $this->configs['use_ajax'] == 0){
		if($a_id != ''){
			$_POST['address_id'] = $a_id;
			$is_ajax = 0;
		}else{
			$is_ajax = 1;
		}
//		}
		//header("Cache-Control: no-cache, must-revalidate"); 
	//	$_POST['address_id']=41;
		$result=array();
		if(isset($_SESSION['User']['User']['id'])){
			$address = $this->UserAddress->findbyid($_POST['address_id']);
			if($address['UserAddress']['user_id'] == $_SESSION['User']['User']['id']){
				$addresses_count = $this->UserAddress->find("count",array('conditions' =>"UserAddress.user_id = '".$_SESSION['User']['User']['id']."'"));
				$result['type']=0;
				$this->set('need_new_address',0);
				$this->Region->set_locale($this->locale);
					$region_array = explode(" ",trim($address['UserAddress']['regions']));
					$address['UserAddress']['regionI18n'] = "";
					foreach($region_array as $k=>$region_id){
						$region_info = $this->Region->findbyid($region_id);
						if($k < sizeof($region_array)-1){
							$address['UserAddress']['regionI18n'] .= $region_info['RegionI18n']['name']." ";
						}else{
							$address['UserAddress']['regionI18n'] .= $region_info['RegionI18n']['name'];
						}
					}
					$_SESSION['svcart']['address'] = $address['UserAddress'];
					
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   

				if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
					$weight = 0;
					foreach($_SESSION['svcart']['products'] as $k=>$v){
						$weight += $v['Product']['weight'];
					}
				}
				//通过地址找配送方式
				if($is_ajax == 0){
					$shippings = $this->show_shipping_by_address($_POST['address_id'],$weight,$is_ajax); //confirm_address
					//$this->set('shippings',$shippings);
				}
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
		if($type == 1){
			header("Location:".$this->server_host.$this->cart_webroot."carts/checkout");
		}
		
	}
	
	
	function confirm_insure_fee(){
		$result=array();
		if(isset($_SESSION['User']['User']['id'])){
			//insure_fee_confirm
			if($_POST['type']==1){
				$_SESSION['svcart']['cart_info']['total'] += $_POST['insure_fee'];
				$_SESSION['svcart']['shipping']['insure_fee_confirm'] = $_POST['insure_fee'];
			}elseif($_POST['type']==2){
				$_SESSION['svcart']['cart_info']['total'] -= $_POST['insure_fee'];
				unset($_SESSION['svcart']['shipping']['insure_fee_confirm']);
			}
			$result['type'] = 0;
			$this->set('shipping',$_SESSION['svcart']['shipping']);
		}
		$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	
	
	function confirm_shipping($s_id = ''){
		if($s_id != ''){
			$post_shipping = $s_id;
			$is_ajax = 0;
		}else{
			$is_ajax = 1;
			$post_shipping = $_POST;
		}
		//header("Cache-Control: no-cache, must-revalidate"); 
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
			$this->Shipping->set_locale($this->locale);
			$shipping = $this->Shipping->findbyid($post_shipping['shipping_id']);
			$result['change_payment'] = 0;
			if(!isset($_SESSION['svcart']['payment']['is_cod'])){
				$result['change_payment'] = 1;
			}elseif(isset($_SESSION['svcart']['payment']['is_cod']) &&  $_SESSION['svcart']['payment']['is_cod'] == 1){
				$result['change_payment'] = 1;
		//		$result['message'] = $this->languages['shipping_no_support'];
			}
		//	}else{
				$_SESSION['svcart']['shipping'] = $post_shipping;
				$_SESSION['svcart']['shipping']['shipping_name'] = $shipping['ShippingI18n']['name'];
				$_SESSION['svcart']['shipping']['shipping_description'] = $shipping['ShippingI18n']['description'];
			
				if($_SESSION['svcart']['shipping']['free_subtotal']>0 && $_SESSION['svcart']['shipping']['free_subtotal'] < $_SESSION['svcart']['cart_info']['sum_subtotal']){
					$_SESSION['svcart']['shipping']['shipping_fee'] = 0;
				//	$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['shipping']['insure_fee'];
				}else{
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['shipping']['shipping_fee'];
				//	$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['shipping']['insure_fee'];
				}

				$result['type'] = 0;
				$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   

				$this->set('svcart',$_SESSION['svcart']);
				$this->set('shipping_type',$shipping_type);
		//	}
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function edit_address(){
		//header("Cache-Control: no-cache, must-revalidate"); 
		if($this->RequestHandler->isPost()){
			$address = $this->UserAddress->findbyid($_POST['id']);
			//$tel = $address['UserAddress']['telephone'];
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
	//	pr($_POST);
		//header("Cache-Control: no-cache, must-revalidate"); 
		if($this->RequestHandler->isPost()){
			$no_error = 1;
			$result['type'] = 1;
			if(!isset($_POST['is_ajax'])){
			    $this->page_init();
			    $region_arr = isset($_POST['data']['Address']['RegionUpdate'])?$_POST['data']['Address']['RegionUpdate']:$_POST['data']['Address']['Region'];
				if(in_array($this->languages['please_choose'],$region_arr)){
		 		    $region_error = 1;					
				}else{
					$this->Region->set_locale($this->locale);
					$region_info = $this->Region->findbyparent_id($region_arr[count($region_arr)-1]);
					if(isset($region_info['Region'])){		
		 		    $region_error = 1;					
					}
				}		
				if(trim($_POST['data']['address']['name']) == ""){
					$msg = "".$this->languages['address'].$this->languages['can_not_empty']."";
		 		    $no_error = 0;						
				}elseif(trim($_POST['data']['address']['consignee']) == ""){
					$msg = "".$this->languages['consignee'].$this->languages['can_not_empty']."";
		 		    $no_error = 0;						
				}elseif(trim($_POST['data']['address']['email']) == ""){
					$msg = "".$this->languages['email'].$this->languages['can_not_empty']."";
		 		    $no_error = 0;	
				}elseif(!ereg("^[-a-zA-Z0-9_.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$_POST['data']['address']['email'])){
					$msg = "".$this->languages['email'].$this->languages['format'].$this->languages['not_correct']."";
		 		    $no_error = 0;	
				}elseif(isset($region_error) && $region_error == 1){
					$msg = "".$this->languages['please_choose'].$this->languages['region']."";
		 		    $no_error = 0;	
				}elseif(trim($_POST['data']['address']['address']) == ""){
					$msg = "".$this->languages['address'].$this->languages['label'].$this->languages['can_not_empty']."";
		 		    $no_error = 0;						
				}elseif(trim($_POST['user_tel0']) == ""){
					$msg = "".$this->languages['telephone'].$this->languages['can_not_empty']."";
		 		    $no_error = 0;						
				}elseif(trim($_POST['data']['address']['mobile']) == ""){
					$msg = "".$this->languages['mobile'].$this->languages['can_not_empty']."";
		 		    $no_error = 0;					
				}
				$telephone = $_POST['user_tel0'];

				$regions = implode(" ",$region_arr);					
				$address = array(
									'id' => isset($_POST['data']['address']['id'])?$_POST['data']['address']['id']:'',
									'user_id'=> $_SESSION['User']['User']['id'],
									'name' =>$_POST['data']['address']['name'],
									'consignee' =>$_POST['data']['address']['consignee'],
									'email' =>$_POST['data']['address']['email'],
									'address' =>$_POST['data']['address']['address'],
									'sign_building' =>$_POST['data']['address']['sign_building'],
									'zipcode' =>$_POST['data']['address']['zipcode'],
									'mobile' =>$_POST['data']['address']['mobile'],
									'best_time' =>$_POST['data']['address']['best_time'],
									'telephone'=>$telephone,
									'regions'=>$regions
									);

			}else{			
				$address=(array)json_decode(StripSlashes($_POST['address']));
			}
			if(isset($address) && $no_error){
				$address['user_id']=$_SESSION['User']['User']['id'];
				$this->UserAddress->save($address);
				$result['type'] = 0;
				$result['id'] = $this->UserAddress->id;
				if(!isset($is_ajax)){
					$this->confirm_address($result['id'],0);
				}
				$msg = $this->languages['edit'].$this->languages['successfully'];
			}
			$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   

			if(isset($_SESSION['svcart']['shipping']['shipping_fee'])){
				unset($_SESSION['svcart']['shipping']['shipping_fee']);
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
			}
			$this->set('svcart',$_SESSION['svcart']);
			$this->set('result',$result);
			if(!isset($_POST['is_ajax'])){
				$this->pageTitle = $msg."-".$this->configs['shop_name'];
				if($no_error){
				header("Location:".$this->server_host.$this->cart_webroot."carts/checkout");
				$url = '/carts/checkout';
				}else{
				$url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'/carts/checkout';
				}
				$this->flash($msg,$url,10);	
			}else{
				$this->layout = 'ajax';
			}
		}
	}
	
	//加地址
	function checkout_address_add(){
		//header("Cache-Control: no-cache, must-revalidate"); 
		$result=array();
//		$result['type']=1;
		if($this->RequestHandler->isPost()){
			if(isset($_SESSION['User']['User']['id'])){
				$address=(array)json_decode(StripSlashes($_POST['address']));
				$address['user_id']=$_SESSION['User']['User']['id'];			
				
				$this->UserAddress->save($address);
				$result['type']=0;
				$result['id']=$this->UserAddress->id;
			//	$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
				
			}else{
				$result['type']=1;
				$result['message']=$this->languages['time_out_relogin'];
			}
		}
		if(isset($_SESSION['svcart']['shipping']['shipping_fee'])){
			unset($_SESSION['svcart']['shipping']['shipping_fee']);
			$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
		}
		$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
	}

	function show_shipping_by_address($id,$weight,$is_ajax = 1){
		//取得可用的配送方式
		$address = $this->UserAddress->findbyid($id);
		$region = $this->Region->findall();
		$region_ids = explode(" ",trim($address['UserAddress']['regions']));
		$shipping_area_region_ids = $this->ShippingAreaRegion->find("list",array("conditions"=>array("ShippingAreaRegion.region_id" =>$region_ids)));
		$shipping_area_regions =  $this->ShippingAreaRegion->find('all',array('conditions'=>array('ShippingAreaRegion.id'=>$shipping_area_region_ids)));
		$shipping_area_region_lists = array();
		if(is_array($shipping_area_regions) && sizeof($shipping_area_regions) >0 ){
			foreach($shipping_area_regions as $k=>$v){
				$shipping_area_region_lists[$v['ShippingAreaRegion']['id']] = $v;
			}
		}
	//	pr($shipping_area_region_lists);
		foreach($shipping_area_region_ids as $shipping_area_region_id){
			$shipping_area_region =  $shipping_area_region_lists[$shipping_area_region_id];//$this->ShippingAreaRegion->findbyid($shipping_area_region_id);
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
			$shippings_arr = $this->Shipping->findall(array("Shipping.status" => '1',"Shipping.id"=>$shipping_ids),'','Shipping.orderby asc');
			$shippings = array();
			
			foreach($shippings_arr as $k=>$v){
				$shippings[$v['Shipping']['id']] = $v;
			}
			foreach($shippings as $k=> $v){
			//	pr($shipping_areas_distinct[$v['Shipping']['id']]);
			//  $shippings[$k]['ShippingArea'] => 改为二
				$shippings[$k]['ShippingArea'] = $shipping_areas_distinct[$v['Shipping']['id']];
		//		if($v['Shipping']['code'] == 'usps'){
		//			$php_code = unserialize(StripSlashes($v['Shipping']['php_code']));
		//		    $shippings[$k]['ShippingArea']['fee'] =	$this->Shipping->USPSParcelRate($weight,$address['UserAddress']['zipcode'],$php_code['Usps']['value'],$php_code['Password']['value']);
		//		}else{
					$shippings[$k]['ShippingArea']['fee'] = $this->ShippingArea->fee_calculation($weight,$shipping_areas_distinct[$v['Shipping']['id']],$_SESSION['svcart']['cart_info']['sum_subtotal']);
	//			}
			}
		
		//单独商品的 运费
		if(isset($_SESSION['svcart']['products']) && $this->configs['use_product_shipping_fee'] == 1){
			foreach($_SESSION['svcart']['products'] as $k=>$v){
				$shipping_sql = " ProductShippingFee.status = '1'  and ProductShippingFee.product_id = ".$v['Product']['id'];
				if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1){
					$shipping_sql .= " and ProductShippingFee.locale = '".$this->locale."'";
				}
				
				$fee_info = $this->ProductShippingFee->findall($shipping_sql);
				if(is_array($fee_info) && sizeof($fee_info)>0){
					foreach($fee_info as $k=>$v){
						if(isset($shippings[$v['ProductShippingFee']['shipping_id']])){
							$shippings[$v['ProductShippingFee']['shipping_id']]['ShippingArea']['fee'] += $v['ProductShippingFee']['shipping_fee'];
							if(isset($shippings[$v['ProductShippingFee']['shipping_id']]['ProductShippingFee']['shipping_fee'])){
								$shippings[$v['ProductShippingFee']['shipping_id']]['ProductShippingFee']['shipping_fee'] +=$v['ProductShippingFee']['shipping_fee'];
							}else{
								$shippings[$v['ProductShippingFee']['shipping_id']]['ProductShippingFee']['shipping_fee'] =$v['ProductShippingFee']['shipping_fee'];
							}
						}
					}
				}
			}
		}
		
		//pr($shippings); insure_fee
		$this->set('shipping_type',1);
		if(isset($shippings) && sizeof($shippings) == 1){
			foreach($shippings as $s=>$p){
				$_SESSION['svcart']['shipping'] = array(
														'shipping_id' => $shippings[$s]['Shipping']['id'],
														'shipping_fee' => $shippings[$s]['ShippingArea']['fee'],
														'shipping_name' => $shippings[$s]['ShippingI18n']['name'],
														'free_subtotal' =>  $shippings[$s]['ShippingArea']['free_subtotal'],
														'support_cod' => $shippings[$s]['Shipping']['support_cod'],
														'insure_fee' => $shippings[$s]['Shipping']['insure_fee'],
														'not_show_change' => '1',
														'shipping_description' => $shippings[$s]['ShippingI18n']['description']
														);
				
			}
				if($_SESSION['svcart']['shipping']['free_subtotal']>0 && $_SESSION['svcart']['shipping']['free_subtotal'] < $_SESSION['svcart']['cart_info']['sum_subtotal']){
					$_SESSION['svcart']['shipping']['shipping_fee'] = 0;
				}else{
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['shipping']['shipping_fee'];
				}
			$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
		}else{
			$_SESSION['svcart']['shipping']['not_show_change'] = '0';
		}
			$this->set('shippings',$shippings);
		}else{
			$this->set('shippings','nothing');
		}
		if($is_ajax == 0){
			return $shippings;
		}
		
	}
	
	function confirm_payment($p_id = ''){
		if($p_id != ''){
			$is_ajax = 0;
			$_POST['payment_id'] = $p_id;
		}else{
			$is_ajax = 1;
		}
		//header("Cache-Control: no-cache, must-revalidate"); 
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
			$this->Payment->set_locale($this->locale);
			$payment = $this->Payment->findbyid($_POST['payment_id']);
			if($payment['Payment']['is_cod']>0 && $_SESSION['svcart']['cart_info']['all_virtual']){
				$result['type'] = 1;
				$result['message'] = $this->languages['payment_no_support'];
			}else if((isset($_SESSION['svcart']['shipping']['support_cod']) && $payment['Payment']['is_cod']== 1 && $_SESSION['svcart']['shipping']['support_cod'] == 0)){
				$result['type'] = 1;
				$result['message'] = $this->languages['payment_no_support'];
			}else if($payment['Payment']['code'] == "account_pay"){
				$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
				if($_SESSION['svcart']['cart_info']['total'] <= $user_info['User']['balance']){
					$_SESSION['svcart']['payment']['payment_id'] = $payment['Payment']['id'];
					$_SESSION['svcart']['payment']['payment_fee'] = $payment['Payment']['fee'];
					$_SESSION['svcart']['payment']['payment_name'] = $payment['PaymentI18n']['name'];
					$_SESSION['svcart']['payment']['payment_description'] = $payment['PaymentI18n']['description'];
					$_SESSION['svcart']['payment']['is_cod'] = $payment['Payment']['is_cod'];
					$_SESSION['svcart']['payment']['code'] = $payment['Payment']['code'];
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['payment']['payment_fee'];
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
				
					$result['type'] = 0;
					$this->set('svcart',$_SESSION['svcart']);
				}else{
					$result['type'] = 1;
					$result['message'] = $this->languages['lack_balance_supply_first'];
				}
			}else{
					$_SESSION['svcart']['payment']['payment_id'] = $payment['Payment']['id'];
					$_SESSION['svcart']['payment']['payment_fee'] = $payment['Payment']['fee'];
					$_SESSION['svcart']['payment']['payment_name'] = $payment['PaymentI18n']['name'];
					$_SESSION['svcart']['payment']['payment_description'] = $payment['PaymentI18n']['description'];
					$_SESSION['svcart']['payment']['is_cod'] = $payment['Payment']['is_cod'];
					$_SESSION['svcart']['payment']['code'] = $payment['Payment']['code'];			
			
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['payment']['payment_fee'];
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
					
			$result['type'] = 0;
			$this->set('svcart',$_SESSION['svcart']);
			}
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function change_shipping(){
		//header("Cache-Control: no-cache, must-revalidate"); 
		if(isset($_SESSION['User']['User']['id'])){
			if(isset($_SESSION['svcart']['shipping']['shipping_fee'])){
			
			if($_SESSION['svcart']['shipping']['free_subtotal']>0 && $_SESSION['svcart']['shipping']['free_subtotal'] < $_SESSION['svcart']['cart_info']['sum_subtotal']){
				$_SESSION['svcart']['shipping']['shipping_fee'] = 0;
				$_SESSION['svcart']['cart_info']['total'] -=  isset($_SESSION['svcart']['shipping']['insure_fee_confirm'])?$_SESSION['svcart']['shipping']['insure_fee_confirm']:0;
			}else{
				$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['shipping']['shipping_fee'];
				$_SESSION['svcart']['cart_info']['total'] -=  isset($_SESSION['svcart']['shipping']['insure_fee_confirm'])?$_SESSION['svcart']['shipping']['insure_fee_confirm']:0;
			}				
			//$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['shipping']['free_subtotal'];
			unset($_SESSION['svcart']['shipping']);
				$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
			}
			if(isset($_SESSION['svcart']['address'])){
				if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
					$weight = 0;
					foreach($_SESSION['svcart']['products'] as $k=>$v){
						$weight += $v['Product']['weight'];
					}
				}				
				$this->show_shipping_by_address($_SESSION['svcart']['address']['id'],$weight); //change_shipping
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
		//header("Cache-Control: no-cache, must-revalidate"); 
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
			$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
		}
		$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function add_note(){
		//header("Cache-Control: no-cache, must-revalidate"); 
		if($this->RequestHandler->isPost()){
			if($_POST['type'] == 'product'){
				$_SESSION['svcart']['products'][$_POST['id']]['Product']['note'] =$_POST['note'];
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
        $conditions = "1=1 and Promotion.status = '1' ";
        $now_time = date("Y-m-d H:i:s");
    	$conditions .= " and Promotion.start_time <= '".$now_time."'";
      	$conditions .= " and Promotion.end_time >= '".$now_time."'";
        $conditions .= " and Promotion.min_amount <= $info_subtotal ";
        $conditions .= " and Promotion.max_amount >= $info_subtotal ";
        $conditions .= " or Promotion.max_amount = '0' ";
        if($id != ''){
     	   $conditions .= " and Promotion.id = $id ";
        }
        $this->Promotion->set_locale($this->locale);
        //$promotions = $this->Promotion->findall($conditions,"","Promotion.orderby asc");
        $promotions = $this->Promotion->find('all',array(
        'fields' => array('Promotion.id','Promotion.type','Promotion.type_ext','Promotion.start_time','Promotion.end_time'
        ,'Promotion.min_amount','Promotion.max_amount','Promotion.user_rank'
       	,'PromotionI18n.title','PromotionI18n.meta_keywords','PromotionI18n.meta_description'),
        'conditions'=>array($conditions),'order'=>array("Promotion.orderby asc")));
        
        
                //特惠品信息
        if(isset($promotions) && count($promotions)>0){
    		foreach($promotions as $k=>$v){
    			if($v['Promotion']['type'] == 2){
    		    	$PromotionProducts[$k] = $this->PromotionProduct->findallbypromotion_id($v['Promotion']['id']);
    				if(isset($PromotionProducts[$k]) && count($PromotionProducts[$k])>0){
    						$pro_ids = array();
    						foreach($PromotionProducts[$k] as $key=>$value){
    							$pro_ids[] = $value['PromotionProduct']['product_id'] ;
    						}
    						if(!empty($pro_ids)){
    							$this->Product->set_locale($this->locale);
    							$pro_products = $this->Product->find('all',array('fields'=>array('Product.id','Product.market_price','ProductI18n.name','Product.shop_price'),'conditions'=>array('Product.id'=>$pro_ids)));
    							$pro_products_list = array();
    							if(isset($pro_products) && sizeof($pro_products)>0){
    								foreach($pro_products as $kk=>$vv){
    									$pro_products_list[$vv['Product']['id']] = $vv;
    								}
    							}
    						}
    						
    					foreach($PromotionProducts[$k] as $key=>$value){
    						if(isset($pro_products_list[$value['PromotionProduct']['product_id']])){
    							$promotions[$k]['products'][$value['PromotionProduct']['product_id']] = $pro_products_list[$value['PromotionProduct']['product_id']];
    							$promotions[$k]['products'][$value['PromotionProduct']['product_id']]['Product']['now_fee'] = $value['PromotionProduct']['price'];
    						}
    					//	$promotions[$k]['products'][$value['PromotionProduct']['product_id']] = $this->Product->findbyid($value['PromotionProduct']['product_id']);
    					}
    				}
    			}
    		}
    	}
    	return $promotions;
	}
	
	function confirm_promotion($set_promotion = ''){
		//header("Cache-Control: no-cache, must-revalidate"); 
		if($set_promotion != ''){
			$is_ajax = 0;
			$_POST = $set_promotion;
		}else{
			$is_ajax = 1;
		}
		
	//	if($this->RequestHandler->isPost()){
			if($_POST['type'] == 0){
				$_SESSION['svcart']['cart_info']['total'] -= $_POST['type_ext'];
				$result['type'] = 0;
			}
			if($_POST['type'] == 1){
				if(isset($_SESSION['svcart']['payment']['payment_fee'])){
					$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['payment']['payment_fee'];
				}
				if(isset($_SESSION['svcart']['shipping']['shipping_fee'])){
					$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['shipping']['shipping_fee'];
				}
				if(isset($_SESSION['svcart']['point']['fee'])){
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['point']['fee'];
				}
				$_SESSION['svcart']['cart_info']['old_total'] = $_SESSION['svcart']['cart_info']['total'];
				$_SESSION['svcart']['cart_info']['total'] = round($_SESSION['svcart']['cart_info']['total']*$_POST['type_ext']/100,2);
				if(isset($_SESSION['svcart']['payment']['payment_fee'])){
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['payment']['payment_fee'];
				}
				if(isset($_SESSION['svcart']['shipping']['shipping_fee'])){
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['shipping']['shipping_fee'];
				}
				$result['type'] = 0;
			}
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
			
			$result['promotion']['title'] = $_POST['title'];
			$result['promotion']['type'] = $_POST['type'];
			$result['promotion']['promotion_fee'] = $_POST['type_ext'];
			$result['promotion']['meta_description'] = $_POST['meta_description'];
			$_SESSION['svcart']['promotion'] = $result['promotion'];
		//	$_SESSION['svcart']['promotion']['promotion_fee'] = $_POST['type_ext'];
//		}
		$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
//		pr($result);
		$this->layout = 'ajax';
	}
	
	function change_promotion(){
		//header("Cache-Control: no-cache, must-revalidate"); 
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
				if(isset($_SESSION['svcart']['payment']['payment_fee'])){
					$_SESSION['svcart']['cart_info']['total'] += $_SESSION['svcart']['payment']['payment_fee'];
				}
				if(isset($_SESSION['svcart']['shipping']['shipping_fee'])){
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
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   

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
		//header("Cache-Control: no-cache, must-revalidate"); 
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
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   

						if(isset($_SESSION['svcart']['shipping']['shipping_fee'])){
						$_SESSION['svcart']['cart_info']['total'] -= $_SESSION['svcart']['shipping']['shipping_fee'];
						unset($_SESSION['svcart']['shipping']);
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   

					}
					
                }
           	$this->set('svcart',$_SESSION['svcart']);
			$this->set('result',$result);
			$this->layout = 'ajax';
            }
        }
    }
    
    //选优惠品
    function add_promotion_product($promotion_arr = ''){
    	if($promotion_arr != ''){
    		$is_ajax = 0;
    		$_POST = $promotion_arr;
    	}else{
    		$is_ajax = 1;
    	}
    	
		//header("Cache-Control: no-cache, must-revalidate"); 
    //	if(isset($_SESSION['User']['User']['id'])){
        //	if($this->RequestHandler->isPost()){
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
										//$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
										
										if(empty($vvv['Product']['extension_code'])){
											$_SESSION['svcart']['promotion']['all_virtual'] = 0;//纯虚拟商品标记
										}
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
								//	$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
										
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
        //	}
    //    }
        		$this->set('result',$result);
			//	$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
				$this->layout = 'ajax';
    }
    /*
    function select_coupon(){
    
    
    }*/
    
    function usecoupon($c_id ="" , $type =""){
    	if($c_id != ''){
    		$_POST['coupon'] = $c_id;
    		if($type = "is_id"){
    			$_POST['is_id'] = 1;
    		}
    		$is_ajax = 0;
    	}else{
    		$is_ajax = 1;
    	}
		//header("Cache-Control: no-cache, must-revalidate"); 
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
			$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
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
	    				$result['point'] = $_POST['coupon'];
	    			if($_SESSION['svcart']['cart_info']['total'] - $coupon_type['CouponType']['money'] >0){
 						$result['type'] = 0;
		    			$_SESSION['svcart']['coupon']['cha_fee'] = 0;
						$_SESSION['svcart']['coupon']['coupon'] = $coupon['Coupon']['id'];
						$_SESSION['svcart']['coupon']['sn_code'] = $coupon['Coupon']['sn_code'];
						$old = $_SESSION['svcart']['cart_info']['total'];
						$_SESSION['svcart']['cart_info']['total'] = round(($_SESSION['svcart']['cart_info']['total'] - $coupon_type['CouponType']['money'])*$coupon['Coupon']['order_amount_discount']/100,2);
						$_SESSION['svcart']['coupon']['cha_fee'] = $old - $_SESSION['svcart']['cart_info']['total'];
						$_SESSION['svcart']['coupon']['discount'] = $coupon['Coupon']['order_amount_discount'];
						$_SESSION['svcart']['coupon']['fee'] = $coupon_type['CouponType']['money'];
						$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
					}else{
					 	$result['type'] = 1;
 						$result['msg'] = $this->languages['exceed_max_value_can_use'];
					}
													
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
    
    
    function usepoint($po = ''){
    	if($po != ''){
    		$is_ajax =0 ;
    		$_POST['point'] = $po;
    	}else{
    		$is_ajax = 1;
    	}
    	
		//header("Cache-Control: no-cache, must-revalidate"); 
 		$result['type'] = 2;
 		$result['msg'] = $this->languages['use'].$this->languages['point'].$this->languages['failed'];
     //   if($this->RequestHandler->isPost()){
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
	    	$result['fee'] = $_POST['point']*$this->configs['conversion_ratio_point']/100;
	    	if($_SESSION['svcart']['cart_info']['total'] - $result['fee'] > 0){
				$_SESSION['svcart']['point']['point'] = $_POST['point'];
		    	$_SESSION['svcart']['point']['fee'] = $_POST['point']*$this->configs['conversion_ratio_point']/100;
				$_SESSION['svcart']['cart_info']['total'] -= $_POST['point']*$this->configs['conversion_ratio_point']/100;
				$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   
				$result['type'] = 0;
			}else{
 				$result['type'] = 1;
 				$result['msg'] = $this->languages['exceed_max_value_can_use'];
			}
    //	}
    	$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
    }
    
    
	function change_coupon(){
		//header("Cache-Control: no-cache, must-revalidate"); 
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
			$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   

    		$result['type'] = 0;
    	}
    	$this->set('svcart',$_SESSION['svcart']);
		$this->set('result',$result);
		$this->layout = 'ajax';
    }    
    
    
    
    function change_point(){
		//header("Cache-Control: no-cache, must-revalidate"); 
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
			$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   

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
				if(!isset($_SESSION['svcart']['shipping']['shipping_id']) && (empty($_SESSION['svcart']['cart_info']['all_virtual'])||(isset($_SESSION['svcart']['promotion']['all_virtual']) && empty($_SESSION['svcart']['promotion']['all_virtual'])))){
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
				}elseif(!isset($_SESSION['svcart']['shipping']['shipping_id'])
					&&(empty($_SESSION['svcart']['cart_info']['all_virtual'])||(isset($_SESSION['svcart']['promotion']['all_virtual'])&&empty($_SESSION['svcart']['promotion']['all_virtual'])))){
					if(isset($_SESSION['svcart']['address']['regions'])){
						$region_array = explode(" ",trim($_SESSION['svcart']['address']['regions']));
						if(in_array($this->languages['please_choose'],$region_array)){
							$error_arr[] = $this->languages['please_choose'].$this->languages['area'];
							$result['type'] = 2;
						}else{
							if($region_array[count($region_array)-1] == "" || $region_array[count($region_array)-1] == $this->languages['please_choose']){
								$error_arr[] = $this->languages['please_choose'].$this->languages['area'];
								$result['type'] = 2;
							}else{
								$this->Region->set_locale($this->locale);
								$region_info = $this->Region->findbyparent_id($region_array[count($region_array)-1]);
								if(isset($region_info['Region'])){
									$error_arr[] = $this->languages['please_choose'].$this->languages['area'];
									$result['type'] = 2;										
								}
							}
						}
					}
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
		//header("Cache-Control: no-cache, must-revalidate"); 
    	$result['type'] = 2;
 		$result['msg'] = $this->languages['add'].$this->languages['remark'].$this->languages['failed'];
    	if($this->RequestHandler->isPost()){	
			if(isset($_SESSION['User'])){
				$_SESSION['svcart']['order_remark'] = $_POST['order_note'];
				$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   

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
		//header("Cache-Control: no-cache, must-revalidate"); 
    	$result['type'] = 2;
    	if($this->RequestHandler->isPost()){	
			if(isset($_SESSION['User'])){
				unset($_SESSION['svcart']['order_remark']);
					$save_cookie = $_SESSION['svcart'];unset($save_cookie['products']);unset($save_cookie['promotion']['products']);$this->Cookie->write('cart_cookie',serialize($save_cookie),false,3600 * 24);   

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
	
    function del_cart_product($type = ''){
	//	if($this->RequestHandler->isPost()){
		Configure::write('debug', 0);
			if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
				foreach($_SESSION['svcart']['products'] as $k=>$v){
					if(isset($v['save_cart'])){
					//	$cart_info = $this->Cart->findbyid($_SESSION['svcart']['products'][$_POST['product_id']]['save_cart']);
						$condition=array("Cart.id"=>$v['save_cart']);
						$this->Cart->deleteAll($condition);
					}
					$product_info = $this->Product->findbyid($v['Product']['id']);
					if(isset($this->configs['enable_out_of_stock_handle']) && sizeof($this->configs['enable_out_of_stock_handle'])>0){
						$product_info['Product']['frozen_quantity'] -= $v['quantity'];
						$this->Product->save($product_info['Product']);					
					}				
				}
		//	}
			
    		unset($_SESSION['svcart']);
    		$this->Cookie->del('cart_cookie');
    		$result['type'] = 1 ;
    		if($type != "done"){
				if(!isset($_POST['is_ajax'])){ 
					$this->page_init();
					$this->pageTitle = isset($result['message'])?$result['message']:$this->languages['delete'].$this->languages['successfully']." - ".$this->configs['shop_title'];;
					$this->flash(isset($result['message'])?$result['message']:$this->languages['delete'].$this->languages['successfully'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"/",10);					
				}else{	    		
	    			die($result);
	    		}
    		}
    	}
    }
    
    function save_cart($product_info,$p_id){
		$product_ranks = $this->ProductRank->findall_ranks();
		if(isset($_SESSION['User']['User'])){
			$user_rank_list=$this->UserRank->findrank();		
		}
		// 存入 cart 表
		if(isset($_SESSION['User']['User']) && (!isset($product_info['save_cart'])) && isset($this->configs['enable_out_of_stock_handle']) && sizeof($this->configs['enable_out_of_stock_handle'])>0){
			if(isset($product_ranks[$product_info['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$product_info['Product']['id']][$_SESSION['User']['User']['rank']])){
				if(isset($product_ranks[$product_info['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$product_info['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
				  $price_user= $product_ranks[$product_info['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
				}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
				  $price_user=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($product_info['Product']['shop_price']);			  
				}
			}			
			
			//$price_user = 	$this->Product->user_price(0,$product_info,$this);
			
		if(isset($price_user) && (!empty($price_user))){
			$cart_price = $price_user;
		}else{
			if($this->is_promotion($product_info)){
				$cart_price = $product_info['Product']['promotion_price'];
			}else{
				$cart_price = $product_info['Product']['shop_price'];
			}
		}
		
		$cart = array(
			'id' => '',
			'session_id' => session_id(),
			'user_id' => $_SESSION['User']['User']['id'],
			'store_id' => 0,
			'product_id' => $product_info['Product']['id'],
			'product_code' => $product_info['Product']['code'],
			'product_name' => $product_info['ProductI18n']['name'],
			'product_price' => $cart_price,
			'product_quantity' => $product_info['quantity'],
			'product_attrbute' => isset($product_info['attributes'])?$product_info['attributes']:"",
			'extension_code' => $product_info['Product']['extension_code']
		);
		$this->Cart->save($cart);
		$_SESSION['svcart']['products'][$p_id]['save_cart'] = $this->Cart->id;
		}    
    }
    
    function update_num(){
    //	pr($_POST);
    	$error_num = 0;
    	if(isset($_POST['product_num'])>0){
    		foreach($_POST['product_num'] as $k=>$v){
    			if(isset($_SESSION['svcart']['products'][$k]) && intval($v) >0){
    				$error_num	+= $this->act_quantity_change($k,intval($v),'product');
    			}else{
    			$error_num ++;
    			}
    		}
    	}
    	
    	if(isset($_POST['packaging_num'])>0){
    		foreach($_POST['packaging_num'] as $k=>$v){
    			if(isset($_SESSION['svcart']['packagings'][$k]) && intval($v) >0){
    				$error_num	+= $this->act_quantity_change($k,intval($v),'packaging');
    			}else{
    			$error_num ++;
    			}
    		}
    	}
    	if(isset($_POST['card_num'])>0){
    		foreach($_POST['card_num'] as $k=>$v){
    			if(isset($_SESSION['svcart']['cards'][$k])  && intval($v) >0){
    			$error_num	+= $this->act_quantity_change($k,intval($v),'card');
    			}else{
    			$error_num ++;
    			}
    		}    		
    	}
    	
    	if($error_num > 0){
    		$msg = "商品更新失败,请确认商品是否在购物或者商品库存不够!";
    	}else{
    		$msg = "购物车更新成功";
    	}
    	
		$this->page_init();
		$this->pageTitle = $msg." - ".$this->configs['shop_title'];;
		$this->flash($msg,$this->server_host.$this->cart_webroot.'carts/',10);					
    }
    
    function confirm_consignee($id){
    	
    	
    }
    
    function consignee($id = ''){
		$this->page_init();
		$this->pageTitle = "修改收货人信息"." - ".$this->configs['shop_title'];
		$this->Region->set_locale($this->locale);
		if(isset($_SESSION['User']['User'])){
    		$addresses = $this->UserAddress->findAllbyuser_id($_SESSION['User']['User']['id']);
					foreach($addresses as $key=>$address){
					$region_array = explode(" ",trim($address['UserAddress']['regions']));
					$addresses[$key]['UserAddress']['regions'] = "";
						foreach($region_array as $k=>$region_id){
							if($region_id!='' && $region_id != $this->languages['please_choose']){
								$region_info = $this->Region->findbyid($region_id);
								if($k < sizeof($region_array)-1){
									$addresses[$key]['UserAddress']['regions'] .= $region_info['RegionI18n']['name']." ";
								}else{
									$addresses[$key]['UserAddress']['regions'] .= $region_info['RegionI18n']['name'];
								}
							}
						}
					}    		
    		
    		
    		$this->set('addresses',$addresses);
    		if($id > 0){
    			$address = $this->UserAddress->find("UserAddress.id = ".$id." and UserAddress.user_id =".$_SESSION['User']['User']['id']);
    			if(isset($address['UserAddress'])){
    				$this->set('address',$address);
    			}
    		}
    	}else{
			$_SESSION['back_url'] = $this->server_host.$this->cart_webroot."carts/consignee/";
			
			$this->redirect($this->server_host.$this->user_webroot.'login/');
			exit;    	   	
    	}
    	$this->layout = "default_full";
    }
    
    //vancl 购物流程
    function check_address(){
   		$this->pageTitle = $this->languages['consignee'].$this->languages['information']." - ".$this->configs['shop_title'];
    	if(!isset($_SESSION['User']['User'])){
			$_SESSION['back_url'] = $this->server_host.$this->cart_webroot."carts/consignee/";
			$this->redirect($this->server_host.$this->user_webroot.'login/');
    	}elseif(!(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0)){
			$this->pageTitle = $this->languages['no_products_in_cart']." - ".$this->configs['shop_title'];
			$this->flash($this->languages['no_products_in_cart']," ","/",5);    		
    	}else{
			$addresses = $this->UserAddress->findAllbyuser_id($_SESSION['User']['User']['id']);
    		if(isset($addresses) && sizeof($addresses)>0){
				foreach($addresses as $key=>$address){
					if(isset($region_array) && sizeof($region_array)>0){
						foreach($region_array as $a=>$b){
							if($b == $this->languages['please_choose']){
								unset($region_array[$a]);
							}
						}
					}else{
						$region_array[] = 0;
					}	
					$region_array = explode(" ",trim($address['UserAddress']['regions']));
					$addresses[$key]['UserAddress']['regions'] = "";						
					$region_name_arr = $this->Region->find('all',array('fields'=>array('Region.id','Region.parent_id','Region.level','RegionI18n.name'),'conditions'=>array('Region.id'=>$region_array)));
					if(is_array($region_name_arr) && sizeof($region_name_arr)>0){
						foreach($region_name_arr as $k=>$v){
							$addresses[$key]['UserAddress']['regions'].= isset($v['RegionI18n']['name'])?$v['RegionI18n']['name']." ":"";
						}
					}						
				}
				$this->set('addresses',$addresses);    		
    		}
    	}
    	$this->layout ="default_full";
    }
    
    
    function check_shipping($id=''){
   		$this->pageTitle = $this->languages['shipping_method']." - ".$this->configs['shop_title'];
		$this->order_price();
		$this->statistic_svcart(); 				//计算金额
    	if($id != ""){
    		$this->confirm_address($id,2);
    	}
    	if(!isset($_SESSION['User']['User'])){
			$_SESSION['back_url'] = $this->server_host.$this->cart_webroot."carts/consignee/";
			$this->redirect($this->server_host.$this->user_webroot.'login/');
    	}elseif(!(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0)){
			$this->pageTitle = $this->languages['no_products_in_cart']." - ".$this->configs['shop_title'];
			$this->flash($this->languages['no_products_in_cart']," ","/",5);    		
    	}elseif(!isset($_SESSION['svcart']['address']) || $_SESSION['svcart']['address']['address'] == "" || ($_SESSION['svcart']['address']['mobile'] == "" ||$_SESSION['svcart']['address']['telephone'] == "")){
    		$this->pageTitle = $this->languages['please_choose'].$this->languages['address']." - ".$this->configs['shop_title'];
			$this->flash($this->languages['please_choose'].$this->languages['address'],$this->server_host.$this->cart_webroot."carts/check_address/","/",5);    		
    	}else{
			$weight = 0;
    		if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
				foreach($_SESSION['svcart']['products'] as $k=>$v){
					$weight += $v['Product']['weight'];
				}
			}
			$shippings = $this->show_shipping_by_address($id,$weight,$is_ajax=0);
			$this->set('shippings',$shippings);
    	}
    	$this->layout ="default_full";
    }
    
    function check_payment(){
		$this->order_price();
   		$this->pageTitle = $this->languages['payment']." - ".$this->configs['shop_title'];
		$this->statistic_svcart(); 				//计算金额
    	if(!isset($_SESSION['User']['User'])){
			$_SESSION['back_url'] = $this->server_host.$this->cart_webroot."carts/consignee/";
			$this->redirect($this->server_host.$this->user_webroot.'login/');
    	}elseif(!(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0)){
			$this->pageTitle = $this->languages['no_products_in_cart']." - ".$this->configs['shop_title'];
			$this->flash($this->languages['no_products_in_cart']," ","/",5);
			$error = 1;
    	}
    	if(!isset($error)){
	   	   	if(isset($_POST['shipping'])){
	    		$this->confirm_shipping($_POST['shipping']);
	    	}
	    	if(!isset($_SESSION['svcart']['shipping'])){
				$this->pageTitle = $this->languages['please_choose'].$this->languages['shipping_method']." - ".$this->configs['shop_title'];
				$this->flash($this->languages['please_choose'].$this->languages['shipping_method'],$this->server_host.$this->cart_webroot."carts/check_shipping/","/",5);    		
	    	}else{
	    		$this->Payment->set_locale($this->locale);
				$payments = $this->Payment->availables();
				$this->set('payments',$payments);
	    	}
    		$this->layout ="default_full";
	    }
    }
    
    function check_order(){
   		$this->pageTitle = $this->languages['checkout']." - ".$this->configs['shop_title'];
		$this->order_price();
		$this->statistic_svcart(); 				//计算金额
    	if(isset($_POST['payment'])){
    		$this->confirm_payment($_POST['payment']);
    	}
    	$this->layout ="default_full";
    }
    
    
    
}
?>