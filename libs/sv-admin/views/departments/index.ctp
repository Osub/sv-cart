<?php 
/*****************************************************************************
 * SV-Cart  部门管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2516 2009-07-01 10:29:18Z shenyunfeng $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增部门","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>部门名称</th>
	<th>联系人</th>
	<th>Email地址</th>
	<th>系电话</th>
	<th>是否有效</th>
	<th>操作</th>
</tr>
<!--Products Cat List-->
<?php if(isset($department_list) && sizeof($department_list)>0){?>
<?php foreach($department_list as $k=>$v){ ?>
<tr>	
	<td><?php echo $v['DepartmentI18n']['name'] ?></td>
	<td align="center"><?php echo $v['Department']['contact_name'] ?></td>
	<td align="center"><?php echo $v['Department']['contact_email'] ?></td>
	<td align="center"><?php echo $v['Department']['contact_mobile'] ?></td>
	<td align="center"><?php if ($v['Department']['status'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['Department']['status'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></td>
	<td align="center">
	<?php echo $html->link("编辑","/departments/edit/{$v['Department']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}departments/remove/{$v['Department']['id']}')"));?>
	</td>
</tr>
<?php } ?><?php }?>
</table>


<!--Products Cat List End-->
<br />

	</div>
	
<!--Main Start End-->
<!--
<img src="images/content_left.gif" class="content_left" /><img src="images/content_right.gif" class="content_right" />
-->
</div>