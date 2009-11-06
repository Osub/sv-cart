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
 * $Id: provider_product.php 4996 2009-10-14 02:06:44Z huangbo $
*****************************************************************************/
class ProviderProduct extends AppModel{
	var $name = 'ProviderProduct';
	var $belongsTo = array('Provider' =>   
                        array('className'    => 'Provider', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true, 
        					  'foreignKey'   => 'provider_id' 
                        ),
        				'Product' =>   
                        array('className'    => 'Product', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true, 
        					  'foreignKey'   => 'product_id' 
                        )
                  );
    //return array('product_id'=>'provider_name');
    

    function findAssoc(){
    	$data = $this->findAll();
    	$product = array();
    	foreach($data as $v){
    		$product[$v['ProviderProduct']['product_id']]['name']='';
    		if(isset($product[$v['ProviderProduct']['product_id']])) 
    			$product[$v['ProviderProduct']['product_id']]['name'] = $v['Provider']['name'];
    	}
    	return $product;
    }
    function handle_other_cat($product_id, $provider_list,$pvprice){
    	  
    	   //��ѯ���е���չ����
    	   $res=$this->findAll("ProviderProduct.product_id = ".$product_id."");
    	   $exist_list=array();
    	   foreach($res as $k=>$v){
    	   	    $exist_list[$k]=$v['ProviderProduct']['provider_id'];
    	   }
    	   //ɾ�������еķ���
    	   $delete_list = array_diff($exist_list, $provider_list);
    	   if($delete_list){
    	   	      $condition=array("ProviderProduct.provider_id"=>$delete_list,"ProviderProduct.product_id = ".$product_id."");
    	   	      $this->deleteAll($condition);
    	   }
    	   //����¼ӵķ���
    	   $add_list = array_diff($provider_list, $exist_list, array(0));
    	   foreach ($provider_list AS $k=>$cat_id){
    	   	   		  if(empty($add_list[$k])){
    	   	   		  	return false;
    	   	   		  }
    	   	          $other_cat_info=array(
		                          'product_id'=>$product_id,
		                          'provider_id'=>$add_list[$k],
		                  			'price'=>$pvprice[$k]
		              );
		             $this->saveAll(array('ProviderProduct'=>$other_cat_info));
    	   }
       return true;
    }

    
}
?>