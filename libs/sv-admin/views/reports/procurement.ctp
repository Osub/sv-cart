<?php
/*****************************************************************************
 * SV-Cart  采购单管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: procurement.ctp 1329 2009-05-11 11:29:59Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($aaa);//pr($orders);?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('reports',array('action'=>'procurement/','name'=>"ReportProcurementForm","type"=>"get"));?>


<?php //echo $form->create('Report',array('action'=>'procurement'));?>
	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" class="time" name="start_time" value="<?php echo $start_time?>"id="date" readonly="readonly"/><button type="button" id="show" ><?=$html->image('calendar.gif')?></button>－<input type="text" class="time" name="end_time" value="<?php echo $end_time?>"id="date2" readonly="readonly"/><button type="button" id="show2"><?=$html->image('calendar.gif')?></button></p></dd>
	<dt class="curement"><input type="submit" value="查询" /></dt>
	</dl>
<?php //$form->end()?>

</div>
<br />
<div class="procurement_date">
	<strong>采购日期：<?php echo $start_time?>～<?php echo $end_time?></strong></div>
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
	<ul class="product_llist procurements">
	<li class="item_number">货号</li>
	<li class="name"><p>商品名称</p></li>
	<li class="profiles">属性</li>
	<li class="number">数量</li>
	<li class="units">单位</li>
	<li class="supplier">供应商</li>
	<li class="remark">备注</li>
	</ul>
	<?if(isset($orders) && sizeof($orders)){?>
	<?php foreach($orders as $order){?>
	<ul class="product_llist procurements procurements_list">
	<li class="item_number"><?php echo $order['OrderProduct']['product_code']?></li>
	<li class="name"><p><?php echo $order['OrderProduct']['product_name']?></p></li>
	<li class="profiles"><?php echo $order['OrderProduct']['product_attrbute']?></li>
	<li class="number"><?php echo $order['OrderProduct']['product_quntity']?></li>
	<li class="units">台</li>
	<li class="supplier"><?php if(isset($productprovider[$order['OrderProduct']['product_id']]))echo $productprovider[$order['OrderProduct']['product_id']]['name']?></li>
	<li class="remark"><?php echo $order['OrderProduct']['note']?></li></ul>
	<?php }}?>
<? echo $form->end();?>
<div class="pagers" style="position:relative">	
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
	
</div>
<!--Main Start End-->
</div>
<!--时间控件层start-->
	<div id="container_cal" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd">
			<div id="cal"></div>
			<div style="clear:both;"></div>
		</div>
	</div>
	<div id="container_cal2" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd">
			<div id="cal2"></div>
			<div style="clear:both;"></div>
		</div>
	</div>
	<div id="container_cal3" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal3"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal4" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal4"></div><div style="clear:both;"></div></div>
	</div>
<!--end-->