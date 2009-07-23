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
 * $Id: checkout_shipping.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<?php if(isset($shippings) && is_array($shippings) && sizeof($shippings)>0){?>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice">
<tr class="send_title bgcolor_e">
<td height="25" align="center"><?php echo $SCLanguages['name'];?></td>
<td height="25" align="center"><?php echo $SCLanguages['description'];?></td>
<td height="25" align="center"><?php echo $SCLanguages['cost'];?></td>
<td height="25" align="center"><?php echo $SCLanguages['free'].$SCLanguages['limit'];?></td>
<td height="25" align="center"  <?php if(!isset($SVConfigs['use_ajax'])|| $SVConfigs['use_ajax'] == 1){ ?>class="handel"<?php }?>><?php echo $SCLanguages['support_value_fee']?></td>
<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
<td height="25" align="center" class="handel"><?php echo $SCLanguages['support_value_or_not']?></td>
<?php }?></tr>
<?php foreach($shippings as $k=>$v){?>
<tr class="list">
<td width="20%" height="25" valign="middle" class="selece_input">
<span class="select_input">
	<input type="radio" name="shipping_id" value="<?php echo $v['Shipping']['id'];?>" 
		<?php 
	if(isset($svcart['shipping']['shipping_id']) && $svcart['shipping']['shipping_id'] == $v['Shipping']['id']){
		echo "checked";
	}		
		if((!isset($SVConfigs['use_ajax'])) || $SVConfigs['use_ajax'] == 1){
	?>

	onclick="confirm_shipping_insure(<?php echo $v['Shipping']['id'];?>,<?php echo $v['ShippingArea']['fee']; ?>,<?php echo $v['ShippingArea']['free_subtotal']; ?>,<?php echo $v['Shipping']['support_cod']?>,<?php echo $v['Shipping']['insure_fee']?>)"	<?php }?>
 <?php if(isset($svcart['shipping']['shipping_id']) && $v['Shipping']['id'] ==$svcart['shipping']['shipping_id']){?>checked="checked"<?php }?> id="shipping_id<?php echo $v['Shipping']['id'];?>" class="radio" /></span>
	<label for="shipping_id<?php echo $v['Shipping']['id'];?>"><span class="name"><?php echo $v['ShippingI18n']['name']; ?></span></label></td>
<td width="30%" height="25" valign="middle" class="bewrite"><?php echo $v['ShippingI18n']['description']; ?></td>
<td width="14%" height="25" align="center" valign="middle" class="addrees">
	<?php echo $svshow->price_format($v['ShippingArea']['fee'],$SVConfigs['price_format']);?>	
	</td>
<td width="10%" height="25" align="center" valign="middle" class="addrees"><?php if($v['ShippingArea']['free_subtotal'] > 0 ){?>
	<?php echo $svshow->price_format($v['ShippingArea']['free_subtotal'],$SVConfigs['price_format']);?>	
	<?php }else{?>-<?php }?></td>
<td width="13%" height="25" align="center" <?php if(!isset($SVConfigs['use_ajax'])|| $SVConfigs['use_ajax'] == 1){ ?>class="handel"<?php }else{?> class="addrees"<?php }?>>
<?php if($v['Shipping']['insure_fee']>0){?>
	<?php echo $svshow->price_format($v['Shipping']['insure_fee'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $SCLanguages['no_support_value']?>
<?php }?>
</td>
<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
<td width="13%" height="25" align="center" class="handel">
<?php if($v['Shipping']['insure_fee']>0){?>
		<input type="radio" name="shipping_id_insure" value="<?php echo $v['Shipping']['id'];?>"  />
	<?php }else{?>
		-
	<?php }?>
</td>	
<?php }?>
</tr>
<?php }?>
</table>
<br />
<?php }else{?>
<p class="border_b" style='margin:0 10px;' align='center'><br /><br /><b>
	
	<?php if(isset($shipping_type) && $shipping_type == 0){?>
	<?php echo $SCLanguages['edit_region_or_contact_cs'];?>
	<?php }else{?>
	<?php echo $SCLanguages['no_shipping_method'];?>
	<?php }?>
	
	</b><br /><br /><br /></p>
<?php }?>