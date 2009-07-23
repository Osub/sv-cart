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
 * $Id: index.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?>


 
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>

<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'','name'=>'ArticleForm','type'=>'get','onsubmit'=>"return false"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">

	  			<select class="all" name="article_cat" id="article_cat" >
	<option value="0">所有分类</option>
<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
<option value="<?php echo $first_v['Category']['id'];?>" <?php if($article_cats == $first_v['Category']['id'] ){echo "selected";}?> ><?php echo $first_v['CategoryI18n']['name'];?></option>
<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?php echo $second_v['Category']['id'];?>" <?php if($article_cats == $second_v['Category']['id'] ){echo "selected";}?> >&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?php echo $third_v['Category']['id'];?>" <?php if($article_cats == $third_v['Category']['id'] ){echo "selected";}?> >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
<?php }}}}}}?>
	</select>
&nbsp;&nbsp;
	文章标题：<input type="text" class="name" name="title" value="<?php echo @$titles?>"/>&nbsp;&nbsp;
	发布时间：<input type="text" name="start_time" class="time" id="date" readonly="readonly"value="<?php echo @$start_time?>" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?></button>－
	<input type="text" name="end_time" class="time" id="date2" readonly="readonly" value="<?php echo @$end_time?>" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?></button></p></dd>
	<dt class="small_search"><input type="submit" onclick="search_article()" value="搜索" class="search_article"  /></dt>
	</dl>

</div>
<br /><br />
<!--Search End-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增文章","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th  align="left"><label><input type="checkbox" name="chkall" value="checkbox" onclick="checkAll(this.form, this);" /><!--selectAll(this,'checkbox');-->编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></label></th><th>文章标题></th><th>文章分类></th><th>文章类型></th><th>是否显示></th><th>排序></th><th>添加日期></th><th>操作</th></tr>
<!--Article List-->

<?php if(isset($article) && sizeof($article)>0){?>
<?php foreach($article as $k=>$v ){?>
	<tr>
	<td><label><input type="checkbox" name="checkbox[]" value="<?php echo $v['Article']['id']?>" /><?php echo $v['Article']['id']?></label></td>
	<td><span><?php echo $html->link("{$v['ArticleI18n']['title']}",$server_host.$cart_webroot."articles/{$v['Article']['id']}",'',false,false);?></span></td>
	<td align="center"><span><?php echo $v['Article']['category']?></span></td>
	<td align="center"><?php echo $v['Article']['type']?></td>
	<td align="center"><?php if( $v['Article']['status'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{ echo $html->image('no.gif'); }?></td>
	<td align="center"><?php echo $v['Article']['orderby']?></td>

	<td align="center"><?php echo $v['Article']['modified']?></td>	
	<td align="center">

	<?php echo $html->link("查看",$server_host.$cart_webroot."articles/{$v['Article']['id']}",array("target"=>"_blank"));?>|<?php echo $html->link("编辑","edit/{$v['Article']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}articles/remove/{$v['Article']['id']}')"));?>
	</td></tr>

<?php } ?>	
<?php }?>
</table>
 
<div class="pagers" style="position:relative;">
<?php if(isset($article) && sizeof($article)>0){?>
<p class='batch'>    <select style="width:66px;border:1px solid #689F7C ;display:none;" name="act_type" id="act_type">
    <!---<option value="0">请选择...</option>
    --><option value="delete">删除</option>
    </select> 
<input type="submit" onclick="batch_action()" value="删除" /></p><?php }?>
		<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div><?php echo $form->end();?>
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
document.ArticleForm.onsubmit= "";
document.ArticleForm.submit(); 
} 
function search_article() 
{ 
document.ArticleForm.action=webroot_dir+"articles/"; 
document.ArticleForm.onsubmit= "";
document.ArticleForm.submit(); 
} 


</script>