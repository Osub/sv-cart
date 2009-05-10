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
 * $Id: add.ctp 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
?>
<div class="content">
	<?php //pr($this->data);pr($parentmenu);?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories"><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."菜单列表","./",array(),false,false);?></p>

<div class="home_main">
<!--ConfigValues-->
<?php echo $form->create('Menu',array('action'=>'add/'.$this->data['Operator_menu']['id'],'onsubmit'=>'return menus_check()'));?>
	<input id="Operator_emnuId" name="data[Operator_menu][id]" type="hidden" value="<?= $newid;?>">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  &nbsp;编辑菜单&nbsp;</h1></div>
	  <div class="box">
	  
<!--Menus_Config--><? //pr($parentmenu);?>
	  <div class="shop_config menus_configs">
	  	<dl><dt>上级菜单: </dt>
		<dd><select style="width:357px;*width:360px;border:1px solid #649776" name="data[Operator_menu][parent_id]">
		<option value="000">顶级菜单</option>
	<? if(isset($parentmenu) && sizeof($parentmenu)>0){?>

		<?php  foreach($parentmenu as $k=>$v){?>
		<option value="<?php echo $v['Operator_menu']['id']?>" <?php if($v['Operator_menu']['id'] == $this->data['Operator_menu']['parent_id']) echo "selected";?>><?php echo $v['Operator_menuI18n']['name']?></option><?php }}?></select></dd></dl>
		
		<dl><dt>菜单名称: </dt>
		<dd>
		</dd></dl>
		<? if(isset($languages) && sizeof($languages)>0){
		foreach ($languages as $k => $v){?>
		<dl><dt><?=$html->image($v['Language']['img01'])?></dt>
		<dd>
			<input type="text" style="width:195px;border:1px solid #649776" id="name<?=$v['Language']['locale']?>" name="data[Operator_menuI18n][<?=$k?>][name]" /> <span><font color="#F90071">*</font>
		<input type="hidden" name="data[Operator_menuI18n][<?=$k?>][locale]" value="<?=$v['Language']['locale']?>" />
		</dd></dl>

		
		<?}}?>
		<dl><dt>菜单权限代码: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776" name="data[Operator_menu][operator_action_code]" /></dd></dl>
		
		<dl><dt>链接地址: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776" name="data[Operator_menu][link]" /></dd></dl>
		
		<dl><dt style="padding-top:2px">是否显示: </dt>
		<dd><input type="radio" name="data[Operator_menu][status]" value="1" checked/> 是 <input type="radio" name="data[Operator_menu][status]" value="0" /> 否</dd></dl>
		
		<dl><dt>排序: </dt>
		<dd><input type="text" style="width:113px;border:1px solid #649776" name="data[Operator_menu][orderby]"  /><br /> 如果您不输入排序号，系统将默认为50</dd></dl>
		<br />
		
		</div>
<!--Menus_Config End-->
		
		
		
	  </div>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
<? echo $form->end();?>
<!--ConfigValues End-->


</div>
<!--Main End-->
</div>