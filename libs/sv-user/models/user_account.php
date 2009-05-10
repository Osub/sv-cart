<?php
/*****************************************************************************
 * SV-Cart 用户账单
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: user_account.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class UserAccount extends AppModel
{
	var $name = 'UserAccount';
	function add_account($user_id,$amount,$payment_time,$admin_user,$admin_note,$process_type,$payment){
 	 $created=date('Y-m-d H:i:s');
 	 $account_info=array(
 	 	     'user_id'=>$user_id,
 	 	     'amount'=>$amount,
 	 	     'paid_time'=>$payment_time,
 	 	     'process_type'=>$process_type,
 	 	     'admin_user'=>$admin_user,
 	 	     'admin_note'=>$admin_note,
 	 	     'payment'=>$payment,
 	 	     'created'=>$created
 	 	 );
 	 if($this->save(array('UserAccount'=>$account_info))){
 	 	 return true;
 	 }
 	 else{
 	 	 return false;
 	 }
 }
}
?>