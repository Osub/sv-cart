<?php 
/*****************************************************************************
 * SV-Cart 支付返回页
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2664 2009-07-08 03:23:02Z huangbo $
*****************************************************************************/
?>
<div class="checkout_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><?php echo $SCLanguages['checkout_center'];?></h1>
    <!--您购买的商品-->
    
    
<div id="globalBalance" class="border" style="border-bottom:none;margin-top:3px;">
	<?php if(isset($msg)){?>
	<br /><br /><br />
	<p class="succeed" style="padding:0;text-align:center;">
	<?php if(isset($fail)){?>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array("alt"=>$msg))?>
	<?php }else{?>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."icon-10.gif":"icon-10.gif",array("alt"=>$msg))?>
	<?php }?>
	<strong><?php echo $msg?></strong></p>	
	
	<br />
	<p class="back_home">
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],"/",array('class'=>'color_4'),false,false);?>
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'],$user_webroot,array('class'=>'color_4'),false,false);?>
	</p>
	<?php }?>
    <br />
</div>
    <p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."succeed02_img.gif":"succeed02_img.gif",array("width"=>"100%"))?></p>
<!--您购买的商品End-->
</div>