<?php 
/*****************************************************************************
 * SV-Cart 分页
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: pagers.ctp 2535 2009-07-02 11:34:51Z huangbo $
*****************************************************************************/
?>
<?php if($paging['pageCount']>1){?>
<div id="pager">
<p><?php 
    if($pagination->setPaging($paging)): 
    $pagenow=$paging['page'];
    $leftArrow = $html->image(isset($img_style_url)?$img_style_url."/"."back_icon.gif":"back_icon.gif", Array('height'=>15)); 
    $rightArrow = $html->image(isset($img_style_url)?$img_style_url."/"."right_icon.gif":"right_icon.gif", Array('height'=>15)); 
    $flag=0;
    $prev = $pagination->prevPage($leftArrow,false); 
    $prev = $prev?$prev:$leftArrow; 
    $next = $pagination->nextPage($rightArrow,false); 
    $next = $next?$next:$rightArrow; 
    $pages = $pagination->pageNumbers("     ");
    echo "$prev";
    echo "$pages";
    echo "$next";
    endif;

?> 
	<span><input type="text" name="go_page" id="go_page"/></span><?php echo $SCLanguages['page'];?><a href="javascript:GoPage(<?php echo $paging['pageCount']?>);"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'to_page.gif':'to_page.gif')?></a>
  </p></div>
<?php }?>