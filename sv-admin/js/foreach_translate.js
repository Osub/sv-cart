	
	function update_lang_dictionarie(text,id,type,len){
		var sUrl = webroot_dir+"language_dictionaries/update_lang_dictionarie/";
		var postData = "value="+text.value+"&id="+id+"&type="+type+"&len="+len;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, update_lang_dictionarie_callback,postData);
	}
	
	var update_lang_dictionarie_Success = function(o){
		try{   

			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
		}
		var by_id = "lang_"+result.style+result.id;
		document.getElementById(by_id).innerHTML = result.message;
	}
	
	var update_lang_dictionarie_Failure = function(o){
		alert("error");
	}

	var update_lang_dictionarie_callback ={
		success:update_lang_dictionarie_Success,
		failure:update_lang_dictionarie_Failure,
		timeout : 10000,
		argument: {}
	};

	function go_input(id,value,type,len){
		var sUrl = webroot_dir+"language_dictionaries/go_input/";
		var postData = "id="+id+"&value="+value+"&type="+type+"&len="+len;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, go_input_callback, postData);
	}
	
	var go_input_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
		}
		var by_id = result.style+result.id;
		if(result.change_type == "select"){
			document.getElementById(by_id).innerHTML = result.type_message;
			focus_input("select");
		}else{
			document.getElementById(by_id).innerHTML = result.message;
			focus_input("input");
		}
	}
	
	var go_input_Failure = function(o){
		alert("error");
	}

	var go_input_callback ={
		success:go_input_Success,
		failure:go_input_Failure,
		timeout : 10000,
		argument: {}
	};
	
	function focus_input(type){
		document.getElementById(type).focus();
	}
	
	
	function go_select(id,value){
		var sUrl = webroot_dir+"language_dictionaries/go_select/";
		var postData = "id="+id+"&value="+value;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, go_select_callback, postData);
	}
	
	var go_select_Success = function(o){
	try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
		}
		document.getElementById(by_id).innerHTML = result.message;
		focus_input();
	}
	
	var go_select_Failure = function(o){
		alert("error");
	}

	var go_select_callback ={
		success:go_select_Success,
		failure:go_select_Failure,
		timeout : 10000,
		argument: {}
	};
	

	
	
	
	//字典表翻译
	function foreach_translate(){
		var value = document.getElementById('locale_value').value;
		if(value == ""){
			alert("内容不能为空");
			return;
		}
		var i=2;
		var google_translate_code = document.getElementById('google_translate_code').value;
		while(true){
			if(document.getElementById('foreach_local_name'+i)==null){
				break;
			}
			var foreach_local_name = document.getElementById('foreach_local_name'+i).value;
			var foreach_local_google = document.getElementById('foreach_local_google'+i).value;
			var foreach_local = document.getElementById('foreach_local'+i).value;

			YAHOO.example.container.wait_translate = new YAHOO.widget.Panel("wait_translate",{ width:"240px", fixedcenter:true, close:false, draggable:false, modal:true,visible:false,effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}});
			YAHOO.example.container.wait_translate.setHeader("请稍等，正在翻译成 "+foreach_local_name);
			YAHOO.example.container.wait_translate.setBody("<object id='loading' data='/img/loading.swf' type='application/x-shockwave-flash' width='220' height='19'><param name='movie' value='/img/loading.swf' /><param name='wmode' value='Opaque'></object>");
			YAHOO.example.container.wait_translate.render(document.body);
   			YAHOO.example.container.wait.show();
			translate(value,google_translate_code,foreach_local_google,foreach_local,foreach_local_name);
			YAHOO.example.container.wait.hide();
			i++;
 		}

	
	}
	
	function stop_translate(){
		var i=2;
		while(true){
			if(document.getElementById('foreach_local_name'+i)==null){
				break;
			}
			var foreach_local = document.getElementById('foreach_local'+i).value;
			var lang_value = foreach_local+"value";
			document.getElementById(lang_value).disabled = "";
		}
	}
	
	function translate(value,sl,google,locale,foreach_local_name){
		var sUrl = webroot_dir+"language_dictionaries/translate/";
		var postData = "sl="+sl+"&value="+value+"&google="+google+"&locale="+locale;
		var lang_value = locale+"value";
		document.getElementById(lang_value).value = "正在翻译 "+foreach_local_name;
		document.getElementById(lang_value).disabled = "true";
		
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, translate_callback,postData);
		
		}
		
	var translate_Success = function(o){
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){
			alert(o.responseText);
			alert("Invalid data");
		}
   		//YAHOO.example.container.wait_translate.hide();

		if(result.type == 0){
		//alert(o.responseText);
		/*
		
		for (i=0;i< result.num;i++)
		{
		//alert(result.locale[i]);
		var lang_value = result.locale[i]+"value"		
		document.getElementById(lang_value).value = result.value[i];
		}
*/		var lang_value = result.locale+"value";
		document.getElementById(lang_value).value = result.value;
		document.getElementById(lang_value).disabled = "";
		}else{
		//   YAHOO.example.container.wait_translate.hide();

			alert("fail");
		}
	}
	
	var translate_Failure = function(result){
		//YAHOO.example.container.wait_translate.hide();
		alert("error");
	}

	var translate_callback ={
		success:translate_Success,
		failure:translate_Failure,
		timeout : 30000,
		argument: {}
	};