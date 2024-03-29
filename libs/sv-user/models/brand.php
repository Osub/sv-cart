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
 * $Id: brand.php 2304 2009-06-26 07:00:53Z zhengli $
*****************************************************************************/
class Brand extends AppModel
{
	var $name = 'Brand';
	var $hasOne = array('BrandI18n' =>   
                        array('className'    => 'BrandI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'brand_id'  
                        )   
                  );
    
    //和flash_images 关联取得该品牌的flash设置
/*   	var $hasMany = array('FlashImage' =>   
                        array('className'    => 'FlashImage', 
                              'conditions'    =>  'FlashImage.type="B"',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'type_id'  
                        )
                  );
*/
    
function set_locale($locale){
    	$conditions = " BrandI18n.locale = '".$locale."'";
    	$this->hasOne['BrandI18n']['conditions'] = $conditions;
        
    }
//品牌列表
	function getlist(){
		$Brands_type = array();
		$condition = "status ='1'";
		$Brands=$this->findAll($condition,'','orderby asc');
		return $Brands;
	}
	
//品牌详细		
    function get_detail($id){
		$Brands=$this->findbyid($id);
		return $Brands;
	}
	
	function findassoc($locale =''){
		$condition=" Brand.status ='1' ";
		$orderby = " orderby asc ";
		$cache_key = md5($this->name.'_'.$locale);
		
		$lists_formated = cache::read($cache_key);	
		if($lists_formated){
			return $lists_formated;
		}else{
		
		$lists=$this->findall($condition,'',$orderby);
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