<?php 
/*****************************************************************************
 * SV-Cart 分页
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: pagers.ctp 2550 2009-07-03 06:35:49Z tangyu $
*****************************************************************************/
?>
    <p>
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
    echo "$prev";
    echo "$pages";
    echo "$next";
    endif;

?> 
		<span><input type="text" name="go_page" id="go_page"/></span><?php echo $SCLanguages['page'];?>
    	<?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'to_page.gif':'to_page.gif'),"javascript:GoPage({$paging['pageCount']})",'',false,false)?>
  </p>
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