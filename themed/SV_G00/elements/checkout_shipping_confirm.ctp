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
 * $Id: checkout_shipping_confirm.ctp 1841 2009-05-27 06:51:37Z huangbo $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice">
<tr class="list bgcolor_e">
<td width="29%" height="25" valign="middle" colspan="4" class="handel"><span class="select_input"><b><?=$svcart['shipping']['shipping_name'];?></b>
</span></td>
</tr>
<tr class="list">

<td width="58%" height="25" valign="middle" class="bewrite"><?=$svcart['shipping']['shipping_description'];?></td>

<td width="14%" height="25" align="center" valign="middle" class="addrees">
	<?=$svshow->price_format($svcart['shipping']['shipping_fee'],$SVConfigs['price_format']);?>	
</td>
<td width="14%" align="center" valign="middle" class="addrees">
	<?=$svshow->price_format($svcart['shipping']['free_subtotal'],$SVConfigs['price_format']);?>	
</td>
<td width="14%" align="center" class="handel">
	<?if($svcart['shipping']['insure_fee']>0){?>
	<?=$svshow->price_format($svcart['shipping']['insure_fee'],$SVConfigs['price_format']);?>	
	<?}else{?>
		-
	<?}?>
</td>	
	
</tr>
</table>
<br />