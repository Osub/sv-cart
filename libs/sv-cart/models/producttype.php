<?php
/*****************************************************************************
 * SV-Cart ��Ʒ����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: producttype.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class ProductType extends AppModel
{
	var $name = 'ProductType';
	var $hasOne = array('ProductTypeI18n' =>   
                        array('className'    => 'ProductTypeI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'ProductType_id'  
                        )
                  );
  	
	function set_locale($locale){
    	$conditions = " ProductTypeI18n.locale = '".$locale."'";
    	$this->hasOne['ProductTypeI18n']['conditions'] = $conditions;
        
    }
    

//class_end
}
?>