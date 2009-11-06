<?php
/*****************************************************************************
 * SV-Cart 专题管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: topics_controller.php 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
class TopicsController extends AppController {
	var $name = 'Topics';
    var $components = array ('Pagination','RequestHandler');
   	var $helpers = array('Pagination','Html', 'Form', 'Javascript'); 
	var $uses = array('Topic','TopicI18n','Brand','ProductType','Category','Product','TopicProduct','ProductLocalePrice','ProductRank','UserRank');
	var $cacheQueries = true;
	var $cacheAction = "1 hour";
   
    function index($page=0,$orderby="created",$rownum=''){
	 	  if(isset($this->configs['promotions_page_list_number'])){
	 	  	  $rownum=$this->configs['promotions_page_list_number'];
	 	  }
	 	  else{
	 	  	  $rownum=10;
	 	  }
		if(!empty($orderby)){
	 	  	 $orderby=$orderby;
	 	 }
	 	 else{
	 	  	 $orderby='created';
	 	 }
	 	 
	 	 if(isset($_GET['page'])){
	 	 	$page = $_GET['page'];
	 	 }else{
	 		 $_GET['page'] = $page;
	 	 }
		$this->data['get_page'] = $page;	 	 
		$this->data['orderby'] = $orderby;
		$this->data['rownum'] = $rownum;
	 	 
	 	 
    	$this->page_init();
     	$this->Topic->set_locale($this->locale);
    	$topics = $this->Topic->findall();
       	$total = count($topics);
       	$sortClass='Topic';
       	$parameters=Array($orderby,$rownum,$page);
       	$options=Array();
       	$page = $this->Pagination->init('1=1',$parameters,$options,$total,$rownum,$sortClass);
       	$topics = $this->Topic->find('all',array('conditions'=>array('1=1'),'order'=>"Topic.created asc",'limit'=>$rownum,'page'=>$page));
       	$now = date("Y-m-d H:i:s");
       	$yestoday = date("Y-m-d H:i:s",strtotime ("-1 day"));
       	$filter = "1=1";
        $filter .= " and Topic.created <= '".$now."' and  Topic.created >='".$yestoday."'";     	
       	$one_day_promotions = $this->Topic->find('all',array('conditions'=>array($filter),'fields'=>array('Topic.id')));
		$this->set("one_day_time",count($one_day_promotions));
       	$ur_heres[]	= array('name'=>$this->languages['home'],'url'=>"/");
    	$ur_heres[]	= array('name'=>$this->languages['topic'].$this->languages['home'],'url'=>"");
    	$this->set('topics',$topics);
    	$this->set('locations',$ur_heres);
      	$this->set('orderby',$orderby);
		$this->set('rownum',$rownum);
    	$this->set('total',$total);
    	
    	$this->data['pages_url_1'] = $this->server_host.$this->cart_webroot."topics/index/";
    	$this->data['pages_url_2'] = "/".$this->data['orderby']."/".$this->data['rownum'];    	
    	
    	//page_number_expand_max
		$js_languages = array("page_number_expand_max" =>$this->languages['page_number'].$this->languages['not_exist']);
		$this->set('js_languages',$js_languages);
    	
    	//$this->set();
    	$this->pageTitle = $this->languages['topic'].$this->languages['home']." - ".$this->configs['shop_title'];
    }
	
    function view($id){
    	$this->layout = 'default_full';
    	$this->page_init();
    	$this->Topic->set_locale($this->locale);
    	$this->Product->set_locale($this->locale);
    	$topic = $this->Topic->findbyid($id);
    	$flag = 1;
    	if(!is_numeric($id) || $id<1){
    		 $this->pageTitle = $this->languages['invalid_id']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['invalid_id'],"/",5);
			 $flag = 0;
		}
    	if(empty($topic)){
    		$this->pageTitle = $this->languages['topic'].$this->languages['home']." - ".$this->configs['shop_title'];
			$this->flash($this->languages['topic'].$this->languages['not_exist'],"/",5);
			$flag = 0;
		}
		if($flag){
    	/*时间格式化*/
		$topic['Topic']['created']=substr($topic['Topic']['start_time'],0,10);
		$topic['Topic']['modified']=substr($topic['Topic']['end_time'],0,10);
    	//商品
    	
    	
    	$topic_products = $this->TopicProduct->find('all',array('conditions'=>array('TopicProduct.topic_id'=>$id,'TopicProduct.status'=>1),'fields'=>array('TopicProduct.id','TopicProduct.topic_id','TopicProduct.product_id','TopicProduct.price')));
   		
   		
   		if(isset($topic_products) && count($topic_products) > 0){
   			$topic_ids = array();
   			foreach($topic_products as $k=>$v){
   				$topic_ids[] = $v['TopicProduct']['product_id'];
   			}
   			
   		//	$all_product = $this->Product->find('all',array('conditions'=>array('Product.id'=>$topic_ids)));
			$all_product = $this->Product->get_list(implode(',',$topic_ids),$this->locale);
			
				//地区价格
				if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1){
					$locale_price_list =array();
					if(!empty($topic_ids)){
						$cache_key = md5('topics_product_id_locale_price'.'_'.$this->locale);
						$locale_price = cache::read($cache_key);	
						if(!$locale_price){
							$locale_price = $this->ProductLocalePrice->find('all',array( 
							'fields' =>	array('ProductLocalePrice.product_price','ProductLocalePrice.product_id'),
							'conditions'=>array('ProductLocalePrice.product_id'=>$topic_ids,'ProductLocalePrice.locale'=>$this->locale,'ProductLocalePrice.status'=>1)));
							cache::write($cache_key,$locale_price);
						}
						if(isset($locale_price) && sizeof($locale_price)>0){
							foreach($locale_price as $k=>$v){
								$locale_price_list[$v['ProductLocalePrice']['product_id']] = $v;
							}
						}
					}
				}			
   			$products = array();
		   		if(isset($_SESSION['User']['User'])){
					$product_ranks = $this->ProductRank->findall_ranks();
				}
				if(isset($_SESSION['User']['User'])){
					$user_rank_list=$this->UserRank->findrank();		
				}
   			if(isset($all_product) && sizeof($all_product)>0){
   				foreach($all_product as $k=>$v){
   					$products[$v['Product']['id']] = $v;
   				
   					if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1  && isset($locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'])){
						$products[$v['Product']['id']]['Product']['shop_price'] = $locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'];
					}	
   				
					if(isset($product_ranks[$v['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']])){
						if(isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
						  $products[$v['Product']['id']]['Product']['shop_price']= $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
						}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
						  $products[$v['Product']['id']]['Product']['shop_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($v['Product']['shop_price']);			  
						}
					}			
					if($this->Product->is_promotion($v)){
						$products[$v['Product']['id']]['Product']['shop_price'] = $v['Product']['promotion_price'];
					}	   				
   				
   				
   				}
   			}
		//	foreach($topic_products as $k=>$v){
    	//		$products[$v['TopicProduct']['product_id']] = $this->Product->findbyid($v['TopicProduct']['product_id']);
    		//	$products[$v['TopicProduct']['product_id']]['Product']['shop_price'] = $v['TopicProduct']['price'];
    	//	}
    	}
    	$ur_heres[]	= array('name'=>$this->languages['home'],'url'=>"/");
    	$ur_heres[]	= array('name'=>$this->languages['topic'].$this->languages['home'],'url'=>"/topics/");
    	$ur_heres[]=array('name'=>$topic['TopicI18n']['title'],'url'=>"");
    	$this->set('locations',$ur_heres);
		if(isset($products)){
			$this->data['cache_products'] = $products;
			$this->set('products',$products);
		}
    	$this->set('topic',$topic);
 		$js_languages = array("comment" => $this->languages['comments'],
 							"waitting_for_check" => $this->languages['waitting_for_check']
 						);
    	$this->set('neighbours',$this->Topic->findNeighbours('',array('id','TopicI18n.title'),$id));
		$this->set('js_languages',$js_languages);
    	$this->pageTitle = $topic['TopicI18n']['title']." -".$this->languages['topic'].$this->languages['home']." - ".$this->configs['shop_title'];
    	$this->set('meta_description',$topic['TopicI18n']['meta_description']);
	 	$this->set('meta_keywords',$topic['TopicI18n']['meta_keywords']);
	 	
		 	if($topic['Topic']['template'] != ""){
		 		$this->render('/topics/'.$topic['Topic']['template']);
		 	}
	 	}
    }
}

?>