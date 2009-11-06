<?php 
/*****************************************************************************
 * SV-Cart 结算页开发票
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_point.ctp 3875 2009-08-25 05:11:54Z zhangshisong $
*****************************************************************************/
?>
<h5>
<dl>
<dt style="padding-top:3px;width:80px;"><strong><?php echo $SCLanguages['invoice'];?>:</strong>&nbsp;&nbsp;</dt>

<dd style="padding-top:3px;padding-right:4px;"><?php echo $SCLanguages['invoice_type'];?></dd>
<dd class="btn_list" style="margin-top:-1px;*margin-top:0;">
	<select name="confirm_invoice" id="confirm_invoice" autocomplete="off">
	<option value="" selected="selected"><?php echo $SCLanguages['please_choose'];?></option>
	<?php foreach($invoice_type as $k=>$v){?>
		<option value="<?php echo $v['InvoiceType']['id']?>"><?php echo $v['InvoiceTypeI18n']['name'];?> [ <?php echo $v['InvoiceType']['tax_point'];?>% ]</option>
	<?php }?>
	</select>&nbsp;
</dd>
<dd style="padding-top:3px;padding-right:4px;"><?php echo $SCLanguages['invoice_title'];?></dd>
<dd style="padding-right:4px;">	<input type="text" name="invoice_title" id="invoice_title" value="" /></dd>
<dd class="btn_list" style="margin-top:-1px;*margin-top:0;"><a href="javascript:confirm_invoice()" class="float_l"><span><?php echo $SCLanguages['confirm']?></span></a><span class="float_l" style="padding:2px 0 0 4px;"><font color="red" id='invoice_error_msg'></font></span></dd>
<dt class="over_cont" style="padding-top:3px;">&nbsp;</dt>
	</dl>
</h5>
