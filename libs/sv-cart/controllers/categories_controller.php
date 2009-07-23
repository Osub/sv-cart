<?php
/*****************************************************************************
 * SV-Cart 分类控制
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: categories_controller.php 3276 2009-07-23 09:14:17Z huangbo $
*****************************************************************************/

class CategoriesController extends AppController {

	var $name = 'Categories';
    var $components = array ('Pagination','Cookie'); // Added
    var $helpers = array('html','Pagination','Flash');
    var $uses = array('Category','Product','Flash','ProductsCategory','UserRank','ProductI18n','ProductRank','ProductLocalePrice','CategoryFilter','ProductType','ProductTypeAttribute','ProductAttribute'); 

	function view($id,$name1='',$name2 = '',$orderby="",$rownum='',$showtype='',$brand =0,$price_min =0,$price_max =0,$filters = ''){
		$orderby = UrlDecode($orderby);
		$rownum = UrlDecode($rownum);
		$showtype = UrlDecode($showtype);
		$this->set('brand',$brand);
		$this->set('price_max',$price_max);
		$this->set('price_min',$price_min);
	//	Configure::write('debug', 0);
		$this->page_init();
		$flag = 1;
		if(!is_numeric($id) || $id<1){
	       	 $this->pageTitle = $this->languages['parameter_error']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['parameter_error'],"/",5);
			 $flag = 0;
			 
		}
		//取该分类的信息
		$this->Category->set_locale($this->locale);
		$info=$this->Category->findbyid($id);
		
		if(empty($info)){
	       	 $this->pageTitle = $this->languages['classificatory'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['classificatory'].$this->languages['not_exist'],"/",5);
			 $flag = 0;
		}elseif($info['Category']['status'] == 0){
	       	 $this->pageTitle = $this->languages['classificatory'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['classificatory'].$this->languages['not_exist'],"/",5);
			 $flag = 0;
		}
		
		if($flag == 1){
			if($this->configs['use_sku'] == 1){
				$this->set('use_sku',1);
				if($info['Category']['parent_id']>0){
					$parent_info = $this->Category->findbyid($info['Category']['parent_id']);
					if(isset($parent_info['Category'])){
						$parent_info['CategoryI18n']['name'] = str_replace(" ","-",$parent_info['CategoryI18n']['name']);
						$parent_info['CategoryI18n']['name'] = str_replace("/","-",$parent_info['CategoryI18n']['name']);
						$this->set('parent',$parent_info['CategoryI18n']['name']);
					}
				}
			}
			$this->set('meta_description',$info['CategoryI18n']['meta_description']);
			$this->set('meta_keywords',$info['CategoryI18n']['meta_keywords']);
			
			$this->pageTitle = $info['CategoryI18n']['name']." - ".$this->configs['shop_title'];
			$this->set('CategoryI18n_name',$info['CategoryI18n']['name']);
			//当前位置
			$navigations = $this->Category->tree('P',$id,$this->locale);
	//		pr($navigations);
			if($info['Category']['parent_id'] == 0){
				if($this->configs['use_sku'] == 1){
					$info_url = str_replace(" ","-",$info['CategoryI18n']['name']);
					$info_url = str_replace("/","-",$info_url);
					$this->navigations[] = array('name'=>$info['CategoryI18n']['name'],'url'=>"/categories/".$info['Category']['id']."/".$info_url."/0");
				}else{
					$this->navigations[] = array('name'=>$info['CategoryI18n']['name'],'url'=>"/categories/".$info['Category']['id']);
				}
			}
			if($info['Category']['parent_id'] > 1){
				if($this->configs['use_sku'] == 1){
					if(isset($navigations['assoc'][$info['Category']['parent_id']])){
							$info_url = str_replace(" ","-",$info['CategoryI18n']['name']);
							$info_url = str_replace("/","-",$info_url);
							$info_url_2 = str_replace(" ","-",$navigations['assoc'][$info['Category']['parent_id']]['CategoryI18n']['name']);
							$info_url_2 = str_replace("/","-",$info_url_2);	
							if($navigations['assoc'][$info['Category']['parent_id']]['Category']['parent_id'] >0 && isset($navigations['assoc'][$navigations['assoc'][$info['Category']['parent_id']]['Category']['parent_id']])){
								$info_url_3 = str_replace(" ","-",$navigations['assoc'][$navigations['assoc'][$info['Category']['parent_id']]['Category']['parent_id']]['CategoryI18n']['name']);
								$info_url_3 = str_replace("/","-",$info_url_3);	
								$this->navigations[] = array('name'=>$navigations['assoc'][$navigations['assoc'][$info['Category']['parent_id']]['Category']['parent_id']]['CategoryI18n']['name'],'url'=>"/categories/".$navigations['assoc'][$navigations['assoc'][$info['Category']['parent_id']]['Category']['parent_id']]['Category']['id']."/".$info_url_2."/".$info_url);
							}
					}
					$this->navigations[] = array('name'=>$navigations['assoc'][$info['Category']['parent_id']]['CategoryI18n']['name'],'url'=>"/categories/".$navigations['assoc'][$info['Category']['parent_id']]['Category']['id']."/".$info_url_2."/".$info_url);
					$this->navigations[] = array('name'=>$info['CategoryI18n']['name'],'url'=>"/categories/".$info['Category']['id']."/".$info_url."/0");

				}else{
					if(isset($navigations['assoc'][$info['Category']['parent_id']])){
							if($navigations['assoc'][$info['Category']['parent_id']]['Category']['parent_id'] >0 && isset($navigations['assoc'][$navigations['assoc'][$info['Category']['parent_id']]['Category']['parent_id']])){
								$this->navigations[] = array('name'=>$navigations['assoc'][$navigations['assoc'][$info['Category']['parent_id']]['Category']['parent_id']]['CategoryI18n']['name'],'url'=>"/categories/".$navigations['assoc'][$navigations['assoc'][$info['Category']['parent_id']]['Category']['parent_id']]['Category']['id']);
							}
						$this->navigations[] = array('name'=>$navigations['assoc'][$info['Category']['parent_id']]['CategoryI18n']['name'],'url'=>"/categories/".$navigations['assoc'][$info['Category']['parent_id']]['Category']['id']);
						$this->navigations[] = array('name'=>$info['CategoryI18n']['name'],'url'=>"/categories/".$info['Category']['id']);
					}
				}
			}
	//		pr($this->navigations);
			$this->set('locations',$this->navigations);

			if(empty($rownum)){
				$rownum=isset($this->configs['products_category_page_size']) ? $this->configs['products_category_page_size']:((!empty($rownum)) ?$rownum:20);
			}
			if(empty($showtype)){
				$showtype=isset($this->configs['products_list_showtype']) ? $this->configs['products_list_showtype']:((!empty($showtype)) ?$showtype:'L');
			}
			if(empty($orderby)){
		 		$orderby=isset($this->configs['products_category_page_orderby_type'])? $this->configs['products_category_page_orderby_type']." ". $this->configs['products_category_page_orderby_method'] :((!empty($orderby)) ?$orderby:'created '.$this->configs['products_category_page_orderby_method']);
			}

		//	pr($this->configs['products_category_page_orderby_method']);
			$this->Product->set_locale($this->locale);
		//	该分类下面的所有商品和该分类下的商品的多语言,以及分页
			$category_ids =$this->Category->allinfo['subids'][$id];
			
			/*
			$category_new_products = $this->Product->find('all',array(
			'conditions'=>array("Product.category_id"=>$category_ids,'Product.status'=>1,'Product.forsale' =>'1')
			'order'=>'Product.'
			));
			
			
			*/			
			
			$sortClass='Product';
			$page=1;
			$parameters=Array($orderby,$rownum,$page);
			$options=Array();
			//pr($category_ids);
			$product_ranks = $this->ProductRank->findall_ranks();
			if(isset($_SESSION['User']['User'])){
				$user_rank_list=$this->UserRank->findrank();		
			}
			/*******************    属性   ********************/
			//$condition = "Product.category_id in (".implode(',',$category_ids).") and Product.status ='1' and Product.forsale = '1'";
			$condition = array("Product.category_id"=>$category_ids,'Product.status'=>1,'Product.forsale' =>'1');

			
			$products_screening=$this->Product->findAll($condition,'',"Product.$orderby","$rownum",$page);
			$brand_lists = array();
			foreach($products_screening as $k=>$v){
				if($v['Product']['brand_id']> 0 && !in_array($v['Product']['brand_id'],$brand_lists)){
					$brand_lists[] = $v['Product']['brand_id'];
				}
			}		
			$all_product_id = array();
			$all_product = $this->Product->findAll($condition,'',"Product.$orderby","$rownum");
		//	pr(sizeof($all_product));
			if(is_array($all_product) && sizeof($all_product)>0){
				foreach($all_product as $k=>$v){
					$all_product_id[] = $v['Product']['id'];
				}
			}
			$category_filter = $this->CategoryFilter->findall("CategoryFilter.status = '1' and CategoryFilter.category_id =".$id);
			//pr($category_filter);
			$product_attribute_list = array();
			$filter_price_list = array();
			$price_arr = array();
			$product_attribute_list[] =0;
			if(is_array($category_filter) && sizeof($category_filter) > 0){
				foreach($category_filter as $k=>$v){
					// 分出 商品属性
					if($v['CategoryFilter']['product_attribute'] != ""){
						$product_attribute = explode(";",$v['CategoryFilter']['product_attribute']);
						if(is_array($product_attribute) && sizeof($product_attribute)>0){
							foreach($product_attribute as $key=>$val){
								if(!in_array($val,$product_attribute_list)){
									$product_attribute_list[] = $val;
								}
							}
						}
					}//end
					
					// 商品价格区间
					if($v['CategoryFilter']['filter_price'] != ""){
						$price_arrs = explode(";",$v['CategoryFilter']['filter_price']);
						if(is_array($price_arrs) && sizeof($price_arrs)>0){
							foreach($price_arrs as $h=>$p){
								$price_arr[] = $p;
							}
						}
					}
				}
			}
			$this->ProductType->set_locale($this->locale);
			$product_types= $this->ProductType->find('all',array('conditions'=>array('ProductType.id'=>$product_attribute_list)));
			
			$this->ProductTypeAttribute->set_locale($this->locale);
			$product_type_attributes = $this->ProductTypeAttribute->find('all',array('conditions'=>array('ProductTypeAttribute.product_type_id'=>$product_attribute_list)));
			$product_type_attributes_list = array();
			if(isset($product_type_attributes) && sizeof($product_type_attributes)>0){
				foreach($product_type_attributes as $k=>$v){
					$product_type_attributes_list[$v['ProductTypeAttribute']['product_type_id']][] = $v;
				}
			}
			$this->set('price_arr',$price_arr);	
			$this->set('product_type_attributes_list',$product_type_attributes_list);	
			$this->set('product_types',$product_types);			
		
			/***************************************/
		
			if($brand > 0){
				$condition['Product.brand_id'] = $brand;
			}
	//		$price_max =0,$price_min =0
			if($price_max > 0){
				$condition['Product.shop_price >='] = $price_min;
				$condition['Product.shop_price <='] = $price_max;
			}
			if($filters != ""){
				$type_attribute_ids = array();
				$filter_arrs =  explode(".",$filters);
				foreach($filter_arrs as $k=>$v){
					if($v == '0' && isset($product_type_attributes_list[$product_types[$k]['ProductType']['id']]) && sizeof($product_type_attributes_list[$product_types[$k]['ProductType']['id']])>0){
						foreach($product_type_attributes_list[$product_types[$k]['ProductType']['id']] as $kk=>$vv){
							$type_attribute_ids[] = $vv['ProductTypeAttribute']['id'];
						}
					}else{
						$type_attribute_ids[] = $v;
					}
				}
		//		$condition .= " and  ProductAttribute.product_id = Product.id and ProductAttribute.id in (".implode(',',$type_attribute_ids).")";
//all_product_id
			$product_attribute_sql =  array('ProductAttribute.product_id'=>$all_product_id,'ProductAttribute.id'=>$type_attribute_ids);
		    $all_product_attribute =  $this->ProductAttribute->find('all',array('conditions'=>$product_attribute_sql));
		    $all_product_attribute_pid = array();
		    if(isset($all_product_attribute) && sizeof($all_product_attribute)>0){
		    	foreach($all_product_attribute as $k=>$v){
		    		$all_product_attribute_pid[] = $v['ProductAttribute']['product_id'];
		    	}
		    }
			$condition['Product.id'] = $all_product_attribute_pid;
			}
			
			
			$products=$this->Product->find('all',array(
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
			  
			  
			  
			  
			  
			  
			  
			  
			  		
			//$products=$this->Product->findAll($condition,'',"Product.$orderby","$rownum",$page);
			$total = count($products);
			$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass); // Added 
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
							
				
		//		$category_info = $this->ProductsCategory->find('ProductsCategory.product_id ='.$v['Product']['id'].' and ProductsCategory.category_id ='.$v['Product']['category_id']);
			//	$products[$k]['ProductsCategory'] = $category_info['ProductsCategory'];
				if(isset($product_category_lists[$v['Product']['id']])){
					$products_list[$k]['ProductsCategory'] = $product_category_lists[$v['Product']['id']]['ProductsCategory'];
				}
				
				if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
					$products[$k]['ProductI18n']['name'] = $this->Product->sub_str($products[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
				}
			//	$products[$k]['Product']['shop_price'] =$this->Product->locale_price($v['Product']['id'],$v['Product']['shop_price'],$this);
			//	$products[$k]['Product']['user_price'] =$this->Product->user_price($k,$v,$this);
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

				if($this->Product->is_promotion($v)){
					$products[$k]['Product']['shop_price'] = $v['Product']['promotion_price'];
				}
			}
		    
			$this->set('products',$products);
			/********************   商品分类 筛选功能   ********************/

			if($filters == ""){
				$num = count($product_types);
				if($num > 0){
					for($i=0;$i<$num;$i++){
						$filters .= "0";
						if($i+1 != $num){
							$filters .=".";
						}
					}
				}
			}
			$this->Brand->set_locale($this->locale);
			$brands = $this->Brand->find('all',array('conditions'=>array('Brand.id'=>$brand_lists)));
			$this->set('brands',$brands);
		   	$this->set('filters',$filters);
			/*******************         End       *************************/
			
			$this->Flash->set_locale($this->locale);
			$this->set('flashes',$this->Flash->find("type ='PC' and type_id='$id' ")); //flash轮播
			
			$this->set('id',$id);
			$this->set('type','P');
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
		//排序方式,显示方式,分页数量限制
		$this->set('orderby',$orderby);
		$this->set('rownum',$rownum);
		$this->set('showtype',$showtype);
 	}
 	
}
?>