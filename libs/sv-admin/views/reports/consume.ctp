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
 * $Id: consume.ctp 4899 2009-10-11 11:00:30Z huangbo $
*****************************************************************************/
?><!--时间控件层start-->
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
<p class="none"><span id="show3">&nbsp;</span><span id="show4">&nbsp;</span></p>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($orders);pr($users);?>
<!--Search-->

<div class="search_box">
<?php echo $form->create('Report',array('action'=>'consume/','name'=>"ConsumeForm"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" style="border:1px solid #649776" name="start_time" value="<?php echo $start_time?>"id="date" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>－<input type="text" style="border:1px solid #649776" name="end_time" value="<?php echo $end_time?>" id="date2" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
		<?php if(isset($SVConfigs["mlti_currency_module"]) && $SVConfigs["mlti_currency_module"]==1){?>
	语言:	<select name="order_locale">
		<?php if(isset($languages) && sizeof($languages)>0){
			foreach ($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale']?>" <?php if($v['Language']['locale']==$locale){echo "selected";}?>><?php echo $v['Language']['name']?></option>
		<?php }}?>
	</select>
<?php }?>


	</p></dd>
	<dt class="small_search"><input  class="search_article" type="button" value="查询" onclick="sub_action()"/> 		CSV导出编码:
			<select id="csv_export_code">
			<?php if(isset($systemresource_info["csv_export_code"]) && sizeof($systemresource_info["csv_export_code"])>0){
			foreach ($systemresource_info["csv_export_code"] as $k => $v){if($k!=""){?>
			<option value="<?php echo $k;?>" ><?php echo $v;?></option>
			<?php }}}?>
			</select> <input type="button" value="导出"class="search_article"  onclick="export_action()"/> </dt>
	</dl>
<?php $form->end()?>
</div>
<br /><br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="25%">会员名称</th>
	<th width="25%"><?php echo $html->link('订单数','/reports/consume/0/number/'.$asc_desc,array(),false,false);?> <?php if($orderby=="number"){if($asc_desc=="desc"){echo $html->image("sort_desc_up.gif");}else{echo $html->image("sort_desc.gif");}}?></th>
	<th width="25%">商品数量</th>
	<th width="25%"><?php echo $html->link('消费总金额','/reports/consume/0/amount/'.$asc_desc,array(),false,false);?> <?php if($orderby=="amount"){if($asc_desc=="desc"){echo $html->image("sort_desc_up.gif");}else{echo $html->image("sort_desc.gif");}}?></th></tr>
	
<!--ConsumeList-->
<?php $total_order_sum=0;$total_order_product_sum=0;$price_format_sum=0;$ij=0;if(isset($order_group) && sizeof($order_group)>0){
	foreach($order_group as $k=>$v){?>
	<tr <?php if((abs($ij)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }$ij++;?> >
	<td><?php echo $html->link($v["Order"]["user_name"],"/users/".$v["Order"]["user_id"],array("target"=>"_blank","style"=>"color: #036; text-decoration: none; border-bottom: 1px solid #666;"),false,false);?></td>
	<td align="center"><?php  echo $v["0"]["sumorderid"];$total_order_sum+= $v["0"]["sumorderid"];?></td>
	<td align="center"><?php  echo $v["Order"]["product_quntity"];$total_order_product_sum+= $v["Order"]["product_quntity"];?></td>
	<td align="center"><?php  echo sprintf($price_format,sprintf("%01.2f",$v["0"]["money_paid"]));$price_format_sum+= $v["0"]["money_paid"];?></td></tr>
<?php }}?>	
<!--ConsumeList End-->
<tr class="thead">
	<th>总计</td>
	<th><?php echo $total_order_sum?></th>
	<th><?php echo $total_order_product_sum?></th>
	<th><?php echo sprintf($price_format,sprintf("%01.2f",$price_format_sum))?></th></tr>
</table></div><div class="pagers" style="position:relative">	
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function sub_action() 
{ 
	document.ConsumeForm.action=webroot_dir+"reports/consume";
	document.ConsumeForm.onsubmit= "";
	document.ConsumeForm.submit(); 
}
function export_action() 
{ 	var csv_export_code = GetId("csv_export_code");
	document.ConsumeForm.action=webroot_dir+"reports/consume/export/"+csv_export_code.value;
	document.ConsumeForm.onsubmit= "";
	document.ConsumeForm.submit(); 
}
</script>