<?php 
/*****************************************************************************
 * SV-Cart 用户中心左边菜单
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: menber_menu.ctp 2807 2009-07-13 09:55:56Z shenyunfeng $
*****************************************************************************/
?>
<div class="category_box catmenus">
<h3 class="font_14"><span class="l"></span><span class="r"></span><?php echo $SCLanguages['user_center']?></h3>
<div class="box">
<ul class="left_menus">
	<li class="Nav"><?php echo $html->link($SCLanguages['my_information'],'/profiles/',array('class'=>'svcartmenuitemlabel'))?></li>
	<li class="Nav"><?php echo $html->link($SCLanguages['address_book'],'/addresses/',array('class'=>'svcartmenuitemlabel'));?></li>
	<li class="Nav"><?php echo $html->link($SCLanguages['my_favorite'],"/favorites/",array('class'=>'svcartmenuitemlabel'));?></li>
	<li class="Nav"><?php echo $html->link($SCLanguages['purchased'],'/products/',array('class'=>'svcartmenuitemlabel'));?></li>
	<li class="Nav"><?php echo $html->link($SCLanguages['order_list'],'/orders/',array('class'=>'svcartmenuitemlabel'))?></li>
	<li class="Nav"><?php echo $html->link($SCLanguages['my_friends'],'/friends/',array('class'=>'svcartmenuitemlabel'));?></li>
	<li class="Nav"><?php echo $html->link($SCLanguages['my_message'],'/messages/',array('class'=>'svcartmenuitemlabel'))?></li>
	<li class="Nav"><?php echo $html->link($SCLanguages['my_tags'],'/tags/',array('class'=>'svcartmenuitemlabel'))?></li>
	<li class="Nav"><?php echo $html->link($SCLanguages['my_comments'],'/commnets/',array('class'=>'svcartmenuitemlabel'));?></li>
	<li class="Nav"><?php echo $html->link($SCLanguages['my_balance'],'/balances/',array('class'=>'svcartmenuitemlabel'))?></li>
	<li class="Nav"><?php echo $html->link($SCLanguages['points'],'/points/',array('class'=>'svcartmenuitemlabel'))?></li>
	<li class="Nav"><?php echo $html->link($SCLanguages['my_coupon'],'/coupons/',array('class'=>'svcartmenuitemlabel'))?></li>
	<?php if(isset($user_config_count) && $user_config_count>0){?>
	<li class="Nav"><?php echo $html->link($SCLanguages['set'],"/configs/",array("class"=>"svcartmenuitemlabel"));?></li>
	<?php }?>
	<li class="Nav"><?php echo $html->link($SCLanguages['log_out'],'javascript:logout();',array("class"=>"svcartmenuitemlabel"));?></li>
</ul>
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'category_ulbt.gif':'category_ulbt.gif',array('alt'=>''))?></p>
</div><!--用户中心菜单 End-->