<?php 
/*****************************************************************************
 * SV-Cart 添加Flashes
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
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."flash列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('Flashe',array('action'=>'add/'));?>
<div class="order_stat athe_infos configvalues" style="align:center">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  新增flash轮播</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
		<dl><dt style="width:105px;">选择语言： </dt>
		<dd>
		<select style="width:80px;" name="data[FlashImage][locale]">
<?php if(isset($languages) && sizeof($languages)>0){
		 foreach($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale'];?>"  ><?php echo $v['Language']['name'];?></option>
		<?php }}?>
		</select>
			</dd></dl>
		<dl><dt style="width:105px;">类型： </dt>
		<dd>
		<select style="width:80px;" name="data[Flash][type]" id='flashType' onchange='typechange();'>
		<?php if(@isset($languages) && sizeof($languages)>0){foreach(@$flashtypes as $k => $v){?>
			<option value="<?php echo $k;?>" ><?php echo $v;?></option>
		<?php }}?>		
		</select>
		<span id="selects"></span>
		</dd></dl>
		<dl><dt style="width:105px;">标题： </dt>
		<dd><input type="text" style="width:280px;*width:180px;border:1px solid #649776" name="data[FlashImage][title]"  /></dd></dl>
		<dl><dt style="width:105px;">URL地址：</dt><dd><input type="text" style="width:280px;*width:180px;border:1px solid #649776" name="data[FlashImage][url]"   size= "35" /></dd></dl>
		<dl><dt style="width:105px;">图片显示： </dt>
		<dd><input type="text" style="width:280px;*width:180px;border:1px solid #649776" name="data[FlashImage][image]" id="upload_img_text_1" size= "35" />
			<?php echo @$html->image('',array('id'=>'logo_thumb_img_1','style'=>'display:none'))?>
		</dd><dd><?php echo $html->link($html->image('select_img.gif',array("height"=>"20","class"=>"vmiddle icons","title"=>$title_arr['select_img'])),"javascript:img_sel(1,'home')",'',false,false)?></dd></dl>
		<dl><dt style="width:105px;">描述： </dt>
		<dd><input type="text" style="width:280px;*width:180px;border:1px solid #649776" name="data[FlashImage][description]"  /></dd></dl>
		<dl><dt style="width:105px;">排序： </dt>
		<dd><input type="text" style="width:100px;*width:180px;border:1px solid #649776" name="data[FlashImage][orderby]" onkeyup="check_input_num(this)"  /><p class="msg">如果您不输入排序号，系统将默认为50</p></dd></dl>	
		<dl><dt style="width:105px;">是否有效： </dt>
		<dd><input type="radio" name="data[FlashImage][status]" value="1" checked />是<input type="radio"  name="data[FlashImage][status]" value="0"   />否</dd></dl>	
		</div>  	
<!--Mailtemplates_Config End-->
	  </div>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
</form>

<span style="display:none">
	<span id="select1">
<select style="width:80px;" name="data[Flash][type_id]" id='bTypeId'>
<?php if(isset($b) && sizeof($b)>0){
	 foreach($b as $k => $v){?>
			<option value="<?php echo $k;?>" ><?php echo $v;?></option>
		<?php }}?>
		</select>
</span>	<span id="select2">
		<select style="width:80px;" name="data[Flash][type_id]" id='pcTypeId'>
<?php if(isset($pc) && sizeof($pc)>0){
	 foreach($pc as $k => $v){?>
			<option value="<?php echo $k;?>" ><?php echo $v;?></option>
		<?php }}?>
		</select>
	</span>			<span id="select3">
		<select style="width:80px;" name="data[Flash][type_id]" id='acTypeId'>
<?php if(isset($ac) && sizeof($ac)>0){
	foreach($ac as $k => $v){?>
			<option value="<?php echo $k;?>" ><?php echo $v;?></option>
		<?php }}?>
</select>
</span>
</span>
<script type='text/javascript'>

function typechange(){
	var	selects = document.getElementById('selects');
	var	select1 = document.getElementById('select1');
	var	select2 = document.getElementById('select2');
	var select3 = document.getElementById('select3');
	var type = document.getElementById('flashType');
	switch(type.value){
		case 'B':selects.innerHTML = select1.innerHTML;break;
		case 'PC':selects.innerHTML = select2.innerHTML;break;
		case 'AC':selects.innerHTML = select3.innerHTML;break;
		default:selects.innerHTML = "";
	}
}
</script>
</div>
<!--Main End-->
</div>
<style>
<!--
#logo_thumb_img_1{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;
width:220px;height:100px;
}
-->
</style>