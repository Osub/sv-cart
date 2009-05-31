<?php
/*****************************************************************************
 * SV-Cart  订单状态报表管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: orderstatus.ctp 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($order_status);pr($shipping_status);pr($payment_status);pr($payment);?>
<!--Search-->

	
<?  $num=count($payment)+2; ?>
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'orderstatus'));?>
	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">下单日期：<input type="text" class="time" name="start_time" value="<?php echo $start_time?>"id="date" readonly="readonly"/><button  id="show" type="button"><?=$html->image('calendar.gif')?></button>－<input type="text" class="time" name="end_time" id="date2" readonly="readonly"value="<?php echo $end_time?>"/><button id="show2" type="button"><?=$html->image('calendar.gif')?></button></p></dd>
	<dt class="curement"><input type="submit" value="查询" /> </dt>
	</dl>
<?php $form->end()?>
</div>
<br /><br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<style type="text/css">
	table.second_box tr.second_title{background:none;}
	table.second_box tr.second_title th{border-bottom:1px solid #ABABAB;border-right:1px solid #E1E1E1;}
</style>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="orderfees">
	<tr class="orderfee_headers">
		<th width="8%" valign="bottom" style="border-right:1px solid #ABABAB">支付方式</th>
		<th width="33%" height="33" colspan="5" style="border-right:0">订单状态</th>
		<th width="32%" colspan="4" style="border-left:1px solid #ABABAB;border-right:0">配送状态</th>
		<th width="26%" colspan="3" style="border-left:1px solid #ABABAB">支付状态</th>
	</tr>
	<tr>
	  <th width="8%" height="28" bgcolor="#E1E1E1" style="border-right:1px solid #ABABAB">&nbsp;</th>
<!--订单状态标题-->
	  <th height="30" width="33%" colspan="5" rowspan="<?=$num?>" style="border-right:0;">
	  	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="second_box">
		<tr class="second_title">
			<th style="height:28px;*height:27px;width:20%">未确认</th>
			<th style="width:20%">已确认</th>
			<th style="width:20%">已取消</th>
			<th style="width:20%">无效</th>
			<th style="border-right:0;width:19%">退货</th>
		</tr>
	<!--	pr($order_status);pr($shipping_status);pr($payment_status);pr($payment);-->
		<?if(isset($payment) && sizeof($payment)>0){?>
		<?php foreach($payment as $k=>$v){?>
		<tr>
			<td height="30" style="vertical-align:middle;"><?php if(isset($order_status[0][$k])) echo $order_status[0][$k];else echo 0;?></td>
			<td style="vertical-align:middle;"><?php if(isset($order_status[1][$k])) echo $order_status[1][$k];else echo 0;?></td>
			<td style="vertical-align:middle;"><?php if(isset($order_status[2][$k])) echo $order_status[2][$k];else echo 0;?></td>
			<td style="vertical-align:middle;"><?php if(isset($order_status[3][$k])) echo $order_status[3][$k];else echo 0;?></td>
			<td style="vertical-align:middle;"><?php if(isset($order_status[4][$k])) echo $order_status[4][$k];else echo 0;?></td>
		</tr>
		<?php }}?>
		<tr class="orderfee_headers title_sum">
		<td height="31" valign="middle"><?php if(isset($order_status[0])) echo array_sum($order_status[0]);else echo 0;?></td>
		<td style="vertical-align:middle;"><?php if(isset($order_status[1])) echo array_sum($order_status[1]);else echo 0;?></td>
		<td style="vertical-align:middle;"><?php if(isset($order_status[2])) echo array_sum($order_status[2]);else echo 0;?></td>
		<td style="vertical-align:middle;"><?php if(isset($order_status[3])) echo array_sum($order_status[3]);else echo 0;?></td>
		<td style="vertical-align:middle;"><?php if(isset($order_status[4])) echo array_sum($order_status[4]);else echo 0;?></td>
		</tr>
		</table>
		</th>
<!--订单状态标题 End-->
<!--配送状态标题-->
      <th width="32%" colspan="4" rowspan="<?=$num?>" style="border-right:0;">
	  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="second_box">
		
		<tr class="second_title">
		<th style="border-left:1px solid #ABABAB;height:28px;*height:27px;width:25%">未发货</th>
		<th style="width:25%">已发货</th>
		<th style="width:25%">已收货</th>
		<th style="border-right:0;width:24%">备货中</th>
		</tr>
			<?if(isset($payment) && sizeof($payment)>0){?>
		<?php foreach($payment as $k=>$v){?>
		<tr>
		<td style="vertical-align:middle;" height="30"><?php if(isset($shipping_status[0][$k])) echo $shipping_status[0][$k];else echo 0;?></td>
		<td style="vertical-align:middle;"><?php if(isset($shipping_status[1][$k])) echo $shipping_status[1][$k];else echo 0;?></td>
		<td style="vertical-align:middle;"><?php if(isset($shipping_status[2][$k])) echo $shipping_status[2][$k];else echo 0;?></td>
		<td style="vertical-align:middle;"><?php if(isset($shipping_status[3][$k])) echo $shipping_status[3][$k];else echo 0;?></td>
		</tr>
		<?php }}?>
		<tr class="orderfee_headers title_sum"><td height="31"><?php if(isset($shipping_status[0])) echo array_sum($shipping_status[0]);else echo 0;?></td><td><?php if(isset($shipping_status[1])) echo array_sum($shipping_status[1]);else echo 0;?></td><td><?php if(isset($shipping_status[2])) echo array_sum($shipping_status[2]);else echo 0;?></td><td><?php if(isset($shipping_status[3])) echo array_sum($shipping_status[3]);else echo 0;?></td></tr>
		</table></th>
<!--配送状态标题 End-->
<!--支付状态标题-->
	  <th width="26%" colspan="3" rowspan="<?=$num?>">
	  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="second_box">
		
		<tr class="second_title">
		<th style="border-left:1px solid #ABABAB;height:28px;*height:27px;">未付款</th>
		<th>付款中</th>
		<th style="border-right:0;">已付款</th>
		</tr>
			<?if(isset($payment) && sizeof($payment)>0){?>
		<?php foreach($payment as $k=>$v){?>
		<tr>
		<td height="30" style="vertical-align:middle;"><?php if(isset($payment_status[0][$k])) echo $payment_status[0][$k];else echo 0;?></td>
		<td style="vertical-align:middle;"><?php if(isset($payment_status[1][$k])) echo $payment_status[1][$k];else echo 0;?></td>
		<td style="vertical-align:middle;"><?php if(isset($payment_status[2][$k])) echo $payment_status[2][$k];else echo 0;?></td></tr>
		<?php }}?>
		<tr class="orderfee_headers title_sum">
		<td height="31"><?php if(isset($payment_status[0])) echo array_sum($payment_status[0]);else echo 0;?></td>
		<td><?php if(isset($payment_status[1])) echo array_sum($payment_status[1]);else echo 0;?></td>
		<td><?php if(isset($payment_status[2])) echo array_sum($payment_status[2]);else echo 0;?></td>
		</tr>
		</table>
		</th>
<!--支付状态标题 End-->
	</tr>
		<?if(isset($payment) && sizeof($payment)>0){?>
	<?php foreach($payment as $k=>$v){?>
	<tr class="list">
		<td height="30" style="vertical-align:middle;" align="center"><strong><?=$v?></strong></td>
	</tr>
	<?php }}?>
	<tr class="orderfee_headers title_sum">
		<th height="30" align="center"><strong>合计</strong></th>
	</tr>
</table>
	
	

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