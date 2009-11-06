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
 * $Id: brand.php 5101 2009-10-15 11:23:51Z huangbo $
*****************************************************************************/
class Brand extends AppModel
{
	var $name = 'Brand';
	var $cacheQueries = true;
	var $cacheAction = "1 day";
	
	var $hasOne = array('BrandI18n' =>   
                        array('className'    => 'BrandI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'brand_id'  
                        )   
                  );
    

	function set_locale($locale){
    	$conditions = " BrandI18n.locale = '".$locale."'";
    	$this->hasOne['BrandI18n']['conditions'] = $conditions;
        
    }
	
	//hobby 20081117 ȡ��id=>name������
	function findassoc($locale =''){
		$condition=" Brand.status ='1' ";
		$orderby = " orderby asc ";
		$cache_key = md5($this->name.'_'.$locale);
		
		$lists_formated = cache::read($cache_key);	
		if($lists_formated){
			return $lists_formated;
		}else{
		
		
		
//		$lists=$this->findall($condition,'',$orderby);
		$lists=$this->find('all',array('order'=>array($orderby,'BrandI18n.name asc'),
			'fields' =>	array('Brand.id','Brand.flash_config','Brand.url','Brand.img01','BrandI18n.img01','BrandI18n.name'
																	
																					),			
		
		'conditions'=>array($condition)));
		
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['Brand']['id']]=$v;
			}
			
		cache::write($cache_key,$lists_formated);
		return $lists_formated;
		}
	}
	
}
?>