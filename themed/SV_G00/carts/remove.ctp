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
 * $Id: remove.ctp 1232 2009-05-06 12:14:41Z huangbo $
*****************************************************************************/
ob_start();?>
<?if($result['type'] == "product"){?>
<div id="loginout">
<h1 class="hd"><b style="font-size:14px"><?php echo $SCLanguages['delete'].$SCLanguages['products'];?></b></h1>
<div id="buyshop_box">
<div class="shops">
<ul>
<li class="pic">
	<?if(isset($product_info['Product']['img_thumb']) && $product_info['Product']['img_thumb'] != ""){?>
	<?=$html->image($product_info['Product']['img_thumb'],array("alt"=>$product_info['ProductI18n']['name'],"width"=>75,"height"=>75));?>
	<?}else{?>
	<?=$html->image("/img/product_default.jpg",array("alt"=>$product_info['ProductI18n']['name'],"width"=>75,"height"=>75));?>
	<?}?>
</li>
<li>
<p class="name"><? echo $SCLanguages['products'].$SCLanguages['name']."：".$product_info['ProductI18n']['name'];?></p>
<?if($result['type']==1){?><p><?=$result['message'];?></p><?}?>
<?if($result['type']==0){?>
<p class="buy_number"><? echo $SCLanguages['quantity']."：".$product_info['quantity'];?></p>
<p>
	
<?if(isset($product_info['product_rank_price'])){?>
<?=$svshow->price_format($product_info['product_rank_price'],$SVConfigs['price_format']);?>	
<?}else if(isset($product_info['is_promotion'])){?>
<? if($product_info['is_promotion'] == 1){ ?>
<?=$SCLanguages['our_price']?>:
<?=$svshow->price_format($product_info['Product']['promotion_price'],$SVConfigs['price_format']);?>	
<? }else{ ?>
<?=$SCLanguages['our_price']?>:
<?=$svshow->price_format($product_info['Product']['shop_price'],$SVConfigs['price_format']);?>	
	<? }} ?>
</p>
	
<p>
<?if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<?= $SCLanguages['market_price']."：";?>
<?=$svshow->price_format($product_info['Product']['market_price'],$SVConfigs['price_format']);?>	
<br />
<?}?>
<?if($product_info['discount_price'] > 0){?>
<?=$SCLanguages['discount'];?>:<? echo $product_info['discount_rate']."%"; ?></p>
<p><?=$SCLanguages['save_to_market_price'];?>：<?=$svshow->price_format($product_info['discount_price'],$SVConfigs['price_format']);?>	
</p>
<?}else{?>
</p>
<?}?>
<?}?></li>
</ul>
<p class="buy_btn">
<?if($result['type']==0){?>
<?=$html->link($SCLanguages['delete'],"javascript:act_remove_product('product',".$product_info['Product']['id'].")","",false,false);?>
<?=$html->link($SCLanguages['cancel'],"javascript:close_message();","",false,false);?>
<?}else{?>
<?=$html->link($SCLanguages['confirm'],"javascript:close_message();","",false,false);?>
<?}?>
</p>
</div>
<p><?=$html->image("loginout-bottom.png");?></p>
</div></div>
<?}?>

<?if($result['type'] == "packaging"){?>
<div id="loginout">
<h1 class="hd"><b style="font-size:14px"><?php echo $SCLanguages['delete'].$SCLanguages['packaging'];?></b></h1>
<div id="buyshop_box">
<div class="shops">
<ul>
<li class="pic"><?=$html->image($product_info['Packaging']['img01'],array("alt"=>$product_info['PackagingI18n']['name'],"width"=>75,"height"=>75));?></li>
<li>
<p class="name"><? echo $SCLanguages['products'].$SCLanguages['name']."：".$product_info['PackagingI18n']['name'];?></p>
<?if($result['type']==1){?><p><?=$result['message'];?></p><?}?>
<?if($result['type']==0){?>
<p class="buy_number"><? echo $SCLanguages['quantity']."：".$product_info['quantity'];?></p>
<p>
<?=$svshow->price_format($product_info['Packaging']['fee'],$SVConfigs['price_format']);?>	
</p>
<?}?></li>
</ul>
<p class="buy_btn">
<?if($result['type']==0){?>
<?=$html->link($SCLanguages['delete'],"javascript:act_remove_product('packaging',".$product_info['Packaging']['id'].")","",false,false);?>
<?=$html->link($SCLanguages['cancel'],"javascript:close_message();","",false,false);?>
<?}else{?>
<?=$html->link($SCLanguages['confirm'],"javascript:close_message();","",false,false);?>
<?}?>
</p>
</div>
<p><?=$html->image("loginout-bottom.png");?></p>
</div></div>
<?}?>

<?if($result['type'] == "card"){?>
<div id="loginout">
<h1 class="hd"><b style="font-size:14px"><?php echo $SCLanguages['delete'].$SCLanguages['card'];?></b></h1>
<div id="buyshop_box">
<div class="shops">
<ul>
<li class="pic"><?=$html->image($product_info['Card']['img01'],array("alt"=>$product_info['CardI18n']['name'],"width"=>75,"height"=>75));?></li>
<li>
<p class="name"><? echo $SCLanguages['products'].$SCLanguages['name']."：".$product_info['CardI18n']['name'];?></p>
<?if($result['type']==1){?><p><?=$result['message'];?></p><?}?>
<?if($result['type']==0){?>
<p class="buy_number"><? echo $SCLanguages['quantity']."：".$product_info['quantity'];?></p>
<p>
<?=$svshow->price_format($product_info['Card']['fee'],$SVConfigs['price_format']);?>	
	</p>
<?}?></li>
</ul>
<p class="buy_btn">
<?if($result['type']==0){?>
<?=$html->link($SCLanguages['delete'],"javascript:act_remove_product('card',".$product_info['Card']['id'].")","",false,false);?>
<?=$html->link($SCLanguages['cancel'],"javascript:close_message();","",false,false);?>
<?}else{?>
<?=$html->link($SCLanguages['confirm'],"javascript:close_message();","",false,false);?>
<?}?>
</p>
</div>
<p><?=$html->image("loginout-bottom.png");?></p>
</div></div>
<?}?>
<?$result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>