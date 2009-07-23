<?php
/*****************************************************************************
 * SV-Cart �ؿ�
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: card.php 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
class Card extends AppModel{
	var $name = 'Card';
	var $hasOne = array('CardI18n'=>
						array('className'  => 'CardI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'card_id'							
						)
					);


	function set_locale($locale){
    	$conditions = " CardI18n.locale = '".$locale."'";
    	$this->hasOne['CardI18n']['conditions'] = $conditions;
        
    }


	//����ṹ����
    function localeformat($id){
		$lists=$this->findAll("Card.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Card']=$v['Card'];
				 $lists_formated['CardI18n'][]=$v['CardI18n'];
				 foreach($lists_formated['CardI18n'] as $key=>$val){
				 	  $lists_formated['CardI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}

}
?>