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
 * $Id: setting_ui.ctp 3113 2009-07-20 11:14:34Z huangbo $
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