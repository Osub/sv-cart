<?php
/*****************************************************************************
 * SV-Cart ����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: comment.php 2304 2009-06-26 07:00:53Z zhengli $
*****************************************************************************/
class Comment extends AppModel
{
	var $name = 'Comment';
/*	var $hasOne = array('Product' =>   
                        array('className'    => 'Product',  
                              'conditions' =>"Product.id = Comment.type_id and Comment.type = 'P'",
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => ''  
                        ),
     				   'ProductI18n' =>   
                        array('className'    => 'ProductI18n',  
                              'conditions' =>"Product.id = ProductI18n.product_id and Comment.type = 'P'",
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => ''  
                        ),
	        			'Article' =>   
	                        array('className'    => 'Article',  
	                              'conditions' =>"Article.id = Comment.type_id and Comment.type = 'A'",
	                              'order'        => '',   
	                              'dependent'    =>  true,   
	                              'foreignKey'   => ''  
	                        ),
	        			'ArticleI18n' =>   
	                        array('className'    => 'ArticleI18n',  
	                              'conditions' =>"Article.id = ArticleI18n.article_id and Comment.type = 'A'",
	                              'order'        => '',   
	                              'dependent'    =>  true,   
	                              'foreignKey'   => ''  
	                        )	    
	    
                  );

	function set_locale($locale){
    	$conditions = " ProductI18n.locale = '".$locale."'";
    	$this->hasOne['ProductI18n']['conditions'] = $conditions;
    	$conditions = " ArticleI18n.locale = '".$locale."'";
    	$this->hasOne['ArticleI18n']['conditions'] = $conditions;
        
    }
*/


}
?>