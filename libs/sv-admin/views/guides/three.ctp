<?php
/*****************************************************************************
 * SV-Cart 商店设置向导
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: three.ctp 1156 2009-04-30 09:16:36Z huangbo $
*****************************************************************************/
?>
<?php echo $form->create('guides',array('action'=>'/four/'));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<div class="home_main" id="guides_1">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?=$html->image('tab_left.gif',array('class'=>'left'))?>
	<?=$html->image('tab_right.gif',array('class'=>'right'))?>
	添加商品分类</h1></div>
	<div class="box">
	<div class="shop_config menus_configs guides" style="width:600px;">
	
	<dl><dt style="width:80px;">分类名称： </dt>
	<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="Categorie_name" name="data[Categorie][CategorieI18n][name]" /></dd>&nbsp<font color="#ff0000" >*</font></dl>

	<dl><dt style="width:80px;">关键字： </dt>
	<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="Categorie_keywords" name="data[Categorie][CategorieI18n][meta_keywords]" />&nbsp<?=$html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:hid_show('meta_keywords');",'',false,false)?></dd><span id="meta_keywords" style="display:none">填写关键字便于用户搜索</span></dl>

	<dl><dt style="width:80px;">分类描述： </dt>
	<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="Categorie_description" name="data[Categorie][CategorieI18n][meta_description]" /></dd></dl>
	
	</div>
	</div>
	<p class="submit_btn"><input type="button" value="上一步" onclick="history.go(-1)" /><input type="submit" value="下一步"  /><input type="button" value="退出向导" onclick="break_config()" /></p>
	</div>
</div>
<script type="text/javascript">
function hid_show(name){
	var name_obj = document.getElementById(name);
	if( name_obj.style.display == "none" ){
		name_obj.style.display = "block";
	}else{
		name_obj.style.display = "none";
	}
}

</script>