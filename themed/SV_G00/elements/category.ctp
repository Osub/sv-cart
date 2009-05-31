<?php
/*****************************************************************************
 * SV-Cart 商品分类
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: category.ctp 1732 2009-05-25 12:03:32Z huangbo $
*****************************************************************************/
?>
<!--商品分类显示开始-->
<?if(isset($categories_tree) && sizeof($categories_tree)>0){?>
<div class="category_box">
<h3 class="font_14"><span class="l"></span><span class="r"></span><?=$SCLanguages['classificatory']?></h3>
<div id="bd" class="box">
<div id="catmenu" class="svcartmenu">
<div class="bd">
<ul>
<?foreach($categories_tree as $first_k=>$first_v){?>
<li class="svcartmenuitem first-of-type">
<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?>
	<?if($SVConfigs['use_sku']==1){?>
	<?=$html->link($first_v['CategoryI18n']['name'],"/categories/".$first_v['Category']['id']."/".$first_v['CategoryI18n']['name']."/0/",array("class"=>"over"),false,false);?>
	<?}else{?>
	<?=$html->link($first_v['CategoryI18n']['name'],"/categories/".$first_v['Category']['id'],array("class"=>"over"),false,false);?>
	<?}?>
<?}else{?>
	<?if($SVConfigs['use_sku']==1){?>
	<?=$html->link($first_v['CategoryI18n']['name'],"/categories/".$first_v['Category']['id']."/".$first_v['CategoryI18n']['name'],array("class"=>"normal"),false,false);?>
	<?}else{?>
	<?=$html->link($first_v['CategoryI18n']['name'],"/categories/".$first_v['Category']['id'],array("class"=>"normal"),false,false);?>
	<?}?>
<?}?>
<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?>
<div class="svcartmenu"><?=$html->image('LeftsubNav_top.gif',array("alt"=>"", "align"=>"left"))?><div class="bd Sub_bd"><ul class="secend_muen" style="padding-bottom:0;">
<?foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<li class="svcartmenuitem No_bg">

	<?if($SVConfigs['use_sku']==1){?>
	<?=$html->link($second_v['CategoryI18n']['name'],"/categories/".$second_v['Category']['id']."/".$first_v['CategoryI18n']['name']."/".$second_v['CategoryI18n']['name'],array(),false,false);?>
	<?}else{?>
	<?=$html->link($second_v['CategoryI18n']['name'],"/categories/".$second_v['Category']['id'],array(),false,false);?>
	<?}?>
<?if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?>
<div class="svcartmenu"><div class="bd"><ul class="first-of-type">
<?foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
	
<li class="svcartmenuitem"><?=$html->link($third_v['CategoryI18n']['name'],"/categories/".$third_v['Category']['id'],"",false,false);?></li>

<?}?></ul></div></div>
<?}?></li>
<?}?></ul></div><?=$html->image('LeftsubNav_bottom.gif',array("alt"=>"","align"=>"top"))?></div>
<?}?></li>
<?}?></ul></div>
</div></div><p><?=$html->image('category_ulbt.gif',array("alt"=>""))?></p></div>
<?}?>

<!--商品分类显示结束-->