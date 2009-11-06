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
    	  
    	   //查询现有的扩展分类
    	   $res=$this->findAll("ProviderProduct.product_id = ".$product_id."");
    	   $exist_list=array();
    	   foreach($res as $k=>$v){
    	   	    $exist_list[$k]=$v['ProviderProduct']['provider_id'];
    	   }
    	   //删除不再有的分类
    	   $delete_list = array_diff($exist_list, $provider_list);
    	   if($delete_list){
    	   	      $condition=array("ProviderProduct.provider_id"=>$delete_list,"ProviderProduct.product_id = ".$product_id."");
    	   	      $this->deleteAll($condition);
    	   }
    	   //添加新加的分类
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