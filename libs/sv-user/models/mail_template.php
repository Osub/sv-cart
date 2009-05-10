<?php
/*****************************************************************************
 * SV-Cart �ʼ�ģ��
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: mail_template.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class MailTemplate extends AppModel
{
	var $name = 'MailTemplate';

	var $hasOne = array('MailTemplateI18n' =>   
                        array('className'    => 'MailTemplateI18n', 
                              'conditions'    =>  '',
                              'order'        => 'MailTemplate.id',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'mail_template_id'  
                        )
                  );
    
    
        
	function set_locale($locale){
    	$conditions = " MailTemplateI18n.locale = '".$locale."'";
    	$this->hasOne['MailTemplateI18n']['conditions'] = $conditions;
        
    }
    
    //����ṹ����
    function localeformat($id){
		$lists=$this->findAll("MailTemplate.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['MailTemplate']=$v['MailTemplate'];
				 $lists_formated['MailTemplateI18n'][]=$v['MailTemplateI18n'];
				 foreach($lists_formated['MailTemplateI18n'] as $key=>$val){
				 	  $lists_formated['MailTemplateI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
}