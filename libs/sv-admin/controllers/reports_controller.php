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
 * $Id: reports_controller.php 2890 2009-07-15 08:04:55Z zhengli $
 *****************************************************************************/
class ReportsController extends AppController{
    var $name='Reports';
    var $components=array('Pagination','RequestHandler');
    var $helpers=array('Pagination','Html');
    var $uses=array('Order','OrderProduct',"UserPointLog","User","ProviderProduct","UserBalanceLog","Payment");
    function procurement($export=0){
        /*判断权限*/
        $this->operator_privilege('purchase_order_view');
        /*end*/
        $this->pageTitle='采购单管理'." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '采购单管理','url' => '/reports/procurement/');
        $this->set('navigations',$this->navigations);
        $this->Payment->set_locale($this->locale);
        $Payment=$this->Payment->findAll("Payment.is_cod='1'");
        $is_cod_arr=array();
        foreach($Payment as $v){
            $is_cod_arr[]=$v['Payment']['id'];
        }
        $is_cod_str="(".implode(',',$is_cod_arr).")";
        $condition2=" Order.status='1' and Order.shipping_status<>'1' and Order.shipping_status<>'2' and (Order.payment_status='2' or Order.payment_id in $is_cod_str)";
        //DAM
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            if(isset($_REQUEST["order_locale"]) && !empty($_REQUEST["order_locale"])){
                $order_locale=$_REQUEST["order_locale"];
                $price_format=$this->currency_format[$order_locale];
                $condition2.=" and Order.order_locale='$order_locale'";
            }
            else{
                $order_locale=$this->locale;
                $price_format=$this->currency_format[$order_locale];
                $condition2.=" and Order.order_locale='$order_locale'";
            }
        }
        else{
            $price_format=$this->configs["price_format"];
            $order_locale=$this->locale;
        }
        $orders=$this->Order->findAll($condition2);
        $orderid=array();
        if(is_array($orders) && !empty($orders))
        foreach($orders as $order){
            $orderid[]="'".$order['Order']['id']."'";
        }
        else{
            $orderid[]='-1';
        }$condition="  OrderProduct.order_id in(".implode(",",$orderid).")";
        $start_time='';
        $end_time='';
        if(isset($this->params['url']['start_time']) && $this->params['url']['start_time']!=''){
            $condition.=" and OrderProduct.modified >= '".$this->params['url']['start_time']."'";
            $start_time=$this->params['url']['start_time'];
        }
        else {
            $condition .= " and OrderProduct.modified >= '".date('Y-m-').'1'."'";
            $start_time = date('Y-m-').'1';
        }
        if(isset($this->params['url']['end_time']) && $this->params['url']['end_time']!=''){
            $condition.=" and OrderProduct.modified <= '".$this->params['url']['end_time']." 23:59:59'";
            $end_time=$this->params['url']['end_time'];
        }
        else {
            $condition.=" and OrderProduct.modified <= '".date('Y-m-d')." 23:59:59'";
            $end_time = date('Y-m-d');
        }
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=array($rownum,$page);
        $options=array();
        $total=$this->OrderProduct->findCount($condition,0);
        $sortClass='OrderProduct';
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        //得到商品供应商列表
        $productprovider=$this->ProviderProduct->findAssoc();
        if(isset($export) && $export==="export"){
        	$data=$this->OrderProduct->findAll($condition,'',"OrderProduct.created,OrderProduct.id");
        }else{
        	$data=$this->OrderProduct->findAll($condition,'',"OrderProduct.created,OrderProduct.id",$rownum,$page);
        }        
        $this->set('orders',$data);
        //pr($data);
        $this->set('productprovider',$productprovider);
        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);
        $this->set('locale',$order_locale);
      //  pr($data);
      /*  if(isset($_REQUEST['page']) && !empty($_REQUEST['page'])){
            $this->set('ex_page',$this->params['url']['page']);
        }
        if(isset($_REQUEST['start_time'])){
            $ex_url="start_time=".$this->params['url']['start_time']."&end_time=".$this->params['url']['end_time']."&order_locale=".$this->params['url']['order_locale'];
        }
        else{
            $ex_url="start_time=&end_time=&order_locale=".$this->locale;
        }
        $this->set('ex_url',$ex_url);
        
        /*CSV导出*/
      //  if(isset($_REQUEST['export']) && $_REQUEST['export']=="export"){
      	if(isset($export) && $export==="export"){
            $filename='采购单导出'.date('Ymd').'.csv';
            $ex_data="采购统计报表,";
            $ex_data.="选择日期:,";
            if(!empty($_REQUEST['start_time'])){
            	$ex_data.=$_REQUEST['start_time']."起,";
            }else{
            	$ex_data.=',';
            }
             if(!empty($_REQUEST['end_time'])){
            	$ex_data.="至".$_REQUEST['end_time']."\n";
            }else{
            	$ex_data.="\n";
            }           
            $ex_data.="货号,";
            $ex_data.="商品名称,";
            $ex_data.="属性,";
            $ex_data.="数量,";
            $ex_data.="供应商,";
            $ex_data.="备注,";
            $ex_data.="\n";
            foreach($data as $v){
                $ex_data.=$v['OrderProduct']['product_code'].",";
                $ex_data.=$v['OrderProduct']['product_name'].",";
                $ex_data.=$v['OrderProduct']['product_attrbute'].",";
                $ex_data.=$v['OrderProduct']['product_quntity'].",";
                if(isset($productprovider[$v['OrderProduct']['product_id']])){
                    $ex_data.=$productprovider[$v['OrderProduct']['product_id']]['name'].",";
                }
                else{
                    $ex_data.=",";
                }
                $ex_data.=$v['OrderProduct']['note']."\n";
            }
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=gb2312");
            header("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8','gb2312',$ex_data."\n");
            exit;
        }
    }
    function shipments($export=0){
        /*判断权限*/
        $this->operator_privilege('shipping_order_view');
        /*end*/
        $this->pageTitle='待发货单管理'." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '待发货单管理','url' => '/reports/shipments/');
        $this->set('navigations',$this->navigations);
        // 增加关联
        $this->Order->bindModel(array('hasMany' => array('OrderProduct' =>
            array('className' => 'OrderProduct','conditions' => '','order' =>
            '','dependent' => true,'foreignKey' => 'order_id'
        ))));
        $condition="Order.status='1'  and shipping_status  in('0','3')";
        //and Order.payment_status=2
        $start_time='';
        $end_time='';
        if($this->RequestHandler->isPost()){
            if(isset($this->params['form']['start_time']) && !empty($this->params['form']['start_time'])){
                $condition.=" and Order.modified >= '".$this->params['form']['start_time']."'";
                $start_time=$this->params['form']['start_time'];
            }
            if(isset($this->params['form']['end_time']) && !empty($this->params['form']['end_time'])){
                $condition.=" and Order.modified <= '".$this->params['form']['end_time']."'";
                $end_time=$this->params['form']['end_time'];
            }
        }
        //DAM
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            if(isset($_REQUEST["order_locale"]) && !empty($_REQUEST["order_locale"]) && $_REQUEST["order_locale"]!="all"){
                $order_locale=$_REQUEST["order_locale"];
                $price_format=$this->currency_format[$order_locale];
                $condition.=" and Order.order_locale='$order_locale'";
            }
            else{
                $order_locale="all";
                //$price_format = $this->currency_format[$order_locale];
                //$condition.= " and Order.order_locale='$order_locale'";
            }
        }
        else{
            $price_format=$this->configs["price_format"];
            $order_locale="all";
        }
        $data=$this->Order->findAll($condition,'',"Order.created,Order.id desc");
        foreach($data as $k => $v){
            $price_format=$this->configs['price_format'];
            //DAM
            if(isset($this->configs["mlti_currency_module"]) && $this->configs["mlti_currency_module"]==1){
                if($v["Order"]["order_locale"]!=' '){
                    $price_format=$this->currency_format[$v["Order"]["order_locale"]];
                }
                else{
                    $price_format=$this->configs['price_format'];
                }
            }
            //
            $data[$k]['Order']['total']=sprintf($price_format,sprintf("%01.2f",$v['Order']['total']));
            $data[$k]['Order']['total']=sprintf($price_format,sprintf("%01.2f",$v['Order']['total']));
            foreach($v['OrderProduct']as $kk => $op){
                $data[$k]['OrderProduct'][$kk]['product_price']=sprintf($price_format,sprintf("%01.2f",$op['product_price']));
            }
        }
        $this->set('orders',$data);
        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);
        $this->set('locale',$order_locale);
        /*CSV导出*/
        if(isset($export) && $export==="export"){
            $filename='待发货单导出'.date('Ymd').'.csv';
            $ex_data="待发货单统计报表,";
            $ex_data.="选择日期:,";
            if(!empty($_REQUEST['start_time'])){
            	$ex_data.=$_REQUEST['start_time']."起,";
            }else{
            	$ex_data.=',';
            }
             if(!empty($_REQUEST['end_time'])){
            	$ex_data.="至".$_REQUEST['end_time']."\n";
            }else{
            	$ex_data.="\n";
            }  
            $ex_data.="订单号,";
            $ex_data.="姓名,";
            $ex_data.="地址,";
            $ex_data.="电话,";
            $ex_data.="付款方式,";
            $ex_data.="付款日期,";
            $ex_data.="金额总计\n";
            foreach($data as $v){
                $ex_data.=$v['Order']['order_code'].",";
                $ex_data.=$v['Order']['consignee'].",";
                $ex_data.=$v['Order']['address'].",";
                $ex_data.=$v['Order']['telephone'].",";
                $ex_data.=$v['Order']['payment_name'].",";
                $ex_data.=$v['Order']['payment_time'].",";
                $ex_data.=$v['Order']['total']."\n";
                $ex_data.=",";
                $ex_data.="货号,";
                $ex_data.="商品名称,";
                $ex_data.="数量,";
                $ex_data.="属性,";
                $ex_data.="价格\n";
                if(isset($v['OrderProduct'])){
                    foreach($v['OrderProduct']as $op){
                        $ex_data.=",".$op['product_code'].",";
                        $ex_data.=$op['product_name'].",";
                        $ex_data.=$op['product_quntity'].",";
                        $ex_data.=$op['product_attrbute'].",";
                        $ex_data.=$op['product_price']."\n";
                    }
                }
            }
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=gb2312");
            header("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8','gb2312',$ex_data."\n");
            exit;
        }
    }
    function balance($export=0){
        /*判断权限*/
        $this->operator_privilege('user_funds_statement_view');
        /*end*/
        $this->pageTitle='用户资金报表'." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '用户资金报表','url' => '/reports/balance/');
        $this->set('navigations',$this->navigations);
        $datatime=date("Y-m-d H:i:s");
        $start_time=date("Y-m-d",strtotime($datatime))." 00:00:00";
        $end_time=date("Y-m-d",strtotime($datatime))." 23:59:59";
        if($this->RequestHandler->isPost()){
            if($_REQUEST['start_time']){
                $start_time=$_REQUEST['start_time'];
                $start_time=$start_time." 00:00:00";
            }
            if($_REQUEST['end_time']){
                $end_time=$_REQUEST['end_time'];
                $end_time=$end_time." 23:59:59";
            }
        }
        //DAM
        $Usercondition="";
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            if(isset($_REQUEST["order_locale"]) && !empty($_REQUEST["order_locale"])){
                $order_locale=$_REQUEST["order_locale"];
                $price_format=$this->currency_format[$order_locale];
                $Usercondition.="  User.locale='$order_locale'";
            }
            else{
                $order_locale=$this->locale;
                $price_format=$this->currency_format[$order_locale];
                $Usercondition.="  User.locale='$order_locale'";
            }
        }
        else{
            $price_format=$this->configs["price_format"];
            $order_locale=$this->locale;
        }
        $username="";
        if( !empty($_REQUEST['username']) ){
        	$username = $_REQUEST['username'];
        	$Usercondition.="  User.name LIKE  '%$username%'";
        }
        $User=$this->User->findAll($Usercondition);
        foreach($User as $k => $v){
            $User_id=$v['User']['id'];
            $wh=" UserBalanceLog.user_id='$User_id' ";
            $UserBalanceLog=$this->UserBalanceLog->findAll($wh);
            $whstart=$wh." and UserBalanceLog.created<'$start_time' and UserBalanceLog.created<'$end_time' ";
            $start_amount=$this->UserBalanceLog->find('first',array('conditions' => $whstart,'fields' => array('sum(amount) as start')));
            $User[$k]['User']['start_amount']=sprintf($price_format,sprintf("%01.2f",$start_amount[0]['start']+0));
            $amount_start_sum[]=$start_amount[0]['start']+0;
            $whzc=$wh."and UserBalanceLog.created<'$start_time' and UserBalanceLog.created<'$end_time' and UserBalanceLog.amount<0";
            $zc_amount=$this->UserBalanceLog->find('first',array('conditions' => $whzc,'fields' => array('sum(amount) as zc')));
            $amount_zc_sum[]=$zc_amount[0]['zc']+0;
            $User[$k]['User']['zc_amount']=sprintf($price_format,sprintf("%01.2f",$zc_amount[0]['zc']+0));
            $whsl=$wh."and UserBalanceLog.created>'$start_time'and UserBalanceLog.amount>0";
            if($end_time!=""){
                $whsl.=" and UserBalanceLog.created<'$end_time'";
            }
            $sl_amount=$this->UserBalanceLog->find('first',array('conditions' => $whsl,'fields' => array('sum(amount) as sl')));
            $amount_sl_sum[]=$sl_amount[0]['sl']+0;
            $User[$k]['User']['sl_amount']=sprintf($price_format,sprintf("%01.2f",$sl_amount[0]['sl']));
            $amountsum=sprintf($price_format,sprintf("%01.2f",$start_amount[0]['start']+$zc_amount[0]['zc']+$sl_amount[0]['sl']));
            $User[$k]['User']['amountsum']=$amountsum;
            $amountsums[]=$start_amount[0]['start']+$zc_amount[0]['zc']+$sl_amount[0]['sl']+0;
        }
        $amount_start_sum=sprintf($price_format,sprintf("%01.2f",@array_sum(@$amount_start_sum)));
        $amount_zc_sum=sprintf($price_format,sprintf("%01.2f",@array_sum(@$amount_zc_sum)));
        $amount_sl_sum=sprintf($price_format,sprintf("%01.2f",@array_sum(@$amount_sl_sum)));
        $amountsums=sprintf($price_format,sprintf("%01.2f",@array_sum(@$amountsums)));
        //pr($point_sl_sum);
        $this->set('User',$User);
        $this->set('username',$username);
        $this->set('amount_start_sum',$amount_start_sum);
        $this->set('amount_zc_sum',$amount_zc_sum);
        $this->set('amount_sl_sum',$amount_sl_sum);
        $this->set('amountsums',$amountsums);
        $this->set('start_time',date("Y-m-d",strtotime($start_time)));
        $this->set('end_time',date("Y-m-d",strtotime($end_time)));
        $this->set('locale',$order_locale);
        /*CSV导出*/
        if(isset($export) && $export==="export"){
            $filename='用户资金报表导出'.date('Ymd').'.csv';
            $ex_data="用户资金报表,";
            $ex_data.="选择日期:,";
            if(!empty($_REQUEST['start_time'])){
            	$ex_data.=$_REQUEST['start_time']."起,";
            }else{
            	$ex_data.=',';
            }
             if(!empty($_REQUEST['end_time'])){
            	$ex_data.="至".$_REQUEST['end_time']."\n";
            }else{
            	$ex_data.="\n";
            } 
            $ex_data.="用户名,";
            $ex_data.="始起资金,";
            $ex_data.="支出,";
            $ex_data.="收入,";
            $ex_data.="结余\n";
            foreach($User as $k => $v){
                $ex_data.=$v['User']['name'].",";
                $ex_data.=$v['User']['start_amount'].",";
                $ex_data.=$v['User']['zc_amount'].",";
                $ex_data.=$v['User']['sl_amount'].",";
                $ex_data.=$v['User']['amountsum']."\n";
            }
            $ex_data.="总计,";
            $ex_data.=$amount_start_sum.",";
            $ex_data.=$amount_zc_sum.",";
            $ex_data.=$amount_sl_sum.",";
            $ex_data.=$amountsums."\n";
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=gb2312");
            header("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8','gb2312',$ex_data."\n");
            exit;
        }
    }
    function point($export=0){
        /*判断权限*/
        $this->operator_privilege('accumulate_point_view');
        /*end*/
        $this->pageTitle='积分报表'." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '积分报表','url' => '/reports/point/');
        $this->set('navigations',$this->navigations);
        if($this->RequestHandler->isPost()){
            $start_time=$_REQUEST['start_time']." 00:00:00";
            $end_time=$_REQUEST['end_time']." 23:59:59";
            $datatime=$start_time;
        }
        else{
            $start_time=date("Y-m-d")." 00:00:00";
            $end_time=date("Y-m-d")." 23:59:59";
            $datatime=date("Y-m-d");
        }
        //dam
        $Usercondition="";
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            if(isset($_REQUEST["order_locale"]) && !empty($_REQUEST["order_locale"])){
                $order_locale=$_REQUEST["order_locale"];
                $price_format=$this->currency_format[$order_locale];
                $Usercondition.="  User.locale='$order_locale'";
            }
            else{
                $order_locale=$this->locale;
                $price_format=$this->currency_format[$order_locale];
                $Usercondition.="  User.locale='$order_locale'";
            }
        }
        else{
            $price_format=$this->configs["price_format"];
            $order_locale=$this->locale;
        }
        $User=$this->User->findAll($Usercondition);
        foreach($User as $k => $v){
            $User_id=$v['User']['id'];
            $wh=" UserPointLog.user_id='$User_id' ";
            $UserPointLog=$this->UserPointLog->findAll($wh);
            $whstart=$wh." and UserPointLog.created<'$datatime'";
            $start_point=$this->UserPointLog->find('all',array('conditions' => $whstart,'fields' => array('sum(point) as start')));
            if(!empty($start_point[0][0]['start'])){
                $User[$k]['User']['start_point']=$start_point[0][0]['start'];
                $point_start_sum[]=$User[$k]['User']['start_point'];
            }
            else{
                $User[$k]['User']['start_point']=0;
                $point_start_sum[]=0;
            }
            $whzc=$wh."and UserPointLog.created>'$datatime'and UserPointLog.point<0";
            if($end_time!=""){
                $whzc.=" and UserPointLog.created<'$end_time'";
            }
            $zc_point=$this->UserPointLog->find('all',array('conditions' => $whzc,'fields' => array('sum(point) as zc')));
            if(!empty($zc_point[0][0]['zc'])){
                $User[$k]['User']['zc_point']=$zc_point[0][0]['zc'];
                $point_zc_sum[]=$User[$k]['User']['zc_point'];
            }
            else{
                $User[$k]['User']['zc_point']=0;
                $point_zc_sum[]=0;
            }
            $whsl=$wh."and UserPointLog.created>'$datatime'and UserPointLog.point>0";
            if($end_time!=""){
                $whsl.=" and UserPointLog.created<'$end_time'";
            }
            $sl_point=$this->UserPointLog->find('all',array('conditions' => $whsl,'fields' => array('sum(point) as sl')));
            if(!empty($sl_point[0][0]['sl'])){
                $User[$k]['User']['sl_point']=$sl_point[0][0]['sl'];
                $point_sl_sum[]=$User[$k]['User']['sl_point'];
            }
            else{
                $User[$k]['User']['sl_point']=0;
                $point_sl_sum[]=0;
            }
            $pointsum=$start_point[0][0]['start']+$zc_point[0][0]['zc']+$sl_point[0][0]['sl'];
            $User[$k]['User']['pointsum']=$pointsum;
            $pointsums[]=$pointsum;
        }
        $point_start_sum=@array_sum(@$point_start_sum);
        $point_zc_sum=@array_sum(@$point_zc_sum);
        $point_sl_sum=@array_sum(@$point_sl_sum);
        $pointsums=@array_sum(@$pointsums);
        $this->set('User',$User);
        $this->set('point_start_sum',$point_start_sum);
        $this->set('point_zc_sum',$point_zc_sum);
        $this->set('point_sl_sum',$point_sl_sum);
        $this->set('pointsums',$pointsums);
        $this->set('start_time',date("Y-m-d",strtotime($start_time)));
        $this->set('end_time',date("Y-m-d",strtotime($end_time)));
        $this->set('locale',$order_locale);
        /*CSV导出*/
        if(isset($export) && $export==="export"){
            $filename='积分报表导出'.date('Ymd').'.csv';
            $ex_data="积分报表,";
            $ex_data.="选择日期:,";
            if(!empty($_REQUEST['start_time'])){
            	$ex_data.=$_REQUEST['start_time']."起,";
            }else{
            	$ex_data.=',';
            }
             if(!empty($_REQUEST['end_time'])){
            	$ex_data.="至".$_REQUEST['end_time']."\n";
            }else{
            	$ex_data.="\n";
            } 
            $ex_data.="用户名,";
            $ex_data.="起始积分,";
            $ex_data.="支出,";
            $ex_data.="收入,";
            $ex_data.="结余\n";
            foreach($User as $k => $v){
                $ex_data.=$v['User']['name'].",";
                $ex_data.=$v['User']['start_point'].",";
                $ex_data.=$v['User']['zc_point'].",";
                $ex_data.=$v['User']['sl_point'].",";
                $ex_data.=$v['User']['pointsum']."\n";
            }
            $ex_data.="总计,";
            $ex_data.=$point_start_sum.",";
            $ex_data.=$point_zc_sum.",";
            $ex_data.=$point_sl_sum.",";
            $ex_data.=$pointsums."\n";
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=gb2312");
            header("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8','gb2312',$ex_data."\n");
            exit;
        }
    }
    function consume($export=0){
        /*判断权限*/
        $this->operator_privilege('member_consume_statement_view');
        /*end*/
        $this->pageTitle='会员消费报表'." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '会员消费报表','url' => '/reports/consume/');
        $this->set('navigations',$this->navigations);
        $start_time='';
        $end_time='';    
        $condition = "1=1";    
        if($this->RequestHandler->isPost()){
            if(isset($this->params['form']['start_time']) && !empty($this->params['form']['start_time'])){
                $condition.=" and Order.modified >= '".$this->params['form']['start_time']."'";
                $start_time=$this->params['form']['start_time'];
            }
            if(isset($this->params['form']['end_time']) && !empty($this->params['form']['end_time'])){
                $condition.=" and Order.modified <= '".$this->params['form']['end_time']."'";
                $end_time=$this->params['form']['end_time'];
            }
        }
        //dam
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            if(isset($_REQUEST["order_locale"]) && !empty($_REQUEST["order_locale"])){
                $order_locale=$_REQUEST["order_locale"];
                $price_format=$this->currency_format[$order_locale];
                $condition.=" and Order.order_locale='$order_locale'";
            }
            else{
                $order_locale=$this->locale;
                $price_format=$this->currency_format[$order_locale];
                $condition.=" and Order.order_locale='$order_locale'";
            }
        }
        else{
            $price_format=$this->configs["price_format"];
            $order_locale=$this->locale;
        }
        $order_all = $this->Order->find("all",array('conditions' => $condition));
        $user_all = $this->User->find("all",array('fields' => array('id','name')));
        $new_user_all = array();
        foreach( $user_all as $k=>$v ){
        	$new_user_all[$v["User"]["id"]] = $v;
        }
        
        $order_user_id = array();
        $order_sum = array();
        $total_order_sum = 0;
        $total_order_product_sum = 0;
        $price_format_sum = 0;
        foreach( $order_all as $k=>$v ){
        	if(isset($new_user_all[$v["Order"]["user_id"]])){
	        	if(!in_array($v["Order"]["user_id"],$order_user_id)){
	        		$order_user_id[$v["Order"]["user_id"]] = $v["Order"]["user_id"];
	        		$order_sum[$v["Order"]["user_id"]]["user_name"] = isset($new_user_all[$v["Order"]["user_id"]])?$new_user_all[$v["Order"]["user_id"]]["User"]["name"]:"匿名用户";
	        		$order_sum[$v["Order"]["user_id"]]["order_sum"] = 0;
	        		$order_sum[$v["Order"]["user_id"]]["order_product_sum"] = 0;
	        		$order_sum[$v["Order"]["user_id"]]["order_money_paid_sum"] = 0;
	        	}
	        	$order_sum[$v["Order"]["user_id"]]["order_sum"]+= 1;
	        	$order_sum[$v["Order"]["user_id"]]["order_product_sum"]+= count($v["OrderProduct"]);
				$order_sum[$v["Order"]["user_id"]]["order_money_paid_sum"]+= $v["Order"]["money_paid"];
				$total_order_sum+= 1;
				$total_order_product_sum += count($v["OrderProduct"]);
				$price_format_sum += $v["Order"]["money_paid"];
			}
		}
        $this->set('order_sum',$order_sum);
        $this->set('total_order_sum',$total_order_sum);
        $this->set('total_order_product_sum',$total_order_product_sum);
        $this->set('price_format_sum',$price_format_sum);
        $this->set('price_format',$price_format);
        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);
        $this->set('locale',$order_locale);
        /*$condition=' 1=1 ';
        $start_time='';
        $end_time='';
        if($this->RequestHandler->isPost()){
            if(isset($this->params['form']['start_time']) && !empty($this->params['form']['start_time'])){
                $condition.=" and Order.modified >= '".$this->params['form']['start_time']."'";
                $start_time=$this->params['form']['start_time'];
            }
            if(isset($this->params['form']['end_time']) && !empty($this->params['form']['end_time'])){
                $condition.=" and Order.modified <= '".$this->params['form']['end_time']."'";
                $end_time=$this->params['form']['end_time'];
            }
        }
        $limit=10;
        $this->Order->hasMany=array();
        //dam
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            if(isset($_REQUEST["order_locale"]) && !empty($_REQUEST["order_locale"])){
                $order_locale=$_REQUEST["order_locale"];
                $price_format=$this->currency_format[$order_locale];
                $condition.=" and Order.order_locale='$order_locale'";
            }
            else{
                $order_locale=$this->locale;
                $price_format=$this->currency_format[$order_locale];
                $condition.=" and Order.order_locale='$order_locale'";
            }
        }
        else{
            $price_format=$this->configs["price_format"];
            $order_locale=$this->locale;
        }
        $data=$this->Order->find('all',array('conditions' => $condition,'fields' => array('DISTINCT Order.user_id')));
        $consume=array();
        $userid=array('-1');
        $sumallfee="0";
        foreach($data as $v){
            $userid[]="'".$v['Order']['user_id']."'";
            $conditiones["user_id"]=$v['Order']['user_id'];
            $datasum_arr=$this->Order->find("all",array("conditions" => $conditiones,"fields" => "Order.subtotal"));
            $sumtotal="";
            foreach($datasum_arr as $sk => $sv){
                $sumtotal += $sv['Order']['subtotal'];
            }
            $sumallfee += $sumtotal;
            $consume[$v['Order']['user_id']]['sumtotal']=sprintf($price_format,sprintf("%01.2f",$sumtotal));
            $consume[$v['Order']['user_id']]['countorder']=count($datasum_arr);
        }
        $condition2="User.id in(".implode(",",$userid).")";
        $users=$this->User->find('list',array('conditions' => $condition2,'limit' => $limit,'fields' => array('User.id','User.name')));
        //	pr($consume);pr($userid);
        $this->Order->bindModel(array('hasMany' => array('OrderProduct' =>
            array('className' => 'OrderProduct','conditions' => '','order' =>
            '','dependent' => true,'foreignKey' => 'order_id'
        ))));
        $condition.=" and Order.user_id in(".implode(",",$userid).")";
        $data=$this->Order->find('all',array('conditions' => $condition,'fields' => array('Order.user_id')));
        //	pr($data);
        foreach($data as $v){
            if(!empty($v['OrderProduct']))
            foreach($v['OrderProduct']as $vv){
                if(isset($consume[$v['Order']['user_id']]['sumquntity'])){
                    $consume[$v['Order']['user_id']]['sumquntity'] += $vv['product_quntity'];
                }
                else{
                    $consume[$v['Order']['user_id']]['sumquntity']=$vv['product_quntity'];
                }
            }
        }
        $this->set('users',$users);
        $this->set('orders',$consume);
        $this->set('sumallfee',$sumallfee);
        $this->set('price_format',$price_format);
        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);
        $this->set('locale',$order_locale);*/
        //CSV导出
        if(isset($export) && $export==="export"){
            $filename='会员消费报表导出'.date('Ymd').'.csv';
            $ex_data="会员消费报表,";
            $ex_data.="选择日期:,";
            if(!empty($_REQUEST['start_time'])){
            	$ex_data.=$_REQUEST['start_time']."起,";
            }else{
            	$ex_data.=',';
            }
             if(!empty($_REQUEST['end_time'])){
            	$ex_data.="至".$_REQUEST['end_time']."\n";
            }else{
            	$ex_data.="\n";
            } 
            $ex_data.="会员名称,";
            $ex_data.="订单数,";
            $ex_data.="商品数量,";
            $ex_data.="消费总金额\n";
            foreach($order_sum as $k => $v){
                $ex_data.=$v['user_name'].",";
                $ex_data.=$v['order_sum'].",";
				$ex_data.=$v['order_product_sum'].",";
				$ex_data.=$v['order_money_paid_sum']."\n";
            }
            $ex_data.="总计,";
            $ex_data.=$total_order_sum.",";
            $ex_data.=$total_order_product_sum.",";
            $sum_money=sprintf($price_format,sprintf("%01.2f",$price_format_sum));
            $ex_data.=$sum_money."\n";
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=gb2312");
            header("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8','gb2312',$ex_data."\n");
            exit;
        }
    }
    function sales($export=0,$orderby="number",$asc_desc="desc"){
        /*判断权限*/
        $this->operator_privilege('goods_sale_statement_view');
        /*end*/
        $this->pageTitle='商品销售报表'." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '商品销售报表','url' => '/reports/sales/');
        $this->set('navigations',$this->navigations);
        $condition="OrderProduct.status='1'";
        //DAM
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            if(isset($_REQUEST["order_locale"]) && !empty($_REQUEST["order_locale"])){
                $order_locale=$_REQUEST["order_locale"];
                $price_format=$this->currency_format[$order_locale];
                $condition2=" and Order.order_locale='$order_locale'";
            }
            else{
                $order_locale=$this->locale;
                $price_format=$this->currency_format[$order_locale];
                $condition2=" and Order.order_locale='$order_locale'";
            }
        }
        else{
            $price_format=$this->configs["price_format"];
            $order_locale=$this->locale;
        }
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            $order_info=$this->Order->find('all',array("conditions" => array("Order.order_locale" => $order_locale)));
            foreach($order_info as $k => $v){
                $order_id[]=$v["Order"]["id"];
            }
            $condition_order_id=" and OrderProduct.order_id in(".implode(",",$order_id).")";
            $condition.=$condition_order_id;
        }
        $start_time='';
        $end_time='';
        if($this->RequestHandler->isPost()){
            if(isset($this->params['form']['start_time']) && !empty($this->params['form']['start_time'])){
                $condition.=" and OrderProduct.modified >= '".$this->params['form']['start_time']."'";
                $start_time=$this->params['form']['start_time'];
            }
            if(isset($this->params['form']['end_time']) && !empty($this->params['form']['end_time'])){
                $condition.=" and OrderProduct.modified <= '".$this->params['form']['end_time']."'";
                $end_time=$this->params['form']['end_time'];
            }
        }
        $order = "product_quntity ".$asc_desc;
        if($orderby == "number"){
        	$order = "product_quntity ".$asc_desc;
        }
        if($orderby == "amount"){
        	$order = "product_price ".$asc_desc;
        }
        $data=$this->OrderProduct->find("all",array("conditions"=>$condition,"group"=>"product_code","order"=>$order,"fields"=>array("sum(product_quntity) as product_quntity,sum(product_price) as product_price,product_code,product_name")));
        $quntitysum = 0;
        $pricesum =0;
       	foreach($data as $k=>$v){
       		$quntitysum+=$v[0]["product_quntity"];
       		$pricesum+=$v[0]["product_price"];
       		$data[$k]["OrderProduct"]["product_quntity"]=$v[0]["product_quntity"];
       		$data[$k]["OrderProduct"]["product_price"]=sprintf($price_format,sprintf("%01.2f",$v[0]["product_price"]));
       	}
		
        $this->set('productcount',count($data));
        $this->set('quntitysum',$quntitysum);
        $this->set('pricesum',sprintf($price_format,sprintf("%01.2f",$pricesum)));
        $this->set('orderproducts',$data);
        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);
        $this->set('locale',$order_locale);
        $this->set('orderby',$orderby);
        $this->set('asc_desc',$asc_desc=="asc"?"desc":"asc");
        /*CSV导出*/
        if(isset($export) && $export==="export"){
            $filename='商品销售报表导出'.date('Ymd').'.csv';
            $ex_data="商品销售报表,";
            $ex_data.="选择日期:,";
            if(!empty($_REQUEST['start_time'])){
            	$ex_data.=$_REQUEST['start_time']."起,";
            }else{
            	$ex_data.=',';
            }
             if(!empty($_REQUEST['end_time'])){
            	$ex_data.="至".$_REQUEST['end_time']."\n";
            }else{
            	$ex_data.="\n";
            } 
            $ex_data.="货号,";
            $ex_data.="商品名称,";
            $ex_data.="数量,";
            $ex_data.="金额,";
            $ex_data.="\n";
            foreach($data as $v){
                $ex_data.=$v['OrderProduct']['product_code'].",";
                $ex_data.=$v['OrderProduct']['product_name'].",";
                $ex_data.=$v['OrderProduct']['product_quntity'].",";
                $ex_data.=$v['OrderProduct']['product_price']."\n";
            }
            $ex_data.="总计,";
            $ex_data.=count($data).",";
            $ex_data.=$quntitysum.",";
            $ex_data.=$pricesum."\n";
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=gb2312");
            header("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8','gb2312',$ex_data."\n");
            exit;
        }
    }
    function orderstatus($export=0){
        /*判断权限*/
        $this->operator_privilege('order_status_statement_view');
        /*end*/
        $this->pageTitle='订单状态报表'." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '订单状态报表','url' => '/reports/orderstatus/');
        $this->set('navigations',$this->navigations);
        $condition='1=1 ';
        $start_time='';
        $end_time='';
        if($this->RequestHandler->isPost()){
            if(isset($this->params['form']['start_time']) && !empty($this->params['form']['start_time'])){
                $condition.=" and Order.modified >= '".$this->params['form']['start_time']."'";
                $start_time=$this->params['form']['start_time'];
            }
            if(isset($this->params['form']['end_time']) && !empty($this->params['form']['end_time'])){
                $condition.=" and Order.modified <= '".$this->params['form']['end_time']."'";
                $end_time=$this->params['form']['end_time'];
            }
        }
        //DAM
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            if(isset($_REQUEST["order_locale"]) && !empty($_REQUEST["order_locale"])){
                $order_locale=$_REQUEST["order_locale"];
                $price_format=$this->currency_format[$order_locale];
                $condition.=" and Order.order_locale='$order_locale'";
            }
            else{
                $order_locale=$this->locale;
                $price_format=$this->currency_format[$order_locale];
                $condition.=" and Order.order_locale='$order_locale'";
            }
        }
        else{
            $price_format=$this->configs["price_format"];
            $order_locale=$this->locale;
        }
        $data=$this->Order->findAll($condition,'',"Order.created,Order.id");
        $order_status=array();
        $shipping_status=array();
        $payment_status=array();
        $payment=array();
        foreach($data as $k => $v){
            if(isset($order_status[$v['Order']['status']][$v['Order']['payment_id']])){
                $order_status[$v['Order']['status']][$v['Order']['payment_id']]++;
            }
            else{
                $order_status[$v['Order']['status']][$v['Order']['payment_id']]="1";
                $payment[$v['Order']['payment_id']]=$v['Order']['payment_name'];
            }
            if(isset($shipping_status[$v['Order']['shipping_status']][$v['Order']['payment_id']])){
                $shipping_status[$v['Order']['shipping_status']][$v['Order']['payment_id']]++;
            }
            else{
                $shipping_status[$v['Order']['shipping_status']][$v['Order']['payment_id']]="1";
            }
            if(isset($payment_status[$v['Order']['payment_status']][$v['Order']['payment_id']])){
                $payment_status[$v['Order']['payment_status']][$v['Order']['payment_id']]++;
            }
            else{
                $payment_status[$v['Order']['payment_status']][$v['Order']['payment_id']]="1";
            }
        }
        $this->set('payment',$payment);
        $this->set('order_status',$order_status);
        $this->set('shipping_status',$shipping_status);
        $this->set('payment_status',$payment_status);
        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);
        $this->set('locale',$order_locale);
        /*CSV导出*/
        if(isset($export) && $export==="export"){
            $filename='订单状态报表导出'.date('Ymd').'.csv';
            $ex_data="订单状态报表,";
            $ex_data.="选择日期:,";
            if(!empty($_REQUEST['start_time'])){
            	$ex_data.=$_REQUEST['start_time']."起,";
            }else{
            	$ex_data.=',';
            }
             if(!empty($_REQUEST['end_time'])){
            	$ex_data.="至".$_REQUEST['end_time']."\n";
            }else{
            	$ex_data.="\n";
            } 
            $ex_data.="支付方式,,,";
            $ex_data.="订单状态,,,,";
            $ex_data.="配送状态,,,,";
            $ex_data.="支付状态,";
            $ex_data.="\n";
            $ex_data.=",未确认 ,";
            $ex_data.="已确认,";
            $ex_data.="已取消,";
            $ex_data.="无效,";
            $ex_data.="退货,";
            $ex_data.="未发货,";
            $ex_data.="已发货,";
            $ex_data.="已收货,";
            $ex_data.="备货中,";
            $ex_data.="未付款,";
            $ex_data.="付款中,";
            $ex_data.="已付款,";
            $ex_data.="\n";
            foreach($payment as $k => $v){
                $ex_data.=$v.",";
                for($i=0;$i < 5;$i++){
                    if(isset($order_status[$i][$k])){
                        $ex_data.=$order_status[$i][$k].",";
                    }
                    else{
                        $ex_data.="0,";
                    }
                }
                for($i=0;$i < 4;$i++){
                    if(isset($shipping_status[$i][$k])){
                        $ex_data.=$shipping_status[$i][$k].",";
                    }
                    else{
                        $ex_data.="0,";
                    }
                }
                for($i=0;$i < 3;$i++){
                    if(isset($payment_status[$i][$k])){
                        $ex_data.=$payment_status[$i][$k].",";
                    }
                    else{
                        $ex_data.="0,";
                    }
                }
                $ex_data.="\n";
            }
            $ex_data.="合计,";
            for($i=0;$i < 5;$i++){
                if(isset($order_status[$i])){
                    $total_order[$i]=array_sum($order_status[$i]).",";
                }
                else{
                    $total_order[$i]="0,";
                }
            }
            for($i=0;$i < 4;$i++){
                if(isset($shipping_status[$i])){
                    $total_shipping[$i]=array_sum($shipping_status[$i]).",";
                }
                else{
                    $total_shipping[$i]="0,";
                }
            }
            for($i=0;$i < 3;$i++){
                if(isset($payment_status[$i])){
                    $total_payment[$i]=array_sum($payment_status[$i]).",";
                }
                else{
                    $total_payment[$i]="0,";
                }
            }
            foreach($total_order as $k => $v){
                $ex_data.=$v;
            }
            foreach($total_shipping as $k => $v){
                $ex_data.=$v;
            }
            foreach($total_payment as $k => $v){
                $ex_data.=$v;
            }
            $ex_data.="\n";
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=gb2312");
            header("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8','gb2312',$ex_data."\n");
            exit;
        }
    }
    function orderfee($export=0){
        /*判断权限*/
        $this->operator_privilege('order_perform_statement_view');
        /*end*/
        $this->pageTitle='订单业绩报表'." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '订单业绩报表','url' => '/reports/orderfee/');
        $this->set('navigations',$this->navigations);
        $now_year=date("Y");
        $now_month=date("m");
        for($i=10;$i >= 0;$i--){
            $now_year_arr[$now_year-10+$i]=$now_year-10+$i;
        }
        for($j=1;$j <= 12;$j++){
            $now_month_arr[$j]=$j;
        }
        $month=date('Y-m')."-01";
        if($this->RequestHandler->isPost()){
            if(isset($this->params['form']['month']) && !empty($this->params['form']['month'])){
                $year=$this->params['form']['year'];
                $now_month=$this->params['form']['month'];
                $month=$year."-".$now_month;
                $now_year=$year;
            }
        }
        $n=31;
        $month_timestamp=strtotime($month);
        if(date('Y-m')==date('Y-m',$month_timestamp)){
            $n=date('d');
        }
        else{
            $bigmonth=array(1,3,5,7,8,10,12);
            $m=date('m',$month_timestamp);
            if(in_array($m,$bigmonth)){
                $n=31;
            }
            else{
                $n=30;
            }
            if($m==2){
                if(date('Y',$month_timestamp)%4==0){
                    $n=29;
                }
                else{
                    $n=28;
                }
            }
        }
        //echo $n;exit;
        $oneday_timestamp=24*60*60;
        $order_status=array();
        //array('月份'=>array('状态'=>'数量'));
        $all_order_status=array();
        //根据订单状态作大统计用
        $all_order['order']=0;
        $all_order['product']=0;
        $all_order['total']=0;
        $newcondition="1=1";
        //dam
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            if(isset($_REQUEST["order_locale"]) && !empty($_REQUEST["order_locale"])){
                $order_locale=$_REQUEST["order_locale"];
                $price_format=$this->currency_format[$order_locale];
            }
            else{
                $order_locale=$this->locale;
                $price_format=$this->currency_format[$order_locale];
            }
            $newcondition.=" and Order.order_locale='$order_locale'";
        }
        else{
            $order_locale=$this->locale;
            $price_format=$this->configs["price_format"];
        }
        
        for($i=1;$i <= $n;$i++){
            $starttime=date("Y-m-d H:i:s",mktime(0,0,0,$now_month,$i,$now_year));
            $endtime=date("Y-m-d H:i:s",mktime(0,0,0,$now_month,$i,$now_year)+$oneday_timestamp);
            $newconditiona=" and Order.modified >= '".$starttime."'"." and Order.modified <'".$endtime."'";
            $condition=$newcondition.$newconditiona;
            $data=$this->Order->findAll($condition);
            $order_status[$i]['count_order']=count($data);
            //订单数量
            $all_order['order'] += $order_status[$i]['count_order'];
            $order_status[$i]['count_product']="0";
            //商品数量
            $order_status[$i]['sum_total']="0";
            //金额小计
            foreach($data as $k => $v){
                //计算金额
                $order_status[$i]['sum_total'] += $v['Order']['total'];
                $all_order['total'] += $v['Order']['total'];
                //根据订单状态作小统计
                if(isset($order_status[$i][$v['Order']['status']])){
                	if( $v['Order']['status'] != 1){
                		$order_status[$i][$v['Order']['status']]++;
                	}
                	if( $v['Order']['status'] == 1 && $v['Order']['shipping_status'] == 0 && $v['Order']['payment_status'] == 0){
                		$order_status[$i][$v['Order']['status']]++;
                	}
                	if($v['Order']['shipping_status'] == 1){
                		@$order_status[$i]["shipping"]++;
                	}
                	if($v['Order']['payment_status'] == 2 && $v['Order']['shipping_status']==0 || $v['Order']['shipping_status']==3){
                		
                		@$order_status[$i]["payments"]++;
                	}
                	
                }
                else{
                	if( $v['Order']['status'] != 1){
                    	$order_status[$i][$v['Order']['status']]="1";
                	}
                	if( $v['Order']['status'] == 1 && $v['Order']['shipping_status'] == 0 && $v['Order']['payment_status'] == 0){
                		$order_status[$i][$v['Order']['status']]="0";
                	}
                	if($v['Order']['shipping_status'] == 1){
                		$order_status[$i][$v['Order']['status']]="0";
                		@$order_status[$i]["shipping"] = "1";
                	}
                	if($v['Order']['payment_status'] == 2 && $v['Order']['shipping_status']==0 || $v['Order']['shipping_status']==3){
                		$order_status[$i][$v['Order']['status']]="0";
                		@$order_status[$i]["payments"] = "1";
                	}
                }
                //
                if(isset($all_order_status[$v['Order']['status']])){
                	if( $v['Order']['status'] != 1){
                  	  	$all_order_status[$v['Order']['status']]++;
                	}
                	if( $v['Order']['status'] == 1 && $v['Order']['shipping_status'] == 0 && $v['Order']['payment_status'] == 0){
                		$all_order_status[$v['Order']['status']]++;
                	}
                	if($v['Order']['shipping_status'] == 1){
                		@$all_order_status["shipping"]++;
                	}
                	if($v['Order']['payment_status'] == 2 && $v['Order']['shipping_status']==0 || $v['Order']['shipping_status']==3){
                		
                		@$all_order_status["payments"]++;
                	}
                }
                else{
                	if( $v['Order']['status'] != 1){
                    	$all_order_status[$v['Order']['status']]="1";
                    }	
                    if( $v['Order']['status'] == 1 && $v['Order']['shipping_status'] == 0 && $v['Order']['payment_status'] == 0){
                    	$all_order_status[$v['Order']['status']]="0";
                	}
                	if($v['Order']['shipping_status'] == 1){
                		$all_order_status[$v['Order']['status']]="0";
                		$all_order_status["shipping"]="1";
                	}
                	if($v['Order']['payment_status'] == 2 && $v['Order']['shipping_status']==0 || $v['Order']['shipping_status']==3){
                		$all_order_status[$v['Order']['status']]="0";
                		$all_order_status["payments"]="1";
                	}
                }
                //计算商品数量
                if(!empty($v['OrderProduct'])){
                    foreach($v['OrderProduct']as $vv){
                        $order_status[$i]['count_product'] += $vv['product_quntity'];
                        $all_order['product'] += $vv['product_quntity'];
                    }
                }
            }
        }
        $monthes=array('2008-01' => '2008-01-01','2008-02' => '2008-02-01','2008-03' => '2008-03-01','2008-04' => '2008-04-01','2008-05' => '2008-05-01','2008-06' => '2008-06-01','2008-07' => '2008-07-01','2008-08' => '2008-08-01','2008-09' => '2008-09-01','2008-10' => '2008-10-01','2008-11' => '2008-11-01','2008-12' => '2008-12-01');
        $all_order['total']=sprintf($price_format,sprintf("%01.2f",$all_order['total']));
        foreach($order_status as $k => $v){
            $order_status[$k]['sum_total']=sprintf($price_format,sprintf("%01.2f",$v['sum_total']));
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
        $this->set('locale',$order_locale);
        
        /*CSV导出*/
        if(isset($export) && $export==="export"){
            $temp=explode('-',$month);
            $filename='订单业绩报表导出'.date('Ymd').'.csv';
            $ex_data="订单业绩报表,";
            $ex_data.="统计月份：,";
            $ex_data.=$temp[0]."年".$temp[1]."月\n";
            $ex_data.="时间,,,";
            $ex_data.="订单状态,,,";
            $ex_data.="订单数量,";
            $ex_data.="数量小计,";
            $ex_data.="金额小计\n";
            $ex_data.=$temp[0]."年".$temp[1]."月,";
            $ex_data.="未确认,";
            $ex_data.="已确认,";
            $ex_data.="已取消,";
            $ex_data.="无效,";
            $ex_data.="退货\n";
            foreach($order_status as $k => $v){
                $ex_data.=$k."日,";
                for($i=0;$i < 5;$i++){
                    if(isset($v[$i])){
                        $ex_data.=$v[$i].",";
                    }
                    else{
                        $ex_data.="0,";
                    }
                }
                $ex_data.=$v['count_order'].",";
                $ex_data.=$v['count_product'].",";
                $ex_data.=$v['sum_total']."\n";
            }
            $ex_data.="总计,";
            for($i=0;$i < 5;$i++){
                if(isset($all_order_status[$i])){
                    $ex_data.=$all_order_status[$i].",";
                }
                else{
                    $ex_data.="0,";
                }
            }
            $ex_data.=$all_order['order'].",";
            $ex_data.=$all_order['product'].",";
            $ex_data.=$all_order['total']."\n";
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=gb2312");
            header("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8','gb2312',$ex_data."\n");
            exit;
        }
    }
    
     function returns($export=0){
        /*判断权限*/
        $this->operator_privilege('order_return_view');
        /*end*/
        $this->pageTitle='退货单报表'." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '退货单报表','url' => '/reports/back/');
        $this->set('navigations',$this->navigations);
        // 增加关联
        $this->Order->bindModel(array('hasMany' => array('OrderProduct' =>
            array('className' => 'OrderProduct','conditions' => '','order' =>
            '','dependent' => true,'foreignKey' => 'order_id'
        ))));
        $condition="Order.status='4' ";
        $start_time='';
        $end_time='';
        if($this->RequestHandler->isPost()){
            if(isset($this->params['form']['start_time']) && !empty($this->params['form']['start_time'])){
                $condition.=" and Order.modified >= '".$this->params['form']['start_time']."'";
                $start_time=$this->params['form']['start_time'];
            }
            if(isset($this->params['form']['end_time']) && !empty($this->params['form']['end_time'])){
                $condition.=" and Order.modified <= '".$this->params['form']['end_time']."'";
                $end_time=$this->params['form']['end_time'];
            }
        }
        //DAM
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            if(isset($_REQUEST["order_locale"]) && !empty($_REQUEST["order_locale"]) && $_REQUEST["order_locale"]!="all"){
                $order_locale=$_REQUEST["order_locale"];
                $price_format=$this->currency_format[$order_locale];
                $condition.=" and Order.order_locale='$order_locale'";
            }
            else{
                $order_locale="all";
            }
        }
        else{
            $price_format=$this->configs["price_format"];
            $order_locale="all";
        }
        $data=$this->Order->findAll($condition,'',"Order.created,Order.id desc");
        foreach($data as $k => $v){
            $price_format=$this->configs['price_format'];
            //DAM
            if(isset($this->configs["mlti_currency_module"]) && $this->configs["mlti_currency_module"]==1){
                if($v["Order"]["order_locale"]!=' '){
                    $price_format=$this->currency_format[$v["Order"]["order_locale"]];
                }
                else{
                    $price_format=$this->configs['price_format'];
                }
            }
            //
            $data[$k]['Order']['total']=sprintf($price_format,sprintf("%01.2f",$v['Order']['total']));
            $data[$k]['Order']['total']=sprintf($price_format,sprintf("%01.2f",$v['Order']['total']));
            foreach($v['OrderProduct']as $kk => $op){
                $data[$k]['OrderProduct'][$kk]['product_price']=sprintf($price_format,sprintf("%01.2f",$op['product_price']));
            }
        }
        $this->set('orders',$data);
        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);
        $this->set('locale',$order_locale);
        /*CSV导出*/
        if(isset($export) && $export==="export"){
            $filename='退货单报表导出'.date('Ymd').'.csv';
            $ex_data="退货单统计报表,";
            $ex_data.="选择日期:,";
            if(!empty($_REQUEST['start_time'])){
            	$ex_data.=$_REQUEST['start_time']."起,";
            }else{
            	$ex_data.=',';
            }
             if(!empty($_REQUEST['end_time'])){
            	$ex_data.="至".$_REQUEST['end_time']."\n";
            }else{
            	$ex_data.="\n";
            } 
            $ex_data.="订单号,";
            $ex_data.="姓名,";
            $ex_data.="地址,";
            $ex_data.="电话,";
            $ex_data.="付款方式,";
            $ex_data.="操作日期,";
            $ex_data.="金额总计\n";
            foreach($data as $v){
                $ex_data.=$v['Order']['order_code'].",";
                $ex_data.=$v['Order']['consignee'].",";
                $ex_data.=$v['Order']['address'].",";
                $ex_data.=$v['Order']['telephone'].",";
                $ex_data.=$v['Order']['payment_name'].",";
                $ex_data.=$v['Order']['payment_time'].",";
                $ex_data.=$v['Order']['total']."\n";
                $ex_data.=",";
                $ex_data.="货号,";
                $ex_data.="商品名称,";
                $ex_data.="数量,";
                $ex_data.="属性,";
                $ex_data.="价格\n";
                if(isset($v['OrderProduct'])){
                    foreach($v['OrderProduct']as $op){
                        $ex_data.=",".$op['product_code'].",";
                        $ex_data.=$op['product_name'].",";
                        $ex_data.=$op['product_quntity'].",";
                        $ex_data.=$op['product_attrbute'].",";
                        $ex_data.=$op['product_price']."\n";
                    }
                }
            }
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=gb2312");
            header("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8','gb2312',$ex_data."\n");
            exit;
        }
    }  
    
    function batch_return_print(){
        $this->pageTitle='配送单打印'." - ".$this->configs['shop_name'];
        $pro_ids='';
        if($this->params['form']['act']=='batch'){
            $pro_ids=!empty($this->params['form']['checkboxes']) ? $this->params['form']['checkboxes']: 0;
        }
        else{
            $pro_ids[]=!empty($this->params['form']['orderr_id']) ? $this->params['form']['orderr_id']: 0;
        }
        if(!empty($pro_ids)){
            $all_order_info=array();
            foreach($pro_ids as $vid){
                $order_info=array();
                //取得订单及订单商品信息
                $order_info=$this->Order->findById($vid);
                //格式化价格数据
                $order_info['Order']['format_shipping_fee'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['shipping_fee']));
                $order_info['Order']['format_point_fee'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['point_fee']));
                $order_info['Order']['format_payment_fee'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['payment_fee']));
                $order_info['Order']['format_money_paid'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['money_paid']));
                $order_info['Order']['format_total'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['total']));
                $order_info['Order']['format_subtotal'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['subtotal']));
                $order_info['Order']['format_tax'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['tax']));
                $order_info['Order']['format_insure_fee'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['insure_fee']));
                $order_info['Order']['format_pack_fee'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['pack_fee']));
                $order_info['Order']['format_card_fee'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['card_fee']));
                $order_info['Order']['format_should_pay'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['total']-$order_info['Order']['money_paid']-$order_info['Order']['point_fee']));
                $order_info['Order']['regionname']=array();
                //取得收货人的地址
                $regionid=array();
                $regionname1=array();
                if(!empty($order_info['Order']['regions'])){
                    $regionid=explode(" ",$order_info['Order']['regions']);
                    foreach($regionid as $vid){
                        if(!empty($vid)){
                            $regionname1[]=$this->RegionI18n->find('list',array('fields' => ('name'),'conditions' => array('RegionI18n.region_id' => $vid,'RegionI18n.locale' => $this->locale)));
                        }
                    }
                }
                $order_info['Order']['regionname']=$regionname1;
                //商品小计
                foreach($order_info['OrderProduct']as $kk => $vv){
                    $order_info['OrderProduct'][$kk]['product_total']='';
                    $order_info['OrderProduct'][$kk]['product_total']=sprintf($this->configs['price_format'],sprintf("%01.2f",$vv['product_price']*$vv['product_quntity']));
                    $order_info['OrderProduct'][$kk]['product_price']=sprintf($this->configs['price_format'],sprintf("%01.2f",$vv['product_price']));
                }
                $all_order_info[]=$order_info;
            }
            //pr($all_order_info);
            $this->set('all_order_info',$all_order_info);
            $this->layout='ajax';
        }
    } 
}
?>