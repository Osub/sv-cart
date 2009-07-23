<?php
/*****************************************************************************
 * SV-Cart flash
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: flash.php 1728 2009-05-25 10:28:39Z zhengli $
*****************************************************************************/
class Flash extends AppModel
{
	var $name = 'Flash';
	var $hasMany = array('FlashImage' =>   
                        array('className'    => 'FlashImage',   
        					  'conditions' => "status = '1' ",
     						  'fields' => array("image","title","url"),
                              'order'        => ' orderby ',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'flash_id'  
                        )   
                  );
    var $cacheQueries = true;
    
    function set_locale($locale){
    	$conditions = " and FlashImage.locale = '".$locale."'";
    	$this->hasMany['FlashImage']['conditions'] = $this->hasMany['FlashImage']['conditions'] .= $conditions;
        
    }

}
?>