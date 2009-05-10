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
 * $Id: add.ctp 517 2009-04-14 01:18:28Z huangbo $
*****************************************************************************/
?>
<!--Main Start-->
<?=$html->css('colorpicker');?>
<?=$html->css('button');?>
<?=$html->css('slider');?>
<?=$html->css('color_font');?>

<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<?=$javascript->link('/../js/yui/dragdrop-min.js');?>
<?=$javascript->link('/../js/yui/button-min.js');?>
<?=$javascript->link('/../js/yui/slider-min.js');?>
<?=$javascript->link('/../js/yui/colorpicker-min.js');?>
<?=$javascript->link('/../js/yui/element-beta-min.js');?>
<?=$javascript->link('color_picker');?>
<?=$javascript->link('product');?>
<?php echo $form->create('virtual_cards',array('action'=>'add','name'=>'thisForm','id'=>'thisForm','OnSubmit'=>'return virtual_cards_check();'));?>



<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."虚拟卡列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<input type="hidden" name="action_type" value="product_base_info">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  通用信息</h1></div>
	  <div class="box">
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="ProductI18n<?=$k;?>Locale" name="data[ProductI18n][<?=$k;?>][locale]" type="hidden" value="<?=$v['Language']['locale'];?>">
<?
	}
}?>
 	    <h2>商品名称：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="virtual_cards_name_<?=$v['Language']['locale']?>" name="data[ProductI18n][<?=$k;?>][name]"  type="text" maxlength="100"  style="" /></span>
		 <font color="#ff0000">*</font></p>
<?
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
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="ProductI18n<?=$k;?>MetaKeywords" name="data[ProductI18n][<?=$k;?>][meta_keywords]" type="text" style="width:215px;" value=""> 用空格分隔</span></p>
<?
	}
}?>
  	 
		<h2>商品简单描述：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea id="ProductI18n<?=$k;?>MetaDescription" name="data[ProductI18n][<?=$k;?>][meta_description]" ></textarea> <font color="#ff0000">*</font></span></p>
<?
	}
}?>
		
				<h2><?=$html->image('help_icon.gif',array('align'=>'absmiddle'))?>商家备注：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea></textarea></span><br /><span class="altter">仅商家自己看的信息</span></p>
	<?}}?>  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;">
<!--Other Stat-->
	<div class="order_stat athe_infos tongxun">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  其他信息</h1></div>
	  <div class="box">
		<dl><dt><?=$html->image('help_icon.gif',array('align'=>'absmiddle'))?>商品货号：</dt><dd><input type="text" class="text_inputs" id="" name="data[Product][code]" value=""/><br />如果您不输入商品货号，系统将自动生成一个唯一货号。</dd></dl>
			<input type="hidden" id="ProductCode"  value="temp"/>
		<dl><dt>商品分类：</dt><dd><select id="ProductsCategory" name="data[Product][category_id]">
		<option value="0">所有分类</option>
		<?if(isset($categories_tree) && sizeof($categories_tree)>0){?><?foreach($categories_tree as $first_k=>$first_v){?>
<option value="<?=$first_v['Category']['id'];?>" ><?=$first_v['CategoryI18n']['name'];?></option>
<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?=$second_v['Category']['id'];?>">&nbsp;&nbsp;<?=$second_v['CategoryI18n']['name'];?></option>
<?if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?=$third_v['Category']['id'];?>">&nbsp;&nbsp;&nbsp;&nbsp;<?=$third_v['CategoryI18n']['name'];?></option>
<?}}}}}}?>
		</select> 
		
		<font color="#ff0000">*</font></dd></dl>
		<dl><dt>扩展分类：</dt>
		<dd>
		<span style='float:left;'><input type="button" class="pointer" value="添加" onclick="addOtherCat()"/></span>
		<span style='float:left;width:211px;padding-top:1px;'>
		    <select name="other_cat[]" style='margin-bottom:2px;'>
		       <option value="0">请选择</option>
		       <?if(isset($categories_tree) && sizeof($categories_tree)>0){?><?foreach($categories_tree as $first_k=>$first_v){?>
<option value="<?=$first_v['Category']['id'];?>" ><?=$first_v['CategoryI18n']['name'];?></option>
<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?=$second_v['Category']['id'];?>" >&nbsp;&nbsp;<?=$second_v['CategoryI18n']['name'];?></option>
<?if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?=$third_v['Category']['id'];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?=$third_v['CategoryI18n']['name'];?></option>
<?}}}}}}?>
		    </select>
	<div id="other_cats"></div>
	</span>
	
	</dd>	</dl>
	
	
	<?if(!empty($brands_tree)){?>
		<dl><dt>商品品牌：</dt><dd>
	<select id="ProductBrandId" name="data[Product][brand_id]">
	      <option value="0">所有品牌</option>
	    <?if(isset($brands_tree) && sizeof($brands_tree)>0){?>
	    <?foreach($brands_tree as $k=>$v){?>
	         <option value="<?echo $v['Brand']['id']?>" value=""><?echo $v['BrandI18n']['name']?></option>
	    <?}}?>
	</select></dd></dl><?}?>	<?if(!empty($provider_list)){?>
			<dl><dt>供应商：</dt><dd>
	<select id="ProductproviderId" name="data[Product][provider_id]">
	      <option value="0">请选择....</option>
	    <?if(isset($provider_list) && sizeof($provider_list)>0){?>
	    <?foreach($provider_list as $k=>$v){?>
	         <option value="<?echo $v['Provider']['id']?>" ><?echo $v['Provider']['name']?></option>
	    <?}}?>
	</select></dd></dl><?}?>
		<dl><dt>本店售价：</dt><dd><input type="text" class="text_inputs" id="ProductShopPrice" name="data[Product][shop_price]" onblur="priceSetted();user_rank_list();" value=""/><input type="button" class="pointer" value="按市场价计算" onclick="marketPriceSetted()"/> <font color="#ff0000">*</font></dd></dl>
		<?if(!empty($user_rank_list)){?>
		<dl>
		   <dt><?=$html->image('help_icon.gif',array('align'=>'absmiddle'))?>会员价格：</dt>
		   <dd>
		    <?if(isset($user_rank_list) && sizeof($user_rank_list) >0){?>
		   <?foreach($user_rank_list as $k=>$v){?>
		       <p style="overflow:hidden;height:100%;width:305px;padding-top:2px"><span style="float:right">折扣率: <input type="text"  class="text_inputs" style="width:30px;margin:-1px 0 0;padding:0;text-align:center" id="user_price_discount<?=$k?>" name="user_price_discount[<?=$k?>]" value="<?echo $v['UserRank']['discount']?>" onkeyup="set_price_note(<?echo $k?>)" size="8"  />
		       	   <input type="checkbox" id="is_default_rank<?=$k?>" name="is_default_rank[<?=$k?>]" <?if(@$v['UserRank']['is_default_rank']==1){ echo "checked"; }?> value="1" onclick="user_prince_check(this.checked,<?=$k?>)" >自动按照比例结算</span>
		       	   <?echo $v['UserRank']['name']?><input class="text_inputs" style="width:50px;margin:-1px 0 0 4px;padding:0;text-align:center" id="rank_product_price<?=$k?>" name="rank_product_price[<?=$k?>]"  value="0" class="no_border_input" size="3" onkeyup="rank_product_price(<?echo $k?>)"  />
				 <input type="hidden" id="user_rank<?=$k?>" name="user_rank[<?=$k?>]" value="<?echo @$v['UserRank']['id']?>"  /></p>
					<input type="hidden" id="productrank_id<?=$k?>" name="productrank_id[<?=$k?>]" value="<?echo @$v['UserRank']['productrank_id']?>"   />
		     <?}}?></dd>
		</dl>
	<?}?>
		<dl><dt>市场售价：</dt><dd><input type="text" class="text_inputs" id="ProductMarketPrice" name="data[Product][market_price]" value=""/><input class="pointer" type="button" value="取整数" /></dd></dl>
		<dl><dt>赠送积分数：</dt><dd><input type="text" class="text_inputs" name="data[Product][point]" /></dd></dl>
		<dl><dt><?=$html->image('help_icon.gif',array('align'=>'absmiddle'))?>积分购买额度：</dt><dd><input type="text" class="text_inputs" name="data[Product][point_fee]" /><br />购买该商品时最多可以使用多少的积分</dd></dl>
	<dl style="padding:3px 0;*padding:4px 0;">
					<dt class="promotion"><label for="ProductPromotionStatus"><input class="checkbox" type="checkbox" id="ProductPromotionStatus" name="data[Product][promotion_status]" value="1" onclick="handlePromote(this.checked);"  <?if($this->data['Product']['promotion_status'] == 1){?>checked<?}?>/>
		促销价</label>：</dt><dd><input type="text" class="text_inputs" value="" name="data[Product][promotion_price]" id="ProductPromotionPrice"/></dd></dl>
		<dl><dt>促销日期：</dt><dd class="time"><input style="width:90px;" class="text_inputs" type="text" id="date" name="date" value="<?=$this->data['Product']['promotion_start']?>"  readonly/><button type="button" id="show" title="Show Calendar" class="calendar"><?=$html->image("calendar.gif")?></button> <input type="text" style="width:90px;" class="text_inputs" id="date2" name="date2" value="<?=$this->data['Product']['promotion_end']?>"  readonly/><button type="button" id="show2" title="Show Calendar" class="calendar"><?=$html->image("calendar.gif")?></button></dd></dl>
	<span style="display:none">	<dl><dt>商品重量：</dt><dd><input type="text" class="text_inputs" value="" name="data[Product][weight]" id="ProductWeight"/>
			<select name="weight_unit">
			<option value="1">千克</option>
			<option value="0.001">克</option>
			</select></dd></dl>
		</span>	<dl style="*padding:4px 0;"><dt style="padding-top:1px">默认库存：</dt><dd class="best_input"><input name="data[Product][quantity]" id="ProductQuantity" value="0" readonly/></dd></dl>
			
			
		<dl style="padding:3px 0;*padding:4px 0;"><dt style="padding-top:1px">加入推荐：</dt><dd class="best_input"><input type="checkbox" name="data[Product][recommand_flag]" id="ProductRecommandFlag"value="1"/>推荐</dd></dl>
		<dl style="*padding:4px 0;"><dt style="padding-top:1px">上架：</dt><dd class="best_input"><input type="checkbox" name="data[Product][forsale]" id="ProductForsale"value="1" checked/>打钩表示能作为普通商品销售，否则不允许销售。</dd></dl>
		<dl style="*padding:5px 0;"><dt style="padding-top:1px">能作为普通商品销售：</dt><dd class="best_input"><input type="checkbox" name="data[Product][alone]" id="ProductAlone"value="1" checked/>打钩表示允许销售，否则只能作为配件或赠品销售。</dd></dl>
	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>

</table>

<!--profile-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  详细信息</h1></div>
	  <div class="box">
	  
	  <?php echo $javascript->link('fckeditor/fckeditor'); ?>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	  <?=$html->image($v['Language']['img01'],array('align'=>'absbottom'))?><br />
<p class="profiles">
       <?php echo $form->textarea('ProductI18n/description', array("cols" => "60","rows" => "10","value" => "","name"=>"data[ProductI18n][{$k}][description]","id"=>"ProductI18n{$k}Description"));?>
        <? echo $fck->load("ProductI18n{$k}/description"); ?>
		</p>
<?
	}
}?>
	  </div>
	</div>
<!--Product Photos-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  <span>商品相册</span></h1></div>
	  <div class="box">
	  <input type="hidden" name="action_type" value="product_gallery"></>
	  <div id="gallery-table">
	  <ul class="photos">
	  <input name="product_id" id="ProductId" type="hidden" value="<?= $this->data['Product']['id'];?>">
	<?if(isset($this->data['ProductGallery']) && sizeof($this->data['ProductGallery'])>0){?>
	   <?foreach($this->data['ProductGallery'] as $k=>$v){?>
	  	<li>
	  	<input type="hidden" name="data[ProductGallery][<?echo $k?>][id]"  id="ProductGallery<?echo $k?>Id" value="<?echo $v['id']?>">
		<p>[<?=$html->link("-","javascript:;",array("onclick"=>"layer_dialog();layer_dialog_show('确定要删除相册图片吗?','dropImg({$v['id']})',5);"),false,false);?>]</p>
		<p><?if($v['img_thumb']){?><?=$html->link($html->image("/..{$v['img_thumb']}",array('align'=>'absmiddle','width'=>'108','height'=>'108')),"/..{$v['img_thumb']}",'',false,false);?>
<?}else{?><?=$html->image("/..{$v['img_detail']}",'');?><?}?></p>
		
		<dl class="edit_photo">
		<dd>图片描述 :</dd>
		<dt><input class="green_border" type="text" style='width:98%' value="<?echo $v['description']?>" name="data[ProductGallery][<?echo $k?>][description]"  id="ProductGallery<?echo $k?>Description"/>
		</dt>
		</dl>
		<dl class="edit_photo">
		<dd>排序: </dd>
		<dt><input class="green_border" type="text" style='width:98%' size="3" value="<?echo $v['orderby']?>" name="data[ProductGallery][<?echo $k?>][orderby]"  id="ProductGallery<?echo $k?>Orderby" />
		
		</dt>
		</dl>
		
		<dl class="edit_photo">
		<dd>&nbsp;</dd>
		<dt>
		<?if($v['img_thumb'] != $this->data['Product']['img_thumb'])?><span name="default_gallery_img[]" id="default_gallery_img_<?=$v['id']?>" style="display:<?if($v['img_thumb'] != $this->data['Product']['img_thumb']){echo 'block';}else{echo 'none';}?>">
		<?=$html->link($html->image('default.gif',$title_arr['edit']),"javascript:default_gallery('{$v['id']}','{$this->data['Product']['id']}');","",false,false)?></span>
		<a name="default_gallery[]" id="default_gallery_<?=$v['id']?>" style="display:<?if($v['img_thumb'] == $this->data['Product']['img_thumb']){echo 'block';}else{echo 'none';}?>  "><span style="font-size:13px"> 默认</span></a></dt>
		</dl>
		</li>
	   <script>
	   	   img_id_arr[<?=$k?>] = "default_gallery_img_<?=$v['id']?>";
	   </script>
	   
	   <?}?>
     <?}?>
	  </ul>

	  <p class="add_photo"><font face="宋体">[<?=$html->link("+","javascript:;",array("onclick"=>"addImg()"),false,false);?>]</font></p>
	  <div id="Pro_img_div">
		<p class="add_photo">
		图片描述 : <input type="text" name="img_desc[]" id="img_desc[]"/>
		排序: <input type="text" name="img_sort[]" id="img_sort[]" size="2"/>
		<span id="new_file">上传文件 : <input type="text" name="img_url[]" id="upload_img_text_1"/>
<?=$html->link($html->image('select_img.gif',array("align"=>"absmiddle","height"=>"23")),"javascript:img_sel(1,'products')",'',false,false)?></span></p>
		  
<li>
	<?=@$html->image("",array('id'=>'logo_thumb_img_1','height'=>'150'))?>

		  </li>

		</div>

		<li><div id="other_imgs"></div></li>

		</div>
	  </div>
	</div>
<!--用来创造要替换的字符串start-->
  	<span id="imgupload" style="display:none">
	<p class="add_photo">
		图片描述 : <input type="text" name="img_desc[]" id="img_desc[]"/>
		排序: <input type="text" name="img_sort[]" id="img_sort[]" size="2"/>
		<span id="new_file">上传文件 : <input type="text" name="img_url[]" id="upload_img_text_&id&"/>
<?=$html->link($html->image('select_img.gif',array("align"=>"absmiddle","height"=>"23")),"javascript:img_sel(&id&,'products')",'',false,false)?></span></p>
			  <?=@$html->image("",array('id'=>'logo_thumb_img_&id&','height'=>'150'))?>


 
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
	</script>
<!--profile End-->
<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>

</div>
<!--Main Start End-->
<? echo $form->end();?>
<script style="text/javascript">
//调色板
//改变字体颜色
var lang_all = Array();
<?foreach( $languages as $k=>$v ){?>
	lang_all[<?=$k?>] = "<?=$v['Language']['locale']?>";
<?}?>
function font_color_picker(color_sn){
	for( var i=0; i<lang_all.length;i++){
		document.getElementById('product_name_'+lang_all[i]).style.color=color_sn;
	}
}
onload = function(){
      handlePromote(document.getElementById('ProductPromotionStatus').checked);
    }
    
       var numpri=<?=$market_price_rate?>;
       var user_rank_list_arr  = Array();
       <?$ii=0;foreach($user_rank_list as $k=>$v){?>
       	   user_rank_list_arr[<?=$ii?>]=<?=$k?>;
       <?$ii++;}?>
       	  // alert(user_rank_list_arr);
       	   function user_rank_list(){
       	   		for(var kk=0;kk<user_rank_list_arr.length;kk++){
       	   			set_price_note(user_rank_list_arr[kk]);
       	   		}
       	   
       	   
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