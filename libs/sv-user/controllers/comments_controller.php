<?php
/*****************************************************************************
 * SV-Cart 用户评论
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: commnets_controller.php 3282 2009-07-24 01:57:17Z shenyunfeng $
*****************************************************************************/
class CommentsController extends AppController {

	var $name = 'Comments';
    var $components = array ('Pagination'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array('Comment','Product','Article','Order','OrderProduct','ProductsCategory');


	function index(){
		//未登录转登录页
		if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
				$this->redirect('/login/');
		}
		$this->page_init();
		
		//当前位置
		$this->navigations[] = array('name'=>__($this->languages['my_comments'],true),'url'=>"");
		$this->set('locations',$this->navigations);
		
	    $user_id=$_SESSION['User']['User']['id'];
 	    //取商店设置评论显示数量
 	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	   //取得我的评论
	   //pr($_SESSION['User']);
	   $condition=" 1=1 and Comment.user_id=$user_id and Comment.parent_id = 0";
	   $total = $this->Comment->findCount($condition,0);
	   $sortClass='Comment';
	   $page=1;
	   $parameters=Array($rownum,$page);
	   $options=Array();
	   $page= $this->Pagination->init($condition,"",$options,$total,$rownum,$sortClass);
//	   $my_comments=$this->Comment->findAll($condition,'',"","$rownum",$page);
	   $my_comments=$this->Comment->find('all',array(
	   'fields' => array('Comment.id','Comment.type','Comment.type_id','Comment.title','Comment.parent_id','Comment.status','Comment.created','Comment.content'),
	   'conditions'=>array($condition),'limit'=>$rownum,'page'=>$page));
	
	 //  pr($my_comments);
	   if(empty($my_comments)){
	   	   $my_comments=array();
	   }
	   
	   $my_comments_id = array();
	   $p_ids = array();
	   $a_ids = array();
	   $p_ids[] = 0;
	   $a_ids[] = 0;
	   $my_comments_id[] = 0;	   
	   foreach($my_comments as $k=>$v){
	     	if($v['Comment']['type'] == "P"){
	   			$p_ids[] = $v['Comment']['type_id'];
	   		}else if($v['Comment']['type'] == "A"){
	   			$a_ids[] = $v['Comment']['type_id'];
	   		}
	   		$my_comments_id[] = $v['Comment']['id'];
	   }	   
	   
	   
  	   $this->Product->set_locale($this->locale);
  	   $this->Article->set_locale($this->locale);


	   $product_infos = $this->Product->find("all",array("conditions"=>array("Product.id"=>$p_ids)));
	   $products_list = array();
	   if(is_array($product_infos) && sizeof($product_infos) > 0){
	   		foreach($product_infos as $k=>$v){
	   			$products_list[$v['Product']['id']] = $v;
	   		}
	   }
	   $article_infos = $this->Article->find("all",array("conditions"=>array("Article.id"=>$a_ids)));
	   $articles_list = array();
	   if(is_array($article_infos) && sizeof($article_infos) > 0){
	   		foreach($article_infos as $k=>$v){
	   			$articles_list[$v['Article']['id']] = $v;
	   		}
	  }
		
	  $my_comments_replies = $this->Comment->find('all',array('conditions'=>array('Comment.parent_id'=>$my_comments_id)));
	  $replies_list =array();
	  if(is_array($my_comments_replies) && sizeof($my_comments_replies)>0){
	  		foreach($my_comments_replies as $kk=>$vv){
	  			$replies_list[$vv['Comment']['parent_id']][] = $vv;
	  		}
	  }
	  
//	  pr($replies_list);
	   foreach($my_comments as $k=>$v){
	   	   //$products=$this->Product->find("Product.id = '".$v['Comment']['type_id']."'");
	   	   if($v['Comment']['type'] == "P" && isset($products_list[$v['Comment']['type_id']])){
	   	   		$my_comments[$k]['Product']		= $products_list[$v['Comment']['type_id']]['Product'];
	   	   		$my_comments[$k]['ProductI18n'] =$products_list[$v['Comment']['type_id']]['ProductI18n'];
	   	   }else if($v['Comment']['type'] == "A" && isset($articles_list[$v['Comment']['type_id']])){
	   	   		$my_comments[$k]['Article']		=$articles_list[$v['Comment']['type_id']]['Article'];
	   	   		$my_comments[$k]['ArticleI18n'] =$articles_list[$v['Comment']['type_id']]['ArticleI18n'];
	   	   }
	   	   //$replies=$this->Comment->findAll("Comment.parent_id = '".$v['Comment']['id']."'");
	   	   if(isset($replies_list[$v['Comment']['id']])){
	   	   		$my_comments[$k]['Reply']=$replies_list[$v['Comment']['id']];
	   	   }
	   }
		$js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']);
		$this->set('js_languages',$js_languages);
	   $this->pageTitle = $this->languages['my_comments']." - ".$this->configs['shop_title'];
	   $this->set('total',$total);
	   $this->set('my_comments',$my_comments);
	}
//删除评论
function del_my_comments($comments_id){
	$this->Comment->del($comments_id);
	//显示的页面
	$this->redirect("/comments/");
}


	function product_comment($rownum='',$showtype="",$orderby=""){
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
			
			//products_ids_list
			if(!empty($products_ids_list)){
				$products_comment = $this->Comment->find('all',array('conditions'=>array('Comment.type_id'=>$products_ids_list,'Comment.type'=>'P',
														'Comment.user_id'=>$_SESSION['User']['User']['id'],'Comment.parent_id'=>0)
														,'fields' => array('Comment.id','Comment.type','Comment.type_id','Comment.title','Comment.parent_id','Comment.status','Comment.created','Comment.content')
															));
	 		  $my_comments_id[] = 0;	   
				if(isset($products_comment) && sizeof($products_comment)>0){
					foreach($products_comment as $k=>$v){
	   					$my_comments_id[] = $v['Comment']['id'];
					}
				}
	  			$my_comments_replies = $this->Comment->find('all',array('conditions'=>array('Comment.parent_id'=>$my_comments_id)));
				  $replies_list =array();
				  if(is_array($my_comments_replies) && sizeof($my_comments_replies)>0){
				  		foreach($my_comments_replies as $kk=>$vv){
				  			$replies_list[$vv['Comment']['parent_id']][] = $vv;
				  		}
				  }	
				$products_comment_list = array();
				if(isset($products_comment) && sizeof($products_comment)>0){
					foreach($products_comment as $k=>$v){
					   	  if(isset($replies_list[$v['Comment']['id']])){
					   	  	 $products_comment[$k]['Reply']=$replies_list[$v['Comment']['id']];
					   	  }						
						$products_comment_list[$v['Comment']['type_id']][] = $products_comment[$k];
					}
				}
				
			}
			$this->set('products_comment_list',$products_comment_list);
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