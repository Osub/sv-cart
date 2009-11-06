<?php 
/*****************************************************************************
 * SV-Cart 商品图批量处理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 4717 2009-09-29 02:49:52Z zhengli $
*****************************************************************************/
?>
<?php echo $javascript->link('utils');?>	
<?php echo $javascript->link('listtable');?>
 <p class="none"><span id="show3">&nbsp;eee</span><span id="show4">&nbsp;</span></p>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/',"type"=>"get",'name'=>"SearchForm"));?>
	<dl>
	<dt><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd>
	货号：<input type="text" style="border:1px solid #649776" name="product_code" id="product_code" value="<?php echo @$product_code?>"/> 
	关键字：<input type="text" style="border:1px solid #649776" name="keywords" id="keywords" value="<?php echo @$keywords?>"/> 
	</dd>&nbsp
	<input type="button"  value="搜索" onclick="product_search();"/>
	<input type="button"  value="选择更新" onclick="update_img_select()" />
	<input type="button"  value="全部更新" onclick="update_img_all()" />
</dl>
<?php echo $form->end();?>

</div>
<br />
<!--Search End-->

<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."缩略图重新生成","/product_image_batchs/this_img_update/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' );">
<?php echo $form->create('',array('action'=>'/',"name"=>"ProForm","type"=>"POST",'onsubmit'=>"return false"));?>
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="6%"><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'checked />编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th width="10%">货号</th>
	<th width="30%">商品名称</th>
	<th width="44%">图片地址</th>
<?php if(isset($product_data) && sizeof($product_data)){?>
<?php foreach($product_data as $k=>$v){?>	
<tr <?php if((abs($k)+2)%2==1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><input type="checkbox" name="checkboxes[]" value="<?php echo $v['Product']['id']?>" checked /><?php echo $v['Product']['id']?></td>
	<td align="center"><?php echo $v['Product']['code']?></td>
	<td><?php echo $v['ProductI18n']['name']?></td>
	<td><?php echo $v['Product']['img_thumb']?></td>
</tr>
<?php }}?>
</table>
<div class="pagers" style="position:relative">
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<?php echo $form->end();?>
</div>

<!--Main Start End-->
</div>
<script>
function product_search(){
	var product_code = GetId("product_code");
	var keywords = GetId("keywords");
	var product_code_value = product_code.value;
	var keywords_value = keywords.value;
	if(product_code_value==""){
		product_code_value = "all";
	}
	if(keywords_value==""){
		keywords_value = "all";
	}
	window.location.href = webroot_dir+"product_image_batchs/index/"+product_code_value+"/"+keywords_value+"/";
}
</script>
<script tyep="text/javascript">
function update_img_select(){
	YAHOO.example.container.wait.show();
	var product_id_arr  = GetName("checkboxes[]");
	var product_id_str = "0";
	for( var i=0;i<product_id_arr.length;i++){
		if(product_id_arr[i].checked){
			product_id_str+="-"+product_id_arr[i].value;
		}
	}
	var product_code = GetId("product_code");
	var keywords = GetId("keywords");
	var product_code_value = product_code.value;
	var keywords_value = keywords.value;
	if(product_code_value==""){
		product_code_value = "all";
	}
	if(keywords_value==""){
		keywords_value = "all";
	}

	var sUrl		=	webroot_dir+"product_image_batchs/update_img/"+product_id_str+"/";
	
	var request 	= 	YAHOO.util.Connect.asyncRequest('POST', sUrl, update_img_select_callback);
}
var update_img_select_Success = function(o){
	var result = YAHOO.lang.JSON.parse(o.responseText);
	layer_dialog();
	layer_dialog_show(result.msg,"",4);
	YAHOO.example.container.wait.hide();
}

var update_img_select_Failure = function(o){
	alert("error");
	YAHOO.example.container.wait.hide();
}
var update_img_select_callback ={
	success:update_img_select_Success,
	failure:update_img_select_Failure,
	timeout : 300000000,
	argument: {}
};

function update_img_all(){
	var product_code = GetId("product_code");
	var keywords = GetId("keywords");
	var product_code_value = product_code.value;
	var keywords_value = keywords.value;
	if(product_code_value==""){
		product_code_value = "all";
	}
	if(keywords_value==""){
		keywords_value = "all";
	}
	window.location.href = webroot_dir+"product_image_batchs/index/"+product_code_value+"/"+keywords_value+"/"+"all/";
	
}
  
function update_database_img(number){
	
	var product_id_arr  = GetName("checkboxes[]");
	var product_id_str = "0";
	for( var i=0;i<product_id_arr.length;i++){
		product_id_str+="-"+product_id_arr[i].value;
	}
	var product_code = GetId("product_code");
	var keywords = GetId("keywords");
	var product_code_value = product_code.value;
	var keywords_value = keywords.value;
	if(product_code_value==""){
		product_code_value = "all";
	}
	if(keywords_value==""){
		keywords_value = "all";
	}
	
	if(product_id_arr.length>0){
		YAHOO.example.container.wait.show();
	}else{
		window.location.href = webroot_dir+"product_image_batchs/index/"+product_code_value+"/"+keywords_value+"/";
	}
	var sUrl		=	webroot_dir+"product_image_batchs/update_img/"+product_id_str+"/";
	var postData 	= "";
	var request 	= 	YAHOO.util.Connect.asyncRequest('POST', sUrl, update_database_img_callback,postData);
}
var update_database_img_Success = function(o){
	var result = YAHOO.lang.JSON.parse(o.responseText);
	var product_id_arr  = GetName("checkboxes[]");
	if(product_id_arr.length>0){
		window.location.reload();
	}else{
		YAHOO.example.container.wait.hide();
	}
}

var update_database_img_Failure = function(o){
	alert("error");
	YAHOO.example.container.wait.hide();
}
var update_database_img_callback ={
	success:update_database_img_Success,
	failure:update_database_img_Failure,
	timeout : 300000000,
	argument: {}
};
<?php if( $all_up_img == "all"){?>
window.onload = function(){
	update_database_img(20);
}
<?php }?>
</script>