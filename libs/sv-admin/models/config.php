<?php
/*****************************************************************************
 * SV-Cart 设置
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: config.php 5195 2009-10-20 05:29:32Z huangbo $
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
	function getformatcode_all($store_id = 0){
		$condition = " store_id = '".$store_id."'";
		$configs=$this->find("all",array("conditions"=>$condition,'order'=>'orderby asc',"fields"=>array("ConfigI18n.locale","Config.code","ConfigI18n.value")));
		$configs_formatcode =array();
		if(is_array($configs))
			foreach($configs as $v){
				
				$configs_formatcode[$v["ConfigI18n"]["locale"]][$v['Config']['code']]=$v['ConfigI18n']['value'];
				
			}
			
		if(!isset($configs_formatcode['use_sku'])){
			$configs_formatcode['use_sku'] = 0;
		}		
		return $configs_formatcode;
	}

	function configall(){
		$lists=$this->findAll();
	//	pr($lists);
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
    //数组结构调整
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