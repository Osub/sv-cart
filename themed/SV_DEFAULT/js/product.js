//删除相册图片
function dropImg(ImgId){
        YAHOO.example.container.manager.hideAll();
       	set_wait(wait_message);
	    YAHOO.example.container.wait.show();	
		var sUrl = admin_webroot+"products/drop_img/"+ImgId;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, dropImg_callback);
		}
		
		var dropImg_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			//alert("Invalid data");
		}
		createDIV("dropImg_ok");
		if(YAHOO.example.container.dropImg_ok)
			YAHOO.example.container.dropImg_ok.destroy();
		document.getElementById('dropImg_ok').innerHTML = result.content;
		document.getElementById('dropImg_ok').style.display = '';

		YAHOO.example.container.dropImg_ok = new YAHOO.widget.Panel("dropImg_ok", { 
																		xy:[700,500],
																		fixedcenter:true,
																		draggable:false,
																		modal:true,
																		visible:false,
																		width:"424px",
																		zIndex:1000,
																		effect:{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.5}
																	} 
															);	
															
		var close_dropImg_ok = new YAHOO.util.KeyListener(document, { keys:27 },  							
													  { fn:YAHOO.example.container.dropImg_ok.hide,
														scope:YAHOO.example.container.dropImg_ok,
														correctScope:true }, "keyup" ); 
	 
		YAHOO.example.container.dropImg_ok.cfg.queueProperty("keylisteners", close_dropImg_ok);
		YAHOO.example.container.dropImg_ok.render();
		YAHOO.example.container.manager.register(YAHOO.example.container.dropImg_ok);
		YAHOO.example.container.dropImg_ok.show();	
		YAHOO.example.container.wait.hide();
     }

	var dropImg_Failure = function(o){
		alert("error");
	}

	var dropImg_callback ={
		success:dropImg_Success,
		failure:dropImg_Failure,
		timeout : 10000,
		argument: {}
	};

//搜索文章
function searchArticles(){
        var Article_keywords=document.getElementById('keywords_id').value;
        var Article_cat=document.getElementById('article_cat').value;
		var sUrl = admin_webroot+"articles/searcharticles/"+Article_keywords+"/"+Article_cat;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, searchArticles_callback);
	}

	var searchArticles_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			//alert("Invalid data");
		}
		 var sel = document.getElementById('source_select2');
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
		var sUrl = admin_webroot+"products/searchproducts/"+keywords+"/"+catId+"/"+brandId;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, searchProducts_callback);
	}

	var searchProducts_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			//alert("Invalid data");
		}
		 var sel = document.getElementById('source_select1');
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
function addOtherCat(conObj){
     var sel = document.createElement("SELECT");
      var selCat = document.forms['thisForm'].elements['ProductsCategory'];

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
      conObj.appendChild(sel);
      sel.name = "other_cat[]";
      sel.onChange = function() {checkIsLeaf(this);};
  }