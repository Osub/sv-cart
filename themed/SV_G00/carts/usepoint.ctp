<?php
/*****************************************************************************
 * SV-Cart 使用积分
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: usepoint.ctp 1201 2009-05-05 13:30:17Z huangbo $
*****************************************************************************/
ob_start();?>
<?if($result['type'] == 0 ){?>
<p class="address btn_list">
<span class="l"></span><span class="r"></span>
<a href="javascript:change_point()" class="amember"><span><?=$SCLanguages['mmodify']?></span></a>
<?=$SCLanguages['use'].$SCLanguages['point'];?>: 
</p>
<? echo $this->element('checkout_point_confirm', array('cache'=>'+0 hour'));?>
<?}else{?>
	<div id="loginout">
	<h1><b style="font-size:14px"><?=$SCLanguages['use'].$SCLanguages['coupon'];?></b></h1>
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
$result['checkout_point'] = ob_get_contents();
ob_end_clean();
?>
<?ob_start();?>
<?if($result['type'] == 0 ){?>
<? echo $this->element('checkout_total', array('cache'=>'+0 hour'));?>
<?}else{?>
<?}?>
<?
$result['checkout_total'] = ob_get_contents();
ob_end_clean();
?>
<?
echo json_encode($result);
?>