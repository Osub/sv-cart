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
 * $Id: checkout_total.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<p class="item_price">
<font><?php echo $SCLanguages['products'].$SCLanguages['total'];?></font>: 
	<?php echo $svshow->price_format($svcart['cart_info']['sum_subtotal'],$SVConfigs['price_format']);?>	
<?php if(isset($svcart['shipping']['shipping_fee'])){?>
<span class="send_menny"><?php echo $SCLanguages['shipping_fee'];?>:
<?php echo $svshow->price_format($svcart['shipping']['shipping_fee'],$SVConfigs['price_format']);?>	
</span><?php }?>
<?php if(isset($svcart['shipping']['insure_fee']) && $svcart['shipping']['insure_fee'] >0){?>
<span class="send_menny"><?php echo $SCLanguages['support_value_fee']?>:
<?php echo $svshow->price_format($svcart['shipping']['insure_fee'],$SVConfigs['price_format']);?>	
</span><?php }else{
	$svcart['shipping']['insure_fee'] = 0;
}?>	
<?php if(isset($svcart['payment']['payment_fee'])){?>
<span class="send_menny">
<?php echo $SCLanguages['payment_fee'];?>:
	<?php echo $svshow->price_format($svcart['payment']['payment_fee'],$SVConfigs['price_format']);?>	
</span>
<?php }?>
<?php if(isset($svcart['promotion']['type'])){?>
<span class="send_menny">
<?php if($svcart['promotion']['type'] == 0){?>
<?php echo $SCLanguages['promotion'];?>:<?php echo $SCLanguages['save_to_market_price'];?>
	<?php echo $svshow->price_format($svcart['promotion']['promotion_fee'],$SVConfigs['price_format']);?>	
<?php }?>
<?php if($svcart['promotion']['type'] == 1){?>
<?php echo $SCLanguages['promotion'];?>:<?php echo $SCLanguages['discount'];?> <?php echo $svcart['promotion']['promotion_fee'];?>%
<?php }?>
<?php if($svcart['promotion']['type'] == 2){?>
<?php echo $SCLanguages['promotion'];?><?php echo $SCLanguages['products'];?><?php echo $SCLanguages['fee'];?>:
	<?php echo $svshow->price_format($svcart['promotion']['product_fee'],$SVConfigs['price_format']);?>	
<?php }?>
</span>
<?php }?>
<?php if(isset($svcart['point']['fee'])){?>
<span class="send_menny">
<?php echo $SCLanguages['offset_point']?>:
	<?php echo $svshow->price_format($svcart['point']['fee'],$SVConfigs['price_format']);?>	
</span>
<?php }?>
<?php if(isset($svcart['coupon']['fee'])){?>
<span class="send_menny">
<?php echo $SCLanguages['coupon']?>:
	<?php echo $svshow->price_format($svcart['coupon']['fee'],$SVConfigs['price_format']);?>	
</span>
<?php if($svcart['coupon']['discount'] < 100){?>	
<span class="send_menny">
<?php echo $SCLanguages['coupon']?><?php echo $SCLanguages['discount']?>:
	<?php echo $svcart['coupon']['discount'];?>
</span>
<?php }?>	
<?php }?>

<?php if(isset($svcart['cart_info']['total'])){?>
	<span class="sum_meny"><?php echo $SCLanguages['total'];?>: 
	<?php echo $svshow->price_format($svcart['cart_info']['total'],$SVConfigs['price_format']);?>	
		</span>
<?php }?>
</p>