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
 * $Id: news.ctp 951 2009-04-24 02:01:46Z shenyunfeng $
*****************************************************************************/
?>
<?php if(isset($SVConfigs['shop_notice']) && $SVConfigs['shop_notice'] != ''){?>
	<div id="News">
    <p><?php echo $html->image("New_img.gif")?></p>
    <div id="newscoll">
	  <p class="text" id="newscoll_1"><?php echo $SVConfigs['shop_notice']?></p>
	  <p class="text" id="newscoll_2"></p>
	</div>
<p><?php echo $html->image("New_img.gif")?></p>
    </div>

<?php }?>

<?php if(isset($scroll_articles) && sizeof($scroll_articles)>0){
//	pr($scroll_articles);
	?>
<div id="News">
<?php echo $html->image('New_img.gif',array('align'=>'top'))?><marquee scrollamount="2">
<p>
	<?php if(isset($scroll_articles) && sizeof($scroll_articles)>0){?>
	<?php foreach($scroll_articles as $k => $v){?>
	<?php echo $html->link($v['ArticleI18n']['title'],"/articles/".$v['Article']['id']);?>  
	<?php }?>
	<?php }?>
</p>
</marquee><?php echo $html->image('New_img.gif',array('align'=>'top'))?>
</div>
<?php }?>