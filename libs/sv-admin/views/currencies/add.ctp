<?php 
/*****************************************************************************
 * SV-Cart 插件管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!-- Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."货币列表","/currencies",'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('currencies',array('action'=>'/add/','name'=>"theForm","onsubmit"=>"return currencies_checks();","enctype"=>"multipart/form-data"));?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
	<td align="left" width="50%" valign="top" style="padding-right:5px">
	<div class="order_stat athe_infos configvalues">
	<div class="title">
	<h1><?php echo $html->image('tab_left.gif',array('class'=>'left'))?><?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  新增货币</h1></div>
	  <div class="box">
		<dl><dt style="width:105px;">货币名称： </dt>
		<dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<dl><dt style="width:105px;"><?php echo $html->image($v['Language']['img01'])?> </dt>
		<dd><input type="text" style="width:300px;border:1px solid #649776" name="data[CurrencyI18n][<?php echo $k;?>][name]" id="currency_name"  /> <font color="#ff0000" >*</font></dd></dl>
	  	<?php }}?>
	  	<dl><dt style="width:105px;">货币格式： </dt>
		<dd></dd></dl>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
	  	<dl><dt style="width:105px;"><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd><input type="text" style="width:300px;border:1px solid #649776" name="data[CurrencyI18n][<?php echo $k;?>][format]" id="currency_format"  /> <font color="#ff0000" >*</font></dd></dl>
	  	<?php }}?>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<input type="hidden" style="width:300px;border:1px solid #649776" name="data[CurrencyI18n][<?php echo $k;?>][locale]" id="currency_format"  value="<?php echo $v['Language']['locale'];?>" />
	  	<?php }}?>
	  	<dl><dt style="width:105px;">语言货币： </dt>
		<dd></dd></dl>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
	  	<dl><dt style="width:105px;"><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd><input type="radio" name="data[CurrencyI18n][<?php echo $k;?>][status]" value="1"   checked  /><label>有效</label><input type="radio" value="0"  name="data[CurrencyI18n][<?php echo $k;?>][status]"      /><label>无效</label></dd></dl>
		<?php }}?>
		</div>
     </div>
	</td>

<td align="left" width="50%" valign="top" style="padding-right:5px;padding-top:26px">
<div class="order_stat athe_infos configvalues">
	  <div class="box">

		<input type="hidden" style="width:300px;border:1px solid #649776" name="data[Currency][id]"   />
	  	<dl><dt style="width:105px;">货币代码： </dt>
		<dd><input type="text" style="width:300px;border:1px solid #649776" name="data[Currency][code]" id="currency_code"  /> <font color="#ff0000" >*</font></dd></dl>
	  	<dl><dt style="width:105px;">汇率： </dt>
		<dd><input type="text" style="width:300px;border:1px solid #649776" name="data[Currency][rate]" id="currency_rate"    /> <font color="#ff0000" >*</font></dd></dl>
	  	<dl><dt style="width:105px;">是否默认： </dt>
		<dd><input type="radio" name="data[Currency][is_default]" value="1" checked /><label>是</label><input type="radio" name="data[Currency][is_default]" value="0"  /><label>否</label></dd></dl>
	  	<dl><dt style="width:105px;">是否有效： </dt>
		<dd><input type="radio" name="data[Currency][status]" value="1" checked /><label>是</label><input type="radio" name="data[Currency][status]" value="0"  /><label>否</label></dd></dl>

<!--Menus_Config-->
	  <div class="shop_config menus_configs" style="width:auto;">
		</div>
<!--Menus_Config End-->
	  </div>
	</div>	
	</td>
</tr>
</table>
	  <p class="submit_values"><input type="submit" style="cursor:pointer;"  value="确 定" /><input type="reset" value="重 置" style="cursor:pointer;"  /></p>
	</div>
<?php echo $form->end();?>
</div>
<!--Main End-->
</div>
<style>
label{vertical-align:middle}
.inputcheckboxradio{vertical-align:middle;}
body{font-family:tahoma;font-size:12px;}
</style>

<script type="text/javascript">
//用户设置管理
function currencies_checks(){
	var currency_name = GetId("currency_name");
	var currency_code = GetId("currency_code");
	var currency_format = GetId("currency_format");
	var currency_rate = GetId("currency_rate");
	if( Trim(currency_name.value,'g') == "" ){
		layer_dialog();
		layer_dialog_show("货币名称不能为空!","",3);
		return false;
	}
	if( Trim(currency_code.value,'g') == "" ){
		layer_dialog();
		layer_dialog_show("货币代码不能为空!","",3);
		return false;
	}
	if( Trim(currency_format.value,'g') == "" ){
		layer_dialog();
		layer_dialog_show("货币格式不能为空!","",3);
		return false;
	}
	if( Trim(currency_rate.value,'g') == "" ){
		layer_dialog();
		layer_dialog_show("汇率不能为空!","",3);
		return false;
	}
}


</script>