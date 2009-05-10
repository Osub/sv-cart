<?php
/*****************************************************************************
 * SV-Cart 搜索用户
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: search.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour',"navigations"=>$navigations));//pr($users);?>
<br />
<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist unvalidate">
	<li class="number"><input type="checkbox" name="checkbox" value="checkbox" />编号<?=$html->image('sort_desc.gif',array('align'=>'absmiddle'))?></li>
	<li class="name">会员名称</li>
	<li class="email">邮件地址</li>
	<li class="date">注册日期</li>
	<li class="balance">余额</li>
	<li class="hadle">操作</li></ul>
<!--Unvalidate List-->
<?if(isset($users) && sizeof($users)>0){?>
	<?php foreach($users as $user){?>
	<ul class="product_llist unvalidate unvalidate_list">
	<li class="number"><input type="checkbox" name="checkbox" value="checkbox" /><?=$user['User']['id']?></li>
	<li class="name"><strong><?php echo $user['User']['name']?></strong></li>
	<li class="email"><span><?php echo $user['User']['email']?></span></li>
	<li class="date"><?php echo $user['User']['created']?></li>
	<li class="balance"><?php echo $user['User']['balance']?></li>
	<li class="hadle">
		<span><?php echo $html->link('认证','search/userconfirm/'.$user['User']['id'],'',false,false)?></a></span>|<span><?php echo $html->link('取消认证','search/cancel/'.$user['User']['id'],'',false,false)?></span>
	</li></ul>
	<?php }}?>

<!--<p class='batch'><select style="width:59px;border:1px solid #689F7C"><option>删除</option></select> <input type="button" value="批量处理" /></p>-->
<div class="pagers" style="position:relative">
<?php echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>