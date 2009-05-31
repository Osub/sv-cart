<?php
/*****************************************************************************
 * SV-Cart 编辑邮件模板
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."邮件模板列表","/mailtemplates/",'',false,false);?></strong></p>

<!--Main Start-->

<div class="home_main">
<?php echo $form->create('Mailtemplate',array('action'=>'/edit/'.$this->data['MailTemplate']['id'],'onsubmit'=>'return mailtemplates_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑邮件模板</h1></div>

<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="MailTemplateI18n<?=$k;?>Locale" name="data[MailTemplateI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
	   <?if(isset($this->data['MailTemplateI18n'][$v['Language']['locale']])){?>
	<input id="MailTemplateI18n<?=$k;?>Id" name="data[MailTemplateI18n][<?=$k;?>][id]" type="hidden" value="<?= $this->data['MailTemplateI18n'][$v['Language']['locale']]['id'];?>">
	   <?}?>
	   	<input id="MailTemplateI18n<?=$k;?>MailTemplateId" name="data[MailTemplateI18n][<?=$k;?>][mail_template_id]" type="hidden" value="<?= $this->data['MailTemplate']['id'];?>">
<?
	}
}?>
	
	
	  <div class="box">
	  <input type="hidden" name="data[MailTemplate][id]" value="<?=$this->data['MailTemplate']['id'];?>" />
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
	  	<dl><dt style="width:105px;">编号: </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[MailTemplate][code]" value="<?=$this->data['MailTemplate']['code'];?>" /></dd></dl>
		
		<h2>邮件主题：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input type="text" style="width:360px;" id="title<?=$v['Language']['locale']?>" name="data[MailTemplateI18n][<?=$k;?>][title]" value="<?=@$this->data['MailTemplateI18n'][$k]['title'];?>" /> <font color="#ff0000">*</font></span></p>
		
<?	}
   } ?>		
		<h2>纯文本邮件内容：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea style="width:590px;height:165px;" name="data[MailTemplateI18n][<?=$k;?>][text_body]" ><?=@$this->data['MailTemplateI18n'][$k]['text_body'];?></textarea></span></p>
<?	}
   } ?>		
		<h2>HTML邮件内容：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea style="width:590px;height:165px;" name="data[MailTemplateI18n][<?=$k;?>][html_body]"><?=@$this->data['MailTemplateI18n'][$k]['html_body'];?></textarea></span></p>
<?	}
   } ?>		
		
		
		<dl><dt style="width:105px;">是否显示：</dt>
			<dd><input id="BrandStatus" name="data[MailTemplate][status]" type="radio" value="1" <?if($this->data['MailTemplate']['status']){?>checked<?}?> >是<input id="BrandStatus" name="data[MailTemplate][status]" type="radio" value="0" <?if($this->data['MailTemplate']['status']==0){?>checked<?}?> >否</dd></dl>
		
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