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
class SendlistsController extends AppController {

	var $name = 'Sendlists';
    var $components=array('Pagination','RequestHandler','Email');
    var $helpers=array('Pagination','Html','Form');
    var $uses=array("MailSendQueue","MailSendHistory");
    function index(){
    	
    	$this->operator_privilege('mail_queue_management_view');
    	$this->pageTitle="邮件队列管理"." - ".$this->configs['shop_name'];
    	$this->navigations[] = array('name'=>'邮件管理','url'=>'');
        $this->navigations[]=array('name' => '邮件队列管理','url' => '/sendlists/');
        $this->set('navigations',$this->navigations);

    	$condition = "";
    	$total=$this->MailSendQueue->findCount($condition,0);
        $sortClass='MailSendQueue';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        $mailsendqueue_data=$this->MailSendQueue->find("all",array("conditions"=>$condition,"limit"=>$rownum,"page"=>$page));
		$this->set("mailsendqueue_data",$mailsendqueue_data);
	}
	//单个删除
	function remove($id){
		$this->MailSendQueue->del($id);
		die();
	}
	//批量删除
	function batch_delete(){
		$checkbox_value = $this->params['url']['checkbox'];
		$this->MailSendQueue->deleteAll(array("id"=>$checkbox_value));
		
		//操作员日志
		if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
			$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'邮件队列批量','operation');
		}
		$this->flash("邮件队列批量删除成功！",'/sendlists/',10);
	}
	//选择发送
	function batch_sel_send(){
		$checkbox_value = $this->params['url']['checkbox'];
		$this->MailSendQueue->deleteAll(array("flag"=>"5"));
		$mail_send_queue_info = $this->MailSendQueue->find("all",array("conditions"=>array("id"=>$checkbox_value),"order"=>"pri asc"));
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
		$this->flash("邮件队列批量发送成功！",'/sendlists/',10);

	}
	//全部发送
	function batch_all_send(){
		$this->MailSendQueue->deleteAll(array("flag"=>"5"));
		$mail_send_queue_info = $this->MailSendQueue->find("all",array("order"=>"pri asc"));
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
		$this->flash("邮件队列批量发送成功！",'/sendlists/',10);
	}
}

?>