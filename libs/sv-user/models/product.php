<?php
/*****************************************************************************
 * SV-Cart 我的收藏
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: product.php 3134 2009-07-21 06:45:45Z huangbo $
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
					   	/*	'ProductsCategory' =>array
												(
										          'className'     => 'ProductsCategory',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'Product_id'
					                        	)*/
					   		'ProductLocalePrice' =>array
												(
										          'className'     => 'ProductLocalePrice',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	)						                        		
                 	   );


    
	function set_locale($locale){
    	$conditions = " ProductI18n.locale = '".$locale."'";
    	$this->hasOne['ProductI18n']['conditions'] = $conditions;
        
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
	
	
		function findassoc($locale){
			$this->set_locale($locale);
		$condition="Product.status ='1'";
		
		$lists=$this->findAll($condition);
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['Product']['id']]=$v;
			}
		
		return $lists_formated;
	}
	
	function locale_price($id,$shop_price,$db){
			if(isset($db->configs['mlti_currency_module']) && $db->configs['mlti_currency_module'] == 1){
			$product_price = $db->ProductLocalePrice->find("ProductLocalePrice.product_id =".$id." and ProductLocalePrice.status = '1' and ProductLocalePrice.locale = '".$db->locale."'");
				if(isset($product_price['ProductLocalePrice']['product_price'])){
					return $product_price['ProductLocalePrice']['product_price'];
				}else{
					return $shop_price;
				}
			}else{
				return $shop_price;
			}
	}	
		function user_price($k,$v,$db){
			  $product_rank = $db->ProductRank->findall('ProductRank.product_id ='.$v['Product']['id']);
			  $user_rank_list=$db->UserRank->findrank();
			       	if(isset($product_rank) && sizeof($product_rank)>0){
				    	  $is_rank = array();
						  foreach($product_rank as $a=>$b){
						  		$is_rank[$b['ProductRank']['rank_id']]['is_default_rank'] = $b['ProductRank']['is_default_rank'];
						  		$is_rank[$b['ProductRank']['rank_id']]['price'] = $b['ProductRank']['product_price'];
						  }
					}
					foreach($user_rank_list as $a=>$b){
							if(isset($is_rank[$b['UserRank']['id']]) && $is_rank[$b['UserRank']['id']]['is_default_rank'] == 0){
							  $user_rank_list[$a]['UserRank']['user_price']= $is_rank[$b['UserRank']['id']]['price'];			  
							}else{
							  $user_rank_list[$a]['UserRank']['user_price']=($user_rank_list[$a]['UserRank']['discount']/100)*($v['Product']['shop_price']);			  
							}
						  if(isset($_SESSION['User']['User']['rank']) && $b['UserRank']['id'] == $_SESSION['User']['User']['rank']){
						  	  	$products[$k]['Product']['user_price'] = $user_rank_list[$a]['UserRank']['user_price'];
						  		//$this->set('my_product_rank',$user_rank_list[$kk]['UserRank']['user_price']);
						  }
					}
					if(isset($products[$k]['Product']['user_price'])){
						return $products[$k]['Product']['user_price'];
					}else{
						return null;
					}
	}
	
	function top_products($locale,$size){
		 if($this->cacheFind($this->name,'findalllang'.$locale,array('locale'=>$locale,'size'=>$size))){
		 	$top_products = $this->cacheFind($this->name,'findalllang'.$locale,array('locale'=>$locale,'size'=>$size));
		 }else{
		 	$top_products = $this->find('all',array('order' => array('Product.sale_stat desc'),
	    												'conditions' => array('Product.status'=>'1',
	    																	  'Product.forsale' => '1'
	    																		),
	    												'limit' => $size
	    			
	    												));	
		 	
			$this->cacheSave($this->name,'findalllang'.$locale,array('locale'=>$locale,'size'=>$size),$top_products);
		}
		 return $top_products;
	}	
	
		function sub_str($str, $length = 0, $append = true)
	{
	    $str = trim($str);
	    $strlength = strlen($str);

	    if ($length == 0 || $length >= $strlength)
	    {
	        return $str;
	    }
	    elseif ($length < 0)
	    {
	        $length = $strlength + $length;
	        if ($length < 0)
	        {
	            $length = $strlength;
	        }
	    }

	    if (function_exists('mb_substr'))
	    {
	        $newstr = mb_substr($str, 0, $length, 'utf-8');
	    }
	    elseif (function_exists('iconv_substr'))
	    {
	        $newstr = iconv_substr($str, 0, $length, 'utf-8');
	    }
	    else
	    {
	        //$newstr = trim_right(substr($str, 0, $length));
	        $newstr = substr($str, 0, $length);
	    }

	    if ($append && $str != $newstr)
	    {
	        $newstr .= '...';
	    }
	    return $newstr;
	}
}
?>