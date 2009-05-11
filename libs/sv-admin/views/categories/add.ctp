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
 * $Id: add.ctp 1327 2009-05-11 11:01:20Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong>
<?php if($type=='P'){?><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."分类列表","/categories/index/P/",'',false,false);?><?}?>
<?php if($type=='A'){?><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."分类列表","/categories/index/A/",'',false,false);?><?}?></strong></p>
<!--Main Start-->
<div class="home_main categories_infos">
<?php if($type=='P'){echo $form->create('Category',array('action'=>'add/P','onsubmit'=>'return categories_P_check();'));}?>
<?php if($type=='A'){echo $form->create('Category',array('action'=>'add/A','onsubmit'=>'return categories_A_check();'));}?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
<input type="hidden" id="categoryid" value="<?=$categories_id?>">
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑分类</h1></div>
	  <div class="box">
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="CategoryI18n<?=$k;?>Locale" name="data[CategoryI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
<?
	}
}?>
  	    <h2>分类名称：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="category_name_<?=$v['Language']['locale']?>" name="data[CategoryI18n][<?=$k;?>][name]" type="text" maxlength="100" value=""> <font color="#ff0000">*</font></span></p>
<?
	}
}?>

		<h2>关键字：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="CategoryI18n<?=$k;?>MetaKeywords" name="data[CategoryI18n][<?=$k;?>][meta_keywords]" type="text" style="width:215px;" value=""></span></p>
<?
	}
}?>
		<h2>分类描述：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea id="CategoryI18n<?=$k;?>MetaDescription" name="data[CategoryI18n][<?=$k;?>][meta_description]" ></textarea> </span></p>
<?
	}
}?>
<?if($type == "P"){?>
		<h2>上传图片01：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="upload_img_text_1<?=$k?>" name="data[CategoryI18n][<?=$k;?>][img01]" type="text" size="50"  /></span> <?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1".$k.",'product_categories')",'',false,false)?><input  type="button" value="自动命名" onclick="change_img_name(1,'<?=$v['Language']['locale']?>',1<?=$k?>)">
<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			<?=@$html->image('',array('id'=>'logo_thumb_img_1'.$k,'height'=>'150','style'=>'display:none'))?>

			</p>
<?
	}
}?>
		<h2>上传图片02：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="upload_img_text_2<?=$k?>" name="data[CategoryI18n][<?=$k;?>][img02]" type="text" size="50"  /></span> <?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(2".$k.",'product_categories')",'',false,false)?><input type="button" value="自动命名" onclick="change_img_name(2,'<?=$v['Language']['locale']?>',2<?=$k?>)">
<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?=@$html->image('',array('id'=>'logo_thumb_img_2'.$k,'height'=>'150','style'=>'display:none'))?>

			</p>
<?
	}
}?>
<?}?>
<?if($type == "A"){?>
		<h2>上传图片01：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="upload_img_text_1<?=$k?>" name="data[CategoryI18n][<?=$k;?>][img01]" type="text" size="50"  /></span><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1".$k.",'article_categories')",'',false,false)?><input type="button" value="自动命名" onclick="change_img_name_gif(1,'<?=$v['Language']['locale']?>',1<?=$k?>)">
	<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?=@$html->image('',array('id'=>'logo_thumb_img_1'.$k,'height'=>'150','style'=>'display:none'))?>


			</p>
<?
	}
}?>
		<h2>上传图片02：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="upload_img_text_2<?=$k?>" name="data[CategoryI18n][<?=$k;?>][img02]" type="text" size="50"  /></span><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(2".$k.",'article_categories')",'',false,false)?><input type="button" value="自动命名" onclick="change_img_name_gif(2,'<?=$v['Language']['locale']?>',2<?=$k?>)">
				<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?=@$html->image('',array('id'=>'logo_thumb_img_2'.$k,'height'=>'150','style'=>'display:none'))?>


			
			</p>
<?
	}
}?>
<?}?>

<? if($type == "A"){?>
<!-- fck start-->
	 <h2>详细内容：</h2>
	  <?php echo $javascript->link('fckeditor/fckeditor'); ?>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	  <?=$html->image($v['Language']['img01'])?><br />
	  <img src="images/tools_img.gif" align="absbottom" />
<p class="profiles">

       <?php echo $form->textarea('CategoryI18n/intro', array('cols' => '60', 'rows' => '20','value'=>"","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"CategoryI18n{$k}Intro"));?> 
		<?php $fck->Height = "400" ;?>
       <?php  echo $fck->load("CategoryI18n{$k}/intro"); ?>

		</p>
		<br /><br />
<?
}}}?>
<? if($type == "P"){?>
<!-- fck start-->
	 <h2>详细内容：</h2>
	  <?php echo $javascript->link('fckeditor/fckeditor'); ?>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	  <?=$html->image($v['Language']['img01'])?><br />
	  <img src="images/tools_img.gif" align="absbottom" />
<p class="profiles">

       <?php echo $form->textarea('CategoryI18n/intro', array('cols' => '60', 'rows' => '20','value'=>"","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"CategoryI18n{$k}Intro"));?> 
		<?php $fck->Height = "400" ;?>
       <?php  echo $fck->load("CategoryI18n{$k}/intro"); ?>

		</p>
		<br /><br />
<?
}}}?>
</div><!-- fck end-->
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
				 <option value="<?=$v['Category']['id'];?>"><?=$v['CategoryI18n']['name'];?></option>
				 	  <?php if(isset($v['SubCategory']) && sizeof($v['SubCategory'])>0){ //第二层
		           	     foreach($v['SubCategory'] as $kk=>$vv){		  
		            		?>
		            		<option value="<?=$vv['Category']['id'];?>">|-- <?=$vv['CategoryI18n']['name'];?></option>
		            			<?php if(isset($vv['SubCategory']) && sizeof($vv['SubCategory'])>0){ //第二层
				           	     foreach($v['SubCategory'] as $kkk=>$vvv){		  
				            		?>
				            		<option value="<?=$vvv['Category']['id'];?>">|---- <?=$vvv['CategoryI18n']['name'];?></option>
				            			<?}
								  }?>
		            			<?}
						  }?>
					<?}
				  }?>
			</select></dd></dl>
		<dl><dt>排序：</dt><dd class="time"><!--<? echo $form->input('orderby',array('label'=>false,'div'=>false));?>--><input id="CategoryOrderby" name="data[Category][orderby]" type="text" class="text" style="width:108px;"   value=""/></dd></dl>
		<span style="display:none"><dl><dt>FLASH幻灯片参数：</dt><dd class="time"><input id="CategoryFlashConfig" name="data[Category][flash_config]" type="text" class="text" value=""/></dd></dl>
		</span><dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">是否显示：</dt><dd class="best_input"><input id="CategoryStatus" name="data[Category][status]" type="radio" value="1" checked >是<input id="CategoryStatus" name="data[Category][status]" type="radio" value="0"  >否</dd></dl>
		<dl><dt>分类图片01：</dt><dd><input id="upload_img_text_3" name="data[Category][img01]" type="text" size="50" /><br /><br /><?=@$html->image('',array('id'=>'logo_thumb_img_3','height'=>'150','style'=>'display:none'))?>
</dd><dd><?=@$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(3,'product_categories')",'',false,false)?></dd></dl>
		<dl><dt>分类图片02：</dt><dd><input id="upload_img_text_4" name="data[Category][img02]" type="text" size="50" /><br /><br /><?=@$html->image('',array('id'=>'logo_thumb_img_4','height'=>'150','style'=>'display:none'))?>
</dd><dd><?=@$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(4,'product_categories')",'',false,false)?></dd></dl>
		
		<br /><br /><br /><br /><br /><br /><br />
	  </div>
	</div>
<?php endif;?>
<?php if($type == 'A'):?>
	<div class="order_stat athe_infos tongxun">
	  
	  <div class="box">
	  <!-- start  -->
	  		<dl><dt>上级分类：</dt><dd><select id="CategoryParentId" name="data[Category][parent_id]">
			<option value="0">顶层</option>
			<?php if(isset($categories_tree) && sizeof($categories_tree)>0){  //第一层
	   				foreach($categories_tree as $k=>$v){
				  ?>
				 <option value="<?=$v['Category']['id'];?>"><?=$v['CategoryI18n']['name'];?></option>
				 	  <?php if(isset($v['SubCategory']) && sizeof($v['SubCategory'])>0){ //第二层
		           	     foreach($v['SubCategory'] as $kk=>$vv){		  
		            		?>
		            		<option value="<?=$vv['Category']['id'];?>">|-- <?=$vv['CategoryI18n']['name'];?></option>
		            			<?php if(isset($vv['SubCategory']) && sizeof($vv['SubCategory'])>0){ //第二层
				           	     foreach($v['SubCategory'] as $kkk=>$vvv){		  
				            		?>
				            		<option value="<?=$vvv['Category']['id'];?>">|---- <?=$vvv['CategoryI18n']['name'];?></option>
				            			<?}
								  }?>
		            			<?}
						  }?>
					<?}
				  }?>
			</select></dd></dl>
	   <!-- end  -->
		<dl><dt>排序：</dt><dd class="time"><!--<? echo $form->input('orderby',array('label'=>false,'div'=>false));?>--><input id="CategoryOrderby" name="data[Category][orderby]" type="text" class="text" style="width:108px;"   value=""/></dd></dl>
		<dl><dt>超级连接：</dt><dd class="time"><input id="CategoryFlashConfig" name="data[Category][link]" type="text" class="text"  style="width:108px;"  value=""/></dd></dl>
		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">是否显示：</dt><dd class="best_input"><input id="CategoryStatus" name="data[Category][status]" type="radio" value="1" checked >是<input id="CategoryStatus" name="data[Category][status]" type="radio" value="0"  >否</dd></dl>
		<dl><dt>分类图片01：</dt><dd><input id="upload_img_text_5" name="data[Category][img01]" type="text" size="50" /><br /><br /><?=@$html->image('',array('id'=>'logo_thumb_img_5','height'=>'150','style'=>'display:none'))?>
</dd><dd><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(5,'article_categories')",'',false,false)?></dd></dl>
		<dl><dt>分类图片02：</dt><dd><input id="upload_img_text_6" name="data[Category][img02]" type="text" size="50" /><br /><br /><?=@$html->image('',array('id'=>'logo_thumb_img_6','height'=>'150','style'=>'display:none'))?>
</dd><dd><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(6,'article_categories')",'',false,false)?></dd></dl>
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
</div>
<!--Main Start End-->
</div>
<script>

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
<?}else{?>
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

<?}?>
</script>