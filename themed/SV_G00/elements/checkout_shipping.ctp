<?php
/*****************************************************************************
 * SV-Cart 结算页配送方式
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_shipping.ctp 1232 2009-05-06 12:14:41Z huangbo $
*****************************************************************************/
?>
<? if(isset($shippings) && is_array($shippings) && sizeof($shippings)>0){?>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice">
<tr class="send_title bgcolor_e">
<td height="25" align="center"><?php echo $SCLanguages['name'];?></td>
<td height="25" align="center"><?php echo $SCLanguages['description'];?></td>
<td height="25" align="center"><?php echo $SCLanguages['cost'];?></td>
<td height="25" align="center" class="handel"><?php echo $SCLanguages['free'].$SCLanguages['limit'];?></td>
</tr>
<? foreach($shippings as $k=>$v){?>
<tr class="list">
<td width="29%" height="25" valign="middle" class="selece_input">
<span class="select_input"><input type="radio" name="shipping_id" value="<?=$v['Shipping']['id'];?>" onclick="confirm_shipping(<?=$v['Shipping']['id'];?>,<?=$v['ShippingArea']['fee']; ?>,'<?=$v['ShippingI18n']['name']; ?>',<?=$v['ShippingArea']['free_subtotal']; ?>,<?=$v['Shipping']['support_cod']?>,'<?=$v['ShippingI18n']['description']; ?>')" <?if(isset($svcart['shipping']['shipping_id']) && $v['Shipping']['id'] ==$svcart['shipping']['shipping_id']){?>checked="checked"<?}?> id="shipping_id<?=$v['Shipping']['id'];?>" class="radio" /></span><label for="shipping_id<?=$v['Shipping']['id'];?>"><span class="name"><?=$v['ShippingI18n']['name']; ?></span></label></td>
<td width="41%" height="25" valign="middle" class="bewrite"><?=$v['ShippingI18n']['description']; ?></td>
<td width="14%" height="25" align="center" valign="middle" class="addrees">
	<?=$svshow->price_format($v['ShippingArea']['fee'],$SVConfigs['price_format']);?>	
	</td>
<td width="16%" height="25" align="center" valign="middle" class="handel"><?if($v['ShippingArea']['free_subtotal'] > 0 ){?>
	<?=$svshow->price_format($v['ShippingArea']['free_subtotal'],$SVConfigs['price_format']);?>	
	<?}else{?>-<?}?></td>
</tr>
<?}?>
</table>
<br />
<?}else{?>
<p class="border_b" style='margin:0 10px;' align='center'><br /><br /><b>
	
	<?if(isset($shipping_type) && $shipping_type == 0){?>
	<?php echo $SCLanguages['edit_region_or_contact_cs'];?>
	<?}else{?>
	<?php echo $SCLanguages['no_shipping_method'];?>
	<?}?>
	
	</b><br /><br /><br /></p>
<?}?>