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
 * $Id: navigation.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Navigation extends AppModel
{
	var $name = 'Navigation';

	var $hasOne = array('NavigationI18n' =>   
                        array('className'    => 'NavigationI18n', 
                              'conditions'    =>  '',
                              'order'        => 'locale desc',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'Navigation_id'  
                        )
                  );

    function set_locale($locale){
    	$conditions = " NavigationI18n.locale = '".$locale."'";
    	$this->hasOne['NavigationI18n']['conditions'] = $conditions;
        
    }

	var $navigations_parent_format=array();
	
	function getdata($condition,$orderby,$rownum,$page,$locale){
		$this->set_locale($locale);
		$navigations=$this->findAll($condition,'',$orderby,$rownum,$page);
		//pr($navigations);
		if(is_array($navigations))
			foreach($navigations as $k=>$v){
				$type = $v['Navigation']['type'];
			//	$v['Navigation']['name']="";
				switch($type){
					case 'T':
						$v['Navigation']['typename'] = '顶部';
						break;
					case 'H':
						$v['Navigation']['typename'] = '帮助栏目';
						break;
					case 'B':
						$v['Navigation']['typename'] = '底部';
						break;
					case 'M':
						$v['Navigation']['typename'] = '中间';
						break;
					default:
						$v['Navigation']['typename'] = '未定义';
				}
				if(empty($v['NavigationI18n'])){
					$v['Navigation']['name'] = "NULL";
					$v['NavigationI18n'][0]['url'] = '/navigations';
				}
				$this->navigations_parent_format[]=$v;
			}
		//pr($this->navigations_parent_format);
		
		return $this->navigations_parent_format;
	}
/*	function localformat($id){
		$data = $this->findById($id);
		if(!empty($data['NavigationI18n'])){
			foreach($data['NavigationI18n'] as $k=>$v){
				$data['NavigationI18n'][$v['locale']] = $v;
			}
		}
		return $data;
	}*/
	
	//数组结构调整
    function localeformat($id){
		$lists=$this->findAll("Navigation.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Navigation']=$v['Navigation'];
				 $lists_formated['NavigationI18n'][]=$v['NavigationI18n'];
				 foreach($lists_formated['NavigationI18n'] as $key=>$val){
				 	  $lists_formated['NavigationI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
	
}
?>