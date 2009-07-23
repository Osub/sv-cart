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
 * $Id: topics_controller.php 2907 2009-07-15 11:04:21Z shenyunfeng $
*****************************************************************************/
class TopicsController extends AppController {
	var $name = 'Topics';
    var $components = array ('Pagination','RequestHandler');
   	var $helpers = array('Pagination','Html', 'Form', 'Javascript'); 
	var $uses = array('Topic','TopicI18n','Brand','ProductType','Category','Product','TopicProduct');
   
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
     	$this->Topic->set_locale($this->locale);
    	$topics = $this->Topic->findall();
       	$total = count($topics);
       	$now = date("Y-m-d H:i:s");
       	$yestoday = date("Y-m-d H:i:s",strtotime ("-1 day"));
       	$filter = "1=1";
        $filter .= " and Topic.created <= '".$now."' and  Topic.created >='".$yestoday."'";     	
       	$one_day_promotions = $this->Topic->find('all',array('conditions'=>array($filter),'fields'=>array('Topic.id')));
		$this->set("one_day_time",count($one_day_promotions));
       	$sortClass='Topic';
       	$parameters=Array($orderby,$rownum,$page);
       	$options=Array();
       	$page = $this->Pagination->init($filter,$parameters,$options,$total,$rownum,$sortClass);
       	$ur_heres[]	= array('name'=>$this->languages['home'],'url'=>"/");
    	$ur_heres[]	= array('name'=>$this->languages['topic'].$this->languages['home'],'url'=>"");
    	$this->set('topics',$topics);
    	$this->set('locations',$ur_heres);
      	$this->set('orderby',$orderby);
		$this->set('rownum',$rownum);
    	$this->set('total',$total);
    	//page_number_expand_max
		$js_languages = array("page_number_expand_max" =>$this->languages['page_number'].$this->languages['not_exist']);
		$this->set('js_languages',$js_languages);
    	
    	//$this->set();
    	$this->pageTitle = $this->languages['topic'].$this->languages['home']." - ".$this->configs['shop_title'];
    }
	
    function view($id){
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
   			
   			$all_product = $this->Product->find('all',array('conditions'=>array('Product.id'=>$topic_ids),));
   			
			foreach($topic_products as $k=>$v){
    			$products[$v['TopicProduct']['product_id']] = $this->Product->findbyid($v['TopicProduct']['product_id']);
    			$products[$v['TopicProduct']['product_id']]['Product']['shop_price'] = $v['TopicProduct']['price'];
    		}
    	}
    	$ur_heres[]	= array('name'=>$this->languages['home'],'url'=>"/");
    	$ur_heres[]	= array('name'=>$this->languages['topic'].$this->languages['home'],'url'=>"/topics/");
    	$ur_heres[]=array('name'=>$topic['TopicI18n']['title'],'url'=>"");
    	$this->set('locations',$ur_heres);
		if(isset($products)){
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