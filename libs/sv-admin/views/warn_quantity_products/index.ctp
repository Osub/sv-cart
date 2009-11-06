<?php 
/*****************************************************************************
 * SV-Cart 商品管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3627 2009-08-13 09:43:45Z zhengli $
*****************************************************************************/
?>
 <p class="none"><span id="show3">&nbsp;eee</span><span id="show4">&nbsp;</span></p>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/',"type"=>"get",'name'=>"SearchForm"));?>
	<dl>
	<dt><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p>
	<?php if(!empty($categories_tree)){?>
	<select class="all" name="category_id" id="category_id">
	<option value="0">所有分类</option>
	<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
	<option value="<?php echo $first_v['Category']['id'];?>" <?php if($category_id == $first_v['Category']['id']){?>selected<?php }?>><?php echo $first_v['CategoryI18n']['name'];?></option>
		<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
		<option value="<?php echo $second_v['Category']['id'];?>" <?php if($category_id == $second_v['Category']['id']){?>selected<?php }?>>&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
			<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
			<option value="<?php echo $third_v['Category']['id'];?>" <?php if($category_id == $third_v['Category']['id']){?>selected<?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
	<?php }}}}}}?>
	</select>
	<select name="forsale">
		<option value="99" selected >所有商品</option>
		<option value="1" <?php if($forsale==1){?>selected<?php }?> >上架</option>
		<option value="0" <?php if($forsale==0){?>selected<?php }?> >下架</option>
	</select>
		<?php }?>
	价格区间：<input name="min_price" id="min_price" value="<?php echo @$min_price?>" size=15>－<input name="max_price" id="max_price" value="<?php echo $max_price?>" size=15>
	关键字：<input type="text" style="width:105px;" name="keywords" id="keywords" value="<?php echo @$keywords?>"/></p>
	<p>
	<?php if(!empty($brands_tree)){?>
	<select class="all" name="brand_id" id="brand_id">
	<option value="0">所有品牌</option>
	<?php if(isset($brands_tree) && sizeof($brands_tree)>0){?>
	<?php foreach($brands_tree as $k=>$v){?>
	  <option value="<?php echo $v['Brand']['id']?>" <?php if($brand_id == $v['Brand']['id']){?>selected<?php }?>><?php echo $v['BrandI18n']['name']?></option>
	<?php }}?>
	</select>
	<?php }?>
	
	<?php if(!empty($types_tree)){?>
	<select name="type_id" id="type_id">
	<option value="0">所有类型</option>
	<?php if(isset($types_tree) && sizeof($types_tree)>0){?>
	<?php foreach($types_tree as $k=>$v){?>
	  <option value="<?php echo $v['ProductType']['id']?>" <?php if($type_id == $v['ProductType']['id']){?>selected<?php }?>><?php echo $v['ProductType']['name']?></option>
	<?php }}?>
	</select> 
	<?php }?>
	&nbsp;&nbsp;推荐：<select name="is_recommond">
	<option value="-1">所有</option>
	<option value="0" <?php if($is_recommond == 0){?>selected<?php }?>>非推荐商品</option>
	<option value="1" <?php if($is_recommond == 1){?>selected<?php }?>>推荐商品</option>
	</select>
	
	<?php if(!empty($provides_tree)){?>
	<select class="all" name="provider_id">
	<option value="-1">所有供应商</option>
	<?php if(isset($provides_tree) && sizeof($provides_tree)>0){?>
	<?php foreach($provides_tree as $k=>$v){?>
	   <option value="<?php echo $v['Provider']['id']?>" <?php if($provider_id == $v['Provider']['id']){?>selected<?php }?>><?php echo $v['Provider']['name']?></option>
	<?php }}?>
	</select>
	<?php }?>
	添加时间：<input type="text" id="date" style="border:1px solid #649776" name="date" value="<?php echo @$date?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
		<input type="text" id="date2"  style="border:1px solid #649776" name="date2" value="<?php echo @$date2?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
	</p>
	</dd>
	<dt class="big_search" style="padding-top:13px;">
		<input type="button" class="big" value="搜索" onclick="search_act()" />
 		<input type="button" value="导出"   class="big"  onclick="export_act()" />
 		</dt>

	</dl><?php echo $form->end();?>


</div>
<br />
<!--Search End-->
<!--时间控件层start-->
	<div id="container_cal" class="calender_2"> 
		<div class="hd">日历</div>
		<div class="bd"><div id="cal"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal2" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal2"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal3" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal3"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal4" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal4"></div><div style="clear:both;"></div></div>
	</div>

<!--end-->

<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."商品管理","/products/",
'',false,false);?></strong></p>

<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' );">
<?php echo $form->create('',array('action'=>'/',"name"=>"ProForm","type"=>"POST",'onsubmit'=>"return false"));?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="6%">编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th>商品名称</th>
	<th width="12%">货号</th>
	<th width="8%"><?php echo $html->link('库存','/warn_quantity_products/index/0/number/'.$asc_desc,array(),false,false);?> <?php if($orderby=="number"){if($asc_desc=="desc"){echo $html->image("sort_desc_up.gif");}else{echo $html->image("sort_desc.gif");}}?></th>
	<th width="8%">警告库存数</th>
	<th width="8%">价格</th>
	<th width="8%">上架</th>
	<th width="8%">推荐</th>
	<th width="8%">操作</th></tr>
<?php if(isset($products_list) && sizeof($products_list)){?>
<?php foreach($products_list as $k=>$v){?>	
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center"><?php echo $v['Product']['id']?></td>
	<td><?php echo $html->link($v['ProductI18n']['name'],$server_host.$cart_webroot."products/".$v['Product']['id'],array('target'=>'_blank'));?>
	</li>
	<td align="center"><?php echo $v['Product']['code']?></td>
	<td align="center"><?php echo $v['Product']['quantity']?></td>
	<td align="center"><?php echo $v['Product']['warn_quantity']?></td>
	<td align="center"><?php echo $v['Product']['shop_price']?></td>
	<td align="center"><?php if($v['Product']['forsale'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{?><?php echo $html->image('no.gif')?><?php }?></td>
	<td align="center"><?php if($v['Product']['recommand_flag'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{?><?php echo $html->image('no.gif')?><?php }?></td>
	<td align="center"><?php echo $html->link("查看",$server_host.$cart_webroot."products/".$v['Product']['id'],array('target'=>'_blank'));?>
	</td></tr>
<?php }}?>
</table></div>
<div class="pagers" style="position:relative">
 
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<?php echo $form->end();?>
</div>
<!--Main Start End-->
</div>


<script>
function diachange(){
	var a=document.getElementById("act_type");
	if(a.value!='0'){
		for(var j=0;j<a.options.length;j++){
			if(a.options[j].selected){
				var vals = a.options[j].text ;
			}
		}
		layer_dialog_show('确定'+vals+'?','operate_select()',5);
	}
}

function operate_change(){
var a=document.getElementById("act_type").value;
			if(a=="del"){
				document.getElementById("category_div").style.display="none";
				document.getElementById("category_change").value='0';	
			//	operate_select();				
			}
			if(a=="category"){
				document.getElementById("category_div").style.display="inline";
			//	operate_select();
			}
			if(a=="0"){
				document.getElementById("category_div").style.display="none";
				document.getElementById("category_change").value='0';	
			}
					
}

function batch_action() 
{ 
	document.ProForm.action=webroot_dir+"products/batch";
	document.ProForm.onsubmit= "";
	document.ProForm.submit(); 
}



function operate_select(){//删除
	var id=document.getElementsByName('checkboxes[]');
	var op=document.getElementById("act_type").value;
	var i;
	var j=0;
	var image="";
	for( i=0;i<=parseInt(id.length)-1;i++ ){
		if(id[i].checked){
			j++;
		}
	}
	if( j<1 ){
		return false;
	}else{
		var k=document.getElementById("category_change").value;
		if(op=="del"){
			batch_action();
		};	
		if(op=="category"){
			if(k=="0"){
				return false;
			}else{
				batch_action();
			}
		}	
	}
}

function search_act(){ 
	document.SearchForm.action=webroot_dir+"warn_quantity_products/index";
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit(); 
}

function export_act(){ 
//	var url=document.getElementById("url").value;
//	window.location.href=webroot_dir+url;
	document.SearchForm.action=webroot_dir+"warn_quantity_products/index/export";
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit(); 
}


/*重新计算冻结数*/
//冻结数确认
function confirm_num(){
	var sUrl = webroot_dir+"products/recalcul_frozen_quantity";
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_num_callback);	
}
var confirm_num_Success = function(o){
	if(o.responseText){
		document.getElementById('num_confirm').style.display = "block";
		document.getElementById('num_text').style.display = "none";
	}
}

var confirm_num_Failure = function(o){
	//alert("error");
}

var confirm_num_callback ={
	success:confirm_num_Success,
	failure:confirm_num_Failure,
	timeout : 10000,	
	argument: {}	
};	
//修改密码对话框	
function amend_num(){
	document.getElementById('amend_num').style.display = "block";
	document.getElementById('num_text').style.display = "block";
	document.getElementById('num_confirm').style.display = "none";
	num_big_panel.show();
}
//遮罩层JS	
function initPage_num(){
	tabView = new YAHOO.widget.TabView('contextPane');
    num_big_panel = new YAHOO.widget.Panel("amend_num",
						{
							visible:false,
							draggable:false,
							modal:true,
							style:"margin 0 auto",
							fixedcenter: true
						} 
					); 
	num_big_panel.render();
}
initPage_num();
</script>