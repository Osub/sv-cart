<?php
/*****************************************************************************
 * SV-Cart ����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: type.php 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
class Type extends AppModel
{
	var $name = 'Type';
		var $hasOne = array('TypeI18n'     =>array
												( 
												  'className'    => 'TypeI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'type_id'
					                        	 )
                 	   );
    
	function set_locale($locale){
    	$conditions = " TypeI18n.locale = '".$locale."'";
    	$this->hasOne['TypeI18n']['conditions'] = $conditions;
        
    }

	function gettypeformat(){
		$condition="";
		$lists=$this->findAll($condition);
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				 $lists_formated[$v['Type']['id']]['Type']=$v['Type'];
				 $lists_formated[$v['Type']['id']]['TypeI18n'][]=$v['TypeI18n'];
				 $lists_formated[$v['Type']['id']]['Type']['name']='';
				 foreach($lists_formated[$v['Type']['id']]['TypeI18n'] as $key=>$val){
				 	  $lists_formated[$v['Type']['id']]['Type']['name'] .=$val['name'] . " | ";
				 }
			}
		//pr($lists_formated);
		return $lists_formated;
	}
}
?>