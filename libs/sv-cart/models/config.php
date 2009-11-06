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
 * $Id: config.php 3367 2009-07-29 03:29:39Z huangbo $
*****************************************************************************/
class Config extends AppModel
{
	var $name = 'Config';
	var $hasOne = array('ConfigI18n' =>   
                        array('className'    => 'ConfigI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'config_id'  
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
	
	function getformatcode($locale,$store_id = 0){		
		$cache_key = md5($this->name."_".$store_id."_".$locale);
		
		$configs_formatcode = cache::read($cache_key);
		if ($configs_formatcode){
			return $configs_formatcode;
		}else{
			$condition = " store_id = '".$store_id."'";
	//		$configs=$this->findAll($condition,'','orderby asc');
			$configs=$this->find('all',array('order'=>'orderby asc','fields'=>array('Config.code','ConfigI18n.value'),'conditions'=>array($condition)));
			
			$configs_formatcode =array();
			if(is_array($configs))
			foreach($configs as $v){
				$configs_formatcode[$v['Config']['code']]=$v['ConfigI18n']['value'];
			}
			if(!isset($configs_formatcode['use_sku'])){
				$configs_formatcode['use_sku'] = 0;
			}
			
			cache::write($cache_key,$configs_formatcode);
			return $configs_formatcode;

		}
	}
}
?>