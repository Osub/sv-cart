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
 * $Id: reports_controller.php 5028 2009-10-14 07:51:28Z huangbo $
 *****************************************************************************/
class ReportsController extends AppController{
    var $name='Reports';
    var $components=array('Pagination','RequestHandler');
    var $helpers=array('Pagination','Html');
    var $uses=array('Order','OrderProduct',"UserPointLog","User","ProductI18n","ProductTypeAttribute","ProductAttribute","ProviderProduct","UserBalanceLog","Payment","Shipping","SystemResource");
    
    function procurement($export=0,$csv_export_code="gbk"){
        /*判断权限*/
        $this->operator_privilege('purchase_order_view');
        /*end*/
        $this->pageTitle='进货单'." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'订单管理','url'=>'');
        $this->navigations[]=array('name' => '进货单','url' => '/reports/procurement/');
        $this->set('navigations',$this->navigations);

        $start_time='';
        $end_time='';
        if(isset($this->params['url']['start_time']) && $this->params['url']['start_time']!=''){
        	$start_time=$this->params['url']['start_time'];
        	$condition["and"]["ProviderProduct.modified >="]=$start_time;
        }
        else {
            $start_time = date('Y-m-').'1';
            $condition["and"]["ProviderProduct.modified >="]=$start_time;
        }
        if(isset($this->params['url']['end_time']) && $this->params['url']['end_time']!=''){
            $end_time=$this->params['url']['end_time'];
            $condition["and"]["ProviderProduct.modified <="]=$end_time." 23:59:59";
        }
        else{
            $end_time = date('Y-m-d');
            $condition["and"]["ProviderProduct.modified <="]=$end_time." 23:59:59";
        }

        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=array($rownum,$page);
        $options=array();
        $total=$this->ProviderProduct->find("count",array("conditions"=>$condition));
        $sortClass='ProviderProduct';
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        $provider_product_info = $this->ProviderProduct->find("all",array("conditions"=>$condition,"group"=>"product_id","fields"=>"sum(Product.quantity) as quantity,Product.code,Provider.name,Provider.description,ProviderProduct.product_id"));
        //pr($provider_product_info);
        $product_id = array();
        foreach( $provider_product_info as $k=>$v ){
        	$product_id[] = $v["ProviderProduct"]["product_id"];
        }
        //pr($product_id);
        //取商品名称
        $product_i18n_info = $this->ProductI18n->find("all",array("conditions"=>array("product_id"=>$product_id,"locale"=>$this->locale),"fields"=>"product_id,name"));
        $product_i18n_info_new = array();
        foreach( $product_i18n_info as $k=>$v ){
        	$product_i18n_info_new[$v["ProductI18n"]["product_id"]] = $v;
        }
        //取商品属性
        $this->ProductAttribute->hasOne=array();
        $product_attributes_info = $this->ProductAttribute->find("all",array("conditions"=>array("product_id"=>$product_id)));
        
        $product_i18n_info_new = array();
        foreach( $product_i18n_info as $k=>$v ){
        	$product_i18n_info_new[$v["ProductI18n"]["product_id"]] = $v;
        }
        $product_type_attribute_id = array();
       	foreach( $product_attributes_info as $k=>$v ){
       		$product_type_attribute_id[] = $v["ProductAttribute"]["product_type_attribute_id"];
       	}
       	$ProductTypeAttribute_info = $this->ProductTypeAttribute->find("all",array("conditions"=>array("ProductTypeAttribute.id"=>$product_type_attribute_id)));
       	$ProductTypeAttribute_info_new = array();
       	foreach( $ProductTypeAttribute_info as $k=>$v){
       		$ProductTypeAttribute_info_new[$v["ProductAttribute"]["product_id"]][$v["ProductTypeAttributeI18n"]["id"]]= $v;
       	}

        foreach( $provider_product_info as $k=>$v ){
        	$aup = empty($ProductTypeAttribute_info_new[$v["ProviderProduct"]["product_id"]])?array():$ProductTypeAttribute_info_new[$v["ProviderProduct"]["product_id"]];
        	$str = "";
        	foreach( $aup as $kk=>$vv){
        		$str.=$vv["ProductTypeAttributeI18n"]["name"]." : ".$vv["ProductAttribute"]["product_type_attribute_value"]."<br />";
        	}
        	$provider_product_info[$k]["Product"]["Attribute"] = $str;
        }

        $this->set("provider_product_info",$provider_product_info);
        $this->set("product_i18n_info_new",$product_i18n_info_new);
        $this->set("ProductTypeAttribute_info_new",$product_i18n_info_new);
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//

        $this->set('systemresource_info',$systemresource_info);

        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);

      	if(isset($export) && $export==="export"){
      		$condition = "";
      		$languagedictionary[] = "back_purchase_order_export";//采购单导出
      		$languagedictionary[] = "back_procurement_statistics_report";//采购统计报表
      		$languagedictionary[] = "back_select_a_date";//选择日期

      		$languagedictionary[] = "back_product_code";//貨號
      		$languagedictionary[] = "back_product_name";//商品名稱
      		$languagedictionary[] = "back_property";//屬性
      		$languagedictionary[] = "back_amount";//數量
      		$languagedictionary[] = "back_supplier";//供應商
      		$languagedictionary[] = "back_notes";//備註
      		$condition["name"] = $languagedictionary;
			$csv_systemResource = $this->SystemResource->findbyresource_value($csv_export_code);
			$condition["locale"] = $csv_systemResource["SystemResource"]["code"];
      		$languagedictionary_info = $this->LanguageDictionary->find("all",array("conditions"=>$condition));
      		$csv_str = array();
      		foreach( $languagedictionary_info as $csv_k=>$csv_v ){
      			$csv_str[$csv_v["LanguageDictionary"]["name"]] = $csv_v["LanguageDictionary"]["value"];
      		}

      		
      		
            $filename=$csv_str["back_purchase_order_export"].''.date('Ymd').'.csv';//back_purchase_order_export
            $ex_data=$csv_str["back_procurement_statistics_report"].",";//back_procurement_statistics_report
            $ex_data.=$csv_str["back_select_a_date"].":,";//back_select_a_date
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
            $ex_data.=$csv_str["back_product_code"].",";
            $ex_data.=$csv_str["back_product_name"].",";
            $ex_data.=$csv_str["back_property"].",";
            $ex_data.=$csv_str["back_amount"].",";
            $ex_data.=$csv_str["back_supplier"].",";
            $ex_data.=$csv_str["back_notes"].",";
            $ex_data.="\n";
            foreach($provider_product_info as $v){
                $ex_data.=$v['Product']['code'].",";
                $ex_data.=(empty($product_i18n_info_new[$v['ProviderProduct']['product_id']]["ProductI18n"]["name"])?"未知商品":$product_i18n_info_new[$v['ProviderProduct']['product_id']]["ProductI18n"]["name"]).",";
                $ex_data.=$v['Product']['Attribute'].",";
                $ex_data.=$v['0']['quantity'].",";
                if(isset($v["Provider"]['name'])){
                    $ex_data.=$v["Provider"]['name'].",";
                }
                else{
                    $ex_data.=",";
                }
                $ex_data.=$v['Provider']['description']."\n";
            }
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=".$csv_export_code);
            header("Content-Disposition: attachment; filename=".iconv('utf-8',$csv_export_code,$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8',$csv_export_code,$ex_data."\n");
            exit;
        }
    }
    function shipments($export=0,$csv_export_code="gbk"){
        
        $this->operator_privilege('shipping_order_view');
        
        $this->pageTitle='发货单'." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'订单管理','url'=>'');
        $this->navigations[]=array('name' => '发货单','url' => '/reports/shipments/');
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
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=array($rownum,$page);
        $options=array();
        $total=$this->Order->findCount($condition,0);
        $sortClass='Order';
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        $myfields[] = "Order.order_code";
        $myfields[] = "Order.consignee";
        $myfields[] = "Order.address";
        $myfields[] = "Order.telephone";
        $myfields[] = "Order.mobile";
        $myfields[] = "Order.email";
        $myfields[] = "Order.payment_fee";
        $myfields[] = "Order.payment_time";
        $myfields[] = "Order.payment_name";
        $myfields[] = "Order.total";
        $myfields[] = "Order.order_locale";
        $data=$this->Order->find("all",array("conditions"=>$condition,"limit"=>$rownum,"page"=>$page,"order"=>"Order.id asc","fields"=>$myfields));
        
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
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//

        $this->set('systemresource_info',$systemresource_info);
        $this->set('orders',$data);
        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);
        $this->set('locale',$order_locale);
        
        if(isset($export) && $export==="export"){
      		$condition = "";
      		$languagedictionary[] = "back_outgoing_manifest_export";//待发货单导出
      		$languagedictionary[] = "back_outgoing_manifest_statistical_report";//待发货单统计报表
      		$languagedictionary[] = "back_select_a_date";//选择日期

      		$languagedictionary[] = "back_order_code";//订单号
      		$languagedictionary[] = "back_name";//姓名
      		$languagedictionary[] = "back_address";//地址
      		$languagedictionary[] = "back_phone";//電話
      		$languagedictionary[] = "back_payment";//付款方式
      		$languagedictionary[] = "back_payment_data";//付款日期
      		$languagedictionary[] = "back_totaled";//金額總計
      		$languagedictionary[] = "back_product_code";//货号
      		$languagedictionary[] = "back_product_name";//商品名称
      		$languagedictionary[] = "back_amount";//数量
      		$languagedictionary[] = "back_property";//属性
      		$languagedictionary[] = "back_price";//价格

      		$condition["name"] = $languagedictionary;
			$csv_systemResource = $this->SystemResource->findbyresource_value($csv_export_code);
			$condition["locale"] = $csv_systemResource["SystemResource"]["code"];
      		$languagedictionary_info = $this->LanguageDictionary->find("all",array("conditions"=>$condition));
      		$csv_str = array();
      		foreach( $languagedictionary_info as $csv_k=>$csv_v ){
      			$csv_str[$csv_v["LanguageDictionary"]["name"]] = $csv_v["LanguageDictionary"]["value"];
      		}

        	
            $filename=$csv_str["back_outgoing_manifest_export"].''.date('Ymd').'.csv';//back_outgoing_manifest_export
            $ex_data=$csv_str["back_outgoing_manifest_statistical_report"].",";//back_outgoing_manifest_statistical_report
            $ex_data.=$csv_str["back_select_a_date"].":,";//back_select_a_date
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
            $ex_data.=$csv_str["back_order_code"].",";
            $ex_data.=$csv_str["back_name"].",";
            $ex_data.=$csv_str["back_address"].",";
            $ex_data.=$csv_str["back_phone"].",";
            $ex_data.=$csv_str["back_payment"].",";
            $ex_data.=$csv_str["back_payment_data"].",";
            $ex_data.=$csv_str["back_totaled"]."\n";
            foreach($data as $v){
                $ex_data.=$v['Order']['order_code'].",";
                $ex_data.=$v['Order']['consignee'].",";
                $ex_data.=$v['Order']['address'].",";
                $ex_data.=$v['Order']['telephone'].",";
                $ex_data.=$v['Order']['payment_name'].",";
                $ex_data.=$v['Order']['payment_time'].",";
                $ex_data.=$v['Order']['total']."\n";
                $ex_data.=",";
                $ex_data.=$csv_str["back_product_code"].",";
                $ex_data.=$csv_str["back_product_name"].",";
                $ex_data.=$csv_str["back_amount"].",";
                $ex_data.=$csv_str["back_property"].",";
                $ex_data.=$csv_str["back_price"]."\n";
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
            header("Content-type: text/csv; charset=".$csv_export_code);
            header("Content-Disposition: attachment; filename=".iconv('utf-8',$csv_export_code,$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8',$csv_export_code,$ex_data."\n");
            exit;
        }
    }
    function balance($export=0,$csv_export_code="gbk"){
        /*判断权限*/
        $this->operator_privilege('user_funds_statement_view');
        /*end*/
        $this->pageTitle='用户资金报表'." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'客户管理','url'=>'');
        $this->navigations[]=array('name' => '余额统计','url' => '/reports/');
        $this->set('navigations',$this->navigations);
        $datatime=date("Y-m-d H:i:s");
        $start_time=date("Y-m-",strtotime($datatime))."1 00:00:00";
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
        $Usercondition="1=1";
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            if(isset($_REQUEST["order_locale"]) && !empty($_REQUEST["order_locale"])){
                $order_locale=$_REQUEST["order_locale"];
                $price_format=$this->currency_format[$order_locale];
                $Usercondition.="  and User.locale='$order_locale'";
            }
            else{
                $order_locale="";//$this->locale;
                $price_format=$this->currency_format["chi"];
                //$Usercondition.="  User.locale='$order_locale'";
            }
        }
        else{
            $price_format=$this->configs["price_format"];
            $order_locale=$this->locale;
        }
        $username="";
        if( !empty($_REQUEST['username']) ){
        	$username = $_REQUEST['username'];
        	$Usercondition.="   and  User.name LIKE  '%$username%'";
        }
        $balance = 1;
        $usermoney = 0;
       	if( !empty($_REQUEST['usermoney']) ){
       		$usermoney = $_REQUEST['usermoney'];
		}
        if( !empty($_REQUEST['balance']) ){
        	$balance = $_REQUEST['balance'];
        	
        	if($balance == 1){
        		$Usercondition.="   and  User.balance>".$usermoney;
        	}
        	if($balance == 2){
        		$Usercondition.="   and  User.balance=".$usermoney;
        	}
        	if($balance == 3){
        		$Usercondition.=" and User.balance<".$usermoney;
        	}
        }
        
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=array($rownum,$page);
        $options=array();
        $total=$this->User->findCount($Usercondition,0);
        $sortClass='Order';
        $page=$this->Pagination->init($Usercondition,$parameters,$options,$total,$rownum,$sortClass);
        $User=$this->User->find("all",array("conditions"=>$Usercondition,"limit"=>$rownum,"page"=>$page));
        
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
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//

        $this->set('systemresource_info',$systemresource_info);
        $this->set('usermoney',$usermoney);
        $this->set('balance',$balance);
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
        	
      		$condition = "";
      		$languagedictionary[] = "back_balance_statistical_export";//余额统计导出
      		$languagedictionary[] = "back_balance_statistical";//余额统计
      		$languagedictionary[] = "back_select_a_date";//选择日期 選擇日期
      			
      		$languagedictionary[] = "back_username";//用戶名
      		$languagedictionary[] = "back_seed_money";//起始資金
      		$languagedictionary[] = "back_use";//使用
      		$languagedictionary[] = "back_get";//獲得
      		$languagedictionary[] = "back_balance";//結餘
			$languagedictionary[] = "back_total";//總計

  			
      		$condition["name"] = $languagedictionary;
			$csv_systemResource = $this->SystemResource->findbyresource_value($csv_export_code);
			$condition["locale"] = $csv_systemResource["SystemResource"]["code"];
      		$languagedictionary_info = $this->LanguageDictionary->find("all",array("conditions"=>$condition));
      		$csv_str = array();
      		foreach( $languagedictionary_info as $csv_k=>$csv_v ){
      			$csv_str[$csv_v["LanguageDictionary"]["name"]] = $csv_v["LanguageDictionary"]["value"];
      		}
            $filename=$csv_str["back_balance_statistical_export"].''.date('Ymd').'.csv';//back_balance_statistical_export
            $ex_data=$csv_str["back_balance_statistical"].",";//back_balance_statistical
            $ex_data.=$csv_str["back_select_a_date"].":,";
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
            $ex_data.=$csv_str["back_username"].",";
            $ex_data.=$csv_str["back_seed_money"].",";
            $ex_data.=$csv_str["back_use"].",";
            $ex_data.=$csv_str["back_get"].",";
            $ex_data.=$csv_str["back_balance"]."\n";
            foreach($User as $k => $v){
                $ex_data.=$v['User']['name'].",";
                $ex_data.=$v['User']['start_amount'].",";
                $ex_data.=$v['User']['zc_amount'].",";
                $ex_data.=$v['User']['sl_amount'].",";
                $ex_data.=$v['User']['amountsum']."\n";
            }
            $ex_data.=$csv_str["back_total"].",";
            $ex_data.=$amount_start_sum.",";
            $ex_data.=$amount_zc_sum.",";
            $ex_data.=$amount_sl_sum.",";
            $ex_data.=$amountsums."\n";
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=".$csv_export_code);
            header("Content-Disposition: attachment; filename=".iconv('utf-8',$csv_export_code,$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8',$csv_export_code,$ex_data."\n");
            exit;
        }
    }
    function point($export=0,$csv_export_code="gbk"){
        /*判断权限*/
        $this->operator_privilege('accumulate_point_view');
        /*end*/
        $this->pageTitle='积分报表'." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'客户管理','url'=>'');
        $this->navigations[]=array('name' => '积分统计','url' => '/reports/point/');
        $this->set('navigations',$this->navigations);
        if($this->RequestHandler->isPost()){
            $start_time=$_REQUEST['start_time']." 00:00:00";
            $end_time=$_REQUEST['end_time']." 23:59:59";
            $datatime=$start_time;
        }
        else{
            $start_time=date("Y-m-")."1 00:00:00";
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
                //$Usercondition.="  User.locale='$order_locale'";
            }
        }
        else{
            $price_format=$this->configs["price_format"];
            $order_locale=$this->locale;
        }
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=array($rownum,$page);
        $options=array();
        $total=$this->User->findCount($Usercondition,0);
        $sortClass='Order';
        $page=$this->Pagination->init($Usercondition,$parameters,$options,$total,$rownum,$sortClass);
        $User=$this->User->find("all",array("conditions"=>$Usercondition,"limit"=>$rownum,"page"=>$page));
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
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//

        $this->set('systemresource_info',$systemresource_info);

        /*CSV导出*/
        if(isset($export) && $export==="export"){
      		$condition = "";
      		$languagedictionary[] = "back_username";//用戶名
      		$languagedictionary[] = "back_points_since_the_beginning";//起始積分
      		$languagedictionary[] = "back_use";//使用
      		$languagedictionary[] = "back_get";//獲得
      		$languagedictionary[] = "back_balance";//結餘
      		$languagedictionary[] = "back_select_a_date";//选择日期 選擇日期
      		$languagedictionary[] = "back_points_export_statistics";//选择日期 選擇日期
      		$languagedictionary[] = "back_points_statistics";//选择日期 選擇日期
      		$languagedictionary[] = "back_total";//總計
      		$condition["name"] = $languagedictionary;
			$csv_systemResource = $this->SystemResource->findbyresource_value($csv_export_code);
			$condition["locale"] = $csv_systemResource["SystemResource"]["code"];
      		$languagedictionary_info = $this->LanguageDictionary->find("all",array("conditions"=>$condition));
      		$csv_str = array();
      		foreach( $languagedictionary_info as $csv_k=>$csv_v ){
      			$csv_str[$csv_v["LanguageDictionary"]["name"]] = $csv_v["LanguageDictionary"]["value"];
      		}

        	
            $filename=$csv_str["back_points_export_statistics"].''.date('Ymd').'.csv';//back_points_export_statistics
            $ex_data=$csv_str["back_points_statistics"].",";//back_points_statistics
            $ex_data.=$csv_str["back_select_a_date"].":,";
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
            $ex_data.=$csv_str["back_username"].",";
            $ex_data.=$csv_str["back_points_since_the_beginning"].",";
            $ex_data.=$csv_str["back_use"].",";
            $ex_data.=$csv_str["back_get"].",";
            $ex_data.=$csv_str["back_balance"]."\n";
            foreach($User as $k => $v){
                $ex_data.=$v['User']['name'].",";
                $ex_data.=$v['User']['start_point'].",";
                $ex_data.=$v['User']['zc_point'].",";
                $ex_data.=$v['User']['sl_point'].",";
                $ex_data.=$v['User']['pointsum']."\n";
            }
            $ex_data.=$csv_str["back_total"].",";
            $ex_data.=$point_start_sum.",";
            $ex_data.=$point_zc_sum.",";
            $ex_data.=$point_sl_sum.",";
            $ex_data.=$pointsums."\n";
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=".$csv_export_code);
            header("Content-Disposition: attachment; filename=".iconv('utf-8',$csv_export_code,$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8',$csv_export_code,$ex_data."\n");
            exit;
        }
    }
    function consume($export=0,$orderby="number",$asc_desc="desc",$csv_export_code="gbk"){
        /*判断权限*/
        $this->operator_privilege('member_consume_statement_view');
        /*end*/
        $this->pageTitle='会员消费报表'." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'客户管理','url'=>'');
        $this->navigations[]=array('name' => '消费统计','url' => '/reports/consume/');
        $this->set('navigations',$this->navigations);
        $start_time='';
        $end_time='';    
        $condition = "";    
        $order = "sumorderid ".$asc_desc;
        if($orderby == "number"){
        	$order = "sumorderid ".$asc_desc;
        }
        if($orderby == "amount"){
        	$order = "money_paid ".$asc_desc;
        }

        if($this->RequestHandler->isPost()){
            if(isset($this->params['form']['start_time']) && !empty($this->params['form']['start_time'])){
            	
                $condition["and"]["Order.modified >="]=$this->params['form']['start_time'];
                $start_time=$this->params['form']['start_time'];
            }
            if(isset($this->params['form']['end_time']) && !empty($this->params['form']['end_time'])){
            	$condition["and"]["Order.modified <="]=$this->params['form']['end_time'];
                $end_time=$this->params['form']['end_time'];
            }
        }

        //dam
        if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module']==1){
            if(isset($_REQUEST["order_locale"]) && !empty($_REQUEST["order_locale"])){
                $order_locale=$_REQUEST["order_locale"];
                $price_format=$this->currency_format[$order_locale];
                $condition["and"]["Order.order_locale ="]= $order_locale;
            }
            else{
                $order_locale=$this->locale;
                $price_format=$this->currency_format[$order_locale];
                $condition["and"]["Order.order_locale ="]= $order_locale;
            }
        }
        else{
            $price_format=$this->configs["price_format"];
            $order_locale=$this->locale;
        }
        
		$this->set("price_format",$price_format);
        $this->Order->hasOne = array();
        $this->Order->hasMany = array();
        $condition["payment_status"] = "2";
        $total=$this->Order->findCount($condition,0);
        $sortClass='Order';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        $order_group = $this->Order->find("all",array("page"=>$page,"limit"=>$rownum,"order"=>$order,"conditions"=>$condition,"group"=>"user_id","fields"=>"count(order.id) as sumorderid,user_id,sum(money_paid) as money_paid,id"));
        
        foreach($order_group as $k=>$v){
        	$user_infos = $this->User->find("first",array("conditions"=>array("id"=>$v["Order"]["user_id"]),"fields"=>"name"));
        	$order_group[$k]["Order"]["user_name"] = !empty($user_infos["User"]["name"])?$user_infos["User"]["name"]:"未知";
        	$order_product_sum = $this->OrderProduct->find("all",array("conditions"=>array("order_id"=>$v["Order"]["id"]),"fields"=>"sum(product_quntity) as product_quntity"));
        	$order_group[$k]["Order"]["product_quntity"] = !empty($order_product_sum["0"]["0"]["product_quntity"])?$order_product_sum["0"]["0"]["product_quntity"]:"0";
        }
        $this->set("order_group",$order_group);
        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);
        $this->set('locale',$order_locale);
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//
        $this->set('systemresource_info',$systemresource_info);
		$this->set('asc_desc',$asc_desc=="asc"?"desc":"asc");
        $this->set('orderby',$orderby);


        
        //CSV导出
        if(isset($export) && $export==="export"){
        	
      		$condition = "";
      		$languagedictionary[] = "back_consumption_statistics_derived";//消费统计导出
      		$languagedictionary[] = "back_consumption_statistics";//消费统计
      		$languagedictionary[] = "back_select_a_date";//选择日期 選擇日期
      		
      		
      		$languagedictionary[] = "back_username";//會員名稱
      		$languagedictionary[] = "back_order_number";//訂單數
      		$languagedictionary[] = "back_amount";//商品數量
      		$languagedictionary[] = "back_the_total_amount_of_consumption";//消費總金額
   			$languagedictionary[] = "back_total";//總計
      		$condition["name"] = $languagedictionary;
			$csv_systemResource = $this->SystemResource->findbyresource_value($csv_export_code);
			$condition["locale"] = $csv_systemResource["SystemResource"]["code"];
      		$languagedictionary_info = $this->LanguageDictionary->find("all",array("conditions"=>$condition));
      		$csv_str = array();
      		foreach( $languagedictionary_info as $csv_k=>$csv_v ){
      			$csv_str[$csv_v["LanguageDictionary"]["name"]] = $csv_v["LanguageDictionary"]["value"];
      		}

        	
        	
        	
            $filename=$csv_str["back_consumption_statistics_derived"].''.date('Ymd').'.csv';//back_consumption_statistics_derived
            $ex_data=$csv_str["back_consumption_statistics"].",";//back_consumption_statistics
            $ex_data.=$csv_str["back_select_a_date"].":,";
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
            $ex_data.=$csv_str["back_username"].",";
            $ex_data.=$csv_str["back_order_number"].",";
            $ex_data.=$csv_str["back_amount"].",";
            $ex_data.=$csv_str["back_the_total_amount_of_consumption"]."\n";
            $total_order_sum=0;$total_order_product_sum=0;$price_format_sum=0;
            foreach($order_group as $k => $v){
                $ex_data.=$v["Order"]['user_name'].",";
                $ex_data.=$v["0"]["sumorderid"].",";$total_order_product_sum+= $v["Order"]["product_quntity"];
				$ex_data.=$v["Order"]["product_quntity"].",";$total_order_sum+= $v["0"]["sumorderid"];
				$ex_data.=$v["0"]["money_paid"]."\n";$price_format_sum+= $v["0"]["money_paid"];
            }
            $ex_data.=$csv_str["back_total"].",";
            $ex_data.=$total_order_sum.",";
            $ex_data.=$total_order_product_sum.",";
            $sum_money=sprintf($price_format,sprintf("%01.2f",$price_format_sum));
            $ex_data.=$sum_money."\n";
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=".$csv_export_code);
            header("Content-Disposition: attachment; filename=".iconv('utf-8',$csv_export_code,$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8',$csv_export_code,$ex_data."\n");
            exit;
       } 
        
    }
    function sales($export=0,$orderby="number",$asc_desc="desc",$csv_export_code="gbk"){
        /*判断权限*/
        $this->operator_privilege('goods_sale_statement_view');
        /*end*/
        $this->pageTitle='商品销售报表'." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '商品销售排行','url' => '/reports/sales/');
        $this->set('navigations',$this->navigations);

        $condition="OrderProduct.status='1'";
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
        $data=$this->OrderProduct->find("all",array("conditions"=>$condition,"group"=>"product_code","order"=>$order,"fields"=>array("sum(product_quntity) as product_quntity,product_price,product_code,product_name")));
      	$quntitysum = 0;
        $pricesum =0;
       	foreach($data as $k=>$v){
       		$quntitysum+=$v[0]["product_quntity"];
       		$pricesum+=$v["OrderProduct"]["product_price"];
       		$data[$k]["OrderProduct"]["product_quntity"]=$v[0]["product_quntity"];
       		$data[$k]["OrderProduct"]["product_price"]=$v["OrderProduct"]["product_price"];
       	}
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//

        $this->set('systemresource_info',$systemresource_info);
        $this->set('productcount',count($data));
        $this->set('quntitysum',$quntitysum);
        $this->set('pricesum',$pricesum);
        $this->set('orderproducts',$data);
        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);

        $this->set('orderby',$orderby);
        $this->set('asc_desc',$asc_desc=="asc"?"desc":"asc");
        /*CSV导出*/
        if(isset($export) && $export==="export"){
      		$condition = "";
      		$languagedictionary[] = "back_top_export_commodity_sales";//商品销售排行导出
      		$languagedictionary[] = "back_merchandising_ranking";//商品销售排行
      		$languagedictionary[] = "back_select_a_date";//选择日期 選擇日期
      			
      		$languagedictionary[] = "back_product_code";//货号
      		$languagedictionary[] = "back_product_name";//商品名稱
      		$languagedictionary[] = "back_amount";//數量
      		$languagedictionary[] = "back_price";//售價
      		$languagedictionary[] = "back_total";//總計


      		$condition["name"] = $languagedictionary;
			$csv_systemResource = $this->SystemResource->findbyresource_value($csv_export_code);
			$condition["locale"] = $csv_systemResource["SystemResource"]["code"];
      		$languagedictionary_info = $this->LanguageDictionary->find("all",array("conditions"=>$condition));
      		$csv_str = array();
      		foreach( $languagedictionary_info as $csv_k=>$csv_v ){
      			$csv_str[$csv_v["LanguageDictionary"]["name"]] = $csv_v["LanguageDictionary"]["value"];
      		}

        	
        	
            $filename=$csv_str["back_top_export_commodity_sales"].''.date('Ymd').'.csv';//back_top_export_commodity_sales
            $ex_data=$csv_str["back_merchandising_ranking"].",";//
            $ex_data.=$csv_str["back_select_a_date"].":,";//"";//选择日期 選擇日期
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
            $ex_data.=$csv_str["back_product_code"].",";
            $ex_data.=$csv_str["back_product_name"].",";
            $ex_data.=$csv_str["back_amount"].",";
            $ex_data.=$csv_str["back_price"].",";
            $ex_data.="\n";
            foreach($data as $v){
                $ex_data.=$v['OrderProduct']['product_code'].",";
                $ex_data.=$v['OrderProduct']['product_name'].",";
                $ex_data.=$v['OrderProduct']['product_quntity'].",";
                $ex_data.=$v['OrderProduct']['product_price']."\n";
            }
            $ex_data.=$csv_str["back_total"].",";
            $ex_data.=count($data).",";
            $ex_data.=$quntitysum.",";
            $ex_data.=$pricesum."\n";
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=".$csv_export_code);
            header("Content-Disposition: attachment; filename=".iconv('utf-8',$csv_export_code,$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8',$csv_export_code,$ex_data."\n");
            exit;
        }
    }
    function orderstatus($export=0,$csv_export_code="gbk"){
        /*判断权限*/
        $this->operator_privilege('order_status_statement_view');
        /*end*/
        $this->pageTitle='订单状态统计'." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'订单管理','url'=>'');
        $this->navigations[]=array('name' => '订单状态统计','url' => '/reports/orderstatus/');
        $this->set('navigations',$this->navigations);
        $condition='1=1 ';
        $start_time='';
        $end_time='';
		$this->Order->belongsTo=array();
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

        $this->Order->hasOne=array();
        $this->Order->hasMany=array();
        $data=$this->Order->find("all",array("conditions"=>$condition,"group"=>"Order.payment_id,Order.status,Order.shipping_status,Order.payment_status","fields"=>array("Order.payment_id as payment_id,count(Order.id) as order_id_count,status ,shipping_status,payment_status,payment_name")));
		$payment = array();
        foreach( $data as $k=>$v ){
        	$payment[$v["Order"]["payment_id"]] = $v["Order"]["payment_name"];
        	if($v["Order"]["status"]==0){
        		@$order_statistics[$v["Order"]["payment_id"]]["status"][$v["Order"]["status"]]["order_id_count"]+= $v[0]["order_id_count"];
        		@$order_statistics_sum["status"][$v["Order"]["status"]]["order_id_count_sum"]+= $v[0]["order_id_count"];
        	}
        	if($v["Order"]["status"]==1){
        		@$order_statistics[$v["Order"]["payment_id"]]["status"][$v["Order"]["status"]]["order_id_count"]+= $v[0]["order_id_count"];
        		@$order_statistics_sum["status"][$v["Order"]["status"]]["order_id_count_sum"]+= $v[0]["order_id_count"];

        	}
        	if($v["Order"]["status"]==2){
        		@$order_statistics[$v["Order"]["payment_id"]]["status"][$v["Order"]["status"]]["order_id_count"]+= $v[0]["order_id_count"];
        		@$order_statistics_sum["status"][$v["Order"]["status"]]["order_id_count_sum"]+= $v[0]["order_id_count"];

        	}
        	if($v["Order"]["status"]==3){
        		@$order_statistics[$v["Order"]["payment_id"]]["status"][$v["Order"]["status"]]["order_id_count"]+= $v[0]["order_id_count"];
        		@$order_statistics_sum["status"][$v["Order"]["status"]]["order_id_count_sum"]+= $v[0]["order_id_count"];

        	}
        	if($v["Order"]["status"]==4){
        		@$order_statistics[$v["Order"]["payment_id"]]["status"][$v["Order"]["status"]]["order_id_count"]+= $v[0]["order_id_count"];
        		@$order_statistics_sum["status"][$v["Order"]["status"]]["order_id_count_sum"]+= $v[0]["order_id_count"];

        	}
        	if($v["Order"]["shipping_status"]==0){
        		@$order_statistics[$v["Order"]["payment_id"]]["shipping_status"][$v["Order"]["shipping_status"]]["order_id_count"]+= $v[0]["order_id_count"];
        		@$order_statistics_sum["shipping_status"][$v["Order"]["shipping_status"]]["order_id_count_sum"]+= $v[0]["order_id_count"];

        	}
        	if($v["Order"]["shipping_status"]==1){
        		@$order_statistics[$v["Order"]["payment_id"]]["shipping_status"][$v["Order"]["shipping_status"]]["order_id_count"]+= $v[0]["order_id_count"];
        		@$order_statistics_sum["shipping_status"][$v["Order"]["shipping_status"]]["order_id_count_sum"]+= $v[0]["order_id_count"];
        	}
        	if($v["Order"]["shipping_status"]==2){
        		@$order_statistics[$v["Order"]["payment_id"]]["shipping_status"][$v["Order"]["shipping_status"]]["order_id_count"]+= $v[0]["order_id_count"];
        		@$order_statistics_sum["shipping_status"][$v["Order"]["shipping_status"]]["order_id_count_sum"]+= $v[0]["order_id_count"];

        	}
        	if($v["Order"]["shipping_status"]==3){
        		@$order_statistics[$v["Order"]["payment_id"]]["shipping_status"][$v["Order"]["shipping_status"]]["order_id_count"]+= $v[0]["order_id_count"];
        		@$order_statistics_sum["shipping_status"][$v["Order"]["shipping_status"]]["order_id_count_sum"]+= $v[0]["order_id_count"];

        	}
        	if($v["Order"]["payment_status"]==0){
        		@$order_statistics[$v["Order"]["payment_id"]]["payment_status"][$v["Order"]["payment_status"]]["order_id_count"]+= $v[0]["order_id_count"];
         		@$order_statistics_sum["payment_status"][$v["Order"]["payment_status"]]["order_id_count_sum"]+= $v[0]["order_id_count"];

        	}
        	if($v["Order"]["payment_status"]==1){
        		@$order_statistics[$v["Order"]["payment_id"]]["payment_status"][$v["Order"]["payment_status"]]["order_id_count"]+= $v[0]["order_id_count"];
         		@$order_statistics_sum["payment_status"][$v["Order"]["payment_status"]]["order_id_count_sum"]+= $v[0]["order_id_count"];
        	}
        	if($v["Order"]["payment_status"]==2){
        		@$order_statistics[$v["Order"]["payment_id"]]["payment_status"][$v["Order"]["payment_status"]]["order_id_count"]+= $v[0]["order_id_count"];
         		@$order_statistics_sum["payment_status"][$v["Order"]["payment_status"]]["order_id_count_sum"]+= $v[0]["order_id_count"];
        	}
        }
    	//pr($order_statistics_sum);
    	//资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//

        $this->set("systemresource_info",@$systemresource_info);
        $this->set("order_statistics",@$order_statistics);
        $this->set("order_statistics_sum",@$order_statistics_sum);
        $this->set("payment",@$payment);
        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);
        $this->set('locale',$order_locale);
        $this->set('csv_export_code',$csv_export_code);
        
        
     //   pr($order_statistics);
        /*CSV导出*/
        if(isset($export) && $export==="export"){
      		$condition = "";
      		$languagedictionary[] = "back_payment";
      		$languagedictionary[] = "back_order_status";
      		$languagedictionary[] = "back_delivery_status";
      		$languagedictionary[] = "back_payment_status";
      		$languagedictionary[] = "back_unconfirmed";
      		$languagedictionary[] = "back_confirmed";
      		$languagedictionary[] = "back_canceled";
      		$languagedictionary[] = "back_invalid";
      		$languagedictionary[] = "back_return";
      		$languagedictionary[] = "back_unfilled";
      		$languagedictionary[] = "back_shipped";
      		$languagedictionary[] = "back_has_been_receiving";
      		$languagedictionary[] = "back_stocking_in_the";
      		$languagedictionary[] = "back_unpaid";
      		$languagedictionary[] = "back_payment_in";
      		$languagedictionary[] = "back_paid";
      		$languagedictionary[] = "back_export_order_status_report";//订单状态报表导出
      		$languagedictionary[] = "back_order_status_report";//订单状态报表
      		$languagedictionary[] = "back_select_a_date";//选择日期 選擇日期
      		$condition["name"] = $languagedictionary;
			$csv_systemResource = $this->SystemResource->findbyresource_value($csv_export_code);
			$condition["locale"] = $csv_systemResource["SystemResource"]["code"];
      		$languagedictionary_info = $this->LanguageDictionary->find("all",array("conditions"=>$condition));
      		$csv_str = array();
      		foreach( $languagedictionary_info as $csv_k=>$csv_v ){
      			$csv_str[$csv_v["LanguageDictionary"]["name"]] = $csv_v["LanguageDictionary"]["value"];
      		}
            $filename=$csv_str["back_export_order_status_report"].''.date('Ymd').'.csv';
            $ex_data=$csv_str["back_order_status_report"].",";
            $ex_data.=$csv_str["back_select_a_date"].":,";
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
            $ex_data.=$csv_str["back_payment"].",,,";
            $ex_data.=$csv_str["back_order_status"].",,,,";
            $ex_data.=$csv_str["back_delivery_status"].",,,,";
            $ex_data.=$csv_str["back_payment_status"].",";
            $ex_data.="\n";
            $ex_data.=$csv_str["back_unconfirmed"].", ,";
            $ex_data.=$csv_str["back_confirmed"].",";
            $ex_data.=$csv_str["back_canceled"].",";
            $ex_data.=$csv_str["back_invalid"].",";
            $ex_data.=$csv_str["back_return"].",";
            $ex_data.=$csv_str["back_unfilled"].",";
            $ex_data.=$csv_str["back_shipped"].",";
            $ex_data.=$csv_str["back_has_been_receiving"].",";
            $ex_data.=$csv_str["back_stocking_in_the"].",";
            $ex_data.=$csv_str["back_unpaid"].",";
            $ex_data.=$csv_str["back_payment_in"]."付款中,";
            $ex_data.=$csv_str["back_paid"]."已付款,";
            $ex_data.="\n";
            foreach($payment as $k => $v){
                $ex_data.=$v.",";
                $ex_data.=!empty($order_statistics[$k]["status"]["0"]["order_id_count"])?$order_statistics[$k]["status"]["0"]["order_id_count"].",":"0".",";
                $ex_data.=!empty($order_statistics[$k]["status"]["1"]["order_id_count"])?$order_statistics[$k]["status"]["1"]["order_id_count"].",":"0".",";
                $ex_data.=!empty($order_statistics[$k]["status"]["2"]["order_id_count"])?$order_statistics[$k]["status"]["2"]["order_id_count"].",":"0".",";
                $ex_data.=!empty($order_statistics[$k]["status"]["3"]["order_id_count"])?$order_statistics[$k]["status"]["3"]["order_id_count"].",":"0".",";
				$ex_data.=!empty($order_statistics[$k]["status"]["4"]["order_id_count"])?$order_statistics[$k]["status"]["4"]["order_id_count"].",":"0".",";
                
                $ex_data.=!empty($order_statistics[$k]["shipping_status"]["0"]["order_id_count"])?$order_statistics[$k]["shipping_status"]["0"]["order_id_count"].",":"0".",";
                $ex_data.=!empty($order_statistics[$k]["shipping_status"]["1"]["order_id_count"])?$order_statistics[$k]["shipping_status"]["1"]["order_id_count"].",":"0".",";
                $ex_data.=!empty($order_statistics[$k]["shipping_status"]["2"]["order_id_count"])?$order_statistics[$k]["shipping_status"]["2"]["order_id_count"].",":"0".",";
                $ex_data.=!empty($order_statistics[$k]["shipping_status"]["3"]["order_id_count"])?$order_statistics[$k]["shipping_status"]["3"]["order_id_count"].",":"0".",";

                $ex_data.=!empty($order_statistics[$k]["payment_status"]["0"]["order_id_count"])?$order_statistics[$k]["payment_status"]["0"]["order_id_count"].",":"0".",";
                $ex_data.=!empty($order_statistics[$k]["payment_status"]["1"]["order_id_count"])?$order_statistics[$k]["payment_status"]["1"]["order_id_count"].",":"0".",";
                $ex_data.=!empty($order_statistics[$k]["payment_status"]["2"]["order_id_count"])?$order_statistics[$k]["payment_status"]["2"]["order_id_count"].",":"0".",";
				$ex_data.="\n";
            }
            $ex_data.="合计,";

            $ex_data.=!empty($order_statistics_sum["status"]["0"]["order_id_count_sum"])?$order_statistics_sum["status"]["0"]["order_id_count_sum"].",":"0".",";
            $ex_data.=!empty($order_statistics_sum["status"]["1"]["order_id_count_sum"])?$order_statistics_sum["status"]["1"]["order_id_count_sum"].",":"0".",";
            $ex_data.=!empty($order_statistics_sum["status"]["2"]["order_id_count_sum"])?$order_statistics_sum["status"]["2"]["order_id_count_sum"].",":"0".",";
            $ex_data.=!empty($order_statistics_sum["status"]["3"]["order_id_count_sum"])?$order_statistics_sum["status"]["3"]["order_id_count_sum"].",":"0".",";
            $ex_data.=!empty($order_statistics_sum["status"]["4"]["order_id_count_sum"])?$order_statistics_sum["status"]["4"]["order_id_count_sum"].",":"0".",";
            
            $ex_data.=!empty($order_statistics_sum["shipping_status"]["0"]["order_id_count_sum"])?$order_statistics_sum["shipping_status"]["0"]["order_id_count_sum"].",":"0".",";
            $ex_data.=!empty($order_statistics_sum["shipping_status"]["1"]["order_id_count_sum"])?$order_statistics_sum["shipping_status"]["1"]["order_id_count_sum"].",":"0".",";
            $ex_data.=!empty($order_statistics_sum["shipping_status"]["2"]["order_id_count_sum"])?$order_statistics_sum["shipping_status"]["2"]["order_id_count_sum"].",":"0".",";
            $ex_data.=!empty($order_statistics_sum["shipping_status"]["3"]["order_id_count_sum"])?$order_statistics_sum["shipping_status"]["3"]["order_id_count_sum"].",":"0".",";

            $ex_data.=!empty($order_statistics_sum["payment_status"]["0"]["order_id_count_sum"])?$order_statistics_sum["payment_status"]["0"]["order_id_count_sum"].",":"0".",";
            $ex_data.=!empty($order_statistics_sum["payment_status"]["1"]["order_id_count_sum"])?$order_statistics_sum["payment_status"]["1"]["order_id_count_sum"].",":"0".",";
            $ex_data.=!empty($order_statistics_sum["payment_status"]["2"]["order_id_count_sum"])?$order_statistics_sum["payment_status"]["2"]["order_id_count_sum"].",":"0".",";

            $ex_data.="\n";
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=".$csv_export_code);
            header("Content-Disposition: attachment; filename=".iconv('utf-8',$csv_export_code,$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8',$csv_export_code,$ex_data."\n");
            exit;
        }
    }
    function orderfee($export=0,$csv_export_code="gbk"){
        /*判断权限*/
        $this->operator_privilege('order_perform_statement_view');
        /*end*/
        $this->pageTitle='订单业绩统计'." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'订单管理','url'=>'');
        $this->navigations[]=array('name' => '订单业绩统计','url' => '/reports/orderfee/');
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
            $condition["and"]["Order.order_locale ="]=$order_locale;
        }
        else{
            $order_locale=$this->locale;
            $price_format=$this->configs["price_format"];
        }
        $condition = "";
        $condition["and"]["Order.modified >="] = date("Y-m",strtotime($month))."-01";
        $condition["and"]["Order.modified <="] = date("Y-m",strtotime($month))."-31";
        
        $this->Order->hasOne=array();
        $this->Order->hasMany=array();
        $this->Order->belongsTo = array();
        $data=$this->Order->find("all",array("conditions"=>$condition,"group"=>"SUBSTR(Order.modified,1,10),Order.status,Order.shipping_status,Order.payment_status","fields"=>array("SUBSTR(Order.modified,1,10) as modified,count(Order.id) as order_id_count,sum(Order.total) as sumtotal,status as status,shipping_status,payment_status")));
		
        $OrderProduct = $this->OrderProduct->find("all",array("group"=>"SUBSTR(OrderProduct.modified,1,10)","fields"=>array("SUBSTR(OrderProduct.modified,1,10) as modified,sum(product_quntity) as product_quntity")));
        foreach( $OrderProduct as $k=>$v ){
        	$orderproduct_statistics[$v[0]["modified"]] = $v[0];
        }
        
        foreach( $data as $k=>$v ){
        	if($v["Order"]["shipping_status"]==1){
        		$order_statistics[$v[0]["modified"]]["shipping_status"][$v["Order"]["shipping_status"]] = $v[0];
        		@$statussum_all["shipping_status"][$v["Order"]["shipping_status"]]["statussum_all"]+= $order_statistics[$v[0]["modified"]]["shipping_status"][$v["Order"]["shipping_status"]]["order_id_count"];
        	}
        	if($v["Order"]["shipping_status"]==2){
        		$order_statistics[$v[0]["modified"]]["shipping_status"][$v["Order"]["shipping_status"]] = $v[0];
        		@$statussum_all["shipping_status"][$v["Order"]["shipping_status"]]["statussum_all"]+= $order_statistics[$v[0]["modified"]]["shipping_status"][$v["Order"]["shipping_status"]]["order_id_count"];
        	}
        	if(($v["Order"]["status"]==1&&$v["Order"]["payment_status"]==2&&$v["Order"]["shipping_status"]==0) ||( $v["Order"]["status"]==1&&$v["Order"]["payment_status"]==2&&$v["Order"]["shipping_status"]==3) ){
        		if( $v["Order"]["status"]==1&&$v["Order"]["shipping_status"]==3 && !empty($order_statistics[$v[0]["modified"]]["payment_status"][$v["Order"]["payment_status"]])){
        			$order_statistics[$v[0]["modified"]]["payment_status"][$v["Order"]["payment_status"]]["order_id_count"] += $v[0]["order_id_count"];
        			@$statussum_all["payment_status"][$v["Order"]["payment_status"]]["statussum_all"]+= $v[0]["order_id_count"];
        		}
        		else{
        			$order_statistics[$v[0]["modified"]]["payment_status"][$v["Order"]["payment_status"]] = $v[0];
        			@$statussum_all["payment_status"][$v["Order"]["payment_status"]]["statussum_all"]+= $order_statistics[$v[0]["modified"]]["payment_status"][$v["Order"]["payment_status"]]["order_id_count"];

        		}
        	}
        	
        	if($v["Order"]["shipping_status"]==0&&$v["Order"]["payment_status"]==0&&$v["Order"]["status"]==1){
        		$order_statistics[$v[0]["modified"]]["status"][$v["Order"]["status"]] = $v[0];
        		@$statussum_all["status"][$v["Order"]["status"]]["statussum_all"]+= $order_statistics[$v[0]["modified"]]["status"][$v["Order"]["status"]]["order_id_count"];
        	}
        	if($v["Order"]["status"]!=1){
        		$order_statistics[$v[0]["modified"]]["status"][$v["Order"]["status"]] = $v[0];
        		@$statussum_all["status"][$v["Order"]["status"]]["statussum_all"]+= $order_statistics[$v[0]["modified"]]["status"][$v["Order"]["status"]]["order_id_count"];
        	}
        	
        	$order_statistics[$v[0]["modified"]]["product_quntity"] = empty($orderproduct_statistics[$v[0]["modified"]]["product_quntity"])?0:$orderproduct_statistics[$v[0]["modified"]]["product_quntity"];
        	@$order_statistics[$v[0]["modified"]]["order_count"]+= $v[0]["order_id_count"];
        	@$order_statistics[$v[0]["modified"]]["sumtotal_all"]+= $v[0]["sumtotal"];
        	
        }
    	//资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//

        $this->set("systemresource_info",@$systemresource_info);

		$this->set("order_statistics",@$order_statistics);
		$this->set("statussum_all",@$statussum_all);
		$this->set("n",$n);
		$this->set("Y",date('Y'));
		$this->set("m",date('m'));
		$this->set("price_format",$price_format);
        $this->set('month',$month);
        $this->set('now_month_arr',$now_month_arr);
        $this->set('now_month',$now_month);
        $this->set('now_year_arr',$now_year_arr);
        $this->set('locale',$order_locale);
        /*CSV导出*/
        if(isset($export) && $export==="export"){
      		$condition = "";
      		$languagedictionary[] = "back_time";//時間
      		$languagedictionary[] = "back_order_status";//訂單狀態
      		$languagedictionary[] = "back_order_number";//訂單數量
      		$languagedictionary[] = "back_quantity_subtotal";//數量小計
      		$languagedictionary[] = "back_subtotal_amount";//金額小計
      		$languagedictionary[] = "back_unconfirmed";//未确认
      		$languagedictionary[] = "back_confirmed";//已确认
      		$languagedictionary[] = "back_canceled";//已取消
      		$languagedictionary[] = "back_invalid";//无效
      		$languagedictionary[] = "back_return";//退货
      		$languagedictionary[] = "back_paid";//已付款
      		$languagedictionary[] = "back_shipped";//已发货
      		$languagedictionary[] = "back_export_orders_for_performance_report";//订单业绩报表导出
      		$languagedictionary[] = "back_orders_for_performance_report";//订单业绩报表
      		$languagedictionary[] = "back_month_of";//统计月份
      		$languagedictionary[] = "back_total";//统计月份
      		$condition["name"] = $languagedictionary;
			$csv_systemResource = $this->SystemResource->findbyresource_value($csv_export_code);
			$condition["locale"] = $csv_systemResource["SystemResource"]["code"];
      		$languagedictionary_info = $this->LanguageDictionary->find("all",array("conditions"=>$condition));
      		$csv_str = array();
      		foreach( $languagedictionary_info as $csv_k=>$csv_v ){
      			$csv_str[$csv_v["LanguageDictionary"]["name"]] = $csv_v["LanguageDictionary"]["value"];
      		}

        	
        	
            $temp=explode('-',$month);
            $filename=$csv_str["back_export_orders_for_performance_report"].''.date('Ymd').'.csv';//back_export_orders_for_performance_report
            $ex_data=$csv_str["back_orders_for_performance_report"].",";//back_orders_for_performance_report
            $ex_data.=$csv_str["back_month_of"]."：,";//back_month_of
            $ex_data.=$temp[0]."年".$temp[1]."月\n";
            $ex_data.=$csv_str["back_time"].",,,";
            $ex_data.=$csv_str["back_order_status"].",,,";
            $ex_data.=$csv_str["back_order_number"].",";
            $ex_data.=$csv_str["back_quantity_subtotal"].",";
            $ex_data.=$csv_str["back_subtotal_amount"]."\n";
            $ex_data.=$temp[0]."年".$temp[1]."月,";
            $ex_data.=$csv_str["back_unconfirmed"].",";
            $ex_data.=$csv_str["back_confirmed"].",";
            $ex_data.=$csv_str["back_canceled"].",";
            $ex_data.=$csv_str["back_invalid"].",";
            $ex_data.=$csv_str["back_return"].",";
            $ex_data.=$csv_str["back_paid"].",";
            $ex_data.=$csv_str["back_shipped"].",";
            $ex_data.=$csv_str["back_order_number"].",";
            $ex_data.=$csv_str["back_quantity_subtotal"].",";
            $ex_data.=$csv_str["back_subtotal_amount"].",";
            $languagedictionary[] = "back_total";//總計
                $ex_data.="\n";
            $sum_order_count = 0;$sum_product_quntity = 0;$sum_sumtotal_all = 0;
            for($i=1;$i<=$n;$i++){$d = $i<10?"0".$i:$i;$this_data = date('Y')."-".date('m')."-".$d;
                $ex_data.=$i."日,";
				$ex_data.=empty($order_statistics[$this_data]["status"][0]["order_id_count"])?"0".",":$order_statistics[$this_data]["status"][0]["order_id_count"].",";
				$ex_data.=empty($order_statistics[$this_data]["status"][1]["order_id_count"])?"0".",":$order_statistics[$this_data]["status"][1]["order_id_count"].",";
				$ex_data.=empty($order_statistics[$this_data]["status"][2]["order_id_count"])?"0".",":$order_statistics[$this_data]["status"][2]["order_id_count"].",";
				$ex_data.=empty($order_statistics[$this_data]["status"][3]["order_id_count"])?"0".",":$order_statistics[$this_data]["status"][3]["order_id_count"].",";
				$ex_data.=empty($order_statistics[$this_data]["status"][4]["order_id_count"])?"0".",":$order_statistics[$this_data]["status"][4]["order_id_count"].",";
      
                $ex_data.=empty($order_statistics[$this_data]["payment_status"][2]["order_id_count"])?"0".",":$order_statistics[$this_data]["payment_status"][2]["order_id_count"].",";
                $ex_data.=empty($order_statistics[$this_data]["shipping_status"][1]["order_id_count"])?"0".",":$order_statistics[$this_data]["shipping_status"][1]["order_id_count"].",";
				
				$ex_data.= empty($order_statistics[$this_data]["order_count"])?"0".",":$order_statistics[$this_data]["order_count"].",";
                $ex_data.= empty($order_statistics[$this_data]["product_quntity"])?"0".",":$order_statistics[$this_data]["product_quntity"].",";
                $ex_data.= sprintf($price_format,sprintf("%01.2f",empty($order_statistics[$this_data]["sumtotal_all"])?"0".",":$order_statistics[$this_data]["sumtotal_all"])).",";
	           	$sum_order_count+= empty($order_statistics[$this_data]["order_count"])?"0".",":$order_statistics[$this_data]["order_count"].",";
				$sum_product_quntity+= empty($order_statistics[$this_data]["product_quntity"])?"0".",":$order_statistics[$this_data]["product_quntity"].",";
	     		$sum_sumtotal_all+= empty($order_statistics[$this_data]["sumtotal_all"])?"0".",":$order_statistics[$this_data]["sumtotal_all"].",";
                $ex_data.="\n";
            }
            $ex_data.=$csv_str["back_total"].",";
			$ex_data.=empty($statussum_all["status"][0]["statussum_all"])?"0".",":$statussum_all["status"][0]["statussum_all"].",";
			$ex_data.=empty($statussum_all["status"][1]["statussum_all"])?"0".",":$statussum_all["status"][1]["statussum_all"].",";
			$ex_data.=empty($statussum_all["status"][2]["statussum_all"])?"0".",":$statussum_all["status"][2]["statussum_all"].",";
			$ex_data.=empty($statussum_all["status"][3]["statussum_all"])?"0".",":$statussum_all["status"][3]["statussum_all"].",";
			$ex_data.=empty($statussum_all["status"][4]["statussum_all"])?"0".",":$statussum_all["status"][4]["statussum_all"].",";
			$ex_data.=empty($statussum_all["payment_status"][2]["statussum_all"])?"0".",":$statussum_all["payment_status"][2]["statussum_all"].",";
			$ex_data.=empty($statussum_all["shipping_status"][1]["statussum_all"])?"0".",":$statussum_all["shipping_status"][1]["statussum_all"].",";
			$ex_data.=$sum_order_count.",";
			$ex_data.=$sum_product_quntity.",";
			$ex_data.=$sum_sumtotal_all.",";
            $ex_data.="\n";
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=".$csv_export_code);
            header("Content-Disposition: attachment; filename=".iconv('utf-8',$csv_export_code,$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8',$csv_export_code,$ex_data."\n");
            exit;
        }
    }
    
     function returns($export=0,$csv_export_code="gbk"){
        /*判断权限*/
        $this->operator_privilege('order_return_view');
        /*end*/
        $this->pageTitle='退货单'." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'订单管理','url'=>'');
        $this->navigations[]=array('name' => '退货单','url' => '/reports/back/');
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
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();//find("first",array("conditions"=>array("code"=>"order_status")));
       	//

        $this->set('systemresource_info',$systemresource_info);
        $this->set('orders',$data);
        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);
        $this->set('locale',$order_locale);
        /*CSV导出*/
        if(isset($export) && $export==="export"){
      		$condition = "";
      		$languagedictionary[] = "back_return_to_export_a_single_report";//退货单报表导出
      		$languagedictionary[] = "back_return_a_single_statistical_report";//退货单统计报表
      		$languagedictionary[] = "back_select_a_date";//选择日期

      		$languagedictionary[] = "back_order_code";//订单号
      		$languagedictionary[] = "back_name";//姓名
      		$languagedictionary[] = "back_address";//地址
      		$languagedictionary[] = "back_phone";//電話
      		$languagedictionary[] = "back_payment";//付款方式
      		$languagedictionary[] = "back_payment_data";//付款日期
      		$languagedictionary[] = "back_totaled";//金額總計
      		
      		$languagedictionary[] = "back_product_code";//货号
      		$languagedictionary[] = "back_product_name";//商品名称
      		$languagedictionary[] = "back_amount";//数量
      		$languagedictionary[] = "back_property";//属性
      		$languagedictionary[] = "back_price";//价格

      		$condition["name"] = $languagedictionary;
			$csv_systemResource = $this->SystemResource->findbyresource_value($csv_export_code);
			$condition["locale"] = $csv_systemResource["SystemResource"]["code"];
      		$languagedictionary_info = $this->LanguageDictionary->find("all",array("conditions"=>$condition));
      		$csv_str = array();
      		foreach( $languagedictionary_info as $csv_k=>$csv_v ){
      			$csv_str[$csv_v["LanguageDictionary"]["name"]] = $csv_v["LanguageDictionary"]["value"];
      		}

        	
            $filename=$csv_str["back_return_to_export_a_single_report"].''.date('Ymd').'.csv';//back_return_to_export_a_single_report
            $ex_data=$csv_str["back_return_a_single_statistical_report"].",";//back_return_a_single_statistical_report
            $ex_data.=$csv_str["back_select_a_date"].":,";//back_select_a_date
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
            $ex_data.=$csv_str["back_order_code"].",";
            $ex_data.=$csv_str["back_name"].",";
            $ex_data.=$csv_str["back_address"].",";
            $ex_data.=$csv_str["back_phone"].",";
            $ex_data.=$csv_str["back_payment"].",";
            $ex_data.=$csv_str["back_payment_data"].",";
            $ex_data.=$csv_str["back_totaled"]."\n";
            foreach($data as $v){
                $ex_data.=$v['Order']['order_code'].",";
                $ex_data.=$v['Order']['consignee'].",";
                $ex_data.=$v['Order']['address'].",";
                $ex_data.=$v['Order']['telephone'].",";
                $ex_data.=$v['Order']['payment_name'].",";
                $ex_data.=$v['Order']['payment_time'].",";
                $ex_data.=$v['Order']['total']."\n";
                $ex_data.=",";
                $ex_data.=$csv_str["back_product_code"].",";
                $ex_data.=$csv_str["back_product_name"].",";
                $ex_data.=$csv_str["back_amount"].",";
                $ex_data.=$csv_str["back_property"].",";
                $ex_data.=$csv_str["back_price"]."\n";
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
            header("Content-type: text/csv; charset=".$csv_export_code);
            header("Content-Disposition: attachment; filename=".iconv('utf-8',$csv_export_code,$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8',$csv_export_code,$ex_data."\n");
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
    function express(){
		/*判断权限*/
		$this->operator_privilege('express_order_view');
		/*end*/

    	
		$this->pageTitle = "快递单" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'订单管理','url'=>'');
		$this->navigations[] = array('name'=>'快递单','url'=>'/areas/');
    	$this->set('navigations',$this->navigations);
    	
    	
        if(isset($this->params['url']['order_status']) && $this->params['url']['order_status']!='-1'){
            $condition["and"]["Order.status"]="".$this->params['url']['order_status']."";
        }
        if(isset($this->params['url']['payment_status']) && $this->params['url']['payment_status']!='-1'){
            $condition["and"]["Order.payment_status"]="".$this->params['url']['payment_status']."";
        }
        if(isset($this->params['url']['express_status']) && $this->params['url']['express_status']!='-1'){
            $condition["and"]["Order.express_status"]="".$this->params['url']['express_status']."";
        }
        if(isset($this->params['url']['date']) && $this->params['url']['date']!=''){
            $condition["and"]["Order.express_date >="]="".$this->params['url']['date']." 00:00:00";
            $this->set("start_time",$this->params['url']['date']);
        }
        if(isset($this->params['url']['date2']) && $this->params['url']['date2']!=''){
            $condition["and"]["Order.express_date <="]="".$this->params['url']['date2']." 23:59:59";
            $this->set("end_time",$this->params['url']['date2']);
        }

    	
    	
    	
    	
    	$this->Order->belongsTo = array();
        $this->Shipping->set_locale($this->locale);
        $shipping_list=$this->Shipping->shipping_list();
       	//支持货到付款的配送方式
       	$is_cod_shipping = array();
       	foreach($shipping_list as $ks=>$kv)
       	{
       		if($kv['Shipping']['support_cod']==1) $is_cod_shipping[]=$kv['Shipping']['id'];
       	}
    	$condition["or"]["and"]["Order.shipping_id"] = $is_cod_shipping;
    	$condition["or"]["and"]["Order.status"] = 1;
    	$condition["and"]["and"]["Order.shipping_status"] = 0;
    	$condition["or"]["Order.payment_status"] = 2;
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=array($rownum,$page);
        $options=array();
        $total=$this->Order->findCount($condition,0);
        $sortClass='Order';
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
    	$order_data = $this->Order->find("all",array("conditions"=>$condition,"page"=>$page,"limit"=>$rownum));
    	
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();
       	//
        $payment_status=isset($this->params['url']['payment_status']) ? $this->params['url']['payment_status']: -1;
        $shipping_status=isset($this->params['url']['shipping_status']) ? $this->params['url']['shipping_status']: -1;
        $express_status=isset($this->params['url']['express_status']) ? $this->params['url']['express_status']: -1;
       	$this->set('systemresource_info',$systemresource_info);//资源库信息
        $this->set('payment_status',$payment_status);
        $this->set('shipping_status',$shipping_status);
        $this->set('express_status',$express_status);
    	$this->set("order_list",$order_data);
    	
    }
}
?>