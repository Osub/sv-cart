<?php
/*****************************************************************************
 * SV-Cart 底部文件
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: footer.ctp 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
?>
<!-- 底部开始-->
<?if(isset($navigations_footer) && sizeof($navigations_footer)>0){?><p class="link">
<? foreach($navigations_footer as $k => $navigation){?><?if($k !=0){?> |　<?}?><?=$html->link($navigation['NavigationI18n']['name'],$navigation['NavigationI18n']['url'],"",false,false);?>
<?}?></p><?}?>
<p class="copyRight green_3"><font face="Arial">&copy;</font>2009 <?printf($SCLanguages['copyright'],$SVConfigs['shop_name']);?></p>
<p class="Power green_3">
<?=$html->link(" <span class='number green_3'>Powered by SV-Cart</span>","http://www.seevia.cn",array("target"=>"_blank"),false,false);?>
</p>
<?=$SVConfigs['statistic_code']?>
<!-- 底部结束 -->