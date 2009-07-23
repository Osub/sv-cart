<?php
/*****************************************************************************
 * SV-Cart �û�����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: user_config.php 723 2009-04-17 07:59:05Z shenyunfeng $
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