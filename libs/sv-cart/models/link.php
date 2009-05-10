<?php
/*****************************************************************************
 * SV-Cart �ⲿ����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: link.php 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
class Link extends AppModel{
	var $name = 'Link';

	var $hasOne = array('LinkI18n' =>   
                        array('className'    => 'LinkI18n', 
                              'conditions'    =>  '',
                              'order'        => 'Link.id',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'link_id'  
                        )
                  );
    
    function set_locale($locale){
    	$conditions = " LinkI18n.locale = '".$locale."'";
    	$this->hasOne['LinkI18n']['conditions'] = $conditions;
        
    }
    
    //����ṹ����
    function localeformat($id){
		$lists=$this->findAll("Link.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Link']=$v['Link'];
				 $lists_formated['LinkI18n'][]=$v['LinkI18n'];
				 foreach($lists_formated['LinkI18n'] as $key=>$val){
				 	  $lists_formated['LinkI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}

}
?>