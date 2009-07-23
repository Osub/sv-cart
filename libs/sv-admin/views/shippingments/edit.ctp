<?php 
/*****************************************************************************
 * SV-Cart  配送方式编辑
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
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!-- Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."配送方式列表","/shippingments/",'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('shippingments',array('action'=>'edit/'.$Shipping_info['Shipping']['id'],'onsubmit'=>''));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑配送方式</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
	  	<dl><dt style="width:200px;">配送方式名称： </dt>
		<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){?>
<?php foreach ($languages as $k => $v){?>
	  	<dl><dt style="width:200px;"><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776"  name="data[ShippingI18n][<?php echo $k?>][name]" value="<?php echo @$Shipping_info['ShippingI18n'][$v['Language']['locale']]['name']?>" /> <font color="#ff0000">*</font></dd></dl>
<input type="hidden" style="width:357px;*width:180px;border:1px solid #649776"  name="data[ShippingI18n][<?php echo $k?>][locale]" value="<?php echo $v['Language']['locale']?>" />
<input type="hidden" style="width:357px;*width:180px;border:1px solid #649776"  name="data[ShippingI18n][<?php echo $k?>][id]" value="<?php echo @$Shipping_info['ShippingI18n'][$v['Language']['locale']]['id']?>" />
		<?php }}?>
		<dl><dt style="width:200px;">保价费用： </dt>
		<dd><input type="text" style="width:90px;*width:180px;border:1px solid #649776" name="data[Shipping][insure_fee]" value="<?php echo @$Shipping_info['Shipping']['insure_fee']?>" /> <font color="#ff0000">*</font></dd></dl>
		<dl><dt style="width:200px;">货到付款： </dt>
		<dd><input type="radio" name="data[Shipping][support_cod]" value="1" <?php if(@$Shipping_info['Shipping']['support_cod']==1){ echo "checked";}?>  />是<input type="radio" name="data[Shipping][support_cod]" value="0" <?php if(@$Shipping_info['Shipping']['support_cod']==0){ echo "checked";}?>  />否 <font color="#ff0000">*</font></dd></dl>
		
		<?php if(isset($php_code) && sizeof($php_code)>0){?>
			<?php foreach($php_code as $k=>$v){?>
		<dl><dt style="width:200px;"><?php echo $v['name']?>： </dt>
		<dd><input type="text" style="width:90px;*width:180px;border:1px solid #649776" name="data[php_code][<?php echo $k?>][value]" value="<?php echo $v['value']?>" />
		<input type="hidden" style="width:90px;*width:180px;border:1px solid #649776" name="data[php_code][<?php echo $k?>][name]" value="<?php echo $v['name']?>" />
		</dd></dl>
			<?php }?>
		<?php }?>		
		
		
		<dl><dt style="width:200px;">配送方式描述： </dt>
		<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){?>
<?php foreach ($languages as $k => $v){?>
		<dl><dt style="width:200px;"><?php echo $html->image($v['Language']['img01'])?> </dt>
		<dd></dd><textarea style="width:357px;*width:180px;border:1px solid #649776"  name="data[ShippingI18n][<?php echo $k?>][description]" ><?php echo @$Shipping_info['ShippingI18n'][$v['Language']['locale']]['description']?></textarea></dl>
<?php }}?>
		</div>
<!--Mailtemplates_Config End-->
	  </div>
	  <p class="submit_values"><input type="submit" value="确 定" /><input type="reset" value="重 置" /></p>
	</div>
<?php echo $form->end();?>


</div>
<!--Main End-->
</div>
