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
 * $Id: newsletter_controller.php 5527 2009-11-05 02:07:24Z huangbo $
*****************************************************************************/
class NewsletterController extends AppController {
	var $name = 'Newsletter';
	var $helpers = array('Html');
	var $uses = array('NewsletterList','MailTemplate');
	var $components = array('RequestHandler','Email');
 
 	function add(){
 		$result['type'] = 2;
 		$result['msg'] = $this->languages['subscribe'].$this->languages['failed'];
 		if($this->RequestHandler->isPost()){	
 			if($this->NewsletterList->check_unique_email($_POST['email'])){
 				$result['type'] = 1;
 				$result['msg'] = $this->languages['not_repeat_subscribe'];
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
		 		$result['msg'] = $this->languages['subscribe'].$this->languages['successfully'];
		 		/* 发送激活邮件 */
		 		$shop_name=$this->configs['shop_name'];
		 		$send_date=date('Y-m-d');
		 		//生成 md5加密 code  == id + email
		 		$code = md5($id . $_POST['email']);
		 		$url = $this->server_host.$this->cart_webroot."newsletter/verify/".$id."/".$code."/";
		 		//$url = "/$id/$code";
		 		$this->MailTemplate->set_locale($this->locale);
  	            $template=$this->MailTemplate->find("code = 'news_letter_lists' and status = 1");
  	            $template_str=$template['MailTemplateI18n']['html_body'];
				/* 商店网址 */
				$shop_url = $this->server_host.$this->cart_webroot;
  	            eval("\$template_str = \"$template_str\";");
		        $text_body = $template['MailTemplateI18n']['text_body'];
		     	eval("\$text_body = \"$text_body\";");
				$subject = $template['MailTemplateI18n']['title'];
				eval("\$subject = \"$subject\";");
				$mailsendqueue = array(
					"sender_name"=>$shop_name,//发送从姓名
					"receiver_email"=>";".$to_email,//接收人姓名;接收人地址
				 	"cc_email"=>";",//抄送人
				 	"bcc_email"=>";",//暗送人
				  	"title"=>$subject,//主题 
				   	"html_body"=>$template_str,//内容
				  	"text_body"=>$text_body,//内容
				 	"sendas"=>"html"
				);
				$this->Email->send_mail($this->locale,$this->configs['email_the_way'], $mailsendqueue);

				if($this->Email->send_mail($this->locale,$this->configs['email_the_way'], $mailsendqueue)){
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
 		$this->pageTitle = $this->languages['activation'].$this->languages['subscribe']." - ".$this->configs['shop_title'];
 		$email = $this->NewsletterList->findbyid($id);
	 	if($code <> md5($id . $email['NewsletterList']['email'])){
	 		$this->flash($this->languages['invalid_url'],'/','');
	 	}else if($email['NewsletterList']['status'] == 1){
 			$this->flash($this->languages['activation'].$this->languages['successfully'],'/','');
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
				$shop_url = $this->server_host.$this->cart_webroot;
				eval("\$template_str = \"$template_str\";");
		        $text_body = $template['MailTemplateI18n']['text_body'];
		     	eval("\$text_body = \"$text_body\";");
				$subject = $template['MailTemplateI18n']['title'];
				eval("\$subject = \"$subject\";");
				$mailsendqueue = array(
					"sender_name"=>$shop_name,//发送从姓名
					"receiver_email"=>";".$to_email,//接收人姓名;接收人地址
				 	"cc_email"=>";",//抄送人
				 	"bcc_email"=>";",//暗送人
				  	"title"=>$subject,//主题 
				   	"html_body"=>$template_str,//内容
				  	"text_body"=>$text_body,//内容
				 	"sendas"=>"html"
				);
				$this->Email->send_mail($this->locale,$this->configs['email_the_way'], $mailsendqueue);
	  
			}
	 		
	 		$this->flash($this->languages['activation'].$this->languages['successfully'],'/','');
 		}
 	}
 	
 	function cancel($id,$code){
 		$this->pageTitle = $this->languages['unsubscribe']." - ".$this->configs['shop_title'];

 		$email = $this->NewsletterList->findbyid($id);
 		if($code <> md5($id . $email['NewsletterList']['email'])){
	 		$this->flash($this->languages['invalid_url'],'/','');
	 	}
 		if($email['NewsletterList']['status'] == 1){
 			$this->flash($this->languages['unsubscribe'].$this->languages['successfully'],'/','');
 		}
 		$email['NewsletterList']['status'] = 2;
 		$this->NewsletterList->save($email);
 		$this->flash($this->languages['unsubscribe'].$this->languages['successfully'],'/','');
 	}
}

?>