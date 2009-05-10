<?php
/*****************************************************************************
 * SV-Cart ��Ӧ����Ʒ
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: provider_product.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class ProviderProduct extends AppModel{
	var $name = 'ProviderProduct';
	var $belongsTo = array('Provider' =>   
                        array('className'    => 'Provider', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true, 
        					  'foreignKey'   => 'provider_id' 
                        )
                  );
    //return array('product_id'=>'provider_name');
    

    function findAssoc(){
    	$data = $this->findAll();
    	foreach($data as $v){
    		$product[$v['ProviderProduct']['product_id']]['name']='';
    		if(isset($product[$v['ProviderProduct']['product_id']])) 
    			$product[$v['ProviderProduct']['product_id']]['name'] = $v['Provider']['name'];
    	}
    	return $product;
    }
}
?>