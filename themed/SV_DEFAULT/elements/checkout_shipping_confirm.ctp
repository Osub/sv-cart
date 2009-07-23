<?php 
/*****************************************************************************
 * SV-Cart 结算页配送方式选定
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_shipping_confirm.ctp 3113 2009-07-20 11:14:34Z huangbo $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice">
<tr class="list bgcolor_e">
<td width="29%" height="25" valign="middle" class="handel"><span class="select_input"><b><?php echo $svcart['shipping']['shipping_name'];?></b>&nbsp;&nbsp;&nbsp;
</span>
<?php echo $SCLanguages['shipping_fee'];?>:<?php echo $svshow->price_format($svcart['shipping']['shipping_fee'],$SVConfigs['price_format']);?>&nbsp;&nbsp;&nbsp;
<?php echo $SCLanguages['free'].$SCLanguages['limit'];?>:<?php echo $svshow->price_format($svcart['shipping']['free_subtotal'],$SVConfigs['price_format']);?>&nbsp;&nbsp;&nbsp;
<?php echo $SCLanguages['support_value_fee'];?>:<span id="shipping_insure_fee">
	<?php if($svcart['shipping']['insure_fee']>0){?>
	<?php echo $svshow->price_format($svcart['shipping']['insure_fee'],$SVConfigs['price_format']);?>	
		<?if(isset($svcart['shipping']['insure_fee_confirm']) && $svcart['shipping']['insure_fee_confirm'] > 0){?>
		<a href="javascript:confirm_insure_fee(<?=$svcart['shipping']['shipping_id']?>,<?=$svcart['shipping']['insure_fee']?>,2);"><?=$html->image('no.gif',array('title'=>'取消保价','alt'=>'取消保价'))?></a>
		<?}else{?>
		<a href="javascript:confirm_insure_fee(<?=$svcart['shipping']['shipping_id']?>,<?=$svcart['shipping']['insure_fee']?>,1);"><?=$html->image('yes.gif',array('title'=>'需要保价','alt'=>'取消保价'))?></a>
		<?}?>
	<?php }else{?>
		-
	<?php }?><span id="insure_fee_loading" style="display:none;"><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>
	</span>
</td>
</tr>
<tr class="list">
	<td width="58%" height="25" valign="middle" class="bewrite handel"><?php echo $svcart['shipping']['shipping_description'];?></td>
</tr>
</table>
<br />