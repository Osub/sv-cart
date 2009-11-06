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
 * $Id: checkout_payment.ctp 4661 2009-09-28 05:31:13Z huangbo $
*****************************************************************************/
?>
<table cellpadding="0" cellspacing="0" class="address_list" width="100%">
<tbody>
<tr class="send_title bgcolor_e">
	<td height="25" align="center"><?php echo $SCLanguages['apellation'];?></td>
	<td height="25" align="center"><?php echo $SCLanguages['description'];?></td>
	<td height="25" align="center" class="handel"><?php echo $SCLanguages['procedure_fee'];?></td>
</tr>
</tbody>
<tbody>
<?php if(isset($payments) && sizeof($payments)>0){?>
<?php foreach($payments as $k=>$v){ ?>
<?php if($v['Payment']['code'] != "account_pay"){?>
<?php if(isset($svcart['cart_info']['all_virtual']) && $svcart['cart_info']['all_virtual'] == 1){?>
<?php if($v['Payment']['is_cod'] == 0){?>
<?php if($v['PaymentI18n']['status'] == 1 && $v['Payment']['order_use_flag'] == 1 ){?>
<tr class="list">
	<td width="34%" height="25" valign="top" class="selece_input">
	<span class="select_input"><input type="radio" name="payment_id" value="<?php echo $v['Payment']['id']; ?>" onclick="confirm_payment(<?php echo $v['Payment']['id'];?>)" style='margin:0 0 0 0;*margin:-2px 0 0 0;vertical-align:middle;' /></span><span class="name"><?php echo $v['PaymentI18n']['name']; ?></span></td>
	<td width="57%" height="25" valign="top" class="bewrite"><?php echo $v['PaymentI18n']['description']; ?></td>
	<td width="9%" height="25" align="center" valign="top" class="handel">
	<?//php echo $svshow->price_format($v['Payment']['fee'],$SVConfigs['price_format']);?>
	
	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php echo $svshow->price_format($v['Payment']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
	<?php }else{?>
		<?php echo $svshow->price_format($v['Payment']['fee'],$this->data['configs']['price_format']);?>	
	<?php }?>		
	
		
	</td>
</tr>
<?php }?>	
<?php }?>
<?php }else{?>
<?php if($v['PaymentI18n']['status'] == 1 && $v['Payment']['order_use_flag'] == 1 && ($v['Payment']['is_cod'] == 0 || (!isset($_SESSION['svcart']['shipping']['support_cod']) || $_SESSION['svcart']['shipping']['support_cod'] == 1))){?>
<tr class="list">
	<td width="34%" height="25" valign="top" class="selece_input">
	<span class="select_input"><input type="radio" name="payment_id" value="<?php echo $v['Payment']['id']; ?>" onclick="confirm_payment(<?php echo $v['Payment']['id'];?>)" id="payment_id<?php echo $v['Payment']['id']; ?>" class='radio' /></span><label for="payment_id<?php echo $v['Payment']['id']; ?>"><span class="name"><?php echo $v['PaymentI18n']['name']; ?></span></label></td>
	<td width="57%" height="25" valign="top" class="bewrite"><?php echo $v['PaymentI18n']['description']; ?></td>
	<td width="9%" height="25" align="center" valign="top" class="handel">
	<?//php echo $svshow->price_format($v['Payment']['fee'],$SVConfigs['price_format']);?>
	
	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php echo $svshow->price_format($v['Payment']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
	<?php }else{?>
		<?php echo $svshow->price_format($v['Payment']['fee'],$this->data['configs']['price_format']);?>	
	<?php }?>	
	
	<?php }?>	
	</td>
</tr>
<?php }?>
<?php }else{?>
	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1){?>
		<?php 	
				eval($v['Payment']['config']);
				if(@isset($payment_arr['use_currency_code']['value']) && $payment_arr['use_currency_code']['value'] == $session->read('currencies')){
					$pay_can_use = 1;
				}else{
					$pay_can_use = 0;
				}
		?>
	<?php }else{				
		$pay_can_use = 0;
	}?>	
<?php if(isset($SVConfigs['enable_balance']) && $SVConfigs['enable_balance'] != 0){?>
<?php if($pay_can_use == 1 && $v['PaymentI18n']['status'] == 1 && $v['Payment']['order_use_flag'] == 1 && ($v['Payment']['is_cod'] == 0 || (!isset($_SESSION['svcart']['shipping']['support_cod']) || $_SESSION['svcart']['shipping']['support_cod'] == 1))){?>
<tr class="list">
	<td width="34%" height="25" valign="top" class="selece_input">
	<span class="select_input"><input type="radio" name="payment_id" value="<?php echo $v['Payment']['id']; ?>" onclick="confirm_payment(<?php echo $v['Payment']['id'];?>)" style='margin:0 0 0 0;*margin:-2px 0 0 0;vertical-align:middle;' /></span><span class="name"><?php echo $v['PaymentI18n']['name']; ?></span></td>
	<td width="57%" height="25" valign="top" class="bewrite"><?php echo $v['PaymentI18n']['description']; ?></td>
	<td width="9%" height="25" align="center" valign="top" class="handel">
	<?//php echo $svshow->price_format($v['Payment']['fee'],$SVConfigs['price_format']);?>	
	
	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php echo $svshow->price_format($v['Payment']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
	<?php }else{?>
		<?php echo $svshow->price_format($v['Payment']['fee'],$this->data['configs']['price_format']);?>	
	<?php }?>		
	
	</td>
</tr>
<?php }?><?php }?>
<?php }?>
<?php }}?>
</tbody>
</table>