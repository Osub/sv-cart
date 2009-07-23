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
 * $Id: view.ctp 3195 2009-07-22 07:15:51Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link(array('/js/yui/yahoo-min.js','/js/yui/event-min.js'));?>
<div id="globalMain">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>	
<div id="main_left" class="product_l">
<h1>·<span><?php echo $info['ProductI18n']['name']?><span>·</h1>

<?php if(isset($galleries) && sizeof($galleries)){?>

<div id="show_pic_original" onclick="javascript:show_pic_original();">
<?php 
echo $html->div('picc',$html->image($galleries[0]['ProductGallery']['img_detail'],array("id"=>"img1","title"=>isset($galleries[0]['ProductGalleryI18n']['description'])?$galleries[0]['ProductGalleryI18n']['description']:"","alt"=>isset($galleries[0]['ProductGalleryI18n']['description'])?$galleries[0]['ProductGalleryI18n']['description']:'',"width"=>isset($SVConfigs['image_width'])?$SVConfigs['image_width']:441,"height"=>isset($SVConfigs['image_height'])?$SVConfigs['image_height']:391)),'',false);
?>
<input type="hidden" value="<?php echo $galleries[0]['ProductGallery']['img_detail']?>" id="img_original_src" />
</div>

	<?php if(isset($galleries) && sizeof($galleries)>0){?>
		<?php foreach($galleries as $k=>$g){?>
			<div class="pic_select">
				<?php echo $html->link($html->image($g['ProductGallery']['img_thumb'],array("title"=>isset($galleries[0]['ProductGalleryI18n']['description'])?$galleries[0]['ProductGalleryI18n']['description']:'',"alt"=>isset($g['ProductGalleryI18n']['description'])?$galleries[0]['ProductGalleryI18n']['description']:'' )),"javascript:show_pic('".$g['ProductGallery']['img_detail']."');","",false,false);?>
			</div>
		<?php }?>
	<?php }?>
<?php }else{?>

<?php 
echo $html->div('picc',$html->image("/img/product_default.jpg",array("id"=>"img1","alt"=>"","width"=>isset($SVConfigs['image_width'])?$SVConfigs['image_width']:441,"height"=>isset($SVConfigs['image_height'])?$SVConfigs['image_height']:391)),'',false);
?>
<?php }?>
</div>
<div id="main_right" class="product_r">
<h1 class="headers"><span class="l">&nbsp;</span><span class="r">&nbsp;</span><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."title_ico.gif":"title_ico.gif")?><?php echo $SCLanguages['products'];?><?php echo $SCLanguages['information'];?></h1>

<div id="item_infos">
<!--ProductInfo-->
	<div class="item_box">
		<h2><?php echo $info['ProductI18n']['name'];?></h2>
		<p class="left">&nbsp;</p>
		<ul>
		<?php if (isset($SVConfigs['show_product_code']) && $SVConfigs['show_product_code'] == 1){ ?>
		<li><dd class="l"><?php echo $SCLanguages['sku'];?>: </dd><dd><?php echo $info['Product']['code'];?></dd></li>
		<?php }?>
		<?php if(!empty($SVConfigs['show_product_category']) && $SVConfigs['show_product_category'] == 1){?>
		<li>
		<dd class="l"><?php echo $SCLanguages['classificatory'];?>:</dd>
		<dd>
		<?php if(isset($categorys['CategoryI18n']['name'])){?>
		<?php echo $categorys['CategoryI18n']['name'];?>
		<?php }else{?>
		<?php echo $SCLanguages['undefined'];?>
		<?php }?></dd></li>
		<?php }?>			
			
		<?php if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
		<?php if ($info['Product']['market_price']){?>
		<li>
			<dd class="l"><?php echo $SCLanguages['market_price'];?>:</dd>
			<dd><strike><?php echo $svshow->price_format($info['Product']['market_price'],$SVConfigs['price_format']);?></strike></dd>
		</li>
		<?php }?>
		<?php }?>
		<?php //pr($info['Product']);?>
		<?php if(isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price']> 0 && isset($my_product_rank)){?><?php // && $my_product_rank < $info['Product']['shop_price']?>
		<li><dd class="l"><?php //php echo $SCLanguages['membership_price'];?><?php echo $SCLanguages['our_price'];?>:</dd><dd>
		<?php echo $svshow->price_format($my_product_rank,$SVConfigs['price_format']);?>
		</dd></li>
		<?php }else{?>
		<li><dd class="l"><?php echo $SCLanguages['our_price'];?>:</dd><dd>
		<?php echo $svshow->price_format($info['Product']['shop_price'],$SVConfigs['price_format']);?>
		</dd></li>
		<?php }?>
			
		<?php if(isset($SVConfigs['show_product_type']) && $SVConfigs['show_product_type'] == 1 ){?>
		<li>
		<dd class="l"><?php echo $SCLanguages['type'];?>:</dd>
		<dd>
		<?php if(isset($product_type['ProductTypeI18n']['name'])){?>
		<?php echo $product_type['ProductTypeI18n']['name'];?>
		<?php }else{?>
		<?//php echo $SCLanguages['undefined'];?>
		<?php }?></dd></li>
			<?php //pr($format_product_attributes);?>
			<?php if(isset($format_product_attributes) && sizeof($format_product_attributes)>0){?>
				<?$fpa=0;?>
			<?php foreach($format_product_attributes as $k=>$v){?>
				<li>
				<dd class="l"><?php echo $product_attributes_name[$k];?>:</dd>
				<dd>
					<?if(sizeof($v)>1){?>
					<select id="attributes_<?php echo $fpa?>"><?php foreach($v as $kk=>$vv){?>
						<option value="<?php echo $vv['id']?>"><?php echo $vv['value']?>  
						<?php //=$svshow->price_format($vv['price'],$SVConfigs['price_format']);?>	
							</option>
					<?php }?></select>
							<?$fpa++;?>
						<?}else{?>
					<?php foreach($v as $kk=>$vv){?><?php echo $vv['value']?><?}?>
					<?}?>	
				</dd>
				</li>
			<?php }}?>
		<?php }?>

		<?php if (isset($SVConfigs['products_show_brand']) && isset($brands[$info['Product']['brand_id']])){?>
		<li>
		<dd class="l"><?php echo $SCLanguages['brand'];?>:</dd>
		<dd><?php echo $brands[$info['Product']['brand_id']]['BrandI18n']['name'];?></dd></li>
		<?php }?>

		<?php if(!empty($SVConfigs['show_sale_stat']) && $SVConfigs['show_sale_stat'] == 1){?>
		<?php if (isset($info['Product']['sale_stat'])){ ?>
		<li><dd class="l"><?php echo $SCLanguages['sales_this_term'];?>:</dd><dd><?php echo $info['Product']['sale_stat'];?></dd></li>
		<?php }?>
		<?php }?>

		<?php if(!empty($SVConfigs['show_view_stat']) && $SVConfigs['show_view_stat'] == 1){?>
		<?php if (isset($info['Product']['view_stat'])){ ?>
		<li>
		<dd class="l"><?php echo $SCLanguages['view_number'];?>:</dd>
		<dd><?php echo $info['Product']['view_stat'];?></dd></li>
		<?php }?>
		<?php }?>
		<?php if(!empty($SVConfigs['show_stock']) && $SVConfigs['show_stock'] == 1 && (empty($info['Product']['extension_code']) || $info['Product']['extension_code']=='virtual_card')){?>
		<?php if (isset($info['Product']['quantity'])){ ?>
		<li><dd class="l"><?php echo $SCLanguages['stock'];?>:</dd><dd><?php echo $info['Product']['quantity'];?></dd></li>
		<?php }?>
		<?php }?>

		<?php if(!empty($SVConfigs['show_weight']) && $SVConfigs['show_weight'] == 1 && $info['Product']['extension_code'] != 'virtual_card'){?>
		<?php if (isset($info['Product']['weight'])){ ?>
		<li>
		<dd class="l"><?php echo $SCLanguages['weight'];?>:</dd>
		<dd><?php echo $info['Product']['weight'];?><?php echo $SCLanguages['gram']?></dd></li>
		<?php }?>                    	
		<?php }?>
		<?php //print("---".$SVConfigs['show_onsale_time']);?>
		<?php if (isset($SVConfigs['show_onsale_time']) && $SVConfigs['show_onsale_time'] == 1 && !empty($info['Product']['created'])){ ?>
		<li><dd class="l"><?php echo $SCLanguages['onsale'];?><?php echo $SCLanguages['time'];?>:</dd><dd><?php echo date('Y-m-d',strtotime($info['Product']['created']));?></dd></li>
		<?php }?> 			
		
		<?php if(!empty($SVConfigs['show_weight']) && $SVConfigs['show_weight'] == 1){?>
		<?php if ($info['Product']['point']>0){ ?>
		<li>
		<dd class="l"><?php echo $SCLanguages['receives']?><?php echo $SCLanguages['point']?>:</dd>
		<dd><?php echo $info['Product']['point'];?><?php echo $SCLanguages['point_unit']?></dd></li>
		<?php }?>                    	
		<?php }?>
			
		<?php if(!empty($SVConfigs['show_weight']) && $SVConfigs['show_weight'] == 1){?>
		<?php if ($info['Product']['point_fee']>0){ ?>
		<li>
		<dd class="l"><?php echo $SCLanguages['users']?><?php echo $SCLanguages['point']?>:</dd>
		<dd><?php echo $info['Product']['point_fee'];?><?php echo $SCLanguages['point_unit']?></dd>
		</li>
		<?php }?>  
			                  	
		<?php }?>
		<?php if(!empty($SVConfigs['show_weight']) && $SVConfigs['show_weight'] == 1){?>
		<?php if (isset($coupon_type)){ ?>
		<li>
		<dd class="l"><?php echo $SCLanguages['receives']?><?php echo $SCLanguages['coupon']?>:</dd>
		<dd><?php echo $coupon_type['CouponTypeI18n']['name'];?>[ <?php echo $svshow->price_format($coupon_type['CouponType']['money'],$SVConfigs['price_format']);?> ]</dd>
		</li>
		<?php }?>                    	
		<?php }?>		
		<?php if(isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] == 1 && isset($my_product_rank)){?>
		<?php if($my_product_rank < $info['Product']['shop_price']){?>
		<li>
			<dd class="l"><?php echo $SCLanguages['membership_price'];?>:</dd>
			<dd><?php echo $svshow->price_format($my_product_rank,$SVConfigs['price_format']);?></dd>
		</li>
		<?php }?>
		<?php }else if(!empty($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] == 2 && isset($product_ranks)){?>
				<?php $is_show = 0;?>
			<?php if(isset($product_ranks) && sizeof($product_ranks)>0){?>
				<?php foreach($product_ranks as $k=>$v){?>
				<?php if($v['UserRank']['user_price'] < $info['Product']['shop_price']){?>
				<?php $is_show = 1;?>
				<?php }}?>
			<?php if(isset($is_show) && $is_show == 1){?>		
			<li><dd class="l" style="">-<?php echo $SCLanguages['membership_price'];?>-</dd></li>
			<?php }?>
			<?php foreach($product_ranks as $k=>$v){?>
			<?php if($v['UserRank']['user_price'] < $info['Product']['shop_price']){?>
			<li>
				<dd class="l"><?php echo $v['UserRankI18n'][0]['name']?>:</dd>
				<dd><?php echo $svshow->price_format($v['UserRank']['user_price'],$SVConfigs['price_format']);?></dd>
			</li>
			<?php }?>
		<?php }}}?>
		
		<?if(isset($product_volume) && sizeof($product_volume)>0){?>
		<li><strong><?=$SCLanguages['preferential_price_range']?></strong></li>
			<?foreach($product_volume as $k=>$v){?>
			<li><dd class="l"><?php echo $v['ProdcutVolume']['volume_number']?>:</dd><dd><?php echo $svshow->price_format($v['ProdcutVolume']['volume_price'],$SVConfigs['price_format']);?>	

			</dd></li>
			<?}?>
		<?}?>
		
		<?php if(isset($shipping_fee)){?>
		<li><dd class="l">-<?php echo $SCLanguages['shipping_fee'];?>-</dd><dd></li>
			<?php foreach($shipping_fee as $k=>$v){?>
			<li><dd class="l"><?php echo $v['shipping_name']?>:</dd><dd>
			<?php echo $svshow->price_format($v['shipping_fee'],$SVConfigs['price_format']);?>
			</dd></li>
			<?php }?>
		<?php }?>
	
		<?php if(isset($info['Product']['quantity']) && $info['Product']['quantity'] == 0){?>
		<li class="btn_list">
		<?php if($SVConfigs['enable_out_of_stock_handle'] == 1){?>
		<a class="addfav" href="javascript:show_booking(<?php echo $info['Product']['id']?>,'<?php echo $info['ProductI18n']['name']?>')"><span><?php echo $SCLanguages['booking']?></span></a>
		<?php }?>
		</li>
		<?php }else{?>
		<li><dd class="l number"><?php echo $SCLanguages['quantity'];?>:</dd><dt><input type="text" name="buy_num" id="buy_num" size="1" class="text_input" value="1"></dt></li>
		<li class="btn_list">
		<a href="javascript:buy_now(<?php echo $info['Product']['id']?>,document.getElementById('buy_num').value)" class="addfav"><span><?php echo $SCLanguages['buy']?></span></a>
		<?php if(isset($_SESSION['User'])){?>
			<a href="javascript:favorite(<?php echo $info['Product']['id']?>,'p')" class="addfav"><span><?php echo $SCLanguages['favorite']?></span></a>
		<?php }?></li>
	<!-- 加商品标签 -->
		<?php if(isset($SVConfigs['use_tag']) && $SVConfigs['use_tag'] == 1){?>					
		<li>
		<dd><input type="text" name="tag" id="tag" class="text_input" />&nbsp;</dd>
		<dd class="btn_list"><a href="javascript:add_tag(<?php echo $info['Product']['id']?>,'P',<?=isset($_SESSION['User']['User']['id'])?1:0;?>)" class="addfav"><span><?php echo $SCLanguages['add_to_my_tags']?></span></a></dd>
		</li>
		
		<li id='update_tag'>
		<?php if(isset($tags) && sizeof($tags)>0){?>
		<p><strong><?php echo $SCLanguages['products']?><?php echo $SCLanguages['tags']?></strong></p>
		
		<div style="padding-top:5px;"><?php foreach($tags as $k=>$v){?><span class="float_l" style="margin:0 10px 4px 0;"><a href="javascript:search_tag('<?php echo $v['TagI18n']['name']?>');"><?php echo $v['TagI18n']['name']?></a></span><?php }?></div>
		<?php }?>
		</li>	
		<?php }?>
	<!-- 加商品标签end -->			
	<?php }?>
	</ul>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'thuoline.gif':'thuoline.gif')?>
	</div>
<!--End-->

<!--OtherInfo-->
<div id="item_info">
	<ul class="content_tab">
	<li id="one1" onmouseover="overtab('one',1,2)" class="hover"><span><?php echo $SCLanguages['products']?><?php echo $SCLanguages['information']?></span></li>
	<li id="one2" onmouseover="overtab('one',2,2)" ><span><?php echo $SCLanguages['others'];?></span></li>
	</ul>
	<div class="property">
	<div id="con_one_1" class='infos'>
	<?php echo $info['ProductI18n']['description'];?>
	</div>
		<div id="con_one_2" class='infos'>
		<?php if(isset($product_attribute) && sizeof($product_attribute)>0){ ?>
		<?php echo $SCLanguages['product_attribute']?>:
		<?php foreach($product_attribute as $key=>$v){
		echo "<br>".$v['Product_attribute']['name']."&nbsp;&nbsp;".$v['Product_attribute']['attr_value'].'<br/>';
		}}?></div>
	</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."thuoline.gif":"thuoline.gif")?></p>
</div>
<!--OtherInfo End-->

<?php if(isset($relation_products) && $relation_products){?>
<!--关联商品-->
<div id="Correlation">
<h1 class="title_nobg item_title"><span><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."icon_08.gif":"icon_08.gif")?></span><?php echo $SCLanguages['related_products'];?></h1>
	<div id="Item_List" style="border:none;">
		<ul>
	<?php if(isset($relation_products) && sizeof($relation_products)>0){?>
		<?php foreach($relation_products as $k=>$r){
		echo $html->tag('li',$html->para('pic',	$html->link($html->image(empty($r['Product']['img_thumb'])?"/img/product_default.jpg":$r['Product']['img_thumb'],array('width'=>'108','height'=>'108',)),$svshow->sku_product_link($r['Product']['id'],$r['ProductI18n']['name'],$r['Product']['code'],$SVConfigs['use_sku']),'',false,false),array(),false)
			.$html->para('info',$html->tag('span',$html->link($r['ProductI18n']['name'],$svshow->sku_product_link($r['Product']['id'],$r['ProductI18n']['name'],$r['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false),'name').
			$html->tag('span',$html->tag('font',$svshow->price_format($r['Product']['shop_price'],$SVConfigs['price_format'])	
		,array('color'=>'#F9630C')),'Price'),array(),false),'');
		}?>
	<?php }?>
		</ul>
	</div>
</div>
<!--关联商品 End-->
<?php }?>

<?php if(isset($articles) && sizeof($articles)){ ?>
<!--关联文章-->
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."thuoline.gif":"thuoline.gif")?></p>
<div id="Correlation_article">
	<h1 class="title_nobg item_title"><span><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."icon_08.gif":"icon_08.gif")?></span><?php echo $SCLanguages['related_article'];?></h1>
	<ul>
	<?php foreach($articles as $k=>$a ){
			 echo $html->tag("li",
			 $html->image(isset($img_style_url)?$img_style_url."/"."li_icon.gif":"li_icon.gif",array('align'=>'middle','alt'=>'li_icon.gif')).
			 $html->link($a['ArticleI18n']['title'],"/articles/".$a['Article']['id']."/",'',false,false),'',false);
	}?>
	</ul>
</div>
<!--关联文章 End-->
<?php }?>

</div>

<!--用户评论-->
<div id="Edit_box">
	<div id="Edit_info" style="border:0;">
		<p class="note article_title" style="position:relative;">
		<span class='comment-left'></span><span class='comment-right'></span>
		<?php echo $SCLanguages['comments'];?>

		<?php if($is_comments == 1){?>
		<a id="comments" class="comments"><span><?php echo $SCLanguages['issue_comments'];?></span></a>
		<?php }?></p>
		<?php echo $this->element('comment', array('cache'=>'+0 hour'));?>
		<div class="border" style="border-top:0;margin-left:0;position:relative;height:100%;">
		<span id="waitcheck"></span>
		<?php if(isset($comments) && sizeof($comments)){foreach($comments as $k=>$c){?><div id="user_msg">
			<p class="msg_title"><span class="title"><?php echo $SCLanguages['comments'];?>:<?php echo $c['Comment']['name'] ?> <font color="#A7A9A8"><?php echo $c['Comment']['modified'] ?></font></span></p>
			<p class="msg_txt"><span><?php echo $c['Comment']['content'] ?></span></p>
		</div>
		
	<?php if(isset($c['children']) && sizeof($c['children'])>0){foreach($c['children'] as $ck=>$cc){?>
		<div id="user_msg">
			<p class="msg_title"><span class="title"><?php echo $SCLanguages['reply'];?>:<?php echo $cc['Comment']['name'] ?> <font color="#A7A9A8"><?php echo $cc['Comment']['modified'] ?></font></span></p><p class="msg_txt"><span><?php echo $cc['Comment']['content'] ?></span>
			</p>
		</div>
		
	<?php }}}}else{?>
	<!--无评论-->
		<div id="user_msg"><p align="center"><span><?php echo $SCLanguages['no_comments_now'];?>!</span></p></div>
		<?php }?>
	</div>
</div>
<!--用户评论End-->


</div>
</div>
</div>
<!--相册弹出 对话框 test-->
<div id="layer_gallery">
<?=$html->link($html->image("closelabel.gif"),"javascript:layer_gallery_hide();",array("class"=>"close"),false,false);?>
<p id="gallery_content"></p>
</div>
<!--End 相册弹出 对话框-->
