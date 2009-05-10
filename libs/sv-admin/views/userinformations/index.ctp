<?php
/*****************************************************************************
 * SV-Cart 用户信息管理
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
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<br />
<!--Search End-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增用户信息","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
	<ul class="product_llist users_title">
	<li class="number"><p style="padding-left:10px">名称</p></li>
	<li class="name" style="text-align:center">类型</li>
	<li class="grade">是否有效</li>
	<li class="email">前台显示</li>
	<li class="date">后台显示</li>
	<li class="hadle">操作</li>
	</ul>
<?if(isset($userinfo_list) && sizeof($userinfo_list)>0){?>
<?foreach($userinfo_list as $k=>$v){?>
	<ul class="product_llist products users_title">
	<li class="number"><p style="padding-left:10px"><?echo $v['UserInfoI18n']['name']?></p></li>
	<li class="name" style="text-align:center"><?echo $v['UserInfo']['type']?></li>
	<li class="grade"><?if($v['UserInfo']['status']==1){?><?=$html->image('yes.gif',array('align'=>'absmiddle','onclick'=>''))?><?}else{?><?=$html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?}?></li>
	<li class="email"><?if($v['UserInfo']['front']==1){?><?=$html->image('yes.gif',array('align'=>'absmiddle','onclick'=>''))?><?}else{?><?=$html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?}?></li>
	<li class="date"><?if($v['UserInfo']['backend']==1){?><?=$html->image('yes.gif',array('align'=>'absmiddle','onclick'=>''))?><?}else{?><?=$html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?}?></li>
	<li class="hadle">
	<?php echo $html->link("编辑","/userinformations/edit/{$v['UserInfo']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}userinformations/remove/{$v['UserInfo']['id']}')"));?>
	</li></ul>
<?}}?>
	
   <div class="pagers" style="position:relative">


<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
