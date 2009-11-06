<?php
/*****************************************************************************
 * SV-Cart 用户管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: votes_controller.php 3179 2009-07-22 05:09:18Z zhengli $
*****************************************************************************/
class MailSendShell extends Shell {
    var $components = array ('Pagination','RequestHandler','Email');
	var $uses = array("Config","MailSendQueue","MailSendHistory");
	
	function main(){		
		$this->MailSendQueue->deleteAll(array("flag"=>"5"));
		$mail_send_queue_info = $this->MailSendQueue->find("all",array("limit"=>"10","order"=>"id asc"));
		//pr($mail_send_queue_info);
		$this->Email->is_ssl=trim($this->configs['smtp_ssl']);
		$this->Email->is_mail_smtp=trim($this->configs['mail_service']);
		$this->Email->smtp_port=trim($this->configs['smtp_port']);
		$this->Email->smtpHostNames=trim($this->configs['smtp_host']);
		$this->Email->smtpUserName=trim($this->configs['smtp_user']);
		$this->Email->smtpPassword=trim($this->configs['smtp_pass']);
		$this->Email->from=$this->configs['smtp_user'];
		foreach( $mail_send_queue_info as $k=>$v){
			$this->Email->sendAs=$v['MailSendQueue']['sendas'];
			$this->Email->fromName = $v['MailSendQueue']['sender_name'];//网店名称
		  	$subject = $v['MailSendQueue']['title'];//主题
		 	eval("\$subject = \"$subject\";");
		  	$this->Email->subject="=?utf-8?B?".base64_encode($subject)."?=";
		  	$to_email_and_name = explode(";",$v['MailSendQueue']['receiver_email']);//收件人email
		  	$to_name = $to_email_and_name[0];//收件人姓名
		  	$to_email = $to_email_and_name[1];//收件人email
		  	$addcc_to_email_and_name = explode(";",$v['MailSendQueue']['cc_email']);
		  	$addcc_to_name = $addcc_to_email_and_name[0];//抄送人姓名
		  	$addcc_to_email = $addcc_to_email_and_name[1];//抄送人email
		  	$addbcc_to_email_and_name = explode(";",$v['MailSendQueue']['bcc_email']);//抄送人email
		  	$addbcc_to_name = $addbcc_to_email_and_name[0];//抄送人姓名
		  	$addbcc_to_email = $addbcc_to_email_and_name[1];//抄送人email
		 	$this->Email->html_body=$v['MailSendQueue']['html_body'];
			$this->Email->text_body=$v['MailSendQueue']['text_body'];
			//收件人
			$this->Email->toName=trim($to_name);
			$this->Email->to=trim($to_email);
			//抄送人
			$this->Email->addcctoName=trim($addcc_to_name);
			$this->Email->addccto=trim($addcc_to_email);
			//暗送人
			$this->Email->addbcctoName=trim($addbcc_to_name);
			$this->Email->addbccto=trim($addbcc_to_email);
			
			$mail_status = $this->Email->send();
			
			//pr($mail_status);
			if( $mail_status == 1 ){
				$this->MailSendQueue->del($v["MailSendQueue"]["id"]);
				$v["MailSendQueue"]["flag"] = 1;
			}
			else{
				$this->MailSendQueue->del($v["MailSendQueue"]["id"]);
				$v["MailSendQueue"]["flag"] = $v["MailSendQueue"]["flag"]+1;
				$v["MailSendQueue"]["id"] = "";
				$this->MailSendQueue->saveAll($v);
				$v["MailSendQueue"]["flag"] = 0;
			}
			$this->MailSendHistory->saveAll(array("MailSendHistory"=>$v["MailSendQueue"]));
		}
		return true;
	}
	
}

?>