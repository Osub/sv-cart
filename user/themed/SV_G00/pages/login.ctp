<?php
/*****************************************************************************
 * SV-Cart 会员登录
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: login.ctp 1028 2009-04-24 12:23:26Z huangbo $
*****************************************************************************/
?>
<div id="login-box">
    	<div class="menber-login">
			<h1>· <?=$SCLanguages['member'].$SCLanguages['login']?></h1>
			<?=$html->image('login-top.gif',array('align'=>'absbottom'))?>
			<div class="box">
			<form action="">
			<dl>
				<dt><?=$SCLanguages['username']?></dt><dd><input type="text" name="data[User][name]" id="UserName_page" tabindex="1"/></dd>
			</dl>
			<dl>
				<dt><?=$SCLanguages['password']?></dt><dd><input type="password" name="data[User][password]" id="UserPassword_page" tabindex="2"/>
			<?=$html->link($SCLanguages['forget_password']."?","forget_password/",array("tabindex"=>"5"),false,false);?>
					</dd></dl>	
			<dl>
				<dt><?=$SCLanguages['verify_code']?></dt><dd class="vidata"><input type="text"  name="data[User][captcha]" id="UserCaptcha_page" tabindex="3" /> <a href="javascript:show_login_captcha('login_captcha_page');"><img id="login_captcha_page" src="<?=$this->webroot?>captcha/" /></a></dd>
			</dl>
			<dl id="error_message_area" style="margin-bottom:0;display:none;">
			<dt></dt><dd class="vidata" id="error_msg"></dd>
			</dl>
			<p class="submit-btn" style="margin-top:0;">
			<?=$html->link($SCLanguages['confirm'],"javascript:user_login();",array("tabindex"=>"4"),false,false);?>
			<?=$html->link($SCLanguages['register'],"/register/","",false,false);?>
			</p>
			</form></div>
			<?=$html->image('login-bottom.gif',array('align'=>'top'))?>
			
		</div>
		<div class="login-banner">
			<p><?=$html->image('login-banner.gif')?></p>
			<ul>
				<li><?=$SCLanguages['make_you_enjoy_internet_shopping']?></li>
				<li><?=$SCLanguages['more_choices_quicker_service']?></li>
			</ul>
		</div>
    </div>
<?php echo $this->element('news', array('cache'=>'+0 hour'));?>