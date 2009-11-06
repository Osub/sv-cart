<?php 
/*****************************************************************************
 * SV-Cart 结算页确定开发票
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_point_confirm.ctp 3634 2009-08-14 07:52:08Z huangbo $
*****************************************************************************/
?>
<h5>
<a href="javascript:change_invoice()" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a>
<?php echo $SCLanguages['invoice'];?>:
<span class="over_cont">
<strong><?php echo $svcart['invoice']['invoice_type'];?> [ <?php echo $svcart['invoice']['tax_point'];?>% ]</strong>
&nbsp;&nbsp;&nbsp;<?php echo $SCLanguages['cost'];?>:
	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php echo $svshow->price_format($svcart['invoice']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
	<?php }else{?>
		<?php echo $svshow->price_format($svcart['invoice']['fee'],$this->data['configs']['price_format']);?>	
	<?php }?>				
&nbsp;&nbsp;&nbsp;
<?php echo $SCLanguages['invoice_title'];?>:<?php echo $svcart['invoice']['invoice_title'];?>
</span>

</h5>