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
 * $Id: producttype.php 1370 2009-05-14 10:35:18Z shenyunfeng $
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