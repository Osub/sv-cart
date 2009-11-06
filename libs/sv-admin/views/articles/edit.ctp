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
 * $Id: edit.ctp 5425 2009-10-26 05:25:54Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php  echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<?php echo $javascript->link('selectzone');?>
<?php echo $javascript->link('product');?>
<?php echo $javascript->link('utils');?>	
<?php echo $javascript->link('listtable');?>	
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."文章列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>
<!--Main Start-->
<?php echo $form->create('Articles',array('action'=>'edit/'.$article['Article']['id'],'onsubmit'=>'return articles_check();'));?>
<div class="home_main">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos configvalues">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  通用信息</h1></div><input  name="data[Article][id]" type="hidden" value="<?php echo  $article['Article']['id'];?>">
	  <div class="box"><br />
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<input name="data[ArticleI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
		<?php }}?>		
		<dl><dt>文章标题: </dt><dd></dd></dl>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input id="article_name_<?php echo $v['Language']['locale']?>"  name="data[ArticleI18n][<?php echo $k;?>][title]" type="text" style="width:280px;border:1px solid #649776" <?php if(isset($article['ArticleI18n'][$v['Language']['locale']])){?>value="<?php echo  $article['ArticleI18n'][$v['Language']['locale']]['title'];?>"<?php }else{?>value=""<?php }?>/ > <font color="#ff0000">*</font></dd></dl>
		<?php }}?>
		<input id="products_id" type="hidden" value="0">
		<dl><dt>文章作者: </dt><dd></dd></dl>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input id="" name="data[ArticleI18n][<?php echo $k;?>][author]" type="text" style="width:280px;border:1px solid #649776" <?php if(isset($article['ArticleI18n'][$v['Language']['locale']])){?>value="<?php echo  $article['ArticleI18n'][$v['Language']['locale']]['author'];?>"<?php }else{?>value=""<?php }?>/></dd></dl>
		<?php }}?>	
	

	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<input id="ArticleI18n<?php echo $k;?>Locale" name="data[ArticleI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
	   		<?php if(isset($article['ArticleI18n'][$v['Language']['locale']])){?>
				<input id="ArticleI18n<?php echo $k;?>Id" name="data[ArticleI18n][<?php echo $k;?>][id]" type="hidden" value="<?php echo  $article['ArticleI18n'][$v['Language']['locale']]['id'];?>">
	   		<?php }?>
	   		<input id="ArticleI18n<?php echo $k;?>ArticleId" name="data[ArticleI18n][<?php echo $k;?>][article_id]" type="hidden" value="<?php echo  $article['Article']['id'];?>">
		<?php }}?>


		<dl><dt>关键字: </dt><dd></dd></dl>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input   style="width:180px;border:1px solid #649776" id="articlei18nmeta_keywords<?php echo $v['Language']['locale'];?>" name="data[ArticleI18n][<?php echo $k;?>][meta_keywords]" type="text" style="width:260px;" <?php if(isset($article['ArticleI18n'][$v['Language']['locale']])){?>value="<?php echo  $article['ArticleI18n'][$v['Language']['locale']]['meta_keywords'];?>"<?php }else{?>value=""<?php }?>/>
			<select style="width:90px;border:1px solid #649776" onchange="add_to_seokeyword(this,'articlei18nmeta_keywords<?php echo $v['Language']['locale'];?>')">
				<option value='常用关键字'>常用关键字</option>
				<?php foreach( $seokeyword_data as $sk=>$sv){?>
					<option value='<?php echo $sv["SeoKeyword"]["name"]?>'><?php echo $sv["SeoKeyword"]["name"]?></option>
				<?php }?>
			</select>

			</dd></dl>
		<?php }}?>
		
		<dl><dt>描述: </dt><dd></dd></dl>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
			<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><textarea id="" style="width:280px;border:1px solid #649776" name="data[ArticleI18n][<?php echo $k;?>][meta_description]" type="text" style="width:260px;" <?php if(isset($article['ArticleI18n'][$v['Language']['locale']])){?>><?php echo $article['ArticleI18n'][$v['Language']['locale']]['meta_description'];?><?php }else{?><?php }?></textarea></dd></dl>
		<?php }}?>	
		
		<dl><dt>上传文件: </dt><dd></dd></dl>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<dl><dt><?php echo $html->image($v['Language']['img01'])?></dt><dd><input type="text" style="width:280px;border:1px solid #649776" id="upload_img_text_<?php echo $k?>" name="data[ArticleI18n][<?php echo $k;?>][img01]" value="<?php if(isset($article['ArticleI18n'][$v['Language']['locale']]['img01'])){echo $article['ArticleI18n'][$v['Language']['locale']]['img01'];}?>"   />
			<?php echo @$html->link($html->image('select_img.gif',array("height"=>"20","class"=>"vmiddle icons","title"=>$title_arr['select_img'])),"javascript:img_sel($k,'articles')",'',false,false)?>
			<br />
			<?php echo @$html->image("/..{$article['ArticleI18n'][$v['Language']['locale']]['img01']}",array('id'=>'logo_thumb_img_'.$k,'style'=>!empty($article['ArticleI18n'][$v['Language']['locale']]['img01'])?"display:block":"display:none"))?>
		</dd></dl>
			<style>
			<!--
			#logo_thumb_img_<?php echo $k;?>{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;width:200px;height:100px;}
			-->
			</style>
		<?php }}?>
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;">
<!--Other Stat-->
	<div class="order_stat athe_infos configvalues">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  其他信息</h1></div>
	  <div class="box"><br />
	  	<dl><dt>文章分类：</dt><dd>
	  		<select class="all"  name="data[Article][category_id]" id="ArticlesCategory">
	<option value="0">所有分类</option>
<?php if(isset($categories_tree_A) && sizeof($categories_tree_A)>0){?><?php foreach($categories_tree_A as $first_k=>$first_v){?>
<option value="<?php echo $first_v['Category']['id'];?>" <?php if($article['Article']['category_id'] == $first_v['Category']['id']){ echo "selected";}?> ><?php echo $first_v['CategoryI18n']['name'];?></option>
<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?php echo $second_v['Category']['id'];?>" <?php if($article['Article']['category_id'] == $second_v['Category']['id']){ echo "selected";}?> >&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?php echo $third_v['Category']['id'];?>" <?php if($article['Article']['category_id'] == $third_v['Category']['id']){ echo "selected";}?> >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
<?php }}}}}}?>
	</select>
	</dd></dl>
	  	<dl><dt>扩展分类：</dt><dd><input type="button" value="添加" onclick="addOtherCat()">
	  <?php foreach( $category_arr as $k=>$v ){?>
	  			<select class="all"  name="article_categories_id[]" >
	<option value="0">所有分类</option>
<?php if(isset($categories_tree_A) && sizeof($categories_tree_A)>0){?><?php foreach($categories_tree_A as $first_k=>$first_v){?>
<option value="<?php echo $first_v['Category']['id'];?>" <?php if($v['ArticleCategorie']['category_id'] == $first_v['Category']['id']){ echo "selected";}?> ><?php echo $first_v['CategoryI18n']['name'];?></option>
<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?php echo $second_v['Category']['id'];?>" <?php if($v['ArticleCategorie']['category_id']== $second_v['Category']['id']){ echo "selected";}?> >&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?php echo $third_v['Category']['id'];?>" <?php if($v['ArticleCategorie']['category_id'] == $third_v['Category']['id']){ echo "selected";}?> >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
<?php }}}}}}?>
	</select><?php }?>	<div id="other_cats"></div>
	</dd></dl>
	  	<dl><dt>文章类型: </dt>
		<dd>
		<select name="data[Article][type]">
		<?php foreach( $systemresource_info["sub_type"] as $k=>$v ){?>
			<option value="<?php echo $k;?>" <?php if($article['Article']['type'] == $k){echo "selected";}?>><?php echo $v;?></option>
		<?php }?>
		</select>
		</dd>
		</dl>

		<dl style="padding:3px 0;*padding:4px 0;"><dt style="padding-top:1px">文章重要性：</dt><dd class="best_input"><input type="radio" name="data[Article][importance]" value="0" <?php if($article['Article']['importance'] == 0){echo "checked";} ?> />普通<input type="radio" name="data[Article][importance]" value="1" <?php if($article['Article']['importance'] == 1){echo "checked";} ?> />置顶 <font color="#ff0000">*</font></dd></dl>
		
		<dl><dt style="padding-top:0px">是否有效：</dt><dd class="best_input"><input type="radio" name="data[Article][status]" value="1" <?php if($article['Article']['status'] == 1){echo "checked";} ?> />是<input type="radio" name="data[Article][status]" value="0" <?php if($article['Article']['status'] != 1){echo "checked";} ?> />否 <font color="#ff0000">*</font></dd></dl>
		<dl><dt style="padding-top:0px">首页显示：</dt><dd class="best_input"><input type="radio" name="data[Article][front]" value="1" <?php if($article['Article']['front'] == 1){echo "checked";} ?> />显示<input type="radio" name="data[Article][front]" value="0" <?php if($article['Article']['front'] != 1){echo "checked";} ?> />不显示 <font color="#ff0000">*</font></dd></dl>
		<dl><dt style="padding-top:0px">是否推荐：</dt><dd class="best_input"><input type="radio" name="data[Article][recommand]" value="1" <?php if($article['Article']['recommand'] == 1){echo "checked";} ?> />是<input type="radio" name="data[Article][recommand]" value="0" <?php if($article['Article']['recommand'] != 1){echo "checked";} ?> />否 <font color="#ff0000">*</font></dd></dl>
		<dl><dt style="padding-top:0px">是否可评论：</dt><dd class="best_input"><input type="radio" name="data[Article][comment]" value="1" <?php if($article['Article']['comment'] == 1){echo "checked";} ?> />是<input type="radio" name="data[Article][comment]" value="0" <?php if($article['Article']['comment'] != 1){echo "checked";} ?> />否 <font color="#ff0000">*</font></dd></dl>
		<dl><dt>作者email：</dt><dd><input type="text" class="text_inputs" name="data[Article][author_email]" value="<?php echo $article['Article']['author_email']?>" style="width:204px;" /></dd></dl>
		
		
		<dl><dt>外部链接：</dt><dd><input type="text" class="text_inputs" name="data[Article][file_url]" value="<?php echo $article['Article']['file_url']?>" style="width:204px;" /></dd></dl>
		<dl><dt>排序：</dt><dd><input type="text" class="text_inputs" name="data[Article][orderby]" value="<?php echo $article['Article']['orderby']?>" style="width:108px;" onkeyup="check_input_num(this)" /><p class="msg">如果您不输入排序号，系统将默认为50</p></dd></dl>
		
	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>

</table>
<!--
<style type="text/css">
	.properies textarea *{
		font-size:200px;
	}
</style>-->
<!--profile-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  文章内容</h1></div>
	  <div class="box">
		<?php if($SVConfigs["select_editor"]=="2"||empty($SVConfigs["select_editor"])){?>
	  	<?php echo $javascript->link('tinymce/tiny_mce/tiny_mce'); ?>
	  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<table><tr><td valign="top">
	  	<?php echo $html->image($v['Language']['img01'])?></td><td valign="top">
		<textarea id="elm<?php echo $v['Language']['locale'];?>" name="data[ArticleI18n][<?php echo $k;?>][content]" rows="15" cols="80" style="width: 80%;"><?php echo $article['ArticleI18n'][$k]['content'];?></textarea>
		<?php  echo $tinymce->load("elm".$v['Language']['locale'],$now_locale); ?></td></tr>
		</table>
    	<?php }?></p>
		<?php }?>
		<?php }?>
		<?php if($SVConfigs["select_editor"]=="1"){?>
			<?php echo $javascript->link('fckeditor/fckeditor'); ?>
		  	<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		  	<?php echo $html->image($v['Language']['img01'])?><br />
			<p class="profiles">
			<?php  if(isset($article['ArticleI18n'][$k]['content'])){?>
	        <?php echo $form->textarea('ArticleI18n/content', array("cols" => "60","rows" => "20","value" => "{$article['ArticleI18n'][$k]['content']}","name"=>"data[ArticleI18n][{$k}][content]","id"=>"ArticleI18n{$k}Content"));?>
	        <?php echo $fck->load("ArticleI18n{$k}/content"); ?>
	        
	    	<?php }else{?>
	       	<?php echo $form->textarea('ArticleI18n/content', array('cols' => '60', 'rows' => '20','value'=>"","name"=>"data[ArticleI18n][{$k}][content]","id"=>"ArticleI18n{$k}Content"));?> 
	       	<?php echo $fck->load("ArticleI18n{$k}/content"); ?>
	    	<?php }?>
		    </p>
			<br /><br />
			<?php }}?>
		<?php }?>
		<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
		
<?php echo $form->end();?>
	  </div>
	</div>
<!--profile End-->


<!--Product Relative-->
<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  <span>关联商品</span></h1></div>
	  <div class="box">
<?php echo $form->create('',array('action'=>'','name'=>'linkForm','id'=>'linkForm'));?>

		<p class="select_cat">
		<?php echo $html->image('serach_icon.gif',array('align'=>'absmiddle'))?>
			<select class="all" name="category_id" id="category_id" >
	<option value="0">所有分类</option>
<?php if(isset($categories_tree_P) && sizeof($categories_tree_P)>0){?><?php foreach($categories_tree_P as $first_k=>$first_v){?>
<option value="<?php echo $first_v['Category']['id'];?>" ><?php echo $first_v['CategoryI18n']['name'];?></option>
<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?php echo $second_v['Category']['id'];?>" >&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?php echo $third_v['Category']['id'];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
<?php }}}}}}?>
	</select>
		<select name="brand_id" id="brand_id">
		<option value="0">所有品牌</option>
		<?php if(isset($brands_tree) && sizeof($brands_tree)>0){?>
		<?php foreach($brands_tree as $k=>$v){?>
		  <option value="<?php echo $v['Brand']['id']?>"><?php echo $v['Brand']['name']?></option>
		<?php }?>
		  <?php }?>
		</select>
		<input type="text" class="text_input" name="keywords" id="keywords"/>
		<input type="button" value="搜 索" class="search" onclick="searchProducts();"/></p>
		<table width="100%" class="relative_product">
			<tr>
				<td valign="top" width="40%">
				<p><strong>可选商品</strong></p>
				<p><select name="source_select1" id="source_select1" size="20" style="width:100%" ondblclick="add_relation_product('insert_link_article_products',<?php echo $article['Article']['id']?>,this,'A',this.form.elements['is_single'][0].checked);"multiple="true"></p>
				</td>
				<td valign="top" width="12%" align="center">
				<p><strong>操作</strong></p>
				<p class="relative_radio">
				<label><input type="radio" name="is_single" id="is_single" value="1" checked/>单向关联</label><br />
				<label><input type="radio"  name="is_single" id="is_single" value="0"/>双向关联</label></p>
				<p class="direction">
				<input type="button" value=">" onclick="add_relation_product('insert_link_article_products',<?php echo $article['Article']['id']?>,document.getElementById('source_select1'),'A',this.form.elements['is_single'][0].checked);"/>
				</p>
				</td>
				<td valign="top" width="40%">
				<p><strong>跟该文章关联的商品</strong></p>
				<div class="relativies_box">
				<div id="target_select1">
				<?php if(isset($articles_products) && sizeof($articles_products)>0){?>
                      <?php foreach($articles_products as $k=>$v){?>
                             <?php if (isset($v['Product'])){?>
                           <p class="rel_list">
                           <span class="handle">
                           
						   排序:<span onclick="javascript:listTable.edit(this, 'products/update_orderby/A/',<?php echo $v['ProductArticle']['id']?>)"><?php echo $v['ProductArticle']['orderby']?></span>
						   	  
                           <?php echo $html->image('delete1.gif',array('align'=>'absmiddle',"onMouseout"=>"onMouseout_deleteimg(this)","onmouseover"=>"onmouseover_deleteimg(this)","onclick"=>"drop_relation_product('drop_link_article_products',".$article['Article']['id'].",".$v['ProductArticle']['product_id'].",'A');"));?>
                           </span><?php echo $v['ProductI18n']['name']?>
							</p>
                            <?php }?>
                      <?php }?>
                      <?php }?>	  
                      	             
          
                      </div>   
               </div></td>
			</tr>
		</table>
<?php echo $form->end();?>
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
document.onmousemove=function(e)
{
  var obj = Utils.srcElement(e);
  if (typeof(obj.onclick) == 'function' && obj.onclick.toString().indexOf('listTable.edit') != -1)
  {
    obj.title = '点击修改内容';
    obj.style.cssText = 'background: #21964D;';
    obj.onmouseout = function(e)
    {
      this.style.cssText = '';
    }
  }
  else if (typeof(obj.href) != 'undefined' && obj.href.indexOf('listTable.sort') != -1)
  {
    obj.title = '点击对列表排序';
  }
}

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