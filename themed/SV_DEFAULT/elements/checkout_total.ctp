<?php 
/*****************************************************************************
 * SV-Cart 结算页金额
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_total.ctp 3158 2009-07-21 10:30:28Z huangbo $
*****************************************************************************/
?>
<div class="item_price bgcolor_e">
<table style="width:auto;" align="right">
<tr>
	<td width="70" class="font_14"><?php echo $SCLanguages['products'].$SCLanguages['total'];?>: </td>
	<td width="100" align="right"><?php echo $svshow->price_format($svcart['cart_info']['sum_subtotal'],$SVConfigs['price_format']);?></td>
</tr>
<?php if(isset($svcart['shipping']['shipping_fee'])){?>
<tr>
	<td><?php echo $SCLanguages['shipping_fee'];?>:</td>
	<td align="right"><?php echo $svshow->price_format($svcart['shipping']['shipping_fee'],$SVConfigs['price_format']);?></td>
</span>
</tr>
<?php }?>

<?php if(isset($svcart['shipping']['insure_fee_confirm']) && $svcart['shipping']['insure_fee_confirm'] >0){?>
<tr>
	<td class="font_14"><?php echo $SCLanguages['support_value_fee']?>:</td>
	<td align="right"><?php echo $svshow->price_format($svcart['shipping']['insure_fee_confirm'],$SVConfigs['price_format']);?></td>
</tr>
<?php }else{
	$svcart['shipping']['insure_fee_confirm'] = 0;
}?>	

<?php if(isset($svcart['payment']['payment_fee'])){?>
<tr>
	<td class="font_14"><?php echo $SCLanguages['payment_fee'];?>:</td>
	<td align="right"><?php echo $svshow->price_format($svcart['payment']['payment_fee'],$SVConfigs['price_format']);?></td>
</span>
</tr>
<?php }?>
<?php if(isset($svcart['promotion']['type'])){?>
<tr>

<?php if($svcart['promotion']['type'] == 0){?>
	<td class="font_14"><?php echo $SCLanguages['promotion'];?>:</td>
	<td align="right"><?php echo $SCLanguages['save_to_market_price'];?><?php echo $svshow->price_format($svcart['promotion']['promotion_fee'],$SVConfigs['price_format']);?></td>
<?php }?>
<?php if($svcart['promotion']['type'] == 1){?>
	<td class="font_14"><?php echo $SCLanguages['promotion'];?>:</td>
	<td align="right"><?php echo $SCLanguages['discount'];?> <?php echo $svcart['promotion']['promotion_fee'];?>%</td>
<?php }?>
<?php if($svcart['promotion']['type'] == 2){?>
	<td><?php echo $SCLanguages['promotion'];?><?php echo $SCLanguages['products'];?><?php echo $SCLanguages['fee'];?>:</td>
	<td align="right"><?php echo $svshow->price_format($svcart['promotion']['product_fee'],$SVConfigs['price_format']);?></td>
<?php }?>
</tr>
<?php }?>
<?php if(isset($svcart['point']['fee'])){?>
<tr>
	<td class="font_14"><?php echo $SCLanguages['offset_point']?>:</td>
	<td align="right"><?php echo $svshow->price_format($svcart['point']['fee'],$SVConfigs['price_format']);?></td>
</tr>
<?php }?>
<?php if(isset($svcart['coupon']['fee'])){?>
<tr>
	<td class="font_14"><?php echo $SCLanguages['coupon']?>:</td>
	<td align="right"><?php echo $svshow->price_format($svcart['coupon']['fee'],$SVConfigs['price_format']);?></td>
<?php if($svcart['coupon']['discount'] < 100){?>	
	<td><?php echo $SCLanguages['coupon']?><?php echo $SCLanguages['discount']?>:</td>
	<td align="right"><?php echo $svcart['coupon']['discount'];?></td>
<?php }?>	
</tr>
<?php }?>

</table>
</div>
<div class="item_price">
<table style="width:auto;" align="right">
<?php if(isset($svcart['cart_info']['total'])){?>
<tr class="sum_meny">
	<td width="70"><strong class="font_14"><?php echo $SCLanguages['total'];?>:</strong></td>
	<td width="100" align="right"><strong><?php echo $svshow->price_format($svcart['cart_info']['total'],$SVConfigs['price_format']);?></strong></td>
</tr>
<?php }?>

</table>	
</div>