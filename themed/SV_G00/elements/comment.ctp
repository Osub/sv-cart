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
 * $Id: comment.ctp 1116 2009-04-28 11:04:43Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('comment');?>
<!--评论框显示开始-->
<div id="add_comment" class="yui-overlay">
<!--我的评论-->
<div class="hd comment_title">
<span class="l"></span><span class="r"></span>
<a href="javascript:close_comment();" class="float_r close" id="close_comment"></a>
<div class="t"><?=$SCLanguages['issue_comments'];?></div>
</div>

<div id="comment">
<div class="box" style="width:599px;">
<div class="key_list">
<form action="" method="POST" name="commentForm">
<div class="user_comment">
	<dl>
	<dd id="user_name" ><?=$SCLanguages['username'];?></dd>
	<dt><?php if (isset($_SESSION['User']['User'])&&$_SESSION['User']['User']){ echo $_SESSION['User']['User']['name'] ;}else{ ?><?=$SCLanguages['anonymous'];?><?=$SCLanguages['user'];?><?php }?></dt>
	</dl>
	<dl class="email">
	<dd><?=$SCLanguages['email_letter'];?></dd>
	<dt><input type="text" size="32" class="text_input" name="data[Comment][email]" id="CommentEmail" value="<?php if (isset($_SESSION['User']['User']['email'])){ echo $_SESSION['User']['User']['email'];}?>" /></dt>
	</dl>
	<dl class="grade">
	<dd><?php echo $SCLanguages['comment_rank'];?></dd>
	<dt class="pingjiadj">
	<?=$form->radio('Comment.Rank',array("1"=>$html->image('one.gif'),"2"=>$html->image('two.gif'),"3"=>$html->image('three.gif'),"4"=>$html->image('four.gif'),"5"=>$html->image('five.gif')),array("legend"=>false,"label"=>false,"onclick"=>"comment_rank(this.value);"));?></dt>
	</dl>
</div>

	<div class="comment_box">
	<p class="textarea_box"><textarea class="text_input" name="data['Comment']['content']" id="CommentContent" style="width:510px;overflow-y:scroll;margin-bottom:3px;"></textarea><br /><font id="comment_error_msg" color="red"></font></p>
		<div class="btn_liss commetn_btn">
		<input type='hidden' name='data[Comment][user_name]' id="CommentUserName" value="<?php if (isset($_SESSION['User']['User']) && $_SESSION['User']['User']){ echo $_SESSION['User']['User']['name'];}else{ ?><?=$SCLanguages['anonymous'];?><?=$SCLanguages['user'];?><?php }?>" />
		<input type='hidden' name='data[Comment][userid]' id="CommentUserId" value ="<?php if (isset($_SESSION['User']['User']) && $_SESSION['User']['User']){ echo $_SESSION['User']['User']['id'];}else{ echo '0';}?>" />
		<input type='hidden' name='data[Comment][type]' id="CommentType" value ="<?php echo $type;?>" />
		<input type='hidden' name='data[Comment][type_id]' id="CommentTypeId" value ="<?php echo $id;?>" />
		
		<a href="javascript:submit_comment();" class="reset"><?php echo $SCLanguages['submit'];?></a>
		<a href="javascript:document.commentForm.reset();" class="reset"><?php echo $SCLanguages['reset'];?></a>
		</div>
	</div>
</form>
</div>
</div>
</div>
</div>
<!--评论框显示结束-->
