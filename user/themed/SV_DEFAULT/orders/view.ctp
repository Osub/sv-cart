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
 * $Id: view.ctp 4887 2009-10-11 09:05:21Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?><div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['order'].$SCLanguages['detail']?></b></h1>
<!--订单状态-->
<div class="infos">
<dl class="order_state">
				<dt><?php echo $SCLanguages['order_code']?><b>：</b></dt><dd><?php echo $order_info['Order']['order_code']?> [
	<?php echo $html->link($SCLanguages['send'],'/messages/'.$order_info['Order']['id'],array(),false,false);?>
	/
	<?php echo $html->link($SCLanguages['view'].$SCLanguages['suppliers_message'],'/messages/'.$order_info['Order']['id'],array(),false,false);?>
	]</dd>
			<dt><?php echo $SCLanguages['order'].$SCLanguages['status']?><b>：</b></dt><dd>
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
			</dd>
			<dt><?php echo $SCLanguages['pay'].$SCLanguages['status']?><b>：</b></dt><dd>
            <?php if($order_info['Order']['payment_status'] == 0){?>
            <?php echo $systemresource_info['payment_status']['0']?>
            <?php }?>
           	<?php if($order_info['Order']['payment_status'] == 1){?>
            <?php echo $systemresource_info['payment_status']['1']?>
            <?php }?>
            <?php if($order_info['Order']['payment_status'] == 2){?>
            <?php echo $systemresource_info['payment_status']['2']?>
            <?php }?>&nbsp;<?php echo $order_info['Order']['payment_time']?>&nbsp;<?php echo $order_info['Order']['payment_name']?>
		</dd>
				<dt><?php echo $SCLanguages['delivery_status']?><b>：</b></dt><dd >
            <?php if($order_info['Order']['shipping_status'] == 0){?>
            <?php echo $systemresource_info['shipping_status']['0']?>
            <?php }?>
           	<?php if($order_info['Order']['shipping_status'] == 1){?>
            <?php echo $systemresource_info['shipping_status']['1']?>&nbsp;
            <?php }?>
            <?php if($order_info['Order']['shipping_status'] == 2){?>
            <?php echo $systemresource_info['shipping_status']['2']?>
            <?php }?>
            <?php if($order_info['Order']['shipping_status'] == 3){?>
            <?php echo $systemresource_info['shipping_status']['3']?>
            <?php }?>				
			&nbsp;<?php echo $order_info['Order']['shipping_time']?>&nbsp;<?php echo $order_info['Order']['shipping_name']?>
			<?if($order_info['Order']['shipping_status'] == 1 && $order_info['Order']['shipping_name'] == "EMS" ){?>
				<form style="margin:0px;display:inline"  method="post" action="http://www.ems.com.cn/qcgzOutQueryAction.do" name="queryForm" target="_blank">
	            <input type="hidden" name="mailNum" value="<?=$order_info['Order']['invoice_no']?>" />
	            <a href="javascript:document.forms['queryForm'].submit();"><?=$order_info['Order']['invoice_no']?></a>
	            <input type="hidden" name="reqCode" value="browseBASE" />
	            <input type="hidden" name="checknum" value="0568792906411" />
	            </form>			
			<?}?>	
				
			</dd>
<!--其他信息-->	
	  <dt><?php if(false){?><?php echo $SCLanguages['order']?><?php echo $SCLanguages['remark']?><b>：</b></dt><dd style="border:0;"><?php echo $order_info['Order']['note']?></dd>
	    <?php }?>
<!--其他信息 End-->
		</dl>
</div> 
<!--订单状态 End-->	

<!-- 留言-->
<?php if(isset($my_messages) && sizeof($my_messages)>0){?>
<div class="Edit_box">
<div class="Edit_info" style="margin-top:5px;*margin-top:0;">
	  <p class="note article_title"><b><?php echo $SCLanguages['message']?></b></p>
  <?php foreach($my_messages as $k=>$v){?>
  <div class="user_msg">
  	<p class="msg_title"><span class="title"><?php echo $v['UserMessage']['type']?>： <?php echo $v['UserMessage']['msg_title']?> <font color="#A7A9A8"><?php echo $v['UserMessage']['created']?></font></span></p>
    <p class="msg_txt"><span><?php echo $v['UserMessage']['msg_content']?></span></p>
  </div>
  <?php if(isset($v['Reply']) && sizeof($v['Reply'])>0){?>
     <?php foreach($v['Reply'] as $key=>$val){?>
  <div class="user_msg">
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
<div class="Edit_box">
<div class="Edit_info" style="margin-top:5px;*margin-top:0;">
<p class="note article_title"><b><?php echo $SCLanguages['purchased_products']?></b></p>
<ul class="already_shop">
	<li class="name" style="text-align:right;"><span><?php echo $SCLanguages['products'].$SCLanguages['apellation']?></span></li>
	<li class="profile"><?php echo $SCLanguages['products'].$SCLanguages['attribute']?></li>
	<li class="marke_price"><?php echo $SCLanguages['market_price']?></li>
	<li class="shop_price"><?php echo $SCLanguages['our_price']?></li>
	<li class="number"><?php echo $SCLanguages['quantity']?></li>
	<li class="subtotal"><?php echo $SCLanguages['subtotal']?></li>

</ul>
<div class="already_box">
  <?php foreach($order_products as $k=>$v){?>
	  <ul class="already_shop already_list">
	  <li class="name">
	  <p class="pic">
			<?php echo $svshow->productimagethumb($v['Product']['img_thumb'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['use_sku'],$server_host,$cart_webroot),array("alt"=>$v['ProductI18n']['name'],'width'=>$this->data['configs']['thumbl_image_width'],'height'=>$this->data['configs']['thumb_image_height']),$this->data['configs']['products_default_image'],$server_host.$cart_webroot);?>
 	  
	  </p>
	  <p class="item_name">
       	  <?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku'],$server_host,$cart_webroot),array("target"=>"_blank"),false,false);?>
	  </p>
	  </li>
	  <li class="profile"><?php echo $v['OrderProduct']['product_attrbute']?></li>
	  <li class="marke_price">
	  	  <?//php echo $svshow->price_format($v['Product']['market_price'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Product']['market_price'],$this->data['configs']['price_format']);?>	
			<?php }?>    		  	  
	  </li>
	  <li class="shop_price">
	  <?php //if($v['Product']['promotion_status'] == 1){?><?php //echo $v['Product']['promotion_price']?><?php //}else{?><?php //echo $v['Product']['shop_price']?><?php //}?>
	  <?//php echo $svshow->price_format($v['OrderProduct']['product_price'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['OrderProduct']['product_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['OrderProduct']['product_price'],$this->data['configs']['price_format']);?>	
			<?php }?>   	  	  
	  	  
	  </li>
	  <li class="number"><?php echo $v['OrderProduct']['product_quntity']?></li>
	  <li class="subtotal"><?//php echo $svshow->price_format($v['OrderProduct']['one_pro_subtotal'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['OrderProduct']['one_pro_subtotal']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['OrderProduct']['one_pro_subtotal'],$this->data['configs']['price_format']);?>	
			<?php }?>  	  	  
	  	  
	  	  </li>
	</ul>
	<?php if(isset($virtual_card[$v['Product']['id']])){?>
	<div class="cardnumber color_67">
		  <?php foreach($virtual_card[$v['Product']['id']] as $vv){?>
		  <div>
		  <?php echo $SCLanguages['card_number']?>:<?php echo $vv['card_sn'];?>
		  <?php echo $SCLanguages['password']?>:<?php echo $vv['card_password'];?>
		  <?php echo $SCLanguages['expiration_date']?>:<?php echo $vv['end_date'];?>
		  </div>
		  <?php }?>
	</div>
	<?php }?>
	
	<?php if(isset($download_product[$v['Product']['id']])){?>
	<div class="cardnumber color_67">
		  <?php foreach($download_product[$v['Product']['id']] as $vv){?>
		  <div>
		 <?php if($vv['count']!='forever'){?> 可下载:<?php echo $vv['count'];?>次&nbsp;&nbsp;<?php }?>
		<?php if($vv['count']>0 ||$vv['count']=='forever' ){?><a href="javascript:download(<?php echo $vv['order_id']?>,<?php echo $vv['product_id']?>)" >点击下载<a>&nbsp;&nbsp;<?php }?>
		  <?php  if(!empty($vv['end_time'])){echo $SCLanguages['expiration_date']?>:<?php echo $vv['end_time'];}?>
		  </div>
		  <?php }?>
	</div>
	<?php }?>	
	
	<?php if(isset($service_product[$v['Product']['id']])){?>
	<div class="cardnumber color_67">
		  <?php foreach($service_product[$v['Product']['id']] as $vv){?>
		  <div>
		  <?php if($vv['cycle']!='forever'){?>服务期剩:<?php echo $vv['cycle'];?>天&nbsp;&nbsp;服务周期至:<?php echo $vv['ser_time'];?>&nbsp;&nbsp;<?php }?>
		  <?php if($vv['cycle']>0||$vv['cycle']=='forever'){ echo "地址:".$vv['url']?>&nbsp;&nbsp;<?php }?>
		  <?php  if(!empty($vv['end_time'])){echo $SCLanguages['expiration_date']?>:<?php echo $vv['end_time'];}?>
		  
		  </div>
		  <?php }?>
	</div>
	<?php }?>
		
  <?php }?>
  	  
<?php if(isset($card) && sizeof($card)>0){?>
  <?php foreach($card as $k=>$v){?>
	  <ul class="already_shop already_list">
	  <li class="name">
	  <p class="pic">
	<?php if($v['Card']['img01'] != ""){?>
    <?php echo $html->link($html->image("/../".$v['Card']['img01'],array("width"=>"108","height"=>"108")),"/#",array(),false,false);?>
	<?php }else{?>
    <?php echo $html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),"/#",array(),false,false);?>
	<?php }?>	  	  
	  </p>
	  <p class="item_name"><?php echo $html->link($v['CardI18n']['name'],"#",array(),false,false);?></p>
	  </li>
	  <li class="profile"><?php echo $v['Card']['note']?></li>
	  <li class="marke_price"><?//php echo $svshow->price_format($v['Card']['fee'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Card']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Card']['fee'],$this->data['configs']['price_format']);?>	
			<?php }?>  		  	  
	  	  
	  	  </li>
	  <li class="shop_price">
	  <?php //if($v['Product']['promotion_status'] == 1){?><?php //echo $v['Product']['promotion_price']?><?php //}else{?><?php //echo $v['Product']['shop_price']?><?php //}?>
	  	  <?//php echo $svshow->price_format($v['Card']['fee'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Card']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Card']['fee'],$this->data['configs']['price_format']);?>	
			<?php }?>  	  	  	  
	  	  	  
	  	  	  
	  </li>
	  <li class="number"><?php echo $v['Card']['quntity']?></li>
	 <li class="subtotal"><?//php echo $svshow->price_format($v['Card']['fee']*$v['Card']['quntity'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Card']['fee']*$v['Card']['quntity']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Card']['fee']*$v['Card']['quntity'],$this->data['configs']['price_format']);?>	
			<?php }?>  	 	  
	 	  
	 	  </li>
	</ul>
  <?php }?>
<?php }?>
<?php if(isset($packaging) && sizeof($packaging)>0){?>
  <?php foreach($packaging as $k=>$v){?>
	  <ul class="already_shop already_list">
	  <li class="name">
	  <p class="pic">
			<?php if($v['Packaging']['img01'] != ""){?>
       	  <?php echo $html->link($html->image("/../".$v['Packaging']['img01'],array("width"=>"108","height"=>"108")),"/#",array(),false,false);?>
			<?php }else{?>
       	  <?php echo $html->link($html->image("/../img/product_default.jpg",array("width"=>"108","height"=>"108")),"/#",array(),false,false);?>
			 <?php }?>	  	  
	  </p>
	  <p class="item_name"><?php echo $html->link($v['PackagingI18n']['name'],"#",array(),false,false);?></p>
	  </li>
	  <li class="profile"><?php echo $v['Packaging']['note']?></li>
	  <li class="marke_price"><?//php echo $svshow->price_format($v['Packaging']['fee'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Packaging']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Packaging']['fee'],$this->data['configs']['price_format']);?>	
			<?php }?>  	  	  
	  	  
	  	  </li>
	  <li class="shop_price">
	  <?php //if($v['Product']['promotion_status'] == 1){?><?php //echo $v['Product']['promotion_price']?><?php //}else{?><?php //echo $v['Product']['shop_price']?><?php //}?>
	  <?//php echo $svshow->price_format($v['Packaging']['fee'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Packaging']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Packaging']['fee'],$this->data['configs']['price_format']);?>	
			<?php }?>  		  	  
	  </li>
	  <li class="number"><?php echo $v['Packaging']['quntity']?></li>
	  <li class="subtotal">
	  	  <?//php echo $svshow->price_format($v['Packaging']['fee']*$v['Packaging']['quntity'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Packaging']['fee']*$v['Packaging']['quntity']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Packaging']['fee']*$v['Packaging']['quntity'],$this->data['configs']['price_format']);?>	
			<?php }?>  		  	
	  	
	  	</li>
	 </ul>
  <?php }?>
<?php }?>
</div>
<p class="saves_many"><?php echo $SCLanguages['amount'].$SCLanguages['subtotal']?>
	<?php //echo $order_info['Order']['subtotal']?>
	<?//php echo $svshow->price_format($shop_subtotal,$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($shop_subtotal*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($shop_subtotal,$this->data['configs']['price_format']);?>	
			<?php }?>  		
	
	<?php if($order_info['Order']['save_price'] >0){?>
	，<font color="#FE5F01"><?php echo $SCLanguages['market_price']?>
	<?//php echo $svshow->price_format($order_info['Order']['market_subtotal'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['market_subtotal']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['market_subtotal'],$this->data['configs']['price_format']);?>	
			<?php }?>  		
		
	<?php echo $SCLanguages['saved']?> 
	<?//php echo $svshow->price_format($order_info['Order']['save_price'],$SVConfigs['price_format']);?>
		
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['save_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['save_price'],$this->data['configs']['price_format']);?>	
			<?php }?>  			
		
		
	(<?php echo (100-$order_info['Order']['discount_price'])?>%)
	<?php }?></font>
</p>
<br />
</div>
</div>
<!--已购买的商品 End-->
<div class="clear">&nbsp;</div>
<!--收货人信息-->
<div class="infos">
		<p class="amend_address"><strong><?php echo $SCLanguages['consignee'].$SCLanguages['information']?></strong></p>
        	<ul class="address_info">
			<li class="lang_title"><?php echo $SCLanguages['consignee']?>:</li><li class="filed"><?php if($order_info['Order']['consignee']) echo $order_info['Order']['consignee']; else echo "&nbsp;";?>&nbsp;</li>
    		<?php if(empty($all_virtual)){?>
    			<li class="lang_title"><?php echo $SCLanguages['region']?>:</li><li class="filed"><?php echo $order_info['Order']['regions']?>&nbsp;</li>
    		<?php }?>
			<li class="lang_title"><?php echo $SCLanguages['email']?>:</li><li class="filed"><?php if($order_info['Order']['email']) echo $order_info['Order']['email'];else echo "&nbsp;"; ?>&nbsp;</li>
			<?php if(empty($all_virtual)){?>
			<li class="lang_title"><?php echo $SCLanguages['address']?>:</li><li class="filed"><?php if($order_info['Order']['address'])echo $order_info['Order']['address'];else echo "&nbsp;";?>&nbsp;</li>
			<?php }?>
			<li class="lang_title"><?php echo $SCLanguages['telephone']?>:</li><li class="filed"><?php if($order_info['Order']['telephone']) echo $order_info['Order']['telephone'];else echo "&nbsp;";?>&nbsp;</li>
			<?php if(empty($all_virtual)){?>
			<li class="lang_title"><?php echo $SCLanguages['post_code']?>:</li><li class="filed"><?php if($order_info['Order']['zipcode']) echo $order_info['Order']['zipcode'];else echo "&nbsp;";?>&nbsp;</li>
			<?php }?>
			<li class="lang_title"><?php echo $SCLanguages['mobile']?>:</li><li class="filed"><?php if($order_info['Order']['mobile']) echo $order_info['Order']['mobile'];else echo "&nbsp;";?>&nbsp;</li>
			<?php if(empty($all_virtual)){?>
			<li class="lang_title"><?php echo $SCLanguages['marked_building']?>:</li><li class="filed"><?php if($order_info['Order']['sign_building']) echo $order_info['Order']['sign_building'];else echo "&nbsp;";?>&nbsp;</li>
			<li class="lang_title"><?php echo $SCLanguages['best_shipping_time']?>:</li><li class="filed"><?php if($order_info['Order']['best_time']) echo $order_info['Order']['best_time'];else echo "&nbsp;";?>&nbsp;</li>
			<?php }?>
			</ul>
        </div>
<!--收货人信息 End-->



<!-- 其他 -->
<?php if(isset($show_note) && $show_note == 1){?>
<div class="Edit_box">
<div class="Edit_info" style="margin-top:5px;*margin-top:0;">
<p class="note article_title btn_list"><b><?php echo $SCLanguages['others']?></b></p>
<p class="balances"><span class="color_4">
<?php if($order_info['Order']['note']){?>
	<?php echo $SCLanguages['order']?><?php echo $SCLanguages['remark']?>:
		<?php echo $order_info['Order']['note']?>
	<?php }?>
<?php if(isset($packaging) && sizeof($packaging)>0){?>
  <?php foreach($packaging as $k=>$v){?>
	<?php if($v['Packaging']['note'] != ""){?>
	<br /><?php echo $SCLanguages['packaging']?><?php echo $SCLanguages['remark']?>:
		<?php echo $v['Packaging']['note']?>
<?php }}}?>
<?php if(isset($card) && sizeof($card)>0){?>
  <?php foreach($card as $k=>$v){?>
	<?php if($v['Card']['note'] != ""){?>
	<br /><?php echo $SCLanguages['card']?><?php echo $SCLanguages['remark']?>:
		<?php echo $v['Card']['note']?>
<?php }}}?></span>
</p>
	</div>   
</div>
<?php }?>

<!--订单小计-->	
<div class="Edit_box">
<div class="Edit_info" style="margin-top:5px;*margin-top:0;">
<p class="note article_title"><b><?php echo $SCLanguages['amount']?><?php echo $SCLanguages['subtotal']?></b></p>
	<table cellpadding="4" cellspacing="0" class="color_4" style="margin-left:15px;">
		<tr>
		<td><?php echo $SCLanguages['total_order_value']?>:</td>
		<td>
	  	<?//php echo $svshow->price_format($order_info['Order']['total'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['total']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['total'],$this->data['configs']['price_format']);?>	
			<?php }?>  				
	
		</td>
		</tr>
		<tr>
		<td><?php echo $SCLanguages['products']?><?php echo $SCLanguages['subtotal']?>:</td>
		<td>
	  	<?//php echo $svshow->price_format($shop_subtotal,$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($shop_subtotal*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($shop_subtotal,$this->data['configs']['price_format']);?>	
			<?php }?> 	  	  	  		
			
		</td>
		</tr>
		<?php $fee=0;?>
		<?php if($order_info['Order']['card_fee'] > 0){?>
		<?php $fee=1;?>
		<tr>
		<td><?php echo $SCLanguages['card_fee']?>: </td>
	  	  <td><?//php echo $svshow->price_format($order_info['Order']['card_fee'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['card_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['card_fee'],$this->data['configs']['price_format']);?>	
			<?php }?>  		  	    
		</td>
		</tr>
		<?php }?>
		
		<?php if($order_info['Order']['pack_fee'] > 0){?>
		<?php $fee=1;?>
		<tr>
			<td><?php echo $SCLanguages['package_fee']?>:</td>
	  	  	<td><?//php echo $svshow->price_format($order_info['Order']['pack_fee'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['pack_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['pack_fee'],$this->data['configs']['price_format']);?>	
			<?php }?> 
			</td> 	
		</tr>		  	    
		<?php }?>

		
		<?php if($fee > 0){?>
		<?php }?>
		<?php if($order_info['Order']['payment_fee'] > 0){?>
		<tr>
		<?php $fee=1;?>
		<td><?php echo $SCLanguages['payment_fee']?>: </td>
	  	<td><?//php echo $svshow->price_format($order_info['Order']['payment_fee'],$SVConfigs['price_format']);?>
	  	    
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['payment_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['payment_fee'],$this->data['configs']['price_format']);?>	
			<?php }?>
	  	    </td>
	  	   </tr>
		<?php }?>
		<?php if(isset($order_info['Order']['shipping_fee'])){?>
		<tr>
		<?php $fee=1;?>
		<td><?php echo $SCLanguages['shipping_fee']?>: </td>
	  	  <td><?//php echo $svshow->price_format($order_info['Order']['shipping_fee'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['shipping_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['shipping_fee'],$this->data['configs']['price_format']);?>	
			<?php }?> 
			</td>
		</tr> 		  	    
	  	    
	  	    
	  	    <?php if($order_info['Order']['insure_fee'] >0){?>
	  	    <tr>
	  	    	<td><?php echo $SCLanguages['support_value_fee']?>:<?//php echo $svshow->price_format($order_info['Order']['insure_fee'],$SVConfigs['price_format']);?></td>
	  	    	<td>
	  	    	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['insure_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['insure_fee'],$this->data['configs']['price_format']);?>	
			<?php }?>  		  	    	
	  	    	</td>
	  	    </tr>
	  	    <?php }?>
	  		
		<?php }?>
			
		<?php if($order_info['Order']['tax'] > 0){?>
		<tr>
		<?php $fee=1;?>
		<td><?php echo $SCLanguages['invoice_fee']?>: </td>
	  	<td><?//php echo $svshow->price_format($order_info['Order']['payment_fee'],$SVConfigs['price_format']);?>
	  	    
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['tax']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['tax'],$this->data['configs']['price_format']);?>	
			<?php }?>
	  	    </td>
	  	   </tr>
		<?php }?>			
			
			
			
			
			
		<?php $fee1=0;?>
		<?php if(isset($order_info['Order']['point_use']) && $order_info['Order']['point_use']>0){?>
			<tr>
		<?php $fee1=1;?>
			<td><?php echo $SCLanguages['use']?><?php echo $SCLanguages['point']?>: </td>
	  	  	<td><?php echo $order_info['Order']['point_use'];?><?php echo $SCLanguages['point_unit'];?><?php echo $SCLanguages['save_to_market_price'];?>
	  	    <?//php echo $svshow->price_format($order_info['Order']['point_fee'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['point_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['point_fee'],$this->data['configs']['price_format']);?>	
			<?php }?> 
		</td>
		</tr> 		  	    
		<?php }?>
		
		<?php if(isset($coupon_fee)){?>
		<tr>
		<?php $fee1=1;?>
		<td><?php echo $SCLanguages['use']?><?php echo $SCLanguages['coupon']?>: </td>
	  	  <?//php echo $svshow->price_format($coupon_fee,$SVConfigs['price_format']);?>
		<td><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($coupon_fee*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($coupon_fee,$this->data['configs']['price_format']);?>	
			<?php }?>
			</td>
			</tr>  	  	    
	  	    
	  	   <?php if(isset($coupon_discount) && $coupon_discount <100){?>
	  	   <tr>
	  	   <td><?php echo $SCLanguages['coupon']?><?php echo $SCLanguages['discount']?>:</td>
	  	   <td><?php echo (100- $coupon_discount)?>%&nbsp;</td>
	  	   </tr>
	  	   <?php }?>
		<?php }?>
		
		<?php if($order_info['Order']['discount'] > 0){?>
		<tr>
		<?php $fee1=1;?>
			<td><?php echo $SCLanguages['order']?><?php echo $SCLanguages['discount']?>: </td>
	  	  	<?//php echo $svshow->price_format($order_info['Order']['discount'],$SVConfigs['price_format']);?>
			<td><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['discount']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['discount'],$this->data['configs']['price_format']);?>	
			<?php }?>
			</td>  	  	  	    
	  	    
	  	    </tr>
		<?php }?>
					
		<?php if(isset($balance_log['UserBalanceLog']['amount']) && $balance_log['UserBalanceLog']['amount'] >0){?>
		<tr>
		<?php $fee1=1;?>
		<td><?php echo $SCLanguages['use']?><?php echo $SCLanguages['balance']?>:</td>
	  	<td><?//php echo $svshow->price_format(($balance_log['UserBalanceLog']['amount']*-1),$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format(($balance_log['UserBalanceLog']['amount']*-1)*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format(($balance_log['UserBalanceLog']['amount']*-1),$this->data['configs']['price_format']);?>	
			<?php }?>  
			</td>
			</tr>	 	  	    
	  	    
	  	    
		<?php }elseif(false){?>
		<tr>
		<?php $fee1=1;?>		
		<td><?php echo $SCLanguages['use']?><?php echo $SCLanguages['balance']?>:</td>
		  <td><?//php echo $svshow->price_format('0.00',$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format('0.00',$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format('0.00',$this->data['configs']['price_format']);?>	
			<?php }?>  
			</td>			    
		    </tr>
		<?php }?>
		<?php if($fee1 == 1){?>	
		
		<?php }?>
		<?php if($order_info['Order']['money_paid'] >0){?>
		<tr>
		<td>- <?php echo $SCLanguages['paid'].$SCLanguages['amount']?>:</td>
	  	<td><?//php echo $svshow->price_format($order_info['Order']['money_paid'],$SVConfigs['price_format']);?>
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['money_paid']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['money_paid'],$this->data['configs']['price_format']);?>	
			<?php }?>
			</td>
		</tr>  		  	    
	  	    
	  	  
		<?php }?>
		<tr>
		<td><?php echo $SCLanguages['payable_amount']?>: </td>
	  	  <td><?//php echo $svshow->price_format($order_info['Order']['need_paid'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['need_paid']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['need_paid'],$this->data['configs']['price_format']);?>	
			<?php }?> 
		</td>
		</tr>	  	    
	  	    
	  	    
			<?php if($order_info['Order']['status'] < 2 && $order_info['Order']['payment_status'] != 2  && $order_info['Order']['payment_status'] != 2){?>
		<tr>
            <td colspan="2"><p class="title order_list">
            <span class="btn_list">
            <a href="javascript:order_pay(<?php echo $order_info['Order']['id']?>,<?php echo $order_info['Order']['status']?>,'<?php echo $SCLanguages['order_not_paid'];?>');">
            <span><?php echo $SCLanguages['pay']?></span>
            </a></span></p>
            <br />
           </td>
            </tr>
            <?php }?>
    </table>      
	</div>
</div>
<!--订单小计 End-->

<!--支付方式-->	
<div class="Edit_box" style="display:none">
<div class="Edit_info" style="margin-top:5px;*margin-top:0;">
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
  <div class="Edit_info" style="width:588px;background:#fff;border:1px solid #fff">
	  <p class="balances">
	  <?php foreach($payment_list as $k=>$v){?>
	  <?php if($v['Payment']['id'] != $order_info['Order']['payment_id'] && $v['PaymentI18n']['status'] == 1){?>
	    <input class="radio" type="radio" name="pay_ment" id="pay_ment" value="<?php echo $v['Payment']['id']?>" onclick="change_payment(this.value,<?php echo $order_info['Order']['id']?>);"><?php echo $v['PaymentI18n']['name']?>
	  <?php }?>
  	  <?php }?>
	  </p>
	  <br /><br />
	</div>
</div>
<!--修改支付方式 End-->
<?php }}?>	  
	  <p class="balances"><?php echo $SCLanguages['payment']?>:<b><?php echo $order_info['Order']['payment_name']?></b>。<?php echo $SCLanguages['payable_amount']?>:
	  	  <b>
	  	  <?//php echo $svshow->price_format($order_info['Order']['total'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($order_info['Order']['total']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($order_info['Order']['total'],$this->data['configs']['price_format']);?>	
			<?php }?> 	  	  
	  	  
	  	  </b>
	  	  <br /><?php //=$SCLanguages['delivery_versus_payment']?></p>
	</div>
</div>
<!--支付方式 End-->
  </div>

<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
