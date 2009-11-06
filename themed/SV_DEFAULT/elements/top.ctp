<?php 
/*****************************************************************************
 * SV-Cart 销售排行
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: top.ctp 4333 2009-09-17 10:46:57Z huangbo $
*****************************************************************************/
?>
<!--Brands-->
<div class="category_box brand_box">
<h3><span class="l"></span><span class="r"></span><?php echo $SCLanguages['sales_ranking']?></h3>
<div class="category toplist box color_083">
<?php if(isset($top_products) && sizeof($top_products)>0){?>	
<?php foreach($top_products as $k=>$v){?>
<ul>
	<li class="number"><?=($k+1);?></li>
	<li><?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['product_link_type']),array("class"=>"color_083","target"=>"_blank"),"",false,false);?></li>
	</ul>
<?php }}?>
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'category_ulbt.gif':'category_ulbt.gif',array("alt"=>""))?></p>
</div>
<!--Brands End-->