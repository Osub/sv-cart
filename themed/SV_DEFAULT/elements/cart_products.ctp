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
 * $Id: cart_products.ctp 4333 2009-09-17 10:46:57Z huangbo $
*****************************************************************************/
?>
<?php if(isset($svcart['products']) || isset($svcart['packagings']) || isset($svcart['cards'])){?>
<ul class="Title_list">
	<li class="picture">&nbsp;</li>
	<li class="Item_title"><?php echo $SCLanguages['purchased_products']?></li>
	<li class="attribute"><?php echo $SCLanguages['attribute']?></li>
	<li class="Price_title"><pre><?php echo $SCLanguages['price']?></pre></li>
	<li class="Number_title"><?php echo $SCLanguages['products']?></li>
	<li class="Sum_title"><?php echo $SCLanguages['subtotal']?></li>
	<li class="action"><?php echo $SCLanguages['operation']?></li>
</ul>
<?php }?>
<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>
<div class="List_bg">
<?php foreach($svcart['products'] as $i=>$p){?>
<ul id="Item_box" class="Title_list">
<?php if(!empty($SVConfigs['enable_products_show_method']) && $SVConfigs['enable_products_show_method'] == 1){?>
<li class="picture">
<?php echo $svshow->productimagethumb($p['Product']['img_thumb'],$svshow->sku_product_link($p['Product']['id'],$p['ProductI18n']['name'],$p['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$p['ProductI18n']['name'],'width'=>72,'height'=>72),$this->data['configs']['products_default_image']);?>
</li>
<?php }else{?>
&nbsp;
<?php }?>
<li class="Item_title" id="products_<?php echo $i;?>">
<?php if(isset($p['ProductI18n']['name'])){?>
<?php $p_name = $p['ProductI18n']['name'];?>
<p><?php echo $html->link($p_name,$svshow->sku_product_link($p['Product']['id'],$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['product_link_type']),array("target"=>"_blank"),false,false);?></p>
<?php }?>
<?php if(isset($p['category_name'])){?>
<p>
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
</p>
<?php }?>
<?php if(isset($brands[$p['Product']['brand_id']])){?>
	<p><?php echo $html->link($brands[$p['Product']['brand_id']]['BrandI18n']['name'],"/brands/".$p['Product']['brand_id']."/","",false,false);?></p>
<?php }?>
</li>
<li class="attribute">
	<?php
if(isset($p['attributes']) && $p['attributes'] != "" && $SVConfigs['enable_show_products_attribute'] == "1"){
	echo $p['attributes'];
}else{
	echo "&nbsp;";
}	
	?>
</li>
<li class="Price_title">
<p><strong>
<?php echo $SCLanguages['our_price']?>:<?php if(isset($p['product_rank_price'])){?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($p['product_rank_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['product_rank_price'],$this->data['configs']['price_format']);?><?php }?><?php }else if(isset($p['is_promotion'])){?><?php if($p['is_promotion'] == 1){ ?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($p['Product']['promotion_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['Product']['promotion_price'],$this->data['configs']['price_format']);?><?php }?><?php }else{ ?>
<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($p['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['Product']['shop_price'],$this->data['configs']['price_format']);?><?php }?><?php } ?><?php }?></strong></p>
<?php if(false){?><?php //=$SCLanguages['membership_price']?>:<?php }?><?php if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<p class="Price"><strong><?php echo $SCLanguages['market_price'].":";?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($p['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['Product']['market_price'],$this->data['configs']['price_format']);?><?php }?></strong></p>
<?php }?><?php if($p['discount_price'] > 0){?><p class="Price"><strong><?php echo $SCLanguages['discount']?>:<?php echo $p['discount_rate']."%"; ?></strong></p><p class="save"><strong><?php echo $SCLanguages['save_to_market_price']?>:<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($p['discount_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['discount_price'],$this->data['configs']['price_format']);?><?php }?></strong></p><?php }?></li>
<li class="Number_select Number_title">
<span class="top"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/"."ico_top.gif":"ico_top.gif",array()),"javascript:quantity_change('product','+','".$i."')","",false,false);?></span>
<span class="Number" id="show_quantity_<?php echo  $p['quantity']; ?>"><?php echo  $p['quantity']; ?></span><input type="hidden" id="quantity_<?php echo $i?>" value="<?php echo  $p['quantity']; ?>" />
<span class="bottom"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/"."ico_bottom.gif":"ico_bottom.gif",array()),"javascript:quantity_change('product','-','".$i."')","",false,false);?></span>
</li>
<li class="Sum_title"><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($p['subtotal']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['subtotal'],$this->data['configs']['price_format']);?><?php }?></li>
<li class="btn_list action"><a href="javascript:remove_product('product',<?php echo $i?>)"><span><?php echo $SCLanguages['delete']?></span></a><?php if(isset($_SESSION['User'])){?><a href="javascript:favorite(<?php echo $i?>,'p')"><span><?php echo $SCLanguages['favorite']?></span></a><?php }?><?php echo $html->link("<span>".$SCLanguages['detail']."</span>",$svshow->sku_product_link($p['Product']['id'],$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['product_link_type']),array(),false,false);?></li>
</ul><?php }?>
</div>
<?php $st = 'ok';} if(isset($svcart['packagings']) && sizeof($svcart['packagings'])>0){?>
<div class="List_bg">
<?php foreach($svcart['packagings'] as $i=>$p){?>
<ul id="Item_box" class="Title_list">
	<li class="picture">
	<?php if(!empty($SVConfigs['enable_products_show_method']) && $SVConfigs['enable_products_show_method'] == 1){?>
	<?php if($p['Packaging']['img01'] != ""){?>
	<?php echo $html->image($p['Packaging']['img01'],array("width"=>72,"height"=>72,'alt'=>$p['PackagingI18n']['name']));?>
	<?php }else{?>
	<?php echo $html->image("/img/product_default.jpg",array("width"=>72,"height"=>72,'alt'=>$p['PackagingI18n']['name']));?>
	<?php }?>
	<?php }?>
	</li>
	<li class="Item_title" id="products_<?php echo $i;?>"><p class="info"><span><?php echo $p['PackagingI18n']['name'];?></span></p></li>
	<li class="attribute"><?if(isset($p['Packaging']['note'])){?><?php echo $p['Packaging']['note'];?><?}?>&nbsp;</li>
	<li class="Price_title">
	<p class="Products_Price"><strong><?php echo $SCLanguages['price']?>:<?php if(isset($p['Packaging']['fee_free'])){?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($p['Packaging']['fee_free']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['Packaging']['fee_free'],$this->data['configs']['price_format']);?><?php }?><?php }else{?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($p['Packaging']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['Packaging']['fee'],$this->data['configs']['price_format']);?><?php }?><?php }?></strong></p><?php if($p['Packaging']['free_money'] > 0){?><p class="Products_Price"><strong><?php echo $SCLanguages['free'];?><?php echo $SCLanguages['limit'];?>:<?//php echo $svshow->price_format($p['Packaging']['free_money'],$SVConfigs['price_format']);?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($p['Packaging']['free_money']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['Packaging']['free_money'],$this->data['configs']['price_format']);?><?php }?></strong></p><?php }?>
	</li>
	<li class="Number_select Number_title">
	 <span class="top"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/"."ico_top.gif":"ico_top.gif",array()),"javascript:quantity_change('packaging','+',".$i.")","",false,false);?></span>
	<span class="Number" id="show_quantity_<?php echo  $p['quantity']; ?>"><?php echo  $p['quantity']; ?></span><input type="hidden" id="quantity_<?php echo $i?>" value="<?php echo  $p['quantity']; ?>" />
	<span class="bottom"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/"."ico_bottom.gif":"ico_bottom.gif",array()),"javascript:quantity_change('packaging','-',".$i.")","",false,false);?></span>
	</li>
	<li class="Sum_title"><span class="Number"><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($p['subtotal']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['subtotal'],$this->data['configs']['price_format']);?>	<?php }?></span></li>
	<li class="btn_list action"><a href="javascript:remove_product('packaging',<?php echo $i?>)"><span><?php echo $SCLanguages['delete']?></span></a></li>
</ul>
<?php }?>
</div>
<?php $st = 'ok';} if(isset($svcart['cards']) && sizeof($svcart['cards'])>0){?>
<div class="List_bg">
<?php foreach($svcart['cards'] as $i=>$p){?>
<ul id="Item_box" class="Title_list">
	<li class="picture">
	<?php if($p['Card']['img01'] != ""){?>
	<?php echo $html->image($p['Card']['img01'],array("width"=>72,"height"=>72,'alt'=>$p['CardI18n']['name']));?>
	<?php }else{?>
	<?php echo $html->image("/img/product_default.jpg",array("width"=>72,"height"=>72,'alt'=>$p['CardI18n']['name']));?>
	<?php }?>
	</li>
	<li class="Item_title" id="products_<?php echo $i;?>">
	<?php if(!empty($SVConfigs['enable_products_show_method']) && $SVConfigs['enable_products_show_method'] == 1){?>
	<?php }?>
	<p class="info"><span><?php echo $p['CardI18n']['name'];?></span></p>
	</li>
	<li class="attribute"><?if(isset($p['Card']['note'])){?><?php echo $p['Card']['note'];?><?}?>&nbsp;</li>
	
	<li class="Price_title">
	<p class="Products_Price"><strong><?php echo $SCLanguages['price']?>:<?php if(isset($p['Card']['fee_free'])){?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($p['Card']['fee_free']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['Card']['fee_free'],$this->data['configs']['price_format']);?><?php }?><?php }else{?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($p['Card']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['Card']['fee'],$this->data['configs']['price_format']);?><?php }?><?php }?></strong></p>
	<?php if($p['Card']['free_money'] > 0){?>
	<p class="Products_Price"><strong><?php echo $SCLanguages['free'];?><?php echo $SCLanguages['limit'];?>:<?//php echo $svshow->price_format($p['Card']['free_money'],$SVConfigs['price_format']);?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($p['Card']['free_money']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['Card']['free_money'],$this->data['configs']['price_format']);?><?php }?></strong></p><?php }?>	
	</li>
	<li class="Number_select Number_title">
	<span class="top"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/"."ico_top.gif":"ico_top.gif",array()),"javascript:quantity_change('card','+',".$i.")","",false,false);?></span>
	<span class="Number" id="show_quantity_<?php echo  $p['quantity']; ?>"><?php echo  $p['quantity']; ?></span><input type="hidden" id="quantity_<?php echo $i?>" value="<?php echo  $p['quantity']; ?>" />
	<span class="bottom"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/"."ico_bottom.gif":"ico_bottom.gif",array()),"javascript:quantity_change('card','-',".$i.")","",false,false);?></span>
	</li>
	<li class="Sum_title">
	<span class="Number">
<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
	<?php echo $svshow->price_format($p['subtotal']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($p['subtotal'],$this->data['configs']['price_format']);?><?php }?></span></li>
	<li class="btn_list action"><a href="javascript:remove_product('card',<?php echo $i?>)"><span><?php echo $SCLanguages['delete']?></span></a></li>
</ul>
<?php }?>
<?php $st = 'ok';}if(empty($st)){?>
<br/><br/>
<?php echo "<p class='not'>"?>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('alt'=>''))?>
<?php 
echo "<strong>".$SCLanguages['no_products_in_cart']."</strong></p><br /><br /><br />";
}else{ ?>
<div id="balance">
<span><?php echo $SCLanguages['subtotal']?>:<font color="#ff0000"><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($svcart['cart_info']['sum_subtotal']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($svcart['cart_info']['sum_subtotal'],$this->data['configs']['price_format']);?><?php }?></font></span>
<?php if($svcart['cart_info']['discount_price'] > 0){?>
<span><?php echo $SCLanguages['discount']?>:<?php if(isset($svcart['cart_info']['discount_rate'])){?>
<?php echo $svcart['cart_info']['discount_rate'];?><?php }else{?>100<?php }?>%</span>
<span><?php echo $SCLanguages['save_to_market_price']?>:<font color="#ff0000"><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($svcart['cart_info']['discount_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($svcart['cart_info']['discount_price'],$this->data['configs']['price_format']);?><?php }?></font></span>
<?php }?>
</div>
<?php }?>