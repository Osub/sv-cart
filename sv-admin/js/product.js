//删除相册图片
function dropImg(ImgId){
	var sUrl = webroot_dir+"products/drop_img/"+ImgId;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, dropImg_callback);
}
var dropImg_Success = function(o){
	layer_dialog();
	layer_dialog_show("图片删除成功","",4);
}

var dropImg_Failure = function(o){}
var dropImg_callback ={
	success:dropImg_Success,
	failure:dropImg_Failure,
	timeout : 100000,
	argument: {}
};
//搜索文章
function searchArticles(){
        var Article_keywords=document.getElementById('keywords_id').value;
        var Article_cat=document.getElementById('article_cat').value;
		var sUrl = webroot_dir+"articles/searcharticles/"+Article_cat+"/"+Article_keywords;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, searchArticles_callback);
	}

	var searchArticles_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert("Invalid data");
		}
		 var sel = document.getElementById('source_select2');
		 sel.innerHTML = "";
		if (result.message){
             for (i = 0; i < result.message.length; i++ ){
                 var opt = document.createElement("OPTION");
                      opt.value = result.message[i]['Article'].id;
                      opt.text  = result.message[i]['Article'].title;
                      sel.options.add(opt);
              }
     //    alert(sel);
         }
         YAHOO.example.container.wait.hide();
	}

	var searchArticles_Failure = function(o){
		alert("error");
	}

	var searchArticles_callback ={
		success:searchArticles_Success,
		failure:searchArticles_Failure,
		timeout : 10000,
		argument: {}
	};
//搜索商品
function searchProducts(){
        var keywords=document.getElementById('keywords').value;
        var catId=document.getElementById('category_id').value;
        var brandId=document.getElementById('brand_id').value;
        var products_id=document.getElementById('products_id').value;
		if(keywords==""){
			keywords = "all";
		}
		var sUrl = webroot_dir+"products/searchproducts/"+keywords+"/"+catId+"/"+brandId+'/'+products_id;
		//alert(sUrl);
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, searchProducts_callback);
	}

	var searchProducts_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert("Invalid data");
		}
		 var sel = document.getElementById('source_select1');
		 sel.innerHTML = "";
	//	 alert(sel);
		if (result.message){
             for (i = 0; i < result.message.length; i++ ){
                 var opt = document.createElement("OPTION");
                      opt.value = result.message[i]['ProductI18n'].product_id;
                      opt.text  = result.message[i]['ProductI18n'].name;
                      sel.options.add(opt);
              }
     //    alert(sel);
         }
         YAHOO.example.container.wait.hide();
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
//添加扩展分类
function addOtherCat(){
     var sel = document.createElement("SELECT");
      var selCat = document.getElementById('ProductsCategory');

      for (i = 0; i < selCat.length; i++)
      {
          var opt = document.createElement("OPTION");
          opt.text = selCat.options[i].text;
          opt.value = selCat.options[i].value;
          if (Browser.isIE)
          {
              sel.add(opt);
          }
          else
          {
              sel.appendChild(opt);
          }
      }
      var conObj=document.getElementById('other_cats');
      conObj.appendChild(sel);
      sel.name = "other_cat[]";
      sel.onChange = function() {checkIsLeaf(this);};
  }
  //检查input框输入数据
  function check_input(Input){
  	     var re = /^[1-9]+[0-9]*]*$/ ;  //判断字符串是否为数字     //判断正整数 /^[1-9]+[0-9]*]*$/   
            if (!re.test(Input.value)){
                    alert("填写内容不是整数!");
                    Input.focus();
                    return false;
            }
  }
  
  
  
  
  
  
  
  
  /////////////////
  
  
  var Browser = new Object();

Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);

/**
   * 按比例计算价格
   * @param   string  inputName   输入框名称
   * @param   float   rate        比例
   * @param   string  priceName   价格输入框名称（如果没有，取shop_price）
   */
  function computePrice(inputName, rate, priceName)
  {
      var shopPrice = priceName == undefined ? document.getElementById('ProductShopPrice').value : document.getElementById(priceName).value;
      var s = shopPrice != '' ? getnum(parseFloat(shopPrice)* numpri,2) : 0;
      shopPrice += "";

      n = shopPrice.lastIndexOf(".");
      if (n > -1)
      {
          shopPrice = shopPrice.substr(0, n + 3);
      }

      if (document.getElementById(inputName) != undefined)
      {
          document.getElementById(inputName).value = s;
      }
      else
      {
          document.getElementById(inputName).value = s;
      }
  }

  /**
   * 设置了一个商品价格，改变市场价格、积分以及会员价格
   */
  function priceSetted()
  {
    computePrice('ProductMarketPrice');
  }
  /**
   * 根据市场价格，计算并改变商店价格、积分以及会员价格
   */
  function marketPriceSetted()
  {
    computePrice('ProductMarketPrice', 1.2, 'ProductShopPrice');
  }
  //促销
    function handlePromote(checked)
  {
       document.getElementById('ProductPromotionPrice').disabled = !checked;
       document.getElementById('date').disabled = !checked;
       document.getElementById('date2').disabled = !checked;
  }
    //会员价
    function user_prince_check(checked,num)
  {
       set_price_note(num);
  }
  /**
   * 将市场价格取整
   */
  function integral_market_price()
  {
       document.getElementById('ProductMarketPrice').value = parseInt(document.getElementById('ProductMarketPrice').value);
  }
  
  /**
   * 设置会员价格注释
   */
  function set_price_note(rank_id)
  {
    var shop_price = parseFloat(document.getElementById('ProductShopPrice').value);

    var user_discount = document.getElementById('user_price_discount' + rank_id).value;
	if(shop_price==""){
		shop_price=0;
	}
    if (shop_price >=0 && document.getElementById('rank_product_price' + rank_id))
    {
        var user_price=getnum((shop_price) * (user_discount/100),2);
        document.getElementById('rank_product_price' + rank_id).value  = user_price ;

        
    }
   
  }
  function rank_product_price(rank_id){
  
        document.getElementById('is_default_rank' + rank_id).checked  = false ;
  }
function getnum(f,c)
{
    var t = Math.pow(10, c);
    return Math.round(f * t) / t;
}
function getAttrList(productId){
       var selProductsType = document.forms['ProAttrForm'].elements['product_type'];
       if (selProductsType != undefined){
           var ProductsType = selProductsType.options[selProductsType.selectedIndex].value;
           //ajax处理
           //YAHOO.example.container.manager.hideAll();
		   //YAHOO.example.container.wait.show();
		   var sUrl = webroot_dir+"products/get_attr/"+productId+"/"+ProductsType;
		   var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, getAttrList_callback);
       }
}
var getAttrList_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){
			alert("Invalid data");
			alert(o.responseText);
			//YAHOO.example.container.wait.hide();
		} 
         //显示属性和规格
         document.getElementById('productsAttr').innerHTML=result.attr_html;
         //YAHOO.example.container.wait.hide();
	}

	var getAttrList_Failure = function(o){
		//YAHOO.example.container.wait.hide();
	}

	var getAttrList_callback ={
		success:getAttrList_Success,
		failure:getAttrList_Failure,
		timeout : 3000,
		argument: {}
	};
	
	
	
	
	
	//更新关联商品排序
function update_orderby(relationId,sort,type){
        YAHOO.example.container.manager.hideAll();
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"products/update_orderby/"+relationId+"/"+sort+"/"+type+"/"+Math.random();
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, updateOrderby_callback);
}

	var updateOrderby_Success = function(o){
		//alert(o.responseText);
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
	
        YAHOO.example.container.wait.hide();
	}

	var updateOrderby_Failure = function(result){
		YAHOO.example.container.wait.hide();
	}

	var updateOrderby_callback ={
		success:updateOrderby_Success,
		failure:updateOrderby_Failure,
		timeout : 3000,
		argument: {}
	};
	//根据货号改文件名
	function update_code(obj){
		var product_code = document.getElementById('product_code').value;
		if(product_code!=obj.value){
			var sUrl = webroot_dir+"products/update_code/"+product_code+"/"+obj.value+"/"+product_id+"/";
		}
		YAHOO.util.Connect.asyncRequest('POST', sUrl, "");

	}
	
	//相册default
	//leo 2009.3.23
	function default_gallery(gallery_id,product_id){

		var sUrl = webroot_dir+"products/update_default_gallery/"+gallery_id+"/"+product_id;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, default_gallery_callback);
	}
	
	
	var default_gallery_Success = function(o){
		
		if(o.responseText){
			var default_gallery_names = document.getElementsByName('default_gallery[]');
			for( var i=0;i<default_gallery_names.length;i++ ){
				default_gallery_names[i].style.display = "none";
			} 
			document.getElementById('default_gallery_'+o.responseText).style.display = "block";
			var default_gallery_img_names = document.getElementsByName('default_gallery_img[]');
			for( var i=0;i<img_id_arr.length;i++ ){
				document.getElementById(img_id_arr[i]).style.display = "block";
			} 
			document.getElementById('default_gallery_img_'+o.responseText).style.display = "none";	
		}else{
			alert('失败');
		}
	}

	var default_gallery_Failure = function(result){
		YAHOO.example.container.wait.hide();
	}

	var default_gallery_callback ={
		success:default_gallery_Success,
		failure:default_gallery_Failure,
		timeout : 3000,
		argument: {}
	};

/**
   * 新增一个规格
   */
  function addSpec(obj)
  {
      var src   = obj.parentNode.parentNode;
      var idx   = rowindex(src);
      var tbl   = document.getElementById('attrTable');
      var row   = tbl.insertRow(idx + 1);
      var cell1 = row.insertCell(-1);
      var cell2 = row.insertCell(-1);
      var regx  = /<a([^>]+)<\/a>/i;

      cell1.className = 'label';
      cell1.innerHTML = src.childNodes[0].innerHTML.replace(/(.*)(addSpec)(.*)(\[)(\+)/i, "$1removeSpec$3$4-");
      cell2.innerHTML = src.childNodes[1].innerHTML.replace(/readOnly([^\s|>]*)/i, '');
  }

  /**
   * 删除规格值
   */
  function removeSpec(obj)
  {
      var row = rowindex(obj.parentNode.parentNode);
      var tbl = document.getElementById('attrTable');

      tbl.deleteRow(row);
  }