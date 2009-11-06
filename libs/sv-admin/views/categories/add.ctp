<?php 
/*****************************************************************************
 * SV-Cart 添加商品分类
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 5265 2009-10-21 08:50:11Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong>
<?php if($type=='P'){?><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."分类列表","/categories/index/P/",'',false,false);?><?php }?>
<?php if($type=='A'){?><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."分类列表","/categories/index/A/",'',false,false);?><?php }?></strong></p>
<!--Main Start-->
<div class="home_main categories_infos">
<?php if($type=='P'){echo $form->create('Category',array('action'=>'add/P','onsubmit'=>'return categories_P_check();'));}?>
<?php if($type=='A'){echo $form->create('Category',array('action'=>'add/A','onsubmit'=>'return categories_A_check();'));}?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
<input type="hidden" id="categoryid" value="<?php echo $categories_id?>">
	<div class="order_stat athe_infos configvalues">
	  	<div class="title"><h1>
	  	<?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  	<?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  	编辑分类</h1></div>
	  	<div class="box">
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<input id="CategoryI18n<?php echo $k;?>Locale" name="data[CategoryI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
		<?php }}?>
		
  	    <dl><dt>分类名称: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input id="category_name_<?php echo $v['Language']['locale']?>" style="width:195px;border:1px solid #649776" name="data[CategoryI18n][<?php echo $k;?>][name]" type="text" maxlength="100" value=""> <font color="#ff0000">*</font></dd></dl>
		<?php }}?>
  	    
  	    <dl><dt>关键字: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input id="CategoryI18n<?php echo $k;?>MetaKeywords" style="width:195px;border:1px solid #649776" name="data[CategoryI18n][<?php echo $k;?>][meta_keywords]" type="text" style="width:215px;" value="">
			<select style="width:90px;border:1px solid #649776" onchange="add_to_seokeyword(this,'CategoryI18n<?php echo $k;?>MetaKeywords')">
				<option value='常用关键字'>常用关键字</option>
				<?php foreach( $seokeyword_data as $sk=>$sv){?>
					<option value='<?php echo $sv["SeoKeyword"]["name"]?>'><?php echo $sv["SeoKeyword"]["name"]?></option>
				<?php }?>
			</select>

			</dd></dl>
		<?php }}?>
		
		<dl><dt>分类描述: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><textarea id="CategoryI18n<?php echo $k;?>MetaDescription" style="width:195px;border:1px solid #649776" name="data[CategoryI18n][<?php echo $k;?>][meta_description]" ></textarea></dd></dl>
		<?php }}?>
		<?php if($type == 'P'){?>
		<dl><dt>上传图片01: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input id="upload_img_text_1<?php echo $k?>" style="width:195px;border:1px solid #649776" name="data[CategoryI18n][<?php echo $k;?>][img01]" type="text" style="width:195px;border:1px solid #649776"  /><?php echo @$html->link($html->image('select_img.gif',array("height"=>"20","class"=>"vmiddle icons","title"=>$title_arr['select_img'])),"javascript:img_sel(1$k,'product_categories')",'',false,false)?><button type="button" class="pointer" onclick="change_img_name(1,'<?php echo $v['Language']['locale']?>',<?php echo $this->data['Category']['id']?>,<?php echo $k?>)">自动命名</button>
			<br /><?php echo @$html->image("",array('id'=>'logo_thumb_img_1'.$k,'height'=>'150','style'=>"display:none"))?>
			</dd></dl>
			<style>
			<!--
			#logo_thumb_img_1<?php echo $k;?>{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;width:200px;height:100px;}
			-->
			</style>
		<?php }}?>
		<dl><dt>图片01超链接: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input  name="data[CategoryI18n][<?php echo $k;?>][img01_link]" type="text" style="width:195px;border:1px solid #649776"  /></dd></dl>
		<?php }}?>
		<dl><dt>上传图片02: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input id="upload_img_text_2<?php echo $k?>" style="width:195px;border:1px solid #649776" name="data[CategoryI18n][<?php echo $k;?>][img02]" type="text" style="width:195px;border:1px solid #649776"    /><?php echo @$html->link($html->image('select_img.gif',array("height"=>"20","class"=>"vmiddle icons","title"=>$title_arr['select_img'])),"javascript:img_sel(2$k,'product_categories')",'',false,false)?><button type="button" class="pointer" onclick="change_img_name(2,'<?php echo $v['Language']['locale']?>',<?php echo $this->data['Category']['id']?>,<?php echo $k?>)">自动命名</button>
			<br /><?php echo @$html->image("",array('id'=>'logo_thumb_img_2'.$k,'height'=>'150','style'=>"display:none"))?>
			</dd></dl>
			<style>
			<!--
			#logo_thumb_img_2<?php echo $k;?>{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;width:200px;height:100px;}
			-->
			</style>
		<?php 	}}?>
		<dl><dt>图片02超链接: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input  name="data[CategoryI18n][<?php echo $k;?>][img02_link]" type="text" style="width:195px;border:1px solid #649776"  /></dd></dl>
		<?php }}}?>
		<?php if($type == 'A'){?>
		<dl><dt>上传图片01: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input id="upload_img_text_1<?php echo $k?>" style="width:195px;border:1px solid #649776" name="data[CategoryI18n][<?php echo $k;?>][img01]" type="text" style="width:195px;border:1px solid #649776"  /><?php echo @$html->link($html->image('select_img.gif',array("height"=>"20","class"=>"vmiddle icons","title"=>$title_arr['select_img'])),"javascript:img_sel(1$k,'article_categories')",'',false,false)?><button type="button" class="pointer" onclick="change_img_name(1,'<?php echo $v['Language']['locale']?>',<?php echo $this->data['Category']['id']?>,<?php echo $k?>)">自动命名</button>
			<br /><?php echo @$html->image("",array('id'=>'logo_thumb_img_1'.$k,'height'=>'150','style'=>"display:none"))?>
			</dd></dl>
			<style>
			<!--
			#logo_thumb_img_1<?php echo $k;?>{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;width:200px;height:100px;}
			-->
			</style>
		<?php }}?>
		<dl><dt>图片01超链接: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input  name="data[CategoryI18n][<?php echo $k;?>][img01_link]" type="text" style="width:195px;border:1px solid #649776"  /></dd></dl>
		<?php }}?>
		<dl><dt>上传图片02: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input id="upload_img_text_2<?php echo $k?>" style="width:195px;border:1px solid #649776" name="data[CategoryI18n][<?php echo $k;?>][img02]" type="text" style="width:195px;border:1px solid #649776"    /><?php echo @$html->link($html->image('select_img.gif',array("height"=>"20","class"=>"vmiddle icons","title"=>$title_arr['select_img'])),"javascript:img_sel(2$k,'article_categories')",'',false,false)?><button type="button" class="pointer" onclick="change_img_name(2,'<?php echo $v['Language']['locale']?>',<?php echo $this->data['Category']['id']?>,<?php echo $k?>)">自动命名</button>
			<br /><?php echo @$html->image("",array('id'=>'logo_thumb_img_2'.$k,'height'=>'150','style'=>"display:none"))?>
			</dd></dl>
			<style>
			<!--
			#logo_thumb_img_2<?php echo $k;?>{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;width:200px;height:100px;}
			-->
			</style>
		<?php 	}}?>
		<dl><dt>图片02超链接: </dt><dd></dd></dl>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input  name="data[CategoryI18n][<?php echo $k;?>][img02_link]" type="text" style="width:195px;border:1px solid #649776"  /></dd></dl>
		<?php }}}?>
	  </div>
</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Other Stat-->
<?php if($type == 'P'):?>
	<div class="order_stat athe_infos tongxun">
	  
	  <div class="box">
		
		<dl><dt>上级分类：</dt><dd><select id="CategoryParentId" name="data[Category][parent_id]">
			<option value="0">顶层</option>
			<?php if(isset($categories_tree) && sizeof($categories_tree)>0){  //第一层
	   				foreach($categories_tree as $k=>$v){
				  ?>
				 <option value="<?php echo $v['Category']['id'];?>"><?php echo $v['CategoryI18n']['name'];?></option>
				 	  <?php if(isset($v['SubCategory']) && sizeof($v['SubCategory'])>0){ //第二层
		           	     foreach($v['SubCategory'] as $kk=>$vv){		  
		            		?>
		            		<option value="<?php echo $vv['Category']['id'];?>">|-- <?php echo $vv['CategoryI18n']['name'];?></option>
		            			<?php if(isset($vv['SubCategory']) && sizeof($vv['SubCategory'])>0){ //第二层
				           	     foreach($v['SubCategory'] as $kkk=>$vvv){		  
				            		?>
				            		<!--<option value="<?php echo $vvv['Category']['id'];?>">|---- <?php echo $vvv['CategoryI18n']['name'];?></option>
				            			--><?php }
								  }?>
		            			<?php }
						  }?>
					<?php }
				  }?>
			</select></dd></dl>
		<dl><dt>排序：</dt><dd class="time"><!--<?php echo $form->input('orderby',array('label'=>false,'div'=>false));?>--><input id="CategoryOrderby" name="data[Category][orderby]" type="text" class="text" style="width:108px;"   value=""/></dd></dl>
		<dl><dt>超级连接：</dt><dd class="time"><input id="CategoryFlashConfig" name="data[Category][link]" type="text" class="text"  style="width:108px;"  value=""/></dd></dl>

		</span><dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">是否显示：</dt><dd class="best_input"><input id="CategoryStatus" name="data[Category][status]" type="radio" value="1" checked >是<input id="CategoryStatus" name="data[Category][status]" type="radio" value="0"  >否</dd></dl>
		</span><dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">显示new：</dt><dd class="best_input"><input id="CategoryStatus" name="data[Category][new_show]" type="radio" value="1" checked >是<input id="CategoryStatus" name="data[Category][new_show]" type="radio" value="0"  >否</dd></dl>
		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">开启筛选：</dt><dd class="best_input"><input  type="checkbox" value="1" name="data[CategoryFilter][status]" id="open_filter" onclick="filter_open(this)">打钩表示开启筛选属性</dd></dl>

		<div id="is_filter" style="display:none">
			<dl style="padding:5px 0;*padding:6px 0;" ><dt style="padding-top:1px">价格区间：</dt><dd class="best_input" >[<?php echo $html->link("+","javascript:;",array("onclick"=>"add_price()"),false,false);?>]<span id="original_price"><input  type="text" class="text" value="" style="width:108px;" name="data[Category][start_price][]" > — <input  type="text" class="text" value="" style="width:108px;" name="data[Category][end_price][]" ></span></dd></dl>
			<div id="hidden_price" style="display:none;"><dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px"></dt> <dd class="best_input">[<?php echo $html->link("-","javascript:;",array("onclick"=>"del_price(this)"),false,false);?>] <input  type="text" class="text" value="" style="width:108px;"  name="data[Category][start_price][]"> — <input  type="text" class="text" value="" style="width:108px;" name="data[Category][end_price][]"></dd></dl></div>
			<div id="add_price"></div>

		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">筛选属性：</dt><dd ><span>[<?php echo $html->link("+","javascript:;",array("onclick"=>"add_attr()"),false,false);?>]</span><span><select onchange="attr_filter(this)" id="original_attr1"><option value="0">请选择商品类型</option>
		 <?php if(isset($product_type) && sizeof($product_type)>0){
			 foreach($product_type as $k=>$v){?>
			 <option value="<?php echo $v['ProductType']['type_id']?>"> <?php echo $v['ProductType']['name']?></option>
			 	
		<?	 }
		 }?>
		</select></span><span id="original_attr2">&nbsp;<select name="data[Category][attr_filter][]"	onchange="check_filter(this)"><option value="0">请选择筛选属性</option></select></span></dd></dl>
		
		<div id="hidden_attr" style="display:none;"><dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px"></dt><dd><span>[<?php echo $html->link("-","javascript:;",array("onclick"=>"del_attr(this)"),false,false);?>] </span><span><select name="attr_type[]" onchange="attr_filter(this)"><option value="0">请选择商品类型</option>	 
		<?php if(isset($product_type) && sizeof($product_type)>0){
			 foreach($product_type as $k=>$v){?>
				 <option value="<?php echo $v['ProductType']['type_id']?>"> <?php echo $v['ProductType']['name']?></option>
		<?	 }
		 }?></select></span><span>&nbsp;<select name="data[Category][attr_filter][]"><option value="0">请选择筛选属性</option></select></span></dd></dl></div>
		<div id="add_attr"></div>
	</div><!-filter end-->
	
		<dl><dt>分类图片01：</dt><dd><input id="upload_img_text_3" name="data[Category][img01]" type="text" style="width:357px;border:1px solid #649776"  /><br /><?php echo @$html->image("",array('id'=>'logo_thumb_img_3','style'=>"display:none"))?>
		</dd><dd><?php echo @$html->link($html->image('select_img.gif',array("height"=>"20","class"=>"vmiddle icons","title"=>$title_arr['select_img'])),"javascript:img_sel(3,'product_categories')",'',false,false)?></dd></dl>
		<dl><dt>分类图片01超链接：</dt><dd><input name="data[Category][img01_link]" type="text" style="width:357px;border:1px solid #649776"  /></dd></dl>
		<dl><dt>分类图片02：</dt><dd><input id="upload_img_text_4" name="data[Category][img02]" type="text" style="width:357px;border:1px solid #649776"   /><br /><?php echo @$html->image("",array('id'=>'logo_thumb_img_4','style'=>"display:none"))?> </dd><dd><?php echo @$html->link($html->image('select_img.gif',array("height"=>"20","class"=>"vmiddle icons","title"=>$title_arr['select_img'])),"javascript:img_sel(4,'product_categories')",'',false,false)?></dd></dl>
		<dl><dt>分类图片02超链接：</dt><dd><input name="data[Category][img02_link]" type="text" style="width:357px;border:1px solid #649776"   /></dd></dl>
	  </div>
	</div>
<?php endif;?>
<?php if($type == 'A'):?>
	<div class="order_stat athe_infos configvalues">
	  
	  <div class="box">
	  <!-- start  -->
	  		<dl><dt>系统类型: </dt>
			<dd>
			<select name="data[Category][sub_type]">
			<?php foreach( $systemresource_info["sub_type"] as $k=>$v ){?>
				<option value="<?php echo $k;?>" ><?php echo $v;?></option>
			<?php }?>
			</select>
			</dd>
			</dl>

	  		<dl><dt>上级分类：</dt><dd><select id="CategoryParentId" name="data[Category][parent_id]">
			<option value="0">顶层</option>
			<?php if(isset($categories_tree) && sizeof($categories_tree)>0){  //第一层
	   				foreach($categories_tree as $k=>$v){
				  ?>
				 <option value="<?php echo $v['Category']['id'];?>"><?php echo $v['CategoryI18n']['name'];?></option>
				 	  <?php if(isset($v['SubCategory']) && sizeof($v['SubCategory'])>0){ //第二层
		           	     foreach($v['SubCategory'] as $kk=>$vv){		  
		            		?>
		            		<option value="<?php echo $vv['Category']['id'];?>">|-- <?php echo $vv['CategoryI18n']['name'];?></option>
		            			<?php if(isset($vv['SubCategory']) && sizeof($vv['SubCategory'])>0){ //第二层
				           	     foreach($v['SubCategory'] as $kkk=>$vvv){		  
				            		?>
				            	<!--	<option value="<?php echo $vvv['Category']['id'];?>">|---- <?php echo $vvv['CategoryI18n']['name'];?></option>
				            		-->	<?php }
								  }?>
		            			<?php }
						  }?>
					<?php }
				  }?>
			</select></dd></dl>
	   <!-- end  -->
		<dl><dt>排序：</dt><dd class="time"><!--<?php echo $form->input('orderby',array('label'=>false,'div'=>false));?>--><input id="CategoryOrderby" name="data[Category][orderby]" type="text" class="text" style="width:108px;"   value=""/></dd></dl>
		<dl><dt>超级连接：</dt><dd class="time"><input id="CategoryFlashConfig" name="data[Category][link]" type="text" class="text"  style="width:108px;"  value=""/></dd></dl>
		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">是否显示：</dt><dd class="best_input"><input id="CategoryStatus" name="data[Category][status]" type="radio" value="1" checked >是<input id="CategoryStatus" name="data[Category][status]" type="radio" value="0"  >否</dd></dl>
		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">显示new：</dt><dd class="best_input"><input id="CategoryStatus" name="data[Category][new_show]" type="radio" value="1" checked >是<input id="CategoryStatus" name="data[Category][new_show]" type="radio" value="0"  >否</dd></dl>
		<dl><dt>分类图片01：</dt><dd><input id="upload_img_text_5" name="data[Category][img01]" type="text" style="width:357px;border:1px solid #649776"  /><br /><?php echo $html->image("/..{$this->data['Category']['img01']}",array('id'=>'logo_thumb_img_5','style'=>"display:none"))?> </dd><dd><?php echo @$html->link($html->image('select_img.gif',array("height"=>"20","class"=>"vmiddle icons","title"=>$title_arr['select_img'])),"javascript:img_sel(5,'article_categories')",'',false,false)?></dd></dl>
		<dl><dt>分类图片01超链接：</dt><dd><input name="data[Category][img01_link]" type="text" style="width:357px;border:1px solid #649776"  /></dd></dl>
		<dl><dt>分类图片02：</dt><dd><input id="upload_img_text_6" name="data[Category][img02]" type="text" style="width:357px;border:1px solid #649776"  /><br /><?php echo $html->image("/..{$this->data['Category']['img02']}",array('id'=>'logo_thumb_img_6','style'=>"display:none"))?></dd><dd><?php echo @$html->link($html->image('select_img.gif',array("height"=>"20","class"=>"vmiddle icons","title"=>$title_arr['select_img'])),"javascript:img_sel(6,'article_categories')",'',false,false)?></dd></dl>
		<dl><dt>分类图片02超链接：</dt><dd><input name="data[Category][img02_link]" type="text" style="width:357px;border:1px solid #649776"  /></dd></dl>
		<input name="data[Category][type]" type="hidden"  value="A"/>
	  </div>
	</div>
<?php endif;?>
<!--Other Stat End-->
</td>
</tr>

</table>
<?php if($type == "A"){
?>
<!-- tinymce start-->
<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  详细内容</h1></div>
	  <div class="box">
		<?php if($SVConfigs["select_editor"]=="2"||empty($SVConfigs["select_editor"])){?>
	  	<?php echo $javascript->link('tinymce/tiny_mce/tiny_mce'); ?>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
	<table><tr><td valign="top">
	  	<?php echo $html->image($v['Language']['img01'])?></td><td valign="top">
		<textarea id="elm<?php echo $v['Language']['locale'];?>" name="data[CategoryI18n][<?php echo $k;?>][detail]" rows="15" cols="80" style="width: 80%"></textarea>
		<?php  echo $tinymce->load("elm".$v['Language']['locale'],$now_locale); ?><br /><br /></td></tr>
</table>
    	<?php }?></p>
		<?php }?><?php }?>
		<?php if($SVConfigs["select_editor"]=="1"){?>
			<?php echo $javascript->link('fckeditor/fckeditor'); ?>
		  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		  	<?php echo $html->image($v['Language']['img01'])?><br />
			<p class="profiles">
			<?php  if(isset($article['BrandI18n'][$k]['description'])){?>
	        <?php echo $form->textarea('ArticleI18n/content', array("cols" => "60","rows" => "20","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"ArticleI18n{$k}Content"));?>
	        <?php echo $fck->load("ArticleI18n{$k}/content"); ?>
	        
	    	<?php }else{?>
	       	<?php echo $form->textarea('ArticleI18n/content', array('cols' => '60', 'rows' => '20','value'=>"","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"ArticleI18n{$k}Content"));?> 
	       	<?php echo $fck->load("ArticleI18n{$k}/content"); ?>
	    	<?php }?>
		    </p>
			<br /><br />
			<?php }}?>
		<?php }?>
<?php }?>
<?php if($type == "P"){
?>
<!-- tinymce start-->	
<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  详细内容</h1></div>
	  <div class="box">
		<?php if($SVConfigs["select_editor"]=="2"||empty($SVConfigs["select_editor"])){?>
	  	<?php echo $javascript->link('tinymce/tiny_mce/tiny_mce'); ?>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?><table><tr><td valign="top">
	  	<?php echo $html->image($v['Language']['img01'])?></td><td valign="top">
		<textarea id="elm<?php echo $v['Language']['locale'];?>" name="data[CategoryI18n][<?php echo $k;?>][detail]" rows="15" cols="80" style="width: 80%"></textarea>
		<?php  echo $tinymce->load("elm".$v['Language']['locale'],$now_locale); ?><br /><br /></td></tr>
</table>
    	<?php }?></p>
		<?php }?><?php }?>
		<?php if($SVConfigs["select_editor"]=="1"){?>
			<?php echo $javascript->link('fckeditor/fckeditor'); ?>
		  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		  	<?php echo $html->image($v['Language']['img01'])?><br />
			<p class="profiles">
			<?php  if(isset($article['BrandI18n'][$k]['description'])){?>
	        <?php echo $form->textarea('ArticleI18n/content', array("cols" => "60","rows" => "20","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"ArticleI18n{$k}Content"));?>
	        <?php echo $fck->load("ArticleI18n{$k}/content"); ?>
	        
	    	<?php }else{?>
	       	<?php echo $form->textarea('ArticleI18n/content', array('cols' => '60', 'rows' => '20','value'=>"","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"ArticleI18n{$k}Content"));?> 
	       	<?php echo $fck->load("ArticleI18n{$k}/content"); ?>
	    	<?php }?>
		    </p>
			<br /><br />
			<?php }}?>
		<?php }?>
<?php 
}?>
</div>
<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
</div>
<!--Main Start End-->
</div>
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
<script>
	
//显示 隐藏层
function filter_open(obj){
	if(obj.checked== true){
		document.getElementById('is_filter').style.display="block";
	}else{
		document.getElementById('is_filter').style.display="none";
		document.getElementById('add_attr').innerHTML="";
		document.getElementById('add_price').innerHTML="";
		document.getElementById('original_attr1').value="0";
		document.getElementById('original_attr2').innerHTML='&nbsp;<select name="data[Category][attr_filter][]"><option value="0">请选择筛选属性</option></select>';
		document.getElementById('original_price').innerHTML='<input  type="text" class="text" value="" style="width:108px;" name="data[Category][start_price][]" > — <input  type="text" class="text" value="" style="width:108px;" name="data[Category][end_price][]" >';
	}
}

function add_price(){
	var div = document.createElement("div");
	var imgupload_str = document.getElementById("hidden_price").innerHTML; 
	div.innerHTML=imgupload_str;
	document.getElementById("add_price").appendChild(div);
}

function del_price(obj){
	var conObj=document.getElementById('add_price');
	var id=obj.parentNode.parentNode.parentNode;
	conObj.removeChild(id);
}
//增加层 判断属性值是否为空
function add_attr(){
	var name=document.getElementsByName("data[Category][attr_filter][]");
	var j=0;
	for(var i=0; i<name.length; i++){
	 	if(name[i].value=="0"){
	 		j+=1;
	 	}
	} 	
	if(j>1){
		layer_dialog_show("请选择筛选属性!","",3);
	}else{
		var div = document.createElement("div");
		var imgupload_str = document.getElementById("hidden_attr").innerHTML; 
		div.innerHTML=imgupload_str;
		document.getElementById("add_attr").appendChild(div);	
	}
}

function del_attr(obj){
	var conObj=document.getElementById('add_attr');
	var id=obj.parentNode.parentNode.parentNode.parentNode;
	conObj.removeChild(id);
}
//判断属性是否已选
function check_filter(obj){
	var value=obj.value;
	var name=document.getElementsByName("data[Category][attr_filter][]");
	var j=0;
	if(value!="0"){
		for(var i=0; i<name.length; i++){
		 	if(name[i].value==value){
		 		j+=1;
		 	}
		} 
		if(j>1){
			layer_dialog_show("已经存在该属性!","",3);
			obj.value="0";
		}				
	}
}
//取属性
var temp;
function attr_filter(obj){
	var conObj=obj.value;
	if(conObj=="0"){
		obj.parentNode.parentNode.childNodes[2].innerHTML='&nbsp;<select name="data[Category][attr_filter][]"><option value="0">请选择筛选属性</option></select>';
	}else{
		filter_show(conObj,obj);
	}
}
	function filter_show(conObj,obj){
	//	YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"categories/getattr?id="+conObj;
		temp=obj;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, filter_show_callback);
	}
	var filter_show_Success = function(o){
		temp.parentNode.parentNode.childNodes[2].innerHTML=o.responseText;
	//	alert(o.responseText);
	//	YAHOO.example.container.wait.hide();
	}	
	
	var filter_show_Failure = function(o){
		alert("error");
	//	YAHOO.example.container.wait.hide();
	}
	var filter_show_callback ={
		success:filter_show_Success,
		failure:filter_show_Failure,
		timeout : 30000,
		argument: {}
	};


<?php if($type == 'A'){?>
function change_img_name(nu,type,e_id){
	var img_url = "/img/article_categories/{$new_id}/"+type+"_0"+nu+".jpg"
	var get_id = "upload_img_text_"+e_id;
	document.getElementById(get_id).value = img_url;

}
function change_img_name_gif(nu,type,e_id){
	var img_url = "/img/article_categories/{$new_id}/"+type+"_0"+nu+".gif"
	var get_id = "upload_img_text_"+e_id;

	document.getElementById(get_id).value = img_url;

}
<?php }else{?>
function change_img_name(nu,type,e_id){
	var img_url = "/img/product_categories/{$new_id}/"+type+"_0"+nu+".jpg"
	var get_id = "upload_img_text_"+e_id;
	document.getElementById(get_id).value = img_url;

}
function change_img_name_gif(nu,type,e_id){
	var img_url = "/img/product_categories/{$new_id}/"+type+"_0"+nu+".gif"
	var get_id = "upload_img_text_"+e_id;

	document.getElementById(get_id).value = img_url;

}

<?php }?>
</script>
<style>
<!--
#logo_thumb_img_3{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;width:200px;height:100px;}
#logo_thumb_img_4{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;width:200px;height:100px;}
#logo_thumb_img_5{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;width:200px;height:100px;}
#logo_thumb_img_6{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;width:200px;height:100px;}
-->
</style>