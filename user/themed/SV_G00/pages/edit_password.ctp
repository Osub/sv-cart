<?php
/*****************************************************************************
 * SV-Cart 重置密码
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: edit_password.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
?>

  <!--header-->
    <!--headerEnd-->
    	<!--div class="Balance_alltitle"><span><?=$SCLanguages['reset_password']?></span></div>
        <div id="reguser_box" style="border:1px solid #909592;margin-top:0;width:892px;">
  <div id="reguser_gut01" style=" background:#fff;width:892px;">

<FORM name="form1" method="post" action="" >
<ul id="need_username" >
  <li>
    <span id="span_usertype" style="margin-left:36px;"><?=$SCLanguages['enter_new_password']?>：</span>
    <span><input name="new_password" id="new_password" type="password" size="37" />&nbsp;</span>
        <span id="span_usertype" style="margin-left:36px;"><?=$SCLanguages['reenter_new_password']?>：</span>
    <span><input name="confirm_password" id="confirm_new_password" type="password" size="37" />&nbsp;</span>
    <input name="edit_user_id" id="edit_user_id" type="hidden" size="37" value="<?=$id?>"/>
    <span class="z_c" id="pass_msg"></span> 
       </li>
    <div class="ws_xx"></div>
<div class="y_but submit_btn">
<?=$html->link($html->image('submit_order.gif',array("id"=>$SCLanguages['confirm'])),"javascript:confirm_edit_password();","",false,false);?> &nbsp;
 <input type="reset" name="" value="<?=$SCLanguages['cancel']?>" class="reset" />
</div>
</ul>
</form>
</div>
</div>
</div-->
	 <!--0000000000-->
	   <div id="container">
  <!--header-->
    <!--headerEnd-->
<div class="Balance_alltitle"><span><?=$SCLanguages['retrieve_password'];?></span></div>
<div id="reguser_box" style="border:1px solid #909592;margin-top:0;width:892px;">
<div id="reguser_gut01" style=" background:#fff;width:892px;">

<FORM name="form1" method="post" action="" >
<input name="edit_user_id" id="edit_user_id" type="hidden" size="37" value="<?=$id?>"/>

<ul id="need_username" style="padding-top:15px;margin-top:0;">
  <li>
    <dd><span id="span_usertype" style="margin-left:36px;"><?=$SCLanguages['enter_new_password']?>：</span></dd>
    <dt><input name="new_password" id="new_password" type="password" size="37" /></dt>
        <dd><span id="span_usertype" style="margin-left:36px;"><?=$SCLanguages['reenter_new_password']?>：</span></dd>
    <dt><input name="confirm_password" id="confirm_new_password" type="password" size="37" /></dt>
      <dd class="gray_btn" style="padding-top:0;">
      <a class="float_l green_8" href="javascript:confirm_edit_password();"><span id="<?=$SCLanguages['confirm']?>" style="width:auto;float:left"><?=$SCLanguages['confirm']?></span></a>
      </dd> 
       </li>
  </ul>
</form>
<br />
</div>
</div>
</div>