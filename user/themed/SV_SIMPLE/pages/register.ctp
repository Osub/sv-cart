<?php 
/*****************************************************************************
 * SV-Cart 注册
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: register.ctp 1635 2009-05-22 06:26:14Z zhengli $
*****************************************************************************/
?>
<?php echo $javascript->link(array('register'));?>
<!--注册步骤一 'calendar',End-->
<div class="register" style="" id="reguser_box_user">
<fieldset>
	<legend class="font_yellow"><?php echo $SCLanguages['register'].$SCLanguages['new_user'];?></legend>
<form name="user_info" id="user_info" method="post" action="<?php echo $user_webroot;?>act_register/">

	<dl>
	<dt><?php echo $SCLanguages['member']?><?php echo $SCLanguages['names']?><font color="red">*</font></dt><dd><input name="name" id="name" type="text" />&nbsp;</dd>
	</dl>
    <dl>
	<dt><?php echo $SCLanguages['email']?><font color="red">*</font></dt><dd><input name="email" id="email" type="text" />&nbsp;</dd>
   	</dl>
	<dl>
	<dt><?php echo $SCLanguages['password']?><font color="red">*</font></dt><dd><input name="password" id="password" type="password" />&nbsp;</dd>
	</dl>
	<dl>
	<dt><?php echo $SCLanguages['affirm'].$SCLanguages['password']?><font color="red">*</font></dt><dd><input name="password_confirm" id="password_confirm" type="password" />&nbsp;</dd>
	</dl>
	<dl <?if(isset($SVConfigs['register_captcha']) && $SVConfigs['register_captcha'] == 0){?>style="display:none"<?}?>>
	<dt class="l">&nbsp;&nbsp;&nbsp;&nbsp;</dt>
  <dd><span id="authnum_img_span" style="display:"><a href="javascript:show_login_captcha('register_captcha_page');"><img id="register_captcha_page" name="register_captcha_page" src="<?php echo $user_webroot?>captcha/" /></a></span></dd>
	</dl>
	<dl <?if(isset($SVConfigs['register_captcha']) && $SVConfigs['register_captcha'] == 0){?>style="display:none"<?}?>>
	<dt>&nbsp;&nbsp;&nbsp;&nbsp;</dt><dd><?php echo $SCLanguages['change_img']?></dd>
	</dl>
	<dl <?if(isset($SVConfigs['register_captcha']) && $SVConfigs['register_captcha'] == 0){?>style="display:none"<?}?>>
	<dt><?php echo $SCLanguages['verify_code']?><font color="red">*</font></dt><dd><input type="text"  name="captcha" id="UserCaptcha_page" value="" onfocus="javascript:get_captcha('register_captcha_page');" class="input" /><span>请输入上图显示的验证码（不区分大小写）</span></dd>
	</dl>
	<dl>
	<dt>&nbsp;&nbsp;&nbsp;&nbsp;</dt><dd><input type="checkbox"  name="send_register_email" id="send_register_email" class="checkbox" /><span><?php echo $SCLanguages['send_register_mail']?></span></dd>
	</dl>
	<dl>
	<dt>&nbsp;&nbsp;&nbsp;&nbsp;</dt>
	<dd>
		<input type="hidden" name="no_ajax" value="1"/>
	<span class="float_l" style="text-indent:0;">
		<span class="button float_left"><a href="javascript:document.forms.user_info.submit()"><?php echo $SCLanguages['register']?></a></span>
		</span>
		  <span class="button float_left"><a href="javascript:document.forms.user_info.reset()"><?php echo $SCLanguages['reset']?></a></span>
	</dd>
	</dl>	
</form>
</fieldset>
</div>
<!--注册步骤一 End-->
<script>
var name_null = name_can_not_be_blank;
var pwd_null = password_can_not_be_blank;
var confirm_pwd_null = retype_password_not_blank;
var pwd_shot = password_length_short;
var pwd_cfm_error = Passwords_are_not_consistent;
var email_null = email_not_empity;
var email_error = incorrect_email_format;
var question_null = choose_security_answer;
var answer_null = fill_answer;
var mobile_error = length_of_cell_phone_not_correct;
var utel_error = length_of_tel_not_correct;
</script>
<script>
function show_other_question(Obj){
    if(Obj.value == others){
		  document.getElementById('other_span').style.display="block";
	 }else{
	 	 document.getElementById('other_span').style.display="none";
	}
}
</script>