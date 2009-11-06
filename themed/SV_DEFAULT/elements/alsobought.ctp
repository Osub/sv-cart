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
 * $Id: history.ctp 3491 2009-08-05 10:52:26Z shenyunfeng $
*****************************************************************************/
?>
<?php if(isset($alsoboughts) && sizeof($alsoboughts)>0){ //if(isset($_SESSION['cookie_product']) && sizeof($_SESSION['cookie_product'])>0){?>
<div id="history_box">
<div class="category_box" style="margin-top:5px;">
<!--浏览历史start-->
<h3><span class="l"></span><span class="r"></span><?php echo $this->data['languages']['purchased_this_product_also'];?></h3>
<div class="history box" id='history'>
	<ul>
	<?php foreach($alsoboughts as $k=>$v){?>
		<li>
		 <p class="pic">
		<?php if(isset($v['Product']['img_thumb']) && $v['Product']['img_thumb'] != ""){?>
		<?php echo $html->link($html->image("{$v['Product']['img_thumb']}",array("width"=>"65","height"=>"65","onmouseover"=>"this.className='hover'","alt"=>$v['ProductI18n']['name'],"onmouseout"=>"this.className='normal'")),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array(),false,false);?>
		<?php }else{?>
			<?php echo $html->link($html->image("/img/product_default.jpg",array("width"=>"65","alt"=>$v['ProductI18n']['name'],"height"=>"65","onmouseover"=>"this.className='hover'","onmouseout"=>"this.className='normal'")),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array(),false,false);?>
		<?php }?>
		</p>
		<p class="name">
		<?php echo $html->link(("{$v['ProductI18n']['name']}"),$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$this->data['configs']['product_link_type']),array("target"=>"_blank"),false,false)?>
		</p>
		<p class="price">
		<?//php if(isset($v['Product']['user_price']) && isset($this->data['configs']['show_member_level_price']) && $this->data['configs']['show_member_level_price'] >0 && isset($_SESSION['User']['User'])){?>	
		<?//php echo $svshow->price_format($v['Product']['user_price'],$this->data['configs']['price_format']);?>	
		<?//php }else{?>
		<?//php echo $svshow->price_format($v['Product']['shop_price'],$this->data['configs']['price_format']);?>	
		<?//php }?>
		</p>
		</li>    
	<?php }?>
	</ul>
</div>       
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."category_ulbt.gif":"category_ulbt.gif",array("width"=>"100%","height"=>"5"))?></p>
</div>
<!--浏览历史End-->
</div>
 <?php }?>
