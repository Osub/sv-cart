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
 * $Id: products_controller.php 1841 2009-05-27 06:51:37Z huangbo $
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
		 	$rownum=isset($this->configs['products_list_num']) ? $this->configs['products_list_num']:((!empty($rownum)) ?$rownum:20);

		 	$showtype=isset($this->configs['products_list_showtype']) ? $this->configs['products_list_showtype']:((!empty($showtype)) ?$showtype:'L');

			if(empty($orderby)){
		 		$orderby=isset($this->configs['products_category_page_orderby_type'])? $this->configs['products_category_page_orderby_type']." ". $this->configs['products_category_page_orderby_method'] :((!empty($orderby)) ?$orderby:'created '.$this->configs['products_category_page_orderby_method']);
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
	    $parameters=Array($rownum,$page);
	    $options=Array();
	    $page = $this->Pagination->init($condition,"",$options,$total,$rownum,$sortClass);
	    $my_orders_products=$this->OrderProduct->findAll($condition,'',"","$rownum",$page);
	    if(empty($my_orders_products)){
	   	    $my_orders_products=array();
	    }
	   // pr($my_orders_products);
	    //商品品牌分类
	   $res_c=$this->Category->findassoc();
	   $res_b=$this->Brand->findassoc();
	   foreach($my_orders_products as $k=>$v){
	   	   	$order_info = $this->Order->findbyid($v['OrderProduct']['order_id']);
	   	   	$my_orders_products[$k]['OrderProduct']['order_code'] = $order_info['Order']['order_code'];
	   	  	$product_category = $this->ProductsCategory->findbyproduct_id($v['Product']['id']);
	  	   if(isset($res_c[$product_category['ProductsCategory']['id']]['Category']['id'])){
	  	  //	  $my_orders_products[$k]['Category']=$res_c[$v['ProductsCategory']['id']]['Category'];
	  	  //	  $my_orders_products[$k]['CategoryI18n']=$res_c[$v['ProductsCategory']['id']]['CategoryI18n'];
	  	  	  $my_orders_products[$k]['Category']=$res_c[$res_c[$product_category['ProductsCategory']['id']]['Category']['id']]['Category'];
	  	  	  $my_orders_products[$k]['CategoryI18n']=$res_c[$res_c[$product_category['ProductsCategory']['id']]['Category']['id']]['CategoryI18n'];	  	  
	  	  }
	  	  if(isset($res_b[$v['Product']['brand_id']]['Brand']['id'])){
	  	  	  $my_orders_products[$k]['Brand']=$res_b[$v['Product']['brand_id']]['Brand'];
	  	  	  $my_orders_products[$k]['BrandI18n']=$res_b[$v['Product']['brand_id']]['BrandI18n'];
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