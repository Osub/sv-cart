<?php
/*****************************************************************************
 * SV-Cart 导航
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: navigation.php 2261 2009-06-22 11:06:14Z zhengli $
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
					$navigations_array[$v['Navigation']['type']][]=$v;
				}
			cache::write($cache_key,$navigations_array);
			return $navigations_array;
		}
	}
}

?>