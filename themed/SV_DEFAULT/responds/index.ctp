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
 * $Id: index.ctp 2583 2009-07-04 07:02:59Z huangbo $
*****************************************************************************/
?>
<div class="Balance_alltitle"><span><?php echo $SCLanguages['checkout_center'];?></span></div>
    <!--您购买的商品-->
    
    
<div id="globalBalance">
	
	
	<?php if(isset($msg)){?>
	<p class="succeed">
	<?php if(isset($fail)){?>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array("align"=>"middle","alt"=>$msg))?>
	<?php }else{?>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."icon-10.gif":"icon-10.gif",array("align"=>"middle","alt"=>$msg))?>
	<?php }?>
	<b class="succeed"><?php echo $msg?></b></p>	
	
	<br />
	<p class="back_home"><span class="green_btns">
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['home'],"/",array(),false,false);?></span>
	</p>
    <p class="back_home"><span class="green_btns">
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'],$user_webroot,array(),false,false);?>
	</span></p>
	<?php }?>
    <br />
    <p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."succeed02_img.gif":"succeed02_img.gif")?></p>
    	
    	
</div>
<!--您购买的商品End-->