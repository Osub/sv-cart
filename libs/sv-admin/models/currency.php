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
class Currency extends AppModel{
	var $name = 'Currency';
	var $hasOne = array('CurrencyI18n'=>
						array('className'  => 'CurrencyI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'currency_id'							
						)
					);


	function set_locale($locale){
    	$conditions = " CurrencyI18n.locale = '".$locale."'";
    	$this->hasOne['CurrencyI18n']['conditions'] = $conditions;
        
    }


	//����ṹ����
    function localeformat($id){
		$lists=$this->findAll("Currency.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Currency']=$v['Currency'];
				 $lists_formated['CurrencyI18n'][]=$v['CurrencyI18n'];
				 foreach($lists_formated['CurrencyI18n'] as $key=>$val){
				 	  $lists_formated['CurrencyI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}

}
?>