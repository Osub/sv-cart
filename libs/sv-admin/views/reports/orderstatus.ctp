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
 * $Id: orderstatus.ctp 4718 2009-09-29 03:01:55Z huangbo $
*****************************************************************************/
?>
<p class="none"><span id="show3">&nbsp;eee</span><span id="show4">&nbsp;</span></p>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($order_status);pr($shipping_status);pr($payment_status);pr($payment);?>
<!--Search-->
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
	
<?php  $num=count($payment)+2; ?>
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'orderstatus/','name'=>"OrderStatusForm"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">下单日期：<input type="text" style="border:1px solid #649776" name="start_time" value="<?php echo $start_time?>"id="date" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>－<input type="text" style="border:1px solid #649776" name="end_time" id="date2" readonly="readonly"value="<?php echo $end_time?>"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
		<?php if(isset($SVConfigs["mlti_currency_module"]) && $SVConfigs["mlti_currency_module"]==1){?>
	语言:	<select name="order_locale">
		<?php if(isset($languages) && sizeof($languages)>0){
			foreach ($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale']?>" <?php if($v['Language']['locale']==$locale){echo "selected";}?>><?php echo $v['Language']['name']?></option>
		<?php }}?>
	</select>
	<?php }?>
	</p></dd>
	<dt class="small_search"><input type="submit" value="查询" onclick="sub_action()" class="search_article" />
				CSV导出编码:
			<select id="csv_export_code">
			<?php if(isset($systemresource_info["csv_export_code"]) && sizeof($systemresource_info["csv_export_code"])>0){
			foreach ($systemresource_info["csv_export_code"] as $k => $v){if($k!=""){?>
			<option value="<?php echo $k;?>" <?php if($k==$csv_export_code){echo "selected";}?>><?php echo $v;?></option>
			<?php }}}?>
			</select>
			<input type="button" value="导出" class="search_article" onclick="export_action()"  class="search_article" /></dt>
	</dl>
<?php $form->end()?>
</div>
<br /><br />
<!--Search End-->
<!--Main Start-->
<?php  $num=count($payment)+2; ?>
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data" >
	<tr>
		<th width="8%">支付方式</th>
		<th colspan="5">订单状态</th>
		<th colspan="4">配送状态</th>
		<th colspan="3">支付状态</th>
	</tr>
	<tr class="tr_bgcolor" >
		<td></td>
		<td align="center">未确认</td>
		<td align="center">已确认</td>
		<td align="center">已取消</td>
		<td align="center">无效</td>
		<td align="center">退货</td>
		<td align="center">未发货</td>
		<td align="center">已发货</td>
		<td align="center">已收货</td>
		<td align="center">备货中</td>
		<td align="center">未付款</td>
		<td align="center">付款中</td>
		<td align="center">已付款</td>
	</tr>
<?php $i=0;if(isset($payment) && sizeof($payment)>0){foreach($payment as $k=>$v){?>
	<tr <?php if((abs($i)+2)%2==1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }$i++;?> >
		<td align="center"><strong><?php echo $v?></strong></td>
		<td align="center"><?php echo !empty($order_statistics[$k]["status"]["0"]["order_id_count"])?$html->link($order_statistics[$k]["status"]["0"]["order_id_count"],"/orders/?payment_id=".$k."&order_status=0",array("target"=>"_blank"),false,false):0;?></td>
		<td align="center"><?php echo !empty($order_statistics[$k]["status"]["1"]["order_id_count"])?$html->link($order_statistics[$k]["status"]["1"]["order_id_count"],"/orders/?payment_id=".$k."&order_status=1",array("target"=>"_blank"),false,false):0;?></td>
		<td align="center"><?php echo !empty($order_statistics[$k]["status"]["2"]["order_id_count"])?$html->link($order_statistics[$k]["status"]["2"]["order_id_count"],"/orders/?payment_id=".$k."&order_status=2",array("target"=>"_blank"),false,false):0;?></td>
		<td align="center"><?php echo !empty($order_statistics[$k]["status"]["3"]["order_id_count"])?$html->link($order_statistics[$k]["status"]["3"]["order_id_count"],"/orders/?payment_id=".$k."&order_status=3",array("target"=>"_blank"),false,false):0;?></td>
		<td align="center"><?php echo !empty($order_statistics[$k]["status"]["4"]["order_id_count"])?$html->link($order_statistics[$k]["status"]["4"]["order_id_count"],"/orders/?payment_id=".$k."&order_status=4",array("target"=>"_blank"),false,false):0;?></td>
		<td align="center"><?php echo !empty($order_statistics[$k]["shipping_status"]["0"]["order_id_count"])?$html->link($order_statistics[$k]["shipping_status"]["0"]["order_id_count"],"/orders/?payment_id=".$k."&shipping_status=0",array("target"=>"_blank"),false,false):0;?></td>
		<td align="center"><?php echo !empty($order_statistics[$k]["shipping_status"]["1"]["order_id_count"])?$html->link($order_statistics[$k]["shipping_status"]["1"]["order_id_count"],"/orders/?payment_id=".$k."&shipping_status=1",array("target"=>"_blank"),false,false):0;?></td>
		<td align="center"><?php echo !empty($order_statistics[$k]["shipping_status"]["2"]["order_id_count"])?$html->link($order_statistics[$k]["shipping_status"]["2"]["order_id_count"],"/orders/?payment_id=".$k."&shipping_status=2",array("target"=>"_blank"),false,false):0;?></td>
		<td align="center"><?php echo !empty($order_statistics[$k]["shipping_status"]["3"]["order_id_count"])?$html->link($order_statistics[$k]["shipping_status"]["3"]["order_id_count"],"/orders/?payment_id=".$k."&shipping_status=3",array("target"=>"_blank"),false,false):0;?></td>
		<td align="center"><?php echo !empty($order_statistics[$k]["payment_status"]["0"]["order_id_count"])?$html->link($order_statistics[$k]["payment_status"]["0"]["order_id_count"],"/orders/?payment_id=".$k."&payment_status=0",array("target"=>"_blank"),false,false):0;?></td>
		<td align="center"><?php echo !empty($order_statistics[$k]["payment_status"]["1"]["order_id_count"])?$html->link($order_statistics[$k]["payment_status"]["1"]["order_id_count"],"/orders/?payment_id=".$k."&payment_status=1",array("target"=>"_blank"),false,false):0;?></td>
		<td align="center"><?php echo !empty($order_statistics[$k]["payment_status"]["2"]["order_id_count"])?$html->link($order_statistics[$k]["payment_status"]["2"]["order_id_count"],"/orders/?payment_id=".$k."&payment_status=2",array("target"=>"_blank"),false,false):0;?></td></tr>
	</tr>
	<?php }}?>
	<tr>
		<th><strong>合计</strong></th>
		<th><?php echo !empty($order_statistics_sum["status"]["0"]["order_id_count_sum"])?$order_statistics_sum["status"]["0"]["order_id_count_sum"]:0;?></th>
		<th><?php echo !empty($order_statistics_sum["status"]["1"]["order_id_count_sum"])?$order_statistics_sum["status"]["1"]["order_id_count_sum"]:0;?></th>
		<th><?php echo !empty($order_statistics_sum["status"]["2"]["order_id_count_sum"])?$order_statistics_sum["status"]["2"]["order_id_count_sum"]:0;?></th>
		<th><?php echo !empty($order_statistics_sum["status"]["3"]["order_id_count_sum"])?$order_statistics_sum["status"]["3"]["order_id_count_sum"]:0;?></th>
		<th><?php echo !empty($order_statistics_sum["status"]["4"]["order_id_count_sum"])?$order_statistics_sum["status"]["4"]["order_id_count_sum"]:0;?></th>
		<th><?php echo !empty($order_statistics_sum["shipping_status"]["0"]["order_id_count_sum"])?$order_statistics_sum["shipping_status"]["0"]["order_id_count_sum"]:0;?></th>
		<th><?php echo !empty($order_statistics_sum["shipping_status"]["1"]["order_id_count_sum"])?$order_statistics_sum["shipping_status"]["1"]["order_id_count_sum"]:0;?></th>
		<th><?php echo !empty($order_statistics_sum["shipping_status"]["2"]["order_id_count_sum"])?$order_statistics_sum["shipping_status"]["2"]["order_id_count_sum"]:0;?></th>
		<th><?php echo !empty($order_statistics_sum["shipping_status"]["3"]["order_id_count_sum"])?$order_statistics_sum["shipping_status"]["3"]["order_id_count_sum"]:0;?></th>
		<th><?php echo !empty($order_statistics_sum["payment_status"]["0"]["order_id_count_sum"])?$order_statistics_sum["payment_status"]["0"]["order_id_count_sum"]:0;?></th>
		<th><?php echo !empty($order_statistics_sum["payment_status"]["1"]["order_id_count_sum"])?$order_statistics_sum["payment_status"]["1"]["order_id_count_sum"]:0;?></th>
		<th><?php echo !empty($order_statistics_sum["payment_status"]["2"]["order_id_count_sum"])?$order_statistics_sum["payment_status"]["2"]["order_id_count_sum"]:0;?></th>
	</tr>

</table>
</div>
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function sub_action() 
{ 
	document.OrderStatusForm.action=webroot_dir+"reports/orderstatus";
	document.OrderStatusForm.onsubmit= "";
	document.OrderStatusForm.submit(); 
}
function export_action() 
{   var csv_export_code = GetId("csv_export_code");
	document.OrderStatusForm.action=webroot_dir+"reports/orderstatus/export/"+csv_export_code.value;
	document.OrderStatusForm.onsubmit= "";
	document.OrderStatusForm.submit(); 
}
</script>