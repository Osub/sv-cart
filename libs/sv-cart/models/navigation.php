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
 * $Id: navigation.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Navigation extends AppModel
{
	var $name = 'Navigation';
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
	
	function get_types(){
		$navigations_array=array();
		$condition = "status ='1'";
		$navigations=$this->findAll($condition,'','orderby asc');
		if(is_array($navigations))
			foreach($navigations as $k=>$v){
				$navigations_array[$v['Navigation']['type']][]=$v;
			}
		return $navigations_array;
	}
}

?>