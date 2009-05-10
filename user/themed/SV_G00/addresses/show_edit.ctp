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
 * $Id: show_edit.ctp 1116 2009-04-28 11:04:43Z huangbo $
*****************************************************************************/
ob_start();
if ($result['type'] == 0){?>
<div id="edit_address" style="width:741px;">
<h2 class="add-addresses" id="title">
<span class="left"><?=$html->image("title_l.png")?></span><span class="right"><?=$html->image("title_r.png")?></span>
<span><?=$SCLanguages['edit'].$SCLanguages['consignee'].$SCLanguages['information'];?></span></h2>
<div id="reguser_gut01" class="addrees_box" style="width:741px;">
  
    <form action="" method="post"  name="EditAddressForm">
      <input type="hidden" name="data[UserAddress][id]" id="UserAddressId" value="<?echo $result['address']['UserAddress']['id']?>"></>
      <input type="hidden" name="data[UserAddress][user_id]" id="UserAddressUserId" value="<?echo $result['address']['UserAddress']['user_id']?>"></>
        <input type="hidden" name="action_type" value="edit_address">
<ul>
		
  <li>
  <dd class="l"><?=$SCLanguages['address'];?><?=$SCLanguages['label'];?>：</dd>
  <dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][name]" id="UserAddressName" maxLength="40" size="27" value="<?echo $result['address']['UserAddress']['name']?>"  />&nbsp;<font color="red" id="name_msg">*</font>    </dt></li>
  <li>		
		
  <li>
  <dd class="l"><?echo $SCLanguages['consignee'].$SCLanguages['name']?>：</dd>
  <dt style="white-space:nowrap;"> 
    <input type="text" name="data[UserAddress][consignee]" id="UserAddressConsignee" maxLength="40" size="27" value="<?echo $result['address']['UserAddress']['consignee']?>" />&nbsp;<font color="red" id="consignee_msg">*</font>
    </dt></li>
  	
  <li>
  <dd class="l"><?echo $SCLanguages['email']?>：</dd>
  <dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][email]" id="UserAddressEmail" maxLength="40" size="27" value="<?echo $result['address']['UserAddress']['email']?>" />&nbsp;<font color="red" id="email_msg">*</font>
    </dt></li>
  
  <li>
    <dd class="l"><span id="span_Uname"><?echo $SCLanguages['region']?>：</span></dd>
    <dt style="white-space:nowrap;"><span id="regions"></span><span id="region_loading" style='display:none'><?=$html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>&nbsp;<font color="red" id="regions_msg">*</font> </dt>
 </li>
 <li>
    <dd class="l"><?=$SCLanguages['street'];?>：</dd>
    <dt class="adrees" style="width:auto;"><textarea name="data[UserAddress][address]" id="UserAddressAddress"  style="width:250px;overflow-y:scroll" rows="4"><?echo $result['address']['UserAddress']['address']?></textarea></dt><dd>&nbsp;<font color="red" id="address_msg">*</font><br/><br/><br/><br/><?=$SCLanguages['duplicate_fill_province_city_district'];?>。</dd>  </li>
  <li>
    <dd class="l"><?echo $SCLanguages['post_code']?>：</dd>
    <dt style="white-space:nowrap;"><input name="data[UserAddress][zipcode]" id="UserAddressZipcode" size="27" maxLength="18" onKeyUp="is_int(this);" value="<?echo $result['address']['UserAddress']['zipcode']?>" />&nbsp;<font color="red" id="zipcode_msg">*</font></dt></li>
    <li>
        <dd class="l"><span id="span_phone"><?echo $SCLanguages['telephone']?>：</span></dd>
        <dt><input style="width:40px;" type="text" name="tel_0" id="tel_0" onKeyUp="is_int(this);" value="<?php if(isset($result['address']['UserAddress']['telephone'][0])){echo $result['address']['UserAddress']['telephone'][0];}?>" />-<input style="width:100px;" onKeyUp="is_int(this);" type="text" name="tel_1" id="tel_1" value="<?php if(isset($result['address']['UserAddress']['telephone'][1])){echo $result['address']['UserAddress']['telephone'][1];}?>" />-<input style="width:40px;" type="text" name="tel_2" id="tel_2" onKeyUp="is_int(this);" value="<?php if(isset($result['address']['UserAddress']['telephone'][2])){echo $result['address']['UserAddress']['telephone'][2];}?>" /></dt>
        <dd>&nbsp;<font color="red" id="tel_msg">*</font> <?echo $SCLanguages['zone_telephone_extension']?></dd></li>
      <li>
        <dd class="l"><span id="span_phone"><?echo $SCLanguages['mobile']?>：</span></dd>
        <dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][mobile]" id="UserAddressMobile" maxLength="30" size="27" onKeyUp="is_int(this);" value="<?echo $result['address']['UserAddress']['mobile']?>" />&nbsp;<font color="red" id="mobile_msg">*</font> </dt></li>
</ul>

<ul id="ul_company" style="display:none;">
  <li>
    <dd class="l"><b><?echo $SCLanguages['purchase_requirement']?>：</b></dd>
    <dt>
      <input name="buytype" id="buytype1" type="radio" size="16" value="1" /><?echo $SCLanguages['yes']?>&nbsp;
      <input name="buytype" id="buytype2" type="radio" size="16" value="0" /><?echo $SCLanguages['no']?><font color="red">*</font></dt>
      <dd>[<?echo $SCLanguages['choose_if_purchase_now']?>] </dd>  
  </li>

  <li>
    <dd class="l"><b><?=$SCLanguages['company_name'];?>：</b></dd>
    <dt>
      <input name="Comname" id="Comname" type="text" size="16" maxLength="20" />&nbsp;<font color="red">*</font></dt>
      <dd><?=$SCLanguages['leave_company_name'];?> </dd>  
  </li>
  <li>
    <dd class="l"><span id="spanzz_comaddr"><b><?=$SCLanguages['company_address'];?>：</b></span></dd>
    <dt><input name="Comaddr" id="Text2" type="text" size="40" maxLength="80" /></dt>
    <dd><?=$SCLanguages['leave_company_address'];?> </dd>  
  </li>
  <li>
    <dd class="l"><b><?=$SCLanguages['company_phone'];?>：</b></dd>
    <dt><input name="Comphone" id="Text3" type="text" size="16" maxLength="20" /></dt>
    <dd><?=$SCLanguages['leave_company_tel.'];?></dd>  
  </li>
</ul>
<div class="add_btn big_buttons">
<p style="padding-left:198px;">
<span class="float_l" style="text-indent:0;"><input type="button" onfocus="blur()" name="Submit2" onclick="javascript:edit_address();" value="<?=$SCLanguages['confirm'];?>" /></span>
<span class="float_l" style="margin-left:4px;text-indent:0;"><input onfocus="blur()" type="button" name="Submit2" value="<?=$SCLanguages['cancel'];?>" onclick="javascript:close_message_img();" /></span></p>
</div>
</form>
</div>
</div>


<?}?>
<?$result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>