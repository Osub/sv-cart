<?php
/*****************************************************************************
 * SV-Cart ��Ʒ����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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