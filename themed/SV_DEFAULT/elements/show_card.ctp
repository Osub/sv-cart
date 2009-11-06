<?php 
/*****************************************************************************
 * SV-Cart 购物车显示贺卡
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: show_card.ctp 4333 2009-09-17 10:46:57Z huangbo $
*****************************************************************************/
?>
<?php if(isset($svcart['products']) && sizeof($svcart['products'])>0 && empty($all_virtual)){?>
<?php if(isset($cards) && sizeof($cards)>0) { ?>
<ul style="height:100%;overflow:hidden;">
<?php foreach($cards as $k=>$v) {?>
<li>
<p class="pic">
<?php if($v['Card']['img01'] != ""){?>
<?php echo $html->image($v['Card']['img01'],array("alt"=>$v['CardI18n']['name'],"title"=>$v['CardI18n']['description'], "width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108));?> </p>
<?php }else{?>
<?php if($this->data['configs']['products_default_image'] != ""){?>
<?php echo $html->image($this->data['configs']['products_default_image'],array("alt"=>$v['CardI18n']['name'],"title"=>$v['CardI18n']['description'], "width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108));?> </p>		
<?php }else{?>
<?php echo $html->image("/img/product_default.jpg",array("alt"=>$v['CardI18n']['name'],"title"=>$v['CardI18n']['description'], "width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108));?> </p>		
<?php }?>
<?php }?>
<p class="info">
<span class="name carts"><?php echo $v['CardI18n']['name'];?></span>
<span class="Price"><?php echo $SCLanguages['our_price'];?>：<font color="#ff0000">
<?//php echo $svshow->price_format($v['Card']['fee'],$SVConfigs['price_format']);?>	
<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
	<?php echo $svshow->price_format($v['Card']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
<?php }else{?>
	<?php echo $svshow->price_format($v['Card']['fee'],$this->data['configs']['price_format']);?>	
<?php }?>	
	
</font>
</span>
<?php if($v['Card']['free_money'] > 0){?> 
<span class="Price"><?php echo $SCLanguages['free'];?><?php echo $SCLanguages['limit'];?>：<font color="#ff0000">
<?//php echo $svshow->price_format($v['Card']['free_money'],$SVConfigs['price_format']);?>	
	
<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
	<?php echo $svshow->price_format($v['Card']['free_money']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
<?php }else{?>
	<?php echo $svshow->price_format($v['Card']['free_money'],$this->data['configs']['price_format']);?>	
<?php }?>	
</font>
</span>	
<?php }?>
	
<span class="stow cart"><?php echo $html->link(__($SCLanguages['put_into_cart'],array("alt"=>$SCLanguages['put_into_cart'])),"javascript:buy_on_cart_page('card',".$v['Card']['id'].")");?></span>
</p>
</li>
<?php }?> 
</ul>
<?php }?>
<?php }?>