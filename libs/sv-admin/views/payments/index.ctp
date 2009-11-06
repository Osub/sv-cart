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
 * $Id: index.ctp 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($payments);?>

<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
	<tr>
	<th>支付方式名称</th>
	<th>支付方式描述</th>
	<th>插件版本</th>
	<th>费用</th>
	<th>排序</th>
	<th>操作</th>
	</tr>
<!--Payments List-->
	<?php if(isset($payments) && sizeof($payments)>0){?>
	<?php foreach($payments as $k=>$payment){?>
    	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
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