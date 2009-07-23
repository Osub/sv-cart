<?php
/*****************************************************************************
 * SV-Cart 用户优惠券
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: coupons_controller.php 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/
class CouponsController extends AppController {

	var $name = 'Coupons';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array("Coupon","Order","User","CouponType");


	function index(){
		//未登录转登录页
		if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
			 $this->redirect('/login/');
		}
	    $user_id=$_SESSION['User']['User']['id'];
		$this->page_init();
		$this->pageTitle = $this->languages['coupon']." - ".$this->configs['shop_title'];
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$coupons = $this->Coupon->findall("Coupon.user_id = ".$user_id." and Coupon.order_id = 0",'',"Coupon.created DESC","$rownum",$page);
			$cache_key = md5('find_coupon_types'.'_'.$this->locale);
			$coupon_types_list = cache::read($cache_key);	
			if(!$coupon_types_list){	
				$coupon_type_arr = $this->CouponType->findall();
				$coupon_types_list = array();
				if(is_array($coupon_type_arr) && sizeof($coupon_type_arr)>0){
					foreach($coupon_type_arr as $k=>$v){
						$coupon_types_list[$v['CouponType']['id']] = $v;
					}
				}
				
				cache::write($cache_key,$coupon_types_list);	
			}
	
		if(is_array($coupons) && sizeof($coupons)>0){
			$this->CouponType->set_locale($this->locale);
			foreach($coupons as $k=>$v){
				if($v['Coupon']['order_id'] == 0){
				//$coupon_type = $this->CouponType->findbyid($v['Coupon']['coupon_type_id']);
				$coupon_type = $coupon_types_list[$v['Coupon']['coupon_type_id']];
			
				$coupons[$k]['Coupon']['name'] = $coupon_type['CouponTypeI18n']['name'];
				$coupons[$k]['Coupon']['use_end_date'] = substr($coupon_type['CouponType']['use_end_date'],0,10);
				$coupons[$k]['Coupon']['min_amount'] = $coupon_type['CouponType']['min_amount'];
				$coupons[$k]['Coupon']['fee'] = $coupon_type['CouponType']['money'];
				$coupons[$k]['Coupon']['is_use'] = 0;
				}else{
					unset($coupons[$k]['Coupon']);
				}
			}
		}
		$total = count($coupons);
	    $sortClass='Coupon';

	    $parameters=Array($rownum,$page);
	    $options=Array();
	    $condition = "Coupon.user_id = ".$user_id." and  Coupon.order_id = 0";
	    $page= $this->Pagination->init($condition,"",$options,$total,$rownum,$sortClass);
		$this->set('coupons',$coupons);
		
		
		
		
		//当前位置
	   $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist'] ,
	   						"recharge_amount_not_empty" => $this->languages['supply'].$this->languages['amount'].$this->languages['can_not_empty'],
							"coupon_not_empty" => $this->languages['coupon'].$this->languages['can_not_empty'],					
	   						"no_choose_payment_method" => $this->languages['please_choose'].$this->languages['payment']);
	   $this->set('js_languages',$js_languages);		
		
		$this->navigations[] = array('name'=>__($this->languages['coupon'],true),'url'=>"");
		$this->set('locations',$this->navigations);
	   
	  
	}
	
	function add_coupon(){
		$result['type'] = 1;
		if($this->RequestHandler->isPost()){
			if(isset($_SESSION['User']['User']['id'])){
				$coupon = $this->Coupon->findbysn_code($_POST['sn_code']);
				if(isset($coupon['Coupon'])){
					$this->CouponType->set_locale($this->locale);
					$coupon_type = $this->CouponType->findbyid($coupon['Coupon']['coupon_type_id']);
					if($coupon_type['CouponType']['send_type'] == 3 && $coupon['Coupon']['user_id'] ==0 && $coupon['Coupon']['order_id'] ==0){
						$coupon['Coupon']['user_id'] = $_SESSION['User']['User']['id'];
	 					$result['msg'] = $this->languages['add'].$this->languages['coupon'].$this->languages['successfully'];
						$this->Coupon->save($coupon['Coupon']);
						$result['type'] = 0;					
					}else{
	 					$result['msg'] = $this->languages['coupon'].$this->languages['not_correct'];
					}
				}else{
	 				$result['msg'] = $this->languages['coupon'].$this->languages['not_correct'];
				}
			}else{
				$result['msg']=$this->languages['time_out_relogin'];
			}
		}
		if(!isset($_POST['is_ajax'])){
		    $this->page_init();
			$this->pageTitle = "".$result['msg']."";
			$flash_url = $this->server_host.$this->user_webroot."coupons";			
		    $this->flash($result['msg'],$flash_url,10);	
		}
		$this->set('result',$result);
		$this->layout = 'ajax';		
		
	}
	
	function used(){
		//未登录转登录页
		if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
			 $this->redirect('/login/');
		}
	    $user_id=$_SESSION['User']['User']['id'];
		$this->page_init();
		$this->pageTitle = $this->languages['coupon']." - ".$this->configs['shop_title'];
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		if(isset($_POST['coupon_sn'])){
			$coupons = $this->Coupon->findall("Coupon.user_id = ".$user_id." and Coupon.order_id > '0' and Coupon.sn_code =".$_POST['coupon_sn'],'',"Coupon.created DESC","$rownum",$page);
		}else{
			$coupons = $this->Coupon->findall("Coupon.user_id = ".$user_id." and Coupon.order_id > '0'",'',"Coupon.created DESC","$rownum",$page);
		}
		
		$cache_key = md5('find_coupon_types'.'_'.$this->locale);
			$coupon_types_list = cache::read($cache_key);	
			if(!$coupon_types_list){	
				$coupon_type_arr = $this->CouponType->findall();
				$coupon_types_list = array();
				if(is_array($coupon_type_arr) && sizeof($coupon_type_arr)>0){
					foreach($coupon_type_arr as $k=>$v){
						$coupon_types_list[$v['CouponType']['id']] = $v;
					}
				}
				
				cache::write($cache_key,$coupon_types_list);	
			}
			
		$orderid_list = array();
		if(is_array($coupons) && sizeof($coupons)>0){
			$this->CouponType->set_locale($this->locale);
			foreach($coupons as $k=>$v){
				if($v['Coupon']['order_id'] > 0){
				//$coupon_type = $this->CouponType->findbyid($v['Coupon']['coupon_type_id']);
				$coupon_type = $coupon_types_list[$v['Coupon']['coupon_type_id']];
				$orderid_list[] = $v['Coupon']['order_id'];
				$coupons[$k]['Coupon']['name'] = $coupon_type['CouponTypeI18n']['name'];
				$coupons[$k]['Coupon']['use_end_date'] = substr($coupon_type['CouponType']['use_end_date'],0,10);
				$coupons[$k]['Coupon']['min_amount'] = $coupon_type['CouponType']['min_amount'];
				$coupons[$k]['Coupon']['fee'] = $coupon_type['CouponType']['money'];
				$coupons[$k]['Coupon']['is_use'] = 1;
			}
		}
		if(!empty($orderid_list)){
			$orders = $this->Order->find('all',array('conditions'=>array('Order.id'=>$orderid_list),'fields'=>array('Order.id','Order.order_code','Order.total')));
		}
		$order_lists = array();
		if(isset($orders) && sizeof($orders)>0){
			foreach($orders as $k=>$v){
				$order_lists[$v['Order']['id']] = $v;
			}
		}
		$total = count($coupons);
	    $sortClass='Coupon';

	    $parameters=Array($rownum,$page);
	    $options=Array();
	    $condition = "Coupon.user_id = ".$user_id." and  Coupon.order_id > '0'";
	    $page= $this->Pagination->init($condition,"",$options,$total,$rownum,$sortClass);
	   	$this->set('coupons',$coupons);
		$this->set('order_lists',$order_lists);
		
		
		
		
		//当前位置
	   $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist'] ,
	   						"recharge_amount_not_empty" => $this->languages['supply'].$this->languages['amount'].$this->languages['can_not_empty'],
							"coupon_not_empty" => $this->languages['coupon'].$this->languages['can_not_empty'],					
	   						"no_choose_payment_method" => $this->languages['please_choose'].$this->languages['payment']);
	   $this->set('js_languages',$js_languages);		
		
		$this->navigations[] = array('name'=>__($this->languages['coupon'],true),'url'=>"");
		$this->set('locations',$this->navigations);
	   
	  
	}
	
	
	
	
}
}
?>