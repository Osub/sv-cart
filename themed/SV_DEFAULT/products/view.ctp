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
 * $Id: view.ctp 5261 2009-10-21 08:30:19Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link(array('/js/yui/yahoo-min.js','/js/yui/event-min.js'));?>
<div id="globalMain">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<?php if(isset($flashes['FlashImage']) && sizeof($flashes['FlashImage'])>0 && false){?>
<div id="Flash" style="margin-bottom:5px;">
<?php echo $flash->renderSwf('img/bcastr4.swf?xml='.$cart_webroot.'flashes/index/P/'.$this->data['product_view']['Product']['id'],$flashes['Flash']['width'],$flashes['Flash']['height'],false,array('params' => array('movie'=>$cart_webroot.'img/bcastr4.swf?xml='.$cart_webroot.'flashes/index/P/'.$this->data['product_view']['Product']['id'],'wmode'=>'Opaque')));?>
</div>
<?php }?>
	
	
<!--Left-->
<div id="main_left" class="product_l">
	<div class="product_infos">
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
		<div class="property font_color_1">
			<h2><?php echo $this->data['product_view']['ProductI18n']['name'];?></h2>
			<ul>
			<?php if (isset($this->data['configs']['show_product_code']) && $this->data['configs']['show_product_code'] == 1){ ?>
			<li><dl><dd class="l"><?php echo $this->data['languages']['sku'];?>: </dd><dd><?php echo $this->data['product_view']['Product']['code'];?></dd></dl></li>
			<?php }?>
			<?php if(!empty($this->data['configs']['show_product_category']) && $this->data['configs']['show_product_category'] == 1){?>
			<li><dl><dd class="l"><?php echo $this->data['languages']['classificatory'];?>:</dd>
			<dd>
			<?php if(isset($categorys['CategoryI18n']['name'])){?>
			<?php echo $categorys['CategoryI18n']['name'];?>
			<?php }else{?>
			<?php echo $this->data['languages']['undefined'];?>
			<?php }?></dd></dl></li>
			<?php }?>			
			
			<cake:nocache>
			<?php if(isset($this->data['configs']['show_market_price']) && $this->data['configs']['show_market_price'] == 1){?>
			<?php if ($this->data['product_view']['Product']['market_price']){?>
			<li><dl><dd class="l"><?php echo $this->data['languages']['market_price'];?>:</dd>
				<dd><strike>
				<?//php echo $svshow->price_format($this->data['product_view']['Product']['market_price'],$this->data['configs']['price_format']);?>
				
				<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
					<?php echo $svshow->price_format($this->data['product_view']['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
				<?php }else{?>
					<?php echo $svshow->price_format($this->data['product_view']['Product']['market_price'],$this->data['configs']['price_format']);?>	
				<?php }?></strike></dd></dl></li>
			<?php }?>
			<?php }?>
			</cake:nocache>
				
			<li><dl><dd class="l"><?php echo $this->data['languages']['our_price'];?>:</dd>
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
					<?}?></dd></cake:nocache></dl></li>
			<?php if(isset($this->data['configs']['show_product_type']) && $this->data['configs']['show_product_type'] == 1){?>
				<?php if(isset($product_type['ProductTypeI18n']['name']) && $product_type['ProductTypeI18n']['name'] == ""){?>
				<li><dl><dd class="l"><?php echo $this->data['languages']['type'];?>:</dd>
			<dd>
			<?php echo $product_type['ProductTypeI18n']['name'];?>
			<?php }else{?><?//php echo $this->data['languages']['undefined'];?>
			<?php }?></dd></dl></li>
				<?php //pr($format_product_attributes);?>
				<?php if(isset($format_product_attributes) && sizeof($format_product_attributes)>0){?>
					<?$fpa=0;?>
				<?php foreach($format_product_attributes as $k=>$v){?>
			<li style="display:none;"><dl><dd class="l"><?php echo $product_attributes_name[$k];?>:</dd>
			<dd><?if(sizeof($v)>1){?>
			<select id="del_attributes_<?php echo $fpa?>">
				<?php foreach($v as $kk=>$vv){?>
					<option value="<?php echo $vv['id']?>"><?php echo $vv['value']?>  
						<?php //=$svshow->price_format($vv['price'],$this->data['configs']['price_format']);?>	
					</option>
				<?php }?>
			</select>
			<?$fpa++;?>
			<?}else{?>
			<?php foreach($v as $kk=>$vv){?><?php echo $vv['value']?><?}?>
			<?}?>	
			</dd></dl></li>
			<?php }}?>
			<?php }?>
			<cake:nocache>
			<?php if (isset($this->data['configs']['products_show_brand']) && isset($brands[$this->data['product_view']['Product']['brand_id']])){?>
			<li><dl><dd class="l"><?php echo $this->data['languages']['brand'];?>:</dd><dd><?php echo $brands[$this->data['product_view']['Product']['brand_id']]['BrandI18n']['name'];?></dd></dl></li>
			<?php }?>
	
			<?php if(!empty($this->data['configs']['show_sale_stat']) && $this->data['configs']['show_sale_stat'] == 1){?>
			<?php if (isset($this->data['product_view']['Product']['sale_stat'])){ ?>
			<li><dl><dd class="l"><?php echo $this->data['languages']['sales_this_term'];?>:</dd><dd><?php echo $this->data['product_view']['Product']['sale_stat'];?></dd></dl></li>
			<?php }?>
			<?php }?>
	
			<?php if(!empty($this->data['configs']['show_view_stat']) && $this->data['configs']['show_view_stat'] == 1){?>
			<?php if (isset($this->data['product_view']['Product']['view_stat'])){ ?>
			<li><dl><dd class="l"><?php echo $this->data['languages']['view_number'];?>:</dd><dd><?php echo $this->data['product_view']['Product']['view_stat'];?></dd></dl></li>
			<?php }?>
			<?php }?>
			<?php if(!empty($this->data['configs']['show_stock']) && $this->data['configs']['show_stock'] == 1 && (empty($this->data['product_view']['Product']['extension_code']) || $this->data['product_view']['Product']['extension_code']=='virtual_card')){?>
			<?php if (isset($this->data['product_view']['Product']['quantity'])){ ?>
			<li><dl><dd class="l"><?php echo $this->data['languages']['stock'];?>:</dd><dd><?php echo $this->data['product_view']['Product']['quantity'];?></dd></dl></li>
			<?php }?>
			<?php }?>
	
			<?php if(!empty($this->data['configs']['show_weight']) && $this->data['configs']['show_weight'] == 1 && $this->data['product_view']['Product']['extension_code'] != 'virtual_card'){?>
			<?php if (isset($this->data['product_view']['Product']['weight'])){ ?>
			<li><dl><dd class="l"><?php echo $this->data['languages']['weight'];?>:</dd><dd><?php echo $this->data['product_view']['Product']['weight'];?><?php echo $this->data['languages']['gram']?></dd></dl></li>
			<?php }?>                    	
			<?php }?>
			<?php //print("---".$this->data['configs']['show_onsale_time']);?>
			<?php if (isset($this->data['configs']['show_onsale_time']) && $this->data['configs']['show_onsale_time'] == 1 && !empty($this->data['product_view']['Product']['created'])){ ?>
			<li><dl><dd class="l"><?php echo $this->data['languages']['onsale'];?><?php echo $this->data['languages']['time'];?>:</dd><dd><?php echo date('Y-m-d',strtotime($this->data['product_view']['Product']['created']));?></dd></dl></li>
			<?php }?> 			
			
			<?php if(!empty($this->data['configs']['show_weight']) && $this->data['configs']['show_weight'] == 1){?>
			<?php if ($this->data['product_view']['Product']['point']>0){ ?>
			<li><dl><dd class="l"><?php echo $this->data['languages']['receives']?><?php echo $this->data['languages']['point']?>:</dd><dd><?php echo $this->data['product_view']['Product']['point'];?><?php echo $this->data['languages']['point_unit']?></dd></dl></li>
			<?php }?>                    	
			<?php }?>
				
			<?php if(!empty($this->data['configs']['show_weight']) && $this->data['configs']['show_weight'] == 1){?>
			<?php if ($this->data['product_view']['Product']['point_fee']>0){ ?>
			<li><dl><dd class="l"><?php echo $this->data['languages']['users']?><?php echo $this->data['languages']['point']?>:</dd><dd><?php echo $this->data['product_view']['Product']['point_fee'];?><?php echo $this->data['languages']['point_unit']?></dd></dl></li>
			<?php }?>  
									
			<?php }?>
			<?php if(!empty($this->data['configs']['show_weight']) && $this->data['configs']['show_weight'] == 1){?>
			<?php if (isset($this->data['cache_coupon_type'])){ ?>
			<li><dl><dd class="l"><?php echo $this->data['languages']['receives']?><?php echo $this->data['languages']['coupon']?>:</dd><dd><?php echo $this->data['cache_coupon_type']['CouponTypeI18n']['name'];?>[ 
				<?//php echo $svshow->price_format($coupon_type['CouponType']['money'],$this->data['configs']['price_format']);?> 
				
				<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
					<?php echo $svshow->price_format($this->data['cache_coupon_type']['CouponType']['money']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
				<?php }else{?>
					<?php echo $svshow->price_format($this->data['cache_coupon_type']['CouponType']['money'],$this->data['configs']['price_format']);?>	
				<?php }?>			
				]</dd></dl></li>
			<?php }?>
			<?php }?>
			<?php if(isset($this->data['configs']['show_member_level_price']) && $this->data['configs']['show_member_level_price'] == 1 && isset($my_product_rank)){?>
			<?php if($this->data['cache_my_product_rank'] < $this->data['product_view']['Product']['shop_price']){?>
			<li><dl><dd class="l"><?php echo $this->data['languages']['membership_price'];?>:</dd><dd><?//php echo $svshow->price_format($my_product_rank,$this->data['configs']['price_format']);?>
				<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
					<?php echo $svshow->price_format($this->data['cache_my_product_rank']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
				<?php }else{?>
					<?php echo $svshow->price_format($this->data['cache_my_product_rank'],$this->data['configs']['price_format']);?>	
				<?php }?></dd></dl></li>
			<?php }?>
			<?php }else if(!empty($this->data['configs']['show_member_level_price']) && $this->data['configs']['show_member_level_price'] == 2 && isset($this->data['cache_product_ranks'])){?>
					<?php $is_show = 0;?>
				<?php if(isset($this->data['cache_product_ranks']) && sizeof($this->data['cache_product_ranks'])>0){?>
					<?php foreach($this->data['cache_product_ranks'] as $k=>$v){?>
					<?php if($v['UserRank']['user_price'] < $this->data['product_view']['Product']['shop_price']){?>
					<?php $is_show = 1;?>
					<?php }}?>
				<?php if(isset($is_show) && $is_show == 1){?>		
				<li><dl><dd class="l" style="">-<?php echo $this->data['languages']['membership_price'];?>-</dd></dl></li>
				<?php }?>
				<?php foreach($this->data['cache_product_ranks'] as $k=>$v){?>
					
				<?php if($v['UserRank']['user_price'] < $this->data['product_view']['Product']['shop_price']){?>
				<li><dl><dd class="l"><?php echo $v['UserRankI18n'][0]['name']?>:</dd><dd>
					<?//php echo $svshow->price_format($v['UserRank']['user_price'],$this->data['configs']['price_format']);?>
					<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
						<?php echo $svshow->price_format($v['UserRank']['user_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
					<?php }else{?>
						<?php echo $svshow->price_format($v['UserRank']['user_price'],$this->data['configs']['price_format']);?>	
					<?php }?></dd></dl></li>
				<?php }?>
			<?php }}}?>
			
			<?if(isset($this->data['cache_product_volume']) && sizeof($this->data['cache_product_volume'])>0){?>
			<li><strong><?=$this->data['languages']['preferential_price_range']?></strong></li>
				<?foreach($this->data['cache_product_volume'] as $k=>$v){?>
				<li><dl><dd class="l"><?php echo $v['ProdcutVolume']['volume_number']?>:</dd><dd>
					<?//php echo $svshow->price_format($v['ProdcutVolume']['volume_price'],$this->data['configs']['price_format']);?>	
					<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
						<?php echo $svshow->price_format($v['ProdcutVolume']['volume_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
					<?php }else{?>
						<?php echo $svshow->price_format($v['ProdcutVolume']['volume_price'],$this->data['configs']['price_format']);?>	
					<?php }?>
				</dd></dl></li>
				<?}?>
			<?}?>
			
			<?php if(isset($shipping_fee)){?>
			<li><dl><dd class="l">-<?php echo $this->data['languages']['shipping_fee'];?>-</dd></dl></li>
				<?php foreach($shipping_fee as $k=>$v){?>
			<li><dl><dd class="l"><?php echo $v['shipping_name']?>:</dd><dd>
			<?//php echo $svshow->price_format($v['shipping_fee'],$this->data['configs']['price_format']);?>
				<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
					<?php echo $svshow->price_format($v['shipping_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
				<?php }else{?>
					<?php echo $svshow->price_format($v['shipping_fee'],$this->data['configs']['price_format']);?>	
				<?php }?></dd></dl></li>
			<?php }?>
			<?php }?>
		</cake:nocache>
			<!--Size-->
			<?php if(isset($format_product_attributes) && sizeof($format_product_attributes)>0 && $this->data['configs']['products_attribute_show_type'] == '1'){?>
				<?$fpa=0;?>
				<?php foreach($format_product_attributes as $k=>$v){?>
					<?php if(isset($product_attributes_name[$k]['name']) && $product_attributes_name[$k]['type'] == "buy"){?>
							<li><dl><dd class="l number"><?php echo $product_attributes_name[$k]['name'];?>:</dd>
								<dt class="sizes">
								<?if(sizeof($v)>1){?><?php $attr_key=0;?>
									<input type="hidden" name="attributes_<?php echo $fpa?>" id="attributes_<?php echo $fpa?>" value="" />
										<?php foreach($v as $kk=>$vv){?>
											<a href="javascript:select_attribute(<?php echo $fpa;?>,<?php echo $vv['id'];?>,<?php echo $attr_key?>);" id="attributes_<?php echo $fpa?>_<?php echo $attr_key?>" onfocus="blur()"><?php echo $vv['value']?></a>
											<?php if($attr_key == '0'){?>
												<script  type="text/javascript">
													 select_attribute(<?php echo $fpa;?>,<?php echo $vv['id'];?>,<?php echo $attr_key?>);
												</script>
											<?php }?>										
											<?php $attr_key++;?>
										<?php }?>
									<?$fpa++;?>
							<?php }else{?>
										<?php foreach($v as $kk=>$vv){ echo $vv['value']; }?>
							<?php }?>										
								</dt></dl></li>	
					<?php }?>
				<?php }?>
			<?php }?>
			<!--Size End-->
			<?if(isset($colors_gallery) && sizeof($colors_gallery)>0){?>
			<li><dl><dd class="l number"><?php echo $this->data['languages']['style']?>:</dd>
			<dt class="colors">
			<?foreach($colors_gallery as $k=>$v){?><?php if($v['Product']['colors_gallery'] != ""){?>
				<?php if($v['Product']['id'] == $this->data['product_view']['Product']['id']){?>
					<?php echo $html->link($html->image($v['Product']['colors_gallery'],array('height'=>'28','width'=>'28','alt'=>$v['ProductI18n']['style_name'])),'/products/'.$v['Product']['id'],array('id'=>$this->data['product_view']['Product']['id'],'title'=>$v['ProductI18n']['style_name'],'class'=>'color_hover'),false,false)?>
				<?php }else{?>
					<?php echo $html->link($html->image($v['Product']['colors_gallery'],array('height'=>'28','width'=>'28','alt'=>$v['ProductI18n']['style_name'])),'/products/'.$v['Product']['id'],array('title'=>$v['ProductI18n']['style_name'],"onmouseover"=>"javascript:onfocus_style(this,".$this->data['product_view']['Product']['id'].");","onmouseout"=>"javascript:onblur_style(this,".$this->data['product_view']['Product']['id'].");"),false,false)?>
				<?php }?>
			<?php }?><?}?>
			</dt></dl></li>
			<?}?>
			<?php if(isset($this->data['product_view']['Product']['quantity']) && $this->data['product_view']['Product']['quantity'] == 0){?>
			<li class="action">
			<?php if($this->data['configs']['enable_out_of_stock_handle'] == 1){?>
			<a href="javascript:show_booking(<?php echo $this->data['product_view']['Product']['id']?>,'<?php echo $this->data['product_view']['ProductI18n']['name']?>')" class="button_1"><span><?php echo $this->data['languages']['booking']?></span></a>
			<?php }?></li>
			<?php }else{?>
			<li><dl><dd class="l number"><?php echo $this->data['languages']['quantity'];?>:</dd><dt><input type="text" name="buy_num" id="buy_num" size="1" class="text_input" value="1"/></dt></dl></li>
			<li class="action">
			<a href="javascript:buy_now(<?php echo $this->data['product_view']['Product']['id']?>,document.getElementById('buy_num').value)" class="button_1"><span><?php echo $this->data['languages']['buy']?></span></a>
			<cake:nocache>
			<?php if($session->check('User.User.name')){?>
			<a href="javascript:favorite(<?php echo $this->data['product_view']['Product']['id']?>,'p')" class="button_1"><span><?php echo $this->data['languages']['favorite']?></span></a>
			<a id="recommends" style="display:none;" class="button_1"><span><?php echo $this->data['languages']['recommend']?></span></a>
			<?php echo $html->link('<span>'.$this->data['languages']['recommend'].'</span>',$this->data['server_host'].$this->data['user_webroot']."recommends/product/".$this->data['product_view']['Product']['id'],array("class"=>"button_1"),false,false);?>
			<?php }?>
			</cake:nocache>
			<?//php echo $form->end();?>
			</li>
		<?php }?>
		</ul>
		</div>
	<!--ProductInfos End-->
	
	<div class="products_detail">
<cake:nocache>
<?php if(isset($this->data['relation_products']) && sizeof($this->data['relation_products'])>0){?>
<!--关联商品-->
<div class="related_products">
<ul class="content_tab"><li class="hover"><span><?php echo $this->data['languages']['related_products'];?></span></li></ul>
	<div class="border Item_List">
		<ul>
			<?php if(isset($this->data['relation_products']) && sizeof($this->data['relation_products'])>0){?>
				<?php foreach($this->data['relation_products'] as $k=>$r){?>
				<li>
					<p class="pic">
					<?php echo $svshow->productimagethumb($r['Product']['img_thumb'],$svshow->sku_product_link($r['Product']['id'],$r['ProductI18n']['name'],$r['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$r['ProductI18n']['name'],'width'=>80,'height'=>80),$this->data['configs']['products_default_image']);?>
					</p>
					<p class="info">
					<span class="name"><?php echo $html->link($r['ProductI18n']['name'],$svshow->sku_product_link($r['Product']['id'],$r['ProductI18n']['name'],$r['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank"),false,false);?></span>
					<span class="Price"><font color='#F9630C'><?php echo (isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')]))?
						 $svshow->price_format($r['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']):	
						 $svshow->price_format($r['Product']['shop_price'],$this->data['configs']['price_format']);?></font></span>
					</p>
				</li>
					
				<?php }?>
			<?php }?>
		</ul>
	</div>
</div>
<!--关联商品 End-->
<?php }?>
</cake:nocache>
<!--OtherInfo-->
<?php if(isset($format_product_attributes) && sizeof($format_product_attributes)>0 && $this->data['configs']['products_attribute_show_type'] == '1'){?>
<div class="detail font_color_1">
	<h4><?php echo $this->data['languages']['products']?><?php echo $this->data['languages']['information']?></h4>
	<div class="height_10">&nbsp;</div>
	<table cellpadding="2" cellspacing="0" width="100%">
		<?php foreach($format_product_attributes as $k=>$v){?>
			<?php if(isset($product_attributes_name[$k]['name']) && $product_attributes_name[$k]['type'] == "basic"){?>
				<tr>
					<td width="16%"><?php echo $product_attributes_name[$k]['name'];?>：</td>
					<td width="84%">
					<?php if(sizeof($v) == 1){?>
					<?php foreach($v as $c){?><?php echo $c['value'];?><?php }?>
					<?php }else{?>								
						<select name="format_product_attributes_basic_<?php echo $k?>" >
						<?php foreach($v as $c){?><option value="<?php echo $c['value'];?>"><?php echo $c['value'];?></option><?php }?>
						</select>
					<?php }?>
					</td>
				</tr>
			<?php }?>
		<?php }?>
	</table>
		
<?php if(isset($format_product_attributes) && sizeof($format_product_attributes)>0 && $this->data['configs']['products_attribute_show_type'] == '1'){?>
	<table cellpadding="2" cellspacing="0" width="100%">
		<?php foreach($format_product_attributes as $k=>$v){?>
			<?php if(isset($product_attributes_name[$k]['name']) && $product_attributes_name[$k]['type'] == "special"){?>
				<tr>
					<td width="16%"><?php echo $product_attributes_name[$k]['name'];?>：</td>
					<td width="84%">
					<?php if(sizeof($v) == 1){?>
					<?php foreach($v as $c){?><?php echo $c['value'];?><?php }?>
					<?php }else{?>								
						<select name="format_product_attributes_special_<?php echo $k?>" >
						<?php foreach($v as $c){?><option value="<?php echo $c['value'];?>"><?php echo $c['value'];?></option><?php }?>
						</select>
					<?php }?>
					</td>
				</tr>
			<?php }?>
		<?php }?>
	</table>
<?php }?>		
		
		
</div>
<?php }?>
		
		
<!--OtherInfo End-->
	</div>
	<div class="height_10">&nbsp;</div><div class="height_10">&nbsp;</div>
	<div class="products_detail">
	<h4><?php echo $this->data['languages']['products'];?><?php echo $this->data['languages']['description'];?></h4>
		<div class="description"><?php echo $this->data['product_view']['ProductI18n']['description'];?></div>
	</div>
<!-- 品牌信息 -->
<?php if(isset($product_brand)){?>
	<div class="height_10">&nbsp;</div><div class="height_10">&nbsp;</div>
	<div class="products_detail">
	<h4><?php echo $this->data['languages']['brand'];?><?php echo $this->data['languages']['description'];?></h4>
		<div class="description"><?php echo $this->data['product_brand']['BrandI18n']['description'];?></div>
	</div>		
<?php }?>
<!-- 品牌信息 End-->
		
	</div>
</div>
<div class="height_5">&nbsp;</div>
	<div class="products_detail">
	<!--用户评论-->
	<div class="cont">
		<div class="head"><span class='left'>&nbsp;</span><span class='right'>&nbsp;</span>
			<?php echo $this->data['languages']['comments'];?>
			<?php if($is_comments == 1 && $this->data['configs']['products_comment_condition'] != '3'){?>
			<a id="comments" class="action"><?php echo $this->data['languages']['issue_comments'];?></a>
			<?php }?>
		</div>
		<?php echo $this->element('comment', array('cache'=>'+0 hour'));?>
		<div class="box comments">
		<span id="waitcheck"></span>
		<?php if(isset($comments) && sizeof($comments)){?>
		<?php foreach($comments as $k=>$c){?>
				<p class="msg_title">
					<span class="float_r">
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
					
					</span>
					
					<?php echo $this->data['languages']['comments'];?>:<?php echo $c['Comment']['name'] ?> <font color="#A7A9A8"><?php echo $c['Comment']['modified'] ?></font></p>
				<div class="message_cont" <?php if($k==(sizeof($comments)-1)){?>style="border:none;padding-bottom:0;"<?php }?>><?php echo $c['Comment']['content'] ?></div>
					
		<?php if(isset($c['children']) && sizeof($c['children'])>0){foreach($c['children'] as $ck=>$cc){?>
				<p class="msg_title"><?php echo $this->data['languages']['reply'];?>:<?php echo $cc['Comment']['name'] ?> <font color="#A7A9A8"><?php echo $cc['Comment']['modified'] ?></font></p>
				<div class="message_cont" <?php if($k==(sizeof($comments)-1)){?>style="border:none;padding-bottom:0;"<?php }?>><?php echo $cc['Comment']['content'] ?></div>
		<?php }}}}else{?>
		<!--无评论-->
			<div class="not">
			<br />
			<strong><?php echo $this->data['languages']['no_comments_now'];?>!</strong>
			<br /><br />
			</div>
			<?php }?></div></div>
	<!--用户评论End 		-->
<div class="height_5">&nbsp;</div>
<!--用户提问-->
	<div class="cont">
		<div class="head"><span class='left'>&nbsp;</span><span class='right'>&nbsp;</span>
		<?php echo $this->data['languages']['questions'];?>
		<a id="product_message" class="action"><?php echo $this->data['languages']['question'];?></a>
		</div>
		<?php echo $this->element('message', array('cache'=>'+0 hour'));?>
		<div class="box comments">
		<?php if(isset($product_message) && sizeof($product_message)){?>
		<?php foreach($product_message as $k=>$c){?>
			<p class="msg_title"><?php echo $this->data['languages']['questions'];?>:<?php echo $c['UserMessage']['msg_title'] ?> <font color="#A7A9A8"><?php echo $c['UserMessage']['modified'] ?></font></p>
			<div class="height_10">&nbsp;</div>
			<div class="message_cont" <?php if($k==(sizeof($product_message)-1)){?>style="border:none;padding-bottom:0;"<?php }?>><?php echo $c['UserMessage']['msg_content'] ?></div>
		
	<?php if(isset($c['Reply']) && sizeof($c['Reply'])>0){foreach($c['Reply'] as $ck=>$cc){?>
			<p class="msg_title"><?php echo $this->data['languages']['reply'];?>:<?php echo $cc['UserMessage']['msg_title'] ?> <font color="#A7A9A8"><?php echo $cc['UserMessage']['modified'] ?></font></p>
			<div class="height_10">&nbsp;</div>
			<div class="message_cont" <?php if($k==(sizeof($product_message)-1)){?>style="border:none;padding-bottom:0;"<?php }?>><?php echo $cc['UserMessage']['msg_content'] ?></div>
		
	<?php }}}}else{?>
	<!--无提问-->
		<div class="not">
		<br />
		<strong><?php echo $this->data['languages']['no_question'];?>!</strong>
		<br /><br />
		</div>
		<?php }?>
	</div>
	
</div>
<!--用户提问End-->

<div class="height_5">&nbsp;</div>
	<!--用户相册-->
		<div class="cont photos">
		<div class="head"><span class='left'>&nbsp;</span><span class='right'>&nbsp;</span>
		<?php echo $this->data['languages']['photo_gallery'] ?>
		<a class="action" href="javascript:show_my_photo(<?php echo $this->data['product_view']['Product']['id'];?>);"><?php echo $this->data['languages']['upload']?><?php echo $this->data['languages']['my_photos']?></a>
		</div>
		<div class="box">
	<?php if(isset($user_product_gallerie) && sizeof($user_product_gallerie)){?>
		<ul>
		<?php foreach($user_product_gallerie as $k=>$v){?>
		<li><?php if($v['UserProductGallerie']['img'] != ""){?>
		<?php echo $html->link($html->image($v['UserProductGallerie']['img'],
		array("alt"=>"","width"=>isset($this->data['configs']['thumbl_image_width'])?$this->data['configs']['thumbl_image_width']:108,
		"height"=>isset($this->data['configs']['thumb_image_height'])?$this->data['configs']['thumb_image_height']:108
		)),"javascript:show_pic_original('".$v['UserProductGallerie']['img']."')",array(),false,false);?>
		<?php }?>
		</li>
		<?php }?>
		</ul><?php }else{?>
		<div class="not">
		<br />
		<strong><?php echo $this->data['languages']['no_photo']?>!</strong>
		<br /><br />
		</div>
		<?php }?>
		</div>
	</div>
	<!--用户相册End-->

<!-- 过往精品 -->
<cake:nocache>
<?php if(isset($this->data['bestbefore_product']) && sizeof($this->data['bestbefore_product'])){?>
<div class="height_5">&nbsp;</div>
		<div class="cont photos">
		<div class="head"><span class='left'>&nbsp;</span><span class='right'>&nbsp;</span>
		<?php echo $this->data['languages']['in_the_past_boutique']?>
		</div>
		<div class="box">
		<ul>
		<?php foreach($this->data['bestbefore_product'] as $k=>$v){?>
		<li><?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image']);?>
		<p class="info">
		<span class="name"><?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank"),false,false);?></span>
		</p>
		<p class="info">
		<span class="Price"><font color='#F9630C'><?php echo (isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')]))?
			 $svshow->price_format($v['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']):	
			 $svshow->price_format($v['Product']['shop_price'],$this->data['configs']['price_format']);?></font></span>
		</p>		
		</li>
		<?php }?>
		</ul>
		</div>
	</div>
<?php }?>
</cake:nocache>
<!-- 过往精品 END -->
<cake:nocache>
<?php if(isset($this->data['tags_products']) && $this->data['tags_products']){?>
<!--有相同标签的商品-->
<div class="height_5">&nbsp;</div>
		<div class="cont photos">
			<div class="head"><span class='left'>&nbsp;</span><span class='right'>&nbsp;</span>
			<?php echo $this->data['languages']['tags'].$this->data['languages']['product'];?>
			</div>
		<div class="box">
		<ul>
			<?php if(isset($this->data['tags_products']) && sizeof($this->data['tags_products'])>0){?>
				<?php foreach($this->data['tags_products'] as $k=>$r){?>
				<li>
					<?php echo $html->link($html->image(empty($r['Product']['img_thumb'])?"/img/product_default.jpg":$r['Product']['img_thumb'],array('width'=>'80','height'=>'80','alt'=>$r['ProductI18n']['name'])),$svshow->sku_product_link($r['Product']['id'],$r['ProductI18n']['name'],$r['Product']['code'],$this->data['configs']['product_link_type']),'',false,false);?>
					<p class="info">
					<span class="name"><?php echo $html->link($r['ProductI18n']['name'],$svshow->sku_product_link($r['Product']['id'],$r['ProductI18n']['name'],$r['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank"),false,false);?></span>
					</p><p class="info"><span class="Price"><font color='#F9630C'><?php echo (isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')]))?
						 $svshow->price_format($r['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']):	
						 $svshow->price_format($r['Product']['shop_price'],$this->data['configs']['price_format']);?></font></span>
					</p>
				</li>
				<?php }?>
			<?php }?>
		</ul>
	</div>
</div>
<!--有相同标签的商品 End-->
<?php }?>
</cake:nocache>
<cake:nocache>
<?php if(isset($this->data['price_product']) && $this->data['price_product']){?>
<!--价格区间内的商品-->
<div class="height_5">&nbsp;</div>
		<div class="cont photos">
			<div class="head"><span class='left'>&nbsp;</span><span class='right'>&nbsp;</span>
				<?php echo $this->data['languages']['about_1000_other_commodities']?>
			</div>
		<div class="box">
		<ul>
			<?php if(isset($this->data['price_product']) && sizeof($this->data['price_product'])>0){?>
				<?php foreach($this->data['price_product'] as $k=>$r){?>
				<li>
					<?php echo $svshow->productimagethumb($r['Product']['img_thumb'],$svshow->sku_product_link($r['Product']['id'],$r['ProductI18n']['name'],$r['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$r['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image']);?>
					<p class="info">
					<span class="name"><?php echo $html->link($r['ProductI18n']['name'],$svshow->sku_product_link($r['Product']['id'],$r['ProductI18n']['name'],$r['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank"),false,false);?></span>
					</p><p class="info"><span class="Price"><font color='#F9630C'><?php echo (isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')]))?
						 $svshow->price_format($r['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']):	
						 $svshow->price_format($r['Product']['shop_price'],$this->data['configs']['price_format']);?></font></span>
					</p>
				</li>
				<?php }?>
			<?php }?>
		</ul>
	</div>
</div>
<!--价格区间内的商品 End-->
<?php }?>
</cake:nocache>
	</div>
</div>
<!--Left End-->

<!--Right-->	
<div id="main_right" class="product_r" style="margin-top:0;">

<div class="category_box brand_box">
	<h3 class="font_14"><span class="l"></span><span class="r"></span><?php echo $this->data['languages']['tags']?></h3>
	<div class="category homeorderlist box font_color_1">
	<!-- 加商品标签 -->
	<?php if(isset($this->data['configs']['use_tag']) && $this->data['configs']['use_tag'] == 1){?>	
	<ul>
		<li>
		<cake:nocache>
		<?php if(isset($this->data['tags']) && sizeof($this->data['tags'])>0){?>	
		<p style="margin:-5px 0 5px;"><strong><?php echo $this->data['languages']['products']?><?php echo $this->data['languages']['tags']?></strong></p>
		<?php }?>
			
		<div id='update_tag'>
		<?php if(isset($this->data['tags']) && sizeof($this->data['tags'])>0){?>		
		<div class="tags">
		<?php 
		$tag_arr = array();
		foreach($this->data['tags'] as $k=>$v){?>
		<?php if(!in_array($v['TagI18n']['name'],$tag_arr)){?>
		<span class="float_l"><a href="javascript:search_tag('<?php echo $v['TagI18n']['name']?>');"><?php echo $v['TagI18n']['name']?></a></span>
		<?php $tag_arr[] = $v['TagI18n']['name'];
		}?>
		<?php }?>
		</div>
		<?php }?>
		</div>
	</cake:nocache>
	</li>	
	<li><input type="text" name="tag" id="tag" class="text_input" style="width:160px;" /></li>
	<li class="action" style="padding-top:5px;">
	<cake:nocache>
	<?php if($session->check('User.User.name')){?>
	<a href="javascript:add_tag(<?php echo $this->data['product_view']['Product']['id']?>,'P',1)" class="button_1"><span><?php echo $this->data['languages']['add_to_my_tags']?></span></a>
	<?}else{?>
	<a href="javascript:add_tag(<?php echo $this->data['product_view']['Product']['id']?>,'P',0)" class="button_1"><span><?php echo $this->data['languages']['add_to_my_tags']?></span></a>
	<?}?>
				
	</cake:nocache>

	</li>
	</ul>
	<?php }?>
	<!-- 加商品标签end -->			
	</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'category_ulbt.gif':'category_ulbt.gif',array("width"=>"100%","height"=>"5"))?></p>
</div>

<!-- 综合评分 -->
<div class="category_box brand_box">
	<h3 class="font_14"><span class="l"></span><span class="r"></span>
	<a id="comments_rank" class="action float_r"><?php echo $this->data['languages']['issue_comments'];?></a>
	<?php echo $this->data['languages']['integrated_score'];?></h3>
	<div class="category homeorderlist box font_color_1">
	<ul>

	<?php if(isset($average_rank)){?>
	<li><p style="margin:-5px 0 10px;"><?php echo $this->data['languages']['user'];?><?php echo $this->data['languages']['integrated_score'];?>：</p></li>	
	<li><center>
		<?php if($average_rank == '1'){?>
		<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'one.gif':'one.gif')?>
	<?php }elseif($average_rank == '2'){?>
		<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'two.gif':'two.gif')?>
	<?php }elseif($average_rank == '3'){?>
		<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'three.gif':'three.gif')?>
	<?php }elseif($average_rank == '4'){?>
		<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'four.gif':'four.gif')?>
	<?php }elseif($average_rank == '5'){?>
		<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'five.gif':'five.gif')?>				
	<?php }?>	</center></li>
	<?php }else{?>
		<li><?php echo $this->data['languages']['no_comments_now'];?></li>
	<?php }?>
	</ul>
	</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'category_ulbt.gif':'category_ulbt.gif',array("width"=>"100%","height"=>"5"))?></p>
</div>

<!-- 综合评分 End-->

<?php if(isset($articles) && sizeof($articles)){ ?>
<!--关联文章-->
<div class="category_box brand_box">
<h3><span class="l"></span><span class="r"></span><?php echo $this->data['languages']['related_article'];?></h3>
<div class="category Help box font_color_1">
<ul>
<?php foreach($articles as $k=>$a ){?>
<li><?php echo $html->link($a['ArticleI18n']['sub_title'],$svshow->article_link($a['Article']['id'],$dlocal,$a['ArticleI18n']['title'],$this->data['configs']['article_link_type']),array('title'=>$a['ArticleI18n']['title']),false,false);?></li>
<?php }?>
</ul>
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'category_ulbt.gif':'category_ulbt.gif',array("width"=>"100%","height"=>"5"))?></p>
</div>
<!--关联文章 End-->
<?php }?>
	
	<?php echo $this->element('alsobought', array('cache'=>'+0 hour'));?>
	
</div>
</div>

<!--Right End-->
<?php echo $this->element('my_photo', array('cache'=>'+0 hour'));?>
	