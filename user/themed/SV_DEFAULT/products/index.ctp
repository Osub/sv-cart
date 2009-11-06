<?php 
/*****************************************************************************
 * SV-Cart 已购买商品信息
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
<?php echo $this->element('ur_here',array('cache'=>'+0 hour'))?>
<div id="Products_box">
<h1 class="headers"><span class="l">&nbsp;</span><span class="r">&nbsp;</span><?php echo $SCLanguages['purchased_products']?></h1>
      <div class="infos">
      <?php if(isset($my_orders_products) && sizeof($my_orders_products)>0){?>
        <p class="View_item">
       	  <span class="view"><?php echo $SCLanguages['show'];?>：</span>
       	  <?php if(isset($SVConfigs['show_L']) &&  $SVConfigs['show_L'] == 1){?>
       	  <span class="View_img">
       	  <?php if ($showtype == 'L'){?>
       	  <!--$SCLanguages['product_list_type']-->
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'btn_display_mode_list_act_over.gif':'btn_display_mode_list_act_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products']))),"/products/index/".$rownum."/L",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'btn_display_mode_list_act.gif':'btn_display_mode_list_act.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products']))),"/products/index/".$rownum."/L",array(),false,false);?>
          <?php }?>
       	  </span> <?php }?><?php if(isset($SVConfigs['show_G']) &&  $SVConfigs['show_G'] == 1){?>
		  <span class="View_img">
       	  <?php if ($showtype == 'G'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'btn_display_mode_grid_over.gif':'btn_display_mode_grid_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['graph']))),"/products/index/".$rownum."/G",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'btn_display_mode_grid.gif':'btn_display_mode_grid.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['graph']))),"/products/index/".$rownum."/G",array(),false,false);?>
          <?php }?>
       	  </span><?php }?><?php if(isset($SVConfigs['show_T']) &&  $SVConfigs['show_T'] == 1){?><span class="View_img">
       	  <?php if ($showtype == 'T'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'btn_display_mode_text_over.gif':'btn_display_mode_text_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['characters']))),"/products/index/".$rownum."/T",array(),false,false);?>     	  
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'btn_display_mode_text.gif':'btn_display_mode_text.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['characters']))),"/products/index/".$rownum."/T",array(),false,false);?>     	  
          <?php }?>
       	  </span>
       	  <?php }?>
          <span class="number">
          <?php if ($rownum == 20){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_1_over.gif':'number_1_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],20))),"/products/index/20/".$showtype,array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_1.gif':'number_1.gif',array('title'=>sprintf($SCLanguages['page_show_number'],20))),"/products/index/20/".$showtype,array(),false,false);?>
          <?php }?>
          </span>
          <span class="number_2">
          <?php if ($rownum == 40){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_2_over.gif':'number_2_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],40))),"/products/index/40/".$showtype,array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_2.gif':'number_2.gif',array('title'=>sprintf($SCLanguages['page_show_number'],40))),"/products/index/40/".$showtype,array(),false,false);?>
          <?php }?>
          </span><span>
          <?php if ($rownum == 80){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_3_over.gif':'number_3_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],80))),"/products/index/80/".$showtype,array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_3.gif':'number_3.gif',array('title'=>sprintf($SCLanguages['page_show_number'],80))),"/products/index/80/".$showtype,array(),false,false);?>
          <?php }?>
          </span>
	  	  <span>
          <?php if ($rownum == 'all'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_4_over.gif':'number_4_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],'all'))),"/products/index/all/".$showtype,array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'number_4.gif':'number_4.gif',array('title'=>sprintf($SCLanguages['page_show_number'],'all'))),"/products/index/all/".$showtype,array(),false,false);?>
          <?php }?>
          </span>          	  
          	  
          
          
<span class="Mode"><?php echo $SCLanguages['sort'];?>：</span><span class="Mode_img">
        <?php if ($orderby == 'shop_price DESC'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo01_over_down.gif':'view_ivo01_over_down.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/products/index/".$rownum."/".$showtype."/shop_price ASC",array(),false,false);?>
          <?php }else if($orderby == 'shop_price ASC'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo01_over.gif':'view_ivo01_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/products/index/".$rownum."/".$showtype."/shop_price DESC",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo01.gif':'view_ivo01.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/products/index/".$rownum."/".$showtype."/shop_price DESC",array(),false,false);?>
          <?php }?>
        </span><span>
        <?php if ($orderby == 'sale_stat DESC'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo02_over.gif':'view_ivo02_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/products/index/".$rownum."/".$showtype."/sale_stat ASC",array(),false,false);?>
          <?php }else if($orderby == 'sale_stat ASC'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo02_over_up.gif':'view_ivo02_over_up.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/products/index/".$rownum."/".$showtype."/sale_stat DESC",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo02.gif':'view_ivo02.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/products/index/".$rownum."/".$showtype."/sale_stat DESC",array(),false,false);?>
          <?php }?>
        </span><span>
        <?php if ($orderby == 'modified DESC'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo03_over.gif':'view_ivo03_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/products/index/".$rownum."/".$showtype."/modified ASC",array(),false,false);?>
          <?php }else if($orderby == 'modified ASC'){?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo03_over_up.gif':'view_ivo03_over_up.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/products/index/".$rownum."/".$showtype."/modified DESC",array(),false,false);?>
          <?php }else{?>
       	  <?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'view_ivo03.gif':'view_ivo03.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/products/index/".$rownum."/".$showtype."/modified DESC",array(),false,false);?>
          <?php }?>
        </span>
        <span class="select_view"></span>
    </p>
    <?php }else{?>
	<div class="not">
	<br /><br /><br /><br />
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('align'=>'middle','style'=>'margin-right:15px;margin-top:-10px;'))?><strong><?php echo $SCLanguages['buy_nothing'];?></strong>
	<br /><br />
	</div>    		
    		
  		<?}?>
  <?php if ($showtype == 'L'){?>
      <?php if(isset($my_orders_products) && sizeof($my_orders_products)>0){?>
  <ul class="buy_products_title"><li class="sum">&nbsp;</li><li class="number"><?php echo $SCLanguages['order_code']?></li><li class="time"><?php echo $SCLanguages['purchase'].$SCLanguages['time']?></li><li class="many"><?php echo $SCLanguages['purchase'].$SCLanguages['amount']?></li><li class="handel"><?php echo $SCLanguages['operation']?></li></ul>
            <br/>
      <?php foreach($my_orders_products as $k=>$v){?>
            <ul class="buy_products_title products_list"<?php if((sizeof($my_orders_products)-1) == $k){?>style="border:none;"<?php }?>>
				<li class="sum">
				<p class="pic">
					<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['use_sku'],$server_host,$cart_webroot),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$server_host.$cart_webroot);?>
				</p>
				<p class="cat_name">
		<?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku'],$server_host,$cart_webroot),array("target"=>"_blank"),false,false);?>				
			<?php if(isset($v['Category']) && isset($v['CategoryI18n'])){?>
		<?php echo $html->link($v['CategoryI18n']['name'],$server_host.$cart_webroot."categories/".$v['Category']['id'],array(),false,false);?>				
		<?php }?><?php if(isset($v['Brand']) && isset($v['BrandI18n'])){?>
		<?php echo $html->link($v['BrandI18n']['name'],$server_host.$cart_webroot."brands/".$v['Brand']['id'],array(),false,false);?>				
		<?php }?></p>
				</li>
				<li class="number"><?php echo $v['OrderProduct']['order_code']?></li>
				<li class="time"><?php echo $v['OrderProduct']['created']?></li>
				<li class="many">
					<?//php echo $svshow->price_format($v['OrderProduct']['product_price'],$SVConfigs['price_format']);?>
	
				<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
					<?php echo $svshow->price_format($v['OrderProduct']['product_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
				<?php }else{?>
					<?php echo $svshow->price_format($v['OrderProduct']['product_price'],$this->data['configs']['price_format']);?>	
				<?php }?>					
					
					</li>
				<li class="handel btn_list">
				<?php echo $html->link("<span>".$SCLanguages['view'].$SCLanguages['order']."</span>","../orders/".$v['OrderProduct']['order_code'],array(),false,false);?>				
				<?php echo $html->link("<span>".$SCLanguages['view'].$SCLanguages['products']."</span>",$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku'],$server_host,$cart_webroot),array(),false,false);?>				
				<a href="javascript:buy_now(<?php echo $v['Product']['id']?>,1)"><span><?php echo $SCLanguages['purchase_again']?></span></a></li>
			</ul>
	<?php }?>
<?php }else{?>
        	<div class="not">
		<br />
		<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array("alt"=>""))?><strong><?php echo $SCLanguages['not_buy_goods']?></strong><br /><br /></div>
<?php }?>		
<?php }elseif($showtype == 'G'){?>
<div id="Item_List" style="border:0;width:auto;height:100%;" >
    <?php if(isset($my_orders_products) && sizeof($my_orders_products)>0){?>
    <!--商品列表图排式-->
    <?php foreach($my_orders_products as $k=>$v){ ?>
    <?php if($k==0){?><ul class="breviary"><?php }?>
	<li>
   	  <p class="pic">
			<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['use_sku'],$server_host,$cart_webroot),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$server_host.$cart_webroot);?>
   	    </p>
        <p class="info">
        	<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku'],$server_host,$cart_webroot),array("target"=>"_blank"),false,false);?></span>
        	<span class="Price"><?php echo $SCLanguages['current_price']?>：<font color="#ff0000">
<?//php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
				<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
					<?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
				<?php }else{?>
					<?php echo $svshow->price_format($v['Product']['shop_price'],$this->data['configs']['price_format']);?>	
				<?php }?>				
			
        		</font></span>
            <span class="Mart_Price"><strike>
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<?php echo $SCLanguages['original_price']?>：
<?//php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Product']['market_price'],$this->data['configs']['price_format']);?>	
			<?php }?>		
	
<?php }?></strike></span>
            <span class="stow">
			<?php echo $html->link($SCLanguages['view'].$SCLanguages['order'],"../orders/".$v['OrderProduct']['order_code'],array(),false,false);?>|<?php echo $html->link($SCLanguages['view'].$SCLanguages['products'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku'],$server_host,$cart_webroot),array(),false,false);?>
           	<br /><a href="javascript:buy_now(<?php echo $v['Product']['id']?>,1,'P')"><?php echo $SCLanguages['purchase_again']?></a>
           	</span></p>
    </li>
<?php  if( $k%5==4 && $k<sizeof($my_orders_products)-1 ){?>
	<?php if($k == 0){?>
	<?php }else{?>
	</ul>
	<ul>
	<?php }?>
	<?php }else if($k==sizeof($my_orders_products)-1){?>
	</ul><?php }else{?><?php }?>
    <?php }?>
    <!--商品列表文字排式End-->
    <?php }?>
    </div>
<?php }elseif($showtype == 'T'){?>
<?php if(isset($my_orders_products) && sizeof($my_orders_products)>0){?>
<ul class="buy_products_title"><strong>
	<li class="sum" style="width:274px">&nbsp;</li>
	<li class="number"><?php echo $SCLanguages['order_code']?></li>
	<li class="time">
<?php if( isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
	<?php echo $SCLanguages['market_price']?>
<?php }?>
	</li>
	<li class="many"><?php echo $SCLanguages['our_price']?></li>
	<li class="handel" style="width:160px"><?php echo $SCLanguages['operation']?></li></strong>
</ul>

<!--商品列表文字排式-->
<?php foreach($my_orders_products as $k=>$v){ ?>
<ul class="buy_products_title products_text" <?php if((sizeof($my_orders_products)-1) == $k){?>style="border:none;"<?php }?>>
    	<li class="sum" style="width:274px">
        	<p class="pic">
			<span class="name"><b><?php echo $html->link( $v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku'],$server_host,$cart_webroot),array("target"=>"_blank"),false,false);?></b>
				<?php if(isset($v['Brand']) && isset($v['BrandI18n'])){?><?php echo $html->link($v['BrandI18n']['name'],"/brands/{$v['BrandI18n']['brand_id']}","",false,false);?><?php }?> | <?php if(isset($v['Category']) && isset($v['CategoryI18n'])){?>
					<?php echo $html->link($v['CategoryI18n']['name'],"/categories/".$v['Category']['id'],array(),false,false);?>						
						<?php }?></span>
		</p></li>
				<li class="number"><?php echo $v['OrderProduct']['order_code']?></li>
				<li class="time">
<?php if($v['Product']['market_price'] > $v['Product']['shop_price'] && isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<strike>
	<?//php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Product']['market_price'],$this->data['configs']['price_format']);?>	
			<?php }?>	
	
	
</strike>
<?php }?>&nbsp;</li>
				
				<li class="many"><font color="#ff0000">
					<?//php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>
					
					<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
						<?php echo $svshow->price_format($v['Product']['shop_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
					<?php }else{?>
						<?php echo $svshow->price_format($v['Product']['shop_price'],$this->data['configs']['price_format']);?>	
					<?php }?>				
				
				</font></li>
				
				<li class="" style="width:160px">
				<?php echo $html->link($SCLanguages['view'].$SCLanguages['order'],"../orders/".$v['OrderProduct']['order_code'],array(),false,false);?>
|<?php echo $html->link($SCLanguages['view'].$SCLanguages['products'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array(),false,false);?>|<a href="javascript:buy_now(<?php echo $v['Product']['id']?>,1,'P')"><?php echo $SCLanguages['purchase_again']?></a></li>
    
    </ul>
<?php }?><?php }?>
<!--商品列表文字排式End-->
<?php }?>
        </div>
  </div>
  <?php if(!empty($my_orders_products)){?>
<div id="pager">
<span class="totally"><?php printf($SCLanguages['totally_buy_records'],$total)?></span>
		<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
  <?php }?>


<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
