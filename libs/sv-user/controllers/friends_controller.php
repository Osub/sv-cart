<?php
/*****************************************************************************
 * SV-Cart 用户中心我的好友
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: friends_controller.php 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
uses('sanitize');		
class FriendsController extends AppController {

	var $name = 'Friends';
	var $components = array ('RequestHandler'); // Added 
	var $helpers = array('Html');
	var $uses = array("UserFriend","UserFriendCat","Region");
/*------------------------------------------------------ */
//-- 我的好友
/*------------------------------------------------------ */
	function index(){
		   //未登录转登录页
		   if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
				$this->redirect('/login/');
		    }
		      $this->page_init();
		      //当前位置
		      $this->navigations[] = array('name'=>__($this->languages['my_friends'],true),'url'=>"");
		      $this->set('locations',$this->navigations);
		      
		   if($this->RequestHandler->isPost()){
			       //pr($this->params);
			       $this->page_init();
			       //新增指定分组的好友
				   $mrClean = new Sanitize();		
                   if(isset($this->params['form']['action_type']) && $this->params['form']['action_type'] == 'insert_contact'){
	          			   $this->pageTitle = $this->languages['add'].$this->languages['successfully']." - ".$this->configs['shop_title'];
	          			       				       $this->UserFriend->save($this->data['UserFriend']);
    			           $this->redirect("/friends/");
    			           //$this->flash($this->languages['add'].$this->languages['successfully'],'../friends','');
			        }
			        //编辑指定分组的好友
			        if(isset($this->params['form']['action_type']) && $this->params['form']['action_type'] == 'edit_contact'){
	          $this->pageTitle = $this->languages['edit'].$this->languages['successfully']." - ".$this->configs['shop_title']; 
	          
    				       $this->UserFriend->save($this->data['UserFriend']);
    			               			            	    $this->redirect("/friends/");

    			           //$this->flash($this->languages['edit'].$this->languages['successfully'],'../friends','');
			         }
			         //增加分组
			         if(isset($this->params['form']['action_type']) && $this->params['form']['action_type'] == 'insert_cat'){
	          $this->pageTitle = $this->languages['edit'].$this->languages['successfully']." - ".$this->configs['shop_title'];
			         	    $this->UserFriendCat->save($this->data['UserFriendCat']);
    			            	    $this->redirect("/friends/");

    			            //$this->flash($this->languages['edit'].$this->languages['successfully'],'../friends','');
			         }
		      }
		      
	          $user_id=$_SESSION['User']['User']['id'];
	          //取得所有好友的分类列表
	          $friend_cat_list=$this->UserFriendCat->findAll(" user_id='".$user_id."' ");
	          //取得所有的好友
	          $friend_list=$this->UserFriend->findAll(" user_id='".$user_id."' ");
	          if(isset($friend_list)){
	          $this->set('friend_num',sizeof($friend_list));
	          }
	          //pr($friend_cat_list);
	          foreach($friend_cat_list as $k=>$v){
	  	            $this->data[$v['UserFriendCat']['id']]=$v;
	  	            $this->data[$v['UserFriendCat']['id']]['user']=array();
	  	            $this->data[$v['UserFriendCat']['id']]['count']=0;
	          }
	          foreach($friend_list as $k=>$v){
	  	            $this->data[$v['UserFriend']['cat_id']]['user'][$v['UserFriend']['id']]=$v;
	  	            $this->data[$v['UserFriend']['cat_id']]['count']=count($this->data[$v['UserFriend']['cat_id']]['user']);
	           }
			  $js_languages = array("group_name_can_not_empty" => $this->languages['group'].$this->languages['apellation'].$this->languages['can_not_empty'],
			  	  					"friend_name_not_empty" => $this->languages['friend'].$this->languages['name'].$this->languages['can_not_empty'],
			  	  					"invalid_email" => $this->languages['email'].$this->languages['format'].$this->languages['not_correct'],
			  	  					"address_detail_not_empty" => $this->languages['address'].$this->languages['can_not_empty'],
			  	  					"invalid_tel_number" => $this->languages['telephone'].$this->languages['format'].$this->languages['not_correct'],
			  	  					"friends_in_group_not_cancelled" => $this->languages['friends_in_group_not_cancelled']
				       				);
			  $this->set('js_languages',$js_languages);	         
	          $this->pageTitle = $this->languages['my_friends']." - ".$this->configs['shop_title'];
	          $this->set('friend_cat_list',$friend_cat_list);
	          $this->set('user_id',$user_id);
	}

/*------------------------------------------------------ */
//-- 删除好友
/*------------------------------------------------------ */
   function del_friends($friend_id){
 	    $this->UserFriend->del($friend_id);
	    //显示的页面
	    $this->redirect("/friends/");
    }

/*------------------------------------------------------ */
//-- 修改分组名称
/*------------------------------------------------------ */
   function modifycat($cat_id,$new_name){
   	   	$new_name = UrlDecode($new_name);
	    $cat_info=array(
		 	  'id'=>	isset($cat_id)   ? intval($cat_id)  : 0 ,
	     	  'cat_name'=>	isset($new_name)   ? trim($new_name)  : ''
		);
	   $this->UserFriendCat->save(array('UserFriendCat'=>$cat_info));

   	   $this->layout="ajax";
   }

/*------------------------------------------------------ */
//-- 删除分组
/*------------------------------------------------------ */
   function del_cat($cat_id){
	    $this->UserFriendCat->del($cat_id);
	    //显示的页面
	    $this->redirect("/friends/");
   }

   function add_cat(){
	   		$result['type'] = 2;
	   		$result['msg'] = $this->languages['add'].$this->languages['failed'];
		if(isset($_SESSION['User']['User'])){
			$result['type'] = 0;
			if($this->RequestHandler->isPost()){
			   $cat = array(
			   				'id' => '',
			   				'cat_name'=> $_POST['cat_name'],
			   				'user_id' => $_POST['user_id']
			   				);
			   $result['msg'] = $this->languages['add'].$this->languages['successfully'];
			   $this->UserFriendCat->save($cat);

   	   		}
   	   	}
   	   $this->set('result',$result);
   	   $this->layout="ajax";
   }


	function recommend(){
		$result['type'] = 2;
		if(isset($_SESSION['User']['User'])){
			if($this->RequestHandler->isPost()){
			$result['type'] = 0;
			
			
			}
		}else{
			$result['msg'] = $this->languages['please_login'];
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}

	function new_group(){
		$result['type'] = 2;
		if(isset($_SESSION['User']['User'])){
			if($this->RequestHandler->isPost()){
				$result['type'] = 0;
				$this->set('user_id',$_SESSION['User']['User']['id']);
			}
		}else{
			$result['msg'] = $this->languages['please_login'];
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
}

?>