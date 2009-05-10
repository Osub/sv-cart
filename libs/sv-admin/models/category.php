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
                              'conditions'    =>  '',
                              'order'        => 'locale desc',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'Category_id'  
                        )
                  );


    function set_locale($locale){
    	$conditions = " CategoryI18n.locale = '".$locale."'";
    	$this->hasOne['CategoryI18n']['conditions'] = $conditions;
        
    }

	var $categories_parent_format=array();
	var $cat_navigate_format=array();
	
	function tree($type,$locale){ 
	    $this->set_locale($locale);
		$conditions =" type='".$type."'";
		$categories=$this->findAll($conditions,'','Category.parent_id,Category.orderby,Category.id');
		
		if(is_array($categories))
			foreach($categories as $k=>$v)
			{
				/*$v['Category']['name']="";
				if(is_array($v['CategoryI18n'])){
					//pr($v['CategoryI18n']);
					foreach( $v['CategoryI18n'] as $kci => $vci){
						$v['Category']['name'] .=$vci['name'] . " | ";
					}
				}*/
				$this->categories_parent_format[$v['Category']['parent_id']][]=$v;
			}
		//pr($this->categories_parent_format);
		return $this->subcat_get(0);
	}
	
	
	function subcat_get($category_id){
		$subcat=array();
		if(isset($this->categories_parent_format[$category_id]) && is_array($this->categories_parent_format[$category_id]))
			foreach($this->categories_parent_format[$category_id] as $k=>$v)
			{

				$category=$v;
				if(isset($this->categories_parent_format[$v['Category']['id']]) && is_array($this->categories_parent_format[$v['Category']['id']]) )
				{
					$category['SubCategory']=$this->subcat_get($v['Category']['id']);
				}
				else{
					
				}
				$subcat[$k]=$category;
			}
		return $subcat;
	}
	
	//hobby@20081120 
/*	function localeformat($id){
		
		$info=$this->findbyid($id);
		if(is_array($info['CategoryI18n']))
			foreach($info['CategoryI18n'] as $k => $v){
				$info['CategoryI18n'][$v['locale']]=$v;
			}
	//	pr($info);
		return $info;
	}*/
	
	//ṹ
    function localeformat($id){
		$lists=$this->findAll("Category.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Category']=$v['Category'];
				 $lists_formated['CategoryI18n'][]=$v['CategoryI18n'];
				 foreach($lists_formated['CategoryI18n'] as $key=>$val){
				 	  $lists_formated['CategoryI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
	
	

	function findAssocs($type){
	
		$conditions =" type='".$type."'";
		$categories=$this->findAll($conditions,'','Category.parent_id,Category.orderby,Category.id');
		if(is_array($categories)){
			$data = array();
			foreach($categories as $k=>$v){
				$categoryname = '';
				if(is_array($v['CategoryI18n'])){
					//pr($v['CategoryI18n']);
					//foreach( $v['CategoryI18n'] as $kci => $vci){
						$categoryname =$v['CategoryI18n']['name'];
						
					//}
				}
				$data[$v['Category']['id']] = $categoryname;
			}
		}
		return $data;
	}
	function findAssoc($type){ 
		$data = "";
		$conditions =" type='".$type."'";
		$categories=$this->findAll($conditions,'','Category.parent_id,Category.orderby,Category.id');
		
		if(is_array($categories)){
			foreach($categories as $k=>$v){
				$categoryname = '';
				if(is_array($v['CategoryI18n'])){
					//pr($v['CategoryI18n']);
					//foreach( $v['CategoryI18n'] as $kci => $vci){
						$categoryname =$v['CategoryI18n']['name'];
						
					//}
				}
				
				$data[$v['Category']['id']] = "|--".$categoryname;
				for($i=0;$i<=$v['Category']['parent_id']-1;$i++){
					$data[$v['Category']['id']] ="&nbsp&nbsp&nbsp".$data[$v['Category']['id']];
				}
			}
		}
		return $data;
	}
function getbrandformat(){
		$condition=" Category.type = 'A'";
		$lists=$this->findAll($condition);
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				 $lists_formated[$v['Category']['id']]['Category']=$v['Category'];
				 $lists_formated[$v['Category']['id']]['CategoryI18n']=$v['CategoryI18n'];
				 /*$lists_formated[$v['Category']['id']]['Category']['name']='';
				 foreach($lists_formated[$v['Category']['id']]['CategoryI18n'] as $key=>$val){
				 	  $lists_formated[$v['Category']['id']]['Category']['name'] .=$val['name'] . " | ";
				 }*/
			}
		//pr($lists_formated);
		return $lists_formated;
}

}
?>