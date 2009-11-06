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
 * $Id: view.ctp 3522 2009-08-07 10:48:41Z shenyunfeng $
*****************************************************************************/
?>
<?php echo $javascript->link(array('/js/yui/yahoo-min.js','/js/yui/event-min.js'));?>
<div id="globalMain">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Left-->
<div id="main_left" class="product_l">
<div class="products_detail">
	<div class="products_show">
	<?php if(isset($galleries) && sizeof($galleries)){?>
	<div id="show_pic_original" onclick="javascript:show_pic_original('<?php echo $galleries[0]['ProductGallery']['img_original']?>');">
	<?php 
	echo $html->div('picc',$html->image($galleries[0]['ProductGallery']['img_detail'],array("id"=>"img1","title"=>isset($galleries[0]['ProductGalleryI18n']['description'])?$galleries[0]['ProductGalleryI18n']['description']:"","alt"=>isset($galleries[0]['ProductGalleryI18n']['description'])?$galleries[0]['ProductGalleryI18n']['description']:'',"width"=>isset($this->data['configs']['image_width'])?$this->data['configs']['image_width']:441,"height"=>isset($this->data['configs']['image_height'])?$this->data['configs']['image_height']:391)),'',false);
	?>
	<input type="hidden" value="<?php echo $galleries[0]['ProductGallery']['img_detail']?>" id="img_original_src" />
	</div>

		<?php if(isset($galleries) && sizeof($galleries)>0){?>
			<?php foreach($galleries as $k=>$g){?>
				<div class="pic_select">
					<?php echo $html->link($html->image($g['ProductGallery']['img_thumb'],array("title"=>isset($galleries[0]['ProductGalleryI18n']['description'])?$galleries[0]['ProductGalleryI18n']['description']:'',"alt"=>isset($g['ProductGalleryI18n']['description'])?$galleries[0]['ProductGalleryI18n']['description']:'' )),"javascript:show_pic_original('".$g['ProductGallery']['img_original']."');","",false,false);?>
				</div>
			<?php }?>
		<?php }?>
	<?php }else{?>

	<?php 
	echo $html->div('picc',$html->image("/img/product_default.jpg",array("id"=>"img1","alt"=>"","width"=>isset($this->data['configs']['image_width'])?$this->data['configs']['image_width']:441,"height"=>isset($this->data['configs']['image_height'])?$this->data['configs']['image_height']:391)),'',false);
	?>
	<?php }?>
	</div>
<!--ProductInfos-->
<!--ProductInfo-->
	<div class="property" onclick="alert(this.offsetWidth)">
		<h2><?php echo $this->data['product_view']['ProductI18n']['name'];?></h2>
		<ul>
		<?php if (isset($this->data['configs']['show_product_code']) && $this->data['configs']['show_product_code'] == 1){ ?>
		<li><dd class="l"><?php echo $this->data['languages']['sku'];?>: </dd><dd><?php echo $this->data['product_view']['Product']['code'];?></dd></li>
		<?php }?>
		<?php if(!empty($this->data['configs']['show_product_category']) && $this->data['configs']['show_product_category'] == 1){?>
		<li>
		<dd class="l"><?php echo $this->data['languages']['classificatory'];?>:</dd>
		<dd>
		<?php if(isset($categorys['CategoryI18n']['name'])){?>
		<?php echo $categorys['CategoryI18n']['name'];?>
		<?php }else{?>
		<?php echo $this->data['languages']['undefined'];?>
		<?php }?></dd></li>
		<?php }?>			
			
		<?php if(isset($this->data['configs']['show_market_price']) && $this->data['configs']['show_market_price'] == 1){?>
		<?php if ($this->data['product_view']['Product']['market_price']){?>
		<li>
			<dd class="l"><?php echo $this->data['languages']['market_price'];?>:</dd>
			<dd><strike>
			<?//php echo $svshow->price_format($this->data['product_view']['Product']['market_price'],$this->data['configs']['price_format']);?>
			
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($this->data['product_view']['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($this->data['product_view']['Product']['market_price'],$this->data['configs']['price_format']);?>	
			<?php }?>			
			</strike></dd>
		</li>
		<?php }?>
		<?php }?>

			
			<li><dd class="l"><?php echo $this->data['languages']['our_price'];?>:</dd>
		<cake:nocache><dd>
				<?php if($session->check('User.User.rank') && isset($this->data['product_ranks'][$this->data['product_view']['Product']['id']][$session->read('User.User.rank')]) && isset($this->data['configs']['show_member_level_price']) && $this->data['configs']['show_member_level_price'] >0){?>
						<?if($this->data['product_ranks'][$this->data['product_view']['Product']['id']][$session->read('User.User.rank')]['ProductRank']['is_default_rank'] == 1){?>
							<?//php echo $svshow->price_format($this->data['product_view']['Product']['shop_price']*$this->data['product_ranks'][$this->data['product_view']['Product']['id']][$session->read('User.User.rank')]['ProductRank']['discount'],$this->data['configs']['price_format']);?>	
						
							<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
								<?php echo $svshow->price_format($this->data['product_view']['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
							<?php }else{?>
								<?php echo $svshow->price_format($this->data['product_view']['Product']['shop_price'],$this->data['configs']['price_format']);?>	
							<?php }?>							
						
						<?}else{?>
							<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
								<?php echo $svshow->price_format($this->data['product_ranks'][$this->data['product_view']['Product']['id']][$session->read('User.User.rank')]['ProductRank']['product_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
							<?php }else{?>
								<?php echo $svshow->price_format($this->data['product_ranks'][$this->data['product_view']['Product']['id']][$session->read('User.User.rank')]['ProductRank']['product_price'],$this->data['configs']['price_format']);?>	
							<?php }?>							
							<?//php echo $svshow->price_format($this->data['product_ranks'][$this->data['product_view']['Product']['id']][$session->read('User.User.rank')]['ProductRank']['product_price'],$this->data['configs']['price_format']);?>	
						<?}?>
					<?//php echo $svshow->price_format($v['Product']['user_price'],$this->data['configs']['price_format']);?>	
				<?}else{?>
							<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
								<?php echo $svshow->price_format($this->data['product_view']['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
							<?php }else{?>
								<?php echo $svshow->price_format($this->data['product_view']['Product']['shop_price'],$this->data['configs']['price_format']);?>	
							<?php }?>							
						
					<?//php echo $svshow->price_format($this->data['product_view']['Product']['shop_price'],$this->data['configs']['price_format']);?>	
				<?}?></dd>
		</cake:nocache>
			</li>
		<?php if(isset($this->data['configs']['show_product_type']) && $this->data['configs']['show_product_type'] == 1){?>
		<li>
		<dd class="l"><?php echo $this->data['languages']['type'];?>:</dd>
		<dd>
		<?php if(isset($product_type['ProductTypeI18n']['name'])){?>
		<?php echo $product_type['ProductTypeI18n']['name'];?>
		<?php }else{?>
		<?//php echo $this->data['languages']['undefined'];?>
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
						<?php //=$svshow->price_format($vv['price'],$this->data['configs']['price_format']);?>	
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
		<cake:nocache>
		<?php if (isset($this->data['configs']['products_show_brand']) && isset($brands[$this->data['product_view']['Product']['brand_id']])){?>
		<li>
		<dd class="l"><?php echo $this->data['languages']['brand'];?>:</dd>
		<dd><?php echo $brands[$this->data['product_view']['Product']['brand_id']]['BrandI18n']['name'];?></dd></li>
		<?php }?>

		<?php if(!empty($this->data['configs']['show_sale_stat']) && $this->data['configs']['show_sale_stat'] == 1){?>
		<?php if (isset($this->data['product_view']['Product']['sale_stat'])){ ?>
		<li><dd class="l"><?php echo $this->data['languages']['sales_this_term'];?>:</dd><dd><?php echo $this->data['product_view']['Product']['sale_stat'];?></dd></li>
		<?php }?>
		<?php }?>

		<?php if(!empty($this->data['configs']['show_view_stat']) && $this->data['configs']['show_view_stat'] == 1){?>
		<?php if (isset($this->data['product_view']['Product']['view_stat'])){ ?>
		<li>
		<dd class="l"><?php echo $this->data['languages']['view_number'];?>:</dd>
		<dd><?php echo $this->data['product_view']['Product']['view_stat'];?></dd></li>
		<?php }?>
		<?php }?>
		<?php if(!empty($this->data['configs']['show_stock']) && $this->data['configs']['show_stock'] == 1 && (empty($this->data['product_view']['Product']['extension_code']) || $this->data['product_view']['Product']['extension_code']=='virtual_card')){?>
		<?php if (isset($this->data['product_view']['Product']['quantity'])){ ?>
		<li><dd class="l"><?php echo $this->data['languages']['stock'];?>:</dd><dd><?php echo $this->data['product_view']['Product']['quantity'];?></dd></li>
		<?php }?>
		<?php }?>

		<?php if(!empty($this->data['configs']['show_weight']) && $this->data['configs']['show_weight'] == 1 && $this->data['product_view']['Product']['extension_code'] != 'virtual_card'){?>
		<?php if (isset($this->data['product_view']['Product']['weight'])){ ?>
		<li>
		<dd class="l"><?php echo $this->data['languages']['weight'];?>:</dd>
		<dd><?php echo $this->data['product_view']['Product']['weight'];?><?php echo $this->data['languages']['gram']?></dd></li>
		<?php }?>                    	
		<?php }?>
		<?php //print("---".$this->data['configs']['show_onsale_time']);?>
		<?php if (isset($this->data['configs']['show_onsale_time']) && $this->data['configs']['show_onsale_time'] == 1 && !empty($this->data['product_view']['Product']['created'])){ ?>
		<li><dd class="l"><?php echo $this->data['languages']['onsale'];?><?php echo $this->data['languages']['time'];?>:</dd><dd><?php echo date('Y-m-d',strtotime($this->data['product_view']['Product']['created']));?></dd></li>
		<?php }?> 			
		
		<?php if(!empty($this->data['configs']['show_weight']) && $this->data['configs']['show_weight'] == 1){?>
		<?php if ($this->data['product_view']['Product']['point']>0){ ?>
		<li>
		<dd class="l"><?php echo $this->data['languages']['receives']?><?php echo $this->data['languages']['point']?>:</dd>
		<dd><?php echo $this->data['product_view']['Product']['point'];?><?php echo $this->data['languages']['point_unit']?></dd></li>
		<?php }?>                    	
		<?php }?>
			
		<?php if(!empty($this->data['configs']['show_weight']) && $this->data['configs']['show_weight'] == 1){?>
		<?php if ($this->data['product_view']['Product']['point_fee']>0){ ?>
		<li>
		<dd class="l"><?php echo $this->data['languages']['users']?><?php echo $this->data['languages']['point']?>:</dd>
		<dd><?php echo $this->data['product_view']['Product']['point_fee'];?><?php echo $this->data['languages']['point_unit']?></dd>
		</li>
		<?php }?>  
			                  	
		<?php }?>
		<?php if(!empty($this->data['configs']['show_weight']) && $this->data['configs']['show_weight'] == 1){?>
		<?php if (isset($this->data['cache_coupon_type'])){ ?>
		<li>
		<dd class="l"><?php echo $this->data['languages']['receives']?><?php echo $this->data['languages']['coupon']?>:</dd>
		<dd><?php echo $this->data['cache_coupon_type']['CouponTypeI18n']['name'];?>[ 
			<?//php echo $svshow->price_format($coupon_type['CouponType']['money'],$this->data['configs']['price_format']);?> 
			
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($this->data['cache_coupon_type']['CouponType']['money']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($this->data['cache_coupon_type']['CouponType']['money'],$this->data['configs']['price_format']);?>	
			<?php }?>			
			
			]</dd>
		</li>
		<?php }?>                    	
		<?php }?>		
		<?php if(isset($this->data['configs']['show_member_level_price']) && $this->data['configs']['show_member_level_price'] == 1 && isset($my_product_rank)){?>
		<?php if($this->data['cache_my_product_rank'] < $this->data['product_view']['Product']['shop_price']){?>
		<li>
			<dd class="l"><?php echo $this->data['languages']['membership_price'];?>:</dd>
			<dd><?//php echo $svshow->price_format($my_product_rank,$this->data['configs']['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($this->data['cache_my_product_rank']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($this->data['cache_my_product_rank'],$this->data['configs']['price_format']);?>	
			<?php }?>			
			
			</dd>
		</li>
		<?php }?>
		<?php }else if(!empty($this->data['configs']['show_member_level_price']) && $this->data['configs']['show_member_level_price'] == 2 && isset($this->data['cache_product_ranks'])){?>
				<?php $is_show = 0;?>
			<?php if(isset($this->data['cache_product_ranks']) && sizeof($this->data['cache_product_ranks'])>0){?>
				<?php foreach($this->data['cache_product_ranks'] as $k=>$v){?>
				<?php if($v['UserRank']['user_price'] < $this->data['product_view']['Product']['shop_price']){?>
				<?php $is_show = 1;?>
				<?php }}?>
			<?php if(isset($is_show) && $is_show == 1){?>		
			<li><dd class="l" style="">-<?php echo $this->data['languages']['membership_price'];?>-</dd></li>
			<?php }?>
			<?php foreach($this->data['cache_product_ranks'] as $k=>$v){?>
				
			<?php if($v['UserRank']['user_price'] < $this->data['product_view']['Product']['shop_price']){?>
			<li>
				<dd class="l"><?php echo $v['UserRankI18n'][0]['name']?>:</dd>
				<dd>
				<?//php echo $svshow->price_format($v['UserRank']['user_price'],$this->data['configs']['price_format']);?>
				
				<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
					<?php echo $svshow->price_format($v['UserRank']['user_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
				<?php }else{?>
					<?php echo $svshow->price_format($v['UserRank']['user_price'],$this->data['configs']['price_format']);?>	
				<?php }?>					
				
				</dd>
			</li>
			<?php }?>
		<?php }}}?>
		
		<?if(isset($this->data['cache_product_volume']) && sizeof($this->data['cache_product_volume'])>0){?>
		<li><strong><?=$this->data['languages']['preferential_price_range']?></strong></li>
			<?foreach($this->data['cache_product_volume'] as $k=>$v){?>
			<li><dd class="l"><?php echo $v['ProdcutVolume']['volume_number']?>:</dd><dd>
				<?//php echo $svshow->price_format($v['ProdcutVolume']['volume_price'],$this->data['configs']['price_format']);?>	
				<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
					<?php echo $svshow->price_format($v['ProdcutVolume']['volume_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
				<?php }else{?>
					<?php echo $svshow->price_format($v['ProdcutVolume']['volume_price'],$this->data['configs']['price_format']);?>	
				<?php }?>
			</dd></li>
			<?}?>
		<?}?>
		
		<?php if(isset($shipping_fee)){?>
		<li><dd class="l">-<?php echo $this->data['languages']['shipping_fee'];?>-</dd><dd></li>
			<?php foreach($shipping_fee as $k=>$v){?>
			<li><dd class="l"><?php echo $v['shipping_name']?>:</dd><dd>
				
			<?//php echo $svshow->price_format($v['shipping_fee'],$this->data['configs']['price_format']);?>
				<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
					<?php echo $svshow->price_format($v['shipping_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
				<?php }else{?>
					<?php echo $svshow->price_format($v['shipping_fee'],$this->data['configs']['price_format']);?>	
				<?php }?>				
				
			</dd></li>
			<?php }?>
		<?php }?>
	</cake:nocache>
		<?if(isset($colors_gallery) && sizeof($colors_gallery)>0){?>
		<li><dd class="l number">颜色:</dd>
		<dt>
		<?foreach($colors_gallery as $k=>$v){?>
			<?php echo $html->link($html->image($v['Product']['colors_gallery'],array('height'=>'20','width'=>'20')),'/products/'.$v['Product']['id'],array(),false,false)?>
		<?}?>
		</dt></li>
		<?}?>
		<?php if(isset($this->data['product_view']['Product']['quantity']) && $this->data['product_view']['Product']['quantity'] == 0){?>
		<li class="btn_list">
		<?php if($this->data['configs']['enable_out_of_stock_handle'] == 1){?>
		<a class="addfav" href="javascript:show_booking(<?php echo $this->data['product_view']['Product']['id']?>,'<?php echo $this->data['product_view']['ProductI18n']['name']?>')"><span><?php echo $this->data['languages']['booking']?></span></a>
		<?php }?>
		</li>
		<?php }else{?>
		<li><dd class="l number"><?php echo $this->data['languages']['quantity'];?>:</dd><dt><input type="text" name="buy_num" id="buy_num" size="1" class="text_input" value="1"></dt></li>
		<li class="btn_list">
		<a href="javascript:buy_now(<?php echo $this->data['product_view']['Product']['id']?>,document.getElementById('buy_num').value)" class="addfav"><span><?php echo $this->data['languages']['buy']?></span></a>
		<cake:nocache>
		<?php if($session->check('User.User.name')){?>
		<a href="javascript:favorite(<?php echo $this->data['product_view']['Product']['id']?>,'p')" class="addfav"><span><?php echo $this->data['languages']['favorite']?></span></a>
		<div style="display:none;"><a id="recommends"  class="addfav cursor"><span><?php echo $this->data['languages']['recommend']?></span></a></div>
		<?php echo $html->link('<span>'.$this->data['languages']['recommend'].'</span>',$this->data['server_host'].$this->data['user_webroot']."recommends/product/".$this->data['product_view']['Product']['id'],array(),false,false);?>
		<?php }?>
		</cake:nocache>
		<?php echo $form->end();?>
		
		
		
		</li>
	<!-- 加商品标签 -->
		<?php if(isset($this->data['configs']['use_tag']) && $this->data['configs']['use_tag'] == 1){?>					
		<li>
		<dd><input type="text" name="tag" id="tag" class="text_input" />&nbsp;</dd>
			
		<dd class="btn_list">
		<cake:nocache>
			<?php if($session->check('User.User.name')){?>
			<a href="javascript:add_tag(<?php echo $this->data['product_view']['Product']['id']?>,'P',1)" class="addfav">
			<?}else{?>
			<a href="javascript:add_tag(<?php echo $this->data['product_view']['Product']['id']?>,'P',0)" class="addfav">
			<?}?>
		<span><?php echo $this->data['languages']['add_to_my_tags']?></span></a>
		</cake:nocache>
			</dd>
		</li>
		
		<li>
		<cake:nocache>
		<?php if(isset($this->data['tags']) && sizeof($this->data['tags'])>0){?>		
		<p><strong><?php echo $this->data['languages']['products']?><?php echo $this->data['languages']['tags']?></strong></p>
		<?php }?>
			
		<div  id='update_tag'>
		<?php if(isset($this->data['tags']) && sizeof($this->data['tags'])>0){?>		
		<div class="tags">
			<?php 
				$tag_arr = array();
				foreach($this->data['tags'] as $k=>$v){?>
					<?php if(!in_array($v['TagI18n']['name'],$tag_arr)){?>
						<span class="float_l"><a href="javascript:search_tag('<?php echo $v['TagI18n']['name']?>');"><?php echo $v['TagI18n']['name']?></a></span>
					<?php
							$tag_arr[] = $v['TagI18n']['name'];
					}?>
			<?php }?>
		</div>
		<?php }?></div>
		</cake:nocache>
		</li>	
		<?php }?>
	<!-- 加商品标签end -->			
	<?php }?>
	</ul>
	</div>
<!--End-->

<!--ProductInfos End-->

</div>
<!--Left End-->
	
<div id="main_right" class="product_r">
<h1 class="headers"><span class="l">&nbsp;</span><span class="r">&nbsp;</span><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."title_ico.gif":"title_ico.gif")?><?php echo $this->data['languages']['products'];?><?php echo $this->data['languages']['information'];?></h1>

<div id="item_infos">

<!--OtherInfo-->
<div id="item_info">
	<ul class="content_tab">
	<li id="one1" onmouseover="overtab('one',1,2)" class="hover"><span><?php echo $this->data['languages']['products']?><?php echo $this->data['languages']['information']?></span></li>
	<li id="one2" onmouseover="overtab('one',2,2)" ><span><?php echo $this->data['languages']['others'];?></span></li>
	</ul>
	<div class="property">
	<div id="con_one_1" class='infos display'>
	<?php echo $this->data['product_view']['ProductI18n']['description'];?>
	</div>
	<div id="con_one_2" class='infos undisplay'>
	<?php if(isset($product_attribute) && sizeof($product_attribute)>0){ ?>
	<?php echo $this->data['languages']['product_attribute']?>:
	<?php foreach($product_attribute as $key=>$v){
	echo "<br>".$v['Product_attribute']['name']."&nbsp;&nbsp;".$v['Product_attribute']['attr_value'].'<br/>';
	}}?>
	</div>
	</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."thuoline.gif":"thuoline.gif")?></p>
</div>
<!--OtherInfo End-->

<?php if(isset($this->data['relation_products']) && $this->data['relation_products']){?>
<!--关联商品-->
<div id="Correlation">
<h1 class="title_nobg item_title"><span><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."icon_08.gif":"icon_08.gif")?></span><?php echo $this->data['languages']['related_products'];?></h1>
	<div id="Item_List" style="border:none;">
		<ul>
		<cake:nocache>
			<?php if(isset($this->data['relation_products']) && sizeof($this->data['relation_products'])>0){?>
				<?php foreach($this->data['relation_products'] as $k=>$r){
				echo $html->tag('li',$html->para('pic',	$html->link($html->image(empty($r['Product']['img_thumb'])?"/img/product_default.jpg":$r['Product']['img_thumb'],array('width'=>'108','height'=>'108',)),$svshow->sku_product_link($r['Product']['id'],$r['ProductI18n']['name'],$r['Product']['code'],$this->data['configs']['use_sku']),'',false,false),array(),false)
					.$html->para('info',$html->tag('span',$html->link($r['ProductI18n']['name'],$svshow->sku_product_link($r['Product']['id'],$r['ProductI18n']['name'],$r['Product']['code'],$this->data['configs']['use_sku']),array("target"=>"_blank"),false,false),'name').
					$html->tag('span',$html->tag('font',
					
					//$svshow->price_format($r['Product']['shop_price'],$this->data['configs']['price_format'])	
					(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')]))?
						 $svshow->price_format($r['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']):	
						 $svshow->price_format($r['Product']['shop_price'],$this->data['configs']['price_format'])
					
				,array('color'=>'#F9630C')),'Price'),array(),false),'');
				}?>
			<?php }?>
		</cake:nocache>
		</ul>
	</div>
</div>
<!--关联商品 End-->
<?php }?>

<?php if(isset($articles) && sizeof($articles)){ ?>
<!--关联文章-->
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."thuoline.gif":"thuoline.gif")?></p>
<br />
<div id="Correlation_article">

	<h1 class="item_title"><span><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."icon_08.gif":"icon_08.gif")?></span><?php echo $this->data['languages']['related_article'];?></h1>
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
<div class="Edit_box">
	<div id="Edit_info" style="border:none;">
		<p class="note article_title" style="position:relative;">
		<span class='comment-left'>&nbsp;</span><span class='comment-right'>&nbsp;</span>
		<?php echo $this->data['languages']['comments'];?>
		<?php if($is_comments == 1){?>
		<a id="comments" class="comments"><span><?php echo $this->data['languages']['issue_comments'];?></span></a>
		<?php }?></p>
		<?php echo $this->element('comment', array('cache'=>'+0 hour'));?>
		<div class="border" style="border-top:none;margin-left:none;position:relative;height:100%;">
		<span id="waitcheck"></span>
		<?php if(isset($comments) && sizeof($comments)){?>
		<?php foreach($comments as $k=>$c){?>
		<div id="user_msg">
			<p class="msg_title"><span class="title"><?php echo $this->data['languages']['comments'];?>:<?php echo $c['Comment']['name'] ?> <font color="#A7A9A8"><?php echo $c['Comment']['modified'] ?></font> 
			
			<?php if($c['Comment']['rank'] == '1'){?>
				<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'one.gif':'one.gif')?>
			<?php }elseif($c['Comment']['rank'] == '2'){?>
				<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'two.gif':'two.gif')?>
			<?php }elseif($c['Comment']['rank'] == '3'){?>
				<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'three.gif':'three.gif')?>
			<?php }elseif($c['Comment']['rank'] == '4'){?>
				<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'four.gif':'four.gif')?>
			<?php }elseif($c['Comment']['rank'] == '5'){?>
				<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'five.gif':'five.gif')?>				
			<?php }?>
								
			</span></p>
			<p class="msg_txt"><span><?php echo $c['Comment']['content'] ?></span></p>
		</div>
		
	<?php if(isset($c['children']) && sizeof($c['children'])>0){foreach($c['children'] as $ck=>$cc){?>
		<div id="user_msg">
			<p class="msg_title"><span class="title"><?php echo $this->data['languages']['reply'];?>:<?php echo $cc['Comment']['name'] ?> <font color="#A7A9A8"><?php echo $cc['Comment']['modified'] ?></font></span></p><p class="msg_txt"><span><?php echo $cc['Comment']['content'] ?></span>
			</p>
		</div>
		
	<?php }}}}else{?>
	<!--无评论-->
		<div class="not">
		<br />
		<strong><?php echo $this->data['languages']['no_comments_now'];?>!</strong>
		<br /><br />
		</div>
		<?php }?>
	</div>
	
</div>
<!--用户评论End-->



<!--用户提问-->
<div class="Edit_box">
	<div id="Edit_info" style="border:none;">
		<p class="note article_title" style="position:relative;">
		<span class='comment-left'>&nbsp;</span><span class='comment-right'>&nbsp;</span>
		<?php echo $this->data['languages']['message'];?>
		<a id="product_message" class="product_message"><span><?php echo $this->data['languages']['leave_message'];?></span></a></p>
		<?php echo $this->element('message', array('cache'=>'+0 hour'));?>
		<div class="border" style="border-top:none;margin-left:none;position:relative;height:100%;">
		<span id="waitcheck"></span>
		<?php if(isset($product_message) && sizeof($product_message)){?>
		<?php foreach($product_message as $k=>$c){?>
		<div id="user_msg">
			<p class="msg_title"><span class="title"><?php echo $this->data['languages']['message'];?>:<?php echo $c['UserMessage']['msg_title'] ?> <font color="#A7A9A8"><?php echo $c['UserMessage']['modified'] ?></font></span></p>
			<p class="msg_txt"><span><?php echo $c['UserMessage']['msg_content'] ?></span></p>
		</div>
		
	<?php if(isset($c['children']) && sizeof($c['children'])>0){foreach($c['children'] as $ck=>$cc){?>
		<div id="user_msg">
			<p class="msg_title"><span class="title"><?php echo $this->data['languages']['reply'];?>:<?php echo $cc['UserMessage']['msg_title'] ?> <font color="#A7A9A8"><?php echo $cc['UserMessage']['modified'] ?></font></span></p><p class="msg_txt"><span><?php echo $cc['UserMessage']['msg_content'] ?></span>
			</p>
		</div>
		
	<?php }}}}else{?>
	<!--无提问-->
		<div class="not">
		<br />
		<strong><?php echo $this->data['languages']['no_message'];?>!</strong>
		<br /><br />
		</div>
		<?php }?>
	</div>
	
</div>
<!--用户提问End-->


<!--用户相册-->
<?php if(isset($user_product_gallerie) && sizeof($user_product_gallerie)){?>
<div class="Edit_box">
	<div id="Edit_info" style="border:none;">
		<p class="note article_title" style="position:relative;">
		<span class='comment-left'>&nbsp;</span><span class='comment-right'>&nbsp;</span>
			<?php echo $this->data['languages']['photo_gallery'] ?>
		<a id="my_photos" class="my_photos"><span><?php echo $this->data['languages']['upload']?><?php echo $this->data['languages']['my_photos']?></span></a></p>
		<div class="border" style="border-top:none;margin-left:none;position:relative;height:100%;">
		<span id="waitcheck"></span>
		<?php foreach($user_product_gallerie as $k=>$v){?>
		<div id="user_msg">
			<p class="pic"><?php if($v['UserProductGallerie']['img'] != ""){?>
<?php echo $html->link($html->image($v['UserProductGallerie']['img'],
	array("alt"=>"","width"=>isset($this->data['configs']['thumbl_image_width'])?$this->data['configs']['thumbl_image_width']:108,
	"height"=>isset($this->data['configs']['thumb_image_height'])?$this->data['configs']['thumb_image_height']:108
	)),"javascript:show_pic_original('".$v['UserProductGallerie']['img']."')",array(),false,false);?>
<?php }?></p>
		</div>
		<?php }?>
	</div>
</div>
<?php }?>
<!--用户相册End-->
</div>
</div>
</div>
<!--相册弹出 对话框 test-->
<div id="layer_gallery">
<?=$html->link($html->image("closelabel.gif"),"javascript:layer_gallery_hide();",array("class"=>"close"),false,false);?>
<p id="gallery_content"></p>
</div>
<!--End 相册弹出 对话框-->

<!-- 推荐好友 -->
<div id="add_recommend" class="yui-overlay">
<div id="loginout" class="add_recommend">
<h1><?php echo $this->data['languages']['tell_a_friend'];?></h1>
	<div id="buyshop_box" class="border" style="background:#ffffff;width:auto;">
	<form action="" method="POST" name="recommendForm">
	<dl>
	<dd><?php echo $this->data['languages']['name'];?></dd>
	<dt><input type="text" size="32" class="text_input" name="data[recommend][name]" id="recommendName" value="" /></dt>
	</dl>
	<dl class="email">
	<dd><?php echo $this->data['languages']['friend'].$this->data['languages']['email_letter'];?></dd>
	<dt>
	<input type="text" size="32" class="text_input" name="data[recommend][email]" id="recommendEmail" value="" />
	<p id="recommend_error_msg" style="color:red;padding-top:5px;"></p></dt>
	</dl>
	
	<p class="buy_btn mar" style="padding:5px 119px 0 0;">
	<input type='hidden' name='data[recommend][type_id]' id="recommendTypeId" value ="<?php echo $id;?>" />
	<span id="recommend_button">
	<a href="javascript:document.recommendForm.reset();"><?php echo $this->data['languages']['reset'];?></a>
	<a href='javascript:submit_recommend();'><?php echo $this->data['languages']['submit'];?></a>
	</span></p>
	</form>
	</div>
</div>

</div>
<!-- 推荐好友END -->
<?php echo $this->element('my_photo', array('cache'=>'+0 hour'));?>
	