<?php
/*****************************************************************************
 * SV-Cart �û��˵�
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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