<?php 
/*****************************************************************************
 * SV-Cart 红包管理
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

<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增包装","add/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="30%">商品包装名称</th>
	<th width="8%">图片</th>
	<th width="8%">费用</th>
	<th width="8%">免费额度</th>
	<th width="30%">包装描述</th>
	<th width="8%">是否有效</th>
	<th width="8%">操作</th></tr>
<!--Menberleves List-->
<?php if(isset($package_list) && sizeof($package_list)>0){?>
<?php foreach($package_list as $k=>$v){ ?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><span><?php echo $html->image('picflag.gif',array('align'=>'absmiddle'))?> <strong><?php echo $v['PackagingI18n']['name'] ?></strong></span></td>
	<td align="center">
		<?php if(!empty($v['Packaging']['img01'])){?>
			<?php echo @$html->image("/..{$v['Packaging']['img01']}",array('width'=>'40','height'=>'40','align'=>'absmiddle'))?>
		<?php }?>
	</td>
	<td align="center"><?php echo $v['Packaging']['fee'] ?></td>
	<td align="center"><?php echo $v['Packaging']['free_money'] ?></td>
	<td align="center"><span><?php echo $v['PackagingI18n']['description'] ?></span></td>
	<td align="center"><?php if($v['Packaging']['status'])echo $html->image('yes.gif',array('align'=>'absmiddle'));else echo $html->image('no.gif',array('align'=>'absmiddle')) ?></td>
	<td align="center">

	<?php echo $html->link("编辑","/packages/edit/{$v['Packaging']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}packages/remove/{$v['Packaging']['id']}')"));?>
	
	
	
	</td></tr>
<?php }} ?>
	</table></div>

<!--Menberleves List End-->	
<div class="pagers" style="position:relative">
<?php echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>