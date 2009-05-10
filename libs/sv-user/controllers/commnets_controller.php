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
 * $Id: commnets_controller.php 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
class CommnetsController extends AppController {

	var $name = 'Commnets';
    var $components = array ('Pagination'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array('Comment','Product');


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
	   $my_comments=$this->Comment->findAll($condition,'',"","$rownum",$page);
	   if(empty($my_comments)){
	   	   $my_comments=array();
	   }
	   foreach($my_comments as $k=>$v){
	   	   $this->Product->set_locale($this->locale);
	   	   $products=$this->Product->find("Product.id = '".$v['Comment']['type_id']."'");
	   	   $replies=$this->Comment->findAll("Comment.parent_id = '".$v['Comment']['id']."'");
	   	   $my_comments[$k]['Product']=$products['Product'];
	   	   $my_comments[$k]['ProductI18n']=$products['ProductI18n'];
	   	   $my_comments[$k]['Reply']=$replies;
	   }
		$js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']
				       		);
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