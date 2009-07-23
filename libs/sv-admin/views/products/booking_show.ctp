<?php 
/*****************************************************************************
 * SV-Cart  新增部门管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: booking_show.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."缺货登记列表","/products/search/wanted",'',false,false);?></strong></p>

<!--Main Start-->

<div class="home_main">
<?php echo $form->create('Product',array('action'=>'booking_show/'.$id));?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos department_config">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  缺货登记</h1></div>
	  <div class="box">
	  <br />
  	    <dl><dt class="config_lang">登记用户:</dt>
		<dd><?php echo $bookingproduct_info["User"]["name"]?></dd></dl>
  	    <dl><dt class="config_lang">登记时间:</dt>
		<dd><?php echo $bookingproduct_info["BookingProduct"]["booking_time"]?></dd></dl>
  	    <dl><dt class="config_lang">数量:</dt>
		<dd><?php echo $bookingproduct_info["BookingProduct"]["product_number"]?></dd></dl>
  	    <dl><dt class="config_lang">缺货商品名:</dt>
		<dd><?php echo $bookingproduct_info["BookingProduct"]["product_name"]?></dd></dl>
  	    <dl><dt class="config_lang">详细描述:</dt>
		<dd><?php echo $bookingproduct_info["BookingProduct"]["product_desc"]?></dd></dl>
  	    <dl><dt class="config_lang">联系人:</dt>
		<dd><?php echo $bookingproduct_info["BookingProduct"]["contact_man"]?></dd></dl>
  	    <dl><dt class="config_lang">电话通知:</dt>
		<dd><?php echo $bookingproduct_info["BookingProduct"]["telephone"]?></dd></dl>

	  </div>
	</div>
	<div class="order_stat athe_infos department_config">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  处理备注</h1></div>
	  <div class="box">
	  <br />
  	    <dl><dt class="config_lang"></dt>
		<dd><input type="text" class="text_inputs" style="width:320px;" name="dispose_note" /></dd></dl>
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Password-->
	<div class="order_stat athe_infos">
	  
	  <div class="box">
		<br />
		<dl><dt>处理用户：</dt>
			<dd><?php echo $bookingproduct_info["BookingProduct"]["dispose_operation_name"]?></dd></dl>		
		<dl><dt>处理时间：</dt>
			<dd><?php echo $bookingproduct_info["BookingProduct"]["dispose_time"]?></dd></dl>		
		<dl><dt>处理备注：</dt>
			<dd><?php echo $bookingproduct_info["BookingProduct"]["dispose_note"]?></dd></dl>		
	
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	  </div>
	</div>
<!--Password End-->

</td>
</tr>
<tr><td colspan="2"><p class="submit_btn"><input type="submit" value="我来处理" /><input type="reset" value="重置" /></p></td></tr>
</table>
<?php echo $form->end();?>

</div>
<!--Main Start End-->
<?php echo $html->image('content_left.gif',array('class'=>'content_left'))?><?php echo $html->image('content_right.gif',array('class'=>'content_right'))?>
</div>