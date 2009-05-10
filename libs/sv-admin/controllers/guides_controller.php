<?php
class GuidesController extends AppController {

	var $name = 'Guides';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers = array('Pagination','Html', 'Form'); // Added    
	var $uses = array("Payment","ShippingAreaRegion","ShippingArea","ShippingAreaI18n","Brand","BrandI18n","ProductsCategory","Product","ProductI18n","Config","Shipping","Payment","Region",'Category',"CategoryI18n","Payment","PaymentI18n","RegionI18n");
	
	
	function index(){
		$this->pageTitle = "商店设置向导"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商店设置向导','url'=>'/configvalue_guides/');
		$this->set('navigations',$this->navigations);
		
		
		//商店设置
		$this->Config->set_locale($_SESSION['Admin_Locale']);
		$config_info = $this->Config->findAll(array("group"=>"shop_setting"));
		$config_arr = array();
		foreach( $config_info as $k=>$v ){
			$config_arr[$v['Config']['code']] = $v;
			
		}
		//pr($config_arr);
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
	}
	
	
	function two(){
		$this->pageTitle = "商店设置向导"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商店设置向导','url'=>'/configvalue_guides/');
		$this->set('navigations',$this->navigations);	
	
		//商店设置基本设置
		if($this->RequestHandler->isPost()){
			foreach($this->data['ConfigI18n'] as $k=>$v){
				$this->Config->updateAll(
					         	array('ConfigI18n.value' => "'$v[value]'"),
								array('ConfigI18n.id' => $v['id'])
					         	
				         );
			}
		}
		
		//配送方式
		$this->Shipping->set_locale($this->locale);
		$shipping_info = $this->Shipping->shipping_list();
		$region_country = $this->Region->getarealist(0,$this->locale);//取国家
		
		//支付方式
		$this->Payment->set_locale($this->locale);
		$payment_info = $this->Payment->payment_list();
		
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
		if(!empty($shippingarea_info['ShippingArea']['shipping_id'])){
			$this->ShippingArea->save(array("ShippingArea"=>$shippingarea_info['ShippingArea']));
			$arr = $shippingarea_info;
			$arr['ShippingArea']['shipping_area_id'] = $this->ShippingArea->getLastInsertId();
			$arr['ShippingArea']['locale'] = $this->locale;
			$arr['ShippingArea']['name'] = $this->data['ShippingArea']['ShippingArea']['name'];
			$this->ShippingAreaI18n->save(array("ShippingAreaI18n"=>$arr['ShippingArea']));
			
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
		   $this->Payment->updateAll(
					         	array('Payment.status' =>1),
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
			$categorie_info['CategorieI18n']['name'] = $this->data['Categorie']['CategorieI18n']['name'];
			$categorie_info['CategorieI18n']['meta_keywords'] = $this->data['Categorie']['CategorieI18n']['meta_keywords'];
			$categorie_info['CategorieI18n']['meta_description'] = $this->data['Categorie']['CategorieI18n']['meta_description'];
			
			
			$categorie_info['Categorie']['parent_id']= 0;
			$categorie_info['Categorie']['type']= "P";
			$categorie_info['CategorieI18n']['locale'] = $this->locale;
			$categorie_info['Categorie']['parent_id']= 0;
			$this->Category->save(array("Category"=>$categorie_info['Categorie']));
			$categorie_info['CategorieI18n']['category_id'] = $this->Category->getLastInsertId();
			$this->CategoryI18n->save(array("CategoryI18n"=>$categorie_info['CategorieI18n']));
		}
		$categories_tree=$this->Category->tree('P',$this->locale);
		
   	    $this->set('categories_tree',$categories_tree);
	}
	function guides_end(){
		$this->pageTitle = "商店设置向导"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商店设置向导','url'=>'/configvalue_guides/');
		$this->set('navigations',$this->navigations);
			//加品牌
		$brand_info = "";//$this->data['Brand'];
		if(!empty($brand_info)){
			$brand_info['Brand']['status'] = 1;
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
		//if(empty($product_info['Product']['quantity'])){
			$product_info['Product']['quantity']=$this->configs['default_stock'];
		//}
		$product_info['Product']['category_id'] = $_REQUEST['category_id'];
		$product_info['Product']['admin_id'] = $_SESSION['Operator_Info']['Operator']['id'];
		$product_info['Product']['brand_id'] = "0";//$brand_id;
		$product_info['ProductI18n']['locale'] = $this->locale;
		$product_info['Product']['shop_price'] = $product_info['Product']['shop_price'];
		$product_info['Product']['market_price'] = $product_info['Product']['shop_price']*$this->configs['market_price_rate'];
		$this->Product->save(array("Product"=>$product_info['Product']));
		$this->ProductI18n->save(array("ProductI18n"=>$product_info['ProductI18n']));
				//商品分类关连
		//$productscategory_info['category_id'] = $_REQUEST['category_id'];
		//$productscategory_info['product_id'] = $product_info['Product']['id'];
		//$this->ProductsCategory->save(array("ProductsCategory"=>$productscategory_info));
		$this->flash("设置成功",'../../sv-admin/',10);
	
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
			$brand_info['Brand']['status'] = 1;
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
