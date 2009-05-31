<?php
/*****************************************************************************
 * SV-Cart 新增优惠券
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
?>


<?=$javascript->link('coupon');?>
<div class="content">
<?php  echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<br />
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."电子优惠券列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('Coupon',array('action'=>'add/','onsubmit'=>'return coupons_check();'));?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos department_config">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑电子优惠券</h1></div>
	  <div class="box" style="table-layout:fixed">
	  <br />
  	    <dl><strong style="table-layout:fixed"> 电子优惠券名称:</strong>
			<dd></dd></dl>

<? if(isset($languages) && sizeof($languages)>0){
 	foreach ($languages as $k => $v){?>
		 <dl><dt class="config_lang"><?=$html->image($v['Language']['img01'])?></dt>
			<dd><input type="text" id="coupontype_name_<?=$v['Language']['locale']?>" name="data[CouponTypeI18n][<?=$k?>][name]" class="text_inputs" style="width:195px;" /> <font color="#ff0000">*</font></dd></dl>
<?
	}
}?>	
	
		<dl><strong style="table-layout:fixed">电子优惠券描述:</strong><dd></dd></dl>

<? if(isset($languages) && sizeof($languages)>0){
	
	foreach ($languages as $k => $v){?>
			<dl><dt class="config_lang"><?=$html->image($v['Language']['img01'])?></dt><dd><textarea name="data[CouponTypeI18n][<?=$k?>][description]" ></textarea></dd></dl>
<input type="hidden" name="data[CouponTypeI18n][<?=$k?>][locale]" value="<?=$v['Language']['locale']?>" />
<?
	}
}?>	
		
	
	<br />	
	<br />
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Password-->
	<div class="order_stat athe_infos">
	  
	  <div class="box">
		<br />
		  <dl><dt><?=$html->image('help_icon.gif')?>优惠券金额：</dt>
			<dd><input type="text"  class="text_inputs" style="width:120px;" name="data[CouponType][money]" /> </dd></dl>
			<dl><dt></dt>
			<dd>此类型的优惠券可以底销的金额</dd></dl>
		<dl><dt><?=$html->image('help_icon.gif')?>最小订单金额：</dt>
			<dd><input type="text" name="data[CouponType][min_amount]" class="text_inputs" style="width:120px;"  /></dd></dl>
			<dl><dt></dt>
			<dd>只有商品总金额达到这个数的订单才能使用这种红包</dd></dl>
			
			<dl><dt>优惠券类型：</dt>
			<dd><input type="radio" name="data[CouponType][send_type]" onclick="javascript:confirm_type(0);" value="0" checked /> 按用户发放 <input type="radio" name="data[CouponType][send_type]" onclick="javascript:confirm_type(1);" value="1"  /> 按商品发放</dd>
			</dl>
			<dl><dt></dt>
			<dd><input type="radio" name="data[CouponType][send_type]" onclick="javascript:confirm_type(2);" value="2"  /> 按订单金额发放 <input type="radio" name="data[CouponType][send_type]" onclick="javascript:confirm_type(3);" value="3"  /> 线下发放的红包</dd>
			</dl>
			<dl><dt></dt>
			<dd><input type="radio" name="data[CouponType][send_type]" onclick="javascript:confirm_type(4);" value="4"  /> 注册后发放 <input type="radio" name="data[CouponType][send_type]" onclick="javascript:confirm_type(5);" value="5"  /> coupon</dd>
			</dl>
				<div id="min_products_amount" style="display:none">
		<dl><dt><?=$html->image('help_icon.gif')?>订单下限：</dt>
			<dd><input type="text" name="data[CouponType][min_products_amount]" class="text_inputs" style="width:120px;"  /></dd></dl>
			<dl><dt></dt>
			<dd> 只有订单金额达到该数值，就会发放优惠券给用户</dd></dl>					
				</div>
			<dl><dt><?=$html->image('help_icon.gif')?>优惠券前缀：</dt>
			<dd><input type="text"  class="text_inputs" style="width:120px;" name="data[CouponType][prefix]" /> </dd></dl>
			<dl><dt></dt><dd></dd></dl>
							
								
		<dl><dt><?=$html->image('help_icon.gif')?>发放起始日期：</dt><span class="search_box"  style="background:none;padding:0;border:0;width:1px;" >
			<dd><input type="text" name="data[CouponType][send_start_date]" class="text_inputs" style="width:120px;" readonly="readonly" id="date" /><button type="button" id="show"><?=$html->image('calendar.gif')?></button></dd></span></dl>
		<dl><dt></dt>
			<dd>只有当前时间介于起始日期和截止日期之间时,<br />些类型的优惠券才可以发放</dd></dl>
		<dl><dt>发放结束日期：</dt><span class="search_box" style="background:none;padding:0;border:0" >
			<dd><input type="text" name="data[CouponType][send_end_date]" class="text_inputs" style="width:120px;" readonly="readonly"  id="date2" /><button type="button" id="show2"><?=$html->image('calendar.gif')?></button></dd></span></dl>
		<dl><dt><?=$html->image('help_icon.gif')?>使用起始日期：</dt><span class="search_box" style="background:none;padding:0;border:0" >
			<dd><input type="text" name="data[CouponType][use_start_date]" class="text_inputs" style="width:120px;"readonly="readonly" id="date3" /><button type="button" id="show3"><?=$html->image('calendar.gif')?></button></dd></span></dl>
		<dl><dt></dt>
			<dd>只有当前时间介于起始日期和截止日期之间时,<br />些类型的优惠券才可以发放</dd></dl>
		<dl><dt>使用结束日期：</dt><span class="search_box" style="background:none;padding:0;border:0" >
			<dd><input type="text" name="data[CouponType][use_end_date]" class="text_inputs" style="width:120px;"readonly="readonly" id="date4" /><button type="button" id="show4"><?=$html->image('calendar.gif')?></button></dd></span></dl>
		
		
	  </div>
	</div>
<!--Password End-->

</td>
</tr>
<tr><td colspan="2"><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p></td></tr>
</table>
<? echo $form->end();?>

</div>
<!--Main Start End-->
<?=$html->image('content_left.gif',array('class'=>'content_left'))?><?=$html->image('content_right.gif',array('class'=>'content_right'))?>
</div>
	
	<!--时间控件层start-->
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