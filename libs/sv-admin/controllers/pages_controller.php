<?php
/*****************************************************************************
 * SV-Cart 后台首页
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: pages_controller.php 5382 2009-10-23 03:59:18Z huangbo $
*****************************************************************************/
class PagesController extends AppController {
	var $name = 'Pages';
	var $helpers = array('Html','Javascript');
	var $uses = array("UserAccount","UserMessage","Store","User",'ConfigI18n','Article','Operator','Operator_action','Operator_menu','Order','BookingProduct',"UserProductGallery",'Product','MailTemplate','Operator_log','Config','Language','OrderProduct');
	var $components = array('Captcha','Email','RequestHandler','Cookie');
	
	//Google快捷窗口
	function back_gears(){
		Configure::write('debug', 0);
	}
	//Google快捷窗口
	function google_shortcut(){
		Configure::write('debug', 0);
	}
	
	//清除缓存
	function clear_cache_bt(){
    	/* app模块 */
    	$app_model = array();
    	$app_model[] = array('name'=>'前台','dir_name'=>'sv-cart');
    	$app_model[] = array('name'=>'用户中心','dir_name'=>'sv-user');
    	$app_model[] = array('name'=>'后台','dir_name'=>'sv-admin');
    	$plugins = $this->Plugin->find("all",array("fields"=>array("name","app_contents")));
    	if(!empty($plugins)){
    		foreach($plugins as $k=>$v){
    			if(!empty($v['Plugin']['app_contents']))
    				$app_model[] = array('name'=>$v['Plugin']['name'],'dir_name'=>$v['Plugin']['app_contents']);
    		}
    	}
    	$this->set('app_model',$app_model);
		Configure::write('debug', 0);
	}
	//插件搜索
	function plugin_search(){
		Configure::write('debug', 0);
	}
	//在线帮助
	function online_help_div(){
		Configure::write('debug', 0);
	}
	//账户设置
	function account_settings(){
		Configure::write('debug', 0);
	}
	//关于SV-Cart
	function sys_about(){
		Configure::write('debug', 0);
	}
	
	
	function display(){
		//pr($this);
		//exit;
		if(!isset($_SESSION['Operator_Info'])){//判断是否已登陆，否则跳回登陆页
			$this->redirect("/login");
			exit;
		}
		//订单统计信息
		
		$await_ship=//待发货
		$unpaid=//未支付
		//$order_wait=//订单缺货
		$unconfirmed=//为确认
		$finished=//已成交
		$returned=//退款申请
		
		$path = func_get_args();
		/*
		if (!count($path)) {
			$this->redirect('/');
		}
		*/
		$count = count($path);
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}

		$this->set(compact('page', 'subpage', 'title'));
		$this->render(join('/', $path));
	}
	function home(){
		if(!isset($_SESSION['Operator_Info'])){//判断是否已登陆，否则跳回登陆页
			$this->redirect("/login");
			exit;
		}
		$this->Order->belongsTo=array();
		$this->Product->hasOne = array();
		//pr($_COOKIE);
		$this->locale = $_SESSION['Admin_Locale'];
		$this->pageTitle = "管理中心"." - ".$this->configs['shop_name'];
		//print_r($_SESSION);
		$this->navigations[] = array('name'=>'管理中心','url'=>'/pages/home/');
		$this->set('navigations',$this->navigations);
		
		//》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》1左
		//待发货订单
		$condition 						= 		"";
		$condition['status']			=		'1';
		$condition['shipping_status']	=		'3';
		$wait_shipments_order_count  	= 		$this->Order->findCount($condition,0);
		
		//等待支付订单
		$condition 						= 		"";
		$condition['payment_status !=']	=		'2';
		$condition['status  =']			=		'1';
		$wait_pay_order_count 			= 		$this->Order->findCount($condition,0);

		//订单缺货登记
		$condition 						= 		"";
		$order_oos_count 				= 		$this->BookingProduct->findCount($condition,0);

		//未确认订单
		$condition 						= 		"";
		$condition['status']			=		0;
		$not_confirm_order_count 		= 		$this->Order->findCount($condition,0);
		
		//已成交订单数
		$condition 						= 		"";
		$condition['payment_status']	=		'2';
		$order_complete_count 			= 		$this->Order->findCount($condition,0);

		$this->set("wait_shipments_order_count",$wait_shipments_order_count );//待发货订单
		$this->set("wait_pay_order_count",$wait_pay_order_count);//等待支付订单
		$this->set("order_oos_count",$order_oos_count);//订单缺货登记
		$this->set("not_confirm_order_count",$not_confirm_order_count);//未确认订单
		$this->set("order_complete_count",$order_complete_count);//已成交订单数
			
			
			
		//未处理充值申请
		$condition 						= 		"";
		$condition['status']			=		'0';
		$user_accounts_top 				= 		$this->UserAccount->findCount($condition,0);

		//库存警告商品数
		$condition 										= 		"";
		$condition										=		"Product.quantity<=Product.warn_quantity";
		$product_quantity_count 						= 		$this->Product->findCount($condition,0);


		
		
		//》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》1右
		//未回复商品咨询
		$condition 						= 		"";
		$condition['status']			=		'0';
		$condition['type']				=		'P';
		$usermessage_complete_count 	= 		$this->UserMessage->findCount($condition,0);
		
		//未查看订单留言
		$condition 						= 		"";
		$condition['status']			=		'0';
		$condition['type']				=		'O';
		$usermessage_order_complete_count 	= 		$this->UserMessage->findCount($condition,0);
		
		//未回复客户留言
		$condition 						= 		"";
		$condition['status']			=		'0';
		$condition['msg_type']			=		'2';
		$usermessage_all_complete_count = 		$this->UserMessage->findCount($condition,0);

		//未查看用户相册
		$condition 						= 		"";
		$condition["status"]			= 		"1";
		$this->UserProductGallery->hasOne = array();
		$this->UserProductGallery->hasMany = array();
		$this->UserProductGallery->belongsTo = array();
		$users_did_not_view_the_album 	= 		$this->UserProductGallery->findCount($condition,0);
		
		
		$this->set("usermessage_complete_count",$usermessage_complete_count);//库存警告商品数
		$this->set("usermessage_order_complete_count",$usermessage_order_complete_count);//库存警告商品数
		$this->set("usermessage_all_complete_count",$usermessage_all_complete_count);//未回复客户留言
		$this->set("users_did_not_view_the_album",$users_did_not_view_the_album);//未查看用户相册
		
		
		
		
		//》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》2左
		//今日成交订单
		$condition 						= 		"";
		$condition['payment_status']	=		'2';
		$condition['payment_time =']	=		date("Y-m-d")." 00:00:00";
		$this_order_complete_count 			= 		$this->Order->findCount($condition,0);
		
		//今日订单金额
		$condition 						= 		"";
		$condition['created >']			=		date("Y-m-d")." 00:00:00";
		$this_order_total 				= 		$this->Order->find("all",array("conditions"=>$condition,"group"=>"SUBSTR(Order.created,1,10)","fields"=>"sum(Order.total) as total"));
		$this_order_total = empty($this_order_total)?0:$this_order_total[0][0]["total"];
		
		//今日销售利润 
		$condition 						= 		"";
		$condition['created >']			=		date("Y-m-d")." 00:00:00";
		$this_order_id_info				= 		$this->Order->find("all",array("conditions"=>$condition,"fields"=>"Order.id"));
		$this_order_id_arr[] 			= 		0;
		foreach( $this_order_id_info as $k=>$v ){
			$this_order_id_arr[] = $v["Order"]["id"];
		}
		$orderproduct_info = $this->OrderProduct->find("all",array("conditions"=>array("OrderProduct.order_id"=>$this_order_id_arr),"fields"=>"sum(Product.purchase_price) as purchase_price"));
		$orderproduct_info = $this_order_total-empty($orderproduct_info[0][0]["purchase_price"])?0:$orderproduct_info[0][0]["purchase_price"];
		//今日新增会员
		$condition 						= 		"";
		$condition['created >']			=		date("Y-m-d")." 00:00:00";
		$this_user_count				= 		$this->User->find("all",array("conditions"=>$condition,"group"=>"SUBSTR(User.created,1,10)","fields"=>"count(User.id) as num"));
		$this_user_count 				=		empty($this_user_count)?0:$this_user_count[0][0]["num"];

		$this->set("this_order_complete_count",$this_order_complete_count);//今日成交订单
		$this->set("this_order_total",$this_order_total);//今日订单金额
		$this->set("orderproduct_info",$orderproduct_info);//今日销售利润
		$this->set("this_user_count",$this_user_count);//今日新增会员
		
		
		
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>2右
		//昨日成交订单
		$condition 						= 		"";
		$condition['payment_status']	=		'2';
		$condition['payment_time >']	=		date("Y-m-d",time()-24*60*60)." 00:00:00";
		$condition['payment_time <']	=		date("Y-m-d",time()-24*60*60)." 23:59:59";
		$this_order_complete_count1 	= 		$this->Order->findCount($condition,0);
		//昨日订单金额
		$condition 						= 		"";
		$condition['created >']			=		date("Y-m-d",time()-24*60*60)." 00:00:00";
		$condition['created <']			=		date("Y-m-d",time()-24*60*60)." 23:59:59";
		$this_order_total1 				= 		$this->Order->find("all",array("conditions"=>$condition,"group"=>"SUBSTR(Order.created,1,10)","fields"=>"sum(Order.total) as total"));
		$this_order_total1 = empty($this_order_tota1l[0][0]["total"])?0:$this_order_tota1l[0][0]["total"] ;
		
		///昨日销售利润 
		$condition 						= 		"";
		$condition['created >']			=		date("Y-m-d",time()-24*60*60)." 00:00:00";
		$this_order_id_info1			= 		$this->Order->find("all",array("conditions"=>$condition,"fields"=>"Order.id"));
		$this_order_id_arr1[] 			= 		0;
		foreach( $this_order_id_info1 as $k=>$v ){
			$this_order_id_arr1[] = $v["Order"]["id"];
		}
		$orderproduct_info1 = $this->OrderProduct->find("all",array("conditions"=>array("OrderProduct.order_id"=>$this_order_id_arr),"fields"=>"sum(Product.purchase_price) as purchase_price"));
		$orderproduct_info1 = $this_order_total1-empty($orderproduct_info1[0][0]["purchase_price"])?0:$orderproduct_info1[0][0]["purchase_price"];
	
		$this->set("orderproduct_info1",$orderproduct_info1);//昨日销售利润
		$this->set("this_order_complete_count1",$this_order_complete_count1);//昨日成交订单
		$this->set("this_order_total1",$this_order_total1);//昨日订单金额
		
		//》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》3左
		$this->Product->hasOne=array();
		$this->Product->hasMany=array();
		//商品总数
		$condition 										= 		"";
		$product_count 									= 		$this->Product->findCount($condition,0);
		
		//商品 
		$condition 										= 		"";
		$condition["extension_code"] 					= 		"";
		$condition["forsale"] 							= 		"1";
		$condition["status"] 							= 		"1";
		$product_and_product_count 						= 		$this->Product->findCount($condition,0);
		
		//下载 
		$condition 										= 		"";
		$condition["extension_code"] 					= 		"download_product";
		$product_and_download_product_count 	 		= 		$this->Product->findCount($condition,0);
		
		//服务 
		$condition 										= 		"";
		$condition["extension_code"] 					= 		"services_product";
		$product_and_services_product_count 		 	= 		$this->Product->findCount($condition,0);
		
		//虚拟卡 
		$condition 										= 		"";
		$condition["extension_code"] 					= 		"virtual_card";
		$product_and_virtual_card_count 		 	= 		$this->Product->findCount($condition,0);
		
		//商品推荐数 
		$condition 										= 		"";
		$condition["recommand_flag"] 					= 		"1";
		$condition["status"] 							= 		"1";
		$product_and_recommend_count 		 			= 		$this->Product->findCount($condition,0);
		
		$this->set("product_count",$product_count);//商品总数
		$this->set("product_and_product_count",$product_and_product_count);//商品
		$this->set("product_and_download_product_count",$product_and_download_product_count);//下载
		$this->set("product_and_services_product_count",$product_and_services_product_count);//服务
		$this->set("product_and_virtual_card_count",$product_and_virtual_card_count);//虚拟卡
		$this->set("product_and_recommend_count",$product_and_recommend_count);//商品推荐数
		
		///>>>>>>>>>>>>>>>>>>>>>>>>>>》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》》3右
		//库存警告商品数
		$condition 										= 		"";
		$condition["status"]  							= 		"1";
		$condition["extension_code"]  					= 		"";
		$condition["quantity <="]  						= 		"warn_quantity";
		$product_and_warn_quantity_count 		 		= 		$this->Product->findCount($condition,0);
		
		//促销商品数
		$condition 										= 		"";
		$condition["promotion_status"]  				= 		"1";
		$condition["status"]  							= 		"1";
		$product_and_forsale_count 		 				= 		$this->Product->findCount($condition,0);
		//回收站商品数
		$condition 										= 		"";
		$condition["status"]  							= 		"2";
		$product_and_trash_count 		 				= 		$this->Product->findCount($condition,0);
		
		//出售中的商品
		$condition 										= 		"";
		$condition["status"]  							= 		"1";
		$product_count_forsale 		 				= 		$this->Product->findCount($condition,0);
		
		$this->set("product_and_warn_quantity_count",$product_and_warn_quantity_count);//库存警告商品数
		$this->set("product_and_forsale_count",$product_and_forsale_count);//促销商品数
		$this->set("product_and_trash_count",$product_and_trash_count);//回收站商品数
		$this->set("product_count_forsale",$product_count_forsale);//出售中的商品


		if(@$this->configs['is_guides']==1){
			$is_guides_id=$this->Config->find(array('Config.code'=>'is_guides'),'DISTINCT Config.id');
			$this->ConfigI18n->updateAll(
			              array('ConfigI18n.value' => 0),
			              array('ConfigI18n.config_id' => $is_guides_id['Config']['id'])
			           );
			$this->redirect("/guides/");
    	}
    	
    	
    	
    		
		$this_data = date("Y-m-d",time()+24*60*60)." 23:59:59";
		$day_num = 7;
		$old_data_arr = array();
		for($i=$day_num;$i>=1;$i--){
			$old_data_arr[] = date("Y-m-d",strtotime($this_data)-24*60*60*$i);
			
		}
		
		$old_data = date("Y-m-d",time()-24*60*60*7)." 00:00:00";
		$this->Order->belongsTo=array();
		$this->Order->hasone=array();
		$this->Order->hasMany=array();
		$condition = "";
		$condition["and"]["payment_time >="] = date("Y-m-d",strtotime($this_data)-24*60*60*$day_num)." 00:00:00";
		$condition["and"]["payment_time <="] = $this_data;
		
		
		//已成交订单数payment_time
		$condition["and"]['payment_status']		= '2';
		$condition["and"]['payment_time <=']	= $this_data;
		$condition["and"]['payment_time >=']	= $old_data;
		
		$order_info = $this->Order->find("all",array("conditions"=>$condition,"group"=>"SUBSTR(Order.payment_time,1,10)","fields"=>array("count(id) as countorder","SUBSTR(Order.payment_time,1,10) as payment_time")));

		$odi = 0;
		foreach( $order_info as $k=>$v ){
			$order_data[$v[0]["payment_time"]] = $v[0]["countorder"];
			
		}
		$locale_arr[] = "AFD8F8";
		$locale_arr[] = "F6BD0F";
		$locale_arr[] = "8BBA00";
		$locale_arr[] = "FF8E46";
		$locale_arr[] = "008E8E";
		$locale_arr[] = "D64646";
		$locale_arr[] = "8E468E";
		foreach( $old_data_arr as $k=>$v ){
			$myvalue = empty($order_data[$v])?0:$order_data[$v];
			if($odi<$myvalue){
				$odi=$myvalue;
			}
		}
		if($odi > 4 ){
			$xmldata = "<graph caption='Monthly Unit Sales' xAxisName='Month' yAxisName='Units' decimalPrecision='0' formatNumberScale='0' >";
		}else{
			$xmldata = "<graph caption='Monthly Unit Sales' xAxisName='Month' yAxisName='Units' decimalPrecision='0' formatNumberScale='0' yaxismaxvalue='5'>";
		}
		
		foreach( $old_data_arr as $k=>$v ){
			$myvalue = empty($order_data[$v])?0:$order_data[$v];
			$xmldata.="<set name='".date("m-d",strtotime($v))."' value='".$myvalue."' color='".$locale_arr[$k]."' />";
		}
		$xmldata.= "</graph>";
		$fp = fopen('../sv-admin/capability/Data/Column2D.xml', 'wb+');
		fwrite($fp, $xmldata);
		
	    $this->layout = 'default';
	}
	
	function login(){
		$locales = $this->languages;
        if(isset($_SESSION['login_is_msg']) && $_SESSION['login_is_msg'] == "1"){
        }else{
        	unset($_SESSION['login_msg']);       	
		}
		$this->set('SVConfigs',$this->configs);
		unset($_SESSION['login_is_msg']);
		$this->set('locales',$locales);
		$this->pageTitle = '操作员登陆'." - ".$this->configs["shop_name"];
		$this->layout = 'page';
	}
	//执行登陆
	function act_login(){
		
		Configure::write('debug', 0);
		$result['type'] = 1;
		$error_msg = "";
		if($this->RequestHandler->isPost()){
			//setcookie('SV-Cart[admin_id]',   '', 1);
		    //setcookie('SV-Cart[admin_pass]', '', 1);
		    unset($_SESSION['Admin_Locale']);
			unset($_SESSION['Operator_Info']);
			$operator=trim($_REQUEST['operator']);
			$operator_pwd=trim($_REQUEST['operator_pwd']);
	        $authnum=trim($_REQUEST['authnum']);
	        
	        if($this->configs['admin_captcha'] == 1 &&isset($_REQUEST['authnum']) && $this->captcha->check($_REQUEST['authnum']) == false){
		    	$error_msg="验证码错误";
		    }else{
		    $operator_info = $this->Operator->findbyname($operator);
		    //print_r($operator_info);exit;
		    if(!$operator_info){
		    	$error_msg="用户不存在";
		    }else{
		    	if(MD5($operator_pwd)!=$operator_info['Operator']['password']){
		    	$error_msg="密码错误";
		    	}else{
		    		if($operator_info['Operator']['status']!=1){
		    			switch($operator_info['Operator']['status']){
		    			case 0:
					        $error_msg = "该账号处于：无效 状态";
					        break;
					    case 2:
					        $error_msg = "该账号处于：冻结 状态";
					        break;
					    case 3:
					        $error_msg = "该账号处于：注销 状态";
					        break;
		    			}
		    		}
		    		else{
		    			$_SESSION['Operator_Info'] = $operator_info;
		    			$this->set('operatorLogin',$operator_info);
		    			$operator_info['Operator']['last_login_time'] = date("Y-m-d H:i:s");
		    			$operator_info['Operator']['last_login_ip'] = $_SERVER["REMOTE_ADDR"];
		    			$this->Operator->save($operator_info);
		    			$language_info = $this->Language->findbylocale($_REQUEST['locale']);
		    			$_SESSION['Operator_Info']['Operator']['Operator_Ip'] = $_SERVER["REMOTE_ADDR"];
		    			$_SESSION['Operator_Info']['Operator']['Operator_Longin_Date'] = date("Y-m-d H:i:s");
		    			//管理员管理权限
		    			$_SESSION['Action_List']=$operator_info['Operator']['actions'];
		    			$_SESSION['Admin_Locale'] = $_REQUEST['locale'];
		    			$_SESSION['Admin_Locale_Name'] = $language_info["Language"]["name"];
		    			$result['type'] = 0;
		    			//pr($_POST['cookie']);
		    				if(isset($_POST['cookie']) && $_POST['cookie'] != ""){
		    					//	pr("sdsds");
								$this->Cookie->write('SV-Cart.admin_cookie',serialize($_SESSION['Operator_Info']),false,time()+3600 * 24 * 365); 
		    					$this->Cookie->write('SV-Cart.admin_id',$operator_info['Operator']['id'],false,time()+3600 * 24 * 365); 
		    					$this->Cookie->write('SV-Cart.admin_pass',md5($operator_info['Operator']['password']),false,time()+3600 * 24 * 365); 
		    					$this->Cookie->write('SV-Cart.locale',$_REQUEST['locale'],false,time()+3600 * 24 * 365); 
							}
							if(isset($_SESSION['login_back'])){
								$result['type'] = 5;
								$result['url'] = $this->server_host.$_SESSION['login_back'];
								unset($_SESSION['login_back']);
								//	header("Location:"."http://".$host."/".$_SESSION['cart_back_url']);
							}
							
			    		}
			    	}
			    }
			   
	        }
        //$_SESSION['login_msg'] = $msg;
        //$_SESSION['login_is_msg'] = 1;
        }
        $result['error_msg'] = $error_msg;
        //$this->set('error_msg',$error_msg);
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	//管理员退出
	function log_out()
	{
		/* 清除cookie */
		$this->Cookie->del('SV-Cart.admin_id'); 
		$this->Cookie->del('SV-Cart.admin_pass'); 
		$this->Cookie->del('SV-Cart.locale'); 	    
	    
	    unset($_SESSION['Admin_Locale']);
		unset($_SESSION['Operator_Info']);
		unset($_SESSION['Action_List']);
		unset($_SESSION['Admin_Config']);
		$this->locale = "";		
		$this->redirect("/");

	}
	// 第一次登出 cookie未能及时删除。。。 删第2次
	function admin_log_out(){
		setcookie('SV-Cart[admin_id]',   '', time()-1);
	    setcookie('SV-Cart[admin_pass]', '', time()-1);
	    setcookie('SV-Cart[locale]', '', time()-1);
	    unset($_SESSION['Admin_Locale']);
		unset($_SESSION['Operator_Info']);
		unset($_SESSION['Action_List']);
		unset($_SESSION['Admin_Config']);
		$this->locale = "";	
		$this->redirect("/login");

	}	
	
	//管理员忘记密码
	function send_email(){
		Configure::write('debug', 0);
		$result['type'] = 2;
		if($this->RequestHandler->isPost()){
			$conditions = "";
			$name = trim($_REQUEST['name']);
			$email = trim($_REQUEST['email']);
			$conditions = "  Operator.name = '$name' and Operator.email = '$email'";
			$operator = $this->Operator->find($conditions,"");
			if(is_array($operator) && count($operator)>0 && $name != "" && $email != ""){
				  $this->Config->set_locale($this->locale);
				  $configs = $this->Config->getformatcode();
				  $send_date=date('Y-m-d');
	              $user_name = $operator['Operator']['name'];
	              $shop_name = $configs['shop_name'];
	              $user_password = $operator['Operator']['password'];
	              $this->MailTemplate->set_locale($this->locale);
	  	          $template=$this->MailTemplate->find("code = 'send_password' and status = '1'");
	  	          $template_str=$template['MailTemplateI18n']['html_body'];
	  	          //生成连接code  id+原密码 md5 加密
	  	          $code = md5($operator['Operator']['id'] . $operator['Operator']['password']);
	  	          $reset_email = $this->server_host.$this->admin_webroot."pages/change_password/".$operator['Operator']['id']."/".$code."/";
				  /* 商店网址 */
				  $shop_url = $this->server_host.$this->cart_webroot;
	              eval("\$template_str = \"$template_str\";");
	              //$template_str=str_replace(" ","",$template_str);
				  $to_email = $operator['Operator']['email'];
				  $this->set_email_config($configs);
				  $this->Email->sendAs = 'html';
				  $this->Email->is_ssl = $this->configs['smtp_ssl'];
				  $this->Email->is_mail_smtp=$this->configs['mail_service'];

				  $this->Email->smtp_port = $this->configs['smtp_port'];

				  $this->Email->fromName = "".$shop_name.""; 
				  $this->Email->html_body = "".$template_str."";
		          $text_body = $template['MailTemplateI18n']['text_body'];
		     	  eval("\$text_body = \"$text_body\";");
		  	      $this->Email->text_body = $text_body;
				  $this->Email->to = "".$to_email."";
				  $subject = $template['MailTemplateI18n']['title'];
				  eval("\$subject = \"$subject\";");
				  $this->Email->subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
				  //

				  //
				  //$this->Email->send()
				  if($this->Email->send()){
			      $result['type'] = 0;
			      }else{
			      $result['type'] = 1;
			      }
			}else{
				$result['type'] = 1;
			}
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	function set_email_config($configs){
		$this->Email->smtpHostNames = "".$configs['smtp_host']."";
		$this->Email->smtpUserName = "".$configs['smtp_user']."";
		$this->Email->smtpPassword = "".$configs['smtp_pass']."";
		$this->Email->from = "".$configs['smtp_user']."";
	}

	function forget_password(){
		Configure::write('debug', 0);
		$result['type'] = 2;
		if($this->RequestHandler->isPost()){
		$result['type'] = 0;
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function change_password($id,$code){
		Configure::write('debug', 0);
		$operator = $this->Operator->findbyid($id);
		$code_v = md5($operator['Operator']['id'].$operator['Operator']['password']);
		if($code <> $code_v){
			$_SESSION['login_msg'] = "无效路径";
			$_SESSION['login_is_msg'] = 1;
			$this->redirect("/login");
		}else{	
			$this->set('operator',$operator);
			$this->pageTitle = '修改密码'." - ".$this->configs['shop_name'];
			$this->layout = 'page';
		}
	}
	
		
	function update_password(){
		Configure::write('debug', 0);
		$result['type'] = 1;
		$result['msg'] = "修改失败";
		if($this->RequestHandler->isPost()){
			$operator = $this->Operator->findbyid($_REQUEST['id']);
			$operator['Operator']['password'] = md5($_REQUEST['pwd']);
			$this->Operator->save($operator);
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'修改操作员密码' ,'operation');
    	    }
			$result['type'] = 0;
			$result['msg'] = "修改成功";
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function rss_str(){
		$rssfeed = array("http://www.seevia.cn/articles/rss/46");
		for($i=0;$i<sizeof($rssfeed);$i++ ){//分解开始
			$buff = "";
			$rss_str="";
			//打开rss地址，并读取，读取失败则中止
			if(!@get_headers($rssfeed[$i])){
				return array();
			}
			$fp = fopen($rssfeed[$i],"r") or die("can not open $rssfeed");
			while ( !feof($fp) ) {
				$buff .= fgets($fp,4096);
			}
			//关闭文件打开
			fclose($fp);

			//建立一个 XML 解析器
			$parser = xml_parser_create();
			//xml_parser_set_option -- 为指定 XML 解析进行选项设置
			xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
			//xml_parse_into_struct -- 将 XML 数据解析到数组$values中
			xml_parse_into_struct($parser,$buff,$values,$idx);
			//xml_parser_free -- 释放指定的 XML 解析器
			xml_parser_free($parser);
			
			foreach ($values as $val) {
				$tag = @$val["tag"];
				$type = @$val["type"];
				$value = @$val["value"];
				//标签统一转为小写
				$tag = strtolower($tag);
				
				if ($tag == "item" && $type == "open"){
					$is_item = 1;
				}else if ($tag == "item" && $type == "close") {
					//构造输出字符串
					$rss_str[]= "<a href='".$link."' target=_blank >".date("Y-m-d",strtotime($pubdate))." ".$title." </a><br />";
					$is_item = 0;
				}
				//仅读取item标签中的内容
				if(@$is_item==1){
					if ($tag == "title") {$title = $value;}
					if ($tag == "link") {$link = $value;}
					if ($tag == "pubdate") {$pubdate = $value;}
				}
			}
		}
		//pr($rss_str);
		Configure::write('debug', 0);
		die(json_encode($rss_str));
	}
	//官网文章推荐列表
	function rss_recommend_article(){
		$this->layout = "ajax";
		$article_list = array();
		$rssfeed = array("http://www.seevia.cn/articles/recommend_rss/14");
		for($i=0;$i<sizeof($rssfeed);$i++ ){//分解开始
			$buff = "";
			$rss_str="";
			//打开rss地址，并读取，读取失败则中止
			if(!@get_headers($rssfeed[$i])){
				return array();
			}
			$fp = fopen($rssfeed[$i],"r") or die("can not open $rssfeed");
			while ( !feof($fp) ) {
				$buff .= fgets($fp,4096);
			}
			//关闭文件打开
			fclose($fp);

			//建立一个 XML 解析器
			$parser = xml_parser_create();
			//xml_parser_set_option -- 为指定 XML 解析进行选项设置
			xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
			//xml_parse_into_struct -- 将 XML 数据解析到数组$values中
			xml_parse_into_struct($parser,$buff,$values,$idx);
			//xml_parser_free -- 释放指定的 XML 解析器
			xml_parser_free($parser);
			
			foreach ($values as $val) {
				$tag = @$val["tag"];
				$type = @$val["type"];
				$value = @$val["value"];
				//标签统一转为小写
				$tag = strtolower($tag);
				
				if ($tag == "item" && $type == "open"){
					$is_item = 1;
				}else if ($tag == "item" && $type == "close") {
					
					$article_list[]= array("href"=>$link,"date"=>date("Y-m-d",strtotime($pubdate)),"title"=>$title);
					$is_item = 0;
				}
				//仅读取item标签中的内容
				if(@$is_item==1){
					if ($tag == "title") {$title = $value;}
					if ($tag == "link") {$link = $value;}
					if ($tag == "pubdate") {$pubdate = $value;}
				}
			}
		}
		//pr($article_list);
		
		$this->set("article_list",$article_list);
		Configure::write('debug', 0);
	}
	    //后台分页数Cookie记录
    function pagers_num($number){
    	$this->Cookie->write('pagers_num_cookies',$number);
    	Configure::write('debug', 0);
		die();
    }
    /* 清除缓存 */
    function clear_cache(){
    	Configure::write('debug',0);
    	//$result['count'] = $this->clear_cache_files();
    	$dir_names = explode(',', $_POST['dir_name']);
    	echo $this->clear_cache_files($dir_names);
    	die();
    }

	/* 清除缓存文件 */
	function clear_cache_files($dirs)
	{

		$cache_dirs = $this->get_cache_dirs($dirs);
	    $count   = 0;
	    foreach ($cache_dirs AS $dir)
	    {
	        $folder = @opendir($dir);
	        if ($folder === false)
	        {
	            continue;
	        }
	        while ($file = readdir($folder))
	        {
	            if ($file == '.' || $file == '..' || $file == '.svn' || $file == 'empty')
	            {
	                continue;
	            }
	            if (is_file($dir . $file))
	            {
	            	//echo $dir . $file.'<br>';
                    if (@unlink($dir . $file))
                    {
                        $count++;
                    }
	            }
	        }
	        closedir($folder);
	    }

	    return $count;
	}
	/* 获取缓存文件夹 */
	function get_cache_dirs($dirs){
		if(is_array($dirs)){
			$cache_dirs = array();
			foreach($dirs as $dir){
				if(is_dir(ROOT . $dir) && is_dir(ROOT . $dir .'/tmp/cache')){
					$cache_dirs[] = ROOT . $dir .'/tmp/cache/';
					$cache_dirs[] = ROOT . $dir .'/tmp/cache/models/';
					$cache_dirs[] = ROOT . $dir .'/tmp/cache/persistent/';
					$cache_dirs[] = ROOT . $dir .'/tmp/cache/views/';
				}
			}
			return $cache_dirs;
		}
	}
	/* 获取所有缓存文件夹 */
	function get_all_cache_dirs(){
		$cache_dirs = array();
		$folder = opendir(ROOT);
		while($file = readdir($folder)){
			if($file == '.' || $file == '..' || $file == 'cake' || $file == '.svn')
				continue;
			if(is_dir(ROOT . $file) && is_dir(ROOT . $file .'/tmp/cache')){
				$cache_dirs[] = ROOT . $dir .'/tmp/cache/';
				$cache_dirs[] = ROOT . $file .'/tmp/cache/models/';
				$cache_dirs[] = ROOT . $file .'/tmp/cache/persistent/';
				$cache_dirs[] = ROOT . $file .'/tmp/cache/views/';
			}
		}
		closedir($folder);
		return $cache_dirs;
	}
    
    
    
    //google翻译快捷窗口
   	function g_translate($lang_value,$original_text,$i){
   		Configure::write('debug',0);
		$sl = "zh-CN";
	//	$original_text = urlencode($original_text);
		$url = "http://translate.google.cn/translate_a/t?client=t&ie=utf8"."&sl=".$sl."&tl=".$lang_value."&text=".$original_text;
		$req_value = $this->translates($url);
		$result = array();
		if($req_value[0] !="\""){
			$result['value'] = $req_value;
		}else{
			$n = strlen($req_value);
			$result['value'] = substr($req_value,1,$n-2);
		}
		$result['type'] = $i;
		echo $result['value']."|".$i;
		die();
	//	$this->set('result',$result['value']);
	//	$this->layout = 'ajax';
	
	}
	
	function translates($url){

		$handle = file_get_contents($url);

		$handle = mb_convert_encoding($handle, 'UTF-8', 'GBK');
		if(preg_match("/.*(\[).*/",$handle))
		{
			$r= json_decode($handle);
			$value=$r[0];
		}else
		{
			$value = $handle;
			$desc = "";
		}
		$result[0] = $value;

		return $value;
	}
   
}
?>