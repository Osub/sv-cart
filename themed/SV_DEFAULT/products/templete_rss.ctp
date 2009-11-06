<?php
   $this->set('documentData', array(
        'xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));

    $this->set('channelData', array(
        'title' => $this_config['shop_name']."-".$dynamic,
        'link' => $html->url('/', true),
        'description' => $this_config['shop_description'],
        'language' => $this_locale));

    foreach ($products as $product) {
        $postTime = strtotime($product['Product']['created']);
 
        $postLink = $this_url."products/".$product['Product']['id'];
        // You should import Sanitize
        App::import('Sanitize');
        // This is the part where we clean the body text for output as the description 
        // of the rss item, this needs to have only text to make sure the feed validates
        $bodyText = preg_replace('=\(.*?\)=is', '', $product['ProductI18n']['description']);
        $bodyText = $text->stripLinks($bodyText);
        $bodyText = Sanitize::stripAll($bodyText);
        $bodyText = $text->truncate($bodyText, 400, '...', true, true);
 
        echo  $rss->item(array(), array(
            'title' => $product['ProductI18n']['name'],
            'link' => $postLink,
            'guid' => array('url' => $postLink, 'isPermaLink' => 'true'),
            'description' =>  $bodyText,
            'img_thumb'=>$this_url.$product['Product']['img_thumb'],
            'shop_price'=>$product['Product']['shop_price'],
            'pubDate' => $product['Product']['created']));
    }
?>