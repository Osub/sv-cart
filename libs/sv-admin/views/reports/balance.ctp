<?php 
/*****************************************************************************
 * SV-Cart  用户资金报表管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: balance.ctp 4718 2009-09-29 03:01:55Z huangbo $
*****************************************************************************/
?>	<!--时间控件层start-->
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

<p class="none"><span id="show3">&nbsp;eee</span><span id="show4">&nbsp;</span></p>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'balance/','name'=>"BalanceForm"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" name="start_time" value="<?php echo @$start_time?>" style="border:1px solid #649776" id="date"  readonly="readonly" /><?php echo $html->image('calendar.gif',array("id"=>"show","class"=>"calendar"))?>
	<input type="text" name="end_time" value="<?php echo @$end_time?>" style="border:1px solid #649776" id="date2" readonly="readonly" /><?php echo $html->image('calendar.gif',array("id"=>"show2","class"=>"calendar"))?>
		<?php if(isset($SVConfigs["mlti_currency_module"]) && $SVConfigs["mlti_currency_module"]==1){?>
	语言:	<select name="order_locale">
			<option value="" >所有语言</option>
		<?php if(isset($languages) && sizeof($languages)>0){
			foreach ($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale']?>" <?php if($v['Language']['locale']==$locale){echo "selected";}?>><?php echo $v['Language']['name']?></option>
		<?php }}?>
	</select>
<?php }?>
	<input type="text" name="username" style="width:70px;border:1px solid #649776" value="<?php echo $username;?>">
	费用:	<select name="balance">
			<option value="1" <?php if($balance==1){echo "selected";}?> >大于</option>
			<option value="2" <?php if($balance==2){echo "selected";}?> >等于</option>
			<option value="3" <?php if($balance==3){echo "selected";}?> >小于</option>
	</select>
	<input type="text" name="usermoney" style="width:63px;border:1px solid #649776" value="<?php echo $usermoney;?>">

	</p></dd>
	<dt class="small_search"><input  class="search_article" type="button" value="查询" onclick="sub_action()"/>		
		CSV导出编码:
			<select id="csv_export_code">
			<?php if(isset($systemresource_info["csv_export_code"]) && sizeof($systemresource_info["csv_export_code"])>0){
			foreach ($systemresource_info["csv_export_code"] as $k => $v){if($k!=""){?>
			<option value="<?php echo $k;?>" ><?php echo $v;?></option>
			<?php }}}?>
			</select> <input type="button" class="search_article" value="导出"  onclick="export_action()"/> </dt>
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
	<th width="37%">用户名</th>
	<th width="18%">始起资金</th>
	<th width="18%">使用</th>
	<th width="18%">获得</th>
	<th width="18%">结余</th></tr>
	
<!--ConsumeList-->
	
	
	<?php if(isset($User) && sizeof($User)>0){?>
<?php foreach( $User as $k=>$v ){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><strong><?php echo $v['User']['name']?></strong></td>
	<td align="center"><?php echo $v['User']['start_amount']?></td>
	<td align="center"><?php echo $v['User']['zc_amount']?></td>
	<td align="center"><?php echo $v['User']['sl_amount']?></td>
	<td align="center"><?php echo $v['User']['amountsum']?></td></tr>
	<?php }} ?>	
<!--ConsumeList End-->
<tr class="thead">
	<td align="center">总计</td>
	<td align="center"><?php echo $amount_start_sum?></td>
	<td align="center"><?php echo $amount_zc_sum?></td>
	<td align="center"><?php echo $amount_sl_sum?></td>
	<td align="center"><?php echo $amountsums?></td></tr>
	</table></div>


<!--Main Start End--><div class="pagers" style="position:relative">	
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
</div>
<script type="text/javascript">
function sub_action() 
{ 
	document.BalanceForm.action=webroot_dir+"reports/balance";
	document.BalanceForm.onsubmit= "";
	document.BalanceForm.submit(); 
}
function export_action() 
{ 	var csv_export_code = GetId("csv_export_code");
	document.BalanceForm.action=webroot_dir+"reports/balance/export/"+csv_export_code.value;
	document.BalanceForm.onsubmit= "";
	document.BalanceForm.submit(); 
}
</script>