<?php 
/*****************************************************************************
 * SV-Cart 结算页用户地址
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_address_update.ctp 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/
?>
<h5><?php echo $SCLanguages['consignee'].$SCLanguages['information'];?>:</h5>
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
</td>
<td class="lan-info">
<input type="text" name="user_tel0" id="tel_0" onKeyUp="is_int(this);" value="<?php if(isset($address['UserAddress']['telephone'])){echo $address['UserAddress']['telephone'];}?>"/>
<font color="red" id="edit_address_telephone">*</font>&nbsp;</td>
<td class="lan-name"><?php echo $SCLanguages['post_code'];?>:</td><td class="lan-info"><input name="data['address']['zipcode']" id="EditAddressZipcode" value="<?php echo $address['UserAddress']['zipcode']?>">&nbsp;</td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['email'];?>:</td><td class="lan-info"><input name="data['address']['email']" id="EditAddressEmail" value="<?php echo $address['UserAddress']['email']?>">&nbsp;<font color="red" id="edit_address_email">*</font></td>
<td class="lan-name"><?php echo $SCLanguages['best_shipping_time'];?>:</td><td class="lan-info"><input name="data['address']['best_time']" id="EditAddressBestTime" value="<?php echo $address['UserAddress']['best_time']?>"></td>
<input type='hidden' name="data['address']['id']" id="EditAddressId" value="<?php echo $address['UserAddress']['id']?>">
</tr>
<tr>
	<td colspan="4" class="btn_list" style="padding-left:415px;"><a href="javascript:edit_address_act();" class="amember float_l"><span><?php echo $SCLanguages['add']?></span></a></td>
</tr>
</table>
