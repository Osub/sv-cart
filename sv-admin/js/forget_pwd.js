//弹出输入层   新增忘记密码
   	function forget_password(){
   		YAHOO.example.container.wait.show();
   	   	var sUrl = webroot_dir+"pages/forget_password/";
		var postData = "";
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, forget_password_callback,postData);
	}
	
	var forget_password_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
		}
		YAHOO.example.container.wait.hide();
   		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.message.show();
	}
	
	var forget_password_Failure = function(result){
		alert("error");
	}

	var forget_password_callback ={
		success:forget_password_Success,
		failure:forget_password_Failure,
		timeout : 30000,
		argument: {}
	};
//弹出结果	
	function find_password(){
		YAHOO.example.container.message.hide();
   		YAHOO.example.container.wait.show();
		var name = document.getElementById('name').value;
		var email = document.getElementById('email').value;
		var sUrl = webroot_dir+"pages/send_email/";
		var postData = "name="+name+"&email="+email;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, find_password_callback,postData);
		}
		
	var find_password_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");
		}
   		YAHOO.example.container.wait.hide();
		if(result.type == 0){
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.message.show();
		}else if(result.type == 1){
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.message.show();
		}else{
			alert("fail");
		}
	}
	
	var find_password_Failure = function(result){
		alert("error");
	}

	var find_password_callback ={
		success:find_password_Success,
		failure:find_password_Failure,
		timeout : 30000,
		argument: {}
	};
	//弹出结果	
	function act_change_password(){
		var pwd = document.getElementById('operator_pwd').value;
		if(!vaild_pwd()){
			return;
		}
   		YAHOO.example.container.wait.show();
		var id = document.getElementById('id').value;
		var sUrl = webroot_dir+"pages/update_password/";
		var postData = "pwd="+pwd+"&id="+id;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, act_change_password_callback,postData);
		}
		
	var act_change_password_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");
		}
   		YAHOO.example.container.wait.hide();
		if(result.type == 0){
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.message.show();
		}else if(result.type == 1){
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.message.show();
		}else{
			alert("fail");
		}
	}
	
	var act_change_password_Failure = function(result){
		alert("error");
	}

	var act_change_password_callback ={
		success:act_change_password_Success,
		failure:act_change_password_Failure,
		timeout : 30000,
		argument: {}
	};
	
	
	function vaild_pwd(){
		if(document.getElementById('operator_pwd').value < 2){
			alert("密码不能小于4位！");
			return false;
		}
		if(document.getElementById('operator_pwd').value  == document.getElementById('operator_pwd_t').value){
			return true;
		}else{
			alert("两次密码不一致！");
			return false;
		}
	}
	