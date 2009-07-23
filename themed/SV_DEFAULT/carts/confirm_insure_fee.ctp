<?php 
/*****************************************************************************
 * SV-Cart 选保价费
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: confirm_insure_fee.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
ob_start();?>
<?php if($result['type'] == 0 ){?>
	<?php if($shipping['insure_fee']>0){?>
	<?php echo $svshow->price_format($shipping['insure_fee'],$SVConfigs['price_format']);?>	
		<?if(isset($shipping['insure_fee_confirm']) && $shipping['insure_fee_confirm'] > 0){?>
		<a href="javascript:confirm_insure_fee(<?=$shipping['shipping_id']?>,<?=$shipping['insure_fee']?>,2);"><?=$html->image('no.gif',array('title'=>'取消保价','alt'=>'取消保价'))?></a>
		<?}else{?>
		<a href="javascript:confirm_insure_fee(<?=$shipping['shipping_id']?>,<?=$shipping['insure_fee']?>,1);"><?=$html->image('yes.gif',array('title'=>'需要保价','alt'=>'取消保价'))?></a>
		<?}?>
	<?php }else{?>
		-
	<?php }?><span id="insure_fee_loading" style="display:none;"><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>
<?php }?>
<?php 
$result['checkout_shipping'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
<?php if($result['type'] == 0 ){?>
<?php echo $this->element('checkout_total', array('cache'=>'+0 hour'));?>
<?php }else{?>

<?php }?>
<?php 
$result['checkout_total'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>