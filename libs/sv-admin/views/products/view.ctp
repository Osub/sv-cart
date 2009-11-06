<?php 
/*****************************************************************************
 * SV-Cart 编辑商品
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 5493 2009-11-03 10:47:49Z huangbo $
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
<?php echo $html->css('colorpicker');?>
<?php echo $html->css('button');?>
<?php echo $html->css('slider');?>
<?php echo $javascript->link('/../js/yui/dragdrop-min.js');?>
<?php echo $javascript->link('/../js/yui/button-min.js');?>
<?php echo $javascript->link('/../js/yui/slider-min.js');?>
<?php echo $javascript->link('/../js/yui/colorpicker-min.js');?>
<?php echo $javascript->link('color_picker');?>	
<?php echo $javascript->link('selectzone');?>	
<?php echo $javascript->link('product');?>	
<?php echo $javascript->link('utils');?>	
<?php echo $javascript->link('listtable');?>

<script type="text/javascript">

//调色板
var lang_all = Array();
<?php foreach( $languages as $k=>$v ){?>
	lang_all[<?php echo $k?>] = "<?php echo $v['Language']['locale']?>";
<?php }?>
function font_color_picker(color_sn){
	for( var i=0; i<lang_all.length;i++){
		document.getElementById('product_name_'+lang_all[i]).style.color=color_sn;
	}
}
//促销
onload = function(){
	handlePromote(document.getElementById('ProductPromotionStatus').checked);
}
var img_id_arr = new Array();
//关键字
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
var numpri=<?php echo $market_price_rate?>;
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

</script>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories"><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."商品列表","/products/",array(),false,false);?></p>

<div class="home_main">
<ul class="tab">
	<li class="hover" id="tabs1" onclick="overtab('tabs',1,5)"><span>基本信息</span></li>
	<li class="normal" id="tabs2" onclick="overtab('tabs',2,5)"><span>详细信息</span></li>
	<li class="normal" id="tabs3" onclick="overtab('tabs',3,5)"><span>商品相册</span></li>
	<li class="normal" id="tabs4" onclick="overtab('tabs',4,5)"><span>商品属性</span></li>
	<li class="normal" id="tabs5" onclick="overtab('tabs',5,5)"><span>关联</span></li>
</ul>
<div id="con_tabs_1" class="display">
<?php echo $form->create('products',array('action'=>'view/'.$product_info['Product']['id'],"OnSubmit"=>'return products_check();'));?>
<!---判断入口-->
<input type="hidden" name="action_type" value="product_base_info"/>
<!---页面传商品主表ID-->
<input type="hidden" id="products_id" name="data[Product][id]" value="<?php echo $product_info['Product']['id'];?>" />
<!---页面传商品名样式--->
<input name="product_style_color" id="product_style_color" style="width:100px;" value="" type="hidden" />

<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
	<td align="left" width="50%" valign="top" style="padding-right:5px"><div class="order_stat athe_infos configvalues"><div class="box">
		<!--商品名称--->
		<dl><dt>商品名称: </dt><dd></dd></dl>
		<?php if(isset($languages)&&sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<!--页面传多语言ID-->
			<input type="hidden" name="data[ProductI18n][<?php echo $k;?>][id]" value="<?php echo  $product_info['ProductI18n'][$v['Language']['locale']]['id'];?>" />
			<!--页面传多语言PRODUCTID-->
			<input type="hidden" name="data[ProductI18n][<?php echo $k;?>][product_id]" value="<?php echo $product_info['Product']['id'];?>" />
			<!--页面传语言-->
			<input type="hidden" name="data[ProductI18n][<?php echo $k;?>][locale]" value="<?php echo $v['Language']['locale'];?>" />
			
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input type="text" style="width:250px;border:1px solid #649776;color:<?php echo $products_name_color;?>;" id="product_name_<?php echo $v['Language']['locale']?>" name="data[ProductI18n][<?php echo $k;?>][name]" value="<?php echo  $product_info['ProductI18n'][$v['Language']['locale']]['name'];?>" /> <font color="#ff0000">*</font></dd></dl>
		<?php }}?>
			<dl><dt></dt><dd>
				<table><tr><td>
				<select id="product_style_word" name="product_style_word">
					<option value="">字体样式</option>
					<option value="strong" <?php if($products_name_style == "strong"){?>selected<?php }?>>加粗</option>
					<option value="em" <?php if($products_name_style == "em"){?>selected<?php }?>>斜体</option>
					<option value="u" <?php if($products_name_style == "u"){?>selected<?php }?>>下划线</option>
					<option value="strike" <?php if($products_name_style == "strike"){?>selected<?php }?>>删除线</option>
				</select>
				</td><td><span id="button-container"></span></td></tr></table>
			</dd></dl>
		
		<!--款号名称--->
		<dl><dt>款号名称: </dt><dd></dd></dl>
		<?php if(isset($languages)&&sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input type="text" style="width:250px;border:1px solid #649776;" id="product_name_<?php echo $v['Language']['locale']?>" name="data[ProductI18n][<?php echo $k;?>][style_name]" value="<?php echo  $product_info['ProductI18n'][$v['Language']['locale']]['style_name'];?>" /></dd></dl>
		<?php }}?>
		
		<!--商品关键词--->
		<dl><dt>商品关键词: </dt><dd></dd></dl>
		<?php if(isset($languages)&&sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt>
				<?php echo $html->image($v['Language']['img01'])?></dt><dd><input type="text" style="width:250px;border:1px solid #649776;" id="ProductI18n<?php echo $k;?>MetaKeywords" name="data[ProductI18n][<?php echo $k;?>][meta_keywords]" value="<?php echo  $product_info['ProductI18n'][$v['Language']['locale']]['meta_keywords'];?>" />
				<select style="width:90px;border:1px solid #649776" onchange="add_to_seokeyword(this,'ProductI18n<?php echo $k;?>MetaKeywords')">
					<option value='常用关键字'>常用关键字</option>
					<?php foreach( $seokeyword_data as $sk=>$sv){?>
						<option value='<?php echo $sv["SeoKeyword"]["name"]?>'><?php echo $sv["SeoKeyword"]["name"]?></option>
					<?php }?>
				</select>
			</dd></dl>
		<?php }}?>
		
		<!--商品简单描述--->
		<dl><dt>商品简单描述: </dt><dd></dd></dl>
		<?php if(isset($languages)&&sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><textarea style="width:250px;border:1px solid #649776;" name="data[ProductI18n][<?php echo $k;?>][meta_description]" ><?php echo $product_info['ProductI18n'][$v['Language']['locale']]['meta_description'];?></textarea></dd></dl>
		<?php }}?>

		<!--商品网站网址--->
		<dl><dt>商品网站网址: </dt><dd></dd></dl>
		<?php if(isset($languages)&&sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input type="text" style="width:250px;border:1px solid #649776;" id="product_name_<?php echo $v['Language']['locale']?>" name="data[ProductI18n][<?php echo $k;?>][api_site_url]" value="<?php echo  $product_info['ProductI18n'][$v['Language']['locale']]['api_site_url'];?>" /></dd></dl>
		<?php }}?>

		<!--购物车快捷网址--->
		<dl><dt>购物车快捷网址: </dt><dd></dd></dl>
		<?php if(isset($languages)&&sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input type="text" style="width:250px;border:1px solid #649776;" id="product_name_<?php echo $v['Language']['locale']?>" name="data[ProductI18n][<?php echo $k;?>][api_cart_url]" value="<?php echo  $product_info['ProductI18n'][$v['Language']['locale']]['api_cart_url'];?>" /></dd></dl>
		<?php }}?>
				
		<!--商家备注--->
		<dl><dt>商家备注: </dt><dd></dd></dl>
		<?php if(isset($languages)&&sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><textarea style="width:250px;border:1px solid #649776;" name="data[ProductI18n][<?php echo $k;?>][seller_note]" ><?php echo  @$product_info['ProductI18n'][$v['Language']['locale']]['seller_note'];?></textarea></dd></dl>
		<?php }}?>
				
		<!--发货备注--->
		<dl><dt>发货备注: </dt><dd></dd></dl>
		<?php if(isset($languages)&&sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><textarea style="width:250px;border:1px solid #649776;" name="data[ProductI18n][<?php echo $k;?>][delivery_note]" ><?php echo  @$product_info['ProductI18n'][$v['Language']['locale']]['delivery_note'];?></textarea></dd></dl>
		<?php }}?>

		
	</div></div></td>
	<td align="left" width="50%" valign="top" ><div class="order_stat athe_infos configvalues"><div class="box">
		<!--商品货号-->
		<dl><dt>商品货号: </dt><dd><input type="text" style="width:100px;border:1px solid #649776" value="<?php echo  $product_info['Product']['code'];?>" id="ProductCode" name="data[Product][code]" onblur="product_code_unique(this,<?php echo $product_info['Product']['id']?>)" /></dd></dl>
		
		<!--商品分类-->
		<dl><dt>商品分类: </dt><dd>
		<select id="ProductsCategory" name="data[Product][category_id]" style="width:100px">
			<option value="0">所有分类</option>
			<?php if(isset($product_cat) && sizeof($product_cat)>0){?><?php foreach($product_cat as $first_k=>$first_v){?>
			<option value="<?php echo $first_v['Category']['id'];?>" <?php if($product_info['Product']['category_id'] == $first_v['Category']['id']){?>selected<?php }?> ><?php echo $first_v['CategoryI18n']['name'];?></option>
			<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
			<option value="<?php echo $second_v['Category']['id'];?>" <?php if($product_info['Product']['category_id'] == $second_v['Category']['id']){?>selected<?php }?>>&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
			<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
			<option value="<?php echo $third_v['Category']['id'];?>" <?php if($product_info['Product']['category_id'] == $third_v['Category']['id']){?>selected<?php }?> >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
			<?php }}}}}}?>
		</select> <font color="#ff0000">*</font>
		</dd></dl>
		
		<!--扩展分类-->
		<dl><dt>扩展分类: </dt><dd><span style='float:left;'><input class="pointer" type="button" value="添加" onclick="addOtherCat()"/>&nbsp;</span>
		<span style='float:left;width:211px;padding-top:1px;'>
  		<?php if(!empty($other_category_list)){foreach($other_category_list as $k=>$v){?>
		    <select name="other_cat[]" style='margin-bottom:2px;'>
		       	<option value="0">请选择</option>
		       	<?php if(isset($product_cat) && sizeof($product_cat)>0){?><?php foreach($product_cat as $first_k=>$first_v){?>
				<option value="<?php echo $first_v['Category']['id'];?>" <?php if($v['ProductsCategory']['category_id'] == $first_v['Category']['id']){?>selected<?php }?>><?php echo $first_v['CategoryI18n']['name'];?></option>
				<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
				<option value="<?php echo $second_v['Category']['id'];?>" <?php if($v['ProductsCategory']['category_id'] == $second_v['Category']['id']){?>selected<?php }?>>&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
				<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
				<option value="<?php echo $third_v['Category']['id'];?>" <?php if($v['ProductsCategory']['category_id'] == $third_v['Category']['id']){?>selected<?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
				<?php }}}}}}?>
		    </select>
		<?php }}?>
		<div id="other_cats"></div>
		</span>

		</dd></dl>
		
		<!--商品品牌-->
		<?php if(!empty($brands_tree)){?>
		<dl><dt>商品品牌: </dt><dd>		
			<select id="ProductBrandId" name="data[Product][brand_id]">
		 	<option value="0">所有品牌</option>
		    <?php if(isset($brands_tree) && sizeof($brands_tree)>0){?>
		    <?php foreach($brands_tree as $k=>$v){?>
			<option value="<?php echo $v['Brand']['id']?>" <?php if($v['Brand']['id']==$product_info['Product']['brand_id']){?>selected<?php }?> ><?php echo $v['BrandI18n']['name']?></option>
		    <?php }}?>
			</select>
		</dd></dl>
		<?php }?>
		
		<!--供应商-->
		<?php if(!empty($provides_tree)){?>
		<dl><dt>供应商: </dt><dd>
			<select id="ProductproviderId" name="data[Product][provider_id]">
		    <option value="0">请选择....</option>
		    <?php if(isset($provides_tree) && sizeof(provides_tree)>0){?>
		    <?php foreach($provides_tree as $k=>$v){?>
		         <option value="<?php echo $v['Provider']['id']?>" <?php if($product_info['Product']['provider_id'] == $v['Provider']['id']){?>selected<?php }?>><?php echo $v['Provider']['name']?></option>
		    <?php }}?>
			</select>
		</dd></dl>
		<?php }?>
		
		<!--进货价-->
		<dl><dt>进货价: </dt><dd><input type="text" style="width:100px;border:1px solid #649776" name="data[Product][purchase_price]" value="<?php echo  $product_info['Product']['purchase_price'];?>" /> </dd></dl>
		
		<!--扩展供应商-->
		<?php if(!empty($provides_tree)){?>
		<dl><dt>扩展供应商：</dt>
		<dd>
			<table id="provider-tables">
	  		<?php if(!empty($other_provides_list)){$pij=1;?>
			<?php foreach($other_provides_list as $pk=>$pv){?>
			<tr><td><?php if($pij==1){?><a href="javascript:;" name="1" onclick="addprovider(this)">[+]</a><?php }else{?><a href="javascript:;" name="1" onclick="removeprovider(this)">[-]</a><?php }$pij++;?>
				<select  name="other_provider[]" style='margin-bottom:2px;'>
			    <option value="0">请选择....</option>
			    <?php if(isset($provides_tree) && sizeof($provides_tree>provides_tree)>0){?>
			    <?php foreach($provides_tree as $k=>$v){?>
			         <option value="<?php echo $v['Provider']['id']?>" <?php if($pv['ProviderProduct']['provider_id'] == $v['Provider']['id']){ echo "selected"; }?>><?php echo $v['Provider']['name']?></option>
			    <?php }}?>
				</select> 进价：<input type="text" style="width:75px;border:1px solid #649776" name="other_provider_price[]" value="<?php echo $pv['ProviderProduct']['price'];?>"/></td>
			</tr>
			<?php }?><?php }else{?>
				<tr>
				<td><a href="javascript:;" name="1" onclick="addprovider(this)">[+]</a><select  name="other_provider[]" style='margin-bottom:2px;'>
			    <option value="0">请选择....</option>
			    <?php if(isset($provides_tree) && sizeof($provides_tree>provides_tree)>0){?>
			    <?php foreach($provides_tree as $k=>$v){?>
			         <option value="<?php echo $v['Provider']['id']?>"><?php echo $v['Provider']['name']?></option>
			    <?php }}?>
				</select> 进价：<input type="text" style="width:75px;border:1px solid #649776" name="other_provider_price[]" /></td>
			</tr>
			<?php }?>
			</table>
		</dd></dl><?php }?>
		
		<!--市场售价-->
		<dl><dt>市场售价: </dt><dd><input type="text" style="width:150px;border:1px solid #649776" id="ProductMarketPrice" name="data[Product][market_price]" value="<?php echo  $product_info['Product']['market_price'];?>" /><input class="pointer" type="button" value="取整数" onclick="integral_market_price()"/></dd></dl>
		
		<!--本店售价-->
		<dl><dt>本店售价: </dt><dd><input type="text" style="width:150px;border:1px solid #649776" id="ProductShopPrice" name="data[Product][shop_price]" value="<?php echo  $product_info['Product']['shop_price'];?>" /><input type="button" class="pointer" value="按市场价计算" onclick="marketPriceSetted()"/> <font color="#ff0000">*</font></dd></dl>
		
		<!--会员价格-->
		<dl><dt>会员价格: </dt><dd>
		<table>
			<?php foreach($user_rank_list as $k=>$v){?>
			<tr>
				<td><?php echo $v["UserRank"]["name"];?></td>
				<td><input type="text" style="width:75px;border:1px solid #649776" id="rank_product_price<?php echo $k?>" name="product_rank_price[<?php echo $v['UserRank']['id']?>]" value="<?php echo empty($product_rank[$v['UserRank']['id']]['ProductRank']['product_price'])?0:$product_rank[$v['UserRank']['id']]['ProductRank']['product_price'];?>"></td>
				<td>折扣率:</td>
				<td><input type="text" style="width:40px;border:1px solid #649776" id="user_price_discount<?php echo $k?>" name="user_rank[<?php echo $v['UserRank']['id']?>]" value="<?php echo empty($v['UserRank']['discount'])?0:$v['UserRank']['discount'];?>"></td>
				<td><input type="checkbox" value="1" name="product_rank_is_default_rank[<?php echo $v['UserRank']['id']?>]" <?php if(!empty($product_rank[$v['UserRank']['id']]['ProductRank']['is_default_rank'])&&$product_rank[$v['UserRank']['id']]['ProductRank']['is_default_rank']!=0){ echo "checked";}?> onclick="user_prince_check(this.checked,<?php echo $k?>)" >自动按照比例结算</td>
			</tr>
			<?php }?>
		</table>
		</dd></dl>
		
		<!--优惠价格-->
		<dl><dt>优惠价格: </dt><dd>
		<table id="prodcut_volumes-tables">
			<?php $ij=1;if(isset($prodcutvolume_info) && sizeof($prodcutvolume_info)>0){?><?php foreach($prodcutvolume_info as $k=>$v){?>
			<tr><td><?php if($ij==1){?><a href="javascript:;" name="1" onclick="add_prodcut_volumes(this)">[+]</a><?php }else{ ?><a href="javascript:;" name="1" onclick="remove_prodcut_volumes(this)">[-]</a> <?php }$ij++;?> 数量 <input type="text"  style="width:80px;border:1px solid #649776" name="volume_number[]" value="<?php echo $v['ProdcutVolume']['volume_number']?>" /> 价格 <input type="text" style="width:80px;border:1px solid #649776" name="volume_price[]" value="<?php echo $v['ProdcutVolume']['volume_price']?>" /></td></tr>
			<?php }}else{?>
			<tr><td><a href="javascript:;" name="1" onclick="add_prodcut_volumes(this)">[+]</a> 数量 <input type="text"  style="width:80px;border:1px solid #649776" name="volume_number[]" /> 价格 <input type="text" style="width:80px;border:1px solid #649776" name="volume_price[]"  /></td></tr>
			<?php }?>
		</table>
		</dd></dl>
		
		<!--赠送积分数-->
		<dl><dt>赠送积分数: </dt><dd><input type="text" style="width:150px;border:1px solid #649776" name="data[Product][point]" value="<?php echo @$product_info['Product']['point'];?>" /> </dd></dl>
		
		<!--积分购买额度-->
		<dl><dt>积分购买额度: </dt><dd><input type="text" style="width:150px;border:1px solid #649776" name="data[Product][point_fee]" value="<?php echo @$product_info['Product']['point_fee'];?>" /> </dd></dl>
		
		<!--促销价-->
		<dl><dt  class="promotion"><label for="ProductPromotionStatus"><input class="checkbox" type="checkbox" id="ProductPromotionStatus" name="data[Product][promotion_status]" value="1" onclick="handlePromote(this.checked);"  <?php if($product_info['Product']['promotion_status'] == 1){?>checked<?php }?>/>促销价：</label></dt><dd><input type="text" style="width:100px;border:1px solid #649776" name="data[Product][promotion_price]" id="ProductPromotionPrice" value="<?php echo $product_info['Product']['promotion_price']?>" /> </dd></dl>
		
		<!--促销日期-->
		<dl><dt>促销日期: </dt><dd>
			<input style="width:90px;" class="text_inputs" type="text" id="date" name="date" value="<?php if($product_info['Product']['promotion_status'] == 1){?><?php echo date('Y-m-d',strtotime($product_info['Product']['promotion_start']));?><?php }?>"  readonly/><?php echo $html->image("calendar.gif",array("id"=>"show","class"=>"calendar_edit"))?>
			<input type="text" style="width:90px;" class="text_inputs" id="date2" name="date2" value="<?php if($product_info['Product']['promotion_status'] == 1){?><?php echo date('Y-m-d',strtotime($product_info['Product']['promotion_end']));?><?php }?>"  readonly/><?php echo $html->image("calendar.gif",array("id"=>"show2","class"=>"calendar_edit"))?> 
		</dd></dl>
		
		<!--商品重量-->
		<dl><dt>商品重量: </dt><dd><input type="text" style="width:150px;border:1px solid #649776" name="data[Product][weight]" value="<?php echo $product_info['Product']['weight']?>" /> </dd></dl>
		
		<!--商品库存数量-->
		<dl><dt>商品库存数量: </dt><dd><input type="text" style="width:150px;border:1px solid #649776" name="data[Product][quantity]" value="<?php echo $product_info['Product']['quantity']?>" /> </dd></dl>
		
		<!--库存警告数量-->
		<dl><dt>库存警告数量: </dt><dd><input type="text" style="width:150px;border:1px solid #649776" name="data[Product][warn_quantity]" value="<?php echo $product_info['Product']['warn_quantity'];?>" /> </dd></dl>
		
		<!--销售量-->
		<dl><dt>销售量: </dt><dd><input type="text" style="width:150px;border:1px solid #649776" name="data[Product][sale_stat]" value="<?php echo $product_info['Product']['sale_stat'];?>" /> </dd></dl>
		
		<!--加入推荐-->
		<dl><dt>加入推荐: </dt><dd><input class="checkbox" type="checkbox" name="data[Product][recommand_flag]" id="ProductRecommandFlag"value="1"<?php if($product_info['Product']['recommand_flag'] == 1){?>checked<?php }?>/>推荐</dd></dl>
		
		<!--上架-->
		<dl><dt>上架: </dt><dd><input class="checkbox" type="checkbox" name="data[Product][forsale]" id="ProductForsale"value="1"<?php if($product_info['Product']['forsale'] == 1){?>checked<?php }?>/>打钩表示能作为普通商品销售，否则不允许销售。</dd></dl>
		
		<!--能作为普通商品销售-->
		<dl><dt>能作为普通商品销售: </dt><dd><input type="checkbox" class="checkbox" name="data[Product][alone]" id="ProductAlone"value="1"<?php if($product_info['Product']['alone'] == 1){?>checked<?php }?>/>打钩表示允许销售，否则只能作为配件或赠品销售。</dd></dl>
		
		<!--是否显示款号颜色图-->
		<dl><dt>是否显示款号颜色图: </dt><dd><input type="radio" class="checkbox" name="data[Product][is_colors_gallery]" value="1" <?php if($product_info['Product']['is_colors_gallery'] == 1){ ?>checked<?php } ?> />是<input type="radio" class="checkbox" name="data[Product][is_colors_gallery]" value="0" <?php if($product_info['Product']['is_colors_gallery'] == 0){ ?>checked<?php } ?>  />否</dd></dl>
		
		<!--过往精品-->
		<dl><dt>过往精品: </dt><dd><input type="radio" class="checkbox" name="data[Product][bestbefore]" value="1" <?php if($product_info['Product']['bestbefore'] == 1){ ?>checked<?php } ?> />是<input type="radio" class="checkbox" name="data[Product][bestbefore]" value="0" <?php if($product_info['Product']['bestbefore'] == 0){ ?>checked<?php } ?>  />否</dd></dl>
		
		<!--商品款号-->
		<dl><dt>商品款号: </dt><dd><input type="text" style="width:150px;border:1px solid #649776" name="data[Product][style_code]" value="<?php echo  @$product_info['Product']['style_code'];?>" /> </dd></dl>
		
		<!--商品款号颜色图-->
		<dl><dt>商品款号颜色图: </dt><dd>
			<input type="text" style="width:150px;border:1px solid #649776" id="upload_img_text_10000" name="data[Product][colors_gallery]" value="<?php echo  @$product_info['Product']['colors_gallery'];?>" readonly /> 
		  	
			<?php echo $html->link($html->image('select_img.gif',array("class"=>"vmiddle icons","height"=>"20")),"javascript:img_sel(10000,'products')",'',false,false)?>
			<?php echo @$html->image("/..".$product_info['Product']['colors_gallery'],array('id'=>'logo_thumb_img_10000','height'=>'100','style'=>!empty($product_info['Product']['colors_gallery'])?'display:block':'display:none'))?>

		</dd></dl>
	</div></div></td>
</tr>
</table>

<?php if(isset($SVConfigs['mlti_currency_module'])&&$SVConfigs['mlti_currency_module']==1){?>
<!--语言价-->
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
			<th width="8%">是否有效</th></tr>
			<?php if(isset($languages) && sizeof($languages) >0){foreach($languages as $k=>$v){?>
			<tr>
				<td align="center"><?php echo $v['Language']['name']?></td>
				<td align="center"><input type="text"  style="border:1px solid #649776"  name="locale_product_price[<?php echo $v['Language']['locale']?>][product_price]" value="<?php echo @$productlocaleprice_info[$v['Language']['locale']]['ProductLocalePrice']['product_price']?>"  /></td>
				<td align="center"><input type="checkbox" style="border:1px solid #649776" name="locale_product_price[<?php echo $v['Language']['locale']?>][status]" value="1" <?php if(@$productlocaleprice_info[$v['Language']['locale']]['ProductLocalePrice']['status'] == 1){?>checked<?php }?> > <input type="hidden" name="locale_product_price[<?php echo $v['Language']['locale']?>][id]" value="<?php echo @$productlocaleprice_info[$v['Language']['locale']]['ProductLocalePrice']['id']?>" ></td>
			</tr>
			<?php }}?>
		</table>
		</div>
	</div>
</div>
<!--语言价 End-->
<?php }?>
<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
</div>


<!--详细信息-->
<div id="con_tabs_2" class="none">
	<div class="order_stat properies">
	  	<div class="box">
		    <?php if($SVConfigs["select_editor"]=="2"||empty($SVConfigs["select_editor"])){?>
		  	<?php echo $javascript->link('tinymce/tiny_mce/tiny_mce'); ?>
		  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		  	<table><tr><td valign="top">
		  	<?php echo $html->image($v['Language']['img01'])?></td><td valign="top">
			<textarea id="elm<?php echo $v['Language']['locale'];?>" name="data[ProductI18n][<?php echo $k;?>][description]" rows="15" cols="80" style="width: 80%"><?php echo $product_info['ProductI18n'][$v['Language']['locale']]['description'];?></textarea>
			<?php  echo $tinymce->load("elm".$v['Language']['locale'],$now_locale); ?><br /><br />
	    	</td></tr>
	    	</table>
	    	<?php }?>
			<?php }?><?php }?>
			<?php if($SVConfigs["select_editor"]=="1"){?>
		  	<?php echo $javascript->link('fckeditor/fckeditor'); ?>
			<?php  if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		  	<?php echo $html->image($v['Language']['img01'])?><br />
	       	<?php echo $form->textarea('ProductI18n/description', array("cols" => "60","rows" => "10","value" => "{$product_info['ProductI18n'][$v['Language']['locale']]['description']}","name"=>"data[ProductI18n][{$k}][description]","id"=>"ProductI18n{$k}Description"));?>
	        <?php  echo $fck->load("ProductI18n{$k}/description"); ?><br /><br />
			<?php }}}?>
		</div>
	</div>
	<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
</div>
<?php  echo $form->end();?>


<!--商品相册-->
<?php echo $form->create('',array('action'=>"view/".$product_info['Product']['id']));?>
<div id="con_tabs_3" class="none">
	<div class="order_stat properies">
	  <div class="box">
	  
	  <input type="hidden" name="action_type" value="product_gallery"></>
	  <div id="gallery-table">
	  <ul class="photos">
	  <input name="product_id" id="ProductId" type="hidden" value="<?php echo  $product_info['Product']['id'];?>">
	  <?php if(isset($thisproduct_gallery['ProductGallery']) && sizeof($thisproduct_gallery['ProductGallery'])>0){?>
	  <?php foreach($thisproduct_gallery['ProductGallery'] as $k=>$v){?>
	  <li>
	  	<input type="hidden" name="data[ProductGallery][<?php echo $k?>][id]"  id="ProductGallery<?php echo $k?>Id" value="<?php echo $v['id']?>">
		<p>[<?php echo $html->link("-","javascript:;",array("onclick"=>"layer_dialog();layer_dialog_show('确定要删除相册图片吗?','dropImg({$v['id']})',5);"),false,false);?>]</p>
		<p><?php if($v['img_thumb']){$imgaddr = substr($v['img_thumb'], 0, 7)=="http://"?" ":"/..";?><?php echo $html->link($html->image("{$imgaddr}{$v['img_thumb']}",array('align'=>'absmiddle','width'=>'108','height'=>'108')),"/..{$v['img_thumb']}",'',false,false);?>
		<?php }else{?><?php echo $html->image("/..{$v['img_detail']}",'');?><?php }?></p>
		<dl class="edit_photo">
		<dd>图片描述 :</dd>
		<dt></dt></dl>
		<?php  if(isset($languages) && sizeof($languages)>0){
		foreach ($languages as $lk => $lv){?>
		<dl class="edit_photo">
		<dd><?php echo $html->image($lv['Language']['img01'])?></dd>
		<dt>
			<input class="green_border" type="text" style='width:98%'  name="ProductGalleryI18ndescription[<?php echo $k?>][ProductGalleryI18n][<?php echo $lk?>][description]"   value="<?php echo @$v['ProductGalleryI18n'][$lv['Language']['locale']]['description']?>" id="ProductGallery<?php echo $k?>Description"/>
			<input type="hidden" name="ProductGalleryI18ndescription[<?php echo $k?>][ProductGalleryI18n][<?php echo $lk?>][product_gallery_id]" value="<?php echo $v['id']?>">
			<input type="hidden" name="ProductGalleryI18ndescription[<?php echo $k?>][ProductGalleryI18n][<?php echo $lk?>][locale]" value="<?php echo $lv['Language']['locale']?>">
		</dt>
		</dl><?php }}?>
		<dl class="edit_photo">
		<dd>排序: </dd>
		<dt><input class="green_border" type="text" style='width:98%' size="3" value="<?php echo $v['orderby']?>" name="data[ProductGallery][<?php echo $k?>][orderby]"  id="ProductGallery<?php echo $k?>Orderby" />
		</dt>
		</dl>
		<dl class="edit_photo">
		<dd>&nbsp;</dd>
		<dt>
		<?php if($v['img_thumb'] != $product_info['Product']['img_thumb'])?><span name="default_gallery_img[]" id="default_gallery_img_<?php echo $v['id']?>" style="display:<?php if($v['img_thumb'] != $product_info['Product']['img_thumb']){echo 'block';}else{echo 'none';}?>">
		<?php echo $html->link($html->image('default.gif',$title_arr['edit']),"javascript:default_gallery('{$v['id']}','{$product_info['Product']['id']}');","",false,false)?></span>
		<a name="default_gallery[]" id="default_gallery_<?php echo $v['id']?>" style="display:<?php if($v['img_thumb'] == $product_info['Product']['img_thumb']){echo 'block';}else{echo 'none';}?>  "><span style="font-size:13px"> 默认</span></a></dt>
		</dl>
		</li>
	   <script>
	   	   img_id_arr[<?php echo $k?>] = "default_gallery_img_<?php echo $v['id']?>";
	   </script>
	   <?php }?>
     <?php }?>
	  </ul>
	  	  <br /><br /><br /> 
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
				<?php }}?>排序: <input type="text" name="img_sort[1]" id="img_sort[1]" size="2" style="border:1px solid #649776"/><input type="radio" name="img_def" value="9999">默认
			 	<br /><?php echo @$html->image("",array('id'=>"logo_thumb_img_9999","style"=>"display:none"))?>
				</td>
	</tr>
	</table>
	</div>
	  </div><br /><br />
<!--默认图-->
<div class="order_stat properies">
	<div class="title"><h1>
	<?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	<?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	默认图</h1></div>
	<div class="box">
		<table>
		<tr>默认图片地址：<input type="text" name="img_url_default" style="width:270px;border:1px solid #649776"  id="upload_img_text_99999" value="<?php echo $product_info['Product']['img_thumb']?>" /><?php echo $html->link($html->image('select_img.gif',array("class"=>"vmiddle icons","height"=>"20")),"javascript:img_sel('99999','products')",'',false,false)?></td></tr>
		<tr><td><?php if($product_info["Product"]['img_thumb']){$imgaddr = substr($product_info["Product"]['img_thumb'], 0, 7)=="http://"?" ":"/..";?><?php echo $html->image("{$imgaddr}{$product_info['Product']['img_thumb']}",array('id'=>"logo_thumb_img_99999",'align'=>'absmiddle','width'=>'108','height'=>'108'));}else{?><?php echo $html->image("a",array('id'=>"logo_thumb_img_99999",'align'=>'absmiddle','width'=>'108','height'=>'108',"style"=>'display:none'));}?></td></tr>
		</table>
	</div>
</div>
<!--可选商品图-->
<?php if(count($select_img_name)>0){?>
<div class="order_stat properies">
	<div class="title"><h1>
	<?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	<?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	可选商品图</h1></div>
	<div class="box">
		<div id="listDiv">
		<table cellpadding="0" cellspacing="0" width="100%"  class="list_data">
					<tr><th>注：以下是该商品文件夹中未进相册的图片，可以点击图片名称查看</th><tr>
		</table>
		<table cellpadding="0" cellspacing="0" width="100%"  class="list_data">
					
		<tr><th><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:imgselectAll(this, "select_img_addr")'/>图片名称</th><th colspan="<?php echo count($languages)*2;?>">描述</th><th align="left">排序</th></tr>
		<?php foreach( $select_img_name as $k=>$v ){?>
			<tr>
			<td width="10%"><input type="checkbox" name="select_img_addr[<?php echo $k;?>]" value="<?php echo $v;?>"><?php echo $html->link($k,$server_host.$v,array("target"=>"_blank"),false,false);?></td>
			<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $kk => $vv){?>
			<td width="3%"><?php echo $html->image($vv['Language']['img01'],array("class"=>"vmiddle"))?></td><td  width="3%"><input type="text" style="width:100px;border:1px solid #649776" name="select_img_addr_desc[<?php echo $vv['Language']['locale']?>][<?php echo $k;?>]" /></td>
			<?php }}?>
			<td><input type="text" size="2" style="border:1px solid #649776" name="select_img_addr_orderby[<?php echo $k;?>]"/></td>
			</tr>
		<?php } ?>
		
		</table>
		</div>
	</div>
<?php }?>
		<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
</div>
</div>

<?php  echo $form->end();?>

<!--商品属性-->
<div id="con_tabs_4" class="none">
<?php $product_type_list=$this->requestAction("/commons/product_type_list/".$product_info['Product']['product_type_id']."");?>
	<?php if(!empty($product_type_list)){?>
	<div class="order_stat properies">
	  <div class="box">
	  <?php echo $form->create('',array('action'=>"view/".$product_info['Product']['id'],'name'=>"ProAttrForm","id"=>"ProAttrForm"));?>

	  <input type="hidden" name="action_type" value="product_attr" />
      <input id="ProductId" name="data[Product][id]" type="hidden" value="<?php echo  $product_info['Product']['id'];?>">
	  <div class="properies_left">
	  
		<dl><dt>&nbsp;</dt><dd>
		<select name="product_type" id="product_type" onchange="getAttrList(<?php echo  $product_info['Product']['id'];?>)">
		  <option value="">请选择</option>
          <?php echo $product_type_list;?>
		</select></dd></dl>

		<span id="productsAttr"><?php echo $products_attr_html;?></span>
		</div>
		<div style="clear:both"></div>
		<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>

	  </div>
	</div><?php }?><?php  echo $form->end();?>
	
</div>
		
		
		
<!--关联商品-->
<div id="con_tabs_5" class="none">
<!--Product Relative-->
	<div class="order_stat properies">
	  <div class="box" style="padding-top:20px;">
	  <h3>关联商品</h3>
	  <?php echo $form->create('',array('action'=>'','name'=>"linkForm","id"=>"linkForm","onsubmit"=>"return false;"));?>
		<p class="select_cat">
		<?php echo $html->image('serach_icon.gif',array('align'=>'absmiddle'))?>
		<select name="category_id" id="category_id" style="width:120px;">
		<option value="0">所有分类</option>
		<?php if(isset($product_cat) && sizeof($product_cat)>0){?><?php foreach($product_cat as $first_k=>$first_v){?>
<option value="<?php echo $first_v['Category']['id'];?>"><?php echo $first_v['CategoryI18n']['name'];?></option>
<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?php echo $second_v['Category']['id'];?>">&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?php echo $third_v['Category']['id'];?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
<?php }}}}}}?>
		</select>
		<select name="brand_id" id="brand_id" style="width:120px;">
		<option value="0">所有品牌</option>
		<?php if(isset($brands_tree) && sizeof($brands_tree)>0){?>
		<?php foreach($brands_tree as $k=>$v){?>
	  <option value="<?php echo $v['Brand']['id']?>"><?php echo $v['BrandI18n']['name']?></option>
	<?php }}?>
		</select>
		<input type="text" class="text_input" name="keywords" id="keywords"/>
		<input type="button" value="搜 索" class="search" onclick="searchProducts();"/></p>
		<table width="100%" class="relative_product">
			<tr>
				<td valign="top" width="40%">
				<p><strong>可选商品</strong></p>
				<p><select name="source_select1" id="source_select1" size="20" style="width:100%" ondblclick="add_relation_product('insert_link_products',<?php echo $product_info['Product']['id']?>,this,'P',this.form.elements['is_single'][0].checked);"multiple="true"></p>
				</td>
				<td valign="top" width="12%" align="center">
				<p><strong>操作</strong></p>
				<p class="relative_radio">
				<label><input type="radio" name="is_single" id="is_single" value="1" checked/>单向关联</label><br />
				<label><input type="radio"  name="is_single" id="is_single" value="0"/>双向关联</label></p>
				<p class="direction">
				<input type="button" class="pointer" value=">" onclick="add_relation_product('insert_link_products',<?php echo $product_info['Product']['id']?>,document.getElementById('source_select1'),'P',this.form.elements['is_single'][0].checked);"/><br /><br />
				</p>
				</td>
				<td valign="top" width="40%">
				<p><strong>跟该商品关联的商品排序</strong></p>
				<div class="relativies_box">
				<div id="target_select1">
				<?php if(isset($product_relations) && sizeof($product_relations)>0){?>
                      <?php foreach($product_relations as $k=>$v){?>
                             <?php if (isset($v['Product'])){?>
                           <p class="rel_list">
                           <span class="handle">
						   排序:<span onclick="javascript:listTable.edit(this, 'products/update_orderby/P/',<?php echo $v['ProductRelation']['id']?>)"><?php echo $v['ProductRelation']['orderby']?></span>
                           <?php echo $html->image('delete1.gif',array('align'=>'absmiddle',"onMouseout"=>"onMouseout_deleteimg(this)","onmouseover"=>"onmouseover_deleteimg(this)","onclick"=>"drop_relation_product('drop_link_products',".$product_info['Product']['id'].",".$v['ProductRelation']['related_product_id'].",'P');"));?>
                           	   </span><?php echo $v['ProductI18n']['name']?>
                            <?php }?>
                      <?php }}?>
                      </div>
               </div></td>
			</tr>
		</table>
<?php  echo $form->end();?>
	  </div>
	</div>
<!--Product Relative End-->
<!--Article Relative-->
<div class="order_stat properies">
	<h3>关联文章</h3>
	<div class="box">
		<?php echo $form->create('',array('action'=>'','name'=>"articleForm","id"=>"articleForm","onsubmit"=>"return false;"));?>
		<p class="select_cat">
		<?php echo $html->image('serach_icon.gif',array('align'=>'absmiddle'))?>
		<input type="text" class="text_input" name="keywords_id" id="keywords_id">
		<select name="article_cat" id="article_cat" style="width:120px;">
			<option value="all">文章分类</option>
			<?php if(isset($article_cat) && sizeof($article_cat)>0){?><?php foreach($article_cat as $first_k=>$first_v){if($first_v["Category"]["type"] == "A"){?>
			<option value="<?php echo $first_v['Category']['id'];?>"  ><?php echo $first_v['CategoryI18n']['name'];?></option>
			<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
			<option value="<?php echo $second_v['Category']['id'];?>"  >&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
			<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
			<option value="<?php echo $third_v['Category']['id'];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
			<?php }}}}}}}?>
		</select>
		<input type="button" value="搜 索" class="search" onclick="searchArticles()"/></p>
		<table cellspacing="0" cellpadding="0" width="100%" class="relative_product">
			<tr>
				<td valign="top" width="40%">
				<p><strong>可选商品</strong></p>
				<p><select name="source_select2" id="source_select2" size="20" style="width:100%" ondblclick="add_relation_product('insert_product_articles',<?php echo $product_info['Product']['id']?>,this,'PA',this.form.elements['is_single2'][0].checked);"multiple="true"></p>
				</td>
				<td valign="top" width="12%" align="center">
				<p><strong>操作</strong></p>
				<p class="relative_radio">
				<label><input type="radio" name="is_single2" id="is_single2" value="1" checked/>单向关联</label><br />
				<label><input type="radio"  name="is_single2" id="is_single2" value="0"/>双向关联</label></p>
				<p class="direction">
				<input type="button" class="pointer" value=">" onclick="add_relation_product('insert_product_articles',<?php echo $product_info['Product']['id']?>,document.getElementById('source_select2'),'PA',this.form.elements['is_single2'][0].checked);"/><br /><br />
				</p>
				</td>
				<td valign="top" width="40%">
				<p><strong>跟该商品关联的商品</strong></p>
				<div class="relativies_box">
              	<div id="target_select2">
            	<?php if(isset($product_articles) && sizeof($product_articles)>0){?>
                      <?php foreach($product_articles as $k=>$v){?>
                          <?php if (isset($v['Article'])){?>
                           <p class="rel_list">
                           <span class="handle">
						   排序:<span onclick="javascript:listTable.edit(this, 'products/update_orderby/PA/',<?php echo $v['ProductArticle']['id']?>)"><?php echo $v['ProductArticle']['orderby']?></span>
                           <?php echo $html->image('delete1.gif',array('align'=>'absmiddle',"onMouseout"=>"onMouseout_deleteimg(this)","onmouseover"=>"onmouseover_deleteimg(this)","onclick"=>"drop_relation_product('drop_product_articles',".$product_info['Product']['id'].",".$v['ProductArticle']['article_id'].",'PA');"));?>
                           </span>
                           <?php echo $v['Article']['title']?>
</p>
                        <?php }?>
                   <?php }}?>  
               </div>
              </div></td>
			</tr>
		</table>
		
<?php  echo $form->end();?>
	  </div>
	</div>
<!--Article Relative End-->

</div>



</div>

<!--ConfigValues End-->
</div>
<!--Main End-->
</div>
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
  /**
   * 删除优惠
   */
  function remove_prodcut_volumes(obj)
  {
      var row = rowindex(obj.parentNode.parentNode);
      var tbl = document.getElementById('prodcut_volumes-tables');

      tbl.deleteRow(row);
  }

  /**
   * 新增优惠
   */
  function add_prodcut_volumes(obj)
  {
      var src  = obj.parentNode.parentNode;
     
      var idx  = rowindex(src); 
      var tbl  = document.getElementById('prodcut_volumes-tables');
      var row  = tbl.insertRow(idx + 1);
      var cell = row.insertCell(-1);
      var img_str = "";
      for( var i=0;i<src.cells.length;i++ ){
      	img_str+= src.cells[i].innerHTML.replace(/(.*)(add_prodcut_volumes)(.*)(\[)(\+)/i, "$1remove_prodcut_volumes$3$4-");
      }
	  cell.innerHTML = img_str;
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
function imgselectAll(obj, chk){

  var elems = obj.form.getElementsByTagName("INPUT");
  for (var i=0; i < elems.length; i++){
      elems[i].checked = obj.checked;
  }
}
</script>