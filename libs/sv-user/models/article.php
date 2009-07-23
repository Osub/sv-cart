<?php
/*****************************************************************************
 * SV-Cart 文章
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
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
//热门文章    
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
文章列表
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
	
	//滚动文章
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