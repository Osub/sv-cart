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
 * $Id: orders_controller.php 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
class OrdersController extends AppController {

	var $name = 'Orders';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array('Order','OrderProduct','Payment','Shipping','PaymentApiLog','UserPointLog','VirtualCard','UserBalanceLog','UserMessage','Coupon','CouponType','Region','OrderCard','OrderPackaging','Packaging','Card');

/************   我的订单首页    ***************/
	function index($order_status=0,$start_date='',$end_date='',$order_id=''){
		//未登录转登录页
		if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
				$this->redirect('/login/');
		}
		$this->page_init();
		
		//当前位置
		$this->navigations[] = array('name'=>__($this->languages['order_list'],true),'url'=>"");

		$this->set('locations',$this->navigations);
		
	   $user_id=$_SESSION['User']['User']['id'];

 	   $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	   //取得我的订单
	   $condition=" Order.user_id='".$user_id."' ";
	   if($order_status == 1){
	   	   $condition .=" and Order.status = 0 ";
	   }
	   elseif($order_status == 2){
	   	   $condition .=" and Order.payment_status = 0 ";
	   }
	   elseif($order_status == 3){
	   	   $condition .=" and Order.shipping_status = 0 ";
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
	   }
	   $condition=" Order.user_id='".$user_id."' and  Order.payment_status =0 ";
	   $no_paid=$this->Order->findCount($condition);
	   $condition=" Order.user_id='".$user_id."' and Order.status = 0 ";
	   $no_confirm=$this->Order->findCount($condition);

	   
	   $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist'],
	   "order_paid_not_cancel" => $this->languages['order_paid_not_cancel'] ,
	   "order_delivered_not_cancel" => $this->languages['order_delivered_not_cancel']);
	   $this->set('js_languages',$js_languages);
	   $this->pageTitle = $this->languages['order_list']." - ".$this->configs['shop_title'];
	   //pr($my_orders);
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
		//当前位置
		$this->navigations[] = array('name'=>__($this->languages['order_list'],true),'url'=>"/orders");
	    $user_id=$_SESSION['User']['User']['id'];
	    //Configure::write('debug', 2);
	    if(!is_numeric($id) || $id<1){
		$this->pageTitle = $this->languages['invalid_id']." - ".$this->configs['shop_title'];
		    $this->flash($this->languages['invalid_id'],"/user/orders",5);
	    }
	    //订单详细 /*****订单部分的处理********/
		$condition=" Order.id='".$id."' ";
		$order_info=$this->Order->find($condition);
		$this->navigations[] = array('name'=>$order_info['Order']['order_code'],'url'=>"");
				$this->set('locations',$this->navigations);

		if ($user_id > 0 && $user_id != $order_info['Order']['user_id'])
         {
			$this->pageTitle = $this->languages['not_your_order']." - ".$this->configs['shop_title'];
            $this->flash($this->languages['not_your_order'],"/user/orders",5);
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
        $point_log_filter = "1=1";
        $point_log_filter .= " and UserPointLog.type_id = ".$id." and UserPointLog.user_id = ".$user_id." and UserPointLog.log_type = 'O'";
        $point_log = $this->UserPointLog->find($point_log_filter);
        $this->set('point_log',$point_log);
        
        //是否使用余额
        if($payment_info['Payment']['code'] == "account_pay"){
        	$balance_log_filter = "1=1";
       	 	$balance_log_filter .= " and UserBalanceLog.type_id = ".$id." and UserBalanceLog.user_id = ".$user_id." and UserBalanceLog.log_type = 'O'";
        	$balance_log = $this->UserBalanceLog->find($balance_log_filter);
        	$this->set('balance_log',$balance_log);
        }
        //是否用优惠券
        if($order_info['Order']['coupon_id'] >0 ){
        	$coupon = $this->Coupon->findbyid($order_info['Order']['coupon_id']);
        	$this->CouponType->set_locale($this->locale);
        	$coupon_type = $this->CouponType->findbyid($coupon['Coupon']['coupon_type_id']);
        	$this->set('coupon_fee',$coupon_type['CouponType']['money']);
        	$this->set('coupon_discount',$coupon['Coupon']['order_amount_discount']);
        }
        //是否有包装
        $order_packaging = $this->OrderPackaging->findallbyorder_id($order_info['Order']['id']);
		if(is_array($order_packaging) && sizeof($order_packaging)>0){
			$this->Packaging->set_locale($this->locale);
			$packaging = array();
			foreach($order_packaging as $k=>$v){
				$packaging_info = $this->Packaging->findbyid($v['OrderPackaging']['packaging_id']);
				$packaging[$k] = $packaging_info;
				$packaging[$k]['Packaging']['fee'] = $v['OrderPackaging']['packaging_fee'];
				$packaging[$k]['Packaging']['note'] = $v['OrderPackaging']['note'];
				$packaging[$k]['Packaging']['quntity'] = $v['OrderPackaging']['packaging_quntity'];			
	        	$this->set('packaging',$packaging);
        	}
		}
        
        //是否有贺卡
        $order_card = $this->OrderCard->findallbyorder_id($order_info['Order']['id']);
		if(is_array($order_card) && sizeof($order_card)>0){
			$this->Card->set_locale($this->locale);
			$card = array();
			foreach($order_card as $k=>$v){
				$card_info = $this->Card->findbyid($v['OrderCard']['card_id']);
				$card[$k] = $card_info;
				$card[$k]['Card']['fee'] = $v['OrderCard']['card_fee'];
				$card[$k]['Card']['note'] = $v['OrderCard']['note'];
				$card[$k]['Card']['quntity'] = $v['OrderCard']['card_quntity'];			
	        	$this->set('card',$card);
        	}
		}  
		//pr($order_info);
		//订单商品详细  /*****订单商品部分的处理********/
		$condition=" OrderProduct.order_id='".$order_info['Order']['id']."' and  ProductI18n.locale='".$this->locale."' ";
		$order_products=$this->OrderProduct->findAll($condition);
	//	pr($order_products);
		static $market_subtotal=0;
		static $shop_subtotal=0;
		foreach($order_products as $k=>$v){
			$shop_subtotal += $v['OrderProduct']['product_price']*$v['OrderProduct']['product_quntity'];
			$market_subtotal+=$v['Product']['market_price']*$v['OrderProduct']['product_quntity'];
			$order_products[$k]['OrderProduct']['one_pro_subtotal']=$v['OrderProduct']['product_price']*$v['OrderProduct']['product_quntity'];
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
		
		$region_array = explode(" ",trim($order_info['Order']['regions']));
		$order_info['Order']['regions'] = "";
		$this->Region->set_locale($this->locale);
		foreach($region_array as $k=>$region_id){
			$region_info = $this->Region->findbyid($region_id);
			if($k < sizeof($region_array)-1){
				$order_info['Order']['regions'] .= $region_info['RegionI18n']['name']." ";
			}else{
				$order_info['Order']['regions'] .= $region_info['RegionI18n']['name'];
			}
		}		
		
		//支付方式列表
		//配送方式
		$this->Shipping->set_locale($this->locale);
		$shipping_info = $this->Shipping->findbyid($order_info['Order']['shipping_id']);
		
		
		$condition =" UserMessage.user_id='".$order_info['Order']['user_id']."' and UserMessage.parent_id = 0 and UserMessage.order_id = ".$id."";
	    $my_messages=$this->UserMessage->findAll($condition);
	   //pr($my_messages);
	   if(isset($my_messages) && is_array($my_messages) && sizeof($my_messages)>0){
		   foreach($my_messages as $k=>$v){
		   	   $replies=$this->UserMessage->findAll("UserMessage.parent_id = '".$v['UserMessage']['id']."'");
		   	   $my_messages[$k]['Reply']=$replies;
		   	   if($v['UserMessage']['msg_type'] == 0){
		   	   	      $my_messages[$k]['UserMessage']['type'] = $this->languages['message'];
		   	   }
		   	   else if($v['UserMessage']['msg_type'] == 1){
		   	   	      $my_messages[$k]['UserMessage']['type'] = $this->languages['complaint'];
		   	   }
		   	   else if($v['UserMessage']['msg_type'] == 2){
		   	   	      $my_messages[$k]['UserMessage']['type'] = $this->languages['inquiry'];
		   	   }
		   	   else if($v['UserMessage']['msg_type'] == 3){
		   	   	      $my_messages[$k]['UserMessage']['type'] = $this->languages['after_sale'];
		   	   }
		   	   else if($v['UserMessage']['msg_type'] == 4){
		   	   	     // $my_messages[$k]['UserMessage']['type'] = $this->languages['inquire'];
		   	   }
		   	  else {
		   	   	      //$my_messages[$k]['UserMessage']['type'] = $this->languages['untyped'];
		   	   }
		   }
		   $this->set('my_messages',$my_messages);
	   }

         /* 虚拟商品付款后处理 */
         $virtual_card = array();
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
							$vv['VirtualCard']['card_sn'] = $this->requestAction("/commons/decrypt/".$vv['VirtualCard']['card_sn']);;
							$vv['VirtualCard']['card_password'] = $this->requestAction("/commons/decrypt/".$vv['VirtualCard']['card_password']);
						}
						$vv['VirtualCard']['name'] = $v['ProductI18n']['name'];
						//$order_info['Order']['virtual_card'][] = $vv['VirtualCard'];
						$virtual_card[$vv['VirtualCard']['product_id']][] = $vv['VirtualCard'];
					}
					//pr($order_info['Order']['virtual_card']);
				}
				/* 下载处理 */
				else if($v['OrderProduct']['extension_code']=='download'){
				
				}
				/* 服务处理 */
				else if($v['OrderProduct']['extension_code']=='service'){
				
				}
			}
        }
//pr($virtual_card);
		
		
		/* 支持纯虚拟物品购买 */
		if(isset($shipping_info['Shipping']['support_cod']))
			$condition=" Payment.status =1 and PaymentI18n.status =1 and Payment.is_cod >= ".$shipping_info['Shipping']['support_cod']."";
		else 
			$condition=" Payment.status =1 and PaymentI18n.status =1 and Payment.is_cod = 0";
		$this->Payment->set_locale($this->locale);
		$payment_list=$this->Payment->findAll($condition);
	   	$this->pageTitle = $this->languages['my_order']." - ".$this->configs['shop_title'];
		//pr($order_products);
		/* 是否显示配送 */
		$condition=" OrderProduct.order_id='".$order_info['Order']['id']."' and  ProductI18n.locale='".$this->locale."' and OrderProduct.extension_code='' ";
		if($this->OrderProduct->findAll($condition))
			$this->set('all_virtual',0);
		else $this->set('all_virtual',1);
		$this->set('order_info',$order_info);
		$this->set('order_products',$order_products);
		$this->set('payment_list',$payment_list);
		$this->set('virtual_card',$virtual_card);
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
	function order_pay(){
		if($this->RequestHandler->isPost()){
			$order = $this->Order->findbyid($_POST['id']);
			$pay_log = $this->PaymentApiLog->findbytype_id($_POST['id']);
			$pay = $this->Payment->findbycode($pay_log['PaymentApiLog']['payment_code']);
			$order_pr = $order['Order'];
			$order_pr['log_id'] = $pay_log['PaymentApiLog']['id'];
			$result['msg'] = $this->languages['pay'];
			$pay_php = $pay['Payment']['php_code'];
			
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
			}		
			$result['type'] = 0;

		}
		$this->set('result',$result);
   		$this->layout="ajax";
	}
	
	function confirm_order(){
		$result['type'] = 1;
		$result['msg'] = "";
		if($this->RequestHandler->isPost()){
			$order_info = array(
								'id' => $_POST['id'],
								'shipping_status' => 2
						);
			$this->Order->save($order_info);
			$result['type'] = 0;
			$result['msg'] = "谢谢您的购买";
   		}
   		$this->set('result',$result);
   		$this->layout="ajax";
	}
	
	
}

?>