<?php 
/*****************************************************************************
 * SV-Cart 查看用户
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 4372 2009-09-18 10:38:17Z huangbo $
*****************************************************************************/
?>



<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."会员列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>
		  <!--时间控件层start-->
	<div id="container_cal" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal2" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal2"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal3" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal3"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal4" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal4"></div><div style="clear:both;"></div></div>
	</div>
<!--end-->
<!--Main Start-->
<div class="home_main">
<?php echo $form->create('User',array('action'=>'add' ,'onsubmit'=>'return users_check();'));?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑会员</h1></div>
	  <div class="box">
	  <br />
  	    <dl><dt class="config_lang">会员名称：</dt>
			<dd><input type="text" class="text_inputs" style="width:265px;" id="user_name" name="data[User][name]" value="<?php echo $this->data['User']['name'];?>"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt class="config_lang">邮件地址：</dt>
			<dd><input type="text" class="text_inputs" style="width:265px;" id="user_email" name="data[User][email]" value="<?php echo $this->data['User']['email'];?>"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt class="config_lang">会员等级：</dt><dd>
		<select style="width:230px;" name="data[User][rank]">
		<option value="-1">用户等级</option>
		<option value="0" >普通用户</option>
		<?php if(isset($rank_list) && sizeof($rank_list)>0){?>
		<?php foreach($rank_list as $k=>$v){?>
		  <option value="<?php echo $v['UserRank']['id']?>" <?php if($v['UserRank']['id'] == $this->data['User']['rank']){?>selected<?php }?>><?php echo $v['UserRank']['name']?></option>
		<?php }}?>
		</select></dd></dl>	

		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px" class="config_lang">性别：</dt><dd class="best_input">
		<input type="radio" name="data[User][sex]" <?php if($this->data['User']['sex'] == 0){?>checked="checked"<?php }?> value="0" checked />保密
		<input type="radio" name="data[User][sex]" <?php if($this->data['User']['sex'] == 1){?>checked="checked"<?php }?> value="1"/>男
		<input type="radio" name="data[User][sex]"  <?php if($this->data['User']['sex'] == 2){?>checked="checked"<?php }?> value="2"/>女</dd></dl>
        <dl><dt>出生日期：</dt><dd>
          <input  style="width:80px;"type="text" id="date" name="data[User][birthday]"  /><?php echo $html->image("calendar.gif",array("id"=>"show","class"=>"calendar_edit"))?></dd></dl>
		<?php if(isset($user_infoarr) && sizeof($user_infoarr)>0){?>
		<?php foreach($user_infoarr as $k=>$v){?>
		 <?php if($v['UserInfo']['backend'] == 1){?>
		 	 <?php if($v['UserInfo']['type'] == "text"){?>
		<dl><dt class="config_lang"><?php echo $v['UserInfo']['name']?>：</dt>
		       <input id="ValueId" name="info_value[<?php echo $v['UserInfo']['id']?>]" type="hidden" value="<?php echo $v['UserInfo']['id']?>">

			<dd><input type="text" class="text_inputs" name="info_value_id[<?php echo $v['UserInfo']['id']?>]" style="width:265px;"/></dd></dl>
		<?php }?>
		<?php if($v['UserInfo']['type'] == "radio"){?>
		<dl><dt class="config_lang"><?php echo $v['UserInfo']['name']?>：</dt>
	
			<dd>
			<?php $one_arr = explode(";",$v['UserInfo']['user_info_values']);?>
			<?php foreach($one_arr as $kkk=>$vvv){$two_arr = explode(":",$vvv);?>
		       <input id="ValueId" name="info_value[<?php echo $v['UserInfo']['id']?>]" type="hidden" value="<?php echo $v['UserInfo']['id']?>">

				<input type="radio" value="<?php echo $two_arr[0]?>" name="info_value_id[<?php echo $v['UserInfo']['id']?>]" checked ><?php echo $two_arr[1]?>
			<?php }?>

	</dd></dl>
		<?php }?>	<?php if($v['UserInfo']['type'] == "checkbox"){?>
		<dl><dt class="config_lang"><?php echo $v['UserInfo']['name']?>：</dt>
			<dd>
			<?php $one_arr = explode(";",$v['UserInfo']['user_info_values']);?>
			<?php foreach($one_arr as $kkk=>$vvv){$two_arr = explode(":",$vvv);?>
		       <input id="ValueId" name="info_value[<?php echo $v['UserInfo']['id']?>]" type="hidden" value="<?php echo $v['UserInfo']['id']?>">

				<input type="checkbox"  value="<?php echo $two_arr[0]?>" name="info_value_id[<?php echo $v['UserInfo']['id']?>][]"  ><?php echo $two_arr[1]?>
			<?php }?>

	</dd></dl>
		<?php }?>
		 	 <?php if($v['UserInfo']['type'] == "textarea"){?>
		<dl><dt class="config_lang"><?php echo $v['UserInfo']['name']?>：</dt>
		       <input id="ValueId" name="info_value[<?php echo $v['UserInfo']['id']?>]" type="hidden" value="<?php echo $v['UserInfo']['id']?>">

			<dd><textarea type="text" class="text_inputs" style="width:265px;" name="info_value_id[<?php echo $v['UserInfo']['id']?>]" /></textarea></dd></dl>
		<?php }?> <?php if($v['UserInfo']['type'] == "select"){?>
		<dl><dt class="config_lang"><?php echo $v['UserInfo']['name']?>：</dt>
			<dd>
			<?php $one_arr = explode(";",$v['UserInfo']['user_info_values']);?>
		       <input id="ValueId" name="info_value[<?php echo $v['UserInfo']['id']?>]" type="hidden" value="<?php echo $v['UserInfo']['id']?>">

			<select class="text_inputs" style="width:265px;" name="info_value_id[<?php echo $v['UserInfo']['id']?>]" >
			<?php foreach($one_arr as $kkk=>$vvv){$two_arr = explode(":",$vvv);?>
				<option value="<?php echo $two_arr[0]?>" ><?php echo $two_arr[1]?></option>
			<?php }?>
			</select>
	</dd></dl>
		<?php }?>
				<?php }?>
		<?php }}?>
	<!--	<dl><dt class="config_lang">信用额度：</dt>
			<dd><input type="text" class="text_inputs" style="width:115px;" /></dd></dl>	-->
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Password-->
	<div class="order_stat athe_infos tongxun">
	  
	  <div class="box">
		
		<dl><dt>密码：</dt>
			<dd><input type="password" class="text_inputs" style="width:270px;" id="user_new_password" name="data[User][new_password]"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt>重复密码：</dt>
			<dd><input type="password" class="text_inputs" style="width:270px;" id="user_new_password2" name="data[User][new_password2]"/> <font color="#F94671">*</font></dd></dl>
	  </div>
	</div>
<!--Password End-->


</td>
</tr>
<tr><td colspan="2"><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p></td></tr>
</table>
<?php echo $form->end();?>

</div>
<!--Main Start End-->
<?php echo $html->image('content_left.gif',array('class'=>'content_left'))?><?php echo $html->image('content_right.gif',array('class'=>'content_right'))?>
</div>
