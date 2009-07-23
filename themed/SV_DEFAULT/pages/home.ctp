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
 * $Id: home.ctp 3225 2009-07-22 10:59:01Z huangbo $
*****************************************************************************/
?>

<!--热门话题-->	
<?php if(isset($home_article) && is_array($home_article) && sizeof($home_article)>0){?>
<div id="hot-list">
	<p class="l fff"><b><?php echo $SCLanguages['latest']?><br /><?php echo $SCLanguages['article']?></b></p>
	<ul>
	<?php if(isset($home_article[0])){?>
	<li>
	<?php echo $html->link($home_article[0]['ArticleI18n']['title'],'/articles/'.$home_article[0]['Article']['id'],array('class'=>'color_6d'),false,false);?>
	</li>
	<?php }?>
	<?php if(isset($home_article[1])){?>
	<li>
	<?php echo $html->link($home_article[1]['ArticleI18n']['title'],'/articles/'.$home_article[1]['Article']['id'],array('class'=>'color_6d'),false,false);?>
	</li>
	<?php }?>
	</ul>		
	<ul>
	<?php if(isset($home_article[2])){?>
	<li>
	<?php echo $html->link($home_article[2]['ArticleI18n']['title'],'/articles/'.$home_article[2]['Article']['id'],array('class'=>'color_6d'),false,false);?>
	</li>
	<?php }?>
	<?php if(isset($home_article[3])){?>
	<li>
	<?php echo $html->link($home_article[3]['ArticleI18n']['title'],'/articles/'.$home_article[3]['Article']['id'],array('class'=>'color_6d'),false,false);?>
	</li>
	<?php }?>
	</ul>		
	<p class="more">
	<?php echo $html->link("&nbsp;",'/articles/',array('title'=>'查看更多文章'),false,false);?>
	</p>
</div>
<?php }?>	
<!--热门话题End-->
<div class="height_5"></div>
<?php if(isset($flashes['FlashImage']) && sizeof($flashes['FlashImage'])>0){?><?php //pr($flashes);?>
<!--Flash-->
<div id="Flash"><?php echo $flash->renderSwf('img/bcastr4.swf?xml='.$cart_webroot.'flashes/index/H',
	$flashes['Flash']['width'],$flashes['Flash']['height'],false,
	array('params' => array('movie'=>$root_all.'img/bcastr4.swf?xml='.$cart_webroot.'flashes/index/H','wmode'=>'Opaque')));?></div>
<!--Flash End-->
<?php }?>
<ul class="content_tab">
<?php if(isset($products_promotion)  && sizeof($products_promotion) > 0 ){?>
<?php if(isset($sign) && $sign == "products_promotion"){?>
<li id="one<?php echo $tab_arr['products_promotion']?>" onmouseover="overtab('one',<?php echo $tab_arr['products_promotion']?>,<?php echo $size?>)" class="hover">
<?php }else{?>
<li id="one<?php echo $tab_arr['products_promotion']?>" onmouseover="overtab('one',<?php echo $tab_arr['products_promotion']?>,<?php echo $size?>)">
<?php }?>
<span><?php echo $SCLanguages['promotion'];?></span></li>
<?php }?>
<?php if(isset($products_newarrival) && sizeof($products_newarrival) > 0){?>
<?php if(isset($sign) && $sign == "products_newarrival"){?>
<li id="one<?php echo $tab_arr['products_newarrival']?>" onmouseover="overtab('one',<?php echo $tab_arr['products_newarrival']?>,<?php echo $size?>)"  class="hover">
<?php }else{?>
<li id="one<?php echo $tab_arr['products_newarrival']?>" onmouseover="overtab('one',<?php echo $tab_arr['products_newarrival']?>,<?php echo $size?>)" >
<?php }?>
<span><?php echo $SCLanguages['new_arrival'];?></span></li><?php }?>
<?php if(isset($products_recommand) && sizeof($products_recommand) > 0){?>
<?php if(isset($sign) && $sign == "products_recommand"){?>
<li id="one<?php echo $tab_arr['products_recommand']?>" onmouseover="overtab('one',<?php echo $tab_arr['products_recommand']?>,<?php echo $size?>)" class="hover">
<?php }else{?>
<li id="one<?php echo $tab_arr['products_recommand']?>" onmouseover="overtab('one',<?php echo $tab_arr['products_recommand']?>,<?php echo $size?>)" >
<?php }?>
<span><?php echo $SCLanguages['recommend'];?></span></li><?php }?>
</ul>
<div id="Item_List" class="border">
<?php if(isset($products_promotion)  && sizeof($products_promotion) > 0 ){?>
<!--促销-->
<?php if($sign == "products_promotion"){?>
<div id="con_one_<?php echo $tab_arr['products_promotion']?>">
<?php }else{?>
<div id="con_one_<?php echo $tab_arr['products_promotion']?>" style="display:none">
<?php }?>
<?php foreach($products_promotion as $k=>$v){?>
<?php if($k==0){?><ul class="home-products"><?php }?>
	<li>
		<p class="pic">
		<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("alt"=>$v['ProductI18n']['name']));?>
		</p>
		<p class="info">
		<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></span>
		<span class="Price Mart_Price"><?php echo $SCLanguages['market_price'];?>:
		<?php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?></span>
		<span class="Price"><?php echo $SCLanguages['promotion'].$SCLanguages['price'];?>:<font color="#ff0000">
<?php if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?php echo $svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($v['Product']['promotion_price'],$SVConfigs['price_format']);?>	
<?php }?>
			</font></span>
		<span class="stow">
	<?php if(isset($_SESSION['User'])){?>
				<?php echo $html->link($SCLanguages['favorite'],"javascript:favorite({$v['Product']['id']},'p')","",false,false)?>|<?php }?>
				
		<?php if($v['Product']['quantity'] == 0){?>
		<a href="javascript:show_booking(<?php echo $v['Product']['id']?>,'<?php echo $v['ProductI18n']['name']?>');"><?php echo $SCLanguages['booking'];?></a>
		<?php }else{?>
		<?php echo $html->link($SCLanguages['buy'],"javascript:buy_now({$v['Product']['id']},1)","",false,false)?>
		<?php }?>
		</span>
		</p></li>
<?php  if( $k%5==4 && $k<sizeof($products_promotion)-1 ){?>
	<?php if($k == 0){?>
	<?php }else{?>
	</ul>
	<ul class="home-products">
	<?php }?>
	<?php }else if($k==sizeof($products_promotion)-1){?>
	</ul><?php }else{?><?php }?>
<?php }?>
</div>
<!--促销 End-->
<?php }?>
<?php if(isset($products_newarrival) && sizeof($products_newarrival) > 0){?>
<!--新品-->
<?php if($sign == "products_newarrival"){?>
<div id="con_one_<?php echo $tab_arr['products_newarrival']?>">
<?php }else{?>
<div id="con_one_<?php echo $tab_arr['products_newarrival']?>" style="display:none;">
<?php }?>
<?php foreach($products_newarrival as $k=>$v){?>
<?php if($k==0){?><ul class="home-products"><?php }?>
	<li>
	<p class="pic">
	<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("alt"=>$v['ProductI18n']['name']));?></p>
	<p class="info">
	<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></span>
	<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
	<span  class="Price Mart_Price"><?php echo $SCLanguages['market_price'];?>:
<?php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?></span>
	<?php }?>
	<span class="Price"><?php echo $SCLanguages['our_price'];?>:<font color="#ff0000">
<?php if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?php echo $svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?php }?>
		</font></span>
	<span class="stow">
	<?php if(isset($_SESSION['User'])){?>
	<?php echo $html->link($SCLanguages['favorite'],"javascript:favorite({$v['Product']['id']},'p')","",false,false)?>|<?php }?>
	<?php if($v['Product']['quantity'] == 0){?>
	<a href="javascript:show_booking(<?php echo $v['Product']['id']?>,'<?php echo $v['ProductI18n']['name']?>');"><?php echo $SCLanguages['booking'];?></a>
	<?php }else{?>
	<?php echo $html->link($SCLanguages['buy'],"javascript:buy_now({$v['Product']['id']},1)","",false,false)?>
	<?php }?>
	</span>
	</p>
	</li>
<?php  if( $k%5==4 && $k<sizeof($products_newarrival)-1 ){?>
	<?php if($k == 0){?>
	<?php }else{?>
	</ul>
	<ul class="home-products">
	<?php }?>
	<?php }else if($k==sizeof($products_newarrival)-1){?>
	</ul><?php }else{?><?php }?>
		
<?php }?>
</div>
<!--新品 End-->
<?php }?>
<?php if(isset($products_recommand) && sizeof($products_recommand) > 0){?>
<!--推荐-->
<?php if($sign == "products_recommand"){?>
<div id="con_one_<?php echo $tab_arr['products_recommand']?>">
<?php }else{?>
<div id="con_one_<?php echo $tab_arr['products_recommand']?>" style="display:none">
<?php }?>
<?php foreach($products_recommand as $kk=>$vv){?>
<?php if($kk==0){?><ul class="home-products"><?php }?>
	<li>
	<p class="pic">
	<?php echo $svshow->productimagethumb($vv['Product']['img_thumb'],$svshow->sku_product_link($vv['Product']['id'],$vv['ProductI18n']['name'],$vv['Product']['code'],$SVConfigs['use_sku']),array("alt"=>$vv['ProductI18n']['name']));?></p>
	<p class="info">
	<span class="name"><?php echo $html->link( $vv['ProductI18n']['name'],$svshow->sku_product_link($vv['Product']['id'],$vv['ProductI18n']['name'],$vv['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></span>
	<?php if($vv['Product']['market_price'] > $vv['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
	<span class="Price Mart_Price"><?php echo $SCLanguages['market_price'];?>: <?php echo $svshow->price_format($vv['Product']['market_price'],$SVConfigs['price_format']);?></span>
	<?php }?>
	<span class="Price"><?php echo $SCLanguages['our_price'];?>:<font color="#ff0000">
<?php if(isset($vv['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?php echo $svshow->price_format($vv['Product']['user_price'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($vv['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?php }?>	
		</font></span>
	<span class="stow">
	<?php if(isset($_SESSION['User'])){?>
			<?php echo $html->link($SCLanguages['favorite'],"javascript:favorite({$vv['Product']['id']},'p')","",false,false)?>|<?php }?>
	<?php if($vv['Product']['quantity'] == 0){?>
	<a href="javascript:show_booking(<?php echo $vv['Product']['id']?>,'<?php echo $vv['ProductI18n']['name']?>');"><?php echo $SCLanguages['booking'];?></a>
	<?php }else{?>
	<?php echo $html->link($SCLanguages['buy'],"javascript:buy_now({$vv['Product']['id']},1)","",false,false)?>
	<?php }?>
	</span>
	</p>
	</li>
<?php  if( $k%5==4 && $k<sizeof($products_recommand)-1 ){?>
	<?php if($k == 0){?>
	<?php }else{?>
	</ul>
	<ul class="home-products">
	<?php }?>
	<?php }else if($k==sizeof($products_recommand)-1){?>
	</ul><?php }else{?><?php }?>
<?php }?>
</div>
<!--推荐 End-->
<?php }?>
</div>
<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>
