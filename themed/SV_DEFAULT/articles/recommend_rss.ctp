<?php
   $this->set('documentData', array(
        'xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));

    $this->set('channelData', array(
        'title' => $this_config['shop_name']."-".$dynamic,
        'link' => $html->url('/', true),
        'description' => $this_config['shop_description'],
        'language' => $this_locale));

    foreach ($articles as $article) {
        $postTime = strtotime($article['Article']['created']);
 
        $postLink = $this_url."articles/".$article['Article']['id'];
        // You should import Sanitize
        App::import('Sanitize');
        // This is the part where we clean the body text for output as the description 
        // of the rss item, this needs to have only text to make sure the feed validates
        $bodyText = preg_replace('=\(.*?\)=is', '', $article['ArticleI18n']['content']);
        $bodyText = $text->stripLinks($bodyText);
        $bodyText = Sanitize::stripAll($bodyText);
        $bodyText = $text->truncate($bodyText, 400, '...', true, true);
 
        echo  $rss->item(array(), array(
            'title' => $article['ArticleI18n']['title'],
            'link' => $postLink,
            'guid' => array('url' => $postLink, 'isPermaLink' => 'true'),
            'description' =>  $bodyText,
            'dc:creator' => $article['Article']['author_email'],
            'pubDate' => $article['Article']['created']));
    }
?>