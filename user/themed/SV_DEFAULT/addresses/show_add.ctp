<?php 
/*****************************************************************************
 * SV-Cart 我的地址簿
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: show_add.ctp 4078 2009-09-04 11:42:15Z huangbo $
*****************************************************************************/
ob_start();
if ($result['type'] == 0){?>
<div id="add_address_box" >
<div class="hd" style='height:auto;'>
<h2 class="add-addresses">
<span class="left"><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."title_l.gif":"title_l.gif")?></span><span class="right"><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."title_r.gif":"title_r.gif")?></span>
<span><?php echo $SCLanguages['add'].$SCLanguages['consignee'].$SCLanguages['information'];?></span></h2></div>
<div class="addrees_box reguser_gut01" style="margin-top:0;border-top:0;overflow:hidden;height:100%;margin-left:0;width:auto;">
  
<form action="" method="post" name="InsertAddressForm" onsubmit="return check_insert_address();">
   	<input type="hidden" name="action_type" value="insert_address">
   	<input type="hidden" name="data[UserAddress][user_id]" id="UserAddressUserId" value="<?php echo $result['id']?>">
<ul>
  <li>
  <dd class="l"><?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?>：</dd>
  <dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][name]" id="UserAddressName" maxLength="40" size="27" />&nbsp;<font color="red" id="name_msg">*</font>    </dt></li>
  <li>
  <li>
  <dd class="l"><?php echo $SCLanguages['consignee'].$SCLanguages['name']?>：</dd>
  <dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][consignee]" id="UserAddressConsignee" maxLength="40" size="27" />&nbsp;<font color="red" id="consignee_msg">*</font>    </dt></li>
  <li>
<dd class="l"><?php echo $SCLanguages['email']?>：</dd>
<dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][email]" id="UserAddressEmail" maxLength="40" size="27" />&nbsp;<font color="red" id="email_msg">*</font></dt></li>
  <li>
    <dd class="l"><span id="span_Uname"><?php echo $SCLanguages['region']?>：</span></dd>
    <dt style="white-space:nowrap;"><span id="regions"></span><span id="region_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>&nbsp;<font color="red" id="regions_msg">*</font> </dt>
 </li>
<script type="text/javascript">
show_regions("");
</script>
  <li>
    <dd class="l"><?php echo $SCLanguages['street'];?>：</dd>
    <dt class="adrees" style="width:auto;"><textarea name="data[UserAddress][address]" id="UserAddressAddress"  style="width:250px;overflow-y:scroll" rows="4"></textarea></dt><dd>&nbsp;<font color="red" id="address_msg">*</font><p><?php echo $SCLanguages['duplicate_fill_province_city_district'];?>。</p></dd>  </li>

  <li>
  <dd class="l"><?php echo $SCLanguages['marked_building']?>：</dd>
  <dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][sign_building]" id="UserAddressSignBuilding" maxLength="40" size="27" value="" />
  </dt></li>




<li>
    <dd class="l"><?php echo $SCLanguages['post_code']?>：</dd>
    <dt style="white-space:nowrap;"><input name="data[UserAddress][zipcode]" id="UserAddressZipcode" onKeyUp="is_int(this);" size="27" />&nbsp;<font color="red" id="zipcode_msg">*</font></dt></li>
    <li>
        <dd class="l"><span id="span_phone"><?php echo $SCLanguages['telephone']?>：</span></dd>
        <dt><input style="width:40px;" type="text" name="user_tel0" id="tel_0" maxLength="30" size="6" onKeyUp="is_int(this);" />-<input type="text" name="user_tel1" id="tel_1" style="width:100px;" size="10" onKeyUp="is_int(this);" />-<input style="width:40px;" type="text" name="user_tel2" id="tel_2" size="6" onKeyUp="is_int(this);" /></dt>
        <dd>&nbsp;<font color="red" id="tel_msg">*</font> <?php echo $SCLanguages['zone_telephone_extension']?></dd></li>
  
      <li>
        <dd class="l"><span id="span_phone"><?php echo $SCLanguages['mobile']?>：</span></dd>
        <dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][mobile]" id="UserAddressMobile" maxLength="30" onKeyUp="is_int(this);" size="27" />&nbsp;<font color="red" id="mobile_msg">*</font> </dt></li>

	  <li>
	  <dd class="l"><?php echo $SCLanguages['best_shipping_time']?>：</dd>
	  <dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][best_time]" id="UserAddressBestTime" maxLength="40" size="27" value="" />
	  </dt></li>		  
	  <li>
	  <dd class="l"><?php echo $SCLanguages['if_set_default']?>：</dd>
	  <dt style="white-space:nowrap;"><input type="checkbox" name="data[UserAddress][is_default]" id="add_is_default" style="width:auto" value="1" />
	  </dt></li>		  
	  


</ul>

<ul id="ul_company" style="display:none;">
  <li>
    <dd class="l"><b><?php echo $SCLanguages['purchase_requirement']?>：</b></dd>
    <dt>
      <input name="buytype" id="buytype1" type="radio" size="16" value="1" /><?php echo $SCLanguages['yes']?>&nbsp;
      <input name="buytype" id="buytype2" type="radio" size="16" value="0" /><?php echo $SCLanguages['no']?><font color="red">*</font></dt>
      <dd>[<?php echo $SCLanguages['choose_if_purchase_now']?>] </dd>  
  </li>

  <li>
    <dd class="l"><b><?php echo $SCLanguages['company_name']?>：</b></dd>
    <dt>
      <input name="Comname" id="Comname" type="text" size="16" maxLength="20" />&nbsp;<font color="red">*</font></dt>
      <dd>[<?php echo $SCLanguages['leave_company_name']?>] </dd>  
  </li>
  <li>
    <dd class="l"><span id="spanzz_comaddr"><b><?php echo $SCLanguages['company_address']?>：</b></span></dd>
    <dt><input name="Comaddr" id="Text2" type="text" size="40" maxLength="80" /></dt>
    <dd>[<?php echo $SCLanguages['leave_company_address']?>]</dd>  
  </li>
  <li>
    <dd class="l"><b><?php echo $SCLanguages['company_phone']?>：</b></dd>
    <dt><input name="Comphone" id="Text3" type="text" size="16" maxLength="20" /></dt>
    <dd>[<?php echo $SCLanguages['leave_company_tel.']?>]</dd>  
  </li>
</ul>
<div class="ws_xx"></div>
<div class="add_btn big_buttons">
	<p style="padding-left:198px;">
	<span class="float_l" style="text-indent:0;"><input onfocus="blur()" type="button" name="Submit2" value="<?php echo $SCLanguages['add'];?>" onclick="javascript:add_user_address();" /></span>
	<span class="float_l" style="margin-left:4px;text-indent:0;"><input onfocus="blur()" type="button" name="Submit2" value="<?php echo $SCLanguages['cancel'];?>" onclick="javascript:close_message_img();" /></span>
	</p></div>
</form>

</div>
</div>

<?php }?>
<?php $result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>