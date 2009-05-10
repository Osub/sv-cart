YAHOO.namespace("example.container");

function init() {


YAHOO.example.container.manager = new YAHOO.widget.OverlayManager();


YAHOO.example.container.wait = new YAHOO.widget.Panel("wait",{ width:"240px", fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
YAHOO.example.container.wait.setHeader("<div style='background:#fff;width:100%;padding-top:5px;margin-top:2px;text-align:center'>Loading, please wait...</div>");
YAHOO.example.container.wait.setBody("<object data='"+webroot_dir+themePath+"img/loading.swf' type='application/x-shockwave-flash' width='240' height='30'><param name='movie' value='"+webroot_dir+"../img/loading.swf' /><param name='wmode' value='Opaque'></object>");
//YAHOO.example.container.wait.setBody("<object id='loading' data='../../img/loading.swf' type='application/x-shockwave-flash' width='240' height='40'><param name='movie' value='../../img/loading.swf' /><param name='wmode' value='Opaque'></object>");

YAHOO.example.container.wait.render(document.body);

YAHOO.example.container.message = new YAHOO.widget.Panel("message_show",{width:"422px",fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
YAHOO.example.container.message.setBody("<div id='message_content'></div>");
YAHOO.example.container.message.render(document.body);



YAHOO.util.Dom.setStyle('svcart-com', 'visibility', 'visible');
}

YAHOO.util.Event.onDOMReady(init);
//创建DIV--begin
	function createDIV(div_id){
	    var div = document.createElement("div");
	    div.innerHTML = "";
	    div.style.display = "none";
	    div.id = div_id;
	    var o = document.body;
	    o.appendChild(div);
	}
//创建DIV--end


	//window.open图片管理
	function img_sel(number,assign_dir){
		
		var win = window.open (webroot_dir+"images/?status=1", 'newwindow', 'height=600, width=800, top=0, left=0, toolbar=no, menubar=yes, scrollbars=yes,resizable=yes,location=no, status=no');
		document.getElementById('img_src_text_number').value = number;
		document.getElementById("assign_dir").value = assign_dir;
	}
	function img_src_return(img_obj){
		if( window_option_status == 1 ){
			var img_src_text_number = window.opener.document.getElementById('img_src_text_number').value;
			var src_arr = img_obj.src.split("/");
			var j=0;
			var src_str = "";
			for(var i=3;i<=src_arr.length-1;i++){
				src_str+="/"+src_arr[i];
				j++;
			}
			window.opener.document.getElementById('upload_img_text_'+img_src_text_number).value = img_obj.name;
			window.opener.document.getElementById('img_src_text_number').value = "";
			window.opener.document.getElementById('logo_thumb_img_'+img_src_text_number).src = src_str;
			window.opener.document.getElementById('logo_thumb_img_'+img_src_text_number).style.display="block";
			window.close();
		}
	}
	//遮罩层JS
	
	function layer_dialog(){
		tabView = new YAHOO.widget.TabView('contextPane'); 
        layer_dialog_obj = new YAHOO.widget.Panel("layer_dialog", 
							{
								visible:false,
								draggable:false,
								modal:true,
								style:"margin 0 auto",
								fixedcenter: true
							} 
						); 
		layer_dialog_obj.render();
	}
	//后台对话框
	/***************************提示信息********连接地址********3*******类拟alert					*/
	/***************************提示信息********连接地址********4*******类拟alert   加刷新			*/
	/***************************提示信息********函数************5*******类拟confirm但用法不一样		*/
	function layer_dialog_show(dialog_content,url_or_function,button_num){
		document.getElementById('layer_dialog').style.display = "block";
		if(url_or_function!=''){
			document.getElementById('confirm').value = url_or_function;//删除层传URL
		}
		document.getElementById('dialog_content').innerHTML = dialog_content;//对话框中的中文
		var button_replace = document.getElementById('button_replace');
		if(button_num==3){
			button_replace.innerHTML = "<a href='javascript:layer_dialog_obj.hide();' style='padding-right:50px;'>确定</a>";
		}
		if(button_num==4){
			button_replace.innerHTML = "<a href='javascript:window.location.reload();' style='padding-right:50px;'>确定</a>";
		}
		if(button_num==5){
			button_replace.innerHTML = "<a href='javascript:layer_dialog_obj.hide();' >取消</a><a href='javascript:layer_dialog_hide();"+url_or_function+";' >确定</a>";

		}
		layer_dialog_obj.show();
	}
	function layer_dialog_hide(){
		document.getElementById('layer_dialog').style.display = "none";
	}
	//确认后操作
	function confirm_record(){
		var sUrl = document.getElementById('confirm').value;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, remove_record_callback);
	}
	var remove_record_Success = function(o){
		window.location.reload();
	}
	
	var remove_record_Failure = function(o){
		alert("error");
	}

	var remove_record_callback ={
		success:remove_record_Success,
		failure:remove_record_Failure,
		timeout : 30000,
		argument: {}
	};
//后台对话框end


function close_message(){
	YAHOO.example.container.message.hide();
}

function show_login_captcha(){
	document.getElementById("authnum_img").src = webroot_dir+"authnums/get_authnums/?"+Math.random();
}

//指定输入框为数字主要为排序
function check_input_num(obj){
	obj.value=obj.value.replace(/[^\d]/g,'');
}



//用户信息管理
function userinformations_check(){
	var name = document.getElementById('name'+now_locale);
	if( Trim(name.value,'g') == "" ){
		layer_dialog();
		layer_dialog_show("名称不能为空!","",3);
		return false;
	}
	
}
//用户设置管理
function userconfigs_checks(){
	var name = document.getElementById('nowname'+now_locale);
	if( Trim(name.value,'g') == "" ){
		layer_dialog();
		layer_dialog_show("用户名称不能为空!","",3);
		return false;
	}
}
//商店设置管理 
function userconfigs_check(){
	var name = document.getElementById('name'+now_locale);
	var config_group = document.getElementById('config_group');
	var config_code = document.getElementById('config_code');
	layer_dialog();
	if( Trim( config_group.value,'g' ) == "" ){
		layer_dialog_show("设置参数组不能为空!","",3);
		return false;
	}
	if( Trim( config_code.value,'g' ) == "" ){
		layer_dialog_show("参数名称不能为空!","",3);
		return false;
	}
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("商店名称不能为空!","",3);
		return false;
	}

}
//访问权限管理 
function competences_check(){
	var operatoraction_parentid = document.getElementById('operatoraction_parentid');
	var name = document.getElementById('name'+now_locale);
	layer_dialog();
	if( Trim( operatoraction_parentid.value,'g' ) == "" ){
		layer_dialog_show("上级权限编号不能为空!","",3);
		return false;
	}
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("访问权限名称不能为空!","",3);
		return false;
	}
}
//菜单管理
function menus_check(){
	var name = document.getElementById('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("菜单名称不能为空!","",3);
		return false;
	}
}
//邮件模板管理
function mailtemplates_check(){
	var title = document.getElementById('title'+now_locale);
	layer_dialog();
	if( Trim( title.value,'g' ) == "" ){
		layer_dialog_show("邮件主题不能为空!","",3);
		return false;
	}

}

//语言管理 
function languages_check(){
	var language_name = document.getElementById('language_name');
	var language_locale = document.getElementById('language_locale');
	var language_charset = document.getElementById('language_charset');
	var language_map = document.getElementById('language_map');
	var language_google_translate_code = document.getElementById('language_google_translate_code');
	layer_dialog();
	if( Trim( language_name.value,'g' ) == "" ){
		layer_dialog_show("语言名称不能为空!","",3);
		return false;
	}
	if( Trim( language_locale.value,'g' ) == "" ){
		layer_dialog_show("语言代码不能为空!","",3);
		return false;
	}
	if( Trim( language_charset.value,'g' ) == "" ){
		layer_dialog_show("字符集不能为空!","",3);
		return false;
	}
	if( Trim( language_map.value,'g' ) == "" ){
		layer_dialog_show("浏览器字符集不能为空!","",3);
		return false;
	}
	if( Trim( language_google_translate_code.value,'g' ) == "" ){
		layer_dialog_show("google翻译参数不能为空!","",3);
		return false;
	}
}
//支付方式
function payments_check(){
	var name = document.getElementById('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("支付方式名称不能为空!","",3);
		return false;
	}

}

//配送区域
function shippingments_check(){
	var name = document.getElementById('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("配送区域名称不能为空!","",3);
		return false;
	}
}

//导航设置 
function navigations_check(){
	var name = document.getElementById('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("导航名称不能为空!","",3);
		return false;
	}
}
//广告管理
function advertisements_check(){
	var advertisement_name = document.getElementById('advertisement_name');
	layer_dialog();
	if( Trim( advertisement_name.value,'g' ) == "" ){
		layer_dialog_show("广告名称不能为空!","",3);
		return false;
	}
}
//友情链接管理 
function links_check(){
	var name = document.getElementById('name'+now_locale);
	var url = document.getElementById('url'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("连接名称不能为空!","",3);
		return false;
	}
	if( Trim( url.value,'g' ) == "" ){
		layer_dialog_show("连接地址不能为空!","",3);
		return false;
	}

}

//供应商管理
function providers_check(){
	var provider_name = document.getElementById('provider_name');
	layer_dialog();
	if( Trim( provider_name.value,'g' ) == "" ){
		layer_dialog_show("供应商名称不能为空!","",3);
		return false;
	}

}
//部门管理
function departments_check(){
	var name = document.getElementById('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("部门名称不能为空!","",3);
		return false;
	}
}

//角色管理
function roles_check(){
	var name = document.getElementById('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("角色名称不能为空!","",3);
		return false;
	}
}

//操作员管理 
function operators_check(){
	var OperatorName = document.getElementById('OperatorName');
	var OperatorEmail = document.getElementById('OperatorEmail');
	var NewPassword = document.getElementById('NewPassword');
	var ConfirmPassword = document.getElementById('ConfirmPassword');
	layer_dialog();
	if( Trim( OperatorName.value,'g' ) == "" ){
		layer_dialog_show("用户名不能为空!","",3);
		return false;
	}
	if( Trim( OperatorEmail.value,'g' ) == "" ){
		layer_dialog_show("Email地址不能为空!","",3);
		return false;
	}
	if(isEmailFormat(OperatorEmail.value)==0){
		layer_dialog_show("Email地址不正确!","",3);
		return false;
	}
	/*
	if( Trim( NewPassword.value,'g' ) == "" ){
		layer_dialog_show("密码不能为空!","",3);
		return false;
	}
	if( Trim( ConfirmPassword.value,'g' ) == "" ){
		layer_dialog_show("确认密码不能为空!","",3);
		return false;
	}*/	
}

//实体店管理
function stores_check(){
	var name = document.getElementById('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("实体店名称不能为空!","",3);
		return false;
	}
}
//会员管理
function users_check(){
	var user_email = document.getElementById('user_email');
	var user_new_password = document.getElementById('user_new_password');
	var user_new_password2 = document.getElementById('user_new_password2');
	
	layer_dialog();
	if( Trim( user_email.value,'g' ) == "" ){
		layer_dialog_show("Email地址不能为空!","",3);
		return false;
	}
	if(isEmailFormat(user_email.value)==0){
		layer_dialog_show("Email地址不正确!","",3);
		return false;
	}
	if(Trim( user_new_password.value,'g' ) != Trim( user_new_password2.value,'g' ) ){
		layer_dialog_show("两次密码输入不相同!","",3);
		return false;
	}
}
//商品管理
function products_check(){
	var ProductsCategory = document.getElementById('ProductsCategory');
	var productes_name = document.getElementById('product_name_'+now_locale);
	layer_dialog();
	if( Trim( productes_name.value,'g' ) == "" ){
		layer_dialog_show("商品名称不能为空!","",3);
		return false;
	}
	if(ProductsCategory.value==0){
		layer_dialog_show("商品分类必须选择!","",3);
		return false;
	
	}

}

//商品类型管理 
function productstypes_check(){
	var name = document.getElementById('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("商品类型名称不能为空!","",3);
		return false;
	}
}
//商品属性管理
function products_attribute(){
	var attribute_name = document.getElementById("attribute_name_"+now_locale);
	layer_dialog();
	if( Trim( attribute_name.value,'g' ) == "" ){
		layer_dialog_show("属性名称不能为空!","",3);
		return false;
	}
}
//商品分类管理 
function categories_P_check(){
	var category_name = document.getElementById('category_name_'+now_locale);
	layer_dialog();
	if( Trim( category_name.value,'g' ) == "" ){
		layer_dialog_show("分类名称不能为空!","",3);
		return false;
	}
}
//文章分类管理 
function categories_A_check(){
	var category_name = document.getElementById('category_name_'+now_locale);
	layer_dialog();
	if( Trim( category_name.value,'g' ) == "" ){
		layer_dialog_show("分类名称不能为空!","",3);
		return false;
	}
	
}
//品牌管理
function brands_check(){
	var brand_name = document.getElementById('brand_name_'+now_locale);
	layer_dialog();
	if( Trim( brand_name.value,'g' ) == "" ){
		layer_dialog_show("品牌名称不能为空!","",3);
		return false;
	}

}
//文章管理
function articles_check(){
	var article_name = document.getElementById('article_name_'+now_locale);
	layer_dialog();
	if( Trim( article_name.value,'g' ) == "" ){
		layer_dialog_show("文章标题不能为空!","",3);
		return false;
	}

}
//会员等级管理 
function memberlevels_check(){
	var user_rank_name = document.getElementById('user_rank_name_'+now_locale);
	layer_dialog();
	if( Trim( user_rank_name.value,'g' ) == "" ){
		layer_dialog_show("会员等级名称不能为空!","",3);
		return false;
	}
}
//虚拟卡管理 
function virtual_cards_check(){
	var ProductsCategory = document.getElementById('ProductsCategory');
	var virtual_cards_name = document.getElementById('virtual_cards_name_'+now_locale);
	layer_dialog();
	if( Trim( virtual_cards_name.value,'g' ) == "" ){
		layer_dialog_show("商品名称不能为空!","",3);
		return false;
	}
	if(ProductsCategory.value==0){
		layer_dialog_show("商品分类必须选择!","",3);
		return false;
	
	}

}
//促销活动管理
function promotions_check(){
	var promotion_title = document.getElementById('promotion_title_'+now_locale);
	layer_dialog();
	if( Trim( promotion_title.value,'g' ) == "" ){
		layer_dialog_show("商品名称不能为空!","",3);
		return false;
	}
}
//贺卡管理
function cards_check(){
	var cards_name = document.getElementById('cards_name_'+now_locale);
	layer_dialog();
	if( Trim( cards_name.value,'g' ) == "" ){
		layer_dialog_show("贺卡名称不能为空!","",3);
		return false;
	}

}

//电子优惠券管理
function coupons_check(){
	var coupontype_name = document.getElementById('coupontype_name_'+now_locale);
	layer_dialog();
	if( Trim( coupontype_name.value,'g' ) == "" ){
		layer_dialog_show("电子优惠券名称不能为空!","",3);
		return false;
	}


}
//包装
function packages_check(){
	var Packaging_name = document.getElementById('Packaging_name_'+now_locale);
	layer_dialog();
	if( Trim( Packaging_name.value,'g' ) == "" ){
		layer_dialog_show("包装名称不能为空!","",3);
		return false;
	}

}
//专题管理
function topics_check(){
	var topic_title = document.getElementById('topic_title_'+now_locale);
	layer_dialog();
	if( Trim( topic_title.value,'g' ) == "" ){
		layer_dialog_show("专题名称不能为空!","",3);
		return false;
	}
}
/*********************************************************************************
* 检查输入的Email
* function	: 	isEmailFormat
* inStr		:	字串符
* 说明		:	1：正确 0：错误
**********************************************************************************/
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
/*	1.去除字符串前后所有空格
	2.去除字符串中所有空格(包括中间空格,需要设置第2个参数为:g)*/
function Trim(str,is_global){
	var result; 
	result = str.replace(/(^\s+)|(\s+$)/g,"");
	if(is_global.toLowerCase()=="g")
		result = result.replace(/\s/g,"");
	return result;
}





function check() { 
	var lee=document.forms["login_form"].cookie;
	var cookie = document.getElementById("cookie").value;
	if (lee.checked == true){ 
		ajax_login(cookie);
	}else{ 
		ajax_login('');
	} 
} 
//onkeydown
document.onkeydown = function(evt){
	var evt = window.event?window.event:evt;
	if(evt.keyCode==13)
	{
		var UserName = document.getElementById('operator_id').value;
		var UserPassword = document.getElementById('operator_pwd').value;
		var UserCaptcha = document.getElementById('authnum').value;
		if(UserName != "" && UserPassword != "" && UserCaptcha != ""){
			check();
		}
	}
}
function ajax_login(cookie){
		YAHOO.example.container.wait.show();
		var operator_pwd =document.getElementById("operator_pwd").value;
		var operator_id =document.getElementById("operator_id").value;
		var authnum = document.getElementById("authnum").value;
		var locale = document.getElementById("locale").value;
		var oCheckbox   =document.getElementById("cookie");  
		var sUrl = webroot_dir+"pages/act_login/";
		//check();
		var postData = "operator_pwd="+operator_pwd+"&operator="+operator_id+"&authnum="+authnum+"&locale="+locale+"&cookie="+cookie;
		//alert(postData);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, ajax_login_callback,postData);
	}

	var ajax_login_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");  
			alert(o.responseText); 
			YAHOO.example.container.wait.hide();
		} 
		if(result.type=="0"){
			window.location.href= webroot_dir+"pages/home";
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			show_login_captcha();
			//document.getElementById("login_msg").innerHTML = result.error_msg;
			YAHOO.example.container.message.show();	
			YAHOO.example.container.wait.hide();
		}
	}
	var ajax_login_Failure = function(o){
		alert("error");
		YAHOO.example.container.wait.hide();
	}
	var ajax_login_callback ={
		success:ajax_login_Success,
		failure:ajax_login_Failure,
		timeout : 30000,
		argument: {}
	};
function break_config(){
	window.location.href=webroot_dir;


}