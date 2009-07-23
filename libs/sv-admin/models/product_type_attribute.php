<?php
/*****************************************************************************
 * SV-Cart ������
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: product_type_attribute.php 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
class ProductTypeAttribute extends AppModel{
	var $name = 'ProductTypeAttribute';
	var $hasOne = array('ProductTypeAttributeI18n' =>   
                        array('className'    => 'ProductTypeAttributeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'product_type_attribute_id'  
                        ),
        				'ProductAttribute' =>
        				array('className'    => 'ProductAttribute', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'product_type_attribute_id'  
                        )
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
}
?>