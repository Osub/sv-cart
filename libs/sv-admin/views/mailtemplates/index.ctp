<?php
/*****************************************************************************
 * SV-Cart 邮件模板管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1201 2009-05-05 13:30:17Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增邮件模板","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist memberlevels MailTemplate">
	<li class="template_name"><p><strong>代码</strong></p></li>
	<li class="template_code"><p><strong>邮件模板名称</strong></p></li>
	
	<li class="use">是否启用</li>
	
	<li class="hadl_template">操作</li></ul>
<!--Competence List-->
<? if(isset($MailTemplate_list) && sizeof($MailTemplate_list)>0){?>

<? foreach( $MailTemplate_list as $k=>$v ){ ?>
	<ul class="product_llist memberlevels memberlevels_list MailTemplate">
	<li class="purview template_name"><p><strong style='margin:0;'><?=$v["MailTemplate"]["code"]?></strong></p></li>
	<li class="template_code"><p><?=$v["MailTemplateI18n"]["title"]?></p></li>
	
	<li class="use"><?if ($v['MailTemplate']['status'] == 1){?><?=$html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?}elseif($v['MailTemplate']['status'] == 0){?><?=$html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?}?></li>
	
	<li class="hadl_template"><?php echo $html->link("编辑","/mailtemplates/edit/{$v['MailTemplate']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}mailtemplates/remove/{$v['MailTemplate']['id']}')"));?>
	</span></li></ul>
<? } }?>
<!--Competence List End-->	

<br />
</div>

<!--Main Start End-->
</div>