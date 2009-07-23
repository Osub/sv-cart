<?php 
/*****************************************************************************
 * SV-Cart 新增分组名称
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: modifycat.ctp 561 2009-04-14 06:50:55Z shenyunfeng $
*****************************************************************************/
	ob_start();
?> 
<!--添加分组弹出框-->
  <div id="new_friend_box" style="width:320px;">
  <div class="hd">
  <h2 class="add-addresses" style="*line-height:15px;">
<span class="left"><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."title_l.png":"title_l.png")?></span>
<span><?php echo $SCLanguages['create'].$SCLanguages['friend'].$SCLanguages['group']?></span>
	<a class="close" href="javascript:close_friends_message();" id="close"></a>
</h2></div>
  <div class="addgroup_box">
	<form  action="" method="post" name="InsertCat">
	<input type="hidden" name="action_type" value="insert_cat">
	<input type="hidden" name="data[UserFriendCat][user_id]" id="UserFriendCatUserId" value="<?php echo $user_id?>">
	<div class="add_froend_box">
	<br />
		<ul class="list" style="margin:0;width:auto;">
		<li>
		<dd class="l"><?php echo $SCLanguages['group']?><?php echo $SCLanguages['apellation']?>：</dd>
		<dt style="padding-top:2px;*padding-top:0;"><input type="text"  name="data[UserFriendCat][cat_name]" id="UserFriendCatCatName"/></dt>
		<dt class="submits">
		<span  class="float_l"><input style="vertical-align:top" type="button" name="Submit2" value="<?php echo $SCLanguages['confirm']?>"  onclick="javascript:submit_insertcat();"/></span> &nbsp;<font color="red" >*</font></dt>
		</li>
			<li>
		<dd class="l"></dd>
		<dt style="padding-top:2px;*padding-top:0;"><font color="red" id="cat_error_msg"></font></dt>
		<dt class="submits">
		</dt>
		</li>
		</ul>
	</div>
</form>
  	</div>
  	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'droup_bottom.gif':'droup_bottom.gif',array());?></p>
</div>
<?php 	
	$result['content'] = ob_get_contents();
	ob_end_clean();
	echo json_encode($result);
?>