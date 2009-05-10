//配送方式  所辖地区
var mod;
function regions(mo){
	mod = mo;
    var province_id=document.getElementById('province_id').value;
    var sUrl = webroot_dir+"shippingments/province/"+province_id;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, province_callback);
}
function region_city(mo){
	mod = mo;
    var citys=document.getElementById('citys').value;
	var sUrl = webroot_dir+"shippingments/province/"+citys;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, province_callback);
}
function region_country(mo){
	mod = mo;
    var country_id=document.getElementById('country_id').value;
    var sUrl = webroot_dir+"shippingments/province/"+country_id;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, province_callback);
}
	var province_Success = function(o){
		//alert(o.responseText);
		try{
			//var result = YAHOO.lang.JSON.parse(o.responseText);
			eval('result='+o.responseText); 
		}catch (e){   
		
		}	
	
		//alert(result);
		if(mod=="country"){
			var sel = document.getElementById('province_id');
			document.getElementById('citys').innerHTML = "";
			 opt = document.createElement("OPTION");  
			 opt.selected = "false";
             opt.value = " ";;
             opt.text  = "请选择...";
             document.getElementById('citys').options.add(opt);
             document.getElementById('area_id').innerHTML = "";
			 opt = document.createElement("OPTION");  
			 opt.selected = "false";
             opt.value = " ";;
             opt.text  = "请选择...";
             document.getElementById('area_id').options.add(opt);
		}
		if(mod=="province"){
			var sel = document.getElementById('citys');
			document.getElementById('area_id').innerHTML = "";
			 opt = document.createElement("OPTION");  
			 opt.selected = "false";
             opt.value = " ";;
             opt.text  = "请选择...";
             document.getElementById('area_id').options.add(opt);
			
		}
		if(mod=="city"){
			var sel = document.getElementById('area_id');
		}
		if (result.message){
			 sel.innerHTML = "";
			 opt = document.createElement("OPTION");  
			 opt.selected = "false";
             opt.value = " ";;
             opt.text  = "请选择...";
             sel.options.add(opt);
             //alert(result.number);
             for (i = result.first_key; i < result.number; i++ ){
              	 	var opt = document.createElement("OPTION");
                 	opt.value = result.message[i]['Region'].id;
                 	opt.text  = result.message[i]['RegionI18n'].name;
                 	sel.options.add(opt);
              	
              }
         
         }
         YAHOO.example.container.wait.hide();
	}

	var province_Failure = function(o){
		alert("error");
	}

	var province_callback ={
		success:province_Success,
		failure:province_Failure,
		timeout : 10000,
		argument: {}
	};