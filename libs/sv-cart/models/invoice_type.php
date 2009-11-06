<?php
/*****************************************************************************
 * SV-Cart Ʒ��
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: brand.php 3896 2009-08-26 02:11:38Z zhangshisong $
*****************************************************************************/
class InvoiceType extends AppModel
{
	var $name = 'InvoiceType';
	var $cacheQueries = true;
	var $cacheAction = "1 day";
	
	var $hasOne = array('InvoiceTypeI18n' =>   
                        array('className'    => 'InvoiceTypeI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'invoice_type_id'  
                        )   
                  );
    

	function set_locale($locale){
    	$conditions = " InvoiceTypeI18n.locale = '".$locale."'";
    	$this->hasOne['InvoiceTypeI18n']['conditions'] = $conditions;
    }
	
}
?>