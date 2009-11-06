<?php 
/*****************************************************************************
 * SV-Cart 删除
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: remove.ctp 3779 2009-08-19 10:40:08Z huangbo $
*****************************************************************************/
ob_start();?>
<?php if($result['type'] == "product"){?>
<div id="loginout" class="loginout">
<h1 class="hd"><b style="font-size:14px"><?php echo $SCLanguages['delete'].$SCLanguages['products'];?></b></h1>
<div id="buyshop_box">
<div class="shops">
<ul>
<li class="pic">
	<?php if(isset($product_info['Product']['img_thumb']) && $product_info['Product']['img_thumb'] != ""){?>
	<?php echo $html->image($product_info['Product']['img_thumb'],array("alt"=>$product_info['ProductI18n']['name'],"width"=>75,"height"=>75));?>
	<?php }else{?>
	<?php echo $html->image("/img/product_default.jpg",array("alt"=>$product_info['ProductI18n']['name'],"width"=>75,"height"=>75));?>
	<?php }?>
</li>
<li>
<p class="name"><?php echo $SCLanguages['products'].$SCLanguages['name']."：".$product_info['ProductI18n']['name'];?></p>
<?php if($result['type']==1){?><p><?php echo $result['message'];?></p><?php }?>
<?php if($result['type']==0){?>
<p class="buy_number"><?php echo $SCLanguages['quantity']."：".$product_info['quantity'];?></p>
<p>
	
<?php if(isset($product_info['product_rank_price'])){?>
<?php echo $svshow->price_format($product_info['product_rank_price'],$SVConfigs['price_format']);?>	
<?php }else if(isset($product_info['is_promotion'])){?>
<?php if($product_info['is_promotion'] == 1){ ?>
<?php echo $SCLanguages['our_price']?>:
<?php echo $svshow->price_format($product_info['Product']['promotion_price'],$SVConfigs['price_format']);?>	
<?php }else{ ?>
<?php echo $SCLanguages['our_price']?>:
<?php echo $svshow->price_format($product_info['Product']['shop_price'],$SVConfigs['price_format']);?>	
	<?php }} ?>
</p>
	
<p>
<?php if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<?php echo  $SCLanguages['market_price']."：";?>
<?php echo $svshow->price_format($product_info['Product']['market_price'],$SVConfigs['price_format']);?>	
<br />
<?php }?>
<?php if($product_info['discount_price'] > 0){?>
<?php echo $SCLanguages['discount'];?>:<?php echo $product_info['discount_rate']."%"; ?></p>
<p><?php echo $SCLanguages['save_to_market_price'];?>：<?php echo $svshow->price_format($product_info['discount_price'],$SVConfigs['price_format']);?>	
</p>
<?php }else{?>
</p>
<?php }?>
<?php }?></li>
</ul>
<p class="buy_btn">
<?php if($result['type']==0){?>
<?php echo $html->link($SCLanguages['delete'],"javascript:act_remove_product('product',".$product_info_id.")","",false,false);?>
<?php echo $html->link($SCLanguages['cancel'],"javascript:close_message();","",false,false);?>
<?php }else{?>
<?php echo $html->link($SCLanguages['confirm'],"javascript:close_message();","",false,false);?>
<?php }?>
</p>
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif");?></p>
</div></div>
<?php }?>

<?php if($result['type'] == "packaging"){?>
<div id="loginout" class="loginout">
<h1 class="hd"><b style="font-size:14px"><?php echo $SCLanguages['delete'].$SCLanguages['packaging'];?></b></h1>
<div id="buyshop_box">
<div class="shops">
<ul>
<li class="pic"><?php echo $html->image((!empty($product_info['Packaging']['img01'])?$product_info['Packaging']['img01']:"/img/product_default.jpg"),array("alt"=>$product_info['PackagingI18n']['name'],"width"=>75,"height"=>75));?></li>
<li>
<p class="name"><?php echo $SCLanguages['products'].$SCLanguages['name']."：".$product_info['PackagingI18n']['name'];?></p>
<?php if($result['type']==1){?><p><?php echo $result['message'];?></p><?php }?>
<?php if($result['type']==0){?>
<p class="buy_number"><?php echo $SCLanguages['quantity']."：".$product_info['quantity'];?></p>
<p>
<?php echo $svshow->price_format($product_info['Packaging']['fee'],$SVConfigs['price_format']);?>	
</p>
<?php }?></li>
</ul>
<p class="buy_btn">
<?php if($result['type']==0){?>
<?php echo $html->link($SCLanguages['delete'],"javascript:act_remove_product('packaging',".$product_info['Packaging']['id'].")","",false,false);?>
<?php echo $html->link($SCLanguages['cancel'],"javascript:close_message();","",false,false);?>
<?php }else{?>
<?php echo $html->link($SCLanguages['confirm'],"javascript:close_message();","",false,false);?>
<?php }?>
</p>
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif");?></p>
</div></div>
<?php }?>

<?php if($result['type'] == "card"){?>
<div id="loginout" class="loginout">
<h1 class="hd"><b style="font-size:14px"><?php echo $SCLanguages['delete'].$SCLanguages['card'];?></b></h1>
<div id="buyshop_box">
<div class="shops">
<ul>
<li class="pic"><?php echo $html->image((!empty($product_info['Card']['img01'])?$product_info['Card']['img01']:"/img/product_default.jpg"),array("alt"=>$product_info['CardI18n']['name'],"width"=>75,"height"=>75));?></li>
<li>
<p class="name"><?php echo $SCLanguages['products'].$SCLanguages['name']."：".$product_info['CardI18n']['name'];?></p>
<?php if($result['type']==1){?><p><?php echo $result['message'];?></p><?php }?>
<?php if($result['type']==0){?>
<p class="buy_number"><?php echo $SCLanguages['quantity']."：".$product_info['quantity'];?></p>
<p>
<?php echo $svshow->price_format($product_info['Card']['fee'],$SVConfigs['price_format']);?>	
	</p>
<?php }?></li>
</ul>
<p class="buy_btn">
<?php if($result['type']==0){?>
<?php echo $html->link($SCLanguages['delete'],"javascript:act_remove_product('card',".$product_info['Card']['id'].")","",false,false);?>
<?php echo $html->link($SCLanguages['cancel'],"javascript:close_message();","",false,false);?>
<?php }else{?>
<?php echo $html->link($SCLanguages['confirm'],"javascript:close_message();","",false,false);?>
<?php }?>
</p>
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif");?></p>
</div></div>
<?php }?>
<?php $result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>