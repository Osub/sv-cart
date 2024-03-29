<?php
/*****************************************************************************
 * SV-Cart 邮件模板
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: mail_template.php 725 2009-04-17 08:00:21Z huangbo $
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
    
    //数组结构调整
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