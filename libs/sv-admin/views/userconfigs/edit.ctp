<?php
/*****************************************************************************
 * SV-Cart 编辑用户设置
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 1201 2009-05-05 13:30:17Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."用户设置列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>
<div class="home_main">
<?php echo $form->create('Userconfig',array('action'=>'/edit/'.$userconfig['UserConfig']['id'],'onsubmit'=>'return userconfigs_checks();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title">
		<h1>
	  	<?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  	<?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  	编辑用户设置</h1>
	</div>
	<div class="box">
<!--Mailtemplates_Config-->
	<input type="hidden" name="data[UserConfig][id]" value="<?=$userconfig['UserConfig']['id'];?>">
	  <div class="shop_config menus_configs">
	  	<dl><dt style="width:105px;">用户名称： </dt>
		<dd></dd></dl>

<?if(isset($languages) && sizeof($languages)>0){foreach($languages as $k => $v){?>
		<input id="UserConfigI18n<?=$k;?>Locale" name="data[UserConfigI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
	   	<?if(isset($userconfig['UserConfigI18n'][$v['Language']['locale']])){?>
			<input id="UserConfigI18n<?=$k;?>Id" name="data[UserConfigI18n][<?=$k;?>][id]" type="hidden" value="<?= $userconfig['UserConfigI18n'][$v['Language']['locale']]['id'];?>">
	   	<?}?>
	   	<input id="UserConfigI18n<?=$k;?>UserConfigId" name="data[UserConfigI18n][<?=$k;?>][user_config_id]" type="hidden" value="<?= $userconfig['UserConfig']['id'];?>">
<?}}?>

<? if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<dl><dt style="width:105px;"><?=$html->image($v['Language']['img01'])?></dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="nowname<?=$v['Language']['locale']?>" name="data[UserConfigI18n][<?=$k;?>][name]" value="<?=@$userconfig['UserConfigI18n'][$v['Language']['locale']]['name'];?>" /> <font color="#ff0000">*</font></dd></dl>
<?}}?>		
		<dl><dt style="width:105px;">用户等级： </dt>
		<dd>
		<select name="data[UserConfig][user_rank]">
		<option value="0"<?if($userconfig['UserConfig']['user_rank']==0){echo "selected";}?> >普通用户</option>
		<? if(isset($memberlevel_list) && sizeof($memberlevel_list)>0){?>
		<?foreach( $memberlevel_list as $k=>$v ){?>
		<option value="<?=$v['UserRank']['id']?>"<?if($userconfig['UserConfig']['user_rank']==$v['UserRank']['id']){echo "selected";}?>><?=$v['UserRankI18n']['name']?></option>
		<?}}?>
		</select>
		<!--	
			<input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[UserConfig][user_rank]" value="<?=$userconfig['UserConfig']['user_rank'];?>" />
		-->
		</dd></dl>
		
		<dl><dt style="width:105px;">默认值： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[UserConfig][value]" value="<?=$userconfig['UserConfig']['value'];?>"  /></dd></dl>
		<dl><dt style="width:105px;">参数名称： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[UserConfig][code]" value="<?=$userconfig['UserConfig']['code'];?>"  /></dd></dl>

		<dl><dt style="width:105px;">HTML类型：</dt>
		
		<dd>
		<select name="data[UserConfig][type]" onchange="selectClicked(this.value)" >
		<option value="text" <?php if($userconfig['UserConfig']['type']=="text"){echo "selected";} ?> >text</option>
		<option value="radio" <?php if($userconfig['UserConfig']['type']=="radio"){echo "selected";} ?> >radio</option>
		<option value="select" <?php if($userconfig['UserConfig']['type']=="select"){echo "selected";} ?> >select</option>
		<option value="checkbox" <?php if($userconfig['UserConfig']['type']=="checkbox"){echo "selected";} ?> >checkbox</option>
		<option value="textarea" <?php if($userconfig['UserConfig']['type']=="textarea"){echo "selected";} ?> >textarea</option>
		</select>
		</dd></dl>
		<h2>描述：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea style="width:590px;height:165px;" name="data[UserConfigI18n][<?=$k;?>][description]" ><?=@$userconfig['UserConfigI18n'][$v['Language']['locale']]['description'];?></textarea></span></p>
		
<?	}
   } ?>	
<div id="option_textarea" <?if($userconfig['UserConfig']['type'] == 'text' || $userconfig['UserConfig']['type'] == 'textarea'){?>style="display:none"<?}elseif($userconfig['UserConfig']['type'] == 'radio' || $userconfig['UserConfig']['type'] == 'select' ||  $userconfig['UserConfig']['type'] == 'checkbox' ){?>style="display:block"<?}?>>
			
		<h2>可选值：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea style="width:590px;height:165px;" name="data[UserConfigI18n][<?=$k;?>][values]" ><?=@$userconfig['UserConfigI18n'][$v['Language']['locale']]['values'];?></textarea></span></p>
		
<?	}
   } ?>	
			</div>
		
		
		<dl><dt style="width:105px;">排序：</dt>
			<dd><input type="text" style="border:1px solid #649776" value="<?=$userconfig['UserConfig']['orderby'];?>" name="data[UserConfig][orderby]" onkeyup="check_input_num(this)" /><font color="#646464"><br />如果您不输入排序号，系统将默认为50</font></dd></dl>
		
		<br />
		
		</div>
<!--Mailtemplates_Config End-->
		
		
		
	  </div>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
<? echo $form->end();?>


</div>
<!--Main End-->
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