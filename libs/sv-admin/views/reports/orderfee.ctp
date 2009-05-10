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
 * $Id: orderfee.ctp 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($monthes)?>
<!--Search-->

	
	
<div class="search_box">
<?php echo $form->create('Report',array('action'=>'orderfee'));?>
	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<!--<select name="month">
	<?php foreach($monthes as $k=>$v){?>
	<option value='<?=$v?>'<?php if($v==$month) echo 'selected';?>><?=$k?></option>
	<?php }?>
	</select>-->
	<select name="year">
	<?php foreach($now_year_arr as $k=>$v){?>
	<option value='<?=$v?>'<?php if($v==$month) echo 'selected';?>><?=$k?></option>
	<?php }?>
	</select>-
	<select name="month">
	<?php foreach($now_month_arr as $k=>$v){?>
	<option value='<?=$v?>'<?php if($v==$now_month) echo 'selected';?>><?=$k?></option>
	<?php }?>
	</select>
	
	</p></dd>
	<dt class="curement"><input type="submit" value="查询" /> </dt>
	</dl>
<?php $form->end()?>
</div>
<br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<style type="text/css">
	table.second_headers tr.headers th{border-bottom:1px solid #ABABAB;border-right:1px solid #E1E1E1;font-weight:normal;}
</style>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="orderfees">
	<tr class="orderfee_headers">
		<th height="31" width="16%" style="border-right:1px solid #ABABAB;">时间</th>
		<th height="31" width="47%" colspan="5" style="border-right:0;">订单状态</th>
		<th rowspan="2" width="12%" style="border-left:1px solid #ABABAB">订单数量</th>
		<th rowspan="2" width="12%">数量小计</th>
		<th rowspan="2" width="12%">金额小计</th>
	</tr>
	<tr>
	  <td height="33" align="center" style="border-right:1px solid #ABABAB;"><strong><?php $temp=explode('-',$month);echo $temp[0].'年'.$temp[1].'月' ?></strong></td>
<!--状态标题 循环时请注意这个th跨行-->
	  <th colspan="5" rowspan="<?php echo $n+2?>" style="border-right:0;">
	  	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="second_headers">
		<tr class="headers"><th width="20%" height="30">未确认</th><th width="20%">已确认</th><th width="20%">已取消</th><th width="20%">无效</th><th width="20%" style="border-right:0;">退货</th></tr>
		    		<?if(isset($order_status) && sizeof($order_status)>0){?>

		<?php foreach($order_status as $k=>$v){?>
		<tr><td width="20%" height="31"><?php if(isset($v[0]))echo $v[0];else echo 0;?></td>
			<td width="20%" ><?php if(isset($v[1]))echo $v[1];else echo 0;?></td>
			<td width="20%" ><?php if(isset($v[2]))echo $v[2];else echo 0;?></td>
			<td width="20%" ><?php if(isset($v[3]))echo $v[3];else echo 0;?></td>
			<td width="20%" ><?php if(isset($v[4]))echo $v[4];else echo 0;?></td>
			
		</tr>
		<?php }}?>
		<tr class="orderfee_headers"><th width="20%" height="31"><?php if(isset($all_order_status[0])) echo $all_order_status[0];else echo 0;?></th>
			<th width="20%" ><?php if(isset($all_order_status[1])) echo $all_order_status[1];else echo 0;?></th>
			<th width="20%" ><?php if(isset($all_order_status[2])) echo $all_order_status[2];else echo 0;?></th>
			<th width="20%" ><?php if(isset($all_order_status[3])) echo $all_order_status[3];else echo 0;?></th>
			<th width="20%" ><?php if(isset($all_order_status[4])) echo $all_order_status[4];else echo 0;?></th>
	  </tr></table></th>
<!--状态标题 End-->	
    </tr>
    		<?if(isset($order_status) && sizeof($order_status)>0){?>
    <?php foreach($order_status as $k=>$v){?>
	<tr>
		<td align="center" width="16%" height="31"><strong><?php echo $k?>日</strong></td>
		<td align="center" width="12%"><?php echo $v['count_order']?></td>
		<td align="center" width="12%"><?php echo $v['count_product']?></td>
		<td align="center" width="12%"><?php echo $v['sum_total']?></td>
	</tr>
	<?php }}?>
	<tr class="orderfee_headers">
		<th height="31" width="16%">总计</th>
		<th rowspan="2" width="12%"><?php echo $all_order['order']?></th>
		<th rowspan="2" width="12%"><?php echo $all_order['product']?></th>
		<th rowspan="2" width="12%"><?php echo $all_order['total']?></th>
	</tr>
</table>
	
	
	

</div>
<!--Main Start End-->
</div>