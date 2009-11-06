<?php
/*****************************************************************************
 * SV-Cart 品牌
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: brand.php 5101 2009-10-15 11:23:51Z huangbo $
*****************************************************************************/
class Brand extends AppModel
{
	var $name = 'Brand';
	var $cacheQueries = true;
	var $cacheAction = "1 day";
	
	var $hasOne = array('BrandI18n' =>   
                        array('className'    => 'BrandI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'brand_id'  
                        )   
                  );
    

	function set_locale($locale){
    	$conditions = " BrandI18n.locale = '".$locale."'";
    	$this->hasOne['BrandI18n']['conditions'] = $conditions;
        
    }
	
	//hobby 20081117 取得id=>name的数组
	function findassoc($locale =''){
		$condition=" Brand.status ='1' ";
		$orderby = " orderby asc ";
		$cache_key = md5($this->name.'_'.$locale);
		
		$lists_formated = cache::read($cache_key);	
		if($lists_formated){
			return $lists_formated;
		}else{
		
		
		
//		$lists=$this->findall($condition,'',$orderby);
		$lists=$this->find('all',array('order'=>array($orderby,'BrandI18n.name asc'),
			'fields' =>	array('Brand.id','Brand.flash_config','Brand.url','Brand.img01','BrandI18n.img01','BrandI18n.name'
																	
																					),			
		
		'conditions'=>array($condition)));
		
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['Brand']['id']]=$v;
			}
			
		cache::write($cache_key,$lists_formated);
		return $lists_formated;
		}
	}
	
}
?>