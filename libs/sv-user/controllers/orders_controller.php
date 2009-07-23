<?php
/*****************************************************************************
 * SV-Cart 用户订单
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: orders_controller.php 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/
uses('sanitize');		
class OrdersController extends AppController {

	var $name = 'Orders';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array('SystemResource','Order','OrderProduct','Payment','Shipping','PaymentApiLog','UserPointLog','VirtualCard','ProductDownload','ProductDownloadLog','ProductService','ProductServiceLog','UserBalanceLog','UserMessage','Coupon','CouponType','Region','OrderCard','OrderPackaging','Packaging','Card');

/************   我的订单首页    ***************/
	function index($order_status=0,$start_date='',$end_date='',$order_id=''){
		//未登录转登录页
		if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
				$this->redirect('/login/');
		}
		$this->page_init();
		$mrClean = new Sanitize();		
			
		$order_id = $mrClean->html($order_id, true);
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(true,$this->locale);
        $this->set('systemresource_info',$systemresource_info);//资源库信息		
		
		//当前位置
		$this->navigations[] = array('name'=>__($this->languages['order_list'],true),'url'=>"");

		$this->set('locations',$this->navigations);
		
	   $user_id=$_SESSION['User']['User']['id'];

 	   $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	   //取得我的订单
	   $condition=" Order.user_id='".$user_id."' ";
	   if($order_status == 1){
	   	   $condition .=" and Order.status = '0' ";
	   }
	   elseif($order_status == 2){
	   	   $condition .=" and Order.payment_status = '0' ";
	   }
	   elseif($order_status == 3){
	   	   $condition .=" and Order.shipping_status = '0' ";
	   }
	   if($start_date){
	   	   $condition .=" and Order.created >= '".$start_date."' ";
	   }
	   if($end_date){
	   	   $condition .=" and Order.created <= '".$end_date."' ";
	   }
	   if($order_id){
	   	   $condition .=" and Order.order_code = '".$order_id."' ";
	   }
	   //pr($condition);
	   $total = $this->Order->findCount($condition,0);
	   //pr($condition);
	   $sortClass='Order';
	   $page=1;
	   $parameters=Array($rownum,$page);
	   $options=Array();
	   $page= $this->Pagination->init($condition,"",$options,$total,$rownum,$sortClass);
	   $my_orders=$this->Order->findAll($condition,'',"Order.created DESC","$rownum",$page);
	   if(empty($my_orders)){	   		
	   	   $my_orders=array();
	   }else{
	   	    $order_coupons = array();
	   		foreach($my_orders as $k=>$v){
	   	   		$order_coupons[] = $v['Order']['coupon_id'];
	   	   	}
	       	$this->CouponType->set_locale($this->locale);
			$cache_key = md5('find_coupon_types'.'_'.$this->locale);
			$coupon_types = cache::read($cache_key);	
			if(!$coupon_types){	
				$coupon_type_arr = $this->CouponType->findall();
				$coupon_types = array();
				if(is_array($coupon_type_arr) && sizeof($coupon_type_arr)>0){
					foreach($coupon_type_arr as $k=>$v){
						$coupon_types[$v['CouponType']['id']] = $v;
					}
				}
				cache::write($cache_key,$coupon_types);	
			}
	   	    
	   	    $use_coupons = $this->Coupon->find('all',array('conditions'=>array('Coupon.id'=>$order_coupons)));
	   	    $use_coupon_fee = array();
	   	    if(is_array($use_coupons) && sizeof($use_coupons)>0){
	   	    	foreach($use_coupons as $k=>$v){
	   	    		if(isset($coupon_types[$v['Coupon']['coupon_type_id']])){
	   	    			$use_coupon_fee[$v['Coupon']['order_id']] = $coupon_types[$v['Coupon']['coupon_type_id']]['CouponType']['money'];
	   	    		}
	   	    	}
	   	    }
			$my_order_ids = array();
	   		foreach($my_orders as $k=>$v){
	   			$my_order_ids[] = $v['Order']['id'];
		       /* if($v['Order']['coupon_id'] >0){
		        	$coupon = $this->Coupon->findbyid($v['Order']['coupon_id']);
		        	$this->CouponType->set_locale($this->locale);
		        	$coupon_type = $this->CouponType->findbyid($coupon['Coupon']['coupon_type_id']);
		        	$my_orders[$k]['Order']['coupon_fee'] = $coupon_type['CouponType']['money'];
		        }else{
		        	$my_orders[$k]['Order']['coupon_fee'] = 0;
		        }*/
		        if(isset($use_coupon_fee[$v['Order']['id']])){
		        	$my_orders[$k]['Order']['coupon_fee'] = $use_coupon_fee[$v['Order']['id']];
		        }else{
		         	$my_orders[$k]['Order']['coupon_fee'] = 0;
		        }
		        
		        $my_orders[$k]['Order']['need_paid'] = number_format($v['Order']['total']-$v['Order']['money_paid']-$v['Order']['point_fee']-$my_orders[$k]['Order']['coupon_fee']-$v['Order']['discount'],2 ,'.','')+0;
	   		}
	   		//pr($my_order_ids);
	   		$order_product = $this->OrderProduct->find('all',array('conditions'=>array('OrderProduct.order_id'=>$my_order_ids)));
	   		$product_weights = array();
	   		if(isset($order_product) && sizeof($order_product)>0){
	   			foreach($order_product as $k=>$v){
	   				if(isset($product_weights[$v['OrderProduct']['order_id']])){
	   					$product_weights[$v['OrderProduct']['order_id']] += $v['OrderProduct']['product_weight']*$v['OrderProduct']['product_quntity'];
	   				}else{
	   					$product_weights[$v['OrderProduct']['order_id']] = $v['OrderProduct']['product_weight']*$v['OrderProduct']['product_quntity'];
	   				}
	   			}
	   		}
	   		$this->set('product_weights',$product_weights);
	   }
	   $condition=" Order.user_id='".$user_id."' and  Order.payment_status ='0' ";
	   $no_paid=$this->Order->findCount($condition);
	   $condition=" Order.user_id='".$user_id."' and Order.status = '0' ";
	   $no_confirm=$this->Order->findCount($condition);

	   
	   $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist'],
	   "order_paid_not_cancel" => $this->languages['order_paid_not_cancel'] ,
	   "order_delivered_not_cancel" => $this->languages['order_delivered_not_cancel']);
	   $this->set('js_languages',$js_languages);
	   $this->pageTitle = $this->languages['order_list']." - ".$this->configs['shop_title'];
	 //  pr($my_orders);exit;
	   $this->set('total',$total);
	   $this->set('order_status',$order_status);
	   $this->set('my_orders',$my_orders);
	   $this->set('no_paid',$no_paid);
	   $this->set('no_confirm',$no_confirm);
	}
/************   我的订单首页    ***************/
/****************  订单详细   *****************/
	function view($id){
		$this->page_init();
		
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(true,$this->locale);
        $this->set('systemresource_info',$systemresource_info);//资源库信息				
		
		$flash_url = $this->server_host.$this->user_webroot."orders";
		//当前位置
		$this->navigations[] = array('name'=>__($this->languages['order_list'],true),'url'=>"/orders");
	    $user_id=$_SESSION['User']['User']['id'];
	    //Configure::write('debug', 2);
	    if(!is_numeric($id) || $id<1){
		$this->pageTitle = $this->languages['invalid_id']." - ".$this->configs['shop_title'];
		    $this->flash($this->languages['invalid_id'],$flash_url,5);
	    }
	    //订单详细 /*****订单部分的处理********/
		$condition=" Order.id='".$id."' ";
		$order_info=$this->Order->find($condition);
		$this->navigations[] = array('name'=>$order_info['Order']['order_code'],'url'=>"");
				$this->set('locations',$this->navigations);

		if ($user_id > 0 && $user_id != $order_info['Order']['user_id'])
         {
			$this->pageTitle = $this->languages['not_your_order']." - ".$this->configs['shop_title'];
            $this->flash($this->languages['not_your_order'],$flash_url,5);
         }
         /* 只有未确认才允许用户修改订单地址 */
        if ($order_info['Order']['status'] == 0)
         {
            $order_info['Order']['allow_update_address'] = 1; //允许修改收货地址
         }
        else
         {
            $order_info['Order']['allow_update_address'] = 0;
         }
		//支付方式信息
		$payment_info = array();
		$payment_info = $this->Payment->findbyid($order_info['Order']['payment_id']);
         /* 如果是未付款状态，生成支付按钮 */
       if ($order_info['Order']['payment_status'] == 0 &&
           ($order_info['Order']['status'] == 0 ||
            $order_info['Order']['status'] == 1))
        {
              /*
               * 在线支付按钮
               */
              //无效支付方式
              if ($payment_info === false)
               {
                    $order_info['Order']['pay_online'] = '';
                }
              else
              {
                 //取得支付信息，生成支付代码
               }
          }
       else
       { 
             $order_info['Order']['pay_online'] = '';
        }

        /* 无配送时的处理 */
            $order_info['Order']['shipping_id'] == -1 and $order_info['Order']['shipping_name'] = $this->languages['need_not_shipping_method'];
 

        /* 支付时间 发货时间 */
       if ($order_info['Order']['payment_time'] > 0 && $order_info['Order']['payment_status'] != 0)
       {
              $order_info['Order']['payment_time'] = sprintf($this->languages['pay_in'], $order_info['Order']['payment_time']);
        }
       else
       {
              $order_info['Order']['payment_time'] = '';
        }
       if ($order_info['Order']['shipping_time'] > 0 && in_array($order_info['Order']['shipping_status'], array(1, 2)))
       {
              $order_info['Order']['shipping_time'] = sprintf($this->languages['shipping_in'],  $order_info['Order']['shipping_time']);
              
        }
       else
       {
              $order_info['Order']['shipping_time'] = '';
        }
        //是否使用积分
        if($order_info['Order']['point_use']>0){
	        $point_log_filter = "1=1";
	        $point_log_filter .= " and UserPointLog.type_id = ".$id." and UserPointLog.user_id = ".$user_id." and UserPointLog.log_type = 'O'";
	        $point_log = $this->UserPointLog->find($point_log_filter);
	        $this->set('point_log',$point_log);
        }
        
        //是否使用余额
        if($payment_info['Payment']['code'] == "account_pay"){
        	$balance_log_filter = "1=1";
       	 	$balance_log_filter .= " and UserBalanceLog.type_id = ".$id." and UserBalanceLog.user_id = ".$user_id." and UserBalanceLog.log_type = 'O'";
        	$balance_log = $this->UserBalanceLog->find($balance_log_filter);
        //	pr($balance_log);
        	$this->set('balance_log',$balance_log);
        }
        //是否用优惠券
        if($order_info['Order']['coupon_id'] >0 ){
        	$coupon = $this->Coupon->findbyid($order_info['Order']['coupon_id']);
        	$this->CouponType->set_locale($this->locale);
        	$coupon_type = $this->CouponType->findbyid($coupon['Coupon']['coupon_type_id']);
        	$order_info['Order']['coupon_fee'] = $coupon_type['CouponType']['money'];
        	$this->set('coupon_fee',$coupon_type['CouponType']['money']);
        	$this->set('coupon_discount',$coupon['Coupon']['order_amount_discount']);
        }else{
        	$order_info['Order']['coupon_fee'] = 0;
        }
        //是否有包装
        $show_note = 0;
        if($order_info['Order']['note'] != ""){
        	        $show_note = 1;
        }
        $order_packaging = $this->OrderPackaging->findallbyorder_id($order_info['Order']['id']);
		if(is_array($order_packaging) && sizeof($order_packaging)>0){
			$this->Packaging->set_locale($this->locale);
			$packagings_id = array();
			foreach($order_packaging as $k=>$v){
				$packagings_id[] = $v['OrderPackaging']['packaging_id'];
			}
			$packagings_info = $this->Packaging->find('all',array(
			'fields' =>array('Packaging.id','Packaging.img01','Packaging.fee','Packaging.free_money','PackagingI18n.name','PackagingI18n.description'),
			'conditions'=>array('Packaging.id'=>$packagings_id)));
			$packagings_list = array();
			if(is_array($packagings_info) && sizeof($packagings_info)>0){
				foreach($packagings_info as $k=>$v){
					$packagings_list[$v['Packaging']['id']] = $v;
				}
			}			

			$packaging = array();
			foreach($order_packaging as $k=>$v){
			//	$packaging_info = $this->Packaging->findbyid($v['OrderPackaging']['packaging_id']);
				if(isset($packagings_list[$v['OrderPackaging']['packaging_id']])){
					$packaging_info = $packagings_list[$v['OrderPackaging']['packaging_id']];
					$packaging[$k] = $packaging_info;
					if( $order_info['Order']['subtotal'] >= $packaging_info['Packaging']['free_money'] &&  $packaging_info['Packaging']['free_money'] > 0){
					$packaging[$k]['Packaging']['fee'] = 0;
					}else{
					$packaging[$k]['Packaging']['fee'] = $v['OrderPackaging']['packaging_fee'];
					}
					$packaging[$k]['Packaging']['note'] = $v['OrderPackaging']['note'];
					$packaging[$k]['Packaging']['quntity'] = $v['OrderPackaging']['packaging_quntity'];		
					if($v['OrderPackaging']['note'] != ""){
	        			$show_note = 1;
					}	
				}
        	}
	        	$this->set('packaging',$packaging);
		}
		$this->Card->set_locale($this->locale);
        //是否有贺卡
        $order_card = $this->OrderCard->findallbyorder_id($order_info['Order']['id']);
		if(is_array($order_card) && sizeof($order_card)>0){
			$cards_id = array();
			foreach($order_card as $k=>$v){
				$cards_id[] = $v['OrderCard']['card_id'];
			}
			$cards_info = $this->Card->find('all',array(
			'fields' =>array('Card.id','Card.img01','Card.fee','Card.free_money','CardI18n.name','CardI18n.description'),
			'conditions'=>array('Card.id'=>$cards_id)));
			$cards_list = array();
			if(is_array($cards_info) && sizeof($cards_info)>0){
				foreach($cards_info as $k=>$v){
					$cards_list[$v['Card']['id']] = $v;
				}
			}
			$card = array();
			foreach($order_card as $k=>$v){
				//$card_info = $this->Card->findbyid($v['OrderCard']['card_id']);
				if(isset($cards_list[$v['OrderCard']['card_id']])){
				$card_info = $cards_list[$v['OrderCard']['card_id']];
		//		pr($card_info);
				$card[$k] = $card_info;
				if( $order_info['Order']['subtotal'] >= $card_info['Card']['free_money'] &&  $card_info['Card']['free_money'] > 0){
					$card[$k]['Card']['fee'] = 0;
				}else{
					$card[$k]['Card']['fee'] = $v['OrderCard']['card_fee'];
				}
				$card[$k]['Card']['note'] = $v['OrderCard']['note'];
				if($v['OrderCard']['note'] != ""){
	        		$show_note = 1;
				}	
				$card[$k]['Card']['quntity'] = $v['OrderCard']['card_quntity'];	
				}		
        	}
	        	$this->set('card',$card);
		}  
	//	pr($card);
		$this->set('show_note',$show_note);
		
		
	//	pr($order_info);
		//订单商品详细  /*****订单商品部分的处理********/
		$condition=" OrderProduct.order_id='".$order_info['Order']['id']."' and  ProductI18n.locale='".$this->locale."' ";
		$order_products=$this->OrderProduct->findAll($condition);
	//	pr($order_products);
		static $market_subtotal=0;
		static $shop_subtotal=0;
		$size = count($order_products);
		foreach($order_products as $k=>$v){
			$shop_subtotal += $v['OrderProduct']['product_price']*$v['OrderProduct']['product_quntity'];
			$market_subtotal+=$v['Product']['market_price']*$v['OrderProduct']['product_quntity'];
			$order_products[$k]['OrderProduct']['one_pro_subtotal']=$v['OrderProduct']['product_price']*$v['OrderProduct']['product_quntity'];
			if($v['OrderProduct']['extension_code'] == 'virtual_card'){
				$size -- ;
			}
		}
		if($size < 1){
			$this->set('all_virtual',1);
		}
		
		$this->set('shop_subtotal',$shop_subtotal);
	//	$save_price=$market_subtotal-$order_info['Order']['subtotal'];
		$save_price=$market_subtotal-$shop_subtotal;
		if($market_subtotal > 0){
		$discount_price=round(($market_subtotal-$save_price)/$market_subtotal,2)*100 ;
		$order_info['Order']['discount_price']=$discount_price;
		$order_info['Order']['market_subtotal']=$market_subtotal;
		}else{
		$order_info['Order']['market_subtotal']= 0;
		$order_info['Order']['discount_price']= 100;
		}
		$order_info['Order']['save_price']=$save_price;
		$order_info['Order']['need_paid'] = number_format($order_info['Order']['total']-$order_info['Order']['money_paid']-$order_info['Order']['point_fee']-$order_info['Order']['coupon_fee']-$order_info['Order']['discount'],2 ,'.','')+0;

		$region_array = explode(" ",trim($order_info['Order']['regions']));
		$order_info['Order']['regions'] = "";
		$this->Region->set_locale($this->locale);
	
		$region_name_arr = $this->Region->find('all',array('conditions'=>array('Region.id'=>$region_array)));
			if(is_array($region_name_arr) && sizeof($region_name_arr)>0){
				foreach($region_name_arr as $k=>$v){
					$order_info['Order']['regions'].= isset($v['RegionI18n']['name'])?$v['RegionI18n']['name']." ":"";
			}
		}	
	
	
	
	/*	foreach($region_array as $k=>$region_id){
			$region_info = $this->Region->findbyid($region_id);
			if($k < sizeof($region_array)-1){
				$order_info['Order']['regions'] .= $region_info['RegionI18n']['name']." ";
			}else{
				$order_info['Order']['regions'] .= $region_info['RegionI18n']['name'];
			}
		}	*/	
		
		//支付方式列表
		//配送方式
		$this->Shipping->set_locale($this->locale);
		$shipping_info = $this->Shipping->findbyid($order_info['Order']['shipping_id']);
		
		
		$condition =" UserMessage.user_id='".$order_info['Order']['user_id']."' and UserMessage.parent_id = 0 and UserMessage.value_id = ".$id."";
	    $my_messages=$this->UserMessage->findAll($condition);
	   //pr($my_messages);
	   if(isset($my_messages) && is_array($my_messages) && sizeof($my_messages)>0){
		   foreach($my_messages as $k=>$v){
		   	   $replies=$this->UserMessage->findAll("UserMessage.parent_id = '".$v['UserMessage']['id']."'");
		   	   $my_messages[$k]['Reply']=$replies;
		   	   if($v['UserMessage']['msg_type'] == 0){
		   	   	      $my_messages[$k]['UserMessage']['type'] = $systemresource_info['msg_type']['0'];//$this->languages['message'];
		   	   }
		   	   else if($v['UserMessage']['msg_type'] == 1){
		   	   	      $my_messages[$k]['UserMessage']['type'] = $systemresource_info['msg_type']['1'];//$this->languages['complaint'];
		   	   }
		   	   else if($v['UserMessage']['msg_type'] == 2){
		   	   	      $my_messages[$k]['UserMessage']['type'] = $systemresource_info['msg_type']['2'];//$this->languages['inquiry'];
		   	   }
		   	   else if($v['UserMessage']['msg_type'] == 3){
		   	   	      $my_messages[$k]['UserMessage']['type'] = $systemresource_info['msg_type']['3'];//$this->languages['after_sale'];
		   	   }
		   	   else if($v['UserMessage']['msg_type'] == 4){
		   	   	      $my_messages[$k]['UserMessage']['type'] = $systemresource_info['msg_type']['4'];//$this->languages['inquire'];
		   	   }
		   	  else {
		   	   	      $my_messages[$k]['UserMessage']['type'] = $systemresource_info['msg_type']['5'];//$this->languages['untyped'];
		   	   }
		   }
		   $this->set('my_messages',$my_messages);
	   }

         /* 虚拟商品付款后处理 */
         $virtual_card = array();
         $download_product= array();
         $service_product=array();
        if ($order_info['Order']['payment_status'] != 0)
        {
			$condition=" OrderProduct.order_id='".$order_info['Order']['id']."' and  ProductI18n.locale='".$this->locale."' and  OrderProduct.extension_code>'' ";
			$order_virtual_products=$this->OrderProduct->findAll($condition);
			if(!empty($order_virtual_products))foreach($order_virtual_products as $k=>$v){
				//pr($order_virtual_products);
				/* 虚拟卡处理 */
				if($v['OrderProduct']['extension_code']=='virtual_card'){
					$VirtualCards = $this->VirtualCard->findAll("VirtualCard.product_id='".$v['OrderProduct']['product_id']."' and VirtualCard.order_id='".$id."'");
					if(!empty($VirtualCards))foreach($VirtualCards as $kk=>$vv){
						/* 解密 */
						if($vv['VirtualCard']['crc32'] == 0 || $vv['VirtualCard']['crc32'] == crc32(AUTH_KEY)){
				//			$vv['VirtualCard']['card_sn'] = $this->requestAction("/commons/decrypt/".$vv['VirtualCard']['card_sn']);;
				//			$vv['VirtualCard']['card_password'] = $this->requestAction("/commons/decrypt/".$vv['VirtualCard']['card_password']);
							$vv['VirtualCard']['card_sn'] = $this->decrypt($vv['VirtualCard']['card_sn']);
							$vv['VirtualCard']['card_password'] = $this->decrypt($vv['VirtualCard']['card_password']);							
							
						}
						$vv['VirtualCard']['name'] = $v['ProductI18n']['name'];
						//$order_info['Order']['virtual_card'][] = $vv['VirtualCard'];
						$virtual_card[$vv['VirtualCard']['product_id']][] = $vv['VirtualCard'];
					}
					//pr($order_info['Order']['virtual_card']);
				}
				/* 下载处理 */
				else if($v['OrderProduct']['extension_code']=='download_product'){
					$DownloadProducts = $this->ProductDownload->findAll("ProductDownload.product_id='".$v['OrderProduct']['product_id']."' ");
					if(!empty($DownloadProducts))foreach($DownloadProducts as $kk=>$vv){	
						$downloadlog = $this->ProductDownloadLog->findAll("ProductDownloadLog.product_id='".$vv['ProductDownload']['product_id']."' and ProductDownloadLog.order_id='".$id."'");					
						if($vv['ProductDownload']['allow_downloadtimes']=="0"){
							$vv['ProductDownload']['count']='forever';
						}else{
							$vv['ProductDownload']['count']=$vv['ProductDownload']['allow_downloadtimes']-count($downloadlog);
						}
						$vv['ProductDownload']['order_id']=$id;
						$download_product[$vv['ProductDownload']['product_id']][] = $vv['ProductDownload'];
					}
				}
				
				/* 服务处理 */
				else if($v['OrderProduct']['extension_code']=='services_product'){
					$ServiceProducts = $this->ProductService->findAll("ProductService.product_id='".$v['OrderProduct']['product_id']."' ");			
					if(!empty($ServiceProducts))foreach($ServiceProducts as $kk=>$vv){
						if(!empty($vv['ProductService']['service_cycle'])){
							$end_time= strtotime(substr($order_info['Order']['payment_time'], 9, 10))+86400*$vv['ProductService']['service_cycle'];  		
							$now=strtotime(date('Y-m-d,H:i:s'));
							$vv['ProductService']['ser_time']=date('Y-m-d',$end_time);
							$vv['ProductService']['cycle']= ceil(($end_time-$now)/86400);
						}else{
							$vv['ProductService']['cycle']='forever';
						}
						$vv['ProductService']['order_id']=$id;
						$service_product[$vv['ProductService']['product_id']][] = $vv['ProductService'];
					}
				}
			}
        }
        /*
	        SV_SIMPLE
        */
        if($order_info['Order']['payment_status']!=2){
         	$this->order_pay($order_info['Order']['id']);
        }
        
        

		/* 支持纯虚拟物品购买 */
		if(isset($shipping_info['Shipping']['support_cod']))
			$condition=" Payment.status = '1' and PaymentI18n.status = '1' and Payment.is_cod >= '".$shipping_info['Shipping']['support_cod']."'";
		else 
			$condition=" Payment.status ='1' and PaymentI18n.status ='1' and Payment.is_cod = '0'";
		$this->Payment->set_locale($this->locale);
	//	$payment_list=$this->Payment->findAll($condition);
	   	$this->pageTitle = $this->languages['my_order']." - ".$this->configs['shop_title'];
		//pr($order_products);
		/* 是否显示配送 */
		$condition=" OrderProduct.order_id='".$order_info['Order']['id']."' and  ProductI18n.locale='".$this->locale."' and OrderProduct.extension_code='' ";
		if($this->OrderProduct->findAll($condition))
			$this->set('all_virtual',0);
		else $this->set('all_virtual',1);
		$this->set('order_info',$order_info);
		$this->set('order_products',$order_products);
	//	$this->set('payment_list',$payment_list);
		$this->set('virtual_card',$virtual_card);
		$this->set('download_product',$download_product);
		$this->set('service_product',$service_product);
	    //$this->set('ur_heres',$ur_heres);
	}
/****************  订单详细   *****************/
/************   取消订单    ***************/
function cancle_order($order_id){
	$order=array(
		'id'=> $order_id ,
		'status'=> 2,
		'payment_status' => 1,
		);
	$this->Order->save($order);
	 //显示的页面
	$this->redirect("/orders/");
}

/************   取消订单    ***************/
/************   修改支付方式  *************/
function change_payment($payment_id,$order_id){
	$payment_info=$this->Payment->find("Payment.id='".$payment_id."'");
    $order_info=array(
    	   'id'=>$order_id,
    	   'payment_id'=>$payment_id,
    	   'payment_name'=>$payment_info['PaymentI18n']['name']
    	);

		$pay_log = $this->PaymentApiLog->findbytype_id($order_id);
		$pay_log['PaymentApiLog']['payment_code'] = $payment_info['Payment']['code'];
		$this->PaymentApiLog->save($pay_log);
		$order = $this->Order->findbyid($order_id);
		$pay = $payment_info;
	    	if($payment_info['Payment']['code'] == "post"){  
				$order_info['payment_status'] 			= 1;											
			}else if($payment_info['Payment']['code'] == "bank"){ 
				$order_info['payment_status'] 			= 1;												
			}else{
				$order_info['payment_status'] 			= 0;												
			}
		$order_pr = $order['Order'];
		$order_pr['log_id'] = $pay_log['PaymentApiLog']['id'];
		$result['msg'] = $this->languages['pay'];
		$pay_php = $pay['Payment']['php_code'];	
		/* -start- */
			if($pay['Payment']['code'] == "alipay"){  //支付宝
				eval($pay_php);    // - -! 执行数据库取出的php代码
				$pay_class = new alipay();	
				$url = $pay_class->get_code($order_pr,$pay,$this);
				$this->set('pay_button',$url);
			}
			
			if($pay['Payment']['code'] == "chinapay"){  //银联电子支付
				eval($pay_php);
				$pay_class = new chinapay();	
				$form = $pay_class->get_code($order_pr,$pay);
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
			if($pay['Payment']['code'] == "paypal"){  //贝宝
				eval($pay_php);
				$pay_message = $pay['PaymentI18n']['description'];
				$pay_class = new paypal();	
				$form = $pay_class->get_code($order_pr,$pay,$this);
				$this->set('pay_form',$form);
			}	
			if($pay['Payment']['code'] == "paypalcn"){  //贝宝
				eval($pay_php);
				$pay_message = $pay['PaymentI18n']['description'];
				$pay_class = new paypal();	
				$form = $pay_class->get_code($order_pr,$pay,$this);
				$this->set('pay_form',$form);
			}		/* -end- */
    if($this->Order->save(array('Order'=>$order_info))){
	    $message=array(
	    'msg'=>$this->languages['mmodify'].$this->languages['payment'].$this->languages['successfully'],
	    'url'=>''
	    );
		}else{
	    $message=array(
	    'msg'=>$this->languages['mmodify'].$this->languages['payment'].$this->languages['failed'],
	    'url'=>''
		);
		}
	$this->set('result',$message);
   	$this->layout="ajax";
}
/************   修改支付方式  *************/


/* 支付*/
	function order_pay($oid = 0){
			if($oid != 0){
				$_POST['id'] = $oid;
			}
//		if($this->RequestHandler->isPost()){
			$order = $this->Order->findbyid($_POST['id']);
			$pay_log = $this->PaymentApiLog->findbytype_id($_POST['id']);
			$pay = $this->Payment->findbycode($pay_log['PaymentApiLog']['payment_code']);
			$order_pr = $order['Order'];
			$order_pr['log_id'] = $pay_log['PaymentApiLog']['id'];
			$result['msg'] = $this->languages['pay'];
			$pay_php = $pay['Payment']['php_code'];
			
	        if($order['Order']['coupon_id'] >0 ){
	        	$coupon = $this->Coupon->findbyid($order['Order']['coupon_id']);
	        	$this->CouponType->set_locale($this->locale);
	        	$coupon_type = $this->CouponType->findbyid($coupon['Coupon']['coupon_type_id']);
	        	$order['Order']['coupon_fee'] = $coupon_type['CouponType']['money'];
	        }else{
	        	$order['Order']['coupon_fee'] = 0;
	        }			
			
		//	$order['Order']['need_paid'] = number_format($order['Order']['total']-$order['Order']['money_paid']-$order['Order']['point_fee']-$order['Order']['coupon_fee']-$order['Order']['discount'],2 ,'.','')+0;
			$order_pr['total'] = $pay_log['PaymentApiLog']['amount'];
			$str = "\$pay_class = new ".$pay['Payment']['code']."();";
			if($pay['Payment']['code'] == "bank" || $pay['Payment']['code'] == "post" || $pay['Payment']['code'] == "COD" ||  $pay['Payment']['code'] == "account_pay"){
				$pay_message = $pay['PaymentI18n']['description'];
				$url_format = $pay_message;
				$this->set('pay_message',$pay_message);
			}else if($pay['Payment']['code'] == "alipay"){
				eval($pay_php);
				@eval($str);
				if(isset($pay_class)){
				$url = $pay_class->get_code($order_pr,$pay,$this);
				$url_format = "<input type=\"button\" onclick=\"window.open('".$url."')\" value=\"".$this->languages['alipay_pay_immedia']."\" />";
				$this->set('url_format',$url_format);
				$this->set('pay_button',$url);
				}
			}else{
				eval($pay_php);
				@eval($str);
				if(isset($pay_class)){
				$url = $pay_class->get_code($order_pr,$pay,$this);
				$url_format = $url;
				$this->set('pay_message',$url);
				}
			}		
	   		$result['msg'] = $this->languages['supply_method_is'].":".$pay['PaymentI18n']['name'];

			$result['type'] = 0;

	//	}
		   if($oid != 0){
		   	//	return $url;
		   }else{
			   if(!isset($_POST['is_ajax'])){
					$flash_url = $this->server_host.$this->user_webroot."orders";			   	   
					$this->page_init();
					$this->pageTitle = isset($result['msg'])?$result['msg']:'';
					if(isset($_POST['act']) && $_POST['act'] == 'index'){
					$this->flash($url_format,$flash_url,10);		
					}else if(isset($_POST['act']) && $_POST['act'] == 'view'){
					$this->flash($url_format,$flash_url."/".$_POST['id'],10);		
					}
				}		
				
				$this->set('result',$result);
		   		$this->layout="ajax";
		  }
	}
	
	function confirm_order(){
		$result['type'] = 1;
		$result['msg'] = "";
		if($this->RequestHandler->isPost()){
			$flash_url = $this->server_host.$this->user_webroot."orders";		
			$order_info = array(
								'id' => $_POST['id'],
								'shipping_status' => 2
							);
			$this->Order->save($order_info);
			$result['type'] = 0;
			$result['msg'] = $this->languages['thanks_for_purchase'];
   		}
		if(!isset($_POST['is_ajax'])){
		    $this->page_init();
			$this->pageTitle = "".$result['msg']."";
		    $this->flash($result['msg'],$flash_url,10);	
		}   		
   		$this->set('result',$result);
   		$this->layout="ajax";
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
	
}

?>