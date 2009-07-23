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
 * $Id: brand.ctp 2525 2009-07-02 05:42:37Z shenyunfeng $
*****************************************************************************/
?>
<!--Brands-->
<div class="category_box brand_box">
<h3><span class="l"></span><span class="r"></span><?php echo $SCLanguages['brand'];?></h3>
<div class="category brands box">
<ul>
<?php if(isset($brands) && sizeof($brands)>0){?>	
<?php foreach($brands as $k=>$v){
if(isset($v['Brand']['img01']) && !empty($v['Brand']['img01'])){?>
<li><?php echo $html->link($html->image($v['Brand']['img01'],array('alt'=>$v['BrandI18n']['name'])),"/brands/".$v['Brand']['id'],"",false,false);?></li>
<?php }else{?>
<li class="text"><?php echo $html->link($v['BrandI18n']['name'],"/brands/".$v['Brand']['id'],array("class"=>"color_083"),"",false,false);?></li>
<?php }?>
<?php }}?>
</ul></div><p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'category_ulbt.gif':'category_ulbt.gif',array("alt"=>""))?></p></div>
<!--Brands End-->