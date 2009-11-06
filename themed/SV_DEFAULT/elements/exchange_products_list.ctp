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
 * $Id: exchange_products_list.ctp 4433 2009-09-22 10:08:09Z huangbo $
*****************************************************************************/
?>
<div class="Item_ListBox">
<p class="View_item">
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'view-left.gif':'view-left.gif',array('class'=>'view-left'))?>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'view-right.gif':'view-right.gif',array('class'=>'view-right'))?>
<span class="Mode_img"><?php echo $this->data['languages']['sort'];?>:
	<?php $mode_url="/".$this->params['controller']."/".$this->data['get_page']."/";?>
	<?php if($orderby == 'shop_price DESC'){?>
		<?php 	$display_mode_img='view_ivo01_over_down.gif';
			$display_mode_url =$mode_url."/shop_price ASC/".$rownum."/".$this->data['showtype']."/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);?>
	<?php }else if($orderby == 'shop_price ASC'){?>
		<?php 	$display_mode_img='view_ivo01_over.gif';
			$display_mode_url=$mode_url."/shop_price DESC/".$rownum."/".$this->data['showtype']."/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);?>
	<?php }else{?>
		<?php 	$display_mode_img='view_ivo01.gif';
			$display_mode_url=$mode_url."/shop_price DESC/".$rownum."/".$this->data['showtype']."/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);?>
	<?php }?>
	<?php if($orderby == 'sale_stat DESC'){?>
		<?php 	$display_mode_img='view_ivo02_over.gif';
			$display_mode_url=$mode_url."/sale_stat ASC/".$rownum."/".$this->data['showtype']."/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);?>
	<?php }else if($orderby == 'sale_stat ASC'){?>
		<?php 	$display_mode_img='view_ivo02_over_up.gif';
			$display_mode_url=$mode_url."/sale_stat DESC/".$rownum."/".$this->data['showtype']."/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);?>
	<?php }else{?>
		<?php 	$display_mode_img='view_ivo02.gif';
			$display_mode_url=$mode_url."/sale_stat DESC/".$rownum."/".$this->data['showtype']."/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);?>
	<?php }?>
	<?php if($orderby == 'modified DESC'){?>
		<?php 	$display_mode_img='view_ivo03_over.gif';
			$display_mode_url=$mode_url."/modified ASC/".$rownum."/".$this->data['showtype']."/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);?>
	<?php }else if($orderby == 'modified ASC'){?>
		<?php 	$display_mode_img='view_ivo03_over_up.gif';
			$display_mode_url=$mode_url."/modified DESC/".$rownum."/".$this->data['showtype']."/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);?>
	<?php }else{?>
		<?php 	$display_mode_img='view_ivo03.gif';
			$display_mode_url=$mode_url."/modified DESC/".$rownum."/".$this->data['showtype']."/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);?>
	<?php }?>	
	</span>	
	<span class="view"><?php echo $this->data['languages']['show'];?>:</span>
	<?php if(isset($this->data['configs']['show_L']) && $this->data['configs']['show_L'] == 1){?>
	<span class="View_img"><?php 	$display_mode_img='btn_display_mode_list'.(($this->data['showtype'] == 'L')?'_act_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$this->data['get_page']."/".$orderby."/".$rownum."/L/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<?php }?>
	<?php if(isset($this->data['configs']['show_G']) && $this->data['configs']['show_G'] == 1){?>
	<span class="View_img"><?php 	$display_mode_img='btn_display_mode_grid'.(($this->data['showtype'] == 'G')?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$this->data['get_page']."/".$orderby."/".$rownum."/G/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<?php }?>
	<?php if(isset($this->data['configs']['show_T']) && $this->data['configs']['show_T'] == 1){?>
	<span class="View_img"><?php 	$display_mode_img='btn_display_mode_text'.(($this->data['showtype'] == 'T')?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$this->data['get_page']."/".$orderby."/".$rownum."/T/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<?php }?>
	<span class="Mode"></span>
	<span class="View_img"><?php 	$display_mode_img='number_1'.(($rownum == 20)?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$this->data['get_page']."/".$orderby."/20/".$this->data['showtype']."/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img='number_2'.(($rownum == 40)?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$this->data['get_page']."/".$orderby."/40/".$this->data['showtype']."/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img='number_3'.(($rownum == 80)?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$this->data['get_page']."/".$orderby."/80/".$this->data['showtype']."/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img='number_4'.(($rownum == 'all')?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$this->data['get_page']."/".$orderby."/all/".$this->data['showtype']."/";
			echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".$display_mode_img:$display_mode_img),$display_mode_url,"",false,false);
	?></span>
</p>
<div class="box">
<cake:nocache>
<?php if($this->data['showtype'] == 'L'){ ?>
<ul><?php if (isset($this->data['products']) && sizeof($this->data['products'])>0){ ?><?php foreach($this->data['products'] as $k=>$v){ ?>
<li>
<p class="pic" style="width:108px;">
<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$v['ProductI18n']['name']);?>
</p>
<div class="right"><p class="item_info">
	<span class="name"><?php echo $html->link( $v['ProductI18n']['sub_name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank"),false,false);?>&nbsp;</span>
<span class="marketprice">
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($this->data['configs']['show_market_price']) && $this->data['configs']['show_market_price'] == 1){?>
<?php echo $this->data['languages']['market_price'];?>:<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($v['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($v['Product']['market_price'],$this->data['configs']['price_format']);?><?php }?><?php }?></span>
<span class="Price"><font color="#ff0000"><?php echo $this->data['languages']['our_price'];?>:<?php if($session->check('User.User.rank') && isset($this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]) && isset($this->data['configs']['show_member_level_price']) && $this->data['configs']['show_member_level_price'] >0){?><?if($this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['is_default_rank'] == 1){?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['discount']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['discount'],$this->data['configs']['price_format']);?><?php }?><?}else{?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['product_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['product_price'],$this->data['configs']['price_format']);?><?php }?><?}?><?}else{?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($v['Product']['shop_price'],$this->data['configs']['price_format']);?><?php }?><?}?></font><br />
<!--可以使用积分 抵消多少？-->
<?php echo $this->data['languages']['users']?><?php echo $this->data['languages']['point']?>:<?php echo $v['Product']['point_fee'];?><?php echo $this->data['languages']['point_unit']?><br /></span></p>
<?php if(isset($brands[$v['Product']['brand_id']])){?><p class="item_info brand-name"><span class="name"><?php echo $html->link($brands[$v['Product']['brand_id']]['BrandI18n']['name'],"/brands/".$v['Product']['brand_id'],"",false,false);?></span></p><?php }?>
<p class="item_info"><span class="name category-name">
<?php if(isset($v['ProductsCategory']['category_id']) && isset($categories[$v['ProductsCategory']['category_id']])){?>
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
	<?php if($session->check('User.User.name')){?>
	<a href="javascript:favorite(<?php echo $v['Product']['id']?>,'p');" class="fav"><span><?php echo $this->data['languages']['favorite'];?></span></a>
	<?php }?>
<?php if($v['Product']['quantity'] == 0){?>
<a href="javascript:show_booking(<?php echo $v['Product']['id']?>,'<?php echo $v['ProductI18n']['name']?>')" class="fav"><span><?php echo $this->data['languages']['booking'];?></span></a>
<?php }else{?>
<a href="javascript:exchange(<?php echo $v['Product']['id']?>,1)" class="fav"><span><?php echo $this->data['languages']['buy'];?></span></a>
<?php }?>
</span></p>
</div></li>
<?php }?><?php }else{?>
<br /><br />		
<?php echo "<p class='not'>"?>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('alt'=>''))?>
<?php 
echo "<strong>".$this->data['languages']['coming_please_note']."</strong></p><br /><br /><br />";
}?>
</ul> 
<?php }elseif($this->data['showtype'] == 'G'){?>
<div class="Item_List">
<!--商品列表图排式-->
<ul class="breviary"><?php if (isset($this->data['products']) && sizeof($this->data['products'])>0){ ?><?php foreach($this->data['products'] as $k=>$v){ ?>
<li><p class="pic">
<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$v['ProductI18n']['name']);?>
</p>
<p class="info">
	<span class="name"><?php echo $html->link( $v['ProductI18n']['sub_name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank"),false,false);?></span>
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($this->data['configs']['show_market_price']) && $this->data['configs']['show_market_price'] == 1){?><span class="Mart_Price"><?php echo $this->data['languages']['market_price'];?>:<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($v['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($v['Product']['market_price'],$this->data['configs']['price_format']);?><?php }?></span><?php }?>
	<span class="Price"><font color="#ff0000"><?php echo $this->data['languages']['our_price'];?>:<?php if($session->check('User.User.rank') && isset($this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]) && isset($this->data['configs']['show_member_level_price']) && $this->data['configs']['show_member_level_price'] >0){?><?if($this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['is_default_rank'] == 1){?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['discount']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['discount'],$this->data['configs']['price_format']);?><?php }?><?}else{?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['product_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['product_price'],$this->data['configs']['price_format']);?>	<?php }?><?}?><?}else{?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($v['Product']['shop_price'],$this->data['configs']['price_format']);?><?php }?><?}?></font></span>
			<!--可以使用积分 抵消多少？-->
<span class="Price">
<?php echo $this->data['languages']['users']?><?php echo $this->data['languages']['point']?>:<?php echo $v['Product']['point_fee'];?><?php echo $this->data['languages']['point_unit']?>
</span><span class="Price">
</span>
	<span class="stow">
	<?php if($session->check('User.User.name')){?>
			<a href="javascript:favorite(<?php echo $v['Product']['id']?>,'p')"><?php echo $this->data['languages']['favorite'];?></a>|<?php }?>
		<?php if($v['Product']['quantity'] == 0){?>
		<a href="javascript:show_booking(<?php echo $v['Product']['id']?>,'<?php echo $v['ProductI18n']['name']?>')"><?php echo $this->data['languages']['booking'];?></a>
		<?php }else{?>	
		<a href="javascript:exchange(<?php echo $v['Product']['id']?>,1)"><?php echo $this->data['languages']['buy'];?></a>
		<?php }?>
		</span></p>
</li>
			<?php  if( $k%5==4 && $k<sizeof($this->data['products'])-1 ){?>
	<?php if($k == 0){?>
	<?php }else{?>
	</ul>
	<ul class="breviary">
	<?php }?>
	<?php }else if($k==sizeof($this->data['products'])-1){?>
	</ul><?php }else{?><?php }?>
<?php }?><?php }else{?>
<br /><br />		
<?php echo "<p class='not'>"?>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('alt'=>''))?>
<?php 
echo "<strong>".$this->data['languages']['coming_please_note']."</strong></p><br /><br /><br />";
}?>
</ul></div>
<?php }elseif($this->data['showtype'] == 'T'){?><?php if (isset($this->data['products']) && sizeof($this->data['products'])>0){ ?>
<p class="Title_Item">
		<?php if(isset($this->data['configs']['show_market_price']) && $this->data['configs']['show_market_price'] == 1){?>
	<span class="Price"><?php echo $this->data['languages']['market_price'];?></span>
	<?php }?>
	<span class="Price"><?php echo $this->data['languages']['our_price'];?></span><span class="Price"></span><span class="handel"><?php echo $this->data['languages']['operation'];?></span></p>
<ul class="text_itemlist"><?php foreach($this->data['products'] as $k=>$v){ ?>
<li>
<p class="item_infos">
	<span class="name"><strong><?php echo $html->link( $v['ProductI18n']['sub_name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank"),false,false);?></strong>
	<?php if(isset($brands[$v['Product']['brand_id']])) echo $html->link($brands[$v['Product']['brand_id']]['BrandI18n']['name'],"/brands/".$v['Product']['brand_id'],"",false,false);?> 
	
<?php if(isset($v['ProductsCategory']['category_id']) && isset($categories[$v['ProductsCategory']['category_id']])){?>
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
<?php if(isset($this->data['configs']['show_market_price']) && $this->data['configs']['show_market_price'] == 1){?>
<span class="marketprice"> 
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($v['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($v['Product']['market_price'],$this->data['configs']['price_format']);?><?php }?></span><?php }?>	
<span class="Price"><font color="#ff0000">
		<?php if($session->check('User.User.rank') && isset($this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]) && isset($this->data['configs']['show_member_level_price']) && $this->data['configs']['show_member_level_price'] >0){?><?if($this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['is_default_rank'] == 1){?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['discount']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['discount'],$this->data['configs']['price_format']);?><?php }?><?}else{?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['product_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($this->data['product_ranks'][$v['Product']['id']][$session->read('User.User.rank')]['ProductRank']['product_price'],$this->data['configs']['price_format']);?><?php }?><?}?><?}else{?><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?><?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?><?php }else{?><?php echo $svshow->price_format($v['Product']['shop_price'],$this->data['configs']['price_format']);?><?php }?><?}?></font></span>
<span class="Territory">
	<?php if($session->check('User.User.name')){?>
		<a href="javascript:favorite(<?php echo $v['Product']['id']?>,'p')"><?php echo $this->data['languages']['favorite'];?></a> | <?php }?>
		<?php if($v['Product']['quantity'] == 0){?>
		<a href="javascript:show_booking(<?php echo $v['Product']['id']?>,'<?php echo $v['ProductI18n']['name']?>')"><?php echo $this->data['languages']['booking'];?></a>
		<?php }else{?>	
		<a href="javascript:exchange(<?php echo $v['Product']['id']?>,1)"><?php echo $this->data['languages']['buy'];?></a>
		<?php }?>
	</span>
</p>
</li>
<?php }?><?php }else{?>
<br /><br />		
<?php echo "<p class='not'>"?>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('alt'=>''))?>
<?php 
echo "<strong>".$this->data['languages']['coming_please_note']."</strong></p><br /><br /><br />";
}?>
</ul><!--商品列表文字排式End-->
<?php }?>
</cake:nocache>
</div></div>