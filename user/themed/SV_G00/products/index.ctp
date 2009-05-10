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
 * $Id: index.ctp 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here',array('cache'=>'+0 hour'))?>

<div id="Products_box">
    	<h1><span><?=$SCLanguages['purchased_products']?></span></h1>
        <div id="infos" style="width:739px;">
      <?if(isset($my_orders_products) && sizeof($my_orders_products)>0){?>
        <p class="View_item">
       	  <span class="view"><?=$SCLanguages['display_mode'];?>：</span>
       	  <?if(isset($SVConfigs['show_L']) &&  $SVConfigs['show_L'] == 1){?>
       	  <span class="View_img">
       	  <?if ($showtype == 'L'){?>
       	  <!--$SCLanguages['product_list_type']-->
       	  <?=$html->link($html->image('btn_display_mode_list_act_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products']))),"/products/index/".$rownum."/L",array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('btn_display_mode_list_act.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products']))),"/products/index/".$rownum."/L",array(),false,false);?>
          <?}?>
       	  </span> <?}?><?if(isset($SVConfigs['show_G']) &&  $SVConfigs['show_G'] == 1){?>
		  <span class="View_img">
       	  <?if ($showtype == 'G'){?>
       	  <?=$html->link($html->image('btn_display_mode_grid_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['graph']))),"/products/index/".$rownum."/G",array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('btn_display_mode_grid.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['graph']))),"/products/index/".$rownum."/G",array(),false,false);?>
          <?}?>
       	  </span><?}?><?if(isset($SVConfigs['show_T']) &&  $SVConfigs['show_T'] == 1){?><span class="View_img">
       	  <?if ($showtype == 'T'){?>
       	  <?=$html->link($html->image('btn_display_mode_text_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['characters']))),"/products/index/".$rownum."/T",array(),false,false);?>     	  
          <?}else{?>
       	  <?=$html->link($html->image('btn_display_mode_text.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['products'].$SCLanguages['list'].$SCLanguages['characters']))),"/products/index/".$rownum."/T",array(),false,false);?>     	  
          <?}?>
       	  </span>
       	  <?}?>
          <span class="number">
          <?if ($rownum == 20){?>
       	  <?=$html->link($html->image('number_1_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],20))),"/products/index/20/".$showtype,array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('number_1.gif',array('title'=>sprintf($SCLanguages['page_show_number'],20))),"/products/index/20/".$showtype,array(),false,false);?>
          <?}?>
          </span><span class="number_2">
          <?if ($rownum == 40){?>
       	  <?=$html->link($html->image('number_2_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],40))),"/products/index/40/".$showtype,array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('number_2.gif',array('title'=>sprintf($SCLanguages['page_show_number'],40))),"/products/index/40/".$showtype,array(),false,false);?>
          <?}?>
          </span><span>
          <?if ($rownum == 80){?>
       	  <?=$html->link($html->image('number_3_over.gif',array('title'=>sprintf($SCLanguages['page_show_number'],80))),"/products/index/80/".$showtype,array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('number_3.gif',array('title'=>sprintf($SCLanguages['page_show_number'],80))),"/products/index/80/".$showtype,array(),false,false);?>
          <?}?>
          </span>
          
          
<span class="Mode"><?=$SCLanguages['sort_by'];?>：</span><span class="Mode_img">
        <?if ($orderby == 'shop_price DESC'){?>
       	  <?=$html->link($html->image('view_ivo01_over_down.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/products/index/".$rownum."/".$showtype."/shop_price ASC",array(),false,false);?>
          <?}else if($orderby == 'shop_price ASC'){?>
       	  <?=$html->link($html->image('view_ivo01_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/products/index/".$rownum."/".$showtype."/shop_price DESC",array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('view_ivo01.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['market_price']))),"/products/index/".$rownum."/".$showtype."/shop_price DESC",array(),false,false);?>
          <?}?>
        </span><span>
        <?if ($orderby == 'sale_stat DESC'){?>
       	  <?=$html->link($html->image('view_ivo02_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/products/index/".$rownum."/".$showtype."/sale_stat ASC",array(),false,false);?>
          <?}else if($orderby == 'sale_stat ASC'){?>
       	  <?=$html->link($html->image('view_ivo02_over_up.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/products/index/".$rownum."/".$showtype."/sale_stat DESC",array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('view_ivo02.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['sales']))),"/products/index/".$rownum."/".$showtype."/sale_stat DESC",array(),false,false);?>
          <?}?>
        </span><span>
        <?if ($orderby == 'modified DESC'){?>
       	  <?=$html->link($html->image('view_ivo03_over.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/products/index/".$rownum."/".$showtype."/modified ASC",array(),false,false);?>
          <?}else if($orderby == 'modified ASC'){?>
       	  <?=$html->link($html->image('view_ivo03_over_up.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/products/index/".$rownum."/".$showtype."/modified DESC",array(),false,false);?>
          <?}else{?>
       	  <?=$html->link($html->image('view_ivo03.gif',array('title'=>sprintf($SCLanguages['order_by'],$SCLanguages['time']))),"/products/index/".$rownum."/".$showtype."/modified DESC",array(),false,false);?>
          <?}?>
        </span>
        <span class="select_view"></span>
    </p>
        	<?}?>
  <?if ($showtype == 'L'){?>
      <?if(isset($my_orders_products) && sizeof($my_orders_products)>0){?>
  <ul class="buy_products_title"><li class="sum">&nbsp;</li><li class="number"><?=$SCLanguages['order_code']?></li><li class="time"><?=$SCLanguages['purchase'].$SCLanguages['time']?></li><li class="many"><?=$SCLanguages['purchase'].$SCLanguages['amount']?></li><li class="handel"><?=$SCLanguages['operation']?></li></ul>
            <br/>
      <?foreach($my_orders_products as $k=>$v){?>
            <ul class="buy_products_title products_list">
				<li class="sum">
				<p class="pic">
			<?if($v['Product']['img_thumb'] != ""){?>
       	  <?=$html->link($html->image("/../".$v['Product']['img_thumb'],array("width"=>"108","height"=>"108")),"/../products/".$v['Product']['id'],array(),false,false);?>
			<?}else{?>
       	  <?=$html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),"/../products/".$v['Product']['id'],array(),false,false);?>
			 <?}?>
				</p>
				<p class="cat_name">
		<?=$html->link($v['ProductI18n']['name'],"/../products/".$v['Product']['id'],array(),false,false);?>				
			<?if(isset($v['Category']) && isset($v['CategoryI18n'])){?>
		<?=$html->link($v['CategoryI18n']['name'],"/../categories/".$v['Category']['id'],array(),false,false);?>				
		<?}?><?if(isset($v['Brand']) && isset($v['BrandI18n'])){?>
		<?=$html->link($v['BrandI18n']['name'],"/../brands/".$v['Brand']['id'],array(),false,false);?>				
		<?}?></p>
				</li>
				<li class="number"><?echo $v['OrderProduct']['order_id']?></li>
				<li class="time"><?echo $v['OrderProduct']['created']?></li>
				<li class="many">
<?=$svshow->price_format($v['OrderProduct']['product_price'],$SVConfigs['price_format']);?>	
					</li>
				<li class="handel btn_list">
				<?=$html->link("<span>".$SCLanguages['view'].$SCLanguages['order']."</span>","../orders/".$v['OrderProduct']['order_id'],array(),false,false);?>				
				<?=$html->link("<span>".$SCLanguages['view'].$SCLanguages['products']."</span>","/../products/".$v['Product']['id'],array(),false,false);?>				
				<a href="javascript:buy_now(<?echo $v['Product']['id']?>,1)"><span><?=$SCLanguages['purchase_again']?></span></a></li>
			</ul>
	<?}?>
<?}else{?>
        	<div class="not">
		<br />
		<?=$html->image("warning_img.gif",array("alt"=>""))?><strong>没有购买任何商品</strong><br /><br /></div>
<?}?>		
<?}elseif($showtype == 'G'){?>
<div id="Item_List" style="border:0;width:auto;height:100%;" >
        <!--商品列表图排式-->
        <ul class="breviary">
      <?if(isset($my_orders_products) && sizeof($my_orders_products)>0){?>
      <? foreach($my_orders_products as $k=>$v){ ?>
	<li>
   	  <p class="pic">
			<?if($v['Product']['img_thumb'] != ""){?>
       	  <?=$html->link($html->image("/../".$v['Product']['img_thumb'],array("width"=>"108","height"=>"108")),"/../products/".$v['Product']['id'],array(),false,false);?>
			<?}else{?>
       	  <?=$html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),"/../products/".$v['Product']['id'],array(),false,false);?>
			 <?}?>
   	    </p>
        <p class="info">
        	<span class="name"><?php echo $html->link( $v['ProductI18n']['name'],"/products/{$v['Product']['id']}","",false,false);?></span>
        	<span class="Price"><?=$SCLanguages['current_price']?>：<font color="#ff0000">
<?=$svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
        		</font></span>
            <span class="Mart_Price"><?=$SCLanguages['original_price']?>：
<?=$svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
            	</span>
            <span class="stow">
			<?=$html->link($SCLanguages['view'].$SCLanguages['order'],"../orders/".$v['OrderProduct']['order_id'],array(),false,false);?>
			|
			<?=$html->link($SCLanguages['view'].$SCLanguages['products'],"/../products/".$v['Product']['id'],array(),false,false);?>
           	|
           	<a href="javascript:buy_now(<? echo $v['Product']['id']?>,1,'P')"><?=$SCLanguages['purchase_again']?></a>
           	</span></p>
    </li>
    <?}?><?}?>
    </ul><!--商品列表文字排式End-->
    </div>
<?}elseif($showtype == 'T'){?>
<?if(isset($my_orders_products) && sizeof($my_orders_products)>0){?>
<ul class="buy_products_title"><li class="sum" style="width:274px">&nbsp;</li><li class="number"><?=$SCLanguages['order_code']?></li><li class="time"><?=$SCLanguages['market_price']?></li><li class="many"><?=$SCLanguages['our_price']?></li><li class="handel" style="width:160px"><?=$SCLanguages['operation']?></li></ul>
            <br/>
<!--商品列表文字排式-->
<? foreach($my_orders_products as $k=>$v){ ?>
<ul class="buy_products_title products_text">
      
    	<li class="sum" style="width:274px">
        	<p class="pic">
			<span class="name"><b><?php echo $html->link( $v['ProductI18n']['name'],"/products/{$v['Product']['id']}","",false,false);?></b>
				<?if(isset($v['Brand']) && isset($v['BrandI18n'])){?><?php echo $html->link($v['BrandI18n']['name'],"/brands/{$v['BrandI18n']['brand_id']}","",false,false);?><?}?> | <?if(isset($v['Category']) && isset($v['CategoryI18n'])){?>
					<?=$html->link($v['CategoryI18n']['name'],"/categories/".$v['Category']['id'],array(),false,false);?>						
						<?}?></span>
		</p></li>
				<li class="number"><?echo $v['OrderProduct']['order_id']?></li>
				<li class="time">
<?=$svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>	
			</li>
				
				<li class="many"><font color="#ff0000">
<?=$svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
					</font></li>
				
				<li class="" style="width:160px">
							<?=$html->link($SCLanguages['view'].$SCLanguages['order'],"../orders/".$v['OrderProduct']['order_id'],array(),false,false);?>
|<?=$html->link($SCLanguages['view'].$SCLanguages['products'],"/../products/".$v['Product']['id'],array(),false,false);?>|<a href="javascript:buy_now(<? echo $v['Product']['id']?>,1,'P')"><?=$SCLanguages['purchase_again']?></a>
				
				</li>
    
    </ul>
<?}?><?}?>
<!--商品列表文字排式End-->
<?}?>
        </div>
  </div>
  <?if(!empty($my_orders_products)){?>
<div id="pager">
<span class="totally"><?php printf($SCLanguages['totally_buy_records'],$total)?></span>
		<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
  <?}?>


<?php echo $this->element('news',array('cache'=>'+0 hour'))?>