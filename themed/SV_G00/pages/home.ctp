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
 * $Id: home.ctp 1883 2009-05-31 11:20:54Z huangbo $
*****************************************************************************/
?>

<!--热门话题-->	
<?if(isset($home_article) && is_array($home_article) && sizeof($home_article)>0){?>
<div id="hot-list">
	<p class="l fff"><b><?=$SCLanguages['latest']?><br /><?=$SCLanguages['article']?></b></p>
	<ul>
	<li>
	<?if(isset($home_article[0])){?>
	<?=$html->link($home_article[0]['ArticleI18n']['title'],'/articles/'.$home_article[0]['Article']['id'],array('class'=>'color_6d'),false,false);?>
	<?}?>
	</li>
	<li>
	<?if(isset($home_article[1])){?>
	<?=$html->link($home_article[1]['ArticleI18n']['title'],'/articles/'.$home_article[0]['Article']['id'],array('class'=>'color_6d'),false,false);?>
	<?}?>
	</li>
	</ul>		
	<ul>
	<li>
	<?if(isset($home_article[2])){?>
	<?=$html->link($home_article[2]['ArticleI18n']['title'],'/articles/'.$home_article[0]['Article']['id'],array('class'=>'color_6d'),false,false);?>
	<?}?>
	</li>
	<li>
	<?if(isset($home_article[3])){?>
	<?=$html->link($home_article[3]['ArticleI18n']['title'],'/articles/'.$home_article[0]['Article']['id'],array('class'=>'color_6d'),false,false);?>
	<?}?>
	</li>
	</ul>		
	<p class="more">
	<?=$html->link("&nbsp;",'/articles/',array('title'=>'查看更多文章'),false,false);?>
	</p>
</div>
<?}?>	
<!--热门话题End-->
<div class="height_5"></div>
<?if(isset($flashes['FlashImage']) && sizeof($flashes['FlashImage'])>0){?><? //pr($flashes);?>
<!--Flash-->
<div id="Flash"><?=$flash->renderSwf('img/bcastr4.swf?xml='.$this->webroot.'flashes/index/H',$flashes['Flash']['width'],$flashes['Flash']['height'],false,array('params' => array('movie'=>$this->webroot.'img/bcastr4.swf?xml='.$this->webroot.'flashes/index/H','wmode'=>'Opaque')));?></div>
<!--Flash End-->
<?}?>
<ul class="content_tab">
<?if(isset($products_promotion)  && sizeof($products_promotion) > 0 ){?>
<?if(isset($sign) && $sign == "products_promotion"){?>
<li id="one<?=$tab_arr['products_promotion']?>" onmouseover="overtab('one',<?=$tab_arr['products_promotion']?>,<?=$size?>)" class="hover">
<?}else{?>
<li id="one<?=$tab_arr['products_promotion']?>" onmouseover="overtab('one',<?=$tab_arr['products_promotion']?>,<?=$size?>)">
<?}?>
<span><?php echo $SCLanguages['promotion'];?></span></li>
<?}?>
<?if(isset($products_newarrival) && sizeof($products_newarrival) > 0){?>
<?if(isset($sign) && $sign == "products_newarrival"){?>
<li id="one<?=$tab_arr['products_newarrival']?>" onmouseover="overtab('one',<?=$tab_arr['products_newarrival']?>,<?=$size?>)"  class="hover">
<?}else{?>
<li id="one<?=$tab_arr['products_newarrival']?>" onmouseover="overtab('one',<?=$tab_arr['products_newarrival']?>,<?=$size?>)" >
<?}?>
<span><?php echo $SCLanguages['new_arrival'];?></span></li><?}?>
<?if(isset($products_recommand) && sizeof($products_recommand) > 0){?>
<?if(isset($sign) && $sign == "products_recommand"){?>
<li id="one<?=$tab_arr['products_recommand']?>" onmouseover="overtab('one',<?=$tab_arr['products_recommand']?>,<?=$size?>)" class="hover">
<?}else{?>
<li id="one<?=$tab_arr['products_recommand']?>" onmouseover="overtab('one',<?=$tab_arr['products_recommand']?>,<?=$size?>)" >
<?}?>
<span><?php echo $SCLanguages['recommend'];?></span></li><?}?>
</ul>
<div id="Item_List" class="border">
<?if(isset($products_promotion)  && sizeof($products_promotion) > 0 ){?>
<!--促销-->
<?if($sign == "products_promotion"){?>
<ul id="con_one_<?=$tab_arr['products_promotion']?>" class="home-products">
<?}else{?>
<ul id="con_one_<?=$tab_arr['products_promotion']?>" class="home-products" style="display:none">
<?}?>
<? foreach($products_promotion as $k=>$v){?>
	<li>
		<p class="pic">
		<?echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("alt"=>$v['ProductI18n']['name']));?>
		</p>
		<p class="info">
		<span class="name"><?echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></span>
		<span class="Price"><font style="letter-spacing:4px;"><?php echo $SCLanguages['market_price'];?></font>:<font color="#ff0000">
		<?=$svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
			</font></span>
		<span class="Price"><?php echo $SCLanguages['promotion'].$SCLanguages['price'];?>:<font color="#ff0000">
<?if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?=$svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?}else{?>
<?=$svshow->price_format($v['Product']['promotion_price'],$SVConfigs['price_format']);?>	
<?}?>
			</font></span>
		<span class="stow">
	<?if(isset($_SESSION['User'])){?>
				<?=$html->link($SCLanguages['favorite'],"javascript:favorite({$v['Product']['id']},'p')","",false,false)?>|<?}?>
				
		<?if($v['Product']['quantity'] == 0){?>
		<a href="javascript:show_booking(<?=$v['Product']['id']?>,'<?=$v['ProductI18n']['name']?>');"><?php echo $SCLanguages['booking'];?></a>
		<?}else{?>
		<?=$html->link($SCLanguages['buy'],"javascript:buy_now({$v['Product']['id']},1)","",false,false)?>
		<?}?>
		</span>
		</p></li>
<?}?>
</ul>
<!--促销 End-->
<?}?>
<?if(isset($products_newarrival) && sizeof($products_newarrival) > 0){?>
<!--新品-->
<?if($sign == "products_newarrival"){?>
<ul id="con_one_<?=$tab_arr['products_newarrival']?>" class="home-products" >
<?}else{?>
<ul id="con_one_<?=$tab_arr['products_newarrival']?>" class="home-products" style="display:none">
<?}?>
<?foreach($products_newarrival as $k=>$v){?>
	<li>
	<p class="pic">
	<?echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("alt"=>$v['ProductI18n']['name']));?></p>
	<p class="info">
	<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></span>
	<?if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
	<span class="Price"><font style="letter-spacing:4px;"><?php echo $SCLanguages['market_price'];?></font>:<font color="#ff0000">
<?=$svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
		</font></span>
	<?}?>
	<span class="Price"><?php echo $SCLanguages['our_price'];?>:<font color="#ff0000">
<?if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?=$svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?}else{?>
<?=$svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?}?>
		</font></span>
	<span class="stow">
	<?if(isset($_SESSION['User'])){?>
	<?=$html->link($SCLanguages['favorite'],"javascript:favorite({$v['Product']['id']},'p')","",false,false)?>|<?}?>
	<?if($v['Product']['quantity'] == 0){?>
	<a href="javascript:show_booking(<?=$v['Product']['id']?>,'<?=$v['ProductI18n']['name']?>');"><?php echo $SCLanguages['booking'];?></a>
	<?}else{?>
	<?=$html->link($SCLanguages['buy'],"javascript:buy_now({$v['Product']['id']},1)","",false,false)?>
	<?}?>
	</span>
	</p>
	</li>
<?}?>
</ul>
<!--新品 End-->
<?}?>
<?if(isset($products_recommand) && sizeof($products_recommand) > 0){?>
<!--推荐-->
<?if($sign == "products_recommand"){?>
<ul id="con_one_<?=$tab_arr['products_recommand']?>" class="home-products">
<?}else{?>
<ul id="con_one_<?=$tab_arr['products_recommand']?>" class="home-products" style="display:none">
<?}?>
<?foreach($products_recommand as $kk=>$vv){?>
	<li>
	<p class="pic">
	<?echo $svshow->productimagethumb($vv['Product']['img_thumb'],$svshow->sku_product_link($vv['Product']['id'],$vv['ProductI18n']['name'],$vv['Product']['code'],$SVConfigs['use_sku']),array("alt"=>$vv['ProductI18n']['name']));?></p>
	<p class="info">
	<span class="name"><?php echo $html->link( $vv['ProductI18n']['name'],$svshow->sku_product_link($vv['Product']['id'],$vv['ProductI18n']['name'],$vv['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></span>
	<?if($vv['Product']['market_price'] > $vv['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
	<span class="Price"><font style="letter-spacing:4px;"><?php echo $SCLanguages['market_price'];?></font>:<font color="#ff0000">
<?=$svshow->price_format($vv['Product']['market_price'],$SVConfigs['price_format']);?>	
		</font></span>
	<?}?>
	<span class="Price"><?php echo $SCLanguages['our_price'];?>:<font color="#ff0000">
<?if(isset($vv['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?=$svshow->price_format($vv['Product']['user_price'],$SVConfigs['price_format']);?>	
<?}else{?>
<?=$svshow->price_format($vv['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?}?>	
		</font></span>
	<span class="stow">
	<?if(isset($_SESSION['User'])){?>
			<?=$html->link($SCLanguages['favorite'],"javascript:favorite({$vv['Product']['id']},'p')","",false,false)?>|<?}?>
	<?if($vv['Product']['quantity'] == 0){?>
	<a href="javascript:show_booking(<?=$v['Product']['id']?>,'<?=$v['ProductI18n']['name']?>');"><?php echo $SCLanguages['booking'];?></a>
	<?}else{?>
	<?=$html->link($SCLanguages['buy'],"javascript:buy_now({$vv['Product']['id']},1)","",false,false)?>
	<?}?>
	</span>
	</p>
	</li>
<?}?>
</ul>
<!--推荐 End-->
<?}?>
</div>
<? echo $this->element('news', array('cache'=>'+0 hour'));?>