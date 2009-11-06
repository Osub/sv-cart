<?php 
/*****************************************************************************
 * SV-Cart 提交评论
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: comment.ctp 2800 2009-07-13 07:42:54Z zhangshisong $
*****************************************************************************/
?>
<!--留言框显示开始-->
<div id="add_product_message" class="yui-overlay">
<!--我的留言-->
	<div class="hd comment_title" style="height:31px;">
	<span class="l"></span><span class="r"></span>
	<a href="javascript:close_product_message();" class="float_r close"></a>
	<div class="t"><?php echo $SCLanguages['question']?></div>
	</div>

<div class="comment">
<div class="box" style="width:auto;">
<div class="key_list">
	<?php echo $form->create('commons',array('action'=>'add_message','name'=>'message_form','type'=>'post'));?>
		<div class="user_comment"><input type="hidden" name="message_type_id" id="message_type_id" value="<?php echo $info['Product']['id'];?>" />
			<dl class="email">
			<dd style="width:auto;padding:4px 5px 0 0"><?php echo $SCLanguages['subject'];?></dd>
			<dt><input size="30" name="title" id="title" type="text" class="text_input" />&nbsp;<font color="red" id="msg_title">*</font></dt>
			</dl>
		</div>
	<div class="comment_box">
	<p class="textarea_box" style="padding-left:56px;"><textarea class="text_input" name="message_content" id="message_content" style="width:500px;overflow-y:scroll;margin-bottom:3px;" rows="" cols=""></textarea><br /><font id="msg_content" color="red"></font></p>
		<div class="btn_liss commetn_btn">
			<font id="message_button"><a href="javascript:javascript:form1_onsubmit(<?php if(isset($_SESSION['User']['User'])){?>1<?}else{?>0<?}?>);" class="reset"><?php echo $SCLanguages['submit'];?></a>
			<a href="javascript:document.forms['message_form'].reset();" class="reset"><?php echo $SCLanguages['reset'];?></a></font>
		</div>
	</div>
<?php echo $form->end();?>
</div>
</div>
</div>
</div>
<!--留言框显示结束-->

