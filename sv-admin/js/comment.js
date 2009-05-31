function commnet_init() {
	YAHOO.example.container.add_comment = new YAHOO.widget.Panel("add_comment", { xy:[400,500],visible:false,width:"601px",zIndex:1000,effect:{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.4}});
	var close_add_comment = new YAHOO.util.KeyListener(document, { keys:27 },{ fn:YAHOO.example.container.add_comment.hide,scope:YAHOO.example.container.add_comment,correctScope:true }, "keyup" );
	YAHOO.example.container.add_comment.cfg.queueProperty("keylisteners", close_add_comment);
	YAHOO.example.container.add_comment.render();
	YAHOO.util.Event.addListener("comments", "click", YAHOO.example.container.add_comment.show, YAHOO.example.container.add_comment, true);
	YAHOO.util.Event.addListener("submit_comment", "click", submit_comment, YAHOO.example.container.add_comment, true);
	 
	var commentSuccess = function(o){
	    try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
		
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.add_comment.hide();
		YAHOO.example.container.wait.hide();
		
		YAHOO.example.container.message.show();
	}

	var commentFailure = function(o){
	 	alert("Failure");
	};

	var commentback =
	{
	  success:commentSuccess,
	  failure:commentFailure,
	  argument:{}
	};

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
		var CommentRank = document.getElementById('CommentRank_').value;
		YAHOO.example.container.wait.show();
		var sUrl = "/comments/add/";
		var postData = '&username='+CommentUserName+'&user_id='+CommentUserId+"&email="+CommentEmail+"&content="+CommentContent+"&type="+CommentType+"&id="+CommentTypeId+"&rank="+CommentRank;
	//	alert(postData);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, commentback,postData);
	}

	
}
YAHOO.util.Event.onDOMReady(commnet_init);
