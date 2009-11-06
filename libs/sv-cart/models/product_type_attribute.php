<?php
/*****************************************************************************
 * SV-Cart 多语言
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: product_type_attribute.php 5527 2009-11-05 02:07:24Z huangbo $
*****************************************************************************/
class ProductTypeAttribute extends AppModel{
	var $name = 'ProductTypeAttribute';
	var $hasOne = array('ProductTypeAttributeI18n' =>   
                        array('className'    => 'ProductTypeAttributeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'product_type_attribute_id'  
                        )/*,
        				'ProductAttribute' =>
        				array('className'    => 'ProductAttribute', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'product_type_attribute_id'  
                        )*/
                  );

    function set_locale($locale){
    	$conditions = " ProductTypeAttributeI18n.locale = '".$locale."'";
    	$this->hasOne['ProductTypeAttributeI18n']['conditions'] = $conditions;
        
    }
    function findassoc(){
		$condition="ProductTypeAttribute.status ='1'";
		
		$lists=$this->findAll($condition);
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['ProductTypeAttribute']['id']]=$v;
				$lists_formated[$v['ProductTypeAttribute']['id']]['ProductTypeAttribute']['name']='';
				   foreach($lists_formated[$v['ProductTypeAttribute']['id']]['ProductTypeAttributeI18n'] as $key=>$val){
				 	     $lists_formated[$v['ProductTypeAttribute']['id']]['ProductTypeAttribute']['name'] .=$val['name'] . " | ";
				   }
			}
		
		return $lists_formated;
	}
	
	 function get_list($category_id){
		$Lists = array();
		$condition="ProductTypeAttribute.status ='1'";
		if($category_id!=''){
			$condition.= " AND ProductTypeAttribute.id in (".$category_id.")";
		}

		$Lists=$this->findAll($condition,'','orderby asc');
		return $Lists;
	}
	
	function find_all_att($locale){
		$params = array('order' => 'ProductTypeAttribute.orderby,ProductTypeAttribute.id desc',
		    			'conditions' => array('ProductTypeAttribute.status' => 1)
			   			);
		$Lists = $this->cache_find('all',$params,$this->name.$locale);	
		$product_type_atts = array();
		if(is_array($Lists) && sizeof($Lists)>0){
			foreach($Lists as $k=>$v){
				$product_type_atts[$v['ProductTypeAttribute']['id']] = $v;
			}
		}
		return $product_type_atts;
	}
	
	function find_product_att($locale,$product_type_id){
		$params = array('order' => 'ProductTypeAttribute.orderby,ProductTypeAttribute.id desc',
		    			'conditions' => array('ProductTypeAttribute.status' => 1,'product_type_id'=>$product_type_id)
			   			);
		$Lists = $this->cache_find('all',$params,$this->name.$locale);	
		$product_type_atts = array();
		if(is_array($Lists) && sizeof($Lists)>0){
			foreach($Lists as $k=>$v){
				$product_type_atts[$v['ProductTypeAttribute']['id']] = $v;
			}
		}
		return $product_type_atts;
	}
	
}
?>