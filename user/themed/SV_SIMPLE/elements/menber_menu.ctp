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
 * $Id: menber_menu.ctp 1381 2009-05-15 04:15:24Z zhangshisong $
*****************************************************************************/
?>
<div class="cont">
<span class="left_up">&nbsp;</span><span class="right_up">&nbsp;</span>
<h3><span><?php echo $SCLanguages['user_center']?></span></h3>
<ul class="list">
	<li><?php echo $html->link($SCLanguages['my_information'],'/profiles/',array())?></li>
	<li><?php echo $html->link($SCLanguages['order_list'],'/orders/',array())?></li>
	<?php if(isset($user_config_count) && $user_config_count>0){?>
	<li><?php echo $html->link($SCLanguages['set'],"/configs/",array());?></li>
	<?php }?>
	<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
	<li><?php echo $html->link($SCLanguages['log_out'],'/logout/',array());?></li>
	<?php }else{?>
	<li><?php echo $html->link($SCLanguages['log_out'],'javascript:logout();',array());?></li>
	<?php }?>
</ul>
<span class="left_down">&nbsp;</span><span class="right_down">&nbsp;</span>
</div><!--用户中心菜单 End-->
<p class="height_3">&nbsp;</p>
