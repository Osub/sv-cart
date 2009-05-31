<?php
/*****************************************************************************
 * SV-Cart 帮助
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: help.ctp 887 2009-04-22 10:46:25Z shenyunfeng $
*****************************************************************************/
?>
<!--帮助中心显示开始-->
<?if(isset($link_info) && sizeof($link_info)>0){?>
<div class="category_box brand_box">
<h3><span class="l"></span><span class="r"></span><?=$SCLanguages['links'];?></h3>
<div class="category brands box">
<ul>
<?foreach($link_info as $key=>$link){?>

<?if(isset($link['LinkI18n']['img01']) && $link['LinkI18n']['img01'] != ""){?>
<li><?=$html->link($html->image($link['LinkI18n']['img01'],array("alt"=>$link['LinkI18n']['name'],'width'=>'165','title'=>$link['LinkI18n']['name'])),$link['LinkI18n']['url'],array("target"=>"_blank"),false,false);?></li>
<?}else{?>
<li class="text"><?=$html->link($link['LinkI18n']['name'],$link['LinkI18n']['url'],array("class"=>"color_083","target"=>"_blank"),false,false);?></li>
<?}?>	
<?}?>
</ul>
</div><p><?=$html->image('category_ulbt.gif',array("alt"=>""))?></p></div>
<?}?>
<!--帮助中心显示结束-->