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
 * $Id: add.ctp 4372 2009-09-18 10:38:17Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."友情链接列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>

<!--Main Start-->
<?php echo $form->create('Link',array('action'=>'add','onsubmit'=>'return links_check();'));?>
<div class="home_main">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos configvalues">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  添加友情链接</h1></div>
	  <div class="box">
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<input name="data[LinkI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
		<?php }}?>
  	    <dl><dt>连接名称: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input type="text" style="width:280px;border:1px solid #649776" id="name<?php echo $v['Language']['locale']?>" name="data[LinkI18n][<?php echo $k?>][name]" /> <font color="#ff0000">*</font></dd></dl>
		<?php }} ?>
  	    <dl><dt>友情链接描述: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input type="text" style="width:280px;border:1px solid #649776" id="name<?php echo $v['Language']['locale']?>" name="data[LinkI18n][<?php echo $k?>][description]"  /> <font color="#ff0000">*</font></dd></dl>
		<?php }} ?>
				
		<dl><dt>连接地址: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input type="text" style="width:280px;border:1px solid #649776" id="url<?php echo $v['Language']['locale']?>" name="data[LinkI18n][<?php echo $k?>][url]"  /> <font color="#ff0000">*</font></span></dd></dl>
		<?php }} ?>

		<dl><dt>连接LOGO: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input type="text"  style="width:280px;border:1px solid #649776" name="data[LinkI18n][<?php echo $k?>][img01]" id="upload_img_text_<?php echo $k?>" value="<?php echo @$link['LinkI18n'][$k]['img01']?>" />
			<?php echo @$html->link($html->image('select_img.gif',array("height"=>"20","class"=>"vmiddle icons","title"=>$title_arr['select_img'])),"javascript:img_sel($k,'links')",'',false,false)?>
			<?php echo @$html->image("",array('id'=>'logo_thumb_img_'.$k,'style'=>"display:none"))?>
			</dd></dl>
			<style>
			<!--
			#logo_thumb_img_<?php echo $k?>{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;width:200px;height:100px;}
			-->
			</style>
		<?php }}?>

		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<input type="hidden" size="35" name="data[LinkI18n][<?php echo $k?>][img02]"  /> 
		<?php }} ?>
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Other Stat-->
	<div class="order_stat athe_infos configvalues">
	  <div class="box">
		<dl><dt>联系人：</dt><dd><input type="text" name="data[Link][contact_name]"  class="text_inputs" style="width:286px;"  /></dd></dl>
		<dl><dt>电话：</dt><dd class="time"><input type="text" name="data[Link][contact_tele]"  class="text" style="width:108px;" /></dd></dl>
		<dl><dt>Email地址：</dt><dd class="time"><input type="text" name="data[Link][contact_email]" class="text" style="width:108px;" /></dd></dl>
		<dl><dt>显示顺序：</dt><dd class="time"><input type="text" name="data[Link][orderby]" class="text" style="width:108px;" /><p class="msg">如果您不输入排序号，系统将默认为50</p></dd></dl>
		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px;">是否显示：</dt><dd class="best_input"><input type="radio" name="data[Link][status]" value="1" checked  />是<input type="radio" name="data[Link][status]" value="0"  />否</dd></dl>
	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>

</table><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
</div>
	<?php echo $form->end();?>
<!--Main Start End-->
</div>