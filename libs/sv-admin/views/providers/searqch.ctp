<?php 
/*****************************************************************************
 * SV-Cart  搜索供应商
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: searqch.ctp 3507 2009-08-06 10:52:06Z tangyu $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box"><?php echo $form->create('Provider',array('action'=>'search'));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">关键字：<input type="text" class="name" name="data[provider][name]"/></p></dd>
	<dt class="small_search"><input type="submit" value="搜索" class="search_article" /></dt>
	</dl><?php echo $form->end();?>
</div>
<br />
<!--Search End-->
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增供应商","add/",'',false,false);?></strong></p>
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">

	<ul class="product_llist memberlevels">
	<li class="provider_name">供应商名称</li>
	<li class="contact">联系人</li>
	<li class="email">Email地址</li>
	<li class="contact_phone">联系电话</li>
	<li class="items">当前商品数</li>
	<li class="availability">是否有效</li>
	<li class="hadl_provider">操作</li></ul>
<!--Competence List-->
<?php if(isset($provider_list) && sizeof($provider_list)>0){?>
<?php foreach( $provider_list as $k=>$v ){?>	
	<ul class="product_llist memberlevels memberlevels_list">
	<li class="provider_name"><strong><?php echo $v['Provider']['name']?></strong></li>
	<li class="contact"><?php echo $v['Provider']['contact_name']?></li>
	<li class="email"><span><?php echo $v['Provider']['contact_email']?></span></li>
	<li class="contact_phone"><span><?php echo $v['Provider']['contact_tele']?></span></li>
	<li class="items">520</li>
	<li class="availability"><?php if ($v['Provider']['status'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['Provider']['status'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></li>
	<li class="hadl_provider"><span><?php echo $html->link("编辑","/providers/edit/{$v['Provider']['id']}");?>
|<?php echo $html->link("移除","/providers/remove/{$v['Provider']['id']}");?></span></li></ul>
<?php }} ?>
	

<!--Competence List End-->	

<br />
</div>
<!--Main Start End-->
</div>