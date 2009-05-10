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
 * $Id: area_edit.ctp 1106 2009-04-28 07:43:39Z zhengli $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!-- Main Start-->
<br />
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."配送方式列表","/shippingments/",'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('shippingments',array('action'=>'edit/'.$Shipping_info['Shipping']['id'],'onsubmit'=>''));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑配送方式</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
		<input type="hidden"  name="data[ShippingI18n][id]" value="<?=@$Shipping_info['ShippingI18n']['id']?>" />
	  	<dl><dt style="width:200px;">配送方式名称： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776"  name="data[ShippingI18n][name]" value="<?=@$Shipping_info['ShippingI18n']['name']?>" /> <font color="#ff0000">*</font></dd></dl>
		<dl><dt style="width:200px;">保价费用： </dt>
		<dd><input type="text" style="width:90px;*width:180px;border:1px solid #649776" name="data[Shipping][insure_fee]" value="<?=@$Shipping_info['Shipping']['insure_fee']?>" /> <font color="#ff0000">*</font></dd></dl>
		<dl><dt style="width:200px;">货到付款： </dt>
		<dd><input type="radio" name="data[Shipping][support_cod]" value="1" <?if(@$Shipping_info['Shipping']['support_cod']==1){ echo "checked";}?>  />是<input type="radio" name="data[Shipping][support_cod]" value="0" <?if(@$Shipping_info['Shipping']['support_cod']==0){ echo "checked";}?>  />否 <font color="#ff0000">*</font></dd></dl>
		
		<dl><dt style="width:200px;">配送方式描述： </dt>
		<dd></dd><textarea style="width:357px;*width:180px;border:1px solid #649776"  name="data[ShippingI18n][description]" ><?=@$Shipping_info['ShippingI18n']['description']?></textarea></dl>
		
		</div>
<!--Mailtemplates_Config End-->
	  </div>
	  <p class="submit_values"><input type="submit" value="确 定" /><input type="reset" value="重 置" /></p>
	</div>
<? echo $form->end();?>


</div>
<!--Main End-->
</div>
