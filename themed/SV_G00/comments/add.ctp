<?php
/*****************************************************************************
 * SV-Cart 提交评论
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 1028 2009-04-24 12:23:26Z huangbo $
*****************************************************************************/
ob_start();?>
<div id="loginout">
	<h1><b><?=$SCLanguages['add'];?><?=$SCLanguages['comments'];?></b></h1>
	<div class="border_side" id="buyshop_box">
		<p class="login-alettr">
 	<?=$html->image('icon-10.gif',array("align"=>"middle"));?>
	<b><?php echo $result['message']?></b></p>
		<p class="buy_btn" style='padding-right:145px;'>
		<br />
		<?=$html->link($SCLanguages['confirm'],"javascript:window.location.reload();");?></p>
	</div>
	 	<?=$html->image('loginout-bottom.gif',array("align"=>"texttop"));?>
</div>
<?php	
	$result['message'] = ob_get_contents();
	ob_end_clean();
	echo json_encode($result);
?>