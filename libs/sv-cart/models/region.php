<?php
/*****************************************************************************
 * SV-Cart 地区
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
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