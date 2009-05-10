<?php
/*****************************************************************************
 * SV-Cart 更改促销
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: change_promotion.ctp 1028 2009-04-24 12:23:26Z huangbo $
*****************************************************************************/
ob_start();?>
<?if($result['type'] == 0 ){?>
<? echo $this->element('checkout_promotion', array('cache'=>'+0 hour'));?>
<?}else{?>
<p class="border_b" style='margin:0 10px;' align='center'><br /><br /><b><?=$SCLanguages['no_paying_method']?></b><br /><br /><br /></p>
<?}?>
<?
$result['checkout_promotion'] = ob_get_contents();
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