<?php
/*****************************************************************************
 * SV-Cart 商品明细
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: products_controller.php 5414 2009-10-26 01:45:58Z huangbo $
*****************************************************************************/
uses('sanitize');		
class ProductsController extends AppController {
	var $name = 'Products';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers = array('Html','Pagination','Flash','Cache','Time','Xml','Rss','Text'); // Added 
	var $uses = array('Product','ProductI18n','Flash','UserMessage','ProductsCategory','Category','CategoryFilter','ProductAlsobought','ProductGallery','ProductRelation','ProductArticle','Article','Comment','ProductType','UserRank','ProductRank','BookingProduct','Order','Brand','CouponType','ProductAttribute','ProductTypeAttribute','ProductShippingFee','Shipping','ShippingArea','ShippingAreaRegion','ProductLocalePrice','Tag','ProdcutVolume','OrderProduct','Order','UserProductGallerie','User','TagI18n');
//	var $cacheQueries = true;
//	var $cacheAction = "1 day";
	
    function view($id=""){
    	$this->cacheQueries = true;
    	$this->cacheAction = "1 day";
		if(isset($_GET['pu'])){
			$is_user = $this->User->findbyid($_GET['pu']);
			if(isset($is_user['User'])){
			//	$affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire'];
			//	$affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'];
				if( $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'] == "hour"){
					$save_time = $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire']*60*60;
				}
				if( $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'] == "day"){
					$save_time = $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire']*60*60*24;
				}
				if( $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'] == "week"){
					$save_time = $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire']*60*60*24*7;
				}
				$this->Cookie->write('affiliate_user_id',$_GET['pu'],false,time()+$save_time);
				$this->Cookie->write('affiliate_product_id',$id,false,time()+$save_time);			
			}
		}
    	
	//	Configure::write('debug', 0);
		if(!is_numeric($id) || $id<1){
			$this->flash($this->languages['invalid_id'],"/","","");
	    }
	    $this->full_page_init();
	    //商品详细
	    $this->Product->set_locale($this->locale);
	    $info = $this->Product->findbyid($id);
		
		$flat = "1";
	    if(empty($info)){
	       $this->pageTitle = $this->languages['products'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
		   $products_error = $this->Product->find('all',array('conditions'=>array('Product.status'=>1,'Product.forsale'=>1),'limit'=>5));
		   $this->set('products_error',$products_error);	    	       
		   $this->flash($this->languages['products'].$this->languages['not_exist'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"/","","");
		   $flat = "0";
	    }else if($info['Product']['status']!=1){
	       $this->pageTitle = $this->languages['products'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
			$products_error = $this->Product->find('all',array('conditions'=>array('Product.status'=>1,'Product.forsale'=>1),'limit'=>5));
			$this->set('products_error',$products_error);	       
	    	$this->flash($this->languages['products'].$this->languages['not_exist'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"/","","");
	    	$flat = "0";
	    }else if($info['Product']['forsale']!=1){
	        $this->pageTitle = $info['ProductI18n']['name'].":".$this->languages['product_out_of_sale']." - ".$this->configs['shop_title'];
	        if($info['Product']['category_id'] > 0){
				$navigations=$this->Category->tree('P',$info['Product']['category_id'],$this->locale,$this);
				$category_error =$this->Category->allinfo['subids'][$info['Product']['category_id']];
				$products_error = $this->Product->find('all',array('conditions'=>array('Product.category_id'=>$category_error,'Product.status'=>1,'Product.forsale'=>1),'limit'=>5));
				$this->set('products_error',$products_error);
	        }	        
	    	$this->flash($info['ProductI18n']['name'].":".$this->languages['product_out_of_sale'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"/","","");
	   		$flat = "0";
	    }
	    
	    if($flat == 1){
	    	
	    $sub_category_id = 0;
	    $this->Category->set_locale($this->locale);
		$navigations=$this->Category->tree('P',$info['Product']['category_id'],$this->locale,$this);
	//	pr($navigations);
	//	$categorys = $this->Category->findbyid($info['Product']['category_id']);
	  	if(isset($navigations['assoc'][$info['Product']['category_id']])){
	  		$categorys = $navigations['assoc'][$info['Product']['category_id']];
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
		    	$sub_category_id = $info['Product']['category_id'];
		    }
	  	}
	  	$this->set('sub_category_id',$sub_category_id);
	  	if($sub_category_id > 0){
	  		//找一级分类的属性
			$cache_key = md5('product_category_filter'.'_'.$this->locale.'_'.$sub_category_id);
			$category_filter = cache::read($cache_key);	
			if(!$category_filter){						
				$category_filter = $this->CategoryFilter->findall("CategoryFilter.status = '1' and CategoryFilter.category_id =".$sub_category_id);
			}	  		
			$category_subids =$this->Category->allinfo['subids'][$sub_category_id];
			$condition = array("Product.category_id"=>$category_subids,'Product.status'=>1,'Product.forsale' =>'1');

			if(isset($category_filter) && sizeof($category_filter)>0){			
		//	$brand_lists = array_unique($this->Product->find('list',array('fields'=>'Product.brand_id','conditions'=>array($condition))));
		//	if(isset($brand_lists)){
				
				$this->Brand->set_locale($this->locale);
				 $this->Brand->bindModel(array(
					 'hasOne' => array(
						 'Product' => array(
						 'className' => 'Product',
						 'foreignKey' => false,
						 'conditions' => array('Brand.id = Product.brand_id')
						),
						 'ProductI18n' => array(
						 'className' => 'ProductI18n',
						 'foreignKey' => false,
						 'conditions' => array('ProductI18n.product_id = Product.id',"ProductI18n.locale = '".$this->locale."'")
						)
				 	)));
				
				$brands = $this->Brand->find('all',array('conditions'=>array($condition),'fields'=>array('Brand.id','BrandI18n.name'),'group'=>array('Brand.id','BrandI18n.name')));
				$this->set('view_brands',$brands);
	//		}
			$product_condition = $condition;
		//	$all_product_id = $this->Product->find('list',array('fields'=>'Product.id','conditions'=>array($condition)));
			
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
				$product_type_attributes_id = array();
				if(isset($product_type_attributes) && sizeof($product_type_attributes)>0){
					$product_type_attributes_formate = array();
					foreach($product_type_attributes as $k=>$v){
						$product_type_attributes_id[] = $v['ProductTypeAttribute']['id'];
						$product_type_attributes_formate[$v['ProductTypeAttribute']['id']] = $v;
					}
					$condition = array(
										'ProductAttribute.product_type_attribute_id'=>$product_type_attributes_id
										);
			/*		if(!empty($all_product_id)){
						$condition['ProductAttribute.product_id'] = $all_product_id;
					}
			*/		
					 $this->ProductAttribute->bindModel(array(
						 'hasOne' => array(
						 'Product' => array(
						 'className' => 'Product',
						 'foreignKey' => false,
						 'conditions' => array('ProductAttribute.product_id = Product.id')
						 ))));						
					$product_condition['ProductAttribute.product_type_attribute_id'] = $product_type_attributes_id;
					$product_condition['ProductAttribute.product_type_attribute_value <>'] = '';
					
				//	$product_attribute_array =  $this->ProductAttribute->find('list',array('conditions'=>$product_condition,'fields'=>array('ProductAttribute.id','ProductAttribute.product_type_attribute_value','ProductAttribute.product_type_attribute_id')));
					//product_attribute_list
					$product_attribute_array_list =  $this->ProductAttribute->find('all',array('conditions'=>$product_condition,'group'=>array('ProductAttribute.product_type_attribute_value','ProductAttribute.product_type_attribute_id'),'fields'=>array('ProductAttribute.product_type_attribute_value','ProductAttribute.product_type_attribute_id')));
					$product_attribute_array = array();
					if(isset($product_attribute_array_list) && sizeof($product_attribute_array_list)){
						foreach($product_attribute_array_list as $k=>$v){
							$product_attribute_array[$v['ProductAttribute']['product_type_attribute_id']][] = $v['ProductAttribute']['product_type_attribute_value'];
						}
					}
					
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
		//			pr($product_attribute_array);exit;
				
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
			$this->set('product_attribute_arr',$product_attribute_arr);
			$this->data['price_arr'] = $price_arr;
			$this->set('price_arr',$price_arr);	
		//	$this->set('product_type_attributes_list',$product_type_attributes_list);	
		//	$this->set('product_types',$product_types);			
			}	  		
	  	}
	  	
	    if($info['Product']['brand_id'] > 0){
	    	$this->Brand->set_locale($this->locale);
	    	$product_brand = $this->Brand->findbyid($info['Product']['brand_id']);
	    	$this->data['product_brand'] = $product_brand;
	    	$this->set('product_brand',$product_brand);
	    }
	    
	    $update_product = array('id'=>$info['Product']['id'],'view_stat'=>$info['Product']['view_stat'] + 1);
		$this->Product->save($update_product);
		
		//商品地区价
		if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1){
			$product_price = $this->ProductLocalePrice->find("ProductLocalePrice.product_id =".$id." and ProductLocalePrice.status = '1' and ProductLocalePrice.locale = '".$this->locale."'");
			if(isset($product_price['ProductLocalePrice']['product_price'])){
				$info['Product']['shop_price'] = $product_price['ProductLocalePrice']['product_price'];
			}
		}
		//pr($info);
		$category_info = $this->ProductsCategory->find('ProductsCategory.product_id ='.$info['Product']['id'].' and ProductsCategory.category_id ='.$info['Product']['category_id']);
		//pr($category_info);exit;
	    //当前位置
			if(isset($category_info['ProductsCategory'])){
				$info['ProductsCategory'] = $category_info['ProductsCategory'];
			}		
	
			if(isset($categorys) && $categorys['Category']['parent_id'] == 0){
				$this->navigations[] = array('name'=>$categorys['CategoryI18n']['name'],'url'=>"/categories/".$categorys['Category']['id']);
			}
			/*	if($categorys['Category']['parent_id'] == 1){
				$this->navigations[] = array('name'=>$navigations['tree']['0']['CategoryI18n']['name'],'url'=>"/categories/".$navigations['tree']['0']['Category']['id']);
				$this->navigations[] = array('name'=>$categorys['CategoryI18n']['name'],'url'=>"/categories/".$categorys['Category']['id']);
			}*/
			if(isset($categorys) && $categorys['Category']['parent_id'] > 0){
				if($this->configs['category_link_type'] == 1){
					if(isset($navigations['assoc'][$categorys['Category']['parent_id']])){
							$info_url = str_replace(" ","-",$categorys['CategoryI18n']['name']);
							$info_url = str_replace("/","-",$info_url);
							$info_url_2 = str_replace(" ","-",$navigations['assoc'][$categorys['Category']['parent_id']]['CategoryI18n']['name']);
							$info_url_2 = str_replace("/","-",$info_url_2);	
							if($navigations['assoc'][$categorys['Category']['parent_id']]['Category']['parent_id'] >0 && isset($navigations['assoc'][$navigations['assoc'][$categorys['Category']['parent_id']]['Category']['parent_id']])){
								$info_url_3 = str_replace(" ","-",$navigations['assoc'][$navigations['assoc'][$categorys['Category']['parent_id']]['Category']['parent_id']]['CategoryI18n']['name']);
								$info_url_3 = str_replace("/","-",$info_url_3);	
								$this->navigations[] = array('name'=>$navigations['assoc'][$navigations['assoc'][$categorys['Category']['parent_id']]['Category']['parent_id']]['CategoryI18n']['name'],'url'=>"/categories/".$navigations['assoc'][$navigations['assoc'][$categorys['Category']['parent_id']]['Category']['parent_id']]['Category']['id']."/".$info_url_2."/".$info_url);
							}
					}
					$this->navigations[] = array('name'=>$navigations['assoc'][$categorys['Category']['parent_id']]['CategoryI18n']['name'],'url'=>"/categories/".$navigations['assoc'][$categorys['Category']['parent_id']]['Category']['id']."/".$info_url_2."/".$info_url);
					$this->navigations[] = array('name'=>$categorys['CategoryI18n']['name'],'url'=>"/categories/".$categorys['Category']['id']."/".$info_url."/0");

				}else{
					if(isset($navigations['assoc'][$categorys['Category']['parent_id']])){
							if($navigations['assoc'][$categorys['Category']['parent_id']]['Category']['parent_id'] >0 && isset($navigations['assoc'][$navigations['assoc'][$categorys['Category']['parent_id']]['Category']['parent_id']])){
								$this->navigations[] = array('name'=>$navigations['assoc'][$navigations['assoc'][$categorys['Category']['parent_id']]['Category']['parent_id']]['CategoryI18n']['name'],'url'=>"/categories/".$navigations['assoc'][$navigations['assoc'][$categorys['Category']['parent_id']]['Category']['parent_id']]['Category']['id']);
							}
						$this->navigations[] = array('name'=>$navigations['assoc'][$categorys['Category']['parent_id']]['CategoryI18n']['name'],'url'=>"/categories/".$navigations['assoc'][$categorys['Category']['parent_id']]['Category']['id']);
						$this->navigations[] = array('name'=>$categorys['CategoryI18n']['name'],'url'=>"/categories/".$categorys['Category']['id']);
					}
				}
			}
			
		$this->navigations[] = array('name'=>$info['ProductI18n']['name'],'url'=>"/products/".$info['Product']['id']);
		$this->set('locations',$this->navigations);
		//商品基本信息
		$product_info=$this->Product->findbyid($id);
			if(isset($category_info['ProductsCategory'])){
			$product_info['ProductsCategory'] = $category_info['ProductsCategory'];
		}
		//是否有会员价

		if($product_info['Product']['coupon_type_id']>0){
			$this->CouponType->set_locale($this->locale);
			$coupon_type = $this->CouponType->findbyid($product_info['Product']['coupon_type_id']);
			$this->data['cache_coupon_type'] = $coupon_type;
			$this->set('coupon_type',$coupon_type);
		}
		if(isset($this->configs['volume_setting']) && $this->configs['volume_setting'] == 1){
			$cache_key = md5('product_volume_pv'.'_'.$this->locale.'_'.$id);
			$product_volume = cache::read($cache_key);	
			if(!$product_volume){			
				$product_volume = $this->ProdcutVolume->find('all',array('order'=>array('ProdcutVolume.volume_number ASC'),'conditions'=>array('ProdcutVolume.product_id'=>$id)));
			}
			$this->data['cache_product_volume'] = $product_volume;
			$this->set('product_volume',$product_volume);
		}
		//是否有会员价end
		
		//同款号的 其他商品
		if($product_info['Product']['is_colors_gallery'] == 1 && $product_info['Product']['style_code'] != ''){
			$colors_gallery = $this->Product->find('all',array('conditions'=>
															array('Product.style_code'=>$product_info['Product']['style_code'],'Product.is_colors_gallery'=>1,'Product.status'=>1,'Product.forsale' =>'1'),
															'order'=>'Product.modified DESC',
															'fields'=>array('Product.colors_gallery','Product.id','Product.code','ProductI18n.style_name')
															));
			
			$this->set('colors_gallery',$colors_gallery);
		}
	//	print_r($colors_gallery);
		//pr($_SESSION);
		$this->data['product_info'] = $this->Product->localeformat($id,$this);
	//会员等级
		$this->UserRank->set_locale($this->locale);
		$user_rank_list=$this->UserRank->findrank();
		$product_all_ranks = $this->ProductRank->findallbyproduct_id($id);
		$product_ranks = array();
		
		if(is_array($product_all_ranks) && sizeof($product_all_ranks)>0){
			foreach($product_all_ranks as $k=>$v){
				$product_ranks[$v['ProductRank']['product_id']][$v['ProductRank']['rank_id']] = $v;
			}
		}
		
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
		$this->data['product_ranks'] = $product_ranks;
		
		if(isset($product_ranks[$id])){
			$product_rank = $product_ranks[$id];
		}
		//$product_rank = $this->ProductRank->findall('ProductRank.product_id ='.$id);
		//pr("");
		//商品会员价 格式化  会员等级 => 是否使用
	    if(isset($product_rank) && sizeof($product_rank)>0){
	    	  $is_rank = array();
			  foreach($product_rank as $k=>$v){
			  		$is_rank[$v['ProductRank']['rank_id']]['is_default_rank'] = $v['ProductRank']['is_default_rank'];
			  		$is_rank[$v['ProductRank']['rank_id']]['price'] = $v['ProductRank']['product_price'];
			  }
		}	
		foreach($user_rank_list as $k=>$v){
			if(isset($is_rank[$v['UserRank']['id']]) && $is_rank[$v['UserRank']['id']]['is_default_rank'] == 0){
			  $user_rank_list[$k]['UserRank']['user_price']= $is_rank[$v['UserRank']['id']]['price'];			  
			}else{
			  $user_rank_list[$k]['UserRank']['user_price']=($user_rank_list[$k]['UserRank']['discount']/100)*($this->data['product_info']['Product']['shop_price']);
			}
			  if(isset($_SESSION['User']['User']['rank']) && $v['UserRank']['id'] == $_SESSION['User']['User']['rank']){
			  	  	$info['Product']['user_price'] = $user_rank_list[$k]['UserRank']['user_price'];
			  	  	$this->data['cache_my_product_rank'] = $user_rank_list[$k]['UserRank']['user_price'];
			  		$this->set('my_product_rank',$user_rank_list[$k]['UserRank']['user_price']);
			  }
		}
		if(!empty($info) && $info['Product']['status'] == 1 && $info['Product']['forsale'] == 1){
     		 $_SESSION['cookie_product']["$id"] = array('Product'=>array(
     		 											 'id'=>$info['Product']['id'],
     		 											'img_thumb'=>$info['Product']['img_thumb'],
     		 											'code'=>$info['Product']['code'],
     		 											'shop_price'=>$info['Product']['shop_price']
     		 											),'ProductI18n'=>array('sub_name'=>$this->Product->sub_str($info['ProductI18n']['name'],6),'name'=>$info['ProductI18n']['name']));
  		}
		if($this->is_promotion($info)){
			$info['Product']['shop_price'] = $info['Product']['promotion_price'];
		}
	//	pr($user_rank_list);
		$this->data['product_ranks'] = $user_rank_list;
		$this->data['cache_product_ranks'] = $user_rank_list;
		$this->set('product_ranks',$user_rank_list);
		$this->data['product_view'] = $info;
		$this->set('info',$info);
		//商品类型
		$this->ProductType->set_locale($this->locale);
		//$product_type=$this->ProductType->gettypeformat($product_info['Product']['product_type_id']);
		if($product_info['Product']['product_type_id'] > 0){
			$product_type = $this->ProductType->findbyid($product_info['Product']['product_type_id']);
			$this->set("product_type",$product_type);
		}
		$product_attributes = $this->ProductAttribute->findallbyproduct_id($id);
		$this->ProductTypeAttribute->set_locale($this->locale);
		$product_type_atts = $this->ProductTypeAttribute->find_all_att($this->locale);
		$format_product_attributes = array();
		$product_attributes_name = array();
	//	pr($product_attributes);exit;
		$format_product_attributes_id = array();
		
		if(is_array($product_attributes) && sizeof($product_attributes)>0){
			foreach($product_attributes as $k=>$v){
				$product_type_attribute_temp =array();
				$product_type_attribute_temp['value'] = $v['ProductAttribute']['product_type_attribute_value'];
				$product_type_attribute_temp['price'] = $v['ProductAttribute']['product_type_attribute_price'];
				$product_type_attribute_temp['id'] = $v['ProductAttribute']['id'];
				$format_product_attributes[$v['ProductAttribute']['product_type_attribute_id']][]=$product_type_attribute_temp;
			}
		//	pr($format_product_attributes);exit;
			foreach($format_product_attributes as $k=>$v){
				$this->ProductTypeAttribute->set_locale($this->locale);
			//	$p_t_a = $this->ProductTypeAttribute->findbyid($k);
				if(isset($product_type_atts[$k])){
					$format_product_attributes_id[$k] = $v;
					$product_attributes_name[$k] = array('name'=>$product_type_atts[$k]['ProductTypeAttributeI18n']['name'],'type'=>$product_type_atts[$k]['ProductTypeAttribute']['type'],'code'=>$product_type_atts[$k]['ProductTypeAttribute']['code']);
				}
			}
		//	pr($product_attributes_name);exit;
			$this->set('product_attributes_name',$product_attributes_name);
			$this->set('format_product_attributes',$format_product_attributes_id);
			if(isset($format_product_attributes_id) && sizeof($format_product_attributes_id)>0){
				$one_product_attributes= array();
				$more_product_attributes= array();
				foreach($format_product_attributes_id as $k=>$v){
					if(sizeof($v) == 1){
						$one_product_attributes[] = $v;
					}else{
						$more_product_attributes[] = $v;
					}
				}
			$this->set('one_product_attributes',$one_product_attributes);
			$this->set('more_product_attributes',$more_product_attributes);
			}
		}
		//pr($format_product_attributes_id);
		$this->set('product_attributes',$product_attributes);
		//pr($format_product_attributes);exit;
	//	相册
		$this->ProductGallery->set_locale($this->locale);
	    $galleries = $this->ProductGallery->findall("ProductGallery.product_id = '$id'",null,"ProductGallery.orderby ASC , ProductGallery.img_thumb ASC");
	    if(isset($this->configs['products_detail_page_gallery_number']) && $this->configs['products_detail_page_gallery_number'] > 0){
	    	$show_gallery_number = $this->configs['products_detail_page_gallery_number'];
	    }else{
	    	$show_gallery_number = 4;
	    }
	    $galleries = array_slice($galleries,'0',$show_gallery_number);
	    //flash 参数
		$this->Flash->set_locale($this->locale);
		$flashes = $this->Flash->find("type ='P'");
		$flashes['FlashImage'] = $galleries;
		$this->set('flashes',$flashes); //flash轮播
	    
	    
	    if(sizeof($galleries) < 1){
	  //  	for($i=0;$i<$show_gallery_number - sizeof($galleries) ; $i++){
	    		$galleries[] =  array('ProductGallery'=>array('img_thumb' => (!empty($this->configs['products_default_image']))?$this->configs['products_default_image']:"/img/product_default.jpg",
	    													'img_detail' => (!empty($this->configs['products_default_image']))?$this->configs['products_default_image']:"/img/product_default.jpg",
	    													'img_original' => (!empty($this->configs['products_default_image']))?$this->configs['products_default_image']:"/img/product_default.jpg",
	    													'description' => (!empty($this->configs['products_default_image']))?$this->configs['products_default_image']:"/img/product_default.jpg"
	    							));
	    //	}
	    }
	    
	    
	    
	    $this->set("galleries",$galleries);
		// 用户上传的 相册
		$user_product_gallerie = $this->UserProductGallerie->find('all',array('conditions'=>array('UserProductGallerie.product_id'=>$id,'UserProductGallerie.status'=>1),'order'=>'UserProductGallerie.created','limit'=>6));
		if($user_product_gallerie){//比例缩放
			foreach($user_product_gallerie as $k=>$v){
				$user=$this->User->findById($v['UserProductGallerie']['user_id']);
				$user_product_gallerie[$k]['UserProductGallerie']['user_name']=$user['User']['name'];
				if(file_exists("./".$v['UserProductGallerie']['img'])){
					$arr=getimagesize("./".$v['UserProductGallerie']['img']);
					$width=$arr[0];
					$height=$arr[1];
					if(($width/$height)>1)    
					{    
						if($width>70){        
							$ImgD_width="70";    
							$ImgD_height=($height*70)/$width;  
						}else{    
							$ImgD_width=$width;        
							$ImgD_height=$height;    
						}      
					}else    
					{    
						if($height>60){        
							$ImgD_height="60";    
							$ImgD_width=($width*60)/$height;           
						}    
						else{    
							$ImgD_width=$width;        
							$ImgD_height=$height;    
						}     
					} 
					$user_product_gallerie[$k]['UserProductGallerie']['width']=$ImgD_width;
					$user_product_gallerie[$k]['UserProductGallerie']['height']=$ImgD_height;				
				}
			}
		}		
		$this->set('user_product_gallerie',$user_product_gallerie);
		//是否单独有运费
		if($this->configs['use_product_shipping_fee'] == 1){
			$shipping_sql = " ProductShippingFee.status = '1'  and ProductShippingFee.product_id = ".$id;
			if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1){
				$shipping_sql .= " and ProductShippingFee.locale = '".$this->locale."'";
			}
			$product_shippings = $this->ProductShippingFee->findall($shipping_sql);
			if(is_array($product_shippings) && sizeof($product_shippings)>0){
				$this->Shipping->set_locale($this->locale);
				$shipping_fee = array();
				foreach($product_shippings as $k=>$v){
					$shipping = $this->Shipping->findbyid($v['ProductShippingFee']['shipping_id']);
					$shipping_fee[$k]['shipping_name'] = $shipping['ShippingI18n']['name'];
					$shipping_fee[$k]['shipping_fee'] = $v['ProductShippingFee']['shipping_fee'];
				}
				$this->set('shipping_fee',$shipping_fee);
			}
		}
	//	相关商品
		$conditions = array(
							'AND'=>array('Product.status'=>'1','Product.forsale'=>'1'),
							'OR'=> array("ProductRelation.product_id "=> $id,"ProductRelation.related_product_id "=> $id)
							);
		
		$relation_ids = $this->ProductRelation->find("all",array('fields'=>array('ProductRelation.product_id','ProductRelation.related_product_id'),'conditions'=>$conditions,'recursive'=>'1','order'=>'ProductRelation.orderby'));
	//	pr($relation_ids);
	//	$relation_ids = $this->ProductRelation->find("list",array('conditions'=>"ProductRelation.product_id = '$id' and Product.status ='1' and Product.forsale ='1'",'recursive'=>'1','order'=>'ProductRelation.orderby'));
	//	$relation_ids_is_double = $this->ProductRelation->find("list",array('conditions'=>"ProductRelation.related_product_id = '$id' and ProductRelation.is_double = '1' and Product.status ='1' and Product.forsale ='1'",'recursive'=>'1','order'=>'ProductRelation.orderby'));
	/*	if(is_array($relation_ids_is_double) && sizeof($relation_ids_is_double)>0){
			foreach($relation_ids_is_double as $k=>$v){
				if(!in_array($v,$relation_ids)){
					$relation_ids[] = $v;
				}
			}
		}*/
		if(sizeof($relation_ids)>0){
			$relation_ids_list = array();
			foreach($relation_ids as $k=>$v){
				if($v['ProductRelation']['product_id']!=$id){
				$relation_ids_list[] = $v['ProductRelation']['product_id'];
				}
				if($v['ProductRelation']['related_product_id']!=$id){
				$relation_ids_list[] = $v['ProductRelation']['related_product_id'];
				}				
			}
			
			$relation_products = $this->Product->findall(array("Product.id"=>$relation_ids_list));
			if(isset($this->configs['related_products_number']) && $this->configs['related_products_number'] > 0){
				$relation_products = array_slice($relation_products,'0',$this->configs['related_products_number']);
			}
			foreach($relation_products as $k=>$v){
				//$relation_products[$k]['Product']['shop_price'] =$this->Product->locale_price($v['Product']['id'],$v['Product']['shop_price'],$this);
				if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($v['ProductLocalePrice']['product_price'])){
					$relation_products[$k]['Product']['shop_price'] = $v['ProductLocalePrice']['product_price'];
				}			
			
			}
			$this->data['relation_products'] = $relation_products;
			$this->set("relation_products",$relation_products);
		}
		
	
	//	相关文章
		$article_ids = $this->ProductArticle->find("list",array('conditions'=>"ProductArticle.product_id = '$id' and Article.status ='1' ",'recursive'=>'1','order'=>'ProductArticle.orderby','fields'=>'ProductArticle.article_id'));
		
		
		if(sizeof($article_ids)>0){
			$this->Article->set_locale($this->locale);
			$articles = $this->Article->findall(array("Article.id"=>$article_ids));
			if(isset($this->configs['related_articles_number']) && $this->configs['related_articles_number'] >0){
				$articles = array_slice($articles,'0',$this->configs['related_articles_number']);
			}
			if(isset($this->configs['article_title_length']) && $this->configs['article_title_length'] >0){
				foreach($articles as $k=>$v){
					$articles[$k]['ArticleI18n']['sub_title'] = $this->Article->sub_str($v['ArticleI18n']['title'],$this->configs['article_title_length']);
				}
			}
			
			$this->set("articles",$articles);
		}
		if(isset($this->configs['use_tag']) && $this->configs['use_tag'] == 1){
		// 标签
			$this->Tag->set_locale($this->locale);
	    	$tags = $this->Tag->findall("Tag.status ='1' and Tag.type_id =".$id." and Tag.type = 'P'");
	    	if(isset($tags) && sizeof($tags)){
	    		$tags_name = array();
	    		foreach($tags as $k=>$v){
	    			if(!in_array($v['TagI18n']['name'],$tags_name)){
	    				$tags_name[] = $v['TagI18n']['name'];
	    			}
	    		}
	    		if(!empty($tags_name)){
	    			$i18n_tag_ids = $this->TagI18n->find('list',array('conditions'=>array('TagI18n.name'=>$tags_name,'TagI18n.locale'=>$this->locale),'fields'=>'TagI18n.tag_id'));
	    			if(!empty($i18n_tag_ids)){
	    				$tags_p_ids = $this->Tag->find('list',array('conditions'=>array('Tag.id'=>$i18n_tag_ids,'Tag.type'=>'P'),'fields'=>array('Tag.type_id')));
	    				if(!empty($tags_p_ids)){
	    					$params = array('conditions'=>array('Product.id'=>$tags_p_ids,'Product.status'=>1,'Product.forsale' =>'1','Product.id <>'=>$id),
																'order'=>'Product.created',
																'fields' =>	array('Product.id','Product.img_thumb'
																					,'Product.market_price'
																					,'Product.shop_price'
																					,'Product.code','ProductI18n.name'
																				)	
																,'limit'=>4
	    														);
	    					$tags_products = $this->Product->cache_find('all',$params,"tags_p_ids_product_".$this->locale);
	    					$this->set('tags_products',$tags_products);
	    					$this->data['tags_products'] = $tags_products;
	    				}
	       			}
	    		}

	    	}
	    	
	    	//$tags_p_ids = $this->Tag
	    	//pr($tags);
	    	$this->data['tags']= $tags;
			$this->set('tags',$tags);
		}
		
		// 价格+1000之间的商品
		$params = array('conditions'=>array('Product.id <>'=>$info['Product']['id'],'Product.shop_price >='=>$info['Product']['shop_price'],'Product.shop_price <='=>($info['Product']['shop_price']+1000),'Product.status'=>1,'Product.forsale' =>'1'),
																'order'=>'Product.created',
																'fields' =>	array('Product.id','Product.img_thumb'
																					,'Product.market_price'
																					,'Product.shop_price'
																					,'Product.code','ProductI18n.name'
																				)	
																,'limit'=>4 	
	    														);
		$price_product = $this->Product->cache_find('all',$params,"1000_price_product_".$this->locale);
		
		
		$this->set('price_product',$price_product);
		$this->data['price_product'] = $price_product;
		// 过往精品
		if(isset($this->configs['show_product_bestbefore']) && $this->configs['show_product_bestbefore'] == '1'){
			$params = array('conditions'=>array('Product.bestbefore '=>"1","Product.forsale" =>'1'),
																	'order'=>'Product.created',
																	'fields' =>	array('Product.id','Product.img_thumb'
																						,'Product.market_price'
																						,'Product.shop_price'
																						,'Product.code','ProductI18n.name'
																					)
																	,'limit'=>4
		    														);	
		    
		    if($info['Product']['category_id'] > 0){
		    	$params['conditions']['Product.category_id'] = $info['Product']['category_id'];
		    }
		   	
			$bestbefore_product = $this->Product->cache_find('all',$params,"bestbefore_product_".$this->locale);
			$this->data['bestbefore_product'] = $bestbefore_product;
			$this->set('bestbefore_product',$bestbefore_product);
		}
		
	//	pr($bestbefore_product);
	//	用户评论
	// 设置用户的评论数
		if(isset($this->configs['comments_number'])){
			$show_comments_number = $this->configs['comments_number'];
		}else{
			$show_comments_number = 6;
		}
		$comments = $this->Comment->find('threaded',array('conditions'=>"Comment.type_id = '$id' and Comment.type = 'P' and Comment.status = '1'",'recursive'=>'1','order'=>'Comment.modified desc','limit'=>$show_comments_number));
		$comment_times = $this->Comment->find('all',array('fields'=>'Comment.rank','conditions'=>array('Comment.type_id'=>$id,'Comment.status'=>1,'Comment.type'=>'P')));
		if(isset($comment_times) && sizeof($comment_times)){
			$comment_count = sizeof($comment_times);
			$all_rank = 0;
			foreach($comment_times as $k=>$v){
				$all_rank += $v['Comment']['rank'];
			}
			$average_rank = ceil($all_rank/$comment_count);
			$this->set('average_rank',$average_rank);
			$this->set('comment_count',$comment_count);
		}
		$my_comments_id =array();
		
		if(isset($comments) && sizeof($comments)>0){
			foreach($comments as $k=>$v){
				$my_comments_id[] = $v['Comment']['id'];
			}
		}
		
	  $my_comments_replies = $this->Comment->find('all',array('conditions'=>array('Comment.parent_id'=>$my_comments_id)));
	  $replies_list =array();
	  if(is_array($my_comments_replies) && sizeof($my_comments_replies)>0){
	  		foreach($my_comments_replies as $kk=>$vv){
	  			$replies_list[$vv['Comment']['parent_id']][] = $vv;
	  		}
	  }
		if(isset($comments) && sizeof($comments)>0){
			foreach($comments as $k=>$v){
				if(isset($replies_list[$v['Comment']['id']])){
					$comments[$k]['children'] = $replies_list[$v['Comment']['id']];
				}
			}
		}
		$this->set('comment_count',count($comments));
		$this->set('comments',$comments);
	
	//是否可以评论
		if(isset($this->configs['products_comment_condition'])){
			$is_comments = 0;
			if($this->configs['products_comment_condition'] == 0){
				$is_comments = 1;
			}
			if($this->configs['products_comment_condition'] == 1){
				if(isset($_SESSION['User'])){
				$is_comments = 1;
				}
			}
			if($this->configs['products_comment_condition'] == 2){
				if(isset($_SESSION['User'])){
					$orders = $this->Order->findallbyuser_id($_SESSION['User']['User']['id']);
					foreach($orders as $k=>$v){
						foreach($v['order_products'] as $kk=>$vv){
							if($vv['product_id'] == $id){
								$is_comments = 1;
							}
						}
					}
				}
			}
		}else{
			$is_comments = 1;
		}

		// 商品提问
		$product_message = $this->UserMessage->find('all',array('conditions'=>array('UserMessage.status'=>1,'UserMessage.type'=>'P','UserMessage.value_id'=>$id)));
	   $my_messages_parent_id = array();
	   if(isset($product_message) && sizeof($product_message)>0){
		   foreach($product_message as $k=>$v){
		   	  $my_messages_parent_id[] = $v['UserMessage']['id'];	   
		   }
		   
		   $replies_list = $this->UserMessage->find('all',array('conditions'=>array('UserMessage.parent_id'=>$my_messages_parent_id)));
		   
		   $replies_list_format = array();
		   if(is_array($replies_list) && sizeof($replies_list)>0){
		   		foreach($replies_list as $k=>$v){
		   			$replies_list_format[$v['UserMessage']['parent_id']][] = $v;
		   		}
		   }
		   foreach($product_message as $k=>$v){
	   	     if(isset($replies_list_format[$v['UserMessage']['id']])){
	   			 $product_message[$k]['Reply']= $replies_list_format[$v['UserMessage']['id']];
	   		 }
		   }
		   $this->set('product_message',$product_message);
		   $this->set('message_count',count($product_message));
	   }
		
		
		// 商品分类
		if(isset($categorys)){
		$this->pageTitle = $product_info['ProductI18n']['name']."-".$categorys['CategoryI18n']['name']." - ".$this->configs['shop_title'];
		$this->set('categorys',$categorys);
		}else{
		$this->pageTitle = $product_info['ProductI18n']['name']." - ".$this->configs['shop_title'];
		}
		$this->set('is_comments',$is_comments);
		$this->set('type','P');
		$this->set('meta_description',$product_info['ProductI18n']['meta_description']);
		$this->set('meta_keywords',$product_info['ProductI18n']['meta_keywords']);

		}

		$this->set('id',$id);
		if(isset($this->configs['enable_one_step_buy']) && $this->configs['enable_one_step_buy'] == 1){
			$js_language = array("enable_one_step_buy" => "1"
										,'enter_positive_integer' => $this->languages['be_integer']);
		}else{
			$js_language = array("enable_one_step_buy" => "0"
										,'enter_positive_integer' => $this->languages['be_integer']);
		}
		$js_error = array("order_quantity_be_integer" => $this->languages['purchase'].$this->languages['quantity'].$this->languages['be_integer'],
							"order_quantity_not_empty" => $this->languages['purchase'].$this->languages['quantity'].$this->languages['can_not_empty'],
							"contact_not_empty" => $this->languages['connect_person'].$this->languages['can_not_empty'],
							"real_name_not_empty" => $this->languages['name'].$this->languages['can_not_empty'],
							"invalid_email" => $this->languages['email_letter'].$this->languages['format'].$this->languages['not_correct'],
							"tel_number_not_empty" => $this->languages['telephone'].$this->languages['can_not_empty'],
							"invalid_tel_number" => $this->languages['telephone'].$this->languages['format'].$this->languages['not_correct'],
							"comments_not_empty" => $this->languages['comments'].$this->languages['can_not_empty'],
							"page_submit" => $this->languages['submit'],
							"page_reset" => $this->languages['reset'],	
						   "subject_is_blank" => $this->languages['subject'].$this->languages['can_not_empty'] ,
						   "message_type_empty" => $this->languages['message'].$this->languages['type'].$this->languages['can_not_empty'],
						   "content_empty" => $this->languages['content'].$this->languages['can_not_empty'],
							"tag_can_not_empty"=>$this->languages['tags'].$this->languages['apellation'].$this->languages['can_not_empty'],
							"select_level_comments" => $this->languages['please_choose'].$this->languages['comment_rank'],
							"comments_successfully" => $this->languages['add'].$this->languages['comments'].$this->languages['successfully']
							);
		//please_choose
		
		//购买过此商品的人还购买过的商品
		$product_alsobought = $this->ProductAlsobought->find('all',array('conditions'=>array('OR'=>array('ProductAlsobought.product_id'=>$id,'ProductAlsobought.alsobought_product_id'=>$id)),
																'fields'=>array('ProductAlsobought.product_id','ProductAlsobought.alsobought_product_id')
															//	'limit'=>10
																	));
		$alsobought_ids = array();
		if(isset($product_alsobought) && sizeof($product_alsobought)){
			foreach($product_alsobought as $k=>$v){
				if($v['ProductAlsobought']['product_id'] != $id && !in_array($v['ProductAlsobought']['product_id'],$alsobought_ids)){
					$alsobought_ids[] = $v['ProductAlsobought']['product_id'];
				}
				if($v['ProductAlsobought']['alsobought_product_id'] != $id && !in_array($v['ProductAlsobought']['alsobought_product_id'],$alsobought_ids)){
					$alsobought_ids[] = $v['ProductAlsobought']['alsobought_product_id'];
				}
			}
		}
		if(!empty($alsobought_ids)){
			$alsoboughts =  $this->Product->find('all',array('conditions'=>array('Product.id'=>$alsobought_ids),
												'fields' =>	array('Product.id','Product.img_thumb'
																			,'Product.market_price'
																			,'Product.shop_price'
																			,'Product.quantity'
																			,'Product.code','ProductI18n.name'
																			),
												'limit'=> 4
																));
			if(isset($alsoboughts) && sizeof($alsoboughts)>0){
				foreach($alsoboughts as $k=>$v){
					$alsoboughts[$k]['ProductI18n']['name'] = $this->Product->sub_str($v['ProductI18n']['name'],6);
				}
			}
			$this->set('alsoboughts',$alsoboughts);
		}
		$neighbour=$this->Product->findNeighbours(null, 'id', $id); 
		$this->set('neighbour',$neighbour);			
		$js_languages = $js_language + $js_error;
		$this->set('js_languages',$js_languages);
		$this->layout = 'default_full';
 	}
 	
 	
 	
 	
	function sku($name ='',$code =''){
		$name = UrlDecode($name);
		$code = UrlDecode($code);
		$product = $this->Product->findbycode($code);
		if(isset($product['Product'])){
			$this->view($product['Product']['id']);
		 		$this->render('/products/view');
		}else{
	 	    $this->page_init();
			$this->pageTitle = $this->languages['products'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
	    	$this->flash($this->languages['products'].$this->languages['not_exist'],"/","","");
		}
	} 	

	function search2($type,$keywords='',$orderby="",$rownum='',$showtype="") {
 	  $this->Category->set_locale($this->locale);
 	   //取商店设置商品数量
 	  $rownum=isset($this->configs['products_list_num']) ? $this->configs['products_list_num']:((!empty($rownum)) ?$rownum:10);
 	  //取商店设置商品显示方式
 	  $showtype=isset($this->configs['products_list_showtype']) ? $this->configs['products_list_showtype']:((!empty($showtype)) ?$showtype:'L');
 	  //取商店设置商品排序
 	  $orderby=isset($this->configs['products_list_orderby']) ? $this->configs['products_list_orderby']:((!empty($orderby)) ?$orderby:'created');
 	  //echo $keywords;
 	  //开始搜索函数
	   $category_id=0;
	   $brand_id=0;
	   $max_price=99999999;
	   $min_price=0;
	   $pid_array=$this->requestAction("/commons/search/$type/$keywords/$category_id/$brand_id/$min_price/$max_price");
	   $this->Product->set_locale($this->locale);
       $condition = array("Product.id"=>$pid_array);
       //分页处理
       $total = $this->Product->findCount($condition,0);
       $sortClass='Product';
       $page=1;
       $parameters=Array($orderby,$rownum,$page);
       $options=Array();
       list($page) = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass); // Added 
       $products = $this->Product->findall($condition,'',"Product.$orderby","$rownum",$page);
	    //商品品牌分类
	   $res_c=$this->Category->findassoc($this->locale);
	   $res_b=$this->Brand->findassoc($this->locale);
	   foreach($products as $k=>$v){
	  	  if(is_array($res_c[$v['ProductsCategory']['id']])){
	  	  	  $products[$k]['Category']=$res_c[$v['ProductsCategory']['id']]['Category'];
	  	  	  $products[$k]['CategoryI18n']=$res_c[$v['ProductsCategory']['id']]['CategoryI18n'];
	  	  }
	  	  if(is_array($res_b[$v['Product']['brand_id']])){
	  	  	  $products[$k]['Brand']=$res_b[$v['Product']['brand_id']]['Brand'];
	  	  	  $products[$k]['BrandI18n']=$res_b[$v['Product']['brand_id']]['BrandI18n'];
	  	  }
	    }
	    $this->pageTitle = $keywords." - ".$this->configs['shop_title'];
         //pr($products);
         //当前位置
	     $ur_heres=array();
	     $ur_heres[]=array('name'=>__("Home",true),'url'=>"/");
	     $ur_heres[]=array('name'=>__("Search Result",true),'url'=>"");
	     
		if(isset($this->configs['enable_one_step_buy']) && $this->configs['enable_one_step_buy'] == 1){
			$js_language = array("enable_one_step_buy" => "1"
										,'enter_positive_integer' => $this->languages['be_integer']);
		}else{
			$js_language = array("enable_one_step_buy" => "0"
										,'enter_positive_integer' => $this->languages['be_integer']);
		}
		$js_error = array("order_quantity_be_integer" => $this->languages['purchase'].$this->languages['quantity'].$this->languages['be_integer'],
							"order_quantity_not_empty" => $this->languages['purchase'].$this->languages['quantity'].$this->languages['can_not_empty'],
							"contact_not_empty" => $this->languages['connect_person'].$this->languages['can_not_empty'],
							"invalid_email" => $this->languages['email_letter'].$this->languages['format'].$this->languages['not_correct'],
							"tel_number_not_empty" => $this->languages['telephone'].$this->languages['can_not_empty'],
							"invalid_tel_number" => $this->languages['telephone'].$this->languages['format'].$this->languages['not_correct'],
							"comments_not_empty" => $this->languages['comments'].$this->languages['can_not_empty'],		
							"select_level_comments" => $this->languages['please_choose'].$this->languages['comment_rank']
							);
		
		 $js_languages = $js_language + $js_error;
		 $this->set('js_languages',$js_languages);
	     $this->page_init();
         $this->set('products',$products);
         $this->set('keywords',$keywords);
	     $this->set('type',$type);
	     
	     //排序方式,显示方式,分页数量限制
	     $this->set('orderby',$orderby);
	     $this->set('rownum',$rownum);
	     $this->set('showtype',$showtype);
	     $this->set('ur_heres',$ur_heres);
		 $this->layout = 'default_search';

	}

/*********商品简单搜索结束*********/


	function search(){
		$this->page_init();
		$this->pageTitle = $this->languages['advanced_search']." - ".$this->configs['shop_title'];
		$this->navigations[] = array('name'=>$this->languages['advanced_search'],'url'=>"");
		$this->set('locations',$this->navigations);
		$this->layout = 'default_full';
	}
	
	
	/*********高级搜索开始*********/
	/*********ad_search   *********/
	function advancedsearch($type,$keywords='',$category_id=0,$brand_id=0,$min_price=0,$max_price=9999999,$page=1,$orderby=0,$rownum=0,$showtype=0){
		$this->cacheQueries = true;
    	$this->cacheAction = "1 day";
		$keywords = UrlDecode($keywords);
	//	pr($keywords);exit;
		$orderby = UrlDecode($orderby);
		$showtype = UrlDecode($showtype);
		if(!isset($_GET['page'])){
			$_GET['page'] = $page;
		}
		$this->data['showtype_page'] = "L";
		$this->data['get_page'] = $_GET['page'];
		$mrClean = new Sanitize();		
		$not_show = 0;
		if(empty($rownum) && $rownum == 0){
			$rownum=isset($this->configs['products_category_page_size']) ? $this->configs['products_category_page_size']:((!empty($rownum)) ?$rownum:20);//取商店设置商品数量
		}
		if(empty($showtype) && $showtype == 0){
			$showtype=isset($this->configs['products_list_showtype']) ? $this->configs['products_list_showtype']:((!empty($showtype)) ?$showtype:'L');//取商店设置商品显示方式
		}
		
		if(empty($orderby) && $orderby == 0){
			if($keywords == "search_3newarrival"){
			$orderby="Product.modified DESC";
			}else{
	 		$orderby=isset($this->configs['products_category_page_orderby_type'])? "Product.".$this->configs['products_category_page_orderby_type']." ". $this->configs['products_category_page_orderby_method'] :((!empty($orderby)) ?$orderby:'Product.created '.$this->configs['products_category_page_orderby_method']);
			}
		}
		
		if($rownum == 'all'){
			$rownum_sql = 99999;
		}else{
			$rownum_sql = $rownum;
		}
		
		
	//	pr($orderby);
		$this->data['rownum'] = $rownum;
		$this->data['showtype'] = $showtype;
		$this->data['pagination_brand'] = $brand_id;
		$this->data['price_min'] = $min_price;
		$this->data['price_max'] = $max_price;	
		$this->data['pagination_category'] = $category_id;	
					
	 	$is_all = 0;
		$url_keywords = $keywords;
	//	pr($keywords);
	//	$keywords = str_replace('?','/',$keywords);
	//	pr($keywords);exit;
		if($keywords == "bestbefore"){
				$keywords = $this->languages['in_the_past_boutique'];
				$not_show = 1;	 
				$is_all = 6;		
		}elseif($keywords == "search_hot"){
				$keywords = $this->languages['hot'];
				$not_show = 1;	 
				$is_all = 5;			
		}elseif($keywords == "search_recommand"){
				$keywords = $this->languages['recommend'];
				$not_show = 1;	 
				$is_all = 4;
		}elseif($keywords == "search_newarrival"){
				$keywords = $this->languages['new_arrival'];
				$not_show = 1;	 
				$is_all = 3;
		}elseif($keywords == "search_promotion"){
				$keywords = $this->languages['promotion'];
				$not_show = 1;	 
				$is_all = 2;
		}elseif($keywords == "all" && $category_id == 0 && $brand_id == 0){
	 		$is_all = 1;
	 	 	$keywords = $this->languages['all'].$this->languages['products'];
	 	 	$not_show = 1;
//			$pid_array=$this->requestAction("/commons/search/$type/$keywords/$category_id/$brand_id/$min_price/$max_price");
	 //		$cache_key = md5('product_advancedsearch'.'_'.$this->locale.$type.$keywords.$brand_id.$min_price.$max_price);
	//		$product_advancedsearch = cache::read($cache_key);	
	//		$pid_array= $this->product_search($type,$keywords,$category_id,$brand_id,$min_price,$max_price);
	 	}else{
	 		if($keywords == 'all'){
	 			$is_all = 1;
	 			$keywords = 0;
			}else{
	//		$pid_array=$this->requestAction("/commons/search/$type/$keywords/$category_id/$brand_id/$min_price/$max_price");
	 			$cache_key = md5('product_advancedsearch'.'_'.$this->locale.$type.$keywords.$brand_id.$min_price.$max_price);
				$pid_array= $this->product_search($type,$keywords,$category_id,$brand_id,$min_price,$max_price);
			}
			if($keywords == "0"){	
				$keywords = "";
				if($category_id > 0){
					$this->Category->set_locale($this->locale);
					$category_info = $this->Category->findbyid($category_id);
					if(is_array($category_info)){
						if($keywords != ""){
							$keywords .= "-";
						}
						$keywords .= $category_info['CategoryI18n']['name'];
					}
				}
				if($brand_id > 0){
					$this->Brand->set_locale($this->locale);
					$brand_info = $this->Brand->findbyid($brand_id);
					if(isset($brand_info) && is_array($brand_info)){
						if($keywords != ""){
							$keywords .= "-";
						}
						$keywords .= $brand_info['BrandI18n']['name'];
					}
				}
				$not_show = 1;	 
			}
	 	}
	 	
	 	$this->set('not_show',$not_show);
	 	//echo "---------------";
	 	//print_r($_SESSION);
		$this->Product->set_locale($this->locale);
		
		if($is_all == 6){
			$condition = array('Product.bestbefore'=>'1',
		    				  'Product.forsale' => '1'
		   					);			
		}elseif($is_all == 5){
			$condition = array('Product.status'=>'1',
		    				  'Product.alone' => '1',
		    				  'Product.forsale' => '1'
		   					);
		   	$orderby = "Product.view_stat DESC";
		}elseif($is_all == 4){
			$condition = array('Product.status'=>'1',
		    				  'Product.alone' => '1',
		    				  'Product.forsale' => '1',
		    				  'Product.recommand_flag' => '1'
		   					);
		}elseif($is_all == 3){
			$condition = array('Product.status'=>'1','Product.forsale' =>'1');
		}elseif($is_all == 2){
			$datetime = date("Y-m-d H:i:s");
			$condition = "Product.status ='1' and Product.alone = '1' and Product.forsale ='1' and Product.promotion_status in ('1','2') and '".$datetime."' between Product.promotion_start and Product.promotion_end  ";
		}elseif($is_all == 1){
			$condition = array('Product.status'=>'1','Product.forsale' =>'1');
		}else{
		//	pr($pid_array);
			$condition = array("Product.id"=>$pid_array,'Product.status'=>'1','Product.forsale' =>'1');
		}
	    if($brand_id !='' && $brand_id != 0){
	      //$condition .=" and Product.brand_id =$brand_id";
	      	  $condition["Product.brand_id"]= $brand_id;
	    }
	    $category_tree = $this->Category->tree('P',0,$this->locale,$this);
	  //  pr($this->Category->allinfo['subids']);
	    if($category_id !=''&& $category_id != 0){
	    	  $category_ids = isset($this->Category->allinfo['subids'][$category_id])?$this->Category->allinfo['subids'][$category_id]:$category_id;
	      	  $condition["Product.category_id"]= $category_ids;
	    }
	   if($min_price !=''&& $min_price > 0){
	     // $condition .=" and Product.shop_price >= ".$min_price;
	      	  $condition["Product.shop_price >= "]= $min_price;
	    }
	   if($max_price !=''&& $max_price < 9999999){
	      //$condition .=" and Product.shop_price <= ".$max_price;
	      	  $condition["Product.shop_price <= "]= $max_price;
	    }		
		
		$this->data['orderby'] = $orderby;
		//分页处理
		$cache_key = md5('product_auto_adv_total_products'.'_'.$this->locale.'_'.serialize($condition));
		$total = $this->Product->cache_find('count',array('fields' => 'DISTINCT Product.id','recursive' => -1,'conditions'=>array($condition)),"Product_find_total_advancedsearch_".$this->locale);
		
		$sortClass='Product';
		$page=1;
		$parameters=Array($orderby,$rownum_sql,$page);
		$options=Array();
		$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum_sql,$sortClass); // Added 
		if( !isset($product_advancedsearch)||!$product_advancedsearch){
		$products=$this->Product->find('all',array(			
															//	'recursive' => -1,
																'fields' =>	array('Product.id','Product.recommand_flag','Product.status','Product.img_thumb'
																				,'Product.market_price'
																				,'Product.shop_price'
																				,'Product.promotion_price'
																				,'Product.promotion_start','Product.brand_id'
																				,'Product.promotion_end'
																				,'Product.promotion_status'
																				,'Product.code','Product.bestbefore'
																				,'Product.product_rank_id'
																				,'Product.quantity','Product.category_id'
																				,'ProductI18n.id','ProductI18n.name','ProductI18n.product_id'
																				),			
		'conditions'=>array($condition),'order'=>array("$orderby"),'limit'=>$rownum_sql,'page'=>$page));	    
		
		$page_products_id = array();
		if(isset($products) && sizeof($products)>0){
			foreach($products as $k=>$v){
				$page_products_id[] = $v['Product']['id'];
			}
		}
		
		
	    //商品品牌分类
		$this->Category->set_locale($this->locale);
	//	$category_tree = $this->Category->tree('P',0,$this->locale);

	//	pr($category_tree);
	//	$res_c=$this->Category->findassoc($this->locale);
		$res_c=$category_tree['assoc'];
		$res_b=$this->Brand->findassoc($this->locale);
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
	 //   $this->Category->set_locale($this->locale);						
	//	$category_lists = $this->Category->find_all($this->locale);
		$this->set('categories',$category_tree['assoc']);
 	    $product_category_infos = $this->ProductsCategory->find('all',array("conditions"=>array('ProductsCategory.product_id'=>$page_products_id)));
	    $product_category_lists = array();
	    if(is_array($product_category_infos) && sizeof($product_category_infos)>0){
	  	  	  foreach($product_category_infos as $k=>$v){
	  			  $product_category_lists[$v['ProductsCategory']['product_id']] = $v;
	  		  }
	    }
		//pid_array
		// 商品地区价格
		if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && !empty($page_products_id)){
			$locale_price_list =array();
					$locale_price = $this->ProductLocalePrice->find('all',array( 
					'fields' =>	array('ProductLocalePrice.product_price','ProductLocalePrice.product_id'),
					'conditions'=>array('ProductLocalePrice.product_id'=>$page_products_id,'ProductLocalePrice.locale'=>$this->locale,'ProductLocalePrice.status'=>1)));
				if(isset($locale_price) && sizeof($locale_price)>0){
					foreach($locale_price as $k=>$v){
						$locale_price_list[$v['ProductLocalePrice']['product_id']] = $v;
					}
				}
			}		
		
		
		foreach($products as $k=>$v){
			
			 if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
				$products[$k]['ProductI18n']['sub_name'] = $this->Product->sub_str($products[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
	 		 }else{
	 		 	$products[$k]['ProductI18n']['sub_name'] = $products[$k]['ProductI18n']['name'];
	 		 }			
			
			if(isset($product_category_lists[$v['Product']['id']])){
				$products[$k]['ProductsCategory'] = $product_category_lists[$v['Product']['id']]['ProductsCategory'];
				$v['ProductsCategory'] = $product_category_lists[$v['Product']['id']]['ProductsCategory'];
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
			if($this->Product->is_promotion($v)){
				$products[$k]['Product']['shop_price'] = $v['Product']['promotion_price'];
			}
			if($this->configs['category_link_type'] == 1){
				if(isset($category_lists[$v['Product']['category_id']])){
					$info = $category_lists[$v['Product']['category_id']];
				}						
				$products[$k]['use_sku'] = 1;
				if(isset($info) && $info['Category']['parent_id']>0){
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
			
			if(isset($v['ProductsCategory']) && isset($res_c[$v['ProductsCategory']['id']]['Category']['id'])){
				$products[$k]['Category']=$res_c[$v['ProductsCategory']['id']]['Category'];
				$products[$k]['CategoryI18n']=$res_c[$v['ProductsCategory']['id']]['CategoryI18n'];
			}
			if(isset($res_b[$v['Product']['brand_id']]['Brand']['id'])){
				$products[$k]['Brand']=$res_b[$v['Product']['brand_id']]['Brand'];
				$products[$k]['BrandI18n']=$res_b[$v['Product']['brand_id']]['BrandI18n'];
			}
			//	$products[$k]['Product']['user_price'] =$this->Product->user_price($k,$v,$this);
		}
			cache::write($cache_key,$products);
		}else{
			$products = $product_advancedsearch;
		}
		//当前位置
		$this->navigations[] = array('name'=>$this->languages['search_result'],'url'=>"");
		if($keywords == "0"){
			$keywords = $this->languages['advanced_search'];
		}

		$this->pageTitle = $keywords." - ".$this->configs['shop_title'];
		$this->navigations[] = array('name'=>$keywords,'url'=>"");
		$this->set('locations',$this->navigations);
		$type='SAD';
		if(isset($this->configs['enable_one_step_buy']) && $this->configs['enable_one_step_buy'] == 1){
			$js_language = array("enable_one_step_buy" => "1"
										,'enter_positive_integer' => $this->languages['be_integer']);
		}else{
			$js_language = array("enable_one_step_buy" => "0"
										,'enter_positive_integer' => $this->languages['be_integer']);
		}
		$js_error = array(	"order_quantity_be_integer" => $this->languages['purchase'].$this->languages['quantity'].$this->languages['be_integer'],
							"order_quantity_not_empty" => $this->languages['purchase'].$this->languages['quantity'].$this->languages['can_not_empty'],
							"contact_not_empty" => $this->languages['connect_person'].$this->languages['can_not_empty'],
							"invalid_email" => $this->languages['email_letter'].$this->languages['format'].$this->languages['not_correct'],
							"tel_number_not_empty" => $this->languages['telephone'].$this->languages['can_not_empty'],
							"invalid_tel_number" => $this->languages['telephone'].$this->languages['format'].$this->languages['not_correct'],
							"comments_not_empty" => $this->languages['comments'].$this->languages['can_not_empty'],
							"select_level_comments" => $this->languages['please_choose'].$this->languages['comment_rank']
							);
		
	  $js_languages = $js_language + $js_error;
	  $this->set('js_languages',$js_languages);
	  $this->data['product_ranks'] = $product_ranks;
	  $this->data['products'] = $products;	 	  
	  $this->data['to_page_id'] = $url_keywords;
      $this->data['pages_url_1'] = $this->server_host.$this->cart_webroot."products/advancedsearch/SAD/".$this->data['to_page_id']."/".$this->data['pagination_category']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/";
      $this->data['pages_url_2'] = "/".$this->data['orderby']."/".$this->data['rownum']."/".$this->data['showtype']."/";
	  $this->data['pages_url_1_type'] =  $this->server_host.$this->cart_webroot."products/advancedsearch/SAD/".$this->data['to_page_id']."/".$this->data['pagination_category']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$page."/";
	  $this->data['pages_url_2_type'] =  "/".$this->data['rownum']."/";
	  
	  $this->set('products',$products);
	  $this->set('type',$type);
	  $this->set('url_keywords',$url_keywords);
	  $this->set('keywords',$keywords);
	  $this->set('category_id',$category_id);
	  $this->set('brand_id',$brand_id);
	  $this->set('min_price',$min_price);
	  $this->set('max_price',$max_price);
	  //排序方式,显示方式,分页数量限制
	  $this->set('orderby',$orderby);
	  $this->set('rownum',$rownum);
	   $this->set('total',$total);
	  $this->set('showtype',$showtype);
		$this->page_init();
	  $this->data['page_total'] = $total;
	  $this->layout = 'default';
	}

	function search_autocomplete(){
		$products_formated=array();
		if(isset($_GET['query'])){
			$keyword=$_GET['query'];
			$num = isset($this->configs['search_autocomplete_number'])?$this->configs['search_autocomplete_number']:10;
	    	$products = $this->Product->search($this->locale,$keyword,$num);
		    if(is_array($products)){
		    	foreach($products as $v){
		    		$product_result=array();
		    		if(isset($this->configs['search_prouduct_type'])){
		    			$type_arr = explode(';',$this->configs['search_prouduct_type']);
		    			if(is_array($type_arr)){
		    				$product_result['id']=$v['Product']['id'];
		    				foreach($type_arr as $kk=>$vv){
		    					if($vv == 0){
		    						
					    		if(trim($v['Product']['img_thumb']) == ""){
					    		$product_result['img']=$this->server_host.$this->cart_webroot."img/product_default.jpg";
					    		}else{
					    		$webroot = substr($this->server_host.$this->cart_webroot,0,strlen($this->server_host.$this->cart_webroot)-1);
					    		$product_result['img']=$this->server_host.$this->cart_webroot.$v['Product']['img_thumb'];
					    		}
		    						
		    					}
		    					if($vv == 1){
		    						if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
			    						$product_result['name'] = $this->Product->sub_str($v['ProductI18n']['name'], $this->configs['products_name_length']);
			    					}
		    					}
		    					if($vv == 2){
		    						$product_result['code']=$v['Product']['code'];
		    					}
		    				}
		    			}
		    		}else{
			    		$product_result['id']=$v['Product']['id'];
			    		$product_result['code']=$v['Product']['code'];
			    		if(trim($v['Product']['img_thumb']) == ""){
			    		$product_result['img']=$this->server_host.$this->cart_webroot."img/product_default.jpg";
			    		}else{
					    $webroot = substr($this->server_host.$this->cart_webroot,0,strlen($this->server_host.$this->cart_webroot)-1);
			    		$product_result['img']=$webroot.$v['Product']['img_thumb'];
			    		}
			    		$product_result['price']=$v['Product']['shop_price'];
			    		if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
			    			$product_result['name'] = $this->Product->sub_str($v['ProductI18n']['name'], $this->configs['products_name_length']);
			    		}
		    		}
		    		$products_formated[]=$product_result;
		    	}
		    }
	    }
	    
	    $this->set('Result',$products_formated);
		$this->layout="ajax";
	}
	
	function findall(){
		$this->Product->set_locale($this->locale);
		$products = $this->Product->findall();
		$this->set('products',$products);
	}
	
	function del_history(){
		if($this->RequestHandler->isPost()){
			Configure::write('debug', 0);
			unset($_SESSION['cookie_product']);
			$this->layout="ajax";
			die("1");
		}else{
			unset($_SESSION['cookie_product']);
			if(isset($_SERVER['HTTP_REFERER'])){
				$url = $_SERVER['HTTP_REFERER'];
			}else{
				$url = $this->server_host.$this->cart_webroot;
			}
			header("Location:".$url);
			exit;
		}
	}
	
	function show_booking(){
		if($this->RequestHandler->isPost()){
			if(isset($_SESSION['User']['User']['id'])){
			$product_info = $this->Product->findbyid($_POST['id']);
			$this->set('product_info',$product_info);
			//$result['name'] = $_POST['name'];
			$result['id'] = $_POST['id'];
			$result['type'] = 0;
			}else{
				$result['type'] = 1;
				$result['message']=$this->languages['time_out_relogin'];
			}
			$this->set('result',$result);
			$this->layout="ajax";
		}
	}
	
	function add_booking(){
		if($this->RequestHandler->isPost()){
			if(isset($_SESSION['User']['User']['id'])){
				$no_error = 1;
				if(!isset($_POST['is_ajax'])){
					$booking = $_POST['data']['bookings'];
					if($booking['product_number'] == ""){
						$no_error = 0;
						$result['message'] = $this->languages['purchase'].$this->languages['quantity'].$this->languages['can_not_empty'];
					}elseif(!is_numeric($booking['product_number']) || intval($booking['product_number']) <= 0){
						$no_error = 0;
						$result['message'] = $this->languages['purchase'].$this->languages['quantity'].$this->languages['be_integer'];
					}elseif($booking['contact_man'] == ""){
						$no_error = 0;
						$result['message'] = $this->languages['connect_person'].$this->languages['can_not_empty'];					
					}elseif($booking['email'] == "" || !$this->is_email($booking['email'])){
						$no_error = 0;
						$result['message'] = $this->languages['email_letter'].$this->languages['format'].$this->languages['not_correct'];										
					}elseif(!empty($booking['telephone']) && !preg_match( '/^[\d|\_|\-|\s]+$/', $booking['telephone'])){
						$no_error = 0;
						$result['message'] = $this->languages['telephone'].$this->languages['format'].$this->languages['not_correct'];															
					}
				}else{
					$booking=(array)json_decode(StripSlashes($_POST['booking']));
				}
				
				$booking['user_id'] = $_SESSION['User']['User']['id'];
				$now_time = date("Y-m-d H:i:s");
				$booking['booking_time'] = $now_time;
				if($no_error){
				$this->BookingProduct->save($booking);
				$result['message'] = $this->languages['out_stock_book_successful'];
				}
				$result['type'] = 0;
			}else{
				$result['type'] = 1;
				$result['message']=$this->languages['time_out_relogin'];
			}
			
			if(!isset($_POST['is_ajax'])){
				$this->page_init();
				$id = isset($booking['product_id'])?$booking['product_id']:'';
				$this->pageTitle = isset($result['message'])?$result['message']:''." - ".$this->configs['shop_title'];
				$this->flash(isset($result['message'])?$result['message']:'','/products/add_booking_page/'.$id,10);					
			}
			
			$this->set('result',$result);
			$this->layout="ajax";
		}
	}
	
	function add_booking_page($id){
		$this->page_init();
		$this->pageTitle = $this->languages['booking']." - ".$this->configs['shop_title'];;
		$this->Product->set_locale($this->locale);
		$product_info = $this->Product->findbyid($id);
		$this->set('product_info',$product_info);
	
	}
	
	function rss($category_id=0){
		$this->layout = '/rss/products';
		$this->Product->set_locale($this->locale);
		if($category_id!=0){
			$this->Category->set_locale($this->locale);
			$this->Category->tree('P',0,$this);
			$conditions['Product.category_id']= $this->Category->allinfo['subids'][$category_id];
		}
		$conditions['Product.status']='1';
        $products_list = $this->Product->find('all',array('conditions'=>$conditions,'limit'=>10,'order'=>'Product.created desc'));
       	$this->set('dynamic',"商品动态"); 
       	$this->set('this_config',$this->configs); 
        $this->set('products',$products_list); 
        Configure::write('debug',0);
	}
	
	function is_promotion($product_info){
		return ($product_info['Product']['promotion_status'] == '1' && $product_info['Product']['promotion_start'] <= date("Y-m-d H:i:s") && $product_info['Product']['promotion_end'] >= date("Y-m-d H:i:s"));
	}
	
 function product_search($type,$keywords='',$category_id='',$brand_id='',$min_price='',$max_price=''){
 	 //$this->Product->set_locale($this->locale);
 	 $category_product_ids = array();
 	// pr($keywords);
     // $condition=" 1=1 and Product.status = 1";
	  $condition['AND'][]= "Product.status = '1'";
    if($category_id !=''&& $category_id != 0){
      //$condition .=" and ProductsCategory.category_id =$category_id";
     // 	$condition['AND'][]= "ProductsCategory.category_id =$category_id";
  /*   $arr = $this->ProductsCategory->findall('ProductsCategory.category_id ='.$category_id ,'DISTINCT ProductsCategory.product_id');
     if(is_array($arr) && sizeof($arr)>0){
     	foreach($arr as $v ){
     		$con = " Product.id = ".$v['ProductsCategory']['product_id'];
     		if($min_price != '' && $min_price >0 ){
     			$con .= " and Product.shop_price >= ".$min_price;
     		}
     	    if($max_price !=''&& $max_price < 99999999){
      	 	  	$con .= " and Product.shop_price <= ".$max_price;
   		    }
		    if($brand_id !='' && $brand_id != 0){
		       	$con .=" and Product.brand_id =$brand_id";
		    }   		    
     		$p = $this->Product->find($con);
     		if(isset($p['Product'])){
     			$category_product_ids[] = $v['ProductsCategory']['product_id'];
     		}
     	}
     }*/
    // pr($arr);exit;
    }//ProductsCategory
    if($brand_id !='' && $brand_id != 0){
      //$condition .=" and Product.brand_id =$brand_id";
      	  $condition['AND'][]= "Product.brand_id =$brand_id";
    }
    
    if($category_id !=''&& $category_id != 0){
		  $this->Category->tree('P',$category_id,$this->locale,$this);
    	  $category_ids = isset($this->Category->allinfo['subids'][$category_id])?$this->Category->allinfo['subids'][$category_id]:$category_id;
      //	  $condition['AND'][]= "Product.category_id =$category_ids";
    }
   if($min_price !=''&& $min_price > 0){
     // $condition .=" and Product.shop_price >= ".$min_price;
      	  $condition['AND'][]= "Product.shop_price >= ".$min_price;
    }
   if($max_price !=''&& $max_price < 9999999){
      //$condition .=" and Product.shop_price <= ".$max_price;
      	  $condition['AND'][]= "Product.shop_price <= ".$max_price;
    }
     if($keywords == $this->languages['all'].$this->languages['products']){
		//	$product18n_pid = $this->ProductI18n->find('list',array('conditions'=>array("1=1"),'fields'=>array('ProductI18n.product_id'),'recursive'=>-1));
     }else{
     //	 if($keywords == "search_promotion"){
     	 
     //	 }
     	 
     	 
     	 
        if($keywords != '0' && $keywords != 'all_products'){
	/*		$condition_18n = array();
			$condition_18n['OR'][] = "ProductI18n.name like '%$keywords%' ";
			$condition_18n['OR'][] = "ProductI18n.description like '%$keywords%' ";    
			$product18n_pid = $this->ProductI18n->find('all',array('conditions'=>array($condition_18n),'fields'=>array('ProductI18n.product_id'),'recursive'=>-1));
    		$filter = "Product.code like '%$keywords%' ";
    		$product_code_id = $this->Product->find('all',array('conditions'=>array($filter),'fields'=>array('Product.id'),'recursive'=>-1));
    		*/
			$condition_18n['OR'][] = "Product.code like '%$keywords%' ";
    		$product_pid = $this->Product->find('list',array('conditions'=>array($condition_18n),'fields'=>array('Product.id')));
    		$condition_p18n['OR'][] = "ProductI18n.name like '%$keywords%' ";
			$condition_p18n['OR'][] = "ProductI18n.description like '%$keywords%' ";
    		$product18n_pid = $this->ProductI18n->find('list',array('conditions'=>array($condition_p18n),'fields'=>array('ProductI18n.product_id')));
    		$product18n_pid = array_unique($product18n_pid+$product_pid);
	/*		$condition_18n['OR'][] = "ProductI18n.name like '%$keywords%' ";
			$condition_18n['OR'][] = "Product.code like '%$keywords%' ";
    		$product_code_id = $this->Product->find('all',array('conditions'=>array(" MATCH (ProductI18n.description) AGAINST ('".$keywords."')"),'fields'=>array('ProductI18n.product_id')));
    		$product18n_pid = $this->Product->find('all',array('conditions'=>array($condition_18n),'fields'=>array('ProductI18n.product_id')));
    */		
    		
    	}
     }
     
     if(isset($product18n_pid)){
     	$category_product_ids = $product18n_pid;
     }          
     //pr($condition);exit;            	
    $pid_arrays = array();
  /*  
	pr($product18n_pid);
	    [0] => Array
        (
            [ProductI18n] => Array
                (
                    [product_id] => 15
                )

        )
	*/
	if(isset($this->configs['use_tag']) && $this->configs['use_tag'] == 1){
		$tag_filter = " TagI18n.locale = '".$this->locale."' and TagI18n.name = '".$keywords."' and Tag.type = 'P'";
		$tags = $this->Tag->findall($tag_filter);
		if(is_array($tags) && sizeof($tags)>0){
			foreach($tags  as $k=>$v){
				$category_product_ids[] = $v['Tag']['type_id'];
			}
		}
	}
	/*
	if(isset($product18n_pid) && sizeof($product18n_pid)>0){
		foreach($product18n_pid as $k=>$v){
			if(!in_array($v['ProductI18n']['product_id'],$category_product_ids)){
				$category_product_ids[] = $v['ProductI18n']['product_id'];
			}
		}
	}
	if(isset($product_code_id) && sizeof($product_code_id)>0){
		foreach($product_code_id as $k=>$v){
			if(!in_array($v['Product']['id'],$category_product_ids)){
				$category_product_ids[] = $v['Product']['id'];
			}
		}
	}*/
	
   	//pr($category_product_ids);
  	return $category_product_ids;
 }	
 
	function is_email($user_email)
	{
	    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
	    if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false)
	    {
	        if (preg_match($chars, $user_email))
	        {
	            return true;
	        }
	        else
	        {
	            return false;
	        }
	    }
	    else
	    {
	        return false;
	    }
	}
	
	function user_gallery($page = 1){
    	$this->cacheQueries = true;
    	$this->cacheAction = "1 day";		
		$this->page_init();
		//当前位置
		$this->navigations[] = array('name'=>$this->languages['all'].$this->languages['albums'],'url'=>"");
		$this->set('locations',$this->navigations);
	 	 if(isset($_GET['page'])){
	 	 	$page = $_GET['page'];
	 	 }else{
	 		 $_GET['page'] = $page;
	 	 }		
		
 	    //取商店设置评论显示数量
 	    $rownum=10;
	   //取得我的评论
	   //pr($_SESSION['User']);
	   $condition=" 1=1 and UserProductGallerie.status = '1'";
	   $user_gallery=$this->UserProductGallerie->find('all',array(
	  	   'fields' => array('UserProductGallerie.id','UserProductGallerie.product_id',
	   	   'UserProductGallerie.user_id','UserProductGallerie.img','UserProductGallerie.created'),
	   	   'conditions'=>array($condition),'order'=>'UserProductGallerie.created DESC'));//,'limit'=>$rownum,'page'=>$page
		
		if(isset($user_gallery) && sizeof($user_gallery)>0){
			$p_ids = array();
			$u_ids = array();
			foreach($user_gallery as $k=>$v){
				if(!in_array($v['UserProductGallerie']['product_id'],$p_ids)){
					$p_ids[] = $v['UserProductGallerie']['product_id'];
				}
				if(!in_array($v['UserProductGallerie']['user_id'],$u_ids)){
					$u_ids[] = $v['UserProductGallerie']['user_id'];
				}				
			}
			$product_lists = array();
			
			if(!empty($p_ids)){
			   $condition = array('Product.id'=>$p_ids);
			   $total = $this->Product->find('count',array('conditions'=>array($condition),'fields'=>'Product.id'));
			   $sortClass='Product';
			   $page=1;
			   $parameters=Array($rownum,$page);
			   $options=Array();
			   $page= $this->Pagination->init($condition,"",$options,$total,$rownum,$sortClass);				
				// ,'fields'=>array('Product.id','ProductI18n.name','Product.img_thumb','Product.img_original')
				$this->Product->set_locale($this->locale);
				$products = $this->Product->find('all',array('conditions'=>$condition,'limit'=>$rownum,'page'=>$page));
				$product_lists = array();
				if(isset($products) && sizeof($products)>0){
					foreach($products as  $k=>$v){
						$product_lists[$v['Product']['id']] =  $v;
					}
				}
			}
			
			foreach($user_gallery as $k=>$v){
				if(isset($product_lists[$v['UserProductGallerie']['product_id']])){
					$product_lists[$v['UserProductGallerie']['product_id']]['gallery'][] = $v;
				}
			}
			$this->set('product_lists',$product_lists);
			if(!empty($u_ids)){
				$users = $this->User->find('all',array('conditions'=>array('User.id'=>$u_ids),'fields'=>array('User.id','User.name')));
				$user_lists = array();
				if(isset($users) && sizeof($users)>0){
					foreach($users as  $k=>$v){
						$user_lists[$v['User']['id']] =  $v;
					}
				}
				$this->set('user_lists',$user_lists);
			}			
			
		}
				
	   $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']);
	   $this->set('js_languages',$js_languages);
	   $this->pageTitle = $this->languages['all'].$this->languages['albums']." - ".$this->configs['shop_title'];
	   $this->set('total',$total);
       $this->data['pages_url_1'] = $this->server_host.$this->cart_webroot."products/user_gallery/";
       $this->data['pages_url_2'] = "/";	   
	   $this->data['user_gallery'] = $user_gallery;
	   $this->set('user_gallery',$user_gallery);
	}
	function order_track(){//2kbuy订单查询		
	  	$this->page_init();
		    //当前位置  
		$this->navigations[] = array('name'=>__($this->languages['order'].$this->languages['search'],true),'url'=>"");
		$this->set('locations',$this->navigations);		
		$this->pageTitle = $this->languages['order'].$this->languages['search']."- ".$this->configs['shop_title'];
	}		
	function templete_rss($category_id=0){
		$this->layout = '/rss/articles';
		$this->Product->set_locale($this->locale);
		if($category_id > 0){
			$condition["Product.category_id"] = $category_id;
		}
		$condition["Product.status"] = 1;
        $Product_list = $this->Product->find('all',array('conditions'=>$condition,'order'=>'Product.created desc',"limit"=>"20"));
       	$this->set('this_locale',$this->locale); 
       	$this->set('this_url',$this->server_host.$this->cart_webroot); 
       	$this->set('dynamic',"收费模板"); 
       	$this->set('this_config',$this->configs);
        $this->set('products',$Product_list); 
        Configure::write('debug',0);
	}		
}//end class

?>