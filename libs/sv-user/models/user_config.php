<?php
/*****************************************************************************
 * SV-Cart 用户设置
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
                              'conditions'       => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'user_config_id'  
                        )   
                  );
    
    function set_locale($locale){
    	$conditions = " UserConfigI18n.locale = '".$locale."'";//
    	$this->hasOne['UserConfigI18n']['conditions'] = $conditions;
        
    }


	
	function get_myconfig($user_id){
		$condition = " UserConfig.user_id = '".$user_id."'";
		$configs=$this->findAll($condition);
		return $configs;
	}
	
	

}
?>