 <rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
    <link>http://<?=$_SERVER['HTTP_HOST']?><?=$this->webroot?></link>
    <title><?=$this_config['shop_name']?> - <?=$dynamic?></title>
    <description><?=$this_config['shop_description']?></description> 
    <pubDate><?php echo date('Y-m-d H:i:s'); ?></pubDate>
    <guid>http://<?=$_SERVER['HTTP_HOST']?><?=$this->webroot?></guid>	
    <docs>http://<?=$_SERVER['HTTP_HOST']?><?=$this->webroot?></docs>
    <generator><?=$this_config['shop_name']?></generator>
    <author><?=$this_config['shop_name']?></author>
    <managingEditor><?=$this_config['customer_service_email']?></managingEditor>
    <webMaster><?=$this_config['smtp_mail']?></webMaster> 

    <?php foreach ($articles as $article): ?>
    <item>
      <title><?php echo $article['ArticleI18n']['title']; ?></title>
      <link>http://<?=$_SERVER['SERVER_NAME']?><?=$this->webroot?>articles/<?php echo $article['Article']['id']; ?></link>
      <description><?php echo htmlspecialchars($article['ArticleI18n']['meta_description']); ?></description>
      <?php echo $article['Article']['created'] ?>
      <pubDate><?php echo $article['Article']['created'] ?></pubDate>
      <author><?=$this_config['shop_name']?></author>
      <guid>http://<?=$_SERVER['SERVER_NAME']?><?=$this->webroot?>articles/<?php echo $article['Article']['id']; ?></guid>
    </item>
    <?php endforeach; ?>
  </channel>
</rss>