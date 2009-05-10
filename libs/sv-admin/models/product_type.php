<?php
/*****************************************************************************
 * SV-Cart ��Ʒ����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: product_type.php 1250 2009-05-07 13:59:20Z huangbo $
*****************************************************************************/
class ProductType extends AppModel
{
	var $name = 'ProductType';
	var $hasMany = array('ProductTypeI18n'=>
						array('className'  => 'ProductTypeI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'type_id'							
						),
						'ProductTypeAttribute'=>
						array('className'  => 'ProductTypeAttribute',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'product_type_id'							
						)
					);
	
    function set_locale($locale){
    	$conditions = " ProductTypeI18n.locale = '".$locale."'";
    	$this->hasOne['ProductTypeI18n']['conditions'] = $conditions;
        
    }	
	
	
	function gettypeformat($id=0){
		if($id == 0){
			$condition="";
		}
		else{
			$condition="ProductType.id = '".$id."' ";
		}
		
		$lists=$this->findAll($condition);

		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				 $lists_formated[$k]['ProductType']['name']='';
				 foreach($v['ProductTypeI18n'] as $key=>$val){
				 	  $lists_formated[$k]['ProductType']['name'] =$val['name'] ;
				 	  $lists_formated[$k]['ProductType']['id'] =$val['type_id'];
				 }
			}
		//pr($lists_formated);
		return $lists_formated;
	}

}
?>