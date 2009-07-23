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
 * $Id: checkout_coupon.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" id="checkout_shipping_choice">
<tr class="list">
<td width="99%" height="25" valign="middle" class="bewrite">
<div class="btn_list" style="padding-top:10px;">
<p class="float_l" style="padding:1px 4px 0 20px;*margin-top:-2px;">
<?php if(isset($coupons) && sizeof($coupons)>0){?>
<?php echo $SCLanguages['choose_exist_coupon'];?>
	<select id='select_coupon' name='select_coupon' 
		<?php if((!isset($SVConfigs['use_ajax'])) || $SVConfigs['use_ajax'] == 1){?>

	onchange="javascript:selectcoupon();" <?php }?>autocomplete="off">
		<option value="<?php echo $SCLanguages['please_choose']?>" <?php if(!isset($svcart['coupon']['is_id'])){?>selected="selected"<?php }?>><?php echo $SCLanguages['please_choose']?></option>
		<?php foreach($coupons as $k=>$v){?>
		<option value="<?php echo $v['Coupon']['id']?>" <?php if(isset($svcart['coupon']['is_id']) && isset($svcart['coupon']['coupon']) && $svcart['coupon']['coupon'] == $v['Coupon']['id']){?>selected="selected"<?php }?>><?php echo $v['Coupon']['name']?> [<?php echo $svshow->price_format($v['Coupon']['fee'],$SVConfigs['price_format']);?>]</option>
		<?php }?>
	</select>
<?php }?>
<?php echo $SCLanguages['or_enter_coupon_serial'];?>
<input type="text" name="use_coupon" id="use_coupon"  value="<?php if(!isset($svcart['coupon']['is_id']) && isset($svcart['coupon']['sn_code'])){ echo $svcart['coupon']['sn_code'];}?>" />
</p>	<?php if((!isset($SVConfigs['use_ajax'])) || $SVConfigs['use_ajax'] == 1){?>
<a href="javascript:usecoupon();" class="float_l"><span><?php echo $SCLanguages['confirm']?></span></a><?php }?>
<span class="float_l" style="padding:2px 0 0 4px;"><font color="red" id='coupon_error_msg'></font></span>
</div>
</tr>
</table>