
var oTextNodeMap = {};//增节点
var oCurrentTextNode = null;//取节点对像
/***********************每次点击创造节点start**********************************************************/
function loadNodeData(node, fnLoadComplete){
	var path = "";///
	var leafNode = node;
	//取当前节点和父节点
	while (!leafNode.isRoot()) {       
		path = "/"+leafNode.label+path  ;        
		leafNode = leafNode.parent;    
	}
	//商品货号定位时取全部货号
	if( assign_dir == "products" ){
		path = "/products"+path;
	}
	if( assign_dir == "product_categories" ){
		path = "/product_categories"+path;
	}
	if( assign_dir == "article_categories" ){
		path = "/article_categories"+path;
	}
	document.getElementById('img_address').value = path;//设置目录参数
	img_addr = path;

	var sUrl = webroot_dir+"images/treeview/?path="+path;
	swf_upload_addr();//创建SESSION上传图片
	var callback = {
		success: function(oResponse){
			var oResults = eval("(" + oResponse.responseText + ")");
				if(YAHOO.lang.isArray(oResults.message)) {
					for (var i=0, j=oResults.message.length; i<j; i++) {
						tempNode = new YAHOO.widget.MenuNode(oResults.message[i], node, false);//创建节点目录
						tempNode.onLabelClick = load_show_img;//创建节点onlcik事件
						tempNode.editable = true;//增编节点
						oTextNodeMap[tempNode.labelElId]=tempNode;//增节点
					}
				} else {
					tempNode = new YAHOO.widget.MenuNode(oResults.message, node, false);//创建节点目录
					tempNode.onLabelClick = load_show_img;//创建节点onlcik事件
					tempNode.editable = true;//增编节点
					oTextNodeMap[tempNode.labelElId]=tempNode;//增节点
				}
 				oResponse.argument.fnLoadComplete(); 
		},
		failure: function(oResponse){
			alert("异步请求失败!");
		},
		argument: {
			"node": node,
			"fnLoadComplete": fnLoadComplete
		},
		timeout: 7000
	};
	YAHOO.util.Connect.asyncRequest('GET', sUrl, callback);
}

/***********************init调用的第一个函数**********************************************************/
function buildTree(){
	//商品页货号定位
	if(window_option_status != ""){
		
		if(assign_dir == "products"){
			var productcode = "/products/&dirname="+window.opener.document.getElementById('ProductCode').value;
			img_addr = "/products/"+window.opener.document.getElementById('ProductCode').value;
			//alert(img_addr);
			var urlimg = webroot_dir+"images/treeview/?path="+img_addr;
			YAHOO.util.Connect.asyncRequest('POST', urlimg, load_show_img_callback);
		}else{
			var productcode = "";
		}
		

		if(assign_dir =="product_categories"){
			var productcode = "/product_categories/&dirname="+window.opener.document.getElementById('categoryid').value;
			img_addr = "/product_categories/"+window.opener.document.getElementById('categoryid').value+"&product_categories_id="+window.opener.document.getElementById('categoryid').value;
			var urlimg = webroot_dir+"images/treeview/?path="+img_addr;
			YAHOO.util.Connect.asyncRequest('POST', urlimg, load_show_img_callback);
			img_addr = "/product_categories/"+window.opener.document.getElementById('categoryid').value;
		}
	
		if(assign_dir =="article_categories"){
			
			var productcode = "/article_categories/&dirname="+window.opener.document.getElementById('categoryid').value;
			img_addr = "/article_categories/"+window.opener.document.getElementById('categoryid').value+"&article_categories_id="+window.opener.document.getElementById('categoryid').value;
			var urlimg = webroot_dir+"images/treeview/?path="+img_addr;
			YAHOO.util.Connect.asyncRequest('POST', urlimg, load_show_img_callback);
			img_addr = "/article_categories/"+window.opener.document.getElementById('categoryid').value;
			
		}
		if(assign_dir =="links"){
			img_addr = "/links/";
			var urlimg = webroot_dir+"images/treeview/?path="+img_addr;
			YAHOO.util.Connect.asyncRequest('POST', urlimg, load_show_img_callback);
			
		}
	}else{
		var productcode = "";
	}
	swfuploadimg();//创建上传图片按钮
	//商品页end 
	var urlimg = webroot_dir+"images/treeview/?path="+productcode;
	YAHOO.util.Connect.asyncRequest('POST', urlimg, root_directory_callback);
}

/***********************取文件夹第一层菜单并设置成为中文start**********************************************************/
	var root_directory_Success = function(oResponse){
		
		var oResults = eval("(" + oResponse.responseText + ")");
		tree = new YAHOO.widget.TreeView("treeDiv1");//取节点对像
		tree.setDynamicLoad(loadNodeData);//load加载事件
		var root = tree.getRoot();//取节点位置
		
		var tempNode 									= 		new Array();//第一层各节点原名
		var china_dir_name								=		img_dir_china_config();//调用中文设置函数
		
		//创造节点
		for(var i=0;i<=oResults.message.length-1; i++){
			var name 									=  		oResults.message[i];//取各节点的名称
			
			//跟据菜单创造指定目录
			if( assign_dir != "" ){
				//创造指定
				if( name == assign_dir ){
					tempNode[i] 						= 		new YAHOO.widget.MenuNode(name, root, false); 
					tempNode[i].onLabelClick 			= 		load_show_img;//节点ONCLICK事件..重载图片
					tempNode.editable 					= 		true;//增编节点
					oTextNodeMap[tempNode[i].labelElId]	=		tempNode[i];//增节点
	   			}
	   			//商品定位在货号目录
	   			if(window_option_status != ""){
					if(assign_dir == "products"){
			   			if( name == Trim(window.opener.document.getElementById('ProductCode').value,'g') ){
							tempNode[i] 				= 		new YAHOO.widget.MenuNode(name, root, false); 
							tempNode[i].onLabelClick 	= 		load_show_img;//节点ONCLICK事件..重载图片
							tempNode[i].editable 		= 		true;//增编节点
							oTextNodeMap[tempNode[i].labelElId]=tempNode[i];//增节点
			   			}
	   				}
	   				if(assign_dir == "product_categories"){
			   			if( name == Trim(window.opener.document.getElementById('categoryid').value,'g') ){
			   				
							tempNode[i] 				= 		new YAHOO.widget.MenuNode(name, root, false); 
							tempNode[i].onLabelClick 	= 		load_show_img;//节点ONCLICK事件..重载图片
							tempNode[i].editable 		= 		true;//增编节点
							oTextNodeMap[tempNode[i].labelElId]=tempNode[i];//增节点
			   			}
			   			
	   				}
	   				if(assign_dir == "article_categories"){
			   			if( name == Trim(window.opener.document.getElementById('categoryid').value,'g') ){
			   				
							tempNode[i] 				= 		new YAHOO.widget.MenuNode(name, root, false); 
							tempNode[i].onLabelClick 	= 		load_show_img;//节点ONCLICK事件..重载图片
							tempNode[i].editable 		= 		true;//增编节点
							oTextNodeMap[tempNode[i].labelElId]=tempNode[i];//增节点
			   			}
			   			
	   				}
	   			}
	   		}else{
	   			//图片管理时创造全部节点
	   			tempNode[i] 							= 		new YAHOO.widget.MenuNode(name, root, false); 
				tempNode[i].onLabelClick 				= 		load_show_img;//节点ONCLICK事件..重载图片
				tempNode[i].editable 					= 		true;//增编节点
				oTextNodeMap[tempNode[i].labelElId]		=		tempNode[i];//增节点
	   		}
	   	}
		tree.draw();//显示创造出来的节点
		
		//第一层菜单设置中文名称
		//除商品页进入外其它创造中文节点
		if( assign_dir != "products" && assign_dir != "product_categories"&& assign_dir != "article_categories"){
			for(var j=0;j<=oResults.message.length-1; j++){
				
				
				if( tempNode[j]){
					var tempnode 						=  		tempNode[j];
					var tempnode_name 					= 		tempnode.label;
					tempnode.getLabelEl().innerHTML 	= 		china_dir_name[tempnode_name];//根椐对应节点替换成中文
				}else{
					//tempnode.getLabelEl().innerHTML 	= 		"未知";//根椐对应节点替换成中文
				}
			}
		} 
	}
	var root_directory_Failure = function(o){
		alert("异步请求失败");
	}

	var root_directory_callback ={success:root_directory_Success,failure:root_directory_Failure,timeout : 10000,argument: {}};
	

var init=function(){  
	//左边树形结构
	buildTree();
}

//图片加载start
function load_show_img(node){
	var path = "";
	swf_upload_addr();//创建SESSION上传图片
	//取当前节点和父节点
	while (!node.isRoot()) {
		path = "/"+node.label+path  ;
		node = node.parent;
	}
	if( assign_dir == "products" ){
		path = "/products"+path;
	}
	if( assign_dir == "product_categories" ){
		path = "/product_categories"+path;
	}
	if( assign_dir == "article_categories" ){
		path = "/article_categories"+path;
	}
	img_addr = path;//SWF上传图片的路径

	document.getElementById('img_address').value = path;//设置目录参数
	var urlimg = webroot_dir+"images/treeview/?path="+path;
	YAHOO.util.Connect.asyncRequest('POST', urlimg, load_show_img_callback);
}
//图片加载回传
var load_show_img_Success = function(oResponse){
		var oResults = eval("(" + oResponse.responseText + ")");
	            var created_img = document.getElementById('preServerData');
	            created_img.innerHTML = "";
	            if(oResults.show_img_str){
	            	created_img.innerHTML = oResults.show_img_str;
	            }
        YAHOO.example.container.wait.hide();
	}

	var load_show_img_Failure = function(o){
		alert("异步请求失败");
	}

	var load_show_img_callback ={
		success:load_show_img_Success,
		failure:load_show_img_Failure,
		timeout : 10000,
		argument: {}
	};
//图片加载end
YAHOO.util.Event.onDOMReady(init);

//左菜单鼠标右键事件
/***********************新增节点******************************************************************/
function showPanel2(){//调用层方法输入框
	big_panel.show();
	document.getElementById("img_dir_comfirm").href = "javascript:addNode();big_panel.hide();";//设置层确定按钮事件
}
function addNode(){
	var sLabel = document.getElementById('img_dir_name').value;
		if (sLabel && sLabel.length > 0) {
			oChildNode = new YAHOO.widget.MenuNode(sLabel, oCurrentTextNode, false);//创造节点
			oChildNode.editable = true;//编辑节点条件
			oTextNodeMap[oChildNode.labelElId]=oChildNode;//编辑节点条件
			oChildNode.onLabelClick = load_show_img;//节点ONCLICK事件
			oCurrentTextNode.refresh();//刷新节点
			oCurrentTextNode.expand();
			var path = "";   
			var leafNode = oCurrentTextNode;
			//取当前节点和父节点
			while (!leafNode.isRoot()) {       
				path = "/"+leafNode.label+path  ;        
				leafNode = leafNode.parent;    
			}
			document.getElementById('img_address').value = path+"/"+sLabel;//设置目录地址
			//商品页
			if(window_option_status != ""){
				if(window.opener.document.getElementById('assign_dir').value == "products"){
					path = "/products"+path;
				}
				if(window.opener.document.getElementById('assign_dir').value == "product_categories"){
					path = "/product_categories"+path;
				}
				if(window.opener.document.getElementById('assign_dir').value == "article_categories"){
					path = "/article_categories"+path;
				}
	   		}
			var create_dir = webroot_dir+"images/create_dir/?path="+path+"/"+sLabel;
			YAHOO.util.Connect.asyncRequest('POST', create_dir, "");
			oTextNodeMap[oChildNode.labelElId] = oChildNode;//节点编缉
		}
	
		img_addr = path+"/"+sLabel+"/";
		swf_upload_addr();
}
/***********************编辑节点******************************************************************/
function showPanel3(){//调用层方法输入框
	big_panel.show();
	document.getElementById("img_dir_comfirm").href = "javascript:editNodeLabel();big_panel.hide();";//设置层确定按钮事件
}
function editNodeLabel() {
	var sLabel =  document.getElementById('img_dir_name').value; 
	if (sLabel && sLabel.length > 0) {
		oCurrentTextNode.getLabelEl().innerHTML = sLabel;
		oCurrentTextNode.refresh();//刷新节点
		oCurrentTextNode.expand();
		var path = "";   
		var leafNode = oCurrentTextNode;
		var new_name = sLabel;
		
		//取当前节点和父节点
		while (!leafNode.isRoot()) {       
			path 			= "/"+leafNode.label+path  ;        
			leafNode	 	= leafNode.parent;    
		}
		//商品页
		if(window_option_status != ""){
			if(window.opener.document.getElementById('assign_dir').value == "products"){
				path = "/products"+path;
			}
	   	}
	   	//设置要重命名的路径
		var new_src = "";
		var src_arr = path.split("/");
		for(var i=0;i<src_arr.length-1;i++){
			new_src+= src_arr[i]+"/";
		}
		new_src = new_src+new_name;
		//end
		document.getElementById('img_address').value = new_src;
		swf_upload_addr();
		var raname_dir = webroot_dir+"images/rename/?old_name=/img"+path+"&new_name=/img"+new_src;
		//alert(raname_dir);
		YAHOO.util.Connect.asyncRequest('POST',raname_dir, "");
	}
}

/***********************删除节点******************************************************************/
function deleteNode() {
	delete oTextNodeMap[oCurrentTextNode.labelElId];//删除节点
	var path = "";   
	var leafNode = oCurrentTextNode;
	//取当前节点和父节点
	while (!leafNode.isRoot()) {       
		path = "/"+leafNode.label+path  ;        
		leafNode = leafNode.parent;    
	}
	//设置要删除目录的路径
	var new_src = "";
	var src_arr = path.split("/");
	for(var i=0;i<src_arr.length-1;i++){
		new_src+= src_arr[i]+"/";
	}
	//end
	document.getElementById('img_address').value = new_src;
	var dir_src = webroot_dir+"images/del_dir/?dir_src="+new_src+oCurrentTextNode.label;
	YAHOO.util.Connect.asyncRequest('POST',dir_src, "");
	tree.removeNode(oCurrentTextNode);
	tree.draw();
}
/***********************节点刷新****************************************************************/
function refresh(){
	if(oCurrentTextNode.children.length){
		tree.removeChildren(oCurrentTextNode);              
		var t=setInterval(
			function(){
				if(!oCurrentTextNode.children.length){
					clearInterval(t);
					tree.unsubscribe("animComplete");
					setTimeout(function(){oCurrentTextNode.expand()},200);                      
					return;
	            }
		    },200);
	}else{
		oCurrentTextNode.expand();
	}
}
/***********************菜单右键选项******************************************************************/

var oContextMenu = new YAHOO.widget.ContextMenu("mytreecontextmenu", {
	trigger: "treeDiv1",
	lazyload: true, 
	itemdata: [
	{ text: "刷新",classname:"refresh",onclick:{fn:refresh}},
	{ text: "新增目录", onclick: { fn: showPanel2 } },
	{ text: "编辑目录", onclick: { fn: showPanel3 } },
																
	{ text: "删除目录", onclick: { fn: deleteNode } }
	] });
	      
	     
function onTriggerContextMenu(p_oEvent) {
	var oTarget = this.contextEventTarget,
	Dom = YAHOO.util.Dom;
	var oTextNode = Dom.hasClass(oTarget, "ygtvlabel") ? 
	oTarget : Dom.getAncestorByClassName(oTarget, "ygtvlabel");
	if (oTextNode) {
		oCurrentTextNode = oTextNodeMap[oTarget.id];
	}else{
		this.cancel();
	}
}
	oContextMenu.subscribe("triggerContextMenu", onTriggerContextMenu);
/***********************菜单右键选项end******************************************************************/

/***********************改图片名***************************************************************/
var image_obj = "";
function mkname(obj){
	image_obj = obj;
	var image_name = obj.innerHTML;
	obj.innerHTML = "<input type='text' value='"+image_name+"' style='ime-mode:disabled;background: #E3E3DF ;' onblur='mkname_back(this)' >";
	
}
function mkname_back(obj_input){

	var new_src  		= "";
	var old_name  		= image_obj.name;
	var src_arr = old_name.split("/");
	for(var i=0;i<src_arr.length-1;i++){
			new_src+= src_arr[i]+"/";
	}
	var new_name 	= new_src+obj_input.value;
	image_obj.name 	= new_name;
	var rechristen_url= webroot_dir+"images/rename/?old_name="+old_name+"&new_name="+new_name;
	YAHOO.util.Connect.asyncRequest('POST',rechristen_url,"");
	image_obj.innerHTML = obj_input.value;
}
//end
/***********************节点中文设置函数**************************************************/
function img_dir_china_config(){
	var china_dir_name 								= new Object();//第一层中文名
	china_dir_name.home 							= "首页";
	china_dir_name.products 						= "产品";
	china_dir_name.product_categories    			= "商品分类";
	china_dir_name.article_categories	    		= "文章分类";
	china_dir_name.brands   						= "品牌";
	china_dir_name.articles 						= "文章";
	china_dir_name.cards    						= "贺卡";
	china_dir_name.packs     						= "包装";
	china_dir_name.topics  	    					= "专题";
	china_dir_name.links	 						= "友情链接";
	china_dir_name.others	 						= "其他";
	

	return china_dir_name;
}


/***********************图片显示隐藏**************************************************/

function img_is_show(obj){
	var img_show = document.getElementById('img_show');
	var img_hide = document.getElementById('img_hide');
	var img_hide_show_obj = document.getElementsByName('img_hide_show[]'); 
	if(img_show.style.display == "none"){
		img_show.style.display = "block";
		img_hide.style.display = "none";
		for( var i=0;i<=img_hide_show_obj.length;i++){
			img_hide_show_obj[i].style.display = "none";
		}

	}else{
		img_show.style.display = "none";
		img_hide.style.display = "block";
		for( var i=0;i<=img_hide_show_obj.length;i++){
			img_hide_show_obj[i].style.display = "block";
		}
	}
}

//删除图片
var image_src;
function remove_img(result){
	var img_hide_show		= document.getElementsByName('img_hide_show[]');
	var img_src				= result.value;
	image_src			= document.getElementById('img_address').value;
	//alert(img_src);
	var arr = img_src.split('/');
	if(confirm("确定删除图片"+arr[arr.length-1]+"?")){
		YAHOO.example.container.wait.show();
		var sUrls = webroot_dir+"images/remove_img/?img_src="+img_src;
		
		YAHOO.util.Connect.asyncRequest('POST', sUrls, load_show_remove_img_callback);//AJAX删除图片
		
	}

	
}
//图片加载回传
var load_show_remove_img_Success = function(oResponse){
		var urlimg = webroot_dir+"images/treeview/?path="+image_src;
        YAHOO.util.Connect.asyncRequest('POST', urlimg, load_show_img_callback);//重载图片
	}

	var load_show_remove_img_Failure = function(o){
		alert("异步请求失败");
	} //

	var load_show_remove_img_callback ={
		success:load_show_remove_img_Success,
		failure:load_show_remove_img_Failure,
		timeout : 10000,
		argument: {}
	};
	
