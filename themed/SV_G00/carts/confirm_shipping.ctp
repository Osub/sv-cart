<?php
/*****************************************************************************
 * SV-Cart 选配送方式
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: confirm_shipping.ctp 1028 2009-04-24 12:23:26Z huangbo $
*****************************************************************************/
ob_start();?>
<?if($result['type'] == 0 ){?>
<p class="address btn_list" id="address_btn_list">
<span class="l"></span><span class="r"></span>
<a href="javascript:change_shipping();" class="amember"><span><?=$SCLanguages['mmodify']?></span></a>
<?php echo $SCLanguages['shipping_method'];?>:</p>
<? echo $this->element('checkout_shipping_confirm', array('cache'=>'+0 hour'));?>
<?}else{?>
<div id="loginout">
	<h1><b style="font-size:14px"><?=$SCLanguages['shipping_method'];?></b></h1>
	<div class="border_side">
	<p class="login-alettr"> 	<?=$html->image('icon-10.gif',array("align"=>"middle"));?>
<b>
<?echo $result['message'];?></b></p>
		<br/>
		<p class="btns">
			<a href="javascript:close_message();"><?=$html->image('loginout-btn_right.gif');?><?=$SCLanguages['confirm'];?></a>
		</p>
	</div>
	<p><?=$html->image("loginout-bottom.gif",array("align"=>"texttop"))?></p>
</div>

<?}?>
<?
$result['checkout_shipping'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
<?if($result['type'] == 0 ){?>
<? echo $this->element('checkout_total', array('cache'=>'+0 hour'));?>
<?}else{?>

<?}?>
<?
$result['checkout_total'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>