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
 * $Id: news.ctp 1028 2009-04-24 12:23:26Z huangbo $
*****************************************************************************/
?>
<?if(isset($SVConfigs['shop_notice']) && $SVConfigs['shop_notice'] != ''){?>
	<div id="News">
    <p><?=$html->image("New_img.gif")?></p>
    <div id="newscoll">
	  <p class="text" id="newscoll_1"><?=$SVConfigs['shop_notice']?></p>
	  <p class="text" id="newscoll_2"></p>
	</div>
<p><?=$html->image("New_img.gif")?></p>
    </div>

<?}?>

<?if(isset($scroll_articles) && sizeof($scroll_articles)>0){?>

<div id="News">
    <p><?=$html->image("New_img.gif")?></p>
    <div id="newscoll">
	<p class="text" id="newscoll_1">	
		<?foreach($scroll_articles as $k => $v){?>
		<?=$html->link($v['ArticleI18n']['title'],"/articles/".$v['Article']['id']);?>  
		<?}?>
	</p>
	<p class="text" id="newscoll_2"></p>
	</div>
	<p><?=$html->image("New_img.gif")?></p>
</div>
<?}?>