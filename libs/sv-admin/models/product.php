<?php
/*****************************************************************************
 * SV-Cart 商品
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: product.php 5425 2009-10-26 05:25:54Z huangbo $
*****************************************************************************/
class Product extends AppModel
{
	var $name = 'Product';
	var $hasOne = array('ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 ) ,
					   		
					   		'ProviderProduct' =>array
												(
										          'className'     => 'ProviderProduct',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	),
					   		'ProductDownload' =>array
												(
										          'className'     => 'ProductDownload',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	),	
					   		'ProductService' =>array
												(
										          'className'     => 'ProductService',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	),					            						
					   		'Stock' =>array
												(
										          'className'     => 'Stock',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	),					            						
                 	   );
    var $hasMany = array('Cart' =>array
												( 
												  'className'    => 'Cart',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 ) ,
					   		           'OrderProduct' =>array
												(
										          'className'     => 'OrderProduct',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	)
                 	   );


	function set_locale($locale){
    	$conditions = " ProductI18n.locale = '".$locale."'";
    	$this->hasOne['ProductI18n']['conditions'] = $conditions;
        
    }
    
    function cat_products_count(){
    	 $cat_products_count=array();
         $conditions = " Product.status = '1' GROUP BY Product.cat_id";
         $cat_products_count=$this->findAll($conditions,'');
         return $cat_products_count;
    }
 /*
商品列表
*$products_id=>商品ID号
*$status=>状态
*$groupby=>分组
*$orderby=>排序
*/    
    function get_list($products_id,$status='1',$groupby='',$orderby='Product.modified desc'){
		$Lists = array();
		$condition=' 1 ';
		if($products_id!=''){
			$condition .= " AND Product.id in (".$products_id.") ";
		}
		if($status!=''){
			$condition.=" AND Product.status='".$status."'";
		}
		if($groupby!=''){
		$condition.=" GROUP BY  ".$groupby;
		}
		$Lists=$this->findAll($condition,'',$orderby);
		return $Lists;
	}

    function promotion($number){
		$datetime = date("Y-m-d H:i:s");
		$products=$this->findall("status ='1' and alone = '1' and forsale ='1' and promotion_status in ('1','2') and '".$datetime."' between promotion_start and promotion_end  ",'','promotion_end asc',$number);
		return $products;
		
	}
    
    //是否是有效促销商品
    function is_promotion($product_id){
    	$datetime = date("Y-m-d H:i:s");
    	$condition = "Product.status ='1' and Product.alone = '1' and Product.forsale ='1' and Product.promotion_status in ('1','2') and '".$datetime."' between Product.promotion_start and Product.promotion_end  and Product.id= '".$product_id."'";
		$products=$this->find($condition);
		if($products)
			return true;
		else
			return false;
    }
    
	function newarrival($number){
		$products=$this->findall(" status ='1' and alone = '1' and forsale ='1'  ",""," Product.created desc",$number);
		return $products;
	}
	
	function recommand($number){
		$products=$this->findall(" status ='1'  and alone = '1' and forsale ='1' and recommand_flag = '1' ",""," Product.modified desc",$number);
		return $products;
	}
	
	function search($locale,$keyword){
		$condition=array(

		   'OR' => array(
		   	  array("Product.code like '%$keyword%' "),
		      array("ProductI18n.name like '%$keyword%' "),
		      array("ProductI18n.description like '%$keyword%' ")
		   		)
		   );
	    $Pids=$this->findall($condition,'DISTINCT Product.id');
	    if(is_array($Pids)){
	    	foreach($Pids as $v ){
	    		$pid_array[]=$v['Product']['id'];
	    	}
	    }
	    $this->set_locale($locale);
 	     $condition = array("Product.id"=>$pid_array);
	   $result=$this->findall($condition);
	   return $result;
	  }		
function pr(){
	//	pr($this->tablePrefix);
		
	}
	
	
	//商品数组结构调整
    function localeformat($id){
		$lists=$this->findAll("Product.id = '".$id."'");
		//pr($lists);
		$lists_formated = array();
		foreach($lists as $k => $v){
			     $v['Product']['promotion_start']=substr($v['Product']['promotion_start'], 0, 10);
			     $v['Product']['promotion_end']=substr($v['Product']['promotion_end'], 0, 10);
				 $lists_formated['Product']=$v['Product'];
				 $lists_formated['ProviderProduct']=@$v['ProviderProduct'];
				 $lists_formated['ProductI18n'][]=$v['ProductI18n'];
				 foreach($lists_formated['ProductI18n'] as $key=>$val){
				 	  $lists_formated['ProductI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
	function product_count(){
		$this->hasOne = array();
    	$this->hasMany = array();
		$lists=$this->find("all",array('fields' => array('category_id', 'count(category_id) as count'),"group"=>"category_id"));
		
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['Product']['category_id']]=$v['0']['count'];
			}
		//	pr($lists_formated);
		return $lists_formated;

	}
}
?>