<?php
/*****************************************************************************
 * SV-Cart 商品管理
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
    var $helpers = array('Pagination','Html', 'Form', 'Javascript', 'Fck'); // Added    
	var $uses = array("ProductRank","TopicProduct","Product","UserRank","Category","Brand","Provider","BookingProduct","ProductType","ProductGallery","ProductRelation","ProductArticle","ProductI18n","ProductTypeAttribute","ProductAttribute","ProductsCategory","BrandI18n");
 
	function search(){
		$this->pageTitle = '待处理缺货'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'待处理缺货','url'=>'/products/search');
		$this->set('navigations',$this->navigations);
		$condition = '';
		$page = 1;
		$rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$parameters = array($rownum,$page);
		$options = array();
		$total = $this->BookingProduct->findCount($condition,0);
		$sortClass = 'BookingProduct';
		$page  = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		//取得缺货列表
		$data = $this->BookingProduct->findAll($condition);
		//根据缺货列表取商品ID
		foreach($data as $k=>$v){
			$product_id[$k] = $v['BookingProduct']['product_id'];
		}
		
		$this->Product->set_locale($this->locale);
		$condition = array("Product.id"=>$product_id);
        //取得缺货商品名列表
		$products = $this->Product->findall($condition);
		
		$assocproduct = array();
        foreach($products as $v){
        	$assocproduct[$v['Product']['id']]['Product']=$v['Product'];
        	$assocproduct[$v['Product']['id']]['ProductI18n']=$v['ProductI18n'];
        }
        foreach( $data as $k=>$v ){
        	if(isset($assocproduct[$v['BookingProduct']['product_id']])){
        		$new_data[$v['BookingProduct']['product_id']]=$v;
        	}
        }
      
		$this->set("assocproduct",$assocproduct);
		$this->set('bookingproducts',$new_data);
		
	}
	
	//缺货删除
	function search_remove($id){
		$this->BookingProduct->deleteAll("BookingProduct.id='$id'");
		$this->flash("删除成功",'/products/search/',10);
	}
/*------------------------------------------------------ */
//-- 编辑列表
/*------------------------------------------------------ */
	function index() {
		$this->pageTitle = "商品管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商品管理','url'=>'/products/');
		$this->set('navigations',$this->navigations);
	   $this->Product->set_locale($this->locale);
       $condition="1=1 and Product.status = 1 and extension_code!='virtual_card'";////////
	   //商品筛选查询条件
	   if(isset($this->params['url']['quantity']) && $this->params['url']['quantity'] != 0){
	   	   $condition .=" and Product.quantity <= '".$this->params['url']['quantity']."'";
	   }
	   if(isset($this->params['url']['forsale']) && $this->params['url']['forsale'] != '99'){
	   	   $condition .=" and Product.forsale = '".$this->params['url']['forsale']."'";
	   }
	   if(isset($this->params['url']['promotion_status']) && $this->params['url']['promotion_status'] != 0){
	   	   $condition .=" and Product.promotion_status = '".$this->params['url']['promotion_status']."'";
	   }	
	   if(isset($this->params['url']['category_id']) && $this->params['url']['category_id'] != 0){
			$condition .=" and Product.category_id = '".$this->params['url']['category_id']."'";
	   }
	   if(isset($this->params['url']['keywords']) && $this->params['url']['keywords'] != ''){
	   	   $condition .=" and ProductI18n.name like '%".$this->params['url']['keywords']."%' or Product.code= '%".$this->params['url']['keywords']."%'";
	   		$this->set('keywords',$this->params['url']['keywords']);
	   }
	   if(isset($this->params['url']['min_price']) && $this->params['url']['min_price'] != ''){
	   	   $condition .=" and Product.shop_price >= '".$this->params['url']['min_price']."'";
	   	   $this->set('min_price',$this->params['url']['min_price']);
	   }
	   if(isset($this->params['url']['max_price']) && $this->params['url']['max_price'] != ''){
	   	   $condition .=" and Product.shop_price <= '".$this->params['url']['max_price']."'";
	   	   $this->set('max_price',$this->params['url']['max_price']);
	   }
	   if(isset($this->params['url']['brand_id']) && $this->params['url']['brand_id'] != 0){
	   	   $condition .=" and Product.brand_id = '".$this->params['url']['brand_id']."'";
	   }
	   if(isset($this->params['url']['type_id']) && $this->params['url']['type_id'] != ''){
		   	   	$condition .=" and Product.product_type_id ='".$this->params['url']['type_id']."'";
	   }
	   if(isset($this->params['url']['date']) && $this->params['url']['date'] != ''){
	   	   $condition .=" and Product.created  >= '".$this->params['url']['date']."'";
	   	   $this->set('date',$this->params['url']['date']);
	   }
	   if(isset($this->params['url']['date2']) && $this->params['url']['date2'] != ''){
	   	   $condition .=" and Product.created  <= '".$this->params['url']['date2']." 23:59:59'";
	   	   $this->set('date2',$this->params['url']['date2']);
	   }
	   if(isset($this->params['url']['is_recommond']) && $this->params['url']['is_recommond'] != -1){
	   	   $condition .=" and Product.recommand_flag = '".$this->params['url']['is_recommond']."'";
	   }
	   if(isset($this->params['url']['provider_id']) && $this->params['url']['provider_id'] != -1){
	   	   $condition .=" and Product.provider_id  = '".$this->params['url']['provider_id']."'";
	   }
	   $total = $this->Product->findCount($condition,0);
	   $sortClass='Product';
	   $page=1;
	   $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	   $parameters=Array($rownum,$page);
	   $options=Array();
	   $page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
	   
	   
   	   $products_list=$this->Product->findAll($condition,'',"Product.created DESC",$rownum,$page);

	 
       //分类下拉列表
       $categories_tree=$this->Category->tree('P',$this->locale);
       //品牌下拉列表
       $this->Brand->set_locale($this->locale);
       $brands_tree=$this->Brand->getbrandformat();
       //类型下拉列表
       $types_tree=$this->ProductType->gettypeformat();
       
       //供应商列表
       $provides_tree=$this->Provider->findAll();
        //pr($types_tree);
       $category_id=isset($this->params['url']['category_id'])?$this->params['url']['category_id']:0;
       $forsale=isset($this->params['url']['forsale'])?$this->params['url']['forsale']:99;
   	   $brand_id=isset($this->params['url']['brand_id'])?$this->params['url']['brand_id']:0;
   	   $type_id=isset($this->params['url']['type_id'])?$this->params['url']['type_id']:0;
   	   $keywords=isset($this->params['url']['keywords'])?$this->params['url']['keywords']:'';
   	   $min_price=isset($this->params['url']['min_price'])?$this->params['url']['min_price']:'';
   	   $max_price=isset($this->params['url']['max_price'])?$this->params['url']['max_price']:'';
   	   $start_date=isset($this->params['url']['start_date'])?$this->params['url']['start_date']:'';
   	   $end_date=isset($this->params['url']['end_date'])?$this->params['url']['end_date']:'';
   	   $is_recommond=isset($this->params['url']['is_recommond'])?$this->params['url']['is_recommond']:-1;
   	   $provider_id=isset($this->params['url']['provider_id'])?$this->params['url']['provider_id']:-1;
   	   //pr($products_list);
   	   
   	   $this->set('forsale',$forsale);
   	   $this->set('products_list',$products_list);
   	   $this->set('navigations',$this->navigations);
   	   $this->set('categories_tree',$categories_tree);
   	   $this->set('brands_tree',$brands_tree);
   	   $this->set('types_tree',$types_tree);
   	   $this->set('provides_tree',$provides_tree);
   	   $this->set('category_id',$category_id);
   	   $this->set('brand_id',$brand_id);
   	   $this->set('type_id',$type_id);
   	   $this->set('keywords',$keywords);
   	   $this->set('min_price',$min_price);
   	   $this->set('max_price',$max_price);
   	   $this->set('start_date',$start_date);
   	   $this->set('end_date',$end_date);
   	   $this->set('is_recommond',$is_recommond);
   	   $this->set('provider_id',$provider_id);
   	   
	}

/*------------------------------------------------------ */
//-- 编辑商品页
/*------------------------------------------------------ */
	function view($id){
		
		$this->pageTitle = "编辑商品-商品管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商品管理','url'=>'/products/');
		$this->navigations[] = array('name'=>'编辑商品','url'=>'');
		$this->set('navigations',$this->navigations);
		$this->UserRank->set_locale($this->locale);
		if($this->RequestHandler->isPost()){
              
              $this->data['Product']['recommand_flag'] = isset($this->data['Product']['recommand_flag'])?$this->data['Product']['recommand_flag']:0;
              $this->data['Product']['forsale'] = isset($this->data['Product']['forsale'])?$this->data['Product']['forsale']:0;
              $this->data['Product']['alone'] = isset($this->data['Product']['alone'])?$this->data['Product']['alone']:0;
              $this->data['Product']['weight'] = !empty($this->data['Product']['weight'])?$this->data['Product']['weight']:"0";
	    	  $this->data['Product']['shop_price'] = !empty($this->data['Product']['shop_price'])?$this->data['Product']['shop_price']:"0";
			  $this->data['Product']['market_price'] = !empty($this->data['Product']['market_price'])?$this->data['Product']['market_price']:"0";
			  $this->data['Product']['point'] = !empty($this->data['Product']['point'])?$this->data['Product']['point']:"0";

           	  
              //更新通用信息和其他信息
              if(isset($this->params['form']['action_type']) && $this->params['form']['action_type'] == 'product_base_info'){
              	      //pr($this->data);
              	      foreach($this->data['ProductI18n'] as $v){
              	     	    $producti18n_info=array(
		                           'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'product_id'=> isset($v['product_id'])?$v['product_id']:$id,
		                           'name'=>	isset($v['name'])?$v['name']:'',
		                           'meta_keywords'=> $v['meta_keywords'],
		                           'meta_description'=>$v['meta_description'],
		                           'description'=>	$v['description']
		                     );
		                    if($v['locale'] == $this->locale){
		                    	$product_name = $v['name'];
		                    }
		                     $this->ProductI18n->saveall(array('ProductI18n'=>$producti18n_info));//更新多语言
              	     }
              	     if(!isset($this->data['Product']['promotion_status'])){
              	             $this->data['Product']['promotion_status'] = 0;
              	     }
              	     if(isset($this->params['form']['date'])){
              	     	    $this->data['Product']['promotion_start'] = $this->params['form']['date'];
              	     }
              	     if(isset($this->params['form']['date2'])){
              	     	    $this->data['Product']['promotion_end'] = $this->params['form']['date2']." 23:59:59";
              	     }
              	     if(empty($this->data['Product']['code'])){
	  	       	            $max_product=$this->Product->find("","","Product.id DESC");
	  	       	            $max_id=$max_product['Product']['id']+1;
	  	       	            //pr($max_product);
	  	       	            $this->data['Product']['code']=$this->generate_product_code($max_id);
	  	             }
              	     $this->data['Product']['product_name_style']=$this->params['form']['product_style_color'] . '+'.$this->params['form']['product_style_word'];
			         if(empty($this->data['Product']['quantity'])&&$this->data['Product']['quantity']!=0){
			         	    $this->data['Product']['quantity']=$this->configs['default_stock'];
			         }
			         $this->Product->save($this->data); //关联保存
			         //扩展分类
			         
			         //pr($this->params['form']['other_cat']);
			         $vcarr = array();
			         if(isset($this->params['form']['other_cat']) && is_array($this->params['form']['other_cat'])){
			                foreach($this->params['form']['other_cat'] as $kc=>$vc){
			                	if( $vc != 0){
			                		$vcarr[] = $vc;
			                	}
			                }
			                $this->ProductsCategory->handle_other_cat($this->data['Product']['id'], array_unique($vcarr));
						
			         	//pr(array_unique($arr));
			         }
		 
			         //会员等级价格
			         if(isset($this->params['form']['user_rank']) && is_array($this->params['form']['user_rank'])){
			         	    
			         	     foreach($this->params['form']['user_rank'] as $k=>$v){
			         	     	    $user_rank=array(
		                                     'id'=>	$v,
		                                     'discount'=>$this->params['form']['user_price_discount'][$k]
		                             );
		                       
		                        $this->UserRank->save(array('UserRank'=>$user_rank));
		                        
			         	     }
			         	     
			         	     $this->ProductRank->deleteAll(array('product_id'=>	$id));
			         	    
			         	     foreach($this->params['form']['user_rank'] as $k=>$v){
			         	     	 
			         	     	    $ProductRank=array(
		                                     'product_id'=>	$id,
		                                	 'rank_id'=>$v,
		                                	 'id'=>$this->params['form']['productrank_id'][$k],
		                                     'product_price'=>$this->params['form']['rank_product_price'][$k],
		                                	'is_default_rank'=>!empty($this->params['form']['is_default_rank'][$k])?$this->params['form']['is_default_rank'][$k]:0
		                             );

		                        $this->ProductRank->saveAll(array('ProductRank'=>$ProductRank));
		                        
			         	     }
			         	     
			         }
			         $product_code = $this->data['Product']['code'];
			         $this->flash("商品 ".$product_code." ".$product_name." 编辑成功。点击继续编辑该商品。",'/products/'.$id,10);
              	     
              }
              //更新商品相册
              if(isset($this->params['form']['action_type']) && $this->params['form']['action_type'] == 'product_gallery'){
              	     // pr($this->params);
              	      /*foreach($this->data['ProductGallery'] as $k=>$v){
              	    	      $this->ProductGallery->save($this->data['ProductGallery'][$k]); //关联保存
              	      }*/
              	      if(!empty($this->params['form']['img_url'])){
              	      	  //缩略图,详细图,原图
              	      	  $pro_info=$this->Product->findbyid($this->params['form']['product_id']);
              	      	  
              	      	  $imgurl = $this->params['form']['img_url'];
              	      	  foreach($imgurl as $k=>$v){
              	      	  	  if(!empty($v)){
              	      	  	  $image_name=basename($v);//basename($this->params['form']['img_url']);
	              	      	  $dir_name=substr($v,0,strrpos($v,'/'));
	              	      	  //echo $dir_name;
	              	      	  $img_thumb=$dir_name.'/'.$image_name;
	              	      	  $img_detail=$dir_name.'/detail/'.$image_name;
	              	      	  $img_original=$dir_name.'/original/'.$image_name;
	              	      	  //echo $img_thumb;
	              	      	        $product_gallery=array(
	              	      	        	    'img_original'=> $img_original,
	              	      	        	    'img_thumb'=> $img_thumb,
	              	      	        	    'img_detail'=> $img_detail,
			                                'orderby'=> !empty($this->params['form']['img_sort'][$k])?$this->params['form']['img_sort'][$k]:50,
			                                'description'=>	 $this->params['form']['img_desc'][$k],
			                                'product_id'=> $this->params['form']['product_id']
			                         );
			                        $this->ProductGallery->saveAll(array('ProductGallery'=>$product_gallery));//更新多语言
			                        $product=array(
	              	      	        	    'img_original'=> $img_original,
	              	      	        	    'img_thumb'=> $img_thumb,
	              	      	        	    'img_detail'=> $img_detail,
			                                'id'=> $this->params['form']['product_id']
			                         );
			                        $this->Product->saveAll(array('Product'=>$product));
		                        
		                  }
		                  }
              	      }
              	      $product_info_img = $this->Product->findById($id);
              	      $product_code = $product_info_img['Product']['code'];
              	      $product_name = $product_info_img['ProductI18n']['name'];
			          $this->flash("商品 ".$product_code." ".$product_name." 编辑相册成功。点击继续编辑该商品。",'/products/'.$id,10);
              }
              //更新商品属性
              if(isset($this->params['form']['action_type']) && $this->params['form']['action_type'] == 'product_attr'){
              	   
              	   $this->Product->updateAll(
			              array('Product.product_type_id' =>$this->params['form']['product_type']),
			              array('Product.id' =>$this->params['data']['Product']['id'])
			           );
              	   // pr($this->params);
              	    $products_attr_list = array();
              	    // 取得原有的属性值
              	    $condition="ProductTypeAttribute.product_type_id= '".$this->params['form']['product_type']."'";
              	    $attr_res=$this->ProductTypeAttribute->findAll($condition,"DISTINCT ProductTypeAttribute.*");
              	    //pr($attr_res);
              	    $attr_list = array();
              	    
              	    $condition="ProductAttribute.product_id= '".$this->params['data']['Product']['id']."'";
              	    $lists=$this->ProductAttribute->findAll($condition,"DISTINCT ProductAttribute.*");
              	    
              	    
              	    foreach($lists as $k=>$v){
              	    	  $products_attr_list[$v['ProductAttribute']['product_type_attribute_id']][$v['ProductAttribute']['product_type_attribute_value']]=$v;
              	    	  $products_attr_list[$v['ProductAttribute']['product_type_attribute_id']][$v['ProductAttribute']['product_type_attribute_value']]['ProductAttribute']['sign']='delete';
              	    }
              	    
              	   // pr($products_attr_list);
              	    // 循环现有的，根据原有的做相应处理
              	    
              	    foreach($this->params['form']['attr_id_list'] AS $key => $attr_id){
              	    	    $attr_value = $this->params['form']['attr_value_list'][$key];
                            $attr_price = $this->params['form']['attr_price_list'][$key];
                            if (!empty($attr_value)){
                            	   if (isset($products_attr_list[$attr_id][$attr_value])){
                            	   	      // 如果原来有，标记为更新
                            	   	      $products_attr_list[$attr_id][$attr_value]['ProductAttribute']['sign'] = 'update';
                            	   	      $products_attr_list[$attr_id][$attr_value]['ProductAttribute']['attr_price'] = $attr_price;
                            	   }
                            	   else{
                            	   	      // 如果原来没有，标记为新增
                                          $products_attr_list[$attr_id][$attr_value]['ProductAttribute']['sign'] = 'insert';
                                          $products_attr_list[$attr_id][$attr_value]['ProductAttribute']['attr_price'] = $attr_price;
                            	   }
                            }
                            
              	    }
              	//    pr($products_attr_list);
              	    /* 插入、更新、删除数据 */
              	    foreach ($products_attr_list as $attr_id => $attr_value_list){
              	    	   foreach ($attr_value_list as $attr_value => $info){
              	    	   	       if ($info['ProductAttribute']['sign'] == 'insert'){
              	    	   	       	             $productattr_info=array(
              	    	   	       	             	 			'id' => '',
		                                                        'product_id'=>	$this->params['data']['Product']['id'],
		                                                        'product_type_attribute_id'=>$attr_id,
		                                                        'product_type_attribute_value'=>	$attr_value,
		                                                        'product_type_attribute_price'=>  $info['ProductAttribute']['attr_price']
		                                          );
		                                      //   pr($productattr_info);
		                                         $this->ProductAttribute->save(array('ProductAttribute'=>$productattr_info));
              	    	   	       }
              	    	   	       elseif($info['ProductAttribute']['sign'] == 'update'){
              	    	   	       	             $productattr_info=array(
              	    	   	       	             	            'id'=>	@$info['ProductAttribute']['id'],
		                                                        'product_id'=>	$this->params['data']['Product']['id'],
		                                                        'product_type_attribute_id'=>$attr_id,
		                                                        'product_type_attribute_value'=>	$attr_value,
		                                                        'product_type_attribute_price'=>  $info['ProductAttribute']['attr_price']
		                                          );
		                                         $this->ProductAttribute->save(array('ProductAttribute'=>$productattr_info));
              	    	   	       }
              	    	   	       else{
              	    	   	       	             $this->ProductAttribute->del($info['ProductAttribute']['id']);
              	    	   	       }
              	    	   }
              	    }
						$product_info_img = $this->Product->findById($id);
              	      $product_code = $product_info_img['Product']['code'];
              	      $product_name = $product_info_img['ProductI18n']['name'];
			          $this->flash("商品 ".$product_code." ".$product_name." 属性编辑成功。点击继续编辑该商品。",'/products/'.$id,10);
     
              
              }
		}
		//分类下拉列表
        $categories_tree=$this->Category->tree('P',$this->locale);
        //品牌下拉列表
   		$this->Brand->set_locale($this->locale);
        $brands_tree=$this->Brand->getbrandformat();
        //文章分类
        $article_cat=$this->Category->getbrandformat();
        //pr($article_cat);
		$this->data=$this->Product->localeformat($id);
		
		//pr($this->data);
		/* 根据商品重量的单位重新计算 */
        if ($this->data['Product']['weight'] >= 0)
        {
            $this->data['Product']['products_weight_by_unit'] = ($this->data['Product']['weight'] >= 1) ? $this->data['Product']['weight'] : ($this->data['Product']['weight'] / 0.001);
        }
        
        $products_name_style = explode('+', empty($this->data['Product']['product_name_style']) ? '+' : $this->data['Product']['product_name_style']);
	    //类型下拉列表
        $types_tree=$this->ProductType->gettypeformat($this->data['Product']['product_type_id']);
        //属性规格html
        $products_attr_html=$this->requestAction("/commons/build_attr_html/".$this->data['Product']['product_type_id']."/".$id."");
		$weight_unit=$this->RequestHandler->isPost() ? '1' : ($this->data['Product']['weight'] >= 1 ? '1' : '0.001');
		//商品相册
		$product_gallery=$this->ProductGallery->findAll(" ProductGallery.product_id = '".$id."'");
		foreach($product_gallery as $k=>$v){
			$this->data['ProductGallery'][$k]=$product_gallery[$k]['ProductGallery'];
		}
		//扩展分类
		$other_cat=$this->ProductsCategory->findAll(" ProductsCategory.product_id = '".$id."'");
		foreach($other_cat as $k=>$v){
			   $this->data['other_cat'][$k]=$v;
		}
	//	pr($this->data);
		//关联商品
		
		$this->Product->set_locale($this->locale);
		$product_relations=$this->requestAction("/commons/get_linked_products/".$id."");
	    //关联文章
	    $product_articles=$this->requestAction("/commons/get_products_articles/".$id."");
		//pr($product_articles);
		//会员等级
		$user_rank_list=$this->UserRank->findrank();
		foreach( $user_rank_list as $k=>$v ){
			$rank_id = $v['UserRank']['id'];
			$product_id = $id;
			$productrank = $this->ProductRank->find(array('product_id'=>$product_id,'rank_id'=>$rank_id));

			if($productrank['ProductRank']['is_default_rank']==1){
				$user_rank_list[$k]['UserRank']['product_price'] = ($user_rank_list[$k]['UserRank']['discount']/100)*($this->data['Product']['shop_price']);
				$user_rank_list[$k]['UserRank']['is_default_rank'] = $productrank['ProductRank']['is_default_rank'];
				$user_rank_list[$k]['UserRank']['productrank_id'] = $productrank['ProductRank']['id'];
			
			}else{
				$user_rank_list[$k]['UserRank']['product_price'] = $productrank['ProductRank']['product_price'];
				$user_rank_list[$k]['UserRank']['is_default_rank'] = $productrank['ProductRank']['is_default_rank'];
				$user_rank_list[$k]['UserRank']['productrank_id'] = $productrank['ProductRank']['id'];
			
			}
		}
		
		//$attributes_info = $this->Attribute->findAll();
		
		//pr($user_rank_list);
		//供应商
		$provider_list = $this->Provider->get_provider_list();
		
		$this->set('provider_list',$provider_list);
		$this->set('categories_tree',$categories_tree);
		$this->set('brands_tree',$brands_tree);
		$this->set('weight_unit', $weight_unit);
		$this->set('types_tree', $types_tree);
		$this->set('product_gallery', $product_gallery);
		$this->set('product_relations', $product_relations);
		$this->set('article_cat', $article_cat);
		$this->set('product_articles', $product_articles);
		$this->set('products_attr_html', $products_attr_html);
		$this->set('user_rank_list', $user_rank_list);
		$this->set('products_name_color', $products_name_style[0]);
        $this->set('products_name_style', $products_name_style[1]);
        
		$this->set('market_price_rate',$this->configs['market_price_rate']);
	}
/*------------------------------------------------------ */
//-- 添加商品
/*------------------------------------------------------ */
function add(){
	
	$this->pageTitle = "添加商品-商品管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商品管理','url'=>'/products/');
		$this->navigations[] = array('name'=>'添加商品','url'=>'');
		$this->set('navigations',$this->navigations);
		$this->UserRank->set_locale($this->locale);
	    if($this->RequestHandler->isPost()){
	    	
	    	$this->data['Product']['weight'] = !empty($this->data['Product']['weight'])?$this->data['Product']['weight']:"0";
	    	$this->data['Product']['shop_price'] = !empty($this->data['Product']['shop_price'])?$this->data['Product']['shop_price']:"0";
			$this->data['Product']['market_price'] = !empty($this->data['Product']['market_price'])?$this->data['Product']['market_price']:"0";
			$this->data['Product']['product_name_style']=$this->params['form']['product_style_color'] . '+'.$this->params['form']['product_style_word'];
			$this->data['Product']['point'] = !empty($this->data['Product']['point'])?$this->data['Product']['point']:"0";


	  	       //新增商品
	  	       if(empty($this->data['Product']['code'])){
	  	       	      $max_product=$this->Product->find("","","Product.id DESC");
	  	       	      $max_id=$max_product['Product']['id']+1;
	  	       	      //pr($max_product);
	  	       	      $this->data['Product']['code']=$this->generate_product_code($max_id);
	  	       }
			   if(empty($this->data['Product']['quantity'])){
			      	    $this->data['Product']['quantity']=$this->configs['default_stock'];
			   }
			   if(!isset($this->data['Product']['promotion_status'])){
              	             $this->data['Product']['promotion_status'] = 0;
              	     }
              	if(isset($this->params['form']['date'])){
              	     	    $this->data['Product']['promotion_start'] = $this->params['form']['date'];
              	     }
              	if(isset($this->params['form']['date2'])){
              	     	    $this->data['Product']['promotion_end'] = $this->params['form']['date2']." 23:59:59";
              }
			   //pr($this->data);die();
			   $this->Product->save($this->data['Product']); //关联保存
			   $id=$this->Product->id;
			   //新增商品多语言
			   
			   	if(is_array($this->data['ProductI18n']))
			          foreach($this->data['ProductI18n'] as $k => $v){
				            $v['product_id']=$id;
				            $this->ProductI18n->id='';
				            $this->ProductI18n->save($v); 
			           }
			           
			  //新增商品分类关联
			  
			  $this->data['ProductsCategory']['product_id']=$id;
			  $this->ProductsCategory->save($this->data['ProductsCategory']);
			  //扩展分类
		
			  if(isset($this->params['form']['other_cat']) && is_array($this->params['form']['other_cat'])){
			            $this->ProductsCategory->handle_other_cat($id, array_unique($this->params['form']['other_cat']));
			  }
			  $id = $this->Product->getLastInsertId();
			  $product_info_img = $this->Product->findById($id);
			  $product_code = $product_info_img['Product']['code'];
              $product_name = $product_info_img['ProductI18n']['name'];
              
              $crdir = "../img/products/".$product_code;
			  if(!is_dir($crdir)){
				 mkdir($crdir, 0700);
			  }
			  $crdir = "../img/products/".$product_code."/detail/";
			  if(!is_dir($crdir)){
				 mkdir($crdir, 0700);
			  }
			  $crdir = "../img/products/".$product_code."/original/";
			  if(!is_dir($crdir)){
				 mkdir($crdir, 0700);
			  }
              //rename($file, $newfile));
              
              //商品相册
              $img_url = $_REQUEST['img_url'];
              
              $img_sort = $_REQUEST['img_sort'];
              $img_desc = $_REQUEST['img_desc'];
              foreach($img_url as $k=>$v){
					if($v!=""){
              	      	  	  $image_name=basename($v);
	              	      	  $dir_name=substr($v,0,strrpos($v,'/'));
	              	      	  $img_thumb=$dir_name.'/'.$image_name;
	              	      	  
	              	      	  @rename("..".$img_thumb, "../img/products/".$product_code."/".$image_name);
	              	      	  $img_thumb = "/img/products/".$product_code."/".$image_name;
							  
	              	      	  $img_detail=$dir_name.'/detail/'.$image_name;
	              	      	  @rename("..".$img_detail, "../img/products/".$product_code."/detail/".$image_name);
	              	      	  $img_detail = "/img/products/".$product_code."/detail/".$image_name;
	              	      	  
	              	      	  $img_original=$dir_name.'/original/'.$image_name;
							  @rename("..".$img_original, "../img/products/".$product_code."/original/".$image_name);
	              	      	  $img_original = "/img/products/".$product_code."/original/".$image_name;
	              	      	  
	              	      	  
	              	      	  
	              	      	  
	              	      	  $product_gallery=array(
	              	      	        	    'img_original'=> $img_original,
	              	      	        	    'img_thumb'=> $img_thumb,
	              	      	        	    'img_detail'=> $img_detail,
			                                'orderby'=> !empty($img_sort[$k])?$img_sort[$k]:50,
			                                'description'=>$img_desc[$k],
			                                'product_id'=> $id
			                         );
			                        $this->ProductGallery->saveAll(array('ProductGallery'=>$product_gallery));//更新多语言
			                        $product=array(
	              	      	        	    'img_original'=> $img_original,
	              	      	        	    'img_thumb'=> $img_thumb,
	              	      	        	    'img_detail'=> $img_detail,
			                                'id'=> $id
			                         );
			                        
			                        $this->Product->saveAll(array('Product'=>$product));
		                        
		                  }
              
              }
              
              //会员等级价格
			  if(isset($this->params['form']['user_rank']) && is_array($this->params['form']['user_rank'])){
			         	    
			         	     foreach($this->params['form']['user_rank'] as $k=>$v){
			         	     	    $user_rank=array(
		                                     'id'=>	$v,
		                                     'discount'=>$this->params['form']['user_price_discount'][$k]
		                             );
		                       
		                        $this->UserRank->save(array('UserRank'=>$user_rank));
		                        
			         	     }
			         	     foreach($this->params['form']['user_rank'] as $k=>$v){
			         	     	 	$is_d_rank = !empty($this->params['form']['is_default_rank'][$k])?$this->params['form']['is_default_rank'][$k]:0;
			         	     	    $ProductRank=array(
		                                     'product_id'=>	$id,
		                                	 'rank_id'=>$v,
		                                	 'id'=>$this->params['form']['productrank_id'][$k],
		                                     'product_price'=>$this->params['form']['rank_product_price'][$k],
		                                	'is_default_rank'=>!empty($this->params['form']['is_default_rank'][$k])?$this->params['form']['is_default_rank'][$k]:0
		                             );

		                        $this->ProductRank->saveAll(array('ProductRank'=>$ProductRank));
		                        
			         	     }
			         	     
			         }
			  $this->flash("商品 ".$product_code." ".$product_name." 添加成功。点击继续编辑该商品。",'/products/'.$id,10);
			  //$this->flash("添加成功",'/products/','');
	    }
	    //分类下拉列表
        $categories_tree=$this->Category->tree('P',$this->locale);
        //品牌下拉列表
        $brands_tree=$this->Brand->getbrandformat();
        foreach( $brands_tree as $k=>$v ){
        	if( $v['BrandI18n']['locale'] == $this->locale ){
        		$new_brands_tree[]=$v;
        	}
        }
        //会员等级
		$user_rank_list=$this->UserRank->findrank();
		
        $this->set('categories_tree',$categories_tree);
		$this->set('brands_tree',$new_brands_tree);
				//供应商
		$provider_list = $this->Provider->get_provider_list();
		$this->set('user_rank_list', $user_rank_list);
		$this->set('provider_list',$provider_list);
		$this->set('market_price_rate',$this->configs['market_price_rate']);
		
}
/*------------------------------------------------------ */
//-- 商品进回收站
/*------------------------------------------------------ */
	function trash($id){
	  	 $this->Product->updateAll(
			              array('Product.status' => 2),
			              array('Product.id' => $id)
			           );
         $this->flash("该商品已经进入回收站",'/products/',10);
	}
/*------------------------------------------------------ */
//-- 复制商品
/*------------------------------------------------------ */
	function copy_pro($original_pro_id){
		$this->Product->hasOne = array();
		$this->Product->hasOne = array('ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'Product_id'
					                        	 ) ,
								);
		$original_pro=$this->Product->findall(array("Product.id"=>$original_pro_id));
		
		foreach( $original_pro as $k=>$v ){
			$max_product=$this->Product->find("","","Product.id DESC");
	  	    $max_id=$max_product['Product']['id']+1;
	  	    //pr($max_product);
	  	    $v['Product']['code']=$this->generate_product_code($max_id);
			$v['Product']['id'] = $max_id;
			$v['Product']['promotion_price'] = "0";//促销价
			$v['Product']['promotion_status'] = "0";//促销状态
			$v['Product']['recommand_flag'] = "0";//推荐状态
			
			$v['Product']['forsale'] = "0";//商品是否上架
			$v['Product']['quantity']="0";//商品库存
			$v['ProductI18n']['id'] = "";
			$v['ProductI18n']['product_id'] = $max_id;
			
			$products['Product'] = $v['Product'];
			$products['ProductI18n'][] = $v['ProductI18n'];
		}
		
		$this->Product->save(array('Product'=>$products['Product']));//复制商品基本信息
		foreach( $products['ProductI18n'] as  $ka=>$va ){
			$this->ProductI18n->save(array('ProductI18n'=>$va));//复制商品多语言信息
		}
		$original_img = $this->ProductGallery->findall(array('ProductGallery.Product_id'=>$original_pro_id));
		foreach( $original_img as $k=>$v ){
			$original_img[$k]['ProductGallery']['product_id'] = $max_id;
			$original_img[$k]['ProductGallery']['id'] = "";
		}
		$this->ProductGallery->saveall($original_img);
		$this->flash("复制商品成功",'/products/','');

	}
/*------------------------------------------------------ */
//-- 删除商品相册图片
/*------------------------------------------------------ */
	function drop_img($img_id){
		    //删除图片文件
		    $img_info=$this->ProductGallery->findbyid($img_id);
		    if ($img_info['ProductGallery']['img_detail'] != '' && is_file('../' . $img_info['ProductGallery']['img_detail'])){
                    @unlink('../' . $img_info['ProductGallery']['img_detail']);
             }
            if ($img_info['ProductGallery']['img_thumb'] != '' && is_file('../' . $img_info['ProductGallery']['img_thumb'])){
                    @unlink('../' . $img_info['ProductGallery']['thumb_url']);
             }
            if ($img_info['ProductGallery']['img_original'] != '' && is_file('../' . $img_info['ProductGallery']['img_original'])){
                    @unlink('../' . $img_info['ProductGallery']['img_original']);
             }
            //删除图片数据
		    $this->ProductGallery->del($img_id);
		    Configure::write('debug',0);
            $result['type'] = "0";
            $result['msg'] = "删除成功";
            die(json_encode($result));
	}
/*------------------------------------------------------ */
//-- 关联商品列表搜索
/*------------------------------------------------------ */

	function searchproducts($keywords="all",$cat_id="0",$brand_id="0",$products_id="0"){
		   $condition="Product.forsale=1 and Product.status=1 ";
		   if($keywords != "all"){
		       $condition .=" and (Product.code like '%$keywords%' or ProductI18n.name like '%$keywords%' or ProductI18n.description like '%$keywords%' or Product.id='$keywords') ";
		   }
		   if($cat_id != "0"){
		   	   $condition .= " and Product.category_id = '$cat_id'";
		   }
		   if($brand_id != "0"){
		   	   $condition .= " and Product.brand_id = '$brand_id'";
		   }
		   if($products_id != "0"){
		   	   $condition .= " and Product.id != '$products_id'";
		   
		   }
		   //$related_product_id = $this->ProductRelation->findall(array('ProductRelation.product_id'=>$products_id),'DISTINCT ProductRelation.related_product_id');
	       $Pids=$this->Product->findall($condition,'DISTINCT Product.id','Product.created ASC');

	       //pr($Pids);
	       $pid_array=array();
	      if(is_array($Pids)){
	    	   foreach($Pids as $v ){
	    		   $pid_array[]=$v['Product']['id'];
	    	   }
	      }
	      $this->Product->set_locale($this->locale);
 	      $condition = array("Product.id"=>$pid_array);
	      $products_tree=$this->Product->findall($condition,'','Product.created DESC');

	      $this->set('products_tree',$products_tree);
	      
	      //显示的页面
	      Configure::write('debug',0);
          $result['type'] = "0";
          $result['message']=$products_tree;
          die(json_encode($result));
	}
/*------------------------------------------------------ */
//-- 把商品加入关联
/*------------------------------------------------------ */
	function insert_link_products($link_id,$id,$is_double,$type){
		   $link_product_id=$link_id;
		   if($is_double == 'false'){
		   	   $is_double=1;
		   }
		   else{
		   	   $is_double=0;
		   }
		    //增加关联商品
		    	  //$this->ProductRelation->deleteAll(array('ProductRelation.related_product_id'=>$link_product_id));
				   if($is_double){
			             $linkproduct_info1=array(
		                            'product_id'=>	$link_product_id,
		                            'related_product_id'=>	$id,
		                            'is_double'=>	$is_double
		                  );
		               $product_rela = $this->ProductRelation->find($linkproduct_info1);
		               if(empty($product_rela)){
		               		$this->ProductRelation->save(array('ProductRelation'=>$linkproduct_info1));
		               }
		               
				     }
			         $linkproduct_info2=array(
		                      'product_id'=>	$id,
		                      'related_product_id'=>$link_product_id,
		                      'is_double'=>	$is_double
		              );
		             $linkproduct_info22=array(
		                      'product_id'=>$link_product_id,
		                      'related_product_id'=>$id	,
		                      'is_double'=>	$is_double
		              );
		              $product_rela2 = $this->ProductRelation->find($linkproduct_info2);
					  $product_rela22 = $this->ProductRelation->find($linkproduct_info22);
					  if(empty($product_rela22)){
		              	$this->ProductRelation->saveall(array('ProductRelation'=>$linkproduct_info22));
		              }
		              if(empty($product_rela2)){
		              	  
		              	$this->ProductRelation->saveall(array('ProductRelation'=>$linkproduct_info2));
		              }
		              
		              
		              //调整关联区商品
		              $this->Product->set_locale($this->locale);
				   	  $linked_products = $this->requestAction("/commons/get_linked_products/".$id."");
				   	  
			//页面显示
			Configure::write('debug',0);
            $result['type'] = "0";
            $result['msg'] = $linked_products;
            $result['type'] = $type;
            die(json_encode($result));
	}
/*------------------------------------------------------ */
//-- 把商品加入专题关联topic_products
/*------------------------------------------------------ */
	function insert_link_topic_products($link_id,$id,$is_double,$type){
		   $link_product_id=$link_id;
		   if($is_double == 'false'){
		   	   $is_double=1;
		   }
		   else{
		   	   $is_double=0;
		   }
		    //增加关联商品
				   if($is_double){
			             $linkproduct_info1=array(
		                            'product_id'=>	$link_product_id,
		                            'topic_id'=>	$id
		                  );
		               $this->TopicProduct->save(array('TopicProduct'=>$linkproduct_info1));
				     }
			         $linkproduct_info2=array(
		                     		'product_id'=>	$link_product_id,
		                            'topic_id'=>	$id
		              );
		              $this->TopicProduct->save(array('TopicProduct'=>$linkproduct_info2));
		              //调整关联区商品
				   	  $linked_products = $this->requestAction("/commons/get_linked_topic_products/".$id."");
				   	  
			//页面显示
			Configure::write('debug',0);
            $result['type'] = "0";
            $result['msg'] = $linked_products;
            $result['type'] = $type;
            die(json_encode($result));
	}
/*------------------------------------------------------ */
//-- 把文章加入商品关联articles_products
/*------------------------------------------------------ */
	function insert_link_article_products($link_id,$id,$is_double,$type){
		   $link_product_id=$link_id;
		   if($is_double == 'false'){
		   	   $is_double=1;
		   }
		   else{
		   	   $is_double=0;
		   }
		    //增加关联商品
				   if($is_double){
			             $linkproduct_info1=array(
		                            'product_id'=>	$link_product_id,
		                            'article_id'=>	$id
		                  );
		               $this->ProductArticle->save(array('ProductArticle'=>$linkproduct_info1));
				     }
			         $linkproduct_info2=array(
		                     		'product_id'=>	$link_product_id,
		                            'article_id'=>	$id
		              );
		              $this->ProductArticle->save(array('ProductArticle'=>$linkproduct_info2));
		              //调整关联区商品
				   	  $linked_products = $this->requestAction("/commons/get_articles_products/".$id."");
				   	  
			//页面显示
			Configure::write('debug',0);
            $result['type'] = "0";
            $result['msg'] = $linked_products;
            $result['type'] = $type;
            die(json_encode($result));
	}
/*------------------------------------------------------ */
//-- 删除关联商品
/*------------------------------------------------------ */
    function drop_link_products($drop_id,$id,$is_signle,$type){
    	   $link_product_id=$drop_id;
    	   if(!$is_signle){
    	   	    $condition = "ProductRelation.product_id = '".$link_product_id."' and ProductRelation.related_product_id = '".$id."'";
    	   	    $this->ProductRelation->deleteAll($condition);
    	   }
    	   $condition = "ProductRelation.related_product_id = '".$link_product_id."' and ProductRelation.product_id = '".$id."'";
    	   $this->ProductRelation->deleteAll($condition);
    	   $this->Product->set_locale($this->locale);
    	   $linked_products   = $this->requestAction("/commons/get_linked_products/".$id."");
    	//   pr($linked_products);
    	   	//页面显示
			Configure::write('debug',0);
            $result['type'] = "0";
            $result['msg'] = $linked_products;
            $result['type'] = $type;
            die(json_encode($result));
    }
/*------------------------------------------------------ */
//-- 删除专题关联商品
/*------------------------------------------------------ */
    function drop_link_topic_products($drop_id,$id,$type){
    	   $link_product_id=$drop_id;
    	   
    	   $condition = "TopicProduct.product_id = '".$link_product_id."' and TopicProduct.topic_id = '".$id."'";
    	   $this->TopicProduct->deleteAll($condition);
    	   $linked_products   = $this->requestAction("/commons/get_linked_topic_products/".$id."");
    	//   pr($linked_products);
    	   	//页面显示
			Configure::write('debug',0);
            $result['type'] = "0";
            $result['msg'] = $linked_products;
            $result['type'] = $type;
            die(json_encode($result));
    }
/*------------------------------------------------------ */
//-- 删除文章关联商品
/*------------------------------------------------------ */
    function drop_link_article_products($drop_id,$id,$type){
    	   $link_product_id=$drop_id;
    	   
    	   $condition = "ProductArticle.product_id = '".$link_product_id."' and ProductArticle.article_id = '".$id."'";
    	   $this->ProductArticle->deleteAll($condition);
    	   $linked_products   = $this->requestAction("/commons/get_articles_products/".$id."");
    	//   pr($linked_products);
    	   	//页面显示
			Configure::write('debug',0);
            $result['type'] = "0";
            $result['msg'] = $linked_products;
            $result['type'] = $type;
            die(json_encode($result));
    }
/*------------------------------------------------------ */
//-- 增加关联文章
/*------------------------------------------------------ */
	function insert_product_articles($link_id,$id,$is_double,$type){
		   $link_article_id=$link_id;
		   if($is_double == 'false'){
		   	   $is_double=1;
		   }
		   else{
		   	   $is_double=0;
		   }
		    //增加关联文章
		    		    $this->ProductArticle->deleteAll(array('ProductArticle.article_id'=>$link_article_id));

				   if($is_double){
			             $link_article_info1=array(
		                            'product_id'=>	$link_article_id,
		                            'article_id'=>	$id,
		                            'is_double'=>	$is_double
		                  );
		                 $this->ProductArticle->save(array('ProductArticle'=>$link_article_info1));
				     }
			         $link_article_info2=array(
		                            'product_id'=>	$id,
		                            'article_id'=>	$link_article_id,
		                            'is_double'=>	$is_double
		              );
		              $this->ProductArticle->save(array('ProductArticle'=>$link_article_info2));
		              //调整关联区文章
				   	  $linked_articles   = $this->requestAction("/commons/get_products_articles/".$id."");
				   	  
		//	pr($link_product_id);
			//页面显示
			Configure::write('debug',0);
            $result['type'] = "0";
            $result['msg'] = $linked_articles;
            $result['type'] = $type;
            die(json_encode($result));
	}
/*------------------------------------------------------ */
//-- 删除关联文章
/*------------------------------------------------------ */
    function drop_product_articles($drop_id,$id,$is_signle,$type){
    	   $link_article_id=$drop_id;
    	   if(!$is_signle){
    	   	    $condition = "ProductArticle.product_id = '".$link_article_id."' and ProductArticle.article_id = '".$id."'";
    	   	    $this->ProductArticle->deleteAll($condition);
    	   }
    	   $condition = "ProductArticle.article_id = '".$link_article_id."' and ProductArticle.product_id = '".$id."'";
    	   $this->ProductArticle->deleteAll($condition);
    	   $linked_articles   = $this->requestAction("/commons/get_products_articles/".$id."");
    	 //  pr($linked_articles);
    	   	//页面显示
			Configure::write('debug',0);
            $result['type'] = "0";
            $result['msg'] = $linked_articles;
            $result['type'] = $type;
            die(json_encode($result));
    }
/*------------------------------------------------------ */
//-- 更新关联排序
/*------------------------------------------------------ */
   function update_orderby($relation_id,$sort_value,$type){
   	    if($type == 'P'){
   	             $this->ProductRelation->updateAll(
			         array('ProductRelation.orderby' => $sort_value),
			         array('ProductRelation.id' => $relation_id)
		         );
		}
		elseif($type == 'A'){
			   $this->ProductArticle->updateAll(
			         array('ProductArticle.orderby' => $sort_value),
			         array('ProductArticle.id' => $relation_id)
		         );
		}
		    Configure::write('debug',0);
            $result['type'] = "0";
            die(json_encode($result));
    }
/*------------------------------------------------------ */
//-- 切换商品类型
/*------------------------------------------------------ */
    function get_attr($id,$product_type){
    	    $id   = empty($id) ? 0 : intval($id);
            $product_type = empty($product_type) ? 0 : intval($product_type);
	        $attr_html = $this->requestAction("/commons/build_attr_html/".$product_type."/".$id."");
	        
	        
	        //页面显示
		    Configure::write('debug',0);
            $result['type'] = "0";
            $result['attr_html'] = $attr_html;
            die(json_encode($result));
     }

/*------------------------------------------------------ */
//-- 为某商品生成唯一的货号
/*------------------------------------------------------ */
    function generate_product_code($product_id){
    	     
    	     $products_code_prefix=isset($this->configs['products_code_prefix'])?$this->configs['products_code_prefix']:'sv';
    	     $product_code=$products_code_prefix.str_repeat('0', 6 - strlen($product_id)) . $product_id;
    	  //   echo $product_code;
    	     $condition=" Product.code like '%$product_code%' and Product.id != '$product_id'";
    	     $products_list=$this->Product->findAll($condition);
    	     $code_list=array();
    	     foreach($products_list as $k=>$v){
    	     	    if(isset($v['Product']['code'])){
    	     	    	    $code_list[$k]=$v['Product']['code'];
    	     	    }
    	     }
    	     if (in_array($product_code, $code_list)){
    	     	    $max = pow(10, strlen($code_list[0]) - strlen($product_code) + 1) - 1;
                    $new_sn = $product_code . mt_rand(0, $max);
                          while (in_array($new_sn, $code_list)){
                                     $new_sn = $product_code . mt_rand(0, $max);
                           }
                    $product_code = $new_sn;
    	     }
    	  //   pr($products_list);
    	     return $product_code;
    }
    function update_default_gallery($gallery_id,$product_id){
    	$productgallery = $this->ProductGallery->findById($gallery_id);
    	//pr($productgallery);
    	$img_thumb = $productgallery['ProductGallery']['img_thumb'];
    	$img_detail = $productgallery['ProductGallery']['img_detail'];
    	$img_original = $productgallery['ProductGallery']['img_original'];
		$this->Product->updateAll(
				         	array('Product.img_thumb' => "'$img_thumb'"),
							array('Product.id' => $product_id)
				         	
			         );
		$this->Product->updateAll(
							array('Product.img_detail' => "'$img_detail'"),
							array('Product.id' => $product_id)
				         	
			         );
		$this->Product->updateAll(
							array('Product.img_original' =>"'$img_original'"),
							array('Product.id' => $product_id)
				         	
			         );
    	Configure::write('debug',0);
    	die($gallery_id);
    }
    
/*------------------------------------------------------ */
//-- 批量处理
/*------------------------------------------------------ */
   function batch(){
   	   //批量处理
   	 //  pr($this->params);
	   	   $pro_ids = !empty($this->params['url']['checkboxes']) ? $this->params['url']['checkboxes'] : 0;
         	   if ($this->params['url']['act_type'] == 'del')
               {
               	   $this->Product->updateAll(
			              array('Product.status' => 2),
			              array('Product.id' => $pro_ids)
			           );
                    
                     $this->flash("商品已经进入回收站",'/products/','');
                }
   }
    

/*------------------------------------------------------ */
//-- 商品批量csv文件上传
/*------------------------------------------------------ */
	function batch_add_products(){
		$this->pageTitle = "商品批量上传" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商品管理','url'=>'/products/');
		$this->navigations[] = array('name'=>'商品批量上传','url'=>'');	
		$this->set('navigations',$this->navigations);
		/* 文件上传后解析 */
		if(!empty($_FILES['file'])){
			if($_FILES['file']['error']>0){
				$this->flash("文件上传错误",'/products/upload_products_file','');
			}
			else if(empty($_POST['category_id'])){
				$this->flash("请选择商品分类",'/products/upload_products_file','');
			}else{
				$handle = @fopen($_FILES['file']['tmp_name'],"r");
				$key_arr = array('name','meta_keywords','meta_description','description','code','brand','provider','shop_price',
								 'market_price','weight','quantity','recommand_flag','forsale','alone','extension_code','img_thumb','img_detail','img_original',
								 'min_buy','max_buy','point','point_fee');
				
				while($row = fgetcsv ($handle, 10000, ",")) {
					foreach($row as $k=>$v){
						$temp[$key_arr[$k]] = iconv('gb2312','utf-8',$v);
					}
					$temp['description'] = htmlspecialchars($temp['description']);
					$data[] = $temp;
		   	    }
		   	    //pr($data);die();
		   	    $this->set('extension_code',array(''=>'真实商品','virtual_card'=>'虚拟卡'));
		   	    $this->set('products_list',$data);
		   	    $this->set('category_id',$_POST['category_id']);
	   	    }
   	    }
   	    /* 商品批量保存 */
   	    if(!empty($this->data)){
   	    	//pr($this->data);pr($this->languages);die();
   	    	$category_id = $_POST['category_id'];
   	    	$checkbox_arr = $_REQUEST['checkbox'];
   	    	foreach($this->data as $key=>$data){
   	    		if(!in_array($key,$checkbox_arr))
   	    			continue;
				$ProductI18n['name'] = $data['name'];//商品名称
				$ProductI18n['meta_keywords'] = $data['meta_keywords'];//商品关键词
				$ProductI18n['meta_description'] = $data['meta_description'];//商品简单描述
				$ProductI18n['description'] = $data['description'];//详细信息
				
				$ProductsCategory['category_id'] = $category_id;//商品分类

				$ProductGallery['img_thumb'] = $data['img_thumb'];//缩略图
				$ProductGallery['img_detail'] = $data['img_detail'];//详细图
				$ProductGallery['img_original'] = $data['img_original'];//原图
					
				$Product['code'] = $data['code'];//商品货号
				$Product['shop_price'] = $data['shop_price'] ? $data['shop_price'] : $data['market_price'];//本店售价
				$Product['market_price'] = $data['market_price'] ? $data['market_price'] : $data['shop_price'];//市场售价
				$Product['weight'] = $data['weight'] ? $data['weight'] : 0;//商品重量
				$Product['quantity'] = $data['quantity'];//库存数量
				$Product['recommand_flag'] = $data['recommand_flag'];//是否推荐
				$Product['forsale'] = $data['forsale'];//是否上架
				$Product['alone'] = $data['alone'];//能否作为普通商品销售
				$Product['extension_code'] = $data['extension_code'];//是否实体商品
				$Product['img_thumb'] = $data['img_thumb'];//缩略图
				$Product['img_detail'] = $data['img_detail'];//详细图
				$Product['img_original'] = $data['img_original'];//原图
				$Product['min_buy'] = $data['min_buy'] ? $data['min_buy'] : 1;//最小购买数
				$Product['max_buy'] = $data['max_buy'] ? $data['max_buy'] : 100;//最大购买数
				$Product['point'] = $data['point'] ? $data['point'] : 0;//赠送积分数
				$Product['point_fee'] = $data['point_fee'] ? $data['point_fee'] : 0;//积分购买额度

				$brand = $this->BrandI18n->findByName($data['brand']);
				$provider = $this->Provider->findByName($data['provider']);
				$Product['brand_id'] = $brand ? $brand['BrandI18n']['brand_id'] : 0;//商品品牌
				$Product['provider_id'] = $provider ? $provider['Provider']['id'] : 0;//供应商
	  	        if(empty($Product['code'])||$this->Product->findByCode($data['code'])){
	  	       		$max_product=$this->Product->find("","","Product.id DESC");
	  	       		$max_id=$max_product['Product']['id']+1;
	  	       		$Product['code']=$this->generate_product_code($max_id);
	  	        }
			    if(empty($Product['quantity'])){
			    	$Product['quantity']=$this->configs['default_stock'];
			    }
			    /* 新增商品 */
			    $this->Product->save($Product); //保存到商品主表
			    $id=$this->Product->id;
			    $this->Product->id = '';
			    
			    /* 新增商品多语言 */
			    $ProductI18n['product_id'] = $id;
			    //pr($this->languages);
			   	if(is_array($this->languages))
			    	foreach($this->languages as $k => $v){
				    	$this->ProductI18n->id = '';
				    	$ProductI18n['locale'] = $v['Language']['locale'];
				        $this->ProductI18n->save($ProductI18n);//保存到商品多语言表
			    	}
			    /* 新增商品相册关联 */
			    if(!empty($ProductGallery['img_thumb'])||!empty($ProductGallery['img_detail'])||!empty($ProductGallery['img_original'])){
				    $ProductGallery['product_id'] = $id;
				    $this->ProductGallery->id = '';
					$this->ProductGallery->save($ProductGallery);//保存到商品相册
				}
			    /* 新增商品分类关联 */
			    $ProductsCategory['product_id']=$id;
			    $this->ProductsCategory->id = '';
			    $this->ProductsCategory->save($ProductsCategory);//保存到商品分类
			}
			$this->flash("导入成功",'/products/upload_products_file','');
		}
	}
/*------------------------------------------------------ */
//-- 商品批量csv文件上传
/*------------------------------------------------------ */
	function upload_products_file(){
		$this->pageTitle = "商品批量上传" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商品管理','url'=>'/products/');
		$this->navigations[] = array('name'=>'商品批量上传','url'=>'');
		$this->set('navigations',$this->navigations);
		$categories_tree=$this->Category->tree('P',$this->locale);
		$this->set('categories_tree',$categories_tree);
	}
/*------------------------------------------------------ */
//-- 商品批量csv文件下载
/*------------------------------------------------------ */
	function download(){
		Configure::write('debug', 0);
	    header("Content-type: application/vnd.ms-excel; charset=gb2312");
	    header("Content-Disposition: attachment; filename=products_list.csv");
	    
	    $str =  "商品名称,商品关键词,商品简单描述,详细信息,商品货号,商品品牌,供应商,本店售价,市场售价,商品重量,库存数量,是否推荐,是否上架,能否作为普通商品销售,商品种类(为空：真实商品 virtual_card：虚拟卡),缩略图,详细图,原图,最小购买数,最大购买数,赠送积分数,积分购买额度";
	    echo  iconv('utf-8','gb2312',$str."\n");
	    exit;
	}
	function update_code($old_product_code,$new_product_code,$product_id){
		rename("../img/products/".$old_product_code,"../img/products/".$new_product_code);
		$this->Product->updateAll(
			              array('Product.code' => "'$new_product_code'"),
			              array('Product.id' => $product_id)
			           );
		$this->Product->hasOne = array();
		$product_info = $this->Product->findById($product_id);
		$product_info['Product']['img_thumb'] = str_replace($old_product_code,$new_product_code,$product_info['Product']['img_thumb']);
		$product_info['Product']['img_detail'] = str_replace($old_product_code,$new_product_code,$product_info['Product']['img_detail']);
		$product_info['Product']['img_original'] = str_replace($old_product_code,$new_product_code,$product_info['Product']['img_original']);
		$this->Product->save($product_info);
		$productgallery_info = $this->ProductGallery->findAll(array("ProductGallery.product_id"=>$product_id));
		foreach( $productgallery_info as $k=>$v ){
			$v['ProductGallery']['img_thumb'] = str_replace($old_product_code,$new_product_code,$v['ProductGallery']['img_thumb']);
			$v['ProductGallery']['img_detail'] = str_replace($old_product_code,$new_product_code,$v['ProductGallery']['img_detail']);
			$v['ProductGallery']['img_original'] = str_replace($old_product_code,$new_product_code,$v['ProductGallery']['img_original']);
			$this->ProductGallery->save($v);
		}
	}
	
	
	//rss
	function rss($category_id=0){
		$this->layout = '/rss/products';
		$this->Product->set_locale($this->locale);
        $products_list = $this->Product->find('all',array('conditions'=>array('ProductsCategory.category_id'=>$category_id),'limit'=>10,'order'=>'Product.created desc'));
       //	pr($products_list);
       	$this->set('this_config',$this->configs); 
        $this->set('products',$products_list); 
        Configure::write('debug',0);
	}
}
?>