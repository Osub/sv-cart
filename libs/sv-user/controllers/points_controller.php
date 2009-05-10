<?php
/*****************************************************************************
 * SV-Cart 用户积分
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: points_controller.php 1201 2009-05-05 13:30:17Z huangbo $
*****************************************************************************/
class PointsController extends AppController {

	var $name = 'Points';
    var $components = array ('Pagination'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array("UserPointLog","Order","User");


	function index(){
		//未登录转登录页
		if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
			 $this->redirect('/login/');
		}
		$this->page_init();
		
		//当前位置
		$this->navigations[] = array('name'=>__($this->languages['points'],true),'url'=>"");
		$this->set('locations',$this->navigations);
		//pr($this->params);
	    $user_id=$_SESSION['User']['User']['id'];
	   //pr($_SESSION['User']);
	   //我的积分使用情况
	   $condition=" user_id = '".$user_id."'";
	   if(isset($this->params['url']['date']) && $this->params['url']['date'] != ''){
	   	   $condition .=" and created  >= '".$this->params['url']['date']."'";
	   }
	   if(isset($this->params['url']['date2']) && $this->params['url']['date2'] != ''){
	   	   $condition .=" and created  <= '".$this->params['url']['date2']."'";
	   }
	   if(isset($this->params['url']['min_points']) && $this->params['url']['min_points'] != ''){
	   	   $condition .=" and point >= '".$this->params['url']['min_points']."'";
	   }
	   if(isset($this->params['url']['max_points']) && $this->params['url']['max_points'] != ''){
	   	   $condition .=" and point <= '".$this->params['url']['max_points']."'";
	   }
	   $total = $this->UserPointLog->findCount($condition,0);
	   $sortClass='UserPointLog';
	   $page=1;
	   $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	   $parameters=Array($rownum,$page);
	   $options=Array();
	   $page= $this->Pagination->init($condition,"",$options,$total,$rownum,$sortClass);
	   $my_points=$this->UserPointLog->findAll($condition,'','','',$page);
	   foreach($my_points as $k=>$v){
	   	   $condition=" id = '".$v['UserPointLog']['type_id']."'";
	   	   $my_points[$k]['Order']=$this->Order->find($condition);
	   }
	   $user_info = $this->User->findbyid($user_id);
	   $my_point = $user_info['User']['point'];
	   $condition=" user_id='".$user_id."' and payment_status = 0 ";
	   $total_no_pay=$this->Order->findCount($condition,0);
	   $condition=" user_id='".$user_id."' and status = 0 ";
	   $total_no_confirm=$this->Order->findCount($condition,0);
	   //筛选条件
	   $min_points=isset($this->params['url']['min_points'])?$this->params['url']['min_points']:'';
   	   $max_points=isset($this->params['url']['max_points'])?$this->params['url']['max_points']:'';
   	   $start_date=isset($this->params['url']['date'])?$this->params['url']['date']:'';
   	   $end_date=isset($this->params['url']['date2'])?$this->params['url']['date2']:'';
	   $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist'] ,
	   						"recharge_amount_not_empty" => $this->languages['supply'].$this->languages['amount'].$this->languages['can_not_empty'],
	   						"no_choose_payment_method" => $this->languages['please_choose'].$this->languages['payment']);
	   $this->set('js_languages',$js_languages);	   
	   	$this->pageTitle = $this->languages['points']." - ".$this->configs['shop_title'];
	   $this->set('my_points',$my_points);
	   $this->set('total',$total);
	   $this->set('total_no_confirm',$total_no_confirm);
	   $this->set('total_no_pay',$total_no_pay);
	   $this->set('my_point',$my_point);
   	   $this->set('min_points',$min_points);
   	   $this->set('max_points',$max_points);
   	   $this->set('start_date',$start_date);
   	   $this->set('end_date',$end_date);
	  
	}

}

?>