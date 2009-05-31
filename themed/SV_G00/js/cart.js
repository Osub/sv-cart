//已修正开始
function to_checkout(){
		document.forms['cart_info'].submit();
}
//将购物车页的促销商品添加到购物车--begin
	function buy_on_cart_page(type,id){

		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"carts/buy_now/";
		var postData ="id="+id+"&quantity="+1+"&page=cart&type="+type;
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
			if(result.is_refresh == "1"){
				window.location.reload(); 
			}
			if(result.buy_type != 'product'){
			document.getElementById('message_content').innerHTML = result.note;
			YAHOO.example.container.message.show();
			}
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
		if(result.is_refresh == "0"){
		YAHOO.example.container.wait.hide();
		}
	}

	var buy_on_cart_page_callback ={
		success:buy_on_cart_page_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};

//显示从购物车中删除商品的确认框--begin
	function remove_product(type,product_id){
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"carts/remove/";
		var postData ="product_id="+product_id+"&type="+type;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, remove_product_callback,postData);
	}

	var remove_product_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");   
			YAHOO.example.container.wait.hide();
		} 
		if(enable_one_step_buy == "1"){
			window.location.href= webroot_dir+"carts/checkout";
			return;
		}
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.message.show();	
		YAHOO.example.container.wait.hide();
	}

	var remove_product_callback ={
		success:remove_product_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
//显示从购物车中删除商品的确认框--end

//将商品从购物车中删除--begin
	function act_remove_product(type,product_id){
		YAHOO.example.container.message.hide();	
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"carts/act_remove/";
		var postData ="product_id="+product_id+"&type="+type;
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
			if(result.no_product == "0" || result.is_refresh == "1"){
				window.location.reload(); 
			}else{
			document.getElementById('my_cart').innerHTML = result.message;
			}
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
		if(result.no_product != "0"){
			YAHOO.example.container.wait.hide();
		}
	}
	
	var act_remove_product_callback ={
		success:act_remove_product_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
//将商品从购物车中删除--end

//购买数量的改变-begin
	function quantity_change(type,act,product_id){
		var temp_quantity = document.getElementById('quantity_'+product_id).value;
		if(act == "+"){
			temp_quantity++;
			act_quantity_change(type,product_id,temp_quantity);
		}else if(act == '-'){
			if(temp_quantity>1){
				temp_quantity--;
				act_quantity_change(type,product_id,temp_quantity);
			}
		}
	}
	
	function act_quantity_change(type,product_id,quantity){
		YAHOO.example.container.wait.show();
		
		var postData ="product_id="+product_id+"&quantity="+quantity+"&type="+type;
		//alert(postData);
		var sUrl = webroot_dir+"carts/act_quantity_change/";
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

	var act_quantity_change_callback ={
		success:act_quantity_change_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};

//购买数量的改变-end

	function show_regions(str){
		var sUrl = webroot_dir+"regions/choice/";
		var postData ="str="+str;
		document.getElementById('add_region_loading').style.display = "";
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
		document.getElementById('add_region_loading').style.display = "none";
		if(result.type == "0"){
			document.getElementById('regions').innerHTML = result.message;
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
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
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"carts/edit_address/";
		var postData = "id="+id;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, show_address_edit_callback,postData);
	}
	
	var show_address_edit_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
			alert(o.responseText);
			YAHOO.example.container.wait.hide();
		}
		document.getElementById('message_width_content').innerHTML = result.message;
		YAHOO.example.container.message_width.show();
		var str= result.str;
		/* 纯虚拟商品不需要详细地址 */
		if(result.all_virtual=="0"){
		show_regions("");
		show_two_regions(str);
		}
		YAHOO.example.container.wait.hide();
	}
	
	var show_address_edit_callback ={
		success:show_address_edit_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function edit_address_act(){
		YAHOO.example.container.wait.show();
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
 		Address.zipcode =document.getElementById('EditAddressZipcode').value;
 		Address.email =document.getElementById('EditAddressEmail').value;
 		Address.best_time =document.getElementById('EditAddressBestTime').value;
 		
 		document.getElementById('edit_address_name').innerHTML = "*";
		document.getElementById('edit_address_consignee').innerHTML = "*";
		document.getElementById('edit_address_mobile').innerHTML = "*";
		document.getElementById('edit_address_telephone').innerHTML = "*";
		document.getElementById('edit_address_email').innerHTML = "*";
		document.getElementById('edit_address_regions').innerHTML = "*";
		document.getElementById('edit_address_address').innerHTML = "*";
		document.getElementById('edit_address_zipcode').innerHTML = "*";
 		var tel_0 =document.getElementById('tel_0').value;
 		var tel_1 =document.getElementById('tel_1').value;
 		var tel_2 =document.getElementById('tel_2').value;
 		Address.telephone = tel_0+"-"+tel_1
 		if(tel_2 != ""){
 		Address.telephone +="-"+tel_2;
		}

 		//判断输入的内容
 		 var regions_arr = Address.regions.split(" ");
 		 var msg = new Array();
  		 var err = false;
  		 
  		 
  		 if (Address.name == "")
		  {
		    document.getElementById('edit_address_name').innerHTML = address_label_not_empty;
		    err = true;
		  }else if (Address.consignee == "")
		  {
			document.getElementById('edit_address_consignee').innerHTML = consignee_name_not_empty;
		    err = true;
		  }else if (Address.mobile == "" && (tel_0 == "" || tel_1 == ""))
		  {
		  	document.getElementById('edit_address_telephone').innerHTML = telephone_or_mobile;
			//document.getElementById('edit_address_mobile').innerHTML = mobile_phone_not_empty;
		    err = true;
		  }else
		 /* else if (tel_0 == "" || tel_1 == "")
		  {
			//document.getElementById('edit_address_telephone').innerHTML = tel_number_not_empty;
		    err = true;
		  }	else 
		  */if (isEmail(Address.email))
		  {
			document.getElementById('edit_address_email').innerHTML = invalid_email;
		    err = true;
		  }else if(regions_arr[2] == "")
  		 {
		document.getElementById('edit_address_regions').innerHTML = choose_area;
		    err = true;
  		 }else if(regions_arr[2] == please_choose){
		document.getElementById('edit_address_regions').innerHTML = choose_area;
		    	err = true;
  		 }else if(Address.regions == please_choose){
		document.getElementById('edit_address_regions').innerHTML = choose_area;
		    	err = true;  		 	
  		 }else if(Address.regions == ""){
		document.getElementById('edit_address_regions').innerHTML = choose_area;
		    err = true;  		 	
  		 }else if(regions_arr[0] == please_choose){
		document.getElementById('edit_address_regions').innerHTML = choose_area;
  		 	 err = true;  
  		 }else if (Address.address == "")
		  {
		    document.getElementById('edit_address_address').innerHTML = address_detail_not_empty;
		    err = true;
		  }else if(Address.address.length < 8){
		    document.getElementById('edit_address_address').innerHTML = not_less_eight_characters;
		    err = true;		  	  
		  }else if (Address.zipcode == "")
		  {
			document.getElementById('edit_address_zipcode').innerHTML = zip_code_not_empty;
		    err = true;
		  }

 		  if (err)
		  {
		  //  message = msg.join("\n");
		  //  alert(message);
		    YAHOO.example.container.wait.hide();
		    return;
		  }
 		
 		var sUrl = webroot_dir+"carts/edit_address_act/";
		var postData ="address="+ YAHOO.lang.JSON.stringify(Address);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, edit_address_act_callback,postData);
	}
	
	var edit_address_act_callback_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		//	YAHOO.example.container.wait.hide();
			YAHOO.example.container.message_width.hide();	
		if(result.type == "0"){
			if(document.getElementById('checkout_total') != null){
			document.getElementById('checkout_total').innerHTML = result.checkout_total;
			}
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
	function edit_virtual_address_act(){
		YAHOO.example.container.wait.show();

		var Address = new Object();
 		Address.id =document.getElementById('EditAddressId').value;
 		Address.name =document.getElementById('EditAddressName').value;
 		Address.consignee =document.getElementById('EditAddressConsignee').value;
 		Address.mobile =document.getElementById('EditAddressMobile').value;
 		Address.email =document.getElementById('EditAddressEmail').value;
 		
 		document.getElementById('edit_address_name').innerHTML = "*";
		document.getElementById('edit_address_consignee').innerHTML = "*";
		document.getElementById('edit_address_mobile').innerHTML = "*";
		document.getElementById('edit_address_telephone').innerHTML = "*";
		document.getElementById('edit_address_email').innerHTML = "*";

 		var tel_0 =document.getElementById('tel_0').value;
 		var tel_1 =document.getElementById('tel_1').value;
 		var tel_2 =document.getElementById('tel_2').value;
 		Address.telephone = tel_0+"-"+tel_1
 		if(tel_2 != ""){
 			Address.telephone +="-"+tel_2;
		}

 		//判断输入的内容
 		 var msg = new Array();
  		 var err = false;
  		 
  		 
  		 if (Address.name == "")
		  {
		    document.getElementById('edit_address_name').innerHTML = address_label_not_empty;
		    err = true;
		  }else if (Address.consignee == "")
		  {
			document.getElementById('edit_address_consignee').innerHTML = consignee_name_not_empty;
		    err = true;
		  }else if (Address.mobile == "" && (tel_0 == "" || tel_1 == ""))
		  {
			document.getElementById('edit_address_mobile').innerHTML = telephone_or_mobile;
		    err = true;
		  }else  if (isEmail(Address.email))
		  {
			document.getElementById('edit_address_email').innerHTML = invalid_email;
		    err = true;
		  }	
		  	  	  
  		  if (err)
		  {
		    YAHOO.example.container.wait.hide();
		    return;
		  }
 		
 		var sUrl = webroot_dir+"carts/edit_address_act/";
		var postData ="address="+ YAHOO.lang.JSON.stringify(Address);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, edit_virtual_address_act_callback,postData);
	}

	
	var edit_virtual_address_act_callback_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
			//YAHOO.example.container.wait.hide();
			YAHOO.example.container.message_width.hide();	
		if(result.type == "0"){
			if(document.getElementById('checkout_total') != null){
			document.getElementById('checkout_total').innerHTML = result.checkout_total;
			}
			confirm_address(result.id);
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var edit_virtual_address_act_callback ={
		success:edit_virtual_address_act_callback_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
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
 		//Address.telephone =document.getElementById('AddressTelephone').value;
 		Address.zipcode =document.getElementById('AddressZipcode').value;
 		Address.email =document.getElementById('AddressEmail').value;
 		Address.best_time =document.getElementById('AddressBestTime').value;
 		var tel_0 =document.getElementById('add_tel_0').value;
 		var tel_1 =document.getElementById('add_tel_1').value;
 		var tel_2 =document.getElementById('add_tel_2').value;
 		Address.telephone = tel_0+"-"+tel_1
 		if(tel_2 != ""){
 		Address.telephone +="-"+tel_2;
		}
 		document.getElementById('add_address_name').innerHTML = "*";
		document.getElementById('add_address_consignee').innerHTML = "*";
		document.getElementById('add_address_mobile').innerHTML = "*";
		document.getElementById('add_address_telephone').innerHTML = "*";
		document.getElementById('add_address_email').innerHTML = "*";
		document.getElementById('add_address_regions').innerHTML = "*";
		document.getElementById('add_address_address').innerHTML = "*";
		document.getElementById('add_address_zipcode').innerHTML = "*";
		
 		var regions_arr = Address.regions.split(" ");
 		var msg = new Array();
  		var err = false;



 		 if (Address.name == "")
		  {
		    document.getElementById('add_address_name').innerHTML = address_label_not_empty;
		    err = true;
		 }else if (Address.consignee == "")
		  {
			document.getElementById('add_address_consignee').innerHTML = consignee_name_not_empty;
		    err = true;
		  }else if (Address.mobile == "" && (tel_0 == "" || tel_1 == ""))
		  {
			document.getElementById('add_address_mobile').innerHTML = telephone_or_mobile;
		    err = true;
		  }else if (isEmail(Address.email))
		  {
		    msg.push(invalid_email);
			document.getElementById('add_address_email').innerHTML = invalid_email;
		    err = true;
		  }else if(regions_arr[2] == "")
  		 {
		document.getElementById('add_address_regions').innerHTML = choose_area;
		    err = true;
  		 }else if(regions_arr[2] == please_choose){
		document.getElementById('add_address_regions').innerHTML = choose_area;
		    	err = true;
  		 }else if(Address.regions == please_choose+" "){
		document.getElementById('add_address_regions').innerHTML = choose_area;
		    	err = true;  		 	
  		 }else if(Address.regions == ""){
		document.getElementById('add_address_regions').innerHTML = choose_area;
		    err = true;  		 	
  		 }else if(regions_arr[0] == please_choose){
		document.getElementById('add_address_regions').innerHTML = choose_area;
  		 	 err = true;  
  		 }else if (Address.address == "")
		  {
		    document.getElementById('add_address_address').innerHTML = address_detail_not_empty;
		    err = true;
		  }else if(Address.address.length < 8){
		    document.getElementById('add_address_address').innerHTML = not_less_eight_characters;
		    err = true;		  	  
		  }else if (Address.zipcode == "")
		  {
			document.getElementById('add_address_zipcode').innerHTML = zip_code_not_empty;
		    err = true;
		  }

 		  if (err)
		  {
		    YAHOO.example.container.wait.hide();
		    return;
		  }
 		var sUrl = webroot_dir+"carts/checkout_address_add/";
		var postData ="address="+ YAHOO.lang.JSON.stringify(Address);
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
		
		//YAHOO.example.container.wait.hide();
		YAHOO.example.container.message_width.hide();	
		if(result.type == "0"){
			if(document.getElementById('checkout_total') != null){
			document.getElementById('checkout_total').innerHTML = result.checkout_total;
			}
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
	
	function checkout_new_virtual_address(){

 		var Address = new Object();
 		Address.name =document.getElementById('AddressName').value;
 		Address.consignee =document.getElementById('AddressConsignee').value;
 		Address.mobile =document.getElementById('AddressMobile').value;
 		Address.email =document.getElementById('AddressEmail').value;
 		var tel_0 =document.getElementById('add_tel_0').value;
 		var tel_1 =document.getElementById('add_tel_1').value;
 		var tel_2 =document.getElementById('add_tel_2').value;
 		Address.telephone = tel_0+"-"+tel_1
 		if(tel_2 != ""){
 			Address.telephone +="-"+tel_2;
		}
 		document.getElementById('add_address_name').innerHTML = "*";
		document.getElementById('add_address_consignee').innerHTML = "*";
		document.getElementById('add_address_mobile').innerHTML = "*";
		document.getElementById('add_address_telephone').innerHTML = "*";
		document.getElementById('add_address_email').innerHTML = "*";
		
 		var msg = new Array();
  		var err = false;
	 if (Address.name == "")
	  {
	    document.getElementById('add_address_name').innerHTML = address_label_not_empty;
	    err = true;
	 }else if (Address.consignee == "")
	  {
		document.getElementById('add_address_consignee').innerHTML = consignee_name_not_empty;
	    err = true;
	  }else if (Address.mobile == "")
	  {
		document.getElementById('add_address_mobile').innerHTML = mobile_phone_not_empty;
	    err = true;
	  }else if (tel_0 == "" || tel_1 == "")
	  {
		document.getElementById('add_address_telephone').innerHTML = tel_number_not_empty;
	    err = true;
	  }else if (isEmail(Address.email))
	  {
	    msg.push(invalid_email);
		document.getElementById('add_address_email').innerHTML = invalid_email;
	    err = true;
	  }

	  if (err)
	  {
	    YAHOO.example.container.wait.hide();
	    return;
	  }
	  var sUrl = webroot_dir+"carts/checkout_address_add/";
      var postData ="address="+ YAHOO.lang.JSON.stringify(Address);
	  var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, checkout_new_virtual_address_callback,postData);
	}
	
	var checkout_new_virtual_address_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		//YAHOO.example.container.wait.hide();
		YAHOO.example.container.message_width.hide();	
		if(result.type == "0"){
			if(document.getElementById('checkout_total') != null){
			document.getElementById('checkout_total').innerHTML = result.checkout_total;
			}
			//alert(result.id);
			confirm_address(result.id);
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var checkout_new_virtual_address_callback ={
		success:checkout_new_virtual_address_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function confirm_address(address_id){
		YAHOO.example.container.wait.show();
 		var sUrl = webroot_dir+"carts/confirm_address/";
		var postData ="address_id="+ address_id;
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
		
	//	YAHOO.example.container.wait.hide();
		if(result.type == "0"){
			document.getElementById('checkout_address').innerHTML = result.address;
			//document.getElementById('checkout_shipping').innerHTML = result.shipping;
			change_shipping();
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
	
	function confirm_shipping_insure(shipping_id,shipping_fee,free_subtotal,support_cod,insure_fee){
		if(insure_fee >0){
    		layer_dialog_show(support_value_or_not,"",3,shipping_id,shipping_fee,free_subtotal,support_cod,insure_fee);
			return;
		}
		confirm_shipping(shipping_id,shipping_fee,free_subtotal,support_cod,insure_fee);
	}

	function confirm_shipping_fee(shipping_id,shipping_fee,free_subtotal,support_cod,insure_fee){
		layer_dialog_obj.hide();
		confirm_shipping(shipping_id,shipping_fee,free_subtotal,support_cod,insure_fee);
	}
		
	function confirm_shipping(shipping_id,shipping_fee,free_subtotal,support_cod,insure_fee){
		YAHOO.example.container.wait.show();
 		var sUrl = webroot_dir+"carts/confirm_shipping/";
		var postData ="shipping_id="+ shipping_id + "&shipping_fee="+shipping_fee+"&free_subtotal="+free_subtotal+"&support_cod="+support_cod+"&insure_fee="+insure_fee;
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
			if(document.getElementById('checkout_total') != null){
			document.getElementById('checkout_total').innerHTML = result.checkout_total;
			}
		}else{
		
			document.getElementById('message_content').innerHTML = result.checkout_shipping;
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
		var sUrl = webroot_dir+"regions/choice/";
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
	function confirm_payment(payment_id){
		YAHOO.example.container.wait.show();
 		var sUrl = webroot_dir+"carts/confirm_payment/";
		var postData ="payment_id="+ payment_id ;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_payment_callback,postData);
	}

	var confirm_payment_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		YAHOO.example.container.wait.hide();
		if(result.type == "0"){
			document.getElementById('payment').innerHTML = result.checkout_payment;
			if(document.getElementById('checkout_total') != null){
			document.getElementById('checkout_total').innerHTML = result.checkout_total;
			}
		}else{
			document.getElementById('message_content').innerHTML = result.checkout_payment;
			YAHOO.example.container.message.show();
		}
	}

	var confirm_payment_callback ={
		success:confirm_payment_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function show_two_regions(str){
		document.getElementById('update_region_loading').style.display = "";
		var sUrl = webroot_dir+"regions/twochoice/";
		var postData ="str="+str;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, show_two_regions_callback,postData);
	}

	var show_two_regions_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		document.getElementById('update_region_loading').style.display = "none";
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
		var sUrl = webroot_dir+"regions/twochoice/";
		var postData ="str="+str+"&updateaddress_id="+AddressId;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, edit_two_regions_callback,postData);
	}

	var edit_two_regions_Success = function(o){
		try{
			alert(o.responseText);
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
	
	function change_shipping(){
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"carts/change_shipping/";
		var postData ="";
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, change_shipping_callback,postData);
	}
	
	var change_shipping_Success = function(o){
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
			if(document.getElementById('checkout_total') != null){
			document.getElementById('checkout_total').innerHTML = result.checkout_total;
			}
		}else{
			document.getElementById('message_content').innerHTML = result.checkout_shipping;
			YAHOO.example.container.message.show();
		}
	}
	
	var change_shipping_callback ={
		success:change_shipping_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function change_payment(){
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"carts/change_payment/";
		var postData ="";
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, change_payment_callback,postData);
	}
	
	var change_payment_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		YAHOO.example.container.wait.hide();
		if(result.type == "0" || result.type == "1"){
			document.getElementById('payment').innerHTML = result.checkout_payment;
			if(document.getElementById('checkout_total') != null){
			document.getElementById('checkout_total').innerHTML = result.checkout_total;
			}
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}
	
	var change_payment_callback ={
		success:change_payment_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function add_note(type,id){
		YAHOO.example.container.wait.show();
		var note = document.getElementById('note').value;
		var sUrl = webroot_dir+"carts/add_note/";
		var postData ="note="+note+"&type="+type+"&id="+id;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, add_note_callback,postData);
	}

	var add_note_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		YAHOO.example.container.wait.hide();
		YAHOO.example.container.message.hide();
		if(result.type == "0" || result.type == "1"){
		
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}
	
	var add_note_callback ={
		success:add_note_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	function select_address(){
		YAHOO.example.container.wait.show();
		note = document.getElementById('note').value;
		var sUrl = webroot_dir+"carts/select_address/";
		var postData ="";
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, select_address_callback,postData);
	}

	var select_address_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		if(result.type == "0" || result.type == "1"){
		
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}
	
	var select_address_callback ={
		success:select_address_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	//选促销活动
function confirm_promotion(type,id,type_ext,title,meta_description){
        YAHOO.example.container.wait.show();
        var sUrl = webroot_dir+"carts/confirm_promotion/";
        var postData ="id="+id+"&type="+type+"&type_ext="+type_ext+"&title="+title+"&meta_description="+meta_description;
        var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_promotion_callback,postData);
    }

    var confirm_promotion_Success = function(o){
        try{  
            var result = YAHOO.lang.JSON.parse(o.responseText);
        }catch (e){  
            alert(o.responseText);
            alert("Invalid data");
            YAHOO.example.container.wait.hide();
        }
       
        YAHOO.example.container.wait.hide();
        if(result.type == "0" || result.type == "1"){
            document.getElementById('promotions').innerHTML = result.checkout_promotion_confirm;
			if(document.getElementById('checkout_total') != null){
            document.getElementById('checkout_total').innerHTML = result.checkout_total;
            }
        }else{
            document.getElementById('message_content').innerHTML = result.checkout_promotion_confirm;
            YAHOO.example.container.message.show();
        }
    }
   
    var confirm_promotion_callback ={
        success:confirm_promotion_Success,
        failure:failure_todo,
        timeout : 30000,
        argument: {}
    };
   
    //重选销活动
    function change_promotion(){
        YAHOO.example.container.wait.show();
        var sUrl = webroot_dir+"carts/change_promotion/";
        var postData ="";
        var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, change_promotion_callback,postData);
    }
   
    var change_promotion_Success = function(o){
        try{  
            var result = YAHOO.lang.JSON.parse(o.responseText);
        }catch (e){  
            alert(o.responseText);
            alert("Invalid data");
            YAHOO.example.container.wait.hide();
        }
       
        YAHOO.example.container.wait.hide();
        if(result.type == "0" || result.type == "1"){
			document.getElementById('promotions').innerHTML = result.checkout_promotion;
			if(document.getElementById('checkout_total') != null){
            document.getElementById('checkout_total').innerHTML = result.checkout_total;
            }
            /* 判断是否需要显示配送方式 */
            if(result.shipping_display == '1'){
            	document.getElementById('address_btn_list').style.display = "block";
            	document.getElementById('checkout_shipping').style.display = "block";
            }else {
            	document.getElementById('address_btn_list').style.display = "none";
            	document.getElementById('checkout_shipping').style.display = "none";
            }
            close_message();
        }else if(result.type == "3"){
            YAHOO.example.container.wait.hide();
        }else{
            document.getElementById('message_content').innerHTML = result.message;
            YAHOO.example.container.message.show();
        }
    }
   
    var change_promotion_callback ={
        success:change_promotion_Success,
        failure:failure_todo,
        timeout : 30000,
        argument: {}
    };
    
    //重选地址
    function change_address(){
        YAHOO.example.container.wait.show();
        var sUrl = webroot_dir+"carts/change_address/";
        var postData ="";
        var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, change_address_callback,postData);
    }
   
    var change_address_Success = function(o){
        try{
           var result = YAHOO.lang.JSON.parse(o.responseText);
        }catch (e){  
            alert(o.responseText);
            alert("Invalid data");
            YAHOO.example.container.wait.hide();
        }
       
        if(result.type == "0" || result.type == "1"){
            document.getElementById('checkout_shipping').innerHTML = result.checkout_shipping;
            document.getElementById('checkout_address').innerHTML = result.checkout_address;
          //  change_shipping();
			if(document.getElementById('checkout_total') != null){
            document.getElementById('checkout_total').innerHTML = result.checkout_total;
            }
        }else if(result.type == "3"){
        	
        }else{
            document.getElementById('message_content').innerHTML = result.message;
            YAHOO.example.container.message.show();
        }
        YAHOO.example.container.wait.hide();

    }
   
    var change_address_callback ={
        success:change_address_Success,
        failure:failure_todo,
        timeout : 30000,
        argument: {}
    };
    
    //选择结算的促销商品
    function add_promotion_product(promotion_id,product_id,now_fee,product_name){
        YAHOO.example.container.wait.show();
        var sUrl = webroot_dir+"carts/add_promotion_product/";
        var postData ="promotion_id="+promotion_id+"&product_id="+product_id+"&now_fee="+now_fee+"&product_name="+product_name;
        var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, add_promotion_product_callback,postData);
    }
    var add_promotion_product_Success = function(o){
        try{
           var result = YAHOO.lang.JSON.parse(o.responseText);
        }catch (e){  
            alert(o.responseText);
            alert("Invalid data");
            YAHOO.example.container.wait.hide();
        }
        YAHOO.example.container.wait.hide();
        if(result.type == "0" ){
			document.getElementById('promotions').innerHTML = result.checkout_promotion_confirm;
			if(document.getElementById('checkout_total') != null){
            document.getElementById('checkout_total').innerHTML = result.checkout_total;
            }
            /* 判断是否需要显示配送方式 */
            if(result.shipping_display == '1'){
            	if(document.getElementById('address_btn_list') != null){
	            	if(document.getElementById('checkout_shipping').style.display == "none"){
		            	change_address();
		            	document.getElementById('address_btn_list').style.display = "block";
		            	document.getElementById('checkout_shipping').style.display = "block";
	            	}
				}
            }else {
            	if(document.getElementById('address_btn_list') != null){
            	document.getElementById('address_btn_list').style.display = "none";
            	}
            	if(document.getElementById('address_btn_list') != null){
            	document.getElementById('checkout_shipping').style.display = "none";
            	}
            }
            	
        //  close_message();
        }else{
            document.getElementById('message_content').innerHTML = result.checkout_promotion_confirm;
            YAHOO.example.container.message.show();
        }
    }
   
    var add_promotion_product_callback ={
        success:add_promotion_product_Success,
        failure:failure_todo,
        timeout : 30000,
        argument: {}
    };
    
    function usepoint(max,order){
    	
    	document.getElementById('point_error_msg').innerHTML = "";
    	
		var point = document.getElementById('use_point').value;
		if(point > max){
			document.getElementById('point_error_msg').innerHTML = exceed_max_value_can_use;
			return;
		}
	    if(point > order){
			document.getElementById('point_error_msg').innerHTML = exceed_max_value_can_use;
			return;
		}
	   if(point == ""){
			document.getElementById('point_error_msg').innerHTML = point_not_empty;
			return;
		}	
		if(point <1 ){
		//	document.getElementById('point_error_msg').innerHTML = point_not_empty;
			return;
		}		
		
        YAHOO.example.container.wait.show();
        var sUrl = webroot_dir+"carts/usepoint/";
        var postData ="point="+point;
        var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, usepoint_callback,postData);
    }
   
    var usepoint_Success = function(o){
        try{
           var result = YAHOO.lang.JSON.parse(o.responseText);
        }catch (e){  
            alert(o.responseText);
            alert("Invalid data");
            YAHOO.example.container.wait.hide();
        }
       
        YAHOO.example.container.wait.hide();
        if(result.type == "0" ){
			document.getElementById('point').innerHTML = result.checkout_point;
			if(document.getElementById('checkout_total') != null){
            document.getElementById('checkout_total').innerHTML = result.checkout_total;
            }
        }else{
            document.getElementById('message_content').innerHTML = result.checkout_point;
            YAHOO.example.container.message.show();
        }
    }
   
    var usepoint_callback ={
        success:usepoint_Success,
        failure:failure_todo,
        timeout : 30000,
        argument: {}
    };

	function change_point(){
		YAHOO.example.container.wait.show();
        var sUrl = webroot_dir+"carts/change_point/";
        var postData = "";
        var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, change_point_callback,postData);
	}
	var change_point_Success = function(o){
        try{
           var result = YAHOO.lang.JSON.parse(o.responseText);
        }catch (e){  
            alert(o.responseText);
            alert("Invalid data");
            YAHOO.example.container.wait.hide();
        }
       
        YAHOO.example.container.wait.hide();
        if(result.type == "0" ){
			document.getElementById('point').innerHTML = result.checkout_point;
			if(document.getElementById('checkout_total') != null){
            document.getElementById('checkout_total').innerHTML = result.checkout_total;
            }
        }else{
            document.getElementById('message_content').innerHTML = result.checkout_point;
            YAHOO.example.container.message.show();
        }
    }
   
    var change_point_callback ={
        success:change_point_Success,
        failure:failure_todo,
        timeout : 30000,
        argument: {}
    };
    
    function checkout_order(){
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"carts/checkout_order/";
		var postData ="";				
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, checkout_order_callback,postData);
	}

	var checkout_order_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
		if(result.type > 0){
		document.getElementById('message_content').innerHTML = result.message;
		YAHOO.example.container.wait.hide();
		YAHOO.example.container.message.show();
		}else{ 
		  document.forms['cart_info'].submit(); 
		}
	}

	var checkout_order_callback ={
		success:checkout_order_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	function del_cart_product(){
	    YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"carts/del_cart_product/";
		var postData ="";
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, del_cart_product_callback,postData);
	}
	
	var del_cart_product_Success = function(o){
/*        try{
           var result = YAHOO.lang.JSON.parse(o.responseText);
        }catch (e){  
            alert(o.responseText);
            alert("Invalid data");
            YAHOO.example.container.wait.hide();
        }*/
        location.reload();

    }
   
    var del_cart_product_callback ={
        success:del_cart_product_Success,
        failure:failure_todo,
        timeout : 30000,
        argument: {}
    };
    
    function usecoupon(){
		document.getElementById('coupon_error_msg').innerHTML = "";
		var coupon = document.getElementById('use_coupon').value;
		if(coupon == ""){
			document.getElementById('coupon_error_msg').innerHTML = coupon_phone_not_empty;
			return;
		}
        YAHOO.example.container.wait.show();
        var sUrl = webroot_dir+"carts/usecoupon/";
        var postData ="coupon="+coupon;
        var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, usecoupon_callback,postData);
    }
   
    var usecoupon_Success = function(o){
        try{
           var result = YAHOO.lang.JSON.parse(o.responseText);
        }catch (e){  
            alert(o.responseText);
            alert("Invalid data");
            YAHOO.example.container.wait.hide();
        }
        YAHOO.example.container.wait.hide();
        if(result.type == "0" ){
			document.getElementById('coupon').innerHTML = result.checkout_point;
			if(document.getElementById('checkout_total') != null){
            document.getElementById('checkout_total').innerHTML = result.checkout_total;
            }
        }else{
            document.getElementById('message_content').innerHTML = result.checkout_point;
            YAHOO.example.container.message.show();
        }
    }
   
    var usecoupon_callback ={
        success:usecoupon_Success,
        failure:failure_todo,
        timeout : 30000,
        argument: {}
    };
	
    function selectcoupon(){
		var coupon = document.getElementById('select_coupon').value;
		if(coupon == please_choose){
			return;
		}
        YAHOO.example.container.wait.show();
        var sUrl = webroot_dir+"carts/usecoupon/";
        var postData ="coupon="+coupon+"&is_id=1";
        var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, select_coupon_callback,postData);
    }
   
    var select_coupon_Success = function(o){
        try{
           var result = YAHOO.lang.JSON.parse(o.responseText);
        }catch (e){  
            alert(o.responseText);
            alert("Invalid data");
            YAHOO.example.container.wait.hide();
        }
        YAHOO.example.container.wait.hide();
        if(result.type == "0" ){
			document.getElementById('coupon').innerHTML = result.checkout_point;
			if(document.getElementById('checkout_total') != null){
            document.getElementById('checkout_total').innerHTML = result.checkout_total;
            }
        }else{
            document.getElementById('message_content').innerHTML = result.checkout_point;
            YAHOO.example.container.message.show();
        }
    }
   
    var select_coupon_callback ={
        success:select_coupon_Success,
        failure:failure_todo,
        timeout : 30000,
        argument: {}
    };
    
    
    function change_coupon(){
		YAHOO.example.container.wait.show();
        var sUrl = webroot_dir+"carts/change_coupon/";
        var postData = "";
        var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, change_coupon_callback,postData);
	}
	var change_coupon_Success = function(o){
        try{
           var result = YAHOO.lang.JSON.parse(o.responseText);
        }catch (e){  
            alert(o.responseText);
            alert("Invalid data");
            YAHOO.example.container.wait.hide();
        }
       
        YAHOO.example.container.wait.hide();
        if(result.type == "0" ){
			document.getElementById('coupon').innerHTML = result.checkout_coupon;
			if(document.getElementById('checkout_total') != null){
            document.getElementById('checkout_total').innerHTML = result.checkout_total;
            }
        }else{
            document.getElementById('message_content').innerHTML = result.checkout_coupon;
            YAHOO.example.container.message.show();
        }
    }
   
    var change_coupon_callback ={
        success:change_coupon_Success,
        failure:failure_todo,
        timeout : 30000,
        argument: {}
    };
    
    function add_remark(){
    	document.getElementById('remark_msg').innerHTML = "";
    	var order_note = document.getElementById('order_note_add').value;
    	if(order_note == ""){
		//	document.getElementById('remark_msg').innerHTML = order_note_not_empty;
			return;
    	}
    	
		document.getElementById('change_remark').style.display = "";
		document.getElementById('order_note_value').innerHTML = order_note;
		document.getElementById('order_note_value').style.display = "";
		document.getElementById('order_note_textarea').style.display = "none";
    	/*
		YAHOO.example.container.wait.show();
        var sUrl = webroot_dir+"carts/add_remark/";
        var postData = "order_note="+order_note;
        var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, add_remark_callback,postData);*/
        
        
	}
	
	var add_remark_Success = function(o){
        try{
           var result = YAHOO.lang.JSON.parse(o.responseText);
        }catch (e){  
            alert(o.responseText);
            alert("Invalid data");
            YAHOO.example.container.wait.hide();
        }
        YAHOO.example.container.wait.hide();
        if(result.type == "0" ){
			document.getElementById('order_note').innerHTML = result.checkout_remark;
        }else{
            document.getElementById('message_content').innerHTML = result.checkout_remark;
            YAHOO.example.container.message.show();
        }
    }
   
    var add_remark_callback ={
        success:add_remark_Success,
        failure:failure_todo,
        timeout : 30000,
        argument: {}
    };    
    
    //change_remark
        function change_remark(){
      //  document.getElementById('order_note_value').innerHTML = "<textarea name='order_note' id='order_note_add' class='green_border'style='width:340px;overflow-y:scroll;vertical-align:top' onblur='javascript:add_remark();'></textarea>";
		document.getElementById('change_remark').style.display = "none";
		document.getElementById('order_note_value').style.display = "none";
		document.getElementById('order_note_textarea').style.display = "";
        	/*
		YAHOO.example.container.wait.show();
        var sUrl = webroot_dir+"carts/change_remark/";
        var postData = "";
        var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, change_remark_callback,postData);
        */
	}
	
	var change_remark_Success = function(o){
        try{
           var result = YAHOO.lang.JSON.parse(o.responseText);
        }catch (e){  
            alert(o.responseText);
            alert("Invalid data");
            YAHOO.example.container.wait.hide();
        }
        YAHOO.example.container.wait.hide();
        if(result.type == "0" ){
			document.getElementById('order_note').innerHTML = result.checkout_remark;
        }else{
            document.getElementById('message_content').innerHTML = result.checkout_remark;
            YAHOO.example.container.message.show();
        }
    }
   
    var change_remark_callback ={
        success:change_remark_Success,
        failure:failure_todo,
        timeout : 30000,
        argument: {}
    };
    
    
    // add 09.5.26
    function layer_dialog_show(dialog_content,url_or_function,button_num,shipping_id,shipping_fee,free_subtotal,support_cod,insure_fee){
		layer_dialog();
		document.getElementById('layer_dialog').style.display = "block";
		if(url_or_function!=''){
			document.getElementById('confirm').value = url_or_function;//删除层传URL
		}
		document.getElementById('dialog_content').innerHTML = dialog_content;//对话框中的中文
		var button_replace = document.getElementById('button_replace');
		if(button_num==3){
			button_replace.innerHTML = "<a href='javascript:confirm_shipping_fee("+shipping_id+","+shipping_fee+","+free_subtotal+","+support_cod+",0);' style='padding-right:50px;'>"+cart_cancel+"</a>"+"<a href='javascript:confirm_shipping_fee("+shipping_id+","+shipping_fee+","+free_subtotal+","+support_cod+","+insure_fee+");' style='padding-right:50px;'>"+cart_confirm+"</a>";
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