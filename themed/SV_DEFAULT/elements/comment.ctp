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
 * $Id: comment.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('comment');?>
<!--评论框显示开始-->
<div id="add_comment" class="yui-overlay">
<!--我的评论-->
<div class="hd comment_title">
<span class="l"></span><span class="r"></span>
<a href="javascript:close_comment();" class="float_r close"></a>
<div class="t"><?php echo $SCLanguages['issue_comments'];?></div>
</div>

<div class="comment">
<div class="box" style="width:auto;">
<div class="key_list">
<form action="/" method="post" name="commentForm">
<div class="user_comment">
	<dl>
	<dd><?php echo $SCLanguages['username'];?></dd>
	<dt><?php if (isset($_SESSION['User']['User'])&&$_SESSION['User']['User']){ echo $_SESSION['User']['User']['name'] ;}else{ ?><?php echo $SCLanguages['anonymous'];?><?php echo $SCLanguages['user'];?><?php }?></dt>
	</dl>
	<dl class="email">
	<dd><?php echo $SCLanguages['email_letter'];?></dd>
	<dt><input type="text" size="32" class="text_input" name="data[Comment][email]" id="CommentEmail" value="<?php if (isset($_SESSION['User']['User']['email'])){ echo $_SESSION['User']['User']['email'];}?>" /></dt>
	</dl>
	<dl class="grade">
	<dd><?php echo $SCLanguages['comment_rank'];?></dd>
	<dt class="pingjiadj">
	<?php echo $form->radio('Comment.Rank',array("1"=>$html->image(isset($img_style_url)?$img_style_url."/".'one.gif':'one.gif'),"2"=>$html->image(isset($img_style_url)?$img_style_url."/".'two.gif':'two.gif'),"3"=>$html->image(isset($img_style_url)?$img_style_url."/".'three.gif':'three.gif'),"4"=>$html->image(isset($img_style_url)?$img_style_url."/".'four.gif':'four.gif'),"5"=>$html->image(isset($img_style_url)?$img_style_url."/".'five.gif':'five.gif')),array("legend"=>false,"label"=>false,"onclick"=>"comment_rank(this.value);"));?></dt>
	</dl>
		<script  type="text/javascript">
			comment_radio();
			function comment_radio(){
				document.getElementById('CommentRank5').checked = true;
				comment_rank(5);
			}
		</script>
	<dl class="email" <?php if($SVConfigs['comment_captcha'] == 0){?>style="display:none"<?php }?>>
	<dd><?php echo $SCLanguages['verify_code'];?></dd>
	<dt><input type="text" size="15" class="text_input" name="captcha" id="CommentCaptcha" value="<?php echo $SCLanguages['obtain_verification_code']?>" onfocus="javascript:show_login_captcha('comment_captcha');" /></dt>
	<dt>
		    <span id="authnum_img_span" >
				<a href="javascript:change_captcha('comment_captcha');"><img id="comment_captcha" src="" alt="" /></a>
			</span>	
	</dt>		
	</dl>
</div>

	<div class="comment_box">
	<p class="textarea_box"><textarea class="text_input" name="data['Comment']['content']" id="CommentContent" style="width:510px;overflow-y:scroll;margin-bottom:3px;" rows="" cols=""></textarea><br /><font id="comment_error_msg" color="red"></font></p>
		<div class="btn_liss commetn_btn">
		<input type='hidden' name='data[Comment][user_name]' id="CommentUserName" value="<?php if (isset($_SESSION['User']['User']) && $_SESSION['User']['User']){ echo $_SESSION['User']['User']['name'];}else{ ?><?php echo $SCLanguages['anonymous'];?><?php echo $SCLanguages['user'];?><?php }?>" />
		<input type='hidden' name='data[Comment][userid]' id="CommentUserId" value ="<?php if (isset($_SESSION['User']['User']) && $_SESSION['User']['User']){ echo $_SESSION['User']['User']['id'];}else{ echo '0';}?>" />
		<input type='hidden' name='data[Comment][type]' id="CommentType" value ="<?php echo $type;?>" />
		<input type='hidden' name='data[Comment][type_id]' id="CommentTypeId" value ="<?php echo $id;?>" />
		
	<font id="comment_button">	<a href="javascript:submit_comment();" class="reset"><?php echo $SCLanguages['submit'];?></a>
		<a href="javascript:document.commentForm.reset();" class="reset"><?php echo $SCLanguages['reset'];?></a></font>
		</div>
	</div>
</form>
</div>
</div>
</div>
</div>
<!--评论框显示结束-->
