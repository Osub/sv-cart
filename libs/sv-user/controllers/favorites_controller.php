<?php
/*****************************************************************************
 * SV-Cart 用户收藏
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: favorites_controller.php 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
class FavoritesController extends AppController {
	var $name = 'Favorites';
//	var $helpers = array('Html');
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers = array('Html','Pagination'); // Added 
	var $uses = array("User","UserFavorite","Category","Brand","Product","Cart");

	//添加收藏
	function add(){
		$result['type'] = 2;
		$result['message'] = $this->languages['invalid_operation'];
		if($this->RequestHandler->isPost()){
			if(isset($_SESSION['User'])){
				$type=$_POST['type'];
				$type_id=$_POST['type_id'];
				
				if(!isset($_SESSION['User'])){
					$result['type'] = 1;
					$result['message'] = $this->languages['only for membership users to keep,only_member_keep'];
				}else{

					$condition = " user_id = '".$_SESSION['User']['User']['id']."' and type = '".$type."' and type_id = '".$type_id."'";
					if($this->UserFavorite->findcount($condition)){
						$result['type'] = 1;
						$result['message'] = $this->languages['Already_favorite'];
					}else{
						$favorite=array("user_id"=>intval($_SESSION['User']['User']['id']),'type'=>trim($type),'type_id'=>intval($type_id),'status'=>1);
						$this->UserFavorite->save($favorite);
						$result['type'] = 0;
						$result['message'] = $this->languages['add_to_favorite'];
					}
				}
			}else{
				$result['type'] = 1;
				$result['message'] = $this->languages['time_out_relogin'];
			}
		}
		
		$this->set('result',$result);
		$this->layout = 'ajax';
	}

/*------------------------------------------------------ */
//-- 我的收藏
/*------------------------------------------------------ */
	function index($rownum='',$showtype="",$orderby=""){
		$orderby = UrlDecode($orderby);
		$rownum = UrlDecode($rownum);
		$showtype = UrlDecode($showtype);
		//未登录转登录页
		if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
				$this->redirect('/login/');
		}
		$this->page_init();
		
		//当前位置
		$this->navigations[] = array('name'=>__($this->languages['my_favorite'],true),'url'=>"");
		$this->set('locations',$this->navigations);
		
		 	$rownum=isset($this->configs['products_list_num']) ? $this->configs['products_list_num']:((!empty($rownum)) ?$rownum:20);

		 	$showtype=isset($this->configs['products_list_showtype']) ? $this->configs['products_list_showtype']:((!empty($showtype)) ?$showtype:'L');

			if(empty($orderby)){
		 		$orderby=isset($this->configs['products_category_page_orderby_type'])? $this->configs['products_category_page_orderby_type']." ". $this->configs['products_category_page_orderby_method'] :((!empty($orderby)) ?$orderby:'created '.$this->configs['products_category_page_orderby_method']);
			}
	  $user_id=$_SESSION['User']['User']['id'];
	   //pr($_SESSION['User']);

      /***************我收藏的商品*************/
	  $condition=" type = 'p' and user_id=$user_id ";
	  $res_p=$this->UserFavorite->findAll($condition);
	  foreach($res_p as $k=>$v){
	     $products_id[$k]=$v['UserFavorite']['type_id'];
	  }
	  $this->Product->set_locale($this->locale);
	  if(!empty($products_id)){
	  	 $condition = array("Product.id"=>$products_id," status ='1'");
	  	 $total = $this->Product->findCount($condition,0);
 	     $sortClass='Product';
	     $page=1;
	     $parameters=Array($orderby,$rownum,$page);
	     $options=Array();
	     $page= $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
	  	  //$this->Product->set_locale($this->locale);
	  	  $fav_products=$this->Product->findAll($condition,'',"Product.$orderby","$rownum",$page);
	     }
	  else{
	  	  $fav_products=array();
	  }
	  $fav_products_count=count($fav_products);
	  //一步购买
	  if(!empty($this->configs['enable_one_step_buy']) && $this->configs['enable_one_step_buy'] == 1){
					$js_languages = array("enable_one_step_buy" => "1","page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']);
					$this->set('js_languages',$js_languages);
		}else{
					$js_languages = array("enable_one_step_buy" => "0","page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']);
					$this->set('js_languages',$js_languages);
	  }
	  
	  $this->pageTitle = $this->languages['my_favorite']." - ".$this->configs['shop_title'];
	  $this->set('fav_products',$fav_products);
	  $this->set('fav_products_count',$fav_products_count);
	  $this->set('user_id',$user_id);
	  //排序方式,显示方式,分页数量限制
	  $this->set('orderby',$orderby);
	  $this->set('rownum',$rownum);
	  $this->set('showtype',$showtype);
	}
/*------------------------------------------------------ */
//-- 删除收藏商品
/*------------------------------------------------------ */
	function del_products_t($type_id,$user_id,$type){
		$condition = " type_id='".$type_id."' and user_id='".$user_id."' and type='".$type."'";
		$fav_product_info=$this->UserFavorite->find($condition);
		$id=$fav_product_info['UserFavorite']['id'];
		$this->UserFavorite->del($id);
		//显示的页面
		$this->redirect("/favorites/");
	}

}

?>