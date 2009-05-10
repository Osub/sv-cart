<?php
/*****************************************************************************
 * SV-Cart 用户资金报表
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: balances_controller.php 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
class BalancesController extends AppController {

	var $name = 'Balances';
	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("Order","UserBalanceLog","PaymentApiLog","Payment","PaymentI18n","User","UserAccount");
	
	function index(){
		$this->pageTitle = "资金日志" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'资金日志','url'=>'/balances/');
		$this->set('navigations',$this->navigations);
		$condition ='';
		/* 类型 */
		if(isset($this->params['url']['log_type']) && $this->params['url']['log_type'] != ''){
	   	   	$condition['and']['log_type ='] = $this->params['url']['log_type'];
			$this->set('log_type',$this->params['url']['log_type']);
	   	}
	   	/* 用户名 */
		if(isset($this->params['url']['name']) && $this->params['url']['name'] != ''){
	   	   	$wh['name like'] = "%".$this->params['url']['name']."%";
			$user = $this->User->findAll($wh);
			foreach( $user as $k=>$v ){
				$condition['or'][]['user_id'] = $user[$k]['User']['id'];
			}
			$this->set('names',$this->params['url']['name']);
	   	}
	   	/* 用户id */
		if(isset($this->params['url']['user_id']) && $this->params['url']['user_id'] != ''){
			$condition['and']['user_id'] = $this->params['url']['user_id'];
	   	}
	   	/* 开始时间 */
		if(isset($this->params['url']['start_time']) && $this->params['url']['start_time'] != ''){
	   	   $condition['and']['modified >='] = $this->params['url']['start_time'];
	   	   $this->set('start_time',$this->params['url']['start_time']);
	   	}
	   	else {
	   	   $condition['and']['modified >='] = date('Y-m-d');
	   	   $this->set('start_time',date('Y-m-d'));
	   	}
	   	/* 结束时间 */
	   	if(isset($this->params['url']['end_time']) && $this->params['url']['end_time'] != ''){
	   	   $condition['and']['modified <='] = $this->params['url']['end_time']." 23:59:59";
	   	   $this->set('end_time',$this->params['url']['end_time']);
	   	}
	   	else {
	   	   $condition['and']['modified <='] = date('Y-m-d')." 23:59:59";
	   	   $this->set('end_time',date('Y-m-d'));
	   	}
		/* 分页 */
   	    $total = $this->UserBalanceLog->findCount($condition,0);
	    $sortClass='UserBalanceLog';
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters=Array($rownum,$page);
	    $options=Array();
	    $page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
	    /* 列表 */
   		$UserBalanceLog_list=$this->UserBalanceLog->findAll($condition,'',"UserBalanceLog.modified desc",$rownum,$page);
   		$PaymentApiLog_list=$this->PaymentApiLog->find('all');
   		$this->Payment->set_locale($this->locale);

		foreach( $UserBalanceLog_list as $k=>$v ){
			/* 用户名 */
			$user_id = $UserBalanceLog_list[$k]['UserBalanceLog']['user_id'];
			$wh['id'] = $user_id;
			$User_list = $this->User->findAll($wh);
			$UserBalanceLog_list[$k]['UserBalanceLog']['name'] = "";
			foreach( $User_list as $ke=>$val ){
				$UserBalanceLog_list[$k]['UserBalanceLog']['name'] = $val['User']['name'];
			}
			
			
			/* 类型名 */
			if($v['UserBalanceLog']['log_type'] == "O"){//消费 UserBalanceLog.type_id = Order.id
				$UserBalanceLog_list[$k]['UserBalanceLog']['log_type'] = "消费";
				$order_info = $this->Order->findById($v['UserBalanceLog']['type_id']);
				$UserBalanceLog_list[$k]['UserBalanceLog']['description'] = "订单号：".$order_info['Order']['order_code'];
			}	
			else if($v['UserBalanceLog']['log_type'] == "B"){//充值 UserBalanceLog.type_id = UserAccount.id
				//pr($v);
				$UserBalanceLog_list[$k]['UserBalanceLog']['log_type'] = "充值";
				$UserAccount = $this->UserAccount->findById($v['UserBalanceLog']['type_id']);
				$Payment = $this->Payment->findById($UserAccount['UserAccount']['payment']);
				$UserBalanceLog_list[$k]['UserBalanceLog']['description'] = "支付方式：".$Payment['PaymentI18n']['name'];
			}
			else if($v['UserBalanceLog']['log_type'] == "C"){//返还 UserBalanceLog.type_id = Order.id
				$UserBalanceLog_list[$k]['UserBalanceLog']['log_type'] = "返还";
				$order_info = $this->Order->findById($v['UserBalanceLog']['type_id']);
				$UserBalanceLog_list[$k]['UserBalanceLog']['description'] = "订单号：".$order_info['Order']['order_code'];
			}
			else if($v['UserBalanceLog']['log_type'] == "A"){//管理员操作 UserBalanceLog.type_id = Order.id
				$UserBalanceLog_list[$k]['UserBalanceLog']['log_type'] = "管理员操作";
				$order_info = $this->Order->findById($v['UserBalanceLog']['type_id']);
				$UserBalanceLog_list[$k]['UserBalanceLog']['description'] = $v['UserBalanceLog']['system_note'];
			}
			else {
				$UserBalanceLog_list[$k]['UserBalanceLog']['log_type'] = "其他";
				$UserBalanceLog_list[$k]['UserBalanceLog']['description'] = "未知";
			}
		}
   		$this->set('UserBalanceLog_list',$UserBalanceLog_list);
	}
	
	function search(){
		$this->pageTitle = "待处理冲值" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'待处理冲值','url'=>'/balances/');
		$this->set('navigations',$this->navigations);
		
		$condition['status']='0';
   	    $total = $this->UserAccount->findCount($condition,0);
	    $sortClass='UserAccount';
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters=Array($rownum,$page);
	    $options=Array();
	    $page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		
		$UserAccount_list = $this->UserAccount->findAll($condition,'',"",$rownum,$page);
		
		foreach( $UserAccount_list as $k=>$v ) {
			$user_id = $UserAccount_list[$k]['UserAccount']['user_id'];
			$User = $this->User->findById($user_id);	
			$UserAccount_list[$k]['UserAccount']['name'] = $User['User']['name'];
			
			$payment_id = $UserAccount_list[$k]['UserAccount']['payment'];
			$payment = $this->Payment->findById($payment_id);
			$UserAccount_list[$k]['UserAccount']['payment_name'] = $payment['PaymentI18n']['name'];
		}
		$this->set('UserAccount_list',$UserAccount_list);

	}
	
	//确认
	function verify( $id ){
        $this->PaymentApiLog->updateAll(
			              array('is_paid' =>1),
			              array('id' =>$id)
			           );
		$this->flash("确认成功",'/balances/',10);

	}

	function cancel( $id ){
        $this->PaymentApiLog->updateAll(
			              array('is_paid' =>0),
			              array('id' =>$id)
			           );
		$this->flash("取消成功",'/balances/',10);
	}
	function search_verify($id){
		$account = $this->UserAccount->findById($id);
		if(empty($account)){
			$this->flash("操作失败，无效的id!",'/balances/search/processing',10);
		}
		else if($account['UserAccount']['status'] != 0){
			$this->flash("操作失败，请不要重复操作!",'/balances/search/processing',10);
		}
		else{
			$this->User->updateAll(
				              array('User.balance' => 'User.balance + '.$account['UserAccount']['amount']),
				              array('id' =>$account['UserAccount']['user_id'])
				           );
			$this->UserAccount->updateAll(
				              array('status' =>'1'),
				              array('id' =>$id)
				           );
   	    	$BalanceLog['UserBalanceLog']['user_id'] = $account['UserAccount']['user_id'];
   	    	$BalanceLog['UserBalanceLog']['amount'] = $account['UserAccount']['amount'];
   	    	$BalanceLog['UserBalanceLog']['admin_user'] = $_SESSION['Operator_Info']['Operator']['name'];
   	    	$BalanceLog['UserBalanceLog']['admin_note'] = "";
   	    	$BalanceLog['UserBalanceLog']['system_note'] = "管理员确认";
   	    	$BalanceLog['UserBalanceLog']['log_type'] = "B";
   	    	$BalanceLog['UserBalanceLog']['type_id'] = $id;
   	    	
   	    	$this->UserBalanceLog->save($BalanceLog);
			$this->flash("确认成功",'/balances/search/processing',10);
		}
	}
	
	function search_cancel($id){
		$account = $this->UserAccount->findById($id);
		if(empty($account)){
			$this->flash("操作失败，无效的id!",'/balances/search/processing',10);
		}
		else if($account['UserAccount']['status'] != 0){
			$this->flash("操作失败，请不要重复操作!",'/balances/search/processing',10);
		}
		else{
			$this->UserAccount->updateAll(
				              array('status' =>'2'),
				              array('id' =>$id)
				           );
			$this->flash("取消成功",'/balances/search/processing/',10);
		}
	
	}
}

?>