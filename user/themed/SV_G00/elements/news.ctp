<?php
/*****************************************************************************
 * SV-Cart ��������
 *===========================================================================
 * ��Ȩ���� �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
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

<?if(isset($scroll_articles) && sizeof($scroll_articles)>0){
//	pr($scroll_articles);
	?>
<div id="News">
<?=$html->image('New_img.gif',array('align'=>'top'))?><marquee scrollamount="2">
<p>
	<?if(isset($scroll_articles) && sizeof($scroll_articles)>0){?>
	<?foreach($scroll_articles as $k => $v){?>
	<?=$html->link($v['ArticleI18n']['title'],"/articles/".$v['Article']['id']);?>  
	<?}?>
	<?}?>
</p>
</marquee><?=$html->image('New_img.gif',array('align'=>'top'))?>
</div>
<?}?>