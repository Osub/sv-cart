<?php 
/**
 * This is a component to send email from CakePHP using PHPMailer
 * @link http://bakery.cakephp.org/articles/view/94
 * @see http://bakery.cakephp.org/articles/view/94
 */
App::import('Vendor','Phpmailer' ,array('file'=>'phpmailer/class.phpmailer.php'));
class EmailComponent
{
  /**
   * Send email using SMTP Auth by default.
   */
    var $from         = 'phpmailer@cakephp';
    var $fromName     = "Cake PHP-Mailer";
    var $smtpUserName = '';  // SMTP username
    var $smtpPassword = ''; // SMTP password
    var $smtpHostNames= "";  // specify main and backup server
    var $text_body = null;
    var $html_body = null;
    var $to = null;
    var $toName = null;
    var $addccto = null;
    var $addcctoName = null;
    var $addbccto = null;
    var $addbcctoName = null;
    var $subject = null;
    var $cc = null;
    var $bcc = null;
    var $template = 'email/default';
    var $attachments = null;
    var $controller;
	var $is_ssl = 0;//是否开启SSL
	var $is_mail_smtp = 0;
	var $smtp_port = 25;//email端口
	
	var $configs;
	
    function startup( &$controller ) {
      $this->controller = &$controller;
    }

    function bodyText() {
    /** This is the body in plain text for non-HTML mail clients
     */
      ob_start();
      $temp_layout = $this->controller->layout;
      $this->controller->layout = '';  // Turn off the layout wrapping
      $this->controller->render($this->template . '_text'); 
      $mail = ob_get_clean();
      $this->controller->layout = $temp_layout; // Turn on layout wrapping again
      return $mail;
    }

    function bodyHTML() {
    /** This is HTML body text for HTML-enabled mail clients
     */
      ob_start();
      $temp_layout = $this->controller->layout;
      $this->controller->layout = 'email';  //  HTML wrapper for my html email in /app/views/layouts
      $this->controller->render($this->template . '_html'); 
      $mail = ob_get_clean();
      $this->controller->layout = $temp_layout; // Turn on layout wrapping again
      return $mail;
    }

    function attach($filename, $asfile = '') {
      if (empty($this->attachments)) {
        $this->attachments = array();
        $this->attachments[0]['filename'] = $filename;
        $this->attachments[0]['asfile'] = $asfile;
      } else {
        $count = count($this->attachments);
        $this->attachments[$count+1]['filename'] = $filename;
        $this->attachments[$count+1]['asfile'] = $asfile;
      }
    }

    function send(){
    	
    	
		$mail = new PHPMailer();
		if($this->is_mail_smtp==0){
			$mail->IsMail();            // set mailer to use SMTP
		}
		else{
			$mail->IsSMTP();            
    	}
    	$mail->SMTPAuth = true;     // turn on SMTP authentication
    	if($this->is_ssl==1){
    		$mail->SMTPSecure = "ssl";
    	}
    	$mail->Port = $this->smtp_port;
    	$mail->Host   = $this->smtpHostNames;
    	if($this->is_mail_smtp==1){
	    	$mail->Username = $this->smtpUserName;
	    	$mail->Password = $this->smtpPassword;
	    }
	   	//$mail->SMTPDebug = 10;
	    $mail->From     = $this->from;
	    $mail->FromName = $this->fromName;
	    $mail->AddAddress($this->to, $this->toName );
	    if(!empty($this->addccto)&&!empty($this->addcctoName)){
	    	$mail->AddCC($this->addccto,$this->addcctoName);
	    }
	    if(!empty($this->addbccto)&&!empty($this->addbcctoName)){
	    	$mail->AddBCC($this->addbccto,$this->addbcctoName);
	    }
	    $mail->AddReplyTo($this->from, $this->fromName );
	    $mail->CharSet  = 'UTF-8';
	    $mail->WordWrap = 50;
	    if(!empty($this->attachments)){
			foreach ($this->attachments as $attachment){
				if(empty($attachment['asfile'])){
					$mail->AddAttachment($attachment['filename']);
	        	}
	        	else{
	          		$mail->AddAttachment($attachment['filename'], $attachment['asfile']);
	        	}
	      	}
	    }
	    $mail->IsHTML(true); 
	    $mail->Subject = $this->subject;
	    $mail->Body    = $this->html_body;
	    $mail->AltBody = $this->text_body;
	    $result = $mail->Send();
	    if($result == false ){
		    $result = $mail->ErrorInfo;
		}
		return $result;
    }
   	function send_mail($locale,$status,$mailsendqueue){
   		

		if(isset($status)&&$status != 1){
			$this_model = new Model(false,"mail_send_queues");
			$this_model->deleteAll(array("flag"=>"5"));//删除发送失败
			$mail_send_queue_info = $this_model->find("all",array("limit"=>"10","order"=>"id asc"));
			$this_model->saveAll($mailsendqueue);//保存邮件队列
		}else{	
				$this->set_configs($locale);//设置参数
				$this->is_ssl=trim($this->configs['smtp_ssl']);
				$this->is_mail_smtp=trim($this->configs['mail_service']);
				$this->smtp_port=trim($this->configs['smtp_port']);
				$this->smtpHostNames=trim($this->configs['smtp_host']);
				$this->smtpUserName=trim($this->configs['smtp_user']);
				$this->smtpPassword=trim($this->configs['smtp_pass']);
				$this->from=$this->configs['smtp_user'];
				
				$this_model = new Model(false,"mail_send_histories");
				
				$this->sendAs=$mailsendqueue['sendas'];
				$this->fromName = $mailsendqueue['sender_name'];//网店名称
			  	$subject = $mailsendqueue['title'];//主题
			 	eval("\$subject = \"$subject\";");
			  	$this->subject="=?utf-8?B?".base64_encode($subject)."?=";
			  	$to_email_and_name = explode(";",$mailsendqueue['receiver_email']);//收件人email
			  	$to_name = $to_email_and_name[0];//收件人姓名
			  	$to_email = $to_email_and_name[1];//收件人email
			  	$addcc_to_email_and_name = explode(";",$mailsendqueue['cc_email']);
			  	$addcc_to_name = $addcc_to_email_and_name[0];//抄送人姓名
			  	$addcc_to_email = $addcc_to_email_and_name[1];//抄送人email
			  	$addbcc_to_email_and_name = explode(";",$mailsendqueue['bcc_email']);//抄送人email
			  	$addbcc_to_name = $addbcc_to_email_and_name[0];//抄送人姓名
			  	$addbcc_to_email = $addbcc_to_email_and_name[1];//抄送人email
			 	$this->html_body=$mailsendqueue['html_body'];
				$this->text_body=$mailsendqueue['text_body'];
				//收件人
				$this->toName=trim($to_name);
				$this->to=trim($to_email);
				//抄送人
				$this->addcctoName=trim($addcc_to_name);
				$this->addccto=trim($addcc_to_email);
				//暗送人
				$this->addbcctoName=trim($addbcc_to_name);
				$this->addbccto=trim($addbcc_to_email);
				$mail_status = $this->send();
				$this_model->saveAll($mailsendqueue);
		}
		return true;
	}
    function test($locale="chi"){
		$this_model = new Model(false,"configs");
		$config = $this_model->find("all",array("conditions"=>array("code"=>array("smtp_ssl","mail_service","smtp_port","smtp_host","smtp_user","smtp_pass","smtp_user"))));

    	foreach( $config as $k=>$v ){
    		$config_id[] = $v["Model"]["id"];
    		$config_code[$v["Model"]["code"]] = $v["Model"]["id"];
    	}
    	$this_model = new Model(false,"config_i18ns");
    	$configi18n = $this_model->find("all",array("conditions"=>array("config_id"=>$config_id,"locale"=>$locale),"fields"=>array("config_id","value")));
    	foreach($configi18n as $k=>$v){
    		$value[$v["Model"]["config_id"]] = $v["Model"]["value"];
    	}
    	foreach( $config_code as $k=>$v ){
    		$this->configs[$k] = $value[$v];
    	}
    }
    function set_configs($locale="chi"){
		$this_model = new Model(false,"configs");
		$config = $this_model->find("all",array("conditions"=>array("code"=>array("smtp_ssl","mail_service","smtp_port","smtp_host","smtp_user","smtp_pass","smtp_user"))));

    	foreach( $config as $k=>$v ){
    		$config_id[] = $v["Model"]["id"];
    		$config_code[$v["Model"]["code"]] = $v["Model"]["id"];
    	}
    	$this_model = new Model(false,"config_i18ns");
    	$configi18n = $this_model->find("all",array("conditions"=>array("config_id"=>$config_id,"locale"=>$locale),"fields"=>array("config_id","value")));
    	foreach($configi18n as $k=>$v){
    		$value[$v["Model"]["config_id"]] = $v["Model"]["value"];
    	}
    	foreach( $config_code as $k=>$v ){
    		$this->configs[$k] = $value[$v];
    	}
    }
}
?>