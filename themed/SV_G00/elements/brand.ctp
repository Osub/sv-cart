<?php
/*****************************************************************************
 * SV-Cart 品牌导航
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: brand.ctp 1215 2009-05-06 05:46:48Z huangbo $
*****************************************************************************/
?>
<!--Brands-->
<div class="category_box brand_box">
<h3><?=$SCLanguages['brand'];?></h3>
<div class="category brands">
<ul>
<?if(isset($brands) && sizeof($brands)>0){?>	
<?foreach($brands as $k=>$v){
if(isset($v['Brand']['img01']) && $v['Brand']['img01'] !=""){?>
<li><?=$html->link($html->image($v['Brand']['img01'],array('alt'=>$v['BrandI18n']['name'])),"/brands/".$v['Brand']['id'],"",false,false);?></li>
<?}else{?>
<li class="text"><?=$html->link($v['BrandI18n']['name'],"/brands/".$v['Brand']['id'],array("class"=>"color_083"),"",false,false);?></li>
<?}?>
<?}}?>
</ul></div><?=$html->image('category_ulbt.gif',array("alt"=>"","align"=>"left"))?></div>
<!--Brands End-->