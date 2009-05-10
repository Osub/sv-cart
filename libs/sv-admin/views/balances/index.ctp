<?php
/*****************************************************************************
 * SV-Cart 资金日志列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
?> 
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>'BalanceForm','type'=>'get'));?>
	<dl>
	<dt style="padding-top:2px;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" name="start_time" class="time" id="date" value="<?=@$start_time?>" readonly="readonly"/><button id="show" type="button"><?=$html->image('calendar.gif')?></button>－<input type="text" name="end_time" value="<?=@$end_time?>" class="time" id="date2" readonly="readonly" /><button id="show2" type="button"><?=$html->image('calendar.gif')?></button>
	类型：
	<select name="log_type">
	<option value="" >全部</option>
	<option value="O"<?if(@$log_type=="O"){ echo "selected";}?>>消费</option>
	<option value="B"<?if(@$log_type=="B"){ echo "selected";}?>>充值</option>
	<option value="A"<?if(@$log_type=="A"){ echo "selected";}?>>管理员操作</option>
	<option value="C"<?if(@$log_type=="C"){ echo "selected";}?>>返还</option>
		
	</select>
	&nbsp;&nbsp;会员名称：<input type="text" class="time" name="name" value="<?=@$names?>" style="width:120px;" /></p></dd>
	<dt style="" class="curement"><input type="button" onclick="search_balance()" value="查询" /></dt>
	</dl>
<? echo $form->end();?>
</div>
<!--Search End-->
<!--Main Start-->
<br />
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
	<ul class="product_llist balances_headers">
	<li class="number_name">会员名称</li>
	<li class="type">类型</li>
	<li class="bankroll">资金</li>
	<li class="payment">备注</li>
	<li class="handle">操作日期</li>
</ul>
<!--Balances List-->
<?if(isset($UserBalanceLog_list) && sizeof($UserBalanceLog_list)>0){?>
<? foreach( $UserBalanceLog_list as $k=>$v ){ ?>
	<ul class="product_llist balances_headers balances_lists">
	<li class="number_name"><span><?=$v['UserBalanceLog']['name']?></span></li>
	<li class="type"><?=$v['UserBalanceLog']['log_type']?></li>
	<li class="bankroll"><?=$v['UserBalanceLog']['amount']?></li>
	<li class="payment"><?=$v['UserBalanceLog']['description']?></li>
	<li class="handle"><?=$v['UserBalanceLog']['modified']?></li>
</ul>
<?}?>
<?}else{?>
<ul class="product_llist">&nbsp;</ul>
<?}?>
<!--Balances List End-->
<div class="pagers" style="position:relative">
   <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
   </div>
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function search_balance() 
{ 
	document.BalanceForm.action=webroot_dir+"balances/"; 
	document.BalanceForm.submit(); 
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