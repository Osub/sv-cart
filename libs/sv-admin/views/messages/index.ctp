<?php
/*****************************************************************************
 * SV-Cart 留言管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
?>


<?=$javascript->link('listtable');?>

<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'','name'=>'UserForm','type'=>'get','onsubmit'=>"return false"));?>
	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article"><select  name="mods">
		<option value="" selected>请选择...</option>
<? if(isset($msg_type) && sizeof($msg_type)>0){?>
	<?foreach($msg_type as $k=>$v){?>
		<option value="<?=$k;?>" <? if("$k"==@$modssss){ echo "selected";}?> ><?=$v;?></option>
	<?}}?>
	</select>&nbsp;&nbsp;留言标题：<input type="text" name="title" value="<?=@$titles?>" class="name" />&nbsp;&nbsp;发布时间：<input type="text" name="start_time" class="time" id="date"value="<?=@$start_time?>" readonly="readonly" /><button id="show" type="button"><?=$html->image('calendar.gif')?></button>－<input type="text" name="end_time" value="<?=@$end_time?>" class="time" id="date2" readonly="readonly" /><button id="show2" type="button"><?=$html->image('calendar.gif')?></button></p></dd>
	<dt class="small_search"><input type="submit" value="搜索" onclick="search_user()"  class="search_article" /></dt>

</div>
<br /><br />
<!--Search End-->
<!--Main Start-->

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
		<ul class="product_llist messgaes_title">
	<li class="number"><label><input type="checkbox" name="chkall" value="checkbox" onclick="selectAll(this,'checkbox');" />编号</label></li>
	<li class="username">用户名</li>
	<li class="msg_headers">留言标题</li>
	<li class="type">类型</li>
	<li class="msg_time">留言时间</li>
	<li class="writeback">回复</li>
	<li class="hadle">操作</li></ul>
<!--Messgaes List-->
	<? if(isset($UserMessage_list) && sizeof($UserMessage_list)>0){?>

	<?php foreach($UserMessage_list as $k=>$v){ ?>
	<ul class="product_llist messgaes_title messgaes_list">
	<li class="number"><label><input type="checkbox" name="checkbox[]" value="<?php echo $v['UserMessage']['id'] ?>" /><?php echo $v['UserMessage']['id'] ?></label></li>
	<li class="username"><span><?php echo $v['UserMessage']['user_name'] ?></span></li>
	<li class="msg_headers"><span><?php echo $v['UserMessage']['msg_title'] ?></span></li>
	<li class="type"><?php echo $msg_type[$v['UserMessage']['msg_type']] ?></li>
	<li class="msg_time"><?php echo $v['UserMessage']['created'] ?></li>
	<li class="writeback"><? if( $v['UserMessage']['status'] == 0 ){ echo "未回复";}else{echo "已回复";}?></li>
	<li class="hadle">
	<?php echo $html->link("编辑","view/{$v['UserMessage']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}messages/remove/{$v['UserMessage']['id']}')"));?>
		</li></ul>
	<? }} ?><? //pr($UserMessage_list); ?>
<!--Messgaes List End-->	
	
	
	
	

<div class="pagers" style="position:relative">
<p class='batch'><select style="width:59px;border:1px solid #689F7C;display:none" name="act_type"><option value="delete">删除</option></select> <input type="submit" onclick="batch_action()" value="删除" /></p>
<? echo $form->end();?>
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
</div>
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
document.UserForm.action=webroot_dir+"messages/batch"; 
document.UserForm.onsubmit= "";
document.UserForm.submit(); 
} 
function search_user() 
{ 
document.UserForm.onsubmit= "";
document.UserForm.action=webroot_dir+"messages/"; 
document.UserForm.submit(); 
} 

</script>