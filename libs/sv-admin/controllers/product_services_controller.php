<?php
/*****************************************************************************
 * SV-Cart 服务管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: product_services_controller.php 3184 2009-07-22 06:09:42Z huangbo $
 *****************************************************************************/
class ProductServicesController extends AppController {
	var $name = 'ProductServices';
	var $helpers = array('Pagination','Html','Form','Javascript','Fck'); // Added
	var $components = array('Pagination','RequestHandler');
	var $uses = array('ProductLocalePrice','ProductGalleryI18n','Order',"OrderProduct","ProductService","ProductRank","TopicProduct","Product","UserRank","Category","Brand","Provider","BookingProduct","ProductType","ProductGallery","ProductRelation","ProductArticle","ProductI18n","ProductTypeAttribute","ProductAttribute","ProductsCategory","BrandI18n");

	function index($export=0){
		$this->operator_privilege('service_product_view');
		$this->pageTitle = '服务管理'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'服务管理','url'=>'/product_services/');
		$this->set('navigations',$this->navigations);
		$this->Product->set_locale($this->locale);
       $condition = "  Product.status = '1' and Product.extension_code='services_product'";
        if(isset($this->params['url']['quantity']) && $this->params['url']['quantity'] != 0)
        {
            $condition.=" and Product.quantity <= '".$this->params['url']['quantity']."'";
        }
        if(isset($this->params['url']['forsale']) && $this->params['url']['forsale'] != '99')
        {
            $condition.=" and Product.forsale = '".$this->params['url']['forsale']."'";
        }
        if(isset($this->params['url']['promotion_status']) && $this->params['url']['promotion_status'] != 0)
        {
            $condition.=" and Product.promotion_status = '".$this->params['url']['promotion_status']."'";
        }
        if(isset($this->params['url']['category_id']) && $this->params['url']['category_id'] != 0)
        {
            $condition.=" and Product.category_id = '".$this->params['url']['category_id']."'";
        }
        if(isset($this->params['url']['keywords']) && $this->params['url']['keywords'] != '')
        {
            $keywords=$this->params['url']['keywords'];
            $condition.=" and (Product.code like '%$keywords%' or ProductI18n.name like '%$keywords%' or ProductI18n.description like '%$keywords%' or Product.id='$keywords') ";
            $this->set('keywords',$this->params['url']['keywords']);
        }
        if(isset($this->params['url']['min_price']) && $this->params['url']['min_price'] != '')
        {
            $condition.=" and Product.shop_price >= '".$this->params['url']['min_price']."'";
            $this->set('min_price',$this->params['url']['min_price']);
        }
        if(isset($this->params['url']['max_price']) && $this->params['url']['max_price'] != '')
        {
            $condition.=" and Product.shop_price <= '".$this->params['url']['max_price']."'";
            $this->set('max_price',$this->params['url']['max_price']);
        }
        if(isset($this->params['url']['brand_id']) && $this->params['url']['brand_id'] != 0)
        {
            $condition.=" and Product.brand_id = '".$this->params['url']['brand_id']."'";
        }
        if(isset($this->params['url']['type_id']) && $this->params['url']['type_id'] != '')
        {
            $condition.=" and Product.product_type_id ='".$this->params['url']['type_id']."'";
        }
        if(isset($this->params['url']['date']) && $this->params['url']['date'] != '')
        {
            $condition.=" and Product.created  >= '".$this->params['url']['date']."'";
            $this->set('date',$this->params['url']['date']);
        }
        if(isset($this->params['url']['date2']) && $this->params['url']['date2'] != '')
        {
            $condition.=" and Product.created  <= '".$this->params['url']['date2']." 23:59:59'";
            $this->set('date2',$this->params['url']['date2']);
        }
          if(isset($this->params['url']['date3']) && $this->params['url']['date3'] != '')
        {
            $condition .= " and ProductService.start_time  >= '".$this->params['url']['date3']."'";
            $this->set('date3',$this->params['url']['date3']);
        }
        if(isset($this->params['url']['date4']) && $this->params['url']['date4'] != '')
        {
            $condition .= " and ProductService.end_time  <= '".$this->params['url']['date4']." 23:59:59'";
            $this->set('date4',$this->params['url']['date4']);
        }        
        
        if(isset($this->params['url']['is_recommond']) && $this->params['url']['is_recommond'] !=  - 1)
        {
            $condition.=" and Product.recommand_flag = '".$this->params['url']['is_recommond']."'";
        }
        if(isset($this->params['url']['provider_id']) && $this->params['url']['provider_id'] !=  - 1)
        {
            $condition.=" and Product.provider_id  = '".$this->params['url']['provider_id']."'";
        }
        $total=$this->Product->findCount($condition,0);
        $sortClass='Product';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        if(isset($export) && $export==="export"){
        	$products_list=$this->Product->findAll($condition,'',"Product.created DESC");
        }else{
        	$products_list=$this->Product->findAll($condition,'',"Product.created DESC",$rownum,$page);
        }
        $categories_tree=$this->Category->tree('P',$this->locale);
        $this->Brand->set_locale($this->locale);
        $brands_tree=$this->Brand->getbrandformat();
        $types_tree=$this->ProductType->gettypeformat();
        $provides_tree=$this->Provider->findAll();
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
   	/*	if(isset($_REQUEST['page'])&& !empty($_REQUEST['page'])){
			$this->set('ex_page',$this->params['url']['page']);
		}
		if(isset($_REQUEST['category_id'])){
			if(isset($this->params['url']['brand_id']) && $this->params['url']['brand_id'] != 0)
	        {
	            $brand_id=$this->params['url']['brand_id'];
	        }else{
	        	$brand_id='';
	        }
			if(isset($this->params['url']['type_id']) && $this->params['url']['type_id'] != 0)
	        {
	            $type_id=$this->params['url']['type_id'];
	        }else{
	        	$type_id='';
	        }
			if(isset($this->params['url']['provider_id']) && $this->params['url']['provider_id'] != 0)
	        {
	            $provider_id=$this->params['url']['provider_id'];
	        }else{
	        	$provider_id='';
	        }			
			$ex_url="category_id=".$this->params['url']['category_id']."&forsale=".$this->params['url']['forsale']."&min_price=".$this->params['url']['min_price']."&max_price=".$this->params['url']['max_price'].
			"&keywords=".$this->params['url']['keywords']."&brand_id=".$brand_id."&type_id=".$type_id."&is_recommond=".$this->params['url']['is_recommond']."&provider_id=".$provider_id."&date=".$this->params['url']['date']."&date2=".$this->params['url']['date2']."&date3=".$this->params['url']['date3']."&date4=".$this->params['url']['date4'];
		}else{
			$ex_url="category_id=0&forsale=99&min_price=&max_price=&keywords=&brand_id=&type_id=&is_recommond=-1&provider_id=-1&date=&date2=&date3=&date4=";
		}
		$this->set('ex_url',$ex_url);  
		     
 		/*CSV导出*/
		//if(isset($_REQUEST['export'])&&$_REQUEST['export']==="export")
		if(isset($export) && $export==="export")
		{
			$filename = '服务商品导出'.date('Ymd').'.csv';
			$ex_data= "服务商品统计报表,";
			$ex_data.= "日期,";
			$ex_data.= date('Y-m-d')."\n";
			$ex_data.= "编号,";
			$ex_data.= "商品名称,";
			$ex_data.= "货号,";
			$ex_data.= "价格,";
			$ex_data.= "上架,";
			$ex_data.= "推荐,";
			$ex_data.= "是否有效\n";

			foreach($products_list as $k=>$v) {
				$ex_data.= $v['Product']['id'].",";
				$ex_data.= $v['ProductI18n']['name'].",";
				$ex_data.= $v['Product']['code'].",";
				$ex_data.= $v['Product']['shop_price'].",";
				if($v['Product']['forsale']=="1"){
					$ex_data.= "是,";
				}else{
					$ex_data.= "否,";	
				}					
				if($v['Product']['recommand_flag']=="1"){
					$ex_data.= "是,";
				}else{
					$ex_data.= "否,";	
				}
				if($v['ProductService']['status']=="1"){
					$ex_data.= "是\n";
				}else{
					$ex_data.= "否\n";	
				}														
			}
			
		 	Configure::write('debug',0);
			header("Content-type: text/csv; charset=gb2312");
			header ("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
			header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
			header('Expires:   0');
			header('Pragma:   public');
			echo iconv('utf-8','gb2312',$ex_data."\n");
			exit;		
		}				   	              
	}
	
	function add(){
		$this->operator_privilege('service_product_add');
		$this->pageTitle = '新增服务商品-服务服务商品'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'服务管理','url'=>'/product_downloads/');
		 $this->navigations[] = array('name' => '新增服务商品','url' => '');
		$this->set('navigations',$this->navigations);
		$this->Product->set_locale($this->locale);
       if($this->RequestHandler->isPost())
        {
            $this->data['Product']['weight'] = !empty($this->data['Product']['weight']) ? $this->data['Product']['weight']: "0";
            $this->data['Product']['shop_price'] = !empty($this->data['Product']['shop_price']) ? $this->data['Product']['shop_price']: "0";
            $this->data['Product']['market_price'] = !empty($this->data['Product']['market_price']) ? $this->data['Product']['market_price']: "0";
            $this->data['Product']['product_name_style'] = $this->params['form']['product_style_color'].'+'.$this->params['form']['product_style_word'];
            $this->data['Product']['point'] = !empty($this->data['Product']['point']) ? $this->data['Product']['point']: "0";
            $this->data['Product']['img_thumb'] = !empty($this->data['Product']['img_thumb']) ? $this->data['Product']['img_thumb']: "";
            $this->data['Product']['img_detail'] = !empty($this->data['Product']['img_detail']) ? $this->data['Product']['img_detail']: "";
            $this->data['Product']['img_original'] = !empty($this->data['Product']['img_original']) ? $this->data['Product']['img_original']: "";
            $this->data['Product']['product_rank_id'] = !empty($this->data['Product']['product_rank_id']) ? $this->data['Product']['product_rank_id']: "0";
            $this->data['Product']['extension_code'] = "services_product";
            $this->data['Product']['is_real'] = "0";
            $this->data['ProductService']['service_cycle'] = !empty($this->data['ProductService']['service_cycle']) ? $this->data['ProductService']['service_cycle']: "0";
			$this->data['ProductService']['view_count'] = "0";

            //新增商品
            if(empty($this->data['Product']['code']))
            {
                $max_product = $this->Product->find("","","Product.id DESC");
                $max_id = $max_product['Product']['id'] + 1;
                //pr($max_product);
                $this->data['Product']['code'] = $this->generate_product_code($max_id);
            }
            //$this->data['Product']['quantity'] = "9999";
            if(!isset($this->data['Product']['promotion_status']))
            {
                $this->data['Product']['promotion_status'] = "0";
            }
            if(isset($this->params['form']['date']))
            {
                $this->data['Product']['promotion_start'] = $this->params['form']['date'];
            }
            if(isset($this->params['form']['date2']))
            {
                $this->data['Product']['promotion_end'] = $this->params['form']['date2']." 23:59:59";
            }
             if(isset($this->params['form']['date3']))
            {
                $this->data['ProductService']['start_time'] = $this->params['form']['date3'];
            }
            if(isset($this->params['form']['date4']))
            {
                $this->data['ProductService']['end_time'] = $this->params['form']['date4'];
            }           

            $this->data['Product']['coupon_type_id'] = "0";
            $this->Product->save($this->data['Product']); //关联保存
            $id = $this->Product->id;
            $this->data['ProductService']['product_id']=$id;
            
            $this->ProductService->save($this->data['ProductService']); //服务商品信息保存
           
            //新增商品多语言
            if(is_array($this->data['ProductI18n']))
            foreach($this->data['ProductI18n']as $k => $v)
            {
                $v['product_id'] = $id;
                $this->ProductI18n->id = '';
                $this->ProductI18n->save($v);
            }
            //新增商品分类关联
            $this->data['ProductsCategory']['product_id'] = $id;
            $this->ProductsCategory->save($this->data['ProductsCategory']);
            //扩展分类
            if(isset($this->params['form']['other_cat']) && is_array($this->params['form']['other_cat']))
            {
                $this->ProductsCategory->handle_other_cat($id,array_unique($this->params['form']['other_cat']));
            }
            $id = $this->Product->getLastInsertId();
            $product_info_img = $this->Product->findById($id);
            $product_code = $product_info_img['Product']['code'];
            $product_name = $product_info_img['ProductI18n']['name'];
            $crdir = "../img/products/".$product_code;
            if(!is_dir($crdir))
            {
                mkdir($crdir,0777);
                @chmod($crdir,0777);
            }
            $crdir = "../img/products/".$product_code."/detail/";
            if(!is_dir($crdir))
            {
                mkdir($crdir,0777);
                @chmod($crdir,0777);
            }
            $crdir = "../img/products/".$product_code."/original/";
            if(!is_dir($crdir))
            {
                mkdir($crdir,0777);
                @chmod($crdir,0777);
            }
            //rename($file, $newfile));
            //商品图
            $id=$this->Product->getLastInsertId();
            $product_info_img=$this->Product->findById($id);
            $product_code=$product_info_img['Product']['code'];
            $product_name=$product_info_img['ProductI18n']['name'];
            $crdir="../img/products/".$product_code;
            if(!is_dir("../img/products/"))
            {
                mkdir("../img/products/",0777);
                @chmod("../img/products/",0777);
            }
            if(!is_dir($crdir))
            {
                mkdir($crdir,0777);
                @chmod($crdir,0777);
            }
            $crdir="../img/products/".$product_code."/detail/";
            if(!is_dir($crdir))
            {
                mkdir($crdir,0777);
                @chmod($crdir,0777);
            }
            $crdir="../img/products/".$product_code."/original/";
            if(!is_dir($crdir))
            {
                mkdir($crdir,0777);
                @chmod($crdir,0777);
            }
            $img_url=$_REQUEST['img_url'];
            $img_sort=$_REQUEST['img_sort'];
            $img_desc=$_REQUEST['img_desc'];
            $image_path = $_REQUEST["image_path"];
		foreach($image_path as $pk=>$pv){
			if($pv == "system_path"){
                if($img_url[$pk] != "")
                {
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
                    $product_gallery=array(
                    	'img_original' => $img_original,
                    	'img_thumb' => $img_thumb,
                    	'img_detail' => $img_detail,
                    	'orderby' => !empty($img_sort[$k]) ? $img_sort[$k]: 50,
                    	'product_id' => $id
                    );
                    $this->ProductGallery->saveAll(array('ProductGallery' => $product_gallery));
                    $product=array(
                    	'img_original' => $img_original,
                    	'img_thumb' => $img_thumb,
                    	'img_detail' => $img_detail,
                    	'id' => $id
                    );
                    foreach($this->languages as $lk => $lv)
                    {
                        $product_gallery_i18n=array(
                        	'product_gallery_id' => $this->ProductGallery->id,
                        	'locale' => $lv['Language']['locale'],
                        	'description' => $this->params['form']['img_desc'][$lv['Language']['locale']][$k],
                        );
                        $this->ProductGalleryI18n->saveAll(array('ProductGalleryI18n' => $product_gallery_i18n));
                    }
                    $this->Product->saveAll(array('Product' => $product));
                }
            }
			if($pv == "definition_path"){
							$img_original = $_REQUEST["img_original"];
                    		$img_thumb = $_REQUEST["img_thumb"];
                    		$img_detail = $_REQUEST["img_detail"];
                    		$product_gallery=array(
		                    	'img_original' => $img_original[$pk],
		                      	'img_thumb' => $img_thumb[$pk],
		                      	'img_detail' => $img_detail[$pk],
		                     	'orderby' => !empty($this->params['form']['img_sort'][$pk]) ? $this->params['form']['img_sort'][$pk]: 50,
		                      	'product_id' => $id
		                    );
		                    $this->ProductGallery->saveall(array('ProductGallery' => $product_gallery));
		                    foreach($this->languages as $lk => $lv)
		                   	{
		                     	$product_gallery_i18n=array(
		                         	'product_gallery_id' => $this->ProductGallery->id,
		                          	'locale' => $lv['Language']['locale'],
		                       		'description' => $this->params['form']['img_desc'][$lv['Language']['locale']][$pk],
		                       	);
		                   		//pr($product_gallery_i18n);
		                    	$this->ProductGalleryI18n->saveAll(array('ProductGalleryI18n' => $product_gallery_i18n));
		                 	}
		                  	$product=array(
		                  		'img_original' => $img_original[$pk],
		                  		'img_thumb' => $img_thumb[$pk],
		                  		'img_detail' => $img_detail[$pk],
		                  		'id' => $id
		                  	);
		                 	$this->Product->saveAll(array('Product' => $product));
                    	       	
					
		    }        
    }
            //会员等级价格
            if(isset($this->params['form']['user_rank']) && is_array($this->params['form']['user_rank']))
            {
                foreach($this->params['form']['user_rank']as $k => $v)
                {
                    $user_rank = array('id' => $v,'discount' => $this->params['form']['user_price_discount'][$k]);
                    $this->UserRank->saveall(array('UserRank' => $user_rank));
                }
                foreach($this->params['form']['user_rank']as $k => $v)
                {
                    $is_d_rank = !empty($this->params['form']['is_default_rank'][$k]) ? $this->params['form']['is_default_rank'][$k]: "0";
                    $ProductRank = array('product_id' => $id,'rank_id' => $v,'id' => $this->params['form']['productrank_id'][$k],'product_price' => $this->params['form']['rank_product_price'][$k],'is_default_rank' => !empty($this->params['form']['is_default_rank'][$k]) ? $this->params['form']['is_default_rank'][$k]: "0"
                    );
                    $this->ProductRank->saveAll(array('ProductRank' => $ProductRank));
                }
            }
            //语言价格
            if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1)
            {
            	foreach($this->params['form']['locale_product_price']as $k => $v)
            	{
                	$v["status"]=isset($v["status"]) ? $v["status"]: "0";
                  	$v["product_price"]=!empty($v["product_price"]) ? $v["product_price"]: "0";
                 	$ProductLocalePrice=array(
                 		"product_id" => $id,
                 		"locale" => $k,
                 		"status" => $v["status"],
                 		"product_price" => $v["product_price"]
                 	);
                 	$this->ProductLocalePrice->saveAll(array("ProductLocalePrice" => $ProductLocalePrice));
             	}
          	}  
          	//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加服务商品:'.$product_name ,'operation');
    	    }            
          	$this->flash("服务商品 ".$product_code." ".$product_name." 添加成功。点击编辑该商品。",'/product_services/'.$id,10);
            //$this->flash("添加成功",'/products/','');
        }
        //分类下拉列表
        $categories_tree = $this->Category->tree('P',$this->locale);
        //品牌下拉列表
        $new_brands_tree = array();
        $brands_tree = $this->Brand->getbrandformat();
        foreach($brands_tree as $k => $v)
        {
            if($v['BrandI18n']['locale'] == $this->locale)
            {
                $new_brands_tree[] = $v;
            }
        }
        //会员等级
        $user_rank_list = $this->UserRank->findrank();
        $this->set('categories_tree',$categories_tree);
        $this->set('brands_tree',$new_brands_tree);
        //供应商
        $provider_list = $this->Provider->get_provider_list();
        $this->set('user_rank_list',$user_rank_list);
        $this->set('provider_list',$provider_list);
        $this->set('market_price_rate',$this->configs['market_price_rate']);
    }	
    function generate_product_code($product_id)
    {
        $products_code_prefix = isset($this->configs['products_code_prefix']) ? $this->configs['products_code_prefix']: 'sv';
        $product_code = $products_code_prefix.str_repeat('0',6-strlen($product_id)).$product_id;
        //   echo $product_code;
        $condition = " Product.code like '%$product_code%' and Product.id != '$product_id'";
        $products_list = $this->Product->findAll($condition);
        $code_list = array();
        foreach($products_list as $k => $v)
        {
            if(isset($v['Product']['code']))
            {
                $code_list[$k] = $v['Product']['code'];
            }
        }
        if(in_array($product_code,$code_list))
        {
            $max = pow(10,strlen($code_list[0]) - strlen($product_code) + 1) - 1;
            $new_sn = $product_code.mt_rand(0,$max);
            while(in_array($new_sn,$code_list))
            {
                $new_sn = $product_code.mt_rand(0,$max);
            }
            $product_code = $new_sn;
        }
        //   pr($products_list);
        return $product_code;
    }
    
    function view($id)
    {
    	$this->operator_privilege('service_product_edit');
        $this->pageTitle="编辑服务商品-服务管理"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '服务管理','url' => '/product_downloads/');
        $this->navigations[]=array('name' => '编辑服务商品','url' => '');
        $this->set('navigations',$this->navigations);
        $this->UserRank->set_locale($this->locale);
       
        $product_info=$this->Product->findById($id);
        $product_code=$product_info['Product']['code'];
        $product_name=$product_info['ProductI18n']['name'];
        $downloads_info=$this->ProductService->findByProductId($id);
        if($this->RequestHandler->isPost())
        {
            $this->data['Product']['recommand_flag']=isset($this->data['Product']['recommand_flag']) ? $this->data['Product']['recommand_flag']: "0";
            $this->data['Product']['forsale']=isset($this->data['Product']['forsale']) ? $this->data['Product']['forsale']: "0";
            $this->data['Product']['alone']=isset($this->data['Product']['alone']) ? $this->data['Product']['alone']: "0";
            $this->data['Product']['weight']=!empty($this->data['Product']['weight']) ? $this->data['Product']['weight']: "0";
            $this->data['Product']['shop_price']=!empty($this->data['Product']['shop_price']) ? $this->data['Product']['shop_price']: "0";
            $this->data['Product']['market_price']=!empty($this->data['Product']['market_price']) ? $this->data['Product']['market_price']: "0";
            $this->data['Product']['point']=!empty($this->data['Product']['point']) ? $this->data['Product']['point']: "0";
            $this->data['Product']['product_name_style']=@$this->params['form']['product_style_color'].'+'.@$this->params['form']['product_style_word'];
            $this->data['Product']['product_rank_id']=!empty($this->data['Product']['product_rank_id']) ? $this->data['Product']['product_rank_id']: "0";
            $this->data['Product']['extension_code'] = "services_product";
            $this->data['Product']['is_real'] = 0;
            $this->data['ProductService']['status']=!empty($this->params['form']['ProductService']['status']) ? $this->params['form']['ProductService']['status']: "0";
      		$this->data['ProductService']['url']=!empty($this->params['form']['ProductService']['url']) ? $this->params['form']['ProductService']['url']: "";
      		$this->data['ProductService']['service_cycle']=!empty($this->params['form']['ProductService']['service_cycle']) ? $this->params['form']['ProductService']['service_cycle']: "0";
      		$this->data['ProductService']['id']=!empty($this->params['form']['ProductService']['id']) ? $this->params['form']['ProductService']['id']: "0";
      		$this->data['ProductService']['product_id']=!empty($this->params['form']['ProductService']['product_id']) ? $this->params['form']['ProductService']['product_id']: "0";
            $this->data['ProductService']['view_count']=$downloads_info['ProductService']['view_count'];
            //基本信息
            if(isset($this->params['form']['action_type']) && $this->params['form']['action_type'] == 'product_base_info')
            {
                foreach($this->data['ProductI18n']as $v)
                {
                    $producti18n_info=array('id' => isset($v['id']) ? $v['id']: '','locale' => $v['locale'],'product_id' => isset($v['product_id']) ? $v['product_id']: $id,'name' => isset($v['name']) ? $v['name']: '','meta_keywords' => $v['meta_keywords'],'meta_description' => $v['meta_description'],'description' => $v['description']);
                    if($v['locale'] == $this->locale)
                    {
                        $product_name=$v['name'];
                    }
                    $this->ProductI18n->saveall(array('ProductI18n' => $producti18n_info));
                }
                if(!isset($this->data['Product']['promotion_status']))
                {
                    $this->data['Product']['promotion_status']='0';
                }
                if(isset($this->params['form']['date']))
                {
                    $this->data['Product']['promotion_start']=$this->params['form']['date'];
                }
                if(isset($this->params['form']['date2']))
                {
                    $this->data['Product']['promotion_end']=$this->params['form']['date2']." 23:59:59";
                }
 		         if(isset($this->params['form']['date3']) )
		        {
		        	$this->data['ProductService']['start_time']=$this->params['form']['date3'];
		            
		        }
		        if(isset($this->params['form']['date4']))
		        {
		        	$this->data['ProductService']['end_time']=$this->params['form']['date4'];
		          
		        }                
                
                if(empty($this->data['Product']['code']))
                {
                    $max_product=$this->Product->find("","","Product.id DESC");
                    $max_id=$max_product['Product']['id'] + 1;
                    $this->data['Product']['code']=$this->generate_product_code($max_id);
                }
                $this->data['Product']['product_name_style']=$this->params['form']['product_style_color'].'+'.$this->params['form']['product_style_word'];
                if(empty($this->data['Product']['quantity']) && $this->data['Product']['quantity'] != 0)
                {
                    $this->data['Product']['quantity']=$this->configs['default_stock'];
                }
               
                $this->Product->save($this->data);
                $this->ProductService->save($this->data);
                $vcarr=array();
                if(isset($this->params['form']['other_cat']) && is_array($this->params['form']['other_cat']))
                {
                    foreach($this->params['form']['other_cat']as $kc => $vc)
                    {
                        if($vc != 0)
                        {
                            $vcarr[]=$vc;
                        }
                    }
                    $this->ProductsCategory->handle_other_cat($this->data['Product']['id'],array_unique($vcarr));
                }
                if(isset($this->params['form']['user_rank']) && is_array($this->params['form']['user_rank']))
                {
                    foreach($this->params['form']['user_rank']as $k => $v)
                    {
                        $user_rank=array('id' => $v,'discount' => $this->params['form']['user_price_discount'][$k]);
                        $this->UserRank->save(array('UserRank' => $user_rank));
                    }
                    $this->ProductRank->deleteAll(array('product_id' => $id));
                    foreach($this->params['form']['user_rank']as $k => $v)
                    {
                    	if(empty($this->params['form']['rank_product_price'][$k])){
                    		$this->params['form']['rank_product_price'][$k]="0";
                    	}
                        $ProductRank=array('product_id' => $id,'rank_id' => $v,'id' => $this->params['form']['productrank_id'][$k],'product_price' => $this->params['form']['rank_product_price'][$k],'is_default_rank' => !empty($this->params['form']['is_default_rank'][$k]) ? $this->params['form']['is_default_rank'][$k]: "0");
                        $this->ProductRank->saveAll(array('ProductRank' => $ProductRank));
                    }
                }
                //语言价格
                if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1)
                {
                    foreach($this->params['form']['locale_product_price']as $k => $v)
                    {
                        $v["status"]=isset($v["status"]) ? $v["status"]: "0";
                        $v["id"]=isset($v["id"]) ? $v["id"]: "";
                        $v["product_price"]=!empty($v["product_price"]) ? $v["product_price"]: "0";
	                 	$ProductLocalePrice=array(
	                 		"id" => $v["id"],
	                 		"product_id" => $id,
	                 		"locale" => $k,
	                 		"status" => $v["status"],
	                 		"product_price" => $v["product_price"]
	                 	);
                        $this->ProductLocalePrice->save(array("ProductLocalePrice" => $ProductLocalePrice));
                    }
                }
                //操作员日志
    	        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑服务商品:'.$product_name ,'operation');
    	        } 
                $this->flash("服务商品 ".$product_code." ".$product_name." 编辑成功。点击继续编辑该商品。",'/product_services/'.$id,10);
            }
            //编辑相册
            if(isset($this->params['form']['action_type']) && $this->params['form']['action_type'] == 'product_gallery')
            {
                $ProductGalleryI18ndescription=!empty($_REQUEST['ProductGalleryI18ndescription']) ? $_REQUEST['ProductGalleryI18ndescription']: array();
                foreach($ProductGalleryI18ndescription as $k => $v)
                {
                    foreach($v['ProductGalleryI18n']as $kk => $vv)
                    {
                        $product_gallery_id=$vv['product_gallery_id'];
                        $this->ProductGalleryI18n->deleteall(array('product_gallery_id' => $product_gallery_id));
                    }
                }
                foreach($ProductGalleryI18ndescription as $k => $v)
                {
                    foreach($v['ProductGalleryI18n']as $kk => $vv)
                    {
                        $product_gallery_id=$vv['product_gallery_id'];
                        $this->ProductGalleryI18n->saveall(array('ProductGalleryI18n' => $vv));
                    }
                }
                if(!empty($this->params['form']['img_url']))
                {	
                	$image_path = $_REQUEST["image_path"];
                    $pro_info=$this->Product->findbyid($this->params['form']['product_id']);
                    //pr($image_path);
                    foreach($image_path as $pk=>$pv){
                    	if($pv == "system_path"){
                    		
	                    	$imgurl=$this->params['form']['img_url'];
		                    
		                        if(!empty($imgurl["$pk"]))
		                        {
		                            $image_name=basename($imgurl["$pk"]);
		                            $dir_name=substr($imgurl["$pk"],0,strrpos($imgurl["$pk"],'/'));
		                            $img_thumb=$dir_name.'/'.$image_name;
		                            $img_detail=$dir_name.'/detail/'.$image_name;
		                            $img_original=$dir_name.'/original/'.$image_name;
		                            $product_gallery=array(
		                            	'img_original' => $img_original,
		                            	'img_thumb' => $img_thumb,
		                            	'img_detail' => $img_detail,
		                            	'orderby' => !empty($this->params['form']['img_sort'][$pk]) ? $this->params['form']['img_sort'][$pk]: 50,
		                            	'product_id' => $this->params['form']['product_id']
		                            );
		                            $this->ProductGallery->saveall(array('ProductGallery' => $product_gallery));
		                            foreach($this->languages as $lk => $lv)
		                            {
		                                $product_gallery_i18n=array(
		                                	'product_gallery_id' => $this->ProductGallery->id,
		                                	'locale' => $lv['Language']['locale'],
		                                	'description' => $this->params['form']['img_desc'][$lv['Language']['locale']][$pk],
		                                );
		                                //pr($product_gallery_i18n);
		                                $this->ProductGalleryI18n->saveAll(array('ProductGalleryI18n' => $product_gallery_i18n));
		                            }
		                            $product=array('img_original' => $img_original,'img_thumb' => $img_thumb,'img_detail' => $img_detail,'id' => $this->params['form']['product_id']);
		                            $this->Product->saveAll(array('Product' => $product));
		                        
		                    }
	                    }
	                    
                    	if($pv == "definition_path"){
                    		$img_original = $_REQUEST["img_original"];
                    		$img_thumb = $_REQUEST["img_thumb"];
                    		$img_detail = $_REQUEST["img_detail"];
                    		$product_gallery=array(
		                    	'img_original' => $img_original[$pk],
		                      	'img_thumb' => $img_thumb[$pk],
		                      	'img_detail' => $img_detail[$pk],
		                     	'orderby' => !empty($this->params['form']['img_sort'][$pk]) ? $this->params['form']['img_sort'][$pk]: 50,
		                      	'product_id' => $this->params['form']['product_id']
		                    );
		                    $this->ProductGallery->saveall(array('ProductGallery' => $product_gallery));
		                    foreach($this->languages as $lk => $lv)
		                   	{
		                     	$product_gallery_i18n=array(
		                         	'product_gallery_id' => $this->ProductGallery->id,
		                          	'locale' => $lv['Language']['locale'],
		                       		'description' => $this->params['form']['img_desc'][$lv['Language']['locale']][$pk],
		                       	);
		                   		//pr($product_gallery_i18n);
		                    	$this->ProductGalleryI18n->saveAll(array('ProductGalleryI18n' => $product_gallery_i18n));
		                 	}
		                  	$product=array(
		                  		'img_original' => $img_original[$pk],
		                  		'img_thumb' => $img_thumb[$pk],
		                  		'img_detail' => $img_detail[$pk],
		                  		'id' => $this->params['form']['product_id']
		                  	);
		                 	$this->Product->saveAll(array('Product' => $product));
                    	}
	                }
                    //}
                }
                //操作员日志
    	        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加服务商品:'.$product_name.' 的相册' ,'operation');
    	        } 
                $this->flash("服务商品 ".$product_code." ".$product_name." 编辑相册成功。点击继续编辑该商品。",'/product_downloads/'.$id,10);
            }
   

        }
        $categories_tree=$this->Category->tree('P',$this->locale);
        //品牌
        $this->Brand->set_locale($this->locale);
        $brands_tree=$this->Brand->getbrandformat();
        //分类
        $article_cat=$this->Category->getbrandformat();
        //商品
        $this->data=$this->Product->localeformat($id);
        if($this->data['Product']['weight'] >= 0)
        {
            $this->data['Product']['products_weight_by_unit']=($this->data['Product']['weight'] >= 1) ? $this->data['Product']['weight']: ($this->data['Product']['weight'] / 0.001);
        }
        $products_name_style=explode('+',empty($this->data['Product']['product_name_style']) ? '+' : $this->data['Product']['product_name_style']);
        $types_tree=$this->ProductType->gettypeformat($this->data['Product']['product_type_id']);
        $products_attr_html=$this->requestAction("/commons/build_attr_html/".$this->data['Product']['product_type_id']."/".$id."");
        $weight_unit=$this->RequestHandler->isPost() ? '1' : ($this->data['Product']['weight'] >= 1 ? '1' : '0.001');
        $product_gallery=$this->ProductGallery->findAll(" ProductGallery.product_id = '".$id."'");
        foreach($product_gallery as $k => $v)
        {
            foreach($v['ProductGalleryI18n']as $kk => $vv)
            {
                $product_gallery[$k]['ProductGalleryI18n'][$vv['locale']]=$vv;
            }
            $this->data['ProductGallery'][$k]=$product_gallery[$k]['ProductGallery'];
            $this->data['ProductGallery'][$k]['ProductGalleryI18n']=$product_gallery[$k]['ProductGalleryI18n'];
        }
        $other_cat=$this->ProductsCategory->findAll(" ProductsCategory.product_id = '".$id."'");
        foreach($other_cat as $k => $v)
        {
            $this->data['other_cat'][$k]=$v;
        }
        $this->Product->set_locale($this->locale);
        $product_relations=$this->requestAction("/commons/get_linked_products/".$id."");
        $product_articles=$this->requestAction("/commons/get_products_articles/".$id."");
        $user_rank_list=$this->UserRank->findrank();
        foreach($user_rank_list as $k => $v)
        {
            $rank_id=$v['UserRank']['id'];
            $product_id=$id;
            $productrank=$this->ProductRank->find(array('product_id' => $product_id,'rank_id' => $rank_id));
            if($productrank['ProductRank']['is_default_rank'] == 1)
            {
                $user_rank_list[$k]['UserRank']['product_price']=($user_rank_list[$k]['UserRank']['discount'] / 100) * ($this->data['Product']['shop_price']);
                $user_rank_list[$k]['UserRank']['is_default_rank']=$productrank['ProductRank']['is_default_rank'];
                $user_rank_list[$k]['UserRank']['productrank_id']=$productrank['ProductRank']['id'];
            }
            else
            {
                $user_rank_list[$k]['UserRank']['product_price']=$productrank['ProductRank']['product_price'];
                $user_rank_list[$k]['UserRank']['is_default_rank']=$productrank['ProductRank']['is_default_rank'];
                $user_rank_list[$k]['UserRank']['productrank_id']=$productrank['ProductRank']['id'];
            }
        }
        //取供应商
        $provider_list=$this->Provider->get_provider_list();


        //语言价格
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1)
        {
            $productlocaleprice_info=$this->ProductLocalePrice->find("all",array("conditions" => array("product_id" => $id)));
            foreach($productlocaleprice_info as $k => $v)
            {
                $productlocaleprice_info[$v["ProductLocalePrice"]["locale"]]=$v;
            }
            //pr($productlocaleprice_info);
            $this->set('productlocaleprice_info',$productlocaleprice_info);
        }
        
        
        $this->set('provider_list',$provider_list); //供应商
        $this->set('categories_tree',$categories_tree);
        $this->set('brands_tree',$brands_tree);
        $this->set('weight_unit',$weight_unit);
        $this->set('types_tree',$types_tree);
        $this->set('product_gallery',$product_gallery);
        $this->set('product_relations',$product_relations);
        $this->set('article_cat',$article_cat);
        $this->set('product_articles',$product_articles);
        $this->set('products_attr_html',$products_attr_html);
        $this->set('user_rank_list',$user_rank_list);
        $this->set('products_name_color',$products_name_style[0]);
        $this->set('products_name_style',$products_name_style[1]);
        $this->set('market_price_rate',$this->configs['market_price_rate']);
        $this->set('downloads_info',$downloads_info);  
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$this->data["ProductI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

    }
    function trash($id)
    {
    	$this->operator_privilege('service_product_edit');
       $this->Product->updateAll(array('Product.status' => '2'),array('Product.id' => $id));
       $product_info = $this->Product->findById($id);
       //操作员日志
       if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
       $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'回收商品:'.$product_info['ProductI18n']['name'] ,'operation');
       }
       $this->flash("该商品已经进入回收站",'/product_downloads/',10);
    } 
    
    function copy_pro($original_pro_id)
    {
    	$this->operator_privilege('service_product_edit');
	   $this->Product->hasOne=array();
        $this->Product->hasOne=array('ProductI18n' => array('className' => 'ProductI18n','order' => '','dependent' => true,'foreignKey' => 'product_id'),
        'ProductService' => array('className' => 'ProductService','order' => '','dependent' => true,'foreignKey' => 'product_id'),
        );
        $original_pro=$this->Product->findall(array("Product.id" => $original_pro_id));
        
        foreach($original_pro as $k => $v)
        {
            $max_product=$this->Product->find("","","Product.id DESC");
            $max_id=$max_product['Product']['id'] + 1;
            $v['Product']['code']=$this->generate_product_code($max_id);
            $v['Product']['id']=$max_id;
            $v['Product']['promotion_price']="0";
            $v['Product']['promotion_status']="0";
            $v['Product']['recommand_flag']="0";
            $v['Product']['forsale']="0";
            $v['Product']['quantity']="9999";
            $v['ProductI18n']['id']="";
            $v['ProductI18n']['product_id']=$max_id;
            $products['Product']=$v['Product'];
            $products['ProductI18n'][]=$v['ProductI18n'];
            $max_productservices=$this->ProductService->find("","","ProductService.id DESC");
            $max_downid=$max_productservices['ProductService']['id'] + 1;
            $v['ProductService']['id']=$max_downid;
            $v['ProductService']['product_id']=$max_id;
            $v['ProductService']['created']=date("Y-m-d H:i:s");
            $v['ProductService']['modified']="";
            $productservices=$v['ProductService'];
        }
        
       $this->Product->save(array('Product' => $products['Product']));
       $this->ProductService->save(array('ProductService' => $productservices));
        foreach($products['ProductI18n']as $ka => $va)
        {
            $this->ProductI18n->save(array('ProductI18n' => $va));
        }
        $original_img=$this->ProductGallery->findall(array('ProductGallery.product_id' => $original_pro_id));
        foreach($original_img as $k => $v)
        {
            $original_img[$k]['ProductGallery']['product_id']=$max_id;
            $original_img[$k]['ProductGallery']['id']="";
        }
        $this->ProductGallery->saveall($original_img);
        $prod_info = $this->Product->findById($original_pro_id);
        //操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'复制商品:'.$prod_info['ProductI18n']['name'] ,'operation');
        }
        $this->flash("复制商品成功",'/product_services/','');
    }   
    function batch()
    {
    	$this->operator_privilege('service_product_edit');
        $pro_ids=!empty($this->params['url']['checkboxes']) ? $this->params['url']['checkboxes']: 0;
        if($this->params['url']['act_type'] == 'del')
        {
           $this->Product->updateAll(array('Product.status' => '2'),array('Product.id' => $pro_ids));
           //操作员日志
           if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
           $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'批量回收商品','operation');
           }
           $this->flash("商品已经进入回收站",'/product_services/','');
        }     
    }   
    function upfile()
    {

    }    
    
       	
}
?>