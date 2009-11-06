<?php 
/*****************************************************************************
 * SV-Cart 首页
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: home.ctp 3296 2009-07-24 07:19:59Z huangbo $
*****************************************************************************/
?>

<?php if(isset($products_newarrival) && sizeof($products_newarrival) > 0){?>
<div class="products clearfix">
<h3><span><?php echo $SCLanguages['new_arrival'];?></span></h3>
<!--NewProduct-->
<?php foreach($products_newarrival as $k=>$v){?>
<?php if($k==0){?><ul><?php }?>
	<li>
	<p class="picture">
	<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("alt"=>$v['ProductI18n']['name']));?></p>
		
	<p class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></p>
	
	<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
	<p class="price font_green market_price"><?php echo $SCLanguages['market_price'];?>: <?php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?></p>
	<?php }?>
	
	<p class="price font_green">
	<?php echo $SCLanguages['our_price'];?>:
	<?php if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
	<?php echo $svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
	<?php }else{?>
	<?php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
	<?php }?>
	</p>

	<div class="action">
	<?php if(isset($_SESSION['User'])){?>
	<?php echo $html->link($SCLanguages['favorite'],$server_host.$user_webroot."favorites/add/p/".$v['Product']['id'],"",false,false)?>
	<?php }?>
		
	<?php if($v['Product']['quantity'] == 0){?>
		<?php echo $html->link($SCLanguages['booking'],'/products/add_booking_page/'.$v['Product']['id']);?>
	<?php }else{?>
		<?php echo $form->create('carts',array('action'=>'buy_now','name'=>'buy_nownewproduct'.$v['Product']['id'],'type'=>'POST'));?>
		<input type="hidden" name="id" value="<?php echo $v['Product']['id']?>"/>
		<input type="hidden" name="quantity" value="1"/>
		<input type="hidden" name="type" value="product"/>
		<?php echo $html->link($SCLanguages['buy'],"javascript:buy_now_no_ajax({$v['Product']['id']},1,'newproduct')","",false,false)?>
		<?php echo $form->end();?>
	<?php }?>
	</div>
	</li>
<?php  if( $k%5==4 && $k<sizeof($products_newarrival)-1 ){?>
	<?php if($k == 0){?>
	<?php }else{?>
	</ul>
	<ul>
	<?php }?>
	<?php }else if($k==sizeof($products_newarrival)-1){?>
	</ul><?php }else{?><?php }?>
		
		
		
<?php }?>
</div>
<!--NewProduct End-->
<div class="height_10">&nbsp;</div>
<?php }?>
<?php 
	
$home_category_products=$this->requestAction("commons/get_cat_products/");
?>	

<?php if(isset($home_category_products) && sizeof($home_category_products)){?>
<?php foreach($home_category_products as $k=>$v){?>
<p class="clear">&nbsp;</p>
<h3><span><?php echo $v['category_name']?></span><?php echo $html->link($SCLanguages['more']."...","/categories/".$k,array('class'=>'more'),false,false)?></h3>
<div class="mainbox clearfix">
<div class="cat_picture float_left">
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."adv_search_ico.png":"adv_search_ico.png",
	array("width"=>"160","height"=>"214"))?></p>
</div>

<div class="float_left cat_product">
<!-- Categories -->
<?php if(isset($v['products']) && sizeof($v['products']) > 0){?>
<?php foreach($v['products'] as $kk=>$vv){?><!--foreach-->
<ul class="grid">
	<li class="picture">
	<p>
	<?php echo $svshow->productimagethumb($vv['Product']['img_thumb'],$svshow->sku_product_link($vv['Product']['id'],$vv['ProductI18n']['name'],$vv['Product']['code'],$SVConfigs['use_sku']),array("alt"=>$vv['ProductI18n']['name']));?></p>
	</li>
	<li class="property">
	<p class="name"><?php echo $html->link( $vv['ProductI18n']['name'],$svshow->sku_product_link($vv['Product']['id'],$vv['ProductI18n']['name'],$vv['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></p>
		
	<p class="price font_green">
	<?php if($vv['Product']['market_price'] > $vv['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
	<strike><?php echo $SCLanguages['market_price'];?>:
<?php echo $svshow->price_format($vv['Product']['market_price'],$SVConfigs['price_format']);?></strike>
	<br />
	<?php }?>
	
	<?php echo $SCLanguages['our_price'];?>:
<?php if(isset($vv['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?php echo $svshow->price_format($vv['Product']['user_price'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($vv['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?php }?></p>
	
	<div class="action">
	<?php if(isset($_SESSION['User'])){?>
			<?php echo $html->link($SCLanguages['favorite'],$server_host.$user_webroot."favorites/add/p/".$vv['Product']['id'],"",false,false)?> |
	<?php }?>
	<?php if($vv['Product']['quantity'] == 0){?>
			<?php echo $html->link($SCLanguages['booking'],'/products/add_booking_page/'.$vv['Product']['id']);?>
	<?php }else{?>
			<?php echo $form->create('carts',array('action'=>'buy_now','name'=>'buy_nowcatproduct'.$vv['Product']['id'],'type'=>'POST'));?>
				<input type="hidden" name="id" value="<?php echo $vv['Product']['id']?>"/>
				<input type="hidden" name="quantity" value="1"/>
				<input type="hidden" name="type" value="product"/>
				<?php echo $html->link($SCLanguages['buy'],"javascript:buy_now_no_ajax({$vv['Product']['id']},1,'catproduct')","",false,false)?>
			<?php echo $form->end();?>
	<?php }?>
	</div>
	</li>

</ul>
<?php }}?><!-- foreach end -->
</div>
</div>
<!--Categories End-->
<?php }}?>

