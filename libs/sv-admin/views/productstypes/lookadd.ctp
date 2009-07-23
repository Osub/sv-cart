<?php 
/*****************************************************************************
 * SV-Cart  查看添加商品类型
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: lookadd.ctp 2485 2009-06-30 11:33:00Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'属性列表','/productstypes/look/'.$id,'',false,false)?> </strong></p>

<div class="home_main">
<?php echo $form->create('Productstype',array('action'=>'/lookadd/'.$id,'onsubmit'=>'return products_attribute();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑属性</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
	  	<dl><dt style="width:105px;">属性名称: </dt>
		<dd></dd></dl>
	<?php if(is_array($languages)){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:105px;"><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="attribute_name_<?php echo $v['Language']['locale']?>" name="data[ProductTypeAttributeI18n][<?php echo $k?>][name]"  /> <font color="#F90071">*</font></dd></dl>
		<input type="hidden" name="data[ProductTypeAttributeI18n][<?php echo $k?>][locale]" value="<?php echo $v['Language']['locale']?>" />

<?php }
		}?>
		<input type="hidden" name="back_id" value="<?php echo $id?>" />
			
			<dl><dt style="width:105px;">所属商品类型: </dt>
		<dd>
		<select name="data[ProductTypeAttribute][product_type_id]">
		<?php foreach($ss as $k=>$v){?>
				<option value="<?php echo $k?>" <?php if($id==$k){echo "selected";}?> ><?php echo $v?></option>
		<?php }?>		
		</select>
		</dd></dl>
				


		<dl><dt style="width:105px;">属性是否可选: </dt>
		<dd><input type="radio" value="1" name="data[ProductTypeAttribute][attr_type]" checked />是 <input type="radio" value="0" name="data[ProductTypeAttribute][attr_type]" />否</dd></dl>
		
		
		<dl><dt style="width:105px;">该属性值的录入方式: </dt>
		<dd><input type="radio" value="0" name="data[ProductTypeAttribute][attr_input_type]" checked >手工录入  
			<input type="radio" value="1" name="data[ProductTypeAttribute][attr_input_type]" >从下面的列表中选择（一行代表一个可选值）
			<input type="radio" value="2" name="data[ProductTypeAttribute][attr_input_type]" >多行文本框</dd></dl>
		
		<dl><dt style="width:105px;">可选值列表：</dt>
			<dd><textarea name="data[ProductTypeAttribute][attr_value]"></textarea></dd></dl>
		<dl><dt style="width:105px;">是否有效：</dt>
			<dd><input type="radio" name="data[ProductTypeAttribute][status]" value="1"checked />是<input type="radio" name="data[ProductTypeAttribute][status]" value="0" />否</dd></dl>
		<dl><dt style="width:105px;">排序：</dt>
			<dd><input  name="data[ProductTypeAttribute][orderby]" onkeyup="check_input_num(this)"  /><br /> 如果您不输入排序号，系统将默认为50</dd></dl>
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