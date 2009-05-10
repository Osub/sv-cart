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
 * $Id: index.ctp 1273 2009-05-08 16:49:08Z huangbo $
*****************************************************************************/
?>

<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<?=$javascript->link('listtable');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/',"type"=>"get"));?>
	<dl>
	<dt><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p>
	<?if(!empty($categories_tree)){?>
	<select class="all" name="category_id" id="category_id">
	<option value="0">所有分类</option>
	<?if(isset($categories_tree) && sizeof($categories_tree)>0){?><?foreach($categories_tree as $first_k=>$first_v){?>
	<option value="<?=$first_v['Category']['id'];?>" <?if($category_id == $first_v['Category']['id']){?>selected<?}?>><?=$first_v['CategoryI18n']['name'];?></option>
		<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
		<option value="<?=$second_v['Category']['id'];?>" <?if($category_id == $second_v['Category']['id']){?>selected<?}?>>&nbsp;&nbsp;<?=$second_v['CategoryI18n']['name'];?></option>
			<?if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
			<option value="<?=$third_v['Category']['id'];?>" <?if($category_id == $third_v['Category']['id']){?>selected<?}?>>&nbsp;&nbsp;&nbsp;&nbsp;<?=$third_v['CategoryI18n']['name'];?></option>
	<?}}}}}}?>
	</select>
		<?}?>
	价格区间：<input name="min_price" id="min_price" value="<?echo @$min_price?>" size=15>－<input name="max_price" id="max_price" value="<?echo $max_price?>" size=15>
	关键字：<input type="text" style="width:105px;" name="keywords" id="keywords" value="<?echo @$keywords?>"/></p>
	<?if(!empty($brands_tree)){?>
	<p><select class="all" name="brand_id" id="brand_id">
	<option value="0">所有品牌</option>
		<?if(isset($brands_tree) && sizeof($brands_tree)>0){?>
	<?foreach($brands_tree as $k=>$v){?>
	  <option value="<?echo $v['Brand']['id']?>" <?if($brand_id == $v['Brand']['id']){?>selected<?}?>><?echo $v['BrandI18n']['name']?></option>
	<?}}?>
	</select>
	<?}?>
	<?if(!empty($types_tree)){?>
	<select name="type_id" id="type_id">
	<option value="0">所有类型</option>
		<?if(isset($types_tree) && sizeof($types_tree)>0){?>
	<?foreach($types_tree as $k=>$v){?>
	  <option value="<?echo $v['ProductType']['id']?>" <?if($type_id == $v['ProductType']['id']){?>selected<?}?>><?echo $v['ProductType']['name']?></option>
	<?}}?>
	</select> 
	<?}?>
	<select name="is_recommond">
	<option value="-1">推荐</option>
	<option value="0" <?if($is_recommond == 0){?>selected<?}?>>非推荐商品</option>
	<option value="1" <?if($is_recommond == 1){?>selected<?}?>>推荐商品</option>
	</select>
	<?if(!empty($provides_tree)){?>
	<select class="all" name="provider_id">
	<option value="-1">所有供应商</option>
	<?if(isset($provides_tree) && sizeof($provides_tree)>0){?>
	<?foreach($provides_tree as $k=>$v){?>
	   <option value="<?echo $v['Provider']['id']?>" <?if($provider_id == $v['Provider']['id']){?>selected<?}?>><?echo $v['Provider']['name']?></option>
	<?}}?>
	</select>
	<?}?>
	添加时间：<input type="text" id="date" name="date" value="<?=@$date?>"  readonly/><button type="button" id="show" title="Show Calendar">
	<?=$html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar'))?>
		</button>--<input type="text" id="date2" name="date2" value="<?=@$date2?>"  readonly/><button type="button" id="show2" title="Show Calendar">	<?=$html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar'))?>
</button></p></dd>
	<dt class="big_search"><input type="submit" class="big" value="搜索" /></dt>
	</dl><? echo $form->end();?>
</div>
<br />
<!--Search End-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增商品","add/",'',false,false);?></strong></p>

<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' );">
<?php echo $form->create('',array('action'=>'/',"name"=>"ProForm","type"=>"get"));?>

	<ul class="product_llist">
	<li class="number"><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>编号<?=$html->image('sort_desc.gif',array('align'=>'absmiddle'))?></li>
	<li class="name" style="width:24%"><p>商品名称</p></li>
	<li class="item_number">货号</li>
	<li class="best">库存</li>
	<li class="price">价格</li>
	<li class="best">上架</li>
	<li class="best">推荐</li>
	<li class="hadle">操作</li></ul>
<?if(isset($products_list) && sizeof($products_list)){?>
<?foreach($products_list as $k=>$v){?>	
	<ul class="product_llist products">
	<li class="number"><input type="checkbox" name="checkboxes[]" value="<?echo $v['Product']['id']?>" /><?echo $v['Product']['id']?></li>
	<li class="name" style="width:24%"><p><?echo $v['ProductI18n']['name']?></p></li>
	<li class="item_number"><?echo $v['Product']['code']?></li>
	<li class="best"><?echo $v['Product']['quantity']?></li>
	<li class="price"><?echo $v['Product']['shop_price']?></li>
	<li class="best"><?if($v['Product']['forsale'] == 1){?><?=$html->image('yes.gif')?><?}else{?><?=$html->image('no.gif')?><?}?></li>
	<li class="best"><?if($v['Product']['recommand_flag'] == 1){?><?=$html->image('yes.gif')?><?}else{?><?=$html->image('no.gif')?><?}?></li>
	<li class="hadle">
	<!--	<?=$html->link($html->image('icon_view.gif',$title_arr['look']),"../../products/{$v['Product']['id']}",'',false,false)?>
		<?=$html->link($html->image('icon_edit.gif',$title_arr['edit']),"/products/{$v['Product']['id']}",'',false,false)?>
		<?=$html->link($html->image('icon_copy.gif',$title_arr['copy']),"/products/copy_pro/{$v['Product']['id']}",'',false,false)?>
		<?=$html->link($html->image('icon_trash.gif',$title_arr['trash']),"/products/trash/{$v['Product']['id']}",'',false,false)?>
-->	<?php echo $html->link("查看","../../products/{$v['Product']['id']}");?>|<?php echo $html->link("编辑","/products/{$v['Product']['id']}");?>|<?php echo $html->link("复制","/products/copy_pro/{$v['Product']['id']}");?>|<?php echo $html->link("回收站","javascript:;",array("onclick"=>"layer_dialog_show('确定进回收站?','{$this->webroot}products/trash/{$v['Product']['id']}')"));?>
		
	</li></ul>
<?}}?>
  
  <div class="pagers" style="position:relative">
  <p class='batch'>
    <select style="width:66px;border:1px solid #689F7C;display:none;" name="act_type" id="act_type">
  <!--  <option value="0">请选择...</option>
    --><option value="del">删除</option>
    </select> 
<input type="submit" value="回收站" onclick="batch_action()"/></p>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<? echo $form->end();?>
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
<script>
	function batch_action() 
	{ 
	document.ProForm.action=webroot_dir+"products/batch";
	document.ProForm.submit(); 
	}
</script>