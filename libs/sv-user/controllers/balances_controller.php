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
 * $Id: balances_controller.php 1273 2009-05-08 16:49:08Z huangbo $
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
	   
	   $condition=" UserBalanceLog.user_id='".$user_id."' and log_type = 'B'";
	   $my_balance_list_B=$this->UserBalanceLog->findAll($condition);
	   $user_account = $this->UserAccount->findall('UserAccount.user_id ='.$user_id);
	   if(is_array($user_account) && sizeof($user_account)>0){
	   	   	$this->Payment->set_locale($this->locale);
	   		foreach($user_account as $k=>$v){
	   	   	   $api_log = $this->PaymentApiLog->find('PaymentApiLog.type_id = '.$v['UserAccount']['id'].' and PaymentApiLog.type = 1');
	   	   	   $pay = $this->Payment->findbyid($v['UserAccount']['payment']);
	   		   $user_account[$k]['UserAccount']['pay_name'] = $pay['PaymentI18n']['name'];
	   		   $user_account[$k]['UserAccount']['pay_id'] = $api_log['PaymentApiLog']['id'];
	   		}
	   }
	   $this->set('user_account',$user_account);
	   //pr($user_account);
	   //订单类型的日志关联订单信息
	   $orders_id=array();
	   
	   foreach($my_balance_list as $k=>$v){
	   	   if($v['UserBalanceLog']['log_type'] == 'O'){
	   	   	   $orders_id[$k]=$v['UserBalanceLog']['type_id'];
	   	   }
	   	   if($v['UserBalanceLog']['log_type'] == 'B'){
	   	   	   $api_log = $this->PaymentApiLog->find('PaymentApiLog.id = '.$v['UserBalanceLog']['type_id'].' and PaymentApiLog.type = 1');
	   	   	   $my_balance_list[$k]['UserBalanceLog']['is_paid'] = $api_log['PaymentApiLog']['is_paid'];
	   	   }
	   }
	   foreach($my_balance_list_B as $k=>$v){
	   	   if($v['UserBalanceLog']['log_type'] == 'B'){
	   	   	   $api_log = $this->PaymentApiLog->find('PaymentApiLog.id = '.$v['UserBalanceLog']['type_id'].' and PaymentApiLog.type = 1');
	   	   	   $this->Payment->set_locale($this->locale);
	   	   	   $pay = $this->Payment->findbycode($api_log['PaymentApiLog']['payment_code']);
	   	   	   $my_balance_list_B[$k]['UserBalanceLog']['is_paid'] = $api_log['PaymentApiLog']['is_paid'];
	   	   	   
	   	   }
	   }
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
	   $condition=" Payment.status =1 and PaymentI18n.status =1 and Payment.supply_use_flag = 1 and Payment.code <> 'COD'";
	   $payment_list=$this->Payment->findAll($condition);
	   	   
	   $this->pageTitle = $this->languages['my_balance']." - ".$this->configs['shop_title'];
	   $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist'] ,
	   						"recharge_amount_not_empty" => $this->languages['supply'].$this->languages['amount'].$this->languages['can_not_empty'],
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
		$pay_log['payment_code'] = $pay['Payment']['code'];
		$pay_log['type'] = 1;
		$pay_log['type_id'] = $account_id;
		$pay_log['amount'] = $amount_money;
		$pay_log['is_paid'] = 0;
		$this->PaymentApiLog->save($pay_log);
		$log_id = $this->PaymentApiLog->id;
		
		$order = array(
					"total" => $amount_money,
					'log_id' => $log_id
					);	
	    $message=array(
	    'msg'=>$this->languages['supply_method_is'].":".$pay['PaymentI18n']['name'],
	    'url'=>''
	    );
	 
	if($pay['Payment']['code'] == "alipay"){  //支付宝
		eval($pay_php);
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
	//UserBalanceLog
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
   	if($pay['Payment']['code'] == 'paypal'){
		eval($pay_php);
		$pay_message = $pay['PaymentI18n']['description'];
		$pay_class = new paypal();	
		$form = $pay_class->get_code($order,$pay,$this);
		$this->set('pay_form',$form);
	}
	}else{
	    $message=array(
	    'msg'=>$_REQUEST['msg'],
	    'url'=>''
		);
	}
	$this->set('result',$message);
   	$this->layout="ajax";
}

/* 支付*/
	function pay_balance(){
		if($this->RequestHandler->isPost()){
			$pay_log = $this->PaymentApiLog->findbyid($_POST['id']);
			$this->Payment->set_locale($this->locale);
			$pay = $this->Payment->findbycode($pay_log['PaymentApiLog']['payment_code']);
			$order_pr = array(
					"total" =>  $pay_log['PaymentApiLog']['amount'],
					'log_id' => $pay_log['PaymentApiLog']['id']
					);				
			
		//	$result['msg'] = $this->languages['supply'];
	   		$result['msg'] = $this->languages['supply_method_is'].":".$pay['PaymentI18n']['name'];
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






}
?>