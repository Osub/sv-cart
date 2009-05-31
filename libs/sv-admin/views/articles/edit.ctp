<?php
/*****************************************************************************
 * SV-Cart 编辑文章
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 1883 2009-05-31 11:20:54Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php  echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<?=$javascript->link('selectzone');?>
<?=$javascript->link('product');?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."文章列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>
<!--Main Start-->
<?php echo $form->create('Articles',array('action'=>'edit/'.$article['Article']['id'],'onsubmit'=>'return articles_check();'));?>
<div class="home_main">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  通用信息</h1></div><input  name="data[Article][id]" type="hidden" value="<?= $article['Article']['id'];?>">
	  <div class="box">
	  	<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input name="data[ArticleI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
<?
	}
}?>
  	    <h2>文章标题：</h2>
	  	<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="article_name_<?=$v['Language']['locale']?>"  name="data[ArticleI18n][<?=$k;?>][title]" type="text" style="width:215px;" <?if(isset($article['ArticleI18n'][$v['Language']['locale']])){?>value="<?= $article['ArticleI18n'][$v['Language']['locale']]['title'];?>"<?}else{?>value=""<?}?>/ > <font color="#ff0000">*</font></span></p>
<?
	}
}?>
<input id="products_id" type="hidden" value="0">

		<h2>文章作者：</h2> 
	  	<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="" name="data[ArticleI18n][<?=$k;?>][author]" type="text" style="width:260px;" <?if(isset($article['ArticleI18n'][$v['Language']['locale']])){?>value="<?= $article['ArticleI18n'][$v['Language']['locale']]['author'];?>"<?}else{?>value=""<?}?>/> </span></p>
<?
	}
}?>	
	

	  	<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="ArticleI18n<?=$k;?>Locale" name="data[ArticleI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
	   <?if(isset($article['ArticleI18n'][$v['Language']['locale']])){?>
	<input id="ArticleI18n<?=$k;?>Id" name="data[ArticleI18n][<?=$k;?>][id]" type="hidden" value="<?= $article['ArticleI18n'][$v['Language']['locale']]['id'];?>">
	   <?}?>
	   	<input id="ArticleI18n<?=$k;?>ArticleId" name="data[ArticleI18n][<?=$k;?>][article_id]" type="hidden" value="<?= $article['Article']['id'];?>">
<?
	}
}?>


		<h2>关键字：</h2>
	  	<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input id="" name="data[ArticleI18n][<?=$k;?>][meta_keywords]" type="text" style="width:260px;" <?if(isset($article['ArticleI18n'][$v['Language']['locale']])){?>value="<?= $article['ArticleI18n'][$v['Language']['locale']]['meta_keywords'];?>"<?}else{?>value=""<?}?>/> </p>
<?
	}
}?>		
		<h2>描述：</h2>
	  	<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea id="" name="data[ArticleI18n][<?=$k;?>][meta_description]" type="text" style="width:260px;" <?if(isset($article['ArticleI18n'][$v['Language']['locale']])){?>><?=$article['ArticleI18n'][$v['Language']['locale']]['meta_description'];?><?}else{?><?}?></textarea> </p>
<?
	}
}?>	
		
		<h2>上传文件：</h2>
	  	<? if(isset($languages) && sizeof($languages)>0){
		foreach ($languages as $k => $v){?>
		<p class="products_name">
			<?=$html->image($v['Language']['img01'])?>
			<span><input type="text" id="upload_img_text_<?=$k?>" name="data[ArticleI18n][<?=$k;?>][img01]" value="<? if(isset($article['ArticleI18n'][$v['Language']['locale']]['img01'])){echo $article['ArticleI18n'][$v['Language']['locale']]['img01'];}?>" style="width:260px;"  />
			<?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel($k,'articles')",'',false,false)?>
			</span><br />
			<?=@$html->image("/..{$article['ArticleI18n'][$v['Language']['locale']]['img01']}",array('id'=>'logo_thumb_img_'.$k,'height'=>'150','style'=>'display:none'))?>
			</p>
		<?}}?>
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;">
<!--Other Stat-->
	<div class="order_stat athe_infos tongxun articles_configs">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  其他信息</h1></div>
	  <div class="box">
	  	<dl><dt>文章分类：</dt><dd>

	  		<select class="all"  name="data[Article][category_id]">
	<option value="0">所有分类</option>
<?if(isset($categories_tree_A) && sizeof($categories_tree_A)>0){?><?foreach($categories_tree_A as $first_k=>$first_v){?>
<option value="<?=$first_v['Category']['id'];?>" <? if($article['Article']['category_id'] == $first_v['Category']['id']){ echo "selected";}?> ><?=$first_v['CategoryI18n']['name'];?></option>
<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?=$second_v['Category']['id'];?>" <? if($article['Article']['category_id'] == $second_v['Category']['id']){ echo "selected";}?> >&nbsp;&nbsp;<?=$second_v['CategoryI18n']['name'];?></option>
<?if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?=$third_v['Category']['id'];?>" <? if($article['Article']['category_id'] == $third_v['Category']['id']){ echo "selected";}?> >&nbsp;&nbsp;&nbsp;&nbsp;<?=$third_v['CategoryI18n']['name'];?></option>
<?}}}}}}?>
	</select>
	</dd></dl>
	  	<dl><dt>扩展分类：</dt><dd><input type="button" value="添加" onclick="addOtherCat()">
	  <?foreach( $category_arr as $k=>$v ){?>
	  			<select class="all"  name="article_categories_id[]" id="ArticlesCategory">
	<option value="0">所有分类</option>
<?if(isset($categories_tree_A) && sizeof($categories_tree_A)>0){?><?foreach($categories_tree_A as $first_k=>$first_v){?>
<option value="<?=$first_v['Category']['id'];?>" <? if($v['ArticleCategorie']['category_id'] == $first_v['Category']['id']){ echo "selected";}?> ><?=$first_v['CategoryI18n']['name'];?></option>
<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?=$second_v['Category']['id'];?>" <? if($v['ArticleCategorie']['category_id']== $second_v['Category']['id']){ echo "selected";}?> >&nbsp;&nbsp;<?=$second_v['CategoryI18n']['name'];?></option>
<?if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?=$third_v['Category']['id'];?>" <? if($v['ArticleCategorie']['category_id'] == $third_v['Category']['id']){ echo "selected";}?> >&nbsp;&nbsp;&nbsp;&nbsp;<?=$third_v['CategoryI18n']['name'];?></option>
<?}}}}}}?>
	</select><?}?>	<div id="other_cats"></div>
	</dd></dl>
	
		<dl><dt>文章类型：</dt><dd><input type="text" class="text_inputs" name="data[Article][type]" value="<?=$article['Article']['type']?>" style="width:204px;" /></dd></dl>
		
		<dl style="padding:3px 0;*padding:4px 0;"><dt style="padding-top:1px">文章重要性：</dt><dd class="best_input"><input type="radio" name="data[Article][importance]" value="0" <? if($article['Article']['importance'] == 0){echo "checked";} ?> />普通<input type="radio" name="data[Article][importance]" value="1" <? if($article['Article']['importance'] == 1){echo "checked";} ?> />置顶 <font color="#ff0000">*</font></dd></dl>
		
		<dl><dt style="padding-top:0px">是否显示：</dt><dd class="best_input"><input type="radio" name="data[Article][status]" value="1" <? if($article['Article']['status'] == 1){echo "checked";} ?> />显示<input type="radio" name="data[Article][status]" value="0" <? if($article['Article']['status'] != 1){echo "checked";} ?> />不显示 <font color="#ff0000">*</font></dd></dl>
		<dl><dt style="padding-top:0px">首页是否显示：</dt><dd class="best_input"><input type="radio" name="data[Article][front]" value="1" <? if($article['Article']['front'] == 1){echo "checked";} ?> />显示<input type="radio" name="data[Article][front]" value="0" <? if($article['Article']['front'] != 1){echo "checked";} ?> />不显示 <font color="#ff0000">*</font></dd></dl>
		
		<dl><dt>作者email：</dt><dd><input type="text" class="text_inputs" name="data[Article][author_email]" value="<?=$article['Article']['author_email']?>" style="width:204px;" /></dd></dl>
		
		
		<dl><dt>外部链接：</dt><dd><input type="text" class="text_inputs" name="data[Article][file_url]" value="<?=$article['Article']['file_url']?>" style="width:204px;" /></dd></dl>
		<dl><dt>排序：</dt><dd><input type="text" class="text_inputs" name="data[Article][orderby]" value="<?=$article['Article']['orderby']?>" style="width:204px;" onkeyup="check_input_num(this)" /><br />如果您不输入排序号，系统将默认为50</dd></dl>
		
		<br /><br /><br /><br /><br /><br /><br /><br />
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
	  文章内容</h1></div>
	  <div class="box">
	  

	  <?php echo $javascript->link('fckeditor/fckeditor'); ?>
	  	<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	  <?=$html->image($v['Language']['img01'])?><br />
<p class="profiles">
    <?  if(isset($article['ArticleI18n'][$k]['content'])){?>
       <?php echo $form->textarea('ArticleI18n/content', array("cols" => "60","rows" => "20","value" => "{$article['ArticleI18n'][$k]['content']}","name"=>"data[ArticleI18n][{$k}][content]","id"=>"ArticleI18n{$k}Content"));?>
        <? echo $fck->load("ArticleI18n{$k}/content"); ?>
        
    <?}else{?>
       <?php echo $form->textarea('ArticleI18n/content', array('cols' => '60', 'rows' => '20','value'=>"","name"=>"data[ArticleI18n][{$k}][content]","id"=>"ArticleI18n{$k}Content"));?> 
       <?php  echo $fck->load("ArticleI18n{$k}/content"); ?>
       
    <?}?>
	    
		</p>
		<br /><br />
<?
	}
}?>
	  		
		
		<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
		

	  </div>
	</div>
<!--profile End-->


<!--Product Relative-->
<div class="order_stat properies">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  <span>关联商品</span></h1></div>
	  <div class="box">
<?php echo $form->create('',array('action'=>'','name'=>'linkForm','id'=>'linkForm'));?>

		<p class="select_cat">
		<?=$html->image('serach_icon.gif',array('align'=>'absmiddle'))?>
			<select class="all" name="category_id" id="category_id" >
	<option value="0">所有分类</option>
<?if(isset($categories_tree_P) && sizeof($categories_tree_P)>0){?><?foreach($categories_tree_P as $first_k=>$first_v){?>
<option value="<?=$first_v['Category']['id'];?>" ><?=$first_v['CategoryI18n']['name'];?></option>
<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?=$second_v['Category']['id'];?>" >&nbsp;&nbsp;<?=$second_v['CategoryI18n']['name'];?></option>
<?if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?=$third_v['Category']['id'];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?=$third_v['CategoryI18n']['name'];?></option>
<?}}}}}}?>
	</select>
		<select name="brand_id" id="brand_id">
		<option value="0">所有品牌</option>
		<?if(isset($brands_tree) && sizeof($brands_tree)>0){?>
		<?foreach($brands_tree as $k=>$v){?>
		  <option value="<?echo $v['Brand']['id']?>"><?echo $v['Brand']['name']?></option>
		<?}?>
		  <?}?>
		</select>
		<input type="text" class="text_input" name="keywords" id="keywords"/>
		<input type="button" value="搜 索" class="search" onclick="searchProducts();"/></p>
		<table width="100%" class="relative_product">
			<tr>
				<td valign="top" width="40%">
				<p><strong>可选商品</strong></p>
				<p><select name="source_select1" id="source_select1" size="20" style="width:100%" ondblclick="addItem1(this,'insert_link_article_products', <?=$article['Article']['id']?>, this.form.elements['is_single'][0].checked,'A');"multiple="true"></p>
				</td>
				<td valign="top" width="12%" align="center">
				<p><strong>操作</strong></p>
				<p class="relative_radio">
				<label><input type="radio" name="is_single" id="is_single" value="1" checked/>单向关联</label><br />
				<label><input type="radio"  name="is_single" id="is_single" value="0"/>双向关联</label></p>
				<p class="direction">
				<input type="button" value=">" onclick="addItem1(this.form.elements['source_select1'],'insert_link_products', <?=$this->data['Product']['id']?>, this.form.elements['is_single'][0].checked,'P');"/><br /><br />
				</p>
				</td>
				<td valign="top" width="40%">
				<p><strong>跟该商品关联的商品</strong></p>
				<div class="relativies_box">
				<div id="target_select1">
				<?if(isset($articles_products) && sizeof($articles_products)>0){?>
                      <?foreach($articles_products as $k=>$v){?>
                             <?if (isset($v['Product'])){?>
                           <p class="rel_list">
                           <span class="handle">
                           <input size="2" value="<?echo $v['ProductArticle']['orderby']?>" onblur="update_orderby(<?echo $v['ProductArticle']['id']?>,this.value,'P');">
                           <input type="button" value="删除" onclick="dropItem1(<?echo $v['ProductArticle']['product_id']?>,'drop_link_article_products', <?=$article['Article']['id']?>,'A');"/></span><?echo $v['ProductI18n']['name']?>
</p>
                            <?}?>
                      <?}?>
                      <?}?>	  
                      	             
          
                      </div>   
               </div></td>
			</tr>
		</table>
<? echo $form->end();?>
	  </div>
	</div> <p class="rel_list">

<!--Product Relative End-->


</div>
<!--Main Start End-->
</div>
<script>
function addOtherCat(){
     var sel = document.createElement("SELECT");
      var selCat = document.getElementById('ArticlesCategory');

      for (i = 0; i < selCat.length; i++)
      {
          var opt = document.createElement("OPTION");
          opt.text = selCat.options[i].text;
          opt.value = selCat.options[i].value;
          if (Browser.isIE)
          {
              sel.add(opt);
          }
          else
          {
              sel.appendChild(opt);
          }
      }
      var conObj=document.getElementById('other_cats');
      conObj.appendChild(sel);
      sel.name = "article_categories_id[]";
      sel.onChange = function() {checkIsLeaf(this);};
  }
</script>