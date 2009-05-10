<?PHP
	class VirtualCardsController extends AppController {
		var $name = 'VirtualCards';
	    var $components = array ('Pagination','RequestHandler'); // Added 
	    var $helpers = array('Pagination','Html', 'Form', 'Javascript', 'Fck'); // Added    
		var $uses = array('Order',"OrderProduct","VirtualCard","ProductRank","TopicProduct","Product","UserRank","Category","Brand","Provider","BookingProduct","ProductType","ProductGallery","ProductRelation","ProductArticle","ProductI18n","ProductTypeAttribute","ProductAttribute","ProductsCategory","BrandI18n");
		
		
		
		function index(){
			$this->pageTitle = "虚拟卡管理" ." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'虚拟卡管理','url'=>'/virtual_cards/');
			$this->set('navigations',$this->navigations);
			$this->Product->set_locale($this->locale);
			$condition = "1=1";
			$condition .=" and Product.status = 1 and Product.extension_code='virtual_card'";

			//商品筛选查询条件
		   	if(isset($this->params['url']['quantity']) && $this->params['url']['quantity'] != 0){
		   	   	$condition .=" and Product.quantity <= '".$this->params['url']['quantity']."'";
		   	}
		   	if(isset($this->params['url']['promotion_status']) && $this->params['url']['promotion_status'] != 0){
		   	   	$condition .=" and Product.promotion_status = '".$this->params['url']['promotion_status']."'";
		   	}	
		   	if(isset($this->params['url']['category_id']) && $this->params['url']['category_id'] != 0){
		   		$parent_id=$this->Category->find(array("Category.id"=>$this->params['url']['category_id']),"DISTINCT Category.parent_id");
				if($parent_id['Category']['parent_id'] == 0){
					$category_id=$this->Category->findAll(array("Category.parent_id"=>$this->params['url']['category_id']),"DISTINCT Category.id");
					
					$str = " 1=1 ";
					foreach( $category_id as $k=>$v ){
						$str .=" or ProductsCategory.category_id = '".$v['Category']['id']."'";
					}
					$condition .=" and (".$str.")";

				}else{
	   	   			$condition .=" and ProductsCategory.category_id = '".$this->params['url']['category_id']."'";

				}
				
		   	
		   	}
		   	if(isset($this->params['url']['keywords']) && $this->params['url']['keywords'] != ''){
		   	   	$condition .=" and ProductI18n.name like '%".$this->params['url']['keywords']."%' or Product.code= '%".$this->params['url']['keywords']."%'";
		   	}
		   	if(isset($this->params['url']['min_price']) && $this->params['url']['min_price'] != ''){
		   	   	$condition .=" and Product.shop_price >= '".$this->params['url']['min_price']."'";
		   	}
		   	if(isset($this->params['url']['max_price']) && $this->params['url']['max_price'] != ''){
		   	   	$condition .=" and Product.shop_price <= '".$this->params['url']['max_price']."'";
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
		
		function add(){
			$this->pageTitle = "新增虚拟卡-虚拟卡管理"." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'虚拟卡管理','url'=>'/virtual_cards/');
			$this->navigations[] = array('name'=>'新增虚拟卡','url'=>'');
			$this->set('navigations',$this->navigations);
			$this->UserRank->set_locale($this->locale);
			 if($this->RequestHandler->isPost()){
	    	
	    	$this->data['Product']['weight'] = !empty($this->data['Product']['weight'])?$this->data['Product']['weight']:"0";
	    	$this->data['Product']['shop_price'] = !empty($this->data['Product']['shop_price'])?$this->data['Product']['shop_price']:"0";
			$this->data['Product']['market_price'] = !empty($this->data['Product']['market_price'])?$this->data['Product']['market_price']:"0";
			$this->data['Product']['product_name_style']=$this->params['form']['product_style_color'] . '+'.$this->params['form']['product_style_word'];
			$this->data['Product']['point'] = !empty($this->data['Product']['point'])?$this->data['Product']['point']:"0";
			$this->data['Product']['extension_code'] = "virtual_card";
			  $this->data['Product']['is_real'] = 0;

	  	       //新增商品
	  	       if(empty($this->data['Product']['code'])){
	  	       	      $max_product=$this->Product->find("","","Product.id DESC");
	  	       	      $max_id=$max_product['Product']['id']+1;
	  	       	      //pr($max_product);
	  	       	      $this->data['Product']['code']=$this->generate_product_code($max_id);
	  	       }
			    $this->data['Product']['quantity']=0;
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
			  $this->flash("虚拟卡 ".$product_code." ".$product_name." 添加成功。点击继续编辑该虚拟卡。",'/virtual_cards/'.$id,10);
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
		function view($id){
			$this->pageTitle = "编辑虚拟卡-虚拟卡管理"." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'虚拟卡管理','url'=>'/virtual_cards/');
			$this->navigations[] = array('name'=>'编辑虚拟卡','url'=>'');
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
			  $this->data['Product']['extension_code'] = "virtual_card";
			  $this->data['Product']['is_real'] = 0;
           	  
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
			         $this->flash("虚拟卡 ".$product_code." ".$product_name." 编辑成功。点击继续编辑该虚拟卡。",'/virtual_cards/'.$id,10);
              	     
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
              	      $product_info_img = $this->Product->findById($id);
              	      $product_code = $product_info_img['Product']['code'];
              	      $product_name = $product_info_img['ProductI18n']['name'];
			          $this->flash("虚拟卡 ".$product_code." ".$product_name." 编辑相册成功。点击继续编辑该虚拟卡。",'/virtual_cards/'.$id,10);
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
     
			          $this->flash("虚拟卡 ".$product_code." ".$product_name." 属性编辑成功。点击继续编辑该虚拟卡。",'/virtual_cards/'.$id,10);
     
              
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
			if(empty($productrank)){
				$user_rank_list[$k]['UserRank']['product_price'] = "-1";($user_rank_list[$k]['UserRank']['discount']/100)*($this->data['Product']['shop_price']);
			}else{
				$user_rank_list[$k]['UserRank']['product_price'] = $productrank['ProductRank']['product_price'];
				$user_rank_list[$k]['UserRank']['is_default_rank'] = $productrank['ProductRank']['is_default_rank'];
				$user_rank_list[$k]['UserRank']['productrank_id'] = $productrank['ProductRank']['id'];
			
			}
		}
		
		//pr($user_rank_list);
		//供应商
		$provider_list = $this->Provider->get_provider_list();
		$user_rank_list=$this->UserRank->findrank();
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
		$this->set('user_rank_list', $user_rank_list);
		}
		
		
		
		
		
		function card($product_id="none"){
			$this->pageTitle = "编辑虚拟卡-虚拟卡管理"." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'虚拟卡管理','url'=>'/virtual_cards/');
			$this->navigations[] = array('name'=>'编辑虚拟卡','url'=>'');
			$this->set('navigations',$this->navigations);
			
			$this->OrderProduct->get_virtual_products(304);
			$condition['product_id'] = $product_id;
			$total = $this->VirtualCard->findCount($condition,0);
		   	$sortClass='VirtualCard';
		   	$page=1;
		   	$rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		   	$parameters=Array($rownum,$page);
		   	$options=Array();
		   	$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
			$virtualcard_list = $this->VirtualCard->findall($condition,'',"",$rownum,$page);
			//pr($virtualcard_list);$condition,'',"Product.created DESC",$rownum,$page
			foreach( $virtualcard_list as $k=>$v ){
				$card_sn = $v['VirtualCard']['card_sn'];
				$card_password = $v['VirtualCard']['card_password'];
				$virtualcard_list[$k]['VirtualCard']['card_sn'] = $this->requestAction("/commons/decrypt/".$card_sn."/");
				$virtualcard_list[$k]['VirtualCard']['card_password'] = $this->requestAction("/commons/decrypt/".$card_password."/");
				$order_code=$this->Order->find(array('Order.id'=>$v['VirtualCard']['order_id']),'DISTINCT Order.order_code');
				$virtualcard_list[$k]['VirtualCard']['order_id'] = $order_code['Order']['order_code'];
				
			}
			$this->set('product_id',$product_id);
			$this->set('virtualcard_list',$virtualcard_list);
		}
		
		function card_add($product_id){
			$this->pageTitle = "编辑虚拟卡-虚拟卡管理"." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'虚拟卡管理','url'=>'/virtual_cards/');
			$this->navigations[] = array('name'=>'补货','url'=>'');
			$this->set('navigations',$this->navigations);
			if($this->RequestHandler->isPost()){        
			

				$this->data['VirtualCard']['card_sn'] = $this->requestAction("/commons/encrypt/".$this->data['VirtualCard']['card_sn']);
				$this->data['VirtualCard']['card_password'] = $this->requestAction("/commons/encrypt/".$this->data['VirtualCard']['card_password']);
				$this->data['VirtualCard']['crc32'] = crc32(AUTH_KEY);
				
				$this->data['VirtualCard']['end_date'] = $this->data['VirtualCard']['end_date']." 23:59:59";
				$this->data['VirtualCard']['product_id'] = $product_id;
				$this->VirtualCard->save($this->data);
				
				$id = $this->VirtualCard->getLastInsertId();
				$condition22['product_id'] = $product_id;
				$condition22['is_saled'] = 0;
				$total = $this->VirtualCard->findCount($condition22,0);

				$this->Product->updateAll(
			              array('Product.quantity' =>$total),
			              array('Product.id' => $product_id)
			           );
				$this->flash("添加成功",'/virtual_cards/card_edit/'.$id.'/'.$product_id.'/',10);
			}
			$condition['product_id'] = $product_id;
			$product_name_list=$this->ProductI18n->findall($condition,'DISTINCT ProductI18n.name,ProductI18n.locale');
			foreach( $product_name_list as $k=>$v ){
				$product_name_list[$v['ProductI18n']['locale']] = $v;
			}
			$this->set("product_name_list",$product_name_list);
			$this->set("product_id",$product_id);
			
		}
		
		
		
		//
		function batch_card_add($product_id){
			$this->pageTitle = "新增虚拟卡-虚拟卡管理"." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'虚拟卡管理','url'=>'/virtual_cards/');
			$this->navigations[] = array('name'=>'批量补货','url'=>'');
			$this->set('navigations',$this->navigations);
			$this->set("product_id",$product_id);
		
		}
		function batch_card_add_list($product_id){
			$this->pageTitle = "新增虚拟卡-虚拟卡管理"." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'虚拟卡管理','url'=>'/virtual_cards/');
			$this->navigations[] = array('name'=>'批量补货','url'=>'');
			$this->set('navigations',$this->navigations);
			if($this->RequestHandler->isPost()){
				$data = file($_FILES['uploadfile']['tmp_name']);
				$separator = trim($_POST['separator']);
				foreach( $data as $k=>$v ){
					$utf8_data[$k] = iconv('gb2312','utf-8',$v);
				}
				foreach( $utf8_data as $k=>$v ){
					$row = explode($separator, $v);
					switch(count($row)){
            			case '3':
                			$rec[$k]['end_date'] = $row[2];
            			case '2':
                			$rec[$k]['card_password'] = $row[1];
            			case '1':
                			$rec[$k]['card_sn']  = $row[0];
                		break;
            			default:
			                $rec[$k]['card_sn']  = $row[0];
			                $rec[$k]['card_password'] = $row[1];
			                $rec[$k]['end_date'] = $row[2];
                		break;
        			}
        			
				}
				
			}
			$this->set("csv_list",$rec);
			$this->set("product_id",$product_id);
		}
		function batch_card_add_firm($product_id){
			if($this->RequestHandler->isPost()){
				$checkbox_arr = $_REQUEST['checkbox'];
				$card_sn_arr = $_REQUEST['card_sn'];
				$card_password_arr = $_REQUEST['card_password'];
				$end_date_arr = $_REQUEST['end_date'];
				
				foreach($checkbox_arr as $k=>$v){
					$virtual_card_info = array(
											"product_id"=>$product_id,
											"card_sn"=>$this->requestAction("/commons/encrypt/".$card_sn_arr[$v]),
											"card_password"=>$this->requestAction("/commons/encrypt/".$card_password_arr[$v]),
											"end_date"=>$end_date_arr[$v],
											"crc32"=>crc32(AUTH_KEY)
										);
					$this->VirtualCard->saveall(array("VirtualCard"=>$virtual_card_info));
					
				}
				$condition['product_id'] = $product_id;
				$condition['is_saled'] = 0;
				$total = $this->VirtualCard->findCount($condition,0);

				$this->Product->updateAll(
			              array('Product.quantity' =>$total),
			              array('Product.id' => $product_id)
			           );
				$this->flash("批量补货成功",'/virtual_cards/card/'.$product_id.'/',10);
			
			}
		
		}
		function card_edit($id,$product_id) {
			$this->pageTitle = "编辑虚拟卡-虚拟卡管理"." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'虚拟卡管理','url'=>'/virtual_cards/');
			$this->navigations[] = array('name'=>'补货','url'=>'');
			$this->set('navigations',$this->navigations);
			
			
			if($this->RequestHandler->isPost()){
				$this->data['VirtualCard']['card_sn'] = $this->requestAction("/commons/encrypt/".$this->data['VirtualCard']['card_sn']);
				$this->data['VirtualCard']['card_password'] = $this->requestAction("/commons/encrypt/".$this->data['VirtualCard']['card_password']);
				$this->data['VirtualCard']['crc32'] = crc32(AUTH_KEY);
				
				$this->data['VirtualCard']['id'] = $id;
				$this->data['VirtualCard']['end_date'] = $this->data['VirtualCard']['end_date']." 23:59:59";
				$this->VirtualCard->save($this->data);
				$this->params['controller']="/virtual_cards/card/".$product_id;
         		$this->flash("编辑成功",'/virtual_cards/card_edit/'.$id.'/'.$product_id.'/',10);

			}
			
			
			
			$condition['product_id'] = $product_id;
			$product_name_list=$this->ProductI18n->findall($condition,'DISTINCT ProductI18n.name,ProductI18n.locale');
			foreach( $product_name_list as $k=>$v ){
				
				$product_name_list[$v['ProductI18n']['locale']] = $v;
			}
			$virtualcard_info = $this->VirtualCard->findById($id);
			$virtualcard_info['VirtualCard']['card_sn']=$this->requestAction("/commons/decrypt/".$virtualcard_info['VirtualCard']['card_sn']);
			$virtualcard_info['VirtualCard']['card_password']=$this->requestAction("/commons/decrypt/".$virtualcard_info['VirtualCard']['card_password']);
			$this->set("id",$id);
			$this->set("product_id",$product_id);
			$this->set("product_name_list",$product_name_list);
			$this->set("virtualcard_info",$virtualcard_info);
		}
		
		function card_remove($id){
			$virtualcard_info = $this->VirtualCard->findById($id);
			$product_id = $virtualcard_info['VirtualCard']['product_id'];
			$this->VirtualCard->deleteAll("id='$id'");
			$condition['product_id'] = $product_id;
			$condition['is_saled'] = 0;
			
			$total = $this->VirtualCard->findCount($condition,0);

			$this->Product->updateAll(
			              array('Product.quantity' =>$total),
			              array('Product.id' => $product_id)
			           );
			$this->flash("删除成功",'/virtual_cards/card/'.$product_id.'/',10);
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
                    
                     $this->flash("虚拟卡已经进入回收站",'/virtual_cards/','');
                }
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

}
?>