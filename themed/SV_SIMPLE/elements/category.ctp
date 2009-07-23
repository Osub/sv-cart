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
 * $Id: category.ctp 2757 2009-07-10 08:42:37Z wuchao $
*****************************************************************************/
?>
<!--商品分类显示开始-->
<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?>
<div class="category_box">
<h3 class="font_14"><span class="l"></span><span class="r"></span><?php echo $SCLanguages['classificatory']?></h3>
<div id="bd" class="box">
<div id="catmenu" class="svcartmenu">
<div class="bd">
<ul>
<?php foreach($categories_tree as $first_k=>$first_v){?>
<li class="svcartmenuitem first-of-type">
		<?php 
		$first_v_url = str_replace(" ","-",$first_v['CategoryI18n']['name']);
		$first_v_url = str_replace("/","-",$first_v_url);
		?>

<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?>
	<?php if($SVConfigs['use_sku']==1){?>
	<?php echo $html->link($first_v['CategoryI18n']['name'],"/categories/".$first_v['Category']['id']."/".$first_v_url."/0/",array("class"=>"over"),false,false);?>
	<?php }else{?>
	<?php echo $html->link($first_v['CategoryI18n']['name'],"/categories/".$first_v['Category']['id'],array("class"=>"over"),false,false);?>
	<?php }?>
<?php }else{?>
	<?php if($SVConfigs['use_sku']==1){?>
	<?php echo $html->link($first_v['CategoryI18n']['name'],"/categories/".$first_v['Category']['id']."/".$first_v_url,array("class"=>"normal"),false,false);?>
	<?php }else{?>
	<?php echo $html->link($first_v['CategoryI18n']['name'],"/categories/".$first_v['Category']['id'],array("class"=>"normal"),false,false);?>
	<?php }?>
<?php }?>
<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?>
<div class="svcartmenu"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'LeftsubNav_top.gif':'LeftsubNav_top.gif',array("alt"=>"", "align"=>"left"))?><div class="bd Sub_bd"><ul class="secend_muen" style="padding-bottom:0;">
<?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<li class="svcartmenuitem No_bg">
		<?php 
		$second_v_url = str_replace(" ","-",$second_v['CategoryI18n']['name']);
		$second_v_url = str_replace("/","-",$second_v_url);
		?>
	<?php if($SVConfigs['use_sku']==1){?>
	<?php echo $html->link($second_v['CategoryI18n']['name'],"/categories/".$second_v['Category']['id']."/".$first_v_url."/".$second_v_url,array(),false,false);?>
	<?php }else{?>
	<?php echo $html->link($second_v['CategoryI18n']['name'],"/categories/".$second_v['Category']['id'],array(),false,false);?>
	<?php }?>
<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?>
<div class="svcartmenu"><div class="bd"><ul class="first-of-type">
<?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
	
<li class="svcartmenuitem"><?php echo $html->link($third_v['CategoryI18n']['name'],"/categories/".$third_v['Category']['id'],"",false,false);?></li>

<?php }?></ul></div></div>
<?php }?></li>
<?php }?></ul></div><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'LeftsubNav_bottom.gif':'LeftsubNav_bottom.gif',array("alt"=>"","align"=>"top"))?></div>
<?php }?></li>
<?php }?></ul></div>
</div></div><p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'category_ulbt.gif':'category_ulbt.gif',array("alt"=>""))?></p></div>
<?php }?>

<!--商品分类显示结束-->