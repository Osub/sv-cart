<?php
/*****************************************************************************
 * SV-Cart 忘记密码
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: forget_password.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
ob_start();?>
<div id="loginout">
	<h1><b>忘记密码</b></h1>
	<div class="order_stat athe_infos tongxun" >
	<div id="buyshop_box">
	<br /><br />
		<dl><dt><b class="green_2">管理员姓名:</b></dt><dd>&nbsp;<input type="text"  id="name" class="text_input" /></dd></dl>
		<dl><dt><b class="green_2">管理员Email:</b></dt><dd>&nbsp;<input type="text"  id="email" class="text_input" /><br /><br /></dd></dl>
		<br />
		<p class="buy_btn mar"><?=$html->link("取消","javascript:close_message();");?>
		<?=$html->link("确定","javascript:find_password();",array('name'=>'confirm'));?></p>
	</div>
	<p><?=$html->image("loginout-bottom.gif");?></p>
	</div>
</div>
<?
$result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>