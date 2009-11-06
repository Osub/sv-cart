<?php 
/*****************************************************************************
 * SV-Cart 商品分类
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 5028 2009-10-14 07:51:28Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<?php if(isset($flashes['FlashImage']) && sizeof($flashes['FlashImage'])>0){?>
<div id="Flash" style="margin-bottom:5px;">
<?php echo $flash->renderSwf('img/bcastr4.swf?xml='.$cart_webroot.'flashes/index/PC/'.$id,$flashes['Flash']['width'],$flashes['Flash']['height'],false,array('params' => array('movie'=>$cart_webroot.'img/bcastr4.swf?xml='.$cart_webroot.'flashes/index/PC/'.$id,'wmode'=>'Opaque')));?>
</div>
<?php }?>
<?if($info['Category']['img01'] != ""){?><?php echo $html->image($info['Category']['img01'],array('height'=>'210px','width'=>'741px'))?><?}?>
<!-- 分类下的 新品 和 推荐 -->
<?php if( (isset($this->data['category_new_products']) && sizeof($this->data['category_new_products']) > 0)   ||    (isset($this->data['category_recommand_products']) && sizeof($this->data['category_recommand_products']) > 0)){?>
<ul class="content_tab">
<?php if(isset($this->data['category_new_products']) && sizeof($this->data['category_new_products']) > 0){?>
<?php if(isset($this->data['sign']) && $this->data['sign'] == "products_newarrival"){?>
<li id="one<?php echo $this->data['tab_arr']['products_newarrival']?>" onmouseover="overtab('one',<?php echo $this->data['tab_arr']['products_newarrival']?>,<?php echo $this->data['size']?>)"  class="hover">
<?php }else{?>
<li id="one<?php echo $this->data['tab_arr']['products_newarrival']?>" onmouseover="overtab('one',<?php echo $this->data['tab_arr']['products_newarrival']?>,<?php echo $this->data['size']?>)" >
<?php }?>
<span><?php echo $this->data['languages']['new_arrival'];?></span></li>
<?php }?>
<?php if(isset($this->data['category_recommand_products']) && sizeof($this->data['category_recommand_products']) > 0){?>
<?php if(isset($this->data['sign']) && $this->data['sign'] == "products_recommand"){?>
<li id="one<?php echo $this->data['tab_arr']['products_recommand']?>" onmouseover="overtab('one',<?php echo $this->data['tab_arr']['products_recommand']?>,<?php echo $this->data['size']?>)" class="hover">
<?php }else{?>
<li id="one<?php echo $this->data['tab_arr']['products_recommand']?>" onmouseover="overtab('one',<?php echo $this->data['tab_arr']['products_recommand']?>,<?php echo $this->data['size']?>)" >
<?php }?>
<span><?php echo $this->data['languages']['recommend'];?></span></li><?php }?>
</ul>
<div  class="border Item_List">
<cake:nocache>
<?php if(isset($this->data['category_new_products']) && sizeof($this->data['category_new_products']) > 0){?>
<!--新品-->
<?php if($this->data['sign'] == "products_newarrival"){?>
<div id="con_one_<?php echo $this->data['tab_arr']['products_newarrival']?>">
<?php }else{?>
<div id="con_one_<?php echo $this->data['tab_arr']['products_newarrival']?>" style="display:none;">
<?php }?>
<?php foreach($this->data['category_new_products'] as $k=>$v){?>
<?php if($k==0){?><ul class="home-products"><?php }?>
	<li><p class="pic"><?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$v['ProductI18n']['name']);?></p><p class="info"><span class="name"><?php echo $html->link( $v['ProductI18n']['sub_name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank"),false,false);?></span></p></li>
<?php  if( $k%5==4 && $k<sizeof($this->data['category_new_products'])-1 ){?>
	<?php if($k == 0){?>
	<?php }else{?>
	</ul>
	<ul class="home-products">
	<?php }?>
	<?php }else if($k==sizeof($this->data['category_new_products'])-1){?>
	</ul><?php }else{?><?php }?>
<?php }?>
</div>
<!--新品 End-->
<?php }?>
</cake:nocache>
<cake:nocache>
<?php if(isset($this->data['category_recommand_products']) && sizeof($this->data['category_recommand_products']) > 0){?>
<!--推荐-->
<?php if($this->data['sign'] == "products_recommand"){?>
<div id="con_one_<?php echo $this->data['tab_arr']['products_recommand']?>">
<?php }else{?>
<div id="con_one_<?php echo $this->data['tab_arr']['products_recommand']?>" style="display:none">
<?php }?>
<?php foreach($this->data['category_recommand_products'] as $kk=>$vv){?>
<?php if($kk==0){?><ul class="home-products"><?php }?>
	<li><p class="pic"><?php echo $svshow->productimagethumb($vv['Product']['img_thumb'],$svshow->sku_product_link($vv['Product']['id'],$vv['ProductI18n']['name'],$vv['Product']['code'],$this->data['configs']['product_link_type']),array("alt"=>$vv['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$v['ProductI18n']['name']);?></p><p class="info"><span class="name"><?php echo $html->link( $vv['ProductI18n']['sub_name'],$svshow->sku_product_link($vv['Product']['id'],$vv['ProductI18n']['name'],$vv['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank"),false,false);?></span></p></li>
<?php  if( $kk%5==4 && $k<sizeof($this->data['category_recommand_products'])-1 ){?>
	<?php if($kk == 0){?>
	<?php }else{?>
	</ul>
	<ul class="home-products">
	<?php }?>
	<?php }else if($kk==sizeof($this->data['category_recommand_products'])-1){?>
	</ul><?php }else{?><?php }?>
<?php }?>
</div>
<!--推荐 End-->
<?php }?></cake:nocache>
</div><?php }?>
<div class="height_5">&nbsp;</div>
<!-- 分类下的 新品 和 推荐  END-->
	<?if($info['Category']['img02'] != ""){?>
		<div class="banner"><?php echo $html->image($info['Category']['img02'],array('height'=>'210px','width'=>'741px'))?></div>
		<div class="height_5">&nbsp;</div>
	<?}?>
			
<!-- 分类下的子分类-->
<?php if(isset($sub_category) && sizeof($sub_category)>0){?>
<ul class="content_tab">
<li class="hover"><span><?php echo $this->data['languages']['subcategories'];?></span></li>
</ul>
<div  class="border Item_List">
<div>
<?php foreach($sub_category as $kk=>$vv){?>
<?php if($kk==0){?><ul class="home-products"><?php }?>
	<li><p class="pic">
		<?php if($vv['Category']['img01'] != ""){?>
			<?php echo $html->link($html->image($vv['Category']['img01'],array("alt"=>$vv['CategoryI18n']['name'],"width"=>isset($this->data['configs']['thumbl_image_width'])?$this->data['configs']['thumbl_image_width']:108,"height"=>isset($this->data['configs']['thumb_image_height'])?$this->data['configs']['thumb_image_height']:108)),"/categories/".$vv['Category']['id'],array('title'=>$vv['CategoryI18n']['name']),false,false);?>
		<?php }else{?>
			<?php echo $html->link($html->image("/img/product_default.jpg",array("alt"=>$vv['CategoryI18n']['name'],"width"=>isset($this->data['configs']['thumbl_image_width'])?$this->data['configs']['thumbl_image_width']:108,"height"=>isset($this->data['configs']['thumb_image_height'])?$this->data['configs']['thumb_image_height']:108)),"/categories/".$vv['Category']['id'],array('title'=>$vv['CategoryI18n']['name']),false,false);?>
		<?php }?>
		</p><p class="info"><span class="name"><?php echo $html->link( $vv['CategoryI18n']['name'],"/categories/".$vv['Category']['id'],array("target"=>"_blank"),false,false);?></span></p></li>
<?php  if( $kk%5==4 && $k<sizeof($sub_category)-1 ){?>
	<?php if($kk == 0){?>
	<?php }else{?>
	</ul>
	<ul class="home-products">
	<?php }?>
	<?php }else if($kk==sizeof($sub_category)-1){?>
	</ul><?php }else{?><?php }?>
<?php }?>
</div>
</div>	<br/>	
<?php }?>
<!-- 分类下的子分类END-->
			
<!-- 分类的筛选 -->
<?if(isset($SVConfigs['screening_setting']) && $SVConfigs['screening_setting'] == 1){?>
<?php if((isset($view_brands) && sizeof($view_brands)) || (isset($price_arr) && sizeof($price_arr)>0) || (isset($product_types) && sizeof($product_types)>0)){?>
<div class="Item_ListBox"><!-- style="display:none;" -->
	<p class="View_item"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'view-left.gif':'view-left.gif',array('class'=>'view-left'))?><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'view-right.gif':'view-right.gif',array('class'=>'view-right'))?><span class="view"><?php echo $this->data['languages']['screening'];?>:</span></p>
	<div class="box screening color_5">
	
	<table>
	<?if(isset($view_brands) && sizeof($view_brands)){?>
	<tr id="screening_brand">
		<th><?=$this->data['languages']['brand']?>: </th>
		<td>
		<?if(true){?>
		<?if($brand == 0){?>
		<span class="all"><?=$this->data['languages']['all']?></span><?}else{?><?=$html->link($this->data['languages']['all'],$this->data['display_mode_url']."0/".$price_max."/".$price_min."/".$filters."/".$this->data['ad_keyword']."/",array(),false,false)?> <?}?>
		<?foreach($view_brands as $k=>$v){?>
		<?if($brand == $v['Brand']['id']){?>
		<span class="all"><?=$v['BrandI18n']['name']?></span>
<?}else{?><?=$html->link($v['BrandI18n']['name'],$this->data['display_mode_url'].$v['Brand']['id']."/".$price_max."/".$price_min."/".$filters."/".$this->data['ad_keyword']."/",array(),false,false)?> 
			<?}?><?}?><?}else{?> 
		<?foreach($view_brands as $k=>$v){?>
		<span class="all"><?=$v['BrandI18n']['name']?></span>
		<?}}?>    
</td>
	</tr>
	<?}?>
<cake:nocache>
		<?if(isset($this->data['price_arr']) && sizeof($this->data['price_arr'])>0){?>
	<tr id="screening_price">
		<th><?=$this->data['languages']['price']?>:</th>
		<td>
		<?if(sizeof($this->data['price_arr'])>1){?>
		<?if($this->data['price_min']."-".$this->data['price_max'] == "0-0"){?>
			<span class="all"><?=$this->data['languages']['all']?></span>
		<?}else{?>
<?=$html->link($this->data['languages']['all'],$this->data['display_mode_url'].$this->data['pagination_brand']."/0/0/".$this->data['page_filters']."/".$this->data['ad_keyword']."/",array(),false,false)?> 
		<?}?>
		<?foreach($this->data['price_arr'] as $k=>$v){?>
		<?if($this->data['price_min']."-".$this->data['price_max'] == $v){?>
		<span class="all"><?$this_price = explode('-',$v);?><?=$this_price[0]*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate']."-".$this_price[1]*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate']?></span>
		<?}else{?><?$this_price = explode('-',$v);?>
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
									<?=$html->link($this_price[0]*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate']."-".$this_price[1]*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['display_mode_url'].$this->data['pagination_brand']."/".$this_price[0]."/".$this_price[1]."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/",array(),false,false)?> 
									<?php }else{?>
									<?=$html->link($v,$this->data['display_mode_url'].$this->data['pagination_brand']."/".$this_price[0]."/".$this_price[1]."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/",array(),false,false)?> 
								<?php }?>									
							<?}?>								
						<?}?>
					<?}?>
		</td>
	</tr>
		<?}?>
</cake:nocache>
		<?if(isset($product_attribute_arr) && sizeof($product_attribute_arr)>0){ $k=0;?>
			<? 
				$filter_arr = array();
				if($filters != ''){
					$filter_arr =  explode('.',$filters); 
				}	
				$filter_url_arr = $filter_arr;
				$product_type_attribute_id = array();
			?>
			<?foreach($product_attribute_arr as $a=>$v){?>
				<?if(true){?>
				<tr id="screening_attribute<?php echo $a;?>">
					<th><?=$a?>: </th>
					<td>
							<?if(true){?>
							<?if($filter_arr[$k] == "0"){?>
								<span class="all"><?=$this->data['languages']['all']?></span>
							<?}else{?>
								<?	$filter_url_arr = $filter_arr;
									$filter_url_arr[$k] = 0;
									$filter_url = implode('.',$filter_url_arr);
								?>
								<?=$html->link($this->data['languages']['all'],$this->data['display_mode_url'].$brand."/".$price_min."/".$price_max."/".$filter_url."/".$this->data['ad_keyword']."/",array(),false,false)?> 
							<?}?>
							<?foreach($v as $kk=>$vv){?>
								<?if(isset($filter_arr[$k]) && $filter_arr[$k] == $kk){?>
									<span class="all"><?=$vv?></span>
								<?}else{?>
								<? 	$filter_url_arr = $filter_arr;
									$filter_url_arr[$k] =  $kk;
									$filter_url = implode('.',$filter_url_arr);
									
								?>										
									<?=$html->link($vv,$this->data['display_mode_url'].$brand."/".$price_min."/".$price_max."/".$filter_url."/".$this->data['ad_keyword']."/",array(),false,false)?> 
								<?}?>								
							<?}?>
						<?}else{?>
							<?foreach($v as $kk=>$vv){?>
								<span class="all"><?=$vv?></span>
							<?}?>
						<?}?>
					
					</td>
				</tr>
				<? $k++;}?>
			<?}?>
		<?}?>
	</table>

	</div>
</div>
<div class="height_5">&nbsp;</div>
	<?}?>
<?}?>
<!-- 分类的筛选End -->
<?php echo $this->element('products_list', array('cache'=>'+0 hour'));?>
<?php if($paging['pageCount']>1){?>
<div id="pager">
<p>
<?php printf($this->data['languages']['total_to_eligible_commodities'],$this->data['page_total'])?>&nbsp;
<span class="View_img"><?php $display_mode_img=isset($img_style_url)?$img_style_url."/".'number_1'.(($this->data['rownum'] == 20)?'_over':'').'.gif':'number_1'.(($this->data['rownum'] == 20)?'_over':'').'.gif';
		if($this->params['controller'] == 'categories'){
			if($this->data['configs']['category_link_type'] == 1){
					if(isset($this->data['page_parent'])){
					$this->data['display_mode_url']="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_parent']."/".$this->data['page_category_name']."/".$this->data['get_page']."/".$this->data['orderby']."/20/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/";
					}else{
					$this->data['display_mode_url']="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_category_name']."/0/".$this->data['get_page']."/".$this->data['orderby']."/20/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/";
					}
			}else{
					$this->data['display_mode_url']="/".$this->params['controller']."/".$this->data['to_page_id']."/0/0/".$this->data['get_page']."/".$this->data['orderby']."/20/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/";
				}
		}else{
				$this->data['display_mode_url']="/".$this->params['controller']."/".$this->params['action']."/".$this->data['to_page_id']."/".$this->data['get_page']."/".$this->data['orderby']."/20/".$this->data['showtype']."/";
		}

			echo $html->link($html->image($display_mode_img),$this->data['display_mode_url'],"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'number_2'.(($this->data['rownum'] == 40)?'_over':'').'.gif':'number_2'.(($this->data['rownum'] == 40)?'_over':'').'.gif';
	
	
		if($this->params['controller'] == 'categories'){
			if($this->data['configs']['category_link_type'] == 1){
					if(isset($this->data['page_parent'])){
					$this->data['display_mode_url']="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_parent']."/".$this->data['page_category_name']."/".$this->data['get_page']."/".$this->data['orderby']."/40/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/";
					}else{
					$this->data['display_mode_url']="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_category_name']."/0/".$this->data['get_page']."/".$this->data['orderby']."/40/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/";
					}
			}else{
					$this->data['display_mode_url']="/".$this->params['controller']."/".$this->data['to_page_id']."/0/0/".$this->data['get_page']."/".$this->data['orderby']."/40/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/";
				}
		}else{
				$this->data['display_mode_url']="/".$this->params['controller']."/".$this->params['action']."/".$this->data['to_page_id']."/".$this->data['get_page']."/".$this->data['orderby']."/40/".$this->data['showtype']."/";
		}
			
			
			echo $html->link($html->image($display_mode_img),$this->data['display_mode_url'],"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'number_3'.(($this->data['rownum'] == 80)?'_over':'').'.gif':'number_3'.(($this->data['rownum'] == 80)?'_over':'').'.gif';
		if($this->params['controller'] == 'categories'){
			if($this->data['configs']['category_link_type'] == 1){
					if(isset($this->data['page_parent'])){
					$this->data['display_mode_url']="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_parent']."/".$this->data['page_category_name']."/".$this->data['get_page']."/".$this->data['orderby']."/80/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/";
					}else{
					$this->data['display_mode_url']="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_category_name']."/0/".$this->data['get_page']."/".$this->data['orderby']."/80/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/";
					}
			}else{
					$this->data['display_mode_url']="/".$this->params['controller']."/".$this->data['to_page_id']."/0/0/".$this->data['get_page']."/".$this->data['orderby']."/80/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/";
				}
		}else{
				$this->data['display_mode_url']="/".$this->params['controller']."/".$this->params['action']."/".$this->data['to_page_id']."/".$this->data['get_page']."/".$this->data['orderby']."/80/".$this->data['showtype']."/";
		}
			
			
			echo $html->link($html->image($display_mode_img),$this->data['display_mode_url'],"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'number_4'.(($this->data['rownum'] == 'all')?'_over':'').'.gif':'number_3'.(($this->data['rownum'] == 'all')?'_over':'').'.gif';
		if($this->params['controller'] == 'categories'){
			if($this->data['configs']['category_link_type'] == 1){
					if(isset($this->data['page_parent'])){
					$this->data['display_mode_url']="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_parent']."/".$this->data['page_category_name']."/".$this->data['get_page']."/".$this->data['orderby']."/all/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/";
					}else{
					$this->data['display_mode_url']="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_category_name']."/0/".$this->data['get_page']."/".$this->data['orderby']."/all/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/";
					}
			}else{
					$this->data['display_mode_url']="/".$this->params['controller']."/".$this->data['to_page_id']."/0/0/".$this->data['get_page']."/".$this->data['orderby']."/all/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/";
				}
		}else{
				$this->data['display_mode_url']="/".$this->params['controller']."/".$this->params['action']."/".$this->data['to_page_id']."/".$this->data['get_page']."/".$this->data['orderby']."/all/".$this->data['showtype']."/";
		}
			echo $html->link($html->image($display_mode_img),$this->data['display_mode_url'],"",false,false);
	?></span>		
		
		
	<?php 
	
    if($pagination->setPaging($paging)): 
    $pagenow=$paging['page'];
    $leftArrow = $html->image(isset($img_style_url)?$img_style_url."/"."back_icon.gif":"back_icon.gif", Array('height'=>15)); 
    $rightArrow = $html->image(isset($img_style_url)?$img_style_url."/"."right_icon.gif":"right_icon.gif", Array('height'=>15)); 
    $flag=0;
    $prev = $pagination->prevPage($leftArrow,false); 
    $prev = $prev?$prev:$leftArrow; 
    $next = $pagination->nextPage($rightArrow,false); 
    $next = $next?$next:$rightArrow; 
    $pages = $pagination->pageNumbers("     ");
    echo "$prev";
    echo "$pages";
    echo "$next";
    endif;

?> 
	<span><input type="text" name="go_page" id="go_page"/></span><?php echo $this->data['languages']['page'];?>

	<!--a href="javascript:GoPage(<?//php echo $paging['pageCount']?>);"-->
	<a href="javascript:Go_Page(<?php echo $paging['pageCount']?>,'<?php echo $this->data['pages_url_1']?>','<?php echo $this->data['pages_url_2']?>');">
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'to_page.gif':'to_page.gif')?></a>
  </p></div>
<?php }?>
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
