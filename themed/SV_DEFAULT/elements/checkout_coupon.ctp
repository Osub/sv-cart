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
 * $Id: checkout_coupon.ctp 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice">
<tr class="list">
<td width="99%" height="25" valign="middle" class="bewrite handel">
<div class="btn_list" style="padding-top:10px;">
<p class="float_l" style="padding:1px 4px 0 0;*margin-top:-2px;">
<?php if(isset($coupons) && sizeof($coupons)>0){?>
<?php echo $SCLanguages['choose_exist_coupon'];?>
	<select id='select_coupon' name='select_coupon' onchange="javascript:selectcoupon();" autocomplete="off">
		<option value="<?php echo $SCLanguages['please_choose']?>" selected="selected"><?php echo $SCLanguages['please_choose']?></option>
		<?php foreach($coupons as $k=>$v){?>
		<option value="<?php echo $v['Coupon']['id']?>"><?php echo $v['Coupon']['name']?> [<?php echo $svshow->price_format($v['Coupon']['fee'],$SVConfigs['price_format']);?>]</option>
		<?php }?>
	</select>
<?php }?>
<?php echo $SCLanguages['or_enter_coupon_serial'];?>: 
<input type="text" name="use_coupon" id="use_coupon"  value="" />
</p><a href="javascript:usecoupon();" class="float_l"><span><?php echo $SCLanguages['confirm']?></span></a>
<span class="float_l" style="padding:2px 0 0 4px;"><font color="red" id='coupon_error_msg'></font></span>
</div>
</tr>
</table>