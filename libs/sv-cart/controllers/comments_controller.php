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
 * $Id: comments_controller.php 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
class CommentsController extends AppController {

	var $name = 'Comments';
//	var $helpers = array('Html');
	var $uses = array('Comment');
	var $components = array('RequestHandler');
 
//添加评论
	function add(){
		
		if($this->RequestHandler->isPost()){
			$status = 0;
			if(isset($this->configs['enable_user_comment_check']) && $this->configs['enable_user_comment_check'] == 0){
				$status = 1;
			}			
			
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
			if($this->Comment->save(array('Comment'=>$comment))){
				$result['type'] ="0";
				$result['message'] = $this->languages['add'].$this->languages['comments'].$this->languages['successfully'];

			}else{
				$result['type'] ="1";
				$result['message'] = $this->languages['add'].$this->languages['comments'].$this->languages['failed'];
			}

	   	}else{
				$result['type'] ="1";
				$result['message'] = $this->languages['invalid_operation'];
	   	}
	   	
	   	$this->set("result",$result);
		$this->layout="ajax";
	}
	

}

?>