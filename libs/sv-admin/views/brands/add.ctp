<?php
/*****************************************************************************
 * SV-Cart 新增品牌
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
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."品牌列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('Brand',array('action'=>'add','onsubmit'=>'return brands_check();'));
	
?><input id="BrandId" name="data[Brand][id]" type="hidden" value="<?= $this->data['Brand']['id'];?>">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array("class"=>"left"))?>
	  <?=$html->image('tab_right.gif',array("class"=>"right"))?>
	  编辑品牌</h1></div>
	  <div class="box">
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="BrandI18n<?=$k;?>Locale" name="data[BrandI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
<?
	}
}?>
  	    <h2>品牌名称：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="brand_name_<?=$v['Language']['locale']?>" name="data[BrandI18n][<?=$k;?>][name]" type="text" maxlength="100" value=""> <font color="#ff0000">*</font></span></p>
<?
	}
}?>
   
		<h2>品牌描述：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea id="BrandI18n<?=$k;?>Description" name="data[BrandI18n][<?=$k;?>][description]" ></textarea> <font color="#ff0000">*</font></span></p>
<?
	}
}?>
  	   <h2>meta关键字：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="BrandI18n<?=$k;?>MetaKeywords" name="data[BrandI18n][<?=$k;?>][meta_keywords]" type="text" style="width:215px;" value=""> <font color="#ff0000">*</font></span></p>
<?
	}
}?>
	    <h2>meta品牌描述：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea id="BrandI18n<?=$k;?>MetaDescription" name="data[BrandI18n][<?=$k;?>][meta_description]" ></textarea> <font color="#ff0000">*</font></span></p>
<?
	}
}?>

		<h2>品牌LOGO：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input  name="data[BrandI18n][<?=$k;?>][img02]" id="upload_img_text_<?=$k?>" type="text" size="50"  /></span> <?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(".$k.",'brands')",'',false,false)?> 
<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?=@$html->image('',array('id'=>'logo_thumb_img_'.$k,'height'=>'150'))?>
			
			</p>
<?
	}
}?>
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Other Stat-->
	<div class="order_stat athe_infos tongxun">
	  
	  <div class="box">
		
		<dl><dt>品牌网址：</dt>
			<dd><input type="text" id="BrandUrl" name="data[Brand][url]" class="text_inputs" style="width:286px;" /></dd></dl>
		<dl><dt>品牌图片：</dt>
			<dd><input type="text" id="upload_img_text_1001" name="data[Brand][img01]" value=" " class="text_inputs" style="width:286px;" /></dd><dd><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1001,'brands')",'',false,false)?></dd></dl>
		<dl><dt></dt>
		<dd><?=@$html->image('',array('id'=>'logo_thumb_img_1001','height'=>'150'))?>

		</dd></dl>
		<dl><dt>排序：</dt><dd class="time"><input id="BrandOrderby" name="data[Brand][orderby]" type="text" class="text" style="width:108px;" onkeyup="check_input_num(this)" /><br />如果您不输入排序号，系统将默认为50</dd></dl>
		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px;">是否显示：</dt><dd class="best_input"><input id="BrandStatus" name="data[Brand][status]" type="radio" value="1" checked>是<input id="BrandStatus" name="data[Brand][status]" type="radio" value="0">否<br />
		<span style="margin-left:4px;*margin-left:6px;">(当品牌下还没有商品的时候，首页及分类页的品牌区将不会显示该品牌。)</span></dd></dl>

	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>

</table>
<br />
<p class="submit_values"><input type="submit" value="确 定" /><input type="submit" value="重 置" /></p>
<br />
<? echo $form->end();?>
</div>
<!--Main Start End-->
</div>