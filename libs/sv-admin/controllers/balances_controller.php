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
 * $Id: balances_controller.php 4691 2009-09-28 10:11:57Z huangbo $
*****************************************************************************/
class BalancesController extends AppController {

	var $name = 'Balances';
	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("SystemResource","Order","UserBalanceLog","PaymentApiLog","Payment","PaymentI18n","User","UserAccount");
	
	function index(){
		/*判断权限*/
		$this->operator_privilege('fund_log_view');
		/*end*/
		$this->pageTitle = "资金日志" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'客户管理','url'=>'');
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
	   	/* 开始时间 */
		if(isset($this->params['url']['start_time']) && $this->params['url']['start_time'] != ''){
	   	   $condition['and']['modified >='] = $this->params['url']['start_time'];
	   	   $this->set('start_time',$this->params['url']['start_time']);
	   	}
	   	else {
	   	   $condition['and']['modified >='] = date('Y-m-')."1";
	   	   $this->set('start_time',date('Y-m-')."1");
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
	   	/* 用户id */
		if(isset($this->params['url']['user_id']) && $this->params['url']['user_id'] != ''){
			$condition = array();
			$this->set('start_time','');
			$this->set('end_time','');
			
			$this->set('names',$this->User->field('name',array('User.id ='=>$this->params['url']['user_id'])));
			$condition['and']['user_id'] = $this->params['url']['user_id'];
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
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(false);
       	//
       	$this->set('balance_log_type',$systemresource_info["balance_log_type"]);//资源库信息

		foreach( $UserBalanceLog_list as $k=>$v ){
			/* 用户名 */
			$user_id = $UserBalanceLog_list[$k]['UserBalanceLog']['user_id'];
			$wh['id'] = $user_id;
			$User_list = $this->User->findAll($wh);
			$UserBalanceLog_list[$k]['UserBalanceLog']['name'] = "";
			foreach( $User_list as $ke=>$val ){
				$UserBalanceLog_list[$k]['UserBalanceLog']['name'] = $val['User']['name'];
			}
			
			$UserBalanceLog_list[$k]['UserBalanceLog']['log_type'] = $systemresource_info["balance_log_type"][$UserBalanceLog_list[$k]['UserBalanceLog']['log_type']];
			/* 类型名 */
			if($v['UserBalanceLog']['log_type'] == "O"){//消费 UserBalanceLog.type_id = Order.id
				$order_info = $this->Order->findById($v['UserBalanceLog']['type_id']);
				$UserBalanceLog_list[$k]['UserBalanceLog']['description'] = "订单号：".$order_info['Order']['order_code'];
			}	
			else if($v['UserBalanceLog']['log_type'] == "B"){//充值 UserBalanceLog.type_id = UserAccount.id
				$UserAccount = $this->UserAccount->findById($v['UserBalanceLog']['type_id']);
				$Payment = $this->Payment->findById($UserAccount['UserAccount']['payment']);
				$UserBalanceLog_list[$k]['UserBalanceLog']['description'] = "支付方式：".$Payment['PaymentI18n']['name'];
			}
			else if($v['UserBalanceLog']['log_type'] == "R"){//返还 UserBalanceLog.type_id = Order.id
				$order_info = $this->Order->findById($v['UserBalanceLog']['type_id']);
				$UserBalanceLog_list[$k]['UserBalanceLog']['description'] = "订单号：".$order_info['Order']['order_code'];
			}
			else if($v['UserBalanceLog']['log_type'] == "A"){//管理员操作 UserBalanceLog.type_id = Order.id
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
		/*判断权限*/
		$this->operator_privilege('voucher_undeal_view');
		/*end*/
		$this->pageTitle = "待处理充值" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'客户管理','url'=>'');
		$this->navigations[] = array('name'=>'待处理充值','url'=>'/balances/search/processing/');
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
		if(isset($_REQUEST['page'])&& !empty($_REQUEST['page'])){
			$this->set('ex_page',$this->params['url']['page']);
		}
		/*CSV导出*/
		if(isset($_REQUEST['export'])&&$_REQUEST['export']==="export")
		{
			$filename = '待处理冲值导出'.date('Ymd').'.csv';
			$ex_data = "待处理冲值统计报表,";
			$ex_data.= "日期,";
			$ex_data.= date('Y-m-d')."\n";
			$ex_data.= "会员名称,";
			$ex_data.= "操作日期,";
			$ex_data.= "金额,";
			$ex_data.= "支付方式,";
			$ex_data.= "备注\n";

			foreach( $UserAccount_list as $k=>$v ) {
				$ex_data.= $v['UserAccount']['name'].",";
				$ex_data.= $v['UserAccount']['created'].",";
				$ex_data.= $v['UserAccount']['amount'].",";
				$ex_data.= $v['UserAccount']['payment_name'].",";
				if( $v['UserAccount']['status']==1 ){ 
					$ex_data.= "已确认\n";
				}else{
					$ex_data.= "待处理\n";
				}			
			}
		 	Configure::write('debug',0);
			header("Content-type: text/csv; charset=gb2312");
			header ("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
			header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
			header('Expires:   0');
			header('Pragma:   public');
			echo iconv('utf-8','gb2312',$ex_data."\n");
			exit;		
		}
	}

	
	//确认
	function verify( $id ){
        $this->PaymentApiLog->updateAll(
			              array('is_paid' =>'1'),
			              array('id' =>"'".$id."'")
			           );
		$this->flash("确认成功",'/balances/',10);

	}

	function cancel( $id ){
        $this->PaymentApiLog->updateAll(
			              array('is_paid' =>'0'),
			              array('id' =>"'".$id."'")
			           );
		$this->flash("取消成功",'/balances/',10);
	}
	function search_verify($id){
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
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'会员:'.$user_info["User"]["name"].' 充值确认' ,'operation');
    	    }
			$this->flash("会员 ".$user_info["User"]["name"]." 充值确认成功。点击这里反回列表页",'/balances/search/processing',10);
		}
	}
	
	function search_cancel($id){
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
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'取消编号:'.$id.' 充值' ,'operation');
    	    }
			$this->flash("取消成功",'/balances/search/processing',10);
		}
	}
}

?>