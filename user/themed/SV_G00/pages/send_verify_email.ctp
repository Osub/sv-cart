<?php
/*****************************************************************************
 * SV-Cart 发送验证邮件成功
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: send_verify_email.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
	ob_start();
?>
<div id="loginout">
	<h1><b style="font-size:14px"><?=$SCLanguages['send_confirm_mail']?></b></h1>
	<div style="border-left:1px solid #909592;border-right:1px solid #909592;background:#fff">
		<p class="login-alettr">
	<?=$html->image('icon-10.gif',array("align"=>"middle"));?>
	<b><?echo $result['msg']?></b></p><br/>
		<p class="btns">
		<?=$html->link($html->image('loginout-btn_right.gif').$SCLanguages['confirm'],"/",array(),false,false);?>
		</p>
	</div>
		<?=$html->image('loginout-bottom.gif',array("align"=>"texttop"));?>
</div>

<?php
	 $result['content'] = ob_get_contents();
	 ob_end_clean();
	 echo json_encode($result);
?>