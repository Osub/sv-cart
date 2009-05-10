<?php
/*****************************************************************************
 * SV-Cart 添加专题
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
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."专题列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<!--Main Start-->
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Main Start-->

<br />

<?php echo $form->create('Topic',array('action'=>'/add/' ,'onsubmit'=>'return topics_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑专题</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
		
		<h2>专题名称：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input type="text" style="width:360px;" id="topic_title_<?=$v['Language']['locale']?>" name="data[TopicI18n][<?=$k;?>][title]"  /> <font color="#ff0000">*</font></span></p>
		
<?	}
   } ?>		
<? if(isset($languages) && sizeof($languages)>0){
   	foreach ($languages as $k => $v){?>
	<input name="data[TopicI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
<?
	}
}?>
   <dl><dt style="width:105px;">活动周期: </dt>
		<span class="search_box"  style="background:none;padding:0;border:0;width:1px;" >
			<dd><input type="text" name="data[Topic][start_time]" class="text_inputs" style="width:120px;"  id="date" readonly="readonly"   /><button type="button" id="show"><?=$html->image('calendar.gif')?></button>－<input type="text" name="data[Topic][end_time]" class="text_inputs" style="width:120px;"  id="date2" readonly="readonly" /><button type="button" id="show2"><?=$html->image('calendar.gif')?></button></dd></span></dl>
		
		
		<dl><dt style="width:105px;"><?=$html->image('help_icon.gif')?>专题模板文件: </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name=""  /><br/>填写当前专题的模板文件名,模板文件应上传到当前商城模板目录下,不填写将调用默认模板。</dd></dl>
			
			
			
		<dl><dt style="width:105px;"><?=$html->image('help_icon.gif')?>专题样式列表: </dt>
		<dd><textarea style="width:360px;height:135px;" name="data[Topic][css]"></textarea><br/>填写当前专题的CSS样式代码，不填写将调用模板默认CSS文件<br />[+][-]</dd></dl>
		
		
		<br />
		
		</div>
<!--Mailtemplates_Config End-->
		
		
		
	  </div>
	  <p class="submit_values"><input type="submit" value="确 定" /><input type="reset" value="重 置" /></p>
	</div>




<!--Main End-->
</td>
</tr>

</table>

<!--Product Relative-->

<!--Product Relative End-->
<!--profile-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  专题介绍</h1></div>
	  <div class="box">
<?//pr($javascript);?>
<?php echo $javascript->link('fckeditor/fckeditor'); ?>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	  <?=$html->image($v['Language']['img01'])?><br />
<p class="profiles">
    <?  if(isset($topic['TopicI18n'][$k]['intro'])){?>
       <?php echo $form->textarea('TopicI18n/intro', array("cols" => "60","rows" => "20","value" => "","name"=>"data[TopicI18n][{$k}][intro]","id"=>"TopicI18n{$k}Intro"));?>
        <? echo $fck->load("TopicI18n{$k}/intro"); ?>
        
    <?}else{?>
       <?php echo $form->textarea('TopicI18n/intro', array('cols' => '60', 'rows' => '20','value'=>"","name"=>"data[TopicI18n][{$k}][intro]","id"=>"TopicI18n{$k}Intro"));?> 
       <?php  echo $fck->load("TopicI18n{$k}/intro"); ?>
       
    <?}?>
		</p>
		<br /><br />
<?
	}
}?>




		<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
		
<? echo $form->end();?>
	  </div>
	</div>
<!--profile End-->






</div>
<!--Main Start End-->
</div><!--时间控件层start-->
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