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
 * $Id: products_controller.php 5493 2009-11-03 10:47:49Z huangbo $
 *****************************************************************************/
class ProductsController extends AppController{
    var $name='Products';
    var $components=array('Pagination','RequestHandler','Email');
    var $helpers=array('Pagination','Html','Form','Javascript','Tinymce','fck');
    var $uses=array("ProviderProduct","MailSendQueue","MailTemplate","ProductLocalePrice","SystemResource","ProductShippingFee","Stock","Shipping","ProductGalleryI18n","ProductRank","TopicProduct","UserRank","Provider","BookingProduct","ProductType","ProductGallery","ProductRelation","ProductArticle","ProductTypeAttribute","ProductAttribute","ProductsCategory","Brand","BrandI18n","Category",'CategoryI18n',"Product","ProductI18n",'ProdcutVolume','SeoKeyword');
    
    function view($id){
    	
        $this->pageTitle="编辑商品-商品管理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '商品管理','url' => '/products/');
        $this->navigations[]=array('name' => '编辑商品','url' => '');
        $this->Product->hasOne = array();
		$this->Product->hasMany = array('ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 ) ,
					   		
                 	   );
        //商品信息
		$product_info = $this->Product->findbyid($id);
		$product_name = "";
		foreach( $product_info["ProductI18n"] as $k=>$v ){
			$product_info["ProductI18n"][$v["locale"]] = $v;
			if($v["locale"]==$this->locale){
				$product_name=$v['name'];
			}
		}
        $product_code = $product_info["Product"]["code"];
        if($this->RequestHandler->isPost()){
        	
        	//基本信息
        	if(isset($this->params['form']['action_type']) && $this->params['form']['action_type']=='product_base_info'){
	        	$this->data['Product']['recommand_flag']=isset($this->data['Product']['recommand_flag']) ? $this->data['Product']['recommand_flag']: "0";//推荐
	            $this->data['Product']['forsale']=isset($this->data['Product']['forsale']) ? $this->data['Product']['forsale']: "0";
	            $this->data['Product']['alone']=isset($this->data['Product']['alone']) ? $this->data['Product']['alone']: "0";
	            $this->data['Product']['weight']=!empty($this->data['Product']['weight']) ? $this->data['Product']['weight']: "0";
	            $this->data['Product']['shop_price']=!empty($this->data['Product']['shop_price']) ? $this->data['Product']['shop_price']: "0";
	            $this->data['Product']['market_price']=!empty($this->data['Product']['market_price']) ? $this->data['Product']['market_price']: "0";
	            $this->data['Product']['point']=!empty($this->data['Product']['point']) ? $this->data['Product']['point']: "0";
	            $this->data['Product']['product_name_style']=@$this->params['form']['product_style_color'].'+'.@$this->params['form']['product_style_word'];
	            $this->data['Product']['product_rank_id']=!empty($this->data['Product']['product_rank_id']) ? $this->data['Product']['product_rank_id']: "0";
	            $this->data['Product']['extension_code']=!empty($this->data['Product']['extension_code']) ? $this->data['Product']['extension_code']: "";
	            $this->data['ProdcutVolume']=!empty($this->data['ProdcutVolume']) ? $this->data['ProdcutVolume']: array();
	            $this->data['Product']['warn_quantity']=!empty($this->data['Product']['warn_quantity']) ? $this->data['Product']['warn_quantity']: "0";
	            $this->data['Product']['warn_quantity']=!empty($this->data['Product']['warn_quantity']) ? $this->data['Product']['warn_quantity']: "0";
	            $this->data['Product']['sale_stat']=!empty($this->data['Product']['sale_stat']) ? $this->data['Product']['sale_stat']: "0";
				
	            
	        	$this->Product->save(array("Product"=>$this->data["Product"]));
	        	foreach( $this->data["ProductI18n"] as $k=>$v ){
	        		$this->ProductI18n->save(array("ProductI18n"=>$v));
	        	}
	        	//扩展分类
	        	if(!empty($_POST["other_cat"])){
	        		$other_cat = $_POST["other_cat"];
	        		$this->ProductsCategory->deleteAll(array("ProductsCategory.product_id"=>$id));
	        		foreach( $other_cat as $k=>$v ){
	        			$productcategory_arr = array(
	        				"category_id"=>$v,
	        				"product_id"=>$id
	        			);
	        			$this->ProductsCategory->saveAll(array("ProductsCategory"=>$productcategory_arr));
	        		}
	        	}
	        	//扩展供应商
	            if(!empty($_POST["other_provider"])){
	        		$other_provider = $_POST["other_provider"];
	        		$other_provider_price = $_POST["other_provider_price"];
	        		$this->ProviderProduct->deleteAll(array("ProviderProduct.product_id"=>$id));
	        		foreach( $other_provider as $k=>$v ){
	        			$productprovider_arr = array(
	        				"provider_id"=>$v,
	        				"product_id"=>$id,
	        				"price"=>empty($other_provider_price[$k])?0:$other_provider_price[$k]
	        			);
	        			$this->ProviderProduct->saveAll(array("ProviderProduct"=>$productprovider_arr));
	        		}
	            }
				//会员价
				if(!empty($_POST["product_rank_price"])){
	        		$product_rank_price = $_POST["product_rank_price"];
	        		$user_rank = $_POST["user_rank"];
	        		$product_rank_is_default_rank = empty($_POST["product_rank_is_default_rank"])?array():$_POST["product_rank_is_default_rank"];
	        		$this->ProductRank->deleteAll(array("product_id"=>$id));
					foreach($user_rank as $k=>$v){
						$user_rank = array(
							"id"=>$k,
							"discount"=>empty($v)?0:$v
						);
						$this->UserRank->save(array("UserRank"=>$user_rank));
						
						$product_rank = array(
							"product_id"=>$id,
							"rank_id"=>$k,
							"is_default_rank"=>empty($product_rank_is_default_rank[$k])?0:$product_rank_is_default_rank[$k],
							"product_price"=>empty($product_rank_price[$k])?0:$product_rank_price[$k],
						);
						$this->ProductRank->saveAll(array("ProductRank"=>$product_rank));
					}
				}
				//语言价格
				if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
					foreach($this->params['form']['locale_product_price']as $k => $v){
		              	$v["status"]=isset($v["status"]) ? $v["status"]: "0";
		            	$v["id"]=isset($v["id"]) ? $v["id"]: "";
						$v["product_price"]=!empty($v["product_price"]) ? $v["product_price"]: "0";
		               	$ProductLocalePrice=array("id" => $v["id"],"product_id" => $id,"locale" => $k,"status" => $v["status"],"product_price" => $v["product_price"]);
		               	$this->ProductLocalePrice->save(array("ProductLocalePrice" => $ProductLocalePrice));
	       			}
	        	}
				//优惠价格
				if(!empty($_POST["volume_number"])){
					$this->ProdcutVolume->deleteAll(array("product_id"=>$id));
					foreach($_POST["volume_number"] as $k => $v){
						$volume_price_post = $_POST["volume_price"];
		              	$volume_number = empty($v)?0:$v;
		              	$volume_price = empty($volume_price_post[$k])?0:$volume_price_post[$k];
		              	if(empty($volume_number)){
		              		continue;
		              	}
		              	$prodcut_volumes_arr = array(
		              		"volume_price"=>$volume_price,
		              		"volume_number"=>$volume_number,
		              		"product_id"=>$id
		              	);
		               	$this->ProdcutVolume->saveAll(array("ProdcutVolume" => $prodcut_volumes_arr));
	       			}
	        	}
               	//操作员日志
               	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
               		$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑商品:'.$product_name.'邮费','operation');
          		}
                $this->flash("商品 ".$product_code." ".$product_name." 编辑成功。点击这里继续编辑该商品。",'/products/view/'.$id,10);

        	}
        	//基本信息end 
            //编辑相册
            if(isset($this->params['form']['action_type']) && $this->params['form']['action_type']=='product_gallery'){
                $ProductGalleryI18ndescription=!empty($_REQUEST['ProductGalleryI18ndescription']) ? $_REQUEST['ProductGalleryI18ndescription']: array();
                foreach($ProductGalleryI18ndescription as $k => $v){
                    foreach($v['ProductGalleryI18n']as $kk => $vv){
                        $product_gallery_id=$vv['product_gallery_id'];
                        $this->ProductGalleryI18n->deleteall(array('product_gallery_id' => $product_gallery_id));
                    }
                }
                foreach($ProductGalleryI18ndescription as $k => $v){
                    foreach($v['ProductGalleryI18n']as $kk => $vv){
                        $product_gallery_id=$vv['product_gallery_id'];
                        $this->ProductGalleryI18n->saveall(array('ProductGalleryI18n' => $vv));
                    }
                }
                $this_pro_img = empty($this->data["ProductGallery"])?array():$this->data["ProductGallery"];
                foreach( $this_pro_img as $ik=>$iv ){
                	$strimg_addr = array(
                		"id"=>$iv["id"],
                		"orderby"=>$iv["orderby"]
                	);
                	$this->ProductGallery->save(array("ProductGallery"=>$strimg_addr));
                }
                //默认相册
                if( !empty($this->params['form']['img_url_default']) ){
                	$img_url_default = $this->params['form']['img_url_default'];
                	$image_name=basename($img_url_default);
                  	$dir_name=substr($img_url_default,0,strrpos($img_url_default,'/'));
                 	$img_thumb=$dir_name.'/'.$image_name;
               		$img_detail=$dir_name.'/detail/'.$image_name;
                  	$img_original=$dir_name.'/original/'.$image_name;
                  	$default_img = array(
                  		"id"=>$id,
                  		"img_thumb"=>$img_thumb,
                  		"img_detail"=>$img_detail,
                  		"img_original"=>$img_original,
                  	);
                  	$this->Product->save(array("Product"=>$default_img));
                }
                if(!empty($this->params['form']['img_url'])){
                    $image_path=$_REQUEST["image_path"];
                    $pro_info=$this->Product->findbyid($this->params['form']['product_id']);
                    foreach($image_path as $pk => $pv){
                        if($pv=="system_path"){
                            $imgurl=$this->params['form']['img_url'];
                            if(!empty($imgurl["$pk"])){
                                $image_name=basename($imgurl["$pk"]);
                                $dir_name=substr($imgurl["$pk"],0,strrpos($imgurl["$pk"],'/'));
                                $img_thumb=$dir_name.'/'.$image_name;
                                $img_detail=$dir_name.'/detail/'.$image_name;
                                $img_original=$dir_name.'/original/'.$image_name;
                                $product_gallery=array('img_original' => $img_original,'img_thumb' => $img_thumb,'img_detail' => $img_detail,'orderby' => !empty($this->params['form']['img_sort'][$pk]) ? $this->params['form']['img_sort'][$pk]: 50,'product_id' => $this->params['form']['product_id']);
                                $this->ProductGallery->saveall(array('ProductGallery' => $product_gallery));
                                foreach($this->languages as $lk => $lv){
                                    $product_gallery_i18n=array('product_gallery_id' => $this->ProductGallery->id,'locale' => $lv['Language']['locale'],'description' => $this->params['form']['img_desc'][$lv['Language']['locale']][$pk],);
                                    $this->ProductGalleryI18n->saveAll(array('ProductGalleryI18n' => $product_gallery_i18n));
                                }
                            }
                        }
                        if($pv=="definition_path"){
                            $img_original=$_REQUEST["img_original"];
                            $img_thumb=$_REQUEST["img_thumb"];
                            $img_detail=$_REQUEST["img_detail"];
                            $product_gallery=array('img_original' => $img_original[$pk],'img_thumb' => $img_thumb[$pk],'img_detail' => $img_detail[$pk],'orderby' => !empty($this->params['form']['img_sort'][$pk]) ? $this->params['form']['img_sort'][$pk]: 50,'product_id' => $this->params['form']['product_id']);
                            $this->ProductGallery->saveall(array('ProductGallery' => $product_gallery));
                            foreach($this->languages as $lk => $lv){
                                $product_gallery_i18n=array('product_gallery_id' => $this->ProductGallery->id,'locale' => $lv['Language']['locale'],'description' => $this->params['form']['img_desc'][$lv['Language']['locale']][$pk],);
                          		$this->ProductGalleryI18n->saveAll(array('ProductGalleryI18n' => $product_gallery_i18n));
                            }
                        }
                        if(!empty($_REQUEST["img_def"])&&$_REQUEST["img_def"]==$pk){
		                  	$default_img = array(
		                  		"id"=>$id,
		                  		"img_thumb"=>$img_thumb,
		                  		"img_detail"=>$img_detail,
		                  		"img_original"=>$img_original,
		                  	);
	                  		$this->Product->save(array("Product"=>$default_img));
                    	}
                    }
                }
                
                //加可选图片
                if( !empty($_REQUEST["select_img_addr"]) ){
                	foreach( $_REQUEST["select_img_addr"] as $k=>$v ){
                		$new_img_name = explode("/",$v);
                		$new_img_name = $new_img_name[count($new_img_name)-1]; //文件名
                		$dir_name=substr($v,0,strrpos($v,'original'));
						//取水印文件
						$watermark_file = $this->configs['watermark_file'];
						//取水印位置$this->configs
						$watermark_location = $this->configs['watermark_location'];
						//取水印透明度
						$watermark_transparency = $this->configs['watermark_transparency'];
						//是否加水印
						$is_watermark = $this->configs['is_watermark'];
						//上传商品图片是否保留原图	 	  	
						$retain_original_image_when_upload_products = $this->configs['retain_original_image_when_upload_products'];
						//列表缩略图宽度
						$thumbl_image_width = $this->configs['thumbl_image_width'];
						//列表缩略图高度
						$thumb_image_height = $this->configs['thumb_image_height'];
						//中图宽度
						$image_width = $this->configs['image_width'];
						//中图高度
						$image_height = $this->configs['image_height'];
						
						$WaterMark_img_address 		= substr($_SERVER["DOCUMENT_ROOT"],0, -1).trim($watermark_file);//水印文件
						
                		$img_original = "..".$v;//原图地址
                		
                		$img_thumb_watermark_name = substr($new_img_name,0,strrpos($new_img_name,'.'));//名称
                		$thumb = "..".$dir_name."";//缩略图地址
                		$img_detail="..".$dir_name."detail/";//详细图 中图地址
                		$db_img_detail = $dir_name."detail/".$new_img_name;
                		
						$img_thumb = $dir_name.$new_img_name;
						
						$image_name = $new_img_name; //文件名
						
                		if(!file_exists("..".$img_thumb)){
                			 $this->make_thumb($img_original,$thumbl_image_width,$thumb_image_height,"#FFFFFF",$img_thumb_watermark_name,$thumb,substr($new_img_name,strrpos($new_img_name,'.')+1));
	 						 $this->imageWaterMark($thumb.$image_name,$watermark_location,$WaterMark_img_address,$watermark_transparency);
	 					}
	 					if(!file_exists("..".$db_img_detail)){
	 						$this->make_thumb($img_original,$image_width,$image_height,"#FFFFFF",$img_thumb_watermark_name,$img_detail,substr($new_img_name,strrpos($new_img_name,'.')+1));
                			$this->imageWaterMark($img_detail.$image_name,$watermark_location,$WaterMark_img_address,$watermark_transparency);
                		}
                		
                		
                		
						
	                	
	                	$add_product_gallery = array(
	                		"product_id" => $id,
	                		"img_thumb" => $img_thumb,
	                		"img_detail" => $db_img_detail,
	                		"img_original" => $v,
	                		"orderby"=>empty($this->params['form']['select_img_addr_orderby'][$k])?"50":$this->params['form']['select_img_addr_orderby'][$k]
	                	);
	                	$this->ProductGallery->saveAll(array("ProductGallery"=>$add_product_gallery));
	                	
                        foreach($this->languages as $slk => $slv){
                        	$product_gallery_i18n=array(
                        		'product_gallery_id' => $this->ProductGallery->id,
                        		'locale' => $slv['Language']['locale'],
                        		'description' => $this->params['form']['select_img_addr_desc'][$slv['Language']['locale']][$k]
                        	);
                        	$this->ProductGalleryI18n->saveAll(array('ProductGalleryI18n' => $product_gallery_i18n));
                   		}
                	}
                }
                //操作员日志
                if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑商品:'.$product_name.'相册','operation');
                }
                $this->flash("商品 ".$product_code." ".$product_name." 编辑相册成功。点击这里继续编辑该商品。",'/products/view/'.$id,10);
            }
            //商品属性编辑
            if(isset($this->params['form']['action_type']) && $this->params['form']['action_type']=='product_attr'){
            	$upall = array(
            		'product_type_id' => $this->params['form']['product_type'],
            		'id' => $this->params['data']['Product']['id']
            	);
                $this->Product->save(array("Product"=>$upall));
                $this->ProductAttribute->deleteAll(array("ProductAttribute.product_id"=>$this->params['data']['Product']['id']));
                foreach($this->params['form']['attr_id_list']AS $key => $attr_id){
                	$pattr = array(
                		"product_id"=>$this->params['data']['Product']['id'],
                		"product_type_attribute_id"=>$attr_id,
			        	"product_type_attribute_value"=>$this->params['form']['attr_value_list'][$key],
			            "product_type_attribute_price"=>empty($this->params['form']['attr_price_list'][$key])?0:$this->params['form']['attr_price_list'][$key]
                	);
                	$this->ProductAttribute->saveAll(array('ProductAttribute' => $pattr));
                }
                
                //操作员日志
                if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑商品:'.$product_name.'属性','operation');
                }
                $this->flash("商品 ".$product_code." ".$product_name." 属性编辑成功。点击这里继续编辑该商品。",'/products/view/'.$id,10);
            }

        }
        
        
        //商品分类
        $product_cat=$this->Category->get_categories_tree("P",$this->locale);
        //文章分类
        $article_cat=$this->Category->getbrandformat();
		//品牌
		$this->Brand->set_locale($this->locale);
		$brands_tree=$this->Brand->getbrandformat();
		//供应商
		$provides_tree=$this->Provider->get_provider_list();
		//扩展分类
		$other_category_list = $this->ProductsCategory->find("all",array("conditions"=>array("product_id"=>$id)));
		//扩展供应商
		$this->ProviderProduct->belongsTo=array();
		$other_provides_list = $this->ProviderProduct->find("all",array("conditions"=>array("product_id"=>$id)));
		//会员等级
		$this->UserRank->set_locale($this->locale);
		$user_rank_list=$this->UserRank->findrank();
		//会员价
		$product_data = $this->ProductRank->find("all",array("conditions"=>array("product_id"=>$id)));
		$product_rank = array();
		foreach( $product_data as $k=>$v ){
			$product_rank[$v["ProductRank"]["rank_id"]] = $v;
		}
		//优惠价格
		$prodcutvolume_info = $this->ProdcutVolume->find("all",array("conditions"=>array("product_id"=>$id)));
		
        //语言价格
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            $productlocaleprice_info=$this->ProductLocalePrice->find("all",array("conditions" => array("product_id" => $id)));
            foreach($productlocaleprice_info as $k => $v){
                $productlocaleprice_info[$v["ProductLocalePrice"]["locale"]]=$v;
            }
            $this->set('productlocaleprice_info',$productlocaleprice_info);
        }
		
		
		//相册
        $product_gallery=$this->ProductGallery->findAll(" ProductGallery.product_id = '".$id."'");
        $product_gallery=$this->ProductGallery->find("all",array("conditions"=>array("ProductGallery.product_id"=>$id),"order"=>array("ProductGallery.orderby,ProductGallery.img_thumb")));
        $thisproduct_gallery = array();
        foreach($product_gallery as $k => $v){
            foreach($v['ProductGalleryI18n']as $kk => $vv){
                $product_gallery[$k]['ProductGalleryI18n'][$vv['locale']]=$vv;
            }
            $thisproduct_gallery['ProductGallery'][$k]=$product_gallery[$k]['ProductGallery'];
            $thisproduct_gallery['ProductGallery'][$k]['ProductGalleryI18n']=$product_gallery[$k]['ProductGalleryI18n'];
        }
        //商品属性
      	$products_attr_html=$this->requestAction("/commons/build_attr_html/".$product_info['Product']['product_type_id']."/".$id."");
        $this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 ) ,
					   		
                 	   );
        $this->Product->set_locale($this->locale);
        $product_relations=$this->requestAction("/commons/get_linked_products/".$id."");//关联商品
  
        $product_articles=$this->requestAction("/commons/get_products_articles/".$id."");//文联文章
        
		//导航商品名称显示
		$this->navigations[] = array('name'=>$product_info["ProductI18n"][$this->locale]["name"],'url'=>'');
	    
	    $products_name_style=explode('+',empty($product_info['Product']['product_name_style']) ? '+' : $product_info['Product']['product_name_style']);//商品样式
	    
	    //商品文件夹中的图片
	    $select_img_name = array();
	    if(is_dir("../img/products/".$product_info["Product"]["code"]."/original/")){
	    	$select_img_name = $this->get_img_name("/img/products/".$product_info["Product"]["code"]."/original/");
	    }
	    if(!empty($thisproduct_gallery["ProductGallery"])){
		    foreach( $thisproduct_gallery["ProductGallery"] as $k=>$v ){
		    	$img_thumb_name_arr = explode("/",$v["img_thumb"]);
		    	$img_thumb_name = $img_thumb_name_arr[count($img_thumb_name_arr)-1];
		    	if( !empty( $select_img_name[$img_thumb_name]) ){
		    		unset($select_img_name[$img_thumb_name]);
		    	}
		    }
	    }
	    $this->set('navigations',$this->navigations);//导航商品名称显示
	    $this->set("product_info",$product_info);//商品信息
	    $this->set("brands_tree",$brands_tree);//品牌
	    $this->set("provides_tree",$provides_tree);//供应商
	    $this->set("product_cat",$product_cat);//商品分类
	    $this->set("other_category_list",$other_category_list);//商品扩展分类
	    $this->set("other_provides_list",$other_provides_list);//扩展供应商
	    $this->set("user_rank_list",$user_rank_list);//会员等级
	    $this->set("prodcutvolume_info",$prodcutvolume_info);//会员等级
	    $this->set("product_rank",$product_rank);//会员价
	    $this->set("thisproduct_gallery",$thisproduct_gallery);//相册
	    $this->set("select_img_name",$select_img_name);//可选商品相册
	    $this->set("products_attr_html",$products_attr_html);//商品属性
	    $this->set("article_cat",$article_cat);//文章分类
	    $this->set("product_relations",$product_relations);//关联商品
	    $this->set("product_articles",$product_articles);//文联文章
		//商品样式
        $this->set('products_name_color',$products_name_style[0]);
        $this->set('products_name_style',$products_name_style[1]);
        $this->set('market_price_rate',$this->configs['market_price_rate']);
        
		//关键字
		$seokeyword_data = $this->SeoKeyword->find("all",array("conditions"=>array("status"=>1)));
		$this->set("seokeyword_data",$seokeyword_data);
    }
    function search(){
    		
        $this->operator_privilege('shortage_undeal_view');
        $this->pageTitle='缺货登记'." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '缺货登记','url' => '/products/search');
        $this->set('navigations',$this->navigations);
        $condition = "";
        if(isset($this->params['url']['keywords']) && $this->params['url']['keywords']!=''){
            $keywords=$this->params['url']['keywords'];
            $condition["and"]["or"]["BookingProduct.email like"] = "%$keywords%";
            $condition["and"]["or"]["BookingProduct.contact_man like"] = "%$keywords%";
            $condition["and"]["or"]["BookingProduct.telephone like"] = "%$keywords%";
            $condition["and"]["or"]["BookingProduct.id like"] = "%$keywords%";
            $condition["and"]["or"]["BookingProduct.product_id like"] = "%$keywords%";
            $condition["and"]["or"]["BookingProduct.product_desc like"] = "%$keywords%";
            $condition["and"]["or"]["BookingProduct.product_number like"] = "%$keywords%";
            $condition["and"]["or"]["BookingProduct.booking_time like"] = "%$keywords%";
            $this->set('keywords',$this->params['url']['keywords']);
        }
        if(isset($this->params['url']['contact_man']) && $this->params['url']['contact_man']!=''){
        	$condition["and"]["BookingProduct.contact_man like"] = "%".$this->params['url']['contact_man']."%";
            
            $this->set('contact_man',$this->params['url']['contact_man']);
        }
        if(isset($this->params['url']['bookstatus']) && $this->params['url']['bookstatus']!=''){
        	$condition["and"]["BookingProduct.is_dispose"] = $this->params['url']['bookstatus'];
            
            $this->set('bookstatus',$this->params['url']['bookstatus']);
        }
        if(isset($this->params['url']['date']) && $this->params['url']['date']!=''){
        	$condition["and"]["BookingProduct.booking_time >="] = $this->params['url']['date']." 00:00:00";
            
            $this->set('date',$this->params['url']['date']);
        }
        if(isset($this->params['url']['date2']) && $this->params['url']['date2']!=''){
        	$condition["and"]["BookingProduct.booking_time <="] = $this->params['url']['date2']." 23:59:59";
            
            $this->set('date2',$this->params['url']['date2']);
        }
		
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=array($rownum,$page);
        $options=array();
        $total=count($this->BookingProduct->find("all",array("conditions" => $condition,"fields" => " BookingProduct.id DISTINCT")));
        $sortClass='BookingProduct';
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        $BookingProduct_list = $this->BookingProduct->find("all",array("conditions" => $condition,"rownum"=>$rownum,"page"=>$page));
        $this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 ) ,
					   		
                 	   );
        $this->Product->set_locale($this->locale);
        $Product_list = $this->Product->find("all",array('fields' => array('ProductI18n.product_id','ProductI18n.name','Product.code')));
        $new_product_list = array();
        foreach( $Product_list as $k=>$v ){
        	$new_product_list[$v["ProductI18n"]["product_id"]] = $v;
        }
      
        $new_bookingproduct_list = array();
        foreach( $BookingProduct_list as $k=>$v ){
        	if(!empty($new_product_list[$v["BookingProduct"]["product_id"]])){
        		$v["BookingProduct"]["product_name"] = $new_product_list[$v["BookingProduct"]["product_id"]]["ProductI18n"]["name"];
        		$v["BookingProduct"]["code"] = $new_product_list[$v["BookingProduct"]["product_id"]]["Product"]["code"];
        		$new_bookingproduct_list[$k] = $v;
        	}
        }
        $this->set("new_bookingproduct_list",$new_bookingproduct_list); 

        
        //CSV导出
        if(isset($_REQUEST['export']) && $_REQUEST['export']==="export"){
            $filename='待处理缺货导出'.date('Ymd').'.csv';
            $ex_data="待处理缺货统计报表,";
            $ex_data.="日期,";
            $ex_data.=date('Y-m-d')."\n";
            $ex_data.="编号,";
            $ex_data.="联系人,";
            $ex_data.="Email地址,";
            $ex_data.="缺货商品名,";
            $ex_data.="商品货号,";
            $ex_data.="登记时间,";
            $ex_data.="是否已处理\n";
            foreach($new_bookingproduct_list as $k => $v){
                $ex_data.=$v['BookingProduct']['id'].",";
                $ex_data.=$v['BookingProduct']['contact_man'].",";
                $ex_data.=$v['BookingProduct']['email'].",";
                $ex_data.=$v['BookingProduct']['product_name'].",";
                $ex_data.=$v['BookingProduct']['code'].",";
                $ex_data.=$v['BookingProduct']['booking_time'].",";
                if($v['BookingProduct']['is_dispose']){
                    $ex_data.="已处理\n";
                }
                else{
                    $ex_data.="待处理\n";
                }
            }
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=gb2312");
            header("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8','gb2312',$ex_data."\n");
            exit;
        }
    }
    function booking_show($id){
        $this->pageTitle='缺货登记'." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'订单管理','url'=>'');
        $this->navigations[]=array('name' => '缺货登记','url' => '/products/search/wanted');
        $this->set('navigations',$this->navigations);
        
        $bookingproduct_info = $this->BookingProduct->findById($id);


        $this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 ) ,
					   		
                 	   );
        $this->Product->set_locale($this->locale);
        $Product_list = $this->Product->find("all",array('fields' => array('ProductI18n.product_id','ProductI18n.name','Product.code')));
        $new_product_list = array();
        foreach( $Product_list as $k=>$v ){
        	$new_product_list[$v["ProductI18n"]["product_id"]] = $v;
        }
        $bookingproduct_info["BookingProduct"]["product_name"] = $new_product_list[$bookingproduct_info["BookingProduct"]["product_id"]]["ProductI18n"]["name"];
        $bookingproduct_info["BookingProduct"]["code"] = $new_product_list[$bookingproduct_info["BookingProduct"]["product_id"]]["Product"]["code"];
		$operator_info = $this->Operator->findById($bookingproduct_info["BookingProduct"]["dispose_operation_id"]);

		$bookingproduct_info["BookingProduct"]["dispose_operation_name"] = $operator_info["Operator"]["name"];

        if($this->RequestHandler->isPost()){
        	$this->BookingProduct->hasMany = array();
			$this->BookingProduct->hasOne = array();
        	$operator_info = $this->Session->read('Operator_Info');
        	$bookingproduct_info["BookingProduct"]["dispose_note"] = $_REQUEST["dispose_note"];
        	$bookingproduct_info["BookingProduct"]["dispose_operation_id"] = $operator_info["Operator"]["id"];
        	$bookingproduct_info["BookingProduct"]["dispose_time"] = $this->today;
        	$bookingproduct_info["BookingProduct"]["is_dispose"] = 1;
        	$this->BookingProduct->save(array("BookingProduct"=>$bookingproduct_info["BookingProduct"]));
        	
        	//发邮件给用户
            if($this->configs['enable_auto_send_mail']==1){
            	$consignee=$bookingproduct_info["User"]["name"];//template
				$product_name=$bookingproduct_info["BookingProduct"]["product_name"];//template
				$url = $this->server_host.$this->cart_webroot."/products/".$bookingproduct_info["BookingProduct"]['product_id'];//template
				$shop_name=$this->configs['shop_name'];//template
				$shop_url=$this->server_host.$this->cart_webroot;//template
				$send_date=date('Y-m-d H:m:s');//template
				//读模板
				$template='arrival_notice';
				$this->MailTemplate->set_locale($this->locale);
				$template=$this->MailTemplate->find("code = '$template' and status = '1'");
				//模板赋值
				$html_body=$template['MailTemplateI18n']['html_body'];
				eval("\$html_body = \"$html_body\";");
                $text_body=$template['MailTemplateI18n']['text_body'];
                eval("\$text_body = \"$text_body\";");
                //主题赋值
                $title = $template['MailTemplateI18n']['title'];
                eval("\$title = \"$title\";");
                
            	$mailsendqueue = array(
            		"sender_name"=>$shop_name,//发送从姓名
            		"receiver_email"=>$consignee.";".$bookingproduct_info["BookingProduct"]['email'],//接收人姓名;接收人地址
            		"cc_email"=>";",//抄送人
            		"bcc_email"=>";",//暗送人
            		"title"=>$title,//主题 
            		"html_body"=>$html_body,//内容
            		"text_body"=>$text_body,//内容
            		"sendas"=>"html"
            	);
            	$this->MailSendQueue->saveAll(array("MailSendQueue"=>$mailsendqueue));//保存邮件队列
            	if(isset($this->configs['email_the_way'])&&$this->configs['email_the_way'] == 1){
            		$this->requestAction('/mail_sends/?status=1'); 
            	}
			}
        	
			$this->flash("缺货登记商品处理成功。点击这里重新输入处理信息。",'/products/booking_show/'.$id,10);

        }
        $this->set("bookingproduct_info",$bookingproduct_info); 
        $this->set("id",$id); 
    }
    function search_remove($id){
        $this->operator_privilege('shortage_undeal_cancle');
        $this->BookingProduct->deleteAll("BookingProduct.id='$id'");
        //操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除缺货登记商品','operation');
        }
        $this->flash("删除成功",'/products/search/',10);
    }
    
    //商品页
    function index($export=0,$csv_export_code="gbk"){
        $this->pageTitle="商品管理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '商品管理','url' => '/products/');
        $this->set('navigations',$this->navigations);
        $this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'=>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 )
                 	   );
        $this->Product->set_locale($this->locale);
		$condition = "";
		$condition["and"]["Product.status"] = "1";
		$condition["and"]["Product.status"] = "1";
		$condition["and"]["Product.extension_code"] = "";
        if(isset($this->params['url']['quantity']) && $this->params['url']['quantity']!=0){
        	$condition["and"]["Product.quantity <="] = $this->params['url']['quantity'] ;

        }
        if(isset($this->params['url']['forsale']) && $this->params['url']['forsale']!='99'){
        	$condition["and"]["Product.forsale ="] = $this->params['url']['forsale'];
        }
        if(isset($this->params['url']['promotion_status']) && $this->params['url']['promotion_status']!=0){
        	$condition["and"]["Product.promotion_status ="] =  $this->params['url']['promotion_status'] ;
            
        }
        if(isset($this->params['url']['category_id']) && $this->params['url']['category_id']!=0){
        	$category_id = $this->params['url']['category_id'];
    	    $this->Category->hasOne=array();
		  	$this->Category->tree_p('P',$category_id,$this->locale);
    	  	$category_ids = isset($this->Category->allinfo['subids'][$category_id])?$this->Category->allinfo['subids'][$category_id]:$category_id;
			$condition["and"]["Product.category_id"] = $category_ids;
        }
        if(isset($this->params['url']['keywords']) && $this->params['url']['keywords']!=''){
            $keywords=$this->params['url']['keywords'];
            $condition["and"]["or"]["Product.code like"] = "%$keywords%";
            $condition["and"]["or"]["ProductI18n.name like"] = "%$keywords%";
            $condition["and"]["or"]["ProductI18n.description like"] = "%$keywords%";
            $condition["and"]["or"]["Product.id like"] = "%$keywords%";
            $this->set('keywords',$this->params['url']['keywords']);
        }
        if(isset($this->params['url']['min_price']) && $this->params['url']['min_price']!=''){

            $condition["and"]["Product.shop_price >="] = $this->params['url']['min_price'];
            $this->set('min_price',$this->params['url']['min_price']);
        }
        if(isset($this->params['url']['max_price']) && $this->params['url']['max_price']!=''){
        	$condition["and"]["Product.shop_price <="] = $this->params['url']['max_price'];
            $this->set('max_price',$this->params['url']['max_price']);
        }
        if(isset($this->params['url']['brand_id']) && $this->params['url']['brand_id']!=0){
        	$condition["and"]["Product.brand_id"] = $this->params['url']['brand_id'];
        }
        if(isset($this->params['url']['type_id']) && $this->params['url']['type_id']!='0'){
        	$condition["and"]["Product.product_type_id ="] = $this->params['url']['type_id'];
        }
        if(isset($this->params['url']['date']) && $this->params['url']['date']!=''){
        	$condition["and"]["Product.created >="] = $this->params['url']['date']." 00:00:00";
            
            $this->set('date',$this->params['url']['date']);
        }
        if(isset($this->params['url']['date2']) && $this->params['url']['date2']!=''){
        	$condition["and"]["Product.created <="] = $this->params['url']['date2']." 23:59:59";
            
            $this->set('date2',$this->params['url']['date2']);
        }
        if(isset($this->params['url']['is_recommond']) && $this->params['url']['is_recommond']!=-1){
        	$condition["and"]["Product.recommand_flag ="] = $this->params['url']['is_recommond'];
            
        }
        if(isset($this->params['url']['provider_id']) && $this->params['url']['provider_id']!=-1){
        	$condition["and"]["Product.provider_id ="] = $this->params['url']['provider_id'];
            
        }
        $total=$this->Product->findCount($condition,0);
        $sortClass='Product';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        $fields[]="Product.id";
        $fields[]="Product.code";
        $fields[]="Product.shop_price";
        $fields[]="Product.quantity";
        $fields[]="Product.recommand_flag";
        $fields[]="Product.forsale";
        $fields[]="ProductI18n.name"; 
        $this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'=>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 )
                 	   );
    	
        $this->Product->set_locale($this->locale);
		$products_list=$this->Product->find("all",array("conditions"=>$condition,"order"=>"Product.id desc","fields"=>$fields,"limit"=>$rownum,"page"=>$page));
        //高级库存
        if(isset($this->configs['enable_advanced_stock_manage']) && $this->configs['enable_advanced_stock_manage']==1){
        	foreach( $products_list as $k=>$v ){
        		$stock_info = $this->Stock->find("all",array("conditions"=>array("product_id"=>$v["Product"]["id"]),"group"=>"product_id","fields"=>array("sum(quantity) as quantity")));
        		$products_list[$k]["Product"]["quantity"] = empty($stock_info[0][0]["quantity"])?0:$stock_info[0][0]["quantity"];
        	}
        }

        $this->Category->hasOne = array('CategoryI18n' =>   
                        array('className'    => 'CategoryI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,
                              'foreignKey'   => 'category_id'  
                        )
                  );
        $categories_tree= $this->Category->tree('P',$this->locale);
       
        $this->Brand->set_locale($this->locale);
        $brands_tree=$this->Brand->getbrandformat();
        $types_tree=$this->ProductType->gettypeformat();
        $provides_tree=$this->Provider->get_provider_list();
        $category_id=isset($this->params['url']['category_id']) ? $this->params['url']['category_id']: "0";
        $forsale=isset($this->params['url']['forsale']) ? $this->params['url']['forsale']: "99";
        $brand_id=isset($this->params['url']['brand_id']) ? $this->params['url']['brand_id']: "0";
        $type_id=isset($this->params['url']['type_id']) ? $this->params['url']['type_id']: "0";
        $keywords=isset($this->params['url']['keywords']) ? $this->params['url']['keywords']: '';
        $min_price=isset($this->params['url']['min_price']) ? $this->params['url']['min_price']: '';
        $max_price=isset($this->params['url']['max_price']) ? $this->params['url']['max_price']: '';
        $start_date=isset($this->params['url']['start_date']) ? $this->params['url']['start_date']: '';
        $end_date=isset($this->params['url']['end_date']) ? $this->params['url']['end_date']: '';
        $is_recommond=isset($this->params['url']['is_recommond']) ? $this->params['url']['is_recommond']: "-1";
        $provider_id=isset($this->params['url']['provider_id']) ? $this->params['url']['provider_id']: "-1";

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
        $this->set('total',$total);
        $this->set('csv_export_code',$csv_export_code);
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//
        $this->set("systemresource_info",$systemresource_info); 
        /*CSV导出*/
     	if(isset($export) && $export==="export"){
     		
      		$condition = "";
      		$languagedictionary[] = "back_number";//编号
      		$languagedictionary[] = "back_product_name";//商品名称
      		$languagedictionary[] = "back_product_code";//货号
      		$languagedictionary[] = "back_inventory";//库存
      		$languagedictionary[] = "back_price";//价格
      		$languagedictionary[] = "back_shelves";//上架
      		$languagedictionary[] = "back_recommended";//推荐
      		$languagedictionary[] = "back_export_of_goods";//商品導出
      		$languagedictionary[] = "back_select_a_date";//日期
      		$condition["name"] = $languagedictionary;
			$csv_systemResource = $this->SystemResource->findbyresource_value($csv_export_code);
			$condition["locale"] = $csv_systemResource["SystemResource"]["code"];
      		$languagedictionary_info = $this->LanguageDictionary->find("all",array("conditions"=>$condition));
      		$csv_str = array();
      		foreach( $languagedictionary_info as $csv_k=>$csv_v ){
      			$csv_str[$csv_v["LanguageDictionary"]["name"]] = $csv_v["LanguageDictionary"]["value"];
      		}

     		
            $filename=$csv_str["back_export_of_goods"].''.date('Ymd').'.csv';
            $ex_data=$csv_str["back_select_a_date"].",";
            $ex_data.=date('Y-m-d')."\n";
            $ex_data.=$csv_str["back_number"].",";
            $ex_data.=$csv_str["back_product_name"].",";
            $ex_data.=$csv_str["back_product_code"].",";
            $ex_data.=$csv_str["back_inventory"].",";
            $ex_data.=$csv_str["back_price"].",";
            $ex_data.=$csv_str["back_shelves"].",";
            $ex_data.=$csv_str["back_recommended"]."\n";
            foreach($products_list as $k => $v){
                $ex_data.=$v['Product']['id'].",";
                $ex_data.=$v['ProductI18n']['name'].",";
                $ex_data.=$v['Product']['code'].",";
                $ex_data.=$v['Product']['quantity'].",";
                $ex_data.=$v['Product']['shop_price'].",";
                if($v['Product']['forsale']=="1"){
                    $ex_data.="yes,";
                }
                else{
                    $ex_data.="no,";
                }
                if($v['Product']['recommand_flag']=="1"){
                    $ex_data.="yes\n";
                }
                else{
                    $ex_data.="no\n";
                }
            }
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=".$csv_export_code);
            header("Content-Disposition: attachment; filename=".iconv('utf-8',$csv_export_code,$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8',$csv_export_code,$ex_data."\n");
            exit;
        }
    }
    function add(){
        $this->pageTitle="添加商品-商品管理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '商品管理','url' => '/products/');
        $this->navigations[]=array('name' => '添加商品','url' => '');
        $this->set('navigations',$this->navigations);
        $this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 ) ,
					   		
					   					'ProviderProduct' =>array
												(
										          'className'     => 'ProviderProduct',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	)
                 	   );

        $this->UserRank->set_locale($this->locale);
        if($this->RequestHandler->isPost()){
            $this->data['Product']['weight']=!empty($this->data['Product']['weight']) ? $this->data['Product']['weight']: "0";
            $this->data['Product']['shop_price']=!empty($this->data['Product']['shop_price']) ? $this->data['Product']['shop_price']: "0";
            $this->data['Product']['market_price']=!empty($this->data['Product']['market_price']) ? $this->data['Product']['market_price']: "0";
            $this->data['Product']['product_name_style']=$this->params['form']['product_style_color'].'+'.$this->params['form']['product_style_word'];
            $this->data['Product']['point']=!empty($this->data['Product']['point']) ? $this->data['Product']['point']: "0";
            $this->data['Product']['img_thumb']=!empty($this->data['Product']['img_thumb']) ? $this->data['Product']['img_thumb']: "";
            $this->data['Product']['img_detail']=!empty($this->data['Product']['img_detail']) ? $this->data['Product']['img_detail']: "";
            $this->data['Product']['img_original']=!empty($this->data['Product']['img_original']) ? $this->data['Product']['img_original']: "";
            $this->data['Product']['product_rank_id']=!empty($this->data['Product']['product_rank_id']) ? $this->data['Product']['product_rank_id']: "0";
            $this->data['Product']['extension_code']=!empty($this->data['Product']['extension_code']) ? $this->data['Product']['extension_code']: "";
            $this->data['Product']['purchase_price']=!empty($this->data['Product']['purchase_price']) ? $this->data['Product']['purchase_price']: "0";
            $this->data['Product']['warn_quantity']=!empty($this->data['Product']['warn_quantity']) ? $this->data['Product']['warn_quantity']: "0";
	        $this->data['Product']['sale_stat']=!empty($this->data['Product']['sale_stat']) ? $this->data['Product']['sale_stat']: "0";
            $ProdcutVolume=array();
            if(empty($this->data['Product']['code'])){
            	$this->Product->hasOne = array();
                $max_product=$this->Product->find("first",array("order"=>"Product.id desc" , "fields"=>array("id")));
                $max_id=$max_product['Product']['id']+1;
                $this->data['Product']['code']=$this->generate_product_code($max_id);
				$this->Product->hasOne = array('ProductI18n'     =>array
														( 
														  'className'    => 'ProductI18n',   
							                              'order'        => '',   
							                              'dependent'    =>  true,   
							                              'foreignKey'   => 'product_id'
							                        	 ) ,
							   		
							   					'ProviderProduct' =>array
														(
												          'className'     => 'ProviderProduct',   
							                              'order'        => '',   
							                              'dependent'    =>  true,   
							                              'foreignKey'   => 'product_id'
							                        	)
		                 	   );
            }

            if(empty($this->data['Product']['quantity'])){
                $this->data['Product']['quantity']=$this->configs['default_stock'];
            }
            if(!isset($this->data['Product']['promotion_status'])){
                $this->data['Product']['promotion_status']='0';
            }
            if(isset($this->params['form']['date'])){
                $this->data['Product']['promotion_start']=$this->params['form']['date'];
            }
            if(isset($this->params['form']['date2'])){
                $this->data['Product']['promotion_end']=$this->params['form']['date2']." 23:59:59";
            }
            $this->data['Product']['coupon_type_id']="0";
            $product_code=$this->data['Product']['code'];
            if(!empty($this->data['Product']['colors_gallery'])){
				$image_name=basename($this->data['Product']['colors_gallery']);
				$dir_name=substr($this->data['Product']['colors_gallery'],0,strrpos($this->data['Product']['colors_gallery'],'/'));
				$this->data['Product']['colors_gallery']="/img/products/".$product_code."/".$image_name;
			}else{
				$this->data['Product']['colors_gallery'] = "";
			}

                       

          $this->Product->saveall(array("Product" => $this->data['Product']));
          $id=$this->Product->id;

          	foreach($this->data['ProdcutVolume']['number'] as $k => $v){
				if($v=="" ||$this->data['ProdcutVolume']['price'][$k]==""){
					unset($this->data['ProdcutVolume']['price'][$k]);
					unset($this->data['ProdcutVolume']['number'][$k]);
				}else{
					$ProdcutVolume[$k]['number']=$this->data['ProdcutVolume']['number'][$k];
					$ProdcutVolume[$k]['price']=$this->data['ProdcutVolume']['price'][$k];
				}
			}
			
			if(!empty($ProdcutVolume)){
				foreach($ProdcutVolume as $k => $v){
					$volume['product_id']=$id;
					$volume['volume_number']=$v['number'];
					$volume['volume_price']=$v['price'];
					
					$this->ProdcutVolume->saveall(array("ProdcutVolume" => $volume));
				}
			}

            if(is_array($this->data['ProductI18n']))
            foreach($this->data['ProductI18n']as $k => $v){
                $v['product_id']=$id;
                $v['meta_description']=!empty($v['meta_description'])?$v['meta_description']:$this->cut_str(strip_tags($v['description']),100);
                $this->ProductI18n->saveall(array("ProductI18n" => $v));
            }
            if(isset($this->params['form']['other_cat']) && is_array($this->params['form']['other_cat'])){
				foreach($this->params['form']['other_cat']as $kc => $vc){
                  	if(!empty($vc)){
                    	$vcarr[]=$vc;
                  	}
                }
                if( !empty($vcarr) ){
                	$this->ProductsCategory->handle_other_cat($id,array_unique($vcarr));
            	}
            }
            if(isset($this->params['form']['other_provider']) && is_array($this->params['form']['other_provider'])){
                $this->ProviderProduct->handle_other_cat($id,array_unique($this->params['form']['other_provider']),array_unique($this->params['form']['other_provider']));
            }
            //商品图
            $id=$this->Product->getLastInsertId();
            $product_info_img=$this->Product->findById($id);
            
            $product_name=$product_info_img['ProductI18n']['name'];
            $crdir="../img/products/".$product_code;
            if(!is_dir("../img/products/")){
                mkdir("../img/products/",0777);
                @chmod("../img/products/",0777);
            }
            if(!is_dir($crdir)){
                mkdir($crdir,0777);
                @chmod($crdir,0777);
            }
            $crdir="../img/products/".$product_code."/detail/";
            if(!is_dir($crdir)){
                mkdir($crdir,0777);
                @chmod($crdir,0777);
            }
            $crdir="../img/products/".$product_code."/original/";
            if(!is_dir($crdir)){
                mkdir($crdir,0777);
                @chmod($crdir,0777);
            }
			//默认相册
		    if( !empty($this->params['form']['img_url_default']) ){
		  		$img_url_default = $this->params['form']['img_url_default'];
		      	$image_name=basename($img_url_default);
		       	$dir_name=substr($img_url_default,0,strrpos($img_url_default,'/'));
		       	$img_thumb=$dir_name.'/'.$image_name;
		      	$img_detail=$dir_name.'/detail/'.$image_name;
		     	$img_original=$dir_name.'/original/'.$image_name;
	        	@rename("..".$img_thumb,"../img/products/".$product_code."/".$image_name);
	       		$img_thumb="/img/products/".$product_code."/".$image_name;
	    		@rename("..".$img_detail,"../img/products/".$product_code."/detail/".$image_name);
	        	$img_detail="/img/products/".$product_code."/detail/".$image_name;
	           	@rename("..".$img_original,"../img/products/".$product_code."/original/".$image_name);
	           	$img_original="/img/products/".$product_code."/original/".$image_name;
		       	$product = array(
		       		"id"=>$id,
		         	"img_thumb"=>$img_thumb,
		          	"img_detail"=>$img_detail,
		        	"img_original"=>$img_original,
		         );
		         $this->Product->saveAll(array('Product' => $product));
		     }
            //款号图处理
            if(!empty($this->data['Product']['colors_gallery'])){
				$img_thumb=$dir_name.'/'.$image_name;
				@rename("..".$img_thumb,"../img/products/".$product_code."/".$image_name);
				$img_thumb="/img/products/".$product_code."/".$image_name;
				$img_detail=$dir_name.'/detail/'.$image_name;
				@rename("..".$img_detail,"../img/products/".$product_code."/detail/".$image_name);
				$img_detail="/img/products/".$product_code."/detail/".$image_name;
				$img_original=$dir_name.'/original/'.$image_name;
				@rename("..".$img_original,"../img/products/".$product_code."/original/".$image_name);
				$img_original="/img/products/".$product_code."/original/".$image_name;
            }
            $img_url=$_REQUEST['img_url'];
            $img_sort=$_REQUEST['img_sort'];
            $img_desc=$_REQUEST['img_desc'];
            $image_path=$_REQUEST["image_path"];
            foreach($image_path as $pk => $pv){
                if($pv=="system_path"){
                    if($img_url[$pk]!=""){
                        $image_name=basename($img_url[$pk]);
                        $dir_name=substr($img_url[$pk],0,strrpos($img_url[$pk],'/'));
                        $img_thumb=$dir_name.'/'.$image_name;
                        @rename("..".$img_thumb,"../img/products/".$product_code."/".$image_name);
                        $img_thumb="/img/products/".$product_code."/".$image_name;
                        $img_detail=$dir_name.'/detail/'.$image_name;
                        @rename("..".$img_detail,"../img/products/".$product_code."/detail/".$image_name);
                        $img_detail="/img/products/".$product_code."/detail/".$image_name;
                        $img_original=$dir_name.'/original/'.$image_name;
                        @rename("..".$img_original,"../img/products/".$product_code."/original/".$image_name);
                        $img_original="/img/products/".$product_code."/original/".$image_name;
                        $product_gallery=array('img_original' => $img_original,'img_thumb' => $img_thumb,'img_detail' => $img_detail,'orderby' => !empty($img_sort[$k]) ? $img_sort[$k]: 50,'product_id' => $id);
                        $this->ProductGallery->saveAll(array('ProductGallery' => $product_gallery));
                        $product=array('img_original' => $img_original,'img_thumb' => $img_thumb,'img_detail' => $img_detail,'id' => $id);
                        foreach($this->languages as $lk => $lv){
                        	
                            $product_gallery_i18n=array('product_gallery_id' => $this->ProductGallery->id,'locale' => $lv['Language']['locale'],'description' => $this->params['form']['img_desc'][$lv['Language']['locale']][$pk],);
                            $this->ProductGalleryI18n->saveAll(array('ProductGalleryI18n' => $product_gallery_i18n));
                        }
		                                    }
                }
                if($pv=="definition_path"){
                    $img_original=$_REQUEST["img_original"];
                    $img_thumb=$_REQUEST["img_thumb"];
                    $img_detail=$_REQUEST["img_detail"];
                    $product_gallery=array('img_original' => !empty($img_original[$pk]) ? $img_original[$pk]: "",'img_thumb' => !empty($img_thumb[$pk]) ? $img_thumb[$pk]: "",'img_detail' => !empty($img_detail[$pk]) ? $img_detail[$pk]: "",'orderby' => !empty($this->params['form']['img_sort'][$pk]) ? $this->params['form']['img_sort'][$pk]: 50,'product_id' => $id);
                    $this->ProductGallery->saveall(array('ProductGallery' => $product_gallery));
                    foreach($this->languages as $lk => $lv){
                        $product_gallery_i18n=array('product_gallery_id' => $this->ProductGallery->id,'locale' => $lv['Language']['locale'],'description' => $this->params['form']['img_desc'][$lv['Language']['locale']][$pk],);
                        //pr($product_gallery_i18n);
                        $this->ProductGalleryI18n->saveAll(array('ProductGalleryI18n' => $product_gallery_i18n));
                    }
                    $product=array('img_original' => $img_original[$pk],'img_thumb' => $img_thumb[$pk],'img_detail' => $img_detail[$pk],'id' => $id);

                    $this->Product->saveAll(array('Product' => $product));
                }
               if(!empty($_REQUEST["img_def"])&&$_REQUEST["img_def"]==$pk){
		        	$default_img = array(
		            	"id"=>$id,
		              	"img_thumb"=>$img_thumb,
		               	"img_detail"=>$img_detail,
		               	"img_original"=>$img_original,
		         	);
	           		$this->Product->save(array("Product"=>$default_img));
              	}
            }
            //商品会员价
            if(isset($this->params['form']['user_rank']) && is_array($this->params['form']['user_rank'])){
                foreach($this->params['form']['user_rank']as $k => $v){
                    $user_rank=array('id' => $v,'discount' => $this->params['form']['user_price_discount'][$k]);
                    $this->UserRank->saveall(array('UserRank' => $user_rank));
                }
                foreach($this->params['form']['user_rank']as $k => $v){
                    $is_d_rank=!empty($this->params['form']['is_default_rank'][$k]) ? $this->params['form']['is_default_rank'][$k]: "0";
                    $ProductRank=array('product_id' => $id,'rank_id' => $v,'id' => $this->params['form']['productrank_id'][$k],'product_price' => $this->params['form']['rank_product_price'][$k],'is_default_rank' => !empty($this->params['form']['is_default_rank'][$k]) ? $this->params['form']['is_default_rank'][$k]: "0");
                    $this->ProductRank->saveAll(array('ProductRank' => $ProductRank));
                }
            }
            //语言价格
            if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            	$this->ProductLocalePrice->deleteAll(array("product_id"=>$id));
                foreach($this->params['form']['locale_product_price']as $k => $v){
                    $v["status"]=isset($v["status"]) ? $v["status"]: "0";
                    $v["product_price"]=!empty($v["product_price"]) ? $v["product_price"]: "0";
                    $ProductLocalePrice=array("product_id" => $id,"locale" => $k,"status" => $v["status"],"product_price" => $v["product_price"]);
                    $this->ProductLocalePrice->saveAll(array("ProductLocalePrice" => $ProductLocalePrice));
                }
            }
            //商品运费
            if(isset($this->configs["use_product_shipping_fee"]) && $this->configs["use_product_shipping_fee"]==1 && isset($this->params['form']['product_shoping_fee']) && is_array($this->params['form']['product_shoping_fee'])){
                if(isset($this->configs["mlti_currency_module"]) && $this->configs["mlti_currency_module"]==1){
                    $product_shoping_fee=!empty($this->params['form']['product_shoping_fee']) ? $this->params['form']['product_shoping_fee']: array();
                    $product_shoping_fee_status=!empty($this->params['form']['product_shoping_fee_status']) ? $this->params['form']['product_shoping_fee_status']: array();
                    foreach($product_shoping_fee as $k => $v){
                        foreach($v as $kk => $vv){
                            $product_shoping_fee_status_check=!empty($product_shoping_fee_status[$k][$kk]) ? $product_shoping_fee_status[$k][$kk]: 0;
                            $ProductShippingFee=array("locale" => $k,"product_id" => $id,"shipping_id" => $kk,"status" => $product_shoping_fee_status_check,"shipping_fee" => !empty($vv) ? $vv : "0"
                            );
                            $this->ProductShippingFee->saveAll(array("ProductShippingFee" => $ProductShippingFee));
                        }
                    }
                }
                else{
                    $product_shoping_fee=!empty($this->params['form']['product_shoping_fee']) ? $this->params['form']['product_shoping_fee']: array();
                    $product_shoping_fee_status=!empty($this->params['form']['product_shoping_fee_status']) ? $this->params['form']['product_shoping_fee_status']: array();
                    foreach($product_shoping_fee as $k => $v){
                        $product_shoping_fee_status_check=!empty($product_shoping_fee_status[$k]) ? $product_shoping_fee_status[$k]: 0;
                        $product_shoping_fee_id_check=!empty($product_shoping_fee_id[$k]) ? $product_shoping_fee_id[$k]: "";
                        $ProductShippingFee=array("product_id" => $id,"shipping_id" => $k,"status" => $product_shoping_fee_status_check,"shipping_fee" => !empty($v) ? $v : "0"
                        );
                        $this->ProductShippingFee->saveAll(array("ProductShippingFee" => $ProductShippingFee));
                    }
                }
            }
            //商品属性编辑
            if(isset($this->params['form']['action_type']) && $this->params['form']['action_type']=='product_attr'){
            	$upall = array(
            		'product_type_id' => $this->params['form']['product_type'],
            		'id' => $id
            	);
                $this->Product->save(array("Product"=>$upall));
                $this->ProductAttribute->deleteAll(array("ProductAttribute.product_id"=>$id));
                $attr_id_list = empty($this->params['form']['attr_id_list'])?array():$this->params['form']['attr_id_list'];
                foreach($attr_id_list AS $key => $attr_id){
                	$pattr = array(
                		"product_id"=>$id,
                		"product_type_attribute_id"=>$attr_id,
			        	"product_type_attribute_value"=>$this->params['form']['attr_value_list'][$key],
			            "product_type_attribute_price"=>empty($this->params['form']['attr_price_list'][$key])?0:$this->params['form']['attr_price_list'][$key]
                	);
                	$this->ProductAttribute->saveAll(array('ProductAttribute' => $pattr));
                }
                
            }

            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加商品:'.$product_name,'operation');
            }
            $this->flash("商品 ".$product_code." ".$product_name." 添加成功。点击这里继续编辑该商品。",'/products/'.$id,10);
        }
        $categories_tree=$this->Category->tree('P',$this->locale);
        $brands_tree=$this->Brand->getbrandformat();
        $new_brands_tree=array();
        foreach($brands_tree as $k => $v){
            if(@$v['BrandI18n']['locale']==$this->locale){
                $new_brands_tree[]=$v;
            }
        }
        $user_rank_list=$this->UserRank->findrank();
        $provider_list=$this->Provider->get_provider_list();
        //取配送方式
        $this->Shipping->set_locale($this->locale);
        $shipping_list=$this->Shipping->findAll(array("Shipping.status" => "1"));
        $this->set('shipping_list',$shipping_list); //配送方式
        $this->set('categories_tree',$categories_tree);
        $this->set('brands_tree',$new_brands_tree);
        $this->set('user_rank_list',$user_rank_list);
        $this->set('provider_list',$provider_list);
        $this->set('market_price_rate',$this->configs['market_price_rate']);
			//关键字
			$seokeyword_data = $this->SeoKeyword->find("all",array("conditions"=>array("status"=>1)));
			$this->set("seokeyword_data",$seokeyword_data);

    }
    function trash($id){
        $this->Product->updateAll(array('Product.status' => '2'),array('Product.id' => $id));
        $pn = $this->ProductI18n->find('list',array('fields' => array('ProductI18n.product_id','ProductI18n.name'),'conditions'=> 
                                        array('ProductI18n.product_id'=>$id,'ProductI18n.locale'=>$this->locale)));
        //操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'把商品:'.$pn[$id].' 放入回收站','operation');
        }
        $this->flash("该商品已经进入回收站",'/products/',10);
    }
    function copy_pro($original_pro_id){
        $this->Product->hasOne=array();
        $this->Product->hasOne=array('ProductI18n' => array('className' => 'ProductI18n','order' => '','dependent' => true,'foreignKey' => 'product_id'),);
        $original_pro=$this->Product->findall(array("Product.id" => $original_pro_id));
        foreach($original_pro as $k => $v){
            $max_product=$this->Product->find("","","Product.id DESC");
            $max_id=$max_product['Product']['id']+1;
            $v['Product']['code']=$this->generate_product_code($max_id);
            $v['Product']['id']=$max_id;
            $v['Product']['promotion_price']="0";
            $v['Product']['promotion_status']="0";
            $v['Product']['recommand_flag']="0";
            $v['Product']['forsale']="0";
            $v['Product']['quantity']="0";
            $v['ProductI18n']['id']="";
            $v['ProductI18n']['product_id']=$max_id;
            $products['Product']=$v['Product'];
            $products['ProductI18n'][]=$v['ProductI18n'];
        }
        $this->Product->save(array('Product' => $products['Product']));
        foreach($products['ProductI18n']as $ka => $va){
            $this->ProductI18n->save(array('ProductI18n' => $va));
        }
        $original_img=$this->ProductGallery->findall(array('ProductGallery.product_id' => $original_pro_id));
        foreach($original_img as $k => $v){
            $original_img[$k]['ProductGallery']['product_id']=$max_id;
            $original_img[$k]['ProductGallery']['id']="";
        }
        $this->ProductGallery->saveall($original_img);
        $pn = $this->ProductI18n->find('list',array('fields' => array('ProductI18n.product_id','ProductI18n.name'),'conditions'=> 
                        array('ProductI18n.product_id'=>$original_pro_id,'ProductI18n.locale'=>$this->locale)));
        //操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'复制商品:'.$pn[$original_pro_id],'operation');
        }
        $this->flash("复制商品成功",'/products/','');
    }
    function drop_img($img_id){
        $img_info=$this->ProductGallery->findbyid($img_id);
        if($img_info['ProductGallery']['img_detail']!='' && is_file('../'.$img_info['ProductGallery']['img_detail'])){
            @unlink('../'.$img_info['ProductGallery']['img_detail']);
        }
        if($img_info['ProductGallery']['img_thumb']!='' && is_file('../'.$img_info['ProductGallery']['img_thumb'])){
            @unlink('../'.$img_info['ProductGallery']['thumb_url']);
        }
        if($img_info['ProductGallery']['img_original']!='' && is_file('../'.$img_info['ProductGallery']['img_original'])){
            @unlink('../'.$img_info['ProductGallery']['img_original']);
        }
        $this->ProductGallery->del($img_id);
        //操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除相册图片:'.$img_info['ProductGalleryI18n']['description'],'operation');
        }
        Configure::write('debug',0);
        $result['type']="0";
        $result['msg']="删除成功";
        die(json_encode($result));
    }
    function searchproducts($cat_id="0",$brand_id="0",$products_id="0"){
    	$this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'=>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 )
                 	   );
		$this->Product->set_locale($this->locale);
        $condition["and"]["Product.forsale ="]='1';
        $condition["and"]["Product.status ="]='1';
        $keywords = $_REQUEST["keywords"];
        
        if(!empty($keywords))
        {	$keywords = urldecode($keywords);
            $condition["and"]["or"]["Product.code like"] = "%$keywords%";
            $condition["and"]["or"]["ProductI18n.name like"] = "%$keywords%";
            $condition["and"]["or"]["ProductI18n.description like"] = "%$keywords%";
            $condition["and"]["or"]["Product.id like"] = "%$keywords%";
        }
        if($cat_id != "0")
        {   
        	$category_id = $cat_id;
    	    $this->Category->hasOne=array();
		  	$this->Category->tree_p('P',$category_id,$this->locale);
    	  	$category_ids = isset($this->Category->allinfo['subids'][$category_id])?$this->Category->allinfo['subids'][$category_id]:$category_id;
			$condition["and"]["Product.category_id"] = $category_ids;

        }
        if($brand_id != "0")
        {
        	$condition["and"]["Product.brand_id"] = $brand_id;
            
        }
        if($products_id != "0")
        {
        	$condition["and"]["Product.id !="] = $products_id;
           
        }
        $fields[]="Product.id";
        $fields[]="ProductI18n.product_id";
        $fields[]="Product.code";
        $fields[]="Product.shop_price";
        $fields[]="Product.quantity";
        $fields[]="Product.recommand_flag";
        $fields[]="Product.forsale";
        $fields[]="ProductI18n.name"; 
        $products_tree=$this->Product->find("all",array("conditions"=>$condition,"order"=>"Product.id desc"));
		Configure::write('debug',0);
        $result['type']="0";
        $result['message']=$products_tree;
        die(json_encode($result));
    }
    function insert_link_products($product_id,$relation_id,$type,$is_double){
        if($is_double=='false'){
            $is_double='1';
        }
        else{
            $is_double='0';
        }
        $linkproduct_info=array('product_id' => $product_id,'related_product_id' => $relation_id,'is_double' => $is_double,'orderby'=>"50");
        $product_rela=$this->ProductRelation->find($linkproduct_info);
        if(empty($product_rela)){
            $this->ProductRelation->saveall(array('ProductRelation' => $linkproduct_info));
        }
        $this->Product->set_locale($this->locale);
        $linked_products=$this->requestAction("/commons/get_linked_products/".$product_id."");
        Configure::write('debug',0);
        $result['type']="0";
        $result['msg']=$linked_products;
        $result['type']=$type;
        die(json_encode($result));
    }
    function insert_link_topic_products($relation_id,$product_id,$type="T"){
        $condition="TopicProduct.product_id = '".$product_id."' and TopicProduct.topic_id = '".$relation_id."'";
        $this->TopicProduct->deleteAll($condition);
        $linkproduct_info=array('product_id' => $product_id,'topic_id' => $relation_id);
        $this->TopicProduct->save(array('TopicProduct' => $linkproduct_info));
        $linked_products=$this->requestAction("/commons/get_linked_topic_products/".$relation_id."");
        
        Configure::write('debug',0);
        $result['type']="0";
        $result['msg']=$linked_products;
        $result['type']=$type;
        die(json_encode($result));
    }
    function insert_link_article_products($article_id,$product_id,$type,$is_double){
        if($is_double=='false'){
            $is_double='1';
        }
        else{
            $is_double='0';
        }
        $this->ProductArticle->hasOne=array();
        $ProductArticle_info=$this->ProductArticle->find(array('product_id' => $product_id,'article_id' => $article_id));
        if(empty($ProductArticle_info)){
            $linkproduct_info1=array('product_id' => $product_id,'article_id' => $article_id,'is_double' => $is_double);
            $this->ProductArticle->saveAll(array('ProductArticle' => $linkproduct_info1));
        }
        $linked_products=$this->requestAction("/commons/get_articles_products/".$article_id."");
        Configure::write('debug',0);
        $result['type']="0";
        $result['msg']=$linked_products;
        $result['type']=$type;
        die(json_encode($result));
    }
    function drop_link_products($product_id,$related_product_id,$type="P"){
		$condition="ProductRelation.related_product_id = '".$related_product_id."' and ProductRelation.product_id = '".$product_id."'";
        $this->ProductRelation->deleteAll($condition);
        $this->Product->set_locale($this->locale);
        $linked_products=$this->requestAction("/commons/get_linked_products/".$product_id."");
        Configure::write('debug',0);
        $result['type']="0";
        $result['msg']=$linked_products;
        $result['type']=$type;
        die(json_encode($result));
    }
    function drop_link_topic_products($relation_id,$product_id,$type="T"){
        $condition="TopicProduct.product_id = '".$product_id."' and TopicProduct.topic_id = '".$relation_id."'";
        $this->TopicProduct->deleteAll($condition);
        $linked_products=$this->requestAction("/commons/get_linked_topic_products/".$relation_id."");
        Configure::write('debug',0);
        $result['type']="0";
        $result['msg']=$linked_products;
        $result['type']=$type;
        die(json_encode($result));
    }
    function drop_link_article_products($article_id,$product_id,$type){
        $condition="ProductArticle.product_id = '".$product_id."' and ProductArticle.article_id = '".$article_id."'";
        $this->ProductArticle->deleteAll($condition);
        $linked_products=$this->requestAction("/commons/get_articles_products/".$article_id."");
        Configure::write('debug',0);
        $result['type']="0";
        $result['msg']=$linked_products;
        $result['type']=$type;
        die(json_encode($result));
    }
    function insert_product_articles($product_id,$article_id,$type,$is_double){
        if($is_double=='false'){
            $is_double='1';
        }
        else{
            $is_double='0';
        }
        $this->ProductArticle->deleteAll(array('ProductArticle.article_id' => $article_id));
        $link_article_info=array('product_id' => $product_id,'article_id' => $article_id,'is_double' => $is_double,'orderby'=>"50");
        $this->ProductArticle->save(array('ProductArticle' => $link_article_info));
        $linked_articles=$this->requestAction("/commons/get_products_articles/".$product_id."");
        Configure::write('debug',0);
        $result['type']="0";
        $result['msg']=$linked_articles;
        $result['type']=$type;
        die(json_encode($result));
    }
    function drop_product_articles($article_id,$product_id,$type){
        $condition="ProductArticle.article_id = '".$article_id."' and ProductArticle.product_id = '".$product_id."'";
        $this->ProductArticle->deleteAll($condition);
        $linked_articles=$this->requestAction("/commons/get_products_articles/".$product_id."");
        Configure::write('debug',0);
        $result['type']="0";
        $result['msg']=$linked_articles;
        $result['type']=$type;
        die(json_encode($result));
    }
    
    function update_orderby($type){
    	$relation_id = $_REQUEST["id"];
    	$sort_value = $_REQUEST["val"];
        if($type=='P'){
            $this->ProductRelation->updateAll(array('ProductRelation.orderby' => $sort_value),array('ProductRelation.id' => $relation_id));
        }
        elseif($type=='A'){
            $this->ProductArticle->updateAll(array('ProductArticle.orderby' => $sort_value),array('ProductArticle.id' => $relation_id));
        }
        elseif($type=='T'){
            $this->TopicProduct->updateAll(array('TopicProduct.orderby' => $sort_value),array('TopicProduct.id' => $relation_id));
        }
        elseif($type=='PA'){
            $this->ProductArticle->updateAll(array('ProductArticle.orderby' => $sort_value),array('ProductArticle.id' => $relation_id));
        }
        Configure::write('debug',0);
        $result['type']="0";
        die(json_encode($result));
    }
    function get_attr($id,$product_type){
        $id=empty($id) ? 0 : intval($id);
        $product_type=empty($product_type) ? 0 : intval($product_type);
        $attr_html=$this->requestAction("/commons/build_attr_html/".$product_type."/".$id."");
        Configure::write('debug',0);
        $result['type']="0";
        $result['attr_html']=$attr_html;
        die(json_encode($result));
    }
    function generate_product_code($product_id){
        $products_code_prefix=isset($this->configs['products_code_prefix']) ? $this->configs['products_code_prefix']: 'sv';
        $product_code=$products_code_prefix.str_repeat('0',6-strlen($product_id)).$product_id;
       /* $condition=" Product.code like '%$product_code%' and Product.id != '$product_id'";
        $products_list=$this->Product->findAll($condition);
        $code_list=array();
        foreach($products_list as $k => $v){
            if(isset($v['Product']['code'])){
                $code_list[$k]=$v['Product']['code'];
            }
        }
        if(in_array($product_code,$code_list)){
            $max=pow(10,strlen($code_list[0])-strlen($product_code)+1)-1;
            $new_sn=$product_code.mt_rand(0,$max);
            while(in_array($new_sn,$code_list)){
                $new_sn=$product_code.mt_rand(0,$max);
            }
            $product_code=$new_sn;
        }*/
        return $product_code;
    }
    function update_default_gallery($gallery_id,$product_id){
        $productgallery=$this->ProductGallery->findById($gallery_id);
        $img_thumb=$productgallery['ProductGallery']['img_thumb'];
        $img_detail=$productgallery['ProductGallery']['img_detail'];
        $img_original=$productgallery['ProductGallery']['img_original'];
        $this->Product->updateAll(array('Product.img_thumb' => "'$img_thumb'"),array('Product.id' => $product_id));
        $this->Product->updateAll(array('Product.img_detail' => "'$img_detail'"),array('Product.id' => $product_id));
        $this->Product->updateAll(array('Product.img_original' => "'$img_original'"),array('Product.id' => $product_id));
        Configure::write('debug',0);
        die($gallery_id);
    }
    function batch(){
        $pro_ids=!empty($this->params['form']['checkboxes']) ? $this->params['form']['checkboxes']: 0;
        if($this->params['form']['act_type']=='del'){
            $this->Product->updateAll(array('Product.status' => '2'),array('Product.id' => $pro_ids));
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
               $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'批量回收商品','operation');
            }
            $this->flash("商品已经进入回收站",'/products/','');
        }
        if($this->params['form']['act_type']=='category'){
        	$cid = $this->params['form']['category_change'];
            $this->Product->updateAll(array('Product.category_id' => $this->params['form']['category_change']),array('Product.id' => $pro_ids));
            
           $pn=$this->CategoryI18n->find('list',array('fields' =>
               array('CategoryI18n.category_id','CategoryI18n.name'),'conditions'=>array('CategoryI18n.category_id'=>
               $cid,'CategoryI18n.locale'=>$this->locale)));
            
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
               $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'批量转移商品到分类 '.$pn[$cid],'operation');
            }
            $this->flash("修改商品分类成功",'/products/','');
        }
        if($this->params['form']['act_type']=='batch_edit_price'){
        	$this->Product->updateAll(array('Product.shop_price' => 'Product.shop_price*'.$this->params['form']['batch_edit_price_value']),array('Product.id' => $pro_ids));
        	 $this->flash("批量修改价格成功，点击这里反回列表页！",'/products/','');
        }
    }
    function batch_add_products(){
        $this->pageTitle="批量上传"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '批量上传','url' => '');
        $this->set('navigations',$this->navigations);
        if(!empty($_FILES['file'])){
            if($_FILES['file']['error'] > 0){
                $this->flash("文件上传错误",'/products/upload_products_file','');
            }
            else if(empty($_POST['category_id'])){
                $this->flash("请选择商品分类",'/products/upload_products_file','');
            }
            else{
                $handle=@fopen($_FILES['file']['tmp_name'],"r");
                $key_arr=array('name','meta_keywords','meta_description','description','code','brand','provider','shop_price','market_price','weight','quantity','recommand_flag','forsale','alone','extension_code','img_thumb','img_detail','img_original','min_buy','max_buy','point','point_fee');
                while($row=fgetcsv($handle,10000,",")){
                    foreach($row as $k => $v){
                        $temp[$key_arr[$k]]=iconv($_REQUEST["csv_export_code"],'utf-8',$v);
                    }
                    $temp['description']=htmlspecialchars($temp['description']);
                    $data[]=$temp;
                }
                $this->set('extension_code',array('' => '真实商品','virtual_card' => '虚拟卡'));
                $this->set('products_list',$data);
                $this->set('category_id',$_POST['category_id']);
            }
        }
        if(!empty($this->data)){
            $category_id=$_POST['category_id'];
            $checkbox_arr=$_REQUEST['checkbox'];
            foreach($this->data as $key => $data){
                if(!in_array($key,$checkbox_arr)){
                    continue;
                }
                $ProductI18n['name']=$data['name'];
                $ProductI18n['meta_keywords']=$data['meta_keywords'];
                $ProductI18n['meta_description']=$data['meta_description'];
                $ProductI18n['description']=$data['description'];
                $ProductsCategory['category_id']=$category_id;
                $ProductGallery['img_thumb']=$data['img_thumb'];
                $ProductGallery['img_detail']=$data['img_detail'];
                $ProductGallery['img_original']=$data['img_original'];
                $Product['code']=$data['code'];
                $Product['shop_price']=$data['shop_price'] ? $data['shop_price']: $data['market_price'];
                $Product['market_price']=$data['market_price'] ? $data['market_price']: $data['shop_price'];
                $Product['weight']=$data['weight'] ? $data['weight']: 0;
                $Product['quantity']=$data['quantity'];
                $Product['recommand_flag']=$data['recommand_flag'];
                $Product['forsale']=$data['forsale'];
                $Product['alone']=$data['alone'];
                $Product['extension_code']=$data['extension_code'];
                $Product['img_thumb']=$data['img_thumb'];
                $Product['img_detail']=$data['img_detail'];
                $Product['img_original']=$data['img_original'];
                $Product['min_buy']=$data['min_buy'] ? $data['min_buy']: 1;
                $Product['max_buy']=$data['max_buy'] ? $data['max_buy']: 100;
                $Product['point']=$data['point'] ? $data['point']: 0;
                $Product['point_fee']=$data['point_fee'] ? $data['point_fee']: 0;
                $brand=$this->BrandI18n->findByName($data['brand']);
                $provider=$this->Provider->findByName($data['provider']);
                $Product['brand_id']=$brand ? $brand['BrandI18n']['brand_id']: 0;
                $Product['provider_id']=$provider ? $provider['Provider']['id']: 0;
                if(empty($Product['code']) || $this->Product->findByCode($data['code'])){
                    $max_product=$this->Product->find("","","Product.id DESC");
                    $max_id=$max_product['Product']['id']+1;
                    $Product['code']=$this->generate_product_code($max_id);
                }
                if(empty($Product['quantity'])){
                    $Product['quantity']=$this->configs['default_stock'];
                }
                $this->Product->save($Product);
                $id=$this->Product->id;
                $this->Product->id='';
                $ProductI18n['product_id']=$id;
                if(is_array($this->languages))
                foreach($this->languages as $k => $v){
                    $this->ProductI18n->id='';
                    $ProductI18n['locale']=$v['Language']['locale'];
                    $this->ProductI18n->save($ProductI18n);
                }
                if(!empty($ProductGallery['img_thumb']) || !empty($ProductGallery['img_detail']) || !empty($ProductGallery['img_original'])){
                    $ProductGallery['product_id']=$id;
                    $this->ProductGallery->id='';
                    $this->ProductGallery->save($ProductGallery);
                }
                $ProductsCategory['product_id']=$id;
                $this->ProductsCategory->id='';
                $this->ProductsCategory->save($ProductsCategory);
            }
            $this->flash("导入成功",'/products/upload_products_file','');
        }
    }
    function upload_products_file(){
        $this->pageTitle="批量上传"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '批量上传','url' => '');
        $this->set('navigations',$this->navigations);
        $categories_tree=$this->Category->tree('P',$this->locale);
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//
        $this->set("systemresource_info",$systemresource_info); 
        $this->set('categories_tree',$categories_tree);
    }
    function download($csv_export_code="gbk"){
        Configure::write('debug',0);
      		$condition = "";
      		$languagedictionary[] = "download_product_name";//商品名称
      		$languagedictionary[] = "download_Product_Keywords";//商品关键词
      		$languagedictionary[] = "download_brief_description";//商品简单描述
      		$languagedictionary[] = "download_Details";//详细信息
      		$languagedictionary[] = "download_Product_code";//商品货号
      		$languagedictionary[] = "download_Product_Brand";//商品品牌
      		$languagedictionary[] = "download_Supplier";//供应商
      		$languagedictionary[] = "download_our_price";//本店售价
      		$languagedictionary[] = "download_Market_price";//市场售价
      		$languagedictionary[] = "download_Product_Weight";//商品重量
      		$languagedictionary[] = "download_Stock_Number";//库存数量
      		$languagedictionary[] = "download_recommended";//是否推荐
      		$languagedictionary[] = "download_shelves";//是否上架
      		$languagedictionary[] = "download_ordinary_commodity";//能否作为普通商品销售
      		$languagedictionary[] = "download_Types_of_goods";//商品种类(为空：真实商品 virtual_card：虚拟卡)
      		$languagedictionary[] = "download_Thumbnail";//缩略图
      		$languagedictionary[] = "download_Detailed";//详细图
      		$languagedictionary[] = "download_original";//原图
      		$languagedictionary[] = "download_purchase";//最小购买数
      		$languagedictionary[] = "download_maximum";//最大购买数
      		$languagedictionary[] = "download_Presented";//赠送积分数
      		$languagedictionary[] = "download_Points";//积分购买额度
      		
      		
      		$condition["name"] = $languagedictionary;
			$csv_systemResource = $this->SystemResource->findbyresource_value($csv_export_code);
			$condition["locale"] = $csv_systemResource["SystemResource"]["code"];
      		$languagedictionary_info = $this->LanguageDictionary->find("all",array("conditions"=>$condition));
      		$csv_str = array();
      		foreach( $languagedictionary_info as $csv_k=>$csv_v ){
      			$csv_str[$csv_v["LanguageDictionary"]["name"]] = $csv_v["LanguageDictionary"]["value"];
      		}

        	header("Content-type: application/vnd.ms-excel; charset=".$csv_export_code);
        	header("Content-Disposition: attachment; filename=products_list.csv");
        $str="".$csv_str["download_product_name"].",".$csv_str["download_Product_Keywords"].",".$csv_str["download_brief_description"].",".$csv_str["download_Details"].",".$csv_str["download_Product_code"].",".$csv_str["download_Product_Brand"].",".$csv_str["download_Supplier"].",".$csv_str["download_our_price"].",".$csv_str["download_Market_price"].",".$csv_str["download_Product_Weight"].",".$csv_str["download_Stock_Number"].",".$csv_str["download_recommended"].",".$csv_str["download_shelves"].",".$csv_str["download_ordinary_commodity"].",".$csv_str["download_Types_of_goods"].",".$csv_str["download_Thumbnail"].",".$csv_str["download_Detailed"].",".$csv_str["download_original"].",".$csv_str["download_purchase"].",".$csv_str["download_maximum"].",".$csv_str["download_Presented"].",".$csv_str["download_Points"]."";
        echo iconv('utf-8',$csv_export_code,$str."\n");
        exit;
    }
    function download_example(){
        Configure::write('debug',0);
        header("Content-type: application/vnd.ms-excel; charset=gb2312");
        header("Content-Disposition: attachment; filename=products_list.csv");
        $str="test1,test1,test1,test1,svcart0000019,10,1,121,1221,1,222,1,1,1,,http://htdocs.trunk.seevia.cn/img/products/svcart000009/49b9b1d0.jpg,http://htdocs.trunk.seevia.cn/img/products/svcart000009/49b9b1d0.jpg,http://htdocs.trunk.seevia.cn/img/products/svcart000009/49b9b1d0.jpg,22,54,432,34"."\n";
        $str.="test2,test2,test2,test2,svcart0000029,10,1,121,1221,1,222,1,1,1,,http://htdocs.trunk.seevia.cn/img/products/svcart000009/49b9b1d0.jpg,http://htdocs.trunk.seevia.cn/img/products/svcart000009/49b9b1d0.jpg,http://htdocs.trunk.seevia.cn/img/products/svcart000009/49b9b1d0.jpg,22,54,432,34"."\n";
        $str.="test3,test3,test3,test3,svcart0000039,10,1,121,1221,1,222,1,1,1,,http://htdocs.trunk.seevia.cn/img/products/svcart000009/49b9b1d0.jpg,http://htdocs.trunk.seevia.cn/img/products/svcart000009/49b9b1d0.jpg,http://htdocs.trunk.seevia.cn/img/products/svcart000009/49b9b1d0.jpg,22,54,432,34"."\n";
        $str.="test4,test4,test4,test4,svcart0000049,10,1,121,1221,1,222,1,1,1,,http://htdocs.trunk.seevia.cn/img/products/svcart000009/49b9b1d0.jpg,http://htdocs.trunk.seevia.cn/img/products/svcart000009/49b9b1d0.jpg,http://htdocs.trunk.seevia.cn/img/products/svcart000009/49b9b1d0.jpg,22,54,432,34";
        echo iconv('utf-8','gb2312',$str."\n");
        exit;
    }
    function update_code($old_product_code,$new_product_code,$product_id){
        rename("../img/products/".$old_product_code,"../img/products/".$new_product_code);
        $this->Product->updateAll(array('Product.code' => "'$new_product_code'"),array('Product.id' => $product_id));
        $this->Product->hasOne=array();
        $product_info=$this->Product->findById($product_id);
        $product_info['Product']['img_thumb']=str_replace($old_product_code,$new_product_code,$product_info['Product']['img_thumb']);
        $product_info['Product']['img_detail']=str_replace($old_product_code,$new_product_code,$product_info['Product']['img_detail']);
        $product_info['Product']['img_original']=str_replace($old_product_code,$new_product_code,$product_info['Product']['img_original']);
        $this->Product->save($product_info);
        $productgallery_info=$this->ProductGallery->findAll(array("ProductGallery.product_id" => $product_id));
        foreach($productgallery_info as $k => $v){
            $v['ProductGallery']['img_thumb']=str_replace($old_product_code,$new_product_code,$v['ProductGallery']['img_thumb']);
            $v['ProductGallery']['img_detail']=str_replace($old_product_code,$new_product_code,$v['ProductGallery']['img_detail']);
            $v['ProductGallery']['img_original']=str_replace($old_product_code,$new_product_code,$v['ProductGallery']['img_original']);
            $this->ProductGallery->save($v);
        }
    }
    
    //检测货号唯一性
    function product_code_unique($product_code,$product_id=""){
        $this->Product->hasOne=array();
        $condition["Product.code"]=$product_code;
        if($product_id!=""){
            $condition["Product.id !="]=$product_id;
        }
        $product_info=$this->Product->find($condition);
        Configure::write('debug',0);
        if(empty($product_info)){
            echo true;
        }
        else{
            echo false;
        }
        die();
    }
    function upname(){
    	$id = $_REQUEST["id"];
    	$val = $_REQUEST["val"];
    	$this->Product->hasMany = array();
    	$this->Product->hasOne = array();
    	$this->ProductI18n->updateAll(
    		array("name"=>"'".$val."'"),
    		array("product_id"=>$id,"locale"=>$this->locale)
    	);
    
    	Configure::write('debug',0);
    	die();
    
    }
//$sourcestr 是要处理的字符串
//$cutlength 为截取的长度(即字数)
function cut_str($sourcestr,$cutlength)
{
   $returnstr='';
   $i=0;
   $n=0;
   $str_length=strlen($sourcestr);//字符串的字节数
   while (($n<$cutlength) and ($i<=$str_length))
   {
      $temp_str=substr($sourcestr,$i,1);
      $ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码
      if ($ascnum>=224)    //如果ASCII位高与224，
      {
         $returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符         
         $i=$i+3;            //实际Byte计为3
         $n++;            //字串长度计1
      }
      elseif ($ascnum>=192) //如果ASCII位高与192，
      {
         $returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
         $i=$i+2;            //实际Byte计为2
         $n++;            //字串长度计1
      }
      elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，
      {
         $returnstr=$returnstr.substr($sourcestr,$i,1);
         $i=$i+1;            //实际的Byte数仍计1个
         $n++;            //但考虑整体美观，大写字母计成一个高位字符
      }
      else                //其他情况下，包括小写字母和半角标点符号，
      {
         $returnstr=$returnstr.substr($sourcestr,$i,1);
         $i=$i+1;            //实际的Byte数计1个
         $n=$n+0.5;        //小写字母和半角标点等与半个高位字符宽...
      }
   }
         if ($str_length>$cutlength){
          $returnstr = $returnstr . "...";//超过长度时在尾处加上省略号
      }
    return $returnstr;

}
	function get_img_name($dir="../img"){
		$handle=opendir("..".$dir);  
	  	$i=0;  
	  	$list = array();
	  	while($file=readdir($handle)){  
	  		if(($file!=".")and($file!="..")){  
		  		$list[$file]=$dir.$file;  
		  		$i=$i+1;  
	  		}  
	  }  
	  closedir($handle);    
	  return   $list;   
	}
	/**
	* 创建图片的缩略图
	*
	* @param   string      $img    原始图片的路径
	* @param   int         $thumb_width  缩略图宽度
	* @param   int         $thumb_height 缩略图高度
	* @param   int         $filename 	 图片名..
	* @param   strint      $dir         指定生成图片的目录名
	* @return  mix         如果成功返回缩略图的路径，失败则返回false
	*/
	function make_thumb($img, $thumb_width = 0, $thumb_height = 0, $bgcolor='#FFFFFF',$filename,$dir,$imgname){
		//echo $filename;
		/* 检查缩略图宽度和高度是否合法 */
		if ($thumb_width == 0 && $thumb_height == 0){
			return false;
		}
		/* 检查原始文件是否存在及获得原始文件的信息 */
		$org_info = @getimagesize($img);
		if (!$org_info){
			return false;
		}
		
		$img_org = $this->img_resource($img, $org_info[2]);
		/* 原始图片以及缩略图的尺寸比例 */
		$scale_org = $org_info[0] / $org_info[1];
		/* 处理只有缩略图宽和高有一个为0的情况，这时背景和缩略图一样大 */
		if ($thumb_width == 0){
			$thumb_width = $thumb_height * $scale_org;
		}
		if ($thumb_height == 0){
			$thumb_height = $thumb_width / $scale_org;
		}

		/* 创建缩略图的标志符 */
		$img_thumb  = @imagecreatetruecolor($thumb_width, $thumb_height);//真彩

		/* 背景颜色 */
		if (empty($bgcolor)){
			$bgcolor = $bgcolor;
		}
		$bgcolor = trim($bgcolor,"#");
		sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
		$clr = imagecolorallocate($img_thumb, $red, $green, $blue);
		imagefilledrectangle($img_thumb, 0, 0, $thumb_width, $thumb_height, $clr);
		if ($org_info[0] / $thumb_width > $org_info[1] / $thumb_height){
			$lessen_width  = $thumb_width;
			$lessen_height  = $thumb_width / $scale_org;
		}else{
			/* 原始图片比较高，则以高度为准 */
			$lessen_width  = $thumb_height * $scale_org;
			$lessen_height = $thumb_height;
		}
		$dst_x = ($thumb_width  - $lessen_width)  / 2;
		$dst_y = ($thumb_height - $lessen_height) / 2;
		
		/* 将原始图片进行缩放处理 */
		imagecopyresampled($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);

		
		/* 生成文件 */
		if (function_exists('imagejpeg')){
			$filename .= ".".$imgname;
			imagejpeg($img_thumb, $dir . $filename,100);
		}elseif (function_exists('imagegif')){
			$filename .= ".".imgname;
			imagegif($img_thumb, $dir . $filename,100);
		}elseif (function_exists('imagepng')){
			$filename .= ".".$imgname;
			imagepng($img_thumb, $dir . $filename,100);
		}else{
			return false;
		}
		imagedestroy($img_thumb);
		imagedestroy($img_org);

		//确认文件是否生成
		if (file_exists($dir . $filename)){
			return  $filename;
		}else{
			return false;
		}
	}
	/**
	* 根据来源文件的文件类型创建一个图像操作的标识符
	*
	* @param   string      $img_file   图片文件的路径
	* @param   string      $mime_type  图片文件的文件类型
	* @return  resource    如果成功则返回图像操作标志符，反之则返回错误代码
	*/
	function img_resource($img_file, $mime_type){
		switch ($mime_type){
			
			case 1:
			case 'image/gif':
			$res = imagecreatefromgif($img_file);
			break;
			
			case 2:
			case 'image/pjpeg':
			case 'image/jpeg':
			$res = imagecreatefromjpeg($img_file);
			break;

			case 3:
			case 'image/x-png':
			case 'image/png':
			$res = imagecreatefrompng($img_file);
			break;

			default:
			return false;
		}
		return $res;
	}
	/*
	* 参数：
	*       $groundImage     	要加水印的图片
	*       $waterPos        	水印位置		0为随机位置；
	*                       	1为顶端居左，	2为顶端居中，	3为顶端居右；
	*                       	4为中部居左，	5为中部居中，	6为中部居右；
	*                       	7为底端居左，	8为底端居中，	9为底端居右；
	*       $waterImage      	图片水印
	*		$watermark_alpha	图片水印透明度
	*       $waterText       	文字水印
	*       $fontSize        	文字大小
	*       $textColor       	文字颜色
	*       $fontfile        	windows字体文件
	*       $xOffset         	水平偏移量，即在默认水印坐标值基础上加上这个值，默认为0，如果给水印留
	*                       	出水平方向上的边距，可以设置这个值,如：2 则表示在默认的基础上向右移2个单位,-2 表示向左移两单位
	*       $yOffset         	垂直偏移量，即在默认水印坐标值基础上加上这个值，默认为0，如果给水印留
	*                       	出垂直方向上的边距，可以设置这个值,如：2 则表示在默认的基础上向下移2个单位,-2 表示向上移两单位
	* 返回值：
	*        0   水印成功
	*        1   水印图片格式不支持
	*        2   要水印的背景图片不存在
	*        3   需要加水印的图片的长度或宽度比水印图片或文字区域还小，无法生成水印
	*        4   字体文件不存在
	*        5   水印文字颜色格式不正确
	*        6   水印背景图片格式目前不支持
	*/
	function imageWaterMark($groundImage,$waterPos=0,$waterImage="",$watermark_alpha=50,$fontSize=44,$textColor="#6AD267",$waterText="", $fontfile='../vendors/securimage/elephant.ttf',$xOffset=0,$yOffset=0){
	
		$isWaterImage = FALSE;
		//读取水印文件
		if(!empty($waterImage) && file_exists($waterImage)){
			$isWaterImage = TRUE;
			$water_info = getimagesize($waterImage);
			$water_w     = $water_info[0];//取得水印图片的宽
			$water_h     = $water_info[1];//取得水印图片的高
			
			switch($water_info[2]){    //取得水印图片的格式  
	            case 1:$water_im = imagecreatefromgif($waterImage);break;
	            case 2:$water_im = imagecreatefromjpeg($waterImage);break;
	            case 3:$water_im = imagecreatefrompng($waterImage);break;
	            default:return 1;
	        }
	    }

	     //读取背景图片
		if(!empty($groundImage) && file_exists($groundImage)){
	        $ground_info  = getimagesize($groundImage);
	        $ground_w     = $ground_info[0];//取得背景图片的宽
	        $ground_h     = $ground_info[1];//取得背景图片的高

	        switch($ground_info[2]){    //取得背景图片的格式  
	             case 1:$ground_im = imagecreatefromgif($groundImage);break;
	             case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
	             case 3:$ground_im = imagecreatefrompng($groundImage);break;
	             default:return 1;
	         }
	     }else{
			return 2;
	     }

	     //水印位置
		if($isWaterImage){ //图片水印  
	         $w = $water_w;
	         $h = $water_h;
	         $label = "图片的";
		}else{  
	     	//文字水印
	     	
			if(!file_exists($fontfile))return 4;
				$temp 	= imagettfbbox($fontSize,0,$fontfile,$waterText);//取得使用 TrueType 字体的文本的范围
				$w 		= $temp[2] - $temp[6];
				$h 		= $temp[3] - $temp[7];
				unset($temp);
	     }
	     if( ($ground_w < $w) || ($ground_h < $h) ){
	         return 3;
	     }
	     switch($waterPos) {
	         case 0://随机
	             $posX = rand(0,($ground_w - $w));
	             $posY = rand(0,($ground_h - $h));
	             break;
	         case 1://1为顶端居左
	             $posX = 0;
	             $posY = 0;
	             break;
	         case 2://2为顶端居中
	             $posX = ($ground_w - $w) / 2;
	             $posY = 0;
	             break;
	         case 3://3为顶端居右
	             $posX = $ground_w - $w;
	             $posY = 0;
	             break;
	         case 4://4为中部居左
	             $posX = 0;
	             $posY = ($ground_h - $h) / 2;
	             break;
	         case 5://5为中部居中
	             $posX = ($ground_w - $w) / 2;
	             $posY = ($ground_h - $h) / 2;
	             break;
	         case 6://6为中部居右
	             $posX = $ground_w - $w;
	             $posY = ($ground_h - $h) / 2;
	             break;
	         case 7://7为底端居左
	             $posX = 0;
	             $posY = $ground_h - $h;
	             break;
	         case 8://8为底端居中
	             $posX = ($ground_w - $w) / 2;
	             $posY = $ground_h - $h;
	             break;
	         case 9://9为底端居右
	             $posX = $ground_w - $w;
	             $posY = $ground_h - $h;
	             break;
	         default://随机
	             $posX = rand(0,($ground_w - $w));
	             $posY = rand(0,($ground_h - $h));
	             break;     
	     }

	     //设定图像的混色模式
	     imagealphablending($ground_im, true);
	     if($isWaterImage) { //图片水印
	         imagecopymerge($ground_im, $water_im, $posX + $xOffset, $posY + $yOffset, 0, 0, $water_w,$water_h, $watermark_alpha);//拷贝水印到目标文件         
	     }else{//文字水印
			if( !empty($textColor) && (strlen($textColor)==7) ) {
				$R = hexdec(substr($textColor,1,2));
				$G = hexdec(substr($textColor,3,2));
				$B = hexdec(substr($textColor,5));
	         }else{
				return 5;
	         }
	         imagettftext ( $ground_im, $fontSize, 0, $posX + $xOffset, $posY + $h + $yOffset, imagecolorallocate($ground_im, $R, $G, $B), $fontfile, $waterText);
	     }

	     //生成水印后的图片
	     
	     @unlink($groundImage);
	     switch($ground_info[2]) {//取得背景图片的格式
			case 1:imagegif($ground_im,$groundImage);break;
			case 2:imagejpeg($ground_im,$groundImage);break;
			case 3:imagepng($ground_im,$groundImage);break;
			default: return 6;
	     }

	     //释放内存
	     if(isset($water_info)) unset($water_info);
	     if(isset($water_im)) imagedestroy($water_im);
	     unset($ground_info);
	     imagedestroy($ground_im);
	     return 0;
	}

 }

?>