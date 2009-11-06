<?php 
/*****************************************************************************
 * SV-Cart 商店设置管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3792 2009-08-19 11:21:35Z zhengli $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增关键字","add/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<?php echo $form->create('',array('action'=>'','name'=>'UserForm',"onsubmit"=>"return false","type"=>"get"));?>

<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">	
	<th width="6%">编号</th>
	<th width="31%">关键词</th>
	<th width="15%">引用次数</th>
	<th width="12%">最后引用</th>
	<th width="8%">点击次数</th>
	<th width="12%">最后访问</th>
	<th width="8%">排序</th>
	<th width="8%">管理操作</th>
</tr>
<!--User List-->
<?php if(isset($seokeyword_data) && sizeof($seokeyword_data)>0){?>
<?php foreach($seokeyword_data as $k=>$v){ ?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >	
	<td align="center"><?php echo $v['SeoKeyword']['id'];?></td>
	<td><?php echo $v['SeoKeyword']['name'];?></td>
	<td align="center"><?php echo $v['SeoKeyword']['usetimes'];?></td>
	<td align="center"><?php echo $v['SeoKeyword']['lastusetime'];?></td>
	<td align="center"><?php echo $v['SeoKeyword']['hits'];?></td>
	<td align="center"><?php echo $v['SeoKeyword']['lasthittime'];?></td>
	<td align="center"><?php echo $v['SeoKeyword']['orderby'];?></td>
	<td align="center">
		<?php echo $html->link("编辑","/keywords/edit/{$v['SeoKeyword']['id']}");?> |
		<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}keywords/remove/{$v['SeoKeyword']['id']}')"));?>
	</td>
</tr>
<?php }}?>
</table></div>
<!--User List End-->	
<div class="pagers" style="position:relative">
	<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div><?php echo $form->end();?>
<!--Main Start End-->
</div>
