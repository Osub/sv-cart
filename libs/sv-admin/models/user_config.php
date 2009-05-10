<?php
/*****************************************************************************
 * SV-Cart 用户基本信息
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: user_config.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class UserConfig extends AppModel
{
	var $name = 'UserConfig';  
	var $hasOne = array('UserConfigI18n' =>   
                        array('className'    => 'UserConfigI18n', 
                              'conditions'    =>  '',
                              'order'        => 'UserConfig.id',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'user_config_id'  
                        )
                  );
    
    function set_locale($locale){
    	$conditions = " UserConfigI18n.locale = '".$locale."'";
    	$this->hasOne['UserConfigI18n']['conditions'] = $conditions;
        
    }
    
    //数组结构调整
    function localeformat($id){
		$lists=$this->findAll("UserConfig.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['UserConfig']=$v['UserConfig'];
				 $lists_formated['UserConfigI18n'][]=$v['UserConfigI18n'];
				 foreach($lists_formated['UserConfigI18n'] as $key=>$val){
				 	  $lists_formated['UserConfigI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
}