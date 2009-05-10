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
 * $Id: edit.ctp 1144 2009-04-29 11:41:30Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<?=$javascript->link('selectzone');?>
<?=$javascript->link('product');?>


<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."专题列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>
<div class="home_main">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Main Start-->
<br />

<?php echo $form->create('Topic',array('action'=>'/edit/'.$topic['Topic']['id'],'onsubmit'=>'return topics_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑专题</h1></div>
	  <div class="box">
	  <input type="hidden" name="data[Topic][id]" value="<?=$topic['Topic']['id'];?>" />
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
	  	
		
		<h2>专题名称：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input type="text" style="width:360px;" id="topic_title_<?=$v['Language']['locale']?>" name="data[TopicI18n][<?=$k;?>][title]" value="<?=@$topic['TopicI18n'][$k]['title']?>" /> <font color="#ff0000">*</font></span></p>
		
<?	}
   } ?>		

<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="TopicI18n<?=$k;?>Locale" name="data[TopicI18n][<?=$k;?>][locale]" type="hidden" value="<?=@$v['Language']['locale'];?>">
	   <?if(isset($topic['TopicI18n'][$v['Language']['locale']])){?>
	<input id="TopicI18n<?=$k;?>Id" name="data[TopicI18n][<?=$k;?>][id]" type="hidden" value="<?=@$topic['TopicI18n'][$v['Language']['locale']]['id'];?>">
	<input id="TopicI18n<?=$k;?>TopicId" name="data[TopicI18n][<?=$k;?>][topic_id]" type="hidden" value="<?=@$topic['Topic']['id'];?>">
	   <?}?>
<?
	}
}?>


   <dl><dt style="width:105px;">活动周期: </dt>
		<span class="search_box"  style="background:none;padding:0;border:0;width:1px;" >
			<dd><input type="text" name="data[Topic][start_time]" class="text_inputs" style="width:120px;"  value="<?=$topic['Topic']['start_time']?>"   id="date" readonly="readonly" /><button id="show" type="button"><?=$html->image('calendar.gif')?></button>－<input type="text" name="data[Topic][end_time]" class="text_inputs" style="width:120px;"   value="<?=$topic['Topic']['end_time']?>" id="date2" readonly="readonly"  /><button id="show2" type="button"><?=$html->image('calendar.gif')?></button></dd></span></dl>
		
		
		<dl><dt style="width:105px;"><?=$html->image('help_icon.gif')?>专题模板文件: </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[Topic][template]" value="<?=$topic['Topic']['template']?>"  /><br/>填写当前专题的模板文件名,模板文件应上传到当前商城模板目录下,不填写将调用默认模板。</dd></dl>
			
			
			
		<dl><dt style="width:105px;"><?=$html->image('help_icon.gif')?>专题样式列表: </dt>
		<dd><textarea style="width:360px;height:135px;" name="data[Topic][css]"><?=$topic['Topic']['css'];?></textarea><br/>填写当前专题的CSS样式代码，不填写将调用模板默认CSS文件<br />[+][-]</dd></dl>
		
		
		<br />
		
		</div>
<!--Mailtemplates_Config End-->
		
		
		
	  </div>
	  <p class="submit_values"><input type="submit" value="确 定" /><input type="reset" value="重 置" /></p>
	</div>




<!--Main End-->
</td>
</tr>

</table>

<!--Product Relative-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  <span>关联商品</span></h1></div>
	  <div class="box">
<?php echo $form->create('',array('action'=>'','name'=>"linkForm","type"=>"get","id"=>"linkForm"));?>

		<p class="select_cat">
		<?=$html->image('serach_icon.gif',array('align'=>'absmiddle'))?>
		<select name="category_id" id="category_id">
		<option value="0">所有分类</option>
		<?if(isset($categories_tree) && sizeof($categories_tree)>0){?><?foreach($categories_tree as $first_k=>$first_v){?>
<option value="<?=$first_v['Category']['id'];?>" ><?=$first_v['CategoryI18n']['name'];?></option>
<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?=$second_v['Category']['id'];?>" >&nbsp;&nbsp;<?=$second_v['CategoryI18n']['name'];?></option>
<?if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?=$third_v['Category']['id'];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?=$third_v['CategoryI18n']['name'];?></option>
<?}}}}}}?>
		</select>

			<select id="brand_id" name="brand_id">
	      <option value="0">所有品牌</option>
	      		<?if(isset($brands_tree) && sizeof($brands_tree)>0){?>
	    <?foreach($brands_tree as $k=>$v){?>
	         <option value="<?echo $v['Brand']['id']?>"  ><?echo $v['BrandI18n']['name']?></option>
	    <?}}?>
	</select>
		<input type="text" class="text_input" name="keywords" id="keywords"/>
		<input type="button" value="搜 索" class="search" onclick="searchProducts();"/></p>
		<table width="100%" class="relative_product">
			<tr>
				<td valign="top" width="40%">
				<p><strong>可选商品</strong></p>
				<p><select name="source_select1" id="source_select1" size="20" style="width:100%" ondblclick="addItem1(this,'insert_link_topic_products', <?=$topic['Topic']['id']?>, this.form.elements['is_single'][0].checked,'P');"multiple="true"></p>
				</td>
				<td valign="top" width="12%" align="center">
				<p><strong>操作</strong></p>
				<p class="relative_radio" style="visibility :hidden">
				<label><input type="radio" name="is_single" id="is_single" value="1" checked/>单向关联</label><br />
				<label><input type="radio"  name="is_single" id="is_single" value="0"/>双向关联</label></p>
				<p class="direction">
				<input type="button" value=">" onclick="addItem1(this,'insert_link_topic_products', <?=$topic['Topic']['id']?>, this.form.elements['is_single'][0].checked,'P');"/><br /><br />
				</p>
				</td>
				<td valign="top" width="40%">
				<p><strong>跟该商品关联的商品</strong></p>
				<div class="relativies_box">
				<div id="target_select1">
                      <?if(isset($topicproduct) && sizeof($topicproduct)>0)foreach($topicproduct as $k=>$v){?>
                             <?if (isset($v['Product'])){?>
                           <p class="rel_list">
                           <span class="handle">
                           <input size="2" value="<?echo $v['TopicProduct']['orderby']?>" onblur="update_orderby(<?echo $v['TopicProduct']['id']?>,this.value,'P');">
                           <input type="button" value="删除" onclick="dropItem1(<?echo $v['TopicProduct']['product_id']?>,'drop_link_topic_products', <?=$topic['Topic']['id']?>,'P');"/></span><?echo $v['Product']['name']?>
</p>
                            <?}?>
                      <?}?>
                      </div>
               </div></td>
			</tr>
		</table>
		
	<!--	<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>-->

	  </div>
	</div>
<!--Product Relative End-->
<!--profile-->
	<div class="order_stat properies">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  专题介绍</h1></div>
	  <div class="box">
	  

<?php echo $javascript->link('fckeditor/fckeditor'); ?>

<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	  <?=$html->image($v['Language']['img01'])?><br />
<p class="profiles">
    <?  if(isset($topic['TopicI18n'][$k]['intro'])){?>
       <?php echo $form->textarea('TopicI18n/intro', array("cols" => "60","rows" => "20","value" => "{$topic['TopicI18n'][$k]['intro']}","name"=>"data[TopicI18n][{$k}][intro]","id"=>"TopicI18n{$k}Intro"));?>
        <? echo $fck->load("TopicI18n{$k}/intro"); ?>
        
    <?}else{?>
       <?php echo $form->textarea('TopicI18n/intro', array('cols' => '60', 'rows' => '20','value'=>"","name"=>"data[TopicI18n][{$k}][intro]","id"=>"TopicI18n{$k}Intro"));?> 
       <?php  echo $fck->load("TopicI18n{$k}/intro"); ?>
       
    <?}?>
	    
		</p>
		<br /><br />
<?
	}
}?>




		<p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
		
<? echo $form->end();?>
	  </div>
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