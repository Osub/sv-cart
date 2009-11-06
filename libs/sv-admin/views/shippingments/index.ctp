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
 * $Id: index.ctp 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>

<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="19%">配送方式名称</th>
	<th width="27%">配送方式描述</th>
	<th width="8%">保价费用</th>
	<th width="8%">货到付款？</th>
	<th width="25%">插件版本</th>
	<th width="13%">操作</th>
</tr>
<!--Shippingments List-->
<?php if(isset($shippings) && sizeof($shippings)>0){?>
<?php foreach($shippings as $k=>$shipping){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $shipping['ShippingI18n']['name']?></td>
	<td><?php echo $shipping['ShippingI18n']['description']?></td>
	<td align="center"><?php echo $shipping['Shipping']['insure_fee']?></td>
	<td align="center"><?php if($shipping['Shipping']['support_cod']) echo $html->image('yes.gif');else echo $html->image('no.gif');?></td>
	<td align="center"><?php echo $shipping['Shipping']['version']?></td>
	<td align="center"><?php if(!($shipping['Shipping']['status']))echo $html->link('安装','/shippingments/install/'.$shipping['Shipping']['id'],'',false,false);else{ echo $html->link('卸载','/shippingments/uninstall/'.$shipping['Shipping']['id'],'',false,false).' ';echo $html->link('编辑','/shippingments/edit/'.$shipping['Shipping']['id'],'',false,false).' '; echo $html->link('设置区域','/shippingments/area/'.$shipping['Shipping']['id'],'',false,false);}?>
	</td>
</tr>
<?php }}?>
</table></div>
<!--Shippingments List End-->	

<div class="pagers" style="position:relative;">
<?php echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
<!--Main Start End-->
</div>