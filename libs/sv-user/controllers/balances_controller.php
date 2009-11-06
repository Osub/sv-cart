<?php
/*****************************************************************************
 * SV-Cart 用户资金
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: balances_controller.php 3428 2009-07-31 11:48:18Z huangbo $
*****************************************************************************/
class BalancesController extends AppController {

	var $name = 'Balances';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array("Order","User","Payment","UserBalanceLog","UserAccount",'PaymentApiLog');


	function index(){
		//未登录转登录页
		if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
				$this->redirect('/login/');
		}
		$this->page_init();
	    $user_id=$_SESSION['User']['User']['id'];
		$user_account = $this->UserAccount->findall('UserAccount.user_id = '.$user_id);
		$this->set('user_account',$user_account);
		        			
		//当前位置
		$this->navigations[] = array('name'=>__($this->languages['my_balance'],true),'url'=>"");
		$this->set('locations',$this->navigations);
		
		//pr($this->configs);
	   //pr($_SESSION['User']['User']);
	   //取得我的资金使用
	   $condition=" UserBalanceLog.user_id='".$user_id."'";
	   $total = $this->UserBalanceLog->findCount($condition,0);
	   $sortClass='UserBalanceLog';
	   $page=1;
	   $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	   $parameters=Array($rownum,$page);
	   $options=Array();
	   $page = $this->Pagination->init($condition,"",$options,$total,$rownum,$sortClass);
	   $my_balance_list=$this->UserBalanceLog->findAll($condition,'','',"$rownum",$page);
	   
	   $orders_id=array();
	   $orders_id[] = 0;
	   foreach($my_balance_list as $k=>$v){
	   		$orders_id[] = $v['UserBalanceLog']['type_id'];
	   }
	   
	   $api_log_order = $this->PaymentApiLog->find('all',array('conditions'=>array('PaymentApiLog.type_id'=>$orders_id,'PaymentApiLog.type'=>0)));
	   $api_log_order_list = array();
	   if(is_array($api_log_order) && sizeof($api_log_order)>0){
	   		foreach($api_log_order as $k=>$v){
	   			$api_log_order_list[$v['PaymentApiLog']['id']] = $v;
	   		}
	   }	   
 	   $this->Payment->set_locale($this->locale);
	   $pays = $this->Payment->find('all',array('conditions'=>array('1=1')));
	   $pay_list = array();
	   foreach($pays as $k=>$v){
	   		$pay_list[$v['Payment']['id']] = $v;
	   }
	   
//	   $condition=" UserBalanceLog.user_id='".$user_id."' and log_type = 'B'";
//	   $my_balance_list_B=$this->UserBalanceLog->findAll($condition);
	   $user_account = $this->UserAccount->findall('UserAccount.user_id ='.$user_id);
	   $account_ids = array();
	   $account_ids[] = 0;
	   foreach($user_account as $k=>$v){
	   		$account_ids[] = $v['UserAccount']['id'];
	   }
	   $account_order = $this->PaymentApiLog->find('all',array('conditions'=>array('PaymentApiLog.type_id'=>$account_ids,'PaymentApiLog.type'=>1)));
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
	   			}
	   		}
	   }
	   $this->set('user_account',$user_account);
	   //pr($user_account);
	   //订单类型的日志关联订单信息

	   
	   
	   foreach($my_balance_list as $k=>$v){
	   	   if($v['UserBalanceLog']['log_type'] == 'O'){
	   	   	   $orders_id[$k]=$v['UserBalanceLog']['type_id'];
	   	   }
	   	   if($v['UserBalanceLog']['log_type'] == 'B'){
	   	   	   //$api_log = $this->PaymentApiLog->find('PaymentApiLog.id = '.$v['UserBalanceLog']['type_id'].' and PaymentApiLog.type = 1');
	   	   	   //$my_balance_list[$k]['UserBalanceLog']['is_paid'] = $api_log['PaymentApiLog']['is_paid'];
	   	   		if(isset($api_log_order_list[$v['UserBalanceLog']['type_id']])){
	   	   			$my_balance_list[$k]['UserBalanceLog']['is_paid'] = $api_log_order_list[$v['UserBalanceLog']['type_id']]['PaymentApiLog']['is_paid'];
	   	   		}
	   	   
	   	   }
	   }
	/*   
	   foreach($my_balance_list_B as $k=>$v){
	   	   if($v['UserBalanceLog']['log_type'] == 'B'){
	   	   	   $api_log = $this->PaymentApiLog->find('PaymentApiLog.id = '.$v['UserBalanceLog']['type_id'].' and PaymentApiLog.type = 1');
	   	   	   $this->Payment->set_locale($this->locale);
	   	   	   $pay = $this->Payment->findbycode($api_log['PaymentApiLog']['payment_code']);
	   	   	   $my_balance_list_B[$k]['UserBalanceLog']['is_paid'] = $api_log['PaymentApiLog']['is_paid'];
	   	   	   
	   	   }
	   }*/
	   $now_time = date("Y-m-d H:i:s");
	   $spot  = time() - (24 * 60 * 60);
 	   $yesterday = date("Y-m-d H:i:s", $spot);
	   $filt = "1=1";
	   $filt .= " and user_id = '".$user_id."' and log_type = 'O' and  created <= '".$now_time."' and  created >= '".$yesterday."'";
	  // pr($filt);
	   $today_balance_list=$this->UserBalanceLog->findAll($filt);
	   $all_fee = 0;
	   if(isset($today_balance_list)){
		   foreach($today_balance_list as $k=>$v){
		      $all_fee += $v['UserBalanceLog']['amount'];
		   }
	   }
		if(empty($orders_id)){
			$orders_id[] = 0;
		}
	
	   $orders_info=$this->Order->findassoc($orders_id);
	   foreach($my_balance_list as $k=>$v){
	   	       $my_balance_list[$k]['Order']=array();
	   	   if($v['UserBalanceLog']['log_type'] == 'O' && is_array($orders_info[$v['UserBalanceLog']['type_id']])){
	   	   	   $my_balance_list[$k]['Order']=$orders_info[$v['UserBalanceLog']['type_id']]['Order'];
	   	   }
	   }
       //pr($my_balance_list);
	   $user_info=$this->User->find("User.id= '".$_SESSION['User']['User']['id']."'");
	   //今天消费金额
	   $today=date('Y-m-d H:i:s');
	   //$today_consumer=$this->UserBalanceLog->query("SELECT SUM(amount) FROM  svcart_user_balance_logs where created like %$today% ;");
	   //pr($today_consumer[0][0]);
	   //支付方式列表
	   $this->Payment->set_locale($this->locale);
	   $condition=" Payment.status = '1' and PaymentI18n.status = '1' and Payment.supply_use_flag = '1' and Payment.code <> 'COD'";
	   $payment_list=$this->Payment->findAll($condition);
	   	   
	   $this->pageTitle = $this->languages['my_balance']." - ".$this->configs['shop_title'];
	   $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist'] ,
	   						"recharge_amount_not_empty" => $this->languages['supply'].$this->languages['amount'].$this->languages['can_not_empty'],
	   						"recharge_amount_larger_zero" => $this->languages['supply'].$this->languages['amount'].$this->languages['larger_zero'],
	   						"no_choose_payment_method" => $this->languages['please_choose'].$this->languages['payment']);
	   $this->set('js_languages',$js_languages);
	   //$this->set('today_consumer',$today_consumer);
	   $this->set('total',$total);
	   $this->set('all_fee',$all_fee);
	   $this->set('my_balance_list',$my_balance_list);
	   $this->set('my_balance',$user_info['User']['balance']);
	   $this->set('payment_list',$payment_list);
	   
	}
	
function balance_deposit(){
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
		$pay_log['type'] = 1;
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

/* 支付*/
	function pay_balance(){
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