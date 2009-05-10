<?php
/*****************************************************************************
 * SV-Cart 访问权限管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增访问权限","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist memberlevels">
	<li class="num_purview">权限编号:</li>
	<li class="purview">权限名称</li>
	<li class="code"><p>代码</p></li>
	<li class="bewrite">排序</li>
	<li class="use">是否启用</li>
	<li class="hadl_purview">操作</li></ul>
<?if(isset($Operator_action_list) && sizeof($Operator_action_list)>0){?>
<?php foreach($Operator_action_list as $k => $v){?>
<!--Competence List-->
	<ul class="product_llist memberlevels memberlevels_list">
	<li class="num_purview"><?=$v['Operator_action']['id']?></li>
	<li class="purview"><strong>
	<?=$html->image('menu_minus.gif')?> <?=$v['Operator_action']['name']?></strong></li>
	<li class="code"><p><?=$v['Operator_action']['code']?></p></li>
	<li class="bewrite"><span><?=$v['Operator_action']['orderby']?></span></li>
	<li class="use"><?php if(!empty($v['Operator_action']['status'])&&$v['Operator_action']['status'])echo $html->image('yes.gif'); else echo $html->image('no.gif');?></li>
	<li class="hadl_purview"><span>
	
	<?php echo $html->link("编辑","/competences/edit/{$v['Operator_action']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}competences/remove/{$v['Operator_action']['id']}')"));?>
</span></li></ul>
<!--Second Cat-->
<?php if(isset($v['SubAction']) && sizeof($v['SubAction'])>0)foreach($v['SubAction'] as $kk=>$vv){ ?>
	<ul class="product_llist memberlevels memberlevels_list">
		<li class="num_purview"><span class="num"><?=$vv['Operator_action']['id']; ?></span></li>
	<li class="purview"><span class="second_car"><strong><?=$html->image('menu_minus.gif')?> <?=$vv['Operator_action']['name']; ?></strong></span></li>
	<li class="code"><p><?=$vv['Operator_action']['code']; ?></p></li>
	<li class="bewrite"><span><?=$vv['Operator_action']['orderby']; ?></span></li>
	<li class="use"><?php if(!empty($vv['Operator_action']['status'])&&$vv['Operator_action']['status'])echo $html->image('yes.gif'); else echo $html->image('no.gif');?></li>
	<li class="hadl_purview"><span>

	<?php echo $html->link("编辑","/competences/edit/{$vv['Operator_action']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}competences/remove/{$vv['Operator_action']['id']}')"));?>
	
	</span></li></ul>
<!--Second Cat End-->
<!--Three Cat-->	
<?php if(isset($vv['SubAction']) && sizeof($vv['SubAction'])>0)foreach($vv['SubAction'] as $kkk=>$vvv){ ?>
	<ul class="product_llist memberlevels memberlevels_list">
	<li class="purview"><span class="three_car"><strong><?=$html->image('menu_minus.gif')?> <a><?=$vvv['Operator_action']['name']; ?></a></strong></span></li>
	<li class="code"><?=$vvv['Operator_action']['code']; ?></li>
	<li class="bewrite"><span><?=$vvv['Operator_action']['descrption']; ?></span></li>
	<li class="use"><?php if(!empty($vvv['Operator_action']['status'])&&$vvv['Operator_action']['status'])echo $html->image('yes.gif'); else echo $html->image('no.gif');?></li>
	<li class="hadl_purview"><span><?php echo $html->link("编辑","/competences/edit/{$vvv['Operator_action']['id']}",array(),false,false);?>
	        	  |<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}competences/remove/{$vvv['Operator_action']['id']}')"),false,false);?></span></li></ul>
<!--Three Cat End-->
<?}?><?}?>
<!--Competence List End-->	
<?}?><?}?>
<br />
</div>
<!--Main Start End-->
</div>