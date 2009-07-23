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
 * $Id: promotion.php 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
class Promotion extends AppModel{
	var $name = 'Promotion';
	var $hasOne = array('PromotionI18n' =>   
                        array('className'    => 'PromotionI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'promotion_id'  
                        )
                  );
    
    function set_locale($locale){
    	$conditions = " PromotionI18n.locale = '".$locale."'";
    	$this->hasOne['PromotionI18n']['conditions'] = $conditions;
        
    }

	//����ṹ����
    function localeformat($id){
		$lists=$this->findAll("Promotion.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Promotion']=$v['Promotion'];
				 $lists_formated['PromotionI18n'][]=$v['PromotionI18n'];
				 foreach($lists_formated['PromotionI18n'] as $key=>$val){
				 	  $lists_formated['PromotionI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}

}
?>