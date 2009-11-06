<?php 
/*****************************************************************************
 * SV-Cart 结算页加备注
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_remark.ctp 3732 2009-08-18 12:01:02Z huangbo $
*****************************************************************************/
?>
<h5 id="checkout_shipping_choice_remark">
<span id="change_remark" style="display:none">
<a href="javascript:change_remark()" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a>
</span>

<dl>
	<dt style="width:80px;"><strong><?php echo $SCLanguages['order'].$SCLanguages['remark'];?>:</strong></dt>
	<dt class="over_cont">
	<p style="padding-bottom:4px;"><?php echo $SCLanguages['if_requirements_in_orders']?><?php echo $SCLanguages['remark_here']?></p>
<span id="order_note_value" style="display:none"></span>
<span id="order_note_textarea">
<textarea name="order_note" rows="3" id="order_note_add" class="green_border" style="width:430px;overflow-y:scroll;vertical-align:top" onblur="javascript:add_remark();" ></textarea>
</span>
	<p id="remark_msg" style='padding:1px 4px 0 20px;*margin-top:-2px;color:red'></p>
	</dt>
</dl>

</h5>
