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
 * $Id: help.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<!--帮助中心显示开始-->
<?php if($navigations_help){?>
<?php //pr($navigations_help);?>
<div class="cont">
<span class="left_up">&nbsp;</span><span class="right_up">&nbsp;</span>
<h3><span><?php echo $SCLanguages['help_center']?></span></h3>
<ul class="list">
<?php if(isset($navigations_help) && sizeof($navigations_help)>0){?>
<?php foreach($navigations_help as $key=>$help){?>
<li class="squareico">
<?php echo $html->link($help['NavigationI18n']['name']." <font face='宋体'>&gt;&gt;</font>","{$help['NavigationI18n']['url']}","",false,false);?></li>
<?php }?>
<?php }?>
</ul>
<span class="left_down">&nbsp;</span><span class="right_down">&nbsp;</span>
</div>
<p class="height_3">&nbsp;</p>
<?php }?>
<!--帮助中心显示结束-->