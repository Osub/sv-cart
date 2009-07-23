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
 * $Id: products_list.ctp 3261 2009-07-23 05:38:53Z huangbo $
*****************************************************************************/
?>
<div id="Item_ListBox">
<p class="View_item">
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'view-left.gif':'view-left.gif',array('class'=>'view-left'))?>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'view-right.gif':'view-right.gif',array('class'=>'view-right'))?>
	<span class="view"><?php echo $SCLanguages['display_mode'];?>:</span>
	<?php if(isset($SVConfigs['show_L']) && $SVConfigs['show_L'] == 1){?>
	<span class="View_img"><?php 	$display_mode_img= isset($img_style_url)?$img_style_url."/".'btn_display_mode_list'.(($showtype == 'L')?'_act_over':'').'.gif':'btn_display_mode_list'.(($showtype == 'L')?'_act_over':'').'.gif';
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
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/".$orderby."/".$rownum."/L/";
			}
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<?php }?>
	
	<?php if(isset($SVConfigs['show_G']) && $SVConfigs['show_G'] == 1){?>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'btn_display_mode_grid'.(($showtype == 'G')?'_over':'').'.gif':'btn_display_mode_grid'.(($showtype == 'G')?'_over':'').'.gif';
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
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/".$orderby."/".$rownum."/G/";
			}
			
			
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<?php }?>
	
	<?php if(isset($SVConfigs['show_T']) && $SVConfigs['show_T'] == 1){?>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'btn_display_mode_text'.(($showtype == 'T')?'_over':'').'.gif':'btn_display_mode_text'.(($showtype == 'T')?'_over':'').'.gif';
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
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/".$orderby."/".$rownum."/T/";
			}
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<?php }?>
	<span class="Mode"></span>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'number_1'.(($rownum == 20)?'_over':'').'.gif':'number_1'.(($rownum == 20)?'_over':'').'.gif';
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
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/".$orderby."/20/".$showtype."/";
		}

			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'number_2'.(($rownum == 40)?'_over':'').'.gif':'number_2'.(($rownum == 40)?'_over':'').'.gif';
	
	
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
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/".$orderby."/40/".$showtype."/";
		}
			
			
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'number_3'.(($rownum == 80)?'_over':'').'.gif':'number_3'.(($rownum == 80)?'_over':'').'.gif';
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
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/".$orderby."/80/".$showtype."/";
		}
			
			
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>



<span class="Mode"><?php echo $SCLanguages['sort_by'];?>:</span>
	<?php 
		if($this->params['controller'] == 'categories'){
			if($SVConfigs['use_sku'] == 1){
				if(isset($parent)){
					$mode_url="/".$this->params['controller']."/".$id."/".$parent."/".$CategoryI18n_name;
				}else{
					$mode_url="/".$this->params['controller']."/".$id."/".$CategoryI18n_name."/0";
				}
			}else{
					$mode_url="/".$this->params['controller']."/".$id."/0/0";
			}
		}else{
				$mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id;
		}	
	?>
	
	<?php if($orderby == 'shop_price DESC'){?>
		<span class="Mode_img">	
		<?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'view_ivo01_over_down.gif':'view_ivo01_over_down.gif';
			$display_mode_url =$mode_url."/shop_price ASC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }else if($orderby == 'shop_price ASC'){?>
		<span class="Mode_img">	
		<?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'view_ivo01_over.gif':'view_ivo01_over.gif';
			$display_mode_url=$mode_url."/shop_price DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }else{?>
		<span class="Mode_img">	
		<?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'view_ivo01.gif':'view_ivo01.gif';
			$display_mode_url=$mode_url."/shop_price DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }?>

	
	<?php if($orderby == 'sale_stat DESC'){?>
		<span class="Mode_img">
		<?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'view_ivo02_over.gif':'view_ivo02_over.gif';
			$display_mode_url=$mode_url."/sale_stat ASC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }else if($orderby == 'sale_stat ASC'){?>
		<span class="Mode_img">	
		<?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'view_ivo02_over_up.gif':'view_ivo02_over_up.gif';
			$display_mode_url=$mode_url."/sale_stat DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }else{?>
		<span class="Mode_img">	
		<?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'view_ivo02.gif':'view_ivo02.gif';
			$display_mode_url=$mode_url."/sale_stat DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }?>
	
	<?php if($orderby == 'modified DESC'){?>
		<span class="Mode_img">
		<?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'view_ivo03_over.gif':'view_ivo03_over.gif';
			$display_mode_url=$mode_url."/modified ASC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }else if($orderby == 'modified ASC'){?>
		<span class="Mode_img">	
		<?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'view_ivo03_over_up.gif':'view_ivo03_over_up.gif';
			$display_mode_url=$mode_url."/modified DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }else{?>
		<span class="Mode_img">	
		<?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'view_ivo03.gif':'view_ivo03.gif';
			$display_mode_url=$mode_url."/modified DESC/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
		</span>
	<?php }?>	
	
	<!--span class="Mode_img">
		<?php 	$display_mode_img='view_ivo03'.(($orderby == 'modified')?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$id."/modified/".$rownum."/".$showtype."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);?>
	</span-->
</p>
<div class="box">

<?php if($showtype == 'L'){ ?>
<ul>
<?php if (isset($products) && sizeof($products)>0){ ?>
<?php foreach($products as $k=>$v){ ?>
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
	<span class="Price"><?php echo $SCLanguages['our_price'];?>:
<font color="#ff0000"><?php if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?php echo $svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?php }?>
	</font></span>
</p>
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
	<?php if(isset($_SESSION['User'])){?>
	<a href="javascript:favorite(<?php echo $v['Product']['id']?>,'p');" class="fav"><span><?php echo $SCLanguages['favorite'];?></span></a>
	<?php }?>
<?php if($v['Product']['quantity'] == 0){?>
<a href="javascript:show_booking(<?php echo $v['Product']['id']?>,'<?php echo $v['ProductI18n']['name']?>')" class="fav"><span><?php echo $SCLanguages['booking'];?></span></a>
<?php }else{?>
<a href="javascript:buy_now(<?php echo $v['Product']['id']?>,1)" class="addtocart"><span><?php echo $SCLanguages['buy'];?></span></a>
<?php }?>
</span></p>
</div></li>
<?php }?><?php }else{?>
<br /><br />		
<?php echo "<p class='not'>"?>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('alt'=>''))?>
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
	<span class="Price"><?php echo $SCLanguages['our_price'];?>:
<font color="#ff0000"><?php if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?php echo $svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?php }?>
		</font></span>
	<span class="stow">
	<?php if(isset($_SESSION['User'])){?>
			<a href="javascript:favorite(<?php echo $v['Product']['id']?>,'p')"><?php echo $SCLanguages['favorite'];?></a>|<?php }?>
		<?php if($v['Product']['quantity'] == 0){?>
		<a href="javascript:show_booking(<?php echo $v['Product']['id']?>,'<?php echo $v['ProductI18n']['name']?>')"><?php echo $SCLanguages['booking'];?></a>
		<?php }else{?>	
		<a href="javascript:buy_now(<?php echo $v['Product']['id']?>,1)"><?php echo $SCLanguages['buy'];?></a>
		<?php }?>
		</span></p>
</li>
<?php }?><?php }else{?>
<br /><br />
<p class='not'>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('alt'=>''))?>
<strong><?php echo $SCLanguages['coming_please_note'];?></strong>
</p><br /><br /><br />
<?php }?>
</ul></div>
<?php }elseif($showtype == 'T'){?><?php if (isset($products) && sizeof($products)>0){ ?>
<p class="Title_Item">
	<?php if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
	<span class="Price"><?php echo $SCLanguages['market_price'];?></span>
	<?php }?>
	<span class="Price"><?php echo $SCLanguages['our_price'];?></span><span class="handel"><?php echo $SCLanguages['operation'];?></span></p>
<ul class="text_itemlist"><?php foreach($products as $k=>$v){ ?>
<li>
<p class="item_infos">
	<span class="name"><strong><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></strong>&nbsp;
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
<?php if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<span class="marketprice"><?php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?></span>
<?php }?>
<span class="Price">
<?php if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0){?>	
<?php echo $svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?php }?></span>
<span class="Territory">
	<?php if(isset($_SESSION['User'])){?>
		<a href="javascript:favorite(<?php echo $v['Product']['id']?>,'p')"><?php echo $SCLanguages['favorite'];?></a> | <?php }?>
		<?php if($v['Product']['quantity'] == 0){?>
		<a href="javascript:show_booking(<?php echo $v['Product']['id']?>,'<?php echo $v['ProductI18n']['name']?>')"><?php echo $SCLanguages['booking'];?></a>
		<?php }else{?>	
		<a href="javascript:buy_now(<?php echo $v['Product']['id']?>,1)"><?php echo $SCLanguages['buy'];?></a>
		<?php }?>
	</span>
</p>
</li>
<?php }?><?php }else{?>
<br /><br />		
<?php echo "<p class='not'>"?>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('alt'=>''))?>
<?php 
echo "<strong>".$SCLanguages['coming_please_note']."</strong></p><br /><br /><br />";
}?>
</ul><!--商品列表文字排式End-->
<?php }?>
</div></div>