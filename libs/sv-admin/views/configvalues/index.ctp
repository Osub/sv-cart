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
 * $Id: index.ctp 3779 2009-08-19 10:40:08Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($infoes);pr($basics);?>
<!--Main Start-->
<div class="home_main">
<!--ConfigValues-->
<script language="javascript">
 function show_intro(url) {
 		window.location.href=webroot_dir+"configvalues/index/"+url;
 }

</script>
<style type="text/css">
table.table_list select{border:1px solid #649776;padding:0;}
table.water td{vertical-align:middle;}
table.water td.select_img input{margin-bottom:-1px;}
table.table_list th{text-align:right;vertical-align:top;padding-top:7px;white-space:nowrap;}
* html table.table_list th{padding-top:10px;}
table.table_list td{padding-top:2px;}
* html table.table_list td{padding-top:5px;}
table.table_list td.textinput{padding-top:0;}
table.table_list td.textinput input{border:1px solid #649776}
table.table_list td.textinput textarea{border:1px solid #649776;overflow-y:scroll;width:270px;}
td p{margin:0 0 3px 0;}
td img{margin:0 3px 0 3px;}
td select,td input{font-size:12px;font-family:arial;}
</style>
<?php echo $form->create('Configvalue',array('action'=>'edit','enctype'=>"multipart/form-data"));?>
<div class="order_stat athe_infos configvalues">

 <ul class="cat_tab">
    
    <?php if(isset($config_group_code) && sizeof($config_group_code)>0){?>
  <?php $i=0;$n=1;
   foreach($config_group_code as $k=>$v){if($k=="email"){continue;}?>
 <?php if($k==$group_codess){?>
 <li class="hdblock3_on" id="hdblock3_t<?php echo $sumbasic.$n;?>" onclick="show_intro('<?php echo $k?>')"><?php echo $v?></li> 
 <?php }else{?>
 <li class="hdblock3_off" id="hdblock3_t<?php echo $sumbasic.$n;?>" onclick="show_intro('<?php echo $k?>')"><?php echo $v?></li> 
 <?php }$n++;}?>
 	 <?php }?>
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
 <td><?php echo $v['Language']['name'];?></td>
 <input name="data[<?php echo $i;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
 <input name="data[<?php echo $i;?>][config_id]" type="hidden" value="<?php echo  $info['Config']['id'];?>">
 <input name="data[<?php echo $i;?>][id]" type="hidden" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])) echo $info['ConfigI18n'][$v['Language']['locale']]['id'];?>">
 
 <td><select name="data[<?php echo $i;?>][value]"/>
 <?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['options']) && !empty($info['ConfigI18n'][$v['Language']['locale']]['options'])){$options = explode(';',$info['ConfigI18n'][$v['Language']['locale']]['options']);foreach($options as $option){$text =explode(":",$option);?>
 <option value="<?php echo $text[0];?>" <?php if($text[0]==$info['ConfigI18n'][$v['Language']['locale']]['value']) echo 'selected';?>><?php if(@$text[1]){ echo $text[1];} ?></option>


 <?php }} ?></select> <?php echo $html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:config_help({$info['ConfigI18n'][$v['Language']['locale']]['id']})",'',false,false)?><span id="config_help_<?php echo $info['ConfigI18n'][$v['Language']['locale']]['id']?>" style="visibility :hidden" ><?php echo $info['ConfigI18n'][$v['Language']['locale']]['description']?></td>
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
 <td><?php echo $v['Language']['name'];?></td>
 <td class="textinput">
 <input name="data[<?php echo $i;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
 <input name="data[<?php echo $i;?>][config_id]" type="hidden" value="<?php echo  $info['Config']['id'];?>">
 <input name="data[<?php echo $i;?>][id]" type="hidden" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])) echo $info['ConfigI18n'][$v['Language']['locale']]['id'];?>">
 <input type="text" size="50" name="data[<?php echo $i;?>][value]" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['value']))echo $info['ConfigI18n'][$v['Language']['locale']]['value']; ?>" /><?php echo $html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:config_help({$info['ConfigI18n'][$v['Language']['locale']]['id']})",'',false,false)?><span id="config_help_<?php echo $info['ConfigI18n'][$v['Language']['locale']]['id']?>" style="visibility :hidden" ><?php echo $info['ConfigI18n'][$v['Language']['locale']]['description']?>
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
 <td><?php echo $v['Language']['name'];?></td>
 <td class="textinput">
 <input name="data[<?php echo $i;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
 <input name="data[<?php echo $i;?>][config_id]" type="hidden" value="<?php echo  $info['Config']['id'];?>">
 <input name="data[<?php echo $i;?>][id]" type="hidden" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])) echo $info['ConfigI18n'][$v['Language']['locale']]['id'];?>">
 <textarea name="data[<?php echo $i;?>][value]"><?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['value']))echo $info['ConfigI18n'][$v['Language']['locale']]['value']; ?></textarea><?php echo $html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:config_help({$info['ConfigI18n'][$v['Language']['locale']]['id']})",'',false,false)?><span id="config_help_<?php echo $info['ConfigI18n'][$v['Language']['locale']]['id']?>" style="visibility :hidden" ><?php echo $info['ConfigI18n'][$v['Language']['locale']]['description']?>
 </td>
 </tr>
 
 <?php $i++;}}?>
 </table>
 </td>
 </tr>
 <?php }?>
 <?php if($info['Config']['type']=="radio"){?>
 <tr>
 <th style="padding-top:7px;*padding-top:16px;"><?php echo $info['Config']['name'].':'?></th>
 <td class="radio">
 <table>
 <?php foreach($languages as $k=>$v){if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])&&!empty($info['ConfigI18n'][$v['Language']['locale']]['id'])){?>
 <tr>
 <td style="padding-top:3px;*padding-top:8px;"><?php echo $v['Language']['name'];?></td>
 <input name="data[<?php echo $i;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
 <input name="data[<?php echo $i;?>][config_id]" type="hidden" value="<?php echo  $info['Config']['id'];?>">
 <input name="data[<?php echo $i;?>][id]" type="hidden" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])) echo $info['ConfigI18n'][$v['Language']['locale']]['id'];?>">
 <td>
 <?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['options'])){$options = $info['ConfigI18n'][$v['Language']['locale']]['options'];foreach($options as $option){$text =explode(":",$option); if(@$text[1]!=""){?>
 <label><input type="radio" name="data[<?php echo $i;?>][value]" value="<?php echo $text[0];?>" <?php if(@$text[0]==$info['ConfigI18n'][$v['Language']['locale']]['value']) echo 'checked';?>/><?php if(@$text[1]){ echo $text[1];}?></label>
 <?php }}?><?php echo $html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:config_help({$info['ConfigI18n'][$v['Language']['locale']]['id']})",'',false,false)?><span id="config_help_<?php echo $info['ConfigI18n'][$v['Language']['locale']]['id']?>" style="visibility :hidden" ><?php echo $info['ConfigI18n'][$v['Language']['locale']]['description']?>
 </td>
 <?php } ?>
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
 <td style="vertical-align:top;"><?php echo $v['Language']['name'];?></td>
 <td class="textinput select_img" style="vertical-align:top;">
 <input name="data[<?php echo $i;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
 <input name="data[<?php echo $i;?>][config_id]" type="hidden" value="<?php echo  $info['Config']['id'];?>">
 <input name="data[<?php echo $i;?>][id]" type="hidden" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])) echo $info['ConfigI18n'][$v['Language']['locale']]['id'];?>">
 <input type="text" size="50" style="width:252px" name="data[<?php echo $i;?>][value]" id="upload_img_text_<?php echo $i;?>" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['value']))echo $info['ConfigI18n'][$v['Language']['locale']]['value']; ?>" /><?php echo $html->link($html->image('select_img.gif',array("class"=>"vmiddle icons","height"=>"20",$title_arr['select_img'])),"javascript:img_sel(".$i.",'others')",'',false,false)?><?php echo @$html->link($html->image('help_icon.gif',array("class"=>"vmiddle",$title_arr['help'])),"javascript:config_help({$info['ConfigI18n'][$v['Language']['locale']]['id']})",'',false,false)?>
<span id="config_help_<?php echo $info['ConfigI18n'][$v['Language']['locale']]['id']?>" style="visibility :hidden" ><?php echo $info['ConfigI18n'][$v['Language']['locale']]['description']?></span>
 </td>
 <td>
 <?php echo @$html->image($server_host.$root_all.$info['ConfigI18n'][$v['Language']['locale']]['value'],array('id'=>'logo_thumb_img_'.$i,'style'=>strlen(trim($info['ConfigI18n'][$v['Language']['locale']]['value']))>0?"display:block":"display:none"))?>
</td>
 <td valign="middle">
 
 
 </td>
 </tr>
 <?php $i++;}}?>
 </table>
 </td>
 </tr>
 <?php }?>
 <?php if($info['Config']['type']=="checkbox"){?>
 <tr>
 <th style="padding-top:8px;*padding-top:15px;"><?php echo $info['Config']['name'].':'?></th>
 <td class="radio">
 <table>
 <?php foreach($languages as $k=>$v){if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])&&!empty($info['ConfigI18n'][$v['Language']['locale']]['id'])){?>
 <tr>
 <td style="padding-top:3px;*padding-top:10px;"><?php echo $v['Language']['name'];?></td>
 <td>
 <input name="data[<?php echo $i;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
 <input name="data[<?php echo $i;?>][config_id]" type="hidden" value="<?php echo  $info['Config']['id'];?>">
 <input name="data[<?php echo $i;?>][id]" type="hidden" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])) echo $info['ConfigI18n'][$v['Language']['locale']]['id'];?>">
 <?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['options'])&&!empty($info['ConfigI18n'][$v['Language']['locale']]['options'])){$checkoptions = explode(';',$info['ConfigI18n'][$v['Language']['locale']]['value']);$options = $info['ConfigI18n'][$v['Language']['locale']]['options'];foreach($options as $option){$text =explode(":",$option);if(@$text[1]!=""){?>
 <label><input type="checkbox" name="data[<?php echo $i;?>][value][]" value="<?php echo $text[0];?>" <?php if( in_array($text[0],$checkoptions)) echo 'checked';?>/><?php if(@$text[1]){ echo $text[1];}?></label>
 <?php } ?><?php }?><?php echo $html->link($html->image('help_icon.gif',$title_arr['help']),"javascript:config_help({$info['ConfigI18n'][$v['Language']['locale']]['id']})",'',false,false)?><span id="config_help_<?php echo $info['ConfigI18n'][$v['Language']['locale']]['id']?>" style="visibility :hidden" ><?php echo $info['ConfigI18n'][$v['Language']['locale']]['description']?>
 </td>
 </tr>
 <?php $i++;}}}?>
 </table>
 </td>
 </tr>
 <?php }?>
 <?php if($info['Config']['type']=="file"){?>
 <tr>
 <th><?php echo $info['Config']['name'].':'?></th>
 <td>
<?php foreach($languages as $k=>$v){if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])&&!empty($info['ConfigI18n'][$v['Language']['locale']]['id'])){?>
 <p><input name="data[<?php echo $i;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">  <input name="data[<?php echo $i;?>][config_id]" type="hidden" value="<?php echo  $info['Config']['id'];?>"> <input name="data[<?php echo $i;?>][id]" type="hidden" value="<?php if(isset($info['ConfigI18n'][$v['Language']['locale']]['id'])) echo $info['ConfigI18n'][$v['Language']['locale']]['id'];?>">
 <?php echo $v['Language']['name'];?><span><input type="file" size='36' name="file[$i]" /></span></p>
 <?php $i++;}}?>
 </td>
 </tr>
 <?php }}?>
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
</script>