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
 * $Id: comment.ctp 3124 2009-07-21 02:27:57Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('comment');?>
<!--评论框显示开始-->
<div id="add_comment" class="cont">
<span class="left_up">&nbsp;</span><span class="right_up">&nbsp;</span>
<!--我的评论-->
<h3><span><?php echo $SCLanguages['issue_comments'];?></span></h3>

<div class="box">
<div class="key_list">
<?php echo $form->create('comments',array('action'=>'add','name'=>'add_comment','type'=>'POST'));?>
<div class="user_comment">
	<dl>
	<dd id="user_name" ><?php echo $SCLanguages['username'];?></dd>
	<dt><?php if (isset($_SESSION['User']['User'])&&$_SESSION['User']['User']){ echo $_SESSION['User']['User']['name'] ;}else{ ?><?php echo $SCLanguages['anonymous'];?><?php echo $SCLanguages['user'];?><?php }?></dt>
	</dl>
	<dl class="email">
	<dd><?php echo $SCLanguages['email_letter'];?></dd>
	<dt><input type="text" size="32" class="text_input" name="data[Comment][email]" id="CommentEmail" value="<?php if (isset($_SESSION['User']['User']['email'])){ echo $_SESSION['User']['User']['email'];}?>" /></dt>
	</dl>
	<dl class="grade">
	<dd><?php echo $SCLanguages['comment_rank'];?></dd>
	<dt class="pingjiadj">
	<?php echo $form->radio('Comment.rank',array("1"=>$html->image(isset($img_style_url)?$img_style_url."/".'one.gif':'one.gif'),"2"=>$html->image(isset($img_style_url)?$img_style_url."/".'two.gif':'two.gif'),"3"=>$html->image(isset($img_style_url)?$img_style_url."/".'three.gif':'three.gif'),"4"=>$html->image(isset($img_style_url)?$img_style_url."/".'four.gif':'four.gif'),"5"=>$html->image(isset($img_style_url)?$img_style_url."/".'five.gif':'five.gif')),array("legend"=>false,"label"=>false,"onclick"=>"comment_rank(this.value);"));?></dt>
	</dl>
</div>
	<div class="comment_box">
	<p class="textarea_box"><textarea class="text_input" name="data[Comment][content]" id="CommentContent" style="width:510px;overflow-y:scroll;margin-bottom:3px;"></textarea><br /><font id="comment_error_msg" color="red"></font></p>
		<div class="btn_liss commetn_btn">
		<input type='hidden' name='data[Comment][name]' id="CommentUserName" value="<?php if (isset($_SESSION['User']['User']) && $_SESSION['User']['User']){ echo $_SESSION['User']['User']['name'];}else{ ?><?php echo $SCLanguages['anonymous'];?><?php echo $SCLanguages['user'];?><?php }?>" />
		<input type='hidden' name='data[Comment][user_id]' id="CommentUserId" value ="<?php if (isset($_SESSION['User']['User']) && $_SESSION['User']['User']){ echo $_SESSION['User']['User']['id'];}else{ echo '0';}?>" />
		<input type='hidden' name='data[Comment][type]' id="CommentType" value ="<?php echo $type;?>" />
		<input type='hidden' name='data[Comment][type_id]' id="CommentTypeId" value ="<?php echo $id;?>" />
		
		<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
		<span class="button float_left"><a href="javascript:form_comment();"><?php echo $SCLanguages['submit'];?></a></span>
		<?php }else{?>
		<span class="button float_left"><a href="javascript:submit_comment();"><?php echo $SCLanguages['submit'];?></a></span>
		<?php }?>
		<span class="button float_left"><a href="javascript:document.add_comment.reset();"><?php echo $SCLanguages['reset'];?></a></span>
		</div>
	</div>
<?php echo $form->end();?>
</div>
</div>
</div>
<!--评论框显示结束-->
<script type="text/javascript">
	function form_comment(){
		document.forms['add_comment'].submit();
	}
</script>