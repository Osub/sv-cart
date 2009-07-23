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
 * $Id: article.php 2907 2009-07-15 11:04:21Z shenyunfeng $
*****************************************************************************/
class Article extends AppModel
{
	var $name = 'Article';
	var $cacheQueries = true;
	var $cacheAction = "1 day";
	
	
	var $hasOne = array('ArticleI18n' =>   
                      array('className'    => 'ArticleI18n', 
        					 'conditions' => '',   
                             'order'        => '',   
                             'dependent'    =>  true,   
                           'foreignKey'   => 'article_id'  
                      )   ,
        				'ArticleCategory' =>array
												(
										          'className'     => 'ArticleCategory',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'article_id'
					                        	),
                 ); 
	
	function set_locale($locale){
    	$conditions = "ArticleI18n.locale = '".$locale."'";
    	$this->hasOne['ArticleI18n']['conditions'] = $conditions;
        
    }
//��������    
    function hot_list($number,$type){
    	$List=array();
    	$conditions=" status ='1' ";
    	if($type){
    	$conditions.=" AND type=$type ";	
    	}
		$List=$this->find('all',array('order'=>array('Article.clicked desc'),
				'fields' =>	array('Article.id',
								'Article.category_id','Article.modified','Article.created',
								'ArticleI18n.title'),
			
		'conditions'=>array($conditions),'limit'=>$number));
		
	//	pr($List);
		return $List;
	}
    
/*
�����б�
*/    
    function get_list($articles_id,$store_id=''){
		$Lists = array();
		$conditions="Article.status ='1'";
		if($articles_id!=''){
			$conditions.= " AND Article.id in (".$articles_id.")";
		}
		if($store_id!=''){
			$conditions.=" AND Article.store_id='".$store_id."'";
		}
		$Lists=$this->find('all',array('conditions'=>array($conditions),'order'=>'Article.orderby asc','fields'=>array(
		'Article.id',
		'Article.category_id','Article.file_url','ArticleI18n.title','Article.author_email','Article.created','Article.modified')));
		return $Lists;
	}
	
	//��������
	function findscroll($locale = ''){
		$cache_key = md5($this->name.'_'.$locale);
		
		$article_list = cache::read($cache_key);	
		if($article_list){
			return $article_list;
		}else{
		$conditions="Article.status ='1' and Article.importance in ('2','3')";
		$article_list =  $this->findAll($conditions,'','Article.orderby asc');
		cache::write($cache_key,$article_list);
		return $article_list;
		}
		
	}
	
	function find_home_article($locale){
		$cache_key = md5($this->name.'_'.$locale.'_'.'find_home_article');
		$home_article = cache::read($cache_key);	
		if($home_article){
			return $home_article;
		}else{
		$home_article = $this->find_home_article('all',array('order' => array('Article.modified DESC'),
	    												'conditions' => array('Article.status'=>'1',
	    																	'Article.front' => '1'
	    																		),
	    												'limit' => 10
	    												));
			cache::write($cache_key,$home_article);
	    	return $home_article;
	    }
	}
	
	function sub_str($str, $length = 0, $append = true)
	{
	    $str = trim($str);
	    $strlength = strlen($str);

	    if ($length == 0 || $length >= $strlength)
	    {
	        return $str;
	    }
	    elseif ($length < 0)
	    {
	        $length = $strlength + $length;
	        if ($length < 0)
	        {
	            $length = $strlength;
	        }
	    }

	    if (function_exists('mb_substr'))
	    {
	        $newstr = mb_substr($str, 0, $length, 'utf-8');
	    }
	    elseif (function_exists('iconv_substr'))
	    {
	        $newstr = iconv_substr($str, 0, $length, 'utf-8');
	    }
	    else
	    {
	        //$newstr = trim_right(substr($str, 0, $length));
	        $newstr = substr($str, 0, $length);
	    }

	    if ($append && $str != $newstr)
	    {
	        $newstr .= '...';
	    }
	    return $newstr;
	}
	
}
?>