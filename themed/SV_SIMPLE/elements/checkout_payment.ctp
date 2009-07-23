<?php 
/*****************************************************************************
 * SV-Cart 结算页支付方式
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_payment.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" width="874">
<tbody>
<tr class="send_title bgcolor_e">
<td height="25" align="center"><?php echo $SCLanguages['name'];?></td><td height="25" align="center"><?php echo $SCLanguages['description'];?></td><td height="25" align="center" class="handel"><?php echo $SCLanguages['cost'];?></td>
</tr>
</tbody>
<tbody>
<?php if(isset($payments) && sizeof($payments)>0){?>
<?php foreach($payments as $k=>$v){ ?>
<?php if($v['Payment']['code'] != "account_pay"){?>
<?php if(isset($svcart['cart_info']['all_virtual']) && $svcart['cart_info']['all_virtual'] == 1){?>
<?php if($v['Payment']['is_cod'] == 0){?>
<?php if($v['PaymentI18n']['status'] == 1 && $v['Payment']['order_use_flag'] == 1){?>
<tr class="list">
<td width="29%" height="25" valign="middle" class="selece_input">
<span class="select_input"> 
<input type="radio" name="payment_id" value="<?php echo $v['Payment']['id']; ?>"	<?php 
	if(isset($svcart['payment']['payment_id']) && $svcart['payment']['payment_id'] == $v['Payment']['id']){
		echo "checked";
	}		
	
	if((!isset($SVConfigs['use_ajax'])) || $SVConfigs['use_ajax'] == 1){?>
 onclick="confirm_payment(<?php echo $v['Payment']['id'];?>)"<?php }?> style='margin:0 0 0 0;*margin:-2px 0 0 0;vertical-align:middle;' /></span>

<span class="name"><?php echo $v['PaymentI18n']['name']; ?></span></td>
<td width="54%" height="25" valign="middle" class="bewrite"><?php echo $v['PaymentI18n']['description']; ?></td>
<td width="17%" height="25" align="center" valign="middle" class="handel">
<?php echo $svshow->price_format($v['Payment']['fee'],$SVConfigs['price_format']);?>	
</td>
</tr>
<?php }?>	
<?php }?>
<?php }else{?>
<?php if($v['PaymentI18n']['status'] == 1 && $v['Payment']['order_use_flag'] == 1){?>
<tr class="list">
<td width="29%" height="25" valign="middle" class="selece_input">
<span class="select_input">
<input type="radio" name="payment_id" value="<?php echo $v['Payment']['id']; ?>" 
		
	<?php 
	if(isset($svcart['payment']['payment_id']) && $svcart['payment']['payment_id'] == $v['Payment']['id']){
		echo "checked";
	}		
		if((!isset($SVConfigs['use_ajax'])) || $SVConfigs['use_ajax'] == 1){?>	onclick="confirm_payment(<?php echo $v['Payment']['id'];?>)" 
	<?php }?>
	id="payment_id<?php echo $v['Payment']['id']; ?>" class='radio' /></span>
<label for="payment_id<?php echo $v['Payment']['id']; ?>"><span class="name"><?php echo $v['PaymentI18n']['name']; ?></span></label></td>
<td width="54%" height="25" valign="middle" class="bewrite"><?php echo $v['PaymentI18n']['description']; ?></td>
<td width="17%" height="25" align="center" valign="middle" class="handel">
<?php echo $svshow->price_format($v['Payment']['fee'],$SVConfigs['price_format']);?>
<?php }?>	
</td>
</tr>
<?php }?>
<?php }else{?>
<?php if(isset($SVConfigs['enable_balance']) && $SVConfigs['enable_balance'] != 0){?>
<?php if($v['PaymentI18n']['status'] == 1 && $v['Payment']['order_use_flag'] == 1){?>
<tr class="list">
<td width="29%" height="25" valign="middle" class="selece_input">
<span class="select_input"> 
<input type="radio" name="payment_id" value="<?php echo $v['Payment']['id']; ?>" 
	<?php 
	if(isset($svcart['payment']['payment_id']) && $svcart['payment']['payment_id'] == $v['Payment']['id']){
		echo "checked";
	}		
	if((!isset($SVConfigs['use_ajax'])) || $SVConfigs['use_ajax'] == 1){?>	onclick="confirm_payment(<?php echo $v['Payment']['id'];?>)"
	<?php }?>
	 style='margin:0 0 0 0;*margin:-2px 0 0 0;vertical-align:middle;' /></span>
<span class="name"><?php echo $v['PaymentI18n']['name']; ?></span></td>
<td width="54%" height="25" valign="middle" class="bewrite"><?php echo $v['PaymentI18n']['description']; ?></td>
<td width="17%" height="25" align="center" valign="middle" class="handel">
<?php echo $svshow->price_format($v['Payment']['fee'],$SVConfigs['price_format']);?>	
</td>
</tr>
<?php }?><?php }?>
<?php }?>
<?php }}?>
</tbody>
</table>