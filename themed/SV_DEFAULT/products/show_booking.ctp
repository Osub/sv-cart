<?php 
/*****************************************************************************
 * SV-Cart 评论显示
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: show_booking.ctp 2535 2009-07-02 11:34:51Z huangbo $
*****************************************************************************/
ob_start();?>	
<?php if($result['type'] == 0){?>
<div id="add_comment" style="width:658px;">
<!--我的评论-->
<div class="hd comment_title">
<span class="l"></span><span class="r"></span>
<div class="t"><?php echo $SCLanguages['booking'];?></div>
</div>


<div id="Edit_box" style="width:658px;background:#fff;margin-top:0;">
	<div id="Edit_info" style="width:658px;">
		<div id="comments">
			<div class="outstock" id="user_comment" style="width:658px;float:none;">
			<dl>
				<dd><?php echo $SCLanguages['products'];?></dd>
				<dt><?php echo $product_info['ProductI18n']['name']?></dt>
			</dl>
			<dl>
				<dd><?php echo $SCLanguages['sku'];?></dd>
				<dt><?php echo $product_info['Product']['code']?></dt>
			</dl>			
			<dl>
				<dd id="user_name" ><?php echo $SCLanguages['quantity'];?></dd>
				<dt><input name="data['bookings']['product_number']" id="product_number" onKeyUp="is_int(this);" class="green_border" value="">&nbsp;<span id="product_number_span" style="color:red">*</span></dt>
			</dl>
			<dl>
				<dd id="user_name" ><?php echo $SCLanguages['connect_person'];?></dd>
				<dt><input name="data['bookings']['contact_man']" id="contact_man" class="green_border"  value="">&nbsp;<span id="contact_man_span" style="color:red">*</span></dt>
			</dl>
			<dl>
				<dd><?php echo $SCLanguages['email'];?></dd>
				<dt><input name="data['bookings']['email']" id="email" class="green_border" value="">&nbsp;<span id="email_span" style="color:red">*</span></dt>
			</dl>
			<dl>
				<dd id="user_name" ><?php echo $SCLanguages['telephone'];?></dd>
				<dt><input name="data['bookings']['telephone']" class="green_border" id="telephone" onKeyUp="is_int(this);" value="">&nbsp;<span id="telephone_span" style="color:red">*</span></dt>
			</dl>
			</div>
			
			<div id="comment_box" style="width:590px;float:none;">
			<p class="textarea_box" style="margin-left:40px; float:none;">
			<?php echo $SCLanguages['remark'];?>
			<textarea name="data['bookings']['product_desc']" id="product_desc" class="green_border" style="margin-left:121px;width:340px;overflow-y:scroll;vertical-align:top" ></textarea></p>
			<div class="btn_liss" style="margin-left:185px;overflow:hidden;margin-top:5px;">
			<input type='hidden' name='data[bookings][product_id]' id="product_id" value="<?php echo $result['id']?>" >
			<input type="submit" value="<?php echo $SCLanguages['submit']?>" style="cursor:pointer" class="submit_comment" id="submit_comment" onclick="javascript:add_booking();"/>
			<a href="javascript:close_message_img();" class="reset"><?php echo $SCLanguages['cancel'];?></a>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<?php }else{?>
<div id="loginout">
	<h1><b style="font-size:14px"><?php echo $SCLanguages['booking'];?></b></h1>
	<div class="border_side">
	<p class="login-alettr">
 	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'icon-10.gif':'icon-10.gif',array("align"=>"middle"));?>
	
	<b>
	<?php echo $result['message']?></b></p>
		<br/>
		<p class="btns">
			<a href="javascript:close_message();"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'loginout-btn_right.gif':'loginout-btn_right.gif');?><?php echo $SCLanguages['confirm'];?></a>
		</p>
	</div>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif",array("align"=>"texttop"))?></p>
</div>
<?php }?>
<?php 
$result['show_booking'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>