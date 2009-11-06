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
 * $Id: index.ctp 4333 2009-09-17 10:46:57Z huangbo $
*****************************************************************************/
?>
<div id="Products_box" style="border:0;">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?><h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['my_favorite'];?></b></h1>
      <div id="Products">
      <div class="List_bg">
    
    <div id="con_one_1"><!--收藏商品-->
    	 	<?php if(isset($fav_products) && sizeof($fav_products)>0){?>

<p class="View_item">
       	  <span class="view"><?php echo $SCLanguages['show'];?>：</span>
       	  <?php if(isset($SVConfigs['show_L']) &&  $SVConfigs['show_L'] == 1){?><span class="View_img">
       	  <?php if ($showtype == 'L'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'btn_display_mode_list_act_over.gif':'btn_display_mode_list_act_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products']))),"/favorites/index/".$rownum."/L",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'btn_display_mode_list_act.gif':'btn_display_mode_list_act.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products']))),"/favorites/index/".$rownum."/L",array(),false,false);?>
          <?php }?>
       	  </span><?php }?><?php if(isset($SVConfigs['show_G']) &&  $SVConfigs['show_G'] == 1){?><span class="View_img">
       	  <?php if ($showtype == 'G'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'btn_display_mode_grid_over.gif':'btn_display_mode_grid_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['graph']))),"/favorites/index/".$rownum."/G",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'btn_display_mode_grid.gif':'btn_display_mode_grid.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['graph']))),"/favorites/index/".$rownum."/G",array(),false,false);?>
          <?php }?>
       	  </span><?php }?><?php if(isset($SVConfigs['show_T']) &&  $SVConfigs['show_T'] == 1){?><span class="View_img">
       	  <?php if ($showtype == 'T'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'btn_display_mode_text_over.gif':'btn_display_mode_text_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['characters']))),"/favorites/index/".$rownum."/T",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'btn_display_mode_text.gif':'btn_display_mode_text.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['characters']))),"/favorites/index/".$rownum."/T",array(),false,false);?>
          <?php }?>
       	  </span>
       	   <?php }?>
          <span class="number">
          <?php if ($rownum == 20){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_1_over.gif':'number_1_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],20))),"/favorites/index/20/".$showtype,array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_1.gif':'number_1.gif',array('title'=>sprintf($SCLanguages['page_show_number'],20))),"/favorites/index/20/".$showtype,array(),false,false);?>
          <?php }?>
          </span><span class="number_2">
          <?php if ($rownum == 40){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_2_over.gif':'number_2_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],40))),"/favorites/index/40/".$showtype,array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_2.gif':'number_2.gif',array('title'=>sprintf($SCLanguages['page_show_number'],40))),"/favorites/index/40/".$showtype,array(),false,false);?>
          <?php }?>
          </span><span>
          <?php if ($rownum == 80){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_3_over.gif':'number_3_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],80))),"/favorites/index/80/".$showtype,array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_3.gif':'number_3.gif',array('title'=>sprintf($SCLanguages['page_show_number'],80))),"/favorites/index/80/".$showtype,array(),false,false);?>
          <?php }?>
          <?php if ($rownum == 'all'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_4_over.gif':'number_4_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],'all'))),"/favorites/index/all/".$showtype,array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_4.gif':'number_4.gif',array('title'=>sprintf($SCLanguages['page_show_number'],'all'))),"/favorites/index/all/".$showtype,array(),false,false);?>
          <?php }?>          	  
          	  
          </span>
          
        <span class="Mode"><?php echo $SCLanguages['sort'];?>：</span><span class="Mode_img">
        <?php if ($orderby == 'shop_price DESC'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo01_over_down.gif':'view_ivo01_over_down.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/favorites/index/".$rownum."/".$showtype."/shop_price ASC",array(),false,false);?>
          <?php }else if($orderby == 'shop_price ASC'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo01_over.gif':'view_ivo01_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/favorites/index/".$rownum."/".$showtype."/shop_price DESC",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo01.gif':'view_ivo01.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/favorites/index/".$rownum."/".$showtype."/shop_price DESC",array(),false,false);?>
          <?php }?>
        </span><span>
        <?php if ($orderby == 'sale_stat DESC'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo02_over.gif':'view_ivo02_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/favorites/index/".$rownum."/".$showtype."/sale_stat ASC",array(),false,false);?>
          <?php }else if($orderby == 'sale_stat ASC'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo02_over_up.gif':'view_ivo02_over_up.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/favorites/index/".$rownum."/".$showtype."/sale_stat DESC",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo02.gif':'view_ivo02.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/favorites/index/".$rownum."/".$showtype."/sale_stat DESC",array(),false,false);?>
          <?php }?>
        </span><span>
        <?php if ($orderby == 'modified DESC'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo03_over.gif':'view_ivo03_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/favorites/index/".$rownum."/".$showtype."/modified ASC",array(),false,false);?>
          <?php }else if($orderby == 'modified ASC'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo03_over_up.gif':'view_ivo03_over_up.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/favorites/index/".$rownum."/".$showtype."/modified DESC",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo03.gif':'view_ivo03.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/favorites/index/".$rownum."/".$showtype."/modified DESC",array(),false,false);?>
          <?php }?>
        </span>
        <span class="select_view">&nbsp;</span>
    </p>
<?php }else{?>
        <div class="not">
		<br /><br /><br />
		<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array("alt"=>""))?><strong><?php echo $SCLanguages['not_favorite_goods'];?></strong>
		<br />
		</div>
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
        <div id="Item_box" <?php if((sizeof($fav_products)-1) == $k){?>style="border:none;"<?php }?>>
        	<div class="Item_info">
                <p class="pic">            
					<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['use_sku'],$server_host,$cart_webroot),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$server_host.$cart_webroot);?>
			    </p>
                <p class="info">
                	<span class="item_name">
			<?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku'],$server_host,$cart_webroot),array("target"=>"_blank"),false,false);?>
            </span>
                </p>
            </div>
            <div class="mart">
            <span class="Products_Price">&nbsp;
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
			<strike><?//php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>
			
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Product']['market_price'],$this->data['configs']['price_format']);?>	
			<?php }?>				
				
			</strike>	
<?php }?>
            </span>
                
            </div>
            <div class="good_price">
                <span class="goodprice">
<?//php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
				
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Product']['shop_price'],$this->data['configs']['price_format']);?>	
			<?php }?>				
				
               	</span>
            </div>
            <div class="btn_list collection_btn">
            	<a href="javascript:buy_now(<?php echo $v['Product']['id']?>,1)"><span style="padding:0;margin-top:0;margin-right:3px;"><?php echo $SCLanguages['purchase'];?></span></a>
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
		<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['use_sku'],$server_host,$cart_webroot),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$server_host.$cart_webroot);?>
		</p>
	<p class="info">
	<span class="name">
			<?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku'],$server_host,$cart_webroot),array("target"=>"_blank"),false,false);?>
		</span>
	<span class="Price" ><strike>
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
	<?php echo $SCLanguages['market_price'];?>：
<?php }?>
		<font  color="#ff0000">
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<?//php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Product']['market_price'],$this->data['configs']['price_format']);?>	
			<?php }?>	
	
<?php }?>
		</font></strike></span>
	<span class="Price"><?php echo $SCLanguages['our_price'];?>：<font color="#ff0000">
<?//php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>
			
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Product']['shop_price'],$this->data['configs']['price_format']);?>	
			<?php }?>			
			
				
		</font></span>
	<span class="stow"><?php echo $html->link($SCLanguages['delete'],"javascript:del_fav_products(".$v['Product']['id'].",'$user_id','p')",array(),false,false)?>|<?php echo $html->link($SCLanguages['purchase'],"javascript:buy_now({$v['Product']['id']},1)","",false,false)?></span>
	</p>
	</li>
	<?php }?>
	<?php }?>
		
	</ul>
</div>

          <?php }elseif($showtype == 'T'){?>
          <?php if(isset($fav_products) && sizeof($fav_products)>0){?>
        <div class="collection"><strong>
        	<span class="nonts">&nbsp;</span>
            <span class="Mart_prices">
		  &nbsp;<?php if( isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
            <?php echo $SCLanguages['market_price'];?>
          <?php }?>  
            </span>
            <span class="products_prices"><?php echo $SCLanguages['our_price'];?></span>
            <span class="handels"><?php echo $SCLanguages['operation'];?></span>
        </strong></div>          	  	  
          	  	  
          	  	  
            <?php foreach ($fav_products as $k=>$v){?>
            <div id="Item_box" style="padding-bottom:10px;<?php if((sizeof($fav_products)-1) == $k){?>border:none;<?php }?>">
        	<div class="Item_info">
                <p class="info">
                	<span class="" style="margin-top:15px;">
			<?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku'],$server_host,$cart_webroot),array("target"=>"_blank"),false,false);?>
                	</span>
                </p>
            </div>
            <div class="mart" style="margin-top:15px;">
            	<span class=""><strike>
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<?//php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Product']['market_price'],$this->data['configs']['price_format']);?>	
			<?php }?>		
	
<?php }?>
            		</strike></span>
                
            </div>
            <div class="good_price" style="margin-top:15px;">
                <span class="">
<?//php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Product']['shop_price'],$this->data['configs']['price_format']);?>	
			<?php }?>					
				
                </span>
            </div>
            <div class="btn_list collection_btn">
            	<a href="javascript:buy_now(<?php echo $v['Product']['id']?>,1)"><span style="padding:0;margin-top:0;margin-right:3px;"><?php echo $SCLanguages['purchase'];?></span></a>
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
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>

<script>
function del_fav_products(type_id,user_id,type){
    window.location.href= webroot_dir+"favorites/del_products_t/"+type_id+"/"+user_id+"/"+type;
}
</script>
