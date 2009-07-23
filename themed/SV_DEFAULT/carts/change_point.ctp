<?php 
/*****************************************************************************
 * SV-Cart 重选积分
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: change_point.ctp 3195 2009-07-22 07:15:51Z huangbo $
*****************************************************************************/
ob_start();?>
<?php if($result['type'] == 0 ){?>
<h5><?php echo $SCLanguages['use'].$SCLanguages['point'];?>:</h5>
<?php echo $this->element('checkout_point', array('cache'=>'+0 hour'));?>
<?php }else{?>
<?php echo $result['msg'];?>
<?php }?>
<?php 
$result['checkout_point'] = ob_get_contents();
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