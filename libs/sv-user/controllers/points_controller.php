<?php
/*****************************************************************************
 * SV-Cart 用户积分
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: points_controller.php 5209 2009-10-20 08:40:13Z huangbo $
*****************************************************************************/
uses('sanitize');		
class PointsController extends AppController {

	var $name = 'Points';
    var $components = array ('Pagination'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array("UserPointLog","Order","User","Product","ProductI18n","Payment","UserAccount","PaymentApiLog");


	function index(){
		//未登录转登录页
		if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
			 $this->redirect('/login/');
		}
		/*************************************/
		/*		vancl	所需 变量			*/
	//	$now = date('Y-m-d')." 23:59:59";
		$conditions = array(
						'Order.user_id' => $_SESSION['User']['User']['id'],
						'Order.shipping_status' => 2,
						'Order.user_id' => $_SESSION['User']['User']['id'],
						'Order.user_id' => $_SESSION['User']['User']['id']
						);
		$all_order = $this->Order->find('all',array('conditions'=>$conditions,'fields'=>'Order.total','recursive' => -1));
		$this->set('order_count',count($all_order));
		$all_order_fee = 0;
		if(is_array($all_order) && sizeof($all_order)>0){
			foreach($all_order as $k=>$v){
				$all_order_fee += $v['Order']['total'];
			}
		}
		$this->set('all_order_fee',$all_order_fee);
		/*************************************/
		$this->page_init();
		$mrClean = new Sanitize();			
		
	   $this->Payment->set_locale($this->locale);
	   $condition=" Payment.status = '1' and PaymentI18n.status = '1'  and Payment.code <> 'COD'";
	   $payment_list=$this->Payment->findAll($condition);
	   $this->set('payment_list',$payment_list);
	   $pays = $this->Payment->find('all',array('conditions'=>array('1=1')));
	   $pay_list = array();
	   foreach($pays as $k=>$v){
	   		$pay_list[$v['Payment']['id']] = $v;
	   }	   
	   
	   $user_account = $this->UserAccount->findall('UserAccount.user_id ='.$_SESSION['User']['User']['id']);
	   $account_ids = array();
	   $account_ids[] = 0;
	   foreach($user_account as $k=>$v){
	   		$account_ids[] = $v['UserAccount']['id'];
	   }		
	   $account_order = $this->PaymentApiLog->find('all',array('conditions'=>array('PaymentApiLog.type_id'=>$account_ids,'PaymentApiLog.type'=>2)));
	   $account_order_list = array();

	   if(is_array($account_order) && sizeof($account_order)>0){
	   		foreach($account_order as $k=>$v){
	   			$account_order_list[$v['PaymentApiLog']['type_id']] = $v;
	   		}
	   }

	   if(is_array($user_account) && sizeof($user_account)>0){
	   		foreach($user_account as $k=>$v){
	   			if(isset($account_order_list[$v['UserAccount']['id']]) && isset($pay_list[$v['UserAccount']['payment']])){
		   			$api_log = $account_order_list[$v['UserAccount']['id']];
		   			$pay = $pay_list[$v['UserAccount']['payment']];
		   	   	//   $api_log = $this->PaymentApiLog->find('PaymentApiLog.type_id = '.$v['UserAccount']['id'].' and PaymentApiLog.type = 1');
		   	   	//   $pay = $this->Payment->findbyid($v['UserAccount']['payment']);
		   		   $user_account[$k]['UserAccount']['pay_name'] = $pay['PaymentI18n']['name'];
		   		   $user_account[$k]['UserAccount']['pay_id'] = $api_log['PaymentApiLog']['id'];
	   			}else{
	   				unset($user_account[$k]);
	   			}
	   		}
	   }
	   $this->set('user_account',$user_account);
		
		//当前位置
		$this->navigations[] = array('name'=>__($this->languages['points'],true),'url'=>"");
		$this->set('locations',$this->navigations);
		//pr($this->params);
	    $user_id=$_SESSION['User']['User']['id'];
	   //pr($_SESSION['User']);
	   //我的积分使用情况
	   $condition=" user_id = '".$user_id."'";
	   if(isset($this->params['url']['date']) && $this->params['url']['date'] != ''){
	   	   $condition .=" and created  >= '".$this->params['url']['date']."'";
	   }
	   if(isset($this->params['url']['date2']) && $this->params['url']['date2'] != ''){
	   	   $condition .=" and created  <= '".$this->params['url']['date2']."'";
	   }
	   if(isset($this->params['url']['min_points']) && $this->params['url']['min_points'] != ''){
			$this->params['url']['min_points']= $this->params['url']['min_points'];
	   	   $condition .=" and point >= '".$this->params['url']['min_points']."'";
	   }
	   if(isset($this->params['url']['max_points']) && $this->params['url']['max_points'] != ''){
			$this->params['url']['max_points']= $this->params['url']['max_points'];
	   	   $condition .=" and point <= '".$this->params['url']['max_points']."'";
	   }
	   $user_point = $this->User->findbyid($_SESSION['User']['User']['id']);
	   $this->set('user_point',$user_point['User']['user_point']);
	   $total = $this->UserPointLog->findCount($condition,0);
	   $sortClass='UserPointLog';
	   $page=1;
	   $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	   $parameters=Array($rownum,$page);
	   $options=Array();
	   $page= $this->Pagination->init($condition,"",$options,$total,$rownum,$sortClass);
	   $my_points=$this->UserPointLog->findAll($condition,'',"UserPointLog.created DESC",'',$page);
	   $b_point = 0;
	   $r_point = 0;
	   $o_point = 0;
	   $c_point = 0;
	   $point_type_ids = array();
	   
	   foreach($my_points as $k=>$v){
	   		$point_type_ids[] = $v['UserPointLog']['type_id'];
	   }
	   
	   $order_infos = $this->Order->find('all',array(
	   'fields' =>	array('Order.id','Order.order_code','Order.total'),
	   'conditions'=>array('Order.id'=>$point_type_ids)));
	   
	   $order_lists = array();
	   if(is_array($order_infos) && sizeof($order_infos) >0){
	   	   foreach($order_infos as $k=>$v){
	   	   		$order_lists[$v['Order']['id']] = $v;
	   	   }
	   }
	   
	   foreach($my_points as $k=>$v){
	   	//   $condition=" id = '".$v['UserPointLog']['type_id']."'";
	   	//   $my_points[$k]['Order']=$this->Order->find($condition);
	   	
	   		if(isset($order_lists[$v['UserPointLog']['type_id']])){
	   		$my_points[$k]['Order'] = $order_lists[$v['UserPointLog']['type_id']];
	   		
	   		}
	   	
	   	   if($v['UserPointLog']['log_type'] == "B"){
	   	   		$b_point += $v['UserPointLog']['point'];
	   	   }
	   	   if($v['UserPointLog']['log_type'] == "R"){
	   	   		$r_point += $v['UserPointLog']['point'];
	   	   }	 
	   	   if($v['UserPointLog']['log_type'] == "O"){
	   	   		$o_point += $v['UserPointLog']['point'];
	   	   }	 
	   	   if($v['UserPointLog']['log_type'] == "C"){
	   	   		$c_point += $v['UserPointLog']['point'];
	   	   }		   	   
	   	   	   	     	   
	   }
	   $this->set('c_point',$c_point);
	   $this->set('b_point',$b_point);
	   $this->set('o_point',$o_point);
	   $this->set('r_point',$r_point);
	   
	   $user_info = $this->User->findbyid($user_id);
	   $my_point = $user_info['User']['point'];
	   $condition=" user_id='".$user_id."' and payment_status = '0' ";
	   $total_no_pay=$this->Order->findCount($condition,0);
	   $condition=" user_id='".$user_id."' and status = '0' ";
	   //筛选条件
	   $min_points=isset($this->params['url']['min_points'])?$this->params['url']['min_points']:'';
   	   $max_points=isset($this->params['url']['max_points'])?$this->params['url']['max_points']:'';
   	   $start_date=isset($this->params['url']['date'])?$this->params['url']['date']:'';
   	   $end_date=isset($this->params['url']['date2'])?$this->params['url']['date2']:''; 
   	   
	   $total_no_confirm=$this->Order->findCount($condition,0);
   	   
	   $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist'] ,
	   						"recharge_amount_not_empty" => $this->languages['supply'].$this->languages['amount'].$this->languages['can_not_empty'],
	   						"no_choose_payment_method" => $this->languages['please_choose'].$this->languages['payment']);
	   $this->set('js_languages',$js_languages);	   
	   	$this->pageTitle = $this->languages['points']." - ".$this->configs['shop_title'];
	   $this->set('my_points',$my_points);
	   $this->set('total',$total);
	   $this->set('total_no_confirm',$total_no_confirm);
	   $this->set('total_no_pay',$total_no_pay);
	   $this->set('my_point',$my_point);
   	   $this->set('min_points',$min_points);
   	   $this->set('max_points',$max_points);
   	   $this->set('start_date',$start_date);
   	   $this->set('end_date',$end_date);	 
	}
	
	function exchange(){
		
		if(!isset($_SESSION['User']['User'])){
			$this->redirect('/login/');
		}
		$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
		
		if($user_info['User']['point'] > 0){
			$orderby = "point_fee ASC";
		}else{
			$orderby = "market_price DESC";
		}
		
		$sortClass='Product';
		$rownum = 10;
		$page=1;
		$parameters=Array($orderby,$rownum,$page);
		$options=Array();
		
		$condition = "Product.point_fee > '0' and Product.status = '1' and Product.forsale = '1' and Product.quantity > '0'";
			$products=$this->Product->find('all',array(
															'recursive' => -1,
																'fields' =>	array('Product.id','Product.recommand_flag','Product.status','Product.img_thumb'
																				,'Product.market_price'
																				,'Product.shop_price'
																				,'Product.code','Product.point','Product.point_fee'
																				,'Product.product_rank_id'
																				,'Product.quantity'
																				),			
			'conditions'=>array($condition),'order'=>array("Product.$orderby"),'limit'=>$rownum,'page'=>$page));		
		
			$products_ids_list = array();
			  if(is_array($products) && sizeof($products)>0){
			  		foreach($products as $k=>$v){
			  			$products_ids_list[] = $v['Product']['id'];
			  		}
			  }	
			  
		// 商品多语言
			$productI18ns_list =array();
				$productI18ns = $this->ProductI18n->find('all',array( 
				'fields' =>	array('ProductI18n.id','ProductI18n.name','ProductI18n.product_id'),
				'conditions'=>array('ProductI18n.product_id'=>$products_ids_list,'ProductI18n.locale'=>$this->locale)));
			if(isset($productI18ns) && sizeof($productI18ns)>0){
				foreach($productI18ns as $k=>$v){
					$productI18ns_list[$v['ProductI18n']['product_id']] = $v;
				}
			}
			
			$total = count($products);
			$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass); // Added 
		
			foreach($products as $k=>$v){
				if(isset($productI18ns_list[$v['Product']['id']])){
					$products[$k]['ProductI18n'] = $productI18ns_list[$v['Product']['id']]['ProductI18n'];
				}else{
					$products[$k]['ProductI18n']['name'] = "";
				}	
				
				if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
					$products[$k]['ProductI18n']['name'] = $this->Product->sub_str($products[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
				}				
			}
	}
	
	
	
		function payment_point(){
				$no_error = 1;
			   if(!isset($_POST['is_ajax'])){
			   	   if($_POST['amount_num'] == ""){
			   	   		$no_error = 0;//larger_zero
			   	   		$_REQUEST['msg'] = $this->languages['supply'].$this->languages['amount'].$this->languages['can_not_empty'];
			   	   }elseif($_POST['amount_num'] == 0){
			   	   		$no_error = 0;//larger_zero
			   	   		$_REQUEST['msg'] = $this->languages['supply'].$this->languages['amount'].$this->languages['larger_zero'];
			   	   }else if(!isset($_POST['payment_id']) || $_POST['payment_id'] == "" || $_POST['payment_id'] < 1){
			   	   		$no_error = 0;
			   	   		$_REQUEST['msg'] = $this->languages['please_choose'].$this->languages['payment'];
			   	   }else{
			   	   		$_REQUEST['money'] = $_POST['amount_num'];
			   	   }
			   	   $url_format = isset($_REQUEST['msg'])?$_REQUEST['msg']:'';
				}
			if(!(isset($_REQUEST['msg']))){
			$modified=date('Y-m-d H:i:s');
			$user_id=$_SESSION['User']['User']['id'];
			$user_info=$this->User->find("User.id='".$user_id."'");
			$user_money=$user_info['User']['balance']+$_REQUEST['money'];
			$amount_money=$_REQUEST['money'];
			$payment_id = $_POST['payment_id'];
			$this->Payment->set_locale($this->locale);
			$pay = $this->Payment->findbyid($payment_id);
			$pay_php = $pay['Payment']['php_code'];
			$account_info = array(
									"id"=>"",
									"user_id"=>$user_id,
									"amount"=>$amount_money,
									"payment"=>$payment_id,
									"status"=> 0
									);
				$this->UserAccount->save($account_info);
				$account_id = $this->UserAccount->id;

				$pay_log = array();
				$pay_log['id'] = '';
				$pay_log['payment_code'] = $pay['Payment']['code'];
				$pay_log['type'] = 2;
				$pay_log['type_id'] = $account_id;
				$pay_log['amount'] = $amount_money;
				$pay_log['is_paid'] = 0;
				$this->PaymentApiLog->save($pay_log);
				$log_id = $this->PaymentApiLog->id;
				$pay_created = $this->PaymentApiLog->findbyid($log_id);
				$order = array(
							'total' => $amount_money,
							'log_id' => $log_id,
							'created' => $pay_created['PaymentApiLog']['created']
							);	
			    $message=array(
			    	'msg'=>$this->languages['supply_method_is'].":".$pay['PaymentI18n']['name'],
			    	'url'=>''
			    );			
			    $_REQUEST['msg'] = $this->languages['supply_method_is'].":".$pay['PaymentI18n']['name'];
					$str = "\$pay_class = new ".$pay['Payment']['code']."();";
					if($pay['Payment']['code'] == "bank" || $pay['Payment']['code'] == "post" || $pay['Payment']['code'] == "COD" ||  $pay['Payment']['code'] == "account_pay"){
						$pay_message = $pay['PaymentI18n']['description'];
						$url_format = $pay_message;
						$this->set('pay_message',$pay_message);
					}else if($pay['Payment']['code'] == "alipay"){
						eval($pay_php);
						eval($str);
						$url = $pay_class->get_code($order,$pay,$this);
						$url_format = "<input type=\"button\" onclick=\"window.open('".$url."')\" value=\"".$this->languages['alipay_pay_immedia']."\" />";
						$this->set('pay_button',$url);
					}else{
						eval($pay_php);
						eval($str);
						$url = $pay_class->get_code($order,$pay,$this);
						$url_format = $url;
						$this->set('pay_message',$url);
					}
			}else{
			    $message=array(
			    'msg'=>$_REQUEST['msg'],
			    'url'=>''
				);
			}
			if(!isset($_POST['is_ajax'])){
				$this->page_init();
				$this->pageTitle = $_REQUEST['msg'];
				$flash_url = $this->server_host.$this->user_webroot."balances";		
				$this->flash($url_format,$flash_url,10);	
			}
			$this->set('result',$message);
		   	$this->layout="ajax";
	 }
	
	function pay_point(){
		$no_error = 1;
		if($this->RequestHandler->isPost()){
			$pay_log = $this->PaymentApiLog->findbyid($_POST['id']);
			$this->Payment->set_locale($this->locale);
			$pay = $this->Payment->findbycode($pay_log['PaymentApiLog']['payment_code']);
			$order_pr = array(
					"total" =>   $pay_log['PaymentApiLog']['amount'],
					'log_id' =>  $pay_log['PaymentApiLog']['id'],
					'created' => $pay_log['PaymentApiLog']['created']
					);				
			
		//	$result['msg'] = $this->languages['supply'];
	   		$result['msg'] = $this->languages['supply_method_is'].":".$pay['PaymentI18n']['name'];
			$pay_php = $pay['Payment']['php_code'];
			$str = "\$pay_class = new ".$pay['Payment']['code']."();";
			if($pay['Payment']['code'] == "bank" || $pay['Payment']['code'] == "post" || $pay['Payment']['code'] == "COD" ||  $pay['Payment']['code'] == "account_pay"){
				$pay_message = $pay['PaymentI18n']['description'];
				$url_format = $pay_message;
				$this->set('pay_message',$pay_message);
			}else if($pay['Payment']['code'] == "alipay"){
				eval($pay_php);
				eval($str);
				$url = $pay_class->get_code($order_pr,$pay,$this);
				$url_format = "<input type=\"button\" onclick=\"window.open('".$url."')\" value=\"".$this->languages['alipay_pay_immedia']."\" />";
				$this->set('pay_button',$url);
			}else{
				eval($pay_php);
				eval($str);
				$url = $pay_class->get_code($order_pr,$pay,$this);
				$url_format = $url;
				$this->set('pay_message',$url);
			}		
			$result['type'] = 0;

		}
	   if(!isset($_POST['is_ajax'])){
			$this->page_init();
			$this->pageTitle = $result['msg'];
			$flash_url = $this->server_host.$this->user_webroot."balances";					
			$this->flash($url_format,$flash_url,10);		
		}
		
		$this->set('result',$result);
   		$this->layout="ajax";
	}
	
	
	
	
	

}

?>