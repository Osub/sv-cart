<?php
/*****************************************************************************
 * SV-Cart 用户资金日志
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: user_balance_log.php 723 2009-04-17 07:59:05Z shenyunfeng $
*****************************************************************************/
class UserBalanceLog extends AppModel
{
	var $name = 'UserBalanceLog';

	function add_log($user_id,$amount,$admin_user,$admin_note,$system_note,$log_type,$type_id){
 	 $created=date('Y-m-d H:i:s');
 	 $log_info=array(
 	 	     'user_id'=>$user_id,
 	 	     'amount'=>$amount,
 	 	     'log_type'=>$log_type,
 	 	     'admin_user'=>$admin_user,
 	 	     'admin_note'=>$admin_note,
 	 	     'system_note'=>$system_note,
 	 	     'type_id'=>$type_id,
 	 	     'created'=>$created
 	 	 );
 	 if($this->save(array('UserBalanceLog'=>$log_info))){
 	 	 return true;
 	 }
 	 else{
 	 	 return false;
 	 }
 }

}
?>