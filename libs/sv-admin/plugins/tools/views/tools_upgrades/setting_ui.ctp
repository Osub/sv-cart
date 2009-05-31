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
 * $Id: setting_ui.ctp 1267 2009-05-08 11:01:10Z shenyunfeng $
*****************************************************************************/
?>
<?php echo $form->create('tools_upgrade',array('action'=>'/setup/','id'=>"js_setting",'method'=>'post',"onsubmit"=>"return check_form();"));?>
<div class="content">
<br />
<!--Setting-->
<div class="home_main">
	<div class="informations">
	<br />
	<h3 align="center" class="green">配置系统</h3>
	<div class="box">
	
	<table align="center" style="margin:0 auto;">
	<tr>
		<td colspan="2"><h3 class="green">数据库帐号</h3></td>
	</tr>
	<tr>
	    <td width="100" align="left">数据库主机：</td>
	    <td align="left"><input type="text" name="db_host" id="db_host"  value="localhost" /></td>
	</tr>
	<!--
	<tr>
	    <td width="100" align="left">端口号：</td>
	    <td align="left"><input type="text" name="db-port"  value="3306" /></td>
	</tr>
	-->
	<tr>
	    <td width="100" align="left">用户名：</td>
	    <td align="left"><input type="text" name="db_user" id="db_user"  value="root" /></td>
	</tr>
	<tr>
	    <td width="100" align="left">密码：</td>
	    <td align="left"><input type="password" name="db_pass" id="db_pass" value="" /></td>
	</tr>
	<tr>
	    <td width="100" align="left">数据库名：</td>
	    <td align="left"><input type="text" name="db_name" id="db_name" value="" />
	   </td>
	</tr>
	<tr>
		<td colspan="2"><br /><h3 class="green">管理员帐号</h3></td>
	</tr>
	<tr>
    <td width="100" align="left">管理员用户名：</td>
    <td align="left"><input type="text" name="admin_name" id="admin_name" value="" /></td>
	</tr>
	<tr>
	    <td width="100" align="left">登录密码：</td>
	    <td align="left"><input type="password" name="admin_password" id="admin_password" value="" /></td>
	</tr>
	<tr>
	    <td width="100" align="left">密码确认：</td>
	    <td align="left"><input type="password" name="admin_password2" id="admin_password2" value="" /></td>
	</tr>
	<tr>
	    <td width="100" align="left">电子邮箱：</td>
	    <td align="left"><input type="text" name="admin_email" id="admin_email" value="" /></td>
	</tr>
	<tr>
	    <td width="100" align="left">安装演示数据：</td>
	    <td align="left"><input type="radio" name="demo_products" id="demo_products1" value="1" checked />是<input type="radio" name="demo_products" id="demo_products2" value="0" />否</td>
	</tr>
</table>
	</div>
	</div>
<div class="agree">
	<input type="button" id="" class="button" value="上一步：配置安装环境" onclick="pre_step()"/>
	<input id="js-install-at-once" type="submit" class="button setup" value="立即安装" />
</div>
</div>
<!--Setting End-->
</div>
<input name="ucapi" type="hidden" value="" />
<input name="ucfounderpw" type="hidden" value="" />
<?php $form->end();?>
<script>
function pre_step(){
	var setting_form = document.getElementById('js_setting');
	setting_form.action = webroot_dir +"tools/tools_upgrades/check";
	setting_form.submit();
}
function check_form(){
	if(document.getElementById('db_host').value.length == 0){
		alert('数据库主机不能为空！');
		return false;
	}
	else if(document.getElementById('db_user').value.length == 0){
		alert('数据库用户名不能为空！');
		return false;
	}
	else if(document.getElementById('db_name').value.length == 0){
		alert('数据库库名不能为空！');
		return false;
	}
	else if(document.getElementById('admin_name').value.length == 0){
		alert('管理员用户名不能为空！');
		return false;
	}
	else if(!CheckStr(document.getElementById('admin_name').value)){
		alert('管理员用户名不能有特殊字符！');
		return false;
	}
	else if(document.getElementById('admin_password').value.length == 0){
		alert('登录密码不能为空！');
		return false;
	}
	else if(document.getElementById('admin_password').value!= document.getElementById('admin_password2').value){
		alert('两次密码输入不一致！');
		return false;
	}
	
	else if(document.getElementById('admin_email').value.length == 0){
		alert('email不能为空！');
		return false;
	}
	else if(!isEmailFormat(document.getElementById('admin_email').value)){
		alert('email格式不对！');
		return false;
	}
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

</script>