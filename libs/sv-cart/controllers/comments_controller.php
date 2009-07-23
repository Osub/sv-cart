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
 * $Id: comments_controller.php 2761 2009-07-10 09:06:59Z shenyunfeng $
*****************************************************************************/
class CommentsController extends AppController {

	var $name = 'Comments';
//	var $helpers = array('Html');
	var $uses = array('Comment');
	var $components = array('RequestHandler','Captcha');
 
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

}

?>