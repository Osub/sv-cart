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
class InvoiceType extends AppModel{
	var $name = 'InvoiceType';
	var $hasOne = array('InvoiceTypeI18n'=>
						array('className'  => 'InvoiceTypeI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'invoice_type_id'							
						)
					);


	function set_locale($locale){
    	$conditions = " InvoiceTypeI18n.locale = '".$locale."'";
    	$this->hasOne['InvoiceTypeI18n']['conditions'] = $conditions;
        
    }


	//����ṹ����
    function localeformat($id){
		$lists=$this->findAll("InvoiceType.id = '".$id."'");
		foreach($lists as $k => $v){
				 $lists_formated['InvoiceType']=$v['InvoiceType'];
				 $lists_formated['InvoiceTypeI18n'][]=$v['InvoiceTypeI18n'];
				 foreach($lists_formated['InvoiceTypeI18n'] as $key=>$val){
				 	  $lists_formated['InvoiceTypeI18n'][$val['locale']]=$val;
				 }
			}
		return $lists_formated;
	}

}
?>