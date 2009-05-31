<?php
/*****************************************************************************
 * SV-Cart 添加广告
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 1883 2009-05-31 11:20:54Z huangbo $
*****************************************************************************/
?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!-- Main Start-->
<br />
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."广告列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('advertisement',array('action'=>'add/','onsubmit'=>'return advertisements_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑广告</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
		<dl><dt style="width:105px;">选择语言： </dt>
		<dd>
	
		<select name="data[AdvertisementI18n][locale]">	
	<? if(isset($languages) && sizeof($languages)){
	foreach ($languages as $k => $v){?>
<option value="<?=$v['Language']['locale']?>"><?=$v['Language']['locale']?></option>
<?}}?>	
		</select>
		</dd></dl>
	  	<dl><dt style="width:105px;">广告名称： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="advertisement_name" name="data[AdvertisementI18n][name]" value="<? if( isset($titles)){ echo $titles;} ?>" /> <font color="#ff0000">*</font></dd></dl>
		
		<dl><dt style="width:105px;">宽度： </dt>
		<dd><input type="text" style="width:180px;*width:180px;border:1px solid #649776" name="data[Advertisement][ad_width]"  /></dd></dl>
		<dl><dt style="width:105px;">高度： </dt>
		<dd><input type="text" style="width:180px;*width:180px;border:1px solid #649776" name="data[Advertisement][ad_height]"  /></dd></dl>
		
		<dl><dt style="width:105px;">描述： </dt>
		<dd></dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[AdvertisementI18n][description]"  /></dl>
		<dl><dt style="width:105px;">广告代码： </dt>
		<dd></dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[AdvertisementI18n][code]"  /></dl>
		
		
		<dl><dt style="width:105px;">开始时间：</dt><span class="search_box" style="background:none;padding:0;border:0" >
			<dd><input type="text"  name="data[AdvertisementI18n][start_time]" class="text_inputs" style="width:180px;"  id="date" readonly="readonly"/><button type="button" id="show"><?=$html->image('calendar.gif')?></button></dd></span></dl>
		<dl><dt style="width:105px;">结束时间：</dt><span class="search_box" style="background:none;padding:0;border:0" >
			<dd><input type="text"  name="data[AdvertisementI18n][end_time]" class="text_inputs" style="width:180px;" id="date2" readonly="readonly" /><button type="button" id="show2" ><?=$html->image('calendar.gif')?></button></dd></span></dl>
		<dl><dt style="width:105px;">连接地址： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[AdvertisementI18n][url]" value="<? if( isset($topics_url)){ echo $topics_url;} ?>"  /></dd></dl>	
		<dl><dt style="width:105px;">上传图片： </dt>
		<dd><input type="text" size='28' name="data[AdvertisementI18n][img01]" id="upload_img_text_0" /></dd><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(0,'others')",'',false,false)?></dl>
		<dl><dt style="width:105px;"></dt>
		<dd><?=@$html->image('',array('id'=>'logo_thumb_img_0','height'=>'150','style'=>'display:none'))?>
		</dd></dl>
		<dl><dt style="width:105px;">上传图片： </dt>
		<dd><input type="text" size='28' name="data[AdvertisementI18n][img02]" id="upload_img_text_1" /></dd><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1,'others')",'',false,false)?></dl>
		<dl><dt style="width:105px;"></dt>
		<dd><?=@$html->image('',array('id'=>'logo_thumb_img_1','height'=>'150','style'=>'display:none'))?>
		</dd></dl>
		<dl><dt style="width:105px;">是否显示图片： </dt>
		<dd><input type="radio" value="1" name="data[Advertisement][is_showimg]" checked />是<input type="radio" value="0" name="data[Advertisement][is_showimg]" />否</dd></dl>
		<dl><dt style="width:105px;">联系人： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[Advertisement][contact_name]"  /></dd></dl>	
		<dl><dt style="width:105px;">电话： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[Advertisement][contact_tele]"  /></dd></dl>	
		<dl><dt style="width:105px;">E-mail地址： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[Advertisement][contact_email]"  /></dd></dl>	
		<dl><dt style="width:105px;">是否有效： </dt>
		<dd><input type="radio" value="1"  name="data[Advertisement][status]" checked  />是<input type="radio" value="0"  name="data[Advertisement][status]"  />否</dd></dl>
		<br />
		
		</div>
<!--Mailtemplates_Config End-->
		
		
		
	  </div>
	  <p class="submit_values"><input type="submit" value="确 定" /><input type="reset" value="重 置" /></p>
	</div>
<? echo $form->end();?>


</div>
<!--Main End-->
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