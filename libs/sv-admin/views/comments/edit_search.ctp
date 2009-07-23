<?php 
/*****************************************************************************
 * SV-Cart 回复评论
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit_search.ctp 2485 2009-06-30 11:33:00Z huangbo $
*****************************************************************************/
?> 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<!--CommentsConfig-->
<div class="home_main">
<?php echo $form->create('Comment',array('action'=>'edit_search/'.$comment['Comment']['id']));?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">

	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  &nbsp;评论详情</h1></div>
	  <div class="box" style="padding:15px 0 5px;">
  	   <p class="user_comments"><strong><?php echo $comment['Comment']['name']; ?></strong> 对 <strong><?php echo $comment['Comment']['type_name']; ?></strong> 发表评论</p>
	   <div class="comment_info">
	   <p class="time"><?php echo $comment['Comment']['created']; ?></p>
	   <br />
	   <p class="content_text"><?php echo $comment['Comment']['content']; ?></p>
	   <br />
	   <p class="grad">评论等级:<?php echo $comment['Comment']['rank']; ?>  IP地址:<?php echo $comment['Comment']['ipaddr']; ?></p>
	   </div>
<?php if( isset( $restore ) ){?>
	   <p class="user_comments"><strong>管理员 <?php echo $restore['Comment']['name']; ?></strong> 对 <strong><?php echo $comment['Comment']['name']; ?></strong> 回复</p>
	   <div class="comment_info">
	   <p class="time"><?php echo $restore['Comment']['created']; ?></p>
	   <br />
	   <p class="content_text"><?php echo $restore['Comment']['content']; ?></p>
	   <br />
	   <p class="grad">IP地址:<?php echo $restore['Comment']['ipaddr']; ?></p>
	   </div>
<?php }?>
	  </div>
	</div>

</td>
<td valign="top" width="50%" style="padding-left:5px;">
	<div class="order_stat athe_infos writeback_coment">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  回复评论</h1></div>
	  <div class="box">
	  <p style="clear:both"></p>
		
		<input type="hidden" name="data[Comment][parent_id]" value="<?php echo $comment['Comment']['id']; ?>">
		<ul style="margin-top:10px;*margin-top:16px;"><li class="lang">用户名:</li><li><input type="text" name="data[Comment][name]" style="width:220px;border:1px solid #629373;font-family:arial;" value="<?php echo $_SESSION['Operator_Info']['Operator']['name']?>" readonly="readonly" /></li></ul>
		<ul><li class="lang">Email:</li><li><input type="text" style="width:220px;border:1px solid #629373;font-family:arial;" name="data[Comment][email]" value="<?php echo $_SESSION['Operator_Info']['Operator']['email']?>" readonly="readonly" /></li></ul>
		<ul><li class="lang" style="padding-top:10px;"><br />回复内容:</li><li><textarea name="data[Comment][content]" style="width:373px;border:1px solid #629373;overflow-y:scroll;height:62px;font-family:arial;"></textarea></li></ul>
		
		
		<p class="submit_btn" style="padding:1px 0;*padding:10px 0;"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	  </div>
	</div>
</td>
</tr>

</table>
<?php echo $form->end();?>
<!--Communication Stat End-->




</div>
<!--CommentsConfig End-->
</div>