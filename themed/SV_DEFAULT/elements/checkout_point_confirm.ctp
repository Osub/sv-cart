<?php 
/*****************************************************************************
 * SV-Cart 结算页确定使用积分
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_point_confirm.ctp 3674 2009-08-17 10:05:24Z huangbo $
*****************************************************************************/
?>
	
<h5>
<a href="javascript:change_point()" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a>
<?php echo $SCLanguages['use'].$SCLanguages['point'];?>: 
<span class="over_cont">
	<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
<?php printf($SCLanguages['avliable_point'],$svcart['point']['point']);?>  ， <?php printf($SCLanguages['can_offset_fee'],$svshow->price_format($svcart['point']['fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']));?>
	<?php }else{?>
<?php printf($SCLanguages['avliable_point'],$svcart['point']['point']);?>  ， <?php printf($SCLanguages['can_offset_fee'],$svshow->price_format($svcart['point']['fee'],$this->data['configs']['price_format']));?>
	<?php }?>			
&nbsp;&nbsp;&nbsp;<?//php echo $svcart['payment']['payment_description'];?>
</span>

</h5>