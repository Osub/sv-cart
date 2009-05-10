<?php
/*****************************************************************************
 * SV-Cart  添加操作员
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 943 2009-04-23 10:38:44Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('listtable');?>
<?php //pr($this->data);pr($departments);pr($_SESSION)?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."操作员列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>
<div class="home_main">
<?php echo $form->create('Operator',array('action'=>'add','onsubmit'=>'return operators_check();'));

?>


<? if(isset($languages) && sizeof($languages)>0){
		foreach ($languages as $k => $v){?>
	<input name="data[OperatorI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
<?
	}
}?>


<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  添加操作员</h1></div>
	<?php //pr($languages);pr($this->data)?>
	  <div class="box">
	  <br />
  	    <dl><dt>用户名：</dt>
			<dd><input type="text" class="text_inputs" style="width:270px;" id="OperatorName" name="data[Operator][name]" value="<?= $this->data['Operator']['name'];?>"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt>Email地址：</dt>
			<dd><input type="text" class="text_inputs" style="width:270px;" id="OperatorEmail" name="data[Operator][email]" value="<?= $this->data['Operator']['email'];?>"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt>所属部门：</dt><dd>
			<select style="width:272px;*width:275px;" name="data[Operator][department_id]">
			<option value="0">没有部门</option>
	<? if(isset($departments) && sizeof($departments)>0){?>

			<?php foreach($departments as $k => $v){?>
			
			<option value="<?php echo $v['Department']['id'];?>"><?php echo $v['DepartmentI18n']['name']?></option>
			<?php }}?>
			</select> <font color="#F94671">*</font></dd></dl>
			<dl><dt>默认语言：</dt><dd>
			<select style="width:272px;*width:275px;" name="data[Operator][default_lang]">
				<? if(isset($languages) && sizeof($languages)>0){?>

			<?php foreach($languages as $k => $v){?>
			
			<option value="<?php echo $v['Language']['locale'];?>"><?php echo $v['Language']['name']?></option>
			<?php }}?>
			</select> <font color="#F94671">*</font></dd></dl>
<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">状态：</dt><dd class="best_input"><input id="OperatorStatus" name="data[Operator][status]" type="radio" value="1" checked >有效<input id="OperatorStatus" name="data[Operator][status]" type="radio" value="0" >无效<input id="OperatorStatus" name="data[Operator][status]" type="radio" value="3" >冻结</dd></dl>
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
		<dl><dt>密码：</dt>
			<dd><input type="password" class="text_inputs" style="width:270px;" name="data[Operator][password]" id="NewPassword"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt>确认密码：</dt>
			<dd><input type="password" class="text_inputs" style="width:270px;" name="confirmpassword" id="ConfirmPassword"/> <font color="#F94671">*</font></dd></dl>
		
		<br /><br /><br />
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
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  <span>操作员权限</span></h1></div>
	  <div class="box">
  	    <p class="select_operators">
		<span><strong>角色维护</strong></span>
		<? if(isset($operator_roles) && sizeof($operator_roles)>0){?>

		<?php foreach($operator_roles as $v){?>
		<span><input type="checkbox" name="operator_role[]" value="<?php echo $v['OperatorRole']['id']?>"  onclick="javascript:check('<?php if(isset($v['OperatorRole']['actions'])){ echo $v['OperatorRole']['actions'];}?>',this,'operator_action')" />   <?php echo $v['OperatorRole']['name']?></span>
		<?php }}?>
		</p>
				<? if(isset($operator_actions) && sizeof($operator_actions)>0){?>

		<?php foreach($operator_actions as $k=>$v){?>
		<div class="purview_set">
		<p><label><input type="checkbox" name="operator_actions[]" value="<?php echo $v['Operator_action']['id']?>" onclick="javascript:check('<?php if(isset($v['SubAction']))foreach($v['SubAction'] as $vv){ echo $vv['Operator_action']['id'].',';}?>',this,'operator_action')"  /><?php echo $v['Operator_action']['name']?></label></p>
		<ul>
			<?php if(isset($v['SubAction']) && sizeof($v['SubAction'])>0)foreach($v['SubAction'] as $vv){?>
			<li><label><input type="checkbox" name="operator_action[]" value="<?php echo $vv['Operator_action']['id']?>"/><?php echo $vv['Operator_action']['name']?></label></li>
			<?php }?>
		</div>
		<?php }}?>
		
	  <br /><br /><br />
	  <p class="submit_operators"><label><input type="checkbox" name="checkbox" value="checkbox" onclick="checkAll(this.form, this);" />全选</label><input type="submit" value="保 存" class="submit_main" /></p>
	</div>
<!--Order Stat End-->
<!--Categories List End-->
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>

</div>
<? echo $form->end();?>
<!--</form>-->
</div>
<!--Main Start End-->
<?=$html->image('content_left.gif',array('class'=>'content_left'))?><?=$html->image('content_right.gif',array('class'=>'content_right'))?>
</div>