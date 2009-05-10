<?php
/*****************************************************************************
 * SV-Cart 包装
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: packaging.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Packaging extends AppModel{
	var $name = 'Packaging';
	var $hasOne = array('PackagingI18n' =>   
                        array('className'    => 'PackagingI18n', 
                              'conditions'    =>  '',
                              'order'        => 'Packaging.id',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'packaging_id'  
                        )
                  );
    
    function set_locale($locale){
    	$conditions = " PackagingI18n.locale = '".$locale."'";
    	$this->hasOne['PackagingI18n']['conditions'] = $conditions;
        
    }


	//数组结构调整
    function localeformat($id){
		$lists=$this->findAll("Packaging.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Packaging']=$v['Packaging'];
				 $lists_formated['PackagingI18n'][]=$v['PackagingI18n'];
				 foreach($lists_formated['PackagingI18n'] as $key=>$val){
				 	  $lists_formated['PackagingI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}

	}
?>