<?php
/*****************************************************************************
 * SV-Cart �û�����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: votes_controller.php 3179 2009-07-22 05:09:18Z zhengli $
*****************************************************************************/
class MailSendsController extends AppController {

	var $name = 'MailSends';
    var $components = array ('Pagination','RequestHandler','Email');
    var $helpers = array('Pagination');
	var $uses = array("MailSendQueue","MailSendHistory");
	
	function index(){
		$this->MailSendQueue->deleteAll(array("flag"=>"5"));
		$mail_send_queue_info = $this->MailSendQueue->find("all",array("limit"=>"10" "order"=>"id asc"));
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
			$this->Email->fromName = $v['MailSendQueue']['sender_name'];//��������
		  	$subject = $v['MailSendQueue']['title'];//����
		 	eval("\$subject = \"$subject\";");
		  	$this->Email->subject="=?utf-8?B?".base64_encode($subject)."?=";
		  	$to_name = $v['MailSendQueue']['receiver_name'];//�ռ�������
		  	$to_email = $v['MailSendQueue']['receiver_email'];//�ռ���email
		  	$addcc_to_name = $v['MailSendQueue']['cc_name'];//����������
		  	$addcc_to_email = $v['MailSendQueue']['cc_email'];//������email
		  	$addbcc_to_name = $v['MailSendQueue']['bcc_name'];//����������
		  	$addbcc_to_email = $v['MailSendQueue']['bcc_email'];//������email
		 	$this->Email->html_body=$v['MailSendQueue']['html_body'];
			$this->Email->text_body=$v['MailSendQueue']['text_body'];
			//�ռ���
			$this->Email->toName=trim($to_name);
			$this->Email->to=trim($to_email);
			//������
			$this->Email->addcctoName=trim($addcc_to_name);
			$this->Email->addccto=trim($addcc_to_email);
			//������
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
		die();
	}
	
}

?>