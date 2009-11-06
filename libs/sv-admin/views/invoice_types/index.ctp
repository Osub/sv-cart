<?php 
/*****************************************************************************
 * SV-Cart 货币管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3304 2009-07-24 09:18:00Z zhangshisong $
*****************************************************************************/
?>

<p class="none"><span id="show3">&nbsp;eee</span><span id="show4">&nbsp;</span></p>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>

<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增发票类型","add",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">

<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th  width="6%">编号</th>
	<th width="20%" >发票类型名称</th>
	<th>发票类型说明</th>
	<th width="12%">发票税点</th>
	<th width="8%">是否有效</th>
	<th width="8%" >操作</th>
</tr>
<!--List Start-->
<?php if(isset($invoice_type_data) && sizeof($invoice_type_data)>0){?> 
<?php foreach( $invoice_type_data as $k=>$v ){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
<td align="center"><?php echo $v["InvoiceType"]["id"]?></td>
<td><?php echo $v["InvoiceTypeI18n"]["name"]?></td>
<td><?php echo $v["InvoiceTypeI18n"]["direction"]?></td>
<td align="center"><?php echo $v["InvoiceType"]["tax_point"]?></td>
<td align="center"><?php if($v["InvoiceType"]["status"]==1)echo $html->image('yes.gif',array('align'=>'absmiddle'));else echo $html->image('no.gif',array('align'=>'absmiddle')) ?></td>
<td align="center"><?php echo $html->link("编辑","/invoice_types/edit/".$v["InvoiceType"]["id"]);?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}invoice_types/remove/{$v['InvoiceType']['id']}')"));?></td>
</tr>
<?php }}?>
</table></div>
<!--List End-->
</div>
</div>
