<?php
/*****************************************************************************
 * SV-CART 促销首页
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1215 2009-05-06 05:46:48Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Products_box">
<h1 class="headers">
<span class="l"></span><span class="r"></span>
<b><?=$SCLanguages['promotion'];?><?=$SCLanguages['list'];?></b></h1>
<div id="Edit_box"><!--促消列表-->
<div id="Edit_info">
<div id="user_msg">
<?php if(isset($promotions) && sizeof($promotions)>0){?>
<p class="article_time article_title">
	<span class="title"><?=$SCLanguages['promotion'];?><?=$SCLanguages['list'];?></span>
	<span class="user_name"><?php echo $SCLanguages['start'];?><?php echo $SCLanguages['time'];?></span>
	<span class="add_time"><?php echo $SCLanguages['end'];?><?php echo $SCLanguages['time'];?></span>
</p>
<div id="article_box">
<?	foreach($promotions as $key=>$v){ ?>    
    	<p class="list">
			<span class="title"><?php echo $html->link($v['PromotionI18n']['title'],"/promotions/{$v['Promotion']['id']}",array(),false,false);?></span>
			<span class="name"><?php echo $v['Promotion']['start_time'];?></span>
			<span class="time"><?php echo $v['Promotion']['end_time'];?></span>
		</p>
<?php }}else{?>
<div class="not">
<br />
<?=$html->image("warning_img.gif",array("alt"=>""))?><strong><?php echo $SCLanguages['no_promote_activity'];?></strong></div>
<?}?>
</div></div></div></div><!--促消列表End--></div>
<div id="pager">
<p style="float:left;padding-left:25px;">
	<?if($total >0 ){?>
	<?php printf($SCLanguages['records_statistics'],$total,$one_day_time);?>
	<?}?>
	</p><p>
<?php 
    if($pagination->setPaging($paging)): 
    //pr($paging);
    $pagenow = $paging['page'];
    $leftArrow = $html->image("back_icon.gif", Array('height'=>15)); 
    $rightArrow = $html->image("right_icon.gif", Array('height'=>15)); 
    $flag=0;
    $prev = $pagination->prevPage($leftArrow,false); 
    $prev = $prev?$prev:$leftArrow; 
    $next = $pagination->nextPage($rightArrow,false); 
    $next = $next?$next:$rightArrow; 
    $pages = $pagination->pageNumbers("     ");
    if(isset($promotions) && sizeof($promotions)>0){
    
    echo "$prev";
    echo "$pages";
    echo "$next";
    }
    endif;

?> 
<?php if(isset($promotions) && sizeof($promotions)>0){?>
    <?=$SCLanguages['topage'];?><span><input type="text" name="go_page" id="go_page"/></span><?=$SCLanguages['pages'];?><a href="javascript:GoPage(<?echo $paging['pageCount']?>);"><?=$html->image('to_page.gif')?></a>
<?}?>
  </p></div>
<script>
function GoPage(pagecount){
var goPage=document.getElementById('go_page').value;
if(goPage > pagecount){
  alert(page_number_expand_max);
}
else{
window.location.href="?page="+goPage;
}
}
function show_last5(){
  document.getElementById('last5').style.display="block";
}
</script>
<? echo $this->element('news', array('cache'=>'+0 hour'));?>
