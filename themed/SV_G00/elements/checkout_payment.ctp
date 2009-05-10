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
 * $Id: checkout_payment.ctp 1232 2009-05-06 12:14:41Z huangbo $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" width="874">
<tbody>
<tr class="send_title bgcolor_e">
<td height="25" align="center"><?php echo $SCLanguages['name'];?></td><td height="25" align="center"><?php echo $SCLanguages['description'];?></td><td height="25" align="center" class="handel"><?php echo $SCLanguages['cost'];?></td>
</tr>
</tbody>
<tbody>
<?if(isset($payments) && sizeof($payments)>0){?>
<? foreach($payments as $k=>$v){ ?>
<?if($v['Payment']['code'] != "account_pay"){?>
<?if(isset($svcart['cart_info']['all_virtual']) && $svcart['cart_info']['all_virtual'] == 1){?>
<?if($v['Payment']['is_cod'] == 0){?>
<?if($v['PaymentI18n']['status'] == 1 && $v['Payment']['order_use_flag'] == 1){?>
<tr class="list">
<td width="29%" height="25" valign="middle" class="selece_input">
<span class="select_input"> 
<input type="radio" name="payment_id" value="<? echo $v['Payment']['id']; ?>" onclick="confirm_payment(<?=$v['Payment']['id'];?>,<?=$v['Payment']['fee'];?>,'<?=$v['PaymentI18n']['name']; ?>','<?=$v['PaymentI18n']['description']; ?>',<?=$v['Payment']['is_cod']?>,'<?=$v['Payment']['code']?>')" style='margin:0 0 0 0;*margin:-2px 0 0 0;vertical-align:middle;' /></span>
<span class="name"><? echo $v['PaymentI18n']['name']; ?></span></td>
<td width="54%" height="25" valign="middle" class="bewrite"><? echo $v['PaymentI18n']['description']; ?></td>
<td width="17%" height="25" align="center" valign="middle" class="handel">
<?=$svshow->price_format($v['Payment']['fee'],$SVConfigs['price_format']);?>	
</td>
</tr>
<?}?>	
<?}?>
<?}else{?>
<?if($v['PaymentI18n']['status'] == 1 && $v['Payment']['order_use_flag'] == 1){?>
<tr class="list">
<td width="29%" height="25" valign="middle" class="selece_input">
<span class="select_input">
<input type="radio" name="payment_id" value="<? echo $v['Payment']['id']; ?>" onclick="confirm_payment(<?=$v['Payment']['id'];?>,<?=$v['Payment']['fee'];?>,'<?=$v['PaymentI18n']['name']; ?>','<?=$v['PaymentI18n']['description']; ?>',<?=$v['Payment']['is_cod']?>,'<?=$v['Payment']['code']?>')" id="payment_id<? echo $v['Payment']['id']; ?>" class='radio' /></span>
<label for="payment_id<? echo $v['Payment']['id']; ?>"><span class="name"><? echo $v['PaymentI18n']['name']; ?></span></label></td>
<td width="54%" height="25" valign="middle" class="bewrite"><? echo $v['PaymentI18n']['description']; ?></td>
<td width="17%" height="25" align="center" valign="middle" class="handel">
<?=$svshow->price_format($v['Payment']['fee'],$SVConfigs['price_format']);?>
<?}?>	
</td>
</tr>
<?}?>
<?}else{?>
<?if(isset($SVConfigs['enable_balance']) && $SVConfigs['enable_balance'] != 0){?>
<?if($v['PaymentI18n']['status'] == 1 && $v['Payment']['order_use_flag'] == 1){?>
<tr class="list">
<td width="29%" height="25" valign="middle" class="selece_input">
<span class="select_input"> 
<input type="radio" name="payment_id" value="<? echo $v['Payment']['id']; ?>" onclick="confirm_payment(<?=$v['Payment']['id'];?>,<?=$v['Payment']['fee'];?>,'<?=$v['PaymentI18n']['name']; ?>','<?=$v['PaymentI18n']['description']; ?>',<?=$v['Payment']['is_cod']?>,'<?=$v['Payment']['code']?>')" style='margin:0 0 0 0;*margin:-2px 0 0 0;vertical-align:middle;' /></span>
<span class="name"><? echo $v['PaymentI18n']['name']; ?></span></td>
<td width="54%" height="25" valign="middle" class="bewrite"><? echo $v['PaymentI18n']['description']; ?></td>
<td width="17%" height="25" align="center" valign="middle" class="handel">
<?=$svshow->price_format($v['Payment']['fee'],$SVConfigs['price_format']);?>	
</td>
</tr>
<?}?><?}?>
<?}?>
<?}}?>
</tbody>
</table>