<?php
/*****************************************************************************
 * SV-Cart ajax结算验证
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_order.ctp 1028 2009-04-24 12:23:26Z huangbo $
*****************************************************************************/
ob_start();?>
<?if($result['type'] != 0){?>
<div id="loginout">
	<h1><b style="font-size:14px"><?=$SCLanguages['order_generated'].$SCLanguages['failed'];?></b></h1>
	<div class="border_side">
	<p class="login-alettr">	<?=$html->image("warning_img.gif",array("align"=>"middle","alt"=>$SCLanguages['order_generated'].$SCLanguages['failed']))?>
<b>
	<?=$SCLanguages['order_generated'].$SCLanguages['failed']?></b>
	<br />	<br />
	<?=$SCLanguages['notice'];?>：
	<?foreach($error_arr as $error){?>
	<?=$error?>
	<?}?>	
</p>
		<p class="btns" style="padding-right:150px;">
			<a href="javascript:close_message();"><?=$html->image('loginout-btn_right.gif');?><?=$SCLanguages['confirm'];?></a>
		</p>
	</div>
	<p><?=$html->image("loginout-bottom.gif",array("align"=>"texttop"))?></p>
</div>
<?}?>
<?
$result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>