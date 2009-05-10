<?php
/*****************************************************************************
 * SV-Cart  积分报表管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: point.ctp 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->

	
	
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'point'));?>
	<dl>
	<dt style="padding-top:2px;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" name="start_time" value="<?=@$start_time?>" class="time" id="date" readonly="readonly"  /><button id="show" type="button"><?=$html->image('calendar.gif')?></button>－<input type="text" name="end_time" value="<?=@$end_time?>" class="time" id="date2" readonly="readonly" /><button id="show2" type="button"><?=$html->image('calendar.gif')?></button></p></dd>
	<dt class="curement"><input type="submit" value="查询" /></dt>
	</dl>
<?php $form->end()?>
</div>
<br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
	<ul class="product_llist procurements">
	<li class="item_number" style="width:31%;">用户名</li>
	<li class="profiles" style="width:16%;">起始积分</li>
	<li class="number" style="width:16%;">支出</li>
	<li class="units" style="width:16%;">收入</li>
	<li class="supplier" style="width:20%;border-right:0;">结余</li></ul>
	<?if(isset($User) && sizeof($User)>0){?>
	<?foreach( $User as $k=>$v ){?>
	<ul class="product_llist procurements procurements_list">
	<li class="item_number" style="width:31%;"><?=$v['User']['name']?></li>
	<li class="profiles" style="width:16%;"><?=$v['User']['start_point']?></li>
	<li class="number" style="width:16%;"><?=$v['User']['zc_point']?></li>
	<li class="units" style="width:16%;"><?=$v['User']['sl_point']?></li>
	<li class="supplier" style="width:20%;border-right:0;"><?=$v['User']['pointsum']?></li></ul>
	<? }} ?>

	<ul class="product_llist procurements">
	<li class="item_number" style="width:31%;">总计</li>
	<li class="profiles" style="width:16%;"><?=$point_start_sum?></li>
	<li class="number" style="width:16%;"><?=$point_zc_sum?></li>
	<li class="units" style="width:16%;"><?=$point_sl_sum?></li>
	<li class="supplier" style="width:20%;border-right:0;"><?=$pointsums?></li></ul>
	
	
	

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