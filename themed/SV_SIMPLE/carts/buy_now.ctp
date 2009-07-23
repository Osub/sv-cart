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
 * $Id: buy_now.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
ob_start();?>
<?php if($result['type'] == 5){?>
<div id="loginout">
	<h1><b style="font-size:14px">	<?php echo $SCLanguages['buy'];?></b></h1>
	<div class="border_side">
	<p class="login-alettr">
 	<?php echo $html->image('icon-10.gif',array("align"=>"middle"));?>
	<b>
	<?php echo $result['message']?></b></p>
		<br/>
		<p class="btns">
			<a href="javascript:close_message();"><?php echo $html->image('loginout-btn_right.gif');?><?php echo $SCLanguages['confirm'];?></a>
		</p>
	</div>
	<p><?php echo $html->image("loginout-bottom.gif",array("align"=>"texttop"))?></p>
</div>
<?php }else if($result['type'] == 4){?>
<div id="loginout">
<h1 class="hd"><b>
	<?php echo $SCLanguages['buy'];?>
	</b></h1>
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
<p class="name"><?php echo $SCLanguages['products'].$SCLanguages['apellation']."：".$product_info['ProductI18n']['name'];?></p>

<p class="buy_number"><?php echo $SCLanguages['quantity']."：".$product_info['quantity'];?></p>
<p>
<?php if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] >0){?>
<?php echo $svshow->price_format($product_info['Product']['market_price'],$SVConfigs['price_format']);?>	

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

<?php if(isset($product_info['discount_price']) && $product_info['discount_price'] > 0){?>
<?php echo $SCLanguages['discount'];?>:<?php echo $product_info['discount_rate']."%"; ?></p>
<p><?php echo $SCLanguages['save_to_market_price'];?>：
<?php echo $svshow->price_format($product_info['discount_price'],$SVConfigs['price_format']);?>	
</p>
<?php }else{?>
</p>
<?php }?>
</li>
</ul>

<?php if(isset($attributes) && sizeof($attributes)>0){?>
	<?php foreach($attributes as $k=>$v){?>
		<input type="hidden" name="attributes_<?php echo $k?>" value="<?php echo $v?>" />
	<?php }?>
<?php }?>
<p class="buy_btn">
<?php echo $html->link($SCLanguages['confirm'],"javascript:sure_buy(".$product_info['Product']['id'].",".$product_info['quantity'].")","",false,false);?>
<?php echo $html->link($SCLanguages['cancel'],"javascript:close_message();","",false,false);?>
</p>
</div>
<p><?php echo $html->image("loginout-bottom.png");?></p>
</div></div>
<?php }else if(isset($result['page']) && $result['page']=="cart" && $result['type'] == 0 ){?>
<?php echo $this->element('cart_products', array('cache'=>'+0 hour'));?>
<?php }else{
if($type == 'product'){
?>
<div id="loginout">
<h1 class="hd"><b>
	<?php if($result['type']==0){?>
	<?php echo $SCLanguages['buy'].$SCLanguages['successfully'];?>
		

	<?php }else{?>
	<?php echo $SCLanguages['buy'].$SCLanguages['failed'];?>
	<?php }?>
	</b></h1>
<div id="buyshop_box">
<div class="shops">
	<ul>
		<li class="pic">
		<?php if(isset($product_info['Product']['img_thumb'])  && $product_info['Product']['img_thumb'] != "" ){?>
		<?php echo $html->image($product_info['Product']['img_thumb'],array("alt"=>$product_info['ProductI18n']['name'],"width"=>108,"height"=>108));?>
		<?php }else{?>
		<?php echo $html->image("/img/product_default.jpg",array("alt"=>$product_info['ProductI18n']['name'],"width"=>108,"height"=>108));?>
		<?php }?>
		</li>
		
		<li class="right">
		
		<div class="profile">
		<dd class="name l"><?php echo $SCLanguages['products'].$SCLanguages['apellation']."："?></dd>
		<dd class="name r"><?php echo $product_info['ProductI18n']['name'];?></dd>
		</div>
		<?php if($result['type']==1){?>
		<div class="profile"><?php echo $result['message'];?></div>
		<?php }?>
		
		<?php if($result['type']==0){?>
		<div class="profile">
		<dd class="l"><?php echo $SCLanguages['quantity']."："?></dd>
		<dd class="r"><?php echo $product_info['quantity'];?></dd>
		</div>
		<div class="profile">
		<dd class="l"><?php echo $SCLanguages['our_price']?>：</dd>
		<dd class="r">
		<?php if(isset($product_info['product_rank_price'])){?>
<?php echo $svshow->price_format($product_info['product_rank_price'],$SVConfigs['price_format']);?>
	<?php }else if($product_info['is_promotion'] == 1){?>
<?php echo $svshow->price_format($product_info['Product']['promotion_price'],$SVConfigs['price_format']);?>	
		<?php }else{ ?>
<?php echo $svshow->price_format($product_info['Product']['shop_price'],$SVConfigs['price_format']);?>	
		<?php } ?></dd>
		</div>
		
		<?php if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
		<div class="profile">
		<dd class="l"><?php echo $SCLanguages['market_price']."：";?></dd>
		<dd class="r"><?php echo $svshow->price_format($product_info['Product']['market_price'],$SVConfigs['price_format']);?></dd>
		</div>
		<?php }?>
		
		<?php if($product_info['discount_price'] >0 ){?>
		<div class="profile">
		<dd class="l"><?php echo $SCLanguages['discount']?>：</dd>
		<dd class="r"><?php echo $product_info['discount_rate']."%"; ?></dd>
		</div>
		<div class="profile">
		<dd class="l"><?php echo $SCLanguages['save_to_market_price']?>：</dd>
		<dd><?php echo $svshow->price_format($product_info['discount_price'],$SVConfigs['price_format']);?></dd>
		</div>
		<?php }else{?>
		
		<?php }?>
		<?php }?>
	<?php }?>
</li>
</ul>

<?php if(isset($result['page']) &&  $result['page']=="cart" && $result['type'] != 0 && $type != 'product'){?>
	<?php echo $result['message']?>
<p class="buy_btn"><?php echo $html->link($SCLanguages['confirm'],"javascript:close_message();");?></p>
</div><p><?php echo $html->image("loginout-bottom.png");?></p></div>

<?php }else{?>
<p class="buy_btn">
<?php if(isset($svcart['products']) && 	$result['type']==0){?>
<?php echo $html->link($SCLanguages['checkout'],"/carts/checkout");?><?php echo $html->link($SCLanguages['cart'],"/carts/");?>
<?php echo $html->link($SCLanguages['continue'],"javascript:close_message();");?>
<?php }else{?>
<?php echo $html->link($SCLanguages['confirm'],"javascript:close_message();");?>
<?php }?>
</p></div><p><?php echo $html->image("loginout-bottom.png");?></p></div>
<?php }?>
<?php }?>
</div>
<?php 
$result['message'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
<?php if(isset($result['page']) && $result['page']=="cart" && $result['type'] == 0 ){?>

<div id="loginout">
	<h1><b><?php echo $SCLanguages['please_enter'];?><?php echo $SCLanguages['remark'];?></b></h1>
	<div class="border_side" style="background:#fff;width:423px" id="buyshop_box">
		<p class="login-alettr" style='border:0;padding-bottom:0;font-size:12px;'>
		<b><?php echo $SCLanguages['remark'];?>:</b><textarea id='note' name="textarea" cols="25" rows="5" style='vertical-align:top;width:320px;' ></textarea></p>
		<br />
		<p class="buy_btn"><?php echo $html->link($SCLanguages['confirm'],"javascript:add_note('".$result['buy_type']."','".$result['buy_id']."');");?>
		<?php echo $html->link($SCLanguages['cancel'],"javascript:close_message();");?></p>
	</div>
	<p><?php echo $html->image("loginout-bottom.png");?></p>
</div>
<?php }?>
<?php 
$result['note'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
<?php echo $this->element('show_packaging', array('cache'=>'+0 hour'));?></div>
<?php 
$result['show_packaging'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
<?php echo $this->element('show_card', array('cache'=>'+0 hour'));?></div>
<?php 
$result['show_card'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>