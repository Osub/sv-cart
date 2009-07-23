<?php 
/*****************************************************************************
 * SV-Cart 我的好友
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3233 2009-07-22 11:41:02Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('friends');?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?><div id="Products_box" style="overflow:hidden;height:100%;">
<h1 class="headers friendheader"><span class="l">&nbsp;</span><span class="r">&nbsp;</span><b><?php echo $SCLanguages['my_friends'];?></b>
<cite class="new_group" style="cursor:pointer;">
    <?php if(isset($SVConfigs['friend_category']) && isset($this->data) && ( sizeof($this->data) < $SVConfigs['friend_category'])){?>
    <?php echo $html->image(isset($img_style_url)?$img_style_url."/".'add-icon.png':'add-icon.png',array())?>
    <a href="javascript:newfriendgroup();"><?php echo $SCLanguages['add'].$SCLanguages['group']?></a>
    <?php }else if(isset($SVConfigs['friend_category']) && !isset($this->data)){?>
    <?php echo $html->image(isset($img_style_url)?$img_style_url."/".'add-icon.png':'add-icon.png',array())?>
    <a href="javascript:newfriendgroup();"><?php echo $SCLanguages['add'].$SCLanguages['group']?></a>
    <?php }?>
    </cite>
    </h1>
<?php if(isset($this->data) && sizeof($this->data)>0){?>
<?php foreach($this->data as $k=>$v){?>

    <div id="infos">
    	<p class="cat_friend" ><b>·<span id="contact_cat[<?php echo $v['UserFriendCat']['id']?>]"><?php echo $v['UserFriendCat']['cat_name']?></span>· <font color="red" id="cat_msg<?php echo $v['UserFriendCat']['id']?>"></font></b>
    	<span class="add_friend">
    	<a href="javascript:modify_cat(<?php echo $v['UserFriendCat']['id']?>)"><?php echo $SCLanguages['edit']?></a>|
    	<a href="javascript:del_contact_cat(<?php echo $v['UserFriendCat']['id']?>,<?php echo $v['count']?>);">
    	<?php echo $SCLanguages['delete']?></a></span></p>
        <p class="note_sum"><?php sprintf($SCLanguages['have_friends_now_continue_adding'],$v['count']);?>
        <?php if(isset($SVConfigs['friend_count']) && isset($friend_num) && ($friend_num < $SVConfigs['friend_count'])){?>
        <span class="add_friend"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'add-icon.png':'add-icon.png',array("class"=>"vmiddle"))?> 
        	<a href="javascript:add_cat_friend(<?php echo $v['UserFriendCat']['id']?>)">
        	<?php echo $SCLanguages['add'].$SCLanguages['friend']?></a></span>
        <?php }else if(isset($SVConfigs['friend_count']) && !isset($friend_num)){?>
        <span class="add_friend"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'add-icon.png':'add-icon.png',array("class"=>"vmiddle"))?> 
        	<a href="javascript:add_cat_friend(<?php echo $v['UserFriendCat']['id']?>)">
        <?php }?>
        </p>

<!--添加分组好友弹出框-->
  <div id="add_group[<?php echo $v['UserFriendCat']['id']?>]" style="border:0;display:none">
  <br />
  <p class="droup_bg"><b><?php echo $SCLanguages['create'].$SCLanguages['friend'].$SCLanguages['group']?></b></p>
  
  <div style="padding-bottom:50px;height:100%;background:#fff;padding-left:50px;">
<form  action="" method="post" name="ContactForm<?php echo $k?>">
	<input type="hidden" name="action_type" value="insert_contact">
	<input type="hidden" name="data[UserFriend][user_id]" id="UserFriendUserId" value="<?php echo $user_id?>">
	<div class="add_froend_box">
	<ul>
		<li><dd class="birthdy"><?php echo $SCLanguages['please_choose']?><?php echo $SCLanguages['group']?>：</dd>
		<dt><select name="data[UserFriend][cat_id]" id="UserFriendCatId" style="position:relative;width:50px;">
		<?php if(isset($friend_cat_list) && sizeof($friend_cat_list)>0){?>
		<?php foreach($friend_cat_list as $key=>$val){?>
		    <option value="<?php echo $val['UserFriendCat']['id']?>" <?php if($val['UserFriendCat']['id'] == $v['UserFriendCat']['id']){?>selected<?php }?>><?php echo $val['UserFriendCat']['cat_name']?></option> 
		<?php }?>
		<?php }?>
		</select></dt>
		</li>
		<li><dd><?php echo $SCLanguages["friend"]?><?php echo $SCLanguages["name"]?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_name]" id="UserFriendContactName<?php echo $k?>"/>&nbsp;<font color="red" id="friendname<?php echo $k?>">*</font></dt>
		</li>
		<li><dd><?php echo $SCLanguages['username']?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_user_name]" id="UserFriendContactUserName<?php echo $k?>"/></dt>
		</li>
		<li>
		<dd><?php echo $SCLanguages['mobile']?>：</dd><dt><input type="text" size="30" name="data[UserFriend][contact_mobile]" id="UserFriendContactMobile<?php echo $k?>"/>&nbsp;<font color="red" id="mobile<?php echo $k?>"></font></dt>
		</li>
		<li>
		<dd><?php echo $SCLanguages['email'];?>：</dd><dt><input type="text" size="30" name="data[UserFriend][contact_email]" id="UserFriendContactEmail<?php echo $k?>"/>&nbsp;<font color="red" id="friendemail<?php echo $k?>"></font></dt>
		</li>
		<li>
		<dd><?php echo $SCLanguages['backup_email']?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_other_email]" id="UserFriendContactOtherEmail<?php echo $k?>"/>&nbsp;<font color="red" id="ortherfriendemail<?php echo $k?>"></font></dt>
		</li>
		<li class="address">
		<dd><?php echo $SCLanguages['address']?>：</dd></dd><dt><input type="text" name="data[UserFriend][address]" id="UserFriendAddress<?php echo $k?>"/>&nbsp;<font color="red" id="address<?php echo $k?>"></font></dt></li>
		</ul>
		<div class="y_but submits" style="padding-left:122px;">
	<span  class="float_l"><input type="button" name="Submit2" value="<?php echo $SCLanguages['confirm']?>" onclick="javascript:submit_add_friend(<?php echo $k?>);" /></span>
	<span  class="float_l"><input type="reset" value="<?php echo $SCLanguages['cancel']?>"  /></span></div>
	</div>
</form>
  	</div>
</div>



  <ul class="friend_title">
  	<li class="name"><?php echo $SCLanguages['name']?></li><li class="email"><?php echo $SCLanguages['email']?></li><li class="tel"><?php echo $SCLanguages['mobile']?></li><li class="handel"><?php echo $SCLanguages['operation']?></li></ul>
 <?php if(isset($v['user']) && sizeof($v['user'])>0){?>
 <?php foreach($v['user'] as $key=>$val){?>
	<ul class="friend_title friend_list" style="border:0;" onmouseover="this.className='friend_title friend_list color_e'" onmouseout="this.style.background='#ffffff'">
  	<li class="name">&nbsp;<?php echo $val['UserFriend']['contact_name']?></li><li class="email">&nbsp;<?php echo $val['UserFriend']['contact_email']?></li><li class="tel">&nbsp;<?php echo $val['UserFriend']['contact_mobile']?></li>
  	<li class="handel btn_list">
  	<p style="margin:0 20px;"><a href="javascript:show_edit_contact(<?php echo $val['UserFriend']['id'] ?>);"><span><?php echo $SCLanguages['edit']?></span></a>
  	<a href="javascript:del_friends(<?php echo $val['UserFriend']['id'] ?>)"><span><?php echo $SCLanguages['delete']?></span></a></li></ul>
 <!--编辑好友弹出框-->
  <div id="edit_friend[<?php echo $val['UserFriend']['id'] ?>]" style="border:0;display:none;padding-left:50px;">
  <p class="droup_bg"><b><?php echo $SCLanguages['edit']?><?php echo $SCLanguages['friend']?></b></p>
  <div style="padding-bottom:50px;height:100%;background:#fff;">
<form  action="" method="post" name="EditContactForm<?php echo $key?>">
	<input type="hidden" name="action_type" value="edit_contact">
	<input type="hidden" name="data[UserFriend][id]" id="UserFriendId" value="<?php echo $val['UserFriend']['id']?>">
	<input type="hidden" name="data[UserFriend][user_id]" id="UserFriendUserId" value="<?php echo $user_id?>">
	<input type="hidden" name="data[UserFriend][cat_id]" id="UserFriendCatId" value="<?php echo $val['UserFriend']['cat_id']?>">
	<input type="hidden" name="contact_id" value="<?php echo $val['UserFriend']['id'] ?>"></>
<input type="hidden" name="cat_id" value="<?php echo $v['UserFriendCat']['id'] ?>"></>
	<div class="add_froend_box">
	<ul>
		<li>
		<dd><?php echo $SCLanguages["friend"]?><?php echo $SCLanguages["name"]?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_name]" id="UserFriendContactName<?php echo $key?>" value="<?php echo $val['UserFriend']['contact_name']?>"/>&nbsp;<font color="red" id="friendname<?php echo $key?>">*</font></dt>
		</li>
		<li>
		<dd><?php echo $SCLanguages['username']?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_user_name]" id="UserFriendContactUserName<?php echo $key?>" value="<?php echo $val['UserFriend']['contact_user_name']?>"/></dt>
		</li>
		<li>
		<dd><?php echo $SCLanguages['mobile']?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_mobile]" id="UserFriendContactMobile<?php echo $key?>" value="<?php echo $val['UserFriend']['contact_mobile']?>"/>&nbsp;<font color="red" id="mobile<?php echo $key?>"></font></dt>
		</li>
		<li>
		<dd><?php echo $SCLanguages['email']?>：</dd><dt><input type="text" size="30" name="data[UserFriend][contact_email]" id="UserFriendContactEmail<?php echo $key?>" value="<?php echo $val['UserFriend']['contact_email']?>"/>&nbsp;<font color="red" id="friendemail<?php echo $key?>"></font></dt>
		</li>
		<li>
		<dd><?php echo $SCLanguages['backup_email']?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_other_email]" id="UserFriendContactOtherEmail<?php echo $key?>" value="<?php echo $val['UserFriend']['contact_other_email']?>"/>&nbsp;<font color="red" id="ortherfriendemail<?php echo $key?>"></font></dt>
		</li>
		<li class="address">
		<dd><?php echo $SCLanguages['address']?>：</dd>
		<dt><input type="text" name="data[UserFriend][address]" id="UserFriendAddress<?php echo $key?>" value="<?php echo $val['UserFriend']['address']?>"/>&nbsp;<font color="red" id="address<?php echo $key?>"></font></dt>
		</li>
	</ul>
	<div class="y_but submits" style="padding-left:122px;">
	<span  class="float_l"><input type="button" name="Submit2" value="<?php echo $SCLanguages['confirm']?>" onclick="javascript:submit_edit_friend(<?php echo $key?>);" /></span>
	<span  class="float_l"><input type="button" onclick="javascript:show_edit_contact(<?php echo $val['UserFriend']['id'] ?>);"  value="<?php echo $SCLanguages['cancel']?>"  /></span></div>
	</div>
</form>
  	</div>
</div>
<!--编辑好友弹出框 End-->
<?php }?>
<?php }?>
     </div>
 <?php }?>
  <?php }else{?>
	<div id="infos">
	<div class="not">
	<br /><br /><br /><br />
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('align'=>'middle','style'=>'margin-right:15px;margin-top:-10px;'))?><strong><?php echo $SCLanguages['no_friends'];?></strong>
	<br /><br /><br /><br /><br />
	</div>
	
	</div>
  <?php }?>
</div>
<br />

<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>
