<?php 
/*****************************************************************************
 * SV-Cart 编辑Flashes
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
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('class'=>'vmiddle'))."flash列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>
<div class="home_main">
<?php echo $form->create('Flashe',array('action'=>'edit/'.$flashimage['FlashImage']['id']));?>
<div class="order_stat athe_infos configvalues" style="align:center">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑flash轮播</h1></div>
<div class="box">
<!--Mailtemplates_Config-->
<br /><br />
	  <div class="shop_config menus_configs">
		<dl><dt style="width:105px;">选择语言： </dt>
		<dd>
		<select style="width:80px;" name="data[FlashImage][locale]">
<?php if(isset($languages) && sizeof($languages)>0){
		foreach($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale'];?>" <?php if($flashimage['FlashImage']['locale'] == $v['Language']['locale']){ echo "selected"; }?> ><?php echo $v['Language']['name'];?></option>
		<?php }}?>
		</select>
		</dd></dl>
		<dl><dt style="width:105px;">类型： </dt>
		<dd>
		<select style="width:80px;" name="data[Flash][type]" id='flashType' onchange='typechange();'>
<?php if(isset($languages) && sizeof($languages)>0){
		 foreach($flashtypes as $k => $v){ ?>
			<option value="<?php echo $k;?>" <?php if($k==$flashimage['Flash']['type'])echo "selected";?>><?php echo $v;?></option>
		<?php }}?>		
		</select>
		
			<span id="selects"></span>
	

		</dd></dl>	
		<dl><dt style="width:105px;">标题： </dt>
		<dd><input type="text" style="width:280px;border:1px solid #649776" name="data[FlashImage][title]" value="<?php echo $flashimage['FlashImage']['title']?>" /></dd></dl>

			
			<dl><dt style="width:105px;">URL地址： </dt>
			<dd><input type="text" style="width:280px;border:1px solid #649776"  name="data[FlashImage][url]"  size= "35"  value="<?php echo $flashimage['FlashImage']['url']?>" />
			
			</dd></dl>

		<dl><dt style="width:105px;">图片显示： </dt>
		<dd><input type="text" style="width:280px;border:1px solid #649776"  name="data[FlashImage][image]"  size= "35" id="upload_img_text_1" value="<?php echo $flashimage['FlashImage']['image']?>" />
		<br /><br />
		<?php echo $html->image("/..{$flashimage['FlashImage']['image']}",array('id'=>'logo_thumb_img_1','height'=>'150','style'=>!empty($flashimage['FlashImage']['image'])?"display:block":"display:none"))?>
		</dd>
		<dd><?php echo $html->link($html->image('select_img.gif',array("height"=>"20","class"=>"vmiddle icons","title"=>$title_arr['select_img'])),"javascript:img_sel(1,'all')",'',false,false)?></dd>
		</dl>

		<?php if(!empty($flashimages['FlashImage'])) for($i=0;$i<=count($flashimages['FlashImage'])-1;$i++){?>
		<dl><dt style="width:105px;"></dt>
		<dd><?php echo $html->image($flashimages['FlashImage'][$i]['image'] ,array('class'=>'vmiddle','onclick'=>''))?> </dd>
		</dl>
	<?php }?>
	 

		<input type="hidden" style="width:280px;border:1px solid #649776" name="data[FlashImage][flash_id]" value="<?php echo $flashimage['FlashImage']['flash_id']?>" />
		<input type="hidden" style="width:280px;border:1px solid #649776" name="data[FlashImage][id]" value="<?php echo $flashimage['FlashImage']['id']?>" />
		<dl><dt style="width:105px;">描述： </dt>
		<dd><input type="text" style="width:280px;border:1px solid #649776" name="data[FlashImage][description]" value="<?php echo $flashimage['FlashImage']['description']?>" /></dd></dl>

		<dl style="padding-bottom:0"><dt style="width:105px;">排序： </dt>
		<dd><input type="text" style="width:100px;border:1px solid #649776" name="data[FlashImage][orderby]" value="<?php echo $flashimage['FlashImage']['orderby']?>" onkeyup="check_input_num(this)" />
			<p class="msg"> 如果您不输入排序号，系统将默认为50</p></dd></dl>	
		<dl style="margin-top:-4px;">
		<dt style="width:105px;">是否有效： </dt>
		<dd style="padding-top:3px;">
		<input type="radio" class="radio" name="data[FlashImage][status]" value="1" <?php if($flashimage['FlashImage']['status'] == "1"){ echo "checked";}?> />是
		<input type="radio" class="radio"  name="data[FlashImage][status]" value="0"  <?php if($flashimage['FlashImage']['status'] == "0"){ echo "checked";}?> />否</dd></dl>
		<br />
		
		</div>  	
<!--Mailtemplates_Config End-->
		
	  </div>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
</form>

<span style="display:none">
	<span id="select1">
<select  name="data[Flash][type_id]" id='bTypeId'>
<?php if(isset($b) && sizeof($b)>0){
	 foreach($b as $k => $v){?>
			<option value="<?php echo $k;?>" <?php if($k==$flashimage['Flash']['type_id'])echo "selected";?> ><?php echo $v;?></option>
		<?php }}?>
		</select>
</span>	<span id="select2">
		<select  name="data[Flash][type_id]" id='pcTypeId'>
<?php if(isset($pc) && sizeof($pc)>0){
	 foreach($pc as $k => $v){?>
			<option value="<?php echo $k;?>" <?php if($k==$flashimage['Flash']['type_id'])echo "selected";?> ><?php echo $v;?></option>
		<?php }}?>
		</select>
	</span>			<span id="select3">
		<select  name="data[Flash][type_id]" id='acTypeId'>
<?php if(isset($ac) && sizeof($ac)>0){
	 foreach($ac as $k => $v){?>
			<option value="<?php echo $k;?>" <?php if($k==$flashimage['Flash']['type_id'])echo "selected";?> ><?php echo $v;?></option>
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

window.onload=function(){
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