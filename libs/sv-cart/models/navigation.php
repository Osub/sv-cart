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
 * $Id: navigation.php 3987 2009-09-02 09:28:48Z huangbo $
*****************************************************************************/
class Navigation extends AppModel
{
	var $name = 'Navigation';
	var $cacheQueries = true;
	var $cacheAction = "1 day";

	var $hasOne = array('NavigationI18n' =>   
                        array('className'    => 'NavigationI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'navigation_id'  
                        )   
                  );
    
    function set_locale($locale){
    	$conditions = " NavigationI18n.locale = '".$locale."'";
    	$this->hasOne['NavigationI18n']['conditions'] = $conditions;
        
    }

	function getbytypes($type=""){
		$navigations_type = array();
		$condition = "status ='1'";
		if($type !="")
			$condition .=" and type = '".$type."'";
		$navigations=$this->findAll($condition,'','orderby asc');
		return $navigations;
	}
	
	function get_types($locale =''){
		$cache_key = md5($this->name.'_'.$locale);
		
		$navigations_array = cache::read($cache_key);	
		if($navigations_array){
			return $navigations_array;
		}else{
			$navigations_array=array();
			$condition = "status ='1'";
			$navigations=$this->findAll($condition,'','orderby asc');
			if(is_array($navigations))
				foreach($navigations as $k=>$v){
					if($v['Navigation']['parent_id'] == 0){
				//		$navigations_array[$v['Navigation']['type']][$v['Navigation']['parent_id']]['SubMenu'][] = $v;
				//	}else{
						$navigations_array[$v['Navigation']['type']][$v['Navigation']['id']] = $v;
					}
				}
				foreach($navigations as $k=>$v){
					if($v['Navigation']['parent_id'] > 0){
						$navigations_array[$v['Navigation']['type']][$v['Navigation']['parent_id']]['SubMenu'][] = $v;
					}
				}
			//	pr($navigations_array);
			cache::write($cache_key,$navigations_array);
			return $navigations_array;
		}
	}
}

?>