<?php
/*****************************************************************************
 * SV-Cart 待处理留言
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: search.ctp 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?=$javascript->link('listtable');?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<!--Main Start-->
<br />
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<?php echo $form->create('',array('action'=>'','name'=>'UserForm','onsubmit'=>"return false"));?>

	<ul class="product_llist unchecks unprocess">
	<li class="number"><input type="checkbox" name="chkall" value="checkbox" onclick="selectAll(this,'checkbox');" />编号<?=$html->image('sort_desc.gif',array('align'=>'absmiddle'))?></li>
	<li class="username">用户名</li>
	<li class="grade">会员等级</li>
	<li class="object msg_headers">留言标题</li>
	<li class="type">类型</li>
	<li class="comment_time msg_time">留言时间<?=$html->image('sort_desc.gif',array('align'=>'absmiddle'))?></li>
	<li class="hadle">操作</li></ul>
<!--Comment Uncheck-->
	<? if(isset($UserMessage_list) && sizeof($UserMessage_list)>0){?>
	<?php foreach($UserMessage_list as $k=>$v){ ?>
	<ul class="product_llist unchecks unchecks_list unprocess">
	<li class="number"><input type="checkbox" name="checkbox[]" value="<?php echo $v['UserMessage']['id'] ?>" /><?php echo $v['UserMessage']['id'] ?></li>
	<li class="username"><span><?php echo $v['UserMessage']['name'] ?></span></li>
	<li class="grade"><?php echo $v['UserMessage']['rank'] ?></li>

	<li class="object"><span><?=$html->link("{$v['UserMessage']['msg_title']}","/messages/view_search/{$v['UserMessage']['id']}",'',false,false);?></span></li>
	<li class="type"><?php echo $v['UserMessage']['msg_type'] ?></li>
	<li class="comment_time"><?php echo $v['UserMessage']['created'] ?></li>
	<li class="hadle">


	<?php echo $html->link("编辑","/messages/view_search/{$v['UserMessage']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}messages/remove_search/{$v['UserMessage']['id']}')"));?>

		</li></ul>
	<? } }?>

<!--Comment Uncheck End-->	
	
	<input type="hidden" name="search" value="search">
<div class="pagers" style="position:relative">
<p class='batch'><select name="act_type"  style="width:59px;border:1px solid #689F7C;display:none;"><option value="delete">删除</option></select> <input type="button" onclick="batch_action()" value="删除" /></p>
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
</div>
<!--Main Start End-->
</div>  
<? echo $form->end();?>
<script type="text/javascript">
function batch_action() 
{ 
document.UserForm.action=webroot_dir+"messages/batch"; 
document.UserForm.onsubmit= "";
document.UserForm.submit(); 
} 


</script>