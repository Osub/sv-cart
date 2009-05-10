<?php
/*****************************************************************************
 * SV-Cart 文章管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 943 2009-04-23 10:38:44Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<?=$javascript->link('listtable');?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>

<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'','name'=>'ArticleForm','type'=>'get'));?>
	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">

	  			<select class="all" name="article_cat" id="article_cat" >
	<option value="0">所有分类</option>
<?if(isset($categories_tree) && sizeof($categories_tree)>0){?><?foreach($categories_tree as $first_k=>$first_v){?>
<option value="<?=$first_v['Category']['id'];?>" <?if($article_cats == $first_v['Category']['id'] ){echo "selected";}?> ><?=$first_v['CategoryI18n']['name'];?></option>
<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?=$second_v['Category']['id'];?>" <?if($article_cats == $second_v['Category']['id'] ){echo "selected";}?> >&nbsp;&nbsp;<?=$second_v['CategoryI18n']['name'];?></option>
<?if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?=$third_v['Category']['id'];?>" <?if($article_cats == $third_v['Category']['id'] ){echo "selected";}?> >&nbsp;&nbsp;&nbsp;&nbsp;<?=$third_v['CategoryI18n']['name'];?></option>
<?}}}}}}?>
	</select>
&nbsp;&nbsp;
	文章标题：<input type="text" class="name" name="title" value="<?=@$titles?>"/>&nbsp;&nbsp;
	发布时间：<input type="text" name="start_time" class="time" id="date" readonly="readonly"value="<?=@$start_time?>" /><button id="show" type="button"><?=$html->image('calendar.gif')?></button>－
	<input type="text" name="end_time" class="time" id="date2" readonly="readonly" value="<?=@$end_time?>" /><button id="show2" type="button"><?=$html->image('calendar.gif')?></button></p></dd>
	<dt class="small_search"><input type="submit" onclick="search_article()" value="搜索" class="search_article"  /></dt>
	</dl>

</div>
<br /><br />
<!--Search End-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增文章","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">


	<ul class="product_llist articles_type">
	<li class="number"><label><input type="checkbox" name="chkall" value="checkbox" onclick="checkAll(this.form, this);" /><!--selectAll(this,'checkbox');-->编号<?=$html->image('sort_desc.gif',array('align'=>'absmiddle'))?></label></li><li class="headers">文章标题</li><li class="categries">文章分类</li><li class="type">文章类型</li><li class="block">是否显示</li><li class="orderby">排序</li><li class="add_time">添加日期</li><li class="hadle">操作</li></ul>
<!--Article List-->

<?if(isset($article) && sizeof($article)>0){?>
<?php foreach($article as $k=>$v ){?>
	<ul class="product_llist articles_type articles_list">
	<li class="number"><label><input type="checkbox" name="checkbox[]" value="<?php echo $v['Article']['id']?>" /><?php echo $v['Article']['id']?></label></li>
	<li class="headers"><span><?=$html->link("{$v['ArticleI18n']['title']}","../../articles/detail/{$v['Article']['id']}",'',false,false);?></span></li>
	<li class="categries"><span><?php echo $v['Article']['category']?></span></li>
	<li class="type"><?php echo $v['Article']['type']?></li>
	<li class="block"><?php if( $v['Article']['status'] == 1){?><?=$html->image('yes.gif')?><?}else{ echo $html->image('no.gif'); }?></li>
	<li class="orderby"><?php echo $v['Article']['orderby']?></li>

	<li class="add_time"><?php echo $v['Article']['modified']?></li>	
	<li class="hadle"> 

	<?php echo $html->link("查看","../../articles/{$v['Article']['id']}",array("target"=>"_blank"));?>|<?php echo $html->link("编辑","edit/{$v['Article']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}articles/remove/{$v['Article']['id']}')"));?>
	</li></ul>

<?php } ?>	
<?}?>

 
<div class="pagers" style="position:relative;">
<p class='batch'>    <select style="width:66px;border:1px solid #689F7C ;display:none;" name="act_type" id="act_type">
    <!---<option value="0">请选择...</option>
    --><option value="delete">删除</option>
    </select> 
<input type="submit" onclick="batch_action()" value="删除" /></p>
<? echo $form->end();?>


<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>

</div>
</div>
	
	<!--时间控件层start-->
	<div id="container_cal" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal2" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal2"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal3" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal3"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal4" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal4"></div><div style="clear:both;"></div></div>
	</div>
<!--end-->

<script>
function batch_action() 
{ 
document.ArticleForm.action=webroot_dir+"articles/batch"; 
document.ArticleForm.submit(); 
} 
function search_article() 
{ 
document.ArticleForm.action=webroot_dir+"articles/"; 
document.ArticleForm.submit(); 
} 


</script>