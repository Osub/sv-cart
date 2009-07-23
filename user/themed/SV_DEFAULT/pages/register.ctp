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
 * $Id: register.ctp 3233 2009-07-22 11:41:02Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<script type="text/javascript">
	var page_password_can_not_empty = "<?php echo $SCLanguages['password'].$SCLanguages['can_not_empty'];?>";
	var page_password_length_short = "<?php echo $SCLanguages['password_length_short'];?>";
	var page_Passwords_are_not_consistent = "<?php echo $SCLanguages['Passwords_are_not_consistent'];?>";
	var wait_message = "<?php echo $SCLanguages['wait_for_operation'];?>";
</script>
<?php echo $javascript->link(array('calendar','register'));?>
<!--注册步骤一 End-->
<div id="reguser_box_user" style="position:absolute;visibility:hidden;">
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'reg_top.gif':'reg_top.gif')?></p>
<div id="reguser_gut01">
<div id="reguser_gut01_01">
<ul class="reg_flow">
	<li class="first"><?php echo $SCLanguages['registration_steps']?>：</li>
    <li class="over"><span>1.<?php echo $SCLanguages['fill_out_information']?></span></li>
    <li><font face="宋体">>></font></li>
    <li class="normal"><span>2.<?php echo $SCLanguages['received_mail']?></span></li>
    <li><font face="宋体">>></font></li>
    <li class="normal"><span>3.<?php echo $SCLanguages['register'].$SCLanguages['successfully']?></span></li></div>
<form name="user_info" id="user_info" method="post" action="<?php echo $user_webroot;?>act_register/">
<ul>
  <li>
    <dd class="l"><?php echo $SCLanguages['member']?><?php echo $SCLanguages['names']?>：</dd>
    <dt><input name="name" id="name" type="text" class="input" />&nbsp;
    <span id="name_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>
    <font color="red">*</font></dt>
    <dd id="name_msg"><?php echo $SCLanguages['3_20_characters']?>。 </dd>
    </li>
  <li>
  <dd class="l"><?php echo $SCLanguages['password']?>：</dd>
  <dt><input name="password" id="password" type="password" class="input" />&nbsp;
  <span id="password_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>
 	<font color="red">*</font></dt>
  <dd><span id="password_msg"><?php echo $SCLanguages['password_is_consist']?>。</span><span id="span_unick" class="z_c"></span></dd>
  </li>
  <li>
    <dd class="l"><?php echo $SCLanguages['affirm'].$SCLanguages['password']?>：</dd>
    <dt><input name="password_confirm" id="password_confirm" type="password" class="input" />&nbsp;
  <span id="password_confirm_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>
      <font color="red">*</font></dt>
    <dd id="password_confirm_msg"><?php echo $SCLanguages['type_again_password']?>。</dd>
  </li>
  <li>
    <dd class="l"><?php echo $SCLanguages['email']?>：</dd>
    <dt><input name="email" id="email" class="input" />&nbsp;
 	 <span id="email_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>
      <font color="red">*</font></dt>  
    <dd id="email_msg"><?php echo $SCLanguages['please_enter'].$SCLanguages['email']?>。</dd>
  </li>

  <li>
  <dd class="l"><?php echo $SCLanguages['security_question']?>：</dd>
  <dt>
    <select id="question" name="question" onchange="show_other_question(this)">
      
      <?php if(isset($register_question) && sizeof($register_question)>0){?>
      <?php foreach($register_question as $k=>$v){?>
      	  
      	 <?php if(isset($v['Config']['options_value']) && sizeof($v['Config']['options_value'])>0){?>
         <?php foreach($v['Config']['options_value'] as $key=>$val){?>
         	<?php if($key == 0){?>
            <option value="<?php echo $val;?>" selected="selected"><?php echo $val;?></option>
         	<?php }else{?>
            <option value="<?php echo $val;?>" ><?php echo $val;?></option>
            <?php }?>
            <?php }?>
         <?php }?>
         		
      <?php }?>
      <?php }?>
      	  
      <option value="<?php echo $SCLanguages['others']?>"><?php echo $SCLanguages['others']?></option>
    </select> 	 <span id="question_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>

  <font color="red">*</font></dt>
  <dd id="question_msg"><?php echo $SCLanguages['please_choose'].$SCLanguages['security_question']?></dd>
  </li>
  
  <li style="display:none" id="other_span">
      <dd class="l"><?php echo $SCLanguages['please_enter'].$SCLanguages['security_question']?>：</dd>
      <dt><input name="other_question" id="other_question" class="input" />&nbsp;
  <span id="other_question_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>
      <font color="red">*</font>
      <dd><span id="other_question_msg"></span></dd>
      </dt>
  </li>
  
  <li>
  <dd class="l"><?php echo $SCLanguages['security_answer']?>：</dd>
  <dt><input type="text" name="answer" id="answer" class="input" />&nbsp;
  <span id="answer_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>
  	  <font color="red">*</font></dt>
  <dd><span id="answer_msg"><?php echo $SCLanguages['enter_hint_answer']?>。</span> <span id="ischkEmail"></span></dd>
  </li>
  	  
  	 
  <li <?if(isset($SVConfigs['register_captcha']) && $SVConfigs['register_captcha'] == 0){?>style="display:none"<?}?>>
  <dd class="l"><?php echo $SCLanguages['verify_code']?>：</dd>
  <dt><input type="text"  name="captcha" id="UserCaptcha_page" value="<?php echo $SCLanguages['obtain_verification_code']?>" onfocus="javascript:get_captcha('register_captcha_page');" class="input" />&nbsp;
 <font color="red">*</font></dt>
  <dd>
     <span id="authnum_img_span" style="display:none"><a href="javascript:show_login_captcha('register_captcha_page');"><img id="register_captcha_page"  /></a></span>
  </dd>
  </li>  	  
  	  
  	 
  	  
  	  
  	  
  	  
  <li class="sorty"><a id="Select_info">
  <span onclick="javascript:Personal('Personal_info','Select_info')"><b><?php echo $SCLanguages['optional_information']?></b></span>
  </a></li>
  </ul>
  <ul style="height:0;line-height:0;overflow:hidden;" id="Personal_info">
  <li>
  <dd class="l"><?php echo $SCLanguages['region']?>：</dd>
  <dt><span id="regions"></span><span id="region_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span></dt>
	<script type="text/javascript">show_regions("");</script>
	</li>
  <li>
    <dd class="l"><?php echo $SCLanguages['address']?>：</dd>
    <dt><input name="address" id="address" type="text" class="input" /></dt>
    <dd id='address_msg'><?php echo $SCLanguages['please_enter'].$SCLanguages['valid'].$SCLanguages['address']?></dd></li>
  <li>
    <dd class="l"><?php echo $SCLanguages['mobile']?>：</dd>
    <dt><input type="mobile" name="mobile" id="mobile" onKeyUp="is_int(this);" class="input" /></dt> 
    <dd><span id="mobile_msg"><?php echo $SCLanguages['please_enter'].$SCLanguages['valid'].$SCLanguages['contact_information']?></span></dd></li>
  <li>
    <dd class="l"><?php echo $SCLanguages['telephone']?>：</dd>
    <dt><input type="text" name="user_tel0" id="user_tel0" onKeyUp="is_int(this);" style='margin-right:3px' class="input" /></dt>
    <dd id='Utel_msg' ><?php echo $SCLanguages['please_enter'].$SCLanguages['telephone'].$SCLanguages['zone_telephone_extension']?></dd></li>     
  <li>
    <dd class="l"><?php echo $SCLanguages['gender']?>：</dd>
    <dt><select id="prov" name="prov">
            <option value="0"><?php echo $SCLanguages['confidence']?></option>
            <option value="1"><?php echo $SCLanguages['male']?></option><option value="2"><?php echo $SCLanguages['female']?></option>
        </select></dt>
         <dd> <?php echo $SCLanguages['please_choose'].$SCLanguages['gender']?></dd></li>
      <li>
        <dd class="l"><?php echo $SCLanguages['birthday']?>：</dd>
        <dt class="datefield"><label id="show"><span class="input_main"><input readonly type="text" id="date" name="date" value="" class="input" /></span><button class="calendar" type="button" title="Show Calendar"><?php echo $html->image('calendar.png',array('alt'=>'calendar'))?></button></label></dt>
        </li>

        <?php if(isset($user_infoarr) && sizeof($user_infoarr)>0){?>
            <?php foreach($user_infoarr as $k=>$v){?>
            <?php if($v['UserInfo']['front'] == 1){?>
              <li>
                  <dd class="l"><?php echo $v['UserInfo']['name']?>：
                  </dd>
                  <dt>
                  <?php if($v['UserInfo']['type'] == "text"){?>
                  <input type="text" class="text_inputs" style="width:265px;" name="info_value[<?php echo $v['UserInfo']['id']?>]" class="input" />
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
			<?php }?>
                  </dt>
                  </li>
            <?php }}?>
        <?php }?>
</ul>
<div class="big_buttons">
<p style="padding-left:227px;margin-bottom:15px;">
		  <span class="float_l" style="text-indent:0;"><input id="button" onfocus="blur()" name="Submit" value="<?php echo $SCLanguages['register']?>"  onclick="javascript:check_user_info();" type="button"></span>
		  <span class="float_l" style="text-indent:0;margin-left:4px;"><input onfocus="blur()" id="Reset" value="<?php echo $SCLanguages['reset']?>" onclick="javascript:document.forms.user_info.reset();" type="button"></span>
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
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'Agreement_top.gif':'Agreement_top.gif',array("align"=>"absbottom"))?>
  <div id="reguser_gut01" class="Agreement_box">
<div id="Title"><b><?php echo $SCLanguages['user'].$SCLanguages['register'].$SCLanguages['agreement']?></b></div>
    <div class="Agreement">
     <div class="text"><span class='green_3'><?php echo $article['ArticleI18n']['content']?></span></div>
	</div>

<div class="Agreement_btn big_buttons" style="padding-bottom:5px;">
	<p style="padding-left:412px;margin-top:30px;">
		  <span class="float_l"><input onfocus="blur()" id="agreement" value="<?php echo $SCLanguages['agree']?>" onclick="javascript:agreement();" type="button"></span>
	</p>
</div>
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'Agreement_img.gif':'Agreement_img.gif')?></p>
</div>
<!--协议条款 End-->
<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>
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