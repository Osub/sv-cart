<?php 
/*****************************************************************************
 * SV-Cart 添加广告
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!-- Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."广告列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('advertisement',array('action'=>'add/','onsubmit'=>'return advertisements_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  添加广告</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
		<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $k => $v){?>
	  	<dl><dt style="width:105px;"><?php if($k==0){ echo "广告名称：";} ?><?php echo $html->image($v['Language']['img01'])?></dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="advertisement_name_<?php echo $v['Language']['locale']?>" name="data[AdvertisementI18n][mutilan][<?php echo $v['Language']['locale']?>][name]" value="<?php if( isset($titles)){ echo $titles;} ?>" /> <font color="#ff0000">*</font></dd></dl><?php }}?>
			
		<dl><dt style="width:105px;">媒介类型： </dt>
		<dd><select name="data[Advertisement][media_type]" onchange="showMedia(this.value)">
         <option value='0'>图片</option>
         <option value='1'>Flash</option>
         <option value='2'>代码</option>
         <option value='3'>文字</option>
         </select></dd></dl>
        
        <dl><dt style="width:105px;">广告位置： </dt>
		<dd><select name="data[Advertisement][advertisement_position_id]" >
         <option value='0'>请选择广告位</option>
         <?php foreach($advertisement_positions as $ap){ ?>
         <option value="<?php echo $ap['AdvertisementPosition']['id'];?>"><?php echo $ap['AdvertisementPosition']['name'];?></option>
         <?php } ?>
         </select></dd></dl>
		
		<dl><dt style="width:105px;">描述： </dt>
		<dd></dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[AdvertisementI18n][description]"  /></dl>
		
		<dl><dt style="width:105px;">开始时间：</dt><span class="search_box" style="background:none;padding:0;border:0" >
			<dd><input type="text"  name="data[AdvertisementI18n][start_time]" class="text_inputs" style="width:180px;"  id="date" value="<?php echo date('Y-m-d H:i:s');?>" readonly="readonly"/><?php echo $html->image('calendar.gif',array("id"=>"show","class"=>"calendar_edit"))?></dd></span></dl>
		<dl><dt style="width:105px;">结束时间：</dt><span class="search_box" style="background:none;padding:0;border:0" >
			<dd><input type="text"  name="data[AdvertisementI18n][end_time]" class="text_inputs" style="width:180px;" id="date2" value="<?php $now = date('Y-m-d H:i:s'); echo date('Y-m-d H:i:s',strtotime($now)+30*24*60*60);?>" readonly="readonly" /><?php echo $html->image('calendar.gif',array("id"=>"show2","class"=>"calendar_edit"))?></dd></span></dl>
		
		<span id="0"><dl><dt style="width:105px;">连接地址： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[AdvertisementI18n][url_0]" /></dd></dl>	
		<dl><dt style="width:105px;">上传广告图片： </dt>
		<dd><input type="text" size='28' name="data[AdvertisementI18n][code_0]" id="upload_img_text_0" /></dd><?php echo $html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(0,'others')",'',false,false)?></dl>
		<dl><dt style="width:105px;"></dt>
		<dd><?php echo @$html->image('',array('id'=>'logo_thumb_img_0','height'=>'150','style'=>'display:none'))?>
		</dd></dl></span>
		<span id="1" style="display:none"><dl><dt style="width:105px;">上传Flash文件： </dt>
		<dd><input type="text" size='28' name="data[AdvertisementI18n][code_1]" id="upload_img_text_1" /></dd><?php echo $html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1,'others')",'',false,false)?></dl>
		<dl><dt style="width:105px;"></dt>
		<dd><?php echo @$html->image('',array('id'=>'logo_thumb_img_0','height'=>'150','style'=>'display:none'))?>
		</dd></dl></span>
		<span id="2" style="display:none"><dl><dt style="width:105px;">输入广告代码： </dt>
		<dd><textarea name="data[AdvertisementI18n][code_2]" cols="40" rows="3" style="width:357px;*width:180px;border:1px solid #649776"></textarea></dd></dl></span>
		<span id="3" style="display:none"><dl><dt style="width:105px;">广告链接： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[AdvertisementI18n][url_3]" /></dd></dl>
		<dl><dt style="width:105px;">广告内容： </dt>
		<dd><textarea name="data[AdvertisementI18n][code_3]" cols="40" rows="3" style="width:357px;*width:180px;border:1px solid #649776"></textarea></dd></dl></span>

		<dl><dt style="width:105px;">联系人： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[Advertisement][contact_name]"  /></dd></dl>	
		<dl><dt style="width:105px;">电话： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[Advertisement][contact_tele]"  /></dd></dl>	
		<dl><dt style="width:105px;">E-mail地址： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[Advertisement][contact_email]"  /></dd></dl>	
		<dl><dt style="width:105px;">是否有效： </dt>
		<dd><input type="radio" value="1"  name="data[Advertisement][status]" checked  />是<input type="radio" value="0"  name="data[Advertisement][status]"  />否</dd></dl>
		<dl><dt style="width:105px;">排序： </dt>
		<dd><input type="text" style="width:50px;*width:180px;border:1px solid #649776" name="data[Advertisement][orderby]"  value="50"/></dd></dl>	
		<br />
		</div>
<!--Mailtemplates_Config End-->
	  </div>
	  <p class="submit_values"><input type="submit" value="确 定" /><input type="reset" value="重 置" /></p>
	</div>
<?php echo $form->end();?>
</div>
<!--Main End-->
</div>
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
<script language="JavaScript">
  document.getElementById('advertisement_name_'+now_locale).focus();
  var MediaList = new Array('0', '1', '2', '3');
  function showMedia(AdMediaType)
  {
    for (I = 0; I < MediaList.length; I ++)
    {
      if (MediaList[I] == AdMediaType)
        document.getElementById(AdMediaType).style.display = "";
      else
        document.getElementById(MediaList[I]).style.display = "none";
    }
  }
</script>