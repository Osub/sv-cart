<?php
/*****************************************************************************
 * SV-Cart ��Ʒ����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * �������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: products_category.php 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
class ProductGallery extends AppModel
{
	var $name = 'ProductGallery';
	var $hasOne = array('ProductGalleryI18n' =>   
                      array( 'className'    => 'ProductGalleryI18n', 
        					 'conditions'   => '',   
                             'order'        => '',   
                             'dependent'    =>  true,   
                             'foreignKey'   => 'product_gallery_id'  
                      ) 
                 ); 
	
	function set_locale($locale){
    	$conditions = "ProductGalleryI18n.locale = '".$locale."'";
    	$this->hasOne['ProductGalleryI18n']['conditions'] = $conditions;
        
    }



}
?>