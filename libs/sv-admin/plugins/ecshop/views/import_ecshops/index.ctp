<?php
/*****************************************************************************
 * SV-Cart Ecshop导入
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1393 2009-05-15 07:40:52Z zhengli $
*****************************************************************************/
?>
<?php echo $form->create('ecshops',array('action'=>'/ecshop_database_config/','id'=>'theform'));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<div class="home_main" id="guides_1">
<table width="100%" cellpadding="0" cellspacing="0" class="">

<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?=$html->image('tab_left.gif',array('class'=>'left'))?>
	<?=$html->image('tab_right.gif',array('class'=>'right'))?>
	Ecshop导入插件</h1></div>
	<div class="box">
	<div class="shop_config menus_configs guides" style="width:500px;">
	<br />
	<dl><dt style="width:140px;">数据库主机: </dt>
	<dd><input type="text" id="ecshop_host" name="ecshop_host" style="width:200px;border:1px solid #649776"  />&nbsp<font color="#ff0000" >*</font></dd></dl>
	<dl><dt style="width:140px;">用户名: </dt>
	<dd><input type="text" id="ecshop_login" name="ecshop_login"  style="width:200px;border:1px solid #649776" />&nbsp<font color="#ff0000" >*</font></dd></dl>
	<dl><dt style="width:140px;">密码: </dt>
	<dd><input type="text" id="ecshop_password" name="ecshop_password"  style="width:200px;border:1px solid #649776" />&nbsp<font color="#ff0000" >*</font></dd></dl>
	<dl><dt style="width:140px;">数据库名: </dt>
	<dd><input type="text" id="ecshop_database" name="ecshop_database"  style="width:200px;border:1px solid #649776"  />&nbsp<font color="#ff0000" >*</font></dd></dl>
	<dl><dt style="width:140px;">表前缀: </dt>
	<dd><input type="text" id="ecshop_prefix" name="ecshop_prefix"  style="width:200px;border:1px solid #649776" />&nbsp<font color="#ff0000" >*</font></dd></dl>
	</div>
	</div>
	</div>
	</td>
	<td valign="top" width="100%" style="padding-left:5px;padding-top:25px;">
	<div class="order_stat athe_infos configvalues">

	<div class="box">
	<div class="shop_config menus_configs guides" style="width:500px;">
	<br />
	<table>
	<?php $i=1;foreach( $import_ecshop_mysql_table as $k=>$v ){?>
		<?php if($i==7){?><tr><?php }?>
		<td><input type="checkbox" value="<?php echo $k;?>" name="import_ecshop_mysql_table[]" checked ><?php $i++;echo $v;?></td>
		<?php if($i==7){$i=1;?></tr><?php }?>
	<?php }?>
	</table>
	</div>
	</div>
	</div>
	</td>
</tr>

</table>
		<p class="submit_btn"><input type="button" value="保存配置" onclick="save_database_config()" /><input type="reset" value="重置"  /></p>

</div>
<? echo $form->end();?>
<script type="text/javascript">
function save_database_config(){
	var ecshop_host 	= GetId('ecshop_host');
	var ecshop_login 	= GetId('ecshop_login');
	var ecshop_password = GetId('ecshop_password');
	var ecshop_database = GetId('ecshop_database');
	var ecshop_prefix 	= GetId('ecshop_prefix');
	layer_dialog();
	if( Trim( ecshop_host.value,'g' ) == "" ){
		layer_dialog_show("数据库主机不能为空!","",3);
		return false;
	}	
	if( Trim( ecshop_login.value,'g' ) == "" ){
		layer_dialog_show("用户名不能为空!","",3);
		return false;
	}
	if( Trim( ecshop_database.value,'g' ) == "" ){
		layer_dialog_show("数据库名不能为空!","",3);
		return false;
	}
	if( Trim( ecshop_prefix.value,'g' ) == "" ){
		layer_dialog_show("表前缀不能为空!","",3);
		return false;
	}
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"ecshop/import_ecshops/ecshop_database_config/";
	var postData = "ecshop_host="+ecshop_host.value+"&ecshop_login="+ecshop_login.value+"&ecshop_password="+ecshop_password.value+"&ecshop_database="+ecshop_database.value+"&ecshop_prefix="+ecshop_prefix.value;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, save_database_config_callback,postData);

}
var save_database_config_Success = function(o){
	var result = YAHOO.lang.JSON.parse(o.responseText);
	check_ecshop_database_config()
}
var save_database_config_Failure = function(o){
	alert("error");
	YAHOO.example.container.wait.hide();
}
var save_database_config_callback ={
	success:save_database_config_Success,
	failure:save_database_config_Failure,
	timeout : 30000,
	argument: {}
};
function check_ecshop_database_config(){
	YAHOO.example.container.wait.show();
	var sUrl		=	webroot_dir+"ecshop/import_ecshops/check_ecshop_database_config/";
	var request 	= 	YAHOO.util.Connect.asyncRequest('POST', sUrl, check_ecshop_database_config_callback);
}
var check_ecshop_database_config_Success = function(o){
	var result = YAHOO.lang.JSON.parse(o.responseText);
	if(result.error==1){
		layer_dialog();
		layer_dialog_show(result.message,"javascript:layer_dialog_obj.hide();start_import_ecshop();",6);
	}else{
		YAHOO.example.container.wait.hide();
		layer_dialog();
		layer_dialog_show(result.message,"",3);
	}
}

var check_ecshop_database_config_Failure = function(o){
	alert("error");
	YAHOO.example.container.wait.hide();
}
var check_ecshop_database_config_callback ={
	success:check_ecshop_database_config_Success,
	failure:check_ecshop_database_config_Failure,
	timeout : 30000,
	argument: {}
};
function start_import_ecshop(){
	YAHOO.example.container.wait.show();
	var import_ecshop_mysql_table = GetName("import_ecshop_mysql_table[]");
	var import_ecshop_mysql_table_value = Array();
	for( var i=0;i<import_ecshop_mysql_table.length;i++ ){
		if(import_ecshop_mysql_table[i].checked){
			import_ecshop_mysql_table_value[i] = import_ecshop_mysql_table[i].value;
		}
	}
	import_ecshop_mysql_table_value = import_ecshop_mysql_table_value.join(",");
	
	var sUrl		=	webroot_dir+"ecshop/import_ecshops/import_ecshop/?import_ecshop_mysql_table_value="+import_ecshop_mysql_table_value;
	var request 	= 	YAHOO.util.Connect.asyncRequest('POST', sUrl, ecshop_import_callback);
}
var ecshop_import_Success = function(o){
	YAHOO.example.container.wait.hide();
	layer_dialog();
	layer_dialog_show(o.responseText,webroot_dir,6);
}

var ecshop_import_Failure = function(o){
	alert("error");
	YAHOO.example.container.wait.hide();
}
var ecshop_import_callback ={
	success:ecshop_import_Success,
	failure:ecshop_import_Failure,
	timeout : 30000000,
	argument: {}
};
</script>