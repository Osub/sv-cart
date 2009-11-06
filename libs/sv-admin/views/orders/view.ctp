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
 * $Id: view.ctp 4551 2009-09-25 05:43:19Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."订单列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>
<style type="text/css">
table.products_infos th{
	border-bottom:3px solid #DBDBDB;
}
table.products_infos td{
	border-bottom:1px solid #E8F2F3;border-right:1px solid #E8F2F3;padding:3px 5px;font-family:arial;vertical-align:middle;
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
	background:url({$admin_webroot}img/handel_bg.gif) repeat-x;
}
table.handels th{
	border-right:1px solid #FAF9F8;
}
</style>
<!--Main Start-->


<div class="home_main">
    
<!--BaseInfo-->
	<div class="order_stat athe_infos order_base">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  订单详细</h1></div>
	  <div class="box" style="padding:10px">
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="50%">
			<table width="97%" cellpadding="0" cellspacing="0" class="order_view">
			<tr>
				<th width="20%" align="left">订单号：</th>
				<td width="80%"><?php echo $order_info['Order']['order_code']?> <?php echo $order_info['Order']['consignee']?> [<?php echo $html->link("发送/查看留言","/messages/index/{$order_info['Order']['user_id']}",array(),false,false);?>] <?php echo $html->link("编辑","/orders/edit/{$order_info['Order']['id']}",array("class"=>"green_4"),false,false);?></td>
			</tr>
			<tr>
				<th align="left">订单状态：</th>
				<td>
				<?php echo $systemresource_info["order_status"][$order_info['Order']['status']];?>
				</td>
			</tr>
			<tr>
				<th align="left">付款状态：</th>
				<td><?php echo $systemresource_info["payment_status"][$order_info['Order']['payment_status']];?> &nbsp&nbsp&nbsp&nbsp&nbsp <?php echo $order_info['Order']['payment_name'];?></td>
			</tr>
			<tr>
				<th align="left">配送状态：</th>
				<td><?php echo $systemresource_info["shipping_status"][$order_info['Order']['shipping_status']];?> &nbsp&nbsp&nbsp&nbsp&nbsp <?php if($order_info['Order']['shipping_id']>0){echo $order_info['Order']['shipping_name'];}else{echo "无需配送";}?></td>
			</tr>
			</table>
			</td>
			<td width="50%">
			<table width="97%" cellpadding="0" cellspacing="0" class="order_view" align="right">
			<tr>
				<th width="20%" align="left">发货单号：</th>
				<td width="80%"><?php if($order_info['Order']['shipping_status']==1 || $order_info['Order']['shipping_status']==2){?><?php echo $order_info['Order']['invoice_no']?><?php }?></td>
			</tr>
			<tr>
				<th align="left">下单域名：</th>
				<td ><?php echo $order_info['Order']['order_domain']?></td>
			</tr>
			<tr>
				<th align="left">订单货币：</th>
				<td><?php echo empty($order_info['Order']['order_currency'])?"RMB":$order_info['Order']['order_currency'];?></td>
			</tr>
			</table>
			</td>
		</tr>
		</table>
	  </div>
	</div>
<!--BaseInfo Stat End-->
<!--Product Infos-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  商品列表</h1></div>
	  <div class="box" style="padding:10px 0;">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="10%">&nbsp;</th>
	<th width="14%">商品货号</th>
	<th width="20%">商品名称</th>
	<th width="12%">商品属性</th>
	<th width="12%">市场价</th>
	<th width="12%">本店售价</th>
	<th width="8%">数量</th>
	<th width="12%">小计</th>
</tr>
<?php $sum = 0;if(isset($order_info['OrderProduct']) && sizeof($order_info['OrderProduct'])>0){?>
	<?php foreach($order_info['OrderProduct'] as $k=>$v){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $html->image($server_host.$root_all.$product_img_new[$v['product_id']]["Product"]["img_thumb"],array('align'=>'absmiddle'))?></td>
	<td><?php echo $html->link($v['product_code'],$server_host.$cart_webroot."products/{$v['product_id']}",array('target'=>'_blank'));?></td>
	<td><?php echo $html->link($v['product_name'],$server_host.$cart_webroot."products/{$v['product_id']}",array('target'=>'_blank'));?><?php if(!empty($v['delivery_note'])){?><br />注：<?php echo $v['delivery_note'];}?>&nbsp;</td>
	<td><?php echo $v['product_attrbute']?>&nbsp;</td>
	<td align="center"><?php echo sprintf($price_format,sprintf("%01.2f",$product_img_new[$v['product_id']]["Product"]["market_price"]));?></td>
	<td align="center"><?php echo sprintf($price_format,sprintf("%01.2f",$v['product_price']));?></td>
	<td align="center"><?php echo $v['product_quntity']?></td>
	<td align="center"><?php echo $v['total']?></td>
</tr>
<?php $sum=$sum+$product_img_new[$v['product_id']]["Product"]["market_price"]*$v['product_quntity'];}?>
<table cellpadding="6" cellspacing="0" width="100%" style="border-top:1px solid #ccc;">	

<tr>	
	<td style="padding-top:10px;">金额小计：
	  <?php echo sprintf($price_format,sprintf("%01.2f",$order_info['Order']['subtotal']));?>
	，<font color="#FF6300">市场价 <?php echo sprintf($price_format,sprintf("%01.2f",$sum));?> </font>
	</td>
</tr>
</table>
<?php }?>
</table>
<?php echo $form->create('Order',array('action'=>'edit_order_info'));?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="products_infos">
	<?php if(isset($order_packaging_list) && sizeof($order_packaging_list)>0){?>
	<tr>
	  	<th width="17%" height="28" valign="middle">包装名称</th>
		<th width="11%" valign="middle">包装价格</th>
		<th width="10%" valign="middle">包装数量</th>
		<th width="62%" valign="middle">备注</th>

	  </tr>
	<?php foreach($order_packaging_list as $k=>$v){?>
	  <tr>
	  <tbody>
	    <input name="OrderPackaging_id[]" type="hidden" value="<?php echo $v['OrderPackaging']['id']?>" />
	  	<td width="17%" height="28" valign="middle"><?php echo $v['OrderPackaging']['packaging_name'];?></td>
		<td width="11%" valign="middle"><?php echo $v['OrderPackaging']['packaging_fee']?></td>
		<td width="10%" valign="middle"><?php echo $v['OrderPackaging']['packaging_quntity']?></td>
		<td width="62%" valign="middle"><?php echo $v['OrderPackaging']['note']?></td>
	  </tbody></tr>
	<?php }}?>
	<?php if(isset($order_card_list) && sizeof($order_card_list)>0){?>
	<tr>
	  	<th width="17%" height="28" valign="middle">贺卡名称</th>
		<th width="11%" valign="middle">贺卡价格</th>
		<th width="10%" valign="middle">贺卡数量</th>
		<th width="62%" valign="middle">备注</th>

	  </tr>
	<?php foreach($order_card_list as $k=>$v){?>
	  <tr>
	  <tbody>
	    <input name="OrderCsrd_id[]" type="hidden" value="<?php echo $v['OrderCard']['id']?>" />
	  	<td width="17%" height="28" valign="middle"><?php echo $v['OrderCard']['card_name'];?></td>
		<td width="11%" valign="middle"><?php echo $v['OrderCard']['card_fee']?></td>
		<td width="10%" valign="middle"><?php echo $v['OrderCard']['card_quntity']?></td>
		<td width="62%" valign="middle"><?php echo $v['OrderCard']['note']?></td>
	  </tbody></tr>
	<?php }}?>
</table>
</div>
</div>
<!--Product Infos End-->

<!--TakeOver-->
	<div class="order_stat athe_infos order_base">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  收货人信息</h1></div>
	  <div class="box" style="padding:10px">
		<table width="100%" cellpadding="0" cellspacing="0" class="consignee">
		<tr>
			<th width="10%" align="left">收货人：</th>
			<td width="40%"><?php echo $order_info['Order']['consignee']?>&nbsp;</td>
			<th width="10%" class="description" align="left">区域：</th>
			<td ><?php foreach($regions as $k=>$v){if(!empty($new_regions_info[$v])){ foreach($new_regions_info[$v] as $kk=>$vv){ if($vv["Region"]["id"]==$v){ echo $vv["RegionI18n"]["name"];}}}}?>&nbsp;</td>
		</tr>
		<tr>
			<th width="10%" align="left">Email：</th>
			<td width="40%"><?php echo $order_info['Order']['email']?>&nbsp;</td>
			<th width="10%" class="description" align="left">地址：</th>
			<td><?php echo $order_info['Order']['address']?>&nbsp;</td>
		</tr>
		<tr>
			<th width="10%" align="left">邮编：</th>
			<td width="40%"><?php echo $order_info['Order']['zipcode']?>&nbsp;</td>
			<th width="10%" class="description" align="left">电话：</th>
			<td><?php echo $order_info['Order']['telephone']?>&nbsp;</td>
		</tr>
		<tr>
			<th width="10%" align="left">标志性建筑：</th>
			<td width="40%"><?php echo $order_info['Order']['sign_building']?>&nbsp;</td>
			<th width="10%" class="description" align="left">手机：</th>
			<td><?php echo $order_info['Order']['mobile']?>&nbsp;</td>
		</tr>
		<tr>
			<th width="10%" align="left" style="border:none;padding-bottom:0;">最佳送货时间：</th>
			<td width="40%" style="border:none;padding-bottom:0;"><?php echo $order_info['Order']['best_time']?>&nbsp;</td>
			<th width="10%" align="left" style="border:none;padding-bottom:0;">&nbsp;</th>
			<td width="40%" style="border:none;padding-bottom:0;">&nbsp;</td>
		</tr>
		</table>
	  </div>
	</div>
<!-- End-->



<!--Properies Stat-->
	<div class="order_stat properies expend_infos">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  金额小计</h1></div>
	  <div class="box" style="padding:10px">
		<table width="100%" cellpadding="0" cellspacing="0" class="consignee">
		<tr>
			<th width="10%" align="left">商品总金额：</th>
			<td width="40%"><?php echo sprintf($price_format,sprintf("%01.2f",$order_info['Order']['subtotal']))?><input type="hidden" id="subtotal" name="subtotal" value="<?php echo $order_info['Order']['subtotal']?>"></td>
			<th width="10%" class="description" align="left">折扣：</th>
			<td><?php echo $order_info['Order']['discount']?></td>
		</tr>
		<tr>
			<th width="10%" align="left">发票税额：</th>
			<td width="40%"><?php echo sprintf($price_format,sprintf("%01.2f",$order_info['Order']['tax']))?><input type="hidden" id="tax" name="tax" value="<?php echo $order_info['Order']['tax']?>"></td>
			<th width="10%" class="description" align="left">订单总金额：</th>
			<td><?php echo sprintf($price_format,sprintf("%01.2f",$order_info["Order"]["total"]));?></td>
		</tr>
		<tr>
			<th width="10%" align="left">配送费用：</th>
			<td width="40%"><?php echo $order_info['Order']['shipping_fee']?></td>
			<th  width="10%" class="description" align="left">已付款金额：</th>
			<td><?php echo sprintf($price_format,sprintf("%01.2f",$order_info["Order"]["money_paid"]));?></td>
		</tr>
		<tr>
			<th width="10%" align="left">保价费用：</th>
			<td width="40%"><?php echo $order_info['Order']['insure_fee']?></td>
			<th class="description" align="left">使用余额：</th>
			<td><?php echo sprintf($price_format,sprintf("%01.2f",$balance_log["UserBalanceLog"]["amount"]));?></td>
		</tr>
		<tr>
			<th width="10%" align="left">支付费用：</th>
			<td width="40%"><?php echo $order_info['Order']['payment_fee']?></td>
			<th width="10%" class="description" align="left">使用积分：</th>
			<td><?php echo $order_info["Order"]["point_use"];?></td>
		</tr>
		<tr>
			<th width="10%" align="left">包装费用：</th>
			<td width="40%"><?php echo $order_info['Order']['pack_fee']?></td>
			<th width="10%" class="description" align="left">积分抵扣：</th>
			<td><?php echo sprintf($price_format,sprintf("%01.2f",$order_info["Order"]["point_fee"]));?></td>
		</tr>
		<tr>
			<th width="10%" align="left">贺卡费用：</th>
			<td width="40%"><?php echo $order_info['Order']['card_fee']?></td>
			<th width="10%" class="description" align="left">使用红包：</th>
			<td><?php echo $order_info['Order']['coupon_fee']?></td>
		</tr>
		<tr>
			<th width="10%" align="left" style="border:none;padding-bottom:0;">应付款金额：</th>
			<td width="40%" style="border:none;padding-bottom:0;"><?php echo $order_info['Order']['amount_payable']?></td>
			<th width="10%" align="left" style="border:none;padding-bottom:0;">&nbsp;</th>
			<td width="40%" style="border:none;padding-bottom:0;">&nbsp;</td>
		</tr>

		</table>
		<div style="clear:both"></div>
	  </div>
	</div>
	<?php echo $form->end();?>
<!--Properies Stat End-->

<!--Product Photos-->
<div class="order_stat properies athe_infos">
	<div class="title"><h1>
	<?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	<?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	操作信息</h1></div>
	<div class="box" style="padding-left:0;padding-right:0;">
<div id="listDiv1">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="145px">操作时间</th>
	<th width="80px">操作者</th>
	<th width="80px">订单状态</th>
	<th width="80px">付款状态</th>
	<th width="80px">发货状态</th>
	<th>备注</th>
</tr>
<?php if(isset($action_list) && sizeof($action_list)>0){foreach($action_list as $k=>$v){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center" width="145px"><?php echo $v['OrderAction']['created']?></td>
	<td align="center" width="80px"><?php echo $v['Operator']['name']?></td>
	<td align="center" width="80px"><?php echo $systemresource_info["order_status"][$v['OrderAction']['order_status']];?></td>
	<td align="center" width="80px"><?php echo $systemresource_info["payment_status"][$v['OrderAction']['payment_status']];?></td>
	<td align="center" width="80px"><?php echo $systemresource_info["shipping_status"][$v['OrderAction']['shipping_status']];?></td>
	<td><?php echo $v['OrderAction']['action_note']?></td>
</tr>
<?php }?>
<?php }?>
</table></div>
</div></div>

<!--Product Photos End-->
</div></div>
<!--Main Start End-->
</div>
<script>
//列表鼠标划动效果
if (document.getElementById("listDiv1")){
	var this_bgcolor = "";
	document.getElementById("listDiv1").onmouseover = function(e){
	    obj = Utils.srcElement(e);
		if (obj){
			if (obj.parentNode.tagName.toLowerCase() == "tr") row = obj.parentNode;
				else if (obj.parentNode.parentNode.tagName.toLowerCase() == "tr") row = obj.parentNode.parentNode;
				else return;
				for (i = 0; i < row.cells.length; i++){
		        	if (row.cells[i].tagName != "TH"){
		        		this_bgcolor = row.cells[i].className;
		        		row.cells[i].className = 'hover';
		        	}
		 		}
		}
	}
	document.getElementById("listDiv1").onmouseout = function(e){
    	obj = Utils.srcElement(e);
		if (obj){
	      	if (obj.parentNode.tagName.toLowerCase() == "tr") row = obj.parentNode;
		      	else if (obj.parentNode.parentNode.tagName.toLowerCase() == "tr") row = obj.parentNode.parentNode;
		      	else return;
				for (i = 0; i < row.cells.length; i++){
		          	if (row.cells[i].tagName != "TH"){
		          		row.cells[i].className= this_bgcolor;
		          	}
		      	}
    	}
  	}
}
//end

</script>