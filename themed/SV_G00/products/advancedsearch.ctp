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
 * $Id: advancedsearch.ctp 1215 2009-05-06 05:46:48Z huangbo $
*****************************************************************************/
?>
<?echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div id="Products_box">
<h1 class="headers">
<span class="r"></span><span class="l"></span>
<b><?=$SCLanguages['advanced_search'];?></b></h1>
	<div id="Products">
	
	<div id="advanced_search_page">
	<span class="search_ico"><?=$html->image("adv_search_ico.png")?></span>
	<?=$form->create('Product', array('action' => 'Search' ,'onsubmit'=>"return YAHOO.example.ACJson.validateForm();"));?> 
	<div id="ysearch" class="green_3">
	<dl>
	<dd><?php echo $SCLanguages['keywords'];?>：</dd>
	<dt><input id="ysearchinput_search" class="text_input" type="text" name="keywords" style="width:176px;" value="<?if(isset($keywords) && $not_show == 0){echo $keywords;}?>"/></dt>
	<input type="hidden" name="type" value="S">
	</dl>
	<dl>
	<dd><?php echo $SCLanguages['category'];?>：</dd>
	<dt><select class="selects" name="category_id_search" id="category_id_search" style="width:176px;">
	<option value="0" <?if(isset($category_id) && $category_id == 0){echo 'selected';}?>><?php echo $SCLanguages['please_choose'];?></option>
	<?if(isset($categories_tree) && sizeof($categories_tree)>0){?><?foreach($categories_tree as $first_k=>$first_v){?><option value="<?=$first_v['Category']['id'];?>" <?if(isset($category_id) && $category_id == $first_v['Category']['id']){echo 'selected';}?>><?=$first_v['CategoryI18n']['name'];?></option>
	<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?foreach($first_v['SubCategory'] as $second_k=>$second_v){?><option value="<?=$second_v['Category']['id'];?>" <?if(isset($category_id) && $category_id == $second_v['Category']['id']){echo 'selected';}?>>|--<?=$second_v['CategoryI18n']['name'];?></option>
	<?if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?foreach($second_v['SubCategory'] as $third_k=>$third_v){?><option value="<?=$third_v['Category']['id'];?>" <?if(isset($category_id) && $category_id == $third_v['Category']['id']){echo 'selected';}?>>|----<?=$third_v['CategoryI18n']['name'];?></option>
	<?}}}}}}?>
	</select>
	</dt>
	</dl>
	<dl>
	<dd><?php echo $SCLanguages['brand'];?>：</dd>
	<dt><select class="selects" name="brand_id" id="brand_id_search" style="width:176px;" >
	<option value="0" <?if(isset($brand_id) && $brand_id == 0){echo 'selected';}?>><?php echo $SCLanguages['please_choose'];?></option>
	<?if(isset($brands) && sizeof($brands)>0){?>
	<? foreach ($brands as $k=>$v){?>
	<option value="<?echo $v['BrandI18n']['brand_id'] ?>" <?if(isset($brand_id) && $brand_id == $v['BrandI18n']['brand_id']){echo 'selected';}?>><?echo $v['BrandI18n']['name'] ?></option>
	<?}?>
	<?}?>
		
	</select></dt>
	</dl>
	<dl>
	<dd><?php echo $SCLanguages['price'];?>：</dd>
	<dt><input type="text" class="text_input" name="min_price" id="min_price_search" value="<?if(isset($min_price) && $min_price>0){echo $min_price;}?>" style="width:82px;"/><span>-</span><input class="text_input" type="text" name="max_price" id="max_price_search" value="<?if(isset($max_price) && $max_price<9999999){echo $max_price;}?>" style="width:82px;"/></dt>
	</dl>
	<div id="buyshop_box">
	<p class="buy_btn">
	<a href="javascript:advanced_search()" title="<?php echo $SCLanguages['advanced_search'];?>"><?php echo $SCLanguages['advanced_search'];?></a></p>
	</div>
	</div>
	<?=$form->end();?>
	</div>
<br />
	</div>
</div>
<!--Search End-->
<div class="height_5"></div>
<?if(isset($products)){?>
<?=$this->element('advance_products_list', array('cache'=>'+0 hour'));?>
<?=$this->element('pagers', array('cache'=>'+0 hour'));?>
<?}else{?>
<!--无搜索结果-->
<div id="noproducts"><p><?=$html->image('warning_img.gif',array('align'=>'middle'))?>&nbsp;<?=$SCLanguages['not_find_product'];?></p></div>
<!--无搜索结果End--> 
<?}?>