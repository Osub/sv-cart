<?php 
/*****************************************************************************
 * SV-Cart 编辑菜单
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories"><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."资源列表","/information_resources/",array(),false,false);?></p>

<div class="home_main">
<!--ConfigValues-->
<?php echo $form->create('InformationResource',array('action'=>'edit/'.$this->data['InformationResource']['id'],'onsubmit'=>'return menus_check()'));?>
	<input id="Operator_emnuId" name="data[InformationResource][id]" type="hidden" value="<?php echo  $this->data['InformationResource']['id'];?>">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
	<td align="left" width="50%" valign="top" style="padding-right:5px">
	<div class="order_stat athe_infos configvalues">
	<div class="title">
	<h1><?php echo $html->image('tab_left.gif',array('class'=>'left'))?><?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑资源</h1></div>
	  <div class="box">
		<dl><dt>资源名称: </dt><dd></dd></dl>		
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd>
		<input type="text" style="width:195px;border:1px solid #649776" id="name<?php echo $v['Language']['locale']?>" name="data[InformationResourceI18n][<?php echo $k;?>][name]" value="<?php if(isset($this->data['InformationResourceI18n'][$v['Language']['locale']]['name'])){echo $this->data['InformationResourceI18n'][$v['Language']['locale']]['name'];}?>"/><span> <font color="#F90071">*</font>
		<input type="hidden" name="data[InformationResourceI18n][<?php echo $k?>][locale]" value="<?php echo $v['Language']['locale']?>" />
		<input id="InformationResourceI18n<?php echo $k;?>Id" name="data[InformationResourceI18n][<?php echo $k;?>][id]" type="hidden" value="<?php if(isset($this->data['InformationResourceI18n'][$v['Language']['locale']]['id'])){ echo $this->data['InformationResourceI18n'][$v['Language']['locale']]['id'];}?>">
		<input id="InformationResourceI18n<?php echo $k;?>InformationResourceI18nId" name="data[InformationResourceI18n][<?php echo $k;?>][resource_id]" type="hidden" value="<?php if(isset($this->data['InformationResourceI18n'][$v['Language']['locale']]['resource_id'])){ echo $this->data['InformationResourceI18n'][$v['Language']['locale']]['resource_id'];}?>">
		</dd></dl>
		<?php }}?>
		<dl><dt>描述: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd>
		<input type="text" style="width:195px;border:1px solid #649776" id="name<?php echo $v['Language']['locale']?>" name="data[InformationResourceI18n][<?php echo $k;?>][description]" value="<?php if(isset($this->data['InformationResourceI18n'][$v['Language']['locale']]['description'])){echo $this->data['InformationResourceI18n'][$v['Language']['locale']]['description'];}?>"/><span> <font color="#F90071">*</font>
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
		<option value="000">顶级资源</option>
		<?php if(isset($parentmenu) && sizeof($parentmenu)>0){foreach($parentmenu as $k=>$v){?>
		<option value="<?php echo $v['InformationResource']['id']?>" <?php if($this->data['InformationResource']['parent_id'] == $v['InformationResource']['id']){?>selected<?php }?>><?php echo $v['InformationResourceI18n']['name']?></option><?php }}?></select>
		</dd></dl>
		<dl><dt>资源代码: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776" name="data[InformationResource][code]" value="<?php echo $this->data['InformationResource']['code']?>"/></dd></dl>
		<dl><dt>资源值: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776" name="data[InformationResource][information_value]" value="<?php echo $this->data['InformationResource']['information_value']?>"/></dd></dl>
		<dl><dt style="padding-top:2px">是否可用: </dt>
		<dd><input type="radio" class="radio" name="data[InformationResource][status]" value="1" <?php if($this->data['InformationResource']['status'])echo "checked";?>/>是<input type="radio" class="radio" name="data[InformationResource][status]" value="0" <?php if(!$this->data['InformationResource']['status'])echo "checked"?>/>否</dd></dl>
		<dl><dt>排序: </dt>
		<dd><input type="text" style="width:113px;border:1px solid #649776" name="data[InformationResource][orderby]" value="<?php echo $this->data['InformationResource']['orderby']?>" onkeyup="check_input_num(this)"/><p class="msg">如果您不输入排序号，系统将默认为50<p/> </dd></dl>
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