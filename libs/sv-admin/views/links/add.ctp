<?php
/*****************************************************************************
 * SV-Cart  添加友情链接
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 943 2009-04-23 10:38:44Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."友情链接列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<!--Main Start-->
<?php echo $form->create('Link',array('action'=>'add','onsubmit'=>'return links_check();'));?>
	
	
<div class="home_main">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  添加友情链接</h1></div>
	  <div class="box">
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input name="data[LinkI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
<?
	}
}?>
  	    
  	    <h2>连接名称：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input type="text" style="width:280px;" id="name<?=$v['Language']['locale']?>" name="data[LinkI18n][<?=$k?>][name]" /> <font color="#ff0000">*</font></span></p>
<? }
} ?>
		
		
		<h2>连接地址：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name cat_info"><?=$html->image($v['Language']['img01'])?><span><input type="text" style="width:280px;" id="url<?=$v['Language']['locale']?>" name="data[LinkI18n][<?=$k?>][url]"  /> <font color="#ff0000">*</font></span></p>
<? }
} ?>
		<h2>连接LOGO：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name">
		<?=$html->image($v['Language']['img01'])?><span><input type="text" id="upload_img_text_<?=$k?>" size="35" name="data[LinkI18n][<?=$k?>][img01]"  /></span><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel($k,'links')",'',false,false)?>
<br /><span style="margin-left:32px;color:#646464;">请上传图片，做为链接的LOGO！</span>

<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
	<?=@$html->image('',array('id'=>'logo_thumb_img_'.$k,'height'=>'150'))?>


			</p>
<? }
} ?>


<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
<input type="hidden" size="35" name="data[LinkI18n][<?=$k?>][img02]"  /> 
<? }
} ?>
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Other Stat-->
	<div class="order_stat athe_infos tongxun">
	  
	  <div class="box">
		
		<dl><dt>联系人：</dt>
			<dd><input type="text" name="data[Link][contact_name]"  class="text_inputs" style="width:286px;"  /></dd></dl>
		
		<dl><dt>电话：</dt><dd class="time"><input type="text" name="data[Link][contact_tele]"  class="text" style="width:108px;" /></dd></dl>
		<dl><dt>Email地址：</dt><dd class="time"><input type="text" name="data[Link][contact_email]" class="text" style="width:108px;" /></dd></dl>
		<dl><dt>显示顺序：</dt><dd class="time"><input type="text" name="data[Link][orderby]" class="text" style="width:108px;" /><br />如果您不输入排序号，系统将默认为50</dd></dl>
		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px;">是否显示：</dt><dd class="best_input"><input type="radio" name="data[Link][status]" value="1" checked  />是<input type="radio" name="data[Link][status]" value="0"  />否</dd></dl>
	<br /><Br /><br /><br /><br /><br /><br /><br />
			
	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>

</table><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
</div>
	<? echo $form->end();?>
<!--Main Start End-->
</div>