<?php 
/*****************************************************************************
 * SV-Cart  待发货单管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: shipments.ctp 4718 2009-09-29 03:01:55Z huangbo $
*****************************************************************************/
?>
<p class="none"><span id="show3">&nbsp;</span><span id="show4">&nbsp;</span></p>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($orders);?>
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
	
	
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'shipments/','name'=>"ShipmentsForm"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" style="border:1px solid #649776" name="start_time" value="<?php echo $start_time?>" id="date" readonly="readonly" /><?php echo $html->image('calendar.gif',array("id"=>"show","class"=>"calendar"))?>
	<input type="text" style="border:1px solid #649776" name="end_time" value="<?php echo $end_time?>" id="date2" readonly="readonly"  /><?php echo $html->image('calendar.gif',array("id"=>"show2","class"=>"calendar"))?>
		<?php if(isset($SVConfigs["mlti_currency_module"]) && $SVConfigs["mlti_currency_module"]==1){?>

	语言:<select name="order_locale">
		<?php if(isset($languages) && sizeof($languages)>0){?>
			<option value="all">所有语言</option>
			<?php foreach ($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale']?>" <?php if($v['Language']['locale']==$locale){echo "selected";}?>><?php echo $v['Language']['name']?></option>
		<?php }}?>
	</select>
		<?php }?>

	</p></dd>
	<dt style="" class="small_search"><input  class="search_article" type="button" value="查询" onclick="sub_action()"/>
		CSV导出编码:
			<select id="csv_export_code">
			<?php if(isset($systemresource_info["csv_export_code"]) && sizeof($systemresource_info["csv_export_code"])>0){
			foreach ($systemresource_info["csv_export_code"] as $k => $v){if($k!=""){?>
			<option value="<?php echo $k;?>" ><?php echo $v;?></option>
			<?php }}}?>
			</select>

		<input type="button" class="search_article" value="导出"  onclick="export_action()"/> </dt>
	</dl>
<?php $form->end()?>
</div>
<br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="150">订单号</th>
	<th>姓名</th>
	<th>地址</th>
	<th>电话</th>
	<th>付款方式</th>
	<th>付款日期</th>
	<th>金额总计</th>
</tr>
<?php $i=1;if(isset($orders) && sizeof($orders)>0){?>
<?php foreach($orders as $order){?>
<tr <?php $i++; if((abs($i)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $html->image('menu_plus.gif')?> <?php echo $html->link($order['Order']['order_code'],'/orders/'.$order['Order']['id'],array("target"=>"_blank"),false,false);?></td>
	<td><?php echo $order['Order']['consignee']?></td>
	<td><?php echo $order['Order']['address']?></td>
	<td><?php echo $order['Order']['telephone']?></td>
	<td align="center"><?php echo $order['Order']['payment_name']?></td>
	<td align="center"><?php echo $order['Order']['payment_time']?></td>
	<td align="right"><?php echo $order['Order']['total']?></td>
</tr>
<tr>
	<td></td>
	<td colspan="6" style="padding:0;">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
	<tr class="thead" align="center">
		<td width="20%">货号</td>
		<td width="38%">商品名称</td>
		<td width="8%">数量</td>
		<td width="22%">属性</td>
		<td width="12%">价格</td>
	</tr>
	<?php $i++; if(isset($order['OrderProduct']) && sizeof($order['OrderProduct'])>0)foreach($order['OrderProduct'] as $op){?>
	<tr <?php if((abs($i)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
		<td><?php echo $op['product_code']?></td>
		<td><?php echo $op['product_name']?></td>
		<td align="center"><?php echo $op['product_quntity']?></td>
		<td><?php echo $op['product_attrbute']?></td>
		<td><?php echo $op['product_price']?></td>
	</tr>
	<?php }?>
	</table></div>
	</td>
</tr>
<?php }}?>

</table>
<!--显示所有订单商品 End-->	
	<div class="pagers" style="position:relative">	
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function sub_action() 
{ 
	document.ShipmentsForm.action=webroot_dir+"reports/shipments";
	document.ShipmentsForm.onsubmit= "";
	document.ShipmentsForm.submit(); 
}
function export_action() 
{   var csv_export_code = GetId("csv_export_code");
	document.ShipmentsForm.action=webroot_dir+"reports/shipments/export/"+csv_export_code.value;
	document.ShipmentsForm.onsubmit= "";
	document.ShipmentsForm.submit(); 
}
</script>