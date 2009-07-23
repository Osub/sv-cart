<?php 
/*****************************************************************************
 * SV-Cart  会员消费报表管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: consume.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($orders);pr($users);?>
<!--Search-->

	
	
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'consume/','name'=>"ConsumeForm"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" class="time" name="start_time" value="<?php echo $start_time?>"id="date" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>－<input type="text" class="time" name="end_time" value="<?php echo $end_time?>" id="date2" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
		<?php if(isset($SVConfigs["mlti_currency_module"]) && $SVConfigs["mlti_currency_module"]==1){?>
	语言:	<select name="order_locale">
		<?php if(isset($languages) && sizeof($languages)>0){
			foreach ($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale']?>" <?php if($v['Language']['locale']==$locale){echo "selected";}?>><?php echo $v['Language']['name']?></option>
		<?php }}?>
	</select>
<?php }?>
	
	</p></dd>
	<dt class="curement"><input type="button" value="查询" onclick="sub_action()"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="导出"  onclick="export_action()"/> </dt>
	</dl>
<?php $form->end()?>
</div>
<br /><br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>会员名称</th>
	<th>订单数</th>
	<th>商品数量</th>
	<th>消费总金额</th></tr>
	
<!--ConsumeList-->
<?php if(isset($order_sum) && sizeof($order_sum)>0){
	foreach($order_sum as $k=>$v){?>
	<tr>
	<td><strong><?php  echo $v["user_name"];?></strong></td>
	<td align="center"><?php  echo $v["order_sum"];?></td>
	<td align="center"><?php  echo $v["order_product_sum"];?></td>
	<td align="center"><?php  echo sprintf($price_format,sprintf("%01.2f",$v["order_money_paid_sum"]));?></td></tr>
<?php }}?>	
<!--ConsumeList End-->
<tr class="thead">
	<td align="center">总计</td>
	<td align="center"><?php echo $total_order_sum?></td>
	<td align="center"><?php echo $total_order_product_sum?></td>
	<td align="center"><?php echo sprintf($price_format,sprintf("%01.2f",$price_format_sum))?></td></tr>
</table>
</div>
<!--Main Start End-->
</div><!--时间控件层start-->
	<div id="container_cal" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal2" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal2"></div><div style="clear:both;"></div></div>
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
	document.ConsumeForm.action=webroot_dir+"reports/consume";
	document.ConsumeForm.onsubmit= "";
	document.ConsumeForm.submit(); 
}
function export_action() 
{ 
	document.ConsumeForm.action=webroot_dir+"reports/consume/export";
	document.ConsumeForm.onsubmit= "";
	document.ConsumeForm.submit(); 
}
</script>