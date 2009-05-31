<?php
/*****************************************************************************
 * SV-Cart 用户中心通用方法
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: commons_controller.php 1883 2009-05-31 11:20:54Z huangbo $
*****************************************************************************/
class CommonsController extends AppController {

	var $name = 'Commons';
    var $components = array ('Email'); // Added 
	var $uses = array('Language','Navigation','Region','UserAddress','UserRank','MailTemplate');

	//$languages = $this->requestAction('commons/get_languages_front/'); 
 	function get_languages_front(){
 		$languages = $this->Language->findall("Language.front <> '0' ");
		return $languages;
 	}
 	
	//$navigations = $this->requestAction('commons/get_navigations/T');
 	function get_navigations($type){

 		$this->Navigation->set_locale($this->locale);
 		$navigations = $this->Navigation->getbytypes($type);
 		return $navigations;
 	}
 	

    function locale($locale="chi") {
        
        $result = NULL;
        $default_locale="chi";
        
        $languages=$this->Language->findall("Language.front <> '0' ");
        
        if(is_array($languages) && sizeof($languages)>0 ){
            $has=false;
            foreach($languages as $language){
                if($language['Language']['front'] == '2'){
                    $default_locale=$language['Language']['locale'];
                }
                if($language['Language']['locale'] == $locale){
                    $has = true;
                }
                
            }
            
            if(!$has) {
                $locale=$default_locale;
                $result->error = 1;
                $result->message = __("No Language!",true);
            }else{
                $result->error = 0;
            }
            setcookie("locale",$locale,time()+60*60*24*30,"/");
    //                pr($_COOKIE);
        /* 切换语言后更改SESSION中 商品的属性 */
				if(isset($_SESSION['svcart']['products'])){
					$this->Product->set_locale($locale);
					foreach($_SESSION['svcart']['products'] as $product){
						$quantity = $product['quantity'];
	                    $is_promotion = $product['is_promotion'];
	                    $market_subtotal = $product['market_subtotal'];
	                    $subtotal = $product['subtotal'];
	                    $discount_price = $product['discount_price'];
	                    $discount_rate = $product['discount_rate'];
						$product_i18n = $this->Product->findbyid($product['Product']['id']);
						$_SESSION['svcart']['products'][$product['Product']['id']] = $product_i18n;
						$_SESSION['svcart']['products'][$product['Product']['id']]['quantity'] = $quantity;
	                    $_SESSION['svcart']['products'][$product['Product']['id']]['is_promotion'] = $is_promotion;
	                    $_SESSION['svcart']['products'][$product['Product']['id']]['market_subtotal'] = $market_subtotal;
	                    $_SESSION['svcart']['products'][$product['Product']['id']]['subtotal'] = $subtotal;
	                    $_SESSION['svcart']['products'][$product['Product']['id']]['discount_price'] = $discount_price;
	                    $_SESSION['svcart']['products'][$product['Product']['id']]['discount_rate'] = $discount_rate;
					}
				}
				if(isset($_SESSION['svcart']['packagings'])){
					$this->Packaging->set_locale($locale);
					foreach($_SESSION['svcart']['packagings'] as $packaging){
						$quantity = $packaging['quantity'];
	                    $subtotal = $packaging['subtotal'];
	                    $is_promotion = $packaging['is_promotion'];
						$packaging_i18n = $this->Packaging->findbyid($packaging['Packaging']['id']);
						$_SESSION['svcart']['packagings'][$packaging['Packaging']['id']] = $packaging_i18n;
						$_SESSION['svcart']['packagings'][$packaging['Packaging']['id']]['subtotal'] = $subtotal;
	                    $_SESSION['svcart']['packagings'][$packaging['Packaging']['id']]['quantity'] = $quantity;
	                    $_SESSION['svcart']['packagings'][$packaging['Packaging']['id']]['is_promotion'] = $is_promotion;
					}
				}
				if(isset($_SESSION['svcart']['cards'])){
					$this->Card->set_locale($locale);
					foreach($_SESSION['svcart']['cards'] as $card){
						$quantity = $card['quantity'];
	                    $subtotal = $card['subtotal'];
	                    $is_promotion = $card['is_promotion'];
						$card_i18n = $this->Card->findbyid($card['Card']['id']);
						$_SESSION['svcart']['cards'][$card['Card']['id']] = $card_i18n;
						$_SESSION['svcart']['cards'][$card['Card']['id']]['subtotal'] = $subtotal;
	                    $_SESSION['svcart']['cards'][$card['Card']['id']]['quantity'] = $quantity;
	                    $_SESSION['svcart']['cards'][$card['Card']['id']]['is_promotion'] = $is_promotion;
					}
        		}
        
        }
        else{
            
            $result->error = 1;
            $result->message = __("No Data!",true);
        }
        
        $this->set('Result',json_encode($result));

        $this->layout = 'ajax';

    
    }
	
		/**
 * ûʵIPַ
 *
 * @access  public
 * @return  string
 */
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

            /* ȡX-Forwarded-ForеһunknownЧIPַ */
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
 

//会员等级
 function get_rank($rank_id){
 	    $this->layout = 'blank';
 	 	$this->UserRank->set_locale($this->locale);
 	    $rank=$this->UserRank->find("UserRank.id = $rank_id");
 	    $rank_name=$rank['UserRankI18n']['name'];
 	    return $rank_name;
 }
 
 /*********发送邮件   ***********/
 
 /****** $arr  邮件所需内容数组*/
 
 /*********发送邮件   ***********/
 
  function send_email($to_email,$template_str){
  	    //echo $template_str;
  	    //echo "--------------";
 	    //$template_html=str_replace('*','/',$template_str);
  		$this->Email->smtpHostNames = "".$this->configs['smtp_host']."";
        $this->Email->smtpUserName = "".$this->configs['smtp_user']."";
        $this->Email->smtpPassword = "".$this->configs['smtp_pass']."";
				$this->Email->is_ssl = $this->configs['smtp_ssl'];
				$this->Email->smtp_port = $this->configs['smtp_port'];        
        $this->Email->from = "".$this->configs['smtp_user']."";
        $this->Email->to = "".$to_email."";
        $this->Email->fromName = "liying";
        //echo $template_html;
  	    $this->Email->html_body = "".$template_str."";
       // $this->Email->template = "".$template['MailTemplateI18n']['html_body']."";
       
       //echo "commons";
	   $this->Email->send();
	   //echo $this->Email->send();
		return true;
 	}
       /**
	 * 加密函数
	 * @param   string  $str    加密前的字符串
	 * @param   string  $key    密钥
	 * @return  string  加密后的字符串
	 */
	function encrypt($str, $key = AUTH_KEY)
	{
	    $coded = '';
	    $keylength = strlen($key);

	    for ($i = 0, $count = strlen($str); $i < $count; $i += $keylength)
	    {
	        $coded .= substr($str, $i, $keylength) ^ $key;
	    }

	    return str_replace('=', '', base64_encode($coded));
	}
	/**
	 * 解密函数
	 * @param   string  $str    加密后的字符串
	 * @param   string  $key    密钥
	 * @return  string  加密前的字符串
	 */
	function decrypt($str, $key = AUTH_KEY)
	{
	    $coded = '';
	    $keylength = strlen($key);
	    $str = base64_decode($str);

	    for ($i = 0, $count = strlen($str); $i < $count; $i += $keylength)
	    {
	        $coded .= substr($str, $i, $keylength) ^ $key;
	    }

	    return $coded;
	}
}

?>