<?php
/*****************************************************************************
 * SV-Cart 促销控制
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: promotions_controller.php 2907 2009-07-15 11:04:21Z shenyunfeng $
*****************************************************************************/
class PromotionsController extends AppController {

	var $name = 'Promotions';
    var $components = array ('Pagination','Cookie');
    var $helpers = array('html','Pagination','Flash');
    var $uses = array('Category','Product','Flash','Promotion','PromotionI18n','PromotionProduct','Brand');

    function index($orderby="orderby",$rownum=''){
	 	  if(isset($this->configs['promotions_page_list_number'])){
	 	  	  $rownum=$this->configs['promotions_page_list_number'];
	 	  }
	 	  else{
	 	  	  $rownum=10;
	 	  }
	 	 if(isset($this->configs['promotions_list_orderby'])){
	 	 	 $orderby=$this->configs['promotions_list_orderby'];
	 	 }elseif(!empty($orderby)){
	 	  	 $orderby=$orderby;
	 	 }
	 	 else{
	 	  	 $orderby='created';
	 	 }
	 	 if(isset($_REQUEST['page'])){
	 	 	$page = $_REQUEST['page'];
	 	 }else{
	 	 	$page = 1;
	 	 }
    	$this->page_init();
     	$this->Promotion->set_locale($this->locale);
    	$promotions = $this->Promotion->findall();
       	$total = count($promotions);
	   // date_default_timezone_set('PRC'); 
       	$now = date("Y-m-d H:i:s");
       	$yestoday = date("Y-m-d H:i:s",strtotime ("-1 day"));
       	$filter = "1=1";
        $filter .= " and  Promotion.status = '1' and Promotion.created <= '".$now."' and  Promotion.created >='".$yestoday."'";     	
       	
       	$one_day_promotions = $this->Promotion->find('all',array('conditions'=>array($filter),'fields'=>array('Promotion.id')));
		$this->set("one_day_time",count($one_day_promotions));
       	$condition = '1=1';
       	$sortClass='Promotion';
       	$parameters=Array($orderby,$rownum,$page);
       	$options=Array();
       	
       //	$promotions = $this->Promotion->findAll($condition,''," Promotion.$orderby asc ","$rownum",$page);
       	
       	$promotions = $this->Promotion->find('all',array('conditions'=>array($condition),'fields'=>array('Promotion.id','Promotion.start_time','Promotion.end_time','PromotionI18n.title'),'order'=>"Promotion.$orderby asc",'limit'=>$rownum,'page'=>$page));
       	$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
       	$ur_heres[]	= array('name'=>$this->languages['home'],'url'=>"/");
    	$ur_heres[]	= array('name'=>$this->languages['promotion'].$this->languages['home'],'url'=>"");
    	$this->set('promotions',$promotions);
    	$this->set('locations',$ur_heres);
      	$this->set('orderby',$orderby);
		$this->set('rownum',$rownum);
    	$this->set('total',$total);
    	//page_number_expand_max
		$js_languages = array("page_number_expand_max" =>$this->languages['page_number'].$this->languages['not_exist']);
		$this->set('js_languages',$js_languages);
    	
    	//$this->set();
    	$this->pageTitle = $this->languages['promotion'].$this->languages['home']." - ".$this->configs['shop_title'];
    }    
    function view($id){
    	$this->page_init();
    	$this->Promotion->set_locale($this->locale);
    	$this->Product->set_locale($this->locale);
    	$promotion = $this->Promotion->findbyid($id);
    	$flag = 1;
    	if(!is_numeric($id) || $id<1){
    		 $this->pageTitle = $this->languages['invalid_id']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['invalid_id'],"/",5);
			 $flag = 0;
		}
    	if(empty($promotion)){
    		$this->pageTitle = $this->languages['promotion'].$this->languages['home']." - ".$this->configs['shop_title'];
			$this->flash($this->languages['promotion'].$this->languages['not_exist'],"/",5);
			$flag = 0;
		}elseif($promotion['Promotion']['status'] == 0){
    		 $this->pageTitle = $this->languages['promotion_forbidden']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['promotion_forbidden'],"/",5);
			 $flag = 0;
		}
		if($flag){
    	/*时间格式化*/
		$promotion['Promotion']['created']=substr($promotion['Promotion']['start_time'],0,10);
		$promotion['Promotion']['modified']=substr($promotion['Promotion']['end_time'],0,10);
    	//商品
    //	$promotion_products = $this->PromotionProduct->findallbypromotion_id($id);
    	$promotion_products = $this->PromotionProduct->find('all',array('conditions'=>array('PromotionProduct.promotion_id'=>$id),'fields'=>array('PromotionProduct.product_id','PromotionProduct.price','PromotionProduct.id')));	
   // 	pr($promotion_products);
		if(isset($promotion_products) && count($promotion_products) > 0){
			foreach($promotion_products as $k=>$v){
    			$products[$v['PromotionProduct']['product_id']] = $this->Product->findbyid($v['PromotionProduct']['product_id']);
    			$products[$v['PromotionProduct']['product_id']]['Product']['shop_price'] = $v['PromotionProduct']['price'];
    		}
    	}
    	$ur_heres[]	= array('name'=>$this->languages['home'],'url'=>"/");
    	$ur_heres[]	= array('name'=>$this->languages['promotion'].$this->languages['home'],'url'=>"/promotions/");
    	$ur_heres[]=array('name'=>$promotion['PromotionI18n']['title'],'url'=>"");
    	$this->set('locations',$ur_heres);
    	$this->set('neighbours',$this->Promotion->findNeighbours('',array('id','PromotionI18n.title'),$id));
		if(isset($products)){
			$this->set('products',$products);
		}
    	$this->set('promotion',$promotion);
 		$js_languages = array("comment" => $this->languages['comments'],
 							"waitting_for_check" => $this->languages['waitting_for_check']
 						);
		$this->set('js_languages',$js_languages);
    	$this->pageTitle = $promotion['PromotionI18n']['title']." -".$this->languages['promotion'].$this->languages['home']." - ".$this->configs['shop_title'];
    	$this->set('meta_description',$promotion['PromotionI18n']['meta_description']);
	 	$this->set('meta_keywords',$promotion['PromotionI18n']['meta_keywords']);
	 	}
    }
}    
?>