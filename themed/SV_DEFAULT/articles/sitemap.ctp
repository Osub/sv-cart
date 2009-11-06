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
 * $Id: sitemap.ctp 4075 2009-09-04 10:45:22Z shenyunfeng $
*****************************************************************************/
?>
<?php echo $xml->header(); ?>	
	<?php echo "<?xml-stylesheet type='text/xsl' href='".$server_host.$cart_webroot."img/sitemap.xsl' ?>";?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
if(isset($sitemaps) && sizeof($sitemaps)>0 ){
	foreach($sitemaps as $key=>$v){ ?>
	<?php 	
		if($v['Sitemap']['type']=="articles"){
			foreach($article_cat as $article_cat_info){ ?>
				<!-- 文章分类 -->
			 <?php if(isset($languages) && sizeof($languages)>0){?>
			 	 <?php foreach($languages as $a=>$b){?>
				<url>
			        <loc><?php echo Router::url(array('controller'=>$v['Sitemap']['url'],'action'=>'category','id'=>$article_cat_info['Category']['id'],$b['Language']['locale']),true); ?></loc>
			        <lastmod><?php echo $time->toAtom($article_cat_info['Category']['modified']); ?></lastmod>
			        <changefreq><?php echo $v['Sitemap']['cycle']?></changefreq>
			        <priority><?php echo $v['Sitemap']['orderby']?></priority>
			    </url>
			    <?php }}?>
	<?php 	}
		}	?>

	<?php 				
		if($v['Sitemap']['type']=="articles"){
			foreach($articles as $article){ ?>
			 <!-- 文章 -->
			 <?php if(isset($languages) && sizeof($languages)>0){?>
			 	 <?php foreach($languages as $a=>$b){?>
				<url>
					 <loc><?php echo Router::url(array('controller'=>$v['Sitemap']['url'],'action'=>'view','id'=>$article['Article']['id'],$b['Language']['locale'],URLEncode($article['ArticleI18n']['title'])),true); ?></loc>
					 <lastmod><?php echo $time->toAtom($article['Article']['modified']); ?></lastmod>
			         <changefreq><?php echo $v['Sitemap']['cycle']?></changefreq>
					 <priority><?php echo $v['Sitemap']['orderby']?></priority>
				</url>
				<?php }?>
			  <?php }?>
	<?php 		}
			}		
	?>

<?php 	}
}
?>
  
    
</urlset> 
