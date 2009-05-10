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
 * $Id: index.ctp 1273 2009-05-08 16:49:08Z huangbo $
*****************************************************************************/
?>

<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Search-->

<div class="search_box">
  <?php echo $form->create('',array('action'=>'/','type'=>'get'));?>

	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif')?></dt>
	<dd><p class="reg_time">下单时间：<input type="text" id="date" name="date" value="<?=@$start_time?>" readonly /><button type="button" id="show" title="Show Calendar">

	<?=$html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar'))?>
	</button>--<input type="text" id="date2" name="date2" value="<?=@$end_time?>"  readonly/><button type="button" id="show2" title="Show Calendar">	<?=$html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar'))?>
</button>
	&nbsp;&nbsp;收货人：<input type="text" class="name" name="consignee" id="consignee" value="<?echo $consignee?>"/>&nbsp;&nbsp;订单号：<input type="text" class="name" name="order_id" id="order_id" value="<?echo $order_id?>"/></p>
	<p class="confine">
		<select style="width:110px;" name="order_status">
		<option value="-1">订单状态</option>
		<option value="0" <?if ($order_status == 0){?>selected<?}?>>未确认</option>
		<option value="1" <?if ($order_status == 1){?>selected<?}?>>已确认</option>
		<option value="2" <?if ($order_status == 2){?>selected<?}?>>已取消</option>
		<option value="3" <?if ($order_status == 3){?>selected<?}?>>无效</option>
		<option value="4" <?if ($order_status == 4){?>selected<?}?>>退货</option>
		</select>
		<select style="width:110px;" name="shipping_status">
		<option value="-1">配送状态</option>
		
		<option value="0" <?if ($shipping_status == 0){?>selected<?}?>>未发货</option>
		<option value="1" <?if ($shipping_status == 1){?>selected<?}?>>已发货</option>
		<option value="2" <?if ($shipping_status == 2){?>selected<?}?>>已收货</option>
		<option value="3" <?if ($shipping_status == 3){?>selected<?}?>>备货中</option>

		</select>
		<select style="width:110px;" name="payment_status">
		<option value="-1">付款状态</option>
		<option value="0" <?if ($payment_status == 0){?>selected<?}?>>未付款</option>
		<option value="1" <?if ($payment_status == 1){?>selected<?}?>>付款中</option>
		<option value="2" <?if ($payment_status == 2){?>selected<?}?>>已付款</option>
		
		</select></p></dd>
	<dt class="big_search"><input type="submit" class="big" value="搜索" /></dt>
	</dl>
<? echo $form->end();?>
</div>


<br />
<!--Search End-->

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