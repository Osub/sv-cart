<?php
/*****************************************************************************
 * SV-Cart 验证码
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: authnums_controller.php 1726 2009-05-25 10:25:03Z zhengli $
*****************************************************************************/
class AuthnumsController extends AppController {
	var $name = 'Authnums';
	var $helpers = array('Html');
	var $uses = array();
	var $components = array ('Captcha');

	function get_authnums(){
 	    $this->layout = 'blank'; //a blank layout 
        $this->set('captcha_data', $this->captcha->show()); //dynamically creates an image 
        exit();
 	}
 	
}

?>