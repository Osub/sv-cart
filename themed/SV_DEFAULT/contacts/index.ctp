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
 * $Id: comment.ctp 3863 2009-08-24 07:36:59Z zhangshisong $
*****************************************************************************/
?>
<div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $this->data['languages']['contact_us']?></b></h1>
<div class="Edit_box">
	<div id="article_info">
<?php echo $form->create('contacts',array('action'=>'index','name'=>'ContactForm','type'=>'post'));?>
<div class="user_comment">
	<dl class="email">
	<dd><?php echo $this->data['languages']['company_name']?>:</dd>
	<dt>
	<input type="hidden" name="data[Contact][height]" id="Contact_height" value="" /><input type="hidden" name="data[Contact][id]" value="" />	
	<input type="hidden" name="data[Contact][width]"  id="Contact_width"  value="" /><input type="text" size="32" class="text_input" name="data[Contact][company]" id="ContactCompany" value="" />&nbsp;<span  style="color:red;">*</span></dt>
	</dl>
	<dl class="email">
	<dd>域名:</dd>
	<dt><input type="text" size="32" class="text_input" name="data[Contact][web]" id="ContactWeb" value="" /></dt>
	</dl>		
	<dl class="email">
	<dd><?php echo $this->data['languages']['industry']?>:</dd>
	<dt>
	<select name="data[Contact][company_type]" class="text_input" id="ContactCompanyType" >
	<option value=""><?php echo $this->data['languages']['please_choose']?></option>
	<?php if(isset($information_info['company_type']) && sizeof($information_info['company_type'])){?>
		<?php foreach($information_info['company_type'] as $k=>$v){
			if($k > 0){?>
			<option value="<?php echo $k;?>"><?php echo $v?></option>
			<?php }
			}?>
	<?php }?>
	</select>&nbsp;<span  style="color:red;">*</span></dt>
	</dl>
	<dl class="email">
	<dd><?php echo $this->data['languages']['connect_person']?>:</dd>
	<dt><input type="text" size="32" class="text_input" name="data[Contact][contact_name]" id="ContactContactName" value="" />&nbsp;<span  style="color:red;">*</span></dt>
	</dl>
	<dl class="email">
	<dd><?php echo $SCLanguages['email_letter'];?>:</dd>
	<dt><input type="text" size="32" class="text_input" name="data[Contact][email]" id="ContactEmail" value="" />&nbsp;<span  style="color:red;">*</span></dt>
	</dl>
	<dl class="email">
	<dd><?php echo $SCLanguages['mobile'];?>:</dd>
	<dt><input type="text" size="32" class="text_input" name="data[Contact][mobile]" id="ContactMobile" value="" />&nbsp;<span  style="color:red;">*</span></dt>
	</dl>		
	<dl class="email">
	<dd>QQ:</dd>
	<dt><input type="text" size="32" class="text_input" name="data[Contact][qq]" id="ContactQQ" value="" /></dt>
	</dl>			
	<dl class="email">
	<dd>MSN:</dd>
	<dt><input type="text" size="32" class="text_input" name="data[Contact][msn]" id="ContactMSN" value="" /></dt>
	</dl>		
	<dl class="email">
	<dd>SKYPE:</dd>
	<dt><input type="text" size="32" class="text_input" name="data[Contact][skype]" id="ContactSKYPE" value="" /></dt>
	</dl>
		
	<dl class="email">
	<dd><?php echo $SCLanguages['where_know']?>:</dd>
	<dt><select name="data[Contact][from]" id="ContactFrom" class="text_input">
	<option value=""><?php echo $this->data['languages']['please_choose']?></option>
	<?php if(isset($information_info['from_type']) && sizeof($information_info['from_type'])){?>
		<?php foreach($information_info['from_type'] as $k=>$v){
			if($k > 0){?>
			<option value="<?php echo $k;?>"><?php echo $v?></option>
			<?php }
			}?>
	<?php }?>
	</select> <span  style="color:red;">*</span></dt>
	</dl>
		
		
	<dl class="email" <?php if(true){?>style="display:none"<?php }?>>
	<dd><?php echo $SCLanguages['verify_code'];?></dd>
	<dt><input type="text" size="15" class="text_input" name="captcha" id="ContactCaptcha" value="<?php echo $SCLanguages['obtain_verification_code']?>" onfocus="javascript:show_login_captcha('comment_captcha');" /></dt>
	<dt>
		    <span id="authnum_img_span" >
				<a href="javascript:change_captcha('comment_captcha');"><img id="comment_captcha" src="" alt="" /></a>
			</span>	
	</dt>		
	</dl>
</div>
	<div class="comment_box">
	<p class="textarea_box"><textarea class="text_input" name="data[Contact][content]" id="ContactContent" style="width:510px;overflow-y:scroll;margin-bottom:3px;" rows="" cols="">域名：
留言：
具体信息：
</textarea><br /><font id="comment_error_msg" color="red"></font></p>
		<div class="btn_liss commetn_btn">		
	<font id="comment_button">	<a href="javascript:submit_contact();" class="reset"><?php echo $SCLanguages['submit'];?></a>
		<a href="javascript:document.ContactForm.reset();" class="reset"><?php echo $SCLanguages['reset'];?></a></font>
		</div>
	</div>
<?php echo $form->end();?><br/><br/><br/>
</div>
</div>
</div>
<!--评论框显示结束-->
