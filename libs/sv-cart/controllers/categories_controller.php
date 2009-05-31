<?php
/*****************************************************************************
 * SV-Cart 分类控制
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: categories_controller.php 1907 2009-05-31 14:34:18Z huangbo $
*****************************************************************************/

class CategoriesController extends AppController {

	var $name = 'Categories';
    var $components = array ('Pagination','Cookie'); // Added
    var $helpers = array('html','Pagination','Flash');
    var $uses = array('Category','Product','Flash','ProductsCategory','UserRank','ProductRank'); 

	function view($id,$name1='',$name2 = '',$orderby="",$rownum='',$showtype=""){
		$orderby = UrlDecode($orderby);
		$rownum = UrlDecode($rownum);
		$showtype = UrlDecode($showtype);
	//	Configure::write('debug', 0);
		$this->page_init();
		$flag = 1;
		if(!is_numeric($id) || $id<1){
	       	 $this->pageTitle = $this->languages['parameter_error']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['parameter_error'],"/",5);
			 $flag = 0;
			 
		}
		//取该分类的信息
		$this->Category->set_locale($this->locale);
		$info=$this->Category->findbyid($id);
		
		if(empty($info)){
	       	 $this->pageTitle = $this->languages['classificatory'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['classificatory'].$this->languages['not_exist'],"/",5);
			 $flag = 0;
		}elseif($info['Category']['status'] == 0){
	       	 $this->pageTitle = $this->languages['classificatory'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['classificatory'].$this->languages['not_exist'],"/",5);
			 $flag = 0;
		}
		
		if($flag == 1){
			if($this->configs['use_sku'] == 1){
				$this->set('use_sku',1);
				if($info['Category']['parent_id']>0){
					$parent_info = $this->Category->findbyid($info['Category']['parent_id']);
					if(isset($parent_info['Category'])){
						$this->set('parent',$parent_info['CategoryI18n']['name']);
					}
				}
			}
			
			
			$this->pageTitle = $info['CategoryI18n']['name']." - ".$this->configs['shop_title'];
			$this->set('CategoryI18n_name',$info['CategoryI18n']['name']);
			//当前位置
			$navigations = $this->Category->tree('P',$id);
			//pr($navigations);
			if($info['Category']['parent_id'] == 0){
				$this->navigations[] = array('name'=>$info['CategoryI18n']['name'],'url'=>"/categories/".$info['Category']['id']);
			}
			if($info['Category']['parent_id'] == 1){
				$this->navigations[] = array('name'=>$navigations['tree']['0']['CategoryI18n']['name'],'url'=>"/categories/".$navigations['tree']['0']['Category']['id']);
				$this->navigations[] = array('name'=>$info['CategoryI18n']['name'],'url'=>"/categories/".$info['Category']['id']);
			}
			
			$this->set('locations',$this->navigations);

		 	$rownum=isset($this->configs['products_list_num']) ? $this->configs['products_list_num']:((!empty($rownum)) ?$rownum:20);

		 	$showtype=isset($this->configs['products_list_showtype']) ? $this->configs['products_list_showtype']:((!empty($showtype)) ?$showtype:'L');

			if(empty($orderby)){
		 		$orderby=isset($this->configs['products_category_page_orderby_type'])? $this->configs['products_category_page_orderby_type']." ". $this->configs['products_category_page_orderby_method'] :((!empty($orderby)) ?$orderby:'created '.$this->configs['products_category_page_orderby_method']);
			}

		//	pr($this->configs['products_category_page_orderby_method']);
			$this->Product->set_locale($this->locale);
		//	该分类下面的所有商品和该分类下的商品的多语言,以及分页
		//	pr($this->Category->allinfo['subids'][$id]);
		//	pr($this->Category->allinfo['subids'][$id]);
		//	pr($this->Category->allinfo['subids'][$id]);
			$category_ids =$this->Category->allinfo['subids'][$id];
			
			//foreach($category_ids as $k=>$v){
		//	$category_arr = $this->Category->findall(array("Category.id"=> $this->Category->allinfo['subids'][$id]));
			
			//}
			/*
			$productscategory = $this->ProductsCategory->findall($condition);
			if(is_array($productscategory) && sizeof($productscategory)>0){
				$id_arr = array();
				foreach($productscategory as $p){
					if(!in_array($p['ProductsCategory']['product_id'],$id_arr)){
					$id_arr[] = $p['ProductsCategory']['product_id'];
					}
				}
			$total = count($id_arr);
			}else{
				$id_arr = 'null';
				$total = 0;
			}*/
			$sortClass='Product';
			$page=1;
			$parameters=Array($orderby,$rownum,$page);
			$options=Array();
			//pr($category_ids);
			$condition = array("Product.category_id"=>$category_ids,'Product.status'=>1,'Product.forsale' =>'1');
			$products=$this->Product->findAll($condition,'',"Product.$orderby","$rownum",$page);
			$total = count($products);
			$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass); // Added 
				foreach($products as $k=>$v){
					$products[$k]['Product']['user_price'] =$this->Product->user_price($k,$v,$this);
					$category_info = $this->ProductsCategory->find('ProductsCategory.product_id ='.$v['Product']['id'].' and ProductsCategory.category_id ='.$v['Product']['category_id']);
					$products[$k]['ProductsCategory'] = $category_info['ProductsCategory'];		
					if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
						$products[$k]['ProductI18n']['name'] = $this->Product->sub_str($v['ProductI18n']['name'], $this->configs['products_name_length']);
					}
					$products[$k]['Product']['shop_price'] =$this->Product->locale_price($v['Product']['id'],$v['Product']['shop_price'],$this);
					if($this->Product->is_promotion($v['Product']['id'])){
						$products[$k]['Product']['shop_price'] = $v['Product']['promotion_price'];
					}						
					
					
				}
		    
			$this->set('products',$products);
			
			$this->Flash->set_locale($this->locale);
			$this->set('flashes',$this->Flash->find("type ='PC' and type_id='$id' ")); //flash轮播
			
			$this->set('id',$id);
			$this->set('type','P');
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
		//排序方式,显示方式,分页数量限制
		$this->set('orderby',$orderby);
		$this->set('rownum',$rownum);
		$this->set('showtype',$showtype);
 	}
 	
}
?>