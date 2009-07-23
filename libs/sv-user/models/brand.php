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
 * $Id: brand.php 2304 2009-06-26 07:00:53Z zhengli $
*****************************************************************************/
class Brand extends AppModel
{
	var $name = 'Brand';
	var $hasOne = array('BrandI18n' =>   
                        array('className'    => 'BrandI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'brand_id'  
                        )   
                  );
    
    //��flash_images ����ȡ�ø�Ʒ�Ƶ�flash����
/*   	var $hasMany = array('FlashImage' =>   
                        array('className'    => 'FlashImage', 
                              'conditions'    =>  'FlashImage.type="B"',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'type_id'  
                        )
                  );
*/
    
function set_locale($locale){
    	$conditions = " BrandI18n.locale = '".$locale."'";
    	$this->hasOne['BrandI18n']['conditions'] = $conditions;
        
    }
//Ʒ���б�
	function getlist(){
		$Brands_type = array();
		$condition = "status ='1'";
		$Brands=$this->findAll($condition,'','orderby asc');
		return $Brands;
	}
	
//Ʒ����ϸ		
    function get_detail($id){
		$Brands=$this->findbyid($id);
		return $Brands;
	}
	
	function findassoc($locale =''){
		$condition=" Brand.status ='1' ";
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
				$lists_formated[$v['Brand']['id']]=$v;
			}
			
		cache::write($cache_key,$lists_formated);
		return $lists_formated;
		}
	}
	
}
?>