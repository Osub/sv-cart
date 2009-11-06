<?php 
/*****************************************************************************
 * SV-Cart 在线管理选项编辑
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: option_edit.ctp 4218 2009-09-11 02:34:41Z huangbo $
*****************************************************************************/
?>
<!--时间控件层start-->
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
<?php echo $form->create('votes',array('action'=>'/option_edit/'.$vote_id.'/'.$option_vote_id."/"));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start--><br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('class'=>'vmiddle'))."选项列表","option_list/".$vote_id,'',false,false);?></strong></p>

<div class="home_main" id="guides_1">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	<?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	新增调查选项</h1></div>
	<div class="box">
	<div class="shop_config menus_configs guides" style="width:500px;">
	<br />
	
	<dl><dt style="width:100px;">选项名称： </dt>
	<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:100px;"><?php echo $html->image($v['Language']['img01'])?></dt>
	<dd><input type="text" style="width:300px;border:1px solid #649776" name="data[VoteOptionI18n][<?php echo $k?>][name]" value="<?php echo @$vote_option_info['VoteOptionI18n'][$v['Language']['locale']]['name']?>" /></dd></dl>
	<input type="hidden" name="data[VoteOptionI18n][<?php echo $k?>][locale]" value="<?php echo $v['Language']['locale']?>" />
	<input type="hidden" name="data[VoteOptionI18n][<?php echo $k?>][id]" value="<?php echo $vote_option_info['VoteOptionI18n'][$v['Language']['locale']]['id']?>" />
	<?php }}?>
	<dl><dt style="width:100px;">选项描述： </dt>
	<dd></dd></dl>
<?php if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:100px;"><?php echo $html->image($v['Language']['img01'])?></dt>
	<dd><textarea style="width:300px;border:1px solid #649776" name="data[VoteOptionI18n][<?php echo $k?>][description]" ><?php echo @$vote_option_info['VoteOptionI18n'][$v['Language']['locale']]['description']?></textarea></dd></dl>

<?php }}?>
	<dl><dt style="width:100px;">是否有效： </dt>
	<dd><input type="radio"  name="data[VoteOption][status]" value="1" <?php if($vote_option_info['VoteOption']['status']==1){ echo "checked";}?>  />是<input type="radio" name="data[VoteOption][status]" value="0" <?php if($vote_option_info['VoteOption']['status']==0){ echo "checked";}?> />否</dd></dl>

	</div>
	</div>
	<p class="submit_btn"><input type="submit" value="确定"  /><input type="reset" value="重置"  /></p>
	</div>
</div>
<?php echo $form->end();?>
</div>