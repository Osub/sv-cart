<?php
/*****************************************************************************
 * SV-Cart ר��
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: topic.php 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
class Topic extends AppModel{
	var $name = 'Topic';
	var $hasOne = array('TopicI18n' =>   
                        array('className'    => 'TopicI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'topic_id'  
                        )
                  );
    
        
    function set_locale($locale){
    	$conditions = " TopicI18n.locale = '".$locale."'";
    	$this->hasOne['TopicI18n']['conditions'] = $conditions;
        
    }

	//����ṹ����
    function localeformat($id){
		$lists=$this->findAll("Topic.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Topic']=$v['Topic'];
				 $lists_formated['TopicI18n'][]=$v['TopicI18n'];
				 foreach($lists_formated['TopicI18n'] as $key=>$val){
				 	  $lists_formated['TopicI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}

}
?>