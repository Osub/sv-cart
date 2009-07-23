 <rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
    <link>http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $cart_webroot?></link>
    <title><?php echo $this_config['shop_name']?> - <?php echo $dynamic?></title>
    <description><?php echo $this_config['shop_description']?></description> 
    <pubDate><?php echo date('Y-m-d H:i:s'); ?></pubDate>
    <guid>http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $cart_webroot?></guid>	
    <docs>http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $cart_webroot?></docs>
    <generator><?php echo $this_config['shop_name']?></generator>
    <author><?php echo $this_config['shop_name']?></author>
    <managingEditor><?php echo $this_config['customer_service_email']?></managingEditor>
    <webMaster><?php echo $this_config['smtp_mail']?></webMaster> 

    <?php foreach ($articles as $article): ?>
    <item>
      <title><?php echo $article['ArticleI18n']['title']; ?></title>
      <link>http://<?php echo $_SERVER['SERVER_NAME']?><?php echo $cart_webroot?>articles/<?php echo $article['Article']['id']; ?></link>
      <description><?php echo htmlspecialchars($article['ArticleI18n']['meta_description']); ?></description>
      <?php echo $article['Article']['created'] ?>
      <pubDate><?php echo $article['Article']['created'] ?></pubDate>
      <author><?php echo $this_config['shop_name']?></author>
      <guid>http://<?php echo $_SERVER['SERVER_NAME']?><?php echo $cart_webroot?>articles/<?php echo $article['Article']['id']; ?></guid>
    </item>
    <?php endforeach; ?>
  </channel>
</rss>