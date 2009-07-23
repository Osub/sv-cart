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
 * $Id: orderstatus.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($order_status);pr($shipping_status);pr($payment_status);pr($payment);?>
<!--Search-->

	
<?php  $num=count($payment)+2; ?>
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'orderstatus/','name'=>"OrderStatusForm"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">下单日期：<input type="text" class="time" name="start_time" value="<?php echo $start_time?>"id="date" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>－<input type="text" class="time" name="end_time" id="date2" readonly="readonly"value="<?php echo $end_time?>"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
		<?php if(isset($SVConfigs["mlti_currency_module"]) && $SVConfigs["mlti_currency_module"]==1){?>
	语言:	<select name="order_locale">
		<?php if(isset($languages) && sizeof($languages)>0){
			foreach ($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale']?>" <?php if($v['Language']['locale']==$locale){echo "selected";}?>><?php echo $v['Language']['name']?></option>
		<?php }}?>
	</select>
	<?php }?>
	</p></dd>
	<dt class="curement"><input type="submit" value="查询" onclick="sub_action()"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="导出"  onclick="export_action()"/></dt>
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
	  <th height="30" width="33%" colspan="5" rowspan="<?php echo $num?>" style="border-right:0;">
	  	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="second_box">
		<tr class="second_title">
			<th style="height:28px;*height:27px;width:20%">未确认</th>
			<th style="width:20%">已确认</th>
			<th style="width:20%">已取消</th>
			<th style="width:20%">无效</th>
			<th style="border-right:0;width:19%">退货</th>
		</tr>
	<!--	pr($order_status);pr($shipping_status);pr($payment_status);pr($payment);-->
		<?php if(isset($payment) && sizeof($payment)>0){?>
		<?php foreach($payment as $k=>$v){?>
		<tr>
			<td height="30" style="vertical-align:middle;"><?php echo $html->link(isset($order_status[0][$k])?$order_status[0][$k]:0,"/orders/?payment_id=".$k."&order_status=0",array("target"=>"_blank"),false,false);?></td>
			<td style="vertical-align:middle;"><?php echo $html->link(isset($order_status[1][$k])?$order_status[1][$k]:0,"/orders/?payment_id=".$k."&order_status=1",array("target"=>"_blank"),false,false);?></td>
			<td style="vertical-align:middle;"><?php echo $html->link(isset($order_status[2][$k])?$order_status[2][$k]:0,"/orders/?payment_id=".$k."&order_status=2",array("target"=>"_blank"),false,false);?></td>
			<td style="vertical-align:middle;"><?php echo $html->link(isset($order_status[3][$k])?$order_status[3][$k]:0,"/orders/?payment_id=".$k."&order_status=3",array("target"=>"_blank"),false,false);?></td>
			<td style="vertical-align:middle;"><?php echo $html->link(isset($order_status[4][$k])?$order_status[4][$k]:0,"/orders/?payment_id=".$k."&order_status=4",array("target"=>"_blank"),false,false);?></td>
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
      <th width="32%" colspan="4" rowspan="<?php echo $num?>" style="border-right:0;">
	  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="second_box">
		
		<tr class="second_title">
		<th style="border-left:1px solid #ABABAB;height:28px;*height:27px;width:25%">未发货</th>
		<th style="width:25%">已发货</th>
		<th style="width:25%">已收货</th>
		<th style="border-right:0;width:24%">备货中</th>
		</tr>
			<?php if(isset($payment) && sizeof($payment)>0){?>
		<?php foreach($payment as $k=>$v){?>
		<tr>
		<td style="vertical-align:middle;" height="30"><?php echo $html->link(isset($shipping_status[0][$k])?$shipping_status[0][$k]:0,"/orders/?payment_id=".$k."&shipping_status=0",array("target"=>"_blank"),false,false);?></td>
		<td style="vertical-align:middle;"><?php echo $html->link(isset($shipping_status[1][$k])?$shipping_status[1][$k]:0,"/orders/?payment_id=".$k."&shipping_status=1",array("target"=>"_blank"),false,false);?></td>
		<td style="vertical-align:middle;"><?php echo $html->link(isset($shipping_status[2][$k])?$shipping_status[2][$k]:0,"/orders/?payment_id=".$k."&shipping_status=2",array("target"=>"_blank"),false,false);?></td>
		<td style="vertical-align:middle;"><?php echo $html->link(isset($shipping_status[3][$k])?$shipping_status[3][$k]:0,"/orders/?payment_id=".$k."&shipping_status=3",array("target"=>"_blank"),false,false);?></td>
		</tr>
		<?php }}?>
		<tr class="orderfee_headers title_sum"><td height="31"><?php if(isset($shipping_status[0])) echo array_sum($shipping_status[0]);else echo 0;?></td><td><?php if(isset($shipping_status[1])) echo array_sum($shipping_status[1]);else echo 0;?></td><td><?php if(isset($shipping_status[2])) echo array_sum($shipping_status[2]);else echo 0;?></td><td><?php if(isset($shipping_status[3])) echo array_sum($shipping_status[3]);else echo 0;?></td></tr>
		</table></th>
<!--配送状态标题 End-->
<!--支付状态标题-->
	  <th width="26%" colspan="3" rowspan="<?php echo $num?>">
	  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="second_box">
		
		<tr class="second_title">
		<th style="border-left:1px solid #ABABAB;height:28px;*height:27px;">未付款</th>
		<th>付款中</th>
		<th style="border-right:0;">已付款</th>
		</tr>
			<?php if(isset($payment) && sizeof($payment)>0){?>
		<?php foreach($payment as $k=>$v){?>
		<tr>
		<td height="30" style="vertical-align:middle;"><?php echo $html->link(isset($payment_status[0][$k])?$payment_status[0][$k]:0,"/orders/?payment_id=".$k."&payment_status=0",array("target"=>"_blank"),false,false);?></td>
		<td style="vertical-align:middle;"><?php echo $html->link(isset($payment_status[1][$k])?$payment_status[1][$k]:0,"/orders/?payment_id=".$k."&payment_status=1",array("target"=>"_blank"),false,false);?></td>
		<td style="vertical-align:middle;"><?php echo $html->link(isset($payment_status[2][$k])?$payment_status[2][$k]:0,"/orders/?payment_id=".$k."&payment_status=2",array("target"=>"_blank"),false,false);?></td></tr>
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
		<?php if(isset($payment) && sizeof($payment)>0){?>
	<?php foreach($payment as $k=>$v){?>
	<tr class="list">
		<td height="30" style="vertical-align:middle;" align="center"><strong><?php echo $v?></strong></td>
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
<script type="text/javascript">
function sub_action() 
{ 
	document.OrderStatusForm.action=webroot_dir+"reports/orderstatus";
	document.OrderStatusForm.onsubmit= "";
	document.OrderStatusForm.submit(); 
}
function export_action() 
{ 
	document.OrderStatusForm.action=webroot_dir+"reports/orderstatus/export";
	document.OrderStatusForm.onsubmit= "";
	document.OrderStatusForm.submit(); 
}
</script>