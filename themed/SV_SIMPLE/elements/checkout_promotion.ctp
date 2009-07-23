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
 * $Id: checkout_promotion.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<p class="address btn_list border_bottom">
<span class="l"></span><span class="r"></span>
<?php echo $SCLanguages['promotion'].$SCLanguages['activity'];?>:
</p>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align=center id="checkout_shipping_choice" style="width:97.5%;">
    <tr>
    <td class="lan-name first"><?php echo $SCLanguages['title'];?></td>
    <td class="lan-name first"><?php echo $SCLanguages['content'];?></td>
    <td class="lan-name first"><?php echo $SCLanguages['type'];?></td>
    <td class="lan-name first"><?php echo $SCLanguages['favorable_content'];?></td>
    </tr>
    
    <?php if(isset($promotions) && sizeof($promotions)>0){?>
    
    <?php foreach($promotions as $k=>$v){?>
    <!--input type="hidden" name="promotion<?php echo $k?>"  value="<?php echo $k?>"-->
    <tr><td class="lan-name first">
    <label for="radios<?php echo $k?>">
    <?php if($v['Promotion']['type'] == 0 || $v['Promotion']['type'] == 1 ){?>
    <input id="radios<?php echo $k?>" type="radio" name="promotion_id" value="<?php echo $v['Promotion']['id'];?>"  
    	<?php if(!isset($SVConfigs['use_ajax']) || $SVConfigs['use_ajax'] == 1){?>
    	 onclick="javascript:confirm_promotion(<?php echo $v['Promotion']['type'];?>,<?php echo $v['Promotion']['id']?>,<?php echo $v['Promotion']['type_ext']?>,'<?php echo $v['PromotionI18n']['title']?>','<?php echo $v['PromotionI18n']['meta_description']?>');"
    	<?php }?>

    	 style='margin:-3px 3px 0 0;vertical-align:middle' autocomplete='off'/>
    <?php }else if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
    <input id="radios<?php echo $k?>" type="radio" name="promotion_id" value="<?php echo $v['Promotion']['id'];?>"  
    		     	<?php if(!isset($SVConfigs['use_ajax']) || $SVConfigs['use_ajax'] == 1){?>
    	 onclick="javascript:confirm_promotion(<?php echo $v['Promotion']['type'];?>,<?php echo $v['Promotion']['id']?>,<?php echo $v['Promotion']['type_ext']?>,'<?php echo $v['PromotionI18n']['title']?>','<?php echo $v['PromotionI18n']['meta_description']?>');"
    	<?php }?>

    	 style='margin:-3px 3px 0 0;vertical-align:middle' autocomplete='off' />
    <?php }?>
    <?php echo $v['PromotionI18n']['title'];?>
     </label>
     </td>
    <td class="lan-name first"><?php echo $v['PromotionI18n']['meta_description'];?> </td>
    <td class="lan-name first">
    <?php if($v['Promotion']['type'] == 0){echo $SCLanguages['save_to_market_price'];}?>
    <?php if($v['Promotion']['type'] == 1){echo $SCLanguages['discount'];}?>
    <?php if($v['Promotion']['type'] == 2){echo $SCLanguages['favorable_products'];}?>
    </td>
    <td class="lan-name first">
    <?php if($v['Promotion']['type'] == 0){
    echo "-"?>
	<?php echo $svshow->price_format($v['Promotion']['type_ext'],$SVConfigs['price_format']);?>	
    <?php }?>
    <?php if($v['Promotion']['type'] == 1){echo $v['Promotion']['type_ext']."%";}?>
    <?php if(isset($v['products']) && count($v['products'])>0){?>
	<?php if($v['Promotion']['type'] == 2){?>
		<?php printf($SCLanguages['chosen_products'],$v['Promotion']['type_ext']);?> 
	
	<?php if(isset($v['products']) && sizeof($v['products'])>0){?>
	<?php $num = 0;?><input type="hidden" name="p_num" id="p_num<?php echo $v['Promotion']['id']?>" value="0" autocomplete="off"/>
	<?php foreach($v['products'] as $key=>$value){ ?>
	<tr>
	    <td class="lan-name first"><input id="product_radios<?php echo $v['Promotion']['id']?><?php echo $num?>" type="checkbox" name="product_id[<?php echo $v['Promotion']['id']?>][<?php echo $value['Product']['id'];?>]" value="<?php echo $value['Product']['id'];?>"
    	<?php if(!isset($SVConfigs['use_ajax']) || $SVConfigs['use_ajax'] == 1){?> 
	    onclick="javascript:add_promotion_product(<?php echo $v['Promotion']['id']?>,<?php echo $value['Product']['id'];?>,<?php echo $value['Product']['now_fee']?>,'<?php echo $value['ProductI18n']['name']?>');"
	    <?php }else{?>
	   	<?php 
	   		if(isset($_SESSION['promotion']['products']) && sizeof($_SESSION['promotion']['products'])>0){
	   			foreach($_SESSION['promotion']['products'] as $s=>$l){
	   				if($s == $value['Product']['id']){
	   				echo "checked";
	   				}
	   			}
	   		}
	   	?>
	    onclick="javascript:select_promotion_product(<?php echo $v['Promotion']['id']?>,<?php echo $k?>,<?php echo $v['Promotion']['type_ext']?>,this);"
	    <?php }?>
	    	 style='margin:-3px 3px 0 0;vertical-align:middle' autocomplete='off' /><?php echo $value['ProductI18n']['name'];?></td><?php $num++;?>
	    <td class="lan-name first"></td>
   	    <td class="lan-name first"></td>   
	    <td class="lan-name first"><?php echo $SCLanguages['original_price'];?>
	<?php echo $svshow->price_format($value['Product']['market_price'],$SVConfigs['price_format']);?>	
	    -<?php echo $SCLanguages['current_price'];?>
	<?php echo $svshow->price_format($value['Product']['now_fee'],$SVConfigs['price_format']);?>	
	    </td>
    </tr>
	<?php }?>
	<?php }?>
	<?php }}?>
</td>
</tr>
<?php }}?>
	

</table>