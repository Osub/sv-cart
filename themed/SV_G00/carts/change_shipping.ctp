<?php
/*****************************************************************************
 * SV-Cart 更改配送
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: change_shipping.ctp 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
ob_start();?>
<?if(isset($svcart['shipping'])){?>
<p class="address btn_list" id="address_btn_list">
<span class="l"></span><span class="r"></span>
<?if(!isset($svcart['shipping']['not_show_change'])){?>
<a href="javascript:change_shipping();" class="amember"><span><?=$SCLanguages['mmodify']?></span></a>
<?}?>
<?php echo $SCLanguages['shipping_method'];?>:</p>
<? echo $this->element('checkout_shipping_confirm', array('cache'=>'+0 hour'));?>
<?}else if($result['type'] == 0 ){?>
<p class="address btn_list" id="address_btn_list">
<span class="l"></span><span class="r"></span>
<?php echo $SCLanguages['shipping_method'];?>:</p>
<? echo $this->element('checkout_shipping', array('cache'=>'+0 hour'));?>
<?}else{?>
<p class="address btn_list" id="address_btn_list">
<span class="l"></span><span class="r"></span>
<?php echo $SCLanguages['shipping_method'];?>:</p>
<p class="border_b" style='margin:0 10px;' align='center'><br /><br /><b>
	<?php echo $SCLanguages['no_shipping_method'];?>
	</b><br /><br /><br /></p>
<?}?>
<?
$result['checkout_shipping'] = ob_get_contents();
ob_end_clean();
?>
<?ob_start();?>
<? echo $this->element('checkout_total', array('cache'=>'+0 hour'));?>
<?
$result['checkout_total'] = ob_get_contents();
ob_end_clean();
?>
<?
echo json_encode($result);
?>