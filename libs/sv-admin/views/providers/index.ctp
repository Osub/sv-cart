<?php 
/*****************************************************************************
 * SV-Cart  供应商管理列表
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
<!--Search-->
<div class="search_box">
<?php echo $form->create('Provider',array('action'=>'./'));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">关键字：<input type="text" class="name" name="data[provider][name]" value="<?php echo $keyword_name?>" />
	<select name="data[provider][status]"><option value="all" <?php if($status == "all"){echo "selected";}?>>请选择</option>><option value="1" <?php if($status == "1"){echo "selected";}?> >有效</option><option value="0" <?php if($status == "0"){echo "selected";}?> >无效</option></select>
	</p></dd>
	<dt class="small_search"><input type="submit" value="搜索" class="search_article" /></dt>
	</dl><?php echo $form->end();?>
</div>
<br />
<!--Search End-->
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增供应商","add/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>供应商名称</th>
	<th width="8%">联系人</th>
	<th width="20%">Email地址</th>
	<th width="15%">联系电话</th>
	<th width="8%">当前商品数</th>
	<th width="8%">是否有效</th>
	<th width="8%">操作</th>
</tr>
<!--Competence List-->
<?php if(isset($provider_list) && sizeof($provider_list)>0){?>
<?php foreach( $provider_list as $k=>$v ){?>	
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $v['Provider']['name']?></td>
	<td align="center"><?php echo $v['Provider']['contact_name']?></td>
	<td align="center"><?php echo $v['Provider']['contact_email']?></td>
	<td align="center"><?php echo $v['Provider']['contact_tele']?></td>
	<td align="center"><?php echo $v['Provider']['total']?></td>
	<td align="center"><?php if ($v['Provider']['status'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['Provider']['status'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></li>
	<td align="center">
	<?php echo $html->link("编辑","/providers/edit/{$v['Provider']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}providers/remove/{$v['Provider']['id']}')"));?>
	</td>
</tr>
<?php }} ?>
</table></div>

<!--Competence List End-->	

<br />
</div>
<!--Main Start End-->
</div>