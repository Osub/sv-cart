<?php
/*****************************************************************************
 * SV-Cart  商品销售报表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: sales.ctp 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($orderproducts);?>
<!--Search-->

	
	
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'sales'));?>
	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" class="time" name="start_time" value="<?php echo $start_time?>"id="date" readonly="readonly"/><button id="show" type="button"><?=$html->image('calendar.gif')?></button>－<input type="text" class="time" name="end_time" value="<?php echo $end_time?>"id="date2" readonly="readonly"/><button id="show2" type="button"><?=$html->image('calendar.gif')?></button></p></dd>
	<dt class="curement"><input type="submit" value="查询" /> </dt>
	</dl>
<?php $form->end()?>
</div>
<br /><br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist consume_headers">
	<li class="member_name">货号</li>
	<li class="product_number">商品名称</li>
	<li class="order_number">数量</li>
	<li class="concume">金额</li></ul>
	
<!--ConsumeList-->
	<?if(isset($orderproducts) && sizeof($orderproducts)>0){?>
	<?php foreach($orderproducts as $orderproduct){?>
	<ul class="product_llist consume_headers consume_headers_list">
	<li class="member_name"><?php echo $orderproduct['OrderProduct']['product_code']?></li>
	<li class="product_number"><?php echo $orderproduct['OrderProduct']['product_name']?></li>
	<li class="order_number"><?php echo $orderproduct['OrderProduct']['product_quntity']?></li>
	<li class="concume"><?php echo $orderproduct['OrderProduct']['product_price']?></li></ul>
	<?php }}?>
<!--ConsumeList End-->
	<ul class="product_llist consume_headers">
	<li class="member_name">总计</li>
	<li class="product_number"><?php echo $productcount?></li>
	<li class="order_number"><?php echo $quntitysum?></li>
	<li class="concume"><?php echo $pricesum?></li></ul>

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