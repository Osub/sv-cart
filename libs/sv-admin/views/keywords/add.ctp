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
 * $Id: add.ctp 3734 2009-08-19 03:17:38Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!-- Main Start-->
<br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."关键字列表","/keywords/",'',false,false);?></strong></p>

<div class="home_main">
<?php echo $form->create('keywords',array('action'=>'add/','onsubmit'=>'return keywords_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  关键字新增</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
		<dl><dt style="width:105px;">关键词： </dt>
		<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" name="data[SeoKeyword][name]" id="SeoKeywordname" /> <font color="#F90071">*</font></dd></dl>
		<dl><dt style="width:105px;">排序： </dt>
		<dd><input type="text" style="width:113px;border:1px solid #649776" name="data[SeoKeyword][orderby]" onkeyup="check_input_num(this)" /><p class="msg">如果您不输入排序号，系统将默认为50<p/> </dd></dl>
		<dl><dt style="width:105px;">是否有效： </dt>
		<dd><input type="radio"  name="data[SeoKeyword][status]" value="1"  checked />是<input type="radio"  name="data[SeoKeyword][status]" value="0"  />否 </dd></dl>

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
