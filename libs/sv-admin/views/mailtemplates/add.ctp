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
 * $Id: add.ctp 2485 2009-06-30 11:33:00Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."邮件模板列表","/mailtemplates/",'',false,false);?></strong></p>
<!--Main Start-->

<div class="home_main">
<?php echo $form->create('Mailtemplate',array('action'=>'/add/','onsubmit'=>'return mailtemplates_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑邮件模板</h1></div>
	  <div class="box">
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input name="data[MailTemplateI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
<?php 
}	}
?>
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
	<dl><dt style="width:105px;">编号: </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[MailTemplate][code]"  /></dd></dl>
	
		<h2>邮件主题：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input type="text" style="width:360px;" id="title<?php echo $v['Language']['locale']?>" name="data[MailTemplateI18n][<?php echo $k;?>][title]" value="" /> <font color="#ff0000">*</font></span></p>
		
<?php 	}
   } ?>		
		<h2>纯文本邮件内容：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><textarea style="width:590px;height:165px;" name="data[MailTemplateI18n][<?php echo $k;?>][text_body]" ></textarea></span></p>
<?php 	}
   } ?>		
		<h2>HTML邮件内容：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><textarea style="width:590px;height:165px;" name="data[MailTemplateI18n][<?php echo $k;?>][html_body]"></textarea></span></p>
<?php 	}
   } ?>		
		
		
		<dl><dt style="width:105px;">是否显示：</dt>
			<dd><input id="BrandStatus" name="data[MailTemplate][status]" type="radio" value="1" checked >是<input id="BrandStatus" name="data[MailTemplate][status]" type="radio" value="0"  >否</dd></dl>
		
		<br />
		
		</div>
<!--Mailtemplates_Config End-->
		
		
		
	  </div>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
<?php echo $form->end();?>


</div>
<!--Main End-->
</div>