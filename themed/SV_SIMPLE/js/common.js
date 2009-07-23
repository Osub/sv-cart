/*****************************************************************************
 * SV-CART 公共JS
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: common.js 2807 2009-07-13 09:55:56Z shenyunfeng $
*****************************************************************************/
/*
YAHOO.namespace("example.container");

//左边菜单
YAHOO.util.Event.onContentReady("catmenu", function () {
                var oMenu = new YAHOO.widget.Menu("catmenu", {position: "static",hidedelay:  750,lazyload: true});
                oMenu.render();            
});

function init() {

// 用户登陆
YAHOO.example.container.User_Login = new YAHOO.widget.Panel("User_Login", { xy:[370,35],visible:false,width:"240px",position: "static",zIndex:1000,effect:[{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.5},{effect:YAHOO.widget.ContainerEffect.SLIDE,duration:0.5}]});
var close_user_login = new YAHOO.util.KeyListener(document, { keys:27 },{ fn:YAHOO.example.container.User_Login.hide,scope:YAHOO.example.container.User_Login,correctScope:true }, "keyup" );
YAHOO.example.container.User_Login.cfg.queueProperty("keylisteners", close_user_login);
YAHOO.example.container.User_Login.render();

// 高级搜索
YAHOO.example.container.advanced_search = new YAHOO.widget.Panel("advanced_search", { xy:[730,35],visible:false,width:"240px",zIndex:1000,effect:{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.4}});
var close_adv_search = new YAHOO.util.KeyListener(document, { keys:27 },{ fn:YAHOO.example.container.advanced_search.hide,scope:YAHOO.example.container.advanced_search,correctScope:true }, "keyup" ); 
// keyup is used here because Safari won't recognize the ESC
// keydown event, which would normally be used by default
 
YAHOO.example.container.advanced_search.cfg.queueProperty("keylisteners", close_adv_search);
YAHOO.example.container.advanced_search.render();

// 语言选择
YAHOO.example.container.language = new YAHOO.widget.Panel("language", { xy:[540,35],visible:false,width:"266px",zIndex:1000,effect:[{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.6},{effect:YAHOO.widget.ContainerEffect.SLIDE,duration:0.6}]});
var close_language = new YAHOO.util.KeyListener(document, { keys:27 },{fn:YAHOO.example.container.language.hide,scope:YAHOO.example.container.language,correctScope:true }, "keyup" ); 
YAHOO.example.container.language.cfg.queueProperty("keylisteners", close_language);
YAHOO.example.container.language.render();

var open_language = new YAHOO.util.KeyListener(document, { ctrl:true,alt:true, keys:76 },{ fn:YAHOO.example.container.language.show,scope:YAHOO.example.container.language, correctScope:true }, "keyup" );
open_language.enable();


YAHOO.example.container.manager = new YAHOO.widget.OverlayManager();



YAHOO.util.Event.addListener("login", "click", show_login, YAHOO.example.container.User_Login, true);
YAHOO.util.Event.addListener("adv_search", "click", YAHOO.example.container.advanced_search.show, YAHOO.example.container.advanced_search, true);
YAHOO.util.Event.addListener("locales", "click", YAHOO.example.container.language.show, YAHOO.example.container.language, true);

YAHOO.example.container.wait = new YAHOO.widget.Panel("wait",{ width:"240px", fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
YAHOO.example.container.wait.setHeader("<div style='background:#fff;position:absolute;width:100%;padding-top:5px;margin-top:15px;text-align:center'>Loading, please wait...</div>");
YAHOO.example.container.wait.setBody("<object id='loading' data='"+root_all+themePath+"img/loading.swf' type='application/x-shockwave-flash' width='240' height='40'><param name='movie' value='"+root_all+themePath+"img/loading.swf' /><param name='wmode' value='Opaque'></object>");
//首页的值 webroot_dir 	var webroot_dir = "/"; 
//themePath  var themePath = "themed/SV_G00/";

	

YAHOO.example.container.wait.render(document.body);

YAHOO.example.container.message = new YAHOO.widget.Panel("message",{width:"424px",zIndex:1000,fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
YAHOO.example.container.message.setBody("<div id='message_content'></div>");
YAHOO.example.container.message.render(document.body);
//Width：895 show框
YAHOO.example.container.message_width = new YAHOO.widget.Panel("message_width",{width:"895px",zIndex:1000,fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
YAHOO.example.container.message_width.setBody("<div id='message_width_content'></div>");
YAHOO.example.container.message_width.render(document.body);

YAHOO.example.container.message_img_content = new YAHOO.widget.Panel("message_img",{width:"658px",zIndex:1000,fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
YAHOO.example.container.message_img_content.setBody("<div id='message_img_content'></div>");
YAHOO.example.container.message_img_content.render(document.body);

YAHOO.util.Dom.setStyle('svcart-com', 'visibility', 'visible'); 


goleft("newscoll","newscoll_1","newscoll_2");
}//658

YAHOO.util.Event.onDOMReady(init);

*/

var failure_todo = function(result){
	alert('error');
	YAHOO.example.container.wait.hide();
}
    
function search(){
var keywords=document.getElementById('keywords').value;
var type=document.getElementById('type').value;
if(keywords == ''){
   keywords = 0;
}
   window.location.href=webroot_dir+"products/search/"+type+"/"+keywords;
}

function ad_search(key){
var type='SAD';
var category_id=document.getElementById('category_id').value;
var brand_id=document.getElementById('brand_id').value;
var min_price="";
var max_price="";
var price=document.getElementById('price_id').value;
	if(price != ""){
		arr = price.split("-");
		min_price = arr[0];
		max_price = arr[1];
	}
    if(key == 'select_all_products'){
		    var keywords = 'all';
			window.location.href=webroot_dir+"products/advancedsearch/"+type+"/"+keywords+"/"+category_id+"/"+brand_id+"/"+min_price+"/"+max_price;
		    return;
    }else{
		var keywords=document.getElementById('ad_keywords').value;
   }
//alert(document.getElementById('act').value)
	var ss = webroot_dir+"products/advancedsearch/"+type+"/"+keywords+"/"+category_id+"/"+brand_id+"/"+min_price+"/"+max_price;
	if(keywords == ""){
		keywords = "all";
	}
window.location.href=webroot_dir+"products/advancedsearch/"+type+"/"+keywords+"/"+category_id+"/"+brand_id+"/"+min_price+"/"+max_price;
}


	    var changelanguages_callbacks = {

        success : function (o) {
            YAHOO.log("RAW JSON DATA: " + o.responseText);

            // Process the JSON data returned from the server
            var messages = [];
            try {
                messages = YAHOO.lang.JSON.parse(o.responseText);
            }
            catch (x) {
                alert("JSON Parse failed!");
                return;
            }

            YAHOO.log("PARSED DATA: " + YAHOO.lang.dump(messages));

            // The returned data was parsed into an array of objects.
            // Add a P element for each received message
			if(messages.error){
				YAHOO.example.container.wait.hide();
				alert(messages.error);
			}
			else{
					window.location.reload();
			}
        },

        failure : function (o) {
            if (!YAHOO.util.Connect.isCallInProgress(o)) {
            	YAHOO.example.container.wait.hide();
                alert("Async call failed!");
            }
        },

        timeout : 30000
    }
    
	function change_locale(locale) {
		YAHOO.example.container.wait.show();
	    YAHOO.util.Connect.asyncRequest('GET',webroot_dir+"commons/locale/"+locale, changelanguages_callbacks);
	}
//Tab
	function overtab(name,cursel,n){ 
		for(i=1;i<=n;i++){ 
		var menu=document.getElementById(name+i); 
		var con=document.getElementById("con_"+name+"_"+i); 
		menu.className=i==cursel?"hover":""; 
		con.style.display=i==cursel?"block":"none"; 
		} 
	}


	function show_pic(img){
		//img = "/themed/SV_G00"+img;
		if(webroot_dir =="/"){
			var img_dir = "";
		}else{
			var img_dir = webroot_dir.substring(0,(webroot_dir.length)-1);
		}
		document.getElementById('img1').src = img_dir+img;
	}

	function show_pic_original(){
		var img_detail = document.getElementById('img1').src;
		var img = img_detail.replace("detail","original");
		document.getElementById('message_img_content').innerHTML = "<div onclick='javascript:close_message_img();'><img src='"+img+"' onload='javascript:img_width(this);'/></div>";
	}
	
	function img_width(img){
		var width = img.clientWidth;
		var height = img.clientHeight;
		if(height > 500){
			var num = 500 / height;
			height = 500;
			width = width * num;
		}
	    if(width > 800){
			var num = 800 / width;
			height = height * num;
		}

		YAHOO.example.container.message_img_show = new YAHOO.widget.Panel("message_img_show",{width:width+"px",zIndex:1000,fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
		YAHOO.example.container.message_img_show.setBody("<div id='message_img_show'></div>");
		YAHOO.example.container.message_img_show.render(document.body);
		document.getElementById('message_img_show').innerHTML = "<div onclick='javascript:close_img_show();'><img src='"+img.src+"' width='"+width+"' height='"+height+"'/></div>";
		YAHOO.example.container.message_img_show.show();

	}
	function close_img_show(){
		YAHOO.example.container.message_img_show.hide();

	}


//检查登陆信息--begin
	function check_login_info(username_not_null,pwd_not_null,authnum_not_null){
		var username = document.getElementById('page_username').value;
		var password = document.getElementById('page_password').value;
		var authnum  = document.getElementById('page_authnum').value;
		var error_msg = '';
		
		if(username == ''){
			error_msg += username_not_null;
		}
		if(password == ''){
			error_msg += "<br> "+pwd_not_null;
		}
		if(authnum == ''){
			error_msg += "<br> "+authnum_not_null;
		}

		if(error_msg)
		{
			document.getElementById('error_msg_area').style.display = '';
			document.getElementById('page_error_msg').innerHTML = error_msg;
		}
		else
		{
			act_login(username,password,authnum);
		}
	}
//检查登陆信息--end


//执行登陆-ajax-begin
	function act_login_ajax(name,password,captcha){
		YAHOO.example.container.wait.show();
		var sUrl = user_webroot+"login/";
		var postData = "is_ajax=1"+"&name="+name+"&password="+password+"&captcha="+captcha;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, act_login_ajax_callback,postData);
	}

	var act_login_ajax_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");   
			YAHOO.example.container.wait.hide();
		}
		if(result.type == 9){
			window.location.reload();
			return;
		}
		if(result.error_msg){
			document.getElementById('login_false_msg').innerHTML = result.error_msg;
		}else{
			document.getElementById('user_info').innerHTML = result.content;
			YAHOO.example.container.User_Login.hide();
		}
		
		YAHOO.example.container.wait.hide();
	}

	var act_login_ajax_callback ={
		success:act_login_ajax_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
//执行登陆-ajax-end

//执行登陆--begin
	function act_login(username,password,captcha){
		YAHOO.example.container.wait.show();
		var sUrl = user_webroot+"login/";
		var postData = "is_ajax=1"+"&username="+username+"&password="+password+"&captcha="+captcha;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, act_login_callback,postData);
	}

	var act_login_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");   
			YAHOO.example.container.wait.hide();
		} 

		if(result.error_msg){
			document.getElementById('error_msg_area').style.display = '';
			document.getElementById('page_error_msg').innerHTML = result.error_msg;
		}else{
			if(result.back_url)
				window.location.href = result.back_url;
			else
				window.location.href = "/";
		}
		
		YAHOO.example.container.wait.hide();
	}

	var act_login_callback ={
		success:act_login_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
//执行登陆--end

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


	function close_message(){
		YAHOO.example.container.message.hide();
		YAHOO.example.container.wait.hide();
	}
	function close_message_width(){
		YAHOO.example.container.message_width.hide();
		YAHOO.example.container.wait.hide();
	}
	function close_message_img(){
		YAHOO.example.container.message_img_content.hide();
		YAHOO.example.container.wait.hide();
	}


            
// 登陆框特效开始

	function show_login(){
		show_login_captcha('login_captcha');
		YAHOO.example.container.User_Login.show();
	}
	function show_login_captcha(id){
		document.getElementById(id).src = user_webroot+"captcha/?"+Math.random();
	}	
	function panel_login(){
		var name = document.getElementById('UserName').value;
		var password = document.getElementById('UserPassword').value;
		var captcha  = document.getElementById('UserCaptcha').value;
		act_login_ajax(name,password,captcha);
	}
	
	function act_login_ajax(name,password,captcha){
		YAHOO.example.container.wait.show();
		var sUrl = user_webroot+"login/";
		var postData = "is_ajax=1"+"&name="+name+"&password="+password+"&captcha="+captcha;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, act_login_ajax_callback,postData);
	}

	var act_login_ajax_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){
			alert("Invalid data");   
			alert(o.responseText);
			YAHOO.example.container.wait.hide();
		} 
		if(result.type == 9){
			window.location.reload();
			return;
		}
		if(result.type==1){ 
			document.getElementById('panel_login_message').innerHTML = result.message;
			show_login_captcha('login_captcha');
		}
		else if(result.type==0){
			YAHOO.example.container.User_Login.hide();
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}else{
			document.getElementById('user_info').innerHTML = result.content;
			YAHOO.example.container.User_Login.hide();
		}
		
		YAHOO.example.container.wait.hide();
	}

	var act_login_ajax_callback ={
		success:act_login_ajax_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
// 登陆框特效结束


//用户退出--begin
	function logout(){
		YAHOO.example.container.wait.show();
		var sUrl = user_webroot+"logout/";
		var postData = "random="+Math.random();
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, logout_callback,postData);
	}

	var logout_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
			alert("Invalid data");   
			YAHOO.example.container.wait.hide();
		} 
		
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.message.show();	
		YAHOO.example.container.wait.hide();
	}

	var logout_callback ={
	success:logout_Success,
	failure:failure_todo,
	timeout : 30000,
	argument: {}
	};
//用户退出--end

//将商品添加到购物车--begin
	function buy_now(product_id,quantity){
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"carts/buy_now/";
		var postData ="id="+product_id+"&quantity="+quantity+"&type=product";
		var i = 0;
		while(true){
			var aa = 'attributes_'+i;
			if(document.getElementById(aa)==null){
				break;
			}
			var a  =document.getElementById(aa).value;
			postData +="&"+aa+"="+a
			i++;
 		}
 	//	alert(postData);
	//	return;
		if(quantity != parseInt(quantity))  
		{  
  		alert(enter_positive_integer);
		YAHOO.example.container.wait.hide();
		return;
		}
		quantity = parseInt(quantity);
		if(parseInt(quantity) < 0){
		alert(enter_positive_integer);
		YAHOO.example.container.wait.hide();
		return;
		}
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, buy_now_callback,postData);
	}

	var buy_now_Success = function(o){
		try{
			
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
		if(enable_one_step_buy == "1"){
			window.location.href= webroot_dir+"carts/checkout";
			return;
		}
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.wait.hide();
		YAHOO.example.container.message.show();
	}

	var buy_now_callback ={
		success:buy_now_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
//将商品添加到购物车--end


	//添加收藏--begin
	function favorite(type_id,type){
		YAHOO.example.container.wait.show();
		var sUrl = user_webroot+"favorites/add/";
		var postData ="type_id="+type_id+"&type="+type;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, favorite_callback,postData);
	}

	var favorite_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
		
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.wait.hide();
		YAHOO.example.container.message.show();
	}

	var favorite_callback ={
		success:favorite_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
//添加收藏--end


//登陆页
	function user_login(){
		
		YAHOO.example.container.wait.show();
		var name = document.getElementById('UserName').value;
		var password = document.getElementById('UserPassword').value;
		var captcha  = document.getElementById('UserCaptcha_page').value;

		var sUrl = user_webroot+"login/";
		var postData = "name="+name+"&password="+password+"&captcha="+captcha;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, user_login_callback,postData);
	}

	var user_login_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");   
			YAHOO.example.container.wait.hide();
		} 

		if(result.type==1){ 

			document.getElementById('error_msg').innerHTML = result.message;
			show_login_captcha('login_captcha_page');
		}
		else if(result.type==0){
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}else{
			YAHOO.example.container.User_Login.hide();
		}
		
		YAHOO.example.container.wait.hide();
	}

	var user_login_callback ={
		success:user_login_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
// 登陆页结束


//分页问题
function GoPage(pagecount){
var goPage=document.getElementById('go_page').value;
if(goPage > pagecount){
//  alert(page_number_expand_max);
	layer_dialog_show(page_number_expand_max,'',2,'','','','','');
}
else{
window.location.href="?page="+goPage;
}
}
function show_last5(){
  document.getElementById('last5').style.display="block";
}

function del_history(){
		YAHOO.example.container.wait.show();

  //document.getElementById('history').innerHTML="<ul><p align='center'><br /><font color='#077C4D'>没有浏览记录</font></p></ul>";
 
  	var sUrl = webroot_dir+"products/del_history/";
	var postData = "";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, del_history_callback,postData);
}

	var del_history_Success = function(result){
			document.getElementById('history_box').style.display="none";
	YAHOO.example.container.wait.hide();

	}

	var del_history_callback ={
		success:del_history_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
//缺货登记
function show_booking(id){
	YAHOO.example.container.wait.show();
  	var sUrl = webroot_dir+"products/show_booking/";
	var postData = "id="+id;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, show_booking_callback,postData);
}

	var show_booking_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		if(result.type == 1){
		document.getElementById('message').innerHTML = result.show_booking;
		YAHOO.example.container.message.show();
		}else{
		document.getElementById('message_img_content').innerHTML = result.show_booking;
		YAHOO.example.container.message_img_content.show();
		}
		YAHOO.example.container.wait.hide();
	}
	
	var show_booking_callback ={
		success:show_booking_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	function isEmail(str){
		res = /^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$/;
		var re = new RegExp(res);
		return (str.match(re) == null);
	} 
function add_booking(){
	YAHOO.example.container.wait.show();
	var Booking= new Object();
	var msg = new Array();
  	var err = false;
	Booking.product_id =document.getElementById('product_id').value;
 	Booking.product_number =document.getElementById('product_number').value;
	Booking.contact_man =document.getElementById('contact_man').value; 
	Booking.email =document.getElementById('email').value; 
	Booking.telephone =document.getElementById('telephone').value; 
	Booking.product_desc =document.getElementById('product_desc').value;
	document.getElementById('contact_man_span').innerHTML = "*";
	document.getElementById('email_span').innerHTML = "*";
	document.getElementById('telephone_span').innerHTML = "*";
	document.getElementById('product_number_span').innerHTML = "*";
  	if(Booking.product_number == ""){
  		document.getElementById('product_number_span').innerHTML = order_quantity_not_empty;
		 err = true;
  	}else if(Booking.product_number != parseInt(Booking.product_number))  
	{  
		document.getElementById('product_number_span').innerHTML = order_quantity_be_integer;
		err = true;
	}else{
		quantity = parseInt(Booking.product_number);
		if(parseInt(quantity) < 0){
		document.getElementById('product_number_span').innerHTML = order_quantity_be_integer;
		err = true;
		}
	}
  	if(Booking.contact_man == ""){
  		document.getElementById('contact_man_span').innerHTML = contact_not_empty;
		err = true;
  	}
  	if (isEmail(Booking.email)){
  		document.getElementById('email_span').innerHTML = invalid_email;
		 err = true;
	}
  	if(Booking.telephone == ""){
  		document.getElementById('telephone_span').innerHTML = tel_number_not_empty;
		 err = true;
  	}else if(Booking.telephone != parseInt(Booking.telephone))  
	{  
  		document.getElementById('telephone_span').innerHTML = invalid_tel_number;
		err = true;
	}	  
    if (err){
		 YAHOO.example.container.wait.hide();
		 return;
	}
   	var sUrl = "/products/add_booking/";
	var postData = "booking="+YAHOO.lang.JSON.stringify(Booking);
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, add_booking_callback,postData);
}

	var add_booking_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		YAHOO.example.container.wait.hide();
		YAHOO.example.container.message_img_content.hide();
		if(result.type == "0"){
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var add_booking_callback ={
		success:add_booking_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	

	function recommend_to_friend(id,name){
		YAHOO.example.container.wait.show();
		var sUrl = user_webroot+"friends/recommend/";
		var postData ="id="+id+"&name="+name;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, recommend_to_friend_callback,postData);
	}

	var recommend_to_friend_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
		//	alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
		
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.wait.hide();
		YAHOO.example.container.message.show();
	}

	var recommend_to_friend_callback ={
		success:recommend_to_friend_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
//onkeydown
document.onkeydown = function(evt){
	var evt = window.event?window.event:evt;
	if(evt.keyCode==13)
	{
		var UserName = document.getElementById('UserName').value;
		var UserPassword = document.getElementById('UserPassword').value;
		var UserCaptcha = document.getElementById('UserCaptcha').value;
		if(UserName != "" && UserPassword != "" && UserCaptcha != ""){
			panel_login();
		}
	}
}
//NewScroll
function goleft(id1,id2,id3){
   var speed=30
   var newscoll=document.getElementById(id1);
   var newscoll_1=document.getElementById(id2);
   var newscoll_2=document.getElementById(id3);
   newscoll_2.innerHTML=newscoll_2.innerHTML;
   if (parseInt(newscoll_1.offsetWidth)<newscoll.offsetWidth)  //判断滚动对象是否比外围对象小
   {newscoll_1.style.width=newscoll.offsetWidth+"px";                //如果小，则设置其宽度等于外围对象
   }
  newscoll_1.style.right=newscoll.offsetWidth-newscoll_1.offsetWidth+"px";
   newscoll_2.style.width=newscoll_1.offsetWidth+"px";//将克隆对象宽度等于滚动对象的宽度
   newscoll_2.style.left=newscoll_1.offsetWidth+"px"; //将克隆对象left值等于滚动对象的宽度
   newscoll_2.innerHTML=newscoll_1.innerHTML
   function Marquee(){
   if(parseInt(newscoll_1.style.right)<newscoll_1.offsetWidth){//如果滚动对象的right值少于滚动对象的宽度
   newscoll_1.style.right=parseInt(newscoll_1.style.right)+1+"px";    //滚动对象的right值递增，等于该对象往左移动
    newscoll_2.style.left=parseInt(newscoll_2.style.left)-1+"px";     //克隆对象的left值递减，等于该对象往左移动
   }
   else{
     newscoll_1.style.right=newscoll.offsetWidth-newscoll_1.offsetWidth+"px";
   newscoll_2.style.left=newscoll_1.offsetWidth+"px";
   }
   }
   var MyMar=setInterval(Marquee,speed)
   newscoll.onmouseover=function() {clearInterval(MyMar)}
   newscoll.onmouseout=function() {MyMar=setInterval(Marquee,speed)}
}
//NewScroll End
function  is_int(txt){  
    txt.value=txt.value.replace(/\D/g,"");  
}   

//确定购买--begin
	function sure_buy(product_id,quantity){
		YAHOO.example.container.message.hide();
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"carts/buy_now/";
		var postData ="id="+product_id+"&quantity="+quantity+"&type=product&sure=1";
		
		var i = 0;
		while(true){
			var aa = 'attributes_'+i;
			if(document.getElementById(aa)==null){
				break;
			}
			var a  =document.getElementById(aa).value;
			postData +="&"+aa+"="+a
			i++;
 		}		
		if(quantity != parseInt(quantity))  
		{  
  		alert(enter_positive_integer);
		YAHOO.example.container.wait.hide();
		return;
		}
		quantity = parseInt(quantity);
		if(parseInt(quantity) < 0){
		alert(enter_positive_integer);
		YAHOO.example.container.wait.hide();
		return;
		}
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, sure_buy_callback,postData);
	}

	var sure_buy_Success = function(o){
		try{
			
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
		if(enable_one_step_buy == "1"){
			window.location.href= webroot_dir+"carts/checkout";
			return;
		}
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.wait.hide();
		YAHOO.example.container.message.show();
	}

	var sure_buy_callback ={
		success:sure_buy_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};

function advanced_search_cart(){
var type='SAD';
var category_id=document.getElementById('category_id_search').value;
var brand_id=document.getElementById('brand_id_search').value;
var min_price=document.getElementById('min_price_search').value;
var max_price=document.getElementById('max_price_search').value;
var keywords=document.getElementById('ysearchinput_search').value;
if(keywords == ""){
var keywords = 'all_products';
}
var ss = webroot_dir+"products/advancedsearch/"+type+"/"+keywords+"/"+category_id+"/"+brand_id+"/"+min_price+"/"+max_price;
window.location.href=webroot_dir+"products/advancedsearch/"+type+"/"+keywords+"/"+category_id+"/"+brand_id+"/"+min_price+"/"+max_price;
return;
}

	function exchange(product_id,quantity){
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"carts/buy_now/";
		var postData ="id="+product_id+"&quantity="+quantity+"&type=product&is_exchange=1";
		var i = 0;
		while(true){
			var aa = 'attributes_'+i;
			if(document.getElementById(aa)==null){
				break;
			}
			var a  =document.getElementById(aa).value;
			postData +="&"+aa+"="+a
			i++;
 		}
		if(quantity != parseInt(quantity))  
		{  
  		alert(enter_positive_integer);
		YAHOO.example.container.wait.hide();
		return;
		}
		quantity = parseInt(quantity);
		if(parseInt(quantity) < 0){
		alert(enter_positive_integer);
		YAHOO.example.container.wait.hide();
		return;
		}
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, buy_now_callback,postData);
	}
	
	function add_tag(type_id,type,is_login){
		if(is_login == 0){
			layer_dialog_show(time_out_relogin_js,'',2,'','','','','');
			return;
		}		
		YAHOO.example.container.wait.show();
		var tag = document.getElementById('tag').value;
		var sUrl = webroot_dir+"commons/add_tag/";
		var postData ="type_id="+type_id+"&type="+type+"&tag="+tag;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, add_tag_callback,postData);
	}

	var add_tag_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 

		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.wait.hide();
		YAHOO.example.container.message.show();
	}

	var add_tag_callback ={
		success:add_tag_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function search_tag(tag_name){
		window.location.href=webroot_dir+"products/advancedsearch/SAD/"+tag_name+"/0/0/0/";
	}
	function buy_now_no_ajax(id,q,type){
		document.forms['buy_now'+type+id].submit();
	}
	function add_tags(is_login){
		if(is_login == 0){
			layer_dialog_show(time_out_relogin_js,'',2,'','','','','');
			return;
		}		
		document.forms['add_tag'].submit();
	}
	
	function layer_dialog_show(dialog_content,url_or_function,button_num,shipping_id,shipping_fee,free_subtotal,support_cod,insure_fee){
		layer_dialog();
		document.getElementById('layer_dialog').style.display = "block";
	//	if(url_or_function!=''){
	//		document.getElementById('confirm').value = url_or_function;//删除层传URL
	//	}
		document.getElementById('dialog_content').innerHTML = dialog_content;//对话框中的中文
		var button_replace = document.getElementById('button_replace');
		if(button_num==3){
			button_replace.innerHTML = "<a href='javascript:confirm_shipping_fee("+shipping_id+","+shipping_fee+","+free_subtotal+","+support_cod+",0);' style='padding-right:50px;'>"+cart_cancel+"</a>"+"<a href='javascript:confirm_shipping_fee("+shipping_id+","+shipping_fee+","+free_subtotal+","+support_cod+","+insure_fee+");' style='padding-right:50px;'>"+cart_confirm+"</a>";
		}
		if(button_num==4){
			button_replace.innerHTML = "<a href='javascript:layer_dialog_hide();'>"+cart_confirm+"</a>";
		}
		if(button_num==2){
			button_replace.innerHTML = "<a href='javascript:layer_dialog_obj.hide();'>"+page_confirm+"</a>";
		}		
		layer_dialog_obj.show();
	}
	function layer_dialog_hide(){
		document.getElementById('layer_dialog').style.display = "none";
	}	
	
	function layer_dialog(){
	//	tabView = new YAHOO.widget.TabView('contextPane'); 
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