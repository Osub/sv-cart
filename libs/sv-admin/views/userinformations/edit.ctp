<?php
/*****************************************************************************
 * SV-Cart 编辑用户信息管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 943 2009-04-23 10:38:44Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."用户信息列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>
<!--Main Start-->

<div class="home_main">
<?php echo $form->create('userinformations',array('action'=>'edit/'.$userinfo_info['UserInfo']['id'],'onsubmit'=>'return userinformations_check();'));?>
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td  align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->

<input type="hidden" name="data[UserInfo][id]" value="<?=$userinfo_info['UserInfo']['id']?>">
	<div class="order_stat athe_infos department_config">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑用户信息</h1></div>
	  <div class="box">
	  <br />
  	    <dl><dt class="config_lang">类型:</dt>
		<dd>
		<select name="data[UserInfo][type]"  onchange="selectClicked(this.value)" >
		<option value="text"  <?if($userinfo_info['UserInfo']['type']=="text"){ echo "selected";}?> >text</option>
		<option value="radio"   <?if($userinfo_info['UserInfo']['type']=="radio"){ echo "selected";}?> >radio</option>
		<option value="select"   <?if($userinfo_info['UserInfo']['type']=="select"){ echo "selected";}?> >select</option>
		<option value="checkbox"  <?if($userinfo_info['UserInfo']['type']=="checkbox"){ echo "selected";}?> >checkbox</option>
		<option value="textarea"  <?if($userinfo_info['UserInfo']['type']=="textarea"){ echo "selected";}?>  >textarea</option>
		</select>
		</dd>
		</dl>
		
		<dl><dt class="config_lang">名称:</dt><dd></dd></dl>
		<? if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>		
		<dl><dt class="config_lang"><?=$html->image($v['Language']['img01'])?></dt><dd><input type="text" class="text_inputs" style="width:320px;" id="name<?=$v['Language']['locale']?>" name="data[UserInfoI18n][<?=$k;?>][name]" value="<?=@$userinfo_info['UserInfoI18n'][$v['Language']['locale']]['name']?>"/> <font color="#ff0000">*</font></dd></dl>
		<?}}?>	
		<dl><dt class="config_lang">提示信息:</dt><dd></dd></dl>
		<? if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>		
		<dl><dt class="config_lang"><?=$html->image($v['Language']['img01'])?></dt><dd><input type="text" class="text_inputs" style="width:320px;" name="data[UserInfoI18n][<?=$k;?>][message]" value="<?=@$userinfo_info['UserInfoI18n'][$v['Language']['locale']]['message']?>"/></dd></dl>
		<?}}?>	
		<dl><dt class="config_lang">备注:</dt><dd></dd></dl>
		<? if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>		
			<input type="hidden" name="data[UserInfoI18n][<?=$k;?>][locale]" value="<?=$v['Language']['locale']?>">	
		<dl><dt class="config_lang"><?=$html->image($v['Language']['img01'])?></dt><dd><textarea name="data[UserInfoI18n][<?=$k;?>][remark]" ><?=@$userinfo_info['UserInfoI18n'][$v['Language']['locale']]['remark']?></textarea></dd></dl>
		<?}}?>	
<div id="option_textarea" <?if($userinfo_info['UserInfo']['type'] == 'text' || $userinfo_info['UserInfo']['type'] == 'textarea'){?>style="display:none"<?}elseif($userinfo_info['UserInfo']['type'] == 'radio' || $userinfo_info['UserInfo']['type'] == 'select' ||  $userinfo_info['UserInfo']['type'] == 'checkbox' ){?>style="display:block"<?}?>>

	 	<dl><dt class="config_lang">可选值：</dt><dd></dd></dl>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<dl><dt class="config_lang"><?=$html->image($v['Language']['img01'])?></dt><dd><textarea  name="data[UserInfoI18n][<?=$k;?>][values]" ><?=@$userinfo_info['UserInfoI18n'][$v['Language']['locale']]['values'];?></textarea></dd></dl>
<?	}
   } ?>	
   			</div>
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Password-->
	<div class="order_stat athe_infos">
	  
	  <div class="box">
		<br />
		<dl><dt>是否有效：</dt>
			<dd><input type="radio" value="1" name="data[UserInfo][status]" <?if($userinfo_info['UserInfo']['status'] == 1){echo "checked";}?> />是<input type="radio" name="data[UserInfo][status]" value="0"<?if($userinfo_info['UserInfo']['status']== 0){echo "checked";}?> />否</dd></dl>
		<dl><dt>前台是否显示：</dt>
			<dd><input type="radio" name="data[UserInfo][front]" value="1" <?if($userinfo_info['UserInfo']['front']== 1){echo "checked";}?> />是<input type="radio" name="data[UserInfo][front]" value="0" <?if($userinfo_info['UserInfo']['front']== 0){echo "checked";}?>  />否</dd></dl>
		<dl><dt>后台是否显示：</dt>
			<dd><input type="radio" name="data[UserInfo][backend]" value="1" <?if($userinfo_info['UserInfo']['backend'] == 1){echo "checked";}?> />是<input type="radio" name="data[UserInfo][backend]" value="0" <?if($userinfo_info['UserInfo']['backend'] == 0){echo "checked";}?> />否</dd></dl>
		<dl><dt>排序：</dt>
			<dd><input type="text" name="data[UserInfo][orderby]" value="<?=$userinfo_info['UserInfo']['orderby']?>" onkeyup="check_input_num(this)" ><br /> 如果您不输入排序号，系统将默认为50</dd></dl>
		
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	  </div>
	</div>
<!--Password End-->

</td>
</tr>
<tr><td colspan="2"><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p></td></tr>
</table>
<? echo $form->end();?>

</div>
<!--Main Start End-->
<?=$html->image('content_left.gif',array('class'=>'content_left'))?><?=$html->image('content_right.gif',array('class'=>'content_right'))?>
</div>
<script language="JavaScript">

function selectClicked(htmlType){
    send_style=document.getElementById('option_textarea');
    if(htmlType == 'text'|| htmlType == 'textarea'){
            if(send_style.style.display=="block"){
		          send_style.style.display="none";
	         }
    }
    else if(htmlType == 'radio'|| htmlType == 'select' || htmlType == 'checkbox'){
          	if(send_style.style.display=="none"){
		          send_style.style.display="block";
	         }
    }

}
</script>