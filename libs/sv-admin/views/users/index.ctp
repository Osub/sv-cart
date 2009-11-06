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
 * $Id: index.ctp 4718 2009-09-29 03:01:55Z huangbo $
*****************************************************************************/
?>
<p class="none"><span id="show3">&nbsp;eee</span><span id="show4">&nbsp;</span></p> 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Search-->
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

<div class="search_box">
<?php echo $form->create('',array('action'=>'','name'=>"SearchForm","type"=>"get",'onsubmit'=>"return false"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif')?></dt>
	<dd>
	<p class="reg_time">
	注册时间：<input type="text" id="date" name="date" style="border:1px solid #649776" value="<?php echo @$date?>"  readonly/><?php echo @$html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?> <input type="text" id="date2" name="date2"  value="<?php echo @$date2?>"  readonly style="border:1px solid #649776" /><?php echo @$html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?>
	会员名称：<input type="text" style="border:1px solid #649776" name="user_name" id="user_name" value="<?php echo @$user_name?>"/>
	&nbsp;&nbsp;Email：<input type="text" style="border:1px solid #649776" name="user_email" value="<?php echo @$user_email?>" id="user_email"/>
	
	</p>
	<p class="confine">
	会员等级：<select class="price" style="margin-right:10px;" id="user_rank" name="user_rank">
	<option value="0">所有等级</option>
	<?php if(isset($rank_list) && sizeof($rank_list)>0){?>
    <?php foreach($rank_list as $k=>$v){?>
    <option value="<?php echo $v['UserRank']['id']?>" <?php if ($user_rank == $v['UserRank']['id']){?>selected<?php }?>><?php echo $v['UserRank']['name']?></option>
 	<?php }}?>
	</select>
	资金范围：<input type="text" id="min_balance" name="min_balance" style="border:1px solid #649776" value="<?php echo $min_balance?>"/>－<input style="border:1px solid #649776" type="text" id="max_balance" name="max_balance" value="<?php echo $max_balance?>"/>&nbsp;&nbsp;积分范围：<input type="text" id="min_points" name="min_points" value="<?php echo $min_points?>"/>－<input type="text" id="max_points" name="max_points" value="<?php echo $max_points?>"/>
	<select name="verify_status">
		<?php foreach( $systemresource_info["verify_status"] as $k=>$v ){?>
		<option value="<?php echo $k;?>" <?php if(@$verify_status == "$k"){echo "selected";}?> ><?php echo $v;?></option>
		<?php }?>
	</select>
		

	</p>
	
	</dd>
	<dt class="big_search"><input type="submit" class="big" value="搜索" onclick="search_user()"/>		
		CSV导出编码:
			<select id="csv_export_code">
			<?php if(isset($systemresource_info["csv_export_code"]) && sizeof($systemresource_info["csv_export_code"])>0){
			foreach ($systemresource_info["csv_export_code"] as $k => $v){if($k!=""){?>
			<option value="<?php echo $k;?>" ><?php echo $v;?></option>
			<?php }}}?>
			</select>
			<input type="button" value="导出"   class="big"   onclick="export_act()"/>
</dt>

	</dl>
</div>
<br />
<!--Search End-->
<?php echo $form->end();?>


<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增会员','/users/add',array(),false,false);?></strong></p>

<?php echo $form->create('users',array('action'=>'','name'=>"UserForm","type"=>"get",'onsubmit'=>"return false"));?>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">	
	<th width="6%"><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>编号</th>
	<th>会员名称<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th width="12%">会员等级</th>
	<th width="15%">邮件地址</th>
	<th width="12%">注册日期<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th width="16%">操作</th>
</tr>
<?php if(isset($users_list) && sizeof($users_list)>0){?>
<?php foreach($users_list as $k=>$v){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >	
	<td align="center"><input type="checkbox" name="checkboxes[]" value="<?php echo $v['User']['id']?>" /><?php echo $v['User']['id']?></td>
	<td><?php echo $v['User']['name']?></td>
	<td align="center"><?php echo $v['User']['UserRankname']?></td>
	<td align="center"><?php echo $v['User']['email']?></td>
	<td align="center"><?php echo $v['User']['created']?></td>
	<td align="center">
	<?php if( $v['User']['verify_status'] != 1){?>
	<?php echo $html->link('认证','search/userconfirm/'.$v['User']['id'],'',false,false)?>
	<?php }else{?>
	<?php echo $html->link('取消认证','search/cancel/'.$v['User']['id'],'',false,false)?>
	<?php }?>
	| <?php echo $html->link("编辑","/users/{$v['User']['id']}");?> |
	<?php echo $html->link("移除","javascript:",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}users/remove/{$v['User']['id']}')"));?>
	</td>
</tr>
<?php }}?>
</table></div>
   <div class="pagers" style="position:relative">
   <p class='batch'>
    <select style="width:66px;border:1px solid #689F7C;display:none" name="act_type" id="act_type">
    <option value="del">删除</option>
    </select> 
   	<?php if(isset($users_list) && sizeof($users_list)>0 && count($users_list)>0){?>
	<input type="button" value="删除" onclick="diachange()" onfocus="this.blur()" />
    <?php } ?>
	</p>
 <?php echo $form->end();?>

<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
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
	var csv_export_code = GetId("csv_export_code");
	document.SearchForm.action=webroot_dir+"users/index/export/"+csv_export_code.value;
	document.SearchForm.onsubmit= "";
	document.SearchForm.submit();
}
function diachange(){
	var a=document.getElementById("act_type");
	if(a.value!='0'){
		for(var j=0;j<a.options.length;j++){
			if(a.options[j].selected){
				var vals = a.options[j].text ;
			}
		}
		var id=document.getElementsByName('checkboxes[]');
		var i;
		var j=0;
		var image="";
		for( i=0;i<=parseInt(id.length)-1;i++ ){
			if(id[i].checked){
				j++;
			}
		}
		if( j>=1 ){
			layer_dialog_show('确定'+vals+'?','operate_select()',5);
		}else{
			layer_dialog_show('请选择！！','operate_select()',3);
		}
	}

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
		document.UserForm.onsubmit= "";
		document.UserForm.submit(); 
		batch_action();
	}
}
</script>