<?php
/*****************************************************************************
 * SV-Cart 添加邮件模板
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 1093 2009-04-28 04:02:04Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."邮件模板列表","/mailtemplates/",'',false,false);?></strong></p>
<!--Main Start-->

<div class="home_main">
<?php echo $form->create('Mailtemplate',array('action'=>'/add/','onsubmit'=>'return mailtemplates_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑邮件模板</h1></div>
	  <div class="box">
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input name="data[MailTemplateI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
<?
}	}
?>
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">

		
		<h2>邮件主题：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input type="text" style="width:360px;" id="title<?=$v['Language']['locale']?>" name="data[MailTemplateI18n][<?=$k;?>][title]" value="" /> <font color="#ff0000">*</font></span></p>
		
<?	}
   } ?>		
		<h2>纯文本邮件内容：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea style="width:590px;height:165px;" name="data[MailTemplateI18n][<?=$k;?>][text_body]" ></textarea></span></p>
<?	}
   } ?>		
		<h2>HTML邮件内容：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea style="width:590px;height:165px;" name="data[MailTemplateI18n][<?=$k;?>][html_body]"></textarea></span></p>
<?	}
   } ?>		
		
		
		<dl><dt style="width:105px;">是否显示：</dt>
			<dd><input id="BrandStatus" name="data[MailTemplate][status]" type="radio" value="1" checked >是<input id="BrandStatus" name="data[MailTemplate][status]" type="radio" value="0"  >否</dd></dl>
		
		<br />
		
		</div>
<!--Mailtemplates_Config End-->
		
		
		
	  </div>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
<? echo $form->end();?>


</div>
<!--Main End-->
</div>