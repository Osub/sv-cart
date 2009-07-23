<?php 
/*****************************************************************************
 * SV-Cart 找回密码提示
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: change_password.ctp 2485 2009-06-30 11:33:00Z huangbo $
*****************************************************************************/
?>	
		<div class="menber_login">
		<dl><dt>管理员姓名：</dt><dd><p class="confim_locale"><?php echo $operator['Operator']['name']?></p></dd></dl>
		<dl><dt>管理员密码：</dt><dd><input type="password" id="operator_pwd" name="operator_pwd" tabindex="0" /></dd></dl>
		<dl><dt>重复密码：</dt><dd><input type="password" id="operator_pwd_t" name="operator_pwd_t" tabindex="0" /></dd></dl>
		<input type="hidden" id="id" name="id" value="<?php echo $operator['Operator']['id']?>" />
  		<p class="login"><input type="button" value="确定"  onclick="javascript:act_change_password();" /></p>
		</div>