<?php 
/*****************************************************************************
 * SV-Cart 店铺管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 5339 2009-10-22 09:16:41Z huangbo $
*****************************************************************************/
?> 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />


<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."店铺列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>
<div class="home_main">
<?php echo $form->create('Store',array('action'=>'edit','onsubmit'=>'return stores_check();'));?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
	<td align="left" width="50%" valign="top" style="padding-right:5px">
	<div class="order_stat athe_infos configvalues">
	<div class="title">
	<h1><?php echo $html->image('tab_left.gif',array('class'=>'left'))?><?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑店铺</h1></div>
	  <div class="box">
<dl><dt>店铺名称: </dt></dl>
	
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd><input type="text" style="width:195px;border:1px solid #649776" id="name<?php echo $v['Language']['locale']?>" name="data[StoreI18n][<?php echo $k;?>][name]" <?php if(isset($stores_info['StoreI18n'][$v['Language']['locale']])){?>value="<?php echo  $stores_info['StoreI18n'][$v['Language']['locale']]['name'];?>"<?php }else{?>value=""<?php }?>/> <font color="#F90071">*</font></dd></dl>
	
<?php }}?>
	<dl><dt>联系电话: </dt></dl>
	
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd><input type="text" style="width:195px;border:1px solid #649776" id="telephone<?php echo $v['Language']['locale']?>" name="data[StoreI18n][<?php echo $k;?>][telephone]" <?php if(isset($stores_info['StoreI18n'][$v['Language']['locale']])){?>value="<?php echo  $stores_info['StoreI18n'][$v['Language']['locale']]['telephone'];?>"<?php }else{?>value=""<?php }?>/> <font color="#F90071">*</font></dd></dl>
	
<?php 
}
}?>
<dl><dt>邮件地址: </dt>	</dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?> </dt>
		<dd><input type="text" style="width:195px;border:1px solid #649776" name="data[StoreI18n][<?php echo $k;?>][address]" <?php if(isset($stores_info['StoreI18n'][$v['Language']['locale']])){?>value="<?php echo  $stores_info['StoreI18n'][$v['Language']['locale']]['address'];?>"<?php }else{?>value=""<?php }?>/></dd></dl>
<?php }
} ?>
	<dl><dt>邮编: </dt></dl>
	
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd><input type="text" style="width:195px;border:1px solid #649776" id="zipcode<?php echo $v['Language']['locale']?>" name="data[StoreI18n][<?php echo $k;?>][zipcode]" <?php if(isset($stores_info['StoreI18n'][$v['Language']['locale']])){?>value="<?php echo  $stores_info['StoreI18n'][$v['Language']['locale']]['zipcode'];?>"<?php }else{?>value=""<?php }?>/> <font color="#F90071">*</font></dd></dl>
	
<?php 
}
}?>  	<dl><dt>超链接: </dt></dl>
	
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd><input type="text" style="width:195px;border:1px solid #649776" id="url<?php echo $v['Language']['locale']?>" name="data[StoreI18n][<?php echo $k;?>][url]" <?php if(isset($stores_info['StoreI18n'][$v['Language']['locale']])){?>value="<?php echo  $stores_info['StoreI18n'][$v['Language']['locale']]['url'];?>"<?php }else{?>value=""<?php }?> /> <font color="#F90071">*</font></dd></dl>
	
<?php 
}
}?>
		<dl><dt>关键字: </dt></dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?> </dt>
		<dd><input type="text" style="width:195px;border:1px solid #649776" id="StoreI18n<?php echo $k;?>meta_keywords" name="data[StoreI18n][<?php echo $k;?>][meta_keywords]" value="<?php echo  @$stores_info['StoreI18n'][$v['Language']['locale']]['meta_keywords'];?>"/>
			<select style="width:90px;border:1px solid #649776" onchange="add_to_seokeyword(this,'StoreI18n<?php echo $k;?>meta_keywords')">
				<option value='常用关键字'>常用关键字</option>
				<?php foreach( $seokeyword_data as $sk=>$sv){?>
					<option value='<?php echo $sv["SeoKeyword"]["name"]?>'><?php echo $sv["SeoKeyword"]["name"]?></option>
				<?php }?>
			</select>

		</dd></dl>
		
<?php }
} ?>	

	<dl><dt>SEO描述: </dt></dl>
<?php //pr($languages);?>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd><textarea style="height:90px;overflow-y:scroll;width:355px;border:1px solid #649776" name="data[StoreI18n][<?php echo $k;?>][meta_description]"><?php if(isset($stores_info['StoreI18n'][$v['Language']['locale']])){?><?php echo  $stores_info['StoreI18n'][$v['Language']['locale']]['meta_description'];?><?php }else{?><?php }?></textarea></dd></dl>
<?php }
} ?>
	
<dl><dt>地图: </dt>	</dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?> </dt>
		<dd><input type="text" style="width:195px;border:1px solid #649776" name="data[StoreI18n][<?php echo $k;?>][map]"  id="upload_img_text_<?php echo $k?>" <?php if(@isset($stores_info['StoreI18n'][$v['Language']['locale']])){?>value="<?php echo @$stores_info['StoreI18n'][$v['Language']['locale']]['map'];?>"<?php }else{?>value=""<?php }?>/>&nbsp<br /><br />
	<?php echo @$html->image("/..{$stores_info['StoreI18n'][$v['Language']['locale']]['map']}",array('id'=>'logo_thumb_img_'.$k,'style'=>!empty($stores_info['StoreI18n'][$v['Language']['locale']]['map'])?"display:block":"display:none"))?>
</dd><dd><?php echo $html->link($html->image('select_img.gif',array("class"=>"vmiddle icons",$title_arr['select_img'],"height"=>"20")),"javascript:img_sel(".$k.",'others')",'',false,false)?></dd></dl>
<?php }
} ?>
<dl><dt>交通: </dt>	</dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?> </dt>
		<dd><input type="text" style="width:195px;border:1px solid #649776" name="data[StoreI18n][<?php echo $k;?>][transport]" id="upload_img_text_1<?php echo $k?>" <?php if(isset($stores_info['StoreI18n'][$v['Language']['locale']])){?>value="<?php echo  $stores_info['StoreI18n'][$v['Language']['locale']]['transport'];?>"<?php }else{?>value=""<?php }?>/><br /><br />
				<?php echo @$html->image("/..{$stores_info['StoreI18n'][$v['Language']['locale']]['transport']}",array('id'=>'logo_thumb_img_1'.$k,'style'=>!empty($stores_info['StoreI18n'][$v['Language']['locale']]['transport'])?"display:block":"display:none"))?>
</dd><dd><?php echo $html->link($html->image('select_img.gif',array("class"=>"vmiddle icons",$title_arr['select_img'],"height"=>"20")),"javascript:img_sel(1".$k.",'others')",'',false,false)?></dd></dl>

<?php }
} ?>	
	  </div>
     </div>
	</td>

<td align="left" width="50%" valign="top" style="padding-right:5px;padding-top:26px">
<div class="order_stat athe_infos configvalues">
	  <div class="box">
	<input type="hidden" name="data[Store][id]" value=<?php echo $stores_info['Store']['id']; ?>>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="StoreI18n<?php echo $k;?>Locale" name="data[StoreI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo $v['Language']['locale'];?>">
			   <?php if(isset($stores_info['StoreI18n'][$v['Language']['locale']])){?>
	<input id="StoreI18n<?php echo $k;?>Id" name="data[StoreI18n][<?php echo $k;?>][id]" type="hidden" value="<?php echo  $stores_info['StoreI18n'][$v['Language']['locale']]['id'];?>">
	   <?php }?>
	   	<input id="StoreI18n<?php echo $k;?>StoreId" name="data[StoreI18n][<?php echo $k;?>][store_id]" type="hidden" value="<?php echo  $stores_info['Store']['id'];?>">
<?php 
	}
}?>
<!--Menus_Config-->
	  <div class="shop_config menus_configs" style="width:auto;">
		<dl><dt>类型：</dt>
		<dd>
		<select name="data[Store][store_type]">
		<?php foreach( $systemresource_info["store_type"] as $k=>$v ){?>
		<option value="<?php echo $k;?>" <?php if($k == $stores_info['Store']['store_type']){ echo "selected";}?> ><?php echo $v;?></option>
		<?php }?>
		</select>
		</dd></dl>

		<dl><dt>联系人: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776" name="data[Store][contact_name]" value="<?php echo $stores_info['Store']['contact_name']; ?> " /></dd></dl>
		<dl><dt>店铺号: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776" name="data[Store][store_sn]" value="<?php echo $stores_info['Store']['store_sn']; ?> " /></dd></dl>
		<dl><dt>E-mail: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776" name="data[Store][contact_email]" value="<?php echo $stores_info['Store']['contact_email']; ?> " /></dd></dl>
		<dl><dt>联系电话: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776"  name="data[Store][contact_tele]" value="<?php echo $stores_info['Store']['contact_tele']; ?>"  /></dd></dl>
		<dl><dt>手机: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776" name="data[Store][contact_mobile]" value="<?php echo $stores_info['Store']['contact_mobile']; ?>" /></dd></dl>
		<dl><dt>传真: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776" name="data[Store][contact_fax]" value="<?php echo $stores_info['Store']['contact_fax']; ?>" /></dd></dl>
		<dl><dt>网址: </dt>
		<dd><input type="text" style="width:355px;border:1px solid #649776" name="data[Store][url]" value="<?php echo $stores_info['Store']['url']; ?>" /></dd></dl>
		
		
		<dl><dt>备注: </dt>
		<dd><textarea style="height:55px;overflow-y:scroll;width:355px;border:1px solid #649776" name="data[Store][remark]" ><?php echo $stores_info['Store']['remark']; ?></textarea></dd></dl>
		<dl><dt>是否有效: </dt>
		<dd><input type="radio" value="1" name="data[Store][status]" <?php if($stores_info['Store']['status'] == 1){ echo "checked"; } ?>/>是 <input type="radio" name="data[Store][status]" value="0" <?php if($stores_info['Store']['status'] == 0){ echo "checked"; } ?>/>否</dd></dl>
		<dl><dt>排序: </dt>
		<dd><input type="text" style="width:113px;border:1px solid #649776" name="data[Store][orderby]" value="<?php echo $stores_info['Store']['orderby']; ?>" onkeyup="check_input_num(this)" /><p class="msg">如果您不输入排序号，系统将默认为50</p></dd></dl>
		<dl><dt style="padding-top:0">添加时间: </dt>
		<dd><?php echo $stores_info['Store']['created']; ?></dd></dl>
		<dl><dt style="padding-top:0">最后修改时间: </dt>
		<dd><?php echo $stores_info['Store']['modified']; ?></dd></dl>
		</div>
<!--Menus_Config End-->
	  </div>
	  
	</div>	
	</td>
</tr>
</table>
		
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  店铺描述</h1></div>
	  <div class="box">
	     <?php if($SVConfigs["select_editor"]=="2"||empty($SVConfigs["select_editor"])){?>
	  	<?php echo $javascript->link('tinymce/tiny_mce/tiny_mce'); ?>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<table><tr><td valign="top">
	  	<?php echo $html->image($v['Language']['img01'])?></td><td valign="top">
		<textarea id="1elm<?php echo $v['Language']['locale'];?>" name="data[StoreI18n][<?php echo $k;?>][description]" rows="15" cols="80" style="width: 80%"><?php if(isset($stores_info['StoreI18n'][$v['Language']['locale']])){?><?php echo  $stores_info['StoreI18n'][$v['Language']['locale']]['description'];?><?php }else{?><?php }?></textarea>
		<?php  echo $tinymce->load("1elm".$v['Language']['locale'],$now_locale); ?><br /></td></tr>
		</table>
    	<?php }?></p>
		<?php }?><?php }?>
		<?php if($SVConfigs["select_editor"]=="1"){?>
			<?php echo $javascript->link('fckeditor/fckeditor'); ?>
		  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		  	<?php echo $html->image($v['Language']['img01'])?><br />
			<p class="profiles">
			<?php  if(isset($article['BrandI18n'][$k]['description'])){?>
	        <?php echo $form->textarea('ArticleI18n/content', array("cols" => "60","rows" => "20",'value'=>"{$stores_info['StoreI18n'][$v['Language']['locale']]['description']}","name"=>"data[StoreI18n][{$k}][description]","id"=>"ArticleI118n{$k}Content"));?>
	        <?php echo $fck->load("ArticleI118n{$k}/content"); ?>
	        
	    	<?php }else{?>
	       	<?php echo $form->textarea('ArticleI18n/content', array('cols' => '60', 'rows' => '20','value'=>"{$stores_info['StoreI18n'][$v['Language']['locale']]['description']}","name"=>"data[StoreI18n][{$k}][description]","id"=>"ArticleI118n{$k}Content"));?> 
	       	<?php echo $fck->load("ArticleI118n{$k}/content"); ?>
	    	<?php }?>
		    </p>
			<br /><br />
			<?php }}?>
		<?php }?>
		</div></div>

<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>


<?php echo $form->end();?>
<!--ConfigValues End-->


</div>
<!--Main End-->
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
