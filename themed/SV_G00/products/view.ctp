<?php
/*****************************************************************************
 * SV-Cart 商品详细页
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
?>

<?=$javascript->link('/js/yui/yahoo-min.js');?>
<?=$javascript->link('/js/yui/event-min.js');?>
<?=$javascript->link('/js/yui/connection-min.js');?>
<div id="globalMain">
<?echo $this->element('ur_here', array('cache'=>'+0 hour'));?>	
<div id="main_left" class="product_l">
<h1>·<span><?echo $info['ProductI18n']['name']?><span>·</h1>

<?if(isset($galleries) && sizeof($galleries)){
?>

<div id="show_pic_original" onclick="javascript:show_pic_original();">
<?
echo $html->div('picc',$html->image($galleries[0]['ProductGallery']['img_detail'],array("id"=>"img1","alt"=>"","width"=>isset($SVConfigs['image_width'])?$SVConfigs['image_width']:441,"height"=>isset($SVConfigs['image_height'])?$SVConfigs['image_height']:391)),'',false);
?>
<input type="hidden" value="<?=$galleries[0]['ProductGallery']['img_detail']?>" id="img_original_src" />
</div>
<?
?>

<?if(isset($galleries) && sizeof($galleries)>0){?>
<?foreach($galleries as $k=>$g){?>
<div class="pic_select">
<? echo $html->link($html->image($g['ProductGallery']['img_detail'],array("alt"=>$g['ProductGallery']['description'])),"javascript:show_pic('".$g['ProductGallery']['img_detail']."');","",false,false);?></div>
<?}?>
<?}?>
<?
}else{?>

<?
echo $html->div('picc',$html->image("/img/product_default.jpg",array("id"=>"img1","alt"=>"","width"=>isset($SVConfigs['image_width'])?$SVConfigs['image_width']:441,"height"=>isset($SVConfigs['image_height'])?$SVConfigs['image_height']:391)),'',false);
?>
<?}?>
</div>
<div id="main_right" class="product_r">
<h1 class="headers"><span class="l"></span><span class="r"></span><?=$html->image("title_ico.gif")?><?=$SCLanguages['products'];?><?=$SCLanguages['information'];?></h1>

<div id="item_infos">
<!--ProductInfo-->
	<div class="item_box">
		<h2><?echo $info['ProductI18n']['name'];?></h2>
		<p class="left">&nbsp;</p>
		<ul>
		<?if (isset($SVConfigs['display_products_code']) && $SVConfigs['display_products_code'] == 1){ ?>
		<li><dd class="l"><?=$SCLanguages['sku'];?>: </dd><dd><?echo $info['Product']['code'];?></dd></li>
		<?}?>
		<?if(!empty($SVConfigs['show_product_category']) && $SVConfigs['show_product_category'] == 1){?>
		<li>
		<dd class="l"><?=$SCLanguages['classificatory'];?>:</dd>
		<dd>
		<?if(isset($categorys['CategoryI18n']['name'])){?>
		<?=$categorys['CategoryI18n']['name'];?>
		<?}else{?>
		<?php echo $SCLanguages['undefined'];?>
		<?}?></dd></li>
		<?}?>			
			
		<?if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
		<?if ($info['Product']['market_price']){?>
		<li><dd class="l"><?php echo $SCLanguages['market_price'];?>:</dd><dd>
		<?=$svshow->price_format($info['Product']['market_price'],$SVConfigs['price_format']);?>	
			</dd></li>
		<?}?>
		<?}?>
			
		<?if(isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price']> 0 && isset($my_product_rank) && $my_product_rank < $info['Product']['shop_price']){?>
		<li><dd class="l"><?//php echo $SCLanguages['membership_price'];?><?php echo $SCLanguages['our_price'];?>:</dd><dd>
		<?=$svshow->price_format($my_product_rank,$SVConfigs['price_format']);?>	
		</dd></li>
		<?}else{?>
		<li><dd class="l"><?php echo $SCLanguages['our_price'];?>:</dd><dd>
		<?=$svshow->price_format($info['Product']['shop_price'],$SVConfigs['price_format']);?>
		</dd></li>
		<?}?>
			
		<?if(isset($SVConfigs['show_product_type']) && $SVConfigs['show_product_type'] == 1 ){?>
		<li>
		<dd class="l"><?=$SCLanguages['type'];?>:</dd>
		<dd>
		<?if(isset($product_type['ProductTypeI18n']['name'])){?>
		<?echo $product_type['ProductTypeI18n']['name'];?>
		<?}else{?>
		<?php echo $SCLanguages['undefined'];?>
		<?}?></dd></li>
			<?//pr($format_product_attributes);?>
			<?if(isset($format_product_attributes) && sizeof($format_product_attributes)>0){?>
			<?foreach($format_product_attributes as $k=>$v){?>
				<li>
				<dd class="l"><?=$product_attributes_name[$k];?>:</dd>
				<dd>					<select>

					<?foreach($v as $kk=>$vv){?>
						<option><?=$vv['value']?>  [<?=$vv['price']?>]</option>
					<?}?>					</select>
</dd>
				</li>
					
			<?}}?>
			
		<?}?>

		<?if (isset($SVConfigs['products_show_brand']) && isset($brands[$info['Product']['brand_id']])){?>
		<li>
		<dd class="l"><?php echo $SCLanguages['brand'];?>:</dd>
		<dd><?=$brands[$info['Product']['brand_id']]['BrandI18n']['name'];?></dd></li>
		<?}?>

		<?if(!empty($SVConfigs['show_sale_stat']) && $SVConfigs['show_sale_stat'] == 1){?>
		<?if (isset($info['Product']['sale_stat'])){ ?>
		<li><dd class="l"><?php echo $SCLanguages['sales_this_term'];?>:</dd><dd><?echo $info['Product']['sale_stat'];?></dd></li>
		<?}?>
		<?}?>

		<?if(!empty($SVConfigs['show_view_stat']) && $SVConfigs['show_view_stat'] == 1){?>
		<?if (isset($info['Product']['view_stat'])){ ?>
		<li>
		<dd class="l"><?php echo $SCLanguages['view_number'];?>:</dd>
		<dd><?echo $info['Product']['view_stat'];?></dd></li>
		<?}?>
		<?}?>
		<?if(!empty($SVConfigs['show_stock']) && $SVConfigs['show_stock'] == 1 && (empty($info['Product']['extension_code']) || $info['Product']['extension_code']=='virtual_card')){?>
		<?if (isset($info['Product']['quantity'])){ ?>
		<li><dd class="l"><?=$SCLanguages['stock'];?>:</dd><dd><?echo $info['Product']['quantity'];?></dd></li>
		<?}?>
		<?}?>

		<?if(!empty($SVConfigs['show_weight']) && $SVConfigs['show_weight'] == 1 && $info['Product']['extension_code'] != 'virtual_card'){?>
		<?if (isset($info['Product']['weight'])){ ?>
		<li>
		<dd class="l"><?=$SCLanguages['weight'];?>:</dd>
		<dd><?echo $info['Product']['weight'];?><?=$SCLanguages['gram']?></dd></li>
		<?}?>                    	
		<?}?>
		<?php //print("---".$SVConfigs['show_onsale_time']);?>
		<?if (isset($SVConfigs['show_onsale_time']) && $SVConfigs['show_onsale_time'] == 1 && !empty($info['Product']['created'])){ ?>
		<li><dd class="l"><?=$SCLanguages['onsale'];?><?=$SCLanguages['time'];?>:</dd><dd><?echo date('Y-m-d',strtotime($info['Product']['created']));?></dd></li>
		<?}?> 			
		
		<?if(!empty($SVConfigs['show_weight']) && $SVConfigs['show_weight'] == 1){?>
		<?if ($info['Product']['point']>0){ ?>
		<li>
		<dd class="l"><?=$SCLanguages['receives']?><?=$SCLanguages['point']?>:</dd>
		<dd><?echo $info['Product']['point'];?><?=$SCLanguages['point_unit']?></dd></li>
		<?}?>                    	
		<?}?>
			
		<?if(!empty($SVConfigs['show_weight']) && $SVConfigs['show_weight'] == 1){?>
		<?if ($info['Product']['point_fee']>0){ ?>
		<li>
		<dd class="l"><?=$SCLanguages['users']?><?=$SCLanguages['point']?>:</dd>
		<dd><?echo $info['Product']['point_fee'];?><?=$SCLanguages['point_unit']?></dd></li>
		<?}?>  
			                  	
		<?}?>
		<?if(!empty($SVConfigs['show_weight']) && $SVConfigs['show_weight'] == 1){?>
		<?if (isset($coupon_type)){ ?>
		<li>
		<dd class="l"><?=$SCLanguages['receives']?><?=$SCLanguages['coupon']?>:</dd>
		<dd><?echo $coupon_type['CouponTypeI18n']['name'];?>[
		<?=$svshow->price_format($coupon_type['CouponType']['money'],$SVConfigs['price_format']);?>	
			]</dd></li>
		<?}?>                    	
		<?}?>		
		
			
			
			
		<?if(isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] == 1 && isset($my_product_rank)){?>
				<?if($my_product_rank < $info['Product']['shop_price']){?>
		<li><dd class="l"><?php echo $SCLanguages['membership_price'];?>:</dd><dd>
		<?=$svshow->price_format($my_product_rank,$SVConfigs['price_format']);?>	
			</dd></li>
		<?}?>
		<?}else if(!empty($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] == 2 && isset($product_ranks)){?>
				<?$is_show = 0;?>
			<?if(isset($product_ranks) && sizeof($product_ranks)>0){?>
				<?foreach($product_ranks as $k=>$v){?>
				<?if($v['UserRank']['user_price'] < $info['Product']['shop_price']){?>
				<?$is_show = 1;?>
				<?}}?>		<?if(isset($is_show) && $is_show == 1){?>		
		<li><dd class="l" style="">-<?php echo $SCLanguages['membership_price'];?>-</dd></li><?}?>
				<?foreach($product_ranks as $k=>$v){?>
				<?if($v['UserRank']['user_price'] < $info['Product']['shop_price']){?>
			<li><dd class="l"><?=$v['UserRankI18n'][0]['name']?>:</dd><dd>
		<?=$svshow->price_format($v['UserRank']['user_price'],$SVConfigs['price_format']);?>	
				<?}?>
		</dd></li>
		<?}}}?>

	
		<?if(isset($info['Product']['quantity']) && $info['Product']['quantity'] == 0){?>
		<li class="btn_list">
		<?if($SVConfigs['enable_out_of_stock_handle'] == 1){?>
		<a class="addfav" href="javascript:show_booking(<?=$info['Product']['id']?>,'<?=$info['ProductI18n']['name']?>')"><span><?=$SCLanguages['booking']?></span></a></li>
		<?}?>
		<?}else{?>
		<li><dd class="l number"><?=$SCLanguages['quantity'];?>:</dd><dt><input type="text" name="buy_num" id="buy_num" size="1" class="text_input" value="1"></dt></li>
		<li class="btn_list">
		<a class="addcart" href="javascript:buy_now(<?=$info['Product']['id']?>,document.getElementById('buy_num').value)"><span><?=$SCLanguages['buy']?></span></a>
		<a href="javascript:favorite(<?=$info['Product']['id']?>,'p')" class="addfav"><span><?=$SCLanguages['favorite']?></span></a>
		</ul><?=$html->image('thuoline.gif')?>
	<?}?>
	</div>
<!--End-->

<!--OtherInfo-->
<div id="item_info">
	<ul class="content_tab">
	<li id="one1" onmouseover="overtab('one',1,2)" class="hover"><span><?=$SCLanguages['products']?><?=$SCLanguages['information']?></span></li>
	<li id="one2" onmouseover="overtab('one',2,2)" ><span><?php echo $SCLanguages['others'];?></span></li>
	</ul>
	<div class="property">
		<div id="con_one_1" class='infos'><?=$info['ProductI18n']['description'];?></div>
		<div id="con_one_2" class='infos'>
		<? if(isset($product_attribute) && sizeof($product_attribute)>0){ ?>
		<?=$SCLanguages['product_attribute']?>:
		<?foreach($product_attribute as $key=>$v){
		echo "<br>".$v['Product_attribute']['name']."&nbsp;&nbsp;".$v['Product_attribute']['attr_value'].'<br/>';
		}}?></div>
	</div>
<p><?=$html->image("thuoline.gif")?></p>
</div>
<!--OtherInfo End-->

<?if(isset($relation_products) && $relation_products){?>
<!--关联商品-->
<div id="Correlation">
<h1 class="title_nobg item_title"><span><?=$html->image("icon_08.gif")?></span><?php echo $SCLanguages['related_products'];?></h1>
	<div id="Item_List" style="border:none;">
		<ul>
	<?if(isset($relation_products) && sizeof($relation_products)>0){?>
		<?foreach($relation_products as $k=>$r){
		echo $html->tag('li',$html->para('pic',	$html->link($html->image(empty($r['Product']['img_thumb'])?"/img/product_default.jpg":$r['Product']['img_thumb'],array('width'=>'108','height'=>'108',)),"/products/".$r['Product']['id']."/",'',false,false),array(),false)
			.$html->para('info',$html->tag('span',$html->link($r['ProductI18n']['name'],"/products/".$r['Product']['id']."/",array(),false,false),'name').
			$html->tag('span',$html->tag('font',$svshow->price_format($r['Product']['shop_price'],$SVConfigs['price_format'])	
		,array('color'=>'#F9630C')),'Price'),array(),false),'');
		}?>
	<?}?>
		</ul>
	</div>
</div>
<!--关联商品 End-->
<?}?>

<? if(isset($articles) && sizeof($articles)){ ?>
<!--关联文章-->
<p><?=$html->image("thuoline.gif")?></p>
<div id="Correlation_article">
	<h1 class="title_nobg item_title"><span><?=$html->image("icon_08.gif")?></span><?php echo $SCLanguages['related_article'];?></h1>
	<ul>
	<?foreach($articles as $k=>$a ){
			 echo $html->tag("li",
			 $html->image("li_icon.gif",array('align'=>'middle','alt'=>'li_icon.gif')).
			 $html->link($a['ArticleI18n']['title'],"/articles/".$a['Article']['id']."/",'',false,false),'',false);
	}?>
	</ul>
</div>
<!--关联文章 End-->
<?}?>

</div>
<!--用户评论-->
<div id="Edit_box">
	<div id="Edit_info" style="border:0;border-top:1px solid #909592;">
		<p class="note article_title" style="position:relative;">
		<span class='comment-left'></span><span class='comment-right'></span>
		<?=$SCLanguages['comments'];?>

		<?if($is_comments == 1){?>
		<a id="comments" class="comments"><span><?php echo $SCLanguages['issue_comments'];?></span></a>
		<?}?></p>
		<? echo $this->element('comment', array('cache'=>'+0 hour'));?>
		
		<div class="border" style="border-top:0;margin-left:0;position:relative;height:100%;">
		<span id="waitcheck"></span>
		<?if(isset($comments) && sizeof($comments)){foreach($comments as $k=>$c){?><div id="user_msg">
			<p class="msg_title"><span class="title"><?php echo $SCLanguages['comments'];?>:<?=$c['Comment']['name'] ?> <font color="#A7A9A8"><?=$c['Comment']['modified'] ?></font></span></p>
			<p class="msg_txt"><span><?=$c['Comment']['content'] ?></span></p>
		</div>
		
	<?if(isset($c['children']) && sizeof($c['children'])>0){foreach($c['children'] as $ck=>$cc){?>
		<div id="user_msg">
			<p class="msg_title"><span class="title"><?php echo $SCLanguages['reply'];?>:<?=$cc['Comment']['name'] ?> <font color="#A7A9A8"><?=$cc['Comment']['modified'] ?></font></span></p><p class="msg_txt"><span><?=$cc['Comment']['content'] ?></span>
			</p>
		</div>
		
	<?}}}}else{?>
	<!--无评论-->
		<div id="user_msg"><p align="center"><br /><span><?php echo $SCLanguages['no_comments_now'];?>!</span><br /><br /></p></div>
		<?}?>
	</div>
</div>
<!--用户评论End-->


</div>
</div>
</div>
