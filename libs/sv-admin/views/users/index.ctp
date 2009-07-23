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
 * $Id: index.ctp 2952 2009-07-16 09:56:25Z huangbo $
*****************************************************************************/
?>


 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'','name'=>"SearchForm","type"=>"get",'onsubmit'=>"return false"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif')?></dt>
	<dd>
	<p class="reg_time">
	注册时间：<input type="text" id="date" name="date" value="<?php echo @$date?>"  readonly/><?php echo @$html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?> <input type="text" id="date2" name="date2" value="<?php echo @$date2?>"  readonly style="margin-left:3px" /><?php echo @$html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
	会员名称：<input type="text" class="name" name="user_name" id="user_name" value="<?php echo @$user_name?>" style="width:110px;"/>
	&nbsp;&nbsp;Email：<input type="text" class="name" name="user_email" value="<?php echo @$user_email?>" id="user_email"/>
	
	</p>
	<p class="confine">
	会员等级：<select class="price" style="margin-right:10px;" id="user_rank" name="user_rank">
	<option value="0">所有等级</option>
	<?php if(isset($rank_list) && sizeof($rank_list)>0){?>
    <?php foreach($rank_list as $k=>$v){?>
    <option value="<?php echo $v['UserRank']['id']?>" <?php if ($user_rank == $v['UserRank']['id']){?>selected<?php }?>><?php echo $v['UserRank']['name']?></option>
 	<?php }}?>
	</select>
	资金范围：<input type="text" id="min_balance" name="min_balance" value="<?php echo $min_balance?>"/>－<input type="text" id="max_balance" name="max_balance" value="<?php echo $max_balance?>"/>&nbsp;&nbsp;积分范围：<input type="text" id="min_points" name="min_points" value="<?php echo $min_points?>"/>－<input type="text" id="max_points" name="max_points" value="<?php echo $max_points?>"/></p>
	</dd>
	<dt class="big_search"><input type="submit" class="big" value="搜索" onclick="search_user()"/> <input type="button" value="导出"   class="big"   onclick="export_act()"/>
	
</dt>

	</dl>
</div>
<br />
<!--Search End-->
<?php echo $form->end();?>


<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增会员','/users/add',array(),false,false);?></strong></p>

<?php echo $form->create('users',array('action'=>'','name'=>"UserForm","type"=>"get",'onsubmit'=>"return false"));?>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">	
	<th><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>编号</th>
	<th>会员名称<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th>会员等级</th>
	<th>邮件地址</th>
	<th>注册日期<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th>操作</th>
</tr>
<?php if(isset($users_list) && sizeof($users_list)>0){?>
<?php foreach($users_list as $k=>$v){?>
<tr>	
	<td align="center"><input type="checkbox" name="checkboxes[]" value="<?php echo $v['User']['id']?>" /><?php echo $v['User']['id']?></td>
	<td><?php echo $v['User']['name']?></td>
	<td align="center"><?php echo $v['User']['UserRankname']?></td>
	<td align="center"><?php echo $v['User']['email']?></td>
	<td align="center"><?php echo $v['User']['created']?></td>
	<td align="center">
	<?php echo $html->link("编辑","/users/{$v['User']['id']}");?> |
	<?php echo $html->link("移除","javascript:",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}users/remove/{$v['User']['id']}')"));?>
	</td>
</tr>
<?php }}?>
</table>
   <div class="pagers" style="position:relative">
   <p class='batch'>
    <select style="width:66px;border:1px solid #689F7C;display:none" name="act_type" id="act_type">
    <option value="del">删除</option>
    </select> 
   	<?php if(isset($users_list) && sizeof($users_list)>0 && count($users_list)>0){?>
	<input type="submit" value="删除" onclick="operate_select()" onfocus="this.blur()" />
    <?php } ?>
	</p>
 <?php echo $form->end();?>

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
document.UserForm.onsubmit= "";
document.UserForm.submit(); 
} 
function search_user() 
{ 
document.SearchForm.action=webroot_dir+"users/";
document.SearchForm.onsubmit= "";
document.SearchForm.submit(); 
} 
function export_act(){ 
//	var url=document.getElementById("url").value;
//	window.location.href=webroot_dir+url;
	document.SearchForm.action=webroot_dir+"users/index/export";
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit();
}
function operate_select(){//删除
	var id=document.getElementsByName('checkboxes[]');
	var i;
	var j=0;
	var image="";
	for( i=0;i<=parseInt(id.length)-1;i++ ){
		if(id[i].checked){
			j++;
		}
	}
	if( j<1 ){
		return false;
	}else{
		batch_action();
	}
}
</script>