<?php
/*****************************************************************************
 * SV-Cart  配送方式列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1201 2009-05-05 13:30:17Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>

<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
	<ul class="product_llist shippingments">
	<li class="shipname">配送方式名称</li><li class="bewrite">配送方式描述</li><li class="expenditure">保价费用</li><li class="payment">货到付款？</li><li class="edition">插件版本</li><li class="hadle">操作</li></ul>
<!--Shippingments List-->
<?if(isset($shippings) && sizeof($shippings)>0){?>
<?php foreach($shippings as $shipping){?>
	<ul class="product_llist shippingments shippingments_list">
	<li class="shipname"><span><?php echo $shipping['ShippingI18n']['name']?></span></li>
	<li class="bewrite"><p><?php echo $shipping['ShippingI18n']['description']?></p></li>
	<li class="expenditure"><?php echo $shipping['Shipping']['insure_fee']?></li>
	<li class="payment"><?php if($shipping['Shipping']['support_cod']) echo $html->image('yes.gif');else echo $html->image('no.gif');?></li>
	<li class="edition"><?php echo $shipping['Shipping']['version']?></li>
	<li class="hadle"><?php if(!($shipping['Shipping']['status']))echo $html->link('安装','/shippingments/install/'.$shipping['Shipping']['id'],'',false,false);else{ echo $html->link('卸载','/shippingments/uninstall/'.$shipping['Shipping']['id'],'',false,false).' ';echo $html->link('编辑','/shippingments/edit/'.$shipping['Shipping']['id'],'',false,false).' '; echo $html->link('设置区域','/shippingments/area/'.$shipping['Shipping']['id'],'',false,false);}?></li></ul>
<?php }}?>
<!--Shippingments List End-->	

<div class="pagers" style="position:relative;">
<?=$this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
<!--Main Start End-->
</div>