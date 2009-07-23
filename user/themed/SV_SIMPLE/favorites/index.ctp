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
 * $Id: index.ctp 2081 2009-06-10 10:10:12Z shenyunfeng $
*****************************************************************************/
?>
<div id="Products_box" style="border:0;">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['my_favorite'];?></b></h1>
        <div id="Products">
      <div class="List_bg">
    
    <div id="con_one_1"><!--收藏商品-->
    	 	<?php if(isset($fav_products) && sizeof($fav_products)>0){?>

<p class="View_item">
       	  <span class="view"><?php echo $SCLanguages['display_mode'];?>：</span>
       	  <?php if(isset($SVConfigs['show_L']) &&  $SVConfigs['show_L'] == 1){?><span class="View_img">
       	  <?php if ($showtype == 'L'){?>
       	  <?php echo $html->link($html->image('btn_display_mode_list_act_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products']))),"favorites/index/".$rownum."/L",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image('btn_display_mode_list_act.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products']))),"favorites/index/".$rownum."/L",array(),false,false);?>
          <?php }?>
       	  </span><?php }?><?php if(isset($SVConfigs['show_G']) &&  $SVConfigs['show_G'] == 1){?><span class="View_img">
       	  <?php if ($showtype == 'G'){?>
       	  <?php echo $html->link($html->image('btn_display_mode_grid_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['graph']))),"/favorites/index/".$rownum."/G",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image('btn_display_mode_grid.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['graph']))),"/favorites/index/".$rownum."/G",array(),false,false);?>
          <?php }?>
       	  </span><?php }?><?php if(isset($SVConfigs['show_T']) &&  $SVConfigs['show_T'] == 1){?><span class="View_img">
       	  <?php if ($showtype == 'T'){?>
       	  <?php echo $html->link($html->image('btn_display_mode_text_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['characters']))),"/favorites/index/".$rownum."/T",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image('btn_display_mode_text.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['characters']))),"/favorites/index/".$rownum."/T",array(),false,false);?>
          <?php }?>
       	  </span>
       	   <?php }?>
          <span class="number">
          <?php if ($rownum == 20){?>
       	  <?php echo $html->link($html->image('number_1_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],20))),"/favorites/index/20/".$showtype,array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image('number_1.gif',array('title'=>sprintf($SCLanguages['page_show_number'],20))),"/favorites/index/20/".$showtype,array(),false,false);?>
          <?php }?>
          </span><span class="number_2">
          <?php if ($rownum == 40){?>
       	  <?php echo $html->link($html->image('number_2_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],40))),"/favorites/index/40/".$showtype,array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image('number_2.gif',array('title'=>sprintf($SCLanguages['page_show_number'],40))),"/favorites/index/40/".$showtype,array(),false,false);?>
          <?php }?>
          </span><span>
          <?php if ($rownum == 80){?>
       	  <?php echo $html->link($html->image('number_3_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],80))),"/favorites/index/80/".$showtype,array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image('number_3.gif',array('title'=>sprintf($SCLanguages['page_show_number'],80))),"/favorites/index/80/".$showtype,array(),false,false);?>
          <?php }?>
          </span>
          
        <span class="Mode"><?php echo $SCLanguages['sort_by'];?>：</span><span class="Mode_img">
        <?php if ($orderby == 'shop_price DESC'){?>
       	  <?php echo $html->link($html->image('view_ivo01_over_down.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/favorites/index/".$rownum."/".$showtype."/shop_price ASC",array(),false,false);?>
          <?php }else if($orderby == 'shop_price ASC'){?>
       	  <?php echo $html->link($html->image('view_ivo01_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/favorites/index/".$rownum."/".$showtype."/shop_price DESC",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image('view_ivo01.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/favorites/index/".$rownum."/".$showtype."/shop_price DESC",array(),false,false);?>
          <?php }?>
        </span><span>
        <?php if ($orderby == 'sale_stat DESC'){?>
       	  <?php echo $html->link($html->image('view_ivo02_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/favorites/index/".$rownum."/".$showtype."/sale_stat ASC",array(),false,false);?>
          <?php }else if($orderby == 'sale_stat ASC'){?>
       	  <?php echo $html->link($html->image('view_ivo02_over_up.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/favorites/index/".$rownum."/".$showtype."/sale_stat DESC",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image('view_ivo02.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/favorites/index/".$rownum."/".$showtype."/sale_stat DESC",array(),false,false);?>
          <?php }?>
        </span><span>
        <?php if ($orderby == 'modified DESC'){?>
       	  <?php echo $html->link($html->image('view_ivo03_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/favorites/index/".$rownum."/".$showtype."/modified ASC",array(),false,false);?>
          <?php }else if($orderby == 'modified ASC'){?>
       	  <?php echo $html->link($html->image('view_ivo03_over_up.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/favorites/index/".$rownum."/".$showtype."/modified DESC",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image('view_ivo03.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/favorites/index/".$rownum."/".$showtype."/modified DESC",array(),false,false);?>
          <?php }?>
        </span>
        <span class="select_view">&nbsp;</span>
    </p>
<?php }else{?>
        	<div class="not">
		<br />
		<?php echo $html->image("warning_img.gif",array("alt"=>""))?><strong><?php echo $SCLanguages['not_favorite_goods'];?></strong><br /><br /></div>
		<?php }?>
 <?php if ($showtype == 'L'){?>
 	<?php if(isset($fav_products) && sizeof($fav_products)>0){?>
        <div class="collection">
        	<span class="nonts">&nbsp;</span>
            <span class="Mart_prices">
		  &nbsp;<?php if( isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
            <?php echo $SCLanguages['market_price'];?>
          <?php }?>  
            </span>
            <span class="products_prices"><?php echo $SCLanguages['our_price'];?></span>
            <span class="handels"><?php echo $SCLanguages['operation'];?></span>
        </div> 		
 		
      <?php foreach ($fav_products as $k=>$v){?>
        <div id="Item_box">
        	<div class="Item_info">
            	<p class="pic">            
			<?php if($v['Product']['img_thumb'] != ""){?>
       	  <?php echo $html->link($html->image("/../".$v['Product']['img_thumb'],array("width"=>"108","height"=>"108")),"../".$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array(),false,false);?>
			<?php }else{?>
       	  <?php echo $html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),"../".$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array(),false,false);?>
			 <?php }?>            </p>
                <p class="info">
                	<span class="item_name">
			<?php echo $html->link($v['ProductI18n']['name'],"../".$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?>
            </span>
                </p>
            </div>
            <div class="mart">
            	<span class="Products_Price">&nbsp;
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<?php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
<?php }?>
            </span>
                
            </div>
            <div class="good_price">
                <span class="goodprice">
<?php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
               	</span>
            </div>
            <div class="btn_list collection_btn">
			
			<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
				<?php //php echo $form->create($server_host.$cart_webroot.'carts',array('action'=>'buy_now','name'=>'buy_nowproduct'.$v['Product']['id'],'type'=>'POST'));?>
					<form action='<?php echo $server_host.$cart_webroot.'carts/buy_now' ?>' name="buy_nowproduct<?php echo $v['Product']['id']?>" method="POST">
					<input type="hidden" name="id" value="<?php echo $v['Product']['id']?>"/>
					<input type="hidden" name="quantity" value="1"/>
					<input type="hidden" name="type" value="product"/>
					<?php echo $html->link("<span style='padding:0;margin-top:0;margin-right:3px;'>".$SCLanguages['purchase']."</span>","javascript:buy_now_no_ajax({$v['Product']['id']},1,'product')","",false,false)?>
				<?php //php echo $form->end();?>
					</form>
			<?php }else{?>	            	
            	<a href="javascript:buy_now(<?php echo $v['Product']['id']?>,1)"><span style="padding:0;margin-top:0;margin-right:3px;"><?php echo $SCLanguages['purchase'];?></span></a>
            <?php }?>
            
            	<a href="javascript:del_fav_products(<?php echo $v['Product']['id']?>,'<?php echo $user_id?>','p')"><span style="padding:0;margin-top:0;margin-right:3px;"><?php echo $SCLanguages['delete'];?></span></a>
            </div>
        </div>
      <?php }?>
    <?php }?>
  <?php }elseif($showtype == 'G'){?>
              <div id="Item_List" style="border:0">
	<ul id="con_one_2" class="home-products">
		
	<?php if(isset($fav_products) && sizeof($fav_products)>0){?>			  
  	<?php foreach ($fav_products as $k=>$v){?>
	<li><p class="pic">
			<?php if($v['Product']['img_thumb'] != ""){?>
       	  <?php echo $html->link($html->image("/../".$v['Product']['img_thumb'],array("width"=>"108","height"=>"108")),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku'],$server_host,$cart_webroot),array(),false,false);?>
			<?php }else{?>
       	  <?php echo $html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku'],$server_host,$cart_webroot),array(),false,false);?>
			 <?php }?>	</p>
	<p class="info">
	<span class="name">
			<?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku'],$server_host,$cart_webroot),array("target"=>"_blank"),false,false);?>
		</span>
	<span class="Price">
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
		<?php echo $SCLanguages['market_price'];?>：
<?php }?>
		<font color="#ff0000">
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<?php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
<?php }?>
		</font></span>
	<span class="Price"><?php echo $SCLanguages['our_price'];?>：<font color="#ff0000">
<?php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
		</font></span>
	<span class="stow"><?php echo $html->link($SCLanguages['delete'],"javascript:del_fav_products(".$v['Product']['id'].",'$user_id','p')",array(),false,false)?>|
			<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
				<?php //php echo $form->create($server_host.$cart_webroot.'carts',array('action'=>'buy_now','name'=>'buy_nowproduct'.$v['Product']['id'],'type'=>'POST'));?>
					<form action='<?php echo $server_host.$cart_webroot.'carts/buy_now' ?>' name="buy_nowproduct<?php echo $v['Product']['id']?>" method="POST">
					<input type="hidden" name="id" value="<?php echo $v['Product']['id']?>"/>
					<input type="hidden" name="quantity" value="1"/>
					<input type="hidden" name="type" value="product"/>
					<?php echo $html->link($SCLanguages['purchase'],"javascript:buy_now_no_ajax({$v['Product']['id']},1,'product')","",false,false)?>
				<?php //php echo $form->end();?>
					</form>
			<?php }else{?>	 			
			<?php echo $html->link($SCLanguages['purchase'],"javascript:buy_now({$v['Product']['id']},1)","",false,false)?>
		<?php }?>
	</span>
	</p>
	</li>
	<?php }?>
	<?php }?>
		
	</ul>
</div>

          <?php }elseif($showtype == 'T'){?>
          	  <?php if(isset($fav_products) && sizeof($fav_products)>0){?>
        <div class="collection">
        	<span class="nonts">&nbsp;</span>
            <span class="Mart_prices">
		  &nbsp;<?php if( isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
            <?php echo $SCLanguages['market_price'];?>
          <?php }?>  
            </span>
            <span class="products_prices"><?php echo $SCLanguages['our_price'];?></span>
            <span class="handels"><?php echo $SCLanguages['operation'];?></span>
        </div>          	  	  
          	  	  
          	  	  
                   <?php foreach ($fav_products as $k=>$v){?>
                <div id="Item_box" style="height:60px;*height:50px;overflow:hidden;">
        	<div class="Item_info">
                <p class="info">
                	<span class="" style="margin-top:15px;">
			<?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?>
                	</span>
                </p>
            </div>
            <div class="mart" style="margin-top:15px;">
            	<span class="">
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<?php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
<?php }?>
            		</span>
                
            </div>
            <div class="good_price" style="margin-top:15px;">
                <span class="">
<?php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
                </span>
            </div>
            <div class="btn_list collection_btn">
			<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
				<?php //php echo $form->create($server_host.$cart_webroot.'carts',array('action'=>'buy_now','name'=>'buy_nowproduct'.$v['Product']['id'],'type'=>'POST'));?>
					<form action='<?php echo $server_host.$cart_webroot.'carts/buy_now' ?>' name="buy_nowproduct<?php echo $v['Product']['id']?>" method="POST">
					<input type="hidden" name="id" value="<?php echo $v['Product']['id']?>"/>
					<input type="hidden" name="quantity" value="1"/>
					<input type="hidden" name="type" value="product"/>
					<?php echo $html->link("<span style='padding:0;margin-top:0;margin-right:3px;'>".$SCLanguages['purchase']."</span>","javascript:buy_now_no_ajax({$v['Product']['id']},1,'product')","",false,false)?>
				<?php //php echo $form->end();?>
					</form>
			<?php }else{?>	            	
            	<a href="javascript:buy_now(<?php echo $v['Product']['id']?>,1)"><span style="padding:0;margin-top:0;margin-right:3px;"><?php echo $SCLanguages['purchase'];?></span></a>
            <?php }?>
            		
            	<a href="javascript:del_fav_products(<?php echo $v['Product']['id']?>,'<?php echo $user_id?>','p')"><span style="padding:0;margin-top:0;margin-right:3px;"><?php echo $SCLanguages['delete'];?></span></a>
            </div>
        </div>
          <?php }?>
          <?php }?>
     <?php }?>
        <!--收藏商品END-->
        
<!---->
<!--End-->
 </div>
</div>
		</div> 
<?php if(!empty($fav_products)){?>
<div id="pager">
<span class="totally"><?php printf($SCLanguages['totally_records_unpaid'],$fav_products_count)?></span>
	<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
<?php }?>
        
   </div>
<?php echo $this->element('news', array('cache'=>'+0 hour'));?>

<script>
function del_fav_products(type_id,user_id,type){
    window.location.href= webroot_dir+"favorites/del_products_t/"+type_id+"/"+user_id+"/"+type;
}
</script>
