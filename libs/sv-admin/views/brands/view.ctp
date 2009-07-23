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
 * $Id: view.ctp 3195 2009-07-22 07:15:51Z huangbo $
*****************************************************************************/
?> 
<?php //pr($this->data);?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."品牌列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('Brand',array('action'=>'view','onsubmit'=>'return brands_check();'));
	
?><input id="BrandId" name="data[Brand][id]" type="hidden" value="<?php echo  $this->data['Brand']['id'];?>">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array("class"=>"left"))?>
	  <?php echo $html->image('tab_right.gif',array("class"=>"right"))?>
	  编辑品牌</h1></div>
	  <div class="box">
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="BrandI18n<?php echo $k;?>Locale" name="data[BrandI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
	    <?php if(isset($this->data['BrandI18n'][$v['Language']['locale']])){?>
	<input id="BrandI18n<?php echo $k;?>BrandId" name="data[BrandI18n][<?php echo $k;?>][brand_id]" type="hidden" value="<?php echo  $this->data['Brand']['id'];?>">
	<input id="BrandI18n<?php echo $k;?>Id" name="data[BrandI18n][<?php echo $k;?>][id]" type="hidden" value="<?php echo  $this->data['BrandI18n'][$v['Language']['locale']]['id'];?>">
	<?php }?>
<?php 
	}
}?>

  	    <h2>品牌名称：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input id="brand_name_<?php echo $v['Language']['locale']?>" name="data[BrandI18n][<?php echo $k;?>][name]" type="text" maxlength="100"  <?php if(isset($this->data['BrandI18n'][$v['Language']['locale']])){?>value="<?php echo  $this->data['BrandI18n'][$v['Language']['locale']]['name'];?>"<?php }else{?>value=""<?php }?>  > <font color="#ff0000">*</font></span></p>
<?php 
	}
}?>
 
		<h2>品牌描述：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><textarea id="BrandI18n<?php echo $k;?>Description" name="data[BrandI18n][<?php echo $k;?>][description]" ><?php if(isset($this->data['BrandI18n'][$v['Language']['locale']])){?><?php echo  $this->data['BrandI18n'][$v['Language']['locale']]['description'];?><?php }else{?><?php }?></textarea></p>
<?php 
	}
}?>
	
	     <h2>meta关键字：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input id="BrandI18n<?php echo $k;?>MetaKeywords" name="data[BrandI18n][<?php echo $k;?>][meta_keywords]" type="text" style="width:215px;" <?php if(isset($this->data['BrandI18n'][$v['Language']['locale']])){?>value="<?php echo  $this->data['BrandI18n'][$v['Language']['locale']]['meta_keywords'];?>"<?php }else{?>value=""<?php }?>></span></p>
<?php 
	}
}?>
   	      <h2>meta品牌描述：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><textarea id="BrandI18n<?php echo $k;?>MetaDescription" name="data[BrandI18n][<?php echo $k;?>][meta_description]" ><?php if(@isset($this->data['BrandI18n'][$v['Language']['locale']])){?><?php echo  $this->data['BrandI18n'][$v['Language']['locale']]['meta_description'];?><?php }else{?><?php }?></textarea></span></p>
<?php 
	}
}?>
	
		<h2>品牌LOGO：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name">
			<?php echo $html->image($v['Language']['img01'])?><span><input id="upload_img_text_<?php echo $k?>" name="data[BrandI18n][<?php echo $k;?>][img01]" type="text" size="45"   value="<?php echo @$this->data['BrandI18n'][$v['Language']['locale']]['img01'];?>"></span> <?php echo $html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(".$k.",'brands')",'',false,false)?>
			<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo @$html->image("{$this->data['BrandI18n'][$v['Language']['locale']]['img01']}",array('id'=>'logo_thumb_img_'.$k,'height'=>'150','style'=>!empty($this->data['BrandI18n'][$v['Language']['locale']]['img01'])?"display:block":"display:none"))?>
			</p>

<?php 
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
			<dd><input type="text" id="BrandUrl" name="data[Brand][url]" value="<?php echo $this->data['Brand']['url'];?>" class="text_inputs" style="width:286px;" /></dd></dl>
		<dl><dt>品牌图片1：</dt>
			<dd><input type="text" id="upload_img_text_1001" name="data[Brand][img01]" value="<?php echo $this->data['Brand']['img01'];?>" class="text_inputs" style="width:286px;" /></dd><dd><?php echo $html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1001,'brands')",'',false,false)?></dd></dl>
		<dl><dt></dt>
		<dd><?php echo $html->image("/..{$this->data['Brand']['img01']}",array('id'=>'logo_thumb_img_1001','height'=>'150','style'=>!empty($this->data['Brand']['img01'])?"display:block":"display:none"))?>
		</dd></dl>
		<dl><dt>品牌图片2：</dt>
			<dd><input type="text" id="upload_img_text_1002" name="data[Brand][img02]" value="<?php echo $this->data['Brand']['img02'];?>" class="text_inputs" style="width:286px;" /></dd><dd><?php echo $html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1002,'brands')",'',false,false)?></dd></dl>

		<dl><dt></dt>
		<dd><?php echo $html->image("/..{$this->data['Brand']['img01']}",array('id'=>'logo_thumb_img_1002','height'=>'150','style'=>!empty($this->data['Brand']['img01'])?"display:block":"display:none"))?>
		</dd></dl>
		<dl><dt>排序：</dt><dd class="time"><input id="BrandOrderby" name="data[Brand][orderby]" type="text" class="text" style="width:108px;"   value="<?php echo $this->data['Brand']['orderby'];?>" onkeyup="check_input_num(this)" /><br />如果您不输入排序号，系统将默认为50</dd></dl>
		<dl style="padding:5px 0;*padding:6px 0;">
		<dt style="padding-top:1px;">是否显示：</dt>
		<dd class="best_input" style="width:70%;"><input id="BrandStatus" name="data[Brand][status]" type="radio" value="1" <?php if($this->data['Brand']['status']){?>checked<?php }?> >是<input id="BrandStatus" name="data[Brand][status]" type="radio" value="0" <?php if($this->data['Brand']['status']==0){?>checked<?php }?> >否
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
<?php echo $form->end();?>

</div>

<!--Main Start End-->
</div>