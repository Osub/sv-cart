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
 * $Id: brand.php 725 2009-04-17 08:00:21Z huangbo $
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
  /*  function localeformat($id){
		$info=$this->findbyid($id);
		if(is_array($info['BrandI18n']))
			foreach($info['BrandI18n'] as $k => $v){
				$info['BrandI18n'][$v['locale']]=$v;
			}
		return $info;
	}*/
	
	//品牌数组结构调整
    function localeformat($id){
		$lists=$this->findAll("Brand.id = '".$id."'");
	//	pr($lists);
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
	
	
	function getbrandformat(){
		$condition="";
		$lists=$this->findAll($condition);
		//pr($lists);
		//$lists_formated = array();
	/*	if(is_array($lists))
			foreach($lists as $k => $v){
				 $lists_formated[$v['Brand']['id']]['Brand']=$v['Brand'];
				 $lists_formated[$v['Brand']['id']]['BrandI18n'][]=$v['BrandI18n'];
				 $lists_formated[$v['Brand']['id']]['Brand']['name']='';
				 foreach($lists_formated[$v['Brand']['id']]['BrandI18n'] as $key=>$val){
				 	  $lists_formated[$v['Brand']['id']]['Brand']['name'] .=$val['name']."|";
				 }
			}*/

		return $lists;
	}


}
?>