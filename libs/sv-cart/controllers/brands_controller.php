<?php
/*****************************************************************************
 * SV-Cart 品牌分类
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: brands_controller.php 2845 2009-07-14 10:58:39Z shenyunfeng $
*****************************************************************************/

class BrandsController extends AppController {
	var $name = 'Brands';
    var $components = array ('Pagination'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array('Brand','Product','Flash','Category','UserRank','ProductsCategory','ProductRank','ProductLocalePrice','ProductI18n');

function view($id="",$orderby="",$rownum='',$showtype=""){
		$orderby = UrlDecode($orderby);
		$rownum = UrlDecode($rownum);
		$showtype = UrlDecode($showtype);
		$this->page_init();
		$flag = 1;
		// Configure::write('debug', 0);
	 if(!is_numeric($id) || $id<1){
	     $this->pageTitle = $this->languages['parameter_error']." - ".$this->configs['shop_title'];
		 $this->flash($this->languages['parameter_error'],"/",5);
		 $flag = 0;
	 }
	 $this->Brand->set_locale($this->locale);
 	  //取得该品牌信息
	  $brand_info=$this->Brand->findbyid($id);
	if(empty($brand_info)){
	       	 $this->pageTitle = $this->languages['brand'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['brand'].$this->languages['not_exist'],"/",5);
			 $flag = 0;
	  }
	elseif($brand_info['Brand']['status'] == 0){
	       	 $this->pageTitle = $this->languages['brand'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['brand'].$this->languages['not_exist'],"/",5);
			 $flag = 0;
	  }
	  
	    if($flag == 1){
		
		$this->pageTitle = $brand_info['BrandI18n']['name']." - ".$this->configs['shop_title']." - ".$this->configs['shop_title'];
		//当前位置
		$navigations=$this->Brand->findbyid($id);
	//	pr($navigations);
		$this->navigations[] = array('name'=>$navigations['BrandI18n']['name'],'url'=>"/brands/".$navigations['Brand']['id']);
		$this->set('locations',$this->navigations);
	  
		if(empty($rownum)){
			$rownum=isset($this->configs['products_list_num']) ? $this->configs['products_list_num']:((!empty($rownum)) ?$rownum:20);
		}
		if(empty($showtype)){
			$showtype=isset($this->configs['products_list_showtype']) ? $this->configs['products_list_showtype']:((!empty($showtype)) ?$showtype:'L');
		}
 		  //取商店设置商品排序
	    if(empty($orderby)){
		  	$orderby=isset($this->configs['products_category_page_orderby_type'])? $this->configs['products_category_page_orderby_type']." ". $this->configs['products_category_page_orderby_method'] :((!empty($orderby)) ?$orderby:'created '.$this->configs['products_category_page_orderby_method']);
		}
 	  $this->Product->set_locale($this->locale);
      //取得属于该品牌的商品,以及分页
	  $condition = " Product.brand_id='$id' and Product.forsale ='1'";
	  $total = $this->Product->findCount($condition,0);
	  $sortClass='Product';
	  //pr($parameters);
	  $page=1;
	  $parameters=Array($orderby,$rownum,$page);
	  $options=Array();
	  list($page) = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass); // Added 
	  
	 // $products_list=$this->Product->findAll($condition,'',"Product.$orderby asc ","$rownum",$page);
	 
	 
	  $products_list=$this->Product->find('all',array(
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
	  	  
	  	  
	  												'order' => array("Product.$orderby asc "),
	  												'conditions' => array($condition),
	  												'limit' => $rownum,
	  												'page'=>$page));
	  
	  												
	  $products_ids_list = array();
	  if(is_array($products_list) && sizeof($products_list)>0){
	  		foreach($products_list as $k=>$v){
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
	  
	  
	  
	  
	  
	  
	  $product_category_infos = $this->ProductsCategory->find('all',array("conditions"=>array('ProductsCategory.product_id'=>$products_ids_list)));
	  $product_category_lists = array();
	  if(is_array($product_category_infos) && sizeof($product_category_infos)>0){
	  		foreach($product_category_infos as $k=>$v){
	  			$product_category_lists[$v['ProductsCategory']['product_id']] = $v;
	  		}
	  }
	  $this->Category->set_locale($this->locale);						
	  $category_lists = $this->Category->find_all($this->locale);
	  $this->set('categories',$category_lists);
	 //pr($product_category_lists);
	 //pr($category_ids);
	  $product_ranks = $this->ProductRank->findall_ranks();
		  if(isset($_SESSION['User']['User'])){
		  	  $user_rank_list=$this->UserRank->findrank();		
		  }
			foreach($products_list as $k=>$v){
					if(isset($productI18ns_list[$v['Product']['id']])){
						$products_list[$k]['ProductI18n'] = $productI18ns_list[$v['Product']['id']]['ProductI18n'];
					}else{
						$products_list[$k]['ProductI18n']['name'] = "";
					}	
		 			 if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
							$products_list[$k]['ProductI18n']['name'] = $this->Product->sub_str($products_list[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
	 				 }
				//	$category_info = $this->ProductsCategory->find('ProductsCategory.product_id ='.$v['Product']['id'].' and ProductsCategory.category_id ='.$v['Product']['category_id']);
					if($this->configs['use_sku'] == 1){
					//	$info = $this->Category->findbyid($v['Product']['category_id']);						
						if(isset($category_lists[$v['Product']['category_id']])){
							$info = $category_lists[$v['Product']['category_id']];
						}
						$products_list[$k]['use_sku'] = 1;
						if($info['Category']['parent_id']>0){
					//		$parent_info = $this->Category->findbyid($info['Category']['parent_id']);
							if(isset($category_lists[$info['Category']['parent_id']])){
								$parent_info = $category_lists[$info['Category']['parent_id']];
							}
							if(isset($parent_info['Category'])){
								$products_list[$k]['parent'] = $parent_info['CategoryI18n']['name'];
							}
						}
					}
					if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'])){
						$products[$k]['Product']['shop_price'] = $locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'];
					}
					if(isset($product_ranks[$v['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']])){
						if(isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
						  $products[$k]['Product']['user_price']= $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
						}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
						  $products[$k]['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($v['Product']['shop_price']);			  
						}
					}						
					if(isset($product_category_lists[$v['Product']['id']])){
						$products_list[$k]['ProductsCategory'] = $product_category_lists[$v['Product']['id']]['ProductsCategory'];
					}
					//$products_list[$k]['ProductsCategory'] = $category_info['ProductsCategory'];
						
				//	$products_list[$k]['Product']['shop_price'] =$this->Product->locale_price($v['Product']['id'],$v['Product']['shop_price'],$this);
					if($this->Product->is_promotion($v)){
						$products_list[$k]['Product']['shop_price'] = $v['Product']['promotion_price'];
					}					
				//	$products_list[$k]['Product']['user_price'] =$this->Product->user_price($k,$v,$this);
  			}
				
	

	  $this->Flash->set_locale($this->locale);
	  $this->set('flashes',$this->Flash->find("type ='PC' and type_id='$id' ")); //flash轮播
	  
 	  $this->set('products',$products_list);
 	  $this->set('id',$id);
 	  $this->set('type','B');
 	  //pr($products_list);
 	  //排序方式,显示方式,分页数量限制
	  $this->set('orderby',$orderby);
	  $this->set('rownum',$rownum);
	  $this->set('showtype',$showtype);
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
	  $this->set('meta_description',$brand_info['BrandI18n']['meta_description']);
 	  $this->set('meta_keywords',$brand_info['BrandI18n']['meta_keywords']);
 	}
}
?>