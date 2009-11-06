<?php 
/*****************************************************************************
 * SV-Cart 服务管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 4718 2009-09-29 03:01:55Z huangbo $
*****************************************************************************/
?>
 <!--时间控件层start-->
<div id="container_cal" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
	<div class="hd">日历</div>
	<div class="bd"><div id="cal"></div><div style="clear:both;"></div></div>
</div>
<div id="container_cal2" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
	<div class="hd">日历</div>
	<div class="bd"><div id="cal2"></div><div style="clear:both;"></div></div>
</div>
<div id="container_cal3" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
	<div class="hd">日历</div>
	<div class="bd"><div id="cal3"></div><div style="clear:both;"></div></div>
</div>
<div id="container_cal4" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
	<div class="hd">日历</div>
	<div class="bd"><div id="cal4"></div><div style="clear:both;"></div></div>
</div>
<!--end-->

<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($payments);?>
<div class="search_box">
<?php echo $form->create('',array('action'=>'/',"type"=>"get",'name'=>"SearchForm"));?>
	<dl>
	<dt><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p>
	价格区间：<input name="min_price" id="min_price" value="<?php echo $min_price?>" style="width:60px;;border:1px solid #649776" >－<input name="max_price" id="max_price" value="<?php echo $max_price?>" style="width:60px;;border:1px solid #649776" />
	关键字：<input type="text" style="width:60px;;border:1px solid #649776" name="keywords" id="keywords" value="<?php echo $keywords?>"/>
	添加时间：<input type="text" id="date" style="width:60px;;border:1px solid #649776" name="date" value="<?php echo @$date?>"  readonly/>
	<?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>
		<input type="text" id="date2"style="width:60px;;border:1px solid #649776"  name="date2" value="<?php echo @$date2?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>

	有效时间：<input type="text" id="date3" style="width:60px;;border:1px solid #649776" name="date3" value="<?php echo @$date3?>"  readonly/>
	<?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show3","class"=>"calendar"))?>
		<input type="text" id="date4" style="width:60px;;border:1px solid #649776" name="date4" value="<?php echo @$date4?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show4","class"=>"calendar"))?>

	</p><p>
	<?php if(!empty($categories_tree)){?>
	<select style="width:80px;" name="category_id" id="category_id">
	<option value="0">所有分类</option>
	<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
	<option value="<?php echo $first_v['Category']['id'];?>" <?php if($category_id == $first_v['Category']['id']){?>selected<?php }?>><?php echo $first_v['CategoryI18n']['name'];?></option>
		<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
		<option value="<?php echo $second_v['Category']['id'];?>" <?php if($category_id == $second_v['Category']['id']){?>selected<?php }?>>&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
			<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
			<option value="<?php echo $third_v['Category']['id'];?>" <?php if($category_id == $third_v['Category']['id']){?>selected<?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
	<?php }}}}}}?>
	</select><?php }?>
	<select name="forsale">
		<option value="99" selected >所有商品</option>
		<option value="1" <?php if($forsale==1){?>selected<?php }?> >上架</option>
		<option value="0" <?php if($forsale==0){?>selected<?php }?> >下架</option>
	</select>

	
	<?php if(!empty($brands_tree)){?>
	<select style="width:80px;" name="brand_id" id="brand_id">
	<option value="0">所有品牌</option>
		<?php if(isset($brands_tree) && sizeof($brands_tree)>0){?>
	<?php foreach($brands_tree as $k=>$v){?>
	  <option value="<?php echo $v['Brand']['id']?>" <?php if($brand_id == $v['Brand']['id']){?>selected<?php }?>><?php echo $v['BrandI18n']['name']?></option>
	<?php }}?>
	</select><?php }?>
	<?php if(!empty($types_tree)){?>
	<select name="type_id" id="type_id">
	<option value="0">所有类型</option>
		<?php if(isset($types_tree) && sizeof($types_tree)>0){?>
	<?php foreach($types_tree as $k=>$v){?>
	  <option value="<?php echo $v['ProductType']['id']?>" <?php if($type_id == $v['ProductType']['id']){?>selected<?php }?>><?php echo $v['ProductType']['name']?></option>
	<?php }}?>
	</select> <?php }?>
	推荐:
	<select name="is_recommond" style="width:60px;">
	<option value="-1">所有</option>
	<option value="0" <?php if($is_recommond == 0){?>selected<?php }?>>非推荐商品</option>
	<option value="1" <?php if($is_recommond == 1){?>selected<?php }?>>推荐商品</option>
	</select>
	<?php if(!empty($provides_tree)){?>
	<select style="width:90px;" name="provider_id">
	<option value="-1">所有供应商</option>
	<?php if(isset($provides_tree) && sizeof($provides_tree)>0){?>
	<?php foreach($provides_tree as $k=>$v){?>
	   <option value="<?php echo $v['Provider']['id']?>" <?php if($provider_id == $v['Provider']['id']){?>selected<?php }?>><?php echo $v['Provider']['name']?></option>
	<?php }}?>
	</select>
	<?php }?>
		CSV导出编码:
			<select id="csv_export_code" >
			<?php if(isset($systemresource_info["csv_export_code"]) && sizeof($systemresource_info["csv_export_code"])>0){
			foreach ($systemresource_info["csv_export_code"] as $k => $v){if($k!=""){?>
			<option value="<?php echo $k;?>" <?php if($k==$csv_export_code){echo "selected";}?>><?php echo $v;?></option>
			<?php }}}?>
			</select>

<input type="button" value="导出"   class="search_article"   onclick="export_act()"  />
</p></dd>
	<dt class="big_search"><input type="button" class="big" value="搜索" onclick="search_act()" />&nbsp;&nbsp;</dt>
	</dl><?php echo $form->end();?>
</div>
<br />

<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增服务商品","add/",'',false,false);?></strong></p>
<!--Main Start-->
<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' );">
<?php echo $form->create('',array('action'=>'/batch',"name"=>"ProForm","type"=>"get",'onsubmit'=>"return false"));?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
	<tr class="thead">
		<th align="left" width="6%"><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
		<th width="39%"><span>商品名称</span></th>
		<th width="8%">货号</th>	
		<th width="8%">价格</th>
		<th width="8%">上架</th>
		<th width="8%">推荐</th>
		<th width="8%">是否有效</th>
		<th width="15%">操作</th>
	</tr>
<?php if(isset($products_list) && sizeof($products_list)>0){?>
<?php foreach($products_list as $k=>$v){?>	
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
		<td><input type="checkbox" name="checkboxes[]" value="<?php echo $v['Product']['id']?>" /><?php echo $v['Product']['id']?></td>
		<td ><?php echo $html->link($v['ProductI18n']['name'],"../../products/{$v['Product']['id']}",array('target'=>'_blank'));?></td>
		<td align="center"><?php echo $v['Product']['code']?></td>
		<td align="center"><?php echo $v['Product']['shop_price']?></td>
		<td align="center"><?php if($v['Product']['forsale'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{?><?php echo $html->image('no.gif')?><?php }?></td>
		<td align="center"><?php if($v['Product']['recommand_flag'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{?><?php echo $html->image('no.gif')?><?php }?></td>
		<td align="center"><?php if($v['ProductService']['status'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{?><?php echo $html->image('no.gif')?><?php }?></td>
		<td align="center">
		<?php echo $html->link("查看","../../products/{$v['Product']['id']}",array('target'=>'_blank'));?>
		|<?php echo $html->link("编辑","/product_services/{$v['Product']['id']}");?>
		|<?php echo $html->link("复制","/product_services/copy_pro/{$v['Product']['id']}");?>
		|<?php echo $html->link("放入回收站","javascript:;",array("onclick"=>"layer_dialog_show('确定进回收站?','{$admin_webroot}product_services/trash/{$v['Product']['id']}')"));?>
		</td>
	</tr>
<?php }}?>
 </table> </div>
  <div class="pagers" style="position:relative">
  <p class='batch'>
    <select style="width:66px;border:1px solid #689F7C;display:none;" name="act_type" id="act_type">
  <!--  <option value="0">请选择...</option>
    --><option value="del">放入回收站</option>
    </select> 
<?php if($total>0){?><input type="button" id="submit_button" value="放入回收站" onclick="diachange()"/><?php }?></p>
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
		var id=document.getElementsByName('checkboxes[]');
		var i;
		var j=0;
		var image="";
		for( i=0;i<=parseInt(id.length)-1;i++ ){
			if(id[i].checked){
				j++;
			}
		}
		if( j>=1 ){
			layer_dialog_show('确定'+vals+'?','batch_action()',5);
		}else{
			layer_dialog_show('请选择！！','batch_action()',3);
		}
	}

	}

function batch_action() 
{ 
	document.ProForm.action=webroot_dir+"product_services/batch";
	document.ProForm.onsubmit= "";
	document.ProForm.submit(); 
}

function search_act(){ 
	document.SearchForm.action=webroot_dir+"product_services/index";
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit(); 
}

function export_act(){ 
	var csv_export_code = GetId("csv_export_code");
	document.SearchForm.action=webroot_dir+"product_services/index/export/"+csv_export_code.value;
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit(); 
}

function operate_select(){//删除
	var id=document.getElementsByName('checkboxes[]');
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
		batch_action();
	}
}
</script>