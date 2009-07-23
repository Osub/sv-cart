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
 * $Id: index.ctp 2485 2009-06-30 11:33:00Z huangbo $
*****************************************************************************/
?>
<?php echo $form->create('guides',array('action'=>'/two/'));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<div class="home_main" id="guides_1">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	<?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	商店基础信息设置</h1></div>
	<div class="box">
	<div class="shop_config menus_configs guides" style="width:500px;">
	<br />
	
	<dl><dt style="width:100px;">商店名称： </dt>
	<dd></dd></dl>
	
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:100px;"><?php echo $html->image($v['Language']['img01'])?></dt>
	<dd><input type="text" style="width:300px;*width:180px;border:1px solid #649776" name="data[ConfigI18n][shop_name][<?php echo $k?>][value]"  value="<?php echo $config_info['shop_name']['ConfigI18n'][$k]['value']?>" />&nbsp<?php echo $html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:hid_show('shop_name_".$v['Language']['locale']."')",'',false,false)?></dd><span id="shop_name_<?php echo $v['Language']['locale']?>" style="display:none"><?php echo $config_info['shop_name']['ConfigI18n'][$k]['description']?></span></dl>
		<input type="hidden" name="data[ConfigI18n][shop_name][<?php echo $k?>][id]" value="<?php echo $config_info['shop_name']['ConfigI18n'][$k]['id']?>" />
<?php }}?>
	<dl><dt style="width:100px;">商店标题： </dt>
	<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:100px;"><?php echo $html->image($v['Language']['img01'])?></dt>
	<dd><input type="text" style="width:300px;*width:180px;border:1px solid #649776" name="data[ConfigI18n][shop_title][<?php echo $k?>][value]" value="<?php echo $config_info['shop_title']['ConfigI18n'][$k]['value']?>" />&nbsp<?php echo $html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:hid_show('shop_title_".$v['Language']['locale']."')",'',false,false)?></dd><span id="shop_title_<?php echo $v['Language']['locale']?>" style="display:none"><?php echo $config_info['shop_title']['ConfigI18n'][$k]['description']?></span></dl>
		<input type="hidden" name="data[ConfigI18n][shop_title][<?php echo $k?>][id]" value="<?php echo $config_info['shop_title']['ConfigI18n'][$k]['id']?>" />
<?php }}?>
	<dl><dt style="width:100px;">商店描述： </dt>
	<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:100px;"><?php echo $html->image($v['Language']['img01'])?></dt>
	<dd><input type="text" style="width:300px;*width:180px;border:1px solid #649776" name="data[ConfigI18n][shop_description][<?php echo $k?>][value]" value="<?php echo $config_info['shop_description']['ConfigI18n'][$k]['value']?>" />&nbsp<?php echo $html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:hid_show('shop_description_".$v['Language']['locale']."')",'',false,false)?></dd><span id="shop_description_<?php echo $v['Language']['locale']?>" style="display:none"><?php echo $config_info['shop_description']['ConfigI18n'][$k]['description']?></span></dl>
		<input type="hidden" name="data[ConfigI18n][shop_description][<?php echo $k?>][id]" value="<?php echo $config_info['shop_description']['ConfigI18n'][$k]['id']?>" />
<?php }}?>
	<dl><dt style="width:100px;">商店关键字： </dt>
	<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:100px;"><?php echo $html->image($v['Language']['img01'])?></dt>
	<dd><input type="text" style="width:300px;*width:180px;border:1px solid #649776" name="data[ConfigI18n][shop_keywords][<?php echo $k?>][value]" value="<?php echo $config_info['shop_keywords']['ConfigI18n'][$k]['value']?>" />&nbsp<?php echo $html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:hid_show('shop_keywords_".$v['Language']['locale']."')",'',false,false)?></dd><span id="shop_keywords_<?php echo $v['Language']['locale']?>" style="display:none"><?php echo $config_info['shop_keywords']['ConfigI18n'][$k]['description']?></span></dl>
		<input type="hidden" name="data[ConfigI18n][shop_keywords][<?php echo $k?>][id]" value="<?php echo $config_info['shop_keywords']['ConfigI18n'][$k]['id']?>" />
<?php }}?>
	<dl><dt style="width:100px;">详细地址： </dt>
	<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:100px;"><?php echo $html->image($v['Language']['img01'])?></dt>
	<dd><input type="text" style="width:300px;*width:180px;border:1px solid #649776" name="data[ConfigI18n][company_address][<?php echo $k?>][value]" value="<?php echo $config_info['company_address']['ConfigI18n'][$k]['value']?>" />&nbsp<?php echo $html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:hid_show('company_address_".$v['Language']['locale']."')",'',false,false)?></dd><span id="company_address_<?php echo $v['Language']['locale']?>" style="display:none"><?php echo $config_info['company_address']['ConfigI18n'][$k]['description']?></span></dl>
		<input type="hidden" name="data[ConfigI18n][company_address][<?php echo $k?>][id]" value="<?php echo $config_info['company_address']['ConfigI18n'][$k]['id']?>" />
<?php }}?>

	<dl><dt style="width:100px;">用户中心公告： </dt>
	<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:100px;"><?php echo $html->image($v['Language']['img01'])?></dt>
	<dd><input type="text" style="width:300px;*width:180px;border:1px solid #649776" name="data[ConfigI18n][user_center_notice][<?php echo $k?>][value]" value="<?php echo $config_info['user_center_notice']['ConfigI18n'][$k]['value']?>" />&nbsp<?php echo $html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:hid_show('user_center_notice_".$v['Language']['locale']."')",'',false,false)?></dd><span id="user_center_notice_<?php echo $v['Language']['locale']?>" style="display:none"><?php echo $config_info['user_center_notice']['ConfigI18n'][$k]['description']?></span></dl>
		<input type="hidden" name="data[ConfigI18n][user_center_notice][<?php echo $k?>][id]" value="<?php echo $config_info['user_center_notice']['ConfigI18n'][$k]['id']?>" />
<?php }}?>
	<dl><dt style="width:100px;">商店公告： </dt>
	<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:100px;"><?php echo $html->image($v['Language']['img01'])?></dt>
	<dd><input type="text" style="width:300px;*width:180px;border:1px solid #649776" name="data[ConfigI18n][shop_notice][<?php echo $k?>][value]" value="<?php echo $config_info['shop_notice']['ConfigI18n'][$k]['value']?>" />&nbsp<?php echo $html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:hid_show('shop_notice_".$v['Language']['locale']."')",'',false,false)?></dd><span id="shop_notice_<?php echo $v['Language']['locale']?>" style="display:none"><?php echo $config_info['shop_notice']['ConfigI18n'][$k]['description']?></span></dl>
		<input type="hidden" name="data[ConfigI18n][shop_notice][<?php echo $k?>][id]" value="<?php echo $config_info['shop_notice']['ConfigI18n'][$k]['id']?>" />
<?php }}?>
	</div>
	</div>
	<p class="submit_btn"><input type="submit" value="下一步"  /><input type="button" value="退出向导" onclick="break_config()" /></p>
	</div>
</div>
<?php echo $form->end();?>

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