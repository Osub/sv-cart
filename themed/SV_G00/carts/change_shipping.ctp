<?php
/*****************************************************************************
 * SV-Cart ��������
 *===========================================================================
 * ��Ȩ�����Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
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