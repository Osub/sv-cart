<?php 
/*****************************************************************************
 * SV-Cart 添加下载商品
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 2989 2009-07-17 02:03:04Z huangbo $
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
<?php echo $form->create('product_downloads',array('action'=>'add','name'=>'thisForm','id'=>'thisForm','OnSubmit'=>'return download_product_check();'));?>



<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."下载商品列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

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
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="ProductI18n<?php echo $k;?>Locale" name="data[ProductI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo $v['Language']['locale'];?>">
<?php 
	}
}?>
 	    <h2>商品名称：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input id="down_name_<?php echo $v['Language']['locale']?>" name="data[ProductI18n][<?php echo $k;?>][name]"  type="text" maxlength="100"  style="" /></span>
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
  	 
		
		
		<h2>商品关键词：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input id="ProductI18n<?php echo $k;?>MetaKeywords" name="data[ProductI18n][<?php echo $k;?>][meta_keywords]" type="text" style="width:215px;" value=""> 用空格分隔</span></p>
<?php 
	}
}?>
  	 
		<h2>商品简单描述：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><textarea id="ProductI18n<?php echo $k;?>MetaDescription" name="data[ProductI18n][<?php echo $k;?>][meta_description]" ></textarea> <font color="#ff0000">*</font></span></p>
<?php 
	}
}?>
		
				<h2><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text1')"))?>商家备注：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><textarea></textarea></span><br /><span class="altter" style="display:none" id="help_text1">仅商家自己看的信息</span></p>
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
		<dl><dt><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text2')"))?>商品货号：</dt><dd><input type="text" class="text_inputs" id="" name="data[Product][code]" value=""/><br /><span style="display:none" id="help_text2">如果您不输入商品货号，系统将自动生成一个唯一货号。</span></dd></dl>
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
	
	</dd>	</dl>
	
	
	<?php if(!empty($brands_tree)){?>
		<dl><dt>商品品牌：</dt><dd>
	<select id="ProductBrandId" name="data[Product][brand_id]">
	      <option value="0">所有品牌</option>
	    <?php if(isset($brands_tree) && sizeof($brands_tree)>0){?>
	    <?php foreach($brands_tree as $k=>$v){?>
	         <option value="<?php echo $v['Brand']['id']?>" value=""><?php echo $v['BrandI18n']['name']?></option>
	    <?php }}?>
	</select></dd></dl><?php }?>	<?php if(!empty($provider_list)){?>
			<dl><dt>供应商：</dt><dd>
	<select id="ProductproviderId" name="data[Product][provider_id]">
	      <option value="0">请选择....</option>
	    <?php if(isset($provider_list) && sizeof($provider_list)>0){?>
	    <?php foreach($provider_list as $k=>$v){?>
	         <option value="<?php echo $v['Provider']['id']?>" ><?php echo $v['Provider']['name']?></option>
	    <?php }}?>
	</select></dd></dl><?php }?>
		<dl><dt>本店售价：</dt><dd><input type="text" class="text_inputs" id="ProductShopPrice" name="data[Product][shop_price]" onblur="priceSetted();user_rank_list();" value=""/><input type="button" class="pointer" value="按市场价计算" onclick="marketPriceSetted()"/> <font color="#ff0000">*</font></dd></dl>
		<?php if(!empty($user_rank_list)){?>
		<dl>
		   <dt>会员价格：</dt>
		   <dd>
		    <?php if(isset($user_rank_list) && sizeof($user_rank_list) >0){?>
		   <?php foreach($user_rank_list as $k=>$v){?>
		       <p style="overflow:hidden;height:100%;width:305px;padding-top:2px"><span style="float:right">折扣率: <input type="text"  class="text_inputs" style="width:30px;margin:-1px 0 0;padding:0;text-align:center" id="user_price_discount<?php echo $k?>" name="user_price_discount[<?php echo $k?>]" value="<?php echo $v['UserRank']['discount']?>" onkeyup="set_price_note(<?php echo $k?>)" size="8"  />
		       	   <input type="checkbox" id="is_default_rank<?php echo $k?>" name="is_default_rank[<?php echo $k?>]" <?php if(@$v['UserRank']['is_default_rank']==1){ echo "checked"; }?> value="1" onclick="user_prince_check(this.checked,<?php echo $k?>)" >自动按照比例结算</span>
		       	   <?php echo $v['UserRank']['name']?><input class="text_inputs" style="width:50px;margin:-1px 0 0 4px;padding:0;text-align:center" id="rank_product_price<?php echo $k?>" name="rank_product_price[<?php echo $k?>]"  value="0" class="no_border_input" size="3" onkeyup="rank_product_price(<?php echo $k?>)"  />
				 <input type="hidden" id="user_rank<?php echo $k?>" name="user_rank[<?php echo $k?>]" value="<?php echo @$v['UserRank']['id']?>"  /></p>
					<input type="hidden" id="productrank_id<?php echo $k?>" name="productrank_id[<?php echo $k?>]" value="<?php echo @$v['UserRank']['productrank_id']?>"   />
		     <?php }}?></dd>
		</dl>
	<?php }?>		
	 <?php if(isset($SVConfigs['mlti_currency_module'])&&$SVConfigs['mlti_currency_module']==1){?>
		<dl>
		   <dt>语言价格：</dt>
		   <dd>
		    <?php if(isset($languages) && sizeof($languages) >0){?>
		   <?php foreach($languages as $k=>$v){?>
		       <p style="overflow:hidden;height:100%;width:305px;padding-top:2px">
		<span style="float:left">
		<?php echo $v['Language']['name']?>: <input type="text"  class="text_inputs" style="width:30px;margin:-1px 0 0;padding:0;text-align:center"  name="locale_product_price[<?php echo $v['Language']['locale']?>][product_price]"   size="8" />
		<input type="checkbox" name="locale_product_price[<?php echo $v['Language']['locale']?>][status]" value="1" >是否有效
	 
	   	</span>
		     <?php }}?></dd>
		</dl>
	<?php }?>
			<dl><dt>市场售价：</dt><dd><input type="text" class="text_inputs" id="ProductMarketPrice" name="data[Product][market_price]" value=""/><input class="pointer" type="button" value="取整数" /></dd></dl>
		<dl><dt>赠送积分数：</dt><dd><input type="text" class="text_inputs" name="data[Product][point]" /></dd></dl>
		<dl><dt><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text4')"))?>积分购买额度：</dt><dd><input type="text" class="text_inputs" name="data[Product][point_fee]" /><br /><span style="display:none" id="help_text4">购买该商品时最多可以使用多少的积分</span></dd></dl>
	<dl style="padding:3px 0;*padding:4px 0;">
					<dt class="promotion"><label for="ProductPromotionStatus"><input class="checkbox" type="checkbox" id="ProductPromotionStatus" name="data[Product][promotion_status]" value="1" onclick="handlePromote(this.checked);"  <?php if($this->data['Product']['promotion_status'] == 1){?>checked<?php }?>/>
		促销价</label>：</dt><dd><input type="text" class="text_inputs" value="" name="data[Product][promotion_price]" id="ProductPromotionPrice"/></dd></dl>
		<dl><dt>促销日期：</dt><dd class="time"><input style="width:90px;" class="text_inputs" type="text" id="date" name="date" value="<?php echo $this->data['Product']['promotion_start']?>"  readonly/><?php echo $html->image("calendar.gif",array("id"=>"show","class"=>"calendar_edit"))?>
			<input type="text" style="width:90px;" class="text_inputs" id="date2" name="date2" value="<?php echo $this->data['Product']['promotion_end']?>"  readonly/><?php echo $html->image("calendar.gif",array("id"=>"show2","class"=>"calendar_edit"))?></dd></dl>
	<span style="display:none">	<dl><dt>商品重量：</dt><dd><input type="text" class="text_inputs" value="" name="data[Product][weight]" id="ProductWeight"/>
			<select name="weight_unit">
			<option value="1">千克</option>
			<option value="0.001">克</option>
			</select></dd></dl>
		</span>	<dl style="*padding:4px 0;"><dt style="padding-top:1px">默认库存：</dt><dd class="best_input"><input name="data[Product][quantity]" id="ProductQuantity" value="9999" readonly/></dd></dl>
			
			
		<dl style="padding:3px 0;*padding:4px 0;"><dt style="padding-top:1px">加入推荐：</dt><dd class="best_input"><input type="checkbox" name="data[Product][recommand_flag]" id="ProductRecommandFlag"value="1"/>推荐</dd></dl>
		<dl style="*padding:4px 0;"><dt style="padding-top:1px">上架：</dt><dd class="best_input"><input type="checkbox" name="data[Product][forsale]" id="ProductForsale"value="1" checked/>打钩表示能作为普通商品销售，否则不允许销售。</dd></dl>
		<dl style="*padding:5px 0;"><dt style="padding-top:1px">能作为普通商品销售：</dt><dd class="best_input"><input type="checkbox" name="data[Product][alone]" id="ProductAlone"value="1" checked/>打钩表示允许销售，否则只能作为配件或赠品销售。</dd></dl>		
		<dl style="*padding:5px 0;"><dt style="padding-top:1px">是否开启下载：</dt><dd class="best_input"><input type="radio" name="data[ProductDownload][status]" value="1" checked/>是&nbsp;&nbsp;<input type="radio" name="data[ProductDownload][status]" value="0" />否</dd></dl>
		<dl><dt>有效日期：</dt><dd class="time"><input style="width:90px;" class="text_inputs" type="text" id="date3" name="date3"   readonly/><?php echo $html->image("calendar.gif",array("id"=>"show3","class"=>"calendar_edit"))?>
			<input type="text" style="width:90px;" class="text_inputs" id="date4" name="date4"  readonly/><?php echo $html->image("calendar.gif",array("id"=>"show4","class"=>"calendar_edit"))?></dd></dl>	  
	  	<dl><dt>下载URL：</dt><dd><input type="text" class="text_inputs"style="width:228px;" name="data[ProductDownload][url]" id="file_src" readonly/>
<?php echo $html->link($html->image('select_img.gif',array("align"=>"absmiddle","height"=>"23")),"javascript:up_file(1,'products')",'',false,false)?></dd></dl>
	  	<dl><dt>可下载次数：</dt><dd><input type="text" class="text_inputs"style="width:228px;" name="data[ProductDownload][allow_downloadtimes]" /></dd></dl>
	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>

</table>

<!--profile-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  详细信息</h1></div>
	  <div class="box">
	  
	  <?php echo $javascript->link('fckeditor/fckeditor'); ?>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	  <?php echo $html->image($v['Language']['img01'],array('align'=>'absbottom'))?><br />
<p class="profiles">
       <?php echo $form->textarea('ProductI18n/description', array("cols" => "60","rows" => "10","value" => "","name"=>"data[ProductI18n][{$k}][description]","id"=>"ProductI18n{$k}Description"));?>
        <?php echo $fck->load("ProductI18n{$k}/description"); ?>
		</p>
<?php 
	}
}?>
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

	  <p class="add_photo"><font face="宋体">[<?php echo $html->link("+","javascript:;",array("onclick"=>"addImg()"),false,false);?>]</font></p>
	  <div id="Pro_img_div">
		<p class="add_photo">

		<span id="new_file"><span id="path_txt_id_1">上传文件 : </span>
			<select name="image_path[1]"  onchange="image_path_change(this,1)">
				<option value="system_path">系统路径</option>
				<option value="definition_path">自定义路径</option>
			</select>
			<span id="definition_path_id_1" style="display:none">
			缩略图：<input type="text" name="img_thumb[1]" />
			详细图：<input type="text" name="img_detail[1]" />
			原图：<input type="text" name="img_original[1]" />
			</span>
			<span id="system_path_id_1" >
			<input type="text" name="img_url[1]" id="upload_img_text_1" readonly/>
<?php echo $html->link($html->image('select_img.gif',array("align"=>"absmiddle","height"=>"23")),"javascript:img_sel(1,'products')",'',false,false)?>
			</span>
			</span><br />
			图片描述 : 
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		  <?php echo $html->image($v['Language']['img01'])?><input type="text" name="img_desc[<?php echo $v['Language']['locale']?>][1]" id="img_desc[1]"/>
<?php }}?>
		排序: <input type="text" name="img_sort[1]" id="img_sort[1]" size="2"/>
			</p>
<li>
	<?php echo @$html->image("",array('id'=>'logo_thumb_img_1','height'=>'150','style'=>'display:none'))?>

		  </li>

		</div>
		<li><div id="other_imgs"></div></li>

		</div>

	  </div>
	</div>
<!--用来创造要替换的字符串start-->
  	<span id="imgupload" style="display:none">

 		<p class="add_photo">

		<span id="new_file"><span id="path_txt_id_&id&">上传文件 : </span>
			<select name="image_path[&id&]"  onchange="image_path_change(this,&id&)">
				<option value="system_path">系统路径</option>
				<option value="definition_path">自定义路径</option>
			</select>
			<span id="definition_path_id_&id&" style="display:none">
			缩略图：<input type="text" name="img_thumb[&id&]" />
			详细图：<input type="text" name="img_detail[&id&]" />
			原图：<input type="text" name="img_original[&id&]" />
			</span>
			<span id="system_path_id_&id&" >
			<input type="text" name="img_url[&id&]" id="upload_img_text_&id&" readonly/>
<?php echo $html->link($html->image('select_img.gif',array("align"=>"absmiddle","height"=>"23")),"javascript:img_sel(&id&,'products')",'',false,false)?>
			</span>
			</span><br />
		图片描述 : 
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		  <?php echo $html->image($v['Language']['img01'])?><input type="text" name="img_desc[<?php echo $v['Language']['locale']?>][&id&]" id="img_desc[&id&]"/>
<?php }}?>
		排序: <input type="text" name="img_sort[&id&]" id="img_sort[&id&]" size="2"/>
			</p>

	<?php echo @$html->image("",array('id'=>'logo_thumb_img_&id&','height'=>'150','style'=>'display:none'))?>

  	</span> <!--用来创造要替换的字符串end-->
	<script>
	    var ddd = 2;
	    function addImg(){
	      //	alert(ddd);
	    	var conObj=document.getElementById('other_imgs');
	     	var imgupload_str = document.getElementById("imgupload").innerHTML; 
	     	conObj.innerHTML+=imgupload_str.replace(/&amp;id&amp;/g,ddd);

	      	ddd++;
	 
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
	</script>
<!--Product Photos End-->
<!--profile End-->
<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>

</div>
<!--Main Start End-->
<?php echo $form->end();?>
<script style="text/javascript">
//调色板
//改变字体颜色
var lang_all = Array();
<?php foreach( $languages as $k=>$v ){?>
	lang_all[<?php echo $k?>] = "<?php echo $v['Language']['locale']?>";
<?php }?>
function font_color_picker(color_sn){
	for( var i=0; i<lang_all.length;i++){
		document.getElementById('down_name_'+lang_all[i]).style.color=color_sn;
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
       	   
 	function up_file(number,assign_dir){
 	 	var src=GetId('file_src').value;	 
	 		var win = window.open (webroot_dir+"product_downloads/upfile?status=1", 'newwindow', 'height=600, width=800, top=0, left=0, toolbar=no, menubar=yes, scrollbars=yes,resizable=yes,location=no, status=no');
			GetId('img_src_text_number').value = number;
			GetId("assign_dir").value = assign_dir;
	}
       	   
</script>

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