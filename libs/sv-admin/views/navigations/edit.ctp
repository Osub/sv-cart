<?php
/*****************************************************************************
 * SV-Cart  编辑导航设置
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 1883 2009-05-31 11:20:54Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here',array('cache'=>'+0 hour','navigations'=>$navigations)); //pr($this->data);?>
<?php echo $form->create('Navigation',array('action'=>'edit/','onsubmit'=>'return navigations_check();'));?>
<div class="content">

<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."导航列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑导航</h1></div>
	  <div class="box" style="padding-left:10px;padding-right:10px;">

  	    <h2 style="width:80px;margin-bottom:5px;">导航名称：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name" style="padding-left:55px;margin-bottom:5px;"><?=$html->image($v['Language']['img01'])?><span><input type="text" style="width:270px;" id="name<?=$v['Language']['locale']?>" name="data[NavigationI18n][<?=$k;?>][name]" <?if(isset($this->data['NavigationI18n'][$v['Language']['locale']])){?>value="<?= $this->data['NavigationI18n'][$v['Language']['locale']]['name'];?>"<?}else{?>value=""<?}?>/> <font color="#ff0000">*</font></span></p>
		
<?}}?>
	  	    
	
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="NavigationI18n<?=$k;?>Locale" name="data[NavigationI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
	   <?if(isset($this->data['NavigationI18n'][$v['Language']['locale']])){?>
	<input id="NavigationI18n<?=$k;?>Id" name="data[NavigationI18n][<?=$k;?>][id]" type="hidden" value="<?= $this->data['NavigationI18n'][$v['Language']['locale']]['id'];?>">
	   <?}?>
	   	<input id="NavigationI18n<?=$k;?>NavigationId" name="data[NavigationI18n][<?=$k;?>][navigation_id]" type="hidden" value="<?= $this->data['Navigation']['id'];?>">
<?
	}
}?>
	
	
		<h2 style="width:80px;;margin-bottom:5px;">连接地址：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name" style="padding-left:55px;margin-bottom:5px;"><?=$html->image($v['Language']['img01'])?><span><input type="text" style="width:270px;" name="data[NavigationI18n][<?=$k;?>][url]" value="<?if(isset($this->data['NavigationI18n'][$v['Language']['locale']]))echo $this->data['NavigationI18n'][$v['Language']['locale']]['url'];?>" /></span></p>
<?}
	}?>	
		<h2 style="width:80px;margin-bottom:5px;">描述：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name" style="padding-left:55px;margin-bottom:5px;"><?=$html->image($v['Language']['img01'])?><span><textarea style="height:95px;width:340px;" name="data[NavigationI18n][<?=$k;?>][description]" ><?if(isset($this->data['NavigationI18n'][$v['Language']['locale']]))echo $this->data['NavigationI18n'][$v['Language']['locale']]['description'];?></textarea></span></p>
<?}
	}?>			
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<style type="text/css">
.tongxun dl{
	margin:3px 0;*margin:1px 0 0;
}
</style>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Other Stat-->
	<div class="order_stat athe_infos tongxun">
	  
	  <div class="box">
		
	  <br />


		
	  	<dl style="padding:3px 0;*padding:4px 0;"><dt style="padding-top:1px">系统内容：</dt><dd >
	<select name="data[Navigation][controller]">
	<option value="pages" <?php if($this->data['Navigation']['controller']=='pages') echo "selected";?> >首页</option>
	<option value="categories" <?php if($this->data['Navigation']['controller']=='categories') echo "selected";?>>分类</option>
	<option value="brands" <?php if($this->data['Navigation']['controller']=='brands') echo "selected";?>>品牌</option>
	<option value="products" <?php if($this->data['Navigation']['controller']=='products') echo "selected";?>>商品</option>
	<option value="articles" <?php if($this->data['Navigation']['controller']=='articles') echo "selected";?>>文章</option>
	<option value="cars" <?php if($this->data['Navigation']['controller']=='cars') echo "selected";?>>购物车</option>
	</select>
	</dd>
		

		</dl>

		
		<dl><dt style="padding:3px 0;*padding:4px 0;">位置：</dt><dd style="padding-top:1px"><select name="data[Navigation][type]"><option value="T" <?php if($this->data['Navigation']['type']=='T')echo "selected";?>>顶部</option><option value="H" <?php if($this->data['Navigation']['type']=='H')echo "selected";?>>帮助栏目</option><option value="B" <?php if($this->data['Navigation']['type']=='B')echo "selected";?>>底部</option><option value="M" <?php if($this->data['Navigation']['type']=='M')echo "selected";?>>中间</option></select></dd></dl>
		
		<dl><dt>显示顺序：</dt><dd><input type="text" class="text_inputs" style="width:112px;" name="data[Navigation][orderby]" value="<?php echo $this->data['Navigation']['orderby'];?>" /><br /> 如果您不输入排序号，系统将默认为50</dd></dl>
		
		
		
		<dl style="padding:3px 0;*padding:4px 0;">
		<dt style="padding-top:1px">是否有效：</dt>
		<dd class="best_input"><label><input type="radio" name="data[Navigation][status]" value="1" <?php if($this->data['Navigation']['status'])echo "checked";?>/>是</label><label><input type="radio" name="data[Navigation][status]" value="0" <?php if(!$this->data['Navigation']['status'])echo "checked";?>/>否</label></dd></dl>
		<dl style="padding:3px 0;*padding:4px 0;">
		<dt style="padding-top:1px">是否弹出新窗口：</dt>
		<dd class="best_input"><label><input type="radio" name="data[Navigation][target]" value="_blank" <?php if($this->data['Navigation']['target']=='_blank')echo "checked";?>/>是</label><label><input type="radio" name="data[Navigation][target]" value="_self" <?php if($this->data['Navigation']['target']=='_self')echo "checked";?>/>否</label></dd></dl>
		<dl><dt style="font-family:arial;">ico图片：</dt><dd><input type="text" class="text_inputs" style="width:112px;" name="data[Navigation][icon]" value="<?php echo $this->data['Navigation']['icon'];?>" id="upload_img_text_0" ><br /><br />

			<?=@$html->image("{$this->data['Navigation']['icon']}",array('id'=>'logo_thumb_img_0','height'=>'50','style'=>'display:none'))?>
			</dd><dd><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(0,'others')",'',false,false)?></dd></dl>
		<br /><br /><br /><br />
	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>

</table>




<p class="submit_btn" style="padding:1px 0;margin:0"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>


</div>
<!--Main Start End-->
</div>
<input id="NavigationId" name="data[Navigation][id]" type="hidden" value="<?= $this->data['Navigation']['id'];?>"/>
<?php $form->end();?>	