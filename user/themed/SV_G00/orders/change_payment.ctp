<?php
/*****************************************************************************
 * SV-Cart 修改配送方式
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: change_payment.ctp 1162 2009-04-30 11:17:42Z huangbo $
*****************************************************************************/

	ob_start();
?>
<div id="loginout">
	<h1><b style="font-size:14px"><?=$SCLanguages['mmodify'].$SCLanguages['payment'];?></b></h1>
	<div style="border-left:1px solid #909592;border-right:1px solid #909592;background:#fff">
		<p class="login-alettr"><?=$html->image("icon-10.gif",array("align"=>"middle"))?>
		<b>
		<?php echo $result['msg']?>
	<?if(isset($pay_button)){?>
	<p class="succeed">
	<input type="button" onclick="window.open('<?php echo $pay_button; ?>')" value="<?=$SCLanguages['alipay_pay_immedia']?>" />
	</p>
	<?}?>
	<?if(isset($pay_form)){?>
		<?=$pay_form?>
	<?}?>
	<?if(isset($pay_message)){?>
		<br/><?=$pay_message?>
	<?}?>
	
		</b></p>
		<br/>
		<p class="btns">
			<a href="javascript:window.location.reload();"><?=$html->image('loginout-btn_right.gif');?><?=$SCLanguages['confirm'];?></a>
		</p>
	</div>
	<p><?=$html->image("loginout-bottom.gif")?></p>
</div>

<?php	
	$result['content'] = ob_get_contents();
	ob_end_clean();
	echo json_encode($result);
?>