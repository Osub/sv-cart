<?php
/*****************************************************************************
 * SV-Cart 我的收藏
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1329 2009-05-11 11:29:59Z huangbo $
*****************************************************************************/
?>
<div id="Products_box" style="border:0;">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
    	<h1 style="margin-bottom:0;"><span><?=$SCLanguages['my_favorite'];?></span></h1>
        <div id="Products">
      <div class="List_bg">
    
    <div id="con_one_1"><!--收藏商品-->
    	 	<?if(isset($fav_products) && sizeof($fav_products)>0){?>

<p class="View_item">
       	  <span class="view"><?=$SCLanguages['display_mode'];?>：</span>
       	  <?if(isset($SVConfigs['show_L']) &&  $SVConfigs['show_L'] == 1){?><span class="View_img">
       	  <?if ($showtype == 'L'){?>
       	  <?=$html->link($html->image('btn_display_mode_list_act_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products']))),"/favorites/index/".$rownum."/L",array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('btn_display_mode_list_act.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products']))),"/favorites/index/".$rownum."/L",array(),false,false);?>
          <?}?>
       	  </span><?}?><?if(isset($SVConfigs['show_G']) &&  $SVConfigs['show_G'] == 1){?><span class="View_img">
       	  <?if ($showtype == 'G'){?>
       	  <?=$html->link($html->image('btn_display_mode_grid_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['graph']))),"/favorites/index/".$rownum."/G",array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('btn_display_mode_grid.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['graph']))),"/favorites/index/".$rownum."/G",array(),false,false);?>
          <?}?>
       	  </span><?}?><?if(isset($SVConfigs['show_T']) &&  $SVConfigs['show_T'] == 1){?><span class="View_img">
       	  <?if ($showtype == 'T'){?>
       	  <?=$html->link($html->image('btn_display_mode_text_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['characters']))),"/favorites/index/".$rownum."/T",array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('btn_display_mode_text.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['characters']))),"/favorites/index/".$rownum."/T",array(),false,false);?>
          <?}?>
       	  </span>
       	   <?}?>
          <span class="number">
          <?if ($rownum == 20){?>
       	  <?=$html->link($html->image('number_1_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],20))),"/favorites/index/20/".$showtype,array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('number_1.gif',array('title'=>sprintf($SCLanguages['page_show_number'],20))),"/favorites/index/20/".$showtype,array(),false,false);?>
          <?}?>
          </span><span class="number_2">
          <?if ($rownum == 40){?>
       	  <?=$html->link($html->image('number_2_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],40))),"/favorites/index/40/".$showtype,array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('number_2.gif',array('title'=>sprintf($SCLanguages['page_show_number'],40))),"/favorites/index/40/".$showtype,array(),false,false);?>
          <?}?>
          </span><span>
          <?if ($rownum == 80){?>
       	  <?=$html->link($html->image('number_3_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],80))),"/favorites/index/80/".$showtype,array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('number_3.gif',array('title'=>sprintf($SCLanguages['page_show_number'],80))),"/favorites/index/80/".$showtype,array(),false,false);?>
          <?}?>
          </span>
          
        <span class="Mode"><?=$SCLanguages['sort_by'];?>：</span><span class="Mode_img">
        <?if ($orderby == 'shop_price DESC'){?>
       	  <?=$html->link($html->image('view_ivo01_over_down.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/favorites/index/".$rownum."/".$showtype."/shop_price ASC",array(),false,false);?>
          <?}else if($orderby == 'shop_price ASC'){?>
       	  <?=$html->link($html->image('view_ivo01_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/favorites/index/".$rownum."/".$showtype."/shop_price DESC",array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('view_ivo01.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/favorites/index/".$rownum."/".$showtype."/shop_price DESC",array(),false,false);?>
          <?}?>
        </span><span>
        <?if ($orderby == 'sale_stat DESC'){?>
       	  <?=$html->link($html->image('view_ivo02_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/favorites/index/".$rownum."/".$showtype."/sale_stat ASC",array(),false,false);?>
          <?}else if($orderby == 'sale_stat ASC'){?>
       	  <?=$html->link($html->image('view_ivo02_over_up.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/favorites/index/".$rownum."/".$showtype."/sale_stat DESC",array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('view_ivo02.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/favorites/index/".$rownum."/".$showtype."/sale_stat DESC",array(),false,false);?>
          <?}?>
        </span><span>
        <?if ($orderby == 'modified DESC'){?>
       	  <?=$html->link($html->image('view_ivo03_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/favorites/index/".$rownum."/".$showtype."/modified ASC",array(),false,false);?>
          <?}else if($orderby == 'modified ASC'){?>
       	  <?=$html->link($html->image('view_ivo03_over_up.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/favorites/index/".$rownum."/".$showtype."/modified DESC",array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('view_ivo03.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/favorites/index/".$rownum."/".$showtype."/modified DESC",array(),false,false);?>
          <?}?>
        </span>
        <span class="select_view">&nbsp;</span>
    </p>
        <div class="collection">
        	<span class="nonts">&nbsp;</span>
            <span class="Mart_prices"><?=$SCLanguages['market_price'];?></span>
            <span class="products_prices"><?=$SCLanguages['our_price'];?></span>
            <span class="handels"><?=$SCLanguages['operation'];?></span>
        </div><?}else{?>
        	<div class="not">
		<br />
		<?=$html->image("warning_img.gif",array("alt"=>""))?><strong><?=$SCLanguages['not_favorite_goods'];?></strong><br /><br /></div>
		<?}?>
 <?if ($showtype == 'L'){?>
 	<?if(isset($fav_products) && sizeof($fav_products)>0){?>
      <?foreach ($fav_products as $k=>$v){?>
        <div id="Item_box">
        	<div class="Item_info">
            	<p class="pic">            
			<?if($v['Product']['img_thumb'] != ""){?>
       	  <?=$html->link($html->image("/../".$v['Product']['img_thumb'],array("width"=>"108","height"=>"108")),"/../products/".$v['Product']['id'],array(),false,false);?>
			<?}else{?>
       	  <?=$html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),"/../products/".$v['Product']['id'],array(),false,false);?>
			 <?}?>            </p>
                <p class="info">
                	<span class="item_name">
			<?=$html->link($v['ProductI18n']['name'],"/../products/".$v['Product']['id'],array(),false,false);?>
            </span>
                </p>
            </div>
            <div class="mart">
            	<span class="Products_Price">
<?=$svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
            </span>
                
            </div>
            <div class="good_price">
                <span class="goodprice">
<?=$svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
               	</span>
            </div>
            <div class="btn_list collection_btn">
            	<a href="javascript:buy_now(<? echo $v['Product']['id']?>,1)"><span style="padding:0;margin-top:0;margin-right:3px;"><?=$SCLanguages['purchase'];?></span></a>
            	<a href="javascript:del_fav_products(<? echo $v['Product']['id']?>,'<?echo $user_id?>','p')"><span style="padding:0;margin-top:0;margin-right:3px;"><?=$SCLanguages['delete'];?></span></a>
            </div>
        </div>
      <?}?>
    <?}?>
  <?}elseif($showtype == 'G'){?>
              <div id="Item_List" style="border:0">
	<ul id="con_one_2" class="home-products">
		
	<?if(isset($fav_products) && sizeof($fav_products)>0){?>			  
  	<?foreach ($fav_products as $k=>$v){?>
	<li><p class="pic">
			<?if($v['Product']['img_thumb'] != ""){?>
       	  <?=$html->link($html->image("/../".$v['Product']['img_thumb'],array("width"=>"108","height"=>"108")),"/../products/".$v['Product']['id'],array(),false,false);?>
			<?}else{?>
       	  <?=$html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),"/../products/".$v['Product']['id'],array(),false,false);?>
			 <?}?>	</p>
	<p class="info">
	<span class="name">
			<?=$html->link($v['ProductI18n']['name'],"/../products/".$v['Product']['id'],array(),false,false);?>
		</span>
	<span class="Price"><?=$SCLanguages['market_price'];?>：<font color="#ff0000">
<?=$svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
		</font></span>
	<span class="Price"><?=$SCLanguages['our_price'];?>：<font color="#ff0000">
<?=$svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
		</font></span>
	<span class="stow"><?=$html->link($SCLanguages['delete'],"javascript:del_fav_products(".$v['Product']['id'].",'$user_id','p')",array(),false,false)?>|<?=$html->link($SCLanguages['purchase'],"javascript:buy_now({$v['Product']['id']},1)","",false,false)?></span>
	</p>
	</li>
	<?}?>
	<?}?>
		
	</ul>
</div>

          <?}elseif($showtype == 'T'){?>
          	  <?if(isset($fav_products) && sizeof($fav_products)>0){?>
                   <?foreach ($fav_products as $k=>$v){?>
                <div id="Item_box" style="height:60px;*height:50px;overflow:hidden;">
        	<div class="Item_info">
                <p class="info">
                	<span class="" style="margin-top:15px;">
			<?=$html->link($v['ProductI18n']['name'],"/../products/".$v['Product']['id'],array(),false,false);?>
                	</span>
                </p>
            </div>
            <div class="mart" style="margin-top:15px;">
            	<span class="">
<?=$svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
            		</span>
                
            </div>
            <div class="good_price" style="margin-top:15px;">
                <span class="">
<?=$svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
                </span>
            </div>
            <div class="btn_list collection_btn">
            	<a href="javascript:buy_now(<? echo $v['Product']['id']?>,1)"><span style="padding:0;margin-top:0;margin-right:3px;"><?=$SCLanguages['purchase'];?></span></a>
            	<a href="javascript:del_fav_products(<? echo $v['Product']['id']?>,'<?echo $user_id?>','p')"><span style="padding:0;margin-top:0;margin-right:3px;"><?=$SCLanguages['delete'];?></span></a>
            </div>
        </div>
          <?}?>
          <?}?>
     <?}?>
        <!--收藏商品END-->
        
<!---->
<!--End-->
 </div>
</div>
		</div> 
<?if(!empty($fav_products)){?>
<div id="pager">
<span class="totally"><?php printf($SCLanguages['totally_records_unpaid'],$fav_products_count)?></span>
	<?echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
<?}?>
        
   </div>
<?php echo $this->element('news', array('cache'=>'+0 hour'));?>

<script>
function del_fav_products(type_id,user_id,type){
    window.location.href= webroot_dir+"favorites/del_products_t/"+type_id+"/"+user_id+"/"+type;
}
</script>
