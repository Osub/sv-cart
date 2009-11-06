function commnet_init() {
			YAHOO.example.container.add_comment = new YAHOO.widget.Overlay("add_comment",{fixedcenter:true,
																					  visible:false,
																					  width:"601px" });
			YAHOO.example.container.add_comment.render();
			YAHOO.log("add_comment rendered.", "info", "example");
			YAHOO.util.Event.addListener("comments", "click", YAHOO.example.container.add_comment.show, YAHOO.example.container.add_comment, true);
			YAHOO.util.Event.addListener("submit_comment", "click", submit_comment, YAHOO.example.container.add_comment, true);
			YAHOO.util.Event.addListener("close_comment","click",YAHOO.example.container.add_comment.hide,YAHOO.example.container.add_comment,true);
			YAHOO.util.Event.addListener("comments_rank", "click", YAHOO.example.container.add_comment.show, YAHOO.example.container.add_comment, true);

			/*	 上传我的相册  */
			YAHOO.example.container.my_photo = new YAHOO.widget.Overlay("my_photo",{fixedcenter:true,
																					  visible:false,
																					  width:"424px" });
			YAHOO.example.container.my_photo.render();
			YAHOO.log("my_photo rendered.", "info", "example");
			YAHOO.util.Event.addListener("my_photos", "click", YAHOO.example.container.my_photo.show, YAHOO.example.container.my_photo, true);
			YAHOO.util.Event.addListener("submit_my_photo", "click", submit_comment, YAHOO.example.container.my_photo, true);
			YAHOO.util.Event.addListener("close_my_photo","click",YAHOO.example.container.my_photo.hide,YAHOO.example.container.my_photo,true);

			/*	 好友推荐  */
			YAHOO.example.container.add_recommend = new YAHOO.widget.Panel("add_recommend",{fixedcenter:true,
																					  visible:false,close:true,
																					  width:"424px" });
			YAHOO.example.container.add_recommend.render();
			YAHOO.log("add_recommend rendered.", "info", "example");
			YAHOO.util.Event.addListener("recommends", "click", YAHOO.example.container.add_recommend.show, YAHOO.example.container.add_recommend, true);
			YAHOO.util.Event.addListener("submit_recommend", "click", submit_recommend, YAHOO.example.container.add_recommend, true);
			YAHOO.util.Event.addListener("close_recommend","click",YAHOO.example.container.add_recommend.hide,YAHOO.example.container.add_recommend,true);

			/*	 商品提问  */
			YAHOO.example.container.add_product_message = new YAHOO.widget.Panel("add_product_message",{fixedcenter:true,
																					  visible:false,close:false,
																					  width:"601px" });
			YAHOO.example.container.add_product_message.render();
			YAHOO.log("add_product_message rendered.", "info", "example");
			YAHOO.util.Event.addListener("product_message", "click", YAHOO.example.container.add_product_message.show, YAHOO.example.container.add_product_message, true);
			YAHOO.util.Event.addListener("submit_product_message", "click", submit_message, YAHOO.example.container.add_product_message, true);
			YAHOO.util.Event.addListener("close_product_message","click",YAHOO.example.container.add_product_message.hide,YAHOO.example.container.add_product_message,true);


}
YAHOO.util.Event.onDOMReady(commnet_init); 

	function show_my_photo(id){
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"commons/can_updata_photo/";
		var postData ="id="+id;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, show_my_photo_callback,postData);
	}

	var show_my_photo_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
		//	alert(o.responseText);
			YAHOO.example.container.wait.hide();
		}
		YAHOO.example.container.wait.hide();
		if(result.type == 0){
			YAHOO.example.container.my_photo.show();
		}else if(result.type == 1){
			layer_dialog_show(result.msg,'',2,'','','','','');
		}
		
	}

	var show_my_photo_callback ={
		success:show_my_photo_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};


	function close_my_photo(){
		YAHOO.example.container.my_photo.hide();	
	}

	function close_product_message(){
		YAHOO.example.container.add_product_message.hide();
	}

	function close_recommend(){
		YAHOO.example.container.add_recommend.hide();
	}
	
	function close_comment(){
		document.getElementById('comment_error_msg').innerHTML = "";
		YAHOO.example.container.add_comment.hide();
	}
	function comment_rank(rank){
		document.getElementById('CommentRank_').value = rank;
	}
	//提交评论
	function submit_comment(){
		var CommentUserName = document.getElementById('CommentUserName').value;
		var CommentUserId = document.getElementById('CommentUserId').value;
		var CommentEmail = document.getElementById('CommentEmail').value;
		var CommentContent = document.getElementById('CommentContent').value;
		var CommentType = document.getElementById('CommentType').value;
		var CommentTypeId = document.getElementById('CommentTypeId').value;
		var CommentCaptcha = document.getElementById('CommentCaptcha').value;
		var CommentRank = document.getElementById('CommentRank_').value;
		if(isEmail(CommentEmail)){
			document.getElementById('comment_error_msg').innerHTML = invalid_email;
			return;
		}else if(CommentRank == ""){
			document.getElementById('comment_error_msg').innerHTML = select_level_comments;
			return;
		}else if(CommentContent == ""){
			document.getElementById('comment_error_msg').innerHTML = comments_not_empty;
			return;
		}
		
		//alert("123");
//		set_wait(wait_message);
//		YAHOO.example.container.wait.show();
		document.getElementById('comment_button').innerHTML = "<span class='green_3'>"+wait_message+"</span>";
		var sUrl = webroot_dir+"comments/add/";
		var postData = '&username='+CommentUserName+'&user_id='+CommentUserId+"&email="+CommentEmail+"&content="+CommentContent+"&type="+CommentType+"&id="+CommentTypeId+"&rank="+CommentRank+"&captcha="+CommentCaptcha+"&is_ajax=1";
		//alert(postData);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, commentback,postData);
	}
	
		var commentSuccess = function(o){
	    try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){
			alert(o.responseText);
			//alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
		document.getElementById('message_content').innerHTML = result.message;
		if(result.type == 0){
			YAHOO.example.container.add_comment.hide();
		}
		document.getElementById('comment_button').innerHTML = "<a href='javascript:submit_comment();' class='reset'>"+page_submit+"</a><a href='javascript:document.commentForm.reset();' class='reset'>"+page_reset+"</a>";
		
	//	YAHOO.example.container.wait.hide();
		YAHOO.example.container.message.show();
	}
	
	var commentback =
	{
	  success:commentSuccess,
	  failure:failure_todo,
	  timeout : 30000,
	  argument:{}
	};
	
function form1_onsubmit(is_login){
   var Title=document.getElementById('title').value;
   var Content=document.forms['message_form'].message_content.value;
   var message_type_id = document.getElementById('message_type_id').value;
   //var MessageType=document.getElementById('message_type').value;
	//   document.getElementById('msg_content').innerHTML = "*";
   //    document.getElementById('msg_title').innerHTML = "*";
   var err = true;
   if(is_login == 0){
		layer_dialog_show(time_out_relogin_js,'',2,'','','','','');
   		return;
   }
   if(Title == ''){
       document.getElementById('msg_title').innerHTML = subject_is_blank;
       err = false;
   }
   if(Content == ''){
       document.getElementById('msg_content').innerHTML = content_empty;
       err = false;
   }
  
   if(err){
     // document.forms['form1'].submit();
		var sUrl = webroot_dir+"commons/add_message/";
		var postData ="title="+Title+"&content="+Content+"&value_id="+message_type_id;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, add_message_callback,postData);
   }
}

	var add_message_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){
			alert(o.responseText);
			//alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		layer_dialog_show(result.msg,'',2,'','','','','');
	}
	
	var add_message_callback ={
		success:add_message_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};

