<?php 
/*****************************************************************************
 * SV-Cart ѡ��ַ
 *===========================================================================
 * ��Ȩ�����Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: confirm_address.ctp 3225 2009-07-22 10:59:01Z huangbo $
*****************************************************************************/
ob_start();?>
<?php if($result['type'] == 0 ){?>
<?php echo $this->element('checkout_address', array('cache'=>'+0 hour'));?>
<?php }else{?>
<?php echo $result['message'];?>
<?php }?>
<?php 
$result['address'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
<?php if($result['type'] == 0 ){?>
<?php echo $this->element('checkout_shipping', array('cache'=>array('key' => 'address_to_shipping', 'time' => '+0 hour')));?>
<?php }else{?>
<?php echo $result['message'];?>
<?php }?>
<?php 
$result['shipping'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>