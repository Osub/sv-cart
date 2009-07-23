<?php 
/*****************************************************************************
 * SV-Cart 购物车
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3195 2009-07-22 07:15:51Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<?php echo $javascript->link('cart');?>
<div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span>
<p class="clear_all">
<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>
	<?php echo $html->link("<span>".$SCLanguages['clear_out'].$SCLanguages['cart']."</span>","javascript:del_cart_product();",array("class"=>"amember"),false,false);?>
	<?php }?>
</p>	
<?php echo $SCLanguages['my_cart'];?>
</h1>
<div id="Products">
<div class="Titles"></div>
<div id="my_cart"><?php echo $this->element('cart_products', array('cache'=>'+0 hour'));?></div>
</div>
	
	
<!--促销begin -->
<?php if(isset($svcart['promotion']) || (isset($promotions) && sizeof($promotions)>0)){?>
<div id="Balance_info" style="width:auto;">
<div id="promotions" style="width:auto;">
<?php if(isset($svcart['promotion'])){?>
<?php echo $this->element('checkout_promotion_confirm', array('cache'=>'+0 hour'));?>
<?php }else if(isset($promotions) && count($promotions) > 0){?>
<?php echo $this->element('checkout_promotion', array('cache'=>'+0 hour'));?>
<br/><br/>
<?php }?>
</div>
<div id="promotion_loading" style="display:none;">
<h5 id="address_btn_list"><?php echo $SCLanguages['promotion'].$SCLanguages['activity'];?>:</h5>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align="center">
	
<tr><td class="lan-name first">
<?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?>
</td></tr>
</table>
</div>		
	
</div>
<?php }?>

<!--促销end-->
	
<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>
<!-- 订单备注-->	
<?php echo $form->create('carts',array('action'=>'/checkout','name'=>'cart_info','type'=>'POST'));?>
<div id="Balance_info" style="width:auto;">
	<div id="order_note" style="width:auto;">
	<h5>
	<span id="change_remark" style="display:none"><a href="javascript:change_remark()" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a></span>
	<?php echo $SCLanguages['order'].$SCLanguages['remark'];?>: 
	</h5>
	<?php echo $this->element('checkout_remark', array('cache'=>'+0 hour'));?><br />
	</div>
</div>	
<!-- 订单备注-->	
<?php }?>
	
	
<?php if(isset($promotion_products) && sizeof($promotion_products)>0) { ?>
<!-- PromotionProduct-->
<ul class="content_tab">
<li id="one1" class="hover"><span><b style="letter-spacing:1px;"><?php echo $SCLanguages['promotion'];?><?php echo $SCLanguages['products'];?></b></span></li>
</ul>

<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'protion-top.gif':'protion-top.gif',array('align'=>'absbottom'))?>
<div id="Item_List" class="border_side" style="padding-bottom:5px;">
<ul id="con_one_1" style="height:100%;overflow:hidden;">
<?php foreach($promotion_products as $k=>$v) {?>
<li>
<p class="pic">
<?php if($v['Product']['img_thumb'] != ""){?>
<?php echo $html->link($html->image($v['Product']['img_thumb'],array("alt"=>$v['ProductI18n']['name'], "width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),"",false,false);?> 
<?php }else{?>
<?php echo $html->link($html->image("/img/product_default.jpg",array("alt"=>$v['ProductI18n']['name'], "width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),"",false,false);?> 
<?php }?>
</p>
<p class="info">
<span class="name carts"><?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></span>
<span class="Price"><?php echo $SCLanguages['our_price'];?>：<font color="#ff0000">
        <?php if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0 && isset($_SESSION['User']['User'])){?>	
		<?php echo $svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
		<?php }else{?>
		<?php echo $svshow->price_format($v['Product']['promotion_price'],$SVConfigs['price_format']);?>	
		<?php }?>
	</font></span>
<span class="stow cart"><?php echo $html->link(__($SCLanguages['put_into_cart'],array("alt"=>$SCLanguages['put_into_cart'])),"javascript:buy_on_cart_page('product',".$v['Product']['id'].")");?></span>
</p>
</li>
<?php }?> 
</ul>
</div>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'protion-bottom.gif':'protion-bottom.gif',array('align'=>'texttop'))?>
<!-- PromotionProduct-->
<?php }?>
<!-- 购物车没商品不显示 -->
<div id="show_package">
<?php echo $this->element('show_packaging', array('cache'=>'+0 hour'));?></div>
<!--   package   end     -->
<!--   card   begin     -->
<div id="show_card">
<?php echo $this->element('show_card', array('cache'=>'+0 hour'));?></div>
<!--   card  end    -->

<div id="buyshop_btn">
<?php echo $html->link("<span>".$SCLanguages['continue'].$SCLanguages['buy']."</span>","/",array('class'=>'green_3 last-shop'),false,false);?>

<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>
<?php echo $html->link("<span>".$SCLanguages['checkout']."<font face='宋体'>>></font></span>","javascript:to_checkout();",array("class"=>"checkout"),false,false);?>
<?php }?>
</div>
<?php echo $form->end();?>

</div>
