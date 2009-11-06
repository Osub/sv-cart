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
 * $Id: checkout_order.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
ob_start();?>
<?php if($result['type'] != 0){?>
<div id="loginout">
	<h4 class="hd"><?php echo $SCLanguages['order_generated'].$SCLanguages['failed'];?></h4>
	<div class="alert">
	<div class="box">
	<p align="center"><strong><?php echo $SCLanguages['order_generated'].$SCLanguages['failed']?></strong>
	<br /><br />
	<?php echo $SCLanguages['notice'];?>：
	<?php foreach($error_arr as $error){?>
	<?php echo $error?>
	<?php }?></p>
	<p align="center" class="action"><a href="javascript:close_message();"><?php echo $SCLanguages['confirm'];?></a></p>
	</div>
	</div>
</div>
<?php }?>
<?php 
$result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>