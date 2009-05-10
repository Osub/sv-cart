<?php
/*****************************************************************************
 * SV-Cart �̵�����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: config.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Config extends AppModel
{
	var $name = 'Config';
	var $hasOne = array('ConfigI18n' =>   
                        array('className'    => 'ConfigI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'Config_id'  
                        )   
                  );
    var $cacheQueries = true;
    
    function set_locale($locale){
    	$conditions = " ConfigI18n.locale = '".$locale."'";
    	$this->hasOne['ConfigI18n']['conditions'] = $conditions;
        
    }

	function getlist($store_id = 0){
		$condition = " store_id = '".$store_id."'";
		$configs=$this->findAll($condition,'','orderby asc');
		return $configs;
	}
	
	function getformatcode($store_id = 0){
		$condition = " store_id = '".$store_id."'";
		$configs=$this->findAll($condition,'','orderby asc');
		$configs_formatcode =array();
		if(is_array($configs))
		foreach($configs as $v){
			
			$configs_formatcode[$v['Config']['code']]=$v['ConfigI18n']['value'];
			
		}
		
		return $configs_formatcode;
	}
}
?>