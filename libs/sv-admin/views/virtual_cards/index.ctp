<?php 
/*****************************************************************************
 * SV-Cart 虚拟卡管理列表
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
	</select><?php }?>
	<select name="forsale">
		<option value="99" selected >所有商品</option>
		<option value="1" <?php if($forsale==1){?>selected<?php }?> >上架</option>
		<option value="0" <?php if($forsale==0){?>selected<?php }?> >下架</option>
	</select>
	价格区间：<input name="min_price" id="min_price" value="<?php echo $min_price?>" size=15>－<input name="max_price" id="max_price" value="<?php echo $max_price?>" size=15>
	关键字：<input type="text" style="width:105px;" name="keywords" id="keywords" value="<?php echo $keywords?>"/></p>
	<?php if(!empty($brands_tree)){?>
	<p><select class="all" name="brand_id" id="brand_id">
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
	</select> <?php }?>推荐:
	<select name="is_recommond">
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
		<input type="text" id="date2" name="date2" value="<?php echo @$date2?>"  readonly/><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?></p></dd>
	<dt class="big_search"><input type="button" class="big" value="搜索" onclick="search_act()" />&nbsp;&nbsp;<input type="button" value="导出"   class="big" onclick="export_act()"  />	</dt>
	</dl><?php echo $form->end();?>
 
</div>
<br />
<!--Search End-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增虚拟卡","add/",'',false,false);?></strong></p>

<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' );">
<?php echo $form->create('',array('action'=>'/',"name"=>"ProForm","type"=>"get",'onsubmit'=>"return false"));?>
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th align="left"><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th><span>商品名称</span></th>
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
	<td><span><?php echo $html->link($v['ProductI18n']['name'],$server_host.$cart_webroot."products/{$v['Product']['id']}",array('target'=>'_blank'));?></span></td>
	<td align="center"><?php echo $v['Product']['code']?></td>
	<td align="center"><?php echo $v['Product']['quantity']?></td>
	<td align="center"><?php echo $v['Product']['shop_price']?></td>
	<td align="center"><?php if($v['Product']['forsale'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{?><?php echo $html->image('no.gif')?><?php }?></td>
	<td align="center"><?php if($v['Product']['recommand_flag'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{?><?php echo $html->image('no.gif')?><?php }?></td>
	<td align="center">
	<?php echo $html->link("查看",$server_host.$cart_webroot."products/{$v['Product']['id']}",array('target'=>'_blank'));?>
	|<?php echo $html->link("编辑","/virtual_cards/{$v['Product']['id']}");?>
	|<?php echo $html->link("复制","/virtual_cards/copy_pro/{$v['Product']['id']}");?>
	|<?php echo $html->link("放入回收站","javascript:;",array("onclick"=>"layer_dialog_show('确定进回收站?','{$this->webroot}products/trash/{$v['Product']['id']}')"));?>
	<br />&nbsp&nbsp&nbsp<?php echo $html->link("查看虚拟卡信息","/virtual_cards/card/{$v['Product']['id']}");?>
	|<?php echo $html->link("补货","/virtual_cards/card_add/{$v['Product']['id']}");?>
	|<?php echo $html->link("批量补货","/virtual_cards/batch_card_add/{$v['Product']['id']}");?>
	</td></tr>
<?php }}?>
  </table>
  <div class="pagers" style="position:relative">
  <p class='batch'>
    <select style="width:66px;border:1px solid #689F7C;display:none;" name="act_type" id="act_type">
  <!--  <option value="0">请选择...</option>
    --><option value="del">删除</option>
    </select> 
<?php if($total>0){?><input type="submit" id="submit_button" value="放入回收站" onclick="batch_action()"/><?php }?></p>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<?php echo $form->end();?>
</div>
<!--Main Start End-->
</div>
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
<script>
function batch_action() 
{ 
	document.ProForm.action=webroot_dir+"virtual_cards/batch";
	document.ProForm.onsubmit= "";
	document.ProForm.submit(); 
}
function search_act(){ 
	document.SearchForm.action=webroot_dir+"virtual_cards/index";
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit(); 
}

function export_act(){ 
//	var url=document.getElementById("url").value;
//	window.location.href=webroot_dir+url;
	document.SearchForm.action=webroot_dir+"virtual_cards/index/export";
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit(); 
}
</script>