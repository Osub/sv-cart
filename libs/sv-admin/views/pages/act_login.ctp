<?php
/*****************************************************************************
 * SV-Cart 执行登录
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: act_login.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
ob_start();?>
<div id="loginout">
	<h1><b>系统提示</b></h1>
	<div class="order_stat athe_infos tongxun">
	<div id="buyshop_box">
		<p class="login-alettr"><?php if(isset($result['error_msg'])) echo $result['error_msg'];?></p>
		<br />
		<p class="buy_btn mar" style="padding-right:75px;"><?=$html->link("关闭","javascript:close_message();");?></p>
	
	</div>
	<p><?=$html->image("loginout-bottom.png");?></p>
	</div>
</div>


<?
$result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>