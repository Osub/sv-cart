<?php 
/*****************************************************************************
 * SV-Cart 编辑专题
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 2989 2009-07-17 02:03:04Z huangbo $
  *****************************************************************************/
?>


<?php echo $javascript->link('selectzone');?>
<?php echo $javascript->link('product');?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."专题列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>
<div class="home_main">

<!--Main Start-->
<?php echo $form->create('Topic',array('action'=>'/edit/'.$topic['Topic']['id'],'onsubmit'=>'return topics_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑专题</h1></div>
	  <div class="box">
	  <input type="hidden" name="data[Topic][id]" value="<?php echo $topic['Topic']['id'];?>" />
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
	  	
		
		<h2>专题名称：</h2>
<?php if(isset($languages) && sizeof($languages) > 0){
    foreach($languages as $k => $v){
?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input type="text" style="width:360px;" id="topic_title_<?php echo $v['Language']['locale']?>" name="data[TopicI18n][<?php echo $k;?>][title]" value="<?php echo @$topic['TopicI18n'][$k]['title']?>" /> <font color="#ff0000">*</font></span></p>
		
<?php }
}
?>		
   		<h2>SEO分类关键字：</h2>
<?php if(isset($languages) && sizeof($languages) > 0){
    foreach($languages as $k => $v){
?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input type="text" style="width:360px;" id="meta_keywords_<?php echo $v['Language']['locale']?>" name="data[TopicI18n][<?php echo $k;?>][meta_keywords]" value="<?php echo @$topic['TopicI18n'][$k]['meta_keywords']?>"  /> <font color="#ff0000">*</font></span></p>
		
<?php }
}
?>
   		<h2>SEO分类描述：</h2>
<?php if(isset($languages) && sizeof($languages) > 0){
    foreach($languages as $k => $v){
?>
		<p class="products_name"><?php echo $html->image($v['Language']['img01'])?><span><input type="text" style="width:360px;" id="meta_description_<?php echo $v['Language']['locale']?>" name="data[TopicI18n][<?php echo $k;?>][meta_description]" value="<?php echo @$topic['TopicI18n'][$k]['meta_description']?>" /> <font color="#ff0000">*</font></span></p>
		
<?php }
}
?>		
<?php if(isset($languages) && sizeof($languages) > 0){
    foreach($languages as $k => $v){
?>
	<input id="TopicI18n<?php echo $k;?>Locale" name="data[TopicI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo @$v['Language']['locale'];?>">
	   <?php if(isset($topic['TopicI18n'][$v['Language']['locale']])){?>
	<input id="TopicI18n<?php echo $k;?>Id" name="data[TopicI18n][<?php echo $k;?>][id]" type="hidden" value="<?php echo @$topic['TopicI18n'][$v['Language']['locale']]['id'];?>">
	<input id="TopicI18n<?php echo $k;?>TopicId" name="data[TopicI18n][<?php echo $k;?>][topic_id]" type="hidden" value="<?php echo @$topic['Topic']['id'];?>">
	   <?php }?>
<?php }
}
?>


   <dl><dt style="width:105px;padding-top:8px;">活动周期: </dt>
		
		<dd>
		<input type="text" name="data[Topic][start_time]" class="text_inputs" style="width:120px;"  value="<?php echo date('Y-m-d',strtotime($topic['Topic']['start_time']))?>"   id="date" readonly="readonly" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>－<input type="text" name="data[Topic][end_time]" class="text_inputs" style="width:120px;"   value="<?php echo date('Y-m-d',strtotime($topic['Topic']['end_time']))?>" id="date2" readonly="readonly"  /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
		</dd>
	</dl>
		
		
		<dl>
			<dt style="width:105px;"><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text1')"))?>专题模板文件: </dt>
		<dd style="padding-top:3px;"><input type="text" style="width:357px;border:1px solid #649776" name="data[Topic][template]" value="<?php echo $topic['Topic']['template']?>"  />
			<p class="msg" style="display:none" id="help_text1">填写当前专题的模板文件名,模板文件应上传到当前商城模板目录下,不填写将调用默认模板。</p></dd>
		</dl>
			
			
			
		<dl><dt style="width:105px;"><?php echo $html->image('help_icon.gif',array('align'=>'absmiddle',"onclick"=>"help_show_or_hide('help_text2')"))?>专题样式列表: </dt>
		<dd><textarea style="width:360px;height:135px;" name="data[Topic][css]"><?php echo $topic['Topic']['css'];?></textarea><br/><span style="display:none" id="help_text2">填写当前专题的CSS样式代码，不填写将调用模板默认CSS文件<br />[+][-]</span></dd></dl>
		
		</div>
<!--Mailtemplates_Config End-->
		
	  </div>
	</div>

<!--Main End-->

<!--profile-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  专题介绍</h1></div>
	  <div class="box">
	

<?php echo $javascript->link('fckeditor/fckeditor'); ?>

<?php if(isset($languages) && sizeof($languages) > 0){
    foreach($languages as $k => $v){
?>
	  <?php echo $html->image($v['Language']['img01'])?><br />
<p class="profiles">
    <?php  if(isset($topic['TopicI18n'][$k]['intro'])){?>
       <?php echo $form->textarea('TopicI18n/intro', array("cols" => "60","rows" => "20","value" => "{$topic['TopicI18n'][$k]['intro']}","name"=>"data[TopicI18n][{$k}][intro]","id"=>"TopicI18n{$k}Intro"));?>
        <?php echo $fck->load("TopicI18n{$k}/intro"); ?>

    <?php }else{?>
       <?php echo $form->textarea('TopicI18n/intro', array('cols' => '60', 'rows' => '20','value'=>"","name"=>"data[TopicI18n][{$k}][intro]","id"=>"TopicI18n{$k}Intro"));?>
       <?php  echo $fck->load("TopicI18n{$k}/intro"); ?>

    <?php }?>
	
		</p>
		<br /><br />
<?php }}?>




		<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
		
<?php echo $form->end();?>
	
	  </div>
	  	  <!--Product Relative-->
<input type="hidden" id="products_id" value="">
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  <span>关联商品</span></h1></div>
	  <div class="box">
<?php echo $form->create('',array('action'=>'','name'=>"linkForm","type"=>"get","id"=>"linkForm"));?>

		<p class="select_cat">
		<?php echo $html->image('serach_icon.gif',array('align'=>'absmiddle'))?>
		<select name="category_id" id="category_id"  style="width:120px;" >
		<option value="0">所有分类</option>
		<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
<option value="<?php echo $first_v['Category']['id'];?>" ><?php echo $first_v['CategoryI18n']['name'];?></option>
<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?php echo $second_v['Category']['id'];?>" >&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?php echo $third_v['Category']['id'];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
<?php }}}}}}?>
		</select>
			<select id="brand_id" name="brand_id"  style="width:120px;" >
	      <option value="0">所有品牌</option>
	      		<?php if(isset($brands_tree) && sizeof($brands_tree)>0){?>
	    <?php foreach($brands_tree as $k=>$v){?>
	         <option value="<?php echo $v['Brand']['id']?>"  ><?php echo $v['BrandI18n']['name']?></option>
	    <?php }}?>
	</select>
		<input type="text" class="text_input" name="keywords" id="keywords"/>
		<input type="button" value="搜 索" class="search" onclick="searchProducts();"/></p>
		<table width="100%" class="relative_product">
			<tr>
				<td valign="top" width="40%">
				<p><strong>可选商品</strong></p>
				<p><select name="source_select1" id="source_select1" size="20" style="width:100%" ondblclick="add_relation_product('insert_link_topic_products',<?php echo $topic['Topic']['id']?>,this,'T');"multiple="true"></select></p>
				</td>
				<td valign="top" width="12%" align="center">
				<p><strong>操作</strong></p>
				<p class="direction" style="visibility:hidden">
				<input type="button" value=">" onclick="product_additem(document.getElementById('source_select1'),'insert_link_topic_products', <?php echo $topic['Topic']['id']?>);"/><br /><br />
				</p>				
				<p class="direction" style="visibility:hidden">
				<input type="button" value=">" onclick="product_additem(document.getElementById('source_select1'),'insert_link_topic_products', <?php echo $topic['Topic']['id']?>);"/><br /><br />
				</p>				
				<p class="direction">
				<input type="button" value=">" onclick="add_relation_product('insert_link_topic_products',<?php echo $topic['Topic']['id']?>,document.getElementById('source_select1'),'T');"/><br /><br />
				</p>				
				</td>
				<td valign="top" width="40%">
				<p><strong>跟该专题关联的商品</strong></p>
				<div class="relativies_box">
				<div id="target_select1">
                      <?php if(isset($topicproduct) && sizeof($topicproduct)>0)foreach($topicproduct as $k=>$v){?>
                             <?php if (isset($v['Product'])){?>
                           <p class="rel_list">
                           <span class="handle">
排序:<input size="2" value="<?php echo $v['TopicProduct']['orderby']?>" onblur="update_orderby(<?php echo $v['TopicProduct']['id']?>,this.value,'T');">
                           <?php echo $html->image('delete1.gif',array('align'=>'absmiddle',"onMouseout"=>"onMouseout_deleteimg(this)","onmouseover"=>"onmouseover_deleteimg(this)","onclick"=>"drop_relation_product('drop_link_topic_products',".$topic['Topic']['id'].",".$v['TopicProduct']['product_id'].",'T');"));?></span><?php echo $v['Product']['name']?>
</p>
                            <?php }?>
                      <?php }?>
                      </div>
               </div></td>
			</tr>
		</table>
	  </div>
	</div>
<!--Product Relative End-->

	</div>
<!--profile End-->






</div>
<!--Main Start End-->
</div><!--时间控件层start-->
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