<?php 
/*****************************************************************************
 * SV-Cart 增加商品数量
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: act_quantity_change.ctp 3779 2009-08-19 10:40:08Z huangbo $
*****************************************************************************/
ob_start();?>
<?php if ($result['type'] == 0){?>
<?php echo $this->element('cart_products', array('cache'=>'+0 hour'));?>
<?php }else{?>
<div id="loginout" class="loginout">
	<h1><b><?php echo $SCLanguages['cart'];?><?php echo $SCLanguages['information'];?></b></h1>
	<div class="box">
		<p class="login-alettr"><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."icon-10.gif":"icon-10.gif",array("align"=>"middle"))?><b><?php echo $result['message']?></b></p>
			<p class="btns"><?php echo $html->link($SCLanguages['confirm'],"javascript:close_message();","",false,false);?></p>
	</div>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif",array("align"=>"texttop"))?>
</div>
<?php }?>
<?php 
$result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>