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
 * $Id: login.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
?>
		<div class="menber_login">
		
<?php echo $form->create('',array('name'=>'login_form','action'=>'act_login'));?>
		<dl><dt>管理员姓名：</dt><dd><input type="text" name="operator" id="operator_id" tabindex="0" /></dd></dl>
		<dl><dt>管理员密码：</dt><dd><input type="password" name="operator_pwd" id="operator_pwd" tabindex="0" /></dd></dl>
		<dl><dt>语言选择：</dt><dd>
		<?if(isset($locales) && count($locales)>1){?>
		<select name="locale"  id="locale" style="border:1px solid #78828D">
		<?foreach($locales as $locale){?>
			<option value="<?=$locale['Language']['locale']?>"><?=$locale['Language']['name']?></option>
		<?}?>
		</select>
		<?}else{?>
			<p class="confim_locale"><?=$locales[0]['Language']['name']?></p>
			<input type="hidden" name="locale" id="locale" value="<?=$locales[0]['Language']['locale']?>"/>
		<?}?>	
		</dd></dl>
        <dl class="validate"><dt>验证码：</dt>
		   <dd><input type="text" name="authnum" id="authnum" class="Price" /></dd>
		   <dd class="captcha"><?=$html->link($html->image('/authnums/get_authnums/',array('align'=>'absmiddle','id'=>"authnum_img")),"javascript:show_login_captcha()",'',false,false);?></dd>
	   </dl>
		<p class="save_cookie"><label for="cookie"><input id="cookie" type="checkbox" name="radiobutton" value="radiobutton" tabindex="0" />保存这次登录信息</label></p>
		<p class="login"><input onfocus="blur()" type="button" onclick="javascript:check();" value="进入管理中心" /></p>
		<p class="forget_password">
		<?=$html->image('icon-right.gif',array('align'=>'absmiddle'))?>
		<span><?=$html->link("您忘记了密码吗?","javascript:forget_password();",'',false,false);?></span></p>
<? echo $form->end();?>
		</div>
