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
 * $Id: register.ctp 1140 2009-04-29 09:39:40Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('/../js/yui/button-min.js');?> 
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<?=$javascript->link('register');?>
<!--注册步骤一 End-->
<div id="reguser_box_user" style="position:absolute;visibility:hidden;">
<p><?=$html->image('reg_top.gif')?></p>
<div id="reguser_gut01">
<div id="reguser_gut01_01">
<ul class="reg_flow">
	<li class="first"><?=$SCLanguages['registration_steps']?>：</li>
    <li class="over"><span>1.<?=$SCLanguages['fill_out_information']?></span></li>
    <li><font face="宋体">>></font></li>
    <li class="normal"><span>2.<?=$SCLanguages['received_mail']?></span></li>
    <li><font face="宋体">>></font></li>
    <li class="normal"><span>3.<?=$SCLanguages['register'].$SCLanguages['successfully']?></span></li></div>
<form name="user_info" id="user_info" method="post" action="<?=$this->webroot;?>act_register/">
<ul>
  <li>
    <dd class="l"><?=$SCLanguages['member']?>：</dd>
    <dt><input name="name" id="name" type="text">&nbsp;<font color="red">*</font></dt>
    <dd id="name_msg"><?=$SCLanguages['3_20_characters']?>。 </dd>
    </li>
  <li>
  <dd class="l"><?=$SCLanguages['password']?>：</dd>
  <dt><input name="password" id="password" type="password" />&nbsp;<font color="red">*</font></dt>
  <dd><span id="password_msg"><?=$SCLanguages['password_is_consist']?>。</span><span id="span_unick" class="z_c"></span></dd>
  </li>
  <li>
    <dd class="l"><?=$SCLanguages['affirm'].$SCLanguages['password']?>：</dd>
    <dt><input name="password_confirm" id="password_confirm" type="password" />&nbsp;<font color="red">*</font></dt>
    <dd id="password_confirm_msg"><?=$SCLanguages['type_again_password']?>。</dd>
  </li>
  <li>
    <dd class="l"><?=$SCLanguages['email']?>：</dd>
    <dt><input name="email" id="email" />&nbsp;<font color="red">*</font></dt>  
    <dd id="email_msg"><?=$SCLanguages['please_enter'].$SCLanguages['email']?>。</dd>
  </li>

  <li>
  <dd class="l"><?=$SCLanguages['security_question']?>：</dd>
  <dt>
    <select id="question" name="question" onchange="show_other_question(this)">
      
      <?if(isset($register_question) && sizeof($register_question)>0){?>
      <?foreach($register_question as $k=>$v){?>
      	  
      	 <?if(isset($v['Config']['options_value']) && sizeof($v['Config']['options_value'])>0){?>
         <?foreach($v['Config']['options_value'] as $key=>$val){?>
         	<?if($key == 0){?>
            <option value="<?echo $val;?>" selected="selected"><?echo $val;?></option>
         	<?}else{?>
            <option value="<?echo $val;?>" ><?echo $val;?></option>
            <?}?>
            <?}?>
         <?}?>
         		
      <?}?>
      <?}?>
      	  
      <option value="<?=$SCLanguages['others']?>"><?=$SCLanguages['others']?></option>
    </select>
  <font color="red">*</font></dt>
  <dd id="question_msg"><?=$SCLanguages['please_choose'].$SCLanguages['security_question']?></dd>
  </li>
  
  <li style="display:none" id="other_span">
      <dd class="l"><?=$SCLanguages['please_enter'].$SCLanguages['security_question']?>：</dd>
      <dt><input name="other_question" id="other_question"/>&nbsp;<font color="red">*</font>
      <dd><span id="other_question_msg"></span></dd>
      </dt>
  </li>
  
  <li>
  <dd class="l"><?=$SCLanguages['security_answer']?>：</dd>
  <dt><input type="text" name="answer" id="answer" />&nbsp;<font color="red">*</font></dt>
  <dd><span id="answer_msg"><?=$SCLanguages['enter_hint_answer']?>。</span> <span id="ischkEmail"></span></dd>
  </li>
  <li class="sorty"><a id="Select_info">
  <span onclick="javascript:Personal('Personal_info','Select_info')"><b><?=$SCLanguages['optional_information']?></b></span>
  </a></li>
  </ul>
  <ul style="height:0;line-height:0;overflow:hidden;" id="Personal_info">
  <li>
  <dd class="l"><?=$SCLanguages['region']?>：</dd>
  <dt><span id="regions"></span><span id="region_loading" style='display:none'><?=$html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span></dt>
	<?=$javascript->link('regions');?>
	<script type="text/javascript">show_regions("");</script>
	</li>
  <li>
    <dd class="l"><?=$SCLanguages['address']?>：</dd>
    <dt><input name="address" id="address" type="text" /></dt>
    <dd id='address_msg'><?=$SCLanguages['please_enter'].$SCLanguages['valid'].$SCLanguages['address']?></dd></li>
  <li>
    <dd class="l"><?=$SCLanguages['mobile']?>：</dd>
    <dt><input type="mobile" name="mobile" id="mobile" onKeyUp="is_int(this);" /></dt> 
    <dd><span id="mobile_msg"><?=$SCLanguages['please_enter'].$SCLanguages['valid'].$SCLanguages['contact_information']?></span></dd></li>
  <li>
    <dd class="l"><?=$SCLanguages['telephone']?>：</dd>
    <dt><input type="text" name="user_tel0" id="user_tel0" onKeyUp="is_int(this);" style='width:40px;margin-right:3px' />-<input type="text" name="user_tel1" id="user_tel1" size="10" onKeyUp="is_int(this);" style='margin:0 3px;width:100px' />-<input type="text" name="user_tel2" id="user_tel2" maxLength="30"  onKeyUp="is_int(this);" style='width:40px;margin-left:3px' /></dt>
    <dd id='Utel_msg' ><?=$SCLanguages['please_enter'].$SCLanguages['telephone'].$SCLanguages['zone_telephone_extension']?></dd></li>     
  <li>
    <dd class="l"><?=$SCLanguages['gender']?>：</dd>
    <dt><select id="prov" name="prov">
            <option value="0"><?=$SCLanguages['confidence']?></option>
            <option value="1"><?=$SCLanguages['male']?></option><option value="2"><?=$SCLanguages['female']?></option>
        </select></dt>
         <dd> <?=$SCLanguages['please_choose'].$SCLanguages['gender']?></dd></li>
      <li>
        <dd class="l"><?=$SCLanguages['birthday']?>：</dd><dt class="datefield"><label id="show"><span class="input_main"><input readonly type="text" id="date" name="date" value="" /></span><button type="button" title="Show Calendar"><?=$html->image('calendar.png',array('alt'=>'calendar'))?></button></label></dt>
        </li>

        <?if(isset($user_infoarr) && sizeof($user_infoarr)>0){?>
            <?foreach($user_infoarr as $k=>$v){?>
            <?if($v['UserInfo']['front'] == 1){?>
              <li>
                  <dd class="l"><?echo $v['UserInfo']['name']?>：
                  </dd>
                  <dt>
                  <?if($v['UserInfo']['type'] == "text"){?>
                  <input type="text" class="text_inputs" style="width:265px;" name="info_value[<?echo $v['UserInfo']['id']?>]" />
                  <?}?>
				 <?if($v['UserInfo']['type'] == 'select'){?>
				 <select   name="info_value[<?echo $v['UserInfo']['id']?>]"/>
				 <?php if(isset($v['UserInfo']['values']) && !empty($v['UserInfo']['values'])){
				 $options = explode(';',$v['UserInfo']['values']);
				 foreach($options as $option){
				 $text =explode(":",$option);
				 ?>
				 <option value="<?php echo $text[0];?>" <?php if(isset($v['value']['value']) && $text[0]==$v['value']['value']) echo 'selected';?>>
				 <?php if(@$text[1]){ echo $text[1];} ?>
				 </option>
				 <?php }} ?></select>
				 <?}?>                  	  
                 <?if($v['UserInfo']['type'] == 'radio'){?>
				 <?php if(isset($v['UserInfo']['values'])){
				 	$options = explode(';',$v['UserInfo']['values']);
				 	 $times = sizeof($options);?>
				 	 <?foreach($options as $kk=>$option){
				 	$text =explode(":",$option); 
				 if(@$text[1]!=""){?>
				 <label><input type="radio" style="width:10px" name="info_value[<?echo $v['UserInfo']['id']?>]" value="<?php echo $text[0];?>" <?php if(isset($v['value']['value']) && @$text[0]==$v['value']['value']) echo 'checked';?>/><?php if(@$text[1]){ echo $text[1];}?></label>
				 <?php }}?>		
				<?}}?>
				<?if($v['UserInfo']['type'] == 'checkbox'){?>
			 <?php if(isset($v['UserInfo']['values'])&&!empty($v['UserInfo']['values'])){
			 	 if(isset($v['value']['value'])){
			 	 	$checkoptions = explode(';',$v['value']['value']);
			 	 }
			 	 $options = explode(';',$v['UserInfo']['values']);
			 	 $times = sizeof($options);?>
			 	 <?foreach($options as $kkk=>$option){
			 	 $text =explode(":",$option);if(@$text[1]!=""){?>
			 <label><input type="checkbox" style="width:10px" name="info_value[<?echo $v['UserInfo']['id']?>][<?=$kkk?>]" value="<?php echo $text[0];?>" <?php if(isset($checkoptions) && in_array($text[0],$checkoptions)) echo 'checked';?>/><?php if(@$text[1]){ echo $text[1];}?></label>
			 <?php } ?><?}}?>
			<?}?>
			<?if($v['UserInfo']['type'] == 'textarea'){?>
			<textarea  name="info_value[<?echo $v['UserInfo']['id']?>]"><?php if(isset($v['value']['value']))echo $v['value']['value']; ?></textarea>
			<?}?>
                  </dt>
                  </li>
            <?}}?>
        <?}?>
</ul>

<ul id="ul_company" style="display:none;">
  <li>
    <dd class="l"><b><?=$SCLanguages['purchase_requirement']?>：</b></dd>
    <dt>
      <input name="buytype" id="buytype1" type="radio" size="16" value="1" /><?=$SCLanguages['yes']?>&nbsp;
      <input name="buytype" id="buytype2" type="radio" size="16" value="0" /><?=$SCLanguages['no']?><font color="red">*</font></dt>
      <dd><?=$SCLanguages['choose_if_purchase_now']?> </dd>  
  </li>

  <li>
    <dd class="l"><b><?=$SCLanguages['company_name']?>：</b></dd>
    <dt>
      <input name="Comname" id="Comname" type="text" />&nbsp;<font color="red">*</font></dt>
      <dd><?=$SCLanguages['leave_company_name']?> </dd>
  </li>
  <li>
    <dd class="l"><b><?=$SCLanguages['company_address']?>：</b></dd>
    <dt><input name="Comaddr" id="Text2" type="text" /></dt>
    <dd><?=$SCLanguages['leave_company_address']?> </dd>
  </li>
  <li>
    <dd class="l"><b><?=$SCLanguages['company_phone']?>：</b></dd>
    <dt><input name="Comphone" id="Text3" type="text" /></dt>
    <dd><?=$SCLanguages['leave_company_tel.']?></dd>  
  </li>
</ul>
<div class="big_buttons">
<p style="padding-left:227px;margin-bottom:15px;">
		  <span class="float_l" style="text-indent:0;"><input id="button" onfocus="blur()" name="Submit" value="<?=$SCLanguages['user'].$SCLanguages['register']?>"  onclick="javascript:check_user_info();" type="button"></span>
		  <span class="float_l" style="text-indent:0;margin-left:4px;"><input onfocus="blur()" id="Reset" value="<?=$SCLanguages['reset']?>" onclick="javascript:document.forms.user_info.reset();" type="button"></span>
</p>
</div>
</form>
</div>
<p><?=$html->image('bottom.gif',array())?></p>
</div>
<!--注册步骤一 End-->
<?php echo $this->element('calendar', array('cache'=>'+0 hour'));?>
<!--协议条款-->
<div id="reguser_box">
<?=$html->image('Agreement_top.gif',array("align"=>"absbottom"))?>
  <div id="reguser_gut01" class="Agreement_box">
<div id="Title"><b><?=$SCLanguages['user'].$SCLanguages['register'].$SCLanguages['agreement']?></b></div>
    <div class="Agreement">
     <p class="text">八、 责任范围及责任限制 <br />
    （一） 本公司仅对本协议中列明的责任承担范围负责。 <br />
    （二） 您明确因交易所产生的任何风险应由您与交易对方承担。 <br />
    （三） 支付宝用户信息是由用户本人自行提供的，本公司无法保证该信息之准确、及时和完整，您应对您的判断承担全部责任。 <br />
    （四） 本公司不对交易标的及本服务提供任何形式的保证，包括但不限于以下事项： <br />
    1、本服务符合您的需求。 <br />
    2、本服务不受干扰、及时提供或免于出错。 <br />
    3、您经由本服务购买或取得之任何产品、服务、资讯或其他资料符合您的期望。 <br />
    （五） 本服务之合作单位，所提供之服务品质及内容由该合作单位自行负责。 <br />
    （六） 您经由本服务之使用下载或取得任何资料，应由您自行考量且自负风险，因资料之下载而导致您电脑系统之任何损坏或资料流失，您应负完全责任。 <br />
    （七） 您自本公司及本公司工作人员或经由本服务取得之建议和资讯，无论其为书面或口头形式，均不构成本公司对本服务之保证。<br />
</div>

<div class="Agreement_btn big_buttons" style="padding-bottom:5px;">
	<p style="padding-left: 385px;margin-top:30px;">
		  <span class="float_l"><input onfocus="blur()" id="agreement" value="<?=$SCLanguages['agree']?>" onclick="javascript:agreement();" type="button"></span>
	</p>
</div>
</div>
<p><?=$html->image('Agreement_img.gif')?></p>
</div>
<!--协议条款 End-->
<?php echo $this->element('news', array('cache'=>'+0 hour'));?>
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