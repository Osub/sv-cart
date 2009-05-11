<?php
/*****************************************************************************
 * SV-Cart 积分管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1329 2009-05-11 11:29:59Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>'PointForm','type'=>'get'));?>
	<dl>
	<dt style="padding-top:2px;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" name="start_time" class="time" id="date" value="<?=@$start_time?>" readonly="readonly"/><button id="show" type="button"><?=$html->image('calendar.gif')?></button>－<input type="text" name="end_time" value="<?=@$end_time?>" class="time" id="date2" readonly="readonly" /><button id="show2" type="button"><?=$html->image('calendar.gif')?></button>
	类型：
	<select name="log_type">
	<option value="" >全部</option>
	<option value="R"<?if(@$log_type=="R"){ echo "selected";}?>>注册赠送</option>
	<option value="B"<?if(@$log_type=="B"){ echo "selected";}?>>购买赠送</option>
	<option value="O"<?if(@$log_type=="O"){ echo "selected";}?>>购买消费</option>
	<option value="A"<?if(@$log_type=="A"){ echo "selected";}?>>管理员操作</option>
	</select>
	&nbsp;&nbsp;会员名称：<input type="text" class="time" name="name" value="<?=@$names?>" style="width:120px;" /></p></dd>
	<dt style="" class="curement"><input type="button" onclick="search_point()" value="查询" /> </dt>
	</dl>
<? echo $form->end();?>
</div>
<!--Search End-->
<!--Main Start-->
<br />
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist memberlevels">
	<li class="member_name"><span>会员名称</span></li>
	<li class="type">类型</li>
	<li class="integral">积分</li>
	<li class="order_number"><p>备注</p></li>
	<li class="handle_date" style="border-right:0;">操作日期</li></ul>
<!--Menberleves List-->
<?if(isset($UserPointLog_list) && sizeof($UserPointLog_list)>0){?>
<? foreach( $UserPointLog_list as $k=>$v ){ ?>
	<ul class="product_llist memberlevels memberlevels_list">
	<li class="member_name"><span><?=$v['UserPointLog']['name']?></span></li>
	<li class="type"><?=$v['UserPointLog']['log_type']?></li>
	<li class="integral"><?=$v['UserPointLog']['point']?></li>
	<li class="order_number"><p><?=$v['UserPointLog']['description']?></p></li>
	<li class="handle_date"><?=$v['UserPointLog']['modified']?></li></ul>
<? }} ?>	

<!--Menberleves List End-->	

	<div class="pagers" style="position:relative;">
   <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
   </div>
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">

function search_point() 
{ 
document.PointForm.action=webroot_dir+"points/"; 
document.PointForm.submit(); 
} 

</script>

<!--时间控件层start-->
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