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
 * $Id: top.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<!--Brands-->
<?php if(isset($top_products) && sizeof($top_products)>0){?>
<div class="cont">
<span class="left_up">&nbsp;</span><span class="right_up">&nbsp;</span>
<h3><span><?php echo $SCLanguages['sales_ranking']?></span></h3>
<ul class="list">

<?php foreach($top_products as $k=>$v){?>
<li class="squareico">
<?php echo $html->link($v['ProductI18n']['name'],$svshow->sku_product_link($v['Product']['id'],$v['ProductI18n']['name'],$v['Product']['code'],$SVConfigs['use_sku']),array("class"=>"color_083","target"=>"_blank"),"",false,false);?></li>
<?php }?>

</ul>
<span class="left_down">&nbsp;</span><span class="right_down">&nbsp;</span>
</div>
<p class="height_3">&nbsp;</p>
<?php }?>
<!--Brands End-->