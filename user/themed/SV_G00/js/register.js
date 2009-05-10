var isIE = false;
var isFF = false;
var isSa = false;

if ((navigator.userAgent.indexOf("MSIE")>0) && (parseInt(navigator.appVersion) >=4))isIE = true;
if(navigator.userAgent.indexOf("Firefox")>0)isFF = true;
if(navigator.userAgent.indexOf("Safari")>0)isSa = true; 


function init(){
	YAHOO.util.Event.addListener("agreement", "click", agreement, '', true);
	//YAHOO.util.Event.addListener("name", "keydown", check_input_value, '', true);
	YAHOO.util.Event.addListener("name", "blur", check_input_name, '', true);
//	YAHOO.util.Event.addListener("password", "keydown", check_input_value, '', true);
	YAHOO.util.Event.addListener("password", "blur", check_input_password, '', true);
//	YAHOO.util.Event.addListener("password_confirm", "keydown", check_input_value, '', true);
	YAHOO.util.Event.addListener("password_confirm", "blur", check_input_password_confirm, '', true);
	/*
	YAHOO.util.Event.addListener("realname", "keydown", check_input_value, '', true);
	YAHOO.util.Event.addListener("realname", "blur", check_input_realname, '', true);
	*/
	YAHOO.util.Event.addListener("email", "blur", check_input_email, '', true);
	YAHOO.util.Event.addListener("question", "blur", check_question, '', true);
//	YAHOO.util.Event.addListener("answer", "keydown", check_input_value, '', true);
	YAHOO.util.Event.addListener("answer", "blur", check_input_answer, '', true);
	
	/* 可选项 JS判定
	YAHOO.util.Event.addListener("address", "keydown", check_input_value, '', true);
	YAHOO.util.Event.addListener("address", "blur", check_input_address, '', true);
	YAHOO.util.Event.addListener("mobile", "keydown", number_only, '', true);
	YAHOO.util.Event.addListener("mobile", "blur", check_input_mobile, '', true);
	YAHOO.util.Event.addListener("Utel", "keydown", number_only, '', true);
	YAHOO.util.Event.addListener("Utel", "blur", check_input_tel, '', true);
	*/
}

YAHOO.util.Event.onDOMReady(init);

//可输入内容-begin
/*function check_input_value(e){
	var e = arguments[0] || window.event;
	var src = e.srcElement || e.target;
	if(e.keyCode)
		var key = e.keyCode;
	else
		var key = e.which;
	if(key!=8)
	{
		if(!((key>=48&&key<=57)||(key>=96&&key<=105)||key==46||key==37||key==39||key==9||key==16||key==189||(key>=65&&key<=90))) 
		{
			if (isIE)
	        {
	            e.returnValue=false;
	        }
	        else
	        {
	            e.preventDefault();
	        }
		}
    }
}*/

//可输入内容-end

//只能输入数字-begin

function number_only(){
	var e = arguments[0] || window.event;
	var src = e.srcElement || e.target;
	if(e.keyCode)
		var key = e.keyCode;
	else
		var key = e.which;
	if(key!=8)
	{
		if(!(key>=48&&key<=57||(key>=96&&key<=105)||key==46||key==37||key==39||key==9||key==16)) 
		{
			if (isIE)
	        {
	            e.returnValue=false;
	        }
	        else
	        {
	            e.preventDefault();
	        }
		}
    }
}

//-end


//检查输入--begin
function check_input_name(){
	check_input('name');
}
function check_input_password(){
	check_input('password');
}
function check_input_password_confirm(){
	check_input('password_confirm');
}

function check_input_email(){
		check_input('email');
}
function check_question(){
	check_input('question');
}

function check_input_answer(){
	check_input('answer');
}

var user_info_error_num = 0;
var error = 0;
var is_error = 0;
function check_user_info(){
	
	if(document.getElementById('name').value == ''){
		  document.getElementById('name_msg').innerHTML = "<font color=red>"+name_null+"</font>";
		  document.getElementById('name').focus();
	}
	else if(document.getElementById('password').value == ''){
		  document.getElementById('password_msg').innerHTML = "<font color=red>"+pwd_null+"</font>";
		  document.getElementById('password').focus();
	}
	else if(document.getElementById('password_confirm').value == ''){
		  document.getElementById('password_confirm_msg').innerHTML = "<font color=red>"+confirm_pwd_null+"</font>";
		  document.getElementById('password_confirm').focus();
	}
	else if(document.getElementById('password').value != document.getElementById('password_confirm').value){
		  document.getElementById('password_confirm_msg').innerHTML = "<font color=red>"+pwd_cfm_error+"</font>";
		  document.getElementById('password_confirm').focus();
	}
	else if(document.getElementById('email').value == ''){
		  document.getElementById('email_msg').innerHTML = "<font color=red>"+email_null+"</font>";
		  document.getElementById('email').focus();
	}
	else if(document.getElementById('question').value == 0){
		  document.getElementById('question_msg').innerHTML = "<font color=red>"+question_null+"</font>";
		  document.getElementById('question').focus();
	}else if(document.getElementById('other_span').style.display == "block"  && document.getElementById('other_question').value == ''){
		  document.getElementById('other_question_msg').innerHTML = "<font color=red>"+fill_security_question+"</font>";
		  document.getElementById('other_question').focus();
	}
	else if(document.getElementById('answer').value == ''){
		  document.getElementById('answer_msg').innerHTML = "<font color=red>"+answer_null+"</font>";
		  document.getElementById('answer').focus();
	}
	else{
		is_error = 0;
		
	//	check_input_name();
	//	check_input_password();
	  //  check_input_password_confirm();
	 //  check_input_email();
	 //   check_question();
	 //   check_input_answer();
		check_input('all');
		YAHOO.example.container.wait.show();
	   // setTimeout("register_submit()",3000);
	    //
	}
	

}
/*
	var question = document.getElementById('question').value;
	if(question == others){
       	 document.getElementById('other_span').style.display="block";*/
function register_submit(){
	if(is_error < 1){
		document.user_info.submit();
	}else{
	YAHOO.example.container.wait.hide();
	}
}

function check_input(column){
	if(column == 'all'){
		var sUrl = webroot_dir+"check_all/";
		var name = document.getElementById('name').value;
		var password = document.getElementById('password').value;
		var pwd_cfm = document.getElementById('password_confirm').value;
		var email = document.getElementById('email').value;
		var question = document.getElementById('question').value;
		var answer = document.getElementById('answer').value;
		var postData = " name="+name+"&password="+password+"&email="+email+"&question="+question+"&column=all&answer="+answer+"&pwd_cfm="+pwd_cfm;
	}else if(column == 'password_confirm'){
		var sUrl = webroot_dir+"check_input/";
		var value = document.getElementById(column).value;
		var pwd = document.getElementById('password').value;
		var pwd_cfm = document.getElementById('password_confirm').value;
		var postData = " column="+column+"&password="+pwd+"&password_confirm="+pwd_cfm;
	}else{
		var sUrl = webroot_dir+"check_input/";
		var value = document.getElementById(column).value;
		var postData = " column="+column+"&value="+value;
	}
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, check_input_callback,postData);
}

	var check_input_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
			alert(o.responseText);
		} 

		if(result.column == "all"){			
			if(result.error_type == ""){
				document.user_info.submit();
			}else{
			document.getElementById(result.error_type+'_msg').innerHTML = "<font color=red>"+result.error_msg+"</font>";
			YAHOO.example.container.wait.hide();
			}	
		}else if(result.error == 1){
			user_info_error_num = 1;
			document.getElementById(result.column+'_msg').innerHTML = "<font color=red>"+result.error_msg+"</font>";
			is_error ++;
			//document.getElementById(result.column).focus();
            return false;
		}else{
			user_info_error_num = 0;
			document.getElementById(result.column+'_msg').innerHTML = '';
		}
		error += user_info_error_num;
		
		return o.status;
	}

	var check_input_Failure = function(result){
		user_info_error_num = 1;
		error += user_info_error_num;
	}

	var check_input_callback ={
		success:check_input_Success,
		failure:check_input_Failure,
		timeout : 30000,
		argument: {}
	};
	
//检查输入--end	

//同意会员注册协议
function agreement(){
	document.getElementById('agreement').style.display  = "none";
	document.getElementById('reguser_box').style.display  = "none";
	var question = document.getElementById('question').value;
	if(question == others){
       	 document.getElementById('other_span').style.display="block";
       	   /*
		   if(send_style.style.display=="none"){
				send_style.style.display="block";
		  	}else{
				send_style.style.display="none";
		   }*/
	 }else{
       	 document.getElementById('other_span').style.display="none";
	 }
	document.getElementById('reguser_box_user').style.position = "";
	document.getElementById('reguser_box_user').style.visibility = "visible";
//	alert(document.getElementById('Personal_info').offsetHeight);
}

//显示隐藏选填信息
function Personal(targetid,objN){
   //alert(template);
   var  Shrink=document.getElementById(targetid);
   var Expansions=document.getElementById(objN);
            if (Shrink.style.height=="100%"){
                Shrink.style.height="0";
                Shrink.style.lineHeight="0";
    Expansions.style.background="url("+webroot_dir+themePath+"img/down_icon.gif) no-repeat left";
            } else {
                Shrink.style.height="100%";
                Shrink.style.lineHeight="normal";
    Expansions.style.background="url("+webroot_dir+themePath+"img/up_icon.gif) no-repeat left";
            }
}