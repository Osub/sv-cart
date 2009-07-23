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
 * $Id: view.ctp 3113 2009-07-20 11:14:34Z huangbo $
*****************************************************************************/
?>
<?php $javascript->link('../js/common.js');?>
<?php echo $form->create('carts',array('action'=>'buy_now','name'=>'buy_nowproduct'.$info['Product']['id'],'type'=>'POST'));?>
<?php echo $javascript->link(array('/js/yui/yahoo-min.js','/js/yui/event-min.js'));?>
<h3><span><?php echo $SCLanguages['brand'].$SCLanguages['classificatory'];?>>><a href="/categories/<?php echo $categorys['Category']['id'];?>"><?php echo $categorys['CategoryI18n']['name'];?></a></span></h3>
<div id="Left" style="margin:0 auto;float:none;">
	
	<div class="product_detail">
	<div class="picture">
	<?php if(isset($galleries) && sizeof($galleries)>0){?>
		<?php foreach($galleries as $k=>$g){?>
				<?php echo $html->link($html->image($g['ProductGallery']['img_thumb'],array("title"=>isset($galleries[0]['ProductGalleryI18n']['description'])?$galleries[0]['ProductGalleryI18n']['description']:'',"alt"=>isset($g['ProductGalleryI18n']['description'])?$galleries[0]['ProductGalleryI18n']['description']:'' )),"","",false,false);?>
		<?php }?>
<?php }else{?>
<?php 
echo $html->div('picc',$html->image("/img/product_default.jpg",array("id"=>"img1","alt"=>"","width"=>isset($SVConfigs['image_width'])?$SVConfigs['image_width']:441,"height"=>isset($SVConfigs['image_height'])?$SVConfigs['image_height']:391)),'',false);
?>
<?php }?></div>
	<div class="detail"><h2><?php echo $info['ProductI18n']['name'];?></h2>
	<dl><dt><?php echo $SCLanguages['market_price'];?>:</dt>
	    <dd><?php if ($info['Product']['market_price']){?>
		    <?php echo $svshow->price_format($info['Product']['market_price'],$SVConfigs['price_format']);?>	
		    <?php }?></dd></dl>
	<dl><dt><?php echo $SCLanguages['our_price'];?>:</dt>
	    <dd><span class="font_red"><?php if($info['Product']['shop_price']){?>
		    <?php echo $svshow->price_format($info['Product']['shop_price'],$SVConfigs['price_format']);?>	
		    <?php }?></span></dd></dl>
		    	
		<?php if(isset($SVConfigs['show_product_type']) && $SVConfigs['show_product_type'] == 1 ){?>
		<dl><dt><?php echo $SCLanguages['type'];?>:</dt>
		<dd>
		<?php if(isset($product_type['ProductTypeI18n']['name'])){?>
		<?php echo $product_type['ProductTypeI18n']['name'];?>
		<?php }else{?>
		<?//php echo $SCLanguages['undefined'];?>
		<?php }?></dd></dl>
			<?php //pr($format_product_attributes);?>
			<?php if(isset($format_product_attributes) && sizeof($format_product_attributes)>0){?>
				<?$fpa=0;?>
			<?php foreach($format_product_attributes as $k=>$v){?>
				<?if(sizeof($v)>1){?>
				<dl><dt><?php echo $product_attributes_name[$k];?>:</dt>
				<dd>
					<select  name="attributes_<?php echo $fpa?>" id="attributes_<?php echo $fpa?>"><?php foreach($v as $kk=>$vv){?>
						<option value="<?php echo $vv['id']?>"><?php echo $vv['value']?>  
						<?php //=$svshow->price_format($vv['price'],$SVConfigs['price_format']);?>	
							</option>
					<?php }?></select>
						<?$fpa++;?>
					<?}?>	
				</dd></dl>
			<?php }}?>
		<?php }?>		    	
    <div class="buy_handle">
    <span class="addtocart"><a href="javascript:buy_now_no_ajax(<?php echo $info['Product']['id']?>,1,'product')"><?php echo $SCLanguages['put_into_cart']?></a></span>
	<strong><?php echo $SCLanguages['purchase'].$SCLanguages['quantity'];?>:</strong><input type="text" name="quantity" id="buy_num" size="1" class="number" value="1">
		<input type="hidden" name="type" value="product"><input type="hidden" name="id" value="<?php echo $info['Product']['id'];?>">
	</div>
	</div>
	</div>
	<div class="property">
	<?php if(isset($brands[$info['Product']['brand_id']]['BrandI18n']['name']) && !empty($brands[$info['Product']['brand_id']]['BrandI18n']['name'])){?>
	<ul class="table_cell table_row">
	<li class="title"><?php echo $SCLanguages['brand'];?></li>
	<li class="description"><?php echo $brands[$info['Product']['brand_id']]['BrandI18n']['name'];?></li>
	</ul>
	<?php }?>
	<?php if(isset($product_attributes) && !empty($product_attributes)){?>
	<ul class="table_cell table_row" style="display:none;">
	<li class="title"><?php echo $SCLanguages['attribute'];?></li>
	<li class="description">
	<?php if(isset($product_attributes)&&sizeof($product_attributes)>0){?>
	<?php foreach($product_attributes as $k=>$v){?>
	<?php echo $v['ProductAttribute']['product_type_attribute_value'];?>
	<?php }}?>
	</li>
	</ul>
	<?php }?>
			<?php if(isset($format_product_attributes) && sizeof($format_product_attributes)>0){?>
			<?php foreach($format_product_attributes as $k=>$v){?>
					<?if(sizeof($v)==1){?>
				<ul class="table_cell table_row">
				<li class="title"><?php echo $product_attributes_name[$k];?></li>
						<li class="description"><?php foreach($v as $kk=>$vv){?><?php echo $vv['value']?><?}?></li>
				</ul>
					<?}?>	
			<?php }}?>		
		
		
		
	<?php if(isset($info['ProductI18n']['description']) && !empty($info['ProductI18n']['description'])){?>
	<ul class="table_cell table_row">
	<li class="title"><?php echo $SCLanguages['detail'].$SCLanguages['description'];?></li>
	<li class="description"><?php echo $info['ProductI18n']['description'];?></li>
	</ul>
	<?php }?>
	</div>
</div>
<?php echo $form->end();?>
