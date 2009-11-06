<?php 
/*****************************************************************************
 * SV-Cart  添加角色管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 4372 2009-09-18 10:38:17Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."角色列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>

<!--Main Start-->
<?php echo $form->create('Role',array('action'=>'add/','onsubmit'=>'return roles_check();'));?>
<div class="home_main">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  添加角色</h1></div>
	  <div class="box">
	  <br />
	  
	  <h2>角色名称：</h2>
	  	  <?php if(isset($languages) && sizeof($languages)>0){?>
<?php foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input type="text" style="width:195px;" id="name<?php echo $v['Language']['locale']?>" name="data[OperatorRoleI18n][<?php echo $k;?>][name]"  /> <font color="#F90046">*</font></span></p>
		
<?php }} ?>
		<br />
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Other Stat-->
	<div class="order_stat athe_infos tongxun">
	  
	  <div class="box">
		
		<br />
		<dl style="margin-bottom:5px;padding-top:8px;"><dt>角色编号：</dt>
			<dd>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="text_inputs" style="width:190px;" name="data[OperatorRole][id]"  /> <font color="#F94671">*</font></dd></dl>
			<dl style="margin-bottom:5px;padding-top:8px;"><dt>角色排序：</dt>
			<dd>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="text_inputs" style="width:190px;" name="data[OperatorRole][orderby]"  /><br /> 如果您不输入排序号，系统将默认为50</dd></dl>
		<dl><dt>是否有效：</dt>
			<dd>&nbsp;&nbsp;<input type="radio" name="data[OperatorRole][status]" value="1" checked /> 是 <input type="radio" name="data[OperatorRole][status]" value="0"  /> 否</dd></dl>
		
		
		<br />
	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>

</table>

<!--Categories List-->
<!--Order Stat-->
<div class="order_stat operators properies">
	<div class="title">
	  	<h1>
	  	<?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  	<?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	 	 默认权限
	  	</h1>
	</div>
	<div class="box">
  	    <p class="select_operators" style="margin-top:-30px;"></p>
  	<?php if(isset($operatoraction) && sizeof($operatoraction)>0){?>
		<?php  foreach($operatoraction as $k=>$v){ ?>
		<div class="purview_set">
			<p><label><input type="checkbox" name="checkbox" value="checkbox" /><?php echo $v['Operator_action']['name'];?></label></p>
			<ul>
			<?php  if(isset($v['SubAction']) && sizeof($v['SubAction'])>0){foreach($v['SubAction'] as $kk=>$vv){  ?>
				<li>
				<label>
				<input type="checkbox" name="competence[]" value="<?php echo $vv['Operator_action']['id'];?>" /><?php echo $vv['Operator_action']['name'];?>
				</label>
				</li>
			<?php }} ?>
			</ul>
		</div>
		<?php }} ?>		
	</div>
<!--Order Stat End-->
<!--Categories List End-->
<!-- gin add start -->
	<div class="title2">
	  	<h1>
	  	<?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  	<?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	 	 xxxx
	  	</h1>
	</div>
	<div class="box">
  	    <p class="select_operators" style="margin-top:-30px;"></p>
  	    <?php if(isset($operatoraction) && sizeof($operatoraction)>0){?>
		<?php  foreach($operatoraction as $k=>$v){ ?>
		<div class="purview_set">
			<p><label><input type="checkbox" name="checkbox" value="checkbox" /><?php echo $v['Operator_action']['name'];?></label></p>
			<ul>
			<?php  if(isset($v['SubAction']) && sizeof($v['SubAction'])>0){foreach($v['SubAction'] as $kk=>$vv){  ?>
				<li>
				<label>
				<input type="checkbox" name="competence[]" value="<?php echo $vv['Operator_action']['id'];?>" /><?php echo $vv['Operator_action']['name'];?>
				</label>
				</li>
			<?php }} ?>
			</ul>
		</div>
		<?php }} ?>		
	</div>

<!-- gin add end -->
<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>

</div>
<?php echo $form->end();?>
</div>
<!--Main Start End-->
<?php echo $html->image('content_left.gif',array('class'=>'content_left'))?><?php echo $html->image('content_right.gif',array('class'=>'content_right'))?>
</div>