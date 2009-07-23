<?php 
/*****************************************************************************
 * SV-Cart 注册成功
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: done.ctp 2722 2009-07-09 07:57:02Z shenyunfeng $
*****************************************************************************/
?>
<div class="Balance_alltitle"><h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['register'];?></b></h1></div>
	<div id="globalBalance">
	<p class="succeed">
	<?php if(isset($fail)){?>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array("alt"=>$SCLanguages['register'].$SCLanguages['failed']))?>
	<?}else{?>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."icon-10.gif":"icon-10.gif",array("alt"=>$SCLanguages['register'].$SCLanguages['failed']))?>
	<?}?>
	
	<b class="succeed color_4">
	<?php if(isset($fail)){?>
		<?php echo $SCLanguages['register'].$SCLanguages['failed']?>
	<?}else{?>
		<?php echo $error_msg?>
	<?}?>
	</b></p>
	
	<?php if(isset($error_msg) && isset($fail)){?>
	<p class="back_home color_4">
	<?php echo $SCLanguages['notice'];?>：
	<?php echo $error_msg?>
	</p>
	<?php }?>
	
	<p class="back_home"><span><!--$server_host.$user_webroot."register/" -->
	<?if(isset($fail)){?>
		<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],$server_host.$user_webroot."register/",array('class'=>'color_4'),false,false);?>
	<?}else{?>
		<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],$back_register,array('class'=>'color_4'),false,false);?>
	<?}?>
	</span>&nbsp;&nbsp;
	<span>
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],$server_host.$cart_webroot,array('class'=>'color_4'),false,false);?>	
	</span></p>

    <p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."succeed02_img.gif":"succeed02_img.gif")?></p>
</div>
