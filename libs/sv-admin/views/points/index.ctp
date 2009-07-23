<?php 
/*****************************************************************************
 * SV-Cart 积分管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3243 2009-07-23 02:30:48Z huangbo $
*****************************************************************************/
?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>'PointForm','type'=>'get'));?>
	<dl>
	<dt style="padding-top:2px;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" name="start_time" class="time" id="date" value="<?php echo @$start_time?>" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>－<input type="text" name="end_time" value="<?php echo @$end_time?>" class="time" id="date2" readonly="readonly" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
	类型：
	<select name="log_type">
	<option value="" >全部</option>
	<?php foreach( $point_log_type as $k=>$v ){?>
	<option value="<?php echo $k;?>" <?php if(@$log_type==$k){ echo "selected";}?> ><?php echo $v;?></option>
	<?php }?>
	</select>
	&nbsp;&nbsp;会员名称：<input type="text" class="time" name="name" value="<?php echo @$names?>" style="width:120px;" /></p></dd>
	<dt style="" class="curement"><input type="button" onclick="search_point()" value="查询" /> </dt>
	</dl>
<?php echo $form->end();?>
</div>
<!--Search End-->
<!--Main Start-->
<br />
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="150px">操作日期</th>
	<th width="150px">会员名称</th>
	<th width="120px">类型</th>
	<th width="90px">积分</th>
	<th>备注</th>
</tr>
<!--Menberleves List-->
<?php if(isset($UserPointLog_list) && sizeof($UserPointLog_list)>0){?>
<?php foreach( $UserPointLog_list as $k=>$v ){ ?>
<tr>
	<td align="center"><?php echo $v['UserPointLog']['modified']?></td>
	<td><?php echo $v['UserPointLog']['name']?></td>
	<td align="center"><?php echo $v['UserPointLog']['log_type']?></td>
	<td align="center"><p><?php echo $v['UserPointLog']['point']?></td>
	<td><?php echo $v['UserPointLog']['description']?></td>
</tr>
<?php }} ?>	
</table>
<!--Menberleves List End-->	

	<div class="pagers" style="position:relative;">
   <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
   </div>
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">

function search_point() 
{ 
document.PointForm.action=webroot_dir+"points/"; 
document.PointForm.submit(); 
} 

</script>

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