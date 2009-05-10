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
 * $Id: help.ctp 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
?>
<!--帮助中心显示开始-->
<?
if($navigations_help){
?>
<?//pr($navigations_help);?>
<div class="category_box brand_box"><h3><?=$SCLanguages['help_center']?></h3><div class="category Help"><ul>

<?if(isset($navigations_help) && sizeof($navigations_help)>0){?>
<?foreach($navigations_help as $key=>$help){?>
<li><?=$html->image('ico_28.gif',array("alt"=>"SV-Cart"));?><?=$html->link($help['NavigationI18n']['name']." <font face='宋体'>&gt;&gt;</font>","{$help['NavigationI18n']['url']}","",false,false);?></li>
<?}?>
<?}?>
</ul></div>
<p><?=$html->image("category_ulbt.gif",array("alt"=>""))?></p>
</div>
<?}?>
<!--帮助中心显示结束-->