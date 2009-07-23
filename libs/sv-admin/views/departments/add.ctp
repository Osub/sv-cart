<?php 
/*****************************************************************************
 * SV-Cart  新增部门管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 2485 2009-06-30 11:33:00Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."部门列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<!--Main Start-->

<div class="home_main">
<?php echo $form->create('Department',array('action'=>'add','onsubmit'=>'return departments_check();'));?>
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
	  <br />
  	    <dl><dt class="config_lang">部门名称:</dt>
		<dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){
		foreach ($languages as $k => $v){?>	
		<dl><dt class="config_lang"><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd>
<input type="text" style="width:150px;" id="name<?php echo $v['Language']['locale']?>" name="data[DepartmentI18n][<?php echo $k?>][name]"  /> <font color="#F94671">*</font>
		</dd>
		</dl>
		<?php 
		}
		}?>
		<dl><dt class="config_lang">描述:</dt><dd>
		</dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){
		foreach ($languages as $k => $v){?>	
		<dl><dt class="config_lang"><?php echo $html->image($v['Language']['img01'])?></dt><dd>
		<textarea name="data[DepartmentI18n][<?php echo $k?>][description]"></textarea>
		</dd></dl>


		<input type="hidden" name="data[DepartmentI18n][<?php echo $k?>][locale]" value="<?php echo $v['Language']['locale']?>" />
		<?php }}?>
		
		<dl><dt class="config_lang">联系人:</dt>
			<dd><input type="text" class="text_inputs" style="width:320px;" name="data[Department][contact_name]" /></dd></dl>
		<dl><dt class="config_lang">联系备注:</dt>
			<dd><input type="text" class="text_inputs" style="width:320px;" name="data[Department][contact_remark]" /></dd></dl>
		<dl><dt class="config_lang">Email地址:</dt>
			<dd><input type="text" class="text_inputs" style="width:320px;" name="data[Department][contact_email]" /></dd></dl>
		<dl><dt class="config_lang">联系电话:</dt>
			<dd><input type="text" class="text_inputs" style="width:320px;" name="data[Department][contact_tele]" /></dd></dl>
		<dl><dt class="config_lang">手机:</dt>
			<dd><input type="text" class="text_inputs" style="width:320px;" name="data[Department][contact_mobile]" /></dd></dl>
		<dl><dt class="config_lang">传真:</dt>
			<dd><input type="text" class="text_inputs" style="width:320px;" name="data[Department][contact_fax]" /></dd></dl>
	
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
			<dd><input type="text" name="data[Department][orderby]" class="text_inputs" style="width:115px;" onkeyup="check_input_num(this)" /><br /> 如果您不输入排序号，系统将默认为50</dd></dl>
		<dl><dt>是否显示：</dt>
			<dd><input type="radio" name="data[Department][status]" value="1" checked /> 是 <input type="radio" name="data[Department][status]" value="0" /> 否</dd></dl>
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