<?php 
/*****************************************************************************
 * SV-Cart 推荐商品列表
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: advance_products_list.ctp 3311 2009-07-24 12:16:27Z huangbo $
*****************************************************************************/
?>
<div class="products clearfix">
	<h3><span class="descending float_right">
	<?php $sort_mode_url = $this->params['controller']."/".$this->params['action']."/".$type."/".$url_keywords.
"/".$category_id."/".$brand_id."/".$min_price."/".$max_price;
?>
	<select name="sort_style" onchange="sort_change(this)">
	<option value="<?php echo $sort_mode_url.'/shop_price DESC/'.$rownum.'/'.$showtype.'/';?>" <?php if($orderby=='shop_price DESC'){?>selected<?php }?>><?php echo $SCLanguages['price'].$SCLanguages['desc'].$SCLanguages['sort'];?></option>
	<option value="<?php echo $sort_mode_url.'/shop_price ASC/'.$rownum.'/'.$showtype.'/';?>" <?php if($orderby=='shop_price ASC'){?>selected<?php }?>><?php echo $SCLanguages['price'].$SCLanguages['asc'].$SCLanguages['sort'];?></option>
	<option value="<?php echo $sort_mode_url.'/sale_stat DESC/'.$rownum.'/'.$showtype.'/';?>" <?php if($orderby=='sale_stat DESC'){?>selected<?php }?>><?php echo $SCLanguages['sale_count'].$SCLanguages['desc'].$SCLanguages['sort'];?></option>
	<option value="<?php echo $sort_mode_url.'/sale_stat ASC/'.$rownum.'/'.$showtype.'/';?>" <?php if($orderby=='sale_stat ASC'){?>selected<?php }?>><?php echo $SCLanguages['sale_count'].$SCLanguages['asc'].$SCLanguages['sort'];?></option>
	<option value="<?php echo $sort_mode_url.'/modified DESC/'.$rownum.'/'.$showtype.'/';?>" <?php if($orderby=='modified DESC'){?>selected<?php }?>><?php echo $SCLanguages['onsale'].$SCLanguages['time'].$SCLanguages['desc'].$SCLanguages['sort'];?></option>
	<option value="<?php echo $sort_mode_url.'/modified ASC/'.$rownum.'/'.$showtype.'/';?>" <?php if($orderby=='modified ASC'){?>selected<?php }?>><?php echo $SCLanguages['onsale'].$SCLanguages['time'].$SCLanguages['asc'].$SCLanguages['sort'];?></option>
	</select></span><span><?php echo $SCLanguages['search_result'];?></span></h3>
	
<!--商品列表图排式-->
<?php if (isset($products) && sizeof($products)>0){ ?>
<?php foreach($products as $k=>$v){ ?>
<?php if($k==0){?><ul><?php }?>
<li>
<p class="picture">
<?php if(isset($v['Product']['img_thumb']) && strlen($v['Product']['img_thumb'])>0){?>
<?php echo $html->link($html->image($v['Product']['img_thumb'],array("alt"=>$v['ProductI18n']['name'],"width"=>108,"height"=>108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),"",false,false);?>
<?php }else{?>
<?php echo $html->link($html->image("../img/product_default.jpg",array("alt"=>$v['ProductI18n']['name'],"width"=>108,"height"=>108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),"",false,false);?>	
<?php }?>
</p>
<p class="name">
<?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></p>

<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<p class="price font_green market_price">
<?php echo $SCLanguages['market_price'];?>: <?php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>
</p>
<?php }?>
<p class="price font_green">
<?php echo $SCLanguages['our_price'];?>:
<?php if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?php echo $svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?php }?></p>
	
	<div class="action">
	<?php if(isset($_SESSION['User'])){?>
		<?php echo $html->link($SCLanguages['favorite'],$server_host.$user_webroot."favorites/add/p/".$v['Product']['id'],"",false,false)?>
		<?php }?>
		<?php if($v['Product']['quantity'] == 0){?>
		<?php echo $html->link($SCLanguages['booking'],'/products/add_booking_page/'.$v['Product']['id']);?><?php }else{?><?php echo $form->create('carts',array('action'=>'buy_now','name'=>'buy_nowproduct'.$v['Product']['id'],'type'=>'POST'));?><?php echo $html->link($SCLanguages['buy'],"javascript:buy_now_no_ajax({$v['Product']['id']},1,'product')","",false,false)?>
		<input type="hidden" name="id" value="<?php echo $v['Product']['id']?>"/>
		<input type="hidden" name="quantity" value="1"/>
		<input type="hidden" name="type" value="product"/>
		<?php echo $form->end();?>
	<?php }?>
	</div>
</li>
<?php  if( $k%5==4 && $k<sizeof($products)-1 ){?>
	<?php if($k == 0){?>
	<?php }else{?>
	</ul>
	<ul>
	<?php }?>
	<?php }else if($k==sizeof($products)-1){?>
	</ul><?php }else{?><?php }?>
<?php }?>
<?php }else{?>
<div class='not'>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array('alt'=>''))?>
<strong><?php echo $SCLanguages['not_find_product'];?></strong>
</div>
<?php }?>
</div>
<script>
function sort_change(choose_sort)
{
   var ssort = choose_sort.value;
   window.open("/"+ssort);
}
</script>