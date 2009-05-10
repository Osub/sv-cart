<?php
/*****************************************************************************
 * SV-Cart 充值
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: balance_deposit.ctp 1162 2009-04-30 11:17:42Z huangbo $
*****************************************************************************/
ob_start();
?>
<div id="loginout">
	<h1><b style="font-size:14px"><?=$SCLanguages['supply'];?></b></h1>
	<div style="border-left:1px solid #909592;border-right:1px solid #909592;background:#fff">
	<div class="login-alettr"><?=$html->image('icon-10.gif');?>
	<?php echo $result['msg']?>
	<?if(isset($pay_button)){?>
	<br /><br /><input type="button" onclick="window.open('<?php echo $pay_button; ?>')" value="<?=$SCLanguages['alipay_pay_immedia']?>" />
	<?}?>
	<?if(isset($pay_form)){?>
		<br /><?=$pay_form?>
	<?}?>
	<?if(isset($pay_message)){?>
		<b><?=$pay_message?></b>
	<?}?>
	</div>
		<p class="btns">
			<?=$html->link($html->image('loginout-btn_right.gif').$SCLanguages['confirm'],"javascript:window.location.reload();","",false,false);?>
		</p>
	</div>
	<p><?=$html->image("loginout-bottom.gif",array("align"=>"texttop"))?></p>
</div>

<?php	
	$result['content'] = ob_get_contents();
	ob_end_clean();
	echo json_encode($result);
?>