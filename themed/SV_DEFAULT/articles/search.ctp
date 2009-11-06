<?php 
/*****************************************************************************
 * SV-Cart 文章分类
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: tag.ctp 3390 2009-07-29 10:39:28Z shenyunfeng $
*****************************************************************************/
?>
<div id="Right">
	<div id="Products_box">	<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
    <h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['article'];?><?php echo $SCLanguages['list'];?></b></h1>
<!--文章列表-->
	<div class="categoryArticle border">
	<?php if(isset($article_list) && sizeof($article_list)>0){?>
	<?php foreach($article_list as $key=>$v){ ?>    
	<div class="title"><?php echo $html->link($v['ArticleI18n']['sub_title'],$svshow->article_link($v['Article']['id'],$dlocal,$v['ArticleI18n']['title'],$this->data['configs']['article_link_type']),array('title'=>$v['ArticleI18n']['title']),false,false);?>&nbsp;<small><?php printf($SCLanguages['released_in'],$v['ArticleI18n']['author']);?>&nbsp;<?php echo $v['Article']['created'];?></small></div>
	<div class="meta <?php if($key==sizeof($article_list)-1){?>last<?php }?>"><?php echo $v['ArticleI18n']['meta_description'];?> &nbsp;<?php echo $html->link($SCLanguages['view_full_text']." >>",$svshow->article_link($v['Article']['id'],$dlocal,$v['ArticleI18n']['title'],$this->data['configs']['article_link_type']),array(),false,false)?></div>
	<?php }?>	
	<?php }else{?>
  	  <div class='not'><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('alt'=>''))?>
<strong><?php echo $SCLanguages['coming_please_note'];?></strong></div>
  <?php }?>
</div>
<!--文章列表End-->

    	<div id="pager">
    	<p style="float:left;padding-left:25px;">
    	<?php if($total > 0){?>
	    	<?//php printf($SCLanguages['records_statistics'],$total,$today);?>
    	<?php }?>
    	</p>
    <p>
 <?php if(isset($article_list) && sizeof($article_list)>0 && $paging['pageCount']>1){?> 
<?php 
    if($pagination->setPaging($paging)): 
    //pr($paging);
    $pagenow=$paging['page'];
    $leftArrow = $html->image(isset($img_style_url)?$img_style_url."/"."back_icon.gif":"back_icon.gif", Array('height'=>15)); 
    $rightArrow = $html->image(isset($img_style_url)?$img_style_url."/"."right_icon.gif":"right_icon.gif", Array('height'=>15)); 
    $flag=0;
    $prev = $pagination->prevPage($leftArrow,false); 
    $prev = $prev?$prev:$leftArrow; 
    $next = $pagination->nextPage($rightArrow,false); 
    $next = $next?$next:$rightArrow; 
    $pages = $pagination->pageNumbers("     ");
if(isset($article_list) && sizeof($article_list)>0){    
	echo "$prev";
    echo "$pages";
    echo "$next";
}
    endif;
?> 
   <?php echo $SCLanguages['topage']?><span><input type="text" name="go_page" id="go_page"/></span><?php echo $SCLanguages['page']?><a href="javascript:GoSearchPage(<?php echo $paging['pageCount']?>,'<?php echo $this->data['article_search']?>');"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'to_page.gif':'to_page.gif')?></a>
 <?php }?>
  </p></div>
<script type="text/javascript">
/*function GoPage(pagecount){
var goPage=document.getElementById('go_page').value;
if(goPage > pagecount){
  alert(page_number_expand_max);
}
else{
window.location.href="?page="+goPage;
}
}*/
function show_last5(){
  document.getElementById('last5').style.display="block";
}
</script>
    
    
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
</div>