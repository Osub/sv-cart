<?php
/*****************************************************************************
 * SV-Cart 联系我们
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: newsletter_controller.php 3334 2009-07-27 06:45:04Z shenyunfeng $
*****************************************************************************/
class ContactsController extends AppController {
	var $name = 'Contacts';
	var $helpers = array('Html');
	var $uses = array('MailTemplate','Contact','MailSendQueue');
	var $components = array('RequestHandler','Email');

	function index(){
		$this->pageTitle = $this->data['languages']['contact_us']." - ".$this->configs['shop_title'];
		$this->navigations[] = array('name'=>$this->data['languages']['contact_us'],'url'=>"/contact/");
		$this->page_init();
		
		if($this->RequestHandler->isPost()){	
			//	$this->Contact->save($this->data['Contact']);
				$company_name = $this->data['Contact']['company'];
				$company_type = $this->information_info['company_type'][$this->data['Contact']['company_type']];
				$from_type = isset($this->information_info['from_type'][$this->data['Contact']['from']])?$this->information_info['from_type'][$this->data['Contact']['from']]:"未选择";
				$connect_person = $this->data['Contact']['contact_name'];
				$email = $this->data['Contact']['email'];
				$mobile = $this->data['Contact']['mobile'];
				$qq = $this->data['Contact']['qq'];
				$msn = $this->data['Contact']['msn'];
				$skype = $this->data['Contact']['skype'];
				$content = $this->data['Contact']['content'];
				$this->data['Contact']['company_url'] = $this->data['Contact']['web']; 
		//		$this->data['Contact']['company_type'] = $company_type;
				$this->data['Contact']['resolution'] = $this->data['Contact']['width']."*".$this->data['Contact']['height'];
				
				$this->data['Contact']['ip_address'] = $this->real_ip();
				$this->data['Contact']['browser'] = $this->getbrowser();
				$this->data['Contact']['locale'] = $this->locale;
				$this->Contact->save($this->data['Contact']);
		 		$shop_name=$this->configs['shop_name'];
		 		$send_date=date('Y-m-d');
		 		$this->MailTemplate->set_locale($this->locale);
  	            $template=$this->MailTemplate->find("code = 'contact_us' and status = 1");
  	            $template_str=$template['MailTemplateI18n']['html_body'];
				/* 商店网址 */
				$shop_url = $this->server_host.$this->cart_webroot;
  	            eval("\$template_str = \"$template_str\";");
		 	  	$this->Email->smtpHostNames = "".$this->configs['smtp_host']."";
			    $this->Email->smtpUserName = "".$this->configs['smtp_user']."";
			    $this->Email->smtpPassword = "".$this->configs['smtp_pass']."";
				$this->Email->is_ssl = $this->configs['smtp_ssl'];
				$this->Email->is_mail_smtp = $this->configs['mail_service'];
				$this->Email->smtp_port = $this->configs['smtp_port'];
			    $this->Email->from = "".$this->configs['smtp_user']."";
			    $this->Email->to = "".$this->data['Contact']['email']."";
			    $this->Email->fromName =$shop_name;
			  	$this->Email->html_body = "".$template_str."";
		        $text_body = $template['MailTemplateI18n']['text_body'];
		     	eval("\$text_body = \"$text_body\";");
		  	    $this->Email->text_body = $text_body;
				$subject = $template['MailTemplateI18n']['title'];
				eval("\$subject = \"$subject\";");
				$mail_send_queue = array(
										'id'=>'',
										'sender_name' => $shop_name,
										'receiver_email' => $this->data['Contact']['contact_name'].";".$this->data['Contact']['email'],
										'cc_email' => ";",
										'bcc_email' => "admin;".$this->configs['smtp_mail'],
										'title' => $subject,
										'html_body' => $template_str,
										'text_body' => $text_body,
										'sendas' => 'html',
										'flag' => 0,
										'pri' => 0
										);
				$this->Email->subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
				$this->MailSendQueue->save($mail_send_queue);
				
			/*	$this->Email->bcc($this->configs['smtp_mail'],'admin');
				@$this->Email->send(); */
				
		    $this->flash("感谢你的联系，我们会在最短的时间内联系您 ~ ".$this->configs['contactus_conversion'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"/",3);
		}
		$js_languages = array(
       						"company_name_not_empty" => $this->languages['company_name'].$this->languages['can_not_empty'],
				       		"invalid_email" => $this->languages['email'].$this->languages['format'].$this->languages['not_correct'],
							"please_choose_company_type" =>  $this->languages['please_choose'].$this->languages['industry'],
							"connect_person_can_not_empty" =>  $this->languages['connect_person'].$this->languages['can_not_empty'],
							"mobile_can_not_empty" =>  $this->languages['mobile'].$this->languages['can_not_empty'],
							"content_can_not_empty" => $this->languages['content'].$this->languages['can_not_empty']
							);
		$this->set('js_languages',$js_languages);
	}
	
		function real_ip()
	{
	    static $realip = NULL;

	    if ($realip !== NULL)
	    {
	        return $realip;
	    }

	    if (isset($_SERVER))
	    {
	        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        {
	            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

	            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
	            foreach ($arr AS $ip)
	            {
	                $ip = trim($ip);

	                if ($ip != 'unknown')
	                {
	                    $realip = $ip;

	                    break;
	                }
	            }
	        }
	        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
	        {
	            $realip = $_SERVER['HTTP_CLIENT_IP'];
	        }
	        else
	        {
	            if (isset($_SERVER['REMOTE_ADDR']))
	            {
	                $realip = $_SERVER['REMOTE_ADDR'];
	            }
	            else
	            {
	                $realip = '0.0.0.0';
	            }
	        }
	    }
	    else
	    {
	        if (getenv('HTTP_X_FORWARDED_FOR'))
	        {
	            $realip = getenv('HTTP_X_FORWARDED_FOR');
	        }
	        elseif (getenv('HTTP_CLIENT_IP'))
	        {
	            $realip = getenv('HTTP_CLIENT_IP');
	        }
	        else
	        {
	            $realip = getenv('REMOTE_ADDR');
	        }
	    }

	    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
	    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

	    return $realip;
	}     
    
	function getbrowser()
	{
	     global $_SERVER;

	     $agent           = $_SERVER['HTTP_USER_AGENT'];
	     $browser         = '';
	     $browser_ver     = '';
	    
	     if (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs))
	     {
	         $browser         = 'OmniWeb';
	         $browser_ver     = $regs[2];
	     }
	    
	     if (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs))
	     {
	         $browser         = 'Netscape';
	         $browser_ver     = $regs[2];
	     }
	    
	     if (preg_match('/safari\/([^\s]+)/i', $agent, $regs))
	     {
	         $browser         = 'Safari';
	         $browser_ver     = $regs[1];
	     }
	    
	     if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs))
	     {
	         $browser         = 'Internet Explorer';
	         $browser_ver     = $regs[1];
	     }
	    
	     if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs))
	     {
	         $browser         = 'Opera';
	         $browser_ver     = $regs[1];
	     }
	    
	     if (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs))
	     {
	         $browser         = '(Internet Explorer ' .$browser_ver. ') NetCaptor';
	         $browser_ver     = $regs[1];
	     }
	    
	     if (preg_match('/Maxthon/i', $agent, $regs))
	     {
	         $browser         = '(Internet Explorer ' .$browser_ver. ') Maxthon';
	         $browser_ver     = '';
	     }
	    
	     if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs))
	     {
	         $browser         = 'FireFox';
	         $browser_ver     = $regs[1];
	     }
	    
	     if (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs))
	     {
	         $browser         = 'Lynx';
	         $browser_ver     = $regs[1];
	     }
	    
	     if ($browser != '')
	     {
	        return $browser.' '.$browser_ver;
	     }
	     else
	     {
	         return 'Unknow browser';
	     }
	}

}