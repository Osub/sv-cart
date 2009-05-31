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
 * $Id: four.ctp 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
?>
<?php echo $form->create('guides',array('action'=>'/guides_end/'));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<div class="home_main" id="guides_1">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?=$html->image('tab_left.gif',array('class'=>'left'))?>
	<?=$html->image('tab_right.gif',array('class'=>'right'))?>
	添加商品</h1></div>
	<div class="box">
	<div class="shop_config menus_configs">
	<dl><dt style="width:240px;">商品分类： </dt><dd>
<select class="all" name="category_id" id="category_id">
	<option value="0">所有分类</option>
<?if(isset($categories_tree) && sizeof($categories_tree)>0){?><?foreach($categories_tree as $first_k=>$first_v){?>
<option value="<?=$first_v['Category']['id'];?>" ><?=$first_v['CategoryI18n']['name'];?></option>
<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?=$second_v['Category']['id'];?>">&nbsp;&nbsp;<?=$second_v['CategoryI18n']['name'];?></option>
<?if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?=$third_v['Category']['id'];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?=$third_v['CategoryI18n']['name'];?></option>
<?}}}}}}?>
	</select></dd></dl>
	<dl><dt style="width:240px;">商品名称： </dt>
	<dd></dd></dl>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:240px;"><?=$html->image($v['Language']['img01'])?></dt>
	<dd><input type="text" style="width:250px;*width:180px;border:1px solid #649776" name="data[Product][ProductI18n][<?=$k?>][name]" />&nbsp<font color="#ff0000" >*</font></dd></dl>
<?}}?>
<!--
	<dl><dt style="width:240px;">商品数量： </dt>
	<dd><input type="text" style="width:75px;*width:180px;border:1px solid #649776" name="data[Product][Product][quantity]"/></dd></dl>
	-->
	<!--<dl><dt style="width:240px;">商品品牌： </dt>
	<dd><input type="text" style="width:250px;*width:180px;border:1px solid #649776" name="data[Brand][BrandI18n][name]" /></dd></dl>
-->
	<dl><dt style="width:240px;">本店售价：</dt>
	<dd><input type="text" style="width:250px;*width:180px;border:1px solid #649776" name="data[Product][Product][shop_price]"/></dd></dl>
	
	<dl><dt style="width:240px;">加入推荐： </dt>
	<dd><input type="checkbox"  value="1" name="data[Product][Product][recommand_flag]" checked />推荐</dd></dl>
	<dl><dt style="width:240px;">商品描述： </dt>
	<dd></dd></dl>

<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input name="data[Product][ProductI18n][<?=$k?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">

	<dl><dt style="width:240px;"><?=$html->image($v['Language']['img01'])?></dt>
	<dd><textarea style="width:250px;border:1px solid #649776;height:110px;" name="data[Product][ProductI18n][<?=$k?>][meta_description]" /></textarea></dd></dl>
<?}}?>
	</div>
	</div>
		
	<input id="to_continue" name="to_continue" type="hidden" value="no">
	<p class="submit_btn"><input type="button" value="上一步" onclick="history.go(-1)" /><input type="submit" value="继续添加商品" onclick="to_continues()" /><input type="submit" value="完成向导"  /><input type="button" value="退出向导" onclick="break_config()" /></p>
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
function to_continues(){
	document.getElementById('to_continue').value = "yes";
}
</script>