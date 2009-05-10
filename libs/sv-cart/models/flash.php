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
 * $Id: flash.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Flash extends AppModel
{
	var $name = 'Flash';
	var $hasMany = array('FlashImage' =>   
                        array('className'    => 'FlashImage',   
        					  'conditions' => 'status = 1 ',
     						  'fields' => array("image","title","url"),
                              'order'        => ' orderby ',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'flash_id'  
                        )   
                  );
    var $cacheQueries = true;
    
    function set_locale($locale){
    	$conditions = " FlashImage.locale = '".$locale."'";
    //	$this->hasMany['FlashImage']['conditions'] = $conditions;
        
    }

}
?>