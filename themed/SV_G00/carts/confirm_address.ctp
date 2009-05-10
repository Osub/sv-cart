<?php
/*****************************************************************************
 * SV-Cart 选地址
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: confirm_address.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
ob_start();?>
<?if($result['type'] == 0 ){?>
<? echo $this->element('checkout_address', array('cache'=>'+0 hour'));?>
<?}else{?>
<?echo $result['message'];?>
<?}?>
<?
$result['address'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
<?if($result['type'] == 0 ){?>
<? echo $this->element('checkout_shipping', array('cache'=>'+0 hour'));?>
<?}else{?>
<?echo $result['message'];?>
<?}?>
<?
$result['shipping'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>