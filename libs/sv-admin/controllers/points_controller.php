<?php
/*****************************************************************************
 * SV-Cart 积分日志
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: points_controller.php 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
class PointsController extends AppController {

	var $name = 'Points';
	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("UserPointLog","PaymentApiLog","User","Order");

	function index(){
		$this->pageTitle = "积分日志"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'积分日志','url'=>'/points/');
		$this->set('navigations',$this->navigations);
		$condition='';
		/* 类型 */
		if(isset($this->params['url']['log_type']) && $this->params['url']['log_type'] != ''){
	   	   	$condition['and']['log_type ='] = $this->params['url']['log_type'];
			$this->set('log_type',$this->params['url']['log_type']);
	   	}
	   	/* 用户名 */
		if(isset($this->params['url']['name']) && $this->params['url']['name'] != ''){
	   	   	$wh['name like'] = "%".$this->params['url']['name']."%";
			$user = $this->User->findAll($wh);
			foreach( $user as $k=>$v ){
				$condition['or'][]['user_id'] = $user[$k]['User']['id'];
			}
			$this->set('names',$this->params['url']['name']);
	   	}
	   	/* 用户id */
		if(isset($this->params['url']['user_id']) && $this->params['url']['user_id'] != ''){
			$condition['and']['user_id'] = $this->params['url']['user_id'];
	   	}
	   	/* 开始时间 */
		if(isset($this->params['url']['start_time']) && $this->params['url']['start_time'] != ''){
	   	   $condition['and']['modified >='] = $this->params['url']['start_time'];
	   	   $this->set('start_time',$this->params['url']['start_time']);
	   	}
	   	else {
	   	   $condition['and']['modified >='] = date('Y-m-d');
	   	   $this->set('start_time',date('Y-m-d'));
	   	}
	   	/* 结束时间 */
	   	if(isset($this->params['url']['end_time']) && $this->params['url']['end_time'] != ''){
	   	   $condition['and']['modified <='] = $this->params['url']['end_time']." 23:59:59";
	   	   $this->set('end_time',$this->params['url']['end_time']);
	   	}
	   	else {
	   	   $condition['and']['modified <='] = date('Y-m-d')." 23:59:59";
	   	   $this->set('end_time',date('Y-m-d'));
	   	}
	   	/* post */
		if($this->RequestHandler->isPost()){
			if( $this->data['point']['name']!="" ){
				$wh['name like'] = "%".$this->data['point']['name']."%";
			 	$user = $this->User->findAll($wh);
			 	foreach( $user as $k=>$v ){
			 		$condition['or'][]['user_id'] = $user[$k]['User']['id'];
			 	}
		 	}
		 	if( $this->data['point']['end_time']!="" ){
		 		$condition['and']['modified <='] = $this->data['point']['end_time'];
		 	}	
		 	if( $this->data['point']['start_time']!="" ){
		 		$condition['and']['modified >='] = $this->data['point']['start_time']." 23:59:59";
		 	}
		}
		
		/* 分页 */
   	    $total = $this->UserPointLog->findCount($condition,0);
	    $sortClass='UserPointLog';
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters=Array($rownum,$page);
	    $options=Array();
		$page  = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
	    /* 列表 */
		$UserPointLog_list = $this->UserPointLog->findAll($condition,'',"UserPointLog.modified desc",$rownum,$page);
		
		foreach( $UserPointLog_list as $k=>$v ){
			/* 用户名 */
			$user_id = $UserPointLog_list[$k]['UserPointLog']['user_id'];
			$User = $this->User->findById($user_id);	
			$UserPointLog_list[$k]['UserPointLog']['name'] = $User['User']['name'];
			/* 订单号 */
			$Order = $this->Order->findById($v['UserPointLog']['type_id']);
			$UserPointLog_list[$k]['UserPointLog']['order_code'] = $Order['Order']['order_code'];
			/* 类型名 */
			if($v['UserPointLog']['log_type'] == "a"){
				$UserPointLog_list[$k]['UserPointLog']['log_type'] = "注册赠送";
			}
			else if($v['UserPointLog']['log_type'] == "b"){
				$UserPointLog_list[$k]['UserPointLog']['log_type'] = "购买赠送";
			}
			else if($v['UserPointLog']['log_type'] == "c"){
				$UserPointLog_list[$k]['UserPointLog']['log_type'] = "购买消费";
			}
			else if($v['UserPointLog']['log_type'] == "d"){
				$UserPointLog_list[$k]['UserPointLog']['log_type'] = "推荐注册赠送";
			}
			else if($v['UserPointLog']['log_type'] == "e"){
				$UserPointLog_list[$k]['UserPointLog']['log_type'] = "推荐购买赠送";
			}
			else if($v['UserPointLog']['log_type'] == "f"){
				$UserPointLog_list[$k]['UserPointLog']['log_type'] = "管理员增加";
			}
			else if($v['UserPointLog']['log_type'] == "g"){
				$UserPointLog_list[$k]['UserPointLog']['log_type'] = "管理员扣除";
			}
			else $UserPointLog_list[$k]['UserPointLog']['log_type'] = "其他";
		}
	   	$this->set('UserPointLog_list',$UserPointLog_list);
	}
}

?>