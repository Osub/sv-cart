<?php
/*****************************************************************************
 * SV-Cart 待处理评论
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: search.ctp 1116 2009-04-28 11:04:43Z huangbo $
*****************************************************************************/
?> 
<div class="content">
<?=$javascript->link('listtable');?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<!--Main Start-->
<br />
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

<?php echo $form->create('',array('action'=>'','name'=>'UserForm'));?>
	<ul class="product_llist unchecks">
	<li class="number"><input type="checkbox" name="chkall" value="checkbox" onclick="selectAll(this,'checkbox');" />编号</li>
	<li class="username">用户名</li>
	<li class="grade">会员等级</li>
	<li class="type">类型</li>
	<li class="object">评论对象</li>
	<li class="IP">IP地址</li>
	<li class="comment_time">评论时间<?=$html->image('sort_desc.gif',array('align'=>'absmiddle'))?></li>
	<li class="hadle">操作</li></ul>
<!--Comment Uncheck-->
<?if(isset($comments_info) && sizeof($comments_info)>0){?>
<?foreach($comments_info as $k=>$v){?>
	<ul class="product_llist unchecks unchecks_list">
	<li class="number"><input type="checkbox" name="checkbox[]" value="<?=$v['Comment']['id']?>" /><?=$v['Comment']['id']?></li>
	<li class="username"><span><?=$v['Comment']['name']?></span></li>
	<li class="grade"><?=$v['Comment']['user_rank'];?></li>
	<li class="type"><?=$v['Comment']['type']?></li>
	<li class="object"><span><?=$v['Comment']['object']?></span></li>
	<li class="IP"><span><?=$v['Comment']['ipaddr']?></span></li>
	<li class="comment_time"><?=$v['Comment']['created']?></li>
	<li class="hadle">
	<?php echo $html->link("查看详情","/comments/edit_search/{$v['Comment']['id']}");?>
	|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}comments/searchremove/{$v['Comment']['id']}')"));?>
	</li></ul>
	<?}?><?}?>
<!--Comment Uncheck End-->	
 <input type="hidden" name="search" value="search">
<div class="pagers" style="position:relative">
<p class='batch'><select style="width:59px;border:1px solid #689F7C;display:none;" name="act_type"><option value="delete">删除</option></select> <input type="button" onclick="batch_action()" value="删除" /></p>
<? echo $form->end();?>
 <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function batch_action(){ 
	document.UserForm.action=webroot_dir+"comments/batch"; 
	document.UserForm.submit(); 
} 
</script>