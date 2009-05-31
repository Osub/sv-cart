<?php
/*****************************************************************************
 * SV-Cart 邮件
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: newsletter_controller.php 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
class NewsletterController extends AppController {
	var $name = 'Newsletter';
	var $helpers = array('Html');
	var $uses = array('NewsletterList','MailTemplate');
	var $components = array('RequestHandler','Email');
 
 	function add(){
 		$result['type'] = 2;
 		$result['msg'] = "订阅失败!";
 		if($this->RequestHandler->isPost()){	
 			if($this->NewsletterList->check_unique_email($_POST['email'])){
 				$result['type'] = 1;
 				$result['msg'] = "请不要重复订阅!";
 			}else{
		 		$email = array(	
		 						"id" => "",
		 						"status" => 0,
		 						"email" =>$_POST['email']
		 						);
		 		if($this->NewsletterList->check_unique_email_by_email($_POST['email'])){
		 			$letter_list = $this->NewsletterList->findbyemail($_POST['email']);
		 			$id =  $letter_list['NewsletterList']['id'];
		 		}else{
		 			$this->NewsletterList->save($email);
		 			$id = $this->NewsletterList->id;
		 		}
		 		$result['email'] = $_POST['email'];
		 		$result['msg'] = "订阅成功!";
		 		/* 发送激活邮件 */
		 		$shop_name=$this->configs['shop_name'];
		 		$send_date=date('Y-m-d');
	  	        $host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		 		//生成 md5加密 code  == id + email
		 		$code = md5($id . $_POST['email']);
		 		$url = "http://".$host."/newsletter/verify/".$id."/".$code."/";
		 		//$url = "/$id/$code";
		 		$this->MailTemplate->set_locale($this->locale);
  	            $template=$this->MailTemplate->find("code = 'news_letter_lists' and status = 1");
  	            $template_str=$template['MailTemplateI18n']['html_body'];
				/* 商店网址 */
				$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
				$webroot = str_replace("/".WEBROOT_DIR."/","",$this->webroot);
				$shop_url = "http://".$host.$webroot;
  	            eval("\$template_str = \"$template_str\";");
		 	  	$this->Email->smtpHostNames = "".$this->configs['smtp_host']."";
			    $this->Email->smtpUserName = "".$this->configs['smtp_user']."";
			    $this->Email->smtpPassword = "".$this->configs['smtp_pass']."";
				$this->Email->is_ssl = $this->configs['smtp_ssl'];
				$this->Email->smtp_port = $this->configs['smtp_port'];
			    $this->Email->from = "".$this->configs['smtp_user']."";
			    $this->Email->to = "".$_POST['email']."";
			    $this->Email->fromName =$shop_name;
			  	$this->Email->html_body = "".$template_str."";
		        $text_body = $template['MailTemplateI18n']['text_body'];
		     	eval("\$text_body = \"$text_body\";");
		  	    $this->Email->text_body = $text_body;
				$subject = $template['MailTemplateI18n']['title'];
				eval("\$subject = \"$subject\";");
				$this->Email->subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
				if($this->Email->send()){
			      $result['type'] = 0;
			    }else{
			      $result['type'] = 1;
			    }
	 		}
 		}
	 		$this->set('result',$result);
	 		$this->layout = 'ajax';
	 }
 	
 	function verify($id,$code){
 		$this->pageTitle = "激活订阅"." - ".$this->configs['shop_title'];
 		$email = $this->NewsletterList->findbyid($id);
	 	if($code <> md5($id . $email['NewsletterList']['email'])){
	 		$this->flash("无效路径",'/','');
	 	}else if($email['NewsletterList']['status'] == 1){
 			$this->flash("已经激活",'/','');
 		}else{
	 		$email['NewsletterList']['status'] = 1;
	 		$this->NewsletterList->save($email);
	 					      // 是否发送订阅通知
			 if($this->configs['email_notification'] == 1){
				/* 发送通知 */
				$shop_name=$this->configs['shop_name'];
				$send_date=date('Y-m-d');
				$email = $email['NewsletterList']['email'];
				$this->MailTemplate->set_locale($this->locale);
				$template=$this->MailTemplate->find("code = 'email_notification' and status = '1'");
				$template_str=$template['MailTemplateI18n']['html_body'];
				/* 商店网址 */
				$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
				$webroot = str_replace("/".WEBROOT_DIR."/","",$this->webroot);
				$shop_url = "http://".$host.$webroot;
				eval("\$template_str = \"$template_str\";");
				$this->Email->is_ssl = $this->configs['smtp_ssl'];
				$this->Email->smtp_port = $this->configs['smtp_port'];
				$this->Email->smtpHostNames = "".$this->configs['smtp_host']."";
				$this->Email->smtpUserName = "".$this->configs['smtp_user']."";
				$this->Email->smtpPassword = "".$this->configs['smtp_pass']."";
				$this->Email->from = "".$this->configs['smtp_user']."";
				$this->Email->to = "".$this->configs['test_mail_address']."";
				$this->Email->fromName =$shop_name;
				$this->Email->html_body = "".$template_str."";
		        $text_body = $template['MailTemplateI18n']['text_body'];
		     	eval("\$text_body = \"$text_body\";");
		  	    $this->Email->text_body = $text_body;
				$subject = $template['MailTemplateI18n']['title'];
				eval("\$subject = \"$subject\";");
				$this->Email->subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
				$this->Email->send();		  
			}
	 		
	 		$this->flash("激活成功",'/','');
 		}
 	}
 	
 	function cancel($id,$code){
 		$this->pageTitle = "订阅取消"." - ".$this->configs['shop_title'];

 		$email = $this->NewsletterList->findbyid($id);
 		if($code <> md5($id . $email['NewsletterList']['email'])){
	 		$this->flash("无效路径",'/','');
	 	}
 		if($email['NewsletterList']['status'] == 1){
 			$this->flash("已经退订",'/','');
 		}
 		$email['NewsletterList']['status'] = 2;
 		$this->NewsletterList->save($email);
 		$this->flash("退订成功",'/','');
 	}
}

?>