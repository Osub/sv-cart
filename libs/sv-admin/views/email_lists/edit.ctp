<?php 
/*****************************************************************************
 * SV-Cart 编辑杂志模板
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 3734 2009-08-19 03:17:38Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."杂志列表","/email_lists/",'',false,false);?></strong></p>

<!--Main Start-->

<div class="home_main">
<?php echo $form->create('email_lists',array('action'=>'/edit/'.$this->data['MailTemplate']['id'],'onsubmit'=>'return mailtemplates_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑杂志模板</h1></div>

<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="MailTemplateI18n<?php echo $k;?>Locale" name="data[MailTemplateI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
	   <?php if(isset($this->data['MailTemplateI18n'][$v['Language']['locale']])){?>
	<input id="MailTemplateI18n<?php echo $k;?>Id" name="data[MailTemplateI18n][<?php echo $k;?>][id]" type="hidden" value="<?php echo  $this->data['MailTemplateI18n'][$v['Language']['locale']]['id'];?>">
	   <?php }?>
	   	<input id="MailTemplateI18n<?php echo $k;?>MailTemplateId" name="data[MailTemplateI18n][<?php echo $k;?>][mail_template_id]" type="hidden" value="<?php echo  $this->data['MailTemplate']['id'];?>">
<?php 
	}
}?>
	
	
	  <div class="box">
	  <input type="hidden" name="data[MailTemplate][id]" value="<?php echo $this->data['MailTemplate']['id'];?>" />
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
	  	<dl><dt style="width:105px;">编号: </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[MailTemplate][code]" value="<?php echo $this->data['MailTemplate']['code'];?>" /></dd></dl>
		
		<dl><dt style="width:105px;">杂志主题: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt style="width:105px;"><?php echo $html->image($v['Language']['img01'])?></dt><dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="title<?php echo $v['Language']['locale']?>" name="data[MailTemplateI18n][<?php echo $k;?>][title]" value="<?php echo @$this->data['MailTemplateI18n'][$k]['title'];?>" /> <font color="#ff0000">*</font></dd></dl>
		<?php }}?>		
		<dl><dt style="width:105px;">杂志说明: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt style="width:105px;"><?php echo $html->image($v['Language']['img01'])?></dt><dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="title<?php echo $v['Language']['locale']?>" name="data[MailTemplateI18n][<?php echo $k;?>][description]" value="<?php echo @$this->data['MailTemplateI18n'][$k]['description'];?>" /></dd></dl>
		<?php }} ?>		
		<dl><dt style="width:105px;">是否显示：</dt>
			<dd><input id="BrandStatus" name="data[MailTemplate][status]" type="radio" value="1" <?php if($this->data['MailTemplate']['status']){?>checked<?php }?> >是<input id="BrandStatus" name="data[MailTemplate][status]" type="radio" value="0" <?php if($this->data['MailTemplate']['status']==0){?>checked<?php }?> >否</dd></dl>
		</div>
<!--Mailtemplates_Config End-->
		
		
		
	  </div><br />
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  纯文本杂志内容</h1></div>
	  <div class="box">
	  	  <?php if($SVConfigs["select_editor"]=="2"||empty($SVConfigs["select_editor"])){?>
	  	<?php echo $javascript->link('tinymce/tiny_mce/tiny_mce'); ?>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<table><tr><td valign="top">
	  	<?php echo $html->image($v['Language']['img01'])?></td><td valign="top">
		<textarea id="11elm<?php echo $v['Language']['locale'];?>" name="data[MailTemplateI18n][<?php echo $k;?>][text_body]" rows="15" cols="80" style="width: 80%"><?php echo $this->data['MailTemplateI18n'][$k]['text_body'];?></textarea>
		<?php  echo $tinymce->load("11elm".$v['Language']['locale'],$now_locale); ?><br /></td></tr>
		</table>
    	<?php }?></p>
		<?php }?><?php }?>
		<?php if($SVConfigs["select_editor"]=="1"){?>
			<?php echo $javascript->link('fckeditor/fckeditor'); ?>
		  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		  	<?php echo $html->image($v['Language']['img01'])?><br />
			<p class="profiles">
			<?php  if(isset($article['BrandI18n'][$k]['description'])){?>
	        <?php echo $form->textarea('ArticleI18n/content', array("cols" => "60","rows" => "20",'value'=>"{$this->data['MailTemplateI18n'][$k]['text_body']}","name"=>"data[MailTemplateI18n][{$k}][text_body]","id"=>"ArticleI18n{$k}Content"));?>
	        <?php echo $fck->load("ArticleI18n{$k}/content"); ?>
	        
	    	<?php }else{?>
	       	<?php echo $form->textarea('ArticleI18n/content', array('cols' => '60', 'rows' => '20','value'=>"{$this->data['MailTemplateI18n'][$k]['text_body']}","name"=>"data[MailTemplateI18n][{$k}][text_body]","id"=>"ArticleI18n{$k}Content"));?> 
	       	<?php echo $fck->load("ArticleI18n{$k}/content"); ?>
	    	<?php }?>
		    </p>
			<br /><br />
			<?php }}?>
		<?php }?></div><br />
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  HTML杂志内容</h1></div>
	  <div class="box">
	     <?php if($SVConfigs["select_editor"]=="2"||empty($SVConfigs["select_editor"])){?>
	  	<?php echo $javascript->link('tinymce/tiny_mce/tiny_mce'); ?>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<table><tr><td valign="top">
	  	<?php echo $html->image($v['Language']['img01'])?></td><td valign="top">
		<textarea id="1elm<?php echo $v['Language']['locale'];?>" name="data[MailTemplateI18n][<?php echo $k;?>][html_body]" rows="15" cols="80" style="width: 80%"><?php echo $this->data['MailTemplateI18n'][$k]['html_body'];?></textarea>
		<?php  echo $tinymce->load("1elm".$v['Language']['locale'],$now_locale); ?><br /></td></tr>
		</table>
    	<?php }?></p>
		<?php }?><?php }?>
		<?php if($SVConfigs["select_editor"]=="1"){?>
			<?php echo $javascript->link('fckeditor/fckeditor'); ?>
		  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		  	<?php echo $html->image($v['Language']['img01'])?><br />
			<p class="profiles">
			<?php  if(isset($article['BrandI18n'][$k]['description'])){?>
	        <?php echo $form->textarea('ArticleI18n/content', array("cols" => "60","rows" => "20",'value'=>"{$this->data['MailTemplateI18n'][$k]['html_body']}","name"=>"data[MailTemplateI18n][{$k}][html_body]","id"=>"ArticleI118n{$k}Content"));?>
	        <?php echo $fck->load("ArticleI118n{$k}/content"); ?>
	        
	    	<?php }else{?>
	       	<?php echo $form->textarea('ArticleI18n/content', array('cols' => '60', 'rows' => '20','value'=>"{$this->data['MailTemplateI18n'][$k]['html_body']}","name"=>"data[MailTemplateI18n][{$k}][html_body]","id"=>"ArticleI118n{$k}Content"));?> 
	       	<?php echo $fck->load("ArticleI118n{$k}/content"); ?>
	    	<?php }?>
		    </p>
			<br /><br />
			<?php }}?>
		<?php }?>
		</div></div>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
<?php echo $form->end();?>
</div>
<!--Main End-->
</div>