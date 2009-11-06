<?php
/*****************************************************************************
 * SV-Cart 积分商城
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: exchanges_controller.php 5028 2009-10-14 07:51:28Z huangbo $
*****************************************************************************/
class ExchangesController extends AppController {
	var $name = 'Exchanges';
    var $components = array ('Pagination','Cookie');
    var $helpers = array('Html','Pagination');
	var $uses = array('Product','ProductRank','UserRank','ProductsCategory','ProductLocalePrice','ProductI18n');
	var $cacheQueries = true;
	var $cacheAction = "1 hour";
	
	function index($page=1,$orderby="",$rownum='',$showtype=""){
		$this->pageTitle = $this->languages['integral_shopping_mall']." - ".$this->configs['shop_title'];
		$this->navigations[] = array('name'=>$this->languages['integral_shopping_mall'],'url'=>"/exchange/");
		$this->page_init();
		$orderby = UrlDecode($orderby);
		$rownum = UrlDecode($rownum);
		$showtype = UrlDecode($showtype);
		if(empty($rownum) && $rownum == 0){
			$rownum=isset($this->configs['products_list_num']) ? $this->configs['products_list_num']:((!empty($rownum)) ?$rownum:20);
		}
		if(empty($showtype) && $showtype == 0){
			$showtype=isset($this->configs['products_list_showtype']) ? $this->configs['products_list_showtype']:((!empty($showtype)) ?$showtype:'L');
		}
		if(empty($orderby) && $orderby == 0){
		 	$orderby=isset($this->configs['products_category_page_orderby_type'])? $this->configs['products_category_page_orderby_type']." ". $this->configs['products_category_page_orderby_method'] :((!empty($orderby)) ?$orderby:'created '.$this->configs['products_category_page_orderby_method']);
		}
		if(!isset($_GET['page'])){
			$_GET['page'] = $page;
		}else{
			$page = $_GET['page'];
		}
		
		if($rownum == 'all'){
			$rownum_sql = 99999;
		}else{
			$rownum_sql = $rownum;
		}		
		$this->data['get_page'] = $page;
		$this->data['orderby'] = $orderby;
		$this->data['rownum'] = $rownum;
		$this->data['showtype'] = $showtype;		
		
		// 查找可用积分购买的商品
		$sortClass='Product';
		$page=1;
		$parameters=Array($orderby,$rownum_sql,$page);
		$options=Array();
		$condition = "Product.point_fee > '0' and Product.status = '1' and Product.forsale = '1'";
		$total = $this->Product->cache_find('count',array('fields' => 'DISTINCT Product.id','recursive' => -1,'conditions'=>array($condition)),"Product_find_total_exchanges_".$this->locale);
		$this->data['page_total'] = $total;
	  	list($page) = $this->Pagination->init($condition,$parameters,$options,$total,$rownum_sql,$sortClass); // Added 
	//	$products=$this->Product->findAll($condition,'',"Product.$orderby","$rownum",$page);
			$products=$this->Product->find('all',array(
															'recursive' => -1,
																'fields' =>	array('Product.id','Product.recommand_flag','Product.status','Product.img_thumb'
																				,'Product.market_price'
																				,'Product.shop_price','Product.brand_id'
																				,'Product.promotion_price'
																				,'Product.promotion_start'
																				,'Product.promotion_end'
																				,'Product.promotion_status'
																				,'Product.code','Product.point','Product.point_fee'
																				,'Product.product_rank_id'
																				,'Product.quantity','Product.category_id'
																				),			
			'conditions'=>array($condition),'order'=>array("Product.$orderby"),'limit'=>$rownum_sql,'page'=>$page));		
		
			$products_ids_list = array();
			  if(is_array($products) && sizeof($products)>0){
			  		foreach($products as $k=>$v){
			  			$products_ids_list[] = $v['Product']['id'];
			  		}
			  }	
			  
		// 商品多语言
			$productI18ns_list =array();
				$productI18ns = $this->ProductI18n->find('all',array( 
				'fields' =>	array('ProductI18n.id','ProductI18n.name','ProductI18n.product_id'),
				'conditions'=>array('ProductI18n.product_id'=>$products_ids_list,'ProductI18n.locale'=>$this->locale)));
			if(isset($productI18ns) && sizeof($productI18ns)>0){
				foreach($productI18ns as $k=>$v){
					$productI18ns_list[$v['ProductI18n']['product_id']] = $v;
				}
			}
		
		// 商品地区价格
		if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1){
			$locale_price_list =array();
					$locale_price = $this->ProductLocalePrice->find('all',array( 
					'fields' =>	array('ProductLocalePrice.product_price','ProductLocalePrice.product_id'),
					'conditions'=>array('ProductLocalePrice.product_id'=>$products_ids_list,'ProductLocalePrice.locale'=>$this->locale,'ProductLocalePrice.status'=>1)));
				if(isset($locale_price) && sizeof($locale_price)>0){
					foreach($locale_price as $k=>$v){
						$locale_price_list[$v['ProductLocalePrice']['product_id']] = $v;
					}
				}
			}		
		
		
		
	//	$total = count($products);
		$product_ranks = $this->ProductRank->findall_ranks();
		$user_rank_list=$this->UserRank->findrank();		
		
		    if(isset($product_ranks) && sizeof($product_ranks)>0){
				  foreach($product_ranks as $k=>$v){
				  	  if(isset($v) && sizeof($v)>0){
				  	  	 foreach($v as $kk=>$vv){
				  	  	 	 if($vv['ProductRank']['is_default_rank'] == 1){
				  	  	 	 	$product_ranks[$k][$kk]['ProductRank']['discount'] = ($user_rank_list[$vv['ProductRank']['rank_id']]['UserRank']['discount']/100);	
				  	  	 	 }			  	  	 
				  	  	 }
				  	  }
				  }
			}		
		
		  $products_ids_list = array();
		  if(is_array($products) && sizeof($products)>0){
		  		foreach($products as $k=>$v){
		  			$products_ids_list[] = $v['Product']['id'];
		  		}
		  }		
	    
	    $this->Category->set_locale($this->locale);						
		$category_lists = $this->Category->find_all($this->locale);
		
		
		$this->set('categories',$category_lists);
 	    $product_category_infos = $this->ProductsCategory->find('all',array("conditions"=>array('ProductsCategory.product_id'=>$products_ids_list)));
	    $product_category_lists = array();
	    if(is_array($product_category_infos) && sizeof($product_category_infos)>0){
	  	  	  foreach($product_category_infos as $k=>$v){
	  			  $product_category_lists[$v['ProductsCategory']['product_id']] = $v;
	  		  }
	    }		
		
			foreach($products as $k=>$v){
				if(isset($productI18ns_list[$v['Product']['id']])){
					$products[$k]['ProductI18n'] = $productI18ns_list[$v['Product']['id']]['ProductI18n'];
				}else{
					$products[$k]['ProductI18n']['name'] = "";
				}					
				
				 if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
					$products[$k]['ProductI18n']['sub_name'] = $this->Product->sub_str($products[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
		 		 }else{
		 		 	$products[$k]['ProductI18n']['sub_name'] = $products[$k]['ProductI18n']['name'];
		 		 }					
				if(isset($product_ranks[$v['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']])){
					if(isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
					  $product_ranks[$k]['Product']['user_price']= $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
					}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
					  $product_ranks[$k]['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($v['Product']['shop_price']);			  
					}
				}				
				
				if(isset($product_category_lists[$v['Product']['id']])){
					$products[$k]['ProductsCategory'] = $product_category_lists[$v['Product']['id']]['ProductsCategory'];
					$v['ProductsCategory'] = $product_category_lists[$v['Product']['id']]['ProductsCategory'];
				}			
				if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
					$products[$k]['ProductI18n']['name'] = $this->Product->sub_str($products[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
				}
	//			if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($v['ProductLocalePrice']['product_price'])){
	//				$products[$k]['Product']['shop_price'] = $v['ProductLocalePrice']['product_price'];
	//			}		
				if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'])){
					$products[$k]['Product']['shop_price'] = $locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'];
				}
		//		$products[$k]['Product']['shop_price'] =$this->Product->locale_price($v['Product']['id'],$v['Product']['shop_price'],$this);
				if($this->Product->is_promotion($v)){
					$products[$k]['Product']['shop_price'] = $v['Product']['promotion_price'];
				}
				
				if($this->configs['category_link_type'] == 1){
					$this->Category->set_locale($this->locale);						
				//	$info = $this->Category->findbyid($v['Product']['category_id']);
					if(isset($category_lists[$v['Product']['category_id']])){
						$info = $category_lists[$v['Product']['category_id']];
					}						
					$products[$k]['use_sku'] = 1;
					if($info['Category']['parent_id']>0){
					//	$parent_info = $this->Category->findbyid($info['Category']['parent_id']);
						if(isset($category_lists[$info['Category']['parent_id']])){
							$parent_info = $category_lists[$info['Category']['parent_id']];
						}						
						
						if(isset($parent_info['Category'])){
							$parent_info['CategoryI18n']['name'] = str_replace(" ","_",$parent_info['CategoryI18n']['name']);
							$parent_info['CategoryI18n']['name'] = str_replace("/","_",$parent_info['CategoryI18n']['name']);
							$products[$k]['parent'] = $parent_info['CategoryI18n']['name'];
						}
					}
				}				
				
				
										
			}
		if(isset($this->configs['enable_one_step_buy']) && $this->configs['enable_one_step_buy'] == 1){
			$js_languages = array("enable_one_step_buy" => "1"
										,'enter_positive_integer' => $this->languages['be_integer']);
			$this->set('js_languages',$js_languages);
		}else{
			$js_languages = array("enable_one_step_buy" => "0"
										,'enter_positive_integer' => $this->languages['be_integer']);
			$this->set('js_languages',$js_languages);
		}
		$this->navigations[] = array('name'=>$this->languages['integral_shopping_mall'],'url'=>"/exchanges");

		$this->set('locations',$this->navigations);
		
    	$this->data['pages_url_1'] = $this->server_host.$this->cart_webroot."exchanges/";
    	$this->data['pages_url_2'] = "/".$this->data['orderby']."/".$this->data['rownum']."/".$this->data['showtype'];
		
		
		//排序方式,显示方式,分页数量限制
		$this->set('orderby',$orderby);
		$this->set('rownum',$rownum);
		$this->set('showtype',$showtype);
		$this->data['product_ranks'] = $product_ranks;
		$this->data['products'] = $products;	  
		$this->set('products',$products);		
		$this->set('locations',$this->navigations);
		
	}
	
}