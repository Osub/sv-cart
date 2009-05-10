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
 * $Id: brand.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Brand extends AppModel
{
	var $name = 'Brand';
	var $hasOne = array('BrandI18n' =>   
                        array('className'    => 'BrandI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'Brand_id'  
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
	
	function findassoc(){
		$condition="Brand.status ='1'";
		
		$lists=$this->findAll($condition);
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['Brand']['id']]=$v;
			}
		
		return $lists_formated;
	}
	
}
?>