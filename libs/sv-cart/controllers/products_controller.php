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
 * $Id: products_controller.php 1329 2009-05-11 11:29:59Z huangbo $
*****************************************************************************/
class ProductsController extends AppController {

	var $name = 'Products';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers = array('Html','Pagination'); // Added 
	var $uses = array('Product','ProductsCategory','Category','ProductGallery','ProductRelation','ProductArticle','Article','Comment','ProductType','UserRank','ProductRank','BookingProduct','Order','Brand','CouponType','ProductAttribute','ProductTypeAttribute');

    function view($id=""){
	//	Configure::write('debug', 0);
		
		if(!is_numeric($id) || $id<1){
			$this->flash('id不合法!',"/","","");
	    }
	    $this->page_init();
	    //商品详细
	    $this->Product->set_locale($this->locale);
	    $info = $this->Product->findbyid($id);
		
		$flat = 1;
	    if(empty($info)){
	       $this->pageTitle = $this->languages['products'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
		   $this->flash($this->languages['products'].$this->languages['not_exist'],"/","","");
		   $flat = 0;
	    }else if($info['Product']['status']!=1){
	       $this->pageTitle = $this->languages['products'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
	    	$this->flash($this->languages['products'].$this->languages['not_exist'],"/","","");
	    	$flat = 0;
	    }else if($info['Product']['forsale']!=1){
	       $this->pageTitle = $this->languages['product_out_of_sale']." - ".$this->configs['shop_title'];
	    	$this->flash($this->languages['product_out_of_sale'],"/","","");
	   		$flat = 0;
	    }

	    
	    if($flat == 1){
	    $this->Category->set_locale($this->locale);
		$categorys = $this->Category->findbyid($info['Product']['category_id']);
	    $info['Product']['view_stat'] =	$info['Product']['view_stat'] + 1;
		$this->Product->save($info);
		//pr($info);
		$category_info = $this->ProductsCategory->find('ProductsCategory.product_id ='.$info['Product']['id'].' and ProductsCategory.category_id ='.$info['Product']['category_id']);
		//$info['Category']
	//	pr($category_info);exit;
	    //当前位置
		if(isset($category_info['ProductsCategory'])){
			$info['ProductsCategory'] = $category_info['ProductsCategory'];
		}		
			$navigations=$this->Category->tree('P',$info['Product']['category_id']);
			if($categorys['Category']['parent_id'] == 0){
				$this->navigations[] = array('name'=>$categorys['CategoryI18n']['name'],'url'=>"/categories/".$categorys['Category']['id']);
			}
			if($categorys['Category']['parent_id'] == 1){
				$this->navigations[] = array('name'=>$navigations['tree']['0']['CategoryI18n']['name'],'url'=>"/categories/".$navigations['tree']['0']['Category']['id']);
				$this->navigations[] = array('name'=>$categorys['CategoryI18n']['name'],'url'=>"/categories/".$categorys['Category']['id']);
			}
		$this->navigations[] = array('name'=>$info['ProductI18n']['name'],'url'=>"/products/".$info['Product']['id']);
		$this->set('locations',$this->navigations);
		//商品基本信息
		$product_info=$this->Product->findbyid($id);
			if(isset($category_info['ProductsCategory'])){
			$product_info['ProductsCategory'] = $category_info['ProductsCategory'];
		}
		//是否有会员价
/*
		if(isset($_SESSION['User']) && $this->configs['show_member_level_price'] == 1){
			$product_rank=$this->ProductRank->findbyproduct_id($info['Product']['id']);
			if(is_array($product_rank)){
				if($product_rank['ProductRank']['is_default_rank'] == 0){
					$info['Product']['product_rank_price'] = $product_rank['ProductRank']['product_price'];
				}
				if($product_rank['ProductRank']['is_default_rank'] == 1){
					$info['Product']['product_rank_price'] = round($info['Product']['shop_price']*$_SESSION['User']['User']['rank_discount']/100,2);
				}
			}
		}*/
		if($product_info['Product']['coupon_type_id']>0){
			$this->CouponType->set_locale($this->locale);
			$coupon_type = $this->CouponType->findbyid($product_info['Product']['coupon_type_id']);
			$this->set('coupon_type',$coupon_type);
		}

		//是否有会员价end
		
		//pr($_SESSION);
		
		$this->data=$this->Product->localeformat($id,$this);
				//会员等级
		$this->UserRank->set_locale($this->locale);
		$user_rank_list=$this->UserRank->findrank();
		$product_rank = $this->ProductRank->findall('ProductRank.product_id ='.$id);
		
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
			  $user_rank_list[$k]['UserRank']['user_price']=($user_rank_list[$k]['UserRank']['discount']/100)*($this->data['Product']['shop_price']);			  
			}
			  if(isset($_SESSION['User']['User']['rank']) && $v['UserRank']['id'] == $_SESSION['User']['User']['rank']){
			  	  	$info['Product']['user_price'] = $user_rank_list[$k]['UserRank']['user_price'];
			  		$this->set('my_product_rank',$user_rank_list[$k]['UserRank']['user_price']);
			  }
		}
		if(!empty($info) && $info['Product']['status'] == 1 && $info['Product']['forsale'] == 1){
     		 $_SESSION['cookie_product']["$id"] = $info;
  		}
	//	pr($user_rank_list);
		$this->set('product_ranks',$user_rank_list);
		$this->set('info',$info);
		//商品类型
		$this->ProductType->set_locale($this->locale);
		//$product_type=$this->ProductType->gettypeformat($product_info['Product']['product_type_id']);
		if($product_info['Product']['product_type_id'] > 0){
		$product_type = $this->ProductType->findbyid($product_info['Product']['product_type_id']);
		$this->set("product_type",$product_type);
		}
		$product_attributes = $this->ProductAttribute->findallbyproduct_id($id);
		$format_product_attributes = array();
		$product_attributes_name = array();
		if(is_array($product_attributes) && sizeof($product_attributes)>0){
			foreach($product_attributes as $k=>$v){
				$this->ProductTypeAttribute->set_locale($this->locale);
				$p_t_a = $this->ProductTypeAttribute->findbyid($v['ProductAttribute']['product_type_attribute_id']);
				$format_product_attributes[$v['ProductAttribute']['product_type_attribute_id']][$k]['value'] = $v['ProductAttribute']['product_type_attribute_value'];
				$format_product_attributes[$v['ProductAttribute']['product_type_attribute_id']][$k]['price'] = $v['ProductAttribute']['product_type_attribute_price'];
				$product_attributes_name[$v['ProductAttribute']['product_type_attribute_id']] = $p_t_a['ProductTypeAttributeI18n']['name'];
			}
			$this->set('product_attributes_name',$product_attributes_name);
			$this->set('format_product_attributes',$format_product_attributes);
		}
	//	pr($format_product_attributes);
		$this->set('product_attributes',$product_attributes);
		//pr($product_attributes);
	//	相册
	    $galleries = $this->ProductGallery->findall("ProductGallery.product_id = '$id'",null,"orderby");
	    if(isset($this->configs['related_products_number']) && $this->configs['related_products_number'] > 0){
	    	$show_gallery_number = $this->configs['related_products_number'];
	    }else{
	    	$show_gallery_number = 4;
	    }
	    $galleries = array_slice($galleries,'0',$show_gallery_number);
	    if(sizeof($galleries) < $show_gallery_number){
	    	for($i=0;$i<$show_gallery_number - sizeof($galleries) ; $i++){
	    		$galleries[] =  array('ProductGallery'=>array('img_thumb' => "/img/product_default.jpg",
	    													'img_detail' => "/img/product_default.jpg",
	    													'img_original' => "/img/product_default.jpg",
	    													'description' => "/img/product_default.jpg"
	    							));
	    	}
	    }
	    
	    $this->set("galleries",$galleries);
	
	//	相关商品

		$relation_ids = $this->ProductRelation->find("list",array('conditions'=>"ProductRelation.Product_id = '$id' and Product.status =1 and Product.forsale =1",'recursive'=>1,'fields'=>'ProductRelation.related_product_id','order'=>'ProductRelation.orderby'));
		$relation_ids_is_double = $this->ProductRelation->find("list",array('conditions'=>"ProductRelation.related_product_id = '$id' and ProductRelation.is_double = 1 and Product.status =1 and Product.forsale =1",'recursive'=>1,'fields'=>'ProductRelation.product_id','order'=>'ProductRelation.orderby'));
		if(is_array($relation_ids_is_double) && sizeof($relation_ids_is_double)>0){
			foreach($relation_ids_is_double as $k=>$v){
				if(!in_array($v,$relation_ids)){
					$relation_ids[] = $v;
				}
			}
		}
		//pr($relation_ids);
		if(sizeof($relation_ids)>0){
			$relation_products = $this->Product->findall(array("Product.id"=>$relation_ids));
			if(isset($this->configs['related_products_number']) && $this->configs['related_products_number'] > 0){
				$relation_products = array_slice($relation_products,'0',$this->configs['related_products_number']);
			}
			$this->set("relation_products",$relation_products);
		}
		
	
	//	相关文章
		$article_ids = $this->ProductArticle->find("list",array('conditions'=>"ProductArticle.Product_id = '$id' and Article.status =1 ",'recursive'=>1,'fields'=>'ProductArticle.article_id','order'=>'ProductArticle.orderby'));
		
		
		if(sizeof($article_ids)>0){
			$this->Article->set_locale($this->locale);
			$articles = $this->Article->findall(array("Article.id"=>$article_ids));
			if(isset($this->configs['related_articles_number']) && $this->configs['related_articles_number'] >0){
				$articles = array_slice($articles,'0',$this->configs['related_articles_number']);
			}
			if(isset($this->configs['article_title_length']) && $this->configs['article_title_length'] >0){
				foreach($articles as $k=>$v){
					$articles[$k]['ArticleI18n']['title'] = $this->Article->sub_str($v['ArticleI18n']['title'],$this->configs['article_title_length']);
				}
			}
			
			$this->set("articles",$articles);
		}
	//	pr($this->configs['article_title_length']);
		
	//	用户评论
	// 设置用户的评论数
		if(isset($this->configs['comments_number'])){
			$show_comments_number = $this->configs['comments_number'];
		}else{
			$show_comments_number = 6;
		}
		$comments = $this->Comment->find('threaded',array('conditions'=>"Comment.type_id = '$id' and Comment.type = 'P' and Comment.status = 1",'recursive'=>1,'order'=>'Comment.modified desc','limit'=>$show_comments_number));
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
		// 商品分类
		$this->set('categorys',$categorys);
		$this->set('is_comments',$is_comments);
		$this->set('type','P');
		$this->pageTitle = $product_info['ProductI18n']['name']."-".$categorys['CategoryI18n']['name']." - ".$this->configs['shop_title'];
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
							"invalid_email" => $this->languages['email_letter'].$this->languages['format'].$this->languages['not_correct'],
							"tel_number_not_empty" => $this->languages['telephone'].$this->languages['can_not_empty'],
							"invalid_tel_number" => $this->languages['telephone'].$this->languages['format'].$this->languages['not_correct'],
							"comments_not_empty" => $this->languages['comments'].$this->languages['can_not_empty'],
							"select_level_comments" => $this->languages['please_choose'].$this->languages['comment_rank']
							);
		//please_choose

		$js_languages = $js_language + $js_error;

		$this->set('js_languages',$js_languages);
		$this->layout = 'default_full';
 	}
 	
	function search($type,$keywords='',$orderby="",$rownum='',$showtype="") {
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
	   $res_c=$this->Category->findassoc();
	   $res_b=$this->Brand->findassoc();
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

	/*********高级搜索开始*********/
	/*********ad_search   *********/
	function advancedsearch($type,$keywords='',$category_id=0,$brand_id=0,$min_price=0,$max_price=9999999,$orderby="",$rownum='',$showtype=""){
		
		$this->page_init();
		
		$keywords = UrlDecode($keywords);
		$orderby = UrlDecode($orderby);
		$showtype = UrlDecode($showtype);
		$not_show = 0;
		$rownum=isset($this->configs['products_list_num']) ? $this->configs['products_list_num']:((!empty($rownum)) ?$rownum:20);//取商店设置商品数量
		$showtype=isset($this->configs['products_list_showtype']) ? $this->configs['products_list_showtype']:((!empty($showtype)) ?$showtype:'L');//取商店设置商品显示方式
		
		
		if(empty($orderby)){
	 		$orderby=isset($this->configs['products_category_page_orderby_type'])? $this->configs['products_category_page_orderby_type']." ". $this->configs['products_category_page_orderby_method'] :((!empty($orderby)) ?$orderby:'created '.$this->configs['products_category_page_orderby_method']);
		}
		
		$url_keywords = $keywords;
	 	if($keywords == "all" && $category_id == 0 && $brand_id == 0){
	 	 	$keywords = $this->languages['all'].$this->languages['products'];
	 	 	$not_show = 1;
			$pid_array=$this->requestAction("/commons/search/$type/$keywords/$category_id/$brand_id/$min_price/$max_price");
	 	}else{
	 		if($keywords == 'all'){
	 		$keywords = 0;
			}
			$pid_array=$this->requestAction("/commons/search/$type/$keywords/$category_id/$brand_id/$min_price/$max_price");
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
		$condition = array("Product.id"=>$pid_array,'Product.status'=>1);
		//分页处理
		$total = $this->Product->findCount($condition,0);
		$sortClass='Product';
		$page=1;
		$parameters=Array($orderby,$rownum,$page);
		//pr($parameters);exit;
		$options=Array();
		$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass); // Added 
		$products = $this->Product->findall($condition,'',"Product.$orderby","$rownum",$page);
	    
	    //商品品牌分类
		$this->Category->set_locale($this->locale);
		$res_c=$this->Category->findassoc();
		$res_b=$this->Brand->findassoc();
		foreach($products as $k=>$v){
			$category_info = $this->ProductsCategory->find('ProductsCategory.product_id ='.$v['Product']['id'].' and ProductsCategory.category_id ='.$v['Product']['category_id']);
			$products[$k]['ProductsCategory'] = $category_info['ProductsCategory'];
			$v['ProductsCategory'] = $category_info['ProductsCategory'];
			if(isset($res_c[$v['ProductsCategory']['id']]['Category']['id'])){
				$products[$k]['Category']=$res_c[$v['ProductsCategory']['id']]['Category'];
				$products[$k]['CategoryI18n']=$res_c[$v['ProductsCategory']['id']]['CategoryI18n'];
			}
			if(isset($res_b[$v['Product']['brand_id']]['Brand']['id'])){
				$products[$k]['Brand']=$res_b[$v['Product']['brand_id']]['Brand'];
				$products[$k]['BrandI18n']=$res_b[$v['Product']['brand_id']]['BrandI18n'];
			}
				$products[$k]['Product']['user_price'] =$this->Product->user_price($k,$v,$this);
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
	  $this->set('showtype',$showtype);
	  
	  
	  $this->layout = 'default';
	}

	function search_autocomplete(){
		$products_formated=array();
		if(isset($_GET['query'])){
			$keyword=$_GET['query'];
	    	$products = $this->Product->search($this->locale,$keyword);
		    if(is_array($products)){
		    	foreach($products as $v){
		    		$product_result=array();
		    		if(isset($this->configs['search_prouduct_type'])){
		    			$type_arr = explode(';',$this->configs['search_prouduct_type']);
		    			if(is_array($type_arr)){
		    				$product_result['id']=$v['Product']['id'];
		    				foreach($type_arr as $kk=>$vv){
		    					if($vv == 0){
		    						$product_result['img']=$v['Product']['img_thumb'];
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
			    		$product_result['img']=$v['Product']['img_thumb'];
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
	Configure::write('debug', 2);
		if($this->RequestHandler->isPost()){
			unset($_SESSION['cookie_product']);
			$this->layout="ajax";
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
				$booking=(array)json_decode(StripSlashes($_POST['booking']));
				$booking['user_id'] = $_SESSION['User']['User']['id'];
				$now_time = date("Y-m-d H:i:s");
				$booking['booking_time'] = $now_time;
				$this->BookingProduct->save($booking);
				$result['message'] = $this->languages['out_stock_book_successful'];
				$result['type'] = 0;
			}else{
				$result['type'] = 1;
				$result['message']=$this->languages['time_out_relogin'];
			}
			$this->set('result',$result);
			$this->layout="ajax";
		}
	}
	function rss($category_id=0){
		$this->layout = '/rss/products';
		$this->Product->set_locale($this->locale);
		if($category_id!=0){
			$conditions['ProductsCategory.category_id']=$category_id;
		}
		$conditions['Product.status']=1;
        $products_list = $this->Product->find('all',array('conditions'=>$conditions,'limit'=>10,'order'=>'Product.created desc'));
       	$this->set('dynamic',"商品动态"); 
       	$this->set('this_config',$this->configs); 
        $this->set('products',$products_list); 
        Configure::write('debug',0);
	}
}//end class

?>