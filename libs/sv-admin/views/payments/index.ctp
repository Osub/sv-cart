<?php
/*****************************************************************************
 * SV-Cart 支付方式管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($payments);?>

<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
	<ul class="product_llist payments">
	<li class="paymentname">支付方式名称</li><li class="bewrite">支付方式描述</li><li class="edition">插件版本</li><li class="expenditure">费用</li><li class="taixs">排序</li><li class="hadle">操作</li></ul>
<!--Payments List-->
	<table cellpadding="0" cellspacing="0" class="payments_list" width="100%">
	<?if(isset($payments) && sizeof($payments)>0){?>
	<?php foreach($payments as $payment){?>
    	<tr>
		<td width="13%" valign="top"><strong><?php echo $payment['PaymentI18n']['name']?></strong></td>
		<td width="54%" valign="top"><?php echo $payment['PaymentI18n']['description']?></td>
		<td width="9%" valign="top" align="center"><?php echo $payment['Payment']['version']?></td>
		<td width="6%" valign="top" align="center"><?php echo $payment['Payment']['fee']?></td>
		<td width="6%" valign="top" align="center"><?php echo $payment['Payment']['orderby']?></td>
		<td width="12%" valign="top" align="center"><?php if(!($payment['Payment']['status']))echo $html->link('安装','/payments/install/'.$payment['Payment']['id'],'',false,false);else{ echo $html->link('卸载','/payments/uninstall/'.$payment['Payment']['id'],'',false,false).' ';echo $html->link('编辑','/payments/edit/'.$payment['Payment']['id'],'',false,false);}?></td></tr>
	<?php }}?>		
	</table>

<!--Payments List End-->	
<br />
</div>
<!--Main Start End-->
</div>