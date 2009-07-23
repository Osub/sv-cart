//增加select项－－－关联商品
function addItem (source,target,all,act,linkedId,isDouble,Type)
  {
    var selOpt  = new Array();

    for (var i = 0; i < source.length; i ++ )
    {
      if (!source.options[i].selected && all == false) continue;

      if (target.length > 0)
      {
        var exsits = false;
        for (var j = 0; j < target.length; j ++ )
        {
          if (target.options[j].value == source.options[i].value)
          {
            exsits = true;
            break;
          }
        }

        if (!exsits)
        {
          selOpt[selOpt.length] = source.options[i].value;
        }
      }
      else
      {
        selOpt[selOpt.length] = source.options[i].value;
      }
    }
    if (selOpt.length > 0)
    {
      //ajax处理
        YAHOO.example.container.manager.hideAll();
       	set_wait(wait_message);
		YAHOO.example.container.wait.show();
		var sUrl = "/sv-admin/products/"+act+"/"+selOpt+"/"+linkedId+"/"+isDouble+"/"+target.id+"/"+Type+"/"+Math.random();
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, addDropItem_callback);
    }
  }
  	var addDropItem_Success = function(o){
		////alert(o.responseText);
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			//alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
//		alert(result.type)
		var sel = document.getElementById(result.targetObj);
//		 alert(sel);
	    sel.length = 0;
		if (result.msg){
             for (i = 0; i < result.msg.length; i++ ){
                  var opt = document.createElement("OPTION");
                      if(result.type == 'P'){
                            opt.value = result.msg[i]['ProductI18n'].product_id;
                            opt.text  = result.msg[i]['ProductI18n'].name;
                            opt.data  = '';
                            sel.options.add(opt);
                      }
                      else if(result.type == 'A'){
                      	    opt.value = result.msg[i]['Article'].id;
                            opt.text  = result.msg[i]['Article'].title;
                            opt.data  = '';
                            sel.options.add(opt);
                      }
              }
      // alert(sel);
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
	
	
	
//删除select项－－－关联商品
function dropItem (source,target,all,act,linkedId,isDouble,Type)
  {
    var arr = new Array();

    for (var i = target.length - 1; i >= 0 ; i -- )
    {
      if (target.options[i].selected || all)
      {
        arr[arr.length] = target.options[i].value;
      }
    }
    if (arr.length > 0)
    {
      //ajax处理
        YAHOO.example.container.manager.hideAll();
      	set_wait(wait_message);
		YAHOO.example.container.wait.show();
		var sUrl = admin_webroot+"products/"+act+"/"+arr+"/"+linkedId+"/"+isDouble+"/"+target.id+"/"+Type+"/"+Math.random();
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, addDropItem_callback);
    }
  }