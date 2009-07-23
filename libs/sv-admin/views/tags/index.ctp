<?php 
/*****************************************************************************
 * SV-Cart 标签管理类表
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增标签","add/",'',false,false);?></strong></p>
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' );">
<?php echo $form->create('',array('action'=>'/',"name"=>"ProForm","type"=>"get",'onsubmit'=>"return false"));?>
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th align="left"><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th><p>标签名称</p></th>
	<th>类型</th>
	<th>会员名</th>
	<th>商品名称/文章名称</th>
	<th>是否显示</th>
	<th>操作</th></tr>
<?php if(isset($tags) && sizeof($tags)){?>
<?php foreach($tags as $k=>$v){?>	
	<tr>
	<td><input type="checkbox" name="checkboxes[]" value="<?php echo $v['Tag']['id']?>" /><?php echo $v['Tag']['id']?></td>
	<td><p><?php echo $v['TagI18n']['name']?></p></td>
	<td align="center"><?php if($v['Tag']['type'] == "A"){echo"文章";}else if($v['Tag']['type'] == "P"){echo"商品";}else{echo"未定义";}?></td>
	<td align="center"><?php if(isset($v['Tag']['user_name'])){echo $v['Tag']['user_name'];}?></td>
	<td align="center"><?php if(isset($v['Tag']['type_name'])){echo $v['Tag']['type_name'];}?></td>
	<td align="center"><?php if($v['Tag']['status'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{?><?php echo $html->image('no.gif')?><?php }?></td>
	<td align="center">
	<?php echo $html->link("编辑","/tags/{$v['Tag']['id']}");?>|<?php echo $html->link("删除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}tags/remove/{$v['Tag']['id']}/{$v['TagI18n']['name']}')"));?>
	</td></tr>
<?php }}?>
  </table>
  <div class="pagers" style="position:relative">
  <p class='batch'>
 <?php if(isset($total) && $total>0){?> 
    <select style="border:1px solid #689F7C;" name="act_type" id="act_type" onchange="operate_change()">
   <option value="0">请选择...</option>
   <option value="del">放入回收站</option>
   <option value="category">转移到分类</option>
    </select> 
	<input type="button" value="确定"  onclick="operate_change()"  id="change_button"/><?php }?></p>

<?php //php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<?php echo $form->end();?>
</div>
<!--Main Start End-->
</div>