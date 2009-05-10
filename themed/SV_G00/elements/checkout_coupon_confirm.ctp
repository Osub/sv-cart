<?php
/*****************************************************************************
 * SV-Cart 结算页确定使用积分
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_point_confirm.ctp 1080 2009-04-27 11:10:00Z zhangshisong $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice">
<tr class="list">
<td width="29%" height="25" valign="middle" class="selece_input">
<?=$SCLanguages['use']?><?=$SCLanguages['coupon']?> :<?=$svcart['coupon']['sn_code']?>， <?printf($SCLanguages['can_offset_fee'],$svcart['coupon']['fee']);?>
<?if($svcart['coupon']['discount'] < 100){?>
<?=$SCLanguages['coupon']?><?=$SCLanguages['discount']?>:<?=$svcart['coupon']['discount']?>
<?}?>
</td>
</tr>
</table>
<br />