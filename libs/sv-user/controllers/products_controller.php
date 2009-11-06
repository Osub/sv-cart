<?php
/*****************************************************************************
 * SV-Cart 用户购买信息
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: products_controller.php 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
class ProductsController extends AppController {

	var $name = 'Products';
    var $components = array ('Pagination'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array("Order","OrderProduct","Product","Category","Brand","ProductsCategory");


	function index($rownum='',$showtype="",$orderby=""){
		$orderby = UrlDecode($orderby);
		$rownum = UrlDecode($rownum);
		$showtype = UrlDecode($showtype);
		//未登录转登录页
		if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
			 $this->redirect('/login/');
		}
		$this->page_init();
		
		//当前位置
		$this->navigations[] = array('name'=>__($this->languages['purchased'].$this->languages['information'],true),'url'=>"");
		$this->set('locations',$this->navigations);
		
		$user_id=$_SESSION['User']['User']['id'];
		if(empty($rownum)){
		 	$rownum=isset($this->configs['products_list_num']) ? $this->configs['products_list_num']:((!empty($rownum)) ?$rownum:20);
		}
		if(empty($showtype)){
		 	$showtype=isset($this->configs['products_list_showtype']) ? $this->configs['products_list_showtype']:((!empty($showtype)) ?$showtype:'L');
		}
			if(empty($orderby)){
		 		$orderby=isset($this->configs['products_category_page_orderby_type'])? $this->configs['products_category_page_orderby_type']." ". $this->configs['products_category_page_orderby_method'] :((!empty($orderby)) ?$orderby:'created '.$this->configs['products_category_page_orderby_method']);
			}
			
		if($rownum == "all"){
			$rownum_sql = 99999;
		}else{
			$rownum_sql = $rownum;
		}
			
			
			
	    //取得我的所有订单id
	    $condition=" user_id=".$user_id;
	    $my_orders=$this->Order->findAll($condition);
	    $orders_id=array();
	    foreach($my_orders as $k=>$v){
	   	    $orders_id[$k]=$v['Order']['id'];
	    }
	    if(empty($orders_id)){
	    	$orders_id[] = 0;
	    }
	    // pr($orders_id);
	    //取得我购买的商品
	    $condition=array("OrderProduct.order_id"=>$orders_id," ProductI18n.locale='".$this->locale."' ");
	    
	    $total = $this->OrderProduct->findCount($condition,0);
	    $sortClass='OrderProduct';
	    $page=1;
	    $parameters=Array($rownum_sql,$page);
	    $options=Array();
	    $page = $this->Pagination->init($condition,"",$options,$total,$rownum_sql,$sortClass);
	   // $my_orders_products=$this->OrderProduct->findAll($condition,'',"","$rownum",$page);
	   
	    $my_orders_products=$this->OrderProduct->find('all',array('conditions'=>array($condition),
																'fields' =>	array('OrderProduct.id','OrderProduct.order_id','OrderProduct.product_id','Product.img_thumb'
																				,'Product.market_price'
																				,'Product.shop_price'
																				,'Product.code','Product.id'
																				,'Product.brand_id','OrderProduct.created','OrderProduct.product_price'
																				,'ProductI18n.name'
																				),		  	  
	  	  'order'=>array("Product.$orderby"),'limit'=>$rownum_sql,'page'=>$page));
	    
	    	    
	    if(empty($my_orders_products)){
	   	    $my_orders_products=array();
	    }
	   // pr($my_orders_products);
	    //商品品牌分类
	   $res_c=$this->Category->findassoc($this->locale);
	   $res_b=$this->Brand->findassoc($this->locale);
	   
	   $products_ids_list = array();
	   $orders_ids_list = array();
	   $orders_ids_list[] = 0;
	   $products_ids_list[] = 0;	   
	   if(is_array($my_orders_products) && sizeof($my_orders_products)>0){
		    foreach($my_orders_products as $k=>$v){
		  	    $products_ids_list[] = $v['OrderProduct']['product_id'];
		    	$orders_ids_list[] = $v['OrderProduct']['order_id'];
		    }
		}
 	    $p_order_infos = $this->Order->find('all',array("conditions"=>array('Order.id'=>$orders_ids_list)));
		$order_lists = array();
		if(is_array($p_order_infos) && sizeof($p_order_infos) >0){
			foreach($p_order_infos as $k=>$v){
				$order_lists[$v['Order']['id']] = $v;
			}
		}
		
		
 	    $product_category_infos = $this->ProductsCategory->find('all',array("conditions"=>array('ProductsCategory.product_id'=>$products_ids_list)));
	    $product_category_lists = array();
	    
	    if(is_array($product_category_infos) && sizeof($product_category_infos)>0){
	  	  	  foreach($product_category_infos as $k=>$v){
	  			  $product_category_lists[$v['ProductsCategory']['product_id']] = $v;
	  		  }
	    }
	   
	   foreach($my_orders_products as $k=>$v){
	   	   	//$order_info = $this->Order->findbyid($v['OrderProduct']['order_id']);
	   	   	if(isset($order_lists[$v['OrderProduct']['order_id']])){
	   	   		$order_info = $order_lists[$v['OrderProduct']['order_id']];
	   	   	}
	   	   	
	   	   	$my_orders_products[$k]['OrderProduct']['order_code'] = isset($order_info['Order']['id'])?$order_info['Order']['id']:'';
	   	  	
	   	  	if(isset($product_category_lists[$v['Product']['id']])){
	   	  		$product_category = $product_category_lists[$v['Product']['id']];
	   	  	}
	   	  	
	   	  	//$product_category = $this->ProductsCategory->findbyproduct_id($v['Product']['id']);
	  	   if(isset($product_category) && isset($res_c[$product_category['ProductsCategory']['id']]['Category']['id'])){
	  	  //	  $my_orders_products[$k]['Category']=$res_c[$v['ProductsCategory']['id']]['Category'];
	  	  //	  $my_orders_products[$k]['CategoryI18n']=$res_c[$v['ProductsCategory']['id']]['CategoryI18n'];
	  	  	  $my_orders_products[$k]['Category']=$res_c[$res_c[$product_category['ProductsCategory']['id']]['Category']['id']]['Category'];
	  	  	  $my_orders_products[$k]['CategoryI18n']=$res_c[$res_c[$product_category['ProductsCategory']['id']]['Category']['id']]['CategoryI18n'];	  	  
	  	  }
	  	  if(isset($res_b[$v['Product']['brand_id']]['Brand']['id'])){
	  	  	  $my_orders_products[$k]['Brand']=$res_b[$v['Product']['brand_id']]['Brand'];
	  	  	  $my_orders_products[$k]['BrandI18n']=$res_b[$v['Product']['brand_id']]['BrandI18n'];
	  	  }
	  	  if($v['Product']['id'] == ''){
	  	  	unset($my_orders_products[$k]);
	  	  }
	   }
	  
	  $this->pageTitle = $this->languages['purchased'].$this->languages['information']." - ".$this->configs['shop_title'];
	  	  //一步购买
	  if(!empty($this->configs['enable_one_step_buy']) && $this->configs['enable_one_step_buy'] == 1){
					$js_languages = array("enable_one_step_buy" => "1","page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']);
					$this->set('js_languages',$js_languages);
		}else{
					$js_languages = array("enable_one_step_buy" => "0","page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']);
					$this->set('js_languages',$js_languages);
	  }
//	  pr($my_orders_products);
	  $this->set('my_orders_products',$my_orders_products);
	  $this->set('total',$total);
	  $this->set('user_id',$user_id);
	  //排序方式,显示方式,分页数量限制
	  $this->set('orderby',$orderby);
	  $this->set('rownum',$rownum);
	  $this->set('showtype',$showtype);
	}

}

?>