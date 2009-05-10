<?php
/*****************************************************************************
 * SV-Cart �û�������Ϣ
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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
    
    //����ṹ����
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