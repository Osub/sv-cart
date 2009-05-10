<?php
/*****************************************************************************
 * SV-Cart 支付响应页面
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: responds_controller.php 1201 2009-05-05 13:30:17Z huangbo $
*****************************************************************************/
class RespondsController extends AppController {
	var $name = 'Responds';
	var $helpers = array('Html','Flash','Svcart');
	var $uses = array('Product','Flash','Payment','Order','UserBalanceLog','UserPointLog','PaymentApiLog','User','UserAccount','OrderProduct','Coupon','CouponType');
	
	function index($code){
		$this->pageTitle = $this->languages['payment_result']." - ".$this->configs['shop_title'];
		/* start */
		if($code == 'alipay'){
			$pay = $this->Payment->findbycode($code);
			eval($pay['Payment']['php_code']);   
			$pay_class = new alipay();	
			if($pay_class->respond($this)){
				$msg = $this->languages['successfully'];
			}else{
				$fail = 1;
				$msg = $this->languages['failed'];
				$this->set('fail',$fail);
			}
		}
		if($code == 'paypalcn'){
			$pay = $this->Payment->findbycode($code);
			eval($pay['Payment']['php_code']);   
			$pay_class = new paypal();	
			if($pay_class->respond($this)){
				$msg = "支付成功";
			}else{
				$msg = "支付失败";
			}	
		}
		if($code == 'paypal'){
			$pay = $this->Payment->findbycode($code);
			eval($pay['Payment']['php_code']);   
			$pay_class = new paypal();	
			if($pay_class->respond($this)){
				$msg = "支付成功";
			}else{
				$msg = "支付失败";
			}	
		}		
		/* end */
		$this->set('msg',$msg);
		$this->set('languages',$this->locale);
		$this->page_init();
		$this->set('categories_tree',$categories_tree = array());
		$this->set('brands',$brands = array());
		$this->layout = 'default_full';
	}
}
?>