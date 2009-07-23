<?php 
/*****************************************************************************
 * SV-Cart 编辑商品分类
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 3053 2009-07-17 11:59:14Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<?php if($type=='P'){?><p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."分类列表","/categories/index/P/",'',false,false);?></strong></p>
<?php }?>
<?php if($type=='A'){?><p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."分类列表","/categories/index/A/",'',false,false);?></strong></p>
<?php }?>
<!--Main Start-->
<div class="home_main categories_infos">
<?php if($type=='P'){echo $form->create('Category',array('action'=>'edit/P/','onsubmit'=>'return categories_P_check();'));}?>
<?php if($type=='A'){echo $form->create('Category',array('action'=>'edit/A/','onsubmit'=>'return categories_A_check();'));}?>
<input id="CategoryId" name="data[Category][id]" type="hidden" value="<?php echo  $this->data['Category']['id'];?>">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?php echo @$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo @$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑分类</h1></div>
	  <div class="box">


<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="CategoryI18n<?php echo $k;?>Locale" name="data[CategoryI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
	   <?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']])){?>
	<input id="CategoryI18n<?php echo $k;?>Id" name="data[CategoryI18n][<?php echo $k;?>][id]" type="hidden" value="<?php echo  $this->data['CategoryI18n'][$v['Language']['locale']]['id'];?>">
	   <?php }?>
	   	<input id="categoryid" name="data[CategoryI18n][<?php echo $k;?>][category_id]" type="hidden" value="<?php echo  $this->data['Category']['id'];?>">
<?php 
	}
}?>


  	    <h2>分类名称：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input  id="category_name_<?php echo $v['Language']['locale']?>" name="data[CategoryI18n][<?php echo $k;?>][name]" type="text" maxlength="100" value="<?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['name'])){echo $this->data['CategoryI18n'][$v['Language']['locale']]['name'];}?>"> <font color="#ff0000">*</font></span></p>
<?php 
	}
}?>

		<h2>关键字：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input id="CategoryI18n<?php echo $k;?>MetaKeywords" name="data[CategoryI18n][<?php echo $k;?>][meta_keywords]" type="text" style="width:215px;" value="<?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['meta_keywords'])){ echo $this->data['CategoryI18n'][$v['Language']['locale']]['meta_keywords'];}?>"> </span></p>
<?php 
	}
}?>
		<h2>分类描述：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><textarea id="CategoryI18n<?php echo $k;?>MetaDescription" name="data[CategoryI18n][<?php echo $k;?>][meta_description]" ><?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['meta_description'])){echo $this->data['CategoryI18n'][$v['Language']['locale']]['meta_description'];}?></textarea> </span></p>
<?php 
	}
}?>

<?php if($type == "P"){?>
		<h2>上传图片01：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input id="upload_img_text_1<?php echo $k?>" name="data[CategoryI18n][<?php echo $k;?>][img01]" type="text" size="45" value="<?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['img01'])){echo $this->data['CategoryI18n'][$v['Language']['locale']]['img01'];}?>" /></span><?php echo $html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1".$k.",'product_categories')",'',false,false)?> <button type="button" class="pointer" onclick="change_img_name(1,'<?php echo $v['Language']['locale']?>',<?php echo $this->data['Category']['id']?>,<?php echo $k?>)">自动命名</button>
<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
	<?php echo @$html->image("/..{$this->data['CategoryI18n'][$v['Language']['locale']]['img01']}",array('id'=>'logo_thumb_img_1'.$k,'height'=>'150','style'=>!empty($this->data['CategoryI18n'][$v['Language']['locale']]['img01'])?"display:block":"display:none"))?>
			</p>
<?php 
	}
}?>
		<h2>上传图片02：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input id="upload_img_text_2<?php echo $k?>" name="data[CategoryI18n][<?php echo $k;?>][img02]" type="text" size="45" value="<?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['img02'])){echo $this->data['CategoryI18n'][$v['Language']['locale']]['img02'];}?>"   /></span> <?php echo $html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(2".$k.",'product_categories')",'',false,false)?> <button type="button" class="pointer" onclick="change_img_name(2,'<?php echo $v['Language']['locale']?>',<?php echo $this->data['Category']['id']?>,<?php echo $k?>)">自动命名</button>
			<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				<?php echo @$html->image("/..{$this->data['CategoryI18n'][$v['Language']['locale']]['img02']}",array('id'=>'logo_thumb_img_2'.$k,'height'=>'150','style'=>!empty($this->data['CategoryI18n'][$v['Language']['locale']]['img02'])?"display:block":"display:none"))?>
</p>
<?php 
	}
}?>
<?php }?>
<?php if($type == "A"){?>
		<h2>上传图片01：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input id="upload_img_text_1<?php echo $k?>" name="data[CategoryI18n][<?php echo $k;?>][img01]" type="text" size="45" value="<?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['img01'])){echo $this->data['CategoryI18n'][$v['Language']['locale']]['img01'];}?>" /></span> <?php echo $html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1".$k.",'article_categories')",'',false,false)?> <button type="button"  class="pointer" onclick="change_img_name_gif(1,'<?php echo $v['Language']['locale']?>',<?php echo $this->data['Category']['id']?>,<?php echo $k?>)">自动命名</button>
	<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp	<?php echo @$html->image("/..{$this->data['CategoryI18n'][$v['Language']['locale']]['img01']}",array('id'=>'logo_thumb_img_1'.$k,'height'=>'150','style'=>!empty($this->data['CategoryI18n'][$v['Language']['locale']]['img01'])?"display:block":"display:none"))?>

<?php 
	}
}?>
		<h2>上传图片02：</h2>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input id="upload_img_text_2<?php echo $k?>" name="data[CategoryI18n][<?php echo $k;?>][img02]" type="text" size="45" value="<?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['img02'])){echo $this->data['CategoryI18n'][$v['Language']['locale']]['img02'];}?>"   /></span> <?php echo $html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(2".$k.",'article_categories')",'',false,false)?> <button type="button" onclick="change_img_name_gif(2,'<?php echo $v['Language']['locale']?>',<?php echo $this->data['Category']['id']?>,<?php echo $k?>)" class="pointer">自动命名</button>
					<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp	<?php echo @$html->image("/..{$this->data['CategoryI18n'][$v['Language']['locale']]['img02']}",array('id'=>'logo_thumb_img_2'.$k,'height'=>'150','style'=>!empty($this->data['CategoryI18n'][$v['Language']['locale']]['img02'])?"display:block":"display:none"))?>


			</p>
<?php 
	}
}?>
<?php }?>

<?php if($type == "A"){
?>
<!-- fck start-->
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  详细内容</h1></div>
	  <div class="box">
	  <?php echo $javascript->link('fckeditor/fckeditor'); ?>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	  <?php echo $html->image($v['Language']['img01'])?><br />
<p class="profiles">
    <?php  if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['detail'])){?>
       <?php echo $form->textarea('TopicI18n/intro', array("cols" => "60","rows" => "20","value" => "{$this->data['CategoryI18n'][$v['Language']['locale']]['detail']}","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"TopicI18n{$k}Intro"));?>
        <?php echo $fck->load("TopicI18n{$k}/intro"); ?>
        
    <?php }else{?>
       <?php echo $form->textarea('CategoryI18n/intro', array('cols' => '60', 'rows' => '20','value'=>"","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"CategoryI18n{$k}Intro"));?> 
       <?php  echo $fck->load("CategoryI18n{$k}/intro"); ?>
	<?php }?>
		</p>
		<br /><br />
<?php 
}}}?>
<?php if($type == "P"){
?>
<!-- fck start-->
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  详细内容</h1></div>
	  <div class="box">
	  <?php echo $javascript->link('fckeditor/fckeditor'); ?>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	  <?php echo $html->image($v['Language']['img01'])?><br />
<p class="profiles">
    <?php  if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['detail'])){?>
       <?php echo $form->textarea('TopicI18n/intro', array("cols" => "60","rows" => "20","value" => "{$this->data['CategoryI18n'][$v['Language']['locale']]['detail']}","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"TopicI18n{$k}Intro"));?>
        <?php echo $fck->load("TopicI18n{$k}/intro"); ?>
        
    <?php }else{?>
       <?php echo $form->textarea('CategoryI18n/intro', array('cols' => '60', 'rows' => '20','value'=>"","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"CategoryI18n{$k}Intro"));?> 
       <?php  echo $fck->load("CategoryI18n{$k}/intro"); ?>
	<?php }?>
		</p>
		<br /><br />
<?php 
}}}?>
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
			<?php if(isset($categories_tree) && sizeof($categories_tree)){  //第一层
	   				foreach($categories_tree as $k=>$v){
				  ?>
				 <option value="<?php echo $v['Category']['id'];?>" <?php if($v['Category']['id'] == $this->data['Category']['parent_id']){?>selected<?php }?>><?php echo $v['CategoryI18n']['name'];?></option>
				 	  <?php if(isset($v['SubCategory']) && sizeof($v['SubCategory'])>0){ //第二层
		           	     foreach($v['SubCategory'] as $kk=>$vv){		  
		            		?>
		            		<option value="<?php echo $vv['Category']['id'];?>" <?php if($vv['Category']['id'] == $this->data['Category']['parent_id']){?>selected<?php }?> >|-- <?php echo $vv['CategoryI18n']['name'];?></option>
		            			<?php if(isset($vv['SubCategory']) && sizeof($vv['SubCategory'])>0){ //第二层
				           	     foreach($v['SubCategory'] as $kkk=>$vvv){		  
				            		?> 
				            	<!--	<option value="<?php echo $vvv['Category']['id'];?>"  >|---- <?php echo $vvv['CategoryI18n']['name'];?></option>
				            		-->	<?php }
								  }?>
		            			<?php }
						  }?>
					<?php }
				  }?>
			</select></dd></dl>
		<dl><dt>排序：</dt><dd class="time"><!--<?php echo $form->input('orderby',array('label'=>false,'div'=>false));?>--><input id="CategoryOrderby" name="data[Category][orderby]" type="text" class="text" style="width:108px;"   value="<?php echo $this->data['Category']['orderby'];?>"/></dd></dl>
		<dl><dt>超级连接：</dt><dd class="time"><input id="CategoryFlashConfig" name="data[Category][link]" type="text" class="text"  style="width:108px;" value="<?php echo $this->data['Category']['link'];?>"/></dd></dl>

		</span><dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">是否显示：</dt><dd class="best_input"><input id="CategoryStatus" name="data[Category][status]" type="radio" value="1" <?php if($this->data['Category']['status']){?>checked<?php }?> >是<input id="CategoryStatus" name="data[Category][status]" type="radio" value="0" <?php if($this->data['Category']['status']==0){?>checked<?php }?> >否</dd></dl>

		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">开启筛选：</dt><dd class="best_input"><input  type="checkbox"  name="data[CategoryFilter][status]" value="1" <?php if(isset($filer_status)&&$filer_status=="1"){?>checked<?php }?> id="open_filter" onclick="filter_open()">打钩表示开启筛选属性</dd></dl>

		<div id="is_filter">
			<dl style="padding:5px 0;*padding:6px 0;" ><dt style="padding-top:1px">价格区间：</dt><dd class="best_input" >[<?php echo $html->link("+","javascript:;",array("onclick"=>"add_price()"),false,false);?>]<span id="original_price"><input  type="text"  class="text" value="<?php if(isset($first_price[0])){echo $first_price[0];}?>" style="width:108px;" name="data[Category][start_price][]" > — <input  type="text" class="text" value="<?php if(isset($first_price[1])){ echo $first_price[1];}?>" style="width:108px;" name="data[Category][end_price][]" ></span></dd></dl>
			<div id="hidden_price" style="display:none;"><dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px"></dt> <dd class="best_input">[<?php echo $html->link("-","javascript:;",array("onclick"=>"del_price(this)"),false,false);?>] <input  type="text" class="text" value="" style="width:108px;"  name="data[Category][start_price][]"> — <input  type="text" class="text" value="" style="width:108px;" name="data[Category][end_price][]"></dd></dl></div>
			<div id="add_price">
				<?php if(isset($clone_price) && sizeof($clone_price)>0){
					foreach($clone_price as $k=>$v){ ?>
				 	<div> <dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px"></dt> <dd class="best_input">[<?php echo $html->link("-","javascript:;",array("onclick"=>"del_price(this)"),false,false);?>] <input  type="text" class="text" value="<?php echo $v[0]?>" style="width:108px;"  name="data[Category][start_price][]"> — <input  type="text" class="text" value="<?php echo $v[1]?>" style="width:108px;" name="data[Category][end_price][]"></dd></dl></div>
				<?php }} ?>
			</div>


			<div id="hidden_attr" style="display:none;"><dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px"></dt><dd><span>[<?php echo $html->link("-","javascript:;",array("onclick"=>"del_attr(this)"),false,false);?>] </span><span><select name="attr_type[]" onchange="attr_filter(this)"><option value="0">请选择商品类型</option>	 
		<?php if(isset($product_type) && sizeof($product_type)>0){
			 foreach($product_type as $k=>$v){?>
				 <option value="<?php echo $v['ProductType']['type_id']?>"> <?php echo $v['ProductType']['name']?></option>
		<?	 }
		 }?></select></span><span>&nbsp;<select name="data[Category][attr_filter][]"><option value="0">请选择筛选属性</option></select></span></dd></dl></div>
		
			<?php if(isset($clone_attr) && sizeof($clone_attr)>0){?><div id="add_attr">
			<?php	foreach($clone_attr as $kk=>$vv){ ?>
				 <div>
				 <dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px"><?php if($kk=="0"){?>筛选属性：<?php }?></dt><dd><span>[<?php if($kk=="0"){ echo $html->link("+","javascript:;",array("onclick"=>"add_attr()"),false,false);}else{echo $html->link("-","javascript:;",array("onclick"=>"del_attr(this)"),false,false);}?>] </span><span><select name="attr_type[]" onchange="attr_filter(this)" id="original_attr1">
				 <option value="0">请选择商品类型</option>	 
			<?php if(isset($product_type) && sizeof($product_type)>0){
				 foreach($product_type as $k=>$v){?>
					 <option value="<?php echo $v['ProductType']['type_id']?>" <?php if($v['ProductType']['type_id']==$check_id[$kk]){?> selected<?php }?>> <?php echo $v['ProductType']['name']?></option>
			<?	 }
			 }?></select></span><span>&nbsp;<?php echo $vv?></span></dd></dl>
		 </div>
		<?php }?></div><?php }else{ ?>
		
		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">筛选属性：</dt><dd ><span>[<?php echo $html->link("+","javascript:;",array("onclick"=>"add_attr()"),false,false);?>]</span><span><select onchange="attr_filter(this)" id="original_attr1"><option value="0">请选择商品类型</option>
		 <?php if(isset($product_type) && sizeof($product_type)>0){
			 foreach($product_type as $k=>$v){?>
			 <option value="<?php echo $v['ProductType']['type_id']?>"> <?php echo $v['ProductType']['name']?></option>
			 	
		<?	 }
		 }?>
		</select></span><span id="original_attr2">&nbsp;<select name="data[Category][attr_filter][]"	onchange="check_filter(this)"><option value="0">请选择筛选属性</option></select></span></dd></dl>		
		<div id="add_attr"></div>
			<?php }?>	
		
		
	</div><!-filter end-->




		<dl><dt>分类图片01：</dt><dd><input id="upload_img_text_3" name="data[Category][img01]" type="text" size="45" value="<?php echo  $this->data['Category']['img01'];?>"  /><br /><br />	<?php echo @$html->image("/..{$this->data['Category']['img01']}",array('id'=>'logo_thumb_img_3','height'=>'150','style'=>!empty($this->data['Category']['img01'])?"display:block":"display:none"))?>
</dd><dd><?php echo @$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(3,'product_categories')",'',false,false)?></dd></dl>
		<dl><dt>分类图片02：</dt><dd><input id="upload_img_text_4" name="data[Category][img02]" type="text" size="45" value="<?php echo  $this->data['Category']['img02'];?>"  /><br /><br /><?php echo @$html->image("/..{$this->data['Category']['img02']}",array('id'=>'logo_thumb_img_4','height'=>'150','style'=>!empty($this->data['Category']['img02'])?"display:block":"display:none"))?> </dd><dd><?php echo @$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(4,'product_categories')",'',false,false)?></dd></dl>
		
		<br /><br /><br /><br /><br /><br /><br />
	  </div>
	</div>
<?php endif;?>
<?php if($type == 'A'):?>
	<div class="order_stat athe_infos tongxun">
	  
	  <div class="box">
	  <!-- start -->
	  		<dl><dt>上级分类：</dt><dd><select id="CategoryParentId" name="data[Category][parent_id]">
			<option value="0">顶层</option>
			<?php if(isset($categories_tree) && sizeof($categories_tree)>0){  //第一层
	   				foreach($categories_tree as $k=>$v){
				  ?>
				 <option value="<?php echo $v['Category']['id'];?>" <?php if($v['Category']['id'] == $this->data['Category']['parent_id']){?>selected<?php }?>><?php echo $v['CategoryI18n']['name'];?></option>
				 	  <?php if(isset($v['SubCategory']) && sizeof($v['SubCategory'])>0){ //第二层
		           	     foreach($v['SubCategory'] as $kk=>$vv){		  
		            		?>
		            		<option value="<?php echo $vv['Category']['id'];?>" <?php if($vv['Category']['id'] == $this->data['Category']['parent_id']){?>selected<?php }?> >|-- <?php echo $vv['CategoryI18n']['name'];?></option>
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
	  <!-- end -->
		<dl><dt>排序：</dt><dd class="time"><!--<?php echo $form->input('orderby',array('label'=>false,'div'=>false));?>--><input id="CategoryOrderby" name="data[Category][orderby]" type="text" class="text" style="width:108px;"   value="<?php echo $this->data['Category']['orderby'];?>"/></dd></dl>
		<dl><dt>超级连接：</dt><dd class="time"><input id="CategoryFlashConfig" name="data[Category][link]" type="text" class="text"  style="width:108px;" value="<?php echo $this->data['Category']['link'];?>"/></dd></dl>
		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">是否显示：</dt><dd class="best_input"><input id="CategoryStatus" name="data[Category][status]" type="radio" value="1" <?php if($this->data['Category']['status']){?>checked<?php }?> >是<input id="CategoryStatus" name="data[Category][status]" type="radio" value="0" <?php if($this->data['Category']['status']==0){?>checked<?php }?> >否</dd></dl>
		<dl><dt>分类图片01：</dt><dd><input id="upload_img_text_5" name="data[Category][img01]" type="text" size="50" value="<?php echo  $this->data['Category']['img01'];?>"  /><br /><br /><?php echo $html->image("/..{$this->data['Category']['img01']}",array('id'=>'logo_thumb_img_5','height'=>'150','style'=>!empty($this->data['Category']['img01'])?"display:block":"display:none"))?> </dd><dd><?php echo $html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(5,'article_categories')",'',false,false)?></dd></dl>
		<dl><dt>分类图片02：</dt><dd><input id="upload_img_text_6" name="data[Category][img02]" type="text" size="50" value="<?php echo  $this->data['Category']['img02'];?>"  /><br /><br /><?php echo $html->image("/..{$this->data['Category']['img02']}",array('id'=>'logo_thumb_img_6','height'=>'150','style'=>!empty($this->data['Category']['img02'])?"display:block":"display:none"))?></dd><dd><?php echo $html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(6,'article_categories')",'',false,false)?></dd></dl>
		<br /><br /><br /><br /><br /><br /><br />
		<input name="data[Category][type]" type="hidden"  value="A"/>
	  </div>
	</div>
<?php endif;?>
<!--Other Stat End-->
</td>
</tr>

</table>
<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
<?php echo $form->end();?>
</div>
<!--Main Start End-->
</div>
<script>
filter_open();
//显示 隐藏层
function filter_open(){
	var obj=document.getElementById('open_filter');
	if(obj.checked== true){
		document.getElementById('is_filter').style.display="block";
	}else{
		document.getElementById('is_filter').style.display="none";
		document.getElementById('add_attr').innerHTML="";
		document.getElementById('add_price').innerHTML="";
		document.getElementById('original_price').innerHTML='<input  type="text" class="text" value="" style="width:108px;" name="data[Category][start_price][]" > — <input  type="text" class="text" value="" style="width:108px;" name="data[Category][end_price][]" >';
		var div = document.createElement("div");
		var imgupload_str = document.getElementById("hidden_attr").innerHTML; 
		div.innerHTML=imgupload_str;
		document.getElementById("add_attr").appendChild(div);	
		var add_attr=document.getElementById("add_attr");
		add_attr.childNodes[0].childNodes[0].childNodes[0].innerHTML="筛选属性：";
		add_attr.childNodes[0].childNodes[0].childNodes[1].childNodes[0].innerHTML='[<?php echo $html->link("+","javascript:;",array("onclick"=>"add_attr()"),false,false);?>]';
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

function del_attr(obj){
	var conObj=document.getElementById('add_attr');
	var id=obj.parentNode.parentNode.parentNode.parentNode;
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
function change_img_name(nu,type,id,e_id){
	var img_url = "/img/article_categories/"+id+"/"+type+"_0"+nu+".jpg"
	var get_id = "upload_img_text_"+nu+e_id;
	document.getElementById(get_id).value = img_url;

}
function change_img_name_gif(nu,type,id,e_id){
	var img_url = "/img/article_categories/"+id+"/"+type+"_0"+nu+".gif"
	var get_id = "upload_img_text_"+nu+e_id;
	document.getElementById(get_id).value = img_url;

}

<?php }else{?>
function change_img_name(nu,type,id,e_id){
	var img_url = "/img/product_categories/"+id+"/"+type+"_0"+nu+".jpg"
	var get_id = "upload_img_text_"+nu+e_id;
	document.getElementById(get_id).value = img_url;

}
function change_img_name_gif(nu,type,id,e_id){
	var img_url = "/img/product_categories/"+id+"/"+type+"_0"+nu+".gif"
	var get_id = "upload_img_text_"+nu+e_id;
	document.getElementById(get_id).value = img_url;

}
<?php }?>
</script>