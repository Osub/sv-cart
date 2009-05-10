<?php
/*****************************************************************************
 * SV-Cart 采购单管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: reports_controller.php 1273 2009-05-08 16:49:08Z huangbo $
*****************************************************************************/
class ReportsController extends AppController {

	var $name = 'Reports';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers = array('Pagination','Html'); // Added 
	//var $uses = array('Order','OrderProduct','OrderAction',"UserPointLog","User","ProviderProduct","UserBalanceLog");
	var $uses = array('Order','OrderProduct',"UserPointLog","User","ProviderProduct","UserBalanceLog","Payment");
	function index(){
	
	}
	function procurement(){
		//pr($this->configs);
		$this->pageTitle = '采购单管理'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'采购单管理','url'=>'/reports/procurement/');
		$this->set('navigations',$this->navigations);
		$this->Payment->set_locale($this->locale);
		$Payment = $this->Payment->findAll("Payment.is_cod=1");
		$is_cod_arr = array('0');
		foreach($Payment as $v){
			$is_cod_arr[] = $v['Payment']['id'];
		}
		$is_cod_str = "(".implode(',',$is_cod_arr).")";
		//echo $is_cod_str;
		$condition2 = "Order.status=1 and Order.shipping_status<>1 and Order.shipping_status<>2 and (Order.payment_status=2 or Order.payment_id in $is_cod_str)";
		$orders = $this->Order->findAll($condition2);
		//pr($orders);
		$orderid = array();
		if(is_array($orders)&&!empty($orders))foreach($orders as $order){
			$orderid[] = "'".$order['Order']['id']."'";
		}
		else $orderid[] = '-1';
    	$condition = '1=1';
    	$condition .= " and OrderProduct.order_id in(".implode(",",$orderid).")";
    	
		$start_time = '';
		$end_time = '';
		if(isset($this->params['url']['start_time']) && $this->params['url']['start_time'] != ''){
	   	   	$condition .= " and OrderProduct.modified >= '".$this->params['url']['start_time']."'";
			$start_time = $this->params['url']['start_time'];
	    }
		if(isset($this->params['url']['end_time']) && $this->params['url']['end_time'] != ''){
			$condition .= " and OrderProduct.modified <= '".$this->params['url']['end_time']."'";
			$end_time = $this->params['url']['end_time'];
	    }
	    /*
		if($this->RequestHandler->isPost()){
			if(isset($this->params['form']['start_time'])&&!empty($this->params['form']['start_time'])){
				$condition .= " and OrderProduct.modified >= '".$this->params['form']['start_time']."'";
				$start_time = $this->params['form']['start_time'];
				
			}	
			if(isset($this->params['form']['end_time'])&&!empty($this->params['form']['end_time'])){
				$condition .= " and OrderProduct.modified <= '".$this->params['form']['end_time']."'";
				$end_time = $this->params['form']['end_time'];
			}
		}
		*/
		$page = 1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$parameters = array($rownum,$page);		
		$options = array();
		$total = $this->OrderProduct->findCount($condition,0);
		$sortClass = 'OrderProduct';
		$page  = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		//得到商品供应商列表
		$productprovider = $this->ProviderProduct->findAssoc();
		$data = $this->OrderProduct->findAll($condition,'',"OrderProduct.created,OrderProduct.id",$rownum,$page);
		$this->set('orders',$data);
		$this->set('productprovider',$productprovider);
		$this->set('start_time',$start_time);
		$this->set('end_time',$end_time);
	}
	
	function shipments(){
		$this->pageTitle = '待发货单管理'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'待发货单管理','url'=>'/reports/shipments/');
		$this->set('navigations',$this->navigations);
		// 增加关联
		$this->Order->bindModel(array('hasMany' => 
									array( 'OrderProduct' =>
										array(  'className'    => 'OrderProduct', 
												'conditions'   =>  '',
												'order'        => '',   
												'dependent'    =>  true,   
												'foreignKey'   => 'order_id'  
											)
	            						)
	        						)
    							);
    	
    	$condition = 'Order.status=1  and shipping_status  in(0,3)';
    	
    	//and Order.payment_status=2
    	
		$start_time = '';
		$end_time = '';
		if($this->RequestHandler->isPost()){
			if(isset($this->params['form']['start_time'])&&!empty($this->params['form']['start_time'])){
				$condition .= " and Order.modified >= '".$this->params['form']['start_time']."'";
				$start_time = $this->params['form']['start_time'];
			}	
			if(isset($this->params['form']['end_time'])&&!empty($this->params['form']['end_time'])){
				$condition .= " and Order.modified <= '".$this->params['form']['end_time']."'";
				$end_time = $this->params['form']['end_time'];
			}
		}
		$data = $this->Order->findAll($condition,'',"Order.created,Order.id desc");
		foreach( $data as $k=>$v ){
			$data[$k]['Order']['total'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$v['Order']['total']));
		$data[$k]['Order']['total'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$v['Order']['total']));
		foreach($v['OrderProduct'] as $kk=>$op){
			$data[$k]['OrderProduct'][$kk]['product_price'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$op['product_price']));
		}
		}
		
		$this->set('orders',$data);
	
		$this->set('start_time',$start_time);
		$this->set('end_time',$end_time);
	}
	
	function balance(){
		$this->pageTitle = '用户资金报表'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'用户资金报表','url'=>'/reports/balance/');
		$this->set('navigations',$this->navigations);
		$datatime = date("Y-m-d H:i:s");
		$end_time = "";
		if($this->RequestHandler->isPost()){
			if($_REQUEST['start_time']){
				$start_time = $_REQUEST['start_time'];
				$this->set('start_time',$start_time);
			}
			if($_REQUEST['end_time']){	 
				$end_time = $_REQUEST['end_time'];
				$this->set('end_time',$end_time);
			}
			if(!empty($start_time)){
				$datatime = $start_time;
			}
			
		}else{
			$datatime = date("Y-m-d H:i:s");
			 $end_time = "";
		}
		
		$User = $this->User->findAll(  );
		foreach( $User as $k=>$v ){
			
			$User_id = $v['User']['id'];
			$wh = " UserBalanceLog.user_id='$User_id' ";
			$UserBalanceLog = $this->UserBalanceLog->findAll( $wh );
			$whstart = $wh." and UserBalanceLog.created<'$datatime'";
			
			$sql = " select sum(amount) as start from svcart_user_balance_logs as UserBalanceLog where $whstart  ";
			$start_amount = $this->UserBalanceLog->query($sql);
			if(!empty($start_amount[0][0]['start'])){
				$User[$k]['User']['start_amount'] = $start_amount[0][0]['start'];
				$amount_start_sum[]=$User[$k]['User']['start_amount'];
			}else{
				$User[$k]['User']['start_amount'] = sprintf($this->configs['price_format'],0);
				$amount_start_sum[]=0;
			}
				
			
			$whzc = $wh."and UserBalanceLog.created>'$datatime'and UserBalanceLog.amount<0";
			if( $end_time!="" ){
				$whzc.=" and UserBalanceLog.created<'$end_time'";
			}
			$sql = " select sum(amount) as zc from svcart_user_balance_logs as UserBalanceLog where $whzc  ";
			$zc_amount = $this->UserBalanceLog->query($sql);
			if(!empty($zc_amount[0][0]['zc'])){
				$User[$k]['User']['zc_amount'] = $zc_amount[0][0]['zc'];
				$amount_zc_sum[]=$User[$k]['User']['zc_amount'];
			}else{
				$User[$k]['User']['zc_amount'] = sprintf($this->configs['price_format'],0);
				$amount_zc_sum[]=0;
			}
			
			
			$whsl = $wh."and UserBalanceLog.created>'$datatime'and UserBalanceLog.amount>0";
			if( $end_time!="" ){
				$whsl.=" and UserBalanceLog.created<'$end_time'";
			}
			$sql = " select sum(amount) as sl from svcart_user_balance_logs as UserBalanceLog where $whsl  ";
			$sl_amount = $this->UserBalanceLog->query($sql);
			if(!empty($sl_amount[0][0]['sl'])){
				$User[$k]['User']['sl_amount'] = sprintf($this->configs['price_format'],$sl_amount[0][0]['sl']);
				$amount_sl_sum[]=$User[$k]['User']['sl_amount'];
			}else{
				$User[$k]['User']['sl_amount'] = sprintf($this->configs['price_format'],0);
				$amount_sl_sum[]=sprintf($this->configs['price_format'],0);
			}
			
			$amountsum = sprintf($this->configs['price_format'],$start_amount[0][0]['start']+$zc_amount[0][0]['zc']+$sl_amount[0][0]['sl']);
			$User[$k]['User']['amountsum'] = $amountsum;
			$amountsums[] = $amountsum;
		}	
			$amount_start_sum = sprintf($this->configs['price_format'],array_sum($amount_start_sum));
			$amount_zc_sum = sprintf($this->configs['price_format'],array_sum($amount_zc_sum));
			$amount_sl_sum = sprintf($this->configs['price_format'],array_sum($amount_sl_sum));
			$amountsums = sprintf($this->configs['price_format'],array_sum($amountsums));
			//pr($point_sl_sum);
			$this->set('User',$User);
			$this->set('amount_start_sum',$amount_start_sum);
			$this->set('amount_zc_sum',$amount_zc_sum);
			$this->set('amount_sl_sum',$amount_sl_sum);
			$this->set('amountsums',$amountsums);
			 
		
	
	}
	
	function point(){
		$this->pageTitle = '积分报表'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'积分报表','url'=>'/reports/point/');
		$this->set('navigations',$this->navigations);
		
		if($this->RequestHandler->isPost()){
			 $start_time = $_REQUEST['start_time'];
			 $end_time = $_REQUEST['end_time'];
			 $this->set('start_time',$start_time);
			 $this->set('end_time',$end_time);
			 $datatime = $start_time;
		
		}else{
			$datatime = date("Y-m-d H:i:s");
			$end_time = "";
		}
		
		$User = $this->User->findAll(  );
		foreach( $User as $k=>$v ){
		
			$User_id = $v['User']['id'];
			$wh = " UserPointLog.user_id='$User_id' ";
			$UserPointLog = $this->UserPointLog->findAll( $wh );
			$whstart = $wh." and UserPointLog.created<'$datatime'";
			
			$sql = " select sum(point) as start from svcart_user_point_logs as UserPointLog where $whstart  ";
			$start_point = $this->UserPointLog->query($sql);
			if(!empty($start_point[0][0]['start'])){
				$User[$k]['User']['start_point'] = $start_point[0][0]['start'];
				$point_start_sum[]=$User[$k]['User']['start_point'];
			}else{
				$User[$k]['User']['start_point'] = 0;
				$point_start_sum[]=0;
			}
				
			
			$whzc = $wh."and UserPointLog.created>'$datatime'and UserPointLog.point<0";
			if( $end_time!="" ){
				$whzc.=" and UserPointLog.created<'$end_time'";
			}
			$sql = " select sum(point) as zc from svcart_user_point_logs as UserPointLog where $whzc  ";
			$zc_point = $this->UserPointLog->query($sql);
			if(!empty($zc_point[0][0]['zc'])){
				$User[$k]['User']['zc_point'] = $zc_point[0][0]['zc'];
				$point_zc_sum[]=$User[$k]['User']['zc_point'];
			}else{
				$User[$k]['User']['zc_point'] = 0;
				$point_zc_sum[]=0;
			}
			
			
			$whsl = $wh."and UserPointLog.created>'$datatime'and UserPointLog.point>0";
			if( $end_time!="" ){
				$whsl.=" and UserPointLog.created<'$end_time'";
			}
			$sql = " select sum(point) as sl from svcart_user_point_logs as UserPointLog where $whsl  ";
			$sl_point = $this->UserPointLog->query($sql);
			if(!empty($sl_point[0][0]['sl'])){
				$User[$k]['User']['sl_point'] = $sl_point[0][0]['sl'];
				$point_sl_sum[]=$User[$k]['User']['sl_point'];
			}else{
				$User[$k]['User']['sl_point'] = 0;
				$point_sl_sum[]=0;
			}
			
			$pointsum = $start_point[0][0]['start']+$zc_point[0][0]['zc']+$sl_point[0][0]['sl'];
			$User[$k]['User']['pointsum'] = $pointsum;
			$pointsums[] = $pointsum;
		}	
			$point_start_sum = array_sum($point_start_sum);
			$point_zc_sum = array_sum($point_zc_sum);
			$point_sl_sum = array_sum($point_sl_sum);
			$pointsums = array_sum($pointsums);
			//pr($point_sl_sum);
			$this->set('User',$User);
			$this->set('point_start_sum',$point_start_sum);
			$this->set('point_zc_sum',$point_zc_sum);
			$this->set('point_sl_sum',$point_sl_sum);
			$this->set('pointsums',$pointsums);
			 
		
	
	}
	
	function consume(){
		$this->pageTitle = '会员消费报表'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'会员消费报表','url'=>'/reports/consume/');
		$this->set('navigations',$this->navigations);
		$condition = '1=1';
		$start_time = '';
		$end_time = '';
		if($this->RequestHandler->isPost()){
			if(isset($this->params['form']['start_time'])&&!empty($this->params['form']['start_time'])){
				$condition .= " and Order.modified >= '".$this->params['form']['start_time']."'";
				$start_time = $this->params['form']['start_time'];
				
			}	
			if(isset($this->params['form']['end_time'])&&!empty($this->params['form']['end_time'])){
				$condition .= " and Order.modified <= '".$this->params['form']['end_time']."'";
				$end_time = $this->params['form']['end_time'];
			}
		}
		
		$limit = 10;
		$this->Order->hasMany = array();
		$data = $this->Order->find('all',array('conditions' =>$condition,'fields' => array('Order.user_id','sum(Order.subtotal) as sumtotal','count(order.id) as countorder'),'order' => 'sumtotal desc','group' => array('Order.user_id')));
    	//pr($data);
    	$consume = array();
    	$userid = array('-1');
    	foreach($data as $v){
    		$userid[] = "'".$v['Order']['user_id']."'";
    		$consume[$v['Order']['user_id']]['sumtotal'] = $v[0]['sumtotal'];
    		$consume[$v['Order']['user_id']]['countorder'] = $v[0]['countorder'];
    	}
    	$condition2 = "User.id in(".implode(",",$userid).")";
    	$users = $this->User->find('list',array('conditions' =>$condition2,'limit' => $limit,'fields'=>array('User.id', 'User.name')));

    //	pr($consume);pr($userid);
    	$this->Order->bindModel(array('hasMany' => 
									array( 'OrderProduct' =>
										array(  'className'    => 'OrderProduct', 
												'conditions'   =>  '',
												'order'        => '',   
												'dependent'    =>  true,   
												'foreignKey'   => 'order_id'  
											)
	            						)
	        						)
    							);
    	$condition .= " and Order.user_id in(".implode(",",$userid).")";
    	$data = $this->Order->find('all',array('conditions' =>$condition,'fields' => array('Order.user_id')));
    //	pr($data);
    	foreach($data as $v){
    		if(!empty($v['OrderProduct'])) foreach($v['OrderProduct'] as $vv){
    			if(isset($consume[$v['Order']['user_id']]['sumquntity'])){
    				$consume[$v['Order']['user_id']]['sumquntity'] += $vv['product_quntity'];
    				//$consume[$v['Order']['user_id']]['sumquntity'] += $vv['product_quntity'];
    			}else{
    				$consume[$v['Order']['user_id']]['sumquntity'] = $vv['product_quntity'];
    			}
    		}
    	}
    	$this->set('users',$users);
    	$this->set('orders',$consume);
    	
		$this->set('start_time',$start_time);
		$this->set('end_time',$end_time);
	}
	   
	function sales(){
		$this->pageTitle = '商品销售报表'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商品销售报表','url'=>'/reports/sales/');
		$this->set('navigations',$this->navigations);
		$condition = 'OrderProduct.status=1';

		$start_time = '';
		$end_time = '';
		if($this->RequestHandler->isPost()){
			if(isset($this->params['form']['start_time'])&&!empty($this->params['form']['start_time'])){
				$condition .= " and OrderProduct.modified >= '".$this->params['form']['start_time']."'";
				$start_time = $this->params['form']['start_time'];
				
			}	
			if(isset($this->params['form']['end_time'])&&!empty($this->params['form']['end_time'])){
				$condition .= " and OrderProduct.modified <= '".$this->params['form']['end_time']."'";
				$end_time = $this->params['form']['end_time'];
			}
		}
		$data = $this->OrderProduct->findAll($condition,'',"OrderProduct.created,OrderProduct.id");
		$productcount = 0;
		$quntitysum = 0;
		$pricesum = 0;
		$data_arr = array();
		//start
		//去除重复..相同的产品..数量..价品...累加
		foreach($data as $k=>$v){
			if(!in_array($v["OrderProduct"]["product_id"],$data_arr)){
				$data_arr[] = $v["OrderProduct"]["product_id"];
			}
		}
		
		for( $i=0;$i<count($data_arr);$i++ ){
			$data_list_arr[$i]['OrderProduct']['product_price'] = "";
			$data_list_arr[$i]['OrderProduct']['product_quntity'] = "";
			foreach($data as $kk=>$vv){
				if($vv["OrderProduct"]["product_id"]==$data_arr[$i]){
					$data_list_arr[$i]['OrderProduct']['product_price']+= $vv["OrderProduct"]["product_price"];
					$data_list_arr[$i]['OrderProduct']['product_quntity']+= $vv["OrderProduct"]["product_quntity"];
					$data_list_arr[$i]['OrderProduct']['product_code'] = $vv["OrderProduct"]["product_code"];
					$data_list_arr[$i]['OrderProduct']['product_name'] = $vv["OrderProduct"]["product_name"];
					
				}
			}
			$data_list_arr[$i]['OrderProduct']['product_price'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$data_list_arr[$i]['OrderProduct']['product_price']));
		}
		//end
		foreach($data_list_arr as $v){
			$productcount++;
			$quntitysum += $v['OrderProduct']['product_quntity'];
			$pricesum += $v['OrderProduct']['product_price'];
		}
		$this->set('productcount',$productcount);
		$this->set('quntitysum',$quntitysum);
		$this->set('pricesum',$pricesum);
		$this->set('orderproducts',$data_list_arr);
		$this->set('start_time',$start_time);
		$this->set('end_time',$end_time);
	}
	
	function orderstatus(){
		$this->pageTitle = '订单状态报表'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'订单状态报表','url'=>'/reports/orderstatus/');
		$this->set('navigations',$this->navigations);
		
		$condition = '1=1';
		$start_time = '';
		$end_time = '';
		if($this->RequestHandler->isPost()){
			if(isset($this->params['form']['start_time'])&&!empty($this->params['form']['start_time'])){
				$condition .= " and Order.modified >= '".$this->params['form']['start_time']."'";
				$start_time = $this->params['form']['start_time'];
				
			}	
			if(isset($this->params['form']['end_time'])&&!empty($this->params['form']['end_time'])){
				$condition .= " and Order.modified <= '".$this->params['form']['end_time']."'";
				$end_time = $this->params['form']['end_time'];
			}
		}
		$data = $this->Order->findAll($condition,'',"Order.created,Order.id");
		$order_status = array();
		$shipping_status = array();
		$payment_status = array();
		$payment = array();
		foreach($data as $k=>$v){
			if(isset($order_status[$v['Order']['status']][$v['Order']['payment_id']]))
				$order_status[$v['Order']['status']][$v['Order']['payment_id']]++;
			else {
				$order_status[$v['Order']['status']][$v['Order']['payment_id']] = 1;
				$payment[$v['Order']['payment_id']] = $v['Order']['payment_name'];
			}
			if(isset($shipping_status[$v['Order']['shipping_status']][$v['Order']['payment_id']]))
				$shipping_status[$v['Order']['shipping_status']][$v['Order']['payment_id']]++;
			else 
				$shipping_status[$v['Order']['shipping_status']][$v['Order']['payment_id']] = 1;
			
			if(isset($payment_status[$v['Order']['payment_status']][$v['Order']['payment_id']]))
				$payment_status[$v['Order']['payment_status']][$v['Order']['payment_id']]++;
			else 
				$payment_status[$v['Order']['payment_status']][$v['Order']['payment_id']] = 1;
		}
		$this->set('payment',$payment);
		$this->set('order_status',$order_status);
		$this->set('shipping_status',$shipping_status);
		$this->set('payment_status',$payment_status);
		$this->set('start_time',$start_time);
		$this->set('end_time',$end_time);
	}
	
	function orderfee(){
		$this->pageTitle = '订单业绩报表'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'订单业绩报表','url'=>'/reports/orderfee/');
		$this->set('navigations',$this->navigations);
		$now_year = date("Y");
		$now_month = date("m");
		for($i=10;$i>=0;$i--){
			$now_year_arr[$now_year-10+$i] = $now_year-10+$i; 
		}
		for($j=1;$j<=12;$j++){
			$now_month_arr[$j] = $j;
		}
		$condition = '1=1';
		$month = date('Y-m')."-01";
		
		if($this->RequestHandler->isPost()){
			if(isset($this->params['form']['month'])&&!empty($this->params['form']['month'])){
				$year = $this->params['form']['year'];
				$now_month = $this->params['form']['month'];
				$month = $year."-".$now_month;
			}	
		}
		
		$n=31;
		$month_timestamp = strtotime($month);
		
		
		if(date('Y-m')==date('Y-m',$month_timestamp))
			$n= date('d');
		else {
			$bigmonth = array(1,3,5,7,8,10,12);
			$m = date('m',$month_timestamp);
			if(in_array($m,$bigmonth))
				$n=31;
			else $n = 30;
			
			if(($m==2)&&(date('Y',$month_timestamp))%4==0)
				$n = 29;
		}
		//echo $n;exit;
		$oneday_timestamp = 24*60*60;
		$order_status = array();//array('月份'=>array('状态'=>'数量'));
		$all_order_status = array();//根据订单状态作大统计用
		$all_order['order'] = 0;
		$all_order['product'] = 0;
		$all_order['total'] = 0;
				
		for($i=1;$i<=$n;$i++){
			$starttime = date('Y-m-d H:i:s',$month_timestamp+($i-1)*$oneday_timestamp);
			$endtime = date('Y-m-d H:i:s',$month_timestamp+($i)*$oneday_timestamp);
			$newcondition = $condition." and Order.modified >= '".$starttime."'"." and Order.modified <'".$endtime."'";
			$data = $this->Order->findAll($newcondition);
			//pr($data);exit
			$order_status[$i]['count_order'] = count($data);//订单数量
			$all_order['order'] += $order_status[$i]['count_order'];
			
			$order_status[$i]['count_product'] = 0;//商品数量
			$order_status[$i]['sum_total'] = 0;//金额小计
	
			foreach($data as $k=>$v){
				//计算金额
				$order_status[$i]['sum_total'] += $v['Order']['total'];		
				$all_order['total'] += $v['Order']['total'];
				//根据订单状态作小统计
				if(isset($order_status[$i][$v['Order']['status']]))
					$order_status[$i][$v['Order']['status']]++;
				else {
					$order_status[$i][$v['Order']['status']] = 1;
					
				}
				//
				if(isset($all_order_status[$v['Order']['status']])){
					$all_order_status[$v['Order']['status']]++;
				}
				else{
					 $all_order_status[$v['Order']['status']] = 1;
				}
				//计算商品数量
				if(!empty($v['OrderProduct'])){
					foreach($v['OrderProduct'] as $vv){
						$order_status[$i]['count_product'] += $vv['product_quntity'];
						$all_order['product'] += $vv['product_quntity'];
					}
				}
			}
		}
		//pr($order_status);
		//pr($all_order_status);

	//	pr($now_year_arr);
		$monthes = array('2008-01'=>'2008-01-01','2008-02'=>'2008-02-01','2008-03'=>'2008-03-01','2008-04'=>'2008-04-01','2008-05'=>'2008-05-01','2008-06'=>'2008-06-01','2008-07'=>'2008-07-01','2008-08'=>'2008-08-01','2008-09'=>'2008-09-01','2008-10'=>'2008-10-01','2008-11'=>'2008-11-01','2008-12'=>'2008-12-01');
		$all_order['total'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$all_order['total']));
		
		foreach($order_status as $k=>$v){
			$order_status[$k]['sum_total'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$v['sum_total']));
		}
		
		$this->set('now_year_arr',$now_year_arr);
		$this->set('now_month_arr',$now_month_arr);
		$this->set('now_month',$now_month);
		
		$this->set('all_order',$all_order);
		
		
	
		$this->set('month',$month);
		$this->set('monthes',$monthes);
		$this->set('n',$n);
		$this->set('order_status',$order_status);
		$this->set('all_order_status',$all_order_status);
	}
}

?>