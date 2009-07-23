<?php 
/*****************************************************************************
 * SV-CART 浏览历史
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: history.ctp 3113 2009-07-20 11:14:34Z huangbo $
*****************************************************************************/
?>
<?php if(isset($_SESSION['cookie_product']) && sizeof($_SESSION['cookie_product'])>0){?>
<div class="cont">
<span class="left_up">&nbsp;</span><span class="right_up">&nbsp;</span>
<!--浏览历史start-->
<h3><span><?php echo $SCLanguages['view_history'];?>&nbsp;|&nbsp;
	<?=$html->link($SCLanguages['clear_view_history'],'/products/del_history/',array('onfocus'=>'blur()','class'=>'fff'),false,false);?>
	</span></h3>

<ul id='history' class="history">
	<?php foreach($_SESSION['cookie_product'] as $k=>$v){?>
	<li>
	<p class="picture">
	<?php if(isset($v['Product']['img_thumb']) && $v['Product']['img_thumb'] != ""){?>
			<?php echo $html->link($html->image("{$v['Product']['img_thumb']}",array("width"=>"65","height"=>"65","onmouseover"=>"this.className='hover'","onmouseout"=>"this.className='normal'")),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array(),false,false);?>
	<?php }else{?>		<?php echo $html->link($html->image("/img/product_default.jpg",array("width"=>"65","height"=>"65","onmouseover"=>"this.className='hover'","onmouseout"=>"this.className='normal'")),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array(),false,false);?>
	<?php }?>
	</p>
	<p class="name">
			<?php echo $html->link(("{$v['ProductI18n']['name']}"),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("target"=>"_blank"),false,false)?>
	</p>
	<p class="price">
	<?php if(isset($v['Product']['user_price']) && isset($SVConfigs['show_member_level_price']) && $SVConfigs['show_member_level_price'] >0 && isset($_SESSION['User']['User'])){?>	
	<?php echo $svshow->price_format($v['Product']['user_price'],$SVConfigs['price_format']);?>	
	<?php }else{?>
	<?php echo $svshow->price_format($v['Product']['shop_price'],$SVConfigs['price_format']);?>	
	<?php }?>
	</p>
	</li>    
	<?php }?>
</ul>
<span class="left_down">&nbsp;</span><span class="right_down">&nbsp;</span>
</div>
<!--浏览历史End-->
<p class="height_3">&nbsp;</p>
 <?php }?>