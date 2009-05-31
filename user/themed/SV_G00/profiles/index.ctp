<?php
/*****************************************************************************
 * SV-Cart 我的信息
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link(array('profiles','calendar'));?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Editinfo_title">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?=$SCLanguages['my_information']?></b></h1></div>
<div id="Edit_box">
  <div id="Edit_info">
<form action="" name="EditUserInfoForm" id="EditUserInfoForm" method="POST" onsubmit="return:false;">
<input type="hidden" id="UserId" name="data[User][id]" value="<?echo $this->data['User']['id']?>">
<?if(isset($this->data['UserAddress'])){?>
	<input type="hidden" id="UserAddressId" name="data[UserAddress][id]" value="<?echo $this->data['UserAddress']['id']?>">
<?}?>
<ul>
  <li>
    <dd id="span_usertype"><?=$SCLanguages['member']?>：</dd>
    <dt class="name"><?echo $this->data['User']['name']?></dt></li>
  <li>
    <dd><?=$SCLanguages['email']?>：</dd>
    <dt><input name="data[User][email]" id="UserEmail" maxLength="200" style="width:216px;" type="text" size="55" <?if(isset($this->data['User']['email'])){?>value="<?echo $this->data['User']['email']?>"<?}else{?>value=""<?}?>/>&nbsp;<font color="red" id="user_email">*</font></dt></li>
  <li>
        <dd class="pass"><?=$SCLanguages['gender']?>：</dd>
        <dt>
          <select id="UserSex" name="data[User][sex]">
            <option value="0" <?if($this->data['User']['sex'] == 0){?>selected<?}?>><?=$SCLanguages['confidence']?></option>
            <option value="1" <?if($this->data['User']['sex'] == 1){?>selected<?}?>><?=$SCLanguages['male']?></option>
            <option value="2" <?if($this->data['User']['sex'] == 2){?>selected<?}?>><?=$SCLanguages['female']?></option>
        </select></dt></li>
  <li>
        <dd><?=$SCLanguages['birthday']?>：</dd>
        <dt>
          <input type="text" id="date" name="date" value="<?echo $this->data['User']['birthday']?>" disabled/>
            <!--button class="Calendar" id="show" title="Show Calendar">
            <?=$html->image('calendar.png',array('alt'=>'calendar'))?>
            </button-->
            <button type="button" class="Calendar" id="show" title="Show Calendar">
       		<?=$html->image('calendar.png',array('width'=>'18' ,'height'=>'18' ,'alt'=>'Calendar'))?>
       		</button>
       	</dt>
   </li>
 <li>
    <dd><?=$SCLanguages['region']?>：</dd>
    <dt><span id="regions"></span><span id="region_loading" style='display:none'><?=$html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>&nbsp;<font color="red" id="user_regions">*</font></dt>
 </li>
  <li class="reguser_gut01_height01">
    <dd><?=$SCLanguages['address']?>：</dd>
    <dt>
      <input name="data[UserAddress][address]" id="UserAddressAddress" maxLength="200" style="width:216px;" type="text" size="55" <?if(isset($this->data['UserAddress']['address'])){?>value="<?echo $this->data['UserAddress']['address']?>"<?}else{?>value=""<?}?>/>&nbsp;<font color="red" id="user_address">*</font></dt>
  </li>
  <li>
  <dd><?=$SCLanguages['mobile']?>：</dd>
  <dt><input type="text" name="data[UserAddress][mobile]" id="UserAddressMobile" onKeyUp="is_int(this);" maxLength="40" size="27" <?if(isset($this->data['UserAddress']['mobile'])){?>value="<?echo $this->data['UserAddress']['mobile']?>"<?}else{?>value=""<?}?>/>&nbsp;<font color="red" id="user_mobile">*</font></dt>
  </li>
    <li>
        <dd><?=$SCLanguages['telephone']?>：</dd>
        <dt>
        <span>
          <input type="text" name="Utel0" id="Utel0" maxLength="30" onKeyUp="is_int(this);" size="6" <?if(isset($this->data['UserAddress']['telephone'])){?>value="<?echo $this->data['UserAddress']['telephone'][0]?>"<?}else{?>value=""<?}?>/>-<input type="text" name="Utel1" id="Utel1" onKeyUp="is_int(this);" maxLength="30" size="10" <?if(isset($this->data['UserAddress']['telephone'][1])){?>value="<?echo $this->data['UserAddress']['telephone'][1]?>"<?}else{?>value=""<?}?>/>-<input type="text" name="Utel2" id="Utel2" onKeyUp="is_int(this);" maxLength="30" size="6" <?if(isset($this->data['UserAddress']['telephone'][2])){?>value="<?echo $this->data['UserAddress']['telephone'][2]?>"<?}else{?>value=""<?}?>/></span>&nbsp;<font color="red" id="user_telephone">*</font><span><?=$SCLanguages['zone_telephone_extension']?></span>
          </dt>
          </li>
          <li>

<?if(isset($user_infoarr) && sizeof($user_infoarr)>0){?>

  <?foreach($user_infoarr as $k=>$v){?>
  	  <?//pr($v['UserInfo']['values']);?>
  	  <?
  	  ?>
	<li>
	<dd><?echo $v['UserInfo']['name']?>：</dd>
	<input id="ValueId<?=$k?>" name="info_value_id[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?php if(isset($v['value']['id'])){echo $v['value']['id'];}?>">
	<input id="ValueInfoId<?=$k?>" name="ValueInfoId[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?=$v['UserInfo']['id']?>">
	<input id="ValueInfoType<?=$k?>" name="ValueInfoType[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?=$v['UserInfo']['type']?>">

	<dt>
	<?if($v['UserInfo']['type'] == 'text'){?>
	<input id="ValueValue<?=$k?>" type="text" class="text_inputs" style="width:265px;" name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" value="<?php if(isset($v['value']['value'])){echo $v['value']['value'];}?>"/>
	<?}?>
	<?if($v['UserInfo']['type'] == 'select'){?>
	<select id="ValueValue<?=$k?>"   name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]"/>
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
	<input id="ValueInfoTimes<?=$k?>" name="ValueInfoTimes[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?=$times?>">
 	 <?foreach($options as $kk=>$option){
 	$text =explode(":",$option); 
 if(@$text[1]!=""){?>
 <label><input type="radio" id="ValueValue<?=$k?><?=$kk?>"   name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" value="<?php echo $text[0];?>" <?php if(isset($v['value']['value']) && @$text[0]==$v['value']['value']) echo 'checked';?>/><?php if(@$text[1]){ echo $text[1];}?></label>
 <?php }}?>		
<?}}?>
<?if($v['UserInfo']['type'] == 'checkbox'){?>
 <?php if(isset($v['UserInfo']['values'])&&!empty($v['UserInfo']['values'])){
 	 if(isset($v['value']['value'])){
 	 	$checkoptions = explode(';',$v['value']['value']);
 	 }
 	 $options = explode(';',$v['UserInfo']['values']);
 	 $times = sizeof($options);?>
	<input id="ValueInfoTimes<?=$k?>" name="ValueInfoTimes[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?=$times?>">
 	 <?foreach($options as $kkk=>$option){
 	 $text =explode(":",$option);if(@$text[1]!=""){?>
 <label><input type="checkbox" id="ValueValue<?=$k?><?=$kkk?>"   name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" value="<?php echo $text[0];?>" <?php if(isset($checkoptions) && in_array($text[0],$checkoptions)) echo 'checked';?>/><?php if(@$text[1]){ echo $text[1];}?></label>
 <?php } ?><?}}?>
<?}?>
<?if($v['UserInfo']['type'] == 'textarea'){?>
<textarea id="ValueValue<?=$k?>"   name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]"><?php if(isset($v['value']['value']))echo $v['value']['value']; ?></textarea>
<?}?>
</dt>
</li>
		<?}?>
<?}?>
</ul></form>
<div class="y_but submits">
<p style="padding-left:47px;">
<input type="hidden" name="address_id" id="address_id" value="<?echo $default_address['UserAddress']['id']?>">
<span class="float_l" style="text-indent:0;"><input type="button" name="Submit2" value="<?=$SCLanguages['confirm']?>"  onclick="view_profiles()" /></span>
<span class="float_l" style="text-indent:0;"><input type="reset" onclick="javascript:document.EditUserInfoForm.reset();" name="Submit1" id="Submit1" value="<?=$SCLanguages['cancel']?>" /></span></p>
</div>


</div>
</div>
<?php echo $this->element('news', array('cache'=>'+0 hour'));?>
<?php echo $this->element('calendar', array('cache'=>'+0 hour'));?>
<script type="text/javascript">
show_regions("<?echo $this->data['UserAddress']['regions']?>");
</script>