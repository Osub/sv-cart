<?php 
/*****************************************************************************
 * SV-Cart 包装
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: cart_packaging.ctp 3051 2009-07-17 11:51:50Z huangbo $
*****************************************************************************/
?>
<?php if(isset($svcart['packagings']) && sizeof($svcart['packagings'])>0){?>
<div class="Title_list">
<span class="Item_title"><?php echo __('Product',true)?></span>
<span class="Price_title"><pre><?php echo __('Single Price',true)?></pre></span>
<span class="Number_title"><?php echo __('quantity',true)?></span>
<span class="Sum_title"><?php echo __('Subtotal',true)?></span>
</div>
<div class="List_bg">
<?php foreach($svcart['packagings'] as $i=>$p){?>
<div id="Item_box">
<div class="Item_info" id="products_<?php echo $i;?>">
<p class="pic"><?php echo $html->image($p['Packaging']['img01'],array("width"=>108,"height"=>108));?></p>
<p class="info">
<span><?php echo $p['PackagingI18n']['name'];?></span>
</p>
</div>
<div class="Item_Price">

 <span class="Products_Price"><?php if($p['is_promotion'] == 1){ ?><?php echo  $p['Product']['promotion_price'];?><?php }else{ ?><?php echo  $p['Product']['shop_price'];?><?php } ?></span>
<span class="Price"><?php echo  __("List Price",true).":".$p['Product']['market_price'];?><br /><?php echo __('Discount',true)?>:<?php echo $p['discount_rate']."%"; ?></span>
<span class="save"><?php echo __('Save',true)?>:<?php echo $p['discount_price']?><?php echo __('$',true)?></span>
</div>
<div class="Number_select">
 <span class="top"><?php echo $html->link($html->image("ico_top.gif",array()),"javascript:quantity_change('+',".$i.")","",false,false);?></span>
<span class="Number" id="show_quantity_<?php echo  $p['quantity']; ?>"><?php echo  $p['quantity']; ?></span><input type="hidden" id="quantity_<?php echo $i?>" value="<?php echo  $p['quantity']; ?>" />
<span class="bottom"><?php echo $html->link($html->image("ico_bottom.gif",array()),"javascript:quantity_change('-',".$i.")","",false,false);?></span>
</div>
<div class="Sums">
<span class="Number"><?php echo $p['subtotal'];?></span>
</div>
<div class="btn_list"> <span class=del><?php echo $html->link(__($SCLanguages['delete'],array()),"javascript:remove_product(".$i.")","",false,false);?></span><span>
				<?php echo $html->link($SCLanguages['favorite'],$user_webroot."favorites/add/p/".$i,"",false,false)?>|
	</span><span><?php echo $html->link(__($SCLanguages['detail'],array()),"/products/index/".$i."/","",false,false);?></span></div>
</div>
<?php }?>
</div>
<div id="balance">
<span><?php echo __('Now count fee',true)?>:<font color="#ff0000">￥<?php echo $svcart['cart_info']['sum_subtotal'];?></font></span>
<span><?php echo __('Market count fee',true)?>:￥<?php echo $svcart['cart_info']['sum_market_subtotal'];?></span>
<span><?php echo __('Discount',true)?>:<?php echo $svcart['cart_info']['discount_rate'];?>%</span>
<span><?php echo __('Save price',true)?>:<font color="#ff0000"><?php echo $svcart['cart_info']['discount_price'];?></font>&nbsp;<?php echo __('$',true)?></span>
</div>
<?php }else{echo $SCLanguages['no_products_in_cart'];}?>