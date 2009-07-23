<?php 
/*****************************************************************************
 * SV-Cart 结算页加备注
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_remark_confirm.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice">
<tr class="list">
<td width="34%" height="25" valign="middle" class="bewrite">
<div class="btn_list" style="padding-top:10px;">
<p class="float_l" style="padding:1px 4px 0 20px;*margin-top:-2px;">
<?php echo $svcart['order_remark']?></p><br/><br/><br/><br/>
<span id="remark_msg" style='padding:1px 4px 0 20px;*margin-top:-2px;color:red'></span>
<div style="padding:2px 4px 0 160px;*margin-top:-2px;">
</div>
</div>
</td>
<td width="36%" height="25" valign="middle" class="bewrite">如果您对订单有什么其他要求<br />可以在这增加备注<br/>
</tr>
</table>
<br />