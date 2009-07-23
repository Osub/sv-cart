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
 * $Id: exchanges_controller.php 2918 2009-07-16 03:26:36Z shenyunfeng $
*****************************************************************************/
class ExchangesController extends AppController {
	var $name = 'Exchanges';
    var $components = array ('Pagination','Cookie');
	var $helpers = array('Html');
	var $uses = array('Product','ProductRank','UserRank','ProductsCategory','ProductLocalePrice','ProductI18n');
	
	function index($orderby="",$rownum='',$showtype=""){
		$this->pageTitle = $this->languages['integral_shopping_mall']." - ".$this->configs['shop_title'];
		$this->navigations[] = array('name'=>$this->languages['integral_shopping_mall'],'url'=>"/exchange/");
		$this->page_init();
		$orderby = UrlDecode($orderby);
		$rownum = UrlDecode($rownum);
		$showtype = UrlDecode($showtype);
		if(empty($rownum)){
			$rownum=isset($this->configs['products_list_num']) ? $this->configs['products_list_num']:((!empty($rownum)) ?$rownum:20);
		}
		if(empty($showtype)){
			$showtype=isset($this->configs['products_list_showtype']) ? $this->configs['products_list_showtype']:((!empty($showtype)) ?$showtype:'L');
		}
		if(empty($orderby)){
		 	$orderby=isset($this->configs['products_category_page_orderby_type'])? $this->configs['products_category_page_orderby_type']." ". $this->configs['products_category_page_orderby_method'] :((!empty($orderby)) ?$orderby:'created '.$this->configs['products_category_page_orderby_method']);
		}
		// 查找可用积分购买的商品
		$sortClass='Product';
		$page=1;
		$parameters=Array($orderby,$rownum,$page);
		$options=Array();
		$condition = "Product.point_fee > '0' and Product.status = '1' and Product.forsale = '1'";
	//	$products=$this->Product->findAll($condition,'',"Product.$orderby","$rownum",$page);
			$products=$this->Product->find('all',array(
															'recursive' => -1,
																'fields' =>	array('Product.id','Product.recommand_flag','Product.status','Product.img_thumb'
																				,'Product.market_price'
																				,'Product.shop_price'
																				,'Product.promotion_price'
																				,'Product.promotion_start'
																				,'Product.promotion_end'
																				,'Product.promotion_status'
																				,'Product.code','Product.point','Product.point_fee'
																				,'Product.product_rank_id'
																				,'Product.quantity'
																				),			
			'conditions'=>array($condition),'order'=>array("Product.$orderby"),'limit'=>$rownum,'page'=>$page));		
		
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
		
		
		
		$total = count($products);
		$product_ranks = $this->ProductRank->findall_ranks();
		if(isset($_SESSION['User']['User'])){
			$user_rank_list=$this->UserRank->findrank();		
		}
		$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass); // Added 
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
				
				if($this->configs['use_sku'] == 1){
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
		//排序方式,显示方式,分页数量限制
		$this->set('orderby',$orderby);
		$this->set('rownum',$rownum);
		$this->set('showtype',$showtype);
		$this->set('products',$products);		
		$this->set('locations',$this->navigations);
		
	}
	
}