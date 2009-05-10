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
 * $Id: index.ctp 1153 2009-04-30 08:55:43Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('friends');?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Products_box" style="overflow:hidden;height:100%;">
    <h1>
    <span><?=$SCLanguages['my_friends'];?></span>
    <cite class="new_group" style="cursor:pointer;">
    <?if(isset($SVConfigs['friend_category']) && isset($this->data) && ( sizeof($this->data) < $SVConfigs['friend_category'])){?>
    <?=$html->image('add-icon.png',array())?>
    <a href="javascript:newfriendgroup();"><?=$SCLanguages['add'].$SCLanguages['group']?></a>
    <?}else if(isset($SVConfigs['friend_category']) && !isset($this->data)){?>
    <?=$html->image('add-icon.png',array())?>
    <a href="javascript:newfriendgroup();"><?=$SCLanguages['add'].$SCLanguages['group']?></a>
    <?}?>
    </cite>
    </h1>
<?if(isset($this->data) && sizeof($this->data)>0){?>
<?foreach($this->data as $k=>$v){?>

    <div id="infos" style="width:739px;">
    	<p class="cat_friend" ><b>·<span id="contact_cat[<?echo $v['UserFriendCat']['id']?>]"><?echo $v['UserFriendCat']['cat_name']?></span>· <font color="red" id="cat_msg<?echo $v['UserFriendCat']['id']?>"></font></b>
    	<span class="add_friend">
    	<a href="javascript:modify_cat(<?echo $v['UserFriendCat']['id']?>)"><?=$SCLanguages['edit']?></a>|
    	<a href="javascript:del_contact_cat(<?echo $v['UserFriendCat']['id']?>,<?echo $v['count']?>);">
    	<?=$SCLanguages['delete']?></a></span></p>
        <p class="note_sum"><?php sprintf($SCLanguages['have_friends_now_continue_adding'],$v['count']);?>
        <?if(isset($SVConfigs['friend_count']) && isset($friend_num) && ($friend_num < $SVConfigs['friend_count'])){?>
        <span class="add_friend"><?=$html->image('add-icon.png',array("class"=>"vmiddle"))?> 
        	<a href="javascript:add_cat_friend(<?echo $v['UserFriendCat']['id']?>)">
        	<?=$SCLanguages['add'].$SCLanguages['friend']?></a></span>
        <?}else if(isset($SVConfigs['friend_count']) && !isset($friend_num)){?>
        <span class="add_friend"><?=$html->image('add-icon.png',array("class"=>"vmiddle"))?> 
        	<a href="javascript:add_cat_friend(<?echo $v['UserFriendCat']['id']?>)">
        <?}?>
        </p>

<!--添加分组好友弹出框-->
  <div id="add_group[<?echo $v['UserFriendCat']['id']?>]" style="border:0;display:none">
  <br />
  <p class="droup_bg"><b><?=$SCLanguages['create'].$SCLanguages['friend'].$SCLanguages['group']?></b></p>
  
  <div style="padding-bottom:50px;height:100%;background:#fff;padding-left:50px;">
<form  action="" method="post" name="ContactForm<?=$k?>">
	<input type="hidden" name="action_type" value="insert_contact">
	<input type="hidden" name="data[UserFriend][user_id]" id="UserFriendUserId" value="<?echo $user_id?>">
	<div class="add_froend_box">
	<ul>
		<li><dd class="birthdy"><?=$SCLanguages['please_choose']?><?=$SCLanguages['group']?>：</dd>
		<dt><select name="data[UserFriend][cat_id]" id="UserFriendCatId" style="position:relative;width:50px;">
		<?if(isset($friend_cat_list) && sizeof($friend_cat_list)>0){?>
		<?foreach($friend_cat_list as $key=>$val){?>
		    <option value="<?echo $val['UserFriendCat']['id']?>" <?if($val['UserFriendCat']['id'] == $v['UserFriendCat']['id']){?>selected<?}?>><?echo $val['UserFriendCat']['cat_name']?></option> 
		<?}?>
		<?}?>
		</select></dt>
		</li>
		<li><dd><?=$SCLanguages["friend"]?><?=$SCLanguages["name"]?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_name]" id="UserFriendContactName<?=$k?>"/>&nbsp;<font color="red" id="friendname<?=$k?>">*</font></dt>
		</li>
		<li><dd><?=$SCLanguages['username']?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_user_name]" id="UserFriendContactUserName<?=$k?>"/></dt>
		</li>
		<li>
		<dd><?=$SCLanguages['mobile']?>：</dd><dt><input type="text" size="30" name="data[UserFriend][contact_mobile]" id="UserFriendContactMobile<?=$k?>"/>&nbsp;<font color="red" id="mobile<?=$k?>"></font></dt>
		</li>
		<li>
		<dd><?=$SCLanguages['email'];?>：</dd><dt><input type="text" size="30" name="data[UserFriend][contact_email]" id="UserFriendContactEmail<?=$k?>"/>&nbsp;<font color="red" id="friendemail<?=$k?>">*</font></dt>
		</li>
		<li>
		<dd><?=$SCLanguages['backup_email']?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_other_email]" id="UserFriendContactOtherEmail<?=$k?>"/>&nbsp;<font color="red" id="ortherfriendemail<?=$k?>"></font></dt>
		</li>
		<li class="address">
		<dd><?=$SCLanguages['address']?>：</dd></dd><dt><input type="text" name="data[UserFriend][address]" id="UserFriendAddress<?=$k?>"/>&nbsp;<font color="red" id="address<?=$k?>">*</font></dt></li>
		</ul>
		<div class="y_but submits" style="padding-left:122px;">
	<span  class="float_l"><input type="button" name="Submit2" value="<?=$SCLanguages['confirm']?>" onclick="javascript:submit_add_friend(<?=$k?>);" /></span>
	<span  class="float_l"><input type="reset" value="<?=$SCLanguages['cancel']?>"  /></span></div>
	</div>
</form>
  	</div>
</div>



  <ul class="friend_title">
  	<li class="name"><?=$SCLanguages['name']?></li><li class="email"><?=$SCLanguages['email']?></li><li class="tel"><?=$SCLanguages['mobile']?></li><li class="handel"><?=$SCLanguages['operation']?></li></ul>
 <?if(isset($v['user']) && sizeof($v['user'])>0){?>
 <?foreach($v['user'] as $key=>$val){?>
	<ul class="friend_title friend_list" style="border:0;" onmouseover="this.className='friend_title friend_list color_e'" onmouseout="this.style.background='#ffffff'">
  	<li class="name">&nbsp;<?echo $val['UserFriend']['contact_name']?></li><li class="email">&nbsp;<?echo $val['UserFriend']['contact_email']?></li><li class="tel">&nbsp;<?echo $val['UserFriend']['contact_mobile']?></li>
  	<li class="handel btn_list">
  	<p style="margin:0 20px;"><a href="javascript:show_edit_contact(<?echo $val['UserFriend']['id'] ?>);"><span><?=$SCLanguages['edit']?></span></a>
  	<a href="javascript:del_friends(<?echo $val['UserFriend']['id'] ?>)"><span><?=$SCLanguages['delete']?></span></a></li></ul>
 <!--编辑好友弹出框-->
  <div id="edit_friend[<?echo $val['UserFriend']['id'] ?>]" style="border:0;display:none;padding-left:50px;">
  <p class="droup_bg"><b><?=$SCLanguages['edit_friend']?></b></p>
  <div style="padding-bottom:50px;height:100%;background:#fff;">
<form  action="" method="post" name="EditContactForm<?=$key?>">
	<input type="hidden" name="action_type" value="edit_contact">
	<input type="hidden" name="data[UserFriend][id]" id="UserFriendId" value="<?echo $val['UserFriend']['id']?>">
	<input type="hidden" name="data[UserFriend][user_id]" id="UserFriendUserId" value="<?echo $user_id?>">
	<input type="hidden" name="data[UserFriend][cat_id]" id="UserFriendCatId" value="<?echo $val['UserFriend']['cat_id']?>">
	<input type="hidden" name="contact_id" value="<?echo $val['UserFriend']['id'] ?>"></>
<input type="hidden" name="cat_id" value="<?echo $v['UserFriendCat']['id'] ?>"></>
	<div class="add_froend_box">
	<ul>
		<li>
		<dd><?=$SCLanguages["friend"]?><?=$SCLanguages["name"]?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_name]" id="UserFriendContactName<?=$key?>" value="<?echo $val['UserFriend']['contact_name']?>"/>&nbsp;<font color="red" id="friendname<?=$key?>">*</font></dt>
		</li>
		<li>
		<dd><?=$SCLanguages['name_for_website']?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_user_name]" id="UserFriendContactUserName<?=$key?>" value="<?echo $val['UserFriend']['contact_user_name']?>"/></dt>
		</li>
		<li>
		<dd><?=$SCLanguages['mobile']?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_mobile]" id="UserFriendContactMobile<?=$key?>" value="<?echo $val['UserFriend']['contact_mobile']?>"/>&nbsp;<font color="red" id="mobile<?=$key?>"></font></dt>
		</li>
		<li>
		<dd><?=$SCLanguages['email']?>：</dd><dt><input type="text" size="30" name="data[UserFriend][contact_email]" id="UserFriendContactEmail<?=$key?>" value="<?echo $val['UserFriend']['contact_email']?>"/>&nbsp;<font color="red" id="friendemail<?=$key?>">*</font></dt>
		</li>
		<li>
		<dd><?=$SCLanguages['backup_email']?>：</dd><dt><input size="30" type="text" name="data[UserFriend][contact_other_email]" id="UserFriendContactOtherEmail<?=$key?>" value="<?echo $val['UserFriend']['contact_other_email']?>"/>&nbsp;<font color="red" id="ortherfriendemail<?=$key?>"></font></dt>
		</li>
		<li class="address">
		<dd><?=$SCLanguages['address']?>：</dd>
		<dt><input type="text" name="data[UserFriend][address]" id="UserFriendAddress<?=$key?>" value="<?echo $val['UserFriend']['address']?>"/>&nbsp;<font color="red" id="address<?=$key?>">*</font></dt>
		</li>
	</ul>
	<div class="y_but submits" style="padding-left:122px;">
	<span  class="float_l"><input type="button" name="Submit2" value="<?=$SCLanguages['confirm']?>" onclick="javascript:submit_edit_friend(<?=$key?>);" /></span>
	<span  class="float_l"><input type="reset" value="<?=$SCLanguages['cancel']?>"  /></span></div>
	</div>
</form>
  	</div>
</div>
<!--编辑好友弹出框 End-->
<?}?>
<?}?>
     </div>
 <?}?>
  <?}else{?>
	<div id="infos" style="width:739px;">
	<br /><br />
	<p style="font-size:14px;" align='center'><?=$html->image('warning_img.gif',array('align'=>'middle','style'=>'margin-right:15px;margin-top:-10px;'))?><?php echo $SCLanguages['no_friends'];?></p>
	<br /><br />
	</div>
  <?}?>
</div>
<br />

<?php echo $this->element('news', array('cache'=>'+0 hour'));?>