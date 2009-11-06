<?php 
/*****************************************************************************
 * SV-Cart  查看编辑商品类型
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: lookedit.ctp 4996 2009-10-14 02:06:44Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->

<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'属性列表','/productstypes/look/'.$product_type_id,'',false,false)?> </strong></p>
<div class="home_main">
<?php echo $form->create('Productstype',array('action'=>'/lookedit/'.$attribute['ProductTypeAttribute']['id']."/".$product_type_id,'onsubmit'=>'return products_attribute();'));?>
<div class="order_stat athe_infos configvalues">
	<input type="hidden" name="data[ProductTypeAttribute][id]" value="<?php echo $attribute['ProductTypeAttribute']['id']?>">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑属性</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
	  	<dl><dt style="width:105px;">属性名称: </dt>
		<dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){
			foreach ($languages as $k => $v){?>
			<dl><dt style="width:105px;"><?php echo $html->image($v['Language']['img01'])?></dt>
				<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="attribute_name_<?php echo $v['Language']['locale']?>" name="data[ProductTypeAttributeI18n][<?php echo $k?>][name]" value="<?php echo @$attribute['ProductTypeAttributeI18n'][$v['Language']['locale']]['name']?>" /> <font color="#F90071">*</font></dd></dl>
						<input type="hidden" name="data[ProductTypeAttributeI18n][<?php echo $k?>][locale]" value="<?php echo $v['Language']['locale']?>" />
				
		<?php }}?>
		<dl><dt style="width:105px;">编码: </dt>
		<dd class="lang_if"><input  name="data[ProductTypeAttribute][code]" style="border:1px solid #649776" value="<?php echo $attribute['ProductTypeAttribute']['code']?>" /></dd></dl>

		<input type="hidden" name="back_id" value="<?php echo $product_type_id?>" />
			<dl><dt style="width:105px;">所属商品类型: </dt>
		<dd>
		<select name="data[ProductTypeAttribute][product_type_id]">
		 <option value="0" <?php if($attribute['ProductTypeAttribute']['product_type_id']=="0"){echo "selected";}?> >公共属性</option>
			<?php if(isset($ProductType_info) && sizeof($ProductType_info)>0){?>	
		<?php foreach($ProductType_info as $k=>$v){?>
				<option value='<?php echo $v["ProductType"]["id"];?>' <?php if( $v["ProductType"]["id"] == $attribute['ProductTypeAttribute']['product_type_id']){ echo "selected"; }?>><?php echo $v["ProductTypeI18n"]["name"];?></option>
		<?php }}?>	
		</select>
		</dd></dl>
		<dl><dt style="width:105px;">属性类型: </dt>
		<dd>
		<select name="data[ProductTypeAttribute][type]">
		<?php foreach($systemresource_info["property_type"] as $k=>$v){?>
				<option value="<?php echo $k?>" <?php if($attribute['ProductTypeAttribute']['type']==$k){echo "selected";}?> ><?php echo $v?></option>
		<?php }?>		
		</select>
		</dd></dl>



		<dl><dt style="width:105px;">属性是否可选: </dt>
		<dd><input type="radio" value="1" name="data[ProductTypeAttribute][attr_type]" <?php if(	$attribute['ProductTypeAttribute']['attr_type'] ==1){ echo "checked"; }?> /><label>是</label> <input type="radio" value="0" name="data[ProductTypeAttribute][attr_type]" <?php if(	$attribute['ProductTypeAttribute']['attr_type'] ==0){ echo "checked"; }?> /><label>否</label></dd></dl>
		
		
		<dl><dt style="width:105px;">属性值录入方式: </dt>
		<dd class="lang_if">
			<input type="radio" style="border: 0pt none ; width: auto;" value="0" name="data[ProductTypeAttribute][attr_input_type]" <?php if(	$attribute['ProductTypeAttribute']['attr_input_type'] ==0){ echo "checked"; }?>><label>手工录入  </label>
			<input type="radio" style="border: 0pt none ; width: auto;" value="1" name="data[ProductTypeAttribute][attr_input_type]" <?php if(	$attribute['ProductTypeAttribute']['attr_input_type'] ==1){ echo "checked"; }?>><label>从下面的列表中选择（一行代表一个可选值） </label>
			<input type="radio" style="border: 0pt none ; width: auto;" value="2" name="data[ProductTypeAttribute][attr_input_type]" <?php if(	$attribute['ProductTypeAttribute']['attr_input_type'] ==2){ echo "checked"; }?>><label>多行文本框 </label></dd></dl>
		<dl><dt style="width:105px;">默认值：</dt>
			<dd><input type="text" style="width:360px;border:1px solid #649776;" name="data[ProductTypeAttribute][default_value]" value="<?php echo $attribute['ProductTypeAttribute']['default_value']?>"></dd></dl>
		<dl><dt style="width:105px;">可选值列表：</dt>
			<dd><textarea style="height:120px;width:360px;border:1px solid #649776;"  name="data[ProductTypeAttribute][attr_value]"><?php echo $attribute['ProductTypeAttribute']['attr_value']?></textarea></dd></dl>
			<dl><dt style="width:105px;">是否有效：</dt>
			<dd><input type="radio" name="data[ProductTypeAttribute][status]" value="1" <?php if($attribute['ProductTypeAttribute']['status'] == 1){echo "checked";}?> /><label>是</label><input type="radio" name="data[ProductTypeAttribute][status]" value="0" <?php if($attribute['ProductTypeAttribute']['status'] == 0){echo "checked";}?> /><label>否</label></dd></dl>
	
		<dl><dt style="width:105px;">排序：</dt>
			<dd><input  name="data[ProductTypeAttribute][orderby]" style="border:1px solid #649776" value="<?php echo $attribute['ProductTypeAttribute']['orderby']?>" onkeyup="check_input_num(this)"  /><br />如果您不输入排序号，系统将默认为50</dd></dl>
		<br />
		</div>
<!--Mailtemplates_Config End-->
		
		
		
	  </div>
	  <p class="submit_values"><input type="submit" value="确 定" /><input type="reset" value="重 置" /></p>
	</div>
<?php echo $form->end();?>


</div>
<!--Main End-->
</div>
<style>
label{vertical-align:middle}
body{font-family:tahoma;font-size:12px;}
</style>