<?php 
/*****************************************************************************
 * SV-Cart  角色管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
	  <?php echo $form->create('',array('action'=>'/','name'=>'SearchForm','type'=>'get'));?>

	<dl>
	<dt style="padding-top:2px;"><?php echo $html->image('serach_icon.gif')?></dt>
	<dd><p class="reg_time">关键字：<input type="text" id="role_name" name="role_name" <?php if(isset($role_name)){?>value="<?php echo $role_name;?>"<?php }?>/>
</p><dd>
	<dt class="big_search"><input class="search_article" type="submit" value="搜索"/></dt>
	</dl>
</div>
<br />
<!--Search End-->
<?php echo $form->end();?><br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增角色","/roles/add/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
  <?php echo $form->create('',array('action'=>''));?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="12%">角色名称</th>
	<th width="8%">角色人数</th>
	<th width="72%">权限摘要</th>
	<th width="8%">操作</th>
</tr> 
<?php if(isset($role_list) && sizeof($role_list)>0){?>
<?php $ij=0; foreach($role_list as $k=>$v){?>	
<tr <?php if((abs($ij)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }$ij++;?> >
	<td><?php echo $v['OperatorRoleI18n']['name']?></td>
	<td align="center"><?php echo $v['OperatorRole']['number']?></td>
	<td><?php echo $v['OperatorRole']['actionses']?></td>
	<td align="center">
	<?php echo $html->link("编辑","/roles/edit/{$v['OperatorRole']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}roles/remove/{$v['OperatorRole']['id']}')"));?>
</td>
</tr>
<?php }} ?>		
</table></div>
</div>
  <div class="pagers" style="position:relative">
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<?php echo $form->end();?>
</div>
<!--Main Start End-->
</div>