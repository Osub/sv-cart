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
 * $Id: checkout_order.ctp 2525 2009-07-02 05:42:37Z shenyunfeng $
*****************************************************************************/
ob_start();?>
<?php if($result['type'] != 0){?>
<div id="loginout">
	<h1><b style="font-size:14px"><?php echo $SCLanguages['order_generated'].$SCLanguages['failed'];?></b></h1>
	<div class="border_side">
	<p class="login-alettr">	<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array("align"=>"middle","alt"=>$SCLanguages['order_generated'].$SCLanguages['failed']))?>
<b>
	<?php echo $SCLanguages['order_generated'].$SCLanguages['failed']?></b>
	<br />	<br />
	<?php echo $SCLanguages['notice'];?>：
	<?php foreach($error_arr as $error){?>
	<?php echo $error?>
	<?php }?>	
</p>
		<p class="btns" style="padding-right:150px;">
			<a href="javascript:close_message();"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'loginout-btn_right.gif':'loginout-btn_right.gif');?><?php echo $SCLanguages['confirm'];?></a>
		</p>
	</div>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif",array("align"=>"texttop"))?></p>
</div>
<?php }?>
<?php 
$result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>