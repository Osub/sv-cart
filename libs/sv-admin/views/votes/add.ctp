<?php 
/*****************************************************************************
 * SV-Cart 在线管理新增
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: add.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<?php echo $form->create('votes',array('action'=>'/add/'));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start--><br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('class'=>'vmiddle'))."在线调查列表","/votes/",'',false,false);?></strong></p>

<div class="home_main" id="guides_1">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	<?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	在线调查编辑</h1></div>
	<div class="box">
	<div class="shop_config menus_configs guides" style="width:500px;">
	<br />
	
	<dl><dt style="width:100px;">调查主题： </dt>
	<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:100px;"><?php echo $html->image($v['Language']['img01'])?></dt>
	<dd><input type="text" style="width:300px;border:1px solid #649776" name="data[VoteI18n][<?php echo $k?>][name]" /></dd></dl>
	<input type="hidden" name="data[VoteI18n][<?php echo $k?>][locale]" value="<?php echo $v['Language']['locale']?>" />
	<?php }}?>
	<dl><dt style="width:100px;">主题描述： </dt>
	<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:100px;"><?php echo $html->image($v['Language']['img01'])?></dt>
	<dd><textarea style="width:300px;border:1px solid #649776" name="data[VoteI18n][<?php echo $k?>][description]" ></textarea></dd></dl>

<?php }}?>
	<dl><dt style="width:100px;">开始日期： </dt>
	<dd><input type="text" style="border:1px solid #649776" name="data[Vote][start_time]" id="date"  readonly /><button id="show" type="button"><?php echo $html->image('calendar.gif')?></button></dd></dl>
	
	<dl><dt style="width:100px;">截止日期： </dt>
	<dd><input type="text" style="border:1px solid #649776" name="data[Vote][end_time]" id="date2" readonly /><button id="show2" type="button"><?php echo $html->image('calendar.gif')?></button></dd></dl>
		
	<dl><dt style="width:100px;">能否多选： </dt>
	<dd><input type="radio"  name="data[Vote][can_multi]" value="0" checked />能<input type="radio" name="data[Vote][can_multi]" value="1"  />不能</dd></dl>

	<dl><dt style="width:100px;">是否有效： </dt>
	<dd><input type="radio"  name="data[Vote][status]" value="1" checked   />是<input type="radio" name="data[Vote][status]" value="0"  />否</dd></dl>

	</div>
	</div>
	<p class="submit_btn"><input type="submit" value="确定"  /><input type="reset" value="重置"  /></p>
	</div>
</div>
<?php echo $form->end();?>
</div><!--时间控件层start-->
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