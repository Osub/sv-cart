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
 * $Id: login_ajax_successful.ctp 3134 2009-07-21 06:45:45Z huangbo $
*****************************************************************************/

if(isset($user_info)){
ob_start();?>
<iframe style="display:none" src="user/pages/uclogin/<?php echo $uid;?>" > </iframe> 
<div id="loginout">
		<h1><b><?php echo $SCLanguages['user_log_in_successfully'];?></b></h1>
	<div style="border-left:1px solid #909592;border-right:1px solid #909592;background:#fff">
		<p class="login-alettr">
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'icon-10.gif':'icon-10.gif',array("align"=>"middle"));?>
	
	<b><?php echo $SCLanguages['welcome'];?>，<?php echo $user_info['User']['name']; ?>！</b> <br /></p>
		<p class="btns">
			<?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'loginout-btn_right.gif':'loginout-btn_right.gif').$SCLanguages['continue'],"javascript:window.location.reload();","",false,false);?>
			<?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'loginout-btn_right.gif':'loginout-btn_right.gif').$SCLanguages['user_center'],"/","",false,false);?>
			<?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'loginout-btn_right.gif':'loginout-btn_right.gif').$SCLanguages['home'],$server_host.$cart_webroot,"",false,false);?>
		</p>
	</div>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'loginout-bottom.gif':'loginout-bottom.gif')?></p>
</div>
<?php $result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
}
?>