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
 * $Id: checkout_total.ctp 1201 2009-05-05 13:30:17Z huangbo $
*****************************************************************************/
?>
<p class="item_price">
<font><?=$SCLanguages['products'].$SCLanguages['total'];?></font>: 
	<?=$svshow->price_format($svcart['cart_info']['sum_subtotal'],$SVConfigs['price_format']);?>	
<?if(isset($svcart['shipping']['shipping_fee'])){?>
<span class="send_menny"><?php echo $SCLanguages['shipping_fee'];?>:
	<?=$svshow->price_format($svcart['shipping']['shipping_fee'],$SVConfigs['price_format']);?>	
	</span><?}?>
<?if(isset($svcart['payment']['payment_fee'])){?>
<span class="send_menny">
<?php echo $SCLanguages['payment_fee'];?>:
	<?=$svshow->price_format($svcart['payment']['payment_fee'],$SVConfigs['price_format']);?>	
</span>
<?}?>
<?if(isset($svcart['promotion']['type'])){?>
<span class="send_menny">
<?if($svcart['promotion']['type'] == 0){?>
<?php echo $SCLanguages['promotion'];?>:<?php echo $SCLanguages['save_to_market_price'];?>
	<?=$svshow->price_format($svcart['promotion']['promotion_fee'],$SVConfigs['price_format']);?>	
<?}?>
<?if($svcart['promotion']['type'] == 1){?>
<?php echo $SCLanguages['promotion'];?>:<?php echo $SCLanguages['discount'];?> <?=$svcart['promotion']['promotion_fee'];?>%
<?}?>
<?if($svcart['promotion']['type'] == 2){?>
<?=$SCLanguages['promotion'];?><?=$SCLanguages['products'];?><?=$SCLanguages['fee'];?>:
	<?=$svshow->price_format($svcart['promotion']['product_fee'],$SVConfigs['price_format']);?>	
<?}?>
</span>
<?}?>
<?if(isset($svcart['point']['fee'])){?>
<span class="send_menny">
<?=$SCLanguages['offset_point']?>:
	<?=$svshow->price_format($svcart['point']['fee'],$SVConfigs['price_format']);?>	
</span>
<?}?>
<?if(isset($svcart['coupon']['fee'])){?>
<span class="send_menny">
<?=$SCLanguages['coupon']?>:
	<?=$svshow->price_format($svcart['coupon']['fee'],$SVConfigs['price_format']);?>	
</span>
<?if($svcart['coupon']['discount'] < 100){?>	
<span class="send_menny">
<?=$SCLanguages['coupon']?><?=$SCLanguages['discount']?>:
	<?=$svcart['coupon']['discount'];?>
</span>
<?}?>	
<?}?>

<?if(isset($svcart['cart_info']['total'])){?>
	<span class="sum_meny"><?php echo $SCLanguages['total'];?>: 
	<?=$svshow->price_format($svcart['cart_info']['total'],$SVConfigs['price_format']);?>	
		</span>
<?}?>
</p>