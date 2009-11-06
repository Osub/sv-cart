<?php 
/*****************************************************************************
 * SV-Cart 结算页配送方式选定
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_shipping_confirm.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
?>
<h5>
<?php if(!isset($svcart['shipping']['not_show_change']) || $svcart['shipping']['not_show_change'] == '0'){?><a href="javascript:change_shipping();" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a><?php }?>
<?php echo $SCLanguages['shipping_method'];?>:
<span class="over_cont">
<strong><?php echo $svcart['shipping']['shipping_name'];?></strong>&nbsp;&nbsp;
<?php echo $SCLanguages['shipping_fee'];?>:<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php echo $svshow->price_format($svcart['shipping']['shipping_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
	<?php }else{?>
		<?php echo $svshow->price_format($svcart['shipping']['shipping_fee'],$this->data['configs']['price_format']);?>	
	<?php }?>
&nbsp;&nbsp;&nbsp;<?php echo $SCLanguages['free'].$SCLanguages['limit'];?>:<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php echo $svshow->price_format($svcart['shipping']['free_subtotal']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
	<?php }else{?>
		<?php echo $svshow->price_format($svcart['shipping']['free_subtotal'],$this->data['configs']['price_format']);?>	
	<?php }?>
&nbsp;&nbsp;&nbsp;<?php echo $SCLanguages['support_value_fee'];?>:<span id="shipping_insure_fee"><?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php echo $svshow->price_format($svcart['shipping']['insure_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
	<?php }else{?>
		<?php echo $svshow->price_format($svcart['shipping']['insure_fee'],$this->data['configs']['price_format']);?>	
	<?php }?>		
&nbsp;&nbsp;&nbsp;<?php if($svcart['shipping']['insure_fee']>0){?>
	<?//php echo $svshow->price_format($svcart['shipping']['insure_fee'],$SVConfigs['price_format']);?>	
		<?if(isset($svcart['shipping']['insure_fee_confirm']) && $svcart['shipping']['insure_fee_confirm'] > 0){?>
		<a href="javascript:confirm_insure_fee(<?=$svcart['shipping']['shipping_id']?>,<?=$svcart['shipping']['insure_fee']?>,2);"><?=$html->image('no.gif',array('title'=>'取消保价','alt'=>'取消保价'))?></a>
		<?}else{?>
		<a href="javascript:confirm_insure_fee(<?=$svcart['shipping']['shipping_id']?>,<?=$svcart['shipping']['insure_fee']?>,1);"><?=$html->image('yes.gif',array('title'=>'需要保价','alt'=>'取消保价'))?></a>
		<?}?>
	<?php }else{?>
		-
	<?php }?><span id="insure_fee_loading" style="display:none;"><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>
<?//php echo $svcart['shipping']['shipping_description'];?>
</span>
</h5>