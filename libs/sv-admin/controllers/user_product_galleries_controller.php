<?php
/*****************************************************************************
 * SV-Cart 用户管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: votes_controller.php 3179 2009-07-22 05:09:18Z zhengli $
*****************************************************************************/
class UserProductGalleriesController extends AppController {

	var $name = 'UserProductGalleries';
    var $components = array ('Pagination','RequestHandler');
    var $helpers = array('Pagination');
	var $uses = array("UserProductGallery","Product");
	
	function index($status="all",$date="all",$date2="all",$product_code="",$user_name=""){
		/*判断权限*/
		$this->operator_privilege('user_galleries_view');
		/*end*/
	   	$this->pageTitle = "会员相册" ." - ".$this->configs['shop_name'];
	   	$this->navigations[] = array('name'=>'客户管理','url'=>'');
		$this->navigations[] = array('name'=>'会员相册','url'=>'/votes/');
		$this->set('navigations',$this->navigations);
	  	$condition='';
   	    if(isset($this->params['url']['status']) && !empty($this->params['url']['status'])&&$this->params['url']['status']!="all"){
   	    		$condition["UserProductGallery.status"] =$status;
	    }

   	    if($status!="all"){
   	    		$condition["and"]["UserProductGallery.status"] =$status;
	    }
   	    if($date!="all"){
   	    		$condition["and"]["UserProductGallery.created >="] =$date;
	    }
   	    if($date2!="all"){
   	    		$condition["and"]["UserProductGallery.created <="] =$date2;
	    }
		if($product_code != ""){
			$condition["and"]["Product.code like"] ="%".$product_code."%";
		}
		if($user_name != ""){
			$condition["and"]["User.name like"] ="%".$user_name."%";
		}
	    
		$total = $this->UserProductGallery->findCount($condition,0);
		$sortClass='UserProductGallery';
		$page=1;
		$rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$parameters=Array($rownum,$page);
		$options=Array();
		$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);

		$userproductgalleries_data = $this->UserProductGallery->find("all",array("conditions"=>$condition,"limit"=>$rownum,"page"=>$page));
		$product_id[] = 0;
		foreach( $userproductgalleries_data as $k=>$v ){
			$product_id[] = $v["UserProductGallery"]["product_id"];
		}
		$this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 )			            						
                 	   );
    	$this->Product->set_locale($this->locale);
		$product_info = $this->Product->find("all",array("conditions"=>array("Product.id"=>$product_id)));
		$product_list = array();
		foreach( $product_info as $k=>$v ){
			$product_list[$v["Product"]["id"]] = $v;
		}
		$this->set("userproductgalleries_data",$userproductgalleries_data);
		$this->set("product_list",$product_list);
		$this->set("status",$status);
		$this->set("product_code",$product_code);
		$this->set("user_name",$user_name);
		$this->set("date",$date=="all"?"":$date);
		$this->set("date2",$date2=="all"?"":$date2);
	
	
	}
	function effective($id){
		$this->UserProductGallery->updateAll(
			array("UserProductGallery.status"=>1),
			array("UserProductGallery.id"=>$id)
		);
		die();
	}
	function invalid($id){
		$this->UserProductGallery->updateAll(
			array("UserProductGallery.status"=>0),
			array("UserProductGallery.id"=>$id)
		);
		die();
	}
	function remove($id){
		$this->UserProductGallery->del($id);
		die();
	}
}

?>