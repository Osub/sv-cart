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
 * $Id: change_shipping.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
ob_start();?>
<?php if(isset($svcart['shipping']['shipping_fee'])){?>
<p class="address btn_list" id="address_btn_list">
<span class="l"></span><span class="r"></span>
<?php if(!isset($svcart['shipping']['not_show_change'])){?>
<a href="javascript:change_shipping();" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a>
<?php }?>
<?php echo $SCLanguages['shipping_method'];?>:</p>
<?php echo $this->element('checkout_shipping_confirm', array('cache'=>'+0 hour'));?>
<?php }else if($result['type'] == 0 ){?>
<p class="address btn_list" id="address_btn_list">
<span class="l"></span><span class="r"></span>
<?php echo $SCLanguages['shipping_method'];?>:</p>
<?php echo $this->element('checkout_shipping', array('cache'=>'+0 hour'));?>
<?php }else{?>
<p class="address btn_list" id="address_btn_list">
<span class="l"></span><span class="r"></span>
<?php echo $SCLanguages['shipping_method'];?>:</p>
<p class="border_b" style='margin:0 10px;' align='center'><br /><br /><b>
	<?php echo $SCLanguages['no_shipping_method'];?>
	</b><br /><br /><br /></p>
<?php }?>
<?php 
$result['checkout_shipping'] = ob_get_contents();
ob_end_clean();
?>
<?php ob_start();?>
<?php echo $this->element('checkout_total', array('cache'=>'+0 hour'));?>
<?php 
$result['checkout_total'] = ob_get_contents();
ob_end_clean();
?>
<?php 
echo json_encode($result);
?>