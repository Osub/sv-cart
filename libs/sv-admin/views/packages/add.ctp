<?php
/*****************************************************************************
 * SV-Cart 添加红包
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
<?php  echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<br />
	
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."包装列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>
<div class="home_main">
<?php echo $form->create('Packages',array('action'=>'add','onsubmit'=>'return packages_check();'));?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos department_config">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  添加包装</h1></div>
	  <div class="box">
	  <br />
  	    <dl><dt class="config_lang">包装名称:</dt>
			<dd></dd></dl>

<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		 <dl><dt class="config_lang"><?=$html->image($v['Language']['img01'])?></dt>
			<dd><input type="text" id="Packaging_name_<?=$v['Language']['locale']?>"  name="data[PackagingI18n][<?=$k?>][name]" class="text_inputs" style="width:195px;" /> <font color="#ff0000">*</font></dd></dl>
<?
	}
}?>	
	
		<dl><dt class="config_lang">包装描述:</dt><dd></dd></dl>

<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
				
			<dl><dt class="config_lang"><?=$html->image($v['Language']['img01'])?></dt><dd><textarea name="data[PackagingI18n][<?=$k?>][description]"></textarea></dd></dl>
				
			<input type="hidden" name="data[PackagingI18n][<?=$k?>][locale]" value="<?=$v['Language']['locale']?>" />
<?
	}
}?>	
		
		
		
	
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Password-->
	<div class="order_stat athe_infos">
	  
	  <div class="box">
		<br />
		  <dl><dt>上传图片1：</dt>
			<dd><input type="text"   name="data[Packaging][img01]" id="upload_img_text_1" class="text_inputs" style="width:195px;" /><br /><br />
			
			<?=@$html->image("",array('id'=>'logo_thumb_img_1','height'=>'150','style'=>'display:none'))?>
			</dd><dd><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1,'packs')",'',false,false)?></dd></dl>
		  <dl><dt>上传图片2：</dt>
			<dd><input type="text"   name="data[Packaging][img02]" id="upload_img_text_2" class="text_inputs" style="width:195px;" /><br /><br />
			
			<?=@$html->image("",array('id'=>'logo_thumb_img_2','height'=>'150','style'=>'display:none'))?>
			</dd><dd><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(2,'packs')",'',false,false)?></dd></dl>
		<dl><dt>费用：</dt>
			<dd><input type="text" name="data[Packaging][fee]" class="text_inputs" style="width:115px;" /></dd></dl>
			<dl><dt>免费额度：</dt>
			<dd><input type="text" name="data[Packaging][free_money]" class="text_inputs" style="width:115px;" /></dd></dl>
		<dl><dt>排序：</dt>
			<dd><input type="text" name="data[Packaging][orderby]" class="text_inputs" style="width:115px;" onkeyup="check_input_num(this)" /> <font color="#646464"><br />如果您不输入排序号，系统将默认为50</font></dd></dl>
		<dl><dt>是否有效：</dt>
			<dd><input type="radio" name="data[Packaging][status]" value="1" checked /> 是 <input type="radio" name="data[Packaging][status]" value="0" /> 否</dd></dl>
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
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
