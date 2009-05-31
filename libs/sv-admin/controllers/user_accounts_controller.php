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
 * $Id: balances_controller.php 1246 2009-05-07 11:29:14Z shenyunfeng $
*****************************************************************************/
class UserAccountsController extends AppController {

	var $name = 'UserAccounts';
	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("Order","UserBalanceLog","PaymentApiLog","Payment","PaymentI18n","User","UserAccount");
	
	
	function index(){
		/*判断权限*/
		$this->operator_privilege('user_accounts_view');
		/*end*/
		$this->pageTitle = "充值管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'充值管理','url'=>'/user_accounts/');
		$this->set('navigations',$this->navigations);
		$this->Payment->set_locale($this->locale);
		$condition ='';
		/* 支付方式 */
		if(isset($this->params['url']['payment']) && $this->params['url']['payment'] != ''){
	   	   	$condition['and']['payment ='] = $this->params['url']['payment'];
			$this->set('payment',$this->params['url']['payment']);
	   	}
		/* 状态 */
		if(isset($this->params['url']['account_status']) && $this->params['url']['account_status'] != ''){
			$condition['and']['status'] = $this->params['url']['account_status'];
			$this->set('status',$this->params['url']['account_status']);
	   	}
	   	else if(!isset($this->params['url']['account_status'])){
			$condition['and']['status'] = 0;
			$this->set('status',0);
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

   	    $total = $this->UserAccount->findCount($condition,0);
	    $sortClass='UserAccount';
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters=Array($rownum,$page);
	    $options=Array();
	    $page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		/* 列表 */
		$UserAccount_list = $this->UserAccount->findAll($condition,'',"",$rownum,$page);
		
		foreach( $UserAccount_list as $k=>$v ) {
			$user_id = $UserAccount_list[$k]['UserAccount']['user_id'];
			$User = $this->User->findById($user_id);
			$UserAccount_list[$k]['UserAccount']['name'] = $User['User']['name'];

			$payment_id = $UserAccount_list[$k]['UserAccount']['payment'];
			$payment = $this->Payment->findById($payment_id);
			$UserAccount_list[$k]['UserAccount']['payment_name'] = $payment['PaymentI18n']['name'];
			//pr($payment);
		}
		
		$payments = $this->Payment->findAll();
		//pr($payments);
		$this->set('payments',$payments);
		$this->set('UserAccount_list',$UserAccount_list);
	}
	
	function verify($id){
		$account = $this->UserAccount->findById($id);
		if(empty($account)){
			$this->flash("操作失败，无效的id!",'/balances/search/processing',10,false);
		}
		else if($account['UserAccount']['status'] != 0){
			$this->flash("操作失败，请不要重复操作!",'/balances/search/processing',10,false);
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
			$user_info = $this->User->findById($account['UserAccount']['user_id']);
			$this->flash("会员 ".$user_info["User"]["name"]." 充值确认成功。点击反回列表页",'/user_accounts/',10);
		}
	}
	
	function cancel($id){
		$account = $this->UserAccount->findById($id);
		if(empty($account)){
			$this->flash("操作失败，无效的id!",'/balances/search/processing',10,false);
		}
		else if($account['UserAccount']['status'] != 0){
			$this->flash("操作失败，请不要重复操作!",'/balances/search/processing',10,false);
		}
		else{
			$this->UserAccount->updateAll(
				              array('status' =>'2'),
				              array('id' =>$id)
				           );
			$this->flash("取消成功",'/user_accounts/',10);
		}
	}
}

?>