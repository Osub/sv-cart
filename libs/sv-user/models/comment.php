<?php
/*****************************************************************************
 * SV-Cart 评论
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
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