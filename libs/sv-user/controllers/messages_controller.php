<?php
/*****************************************************************************
 * SV-Cart 用户留言
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: messages_controller.php 4718 2009-09-29 03:01:55Z huangbo $
*****************************************************************************/
uses('sanitize');		
class MessagesController extends AppController {

	var $name = 'Messages';
     var $components = array ('Pagination'); // Added 
    var $helpers = array('Pagination'); // Added
	var $uses = array("UserMessage",'Order',"Product","ProductsCategory","OrderProduct");


	function view($order_id=0){
		//未登录转登录页
		if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
				$this->redirect('/login/');
		}
		$this->page_init();
		
		//当前位置
		$this->navigations[] = array('name'=>__($this->languages['my_message'],true),'url'=>"");
		$this->set('locations',$this->navigations);
		
	    $user_id=$_SESSION['User']['User']['id'];
 	  //取商店设置留言显示数量
 	  $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	   //取得我的留言
	   //pr($_SESSION['User']);
	   $condition=" UserMessage.user_id='".$user_id."' and UserMessage.parent_id = 0";
	   $total = $this->UserMessage->findCount($condition,0);
	   $sortClass='UserMessage';
	   $page=1;
	   $parameters=Array($rownum,$page);
	   $options=Array();
	   $page = $this->Pagination->init($condition,"",$options,$total,$rownum,$sortClass);
	   $my_messages=$this->UserMessage->findAll($condition,'',"","$rownum",$page);
	   if(empty($my_messages)){
	   	   $my_messages=array();
	   }
	   if($order_id >0){
	   		$order_info = $this->Order->findbyid($order_id);
	   		$this->set('order_info',$order_info);
	   }
	   //pr($my_messages);
	   $my_messages_parent_id = array();
	   $my_messages_parent_id[] = 0;
	   $p_ids = array();
	   $o_ids = array();
	   foreach($my_messages as $k=>$v){
	   	  $my_messages_parent_id[] = $v['UserMessage']['id'];
	//   	   $replies=$this->UserMessage->findAll("UserMessage.parent_id = '".$v['UserMessage']['id']."'");
	   //	   $my_messages[$k]['Reply']=$replies;
	   	   if($v['UserMessage']['msg_type'] == 0){
	   	   	      $my_messages[$k]['UserMessage']['type_name'] = $this->systemresource_info['msg_type']['0'];
	   	   }
	   	   else if($v['UserMessage']['msg_type'] == 1){
	   	   	      $my_messages[$k]['UserMessage']['type_name'] = $this->systemresource_info['msg_type']['1'];
	   	   }
	   	   else if($v['UserMessage']['msg_type'] == 2){
	   	   	      $my_messages[$k]['UserMessage']['type_name'] = $this->systemresource_info['msg_type']['2'];
	   	   }
	   	   else if($v['UserMessage']['msg_type'] == 3){
	   	   	      $my_messages[$k]['UserMessage']['type_name'] = $this->systemresource_info['msg_type']['3'];
	   	   }
	   	   else if($v['UserMessage']['msg_type'] == 4){
	   	   	      $my_messages[$k]['UserMessage']['type_name'] = $this->systemresource_info['msg_type']['4'];
	   	   }
	   	  else {
	   	   	      $my_messages[$k]['UserMessage']['type_name'] = $this->systemresource_info['msg_type']['5'];
	   	   }
	   	   
	   	   if($v['UserMessage']['type'] == "P" && $v['UserMessage']['value_id'] > 0){
	   	   		$p_ids[] = $v['UserMessage']['value_id'];
	   	   }
	   	   if($v['UserMessage']['type'] == "O" && $v['UserMessage']['value_id'] > 0){
	   	   		$o_ids[] = $v['UserMessage']['value_id'];
	   	   }	   	   
	   }
	   
	   if(!empty($p_ids)){
	   	  $this->Product->set_locale($this->locale);
	   	  $products = $this->Product->find('all',array(
			'fields' =>	array('Product.id','ProductI18n.name'),			   	  
	   	  'conditions'=>array('Product.id'=>$p_ids)));
	   }
	   if(!empty($o_ids)){
	   	  $orders = $this->Order->find('all',array(
			'fields' =>	array('Order.id','Order.order_code'),			   	  
	   	  'conditions'=>array('Order.id'=>$o_ids)));
	   }	   
	   $order_list = array();
	   $product_list = array();
	   
	   if(isset($products) && sizeof($products)>0){
	   		foreach($products as $k=>$v){
	   			$product_list[$v['Product']['id']] = $v;
	   		}
	   }
	   if(isset($orders) && sizeof($orders)>0){
	   		foreach($orders as $k=>$v){
	   			$order_list[$v['Order']['id']] = $v;
	   		}
	   }	   
	   
	   
	   $replies_list = $this->UserMessage->find('all',array('conditions'=>array('UserMessage.parent_id'=>$my_messages_parent_id)));
	   
	   $replies_list_format = array();
	   if(is_array($replies_list) && sizeof($replies_list)>0){
	   		foreach($replies_list as $k=>$v){
	   			$replies_list_format[$v['UserMessage']['parent_id']][] = $v;
	   		}
	   }
	   foreach($my_messages as $k=>$v){
	   	     if(isset($replies_list_format[$v['UserMessage']['id']])){
	   			 $my_messages[$k]['Reply']= $replies_list_format[$v['UserMessage']['id']];
	   		 }
	   		 
	   			 if($v['UserMessage']['type'] == 'O' && isset($order_list[$v['UserMessage']['value_id']])){
	   			 	
	   			 	$my_messages[$k]['Order']= $order_list[$v['UserMessage']['value_id']];
	   			 }
	   			 
	   			 if($v['UserMessage']['type'] == 'P' && isset($product_list[$v['UserMessage']['value_id']])){
	   			 	$my_messages[$k]['Product']= $product_list[$v['UserMessage']['value_id']];
	   		 	 }	   		 
	   }
	  //	pr($order_list);
 		//pr($my_messages[12]);
	   $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist'],
	   "subject_is_blank" => $this->languages['subject'].$this->languages['can_not_empty'] ,
	   "message_type_empty" => $this->languages['message'].$this->languages['type'].$this->languages['can_not_empty'],
	   "content_empty" => $this->languages['content'].$this->languages['can_not_empty']);
	   $this->set('js_languages',$js_languages);

	   $this->pageTitle = $this->languages['my_message']." - ".$this->configs['shop_title'];
	   $this->set('total',$total);
	   $this->set('my_messages',$my_messages);
	}
/************   添加留言    ****************/
function AddMessage(){
		$mrClean = new Sanitize();		
	 $order_id = 0;
	 if(isset($_POST['order_id'])){
	 	$order_id = $_POST['order_id'];
	 	$message_type = 0;
	 }else{
	 $message_type = $_POST['message_type'];
	 }
	 $created=date('Y-m-d H:i:s');
	 
	 $messages=array(
		'msg_title'=>	isset($_POST['title'])   ? trim($_POST['title'])  : '',
		'msg_content'=>	isset($_POST['content'])   ? trim($_POST['content'])  : 0,
		'msg_type'=>	isset($message_type)   ? trim($message_type)  : '',
		'type'=>	isset($_POST['order_type'])   ? trim($_POST['order_type'])  : '',
		'user_id'=> $_SESSION['User']['User']['id'],
		'user_email'=> $_SESSION['User']['User']['email'],
		'user_name'=> $_SESSION['User']['User']['name'],
		'value_id' => $order_id,
		'created'=>$created
		);
	$this->UserMessage->save(array('UserMessage'=>$messages));
	 //显示的页面
	$this->redirect("/messages/");
}
/************   添加留言    ****************/


	function product_message($rownum='',$showtype="",$orderby=""){
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
		   // $my_orders_products=$this->OrderProduct->findAll($condition,'',"","$rownum",$page);
		    $my_orders_products=$this->OrderProduct->find('all',array('conditions'=>array($condition),
																	'fields' =>	array('OrderProduct.id','OrderProduct.order_id','OrderProduct.product_id','Product.img_thumb'
																					,'Product.market_price'
																					,'Product.shop_price'
																					,'Product.code','Product.id'
																					,'Product.brand_id'
																					,'ProductI18n.name'
																					),		  	  
		  	  'order'=>array("Product.$orderby"),'limit'=>$rownum,'page'=>$page));
		    
		    
		  //  pr($my_orders_products);
		    
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
			//products_ids_list
	   		$my_messages	=	$this->UserMessage->find('all',array('conditions'=>array('UserMessage.value_id'=>$products_ids_list,'UserMessage.type'=>'P','UserMessage.parent_id'=>0,'UserMessage.user_id'=>$_SESSION['User']['User']['id'],'UserMessage.status'=>1)));
			$this->set('my_messages_sizeof',sizeof($my_messages));
			
			if(isset($my_messages) && sizeof($my_messages)>0){
	  			foreach($my_messages as $k=>$v){
	  	 	  		$my_messages_parent_id[] = $v['UserMessage']['id'];
	  			}
	  			 $replies_list = $this->UserMessage->find('all',array('conditions'=>array('UserMessage.parent_id'=>$my_messages_parent_id)));
				$this->set('replies_list_sizeof',sizeof($replies_list));
				   $replies_list_format = array();
				   if(is_array($replies_list) && sizeof($replies_list)>0){
				   		foreach($replies_list as $k=>$v){
				   			$replies_list_format[$v['UserMessage']['parent_id']][] = $v;
				   		}
				   }
				   $my_messages_list = array();
				   foreach($my_messages as $k=>$v){
				   	   	$my_messages_list[$v['UserMessage']['value_id']][$k] = $v;
				   	   	
				   	     if(isset($replies_list_format[$v['UserMessage']['id']])){
				   			 $my_messages_list[$v['UserMessage']['value_id']][$k]['Reply'] = $replies_list_format[$v['UserMessage']['id']];
				   		 }	  			
	  				}
	  				$this->set('my_messages_list',$my_messages_list);
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

	function delete_message($id){
		if(!isset($_SESSION['User'])){
			 $this->redirect('/login/');
		}
		$this->UserMessage->deleteall("UserMessage.id='".$id."'  and UserMessage.user_id = '".$_SESSION['User']['User']['id']."'");
		$this->redirect("/messages/");
		
	}



}

?>