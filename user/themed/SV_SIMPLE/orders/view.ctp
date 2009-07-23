<?php 
/*****************************************************************************
 * SV-CART 订单详细
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 1783 2009-05-26 09:35:54Z shenyunfeng $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Products_box">
<h3><span><?php echo $SCLanguages['order'].$SCLanguages['detail']?></span></h3>
<!--订单状态-->
<br />
<table cellpadding="5" cellspacing="1" class="table_data" width="100%">
<tr class="rows">
	<td width="15%"><?php echo $SCLanguages['order_code']?><strong>：</strong></td>
	<td width="85%"><?php echo $order_info['Order']['order_code']?> [
	<?php echo $html->link($SCLanguages['send'],'/messages/'.$order_info['Order']['id'],array(),false,false);?>
	/
	<?php echo $html->link($SCLanguages['view'].$SCLanguages['suppliers_message'],'/messages/'.$order_info['Order']['id'],array(),false,false);?>
	]</td>
</tr>
<tr class="rows">
	<td><?php echo $SCLanguages['order'].$SCLanguages['status']?><b>：</b></td>
	<td>
	<?php if($order_info['Order']['status'] == 0){?>
    <?php echo $systemresource_info['order_status']['0']?>
    <?php }?>
    <?php if($order_info['Order']['status'] == 1){?>
    <?php echo $systemresource_info['order_status']['1']?> <?php echo $order_info['Order']['confirm_time']?>
    <?php }?>
    <?php if($order_info['Order']['status'] == 2){?>
    <?php echo $systemresource_info['order_status']['2']?>
    <?php }?>
    <?php if($order_info['Order']['status'] == 3){?>
    <?php echo $systemresource_info['order_status']['3']?>
    <?php }?>
    <?php if($order_info['Order']['status'] == 4){?>
    <?php echo $systemresource_info['order_status']['4']?>
    <?php }?>
	</td>
</tr>
<tr class="rows">
	<td><?php echo $SCLanguages['pay'].$SCLanguages['status']?><b>：</b></td>
	<td>
    <?php if($order_info['Order']['payment_status'] == 0){?>
    <?php echo $systemresource_info['payment_status']['0']?>
    <?php }?>
    <?php if($order_info['Order']['payment_status'] == 1){?>
    <?php echo $systemresource_info['payment_status']['1']?>
    <?php }?>
    <?php if($order_info['Order']['payment_status'] == 2){?>
    <?php echo $systemresource_info['payment_status']['2']?>
    <?php }?>&nbsp;<?php echo $order_info['Order']['payment_time']?>&nbsp;<?php echo $order_info['Order']['payment_name']?>
	</td>
</tr>
<tr class="rows">
	<td><?php echo $SCLanguages['delivery_status']?><b>：</b></td>
	<td>
    <?php if($order_info['Order']['shipping_status'] == 0){?>
    <?php echo $systemresource_info['shipping_status']['0']?>
    <?php }?>
    <?php if($order_info['Order']['shipping_status'] == 1){?>
    <?php echo $systemresource_info['shipping_status']['1']?>
    <?php }?>
    <?php if($order_info['Order']['shipping_status'] == 2){?>
    <?php echo $systemresource_info['shipping_status']['2']?>
    <?php }?>			
    <?php if($order_info['Order']['shipping_status'] == 3){?>
    <?php echo $systemresource_info['shipping_status']['3']?>
    <?php }?>            	
	&nbsp;<?php echo $order_info['Order']['shipping_time']?>&nbsp;<?php echo $order_info['Order']['shipping_name']?>
	</td>
</tr>
<?php if(false){?>
<tr class="rows">
	<td><?php echo $SCLanguages['order']?><?php echo $SCLanguages['remark']?><b>：</b></td>
	<td><?php echo $order_info['Order']['note']?></td>
</tr>
<?php }?>
</table>
<br />
<!--订单状态 End-->	
<!-- 留言-->
<?php if(isset($my_messages) && sizeof($my_messages)>0){?>
<div id="Edit_box">
<div id="Edit_info" style="margin-top:5px;*margin-top:0;">
	  <p class="note article_title">
	  <b><?php echo $SCLanguages['message']?></b></p>
  <?php foreach($my_messages as $k=>$v){?>
  <div id="user_msg">
  	<p class="msg_title"><span class="title"><?php echo $v['UserMessage']['type']?>： <?php echo $v['UserMessage']['msg_title']?> <font color="#A7A9A8"><?php echo $v['UserMessage']['created']?></font></span></p>
    <p class="msg_txt"><span><?php echo $v['UserMessage']['msg_content']?></span></p>
  </div>
  <?php if(isset($v['Reply']) && sizeof($v['Reply'])>0){?>
     <?php foreach($v['Reply'] as $key=>$val){?>
  <div id="user_msg">
  	<p class="msg_title"><span class="title"><?php echo $SCLanguages['reply'];?>：<?php echo $val['UserMessage']['msg_title']?><font color="#A7A9A8"><?php echo $val['UserMessage']['created']?></font></span></p>
    <p class="msg_txt"><span><?php echo $val['UserMessage']['msg_content']?></span></p>
  </div>
     <?php }?>
  <?php }?>
  <?php }?>
</div>
</div>
<?php }?>	
<!-- 留言end-->	
<!--已购买的商品-->	
<table cellpadding="5" cellspacing="1" class="table_data" width="100%">
<tr>
	<td><strong><?php echo $SCLanguages['purchased_products']?></strong></td>
</tr>
<tr class="rows">
	<th><?php echo $SCLanguages['products'].$SCLanguages['apellation']?></th>
	<th><?php echo $SCLanguages['products'].$SCLanguages['attribute']?></th>
	<th><?php echo $SCLanguages['market_price']?></th>
	<th><?php echo $SCLanguages['our_price']?></th>
	<th><?php echo $SCLanguages['quantity']?></th>
	<th><?php echo $SCLanguages['subtotal']?></th>
</tr>
  <?php foreach($order_products as $k=>$v){?>
	  <tr class="rows">
	  <td align="center">
	  <p class="pic">
		<?php if($v['Product']['img_thumb'] != ""){?>
<?php echo $html->link($html->image("/../".$v['Product']['img_thumb'],array("width"=>"108","height"=>"108")),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?>
		<?php }else{?>
       	  <?php echo $html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?>
		<?php }?>	  	  
	  </p>
	  <p class="item_name">
       	  <?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false);?>	  	  
	  </p>
	  </td>
	  <td><?php echo $v['OrderProduct']['product_attrbute']?></td>
	  <td align='center'><?php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?></td>
	  <td align='center'>
	  <?php //if($v['Product']['promotion_status'] == 1){?><?php //echo $v['Product']['promotion_price']?><?php //}else{?><?php //echo $v['Product']['shop_price']?><?php //}?>
	  <?php echo $svshow->price_format($v['OrderProduct']['product_price'],$SVConfigs['price_format']);?>
	  </td>
	  <td align='center'><?php echo $v['OrderProduct']['product_quntity']?></td>
	  <td align='center'><?php echo $svshow->price_format($v['OrderProduct']['one_pro_subtotal'],$SVConfigs['price_format']);?></td>
	</tr>
	<?php if(isset($virtual_card[$v['Product']['id']])){?>
	<?php foreach($virtual_card[$v['Product']['id']] as $vv){?>
	<tr class="cardnumber color_67">
		  <td colspan="6">
		  <?php echo $SCLanguages['card_number']?>:<?php echo $vv['card_sn'];?>
		  <?php echo $SCLanguages['password']?>:<?php echo $vv['card_password'];?>
	      <?php echo $SCLanguages['expiration_date']?>:<?php echo $vv['end_date'];?>
		  </td>
	</tr>
	<?php }?>
	<?php }?>
  <?php }?>
 <?php if(isset($card) && sizeof($card)>0){?>
  <?php foreach($card as $k=>$v){?>
	  <tr class="rows">
	  <td class="name">
	  <p>
	<?php if($v['Card']['img01'] != ""){?>
    <?php echo $html->link($html->image("/../".$v['Card']['img01'],array("width"=>"108","height"=>"108")),"/#",array(),false,false);?>
	<?php }else{?>
    <?php echo $html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),"/#",array(),false,false);?>
	<?php }?>	  	  
	  </p>
	  <p><?php echo $html->link($v['CardI18n']['name'],"#",array(),false,false);?></p>
	  </td>
	  <td><?php echo $v['Card']['note']?></li>
	  <td><?php echo $svshow->price_format($v['Card']['fee'],$SVConfigs['price_format']);?></li>
	  <td>
	  <?php //if($v['Product']['promotion_status'] == 1){?><?php //echo $v['Product']['promotion_price']?><?php //}else{?><?php //echo $v['Product']['shop_price']?><?php //}?>
	  	  <?php echo $svshow->price_format($v['Card']['fee'],$SVConfigs['price_format']);?>
	  </td>
	  <td><?php echo $v['Card']['quntity']?></td>
	 <td><?php echo $svshow->price_format($v['Card']['fee']*$v['Card']['quntity'],$SVConfigs['price_format']);?></td>
	</tr>
  <?php }?>
<?php }?>
<?php if(isset($packaging) && sizeof($packaging)>0){?>
  <?php foreach($packaging as $k=>$v){?>
	  <tr class="rows">
	  <td>
	  <p>
		<?php if($v['Packaging']['img01'] != ""){?>
       	<?php echo $html->link($html->image("/../".$v['Packaging']['img01'],array("width"=>"108","height"=>"108")),"/#",array(),false,false);?>
		<?php }else{?>
       	<?php echo $html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),"/#",array(),false,false);?>
		<?php }?>	  	  
	  </p>
	  <p><?php echo $html->link($v['PackagingI18n']['name'],"#",array(),false,false);?></p>
	  </td>
	  <td><?php echo $v['Packaging']['note']?></td>
	  <td><?php echo $svshow->price_format($v['Packaging']['fee'],$SVConfigs['price_format']);?></td>
	  <td>
	  <?php //if($v['Product']['promotion_status'] == 1){?><?php //echo $v['Product']['promotion_price']?><?php //}else{?><?php //echo $v['Product']['shop_price']?><?php //}?>
	  <?php echo $svshow->price_format($v['Packaging']['fee'],$SVConfigs['price_format']);?>
	  </td>
	  <td class="number"><?php echo $v['Packaging']['quntity']?></td>
	  <td class="subtotal"><?php echo $svshow->price_format($v['Packaging']['fee']*$v['Packaging']['quntity'],$SVConfigs['price_format']);?></td>
	 </tr>
  <?php }?>
<?php }?>
<tr class="rows">
	<td colspan="6">
	<p class="saves_many"><?php echo $SCLanguages['amount'].$SCLanguages['subtotal']?>
		<?php //echo $order_info['Order']['subtotal']?>
		<?php echo $svshow->price_format($shop_subtotal,$SVConfigs['price_format']);?>
		<?php if($order_info['Order']['save_price'] >0){?>
		，<font color="#FE5F01"><?php echo $SCLanguages['market_price']?>
		<?php echo $svshow->price_format($order_info['Order']['market_subtotal'],$SVConfigs['price_format']);?>
		<?php echo $SCLanguages['saved']?> 
		<?php echo $svshow->price_format($order_info['Order']['save_price'],$SVConfigs['price_format']);?>
		(<?php echo (100-$order_info['Order']['discount_price'])?>%)
		<?php }?></font>
	</p>	
	</td>
</tr>
</table>
<br />
<!--已购买的商品 End-->

<!--收货人信息-->

        	<table cellpadding="5" cellspacing="1" class="table_data" width="100%">
        	<tr>
			<td><strong><?php echo $SCLanguages['consignee']?></strong></td>
			</tr>
			<tr class="rows">
			<td width="15%"><?php echo $SCLanguages['consignee']?>:</td>
			<td width="35%"><?php if($order_info['Order']['consignee']) echo $order_info['Order']['consignee']; else echo "&nbsp;";?></td>
    		<td width="15%"><?php echo $SCLanguages['region']?>:</td>
    		<td width="35%"><?php echo $order_info['Order']['regions']?>&nbsp;</td>
    		</tr>
    		<tr class="rows">
			<td><?php echo $SCLanguages['email']?>:</li>
			<td><?php if($order_info['Order']['email']) echo $order_info['Order']['email'];else echo "&nbsp;"; ?></td>
			<?php if(empty($all_virtual)){?>
			<td><?php echo $SCLanguages['address']?>:</td>
			<td><?php if($order_info['Order']['address'])echo $order_info['Order']['address'];else echo "&nbsp;";?></td>
			</tr>
			<tr class="rows">
			<td><?php echo $SCLanguages['post_code']?>:</td>
			<td><?php if($order_info['Order']['zipcode']) echo $order_info['Order']['zipcode'];else echo "&nbsp;";?></td>
			<?php }?>
			<td><?php echo $SCLanguages['telephone']?>:</td>
			<td><?php if($order_info['Order']['telephone']) echo $order_info['Order']['telephone'];else echo "&nbsp;";?></td>
			</tr>
			<tr class="rows">
			<td><?php echo $SCLanguages['mobile']?>:</td>
			<td><?php if($order_info['Order']['mobile']) echo $order_info['Order']['mobile'];else echo "&nbsp;";?></td>
			<td></td>
			<td></td>
			</tr>
			<?php if(empty($all_virtual)){?>
			<tr class="rows">
			<td><?php echo $SCLanguages['marked_building']?>:</td>
			<td><?php if($order_info['Order']['sign_building']) echo $order_info['Order']['sign_building'];else echo "&nbsp;";?></td>
			
			<td><?php echo $SCLanguages['best_shipping_time']?>:</td>
			<td><?php if($order_info['Order']['best_time']) echo $order_info['Order']['best_time'];else echo "&nbsp;";?></td>
			<?php }?>
			</tr>
			</table>
        
<!--收货人信息 End-->
<br />


<!-- 其他 -->
<?php if(isset($show_note) && $show_note == 1){?>
<table cellpadding="5" cellspacing="1" class="table_data" width="100%">
<tr>
	<td><strong><?php echo $SCLanguages['others']?></strong></td>
</tr>
<?php if($order_info['Order']['note']){?>
<tr class="rows">
	<td width="15%"><?php echo $SCLanguages['order']?><?php echo $SCLanguages['remark']?>:</td>
	<td width="85%"><?php echo $order_info['Order']['note']?></td>
	
</tr>
<?php }?>

<?php if(isset($packaging) && sizeof($packaging)>0){?>
<?php foreach($packaging as $k=>$v){?>
<tr class="rows">
  <?php if($v['Packaging']['note'] != ""){?>
  <td><?php echo $SCLanguages['packaging']?><?php echo $SCLanguages['remark']?>:</td>
  <td><?php echo $v['Packaging']['note']?></td>
<?php }?>
</tr>
<?php }?>
<?php }?>

<?php if(isset($card) && sizeof($card)>0){?>
<?php foreach($card as $k=>$v){?>
<tr>
	<?php if($v['Card']['note'] != ""){?>
	<td><?php echo $SCLanguages['card']?><?php echo $SCLanguages['remark']?>:</td>
	<td><?php echo $v['Card']['note']?></td>
<?php }?>
</tr>
<?php }?>
<?php }?>
</table>
<br />
<?php }?>

<!--订单小计-->	
<table cellpadding="5" cellspacing="1" class="table_data" width="100%">
<tr>
	<td><strong><?php echo $SCLanguages['amount']?><?php echo $SCLanguages['subtotal']?></strong></td>
</tr>
<tr class="rows">
	<td width="15%"><?php echo $SCLanguages['total_order_value']?>:</td>
	<td width="35%"><?php echo $svshow->price_format($order_info['Order']['total'],$SVConfigs['price_format']);?></td>
	<td width="15%"><?php echo $SCLanguages['products']?><?php echo $SCLanguages['subtotal']?>:</td>
	<td width="35%"><?php echo $svshow->price_format($shop_subtotal,$SVConfigs['price_format']);?></td>
</tr>

<tr class="rows">
		<td><?php echo $SCLanguages['card_fee']?>:</td>
	  	<td><?php echo $svshow->price_format($order_info['Order']['card_fee'],$SVConfigs['price_format']);?></td>
		<td><?php echo $SCLanguages['package_fee']?>:</td>
	  	<td><?php echo $svshow->price_format($order_info['Order']['pack_fee'],$SVConfigs['price_format']);?></td>
</tr>

<?php if(isset($order_info['Order']['shipping_fee'])){?>
<tr class="rows">
	<td><?php echo $SCLanguages['shipping_fee']?>: </td>
	<td><?php echo $svshow->price_format($order_info['Order']['shipping_fee'],$SVConfigs['price_format']);?></td>
	
	<td><?php echo $SCLanguages['support_value_fee']?>:</td>
	<td><?php echo $svshow->price_format($order_info['Order']['insure_fee'],$SVConfigs['price_format']);?></td>
	<?php if($order_info['Order']['insure_fee'] >0){?><?php }?>
</tr>
<?php }?>
<tr class="rows">
		<td><?php echo $SCLanguages['payment_fee']?>: </td>
	  	<td><?php echo $svshow->price_format($order_info['Order']['payment_fee'],$SVConfigs['price_format']);?></td>
		<td><?php echo $SCLanguages['use']?><?php echo $SCLanguages['point']?>: </td>
	  	<td><?php echo $order_info['Order']['point_use'];?><?php echo $SCLanguages['point_unit'];?><?php echo $SCLanguages['save_to_market_price'];?><?php echo $svshow->price_format($order_info['Order']['point_fee'],$SVConfigs['price_format']);?></td>
</tr>

<?php if(isset($coupon_fee)){?>
<tr class="rows">
		<td><?php echo $SCLanguages['use']?><?php echo $SCLanguages['coupon']?>: </td>
	  	<td><?php echo $svshow->price_format($coupon_fee,$SVConfigs['price_format']);?></td>
	  	<?php if(isset($coupon_discount) && $coupon_discount <100){?>
	  	<td><?php echo $SCLanguages['coupon']?><?php echo $SCLanguages['discount']?>:</td>
	  	<td><?php echo (100- $coupon_discount)?>%&nbsp;</td>
	  	<?php }?>
</tr>
<?php }?>
<tr class="rows">
		<td><?php echo $SCLanguages['order']?><?php echo $SCLanguages['discount']?>: </td>
	  	<td><?php echo $svshow->price_format($order_info['Order']['discount'],$SVConfigs['price_format']);?></td>
		<?php if(isset($balance_log['UserBalanceLog']['amount'])){?>
		<td><?php echo $SCLanguages['use']?><?php echo $SCLanguages['balance']?>:</td>
	  	<td><?php echo $svshow->price_format(($balance_log['UserBalanceLog']['amount']*-1),$SVConfigs['price_format']);?></td>
		<?php }else{?>
		<td><?php echo $SCLanguages['use']?><?php echo $SCLanguages['balance']?>:</td>
		<td><?php echo $svshow->price_format('0',$SVConfigs['price_format']);?></td>
		<?php }?>
</tr>
<tr class="rows">
		<td><?php echo $SCLanguages['paid'].$SCLanguages['amount']?>:</td>
	  	<td><?php echo $svshow->price_format($order_info['Order']['money_paid'],$SVConfigs['price_format']);?></td>
		
		<td><?php echo $SCLanguages['payable_amount']?>: </td>
	  	<td><?php echo $svshow->price_format($order_info['Order']['need_paid'],$SVConfigs['price_format']);?></td>
</tr>
		
<?php if($order_info['Order']['status'] < 2 && $order_info['Order']['payment_status'] != 2  && $order_info['Order']['payment_status'] != 2){?>
<tr class="rows">
	<td colspan="4" align="center">
	<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
	<?php echo $form->create('orders',array('action'=>'order_pay','name'=>'order_pay1','type'=>'POST'));?>
	<input type="hidden" name='id' value="<?php echo $order_info['Order']['id']?>">
	<input type="hidden" name='act' value="view">
		<?if(isset($url_format)){?>
		<?=$url_format?>
		<?}elseif(isset($pay_message)){?>
		<?=$pay_message?>
		<?}?>
		
	<?php echo $form->end();?>
	<?php }else{?>
	<span class="button float_left">             
	<a href="javascript:order_pay(<?php echo $order_info['Order']['id']?>,<?php echo $order_info['Order']['status']?>,'<?php echo $SCLanguages['order_not_paid'];?>');"><?php echo $SCLanguages['pay']?></a></span>
	<?php }?>
	</td>
</tr>
<?php }?>
</table>
<!--订单小计 End-->







<!--支付方式-->	
<div id="Edit_box" style="display:none">
<div id="Edit_info" style="margin-top:5px;*margin-top:0;">
<p class="note article_title btn_list"><b><?php echo $SCLanguages['payment']?></b>
<?php if ($order_info['Order']['status'] == 0){?>	  
<span class="amenber_balances"><!--cite style="cursor:pointer;"><a id="editpayment"><?php echo $SCLanguages['edit']?></a></cite--></span></p>
<?php }?>
<?php if($order_info['Order']['payment_status'] != 2 && $order_info['Order']['status'] < 2){?>
	  <?php foreach($payment_list as $k=>$v){?>
	  <?php if($v['Payment']['id'] != $order_info['Order']['payment_id'] && $v['PaymentI18n']['status'] == 1){
	  $is_show = 1;	  
	  }?>
<?php }?>	
<!--修改支付方式-->
<?php if(isset($is_show) && $is_show == 1){?>
<div id="edit_payment" style="border:1px solid #fff">
  <div id="Edit_info" style="width:588px;background:#fff;border:1px solid #fff">
	  <p class="balances">
	  <?php foreach($payment_list as $k=>$v){?>
	  <?php if($v['Payment']['id'] != $order_info['Order']['payment_id'] && $v['PaymentI18n']['status'] == 1){?>
	    <input class="radio" type="radio" name="pay_ment" id="pay_ment" value="<?php echo $v['Payment']['id']?>" onclick="change_payment(this.value,<?php echo $order_info['Order']['id']?>);"><?php echo $v['PaymentI18n']['name']?>
	  <?php }?>
  	  <?php }?>
	  </p>
	  <br />
	  <br />
	</div>
</div>
<!--修改支付方式 End-->
<?php }}?>	  
	  <p class="balances"><?php echo $SCLanguages['payment']?>:<b><?php echo $order_info['Order']['payment_name']?></b>。<?php echo $SCLanguages['payable_amount']?>:
	  	  <b><?php echo $svshow->price_format($order_info['Order']['total'],$SVConfigs['price_format']);?></b>
	  	  <br /><?php //=$SCLanguages['delivery_versus_payment']?></p>
	</div>
</div>
<!--支付方式 End-->
  </div>


