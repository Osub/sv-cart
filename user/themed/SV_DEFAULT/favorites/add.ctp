<?php 
/*****************************************************************************
 * SV-Cart 添加收藏
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 3113 2009-07-20 11:14:34Z huangbo $
*****************************************************************************/
?>
<?php ob_start();?>
<div id="loginout">
	<?if($result['type']==0){?>
		<h1 class="hd"><b>
		<?php echo $result['message'];?>
			</b></h1>
		<div id="buyshop_box">
		<div class="shops">
		<ul>
		<li class="pic">
			<?php if(isset($product_info['Product']['img_thumb']) && $product_info['Product']['img_thumb'] != ""){?>
			<?php echo $html->image("/../".$product_info['Product']['img_thumb'],array("alt"=>$product_info['ProductI18n']['name'],"width"=>75,"height"=>75));?>
			<?php }else{?>
			<?php echo $html->image("/../img/product_default.jpg",array("alt"=>$product_info['ProductI18n']['name'],"width"=>75,"height"=>75));?>
			<?php }?>
		</li>
		<li>
		<p class="name"><?php echo $SCLanguages['products'].$SCLanguages['apellation']."：".$product_info['ProductI18n']['name'];?></p>
		<p>
		<?php if(isset($SVConfigs['show_market_price']) && $SVConfigs['show_market_price'] >0){?>
		<?php echo $svshow->price_format($product_info['Product']['market_price'],$SVConfigs['price_format']);?>	
		<?php }else if(isset($product_info['is_promotion'])){?>
		<?php if($product_info['is_promotion'] == 1){ ?>
		<?php echo $SCLanguages['our_price']?>:
		<?php echo $svshow->price_format($product_info['Product']['promotion_price'],$SVConfigs['price_format']);?>	
		<?php }else{ ?>
		<?php echo $SCLanguages['our_price']?>:
		<?php echo $svshow->price_format($product_info['Product']['shop_price'],$SVConfigs['price_format']);?>	
		<?php }} ?>
		</p>
		<p>

		<?php if(isset($product_info['discount_price']) && $product_info['discount_price'] > 0){?>
		<?php echo $SCLanguages['discount'];?>:<?php echo $product_info['discount_rate']."%"; ?></p>
		<p><?php echo $SCLanguages['save_to_market_price'];?>：
		<?php echo $svshow->price_format($product_info['discount_price'],$SVConfigs['price_format']);?>	
		</p>
		<?php }else{?>
		</p>
		<?php }?>
		</li>
		</ul>
		</div>
	
	
	<?}else{?>
		<h1><b><?php echo $SCLanguages['favorite'].$SCLanguages['products'];?></b></h1>
	<?}?>
	
	
	<div style="border-left:1px solid #909592;border-right:1px solid #909592;background:#fff">
	<?if($result['type'] != ''){?>
		<p class="login-alettr"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'icon-10.gif':'icon-10.gif',array("align"=>"middle"));?>
	<b><?php echo $result['message'];?></b></p>
	<?}?>	
		<p class="btns">
			<a href="javascript:close_message();"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'loginout-btn_right.gif':'loginout-btn_right.gif');?><?php echo $SCLanguages['close'];?></a>
			<?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'loginout-btn_right.gif':'loginout-btn_right.gif').$SCLanguages['view'].$SCLanguages['my_favorite'],$server_host.$user_webroot."favorites/",array(),false,false);?>
		</p>
	</div>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'loginout-bottom.gif':'loginout-bottom.gif')?></p>
</div>
<?php 
	$result['message'] = ob_get_contents();
	ob_end_clean();
	echo json_encode($result);
?>