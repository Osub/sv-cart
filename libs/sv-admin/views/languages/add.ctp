<?php 
/*****************************************************************************
 * SV-Cart 添加语言管理
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
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations)); //pr($languages)?>
<!--Main Start-->

<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."语言列表","/".(empty($_SESSION['cart_back_url'])?$this->params['controller']:$_SESSION['cart_back_url']),'',false,false);?></strong></p>
<div class="home_main">
<!--ConfigValues-->
	<?php echo $form->create('Language',array('action'=>'add' ,'onsubmit'=>'return languages_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑语言</h1></div>
	  <div class="box">
<!--Menus_Config-->
	  <div class="shop_config menus_configs">
	  	<dl><dt>语言名称: </dt>
		<dd><input type="text" style="width:290px;border:1px solid #649776" id="language_name" name="data[Language][name]"  /> <font color="#ff0000">*</font></dd></dl>
		<dl><dt>语言代码: </dt>
		<dd><input type="text" style="width:290px;border:1px solid #649776" id="language_locale" name="data[Language][locale]" /> <font color="#ff0000">*</font></dd></dl>
		<dl><dt>字符集: </dt>
		<dd><input type="text" style="width:290px;border:1px solid #649776" id="language_charset" name="data[Language][charset]" /> <font color="#ff0000">*</font></dd></dl>
		<dl><dt>浏览器字符集: </dt>
		<dd><input type="text" style="width:290px;border:1px solid #649776" id="language_map" name="data[Language][map]" /> <font color="#ff0000">*</font></dd></dl>
		<dl><dt>google翻译参数: </dt>
		<dd><input type="text" style="width:290px;border:1px solid #649776" id="language_google_translate_code" name="data[Language][google_translate_code]" /> <font color="#ff0000">*</font></dd></dl>
		<dl><dt>图标1: </dt>
		<dd><input type="text" style="width:290px;border:1px solid #649776" name="data[Language][img01]" id="upload_img_text_1" /><br /><br /><img src="<?php echo  $this->data['Language']['img01'];?>" id="logo_thumb_img_1" height="150" ></dd><dd><?php //=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(1,'others')",'',false,false)?></dd></dl>
		<dl><dt>图标2: </dt>
		<dd><input type="text" style="width:290px;border:1px solid #649776" name="data[Language][img02]" id="upload_img_text_2" /><br /><br /><img src="<?php echo  $this->data['Language']['img02'];?>" id="logo_thumb_img_2" height="150" ></dd><dd><?php //=$html->link($html->image('select_img.gif',$title_arr['select_img']),"javascript:img_sel(2,'others')",'',false,false)?></dd></dl>
		<dl><dt>前台是否有效: </dt>
		<dd class="lang_if">
		<input type="radio" style="width:auto;border:0" name="data[Language][front]" value="1" checked /><label>是</label><input type="radio" style="width:auto;border:0" name="data[Language][front]" value="0"   /><label>否</label></dd></dl>
		<dl><dt>后台是否有效: </dt>
		<dd class="lang_if">
		<input type="radio" style="width:auto;border:0" name="data[Language][backend]" value="1" checked /><label>是</label><input type="radio" style="width:auto;border:0" name="data[Language][backend]" value="0"  /><label>否</label></dd></dl>
		<dl><dt>是否设为默认语言: </dt>
		<dd class="lang_if">
		<input type="radio" style="width:auto;border:0" name="data[Language][is_default]" value="1" checked /><label>是</label><input type="radio" style="width:auto;border:0" name="data[Language][is_default]" value="0"  /><label>否</label></dd></dl>
		<br />
		
		</div>
<!--Menus_Config End-->
	  </div>
	  <p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p>
	</div>
<?php $form->end();?>
<!--ConfigValues End-->
</div>
<!--Main End-->
</div>



