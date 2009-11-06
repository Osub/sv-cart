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
 * $Id: brand.php 5203 2009-10-20 07:21:12Z huangbo $
*****************************************************************************/
class Brand extends AppModel
{
	var $name = 'Brand';

	var $hasOne = array('BrandI18n' =>   
                        array('className'    => 'BrandI18n', 
                              'conditions'    =>  '',
                              'order'        => '',
                              'dependent'    =>  true,
                              'foreignKey'   => 'brand_id'
                        )
                  );
    	function set_locale($locale){
    	$conditions = " BrandI18n.locale = '".$locale."'";
    	$this->hasOne['BrandI18n']['conditions'] = $conditions;
        
    }
	//品牌数组结构调整
    function localeformat($id){
		$lists=$this->findAll("Brand.id = '".$id."'");
		foreach($lists as $k => $v){
				 $lists_formated['Brand']=$v['Brand'];
				 $lists_formated['BrandI18n'][]=$v['BrandI18n'];
				 foreach($lists_formated['BrandI18n'] as $key=>$val){
				 	  $lists_formated['BrandI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
	
	
	function getbrandformat_test(){
			$lists=$this->find("all",array("fields"=>array("Brand.id,BrandI18n.name,BrandI18n.locale")));
			return $lists;
	}
	function getbrandformat(){
		$lists=$this->find("all",array("fields"=>array("Brand.id,BrandI18n.name,BrandI18n.locale"),"order"=>"Brand.orderby asc,BrandI18n.name asc"));
		return $lists;
	}


}
?>