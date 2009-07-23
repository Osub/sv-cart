 <rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
     <link>http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $cart_webroot?></link>
    <title><?php echo $this_config['shop_name']?> - <?php echo $dynamic?></title>
    <description><?php echo $this_config['shop_description']?></description> 
    <pubDate> <?php echo date('Y-m-d H:i:s'); ?></pubDate>
    <guid>http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $cart_webroot?></guid>	
    <docs>http://<?php echo $_SERVER['HTTP_HOST']?><?php echo $cart_webroot?></docs>
    <generator><?php echo $this_config['shop_name']?></generator>
    <managingEditor><?php echo $this_config['customer_service_email']?></managingEditor>
    <webMaster><?php echo $this_config['smtp_mail']?></webMaster> 

    <?php foreach ($products as $product): ?>
    <item>
      <title><?php echo $product['ProductI18n']['name']; ?></title>
      <link>http://<?php echo $_SERVER['SERVER_NAME']?><?php echo $cart_webroot?>products/<?php echo $product['Product']['id']; ?></link>
      <description><?php echo htmlspecialchars($product['ProductI18n']['meta_description']); ?></description>
      <?php echo $product['Product']['created'] ?>
      <pubDate><?php echo $product['Product']['created'] ?></pubDate>
      <author></author>
      <guid>http://<?php echo $_SERVER['SERVER_NAME']?><?php echo $cart_webroot?>products/<?php echo $product['Product']['id']; ?></guid>
    </item>
    <?php endforeach; ?>
  </channel>
</rss>