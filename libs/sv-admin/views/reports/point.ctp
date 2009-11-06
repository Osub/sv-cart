<?php 
/*****************************************************************************
 * SV-Cart  积分报表管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: point.ctp 4718 2009-09-29 03:01:55Z huangbo $
*****************************************************************************/
?>
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
<p class="none"><span id="show3">&nbsp;</span><span id="show4">&nbsp;</span></p>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'point/','name'=>"PointForm"));?>
	<dl>
	<dt style="padding-top:2px;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" name="start_time" value="<?php echo @$start_time?>" style="border:1px solid #649776" id="date" readonly="readonly"  /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>－<input type="text" name="end_time" value="<?php echo @$end_time?>" style="border:1px solid #649776" id="date2" readonly="readonly" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
			<?php if(isset($SVConfigs["mlti_currency_module"]) && $SVConfigs["mlti_currency_module"]==1){?>
	语言:<select name="order_locale">
		<option value="">所有语言</option>
		<?php if(isset($languages) && sizeof($languages)>0){
			foreach ($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale']?>" <?php if($v['Language']['locale']==$locale){echo "selected";}?>><?php echo $v['Language']['name']?></option>
		<?php }}?>
	</select>
<?php }?>
	</p></dd>
	<dt class="curement"><input type="button" value="查询" onclick="sub_action()"/>
				CSV导出编码:
			<select id="csv_export_code">
			<?php if(isset($systemresource_info["csv_export_code"]) && sizeof($systemresource_info["csv_export_code"])>0){
			foreach ($systemresource_info["csv_export_code"] as $k => $v){if($k!=""){?>
			<option value="<?php echo $k;?>" ><?php echo $v;?></option>
			<?php }}}?>
			</select>

			<input type="button" value="导出" class="search_article" onclick="export_action()"/> </dt>
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
	<th>用户名</th>
	<th>起始积分</th>
	<th>使用</th>
	<th>获得</th>
	<th>结余</th></tr>
	<?php if(isset($User) && sizeof($User)>0){?>
	<?php $ij=0;foreach( $User as $k=>$v ){?>
	<tr <?php if((abs($ij)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }$ij++;?> >
	<td><?php echo $v['User']['name']?></td>
	<td align="center"><?php echo $v['User']['start_point']?></td>
	<td align="center"><?php echo $v['User']['zc_point']?></td>
	<td align="center"><?php echo $v['User']['sl_point']?></td>
	<td align="center"><?php echo $v['User']['pointsum']?></td></tr>
	<?php }} ?>

<tr class="thead">
	<td align="center">总计</td>
	<td align="center"><?php echo $point_start_sum?></td>
	<td align="center"><?php echo $point_zc_sum?></td>
	<td align="center"><?php echo $point_sl_sum?></td>
	<td align="center"><?php echo $pointsums?></td></tr>
	</table></div>
	
	<div class="pagers" style="position:relative">	
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>

</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function sub_action() 
{ 
	document.PointForm.action=webroot_dir+"reports/point";
	document.PointForm.onsubmit= "";
	document.PointForm.submit(); 
}
function export_action() 
{ 	var csv_export_code = GetId("csv_export_code");
	document.PointForm.action=webroot_dir+"reports/point/export/"+csv_export_code.value;
	document.PointForm.onsubmit= "";
	document.PointForm.submit(); 
}
</script>