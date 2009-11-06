	function show_regions(str){
		var sUrl = webroot_dir+"regions/choice/"+str;
		document.getElementById('region_loading').style.display = "";
		var postData ="str="+str;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, show_regions_callback,postData);
	}

	var show_regions_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			//alert(o.responseText);
			//alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		document.getElementById('region_loading').style.display = "none";
		if(result.type == "0"){
			document.getElementById('regions').innerHTML = result.message;
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}
	var failure_todo = function(o){
		alert("error");
	}
	var show_regions_callback ={
		success:show_regions_Success,
		failure:failure_todo,
		timeout : 30000,
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
 		
        show_regions(str);
		
	}
	
	function show_address_edit(id){
		set_wait(wait_message);YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"carts/edit_address/";
		var postData = "id="+id;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, show_address_edit_callback,postData);
	}
	
	var show_address_edit_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			//alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.message.show();	
		var str="";
		show_regions(str);
		show_two_regions(str);
		YAHOO.example.container.wait.hide();
	}
	
	var show_address_edit_callback ={
		success:show_address_edit_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function edit_address_act(){
		set_wait(wait_message);YAHOO.example.container.wait.show();
		var i=0;
		var Region="";
		while(true){
			if(document.getElementById('AddressRegionUpdate'+i)==null){
				break;
			}
			Region +=document.getElementById('AddressRegionUpdate'+i).value + " ";
			i++;
 		}
		var Address = new Object();
 		Address.regions = Region;
 		Address.id =document.getElementById('EditAddressId').value;
 		Address.name =document.getElementById('EditAddressName').value;
 		Address.consignee =document.getElementById('EditAddressConsignee').value;
 		Address.address =document.getElementById('EditAddressAddress').value;
 		Address.mobile =document.getElementById('EditAddressMobile').value;
 		Address.sign_building =document.getElementById('EditAddressSignBuilding').value;
 		Address.telephone =document.getElementById('EditAddressTelephone').value;
 		Address.zipcode =document.getElementById('EditAddressZipcode').value;
 		Address.email =document.getElementById('EditAddressEmail').value;
 		Address.best_time =document.getElementById('EditAddressBestTime').value;
 		var sUrl = webroot_dir+"carts/edit_address_act/";
		var postData ="address="+ YAHOO.lang.JSON.stringify(Address);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, edit_address_act_callback,postData);
	}
	
	var edit_address_act_callback_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
			//alert(o.responseText);
			//alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
			YAHOO.example.container.wait.hide();
			YAHOO.example.container.message.hide();	
		if(result.type == "0"){
			document.getElementById('checkout_total').innerHTML = result.checkout_total;
			confirm_address(result.id);
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var edit_address_act_callback ={
		success:edit_address_act_callback_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
		
	function checkout_new_address(){
		set_wait(wait_message);YAHOO.example.container.wait.show();
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
 		var sUrl = webroot_dir+"carts/checkout_address_add/";
		var postData ="address="+ YAHOO.lang.JSON.stringify(Address);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, checkout_new_address_callback,postData);
	}

	var checkout_new_address_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			//alert(o.responseText);
			//alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		YAHOO.example.container.wait.hide();
		YAHOO.example.container.message.hide();	
		if(result.type == "0"){
			document.getElementById('checkout_total').innerHTML = result.checkout_total;
			confirm_address(result.id);
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var checkout_new_address_callback ={
		success:checkout_new_address_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function confirm_address(address_id){
		set_wait(wait_message);YAHOO.example.container.wait.show();
 		var sUrl = webroot_dir+"carts/confirm_address/";
		var postData ="address_id="+ address_id;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_address_callback,postData);
	}

	var confirm_address_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			//alert(o.responseText);
			//alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		YAHOO.example.container.wait.hide();
		if(result.type == "0"){
			document.getElementById('checkout_address').innerHTML = result.address;
			document.getElementById('checkout_shipping').innerHTML = result.shipping;
			document.getElementById('checkout_shipping_two').innerHTML = result.shipping;
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var confirm_address_callback ={
		success:confirm_address_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function confirm_shipping(shipping_id,shipping_fee,shipping_name){
		set_wait(wait_message);YAHOO.example.container.wait.show();
 		var sUrl = webroot_dir+"carts/confirm_shipping/";
		var postData ="shipping_id="+ shipping_id + "&shipping_fee="+shipping_fee+ "&shipping_name="+shipping_name;
//		alert(postData);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_shipping_callback,postData);
	}

	var confirm_shipping_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
			//alert(o.responseText);
			//alert("Invalid data");
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

	var confirm_shipping_callback ={
		success:confirm_shipping_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
//编辑地址---------add--liying
	function edit_regions(AddressId,str){
		var sUrl = webroot_dir+"regions/choice/"+str+"/"+AddressId;
		var postData ="str="+str+"&address_id="+AddressId;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, edit_regions_callback,postData);
	}

	var edit_regions_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
			//alert(o.responseText);
			//alert("Invalid data");
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

	var edit_regions_callback ={
		success:edit_regions_Success,
		failure:failure_todo,
		timeout : 30000,
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
       	edit_regions(addressId,str);
		
	}
	
//---
	function confirm_payment(payment_id,payment_fee,payment_name){
		set_wait(wait_message);YAHOO.example.container.wait.show();
 		var sUrl = webroot_dir+"carts/confirm_payment/";
		var postData ="payment_id="+ payment_id + "&payment_fee="+payment_fee+"&payment_name="+payment_name;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_payment_callback,postData);
	}

	var confirm_payment_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			//alert(o.responseText);
			//alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		YAHOO.example.container.wait.hide();
		if(result.type == "0"){
			document.getElementById('payment').innerHTML = result.checkout_payment;
			document.getElementById('checkout_total').innerHTML = result.checkout_total;
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var confirm_payment_callback ={
		success:confirm_payment_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
//显示2个地区选者框
	function show_two_regions(str){
		var sUrl = webroot_dir+"regions/twochoice/"+str;
		var postData ="str="+str;
		document.getElementById('region_t_loading').style.display = "";
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, show_two_regions_callback,postData);
	}

	var show_two_regions_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			//alert(o.responseText);
			//alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		document.getElementById('region_t_loading').style.display = "none";
		if(result.type == "0"){
			document.getElementById('regionsupdate').innerHTML = result.message;
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var show_two_regions_callback ={
		success:show_two_regions_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
//
	function reload_edit_two_regions(addressId){
		var i=0;
		var str="";
		while(true){
			if(document.getElementById('AddressRegionUpdate'+i+addressId)==null){
				break;
			}
			str +=document.getElementById('AddressRegionUpdate'+i+addressId).value + " ";
			i++;
 		}
       	edit_two_regions(addressId,str);
	}

//编辑两地址---------
	function edit_two_regions(AddressId,str){
		var sUrl = webroot_dir+"regions/twochoice/"+str+"/"+AddressId;
		var postData ="str="+str+"&updateaddress_id="+AddressId;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, edit_two_regions_callback,postData);
	}

	var edit_two_regions_Success = function(o){
		try{
			//alert(o.responseText);
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
			//alert(o.responseText);
			//alert("Invalid data");
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

	var edit_two_regions_callback ={
		success:edit_two_regions_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};

	function reload_two_regions(){
		var i=0;
		var str="";
		while(true){
			if(document.getElementById('AddressRegionUpdate'+i)==null){
				break;
			}
			str +=document.getElementById('AddressRegionUpdate'+i).value + " ";
			i++;
 		}
        show_two_regions(str);
	}