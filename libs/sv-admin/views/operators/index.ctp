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
 * $Id: index.ctp 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
?>
<div class="content">
	<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
	<!--Search-->
<div class="search_box">
	  <?php echo $form->create('',array('action'=>'/','name'=>'SearchForm','type'=>'get'));?>

	<dl>
	<dt style="padding-top:2px;"><?=$html->image('serach_icon.gif')?></dt>
	<dd><p class="reg_time">名称：<input type="text" id="operator_name" name="operator_name"  <?if(isset($operator_name)){?>value="<?echo $operator_name;?>"<?}?>/>
</p><dd>
<dd><p class="reg_time">&nbsp;邮箱地址：<input type="text" id="operator_email" name="operator_email" <?if(isset($operator_email)){?>value="<?echo $operator_email;?>"<?}?> />
</p><dd>
<dd><p class="reg_time">&nbsp;部门：<select id="operator_depart" name="operator_depart">
<option value="所有部门">所有部门</option>
<?foreach($departments as $k=>$v){?>
    <option value="<?echo $k;?>" <?if(isset($operator_depart)){?><?if($operator_depart == $k){?>selected<?}?><?}?>><?echo $v;?></option>
<?}?>
</select>
</p><dd>
	<dt class="big_search"><input type="submit" class="search_article" value="搜索" /></dt>
	</dl>
</div>
<br />
<!--Search End-->
<? echo $form->end();?><br />
<br />
<!--Main Start-->
<p class="add_categories"><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增操作员","/operators/add",array(),false,false);?></p>
	  <?php echo $form->create('',array('action'=>'','name'=>'SearchForm'));?>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist operatorscompetentce_headers">
	<li class="username">操作员名称</li>
	<li class="email">Email地址</li>
	<li class="department">部门</li>
	<li class="role">角色</li>
	<li class="status">状态</li>
	<li class="jointime">加入时间</li>
	<li class="last_login">最后登录时间</li>
	<li class="hadle">操作</li></ul>
<!--User List-->
	<?if(isset($operators) && sizeof($operators)>0){?>
	<?php foreach($operators as $operator){?>
	<ul class="product_llist operatorscompetentce_headers operatorscompetentce_list">
	<li class="username"><span>
		<?php echo $html->link($operator['Operator']['name'],
		"edit/{$operator['Operator']['id']}",'',false,false);?>
		</span></li>
	<li class="email"><span><?php echo $operator['Operator']['email'];?></span></li>
	<li class="department"><?php if(!empty($operator['Operator']['department_id'])){
			if(isset($departments[$operator['Operator']['department_id']])){
				echo @$departments[$operator['Operator']['department_id']];
			}else{
				echo '没有部门';
			}} else{ echo '没有部门';}?></li>
	<li class="role"><p><?=$operator['Operator']['role_name'];?></p></li>
	<li class="status"><?php if($operator['Operator']['status']==1) 
		{echo $html->image('yes.gif');}else{ echo $html->image('no.gif');}?></li>
	<li class="jointime"><?php echo $operator['Operator']['created'];?></li>
	<li class="last_login"><?php echo $operator['Operator']['modified'];?></li>
	<li class="hadle">

	<?php echo $html->link("编辑","/operators/edit/{$operator['Operator']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}operators/remove/{$operator['Operator']['id']}')"));?>
	</li></ul>

	<?php  }}?>
	<div class="pagers" style="position:relative">
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
<? echo $form->end();?>
<!--Main Start End-->
</div>