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
 * $Id: procurement.ctp 5028 2009-10-14 07:51:28Z huangbo $
*****************************************************************************/
?>
<p class="none"><span id="show3">&nbsp;</span><span id="show4">&nbsp;</span></p>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($aaa);//pr($orders);?>
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
<?php echo $form->create('reports',array('action'=>'procurement/','name'=>"ReportProcurementForm","type"=>"get"));?>


<?php //echo $form->create('Report',array('action'=>'procurement'));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" style="border:1px solid #649776" name="start_time" value="<?php echo $start_time?>"id="date" readonly="readonly"/><?php echo $html->image('calendar.gif',array("id"=>"show","class"=>"calendar"))?>
	<input type="text" style="border:1px solid #649776" name="end_time" value="<?php echo $end_time?>"id="date2" readonly="readonly"/><?php echo $html->image('calendar.gif',array("id"=>"show2","class"=>"calendar"))?>
	</p></dd><dt class="small_search"><input  class="search_article" type="button" value="查询"  onclick="sub_action()"/>		
		CSV导出编码:
			<select id="csv_export_code">
			<?php if(isset($systemresource_info["csv_export_code"]) && sizeof($systemresource_info["csv_export_code"])>0){
			foreach ($systemresource_info["csv_export_code"] as $k => $v){if($k!=""){?>
			<option value="<?php echo $k;?>" ><?php echo $v;?></option>
			<?php }}}?>
			</select>

			<input type="button" value="导出" class="search_article" onclick="export_action()"/></dt>
	</dl>
<?php //$form->end()?>

</div>
<br />
<div class="procurement_date">
	<strong>采购日期：<?php echo $start_time?>～<?php echo $end_time?></strong></div>
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
	<tr class="thead">
	<th width="80px">货号</th>
	<th><p>商品名称</p></th>
	<th  width="220px">属性</th>
	<th  width="40px">数量</th>
	<th  width="100px">供应商</th>
	<th  width="300px">备注</th>
	</tr>
	<?php if(isset($provider_product_info) && sizeof($provider_product_info)){?>
	<?php foreach($provider_product_info as $k=>$v){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td width="80px"><?php echo $v['Product']['code']?></td>
	<td><?php echo empty($product_i18n_info_new[$v['ProviderProduct']['product_id']]["ProductI18n"]["name"])?"未知商品":$product_i18n_info_new[$v['ProviderProduct']['product_id']]["ProductI18n"]["name"];?></td>
	<td><?php echo $v['Product']['Attribute']?></td>
	<td align="center"><?php echo $v['0']['quantity']?></td>
	<td align="center"><?php echo $v["Provider"]['name'];?></td>
	<td align="center"><?php echo $v['Provider']['description']?></td></tr>
	<?php }}?></table></div>
<?php echo $form->end();?>
<div class="pagers" style="position:relative">	
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>
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
	var csv_export_code = GetId("csv_export_code");
	document.ReportProcurementForm.action=webroot_dir+"reports/procurement/export/"+csv_export_code.value;
	document.ReportProcurementForm.onsubmit= "";
	document.ReportProcurementForm.submit(); 
}
</script>