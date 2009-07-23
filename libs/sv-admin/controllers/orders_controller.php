<?php
/*****************************************************************************
 * SV-Cart 订单管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: orders_controller.php 3238 2009-07-22 12:49:40Z huangbo $
 *****************************************************************************/
class OrdersController extends AppController{
    var $name='Orders';
    var $components=array('Pagination','RequestHandler','Email');
    var $helpers=array('Pagination');
    var $uses=array('SystemResource','SystemResourceI18n','ProductRank','UserRank','OrderCard','OrderPackaging','Operator','RegionI18n','Region','VirtualCard','Shipping','Order','OrderProduct','UserAddress','Payment','Shipping','OrderProduct','User','Product','OrderAction','Category','Brand','ProductAttribute','ProductTypeAttribute','UserBalanceLog','ShippingArea','MailTemplate','UserConfig','UserPointLog','UserBalanceLog','CouponType','Coupon','PaymentApiLog');
    function search($export=0){
        $this->operator_privilege('order_undeal_view');
        $this->pageTitle='待处理订单'." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '待处理订单','url' => '/orders/search/processing');
        $this->set('navigations',$this->navigations);
        if($_SESSION['Operator_Info']['Operator']['actions']=='all'){
            $condition="Order.status not in(2,3) and (Order.payment_status<>'2' or Order.shipping_status<>'2')";
        }
        else{
            $condition="Order.status not in(2,3) and (Order.payment_status<>'2' or Order.shipping_status<>'2') and (Order.operator_id=".$_SESSION['Operator_Info']['Operator']['id']." or Order.operator_id='0') ";
        }
        $total=$this->Order->findCount($condition,0);
        $sortClass='Order';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        $orders_list=$this->Order->findAll($condition,'',"created desc",$rownum,$page);
        foreach($orders_list as $k => $v){
            $orders_list[$k]['Order']['should_pay']=sprintf($this->configs['price_format'],sprintf("%01.2f",$v['Order']['subtotal']-$v['Order']['money_paid']));
            $orders_list[$k]['Order']['subtotal']=sprintf($this->configs['price_format'],$v['Order']['subtotal']);
        }
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();
       	//
       	$this->set('orders_list',$orders_list);
       	$this->set('systemresource_info',$systemresource_info);//资源库信息
       	
        if(isset($_REQUEST['page']) && !empty($_REQUEST['page'])){
            $this->set('ex_page',$this->params['url']['page']);
        }
        /*CSV导出*/
        if(isset($_REQUEST['export']) && $_REQUEST['export']==="export"){
            $filename='待处理订单导出'.date('Ymd').'.csv';
            $ex_data="待处理订单统计报表,";
            $ex_data.="日期,";
            $ex_data.=date('Y-m-d')."\n";
            $ex_data.="订单号,";
            $ex_data.="下单时间,";
            $ex_data.="收货人,";
            $ex_data.="费用,";
            $ex_data.="支付方式,";
            $ex_data.="配送方式,";
            $ex_data.="订单状态,";
            $ex_data.="\n";
            foreach($orders_list as $k => $v){
                $ex_data.=$v['Order']['order_code'].",";
                $ex_data.=$v['Order']['created'].",";
                $ex_data.=$v['Order']['consignee']." ";
                if(!empty($v['Order']['telephone'])){
                    $ex_data.="[".$v['Order']['telephone']."]  ";
                }
                $ex_data.=$v['Order']['address'].",";
                $ex_data.='总金额:'.$v['Order']['subtotal']." ";
                $ex_data.='应付金额:'.$v['Order']['should_pay'].",";
                $ex_data.=$v['Order']['payment_name'].",";
                $ex_data.=$v['Order']['shipping_name'].",";
				$ex_data.= 	$systemresource_info["order_status"][$v['Order']['status']]." ".
							$systemresource_info["payment_status"][$v['Order']['payment_status']]." ".
							$systemresource_info["shipping_status"][$v['Order']['shipping_status']]."\n";

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
    function index($export=0){
        $this->operator_privilege('order_view');
        $this->pageTitle="订单管理"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '订单管理','url' => '/orders/');
        $this->set('navigations',$this->navigations);

        if($_SESSION['Operator_Info']['Operator']['actions']=='all'){
            $condition="";
        }
        else{
            $condition["or"]["Order.operator_id"]=$_SESSION['Operator_Info']['Operator']['id'];
            $condition["or"]["Order.operator_id"]="0";
        }
        if(isset($this->params['url']['user_id']) && $this->params['url']['user_id']!='-1'){
            $condition["and"]["Order.user_id"]="".$this->params['url']['user_id']."";
        }
        if(isset($this->params['url']['payment_id']) && $this->params['url']['payment_id']!='-1'){
            $condition["and"]["Order.payment_id"]="".$this->params['url']['payment_id']."";
        }
        if(isset($this->params['url']['order_status']) && $this->params['url']['order_status']!='-1'){
            $condition["and"]["Order.status"]="".$this->params['url']['order_status']."";
        }
        if(isset($this->params['url']['payment_status']) && $this->params['url']['payment_status']!='-1'){
            $condition["and"]["Order.payment_status"]="".$this->params['url']['payment_status']."";
        }
        if(isset($this->params['url']['shipping_status']) && $this->params['url']['shipping_status']!='-1'){
            $condition["and"]["Order.shipping_status"]="".$this->params['url']['shipping_status']."";
        }
        if(isset($this->params['url']['order_id']) && $this->params['url']['order_id']!=''){
            $condition["and"]["Order.order_code"]=$this->params['url']['order_id'];
        }
        if(isset($this->params['url']['consignee']) && $this->params['url']['consignee']!=''){
            $condition["or"]["Order.consignee like"]="%".$this->params['url']['consignee']."%";
            $condition["or"]["Order.telephone like"]="%".$this->params['url']['consignee']."%";
        }
        if(isset($this->params['url']['date']) && $this->params['url']['date']!=''){
            $condition["and"]["Order.created >="]="".$this->params['url']['date']." 00:00:00";
            $this->set("start_time",$this->params['url']['date']);
        }
        if(isset($this->params['url']['date2']) && $this->params['url']['date2']!=''){
            $condition["and"]["Order.created <="]="".$this->params['url']['date2']." 23:59:59";
            $this->set("end_time",$this->params['url']['date2']);
        }
        
        //dam
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            if(isset($_REQUEST["order_locale"]) && !empty($_REQUEST["order_locale"]) && $_REQUEST["order_locale"]!="all"){
                $order_locale=$_REQUEST["order_locale"];
                $price_format=$this->currency_format[$order_locale];
                $condition["and"]["Order.order_locale ="]=$order_locale;
            }
            else{
                $order_locale="all";
            }
        }
        else{
            $order_locale="all";
        }
        $total=$this->Order->findCount($condition,0);
        $sortClass='Order';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        if(isset($export) && $export==="export"){
        	$orders_list=$this->Order->findAll($condition,'',"Order.created DESC");
        }else{
        	$orders_list=$this->Order->findAll($condition,'',"Order.created DESC",$rownum,$page);
        }       
        foreach($orders_list as $k => $v){
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
            $orders_list[$k]['Order']['should_pay']=sprintf($price_format,sprintf("%01.2f",$v['Order']['total']-$v['Order']['money_paid']-$v['Order']['point_fee']));
            $orders_list[$k]['Order']['subtotal']=sprintf($price_format,$v['Order']['subtotal']);
            $orders_list[$k]['Order']['total']=sprintf($price_format,$v['Order']['total']);
        }
        $order_status=isset($this->params['url']['order_status']) ? $this->params['url']['order_status']: -1;
        $payment_status=isset($this->params['url']['payment_status']) ? $this->params['url']['payment_status']: -1;
        $shipping_status=isset($this->params['url']['shipping_status']) ? $this->params['url']['shipping_status']: -1;
        $order_id=isset($this->params['url']['order_id']) ? $this->params['url']['order_id']: '';
        $consignee=isset($this->params['url']['consignee']) ? $this->params['url']['consignee']: '';
        $start_date=isset($this->params['url']['start_date']) ? $this->params['url']['start_date']: '';
        $end_date=isset($this->params['url']['end_date']) ? $this->params['url']['end_date']: '';
        $this->navigations[]=array('name' => '订单管理','url' => '/orders/');
        $this->Shipping->set_locale($this->locale);
        $shipping_list=$this->Shipping->shipping_list();
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//
       	//支持货到付款的配送方式
       	$is_cod_shipping = array();
       	foreach($shipping_list as $ks=>$kv)
       	{
       		if($kv['Shipping']['support_cod']==1) $is_cod_shipping[]=$kv['Shipping']['id'];
       	}
       	foreach($orders_list as $k1=>$v1)
       	{
       		$orders_list[$k1]['Order']['is_cod']=(in_array($v1['Order']['shipping_id'],$is_cod_shipping)?1:0);
       		$orders_list[$k1]['Order']['allvirtual']=0;
       		$virtualnum = 0;
       		foreach($v1['OrderProduct'] as $k2=>$v2)
       		{
       			$aa = isset($v2['extension_code'])?$v2['extension_code']:'0';
                $virtualnum += (($aa=='virtual_card')?1:0);
       		}
       		$orders_list[$k1]['Order']['allvirtual']=(count($v1['OrderProduct'])==$virtualnum)?1:0;
       	}
        $this->set('shipping_list',$shipping_list);
        $this->set('orders_list',$orders_list);
        $this->set('order_status',$order_status);
        $this->set('payment_status',$payment_status);
        $this->set('shipping_status',$shipping_status);
        $this->set('order_id',$order_id);
        $this->set('consignee',$consignee);
        $this->set('start_date',$start_date);
        $this->set('end_date',$end_date);
        $this->set('navigations',$this->navigations);
        $this->set('locale',$order_locale);
        $this->set('systemresource_info',$systemresource_info);
        
    /*    if(isset($_REQUEST['page']) && !empty($_REQUEST['page'])){
            $this->set('ex_page',$this->params['url']['page']);
        }
        if(isset($_REQUEST['date'])){
            $ex_url="date=".$this->params['url']['date']."&date2=".$this->params['url']['date2']."&consignee=".$this->params['url']['consignee']."&order_id=".$this->params['url']['order_id']."&order_status=".$this->params['url']['order_status']."&shipping_status=".$this->params['url']['shipping_status']."&payment_status=".$this->params['url']['payment_status']."&order_locale=".$order_locale;
        }
        else{
            $ex_url="date=&date2=&consignee=&order_id=&order_status=-1&shipping_status=-1&payment_status=-1&order_locale=all";
        }
        $this->set('ex_url',$ex_url);
        /*CSV导出*/
      //  if(isset($_REQUEST['export']) && $_REQUEST['export']==="export"){
      	if(isset($export) && $export==="export"){
            $filename='订单导出'.date('Ymd').'.csv';
            $ex_data="订单统计报表,";
            $ex_data.="日期,";
            $ex_data.=date('Y-m-d')."\n";
            $ex_data.="订单号,";
            $ex_data.="下单时间,";
            $ex_data.="收货人,";
            $ex_data.="费用,";
            $ex_data.="支付方式,";
            $ex_data.="配送方式,";
            $ex_data.="订单状态,";
            $ex_data.="\n";
            foreach($orders_list as $k => $v){
                $ex_data.=$v['Order']['order_code'].",";
                $ex_data.=$v['Order']['created'].",";
                $ex_data.=$v['Order']['consignee']." ";
                if(!empty($v['Order']['telephone'])){
                    $ex_data.="[".$v['Order']['telephone']."]  ";
                }
                $ex_data.=$v['Order']['address'].",";
                $ex_data.='总金额:'.$v['Order']['subtotal']." ";
                $ex_data.='应付金额:'.$v['Order']['should_pay'].",";
                $ex_data.=$v['Order']['payment_name'].",";
                $ex_data.=$v['Order']['shipping_name'].",";
				$ex_data.= 	$systemresource_info["order_status"][$v['Order']['status']]." ".
							$systemresource_info["payment_status"][$v['Order']['payment_status']]." ".
							$systemresource_info["shipping_status"][$v['Order']['shipping_status']]."\n";
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
    function view($id){
        $this->operator_privilege('order_edit');
        
        $order_info=$this->Order->findbyid($id);//订单信息
        
        $this->pageTitle="查看订单-订单管理"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '订单管理','url' => '/orders/');
        $this->navigations[]=array('name' => '查看订单','url' => '');
        $this->navigations[]=array('name' => $order_info["Order"]["order_code"],'url' => '');
        $this->set('navigations',$this->navigations);
    	
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();
       	//
        //DAM
        $price_format=$this->configs['price_format'];
        if(isset($this->configs["mlti_currency_module"]) && $this->configs["mlti_currency_module"]==1){
            if($order_info["Order"]["order_locale"]!=' '){
                $price_format=$this->currency_format[$order_info["Order"]["order_locale"]];
            }
            else{
                $price_format=$this->configs['price_format'];
            }
        }
        $this->configs['price_format']=$price_format;
       	//标签
       	$wh['UserAddress.regions']=trim($order_info['Order']['regions']);
        $wh['UserAddress.user_id']=trim($order_info['Order']['user_id']);
        $regions_names_arr=$this->UserAddress->find($wh);
        $order_info['Order']['regions_names']=$regions_names_arr['UserAddress']['name'];
       	//区域 
       	$regions = $order_info["Order"]["regions"];
       	$regions = explode(" ",$regions);
       	$this->Region->set_locale($this->locale);
       	$regions_info = $this->Region->find("all");
       	$new_regions_info = array();
       	foreach($regions_info as $k=>$v){
       		if($v["Region"]["parent_id"]==0){
       			$new_regions_info[$regions[0]][$k] = $v;
       		}
       		if($v["Region"]["parent_id"]==@$regions[0]){
       			$new_regions_info[$regions[1]][$k] = $v;
       		}
       		if($v["Region"]["parent_id"]==@$regions[1]){
       			$new_regions_info[$regions[2]][$k] = $v;
       		}
       		if($v["Region"]["parent_id"]==@$regions[2]){
       			$new_regions_info[$regions[3]][$k] = $v;
       		}
       	}
       	//钱
        $order_info['Order']['pro_weight']=0;
        $product_id_arr = array();
        foreach($order_info['OrderProduct']as $k => $v){
        	$product_id_arr[] = $v['product_id'];
            $products[$k]=$this->OrderProduct->find("OrderProduct.product_id = ".$v['product_id']."");
            $order_info['Order']['pro_weight'] += $products[$k]['Product']['weight'];
            $order_info['OrderProduct'][$k]['total']=sprintf($this->configs['price_format'],sprintf("%01.2f",$v['product_quntity']*$v['product_price']));
        }
        //是否使用余额
        $balance_log_filter="1=1";
        $balance_log_filter .= " and UserBalanceLog.type_id = ".$id." and UserBalanceLog.user_id = ".$order_info["Order"]["user_id"]." and UserBalanceLog.log_type = 'O'";
        $balance_log=$this->UserBalanceLog->find($balance_log_filter);
        $balance_log["UserBalanceLog"]["amount"]=!empty($balance_log["UserBalanceLog"]["amount"]) ? $balance_log["UserBalanceLog"]["amount"]: "0";
        $this->CouponType->set_locale($this->locale);
        $coupon_info=$this->Coupon->findById($order_info["Order"]["coupon_id"]);
        $coupon_types_info=$this->CouponType->findById($coupon_info["Coupon"]["coupon_type_id"]);
        $order_info['Order']['coupon_fee']=sprintf($this->configs['price_format'],sprintf("%01.2f",$coupon_info["Coupon"]["order_amount_discount"]));
        $order_info['Order']['coupon_type_name']=$coupon_types_info["CouponTypeI18n"]["name"];
        $coupon_types_list=$this->CouponType->findall();
        //应付款金额
        $Order_total=$order_info['Order']['subtotal']-$order_info['Order']['discount']+$order_info['Order']['tax']+$order_info['Order']['shipping_fee']+$order_info['Order']['insure_fee']+$order_info['Order']['payment_fee']+$order_info['Order']['pack_fee']+$order_info['Order']['card_fee'];
        $maney_fee=round($Order_total-$order_info['Order']['money_paid']+$balance_log["UserBalanceLog"]["amount"]-$order_info['Order']['point_fee']-$coupon_info["Coupon"]["order_amount_discount"],2);
        $order_info['Order']['amount_payable']=sprintf($this->configs['price_format'],sprintf("%01.2f",$maney_fee));
        //操作信息列表
        $action_list=$this->OrderAction->findAll("OrderAction.order_id = '".$id."'",'','OrderAction.created desc');
        //商品
        $this->Product->hasOne = array();
        $this->Product->hasMany = array();
       
        $product_img = $this->Product->find("all",array("conditions"=>array("id"=>$product_id_arr),"fields"=>array("img_thumb","id","market_price")));
        $product_img_new = array();
        foreach( $product_img as $k=>$v ){
        	$product_img_new[$v["Product"]["id"]] = $v;
        }
		$this->set('balance_log',$balance_log); //是否使用余额
       	$this->set('new_regions_info',$new_regions_info);
       	$this->set('product_img_new',$product_img_new);
        $this->set('regions',$regions);
        $this->set('systemresource_info',$systemresource_info);//
    	$this->set('order_info',$order_info);//订单信息
    	$this->set('price_format',$this->configs['price_format']);
    	$this->set('action_list',$action_list);
    }
    function edit($id){
        $this->operator_privilege('order_edit');
        $order_info=$this->Order->findbyid($id);
        
        $this->pageTitle="编辑订单-订单管理"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '订单管理','url' => '/orders/');
        $this->navigations[]=array('name' => '编辑订单','url' => '');
        $this->navigations[]=array('name' => $order_info["Order"]["order_code"],'url' => '');
        $this->set('navigations',$this->navigations);
        
        //DAM
        $price_format=$this->configs['price_format'];
        if(isset($this->configs["mlti_currency_module"]) && $this->configs["mlti_currency_module"]==1){
            if($order_info["Order"]["order_locale"]!=' '){
                $price_format=$this->currency_format[$order_info["Order"]["order_locale"]];
            }
            else{
                $price_format=$this->configs['price_format'];
            }
        }
        $this->configs['price_format']=$price_format;
        $coupon_info=$this->Coupon->findById($order_info["Order"]["coupon_id"]);
        //是否使用余额
        $balance_log_filter="1=1";
        $balance_log_filter .= " and UserBalanceLog.type_id = ".$id." and UserBalanceLog.user_id = ".$order_info["Order"]["user_id"]." and UserBalanceLog.log_type = 'O'";
        $balance_log=$this->UserBalanceLog->find($balance_log_filter);
        $balance_log["UserBalanceLog"]["amount"]=!empty($balance_log["UserBalanceLog"]["amount"]) ? $balance_log["UserBalanceLog"]["amount"]: "0";
        $this->CouponType->set_locale($this->locale);
        $coupon_types_info=$this->CouponType->findById($coupon_info["Coupon"]["coupon_type_id"]);
        $order_info['Order']['coupon_fee']=sprintf($this->configs['price_format'],sprintf("%01.2f",$coupon_info["Coupon"]["order_amount_discount"]));
        $order_info['Order']['coupon_type_name']=$coupon_types_info["CouponTypeI18n"]["name"];
        $coupon_types_list=$this->CouponType->findall();
        //应付款金额
        $Order_total=$order_info['Order']['subtotal']-$order_info['Order']['discount']+$order_info['Order']['tax']+$order_info['Order']['shipping_fee']+$order_info['Order']['insure_fee']+$order_info['Order']['payment_fee']+$order_info['Order']['pack_fee']+$order_info['Order']['card_fee'];
        $maney_fee=round($Order_total-$order_info['Order']['money_paid']+$balance_log["UserBalanceLog"]["amount"]-$order_info['Order']['point_fee']-$coupon_info["Coupon"]["order_amount_discount"],2);
        $order_info['Order']['amount_payable']=sprintf($this->configs['price_format'],sprintf("%01.2f",$maney_fee));
        //$order_info['Order']['subtotal']=sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['subtotal']));
        $pay_log=$this->PaymentApiLog->find(" PaymentApiLog.type = '0' and PaymentApiLog.type_id =".$id);
        $pay_log['PaymentApiLog']['amount']=$maney_fee;
        $this->PaymentApiLog->save($pay_log['PaymentApiLog']);
        $user_info=$this->User->findbyid($order_info['Order']['user_id']);
        $this->Payment->set_locale($this->locale);
        $payment_list=$this->Payment->findAll(array("Payment.status" => 1));
        
        $this->Shipping->set_locale($this->locale);
        $shipping_listt=$this->Shipping->shipping_list();
        //支持货到付款的配送方式
       	$is_cod_shipping = array();
       	foreach($shipping_listt as $ks=>$kv)
       	{
       		if($kv['Shipping']['support_cod']==1) $is_cod_shipping[]=$kv['Shipping']['id'];
       	}
        $order_info['Order']['is_cod']=(in_array($order_info['Order']['shipping_id'],$is_cod_shipping)?1:0);
        $order_info['Order']['pro_weight']=0;
        $order_info['Order']['allvirtual']=0;
        $virtualnum = 0;
        foreach($order_info['OrderProduct']as $k => $v){
            $products[$k]=$this->OrderProduct->find("OrderProduct.product_id = ".$v['product_id']."");
            $order_info['Order']['pro_weight'] += $products[$k]['Product']['weight'];
            $order_info['OrderProduct'][$k]['total']=sprintf($this->configs['price_format'],sprintf("%01.2f",$v['product_quntity']*$v['product_price']));
            
            $aa = isset($v['extension_code'])?$v['extension_code']:'0';
                    $virtualnum += (($aa=='virtual_card')?1:0);
        }
        $order_info['Order']['allvirtual']=(count($order_info['OrderProduct'])==$virtualnum)?1:0;
        
        $this->Shipping->set_locale($this->locale);
        $res=$this->Shipping->findAll(array("Shipping.status" => "1"));
        $res2=$this->ShippingArea->findAll();
        foreach($res2 as $k => $v){
            $shipping_fees[$v['ShippingArea']['shipping_id']]['ShippingArea']=$v['ShippingArea'];
        }
        foreach($res as $k => $v){
            $shipping_list[$v['Shipping']['id']]['Shipping']=$v['Shipping'];
            $shipping_list[$v['Shipping']['id']]['ShippingI18n']=$v['ShippingI18n'];
            @$shipping_list[$v['Shipping']['id']]['fee_arr']=@unserialize(@$shipping_fees[$v['Shipping']['id']]['ShippingArea']['fee_configures']);
            if($order_info['Order']['pro_weight'] < 1000){
                $shipping_list[$v['Shipping']['id']]['Shipping']['shipping_fee']=0;
            }
            elseif($order_info['Order']['pro_weight'] > 1001 && $order_info['Order']['pro_weight'] < 5000){
                $shipping_list[$v['Shipping']['id']]['Shipping']['shipping_fee']=(($order_info['Order']['pro_weight']/500)*$shipping_list[$v['Shipping']['id']]['fee_arr'][1])-($shipping_fees[$v['Shipping']['id']]['ShippingArea']['free_subtotal']);
            }
            elseif($order_info['Order']['pro_weight'] > 5001){
                $shipping_list[$v['Shipping']['id']]['Shipping']['shipping_fee']=(($order_info['Order']['pro_weight']/500)*$shipping_list[$v['Shipping']['id']]['fee_arr'][2])-($shipping_fees[$v['Shipping']['id']]['ShippingArea']['free_subtotal']);
            }
        }
        $all_address=$this->UserAddress->findAll("UserAddress.user_id = ".$order_info['Order']['user_id']."");
        $action_list=$this->OrderAction->findAll("OrderAction.order_id = '".$id."'",'','OrderAction.created desc');
        $order_action=$this->OrderAction->operable_list($order_info);
        foreach($all_address as $kk => $vv){
            $regions_arr=explode(" ",trim($vv['UserAddress']['regions']));
            $attr_res=$this->RegionI18n->findAll(array('region_id' => $regions_arr));
            $arr_regions_locale=array();
            foreach($attr_res as $k => $v){
                if($v['RegionI18n']['locale']==$this->locale){
                    $arr_regions_locale[]=$v['RegionI18n']['name'];
                }
            }
            $all_address[$kk]['UserAddress']['regions_locale']="[".$vv['UserAddress']['name']."] | ".$vv['UserAddress']['address']." | ".$vv['UserAddress']['telephone'];
        }
        $wh['UserAddress.regions']=trim($order_info['Order']['regions']);
        $wh['UserAddress.user_id']=trim($order_info['Order']['user_id']);
        $regions_names_arr=$this->UserAddress->find($wh);
        $order_info['Order']['regions_names']=$regions_names_arr['UserAddress']['name'];
        $condition_v['OrderProduct.order_id']=$id;
        $total1=$this->OrderProduct->findCount($condition_v,0);
        $condition_v['OrderProduct.extension_code']='virtual_card';
        $total2=$this->OrderProduct->findCount($condition_v,0);
        if($total1==$total2){
            $virtual_card_status="yes";
        }
        else{
            $virtual_card_status="no";
        }
        $operator_info=$this->Operator->find('all');
        //包装列表
        $order_card_condition["order_id"]=$id;
        $order_card_list=$this->OrderCard->find("all",array("conditions" => $order_card_condition));
        //贺卡列表
        $order_packaging_condition["order_id"]=$id;
        $order_packaging_list=$this->OrderPackaging->find("all",array("conditions" => $order_packaging_condition));
        //积分比例。
        $conversion_ratio_point=$this->configs["conversion_ratio_point"];
        
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//
       	//区域 
       	$regions = $order_info["Order"]["regions"];
       	$regions = explode(" ",$regions);
       	$this->Region->set_locale($this->locale);
       	$regions_info = $this->Region->find("all");
       	$new_regions_info = array();
       	foreach($regions_info as $k=>$v){
       		if($v["Region"]["parent_id"]==0){
       			$new_regions_info[$regions[0]][$k] = $v;
       		}
       		if($v["Region"]["parent_id"]==@$regions[0]){
       			$new_regions_info[$regions[1]][$k] = $v;
       		}
       		if($v["Region"]["parent_id"]==@$regions[1]){
       			$new_regions_info[$regions[2]][$k] = $v;
       		}
       		if($v["Region"]["parent_id"]==@$regions[2]){
       			$new_regions_info[$regions[3]][$k] = $v;
       		}
       	}
       	
       	$this->set('new_regions_info',$new_regions_info);
       	$this->set('regions',$regions);
        $this->set('balance_log',$balance_log); //是否使用余额
        $this->set('order_packaging_list',$order_packaging_list);
        $this->set('systemresource_info',$systemresource_info);
        $this->set('order_card_list',$order_card_list);
        $this->set('conversion_ratio_point',$conversion_ratio_point);
        $this->set('coupon_info',$coupon_info);
        $this->set('price_format',$this->configs['price_format']);
        $this->set('write_order_unpay_remark',$this->configs['write_order_unpay_remark']);
        $this->set('write_order_ship_remark',$this->configs['write_order_ship_remark']);
        $this->set('write_order_receive_remark',$this->configs['write_order_receive_remark']);
        $this->set('write_order_unship_remark',$this->configs['write_order_unship_remark']);
        $this->set('write_order_return_remark',$this->configs['write_order_return_remark']);
        $this->set('write_order_invalid_remark',$this->configs['write_order_invalid_remark']);
        $this->set('write_order_cancel_remark',$this->configs['write_order_cancel_remark']);
        $this->set('operator_info',$operator_info);
        $this->set('order_info',$order_info);
        $this->set('coupon_types_list',$coupon_types_list);
        $this->set('payment_list',$payment_list);
        $this->set('shipping_list',$shipping_list);
        $this->set('action_list',$action_list);
        $this->set('order_action',$order_action);
        $this->set('user_info',$user_info);
        $this->set('all_address',$all_address);
        $this->set('ctp_view','yes');
        $this->set('virtual_card_status',$virtual_card_status);
        $this->set('price_format',$price_format);
    }
    function ajax_edit($id){
        $this->operator_privilege('order_edit');
        $this->pageTitle="编辑订单-订单管理"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '订单管理','url' => '/orders/');
        $this->navigations[]=array('name' => '编辑订单','url' => '');
        $this->set('navigations',$this->navigations);
        $order_info=$this->Order->findbyid($id);
        //DAM
        $price_format=$this->configs['price_format'];
        if(isset($this->configs["mlti_currency_module"]) && $this->configs["mlti_currency_module"]==1){
            if($order_info["Order"]["order_locale"]!=' '){
                $price_format=$this->currency_format[$order_info["Order"]["order_locale"]];
            }
            else{
                $price_format=$this->configs['price_format'];
            }
        }
        $this->configs['price_format']=$price_format;
        $coupon_info=$this->Coupon->findById($order_info["Order"]["coupon_id"]);
        //是否使用余额
        $balance_log_filter="1=1";
        $balance_log_filter .= " and UserBalanceLog.type_id = ".$id." and UserBalanceLog.user_id = ".$order_info["Order"]["user_id"]." and UserBalanceLog.log_type = 'O'";
        $balance_log=$this->UserBalanceLog->find($balance_log_filter);
        $balance_log["UserBalanceLog"]["amount"]=!empty($balance_log["UserBalanceLog"]["amount"]) ? $balance_log["UserBalanceLog"]["amount"]: "0";
        $this->CouponType->set_locale($this->locale);
        $coupon_types_info=$this->CouponType->findById($coupon_info["Coupon"]["coupon_type_id"]);
        $order_info['Order']['coupon_fee']=sprintf($this->configs['price_format'],sprintf("%01.2f",$coupon_info["Coupon"]["order_amount_discount"]));
        $order_info['Order']['coupon_type_name']=$coupon_types_info["CouponTypeI18n"]["name"];
        $coupon_types_list=$this->CouponType->findall();
        //应付款金额
        $Order_total=$order_info['Order']['subtotal']-$order_info['Order']['discount']+$order_info['Order']['tax']+$order_info['Order']['shipping_fee']+$order_info['Order']['insure_fee']+$order_info['Order']['payment_fee']+$order_info['Order']['pack_fee']+$order_info['Order']['card_fee'];
        $maney_fee=round($Order_total-$order_info['Order']['money_paid']+$balance_log["UserBalanceLog"]["amount"]-$order_info['Order']['point_fee']-$coupon_info["Coupon"]["order_amount_discount"],2);
        $order_info['Order']['amount_payable']=sprintf($this->configs['price_format'],sprintf("%01.2f",$maney_fee));
        //$order_info['Order']['subtotal']=sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['subtotal']));
        $pay_log=$this->PaymentApiLog->find(" PaymentApiLog.type = '0' and PaymentApiLog.type_id =".$id);
        $pay_log['PaymentApiLog']['amount']=$maney_fee;
        $this->PaymentApiLog->save($pay_log['PaymentApiLog']);
        $user_info=$this->User->findbyid($order_info['Order']['user_id']);
        $this->Payment->set_locale($this->locale);
        $payment_list=$this->Payment->findAll(array("Payment.status" => 1));
        
        $this->Shipping->set_locale($this->locale);
        $shipping_listt=$this->Shipping->shipping_list();
        //支持货到付款的配送方式
       	$is_cod_shipping = array();
       	foreach($shipping_listt as $ks=>$kv)
       	{
       		if($kv['Shipping']['support_cod']==1) $is_cod_shipping[]=$kv['Shipping']['id'];
       	}
        $order_info['Order']['is_cod']=(in_array($order_info['Order']['shipping_id'],$is_cod_shipping)?1:0);
        $order_info['Order']['pro_weight']=0;
        $order_info['Order']['allvirtual']=0;
        $virtualnum = 0;
        foreach($order_info['OrderProduct']as $k => $v){
            $products[$k]=$this->OrderProduct->find("OrderProduct.product_id = ".$v['product_id']."");
            $order_info['Order']['pro_weight'] += $products[$k]['Product']['weight'];
            $order_info['OrderProduct'][$k]['total']=sprintf($this->configs['price_format'],sprintf("%01.2f",$v['product_quntity']*$v['product_price']));
            
            $aa = isset($v['extension_code'])?$v['extension_code']:'0';
                    $virtualnum += (($aa=='virtual_card')?1:0);
        }
        $order_info['Order']['allvirtual']=(count($order_info['OrderProduct'])==$virtualnum)?1:0;
        
        $this->Shipping->set_locale($this->locale);
        $res=$this->Shipping->findAll(array("Shipping.status" => "1"));
        $res2=$this->ShippingArea->findAll();
        foreach($res2 as $k => $v){
            $shipping_fees[$v['ShippingArea']['shipping_id']]['ShippingArea']=$v['ShippingArea'];
        }
        foreach($res as $k => $v){
            $shipping_list[$v['Shipping']['id']]['Shipping']=$v['Shipping'];
            $shipping_list[$v['Shipping']['id']]['ShippingI18n']=$v['ShippingI18n'];
            @$shipping_list[$v['Shipping']['id']]['fee_arr']=@unserialize(@$shipping_fees[$v['Shipping']['id']]['ShippingArea']['fee_configures']);
            if($order_info['Order']['pro_weight'] < 1000){
                $shipping_list[$v['Shipping']['id']]['Shipping']['shipping_fee']=0;
            }
            elseif($order_info['Order']['pro_weight'] > 1001 && $order_info['Order']['pro_weight'] < 5000){
                $shipping_list[$v['Shipping']['id']]['Shipping']['shipping_fee']=(($order_info['Order']['pro_weight']/500)*$shipping_list[$v['Shipping']['id']]['fee_arr'][1])-($shipping_fees[$v['Shipping']['id']]['ShippingArea']['free_subtotal']);
            }
            elseif($order_info['Order']['pro_weight'] > 5001){
                $shipping_list[$v['Shipping']['id']]['Shipping']['shipping_fee']=(($order_info['Order']['pro_weight']/500)*$shipping_list[$v['Shipping']['id']]['fee_arr'][2])-($shipping_fees[$v['Shipping']['id']]['ShippingArea']['free_subtotal']);
            }
        }
        $all_address=$this->UserAddress->findAll("UserAddress.user_id = ".$order_info['Order']['user_id']."");
        $action_list=$this->OrderAction->findAll("OrderAction.order_id = '".$id."'",'','OrderAction.created desc');
        $order_action=$this->OrderAction->operable_list($order_info);
        foreach($all_address as $kk => $vv){
            $regions_arr=explode(" ",trim($vv['UserAddress']['regions']));
            $attr_res=$this->RegionI18n->findAll(array('region_id' => $regions_arr));
            $arr_regions_locale=array();
            foreach($attr_res as $k => $v){
                if($v['RegionI18n']['locale']==$this->locale){
                    $arr_regions_locale[]=$v['RegionI18n']['name'];
                }
            }
            $all_address[$kk]['UserAddress']['regions_locale']="[".$vv['UserAddress']['name']."] | ".$vv['UserAddress']['address']." | ".$vv['UserAddress']['telephone'];
        }
        $wh['UserAddress.regions']=trim($order_info['Order']['regions']);
        $wh['UserAddress.user_id']=trim($order_info['Order']['user_id']);
        $regions_names_arr=$this->UserAddress->find($wh);
        $order_info['Order']['regions_names']=$regions_names_arr['UserAddress']['name'];
        $condition_v['OrderProduct.order_id']=$id;
        $total1=$this->OrderProduct->findCount($condition_v,0);
        $condition_v['OrderProduct.extension_code']='virtual_card';
        $total2=$this->OrderProduct->findCount($condition_v,0);
        if($total1==$total2){
            $virtual_card_status="yes";
        }
        else{
            $virtual_card_status="no";
        }
        $operator_info=$this->Operator->find('all');
        //包装列表
        $order_card_condition["order_id"]=$id;
        $order_card_list=$this->OrderCard->find("all",array("conditions" => $order_card_condition));
        //贺卡列表
        $order_packaging_condition["order_id"]=$id;
        $order_packaging_list=$this->OrderPackaging->find("all",array("conditions" => $order_packaging_condition));
        //积分比例。
        $conversion_ratio_point=$this->configs["conversion_ratio_point"];
        
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//
       	//区域 
       	$regions = $order_info["Order"]["regions"];
       	$regions = explode(" ",$regions);
       	$this->Region->set_locale($this->locale);
       	$regions_info = $this->Region->find("all");
       	$new_regions_info = array();
       	foreach($regions_info as $k=>$v){
       		if($v["Region"]["parent_id"]==0){
       			$new_regions_info[$regions[0]][$k] = $v;
       		}
       		if($v["Region"]["parent_id"]==@$regions[0]){
       			$new_regions_info[$regions[1]][$k] = $v;
       		}
       		if($v["Region"]["parent_id"]==@$regions[1]){
       			$new_regions_info[$regions[2]][$k] = $v;
       		}
       		if($v["Region"]["parent_id"]==@$regions[2]){
       			$new_regions_info[$regions[3]][$k] = $v;
       		}
       	}
       	
       	$this->set('new_regions_info',$new_regions_info);
       	$this->set('regions',$regions);
        $this->set('balance_log',$balance_log); //是否使用余额
        $this->set('order_packaging_list',$order_packaging_list);
        $this->set('systemresource_info',$systemresource_info);
        $this->set('order_card_list',$order_card_list);
        $this->set('conversion_ratio_point',$conversion_ratio_point);
        $this->set('coupon_info',$coupon_info);
        $this->set('price_format',$this->configs['price_format']);
        $this->set('write_order_unpay_remark',$this->configs['write_order_unpay_remark']);
        $this->set('write_order_ship_remark',$this->configs['write_order_ship_remark']);
        $this->set('write_order_receive_remark',$this->configs['write_order_receive_remark']);
        $this->set('write_order_unship_remark',$this->configs['write_order_unship_remark']);
        $this->set('write_order_return_remark',$this->configs['write_order_return_remark']);
        $this->set('write_order_invalid_remark',$this->configs['write_order_invalid_remark']);
        $this->set('write_order_cancel_remark',$this->configs['write_order_cancel_remark']);
        $this->set('operator_info',$operator_info);
        $this->set('order_info',$order_info);
        $this->set('coupon_types_list',$coupon_types_list);
        $this->set('payment_list',$payment_list);
        $this->set('shipping_list',$shipping_list);
        $this->set('action_list',$action_list);
        $this->set('order_action',$order_action);
        $this->set('user_info',$user_info);
        $this->set('all_address',$all_address);
        $this->set('ctp_view','no');
        $this->set('virtual_card_status',$virtual_card_status);
        $this->set('price_format',$price_format);
        Configure::write('debug',0);
        $this->render('edit');
    }
    function assign_operator($id){
        Configure::write('debug',0);
        $this->Order->updateAll(array('Order.operator_id' => $this->data['Operator']['id']),array('Order.id' => $id));
        //操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'分派订单:'.$id,'operation');
        }
        $result['order_id']=$id;
        $result['message']="订单分派成功";
        die(json_encode($result));
        $this->flash("操作成功",'/orders/',10);
    }
    function get_product_info($product_id){
        $products_info=$this->Product->findbyid($product_id);
        $today=date('Y-m-d H:i:s');
        $products_info['Product']['product_price']=($products_info['Product']['promotion_status']=="1" && $products_info['Product']['promotion_start'] <= $today && $products_info['Product']['promotion_end'] >= $today) ? $products_info['Product']['promotion_price']: $products_info['Product']['shop_price'];
        $pro_cat=$this->Category->findbyid($products_info['Product']['category_id']);
        $pro_brand=$this->Brand->findbyid($products_info['Product']['brand_id']);
        if(empty($pro_cat)){
            $pro_cat['Category']='';
            $pro_cat['CategoryI18n']['name']='';
        }
        else{
            $pro_cat=$pro_cat;
        }
        if(empty($pro_brand)){
            $pro_brand['Brand']='';
            $pro_brand['BrandI18n']['name']='';
        }
        $products_info['Category']=$pro_cat['Category'];
        $products_info['CategoryI18n']=$pro_cat['CategoryI18n'];
        $products_info['Brand']=$pro_brand['Brand'];
        $products_info['BrandI18n']=$pro_brand['BrandI18n'];
        $res=$this->ProductAttribute->findAll("ProductAttribute.product_id = '".$product_id."'");
        $attrs_list=$this->ProductTypeAttribute->findassoc();
        $products_info['ProductTypeAttribute']=array();
        foreach($res as $k => $v){
            if(isset($attrs_list[$v['ProductAttribute']['product_type_attribute_id']])){
                $res[$k]['ProductTypeAttribute']=$attrs_list[$v['ProductAttribute']['product_type_attribute_id']]['ProductTypeAttribute'];
            }
            $pro_attr[$v['ProductAttribute']['product_type_attribute_id']]=$v;
            $pro_attr[$v['ProductAttribute']['product_type_attribute_id']]['Attribute']['attr_id']=$attrs_list[$v['ProductAttribute']['product_type_attribute_id']]['ProductTypeAttribute']['id'];
            $pro_attr[$v['ProductAttribute']['product_type_attribute_id']]['Attribute']['attr_name']=$attrs_list[$v['ProductAttribute']['product_type_attribute_id']]['ProductTypeAttributeI18n']['name'];
            $pro_attr[$v['ProductAttribute']['product_type_attribute_id']]['Attribute']['attr_value']=$pro_attr[$v['ProductAttribute']['product_type_attribute_id']]['ProductAttribute']['product_type_attribute_value'];
            $pro_attr[$v['ProductAttribute']['product_type_attribute_id']]['Attribute']['attr_price']=$pro_attr[$v['ProductAttribute']['product_type_attribute_id']]['ProductAttribute']['product_type_attribute_price'];
            $pro_attr[$v['ProductAttribute']['product_type_attribute_id']]['Attribute']['product_attr_id']=$pro_attr[$v['ProductAttribute']['product_type_attribute_id']]['ProductAttribute']['product_type_attribute_id'];
            $products_info['ProductTypeAttribute'][$v['ProductAttribute']['product_type_attribute_id']][]=$pro_attr[$v['ProductAttribute']['product_type_attribute_id']]['Attribute'];
        }
        $products_info['ProductTypeAttribute']=array_values($products_info['ProductTypeAttribute']);
        $this->UserRank->set_locale($this->locale);
        $userrank_info=$this->UserRank->findall();
        foreach($userrank_info as $k => $v){
            $rank_id=$v["UserRank"]["id"];
            $ProductRank_info=$this->ProductRank->find(array("rank_id" => $rank_id));
            $userrank_info[$k]["ProductRank"]=$ProductRank_info["ProductRank"];
        }
        Configure::write('debug',0);
        $result['type']="0";
        $result['productinfo']=$products_info;
        $result['userrankinfo']=$userrank_info;
        $result['productid']=$product_id;
        die(json_encode($result));
    }
    function edit_order_info(){
        Configure::write('debug',0);
        if(isset($this->params['form']['act_type']) && $this->params['form']['act_type']=='baseinfo'){
            $this->data['Order']['regions']='';
            foreach($this->data['Address']['Region']as $k => $v){
                $this->data['Order']['regions'] .= $v." ";
            }
            $payment_info=$this->Payment->findbyid($this->data['Order']['payment_id']);
            $shipping_info=$this->Shipping->findbyid($this->data['Order']['shipping_id']);
            $this->data['Order']['payment_name']=$payment_info['PaymentI18n']['name'];
            $this->data['Order']['shipping_name']=$shipping_info['ShippingI18n']['name'];
            $this->Order->saveall($this->data);
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑订单:'.$id."基本信息",'operation');
            }
            $result['order_id']=$this->data['Order']['id'];
            $result['message']="编辑成功";
            die(json_encode($result));
            $this->flash("编辑成功",'/orders/'.$this->data['Order']['id'],10);
        }
        if(isset($this->params['form']['act_type']) && $this->params['form']['act_type']=='products'){
            foreach($this->params['form']['rec_id']as $k => $v){
                static$subtotal=0;
                $products_info=array('id' => $this->params['form']['rec_id'][$k],'product_quntity' => $this->params['form']['product_quntity'][$k],'product_price' => $this->params['form']['product_price'][$k],'product_attrbute' => $this->params['form']['product_attrbute'][$k]);
                $subtotal += $this->params['form']['product_quntity'][$k]*$this->params['form']['product_price'][$k];
                $this->OrderProduct->save(array('OrderProduct' => $products_info));
            }
            $order_info=$this->Order->findById($_REQUEST['order_id']);
            $total=$subtotal-$order_info['Order']['discount']+$order_info['Order']['tax']+$order_info['Order']['shipping_fee']+$order_info['Order']['insure_fee']+$order_info['Order']['payment_fee']+$order_info['Order']['pack_fee']+$order_info['Order']['card_fee'];
            $this->Order->updateAll(array('Order.subtotal' => $subtotal),array('Order.id' => $_REQUEST['order_id']));
            $this->Order->updateAll(array('Order.total' => $total),array('Order.id' => $_REQUEST['order_id']));
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑订单:'.$id."商品",'operation');
            }
            $result['order_id']=$_REQUEST['order_id'];
            $result['message']="商品编辑成功";
            die(json_encode($result));
            $this->flash("商品编辑成功",'/orders/'.$this->params['form']['order_id'],10);
        }
        elseif(isset($this->params['form']['act_type']) && $this->params['form']['act_type']=='insert_products'){
            $pro_price=0;
            $products_attr='0';
            for($i=0;$i < $this->params['form']['spec_count'];$i++){
                $products_attr.=','.$this->params['form']['spec_'.$i];
            }
            $attr_list=array();
            $order_proattr=array();
            $this->params['form']['product_id']=!empty($this->params['form']['product_id']) ? $this->params['form']['product_id']: "''";
            if($products_attr!=''){
                if($products_attr==0){
                    $condition="ProductAttribute.product_id = ".$this->params['form']['product_id']."";
                }
                else{
                    $condition=array("ProductAttribute.id" => $products_attr);
                }
                $res=$this->ProductAttribute->findAll($condition);
                $attrs_list=$this->ProductTypeAttribute->findassoc();
                foreach($res as $k => $v){
                    if(isset($attrs_list[$v['ProductAttribute']['attr_id']])){
                        $res[$k]['Attribute']=$attrs_list[$v['ProductAttribute']['attr_id']]['Attribute'];
                    }
                    $attr_list[$v['ProductAttribute']['attr_id']]=$v;
                    $attr_list[$v['ProductAttribute']['attr_id']]['Attribute']['attr_id']=$attrs_list[$v['ProductAttribute']['attr_id']]['Attribute']['id'];
                    $attr_list[$v['ProductAttribute']['attr_id']]['Attribute']['attr_name']=$attrs_list[$v['ProductAttribute']['attr_id']]['Attribute']['name'];
                    $attr_list[$v['ProductAttribute']['attr_id']]['Attribute']['attr_value']=$attr_list[$v['ProductAttribute']['attr_id']]['ProductAttribute']['attr_value'];
                    $attr_list[$v['ProductAttribute']['attr_id']]['Attribute']['attr_price']=$attr_list[$v['ProductAttribute']['attr_id']]['ProductAttribute']['attr_price'];
                    $attr_list[$v['ProductAttribute']['attr_id']]['Attribute']['product_attr_id']=$attr_list[$v['ProductAttribute']['attr_id']]['ProductAttribute']['attr_id'];
                    $attr=$attr_list[$v['ProductAttribute']['attr_id']]['Attribute']['attr_name'].': '.$attr_list[$v['ProductAttribute']['attr_id']]['Attribute']['attr_value'];
                    if($attr_list[$v['ProductAttribute']['attr_id']]['Attribute']['attr_price'] > 0){
                        $attr.=' [+'.$attr_list[$v['ProductAttribute']['attr_id']]['Attribute']['attr_price'].']';
                    }
                    elseif($attr_list[$v['ProductAttribute']['attr_id']]['Attribute']['attr_price'] < 0){
                        $attr.=' [+'.abs($attr_list[$v['ProductAttribute']['attr_id']]['Attribute']['attr_price']).']';
                    }
                    $order_proattr[]=$attr;
                    $pro_price += $attr_list[$v['ProductAttribute']['attr_id']]['Attribute']['attr_price'];
                }
            }
            $order_proattr=is_array($order_proattr) ? array_map(null,$order_proattr): addslashes($order_proattr);
            $products_info=$this->Product->findbyid($_REQUEST['productslist']);
            $product_info=array('order_id' => $_REQUEST['order_id'],'product_id' => $_REQUEST['productslist'],'product_name' => $_REQUEST['product_name'],'product_code' => $_REQUEST['product_code'],'product_price' => $_REQUEST['shop_price']+$pro_price,'product_attrbute' => join("\r\n",$order_proattr),'extension_code' => $products_info['Product']['extension_code'],'product_quntity' => $_REQUEST['product_number']);
            if(empty($this->params['form']['product_name'])){
                $this->flash("请选择商品",'/orders/'.$this->params['form']['order_id'],10);
            }
            else{
                $this->OrderProduct->save(array('OrderProduct' => $product_info));
            }
            $order_info=$this->Order->findbyid($this->params['form']['order_id']);
            $subtotal=$order_info['Order']['subtotal']+$this->params['form']['product_number']*$this->params['form']['shop_price']+$pro_price;
            $this->Order->updateAll(array('Order.subtotal' => $subtotal),array('Order.id' => $this->params['form']['order_id']));
            if(!empty($this->params['form']['product_name'])){
                //操作员日志
                if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'插入商品'.$this->params['form']['product_name'].'至订单:'.$id,'operation');
                }
                $result['order_id']=$_REQUEST['order_id'];
                $result['message']="商品已经加入订单";
                die(json_encode($result));
                $this->flash("商品已经加入订单",'/orders/'.$this->params['form']['order_id'],10);
            }
        }
        /*------------------------------------------------------ */
        //-- 费用信息
        /*------------------------------------------------------ */
        elseif(isset($this->params['form']['act_type']) && $this->params['form']['act_type']=='money'){
            //订单总额
            $total=$this->params['form']['subtotal']+$this->params['form']['tax']+$this->params['form']['shipping_fee']+$this->params['form']['insure_fee']+$this->params['form']['payment_fee']+$this->params['form']['pack_fee']+$this->params['form']['card_fee'];
            //			商品总金额					-			折扣				+			发票税额		+			配送费用					+		保价费用				+			支付费用					+			包装费用			+			贺卡费用
            $order_info=$this->Order->findById($this->params['form']['order_id']);
            $money_info=array('id' => $this->params['form']['order_id'],'tax' => $this->params['form']['tax'], //发票税额
            'shipping_fee' => $this->params['form']['shipping_fee'], //配送费用
            'insure_fee' => $this->params['form']['insure_fee'], //保价费用
            'payment_fee' => $this->params['form']['payment_fee'], //支付费用
            'pack_fee' => $this->params['form']['pack_fee'], //包装费用
            'card_fee' => $this->params['form']['card_fee'], //贺卡费用
            'discount' => $this->params['form']['discount'], //折扣
            'total' => $total, //订单总额
            'coupon_id' => $this->params['form']['coupon_fee_id'], //红包ID
            ''
            );
            $this->Order->save(array('Order' => $money_info));
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑订单'.$this->params['form']['order_id'].'费用','operation');
            }
            $result['order_id']=$_REQUEST['order_id'];
            $result['message']="费用编辑成功";
            die(json_encode($result));
            $this->flash("费用编辑成功",'/orders/'.$this->params['form']['order_id'],10);
        }
    }
    function drop_order_products($order_pro_id,$id){
        $order_pro_info=$this->OrderProduct->findbyid($order_pro_id);
        $pro_amount=$order_pro_info['OrderProduct']['product_quntity']*$order_pro_info['OrderProduct']['product_price'];
        $order_info=$this->Order->findbyid($id);
        $subtotal=$order_info['Order']['subtotal']-$pro_amount;
        $this->Order->updateAll(array('Order.subtotal' => $subtotal),array('Order.id' => $id));
        $this->OrderProduct->del($order_pro_id);
        //操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除订单'.$id.'的商品','operation');
        }
        $this->flash("商品已经从该订单删除",'/orders/',10);
    }
    //订单各种操作
    function order_operate(){
        $order_info=$this->Order->findbyid($_REQUEST['order_id']);
        $id=$_REQUEST['order_id'];
        $order_code=$order_info['Order']['order_code'];
        $operator_id=$_SESSION['Operator_Info']['Operator']['id'];
        $operator_user_id=$order_info['Order']['user_id'];
        $msg = "";
        $action_note = $_REQUEST['action_note'];
        if($_REQUEST['action_type']=='confirm'){
            $modified=date('Y-m-d H:i:s');
            $this->Order->update_order(array('id' => $id,'status' => '1','confirm_time' => $modified));
            $this->OrderAction->update_order_action(array('order_id' => $id,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => '1','payment_status' => '0','shipping_status' => '0','action_note' => $_REQUEST['action_note']));
            $order_list=$this->OrderProduct->findAll(array("order_id" => $id));
            foreach($order_list as $k => $v){
                $product_id=$v['OrderProduct']['product_id'];
                //	$product_quntity=$v['Product']['quantity']-$v['OrderProduct']['product_quntity'];
                $frozen_quantity=$v['Product']['frozen_quantity']-$v['OrderProduct']['product_quntity'];
                $update_product=array('id' => $product_id,'frozen_quantity' => $frozen_quantity);
                $this->Product->save($update_product);
                //	$this->Product->updateAll(array('Product.quantity'=>$product_quntity),array('Product.id'=>$product_id),array('Product.frozen_quantity'=>$frozen_quantity));
            } // 改为 发货减库存 确定减冻结库存 by Gin
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'订单'.$order_code=$order_info['Order']['order_code'].'已确认','operation');
            }
            $user_filter=" UserConfig.user_id = ".$operator_user_id." and UserConfig.code = 'email_new_order'";
            $user_config=$this->UserConfig->find($user_filter);
            $this->order_confim_email($id,$order_info);
            $msg="订单已经确认";
        }
        elseif($_REQUEST['action_type']=='pay'){

            $this->orderpay($order_info,$id,$operator_id,$operator_user_id,$action_note);
            $msg="订单已经付款";
        }
        elseif($_REQUEST['action_type']=='unpay'){
            $this->Order->update_order(array('id' => $id,'payment_status' => '0','payment_time' => '0000-00-00 00:00:00','money_paid' => '0'));
            $refund_type=$_REQUEST['refund'];
            $refund_note=$_REQUEST['refund_note'];
            $this->order_refund($order_info,$refund_type,$refund_note);
            $this->OrderAction->update_order_action(array('order_id' => $id,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => '1','payment_status' => '0','shipping_status' => '0','action_note' => $_REQUEST['action_note']));
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'订单'.$order_code=$order_info['Order']['order_code'].'未付款','operation');
            }
            $msg="订单支付状态未付款成功";
        }
        elseif($_REQUEST['action_type']=='prepare'){
            $modified=date('Y-m-d H:i:s');
            $order=array();
            if($order_info['Order']['status']!=1){
                $order['status']=1;
                $order['confirm_time']=$modified;
            }
            $order['id']=$id;
            $order['shipping_status']='3';
            $this->Order->update_order($order);
            $this->OrderAction->update_order_action(array('order_id' => $id,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => '1','payment_status' => $order_info['Order']['payment_status'],'shipping_status' => '3','action_note' => $_REQUEST['action_note']));
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'订单'.$order_code=$order_info['Order']['order_code'].'配货中','operation');
            }
            $msg="订单配货中";
        }
        elseif($_REQUEST['action_type']=='ship'){
            $condition_v['OrderProduct.order_id']=$id;
            $total1=$this->OrderProduct->findCount($condition_v,0);
            $condition_v['OrderProduct.extension_code']='virtual_card';
            $total2=$this->OrderProduct->findCount($condition_v,0);
            if($total1==$total2){
                $virtual_card_status="yes";
            }
            else{
                $virtual_card_status="no";
            }
            $invoice_no=$_REQUEST['invoice_no'];
            $invoice_no_check=$this->Order->find('first',array('conditions' => array('invoice_no' => $invoice_no)));
            if(!empty($invoice_no_check) && $virtual_card_status=='no'){
                $msg="该发货单号已经存在。发货失败!";
                Configure::write('debug',0);
                $result['type']="0";
                $result['msg']=$msg;
                $result['order_id']=$id;
                die(json_encode($result));
            }
            $virtual_products=$this->OrderProduct->get_virtual_products($id);
            if(!empty($virtual_products)){
                if(!$this->virtual_products_ship($virtual_products,$id)){
                    $msg="虚拟卡库存不足。发货失败!";
                    Configure::write('debug',0);
                    $result['type']="0";
                    $result['msg']=$msg;
                    $result['order_id']=$id;
                    die(json_encode($result));
                }
            }
            $modified=date('Y-m-d H:i:s');
            $this->Order->update_order(array('id' => $id,'shipping_status' => '1','shipping_time' => $modified,'invoice_no' => $invoice_no));
            $this->OrderAction->update_order_action(array('order_id' => $id,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'payment_status' => $order_info['Order']['payment_status'],'shipping_status' => '1','action_note' => $_REQUEST['action_note']));
            if($order_info['Order']['user_id'] > 0){
                $user=$this->User->findbyid($order_info['Order']['user_id']);
            }
            $user_filter="";
            $user_filter="  UserConfig.user_id = ".$operator_user_id." and UserConfig.code = 'email_ship_order'";
            $user_config=$this->UserConfig->find($user_filter);
            if($this->configs['enable_auto_send_mail']==1 || $this->configs['enable_send_ship_email']==1 || $user_config['UserConfig']['value']==1){
                $products=array();
                foreach($order_info['OrderProduct']as $k => $v){
                    $products[$k]=$this->OrderProduct->find("OrderProduct.product_id = ".$v['product_id']."");
                }
                $products_info="";
                foreach($products as $k => $v){
                    $products_info.="------------------------------------- <br />";
                    $products_info.="商品ID：".$v['OrderProduct']['product_id']."<br />";
                    $products_info.="商品名：".$v['OrderProduct']['product_name']."<br />";
                    $products_info.="商品编号：".$v['OrderProduct']['product_code']."<br />";
                    $products_info.="商品价格：".$v['OrderProduct']['product_price']." <br />";
                    $products_info.="购买数量：".$v['OrderProduct']['product_quntity']."<br />";
                    $products_info.="------------------------------------- <br />";
                    $order_list=$this->OrderProduct->findAll(array("order_id" => $id));
                    $product_id=$v['OrderProduct']['product_id'];
                    if(isset($this->configs['enable_decrease_stock_time']) && $this->configs['enable_decrease_stock_time']==2){
                        $product_quntity=$v['Product']['quantity']-$v['OrderProduct']['product_quntity'];
                        $update_product=array('id' => $product_id,'quantity' => $product_quntity);
                        $this->Product->save($update_product);
                    }
                }
                $to_email=$order_info['Order']['email'];
                $template='out_confirm';
                $consignee=$order_info['Order']['consignee'];
                $this->MailTemplate->set_locale($this->locale);
                $template=$this->MailTemplate->find("code = '$template' and status = '1'");
                $formated_add_time=$order_info['Order']['created'];
                $id=$order_info['Order']['id'];
                $shop_name=$this->configs['shop_name'];
                $send_date=date('Y-m-d H:m:s');
                $sent_date=date('Y-m-d H:m:s');
                $url=$this->server_host.$this->user_webroot."order_received/".$order_info['Order']['id']."/received";
                $shop_url=$this->server_host.$this->cart_webroot;
                $fromName=$shop_name;
                $subject=$template['MailTemplateI18n']['title'];
                $this->Email->sendAs='html';
                $this->Email->is_ssl=$this->configs['smtp_ssl'];
                $this->Email->is_mail_smtp=$this->configs['mail_service'];
                $this->Email->smtp_port=$this->configs['smtp_port'];
                $this->Email->smtpHostNames="".$this->configs['smtp_host']."";
                $this->Email->smtpUserName="".$this->configs['smtp_user']."";
                $this->Email->smtpPassword="".$this->configs['smtp_pass']."";
                $this->Email->fromName=$fromName;
                eval("\$subject = \"$subject\";");
                $this->Email->subject="=?utf-8?B?".base64_encode($subject)."?=";
                $this->Email->from="".$this->configs['smtp_user']."";
                $shop_url=$this->server_host.$this->cart_webroot;
                $template_str=$template['MailTemplateI18n']['html_body'];
                eval("\$template_str = \"$template_str\";");
                $this->Email->html_body=$template_str;
                $text_body=$template['MailTemplateI18n']['text_body'];
                eval("\$text_body = \"$text_body\";");
                $this->Email->text_body=$text_body;
                $this->Email->to="".$to_email."";
                if($this->Email->send()!=1){
                	$msg.="邮件发送失败,";
                }
            }
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'订单'.$order_code=$order_info['Order']['order_code'].'已发货','operation');
            }
            
            //网站联盟，refferer_orders产生记录
            if($order_info['Order']['union_user_id'] != '0'){
				$plugin_union_admin = $this->Plugin->find_union();
				if(isset($plugin_union['Plugin']) && !empty($order_info['Order']['union_user_id'])){
					$this->requestAction('/union/union_orders/add_union_refferer_orders/'.$id);
				}
			}
            
            $msg.="订单已经发货";
        }
        elseif($_REQUEST['action_type']=='unship'){
            $this->Order->update_order(array('id' => $id,'shipping_status' => '0','shipping_time' => '0000-00-00 00:00:00'));
            $this->OrderAction->update_order_action(array('order_id' => $id,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => $order_info['Order']['status'],'payment_status' => $order_info['Order']['payment_status'],'shipping_status' => '0','action_note' => $_REQUEST['action_note']));
            if($order_info['Order']['user_id'] > 0){
                $user_info=$this->User->findbyid($order_info['Order']['user_id']);
                $order_products=$this->OrderProduct->findAll("OrderProduct.order_id='$_REQUEST[order_id]'");
                $product_point=0;
                foreach($order_products as $k => $v){
                    if($v['Product']['point'] > 0){
                        $product_point += $v['Product']['point'];
                    }
                }
                if($product_point > 0){
                    $user_info['User']['point'] += $product_point;
                    $user_info['User']['user_point'] += $product_point;
                    $this->User->save($user_info);
                    $point_log=array("id" => "","user_id" => $order_info['Order']['user_id'],"point" => $product_point,"log_type" => "B","type_id" => $id);
                    $this->UserPointLog->save($point_log);
                }
            }
            $order_list=$this->OrderProduct->findAll(array("order_id" => $id,"OrderProduct.extension_code" => ""));
            foreach($order_list as $k => $v){
                $product_id=$v['OrderProduct']['product_id'];
                $product_quntity=$v['Product']['quantity']+$v['OrderProduct']['product_quntity'];
                $this->Product->updateAll(array('Product.quantity' => $product_quntity),array('Product.id' => $product_id));
            }
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'订单'.$order_code=$order_info['Order']['order_code'].'设为未发货','operation');
            }
            $msg="订单已经设为未发货";
        }
        elseif($_REQUEST['action_type']=='receive'){
            $order=array();
            $order['id']=$id;
            $order['shipping_status']='2';
            $payment=$this->Payment->find("Payment.id = ".$order_info['Order']['payment_id']." and Payment.status = '1'");
            if($payment['Payment']['is_cod']){
                $order['payment_status']='2';
                $order_info['Order']['payment_status']='2';
            }
            $this->Order->update_order($order);
            $this->OrderAction->update_order_action(array('order_id' => $id,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => $order_info['Order']['status'],'payment_status' => $order_info['Order']['payment_status'],'shipping_status' => '2','action_note' => $_REQUEST['action_note']));
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'订单'.$order_code=$order_info['Order']['order_code'].'已收货','operation');
            }
            $msg="订单收货确认";
        }
        elseif($_REQUEST['action_type']=='cancel'){
            $cancel_note=isset($this->params['form']['cancel_note']) ? trim($this->params['form']['cancel_note']): '';
            $this->Order->update_order(array('id' => $id,'status' => '2','payment_status' => '0','payment_time' => '0000-00-00 00:00:00','money_paid' => '0','to_buyer' => $cancel_note));
            if($order_info['Order']['money_paid'] > 0){
                $refund_cancel_type=$_REQUEST['refund_cancel'];
                $refund_cancel_note=$_REQUEST['refund_cancel_note'];
                $this->order_refund($order_info,$refund_cancel_type,$refund_cancel_note);
            }
            $this->OrderAction->update_order_action(array('order_id' => $id,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => '2','payment_status' => '0','shipping_status' => $order_info['Order']['shipping_status'],'action_note' => $_REQUEST['action_note']));
            $order_list=$this->OrderProduct->findAll(array("order_id" =>$id));
            foreach($order_list as $k => $v){
                $product_id=$v['OrderProduct']['product_id'];
                $product_quntity=$v['Product']['quantity']-$v['OrderProduct']['product_quntity'];
                $this->Product->updateAll(array('Product.quantity' => $product_quntity),array('Product.id' => $product_id));
            }
            $user_point_filter="";
            $user_point_filter="  UserPointLog.log_type = 'B' and UserPointLog.type_id = ".$id." and UserPointLog.user_id = ".$operator_user_id;
            $point_logs=$this->UserPointLog->findall($user_point_filter);
            if(isset($point_logs) && count($point_logs) > 0){
                $user_info=$this->User->findbyid($operator_user_id);
                $back_point=0;
                foreach($point_logs as $k => $v){
                    $point_log=array("id" => "","user_id" => $operator_user_id,"point" => $v['UserPointLog']['point'],"log_type" => "R","type_id" =>$id);
                    $this->UserPointLog->save($point_log);
                    $back_point += $v['UserPointLog']['point'];
                }
                $user_info['User']['point']-=$back_point;
                $user_info['User']['user_point']-=$back_point;
                $this->User->save($user_info);
            }
            if($order_info['Order']['coupon_id'] > 0){
                $coupon=$this->Coupon->findbyid($order_info['Order']['coupon_id']);
                if(isset($coupon['Coupon'])){
                    $coupon['Coupon']['order_id']=0;
                    $this->Coupon->save($coupon['Coupon']);
                }
            }
            if($this->configs['enable_auto_send_mail']==1 || $this->configs['enable_send_cancel_email']==1){
                $products=array();
                foreach($order_info['OrderProduct']as $k => $v){
                    $products[$k]=$this->OrderProduct->find("OrderProduct.product_id = ".$v['product_id']."");
                }
                $products_info="";
                if(isset($products) && count($products) > 0){
                    foreach($products as $k => $v){
                        $products_info.="------------------------------------- <br />";
                        $products_info.="商品ID：".$v['OrderProduct']['product_id']."<br />";
                        $products_info.="商品名：".$v['OrderProduct']['product_name']."<br />";
                        $products_info.="商品编号：".$v['OrderProduct']['product_code']."<br />";
                        $products_info.="商品价格：".$v['OrderProduct']['product_price']." <br />";
                        $products_info.="购买数量：".$v['OrderProduct']['product_quntity']."<br />";
                        $products_info.="------------------------------------- <br />";
                    }
                }
                else{
                    $products_info.="无相关商品信息 <br />";
                }
                $to_email=$order_info['Order']['email'];
                $template='order_cancel';
                $consignee=$order_info['Order']['consignee'];
                $this->MailTemplate->set_locale($this->locale);
                $template=$this->MailTemplate->find("code = '$template' and status = '1'");
                $formated_add_time=$order_info['Order']['created'];
                $id=$order_info['Order']['id'];
                $shop_name=$this->configs['shop_name'];
                $send_date=date('Y-m-d H:m:s');
                $sent_date=date('Y-m-d H:m:s');
                $fromName=$shop_name;
                $subject=$template['MailTemplateI18n']['title'];
                $this->Email->sendAs='html';
                $this->Email->is_ssl=$this->configs['smtp_ssl'];
				$this->Email->is_mail_smtp=$this->configs['mail_service'];

                $this->Email->smtp_port=$this->configs['smtp_port'];
                $this->Email->is_ssl=$this->configs['smtp_ssl'];
                $this->Email->smtp_port=$this->configs['smtp_port'];
                $this->Email->smtpHostNames="".$this->configs['smtp_host']."";
                $this->Email->smtpUserName="".$this->configs['smtp_user']."";
                $this->Email->smtpPassword="".$this->configs['smtp_pass']."";
                $this->Email->fromName=$fromName;
                eval("\$subject = \"$subject\";");
                $this->Email->subject="=?utf-8?B?".base64_encode($subject)."?=";
                $this->Email->from="".$this->configs['smtp_user']."";
                $shop_url=$this->server_host.$this->cart_webroot;
                $template_str=$template['MailTemplateI18n']['html_body'];
                eval("\$template_str = \"$template_str\";");
                $this->Email->html_body=$template_str;
                $text_body=$template['MailTemplateI18n']['text_body'];
                eval("\$text_body = \"$text_body\";");
                $this->Email->text_body=$text_body;
                $this->Email->to="".$to_email."";
                if(@$this->Email->send()!=1){
                	$msg.="邮件发送失败,";
                }

            }
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'订单'.$order_code=$order_info['Order']['order_code'].'已取消','operation');
            }
            $msg.="订单已经取消";
        }
        elseif($_REQUEST['action_type']=='invalid'){
            $this->Order->update_order(array('id' => $id,'status' => '3'));
            if($order_info['Order']['money_paid'] > 0){
                $this->order_refund($order_info,1,"订单无效 退款");
            }
            $this->OrderAction->update_order_action(array('order_id' => $id,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => '3','payment_status' => '0','shipping_status' => $order_info['Order']['shipping_status'],'action_note' => $_REQUEST['action_note']));
            $order_list=$this->OrderProduct->findAll(array("order_id" => $id));
            foreach($order_list as $k => $v){
                $product_id=$v['OrderProduct']['product_id'];
                $product_quntity=$v['Product']['quantity']+$v['OrderProduct']['product_quntity'];
                $this->Product->updateAll(array('Product.quantity' => $product_quntity),array('Product.id' => $product_id));
            }
            //积分
            $user_point_filter="";
            $user_point_filter="  UserPointLog.log_type = 'B' and UserPointLog.type_id = ".$id." and UserPointLog.user_id = ".$operator_user_id;
            $point_logs=$this->UserPointLog->findall($user_point_filter);
            if(isset($point_logs) && count($point_logs) > 0){
                $user_info=$this->User->findbyid($operator_user_id);
                $back_point=0;
                foreach($point_logs as $k => $v){
                    $point_log=array("id" => "","user_id" => $operator_user_id,"point" => $v['UserPointLog']['point'],"log_type" => "A","system_note" => "管理员:".$_SESSION['Operator_Info']['Operator']['name']." 设订单".$order_info["Order"]["order_code"]."无效退还积分","type_id" => $_REQUEST['order_id']);
                    $this->UserPointLog->save($point_log);
                    $back_point-=$v['UserPointLog']['point'];
                }
                $user_info['User']['point']-=$back_point;
                $user_info['User']['user_point']-=$back_point;
                $this->User->save($user_info);
            }
            //电子优惠卷
            if($order_info['Order']['coupon_id'] > 0){
                $coupon=$this->Coupon->findbyid($order_info['Order']['coupon_id']);
                if(isset($coupon['Coupon'])){
                    $coupon['Coupon']['order_id']=0;
                    $this->Coupon->save($coupon['Coupon']);
                }
            }
            //Email
            if($this->configs['enable_auto_send_mail']==1 || $this->configs['enable_send_invalid_email']==1){
                $products=array();
                foreach($order_info['OrderProduct']as $k => $v){
                    $products[$k]=$this->OrderProduct->find("OrderProduct.product_id = ".$v['product_id']."");
                }
                $products_info="";
                if(isset($products) && count($products) > 0){
                    foreach($products as $k => $v){
                        $products_info.="------------------------------------- <br />";
                        $products_info.="商品ID：".$v['OrderProduct']['product_id']."<br />";
                        $products_info.="商品名：".$v['OrderProduct']['product_name']."<br />";
                        $products_info.="商品编号：".$v['OrderProduct']['product_code']."<br />";
                        $products_info.="商品价格：".$v['OrderProduct']['product_price']." <br />";
                        $products_info.="购买数量：".$v['OrderProduct']['product_quntity']."<br />";
                        $products_info.="------------------------------------- <br />";
                    }
                }
                else{
                    $products_info.="无相关商品信息 <br />";
                }
                $to_email=$order_info['Order']['email'];
                $template='order_invalid';
                $consignee=$order_info['Order']['consignee'];
                $this->MailTemplate->set_locale($this->locale);
                $template=$this->MailTemplate->find("code = '$template' and status = '1'");
                $formated_add_time=$order_info['Order']['created'];
                $id=$order_info['Order']['id'];
                $shop_name=$this->configs['shop_name'];
                $send_date=date('Y-m-d H:m:s');
                $sent_date=date('Y-m-d H:m:s');
                $fromName=$shop_name;
                $subject=$template['MailTemplateI18n']['title'];
                $this->Email->sendAs='html';
                $this->Email->is_ssl=$this->configs['smtp_ssl'];
    			$this->Email->is_mail_smtp=$this->configs['mail_service'];

                $this->Email->smtp_port=$this->configs['smtp_port'];
                $this->Email->smtpHostNames="".$this->configs['smtp_host']."";
                $this->Email->smtpUserName="".$this->configs['smtp_user']."";
                $this->Email->smtpPassword="".$this->configs['smtp_pass']."";
                $this->Email->fromName=$fromName;
                eval("\$subject = \"$subject\";");
                $this->Email->subject="=?utf-8?B?".base64_encode($subject)."?=";
                $this->Email->from="".$this->configs['smtp_user']."";
                $shop_url=$this->server_host.$this->cart_webroot;
                $template_str=$template['MailTemplateI18n']['html_body'];
                eval("\$template_str = \"$template_str\";");
                $this->Email->html_body=$template_str;
                $text_body=$template['MailTemplateI18n']['text_body'];
                eval("\$text_body = \"$text_body\";");
                $this->Email->text_body=$text_body;
                $this->Email->to="".$to_email."";
                if(@$this->Email->send()!=1){
                	$msg.="邮件发送失败,";
                }

            }
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'订单'.$order_code=$order_info['Order']['order_code'].'设为无效','operation');
            }
            $msg.="订单已经设为无效";
        }
        elseif($_REQUEST['action_type']=='return'){
            $refund_return_type=$_REQUEST['refund_return'];
            $refund_return_note=$_REQUEST['refund_return_note'];
            $this->order_refund($order_info,$refund_return_type,$refund_return_note);
            $this->Order->update_order(array('id' => $id,'status' => '4','payment_status' => '0','shipping_status' => '0','money_paid' => '0'));
            $this->OrderAction->update_order_action(array('order_id' => $id,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => '4','payment_status' => '0','shipping_status' => '0','action_note' => $_REQUEST['action_note']));
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'订单'.$order_code=$order_info['Order']['order_code'].'已退回','operation');
            }
            $msg="订单已经退回";
        }
        elseif($_REQUEST['action_type']=='after_service'){
            $this->OrderAction->update_order_action(array('order_id' => $id,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => $order_info['Order']['status'],'payment_status' => $order_info['Order']['payment_status'],'shipping_status' => $order_info['Order']['shipping_status'],'action_note' => $_REQUEST['action_note']));
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'订单'.$order_code=$order_info['Order']['order_code'].'售后服务','operation');
            }
            $msg="售后服务";
        }
        Configure::write('debug',0);
        $result['type']="0";
        $result['msg']=$msg;
        $result['order_id']=$id;
        die(json_encode($result));
    }
    function onchange_address($id){
        $onchange_address=$this->UserAddress->findById($id);
        Configure::write('debug',0);
        die(json_encode($onchange_address));
    }
    function order_refund($order_info,$refund_type,$refund_note,$refund_amount=0){
        $user_id=$order_info['Order']['user_id'];
        if($user_id==0 && $refund_type==1){
            $this->flash("匿名,不能返回帐户余额",'/orders/'.$order_info['Order']['id'],10);
        }
        $amount=$refund_amount > 0 ? $refund_amount : $order_info['Order']['money_paid'];
        if($amount <= 0){
            return true;
        }
        if(!in_array($refund_type,array(1,2,3))){
            $this->flash("无效的退款类型",'/orders/'.$order_info['Order']['id'],10);
        }
        if($refund_note){
            $change_desc=$refund_note;
        }
        else{
            $change_desc=sprintf('订单退款：'.$this->configs['price_format'],$order_info['Order']['id']);
        }
        if($refund_type==1){
            $user_info=$this->User->findbyid($order_info['Order']['user_id']);
            $user_info['User']['balance'] += $order_info['Order']['money_paid'];
            $user_info['User']['point'] += $order_info['Order']['point_use'];
            $user_info['User']['user_point'] += $order_info['Order']['point_use'];
            $this->User->save($user_info);
            $balance_log=array("id" => '',"user_id" => $order_info['Order']['user_id'],"amount" => $order_info['Order']['money_paid'],"log_type" => "R","type_id" => $order_info['Order']['id'],"system_note" => "订单".$order_info['Order']['order_code']."退款"
            );
            $this->UserBalanceLog->save($balance_log);
            $point_log=array("id" => '',"user_id" => $order_info['Order']['user_id'],"point" => $order_info['Order']['point_use'],"log_type" => "A","type_id" => $order_info['Order']['id'],"system_note" => "订单".$order_info['Order']['order_code']."退货"
            );
            $this->UserPointLog->save($point_log);
            return true;
        }
        else if($refund_type==1){
            if($user_id > 0){
                $user_info=$this->User->findbyid($order_info['Order']['user_id']);
                $user_info['User']['balance'] += $order_info['Order']['money_paid'];
                $this->User->save($user_info);
                $balance_log=array("id" => '',"user_id" => $order_info['Order']['user_id'],"amount" => $order_info['Order']['money_paid'],"log_type" => "R","type_id" => $order_info['Order']['id'],"system_note" => "订单".$order_info['Order']['order_code']."退款");
                $this->UserBalanceLog->save($balance_log);
            }
            $this->UserAccount->add_account($user_id,$amount,$order_info['Order']['payment_time'],0,0,0,$order_info['Order']['payment_name']);
            return true;
        }
        else{
            return true;
        }
    }
    function virtual_products_ship($virtual_products,$order_id,$return_result=false){
        $virtual_card=array();
        foreach($virtual_products AS $code => $products_list){
            if($code=='virtual_card'){
                foreach($products_list as $products){
                    if(!$this->virtual_card_shipping($products,$order_id)){
                        return false;
                    }
                }
            }
        }
        return true;
    }
    function virtual_card_shipping($product,$order_id=""){
        $condition="";
        $condition['VirtualCard.product_id']=$product['Product']['id'];
        $condition['VirtualCard.is_saled']=0;
        $num=$this->VirtualCard->findCount($condition,0);
        if($num < $product['OrderProduct']['num']){
            return false;
        }
        if($product['OrderProduct']['num']!=0){
            $virtualcard_info=$this->VirtualCard->findAll($condition,"","",$product['OrderProduct']['num']);
        }
        else{
            $virtualcard_info=array();
        }
        $cards=array();
        foreach($virtualcard_info as $k => $v){
            if($v['VirtualCard']['crc32']==0 || $v['VirtualCard']['crc32']==crc32(AUTH_KEY)){
                $virtualcard_info[$k]['VirtualCard']['card_sn']=$this->requestAction("/commons/decrypt/".$v['VirtualCard']['card_sn']);
                $virtualcard_info[$k]['VirtualCard']['card_password']=$this->requestAction("/commons/decrypt/".$v['VirtualCard']['card_password']);
            }
            else{
                return false;
            }
            $cards=$virtualcard_info;
        }
        foreach($virtualcard_info as $k => $v){
            $this->VirtualCard->updateAll(array('VirtualCard.is_saled' => 1),array('VirtualCard.id' => $v['VirtualCard']['id']));
        }
        $condition212['product_id']=$product['Product']['id'];
        $condition212['is_saled']=0;
        $total=$this->VirtualCard->findCount($condition212,0);
        $this->Product->updateAll(array('Product.quantity' => $total),array('Product.id' => $product['Product']['id']));
        $order_info=$this->Order->findById($order_id);
        foreach($order_info['OrderProduct']as $k => $v){
            if($v['product_id']==$product['Product']['id']){
                $update_arr_id[]=$v['id'];
            }
        }
        foreach($virtualcard_info as $k => $v){
            $this->VirtualCard->updateAll(array('VirtualCard.order_id' => $order_info['Order']['id']),array('VirtualCard.id' => $v['VirtualCard']['id']));
        }
        foreach($update_arr_id as $k => $v){
            $this->OrderProduct->updateAll(array('OrderProduct.send_quntity' => $product['OrderProduct']['num']),array('OrderProduct.id' => $v));
        }
        $virtualcards_info="";
        foreach($cards as $k => $v){
            $virtualcards_info.="------------------------------------- <br />";
            $virtualcards_info.="卡号：".$v['VirtualCard']['card_sn']."<br />";
            $virtualcards_info.="卡片密码：".$v['VirtualCard']['card_password']."<br />";
            $virtualcards_info.="截至日期：".$v['VirtualCard']['end_date']."<br />";
            $virtualcards_info.="------------------------------------- <br />";
        }
        $consignee=$order_info['Order']['consignee'];
        $order_sn=$order_info['Order']['order_code'];
        $product_name=$product['OrderProduct']['product_name'];
        $shop_name=$this->configs['shop_name'];
        $send_date=date('Y-m-d H:m:s');
        $to_email=$order_info['Order']['email'];
        $template='virtual_vard';
        $this->MailTemplate->set_locale($this->locale);
        $template=$this->MailTemplate->find("code = '$template' and status = '1'");
        $fromName=$shop_name;
        $subject=$template['MailTemplateI18n']['title'];
        $this->Email->sendAs='html';
        $this->Email->is_ssl=$this->configs['smtp_ssl'];
		$this->Email->is_mail_smtp=$this->configs['mail_service'];

        $this->Email->smtp_port=$this->configs['smtp_port'];
        $this->Email->smtpHostNames="".$this->configs['smtp_host']."";
        $this->Email->smtpUserName="".$this->configs['smtp_user']."";
        $this->Email->smtpPassword="".$this->configs['smtp_pass']."";
        $this->Email->fromName=$fromName;
        eval("\$subject = \"$subject\";");
        $this->Email->subject="=?utf-8?B?".base64_encode($subject)."?=";
        $this->Email->from="".$this->configs['smtp_user']."";
        $shop_url=$this->server_host.$this->cart_webroot;
        $template_str=$template['MailTemplateI18n']['html_body'];
        eval("\$template_str = \"$template_str\";");
        $this->Email->html_body=$template_str;
        $text_body=$template['MailTemplateI18n']['text_body'];
        eval("\$text_body = \"$text_body\";");
        $this->Email->text_body=$text_body;
        $this->Email->to="".$to_email."";
        $this->Email->send();
        return true;
    }
    function virtual_card_result($order_id,$products){
    }
    function order_confim_email($order_id,$order_info){
        $order_info_now=$this->Order->findbyid($order_id);
        $order_code=$order_info_now['Order']['order_code'];
        if($order_info['Order']['status']!=0 && $order_info_now['Order']['status']==1){
            if($this->configs['enable_auto_send_mail']==1 && $this->configs['enable_send_confirm_email']==1 || $user_config['UserConfig']['value']==1){
                $to_email=$order_info['Order']['email'];
                $template='order_confirm';
                $consignee=$order_info['Order']['consignee'];
                $products=array();
                foreach($order_info['OrderProduct']as $k => $v){
                    $products[$k]=$this->OrderProduct->find("OrderProduct.product_id = ".$v['product_id']."");
                }
                $products_info="";
                foreach($products as $k => $v){
                    $products_info.="------------------------------------- <br />";
                    $products_info.="商品ID：".$v['OrderProduct']['product_id']."<br />";
                    $products_info.="商品名：".$v['OrderProduct']['product_name']."<br />";
                    $products_info.="商品编号：".$v['OrderProduct']['product_code']."<br />";
                    $products_info.="商品价格：".$v['OrderProduct']['product_price']." <br />";
                    $products_info.="购买数量：".$v['OrderProduct']['product_quntity']."<br />";
                    $products_info.="------------------------------------- <br />";
                }
                $this->MailTemplate->set_locale($this->locale);
                $template=$this->MailTemplate->find("code = '$template' and status = '1'");
                $formated_add_time=$order_info['Order']['created'];
                $id=$order_info['Order']['id'];
                $shop_name=$this->configs['shop_name'];
                $sent_date=date('Y-m-d H:m:s');
                $fromName=$shop_name;
                $subject=$template['MailTemplateI18n']['title'];
                $this->Email->sendAs='html';
                $this->Email->is_ssl=$this->configs['smtp_ssl'];
				$this->Email->is_mail_smtp=$this->configs['mail_service'];

                $this->Email->smtp_port=$this->configs['smtp_port'];
                $this->Email->smtpHostNames="".$this->configs['smtp_host']."";
                $this->Email->smtpUserName="".$this->configs['smtp_user']."";
                $this->Email->smtpPassword="".$this->configs['smtp_pass']."";
                $this->Email->fromName=$fromName;
                eval("\$subject = \"$subject\";");
                $this->Email->subject="=?utf-8?B?".base64_encode($subject)."?=";
                $this->Email->from="".$this->configs['smtp_user']."";
                $template_str=$template['MailTemplateI18n']['html_body'];
                $shop_url=$this->server_host.$this->cart_webroot;
                eval("\$template_str = \"$template_str\";");
                $this->Email->html_body=$template_str;
                $text_body=$template['MailTemplateI18n']['text_body'];
                eval("\$text_body = \"$text_body\";");
                $this->Email->text_body=$text_body;
                $this->Email->to="".$to_email."";
                $this->Email->send();
            }
        }
    }
    //批量打印配送单
    function batch_shipping_print($id=''){
        $this->pageTitle='配送单打印'." - ".$this->configs['shop_name'];
        $pro_ids='';
        if(empty($id)){
        	if($this->params['form']['act']=='batch'){
                $pro_ids=!empty($this->params['form']['checkboxes']) ? $this->params['form']['checkboxes']: 0;
            }
            else{
                $pro_ids[]=!empty($this->params['form']['orderr_id']) ? $this->params['form']['orderr_id']: 0;
            }
        }
        else
        {
        	$pro_ids[] = $id;
        }
        if(!empty($pro_ids)){
            $all_order_info=array();
            foreach($pro_ids as $vid){
                $order_info=array();
                //取得订单及订单商品信息
                $order_info=$this->Order->findById($vid);
                $this->Shipping->set_locale($this->locale);
                $shippings_list=$this->Shipping->shipping_list();
                //支持货到付款的配送方式
       	        $is_cod_shipping = array();
       	        foreach($shippings_list as $ks=>$kv)
       	        {
       		        if($kv['Shipping']['support_cod']==1) $is_cod_shipping[]=$kv['Shipping']['id'];
       	        }
                $order_info['Order']['is_cod']=(in_array($order_info['Order']['shipping_id'],$is_cod_shipping)?1:0);
                
                $order_info['Order']['allvirtual']='';
                $order_info['Order']['novirtual_subtotal']=0;
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
                $virtualnum = $novsub = 0;
                foreach($order_info['OrderProduct']as $kk => $vv){
                    $order_info['OrderProduct'][$kk]['product_total']='';
                    $order_info['OrderProduct'][$kk]['product_total']=sprintf($this->configs['price_format'],sprintf("%01.2f",$vv['product_price']*$vv['product_quntity']));
                    $order_info['OrderProduct'][$kk]['product_price']=sprintf($this->configs['price_format'],sprintf("%01.2f",$vv['product_price']));
                    $aa = isset($vv['extension_code'])?$vv['extension_code']:'0';
                    $virtualnum += (($aa=='virtual_card')?1:0);
                    if($aa=='virtual_card'){
                    	$novsub += ($vv['product_price']*$vv['product_quntity']);
                    }
                }
                $order_info['Order']['allvirtual']=(count($order_info['OrderProduct'])==$virtualnum)?1:0;
                $order_info['Order']['novirtual_subtotal']=$order_info['Order']['subtotal']-$novsub;
                //格式化价格数据
                $order_info['Order']['format_shipping_fee'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['shipping_fee']));
                $order_info['Order']['format_point_fee'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['point_fee']));
                $order_info['Order']['format_payment_fee'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['payment_fee']));
                $order_info['Order']['format_money_paid'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['money_paid']));
                $order_info['Order']['format_total'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['total']));
                $order_info['Order']['format_novir_subtotal'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['novirtual_subtotal']));
                $order_info['Order']['format_tax'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['tax']));
                $order_info['Order']['format_insure_fee'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['insure_fee']));
                $order_info['Order']['format_pack_fee'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['pack_fee']));
                $order_info['Order']['format_card_fee'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['card_fee']));
                $order_info['Order']['format_should_pay'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$order_info['Order']['total']-$order_info['Order']['money_paid']-$order_info['Order']['point_fee']));
                
                $all_order_info[]=$order_info;
            }
            //pr($all_order_info);exit();
            $this->set('all_order_info',$all_order_info);
            $this->layout='shipping_print';
        }
    }
    
    function orderpay($order_info,$id,$operator_id,$operator_user_id ,$action_note){
            $order=array();
            $modified=date('Y-m-d H:i:s');
            if($order_info['Order']['status']!='1'){
                $order['status']='1';
                $order['confirm_time']=$modified;
            }
            $payment=$this->Payment->find("Payment.id = ".$order_info['Order']['payment_id']." and Payment.status = '1'");
            if($payment['Payment']['is_cod']){
                $order['shipping_status']='2';
                $order_info['Order']['shipping_status']='2';
            }
            $order['id']=$id;
            $order['payment_status']='2';
            $order['payment_time']=$modified;
            $coupon_info=$this->Coupon->findById($order_info["Order"]["coupon_id"]);
            $amount_payables=$order_info['Order']['total']-$order_info['Order']['money_paid']-$order_info['Order']['discount']-$order_info['Order']['point_fee']-$coupon_info["Coupon"]["order_amount_discount"]+0;
            $order['money_paid']=$amount_payables;
            $condition_v['OrderProduct.order_id']=$order['id'];
            $total1=$this->OrderProduct->findCount($condition_v,0);
            $condition_v['OrderProduct.extension_code']='virtual_card';
            $total2=$this->OrderProduct->findCount($condition_v,0);
            if($total1==$total2){
                $virtual_card_status="yes";
                $order['shipping_status']='1';
                $order_info['Order']['shipping_status']='1';
                $this->OrderAction->update_order_action(array('order_id' => $id,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => '1','payment_status' => '2','shipping_status' => '1','action_note' => $action_note));
            }
            else{
                $virtual_card_status="no";
                $this->OrderAction->update_order_action(array('order_id' => $id,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => '1','payment_status' => '2','shipping_status' => $order_info['Order']['shipping_status'],'action_note' => $action_note));
            }
            $this->Order->update_order($order);
            $order=$this->Order->findbyid($order['id']);
            if($this->configs['order_smallest'] <= $order['Order']['subtotal'] && $this->configs['out_order_gift_points']==1 && $this->configs['out_order_points'] > 0){
                $user_info=$this->User->findbyid($order['Order']['user_id']);
                $user_info['User']['point'] += $this->configs['out_order_points'];
                $user_info['User']['user_point'] += $this->configs['out_order_points'];
                $this->User->save($user_info);
                $point_log=array("id" => "","user_id" => $order['Order']['user_id'],"point" => $this->configs['out_order_points'],"log_type" => "B","system_note" => "超过订单金额 ".$this->configs['order_smallest']." 赠送积分","type_id" => $order['Order']['id']);
                $this->UserPointLog->save($point_log);
            }
            if($this->configs['order_gift_points']==1 && $this->configs['order_points'] > 0){
                $user_info=$this->User->findbyid($order['Order']['user_id']);
                $user_info['User']['point'] += $this->configs['order_points'];
                $user_info['User']['user_point'] += $this->configs['order_points'];//等级积分
                $this->User->save($user_info);
                $point_log=array("id" => "","user_id" => $order['Order']['user_id'],"point" => $this->configs['order_points'],"log_type" => "B","system_note" => "下单送积分","type_id" => $order['Order']['id']);
                $this->UserPointLog->save($point_log);
            }
            $product_point=array();
            $product_ids=$this->OrderProduct->findallbyorder_id($order['Order']['id']);
            foreach($product_ids as $k => $v){
                $product=$this->Product->findbyid($v['OrderProduct']['product_id']);
                $product_point[$k]=array('point' => $product['Product']['point']*$v['OrderProduct']['product_quntity'],'name' => $product['ProductI18n']['name']);
            }
            if(is_array($product_point) && sizeof($product_point) > 0){
                foreach($product_point as $k => $v){
                    if($v['point'] > 0){
                        $user_info=$this->User->findbyid($order['Order']['user_id']);
                        $user_info['User']['point'] += $v['point'];
                        $user_info['User']['user_point'] += $v['point'];
                        $this->User->save($user_info);
                        $point_log=array("id" => "","user_id" => $order['Order']['user_id'],"point" => $v['point'],"log_type" => "B","system_note" => "商品 ".$v['name']." 送积分","type_id" => $order['Order']['id']);
                        $this->UserPointLog->save($point_log);
                    }
                }
            }
            if(isset($this->configs['send_coupons']) && $this->configs['send_coupons']==1){
                $now=date("Y-m-d H:i:s");
                $this->CouponType->set_locale($this->locale);
                $order_coupon_type=$this->CouponType->findall("CouponType.send_type = 2 and CouponType.send_start_date <= '".$now."' and CouponType.send_end_date >= '".$now."'");
                if(is_array($order_coupon_type) && sizeof($order_coupon_type) > 0){
                    $coupon_arr=$this->Coupon->findall("",'DISTINCT Coupon.sn_code');
                    $coupon_count=count($coupon_arr);
                    $num=0;
                    if($coupon_count > 0){
                        $num=$coupon_arr[$coupon_count-1]['Coupon']['sn_code'];
                    }
                    foreach($order_coupon_type as $k => $v){
                        if($v['CouponType']['min_products_amount'] < $order['Order']['subtotal']){
                            if(isset($coupon_sn)){
                                $num=$coupon_sn;
                            }
                            $num=substr($num,2,10);
                            $num=$num ? floor($num/10000): 100000;
                            $coupon_sn=$v['CouponType']['prefix'].$num.str_pad(mt_rand(0,9999),4,'0',STR_PAD_LEFT);
                            $order_coupon=array('id' => '','coupon_type_id' => $v['CouponType']['id'],'user_id' => $order['Order']['user_id'],'sn_code' => $coupon_sn);
                            $this->Coupon->save($order_coupon);
                        }
                    }
                }
                foreach($order['OrderProduct']as $k => $v){
                    $products[$k]=$this->OrderProduct->find("OrderProduct.product_id = ".$v['product_id']."");
                }
                $send_coupon=array();
                foreach($products as $k => $v){
                    if($v['Product']['coupon_type_id'] > 0){
                        $send_coupon[]=$v['Product']['coupon_type_id'];
                    }
                }
                if(is_array($send_coupon) && sizeof($send_coupon) > 0){
                    $coupon_arr=$this->Coupon->findall("",'DISTINCT Coupon.sn_code');
                    $coupon_count=count($coupon_arr);
                    $num=0;
                    if($coupon_count > 0){
                        $num=$coupon_arr[$coupon_count-1]['Coupon']['sn_code'];
                    }
                    foreach($send_coupon as $type_id){
                        if(isset($coupon_sn)){
                            $num=$coupon_sn;
                        }
                        $pro_coupon_type=$this->CouponType->findbyid($type_id);
                        $num=substr($num,2,10);
                        $num=$num ? floor($num/10000): 100000;
                        $coupon_sn=$pro_coupon_type['CouponType']['prefix'].$num.str_pad(mt_rand(0,9999),4,'0',STR_PAD_LEFT);
                        $pro_coupon=array('id' => '','coupon_type_id' => $pro_coupon_type['CouponType']['id'],'user_id' => $order['Order']['user_id'],'sn_code' => $coupon_sn);
                        $this->Coupon->save($pro_coupon);
                    }
                }
            }
            $virtual_products=$this->OrderProduct->get_virtual_products($id);
            $this->virtual_products_ship($virtual_products,$id);
            $this->Order->updateAll(array('Order.shipping_time' => "'".$this->today."'"),array('Order.id' => $id));
            $this->order_confim_email($id,$order_info);
            if($order_info['Order']['user_id'] > 0 && $virtual_card_status=="yes"){
                $user=$this->User->findbyid($order_info['Order']['user_id']);
                $virtual_point=0;
                foreach(@$virtual_products["virtual_card"]as $k => $v){
                    $virtual_point += $v["Product"]["point"]*$v["OrderProduct"]["product_quntity"];
                }
                if($virtual_point > 0){
                    $user_total_point=$user["User"]["point"]+$virtual_point;
                    $point_log=array("user_id" => $order_info['Order']['user_id'],"point" => $virtual_point,"log_type" => "B","type_id" => $id);
                    $this->UserPointLog->saveall($point_log);
                }
            }
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'订单'.$order_code=$order_info['Order']['order_code'].'已付款','operation');
            }
            
            //网站联盟，refferer_orders产生记录
			$plugin_union_admin = $this->Plugin->find_union();
			if(isset($plugin_union['Plugin']) && !empty($order_info['Order']['union_user_id'])){
				$this->requestAction('/union/union_orders/add_union_refferer_orders/'.$id);
			}
    	return true;
    }
    function order_status($status){
    	
    	foreach( $_REQUEST["checkboxes"] as $k=>$v ){
    		if($status=="confirm_status"){
    			$order_info = array(
    				"status"=>"1",
    				"id"=>$v
    			);
    			$this->Order->save($order_info);
    			$order_info=$this->Order->findbyid($v);
    			
		        $order_code=$order_info['Order']['order_code'];
		        $operator_id=$_SESSION['Operator_Info']['Operator']['id'];
		        $operator_user_id=$order_info['Order']['user_id'];
				$this->OrderAction->update_order_action(array('order_id' => $v,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => $order_info["Order"]["status"],'payment_status' => $order_info["Order"]["payment_status"],'shipping_status' => $order_info["Order"]["shipping_status"]));
    		}
    		if($status=="payment_status"){
    			$order_info = array(
    				"status"=>"1",
    				"payment_status"=>"2",
    				"id"=>$v
    			);
    			
    			$this->Order->save($order_info);
    			$order_info=$this->Order->findbyid($v);
    			$this->orderpay($order_info,$v,$_SESSION["Operator_Info"]["Operator"]["id"],$order_info['Order']['user_id'],"");
		        $order_code=$order_info['Order']['order_code'];
		        $operator_id=$_SESSION['Operator_Info']['Operator']['id'];
		        $operator_user_id=$order_info['Order']['user_id'];

    		}
    		if($status=="cancel_status"){
    			$order_info = array(
    				"status"=>"2",
    				"id"=>$v
    			);
    			$this->Order->save($order_info);
    			$order_info=$this->Order->findbyid($v);
		        $order_code=$order_info['Order']['order_code'];
		        $operator_id=$_SESSION['Operator_Info']['Operator']['id'];
		        $operator_user_id=$order_info['Order']['user_id'];
				$this->OrderAction->update_order_action(array('order_id' => $v,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => $order_info["Order"]["status"],'payment_status' => $order_info["Order"]["payment_status"],'shipping_status' => $order_info["Order"]["shipping_status"]));
    		}
    		if($status=="invalid_status"){
    			$order_info = array(
    				"status"=>"3",
    				"id"=>$v
    			);
    			$this->Order->save($order_info);
    			$order_info=$this->Order->findbyid($v);
		        $order_code=$order_info['Order']['order_code'];
		        $operator_id=$_SESSION['Operator_Info']['Operator']['id'];
		        $operator_user_id=$order_info['Order']['user_id'];
				$this->OrderAction->update_order_action(array('order_id' => $v,'from_operator_id' => $operator_id,'user_id' => $operator_user_id,'order_status' => $order_info["Order"]["status"],'payment_status' => $order_info["Order"]["payment_status"],'shipping_status' => $order_info["Order"]["shipping_status"]));
    		}
    		
    	}
        $this->flash("修改订单状态成功，点击返回列表页。",'/orders/',10);
    
    }
}

?>