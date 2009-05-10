<?php
/*****************************************************************************
 * SV-Cart ajax登录成功
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: login_ajax_successful.ctp 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/

if(isset($user_info)){
ob_start();?>
<div id="loginout">
		<h1><b><?=$SCLanguages['user_log_in_successfully'];?></b></h1>
	<div style="border-left:1px solid #909592;border-right:1px solid #909592;background:#fff">
		<p class="login-alettr">
	<?=$html->image('icon-10.gif',array("align"=>"middle"));?>
	
	<b><?=$SCLanguages['welcome'];?>，<? echo $user_info['User']['name']; ?>！</b> <br /></p>
		<p class="btns">
			<?=$html->link($html->image('loginout-btn_right.gif').$SCLanguages['continue'],"javascript:window.location.reload();","",false,false);?>
			<?=$html->link($html->image('loginout-btn_right.gif').$SCLanguages['user_center'],"/","",false,false);?>
			<?=$html->link($html->image('loginout-btn_right.gif').$SCLanguages['home'],"../../","",false,false);?>
		</p>
	</div>
	<p><?=$html->image('loginout-bottom.gif')?></p>
</div>
<?$result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
}
?>