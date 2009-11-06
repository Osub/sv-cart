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
 * $Id: article.php 4681 2009-09-28 09:16:46Z huangbo $
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
                      )   /*,
        				'ArticleCategory' =>array
												(
										          'className'     => 'ArticleCategory',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'article_id'
					                        	)*/
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
		'Article.id','ArticleI18n.meta_description',
		'Article.category_id','Article.file_url','ArticleI18n.title','Article.author_email','Article.created','Article.modified')));
		return $Lists;
	}
	
	//��������
	function findscroll($locale = ''){
		//	$cache_key = md5($this->name."_findscroll".'_'.$locale);
		
	//	$article_list = cache::read($cache_key);	
	//	if($article_list){
	//		return $article_list;
	//	}else{
			if($this->cacheFind($this->name,'findscroll_c'.$locale,array('locale'=>$locale))){
				$article_list = $this->cacheFind($this->name,'findscroll'.$locale,array('locale'=>$locale));
			}else{
				$conditions="Article.status ='1' and Article.importance in ('2','3')";
				$article_list=$this->find('all',array('conditions'=>array($conditions),'order'=>'Article.orderby asc','fields'=>array(
				'ArticleI18n.title')));
				$this->cacheSave($this->name,'findscroll_c'.$locale,array('locale'=>$locale),$article_list);
			}
			return $article_list;
	//	}
		
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


	function findcountassoc(){
		$lists=$this->find("all",array('fields' => array('id', 'count(*) as count'),"group"=>"id"));
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['ArticleCategory']['id']]=$v['0']['count'];
			}
		return $lists_formated;
	}
	//��չ����
    function handle_other_cat($article_id, $cat_list){
    	   //��ѯ���е���չ����
    	   $res=$this->findAll("ArticleCategory.article_id = ".$article_id."");
    	   $exist_list=array();
    	   foreach($res as $k=>$v){
    	   	    $exist_list[$k]=$v['ArticleCategory']['category_id'];
    	   }
    	   //ɾ�������еķ���
    	   $delete_list = array_diff($exist_list, $cat_list);
    	   if($delete_list){
    	   	      $condition=array("ArticleCategory.category_id"=>$delete_list,"ArticleCategory.article_id = ".$article_id."");
    	   	      $this->deleteAll($condition);
    	   }
    	   //����¼ӵķ���
    	   $add_list = array_diff($cat_list, $exist_list, array(0));
    	   foreach ($add_list AS $k=>$cat_id){
    	   	          $other_cat_info=array(
		                   'product_id'=>$product_id,
		                   'category_id'=>$add_list[$k]
		              );
		             $this->saveAll(array('ArticleCategory'=>$other_cat_info));
    	   }
       return true;
    }
    
    function find_indx_all($category_id,$locale){
		$params = array('order' => array('ArticleCategory.modified DESC'),
		    			'conditions' => array(" ArticleCategory.category_id in (".$category_id.")")
			   			);
		$article_categorys = $this->cache_find('all',$params,$this->name.$locale);	
		return $article_categorys;	    	
    	
    	//"all",array( "conditions" =>array(" ArticleCategory.category_id in (".$category_id.")"))
    }
/* <li class="center">&nbsp;</li>

	function ccStrLeft($str,$len) #����߽�ȡ��Ӣ�Ļ���ַ���
	{
	$ascLen=strlen($str); if($ascLen<=$len) return $str;
	$hasCC=ereg("[xA1-xFE]",$str);
	$hasAsc=ereg("[x01-xA0]",$str);
	if(!$hasCC) return substr($str,0,$len);
	if(!$hasAsc)
	if($len & 0��01)
	return substr($str,0,$len+$len-2);
	else
	return substr($str,0,$len+$len);
	$cind=0;$flag=0;$reallen=0;//ʵ��ȡ�ֽڳ�
	while($cind<$ascLen && $reallen<$len)
	{
	if(ord(substr($str,$cind,1))<0xA1){ //������ֽ�ΪӢ�� ���һ
	$cind++;
	}else{//���� ��2���ֽ�
	$cind+=2;
	}
	$reallen++;
	}
	return substr($str,0,$cind);
	}
	*/
	
function cutstr($string, $length, $dot = ' ...') {
	global $charset;
	$oldstr = strlen($string) ;
	if(strlen($string) <= $length) {
		return $string;
	}

	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	    if (function_exists('mb_substr'))
	    {
	        $string = mb_substr($string, 0, $length, 'utf-8');
	        $charset = 'utf-8';
	    }
	    elseif (function_exists('iconv_substr'))
	    {
	        $string = iconv_substr($string, 0, $length, 'utf-8');
	        $charset = 'utf-8';
	    }
	$strcut = '';
	if(strtolower($charset) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < strlen($string)) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}

	$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	if($oldstr > strlen($strcut)){
			return $strcut.$dot;
	}
	
	return $strcut;
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