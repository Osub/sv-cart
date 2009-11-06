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
 * $Id: register.ctp 4578 2009-09-25 10:21:49Z huangbo $
*****************************************************************************/
?>
	<cake:nocache>
<?php
	if($session->check('User.User.name')){
		header("Location:".$this->webroot);
	}
?>
	</cake:nocache>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<script type="text/javascript">
	var page_password_can_not_empty = "<?php echo $this->data['languages']['password'].$this->data['languages']['can_not_empty'];?>";
	var page_password_length_short = "<?php echo $this->data['languages']['password_length_short'];?>";
	var page_Passwords_are_not_consistent = "<?php echo $this->data['languages']['Passwords_are_not_consistent'];?>";
	var wait_message = "<?php echo $this->data['languages']['wait_for_operation'];?>";
</script>
<?php echo $javascript->link(array('calendar','register'));?>
<!--注册步骤一 End-->
<div class="reguser_box_user" id="reguser_box_user" style="position:absolute;visibility:hidden;">
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'reg_top.gif':'reg_top.gif')?></p>
<div class="reguser_gut01">
<div class="reguser_gut01_01">
<ul class="reg_flow">
	<li class="first"><?php echo $this->data['languages']['registration_steps']?>：</li>
    <li class="over"><span>1.<?php echo $this->data['languages']['fill_out_information']?></span></li>
    <li><font face="宋体">>></font></li>
    <li class="normal"><span>2.<?php echo $this->data['languages']['received_mail']?></span></li>
    <li><font face="宋体">>></font></li>
    <li class="normal"><span>3.<?php echo $this->data['languages']['register'].$this->data['languages']['successfully']?></span></li>
</ul>
</div>
<form name="user_info" id="user_info" method="post" action="<?php echo $user_webroot;?>act_register/">
<ul>
  <li><dl><dd class="l"><?php echo $this->data['languages']['member']?><?php echo $this->data['languages']['names']?>：</dd><dt><input name="name" id="name" type="text" class="input" />&nbsp;<span id="name_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span><font color="red">*</font></dt><dd id="name_msg"><?php echo $this->data['languages']['3_20_characters']?>。</dd></dl></li>
  <li><dl><dd class="l"><?php echo $this->data['languages']['password']?>：</dd><dt><input name="password" id="password" type="password" class="input" />&nbsp;<span id="password_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span><font color="red">*</font></dt><dd><span id="password_msg"><?php echo $this->data['languages']['password_is_consist']?>。</span><span id="span_unick" class="z_c"></span></dd></dl></li>
  <li><dl><dd class="l"><?php echo $this->data['languages']['affirm'].$this->data['languages']['password']?>：</dd><dt><input name="password_confirm" id="password_confirm" type="password" class="input" />&nbsp;<span id="password_confirm_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span><font color="red">*</font></dt><dd id="password_confirm_msg"><?php echo $this->data['languages']['type_again_password']?>。</dd></dl></li>
  <li><dl><dd class="l"><?php echo $this->data['languages']['email']?>：</dd><dt><input name="email" id="email" class="input" />&nbsp;<span id="email_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span><font color="red">*</font></dt><dd id="email_msg"><?php echo $this->data['languages']['please_enter'].$this->data['languages']['email']?>。</dd></dl></li>

  <li><dl><dd class="l"><?php echo $this->data['languages']['security_question']?>：</dd>
  	  <dt><select id="question" name="question" onchange="show_other_question(this)">
      <?php if(isset($information_info['register_question']) && sizeof($information_info['register_question'])>0){?>
      		<?php foreach($information_info['register_question'] as $key=>$val){?>
	         	<?php if($key > 0){?>
		         	<?php if($key == 0){?>
		            <option value="<?php echo $val;?>" selected="selected"><?php echo $val;?></option>
		         	<?php }else{?>
		            <option value="<?php echo $val;?>" ><?php echo $val;?></option>
		            <?php }?>
	            <?php }?>
      		<?php }?>
      <?php }?>
      <option value="<?php echo $this->data['languages']['others']?>"><?php echo $this->data['languages']['others']?></option>
    </select><span id="question_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span><font color="red">*</font></dt><dd id="question_msg"><?php echo $this->data['languages']['please_choose'].$this->data['languages']['security_question']?></dd></dl></li>
  
  <li style="display:none" id="other_span"><dl><dd class="l"><?php echo $this->data['languages']['please_enter'].$this->data['languages']['security_question']?>：</dd><dt><input name="other_question" id="other_question" class="input" />&nbsp;<span id="other_question_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span><font color="red">*</font><span id="other_question_msg"></span></dt></dl></li>
  
  <li><dl><dd class="l"><?php echo $this->data['languages']['security_answer']?>：</dd><dt><input type="text" name="answer" id="answer" class="input" />&nbsp;<span id="answer_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span><font color="red">*</font></dt><dd><span id="answer_msg"><?php echo $this->data['languages']['enter_hint_answer']?>。</span> <span id="ischkEmail"></span></dd></dl></li>

  <li <?if(isset($SVConfigs['register_captcha']) && $SVConfigs['register_captcha'] == 0){?>style="display:none"<?}?>><dl><dd class="l"><?php echo $this->data['languages']['verify_code']?>：</dd><dt><input type="text"  name="captcha" id="UserCaptcha_page" style="width:75px;" value="<?php echo $this->data['languages']['obtain_verification_code']?>" onfocus="javascript:get_captcha('register_captcha_page');" class="input" />&nbsp;<font color="red">*</font></dt><dd><span id="authnum_img_span" style="display:none"><a href="javascript:show_login_captcha('register_captcha_page');"><img id="register_captcha_page" src="" alt="" /></a></span></dd></dl></li>  	  
  <li class="sorty"><a id="Select_info"><span onclick="javascript:Personal('Personal_info','Select_info')"><b><?php echo $this->data['languages']['optional_information']?></b></span></a></li>
  </ul>
  <ul style="height:0;line-height:0;overflow:hidden;" id="Personal_info">
  <li><dl><dd class="l"><?php echo $this->data['languages']['region']?>：</dd><dt><span id="regions"></span><span id="region_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span></dt></dl><script type="text/javascript">show_regions("");</script></li>
  <li><dl><dd class="l"><?php echo $this->data['languages']['address']?>：</dd><dt><input name="address" id="address" type="text" class="input" /></dt><dd id='address_msg'><?php echo $this->data['languages']['please_enter'].$this->data['languages']['valid'].$this->data['languages']['address']?></dd></dl></li>
  <li><dl><dd class="l"><?php echo $this->data['languages']['mobile']?>：</dd><dt><input type="text" name="mobile" id="mobile" onkeyup="is_int(this);" class="input" /></dt> <dd><span id="mobile_msg"><?php echo $this->data['languages']['please_enter'].$this->data['languages']['valid'].$this->data['languages']['contact_information']?></span></dd></dl></li>
  <li><dl><dd class="l"><?php echo $this->data['languages']['telephone']?>：</dd><dt><input type="text" name="user_tel0" id="user_tel0" onkeyup="is_int(this);" style='margin-right:3px' class="input" /></dt><dd id='Utel_msg' ><?php echo $this->data['languages']['please_enter'].$this->data['languages']['telephone'].$this->data['languages']['zone_telephone_extension']?></dd></dl></li>     
  
  <li><dl><dd class="l"><?php echo $this->data['languages']['gender']?>：</dd><dt><select id="prov" name="prov"><option value="0"><?php echo $this->data['languages']['confidence']?></option><option value="1"><?php echo $this->data['languages']['male']?></option><option value="2"><?php echo $this->data['languages']['female']?></option></select></dt><dd> <?php echo $this->data['languages']['please_choose'].$this->data['languages']['gender']?></dd></dl></li>
  <li><dl><dd class="l"><?php echo $this->data['languages']['birthday']?>：</dd><dt class="datefield"><label id="show"><span class="input_main"><input readonly="readonly" type="text" id="date" name="date" value="" class="input" /></span><button class="calendar" type="button" title="Show Calendar"><?php echo $html->image('calendar.png',array('alt'=>'calendar'))?></button></label></dt></dl></li>

        <?php if(isset($user_infoarr) && sizeof($user_infoarr)>0){?>
            <?php foreach($user_infoarr as $k=>$v){?>
            <?php if($v['UserInfo']['front'] == 1){?>
              <li><dl><dd class="l"><?php echo $v['UserInfo']['name']?>：</dd>
                  <dt>
                  <?php if($v['UserInfo']['type'] == "text"){?>
                  <input type="text" style="width:265px;" name="info_value[<?php echo $v['UserInfo']['id']?>]" class="input" />
                  <?php }?>
				 <?php if($v['UserInfo']['type'] == 'select'){?>
				 <select   name="info_value[<?php echo $v['UserInfo']['id']?>]"/>
				 <?php if(isset($v['UserInfo']['user_info_values']) && !empty($v['UserInfo']['user_info_values'])){
				 $options = explode(';',$v['UserInfo']['user_info_values']);
				 foreach($options as $option){
				 $text =explode(":",$option);
				 ?>
				 <option value="<?php echo $text[0];?>" <?php if(isset($v['value']['value']) && $text[0]==$v['value']['value']) echo 'selected';?>>
				 <?php if(@$text[1]){ echo $text[1];} ?>
				 </option>
				 <?php }} ?></select>
				 <?php }?>                  	  
                 <?php if($v['UserInfo']['type'] == 'radio'){?>
				 <?php if(isset($v['UserInfo']['user_info_values'])){
				 	$options = explode(';',$v['UserInfo']['user_info_values']);
				 	 $times = sizeof($options);?>
				 	 <?php foreach($options as $kk=>$option){
				 	$text =explode(":",$option); 
				 if(@$text[1]!=""){?>
				 <label><input type="radio" style="width:auto;border:none ;" name="info_value[<?php echo $v['UserInfo']['id']?>]" value="<?php echo $text[0];?>" <?php if(isset($v['value']['value']) && @$text[0]==$v['value']['value']) echo 'checked';?> /><?php if(@$text[1]){ echo $text[1];}?></label>
				 <?php }}?>		
				<?php }}?>
				<?php if($v['UserInfo']['type'] == 'checkbox'){?>
			 <?php if(isset($v['UserInfo']['user_info_values'])&&!empty($v['UserInfo']['user_info_values'])){
			 	 if(isset($v['value']['value'])){
			 	 	$checkoptions = explode(';',$v['value']['value']);
			 	 }
			 	 $options = explode(';',$v['UserInfo']['user_info_values']);
			 	 $times = sizeof($options);?>
			 	 <?php foreach($options as $kkk=>$option){
			 	 $text =explode(":",$option);if(@$text[1]!=""){?>
			 <label><input type="checkbox" style="width:10px" name="info_value[<?php echo $v['UserInfo']['id']?>][<?php echo $kkk?>]" value="<?php echo $text[0];?>" <?php if(isset($checkoptions) && in_array($text[0],$checkoptions)) echo 'checked';?>/><?php if(@$text[1]){ echo $text[1];}?></label>
			 <?php } ?><?php }}?>
			<?php }?>
			<?php if($v['UserInfo']['type'] == 'textarea'){?>
			<textarea  name="info_value[<?php echo $v['UserInfo']['id']?>]"><?php if(isset($v['value']['value']))echo $v['value']['value']; ?></textarea>
			<?php }?></dt></dl></li>
            <?php }}?>
        <?php }?>
</ul>
<div class="big_buttons">
<p style="padding-left:227px;margin-bottom:15px;">
		  <span class="float_l" style="text-indent:0;"><input id="button" onfocus="blur()" name="Submit" value="<?php echo $this->data['languages']['register']?>"  onclick="javascript:check_user_info();" type="button"/></span>
		  <span class="float_l" style="text-indent:0;margin-left:4px;"><input onfocus="blur()" id="Reset" value="<?php echo $this->data['languages']['reset']?>" onclick="javascript:document.forms.user_info.reset();" type="button"/></span>
</p>
</div>
</form>
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'bottom.gif':'bottom.gif',array())?></p>
</div>
<!--注册步骤一 End-->
<?php echo $this->element('calendar', array('cache'=>'+0 hour'));?>
<!--协议条款-->
<div id="reguser_box">
<p style="margin:0;padding:0;text-indent:0;"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'Agreement_top.gif':'Agreement_top.gif',array())?></p>
  <div class="reguser_gut01 Agreement_box">
<div id="Title"><b><?php echo $this->data['languages']['user'].$this->data['languages']['register'].$this->data['languages']['agreement']?></b></div>
    <div class="Agreement">
     <div class="text green_3"><?php echo $article['ArticleI18n']['content']?></div>
	</div>

<div class="Agreement_btn big_buttons" style="padding-bottom:5px;">
	<p style="padding-left:412px;margin-top:30px;">
		  <span class="float_l"><input onfocus="blur()" id="agreement" value="<?php echo $this->data['languages']['agree']?>" onclick="javascript:agreement();" type="button"/></span>
	</p>
</div>
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'Agreement_img.gif':'Agreement_img.gif')?></p>
</div>
<!--协议条款 End-->
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
	<!-- 不加第二个日历 页面上会多一个表格 -->
	<div style="display:none;"> 
	<button class="calendar" id="show2" title="Show Calendar">
       		<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'calendar.png':'calendar.png',array('width'=>'18' ,'height'=>'18' ,'alt'=>'Calendar'))?>
    </button>
     </div>	
	
<script type="text/javscript">
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
<script type="text/javscript">
function show_other_question(Obj){
    if(Obj.value == others){
		  document.getElementById('other_span').style.display="block";
	 }else{
	 	 document.getElementById('other_span').style.display="none";
	}
}
</script>