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
 * $Id: commnets_controller.php 3134 2009-07-21 06:45:45Z huangbo $
*****************************************************************************/
class CommnetsController extends AppController {

	var $name = 'Commnets';
    var $components = array ('Pagination'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array('Comment','Product','Article');


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
}

?>