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
 * $Id: index.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?> 


 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>'UserForm','type'=>'get','onsubmit'=>"return false"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">评论内容：<input type="text" class="name" name="content" value="<?php echo @$content?>"/>&nbsp;&nbsp;发布时间：<input type="text" name="start_time" class="time" id="date" value="<?php echo @$start_time?>" readonly="readonly" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?>－<input type="text" name="end_time" value="<?php echo @$end_time?>" class="time" id="date2" readonly="readonly" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?></p></dd>
	<dt class="small_search"><input type="submit" value="搜索"  class="search_article" onclick="search_user()" /></dt>
	</dl>
</div>
<br /><br />

<!--Search End-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<input type="hidden" name="search" value="one">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th align="left"><input type="checkbox" name="chkall" value="checkbox" onclick="selectAll(this,'checkbox');" />编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th>用户名</th>
	<th>类型</th>
	<th>评论对象</th>
	<th><font face="arial">IP地址</font></th>
	<th>评论时间<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th>状态</th>
	<th>操作</th></tr>
<!--Comment List-->
<?php if(isset($comments_info) && sizeof($comments_info)>0){?>
<?php foreach($comments_info as $k=>$v){?>
	<tr>
	<td><input type="checkbox" name="checkbox[]" value="<?php echo $v['Comment']['id']?>" /><?php echo $v['Comment']['id']?></td>
	<td><span><?php echo $v['Comment']['name']?></span></td>
	<td align="center"><span><?php echo $v['Comment']['type']?></span></td>
	<td align="center"><span><?php echo $v['Comment']['object']?></span></td>
	<td align="center"><?php echo $v['Comment']['ipaddr']?></td>
	<td align="center"><?php echo $v['Comment']['created']?></td>
	<td align="center"><?php if($v['Comment']['status']=='1'){ echo "显示"; }if($v['Comment']['status']=='0'){  echo "不显示"; }if($v['Comment']['status']=='2'){  echo "删除"; } ?></td>
	<td align="center"><?php echo $html->link("查看详情","/comments/edit/{$v['Comment']['id']}");?>
|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}comments/remove/{$v['Comment']['id']}')"));?></td></tr>

<?php }?><?php }?>
	</table>
<!--Comment List End-->	
<div class="pagers" style="position:relative">
<?php if(isset($comments_info) && sizeof($comments_info)>0){?>
<p class='batch'><select name="act_type" style="width:59px;border:1px solid #689F7C;display:none">
	<option value="delete">删除</option>
	</select> <input type="submit" value="删除" onclick="batch_action()" /></p>
<?php }?>
<?php echo $form->end();?><div class="box">
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
document.UserForm.onsubmit= "";
document.UserForm.submit(); 
} 
function search_user() 
{ 
document.UserForm.action=webroot_dir+"comments/"; 
document.UserForm.onsubmit= "";
document.UserForm.submit(); 
} 

</script>