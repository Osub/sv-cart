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
 * $Id: index.ctp 4333 2009-09-17 10:46:57Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('cart');?>
<div id="Products_box">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<h1 class="headers"><span class="l"></span><span class="r"></span>
<span class="clear_all"><?php if(isset($svcart['products']) && sizeof($svcart['products'])>0){?><?php echo $html->link("<span>".$SCLanguages['clear_out'].$SCLanguages['cart']."</span>","javascript:del_cart_product();",array("class"=>"amember"),false,false);?><?php }?></span>	
<?php echo $SCLanguages['my_cart'];?>
</h1>
<div id="Products">
<div class="height_5">&nbsp;</div>
<div id="my_cart" class="border"><?php echo $this->element('cart_products', array('cache'=>'+0 hour'));?></div>
</div>
	
	
<!--促销begin -->
<?php if(isset($svcart['promotion']) || (isset($promotions) && sizeof($promotions)>0)){?>
<div id="Balance_info" style="width:auto;">
<div id="promotions" style="width:auto;padding:0;">
<?php if(isset($svcart['promotion'])){?>
<?php echo $this->element('checkout_promotion_confirm', array('cache'=>'+0 hour'));?><br />
<?php }else if(isset($promotions) && count($promotions) > 0){?>
<?php echo $this->element('checkout_promotion', array('cache'=>'+0 hour'));?>
<?php }?>
</div>
<div id="promotion_loading" style="display:none;width:auto;">
<h5><?php echo $SCLanguages['promotion'].$SCLanguages['activity'];?>: <?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></h5>
</div>
</div>
<?php }?>

<!--促销end-->
	
<?php echo $form->create('carts',array('action'=>'checkout','name'=>'cart_info','type'=>'POST'));?>
	
	<input type="hidden" name="svcart_theme" value="1" />
<?php if(isset($promotion_products) && sizeof($promotion_products)>0) { ?>
<!-- PromotionProduct-->
<ul class="content_tab">
<li class="hover"><span><b style="letter-spacing:1px;"><?php echo $SCLanguages['promotion'];?><?php echo $SCLanguages['products'];?></b></span></li>
</ul>

<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'protion-top.gif':'protion-top.gif',array("width"=>"100%","height"=>"5"))?>
<div class="Item_List border_side" style="padding-bottom:5px;">
<!--促销-->
<ul style="height:100%;overflow:hidden;">
<?php foreach($promotion_products as $k=>$v) {?>
<li>
<p class="pic">
<?php if($v['Product']['img_thumb'] != ""){?>
<?php echo $html->link($html->image($v['Product']['img_thumb'],array("alt"=>$v['ProductI18n']['name'], "width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['product_link_type']),"",false,false);?> 
<?php }else{?>
<?php echo $html->link($html->image("/img/product_default.jpg",array("alt"=>$v['ProductI18n']['name'], "width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['product_link_type']),"",false,false);?> 
<?php }?>
</p>
<p class="info">
<span class="name carts"><?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['product_link_type']),array("target"=>"_blank"),false,false);?></span>
<span class="Price"><?php echo $SCLanguages['our_price'];?>：<font color="#ff0000">
        <?php if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0 && isset($_SESSION['User']['User'])){?>	
		<?//php echo $svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
			
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format($v['Product']['user_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
		<?php }else{?>
			<?php echo $svshow->price_format($v['Product']['user_price'],$this->data['configs']['price_format']);?>	
		<?php }?>				
			
		<?php }else{?>
			
		<?//php echo $svshow->price_format($v['Product']['promotion_price'],$SVConfigs['price_format']);?>	
			
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format($v['Product']['promotion_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
		<?php }else{?>
			<?php echo $svshow->price_format($v['Product']['promotion_price'],$this->data['configs']['price_format']);?>	
		<?php }?>			
			
		<?php }?>
	</font></span>
<span class="stow cart"><?php echo $html->link(__($SCLanguages['put_into_cart'],array("alt"=>$SCLanguages['put_into_cart'])),"javascript:buy_on_cart_page('product',".$v['Product']['id'].")");?></span>
</p>
</li>
<?php }?> 
</ul>
<!--促销 END-->
</div>

<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'protion-bottom.gif':'protion-bottom.gif',array('alt'=>'',"width"=>"100%","height"=>"5"))?></p>
<?php }?>

<ul class="content_tab">	
<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0 && empty($all_virtual) && isset($packages) && sizeof($packages)>0){
	$sign_tab = 'package';
?>
<li id="one1" onmouseover="overtab('one','1','<?php echo $pack_card_num;?>')" class="hover"><span><b style="letter-spacing:1px;"><?php echo $SCLanguages['packaging'];?></b></span></li>
<?php }?>
<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0 && empty($all_virtual) && isset($cards) && sizeof($cards)>0){?>
<li id="one2" onmouseover="overtab('one','2','<?php echo $pack_card_num;?>')" <?php if(!isset($sign_tab)){ $sign_tab = 'card'; ?>class="hover"<?php }?> ><span><b style="letter-spacing:1px;"><?php echo $SCLanguages['card'];?></b></span></li>	
<?php }?>
</ul>

<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0 && empty($all_virtual) && ((isset($packages) && sizeof($packages)>0) || (isset($cards) && sizeof($cards)>0))){?>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'protion-top.gif':'protion-top.gif',array("width"=>"100%","height"=>"5"))?>
<div class="Item_List border_side" style="padding-bottom:5px;">
<div id="con_one_1" <?php if(isset($sign_tab) && $sign_tab == 'package'){?> class="display" <?php }else{?>class="undisplay"<?php }?>>
<!--包装-->
<div id="show_package"><?php echo $this->element('show_packaging', array('cache'=>'+0 hour'));?></div>
<!--包装 END-->
</div>
<div id="con_one_2" <?php if(isset($sign_tab) && $sign_tab == 'card'){?> class="display" <?php }else{?>class="undisplay"<?php }?>>
<!--   card   begin     -->
<div id="show_card"><?php echo $this->element('show_card', array('cache'=>'+0 hour'));?></div>
<!--   card  end    -->
</div>
	
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'protion-bottom.gif':'protion-bottom.gif',array('alt'=>'',"width"=>"100%","height"=>"5"))?></p>
<?php }?>
<!-- PromotionProduct-->
<!-- 购物车没商品不显示 -->
<!--   package   end     -->

<div id="buyshop_btn">
<?php echo $html->link("<span>".$SCLanguages['continue'].$SCLanguages['buy']."</span>","/",array('class'=>'green_3 last-shop'),false,false);?>

<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>
<?php echo $html->link("<span>".$SCLanguages['check_out']." <font face='宋体'>>></font></span>","javascript:to_checkout();",array("class"=>"checkout"),false,false);?>
<?php }?>
</div>
<?php echo $form->end();?>

</div>
