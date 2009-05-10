<?php
/*****************************************************************************
 * SV-Cart 结算页促销商品
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_promotion.ctp 1093 2009-04-28 04:02:04Z huangbo $
*****************************************************************************/
?>
<p class="address btn_list border_bottom">
<span class="l"></span><span class="r"></span>
<?=$SCLanguages['promotion'].$SCLanguages['activity'];?>:
</p>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align=center id="checkout_shipping_choice">
    <tr>
    <td class="lan-name first"><?php echo $SCLanguages['title'];?></td>
    <td class="lan-name first"><?php echo $SCLanguages['content'];?></td>
    <td class="lan-name first"><?php echo $SCLanguages['type'];?></td>
    <td class="lan-name first"><?php echo $SCLanguages['favorable_content'];?></td>
    </tr>
    
    <?if(isset($promotions) && sizeof($promotions)>0){?>
    
    <?foreach($promotions as $k=>$v){?>
    <tr><td class="lan-name first">
    <label for="radios<?echo $k?>">
    <?if($v['Promotion']['type'] == 0 || $v['Promotion']['type'] == 1){?>
    <input id="radios<?echo $k?>" type="radio" name="address_id" value="<?=$v['Promotion']['id'];?>" onclick="javascript:confirm_promotion(<?=$v['Promotion']['type'];?>,<?=$v['Promotion']['id']?>,<?=$v['Promotion']['type_ext']?>,'<?=$v['PromotionI18n']['title']?>','<?=$v['PromotionI18n']['meta_description']?>');" style='margin:-3px 3px 0 0;vertical-align:middle' />
    <?}?>
    <? echo $v['PromotionI18n']['title'];?>
     </label>
     </td>
    <td class="lan-name first"><? echo $v['PromotionI18n']['meta_description'];?> </td>
    <td class="lan-name first">
    <?if($v['Promotion']['type'] == 0){echo $SCLanguages['save_to_market_price'];}?>
    <?if($v['Promotion']['type'] == 1){echo $SCLanguages['discount'];}?>
    <?if($v['Promotion']['type'] == 2){echo $SCLanguages['favorable_products'];}?>
    </td>
    <td class="lan-name first">
    <?if($v['Promotion']['type'] == 0){
    echo "-"?>
	<?=$svshow->price_format($v['Promotion']['type_ext'],$SVConfigs['price_format']);?>	
    <?}?>
    <?if($v['Promotion']['type'] == 1){echo $v['Promotion']['type_ext']."%";}?>
    <?if(isset($v['products']) && count($v['products'])>0){?>
	<?if($v['Promotion']['type'] == 2){?>
		<?php printf($SCLanguages['chosen_products'],$v['Promotion']['type_ext']);?> 
	
	<?if(isset($v['products']) && sizeof($v['products'])>0){?>
	<?foreach($v['products'] as $key=>$value){ ?>
	<tr>
	    <td class="lan-name first"><input id="product_radios<?echo $key?>" type="checkbox" name="product_id" value="<?=$value['Product']['id'];?>" onclick="javascript:add_promotion_product(<?=$v['Promotion']['id']?>,<?=$value['Product']['id'];?>,<?=$value['Product']['now_fee']?>,'<?=$value['ProductI18n']['name']?>');" style='margin:-3px 3px 0 0;vertical-align:middle' /><?echo $value['ProductI18n']['name'];?></td>
	    <td class="lan-name first"></td>
   	    <td class="lan-name first"></td>   
	    <td class="lan-name first"><?php echo $SCLanguages['original_price'];?>
	<?=$svshow->price_format($value['Product']['market_price'],$SVConfigs['price_format']);?>	
	    -<?=$SCLanguages['current_price'];?>
	<?=$svshow->price_format($value['Product']['now_fee'],$SVConfigs['price_format']);?>	
	    </td>
    </tr>
	<?}?>
	<?}?>
	<?}}?>
</td>
</tr>
<?}}?>
	

</table>