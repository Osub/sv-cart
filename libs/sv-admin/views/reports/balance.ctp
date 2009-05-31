<?php
/*****************************************************************************
 * SV-Cart  用户资金报表管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: balance.ctp 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->


	
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'balance'));?>
	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" name="start_time" value="<?=@$start_time?>" class="time" id="date"  readonly="readonly" /><button type="button" id="show"><?=$html->image('calendar.gif')?></button>－<input type="text" name="end_time" value="<?=@$end_time?>" class="time" id="date2" readonly="readonly" /><button type="button" id="show2"><?=$html->image('calendar.gif')?></button></p></dd>
	<dt class="curement"><input type="submit" value="查询" /> </dt>
	</dl>
<?php $form->end()?>
</div>
<br /><br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist balance_headers">
	<li class="member_name">用户名</li>
	<li class="start_bankroll">始起资金</li>
	<li class="payout">支出</li>
	<li class="earning">收入</li>
	<li class="balance">结余</li></ul>
	
<!--ConsumeList-->
	
	
	<?if(isset($User) && sizeof($User)>0){?>
<?foreach( $User as $k=>$v ){?>
	<ul class="product_llist balance_headers balance_lists">
	<li class="member_name"><strong><?=$v['User']['name']?></strong></li>
	<li class="start_bankroll"><?=$v['User']['start_amount']?></li>
	<li class="payout"><?=$v['User']['zc_amount']?></li>
	<li class="earning"><?=$v['User']['sl_amount']?></li>
	<li class="balance"><?=$v['User']['amountsum']?></li></ul>
	<? }} ?>	
<!--ConsumeList End-->
	<ul class="product_llist balance_headers">
	<li class="member_name">总计</li>
	<li class="start_bankroll"><?=$amount_start_sum?></li>
	<li class="payout"><?=$amount_zc_sum?></li>
	<li class="earning"><?=$amount_sl_sum?></li>
	<li class="balance"><?=$amountsums?></li></ul>
	

</div>
<!--Main Start End-->
</div>
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