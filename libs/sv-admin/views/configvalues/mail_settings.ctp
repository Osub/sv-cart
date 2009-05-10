<?php
/*****************************************************************************
 * SV-Cart 商店设置
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($infoes);pr($basics);?>
<!--Main Start-->
<div class="home_main">
<!--ConfigValues-->
<script language="javascript">
 function show_intro(pre,pree, n, select_n,css) {
 for (i = 1; i <= n; i++) {
 var intro = document.getElementById(pre + i);
 var cha = document.getElementById(pree + i);
 intro.style.display = "none";
 cha.className=css + "_off";
 if (i == select_n) {
 intro.style.display = "block";
 cha.className=css + "_on";
 }
 }
 }
 window.onload = function(){
  show_intro('hdblock3_c<?php echo $sumbasic;?>','hdblock3_t<?php echo $sumbasic;?>',<?php echo $sumbasic;?>,1,'hdblock3');
 }
</script>
<style type="text/css">
table.table_list select{border:1px solid #649776;padding:0;}
table.water td{vertical-align:middle;}
table.water td.select_img img{vertical-align:middle;}
table.water td.select_img input{margin-bottom:-1px;}
table.table_list th{text-align:right;vertical-align:top;padding-top:7px;}
table.table_list td.textinput input{border:1px solid #649776}
table.table_list td.textinput textarea{border:1px solid #649776;overflow-y:scroll;width:270px;}
td p{margin:0 0 3px 0;}
td img{margin:0 3px 0 3px;}
td select,td input{font-size:12px;font-family:arial;}
</style>
<?php echo $form->create('Configvalue',array('action'=>'mail_settings_edit','enctype'=>"multipart/form-data"));?>
<div class="order_stat athe_infos configvalues">
 <ul class="cat_tab">
    <?if(isset($basics) && sizeof($basics)>0){?>
  <?php $i=0;$n=1;
   foreach($basics as $k=>$v){ ?>
 <?if($n==1){?>
 <li class="hdblock3_on" id="hdblock3_t<?php echo $sumbasic.$n;?>" onclick="show_intro('hdblock3_c<?php echo $sumbasic;?>','hdblock3_t<?php echo $sumbasic;?>',<?php echo $sumbasic;?>,<?php echo $n;?>,'hdblock3')">邮件服务器设置</li> 
 <?}else{?>
 <li class="hdblock3_off" id="hdblock3_t<?php echo $sumbasic.$n;?>" onclick="show_intro('hdblock3_c<?php echo $sumbasic;?>','hdblock3_t<?php echo $sumbasic;?>',<?php echo $sumbasic;?>,<?php echo $n;?>,'hdblock3')">邮件服务器设置</li> 
 <?php }$n++;}?>
 	 <?}?>
 </ul>
 <div class="box">
<?php $n=1;foreach($basics as $infoes){?>
 <div class="hdblock3_c" id="hdblock3_c<?php echo $sumbasic.$n;?>" style="display:<?php if($n==1)echo 'block';else echo 'none';?>;">
<!--shop_config-->
<div class="shop_config" style="width:auto;">
<table cellpadding="4" class="table_list">
<?php foreach($infoes as $info){
if($info['Config']['type']=="select"){?>
<tr>
<th><?php echo $info['Config']['name'].':'?></th>
<td>
<table>
 <?php foreach($languages as $k=>$v){if(isset($info['ConfigI18n'][$v['Language']['locale']]['id']) && !empty($info['ConfigI18n'][$v['Language']['locale']]['id'])){?>
 <tr>
 <td><?=$v['Language']['name'];?></td>
 <input name="data[<?=$i;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
 <input name="data[<?=$i;?>][config_id]" type="hidden" value="<?= $info['Config']['id'];?>">
 <input name="data[<?=$i;?>][id]" type="hidden" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])) echo $info['ConfigI18n'][$v['Language']['locale']]['id'];?>">
 
 <td><select name="data[<?=$i;?>][value]"/>
 <?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['options']) && !empty($info['ConfigI18n'][$v['Language']['locale']]['options'])){$options = explode(';',$info['ConfigI18n'][$v['Language']['locale']]['options']);foreach($options as $option){$text =explode(":",$option);?>
 <option value="<?php echo $text[0];?>" <?php if($text[0]==$info['ConfigI18n'][$v['Language']['locale']]['value']) echo 'selected';?>><?php if(@$text[1]){ echo $text[1];} ?></option>


 <?php }} ?></select> </td>
 </tr>
 <?php $i++;}}?>
 </table>
 </td>
 </tr><?php }?>
 
 <?php if($info['Config']['type']=="text"){?>
 <tr>
 <th><?php echo @$info['Config']['name'].':'?></th>
 <td>
 <table>
 <?php foreach($languages as $k=>$v){if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])&&!empty($info['ConfigI18n'][$v['Language']['locale']]['id'])){?>
 <tr>
 <td><?=$v['Language']['name'];?></td>
 <td class="textinput">
 <input name="data[<?=$i;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
 <input name="data[<?=$i;?>][config_id]" type="hidden" value="<?= $info['Config']['id'];?>">
 <input name="data[<?=$i;?>][id]" type="hidden" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])) echo $info['ConfigI18n'][$v['Language']['locale']]['id'];?>">
 <input type="text" size="50" name="data[<?=$i;?>][value]" id="<?=$info['Config']['code']?><?=$v['Language']['locale'];?>" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['value']))echo $info['ConfigI18n'][$v['Language']['locale']]['value']; ?>" /><?=$html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:config_help({$info['ConfigI18n'][$v['Language']['locale']]['id']})",'',false,false)?><span id="config_help_<?=$info['ConfigI18n'][$v['Language']['locale']]['id']?>" style="visibility :hidden" ><?=$info['ConfigI18n'][$v['Language']['locale']]['description']?>
 
 </td>
 </tr>
 
 <?php $i++;}}?>
 </table>
 </td>
 </tr>
 <?php }?>
 <?php if($info['Config']['type']=="textarea"){?>
 <tr>
 <th><?php echo @$info['Config']['name'].':'?></th>
 <td>
 <table>
 <?php foreach($languages as $k=>$v){if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])&&!empty($info['ConfigI18n'][$v['Language']['locale']]['id'])){?>
 <tr>
 <td><?=$v['Language']['name'];?></td>
 <td class="textinput">
 <input name="data[<?=$i;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
 <input name="data[<?=$i;?>][config_id]" type="hidden" value="<?= $info['Config']['id'];?>">
 <input name="data[<?=$i;?>][id]" type="hidden" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])) echo $info['ConfigI18n'][$v['Language']['locale']]['id'];?>">
 <textarea name="data[<?=$i;?>][value]"><?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['value']))echo $info['ConfigI18n'][$v['Language']['locale']]['value']; ?></textarea><?=$html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:config_help({$info['ConfigI18n'][$v['Language']['locale']]['id']})",'',false,false)?><span id="config_help_<?=$info['ConfigI18n'][$v['Language']['locale']]['id']?>" style="visibility :hidden" ><?=$info['ConfigI18n'][$v['Language']['locale']]['description']?>
 </td>
 </tr>
 
 <?php $i++;}}?>
 </table>
 </td>
 </tr>
 <?php }?>
 <?php if($info['Config']['type']=="radio"){?>
 <tr>
 <th><?php echo $info['Config']['name'].':'?></th>
 <td class="radio">
 <table>
 <?php foreach($languages as $k=>$v){if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])&&!empty($info['ConfigI18n'][$v['Language']['locale']]['id'])){?>
 <tr>
 <td><?=$v['Language']['name'];?></td>
 <input name="data[<?=$i;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
 <input name="data[<?=$i;?>][config_id]" type="hidden" value="<?= $info['Config']['id'];?>">
 <input name="data[<?=$i;?>][id]" type="hidden" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])) echo $info['ConfigI18n'][$v['Language']['locale']]['id'];?>">
 <td>
 <?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['options'])){$options = $info['ConfigI18n'][$v['Language']['locale']]['options'];foreach($options as $option){$text =explode(":",$option); if(@$text[1]!=""){?>
 <label><input type="radio" name="data[<?=$i;?>][value]" value="<?php echo $text[0];?>" <?php if(@$text[0]==$info['ConfigI18n'][$v['Language']['locale']]['value']) echo 'checked';?>/><?php if(@$text[1]){ echo $text[1];}?></label>
 <?php }}?><?=$html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:config_help({$info['ConfigI18n'][$v['Language']['locale']]['id']})",'',false,false)?><span id="config_help_<?=$info['ConfigI18n'][$v['Language']['locale']]['id']?>" style="visibility :hidden" ><?=$info['ConfigI18n'][$v['Language']['locale']]['description']?>
 </td>
 <?} ?>
 </tr>
 <?php $i++;}}?>
 </table></td>
 </tr>
 <?php }?>
 <?php if($info['Config']['type']=="image"){?>
 <tr>
 <th><?php echo @$info['Config']['name'].':'?></th>
 <td>
 <table class="water">
 <?php foreach($languages as $k=>$v){if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])&&!empty($info['ConfigI18n'][$v['Language']['locale']]['id'])){?>
 <tr>
 <td><?=$v['Language']['name'];?></td>
 <td class="textinput select_img">
 <input name="data[<?=$i;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
 <input name="data[<?=$i;?>][config_id]" type="hidden" value="<?= $info['Config']['id'];?>">
 <input name="data[<?=$i;?>][id]" type="hidden" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])) echo $info['ConfigI18n'][$v['Language']['locale']]['id'];?>">
 <input type="text" size="50" name="data[<?=$i;?>][value]" id="upload_img_text_<?=$i;?>" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['value']))echo $info['ConfigI18n'][$v['Language']['locale']]['value']; ?>" />
 <?=$html->link($html->image('select_img.gif',$title_arr['select_img'],array("align"=>"absmiddle")),"javascript:img_sel(".$i.",'others')",'',false,false)?>
 </td>
 <td>
 <?=@$html->image("{$info['ConfigI18n'][$v['Language']['locale']]['value']}",array('id'=>'logo_thumb_img_'.$i,'height'=>'150'))?>
</td>
 <td valign="middle">
 <?=@$html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:config_help({$info['ConfigI18n'][$v['Language']['locale']]['id']})",'',false,false)?>
 <span id="config_help_<?=$info['ConfigI18n'][$v['Language']['locale']]['id']?>" style="visibility :hidden" ><?=$info['ConfigI18n'][$v['Language']['locale']]['description']?></span>
 </td>
 </tr>
 <?php $i++;}}?>
 </table>
 </td>
 </tr>
 <?php }?>
 <?php if($info['Config']['type']=="checkbox"){?>
 <tr>
 <th><?php echo $info['Config']['name'].':'?></th>
 <td class="radio">
 <table>
 <?php foreach($languages as $k=>$v){if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])&&!empty($info['ConfigI18n'][$v['Language']['locale']]['id'])){?>
 <tr>
 <td><?=$v['Language']['name'];?></td>
 <td>
 <input name="data[<?=$i;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
 <input name="data[<?=$i;?>][config_id]" type="hidden" value="<?= $info['Config']['id'];?>">
 <input name="data[<?=$i;?>][id]" type="hidden" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])) echo $info['ConfigI18n'][$v['Language']['locale']]['id'];?>">
 <?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['options'])&&!empty($info['ConfigI18n'][$v['Language']['locale']]['options'])){$checkoptions = explode(';',$info['ConfigI18n'][$v['Language']['locale']]['value']);$options = $info['ConfigI18n'][$v['Language']['locale']]['options'];foreach($options as $option){$text =explode(":",$option);if(@$text[1]!=""){?>
 <label><input type="checkbox" name="data[<?=$i;?>][value][]" value="<?php echo $text[0];?>" <?php if( in_array($text[0],$checkoptions)) echo 'checked';?>/><?php if(@$text[1]){ echo $text[1];}?></label>
 <?php } ?><?}?><?=$html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:config_help({$info['ConfigI18n'][$v['Language']['locale']]['id']})",'',false,false)?><span id="config_help_<?=$info['ConfigI18n'][$v['Language']['locale']]['id']?>" style="visibility :hidden" ><?=$info['ConfigI18n'][$v['Language']['locale']]['description']?>
 </td>
 </tr>
 <?php $i++;}}}?>
 </table>
 </td>
 </tr>
 <?php }?>


 <?php }?>
  <tr>
 <th>邮件地址:</th>
 <td><input type="text" style="width:250px;*width:180px;border:1px solid #649776" id="email_addr" /><input style="cursor:pointer;" type="button" value="发送测试邮件" onclick="test_email()" /></td>
 </tr>
 </table>
 </div>
 </div> 
 <?php $n++;}?>
</div>
 <p class="submit_values"><input style="cursor:pointer;" type="submit" value="确 定" /><input style="cursor:pointer;" type="reset" value="重 置" /></p>
 </div>
<?php $form->end();?> 
<!--ConfigValues End-->
</div>
<!--Main End-->
</div>

<script type="text/javascript">

function config_help(id){
	var config_help = document.getElementById("config_help_"+id);

	if(config_help.style.visibility  == "hidden"){
		config_help.style.visibility  = "visible";
	}else{
		config_help.style.visibility  = "hidden";
	
	}
}


function test_email(){
	YAHOO.example.container.wait.show();
	var email_addr = document.getElementById('email_addr');
	var smtp_pass = document.getElementById('smtp_pass'+now_locale);
	var smtp_host = document.getElementById('smtp_host'+now_locale);
	var smtp_user = document.getElementById('smtp_user'+now_locale);
	
	var sUrl = webroot_dir+"configvalues/test_email/"+email_addr.value+"/"+smtp_host.value+"/"+smtp_user.value+"/"+smtp_pass.value;
	
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, test_email_callback);

}
var test_email_Success = function(o){
	
	YAHOO.example.container.wait.hide();
	layer_dialog();
	if(o.responseText==1){
		layer_dialog_show("恭喜！测试邮件已成功发送到 "+document.getElementById('email_addr').value,"",3);
	}else{
		layer_dialog_show("邮件服务器验证帐号或密码不正确","",3);
	}
}
	
var test_email_Failure = function(o){
		
}

var test_email_callback ={
	success:test_email_Success,
	failure:test_email_Failure,
	timeout : 300000,
	argument: {}
};

</script>