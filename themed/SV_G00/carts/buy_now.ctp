<?php
/*****************************************************************************
 * SV-Cart 购买
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: buy_now.ctp 1902 2009-05-31 13:56:19Z huangbo $
*****************************************************************************/
ob_start();?>
<?if($result['type'] == 5){?>
<div id="loginout">
	<h1><b style="font-size:14px">	<?php echo $SCLanguages['buy'];?></b></h1>
	<div class="border_side">
	<p class="login-alettr">
 	<?=$html->image('icon-10.gif',array("align"=>"middle"));?>
	<b>
	<?php echo $result['message']?></b></p>
		<br/>
		<p class="btns">
			<a href="javascript:close_message();"><?=$html->image('loginout-btn_right.gif');?><?=$SCLanguages['confirm'];?></a>
		</p>
	</div>
	<p><?=$html->image("loginout-bottom.gif",array("align"=>"texttop"))?></p>
</div>
<?}else if($result['type'] == 4){?>
<div id="loginout">
<h1 class="hd"><b>
	<?php echo $SCLanguages['buy'];?>
	</b></h1>
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
<p class="name"><? echo $SCLanguages['products'].$SCLanguages['apellation']."：".$product_info['ProductI18n']['name'];?></p>

<p class="buy_number"><? echo $SCLanguages['quantity']."：".$product_info['quantity'];?></p>
<p>
<?if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] >0){?>
<?=$svshow->price_format($product_info['Product']['market_price'],$SVConfigs['price_format']);?>	

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

<?if(isset($product_info['discount_price']) && $product_info['discount_price'] > 0){?>
<?=$SCLanguages['discount'];?>:<? echo $product_info['discount_rate']."%"; ?></p>
<p><?=$SCLanguages['save_to_market_price'];?>：
<?=$svshow->price_format($product_info['discount_price'],$SVConfigs['price_format']);?>	
</p>
<?}else{?>
</p>
<?}?>
</li>
</ul>

<?if(isset($attributes) && sizeof($attributes)>0){?>
	<?foreach($attributes as $k=>$v){?>
		<input type="hidden" name="attributes_<?=$k?>" value="<?=$v?>" />
	<?}?>
<?}?>
<p class="buy_btn">
<?=$html->link($SCLanguages['confirm'],"javascript:sure_buy(".$product_info['Product']['id'].",".$product_info['quantity'].")","",false,false);?>
<?=$html->link($SCLanguages['cancel'],"javascript:close_message();","",false,false);?>
</p>
</div>
<p><?=$html->image("loginout-bottom.png");?></p>
</div></div>
<?}else if(isset($result['page']) && $result['page']=="cart" && $result['type'] == 0 ){?>
<? echo $this->element('cart_products', array('cache'=>'+0 hour'));?>
<?}else{
if($type == 'product'){
?>
<div id="loginout">
<h1 class="hd"><b>
	<?if($result['type']==0){?>
	<?php echo $SCLanguages['buy'].$SCLanguages['successfully'];?>
		

	<?}else{?>
	<?php echo $SCLanguages['buy'].$SCLanguages['failed'];?>
	<?}?>
	</b></h1>
<div id="buyshop_box">
<div class="shops">
	<ul>
		<li class="pic">
		<?if(isset($product_info['Product']['img_thumb'])  && $product_info['Product']['img_thumb'] != "" ){?>
		<?=$html->image($product_info['Product']['img_thumb'],array("alt"=>$product_info['ProductI18n']['name'],"width"=>108,"height"=>108));?>
		<?}else{?>
		<?=$html->image("/img/product_default.jpg",array("alt"=>$product_info['ProductI18n']['name'],"width"=>108,"height"=>108));?>
		<?}?>
		</li>
		
		<li class="right">
		
		<div class="profile">
		<dd class="name l"><? echo $SCLanguages['products'].$SCLanguages['apellation']."："?></dd>
		<dd class="name r"><? echo $product_info['ProductI18n']['name'];?></dd>
		</div>
		<?if($result['type']==1){?>
		<div class="profile"><?=$result['message'];?></div>
		<?}?>
		
		<?if($result['type']==0){?>
		<div class="profile">
		<dd class="l"><? echo $SCLanguages['quantity']."："?></dd>
		<dd class="r"><? echo $product_info['quantity'];?></dd>
		</div>
		<?if(isset($product_info['is_promotion'])){?>
		<div class="profile">
		<dd class="l"><?=$SCLanguages['our_price']?>：</dd>
		<dd class="r">
		<?if(isset($product_info['product_rank_price'])){?>
<?=$svshow->price_format($product_info['product_rank_price'],$SVConfigs['price_format']);?>
	<?}else if($product_info['is_promotion'] == 1){?>
<?=$svshow->price_format($product_info['Product']['promotion_price'],$SVConfigs['price_format']);?>	
		<? }else{ ?>
<?=$svshow->price_format($product_info['Product']['shop_price'],$SVConfigs['price_format']);?>	
		<? } ?></dd>
		</div>
		<?}?>		
		
		<?if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
		<div class="profile">
		<dd class="l"><?=$SCLanguages['market_price']."：";?></dd>
		<dd class="r"><?=$svshow->price_format($product_info['Product']['market_price'],$SVConfigs['price_format']);?></dd>
		</div>
		<?}?>
		
		<?if($product_info['discount_price'] >0 ){?>
		<div class="profile">
		<dd class="l"><?=$SCLanguages['discount']?>：</dd>
		<dd class="r"><? echo $product_info['discount_rate']."%"; ?></dd>
		</div>
		<div class="profile">
		<dd class="l"><?=$SCLanguages['save_to_market_price']?>：</dd>
		<dd><?=$svshow->price_format($product_info['discount_price'],$SVConfigs['price_format']);?></dd>
		</div>
		<?}else{?>
		
		<?}?>
		<?}?>
	<?}?>
</li>
</ul>

<?if(isset($result['page']) &&  $result['page']=="cart" && $result['type'] != 0 && $type != 'product'){?>
	<?=$result['message']?>
<p class="buy_btn"><?=$html->link($SCLanguages['confirm'],"javascript:close_message();");?></p>
</div><p><?=$html->image("loginout-bottom.png");?></p></div>

<?}else{?>
<p class="buy_btn">
<?if(isset($svcart['products']) && 	$result['type']==0){?>
<?=$html->link($SCLanguages['checkout'],"/carts/checkout");?><?=$html->link($SCLanguages['cart'],"/carts/");?>
<?=$html->link($SCLanguages['continue'],"javascript:close_message();");?>
<?}else{?>
<?=$html->link($SCLanguages['confirm'],"javascript:close_message();");?>
<?}?>
</p></div><p><?=$html->image("loginout-bottom.png");?></p></div>
<?}?>
<?}?>
</div>
<?
$result['message'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
<?if(isset($result['page']) && $result['page']=="cart" && $result['type'] == 0 ){?>

<div id="loginout">
	<h1><b><?php echo $SCLanguages['please_enter'];?><?php echo $SCLanguages['remark'];?></b></h1>
	<div class="border_side" style="background:#fff;width:423px" id="buyshop_box">
		<p class="login-alettr" style='border:0;padding-bottom:0;font-size:12px;'>
		<b><?php echo $SCLanguages['remark'];?>:</b><textarea id='note' name="textarea" cols="25" rows="5" style='vertical-align:top;width:320px;' ></textarea></p>
		<br />
		<p class="buy_btn"><?=$html->link($SCLanguages['confirm'],"javascript:add_note('".$result['buy_type']."','".$result['buy_id']."');");?>
		<?=$html->link($SCLanguages['cancel'],"javascript:close_message();");?></p>
	</div>
	<p><?=$html->image("loginout-bottom.png");?></p>
</div>
<?}?>
<?
$result['note'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
<?php echo $this->element('show_packaging', array('cache'=>'+0 hour'));?></div>
<?
$result['show_packaging'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
<?php echo $this->element('show_card', array('cache'=>'+0 hour'));?></div>
<?
$result['show_card'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>