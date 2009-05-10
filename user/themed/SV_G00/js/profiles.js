	function view_profiles(){
//		YAHOO.example.container.wait.show();
		var User = new Object();
		User.id = document.getElementById('UserId').value;
		User.email = document.getElementById('UserEmail').value;
		User.sex = document.getElementById('UserSex').value;
		User.birthday = document.getElementById('date').value;
		var UserAddress = new Object();
		UserAddress.id = document.getElementById('UserAddressId').value;
		UserAddress.address = document.getElementById('UserAddressAddress').value;
		UserAddress.mobile = document.getElementById('UserAddressMobile').value;
		var tel_0 =  document.getElementById('Utel0').value;
		var tel_1 =  document.getElementById('Utel1').value;
		var tel_2 =  document.getElementById('Utel2').value;
		if(tel_2 == ""){
		UserAddress.telephone = document.getElementById('Utel0').value+"-"+document.getElementById('Utel1').value;
		}else{
		UserAddress.telephone = document.getElementById('Utel0').value+"-"+document.getElementById('Utel1').value+"-"+document.getElementById('Utel2').value;
		}
		//alert(UserAddress.telephone);
		var Region="";
		var i=0;
		while(true){
			if(document.getElementById('AddressRegion'+i)==null){
				break;
			}
			Region +=document.getElementById('AddressRegion'+i).value + " ";
			i++;
 		}
 	//	alert(Region);
 		UserAddress.regions = Region;
 		 var regions_arr = UserAddress.regions.split(" ");
 		 var msg = new Array();
  		 var err = false;
		document.getElementById('user_regions').innerHTML = "*";
		document.getElementById('user_address').innerHTML = "*";
		document.getElementById('user_mobile').innerHTML = "*";
		document.getElementById('user_telephone').innerHTML = "*";
		document.getElementById('user_email').innerHTML = "*";
			
  		 if(regions_arr[2] == "")
  		 {
			document.getElementById('user_regions').innerHTML = choose_area;
		    err = true;
  		 }else if(regions_arr[2] == please_choose){
			document.getElementById('user_regions').innerHTML = choose_area;
		   	err = true;
  		 }else if(UserAddress.regions == please_choose){
			document.getElementById('user_regions').innerHTML = choose_area;
		   	err = true;  		 	
  		 }else if(UserAddress == ""){
			document.getElementById('user_regions').innerHTML = choose_area;
		   	err = true; 
		 } 		
		 if (UserAddress.address == "")
		  {
			document.getElementById('user_address').innerHTML = address_detail_not_empty;
		    err = true;
		  }
		 if (UserAddress.mobile == "")
		  {
			document.getElementById('user_mobile').innerHTML = mobile_phone_not_empty;
		    err = true;
		  }

		  if (tel_0 == "" || tel_1 == "")
		  {
			document.getElementById('user_telephone').innerHTML = tel_number_not_empty;
		    err = true;
		  } 
		  
		  if(isEmail(User.email)){
			document.getElementById('user_email').innerHTML = invalid_email;
		    err = true;
		  }
 		
 		if(err){
 			return;
 		}
		var Info ="";
		var k = 0
		while(true){
			if(document.getElementById('ValueId'+k)==null){
				break;
			}else{
			if(document.getElementById('ValueInfoType'+k).value == "radio"){
				var times = document.getElementById('ValueInfoTimes'+k).value;
				for(var i=0;i< times;i++){
					if(document.getElementById('ValueValue'+k+i).checked){
					Info +=document.getElementById('ValueValue'+k+i).value+" "+document.getElementById('ValueId'+k).value+" "+document.getElementById('ValueInfoId'+k).value+",";
					}
				}
			}else if(document.getElementById('ValueInfoType'+k).value == "checkbox"){
				var times = document.getElementById('ValueInfoTimes'+k).value;
				var str = "";
				for(var i=0;i< times;i++){
					if(document.getElementById('ValueValue'+k+i).checked){
						str += document.getElementById('ValueValue'+k+i).value+";"
					}
				}
			//	alert(str);
				Info +=str+" "+document.getElementById('ValueId'+k).value+" "+document.getElementById('ValueInfoId'+k).value+",";
			}else{
			Info +=document.getElementById('ValueValue'+k).value+" "+document.getElementById('ValueId'+k).value+" "+document.getElementById('ValueInfoId'+k).value+",";
			}
			}
			k++;
 		}
 		//alert(Info);return;
		var sUrl = webroot_dir+"profiles/edit_profiles/";
		var postData ="address="+ YAHOO.lang.JSON.stringify(UserAddress)+"&user="+YAHOO.lang.JSON.stringify(User)+"&info="+Info;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, view_profiles_callback,postData);
		//frm.submit();
    }
    var view_profiles_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		}
		
		YAHOO.example.container.wait.hide();
		if(result.type == "0"){
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}else{
			document.getElementById('message_content').innerHTML = result.message;
			YAHOO.example.container.message.show();
		}
	}

	var view_profiles_callback ={
		success:view_profiles_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};
	
	//取得省市下级-----begin
function show_lower(RegionId,Level,Target){
        YAHOO.example.container.manager.hideAll();
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"user/addresses/change_region/"+RegionId+"/"+Level+"/"+Target;
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, change_region_callback);
}
	var change_region_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
		
		var sel = document.getElementById(result.targets);
		if (result.regions)
        {
          for (i = 0; i < result.regions.length; i ++ )
            {
              var opt = document.createElement("OPTION");
                  opt.value = result.regions[i]['RegionI18n'].region_id;
                  opt.text  = result.regions[i]['RegionI18n'].name;
                  sel.options.add(opt);
            }
        }
		YAHOO.example.container.wait.hide();
	}

	var change_region_callback ={
		success:change_region_Success,
		failure:failure_todo,
		timeout : 30000,
		argument: {}
	};