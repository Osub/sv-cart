<?php 
/*****************************************************************************
 * SV-Cart 结算页支付方式选定
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_payment_confirm.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" width="874">
<tbody>
<tr class="bgcolor_e">
<td width="29%" colspan="2" height="25" valign="middle" class="handel"><span class="name">	<b><?php echo $svcart['payment']['payment_name'];?></b></span></td>
</tr>
<tr class="list">
<td width="54%" height="25" valign="middle" class="bewrite"><?php echo $svcart['payment']['payment_description'];?></td>
<td width="17%" align="center" valign="middle" class="handel">
<?php echo $svshow->price_format($svcart['payment']['payment_fee'],$SVConfigs['price_format']);?>	
</td>
</tr>
</tbody>
</table>