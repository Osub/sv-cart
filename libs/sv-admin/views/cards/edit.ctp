<?php
/*****************************************************************************
 * SV-Cart 编辑贺卡
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
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."贺卡列表","/cards/",'',false,false);?></strong></p>

<?php echo $form->create('Card',array('action'=>'edit/'.$card['Card']['id'],'onsubmit'=>'return cards_check();'));?>
<input type="hidden" name="data[Card][id]" value="<?=$card['Card']['id']?>">
<div class="home_main">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑贺卡</h1></div>
	  <div class="box">
  	    <h2>贺卡名称：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>		
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><input type="text" id="cards_name_<?=$v['Language']['locale']?>" style="width:215px;"  name="data[CardI18n][<?=$k?>][name]" <?if(isset($card['CardI18n'][$v['Language']['locale']])){?>value="<?= $card['CardI18n'][$v['Language']['locale']]['name'];?>"<?}else{?>value=""<?}?> /> <font color="#ff0000">*</font></span></p>
<?
	}
}?>

<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="CardI18n<?=$k;?>Locale" name="data[CardI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
	   <?if(isset($card['CardI18n'][$v['Language']['locale']])){?>
	<input id="CardI18n<?=$k;?>Id" name="data[CardI18n][<?=$k;?>][id]" type="hidden" value="<?= $card['CardI18n'][$v['Language']['locale']]['id'];?>">
	<input id="CardI18n<?=$k;?>CardId" name="data[CardI18n][<?=$k;?>][card_id]" type="hidden" value="<?= $card['Card']['id'];?>">
	   <?}?>
<?
	}
}?>

		<h2>贺卡描述：</h2>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<p class="products_name"><?=$html->image($v['Language']['img01'])?><span><textarea name="data[CardI18n][<?=$k?>][description]"><?=$card['CardI18n'][$k]['description']?></textarea></span></p>
			<input type="hidden" name="data[CardI18n][<?=$k?>][locale]" value="<?=$v['Language']['locale']?>" />
<?
			
	}
}?>		
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<style type="text/css">
.tongxun dl{
	margin:3px 0;*margin:1px 0 0;
}
</style>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Other Stat-->
	<div class="order_stat athe_infos tongxun">
	  
	  <div class="box">
	  <br />
		<dl><dt>上传图片1：</dt><dd><input type="text" size="35" style="font-size:12px;" id="upload_img_text_1" name="data[Card][img01]" value="<?=$card['Card']['img01']?>" /><br /><br /><?=$html->image("/..{$card['Card']['img01']}",array('id'=>'logo_thumb_img_1','height'=>'150'))?></dd><dd><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1,'cards')",'',false,false)?></dd></dl>
		
		<dl><dt>上传图片2：</dt><dd><input type="text" size="35" style="font-size:12px;" id="upload_img_text_2" name="data[Card][img02]" value="<?=$card['Card']['img02']?>" /><br /><br /><?=$html->image("/..{$card['Card']['img02']}",array('id'=>'logo_thumb_img_1','height'=>'150'))?></dd><dd><?=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(2,'cards')",'',false,false)?></dd></dl>
		
		
		
		<dl><dt>费用：</dt><dd><input type="text" class="text_inputs" style="width:120px;" name="data[Card][fee]" value="<?=$card['Card']['fee']?>" /></dd></dl>
		<dl><dt>免费额度：</dt><dd><input type="text" class="text_inputs" style="width:120px;" name="data[Card][free_money]" value="<?=$card['Card']['free_money']?>" /></dd></dl>
		<dl><dt>排序：</dt><dd><input type="text" class="text_inputs" style="width:120px;" name="data[Card][orderby]" value="<?=$card['Card']['orderby']?>" onkeyup="check_input_num(this)" /><font color="#646464"><br />如果您不输入排序号，系统将默认为50</font></dd></dl>
		
		
		
		<dl style="padding:3px 0;*padding:4px 0;">
		<dt style="padding-top:1px">是否有效：</dt>
		<dd class="best_input"><label><input type="radio" name="data[Card][status]" value="1" <? if($card['Card']['status'] == 1){echo "checked";} ?> />是</label><label><input type="radio" name="data[Card][status]" value="0" <? if($card['Card']['status'] == 0){echo "checked";} ?> />否</label></dd></dl>
		
		<br /><br /><br /><br />
	  </div>
	</div>
<!--Other Stat End-->
</td>
</tr>

</table>




<p class="submit_btn" style="padding:1px 0;margin:0"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>

<? echo $form->end();?>
</div>
<!--Main Start End-->
</div>