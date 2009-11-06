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
 * $Id: index.ctp 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增邮件模板","add/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' );height:auto!important;">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="12%">代码</th>
	<th width="32%">邮件模板名称</th>
	<th width="40%">说明</th>
	<th width="8%">是否启用</th>
	<th width="8%">操作</th>
</tr>
<!--Competence List-->
<?php if(isset($MailTemplate_list) && sizeof($MailTemplate_list)>0){?>
<?php foreach( $MailTemplate_list as $k=>$v ){ ?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $v["MailTemplate"]["code"]?></td>
	<td><?php echo $v["MailTemplateI18n"]["title"]?></td>
	<td><?php echo $v["MailTemplateI18n"]["description"]?></td>
	<td align="center"><?php if ($v['MailTemplate']['status'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['MailTemplate']['status'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></td>
	<td align="center">
		<?php echo $html->link("编辑","/mailtemplates/edit/{$v['MailTemplate']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}mailtemplates/remove/{$v['MailTemplate']['id']}')"));?>
	</td>
</tr>
<?php } }?>
</table></div>
<!--Competence List End-->	

<br />
</div>

<!--Main Start End-->
</div>