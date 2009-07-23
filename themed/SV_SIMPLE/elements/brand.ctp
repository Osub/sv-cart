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
 * $Id: brand.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?>
<?php if(isset($brands) && sizeof($brands)>0){?>
<!--Brands-->
<div class="cont">
<span class="left_up">&nbsp;</span><span class="right_up">&nbsp;</span>
	<h3><span><?php echo $SCLanguages['brand'].$SCLanguages['list'];?></span></h3>
	<ul class="list">
	<?php foreach($brands as $k=>$v){?>
	<li><?php echo $html->link($v['BrandI18n']['name'],"/brands/".$v['Brand']['id'],array(),"",false,false);?></li>
	<?php }?>
	<li class="more"><?php echo $html->link("<strong>+</strong>".$SCLanguages['all'].$SCLanguages['brand']."...","/products/advancedsearch/SAD/brands/",array(),false,false)?></li>
	</ul>
<span class="left_down">&nbsp;</span><span class="right_down">&nbsp;</span>
</div>
<p class="height_3">&nbsp;</p>
<!--Brands End-->
<?php }?>