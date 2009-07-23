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
 * $Id: view.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<?php   	
if(isset($sitemaps) && sizeof($sitemaps)>0 ){
	foreach($sitemaps as $key=>$v){ 
		if($v['Sitemap']['type']=="brands"){
			foreach($brands as $brand){ ?>
			<!-- 商品品牌 -->
			    <url>
			        <loc><?php echo Router::url(array('controller'=>$v['Sitemap']['url'],'action'=>'view','id'=>$brand['Brand']['id']),true); ?></loc>
			        <lastmod><?php echo $time->toAtom($brand['Brand']['modified']); ?></lastmod>
			        <priority><?php echo $v['Sitemap']['orderby']?></priority>
			    </url>
	<?php 		}
		}
		if($v['Sitemap']['type']=="articles"){
			foreach($article_cat as $article_cat_info){ ?>
				<!-- 文章分类 -->
				<url>
			        <loc><?php echo Router::url(array('controller'=>$v['Sitemap']['url'],'action'=>'view','id'=>$article_cat_info['Category']['id']),true); ?></loc>
			        <lastmod><?php echo $time->toAtom($article_cat_info['Category']['modified']); ?></lastmod>
			        <priority><?php echo $v['Sitemap']['orderby']?></priority>
			    </url>
	<?php 	}
		}		
		if($v['Sitemap']['type']=="product_cat"){
			foreach($product_cat as $product_cat_info){ ?>
			 <!-- 商品分类 -->
				<url>
					 <loc><?php echo Router::url(array('controller'=>$v['Sitemap']['url'],'action'=>'view','id'=>$product_cat_info['Category']['id']),true); ?></loc>
					 <lastmod><?php echo $time->toAtom($product_cat_info['Category']['modified']); ?></lastmod>
					 <priority><?php echo $v['Sitemap']['orderby']?></priority>
				</url>
	<?php 		}
			}			
		if($v['Sitemap']['type']=="products"){
					foreach($products as $product){ ?>
					<!-- 商品 -->
					    <url>
					        <loc>
					        <?php if($SVConfigs['use_sku'] == 1){?>
					        <?php echo Router::url(array('controller'=>$v['Sitemap']['url'],'action'=>'sku',$product['ProductI18n']['name'],$product['Product']['code']),true); ?>
					        <?php }else{?>
					        <?php echo Router::url(array('controller'=>$v['Sitemap']['url'],'action'=>'view','id'=>$product['Product']['id']),true); ?>
					        <?php }?>
					        </loc>
					        <lastmod><?php echo $time->toAtom($product['Product']['modified']); ?></lastmod>
					        <priority><?php echo $v['Sitemap']['orderby']?></priority>
					    </url>
	<?php 		}
		}			
		if($v['Sitemap']['type']=="articles"){
			foreach($articles as $article){ ?>
			 <!-- 文章 -->
				<url>
					 <loc><?php echo Router::url(array('controller'=>$v['Sitemap']['url'],'action'=>'view','id'=>$article['Article']['id']),true); ?></loc>
					 <lastmod><?php echo $time->toAtom($article['Article']['modified']); ?></lastmod>
					 <priority><?php echo $v['Sitemap']['orderby']?></priority>
				</url>
	<?php 		}
			}		
			
		else{	
	?>
	    <url>
	        <loc><?php echo Router::url($v['Sitemap']['url'],true); ?></loc>
	        <changefreq><?php echo $v['Sitemap']['cycle']; ?></changefreq>
	        <priority><?php echo $v['Sitemap']['orderby']; ?></priority>
	    </url>
<?php 	}}
}
?>
  
    
</urlset> 
