<?php 
/*****************************************************************************
 * SV-Cart  编辑部门管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 2498 2009-07-01 07:17:42Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."部门列表","/departments/",'',false,false);?></strong></p>

<!--Main Start-->

<div class="home_main">
<?php echo $form->create('Department',array('action'=>'edit','onsubmit'=>'return departments_check();'));?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos department_config">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑部门</h1></div>
	  <div class="box">
	  <br /><input id="BrandId" name="data[Department][id]" type="hidden" value="<?php echo  $departments_info['Department']['id'];?>">
  	    <dl><dt class="config_lang">部门名称:</dt>
		<dd></dd></dl>
	
			<?php if(isset($languages) && sizeof($languages)>0){
		foreach ($languages as $k => $v){?>	
	  	<dl><dt class="config_lang"><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd><input type="text" style="width:150px;" id="name<?php echo $v['Language']['locale']?>" id="name<?php echo $v['Language']['locale']?>" name="data[DepartmentI18n][<?php echo $k?>][name]"  <?php if(isset($departments_info['DepartmentI18n'][$v['Language']['locale']])){?>value="<?php echo  $departments_info['DepartmentI18n'][$v['Language']['locale']]['name'];?>"<?php }else{?>value=""<?php }?>  /> <font color="#F94671">*</font></dd></dl>
	<?php }}?>

	
			
		<dl><dt class="config_lang">描述:</dt><dd></dd></dl>
	<?php if(isset($languages) && sizeof($languages)>0){
		foreach ($languages as $k => $v){?>	
		<dl><dt class="config_lang"><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd><textarea name="data[DepartmentI18n][<?php echo $k?>][description]"><?php if(isset($departments_info['DepartmentI18n'][$v['Language']['locale']])){?><?php echo $departments_info['DepartmentI18n'][$v['Language']['locale']]['description']?><?php }?></textarea></dd></dl>
		<input type="hidden" name="data[DepartmentI18n][<?php echo $k?>][locale]" value="<?php echo $v['Language']['locale']?>" />
		<input id="DepartmentI18n<?php echo $k;?>Id" name="data[DepartmentI18n][<?php echo $k;?>][id]" type="hidden" value="<?php if(isset($departments_info['DepartmentI18n'][$v['Language']['locale']]['id'])){ echo $departments_info['DepartmentI18n'][$v['Language']['locale']]['id'];}?>">
		<input id="DepartmentI18n<?php echo $k;?>DepartmentId" name="data[DepartmentI18n][<?php echo $k;?>][department_id]" type="hidden" value="<?php if(isset($departments_info['Department']['id'])){echo $departments_info['Department']['id'];}?>">
	
		<?php }}?>	


		
		<dl><dt class="config_lang">联系人:</dt>
			<dd><input type="text" class="text_inputs" style="width:320px;" name="data[Department][contact_name]" value="<?php echo $departments_info['Department']['contact_name']?>"/></dd></dl>
		<dl><dt class="config_lang">联系备注:</dt>
			<dd><input type="text" class="text_inputs" style="width:320px;" name="data[Department][contact_remark]" value="<?php echo $departments_info['Department']['contact_remark']?>" /></dd></dl>

		<dl><dt class="config_lang">Email地址:</dt>
			<dd><input type="text" class="text_inputs" style="width:320px;" name="data[Department][contact_email]" value="<?php echo $departments_info['Department']['contact_email']?>"/></dd></dl>
		<dl><dt class="config_lang">联系电话:</dt>
			<dd><input type="text" class="text_inputs" style="width:320px;" name="data[Department][contact_tele]" value="<?php echo $departments_info['Department']['contact_tele']?>"/></dd></dl>
		<dl><dt class="config_lang">手机:</dt>
			<dd><input type="text" class="text_inputs" style="width:320px;" name="data[Department][contact_mobile]" value="<?php echo $departments_info['Department']['contact_mobile']?>"/></dd></dl>
		<dl><dt class="config_lang">传真:</dt>
			<dd><input type="text" class="text_inputs" style="width:320px;" name="data[Department][contact_fax]" value="<?php echo $departments_info['Department']['contact_fax']?>"/></dd></dl>
	
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Password-->
	<div class="order_stat athe_infos">
	  
	  <div class="box">
		<br />
		<dl><dt>排序：</dt>
			<dd><input type="text" name="data[Department][orderby]" class="text_inputs" style="width:115px;" value="<?php echo $departments_info['Department']['orderby'];?>" onkeyup="check_input_num(this)" /><p class="msg"> 如果您不输入排序号，系统将默认为50</p></dd></dl>
		<dl><dt>是否显示：</dt>
			<dd style="padding-top:4px;*padding-top:5px;">
			<input type="radio" class="radio" name="data[Department][status]" value="1" <?php if($departments_info['Department']['status']){?>checked<?php }?> />是&nbsp;
			<input type="radio" class="radio" name="data[Department][status]" value="0" <?php if($departments_info['Department']['status']==0){?>checked<?php }?>/>否</dd></dl>
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	  </div>
	</div>
<!--Password End-->

</td>
</tr>
<tr><td colspan="2"><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p></td></tr>
</table>
<?php echo $form->end();?>

</div>
<!--Main Start End-->
<?php echo $html->image('content_left.gif',array('class'=>'content_left'))?><?php echo $html->image('content_right.gif',array('class'=>'content_right'))?>
</div>