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
 * $Id: order_pay.ctp 3779 2009-08-19 10:40:08Z huangbo $
*****************************************************************************/
ob_start();
?>
<div id="loginout" class="loginout">
	<h1><b style="font-size:14px"><?php echo $SCLanguages['pay'];?></b></h1>
	<div style="border-left:1px solid #909592;border-right:1px solid #909592;background:#fff">
	<p class="login-alettr">
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'icon-10.gif':'icon-10.gif',array("align"=>"middle"));?>
	
	<?php echo $result['msg']?>
	<?php if(isset($pay_button)){?>
	<input type="button" onclick="window.open('<?php echo $pay_button; ?>')" value="<?php echo $SCLanguages['alipay_pay_immedia']?>" />
	<?php }?>
	<?php if(isset($pay_form)){?>
		<b><?php echo $pay_form?></b>
	<?php }?>
	<?php if(isset($pay_message)){?>
		<br/><br/><b><?php echo $pay_message?></b>
	<?php }?></p>
		<br/>
		<p class="btns">
		<?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'loginout-btn_right.gif':'loginout-btn_right.gif').$SCLanguages['confirm'],"javascript:window.location.reload();",array(),false,false);?>
		</p>
	</div>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif",array("align"=>"texttop"))?></p>
</div>

<?php 	
	$result['content'] = ob_get_contents();
	ob_end_clean();
	echo json_encode($result);
?>