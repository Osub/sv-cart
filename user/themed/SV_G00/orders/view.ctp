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
 * $Id: view.ctp 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Products_box">
    	<h1><span><?=$SCLanguages['order'].$SCLanguages['detail']?></span></h1>
<!--订单状态-->
        <div id="infos" style="width:739px;">
        	<dl class="order_state">
				<dt><?=$SCLanguages['order_code']?><b>：</b></dt><dd><?echo $order_info['Order']['order_code']?> [
	<?=$html->link($SCLanguages['send'],'/messages/'.$order_info['Order']['id'],array(),false,false);?>
	/
	<?=$html->link($SCLanguages['view'].$SCLanguages['suppliers_message'],'/messages/'.$order_info['Order']['id'],array(),false,false);?>
	]</dd>
				<dt><?=$SCLanguages['order'].$SCLanguages['status']?><b>：</b></dt><dd>
	        <?if($order_info['Order']['status'] == 0){?>
            <?=$SCLanguages['unconfirmed']?>
            <?}?>
           	<?if($order_info['Order']['status'] == 1){?>
            <?=$SCLanguages['has_confirmed']?> <?=$order_info['Order']['confirm_time']?>
            <?}?>
            <?if($order_info['Order']['status'] == 2){?>
            <?=$SCLanguages['has_been_canceled']?>
            <?}?>
            <?if($order_info['Order']['status'] == 3){?>
            <?=$SCLanguages['invalid']?>
            <?}?>
            <?if($order_info['Order']['status'] == 4){?>
            <?=$SCLanguages['return']?>
            <?}?>
			</dd>
			<dt><?=$SCLanguages['pay'].$SCLanguages['status']?><b>：</b></dt><dd>
            <?if($order_info['Order']['payment_status'] == 0){?>
            <?=$SCLanguages['unpaid']?>
            <?}?>
           	<?if($order_info['Order']['payment_status'] == 1){?>
            <?=$SCLanguages['paying']?>
            <?}?>
            <?if($order_info['Order']['payment_status'] == 2){?>
            <?=$SCLanguages['paid']?>
            <?}?>&nbsp;<?=$order_info['Order']['payment_time']?>&nbsp;<?echo $order_info['Order']['payment_name']?>
		</dd>
				<dt><?=$SCLanguages['delivery_status']?><b>：</b></dt><dd >
            <?if($order_info['Order']['shipping_status'] == 0){?>
            <?=$SCLanguages['undelivered']?>
            <?}?>
           	<?if($order_info['Order']['shipping_status'] == 1){?>
            <?=$SCLanguages['delivered']?>
            <?}?>
            <?if($order_info['Order']['shipping_status'] == 2){?>
            <?=$SCLanguages['stocking']?>
            <?}?>			
			&nbsp;<?=$order_info['Order']['shipping_time']?>&nbsp;<?echo $order_info['Order']['shipping_name']?></dd>
<!--其他信息-->	
	  <dt><?if($order_info['Order']['note']){?><?=$SCLanguages['order']?><?=$SCLanguages['remark']?><b>：</b></dt><dd style="border:0;"><?echo $order_info['Order']['note']?></dd>
	    <?}?>
<!--其他信息 End-->
		</dl>
        </div> 
<!--订单状态 End-->	
<!-- 留言-->
  <?if(isset($my_messages) && sizeof($my_messages)>0){?>
	<div id="Edit_box">
  <div id="Edit_info" style="width:739px;margin-top:5px;*margin-top:0;">
	  <p class="note article_title">
	  <b><?=$SCLanguages['message']?></b></p>
  <?foreach($my_messages as $k=>$v){?>
  <div id="user_msg">
  	<p class="msg_title"><span class="title"><?echo $v['UserMessage']['type']?>： <?echo $v['UserMessage']['msg_title']?> <font color="#A7A9A8"><?echo $v['UserMessage']['created']?></font></span></p>
    <p class="msg_txt"><span><?echo $v['UserMessage']['msg_content']?></span></p>
  </div>
  <?if(isset($v['Reply']) && sizeof($v['Reply'])>0){?>
     <?foreach($v['Reply'] as $key=>$val){?>
  <div id="user_msg">
  	<p class="msg_title"><span class="title"><?=$SCLanguages['reply'];?>：<?echo $val['UserMessage']['msg_title']?><font color="#A7A9A8"><?echo $val['UserMessage']['created']?></font></span></p>
    <p class="msg_txt"><span><?echo $val['UserMessage']['msg_content']?></span></p>
  </div>
     <?}?>
  <?}?>
  <?}?>
  
		</div></div><?}?>	
<!-- 留言end-->	
<!--已购买的商品-->	
	<div id="Edit_box">
  <div id="Edit_info" style="width:739px;margin-top:5px;*margin-top:0;">
	  <p class="note article_title">
	  <b><?=$SCLanguages['purchased_products']?></b></p>
	  <ul class="already_shop"><li class="name" style="text-align:right;"><span><?=$SCLanguages['products'].$SCLanguages['apellation']?></span></li><li class="profile"><?=$SCLanguages['products'].$SCLanguages['attribute']?></li><li class="marke_price"><?=$SCLanguages['market_price']?></li><li class="shop_price"><?=$SCLanguages['our_price']?></li><li class="number"><?=$SCLanguages['quantity']?></li><li class="subtotal"><?=$SCLanguages['subtotal']?></li></ul>
	  <div class="already_box">
  <?foreach($order_products as $k=>$v){?>
	  <ul class="already_shop already_list">
	  <li class="name">
	  <p class="pic">
			<?if($v['Product']['img_thumb'] != ""){?>
       	  <?=$html->link($html->image("/../".$v['Product']['img_thumb'],array("width"=>"108","height"=>"108")),"/../products/".$v['Product']['id'],array(),false,false);?>
			<?}else{?>
       	  <?=$html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),"/../products/".$v['Product']['id'],array(),false,false);?>
			 <?}?>	  	  
	  </p>
	  <p class="item_name">
       	  <?=$html->link($v['ProductI18n']['name'],"/../products/".$v['Product']['id'],array(),false,false);?>	  	  
	  </p>
	  </li><li class="profile"><?echo $v['OrderProduct']['product_attrbute']?></li>
	  	  <li class="marke_price">
	  	  <?=$svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>
	  	  </li>
	  	  <li class="shop_price">
	  	  <?//if($v['Product']['promotion_status'] == 1){?><?//echo $v['Product']['promotion_price']?><?//}else{?><?//echo $v['Product']['shop_price']?><?//}?>
	  	  <?=$svshow->price_format($v['OrderProduct']['product_price'],$SVConfigs['price_format']);?>
	  	  </li>
	  	  <li class="number"><?echo $v['OrderProduct']['product_quntity']?></li><li class="subtotal">
	  	  <?=$svshow->price_format($v['OrderProduct']['one_pro_subtotal'],$SVConfigs['price_format']);?>
	  	  	  </li></ul>
	  	  <?if(isset($virtual_card[$v['Product']['id']])){?>
	  	  <div class="cardnumber color_67">
	  	  	  <?foreach($virtual_card[$v['Product']['id']] as $vv){?>
	  	  	  <div>
	  	  	  <?//=$SCLanguages['card_sn']?>卡号:<?php echo $vv['card_sn'];?>
	  	  	  <?=$SCLanguages['password']?>:<?php echo $vv['card_password'];?>
	  	  	  <?//=$SCLanguages['end_date']?>有效期限:<?php echo $vv['end_date'];?>
	  	  	  </div>
	  	  	  <?}?>
	  	  </div>
	  	  <?}?>
  <?}?>
  <?foreach($card as $k=>$v){?>
	  <ul class="already_shop already_list">
	  <li class="name">
	  <p class="pic">
			<?if($v['Card']['img01'] != ""){?>
       	  <?=$html->link($html->image("/../".$v['Card']['img01'],array("width"=>"108","height"=>"108")),"/#",array(),false,false);?>
			<?}else{?>
       	  <?=$html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),"/#",array(),false,false);?>
			 <?}?>	  	  
	  </p>
	  <p class="item_name">
       	  <?=$html->link($v['CardI18n']['name'],"#",array(),false,false);?>	  	  
	  </p>
	  </li><li class="profile"><?=$v['Card']['note']?></li>
	  	  <li class="marke_price">
	  	  <?=$svshow->price_format($v['Card']['fee'],$SVConfigs['price_format']);?>
	  	  </li>
	  	  <li class="shop_price">
	  	  <?//if($v['Product']['promotion_status'] == 1){?><?//echo $v['Product']['promotion_price']?><?//}else{?><?//echo $v['Product']['shop_price']?><?//}?>
	  	  <?=$svshow->price_format($v['Card']['fee'],$SVConfigs['price_format']);?>
	  	  </li>
	  	  <li class="number"><?echo $v['Card']['quntity']?></li><li class="subtotal">
	  	  <?=$svshow->price_format($v['Card']['fee']*$v['Card']['quntity'],$SVConfigs['price_format']);?>
	  	  	  </li></ul>
  <?}?>
  <?foreach($packaging as $k=>$v){?>
	  <ul class="already_shop already_list">
	  <li class="name">
	  <p class="pic">
			<?if($v['Packaging']['img01'] != ""){?>
       	  <?=$html->link($html->image("/../".$v['Packaging']['img01'],array("width"=>"108","height"=>"108")),"/#",array(),false,false);?>
			<?}else{?>
       	  <?=$html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),"/#",array(),false,false);?>
			 <?}?>	  	  
	  </p>
	  <p class="item_name">
       	  <?=$html->link($v['PackagingI18n']['name'],"#",array(),false,false);?>	  	  
	  </p>
	  </li><li class="profile"><?=$v['Packaging']['note']?></li>
	  	  <li class="marke_price">
	  	  <?=$svshow->price_format($v['Packaging']['fee'],$SVConfigs['price_format']);?>
	  	  </li>
	  	  <li class="shop_price">
	  	  <?//if($v['Product']['promotion_status'] == 1){?><?//echo $v['Product']['promotion_price']?><?//}else{?><?//echo $v['Product']['shop_price']?><?//}?>
	  	  <?=$svshow->price_format($v['Packaging']['fee'],$SVConfigs['price_format']);?>
	  	  </li>
	  	  <li class="number"><?echo $v['Packaging']['quntity']?></li><li class="subtotal">
	  	  <?=$svshow->price_format($v['Packaging']['fee']*$v['Packaging']['quntity'],$SVConfigs['price_format']);?>
	  	  	  </li></ul>
  <?}?>  			  
  			  
  	 	  </div>
	  <p class="saves_many"><?=$SCLanguages['amount'].$SCLanguages['subtotal']?>
	  	   <?//echo $order_info['Order']['subtotal']?>
	  	  <?=$svshow->price_format($shop_subtotal,$SVConfigs['price_format']);?>
	  	  <?if($order_info['Order']['save_price'] >0){?>
	  	  ，<font color="#FE5F01"><?=$SCLanguages['market_price']?>
	  	  <?=$svshow->price_format($order_info['Order']['market_subtotal'],$SVConfigs['price_format']);?>
	  	  <?=$SCLanguages['saved']?> 
	  	  <?=$svshow->price_format($order_info['Order']['save_price'],$SVConfigs['price_format']);?>
	  	  	  (<?echo (100-$order_info['Order']['discount_price'])?>%)
	  	  <?}?>
	  	  </font></p><br />
	</div>
</div>
 


<!--已购买的商品 End-->
<!--收货人信息-->
        <div id="infos" style="width:739px;">
		<p class="amend_address"><span><a href="#"><?=$SCLanguages['edit']?></a></span></p>
        	<ul class="address_info">
			<li class="lang_title"><?=$SCLanguages['consignee']?>:</li><li class="filed"><?php if($order_info['Order']['consignee']) echo $order_info['Order']['consignee']; else echo "&nbsp;";?></li>
    			<li class="lang_title"><?=$SCLanguages['region']?>:</li><li class="filed"><?=$order_info['Order']['regions']?>&nbsp;</li>
			<li class="lang_title"><?=$SCLanguages['email']?>:</li><li class="filed"><?php if($order_info['Order']['email']) echo $order_info['Order']['email'];else echo "&nbsp;"; ?></li>
			<?php if(empty($all_virtual)){?>
			<li class="lang_title"><?=$SCLanguages['address']?>:</li><li class="filed"><?php if($order_info['Order']['address'])echo $order_info['Order']['address'];else echo "&nbsp;";?></li>
			<li class="lang_title"><?=$SCLanguages['post_code']?>:</li><li class="filed"><?php if($order_info['Order']['zipcode']) echo $order_info['Order']['zipcode'];else echo "&nbsp;";?></li>
			<?php }?>
			<li class="lang_title"><?=$SCLanguages['telephone']?>:</li><li class="filed"><?php if($order_info['Order']['telephone']) echo $order_info['Order']['telephone'];else echo "&nbsp;";?></li>
			<li class="lang_title"><?=$SCLanguages['mobile']?>:</li><li class="filed"><?php if($order_info['Order']['mobile']) echo $order_info['Order']['mobile'];else echo "&nbsp;";?></li>
			<?php if(empty($all_virtual)){?>
			<li class="lang_title"><?=$SCLanguages['marked_building']?>:</li><li class="filed"><?php if($order_info['Order']['sign_building']) echo $order_info['Order']['sign_building'];else echo "&nbsp;";?></li>
			<li class="lang_title"><?=$SCLanguages['best_shipping_time']?>:</li><li class="filed"><?php if($order_info['Order']['best_time']) echo $order_info['Order']['best_time'];else echo "&nbsp;";?></li>
			<?php }?>
			</ul>
        </div>
<!--收货人信息 End-->
<!--订单小计-->	
	<div id="Edit_box">
  <div id="Edit_info" style="width:739px;margin-top:5px;*margin-top:0;">
	  <p class="note article_title">
	  <b><?=$SCLanguages['products']?><?=$SCLanguages['subtotal']?></b></p>
	  <p class="balances">
<!--$point_log['UserPointLog']['point']-->
		<?=$SCLanguages['products']?><?=$SCLanguages['subtotal']?>:
	  	  <?=$svshow->price_format($shop_subtotal,$SVConfigs['price_format']);?>
				<br />
		<?$fee=0;?>
		<?if($order_info['Order']['card_fee'] > 0){?>
		<?$fee=1;?>
		<?=$SCLanguages['card_fee']?>: 
	  	  <?=$svshow->price_format($order_info['Order']['card_fee'],$SVConfigs['price_format']);?>
		<?}?>
		<?if($order_info['Order']['pack_fee'] > 0){?>
		<?$fee=1;?>
		<?=$SCLanguages['package_fee']?>:
	  	  <?=$svshow->price_format($order_info['Order']['pack_fee'],$SVConfigs['price_format']);?>
		<?}?>
		<?if($order_info['Order']['payment_fee'] > 0){?>
		<?$fee=1;?>
		<?=$SCLanguages['payment_fee']?>: 
	  	  <?=$svshow->price_format($order_info['Order']['payment_fee'],$SVConfigs['price_format']);?>
		<?}?>
		<?if($order_info['Order']['shipping_fee'] > 0){?>
		<?$fee=1;?>
		<?=$SCLanguages['shipping_fee']?>: 
	  	  <?=$svshow->price_format($order_info['Order']['shipping_fee'],$SVConfigs['price_format']);?>
		<?}?>
		<?if($fee == 1){?>
		<br />
		<?}?>
		<?$fee1=0;?>
		<?if(isset($point_log['UserPointLog']['point']) && $point_log['UserPointLog']['point']>0){?>
		<?$fee1=1;?>
		<?=$SCLanguages['use']?><?=$SCLanguages['point']?>: 
	  	  <?=$svshow->price_format($point_log['UserPointLog']['point'],$SVConfigs['price_format']);?>
		<?}?>
		<?if(isset($coupon_fee)){?>
		<?$fee1=1;?>
		<?=$SCLanguages['use']?><?=$SCLanguages['coupon']?>: 
	  	  <?=$svshow->price_format($coupon_fee,$SVConfigs['price_format']);?>
	  	   <?if(isset($coupon_discount) && $coupon_discount <100){?>
	  	   <?=$SCLanguages['coupon']?><?=$SCLanguages['discount']?>: <?=(100- $coupon_discount)?>%&nbsp;
	  	   <?}?>
		<?}?>
		<?if($order_info['Order']['discount'] > 0){?>
		<?$fee1=1;?>
		<?=$SCLanguages['order']?><?=$SCLanguages['discount']?>: 
	  	  <?=$svshow->price_format($order_info['Order']['discount'],$SVConfigs['price_format']);?>
		<?}?>			
		<?if(isset($balance_log['UserBalanceLog']['amount'])){?>
		<?$fee1=1;?>	  <br/>	
		<?=$SCLanguages['use']?><?=$SCLanguages['balance']?>:
	  	  <?=$svshow->price_format($balance_log['UserBalanceLog']['amount'],$SVConfigs['price_format']);?>
		<?}else{?>
		<?$fee1=1;?>		
		<?=$SCLanguages['use']?><?=$SCLanguages['balance']?>:
		  <?=$svshow->price_format('0',$SVConfigs['price_format']);?>
		<?}?>
		<?if($fee1 == 1){?>	
		<br />
		<?}?>
		<?if($order_info['Order']['money_paid'] >0){?>
		- <?=$SCLanguages['paid'].$SCLanguages['amount']?>:
	  	  <?=$svshow->price_format($order_info['Order']['money_paid'],$SVConfigs['price_format']);?><br/>
		<?}?>
		<?=$SCLanguages['payable_amount']?>: 
	  	  <?=$svshow->price_format($order_info['Order']['total']-$order_info['Order']['money_paid']-$order_info['Order']['discount'],$SVConfigs['price_format']);?><br />
		
			<?if($order_info['Order']['status'] < 2 && $order_info['Order']['payment_status'] != 2  && $order_info['Order']['payment_status'] != 2){?>
            <p class="title order_list">
            <span class="handel btn_list">
            <a href="javascript:order_pay(<?echo $order_info['Order']['id']?>,<?echo $order_info['Order']['status']?>,'<?=$SCLanguages['order_not_paid'];?>');">
            <span><?=$SCLanguages['pay']?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </a></span></p><br /><br /><br />
            <?}?>
		</p>
	</div>
</div>
<!--订单小计 End-->

<!--支付方式-->	
	<div id="Edit_box">
  <div id="Edit_info" style="width:739px;margin-top:5px;*margin-top:0;">
	  <p class="note article_title btn_list">
	  <b><?=$SCLanguages['payment']?></b>
<?if ($order_info['Order']['status'] == 0){?>	  
	<span class="amenber_balances"><!--cite style="cursor:pointer;"><a id="editpayment"><?=$SCLanguages['edit']?></a></cite--></span></p>
<?}?>
<?if($order_info['Order']['payment_status'] != 2 && $order_info['Order']['status'] < 2){?>
	  <?foreach($payment_list as $k=>$v){?>
	  <?if($v['Payment']['id'] != $order_info['Order']['payment_id'] && $v['PaymentI18n']['status'] == 1){
	  $is_show = 1;	  
	  }?>
  	  <?}?>	
	
	
<!--修改支付方式-->
<?if(isset($is_show) && $is_show == 1){?>
<div id="edit_payment" style="border:1px solid #fff">
  <div id="Edit_info" style="width:588px;background:#fff;border:1px solid #fff">
	  <p class="balances">
	  <?foreach($payment_list as $k=>$v){?>
	  <?if($v['Payment']['id'] != $order_info['Order']['payment_id'] && $v['PaymentI18n']['status'] == 1){?>
	    <input class="radio" type="radio" name="pay_ment" id="pay_ment" value="<?echo $v['Payment']['id']?>" onclick="change_payment(this.value,<?echo $order_info['Order']['id']?>);"><?echo $v['PaymentI18n']['name']?>
	  <?}?>
  	  <?}?>
	  </p>
	  <br /><br />
	</div>
</div>
<!--修改支付方式 End-->
<?}}?>	  
	  <p class="balances"><?=$SCLanguages['payment']?>:<b><?echo $order_info['Order']['payment_name']?></b>。<?=$SCLanguages['payable_amount']?>:
	  	  <b>
	  	  <?=$svshow->price_format($order_info['Order']['total'],$SVConfigs['price_format']);?></b>
	  	  <br /><?//=$SCLanguages['delivery_versus_payment']?></p>
	  
	</div>
</div>
<!--支付方式 End-->
  </div>

<?php echo $this->element('news',array('cache'=>'+0 hour'))?>

