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
 * $Id: brand.php 1608 2009-05-21 02:50:04Z huangbo $
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
    

	function set_locale($locale){
    	$conditions = " BrandI18n.locale = '".$locale."'";
    	$this->hasOne['BrandI18n']['conditions'] = $conditions;
        
    }
	
	//hobby 20081117 ȡ��id=>name������
	function findassoc(){
		$condition=" Brand.status ='1' ";
		$orderby = " orderby asc ";
		$lists=$this->findall($condition,'',$orderby);
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['Brand']['id']]=$v;
			}
		
		return $lists_formated;
	}
	
}
?>