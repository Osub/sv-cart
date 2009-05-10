<?php
/*****************************************************************************
 * SV-Cart 用户管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1232 2009-05-06 12:14:41Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<?=$javascript->link('listtable');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'','name'=>"SearchForm","type"=>"get"));?>
	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif')?></dt>
	<dd><p class="reg_time">注册时间：<input type="text" id="date" name="date" value="<?=@$date?>"  readonly/><button type="button" id="show" title="Show Calendar">

	<?=@$html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar'))?>

	</button>--<input type="text" id="date2" name="date2" value="<?=@$date2?>"  readonly/><button type="button" id="show2" title="Show Calendar">
	<?=@$html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar'))?>
		
		</button>
	
	&nbsp;&nbsp;会员名称：<input type="text" class="name" name="user_name" id="user_name" value="<?=@$user_name?>"/>&nbsp;&nbsp;Email：<input type="text" class="name" name="user_email" value="<?=@$user_email?>" id="user_email"/>&nbsp;&nbsp;会员等级：<select class="price" style="margin-right:10px;" id="user_rank" name="user_rank">
	<option value="0">所有等级</option>
		<?if(isset($rank_list) && sizeof($rank_list)>0){?>
      <?foreach($rank_list as $k=>$v){?>
             <option value="<?echo $v['UserRank']['id']?>" <?if ($user_rank == $v['UserRank']['id']){?>selected<?}?>><?echo $v['UserRank']['name']?></option>
 	  <?}}?>
	</select></p>
	<p class="confine">资金范围：<input type="text" id="min_balance" name="min_balance" value="<?echo $min_balance?>"/>－<input type="text" id="max_balance" name="max_balance" value="<?echo $max_balance?>"/>&nbsp;&nbsp;积分范围：<input type="text" id="min_points" name="min_points" value="<?echo $min_points?>"/>－<input type="text" id="max_points" name="max_points" value="<?echo $max_points?>"/></p></dd>
	<dt class="big_search"><input type="submit" class="big" value="搜索" onclick="search_user()"/></dt>
	</dl>
</div>
<br />
<!--Search End-->
<? echo $form->end();?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增会员','/users/add',array(),false,false);?></strong></p>

<?php echo $form->create('users',array('action'=>'','name'=>"UserForm","type"=>"get"));?>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
	<ul class="product_llist users_title">
	<li class="number"><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>
	编号</li>
	<li class="name">会员名称<?=$html->image('sort_desc.gif',array('align'=>'absmiddle'))?></li>
	<li class="grade">会员等级</li>
	<li class="email">邮件地址</li>
	<li class="date">注册日期<?=$html->image('sort_desc.gif',array('align'=>'absmiddle'))?></li>
	<li class="hadle">操作</li>
	</ul>
<?if(isset($users_list) && sizeof($users_list)>0){?>
<?foreach($users_list as $k=>$v){?>
	<ul class="product_llist products users_title">
	<li class="number"><input type="checkbox" name="checkboxes[]" value="<?echo $v['User']['id']?>" /><?echo $v['User']['id']?></li><li class="name"><?echo $v['User']['name']?></li><li class="grade"><?echo $v['User']['UserRankname']?></li><li class="email"><?echo $v['User']['email']?></li><li class="date"><?echo $v['User']['created']?></li>
	<li class="hadle">
	<?php echo $html->link("编辑","/users/{$v['User']['id']}");?>|<?php echo $html->link("移除","javascript:",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}users/remove/{$v['User']['id']}')"));?>
	</li></ul>
<?}}?>
	
   <div class="pagers" style="position:relative">
   <p class='batch'>
    <select style="width:66px;border:1px solid #689F7C;display:none" name="act_type" id="act_type">
   <!-- <option value="0">请选择...</option>-->
    <option value="del">删除</option>
    </select> 
<input type="submit" value="删除" onclick="batch_action()" onfocus="this.blur()" /></p>
 <? echo $form->end();?>

<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div><!--时间控件层start-->
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
<script>
function batch_action() 
{ 
document.UserForm.action=webroot_dir+"users/batch";
document.UserForm.submit(); 
} 
function search_user() 
{ 
document.SearchForm.action=webroot_dir+"users/";
document.SearchForm.submit(); 
} 

</script>