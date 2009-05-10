<?php
/*****************************************************************************
 * SV-Cart 查看留言
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 1144 2009-04-29 11:41:30Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."留言列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<!--Main Start-->
<!--CommentsConfig-->
<div class="home_main">
<?php echo $form->create('Message',array('action'=>'view/'.$usermessage['UserMessage']['id']));?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">

	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  &nbsp;留言详情&nbsp;</h1></div>
	  <div class="box" style="padding:15px 0 5px;">
  	   <p class="user_comments"><strong><?=$usermessage['UserMessage']['msg_title']?></strong></p>
	   <div class="comment_info">
	   <br />
	   <p class="content_text"><?=$usermessage['UserMessage']['msg_content']?></p>
	   <br />
	   <p class="grad"><strong><?=$usermessage['UserMessage']['user_name']?></strong>  <?=$usermessage['UserMessage']['created']?></p>
	   </div>
<?if( isset( $restore ) ){ //foreach($restore as $k=>$v){?>
	   <p class="user_comments"><strong>回复</strong></p>
	   <div class="comment_info">
	   <br />
	   <p class="content_text"><?=$restore['UserMessage']['msg_content'] ?></p>
	   <br />
	   <p class="grad"><strong><?=$restore['UserMessage']['user_name'] ?></strong><?=$restore['UserMessage']['created'] ?></p>
	   </div>
<?}//}?>
	   <br /><br /><br />
	  </div>
	</div>

</td>
<input type="hidden" name="data[UserMessage][parent_id]" value="<?=$usermessage['UserMessage']['id']; ?>">
		
<td valign="top" width="50%" style="padding-left:5px;">
	<div class="order_stat athe_infos writeback_coment">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  &nbsp;回复留言&nbsp;</h1></div>
	  <div class="box">
		<ul><li class="lang">管理员:</li><li><input type="text" name="data[UserMessage][user_name]" style="width:220px;border:1px solid #629373;font-family:arial;"value="<?=$_SESSION['Operator_Info']['Operator']['name']?>" readonly="readonly"/></li></ul>
		<ul><li class="lang" style="padding-top:10px;">回复内容:</li><li><textarea name="data[UserMessage][msg_content]" style="width:353px;border:1px solid #629373;overflow-y:scroll;height:62px;font-family:arial;"></textarea></li></ul>
		<p style="clear:both;">
		<?if( isset( $restore ) ){?>
		<ul><li class="lang" style="padding-top:10px;"></li><li>
		提示: 此条留言已有回复, 如果继续回复将更新原来回复的内容!</li></ul>
		<?}?>
		</p>
		<br /><br />
		<p class="submit_btn" style="padding:1px 0;*padding:10px 0;"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	  </div>
	</div>
</td>
</tr>

</table>
<? echo $form->end();?>
<!--Communication Stat End-->




</div>
<!--CommentsConfig End-->
</div>