<?php
/*****************************************************************************
 * SV-Cart  会员消费报表管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: consume.ctp 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($orders);pr($users);?>
<!--Search-->

	
	
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'consume'));?>
	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" class="time" name="start_time" value="<?php echo $start_time?>"id="date" readonly="readonly"/><button id="show" type="button"><?=$html->image('calendar.gif')?></button>－<input type="text" class="time" name="end_time" value="<?php echo $end_time?>" id="date2" readonly="readonly"/><button id="show2" type="button"><?=$html->image('calendar.gif')?></button></p></dd>
	<dt class="curement"><input type="submit" value="查询" /> </dt>
	</dl>
<?php $form->end()?>
</div>
<br /><br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist consume_headers">
	<li class="member_name">会员名称</li>
	<li class="order_number">订单数</li>
	<li class="product_number">商品数量</li>
	<li class="concume">消费总金额</li></ul>
	
<!--ConsumeList-->
<?php $sumallorder=0;$sumallquntity=0;$sumallfee=0;if(isset($orders) && sizeof($orders)>0){foreach($orders as $k=>$v){if(isset($v['countorder']))$sumallorder+=$v['countorder'];if(isset($v['sumquntity']))$sumallquntity+=$v['sumquntity'];if(isset($v['sumtotal']))$sumallfee+=$v['sumtotal'];?>
	<ul class="product_llist consume_headers consume_headers_list">
	<li class="member_name"><strong><?php if(isset($users[$k]))echo $users[$k];else echo '鬼是不会留名的'?></strong></li>
	<li class="order_number"><?=$html->link($v['countorder'],'/orders/?user_id='.$k.'date='.$start_time.'&date2='.$end_time,array('target'=>'_blank'),false,false);?></li>
	<li class="product_number"><?php if(isset($v['sumquntity']))echo $v['sumquntity']?></li>
	<li class="concume"><?php if(isset($v['sumtotal']))echo $v['sumtotal']?></li></ul>
<?php }}?>	
<!--ConsumeList End-->
	<ul class="product_llist consume_headers">
	<li class="member_name">总计</li>
	<li class="order_number"><?php echo $sumallorder?></li>
	<li class="product_number"><?php echo $sumallquntity?></li>
	<li class="concume"><?php echo $sumallfee?></li></ul>

</div>
<!--Main Start End-->
</div><!--时间控件层start-->
	<div id="container_cal" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal2" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal2"></div><div style="clear:both;"></div></div>
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