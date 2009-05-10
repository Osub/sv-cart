<?php
/*****************************************************************************
 * SV-Cart 用户设置管理
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
<?=$javascript->link('listtable');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增用户设置","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<?php echo $form->create('',array('action'=>'','name'=>"UserForm","type"=>"get"));?>

	<ul class="product_llist commets_title users_lists">
	<li class="number"><label><input type="checkbox" name="checkbox" value="checkbox" onclick="selectAll(this,'checkbox');" />编号<?=$html->image('sort_desc.gif',array('align'=>'absmiddle'))?></label></li>
	<li class="username">用户名称</li>
	<li class="user_grade">用户等级</li>
	<li class="default">默认值</li>
	<li class="html_type">html类型</li>
	<li class="hadle">操作</li></ul>
<!--User List-->
<?if(isset($UserConfig_list) && sizeof($UserConfig_list)>0){?>
<? foreach( $UserConfig_list as $k=>$v ){ ?>
	<ul class="product_llist commets_title commets_list users_lists">
	<li class="number"><label><input type="checkbox" name="checkbox[]" value="<?=$v['UserConfig']['id']?>" /><?=$v['UserConfig']['id']?></label></li>
	<li class="username"><span><?=$v['UserConfigI18n']['name']?></span></li>
	<li class="user_grade"><?=$v['UserConfig']['user_rank']?></li>
	<li class="default"><span><?=$v['UserConfig']['value']?></span></li>
	<li class="html_type"><?=$v['UserConfig']['type']?></li>
	<li class="hadle">
	<?php echo $html->link("编辑","/userconfigs/edit/{$v['UserConfig']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}userconfigs/remove/{$v['UserConfig']['id']}')"));?>

	</li></ul>
	<? }} ?>

<!--User List End-->	
	
	
	
	

<div class="pagers" style="position:relative"><?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
<p class='batch'><select style="width:59px;border:1px solid #689F7C;display:none" name="act_type"><option value="delete">删除</option></select> <input type="submit" onclick="batch_action()" value="删除" /></p>
<? echo $form->end();?>
    </div>
</div>
</div> 
<script type="text/javascript">
function batch_action() 
{ 
document.UserForm.action=webroot_dir+"userconfigs/batch"; 
document.UserForm.submit(); 
} 
</script>