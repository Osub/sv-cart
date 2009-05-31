<?php
/*****************************************************************************
 * SV-Cart 查看订单
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 1895 2009-05-31 13:03:01Z huangbo $
*****************************************************************************/
?>
<?if( $ctp_view == 'yes' ){?>
<?=$javascript->link('product');?>
<?=$javascript->link('order');?>
<?=$javascript->link('regions');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."订单列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>
<style type="text/css">
table.products_infos th{
	border-bottom:3px solid #DBDBDB;
}
table.products_infos td{
	border-bottom:1px solid #E8F2F3;border-right:1px solid #E8F2F3;padding:3px 5px;font-family:arial;
}
table.products_infos td.handle a{
	text-decoration:underline;
}
table.products_infos td input,table.products_infos td textarea{
	border:1px solid #629373;width:230px;
}
table.products_infos  table.profiles th{
	
}
table.products_infos td textarea{height:17px;*height:16px;overflow-y:scroll;}

table.handels{
	margin-top:10px;
}
table.handels tr.headers{
	background:url({$this->webroot}img/handel_bg.gif) repeat-x;
}
table.handels th{
	border-right:1px solid #FAF9F8;
}
</style>
<?}?>
<!--Main Start-->


<span id="ajax_view">
<div class="home_main">
  <?php echo $form->create('Order',array('action'=>'edit_order_info'));?>
  <input name="data[Order][id]" id="data_order_id" type="hidden" value="<?echo $order_info['Order']['id']?>" />
  <input type="hidden" name="act_type" id="act_type" value="baseinfo"></>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="40%" valign="top" style="padding-right:5px">
<!--BaseInfo-->
	<div class="order_stat athe_infos order_base">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  基本信息</h1></div>
	  <div class="box">
	  <br />
	  	<dl><dt>订单号：</dt><dd><font face="arial"><?echo $order_info['Order']['order_code']?></font></dd></dl>
		<dl><dt>购货人：</dt><dd><font face="arial"><?echo $order_info['Order']['consignee']?></font>[<?=$html->link("显示购货人信息","/users/{$order_info['Order']['user_id']}",array("class"=>"none"),false,false);?>] [<?=$html->link("发送/查看留言","/messages/index/{$order_info['Order']['user_id']}",array("class"=>"none"),false,false);?>]</dd></dl>
  	    <dl><dt>支付方式：</dt><dd>
  	<?if(isset($payment_list) && sizeof($payment_list)>0){?>
  	<?foreach($payment_list as $k=>$v){?>
		<?if($order_info['Order']['payment_id'] == $v['Payment']['id']){ echo $v['PaymentI18n']['name'];}?>
	<?}}?>
		<input type="button" name="Payment_edit" value="编辑" onclick="status_edit_show(this)">
  	    </dd></dl>
<span style="display:none" id="Payment_edit_id">
  	<?if(isset($payment_list) && sizeof($payment_list)>0){?>
  	<?foreach($payment_list as $k=>$v){?>
		<p class="langs"><input class="radio" type="radio" style="width:auto;border:0;" value="<?echo $v['Payment']['id']?>" name="data[Order][payment_id]" <?if($order_info['Order']['payment_id'] == $v['Payment']['id']){?>checked<?}?>/><?echo $v['PaymentI18n']['name']?></p>
		<p class="alt"><?echo $v['PaymentI18n']['description']?></p>
	<?}}?>
</span>
  	 <dl><dt>配送方式：</dt>
  	<dd>
    <?if(isset($shipping_list) && sizeof($shipping_list)>0){?>
	<?foreach($shipping_list as $k=>$v){?>
		<?if($order_info['Order']['shipping_id'] == $v['Shipping']['id']){echo $v['ShippingI18n']['name'];}//echo "  ￥".$v['Shipping']['shipping_fee'];}?>
	<?}}?>
  	<input type="button" name="Shipping_edit" value="编辑" onclick="status_edit_show(this)">
  	</dd></dl>
<span style="display:none" id="Shipping_edit_id">
  	<?if(isset($shipping_list) && sizeof($shipping_list)>0){?>
	<?foreach($shipping_list as $k=>$v){?>
		<p class="langs"><span>￥<?echo $v['Shipping']['shipping_fee']?></span><input type="radio" class="radio" style="width:auto;border:0;" value="<?echo $v['Shipping']['id']?>" name="data[Order][shipping_id]" <?if($order_info['Order']['shipping_id'] == $v['Shipping']['id']){?>checked<?}?> /><?echo $v['ShippingI18n']['name']?></p>
		<p class="alt"><?echo $v['ShippingI18n']['description']?></p>
	<?}}?>
</span>
		<dl><dt>发货单号：</dt><dd><font face="arial"><?if($order_info['Order']['invoice_no']){?><?echo $order_info['Order']['invoice_no']?><?}else{?><input type="text" name="data[Order][invoice_no]"></><?}?></font></dd></dl>
		<dl><dt>订单状态：</dt><dd><font face="arial"><?if($order_info['Order']['status'] == 0){?>未确认&nbsp;<?}elseif($order_info['Order']['status'] == 1){?>已确认&nbsp;<?}elseif($order_info['Order']['status'] == 2){?>已取消&nbsp;<?}elseif($order_info['Order']['status'] == 3){?>无效&nbsp;<?}elseif($order_info['Order']['status'] == 4){?>退货&nbsp;<?}?>
		<?if($order_info['Order']['payment_status'] == 0){?>未付款&nbsp;<?}elseif($order_info['Order']['payment_status'] == 1){?>付款中&nbsp;<?}elseif($order_info['Order']['payment_status'] == 2){?>已付款&nbsp;<?}?>
		<?if($order_info['Order']['shipping_status'] == 0){?>未发货&nbsp;<?}elseif($order_info['Order']['shipping_status'] == 1){?>已发货&nbsp;<?}elseif($order_info['Order']['shipping_status'] == 2){?>已收货&nbsp;<?}elseif($order_info['Order']['shipping_status'] == 3){?>备货中&nbsp;<?}?></font></dd></dl>
		<dl><dt>下单时间：</dt><dd><font face="arial"><?echo $order_info['Order']['created']?></font></dd></dl>
		<dl><dt>付款时间：</dt><dd><font face="arial"><?if($order_info['Order']['payment_status'] == 1 || $order_info['Order']['payment_status'] == 2){?><?echo $order_info['Order']['payment_time']?><?}else{?>未付款<?}?></font></dd></dl>
		<dl><dt>发货时间：</dt><dd><font face="arial"><?if($order_info['Order']['shipping_status'] == 1 || $order_info['Order']['shipping_status'] == 2){?><?echo $order_info['Order']['shipping_time']?><?}else{?>未付款<?}?></font></dd></dl>
		
		<dl><dt>订单来源：</dt><dd><font face="arial"><?echo $order_info['Order']['referer']?></font></dd></dl>
		
		<br />
	  </div>
	</div>
<!--BaseInfo Stat End-->
</td>
<td valign="top" width="58%" style="padding-left:5px;">
			
<!--TakeOver-->
	<div class="order_stat athe_infos tongxun orders_config">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  收货人信息</h1></div>
	  <div class="box">
	  	<dl><dt>标签：</dt><dd>
		<span id='regions_names'><?=$order_info['Order']['regions_names']?></span></dd></dl>
		<dl><dt>从已有收货地址中选择：</dt><dd>
		<select style="width:318px;" onchange="onchange_address(this)">
		
		<?if(isset($all_address) && sizeof($all_address)>0){?>
		<?foreach($all_address as $key=>$val){?>
		   <option value="<?echo $val['UserAddress']['id']?>"><?echo $val['UserAddress']['regions_locale']?></option>
		<?}}?>
		</select></dd></dl>
		<dl><dt>收货人：</dt><dd><input type="text" class="text_inputs" style="width:150px;" name="data[Order][consignee]" id="OrderConsignee" value="<?echo $order_info['Order']['consignee']?>"/> <font color="#F90000">*</font></dd></dl>
		<dl><dt>区域：</dt><dd>
	<span id="regions"></span><span id="region_loading" style="display:none;"><?=$html->image('regions_loader.gif')?></span></dd></dl>
	
		<script type="text/javascript">
		show_regions("<?echo $order_info['Order']['regions']?>");
	</script>
		<dl><dt>电子邮件：</dt><dd><input type="text" class="text_inputs" style="width:285px;" name="data[Order][email]" id="OrderEemail"  value="<?echo $order_info['Order']['email']?>" /> <font color="#F90000">*</font></dd></dl>
		<dl><dt>地址：</dt><dd><input type="text" class="text_inputs" style="width:285px;" name="data[Order][address]" id="OrderAddress"  value="<?echo $order_info['Order']['address']?>" /> <font color="#F90000">*</font></dd></dl>
		<dl><dt>邮编：</dt><dd><input type="text" class="text_inputs" style="width:150px;" name="data[Order][zipcode]" id="OrderZipcode" value="<?echo $order_info['Order']['zipcode']?>" /></dd></dl>
		<dl><dt>电话：</dt><dd><input type="text" class="text_inputs" style="width:150px;" name="data[Order][telephone]" id="OrderTelephone" value="<?echo $order_info['Order']['telephone']?>" /> <font color="#F90000">*</font></dd></dl>
		<dl><dt>手机：</dt><dd><input type="text" class="text_inputs" style="width:150px;" name="data[Order][mobile]" id="Ordermobile" value="<?echo $order_info['Order']['mobile']?>" /> <font color="#F90000">*</font></dd></dl>
	
		<dl><dt>标志性建筑：</dt><dd><input type="text" class="text_inputs" style="width:285px;" name="data[Order][sign_building]" id="OrderSignBuilding" value="<?echo $order_info['Order']['sign_building']?>" /></dd></dl>
		<dl><dt>最佳送货时间：</dt><dd><input type="text" class="text_inputs" style="width:285px;" name="data[Order][best_time]" id="OrderBestTime" value="<?echo $order_info['Order']['best_time']?>" /></dd></dl>
	  </div>
	</div>
<!--TakeOver End-->
<!--Other Stat-->
	<div class="order_stat athe_infos tongxun">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  其他信息</h1></div>
	  <div class="box">
		<dl><dt>客户给商家留言：</dt><dd><textarea style="width:355px;height:60px;border:1px solid #649776;overflow-y:scroll" name="data[Order][postscript]" id="data_order_postscript" ><?echo $order_info['Order']['postscript']?></textarea></dd></dl>
		<dl><dt>商家给客户的留言：</dt><dd><textarea style="width:355px;height:60px;border:1px solid #649776;overflow-y:scroll" id="data_order_to_buyer" name="data[Order][to_buyer]"><?echo $order_info['Order']['to_buyer']?></textarea></dd></dl>
		<dl><dt>发票类型：</dt><dd><input type="text" name="data[Order][invoice_type]" id="data_order_invoice_type" class="text_inputs" style="width:198px;" value="<?echo $order_info['Order']['invoice_type']?>"/></dd></dl>
		<dl><dt>发票抬头：</dt><dd><input type="text" name="data[Order][invoice_payee]" id="data_order_invoice_payee" class="text_inputs" style="width:198px;" value="<?echo $order_info['Order']['invoice_payee']?>"/></dd></dl>
		<dl><dt>发票内容：</dt><dd><textarea name="data[Order][invoice_content]" id="data_order_invoice_content" style="width:355px;height:60px;border:1px solid #649776;overflow-y:scroll"><?echo $order_info['Order']['invoice_content']?></textarea></dd></dl>
		<dl><dt>缺货处理：</dt><dd><input type="text" id="data_order_how_oos" class="text_inputs" style="width:198px;" value="<?echo $order_info['Order']['how_oos']?>" name="data[Order][how_oos]"/></dd></dl>
		<span style="display:none"><dl><dt>包装：</dt><dd><input type="text" id="data_order_pack_name" class="text_inputs" style="width:198px;" value="<?echo $order_info['Order']['pack_name']?>" name="data[Order][pack_name]"/></dd></dl>
		</span>
	    <dl><dt>备注：</dt><dd><textarea id="data_order_note" name="data[Order][note]" style="width:355px;height:60px;border:1px solid #649776;overflow-y:scroll"><?echo $order_info['Order']['note']?></textarea></dd></dl>
		
  	  </div>
	</div>
<!--Other Stat End-->

</td>
</tr>

</table>
<p class="submit_btn"><input type="button" value="确定" onclick="baseinfo_submit()" /><input type="reset" value="重置" /></p>
<? echo $form->end();?>

<!--Product Infos-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  商品信息</h1></div>
	  <div class="box" style="padding:10px 0;">

<?php echo $form->create('Order',array('action'=>'edit_order_info'));?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="products_infos">
  <input name="order_id" type="hidden" value="<?echo $order_info['Order']['id']?>" />
  <input type="hidden" name="act_type" value="products">
	  <tr>
	  	<th width="17%" height="28" valign="middle">商品名称</th>
		<th width="11%" valign="middle">货号</th>
		<th width="10%" valign="middle">价格</th>
		<th width="8%" valign="middle">数量</th>
		<th width="30%" valign="middle">属性</th>
		<th width="10%" valign="middle">小计</th>
		<th width="14%" valign="middle">操作</th>
	  </tr>
	  	  <?if(isset($order_info['OrderProduct']) && sizeof($order_info['OrderProduct'])>0){?>
	<?foreach($order_info['OrderProduct'] as $k=>$v){?>
	  <tr>
	  <tbody>
	    <input name="rec_id[]" type="hidden" value="<?echo $v['id']?>" />
	  	<td width="17%" height="28" valign="middle"><?php echo $html->link($v['product_name'],"../../products/{$v['product_id']}",array('target'=>'_blank'));?></td>
		<td width="11%" valign="middle"><?echo $v['product_code']?></td>
		<td width="10%" valign="middle"><input type="text" name="product_price[]" value="<?echo $v['product_price']?>" style="width:75px;text-align:right;" /></td>
		<td width="8%" valign="middle"><input type="text" id="product_quntity[]" name="product_quntity[]" value="<?echo $v['product_quntity']?>" style="width:45px; text-align:right;" onblur="javascript:check_input(this);"/></td>
		<td width="30%" valign="middle"><textarea name="product_attrbute[]"><?echo $v['product_attrbute']?></textarea></td>
		<td width="10%" align="right" valign="middle"><?echo $v['total']?></td>
		<td width="14%" valign="middle" class="handle"><?if($order_info['Order']['shipping_status'] != 0){?><?//=$html->link("删除","/orders/drop_order_products/{$v['id']}/{$order_info['Order']['id']}",'',false,false);?><?}?></td>
	  </tbody></tr>
	<?}}?>
<tr>
	  <tbody>
		<td valign="middle" colspan="4"><pre>  <font color="#F90000">备注：商品价格中已包含属性加价</font></pre></td>
		<td align="right" valign="middle"><strong>合计：</strong></td>
		<td valign="middle" align="right"><?echo $order_info['Order']['subtotal']?></td>
		<td valign="middle" align="center"><?if($order_info['Order']['shipping_status'] == 0){?><input type="button" value="更新商品" onclick="update_order_product()" style="background:url(<?=$this->webroot?>img/upload.gif) no-repeat;width:78px;height:22px;border:0;font-size:12px;cursor:pointer" /><?}?></td>
	  </tbody></tr>
	<?if(isset($order_packaging_list) && sizeof($order_packaging_list)>0){?>
	<tr>
	  	<th width="17%" height="28" valign="middle">包装名称</th>
		<th width="11%" valign="middle">包装价格</th>
		<th width="10%" valign="middle">包装数量</th>
		<th width="62%" valign="middle">备注</th>

	  </tr>
	<?foreach($order_packaging_list as $k=>$v){?>
	  <tr>
	  <tbody>
	    <input name="OrderPackaging_id[]" type="hidden" value="<?echo $v['OrderPackaging']['id']?>" />
	  	<td width="17%" height="28" valign="middle"><?php echo $v['OrderPackaging']['packaging_name'];?></td>
		<td width="11%" valign="middle"><?echo $v['OrderPackaging']['packaging_fee']?></td>
		<td width="10%" valign="middle"><?echo $v['OrderPackaging']['packaging_quntity']?></td>
		<td width="62%" valign="middle"><?echo $v['OrderPackaging']['note']?></td>
	  </tbody></tr>
	<?}}?>
	<?if(isset($order_card_list) && sizeof($order_card_list)>0){?>
	<tr>
	  	<th width="17%" height="28" valign="middle">贺卡名称</th>
		<th width="11%" valign="middle">贺卡价格</th>
		<th width="10%" valign="middle">贺卡数量</th>
		<th width="62%" valign="middle">备注</th>

	  </tr>
	<?foreach($order_card_list as $k=>$v){?>
	  <tr>
	  <tbody>
	    <input name="OrderCsrd_id[]" type="hidden" value="<?echo $v['OrderCard']['id']?>" />
	  	<td width="17%" height="28" valign="middle"><?php echo $v['OrderCard']['card_name'];?></td>
		<td width="11%" valign="middle"><?echo $v['OrderCard']['card_fee']?></td>
		<td width="10%" valign="middle"><?echo $v['OrderCard']['card_quntity']?></td>
		<td width="62%" valign="middle"><?echo $v['OrderCard']['note']?></td>
	  </tbody></tr>
	<?}}?>
</table><? echo $form->end();?>
<?php echo $form->create('',array('action'=>'edit_order_info','name'=>'UpdateOrder','onsubmit'=>'return false;'));?>
	  <input name="order_id" type="hidden" value="<?echo $order_info['Order']['id']?>" />
  <input type="hidden" name="act_type" id="insert_products" value="insert_products" />
  <input type="hidden" name="product_id" id="product_id" />
	  <tr><td colspan="7" height="60">
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;按商品编号或商品名称或商品货号搜索
	  <input type="text" name="keywords" id="keywords"/>
	  <input type="button" value="搜索" style="background:url(<?=$this->webroot?>img/upload.gif) no-repeat;width:78px;height:22px;border:0;font-size:12px;cursor:pointer" onclick="searchProducts();"/>
	  <select name="productslist" id="productslist" onchange="getProductInfo(this.value)">
	    <option>请选择商品</option>
	  </select></td>
	  </tr>
	  <tr>
	  <td colspan="7" style="padding:0;border:0;">
	  	  <span style="display:none" id="showhidess">
	  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="profiles" >
		  <tr><tbody>
			<th width="11%" height="28" style="border-right:1px solid #E8F2F3;border-bottom:1px solid #E8F2F3;">商品名称</th>
			<td width="88%" ><input name="product_name" id="product_name" style="border:0" readonly /></td>
		  </tbody></tr>
		  <tr><tbody>
			<th width="11%" height="28" style="border-right:1px solid #E8F2F3;border-bottom:1px solid #E8F2F3;">货号</th>
			<td width="88%"><input name="product_code" id="product_code" style="border:0" readonly /></td>
		  </tbody></tr>
		  <tr><tbody>
			<th width="11%" height="28" style="border-right:1px solid #E8F2F3;border-bottom:1px solid #E8F2F3;">分类</th>
			<td width="88%"><input name="product_cat" id="product_cat" style="border:0" readonly /></td>
			<input name="cat_id" id="cat_id" type="hidden">
		  </tbody></tr>
		  <tr><tbody>
			<th width="11%" height="28" style="border-right:1px solid #E8F2F3;border-bottom:1px solid #E8F2F3;">品牌</th>
			<td width="88%" ><input name="product_brand" id="product_brand" style="border:0" readonly /></td>
			<input name="brand_id" id="brand_id" type="hidden">
		  </tbody></tr>
		  <tr><tbody>
			<th width="11%" height="28" style="border-right:1px solid #E8F2F3;border-bottom:1px solid #E8F2F3;">价格</th>
			<td width="88%" ><input name="shop_price" id="shop_price" style="border:0" readonly /></td>
		  </tbody></tr>
		  <tr><tbody>
			<th width="11%" height="28" style="border-right:1px solid #E8F2F3;border-bottom:1px solid #E8F2F3;">属性<input type="hidden" name="spec_count" value="0" id="spec_count"/></th>
			<td width="88%" id="product_attr" name="product_attr" readonly/></td>
		  </tbody></tr>
		  <tr><tbody>
			<th width="11%" height="28" style="border-right:1px solid #E8F2F3;border-bottom:1px solid #E8F2F3;">数量</th>
			<td width="88%"><input type="text" value="1" style="width:75px" id="product_number" name="product_number" onblur="javascript:check_input(this);"/></td>
		  </tbody></tr>
	  </table>
	  </td>
	  </tr>
	  </table>
	  <p class="submit_btn"><span><input type="button" value="加入订单" onclick="insert_productses()"/></span></p></span><br />
<? echo $form->end();?>		
	  </div>
	</div>
<!--Product Infos End-->


<!--Properies Stat-->
<?php echo $form->create('Order',array('action'=>'edit_order_info'));?>
  <input name="order_id" type="hidden" value="<?echo $order_info['Order']['id']?>" />
  <input type="hidden" name="act_type" value="money"></>
	<div class="order_stat properies expend_infos">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  费用信息</h1></div>
	  <div class="box">
	  <div class="properies_left">
		<dl><dt>商品总金额：</dt><dd><?echo sprintf($price_format,sprintf("%01.2f",$order_info['Order']['subtotal']))?><input type="hidden" id="subtotal" name="subtotal" value="<?echo $order_info['Order']['subtotal']?>"></dd></dl>
		<dl><dt>发票税额：</dt><dd><input type="text" id="tax" name="tax" value="<?echo $order_info['Order']['tax']?>" style="width:110px;" /></dd></dl>
		<dl><dt>配送费用：</dt><dd><input type="text" id="shipping_fee" name="shipping_fee" value="<?echo $order_info['Order']['shipping_fee']?>" style="width:110px;" /></dd></dl>
		<dl><dt>保价费用：</dt><dd><input type="text" style="width:110px;" id="insure_fee" name="insure_fee" value="<?echo $order_info['Order']['insure_fee']?>"/></dd></dl>
		<dl><dt>支付费用：</dt><dd><input type="text" style="width:110px;" id="payment_fee" name="payment_fee" value="<?echo $order_info['Order']['payment_fee']?>"/></dd></dl>
		<dl><dt>包装费用：</dt><dd><input type="text" style="width:110px;" id="pack_fee" name="pack_fee" value="<?echo $order_info['Order']['pack_fee']?>"/></dd></dl>
		<dl><dt>贺卡费用：</dt><dd><input type="text" style="width:110px;" id="card_fee" name="card_fee" value="<?echo $order_info['Order']['card_fee']?>"/></dd></dl>
		
		</div>
		
		<div class="properies_left" style="float:right;">
		<dl><dt>折扣：</dt><dd><input type="text" style="width:110px;" id="discount" name="discount" value="<?echo $order_info['Order']['discount']?>" /></dd></dl>
		<dl><dt>订单总金额：</dt><dd><?echo sprintf($price_format,sprintf("%01.2f",$order_info["Order"]["total"]));?><input type="hidden" name="total" value="<?echo $order_info['Order']['total']?>"></dd></dl>
		<dl><dt>已付款金额：</dt><dd><?echo sprintf($price_format,sprintf("%01.2f",$order_info["Order"]["money_paid"]));?><input type="hidden" name="money_paid" value="<?echo $order_info['Order']['money_paid']?>"></dd></dl>
		<dl><dt>使用余额：</dt><dd><dd><?echo sprintf($price_format,sprintf("%01.2f",$balance_log["UserBalanceLog"]["amount"]));?><input type="hidden" name="balance" value="<?echo $user_info['User']['balance']?>"></dd></dd>
		</dl>
		<dl><dt>使用积分：</dt><dd><?echo $order_info["Order"]["point_use"];?><input type="hidden" name="point" value="<?echo $order_info['Order']['point_use']?>"></dd></dl>
		<dl><dt>积分抵扣：</dt><dd><?echo sprintf($price_format,sprintf("%01.2f",$order_info["Order"]["point_fee"]));?><input type="hidden" name="point" value="<?echo $order_info['Order']['point_fee']?>"></dd></dl>
		<dl><dt>使用红包：</dt><dd>
			<?echo $order_info['Order']['coupon_fee']?>
			<select id="coupon_fee_id">
			<option value="0">请选择...</option>
			<?foreach( $coupon_types_list as $k=>$v ){?>
				<option value="<?=$v['CouponType']['id']?>" <?if($v["CouponType"]["id"]==$coupon_info["Coupon"]["coupon_type_id"]){?>selected<?}?>><?=$v["CouponTypeI18n"]["name"]?></option>
			<?}?>
			</select></dd></dl>
		<dl><dt>应付款金额：</dt><dd><?echo $order_info['Order']['amount_payable']?></dd></dl>
		
		</div>
		<div style="clear:both"></div>
		<p class="submit_btn"><input type="button" value="确定" onclick="order_fee_information()" /><input type="reset" value="重置" /></p>
	  </div>
	</div>
	<?echo $form->end();?>
<!--Properies Stat End-->

<!--Product Photos-->

<input name="order_id" id="order_id" type="hidden" value="<?echo $order_info['Order']['id']?>" />
	<div class="order_stat properies athe_infos">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  操作信息</h1></div>
	  <div class="box" style="padding-left:0;padding-right:0;">
	  <dl><dt style="padding-top:25px;padding-right:10px;">操作备注：</dt><dd><textarea style="width:580px;height:55px;border:1px solid #629373;overflow-y:scroll;" name="action_note" id="action_note"></textarea></dd></dl>
	  <div id="handle_detail">
	<dl><dt style="padding-right:10px;"></dt>
		<dd class="orders_submits">
		<?php echo $form->create('Order',array('action'=>'assign_operator/'.$order_info['Order']['id']));?>
				<span><input type="button" value="指派给" onclick="change_data_Operator_id()" /></span>
				<select name="data[Operator][id]" id="data_Operator_id">
					<option value="0" >请选择...</option>
					<?foreach( $operator_info as $k=>$v ){?>
					<option value="<?=$v['Operator']['id']?>" <?if($order_info['Order']['operator_id']==$v['Operator']['id']){?>selected<?}?>><?=$v['Operator']['name']?></option>
					<?}?>
				</select>
		<?echo $form->end();?>
			</dd></dl>
		<dl><dt style="padding-right:10px;">当前可执行操作：</dt>
		<dd class="orders_submits">
		  <?if(isset($order_action['confirm']) && $order_action['confirm']){?>
			<span><input type="button" value="确认" onclick="orderaction(this)" name="confirm" /></span>
		  <?}?>
		  <?if(isset($order_action['pay']) && $order_action['pay']){?>
			<span><input type="button" value="付款" name="pay" id="pay" onclick="orderaction(this)"/></span>
		  <?}?>
		  <?if(isset($order_action['unpay']) && $order_action['unpay']){?>
			<span><input type="button" value="设为未付款" name="unpay_detail" onclick="order_show_hide('unpay_detail_id')"/></span>
		  <?}?>
		  <?if(isset($order_action['prepare']) && $order_action['prepare']){?>
			<span><input type="button" value="配货" name="prepare" id="prepare" onclick="orderaction(this)"/></span>
		  <?}?>
		  <?if(isset($order_action['ship']) && $order_action['ship']){?>
			<span><input type="button" value="发货" <?if($virtual_card_status == 'yes'){?>name="ship" id="ship" onclick="orderaction(this)"<?}else{?> onclick="order_show_hide('ship_detail_id')"<?}?>/></span>
		  <?}?>
		  <?if(isset($order_action['unship']) && $order_action['unship']){?>
			<span><input type="button" value="未发货" name="unship" id="unship" onclick="orderaction(this)"/></span>
		  <?}?>
		  <?if(isset($order_action['receive']) && $order_action['receive']){?>
			<span><input type="button" value="已收货" name="receive" id="receive" onclick="orderaction(this)"/></span>
		  <?}?>
		  <?if(isset($order_action['cancel']) && $order_action['cancel']){?>
			<span><input type="button" value="取消" name="cancel_detail" onclick="order_show_hide('cancel_detail_id')" /></span>
		  <?}?>
		  <?if(isset($order_action['invalid']) && $order_action['invalid']){?>
			<span><input type="button" value="无效" name="invalid" id="invalid" onclick="orderaction(this)"/></span>
		  <?}?>
		  <?if(isset($order_action['return']) && $order_action['return']){?>
			<span><input type="button" value="退货" name="return_detail" onclick="order_show_hide('return_detail_id')" /></span>
		  <?}?>
		    <span><input type="button" value="售后" name="after_service" id="after_service" onclick="orderaction(this)"/></span>
		  <?if(isset($order_action['remove']) && $order_action['remove']){?>
			<span><input type="button" value="删除" name="remove" id="remove" onclick="orderaction(this)"/></span>
		  <?}?>
			</dd></dl></div>
<!--发货详细框-->
<div id="ship_detail_id" style="display:none">
<dl><dt style="padding-right:10px;">发货单号：</dt>
<dd><input style="border:1px solid #629373;overflow-y:scroll;" name="invoice_no" id="invoice_no" ></dd></dl>
<dl><dt style="padding-right:10px;"></dt>
<dd class="orders_submits"><span><input type="button" value="确定" <?if($virtual_card_status == 'no'){?>name="ship" id="ship" onclick="orderaction(this)"<?}?> /></span><span><input type="button" value="取消" onclick="come_to_back()"/></span></dd>
</dl>
</div>
<!--设为未付款详细框-->
<div id="unpay_detail_id" style="display:none">
<dl><dt style="padding-right:10px;">退款方式：</dt>
	<dd>
		<input type="radio" name="refund[]" value="1" />退回用户余额<br>
		<input type="radio" name="refund[]" value="2" />生成退款申请<br>
		<input type="radio" name="refund[]" value="3" />不处理，误操作时选择此项<br>
	</dd>
</dl>
<dl><dt style="padding-right:10px;">退款说明：</dt>
	<dd><textarea name="refund_note" cols="60" rows="3" id="refund_note"></textarea></dd>
</dl>
<dl><dt style="padding-right:10px;"></dt>
	<dd class="orders_submits" style=""><span><input type="button" value="确定" name="unpay" id="unpay" onclick="orderaction(this)"/></span><span><input type="button" value="取消" onclick="come_to_back()"/></span></dd>
</dl>
</div>

<!--取消详细框-->
<div id="cancel_detail_id" style="display:none">
<dl><dt style="padding-right:10px;">取消原因：</dt>
<dd><textarea name="cancel_note" cols="60" rows="3" id="cancel_note"></textarea></dd></dl>
<dl><dt style="padding-right:10px;">退款方式：</dt>
	
<dl><dd>
<input type="radio" name="refund_cancel[]" value="1" id="refund_cancel1"/>退回用户余额<br>
<input type="radio" name="refund_cancel[]" value="2" id="refund_cancel2"/>生成取消申请<br>
<input type="radio" name="refund_cancel[]" value="3" id="refund_cancel3"/>不处理，误操作时选择此项<br>
</dd></dl>
	
<dl><dt style="padding-right:10px;">退款说明：</dt>
<dd><textarea name="refund_cancel_note" cols="60" rows="3" id="refund_cancel_note"></textarea>
</dd></dl>
<dl><dt style="padding-right:10px;"></dt>
<dd class="orders_submits"><span><input type="button" value="确定" name="cancel" id="cancel" onclick="orderaction(this)"/></span><span><input type="button" value="取消" onclick="come_to_back()"/></span></dd>
</dl>	
</div>

<!--退货详细框-->

<div id="return_detail_id" style="display:none">
<dl><dt style="padding-right:10px;">退款方式：</dt>
	
<dd>
<input type="radio" name="refund_return[]" value="1" id="refund_return1"/>退回用户余额<br>
<input type="radio" name="refund_return[]" value="2" id="refund_return2"/>生成取消申请<br>
<input type="radio" name="refund_return[]" value="3" id="refund_return3"/>不处理，误操作时选择此项<br>
</dd></dl>

<dl><dt style="padding-right:10px;">退款说明：</dt>
<dd><textarea name="refund_return_note" cols="60" rows="3" id="refund_return_note"></textarea></dd></dl>
<dl>
<dt style="padding-right:10px;"></dt>
<dd class="orders_submits"><span><input type="button" value="确定" name="return" id="return" onclick="orderaction(this)"/></span><span><input type="button" value="取消" onclick="come_to_back()"/></span></dd>
</dl>
</div>

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="handels">
	<tr class="headers">
			<th height="30" width="19%">操作者：</th><th width="22%">操作时间</th><th width="12%">订单状态</th><th width="12%">付款状态</th><th width="12%">发货状态</th><th width="17%">备注</th>
		</tr>
	<?if(isset($action_list) && sizeof($action_list)>0){?>
		<?foreach($action_list as $k=>$v){?>
		<tr>
			<td align="center" height="30" width="19%"><?echo $v['Operator']['name']?>&nbsp;</td>
			<td align="center" width="22%"><?echo $v['OrderAction']['created']?>&nbsp;</td>
			<td align="center" width="12%"><?if($v['OrderAction']['order_status'] == 0){?>未确认&nbsp;<?}elseif($v['OrderAction']['order_status'] == 1){?>已确认&nbsp;<?}elseif($v['OrderAction']['order_status'] == 2){?>已取消&nbsp;<?}elseif($v['OrderAction']['order_status'] == 3){?>无效&nbsp;<?}elseif($v['OrderAction']['order_status'] == 4){?>退货&nbsp;<?}?>&nbsp;</td>
			<td align="center" width="12%"><?if($v['OrderAction']['payment_status'] == 0){?>未付款&nbsp;<?}elseif($v['OrderAction']['payment_status'] == 1){?>付款中&nbsp;<?}elseif($v['OrderAction']['payment_status'] == 2){?>已付款&nbsp;<?}?>&nbsp;</td>
			<td align="center" width="12%"><?if($v['OrderAction']['shipping_status'] == 0){?>未发货&nbsp;<?}elseif($v['OrderAction']['shipping_status'] == 1){?>已发货&nbsp;<?}elseif($v['OrderAction']['shipping_status'] == 2){?>已收货&nbsp;<?}elseif($v['OrderAction']['shipping_status'] == 3){?>备货中&nbsp;<?}?>&nbsp;</td>
			<td align="center" width="17%"><?echo $v['OrderAction']['action_note']?>&nbsp;</td>
		</tr>
		<?}?>
	<?}?>
</table>
</div></div>

<!--Product Photos End-->
</div></div>
<!--Main Start End-->
</div>
</span>
<script type="text/javascript">
	
	function status_edit_show(obj){
		var edit_obj = document.getElementById(obj.name+"_id");
	
		if(edit_obj.style.display == "none"){
			edit_obj.style.display = "block";
			obj.value="返回";
		}else{
			edit_obj.style.display = "none";
			obj.value="编辑";
		
		}
	
	}
	
	
	var virtual_card_status = '<?=$virtual_card_status?>';
	var regions = "<?echo $order_info['Order']['regions']?>"

	//必填控制
	var write_order_unpay_remark = "<?=$write_order_unpay_remark?>";//设置订单为“未付款”时
	var write_order_ship_remark = "<?=$write_order_ship_remark?>";//设置订单为“已发货”时
	var write_order_receive_remark = "<?=$write_order_receive_remark?>";//设置订单为“收货确认”时:
	var write_order_unship_remark = "<?=$write_order_unship_remark?>";//设置订单为“未发货”时
	var write_order_return_remark = "<?=$write_order_return_remark?>";//退货时:
	var write_order_invalid_remark = "<?=$write_order_invalid_remark?>";//把订单设为无效时:
	var write_order_cancel_remark = "<?=$write_order_cancel_remark?>";//取消订单时:  	

//	alert(write_order_unpay_remark);
</script>

