<?php
/*****************************************************************************
 * SV-Cart 供应商商品
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
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