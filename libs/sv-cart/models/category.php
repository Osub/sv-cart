<?php
/*****************************************************************************
 * SV-Cart 分类
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: category.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Category extends AppModel
{
	var $name = 'Category';
	var $hasOne = array('CategoryI18n' =>   
                        array('className'    => 'CategoryI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,
                              'foreignKey'   => 'Category_id'  
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

	function tree($type='P',$category_id = 0){
		$this->categories_parent_format=array();
		$this->cat_navigate_format=array();
		$this->all_subcat = array();
		$this->allinfo =array();
		$lists=$this->findall("status ='1' AND type='".$type."' ",'','orderby asc');
		$lists_formated = array();
	//	pr($lists);  全部的分类
		if(is_array($lists)){
			foreach($lists as $k => $v){
				$lists_formated[$v['Category']['id']]=$v;
			}
		//	pr($lists_formated); 格式化为ID为序
			$this->allinfo['assoc']=$lists_formated;
			
			foreach($lists as $k=>$v){
				$this->categories_parent_format[$v['Category']['parent_id']][]=$v;
			}
		//	pr($this->categories_parent_format); //格式化为以parent_id为序
			$this->allinfo['tree']=$this->subcat_get(0);
			$this->allinfo['subids']=$this->all_subcat;
			return $this->allinfo;
		}
	}
	
	function subcat_get($category_id){
		$subcat=array();
		if(isset($this->categories_parent_format[$category_id]) && is_array($this->categories_parent_format[$category_id])) //判断parent_id = 0 的数据
			foreach($this->categories_parent_format[$category_id] as $k=>$v)
			{
				$category=$v; //parent_id 为 0 的数据
				if(isset($this->categories_parent_format[$v['Category']['id']]) && is_array($this->categories_parent_format[$v['Category']['id']]))
				{
					$category['SubCategory']=$this->subcat_get($v['Category']['id']);
				}
				
				$subcat[$k]=$category;
			//	pr($subcat); //parent_id 为 0 的数据
								
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
	//hobby 20081117 取得id=>name的数组
	function findassoc(){
		$condition=" Category.status ='1' ";
		$orderby = " orderby asc ";
		$lists=$this->findall($condition,'',$orderby);
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['Category']['id']]=$v;
			}
		
		return $lists_formated;
	}
	

}
?>