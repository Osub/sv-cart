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
 * $Id: products_list.ctp 1732 2009-05-25 12:03:32Z huangbo $
*****************************************************************************/
?>
<div id="Item_ListBox">
<p class="View_item">
	<?=$html->image('view-left.gif',array('class'=>'view-left'))?>
	<?=$html->image('view-right.gif',array('class'=>'view-right'))?>
	<span class="view"><?php echo $SCLanguages['display_mode'];?>:</span>
	<?if(isset($SVConfigs['show_L']) && $SVConfigs['show_L'] == 1){?>
	<span class="View_img"><?	$display_mode_img='btn_display_mode_list'.(($showtype == 'L')?'_act_over':'').'.gif';
			if($this->params['controller'] == 'categories'){
				if($SVConfigs['use_sku'] == 1){
					if(isset($parent)){
					$display_mode_url="/".$this->params['controller']."/".$id."/".$parent."/".$CategoryI18n_name."/".$orderby."/".$rownum."/L/";
					}else{
					$display_mode_url="/".$this->params['controller']."/".$id."/".$CategoryI18n_name."/0/".$orderby."/".$rownum."/L/";
					}
				}else{
					$display_mode_url="/".$this->params['controller']."/".$id."/0/0/".$orderby."/".$rownum."/L/";
				}
			}else{
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/0/0/".$orderby."/".$rownum."/L/";
			}
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<?}?>
	
	<?if(isset($SVConfigs['show_G']) && $SVConfigs['show_G'] == 1){?>
	<span class="View_img"><?	$display_mode_img='btn_display_mode_grid'.(($showtype == 'G')?'_over':'').'.gif';
			if($this->params['controller'] == 'categories'){
				if($SVConfigs['use_sku'] == 1){
					if(isset($parent)){
					$display_mode_url="/".$this->params['controller']."/".$id."/".$parent."/".$CategoryI18n_name."/".$orderby."/".$rownum."/G/";
					}else{
					$display_mode_url="/".$this->params['controller']."/".$id."/".$CategoryI18n_name."/0/".$orderby."/".$rownum."/G/";
					}
				}else{
					$display_mode_url="/".$this->params['controller']."/".$id."/0/0/".$orderby."/".$rownum."/G/";
				}
			}else{
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/0/0/".$orderby."/".$rownum."/G/";
			}
			
			
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<?}?>
	
	<?if(isset($SVConfigs['show_T']) && $SVConfigs['show_T'] == 1){?>
	<span class="View_img"><?	$display_mode_img='btn_display_mode_text'.(($showtype == 'T')?'_over':'').'.gif';
			if($this->params['controller'] == 'categories'){
				if($SVConfigs['use_sku'] == 1){
					if(isset($parent)){
					$display_mode_url="/".$this->params['controller']."/".$id."/".$parent."/".$CategoryI18n_name."/".$orderby."/".$rownum."/T/";
					}else{
					$display_mode_url="/".$this->params['controller']."/".$id."/".$CategoryI18n_name."/0/".$orderby."/".$rownum."/T/";
					}
				}else{
					$display_mode_url="/".$this->params['controller']."/".$id."/0/0/".$orderby."/".$rownum."/T/";
				}
			}else{
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/0/0/".$orderby."/".$rownum."/T/";
			}
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<?}?>
	<span class="Mode"></span>
	<span class="View_img"><?	$display_mode_img='number_1'.(($rownum == 20)?'_over':'').'.gif';
		if($this->params['controller'] == 'categories'){
			if($SVConfigs['use_sku'] == 1){
					if(isset($parent)){
					$display_mode_url="/".$this->params['controller']."/".$id."/".$parent."/".$CategoryI18n_name."/".$orderby."/20/".$showtype."/";
					}else{
					$display_mode_url="/".$this->params['controller']."/".$id."/".$CategoryI18n_name."/0/".$orderby."/20/".$showtype."/";
					}
			}else{
					$display_mode_url="/".$this->params['controller']."/".$id."/0/0/".$orderby."/20/".$showtype."/";
				}
		}else{
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/0/0/".$orderby."/20/".$showtype."/";
		}

			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?	$display_mode_img='number_2'.(($rownum == 40)?'_over':'').'.gif';
	
	
		if($this->params['controller'] == 'categories'){
			if($SVConfigs['use_sku'] == 1){
					if(isset($parent)){
					$display_mode_url="/".$this->params['controller']."/".$id."/".$parent."/".$CategoryI18n_name."/".$orderby."/40/".$showtype."/";
					}else{
					$display_mode_url="/".$this->params['controller']."/".$id."/".$CategoryI18n_name."/0/".$orderby."/40/".$showtype."/";
					}
			}else{
					$display_mode_url="/".$this->params['controller']."/".$id."/0/0/".$orderby."/40/".$showtype."/";
				}
		}else{
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/0/0/".$orderby."/40/".$showtype."/";
		}
			
			
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?	$display_mode_img='number_3'.(($rownum == 80)?'_over':'').'.gif';
		if($this->params['controller'] == 'categories'){
			if($SVConfigs['use_sku'] == 1){
					if(isset($parent)){
					$display_mode_url="/".$this->params['controller']."/".$id."/".$parent."/".$CategoryI18n_name."/".$orderby."/80/".$showtype."/";
					}else{
					$display_mode_url="/".$this->params['controller']."/".$id."/".$CategoryI18n_name."/0/".$orderby."/80/".$showtype."/";
					}
			}else{
					$display_mode_url="/".$this->params['controller']."/".$id."/0/0/".$orderby."/80/".$showtype."/";
				}
		}else{
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/0/0/".$orderby."/80/".$showtype."/";
		}
			
			
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>



<span class="Mode"><?php echo $SCLanguages['sort_by'];?>:</span>
	<?
		if($this->params['controller'] == 'categories'){
			if($SVConfigs['use_sku'] == 1){
				if(isset($parent)){
					$mode_url="/".$this->params['controller']."/".$id."/".$parent."/".$CategoryI18n_name;
				}else{
					$mode_url="/".$this->params['controller']."/".$id."/".$CategoryI18n_name;
				}
			}else{
					$mode_url="/".$this->params['controller']."/".$id."/0/0/";
			}
		}else{
				$mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id;
		}	
	?>
	
	<?if($orderby == 'shop_price DESC'){?>
		<span class="Mode_img">	
		<?	$display_mode_img='view_ivo01_over_down.gif';
			$display_mode_url =$mode_url."/shop_price ASC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?}else if($orderby == 'shop_price ASC'){?>
		<span class="Mode_img">	
		<?	$display_mode_img='view_ivo01_over.gif';
			$display_mode_url=$mode_url."/shop_price DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?}else{?>
		<span class="Mode_img">	
		<?	$display_mode_img='view_ivo01.gif';
			$display_mode_url=$mode_url."/shop_price DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?}?>

	
	<?if($orderby == 'sale_stat DESC'){?>
		<span class="Mode_img">
		<?	$display_mode_img='view_ivo02_over.gif';
			$display_mode_url=$mode_url."/sale_stat ASC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?}else if($orderby == 'sale_stat ASC'){?>
		<span class="Mode_img">	
		<?	$display_mode_img='view_ivo02_over_up.gif';
			$display_mode_url=$mode_url."/sale_stat DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?}else{?>
		<span class="Mode_img">	
		<?	$display_mode_img='view_ivo02.gif';
			$display_mode_url=$mode_url."/sale_stat DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?}?>
	
	<?if($orderby == 'modified DESC'){?>
		<span class="Mode_img">
		<?	$display_mode_img='view_ivo03_over.gif';
			$display_mode_url=$mode_url."/modified ASC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?}else if($orderby == 'modified ASC'){?>
		<span class="Mode_img">	
		<?	$display_mode_img='view_ivo03_over_up.gif';
			$display_mode_url=$mode_url."/modified DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?}else{?>
		<span class="Mode_img">	
		<?	$display_mode_img='view_ivo03.gif';
			$display_mode_url=$mode_url."/modified DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?}?>	
	
	<!--span class="Mode_img">
		<?	$display_mode_img='view_ivo03'.(($orderby == 'modified')?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/modified/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
	</span-->
</p>
<div class="box">

<? if($showtype == 'L'){ ?>
<ul><? if (isset($products) && sizeof($products)>0){ ?><? foreach($products as $k=>$v){ ?>
<li>
<p class="pic" style="width:108px;">
<?if($v['Product']['img_thumb'] != ""){?>
<?php echo $html->link($html->image($v['Product']['img_thumb'],array("alt"=>$v['ProductI18n']['name'],"width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),"",false,false);?>
<?}else {
echo $html->link($html->image("product_default.jpg",array("alt"=>$v['ProductI18n']['name'],"width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),"",false,false);
}?>
</p>
<div class="right"><p class="item_info">
	<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?>&nbsp;</span>

<span class="marketprice">
<?if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<?php echo $SCLanguages['market_price'];?>:
<?=$svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
<?}?>
</span>
	<span class="Price"><font color="#ff0000"><?php echo $SCLanguages['our_price'];?>:
<?if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?=$svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?}else{?>
<?=$svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?}?>
	</font></span>
</p>
<?if(isset($brands[$v['Product']['brand_id']])){?><p class="item_info brand-name"><span class="name"><?php echo $html->link($brands[$v['Product']['brand_id']]['BrandI18n']['name'],"/brands/".$v['Product']['brand_id'],"",false,false);?></span></p><?}?>
<p class="item_info"><span class="name category-name">
<?if(isset($categories[$v['ProductsCategory']['category_id']])){?>
		<?if(isset($use_sku)){?>
			<?if(isset($parent)){?>
			<?=$html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$parent."/".$categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],array(),false,false);?>
			<?}else{?>
			<?=$html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name']."/0/",array(),false,false);?>
			<?}?>
		<?}else if(isset($v['use_sku'])){?>
			<?if(isset($v['parent'])){?>
			<?=$html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$v['parent']."/".$categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],array(),false,false);?>
			<?}else{?>
			<?=$html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name']."/0/",array(),false,false);?>
			<?}?>
		<?}else{?>	
			<?=$html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id'],array(),false,false);?>
		<?}?>
<?}?>
</span>

<span class="buy">
	<?if(isset($_SESSION['User'])){?>
	<a href="javascript:favorite(<? echo $v['Product']['id']?>,'p');" class="fav"><span><?php echo $SCLanguages['favorite'];?></span></a>
	<?}?>
<?if($v['Product']['quantity'] == 0){?>
<a href="javascript:show_booking(<? echo $v['Product']['id']?>,'<? echo $v['ProductI18n']['name']?>')" class="fav"><span><?php echo $SCLanguages['booking'];?></span></a>
<?}else{?>
<a href="javascript:buy_now(<? echo $v['Product']['id']?>,1)" class="addtocart"><span><?php echo $SCLanguages['buy'];?></span></a>
<?}?>
</span></p>
</div></li>
<?}?><?}else{?>
<br /><br />		
<? echo "<p class='not'>"?>
<?=$html->image('warning_img.gif',array('alt'=>''))?>
<?
echo "<strong>".$SCLanguages['coming_please_note']."</strong></p><br /><br /><br />";
}?>
</ul> 
<?}elseif($showtype == 'G'){?>
<div id="Item_List">
<!--商品列表图排式-->
<ul class="breviary"><? if (isset($products) && sizeof($products)>0){ ?><? foreach($products as $k=>$v){ ?>
<li><p class="pic">
<?if($v['Product']['img_thumb'] != ""){?>
<?php echo $html->link($html->image($v['Product']['img_thumb'],array("alt"=>$v['ProductI18n']['name'],"width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),"",false,false);?>
<?}else {
echo $html->link($html->image("/img/product_default.jpg",array("alt"=>$v['ProductI18n']['name'],"width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),"",false,false);
}?>
</p>
<p class="info">
	<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></span>
<?if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?><span class="Mart_Price"><?php echo $SCLanguages['market_price'];?>:
<?=$svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
		</span><?}?>
	<span class="Price"><font color="#ff0000"><?php echo $SCLanguages['our_price'];?>:
<?if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?=$svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?}else{?>
<?=$svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?}?>
		</font></span>
	<span class="stow">
	<?if(isset($_SESSION['User'])){?>
			<a href="javascript:favorite(<? echo $v['Product']['id']?>,'p')"><?php echo $SCLanguages['favorite'];?></a>|<?}?>
		<?if($v['Product']['quantity'] == 0){?>
		<a href="javascript:show_booking(<? echo $v['Product']['id']?>,'<? echo $v['ProductI18n']['name']?>')"><?php echo $SCLanguages['booking'];?></a>
		<?}else{?>	
		<a href="javascript:buy_now(<? echo $v['Product']['id']?>,1)"><?php echo $SCLanguages['buy'];?></a>
		<?}?>
		</span></p>
</li>
<?}?><?}else{?>
<br /><br />		
<? echo "<p class='not'>"?>
<?=$html->image('warning_img.gif',array('alt'=>''))?>
<?
echo "<strong>".$SCLanguages['coming_please_note']."</strong></p><br /><br /><br />";
}?>
</ul></div>
<?}elseif($showtype == 'T'){?><? if (isset($products) && sizeof($products)>0){ ?>
<p class="Title_Item">
		<?if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
	<span class="Price"><?php echo $SCLanguages['market_price'];?></span>
	<?}?>
	<span class="Price"><?php echo $SCLanguages['our_price'];?></span><span class="handel"><?php echo $SCLanguages['operation'];?></span></p>
<ul class="text_itemlist"><? foreach($products as $k=>$v){ ?>
<li>
<p class="item_infos">
	<span class="name"><strong><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></strong>
	<?if(isset($brands[$v['Product']['brand_id']])) echo $html->link($brands[$v['Product']['brand_id']]['BrandI18n']['name'],"/brands/".$v['Product']['brand_id'],"",false,false);?> 
	
<?if(isset($categories[$v['ProductsCategory']['category_id']])){?>
		|<?if(isset($use_sku)){?>
			<?if(isset($parent)){?>
			<?=$html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$parent."/".$categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],array(),false,false);?>
			<?}else{?>
			<?=$html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name']."/0/",array(),false,false);?>
			<?}?>
		<?}else if(isset($v['use_sku'])){?>
			<?if(isset($v['parent'])){?>
			<?=$html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$v['parent']."/".$categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],array(),false,false);?>
			<?}else{?>
			<?=$html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id']."/".$categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name']."/0/",array(),false,false);?>
			<?}?>
		<?}else{?>	
			<?=$html->link($categories[$v['ProductsCategory']['category_id']]['CategoryI18n']['name'],"/categories/".$v['ProductsCategory']['category_id'],array(),false,false);?>
		<?}?>
<?}?>
	
</span>
<?if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<span class="marketprice"> 
<?=$svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
	</span>
<?}?>	
<span class="Price"><font color="#ff0000">
<?if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?=$svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?}else{?>
<?=$svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?}?>
	</font></span>
<span class="Territory">
	<?if(isset($_SESSION['User'])){?>
		<a href="javascript:favorite(<? echo $v['Product']['id']?>,'p')"><?php echo $SCLanguages['favorite'];?></a> | <?}?>
		<?if($v['Product']['quantity'] == 0){?>
		<a href="javascript:show_booking(<? echo $v['Product']['id']?>,'<? echo $v['ProductI18n']['name']?>')"><?php echo $SCLanguages['booking'];?></a>
		<?}else{?>	
		<a href="javascript:buy_now(<? echo $v['Product']['id']?>,1)"><?php echo $SCLanguages['buy'];?></a>
		<?}?>
	</span>
</p>
</li>
<?}?><?}else{?>
<br /><br />		
<? echo "<p class='not'>"?>
<?=$html->image('warning_img.gif',array('alt'=>''))?>
<?
echo "<strong>".$SCLanguages['coming_please_note']."</strong></p><br /><br /><br />";
}?>
</ul><!--商品列表文字排式End-->
<?}?>
</div></div>