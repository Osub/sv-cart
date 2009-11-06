<?php 
/*****************************************************************************
 * SV-Cart  订单业绩报表管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: orderfee.ctp 4893 2009-10-11 10:07:01Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($monthes)?>
<!--Search-->

	
<!--Search-->

	
	
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'orderfee/','name'=>"OrderfeeForm"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：
	<select name="year">
	<?php foreach($now_year_arr as $k=>$v){?>
	<option value='<?php echo $v?>'<?php if($v==$month) echo 'selected';?>><?php echo $k?></option>
	<?php }?>
	</select>-
	<select name="month">
	<?php foreach($now_month_arr as $k=>$v){?>
	<option value='<?php echo $v?>'<?php if($v==$now_month) echo 'selected';?>><?php echo $k?></option>
	<?php }?>
	</select>
		<?php if(isset($SVConfigs["mlti_currency_module"]) && $SVConfigs["mlti_currency_module"]==1){?>
	语言:	<select name="order_locale">
		<?php if(isset($languages) && sizeof($languages)>0){
			foreach ($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale']?>" <?php if($v['Language']['locale']==$locale){echo "selected";}?>><?php echo $v['Language']['name']?></option>
		<?php }}?>
	</select>
		<?php }?>

	</p></dd>
	<dt class="small_search"><input type="button" value="查询"  onclick="sub_action()" class="search_article" />
				CSV导出编码:
			<select id="csv_export_code">
			<?php if(isset($systemresource_info["csv_export_code"]) && sizeof($systemresource_info["csv_export_code"])>0){
			foreach ($systemresource_info["csv_export_code"] as $k => $v){if($k!=""){?>
			<option value="<?php echo $k;?>"  ><?php echo $v;?></option>
			<?php }}}?>
			</select>

			<input type="button" class="search_article" value="导出" class="search_article" onclick="export_action()"/> </dt>
	</dl>
<?php $form->end()?>
</div>
<br />
<!--Search End-->


<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">

<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data" >
	<tr class="orderfee_headers">
		<th width="16%">时间</th>
		<th width="47%"  colspan="8"  >订单状态</th>
		<th width="12%" rowspan="2">订单数量</th>
		<th width="12%" rowspan="2">数量小计</th>
		<th width="12%" rowspan="2">金额小计</th>
	</tr>
	<tr>
	<td align="center"><?php echo $Y;?>年<?php echo $now_month;?>月</td>
	<td align="center">未确认</td>
	<td align="center">已确认</td>
	<td align="center">已取消</td>
	<td align="center">无效</td>
	<td align="center">退货</td>
	<td align="center">已付款</td>
	<td align="center">已发货</td>
	<td align="center">已收货</td>
	</tr>
	<?php $ij=1;if(isset($n) && sizeof($n)>0){$sum_order_count = 0;$sum_product_quntity = 0;$sum_sumtotal_all = 0;for($i=1;$i<=$n;$i++){$d = $i<10?"0".$i:$i;$this_data = $Y."-".$m."-".$d?>
		<tr <?php if((abs($ij)+2)%2==1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }$ij++;?> ><td align="center"><strong><?php echo $i?>日</strong></td>
			<td align="center"><?php echo empty($order_statistics[$this_data]["status"][0]["order_id_count"])?0:$html->link($order_statistics[$this_data]["status"][0]["order_id_count"],"/orders/?date=".$this_data."00:00:00&date2=".$this_data."23:59:59&order_status=0",array("target"=>"_blank"),false,false);?></td>
			<td align="center"><?php echo empty($order_statistics[$this_data]["status"][1]["order_id_count"])?0:$html->link($order_statistics[$this_data]["status"][1]["order_id_count"],"/orders/?date=".$this_data." 00:00:00&date2=".$this_data." 23:59:59&order_status=1",array("target"=>"_blank"),false,false);?></td>
			<td align="center"><?php echo empty($order_statistics[$this_data]["status"][2]["order_id_count"])?0:$html->link($order_statistics[$this_data]["status"][2]["order_id_count"],"/orders/?date=".$this_data." 00:00:00&date2=".$this_data." 23:59:59&order_status=2",array("target"=>"_blank"),false,false);?></td>
			<td align="center"><?php echo empty($order_statistics[$this_data]["status"][3]["order_id_count"])?0:$html->link($order_statistics[$this_data]["status"][3]["order_id_count"],"/orders/?date=".$this_data." 00:00:00&date2=".$this_data." 23:59:59&order_status=3",array("target"=>"_blank"),false,false);?></td>
			<td align="center"><?php echo empty($order_statistics[$this_data]["status"][4]["order_id_count"])?0:$html->link($order_statistics[$this_data]["status"][4]["order_id_count"],"/orders/?date=".$this_data." 00:00:00&date2=".$this_data." 23:59:59&order_status=4",array("target"=>"_blank"),false,false);?></td>
			<td align="center"><?php echo empty($order_statistics[$this_data]["payment_status"][2]["order_id_count"])?0:$html->link($order_statistics[$this_data]["payment_status"][2]["order_id_count"],"/orders/?date=".$this_data." 00:00:00&date2=".$this_data." 23:59:59&payment_status=2",array("target"=>"_blank"),false,false);?></td>
			<td align="center"><?php echo empty($order_statistics[$this_data]["shipping_status"][1]["order_id_count"])?0:$html->link($order_statistics[$this_data]["shipping_status"][1]["order_id_count"],"/orders/?date=".$this_data." 00:00:00&date2=".$this_data." 23:59:59&shipping_status=1",array("target"=>"_blank"),false,false);?></td>
			<td align="center"><?php echo empty($order_statistics[$this_data]["shipping_status"][2]["order_id_count"])?0:$html->link($order_statistics[$this_data]["shipping_status"][2]["order_id_count"],"/orders/?date=".$this_data." 00:00:00&date2=".$this_data." 23:59:59&shipping_status=2",array("target"=>"_blank"),false,false);?></td>
			
			<td align="center"><?php $sum_order_count+= empty($order_statistics[$this_data]["order_count"])?0:$order_statistics[$this_data]["order_count"];echo empty($order_statistics[$this_data]["order_count"])?0:$order_statistics[$this_data]["order_count"];?></td>
			<td align="center"><?php $sum_product_quntity+= empty($order_statistics[$this_data]["product_quntity"])?0:$order_statistics[$this_data]["product_quntity"];echo empty($order_statistics[$this_data]["product_quntity"])?0:$order_statistics[$this_data]["product_quntity"];?></td>
			<td><?php $sum_sumtotal_all+= empty($order_statistics[$this_data]["sumtotal_all"])?0:$order_statistics[$this_data]["sumtotal_all"];echo sprintf($price_format,sprintf("%01.2f",empty($order_statistics[$this_data]["sumtotal_all"])?0:$order_statistics[$this_data]["sumtotal_all"]));?></td>
		</tr>
	<?php }}?>
	<tr>
			<th>总计</th>
			<th><?php echo empty($statussum_all["status"][0]["statussum_all"])?0:$statussum_all["status"][0]["statussum_all"];?></th>
			<th><?php echo empty($statussum_all["status"][1]["statussum_all"])?0:$statussum_all["status"][1]["statussum_all"];?></th>
			<th><?php echo empty($statussum_all["status"][2]["statussum_all"])?0:$statussum_all["status"][2]["statussum_all"];?></th>
			<th><?php echo empty($statussum_all["status"][3]["statussum_all"])?0:$statussum_all["status"][3]["statussum_all"];?></th>
			<th><?php echo empty($statussum_all["status"][4]["statussum_all"])?0:$statussum_all["status"][4]["statussum_all"];?></th>
			<th><?php echo empty($statussum_all["payment_status"][2]["statussum_all"])?0:$statussum_all["payment_status"][2]["statussum_all"];?></th>
			<th><?php echo empty($statussum_all["shipping_status"][1]["statussum_all"])?0:$statussum_all["shipping_status"][1]["statussum_all"];?></th>
			<th><?php echo empty($statussum_all["shipping_status"][2]["statussum_all"])?0:$statussum_all["shipping_status"][2]["statussum_all"];?></th>
			<th><?php echo $sum_order_count;?></th>
			<th><?php echo $sum_product_quntity;?></th>
			<th><?php echo sprintf($price_format,sprintf("%01.2f",$sum_sumtotal_all));?></th>
	</tr>
</table>
</div>
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function sub_action() 
{ 
	document.OrderfeeForm.action=webroot_dir+"reports/orderfee";
	document.OrderfeeForm.onsubmit= "";
	document.OrderfeeForm.submit(); 
}
function export_action() 
{  var csv_export_code = GetId("csv_export_code");
	document.OrderfeeForm.action=webroot_dir+"reports/orderfee/export/"+csv_export_code.value;
	document.OrderfeeForm.onsubmit= "";
	document.OrderfeeForm.submit(); 
}
</script>