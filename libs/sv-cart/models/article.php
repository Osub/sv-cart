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
 * $Id: article.php 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
class Article extends AppModel
{
	var $name = 'Article';
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
		$Lists=$this->findAll($conditions,'','Article.orderby asc');
		return $Lists;
	}
	
	//��������
	function findscroll(){
		$conditions="Article.status ='1' and Article.importance in ('2','3')";
		return $this->findAll($conditions,'','Article.orderby asc');
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