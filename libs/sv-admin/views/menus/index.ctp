<?php
/*****************************************************************************
 * SV-Cart 菜单管理
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
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>

<!--Main Start-->
<p class="add_categories"><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增菜单","/menus/add",array(),false,false);?></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist menus">
	<li class="menu_name"><p style="padding-left:15px;">菜单名称</p></li>
	<li class="menu_code"><p>菜单代码</p></li>
	<li class="menu_links"><p>超级链接</p></li>
	<li class="block">是否显示</li>
	<li class="taxis">排序</li>
	<li class="hadle_menu">操作</li></ul>
		
	<? if(isset($menus_tree) && sizeof($menus_tree)>0){?>
	<?php foreach($menus_tree as $k => $v){//pr($v);?>
		
	<ul class="product_llist products menus">
	<li class="menu_name">
	<cite>
<?=$html->link($html->image('menu_plus.gif',array("id"=>"menulist{$k}")),"javascript:b1_onclick('menulist{$k}','list{$k}');",array("id"=>""),false,false)?>
		<?//=$html->image('menu_plus.gif')?>
		<a><?php echo $v['Operator_menuI18n']['name'];?></a>
	</cite>
	</li>
	<li class="menu_code"><p><?php echo $v['Operator_menu']['operator_action_code']?></p></li>
	<li class="menu_links"><?php echo $v['Operator_menu']['link']?></li>
	<li class="block"><?php if(!empty($v['Operator_menu']['status'])&&$v['Operator_menu']['status'])echo $html->image('yes.gif'); else echo $html->image('no.gif');?></li>
	<li class="taxis"><?php echo $v['Operator_menu']['orderby']?></li>
	<li class="hadle_menu"><span>
		
	<?php echo $html->link("编辑","/menus/edit/{$v['Operator_menu']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}menus/remove/{$v['Operator_menu']['id']}')"));?>
	        	  	  
	</span></li></ul>
<!--second menu-->
<span id="list<?=$k?>" style="display:none">
	<?php if(isset($v['SubMenu']) && sizeof($v['SubMenu'])>0)foreach($v['SubMenu'] as $kk=>$vv){?>
	<ul class="product_llist products second_menu" style="height:100%;overflow:hidden;">
	<li class="menu_name" style="margin-bottom:-10000px;padding-bottom:10006px;"><span><?php echo $html->link($vv['Operator_menuI18n']['name'],"edit/{$vv['Operator_menu']['id']}",array(),false,false);?></span></li>
	<li class="menu_code" style="margin-bottom:-10000px;padding-bottom:10008px;"><p><?php echo $vv['Operator_menu']['operator_action_code']?></p></li>
	<li class="menu_links" style="margin-bottom:-10000px;padding-bottom:10008px;"><p><?php echo $vv['Operator_menu']['link']?></p></li>
	<li class="block" style="margin-bottom:-10000px;padding-bottom:10008px;"><?php if(!empty($vv['Operator_menu']['status'])&&$vv['Operator_menu']['status'])echo $html->image('yes.gif'); else echo $html->image('no.gif');?></li>
	<li class="taxis" style="margin-bottom:-10000px;padding-bottom:10008px;"><?php echo $vv['Operator_menu']['orderby']?></li>
	<li class="hadle_menu" style="margin-bottom:-10000px;padding-bottom:10008px;"><span>

	<?php echo $html->link("编辑","/menus/edit/{$vv['Operator_menu']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}menus/remove/{$vv['Operator_menu']['id']}')"));?>

	
	
	</span></li></ul>
	
<!--second menu End-->	
<?php }?>
</span>
	<?php }}?>
<br /><br /><br /><br />
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function b1_onclick(obj1,obj2) {

	var test = document.getElementById(obj1).src;
	if(test.indexOf("minus.gif") != -1){	
		document.getElementById(obj1).src = webroot_dir+"img/menu_plus.gif";
		document.getElementById(obj2).style.display = "none";
	}else{
		document.getElementById(obj2).style.display = "block";
		document.getElementById(obj1).src = webroot_dir+"img/minus.gif";
	}
	

	
}


</script>