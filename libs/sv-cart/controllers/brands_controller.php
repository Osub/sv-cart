<?php
/*****************************************************************************
 * SV-Cart 品牌分类
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: brands_controller.php 1144 2009-04-29 11:41:30Z huangbo $
*****************************************************************************/

class BrandsController extends AppController {
	var $name = 'Brands';
    var $components = array ('Pagination'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array('Brand','Product','Flash','Category','UserRank','ProductsCategory','ProductRank');

function view($id="",$orderby="",$rownum='',$showtype=""){
		$orderby = UrlDecode($orderby);
		$rownum = UrlDecode($rownum);
		$showtype = UrlDecode($showtype);
		$this->page_init();
		$flag = 1;
		// Configure::write('debug', 0);
	 if(!is_numeric($id) || $id<1){
	     $this->pageTitle = $this->languages['parameter_error']." - ".$this->configs['shop_title'];
		 $this->flash($this->languages['parameter_error'],"/",5);
		 $flag = 0;
	 }
	 $this->Brand->set_locale($this->locale);
 	  //取得该品牌信息
	  $brand_info=$this->Brand->findbyid($id);
	if(empty($brand_info)){
	       	 $this->pageTitle = $this->languages['brand_unexist']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['brand_unexist'],"/",5);
			 $flag = 0;
	  }
	elseif($brand_info['Brand']['status'] == 0){
	       	 $this->pageTitle = $this->languages['brand_has_been_forbidden']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['brand_has_been_forbidden'],"/",5);
			 $flag = 0;
	  }
	  
	    if($flag == 1){
		
		$this->pageTitle = $brand_info['BrandI18n']['name']." - ".$this->configs['shop_title']." - ".$this->configs['shop_title'];
		//当前位置
		$navigations=$this->Brand->findbyid($id);
	//	pr($navigations);
		$this->navigations[] = array('name'=>$navigations['BrandI18n']['name'],'url'=>"/brands/".$navigations['Brand']['id']);
		$this->set('locations',$this->navigations);
	  
 	  //取商店设置商品数量
 	  $rownum=isset($this->configs['products_list_num']) ? $this->configs['products_list_num']:((!empty($rownum)) ?$rownum:20);
 	  //取商店设置商品显示方式
 	  $showtype=isset($this->configs['products_list_showtype']) ? $this->configs['products_list_showtype']:((!empty($showtype)) ?$showtype:'L');
 	  //取商店设置商品排序
	  if(empty($orderby)){
	  		$orderby=isset($this->configs['products_category_page_orderby_type'])? $this->configs['products_category_page_orderby_type']." ". $this->configs['products_category_page_orderby_method'] :((!empty($orderby)) ?$orderby:'created '.$this->configs['products_category_page_orderby_method']);
	  }

 	  $this->Product->set_locale($this->locale);
      //取得属于该品牌的商品,以及分页
	  $condition = " Product.brand_id='$id' ";
	  $total = $this->Product->findCount($condition,0);
	  $sortClass='Product';
	  //pr($parameters);
	  $page=1;
	  $parameters=Array($orderby,$rownum,$page);
	  $options=Array();
	  list($page) = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass); // Added 
	  $products_list=$this->Product->findAll($condition,'',"Product.$orderby asc ","$rownum",$page);
			foreach($products_list as $k=>$v){
				
		 			 if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
							$products_list[$k]['ProductI18n']['name'] = $this->Product->sub_str($v['ProductI18n']['name'], $this->configs['products_name_length']);
	 				 }
					$category_info = $this->ProductsCategory->find('ProductsCategory.product_id ='.$v['Product']['id'].' and ProductsCategory.category_id ='.$v['Product']['category_id']);
					$products_list[$k]['ProductsCategory'] = $category_info['ProductsCategory'];					
					$products_list[$k]['Product']['user_price'] =$this->Product->user_price($k,$v,$this);
  			}
				
	

	  $this->Flash->set_locale($this->locale);
	  $this->set('flashes',$this->Flash->find("type ='PC' and type_id='$id' ")); //flash轮播
	  
 	  $this->set('products',$products_list);
 	  $this->set('id',$id);
 	  $this->set('type','B');
 	  //pr($products_list);
 	  //排序方式,显示方式,分页数量限制
	  $this->set('orderby',$orderby);
	  $this->set('rownum',$rownum);
	  $this->set('showtype',$showtype);
	    }
      if(isset($this->configs['enable_one_step_buy']) && $this->configs['enable_one_step_buy'] == 1){
			$js_languages = array("enable_one_step_buy" => "1"
										,'enter_positive_integer' => $this->languages['be_integer']);
			$this->set('js_languages',$js_languages);
	  }else{
			$js_languages = array("enable_one_step_buy" => "0"
										,'enter_positive_integer' => $this->languages['be_integer']);
			$this->set('js_languages',$js_languages);
	  }
	  $this->set('meta_description',$brand_info['BrandI18n']['meta_description']);
 	  $this->set('meta_keywords',$brand_info['BrandI18n']['meta_keywords']);
 	}
}
?>