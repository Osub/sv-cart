<?php
/*****************************************************************************
 * SV-Cart 品牌编辑
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 943 2009-04-23 10:38:44Z huangbo $
*****************************************************************************/
?> 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."品牌列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('Brand',array('action'=>'view','onsubmit'=>'return brands_check();'));
	
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
	    <?if(isset($this->data['BrandI18n'][$v['Language']['locale']])){?>
	<input id="BrandI18n<?=$k;?>BrandId" name="data[BrandI18n][<?=$k;?>][brand_id]" type="hidden" value="<?= $this->data['Brand']['id'];?>">
	<input id="BrandI18n<?=$k;?>Id" name="data[BrandI18n][<?=$k;?>][id]" type="hidden" value="<?= $this->data['BrandI18n'][$v['Language']['locale']]['id'];?>">
	<?}?>
<?
	}
}?>

  	    <h2>品牌名称：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="brand_name_<?=$v['Language']['locale']?>" name="data[BrandI18n][<?=$k;?>][name]" type="text" maxlength="100"  <?if(isset($this->data['BrandI18n'][$v['Language']['locale']])){?>value="<?= $this->data['BrandI18n'][$v['Language']['locale']]['name'];?>"<?}else{?>value=""<?}?>  > <font color="#ff0000">*</font></span></p>
<?
	}
}?>
 
		<h2>品牌描述：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea id="BrandI18n<?=$k;?>Description" name="data[BrandI18n][<?=$k;?>][description]" ><?if(isset($this->data['BrandI18n'][$v['Language']['locale']])){?><?= $this->data['BrandI18n'][$v['Language']['locale']]['description'];?><?}else{?><?}?></textarea></p>
<?
	}
}?>
	
	     <h2>meta关键字：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="BrandI18n<?=$k;?>MetaKeywords" name="data[BrandI18n][<?=$k;?>][meta_keywords]" type="text" style="width:215px;" <?if(isset($this->data['BrandI18n'][$v['Language']['locale']])){?>value="<?= $this->data['BrandI18n'][$v['Language']['locale']]['meta_keywords'];?>"<?}else{?>value=""<?}?>></span></p>
<?
	}
}?>
   	      <h2>meta品牌描述：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea id="BrandI18n<?=$k;?>MetaDescription" name="data[BrandI18n][<?=$k;?>][meta_description]" ><?if(@isset($this->data['BrandI18n'][$v['Language']['locale']])){?><?= $this->data['BrandI18n'][$v['Language']['locale']]['meta_description'];?><?}else{?><?}?></textarea></span></p>
<?
	}
}?>
	
		<h2>品牌LOGO：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name">
			<?=$html->image($v['Language']['img01'])?><span><input id="upload_img_text_<?=$k?>" name="data[BrandI18n][<?=$k;?>][img01]" type="text" size="45"   value="<?=@$this->data['BrandI18n'][$v['Language']['locale']]['img01'];?>"></span> <?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(".$k.",'brands')",'',false,false)?>
			<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?=@$html->image("{$this->data['BrandI18n'][$v['Language']['locale']]['img01']}",array('id'=>'logo_thumb_img_'.$k,'height'=>'150'))?>
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
			<dd><input type="text" id="BrandUrl" name="data[Brand][url]" value="<?=$this->data['Brand']['url'];?>" class="text_inputs" style="width:286px;" /></dd></dl>
		<dl><dt>品牌图片：</dt>
			<dd><input type="text" id="upload_img_text_1001" name="data[Brand][img01]" value="<?=$this->data['Brand']['img01'];?>" class="text_inputs" style="width:286px;" /></dd><dd><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1001,'brands')",'',false,false)?></dd></dl>
		<dl><dt></dt>
		<dd><?=$html->image("/..{$this->data['Brand']['img01']}",array('id'=>'logo_thumb_img_1001','height'=>'150'))?>
		</dd></dl>
		<dl><dt>排序：</dt><dd class="time"><input id="BrandOrderby" name="data[Brand][orderby]" type="text" class="text" style="width:108px;"   value="<?=$this->data['Brand']['orderby'];?>" onkeyup="check_input_num(this)" /><br />如果您不输入排序号，系统将默认为50</dd></dl>
		<dl style="padding:5px 0;*padding:6px 0;">
		<dt style="padding-top:1px;">是否显示：</dt>
		<dd class="best_input" style="width:70%;"><input id="BrandStatus" name="data[Brand][status]" type="radio" value="1" <?if($this->data['Brand']['status']){?>checked<?}?> >是<input id="BrandStatus" name="data[Brand][status]" type="radio" value="0" <?if($this->data['Brand']['status']==0){?>checked<?}?> >否
		<p style="margin-left:4px;*margin-left:6px;">(当品牌下还没有商品的时候，首页及分类页的品牌区将不会显示该品牌。)</p></dd></dl>

	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>

</table>
<br />
<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
<br />
<? echo $form->end();?>

</div>

<!--Main Start End-->
</div>