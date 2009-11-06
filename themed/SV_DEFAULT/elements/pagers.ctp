<?php 
/*****************************************************************************
 * SV-Cart 分页
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: pagers.ctp 5028 2009-10-14 07:51:28Z huangbo $
*****************************************************************************/
?>
<?php if($paging['pageCount']>1){?>
<div id="pager">
<p>
<?php printf($this->data['languages']['total_to_eligible_commodities'],$this->data['page_total'])?>&nbsp;
	<?php if($this->params['controller'] == 'products' && $this->params['action'] == 'advancedsearch'){?>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'number_1'.(($rownum == 20)?'_over':'').'.gif':'number_1'.(($rownum == 20)?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$type."/".$url_keywords."/".$category_id."/".$brand_id."/".$min_price."/".$max_price."/".$this->data['get_page']."/".$orderby."/20/".$this->data['showtype']."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'number_2'.(($rownum == 40)?'_over':'').'.gif':'number_2'.(($rownum == 40)?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$type."/".$url_keywords."/".$category_id."/".$brand_id."/".$min_price."/".$max_price."/".$this->data['get_page']."/".$orderby."/40/".$this->data['showtype']."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'number_3'.(($rownum == 80)?'_over':'').'.gif':'number_3'.(($rownum == 80)?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$type."/".$url_keywords."/".$category_id."/".$brand_id."/".$min_price."/".$max_price."/".$this->data['get_page']."/".$orderby."/80/".$this->data['showtype']."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'number_4'.(($rownum == 'all')?'_over':'').'.gif':'number_4'.(($rownum == 'all')?'_over':'').'.gif';
			$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$type."/".$url_keywords."/".$category_id."/".$brand_id."/".$min_price."/".$max_price."/".$this->data['get_page']."/".$orderby."/all/".$this->data['showtype']."/";
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>		
	<?php }?>
	
	<?php if($this->params['controller'] == 'brands'){?>
<span class="View_img"><?php $display_mode_img=isset($img_style_url)?$img_style_url."/".'number_1'.(($this->data['rownum'] == 20)?'_over':'').'.gif':'number_1'.(($this->data['rownum'] == 20)?'_over':'').'.gif';
		if($this->params['controller'] == 'categories'){
			if($this->data['configs']['category_link_type'] == 1){
					if(isset($this->data['page_parent'])){
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_parent']."/".$this->data['page_category_name']."/".$this->data['get_page']."/".$this->data['orderby']."/20/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
					}else{
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_category_name']."/0/".$this->data['get_page']."/".$this->data['orderby']."/20/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
					}
			}else{
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/0/0/".$this->data['get_page']."/".$this->data['orderby']."/20/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
				}
		}else{
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$this->data['to_page_id']."/".$this->data['get_page']."/".$this->data['orderby']."/20/".$this->data['showtype']."/";
		}

			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'number_2'.(($this->data['rownum'] == 40)?'_over':'').'.gif':'number_2'.(($this->data['rownum'] == 40)?'_over':'').'.gif';
	
	
		if($this->params['controller'] == 'categories'){
			if($this->data['configs']['category_link_type'] == 1){
					if(isset($this->data['page_parent'])){
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_parent']."/".$this->data['page_category_name']."/".$this->data['get_page']."/".$this->data['orderby']."/40/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
					}else{
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_category_name']."/0/".$this->data['get_page']."/".$this->data['orderby']."/40/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
					}
			}else{
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/0/0/".$this->data['get_page']."/".$this->data['orderby']."/40/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
				}
		}else{
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$this->data['to_page_id']."/".$this->data['get_page']."/".$this->data['orderby']."/40/".$this->data['showtype']."/";
		}
			
			
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'number_3'.(($this->data['rownum'] == 80)?'_over':'').'.gif':'number_3'.(($this->data['rownum'] == 80)?'_over':'').'.gif';
		if($this->params['controller'] == 'categories'){
			if($this->data['configs']['category_link_type'] == 1){
					if(isset($this->data['page_parent'])){
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_parent']."/".$this->data['page_category_name']."/".$this->data['get_page']."/".$this->data['orderby']."/80/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
					}else{
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_category_name']."/0/".$this->data['get_page']."/".$this->data['orderby']."/80/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
					}
			}else{
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/0/0/".$this->data['get_page']."/".$this->data['orderby']."/80/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
				}
		}else{
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$this->data['to_page_id']."/".$this->data['get_page']."/".$this->data['orderby']."/80/".$this->data['showtype']."/";
		}
			
			
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>
	<span class="View_img"><?php 	$display_mode_img=isset($img_style_url)?$img_style_url."/".'number_4'.(($this->data['rownum'] == 'all')?'_over':'').'.gif':'number_4'.(($this->data['rownum'] == 'all')?'_over':'').'.gif';
		if($this->params['controller'] == 'categories'){
			if($this->data['configs']['category_link_type'] == 1){
					if(isset($this->data['page_parent'])){
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_parent']."/".$this->data['page_category_name']."/".$this->data['get_page']."/".$this->data['orderby']."/all/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
					}else{
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_category_name']."/0/".$this->data['get_page']."/".$this->data['orderby']."/all/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
					}
			}else{
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/0/0/".$this->data['get_page']."/".$this->data['orderby']."/all/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
				}
		}else{
				$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$this->data['to_page_id']."/".$this->data['get_page']."/".$this->data['orderby']."/all/".$this->data['showtype']."/";
		}
			echo $html->link($html->image($display_mode_img),$display_mode_url,"",false,false);
	?></span>		
	<?php }?>
	
	<?php if($this->params['controller'] == 'exchanges'){?>
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
	<?php }?>
		
	
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
	<span>    <input type="text" name="go_page" id="go_page"/></span><?php echo $SCLanguages['page'];?>

	<!--a href="javascript:GoPage(<?//php echo $paging['pageCount']?>);"-->
	<a href="javascript:Go_Page(<?php echo $paging['pageCount']?>,'<?php echo $this->data['pages_url_1']?>','<?php echo $this->data['pages_url_2']?>');">
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'to_page.gif':'to_page.gif')?></a>
  </p></div>
<?php }?>