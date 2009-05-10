<?php
/*****************************************************************************
 * SV-Cart 删除商品
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: act_remove.ctp 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
ob_start();?>
<?if ($result['type'] == 0){?>
<? echo $this->element('cart_products', array('cache'=>'+0 hour'));?>
<?}else{?>
<div id="loginout">
	<h1><b><?=$SCLanguages['cart'];?><?=$SCLanguages['information'];?></b></h1>
	<div class="box">
		<p class="login-alettr"><?=$html->image("icon-10.gif",array("align"=>"middle"))?><b><?php echo $result['message']?></b></p>
		<?=$html->link($SCLanguages['close'],"javascript:close_message();","",false,false);?>
	</div>
	<?=$html->image("loginout-bottom.gif",array("align"=>"texttop"))?>
</div>
<?}?>
<?
$result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>