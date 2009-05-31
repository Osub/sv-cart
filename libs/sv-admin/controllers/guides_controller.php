<?php
class GuidesController extends AppController {

	var $name = 'Guides';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers = array('Pagination','Html', 'Form'); // Added    
	var $uses = array("PaymentI18n","Payment","ShippingAreaRegion","ShippingArea","ShippingAreaI18n","Brand","BrandI18n","ProductsCategory","Product","ProductI18n","Config","ConfigI18n","Shipping","Payment","Region",'Category',"CategoryI18n","Payment","PaymentI18n","RegionI18n");
	
	
	function index(){
		$this->pageTitle = "商店设置向导"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商店设置向导','url'=>'/configvalue_guides/');
		$this->set('navigations',$this->navigations);
		

		//商店设置
		$this->Config->hasOne = array();
		$this->Config->hasMany = array('ConfigI18n' =>   
                        array('className'    => 'ConfigI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'config_id'  
                        )
				 );
		//$this->Config->set_locale($_SESSION['Admin_Locale']);
		$config_info = $this->Config->findAll(array("group_code"=>"shop_setting"));
		$config_arr = array();
		foreach( $config_info as $k=>$v ){
			$config_arr[$v['Config']['code']] = $v;
			
		}
		
		//配送方式
		$this->Shipping->set_locale($this->locale);
		$shipping_info = $this->Shipping->shipping_list();
		$region_country = $this->Region->getarealist(0,$this->locale);//取国家
		
		//支付方式
		
		$this->Payment->set_locale($this->locale);
		$payment_info = $this->Payment->payment_list();
		
		$this->set("config_info",$config_arr);
		$this->set("shipping_info",$shipping_info);
		$this->set("region_country",$region_country);
		$this->set("payment_info",$payment_info);
		$this->Config->hasMany = array();
		$this->Config->hasOne = array('ConfigI18n' =>   
                        array('className'    => 'ConfigI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'config_id'  
                        )
				 );
	}
	
	
	function two(){
		$this->pageTitle = "商店设置向导"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商店设置向导','url'=>'/configvalue_guides/');
		$this->set('navigations',$this->navigations);	
	
		//商店设置基本设置
			//	pr($this->data);

		if($this->RequestHandler->isPost()){
			foreach($this->data['ConfigI18n'] as $k=>$v){
				foreach( $v as $kk=>$vv ){
					$this->ConfigI18n->updateAll(
					         	array('value' => "'$vv[value]'"),
								array('id' => $vv['id'])
					         	
				         );
				}
			}
		}
		
		//配送方式
		//$this->Shipping->set_locale($this->locale);
		$this->Shipping->hasOne = array();
        $this->Shipping->hasMany = array('ShippingI18n'     =>array
												( 
												  'className'    => 'ShippingI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'shipping_id'
					                        	 ) 
                 	   );
		$shipping_info = $this->Shipping->findall();
		foreach($shipping_info as $k=>$v){
			$shipping_info[$k]['Shipping']['name'] = "";
			foreach( $v['ShippingI18n'] as $kk=>$vv ){
				if($vv['locale']==$this->locale){
					$shipping_info[$k]['Shipping']['name']=$vv['name'];
				}
			}
			
		}
		//pr($shipping_info);
		$region_country = $this->Region->getarealist(0,$this->locale);//取国家
		
		//支付方式
		$this->Payment->hasOne = array();
        $this->Payment->hasMany = array('PaymentI18n'=>
						array('className'  => 'PaymentI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'payment_id'	
						)
					);
		$payment_info = $this->Payment->findall();
		foreach($payment_info as $k=>$v){
			$payment_info[$k]['Payment']['name'] = "";
			foreach( $v['PaymentI18n'] as $kk=>$vv ){
				$payment_info[$k]['PaymentI18n'][$vv['locale']] = $vv;
				if($vv["locale"]==$this->locale){
					$payment_info[$k]['Payment']['name'] =$vv['name'];
				}
			}
		}
		
		$this->set("shipping_info",$shipping_info);
		$this->set("region_country",$region_country);
		$this->set("payment_info",$payment_info);
	
	}
	
	function three(){
		$this->pageTitle = "商店设置向导"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商店设置向导','url'=>'/configvalue_guides/');
		$this->set('navigations',$this->navigations);
		//新增配送方式
		
		if($this->RequestHandler->isPost()){
		$shippingarea_info['ShippingArea']['shipping_id'] =  $this->data['ShippingArea']['ShippingArea']['shipping_id'];
		//pr($this->data);
		if(!empty($shippingarea_info['ShippingArea']['shipping_id'])){
			
			$money = serialize( $_REQUEST['money'] );
			$shippingarea_info['ShippingArea']['free_subtotal'] = $this->data['ShippingArea']['ShippingArea']['free_subtotal'];
			$shippingarea_info['ShippingArea']['fee_configures'] = !empty($money)?$money:0;
			$this->ShippingArea->save(array("ShippingArea"=>$shippingarea_info['ShippingArea']));
			$arr = $shippingarea_info;
			$arrI18n['ShippingAreaI18n']['shipping_area_id'] = $this->ShippingArea->getLastInsertId();

			foreach($this->data['ShippingArea']['ShippingAreaI18n'] as $k=>$v){
				$arrI18n['ShippingAreaI18n']['locale'] = $v['locale'];
				$arrI18n['ShippingAreaI18n']['name'] = $v['name'];
				$this->ShippingAreaI18n->saveall($arrI18n);
			}
			if(@$this->data['Address']['Region'][0]!=""&&@$this->data['Address']['Region'][0]!="请选择"){
				$shippingarearegion_info['ShippingArea']['region_id'] = $this->data['Address']['Region'][0];
			}
			if(@$this->data['Address']['Region'][1]!=""&&@$this->data['Address']['Region'][1]!="请选择"){
				$shippingarearegion_info['ShippingArea']['region_id'] = $this->data['Address']['Region'][1];
			}
			if(@$this->data['Address']['Region'][2]!=""&&@$this->data['Address']['Region'][2]!="请选择"){
				$shippingarearegion_info['ShippingArea']['region_id'] = $this->data['Address']['Region'][2];
			}
			if(@$this->data['Address']['Region'][3]!=""&&@$this->data['Address']['Region'][3]!="请选择"){
				$shippingarearegion_info['ShippingArea']['region_id'] = $this->data['Address']['Region'][3];
			}
			$shippingarearegion_info['ShippingArea']['shipping_area_id'] = $this->ShippingArea->getLastInsertId();
			
			$regioni18n_arr = $this->RegionI18n->find(array('name'=>$shippingarearegion_info['ShippingArea']['region_id']));
			//pr($shippingarearegion_info['ShippingArea']);
			//$shippingarearegion_info['ShippingArea']['region_id'] = $regioni18n_arr['RegionI18n']['region_id'];
			$this->ShippingAreaRegion->save(array("ShippingAreaRegion"=>$shippingarearegion_info['ShippingArea']));
		
		}
		//pr( $this->data['PaymentI18n'] );
		foreach( $this->data['PaymentI18n'] as $k=>$v ){
			foreach($v as $kk=>$vv){
				$this->PaymentI18n->updateAll(
						         	array('PaymentI18n.description' =>"'".$vv['description']."'"),
									array('PaymentI18n.id' =>$kk)
						         	
					         );
			}
		}
		
		
		if(!empty($_REQUEST['payment_arrs']['payment_arr']['id'])){
			$arrs = "";

			foreach($_REQUEST['payment_arr'] as $k=>$v){
				if($v['id'] == $_REQUEST['payment_arrs']['payment_arr']['id']){
					$arrs['payment_arr'][$k] =  $v;
				}
			}
			
			$configs = "";
			if(isset($arrs['payment_arr']) && count($arrs['payment_arr'])>0){
				$configs = "\$payment_arr = array(";
				$i = 0;
				foreach($arrs['payment_arr'] as $kk=>$vv){
					$i++;
					$configs .= "'".$kk."'=> array('name'=> '".$vv['name']."','value'=>'".$vv['value']."')" ;
					if($i < count($arrs['payment_arr'])){
						$configs .= ",";
					}
				}
	            $configs .= ");";
			}
			$Payment_info = $this->Payment->findById($_REQUEST['payment_arrs']['payment_arr']['id']);
			$Payment_info["Payment"]["config"] = $configs;
		
			$this->Payment->save(array("Payment"=>$Payment_info["Payment"]));
		   $this->Payment->updateAll(
					         	array('Payment.status' =>"1"),
								array('Payment.id' => $_REQUEST['payment_arrs']['payment_arr']['id'])
					         	
				         );
		}

		}
		
		
		
	}
	function four(){
		$this->pageTitle = "商店设置向导"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商店设置向导','url'=>'/configvalue_guides/');
		$this->set('navigations',$this->navigations);

		
		
		if($this->RequestHandler->isPost()){
			//加分类
			
			$categorie_info['Categorie']['parent_id']= 0;
			$categorie_info['Categorie']['parent_id']= 0;
			
			$this->Category->save(array("Category"=>$categorie_info['Categorie']));
			foreach($this->data['Categorie']['CategorieI18n'] as $k=>$v){
				$categorie_info['CategorieI18n']['name'] = $v['name'];
				$categorie_info['CategorieI18n']['meta_keywords'] = $v['meta_keywords'];
				$categorie_info['CategorieI18n']['meta_description'] = $v['meta_description'];
				$categorie_info['Categorie']['type']= "P";
				$categorie_info['CategorieI18n']['locale'] = $v['locale'];
				$categorie_info['CategorieI18n']['category_id'] = $this->Category->getLastInsertId();
				$this->CategoryI18n->saveall(array("CategoryI18n"=>$categorie_info['CategorieI18n']));
			}
		}
		$categories_tree=$this->Category->tree('P',$this->locale);
		if(@$_REQUEST['to_continue'] == 'yes'){
			$this->redirect("/guides/three");
		}
   	    $this->set('categories_tree',$categories_tree);
	}
	function guides_end(){
		$this->pageTitle = "商店设置向导"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商店设置向导','url'=>'/configvalue_guides/');
		$this->set('navigations',$this->navigations);
			//加品牌
		$brand_info = "";//$this->data['Brand'];
		if(!empty($brand_info)){
			$brand_info['Brand']['status'] = "1";
			//pr($brand_info);
			$this->Brand->save(array("Brand"=>$brand_info['Brand']));
			$brand_info['BrandI18n']['brand_id'] = $this->Brand->getLastInsertId();
			$brand_info['BrandI18n']['locale'] = $this->locale;
			$this->BrandI18n->save(array("BrandI18n"=>$brand_info['BrandI18n']));
			$brand_id=$this->Brand->getLastInsertId();
		}else{
			$brand_id = 0;
		}
		
		//加商品
		$product_info = $this->data['Product'];
		$product_info['Product']['shop_price']=!empty($product_info['Product']['shop_price'])?$product_info['Product']['shop_price']:0;
		
		$max_product=$this->Product->find("","","Product.id DESC");
	    $max_id=$max_product['Product']['id']+1;
	    $product_info['Product']['id'] = $max_id;
	    
		$product_info['Product']['code'] = $this->generate_product_code($max_id);
		//if(empty($product_info['Product']['quantity'])){
			$product_info['Product']['quantity']=$this->configs['default_stock'];
		//}
		$product_info['Product']['category_id'] = $_REQUEST['category_id'];
		$product_info['Product']['admin_id'] = $_SESSION['Operator_Info']['Operator']['id'];
		$product_info['Product']['brand_id'] = "0";//$brand_id;
		$product_info['Product']['img_thumb'] = !empty($product_info['Product']['img_thumb'])?$product_info['Product']['img_thumb']:"";
		$product_info['Product']['img_detail'] = !empty($product_info['Product']['img_detail'])?$product_info['Product']['img_detail']:"";
		$product_info['Product']['img_original'] = !empty($product_info['Product']['img_original'])?$product_info['Product']['img_original']:"";
		
		$product_info['Product']['shop_price'] = $product_info['Product']['shop_price'];
		$product_info['Product']['market_price'] = $product_info['Product']['shop_price']*$this->configs['market_price_rate'];
		$this->Product->saveall(array("Product"=>$product_info['Product']));
	//	pr($product_info);
		foreach($product_info['ProductI18n'] as $k=>$v){
			
		$product_info_new['ProductI18n']['product_id'] = $max_id;
		$product_info_new['ProductI18n']['locale'] = $v['locale'];
		$product_info_new['ProductI18n']['meta_description'] = $v['meta_description'];
		$product_info_new['ProductI18n']['name'] = $v['name'];
			$this->ProductI18n->saveall(array("ProductI18n"=>$product_info_new['ProductI18n']));
		}
				//商品分类关连
		//$productscategory_info['category_id'] = $_REQUEST['category_id'];
		//$productscategory_info['product_id'] = $product_info['Product']['id'];
		//$this->ProductsCategory->save(array("ProductsCategory"=>$productscategory_info));
		if(@$_REQUEST['to_continue'] == 'yes'){
			$this->redirect("/guides/four");
		}
		
		$this->flash("您的商店初始设置成功，进入管理员首页",'../../sv-admin/',10);
	
	}
	
	
	function edit(){
		//商店设置基本设置
		foreach($this->data['ConfigI18n'] as $k=>$v){
			$this->Config->updateAll(
				         	array('ConfigI18n.value' => "'$v[value]'"),
							array('ConfigI18n.id' => $v['id'])
				         	
			         );
		}
		

		
		//加品牌
		$brand_info = $this->data['Brand'];
		if(!empty($brand_info)){
			$brand_info['Brand']['status'] = "1";
			//pr($brand_info);
			$this->Brand->save(array("Brand"=>$brand_info['Brand']));
			$brand_info['BrandI18n']['brand_id'] = $this->Brand->getLastInsertId();
			$brand_info['BrandI18n']['locale'] = $this->locale;
			$this->BrandI18n->save(array("BrandI18n"=>$brand_info['BrandI18n']));
			$brand_id=$this->Brand->getLastInsertId();
		}else{
			$brand_id = 0;
		}
		//加商品
		$product_info = $this->data['Product'];
		$product_info['Product']['shop_price']=!empty($product_info['Product']['shop_price'])?$product_info['Product']['shop_price']:0;
		$max_product=$this->Product->find("","","Product.id DESC");
	    $max_id=$max_product['Product']['id']+1;
	    $product_info['Product']['id'] = $max_id;
	    $product_info['ProductI18n']['product_id'] = $max_id;
		$product_info['Product']['code'] = $this->generate_product_code($max_id);
		if(empty($product_info['Product']['quantity'])){
			$product_info['Product']['quantity']=$this->configs['default_stock'];
		}
		$product_info['Product']['admin_id'] = $_SESSION['Operator_Info']['Operator']['id'];
		$product_info['Product']['brand_id'] = $brand_id;
		$product_info['ProductI18n']['locale'] = $this->locale;
		$product_info['Product']['market_price'] = $product_info['Product']['shop_price'];
		$this->Product->save(array("Product"=>$product_info['Product']));
		$this->ProductI18n->save(array("ProductI18n"=>$product_info['ProductI18n']));
		
		//商品分类关连
		$productscategory_info['category_id'] = 0;//$categorie_info['CategorieI18n']['category_id'];
		$productscategory_info['product_id'] = $product_info['Product']['id'];
		$this->ProductsCategory->save(array("ProductsCategory"=>$productscategory_info));
		
		//新增配送方式
		$shippingarea_info['ShippingArea']['shipping_id'] =  $this->data['ShippingArea']['ShippingArea']['shipping_id'];
		if(!empty($shippingarea_info['ShippingArea']['shipping_id'])){
			$this->ShippingArea->save(array("ShippingArea"=>$shippingarea_info['ShippingArea']));
			$arr = $shippingarea_info;
			$arr['ShippingArea']['shipping_area_id'] = $this->ShippingArea->getLastInsertId();
			$arr['ShippingArea']['locale'] = $this->locale;
			$arr['ShippingArea']['name'] = $this->data['ShippingArea']['ShippingArea']['name'];
			$this->ShippingAreaI18n->save(array("ShippingAreaI18n"=>$arr['ShippingArea']));
			if(@$this->data['Address']['Region'][0]!=""){
				$shippingarearegion_info['ShippingArea']['region_id'] = $this->data['Address']['Region'][0];
			}
			if(@$this->data['Address']['Region'][1]!=""){
				$shippingarearegion_info['ShippingArea']['region_id'] = $this->data['Address']['Region'][1];
			}
			if(@$this->data['Address']['Region'][2]!=""){
				$shippingarearegion_info['ShippingArea']['region_id'] = $this->data['Address']['Region'][2];
			}
			if(@$this->data['Address']['Region'][3]!=""){
				$shippingarearegion_info['ShippingArea']['region_id'] = $this->data['Address']['Region'][3];
			}
			$shippingarearegion_info['ShippingArea']['shipping_area_id'] = $this->ShippingArea->getLastInsertId();
			$this->ShippingAreaRegion->save(array("ShippingAreaRegion"=>$shippingarearegion_info['ShippingArea']));
			//pr($shippingarearegion_info);
		}
		if(!empty($_REQUEST['payment_arrs']['payment_arr']['id'])){
			$arrs = "";
			foreach($_REQUEST['payment_arr'] as $k=>$v){
				if($v['id'] == $_REQUEST['payment_arrs']['payment_arr']['id']){
					$arrs['payment_arr'][$k] =  $v;
				}
			}
			
			
			if(isset($arrs['payment_arr']) && count($arrs['payment_arr'])>0){
				$configs = "\$payment_arr = array(";
				$i = 0;
				foreach($arrs['payment_arr'] as $kk=>$vv){
					$i++;
					$configs .= "'".$kk."'=> array('name'=> '".$vv['name']."','value'=>'".$vv['value']."')" ;
					if($i < count($arrs['payment_arr'])){
						$configs .= ",";
					}
				}
	            $configs .= ");";
			}
			$this->Payment->updateAll(
					         	array('Payment.config' =>@"\"$configs\""),
								array('Payment.id' => $_REQUEST['payment_arrs']['payment_arr']['id'])
					         	
				         );
		}
		$this->flash("设置成功",'../../sv-admin/',10);
	}
	
	
	function guides_category(){
		//加分类
		$categorie_info['CategorieI18n']['name'] = $_REQUEST['categorie_name'];
		$categorie_info['CategorieI18n']['meta_keywords'] = $_REQUEST['categorie_keywords'];
		$categorie_info['CategorieI18n']['meta_description'] = $_REQUEST['categorie_description'];
		
		
		$categorie_info['Categorie']['parent_id']= 0;
		$categorie_info['Categorie']['type']= "P";
		$categorie_info['CategorieI18n']['locale'] = $this->locale;
		$categorie_info['Categorie']['parent_id']= 0;
		$this->Category->save(array("Category"=>$categorie_info['Categorie']));
		$categorie_info['CategorieI18n']['category_id'] = $this->Category->getLastInsertId();
		$this->CategoryI18n->save(array("CategoryI18n"=>$categorie_info['CategorieI18n']));
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
