<?php 
/*****************************************************************************
 * SV-Cart 最新文章
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: news.ctp 2550 2009-07-03 06:35:49Z tangyu $
*****************************************************************************/
?>
<?php if(isset($SVConfigs['shop_notice']) && $SVConfigs['shop_notice'] != ''){?>
	<div id="News">
    <p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."New_img.gif":"New_img.gif")?></p>
    <div id="newscoll">
	  <p class="text" id="newscoll_1"><?php echo $SVConfigs['shop_notice']?></p>
	  <p class="text" id="newscoll_2"></p>
	</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."New_img.gif":"New_img.gif")?></p>
    </div>

<?php }?>

<?php if(isset($scroll_articles) && sizeof($scroll_articles)>0){
//	pr($scroll_articles);
	?>
<div id="News">
<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'New_img.gif':'New_img.gif',array('align'=>'top'))?><marquee scrollamount="2">
<p>
	<?php if(isset($scroll_articles) && sizeof($scroll_articles)>0){?>
	<?php foreach($scroll_articles as $k => $v){?>
	<?php echo $html->link($v['ArticleI18n']['title'],"/articles/".$v['Article']['id']);?>  
	<?php }?>
	<?php }?>
</p>
</marquee><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'New_img.gif':'New_img.gif',array('align'=>'top'))?>
</div>
<?php }?>