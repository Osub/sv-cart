<?php
/*****************************************************************************
 * SV-Cart 购物车显示包装
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 789 2009-04-18 15:57:07Z huangbo $
*****************************************************************************/
?>
<?if(isset($svcart['products']) && sizeof($svcart['products'])>0 && empty($all_virtual)){?>
<!--   package   begin     -->
<? if(isset($packages) && sizeof($packages)>0) { ?>
<ul class="content_tab">
<li id="one1" class="hover"><span><b style="letter-spacing:1px;"><?=$SCLanguages['packaging'];?></b></span></li>
</ul>
<?=$html->image('protion-top.gif',array('align'=>'absbottom'))?>
<div id="Item_List" class="border_side" style="padding-bottom:5px;">
<ul id="con_one_1" style="height:100%;overflow:hidden;">
<? foreach($packages as $k=>$v) {?>
<li>
<p class="pic">
<?if($v['Packaging']['img01'] != ""){?>
<?=$html->link($html->image($v['Packaging']['img01'],array("alt"=>$v['PackagingI18n']['name'], "width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),"/carts/#","",false,false);?> 
<?}else{?>
<?=$html->link($html->image("/img/product_default.jpg",array("alt"=>$v['PackagingI18n']['name'], "width"=>isset($SVConfigs['thumbl_image_width'])?$SVConfigs['thumbl_image_width']:108,"height"=>isset($SVConfigs['thumb_image_height'])?$SVConfigs['thumb_image_height']:108)),"/carts/#","",false,false);?> 	
<?}?>
</p>
<p class="info">
<span class="name carts"><?php echo $v['PackagingI18n']['name'];?></span>
<span class="Price"><?=$SCLanguages['our_price'];?>：<font color="#ff0000">
	<?=$svshow->price_format($v['Packaging']['fee'],$SVConfigs['price_format']);?>	
	</font></span>
<span class="stow cart"><?=$html->link(__($SCLanguages['put_into_cart'],array("alt"=>$SCLanguages['put_into_cart'])),"javascript:buy_on_cart_page('packaging',".$v['Packaging']['id'].")");?></span>
</p>
</li>
<?}?> 
</ul>
</div>
<?=$html->image('protion-bottom.gif',array('align'=>'texttop'))?>
<?}?>
<?}?>