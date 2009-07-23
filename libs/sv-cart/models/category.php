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
 * $Id: category.php 2952 2009-07-16 09:56:25Z huangbo $
*****************************************************************************/
class Category extends AppModel
{
	var $name = 'Category';
	var $cacheQueries = true;
	var $cacheAction = "1 day";	
	
	var $hasOne = array('CategoryI18n' =>   
                        array('className'    => 'CategoryI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,
                              'foreignKey'   => 'category_id'  
                        )
                  );
    var $actsAs = array('Tree');
	var $categories_parent_format=array();
	var $cat_navigate_format=array();
	var $all_subcat = array();
	var $allinfo =array();
	
	function set_locale($locale){
    	$conditions = " CategoryI18n.locale = '".$locale."'";
    	$this->hasOne['CategoryI18n']['conditions'] = $conditions;
    }

	function tree($type='P',$category_id = 0,$locale=''){
		
		$cache_key = md5($this->name.'_'.$type.'_'.$category_id.'_'.$locale);
		$this->allinfo = cache::read($cache_key);	
		if($this->allinfo){
			return $this->allinfo;
		}else{
			$this->categories_parent_format=array();
			$this->cat_navigate_format=array();
			$this->all_subcat = array();
			$this->allinfo =array();
		//	$lists=$this->findall("status ='1' AND type='".$type."' ",'','orderby asc');
			$lists=$this->find('all',array('order'=>'orderby asc',
			'fields' =>	array('Category.id','Category.parent_id','Category.type','Category.img01','CategoryI18n.name',
																		'Category.link','Category.modified','Category.created'
																					),			
				'conditions'=>array("status ='1' AND type='".$type."' ")));
			
		//	pr($lists);
			$lists_formated = array();
		//	pr($lists);  ȫ���ķ���
			if(is_array($lists)){
				foreach($lists as $k => $v){
					$lists_formated[$v['Category']['id']]=$v;
				}
			//	pr($lists_formated); ��ʽ��ΪIDΪ��
				$this->allinfo['assoc']=$lists_formated;
				
				foreach($lists as $k=>$v){
					$this->categories_parent_format[$v['Category']['parent_id']][]=$v;
				}
			//	pr($this->categories_parent_format); //��ʽ��Ϊ��parent_idΪ��
				$this->allinfo['tree']=$this->subcat_get(0);
				$this->allinfo['subids']=$this->all_subcat;
				
				cache::write($cache_key,$this->allinfo);
				return $this->allinfo;
			}
		}
	}
	
	function subcat_get($category_id){
		$subcat=array();
		if(isset($this->categories_parent_format[$category_id]) && is_array($this->categories_parent_format[$category_id])) //�ж�parent_id = 0 ������
			foreach($this->categories_parent_format[$category_id] as $k=>$v)
			{
				$category=$v; //parent_id Ϊ 0 ������
				if(isset($this->categories_parent_format[$v['Category']['id']]) && is_array($this->categories_parent_format[$v['Category']['id']]))
				{
					$category['SubCategory']=$this->subcat_get($v['Category']['id']);
				}
				
				$subcat[$k]=$category;
			//	pr($subcat); //parent_id Ϊ 0 ������
								
				$this->all_subcat[$v['Category']['id']][]=$v['Category']['id'];
				
				if(isset($this->all_subcat[$v['Category']['parent_id']]))
					$this->all_subcat[$v['Category']['parent_id']]= array_merge($this->all_subcat[$v['Category']['parent_id']],$this->all_subcat[$v['Category']['id']]);
				else
					$this->all_subcat[$v['Category']['parent_id']] = $this->all_subcat[$v['Category']['id']];
				
			//	pr($this->all_subcat);  ??
			}
		return $subcat;
	}
	
	function get_navigation($id){
		$navigations_list=array();
		$navigations = array();
		$navigations_info = array();
		foreach($this->allinfo['subids'] as $k=> $v){
			if($k !=0 && in_array($id,$v)){
				$navigations[sizeof($v)]=$k;
			}
		}
		krsort($navigations);
		$navigations=array_values($navigations);
		foreach($navigations as $k => $v){
			$navigations_info[$k]=$this->allinfo['assoc'][$v];
		}
		return $navigations_info;
	}
	
//class_end
	//hobby 20081117 ȡ��id=>name������
	function findassoc($locale =''){
		$condition=" Category.status ='1' ";
		$orderby = " orderby asc ";
		$cache_key = md5($this->name.'_'.$locale);
		
		$lists_formated = cache::read($cache_key);	
		if($lists_formated){
			return $lists_formated;
		}else{
		$lists=$this->findall($condition,'',$orderby);
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['Category']['id']]=$v;
			}
		cache::write($cache_key,$lists_formated);
		return $lists_formated;
		}
	}
	
	function find_all($locale){
		$params = array('order' => array('Category.modified DESC'),
			'fields' =>	array('Category.id','Category.parent_id','Category.type','Category.img01','CategoryI18n.name',
																		'Category.link','Category.modified','Category.created'
																					),			
			
		    			'conditions' => array("Category.status" => 1)
			   			);
		$article_categorys = $this->cache_find('all',$params,$this->name.$locale);
		$article_categorys_list = array();			
		if(sizeof($article_categorys)>0){
			foreach($article_categorys as $k=>$v){
				$article_categorys_list[$v['Category']['id']] = $v;
			}
		}
		
		return $article_categorys_list;		
		
	}
	
	function home_category($locale){
			$params = array('order' => array('Category.orderby DESC'),
			'fields' =>	array('Category.id','Category.parent_id','Category.type','Category.img01','CategoryI18n.name',
																		'Category.link','Category.modified','Category.created'
																					),			
				
		    			'conditions' => array("Category.status" => 1,"Category.type" => "P","Category.parent_id"=>0)
			   			);
		$home_categorys = $this->cache_find('all',$params,$this->name.$locale."home_category");
		$home_categorys_list = array();			
		if(sizeof($home_categorys)>0){
			foreach($home_categorys as $k=>$v){
				$home_categorys_list[$v['Category']['id']] = $v;
			}
		}
		
		return $home_categorys_list;		
	
	}
	

}
?>