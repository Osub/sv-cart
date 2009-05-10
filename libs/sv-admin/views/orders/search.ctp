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
 * $Id: search.ctp 1123 2009-04-29 02:43:17Z huangbo $
*****************************************************************************/
?>

<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><a href="../" style="background:url(<?=$this->webroot?>img/order_search.gif) no-repeat;width:101px;height:24px;display:block;text-align:center;line-height:24px;color:#192E32;margin-bottom:5px;float:right;">订单高级搜索</a></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
	<ul class="orders_title">
	<li class="number">订单号</li>
	<li class="time">下单时间</li>
	<li class="take_over">收货人</li>
	<li class="expenses">费用</li>
	<li class="payment">支付方式</li>
	<li class="deliver">配送方式</li>
	<li class="state">订单状态</li>
	<li class="hadle">操作</li></ul>
<!--List Start-->
<?if(isset($orders_list) && sizeof($orders_list)>0){?>
<?foreach($orders_list as $k=>$v){?>
	<ul class="orders_title orders-list">
	<li class="number"><?=$html->link("{$v['Order']['order_code']}","/orders/{$v['Order']['id']}",'',false,false);?></li>
	<li class="time">
		<span><?echo $v['Order']['created']?></span></li>
	<li class="take_over">
		<span><?echo $v['Order']['consignee']?><?if(isset($v['Order']['telephone']) && !empty($v['Order']['telephone'])){?>[TEL:<?echo $v['Order']['telephone']?>]<?}?></span>
		<span><?echo $v['Order']['address']?></span></li>
	<li class="expenses">
		<span>总金额: <code style="margin-left:12px"><?echo $v['Order']['subtotal']?></code></span>
		<span>应付金额: <?echo $v['Order']['should_pay']?></span></li>
		<li class="payment"><?echo $v['Order']['payment_name']?></li>
		<li class="deliver"><?echo $v['Order']['shipping_name']?></li>
		<li class="state"><?if($v['Order']['status'] == 0){?>未确认&nbsp;<?}elseif($v['Order']['status'] == 1){?>已确认&nbsp;<?}elseif($v['Order']['status'] == 2){?>已取消&nbsp;<?}elseif($v['Order']['status'] == 3){?>无效&nbsp;<?}elseif($v['Order']['status'] == 4){?>退货&nbsp;<?}?>
		<?if($v['Order']['payment_status'] == 0){?>未付款&nbsp;<?}elseif($v['Order']['payment_status'] == 1){?>付款中&nbsp;<?}elseif($v['Order']['payment_status'] == 2){?>已付款&nbsp;<?}?>
		<?if($v['Order']['shipping_status'] == 0){?>未发货&nbsp;<?}elseif($v['Order']['shipping_status'] == 1){?>已发货&nbsp;<?}elseif($v['Order']['shipping_status'] == 2){?>已收货&nbsp;<?}elseif($v['Order']['shipping_status'] == 3){?>备货中&nbsp;<?}?></li>
		<li class="hadle"><?php echo $html->link("查看","/orders/{$v['Order']['id']}");?></li></ul>
<?}}?>

<!--List End-->
<div class="pagers" style="position:relative">
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