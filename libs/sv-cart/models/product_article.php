<?php
/*****************************************************************************
 * SV-Cart 商品文章
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: product_article.php 2863 2009-07-15 04:57:00Z shenyunfeng $
*****************************************************************************/
class ProductArticle extends AppModel
{
	var $name = 'ProductArticle';
    var $belongsTo = array(
        'Article' => array(
            'className'    => 'Article',
            'foreignKey'    => 'article_id'
        )
    );
    function find_product_article($id,$locale){
		$params = array('order' => array('ProductArticle.modified DESC'),
		//	'fields' =>	array('ProductArticle.id','ProductArticle.article_id','ProductArticle.product_id','ProductArticle.is_double'
				//					,'Article.id','Article.category_id'),			
		    			'conditions' => array(" ProductArticle.article_id= ".$id)
			   			);
		$article_categorys = $this->cache_find('all',$params,$this->name.$locale);	
	//	pr($article_categorys);		
		return $article_categorys;
    }
    
}
?>