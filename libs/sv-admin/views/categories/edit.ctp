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
 * $Id: edit.ctp 943 2009-04-23 10:38:44Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<?php if($type=='P'){?><p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."分类列表","/categories/index/P/",'',false,false);?></strong></p>
<?}?>
<?php if($type=='A'){?><p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."分类列表","/categories/index/A/",'',false,false);?></strong></p>
<?}?>
<!--Main Start-->
<div class="home_main categories_infos">
<?php if($type=='P'){echo $form->create('Category',array('action'=>'edit/P/','onsubmit'=>'return categories_P_check();'));}?>
<?php if($type=='A'){echo $form->create('Category',array('action'=>'edit/A/','onsubmit'=>'return categories_A_check();'));}?>
<input id="CategoryId" name="data[Category][id]" type="hidden" value="<?= $this->data['Category']['id'];?>">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?=@$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=@$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑分类</h1></div>
	  <div class="box">


<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="CategoryI18n<?=$k;?>Locale" name="data[CategoryI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
	   <?if(isset($this->data['CategoryI18n'][$v['Language']['locale']])){?>
	<input id="CategoryI18n<?=$k;?>Id" name="data[CategoryI18n][<?=$k;?>][id]" type="hidden" value="<?= $this->data['CategoryI18n'][$v['Language']['locale']]['id'];?>">
	   <?}?>
	   	<input id="CategoryI18n<?=$k;?>CategoryId" name="data[CategoryI18n][<?=$k;?>][category_id]" type="hidden" value="<?= $this->data['Category']['id'];?>">
<?
	}
}?>


  	    <h2>分类名称：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input  id="category_name_<?=$v['Language']['locale']?>" name="data[CategoryI18n][<?=$k;?>][name]" type="text" maxlength="100" value="<?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['name'])){echo $this->data['CategoryI18n'][$v['Language']['locale']]['name'];}?>"> <font color="#ff0000">*</font></span></p>
<?
	}
}?>

		<h2>关键字：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="CategoryI18n<?=$k;?>MetaKeywords" name="data[CategoryI18n][<?=$k;?>][meta_keywords]" type="text" style="width:215px;" value="<?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['meta_keywords'])){ echo $this->data['CategoryI18n'][$v['Language']['locale']]['meta_keywords'];}?>"> </span></p>
<?
	}
}?>
		<h2>分类描述：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea id="CategoryI18n<?=$k;?>MetaDescription" name="data[CategoryI18n][<?=$k;?>][meta_description]" ><?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['meta_description'])){echo $this->data['CategoryI18n'][$v['Language']['locale']]['meta_description'];}?></textarea> </span></p>
<?
	}
}?>

<? if($type == "P"){?>
		<h2>上传图片01：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="upload_img_text_1<?=$k?>" name="data[CategoryI18n][<?=$k;?>][img01]" type="text" size="45" value="<?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['img01'])){echo $this->data['CategoryI18n'][$v['Language']['locale']]['img01'];}?>" /></span><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1".$k.",'product_categories')",'',false,false)?> <button class="pointer" onclick="change_img_name(1,'<?=$v['Language']['locale']?>',<?=$this->data['Category']['id']?>,<?=$k?>)">自动命名</button>
<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
	<?=@$html->image("/..{$this->data['CategoryI18n'][$v['Language']['locale']]['img01']}",array('id'=>'logo_thumb_img_1'.$k,'height'=>'150'))?>
			</p>
<?
	}
}?>
		<h2>上传图片02：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="upload_img_text_2<?=$k?>" name="data[CategoryI18n][<?=$k;?>][img02]" type="text" size="45" value="<?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['img02'])){echo $this->data['CategoryI18n'][$v['Language']['locale']]['img02'];}?>"   /></span> <?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(2".$k.",'product_categories')",'',false,false)?> <button class="pointer" onclick="change_img_name(2,'<?=$v['Language']['locale']?>',<?=$this->data['Category']['id']?>,<?=$k?>)">自动命名</button>
			<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				<?=@$html->image("/..{$this->data['CategoryI18n'][$v['Language']['locale']]['img02']}",array('id'=>'logo_thumb_img_2'.$k,'height'=>'150'))?>
</p>
<?
	}
}?>
<?}?>
<? if($type == "A"){?>
		<h2>上传图片01：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="upload_img_text_1<?=$k?>" name="data[CategoryI18n][<?=$k;?>][img01]" type="text" size="45" value="<?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['img01'])){echo $this->data['CategoryI18n'][$v['Language']['locale']]['img01'];}?>" /></span> <?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1".$k.",'article_categories')",'',false,false)?> <button class="pointer" onclick="change_img_name_gif(1,'<?=$v['Language']['locale']?>',<?=$this->data['Category']['id']?>,<?=$k?>)">自动命名</button>
	<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbs	<?=@$html->image("/..{$this->data['CategoryI18n'][$v['Language']['locale']]['img01']}",array('id'=>'logo_thumb_img_1'.$k,'height'=>'150'))?>

<?
	}
}?>
		<h2>上传图片02：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="upload_img_text_2<?=$k?>" name="data[CategoryI18n][<?=$k;?>][img02]" type="text" size="45" value="<?php if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['img02'])){echo $this->data['CategoryI18n'][$v['Language']['locale']]['img02'];}?>"   /></span> <?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(2".$k.",'article_categories')",'',false,false)?> <button onclick="change_img_name_gif(2,'<?=$v['Language']['locale']?>',<?=$this->data['Category']['id']?>,<?=$k?>)" class="pointer">自动命名</button>
					<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp	<?=@$html->image("/..{$this->data['CategoryI18n'][$v['Language']['locale']]['img02']}",array('id'=>'logo_thumb_img_2'.$k,'height'=>'150'))?>


			</p>
<?
	}
}?>
<?}?>

<? if($type == "A"){
?>
<!-- fck start-->
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  详细内容</h1></div>
	  <div class="box">
	  <?php echo $javascript->link('fckeditor/fckeditor'); ?>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	  <?=$html->image($v['Language']['img01'])?><br />
<p class="profiles">
    <?  if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['detail'])){?>
       <?php echo $form->textarea('TopicI18n/intro', array("cols" => "60","rows" => "20","value" => "{$this->data['CategoryI18n'][$v['Language']['locale']]['detail']}","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"TopicI18n{$k}Intro"));?>
        <? echo $fck->load("TopicI18n{$k}/intro"); ?>
        
    <?}else{?>
       <?php echo $form->textarea('CategoryI18n/intro', array('cols' => '60', 'rows' => '20','value'=>"","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"CategoryI18n{$k}Intro"));?> 
       <?php  echo $fck->load("CategoryI18n{$k}/intro"); ?>
	<?}?>
		</p>
		<br /><br />
<?
}}}?>
<? if($type == "P"){
?>
<!-- fck start-->
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  详细内容</h1></div>
	  <div class="box">
	  <?php echo $javascript->link('fckeditor/fckeditor'); ?>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	  <?=$html->image($v['Language']['img01'])?><br />
<p class="profiles">
    <?  if(isset($this->data['CategoryI18n'][$v['Language']['locale']]['detail'])){?>
       <?php echo $form->textarea('TopicI18n/intro', array("cols" => "60","rows" => "20","value" => "{$this->data['CategoryI18n'][$v['Language']['locale']]['detail']}","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"TopicI18n{$k}Intro"));?>
        <? echo $fck->load("TopicI18n{$k}/intro"); ?>
        
    <?}else{?>
       <?php echo $form->textarea('CategoryI18n/intro', array('cols' => '60', 'rows' => '20','value'=>"","name"=>"data[CategoryI18n][{$k}][detail]","id"=>"CategoryI18n{$k}Intro"));?> 
       <?php  echo $fck->load("CategoryI18n{$k}/intro"); ?>
	<?}?>
		</p>
		<br /><br />
<?
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
				 <option value="<?=$v['Category']['id'];?>" <?if($v['Category']['id'] == $this->data['Category']['parent_id']){?>selected<?}?>><?=$v['CategoryI18n']['name'];?></option>
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
		<dl><dt>排序：</dt><dd class="time"><!--<? echo $form->input('orderby',array('label'=>false,'div'=>false));?>--><input id="CategoryOrderby" name="data[Category][orderby]" type="text" class="text" style="width:108px;"   value="<?=$this->data['Category']['orderby'];?>"/></dd></dl>
		<dl><dt>FLASH幻灯片参数：</dt><dd class="time"><input id="CategoryFlashConfig" name="data[Category][flash_config]" type="text" class="text" value="<?=$this->data['Category']['flash_config'];?>"/></dd></dl>
		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">是否显示：</dt><dd class="best_input"><input id="CategoryStatus" name="data[Category][status]" type="radio" value="1" <?if($this->data['Category']['status']){?>checked<?}?> >是<input id="CategoryStatus" name="data[Category][status]" type="radio" value="0" <?if($this->data['Category']['status']==0){?>checked<?}?> >否</dd></dl>
		<dl><dt>分类图片01：</dt><dd><input id="upload_img_text_3" name="data[Category][img01]" type="text" size="45" value="<?= $this->data['Category']['img01'];?>"  /><br /><br />	<?=@$html->image("/..{$this->data['Category']['img01']}",array('id'=>'logo_thumb_img_3','height'=>'150'))?>
</dd><dd><?=@$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(3,'product_categories')",'',false,false)?></dd></dl>
		<dl><dt>分类图片02：</dt><dd><input id="upload_img_text_4" name="data[Category][img02]" type="text" size="45" value="<?= $this->data['Category']['img02'];?>"  /><br /><br /><?=@$html->image("/..{$this->data['Category']['img02']}",array('id'=>'logo_thumb_img_4','height'=>'150'))?> </dd><dd><?=@$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(4,'product_categories')",'',false,false)?></dd></dl>
		
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
				 <option value="<?=$v['Category']['id'];?>" <?if($v['Category']['id'] == $this->data['Category']['parent_id']){?>selected<?}?>><?=$v['CategoryI18n']['name'];?></option>
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
	  <!-- end -->
		<dl><dt>排序：</dt><dd class="time"><!--<? echo $form->input('orderby',array('label'=>false,'div'=>false));?>--><input id="CategoryOrderby" name="data[Category][orderby]" type="text" class="text" style="width:108px;"   value="<?=$this->data['Category']['orderby'];?>"/></dd></dl>
		<dl><dt>超级连接：</dt><dd class="time"><input id="CategoryFlashConfig" name="data[Category][link]" type="text" class="text"  style="width:108px;" value="<?=$this->data['Category']['link'];?>"/></dd></dl>
		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px">是否显示：</dt><dd class="best_input"><input id="CategoryStatus" name="data[Category][status]" type="radio" value="1" <?if($this->data['Category']['status']){?>checked<?}?> >是<input id="CategoryStatus" name="data[Category][status]" type="radio" value="0" <?if($this->data['Category']['status']==0){?>checked<?}?> >否</dd></dl>
		<dl><dt>分类图片01：</dt><dd><input id="upload_img_text_5" name="data[Category][img01]" type="text" size="50" value="<?= $this->data['Category']['img01'];?>"  /><br /><br /><?=$html->image("/..{$this->data['Category']['img01']}",array('id'=>'logo_thumb_img_5','height'=>'150'))?> </dd><dd><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(5,'article_categories')",'',false,false)?></dd></dl>
		<dl><dt>分类图片02：</dt><dd><input id="upload_img_text_6" name="data[Category][img02]" type="text" size="50" value="<?= $this->data['Category']['img02'];?>"  /><br /><br /><?=$html->image("/..{$this->data['Category']['img02']}",array('id'=>'logo_thumb_img_6','height'=>'150'))?></dd><dd><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(6,'article_categories')",'',false,false)?></dd></dl>
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
<? echo $form->end();?>
</div>
<!--Main Start End-->
</div>
<script>
function change_img_name(nu,type,id,e_id){
	var img_url = webroot_dir+"../img/article_categories/"+id+"/"+type+"_0"+nu+".jpg"
	var get_id = "upload_img_text_"+nu+e_id;
	document.getElementById(get_id).value = img_url;

}
function change_img_name_gif(nu,type,id,e_id){
	var img_url = webroot_dir+"../img/article_categories/"+id+"/"+type+"_0"+nu+".gif"
	var get_id = "upload_img_text_"+nu+e_id;
	document.getElementById(get_id).value = img_url;

}

</script>