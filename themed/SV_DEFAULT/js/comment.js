function commnet_init() {
			YAHOO.example.container.add_comment = new YAHOO.widget.Overlay("add_comment",{fixedcenter:true,
																					  visible:false,
																					  width:"601px" });
			YAHOO.example.container.add_comment.render();
			YAHOO.log("add_comment rendered.", "info", "example");
			YAHOO.util.Event.addListener("comments", "click", YAHOO.example.container.add_comment.show, YAHOO.example.container.add_comment, true);
			YAHOO.util.Event.addListener("submit_comment", "click", submit_comment, YAHOO.example.container.add_comment, true);
			YAHOO.util.Event.addListener("close_comment","click",YAHOO.example.container.add_comment.hide,YAHOO.example.container.add_comment,true);

}
YAHOO.util.Event.onDOMReady(commnet_init); 

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