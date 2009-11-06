<?php 
/*****************************************************************************
 * SV-Cart 邮件队列列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3792 2009-08-19 11:21:35Z zhengli $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<?php echo $form->create('',array('action'=>'','name'=>'UserForm',"onsubmit"=>"return false","type"=>"get"));?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">	
	<th width="6%"><input type="checkbox" name="chkall" value="checkbox" onclick="selectAll(this,'checkbox');" />编号</th>
	<th>邮件标题</th>
	<th>邮件地址</th>
	<th width="8%">优先级</th>
	<th width="8%">错误次数</th>
	<th width="12%">上次发送</th>
	<th width="6%">操作</th>
</tr>
<!--User List-->
<?php if(isset($mailsendqueue_data) && sizeof($mailsendqueue_data)>0){?>
<?php foreach($mailsendqueue_data as $k=>$v){ ?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >	
	<td><input type="checkbox" name="checkbox[]" value="<?php echo $v['MailSendQueue']['id'] ?>" /><?php echo $v['MailSendQueue']['id'] ?></td>
	<td><?php echo $v['MailSendQueue']['title'] ?></td>
	<td><?php $receiver_email_arr = explode(";",$v['MailSendQueue']['receiver_email']);echo $receiver_email_arr[1]?></td>
	<td align="center"><?php echo $v['MailSendQueue']['pri'] ?></td>
	<td align="center"><?php echo $v['MailSendQueue']['flag'] ?></td>
	<td align="center"><?php echo $v['MailSendQueue']['modified'] ?></td>
	<td align="center">
	<?php echo $html->link("删除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}sendlists/remove/{$v['MailSendQueue']['id']}')"));?>
	</td>
</tr>
<?php }}else{?>
<tr><td align="center" colspan="7"><br />没有找到任何记录<br /><br /></td></tr>
<?php }?>
</table></div>
<!--User List End-->	
<div class="pagers" style="position:relative">
	<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
<?php if(isset($mailsendqueue_data) && sizeof($mailsendqueue_data)>0){?>
<p class='batch'><input type="button" onclick="batch_func(this,'batch_delete_action()')" value="删除" /> <input type="button" onclick="batch_func(this,'batch_sel_send_action()')" value="选择发送" /> <input type="button" onclick="batch_func(this,'batch_all_send_action()')" value="全部发送" /></p>  
<?php }?>
</div>
<?php echo $form->end();?>
<!--Main Start End-->
</div>
<script type="text/javascript">
function batch_func(obj,func){ 
	layer_dialog_show('确定'+obj.value+'?',func,5);
}
function batch_delete_action(){ 
	document.UserForm.action=webroot_dir+"sendlists/batch_delete"; 
	document.UserForm.onsubmit=""; 
	document.UserForm.submit(); 
} 
function batch_sel_send_action(){ 
	document.UserForm.action=webroot_dir+"sendlists/batch_sel_send"; 
	document.UserForm.onsubmit=""; 
	document.UserForm.submit(); 
} 
function batch_all_send_action(){ 
	window.location.href = webroot_dir+"sendlists/batch_all_send"; 
} 
</script>