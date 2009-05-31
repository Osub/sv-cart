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
 * $Id: producttype.php 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
class ProductType extends AppModel
{
	var $name = 'ProductType';
	var $hasOne = array('ProductTypeI18n' =>   
                        array('className'    => 'ProductTypeI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'type_id'  
                        )
                  );
  	
	function set_locale($locale){
    	$conditions = " ProductTypeI18n.locale = '".$locale."'";
    	$this->hasOne['ProductTypeI18n']['conditions'] = $conditions;
        
    }
    

//class_end
}
?>