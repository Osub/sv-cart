<?php 
/*****************************************************************************
 * SV-Cart  后台登录
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: login.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
?>
<div class="menber_login">
<?php echo $form->create('',array('name'=>'login_form','action'=>'act_login'));?>
		<dl><dt>管理员姓名：</dt><dd><input type="text" name="operator" id="operator_id" tabindex="0" /></dd></dl>
		<dl><dt>管理员密码：</dt><dd><input type="password" name="operator_pwd" id="operator_pwd" tabindex="0" /></dd></dl>
		<dl><dt>语言选择：</dt><dd>
		<?php if(isset($locales) && count($locales)>1){?>
		<select name="locale"  id="locale" style="border:1px solid #78828D">
		<?php foreach($locales as $locale){?>
			<option value="<?php echo $locale['Language']['locale']?>"><?php echo $locale['Language']['name']?></option>
		<?php }?>
		</select>
		<?php }else{?>
			<p class="confim_locale"><?php echo $locales[0]['Language']['name']?></p>
			<input type="hidden" name="locale" id="locale" value="<?php echo $locales[0]['Language']['locale']?>"/>
		<?php }?>	
		</dd></dl>
        <dl class="validate" <?if($SVConfigs['admin_captcha'] == 0){?>style="display:none"<?}?>><dt>验证码：</dt>
		   <dd><input type="text" name="authnum" id="authnum" class="Price" value="点击获取验证码" onfocus="javascript:show_login_captcha();" /></dd>
		   <dd class="captcha">
		    <span id="authnum_img_span" style="display:none">
		    <a href='javascript:change_captcha();'><img id='authnum_img' align='absmiddle' /></a>
		    </span>
		    </dd>
	   </dl>
		<p class="save_cookie"><label for="cookie"><input id="cookie" type="checkbox" name="radiobutton" value="radiobutton" tabindex="0" />保存这次登录信息</label></p>
		<p class="login"><input onfocus="blur()" type="button" onclick="javascript:ajax_login_check();" value="进入管理中心" /></p>
		<p class="forget_password">
		<?php echo $html->image('icon-right.gif',array('align'=>'absmiddle'))?>
		<span><?php echo $html->link("您忘记了密码吗?","javascript:forget_password();",'',false,false);?></span></p>
<?php echo $form->end();?>
</div>
<script type="text/javascript">
//show_login_captcha();
	document.onkeydown = function(evt){
		var evt = window.event?window.event:evt;
		if(evt.keyCode==13)
		{	
			var UserName = document.getElementById('operator_id').value;
			var UserPassword = document.getElementById('operator_pwd').value;
			var UserCaptcha = document.getElementById('authnum').value;
			if(UserName != "" && UserPassword != "" && UserCaptcha != ""){
				ajax_login_check();
			}
		}
	}
</script>