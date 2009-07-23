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
 * $Id: checkout_remark.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice" style="width:97.5%;">
<tr class="list">
<td width="34%" height="25" valign="middle" class="bewrite">
<div class="btn_list" style="padding-top:10px;">
<span id="order_note_value" style="display:none"></span>
<span id="order_note_textarea">
<textarea name="order_note" rows="3" id="order_note_add" class="green_border" style="width:90%;overflow-y:scroll;vertical-align:top" onblur="javascript:add_remark();" ></textarea>
</span>

<p id="remark_msg" style='padding:1px 4px 0 20px;*margin-top:-2px;color:red'><br /></p>
</div>
</td>
<td width="36%" height="25" valign="middle" class="handel">
	<div valign="middle"  style="padding-left:20px;"><?php echo $SCLanguages['if_requirements_in_orders']?><br/><?php echo $SCLanguages['remark_here']?></div></td>
</tr>
</table>