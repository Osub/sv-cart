 <rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
     <link>http://www.seevia.cn/</link>
    <title><?=$this_config['shop_name']?></title>
    <description>商品</description> 
    <pubDate> <?php echo date('Y-m-d H:i:s'); ?></pubDate>
    <guid>http://www.seevia.cn/</guid>	
    <docs>http://www.seevia.cn/</docs>
    <generator><?=$this_config['shop_name']?></generator>
    <managingEditor><?=$this_config['customer_service_email']?></managingEditor>
    <webMaster><?=$this_config['smtp_mail']?></webMaster> 

    <?php foreach ($products as $product): ?>
    <item>
      <title><?php echo $product['ProductI18n']['name']; ?></title>
      <link>http://<?=$_SERVER['SERVER_NAME']?><?=$this->webroot?>products/<?php echo $product['Product']['id']; ?></link>
      <description><?php echo $product['ProductI18n']['meta_description']; ?></description>
      <?php echo $product['Product']['created'] ?>
      <pubDate><?php echo $product['Product']['created'] ?></pubDate>
      <guid>http://<?=$_SERVER['SERVER_NAME']?><?=$this->webroot?>products/<?php echo $product['Product']['id']; ?></guid>
    </item>
    <?php endforeach; ?>
  </channel>
</rss>