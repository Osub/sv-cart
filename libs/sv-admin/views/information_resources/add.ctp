<?php 
/*****************************************************************************
 * SV-Cart 添加菜单
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<div class="content">
	<?php //pr($this->data);pr($parentmenu);?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories"><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."菜单列表","./",array(),false,false);?></p>

<div class="home_main">
<!--ConfigValues-->
<?php echo $form->create('InformationResource',array('action'=>'add/'.$this->data['InformationResource']['id'],'onsubmit'=>'return menus_check()'));?>
	<input id="Operator_emnuId" name="data[Operator_menu][id]" type="hidden" value="<?php echo  $newid;?>">
	
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
	<td align="left" width="50%" valign="top" style="padding-right:5px">
	<div class="order_stat athe_infos configvalues">
	<div class="title">
	<h1><?php echo $html->image('tab_left.gif',array('class'=>'left'))?><?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  &nbsp;&nbsp;编辑资源&nbsp;&nbsp;</h1></div>
	  <div class="box">
		<dl><dt>资源名称: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){
		foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd>
			<input type="text" style="width:195px;border:1px solid #649776" id="name<?php echo $v['Language']['locale']?>" name="data[InformationResourceI18n][<?php echo $k?>][name]" /> <span><font color="#F90071">*</font>
		<input type="hidden" name="data[InformationResourceI18n][<?php echo $k?>][locale]" value="<?php echo $v['Language']['locale']?>" />
		</dd></dl>

		<?php }}?>
		<dl><dt>描述: </dt><dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){
		foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd>
		<input type="text" style="width:195px;border:1px solid #649776" id="name<?php echo $v['Language']['locale']?>" name="data[InformationResourceI18n][<?php echo $k;?>][description]" value=""/><span> <font color="#F90071">*</font>
		</dd></dl>
		<?php }}?>

	  </div>
     </div>
	</td>

<td align="left" width="50%" valign="top" style="padding-right:5px;padding-top:26px">
<div class="order_stat athe_infos configvalues">
	  <div class="box">
	  	<dl><dt>上级资源: </dt>
		<dd><select style="width:357px;*width:360px;border:1px solid #649776" name="data[InformationResource][parent_id]">
		<option value="0">顶级资源</option>
	<?php if(isset($resource_type) && sizeof($resource_type)>0){?>

		<?php  foreach($resource_type as $k=>$v){?>
		<option value="<?php echo $v['InformationResource']['id']?>" <?php if($v['InformationResource']['id'] == $this->data['InformationResource']['parent_id']) echo "selected";?>><?php echo $v['InformationResourceI18n']['name']?></option><?php }}?></select></dd></dl>

		<dl><dt>资源代码: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776" name="data[InformationResource][code]" value=""/></dd></dl>
		<dl><dt>资源值: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776" name="data[InformationResource][information_value]" value=""/></dd></dl>
	
		<dl><dt style="padding-top:2px">是否可用: </dt>
		<dd><input type="radio" name="data[InformationResource][status]" value="1" checked/> 是 <input type="radio" name="data[InformationResource][status]" value="0" /> 否</dd></dl>
		
		<dl><dt>排序: </dt>
		<dd><input type="text" style="width:113px;border:1px solid #649776" name="data[InformationResource][orderby]"  /><br /> 如果您不输入排序号，系统将默认为50</dd></dl>


<!--Menus_Config-->
	  <div class="shop_config menus_configs" style="width:auto;">
		
		</div>
<!--Menus_Config End-->
	  </div>
	  
	</div>	
	</td>
</tr>
</table>
	
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
<?php echo $form->end();?>
<!--ConfigValues End-->


</div>
<!--Main End-->
</div>