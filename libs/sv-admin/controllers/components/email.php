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
    var $subject = null;
    var $cc = null;
    var $bcc = null;
    var $template = 'email/default';
    var $attachments = null;
    var $controller;
	var $is_ssl = 0;//ÊÇ·ñ¿ªÆôSSL
	var $is_mail_smtp = 0;
	var $smtp_port = 25;//email¶Ë¿Ú
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
    	//$this->Config->findall();
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
	    $mail->AddReplyTo($this->from, $this->fromName );
	    
	    $mail->CharSet  = 'UTF-8';
	    $mail->WordWrap = 50;  

	    if (!empty($this->attachments)) {
	      foreach ($this->attachments as $attachment) {
	        if (empty($attachment['asfile'])) {
	          $mail->AddAttachment($attachment['filename']);
	        } else {
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
}
?>