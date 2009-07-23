<?php 
/*****************************************************************************
 * SV-Cart 退货单
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: returns.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?>
 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Search-->

<div class="search_box">
  <?php echo $form->create('',array('action'=>'/','name'=>'TheForm'));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">选择日期：<input type="text" class="time" name="start_time" value="<?php echo $start_time?>" id="date" readonly="readonly" /><?php echo $html->image('calendar.gif',array("id"=>"show","class"=>"calendar"))?>
	<input type="text" class="time" name="end_time" value="<?php echo $end_time?>" id="date2" readonly="readonly"  /><?php echo $html->image('calendar.gif',array("id"=>"show2","class"=>"calendar"))?>
		<?php if(isset($SVConfigs["mlti_currency_module"]) && $SVConfigs["mlti_currency_module"]==1){?>

	语言:	<select name="order_locale">
		<?php if(isset($languages) && sizeof($languages)>0){?>
			<option value="all">all</option>
			<?php foreach ($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale']?>" <?php if($v['Language']['locale']==$locale){echo "selected";}?>><?php echo $v['Language']['name']?></option>
		<?php }}?>
	</select>
		<?php }?>
	</p></dd>
	<dt style="" class="curement"><input type="button" value="查询" onclick="sub_action()"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="导出"  onclick="export_action()"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="打印"  onclick="batch_print()"/> </dt>
	</dl>
<?php echo $form->end();?>


</div>


<br />
<!--Search End-->

	<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
	<?php echo $form->create('',array('action'=>'/batch_shipping_print/','name'=>'testForm','target'=>'_blank'));?>
		<ul class="product_llist procurements">
			<li class="item_number"><input type="checkbox" id="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>订单号</li>
			<li class="name ship_name"><p>姓名</p></li>
			<li class="profiles addresse">地址</li>
			<li class="number">电话</li>
			<li class="units">付款方式</li>
			<li class="supplier">操作日期</li>
			<li class="remark">金额总计</li>
		</ul>
		<?php if(isset($orders) && sizeof($orders)>0){?>
		<?php foreach($orders as $order){?>
		<ul class="product_llist procurements procurements_list"style="clear:both;">
			<li class="item_number ordernumber"><input type="checkbox" name="checkboxes[]" value="<?php echo $order['Order']['id']?>" /><?php echo $html->link("{$order['Order']['order_code']}","/orders/{$order['Order']['id']}",'',false,false);?></li>
			<li class="name ship_name"><p><?php echo $order['Order']['consignee']?></p></li>
			<li class="profiles addresse"><span><?php echo $order['Order']['address']?></span></li>
			<li class="number"><span><?php echo $order['Order']['telephone']?></span></li>
			<li class="units"><?php echo $order['Order']['payment_name']?></li>
			<li class="supplier phone"><?php echo $order['Order']['modified']?></li>
			<li class="remark"><?php echo $order['Order']['total']?></li>
		</ul>
		
	<!--显示所有订单商品-->
		<div class="show_all">
			<div class="show_all_order">
				<ul class="product_llist procurements item_order">
				<li class="item_number">货号</li>
				<li class="name ship_name"><p>商品名称</p></li>
				<li class="number">数量</li>
				<li class="supplier">属性</li>
				<li class="remark" style="text-align:left;"><p>价格</p></li></ul>
				<?php if(isset($order['OrderProduct']) && sizeof($order['OrderProduct'])>0)foreach($order['OrderProduct'] as $op){?>
				<ul class="product_llist procurements procurements_list item_order">
				<li class="item_number ordernumber"><span><?php echo $op['product_code']?></span></li>
				<li class="name ship_name"><p><?php echo $op['product_name']?></p></li>
				<li class="number"><?php echo $op['product_quntity']?></li>
				<li class="supplier"><?php echo $op['product_attrbute']?></li>
				<li class="remark" style="text-align:left;"><p><?php echo $op['product_price']?></p></li></ul>
				<?php }?>
			</div>
			<p style="clear:both"></p>
		</div>
		<?php }}?>
		<input name="act" type="hidden" value="batch"/>
	<?php echo $form->end();?>
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
<script>
function batch_shipping_print(){
    var id=document.getElementsByName('checkboxes[]');
	var i;
	var j=0;
	for( i=0;i<=parseInt(id.length)-1;i++ ){
		if(id[i].checked){
			j++;
		}
	}
	if( j<1 ){
		return false;
	}else{
		document.OrdForm.action=webroot_dir+"orders/batch_shipping_print";
	    document.OrdForm.onsubmit= "";
	    document.OrdForm.submit();
	}
}
function sub_action() 
{ 
	document.TheForm.action=webroot_dir+"reports/returns";
	document.TheForm.onsubmit= "";
	document.TheForm.submit(); 
}
function export_action() 
{ 
	document.TheForm.action=webroot_dir+"reports/returns/export";
	document.TheForm.onsubmit= "";
	document.TheForm.submit(); 
}

function batch_print() 
{    
    var id=document.getElementsByName('checkboxes[]');
	var i;
	var j=0;
	for( i=0;i<=parseInt(id.length)-1;i++ ){
		if(id[i].checked){
			j++;
		}
	}
	if( j<1 ){
		return false;
	}else{
		document.testForm.action=webroot_dir+"reports/batch_return_print";
		document.testForm.onsubmit= "";
		document.testForm.submit(); 
	}
}
</script>
