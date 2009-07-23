<?php 
/*****************************************************************************
 * SV-Cart 选支付方式
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: confirm_payment.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
ob_start();?>
<?php if($result['type'] == 0 ){?>
<p class="address btn_list">
<span class="l"></span><span class="r"></span>
<a href="javascript:change_payment()" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a>
<?php echo $SCLanguages['payment'];?>:
</p>
<?php echo $this->element('checkout_payment_confirm', array('cache'=>'+0 hour'));?>
<?php }else{?>
<div id="loginout">
	<h1><b style="font-size:14px"><?php echo $SCLanguages['payment'];?></b></h1>
	<div class="border_side">
	<p class="login-alettr">
 	<?php echo $html->image('icon-10.gif',array("align"=>"middle"));?>
	<b>
<?php echo $result['message'];?></b></p>
		<br/>
		<p class="btns">
			<a href="javascript:close_message();"><?php echo $html->image('loginout-btn_right.gif');?><?php echo $SCLanguages['confirm'];?></a>
		</p>
	</div>
	<p><?php echo $html->image("loginout-bottom.gif",array("align"=>"texttop"))?></p>
</div>
<?php }?>
<?php 
$result['checkout_payment'] = ob_get_contents();
ob_end_clean();
?>
<?php ob_start();?>
<?php if($result['type'] == 0 ){?>
<?php echo $this->element('checkout_total', array('cache'=>'+0 hour'));?>
<?php }else{?>

<?php }?>
<?php 
$result['checkout_total'] = ob_get_contents();
ob_end_clean();
?>
<?php 
echo json_encode($result);
?>