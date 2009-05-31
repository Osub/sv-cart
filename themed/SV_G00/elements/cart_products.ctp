<?php
/*****************************************************************************
 * SV-Cart 购物车页商品
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: cart_products.ctp 1883 2009-05-31 11:20:54Z huangbo $
*****************************************************************************/
?>
<?if(isset($svcart['products']) || isset($svcart['packagings']) || isset($svcart['cards'])){?>
<div class="Title_list">
<span class="Item_title"><?=$SCLanguages['purchased_products']?></span>
<span class="Price_title"><pre><?=$SCLanguages['price']?></pre></span>
<span class="Number_title"><?=$SCLanguages['products']?></span>
<span class="Sum_title"><?=$SCLanguages['subtotal']?></span>
</div>
<?}?>
<?if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>
<div class="List_bg">
<?foreach($svcart['products'] as $i=>$p){?>
<div id="Item_box">
<div class="Item_info" id="products_<?=$i;?>">
<?if(!empty($SVConfigs['enable_products_show_method']) && $SVConfigs['enable_products_show_method'] == 1){?>
<p class="pic">
<?if($p['Product']['img_thumb'] != ""){?>
<?=$html->link($html->image($p['Product']['img_thumb'],array("width"=>108,"height"=>108)),$svshow->sku_product_link($i,$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),"",false,false);?>
<?}else{?>
<?=$html->link($html->image("/img/product_default.jpg",array("width"=>108,"height"=>108)),$svshow->sku_product_link($i,$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),"",false,false);?>	
<?}?>
</p>
<?}?>
<p class="info">
<?if(isset($p['ProductI18n']['name'])){?>
<?
if(isset($p['attributes'])){
	$p_name = $p['ProductI18n']['name']." (".$p['attributes']." )";
}else{
	$p_name = $p['ProductI18n']['name'];
}
?>
<span><?=$html->link($p_name,$svshow->sku_product_link($i,$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></span>
<?}?>
<?if(isset($p['category_name'])){?>
<span>
		<?if(isset($p['use_sku'])){?>
			<?if(isset($p['parent'])){?>
			<?=$html->link($p['category_name'],"/categories/".$p['category_id']."/".$p['parent']."/".$p['category_name'],array(),false,false);?>
			<?}else{?>
			<?=$html->link($p['category_name'],"/categories/".$p['category_id']."/".$p['category_name']."/0/",array(),false,false);?>
			<?}?>
		<?}else{?>	
			<?=$html->link($p['category_name'],"/categories/".$p['category_id'],array(),false,false);?>
		<?}?>
</span>
<?}?>
<?if(isset($brands[$p['Product']['brand_id']])){?><span><?=$html->link($brands[$p['Product']['brand_id']]['BrandI18n']['name'],"/brands/".$p['Product']['brand_id']."/","",false,false);?></span><?}?>
</p>
</div>
<div class="Item_Price">

<span class="Products_Price">
<?=$SCLanguages['our_price']?>:<?if(isset($p['product_rank_price'])){?><?=$svshow->price_format($p['product_rank_price'],$SVConfigs['price_format']);?><?}else if(isset($p['is_promotion'])){?>
<? if($p['is_promotion'] == 1){ ?>
<?=$svshow->price_format($p['Product']['promotion_price'],$SVConfigs['price_format']);?>	
<? }else{ ?>
<?=$svshow->price_format($p['Product']['shop_price'],$SVConfigs['price_format']);?>	
	<? } ?>
<?}?>
</span>
<?if(false){?>
<span class="Price"><?//=$SCLanguages['membership_price']?>:
</span>
<?}?>
<span class="Price">
<?if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
	<?=$SCLanguages['market_price'].":";?>
<?=$svshow->price_format($p['Product']['market_price'],$SVConfigs['price_format']);?>	
		<br />
<?}?>
<?if($p['discount_price'] > 0){?>
<?=$SCLanguages['discount']?>:<?=$p['discount_rate']."%"; ?></span>
<span class="save"><?=$SCLanguages['save_to_market_price']?>:
<?=$svshow->price_format($p['discount_price'],$SVConfigs['price_format']);?>	
</span>
<?}else{?>
	</span>
<?}?>
</div>
<div class="Number_select">
<span class="top"><?=$html->link($html->image("ico_top.gif",array()),"javascript:quantity_change('product','+',".$i.")","",false,false);?></span>
<span class="Number" id="show_quantity_<?= $p['quantity']; ?>"><?= $p['quantity']; ?></span><input type="hidden" id="quantity_<?=$i?>" value="<?= $p['quantity']; ?>" />
<span class="bottom"><?=$html->link($html->image("ico_bottom.gif",array()),"javascript:quantity_change('product','-',".$i.")","",false,false);?></span>
</div>
<div class="Sums">
<span class="Number">
	<?=$svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?>	

	</span>
</div>
<div class="btn_list">
<a href="javascript:remove_product('product',<?=$i?>)"><span><?=$SCLanguages['delete']?></span></a>
	<?if(isset($_SESSION['User'])){?>
<a href="javascript:favorite(<?=$i?>,'p')"><span><?=$SCLanguages['favorite']?></span></a>
	<?}?>
<?=$html->link("<span>".$SCLanguages['detail']."</span>",$svshow->sku_product_link($i,$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),array(),false,false);?></div>
</div>
<?}?>
</div>
<? $st = 'ok';} if(isset($svcart['packagings']) && sizeof($svcart['packagings'])>0){?>
<div class="List_bg">
<?foreach($svcart['packagings'] as $i=>$p){?>
<div id="Item_box">
<div class="Item_info" id="products_<?=$i;?>">
<?if(!empty($SVConfigs['enable_products_show_method']) && $SVConfigs['enable_products_show_method'] == 1){?>
<p class="pic">
<?if($p['Packaging']['img01'] != ""){?>
<?=$html->image($p['Packaging']['img01'],array("width"=>108,"height"=>108));?>
<?}else{?>
<?=$html->image("/img/product_default.jpg",array("width"=>108,"height"=>108));?>
<?}?>
</p>
<?}?>
<p class="info">
<span><?php echo $p['PackagingI18n']['name'];?></span>
</p>
</div>
<div class="Item_Price">
<span class="Products_Price"><?=$SCLanguages['price']?>:
<?if(isset($p['Packaging']['fee_free'])){?>
<?=$svshow->price_format($p['Packaging']['fee_free'],$SVConfigs['price_format']);?>	
<?}else{?>
<?=$svshow->price_format($p['Packaging']['fee'],$SVConfigs['price_format']);?>	
<?}?>
</span>
<?if($p['Packaging']['free_money'] > 0){?>
<span class="Products_Price"><?=$SCLanguages['free'];?><?=$SCLanguages['limit'];?>:
<?=$svshow->price_format($p['Packaging']['free_money'],$SVConfigs['price_format']);?>	
</span>
<?}?>

</div>
<div class="Number_select">
 <span class="top"><?=$html->link($html->image("ico_top.gif",array()),"javascript:quantity_change('packaging','+',".$i.")","",false,false);?></span>
<span class="Number" id="show_quantity_<?= $p['quantity']; ?>"><?= $p['quantity']; ?></span><input type="hidden" id="quantity_<?=$i?>" value="<?= $p['quantity']; ?>" />
<span class="bottom"><?=$html->link($html->image("ico_bottom.gif",array()),"javascript:quantity_change('packaging','-',".$i.")","",false,false);?></span>
</div>
<div class="Sums">
<span class="Number">	<?=$svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?>	
</span>
</div>
<div class="btn_list">
<a href="javascript:remove_product('packaging',<?=$i?>)"><span><?=$SCLanguages['delete']?></span></a></div>
</div>
<?}?>
</div>
<? $st = 'ok';} if(isset($svcart['cards']) && sizeof($svcart['cards'])>0){?>
<div class="List_bg">
<?foreach($svcart['cards'] as $i=>$p){?>
<div id="Item_box">
<div class="Item_info" id="products_<?=$i;?>">
<?if(!empty($SVConfigs['enable_products_show_method']) && $SVConfigs['enable_products_show_method'] == 1){?>
<p class="pic">
<?if($p['Card']['img01'] != ""){?>
<?=$html->image($p['Card']['img01'],array("width"=>108,"height"=>108));?>
<?}else{?>
<?=$html->image("/img/product_default.jpg",array("width"=>108,"height"=>108));?>
<?}?>
</p>
<?}?>
<p class="info">
<span><?php echo $p['CardI18n']['name'];?></span>
</p>
</div>
<div class="Item_Price">
<span class="Products_Price"><?=$SCLanguages['price']?>:
<?if(isset($p['Card']['fee_free'])){?>
<?=$svshow->price_format($p['Card']['fee_free'],$SVConfigs['price_format']);?>	
<?}else{?>
<?=$svshow->price_format($p['Card']['fee'],$SVConfigs['price_format']);?>	
<?}?>
</span>
<?if($p['Card']['free_money'] > 0){?>
<span class="Products_Price"><?=$SCLanguages['free'];?><?=$SCLanguages['limit'];?>:
<?=$svshow->price_format($p['Card']['free_money'],$SVConfigs['price_format']);?>	
</span>
<?}?>	
	
	
</div>
<div class="Number_select">
 <span class="top"><?=$html->link($html->image("ico_top.gif",array()),"javascript:quantity_change('card','+',".$i.")","",false,false);?></span>
<span class="Number" id="show_quantity_<?= $p['quantity']; ?>"><?= $p['quantity']; ?></span><input type="hidden" id="quantity_<?=$i?>" value="<?= $p['quantity']; ?>" />
<span class="bottom"><?=$html->link($html->image("ico_bottom.gif",array()),"javascript:quantity_change('card','-',".$i.")","",false,false);?></span>
</div>
<div class="Sums">
<span class="Number">	<?=$svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?>	
</span>
</div>
<div class="btn_list">
<a href="javascript:remove_product('card',<?=$i?>)"><span><?=$SCLanguages['delete']?></span></a></div>
</div>
<?}?>
</div>
<? $st = 'ok';}if(empty($st)){?>
<br/><br/>
<? echo "<p class='not'>"?>
<?=$html->image('warning_img.gif',array('alt'=>''))?>
<?
echo "<strong>".$SCLanguages['no_products_in_cart']."</strong></p><br /><br /><br />";
}else{ ?>
<div id="balance">
<span><?=$SCLanguages['subtotal']?>:<font color="#ff0000">
<?=$svshow->price_format($svcart['cart_info']['sum_subtotal'],$SVConfigs['price_format']);?></font></span>
<?if($svcart['cart_info']['discount_price'] > 0){?>
<span><?=$SCLanguages['discount']?>:<?if(isset($svcart['cart_info']['discount_rate'])){?>
<?=$svcart['cart_info']['discount_rate'];?><?}else{?>100<?}?>%</span>
<span><?=$SCLanguages['save_to_market_price']?>:<font color="#ff0000"><?=$svshow->price_format($svcart['cart_info']['discount_price'],$SVConfigs['price_format']);?></font></span>
<?}?>
</div>
<?}?>