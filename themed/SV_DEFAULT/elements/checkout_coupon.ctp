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
 * $Id: checkout_coupon.ctp 4661 2009-09-28 05:31:13Z huangbo $
*****************************************************************************/
?>
<h5>
<dl>
	<dt style="padding-top:3px;width:80px;"><strong><?php echo $SCLanguages['use'].$SCLanguages['coupon'];?>:</strong></dt>
	<dd style="padding-right:4px;"><input type="text" name="use_coupon" id="use_coupon"  value="" onblur="javascript:usecoupon();" /></dd>
	<dd class="btn_list" style="margin-top:-1px;*margin-top:0;"><div style="display:none;"><a href="javascript:usecoupon();" class="float_l"><span><?php echo $SCLanguages['confirm']?></span></a></div><span class="float_l" style="padding:2px 0 0 4px;"><font color="red" id='coupon_error_msg'></font></span>
</dd>
	<dt class="over_cont" style="padding-top:3px;">&nbsp;
	<?php echo $SCLanguages['or_enter_coupon_serial'];?>
	<?php if(isset($coupons) && sizeof($coupons)>0){?>|
<?php echo $SCLanguages['choose_exist_coupon'];?>
	<select id='select_coupon' name='select_coupon' onchange="javascript:selectcoupon();" autocomplete="off">
		<option value="<?php echo $SCLanguages['please_choose']?>" selected="selected"><?php echo $SCLanguages['please_choose']?></option>
		<?php foreach($coupons as $k=>$v){?>
		<option value="<?php echo $v['Coupon']['id']?>"><?php echo $v['Coupon']['name']?> [
			<?//php echo $svshow->price_format($v['Coupon']['fee'],$SVConfigs['price_format']);?>
			
	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php echo $svshow->price_format(round($v['Coupon']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],2),$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
	<?php }else{?>
		<?php echo $svshow->price_format($v['Coupon']['fee'],$this->data['configs']['price_format']);?>	
	<?php }?>			
			
			]</option>
		<?php }?>
	</select>
<?php }?>
</dt>
</dl>
</h5>
