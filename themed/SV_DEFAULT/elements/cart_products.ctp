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
 * $Id: cart_products.ctp 3113 2009-07-20 11:14:34Z huangbo $
*****************************************************************************/
?>
<?php if(isset($svcart['products']) || isset($svcart['packagings']) || isset($svcart['cards'])){?>
<div class="Title_list">
	<span class="Item_title"><?php echo $SCLanguages['purchased_products']?></span>
	<span class="Price_title"><pre><?php echo $SCLanguages['price']?></pre></span>
	<span class="Number_title"><?php echo $SCLanguages['products']?></span>
	<span class="Sum_title"><?php echo $SCLanguages['subtotal']?></span>
</div>
<?php }?>
<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>
<div class="List_bg">
<?php foreach($svcart['products'] as $i=>$p){?>
<div id="Item_box">
<div class="Item_info" id="products_<?php echo $i;?>">
<?php if(!empty($SVConfigs['enable_products_show_method']) && $SVConfigs['enable_products_show_method'] == 1){?>
<p class="pic">
<?php if($p['Product']['img_thumb'] != ""){?>
<?php echo $html->link($html->image($p['Product']['img_thumb'],array("width"=>108,"height"=>108)),$svshow->sku_product_link($p['Product']['id'],$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),"",false,false);?>
<?php }else{?>
<?php echo $html->link($html->image("/img/product_default.jpg",array("width"=>108,"height"=>108)),$svshow->sku_product_link($p['Product']['id'],$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),"",false,false);?>	
<?php }?>
</p>
<?php }?>
<p class="info">
<?php if(isset($p['ProductI18n']['name'])){?>
<?php 
if(isset($p['attributes']) && $p['attributes'] != ""){
	$p_name = $p['ProductI18n']['name']." (".$p['attributes']." )";
}else{
	$p_name = $p['ProductI18n']['name'];
}
?>
<span><?php echo $html->link($p_name,$svshow->sku_product_link($p['Product']['id'],$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></span>
<?php }?>
<?php if(isset($p['category_name'])){?>
<span>
		<?php 
		$categories_url = str_replace(" ","-",$p['category_name']);
		$categories_url = str_replace("/","-",$categories_url);
		?>
		<?php if(isset($p['use_sku'])){?>
			<?php if(isset($p['parent'])){?>
			<?php echo $html->link($p['category_name'],"/categories/".$p['category_id']."/".$p['parent']."/".$categories_url,array(),false,false);?>
			<?php }else{?>
			<?php echo $html->link($p['category_name'],"/categories/".$p['category_id']."/".$categories_url."/0/",array(),false,false);?>
			<?php }?>
		<?php }else{?>	
			<?php echo $html->link($p['category_name'],"/categories/".$p['category_id'],array(),false,false);?>
		<?php }?>
</span>
<?php }?>
<?php if(isset($brands[$p['Product']['brand_id']])){?><span><?php echo $html->link($brands[$p['Product']['brand_id']]['BrandI18n']['name'],"/brands/".$p['Product']['brand_id']."/","",false,false);?></span><?php }?>
</p>
</div>
<div class="Item_Price">
<span class="Products_Price">
<?php echo $SCLanguages['our_price']?>:<?php if(isset($p['product_rank_price'])){?><?php echo $svshow->price_format($p['product_rank_price'],$SVConfigs['price_format']);?><?php }else if(isset($p['is_promotion'])){?>
<?php if($p['is_promotion'] == 1){ ?>
<?php echo $svshow->price_format($p['Product']['promotion_price'],$SVConfigs['price_format']);?>	
<?php }else{ ?>
<?php echo $svshow->price_format($p['Product']['shop_price'],$SVConfigs['price_format']);?>	
	<?php } ?>
<?php }?>
</span>
<?php if(false){?>
<span class="Price"><?php //=$SCLanguages['membership_price']?>:</span>
<?php }?>
<span class="Price">
<?php if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
	<?php echo $SCLanguages['market_price'].":";?>
<?php echo $svshow->price_format($p['Product']['market_price'],$SVConfigs['price_format']);?>	
		<br />
<?php }?>
<?php if($p['discount_price'] > 0){?>
<?php echo $SCLanguages['discount']?>:<?php echo $p['discount_rate']."%"; ?></span>
<span class="save"><?php echo $SCLanguages['save_to_market_price']?>:
<?php echo $svshow->price_format($p['discount_price'],$SVConfigs['price_format']);?>	
</span>
<?php }else{?>
	</span>
<?php }?>
</div>
<div class="Number_select">
<span class="top"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/"."ico_top.gif":"ico_top.gif",array()),"javascript:quantity_change('product','+','".$i."')","",false,false);?></span>
<span class="Number" id="show_quantity_<?php echo  $p['quantity']; ?>"><?php echo  $p['quantity']; ?></span><input type="hidden" id="quantity_<?php echo $i?>" value="<?php echo  $p['quantity']; ?>" />
<span class="bottom"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/"."ico_bottom.gif":"ico_bottom.gif",array()),"javascript:quantity_change('product','-','".$i."')","",false,false);?></span>
</div>
<div class="Sums">
<span class="Number"><?php echo $svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?></span>
</div>
<div class="btn_list">
<a href="javascript:remove_product('product',<?php echo $i?>)"><span><?php echo $SCLanguages['delete']?></span></a>
	<?php if(isset($_SESSION['User'])){?>
<a href="javascript:favorite(<?php echo $i?>,'p')"><span><?php echo $SCLanguages['favorite']?></span></a>
	<?php }?>
<?php echo $html->link("<span>".$SCLanguages['detail']."</span>",$svshow->sku_product_link($i,$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),array(),false,false);?></div>
</div>
<?php }?>
</div>
<?php $st = 'ok';} if(isset($svcart['packagings']) && sizeof($svcart['packagings'])>0){?>
<div class="List_bg">
<?php foreach($svcart['packagings'] as $i=>$p){?>
<div id="Item_box">
<div class="Item_info" id="products_<?php echo $i;?>">
<?php if(!empty($SVConfigs['enable_products_show_method']) && $SVConfigs['enable_products_show_method'] == 1){?>
<p class="pic">
<?php if($p['Packaging']['img01'] != ""){?>
<?php echo $html->image($p['Packaging']['img01'],array("width"=>108,"height"=>108));?>
<?php }else{?>
<?php echo $html->image("/img/product_default.jpg",array("width"=>108,"height"=>108));?>
<?php }?>
</p>
<?php }?>
<p class="info">
<span><?php echo $p['PackagingI18n']['name'];?></span>
</p>
</div>
<div class="Item_Price">
<span class="Products_Price"><?php echo $SCLanguages['price']?>:
<?php if(isset($p['Packaging']['fee_free'])){?>
<?php echo $svshow->price_format($p['Packaging']['fee_free'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($p['Packaging']['fee'],$SVConfigs['price_format']);?>	
<?php }?>
</span>
<?php if($p['Packaging']['free_money'] > 0){?>
<span class="Products_Price"><?php echo $SCLanguages['free'];?><?php echo $SCLanguages['limit'];?>:
<?php echo $svshow->price_format($p['Packaging']['free_money'],$SVConfigs['price_format']);?>
</span>
<?php }?>

</div>
<div class="Number_select">
 <span class="top"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/"."ico_top.gif":"ico_top.gif",array()),"javascript:quantity_change('packaging','+',".$i.")","",false,false);?></span>
<span class="Number" id="show_quantity_<?php echo  $p['quantity']; ?>"><?php echo  $p['quantity']; ?></span><input type="hidden" id="quantity_<?php echo $i?>" value="<?php echo  $p['quantity']; ?>" />
<span class="bottom"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/"."ico_bottom.gif":"ico_bottom.gif",array()),"javascript:quantity_change('packaging','-',".$i.")","",false,false);?></span>
</div>
<div class="Sums">
	<span class="Number"><?php echo $svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?></span>
</div>
<div class="btn_list"><a href="javascript:remove_product('packaging',<?php echo $i?>)"><span><?php echo $SCLanguages['delete']?></span></a></div>
</div>
<?php }?>
</div>
<?php $st = 'ok';} if(isset($svcart['cards']) && sizeof($svcart['cards'])>0){?>
<div class="List_bg">
<?php foreach($svcart['cards'] as $i=>$p){?>
<div id="Item_box">
<div class="Item_info" id="products_<?php echo $i;?>">
<?php if(!empty($SVConfigs['enable_products_show_method']) && $SVConfigs['enable_products_show_method'] == 1){?>
<p class="pic">
<?php if($p['Card']['img01'] != ""){?>
<?php echo $html->image($p['Card']['img01'],array("width"=>108,"height"=>108));?>
<?php }else{?>
<?php echo $html->image("/img/product_default.jpg",array("width"=>108,"height"=>108));?>
<?php }?>
</p>
<?php }?>
<p class="info"><span><?php echo $p['CardI18n']['name'];?></span></p>
</div>
<div class="Item_Price">
<span class="Products_Price"><?php echo $SCLanguages['price']?>:
<?php if(isset($p['Card']['fee_free'])){?>
<?php echo $svshow->price_format($p['Card']['fee_free'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($p['Card']['fee'],$SVConfigs['price_format']);?>	
<?php }?>
</span>
<?php if($p['Card']['free_money'] > 0){?>
<span class="Products_Price"><?php echo $SCLanguages['free'];?><?php echo $SCLanguages['limit'];?>:
<?php echo $svshow->price_format($p['Card']['free_money'],$SVConfigs['price_format']);?>	
</span>
<?php }?>	
	
	
</div>
<div class="Number_select">
 <span class="top"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/"."ico_top.gif":"ico_top.gif",array()),"javascript:quantity_change('card','+',".$i.")","",false,false);?></span>
<span class="Number" id="show_quantity_<?php echo  $p['quantity']; ?>"><?php echo  $p['quantity']; ?></span><input type="hidden" id="quantity_<?php echo $i?>" value="<?php echo  $p['quantity']; ?>" />
<span class="bottom"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/"."ico_bottom.gif":"ico_bottom.gif",array()),"javascript:quantity_change('card','-',".$i.")","",false,false);?></span>
</div>
<div class="Sums">
	<span class="Number"><?php echo $svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?></span>
</div>
<div class="btn_list">
<a href="javascript:remove_product('card',<?php echo $i?>)"><span><?php echo $SCLanguages['delete']?></span></a></div>
</div>
<?php }?>
</div>
<?php $st = 'ok';}if(empty($st)){?>
<br/><br/>
<?php echo "<p class='not'>"?>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('alt'=>''))?>
<?php 
echo "<strong>".$SCLanguages['no_products_in_cart']."</strong></p><br /><br /><br />";
}else{ ?>
<div id="balance">
<span><?php echo $SCLanguages['subtotal']?>:<font color="#ff0000">
<?php echo $svshow->price_format($svcart['cart_info']['sum_subtotal'],$SVConfigs['price_format']);?></font></span>
<?php if($svcart['cart_info']['discount_price'] > 0){?>
<span><?php echo $SCLanguages['discount']?>:<?php if(isset($svcart['cart_info']['discount_rate'])){?>
<?php echo $svcart['cart_info']['discount_rate'];?><?php }else{?>100<?php }?>%</span>
<span><?php echo $SCLanguages['save_to_market_price']?>:<font color="#ff0000"><?php echo $svshow->price_format($svcart['cart_info']['discount_price'],$SVConfigs['price_format']);?></font></span>
<?php }?>
</div>
<?php }?>