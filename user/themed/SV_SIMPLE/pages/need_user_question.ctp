<?php 
/*****************************************************************************
 * SV-Cart 用户密码保护问题
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: need_user_question.ctp 724 2009-04-17 07:59:41Z shenyunfeng $
*****************************************************************************/
if(!isset($SVConfigs['use_ajax']) || $SVConfigs['use_ajax'] == 1){
ob_start();
if($err != 0){
	$result['err_msg'] = $err_msg;
}
if($question != ''){
	$result['question'] = $question;
}
if($old_answer != ''){
	$result['old_answer'] = $old_answer;
}
if($user_id != ''){
	$result['user_id'] = $user_id;
}
$result['err'] = $err;
echo json_encode($result);
}else{
?>
  <div id="container">
  <!--header-->
    <!--headerEnd-->
<div class="Balance_alltitle"><span><?php echo $SCLanguages['retrieve_password'];?></span></div>
<div id="reguser_box" style="border:1px solid #909592;margin-top:0;width:892px;">
<div id="reguser_gut01" style=" background:#fff;width:892px;" style="display:none;">
<?php echo $form->create('pages',array('action'=>'send_editpsw_email','name'=>'send_editpsw_email','type'=>'POST'));?>
  <div id="Personal_info" >
  <ul style="margin-top:0;">
    <li><b><font color="#FF9000"><?php echo $SCLanguages['please_enter'].$SCLanguages['security_answer']?></font></b></li>
	<li>
	<dd><?php echo $SCLanguages['security_question']?>：</dd>
	<dt><input style="width:98%" name="question" id="question" value="<?php if(isset($question)){echo $question;}?>" readonly/></dt></li>
	<li>
	<dd><?php echo $SCLanguages['security_answer']?>：</dd>
	<dt>
	<input style="width:98%" type="text" name="answer" id="answer" size="37" />
	<input type="hidden" name="old_answer" id="old_answer" size="37" value="<?php if(isset($old_answer)){echo $old_answer;}?>"/>
	<input type="hidden" name="user_id" id="user_id" size="37" value="<?php if(isset($user_id)){echo $user_id;}?>" /></dt>
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


<?php }?>