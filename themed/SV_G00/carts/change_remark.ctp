<?php
/*****************************************************************************
 * SV-Cart 重写备注
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: change_point.ctp 887 2009-04-22 10:46:25Z shenyunfeng $
*****************************************************************************/
ob_start();?>
<?if($result['type'] == 0 ){?>
<p class="address btn_list">
<span class="l"></span><span class="r"></span>
<?=$SCLanguages['order'].$SCLanguages['remark'];?>: 
</p><? echo $this->element('checkout_remark', array('cache'=>'+0 hour'));?>
<?}else{?>
	<div id="loginout">
	<h1><b style="font-size:14px"><?=$SCLanguages['order'].$SCLanguages['remark'];?></b></h1>
	<div class="border_side">
	<p class="login-alettr">
 	<?=$html->image('icon-10.gif',array("align"=>"middle"));?>
	<b>
<?echo $result['msg'];?></b></p>
		<br/>
		<p class="btns">
			<a href="javascript:close_message();"><?=$html->image('loginout-btn_right.gif');?><?=$SCLanguages['confirm'];?></a>
		</p>
	</div>
	<p><?=$html->image("loginout-bottom.gif",array("align"=>"texttop"))?></p>
</div>
<?}?>
<?
$result['checkout_remark'] = ob_get_contents();
ob_end_clean();
?>
<?ob_start();?>
<? echo $this->element('checkout_total', array('cache'=>'+0 hour'));?>
<?
$result['checkout_total'] = ob_get_contents();
ob_end_clean();
?>
<?
echo json_encode($result);
?>