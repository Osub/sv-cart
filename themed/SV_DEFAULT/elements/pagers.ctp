<?php 
/*****************************************************************************
 * SV-Cart ��ҳ
 *===========================================================================
 * ��Ȩ�����Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
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