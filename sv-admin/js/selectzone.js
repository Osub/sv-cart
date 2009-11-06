

//专题，关联商品
function add_relation_product(act,relation_id,source,type,isdouble){
	YAHOO.example.container.wait.show();
    for(var i=0;i < source.length;i++){
        if(!source.options[i].selected){
            continue;
        }
        product_id=source.options[i].value;
    }	
    if(type=="T"){
    	var sUrl = webroot_dir+"products/"+act+"/"+relation_id+"/"+product_id+"/"+type;
	}
	if(type=="A"){
    	var sUrl = webroot_dir+"products/"+act+"/"+relation_id+"/"+product_id+"/"+type+"/"+isdouble;
	}
	if(type=="P"){
    	var sUrl = webroot_dir+"products/"+act+"/"+relation_id+"/"+product_id+"/"+type+"/"+isdouble;
    
	}
	if(type=="PA"){
    	var sUrl = webroot_dir+"products/"+act+"/"+relation_id+"/"+product_id+"/"+type+"/"+isdouble;
    	
	}

	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, add_relation_product_callback);
}
//删除专题，文章 关联商品
function drop_relation_product(act,relation_id,product_id,type){
	YAHOO.example.container.wait.show();

    var sUrl = webroot_dir+"products/"+act+"/"+relation_id+"/"+product_id+"/"+type;

	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, add_relation_product_callback);
}
var add_relation_Success = function(o){
    try{
        var result=YAHOO.lang.JSON.parse(o.responseText);
    }
    catch(e){
        alert(o.responseText);
        YAHOO.example.container.wait.hide();
    }
    var newhtml='';
    var Objhtml=document.getElementById('target_select1');
    if(result.msg){
        for(i=0;i < result.msg.length;i++){
            if(result.type=='T'){
                var Objhtml=document.getElementById('target_select1');
                newhtml+="<p class='rel_list'><span class='handle'>排序:<span onclick='javascript:listTable.edit(this, \"products/update_orderby/T/\","+result.msg[i]['TopicProduct']['id']+")'>"+result.msg[i]['TopicProduct']['orderby']+"</span><img src='"+root_all+"sv-admin/img/delete1.gif' onMouseout='onMouseout_deleteimg(this);' onmouseover='onmouseover_deleteimg(this);' onclick=\"drop_relation_product('drop_link_topic_products',"+result.msg[i]['TopicProduct']['topic_id']+", "+result.msg[i]['TopicProduct']['product_id']+",'T');\"/></span>"+result.msg[i]['Product'].name+"</p>";
            }else if(result.type=='A'){
                var Objhtml=document.getElementById('target_select1');
                newhtml+="<p class='rel_list'><span class='handle'>排序:<span onclick='javascript:listTable.edit(this, \"products/update_orderby/A/\","+result.msg[i]['ProductArticle']['id']+")'>"+result.msg[i]['ProductArticle']['orderby']+"</span><img src='"+root_all+"sv-admin/img/delete1.gif' onMouseout='onMouseout_deleteimg(this);' onmouseover='onmouseover_deleteimg(this);' onclick=\"drop_relation_product('drop_link_article_products',"+result.msg[i]['ProductArticle']['article_id']+", "+result.msg[i]['ProductArticle']['product_id']+",'A');\"/></span>"+result.msg[i]['ProductI18n'].name+"</p>";
            }else if(result.type=='P'){
                var Objhtml=document.getElementById('target_select1');
                newhtml+="<p class='rel_list'><span class='handle'>排序:<span onclick='javascript:listTable.edit(this, \"products/update_orderby/P/\","+result.msg[i]['ProductRelation']['id']+")'>"+result.msg[i]['ProductRelation']['orderby']+"</span><img src='"+root_all+"sv-admin/img/delete1.gif' onMouseout='onMouseout_deleteimg(this);' onmouseover='onmouseover_deleteimg(this);' onclick=\"drop_relation_product('drop_link_products',"+result.msg[i]['ProductRelation']['product_id']+", "+result.msg[i]['ProductRelation']['related_product_id']+",'P');\"/></span>"+result.msg[i]['ProductI18n'].name+"</p>";
            }else if(result.type=='PA'){
                Objhtml=document.getElementById('target_select2');
                newhtml+="<p class='rel_list'><span class='handle'>排序:<span onclick='javascript:listTable.edit(this, \"products/update_orderby/PA/\","+result.msg[i]['ProductArticle']['id']+")'>"+result.msg[i]['ProductArticle']['orderby']+"</span><img src='"+root_all+"sv-admin/img/delete1.gif' onMouseout='onMouseout_deleteimg(this);' onmouseover='onmouseover_deleteimg(this);' onclick=\"drop_relation_product('drop_product_articles',"+result.msg[i]['ProductArticle']['product_id']+", "+result.msg[i]['ProductArticle']['article_id']+",'PA');\"/></span>"+result.msg[i]['Article'].title+"</p>";
            }
        }
        Objhtml.innerHTML=newhtml;
        newhtml="";
    }
    YAHOO.example.container.wait.hide();
}
	
var add_relation_Failure = function(o){
	alert("异步请求失败!");
	YAHOO.example.container.wait.hide();
}

var add_relation_product_callback ={
	success:add_relation_Success,
	failure:add_relation_Failure,
	timeout : 10000,
	argument: {}
};
function onMouseout_deleteimg(obj){
	obj.src=root_all+"sv-admin/img/delete1.gif"
}
function onmouseover_deleteimg(obj){
	obj.src=root_all+"sv-admin/img/delete2.gif"
}

//更新排序
function update_orderby(relation_id,sort,type){
	YAHOO.example.container.wait.show();
	var sUrl = webroot_dir+"products/update_orderby/"+relation_id+"/"+sort+"/"+type+"/";

	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, updateOrderby_callback);
}
var updateOrderby_Success = function(o){
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
