<?php 
/*****************************************************************************
 * SV-Cart 忘记密码
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: forget_password.ctp 4366 2009-09-18 09:49:37Z huangbo $
*****************************************************************************/
?>
<div id="container">
  <!--header-->
    <!--headerEnd-->
<div class="Balance_alltitle"><h1 class="headers"><span class="l"></span><span class="r"></span><?php echo $SCLanguages['retrieve_password'];?></h1>
</div>
<div id="reguser_box" style="border:1px solid #909592;margin-top:0;width:892px;">
<div id="reguser_gut01" style="background:#fff;width:892px;">
<br />
<form name="form1" method="post" action= "<?php echo $user_webroot?>pages/send_editpsw_email" onsubmit="check_answer()">
<ul id="need_username" style="padding-top:15px;margin-top:0;">
	<li><dl><dd style="padding-top:3px;"><span id="span_usertype" style="margin-left:36px;"><?php echo $SCLanguages['username']?>：</span></dd><dt style="padding-top:1px;"><input name="UNickNme" id="UNickNme" type="text" style="width:98%" /></dt><dd class="btn_list" style="padding:0 0 0 4px;"><a class="float_l green_8" href="javascript:confirm_name()"><span id="<?php echo $SCLanguages['confirm']?>" style="width:auto;float:left"><?php echo $SCLanguages['confirm'];?></span></a></dd><dd style="padding-top:3px;">&nbsp;&nbsp;<?php echo $SCLanguages['please_enter'].$SCLanguages['username'];?><span id="name_msg"></span> </dd></dl></li>
 </ul>
  <div id="Personal_info" style="display:none;">
  <ul style="margin-top:0;">
    <li><b><font color="#FF9000" style="margin-left:36px;"><?php echo $SCLanguages['please_enter'].$SCLanguages['security_answer']?></font></b></li>
	<li>
	<dd><font style="margin-left:36px;"><?php echo $SCLanguages['security_question']?>：</font></dd>
	<dt><input style="width:98%" name="question" id="question" readonly/>&nbsp;</dt></li>
	<li>
	<dd><font style="margin-left:36px;"><?php echo $SCLanguages['security_answer']?>：</font></dd>
	<dt>
	<input style="width:98%" type="text" name="answer" id="answer" size="37" />
	<input type="hidden" name="old_answer" id="old_answer" size="37" />
	<input type="hidden" name="user_id" id="user_id" size="37"/></dt>
	<dd><?//php echo $SCLanguages['enter_hint_answer']?><span id="ischkEmail"></span></dd>
    </li>
</ul>
<div class="y_but submits">
<span class="float_l"><input type="submit" name="" value="<?php echo $SCLanguages['confirm']?>" /></span>
<span class="float_l"><input type="reset" name="" value="<?php echo $SCLanguages['cancel']?>" /></span>
</div>
</div>
</form>
<br />
<br /><br />
</div>
</div>
</div>