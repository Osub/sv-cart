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