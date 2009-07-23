<?php 
/*****************************************************************************
 * SV-Cart  编辑电子优惠券
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?>


<?php echo $javascript->link('coupon');?>
<div class="content">
<?php  echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."电子优惠券列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('Coupon',array('action'=>'edit/'.$coupontype['CouponType']['id'],'onsubmit'=>'return coupons_check();'));?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr><input type="hidden" name="data[CouponType][id]" value="<?php echo $coupontype['CouponType']['id']?>">
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos department_config">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑电子优惠券</h1></div>
	  <div class="box" style="table-layout:fixed">
	  <br />
  	    <dl><strong style="table-layout:fixed"> 电子优惠券名称:</strong>
			<dd></dd></dl>

<?php if(isset($languages) && sizeof($languages)>0){
 	foreach ($languages as $k => $v){?>
		 <dl><dt class="config_lang"><?php echo $html->image($v['Language']['img01'])?></dt>
			<dd><input type="text" id="coupontype_name_<?php echo $v['Language']['locale']?>" name="data[CouponTypeI18n][<?php echo $k?>][name]" class="text_inputs" style="width:195px;"  <?php if(isset($coupontype['CouponTypeI18n'][$v['Language']['locale']])){?>value="<?php echo  $coupontype['CouponTypeI18n'][$v['Language']['locale']]['name'];?>"<?php }else{?>value=""<?php }?>/> <font color="#ff0000">*</font></dd></dl>
<?php 
	}
}?>	

	  
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="CouponTypeI18n<?php echo $k;?>Locale" name="data[CouponTypeI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
	   <?php if(isset($coupontype['CouponTypeI18n'][$v['Language']['locale']])){?>
	<input id="CouponTypeI18n<?php echo $k;?>Id" name="data[CouponTypeI18n][<?php echo $k;?>][id]" type="hidden" value="<?php echo  $coupontype['CouponTypeI18n'][$v['Language']['locale']]['id'];?>">
	<input id="CouponTypeI18n<?php echo $k;?>CouponTypeId" name="data[CouponTypeI18n][<?php echo $k;?>][coupon_type_id]" type="hidden" value="<?php echo  $coupontype['CouponType']['id'];?>">
	   <?php }?>
<?php 
	}
}?>

	
		<dl><strong style="table-layout:fixed">电子优惠券描述:</strong><dd></dd></dl>

<?php if(isset($languages) && sizeof($languages)>0){
	
	foreach ($languages as $k => $v){?>
			<dl><dt class="config_lang"><?php echo $html->image($v['Language']['img01'])?></dt><dd><textarea name="data[CouponTypeI18n][<?php echo $k?>][description]" ><?php echo $coupontype['CouponTypeI18n'][$k]['description']?></textarea></dd></dl>
<input type="hidden" name="data[CouponTypeI18n][<?php echo $k?>][locale]" value="<?php echo $v['Language']['locale']?>" />
<?php 
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
		  <dl><dt><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text1')"))?>优惠券金额：</dt>
			<dd><input type="text"  class="text_inputs" style="width:120px;" name="data[CouponType][money]" value="<?php echo $coupontype['CouponType']['money']?>"/>
			<p class="msg" style="display:none" id="help_text1">此类型的优惠券可以底销的金额</p>
			</dd></dl>
		<dl><dt><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text2')"))?>最小订单金额：</dt>
			<dd><input type="text" name="data[CouponType][min_amount]" class="text_inputs" style="width:120px;"  value="<?php echo $coupontype['CouponType']['min_amount']?>"/>
			<p style="display:none" id="help_text2" class="msg">只有商品总金额达到这个数的订单才能使用这种红包</p>
			</dd></dl>
			
			<dl><dt>优惠券类型：</dt>
			<dd>
				<p class="msg">
				<input type="radio" class="radio" name="data[CouponType][send_type]" onclick="javascript:confirm_type(0);" value="0" <?php if($coupontype['CouponType']['send_type'] == 0){ echo "checked"; } ?>/>按用户发放&nbsp;
				<input type="radio" class="radio" name="data[CouponType][send_type]"  onclick="javascript:confirm_type(1);" value="1" <?php if($coupontype['CouponType']['send_type'] == 1){ echo "checked"; } ?> />按商品发放</p>
				<p class="msg">
				<input type="radio" class="radio" name="data[CouponType][send_type]" onclick="javascript:confirm_type(2);" value="2" <?php if($coupontype['CouponType']['send_type'] == 2){ echo "checked"; } ?> />按订单金额发放&nbsp;
				<input type="radio" class="radio" name="data[CouponType][send_type]" onclick="javascript:confirm_type(3);" value="3" <?php if($coupontype['CouponType']['send_type'] == 3){ echo "checked"; } ?> />线下发放的红包
				</p>
				<p class="msg">
				<input type="radio" class="radio" name="data[CouponType][send_type]" onclick="javascript:confirm_type(4);" value="4" <?php if($coupontype['CouponType']['send_type'] == 4){ echo "checked"; } ?> />注册后发放&nbsp;
				<input type="radio" class="radio" name="data[CouponType][send_type]"  onclick="javascript:confirm_type(5);" value="5" <?php if($coupontype['CouponType']['send_type'] == 5){ echo "checked"; } ?> style="margin-top:-1px;" />coupon&nbsp;
				</p>
				</dd>
			</dl>
			
			<div id="min_products_amount" <?php if($coupontype['CouponType']['send_type'] == 2){?>style="display:block"<?php }?>>
		<dl><dt><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text3')"))?>订单下限：</dt>
			<dd><input type="text" name="data[CouponType][min_products_amount]" class="text_inputs" style="width:120px;" value="<?php echo $coupontype['CouponType']['min_products_amount']?>" />
			<p class="msg" style="display:none" id="help_text3">只有订单金额达到该数值，就会发放优惠券给用户</p>
			</dd></dl>
				
			</div>
	
			<dl><dt>优惠券前缀：</dt>
			<dd><input type="text"  class="text_inputs" style="width:120px;" name="data[CouponType][prefix]" value="<?php echo $coupontype['CouponType']['prefix']?>"/> </dd></dl>
				 
				
		<dl><dt style="*padding-top:11px;"><?php echo $html->image('help_icon.gif',array('class'=>'vmiddle icons',"onclick"=>"help_show_or_hide('help_text4')"))?>发放起始日期：</dt>
			<dd><input type="text" name="data[CouponType][send_start_date]" class="text_inputs" style="width:120px;" value="<?php echo $coupontype['CouponType']['send_start_date']?>" id="date" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
			<p class="msg" style="display:none" id="help_text4">只有当前时间介于起始日期和截止日期之间时,<br />些类型的优惠券才可以发放</p>
			</dd>
		</dl>
		<dl><dt style="*padding-top:11px;">发放结束日期：</dt>
			<dd><input type="text" name="data[CouponType][send_end_date]" class="text_inputs" style="width:120px;" value="<?php echo $coupontype['CouponType']['send_end_date']?>" id="date2" readonly="readonly"/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
			</dd>
		</dl>
		<dl><dt><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text5')"))?>使用起始日期：</dt>
			<dd><input type="text" name="data[CouponType][use_start_date]" class="text_inputs" style="width:120px;" value="<?php echo $coupontype['CouponType']['use_start_date']?>" id="date3" readonly="readonly" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show3","class"=>"calendar"))?>
			<p class="msg">只有当前时间介于起始日期和截止日期之间时,<br />些类型的优惠券才可以发放</p>
			</dd>
		</dl>

		<dl><dt style="*padding-top:11px;">使用结束日期：</dt>
			<dd><input type="text" name="data[CouponType][use_end_date]" class="text_inputs" style="width:120px;"  value="<?php echo $coupontype['CouponType']['use_end_date']?>" id="date4" readonly="readonly" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show4","class"=>"calendar"))?>
		</dl>
		
		
	  </div>
	</div>
<!--Password End-->

</td>
</tr>
<tr><td colspan="2"><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p></td></tr>
</table>
<?php echo $form->end();?>

</div>
<!--Main Start End-->
<?php echo $html->image('content_left.gif',array('class'=>'content_left'))?><?php echo $html->image('content_right.gif',array('class'=>'content_right'))?>
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