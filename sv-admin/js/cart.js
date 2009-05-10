//已修正开始

//将购物车页的促销商品添加到购物车--begin
	function buy_on_cart_page(product_id){
		YAHOO.example.container.wait.show();
		var sUrl = "/carts/buy_now/";
		var postData ="product_id="+product_id+"&quantity="+1+"&page=cart";
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, buy_on_cart_page_callback,postData);
	}

	var buy_on_cart_page_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		if(result.page == "cart" && result.type == "0"){
			document.getElementById('my_cart').innerHTML = result.message;
		}else{
		
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
		YAHOO.example.container.wait.hide();

	}

	var buy_on_cart_page_Failure = function(result){
		alert("error");
		YAHOO.example.container.wait.hide();
	}

	var buy_on_cart_page_callback ={
		success:buy_on_cart_page_Success,
		failure:buy_on_cart_page_Failure,
		timeout : 10000,
		argument: {}
	};



//显示从购物车中删除商品的确认框--begin
	function remove_product(product_id){
		YAHOO.example.container.wait.show();
		var sUrl = "/carts/remove/";
		var postData ="product_id="+product_id;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, remove_product_callback,postData);
	}

	var remove_product_Success = function(o){
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

	var remove_product_Failure = function(result){
		YAHOO.example.container.wait.hide();
	}

	var remove_product_callback ={
		success:remove_product_Success,
		failure:remove_product_Failure,
		timeout : 10000,
		argument: {}
	};
//显示从购物车中删除商品的确认框--end

//将商品从购物车中删除--begin
	function act_remove_product(product_id){
		YAHOO.example.container.message.hide();	
		YAHOO.example.container.wait.show();
		var sUrl = "/carts/act_remove/";
		var postData ="product_id="+product_id;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, act_remove_product_callback,postData);


	}

	var act_remove_product_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");  
			YAHOO.example.container.wait.hide();
		} 
		
		if(result.type == "0"){
			document.getElementById('my_cart').innerHTML = result.message;
		}else{
		
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
		
		YAHOO.example.container.wait.hide();
	}

	var act_remove_product_Failure = function(result){
		YAHOO.example.container.wait.hide();
	}

	var act_remove_product_callback ={
		success:act_remove_product_Success,
		failure:act_remove_product_Failure,
		timeout : 10000,
		argument: {}
	};
//将商品从购物车中删除--end

//购买数量的改变-begin
	function quantity_change(act,product_id){
		var temp_quantity = document.getElementById('quantity_'+product_id).value;
		if(act == "+"){
			temp_quantity++;
			act_quantity_change(product_id,temp_quantity);
		}else if(act == '-'){
			if(temp_quantity>1){
				temp_quantity--;
				act_quantity_change(product_id,temp_quantity);
			}
		}
	}
	
	function act_quantity_change(product_id,quantity){
		YAHOO.example.container.wait.show();
		
		var postData ="product_id="+product_id+"&quantity="+quantity;
		var sUrl = "/carts/act_quantity_change/";
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, act_quantity_change_callback,postData);
	}

	var act_quantity_change_Success = function(o){
			try{   
				var result = YAHOO.lang.JSON.parse(o.responseText);   
			}catch (e){
				alert(o.responseText);
				alert("Invalid data");
				YAHOO.example.container.wait.hide();
			} 
			
			if(result.type == "0"){
				document.getElementById('my_cart').innerHTML = result.message;
			}else{
			
				document.getElementById('message_content').innerHTML = result.message;
				YAHOO.example.container.message.show();
			}
		
		
		YAHOO.example.container.wait.hide();
		
		}

	var act_quantity_change_Failure = function(result){
		YAHOO.example.container.wait.hide();
	}

	var act_quantity_change_callback ={
		success:act_quantity_change_Success,
		failure:act_quantity_change_Failure,
		timeout : 10000,
		argument: {}
	};

//购买数量的改变-end	}

	function show_regions(str){
		var sUrl = "/regions/choice/";
		var postData ="str="+str;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, show_regions_callback,postData);
	}

	var show_regions_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		if(result.type == "0"){
			document.getElementById('regions').innerHTML = result.message;
		}else{
		
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var show_regions_Failure = function(result){
		alert("error");
	}

	var show_regions_callback ={
		success:show_regions_Success,
		failure:show_regions_Failure,
		timeout : 10000,
		argument: {}
	};
	
	function reload_regions(){
		var i=0;
		var str="";
		while(true){
			if(document.getElementById('AddressRegion'+i)==null){
				break;
			}
			str +=document.getElementById('AddressRegion'+i).value + " ";
			i++;
 		}
 //		alert(str);
        	show_regions(str);
		
	}
	
	function checkout_new_address(){
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
 		Address.regions =Region;
 		Address.name =document.getElementById('AddressName').value;
 		Address.consignee =document.getElementById('AddressConsignee').value;
 		Address.address =document.getElementById('AddressAddress').value;
 		Address.mobile =document.getElementById('AddressMobile').value;
 		Address.sign_building =document.getElementById('AddressSignBuilding').value;
 		Address.telephone =document.getElementById('AddressTelephone').value;
 		Address.zipcode =document.getElementById('AddressZipcode').value;
 		Address.email =document.getElementById('AddressEmail').value;
 		Address.best_time =document.getElementById('AddressBestTime').value;
 		
 		var sUrl = "/user/addresses/checkout_address_add/";
		var postData ="address="+ YAHOO.lang.JSON.stringify(Address);
	//	alert(postData);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, checkout_new_address_callback,postData);
	}

	var checkout_new_address_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		YAHOO.example.container.wait.hide();
		if(result.type == "0"){
			confirm_address(result.id);
		//	alert('a');
		//	document.getElementById('checkout_address').innerHTML = result.message;
		}else{
		
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var checkout_new_address_Failure = function(result){
		alert("error");
	}

	var checkout_new_address_callback ={
		success:checkout_new_address_Success,
		failure:checkout_new_address_Failure,
		timeout : 10000,
		argument: {}
	};
	
	function confirm_address(address_id){
		YAHOO.example.container.wait.show();
 		var sUrl = "/carts/confirm_address/";
		var postData ="address_id="+ address_id;
//		alert(postData);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_address_callback,postData);
	}

	var confirm_address_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		YAHOO.example.container.wait.hide();
		if(result.type == "0"){
			document.getElementById('checkout_address').innerHTML = result.message;
		}else{
		
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var confirm_address_Failure = function(result){
		alert("error");
	}

	var confirm_address_callback ={
		success:confirm_address_Success,
		failure:confirm_address_Failure,
		timeout : 10000,
		argument: {}
	};
	
	function confirm_shipping(shipping_id,shipping_fee,shipping_name){
		YAHOO.example.container.wait.show();
 		var sUrl = "/carts/confirm_shipping/";
		var postData ="shipping_id="+ shipping_id + "&shipping_fee="+shipping_fee+ "&shipping_name="+shipping_name;
//		alert(postData);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_shipping_callback,postData);
	}

	var confirm_shipping_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		YAHOO.example.container.wait.hide();
		if(result.type == "0"){
			document.getElementById('checkout_shipping').innerHTML = result.checkout_shipping;
			document.getElementById('checkout_total').innerHTML = result.checkout_total;
		}else{
		
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var confirm_shipping_Failure = function(result){
		alert("error");
	}

	var confirm_shipping_callback ={
		success:confirm_shipping_Success,
		failure:confirm_shipping_Failure,
		timeout : 10000,
		argument: {}
	};
//编辑地址---------add--liying
	function edit_regions(AddressId,str){
		var sUrl = "/regions/choice/";
		var postData ="str="+str+"&address_id="+AddressId;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, edit_regions_callback,postData);
	}

	var edit_regions_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
			regions_edit="regions_edit"+result.address_id;
		if(result.type == "0"){
			document.getElementById(regions_edit).innerHTML = result.message;
		}else{
		
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var edit_regions_Failure = function(result){
		alert("error");
	}

	var edit_regions_callback ={
		success:edit_regions_Success,
		failure:edit_regions_Failure,
		timeout : 10000,
		argument: {}
	};
	
		function reload_edit_regions(addressId){
		var i=0;
		var str="";
		while(true){
			if(document.getElementById('AddressRegion'+i+addressId)==null){
				break;
			}
			str +=document.getElementById('AddressRegion'+i+addressId).value + " ";
			i++;
 		}
 //		alert(str);
        	edit_regions(addressId,str);
		
	}