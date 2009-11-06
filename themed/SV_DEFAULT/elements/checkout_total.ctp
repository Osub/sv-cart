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
 * $Id: checkout_total.ctp 4433 2009-09-22 10:08:09Z huangbo $
*****************************************************************************/
?>
<div class="height_5">&nbsp;</div>
<div class="total_box">
<div class="border_line">&nbsp;</div>
<table width="100%">
<tr>
<td width="50%" valign="bottom">
	<table align="left" class="total_table">
	<tr class="font_color_1">
		<?php if(isset($send_point['order_smallest'])){?>
		<?php if($send_point['order_smallest'] > 0){?>
		<td width="203"><?php echo $SCLanguages['more_than_order_total']?>
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php echo $svshow->price_format($send_point['order_smallest_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
		<?php }else{?>
		<?php echo $svshow->price_format($send_point['order_smallest_fee'],$this->data['configs']['price_format']);?>	
		<?php }?>				 	 
		<?php echo $SCLanguages['present_points']?> ：
		</td>
		<td><?php echo $send_point['order_smallest']?> <?php echo $SCLanguages['point_unit'];?></td>
		<?php }?>
		<?php }?>
	</tr>
	<tr class="font_color_1">
		<?php if(isset($send_point['order_gift_points'])){?>
		<?php if($send_point['order_gift_points'] > 0){?>
		<td><?php echo $SCLanguages['place_order']?><?php echo $SCLanguages['present_points']?> ：</td>
		<td><?php echo $send_point['order_gift_points']?> <?php echo $SCLanguages['point_unit'];?></td>
		<?php }?>
		<?php }?>
	</tr>
	<?php if(isset($product_point) && sizeof($product_point)>0){?>
	<?php foreach($product_point as $kk=>$vv){?>
	<tr class="font_color_1">
		
		<?php if($vv['point'] > 0){?>
		<td><?php echo $vv['name']?> <?php echo $SCLanguages['present_points']?>：</td>
		<td><?php echo $vv['point']?> <?php echo $SCLanguages['point_unit'];?></td>
		<?php }?>
	</tr>
	<?php }?>
	<?php }?>

		<?php if(isset($order_coupon) && sizeof($order_coupon)>0){?>
		<?php foreach($order_coupon as $k=>$v){?>

		<?php if($v['fee'] > 0){?>
	<tr class="font_color_1">
		<td><?php echo $SCLanguages['more_than_order_total']?><?php echo $SCLanguages['present_coupons']?> ：</td>
		<td><?php echo $v['name']?>
		<?//php echo $svshow->price_format($v['fee'],$SVConfigs['price_format']);?>
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>

		<?php echo $svshow->price_format($v['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>
		</td>
		<?php }else{?>
		<?php echo $svshow->price_format($v['fee'],$this->data['configs']['price_format']);?></td>
		<?php }?>			
	</tr>
		<?php }?>
		<?php }?>
		
		<?php }?>


		<?php if(isset($product_coupon) && sizeof($product_coupon)>0){?>
		<?php foreach($product_coupon as $kk=>$vv){?>
		<tr class="font_color_1">
		<?php if($vv['fee'] > 0){?>
		<td><?php echo $vv['name']?> <?php echo $SCLanguages['present_coupons']?> ：</td>
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<td><?php echo $svshow->price_format($vv['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?></td>
		<?php }else{?>
		<td><?php echo $svshow->price_format($vv['fee'],$this->data['configs']['price_format']);?></td>
		<?php }?>
		
		<?php if($vv['quantity']>1){?><td><?php echo $vv['quantity']?></td><?php }?>
		<?php }?>
		</tr>
		<?php }?>
		<?php }?>
		<?php if(isset($checkout_total_point)){?>
		<tr valign="bottom">
		<td class="font_14" height="34"><strong><?php echo $this->data['languages']['total_points']?>：</strong></td>
		<td><strong><?php echo $checkout_total_point;?> <?php echo $SCLanguages['point_unit'];?></strong></td>
		</tr>
		<?php }?>		
			
		</table>
	</td>
	<td width="50%" valign="bottom">
	<table align="right" class="total_table">
	<tr class="font_color_1">
		<td width="106"><?php echo $SCLanguages['products'].$SCLanguages['total'];?>：</td>
		<td align="right">
		
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format(round($svcart['cart_info']['sum_subtotal']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],2),$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
		<?php }else{?>
			<?php echo $svshow->price_format($svcart['cart_info']['sum_subtotal'],$this->data['configs']['price_format']);?>	
		<?php }?>			
		</td>
		
	</tr>
	<?php if(isset($svcart['shipping']['shipping_fee'])){?>
	<tr class="font_color_1">
		<td><?php echo $SCLanguages['shipping_fee'];?>：</td>
		<td align="right"><?//php echo $svshow->price_format($svcart['shipping']['shipping_fee'],$SVConfigs['price_format']);?>
		
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format(round($svcart['shipping']['shipping_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],2),$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
		<?php }else{?>
			<?php echo $svshow->price_format($svcart['shipping']['shipping_fee'],$this->data['configs']['price_format']);?>	
		<?php }?>	
		
		</td>
	</span>
	</tr>
	<?php }?>
	<?php if(isset($svcart['shipping']['insure_fee_confirm']) && $svcart['shipping']['insure_fee_confirm'] >0){?>
	<tr class="font_color_1">
		<td><?php echo $SCLanguages['support_value_fee']?>：</td>
		<td align="right"><?//php echo $svshow->price_format($svcart['shipping']['insure_fee_confirm'],$SVConfigs['price_format']);?>
		
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format(round($svcart['shipping']['insure_fee_confirm']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],2),$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
		<?php }else{?>
			<?php echo $svshow->price_format($svcart['shipping']['insure_fee_confirm'],$this->data['configs']['price_format']);?>	
		<?php }?>		
		
		</td>
	</tr>
	<?php }else{
		$svcart['shipping']['insure_fee_confirm'] = 0;
	}?>	
	<?php if(isset($svcart['payment']['payment_fee'])){?>
	<tr class="font_color_1">
		<td><?php echo $SCLanguages['payment_fee'];?>：</td>
		<td align="right"><?//php echo $svshow->price_format($svcart['payment']['payment_fee'],$SVConfigs['price_format']);?>
		
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format(round($svcart['payment']['payment_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],2),$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
		<?php }else{?>
			<?php echo $svshow->price_format($svcart['payment']['payment_fee'],$this->data['configs']['price_format']);?>	
		<?php }?>		
		</td>
	</tr>
	<?php }?>
			
	<?php if(isset($svcart['invoice']['fee'])){?>
	<tr class="font_color_1">
		<td><?php echo $SCLanguages['invoice_fee'];?>：</td>
		<td align="right"><?//php echo $svshow->price_format($svcart['payment']['payment_fee'],$SVConfigs['price_format']);?>
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format(round($svcart['invoice']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],2),$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
		<?php }else{?>
			<?php echo $svshow->price_format($svcart['invoice']['fee'],$this->data['configs']['price_format']);?>	
		<?php }?>		
		</td>
	</tr>
	<?php }?>			
			
			
<?php if(isset($svcart['promotion']['type'])){?>
<tr class="font_color_1">
<?php if($svcart['promotion']['type'] == 0){?>
	<td><?php echo $SCLanguages['promotion'];?>：</td>
	<td align="right"><?php echo $SCLanguages['save_to_market_price'];?>
	<?//php echo $svshow->price_format($svcart['promotion']['promotion_fee'],$SVConfigs['price_format']);?>
	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format(round($svcart['promotion']['promotion_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],2),$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
	<?php }else{?>
	<?php echo $svshow->price_format($svcart['promotion']['promotion_fee'],$this->data['configs']['price_format']);?>	
	<?php }?>			
	</td>
<?php }?>
<?php if($svcart['promotion']['type'] == 1){?>
	<td><?php echo $SCLanguages['promotion'];?>：</td>
	<td align="right"><?php echo $SCLanguages['discount'];?> <?php echo $svcart['promotion']['promotion_fee'];?>%
	(-<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php echo $svshow->price_format(round(($svcart['cart_info']['sum_subtotal']/100)*$svcart['promotion']['promotion_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],2),$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
	<?php }else{?>
		<?php echo $svshow->price_format(round(($svcart['cart_info']['sum_subtotal']/100)*$svcart['promotion']['promotion_fee']),$this->data['configs']['price_format']);?>	
	<?php }?>)		
	</td>
<?php }?>
<?php if($svcart['promotion']['type'] == 2){?>
	<td><?php echo $SCLanguages['promotion'];?><?php echo $SCLanguages['products'];?><?php echo $SCLanguages['fee'];?>：</td>
	<td align="right"><?//php echo $svshow->price_format($svcart['promotion']['product_fee'],$SVConfigs['price_format']);?>
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format(round($svcart['promotion']['product_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],2),$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
		<?php }else{?>
			<?php echo $svshow->price_format($svcart['promotion']['product_fee'],$this->data['configs']['price_format']);?>	
		<?php }?>			
		
		</td>
<?php }?>
</tr>
<?php }?>

<?php if(isset($svcart['point']['fee'])){?>
<tr class="font_color_1">
	<td><?php echo $SCLanguages['offset_point']?>：</td>
	<td align="right">
	
	<?//php echo $svshow->price_format($svcart['point']['fee'],$SVConfigs['price_format']);?>
	
	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format(round($svcart['point']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],2),$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
	<?php }else{?>
		<?php echo $svshow->price_format($svcart['point']['fee'],$this->data['configs']['price_format']);?>	
	<?php }?>		
	</td>
</tr>
<?php }?>
<?php if(isset($svcart['coupon']['fee'])){?>
<tr class="font_color_1">
	<td><?php echo $SCLanguages['coupon']?>：</td>
	<td align="right">
	<?//php echo $svshow->price_format($svcart['coupon']['fee'],$SVConfigs['price_format']);?>
	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
	<?php echo $svshow->price_format(round($svcart['coupon']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],2),$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
	<?php }else{?>
		<?php echo $svshow->price_format($svcart['coupon']['fee'],$this->data['configs']['price_format']);?>	
	<?php }?>	
	</td>
<?php if($svcart['coupon']['discount'] < 100){?>	
	<td><?php echo $SCLanguages['coupon']?><?php echo $SCLanguages['discount']?>：</td>
	<td align="right"><?php echo $svcart['coupon']['discount'];?></td>
<?php }?>	
</tr>
<?php }?>
	<?php if(isset($svcart['cart_info']['total'])){?>
	<tr valign="bottom">
	<td height="34" class="font_14"><strong><?php echo $SCLanguages['total'];?>：</strong></td>
	<td align="right"><strong>
	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format(round($svcart['cart_info']['total']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],2),$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
		<?php }else{?>
			<?php echo $svshow->price_format($svcart['cart_info']['total'],$this->data['configs']['price_format']);?>	
		<?php }?>		
	</strong></td>

	</tr>
<?php }?>

		
	</table>

	</td>
</tr>



</table>
</div>