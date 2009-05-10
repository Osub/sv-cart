 <rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
     <link>http://www.seevia.cn/</link>
    <title><?=$this_config['shop_name']?></title>
    <description>文章</description> 
    <pubDate> <?php echo date('Y-m-d H:i:s'); ?></pubDate>
    <guid>http://www.seevia.cn/</guid>	
    <docs>http://www.seevia.cn/</docs>
    <generator><?=$this_config['shop_name']?></generator>
    <managingEditor><?=$this_config['customer_service_email']?></managingEditor>
    <webMaster><?=$this_config['smtp_mail']?></webMaster> 

    <?php foreach ($articles as $article): ?>
    <item>
      <title><?php echo $article['ArticleI18n']['title']; ?></title>
      <link>http://<?=$_SERVER['SERVER_NAME']?><?=$this->webroot?>articles/<?php echo $article['Article']['id']; ?></link>
      <description><?php echo $article['ArticleI18n']['meta_keywords']; ?></description>
      <?php echo $article['Article']['created'] ?>
      <pubDate><?php echo $article['Article']['created'] ?></pubDate>
      <guid>http://<?=$_SERVER['SERVER_NAME']?><?=$this->webroot?>articles/<?php echo $article['Article']['id']; ?></guid>
    </item>
    <?php endforeach; ?>
  </channel>
</rss>