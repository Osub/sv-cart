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
 * $Id: messages_controller.php 3233 2009-07-22 11:41:02Z huangbo $
*****************************************************************************/
uses('sanitize');		
class MessagesController extends AppController {

	var $name = 'Messages';
     var $components = array ('Pagination'); // Added 
    var $helpers = array('Pagination'); // Added
	var $uses = array("UserMessage",'Order',"SystemResource","Product");


	function view($order_id=0){
		//未登录转登录页
		if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
				$this->redirect('/login/');
		}
		$this->page_init();
		
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(true,$this->locale);
        $this->set('systemresource_info',$systemresource_info);//资源库信息				
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
	   	   	      $my_messages[$k]['UserMessage']['type_name'] = $systemresource_info['msg_type']['0'];
	   	   }
	   	   else if($v['UserMessage']['msg_type'] == 1){
	   	   	      $my_messages[$k]['UserMessage']['type_name'] = $systemresource_info['msg_type']['1'];
	   	   }
	   	   else if($v['UserMessage']['msg_type'] == 2){
	   	   	      $my_messages[$k]['UserMessage']['type_name'] = $systemresource_info['msg_type']['2'];
	   	   }
	   	   else if($v['UserMessage']['msg_type'] == 3){
	   	   	      $my_messages[$k]['UserMessage']['type_name'] = $systemresource_info['msg_type']['3'];
	   	   }
	   	   else if($v['UserMessage']['msg_type'] == 4){
	   	   	      $my_messages[$k]['UserMessage']['type_name'] = $systemresource_info['msg_type']['4'];
	   	   }
	   	  else {
	   	   	      $my_messages[$k]['UserMessage']['type_name'] = $systemresource_info['msg_type']['5'];
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
}

?>