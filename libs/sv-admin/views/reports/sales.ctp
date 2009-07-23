<?php 
/*****************************************************************************
 * SV-Cart  商品销售报表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: sales.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($orderproducts);?>
<!--Search-->

	
	
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'sales/','name'=>"SalesForm"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" class="time" name="start_time" value="<?php echo $start_time?>"id="date" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>－<input type="text" class="time" name="end_time" value="<?php echo $end_time?>"id="date2" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
		<?php if(isset($SVConfigs["mlti_currency_module"]) && $SVConfigs["mlti_currency_module"]==1){?>
		语言:	<select name="order_locale">
		<?php if(isset($languages) && sizeof($languages)>0){
			foreach ($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale']?>" <?php if($v['Language']['locale']==$locale){echo "selected";}?>><?php echo $v['Language']['name']?></option>
		<?php }}?>
	</select>
		<?php }?>
	</p></dd>
	<dt class="curement"><input type="submit" value="查询" onclick="sub_action()"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="导出"  onclick="export_action()"/> </dt>
	</dl>
<?php $form->end()?>
</div>
<br /><br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="80px">货号</th>
	<th>商品名称</th>
	<th  width="40px" ><?php echo $html->link('数量','/reports/sales/0/number/'.$asc_desc,array(),false,false);?> <?php if($orderby=="number"){if($asc_desc=="desc"){echo $html->image("sort_desc.gif");}else{echo $html->image("sort_desc_up.gif");}}?></th>
	<th  width="120px" ><?php echo $html->link('金额','/reports/sales/0/amount/'.$asc_desc,array(),false,false);?> <?php if($orderby=="amount"){if($asc_desc=="desc"){echo $html->image("sort_desc_up.gif");}else{echo $html->image("sort_desc.gif");}}?></th></tr>
	
<!--ConsumeList-->
	<?php if(isset($orderproducts) && sizeof($orderproducts)>0){?>
	<?php foreach($orderproducts as $orderproduct){?>
	<tr>
	<td width="80px"><?php echo $orderproduct['OrderProduct']['product_code']?></td>
	<td><?php echo $orderproduct['OrderProduct']['product_name']?></td>
	<td align="center" width="40px"><?php echo $orderproduct['OrderProduct']['product_quntity']?></td>
	<td width="120px"><?php echo $orderproduct['OrderProduct']['product_price']?></td></tr>
	<?php }}?>
<!--ConsumeList End-->
<tr class="thead">
	<td align="center"  width="80px">总计</td>
	<td align="center"><?php echo $productcount?></td>
	<td align="center"><?php echo $quntitysum?></td>
	<td><?php echo $pricesum?></td></tr>
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
	document.SalesForm.action=webroot_dir+"reports/sales";
	document.SalesForm.onsubmit= "";
	document.SalesForm.submit(); 
}
function export_action() 
{ 
	document.SalesForm.action=webroot_dir+"reports/sales/export";
	document.SalesForm.onsubmit= "";
	document.SalesForm.submit(); 
}
</script>