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
 * $Id: index.ctp 3233 2009-07-22 11:41:02Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link(array('profiles','calendar'));?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Editinfo_title">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['my_information']?></b></h1></div>
<div id="Edit_box">
  <div id="Edit_info">
<?php echo $form->create('profiles',array('action'=>'edit_profiles','name'=>'edit_profiles','type'=>'POST'));?>
<input type="hidden" id="UserId" name="data[User][id]" value="<?php echo $this->data['User']['id']?>">
<?php if(isset($this->data['UserAddress'])){?>
<input type="hidden" id="UserAddressId" name="data[UserAddress][id]" value="<?php echo $this->data['UserAddress']['id']?>">
<?php }?>
<ul>
  <li>
    <dd id="span_usertype"><?php echo $SCLanguages['member']?>：</dd>
    <dt class="name"><?php echo $this->data['User']['name']?></dt></li>
  <li>
    <dd><?php echo $SCLanguages['email']?>：</dd>
    <dt><input name="data[User][email]" id="UserEmail" maxLength="200" style="width:216px;" type="text" size="55" <?php if(isset($this->data['User']['email'])){?>value="<?php echo $this->data['User']['email']?>"<?php }else{?>value=""<?php }?>/>&nbsp;<font color="red" id="user_email">*</font></dt></li>
  <li>
        <dd class="pass"><?php echo $SCLanguages['gender']?>：</dd>
        <dt>
          <select id="UserSex" name="data[User][sex]">
            <option value="0" <?php if($this->data['User']['sex'] == 0){?>selected<?php }?>><?php echo $SCLanguages['confidence']?></option>
            <option value="1" <?php if($this->data['User']['sex'] == 1){?>selected<?php }?>><?php echo $SCLanguages['male']?></option>
            <option value="2" <?php if($this->data['User']['sex'] == 2){?>selected<?php }?>><?php echo $SCLanguages['female']?></option>
        </select></dt></li>
  <li>
        <dd><?php echo $SCLanguages['birthday']?>：</dd>
        <dt>
          <label id="show"><input type="text" id="date" name="data[User][birthday]" value="<?php echo $this->data['User']['birthday']?>" Readonly/><button type="button" class="calendar" title="Show Calendar"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'calendar.png':'calendar.png',array('width'=>'18' ,'height'=>'18' ,'alt'=>'Calendar'))?></button></label>
       	</dt>
   </li>
 <li>
    <dd><?php echo $SCLanguages['region']?>：</dd>
    <dt><span id="regions"></span><span id="region_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>&nbsp;<font color="red" id="user_regions">*</font></dt>
 </li>
  <li class="reguser_gut01_height01">
    <dd><?php echo $SCLanguages['address']?>：</dd>
    <dt>
      <input name="data[UserAddress][address]" id="UserAddressAddress" maxLength="200" style="width:216px;" type="text" size="55" <?php if(isset($this->data['UserAddress']['address'])){?>value="<?php echo $this->data['UserAddress']['address']?>"<?php }else{?>value=""<?php }?>/>&nbsp;<font color="red" id="user_address">*</font></dt>
  </li>
  <li>
  <dd><?php echo $SCLanguages['mobile']?>：</dd>
  <dt><input type="text" name="data[UserAddress][mobile]" id="UserAddressMobile" onKeyUp="is_int(this);" maxLength="40" size="27" <?php if(isset($this->data['UserAddress']['mobile'])){?>value="<?php echo $this->data['UserAddress']['mobile']?>"<?php }else{?>value=""<?php }?>/>&nbsp;<font color="red" id="user_mobile">*</font></dt>
  </li>
    <li>
        <dd><?php echo $SCLanguages['telephone']?>：</dd>
        <dt>
        <span>
          <input type="text" name="Utel0" id="Utel0"  onKeyUp="is_int(this);" maxLength="40" size="27"  <?php if(isset($this->data['UserAddress']['telephone'])){?>value="<?php echo $this->data['UserAddress']['telephone']?>"<?php }else{?>value=""<?php }?>/></span>&nbsp;<font color="red" id="user_telephone">*</font><span><?php echo $SCLanguages['zone_telephone_extension']?></span>
          </dt>
          </li>

<?php if(isset($user_infoarr) && sizeof($user_infoarr)>0){?>

  <?php foreach($user_infoarr as $k=>$v){?>
  	  <?php //pr($v['UserInfo']['values']);?>
  	  <?php 
  	  ?>
	<li>
	<dd><?php echo $v['UserInfo']['name']?>：</dd>
	<input id="ValueId<?php echo $k?>" name="info_value_id[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?php if(isset($v['value']['id'])){echo $v['value']['id'];}?>">
	<input id="ValueInfoId<?php echo $k?>" name="ValueInfoId[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?php echo $v['UserInfo']['id']?>">
	<input id="ValueInfoType<?php echo $k?>" name="ValueInfoType[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?php echo $v['UserInfo']['type']?>">

	<dt>
	<?php if($v['UserInfo']['type'] == 'text'){?>
	<input id="ValueValue<?php echo $k?>" type="text" class="text_inputs" style="width:265px;" name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" value="<?php if(isset($v['value']['value'])){echo $v['value']['value'];}?>"/>
	<?php }?>
	<?php if($v['UserInfo']['type'] == 'select'){?>
	<select id="ValueValue<?php echo $k?>"   name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]"/>
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
 	 <p style="padding-top:4px;">
 <?php if(isset($v['UserInfo']['user_info_values'])){
 	$options = explode(';',$v['UserInfo']['user_info_values']);
 	 $times = sizeof($options);?>
	<input id="ValueInfoTimes<?php echo $k?>" name="ValueInfoTimes[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?php echo $times?>">
 	 <?php foreach($options as $kk=>$option){
 	$text =explode(":",$option); 
 if(@$text[1]!=""){?>
 <label><input type="radio" class="radio" id="ValueValue<?php echo $k?><?php echo $kk?>"   name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" value="<?php echo $text[0];?>" <?php if(isset($v['value']['value']) && @$text[0]==$v['value']['value']) echo 'checked';?>/><?php if(@$text[1]){ echo $text[1];}?></label>
 <?php }}?>		
<?php }?></p><?php }?>
<?php if($v['UserInfo']['type'] == 'checkbox'){?>
 <?php if(isset($v['UserInfo']['user_info_values'])&&!empty($v['UserInfo']['user_info_values'])){
 	 if(isset($v['value']['value'])){
 	 	$checkoptions = explode(';',$v['value']['value']);
 	 }
 	 $options = explode(';',$v['UserInfo']['user_info_values']);
 	 $times = sizeof($options);?>
	<input id="ValueInfoTimes<?php echo $k?>" name="ValueInfoTimes[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?php echo $times?>">
 	 <?php foreach($options as $kkk=>$option){
 	 $text =explode(":",$option);if(@$text[1]!=""){?>
 <label><input type="checkbox" id="ValueValue<?php echo $k?><?php echo $kkk?>"   name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>][<?php echo $kkk?>]" value="<?php echo $text[0];?>" <?php if(isset($checkoptions) && in_array($text[0],$checkoptions)) echo 'checked';?>/><?php if(@$text[1]){ echo $text[1];}?></label>
 <?php } ?><?php }}?>
<?php }?>
<?php if($v['UserInfo']['type'] == 'textarea'){?>
<textarea id="ValueValue<?php echo $k?>"   name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]"><?php if(isset($v['value']['value']))echo $v['value']['value']; ?></textarea>
<?php }?>
</dt>
</li>
		<?php }?>
<?php }?>
</ul>
<div class="y_but submits">
<p style="padding-left:47px;">
<input type="hidden" name="address_id" id="address_id" value="<?php echo $default_address['UserAddress']['id']?>">
<span class="float_l" style="text-indent:0;">
	<input type="button" name="Submit2" value="<?php echo $SCLanguages['confirm']?>"  onclick="view_profiles()" />
</span>
<?php echo $form->end();?>
<span class="float_l" style="text-indent:0;"><input type="reset" onclick="javascript:document.EditUserInfoForm.reset();" name="Submit1" id="Submit1" value="<?php echo $SCLanguages['cancel']?>" /></span></p>
</div>


</div>
</div>
<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>
<?php echo $this->element('calendar', array('cache'=>'+0 hour'));?>
<script type="text/javascript">
show_regions("<?php echo (!empty($this->data['UserAddress']['regions']))?$this->data['UserAddress']['regions']:'';?>");
</script>