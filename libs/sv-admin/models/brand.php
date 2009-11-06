<?php
/*****************************************************************************
 * SV-Cart Ʒ��
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: brand.php 5203 2009-10-20 07:21:12Z huangbo $
*****************************************************************************/
class Brand extends AppModel
{
	var $name = 'Brand';

	var $hasOne = array('BrandI18n' =>   
                        array('className'    => 'BrandI18n', 
                              'conditions'    =>  '',
                              'order'        => '',
                              'dependent'    =>  true,
                              'foreignKey'   => 'brand_id'
                        )
                  );
    	function set_locale($locale){
    	$conditions = " BrandI18n.locale = '".$locale."'";
    	$this->hasOne['BrandI18n']['conditions'] = $conditions;
        
    }
	//Ʒ������ṹ����
    function localeformat($id){
		$lists=$this->findAll("Brand.id = '".$id."'");
		foreach($lists as $k => $v){
				 $lists_formated['Brand']=$v['Brand'];
				 $lists_formated['BrandI18n'][]=$v['BrandI18n'];
				 foreach($lists_formated['BrandI18n'] as $key=>$val){
				 	  $lists_formated['BrandI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
	
	
	function getbrandformat_test(){
			$lists=$this->find("all",array("fields"=>array("Brand.id,BrandI18n.name,BrandI18n.locale")));
			return $lists;
	}
	function getbrandformat(){
		$lists=$this->find("all",array("fields"=>array("Brand.id,BrandI18n.name,BrandI18n.locale"),"order"=>"Brand.orderby asc,BrandI18n.name asc"));
		return $lists;
	}


}
?>