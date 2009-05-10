<?php
/*****************************************************************************
 * SV-Cart ʵ���
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: store.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Store extends AppModel{
	var $name = 'Store';

	var $hasOne = array('StoreI18n' =>   
                        array('className'    => 'StoreI18n', 
                              'conditions'    =>  '',
                              'order'        => 'Store.id',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'store_id'  
                        )
                  );
    
    function set_locale($locale){
    	$conditions = " StoreI18n.locale = '".$locale."'";
    	$this->hasOne['StoreI18n']['conditions'] = $conditions;
        
    }
    
    //����ṹ����
    function localeformat($id){
		$lists=$this->findAll("Store.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Store']=$v['Store'];
				 $lists_formated['StoreI18n'][]=$v['StoreI18n'];
				 foreach($lists_formated['StoreI18n'] as $key=>$val){
				 	  $lists_formated['StoreI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
}
?>