<?php
/*****************************************************************************
 * SV-Cart 商店配置
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
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