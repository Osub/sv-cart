 <rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
     <link>http://<?=$_SERVER['HTTP_HOST']?><?=$this->webroot?></link>
    <title><?=$this_config['shop_name']?> - <?=$dynamic?></title>
    <description><?=$this_config['shop_description']?></description> 
    <pubDate> <?php echo date('Y-m-d H:i:s'); ?></pubDate>
    <guid>http://<?=$_SERVER['HTTP_HOST']?><?=$this->webroot?></guid>	
    <docs>http://<?=$_SERVER['HTTP_HOST']?><?=$this->webroot?></docs>
    <generator><?=$this_config['shop_name']?></generator>
    <managingEditor><?=$this_config['customer_service_email']?></managingEditor>
    <webMaster><?=$this_config['smtp_mail']?></webMaster> 

    <?php foreach ($products as $product): ?>
    <item>
      <title><?php echo $product['ProductI18n']['name']; ?></title>
      <link>http://<?=$_SERVER['SERVER_NAME']?><?=$this->webroot?>products/<?php echo $product['Product']['id']; ?></link>
      <description><?php echo htmlspecialchars($product['ProductI18n']['meta_description']); ?></description>
      <?php echo $product['Product']['created'] ?>
      <pubDate><?php echo $product['Product']['created'] ?></pubDate>
      <author></author>
      <guid>http://<?=$_SERVER['SERVER_NAME']?><?=$this->webroot?>products/<?php echo $product['Product']['id']; ?></guid>
    </item>
    <?php endforeach; ?>
  </channel>
</rss>