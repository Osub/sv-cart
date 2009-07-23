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
 * $Id: category_A.ctp 2535 2009-07-02 11:34:51Z huangbo $
*****************************************************************************/
?>
<!--文章分类显示开始-->
<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?>
<div class="category_box">
<h3 class="font_14"><span class="l"></span><span class="r"></span><?php echo $SCLanguages['classificatory']?></h3>
	<?php //pr($categories_tree);?>
<div id="bd" class="box"><div class="svcart-b"><div id="catmenu" class="svcartmenu"><div class="bd"><ul class="first-of-type">
<?php foreach($categories_tree as $first_k=>$first_v){?>
<li class="svcartmenuitem first-of-type">
<?php if(!empty($first_v['Category']['link'])){?>
<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?>	
<?php echo $html->link($first_v['CategoryI18n']['name'],"/articles/".$first_v['Category']['link'],array("class"=>"over"),false,false);?>
<?php }else{?>
<?php echo $html->link($first_v['CategoryI18n']['name'],"/articles/".$first_v['Category']['link'],array("class"=>"normal"),false,false);?>
<?php }?>
<?php }else{?>
<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?>	
<?php echo $html->link($first_v['CategoryI18n']['name'],"/articles/".$first_v['Category']['id'],array("class"=>"over"),false,false);?>
<?php }else{?>
<?php echo $html->link($first_v['CategoryI18n']['name'],"/articles/".$first_v['Category']['id'],array("class"=>"normal"),false,false);?>
<?php }?>
<?php }?>
<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?>
<div class="svcartmenu"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'LeftsubNav_top.gif':'LeftsubNav_top.gif',array("alt"=>"", "align"=>"left"))?><div class="bd Sub_bd"><ul class="secend_muen">
<?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<li class="svcartmenuitem No_bg">
<?php if(!empty($second_v['Category']['link'])){?>
<?php echo $html->link($first_v['CategoryI18n']['name'],"/articles/".$second_v['Category']['link'],"",false,false);?>
<?php }else{?>
<?php echo $html->link($second_v['CategoryI18n']['name'],"/category_articles/".$second_v['Category']['id'],"",false,false);?>
<?php }?>
<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?>
<div class="svcartmenu"><div class="bd"><ul class="first-of-type">
<?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<li class="svcartmenuitem"><?php echo $html->link($third_v['CategoryI18n']['name'],"/category_articles/".$third_v['Category']['id'],"",false,false);?></li>
<?php }?></ul></div></div>
<?php }?></li>
<?php }?></ul></div><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'LeftsubNav_bottom.gif':'LeftsubNav_bottom.gif',array("alt"=>"","align"=>"top"))?></div>
<?php }?></li>
<?php }?></ul></div></div></div></div><p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'category_ulbt.gif':'category_ulbt.gif',array("alt"=>""))?></p></div>
<?php }?>

<!--文章分类显示结束-->