<?php
/*****************************************************************************
 * SV-Cart 网站导航
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 984 2009-04-24 07:17:53Z zhangshisong $
*****************************************************************************/
?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo Router::url('/',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?php echo Router::url('/products/advancedsearch/SAD/all',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>    
    <url>
        <loc><?php echo Router::url('/sitemaps',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?php echo Router::url('/user/register',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>    
    <url>
        <loc><?php echo Router::url('/user/login',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>    
    <url>
        <loc><?php echo Router::url('/articles',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>  
    <url>
        <loc><?php echo Router::url('/topics',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>  
    <url>
        <loc><?php echo Router::url('/promotions',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>  
    
        
    <!-- Brand -->    
    <?php foreach ($brands as $brand):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'brands','action'=>'view','id'=>$brand['Brand']['id']),true); ?></loc>
        <lastmod><?php echo $time->toAtom($brand['Brand']['modified']); ?></lastmod>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>
    <!-- Articles Category -->    
    <?php foreach ($article_cat as $article_cat_info):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'category_articles','action'=>'view','id'=>$article_cat_info['Category']['id']),true); ?></loc>
        <lastmod><?php echo $time->toAtom($article_cat_info['Category']['modified']); ?></lastmod>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>

    <!-- Products Category -->    
    <?php foreach ($product_cat as $product_cat_info):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'categories','action'=>'view','id'=>$product_cat_info['Category']['id']),true); ?></loc>
        <lastmod><?php echo $time->toAtom($product_cat_info['Category']['modified']); ?></lastmod>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>    
    <!-- Products -->    
    <?php foreach ($products as $product):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'products','action'=>'view','id'=>$product['Product']['id']),true); ?></loc>
        <lastmod><?php echo $time->toAtom($product['Product']['modified']); ?></lastmod>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>       
    <!-- Articles -->    
    <?php foreach ($articles as $article):?>
    <url>
        <loc><?php echo Router::url(array('controller'=>'articles','action'=>'view','id'=>$article['Article']['id']),true); ?></loc>
        <lastmod><?php echo $time->toAtom($article['Article']['modified']); ?></lastmod>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>      
    
</urlset> 