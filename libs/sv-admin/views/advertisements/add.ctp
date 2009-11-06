<?php 
/*****************************************************************************
 * SV-Cart 编辑菜单
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 5328 2009-10-22 08:06:54Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."广告列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>
<!--时间控件层start-->
	<div id="container_cal" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal2" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal2"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal3" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal3"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal4" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal4"></div><div style="clear:both;"></div></div>
	</div>
<!--end-->

<div class="home_main">
<!--ConfigValues-->
<?php echo $form->create('advertisement',array('action'=>'add/','onsubmit'=>'return advertisements_check();'));?>
	<div class="order_stat athe_infos configvalues">
	<div class="title">
	<h1><?php echo $html->image('tab_left.gif',array('class'=>'left'))?><?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  添加广告</h1></div>
	  <div class="box"><br />
<!--Mailtemplates_Config-->
		<table width="100%">
		<tr><td align="right" width="10%">广告名称：</td><td></td></tr>
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
		<tr><td align="right"><?php echo $html->image($v['Language']['img01'])?></td><td><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="advertisement_name_<?php echo $v['Language']['locale']?>" name="data[AdvertisementI18n][mutilan][<?php echo $v['Language']['locale']?>][name]" value="<?php if( isset($titles)){ echo $titles;} ?>" /> <font color="#ff0000">*</font></td></tr>
		<?php }}?>
		
		<tr><td align="right">媒介类型： </td><td><select name="data[Advertisement][media_type]" onchange="showMedia(this.value)"><option value='0'>图片</option><option value='1'>Flash</option><option value='2'>代码</option><option value='3'>文字</option></select></td></tr>
		<tr><td align="right">广告位置： </td><td>
			<select name="data[Advertisement][advertisement_position_id]" >
			<option value='0'>请选择广告位</option>
			<?php foreach($advertisement_positions as $ap){ ?>
			<option value="<?php echo $ap['AdvertisementPosition']['id'];?>"><?php echo $ap['AdvertisementPosition']['name'];?></option>
			<?php } ?>
			</select>
		</td></tr>
		
		<tr><td align="right">描述： </td><td><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[AdvertisementI18n][description]"  /></td></tr>

		<tr><td align="right">开始时间： </td><td><input type="text"  name="data[AdvertisementI18n][start_time]" class="text_inputs" style="width:180px;"  id="date" value="<?php echo date('Y-m-d');?>" readonly="readonly"/><?php echo $html->image('calendar.gif',array("id"=>"show","class"=>"calendar_edit"))?></td></tr>

		<tr><td align="right">结束时间： </td><td><input type="text"  name="data[AdvertisementI18n][end_time]" class="text_inputs" style="width:180px;" id="date2" value="<?php $now = date('Y-m-d H:i:s'); echo date('Y-m-d',strtotime($now)+30*24*60*60);?>" readonly="readonly" /><?php echo $html->image('calendar.gif',array("id"=>"show2","class"=>"calendar_edit"))?></td></tr>

		<tr id="01"><td align="right">连接地址： </td><td><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[AdvertisementI18n][url_0]" /></td></tr>
		<tr id="04"><td align="right">连接类型： </td><td><input type="radio" name="data[AdvertisementI18n][url_type]" value="0" checked />直接连接<input type="radio" name="data[AdvertisementI18n][url_type]" value="1" />间接链接</td></tr>
		<tr id="02"><td align="right">上传广告图片： </td><td><input type="text" style="width:357px;*width:360px;border:1px solid #649776" name="data[AdvertisementI18n][code_0]" id="upload_img_text_0" /></dd><?php echo $html->link($html->image('select_img.gif',array("class"=>"vmiddle icons",$title_arr['select_img'],"height"=>"20")),"javascript:img_sel(0,'others')",'',false,false)?></td></tr>
		<tr id="03"><td align="right"></td><td><?php echo @$html->image('',array('id'=>'logo_thumb_img_0','style'=>'display:none'))?></td></tr>
		
		<tr id="11" style="display:none"><td align="right">上传Flash文件： </td><td><input type="text" style="width:357px;*width:360px;border:1px solid #649776" name="data[AdvertisementI18n][code_1]" id="upload_img_text_1" /></dd><?php echo $html->link($html->image('select_img.gif',array("class"=>"vmiddle icons",$title_arr['select_img'],"height"=>"20")),"javascript:img_sel(1,'others')",'',false,false)?></td></tr>
		<tr id="12" style="display:none"><td align="right"></td><td><?php echo @$html->image('',array('id'=>'logo_thumb_img_1','style'=>'display:none'))?></td></tr>
		
		<tr id="21" style="display:none"><td align="right" style="vertical-align:top;">输入广告代码： </td><td>
			<?php if($SVConfigs["select_editor"]=="2"||empty($SVConfigs["select_editor"])){?>
			<?php echo $javascript->link('tinymce/tiny_mce/tiny_mce'); ?>
			<textarea id="elm" name="data[AdvertisementI18n][code_2]" rows="15" cols="80" style="width: 80%"></textarea>
			<?php  echo $tinymce->load("elm",$now_locale); ?>
			<?php }?>
			<?php if($SVConfigs["select_editor"]=="1"){?>
				<?php echo $javascript->link('fckeditor/fckeditor'); ?>
				<p class="profiles">
		        <?php echo $form->textarea('ArticleI18n/content', array("cols" => "60","rows" => "20","name"=>"data[AdvertisementI18n][code]",'id'=>'ArticleI18ncontent'));?>
		        <?php echo $fck->load("ArticleI18ncontent"); ?>
			    </p>
				<br /><br />
			<?php }?>
		</td></tr>
		<tr id="31" style="display:none"><td align="right">广告链接： </td><td><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[AdvertisementI18n][url_3]" /></td></tr>
		<tr id="32" style="display:none"><td align="right">广告内容： </td><td><textarea name="data[AdvertisementI18n][code_3]" cols="40" rows="3" style="width:357px;*width:180px;border:1px solid #649776"></textarea></td></tr>
		<tr><td align="right">联系人： </td><td><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[Advertisement][contact_name]"  /></td></tr>
		<tr><td align="right">电话： </td><td><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[Advertisement][contact_tele]"  /></td></tr>
		<tr><td align="right">E-mail地址： </td><td><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[Advertisement][contact_email]"  /></td></tr>
		<tr><td align="right">是否有效： </td><td><input type="radio" value="1"  name="data[Advertisement][status]" checked  />是<input type="radio" value="0"  name="data[Advertisement][status]"  />否</td></tr>
		<tr><td align="right">排序： </td><td><input type="text" style="width:50px;*width:180px;border:1px solid #649776" name="data[Advertisement][orderby]"  value="50"/></td></tr>

		</table>
		




<!--Mailtemplates_Config End-->
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
<?php echo $form->end();?>
<!--ConfigValues End-->


</div>
<!--Main End-->
</div>
<script language="JavaScript">
  document.getElementById('advertisement_name_'+now_locale).focus();
  var MediaList = new Array('01','02','03','04', '11','12', '21', '31', '32');
  function showMedia(AdMediaType)
  {
    for (I = 0; I < MediaList.length; I ++)
    {	
      if (MediaList[I].substring(0,1) == AdMediaType)
        document.getElementById(MediaList[I]).style.display = "";
      else
        document.getElementById(MediaList[I]).style.display = "none";
    }
  }
</script>
<style>
<!--
#logo_thumb_img_0{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;width:200px;height:100px;}
-->
</style>
