  //搜索用户
function searchUsers(){
        var keywords=document.getElementById('user_keywords').value;

		var sUrl = webroot_dir+"coupons/searchusers/"+keywords;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, searchUsers_callback);
	}

	var searchUsers_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert("Invalid data");
			alert(o.responseText);
		}
		 var sel = document.getElementById('source_select1');
	//	 alert(sel);
		if (result.message){
             for (i = 0; i < result.message.length; i++ ){
                 var opt = document.createElement("OPTION");
                      opt.value = result.message[i]['User'].id;
                      opt.text  = result.message[i]['User'].name;
                      sel.options.add(opt);
              }
     //    alert(sel);
         }
         YAHOO.example.container.wait.hide();
	}

	var searchUsers_Failure = function(o){
		alert("error");
	}

	var searchUsers_callback ={
		success:searchUsers_Success,
		failure:searchUsers_Failure,
		timeout : 10000,
		argument: {}
	};
	
	
	//增加select项－－－按用户发放
function addCoupon (source,act,Id,isDouble,Type)
  {
    for (var i = 0; i < source.length; i ++ )
    {
    	if (!source.options[i].selected) continue;
      	  linkedId=source.options[i].value;
    }
    if (linkedId > 0)
    {
      //ajax处理
        YAHOO.example.container.manager.hideAll();
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"coupons/"+act+"/"+linkedId+"/"+Id+"/"+Math.random();
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, addCoupon_callback);
    }
  }
  	var addCoupon_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
			alert(o.responseText);
			YAHOO.example.container.wait.hide();
		} 
		var newhtml='';
		var is_div = document.getElementById(result.msg['id'])!=null && document.getElementById(result.msg['id']).tagName=="DIV";
        	if (result.msg && !is_div){
        		   var newDiv  = document.createElement("div");
        		   newDiv.setAttribute("id",result.msg['id']);
                   newhtml +="<p class='rel_list'><span class='handle'><input type='button' value='删除' onclick=\"dropCoupon("+result.coupon_id+",'"+result.action+"', "+result.msg['id']+");\"/></span>"+result.msg['name']+"</p>";
                   
                   newDiv.innerHTML = newhtml;
                   document.getElementById("relativies_box").appendChild(newDiv);
                   newhtml="";
         	}
        YAHOO.example.container.wait.hide();
	}

	var addCoupon_Failure = function(result){
		YAHOO.example.container.wait.hide();
	}

	var addCoupon_callback ={
		success:addCoupon_Success,
		failure:addCoupon_Failure,
		timeout : 30000,
		argument: {}
	};
	
	//增加select项－－－按用户发放
function dropCoupon(id,act,user_id)
  {
      //ajax处理
        YAHOO.example.container.manager.hideAll();
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"coupons/"+act+"/"+id+"/"+user_id+"/"+Math.random();
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, dropCoupon_callback);
  }
  	var dropCoupon_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
			alert(o.responseText);
			YAHOO.example.container.wait.hide();
		} 
        if (result.msg){
        	var id = result.msg;
			document.getElementById(id).style.display = "none";
         }
        YAHOO.example.container.wait.hide();
	}

	var dropCoupon_Failure = function(result){
		YAHOO.example.container.wait.hide();
	}

	var dropCoupon_callback ={
		success:dropCoupon_Success,
		failure:dropCoupon_Failure,
		timeout : 30000,
		argument: {}
	};	
	
	function confirm_type(type){
		if(type == 2){
			document.getElementById('min_products_amount').style.display = "block";
		}else{
			document.getElementById('min_products_amount').style.display = "none";
		}
	}
	
	function  is_int(txt){  
	    txt.value=txt.value.replace(/\D/g,"");  
	}   

	function num_check(){
	var num = document.getElementById('num');
	layer_dialog();
		if( Trim( num.value,'g' ) == "" ){
			layer_dialog_show("优惠券数量不能为空!","",3);
			return false;
		}
	}
	
	function coupon_check(){
	var max_buy_quantity = document.getElementById('max_buy_quantity');
	var order_amount_discount = document.getElementById('order_amount_discount');
	layer_dialog();
		if( Trim( max_buy_quantity.value,'g' ) == "" ){
			layer_dialog_show("优惠券可使用次数不能为空!","",3);
			return false;
		}	
		if( Trim( order_amount_discount.value,'g' ) == "" ){
			layer_dialog_show("优惠券折扣不能为空!","",3);
			return false;
		}			
	}
	
	
	function send_coupon_email(id)
  {
      //ajax处理
        YAHOO.example.container.manager.hideAll();
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"coupons/user_coupon_email/"+id+"/"+Math.random();
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, send_coupon_email_callback);
  }
  	var send_coupon_email_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
			alert(o.responseText);
			YAHOO.example.container.wait.hide();
		} 
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.wait.hide();
		YAHOO.example.container.message.show();
	}

	var send_coupon_email_Failure = function(result){
		YAHOO.example.container.wait.hide();
	}

	var send_coupon_email_callback ={
		success:send_coupon_email_Success,
		failure:send_coupon_email_Failure,
		timeout : 30000,
		argument: {}
	};
	
	function send_by_user_rank(){
		var user_rank = document.getElementById('user_rank').value;
		layer_dialog();
		if( user_rank == 0 ){
			layer_dialog_show("请选择会员等级","",3);
			return;
		}			
		document.send_by_form.submit();
	}