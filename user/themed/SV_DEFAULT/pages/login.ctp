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
 * $Id: login.ctp 3233 2009-07-22 11:41:02Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<div id="login-box">
    	<div class="menber-login">
			<h1>· <?php echo $SCLanguages['member'].$SCLanguages['login']?></h1>
			<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'login-top.gif':'login-top.gif',array('align'=>'absbottom'))?>
			<div class="box">
			<form action="">
			<dl>
				<dt><?php echo $SCLanguages['username']?></dt><dd><input type="text" name="data[User][name]" id="UserName_page" tabindex="1"/></dd>
			</dl>
			<dl>
				<dt><?php echo $SCLanguages['password']?></dt><dd><input type="password" name="data[User][password]" id="UserPassword_page" tabindex="2"/>
			<?php echo $html->link($SCLanguages['forget_password']."?","forget_password/",array("tabindex"=>"5"),false,false);?>
					</dd></dl>	
			<dl <?php if($SVConfigs['use_captcha'] == 0){?>style="display:none"<?php }?>>
			<dt><?php echo $SCLanguages['verify_code']?></dt>
			<dd class="vidata"><input type="text"  name="data[User][captcha]" id="UserCaptcha_page" value="<?php echo $SCLanguages['obtain_verification_code']?>" onfocus="javascript:get_captcha('login_captcha_page');"  tabindex="3" /> 
		    <span id="authnum_img_span" style="display:none">
				<a href="javascript:show_login_captcha('login_captcha_page');"><img id="login_captcha_page"  /></a>
			</span>
		    </dd>
			</dl>	
			<dl id="error_message_area" style="margin-bottom:0;display:none;">
			<dt></dt><dd class="vidata" id="error_msg"></dd>
			</dl>
			<p class="submit-btn" style="margin-top:0;">
			<?php echo $html->link($SCLanguages['confirm'],"javascript:user_login();",array("tabindex"=>"4"),false,false);?>
			<?php echo $html->link($SCLanguages['register'],"/register/","",false,false);?>
			</p>
			</form></div>
			<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'login-bottom.gif':'login-bottom.gif',array('align'=>'top'))?>
			
		</div>
		<div class="login-banner">
			<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'login-banner.gif':'login-banner.gif')?></p>
			<ul>
				<li><?php echo $SCLanguages['make_you_enjoy_internet_shopping']?></li>
				<li><?php echo $SCLanguages['more_choices_quicker_service']?></li>
			</ul>
		</div>
    </div>
<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>
