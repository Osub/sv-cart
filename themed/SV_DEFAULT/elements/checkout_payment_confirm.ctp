<?php 
/*****************************************************************************
 * SV-Cart 结算页支付方式选定
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_payment_confirm.ctp 4808 2009-10-09 10:05:22Z huangbo $
*****************************************************************************/
?>

<h5 style="border-bottom:1px solid;">
<?php if(!isset($svcart['payment']['not_show_change']) || $svcart['payment']['not_show_change'] == '0'){?>
<a href="javascript:change_payment()" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a>
<?php }?>
<?php echo $SCLanguages['payment'];?>:
<span class="over_cont" >
<strong><?php echo $svcart['payment']['payment_name'];?></strong>
&nbsp;&nbsp;&nbsp;<?php echo $SCLanguages['procedure_fee'];?>:
	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php echo $svshow->price_format($svcart['payment']['payment_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
	<?php }else{?>
		<?php echo $svshow->price_format($svcart['payment']['payment_fee'],$this->data['configs']['price_format']);?>	
	<?php }?>				
&nbsp;&nbsp;&nbsp;<?//php echo $svcart['payment']['payment_description'];?>
</span>

</h5>
