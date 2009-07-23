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
 * $Id: article.php 2304 2009-06-26 07:00:53Z zhengli $
*****************************************************************************/
class Article extends AppModel
{
	var $name = 'Article';
	var $hasOne = array('ArticleI18n' =>   
                        array('className'    => 'ArticleI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'article_id'
                        )
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
		$List=$this->findall($conditions,""," Article.clicked desc",$number);
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
		$Lists=$this->findAll($conditions,'','orderby asc');
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
	
}
?>