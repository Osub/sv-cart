<?php 
/*****************************************************************************
 * SV-Cart 商品列表
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: exchange_products_list.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<div id="Item_ListBox">
<p class="View_item">
	<?php echo $html->image('view-left.gif',array('class'=>'view-left'))?>
	<?php echo $html->image('view-right.gif',array('class'=>'view-right'))?>
	<span class="view"><?php echo $SCLanguages['display_mode'];?>:</span>
	<?php if(isset($SVConfigs['show_L']) && $SVConfigs['show_L'] == 1){?>
	<span class="View_img"><?php 	$display_mode_img='btn_display_mode_list'.(($showtype == 'L')?'_act_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$orderby."/".$rownum."/L/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<?php }?>
	
	<?php if(isset($SVConfigs['show_G']) && $SVConfigs['show_G'] == 1){?>
	<span class="View_img"><?php 	$display_mode_img='btn_display_mode_grid'.(($showtype == 'G')?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$orderby."/".$rownum."/G/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<?php }?>
	
	<?php if(isset($SVConfigs['show_T']) && $SVConfigs['show_T'] == 1){?>
	<span class="View_img"><?php 	$display_mode_img='btn_display_mode_text'.(($showtype == 'T')?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$orderby."/".$rownum."/T/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<?php }?>
	<span class="Mode"></span>
	<span class="View_img"><?php 	$display_mode_img='number_1'.(($rownum == 20)?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$orderby."/20/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img='number_2'.(($rownum == 40)?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$orderby."/40/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img='number_3'.(($rownum == 80)?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$orderby."/80/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>



<span class="Mode"><?php echo $SCLanguages['sort_by'];?>:</span>
	<?php 
		$mode_url="/".$this->params['controller']."/";
	?>
	
	<?php if($orderby == 'shop_price DESC'){?>
		<span class="Mode_img">	
		<?php 	$display_mode_img='view_ivo01_over_down.gif';
			$display_mode_url =$mode_url."/shop_price ASC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }else if($orderby == 'shop_price ASC'){?>
		<span class="Mode_img">	
		<?php 	$display_mode_img='view_ivo01_over.gif';
			$display_mode_url=$mode_url."/shop_price DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }else{?>
		<span class="Mode_img">	
		<?php 	$display_mode_img='view_ivo01.gif';
			$display_mode_url=$mode_url."/shop_price DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }?>

	
	<?php if($orderby == 'sale_stat DESC'){?>
		<span class="Mode_img">
		<?php 	$display_mode_img='view_ivo02_over.gif';
			$display_mode_url=$mode_url."/sale_stat ASC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }else if($orderby == 'sale_stat ASC'){?>
		<span class="Mode_img">	
		<?php 	$display_mode_img='view_ivo02_over_up.gif';
			$display_mode_url=$mode_url."/sale_stat DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }else{?>
		<span class="Mode_img">	
		<?php 	$display_mode_img='view_ivo02.gif';
			$display_mode_url=$mode_url."/sale_stat DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }?>
	
	<?php if($orderby == 'modified DESC'){?>
		<span class="Mode_img">
		<?php 	$display_mode_img='view_ivo03_over.gif';
			$display_mode_url=$mode_url."/modified ASC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }else if($orderby == 'modified ASC'){?>
		<span class="Mode_img">	
		<?php 	$display_mode_img='view_ivo03_over_up.gif';
			$display_mode_url=$mode_url."/modified DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }else{?>
		<span class="Mode_img">	
		<?php 	$display_mode_img='view_ivo03.gif';
			$display_mode_url=$mode_url."/modified DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }?>	
	
</p>
<div class="box">

<?php if($showtype == 'L'){ ?>
<ul><?php if (isset($products) && sizeof($products)>0){ ?><?php foreach($products as $k=>$v){ ?>
<li>
<p class="pic" style="width:108px;">
<?php if($v['Product']['img_thumb'] != ""){?>
<?php echo $html->link($html->image($v['Product']['img_thumb'],array("alt"=>$v['ProductI18n']['name'],"width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),"",false,false);?>
<?php }else {
echo $html->link($html->image("product_default.jpg",array("alt"=>$v['ProductI18n']['name'],"width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),"",false,false);
}?>
</p>
<div class="right"><p class="item_info">
	<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?>&nbsp;</span>

<span class="marketprice">
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<?php echo $SCLanguages['market_price'];?>:
<?php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
<?php }?>
</span>
	<span class="Price"><font color="#ff0000"><?php echo $SCLanguages['our_price'];?>:
<?php if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?php echo $svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?php }?>
</font>
	<br />
<!--可以使用积分 抵消多少？-->
<?php echo $SCLanguages['users']?><?php echo $SCLanguages['point']?>:<?php echo $v['Product']['point_fee'];?><?php echo $SCLanguages['point_unit']?>
	<br />
<?php //printf($SCLanguages['can_offset_fee'],round($v['Product']['point_fee']*$SVConfigs['conversion_ratio_point']/100,2));?>
</span>

</p>
<?php if(isset($brands[$v['Product']['brand_id']])){?><p class="item_info brand-name"><span class="name"><?php echo $html->link($brands[$v['Product']['brand_id']]['BrandI18n']['name'],"/brands/".$v['Product']['brand_id'],"",false,false);?></span></p><?php }?>
<p class="item_info"><span class="name category-name">
<?php if(isset($v['ProductsCategory']) && isset($categories[$v['ProductsCategory']['category_id']])){?>
			<?php 
		$categories_url = str_replace(" ","-",$categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name']);
		$categories_url = str_replace("/","-",$categories_url);
		?>
		<?php if(isset($use_sku)){?>
			<?php if(isset($parent)){?>
			<?php echo $html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$parent."/".$categories_url,array(),false,false);?>
			<?php }else{?>
			<?php echo $html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$categories_url."/0/",array(),false,false);?>
			<?php }?>
		<?php }else if(isset($v['use_sku'])){?>
			<?php if(isset($v['parent'])){?>
			<?php echo $html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$v['parent']."/".$categories_url,array(),false,false);?>
			<?php }else{?>
			<?php echo $html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$categories_url."/0/",array(),false,false);?>
			<?php }?>
		<?php }else{?>	
			<?php echo $html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id'],array(),false,false);?>
		<?php }?>
<?php }?>
</span>

<span class="buy">
	<?php if(isset($_SESSION['User'])){?>
	<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
		<?php echo $html->link("<span>".$SCLanguages['favorite']."</span>",$user_webroot."favorites/add/p/".$v['Product']['id'],array('class'=>'fav'),false,false)?>
	<?php }else{?>
		<a href="javascript:favorite(<?php echo $v['Product']['id']?>,'p');" class="fav"><span><?php echo $SCLanguages['favorite'];?></span></a>
	<?php }?>
		
	<?php }?>
<?php if($v['Product']['quantity'] == 0){?>
		<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
			<?php echo $html->link("<span>".$SCLanguages['booking']."</span>",'/products/add_booking_page/'.$v['Product']['id'],array('class'=>'fav'),false,false);?>
		<?php }else{?>		
		<a href="javascript:show_booking(<?php echo $v['Product']['id']?>)" class="fav"><span><?php echo $SCLanguages['booking'];?></span></a>
		<?php }?>
<?php }else{?>
<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
	<?php echo $form->create('carts',array('action'=>'buy_now','name'=>'buy_nowproduct'.$v['Product']['id'],'type'=>'POST'));?>
		<input type="hidden" name="id" value="<?php echo $v['Product']['id']?>"/>
		<input type="hidden" name="quantity" value="1"/>
		<input type="hidden" name="is_exchange" value="1"/>
		<input type="hidden" name="type" value="product"/>
		<?php echo $html->link($SCLanguages['buy'],"javascript:buy_now_no_ajax({$v['Product']['id']},1,'product')","",false,false)?>
	<?php echo $form->end();?>
<?php }else{?>
<a href="javascript:exchange(<?php echo $v['Product']['id']?>,1)" class="addtocart"><span><?php echo $SCLanguages['buy'];?></span></a>
<?php }?>
	
<?php }?>
</span></p>
</div></li>
<?php }?><?php }else{?>
<br /><br />		
<?php echo "<p class='not'>"?>
<?php echo $html->image('warning_img.gif',array('alt'=>''))?>
<?php 
echo "<strong>".$SCLanguages['coming_please_note']."</strong></p><br /><br /><br />";
}?>
</ul> 
<?php }elseif($showtype == 'G'){?>
<div id="Item_List">
<!--商品列表图排式-->
<ul class="breviary"><?php if (isset($products) && sizeof($products)>0){ ?><?php foreach($products as $k=>$v){ ?>
<li><p class="pic">
<?php if($v['Product']['img_thumb'] != ""){?>
<?php echo $html->link($html->image($v['Product']['img_thumb'],array("alt"=>$v['ProductI18n']['name'],"width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),"",false,false);?>
<?php }else {
echo $html->link($html->image("/img/product_default.jpg",array("alt"=>$v['ProductI18n']['name'],"width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),"",false,false);
}?>
</p>
<p class="info">
	<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></span>
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?><span class="Mart_Price"><?php echo $SCLanguages['market_price'];?>:
<?php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
		</span><?php }?>
	<span class="Price"><font color="#ff0000"><?php echo $SCLanguages['our_price'];?>:
<?php if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?php echo $svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?php }?>
		</font></span>
			
			<!--可以使用积分 抵消多少？-->
<span class="Price">
<?php echo $SCLanguages['users']?><?php echo $SCLanguages['point']?>:<?php echo $v['Product']['point_fee'];?><?php echo $SCLanguages['point_unit']?>
</span><span class="Price">
<?php //printf($SCLanguages['can_offset_fee'],round($v['Product']['point_fee']*$SVConfigs['conversion_ratio_point']/100,2));?>
</span>
			
	<span class="stow">
	<?php if(isset($_SESSION['User'])){?>
		<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
			<?php echo $html->link($SCLanguages['favorite'],$user_webroot."favorites/add/p/".$v['Product']['id'],"",false,false)?>|
		<?php }else{?>		
			<a href="javascript:favorite(<?php echo $v['Product']['id']?>,'p')"><?php echo $SCLanguages['favorite'];?></a>|
		<?php }?>
	
	<?php }?>
		<?php if($v['Product']['quantity'] == 0){?>
			<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
				<?php echo $html->link($SCLanguages['booking'],'/products/add_booking_page/'.$v['Product']['id']);?>
			<?php }else{?>			
				<a href="javascript:show_booking(<?php echo $v['Product']['id']?>)"><?php echo $SCLanguages['booking'];?></a>
			<?php }?>
		<?php }else{?>	
			
<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
	<?php echo $form->create('carts',array('action'=>'buy_now','name'=>'buy_nowproduct'.$v['Product']['id'],'type'=>'POST'));?>
		<input type="hidden" name="id" value="<?php echo $v['Product']['id']?>"/>
		<input type="hidden" name="quantity" value="1"/>
		<input type="hidden" name="is_exchange" value="1"/>
		<input type="hidden" name="type" value="product"/>
		<?php echo $html->link($SCLanguages['buy'],"javascript:buy_now_no_ajax({$v['Product']['id']},1,'product')","",false,false)?>
	<?php echo $form->end();?>
<?php }else{?>			
	<a href="javascript:exchange(<?php echo $v['Product']['id']?>,1)"><?php echo $SCLanguages['buy'];?></a>
<?php }?>
				
				
		<?php }?>
		</span></p>
</li>
<?php }?><?php }else{?>
<br /><br />		
<?php echo "<p class='not'>"?>
<?php echo $html->image('warning_img.gif',array('alt'=>''))?>
<?php 
echo "<strong>".$SCLanguages['coming_please_note']."</strong></p><br /><br /><br />";
}?>
</ul></div>
<?php }elseif($showtype == 'T'){?><?php if (isset($products) && sizeof($products)>0){ ?>
<p class="Title_Item">
		<?php if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
	<span class="Price"><?php echo $SCLanguages['market_price'];?></span>
	<?php }?>
	<span class="Price"><?php echo $SCLanguages['our_price'];?></span><span class="Price"><?php //=$SCLanguages['users']?><?php //=$SCLanguages['point']?></span><span class="handel"><?php echo $SCLanguages['operation'];?></span></p>

<ul class="text_itemlist"><?php foreach($products as $k=>$v){ ?>
<li>
<p class="item_infos">
	<span class="name"><strong><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></strong>
	<?php if(isset($brands[$v['Product']['brand_id']])) echo $html->link($brands[$v['Product']['brand_id']]['BrandI18n']['name'],"/brands/".$v['Product']['brand_id'],"",false,false);?> 
	
<?php if(isset($v['ProductsCategory']) && isset($categories[$v['ProductsCategory']['category_id']])){?>
		<?php 
		$categories_url = str_replace(" ","-",$categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name']);
		$categories_url = str_replace("/","-",$categories_url);
		?>
		|<?php if(isset($use_sku)){?>
			<?php if(isset($parent)){?>
			<?php echo $html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$parent."/".$categories_url,array(),false,false);?>
			<?php }else{?>
			<?php echo $html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$categories_url."/0/",array(),false,false);?>
			<?php }?>
		<?php }else if(isset($v['use_sku'])){?>
			<?php if(isset($v['parent'])){?>
			<?php echo $html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$v['parent']."/".$categories_url,array(),false,false);?>
			<?php }else{?>
			<?php echo $html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$categories_url."/0/",array(),false,false);?>
			<?php }?>
		<?php }else{?>	
			<?php echo $html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id'],array(),false,false);?>
		<?php }?>
<?php }?>
	
</span>
<?php if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<span class="marketprice"> 
<?php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
	</span>
<?php }?>	
<span class="Price"><font color="#ff0000">
<?php if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?php echo $svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?php }?>
	</font></span>
<span class="Territory">
	<?php if(isset($_SESSION['User'])){?>
		
		<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
			<?php echo $html->link($SCLanguages['favorite'],$user_webroot."favorites/add/p/".$v['Product']['id'],"",false,false)?>|
		<?php }else{?>				
		<a href="javascript:favorite(<?php echo $v['Product']['id']?>,'p')"><?php echo $SCLanguages['favorite'];?></a> | 
		<?php }?>
			
			<?php }?>
		<?php if($v['Product']['quantity'] == 0){?>
			<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
				<?php echo $html->link($SCLanguages['booking'],'/products/add_booking_page/'.$v['Product']['id']);?>
			<?php }else{?>			
			<a href="javascript:show_booking(<?php echo $v['Product']['id']?>)"><?php echo $SCLanguages['booking'];?></a>
			<?php }?>
		<?php }else{?>	
			<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
				<?php echo $form->create('carts',array('action'=>'buy_now','name'=>'buy_nowproduct'.$v['Product']['id'],'type'=>'POST'));?>
					<input type="hidden" name="id" value="<?php echo $v['Product']['id']?>"/>
					<input type="hidden" name="quantity" value="1"/>
					<input type="hidden" name="is_exchange" value="1"/>
					<input type="hidden" name="type" value="product"/>
					<?php echo $html->link($SCLanguages['buy'],"javascript:buy_now_no_ajax({$v['Product']['id']},1,'product')","",false,false)?>
				<?php echo $form->end();?>
			<?php }else{?>				
				<a href="javascript:exchange(<?php echo $v['Product']['id']?>,1)"><?php echo $SCLanguages['buy'];?></a>
			<?php }?>			
		<?php }?>
	</span>
</p>
</li>
<?php }?><?php }else{?>
<br /><br />		
<?php echo "<p class='not'>"?>
<?php echo $html->image('warning_img.gif',array('alt'=>''))?>
<?php 
echo "<strong>".$SCLanguages['coming_please_note']."</strong></p><br /><br /><br />";
}?>
</ul><!--商品列表文字排式End-->
<?php }?>
</div></div>