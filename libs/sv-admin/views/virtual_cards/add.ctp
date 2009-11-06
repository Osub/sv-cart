<?php 
/*****************************************************************************
 * SV-Cart 添加商品
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 4708 2009-09-28 13:45:35Z huangbo $
*****************************************************************************/
?>
<!--Main Start-->
<?php echo $html->css('colorpicker');?>
<?php echo $html->css('button');?>
<?php echo $html->css('slider');?>
<?php echo $html->css('color_font');?>


<?php echo $javascript->link('/../js/yui/dragdrop-min.js');?>
<?php echo $javascript->link('/../js/yui/button-min.js');?>
<?php echo $javascript->link('/../js/yui/slider-min.js');?>
<?php echo $javascript->link('/../js/yui/colorpicker-min.js');?>

<?php echo $javascript->link('color_picker');?>
<?php echo $javascript->link('product');?>
<?php echo $form->create('virtual_cards',array('action'=>'add','name'=>'thisForm','id'=>'thisForm','OnSubmit'=>'return products_check();'));?>
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

<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."商品列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>

<div class="home_main">
<input type="hidden" name="action_type" value="product_base_info">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  通用信息</h1></div>
	  <div class="box">
<?php  if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="ProductI18n<?php echo $k;?>Locale" name="data[ProductI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo $v['Language']['locale'];?>">
<?php 
	}
}?>
 	    <h2>商品名称：</h2>
<?php  if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input id="product_name_<?php echo $v['Language']['locale']?>" name="data[ProductI18n][<?php echo $k;?>][name]"  type="text" maxlength="100"  style="" /></span>
		 <font color="#ff0000">*</font></p>
<?php 
	}
}?>
    <div class="products_name" style='position:relative;margin:5px 0 0 103px;'>
    <span>
  	   <select id="product_style_word" name="product_style_word">
		<option value="">字体样式</option>
		<option value="strong" >加粗</option>
		<option value="em" >斜体</option>
		<option value="u" >下划线</option>
		<option value="strike" >删除线</option>
		</select>
		<div id="button-container" style="position:absolute;left:80px;top:-10px;"><label for="color-picker-button"></label></div><input name="product_style_color" id="product_style_color" style="width:100px;" value="" type="hidden"/>
    </span>

    </div>
  	 
 	    <h2>款号名称：</h2>
<?php  if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input  name="data[ProductI18n][<?php echo $k;?>][style_name]"  type="text" maxlength="100"  style="" /></span>
		</p>
<?php 
	}
}?>
		
		<h2>商品关键词：</h2>
<?php  if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input id="ProductI18n<?php echo $k;?>MetaKeywords" name="data[ProductI18n][<?php echo $k;?>][meta_keywords]" type="text" style="width:215px;" value=""> 
			<select style="width:90px;border:1px solid #649776" onchange="add_to_seokeyword(this,'ProductI18n<?php echo $k;?>MetaKeywords')">
				<option value='常用关键字'>常用关键字</option>
				<?php foreach( $seokeyword_data as $sk=>$sv){?>
					<option value='<?php echo $sv["SeoKeyword"]["name"]?>'><?php echo $sv["SeoKeyword"]["name"]?></option>
				<?php }?>
			</select>

		用逗号分隔</span></p>
<?php 
	}
}?>
  	 
		<h2>商品简单描述：</h2>
<?php  if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><textarea id="ProductI18n<?php echo $k;?>MetaDescription" name="data[ProductI18n][<?php echo $k;?>][meta_description]" ></textarea> <font color="#ff0000">*</font></span></p>
<?php 
	}
}?>
		<h2>商品网站网址：</h2>
<?php  if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input id="ProductI18n<?php echo $k;?>api_site_url" name="data[ProductI18n][<?php echo $k;?>][api_site_url]" type="text" style="width:215px;" value=""> </span></p>
<?php 
	}
}?>
		<h2>购物车快捷网址：</h2>
<?php  if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input id="ProductI18n<?php echo $k;?>api_cart_url" name="data[ProductI18n][<?php echo $k;?>][api_cart_url]" type="text" style="width:215px;" value=""> </span></p>
<?php 
	}
}?>
		<h2><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text1')"))?>商家备注：</h2>
<?php  if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><textarea name="data[ProductI18n][<?php echo $k;?>][seller_note]" ></textarea></span><br /></p>
	<?php }}?>  
		<h2><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text1')"))?>发货备注：</h2>
<?php  if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><textarea name="data[ProductI18n][<?php echo $k;?>][delivery_note]" ></textarea></span><br /></p>
	<?php }}?>  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;">
<!--Other Stat-->
	<div class="order_stat athe_infos tongxun">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  其他信息</h1></div>
	  <div class="box">
		<dl><dt><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text2')"))?>商品货号：</dt><dd><input type="text" class="text_inputs"  name="data[Product][code]" value="" onblur="product_code_unique(this,'')"/><br /><span style="display:none" id="help_text2">如果您不输入商品货号，系统将自动生成一个唯一货号。</span></dd></dl>
		<input type="hidden" id="ProductCode"  value="temp"/>
		<dl><dt>商品分类：</dt><dd><select id="ProductsCategory" name="data[Product][category_id]">
		<option value="0">所有分类</option>
		<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
<option value="<?php echo $first_v['Category']['id'];?>" ><?php echo $first_v['CategoryI18n']['name'];?></option>
<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?php echo $second_v['Category']['id'];?>">&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?php echo $third_v['Category']['id'];?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
<?php }}}}}}?>
		</select> 
		
		<font color="#ff0000">*</font></dd></dl>
		<dl><dt>扩展分类：</dt>
		<dd>
		<span style='float:left;'><input type="button" class="pointer" value="添加" onclick="addOtherCat()"/></span>
		<span style='float:left;width:211px;padding-top:1px;'>
		    <select name="other_cat[]" style='margin-bottom:2px;'>
		       <option value="0">请选择</option>
		       <?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
<option value="<?php echo $first_v['Category']['id'];?>" ><?php echo $first_v['CategoryI18n']['name'];?></option>
<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?php echo $second_v['Category']['id'];?>" >&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?php echo $third_v['Category']['id'];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
<?php }}}}}}?>
		    </select>
	<div id="other_cats"></div>
	</span>
	
	</dd></dl>
	

	<?php if(!empty($brands_tree)){?>
		<dl><dt>商品品牌：</dt><dd>
	<select id="ProductBrandId" name="data[Product][brand_id]">
	      <option value="0">所有品牌</option>
	    <?php if(isset($brands_tree) && sizeof($brands_tree)>0){?>
	    <?php foreach($brands_tree as $k=>$v){?>
	         <option value="<?php echo $v['Brand']['id']?>" value=""><?php echo $v['BrandI18n']['name']?></option>
	    <?php }}?>
	</select></dd></dl><?php }?>
		<?php if(!empty($provider_list)){?>
			<dl><dt>供应商：</dt><dd>
	<select id="ProductproviderId" name="data[Product][provider_id]">
	      <option value="0">请选择....</option>
	    <?php if(isset($provider_list) && sizeof($provider_list)>0){?>
	    <?php foreach($provider_list as $k=>$v){?>
	         <option value="<?php echo $v['Provider']['id']?>" ><?php echo $v['Provider']['name']?></option>
	    <?php }}?>
	</select></dd></dl><?php }?>
		<dl><dt>进货价：</dt><dd><input type="text" class="text_inputs" id="Productpurchase_price" name="data[Product][purchase_price]"  /></dd></dl>
		<?php if(!empty($provider_list)){?>
		<dl><dt>扩展供应商：</dt>
		<dd>
			<table id="provider-tables">
	  		<?php if(!empty($this->data['other_provider'])){$pij=1;?>
			<?php foreach($this->data['other_provider'] as $pk=>$pv){?>
			<tr>
				<td><?php if($pij==1){?><a href="javascript:;" name="1" onclick="addprovider(this)">[+]</a><?php }else{?><a href="javascript:;" name="1" onclick="removeprovider(this)">[-]</a><?php }$pij++;?>
				<select  name="other_provider[]" style='margin-bottom:2px;'>
			    <option value="0">请选择....</option>
			    <?php if(isset($provider_list) && sizeof($provider_list>provider_list)>0){?>
			    <?php foreach($provider_list as $k=>$v){?>
			         <option value="<?php echo $v['Provider']['id']?>" ><?php echo $v['Provider']['name']?></option>
			    <?php }}?>
				</select>
				<input type="text" style="width:75px;border:1px solid #649776" name="other_provider_price[]" /></td>
			</tr>
			<?php }?><?php }else{?>
				<tr>
				<td><a href="javascript:;" name="1" onclick="addprovider(this)">[+]</a><select  name="other_provider[]" style='margin-bottom:2px;'>
			    <option value="0">请选择....</option>
			    <?php if(isset($provider_list) && sizeof($provider_list>provider_list)>0){?>
			    <?php foreach($provider_list as $k=>$v){?>
			         <option value="<?php echo $v['Provider']['id']?>"><?php echo $v['Provider']['name']?></option>
			    <?php }}?>
				</select>
				<input type="text" style="width:75px;border:1px solid #649776" name="other_provider_price[]" /></td>
			</tr>
			<?php }?>
			</table>
		</dd></dl><?php }?>
		<dl><dt>市场售价：</dt><dd><input type="text" class="text_inputs" id="ProductMarketPrice" name="data[Product][market_price]" value=""/><input class="pointer" type="button" value="取整数" onclick="integral_market_price()" /></dd></dl>

		<dl><dt>本店售价：</dt><dd><input type="text" class="text_inputs" id="ProductShopPrice" name="data[Product][shop_price]" onblur="priceSetted();user_rank_list();" value=""/><input type="button" class="pointer" value="按市场价计算" onclick="marketPriceSetted()"/> <font color="#ff0000">*</font></dd></dl>
		<?php if(!empty($user_rank_list)){?>
		<dl>
		   <dt>会员价格：</dt>
		   <dd>
		    <table>
		    
		    <?php if(isset($user_rank_list) && sizeof($user_rank_list) >0){?>
		   <?php foreach($user_rank_list as $k=>$v){?>
		       <tr>
		    <td>
		       	    </td><td><?php echo $v['UserRank']['name']?> </td><td><input class="text_inputs" style="width:50px;margin:-1px 0 0 4px;padding:0;text-align:center" id="rank_product_price<?php echo $k?>" name="rank_product_price[<?php echo $k?>]"  value="0" class="no_border_input" size="3" onkeyup="rank_product_price(<?php echo $k?>)"  />
				 <input type="hidden" id="user_rank<?php echo $k?>" name="user_rank[<?php echo $k?>]" value="<?php echo @$v['UserRank']['id']?>"  /></p>
					<input type="hidden" id="productrank_id<?php echo $k?>" name="productrank_id[<?php echo $k?>]" value="<?php echo @$v['UserRank']['productrank_id']?>"   />
		 
	 		   </td><td>折扣率: <input type="text"  class="text_inputs" style="width:30px;margin:-1px 0 0;padding:0;text-align:center" id="user_price_discount<?php echo $k?>" name="user_price_discount[<?php echo $k?>]" value="<?php echo $v['UserRank']['discount']?>" onkeyup="set_price_note(<?php echo $k?>)" size="8"  />
		       	   <input type="checkbox" id="is_default_rank<?php echo $k?>" name="is_default_rank[<?php echo $k?>]" <?php if(@$v['UserRank']['is_default_rank']==1){ echo "checked"; }?> value="1" onclick="user_prince_check(this.checked,<?php echo $k?>)" >自动按照比例结算</span>
		     		  </td></tr>
  
  		     <?php }}?>
		     		  </table>
		     		   </dd>
		</dl>
		<dl><dt>优惠价格：</dt><dd>[<?php echo $html->link("+","javascript:;",array("onclick"=>"add_price()"),false,false);?>]优惠数量<input type="text" class="text_inputs" name="data[ProdcutVolume][number][]"  onblur="check_number(this)"/> 优惠价格<input type="text" class="text_inputs" name="data[ProdcutVolume][price][]" onblur="check_price(this)"/></dd></dl>
		<div id="add_price"></div>

	<?php }?>

		<dl><dt>赠送积分数：</dt><dd><input type="text" class="text_inputs" name="data[Product][point]" /></dd></dl>
	
		<dl><dt><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text4')"))?>积分购买额度：</dt><dd><input type="text" class="text_inputs" name="data[Product][point_fee]" /><br /><span style="display:none" id="help_text4">购买该商品时最多可以使用多少的积分</span></dd></dl>
		<dl style="padding:3px 0;*padding:4px 0;">
					<dt class="promotion"><label for="ProductPromotionStatus"><input class="checkbox" type="checkbox" id="ProductPromotionStatus" name="data[Product][promotion_status]" value="1" onclick="handlePromote(this.checked);"  <?php if($this->data['Product']['promotion_status'] == 1){?>checked<?php }?>/>
		促销价</label>：</dt><dd><input type="text" class="text_inputs" value="" name="data[Product][promotion_price]" id="ProductPromotionPrice"/></dd></dl>
		<dl><dt>促销日期：</dt><dd class="time"><input style="width:90px;" class="text_inputs" type="text" id="date" name="date" value="<?php echo $this->data['Product']['promotion_start']?>"  readonly/><?php echo $html->image("calendar.gif",array("id"=>"show","class"=>"calendar_edit"))?>
			 <input type="text" style="width:90px;" class="text_inputs" id="date2" name="date2" value="<?php echo $this->data['Product']['promotion_end']?>"  readonly/><?php echo $html->image("calendar.gif",array("id"=>"show2","class"=>"calendar_edit"))?></dd></dl>
		<dl><dt>商品重量：</dt><dd><input type="text" class="text_inputs" value="" name="data[Product][weight]" id="ProductWeight"/>
			<select name="weight_unit">
			<option value="1">千克</option>
			<option value="0.001">克</option>
			</select></dd></dl>
			
		<dl style="*padding:4px 0;"><dt style="padding-top:1px">商品库存数量：</dt><dd class="best_input"><input name="data[Product][quantity]" id="ProductQuantity" value="<?php echo $SVConfigs['default_stock']?>"/></dd></dl>
		<dl style="*padding:4px 0;"><dt style="padding-top:1px">库存警告数量：</dt><dd class="best_input"><input name="data[Product][warn_quantity]" id="warn_quantity" value="<?php echo $SVConfigs['warn_quantity']?>"/></dd></dl>
			
			
		<dl style="padding:3px 0;*padding:4px 0;"><dt style="padding-top:1px">加入推荐：</dt><dd class="best_input"><input type="checkbox" name="data[Product][recommand_flag]" id="ProductRecommandFlag"value="1"/>推荐</dd></dl>
		<dl style="*padding:4px 0;"><dt style="padding-top:1px">上架：</dt><dd class="best_input"><input type="checkbox" name="data[Product][forsale]" id="ProductForsale"value="1" checked/>打钩表示能作为普通商品销售，否则不允许销售。</dd></dl>
		<dl style="*padding:5px 0;"><dt style="padding-top:1px">能作为普通商品销售：</dt><dd class="best_input"><input type="checkbox" name="data[Product][alone]" id="ProductAlone"value="1" checked/>打钩表示允许销售，否则只能作为配件或赠品销售。</dd></dl>
		<dl  style="*padding:5px 0;" ><dt style="padding-top:1px">是否显示款号颜色图：</dt><dd class="best_input"><input type="radio" class="checkbox" name="data[Product][is_colors_gallery]" value="1" checked />是<input type="radio" class="checkbox" name="data[Product][is_colors_gallery]" value="0"   />否</label></dd></dl>
		<dl  style="*padding:5px 0;" ><dt style="padding-top:1px">过往精品：</dt><dd class="best_input"><input type="radio" class="checkbox" name="data[Product][bestbefore]" value="1"  />是<input type="radio" class="checkbox" name="data[Product][bestbefore]" value="0"  checked />否</label></dd></dl>
		<dl><dt>商品款号：</dt><dd><input type="text" class="text_inputs"  name="data[Product][style_code]" /></dd></dl>
		<dl><dt>
			商品款号颜色图：
		</dt><dd>
		  	<input type="text" class="text_inputs" id="upload_img_text_10000" name="data[Product][colors_gallery]"  readonly />
			<?php echo $html->link($html->image('select_img.gif',array("align"=>"absmiddle","height"=>"23")),"javascript:img_sel(10000,'products')",'',false,false)?>
			<?php echo @$html->image("",array('id'=>'logo_thumb_img_10000','height'=>'100','style'=>'display:none'))?>
		</dd></dl>
  	
  	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>

</table>
<!--商品邮费-->
<?php if($SVConfigs["use_product_shipping_fee"] == 1){?>
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  <span>商品邮费</span></h1></div>
	  <div class="box">
	  <div class="properies_left">
		<table>
<?php if(isset($SVConfigs["mlti_currency_module"])&&$SVConfigs["mlti_currency_module"] == 1){?>
	<?php foreach( $shipping_list as $k=>$v ){?>
		<tr><td><?php echo $v["ShippingI18n"]["name"]?>：</td>
		<td></td></tr>
<?php if(isset($languages) && sizeof($languages) >0){?>
<?php foreach($languages as $kl=>$lv){?>
		<tr><td><?php echo $html->image($lv['Language']['img01'])?>:</td>
		<td>
		<input type="text" style="width:120px;border:1px solid #649776" name="product_shoping_fee[<?php echo $lv['Language']['locale']?>][<?php echo @$v['Shipping']['id']?>]" ></td><td>是否有效：<input type="checkbox" value="1" name="product_shoping_fee_status[<?php echo $lv['Language']['locale']?>][<?php echo @$v['Shipping']['id']?>]" style="border:1px solid #649776" />
		</td></tr><?php }}?>
	<?php }?>
<?php }else{?>
	<?php foreach( $shipping_list as $k=>$v ){?>
		<tr><td><?php echo $v["ShippingI18n"]["name"]?>:</td>
		<td><input type="text" style="width:120px;border:1px solid #649776" name="product_shoping_fee[<?php echo @$v['Shipping']['id']?>]" ></td><td>有效：<input type="checkbox" value="1" name="product_shoping_fee_status[<?php echo @$v['Shipping']['id']?>]" style="border:1px solid #649776"  /></td></tr>
	<?php }?>
<?php }?>
		</table>
		</div>
		<div style="clear:both"></div>
  	  </div>
	</div>
<?php }?>
<!--end-->
<?php if(isset($SVConfigs['mlti_currency_module'])&&$SVConfigs['mlti_currency_module']==1){?>
<!--profile-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  语言价</h1></div>
	  <div class="box">
		<div id="listDiv">
		<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
		<tr class="thead">
		<th width="12%">语言</th>
		<th width="20%">商品价</th>
		<th width="8%">有效</th></tr>
		<?php if(isset($languages) && sizeof($languages) >0){foreach($languages as $k=>$v){?>
		<tr>
			<td align="center"><?php echo $v['Language']['name']?></td>
			<td align="center"><input type="text"  style="border:1px solid #649776"  name="locale_product_price[<?php echo $v['Language']['locale']?>][product_price]"  /></td>
			<td align="center"><input type="checkbox" style="border:1px solid #649776" name="locale_product_price[<?php echo $v['Language']['locale']?>][status]" value="1"  ></td>
		</tr>
		<?php }}?>
		</table>
	  	</div>
	  </div>
	</div>
<!--profile End-->
<?php }?>

<!--profile-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  详细信息</h1></div>
	  <div class="box">
		<?php if($SVConfigs["select_editor"]=="2"||empty($SVConfigs["select_editor"])){?>
	  	<?php echo $javascript->link('tinymce/tiny_mce/tiny_mce'); ?>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?><table><tr><td valign="top">
	  	<?php echo $html->image($v['Language']['img01'])?></td><td valign="top">
		<textarea id="elm<?php echo $v['Language']['locale'];?>" name="data[ProductI18n][<?php echo $k;?>][description]" rows="15" cols="80" style="width: 80%"></textarea>
		<?php  echo $tinymce->load("elm".$v['Language']['locale'],$now_locale); ?><br /><br />
</td></tr>
</table>
    	<?php }?></p>
		<?php }?><?php }?>
		<?php if($SVConfigs["select_editor"]=="1"){?>
				  <?php echo $javascript->link('fckeditor/fckeditor'); ?>
			<?php  if(isset($languages) && sizeof($languages)>0){
				foreach ($languages as $k => $v){?>
				  <?php echo $html->image($v['Language']['img01'],array('align'=>'absbottom'))?><br />
			<p class="profiles">
			       <?php echo $form->textarea('ProductI18n/description', array("cols" => "60","rows" => "10","value" => "","name"=>"data[ProductI18n][{$k}][description]","id"=>"ProductI18n{$k}Description"));?>
			        <?php  echo $fck->load("ProductI18n{$k}/description"); ?>
					</p>
			<?php }}?>
		<?php }?>
	  </div>
	</div>
<!--Product Photos-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  <span>商品相册</span></h1></div>
	  <div class="box">
	  <input type="hidden" name="action_type" value="product_gallery"></>
	  <div id="gallery-table">
	  <ul class="photos">
	  <input name="product_id" id="ProductId" type="hidden" value="<?php echo  $this->data['Product']['id'];?>">
	<?php if(isset($this->data['ProductGallery']) && sizeof($this->data['ProductGallery'])>0){?>
	   <?php foreach($this->data['ProductGallery'] as $k=>$v){?>
	  	<li>
	  	<input type="hidden" name="data[ProductGallery][<?php echo $k?>][id]"  id="ProductGallery<?php echo $k?>Id" value="<?php echo $v['id']?>">
		<p>[<?php echo $html->link("-","javascript:;",array("onclick"=>"layer_dialog();layer_dialog_show('确定要删除相册图片吗?','dropImg({$v['id']})',5);"),false,false);?>]</p>
		<p><?php if($v['img_thumb']){?><?php echo $html->link($html->image("/..{$v['img_thumb']}",array('align'=>'absmiddle','width'=>'108','height'=>'108')),"/..{$v['img_thumb']}",'',false,false);?>
<?php }else{?><?php echo $html->image("/..{$v['img_detail']}",'');?><?php }?></p>
		
		<dl class="edit_photo">
		<dd>图片描述 :</dd>
		<dt><input class="green_border" type="text" style='width:98%' value="<?php echo $v['description']?>" name="data[ProductGallery][<?php echo $k?>][description]"  id="ProductGallery<?php echo $k?>Description"/>
		</dt>
		</dl>
		<dl class="edit_photo">
		<dd>排序: </dd>
		<dt><input class="green_border" type="text" style='width:98%' size="3" value="<?php echo $v['orderby']?>" name="data[ProductGallery][<?php echo $k?>][orderby]"  id="ProductGallery<?php echo $k?>Orderby" />
		
		</dt>
		</dl>
		
		<dl class="edit_photo">
		<dd>&nbsp;</dd>
		<dt>
		<?php if($v['img_thumb'] != $this->data['Product']['img_thumb'])?><span name="default_gallery_img[]" id="default_gallery_img_<?php echo $v['id']?>" style="display:<?php if($v['img_thumb'] != $this->data['Product']['img_thumb']){echo 'block';}else{echo 'none';}?>">
		<?php echo $html->link($html->image('default.gif',$title_arr['edit']),"javascript:default_gallery('{$v['id']}','{$this->data['Product']['id']}');","",false,false)?></span>
		<a name="default_gallery[]" id="default_gallery_<?php echo $v['id']?>" style="display:<?php if($v['img_thumb'] == $this->data['Product']['img_thumb']){echo 'block';}else{echo 'none';}?>  "><span style="font-size:13px"> 默认</span></a></dt>
		</dl>
		</li>
	   <script>
	   	   img_id_arr[<?php echo $k?>] = "default_gallery_img_<?php echo $v['id']?>";
	   </script>
	   
	   <?php }?>
     <?php }?>
	  </ul>

	  <div id="Pro_img_div">
		<p class="add_photo">

	<!-- 商品相册 -->
    <table width="100%" id="gallery-tables"  align="center">
	<!-- 上传图片 -->
	<tr>
		<td valign="bottom">
			<a href="javascript:;" name="1" onclick="addImg(this)">[+]</a>
			<select name="image_path[9999]" onchange="image_path_change(this,9999)">
				<option value="system_path">系统路径</option>
				<option value="definition_path">自定义路径</option>
			</select>
			<span id="definition_path_id_9999" style="display:none">
			缩略图：<input type="text" name="img_thumb[9999]" />
			详细图：<input type="text" name="img_detail[9999]" />
			原图：<input type="text" name="img_original[9999]" />
			</span>
			<span id="system_path_id_9999" >
             <input type="text" name="img_url[9999]" style="width:270px;border:1px solid #649776"  id="upload_img_text_9999" /><?php echo $html->link($html->image('select_img.gif',array("class"=>"vmiddle icons","height"=>"20")),"javascript:img_sel('9999','products')",'',false,false)?>
			</span>
			 <br />
			 图片描述: 
			 	<?php  if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		  		<?php echo $html->image($v['Language']['img01'],array("class"=>"vmiddle"))?> <input type="text" style="width:100px;border:1px solid #649776"   name="img_desc[<?php echo $v['Language']['locale']?>][9999]" id="img_desc[9999]"/>
				<?php }}?>排序: <input type="text" name="img_sort[1]" id="img_sort[1]" size="2" style="border:1px solid #649776"/>
			 	<br /><?php echo @$html->image("",array('id'=>"logo_thumb_img_9999",'style'=>"display:none"))?>
				</td>
	</tr>

	</table>

		</div>

		</div>

	  </div>
	</div>
<!--用来创造要替换的字符串start-->
<!--Product Photos End-->
<!--profile End-->
<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>

</div>
<!--Main Start End-->
<?php  echo $form->end();?>
<script style="text/javascript">
function check_number(obj){
	var value=obj.value;
	var filter= /^[0-9]*[0-9][0-9]*$/　　//正整数 
	if(!(filter.test(value))&&value!=""){
		obj.value="";
	}
}

function check_price(obj){
	var value=obj.value;
 	if(isNaN(value) || value<0){
	 	obj.value="";
	 }	
}


function add_price(){
	var text='<dl><dt></dt><dd>[<?php echo $html->link("-","javascript:;",array("onclick"=>"del_price(this)"),false,false);?>] 优惠数量<input type="text" class="text_inputs" name="data[ProdcutVolume][number][]" onblur="check_number(this)"/> 优惠价格<input type="text" class="text_inputs" name="data[ProdcutVolume][price][]" onblur="check_price(this)"/></dd></dl>';
	var number=document.getElementsByName("data[ProdcutVolume][number][]");
	var price=document.getElementsByName("data[ProdcutVolume][price][]");
	var j=0;
	var k=0;
	var msg="";
	for(var i=0; i<number.length; i++){
	 	if(number[i].value==""){
	 		j+=1;
	 	}
	} 	
	if(j>0){
		msg+="请输入优惠数量!\n";
	}	
	for(var i=0; i<price.length; i++){
	 	if(price[i].value==""){
	 		k+=1;
	 	}
	} 	
	if(k>0){
			msg+="请输入优惠价格!\n";
	}		
	if(msg.length>0){
		layer_dialog();
		layer_dialog_show(msg,"",3);	
	}
	else{
		var div = document.createElement("div");
		div.innerHTML=text;
		document.getElementById("add_price").appendChild(div);
	}
}

function del_price(obj){
	var conObj=document.getElementById('add_price');
	var id=obj.parentNode.parentNode.parentNode;
	conObj.removeChild(id);
}
//调色板
//改变字体颜色
var lang_all = Array();
<?php foreach( $languages as $k=>$v ){?>
	lang_all[<?php echo $k?>] = "<?php echo $v['Language']['locale']?>";
<?php }?>
function font_color_picker(color_sn){
	for( var i=0; i<lang_all.length;i++){
		document.getElementById('product_name_'+lang_all[i]).style.color=color_sn;
	}
}
onload = function(){
      handlePromote(document.getElementById('ProductPromotionStatus').checked);
    }
    
       var numpri=<?php echo $market_price_rate?>;
       var user_rank_list_arr  = Array();
       <?php $ii=0;foreach($user_rank_list as $k=>$v){?>
       	   user_rank_list_arr[<?php echo $ii?>]=<?php echo $k?>;
       <?php $ii++;}?>
       	  // alert(user_rank_list_arr);
       	   function user_rank_list(){
       	   		for(var kk=0;kk<user_rank_list_arr.length;kk++){
       	   			set_price_note(user_rank_list_arr[kk]);
       	   		}
       	   
       	   
       	   }
  /**
   * 删除图片上传
   */
  function removeImg(obj)
  {
      var row = rowindex(obj.parentNode.parentNode);
      var tbl = document.getElementById('gallery-tables');

      tbl.deleteRow(row);
  }

  /**
   * 新增一个图片
   */
  function addImg(obj)
  {
      var src  = obj.parentNode.parentNode;
     
      var idx  = rowindex(src); 
      var tbl  = document.getElementById('gallery-tables');
      var row  = tbl.insertRow(idx + 1);
      var cell = row.insertCell(-1);
      var img_str = src.cells[0].innerHTML.replace(/(.*)(addImg)(.*)(\[)(\+)/i, "$1removeImg$3$4-");
      img_str = img_str.replace(/\'9999\'/g,obj.name)
      img_str = img_str.replace(/9999/g,obj.name)
      cell.innerHTML = img_str;
      obj.name = obj.name-0+1;
  }
	    function image_path_change(obj,num){
	    	if(obj.value == "system_path"){
	    		document.getElementById("definition_path_id_"+num).style.display = "none";
	    		document.getElementById("system_path_id_"+num).style.display = "inline-block";
	    		document.getElementById("path_txt_id_"+num).style.display = "inline-block";
	    	}
	    	if(obj.value == "definition_path"){
	    		document.getElementById("definition_path_id_"+num).style.display = "inline-block";
	    		document.getElementById("system_path_id_"+num).style.display = "none";
	    		document.getElementById("path_txt_id_"+num).style.display = "none";
	    	}
		}
		document.onmousemove=function(e)
{
  var obj = Utils.srcElement(e);
  if (typeof(obj.onclick) == 'function' && obj.onclick.toString().indexOf('listTable.edit') != -1)
  {
    obj.title = '点击修改内容';
    obj.style.cssText = 'background: #21964D;';
    obj.onmouseout = function(e)
    {
      this.style.cssText = '';
    }
  }
  else if (typeof(obj.href) != 'undefined' && obj.href.indexOf('listTable.sort') != -1)
  {
    obj.title = '点击对列表排序';
  }
}

</script>
<script type="text/javascript">
  function add_to_seokeyword(obj,keyword_id){
	
	var keyword_str = GetId(keyword_id).value;
	var keyword_str_arr = keyword_str.split(",");
	for( var i=0;i<keyword_str_arr.length;i++ ){
		if(keyword_str_arr[i]==obj.value){
			return false;
		}
	}
	if(keyword_str!=""){
		GetId(keyword_id).value+= ","+obj.value;
	}else{
		GetId(keyword_id).value+= obj.value;
	}
}
</script>
<script style="text/javascript">

  /**
   * 删除扩展供应商
   */
  function removeprovider(obj)
  {
      var row = rowindex(obj.parentNode.parentNode);
      var tbl = document.getElementById('provider-tables');

      tbl.deleteRow(row);
  }

  /**
   * 新增扩展供应商
   */
  function addprovider(obj)
  {
      var src  = obj.parentNode.parentNode;
     
      var idx  = rowindex(src); 
      var tbl  = document.getElementById('provider-tables');
      var row  = tbl.insertRow(idx + 1);
      var cell = row.insertCell(-1);
      var img_str = "";
      for( var i=0;i<src.cells.length;i++ ){
      	img_str+= src.cells[i].innerHTML.replace(/(.*)(addprovider)(.*)(\[)(\+)/i, "$1removeprovider$3$4-");
      }
	  cell.innerHTML = img_str;
      
  }


</script>


