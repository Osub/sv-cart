<?php
/*****************************************************************************
 * SV-Cart �ؿ�
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * �������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
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
}
?>