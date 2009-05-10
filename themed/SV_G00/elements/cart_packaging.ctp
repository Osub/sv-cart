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
 * $Id: cart_packaging.ctp 791 2009-04-18 16:04:23Z huangbo $
*****************************************************************************/
?>
<?if(isset($svcart['packagings']) && sizeof($svcart['packagings'])>0){?>
<div class="Title_list">
<span class="Item_title"><?=__('Product',true)?></span>
<span class="Price_title"><pre><?=__('Single Price',true)?></pre></span>
<span class="Number_title"><?=__('quantity',true)?></span>
<span class="Sum_title"><?=__('Subtotal',true)?></span>
</div>
<div class="List_bg">
<?foreach($svcart['packagings'] as $i=>$p){?>
<div id="Item_box">
<div class="Item_info" id="products_<?=$i;?>">
<p class="pic"><?=$html->link($html->image($p['Packaging']['img01'],array("width"=>108,"height"=>108)),"/carts/#","",false,false);?></p>
<p class="info">
<span><?php echo $p['PackagingI18n']['name'];?></span>
</p>
</div>
<div class="Item_Price">

 <span class="Products_Price"><? if($p['is_promotion'] == 1){ ?><?= $p['Product']['promotion_price'];?><? }else{ ?><?= $p['Product']['shop_price'];?><? } ?></span>
<span class="Price"><?= __("List Price",true).":".$p['Product']['market_price'];?><br /><?=__('Discount',true)?>:<?=$p['discount_rate']."%"; ?></span>
<span class="save"><?=__('Save',true)?>:<?=$p['discount_price']?><?=__('$',true)?></span>
</div>
<div class="Number_select">
 <span class="top"><?=$html->link($html->image("ico_top.gif",array()),"javascript:quantity_change('+',".$i.")","",false,false);?></span>
<span class="Number" id="show_quantity_<?= $p['quantity']; ?>"><?= $p['quantity']; ?></span><input type="hidden" id="quantity_<?=$i?>" value="<?= $p['quantity']; ?>" />
<span class="bottom"><?=$html->link($html->image("ico_bottom.gif",array()),"javascript:quantity_change('-',".$i.")","",false,false);?></span>
</div>
<div class="Sums">
<span class="Number"><?=$p['subtotal'];?></span>
</div>
<div class="btn_list"> <span class=del><?=$html->link(__($SCLanguages['delete'],array()),"javascript:remove_product(".$i.")","",false,false);?></span><span><?=$html->link(__($SCLanguages['favorite'],array()),"javascript:new_favorite(".$i.",'p')","",false,false);?></span><span><?=$html->link(__($SCLanguages['detail'],array()),"/products/index/".$i."/","",false,false);?></span></div>
</div>
<?}?>
</div>
<div id="balance">
<span><?=__('Now count fee',true)?>:<font color="#ff0000">￥<?=$svcart['cart_info']['sum_subtotal'];?></font></span>
<span><?=__('Market count fee',true)?>:￥<?=$svcart['cart_info']['sum_market_subtotal'];?></span>
<span><?=__('Discount',true)?>:<?=$svcart['cart_info']['discount_rate'];?>%</span>
<span><?=__('Save price',true)?>:<font color="#ff0000"><?=$svcart['cart_info']['discount_price'];?></font>&nbsp;<?=__('$',true)?></span>
</div>
<?}else{echo $SCLanguages['no_products_in_cart'];}?>