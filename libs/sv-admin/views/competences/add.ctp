<?php
/*****************************************************************************
 * SV-Cart 新增访问权限
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
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."访问权限列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<!--ConfigValues-->
<?php echo $form->create('competence',array('action'=>'/add/','onsubmit'=>'return competences_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑访问权限</h1></div>
	  <div class="box">
	  <input type="hidden" name="data[Operator_action][id]" />
<!--Competence_Config-->
	  <div class="shop_config menus_configs">
	  	<dl><dt>上级权限编号: </dt>
		<dd><input type="text" id="operatoraction_parentid" name="data[Operator_action][parent_id]" style="width:195px;border:1px solid #649776" onkeyup="check_input_num(this)" /> <font color="#F90071">*</font></dd></dl>
		
		<dl><dt>访问权限名称:  </dt>
		<dd></dd></dl>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<dl><dt><?=$html->image($v['Language']['img01'])?> </dt>
		<dd><input type="text" id="name<?=$v['Language']['locale']?>" name="data[Operator_actionI18n][<?=$k?>][name]"  style="width:195px;border:1px solid #649776" /> <font color="#F90071">*</font></dd></dl>
<?
	}
}?>		<dl><dt>访问权限备注:  </dt>
		<dd></dd></dl>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<dl><dt><?=$html->image($v['Language']['img01'])?> </dt>
		<dd><textarea style="width:353px;height:80px;" name="data[Operator_actionI18n][<?=$k;?>][descrption]" ></textarea></dd></dl>
<?
	}
}?>		
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input name="data[Operator_actionI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
<?
}	}
?>
		<dl><dt>权限代码: </dt>
		<dd><input type="text" name="data[Operator_action][code]"  style="width:355px;border:1px solid #649776" /></dd></dl>
		
		
		
		<dl><dt style="padding-top:2px">是否有效: </dt>
		<dd><input type="radio" name="data[Operator_action][status]" value="1" checked /> 是 <input type="radio" name="data[Operator_action][status]" value="0"  /> 否</dd></dl>
		
		<dl><dt>排序: </dt>
		<dd><input type="text" name="data[Operator_action][orderby]"  style="width:113px;border:1px solid #649776"  onkeyup="check_input_num(this)" /> <br />如果您不输入排序号，系统将默认为50</dd></dl>
		<br />
		
		</div>
<!--Competence_Config End-->
		
		
		
	  </div>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
<? echo $form->end();?>
<!--ConfigValues End-->


</div>
<!--Main End-->
<?=$html->image('content_left.gif',array('class'=>'content_left'))?><?=$html->image('content_right.gif',array('class'=>'content_right'))?>
</div>