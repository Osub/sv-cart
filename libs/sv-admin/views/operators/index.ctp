<?php 
/*****************************************************************************
 * SV-Cart  操作员管理列表
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
	<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
	<!--Search-->
<div class="search_box">
	  <?php echo $form->create('',array('action'=>'/','name'=>'SearchForm','type'=>'get'));?>

	<dl>
	<dt style="padding-top:2px;"><?php echo $html->image('serach_icon.gif')?></dt>
	<dd><p class="reg_time">名称：<input type="text" id="operator_name" name="operator_name"  <?php if(isset($operator_name)){?>value="<?php echo $operator_name;?>"<?php }?>/>
</p><dd>
<dd><p class="reg_time">&nbsp;邮箱地址：<input type="text" id="operator_email" name="operator_email" <?php if(isset($operator_email)){?>value="<?php echo $operator_email;?>"<?php }?> />
</p><dd>
<dd><p class="reg_time">&nbsp;部门：<select id="operator_depart" name="operator_depart">
<option value="所有部门">所有部门</option>
<?php foreach($departments as $k=>$v){?>
    <option value="<?php echo $k;?>" <?php if(isset($operator_depart)){?><?php if($operator_depart == $k){?>selected<?php }?><?php }?>><?php echo $v;?></option>
<?php }?>
</select>
</p><dd>
	<dt class="big_search"><input type="submit" class="search_article" value="搜索" /></dt>
	</dl>
</div>
<br />
<!--Search End-->
<?php  echo $form->end();?><br />
<br />
<!--Main Start-->
<p class="add_categories"><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增操作员","/operators/add",array(),false,false);?></p>
	  <?php echo $form->create('',array('action'=>'','name'=>'SearchForm'));?>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
	<tr class="thead">
	<th  width="8%">操作员名称</th>
	<th  width="12%">Email地址</th>
	<th  width="20%">部门</th>
	<th width="20%">角色</th>
	<th width="8%">状态</th>
	<th width="12%">加入时间</th>
	<th width="12%">最后登录时间</th>
	<th width="8%">操作</th>
	</tr>
<!--User List-->
	<?php if(isset($operators) && sizeof($operators)>0){?>
	<?php foreach($operators as $k=>$operator){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $html->link($operator['Operator']['name'],"edit/{$operator['Operator']['id']}",'',false,false);?></td>
	<td><?php echo $operator['Operator']['email'];?></td>
	<td>
	<?php if(!empty($operator['Operator']['department_id'])){
		if(isset($departments[$operator['Operator']['department_id']])){
			echo @$departments[$operator['Operator']['department_id']];
			}else{
			echo '没有部门';
			}} else{ echo '没有部门';}?>
	</td>
	<td><?php echo $operator['Operator']['role_name'];?></td>
	<td align="center"><?php if($operator['Operator']['status']==1) 
		{echo $html->image('yes.gif');}else{ echo $html->image('no.gif');}?></td>
	<td align="center"><?php echo $operator['Operator']['created'];?></td>
	<td align="center"><?php echo $operator['Operator']['modified'];?></td>
	<td align="center">
	<?php echo $html->link("编辑","/operators/edit/{$operator['Operator']['id']}");?>
	<?php if($operator['Operator']['id']==1){?>
	<?php }else{ ?>
	| <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}operators/remove/{$operator['Operator']['id']}')"));?>
	<?php } ?>
	</td>
	</tr>

	<?php  }}?>
	</table></div>
	<div class="pagers" style="position:relative">
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
<?php  echo $form->end();?>
<!--Main Start End-->
</div>