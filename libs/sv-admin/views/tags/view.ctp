<?php 
/*****************************************************************************
 * SV-CART 编辑标签
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('/../js/yui/dragdrop-min.js');?>
<?php echo $javascript->link('/../js/yui/button-min.js');?>
<?php echo $javascript->link('/../js/yui/slider-min.js');?>
<?php echo $javascript->link('/../js/yui/colorpicker-min.js');?>
<?php echo $javascript->link('color_picker');?>	
<?php echo $javascript->link('product');?>	
<?php echo $javascript->link('coupon');?>	
<div class="content">
<?php  echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<br />	
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'标签列表','/tags/','',false,false)?> </strong></p>
<div class="home_main">

	<?php echo $form->create('Tag',array('action'=>'edit' ,'method'=>'POST' , 'onsubmit'=>'return type_check();'));?>
<div class="order_stat athe_infos configvalues">
	  <div class="box">
	  <div class="shop_config menus_configs">
	  	<dl><dt>标签名称: </dt></dl>
		<?php if(isset($languages) && sizeof($languages)>0){
		foreach ($languages as $k => $v){?>
		<dl><dt><p><?php echo $html->image($v['Language']['img01'])?></p></dt>
		<dd>
		<input type="text" style="width:290px;border:1px solid #649776" id="tag_name_<?php echo $v['Language']['locale']?>" name="tag_name_<?php echo $v['Language']['locale']?>" value="<?php if(isset($tag['TagI18n'][$v['Language']['locale']]['name'])){echo $tag['TagI18n'][$v['Language']['locale']]['name'];}else{echo '';}?>" />
		<input type="hidden" name="tag_i18n_<?php echo $v['Language']['locale']?>" value="<?php if(isset($tag['TagI18n'][$v['Language']['locale']]['id'])){echo $tag['TagI18n'][$v['Language']['locale']]['id'];}else{echo '';}?>">
		</dd></dl>
		<?php }}?>	
		<input type="hidden" name="tag_id" value="<?php echo $tag['Tag']['id']?>">
		<dl><dt>是否显示: </dt>
		<dd class="best_input">
		<input type="radio" name="status" value="1" <?php if($tag['Tag']['status'] == 1){echo "checked";}?> />显示<input type="radio" name="status" value="0"  <?php if($tag['Tag']['status'] == 0){echo "checked";}?>  />不显示 
	    </dd></dl>
		<dl><dt>搜索商品: </dt>
		<dd><input type="text" style="width:190px;border:1px solid #649776" name="keywords" id="keywords" />&nbsp;<input type="button" name="search_product" onclick="javascript:tag_product();" value="搜索商品"/>
	    </dd></dl>
	  	<dl><dt>搜索文章: </dt>
		<dd><input type="text" style="width:190px;border:1px solid #649776" name="keywords_id" id="keywords_id" />&nbsp;<input type="button" name="search_product" onclick="javascript:search_article();" value="搜索文章"/> </dd></dl>
	  	<dl><dt></dt>
		<dd></dd></dl>
		<div id="product_select" style="<?php if($tag['Tag']['type'] == 'A'){?>display:none<?php }?>">
		<dl><dt>可选商品: </dt><dd><select id="source_select1" name="source_select1">
			<option value="<?php echo $tag['Tag']['type_id']?>"><?php echo $tag['Tag']['type_name']?></option>
			</select>
			</div>
			<div id="article_select" style="<?php if($tag['Tag']['type'] == 'P'){?>display:none<?php }?>">
		<dl><dt>可选文章: </dt><dd>	<select id="source_select2" name="source_select2">
			<option value="<?php echo $tag['Tag']['type_id']?>"><?php echo $tag['Tag']['type_name']?></option>
			</select>
			</div>
		</div>		
	  </div>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
<input id="brand_id" type="hidden" name="brand_id"/>
<input id="products_id" type="hidden" value="0" name="products_id"/>
<input id="category_id" type="hidden" name="category_id"/>
<input id="article_cat" type="hidden" name="article_cat"/>
<input id="select_type" type="hidden" name="select_type" value="<?php echo $tag['Tag']['type']?>" />
<?php $form->end();?></div>
</div>
<script type="text/javascript">
	function tag_product(){
		searchProducts();
		document.getElementById('article_select').style.display="none";
		document.getElementById('product_select').style.display="";
		document.getElementById('select_type').value = "P";
	}
	function search_article(){
		searchArticles();
		document.getElementById('product_select').style.display="none";
		document.getElementById('article_select').style.display="";
		document.getElementById('select_type').value = "A";
	}
	
	function type_check(){
		var tag_name = document.getElementById('tag_name_'+now_locale).value;
		if(tag_name == ""){
			layer_dialog_show("标签名不能为空!","",3);
			return false;
		}
		var type = document.getElementById('select_type').value;
		if(type == "P" && document.getElementById('source_select1').value != parseInt(document.getElementById('source_select1').value)){
				layer_dialog_show("请选择一个商品或文章!","",3);
				return false;				
		}
		if(type == "A" && document.getElementById('source_select2').value != parseInt(document.getElementById('source_select2').value)){
				layer_dialog_show("请选择一个商品或文章!","",3);
				return false;				
		}
		if(type == "0")
		{
				layer_dialog_show("请选择一个商品或文章!","",3);
				return false;				
		}
		return true;
	}
	
</script>