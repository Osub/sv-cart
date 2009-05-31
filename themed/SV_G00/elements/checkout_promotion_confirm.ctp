<?php
/*****************************************************************************
 * SV-Cart 结算页促销商品选定
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_promotion_confirm.ctp 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
?>
<p class="address btn_list border_bottom">
<span class="l"></span><span class="r"></span>
	<a href="javascript:change_promotion();" class="amember"><span><?=$SCLanguages['mmodify']?></span></a>

	<?=$SCLanguages['promotion'].$SCLanguages['activity'];?>：
</p>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align=center id="checkout_shipping_choice" style="width:97.5%;">
    <tr>
    <td class="lan-name first"><?php echo $SCLanguages['title'];?></td>
    <td class="lan-name first"><?php echo $SCLanguages['content'];?></td>
    <td class="lan-name first"><?php echo $SCLanguages['type'];?></td>
    <td class="lan-name first"><?php echo $SCLanguages['favorable_content'];?></td>
    </tr>
    <td class="lan-name first"><? echo $svcart['promotion']['title'];?> </td>
    <td class="lan-name first"><? echo $svcart['promotion']['meta_description'];?> </td>
    <td class="lan-name first">
    <?if($svcart['promotion']['type'] == 0){echo $SCLanguages['save_to_market_price'];}?>
    <?if($svcart['promotion']['type'] == 1){echo $SCLanguages['discount'];}?>
    <?if($svcart['promotion']['type'] == 2){echo $SCLanguages['favorable_products'];}?>
    </td>
    <td class="lan-name first">	

    <?if($svcart['promotion']['type'] == 0){echo "-";?><?=$svshow->price_format($svcart['promotion']['promotion_fee'],$SVConfigs['price_format']);?><?}?>
    <?if($svcart['promotion']['type'] == 1){echo $svcart['promotion']['promotion_fee']."%";}?>
	<?if(isset($svcart['promotion']['Promotion']['type']) && $svcart['promotion']['Promotion']['type'] == 2){?>
<?php printf($SCLanguages['chosen_products'],$svcart['promotion']['Promotion']['type_ext']);?> 
	<?if(isset($svcart['Product_by_Promotion']) && sizeof($svcart['Product_by_Promotion'])>0){?>
	<?foreach($svcart['Product_by_Promotion'] as $kk=>$vv){ ?>
	<tr>
	    <td class="lan-name first"><?echo $vv['ProductI18n']['name'];?></td>
	    <td class="lan-name first"></td>
   	    <td class="lan-name first"></td>   
	    <td class="lan-name first"><?php echo $SCLanguages['original_price'];?><?=$svshow->price_format($vv['Product']['market_price'],$SVConfigs['price_format']);?> -<?=$SCLanguages['current_price'];?><?=$svshow->price_format($vv['Product']['now_fee'],$SVConfigs['price_format']);?></td>
    </tr>
	<?}?>
	<?}?>
	
	<?if(isset($svcart['promotion']['products']) && sizeof($svcart['promotion']['products'])){?>
	<?foreach($svcart['promotion']['products'] as $key=>$value){ ?>
	<tr>
	    <td class="lan-name first"><input id="product_radios<?echo $key?>" type="checkbox" name="product_id" value="<?=$value['Product']['id'];?>" onclick="javascript:add_promotion_product(<?=$svcart['promotion']['id']?>,<?=$value['Product']['id'];?>,<?=$value['Product']['now_fee']?>,'<?=$value['ProductI18n']['name']?>');" style='margin:-3px 3px 0 0;vertical-align:middle' /><?echo $value['ProductI18n']['name'];?></td>
	    <td class="lan-name first"></td>
   	    <td class="lan-name first"></td>   
	    <td class="lan-name first"><?php echo $SCLanguages['original_price'];?><?=$svshow->price_format($value['Product']['market_price'],$SVConfigs['price_format']);?> -<?=$SCLanguages['current_price'];?><?=$svshow->price_format($value['Product']['now_fee'],$SVConfigs['price_format']);?></td>
    </tr>
	<?}?><?}?>
	
<?}?>
</td>
</tr>
</table>