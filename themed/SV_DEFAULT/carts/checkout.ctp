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
 * $Id: checkout.ctp 3233 2009-07-22 11:41:02Z huangbo $
*****************************************************************************/
?>
<div class="Balance_alltitle">
<h1 class="headers"><span class="l"></span><span class="r"></span>
<p class="clear_all"><?php echo $html->link("<span>".$SCLanguages['mmodify'].$SCLanguages['products']."</span>","/carts/",array("class"=>"amember"),false,false);?></p><?php echo $SCLanguages['checkout_center'];?>
</h1>
</div>
<!--您购买的商品 -->
<div id="globalBalance">
<p class="buy_title"><?php echo $SCLanguages['purchased_products'];?>:</p>
<p class="list_title">
<span class="name"><?php echo $SCLanguages['products'];?><?php echo $SCLanguages['names'];?></span>
<span class="attribute"><?php echo $SCLanguages['products'];?><?php echo $SCLanguages['attribute'];?>
</span>
<?php if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<span class="martprice"><?php echo $SCLanguages['market_price'];?></span>
<?php }?>
<span class="productsprice"><?php echo $SCLanguages['our_price'];?></span>
<span class="number"><?php echo $SCLanguages['quantity'];?></span>
<span class="sum"><?php echo $SCLanguages['subtotal'];?></span></p>
<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>

<?php foreach($svcart['products'] as $i=>$p){?>
<p class="list_title lists">
<span class="pic"></span>
<span class="name"><?php echo $html->link($p['ProductI18n']['name'],$svshow->sku_product_link($i,$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></span>
<span class="attribute">
<?php if(isset($p['is_promotion'])){?>
<?php if($p['is_promotion']==1) echo $SCLanguages['promotion'].$SCLanguages['products']; else echo $SCLanguages['normal'].$SCLanguages['products'];?>
<?php }else{?>
<?php echo $SCLanguages['normal'].$SCLanguages['products'];?>
<?php }?>
&nbsp;
<?php if(isset($p['attributes']) && $p['attributes'] != ""){?>
( <?php echo $p['attributes'];?> )
<?php }?>
</span>
<?php if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] == 1){?>
<span class="martprice"><?php echo $svshow->price_format($p['Product']['market_price'],$SVConfigs['price_format']);?></span>
<?php }?>
<?php if(isset($p['product_rank_price'])){?>
<span class="productsprice">
<?php echo $svshow->price_format($p['product_rank_price'],$SVConfigs['price_format']);?>	
	</span>
<?php } elseif(isset($p['is_promotion'])){?>
<span class="productsprice"><?php if($p['is_promotion'] == 1){ ?>
<?php echo $svshow->price_format($p['Product']['promotion_price'],$SVConfigs['price_format']);?>	
<?php }else{?>
<?php echo $svshow->price_format($p['Product']['shop_price'],$SVConfigs['price_format']);?>	
<?php }?>
</span>
<?php }?>
<span class="number"><?php echo  $p['quantity'];?></span>
<span class="sum">
<?php echo $svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?>	
	</span></p>
<?php }?>
	
<?php }?>
<?php if(isset($svcart['packagings']) && sizeof($svcart['packagings'])>0){?>
<?php foreach($svcart['packagings'] as $i=>$p){?>
<p class="list_title lists">
<span class="pic"></span>
<span class="name"><?php echo $p['PackagingI18n']['name'];?></span>
<span class="attribute"><?php //php echo $SCLanguages['package_fee'];?>
<?php if(isset($p['Packaging']['note'])){?>
	<?php echo $p['Packaging']['note'];?>	
<?php }?>
	</span>
<span class="productsprice"></span>
<span class="martprice">
<?php echo $svshow->price_format($p['Packaging']['fee'],$SVConfigs['price_format']);?>	
</span>
<span class="number"><?php echo  $p['quantity'];?></span>
<span class="sum">
<?php echo $svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?>	
	</span></p>
<?php }?>
<?php }?>
<?php if(isset($svcart['cards']) && sizeof($svcart['cards'])>0){?>
<?php foreach($svcart['cards'] as $i=>$p){?>
<p class="list_title lists">
<span class="pic"></span>
<span class="name"><?php echo $p['CardI18n']['name'];?></span>
<span class="attribute"><?php //php echo $SCLanguages['card_fee'];?>
<?php if(isset($p['Card']['note'])){?>
<?php echo $p['Card']['note'];?>	
<?php }?>
</span><span class="productsprice"></span>

<span class="martprice">
<?php echo $svshow->price_format($p['Card']['fee'],$SVConfigs['price_format']);?>	
	</span>
<span class="number"><?php echo  $p['quantity'];?></span>
<span class="sum">
<?php echo $svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?>	
	</span></p>
<?php }?>
<?php }?>
	
<?php if(isset($svcart['promotion']['type']) && $svcart['promotion']['type'] == 2 && isset($svcart['Product_by_Promotion']) && sizeof($svcart['Product_by_Promotion'])>0){?>
<?php foreach($svcart['Product_by_Promotion'] as $k=>$value){?>
<p class="list_title lists">
<span class="pic"></span>
<span class="name"><?php echo $value['ProductI18n']['name']?></span>
<span class="attribute"><?php //php echo $SCLanguages['card_fee'];?>
<?php echo $SCLanguages['favorable_products']?>
</span><span class="productsprice"></span>

<span class="martprice">
<?php echo $svshow->price_format($value['Product']['now_fee'],$SVConfigs['price_format']);?>	
	</span>
<span class="number">1</span>
<span class="sum">
<?php echo $svshow->price_format($value['Product']['now_fee'],$SVConfigs['price_format']);?>	
	</span></p>
<?php }?>
<?php }?>



	
	
	
	
<p class="buy_allmeny"><?php echo $SCLanguages['amount'].$SCLanguages['total'];?> 
<?php echo $svshow->price_format($svcart['cart_info']['sum_subtotal'],$SVConfigs['price_format']);?>	
<?php if($svcart['cart_info']['discount_price'] > 0){?>
，<font color="#FF6000"><?php // echo $SCLanguages['compare_to_market_price'];?> <!--￥--><?php //=$svcart['cart_info']['sum_market_subtotal'];?><?php //php echo $SCLanguages['yuan'];?> 
<?php echo $SCLanguages['save_to_market_price'];?>
<?php echo $svshow->price_format($svcart['cart_info']['discount_price'],$SVConfigs['price_format']);?>	
(<?php echo (100 - $svcart['cart_info']['discount_rate']);?>%)</font>
<?php }?>	
	<?php //=$SCLanguages['this_order_receives']?>
<br />
		<?php if(isset($send_point['order_smallest'])){?>
				<?php if($send_point['order_smallest'] > 0){?>
		<br />	<?php echo $SCLanguages['more_than_order_total']?> <?php echo $svshow->price_format($send_point['order_smallest'],$SVConfigs['price_format']);?>	
  <?php echo $SCLanguages['present_points']?> ：<?php echo $send_point['order_gift_points']?> <?php echo $SCLanguages['point_unit'];?>
		<?php }?>
		<?php }?>
		<?php if(isset($send_point['order_gift_points'])){?>
				<?php if($send_point['order_gift_points'] > 0){?>
	<br />		<?php echo $SCLanguages['place_order']?><?php echo $SCLanguages['present_points']?> ： <?php echo $send_point['order_gift_points']?> <?php echo $SCLanguages['point_unit'];?>
		<?php }?>
		<?php }?>
		<?php if(isset($product_point) && sizeof($product_point)>0){?>
			<?php foreach($product_point as $kk=>$vv){?>
				<?php if($vv['point'] > 0){?>
			<br />	<?php echo $vv['name']?> <?php echo $SCLanguages['present_points']?>:<?php echo $vv['point']?> <?php echo $SCLanguages['point_unit'];?>
				<?php }?>
			<?php }?>
		<?php }?>
		<?php if(isset($order_coupon) && sizeof($order_coupon)>0){?>
			<?php foreach($order_coupon as $k=>$v){?>
				<?php if($v['fee'] > 0){?>
		<br />		<?php echo $SCLanguages['more_than_order_total']?><?php echo $SCLanguages['present_points']?> ：
		<?php echo $v['name']?><?php echo $svshow->price_format($v['fee'],$SVConfigs['price_format']);?>&nbsp;
				<?php }?>
			<?php }?>
			<?php }?>
		<?php if(isset($product_coupon) && sizeof($product_coupon)>0){?>
			<?php foreach($product_coupon as $kk=>$vv){?>
				<?php if($vv['fee'] > 0){?>
		<br />		<?php echo $vv['name']?> <?php echo $SCLanguages['present_coupons']?> ：<?php echo $svshow->price_format($vv['fee'],$SVConfigs['price_format']);?><?php if($vv['quantity']>1){?>X<?php echo $vv['quantity']?><?php }?>
			<?php }?>
			<?php }?>
		<?php }?>
	</p>
 	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'Balancebottom_img.gif':'Balancebottom_img.gif',array());?></p>
</div>
<!--您购买的商品End-->
<?php echo $javascript->link('cart');?>
<br />
<div id="Balance_info">
		
<!--促销begin 暂时取消-->
<div id="promotions" style="display:none">
<?php if(isset($svcart['promotion'])){?>
<?php echo $this->element('checkout_promotion_confirm', array('cache'=>'+0 hour'));?>
<?php }else if(isset($promotions) && count($promotions) > 0){?>
<?php echo $this->element('checkout_promotion', array('cache'=>'+0 hour'));?>
<br/><br/>
<?php }?>
</div>
<!--促销end-->


<!--Address-->
<div id="address_shipping" >
<div id="checkout_address">
<?php if(isset($svcart['address'])){?>
<?php if( ((isset($svcart['address']['mobile']) && $svcart['address']['mobile'] !='')||(isset($svcart['address']['telephone']) && $svcart['address']['telephone'] !='')) || $all_virtual == 1){?>
<?php echo $this->element('checkout_address_confirm', array('cache'=>'+0 hour'));?>
<?php }else{?>
<?php echo $this->element('checkout_address_update', array('cache'=>'+0 hour'));?>
<script type="text/javascript">
var regions_add = <?php 
if(isset($svcart['address']['regions'])){
echo "'".$svcart['address']['regions']."'";
}else{
echo "''";
}
?>;
show_two_regions(regions_add);
</script>
<?php }?>
<?php }else if ($checkout_address =="new_address"){?>
<?php if($all_virtual){?>
<h5><?php echo $SCLanguages['consignee'].$SCLanguages['information'];?>:</h5>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 style="width:97%;margin:0 auto;border:none">
<tr>
	<td class="lan-name first"><?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?>:</td>
	<td class="lan-info"><input name="data['address']['name']" id="AddressName" value="">&nbsp;<font id="add_address_name" color="red">*</font></td>
</tr>

<tr>
	<td class="lan-name first"><?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td>
	<td class="lan-info"><input name="data['address']['consignee']" id="AddressConsignee" value="">&nbsp;<font id="add_address_consignee" color="red">*</font></td>
</tr>
<tr>
	<td class="lan-name first"><?php echo $SCLanguages['mobile'];?>:</td>
	<td class="lan-info"><input name="data['address']['mobile']" onKeyUp="is_int(this);" id="AddressMobile" value="">&nbsp;<font id="add_address_mobile" color="red">*</font></td>
</tr>
<tr>
	<td class="lan-name first"><?php echo $SCLanguages['telephone'];?>:</td>
	<td class="lan-info"><input type="text" name="user_tel0" id="add_tel_0" onKeyUp="is_int(this);"  />
	&nbsp;<font id="add_address_telephone" color="red">*</font></td>
</tr>
<tr>
	<td class="lan-name first"><?php echo $SCLanguages['email'];?>:</td>
	<td class="lan-info"><input name="data['address']['email']" id="AddressEmail" value="">&nbsp;<font id="add_address_email" color="red">*</font></td>
</tr>
<tr>
	<td colspan="4" class="btn_list" style="padding-left:415px;"><a href="javascript:checkout_new_virtual_address();" class="amember float_l"><span><?php echo $SCLanguages['add']?></span></a></td>
</tr>
</table>

<?php }else{?>

<h5><?php echo $SCLanguages['consignee'].$SCLanguages['information'];?>:</h5>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align="center">
<tr>
	<td class="lan-name first"><?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?>:</td>
	<td class="lan-info"><input name="data['address']['name']" id="AddressName" value="">&nbsp;<font id="add_address_name" color="red">*</font></td>
	<td class="lan-name" ><?php echo $SCLanguages['region'];?>:</td>
	<td class="lan-info" width="350"><span id="regions"></span><span id="add_region_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>&nbsp;<font id="add_address_regions" color="red">*</font></td>
</tr>
<input type="hidden" name="EditAddressId" id="EditAddressId" value="" />
<tr>
	<td class="lan-name first"><?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td>
	<td class="lan-info"><input name="data['address']['consignee']" id="AddressConsignee" value="">&nbsp;<font id="add_address_consignee" color="red">*</font></td>
	<td class="lan-name"><?php echo $SCLanguages['address'];?>:</td>
	<td class="lan-info"><input name="data['address']['address']" id="AddressAddress" value="">&nbsp;<font id="add_address_address" color="red">*</font></td>
</tr>
<tr>
	<td class="lan-name first"><?php echo $SCLanguages['mobile'];?>:</td>
	<td class="lan-info"><input name="data['address']['mobile']" onKeyUp="is_int(this);" id="AddressMobile" value="">&nbsp;<font id="add_address_mobile" color="red">*</font></td>
	<td class="lan-name "><?php echo $SCLanguages['marked_building'];?>:</td>
	<td class="lan-info"><input name="data['address']['sign_building']" id="AddressSignBuilding" value=""></td>
</tr>
<tr>
	<td class="lan-name first"><?php echo $SCLanguages['telephone'];?>:</td><td class="lan-info">
	<!--input name="data['address']['telephone']" id="AddressTelephone" value=""-->
	<input  type="text" name="user_tel0" id="add_tel_0" onKeyUp="is_int(this);"/>
	<font id="add_address_telephone" color="red">*</font></td>
	<td class="lan-name"><?php echo $SCLanguages['post_code'];?>:</td><td class="lan-info"><input name="data['address']['zipcode']" id="AddressZipcode" onKeyUp="is_int(this);" value=""></td>
</tr>
<tr>
	<td class="lan-name first"><?php echo $SCLanguages['email'];?>:</td>
	<td class="lan-info"><input name="data['address']['email']" id="AddressEmail" value="">&nbsp;<font id="add_address_email" color="red">*</font></td>
	<td class="lan-name"><?php echo $SCLanguages['best_shipping_time'];?>:</td>
	<td class="lan-info"><input name="data['address']['best_time']" id="AddressBestTime" value=""></td>
</tr>
<tr>
	<td colspan="4" class="btn_list" style="padding-left:415px;"><a href="javascript:checkout_new_address();" class="amember float_l"><span><?php echo $SCLanguages['add']?></span></a></td>
</tr>
</table>
<script type="text/javascript">
show_regions("");
</script>	
<?php }?>

<?php }else if (isset($checkout_address) && $checkout_address == "confirm_address"){?>
<?php echo $this->element('checkout_address', array('cache'=>'+0 hour'));?>
<?php }else if (isset($checkout_address) && $checkout_address == "select_address"){?>
<h5>
<?php echo $html->link("<span>".$SCLanguages['mmodify']."</span>","javascript:show_address_edit('".$address['UserAddress']['id']."')",array("class"=>"amember"),false,false);?>
<?php echo $SCLanguages['please_choose']?><?php echo $SCLanguages['consignee']?><?php echo $SCLanguages['information']?>:
</h5>
<table cellpadding="0" cellspacing="0" class="address_table" border="0" align=center id="checkout_shipping_choice">

<tr>
	<td class="lan-name first"><?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?></td>
	<td class="lan-name first"><?php echo $SCLanguages['address'];?></td>
	<td class="lan-name first"><?php echo $SCLanguages['area'];?></td>
</tr>
	
<?php if(isset($addresses) && sizeof($addresses)>0){?>
<?php foreach($addresses as $i=>$p){?>
<tr>
<td class="lan-name first"><input type="radio" name="address_id" id="<?php echo $p['UserAddress']['id'];?>" value="<?php echo $p['UserAddress']['id'];?>" onclick="javascript:confirm_address(<?php echo $p['UserAddress']['id'];?>)" class="radio" /><label for="<?php echo $p['UserAddress']['id'];?>"><?php echo $p['UserAddress']['name']?></label></td>
<td class="lan-name first"><?php echo $p['UserAddress']['address']?></td>
<td class="lan-name first"><?php echo $p['UserAddress']['regions']?></td>
</tr>
<?php }?>
<?php }?>
</table>
<?php }?>
</div>
<div id="address_loading" style="display:none;">
<h5><?php echo $SCLanguages['consignee'].$SCLanguages['information'];?>:</h5>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align="center">
	
<tr><td class="lan-name first">
<?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?>
</td></tr>
</table>
</div>
<!--End Address-->

<!--Shipping-->
<?php echo $form->create('carts',array('action'=>'/done','name'=>'cart_info','type'=>'POST'));?>
<div id="checkout_shipping" <?php if($all_virtual){?>style="display:none"<?php }?>>
	<?if($need_new_address == 0){?>
<?php if(isset($svcart['shipping']['shipping_fee'])){?>
<h5 id="address_btn_list">
<?php if(!isset($svcart['shipping']['not_show_change']) || $svcart['shipping']['not_show_change'] == '0'){?>
<a href="javascript:change_shipping();" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a>
<?php }?>
<?php echo $SCLanguages['shipping_method'];?>:</h5>
<?php echo $this->element('checkout_shipping_confirm', array('cache'=>'+0 hour'));?>
<?php }else if(isset($shippings)){?>
<h5 id="address_btn_list" <?php if($all_virtual){?>style="display:none"<?php }?>><?php echo $SCLanguages['shipping_method'];?>:</h5>
<?php echo $this->element('checkout_shipping', array('cache'=>array('key' => 'checkout_to_shipping', 'time' => '+0 hour')));?>
<?php }else{?>
<h5 id="address_btn_list" <?php if($all_virtual){?>style="display:none"<?php }?>><?php echo $SCLanguages['shipping_method'];?>:</h5>
<p class="border_b" style='margin:0 10px;' align='center'><br /><br /><b>
	<?php if(isset($shipping_type) && $shipping_type == 0){?>
	<?php echo $SCLanguages['edit_region_or_contact_cs'];?>
	<?php }else{?>
	<?php echo $SCLanguages['no_shipping_method'];?>
	<?php }?>
	</b><br /><br /><br /></p>
<?php }?>
<?}?></div>	
<div id="shipping_loading" style="display:none;">
<h5 id="address_btn_list"><?php echo $SCLanguages['shipping_method'];?>:</h5>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align="center">
	
<tr><td class="lan-name first">
<?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?>
</td></tr>
</table>
</div>	
</div>
<!--Shipping End-->

<!--Payment-->
<div id="payment">
	<?if($need_new_address == 0){?>
<?php if(isset($svcart['payment']['payment_fee'])){?>
<h5>
<?php if(!isset($svcart['payment']['not_show_change']) || $svcart['payment']['not_show_change'] == '0'){?>
<a href="javascript:change_payment()" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a>
<?php }?>
<?php echo $SCLanguages['payment'];?>:
</h5>
<?php echo $this->element('checkout_payment_confirm', array('cache'=>'+0 hour'));?>
<?php }else if(isset($payments) && sizeof($payments)>0){?>
<h5><?php echo $SCLanguages['payment'];?>:</h5>
<?php echo $this->element('checkout_payment', array('cache'=>array('key' => 'checkout_to_payment', 'time' => '+0 hour')));?>
<?php }else{?>
<h5><?php echo $SCLanguages['payment'];?>:</h5>
<p class="border_b" style='margin:0 10px;' align='center'><br /><br /><b><?php echo $SCLanguages['no_paying_method'];?></b><br /><br /><br /></p>
<?php }?><?}?>
</div>

<div id="payment_loading" style="display:none;">
<h5 id="address_btn_list"><?php echo $SCLanguages['payment'];?>:</h5>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align="center">
	
<tr><td class="lan-name first">
<?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?>
</td></tr>
</table>
</div>		
<!--Payment End-->

<!-- Points -->	
<div id="point">
<?php if($SVConfigs['enable_points'] == 1){?>
<?php if(isset($svcart['point']) && $svcart['point']['point'] > 0){?>
<h5>
<a href="javascript:change_point()" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a>
<?php echo $SCLanguages['use'].$SCLanguages['point'];?>: 
</h5>
<?php echo $this->element('checkout_point_confirm', array('cache'=>'+0 hour'));?>
<?php }else{?>
<h5><?php echo $SCLanguages['use'].$SCLanguages['point'];?>:</h5>
<?php echo $this->element('checkout_point', array('cache'=>'+0 hour'));?>
<?php }?>
<?php }?>	
</div>
<div id="point_loading" style="display:none;">
<h5 id="address_btn_list"><?php echo $SCLanguages['use'].$SCLanguages['point'];?>:</h5>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align="center">
	
<tr><td class="lan-name first">
<?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?>
</td></tr>
</table>
</div>		
<!--Points End -->

<!-- 优惠券使用 start -->	
<div id="coupon">
<?php if(isset($SVConfigs['use_coupons']) && $SVConfigs['use_coupons'] == 1){?>
<?php if(isset($svcart['coupon']['fee'])){?>
<h5>
<a href="javascript:change_coupon()" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a>
<?php echo $SCLanguages['use'].$SCLanguages['coupon'];?>:</h5>
<?php echo $this->element('checkout_coupon_confirm', array('cache'=>'+0 hour'));?>
<?php }else{?>
<h5><?php echo $SCLanguages['use'].$SCLanguages['coupon'];?>:</h5>
<?php echo $this->element('checkout_coupon', array('cache'=>'+0 hour'));?>
<?php }?>
<?php }?>	
</div>
<div id="coupon_loading" style="display:none;">
<h5 id="address_btn_list"><?php echo $SCLanguages['use'].$SCLanguages['coupon'];?>: </h5>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align="center">
	
<tr>
	<td class="lan-name first"><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></td>
</tr>
</table>
</div>		
	
 <!--优惠券使用 end --> 
 
<!-- order_note start -->	
<div id="order_note">

<?php if(isset($svcart['order_note'])){?>
<h5>
<span id="change_remark"><a href="javascript:change_remark()" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a></span>
<?php echo $SCLanguages['order'].$SCLanguages['remark'];?>: 
</h5>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice" style="width:97.8%;">
<tr class="list">
<td width="34%" height="25" valign="middle" class="bewrite">
	<div class="btn_list" style="padding-top:10px;">
		<p class="float_l" style="padding:1px 4px 0 20px;*margin-top:-2px;">
		<span id="order_note_value" >
		<?php echo $svcart['order_note']?>
		</span>
		<span id="order_note_textarea" style="display:none">
		<textarea name="order_note" id="order_note_add" class="green_border" style="width:340px;overflow-y:scroll;vertical-align:top" onblur="javascript:add_remark();" ><?php echo $svcart['order_note']?></textarea>
		</span>

		</p><br/><br/><br/><br/>
	<span id="remark_msg" style='padding:1px 4px 0 20px;*margin-top:-2px;color:red'></span>

	</div>
</td>
<td width="36%" height="25" valign="middle" class="handel">
<div valign="middle"  style="padding-left:20px;"><?php echo $SCLanguages['if_requirements_in_orders']?><br/><?php echo $SCLanguages['remark_here']?></div><br /><br/>
</td>
</tr>
</table>	
<?php }else{?>
<h5>
<span id="change_remark" style="display:none">
<a href="javascript:change_remark()" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a>
</span>
<?php echo $SCLanguages['order'].$SCLanguages['remark'];?>: 
</h5>
<?php echo $this->element('checkout_remark', array('cache'=>'+0 hour'));?>
<?php }?>
</div>
 <!--order_note end -->  
<h5><?php echo $SCLanguages['total'].$SCLanguages['amount'];?>:</h5>
<div id="checkout_total">
<?php if(isset($svcart)){?>
<?php echo $this->element('checkout_total', array('cache'=>'+0 hour'));?>
<?php }else{?>
<div class="item_price border">
<table style="width:auto;" align="right">
<tr>
	<td><?php echo $SCLanguages['products'].$SCLanguages['total'];?>:</td>
	<td align="right"><?php echo $svshow->price_format($svcart['cart_info']['sum_subtotal'],$SVConfigs['price_format']);?></td>
</tr>
<?php if(isset($svcart['shipping']['shipping_fee'])){?>
<tr>
	<td><?php echo $SCLanguages['shipping_fee'];?>:</td>
	<td align="right"><?php echo $svshow->price_format($svcart['shipping']['shipping_fee'],$SVConfigs['price_format']);?></td>
</tr>
<?php }?>

<?php if(isset($svcart['payment']['payment_fee'])){?>
<tr>
	<td><?php echo $SCLanguages['payment_fee'];?>:</td>
	<td><?php echo $svshow->price_format($svcart['payment']['payment_fee'],$SVConfigs['price_format']);?></td>
</tr>
<?php }?>

<?php if(isset($svcart['cart_info']['total'])){?>
<tr>
	<td class="sum_meny"><?php echo $SCLanguages['total'];?>:</td>
	<td><?php echo $svshow->price_format($svcart['cart_info']['total'],$SVConfigs['price_format']);?></td>
</tr>
<?php }?>
</table>
</div>
<?php }?>
</div>
	
<p class="Balance_btn"><input type="button" value="<?php echo $SCLanguages['confirm_2'];?>" onclick="javascript:checkout_order();" onfocus="blur()" /></p>
</div> 
<?php echo $form->end();?>
<div style="width:741px;margin:30px auto 10px;*margin:10px auto 0;">
<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>
</div>