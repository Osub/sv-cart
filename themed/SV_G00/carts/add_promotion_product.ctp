<?php
/*****************************************************************************
 * SV-Cart 增加促销商品
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: add_promotion_product.ctp 1116 2009-04-28 11:04:43Z huangbo $
*****************************************************************************/
ob_start();?>
<?if($result['type'] == 0 ){?>
<? echo $this->element('checkout_promotion_confirm', array('cache'=>'+0 hour'));?>
<?}else{?>
<div id="buyshop_box">
<div class="shops">
<p style='margin:0 10px;' align='center'><br /><br /><b><?=$SCLanguages['exceed_upper_limit_products'];?></b><br /><br /><br /></p>
<p class="buy_btn"><?=$html->link($SCLanguages['close'],"javascript:close_message();");?></p>
</div></div>
<?}?>
<?
$result['checkout_promotion_confirm'] = ob_get_contents();
ob_end_clean();
ob_start();?>
<?if($result['type'] == 0 ){?>
<? echo $this->element('checkout_total', array('cache'=>'+0 hour'));?>
<?}else{?>
<?echo $result['message'];?>
<?}?>
<?
$result['checkout_total'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>