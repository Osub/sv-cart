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
 * $Id: categories_controller.php 5261 2009-10-21 08:30:19Z huangbo $
*****************************************************************************/

class CategoriesController extends AppController {

	var $name = 'Categories';
    var $components = array ('Pagination','Cookie'); // Added
    var $helpers = array('html','Pagination','Flash');
    var $uses = array('Category','Comment','Product','Flash','ProductsCategory','UserRank','ProductI18n','ProductRank','ProductLocalePrice','CategoryFilter','ProductType','ProductTypeAttribute','ProductAttribute'); 
	var $cacheQueries = true;
	var $cacheAction = "1 hour";
	
	function view($id,$name1=0,$name2 = 0,$page=1,$orderby=0,$rownum=0,$showtype=0,$brand =0,$price_min =0,$price_max =0,$filters = '00',$keyword=''){
		$orderby = UrlDecode($orderby);
		$rownum = UrlDecode($rownum);
		$showtype = UrlDecode($showtype);
		$keyword = UrlDecode($keyword);
		$this->data['page_category_name'] = $name1;
		$this->data['ad_keyword'] = $keyword;
		if($brand > 0){
			$this->Brand->set_locale($this->locale);
			$filter_brand_name = $this->Brand->find(array('Brand.id'=>$brand));
			//pr();
		}
		$this->set('brand',$brand);
		$this->data['ideal_orderby'] = $orderby;
		$this->set('price_max',$price_max);
		$this->set('price_min',$price_min);
		$this->data['showtype_page'] = 'L';
	//	Configure::write('debug', 0);
		$this->page_init();
		$flag = 1;
    	$this->set('rss_id',$id);
		if($filters != '00'){
			$filters_arr = explode('.',$filters);
			$filters_select = 0;
			if(isset($filters_arr) && sizeof($filters_arr)>0){
				foreach($filters_arr as $k=>$v){
					if($v > 0){
						$filters_select++;
					}
				}
			}
			if($filters_select == 0){
				$filters = '00';
			}
		}
		$this->data['pagination_brand'] = $brand;
		$this->data['price_min'] = $price_min;
		$this->data['price_max'] = $price_max;	
		$this->data['to_page_id'] = $id;
		if(!isset($_GET['page'])){
			$_GET['page'] = $page;
		}else{
			$page = $_GET['page'];
		}
		$this->data['get_page'] = $_GET['page'];
				
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
			if($this->configs['category_link_type'] == 1){
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
			$this->set('category_info',$info);
			$navigations = $this->Category->tree('P',0,$this->locale,$this);
		  	if(isset($navigations['assoc'][$info['Category']['id']])){
		  		$categorys = $navigations['assoc'][$info['Category']['id']];
			    //找顶级分类
			    if($categorys['Category']['parent_id'] >0){
			    	if(isset($navigations['assoc'][$categorys['Category']['parent_id']])){
			    		if($navigations['assoc'][$categorys['Category']['parent_id']]['Category']['parent_id'] >0){
			    			if(isset($navigations['assoc'][$navigations['assoc'][$categorys['Category']['parent_id']]['Category']['parent_id']])){
			    				$sub_category_id = $navigations['assoc'][$categorys['Category']['parent_id']]['Category']['parent_id'];
			    			}
			    		}else{
			    			$sub_category_id = $categorys['Category']['parent_id'];
			    		}
			    	}
			    }else{
			    	$sub_category_id = $info['Category']['id'];
			    }
		  	}
	  		$this->set('sub_category_id',$sub_category_id);			
			
			$this->set('meta_description',$info['CategoryI18n']['meta_description']);
			$this->set('meta_keywords',$info['CategoryI18n']['meta_keywords']);
			
			$this->pageTitle = $info['CategoryI18n']['name']." - ".$this->configs['shop_title'];
			$this->set('CategoryI18n_name',$info['CategoryI18n']['name']);
			//当前位置
			//pr($navigations);
			$sub_category = $this->Category->cache_find('all',array('conditions'=>array('Category.status'=>1,'Category.parent_id'=>$id,'Category.type'=>'P')),'sub_category_'.$id."_".$this->locale);
			$this->Product->set_locale($this->locale);
			if(isset($sub_category) && sizeof($sub_category)>0){
				foreach($sub_category as $k=>$v){
					$sub_category[$k]['products'] = $this->Product->cache_find('all',array('conditions'=>array('Product.status'=>1,'Product.alone' => '1','Product.forsale' => '1','Product.recommand_flag' => '1','Product.category_id'=>$v['Category']['id']),'limit'=>4,'fields'=>array('Product.id','Product.shop_price','Product.img_thumb','ProductI18n.name','Product.code','Product.market_price'),'order'=>'Product.created DESC'),'sub_category_product_'.$v['Category']['id']."_".$this->locale);
				}
			}
			//pr($sub_category);exit;
			$this->set('sub_category',$sub_category);
			/*	foreach($navigations['subids'][$id] as $k=>$v){
					if($v != $id){
						$sub_category[] = $navigations['assoc'][$v];
					}
				}*/
			//pr($sub_category);

			if($info['Category']['parent_id'] == 0){
				if($this->configs['category_link_type'] == 1){
					$info_url = str_replace(" ","-",$info['CategoryI18n']['name']);
					$info_url = str_replace("/","-",$info_url);
					$this->navigations[] = array('name'=>$info['CategoryI18n']['name'],'url'=>"/categories/".$info['Category']['id']."/".$info_url."/0");
				}else{
					$this->navigations[] = array('name'=>$info['CategoryI18n']['name'],'url'=>"/categories/".$info['Category']['id']);
				}
			}

			if($info['Category']['parent_id'] > 0){
				if($this->configs['category_link_type'] == 1){
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
			if(isset($filter_brand_name['BrandI18n']['name'])){
				$this->navigations[] = array('name'=>$filter_brand_name['BrandI18n']['name'],'url'=>$this->server_host.$this->cart_webroot.$this->params['url']['url']);
			}
			//		pr($this->navigations);
			$this->set('locations',$this->navigations);

			if(empty($rownum) && $rownum == 0){
				$rownum=isset($this->configs['products_category_page_size']) ? $this->configs['products_category_page_size']:((!empty($rownum)) ?$rownum:20);
			}
			if(empty($showtype) && $showtype == 0){
				$showtype=isset($this->configs['products_list_showtype']) ? $this->configs['products_list_showtype']:((!empty($showtype)) ?$showtype:'L');
			}
			if(empty($orderby) && $orderby == 0){
		 		$orderby=isset($this->configs['products_category_page_orderby_type'])? "Product.".$this->configs['products_category_page_orderby_type']." ". $this->configs['products_category_page_orderby_method'] :((!empty($orderby)) ?$orderby:'Product.created '.$this->configs['products_category_page_orderby_method']);
			
			}
			
			if($rownum == 'all'){
				$rownum_sql = 99999;
			}else{
				$rownum_sql = $rownum;
			}
			
			
			$this->data['orderby'] = $orderby;
			$this->data['rownum'] = $rownum;
			$this->data['showtype'] = $showtype;
		//	pr($this->configs['products_category_page_orderby_method']);
			$this->Product->set_locale($this->locale);
		//	该分类下面的所有商品和该分类下的商品的多语言,以及分页
			$category_ids =$this->Category->allinfo['subids'][$id];
			$cache_key = md5('category_new_products'.'_'.$this->locale.'_'.$category_ids);
			$category_new_products = cache::read($cache_key);	
			if(!$category_new_products){				
				$category_new_products = $this->Product->find('all',array(
				'conditions'=>array("Product.category_id"=>$category_ids,'Product.status'=>1,'Product.forsale' =>'1'),
				'order'=>'Product.created',
				'fields' =>	array('Product.id','Product.img_thumb'
											,'Product.market_price'
											,'Product.shop_price'
											,'Product.quantity'
											,'Product.code','ProductI18n.name'
								)	
				,'limit'=>8
				));
			}
			$cache_key = md5('category_recommand_products'.'_'.$this->locale.'_'.$category_ids);
			$category_recommand_products = cache::read($cache_key);	
			if(!$category_recommand_products){			
				$category_recommand_products = $this->Product->find('all',array(
				'conditions'=>array("Product.category_id"=>$category_ids,'Product.status'=>1,'Product.forsale' =>'1','Product.recommand_flag' =>'1'),
				'order'=>'Product.created',
				'fields' =>	array('Product.id','Product.img_thumb'
											,'Product.market_price'
											,'Product.shop_price'
											,'Product.quantity'
											,'Product.code','ProductI18n.name'
								)	
				,'limit'=>8
				));
			}
			//热卖商品
			$cache_key = md5('category_hot_products'.'_'.$this->locale.'_'.$category_ids);
			$category_hot_products = cache::read($cache_key);	
			if(!$category_hot_products){			
				$category_hot_products = $this->Product->find('all',array(
				'conditions'=>array("Product.category_id"=>$category_ids,'Product.status'=>1,'Product.forsale' =>'1','Product.recommand_flag' =>'1'),
				'order'=>'Product.sale_stat DESC',
				'fields' =>	array('Product.id','Product.img_thumb'
											,'Product.market_price'
											,'Product.shop_price'
											,'Product.quantity'
											,'Product.code','ProductI18n.name'
								)	
				,'limit'=>8
				));
			}			
			//最多浏览商品
			$cache_key = md5('category_veiw_products'.'_'.$this->locale.'_'.$category_ids);
			$category_veiw_products = cache::read($cache_key);	
			if(!$category_veiw_products){			
				$category_veiw_products = $this->Product->find('all',array(
				'conditions'=>array("Product.category_id"=>$category_ids,'Product.status'=>1,'Product.forsale' =>'1','Product.recommand_flag' =>'1'),
				'order'=>'Product.view_stat DESC',
				'fields' =>	array('Product.id','Product.img_thumb'
											,'Product.market_price'
											,'Product.shop_price'
											,'Product.quantity'
											,'Product.code','ProductI18n.name'
								)	
				,'limit'=>8
				));
			}				
			
			if(isset($category_veiw_products) && sizeof($category_veiw_products)>0){
				foreach($category_veiw_products as $k=>$v){
					if(isset($category_veiw_products[$k]['ProductI18n']['name']) &&isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
						$category_veiw_products[$k]['ProductI18n']['sub_name'] = $this->Product->sub_str($category_veiw_products[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
					}else{
						$category_veiw_products[$k]['ProductI18n']['sub_name'] = $category_veiw_products[$k]['ProductI18n']['name'];
					}
				}
			}			
			
			if(isset($category_hot_products) && sizeof($category_hot_products)>0){
				foreach($category_hot_products as $k=>$v){
					if(isset($category_hot_products[$k]['ProductI18n']['name']) &&isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
						$category_hot_products[$k]['ProductI18n']['sub_name'] = $this->Product->sub_str($category_hot_products[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
					}else{
						$category_hot_products[$k]['ProductI18n']['sub_name'] = $category_hot_products[$k]['ProductI18n']['name'];
					}
				}
			}			
			
			if(isset($category_new_products) && sizeof($category_new_products)>0){
				foreach($category_new_products as $k=>$v){
					if(isset($category_new_products[$k]['ProductI18n']['name']) &&isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
						$category_new_products[$k]['ProductI18n']['sub_name'] = $this->Product->sub_str($category_new_products[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
					}else{
						$category_new_products[$k]['ProductI18n']['sub_name'] = $category_new_products[$k]['ProductI18n']['name'];
					}
				}
			}
			
			if(isset($category_recommand_products) && sizeof($category_recommand_products)>0){
				foreach($category_recommand_products as $k=>$v){
					if(isset($category_recommand_products[$k]['ProductI18n']['name']) &&isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
						$category_recommand_products[$k]['ProductI18n']['sub_name'] = $this->Product->sub_str($category_recommand_products[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
					}else{
						$category_recommand_products[$k]['ProductI18n']['sub_name'] = $category_recommand_products[$k]['ProductI18n']['name'];
					}
				}
			}			
			
			$this->data['category_veiw_products'] = $category_veiw_products;
			$this->set('category_veiw_products',$category_veiw_products);
			$this->data['category_hot_products'] = $category_hot_products;
			$this->data['category_new_products'] = $category_new_products;
			$this->data['category_recommand_products'] = $category_recommand_products;
			$this->set('category_hot_products',$category_hot_products);
			$this->set('category_new_products',$category_new_products);
			$this->set('category_recommand_products',$category_recommand_products);

			$sortClass='Product';
			$page=1;
			$parameters=Array($orderby,$rownum_sql,$page);
			$options=Array();
			//pr($category_ids);
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
			/*******************    属性   ********************/
		//	exit;
			if($this->configs['screening_setting'] == 1){
				$cache_key = md5('category_filter'.'_'.$this->locale.'_'.$id);
				$category_filter = cache::read($cache_key);	
				if(!$category_filter){						
					$category_filter = $this->CategoryFilter->findall("CategoryFilter.status = '1' and CategoryFilter.category_id =".$id);
				}
			}
			//$condition = "Product.category_id in (".implode(',',$category_ids).") and Product.status ='1' and Product.forsale = '1'";
			$condition = array("Product.category_id"=>$category_ids,'Product.status'=>1,'Product.forsale' =>'1');
			$product_condition = $condition;
			if(isset($category_filter) && sizeof($category_filter)>0){			
		//	$products_screening=$this->Product->find('list',array('fields'=>'Product.brand_id','conditions'=>array($condition) ,'order'=>$orderby,'limit'=>$rownum_sql,'page'=>$page));
			$brand_lists = array();
		
	//		$all_product_id = array();
		/*	$all_product = $this->Product->find('list',array('fields'=>'Product.id','conditions'=>array($condition) ,'order'=>$orderby));
			foreach($all_product as $k=>$v){
				if($v> 0 && !in_array($v,$brand_lists)){
					$brand_lists[] = $v;
				}
			}	*/
	/*		
		//	pr(sizeof($all_product));
			if(is_array($all_product) && sizeof($all_product)>0){
				foreach($all_product as $k=>$v){
					$all_product_id[] = $v;
				}
			}*/
			
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

		//	pr($product_attribute_list);
			$this->ProductTypeAttribute->set_locale($this->locale);
		
			$cache_key = md5('product_type_attributes_c'.'_'.$this->locale.'_'.$product_attribute_list);
			$product_type_attributes_list = cache::read($cache_key);	
			if(!$product_type_attributes_list){									
			//	$product_type_attributes = $this->ProductTypeAttribute->find('all',array('conditions'=>array('ProductTypeAttribute.product_type_id'=>$product_attribute_list)));
				$product_type_attributes = $this->ProductTypeAttribute->find('all',array('conditions'=>array('ProductTypeAttribute.id'=>$product_attribute_list)));
				
				
				if(isset($product_type_attributes) && sizeof($product_type_attributes)>0){
					$product_type_attributes_formate = array();
					foreach($product_type_attributes as $k=>$v){
						$product_type_attributes_id[] = $v['ProductTypeAttribute']['id'];
						$product_type_attributes_formate[$v['ProductTypeAttribute']['id']] = $v;
					}
					$condition = array(
										'ProductAttribute.product_type_attribute_id'=>$product_type_attributes_id
										);
				//	if(!empty($all_product_id)){
						$condition['Product.category_id'] = $category_ids;
				//	}
					$condition['Product.status'] = 1;
					$condition['Product.forsale'] = 1;
					 $this->ProductAttribute->bindModel(array(
						 'hasOne' => array(
						 'Product' => array(
						 'className' => 'Product',
						 'foreignKey' => false,
						 'conditions' => array('ProductAttribute.product_id = Product.id')
						 ))));
					
				//	$this->ProductAttribute->Product->bindModel(array('belongsTo'=>array('ProductAttribute','Product')));
			//		$joinRecords = $this->ProductAttribute->Product->findAll(array('Product.category_id' => $category_ids));
					
					$product_attribute_array_list =  $this->ProductAttribute->find('all',array('conditions'=>$condition,'group'=>array('ProductAttribute.product_type_attribute_value','ProductAttribute.product_type_attribute_id'),'fields'=>array('ProductAttribute.product_type_attribute_value','ProductAttribute.product_type_attribute_id')));
					$product_attribute_array = array();
					if(isset($product_attribute_array_list) && sizeof($product_attribute_array_list)){
						foreach($product_attribute_array_list as $k=>$v){
							$product_attribute_array[$v['ProductAttribute']['product_type_attribute_id']][] = $v['ProductAttribute']['product_type_attribute_value'];
						}
					}
					
				//	pr(Configure::read("database"));
					
					$product_type_attribute_list = array();
					if(isset($product_attribute_array) && sizeof($product_attribute_array)>0){
							$mun = 0;
						foreach($product_attribute_array as $k=>$v){
							if(isset($product_type_attributes_formate[$k]) && sizeof($v)>0){
								foreach($v as $kk=>$vv){
									$product_type_attribute_list[$mun]=$product_type_attributes_formate[$k];
									$product_type_attribute_list[$mun]['ProductAttribute']['product_type_attribute_value'] = $vv;
									$product_type_attribute_list[$mun]['ProductAttribute']['id'] = $kk;
									$mun ++;
								}
							}
						}
					}
					
				}				
				
				
				$product_type_attributes_list = array();
				$product_types_ids = array();
				$ProductTypeAttribute_id = array();
				$product_attribute_arr = array();
				$product_attribute_arr_filter = array();
				if(isset($product_type_attribute_list) && sizeof($product_type_attribute_list)>0){
					foreach($product_type_attribute_list as $k=>$v){
						/*****bug 修改*****/
						if(!in_array($v['ProductAttribute']['product_type_attribute_value'],$product_attribute_arr_filter)){
							$product_attribute_arr[$v['ProductTypeAttributeI18n']['name']][$v['ProductAttribute']['id']] = $v['ProductAttribute']['product_type_attribute_value'];
							$product_attribute_arr_filter[] = $v['ProductAttribute']['product_type_attribute_value'];
						}
						/******************/
					}
				}
			}	
			$cache_key = md5('product_types_c'.'_'.$this->locale.'_'.$product_attribute_list);
			$product_types = cache::read($cache_key);	
			if(!$product_types){									
				$product_types= $this->ProductType->find('all',array('conditions'=>array('ProductType.id'=>$product_types_ids)));
			}		
		//	pr($product_attribute_arr);
			$this->set('product_attribute_arr',$product_attribute_arr);
			$this->data['price_arr'] = $price_arr;
			$this->set('price_arr',$price_arr);	
			$this->set('product_type_attributes_list',$product_type_attributes_list);	
			$this->set('product_types',$product_types);			
			}
			/***************************************/
	//		$condition = array();
			$condition = array("Product.category_id"=>$category_ids,'Product.status'=>1,'Product.forsale' =>'1');
			if($brand > 0){
				$condition['Product.brand_id'] = $brand;
			}
	//		$price_max =0,$price_min =0
			if($price_max > 0){
				$condition['Product.shop_price >='] = $price_min;
				$condition['Product.shop_price <='] = $price_max;
			}

			if($keyword != ""){
				$condition_18n['OR'][] = "Product.code like '%$keyword%' ";
	    		$product_pid = $this->Product->find('list',array('conditions'=>array($condition_18n),'fields'=>array('Product.id')));
	    		$condition_p18n['OR'][] = "ProductI18n.name like '%$keyword%' ";
				$condition_p18n['OR'][] = "ProductI18n.description like '%$keyword%' ";
	    		$product18n_pid = $this->ProductI18n->find('list',array('conditions'=>array($condition_p18n),'fields'=>array('ProductI18n.product_id')));
	    		$product18n_pid = array_unique($product18n_pid+$product_pid);
				$condition['Product.id'] = $product18n_pid;				
			}
			
			$product_attribute_arr_f = array();
			if(isset($product_attribute_arr) && sizeof($product_attribute_arr)>0){
				$list_key = 0;
				foreach($product_attribute_arr as $k=>$v){
					$product_attribute_arr_f[$list_key]=$v;
					$list_key++;
				}
			}
			if($filters != "00"){
				$product_attribute_ids = array();
				$filter_arrs =  explode(".",$filters);
				foreach($filter_arrs as $k=>$v){
					if($v == '0' && isset($product_attribute_arr_f[$k]) && sizeof($product_attribute_arr_f[$k])>0){
						foreach($product_attribute_arr_f[$k] as $kk=>$vv){
					//		$product_attribute_ids[] = $kk;
						}
					}else{
						$product_attribute_ids[] = $v;
					}
				}
		//		pr($product_attribute_ids);
			$product_attribute_sql =  array('ProductAttribute.id'=>$product_attribute_ids);
		   //'ProductAttribute.product_id'=>$all_product_id,
		   
		    $all_product_attribute =  $this->ProductAttribute->find('all',array('conditions'=>$product_attribute_sql));
		    $all_product_attribute_pid = array();
		    $all_product_attribute_names = array();
		    if(isset($all_product_attribute) && sizeof($all_product_attribute)>0){
		    	foreach($all_product_attribute as $k=>$v){
		    		$all_product_attribute_names[] = $v['ProductAttribute']['product_type_attribute_value'];
		    		//$all_product_attribute_pid[] = $v['ProductAttribute']['product_id'];
		    	}
		    }
		    	//pr($all_product_attribute_names);
		    	
		    //	if(isset($all_product_id)){
		    
					 $this->ProductAttribute->bindModel(array(
						 'hasOne' => array(
						 'Product' => array(
						 'className' => 'Product',
						 'foreignKey' => false,
						 'conditions' => array('ProductAttribute.product_id = Product.id')
						 ))));
		    
		   	    	$all_product_attributes =  $this->ProductAttribute->find('all',array('conditions'=>array('Product.category_id'=>$category_ids,'Product.status'=>1,'Product.forsale'=>1,'ProductAttribute.product_type_attribute_value'=>$all_product_attribute_names),'group'=>'ProductAttribute.product_type_attribute_value','fields'=>array('ProductAttribute.product_type_attribute_value','ProductAttribute.product_id')));
		 	//	}
		 //		 pr($all_product_attributes);
		 		 $all_product_attributes_list = array();
		 		 if(isset($all_product_attributes) && sizeof($all_product_attributes)>0){
		 		 	foreach($all_product_attributes as $k=>$v){
		 		 		$all_product_attributes_list[$v['ProductAttribute']['product_id']][] = $v['ProductAttribute']['product_type_attribute_value'];
		 		 	}
		 		 }
		 		 $ids = array();
		 		 $ids[] = 0;
		 		 if(isset($all_product_attributes_list) && sizeof($all_product_attributes_list)>0){
		 		 	foreach($all_product_attributes_list as $k=>$v){
		 		 		if(sizeof($v) == sizeof($all_product_attribute_names)){
		 		 			$ids[] = $k;
		 		 		}
		 		 	}
		 		 }
		 		 
		  	//	exit;
		  // 	pr($all_product_attribute_names);
				$condition['Product.id'] = $ids;
			}
			$condition['Product.bestbefore'] = 0;
		//	pr($condition);
			$cache_key = md5('category_view_total'.'_'.$this->locale.'_'.$condition);
		//	$total = cache::read($cache_key);	
		//	if(!$total){
				$total = $this->Product->cache_find('count',array('fields' => 'DISTINCT Product.id',	'recursive' => -1,'conditions'=>array($condition)),"Product_find_total_categories_view_".$this->locale);
				$this->data['page_total'] = $total;
		//		cache::write($cache_key,$total);	
		//	}
			list($page) = $this->Pagination->init($condition,$parameters,$options,$total,$rownum_sql,$sortClass); // Added 
		//	pr($condition);exit;
			$products=$this->Product->find('all',array(
														//	'recursive' => -1,
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
																				,'Product.quantity'
																				),			
			'conditions'=>array($condition),'order'=>array($orderby),'limit'=>$rownum_sql,'page'=>$page));
			
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
		
		// 分类下商品的评论
		if(!empty($products_ids_list)){
			$comments = $this->Comment->cache_find('all',array('conditions'=>array('Comment.type'=>'P','Comment.type_id'=>$products_ids_list),'status'=>1,'limit'=>5),"Comment_categories_prodcut_".$this->locale);
			$this->set('comments',$comments);
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
			  			  
			  
		 //   $this->Category->set_locale($this->locale);						
		//	$category_lists = $this->Category->find_all($this->locale);
			$this->set('categories',$navigations['assoc']);	//$navigations		

			  
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
					$products[$k]['ProductI18n']['sub_name'] = $this->Product->sub_str($products[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
				}else{
					$products[$k]['ProductI18n']['sub_name'] = $products[$k]['ProductI18n']['name'];
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
			
		    $this->data['product_ranks'] = $product_ranks;
			$this->data['products'] = $products;	  		    
			$this->set('products',$products);
			/********************   商品分类 筛选功能   ********************/
			
			if($filters == "00" && isset($product_attribute_arr)){
				$num = count($product_attribute_arr);
				$filters = "";
				if($num > 0){
					for($i=0;$i<$num;$i++){
						$filters .= "0";
						if($i+1 != $num){
							$filters .=".";
						}
					}
				}
			}
			$this->data['page_filters'] = $filters;	
		   	$this->set('filters',$filters);
		//	if(isset($brand_lists)){
			$this->Brand->set_locale($this->locale);
			
			 $this->Brand->bindModel(array(
				 'hasOne' => array(
					 'Product' => array(
					 'className' => 'Product',
					 'foreignKey' => false,
					 'conditions' => array('Brand.id = Product.brand_id')
					)/*,
					 'ProductI18n' => array(
					 'className' => 'ProductI18n',
					 'foreignKey' => false,
					 'conditions' => array('ProductI18n.product_id = Product.id',"ProductI18n.locale = '".$this->locale."'")
					)*/
			 	)));
			$product_condition['Brand.id <>']= 0;
			$product_condition['Brand.status']= 1;
			
			$brands = $this->Brand->find('all',array('conditions'=>array($product_condition),'fields'=>array('Brand.id','BrandI18n.name'),'group'=>array('Brand.id','BrandI18n.name')));
			//product_condition
			$this->set('view_brands',$brands);
	//		}
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
		
		if($this->data['configs']['category_link_type'] == 1){
				if(isset($this->data['parent'])){ 
				//	$this->data['pages_url_1']=$this->server_host.$this->cart_webroot.$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_parent']."/".$this->data['page_category_name']."/";
					$this->data['pages_url_1']=$this->server_host.$this->cart_webroot.$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_category_name']."/0/";
					$this->data['pages_url_1_type']=$this->server_host.$this->cart_webroot.$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_category_name']."/0/".$this->data['get_page']."/";
				}else{
					$this->data['pages_url_1_type']=$this->server_host.$this->cart_webroot.$this->params['controller']."/".$this->data['to_page_id']."/0/0/".$this->data['get_page']."/";
				}
			}else{
				$this->data['pages_url_1']=$this->server_host.$this->cart_webroot.$this->params['controller']."/".$this->data['to_page_id']."/0/0/";
				$this->data['pages_url_1_type']=$this->server_host.$this->cart_webroot.$this->params['controller']."/".$this->data['to_page_id']."/0/0/".$this->data['get_page']."/";
			}
    		$this->data['pages_url_2'] = "/".$this->data['orderby']."/".$this->data['rownum']."/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/".$this->data['ad_keyword']."/";
    		$this->data['pages_url_2_type'] = "/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
		if($this->configs['category_link_type'] == 1){
			if(isset($parent)){
				$mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_parent']."/".$this->data['page_category_name'];
			}else{
				$mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_category_name']."/0";
			}
		}else{
			$mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/0/0";
		}		
		
		$this->data['display_mode_url'] =$mode_url."/".$this->data['get_page']."/".$this->data['orderby']."/".$this->data['rownum']."/".$this->data['showtype']."/";

		//排序方式,显示方式,分页数量限制
		$this->set('orderby',$orderby);
		$this->set('rownum',$rownum);
		$this->set('showtype',$showtype);
		
		
		$size = 0;
		$tab_arr = array();
		$sign = "";
		if(isset($category_recommand_products) && sizeof($category_recommand_products)>0){
		$size ++;
		$tab_arr['products_recommand'] = $size;
		}
		if(isset($category_new_products) && sizeof($category_new_products)>0){
		$size ++;
		$tab_arr['products_newarrival'] = $size;
		}		
		

		if(isset($category_new_products) && sizeof($category_new_products)>0){
		$sign = "products_newarrival";
		}else		
		if(isset($category_recommand_products) && sizeof($category_recommand_products)>0){
		$sign = "products_recommand";
		}		
		$this->set('sign',$sign);
		$this->set('size',$size);
		$this->set('tab_arr',$tab_arr);
		$this->set('info',$info);
		
		// $this->data 赋值区
		
		$this->data['tab_arr'] = $tab_arr;
		$this->data['sign'] = $sign;
		$this->data['size'] = $size;
		$this->set('head_id',$id);
		
 	}
 	
 	function detail($id){
 	  	$this->page_init();
		    //当前位置  
		$this->navigations[] = array('name'=>$this->languages['promotion'].$this->languages['activity'],'url'=>"");
		$this->set('locations',$this->navigations);		
		$this->pageTitle = $this->languages['promotion'].$this->languages['activity']."- ".$this->configs['shop_title'];		
		$this->Category->set_locale($this->locale);
		$info=$this->Category->findbyid($id);
 		$this->set('info',$info);
 	}
 	
 	
}
?>