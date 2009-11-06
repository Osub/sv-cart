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
 * $Id: view.ctp 4218 2009-09-11 02:34:41Z huangbo $
*****************************************************************************/
?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
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
<br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>用户名</th>
	<th>商品名称</th>
	<th>数量</th>
	<th>单价</th></tr>
	<?php if(isset($product_list) && sizeof($product_list)>0){?>
	<?php foreach( $product_list as $k=>$v ){if(!empty($v)){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center"><?php if(isset($user_info) && sizeof($user_info)>0){echo $user_info['User']['name'];}?></td>
	<td align="center"><?php echo $v['Cart']['product_name']?></td>
	<td align="center"><?php echo $v['Cart']['product_quantity']?></td>
	<td align="center"><?php echo $v['Cart']['product_price']?></td>
	</tr>
	<?php }}} ?>
</table></div>
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
{ 
	document.PointForm.action=webroot_dir+"reports/point/export";
	document.PointForm.onsubmit= "";
	document.PointForm.submit(); 
}
</script>