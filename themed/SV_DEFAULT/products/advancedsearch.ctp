<?php 
/*****************************************************************************
 * SV-Cart 高级搜索
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: advancedsearch.ctp 3113 2009-07-20 11:14:34Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link(array('autocomplete','/js/yui/autocomplete-min'));?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div id="Products_box">
<h1 class="headers">
<span class="r"></span><span class="l"></span>
<b><?php echo $SCLanguages['advanced_search'];?></b></h1>
	<div id="Products">
	<div id="advanced_search_page">
	<span class="search_ico"><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."adv_search_ico.png":"adv_search_ico.png")?></span>
	<?php echo $form->create('Product', array('action' => 'Search' ));?> 
	<div id="ysearch" class="green_3">
	<dl>
	<dd><?php echo $SCLanguages['keywords'];?>：</dd>
	<dt><input id="ysearchinput_search" class="text_input" onchange='javascript:YAHOO.example.ACJson.validateForm();' type="text" name="keywords" style="width:176px;" value="<?php if(isset($keywords) && $not_show == 0){echo $keywords;}?>"/></dt>
	<input type="hidden" name="type" value="S">
	</dl>
	<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?>	<dl>
	<dd><?php echo $SCLanguages['classificatory'];?>：</dd>
	<dt><select class="selects" name="category_id_search" id="category_id_search" style="width:176px;">
	<option value="0" <?php if(isset($category_id) && $category_id == 0){echo 'selected';}?>><?php echo $SCLanguages['please_choose'];?></option>
	<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?><option value="<?php echo $first_v['Category']['id'];?>" <?php if(isset($category_id) && $category_id == $first_v['Category']['id']){echo 'selected';}?>><?php echo $first_v['CategoryI18n']['name'];?></option>
	<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?><option value="<?php echo $second_v['Category']['id'];?>" <?php if(isset($category_id) && $category_id == $second_v['Category']['id']){echo 'selected';}?>>|--<?php echo $second_v['CategoryI18n']['name'];?></option>
	<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?><option value="<?php echo $third_v['Category']['id'];?>" <?php if(isset($category_id) && $category_id == $third_v['Category']['id']){echo 'selected';}?>>|----<?php echo $third_v['CategoryI18n']['name'];?></option>
	<?php }}}}}}?>
	</select>
	</dt>
	</dl><?}else{?>
	<input type='hidden' name="category_id" id="category_id_search" value='0' />
	<?}?>
<?php if(isset($brands) && sizeof($brands)>0){?>	<dl>
	<dd><?php echo $SCLanguages['brand'];?>：</dd>
	<dt><select class="selects" name="brand_id" id="brand_id_search" style="width:176px;" >
	<option value="0" <?php if(isset($brand_id) && $brand_id == 0){echo 'selected';}?>><?php echo $SCLanguages['please_choose'];?></option>
	<?php if(isset($brands) && sizeof($brands)>0){?>
	<?php foreach ($brands as $k=>$v){?>
	<option value="<?php echo $v['Brand']['id'] ?>" <?php if(isset($brand_id) && $brand_id == $v['Brand']['id']){echo 'selected';}?>><?php echo $v['BrandI18n']['name'] ?></option>
	<?php }?>
	<?php }?>
		
	</select></dt>
	</dl><?}else{?>
	<input type='hidden' name="brand_id" id="brand_id_search" value='0' />
		<?}?>
	<dl>
	<dd><?php echo $SCLanguages['price'];?>：</dd>
	<dt><input type="text" class="text_input" name="min_price" id="min_price_search" value="<?php if(isset($min_price) && $min_price>0){echo $min_price;}?>" style="width:82px;"/><span>-</span><input class="text_input" type="text" name="max_price" id="max_price_search" value="<?php if(isset($max_price) && $max_price<9999999){echo $max_price;}?>" style="width:82px;"/></dt>
	</dl>
	<div id="buyshop_box">
	<p class="buy_btn">
	<a href="javascript:advanced_search()" title="<?php echo $SCLanguages['advanced_search'];?>"><?php echo $SCLanguages['search'];?></a></p>
	</div>
	</div>
	<?php echo $form->end();?>
	</div>
<br />
	</div>
</div>
<!--Search End-->
<div class="height_5"></div>
<?php if(isset($products)){?>
<?php echo $this->element('advance_products_list', array('cache'=>'+0 hour'));?>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
<?php }else{?>
<!--无搜索结果-->
<div id="noproducts"><p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('align'=>'middle'))?>&nbsp;<?php echo $SCLanguages['not_find_product'];?></p></div>
<!--无搜索结果End--> 
<?php }?>