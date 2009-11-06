//根据供应商选择批次
function provider_change(){
	var provider = document.getElementById('outbound_provider');
	var sUrl = webroot_dir+"outbounds/provider_to_batch/"+provider.value;
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
	document.getElementById('outbound_batch').innerHTML = option;

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

//outbounds产生记录
function outbound_insert(){
	var outbound_id = document.getElementById('outbound_id');
	var outbound_warehouse = document.getElementById('outbound_warehouse');
	var outbound_provider = document.getElementById('outbound_provider');
	var outbound_batch = document.forms["OutboundForm"].outbound_batch;
	var outbound_type = document.getElementById('outbound_type');
	var outbound_reason = document.getElementById('outbound_reason');
	var outbound_remark = document.getElementById('outbound_remark');
	
	var postData = "&outbound_id="+outbound_id.value+
				   "&outbound_warehouse="+outbound_warehouse.value+
				   "&outbound_provider="+outbound_provider.value+
		           "&outbound_batch="+outbound_batch.value+
				   "&outbound_type="+outbound_type.value+
				   "&outbound_reason="+outbound_reason.value+
	               "&outbound_remark="+outbound_remark.value;
//	alert(postData);
	var sUrl = webroot_dir+"outbounds/outbound_insert_act/";
//	alert(sUrl);
//	window.location.href = sUrl;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, outbound_insert_callback, postData);
}
var outbound_insert_Success = function(o){
//	alert('in');
	try{
		 var result = YAHOO.lang.JSON.parse(o.responseText);
	}catch (e){
		alert(o.responseText);
	}
	var outbound_id = document.getElementById('outbound_id');
//	alert(outbound_id.value);
	outbound_id.value = result.message;
	window.location.href = webroot_dir+"outbounds/edit/"+result.message;
}
var outbound_insert_Failure = function(o){
		alert("error");
}
var outbound_insert_callback ={
		success:outbound_insert_Success,
		failure:outbound_insert_Failure,
		timeout : 10000,
		argument: {}
};

//进库搜索
function outbound_product_search(key){
	var type='SAD';
	var category_id=document.getElementById('category_id').value;
	var product_sn=document.getElementById('product_sn').value;
	var keywords=document.getElementById('keywords').value;
	var provider_id=document.getElementById('outbound_provider').value;
	if(keywords == ""){
			keywords = "all";
	}
	var postData = "&product_sn="+product_sn+
				   "&keywords="+keywords+
				   "&provider_id="+provider_id+
				   "&category_id="+category_id;
	var sUrl = webroot_dir+"outbounds/outbound_product_search_act/";
//	alert(sUrl);
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, outbound_product_search_callback, postData);
//	window.location.href=sUrl+"?"+postData;
}
var outbound_product_search_Success = function(o){
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
		document.getElementById('outbound_optional_list').innerHTML = "没有任何商品";
	}else{
		var outbound_optional_list = "";
		var store_optional_list = "";
		for(var i=0;i<result.store.length;i++){
			store_optional_list += "<option value='"+result.store[i]['Store'].id+"'>"+result.store[i]['StoreI18n'].name+"</option>"
		}
		for(var i=0;i<result.message.length;i++){
			outbound_optional_list += 
					 "<input type='hidden' value='"+result.message[i]['Product'].id+"' name='outbound_list["+i+"][id]' id='outbound_list["+i+"][id]'/>"+
					 "<input type='hidden' value='"+result.message[i]['Product'].code+"' name='outbound_list["+i+"][code]' id='outbound_list["+i+"][code]'/>"+
					 "<input type='hidden' value='"+result.message[i]['ProductI18n'].name+"' name='outbound_list["+i+"][name]' id='outbound_list["+i+"][name]'/>"+
					 "<tr><td align='center'  width='8%'><input type='checkbox' name='outbound_list["+i+"][checkbox]' id='outbound_list["+i+"][checkbox]'/>"+result.message[i]['Product'].id+"</td>"+
					 "<td align='center' width='12%'>"+result.message[i]['Product'].code+"</td>"+
					 "<td align='center' width='15%'>"+result.message[i]['ProductI18n'].name+"</td>"+
					 "<td align='center' width='15%'><input type='text' style='width:100px;border:1px solid #649776;' name='outbound_list["+i+"][remark]' id='outbound_list["+i+"][remark]'/></td>"+
					 "<td align='center' width='15%'><input type='text' style='width:100px;border:1px solid #649776;' name='outbound_list["+i+"][attribute]' id='outbound_list["+i+"][attribute]'/></td>"+
					 "<td align='center' width='5%'><input type='text' style='width:60px;border:1px solid #649776;' name='outbound_list["+i+"][purchase_price]' id='outbound_list["+i+"][purchase_price]' value='"+result.message[i]['Product'].purchase_price+"' /></td>"+
					 "<td align='center' width='5%'><input type='text' style='width:60px;border:1px solid #649776;' name='outbound_list["+i+"][shop_price]' id='outbound_list["+i+"][shop_price]'value='"+result.message[i]['Product'].shop_price+"' /></td>"+
					 "<td align='center' width='10%'><select style='width:60px;border:1px solid #649776;' name='outbound_list["+i+"][store_id]' id='outbound_list["+i+"][store_id]'>"+store_optional_list+"</select></td>"+
					 "<td align='center' width='5%'><input type='text' style='width:40px;border:1px solid #649776;' name='outbound_list["+i+"][quantity]' id='outbound_list["+i+"][quantity]' value='1'/></td>"+
					 "<td align='center' width='5%'><a href='javascript:outbound_in("+i+","+result.message[i]['Product'].id+");' name='1'>添加</a></td></tr>";
		}
		outbound_optional_list += "<tr><input type='submit' value='批量添加'></tr>";
		document.getElementById('outbound_optional_list').innerHTML = outbound_optional_list;
	}

}
var outbound_product_search_Failure = function(o){
		alert("error");
}
var outbound_product_search_callback ={
		success:outbound_product_search_Success,
		failure:outbound_product_search_Failure,
		timeout : 10000,
		argument: {}
};

/*function outbound_add_list(i){
	alert(document.getElementById('outbound_list['+i+'][purchase_price]').value);
	var add_data;
	add_data['id'] = document.getElementById('"'+'outbound_list['+i+'][id]'+'"').value;
	add_data['code'] = document.getElementById('outbound_list['+i+'][code]').value;
	add_data['name'] = document.getElementById('outbound_list['+i+'][name]').value;
	add_data['remark'] = document.getElementById('outbound_list['+i+'][remark]').value;
	add_data['attribute'] = document.getElementById('outbound_list['+i+'][attribute]').value;
	add_data['purchase_price'] = document.getElementById('outbound_list['+i+'][purchase_price]').value;
	add_data['shop_price'] = document.getElementById('outbound_list['+i+'][shop_price]').value;
	add_data['quantity'] = document.getElementById('outbound_list['+i+'][quantity]').value;
	
	document.getElementById('outbound_product_list').innerHTML += 
				 "<input type='hidden' value='"+add_data['id']+"' id='outbound_product["+i+"][id]'/>"+
				 "<input type='hidden' value='"+add_data['code']+"' id='outbound_product["+i+"][code]'/>"+
				 "<input type='hidden' value='"+add_data['name']+"' id='outbound_product["+i+"][name]'/>"+
				 "<input type='hidden' value='"+add_data['remark']+"' id='outbound_product["+i+"][remark]'/>"+
		         "<input type='hidden' value='"+add_data['attribute']+"' id='outbound_product["+i+"][attribute]'/>"+
				 "<input type='hidden' value='"+add_data['purchase_price']+"' id='outbound_product["+i+"][purchase_price]'/>"+
				 "<input type='hidden' value='"+add_data['shop_price']+"' id='outbound_product["+i+"][shop_price]'/>"+
				 "<input type='hidden' value='"+add_data['quantity']+"' id='outbound_product["+i+"][quantity]'/>"+
				 "<tr><td align='center'><input type='checkbox' id='outbound_product["+i+"][checkbox]'>"+add_data['id']+"</td>"+
				 "<td align='center'>"+add_data['code']+"</td>"+
				 "<td align='center'>"+add_data['name']+"</td>"+
				 "<td align='center'>"+add_data['remark']+"</td>"+
				 "<td align='center'>"+add_data['attribute']+"</td>"+
				 "<td align='center'>"+add_data['purchase_price']+"</td>"+
				 "<td align='center'>"+add_data['shop_price']+"</td>"+
				 "<td align='center'>"+add_data['quantity']+"</td>"+
				 "<td align='center'><a href='outbound_add_list("+i+")'>添加</a></td></tr>";
}*/

function outbound_batch_add_list(batch_id){

}

function outbound_in(i,id){
	var objForm = document.forms["outbound_products_form"];
  	if (objForm.elements["outbound_list["+i+"][store_id]"].value == "")
	{
		      layer_dialog_show("请填写店铺ID!","",3);
			 // return false;
	}else{
		document.outbound_products_form.action= webroot_dir +"outbounds/outbound_in_act/"+i+"/"+id;
		document.outbound_products_form.submit();
	}
  	//document.outbound_products_form.onsubmit= "return outbound_check()";
  	//document.outbound_products_form.submit();

}

function outbound_stock_check(id){
	document.outbound_list_form.action= webroot_dir +"outbounds/outbound_to_stock/" + id;
  	document.outbound_list_form.submit();
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

function outbound_check(){
	
	var objForm = document.forms["outbound_products_form"];
	var objLen = objForm.length;
	for (var i = 0; i < objLen; i++)
	    {
	        if(objForm.elements["outbound_list["+i+"][checkbox]"].checked == true){
	           if (objForm.elements["outbound_list["+i+"][store_id]"].value == "")
		       {
		       	   layer_dialog_show("请填写店铺ID!","",3);
					return false;
		       }
	       }
	    }
    
    document.outbound_products_form.submit();
}