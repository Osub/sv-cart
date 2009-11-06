


YAHOO.namespace("example.container");

function init() {


YAHOO.example.container.manager = new YAHOO.widget.OverlayManager();


YAHOO.example.container.wait = new YAHOO.widget.Panel("wait",{ width:"240px", fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
YAHOO.example.container.wait.setHeader("<div style='background:#fff;width:100%;padding-top:5px;margin-top:2px;text-align:center'>操作中,请稍后...</div>");
YAHOO.example.container.wait.setBody("<object data='"+root_all+'sv-admin/'+themePath+"img/loading.swf' type='application/x-shockwave-flash' width='240' height='30'><param name='movie' value='"+root_all+"sv-admin/img/loading.swf' /><param name='wmode' value='Opaque'></object>");
//YAHOO.example.container.wait.setBody("<object id='loading' data='../../img/loading.swf' type='application/x-shockwave-flash' width='240' height='40'><param name='movie' value='../../img/loading.swf' /><param name='wmode' value='Opaque'></object>");

YAHOO.example.container.wait.render(document.body);


YAHOO.example.container.message = new YAHOO.widget.Panel("message",{width:"640px", fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
YAHOO.example.container.message.setBody("<div id='message_content'></div>");
YAHOO.example.container.message.render(document.body);

YAHOO.util.Dom.setStyle('svcart-com', 'visibility', 'visible');

//列表鼠标划动效果
if (document.getElementById("listDiv")){
	var this_bgcolor = "";
	document.getElementById("listDiv").onmouseover = function(e){
	    obj = Utils.srcElement(e);
		if (obj){
			if (obj.parentNode.tagName.toLowerCase() == "tr") row = obj.parentNode;
				else if (obj.parentNode.parentNode.tagName.toLowerCase() == "tr") row = obj.parentNode.parentNode;
				else return;
				for (i = 0; i < row.cells.length; i++){
		        	if (row.cells[i].tagName != "TH"){
		        		this_bgcolor = row.cells[i].className;
		        		row.cells[i].className = 'hover';
		        	}
		 		}
		}
	}
	document.getElementById("listDiv").onmouseout = function(e){
    	obj = Utils.srcElement(e);
		if (obj){
	      	if (obj.parentNode.tagName.toLowerCase() == "tr") row = obj.parentNode;
		      	else if (obj.parentNode.parentNode.tagName.toLowerCase() == "tr") row = obj.parentNode.parentNode;
		      	else return;
				for (i = 0; i < row.cells.length; i++){
		          	if (row.cells[i].tagName != "TH"){
		          		row.cells[i].className= this_bgcolor;
		          	}
		      	}
    	}
  	}
}
//end
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

/****leo20090513*****************************************************************************
使用说明:
  例:
* GetId("zheng").innerHTML)
* GetTag("li").length  
* GetChildTag(GetId("zheng"),"li").length+"个li"
* GetClass("zheng")[0].innerHTML+GetClass("zheng")[1].innerHTML
*********************************************************************************/
//通过ID获取对象
function GetId(id){
	return document.getElementById(id)
}  
//通过NAME获取对象
function GetName(name){
	return document.getElementsByName(name)
}
//通过Tag获取对象
function GetTag(tag){
	return document.getElementsByTagName(tag)
}
//通过Tag获取ID的子对象
function GetChildTag(id,tag){
	return id.getElementsByTagName(tag)
}  
//通过className获取对象
function GetClass(className){
	return getElementsByClassName(className)
}  
var $c=function(array){var nArray = [];for (var i=0;i<array.length;i++) nArray.push(array[i]);return nArray;};
    Array.prototype.each=function(func){for(var i=0,l=this.length;i<l;i++) {func(this[i],i);};};
var getElementsByClassName=function(cn){
        var hasClass=function(w,Name){
	        var hasClass = false;
	        w.className.split(' ').each(function(s){
	            if (s == Name) hasClass = true;
	        });
	        return hasClass;
        }; 
        var elems =document.getElementsByTagName("*")||document.all;
		var elemList = [];
		$c(elems).each(function(e){
			if(hasClass(e,cn)){elemList.push(e);}
		})
		return $c(elemList);
};

function selectAll(obj, chk)
{
  if (chk == null)
  {
    chk = 'checkboxes';
  }
  var elems = obj.form.getElementsByTagName("INPUT");
  for (var i=0; i < elems.length; i++)
  {
    if (elems[i].name == chk || elems[i].name == chk + "[]")
    {
      elems[i].checked = obj.checked;
    }
  }
}


/*******************************************************************
leo 2009-1-5

使用说明
list:checkbox的VALUE集合
obj:this
chk:要选中的name复选框

frm: this.form
checkbox: this
**************************************************** ***************/
//操作员分批全选
function check(list, obj,chk)
{
  var frm = obj.form;

    for (i = 0; i < frm.elements.length; i++)
    {
      if (frm.elements[i].name == chk+"[]")
      {
          var regx = new RegExp(frm.elements[i].value + "(?!_)", "i");

          if (list.search(regx) > -1) frm.elements[i].checked = obj.checked;
      }
    }
}
//操作员复选框全部选取
function checkAll(frm, checkbox){
	for(i = 0; i < frm.elements.length; i++){
		if( frm.elements[i].type == "checkbox" ){
			frm.elements[i].checked = checkbox.checked;
		}
	}
}

//赠品（特惠品）商品
function special_preference(){
	var sp_obj = document.getElementById('special_preference');
	var good_obj = document.getElementById('source_select1');
}

/********************/
	//window.open图片管理
	function img_sel(number,assign_dir){
		
		var win = window.open (webroot_dir+"images/?status=1", 'newwindow', 'height=600, width=800, top=0, left=0, toolbar=no, menubar=yes, scrollbars=yes,resizable=yes,location=no, status=no');
		GetId('img_src_text_number').value = number;
		GetId("assign_dir").value = assign_dir;
	}
	function img_src_return(img_obj){
		if( window_option_status == 1 ){
			var img_src_text_number = window.opener.GetId('img_src_text_number').value;
			var src_arr = img_obj.src.split("/");
			var j=0;
			var src_str = "";
			for(var i=3;i<=src_arr.length-1;i++){
				src_str+="/"+src_arr[i];
				j++;
			}
			window.opener.GetId('upload_img_text_'+img_src_text_number).value = img_obj.name;
			window.opener.GetId('img_src_text_number').value = "";
			window.opener.GetId('logo_thumb_img_'+img_src_text_number).src = src_str;
			window.opener.GetId('logo_thumb_img_'+img_src_text_number).style.display="block";
			window.close();
		}
	}
	//遮罩层JS
	
	function layer_dialog(){
		tabView = new YAHOO.widget.TabView('contextPane'); 
        layer_dialog_obj = new YAHOO.widget.Overlay("layer_dialog", 
							{
								width:"422px",
								visible:false,
								draggable:false,
								modal:true,close: true,
								fixedcenter: true,zindex:"40"
							} 
						); 
		layer_dialog_obj.render();
	}
	//后台对话框
	/***************************提示信息********连接地址********3*******类拟alert					*/
	/***************************提示信息********连接地址********4*******类拟alert   加刷新			*/
	/***************************提示信息********函数************5*******类拟confirm但用法不一样		*/
	function layer_dialog_show(admin_dialog_content,url_or_function,button_num){
		if(url_or_function!=''){
			GetId('confirm').value = url_or_function;//删除层传URL
		}
		
		//alert(document.getElementById("dialog_content").innerHTML);
		GetId('admin_dialog_content').innerHTML = admin_dialog_content;//对话框中的中文
		var button_replace = GetId('admin_button_replace');
		if(button_num==3){
			button_replace.innerHTML = "<a href='javascript:layer_dialog_obj.hide();' style='padding-right:50px;'>确定</a>";
		}
		if(button_num==4){
			button_replace.innerHTML = "<a href='javascript:window.location.reload();' style='padding-right:50px;'>确定</a>";
		}
		if(button_num==5){
			button_replace.innerHTML = "<a href='javascript:layer_dialog_obj.hide();' >取消</a><a href='javascript:layer_dialog_obj.hide();"+url_or_function+";' >确定</a>";

		}
		if(button_num==6){
			button_replace.innerHTML = "<a href='javascript:layer_dialog_obj.hide();YAHOO.example.container.wait.hide();' >取消</a><a href="+url_or_function+" style='padding-right:50px;'>确定</a>";
		}
		layer_dialog_obj.show();
	}
	function layer_dialog_hide(){
		GetId('layer_dialog').style.display = "none";
	}
	//确认后操作
	function confirm_record(){
		var sUrl = GetId('confirm').value;
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

function change_captcha(){
	GetId("authnum_img").src = webroot_dir+"authnums/get_authnums/?"+Math.random();
}


function show_login_captcha(){
	GetId("authnum_img_span").style.display = "";
	GetId("authnum").value = "";
	if(GetId("authnum_img").src != ""){
		return;
	}
	GetId("authnum_img").src = webroot_dir+"authnums/get_authnums/?"+Math.random();
}

//指定输入框为数字主要为排序
function check_input_num(obj){
	obj.value=obj.value.replace(/[^\d]/g,'');
}



//关键字管理
function keywords_check(){
	var SeoKeywordname = GetId('SeoKeywordname');
	if( Trim(SeoKeywordname.value,'g') == "" ){
		layer_dialog();
		layer_dialog_show("关键词不能为空!","",3);
		return false;
	}
	
}
//用户信息管理
function userinformations_check(){
	var name = GetId('name'+now_locale);
	if( Trim(name.value,'g') == "" ){
		layer_dialog();
		layer_dialog_show("名称不能为空!","",3);
		return false;
	}
	
}
//用户设置管理
function userconfigs_checks(){
	var name = GetId('nowname'+now_locale);
	if( Trim(name.value,'g') == "" ){
		layer_dialog();
		layer_dialog_show("用户名称不能为空!","",3);
		return false;
	}
}
//商店设置管理 
function userconfigs_check(){
	var name = GetId('name'+now_locale);
	var config_group = GetId('config_group');
	var config_code = GetId('config_code');
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
	var operatoraction_parentid = GetId('operatoraction_parentid');
	var name = GetId('name'+now_locale);
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
	var name = GetId('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("菜单名称不能为空!","",3);
		return false;
	}
}
//邮件模板管理
function mailtemplates_check(){
	var title = GetId('title'+now_locale);
	var data_mailtemplate_code = GetId('data_mailtemplate_code');

	layer_dialog();
	if( Trim( title.value,'g' ) == "" ){
		layer_dialog_show("邮件主题不能为空!","",3);
		return false;
	}
	if( Trim( data_mailtemplate_code.value,'g' ) == "" ){
		layer_dialog_show("邮件编号不能为空!","",3);
		return false;
	}
}

//语言管理 
function languages_check(){
	var language_name = GetId('language_name');
	var language_locale = GetId('language_locale');
	var language_charset = GetId('language_charset');
	var language_map = GetId('language_map');
	var language_google_translate_code = GetId('language_google_translate_code');
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
	var name = GetId('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("支付方式名称不能为空!","",3);
		return false;
	}

}

//配送区域
function shippingments_check(){
	var name = GetId('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("配送区域名称不能为空!","",3);
		return false;
	}
}

//导航设置 
function navigations_check(){
	var name = GetId('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("导航名称不能为空!","",3);
		return false;
	}
}
//广告管理
function advertisements_check(){
	var advertisement_name = GetId('advertisement_name_'+now_locale);
	var data_AdvertisementI18n_start_time = GetId('date');
	var data_AdvertisementI18n_end_time = GetId('date2');
	layer_dialog();
	if( Trim( advertisement_name.value,'g' ) == "" ){
		layer_dialog_show("广告名称不能为空!","",3);
		return false;
	}
	if( Trim( data_AdvertisementI18n_start_time.value,'g' ) == "" ){
		layer_dialog_show("开始时间不能为空!","",3);
		return false;
	}
	if( Trim( data_AdvertisementI18n_end_time.value,'g' ) == "" ){
		layer_dialog_show("结束时间不能为空!","",3);
		return false;
	}
}
//友情链接管理 
function links_check(){
	var name = GetId('name'+now_locale);
	var url = GetId('url'+now_locale);
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
	var provider_name = GetId('provider_name');
	layer_dialog();
	if( Trim( provider_name.value,'g' ) == "" ){
		layer_dialog_show("供应商名称不能为空!","",3);
		return false;
	}
}

//Sitemap
function sitemap_check(){
	var name = GetId('name');
	var url = GetId('url');
	var orderby = GetId('orderby');
	var cycle = GetId('cycle');
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("模块名称不能为空!","",3);
		return false;
	}
	if( Trim( url.value,'g' ) == "" ){
		layer_dialog_show("URL不能为空!","",3);
		return false;
	}
	
}


//部门管理
function departments_check(){
	var name = GetId('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("部门名称不能为空!","",3);
		return false;
	}
}

//角色管理
function roles_check(){
	var name = GetId('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("角色名称不能为空!","",3);
		return false;
	}
}

//操作员管理 
function operators_check(){
	var OperatorName = GetId('OperatorName');
	var OperatorEmail = GetId('OperatorEmail');
	var NewPassword = GetId('NewPassword');
	var ConfirmPassword = GetId('ConfirmPassword');
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
	var name = GetId('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("实体店名称不能为空!","",3);
		return false;
	}
}
//会员管理
function users_check(){
	var user_email = GetId('user_email');
	var user_new_password = GetId('user_new_password');
	var user_new_password2 = GetId('user_new_password2');
	
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
	var ProductsCategory = GetId('ProductsCategory');
	var productes_name = GetId('product_name_'+now_locale);
	var ProductPromotionStatus = GetId('ProductPromotionStatus');
	var ProductPromotionPrice= GetId('ProductPromotionPrice');
	var date= GetId('date');
	var date2= GetId('date2');	
	layer_dialog();
	if( Trim( productes_name.value,'g' ) == "" ){
		layer_dialog_show("商品名称不能为空!","",3);
		return false;
	}
	if(ProductsCategory.value==0){
		layer_dialog_show("商品分类必须选择!","",3);
		return false;	
	}
	if(ProductPromotionStatus.checked){
		if( Trim( ProductPromotionPrice.value,'g' ) == "" ){
			layer_dialog_show("促销价不能为空!","",3);
			return false;
		}
		if( Trim( date.value,'g' ) == "" || Trim( date2.value,'g' ) == "" ){
			layer_dialog_show("促销日期不能为空!","",3);
			return false;
		}			
	}

}
function product_code_unique(obj,product_id){
	//YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"products/product_code_unique/"+obj.value+"/"+product_id;

	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, product_code_unique_callback);
}
var product_code_unique_Success = function(o){
	var productbassic = document.getElementById("productbassic");
	//YAHOO.example.container.wait.hide();
	if(o.responseText){
	}else{
		var pcode = GetName("data[Product][code]");
		pcode[0].value = "";
		layer_dialog();
		layer_dialog_show("货号已经存在请重新输入!","",3);
	}
	
}
var product_code_unique_Failure = function(o){
	YAHOO.example.container.wait.hide();
}
var product_code_unique_callback ={
	success:product_code_unique_Success,
	failure:product_code_unique_Failure,
	timeout : 30000,
	argument: {}
};
//商品类型管理 
function productstypes_check(){
	var name = GetId('name'+now_locale);
	layer_dialog();
	if( Trim( name.value,'g' ) == "" ){
		layer_dialog_show("商品类型名称不能为空!","",3);
		return false;
	}
}
//商品属性管理
function products_attribute(){
	var attribute_name = GetId("attribute_name_"+now_locale);
	layer_dialog();
	if( Trim( attribute_name.value,'g' ) == "" ){
		layer_dialog_show("属性名称不能为空!","",3);
		return false;
	}
}
//商品分类管理 
function categories_P_check(){
	var category_name = GetId('category_name_'+now_locale);
	layer_dialog();
	if( Trim( category_name.value,'g' ) == "" ){
		layer_dialog_show("分类名称不能为空!","",3);
		return false;
	}
}
//文章分类管理 
function categories_A_check(){
	var category_name = GetId('category_name_'+now_locale);
	layer_dialog();
	if( Trim( category_name.value,'g' ) == "" ){
		layer_dialog_show("分类名称不能为空!","",3);
		return false;
	}
	
}
//品牌管理
function brands_check(){
	var brand_name = GetId('brand_name_'+now_locale);
	layer_dialog();
	if( Trim( brand_name.value,'g' ) == "" ){
		layer_dialog_show("品牌名称不能为空!","",3);
		return false;
	}

}
//文章管理
function articles_check(){
	var article_name = GetId('article_name_'+now_locale);
	layer_dialog();
	if( Trim( article_name.value,'g' ) == "" ){
		layer_dialog_show("文章标题不能为空!","",3);
		return false;
	}

}
//会员等级管理 
function memberlevels_check(){
	var user_rank_name = GetId('user_rank_name_'+now_locale);
	layer_dialog();
	if( Trim( user_rank_name.value,'g' ) == "" ){
		layer_dialog_show("会员等级名称不能为空!","",3);
		return false;
	}
}
//虚拟卡管理 
function virtual_cards_check(){
	var ProductsCategory = GetId('ProductsCategory');
	var virtual_cards_name = GetId('virtual_cards_name_'+now_locale);
	var ProductPromotionStatus = GetId('ProductPromotionStatus');
	var ProductPromotionPrice= GetId('ProductPromotionPrice');
	var date= GetId('date');
	var date2= GetId('date2');	
	layer_dialog();	
	if( Trim( virtual_cards_name.value,'g' ) == "" ){
		layer_dialog_show("商品名称不能为空!","",3);
		return false;
	}
	if(ProductsCategory.value==0){
		layer_dialog_show("商品分类必须选择!","",3);
		return false;	
	}
	if(ProductPromotionStatus.checked){
		if( Trim( ProductPromotionPrice.value,'g' ) == "" ){
			layer_dialog_show("促销价不能为空!","",3);
			return false;
		}
		if( Trim( date.value,'g' ) == "" || Trim( date2.value,'g' ) == "" ){
			layer_dialog_show("促销日期不能为空!","",3);
			return false;
		}
	}	
}
//下载服务管理 
function download_product_check(){
	var ProductsCategory = GetId('ProductsCategory');
	var Product_name = GetId('down_name_'+now_locale);
	var ProductPromotionStatus = GetId('ProductPromotionStatus');
	var ProductPromotionPrice= GetId('ProductPromotionPrice');
	var date= GetId('date');
	var date2= GetId('date2');
	layer_dialog();
	if( Trim( Product_name.value,'g' ) == "" ){
		layer_dialog_show("商品名称不能为空!","",3);
		return false;
	}
	if(ProductsCategory.value==0){
		layer_dialog_show("商品分类必须选择!","",3);
		return false;	
	}
	if(ProductPromotionStatus.checked){
		if( Trim( ProductPromotionPrice.value,'g' ) == "" ){
			layer_dialog_show("促销价不能为空!","",3);
			return false;
		}
		if( Trim( date.value,'g' ) == "" || Trim( date2.value,'g' ) == "" ){
			layer_dialog_show("促销日期不能为空!","",3);
			return false;
		}			
	}		
}

//促销活动管理
function promotions_check(){
	var promotion_title = GetId('promotion_title_'+now_locale);
	var data_Promotion_end_time = GetId("date2");
	var data_Promotion_start_time = GetId("date");
	layer_dialog();
	if( Trim( promotion_title.value,'g' ) == "" ){
		layer_dialog_show("商品名称不能为空!","",3);
		return false;
	}	
	if( Trim( data_Promotion_end_time.value,'g' ) == "" ){
		layer_dialog_show("促销结束日期不能为空!","",3);
		return false;
	}	
	if( Trim( data_Promotion_start_time.value,'g' ) == "" ){
		layer_dialog_show("促销起始日期不能为空!","",3);
		return false;
	}
}
//贺卡管理
function cards_check(){
	var cards_name = GetId('cards_name_'+now_locale);
	layer_dialog();
	if( Trim( cards_name.value,'g' ) == "" ){
		layer_dialog_show("贺卡名称不能为空!","",3);
		return false;
	}

}

//电子优惠券管理
function coupons_check(){
	var coupontype_name = GetId('coupontype_name_'+now_locale);
	var date = GetId("date");
	var date2 = GetId("date2");
	var date3 = GetId("date3");
	var date4 = GetId("date4");
	layer_dialog();
	if( Trim( coupontype_name.value,'g' ) == "" ){
		layer_dialog_show("电子优惠券名称不能为空!","",3);
		return false;
	}	
	if( Trim( date.value,'g' ) == "" ){
		layer_dialog_show("发放起始日期不能为空!","",3);
		return false;
	}
	if( Trim( date2.value,'g' ) == "" ){
		layer_dialog_show("发放结束日期不能为空!","",3);
		return false;
	}
	if( Trim( date3.value,'g' ) == "" ){
		layer_dialog_show("使用起始日期不能为空!","",3);
		return false;
	}
	if( Trim( date4.value,'g' ) == "" ){
		layer_dialog_show("使用结束日期不能为空!","",3);
		return false;
	}


}
//包装
function packages_check(){
	var Packaging_name = GetId('Packaging_name_'+now_locale);
	layer_dialog();
	if( Trim( Packaging_name.value,'g' ) == "" ){
		layer_dialog_show("包装名称不能为空!","",3);
		return false;
	}

}
//专题管理
function topics_check(){
	var topic_title = GetId('topic_title_'+now_locale);
	layer_dialog();
	if( Trim( topic_title.value,'g' ) == "" ){
		layer_dialog_show("专题名称不能为空!","",3);
		return false;
	}
}

//批次管理
function batch_check(){
	var batch_code = GetId('data[Batch][code]');
	var batch_provider = GetId('data[Batch][provider_id]');
	if( Trim( batch_code.value,'g' ) == "" ){
		layer_dialog_show("批次号不能为空!","",3);
		return false;
	}
	if( Trim( batch_provider.value,'g' ) == "-1" ){
		layer_dialog_show("请选择供应商!","",3);
		return false;
	}
}

//仓库管理
function warehouse_check(){
	var warehouse_code = GetId('data[Warehouse][code]');
	var warehouse_name = GetId('data[Warehouse][warehouse_name]');
	var contact_name = GetId('data[Warehouse][contact_name]');
	var contact_email = GetId('data[Warehouse][contact_email]');
	var warehouse_address = GetId('data[Warehouse][address]');
	var warehouse_zipcode = GetId('data[Warehouse][zipcode]');
	var warehouse_telephone = GetId('data[Warehouse][telephone]');
	
	if( Trim( warehouse_code.value,'g' ) == "" ){
		layer_dialog_show("仓库代码不能为空!","",3);
		return false;
	}
	if( Trim( warehouse_name.value,'g' ) == "" ){
		layer_dialog_show("仓库名称不能为空!","",3);
		return false;
	}
	
	if( Trim( contact_name.value,'g' ) == "" ){
		layer_dialog_show("联系人姓名不能为空!","",3);
		return false;
	}
	
	if( Trim( contact_email.value,'g' ) == "" ){
		layer_dialog_show("Email不能为空!","",3);
		return false;
	}
	
	if(isEmailFormat(contact_email.value)==0){
		layer_dialog_show("Email地址不正确!","",3);
		return false;
	}
	
	if( Trim( warehouse_address.value,'g' ) == "" ){
		layer_dialog_show("仓库地址不能为空!","",3);
		return false;
	}
	
	if( Trim( warehouse_zipcode.value,'g' ) == "" ){
		layer_dialog_show("邮编不能为空!","",3);
		return false;
	}
	
	if( Trim( warehouse_telephone.value,'g' ) == "" ){
		layer_dialog_show("电话不能为空!","",3);
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





function ajax_login_check() { 
	var lee=document.forms["login_form"].cookie;
	var cookie = GetId("cookie").value;
	if (lee.checked == true){ 
		ajax_login(cookie);
	}else{ 
		ajax_login('');
	} 
} 
//onkeydown
/*
function login_event(e){
	if(window.event){
		keynum = e.keyCode
	}else if(e.which){
		keynum = e.which
	}
	if(keynum==13)
	{	
		var UserName = GetId('operator_id').value;
		var UserPassword = GetId('operator_pwd').value;
		var UserCaptcha = GetId('authnum').value;
		if(UserName != "" && UserPassword != "" && UserCaptcha != ""){
			check();
		}
	}

}*/
function ajax_login(cookie){
		YAHOO.example.container.wait.show();
		var operator_pwd =GetId("operator_pwd").value;
		var operator_id =GetId("operator_id").value;
		var authnum = GetId("authnum").value;
		var locale = GetId("locale").value;
		var oCheckbox   =GetId("cookie");  
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
		if(result.type=="5"){
			window.location.href=result.url
			return;
		}
		
		if(result.type=="0"){
			window.location.href= webroot_dir+"pages/home";
		}else{
			GetId('message_content').innerHTML = result.message;
			show_login_captcha();
			//GetId("login_msg").innerHTML = result.error_msg;
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

//分页回车
function pagers_onkeypress(obj,e){
	if(window.event){
		keynum = event.keyCode
	}else if(e.which){
		keynum = e.which
	} 
	if(keynum==13){
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"pages/pagers_num/"+obj.value;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, ajax_pagers_callback);
	}  
}   
var ajax_pagers_Success = function(o){
	window.location.reload();
}
var ajax_pagers_Failure = function(o){
	YAHOO.example.container.wait.hide();
}
var ajax_pagers_callback ={
	success:ajax_pagers_Success,
	failure:ajax_pagers_Failure,
	timeout : 30000,
	argument: {}
};




//后台问号帮助信息
function help_show_or_hide(text_id){
	var text_help = GetId(text_id);
	if(text_help.style.display  == "none"){
		text_help.style.display  = "block";
	}else{
		text_help.style.display  = "none";
	
	}
}

//Tab
	function overtab(name,cursel,n){ 
		for(i=1;i<=n;i++){ 
		var menu=document.getElementById(name+i); 
		var con=document.getElementById("con_"+name+"_"+i); 
		menu.className=i==cursel?"hover":"normal"; 
		con.className=i==cursel?"display":"none"; 
		} 
	}

//后台关于svcart层
function sys_about(){
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"pages/sys_about/?status=1";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, sys_about_callback);
}
var sys_about_Success = function(o){
	//var sys_messages = YAHOO.lang.JSON.parse(o.responseText);
	document.getElementById('message_content').innerHTML = o.responseText;
	YAHOO.example.container.wait.hide();
	YAHOO.example.container.message.show();
}
var sys_about_Failure = function(o){
	YAHOO.example.container.wait.hide();
}
var sys_about_callback ={
	success:sys_about_Success,
	failure:sys_about_Failure,
	timeout : 30000,
	argument: {}
};
//后台账户设置
function account_settings(){
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"pages/account_settings/?status=1";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, account_settings_callback);
}
var account_settings_Success = function(o){
	//var sys_messages = YAHOO.lang.JSON.parse(o.responseText);
	document.getElementById('message_content').innerHTML = o.responseText;
	YAHOO.example.container.wait.hide();
	YAHOO.example.container.message.show();
}
var account_settings_Failure = function(o){
	YAHOO.example.container.wait.hide();
}
var account_settings_callback ={
	success:account_settings_Success,
	failure:account_settings_Failure,
	timeout : 30000,
	argument: {}
};
//修改密码确认
function confirm_password(){
		var old_pwd = document.getElementById('old_pwd');
		var new_pwd = document.getElementById('new_pwd');
		var new_pwd_confirm = document.getElementById('new_pwd_confirm');
		
		var pwd_information = document.getElementById('pwd_information');
		var Operator_time_zone = document.getElementById('Operator_time_zone');
		if(new_pwd.value!=new_pwd_confirm.value&&new_pwd_confirm.value!=""){
			pwd_information.innerHTML = "两次密码输入不一样";
			return false;
		}else{
			pwd_information.innerHTML = "";
		}
		if(old_pwd.value!=""&&new_pwd.value==""){
			pwd_information.innerHTML = "新密码不能为空";
			return false;
		}
		if(old_pwd.value!=""&&new_pwd_confirm.value==""){
			pwd_information.innerHTML = "新密码不能为空";
			return false;
		}
		
		var sUrl = webroot_dir+"operators/ajax_amend_now_pwd/"+old_pwd.value+"/"+new_pwd.value+"/?Operator_time_zone="+Operator_time_zone.value;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_password_callback);
		

	}

	var confirm_password_Success = function(o){
		var new_pwd = document.getElementById('new_pwd');
		var new_pwd_confirm = document.getElementById('new_pwd_confirm');
		var pwd_information = document.getElementById('pwd_information');
		var old_pwd = document.getElementById('old_pwd');
		if(o.responseText==0){
			old_pwd.value="";
			new_pwd.value="";
			new_pwd_confirm.value="";
			pwd_information.innerHTML = "密码输入错误!"
			
		}else{
			pwd_information.innerHTML = "";
			old_pwd.value="";
			new_pwd.value="";
			new_pwd_confirm.value="";
			document.getElementById('pwd_confirm').style.display = "block";
			document.getElementById('pwd_text').style.display = "none";
		}
	}
	
	var confirm_password_Failure = function(o){
		//alert("error");
	}

	var confirm_password_callback ={
		success:confirm_password_Success,
		failure:confirm_password_Failure,
		timeout : 10000,
		argument: {}
	};

//后台在线帮助快捷窗口
function online_help_div(){
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"pages/online_help_div/?status=1";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, online_help_div_callback);
}
var online_help_div_Success = function(o){
	//var sys_messages = YAHOO.lang.JSON.parse(o.responseText);
	document.getElementById('message_content').innerHTML = o.responseText;
	YAHOO.example.container.wait.hide();
	YAHOO.example.container.message.show();
}
var online_help_div_Failure = function(o){
	YAHOO.example.container.wait.hide();
}
var online_help_div_callback ={
	success:online_help_div_Success,
	failure:online_help_div_Failure,
	timeout : 30000,
	argument: {}
};
function online_help_go(){
	document.getElementById('online_help_link').href = "http://www.seevia.cn/articles/search/" + document.getElementById('online_help_value').value;
	oh_big_panel.hide();
}

//后台插件搜索
function plugin_search(){
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"pages/plugin_search/?status=1";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, plugin_search_callback);
}
var plugin_search_Success = function(o){
	//var sys_messages = YAHOO.lang.JSON.parse(o.responseText);
	document.getElementById('message_content').innerHTML = o.responseText;
	YAHOO.example.container.wait.hide();
	YAHOO.example.container.message.show();
}
var plugin_search_Failure = function(o){
	YAHOO.example.container.wait.hide();
}
var plugin_search_callback ={
	success:plugin_search_Success,
	failure:plugin_search_Failure,
	timeout : 30000,
	argument: {}
};
function plugin_search_go(){
	var search_value = document.getElementById('plugin_search_value').value;
	if(search_value == "")
		search_value = "all";
		document.getElementById('plugin_search_link').href = "http://www.seevia.cn/products/advancedsearch/SAD/" + search_value + "/82/";
}
//后台清除缓存
function clear_cache_bt(){
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"pages/clear_cache_bt/?status=1";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, clear_cache_bt_callback);
}
var clear_cache_bt_Success = function(o){
	//var sys_messages = YAHOO.lang.JSON.parse(o.responseText);
	document.getElementById('message_content').innerHTML = o.responseText;
	YAHOO.example.container.wait.hide();
	YAHOO.example.container.message.show();
}
var clear_cache_bt_Failure = function(o){
	YAHOO.example.container.wait.hide();
}
var clear_cache_bt_callback ={
	success:clear_cache_bt_Success,
	failure:clear_cache_bt_Failure,
	timeout : 30000,
	argument: {}
};
	function clear_cache(){
	    var app_checkbox = document.getElementsByName('app_checkbox');
	    if(app_checkbox.length > 0){
	    	var sPost = Array();
	    	var j = 0;
			for(var i=0;i<app_checkbox.length;i++){
				if(app_checkbox[i].checked === true){
					sPost[j] = app_checkbox[j].value;
					j++;
				}
			}
			if(sPost.length>0){
		    	var sUrl = webroot_dir+"pages/clear_cache";
		   		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, clear_cache_callback, 'dir_name='+sPost.join(','));
	    	}
	    }
	    
	}

	var clear_cache_Success = function(oResponse){
		document.getElementById('clear_cache_msg').innerHTML = '共清除缓存文件:'+oResponse.responseText+'个';
		document.getElementById('cc_confirm').style.display = "block";
		document.getElementById('cc_text').style.display = "none";
	}
	var clear_cache_Failure = function(o){
		alert("error");
	}
	var clear_cache_callback ={
		success:clear_cache_Success,
		failure:clear_cache_Failure,
		timeout : 100000,
		argument: {}
	};
	function app_checkAll(){
		var app_checkbox = document.getElementsByName('app_checkbox');
		if(document.getElementById('app_chkall').checked == true){
			for(var i=0;i<app_checkbox.length;i++){
				app_checkbox[i].checked = true;
			}
		}
		else{
			for(var i=0;i<app_checkbox.length;i++){
				app_checkbox[i].checked = false;
			}
		}
	}
	function check_checked(){
		var app_checkbox = document.getElementsByName('app_checkbox');
		for(var i=0;i<app_checkbox.length;i++){
			if(app_checkbox[i].checked == false){
				document.getElementById('app_chkall').checked = false;
				return ;
			}
				
		}
		document.getElementById('app_chkall').checked = true;
	}
//google翻译
function google_shortcut(){
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"pages/google_shortcut/?status=1";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, google_shortcut_callback);
}
var google_shortcut_Success = function(o){
	//var sys_messages = YAHOO.lang.JSON.parse(o.responseText);
	document.getElementById('message_content').innerHTML = o.responseText;
	YAHOO.example.container.wait.hide();
	YAHOO.example.container.message.show();
}
var google_shortcut_Failure = function(o){
	YAHOO.example.container.wait.hide();
}
var google_shortcut_callback ={
	success:google_shortcut_Success,
	failure:google_shortcut_Failure,
	timeout : 30000,
	argument: {}
};
   //实现google接口翻译功能
   	function g_trans(){
	
	    var original_text = document.getElementById('original_text').value;
   	    var lang_obj = document.getElementById("g_language");
 	    var google_translate_information = document.getElementById('google_translate_information');
 	    if(original_text.length <= 0){
	   		google_translate_information.innerHTML = "请填写原文";
	   		return false;
	   }else{
	   		google_translate_information.innerHTML = "";
	   }
	   var i=0;
	   while(true){
			if(document.getElementById('g_trans'+i) == null){
				break;
			}
			var lang_value = document.getElementById('g_trans'+i).name;
			var g_translation = document.getElementById('g_trans'+i);
			var sUrl = webroot_dir+"pages/g_translate/"+lang_value+"/"+original_text+"/"+i;
			var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, g_trans_callback);
			i++;
 		}
	}
	
	var g_trans_Success = function(o){
		var result = o.responseText;
		result = result.split("|");
		var g_trans = document.getElementById('g_trans'+result[1]);
		g_trans.value = result[0];
	}
	
	var g_trans_Failure = function(o){
		alert("error:"+o.statusText);
	}
	
	var g_trans_callback ={
		success:g_trans_Success,
		failure:g_trans_Failure,
		timeout : 10000,
		argument: {}
	};
//google翻译
function back_gears(){
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"pages/back_gears/?status=1";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, back_gears_callback);
}
var back_gears_Success = function(o){
	//var sys_messages = YAHOO.lang.JSON.parse(o.responseText);
	document.getElementById('message_content').innerHTML = o.responseText;
	YAHOO.example.container.wait.hide();
	YAHOO.example.container.message.show();
}
var back_gears_Failure = function(o){
	YAHOO.example.container.wait.hide();
}
var back_gears_callback ={
	success:back_gears_Success,
	failure:back_gears_Failure,
	timeout : 30000,
	argument: {}
};
