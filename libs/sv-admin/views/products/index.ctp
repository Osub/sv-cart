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
 * $Id: index.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?>
 
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
	添加时间：<input type="text" id="date" name="date" value="<?php echo @$date?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
		<input type="text" id="date2" name="date2" value="<?php echo @$date2?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
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
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增商品","add/",
'',false,false);?></strong></p>

<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' );">
<?php echo $form->create('',array('action'=>'/',"name"=>"ProForm","type"=>"POST",'onsubmit'=>"return false"));?>
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th align="left"><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th>商品名称</th>
	<th>货号</th>
	<th>库存</th>
	<th>价格</th>
	<th>上架</th>
	<th>推荐</th>
	<th>操作</th></tr>
<?php if(isset($products_list) && sizeof($products_list)){?>
<?php foreach($products_list as $k=>$v){?>	
<tr>
	<td><input type="checkbox" name="checkboxes[]" value="<?php echo $v['Product']['id']?>" /><?php echo $v['Product']['id']?></td>
	<td><?php echo $html->link($v['ProductI18n']['name'],$server_host.$cart_webroot."products/".$v['Product']['id'],array('target'=>'_blank'));?>
	</li>
	<td align="center"><?php echo $v['Product']['code']?></td>
	<td align="center"><?php echo $v['Product']['quantity']?></td>
	<td align="center"><?php echo $v['Product']['shop_price']?></td>
	<td align="center"><?php if($v['Product']['forsale'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{?><?php echo $html->image('no.gif')?><?php }?></td>
	<td align="center"><?php if($v['Product']['recommand_flag'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{?><?php echo $html->image('no.gif')?><?php }?></td>
	<td align="center">
	<!--	<?php echo $html->link($html->image('icon_view.gif',$title_arr['look']),$server_host.$cart_webroot."products/{$v['Product']['id']}",'',false,false)?>
		<?php echo $html->link($html->image('icon_edit.gif',$title_arr['edit']),"/products/{$v['Product']['id']}",'',false,false)?>
		<?php echo $html->link($html->image('icon_copy.gif',$title_arr['copy']),"/products/copy_pro/{$v['Product']['id']}",'',false,false)?>
		<?php echo $html->link($html->image('icon_trash.gif',$title_arr['trash']),"/products/trash/{$v['Product']['id']}",'',false,false)?>
-->	
	<p><?php echo $html->link("查看",$server_host.$cart_webroot."products/".$v['Product']['id'],array('target'=>'_blank'));?> | <?php echo $html->link("编辑","/products/{$v['Product']['id']}");?> | <?php echo $html->link("复制","/products/copy_pro/{$v['Product']['id']}");?> | <?php echo $html->link("放入回收站","javascript:;",array("onclick"=>"layer_dialog_show('确定进回收站?','{$this->webroot}products/trash/{$v['Product']['id']}')"));?></p>
	</td></tr>
<?php }}?>
</table>
<div class="pagers" style="position:relative">
 <p class='batch'>
 <?php if($total>0){?> 
    <select name="act_type" id="act_type" onchange="operate_change()" style="top:-2px;*top:-5px;position:relative;width:80px">
    <option value="0">请选择...</option>
    <option value="del">放入回收站</option>
    <option value="category">转移到分类</option>
    </select>
    <span id="category_div" style="display:none;">
    <?php if(!empty($categories_tree)){?>
	<select class="all" name="category_change" id="category_change" style="top:-2px;*top:-5px;position:relative;width:80px;zoom:1;">
	<option value="0">请选择...</option>
	<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
	<option value="<?php echo $first_v['Category']['id'];?>"><?php echo $first_v['CategoryI18n']['name'];?></option>
	<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
	<option value="<?php echo $second_v['Category']['id'];?>" >&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
	<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
	<option value="<?php echo $third_v['Category']['id'];?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
	<?php }}}}}}?>
	</select>
	<?php }?>
	</span>
	<input type="button" value="确定"  onclick="operate_select()"  id="change_button"/>
<?php }?>
</p>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<?php echo $form->end();?>
</div>
<!--Main Start End-->
</div>
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

<!--重新计算冻结数弹出层--> 
<!--对话框start-->
<div id="amend_num" style="display:none">
<input type="hidden" value="" id="select_id">
<div id="loginout" >
	<h1><b>系统提示</b></h1>
	<div class="order_stat athe_infos tongxun" >
	<div id="num_text">
	<div id="buyshop_box">
		<p class="login-alettr" style="border:0;padding-bottom:15px;">
	    <?php echo $html->image("msg.gif",array('class'=>'sub_icon vmiddle'));?><b>重新计算商品冻结数?</b></p>
 		<br />
		<p class="buy_btn mar" style="margin:0 110px 0 0;"><?php echo $html->link("取消","javascript:num_big_panel.hide();");?>
		<?php echo $html->link("确定","javascript:;",array("onclick"=>"confirm_num();"));?></p>
	</div></div>
		<div id="num_confirm" style="display:none">
		<div id="buyshop_box">
		<p class="login-alettr" style="border:0;padding-bottom:15px;"><b>商品冻结数修改成功!</b></p>
		<br />
		<p class="buy_btn" style="padding-right:170px;"><?php echo $html->link("确定","javascript:num_big_panel.hide();");?></p>
		</div></div>
		
	<p><?php echo $html->image("loginout-bottom.png");?></p>
	</div>
</div>	
</div>
<!--对话框end-->

<script>
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
	document.SearchForm.action=webroot_dir+"products/index";
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit(); 
}

function export_act(){ 
//	var url=document.getElementById("url").value;
//	window.location.href=webroot_dir+url;
	document.SearchForm.action=webroot_dir+"products/index/export";
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