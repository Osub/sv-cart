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
 * $Id: checkout_point_confirm.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice">
<tr class="list">
<td width="29%" height="25" valign="middle" class="selece_input">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php printf($SCLanguages['avliable_point'],$svcart['point']['point']);?>  ， <?php printf($SCLanguages['can_offset_fee'],$svcart['point']['fee']);?>
</td>
<td width="41%" height="25" valign="middle" class="bewrite"><?php printf($SCLanguages['can_use_point'],$user_info['User']['point']);?>,<?php printf($SCLanguages['order_max_point'],$can_use_point);?></td>
<td width="14%" height="25" align="center" valign="middle" class="addrees"><?php printf($SCLanguages['hundred_point'],$SVConfigs['conversion_ratio_point']);?>
</td>
</tr>
</table>
<br />