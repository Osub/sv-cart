<?php 
/*****************************************************************************
 * SV-Cart 购物车页商品
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: cart_products.ctp 3123 2009-07-21 02:23:49Z huangbo $
*****************************************************************************/
?>
<?php //pr($svcart); ?>
<div class="my_cart">

<?php if(isset($svcart['products'])){?>
<h3><span><?php echo $SCLanguages['cart'].$SCLanguages['products'].$SCLanguages['list'];?></span></h3>
<ul class="table_row">
<li class="name"><strong><?php echo $SCLanguages['products'].$SCLanguages['apellation'];?></strong></li>
<li class="thumb"><strong><?php echo $SCLanguages['products'].$SCLanguages['graph'];?></strong></li>
<li class="price"><strong><?php echo $SCLanguages['purchase'].$SCLanguages['price'];?></strong></li>
<li class="number"><strong><?php echo $SCLanguages['purchase'].$SCLanguages['quantity'];?></strong></li>
<li class="subtotal"><strong><?php echo $SCLanguages['subtotal'];?></strong></li>
<li class="handle"><strong><?php echo $SCLanguages['operation'];?></strong></li>
</ul>
<?php }?>
<?php echo $form->create('carts',array('action'=>'update_num','name'=>'update_num','type'=>'POST'));?>
<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>
<?php foreach($svcart['products'] as $i=>$p){?>
<ul class="table_row table_cell" onmouseover="this.className='table_over table_row table_cell'" onmouseout="this.className='table_row table_cell'">
	<li class="name"><p><?php if(isset($p['ProductI18n']['name'])){?>
<?php
if(isset($p['attributes']) && $p['attributes'] != ""){
	$p_name = $p['ProductI18n']['name']." (".$p['attributes']." )";
}else{
	$p_name = $p['ProductI18n']['name'];
}?>
<?php echo $html->link($p_name,$svshow->sku_product_link($i,$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?>
<?php }?>
</p></li>
<li class="thumb"><?php if($p['Product']['img_thumb'] != ""){?>
<?php echo $html->link($html->image($p['Product']['img_thumb'],array("width"=>108,"height"=>108)),$svshow->sku_product_link($i,$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),"",false,false);?>
<?php }else{?>
<?php echo $html->link($html->image("/img/product_default.jpg",array("width"=>108,"height"=>108)),$svshow->sku_product_link($i,$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),"",false,false);?>	
<?php }?></li>
<li class="price"><?php if(isset($p['is_promotion'])){?>
<?php if($p['is_promotion'] == 1){ ?>
<?php echo $svshow->price_format($p['Product']['promotion_price'],$SVConfigs['price_format']);?>	
<?php }else{ ?>
<?php echo $svshow->price_format($p['Product']['shop_price'],$SVConfigs['price_format']);?>	
	<?php } ?>
<?php }?>
</li>
<li class="number">
<span class="Number"><input type="text" name="product_num[<?php echo $i?>]" value="<?php echo $p['quantity']?>" style="width:34px;" /></span></li>
<li class="subtotal"><?php echo $svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?></li>
<li class="handle"><?php echo $html->link("<span>".$SCLanguages['delete']."</span>","/carts/act_remove/product/".$i,"",false,false)?>
	<?php if(isset($_SESSION['User'])){?><?php echo $html->link("<span>".$SCLanguages['favorite']."</span>",$server_host.$user_webroot."favorites/add/p/".$i,"",false,false)?><?php }?>
	</li>
</ul>
<?php }?>
<?php $st = 'ok';}?>

<?php if(empty($st)){?>
<br/><br/>
<?php echo "<p class='not'>"?>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array('alt'=>''))?>
<?php 
echo "<strong>".$SCLanguages['no_products_in_cart']."</strong></p><br /><br /><br />";
}else{ ?>
<div class="order_total">
<div class="total float_left">
<span><strong><?php echo $SCLanguages['products'].$SCLanguages['total_amount'];?>:</strong><font  class="font_red"><?php echo $svshow->price_format($svcart['cart_info']['sum_subtotal'],$SVConfigs['price_format']);?></font></span>，
<span><strong><?php echo $SCLanguages['products'].$SCLanguages['total_weight'];?>:</strong><font class="font_red"><?php if(isset($svcart['cart_info']['sum_weight'])&&($svcart['cart_info']['sum_weight']>0)){?>
<?php echo $svcart['cart_info']['sum_weight'];?><?php } ?></font></span>
</div>
<div class="continue float_right">
<span class="submit"><?php echo $html->link($SCLanguages['mmodify'].$SCLanguages['cart'],"javascript:document.forms['update_num'].submit();",array(),false,false);?></span>
<?php echo $form->end();?>
<?php echo $form->create('carts',array('action'=>'/consignee/','name'=>'cart_info','type'=>'POST'));?>
<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>
<span class="submit"><?php echo $html->link($SCLanguages['checkout'],"javascript:to_checkout();",array(),false,false);?></span>
<?php }?>
<p><span  class="tobuy"><?php echo $html->link($SCLanguages['continue'].$SCLanguages['buy'],"/",array(),false,false);?></span></p>
</div>
</div>
<?php }?>

<?php echo $form->end();?>
</div>

