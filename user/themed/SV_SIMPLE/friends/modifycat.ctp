<?php 
/*****************************************************************************
 * SV-Cart 修改分组名称
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: modifycat.ctp 884 2009-04-22 10:24:48Z tangyu $
*****************************************************************************/
ob_start();
?>
<div id="loginout">
	<h1><b style="font-size:14px"><?php echo $SCLanguages['mmodify'].$SCLanguages['group'].$SCLanguages['apellation']?></b></h1>
	<div style="border-left:1px solid #909592;border-right:1px solid #909592;background:#fff">
		<p class="login-alettr">
	<?php echo $html->image('icon-10.gif',array("align"=>"middle"));?>
	<b><?php echo $SCLanguages['mmodify'].$SCLanguages['group'].$SCLanguages['apellation'].$SCLanguages['successfully']?></b></p>
	</div>
		<?php echo $html->image('loginout-bottom.gif',array("align"=>"texttop"));?>
</div>

<?php 	
	$result['content'] = ob_get_contents();
	ob_end_clean();
	echo json_encode($result);
?>