//根据供应商选择批次
function provider_change(){
	var provider = document.getElementById('inbound_provider');
	var sUrl = webroot_dir+"inbounds/provider_to_batch/"+provider.value;
	var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, provider_change_callback);
}
var provider_change_Success = function(o){
	try{
		 var result = YAHOO.lang.JSON.parse(o.responseText);
	}catch (e){   
		alert("Invalid data");
	}
	var option = "<option value='-1'>请选择...</option><option value='0'>无批次</option>";

	for(var i=0;i<result.message.length;i++){
		option += "<option value='" + result.message[i]['Batch'].id + "'>"+result.message[i]['Batch'].code+"</option>";
	}
	document.getElementById('inbound_batch').innerHTML = option;

}
var provider_change_Failure = function(o){
		alert("error");
}
var provider_change_callback ={
		success:provider_change_Success,
		failure:provider_change_Failure,
		timeout : 10000,
		argument: {}
};

//inbounds产生记录
function inbound_insert(){
	var inbound_id = document.getElementById('inbound_id');
	var inbound_warehouse = document.getElementById('inbound_warehouse');
	var inbound_provider = document.getElementById('inbound_provider');
	var inbound_batch = document.forms["InboundForm"].inbound_batch;
	var inbound_type = document.getElementById('inbound_type');
	var inbound_reason = document.getElementById('inbound_reason');
	var inbound_remark = document.getElementById('inbound_remark');
	
	var postData = "&inbound_id="+inbound_id.value+
				   "&inbound_warehouse="+inbound_warehouse.value+
				   "&inbound_provider="+inbound_provider.value+
		           "&inbound_batch="+inbound_batch.value+
				   "&inbound_type="+inbound_type.value+
				   "&inbound_reason="+inbound_reason.value+
	               "&inbound_remark="+inbound_remark.value;
	var sUrl = webroot_dir+"inbounds/inbound_insert_act/";
//	alert(sUrl);
//	window.location.href = sUrl;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, inbound_insert_callback, postData);
}
var inbound_insert_Success = function(o){
//	alert('in');
	try{
		 var result = YAHOO.lang.JSON.parse(o.responseText);
	}catch (e){
		alert("Invalid data");
	}
	var inbound_id = document.getElementById('inbound_id');
//	alert(inbound_id.value);
	inbound_id.value = result.message;
	window.location.href = webroot_dir+"inbounds/edit/"+result.message;
}
var inbound_insert_Failure = function(o){
		alert("error");
}
var inbound_insert_callback ={
		success:inbound_insert_Success,
		failure:inbound_insert_Failure,
		timeout : 10000,
		argument: {}
};

//进库搜索
function inbound_product_search(){
	var type='SAD';
	var category_id=document.getElementById('category_id').value;
	var product_sn=document.getElementById('product_sn').value;
	var keywords=document.getElementById('keywords').value;
	var provider_id=document.getElementById('inbound_provider').value;
	if(keywords == ""){
			keywords = "all";
	}
	var postData = "&product_sn="+product_sn+
				   "&keywords="+keywords+
				   "&provider_id="+provider_id+
				   "&category_id="+category_id;
	var sUrl = webroot_dir+"inbounds/inbound_product_search_act/";
	alert(sUrl+postData);
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, inbound_product_search_callback, postData);
//	window.location.href=sUrl+"?"+postData;
}
var inbound_product_search_Success = function(o){
//	alert('in');
	try{
		 var result = YAHOO.lang.JSON.parse(o.responseText);
	}catch (e){
		alert(e);
		alert(o.responseText);
	//	alert("Invalid data");
	}
	
	if(result.type == '-1')
	{
		document.getElementById('inbound_optional_list').innerHTML = "没有任何商品";
	}else{
		var inbound_optional_list = "";
		for(var i=0;i<result.message.length;i++){
			inbound_optional_list += 
					 "<input type='hidden' value='"+result.message[i]['Product'].id+"' name='inbound_list["+i+"][id]' id='inbound_list["+i+"][id]'/>"+
					 "<input type='hidden' value='"+result.message[i]['Product'].code+"' name='inbound_list["+i+"][code]' id='inbound_list["+i+"][code]'/>"+
					 "<input type='hidden' value='"+result.message[i]['ProductI18n'].name+"' name='inbound_list["+i+"][name]' id='inbound_list["+i+"][name]'/>"+
					 "<tr><td align='center' width='8%'><input type='checkbox' name='inbound_list["+i+"][checkbox]' id='inbound_list["+i+"][checkbox]'/>"+result.message[i]['Product'].id+"</td>"+
					 "<td align='center' width='12%'>"+result.message[i]['Product'].code+"</td>"+
					 "<td align='center' width='15%'>"+result.message[i]['ProductI18n'].name+"</td>"+
					 "<td align='center' width='20%'><input type='text' style='width:100px;border:1px solid #649776;' name='inbound_list["+i+"][remark]' id='inbound_list["+i+"][remark]'/></td>"+
					 "<td align='center' width='20%'><input type='text' style='width:100px;border:1px solid #649776;' name='inbound_list["+i+"][attribute]' id='inbound_list["+i+"][attribute]'/></td>"+
					 "<td align='center' width='5W%'><input type='text' style='width:60px;border:1px solid #649776;' name='inbound_list["+i+"][purchase_price]' id='inbound_list["+i+"][purchase_price]' value='"+result.message[i]['Product'].purchase_price+"' /></td>"+
					 "<td align='center' width='5%'><input type='text' style='width:60px;border:1px solid #649776;' name='inbound_list["+i+"][shop_price]' id='inbound_list["+i+"][shop_price]'value='"+result.message[i]['Product'].shop_price+"' /></td>"+
					 "<td align='center' width='5%'><input type='text' style='width:40px;border:1px solid #649776;' name='inbound_list["+i+"][quantity]' id='inbound_list["+i+"][quantity]' value='1'/></td>"+
					 "<td align='center' width='5%'><a href='javascript:inbound_in("+i+","+result.message[i]['Product'].id+");' name='1'>添加</a></td></tr>";
		}
		inbound_optional_list += "<tr><input type='submit' value='批量添加'></tr>";
		document.getElementById('inbound_optional_list').innerHTML  = inbound_optional_list;
	}
	
//	document.getElementById('inbound_optional_list').innerHTML += "<input type='hidden' value='hidden' id='hidden'>"

}
var inbound_product_search_Failure = function(o){
		alert("error");
}
var inbound_product_search_callback ={
		success:inbound_product_search_Success,
		failure:inbound_product_search_Failure,
		timeout : 10000,
		argument: {}
};

/*function inbound_add_list(i){
	alert(document.getElementById('inbound_list['+i+'][purchase_price]').value);
	var add_data;
	add_data['id'] = document.getElementById('"'+'inbound_list['+i+'][id]'+'"').value;
	add_data['code'] = document.getElementById('inbound_list['+i+'][code]').value;
	add_data['name'] = document.getElementById('inbound_list['+i+'][name]').value;
	add_data['remark'] = document.getElementById('inbound_list['+i+'][remark]').value;
	add_data['attribute'] = document.getElementById('inbound_list['+i+'][attribute]').value;
	add_data['purchase_price'] = document.getElementById('inbound_list['+i+'][purchase_price]').value;
	add_data['shop_price'] = document.getElementById('inbound_list['+i+'][shop_price]').value;
	add_data['quantity'] = document.getElementById('inbound_list['+i+'][quantity]').value;
	
	document.getElementById('inbound_product_list').innerHTML += 
				 "<input type='hidden' value='"+add_data['id']+"' id='inbound_product["+i+"][id]'/>"+
				 "<input type='hidden' value='"+add_data['code']+"' id='inbound_product["+i+"][code]'/>"+
				 "<input type='hidden' value='"+add_data['name']+"' id='inbound_product["+i+"][name]'/>"+
				 "<input type='hidden' value='"+add_data['remark']+"' id='inbound_product["+i+"][remark]'/>"+
		         "<input type='hidden' value='"+add_data['attribute']+"' id='inbound_product["+i+"][attribute]'/>"+
				 "<input type='hidden' value='"+add_data['purchase_price']+"' id='inbound_product["+i+"][purchase_price]'/>"+
				 "<input type='hidden' value='"+add_data['shop_price']+"' id='inbound_product["+i+"][shop_price]'/>"+
				 "<input type='hidden' value='"+add_data['quantity']+"' id='inbound_product["+i+"][quantity]'/>"+
				 "<tr><td align='center'><input type='checkbox' id='inbound_product["+i+"][checkbox]'>"+add_data['id']+"</td>"+
				 "<td align='center'>"+add_data['code']+"</td>"+
				 "<td align='center'>"+add_data['name']+"</td>"+
				 "<td align='center'>"+add_data['remark']+"</td>"+
				 "<td align='center'>"+add_data['attribute']+"</td>"+
				 "<td align='center'>"+add_data['purchase_price']+"</td>"+
				 "<td align='center'>"+add_data['shop_price']+"</td>"+
				 "<td align='center'>"+add_data['quantity']+"</td>"+
				 "<td align='center'><a href='inbound_add_list("+i+")'>添加</a></td></tr>";
}*/

function inbound_batch_add_list(batch_id){

}
  
function inbound_in(i,id){
  	/* alert('in1');
  	 var tem  = document.getElementById(inbound_list[0][remark]).value;
  	 alert(tem);*/
  	document.inbound_products_form.action= webroot_dir +"inbounds/inbound_in_act/"+i+"/"+id;
  	document.inbound_products_form.submit();

}
function inbound_stock_check(id){
	document.inbound_list_form.action= webroot_dir +"inbounds/inbound_to_stock/" + id;
  	document.inbound_list_form.submit();
}

function chkall(input1,input2)
{
    var objForm = document.forms[input1];
    var objLen = objForm.length;
    for (var iCount = 0; iCount < objLen; iCount++)
    {
        if (input2.checked == true)
        {
            if (objForm.elements[iCount].type == "checkbox")
            {
                objForm.elements[iCount].checked = true;
            }
        }
        else
        {
            if (objForm.elements[iCount].type == "checkbox")
            {
                objForm.elements[iCount].checked = false;
            }
        }
    }
}
