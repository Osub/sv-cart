<?php 
/*****************************************************************************
 * SV-Cart 新增实体店
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址：http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发：上海实玮$
 * $Id：add.ctp 2485 2009-06-30 11:33:00Z huangbo $
*****************************************************************************/
?> 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />

<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."实体店列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('Store',array('action'=>'add','onsubmit'=>'return stores_check();'));?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
	<td align="left" width="50%" valign="top" style="padding-right:5px">
		<div class="order_stat athe_infos tongxun">
		<div class="title">
		<h1><?php echo $html->image('tab_left.gif',array('class'=>'left'))?><?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
		  &nbsp;&nbsp;编辑实体店&nbsp;&nbsp;</h1>
		</div>
		<div class="box">
		<input type="hidden" name="data[Store][id]" />
		<?php if(isset($languages) && sizeof($languages)>0){
			foreach ($languages as $k => $v){?>
			<input id="BrandI18n<?php echo $k;?>Locale" name="data[StoreI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
		<?php 
			}
		}?>

		<h2>实体店名称：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?>
		<input type="text" style="width:195px;" class="border" id="name<?php echo $v['Language']['locale']?>" name="data[StoreI18n][<?php echo $k;?>][name]"  /> <font color="#F90071">*</font></p>
	
<?php 
}
}?>	  	<h2>联系电话：</h2>
	
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?>
		<input type="text" style="width:195px;" class="border" id="telephone<?php echo $v['Language']['locale']?>" name="data[StoreI18n][<?php echo $k;?>][telephone]" /> <font color="#F90071">*</font></p>
	
<?php 
}
}?>	  	<h2>邮编：</h2>
	
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?>
		<input type="text" style="width:195px;" class="border" id="zipcode<?php echo $v['Language']['locale']?>" name="data[StoreI18n][<?php echo $k;?>][zipcode]"  /> <font color="#F90071">*</font></p>
	
<?php 
}
}?>	  	<h2>超链接：</h2>
	
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?>
		<input type="text" style="width:195px;" class="border" id="url<?php echo $v['Language']['locale']?>" name="data[StoreI18n][<?php echo $k;?>][url]"  /> <font color="#F90071">*</font></p>
	
<?php 
}
}?>
		<h2>关键字：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?>
		<input type="text" style="width:195px;" class="border" name="data[StoreI18n][<?php echo $k;?>][meta_keywords]"  /></p>
		
<?php }
} ?>
	<h2>描述：</h2>
<?php //pr($languages);?>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?>
		<textarea style="height:90px;width:315px;" class="border" name="data[StoreI18n][<?php echo $k;?>][description]"></textarea></p>
<?php }
} ?>
	<h2>SEO关键字：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?>
		<input type="text" style="width:315px;" class="border" name="data[StoreI18n][<?php echo $k;?>][meta_keywords]" /></p
		
<?php }
} ?>
	<h2>SEO描述：</h2>
<?php //pr($languages);?>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?>
		<textarea style="height:90px;width:315px;" class="border" name="data[StoreI18n][<?php echo $k;?>][meta_description]"></textarea></p>
<?php }
} ?>
<h2>邮件地址：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?>
		<input type="text" style="width:315px;" class="border" name="data[StoreI18n][<?php echo $k;?>][address]"  /></p>
<?php }
} ?>
<h2>地图：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?>
		<input type="text" style="width:297px;" class="border" name="data[StoreI18n][<?php echo $k;?>][map]" id="upload_img_text_<?php echo $k?>" /><?php echo @$html->image("",array('id'=>'logo_thumb_img_'.$k,'height'=>'150','style'=>'display:none'))?><?php echo $html->link($html->image('select_img.gif',array("class"=>"vmiddle icons","height"=>"20",$title_arr['select_img'])),"javascript:img_sel($k,'others')",'',false,false)?>
	
	</p>
<?php }
} ?>	
<h2>交通：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?>
		<input type="text" style="width:297px;" class="border" id="upload_img_text_1<?php echo $k?>"name="data[StoreI18n][<?php echo $k;?>][transport]" /><?php echo @$html->image("",array('id'=>'logo_thumb_img_1'.$k,'height'=>'150','style'=>'display:none'))?><?php echo $html->link($html->image('select_img.gif',array("class"=>"vmiddle icons","height"=>"20",$title_arr['select_img'])),"javascript:img_sel(1".$k.",'others')",'',false,false)?></p>
<?php }
} ?>	
		</div>
		</div>
	</td>

	<td align="left" width="50%" valign="top" style="padding-top:26px">
	<div class="order_stat athe_infos tongxun">
	<div class="box">
<!--Menus_Config-->
		<dl><dt>联系人：</dt>
		<dd><input type="text" style="width:195px;" class="border" name="data[Store][contact_name]"  /></dd></dl>
		<dl><dt>E-mail：</dt>
		<dd><input type="text" style="width:195px;" class="border" name="data[Store][contact_email]"  /></dd></dl>
		<dl><dt>联系电话：</dt>
		<dd><input type="text" style="width:195px;" class="border"  name="data[Store][contact_tele]"  /></dd></dl>
		<dl><dt>手机：</dt>
		<dd><input type="text" style="width:195px;" class="border" name="data[Store][contact_mobile]" /></dd></dl>
		<dl><dt>传真：</dt>
		<dd><input type="text" style="width:195px;" class="border" name="data[Store][contact_fax]" /></dd></dl>
		
		
		<dl><dt>备注：</dt>
		<dd><textarea style="height:55px;width:315px;" class="border" name="data[Store][remark]" ></textarea></dd></dl>
		<dl><dt>排序：</dt>
		<dd>
			<input type="text" style="width:113px;" class="border" name="data[Store][orderby]" onkeyup="check_input_num(this)" />
			<p class="msg">如果您不输入排序号，系统将默认为50</p>
		</dd></dl>
		<dl><dt>是否有效：</dt>
		<dd style="padding-top:3px;">
			<input type="radio" class="radio" value="1" name="data[Store][status]" checked/>是
			<input type="radio" class="radio" name="data[Store][status]" value="0" />否</dd></dl>

		<br /><br /><br />
		
		<br /><br />
<!--Menus_Config End-->
	  </div>
	</div>
	</td>
</tr>
</table>
<!--ConfigValues-->

<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
<?php echo $form->end();?>
<!--ConfigValues End-->
</div>
	

<!--Main End-->
</div>