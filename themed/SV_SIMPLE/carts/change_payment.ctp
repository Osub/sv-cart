<?php 
/*****************************************************************************
 * SV-Cart ��ѡ֧����ʽ
 *===========================================================================
 * ��Ȩ�����Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: change_payment.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
ob_start();?>
<?php if($result['type'] == 0 ){?>
<p class="address btn_list">
<span class="l"></span><span class="r"></span>
<?php echo $SCLanguages['payment'];?>:
</p>
<?php echo $this->element('checkout_payment', array('cache'=>'+0 hour'));?>
<?php }else{?>
<?php echo $result['message'];?>
<?php }?>
<?php 
$result['checkout_payment'] = ob_get_contents();
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