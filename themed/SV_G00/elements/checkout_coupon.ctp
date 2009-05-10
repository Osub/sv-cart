<?php
/*****************************************************************************
 * SV-Cart 结算页使用优惠券
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_point.ctp 887 2009-04-22 10:46:25Z shenyunfeng $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice">
<tr class="list">
<td width="99%" height="25" valign="middle" class="bewrite">
<div class="btn_list" style="padding-top:10px;">
<p class="float_l" style="padding:1px 4px 0 20px;*margin-top:-2px;">
<?if(isset($coupons) && sizeof($coupons)>0){?>
<?=$SCLanguages['choose_exist_coupon'];?>
	<select id='select_coupon' name='select_coupon' onchange="javascript:selectcoupon();" autocomplete="off">
		<option value="<?=$SCLanguages['please_choose']?>" selected="selected"><?=$SCLanguages['please_choose']?></option>
		<?foreach($coupons as $k=>$v){?>
		<option value="<?=$v['Coupon']['id']?>"><?=$v['Coupon']['name']?> [<?=$svshow->price_format($v['Coupon']['fee'],$SVConfigs['price_format']);?>]</option>
		<?}?>
	</select>
<?}?>
<?=$SCLanguages['or_enter_coupon_serial'];?>
<input type="text" name="use_coupon" id="use_coupon"  value="" />
</p><a href="javascript:usecoupon();" class="float_l"><span><?=$SCLanguages['confirm']?></span></a>
<span class="float_l" style="padding:2px 0 0 4px;"><font color="red" id='coupon_error_msg'></font></span>
</div>
</tr>
</table>