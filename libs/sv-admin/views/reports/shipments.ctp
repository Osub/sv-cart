<?php
/*****************************************************************************
 * SV-Cart  待发货单管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: shipments.ctp 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($orders);?>
<!--Search-->

	
	
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'shipments'));?>
	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" class="time" name="start_time" value="<?php echo $start_time?>" id="date" readonly="readonly" /><button type="button" id="show"><?=$html->image('calendar.gif')?></button>－<input type="text" class="time" name="end_time" value="<?php echo $end_time?>" id="date2" readonly="readonly"  /><button type="button" id="show2" ><?=$html->image('calendar.gif')?></button></p></dd>
	<dt style="" class="curement"><input type="submit" value="查询" /></dt>
	</dl>
<?php $form->end()?>
</div>
<br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist procurements">
	<li class="item_number">订单号</li>
	<li class="name ship_name">姓名</li>
	<li class="profiles addresse">地址</li>
	<li class="number">电话</li>
	<li class="units">付款方式</li>
	<li class="supplier">付款日期</li>
	<li class="remark">金额总计</li></ul>
	<?if(isset($orders) && sizeof($orders)>0){?>
	<?php foreach($orders as $order){?>
	<ul class="product_llist procurements procurements_list">
	<li class="item_number ordernumber"><span><?=$html->image('menu_plus.gif')?><?php echo $order['Order']['order_code']?></span></li>
	<li class="name ship_name"><?php echo $order['Order']['consignee']?></li>
	<li class="profiles addresse"><span><?php echo $order['Order']['address']?></span></li>
	<li class="number"><span><?php echo $order['Order']['telephone']?></span></li>
	<li class="units"><?php echo $order['Order']['payment_name']?></li>
	<li class="supplier phone"><?php echo $order['Order']['payment_time']?></li>
	<li class="remark"><?php echo $order['Order']['total']?></li></ul>
	
<!--显示所有订单商品-->
<div class="show_all">
	<div class="show_all_order">
		<ul class="product_llist procurements item_order">
		<li class="item_number">货号</li>
		<li class="name ship_name">商品名称</li>
		<li class="number">数量</li>
		<li class="supplier">属性</li>
		<li class="remark">价格</li></ul>
		<?php if(isset($order['OrderProduct']) && sizeof($order['OrderProduct'])>0)foreach($order['OrderProduct'] as $op){?>
		<ul class="product_llist procurements procurements_list item_order">
		<li class="item_number ordernumber"><span><?php echo $op['product_code']?></span></li>
		<li class="name ship_name"><?php echo $op['product_name']?></li>
		<li class="number"><?php echo $op['product_quntity']?></li>
		<li class="supplier"><?php echo $op['product_attrbute']?></li>
		<li class="remark"><?php echo $op['product_price']?></li></ul>
		<?php }?>
	</div>
	<p style="clear:both">
<!--	订单状态:
	付款时间:
	配送方法:
	支付方法:
-->
	</p>
</div>
	<?php }}?>
<!--显示所有订单商品 End-->	
	
</div>
<!--Main Start End-->
</div><!--时间控件层start-->
	<div id="container_cal" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal2" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal2"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal3" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal3"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal4" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal4"></div><div style="clear:both;"></div></div>
	</div>
<!--end-->