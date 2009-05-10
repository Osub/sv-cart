function friend_init() {
			// 添加分组弹出框
			YAHOO.example.container.new_friend_box = new YAHOO.widget.Overlay("new_friend_box", { fixedcenter:true,
						
																					  visible:false,
																					  width:"320px" } );
			YAHOO.example.container.new_friend_box.render();
			YAHOO.log("new_friend_box rendered.", "info", "example");

			YAHOO.util.Event.addListener("new_friend_group", "click", YAHOO.example.container.new_friend_box.show, YAHOO.example.container.new_friend_box, true);
			YAHOO.util.Event.addListener("close", "click", YAHOO.example.container.new_friend_box.hide, YAHOO.example.container.new_friend_box, true);

		}
		YAHOO.util.Event.addListener(window, "load", friend_init);
		
		
function del_friends(FriendId){
    window.location.href=webroot_dir+"friends/del_friends/"+FriendId;
}
function add_cat_friend(CatId){
  	send_style=document.getElementById('add_group['+CatId+']');
	if(send_style.style.display=="none"){
		send_style.style.display="block";
	}
	else{
		send_style.style.display="none";
	}
}
function show_edit_contact(FriendId){
   	send_style=document.getElementById('edit_friend['+FriendId+']');
	if(send_style.style.display=="none"){
		send_style.style.display="block";
	}
	else{
		send_style.style.display="none";
	}
}

	
//删除分组-----begin
function del_contact_cat(CatId,Count){
  if(Count > 0){
    alert(friends_in_group_not_cancelled);
  }
  else{
    window.location.href=webroot_dir+"friends/del_cat/"+CatId;
  }
}
//删除分组------end

//修改分组名称-----begin
function modify_cat(CatId){
	if(!document.getElementById("new_cat_name")){
		var obj=document.getElementById('contact_cat['+CatId+']');
		var temp_info=obj.innerHTML;
		obj.innerHTML=""; 
		var temp_text = document.createElement("input"); 
		temp_text.id="new_cat_name"; 
		temp_text.value=temp_info.replace(/\r\n?/, "\n");
		temp_text.onblur=function(){
	   var new_cat_item=document.getElementById("new_cat_name").value;
	   if(new_cat_item == ""){
		document.getElementById('cat_msg'+CatId).innerHTML = group_name_can_not_empty;
	    return;
	   }
	   obj.innerHTML=new_cat_item;
	   YAHOO.example.container.wait.show();
	   var sUrl = webroot_dir+"friends/modifycat/"+CatId+"/"+new_cat_item;
	     document.getElementById('cat_msg'+CatId).innerHTML = "";

	   var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, modify_cat_callback);
		}
		obj.appendChild(temp_text);
	}
}
	var modify_cat_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert("Invalid data");   
			YAHOO.example.container.wait.hide();
		} 
		createDIV("modify_ok");
		if(YAHOO.example.container.modify_ok)
			YAHOO.example.container.modify_ok.destroy();
		document.getElementById('modify_ok').innerHTML = result.content;
		document.getElementById('modify_ok').style.display = '';

		YAHOO.example.container.modify_ok = new YAHOO.widget.Panel("modify_ok", { 
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
															
		var close_modify_ok = new YAHOO.util.KeyListener(document, { keys:27 },  							
													  { fn:YAHOO.example.container.modify_ok.hide,
														scope:YAHOO.example.container.modify_ok,
														correctScope:true }, "keyup" ); 
	 
		YAHOO.example.container.modify_ok.cfg.queueProperty("keylisteners", close_modify_ok);
		YAHOO.example.container.modify_ok.render();
		YAHOO.example.container.manager.register(YAHOO.example.container.modify_ok);
		YAHOO.example.container.modify_ok.show();	
		YAHOO.example.container.wait.hide();
	}

	var modify_cat_callback ={
		success:modify_cat_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
//修改分组名称-------end
	function hide_cat(){
		document.getElementById("cat_error_msg").innerHTML = "*";
	}

	
	function submit_add_friend(id){
		var address = document.getElementById("UserFriendAddress"+id).value;
		var mobile = document.getElementById("UserFriendContactMobile"+id).value;
		var name = document.getElementById("UserFriendContactName"+id).value;
		var email = document.getElementById("UserFriendContactEmail"+id).value;
		var other_email = document.getElementById("UserFriendContactOtherEmail"+id).value;
		var err = false;
			document.getElementById("friendname"+id).innerHTML = "*";
			document.getElementById("friendemail"+id).innerHTML = "*";
			document.getElementById("ortherfriendemail"+id).innerHTML = "";
			document.getElementById("address"+id).innerHTML = "*";
			document.getElementById('mobile'+id).innerHTML = "";
		if(name == ""){
			document.getElementById("friendname"+id).innerHTML = friend_name_not_empty;
			err = true;
		}
		if(isEmail(email)){
			document.getElementById("friendemail"+id).innerHTML = invalid_email;
			err = true;
		}
		if(other_email != ""){
			if(isEmail(other_email)){
			document.getElementById("ortherfriendemail"+id).innerHTML = invalid_email;
			err = true;
			}
		}
		if(address == ""){
			document.getElementById("address"+id).innerHTML = address_detail_not_empty;
			err = true;
		}
		if(mobile != ""){
			if(mobile != parseInt(mobile))  
				{  
			  		document.getElementById('mobile'+id).innerHTML = invalid_tel_number;
					err = true;
				}else{
					telephone = parseInt(mobile);
					if(parseInt(telephone) < 0){
			  		document.getElementById('mobile'+id).innerHTML = invalid_tel_number;
						err = true;
					}
				}
		}
		if(err){
			return;
		}		
		document.forms['ContactForm'+id].submit();
	}
	
	function submit_edit_friend(id){
		var address = document.getElementById("UserFriendAddress"+id).value;
		var mobile = document.getElementById("UserFriendContactMobile"+id).value;
		var name = document.getElementById("UserFriendContactName"+id).value;
		var email = document.getElementById("UserFriendContactEmail"+id).value;
		var other_email = document.getElementById("UserFriendContactOtherEmail"+id).value;
		var err = false;
			document.getElementById("friendname"+id).innerHTML = "*";
			document.getElementById("friendemail"+id).innerHTML = "*";
			document.getElementById("ortherfriendemail"+id).innerHTML = "";
			document.getElementById("address"+id).innerHTML = "*";
			document.getElementById('mobile'+id).innerHTML = "";
		if(name == ""){
			document.getElementById("friendname"+id).innerHTML = friend_name_not_empty;
			err = true;
		}
		if(isEmail(email)){
			document.getElementById("friendemail"+id).innerHTML = invalid_email;
			err = true;
		}
		if(other_email != ""){
			if(isEmail(other_email)){
			document.getElementById("ortherfriendemail"+id).innerHTML = invalid_email;
			err = true;
			}
		}
		if(address == ""){
			document.getElementById("address"+id).innerHTML = address_detail_not_empty;
			err = true;
		}
		if(mobile != ""){
			if(mobile != parseInt(mobile))  
				{  
			  		document.getElementById('mobile'+id).innerHTML = invalid_tel_number;
					err = true;
				}else{
					telephone = parseInt(mobile);
					if(parseInt(telephone) < 0){
			  		document.getElementById('mobile'+id).innerHTML = invalid_tel_number;
						err = true;
					}
				}
		}
		if(err){
			return;
		}		
		document.forms['EditContactForm'+id].submit();
	}
	
	function newfriendgroup(){
	YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"friends/new_group/";
		var postData = "";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, new_friend_group_back,postData);
	}
	var new_friend_group_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
			alert(o.responseText);
			YAHOO.example.container.wait.hide();
		} 
		document.getElementById('friends_message_content').innerHTML = result.content;
		YAHOO.example.container.friends_message.show();
		YAHOO.example.container.wait.hide();
	}

	var new_friend_group_back ={
		success:new_friend_group_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function submit_insertcat(){
		document.getElementById("cat_error_msg").innerHTML = "";

		var user_id = document.getElementById("UserFriendCatUserId").value;
		var cat_name = document.getElementById("UserFriendCatCatName").value;
		if(cat_name == ""){
	//	alert(group_name_can_not_empty);
		document.getElementById("cat_error_msg").innerHTML = group_name_can_not_empty;
		return;
		}else{
		//document.forms['InsertCat'].submit(); 
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"friends/add_cat/";
		var postData = "user_id="+user_id+"&cat_name="+cat_name;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, submit_insertcat_back,postData);		
		}
	}
		var submit_insertcat_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
			alert(o.responseText);
			YAHOO.example.container.wait.hide();
		} 
		YAHOO.example.container.friends_message.hide();
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.message.show();
		YAHOO.example.container.wait.hide();
	}

	var submit_insertcat_back ={
		success:submit_insertcat_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
