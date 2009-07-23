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
 * $Id: common.js 1363 2009-05-14 06:18:55Z shenyunfeng $
*****************************************************************************/

//YAHOO.namespace("example.container");

function init() {
// 用户登陆
/*YAHOO.example.container.User_Login = new YAHOO.widget.Panel("User_Login", { xy:[370,35],visible:false,width:"240px",zIndex:1000,effect:[{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.5},{effect:YAHOO.widget.ContainerEffect.SLIDE,duration:0.5}]});
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
YAHOO.example.container.wait.setBody("<object id='loading' data='"+root_all+'user/'+themePath+"img/loading.swf' type='application/x-shockwave-flash' width='240' height='40'><param name='movie' value='"+root_all+'user/'+themePath+"img/loading.swf' /><param name='wmode' value='Opaque'></object>");

YAHOO.example.container.wait.render(document.body);

YAHOO.example.container.message = new YAHOO.widget.Panel("message",{width:"424px",zIndex:1000,fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
YAHOO.example.container.message.setBody("<div id='message_content'></div>");
YAHOO.example.container.message.render(document.body);

YAHOO.example.container.friends_message = new YAHOO.widget.Panel("friends_message",{width:"318px",zIndex:1000,fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
YAHOO.example.container.friends_message.setBody("<div id='friends_message_content'></div>");
YAHOO.example.container.friends_message.render(document.body);
//Width：895 show框
YAHOO.example.container.message_width = new YAHOO.widget.Panel("message_width",{width:"895px",zIndex:1000,fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
YAHOO.example.container.message_width.setBody("<div id='message_width_content'></div>");
YAHOO.example.container.message_width.render(document.body);

YAHOO.example.container.message_img_content = new YAHOO.widget.Panel("message_img",{width:"741px",zIndex:1000,fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
YAHOO.example.container.message_img_content.setBody("<div id='message_img_content'></div>");
YAHOO.example.container.message_img_content.render(document.body);

YAHOO.util.Dom.setStyle('svcart-com', 'visibility', 'visible'); 
//NewScroll
goleft("newscoll","newscoll_1","newscoll_2");*/

}//658

//YAHOO.util.Event.onDOMReady(init);

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
   window.location.href= "/products/search/"+type+"/"+keywords;
}
	function isEmail(str){
		res = /^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$/;
		var re = new RegExp(res);
		return (str.match(re) == null);
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
					window.location.href= cart_webroot+"products/advancedsearch/"+type+"/"+keywords+"/"+category_id+"/"+brand_id+"/"+min_price+"/"+max_price;
				    return;
		    }else{
				var keywords=document.getElementById('ad_keywords').value;
		   }
		//alert(document.getElementById('act').value)
			var ss = cart_webroot+"products/advancedsearch/"+type+"/"+keywords+"/"+category_id+"/"+brand_id+"/"+min_price+"/"+max_price;
			if(keywords == ""){
				keywords = "all";
			}
		window.location.href = cart_webroot+"products/advancedsearch/"+type+"/"+keywords+"/"+category_id+"/"+brand_id+"/"+min_price+"/"+max_price;
	}
	
function ad_search00(key){
    if(key == 'select_all_products'){
		    var keywords = 'all';
		    window.location.href="/products/advancedsearch/SAD/"+keywords+"/";
		    return;
    }
    else{
	      var ysearchinput=document.getElementById('ysearchinput').value;
	         if(ysearchinput != ''){
	 	           var keywords = ysearchinput;
	          }
	          else{
		           var keywords=document.getElementById('ad_keywords').value;
	           }
       }
//alert(document.getElementById('act').value)
var type='SAD';
var category_id=document.getElementById('category_id').value;
var brand_id=document.getElementById('brand_id').value;
var price = document.ad_search.price_id.options[document.ad_search.price_id.selectedIndex].value;
price = price.split('-');	
var min_price=price[0];
var max_price=price[1];
//var min_price=document.getElementById('min_price').value;
//var max_price=document.getElementById('max_price').value;
     if(keywords == ''){
          keywords = 0;
      }
window.location.href=cart_webroot+"products/advancedsearch/"+type+"/"+keywords+"/"+category_id+"/"+brand_id+"/"+min_price+"/"+max_price;
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
            	alert(o.responseText);
                alert("JSON Parse failed!");
               	YAHOO.example.container.wait.hide();
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
    
    function user_change_locale(locale) {
    	document.select_locale.action = cart_webroot+"commons/locale/";
    	document.select_locale.submit();
//	window.location.href = cart_webroot+"commons/locale/"+local;
	}
	function change_locale(locale) {
		//alert('in');
		YAHOO.example.container.wait.show();
	    YAHOO.util.Connect.asyncRequest('GET',cart_webroot+"commons/locale/"+locale, changelanguages_callbacks);
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
		document.getElementById('img1').src = img;
	}

	function show_pic_original(){
		var img_detail = document.getElementById('img1').src;
		var img = img_detail.replace("detail","original");
		document.getElementById('message_img_content').innerHTML = "<div onclick='javascript:close_message_img();'><img src='"+img+"' onload='javascript:img_width(this);'/></div>";
		

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
			error_msg += "<br /> "+pwd_not_null;
		}
		if(authnum == ''){
			error_msg += "<br /> "+authnum_not_null;
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
		var sUrl = webroot_dir+"login/";
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

		if(result.error_msg){
			document.getElementById('login_false_msg').innerHTML = result.error_msg;
		}else{
			document.getElementById('user_info').innerHTML = result.content;
			YAHOO.example.container.User_Login.hide();
		}
		
		YAHOO.example.container.wait.hide();
	}

	var act_login_ajax_Failure = function(result){
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
		var sUrl = webroot_dir+"login/";
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
				window.location.href = webroot_dir+"";
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
	}
	function close_message_width(){
		YAHOO.example.container.message_width.hide();
	}
	function close_message_img(){
		YAHOO.example.container.message_img_content.hide();
	}

	function close_friends_message(){
		YAHOO.example.container.friends_message.hide();
	}
//左边菜单
      //      YAHOO.util.Event.onContentReady("productsandservices", function () {
       //         var oMenu = new YAHOO.widget.Menu("productsandservices", {position: "static",hidedelay:  750,lazyload: true });
       //         oMenu.render();            
       //     });
            
// 登陆框特效开始

	function show_login(){
		show_login_captcha('login_captcha');
		YAHOO.example.container.User_Login.show();
	}
	function show_login_captcha(id){
	//	window.location.href = webroot_dir+"captcha/?"+Math.random();
		document.getElementById(id).src = webroot_dir+"captcha/?"+Math.random();
	//	alert(webroot_dir+"captcha/?"+Math.random());
	}	
	function panel_login(){
		var name = document.getElementById('UserName').value;
		var password = document.getElementById('UserPassword').value;
		var captcha  = document.getElementById('UserCaptcha').value;
		act_login_ajax(name,password,captcha);
	}
	
	function act_login_ajax(name,password,captcha){
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"login/";
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
		var sUrl = webroot_dir+"logout/";
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
		var sUrl = cart_webroot+"carts/buy_now/";
		var postData ="id="+product_id+"&quantity="+quantity+"&type=product";
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
			window.location.href= cart_webroot+"carts/checkout";
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
		var sUrl = webroot_dir+"favorites/add/";
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
		
		var name = document.getElementById('UserName_page').value;
		var password = document.getElementById('UserPassword_page').value;
	//	var captcha  = document.getElementById('UserCaptcha_page').value;	
	var sUrl = webroot_dir+"login/";alert("in3");
	//	var postData = "name="+name+"&password="+password+"&captcha="+captcha;
		var postData = "name="+name+"&password="+password;
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
			document.getElementById('error_message_area').style.display = "block";
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
/*function GoPage(pagecount){
var goPage=document.getElementById('go_page').value;
if(goPage > pagecount){
  //alert(page_number_expand_max);
  layer_dialog_show('1',page_number_expand_max,2,page_confirm,"");
}
else{
	alert(webroot_dir+"?page="+goPage);
window.location.href = webroot_dir+"?page="+goPage;
}
}*/
function show_last5(){
  document.getElementById('last5').style.display="block";
}

function del_history(){
  //document.getElementById('history').innerHTML="<ul><p align='center'><br /><font color='#077C4D'>没有浏览记录</font></p></ul>";
 	document.getElementById('history_box').style.display="none";
  	var sUrl = webroot_dir+"products/del_history/";
	var postData = "";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, del_history_callback,postData);
}

	var del_history_Success = function(result){

	}

	var del_history_callback ={
		success:del_history_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	
//用户中心

function show_edit(id){
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"addresses/show_edit/";
	var postData = "id="+id;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, show_edit_callback,postData);
	//YAHOO.example.container.message.show();
}
	var show_edit_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");
		}
   		YAHOO.example.container.wait.hide();
		if(result.type == 0){
		document.getElementById('message_img_content').innerHTML = result.message;
		YAHOO.example.container.message_img_content.show();
		show_regions(result.regions,'');
		}else{
			alert("fail");
		}
	}

	var show_edit_callback ={
		success:show_edit_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	
	function show_add(){
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"addresses/show_add/";
	var postData = "";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, show_add_callback,postData);
}
	var show_add_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");
		}

   		YAHOO.example.container.wait.hide();
		if(result.type == 0){
		document.getElementById('message_img_content').innerHTML = result.message;
		YAHOO.example.container.message_img_content.show();
		show_regions("","");
		}else{
			alert("fail");
		}
	}
	var show_add_callback ={
		success:show_add_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	function address_close(){
		window.location.reload();
	}
	function edit_address(){
		YAHOO.example.container.wait.show();
		var i=0;
		var Region="";
		while(true){
			if(document.getElementById('AddressRegion'+i)==null){
				break;
			}
			Region +=document.getElementById('AddressRegion'+i).value + " ";
			i++;
 		}
		var Address = new Object();
 		Address.regions = Region;
 		Address.id =document.getElementById('UserAddressId').value;
 	    Address.name =document.getElementById('UserAddressName').value;
 		Address.consignee =document.getElementById('UserAddressConsignee').value;
 		Address.sign_building =document.getElementById('UserAddressSignBuilding').value;
 		Address.best_time =document.getElementById('UserAddressBestTime').value;
 		Address.address =document.getElementById('UserAddressAddress').value;
 		Address.mobile =document.getElementById('UserAddressMobile').value;
 	//	Address.sign_building =document.getElementById('EditAddressSignBuilding').value;
 		var tel_0 = document.getElementById('tel_0').value;
 		var tel_1 = document.getElementById('tel_1').value;
 		var tel_2 = document.getElementById('tel_2').value;
 		Address.telephone = tel_0+"-"+tel_1
 		if(tel_2 != ""){
 		Address.telephone +="-"+tel_2;
		}
 		
 		//Address.telephone = document.getElementById('tel_0').value+"-"+document.getElementById('tel_1').value+"-"+document.getElementById('tel_2').value;
 		Address.zipcode =document.getElementById('UserAddressZipcode').value;
 		Address.email =document.getElementById('UserAddressEmail').value;
 	  //Address.best_time =document.getElementById('EditAddressBestTime').value;
 		//判断输入的内容
 		 var regions_arr = Address.regions.split(" ");
 		 var msg = new Array();
  		 var err = false;
		    document.getElementById('name_msg').innerHTML = "*";
		    document.getElementById('consignee_msg').innerHTML = "*";
		    document.getElementById('email_msg').innerHTML = "*";
			document.getElementById('regions_msg').innerHTML = "*";
		    document.getElementById('address_msg').innerHTML = "*";
		    document.getElementById('zipcode_msg').innerHTML = "*";
		    document.getElementById('tel_msg').innerHTML = "*";
		    document.getElementById('mobile_msg').innerHTML = "*";
		if(Address.name == ""){
		    document.getElementById('name_msg').innerHTML = address_label_not_empty;
		    err = true;
		}
		 if (Address.consignee == "")
		  {
		    document.getElementById('consignee_msg').innerHTML = consignee_name_not_empty;
		    err = true;
		  }
		  if (Address.email == "" && !( /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/.test(Address.email)))
		  {
		    document.getElementById('email_msg').innerHTML = invalid_email;
		    err = true;
		  }		  			
  		 if(regions_arr[2] == "")
  		 {
			document.getElementById('regions_msg').innerHTML = choose_area;
		    err = true;
  		 }else if(regions_arr[2] == please_choose){
			document.getElementById('regions_msg').innerHTML = choose_area;
		    	err = true;
  		 }else if(Address.regions == please_choose+" "){
			document.getElementById('regions_msg').innerHTML = choose_area;
		    	err = true;  		 	
  		 }
		  if (Address.address == "")
		  {
		    document.getElementById('address_msg').innerHTML = address_detail_not_empty;
		    err = true;
		  }else if(Address.address.length < 8){
		    document.getElementById('address_msg').innerHTML = not_less_eight_characters;
		    err = true;
		  }

		  if (Address.zipcode == "")
		  {
		    document.getElementById('zipcode_msg').innerHTML = zip_code_not_empty;
		    err = true;
		  }
		  if ( (tel_0 == "" || tel_1 == "") && Address.mobile == "")
		  {
		    document.getElementById('tel_msg').innerHTML = telephone_or_mobile;
		    err = true;
		  }	
	/*	 if (Address.mobile == "")
		  {
		    document.getElementById('mobile_msg').innerHTML = mobile_phone_not_empty;
		    err = true;
		  }
	*/


 		  if (err)
		  {
		   // message = msg.join("\n");
		   // alert(message);
		    YAHOO.example.container.wait.hide();
		    return;
		  }
 		
 		var sUrl = webroot_dir+"addresses/checkout_address_add/";
		var postData ="address="+ YAHOO.lang.JSON.stringify(Address);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, edit_address_callback,postData);
	
	}
	var edit_address_Success = function(o){
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

	var edit_address_callback ={
		success:edit_address_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
		function add_user_address(){
		YAHOO.example.container.wait.show();
		var i=0;
		var Region="";
		while(true){
			if(document.getElementById('AddressRegion'+i)==null){
				break;
			}
			Region +=document.getElementById('AddressRegion'+i).value + " ";
			i++;
 		}
		var Address = new Object();
 		Address.regions = Region;
 	//	Address.id =document.getElementById('UserAddressId').value;
 	    Address.name =document.getElementById('UserAddressName').value;
 		Address.consignee =document.getElementById('UserAddressConsignee').value;
 		Address.sign_building =document.getElementById('UserAddressSignBuilding').value;
 		Address.best_time =document.getElementById('UserAddressBestTime').value;
 		Address.address =document.getElementById('UserAddressAddress').value;
 		Address.mobile =document.getElementById('UserAddressMobile').value;
 	//	Address.sign_building =document.getElementById('EditAddressSignBuilding').value;
 		var tel_0 = document.getElementById('tel_0').value;
 		var tel_1 = document.getElementById('tel_1').value;
 		var tel_2 = document.getElementById('tel_2').value;
 		Address.telephone = tel_0+"-"+tel_1
 		if(tel_2 != ""){
 		Address.telephone +="-"+tel_2;
		}
 		Address.zipcode =document.getElementById('UserAddressZipcode').value;
 		Address.email =document.getElementById('UserAddressEmail').value;
 	  //Address.best_time =document.getElementById('EditAddressBestTime').value;
 		//判断输入的内容
 		 var regions_arr = Address.regions.split(" ");
 		 var msg = new Array();
  		 var err = false;
  		 document.getElementById('consignee_msg').innerHTML = "*";
		    document.getElementById('email_msg').innerHTML = "*";
			document.getElementById('regions_msg').innerHTML = "*";
		    document.getElementById('address_msg').innerHTML = "*";
		    document.getElementById('zipcode_msg').innerHTML = "*";
		    document.getElementById('tel_msg').innerHTML = "*";
		    document.getElementById('mobile_msg').innerHTML = "*";
		    document.getElementById('name_msg').innerHTML = "*";
		
		if(Address.name == ""){
		    document.getElementById('name_msg').innerHTML = address_label_not_empty;
		    err = true;
		}

		 if (Address.consignee == "")
		  {
		    document.getElementById('consignee_msg').innerHTML = consignee_name_not_empty;
		    err = true;
		  }
		  if (Address.email == "" && !( /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/.test(Address.email)))
		  {
		    document.getElementById('email_msg').innerHTML = invalid_email;
		    err = true;
		  }		  			
  		 if(regions_arr[2] == "")
  		 {
			document.getElementById('regions_msg').innerHTML = choose_area;
		    err = true;
  		 }else if(regions_arr[2] == please_choose){
			document.getElementById('regions_msg').innerHTML = choose_area;
		    	err = true;
  		 }else if(Address.regions == please_choose+" "){
			document.getElementById('regions_msg').innerHTML = choose_area;
		    	err = true;  		 	
  		 }
		  if (Address.address == "")
		  {
		    document.getElementById('address_msg').innerHTML = address_detail_not_empty;
		    err = true;
		  }else if(Address.address.length < 8){
		    document.getElementById('address_msg').innerHTML = telephone_or_mobile;
		    err = true;
		  }

		  if (Address.zipcode == "")
		  {
		    document.getElementById('zipcode_msg').innerHTML = zip_code_not_empty;
		    err = true;
		  }
		  if ((tel_0 == "" || tel_1 == "") && Address.mobile == "")
		  {
		    document.getElementById('tel_msg').innerHTML = telephone_or_mobile;
		    err = true;
		  }
		 /*
		 if (Address.mobile == "")
		  {
		    document.getElementById('mobile_msg').innerHTML = mobile_phone_not_empty;
		    err = true;
		  }*/
 		  if (err)
		  {
		  //  message = msg.join("\n");
		  //  alert(message);
		    YAHOO.example.container.wait.hide();
		    return;
		  }
 		
 		var sUrl = webroot_dir+"addresses/checkout_address_add/";
		var postData ="address="+ YAHOO.lang.JSON.stringify(Address);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, add_user_address_callback,postData);
	
	}
	var add_user_address_Success = function(o){
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

	var add_user_address_callback ={
		success:add_user_address_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function points_search(){
		var date = document.getElementById('date').value;
		var date2 = document.getElementById('date2').value;
		var min_points = document.getElementById('min_points').value;
		var max_points = document.getElementById('max_points').value;
	     window.location.href=webroot_dir+"points/?date="+date+"&date2="+date2+"&min_points="+min_points+"&max_points="+max_points;
	}
	
	function confirm_edit_password(){
		YAHOO.example.container.wait.show();
		var id = document.getElementById("edit_user_id").value;
 		var new_password = document.getElementById("new_password").value;
 		var confirm_new_password = document.getElementById("confirm_new_password").value;
		if(new_password == ""){
			alert(password_can_not_be_blank);
					YAHOO.example.container.wait.hide();
			return;
		}else if(confirm_new_password == ""){
			alert(retype_password_not_blank);
					YAHOO.example.container.wait.hide();
			return;
		}else if(new_password != confirm_new_password){
			alert(Passwords_are_not_consistent);
					YAHOO.example.container.wait.hide();
			return;
		}
 		var sUrl = webroot_dir+"pages/ajax_edit_password/";
		var postData ="password="+new_password+"&id="+id;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_edit_password_callback,postData);
	}
	var confirm_edit_password_Success = function(o){
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

	var confirm_edit_password_callback ={
		success:confirm_edit_password_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function order_pay_no_ajax(id){
		document.forms['order_pay'+id].submit();
	}
	function confirm_order_no_ajax(id){
		document.forms['confirm_order'+id].submit();
	}
	function order_pay(id,status,msg){
		if(status > 1){
			alert(msg);
			return;
		}
		YAHOO.example.container.wait.show();
 		var sUrl = webroot_dir+"orders/order_pay/";
		var postData ="id="+id;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, order_pay_callback,postData);
	}
	var order_pay_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		YAHOO.example.container.wait.hide();
		if(result.type == "0"){
			document.getElementById('message_content').innerHTML = result.content;
			YAHOO.example.container.message.show();
		}else{
			document.getElementById('message_content').innerHTML = result.content;
			YAHOO.example.container.message.show();
		}
	}

	var order_pay_callback ={
		success:order_pay_Success,
		failure:failure_todo,
		timeout :30000,
		argument: {}
	};
	
	
	 function confirm_name(){
         var confirmName = document.getElementById('UNickNme').value;
       //  alert(confirmName)
         if(confirmName == ''){
                alert(enter_registration_username);
                return;
         }
         else{
                YAHOO.example.container.manager.hideAll();
	            YAHOO.example.container.wait.show();
	            var sUrl = webroot_dir+"pages/need_user_question/"+confirmName;
	            var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_name_callback); 
	     }
 }
 
 	var confirm_name_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){  
			YAHOO.example.container.wait.hide();
			alert(o.responseText);
			alert("Invalid data");
		} 
		
	//	alert(1);
	//	alert(result.err)
		if(result.err == 1){
		       document.getElementById('name_msg').innerHTML = "<font color=red>"+result.err_msg+"</font>";
		       document.getElementById('name_msg').focus();
		}
		else{
		    document.getElementById('need_username').style.display  = 'none';
	        document.getElementById('Personal_info').style.display = 'block';
	        document.getElementById('question').value=result.question;
	        document.getElementById('old_answer').value=result.old_answer;
	        document.getElementById('user_id').value=result.user_id;
	   }
	   YAHOO.example.container.wait.hide();

	}

	var confirm_name_callback ={
		success:confirm_name_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	}
	
	function check_answer(){
	//user_id
	  var Answer=document.getElementById('answer').value;
	  var id=document.getElementById('user_id').value;
	  if(Answer == ''){
	       alert(enter_answer_to_security_questions);
	       return;
	  }
	}
	var add_user_address_Success = function(o){
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

	var add_user_address_callback ={
		success:add_user_address_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
//改支付方式
	function change_payment(PaymentId,OrderId){
	   	YAHOO.example.container.manager.hideAll();
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"orders/change_payment/"+PaymentId+"/"+OrderId;
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, change_payment_callback);
	}
	var change_payment_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
			alert(o.responseText);
			YAHOO.example.container.wait.hide();
		} 
		createDIV("change_payment");
		document.getElementById('message_content').innerHTML = result.content;
		YAHOO.example.container.message.show();
		YAHOO.example.container.wait.hide();
	}

	var change_payment_callback ={
		success:change_payment_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function del_my_comments(CommentId){
	    window.location.href=webroot_dir+"comments/del_comments/"+CommentId;
	}
	
	     function   is_int(txt){  
          txt.value=txt.value.replace(/\D/g,"");  
      }
 
function pay_balance_no_ajax(id){
	document.forms['pay_balance'+id].submit();
} 
 
      //资金
function ActAmount(frm){
  	var amount = new Object;
      amount.money  = frm.elements['amount_num'].value;
  	  var payment =  document.getElementById('payment_id').value;
  	  var err = false;
 	 if(payment< 1){
  	  msg = no_choose_payment_method;
  	  var err = true;
 	}else if(amount.money == ''){
  	  msg = recharge_amount_not_empty;
  	  var err = true;
  	}else if(amount.money == 0){
  	  msg = recharge_amount_larger_zero;
  	  var err = true;
  	}
	YAHOO.example.container.manager.hideAll();
	YAHOO.example.container.wait.show();	
	var sUrl = webroot_dir+"balances/balance_deposit/";
	var postData ='amount='+YAHOO.lang.JSON.stringify(amount);
	postData+='&money='+amount.money+'&payment_id='+payment;
	if(err){
	postData +='&msg='+msg;
	}
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, balance_deposit_back,postData);
	frm.reset();
}
var balancedepositSuccess = function(o){

	    try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
		createDIV("balance_deposit");
		if(YAHOO.example.container.balance_deposit)
			YAHOO.example.container.balance_deposit.destroy();
		document.getElementById('balance_deposit').innerHTML = result.content;
		document.getElementById('balance_deposit').style.display = '';

		YAHOO.example.container.balance_deposit = new YAHOO.widget.Panel("balance_deposit", { 
																		xy:[700,500],
																		fixedcenter:true,
																		draggable:false,
																		modal:true,
																		visible:false,
																		width:"424px",
																		zIndex:1000,
																		effect:{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.5}
																	} 
															);	
															
		var close_balance_deposit = new YAHOO.util.KeyListener(document, { keys:27 },  							
													  { fn:YAHOO.example.container.balance_deposit.hide,
														scope:YAHOO.example.container.balance_deposit,
														correctScope:true }, "keyup" ); 
	 
		YAHOO.example.container.balance_deposit.cfg.queueProperty("keylisteners", close_balance_deposit);
		YAHOO.example.container.balance_deposit.render();
		YAHOO.example.container.manager.register(YAHOO.example.container.balance_deposit);
		YAHOO.example.container.balance_deposit.show();	
		YAHOO.example.container.wait.hide();

}

var balance_deposit_back=
{
  success:balancedepositSuccess,
  failure:failure_todo,
  timeout : 30000,
  argument:{}
};   


	function clearNoNum(obj)
	{
		//先把非数字的都替换掉，除了数字和.
		obj.value = obj.value.replace(/[^\d.]/g,"");
		//必须保证第一个为数字而不是.
		obj.value = obj.value.replace(/^\./g,"");
		//保证只有出现一个.而没有多个.
		obj.value = obj.value.replace(/\.{2,}/g,".");
		//保证.只出现一次，而不能出现两次以上
		obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
	}     
	
	
//确定购买--begin
	function sure_buy(product_id,quantity){
		YAHOO.example.container.message.hide();
		YAHOO.example.container.wait.show();
		var sUrl = cart_webroot+"carts/buy_now/";
		var postData ="id="+product_id+"&quantity="+quantity+"&type=product&sure=1";
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
			window.location.href= cart_webroot+"carts/checkout";
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
	
	function confirm_order(id){
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"orders/confirm_order/";
		var postData ="id="+id;		
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_order_callback,postData);		
	}
	
	var confirm_order_Success = function(o){
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

	var confirm_order_callback ={
		success:confirm_order_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	}; 
	
	
	function add_coupon(){
		document.getElementById('sn_code_msg').innerHTML = "";
	 	var sn_code = document.getElementById('sn_code').value;
	 	if(sn_code == ""){
			document.getElementById('sn_code_msg').innerHTML = coupon_not_empty;
			return;
	 	}
			YAHOO.example.container.wait.hide();
		var sUrl = webroot_dir+"coupons/add_coupon/";
	 	var postData ="sn_code="+sn_code;		
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, add_coupon_callback,postData);
	}
	
	var add_coupon_Success = function(o){
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

	var add_coupon_callback ={
		success:add_coupon_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	}; 	
	
	
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

function pay_balance(id){
  	
	YAHOO.example.container.wait.show();	
	var sUrl = webroot_dir+"balances/pay_balance/";
	var postData ='id='+id;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, pay_balance_back,postData);
}
var pay_balance_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		YAHOO.example.container.wait.hide();
		if(result.type == "0"){
			document.getElementById('message_content').innerHTML = result.content;
			YAHOO.example.container.message.show();
		}else{
			document.getElementById('message_content').innerHTML = result.content;
			YAHOO.example.container.message.show();
		}
	}

var pay_balance_back=
{
  success:pay_balance_Success,
  failure:failure_todo,
  timeout : 30000,
  argument:{}
};   

	function cancleorder(id){
 	    window.location.href=webroot_dir+"orders/cancle_order/"+id;
	
	}

    function layer_dialog_show(id,dialog_content,button_num,button1,button2){
		layer_dialog();
		document.getElementById('layer_dialog').style.display = "block";
		document.getElementById('dialog_content').innerHTML = dialog_content;//对话框中的中文
		var button_replace = document.getElementById('button_replace');
		if(button_num==3){
			button_replace.innerHTML = "<a href='javascript:layer_dialog_obj.hide();' style='padding-right:50px;'>"+button2+"</a>"+"<a href='javascript:cancleorder("+id+");' style='padding-right:50px;'>"+button1+"</a>";
		}
		if(button_num==2){
			button_replace.innerHTML = "<a href='javascript:layer_dialog_obj.hide();' style='padding-right:50px;'>"+button1+"</a>";
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
	
	function buy_now_no_ajax(id,q,type){
		document.forms['buy_now'+type+id].submit();
	}
	function user_login_no_ajax(){
		document.forms['user_login_no_ajax'].submit();
	}
	function need_name(){
		document.forms['need_user_question'].submit();
	}
	function get_captcha(id){
		if((document.getElementById(id).src == "")){
			document.getElementById('UserCaptcha_page').value = '';
			document.getElementById('authnum_img_span').style.display = '';
			document.getElementById(id).src = webroot_dir+"captcha/?"+Math.random();
		}
	}	