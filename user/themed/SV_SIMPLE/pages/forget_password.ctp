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
 * $Id: forget_password.ctp 1099 2009-04-28 05:51:30Z shenyunfeng $
*****************************************************************************/
?>
  <div id="container">
  <!--header-->
    <!--headerEnd-->
<div class="Balance_alltitle"><span><?php echo $SCLanguages['retrieve_password'];?></span></div>
<div id="reguser_box" style="border:1px solid #909592;margin-top:0;width:892px;">
<div id="reguser_gut01" style=" background:#fff;width:892px;">

<?php echo $form->create('pages',array('action'=>'need_user_question','name'=>'need_user_question','type'=>'POST'));?>
<ul id="need_username" style="padding-top:15px;margin-top:0;">
  <li>
    <dd><span id="span_usertype" style="margin-left:36px;"><?php echo $SCLanguages['username']?>：</span></dd>
    <dt><input name="UNickNme" id="UNickNme" type="text" style="width:98%" /></dt>
      <dd class="gray_btn" style="padding-top:0;">
	<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
      <a class="float_l green_8" href="javascript:need_name()">
    	<span id="<?php echo $SCLanguages['confirm']?>" style="width:auto;float:left"><?php echo $SCLanguages['confirm'];?></span>
      </a>    	
    <?php }else{?>
      <a class="float_l green_8" href="javascript:confirm_name()">
    	<span id="<?php echo $SCLanguages['confirm']?>" style="width:auto;float:left"><?php echo $SCLanguages['confirm'];?></span>
      </a>
    <?php }?>
      	  
      </dd> 
      <dd>&nbsp;&nbsp;<?php echo $SCLanguages['please_enter'].$SCLanguages['username'];?><span id="name_msg"></span> </dd>
       </li>
  </ul>
  <div id="Personal_info" style="display:none;">
  <ul style="margin-top:0;">
    <li><b><font color="#FF9000"><?php echo $SCLanguages['please_enter'].$SCLanguages['security_answer']?></font></b></li>
	<li>
	<dd><?php echo $SCLanguages['security_question']?>：</dd>
	<dt><input style="width:98%" name="question" id="question" value="" readonly/></dt></li>
	<li>
	<dd><?php echo $SCLanguages['security_answer']?>：</dd>
	<dt>
	<input style="width:98%" type="text" name="answer" id="answer" size="37" />
	<input type="hidden" name="old_answer" id="old_answer" size="37" />
	<input type="hidden" name="user_id" id="user_id" size="37"/></dt>
	<dd><?php echo $SCLanguages['enter_hint_answer']?><span id="ischkEmail"></span></dd>
    </li>
</ul>
<div class="y_but submits">
<span class="float_l"><input type="submit" name="" value="<?php echo $SCLanguages['confirm']?>" /></span>
<span class="float_l"><input type="reset" name="" value="<?php echo $SCLanguages['cancel']?>" /></span>
</div>
</div>
<?php echo $form->end();?>
<br />
</div>
</div>
</div>
