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
 * $Id: checkout_address_update.ctp 3051 2009-07-17 11:51:50Z huangbo $
*****************************************************************************/
?>
<p class="address btn_list border_bottom" style="padding-bottom:0;">
<?php echo $html->link("<span>".$SCLanguages['add']."</span>","javascript:edit_address_no_ajax('update');",array('class'=>'amember'),false,false)?>
<a href="javascript:edit_address_act();" class="amember"><span><?php echo $SCLanguages['add']?></span></a>
<span class="l"></span><span class="r"></span><?php echo $SCLanguages['consignee'].$SCLanguages['information'];?>:
</p>
<?php echo $form->create('carts',array('action'=>'edit_address_act','name'=>'edit_address_act_update','type'=>'POST'));?>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align="center">
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?>:</td>
<td class="lan-info"><input name="data[address][name]" id="EditAddressName" value="<?php echo $address['UserAddress']['name']?>">&nbsp;<font id="edit_address_name" color="red">*</font></td>
<td class="lan-name" ><?php echo $SCLanguages['region'];?>:</td>
<td class="lan-info" width="350"><span id="regionsupdate"></span>
<span id="update_region_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>
&nbsp;<font id="edit_address_regions" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td><td class="lan-info"><input name="data[address][consignee]" id="EditAddressConsignee" value="<?php echo $address['UserAddress']['consignee']?>">&nbsp;<font id="edit_address_consignee" color="red">*</font>&nbsp;</td>
<td class="lan-name"><?php echo $SCLanguages['address'];?>:</td><td class="lan-info"><input name="data[address][address]" id="EditAddressAddress" value="<?php echo $address['UserAddress']['address']?>">&nbsp;<font id="edit_address_address" color="red">*</font>&nbsp;</td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['mobile'];?>:</td><td class="lan-info"><input name="data[address][mobile]"  onKeyUp="is_int(this);" id="EditAddressMobile" value="<?php echo $address['UserAddress']['mobile']?>">&nbsp;<font id="edit_address_mobile" color="red">*</font></td>
<td class="lan-name "><?php echo $SCLanguages['marked_building'];?>:</td><td class="lan-info"><input name="data[address][sign_building]" id="EditAddressSignBuilding" value="<?php echo $address['UserAddress']['sign_building']?>"></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['telephone'];?>:
	<?php 
	$tel_arr = @explode('-',$address['UserAddress']['telephone']);
	
	?>
</td><td class="lan-info">
<input style="width:30px;" type="text" name="user_tel0" id="tel_0" maxLength="30" size="6" onKeyUp="is_int(this);" value="<?php if(isset($tel_arr[0])){echo $tel_arr[0];}?>"/>
-<input type="text" name="user_tel1" id="tel_1" style="width:80px;" size="10" onKeyUp="is_int(this);"  value="<?php if(isset($tel_arr[1])){echo $tel_arr[1];}?>"/>
-<input style="width:30px;" type="text" name="user_tel2" id="tel_2" size="6" onKeyUp="is_int(this);"  value="<?php if(isset($tel_arr[2])){echo $tel_arr[2];}?>"/>&nbsp;<font color="red" id="edit_address_telephone">*</font>&nbsp;</td>
<td class="lan-name"><?php echo $SCLanguages['post_code'];?>:</td><td class="lan-info"><input name="data[address][zipcode]" id="EditAddressZipcode" value="<?php echo $address['UserAddress']['zipcode']?>">&nbsp;<font color="red" id="edit_address_zipcode">*</font>&nbsp;</td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['email'];?>:</td><td class="lan-info"><input name="data[address][email]" id="EditAddressEmail" value="<?php echo $address['UserAddress']['email']?>">&nbsp;<font color="red" id="edit_address_email">*</font></td>
<td class="lan-name"><?php echo $SCLanguages['best_shipping_time'];?>:</td><td class="lan-info"><input name="data[address][best_time]" id="EditAddressBestTime" value="<?php echo $address['UserAddress']['best_time']?>"></td>
<input type='hidden' name="data[address][id]" id="EditAddressId" value="<?php echo $address['UserAddress']['id']?>">
</tr>
</table>
<?php echo $form->end();?>
