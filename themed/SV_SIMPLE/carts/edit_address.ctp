<?php 
/*****************************************************************************
 * SV-Cart 编辑地址
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: edit_address.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
ob_start();?>
<?php if ($result['type'] == 0){?>
	<?php if(empty($result['all_virtual'])){?>
<div class="Balance_alltitle" style="margin-bottom:0;"><h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['mmodify']?></b></h1></div>
<div id="Balance_info" style='background:#fff;margin-top:0;width:892px;'>
<p class="address border_bottom">
<span class="l"></span><span class="r"></span><?php echo $SCLanguages['mmodify'].$SCLanguages['consignee'].$SCLanguages['information'];?>:
</p>

<table cellpadding="0" cellspacing="0" class="address_table" border=0 align="center">
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?>:</td>
<td class="lan-info"><input name="data['address']['name']" id="EditAddressName" value="<?php echo $address['UserAddress']['name']?>">&nbsp;<font id="edit_address_name" color="red">*</font></td>
<td class="lan-name" ><?php echo $SCLanguages['region'];?>:</td>
<td class="lan-info" width="350"><span id="regionsupdate"></span>
<span id="update_region_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>
&nbsp;<font id="edit_address_regions" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td><td class="lan-info"><input name="data['address']['consignee']" id="EditAddressConsignee" value="<?php echo $address['UserAddress']['consignee']?>">&nbsp;<font id="edit_address_consignee" color="red">*</font>&nbsp;</td>
<td class="lan-name"><?php echo $SCLanguages['address'];?>:</td><td class="lan-info"><input name="data['address']['address']" id="EditAddressAddress" value="<?php echo $address['UserAddress']['address']?>">&nbsp;<font id="edit_address_address" color="red">*</font>&nbsp;</td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['mobile'];?>:</td><td class="lan-info"><input name="data['address']['mobile']"  onKeyUp="is_int(this);" id="EditAddressMobile" value="<?php echo $address['UserAddress']['mobile']?>">&nbsp;<font id="edit_address_mobile" color="red">*</font></td>
<td class="lan-name "><?php echo $SCLanguages['marked_building'];?>:</td><td class="lan-info"><input name="data['address']['sign_building']" id="EditAddressSignBuilding" value="<?php echo $address['UserAddress']['sign_building']?>"></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['telephone'];?>:
</td><td class="lan-info">
<input style="width:30px;" type="text" name="user_tel0" id="tel_0" maxLength="30" size="6" onKeyUp="is_int(this);" value="<?php if(isset($tel_arr[0])){echo $tel_arr[0];}?>"/>
-<input type="text" name="user_tel1" id="tel_1" style="width:80px;" size="10" onKeyUp="is_int(this);"  value="<?php if(isset($tel_arr[1])){echo $tel_arr[1];}?>"/>
-<input style="width:30px;" type="text" name="user_tel2" id="tel_2" size="6" onKeyUp="is_int(this);"  value="<?php if(isset($tel_arr[2])){echo $tel_arr[2];}?>"/>&nbsp;<font color="red" id="edit_address_telephone">*</font>&nbsp;</td>
<td class="lan-name"><?php echo $SCLanguages['post_code'];?>:</td><td class="lan-info"><input name="data['address']['zipcode']" id="EditAddressZipcode" value="<?php echo $address['UserAddress']['zipcode']?>">&nbsp;<font color="red" id="edit_address_zipcode">*</font>&nbsp;</td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['email'];?>:</td><td class="lan-info"><input name="data['address']['email']" id="EditAddressEmail" value="<?php echo $address['UserAddress']['email']?>">&nbsp;<font color="red" id="edit_address_email">*</font></td>
<td class="lan-name"><?php echo $SCLanguages['best_shipping_time'];?>:</td><td class="lan-info"><input name="data['address']['best_time']" id="EditAddressBestTime" value="<?php echo $address['UserAddress']['best_time']?>"></td>
<input type='hidden' name="data['address']['id']" id="EditAddressId" value="<?php echo $address['UserAddress']['id']?>">
</tr>
<tr class='btn_list'>
<td colspan="2" style="*padding-top:8px;">
<a href="javascript:edit_address_act();" class="float_r"><span><?php echo $SCLanguages['mmodify']?></span></a></td>
<td colspan="2" style="padding-left:4px;">
<a href="javascript:close_message_width();" class="float_l"><span><?php echo $SCLanguages['cancel']?></span></a></td>
</tr>
</table>
<p class="edittitle address">
<span class="l"></span><span class="r"></span><?php echo $SCLanguages['add'];?><?php echo $SCLanguages['consignee'];?><?php echo $SCLanguages['information'];?>:
</p>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align="center">
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?>:</td>
<td class="lan-info"><input name="data['address']['name']" id="AddressName" value="">&nbsp;<font id="add_address_name" color="red">*</font></td>
<td class="lan-name" ><?php echo $SCLanguages['region'];?>:</td>
<td class="lan-info" width="350"><span id="regions"></span><span id="add_region_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>&nbsp;<font id="add_address_regions" color="red">*</font></td>
</tr>

<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td>
<td class="lan-info"><input name="data['address']['consignee']" id="AddressConsignee" value="">&nbsp;<font id="add_address_consignee" color="red">*</font></td>
<td class="lan-name"><?php echo $SCLanguages['address'];?>:</td>
<td class="lan-info"><input name="data['address']['address']" id="AddressAddress" value="">&nbsp;<font id="add_address_address" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['mobile'];?>:</td><td class="lan-info"><input name="data['address']['mobile']" onKeyUp="is_int(this);" id="AddressMobile" value="">&nbsp;<font id="add_address_mobile" color="red">*</font></td>
<td class="lan-name "><?php echo $SCLanguages['marked_building'];?>:</td><td class="lan-info"><input name="data['address']['sign_building']" id="AddressSignBuilding" value=""></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['telephone'];?>:</td><td class="lan-info">
<!--input name="data['address']['telephone']" id="AddressTelephone" value=""-->
<input style="width:30px;" type="text" name="user_tel0" id="add_tel_0" onKeyUp="is_int(this);" maxLength="30" size="6" />
-<input type="text" name="user_tel1" id="add_tel_1" style="width:80px;" onKeyUp="is_int(this);" size="10" />
-<input style="width:30px;" type="text" name="user_tel2" id="add_tel_2" onKeyUp="is_int(this);" size="6" />
&nbsp;<font id="add_address_telephone" color="red">*</font></td>
<td class="lan-name"><?php echo $SCLanguages['post_code'];?>:</td><td class="lan-info"><input name="data['address']['zipcode']" id="AddressZipcode" value="">&nbsp;<font id="add_address_zipcode" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['email'];?>:</td><td class="lan-info"><input name="data['address']['email']" id="AddressEmail" value="">&nbsp;<font id="add_address_email" color="red">*</font></td>
<td class="lan-name"><?php echo $SCLanguages['best_shipping_time'];?>:</td><td class="lan-info"><input name="data['address']['best_time']" id="AddressBestTime" value=""></td>
</tr>
<tr class='btn_list'>
<td colspan="2" align="right" style="*padding-top:8px;">
<a href="javascript:checkout_new_address();" class="float_r"><span><?php echo $SCLanguages['add']?></span></a>
</td>
<td colspan="2" align="left" style="padding-left:4px;">
<a href="javascript:close_message_width();" class="float_l"><span><?php echo $SCLanguages['cancel']?></span></a>
</td>
</tr>
</table>
<br />
</div>




	
<?php }else{?>




	
<div class="Balance_alltitle" style="margin-bottom:0;margin-top:0;position:relative;width:500px;">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['mmodify']?></b></h1>
</div>
<div id="Balance_info" style='background:#fff;margin-top:0;width:500px;'>
<p class="edittitle">
<strong><?php echo $SCLanguages['mmodify'].$SCLanguages['consignee'].$SCLanguages['information'];?>:</strong>
</p>

<table cellpadding="0" cellspacing="0" class="address_table" border="0" align="center" style="width:97%;margin:0 auto;border:none">
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?>:</td>
<td class="lan-info"><input name="data['address']['name']" id="EditAddressName" value="<?php echo $address['UserAddress']['name']?>">&nbsp;<font id="edit_address_name" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td><td class="lan-info"><input name="data['address']['consignee']" id="EditAddressConsignee" value="<?php echo $address['UserAddress']['consignee']?>">&nbsp;<font id="edit_address_consignee" color="red">*</font>&nbsp;</td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['mobile'];?>:</td><td class="lan-info"><input name="data['address']['mobile']"  onKeyUp="is_int(this);" id="EditAddressMobile" value="<?php echo $address['UserAddress']['mobile']?>">&nbsp;<font id="edit_address_mobile" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['telephone'];?>:
</td><td class="lan-info">
<input style="width:30px;" type="text" name="user_tel0" id="tel_0" maxLength="30" size="6" onKeyUp="is_int(this);" value="<?php if(isset($tel_arr[0])){echo $tel_arr[0];}?>"/>
-<input type="text" name="user_tel1" id="tel_1" style="width:80px;" size="10" onKeyUp="is_int(this);"  value="<?php if(isset($tel_arr[1])){echo $tel_arr[1];}?>"/>
-<input style="width:30px;" type="text" name="user_tel2" id="tel_2" size="6" onKeyUp="is_int(this);"  value="<?php if(isset($tel_arr[2])){echo $tel_arr[2];}?>"/>&nbsp;<font color="red" id="edit_address_telephone">*</font>&nbsp;</td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['email'];?>:</td><td class="lan-info"><input name="data['address']['email']" id="EditAddressEmail" value="<?php echo $address['UserAddress']['email']?>">&nbsp;<font color="red" id="edit_address_email">*</font></td>
<input type='hidden' name="data['address']['id']" id="EditAddressId" value="<?php echo $address['UserAddress']['id']?>">
</tr>
<tr class='btn_list'>
<td colspan="1" style="*padding-top:8px;">
</td>
<td colspan="1">
<a href="javascript:edit_virtual_address_act();" class="float_l" style="margin-right:4px;"><span><?php echo $SCLanguages['mmodify']?></span></a>
<a href="javascript:close_message_width();" class="float_l"><span><?php echo $SCLanguages['cancel']?></span></a></td>
</tr>
</table>
	

<p class="edittitle">
<strong><?php echo $SCLanguages['add'];?><?php echo $SCLanguages['consignee'];?><?php echo $SCLanguages['information'];?>:</strong>
</p>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 style="width:97%;margin:0 auto;border:none">
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?>:</td>
<td class="lan-info"><input name="data['address']['name']" id="AddressName" value="">&nbsp;<font id="add_address_name" color="red">*</font></td>
</tr>

<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td>
<td class="lan-info"><input name="data['address']['consignee']" id="AddressConsignee" value="">&nbsp;<font id="add_address_consignee" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['mobile'];?>:</td><td class="lan-info"><input name="data['address']['mobile']" onKeyUp="is_int(this);" id="AddressMobile" value="">&nbsp;<font id="add_address_mobile" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['telephone'];?>:</td><td class="lan-info">

<input style="width:30px;" type="text" name="user_tel0" id="add_tel_0" onKeyUp="is_int(this);" maxLength="30" size="6" />
-<input type="text" name="user_tel1" id="add_tel_1" style="width:80px;" onKeyUp="is_int(this);" size="10" />
-<input style="width:30px;" type="text" name="user_tel2" id="add_tel_2" onKeyUp="is_int(this);" size="6" />
&nbsp;<font id="add_address_telephone" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['email'];?>:</td><td class="lan-info"><input name="data['address']['email']" id="AddressEmail" value="">&nbsp;<font id="add_address_email" color="red">*</font></td>
</tr>
<tr class='btn_list'>
<td colspan="1" align="right" style="*padding-top:8px;">

</td>
<td colspan="1" align="left">
<a href="javascript:checkout_new_virtual_address();" class="float_l" style="margin-right:4px;"><span><?php echo $SCLanguages['add']?></span></a>
<a href="javascript:close_message_width();" class="float_l"><span><?php echo $SCLanguages['cancel']?></span></a>
</td>
</tr>
</table>

<br />
</div>
<?php }}?>
<?php $result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>