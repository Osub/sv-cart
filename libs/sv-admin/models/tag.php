<?php
/*****************************************************************************
 * SV-Cart ��ǩ
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: tag.php 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
class Tag extends AppModel
{
	var $name = 'Tag';
	var $hasOne = array('TagI18n'=>
						array('className'  => 'TagI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'tag_id'	
						)
					);
	
	
	function set_locale($locale){
    	$conditions = " TagI18n.locale = '".$locale."'";
    	$this->hasOne['TagI18n']['conditions'] = $conditions;
        
    }
    
    //����ṹ����
    function localeformat($id){
		$lists=$this->findAll("Tag.id = '".$id."'");
		foreach($lists as $k => $v){
				 $lists_formated['Tag']=$v['Tag'];
				 $lists_formated['TagI18n'][]=$v['TagI18n'];
				 foreach($lists_formated['TagI18n'] as $key=>$val){
				 	  $lists_formated['TagI18n'][$val['locale']]=$val;
				 }
			}
		return $lists_formated;
	}
	

}
?>