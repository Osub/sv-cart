<?php 
/*****************************************************************************
 * SV-Cart 后台首页
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: setting_ui.ctp 4433 2009-09-22 10:08:09Z huangbo $
*****************************************************************************/
?>
<?php //echo $minify->js(array('/../js/yui/yahoo-dom-event.js','/../js/yui/container_core-min.js','/../js/yui/connection-min.js'));?>
<?php echo $javascript->link('/../js/yui/yahoo-dom-event.js');?>
<?php echo $javascript->link('/../js/yui/container_core-min.js');?>
<?php echo $javascript->link('/../js/yui/connection-min.js');?>
<?php echo $form->create('tools_install',array('action'=>'/setup/','id'=>"js_setting",'method'=>'post',"onsubmit"=>"return check_form();"));?>
<div class="content">
<br />
<!--Setting-->
<div class="home_main">
<p><?php echo $html->image("/tools/img/".$local_lang."/3_01.gif")?></p>
	<div class="informations">
	<div class="check">
<h3><?php echo $html->image("/tools/img/".$local_lang."/3_02.gif")?></h3>
	<table align="center" width="645" cellpadding="0" cellspacing="0">
	<tr>
	    <td width="28%" align="left"><?php echo $lang['db_type']?>：</td>
	    <td width="72%" align="left"><select name="db_type" id="db_type"><option value="mysql">MySQL</option><option value="postgres">PostgreSQL</option></select></td>
	</tr>
	<tr>
	    <td align="left"><?php echo $lang['db_host']?>：</td>
	    <td align="left"><input type="text" name="db_host" id="db_host"  value="localhost" /></td>
	</tr>
	<!--
	<tr>
	    <td width="100" align="left">端口号：</td>
	    <td align="left"><input type="text" name="db-port"  value="3306" /></td>
	</tr>
	-->
	<tr>
	    <td align="left"><?php echo $lang['db_user']?>：</td>
	    <td align="left"><input type="text" name="db_user" id="db_user"  value="root" /></td>
	</tr>
	<tr>
	    <td align="left"><?php echo $lang['db_pass']?>：</td>
	    <td align="left"><input type="password" name="db_pass" id="db_pass" value="" /></td>
	</tr>
	<tr>
	    <td align="left"><?php echo $lang['db_name']?>：</td>
	    <td align="left"><input type="text" name="db_name" id="db_name" value="" onblur="check_database_connect()"/>  <span id="loading" style="display:none"><?php echo $html->image("/tools/img/".$local_lang."/loader.gif")?></span>(<?php echo $lang['please_create_database']?>)
	   </td>
	</tr>
	<tr id="check_database_connect" style="display:none">
	    <td align="left"><span style="color:red"> </span></td>
	    <td align="left"><span style="color:red" id='connect_no_msg'><?php echo $lang['db_conn_failed']?></span><span style="color:green" id='connect_ok_msg'><?php echo $lang['db_conn_ok']?></span>
	   </td>
	</tr>
</table>
<h3><?php echo $html->image("/tools/img/".$local_lang."/3_03.gif")?></h3>
<table align="center" width="645" cellpadding="0" cellspacing="0">
	<tr>
    <td width="28%" align="left"><?php echo $lang['admin_name']?>：</td>
    <td width="72%" align="left"><input type="text" name="admin_name" id="admin_name" value="" /></td>
	</tr>
	<tr>
	    <td align="left"><?php echo $lang['admin_password']?>：</td>
	    <td align="left"><input type="password" name="admin_password" id="admin_password" value="" /></td>
	</tr>
	<tr>
	    <td align="left"><?php echo $lang['admin_password2']?>：</td>
	    <td align="left"><input type="password" name="admin_password2" id="admin_password2" value="" onblur="check_confirm_password()" /> <span id="confirm_password_loading" style="display:none"><?php echo $html->image("/tools/img/".$local_lang."/loader.gif")?></span><span id="confirm_password_ok" style="display:none;color:green">√</span><span id="confirm_password_no" style="color:red;display:none"> <?php echo $lang['pwd_not_eq']?></span></td>
	</tr>
	<tr>
	    <td align="left"><?php echo $lang['admin_email']?>：</td>
	    <td align="left"><input type="text" name="admin_email" id="admin_email" value="" /></td>
	</tr>
</table>
<h3><?php echo $html->image("/tools/img/".$local_lang."/3_06.gif")?></h3>
<table align="center" width="645" cellpadding="0" cellspacing="0">
	
	<tr>
	    <td align="left" width="28%"><?php echo $lang['user_register_authcode']?>：</td>
	    <td align="left" width="72%">
	    <input type="radio" class="radio" name="user_register_authcode" id="user_register_authcode1" value="1" /><?php echo $lang['yes']?>&nbsp;
	    <input type="radio" class="radio" name="user_register_authcode" id="user_register_authcode2" value="0" checked="checked" /><?php echo $lang['no']?></td>
	</tr>
	<tr>
	    <td align="left"><?php echo $lang['user_login_authcode']?>：</td>
	    <td align="left">
	    <input type="radio" class="radio" name="user_login_authcode" id="user_login_authcode1" value="1" /><?php echo $lang['yes']?>&nbsp;
	    <input type="radio" class="radio" name="user_login_authcode" id="user_login_authcode2" value="0" checked="checked" /><?php echo $lang['no']?></td>
	</tr>
	<tr>
	    <td align="left"><?php echo $lang['user_comment_authcode']?>：</td>
	    <td align="left">
	    <input type="radio" class="radio" name="user_comment_authcode" id="user_comment_authcode1" value="1" /><?php echo $lang['yes']?>&nbsp;
	    <input type="radio" class="radio" name="user_comment_authcode" id="user_comment_authcode2" value="0" checked="checked" /><?php echo $lang['no']?></td>
	</tr>
	<tr>
	    <td align="left"><?php echo $lang['admin_login_authcode']?>：</td>
	    <td align="left">
	    <input type="radio" class="radio" name="admin_login_authcode" id="admin_login_authcode1" value="1" checked="checked" /><?php echo $lang['yes']?>&nbsp;
	    <input type="radio" class="radio" name="admin_login_authcode" id="admin_login_authcode2" value="0" /><?php echo $lang['no']?></td>
	</tr>

</table>
<h3><?php echo $html->image("/tools/img/".$local_lang."/3_04.gif")?></h3>
<table align="center" width="645" cellpadding="0" cellspacing="0">
	<tr>
	    <td align="left" width="28%"><?php echo $lang['demo_products']?>：</td>
	    <td align="left" width="72%">
	    <input type="radio" class="radio" name="demo_products" id="demo_products1" value="1" checked="checked" /><?php echo $lang['yes']?>&nbsp;
	    <input type="radio" class="radio" name="demo_products" id="demo_products2" value="0" /><?php echo $lang['no']?></td>
	</tr>
	<tr>
    <td width="20%" align="left" <?php if(!$use_minify) echo "style='dilpaly:none'";?> ><?php echo $lang['minify_compress']?>：</td>
    <td width="80%" align="left">
    	<input type="radio" class="radio" name="use_minify" id="use_minify1" value="1" <?php if($use_minify){?>checked="checked"<?php }?> /><?php echo $lang['yes']?>&nbsp;
    	<input type="radio" class="radio" name="use_minify" id="use_minify2" value="0" <?php if(!$use_minify){?>checked="checked"<?php }?>/><?php echo $lang['no']?></td>
	</tr>

	<tr>
    <td width="28%" align="left"><?php echo $lang['if_use']?>：</td>
    <td width="72%" align="left">
    	<input type="radio" class="radio" name="use_mod_rewrite" id="use_mod_rewrite1" value="1" <?php if($use_mod_rewrite){?>checked="checked"<?php }?> /><?php echo $lang['yes']?>&nbsp;
    	<input type="radio" class="radio" name="use_mod_rewrite" id="use_mod_rewrite2" value="0" <?php if(!$use_mod_rewrite){?>checked="checked"<?php }?>/><?php echo $lang['no']?></td>
	</tr>
	<tr>
    <td width="28%" align="left"><?php echo $lang['set_timezone']?>：</td>
    <td width="72%" align="left">
    <?php if($local_lang=="eng"){?>
		<select name="time_zone_set" id="time_zone_set">

		  <option value="+12">GMT+12 Eniwetok, Kwajalein</option>


		  <option value="+11">GMT+11 Midway Island, Samoa</option>


		  <option value="+10">GMT+10 Hawaii</option>


		  <option value="+9">GMT+9 Alaska</option>


		  <option value="+8">GMT+8 Pacific Time (US &amp; Canada), Tijuana</option>


		  <option value="+7">GMT+7 Mountain Time (US &amp; Canada), Arizona</option>


		  <option value="+6">GMT+6 Central Time (US &amp; Canada), Mexico City</option>


		  <option value="+5">GMT+5 Eastern Time (US &amp; Canada), Bogota, Lima, Quito</option>


		  <option value="+4">GMT+4 Atlantic Time (Canada), Caracas, La Paz</option>


		  <option value="+3.5">GMT+3.5 Newfoundland</option>


		  <option value="+3">GMT+3 Brassila, Buenos Aires, Georgetown, Falkland Is</option>


		  <option value="+2">GMT+2 Mid-Atlantic, Ascension Is., St. Helen, St. Helena</option>


		  <option value="+1">GMT+1 Azores, Cape Verde Islands</option>


		  <option value="+0" selected="selected">GMT+0 Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia</option>


		  <option value="-1">GMT-1 Amsterdam, Berlin, Brussels, Madrid, Paris, Rome</option>


		  <option value="-2">GMT-2 Cairo, Helsinki, Kaliningrad, South Africa</option>


		  <option value="-3">GMT-3 Baghdad, Riyadh, Moscow, Nairobi</option>


		  <option value="-3.5">GMT-3.5 Tehran</option>


		  <option value="-4">GMT-4 Abu Dhabi, Baku, Muscat, Tbilisi</option>


		  <option value="-4.5">GMT-4.5 Kabul</option>


		  <option value="-5">GMT-5 Ekaterinburg, Islamabad, Karachi, Tashkent</option>


		  <option value="-5.5">GMT-5.5 Bombay, Calcutta, Madras, New Delhi</option>


		  <option value="-5.75">GMT-5.75 Katmandu</option>


		  <option value="-6">GMT-6 Almaty, Colombo, Dhaka, Novosibirsk</option>


		  <option value="-6.5">GMT-6.5 Rangoon</option>


		  <option value="-7">GMT-7 Bangkok, Hanoi, Jakarta</option>


		  <option value="-8">GMT-8 Beijing, Hong Kong, Perth, Singapore, Taipei</option>


		  <option value="-9">GMT-9 Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option>


		  <option value="-9.5">GMT-9.5 Adelaide, Darwin</option>


		  <option value="-10">GMT-10 Canberra, Guam, Melbourne, Sydney, Vladivostok</option>


		  <option value="-11">GMT-11 Magadan, New Caledonia, Solomon Islands</option>


		  <option value="-12">GMT-12 Auckland, Wellington, Fiji, Marshall Island</option>
		 </select>
	<?php }else{?>
		<select name="time_zone_set" id="time_zone_set">
		  <option value="+12">GMT+12 埃尼威托克岛，夸贾林</option>


		  <option value="+11">GMT+11 中途岛，萨摩亚群岛</option>


		  <option value="+10">GMT+10 夏威夷</option>


		  <option value="+9">GMT+9 阿拉斯加</option>


		  <option value="+8">GMT+8 太平洋时间（美国和加拿大），蒂华纳</option>


		  <option value="+7">GMT+7 山地时间（美国和加拿大），亚利桑那州</option>


		  <option value="+6">GMT+6 中央时间（美国和加拿大），墨西哥城</option>


		  <option value="+5">GMT+5 东部时间（美国和加拿大），波哥大，利马，基多</option>


		  <option value="+4">GMT+4 大西洋时间（加拿大），加拉加斯，拉巴斯</option>


		  <option value="+3.5">GMT+3.5 纽芬兰</option>


		  <option value="+3">GMT+3 布宜诺斯艾利斯，乔治敦，福克兰群岛</option>


		  <option value="+2">GMT+2 大西洋中部，阿森松岛，圣海伦，圣赫勒拿</option>


		  <option value="+1">GMT+1 亚速尔群岛，佛得角群岛</option>


		  <option value="+0">GMT+0 卡萨布兰卡，都柏林，爱丁堡，伦敦，里斯本，蒙罗维亚</option>


		  <option value="-1">GMT-1 阿姆斯特丹，柏林，布鲁塞尔，马德里，巴黎，罗马</option>


		  <option value="-2">GMT-2 开罗，赫尔辛基，加里宁格勒，南非</option>


		  <option value="-3">GMT-3 巴格达，利雅得，莫斯科，内罗毕</option>


		  <option value="-3.5">GMT-3.5 德黑兰</option>


		  <option value="-4">GMT-4 阿布扎比，巴库，马斯喀特，第比利斯</option>


		  <option value="-4.5">GMT-4.5 喀布尔</option>


		  <option value="-5">GMT-5 叶卡特琳堡，伊斯兰堡，卡拉奇，塔什干</option>


		  <option value="-5.5">GMT-5.5 孟买，加尔各答，马德拉斯，新德里</option>


		  <option value="-5.75">GMT-5.75 加德满都</option>


		  <option value="-6">GMT-6 阿拉木图，科伦坡，达卡，新西伯利亚</option>


		  <option value="-6.5">GMT-6.5 仰光</option>


		  <option value="-7">GMT-7 曼谷，河内，雅加达</option>


		  <option value="-8" selected="selected">GMT-8 北京，香港，珀斯，新加坡，台北</option>


		  <option value="-9">GMT-9 大阪，札幌，汉城，东京，雅库茨克</option>


		  <option value="-9.5">GMT-9.5 阿德莱德，达尔文</option>


		  <option value="-10">GMT-10 堪培拉，关岛，墨尔本，悉尼，符拉迪沃斯托克</option>


		  <option value="-11">GMT-11 马加丹，新喀里多尼亚所罗门群岛</option>


		  <option value="-12">GMT-12 奥克兰，惠灵顿，斐济，马绍尔群岛</option>

		 </select>
	<?php }?>
	</tr>
	<tr>
</table>
<h3><?php echo $html->image("/tools/img/".$local_lang."/3_05.gif")?></h3>
<table align="center" width="645" cellpadding="0" cellspacing="0" id='template_table'>
	<?php foreach($templates as $k=>$v){?>	
	<tr >
    <?php if($k==0){?><td width="28%" align="left" rowspan='100'>
    		
    		<select name="template_name" onchange="template_change(this.value);">
    			<?php foreach($templates as $k2=>$v2){?>
    			<option value="<?php echo $v2['code']?>" <?php if($k2==0){?>selected"<?php }?>>
    			<?php echo $v2['name'];?></option>
    			<?php }?>
    		</select>
    		
    		
    </td><?php }?>
    <td width="72%" align="left" <?php if($k>0) echo "style='display:none'";?> id='td_<?php echo $v['code']?>' name='template_td'>
		<?php echo $html->image($v['style_default_img'],array('height'=>'190','id'=>'theme_img_'.$v['code']));?>
		<?php foreach ($v['template_styles'] as $style){?>
			<span onMouseOver="javascript:onSOver('theme_img_<?php echo $v['code']?>','<?php echo $style['img']?>');" onMouseOut="onSOut('theme_img_<?php echo $v['code']?>','template_style_img_<?php echo $v['code']?>');"><a href="javascript:select_style('theme_name_<?php echo $v['code']?>','<?php echo $v['code']?>','<?php echo $style['name']?>','<?php echo $style['img']?>');"><?php if ($style['name'] == $v['style_default_name']) echo $html->image($style['name'].'_over.gif',array("title"=>$style['name'],'id'=>'theme_'.$v['code'].'_'.$style['name'],'name'=>'theme_name_'.$v['code'])); else echo $html->image($style['name'].'.gif',array("title"=>$style['name'],'id'=>'theme_'.$v['code'].'_'.$style['name'],'name'=>'theme_name_'.$v['code']));?></a></span>
		<?php }?>
	<input name="template_style_<?php echo $v['code']?>" id="template_style_<?php echo $v['code']?>" type="hidden" value="<?php echo $v['style_default_name'];?>" />
	<input name="template_style_img_<?php echo $v['code']?>"  id="template_style_img_<?php echo $v['code']?>" type="hidden" value="<?php echo $v['style_default_img'];?>" />
	</tr>
	<?php }?>
</table>
</div>
<p><?php echo $html->image("/tools/img/".$local_lang."/1_02.gif")?></p>
	</div>
<div class="agree">
	<input type="button" class="button" value="<?php echo $lang['prev_step']?>：<?php echo $lang['check_system_environment']?>" onclick="pre_step()" />
	<input id="js-install-at-once" type="submit" class="button setup" value="<?php echo $lang['install_at_once']?>" />
</div>
</div>
<!--Setting End-->
</div>
<input name="template_style" type="hidden" value="" />
<input name="ucapi" type="hidden" value="" />
<input name="ucfounderpw" type="hidden" value="" />
<?php echo $form->end();?>
<script type="text/javascript">
//YAHOO.example.container.wait = new YAHOO.widget.Panel("wait",{ width:"240px", fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
//YAHOO.example.container.wait.setHeader("<div style='background:#fff;position:absolute;width:100%;padding-top:5px;margin-top:15px;text-align:center'>Loading, please wait...</div>");
//YAHOO.example.container.wait.setBody("<object id='loading' data='"+webroot_dir+"tools/img/loading.swf' type='application/x-shockwave-flash' width='240' height='40'><param name='movie' value='"+webroot_dir+"tools/img/loading.swf' /><param name='wmode' value='Opaque'></object>");

function pre_step(){
	var setting_form = document.getElementById('js_setting');
	setting_form.action = webroot_dir +"tools/tools_installs/check";
	setting_form.submit();
}
function check_form(){
	//YAHOO.example.container.wait.show();
	if(document.getElementById('db_host').value.length == 0){
		alert(db_host_not_empty);
		return false;
	}
	else if(document.getElementById('db_user').value.length == 0){
		alert(db_user_name_not_empty);
		return false;
	}
	else if(document.getElementById('db_name').value.length == 0){
		alert(db_name_not_empty);
		return false;
	}
	else if(document.getElementById('admin_name').value.length == 0){
		alert(admin_name_not_empty);
		return false;
	}
	else if(!CheckStr(document.getElementById('admin_name').value)){
		alert(admin_name_not_valid);
		return false;
	}
	else if(document.getElementById('admin_password').value.length == 0){
		alert(pwd_not_empty);
		return false;
	}
	else if(document.getElementById('admin_password').value!= document.getElementById('admin_password2').value){
		alert(pwd_not_eq);
		return false;
	}
	
	else if(document.getElementById('admin_email').value.length == 0){
		alert(email_not_empty);
		return false;
	}
	else if(!isEmailFormat(document.getElementById('admin_email').value)){
		alert(email_not_valid);
		return false;
	}
	document.getElementById('js-install-at-once').value = '<?php echo $lang['install_ing']?>';
	document.getElementById('js-install-at-once').disabled = true;
	return true;

}
function isEmailFormat(inStr){
	if(inStr.length==0) return 1;
	var AtSym    = inStr.indexOf('@');
	var Period   = inStr.lastIndexOf('.');
	var Space    = inStr.indexOf(' ');
	var Length   = inStr.length - 1;   
	if ((AtSym < 1)||(Period <= AtSym+1)||(Period == Length )||(Space  != -1)){  
		return 0;
	}
		return 1;
}
function CheckStr(str){
    var myReg = /^[^@\/\'\\\"#$%&~\!\^\*]+$/;
    if(myReg.test(str)) 
    	return true; 
	return false; 
}

function check_database_connect(){
	document.getElementById('loading').style.display = '';
	var url = webroot_dir+"tools/tools_installs/check_database_connect";
	var db_type = document.getElementById('db_type').value;
	var db_host = document.getElementById('db_host').value;
	var db_user = document.getElementById('db_user').value;
	var db_pass = document.getElementById('db_pass').value;
	var db_name = document.getElementById('db_name').value;
	var str = "db_type="+db_type+"&db_host="+db_host+"&db_user="+db_user+"&db_pass="+db_pass+"&db_name="+db_name;
	YAHOO.util.Connect.asyncRequest('POST', url, check_database_connect_callback,str);
}
var check_database_connect_Success = function(oResponse){
	if(oResponse.responseText=="yes"){
		document.getElementById('check_database_connect').style.display = "";
		document.getElementById('connect_ok_msg').style.display = "";
		document.getElementById('connect_no_msg').style.display = "none";
	}
	else {
		document.getElementById('check_database_connect').style.display = "";
		document.getElementById('connect_ok_msg').style.display = "none";
		document.getElementById('connect_no_msg').style.display = "";
	}
	document.getElementById('loading').style.display = 'none';
}

var check_database_connect_Failure = function(o){
	document.getElementById('loading').style.display = 'none';
	alert("异步请求失败");
}

var check_database_connect_callback ={
	success:check_database_connect_Success,
	failure:check_database_connect_Failure,
	timeout : 3000000,
	argument: {}
};		
function check_confirm_password(){
	document.getElementById('confirm_password_loading').style.display = '';
	if(document.getElementById('admin_password').value.length > 0){
		
		if(document.getElementById('admin_password').value!= document.getElementById('admin_password2').value){
			document.getElementById('confirm_password_no').style.display = '';
			document.getElementById('confirm_password_ok').style.display = 'none';
		}
		else {
			document.getElementById('confirm_password_no').style.display = 'none';
			document.getElementById('confirm_password_ok').style.display = '';
		}
		
	}
	document.getElementById('confirm_password_loading').style.display = 'none';
}
function onSOver(img_id,img_url){
	document.getElementById(img_id).src = img_url;
}
function onSOut(img_id,theme_id){
	document.getElementById(img_id).src = document.getElementById(theme_id).value;
}
function select_style(img_name,code,style_name,img_url){
	document.getElementById('template_style_'+code).value = style_name;
	document.getElementById('template_style_img_'+code).value = img_url;
	document.getElementById('theme_img_'+code).src = img_url;
	var imgs = document.getElementsByName(img_name);
	for(var i=0;i<imgs.length;i++){
		imgs[i].src = root_all+'sv-admin/img/'+imgs[i].title+'.gif';
	}
	document.getElementById('theme_'+code+'_'+style_name).src = root_all+'sv-admin/img/'+style_name+'_over.gif';
	//a.blur();
}
function template_change(template){
	var template_td = document.getElementById('template_table').getElementsByTagName('td');
	for(var i=0;i<template_td.length;i++){
		if(template_td[i].id != '')
			template_td[i].style.display = 'none';
	}
	document.getElementById('td_'+template).style.display = '';
	//alert(template);
}
</script>