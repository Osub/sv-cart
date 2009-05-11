//增加select项－－－关联商品
function addItem (source,act,Id,isDouble,Type)
  {
    for (var i = 0; i < source.length; i ++ )
    {
    	if (!source.options[i].selected) continue;
      	  linkedId=source.options[i].value;
    }
    if (linkedId > 0)
    {
      //ajax处理
        YAHOO.example.container.manager.hideAll();
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"products/"+act+"/"+linkedId+"/"+Id+"/"+isDouble+"/"+Type+"/"+Math.random();
		
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, addDropItem_callback);
    }
  }
  	var addDropItem_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert(o.responseText);
			YAHOO.example.container.wait.hide();
		} 
	//	alert(result.msg)
		var newhtml='';
		var Objhtml=document.getElementById('target_select2');
        	if (result.msg){
                    for (i = 0; i < result.msg.length; i++ ){
                       if(result.type == 'P'){
                       	     var Objhtml=document.getElementById('target_select1');
                       	     newhtml +="<p class='rel_list'><span class='handle'>排序:<input onblur=\"update_orderby("+result.msg[i]['ProductRelation']['id']+",this.value,'P');\" size='2' value='"+ result.msg[i]['ProductRelation']['orderby']+"'>&nbsp;<input type='button' value='删除' onclick=\"dropItem("+result.msg[i]['ProductRelation']['related_product_id']+",'drop_link_products', "+result.msg[i]['ProductRelation']['product_id']+",1,'P');\"/></span>"+result.msg[i]['Product'].name+"</p>";
                       }
                       else if(result.type == 'A'){
                             var Objhtml=document.getElementById('target_select2');
                       	     newhtml +="<p class='rel_list'><span class='handle'>排序:<input onblur=\"update_orderby("+result.msg[i]['ProductArticle']['id']+",this.value,'A');\" size='2' value='"+ result.msg[i]['ProductArticle']['orderby']+"'>&nbsp;<input type='button' value='删除' onclick=\"dropItem("+result.msg[i]['ProductArticle']['article_id']+",'drop_product_articles', "+result.msg[i]['ProductArticle']['product_id']+", this.form.elements['is_single'][0].checked,'A');\"/></span>"+result.msg[i]['Article'].title+"</p>";
                       	
                       }
                   }
                   Objhtml.innerHTML=newhtml;
                   newhtml="";
         }
        YAHOO.example.container.wait.hide();
	}

	var addDropItem_Failure = function(result){
		YAHOO.example.container.wait.hide();
	}

	var addDropItem_callback ={
		success:addDropItem_Success,
		failure:addDropItem_Failure,
		timeout : 3000,
		argument: {}
	};
	
	//增加select项－－－专题关联商品
function addItem1 (source,act,Id,isDouble,Type)
  {
    for (var i = 0; i < source.length; i ++ )
    {
    	if (!source.options[i].selected) continue;
      	  linkedId=source.options[i].value;
    }
    if (linkedId > 0)
    {
      //ajax处理
        YAHOO.example.container.manager.hideAll();
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"products/"+act+"/"+linkedId+"/"+Id+"/"+isDouble+"/"+Type+"/"+Math.random();
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, addDropItem1_callback);
    }
  }
  	var addDropItem1_Success = function(o){

		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
	//	alert(result.msg)
		var newhtml='';
		var Objhtml=document.getElementById('target_select1');
        if (result.msg){
			for (i = 0; i < result.msg.length; i++ ){
				if(result.type == 'P'){
					var Objhtml=document.getElementById('target_select1');
					newhtml +="<p class='rel_list'><span class='handle'><input size='2' value='"+ result.msg[i]['TopicProduct']['orderby']+"'>&nbsp;<input type='button' value='删除' onclick=dropItem1("+result.msg[i]['TopicProduct']['product_id']+",'drop_link_topic_products',"+result.msg[i]['TopicProduct']['topic_id']+",'P') /></span>"+result.msg[i]['Product'].name+"</p>";
				}else if(result.type == 'A'){
					var Objhtml=document.getElementById('target_select1');
					newhtml +="<p class='rel_list'><span class='handle'><input size='2' value='"+ result.msg[i]['ProductArticle']['orderby']+"'>&nbsp;<input type='button' value='删除' onclick=dropItem1("+result.msg[i]['ProductArticle']['product_id']+",'drop_link_article_products',"+result.msg[i]['ProductArticle']['article_id']+",'A') /></span>"+result.msg[i]['Product'].name+"</p>";
                
				}
			}
			Objhtml.innerHTML=newhtml;
         }
        YAHOO.example.container.wait.hide();
	}

	var addDropItem1_Failure = function(result){
		YAHOO.example.container.wait.hide();
	}

	var addDropItem1_callback ={
		success:addDropItem1_Success,
		failure:addDropItem1_Failure,
		timeout : 3000,
		argument: {}
	};
	
//删除select项－－－关联商品
function dropItem (dropId,act,Id,isDouble,Type)
  {
    if (dropId > 0)
    {
      //ajax处理
        YAHOO.example.container.manager.hideAll();
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"products/"+act+"/"+dropId+"/"+Id+"/"+isDouble+"/"+Type+"/"+Math.random();
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, addDropItem_callback);
    }
  }

  //删除select项－－－专题关联商品
function dropItem1 (dropId,act,Id,Type)
  {
    if (dropId > 0)
    {
      //ajax处理
        YAHOO.example.container.manager.hideAll();
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"products/"+act+"/"+dropId+"/"+Id+"/"+Type+"/"+Math.random();
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, addDropItem1_callback);
    }
  }