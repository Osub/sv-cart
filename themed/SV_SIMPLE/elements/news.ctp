<?php 
/*****************************************************************************
 * SV-Cart 最新文章
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: news.ctp 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
?>
<?php if(isset($SVConfigs['shop_notice']) && $SVConfigs['shop_notice'] != ''){?>
<div class="cont">
<span class="left_up">&nbsp;</span><span class="right_up">&nbsp;</span>
	<h3><span><?php echo $SCLanguages['notices'];?></span></h3>
	<div class="notice"><?php echo $SVConfigs['shop_notice']?></div>
<span class="left_down">&nbsp;</span><span class="right_down">&nbsp;</span>
</div>
<p class="height_3">&nbsp;</p>
<?php }?>

<?php if(isset($scroll_articles) && sizeof($scroll_articles)>0){?>

<div class="cont">
<span class="left_up">&nbsp;</span><span class="right_up">&nbsp;</span>
	<div class="notice">
	<?php foreach($scroll_articles as $k => $v){?>
	<?php echo $html->link($v['ArticleI18n']['title'],"/articles/".$v['Article']['id']);?>  
	<?php }?>
	</div>
<span class="left_down">&nbsp;</span><span class="right_down">&nbsp;</span>
</div>
<p class="height_3">&nbsp;</p>
<?php }?>