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
 * $Id: checkout.ctp 3160 2009-07-21 10:43:24Z huangbo $
*****************************************************************************/
?>
<?php //pr($address);?>
<?php echo $form->create('carts',array('action'=>'/done','name'=>'cart_info','type'=>'POST'));?>
<div class="mainbox">
<h3><span><?php echo $SCLanguages['checkout_center'];?></span></h3>
<div class="checkout">
<h5><?php echo $SCLanguages['consignee'].$SCLanguages['information'];?></h5>
<div class="box consignee">
<dl><dt><?php echo $SCLanguages['consignee'];?>:</dt>
	<dd><input type="text" value="<?php if(isset($address['UserAddress']['consignee']))echo $address['UserAddress']['consignee'];?>"></dd></dl>
<dl><dt><?php echo $SCLanguages['country']."/".$SCLanguages['region'];?>:</dt>
	<dd><?php if(isset($_SESSION['svcart']['address']['regionI18n']))echo $_SESSION['svcart']['address']['regionI18n'];?></dd></dl>
<dl><dt><?php echo $SCLanguages['consignee'].$SCLanguages['address'];?>:</dt>
	<dd><input type="text" name="address" value="<?php if(isset($address['UserAddress']['address']))echo $address['UserAddress']['address'];?>"></dd></dl>
<dl><dt><?php echo $SCLanguages['post_code'];?>:</dt>
	<dd><input type="text" name="zipcode" value="<?php if(isset($address['UserAddress']['zipcode']))echo $address['UserAddress']['zipcode'];?>"></dd></dl>
<dl><dt><?php echo $SCLanguages['telephone'];?>:</dt>
	<dd><input type="text" name="telephone" value="<?php if(isset($address['UserAddress']['telephone']))echo $address['UserAddress']['telephone'];?>"></dd>
</dl>
</div>
</div>
	
<div class="checkout">
<h5><?php echo $SCLanguages['shipping_method'];?></h5>
<div class="box shipping">
<?php if(isset($shippings)&&sizeof($shippings)>0){?>
<?$num=0;?>
<?php foreach($shippings as $k=>$v){?>
	<p><input type="radio" onclick="javascript:to_confirm_shipping(<?php echo $v['ShippingArea']['fee']; ?>,0,<?=$v['Shipping']['support_cod']?>);"
 <?if(isset($svcart['shipping']['shipping_id']) && $v['Shipping']['id'] ==$svcart['shipping']['shipping_id']){?>checked="checked"<?}?>		
		 id="shipping_id_<?=$num?>" name="shipping_id" class="radio" value="<?php echo $v['Shipping']['id'];?>" 
		<?php 
	if(isset($svcart['shipping']['shipping_id']) && $svcart['shipping']['shipping_id'] == $v['Shipping']['id']){
		echo "checked";}?>><?php echo $v['ShippingI18n']['name'];?>&nbsp;&nbsp;<?php echo $v['ShippingI18n']['description'];?></p>		
				<input type="hidden" value="<?=$v['ShippingArea']['fee']?>" name="order_shipping_fee_<?=$num?>" id="order_shipping_fee_<?=$num?>"  />
				<input type="hidden" value="<?=$v['ShippingArea']['free_subtotal']?>" name="order_shipping_free_<?=$num?>" id="order_shipping_free_<?=$num?>"  />
				<input type="hidden" value="<?=$v['Shipping']['support_cod']?>" name="order_shipping_support_cod_<?=$num?>" id="order_shipping_support_cod_<?=$num?>"  />
<?$num++;?>
<?php }?>
<?php }else{?>
	<p><?php echo $SCLanguages['no_shipping_method'];?></p>	

<?php }?>
</div>
</div>
<div class="checkout">
<h5><?php echo $SCLanguages['payment'];?></h5>
<div class="box payment">
<?php if(isset($payments) && sizeof($payments)>0){?>
<?$abc=0;?>
<?php foreach($payments as $k=>$v){ ?>
<?if(($_SESSION['User']['User']['balance'] >= $svcart['cart_info']['total']) || $v['Payment']['code'] !="account_pay"){?>
<p><span class="shading">
	
	<input type="radio"  onclick="javascript:to_confirm_payment(<?=$v['Payment']['fee']?>,<?=$v['Payment']['is_cod']?>)" id="payment_id_<?=$abc?>" name="payment_id" class="radio" value="<?php echo $v['Payment']['id']; ?>"	
	<?php 
	if(isset($svcart['payment']['payment_id']) && $svcart['payment']['payment_id'] == $v['Payment']['id']){
		echo "checked";
	}?>  >
		<input type="hidden" value="<?=$v['Payment']['fee']?>" name="order_payment_fee_<?=$k?>" id="order_payment_fee_<?=$abc?>"  />
		<input type="hidden" value="<?=$v['Payment']['is_cod']?>" name="order_payment_is_cod_<?=$k?>" id="order_payment_is_cod_<?=$abc?>"  /><?$abc++;?>
		<?php echo $v['PaymentI18n']['name'];?></span><span class="description"><?php echo $v['PaymentI18n']['description'];?></span></p>
<?}?>
<?php } ?>
<?php } ?>
</div>
</div>
	
<div class="checkout">
<h5><?php echo $SCLanguages['products'].$SCLanguages['all_list'];?></h5>
<p class="business"><?php echo $SCLanguages['business'];?>：<strong>SEEWORLDS</strong></p>
<div class="order_table cont">
<span class="left_up">&nbsp;</span><span class="right_up">&nbsp;</span>
<span class="left_down">&nbsp;</span><span class="right_down">&nbsp;</span>
<ul class="table_row">
<li class="name"><?php echo $SCLanguages['products'].$SCLanguages['apellation'];?></li>
<li class="price"><?php echo $SCLanguages['market_price'];?></li>
<li class="price"><?php echo $SCLanguages['our_price'];?></li>
<li class="number"><?php echo $SCLanguages['quantity'];?></li>
<li class="subtotal"><?php echo $SCLanguages['subtotal'];?></li>
</ul>
<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0){?>
<?php foreach($svcart['products'] as $i=>$p){?>
<ul class="table_row table_cell">
<li class="name"><?php echo $html->link($p['ProductI18n']['name'],$svshow->sku_product_link($i,$p['ProductI18n']['name'],$p['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?></li>
<li class="price"><?php echo $svshow->price_format($p['Product']['market_price'],$SVConfigs['price_format']);?></li>
<li class="price"><?php echo $svshow->price_format($p['Product']['shop_price'],$SVConfigs['price_format']);?>	</li>
<li class="number"><?php echo  $p['quantity'];?></li>
<li class="subtotal"><?php echo $svshow->price_format($p['subtotal'],$SVConfigs['price_format']);?></li>
</ul>
<?php }?>
<?php }?>
</div>
	
<div class="total"><?php echo $SCLanguages['products'].$SCLanguages['amount'].$SCLanguages['total'];?>：<?php echo $svshow->price_format($svcart['cart_info']['sum_subtotal'],$SVConfigs['price_format']);?></div>

<div class="total" id="total_shipping" style="display:none;"><?php echo $SCLanguages['shipping_fee'];?>：<span id="shipping_fee"></span></div>
<div class="total" id="total_payment" style="display:none"><?php echo $SCLanguages['payment_fee'];?>：<span id="payment_fee"></span></div>

<div class="order_total"><?php echo $SCLanguages['payable_amount'];?>：<span id="order_total_fee"><?php echo $svshow->price_format($svcart['cart_info']['total'],$SVConfigs['price_format']);?></span></div>
		<input type='hidden' name="fee_total" id="fee_total" value="<?=$svcart['cart_info']['total']?>" />
<input type="hidden" name="this_shipping_fee" id="this_shipping_fee" value="0" /><input type="hidden" name="this_payment_fee" id="this_payment_fee" value="0" />	
</div><input type="hidden" name="no_ajax" value="0" />
<div class="submitform"><span class="button"><input type="button" name="checkout" onclick="javascript:submitorder();" value="<?php echo $SCLanguages['checkout'];?>"></span></div>
</div>
</div>
<?php echo $form->end();?>
<script>
	var  price_format = "<?php echo $SVConfigs['price_format'];?>";
	checked_order();
	function to_confirm_shipping(fee,free,type){
		document.getElementById('total_shipping').style.display = '';
		document.getElementById('shipping_fee').innerHTML = price_format.replace("%s", fee);
		if(free != 0 && "<?=$svcart['cart_info']['total']?>" >= free){
			fee = 0;
		}
		document.getElementById('fee_total').value = fee*1+(document.getElementById('fee_total').value)*1-(document.getElementById('this_shipping_fee').value)*1;
		document.getElementById('this_shipping_fee').value =fee*1;
		document.getElementById('order_total_fee').innerHTML =  price_format.replace("%s", 	document.getElementById('fee_total').value);
			if(type == 0){
			 		var ii = 0;
					while(true){
						if(document.getElementById('payment_id_'+ii)==null){
							break;
						}
						if(document.getElementById('order_payment_is_cod_'+ii).value == '1'){
							document.getElementById('payment_id_'+ii).disabled = "1";
						}else{
							document.getElementById('payment_id_'+ii).disabled = false;
						}						

						ii++;
			 		} 		
			}else{
			 		var ii = 0;
					while(true){
						if(document.getElementById('payment_id_'+ii)==null){
							break;
						}

							document.getElementById('payment_id_'+ii).disabled = false;
						ii++;
			 		} 			
			}
	}
	
	function to_confirm_payment(fee,type){
		document.getElementById('total_payment').style.display = '';
		document.getElementById('payment_fee').innerHTML = price_format.replace("%s", fee);
		document.getElementById('fee_total').value = fee*1+(document.getElementById('fee_total').value)*1-(document.getElementById('this_payment_fee').value)*1;;
		document.getElementById('this_payment_fee').value = fee*1;
		document.getElementById('order_total_fee').innerHTML =  price_format.replace("%s", 	document.getElementById('fee_total').value);
		
				if(type == 1){
			 		var ii = 0;
					while(true){
						if(document.getElementById('shipping_id_'+ii)==null){
							break;
						}
						if(document.getElementById('order_shipping_support_cod_'+ii).value == '0'){
							document.getElementById('shipping_id_'+ii).disabled = "1";
						}else{
							document.getElementById('shipping_id_'+ii).disabled = false;
						}
						ii++;
			 		} 		
					
				}else{
			 		var ii = 0;
					while(true){
						if(document.getElementById('shipping_id_'+ii)==null){
							break;
						}
							document.getElementById('shipping_id_'+ii).disabled = false;
						ii++;
			 		} 						
				
				}		
		
	}	
	
	function checked_order(){
		document.getElementById('fee_total').value = "<?=$svcart['cart_info']['total']?>";
		document.getElementById('this_shipping_fee').value =0;
		document.getElementById('this_payment_fee').value = 0;
		var i =0;
		var ii =0;
		while(true){
			if(document.getElementById('payment_id_'+i)==null){
				break;
			}
			if(document.getElementById('payment_id_'+i).checked ){
				//payment = 1;
				to_confirm_payment(document.getElementById('order_payment_fee_'+i).value,document.getElementById('order_payment_is_cod_'+i).value);

			}
			i++;
 		}
 		
 		var ii = 0;
		while(true){
			if(document.getElementById('shipping_id_'+ii)==null){
				break;
			}
			if(document.getElementById('shipping_id_'+ii).checked){
				to_confirm_shipping(document.getElementById('order_shipping_fee_'+ii).value,document.getElementById('order_shipping_free_'+ii).value,document.getElementById('order_shipping_support_cod_'+ii).value);
			}
			ii++;
 		} 		
 		
 		
	}
	
	function submitorder(){
		var payment = 0;
		var shipping = 0;
		var i =0;
		while(true){
			if(document.getElementById('payment_id_'+i)==null){
				break;
			}
			if(document.getElementById('payment_id_'+i).checked ){
				payment = 1;
			}
			i++;
 		}
 		var ii = 0;
		while(true){
			if(document.getElementById('shipping_id_'+ii)==null){
				break;
			}
			if(document.getElementById('shipping_id_'+ii).checked){
				shipping = 1;
			}
			ii++;
 		}
 		if(shipping == 0){
 			alert(please_choose_shipping);
 			return;
 		}
 		if(payment == 0){
 			alert(please_choose_payment);
 			return;
 		} 		
 		document.forms.cart_info.submit();		
	}	
	
</script>
	
	