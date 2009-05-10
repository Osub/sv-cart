//搜索商品
function searchProducts(){
	var keywords=document.getElementById('keywords').value;
	var sUrl = webroot_dir+"products/searchproducts/"+keywords;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, searchProducts_callback);
}

	var searchProducts_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert("Invalid data");
		}
		 var sel = document.getElementById('productslist');
		 sel.innerHTML = "";
	//	 alert(sel);
		if (result.message){
			 var opt = document.createElement("OPTION");
			opt.value = "";
			opt.text = "请选择商品";
			sel.options.add(opt);
             for (i = 0; i < result.message.length; i++ ){
                 var opt = document.createElement("OPTION");
                      opt.value = result.message[i]['ProductI18n'].product_id;
                      opt.text  = result.message[i]['ProductI18n'].name;
                      sel.options.add(opt);
              }
     //    alert(sel);
         }
	}

	var searchProducts_Failure = function(o){
		alert("error");
	}

	var searchProducts_callback ={
		success:searchProducts_Success,
		failure:searchProducts_Failure,
		timeout : 10000,
		argument: {}
	};
	
	
	
	
	
	//选择商品加入订单
	function getProductInfo(productId){
	      if (productId > 0){
               var sUrl = webroot_dir+"orders/get_product_info/"+productId;
		       var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, getProductInfo_callback);
		       document.getElementById('showhidess').style.display = 'block';
          }
         else{
              document.getElementById('product_name').value = '';
              document.getElementById('product_code').value = '';
              document.getElementById('product_cat').value = '';
              document.getElementById('product_brand').value = '';
              document.getElementById('shop_price').value = '';
              document.getElementById('product_attr').value = '';
         }
		
    }
	var getProductInfo_Success = function(o){
	   try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   alert(o.responseText);
			alert("Invalid data");
		} 
	    // 显示商品名称、货号、分类、品牌
	         document.getElementById('product_name').value = result.productinfo['ProductI18n'].name;
	         document.getElementById('product_cat').value = result.productinfo['CategoryI18n'].name;
	         document.getElementById('product_brand').value = result.productinfo['BrandI18n'].name;
	         document.getElementById('product_code').value = result.productinfo['Product'].code;
             document.getElementById('shop_price').value = result.productinfo['Product'].product_price;
             document.getElementById('product_id').value = result.productid;
             

        // 显示价格：包括市场价、本店价（促销价）、会员价

         var specCnt = 0; // 规格的数量
         var attrHtml = '';
         var attrCnt = result.productinfo['Attribute'].length;
         for (i = 0; i < attrCnt; i++){
               var valueCnt = result.productinfo['Attribute'][i].length;

              // 规格
              if (valueCnt > 1){
              //alert("大于1")
                   attrHtml += result.productinfo['Attribute'][i][0].attr_name + ': ';
                   for (var j = 0; j < valueCnt; j++){
                         attrHtml += '<input type="radio" name="spec_' + specCnt + '" value="' + result.productinfo['Attribute'][i][j].product_attr_id + '"';
                         if (j == 0){
                                attrHtml += ' checked';
                          }
                          attrHtml += ' />' + result.productinfo['Attribute'][i][j].attr_value;
                          if (result.productinfo['Attribute'][i][j].attr_price > 0){
                                  attrHtml += ' [+' + result.productinfo['Attribute'][i][j].attr_price + ']';
                          }
                         else if (result.productinfo['Attribute'][i][j].attr_price < 0){
                                   attrHtml += ' [-' + Math.abs(result.productinfo['Attribute'][i][j].attr_price) + ']';
                          }
                   }
                   attrHtml += '<br />';
                   specCnt++;
             }
            // 属性
           else{
                 attrHtml +='<input name="pro_attr" id="pro_attr" style="border:0" value="'+result.productinfo['Attribute'][i][0].attr_name + ': ' + result.productinfo['Attribute'][i][0].attr_value + '" readonly/><br />';
           }
        }
       document.getElementById('spec_count').value = specCnt;
       document.getElementById('product_attr').innerHTML = attrHtml;
         
	}

	var getProductInfo_Failure = function(o){
		alert("error");
	}

	var getProductInfo_callback ={
		success:getProductInfo_Success,
		failure:getProductInfo_Failure,
		timeout : 3000,
		argument: {}
	};







//



function insert_products(){
		var product_name = document.getElementById('product_name');
		
		if(product_name.value!=""){
			document.UpdateOrder.submit();
		}else{
			layer_dialog_show("请选择商品!","",3);
		}
   	}





/***************操作订单各种状态***************/
/****order_action******/
/****action type*******/
/***************操作订单各种状态***************/
function orderaction(obj){
		layer_dialog();
        var actionnote=document.getElementById('action_note').value;
        var orderid=document.getElementById('order_id').value;
        var invoiceno=document.getElementById('invoice_no').value;
        var refunds=document.getElementsByName('refund[]');
        var refund = 0;
        for(var i = 0;i <refunds.length;i++ ){
             if(refunds[i].checked){
             	refund= refunds[i].value;
             }
        }
        var refund_note=document.getElementById('refund_note').value;
        var cancel_note=document.getElementById('cancel_note').value;
        var refund_cancels=document.getElementsByName('refund_cancel[]');
        var refund_cancel = 0;
        for(var j = 0;j <refund_cancels.length;j++ ){
             if(refund_cancels[j].checked){
                   refund_cancel= refund_cancels[j].value;
             }
        }
  
        var refund_cancel_note=document.getElementById('refund_cancel_note').value;
        var refund_returns=document.getElementsByName('refund_return[]');
        var refund_return = 0;
        for(var k = 0;k <refund_returns.length;k++ ){
             if(refund_returns[k].checked){
                   refund_return= refund_returns[k].value;
             }
        }
        
        if(actionnote == ''&&write_order_ship_remark==0){
             layer_dialog_show("操作备注未填写!","",3);
             return false;
         }
        if(actionnote == ''&&write_order_receive_remark==0){
             layer_dialog_show("操作备注未填写!","",3);
             return false;
         }
         if(actionnote == ''&&write_order_unship_remark==0){
             layer_dialog_show("操作备注未填写!","",3);
             return false;
         }
         if(actionnote == ''&&write_order_invalid_remark==0){
             layer_dialog_show("操作备注未填写!","",3);
             return false;
         }
         
        var refund_return_note=document.getElementById('refund_return_note').value;
        var action_type=obj.name;
        if(action_type=="ship"&&invoiceno==""&&virtual_card_status=='no'){
        	layer_dialog_show("请输入货号!","",3);
        	return false;
        }
        
        
        
        if(action_type=="unpay"){
        	if(actionnote == ''&&write_order_unpay_remark==0){
             layer_dialog_show("操作备注未填写!","",3);
             return false;
         	}
        	if(refund==0){
        		layer_dialog_show("请选择退款方式!","",3);
        		return false;
        	}
        	if(refund_note==""){
        		layer_dialog_show("请输入退款说明!","",3);
        		return false;
        	}

        }
        
        if(action_type=="cancel"){
        	if(actionnote == ''&&write_order_cancel_remark==0){
             layer_dialog_show("操作备注未填写!","",3);
             return false;
         	}
        	if(cancel_note==""){
        		layer_dialog_show("请输入取消原因!","",3);
        		return false;
        	}
        	if(refund_cancel==0){
        		layer_dialog_show("请选择退款方式!","",3);
        		return false;
        	}
            if(refund_cancel_note==""){
        		layer_dialog_show("请输入退款说明!","",3);
        		return false;
        	}

        }
        
        if(action_type=="return"){
        	if(actionnote == ''&&write_order_return_remark==0){
             layer_dialog_show("操作备注未填写!","",3);
             return false;
         	}
        	if(refund_return==0){
        		layer_dialog_show("请选择退款方式!","",3);
        		return false;
        	}
            if(refund_return_note==""){
        		layer_dialog_show("请输入退款说明!","",3);
        		return false;
        	}
        }
        
        
        
        
 
        YAHOO.example.container.manager.hideAll();
	    YAHOO.example.container.wait.show();	
		var sUrl = webroot_dir+"orders/order_operate/";
		var postData ='';
			postData+='&action_note='+actionnote+'&order_id='+orderid+"&invoice_no="+invoiceno+"&action_type="+action_type+"&refund_note="+refund_note+"&cancel_note="+cancel_note+"&refund_cancel_note="+refund_cancel_note+"&refund_return_note="+refund_return_note+"&refund="+refund+"&refund_cancel="+refund_cancel+"&refund_return="+refund_return;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, orderAction_callback,postData);
	}

	var orderAction_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
			loading_operate_information(result.order_id);
		}catch (e){   
			alert("Invalid data");
			alert(o.responseText);
		}
		layer_dialog();
        layer_dialog_show(result.msg,"",3);
		YAHOO.example.container.wait.hide();
     }
	var orderAction_Failure = function(o){}
	var orderAction_callback ={
		success:orderAction_Success,
		failure:orderAction_Failure,
		timeout : 300000,
		argument: {}
	};
	
	
	
	
	
	
	////收货人地址
	
	function onchange_address(obj){
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"orders/onchange_address/"+obj.value;
	
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, onchange_address_callback);
	}
	var onchange_address_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert("Invalid data");
			alert(o.responseText);
		}
		document.getElementById('OrderConsignee').value=result.UserAddress.consignee;
		show_regions(result.UserAddress.regions);
		document.getElementById('OrderEemail').value=result.UserAddress.email;
		document.getElementById('OrderAddress').value=result.UserAddress.address;
		document.getElementById('OrderZipcode').value=result.UserAddress.zipcode;
		document.getElementById('OrderTelephone').value=result.UserAddress.telephone;
		document.getElementById('OrderSignBuilding').value=result.UserAddress.sign_building;
		document.getElementById('OrderBestTime').value=result.UserAddress.best_time;
		document.getElementById('regions_names').innerHTML=result.UserAddress.name;
		document.getElementById('Ordermobile').value=result.UserAddress.mobile;
		YAHOO.example.container.wait.hide();
     }
	var onchange_address_Failure = function(o){}
	var onchange_address_callback ={
		success:onchange_address_Success,
		failure:onchange_address_Failure,
		timeout : 300000,
		argument: {}
	};
	

	//重载  操作信息
	function loading_operate_information(id){
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"orders/ajax_view/"+id+"/?status=1";
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, loading_operate_information_callback);	
	} 
	var loading_operate_information_Success = function(o){
		document.getElementById('ajax_view').innerHTML = o.responseText;
		YAHOO.example.container.wait.hide();
		show_regions(regions);
		
    }
	var loading_operate_information_Failure = function(o){}
	var loading_operate_information_callback ={
		success:loading_operate_information_Success,
		failure:loading_operate_information_Failure,
		timeout : 300000,
		argument: {}
	};


	
	
	function order_show_hide(id){
		document.getElementById(id).style.display = "block";
		document.getElementById('handle_detail').style.display = "none";

	}
	//返回
	function come_to_back(){
		document.getElementById("ship_detail").style.display = "none";
		document.getElementById("unpay_detail").style.display = "none";
		document.getElementById("cancel_detail").style.display = "none";
		document.getElementById("return_detail").style.display = "none";
		document.getElementById('handle_detail').style.display = "block";

	}