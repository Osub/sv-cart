<?php
/*****************************************************************************
 * SV-Cart 评论
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: comments_controller.php 4512 2009-09-24 11:15:59Z huangbo $
*****************************************************************************/
class CommentsController extends AppController {

	var $name = 'Comments';
	var $helpers = array('Html','Pagination');
	var $uses = array('Comment','User','Cache');
	var $components = array('RequestHandler','Captcha','Pagination');
 
 
 	function index($page = 1){
    	$this->cacheQueries = true;
    	$this->cacheAction = "1 day";		
 		
		$this->page_init();
		
		//当前位置
		$this->navigations[] = array('name'=>__($this->languages['all'].$this->languages['comments'],true),'url'=>"");
		$this->set('locations',$this->navigations);
	   //取商店设置评论显示数量
 	   $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
 	   
	 	 if(isset($_GET['page'])){
	 	 	$page = $_GET['page'];
	 	 }else{
	 		 $_GET['page'] = $page;
	 	 } 	   
	   
	   $condition=" 1=1 and Comment.parent_id = '0' and Comment.status = '1'";
	   $my_comments=$this->Comment->find('all',array(
	   'order' => 'Comment.created DESC',
//	   'fields' => array('Comment.id','Comment.type','Comment.type_id','Comment.title','Comment.user_id','Comment.parent_id','Comment.status','Comment.created','Comment.content'),
	   'conditions'=>array($condition)));//,'limit'=>$rownum,'page'=>$page
	   if(empty($my_comments)){
	   	   $my_comments=array();
	   }
	   $my_comments_id = array();
	   $p_ids = array();
	   $a_ids = array();
	   $u_ids = array();
	   $p_ids[] = 0;
	   $u_ids[] = 0;
	   $a_ids[] = 0;
	   $my_comments_id[] = 0;	   
	   foreach($my_comments as $k=>$v){
	     	if($v['Comment']['type'] == "P"){
	   			$p_ids[] = $v['Comment']['type_id'];
	   		}else if($v['Comment']['type'] == "A"){
	   			$a_ids[] = $v['Comment']['type_id'];
	   		}
	   		$u_ids[] =  $v['Comment']['user_id'];
	   		$my_comments_id[] = $v['Comment']['id'];
	   	    $my_comments[$k]['Comment']['sub_content'] = $this->sub_str($v['Comment']['content'],60);
	   }	   
	   
  	   $this->Product->set_locale($this->locale);
  	   $this->Article->set_locale($this->locale);
	   $users = $this->User->find('all',array('conditions'=>array('User.id'=>$u_ids),'fields'=>array('User.id','User.name')));
	   $user_list = array();
	   if(isset($users) && sizeof($users)>0){
		  foreach($users as $k=>$v){
		  	 $user_list[$v['User']['id']] = $v;
		  }
	   }

	   $condition=array('Product.id'=>$p_ids);
	   $total = $this->Product->findCount($condition,0);
	   $sortClass='Product';
	   $page=1;
	   $parameters=Array($rownum,$page);
	   $options=Array();
	   $page= $this->Pagination->init($condition,"",$options,$total,$rownum,$sortClass);



	   $product_infos = $this->Product->find("all",array("conditions"=>array("Product.id"=>$p_ids),'limit'=>$rownum,'page'=>$page));
	   $products_list = array();
	   if(is_array($product_infos) && sizeof($product_infos) > 0){
	   		foreach($product_infos as $k=>$v){
	   			$products_list[$v['Product']['id']] = $v;
	   		}
	   }
	 /*  $article_infos = $this->Article->find("all",array("conditions"=>array("Article.id"=>$a_ids)));
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
	  */
	   foreach($my_comments as $k=>$v){
	   	   $arr_formate = $v;
	   	   if(isset($user_list[$v['Comment']['user_id']])){
	   	   	    $arr_formate['User'] =  $user_list[$v['Comment']['user_id']];
	  	   }
	   	   $products_list[$v['Comment']['type_id']]['comments'][] = $arr_formate;
	   	   unset($arr_formate);
	   	   /*$my_comments[$k]['Comment']['content'] = $this->sub_str($v['Comment']['content'],12);
	   	   if($v['Comment']['type'] == "P" && isset($products_list[$v['Comment']['type_id']])){
	   	   		$my_comments[$k]['Product']		= $products_list[$v['Comment']['type_id']]['Product'];
	   	   		$my_comments[$k]['ProductI18n'] =$products_list[$v['Comment']['type_id']]['ProductI18n'];
	   	   }else if($v['Comment']['type'] == "A" && isset($articles_list[$v['Comment']['type_id']])){
	   	   		$my_comments[$k]['Article']		=$articles_list[$v['Comment']['type_id']]['Article'];
	   	   		$my_comments[$k]['ArticleI18n'] =$articles_list[$v['Comment']['type_id']]['ArticleI18n'];
	   	   }*/

	   	   /*if(isset($replies_list[$v['Comment']['id']])){
	   	   $my_comments[$k]['Reply']=$replies_list[$v['Comment']['id']];
	   	  }*/
	   }
	 //  pr($products_list);
	$js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']);
			$this->set('js_languages',$js_languages);
		   $this->pageTitle = $this->languages['all'].$this->languages['comments']." - ".$this->configs['shop_title'];
		   $this->set('total',$total);
		   $this->set('my_comments',$my_comments);
//		pr($my_comments);exit;
 		$this->set('products_lists',$products_list);
    	$this->data['pages_url_1'] = $this->server_host.$this->cart_webroot."comments/index/";
    	$this->data['pages_url_2'] = "/"; 		
 		
 	}
 
//添加评论
	function add(){
		if($this->RequestHandler->isPost()){
			$result['message'] = $this->languages['add'].$this->languages['comments'].$this->languages['failed'];
			$status = 0;
			$no_error = 1;
			if(isset($this->configs['comment_captcha']) && $this->configs['comment_captcha'] == 1 && isset($_POST['captcha']) && $this->captcha->check($_POST['captcha']) == false){
				$no_error = 0;
				$result['message'] = $this->languages['verify_code'].$this->languages['not_correct'];
			}
			if(isset($this->configs['enable_user_comment_check']) && $this->configs['enable_user_comment_check'] == 0){
				$status = 1;
			}
			if(!isset($_POST['is_ajax'])){
				$comment = $_POST['data']['Comment'];
				$comment['ipaddr'] = $this->RequestHandler->getClientIP();
				$comment['status'] = $status;
				if($comment['email'] == "" || !$this->is_email($comment['email'])){
					$no_error = 0;
					$result['message'] = $this->languages['email_letter'].$this->languages['format'].$this->languages['not_correct'];
				}elseif($comment['rank'] == ""){
					$no_error = 0;
					$result['message'] = $this->languages['please_choose'].$this->languages['comment_rank'];
				}elseif($comment['content'] == ""){
					$no_error = 0;
					$result['message'] = $this->languages['comments'].$this->languages['can_not_empty'];
				}
			}else{
				$comment=array(
					'type'=>	isset($_POST['type'])   ? trim($_POST['type']): '',
					'type_id'=>	isset($_POST['id'])   ? intval($_POST['id'])  : 0,
					'email'=>	isset($_POST['email'])   ? trim($_POST['email'])  : '',
					'status'=>  $status,//评论是否要审核
					'content'=> isset($_POST['content'])   ? trim($_POST['content'])  : '',
					'user_id'=> isset($_POST['user_id'])   ? intval($_POST['user_id'])  : 0,
					'name'=> isset($_POST['username'])   ? trim($_POST['username'])  : '',
					'rank'=> isset($_POST['rank'])   ? intval($_POST['rank'])  : 0,
					'ipaddr'=>$this->RequestHandler->getClientIP()
					);			
			}
			if($no_error){
				$this->Comment->save(array('Comment'=>$comment));
				$result['type'] ="0";
				$result['message'] = $this->languages['add'].$this->languages['comments'].$this->languages['successfully'];
			}else{
				$result['type'] ="1";
			
			}
	   	}else{
				$result['type'] ="1";
				$result['message'] = $this->languages['invalid_operation'];
	   	}
		if(!isset($_POST['is_ajax'])){
			$this->page_init();
			$id = isset($comment['type_id'])?$comment['type_id']:'';
			$url = ($comment['type_id'] == "P")?"/products/":"/articles/";
			$this->pageTitle = isset($result['message'])?$result['message']:''." - ".$this->configs['shop_title'];;
			$this->flash(isset($result['message'])?$result['message']:'',$url.$id,10);					
		}	   	
	   	
	   	$this->set("result",$result);
		$this->layout="ajax";
	}
	
	function is_email($user_email)
	{
	    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
	    if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false)
	    {
	        if (preg_match($chars, $user_email))
	        {
	            return true;
	        }
	        else
	        {
	            return false;
	        }
	    }
	    else
	    {
	        return false;
	    }
	}
	
	function sub_str2($str, $length = 0, $append = true)
	{
	    $str = trim($str);
	    $strlength = strlen($str);

	    if ($length == 0 || $length >= $strlength)
	    {
	        return $str;
	    }
	    elseif ($length < 0)
	    {
	        $length = $strlength + $length;
	        if ($length < 0)
	        {
	            $length = $strlength;
	        }
	    }

	    if (function_exists('mb_substr'))
	    {
	        $newstr = mb_substr($str, 0, $length, 'utf-8');
	    }
	    elseif (function_exists('iconv_substr'))
	    {
	        $newstr = iconv_substr($str, 0, $length, 'utf-8');
	    }
	    else
	    {
	        //$newstr = trim_right(substr($str, 0, $length));
	        $newstr = substr($str, 0, $length);
	    }

	    if ($append && $str != $newstr)
	    {
	        $newstr .= '...';
	    }
	    return $newstr;	

	}		
	
function sub_str($string, $length, $dot = ' ...') {
	global $charset;
	$oldstr = strlen($string) ;
	if(strlen($string) <= $length) {
		return $string;
	}

	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	    if (function_exists('mb_substr'))
	    {
	        $string = mb_substr($string, 0, $length, 'utf-8');
	        $charset = 'utf-8';
	    }
	    elseif (function_exists('iconv_substr'))
	    {
	        $string = iconv_substr($string, 0, $length, 'utf-8');
	        $charset = 'utf-8';
	    }
	$strcut = '';
	if(strtolower($charset) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < strlen($string)) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}

	$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	if($oldstr > strlen($strcut)){
			return $strcut.$dot;
	}
	
	return $strcut;
}	
	

}

?>