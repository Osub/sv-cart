<?php
/*****************************************************************************
 * SV-Cart  添加导航栏
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
<?php //pr($navigations);
	?>
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>'NavigationForm','type'=>'get'));?>

	<dl>
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd>
		<select name="controller" id="controller">
		  <option value="">系统参数</option>
		<? if(isset($controllers) && sizeof($controllers)>0){?>

		<?php foreach($controllers as $k=>$v){?>
		  <option value="<?php echo $k; ?>" <?php if($k==$controller)echo 'selected'; ?>><?php echo $v; ?></option>
		<?php }}?>
		</select>	
		<select name="type" id="type">
		  <option value="">位置</option>
		    <? if(isset($types) && sizeof($types)>0){?>

		<?php foreach($types as $k=>$v){?>
		  <option value="<?php echo $k; ?>" <?php if($k==$type)echo 'selected'; ?>><?php echo $v; ?></option>
		<?php }}?>
		</select>
		关键字：<input type="text" class="name" name="navigation_name"/>&nbsp;&nbsp;
	</dd>
	<dt class="small_search"><input type="submit"  value="搜索"  class="search_article" /></dt>
	</dl>

</div><br></br>
<!--Main Start-->
<p class="add_categories"><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."添加导航","/navigations/add",array(),false,false);?></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist navigation">
	<li class="name"><p>名称</p></li>
	<li class="block">是否显示</li>
	<li class="blank">是否新窗口</li>
	<li class="taixs">排序</li>
	<li class="position">位置</li>
	<li class="hadle">操作</li></ul>
<!--Navigation List-->
		    <? if(isset($navigations2) && sizeof($navigations2)>0){?>
	<?php  foreach($navigations2 as $navigation){ ?>
	<ul class="product_llist navigation navigation_list">
	<li class="name"><p><?php echo $html->link($navigation['NavigationI18n']['name'],$navigation['NavigationI18n']['url'],'',false,false);?></p></li>
	<li class="block"><?php if($navigation['Navigation']['status']){echo $html->image('yes.gif');} else {echo $html->image('no.gif');}?></li>
	<li class="blank"><?php if($navigation['Navigation']['target']=='_blank'){echo $html->image('yes.gif');} else {echo $html->image('no.gif');}?></li>
	<li class="taixs"><?php echo $navigation['Navigation']['orderby'];?></li>
	<li class="position"><?php echo $navigation['Navigation']['typename'];?></li>
	<li class="hadle">

	<?php echo $html->link("编辑","/navigations/edit/{$navigation['Navigation']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}navigations/remove/{$navigation['Navigation']['id']}')"));?>

	</li></ul>
	<?php  }}?>
		

		
<!--User List End-->
<div class="pagers" style="position:relative">	
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>

</div>

<!--Main Start End-->
