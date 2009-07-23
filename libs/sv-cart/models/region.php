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
 * $Id: region.php 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
class Region extends AppModel
{
	var $name = 'Region';
	
	
	var $hasOne = array('RegionI18n' =>   
                        array('className'    => 'RegionI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'region_id'  
                        )
                  );

	
	function set_locale($locale){
    	$conditions = " RegionI18n.locale = '".$locale."'";
    	$this->hasOne['RegionI18n']['conditions'] = $conditions;
    }
    
    function strtoid($str){
    	$last_name = array_pop(explode(" ",trim($str)));
		return $this->find("RegionI18n.name ='".$last_name."'");
    }
    
    function strtoids($str){
    	$names = explode(" ",trim($str));
    //	pr($names);
		$ids = $this->find("list",array("conditions"=>array("RegionI18n.name" =>$names),'recursive'=>1));
	//	pr($ids);
		return $ids;
    }
    
}
?>