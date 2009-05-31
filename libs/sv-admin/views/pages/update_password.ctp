<?php
/*****************************************************************************
 * SV-Cart 找回密码提示
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: update_password.ctp 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
ob_start();?>
<div id="loginout">
	<h1><b>系统提示</b></h1>
	<div class="order_stat athe_infos tongxun" >
	<div id="buyshop_box">
			<p class="login-alettr"><?=$result['msg'];?></p>
		<p class="buy_btn mar">
	<?=$html->link("返回","../login");?>
	<?if($result['type'] == 0){?>
	<?=$html->link("取消","../login");?>
	<?}else{?>
	<?=$html->link("取消","javascript:close_message();");?>
	<?}?>
	<p><?=$html->image("loginout-bottom.png");?></p>
	</div></div>
</div>
<?
$result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>