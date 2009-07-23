<?php 
/*****************************************************************************
 * SV-Cart 我的信息
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2102 2009-06-11 09:36:26Z shenyunfeng $
*****************************************************************************/
?>
<?php echo $javascript->link(array('profiles'));?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div class="profile">
	<h3><span><?php echo $SCLanguages['my_information'];?></span></h3>
	<?php echo $form->create('profiles',array('action'=>'edit_profiles','name'=>'edit_profiles','type'=>'POST'));?>
	<input type="hidden" id="UserId" name="data[User][id]" value="<?php echo $this->data['User']['id'];?>" />
	<input type="hidden" id="UserAddressId" name="data[UserAddress][id]" value="<?php if(isset($this->data['UserAddress']['id'])){echo $this->data['UserAddress']['id'];}?>"/>

	<dl>
		<dt><strong><?php echo $SCLanguages['member'];?></strong></dt><dd><?php echo $this->data['User']['name'];?></dd>
	</dl>
	<dl>
		<dt><strong><?php echo $SCLanguages['email'];?></strong></dt><dd><?php echo $this->data['User']['email'];?></dd>
	</dl>
	<dl>
		<dt class="pass"><strong><?php echo $SCLanguages['gender'];?></strong></dt>
        <dd>
          <select id="UserSex" name="data[User][sex]">
            <option value="0" <?php if($this->data['User']['sex'] == 0){?>selected<?php }?>><?php echo $SCLanguages['confidence'];?></option>
            <option value="1" <?php if($this->data['User']['sex'] == 1){?>selected<?php }?>><?php echo $SCLanguages['male'];?></option>
            <option value="2" <?php if($this->data['User']['sex'] == 2){?>selected<?php }?>><?php echo $SCLanguages['female'];?></option>
          </select>
         </dd>
	</dl>
	<dl>
		<dt><strong>电话</strong></dt><dd><input type="text" name="Utel1" id="Utel1" onKeyUp="is_int(this);" maxLength="30" size="10" <?php if(isset($this->data['UserAddress']['telephone_str'])){?>value="<?php echo $this->data['UserAddress']['telephone_str'];?>"<?php }else{?>value=""<?php }?>/><font color="red" id="user_telephone"></font></dd>
	</dl>
	<dl>
		<dt><strong>手机</strong></dt><dd><input type="text" id="UserAddressMobile" name="data[UserAddress][mobile]" value="<?php if(isset($this->data['UserAddress']['mobile'])){echo $this->data['UserAddress']['mobile'];}?>"/><font color="red" id="user_mobile"></font></dt></dd>
	</dl>
	<dl>
		<dt><strong>生日</strong></dt><dd><input type="text" id="date" name="data[User][birthday]" value="<?php echo $this->data['User']['birthday'];?>"/></dd>
	</dl>
	<?php if(isset($user_infoarr) && sizeof($user_infoarr)>0){?>

  <?php foreach($user_infoarr as $k=>$v){?>
	<dl>
	<dt><?php echo $v['UserInfo']['name'];?></dt>
	<input id="ValueId<?php echo $k;?>" name="info_value_id[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?php if(isset($v['value']['id'])){echo $v['value']['id'];}?>" />
	<input id="ValueInfoId<?php echo $k;?>" name="ValueInfoId[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?php echo $v['UserInfo']['id'];?>" />
	<input id="ValueInfoType<?php echo $k;?>" name="ValueInfoType[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?php echo $v['UserInfo']['type'];?>" />

	<dd>
	<?php if($v['UserInfo']['type'] == 'text'){?>
	<input id="ValueValue<?php echo $k;?>" type="text" class="text_inputs" style="width:265px;" name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" value="<?php if(isset($v['value']['value'])){echo $v['value']['value'];}?>"/>
	<?php }?>
		<?php if($v['UserInfo']['type'] == 'label'){?>
	<input id="ValueValue<?php echo $k?>" type="hidden" class="text_inputs" style="width:265px;" name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" value="<?php echo $this->requestAction('commons/real_ip');?>"/>
	<?php echo $this->requestAction('commons/real_ip');?>
	<?php }?>
	<?php if($v['UserInfo']['type'] == 'select'){?>
	<select id="ValueValue<?php echo $k;?>"   name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]"/>
 <?php if(isset($v['UserInfo']['user_info_values']) && !empty($v['UserInfo']['user_info_values'])){
 $options = explode(';',$v['UserInfo']['user_info_values']);
 foreach($options as $option){
 $text =explode(":",$option);
 ?>
 <option value="<?php echo $text[0];?>" <?php if(isset($v['value']['value']) && $text[0]==$v['value']['value']) echo 'selected';?>>
 	 <?php if(@$text[1]){ echo $text[1];} ?>
 </option>
 <?php }} ?></select>
	<?php }?>
	<?php if($v['UserInfo']['type'] == 'radio'){?>
 <?php if(isset($v['UserInfo']['user_info_values'])){
 	$options = explode(';',$v['UserInfo']['user_info_values']);
 	 $times = sizeof($options);?>
	<input id="ValueInfoTimes<?php echo $k;?>" name="ValueInfoTimes[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?php echo $times;?>" />
 	 <?php foreach($options as $kk=>$option){
 	$text =explode(":",$option); 
 if(@$text[1]!=""){?>
 <label><input type="radio" id="ValueValue<?php echo $k;?><?php echo $kk;?>"   name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" value="<?php echo $text[0];?>" <?php if(isset($v['value']['value']) && @$text[0]==$v['value']['value']) echo 'checked';?>/><?php if(@$text[1]){ echo $text[1];}?></label>
 <?php }}?>		
<?php }}?>
<?php if($v['UserInfo']['type'] == 'checkbox'){?>
 <?php if(isset($v['UserInfo']['user_info_values'])&&!empty($v['UserInfo']['user_info_values'])){
 	 if(isset($v['value']['value'])){
 	 	$checkoptions = explode(';',$v['value']['value']);
 	 }
 	 $options = explode(';',$v['UserInfo']['user_info_values']);
 	 $times = sizeof($options);?>
	<input id="ValueInfoTimes<?php echo $k;?>" name="ValueInfoTimes[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]" type="hidden" value="<?php echo $times;?>" />
 	 <?php foreach($options as $kkk=>$option){
 	 $text =explode(":",$option);if(@$text[1]!=""){?>
 <label><input type="checkbox" id="ValueValue<?php echo $k;?><?php echo $kkk;?>"   name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>][<?php echo $kkk;?>]" value="<?php echo $text[0];?>" <?php if(isset($checkoptions) && in_array($text[0],$checkoptions)) echo 'checked';?>/><?php if(@$text[1]){ echo $text[1];}?></label>
 <?php } ?><?php }}?>
<?php }?>
<?php if($v['UserInfo']['type'] == 'textarea'){?>
<textarea id="ValueValue<?php echo $k;?>"   name="info_value[<?php if(isset($v['value']['user_info_id'])){echo $v['value']['user_info_id'];}?>]"><?php if(isset($v['value']['value']))echo $v['value']['value']; ?></textarea>
<?php }?>
</dd>
</dl>
		<?php }?>
<?php }?>
	
	<dl>
		<dt><strong>注册时间</strong></dt><dd><?php echo $this->data['User']['created'];?></dd>
	</dl>
	<dl>
		<dt><strong>上次登录IP</strong></dt><dd><?php echo $this->data['User']['login_ipaddr'];?></dd>
	</dl>
	<dl>
		<dt><strong>上次登录时间</strong></dt><dd><?php echo $this->data['User']['last_login_time'];?></dd>
	</dl>
	<dl class="submitform"><dt>&nbsp;&nbsp;&nbsp;&nbsp;</dt>
	<dd>
	
		<span class="button float_left"><a href="javascript:document.edit_profiles.submit()"><?php echo $SCLanguages['confirm'];?></a></span>
<?php echo $form->end();?>
	<span class="button float_left"><a href="javascript:document.edit_profiles.reset()"><?php echo $SCLanguages['cancel'];?></a></span>
	</dd>
	</dl>
</div>