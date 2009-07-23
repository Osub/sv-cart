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
             //document.getElementById('shop_price').value = result.productinfo['Product'].product_price;
             document.getElementById('product_id').value = result.productid;
             

	    	// 显示价格：包括市场价、本店价（促销价）、会员价
	    	var priceHtml = '<input type="radio" name="add_price[]" value="' + result.productinfo['Product'].market_price + '" />市场价 [' + result.productinfo['Product'].market_price + ']<br />' +
	      		'<input type="radio" name="add_price[]" value="' + result.productinfo['Product'].shop_price + '" checked />本店价 [' + result.productinfo['Product'].shop_price + ']<br />';
	    	for (var i = 0; i < result.userrankinfo.length; i++)
	    	{
	      		priceHtml += '<input type="radio" name="add_price[]" value="' + result.userrankinfo[i].ProductRank.product_price + '" />' + result.userrankinfo[i].UserRankI18n.name + ' [' + result.userrankinfo[i].ProductRank.product_price + ']<br />';
	     	}
	     	priceHtml += '<input type="radio" name="add_price[]" value="user_input" />' + '自定义价格' + '<input type="text" id="user_input_price" name="user_input_price" value="" style="width:60px;" /><br />';
	     	document.getElementById('add_product_price').innerHTML = priceHtml;
	    
         var specCnt = 0; // 规格的数量
         var attrHtml = '';
         var attrCnt = result.productinfo['ProductTypeAttribute'].length;
         for (i = 0; i < attrCnt; i++){
               var valueCnt = result.productinfo['ProductTypeAttribute'][i].length;

              // 规格
              if (valueCnt > 1){
              //alert("大于1")
                   attrHtml += result.productinfo['ProductTypeAttribute'][i][0].attr_name + ': ';
                   for (var j = 0; j < valueCnt; j++){
                         attrHtml += '<input type="radio" name="spec_' + specCnt + '" value="' + result.productinfo['ProductTypeAttribute'][i][j].product_attr_id + '"';
                         if (j == 0){
                                attrHtml += ' checked';
                          }
                          attrHtml += ' />' + result.productinfo['ProductTypeAttribute'][i][j].attr_value;
                          if (result.productinfo['ProductTypeAttribute'][i][j].attr_price > 0){
                                  attrHtml += ' [+' + result.productinfo['ProductTypeAttribute'][i][j].attr_price + ']';
                          }
                         else if (result.productinfo['ProductTypeAttribute'][i][j].attr_price < 0){
                                   attrHtml += ' [-' + Math.abs(result.productinfo['ProductTypeAttribute'][i][j].attr_price) + ']';
                          }
                   }
                   attrHtml += '<br />';
                   specCnt++;
             }
            // 属性
           else{
                 attrHtml +='<input name="pro_attr" id="pro_attr" style="border:0" value="'+result.productinfo['ProductTypeAttribute'][i][0].attr_name + ': ' + result.productinfo['ProductTypeAttribute'][i][0].attr_value + '" readonly/><br />';
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
		var sUrl = webroot_dir+"orders/ajax_edit/"+id+"/?status=1";
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, loading_operate_information_callback);	
	} 
	var loading_operate_information_Success = function(o){
	
		document.getElementById('ajax_edit').innerHTML = o.responseText;
		YAHOO.example.container.wait.hide();
		
		
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
		document.getElementById("ship_detail_id").style.display = "none";
		document.getElementById("unpay_detail_id").style.display = "none";
		document.getElementById("cancel_detail_id").style.display = "none";
		document.getElementById("return_detail_id").style.display = "none";
		document.getElementById('handle_detail').style.display = "block";

	}
	
	function baseinfo_submit(){
		//其他信息
		var data_order_note=GetId('data_order_note').value;//备注
		var data_order_pack_name=GetId('data_order_pack_name').value;//包装
		var data_order_how_oos=GetId('data_order_how_oos').value;//缺货处理
		var data_order_invoice_content=GetId('data_order_invoice_content').value;//发票内容
		var data_order_invoice_payee=GetId('data_order_invoice_payee').value;//发票抬头
		var data_order_invoice_type=GetId('data_order_invoice_type').value;//发票类型
		var data_order_to_buyer=GetId('data_order_to_buyer').value;//商家给客户的留言
		var data_order_postscript=GetId('data_order_postscript').value;//客户给商家留言
		
		//收货人信息
		var OrderConsignee=GetId('OrderConsignee').value;//收货人
		var AddressRegion0=GetId('AddressRegion0').value;//区域
		var AddressRegion1=GetId('AddressRegion1').value;//区域
		var AddressRegion2=GetId('AddressRegion2').value;//区域
		
		var OrderSignBuilding=GetId('OrderSignBuilding').value;//标志性建筑
		var Ordermobile=GetId('Ordermobile').value;//手机
		var OrderTelephone=GetId('OrderTelephone').value;//电话
		var OrderZipcode=GetId('OrderZipcode').value;//邮编
		var OrderAddress=GetId('OrderAddress').value;//地址
		var OrderEemail=GetId('OrderEemail').value;//电子邮件
		var OrderBestTime=GetId('OrderBestTime').value;//
			
		//基本信息
		var order_payment_obj = GetName('data[Order][payment_id]');//支付方式obj
		for( var i=0;i<=order_payment_obj.length-1;i++ ){
			if(order_payment_obj[i].checked){
				var order_payment_id = order_payment_obj[i].value;//支付方式
			}
		}
		var order_shipping_obj = GetName('data[Order][shipping_id]');//配送方式obj
		for( var i=0;i<=order_shipping_obj.length-1;i++ ){
			if(order_shipping_obj[i].checked){
				var order_shipping_id = order_shipping_obj[i].value;//配送方式
			}
		}
		
		var act_type = GetId('act_type').value
		var data_order_id = GetId('data_order_id').value
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"orders/edit_order_info/?status=1";
		var postData = "data[Order][id]="+data_order_id+"&act_type="+act_type+"&data[Order][payment_id]="+order_payment_id+"&data[Order][shipping_id]="+order_shipping_id+"&data[Order][consignee]="+OrderConsignee+"&data[Order][email]="+OrderEemail+"&data[Order][address]="+OrderAddress+"&data[Order][zipcode]="+OrderZipcode+"&data[Order][telephone]="+OrderTelephone+"&data[Order][mobile]="+Ordermobile+"&data[Order][sign_building]="+OrderSignBuilding+"&data[Order][best_time]="+OrderBestTime+"&data[Order][postscript]="+data_order_postscript+"&data[Order][to_buyer]="+data_order_to_buyer+"&data[Order][invoice_type]="+data_order_invoice_type+"&data[Order][invoice_payee]="+data_order_invoice_payee+"&data[Order][invoice_content]="+data_order_invoice_content+"&data[Order][how_oos]="+data_order_how_oos+"&data[Order][pack_name]="+data_order_pack_name+"&data[Order][note]="+data_order_note+"&data[Address][Region][0]="+AddressRegion0+"&data[Address][Region][1]="+AddressRegion1+"&data[Address][Region][2]="+AddressRegion2;

		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl,baseinfo_submit_callback,postData);

	}
	
	var baseinfo_submit_Success = function(o){
		
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
			loading_operate_information(result.order_id);
		}catch (e){   
			alert("Invalid data");
			alert(o.responseText);
		}
		YAHOO.example.container.wait.hide();
		layer_dialog();
        layer_dialog_show(result.message,"",3);
     	
     }
	var baseinfo_submit_Failure = function(o){}
	var baseinfo_submit_callback ={
		success:baseinfo_submit_Success,
		failure:baseinfo_submit_Failure,
		timeout : 300000,
		argument: {}
	};
	
	
//加入订单
function insert_productses(){

	var product_number = GetId('product_number').value;//数量
	var add_product_price = GetName('add_price[]');//价格
	var shop_price = "";
	for( var i=0;i<add_product_price.length;i++){
		if(add_product_price[i].checked){
			shop_price = add_product_price[i].value;
		}
		if(add_product_price[i].checked&&add_product_price[i].value == "user_input"){
			shop_price = GetId('user_input_price').value;
		}
	
	}
	//价格end
	
	var brand_id = GetId('brand_id').value//品牌
	var product_brand = GetId('product_brand').value//品牌
	var product_cat = GetId('product_cat').value//分类

	var cat_id = GetId('cat_id').value//分类
	var product_code = GetId('product_code').value//货号
	var product_name = GetId('product_name').value;//商品名称
		
	var order_id = GetId('order_id').value;
	var product_id = GetId('product_id').value;
	var insert_products = GetId('insert_products').value;
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"orders/edit_order_info/?status=1";
	var postData = "product_number="+product_number+"&shop_price="+shop_price+"&brand_id="+brand_id+"&product_brand="+product_brand+"&product_cat="+product_cat+"&cat_id="+cat_id+"&product_code="+product_code+"&product_name="+product_name+"&order_id="+order_id+"&act_type="+insert_products+"&product_id="+product_id+"&productslist="+product_id;
	
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl,baseinfo_submit_callback,postData);
		
}
function update_order_product(){
	var order_id = GetId('order_id').value;
	var product_attrbute = GetName('product_attrbute[]');//属性
	var product_quntity = GetName('product_quntity[]');//数量
	var product_price = GetName('product_price[]');//价格
	var rec_id = GetName('rec_id[]');
	var product_str = "test=test";
	for( var i=0;i<=product_attrbute.length-1;i++ ){
		product_str+="&product_attrbute["+i+"]="+product_attrbute[i].value;
		product_str+="&product_quntity["+i+"]="+product_quntity[i].value;
		product_str+="&product_price["+i+"]="+product_price[i].value;
		product_str+="&rec_id["+i+"]="+rec_id[i].value;
		
	}
	//alert(product_str);
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"orders/edit_order_info/?status=1";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl,baseinfo_submit_callback,product_str+"&act_type=products&order_id="+order_id);
		
}
	
//  费用信息

function order_fee_information(){
	var order_id = GetId('order_id').value;
	var tax = GetId('tax').value;//发票税额
	var shipping_fee = GetId('shipping_fee').value;//配送费用
	var insure_fee = GetId('insure_fee').value;//保价费用
	var payment_fee = GetId('payment_fee').value;//支付费用
	var pack_fee = GetId('pack_fee').value;//包装费用
	var card_fee = GetId('card_fee').value;//贺卡费用
	var discount = GetId('discount').value;//折扣
	//var tax = GetId('tax').value;//使用红包
	
	var subtotal = GetId('subtotal').value;//商品总价
	var coupon_fee_id = GetId('coupon_fee_id').value;//使用红包

	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"orders/edit_order_info/?status=1";
	var postData = "order_id="+order_id+"&tax="+tax+"&shipping_fee="+shipping_fee+"&insure_fee="+insure_fee+"&payment_fee="+payment_fee+"&pack_fee="+pack_fee+"&card_fee="+card_fee+"&discount="+discount+"&order_id="+order_id+"&act_type=money&subtotal="+subtotal+"&coupon_fee_id="+coupon_fee_id;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl,baseinfo_submit_callback,postData);
		
}
//订单指派
function change_data_Operator_id(){
	YAHOO.example.container.wait.show();
	var order_id = GetId('order_id').value;
	var data_Operator_id = GetId('data_Operator_id').value;
	var sUrl = webroot_dir+"orders/assign_operator/"+order_id;
	var postData = "data[Operator][id]="+data_Operator_id;
	//alert(sUrl);
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl,baseinfo_submit_callback,postData);

}