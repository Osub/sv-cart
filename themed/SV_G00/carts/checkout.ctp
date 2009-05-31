<?php
/*****************************************************************************
 * SV-Cart 结算页
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout.ctp 1908 2009-05-31 14:36:16Z huangbo $
*****************************************************************************/
?>
<div class="Balance_alltitle">
<h1 class="headers"><span class="l"></span><span class="r"></span><p class="address btn_list clear_all">
	<?=$html->link("<span>".$SCLanguages['mmodify'].$SCLanguages['products']."</span>","/carts/",array("class"=>"amember"),false,false);?>
	</p><b><?php echo $SCLanguages['checkout_center'];?>
</b></h1>
</div>
<!--您购买的商品 -->
<div id="globalBalance">
<p class="buy_title"><?php echo $SCLanguages['purchased_products'];?>:</p>
<p class="list_title">
<span class="name"><?=$SCLanguages['products'];?><?=$SCLanguages['names'];?></span>
<span class="attribute"><?=$SCLanguages['products'];?><?=$SCLanguages['attribute'];?>
</span>
<?if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<span class="martprice"><?php echo $SCLanguages['market_price'];?></span>
<?}?>
<span class="productsprice"><?php echo $SCLanguages['our_price'];?></span>
<span class="number"><?php echo $SCLanguages['quantity'];?></span>
<span class="sum"><?php echo $SCLanguages['subtotal'];?></span></p>
<?if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>

<?foreach($svcart['products'] as $i=>$p){?>
<p class="list_title lists">
<span class="pic"></span>
<span class="name"><?=$html->link($p['ProductI18n']['name'],$svshow->sku_product_link($i,$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></span>
<span class="attribute">
<?if(isset($p['is_promotion'])){?>
<? if($p['is_promotion']==1) echo $SCLanguages['promotion'].$SCLanguages['products']; else echo $SCLanguages['normal'].$SCLanguages['products'];?>
<?}else{?>
<?php echo $SCLanguages['normal'].$SCLanguages['products'];?>
<?}?>
&nbsp;
<?if(isset($p['attributes'])){?>
( <?=$p['attributes'];?> )
<?}?>
</span>
<?if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<span class="martprice">
<?=$svshow->price_format($p['Product']['market_price'],$SVConfigs['price_format']);?>	
	</span>
<?}?>
<?if(isset($p['product_rank_price'])){?>
<span class="productsprice">
<?=$svshow->price_format($p['product_rank_price'],$SVConfigs['price_format']);?>	
	</span>
<?} elseif(isset($p['is_promotion'])){?>
<span class="productsprice"><? if($p['is_promotion'] == 1){ ?>
<?=$svshow->price_format($p['Product']['promotion_price'],$SVConfigs['price_format']);?>	
<?}else{?>
<?=$svshow->price_format($p['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?}?>
</span>
<?}?>
<span class="number"><?= $p['quantity'];?></span>
<span class="sum">
<?=$svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?>	
	</span></p>
<?}?>
	
<?}?>
<? if(isset($svcart['packagings']) && sizeof($svcart['packagings'])>0){?>
<?foreach($svcart['packagings'] as $i=>$p){?>
<p class="list_title lists">
<span class="pic"></span>
<span class="name"><?=$p['PackagingI18n']['name'];?></span>
<span class="attribute"><?//php echo $SCLanguages['package_fee'];?>
<?if(isset($p['Packaging']['note'])){?>
	<?=$p['Packaging']['note'];?>	
<?}?>
	</span>
<span class="productsprice"></span>
<span class="martprice">
<?=$svshow->price_format($p['Packaging']['fee'],$SVConfigs['price_format']);?>	
</span>
<span class="number"><?= $p['quantity'];?></span>
<span class="sum">
<?=$svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?>	
	</span></p>
<?}?>
<?}?>
<? if(isset($svcart['cards']) && sizeof($svcart['cards'])>0){?>
<?foreach($svcart['cards'] as $i=>$p){?>
<p class="list_title lists">
<span class="pic"></span>
<span class="name"><?=$p['CardI18n']['name'];?></span>
<span class="attribute"><?//php echo $SCLanguages['card_fee'];?>
<?if(isset($p['Card']['note'])){?>
<?=$p['Card']['note'];?>	
<?}?>
</span><span class="productsprice"></span>

<span class="martprice">
<?=$svshow->price_format($p['Card']['fee'],$SVConfigs['price_format']);?>	
	</span>
<span class="number"><?= $p['quantity'];?></span>
<span class="sum">
<?=$svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?>	
	</span></p>
<?}?>
<?}?>
	
<? if(isset($svcart['promotion']['type']) && $svcart['promotion']['type'] == 2 && isset($svcart['Product_by_Promotion']) && sizeof($svcart['Product_by_Promotion'])>0){?>
<?foreach($svcart['Product_by_Promotion'] as $k=>$value){?>
<p class="list_title lists">
<span class="pic"></span>
<span class="name"><?=$value['ProductI18n']['name']?></span>
<span class="attribute"><?//php echo $SCLanguages['card_fee'];?>
<?=$SCLanguages['favorable_products']?>
</span><span class="productsprice"></span>

<span class="martprice">
<?=$svshow->price_format($value['Product']['now_fee'],$SVConfigs['price_format']);?>	
	</span>
<span class="number">1</span>
<span class="sum">
<?=$svshow->price_format($value['Product']['now_fee'],$SVConfigs['price_format']);?>	
	</span></p>
<?}?>
<?}?>



	
	
	
	
<p class="buy_allmeny"><?php echo $SCLanguages['amount'].$SCLanguages['total'];?> 
<?=$svshow->price_format($svcart['cart_info']['sum_subtotal'],$SVConfigs['price_format']);?>	
<?if($svcart['cart_info']['discount_price'] > 0){?>
，<font color="#FF6000"><?// echo $SCLanguages['compare_to_market_price'];?> <!--￥--><?//=$svcart['cart_info']['sum_market_subtotal'];?><?//php echo $SCLanguages['yuan'];?> 
<?php echo $SCLanguages['save_to_market_price'];?>
<?=$svshow->price_format($svcart['cart_info']['discount_price'],$SVConfigs['price_format']);?>	
(<?=(100 - $svcart['cart_info']['discount_rate']);?>%)</font>
<?}?>	
	<?//=$SCLanguages['this_order_receives']?>
<br />
		<?if(isset($send_point['order_smallest'])){?>
				<?if($send_point['order_smallest'] > 0){?>
		<br />	<?=$SCLanguages['more_than_order_total']?> <?=$svshow->price_format($send_point['order_smallest'],$SVConfigs['price_format']);?>	
  <?=$SCLanguages['present_points']?> ：<?=$send_point['order_gift_points']?> <?=$SCLanguages['point_unit'];?>
		<?}?>
		<?}?>
		<?if(isset($send_point['order_gift_points'])){?>
				<?if($send_point['order_gift_points'] > 0){?>
	<br />		<?=$SCLanguages['place_order']?><?=$SCLanguages['present_points']?> ： <?=$send_point['order_gift_points']?> <?=$SCLanguages['point_unit'];?>
		<?}?>
		<?}?>
		<?if(isset($product_point) && sizeof($product_point)>0){?>
			<?foreach($product_point as $kk=>$vv){?>
				<?if($vv['point'] > 0){?>
			<br />	<?=$vv['name']?> <?=$SCLanguages['present_points']?>:<?=$vv['point']?> <?=$SCLanguages['point_unit'];?>
				<?}?>
			<?}?>
		<?}?>
		<?if(isset($order_coupon) && sizeof($order_coupon)>0){?>
			<?foreach($order_coupon as $k=>$v){?>
				<?if($v['fee'] > 0){?>
		<br />		<?=$SCLanguages['more_than_order_total']?><?=$SCLanguages['present_points']?> ：
		<?=$v['name']?><?=$svshow->price_format($v['fee'],$SVConfigs['price_format']);?>&nbsp;
				<?}?>
			<?}?>
			<?}?>
		<?if(isset($product_coupon) && sizeof($product_coupon)>0){?>
			<?foreach($product_coupon as $kk=>$vv){?>
				<?if($vv['fee'] > 0){?>
		<br />		<?=$vv['name']?> <?=$SCLanguages['present_coupons']?> ：<?=$svshow->price_format($vv['fee'],$SVConfigs['price_format']);?><?if($vv['quantity']>1){?>X<?=$vv['quantity']?><?}?>
			<?}?>
			<?}?>
		<?}?>
			
	</p>
 	<?=$html->image('Balancebottom_img.gif',array("align"=>"absbottom"));?>
</div>
<!--您购买的商品End-->
<?=$javascript->link('cart');?>
<br />
<div id="Balance_info">
		
<!--促销begin 暂时取消-->
<div id="promotions" style="display:none">
<?if(isset($svcart['promotion'])){?>
<? echo $this->element('checkout_promotion_confirm', array('cache'=>'+0 hour'));?>
<?}else if(isset($promotions) && count($promotions) > 0){?>
<? echo $this->element('checkout_promotion', array('cache'=>'+0 hour'));?>
<br/><br/>
<?}?>
</div>
<!--促销end-->


<!--Address-->
<div id="address_shipping" >
<div id="checkout_address">
<?if(isset($svcart['address'])){?>
<?if($svcart['address']['zipcode'] != "" || $all_virtual == 1){?>
<? echo $this->element('checkout_address_confirm', array('cache'=>'+0 hour'));?>
<?}else{?>
<? echo $this->element('checkout_address_update', array('cache'=>'+0 hour'));?>
<script type="text/javascript">
var regions_add = <?="'".$svcart['address']['regions']."'"?>;
show_two_regions(regions_add);
</script>
<?}?>
<?}else if ($checkout_address =="new_address"){?>
<?if($all_virtual){?>
<p class="address btn_list border_bottom" style="padding-bottom:0;">
<a href="javascript:checkout_new_virtual_address();" class="amember"><span><?=$SCLanguages['add']?></span></a>
<span class="l"></span><span class="r"></span><?php echo $SCLanguages['consignee'].$SCLanguages['information'];?>:
</p>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 style="width:97%;margin:0 auto;border:none">
<tr>
<td class="lan-name">&nbsp;<?=$SCLanguages['address'];?><?=$SCLanguages['label'];?>:</td>
<td class="lan-info"><input name="data['address']['name']" id="AddressName" value="">&nbsp;<font id="add_address_name" color="red">*</font></td>
</tr>

<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td>
<td class="lan-info"><input name="data['address']['consignee']" id="AddressConsignee" value="">&nbsp;<font id="add_address_consignee" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['mobile'];?>:</td><td class="lan-info"><input name="data['address']['mobile']" onKeyUp="is_int(this);" id="AddressMobile" value="">&nbsp;<font id="add_address_mobile" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['telephone'];?>:</td><td class="lan-info">

<input style="width:30px;" type="text" name="user_tel0" id="add_tel_0" onKeyUp="is_int(this);" maxLength="30" size="6" />
-<input type="text" name="user_tel1" id="add_tel_1" style="width:80px;" onKeyUp="is_int(this);" size="10" />
-<input style="width:30px;" type="text" name="user_tel2" id="add_tel_2" onKeyUp="is_int(this);" size="6" />
&nbsp;<font id="add_address_telephone" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['email'];?>:</td><td class="lan-info"><input name="data['address']['email']" id="AddressEmail" value="">&nbsp;<font id="add_address_email" color="red">*</font></td>
</tr>
<tr class='btn_list'>
<td colspan="1" align="right" style="*padding-top:8px;">

</td>
</tr>
</table>



<?}else{?>
<p class="address btn_list border_bottom" style="padding-bottom:0;">
<a href="javascript:checkout_new_address();" class="amember"><span><?=$SCLanguages['add']?></span></a>
<span class="l"></span><span class="r"></span><?php echo $SCLanguages['consignee'].$SCLanguages['information'];?>:
</p>
</table>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align="center">
<tr>
<td class="lan-name">&nbsp;<?=$SCLanguages['address'];?><?=$SCLanguages['label'];?>:</td>
<td class="lan-info"><input name="data['address']['name']" id="AddressName" value="">&nbsp;<font id="add_address_name" color="red">*</font></td>
<td class="lan-name" ><?php echo $SCLanguages['region'];?>:</td>
<td class="lan-info" width="350"><span id="regions"></span><span id="add_region_loading" style='display:none'><?=$html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>&nbsp;<font id="add_address_regions" color="red">*</font></td>
</tr>

<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td>
<td class="lan-info"><input name="data['address']['consignee']" id="AddressConsignee" value="">&nbsp;<font id="add_address_consignee" color="red">*</font></td>
<td class="lan-name"><?php echo $SCLanguages['address'];?>:</td>
<td class="lan-info"><input name="data['address']['address']" id="AddressAddress" value="">&nbsp;<font id="add_address_address" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['mobile'];?>:</td><td class="lan-info"><input name="data['address']['mobile']" onKeyUp="is_int(this);" id="AddressMobile" value="">&nbsp;<font id="add_address_mobile" color="red">*</font></td>
<td class="lan-name "><?php echo $SCLanguages['marked_building'];?>:</td><td class="lan-info"><input name="data['address']['sign_building']" id="AddressSignBuilding" value=""></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['telephone'];?>:</td><td class="lan-info">
<!--input name="data['address']['telephone']" id="AddressTelephone" value=""-->
<input style="width:30px;" type="text" name="user_tel0" id="add_tel_0" onKeyUp="is_int(this);" maxLength="30" size="6" />
-<input type="text" name="user_tel1" id="add_tel_1" style="width:80px;" onKeyUp="is_int(this);" size="10" />
-<input style="width:30px;" type="text" name="user_tel2" id="add_tel_2" onKeyUp="is_int(this);" size="6" />
&nbsp;<font id="add_address_telephone" color="red">*</font></td>
<td class="lan-name"><?php echo $SCLanguages['post_code'];?>:</td><td class="lan-info"><input name="data['address']['zipcode']" id="AddressZipcode" onKeyUp="is_int(this);" value="">&nbsp;<font id="add_address_zipcode" color="red">*</font></td>
</tr>
<tr>
<td class="lan-name">&nbsp;<?php echo $SCLanguages['email'];?>:</td><td class="lan-info"><input name="data['address']['email']" id="AddressEmail" value="">&nbsp;<font id="add_address_email" color="red">*</font></td>
<td class="lan-name"><?php echo $SCLanguages['best_shipping_time'];?>:</td><td class="lan-info"><input name="data['address']['best_time']" id="AddressBestTime" value=""></td>
</tr>
</table>
<script type="text/javascript">
show_regions("");
</script>	
<?}?>

<?}else if (isset($checkout_address) && $checkout_address == "confirm_address"){?>
<? echo $this->element('checkout_address', array('cache'=>'+0 hour'));?>
<?}else if (isset($checkout_address) && $checkout_address == "select_address"){?>
<p class="address btn_list border_bottom">
<?=$html->link("<span>".$SCLanguages['mmodify']."</span>","javascript:show_address_edit('".$address['UserAddress']['id']."')",array("class"=>"amember"),false,false);?>
<span class="l"></span><span class="r"></span><?=$SCLanguages['please_choose']?><?=$SCLanguages['consignee']?><?=$SCLanguages['information']?>:
</p>
<table cellpadding="0" cellspacing="0" class="address_table" border="0" align=center id="checkout_shipping_choice">

<tr>
<td class="lan-name first"><?=$SCLanguages['address'];?><?=$SCLanguages['label'];?></td>
<td class="lan-name first"><?php echo $SCLanguages['address'];?></td>
<td class="lan-name first"><?php echo $SCLanguages['area'];?></td>
</tr>
	
<?if(isset($addresses) && sizeof($addresses)>0){?>
<?foreach($addresses as $i=>$p){?>
<tr>
<td class="lan-name first"><input type="radio" name="address_id" id="<?=$p['UserAddress']['id'];?>" value="<?=$p['UserAddress']['id'];?>" onclick="javascript:confirm_address(<?=$p['UserAddress']['id'];?>)" class="radio" /><label for="<?=$p['UserAddress']['id'];?>"><?=$p['UserAddress']['name']?></label></td>
<td class="lan-name first"><?=$p['UserAddress']['address']?></td>
<td class="lan-name first"><?=$p['UserAddress']['regions']?></td>
</tr>
<?}?>
<?}?>
</table>
<?}?>
</div>
<!--End Address-->

<!--Shipping-->
<?=$form->create('carts',array('action'=>'/done','name'=>'cart_info','type'=>'POST'));?>
<div id="checkout_shipping" <?php if($all_virtual){?>style="display:none"<?php }?>>
<?if(isset($svcart['shipping']['shipping_fee'])){?>
<p class="address btn_list" id="address_btn_list">
<span class="l"></span><span class="r"></span>
<?if(!isset($svcart['shipping']['not_show_change']) || $svcart['shipping']['not_show_change'] == '0'){?>
<a href="javascript:change_shipping();" class="amember"><span><?=$SCLanguages['mmodify']?></span></a>
<?}?>
<?php echo $SCLanguages['shipping_method'];?>:</p>
<? echo $this->element('checkout_shipping_confirm', array('cache'=>'+0 hour'));?>
<?}else if(isset($shippings)){?>
<p class="address btn_list" id="address_btn_list" <?php if($all_virtual){?>style="display:none"<?php }?>>
<span class="l"></span><span class="r"></span>
<?php echo $SCLanguages['shipping_method'];?>:</p>
<? echo $this->element('checkout_shipping', array('cache'=>'+0 hour'));?>
<?}else{?>
<p class="address btn_list" id="address_btn_list" <?php if($all_virtual){?>style="display:none"<?php }?>>
<span class="l"></span><span class="r"></span>
<?php echo $SCLanguages['shipping_method'];?>:</p>
<p class="border_b" style='margin:0 10px;' align='center'><br /><br /><b>
	<?if(isset($shipping_type) && $shipping_type == 0){?>
	<?php echo $SCLanguages['edit_region_or_contact_cs'];?>
	<?}else{?>
	<?php echo $SCLanguages['no_shipping_method'];?>
	<?}?>
	</b><br /><br /><br /></p>
<?}?>
</div>
</div>
<!--Shipping End-->

<!--Payment-->
<div id="payment">
<?if(isset($svcart['payment']['payment_fee'])){?>
<p class="address btn_list">
<span class="l"></span><span class="r"></span>
<?if(!isset($svcart['payment']['not_show_change']) || $svcart['payment']['not_show_change'] == '0'){?>
<a href="javascript:change_payment()" class="amember"><span><?=$SCLanguages['mmodify']?></span></a>
<?}?>
<?php echo $SCLanguages['payment'];?>:
</p>
<? echo $this->element('checkout_payment_confirm', array('cache'=>'+0 hour'));?>
<?}else if(isset($payments) && sizeof($payments)>0){?>
<p class="address btn_list">
<span class="l"></span><span class="r"></span>
<?php echo $SCLanguages['payment'];?>:
</p>
<? echo $this->element('checkout_payment', array('cache'=>'+0 hour'));?>
<?}else{?>
<p class="address btn_list">
<span class="l"></span><span class="r"></span>
<?php echo $SCLanguages['payment'];?>:
</p>
<p class="border_b" style='margin:0 10px;' align='center'><br /><br /><b><?=$SCLanguages['no_paying_method'];?></b><br /><br /><br /></p>
<?}?>
</div>
<!--Payment End-->

<!-- Points -->	
<div id="point">
<?if($SVConfigs['enable_points'] == 1){?>
<?if(isset($svcart['point'])){?>
<p class="address btn_list">
<span class="l"></span><span class="r"></span>
<a href="javascript:change_point()" class="amember"><span><?=$SCLanguages['mmodify']?></span></a>
<?=$SCLanguages['use'].$SCLanguages['point'];?>: 
</p>
<? echo $this->element('checkout_point_confirm', array('cache'=>'+0 hour'));?>
<?}else{?>
<p class="address btn_list">
<span class="l"></span><span class="r"></span>
<?=$SCLanguages['use'].$SCLanguages['point'];?>: 
</p>
<? echo $this->element('checkout_point', array('cache'=>'+0 hour'));?>
<?}?>
<?}?>	
</div>
<!--Points End -->

<!-- 优惠券使用 start -->	
<div id="coupon">
<?if(isset($SVConfigs['use_coupons']) && $SVConfigs['use_coupons'] == 1){?>
<?if(isset($svcart['coupon'])){?>
<p class="address btn_list">
<span class="l"></span><span class="r"></span>
<a href="javascript:change_coupon()" class="amember"><span><?=$SCLanguages['mmodify']?></span></a>
<?=$SCLanguages['use'].$SCLanguages['coupon'];?>: 
</p>
<? echo $this->element('checkout_coupon_confirm', array('cache'=>'+0 hour'));?>
<?}else{?>
<p class="address btn_list">
<span class="l"></span><span class="r"></span>
<?=$SCLanguages['use'].$SCLanguages['coupon'];?>: 
</p>
<? echo $this->element('checkout_coupon', array('cache'=>'+0 hour'));?>
<?}?>
<?}?>	
</div>
 <!--优惠券使用 end --> 
 
<!-- order_note start -->	
<div id="order_note">

<?if(isset($svcart['order_note'])){?>
<p class="address btn_list">
<span class="l"></span><span class="r"></span>
<span id="change_remark">
<a href="javascript:change_remark()" class="amember"><span><?=$SCLanguages['mmodify']?></span></a>
</span>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice" style="width:97.5%;border:1px solid blue">
<tr class="list">
<td width="34%" height="25" valign="middle" class="bewrite">
<div class="btn_list" style="padding-top:10px;">
<p class="float_l" style="padding:1px 4px 0 20px;*margin-top:-2px;">
<span id="order_note_value" >
<?=$svcart['order_note']?>
</span>
<span id="order_note_textarea" style="display:none">
<textarea name="order_note" id="order_note_add" class="green_border" style="width:340px;overflow-y:scroll;vertical-align:top" onblur="javascript:add_remark();" ><?=$svcart['order_note']?></textarea>
</span>

</p><br/><br/><br/><br/>
<span id="remark_msg" style='padding:1px 4px 0 20px;*margin-top:-2px;color:red'></span>
<div style="padding:2px 4px 0 160px;*margin-top:-2px;">
</div>
</div>
</td>
<td width="36%" height="25" valign="middle" class="handel">
	<div valign="middle"  style="padding-left:20px;"><?=$SCLanguages['if_requirements_in_orders']?><br/><?=$SCLanguages['remark_here']?></div><br /><br/>
</td>
</tr>
</table>	
<?}else{?>
<p class="address btn_list">
<span class="l"></span><span class="r"></span>
<span id="change_remark" style="display:none">
<a href="javascript:change_remark()" class="amember"><span><?=$SCLanguages['mmodify']?></span></a>
</span>
<?=$SCLanguages['order'].$SCLanguages['remark'];?>: 
</p>
<? echo $this->element('checkout_remark', array('cache'=>'+0 hour'));?>
<?}?>
</div>
 <!--order_note end -->  
<p class="address">
<span class="l"></span><span class="r"></span>
<?php echo $SCLanguages['total'].$SCLanguages['amount'];?>:</p>
<div id="checkout_total">
<?if(isset($svcart)){?>
<? echo $this->element('checkout_total', array('cache'=>'+0 hour'));?>
<?}else{?>
<p class="item_price"><font><?=$SCLanguages['products'].$SCLanguages['total'];?></font>:
<?=$svshow->price_format($svcart['cart_info']['sum_subtotal'],$SVConfigs['price_format']);?>	
<?if(isset($svcart['shipping']['shipping_fee'])){?>
<span class="send_menny"><?php echo $SCLanguages['shipping_fee'];?>:
<?=$svshow->price_format($svcart['shipping']['shipping_fee'],$SVConfigs['price_format']);?>	
</span><?}?><?if(isset($svcart['payment']['payment_fee'])){?><span class="send_menny"><?php echo $SCLanguages['payment_fee'];?>:
<?=$svshow->price_format($svcart['payment']['payment_fee'],$SVConfigs['price_format']);?>	
</span><?}?><?if(isset($svcart['cart_info']['total'])){?></span><span class="sum_meny"><?php echo $SCLanguages['total'];?>: 
<?=$svshow->price_format($svcart['cart_info']['total'],$SVConfigs['price_format']);?>	
</span><?}?>
</p>
<?}?>
</div>
	
<p class="Balance_btn"><input type="button" value="<?=$SCLanguages['checkout'];?>" onclick="javascript:checkout_order();" onfocus="blur()" /></p>
</div> 
<?=$form->end();?>
<div style="width:741px;margin:30px auto 10px;*margin:10px auto 0;">
<?php echo $this->element('news',array('cache'=>'+0 hour'))?>
</div>