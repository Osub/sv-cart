<?php 
/*****************************************************************************
 * SV-Cart 结算页使用积分
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_point.ctp 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice">
<tr class="list">
<td width="34%" height="25" valign="middle" class="bewrite">
<div class="btn_list" style="padding-top:10px;">
<p class="float_l" style="padding:1px 4px 0 0;*margin-top:-2px;"><?php printf($SCLanguages['can_use_point'],$user_info['User']['point']);?>:
<input type="text" name="use_point" id="use_point" onKeyUp="is_int(this);" value="" />
</p><a href="javascript:usepoint(<?php echo $user_info['User']['point']?>,<?php echo $can_use_point?>)" class="float_l"><span><?php echo $SCLanguages['confirm']?></span></a>
<span class="float_l" style="padding:2px 0 0 4px;"><font color="red" id='point_error_msg'></font>	</span>
</div>
</td>
<td width="36%" height="25" valign="middle" class="bewrite handel">
<?php printf($SCLanguages['order_max_point'],$can_use_point);?>，<?php printf($SCLanguages['hundred_point'],$SVConfigs['conversion_ratio_point']);?>
</td>
</tr>
</table>