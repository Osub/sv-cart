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
 * $Id: index.ctp 1093 2009-04-28 04:02:04Z huangbo $
*****************************************************************************/
?>
<div class="Balance_alltitle"><span><?php echo $SCLanguages['checkout_center'];?></span></div>
    <!--您购买的商品-->
    
    
<div id="globalBalance">
	
	
	<?if(isset($msg)){?>
	<p class="succeed">
	<?if(isset($fail)){?>
	<?=$html->image("warning_img.gif",array("align"=>"middle","alt"=>$msg))?>
	<?}else{?>
	<?=$html->image("icon-10.gif",array("align"=>"middle","alt"=>$msg))?>
	<?}?>
	<b class="succeed"><?=$msg?></b></p>	
	
	<br />
	<p class="back_home"><span class="green_btns">
	<?=$html->link($SCLanguages['return'].$SCLanguages['home'],"/",array(),false,false);?></span>
	</p>
    <p class="back_home"><span class="green_btns">
	<?=$html->link($SCLanguages['return'].$SCLanguages['user_center'],"/user",array(),false,false);?>
	</span></p>
	<?}?>
    <br />
    <p><?=$html->image("succeed02_img.gif")?></p>
    	
    	
</div>
<!--您购买的商品End-->