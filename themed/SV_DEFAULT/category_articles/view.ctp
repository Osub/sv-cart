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
 * $Id: view.ctp 3225 2009-07-22 10:59:01Z huangbo $
*****************************************************************************/
?>
<div id="Right">
	<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
	<div id="Products_box">
    	<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['article'];?><?php echo $SCLanguages['list'];?></b></h1>
<div id="Edit_box">
<!--文章列表-->
  <div id="Edit_info">
 <?php if(isset($article_list) && sizeof($article_list)>0){?>   <div id="user_msg">
  	<p class="article_time article_title">
		<span class="title"><?php echo $SCLanguages['article'];?><?php echo $SCLanguages['list'];?></span>
		<span class="add_time"><?php echo $SCLanguages['issue_time'];?></span></p>
    <div id="article_box">
<?php foreach($article_list as $key=>$v){ ?>    
		<p class="list">
			<span class="title"><?php echo $html->link($v['ArticleI18n']['title'],"/articles/{$v['Article']['id']}",array(),false,false);?></span>
			<span class="time"><?php echo $v['Article']['created'];?></span>
		</p>
<?php } ?>
	</div>
	
  <?php }else{?><br /><br /><br />
<?php echo "<p class='not'>"?>
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('alt'=>''))?>
<?php 
echo "<strong>".$SCLanguages['coming_please_note']."</strong></p><br /><br /><br />";  	  
}?>
  </div>
  </div>
</div><!--文章列表End-->
    </div>
    	<div id="pager">
    	<p style="float:left;padding-left:25px;">
    	
    	<?php if($total > 0){?>
	    	<?php printf($SCLanguages['records_statistics'],$total,$today);?>
    	<?php }?>
    	</p>
    <p><?php if($paging['pageCount']>1){?>

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
 <?php if(isset($article_list) && sizeof($article_list)>0){?> 
        <?php echo $SCLanguages['topage']?><span><input type="text" name="go_page" id="go_page"/></span><?php echo $SCLanguages['page']?><a href="javascript:GoPage(<?php echo $paging['pageCount']?>);"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'to_page.gif':'to_page.gif')?></a>
 <?php }}?>
  </p></div>
<script>
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
    
    
<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>
</div>