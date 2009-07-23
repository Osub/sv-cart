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
 * $Id: procurement.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($aaa);//pr($orders);?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('reports',array('action'=>'procurement/','name'=>"ReportProcurementForm","type"=>"get"));?>


<?php //echo $form->create('Report',array('action'=>'procurement'));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" class="time" name="start_time" value="<?php echo $start_time?>"id="date" readonly="readonly"/><?php echo $html->image('calendar.gif',array("id"=>"show","class"=>"calendar"))?>
	<input type="text" class="time" name="end_time" value="<?php echo $end_time?>"id="date2" readonly="readonly"/><?php echo $html->image('calendar.gif',array("id"=>"show2","class"=>"calendar"))?>
		<?php if(isset($SVConfigs["mlti_currency_module"]) && $SVConfigs["mlti_currency_module"]==1){?>
	语言:	<select name="order_locale">
		<?php if(isset($languages) && sizeof($languages)>0){
			foreach ($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale']?>" <?php if($v['Language']['locale']==$locale){echo "selected";}?>><?php echo $v['Language']['name']?></option>
		<?php }}?>
	</select>
<?php }?>
			</p></dd>
	
	<dt class="curement"><input type="button" value="查询"  onclick="sub_action()"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="导出"  onclick="export_action()"/></dt>
	</dl>
<?php //$form->end()?>

</div>
<br />
<div class="procurement_date">
	<strong>采购日期：<?php echo $start_time?>～<?php echo $end_time?></strong></div>
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">	
	<tr class="thead">
	<th width="80px">货号</th>
	<th><p>商品名称</p></th>
	<th  width="220px">属性</th>
	<th  width="40px">数量</th>
	<th  width="100px">供应商</th>
	<th  width="300px">备注</th>
	</tr>
	<?php if(isset($orders) && sizeof($orders)){?>
	<?php foreach($orders as $order){?>
	<tr>
	<td width="80px"><?php echo $order['OrderProduct']['product_code']?></td>
	<td><p><?php echo $order['OrderProduct']['product_name']?></p></td>
	<td align="center"><?php echo $order['OrderProduct']['product_attrbute']?></td>
	<td align="center"><?php echo $order['OrderProduct']['product_quntity']?></td>
	<td align="center"><?php if(isset($productprovider[$order['OrderProduct']['product_id']]))echo $productprovider[$order['OrderProduct']['product_id']]['name']?></td>
	<td align="center"  width="300px"><?php echo $order['OrderProduct']['note']?></td></tr>
	<?php }}?></table>
<?php echo $form->end();?>
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
<script type="text/javascript">
function sub_action() 
{ 
	document.ReportProcurementForm.action=webroot_dir+"reports/procurement";
	document.ReportProcurementForm.onsubmit= "";
	document.ReportProcurementForm.submit(); 
}
function export_action(){ 
//	var url=document.getElementById("url").value;
//	window.location.href=webroot_dir+url;
	document.ReportProcurementForm.action=webroot_dir+"reports/procurement/export";
	document.ReportProcurementForm.onsubmit= "";
	document.ReportProcurementForm.submit(); 
}
</script>