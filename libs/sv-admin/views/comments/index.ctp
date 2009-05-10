<?php
/*****************************************************************************
 * SV-Cart 评论管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
?> 
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<?=$javascript->link('listtable');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>'UserForm','type'=>'get'));?>
	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">评论内容：<input type="text" class="name" name="content" value="<?=@$content?>"/>&nbsp;&nbsp;发布时间：<input type="text" name="start_time" class="time" id="date" value="<?=@$start_time?>" readonly="readonly" /><button id="show" type="button"><?=$html->image('calendar.gif')?></button>－<input type="text" name="end_time" value="<?=@$end_time?>" class="time" id="date2" readonly="readonly" /><button id="show2" type="button"><?=$html->image('calendar.gif')?></button></p></dd>
	<dt class="small_search"><input type="submit" value="搜索"  class="search_article" onclick="search_user()" /></dt>
	</dl>
</div>
<br /><br />

<!--Search End-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<input type="hidden" name="search" value="one">
	<ul class="product_llist commets_title">
	<li class="number"><input type="checkbox" name="chkall" value="checkbox" onclick="selectAll(this,'checkbox');" />编号<?=$html->image('sort_desc.gif',array('align'=>'absmiddle'))?></li>
	<li class="username">用户名</li>
	<li class="type">类型</li>
	<li class="object">评论对象</li>
	<li class="IP"><font face="arial">IP地址</font></li>
	<li class="comment_time">评论时间<?=$html->image('sort_desc.gif',array('align'=>'absmiddle'))?></li>
	<li class="status">状态</li>
	<li class="hadle">操作</li></ul>
<!--Comment List-->
<?if(isset($comments_info) && sizeof($comments_info)>0){?>
<?foreach($comments_info as $k=>$v){?>
	<ul class="product_llist commets_title commets_list">
	<li class="number"><input type="checkbox" name="checkbox[]" value="<?=$v['Comment']['id']?>" /><?=$v['Comment']['id']?></li>
	<li class="username"><span><?=$v['Comment']['name']?></span></li>
	<li class="type"><span><?=$v['Comment']['type']?></span></li>
	<li class="object"><span><?=$v['Comment']['object']?></span></li>
	<li class="IP"><?=$v['Comment']['ipaddr']?></li>
	<li class="comment_time"><?=$v['Comment']['created']?></li>
	<li class="status"><? if($v['Comment']['status']=='1'){ echo "显示"; }if($v['Comment']['status']=='0'){  echo "不显示"; }if($v['Comment']['status']=='2'){  echo "删除"; } ?></li>
	<li class="hadle"><?php echo $html->link("查看详情","/comments/edit/{$v['Comment']['id']}");?>
|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}comments/remove/{$v['Comment']['id']}')"));?></li></ul>

<?}?><?}?>
<!--Comment List End-->	
<div class="pagers" style="position:relative">
<p class='batch'><select name="act_type" style="width:59px;border:1px solid #689F7C;display:none">
	<option value="delete">删除</option>
	</select> <input type="submit" value="删除" onclick="batch_action()" /></p>
<? echo $form->end();?><div class="box">
 <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
	</div></div>
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
<script type="text/javascript">
function batch_action() 
{ 
document.UserForm.action=webroot_dir+"comments/batch"; 
document.UserForm.submit(); 
} 
function search_user() 
{ 
document.UserForm.action=webroot_dir+"comments/"; 
document.UserForm.submit(); 
} 

</script>