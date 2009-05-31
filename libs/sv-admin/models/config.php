<?php
/*****************************************************************************
 * SV-Cart ����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: config.php 1732 2009-05-25 12:03:32Z huangbo $
*****************************************************************************/
class Config extends AppModel
{
	var $name = 'Config';  
	var $hasOne = array('ConfigI18n' =>   
                        array('className'    => 'ConfigI18n',
                        	'conditions'    =>  '',   
                              'order'        => 'Config.id',   
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
	
	function getformatcode($store_id = 0){
		$condition = " store_id = '".$store_id."'";
		$configs=$this->findAll($condition,'','orderby asc');
		
		$configs_formatcode =array();
		if(is_array($configs))
		foreach($configs as $v){
			
			$configs_formatcode[$v['Config']['code']]=$v['ConfigI18n']['value'];
			
		}
		
		if(!isset($configs_formatcode['use_sku'])){
			$configs_formatcode['use_sku'] = 0;
		}		
		
		return $configs_formatcode;
	}
	
	
    //����ṹ����
    function localeformat($id){
		$lists=$this->findAll("Config.id = '".$id."'");
		//pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Config']=$v['Config'];
				 $lists_formated['ConfigI18n'][]=$v['ConfigI18n'];
				 foreach($lists_formated['ConfigI18n'] as $key=>$val){
				 	  $lists_formated['ConfigI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
}
?>