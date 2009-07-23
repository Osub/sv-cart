<?php 
/*****************************************************************************
 * SV-Cart 订单管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: search.ctp 3099 2009-07-20 08:27:54Z huangbo $
*****************************************************************************/
?>

<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories" style="height:28px;">
	<a href="../" style="background:url(<?php echo $this->webroot?>img/order_search.gif) no-repeat;width:101px;height:24px;display:block;text-align:center;line-height:24px;color:#192E32;margin-bottom:5px;float:right;">订单高级搜索</a>
</p>
<?php echo $form->create('Report',array('action'=>'','name'=>"orderForm"));?>
<?php $form->end()?>


<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<?php echo $form->create('',array('action'=>'/batch_shipping_print/',"name"=>"OrdForm",'onsubmit'=>"return true"));?>
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th align="left" width="120px"><input type="checkbox" class="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>订单号</th>
	<th width="140px" >下单时间</th>
	<th>收货人</th>
	<th width="150px">费用</th>
	<th width="110px">支付方式</th>
	<th width="80px">配送方式</th>
	<th width="140px">订单状态</th>
	<th width="70px" >操作</th>
</tr>
<!--List Start-->
<?php if(isset($orders_list) && sizeof($orders_list)>0){?>
<?php foreach($orders_list as $k=>$v){?>
	<tr>
	<td width="140px" class="order_num no_wrap"><input type="checkbox" class="checkbox" name="checkboxes[]" value="<?php echo $v['Order']['id']?>" /><?php echo $html->link("{$v['Order']['order_code']}","/orders/{$v['Order']['id']}",'',false,false);?></td>
	<td align="center" width="120px"><?php echo $v['Order']['created']?></td>
	<td><p><?php echo $v['Order']['consignee']?><?php if(isset($v['Order']['telephone']) && !empty($v['Order']['telephone'])){?> [TEL:<?php echo $v['Order']['telephone']?>]<?php }?></p>
		<p><?php echo $v['Order']['address']?></p>
	</td>
	<td width="150px">
		<p>总金额:&nbsp&nbsp&nbsp&nbsp  <?php echo $v['Order']['total']?></p>
		<p>应付金额: <?php echo $v['Order']['should_pay']?></p>
	</td>
	<td align="center" width="110px"><?php echo $v['Order']['payment_name']?></td>
	<td align="center" width="80px"><?php echo $v['Order']['shipping_name']?></td>
	<td align="center" width="140px" ><?php echo $systemresource_info["order_status"][$v['Order']['status']];?>,<?php echo $systemresource_info["payment_status"][$v['Order']['payment_status']];?>,<?php echo $systemresource_info["shipping_status"][$v['Order']['shipping_status']];?></td>
	<td align="center" width="70px" ><?php echo $html->link("查看","/orders/{$v['Order']['id']}",array("target"=>"_blank"));?> | <?php echo $html->link("编辑","/orders/edit/{$v['Order']['id']}",array("target"=>"_blank"));?></td></tr>
<?php }}?>
</table>
<!--List End-->

<div class="pagers" style="position:relative">
<?php if(isset($orders_list) && sizeof($orders_list)>0){?>
<p class='batch'><input type="button" value="导出" onclick=export_act() /></p> 
<input type="hidden" id="url" <?php   if(isset($ex_page)){  ?> value="/orders/search/wanted?page=<?php echo $ex_page;?>&export=export"<?php }else{ ?> value="/orders/search/wanted?export=export"<?php } ?>/>
<?php }?>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
</div>
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
<script type="text/javascript">
function export_act(){ 
	var url=document.getElementById("url").value;
	window.location.href=webroot_dir+url;
}
</script>