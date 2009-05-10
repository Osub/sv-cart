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
 * $Id: index.ctp 1273 2009-05-08 16:49:08Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<?=$javascript->link('cart');?>
<div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span>
<p class="address btn_list clear_all">
<?if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>
	<?=$html->link("<span>".$SCLanguages['delete'].$SCLanguages['all'].$SCLanguages['products']."</span>","javascript:del_cart_product();",array("class"=>"amember"),false,false);?>
	<?}?>
	</p>	
	
<b><?php echo $SCLanguages['my_cart'];?></b></h1>
<div id="Products">
<div class="Titles"></div>
<div id="my_cart"><?php echo $this->element('cart_products', array('cache'=>'+0 hour'));?></div>
</div>
<? if(isset($promotion_products) && sizeof($promotion_products)>0) { ?>
<ul class="content_tab">
<li id="one1" class="hover"><span><b style="letter-spacing:1px;"><?=$SCLanguages['promotion'];?><?=$SCLanguages['products'];?></b></span></li>
</ul>
<?=$html->image('protion-top.gif',array('align'=>'absbottom'))?>
<div id="Item_List" class="border_side" style="padding-bottom:5px;">
<ul id="con_one_1" style="height:100%;overflow:hidden;">
<? foreach($promotion_products as $k=>$v) {?>
<li>
<p class="pic">
<?if($v['Product']['img_thumb'] != ""){?>
<?=$html->link($html->image($v['Product']['img_thumb'],array("alt"=>$v['ProductI18n']['name'], "width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),"/products/".$v['Product']['id']."/","",false,false);?> 
<?}else{?>
<?=$html->link($html->image("/img/product_default.jpg",array("alt"=>$v['ProductI18n']['name'], "width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),"/products/".$v['Product']['id']."/","",false,false);?> 
<?}?>
</p>
<p class="info">
<span class="name carts"><?=$html->link($v['ProductI18n']['name'],"/products/".$v['Product']['id']."/");?></span>
<span class="Price"><?=$SCLanguages['our_price'];?>：<font color="#ff0000">
        <?if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0 && isset($_SESSION['User']['User'])){?>	
		<?=$svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
		<?}else{?>
		<?=$svshow->price_format($v['Product']['promotion_price'],$SVConfigs['price_format']);?>	
		<?}?>
	</font></span>
<span class="stow cart"><?=$html->link(__($SCLanguages['put_into_cart'],array("alt"=>$SCLanguages['put_into_cart'])),"javascript:buy_on_cart_page('product',".$v['Product']['id'].")");?></span>
</p>
</li>
<?}?> 
</ul>
</div>
<?=$html->image('protion-bottom.gif',array('align'=>'texttop'))?>
<?}?>
<!-- 购物车没商品不显示 -->
<div id="show_package">
<?php echo $this->element('show_packaging', array('cache'=>'+0 hour'));?></div>
<!--   package   end     -->
<!--   card   begin     -->
<div id="show_card">
<?php echo $this->element('show_card', array('cache'=>'+0 hour'));?></div>
<!--   card  end    -->

<div id="buyshop_btn">
<p>
<?=$html->link("<span>".$SCLanguages['continue'].$SCLanguages['buy']."</span>","/",array("class"=>"last-shop"),false,false);?>
<?if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>
<?=$html->link("<span>".$SCLanguages['checkout']."<font face='宋体'>>></font></span>","/carts/checkout",array("class"=>"checkout"),false,false);?>

<?}?>
</p></div>
</div>
