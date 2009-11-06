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
 * $Id: product.php 4930 2009-10-12 10:24:42Z huangbo $
*****************************************************************************/
class Product extends AppModel
{
	var $name = 'Product';
	var $cacheQueries = true;
	var $cacheAction = "1 day";		
	
		var $hasOne = array(
							'ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 ) 
					   	/*	'ProductsCategory' =>array
												(
										          'className'     => 'ProductsCategory',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'Product_id'
					                        	),*/
					  	/*	'ProviderProduct' =>array
												(
										          'className'     => 'ProviderProduct',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	),	*/
					  /* 	,	'ProductLocalePrice' =>array
												(
										          'className'     => 'ProductLocalePrice',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	)*/
                 	   );
	/*		var $hasMany = array('ProductAttribute' =>array
															(
													          'className'     => 'ProductAttribute',   
								                              'order'        => '',   
								                              'dependent'    =>  true,   
								                              'foreignKey'   => 'product_id'
								                        	)	
												);
			*/
	function set_locale($locale){
    	$conditions = " ProductI18n.locale = '".$locale."'";
     //	$condition = " ProductLocalePrice.locale = '".$locale."'";
    	$this->hasOne['ProductI18n']['conditions'] = $conditions;
    //	$this->hasOne['ProductLocalePrice']['conditions'] = $condition;
    }
    
 /*
商品列表
*$products_id=>商品ID号
*$status=>状态
*$groupby=>分组
*$orderby=>排序
*/    
	function find_category(){
	
	}


    function get_list($products_id,$locale,$status='1',$groupby='',$orderby='Product.modified desc'){
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
	//	$Lists=$this->findAll($condition,'',$orderby);
		$params = array('order' => array($orderby),
			'fields' =>	array('Product.id'
																				,'Product.recommand_flag'
																				,'Product.status'
																				,'Product.img_thumb'
																				,'Product.market_price'
																				,'Product.shop_price'
																				,'Product.promotion_price'
																				,'Product.promotion_start'
																				,'Product.promotion_end'
																				,'Product.promotion_status'
																				,'Product.code'
																				,'Product.brand_id'
																				,'Product.category_id'
																				,'Product.product_rank_id'
																				,'Product.quantity','ProductI18n.name'
																				),			
			
			
		    			'conditions' => array($condition)
			   			);
		$Lists = $this->cache_find('all',$params,$this->name.$locale);	
		return $Lists;
	}

    function promotion($number,$locale,$category_ids =''){
/*		$cache_key = md5($this->name."_promotion_".$number);
		
		$products = cache::read($cache_key);
		if($products){
			return $products;
		}else{		    	
			
	//		$products=$this->findall("Product.status ='1' and Product.alone = '1' and Product.forsale ='1' and promotion_status in ('1','2') and '".$datetime."' between promotion_start and promotion_end  ",'','promotion_end asc',$number);
			$products=$this->find('all',array('order' => array('Product.promotion_end DESC'),
		    												'conditions' => "Product.status ='1' and Product.alone = '1' and Product.forsale ='1' and promotion_status in ('1','2') and '".$datetime."' between promotion_start and promotion_end  ",
		    												'limit' => $number
		    												));					
			
//			cache::write($cache_key,$products);*/
			$datetime = date("Y-m-d H:i:s");
			$condition = "Product.status ='1' and Product.alone = '1' and Product.forsale ='1' and promotion_status in ('1','2') and '".$datetime."' between promotion_start and promotion_end  ";
			if($category_ids != ""){
				$condition  .= " and Product.category_id = ".$category_ids;
			}			
			$params = array('order' => array('Product.modified DESC'),
																'recursive' => -1,
																'fields' =>	array('Product.id','Product.recommand_flag','Product.status','Product.img_thumb'
																				,'Product.market_price'
																				,'Product.shop_price'
																				,'Product.promotion_price'
																				,'Product.promotion_start'
																				,'Product.promotion_end'
																				,'Product.promotion_status'
																				,'Product.code'
																				,'Product.quantity'
																				,'Product.product_rank_id'
																				),																
			    												'conditions' => $condition,
			    												'limit' => $number
			    												);
			$products = $this->cache_find('all',$params,$this->name.$locale);			
			return $products;			
		//	}
		
	}
    
    //是否是有效促销商品
    function is_promotion($product){
    	$datetime = date("Y-m-d H:i:s");
    //	$condition = "Product.status ='1' and Product.alone = '1' and Product.forsale ='1' and Product.promotion_status in ('1','2') and '".$datetime."' between Product.promotion_start and Product.promotion_end  and Product.id= '".$product_id."'";
//		$products=$this->find($condition);
	//	pr($product);exit;
		if(isset($product['Product']) && ($product['Product']['promotion_status']== 1 || $product['Product']['promotion_status']== 2) && $product['Product']['promotion_start'] <= $datetime && $product['Product']['promotion_end'] >=  $datetime){
			return true;
		}else{
			return false;
   		}
    }
    
	function newarrival($number,$locale,$category_ids =''){
//		$cache_key = md5($this->name."_newarrival_".$number);
//		$products = cache::read($cache_key);
//		if($products){
//			return $products;
//		}else{		
	//		$products=$this->findall(" Product.status ='1' and Product.alone = '1' and Product.forsale ='1'  ",""," Product.created desc",$number);
			
/*			$products=$this->find('all',array('order' => array('Product.modified DESC'),
		    												'conditions' => array('Product.status'=>'1',
		    																	  'Product.alone' => '1',
		    																	  'Product.forsale' => '1'
		    																		),
		    												'limit' => $number
		    												));			
			
			
			cache::write($cache_key,$products);*/
			$condition = array('Product.status'=>'1',
								'Product.alone' => '1',
								'Product.forsale' => '1'
								);
			if($category_ids != ""){
				$condition['Product.category_id'] = $category_ids;
			}
			
			$params = array('order' => array('Product.modified DESC'),
																'recursive' => -1,
																'fields' =>	array('Product.id','Product.recommand_flag','Product.status','Product.img_thumb'
																				,'Product.market_price'
																				,'Product.shop_price'
																				,'Product.promotion_price'
																				,'Product.promotion_start'
																				,'Product.promotion_end'
																				,'Product.promotion_status'
																				,'Product.code'
																				,'Product.product_rank_id'
																				,'Product.quantity'
																				),
			    												'conditions' => $condition,
			    												'limit' => $number
			    												);
			$products = $this->cache_find('all',$params,$this->name.$locale);			
			return $products;
	//	}
	}
	
	function recommand($number,$locale,$category_ids =''){
	/*	$cache_key = md5($this->name."_recommand_".$number);
		
		$products = cache::read($cache_key);
		if($products){
			return $products;
		}else{
//			$products=$this->findall(" Product.status ='1'  and Product.alone = '1' and Product.forsale ='1' and Product.recommand_flag = '1' ",""," Product.modified desc",$number);
			$products=$this->find('all',array('order' => array('Product.modified DESC'),
		    												'conditions' => array('Product.status'=>'1',
		    																	  'Product.alone' => '1',
		    																	  'Product.forsale' => '1',
		    																	  'Product.recommand_flag' => '1'
		    																		),
		    												'limit' => $number
		    												));
			
			cache::write($cache_key,$products);
			return $products;
		}*/
		$condition =  array('Product.status'=>'1',
		    			  'Product.alone' => '1',
		    			  'Product.forsale' => '1',
						  'Product.recommand_flag' => '1'
		    			);
		if($category_ids != ""){
			$condition['Product.category_id'] = $category_ids;
		}
		
		$params = array('order' => array('Product.modified DESC'),
																'recursive' => -1,
																'fields' =>	array('Product.id','Product.recommand_flag','Product.status','Product.img_thumb'
																				,'Product.market_price'
																				,'Product.shop_price'
																				,'Product.promotion_price'
																				,'Product.promotion_start'
																				,'Product.promotion_end'
																				,'Product.promotion_status'
																				,'Product.code'
																				,'Product.quantity'
																				,'Product.product_rank_id'
																				),			
			
			
		    												'conditions' => $condition,
		    												'limit' => $number
		    												);
		$products = $this->cache_find('all',$params,$this->name.$locale);
		return $products;
	}
	
	function all_list($number,$locale,$category_ids =''){
		$condition =  array('Product.status'=>'1',
		    			  'Product.alone' => '1',
		    			  'Product.forsale' => '1'
				    		);
		if($category_ids != ""){
			$condition['Product.category_id'] = $category_ids;
		}
		
		$params = array('order' => array('Product.modified DESC'),
																'recursive' => -1,
																'fields' =>	array('Product.id','Product.recommand_flag','Product.status','Product.img_thumb'
																				,'Product.market_price'
																				,'Product.shop_price'
																				,'Product.promotion_price'
																				,'Product.promotion_start'
																				,'Product.promotion_end'
																				,'Product.promotion_status'
																				,'Product.code'
																				,'Product.quantity'
																				,'Product.product_rank_id'
																				),			
		    												'conditions' => $condition,
		    												'limit' => $number
		    												);
		$products = $this->cache_find('all',$params,$this->name.$locale);
		return $products;
	}	
	
	function search($locale,$keyword,$num = 10){
		$condition=array(
		   'OR' => array(
		   	  array("Product.code like '%$keyword%' "),
		      array("ProductI18n.name like '%$keyword%' "),
		      array("ProductI18n.description like '%$keyword%' ")
		   		),
		   	'AND' =>array('Product.status'=>'1',
						'Product.alone' => '1',
						'Product.forsale' => '1')
		   );
	  /*  $Pids=$this->findall($condition,'DISTINCT Product.id');
	    if(is_array($Pids)){
	    	foreach($Pids as $v ){
	    		$pid_array[]=$v['Product']['id'];
	    	}
	    }*/
	    $this->set_locale($locale);
 	   // $condition = array("Product.id"=>$pid_array);
 	    $params = array('order' => array('Product.modified DESC'),
						'fields' =>	array('Product.id','Product.img_thumb','Product.code','ProductI18n.name'),
						'conditions' => $condition,
 	    				'limit' => $num
 	    				);
		$result = $this->cache_find('all',$params,$this->name."_search_".$locale);
	  //  $result=$this->findall($condition);
	    
	    
	    return $result;
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
	
	function localeformat($id,$db){
		$lists=$this->findAll("Product.id = '".$id."'");
		
	//	pr($lists);
		$lists_formated = array();
		foreach($lists as $k => $v){
				 $category_info = $db->ProductsCategory->find('ProductsCategory.product_id ='.$v['Product']['id'].' and ProductsCategory.category_id ='.$v['Product']['category_id']);
			     $v['Product']['promotion_start']=substr($v['Product']['promotion_start'], 0, 10);
			     $v['Product']['promotion_end']=substr($v['Product']['promotion_end'], 0, 10);
				 $lists_formated['Product']=$v['Product'];
				 if(isset($category_info['ProductsCategory'])){
				 $lists_formated['ProductsCategory']=$category_info['ProductsCategory'];
				 }
			//	 $lists_formated['ProviderProduct']=$v['ProviderProduct'];
				 $lists_formated['ProductI18n'][]=$v['ProductI18n'];
				 foreach($lists_formated['ProductI18n'] as $key=>$val){
				 	  $lists_formated['ProductI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
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
	
	function top_products($locale,$size){
		 if($this->cacheFind($this->name,'findalllang'.$locale,array('locale'=>$locale,'size'=>$size))){
		 	$top_products = $this->cacheFind($this->name,'findalllang'.$locale,array('locale'=>$locale,'size'=>$size));
		 }else{
		 	$top_products = $this->find('all',array('order' => array('Product.sale_stat desc'),
																	'fields' =>	array('Product.id','Product.code','Product.market_price','Product.img_thumb','Product.shop_price',
																						'ProductI18n.name'
																				),								 		
	    												'conditions' => array('Product.status'=>'1',
	    																	  'Product.forsale' => '1',
	    																		'Product.sale_stat >'=>'0'
	    																		),
	    												'limit' => $size
	    			
	    												));	
		 	
			$this->cacheSave($this->name,'findalllang'.$locale,array('locale'=>$locale,'size'=>$size),$top_products);
		}
		 return $top_products;
	}
	
	function home_category_products($home_category_ids,$locale,$size){
		$params = array('order' => array('Product.modified DESC'),
		    			'conditions' => array("Product.status" => 1,'Product.forsale' => '1','Product.category_id'=>$home_category_ids)
			   			);
		$home_category_products = $this->cache_find('all',$params,$this->name.$locale."home_category_products");
		$home_category_products_list = array();			
		if(sizeof($home_category_products)>0){
			foreach($home_category_products as $k=>$v){
				$home_category_products_list[$v['Product']['category_id']][] = $v;
			}
		}
		
		return $home_category_products_list;		
	}
	
	function find_total($params,$locale){
		$total = $this->cache_find('count',$params,$this->name."_find_total_".$locale);
		return $total;
	}
	
	
	
}
?>