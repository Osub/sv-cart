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
 * $Id: pages_controller.php 1273 2009-05-08 16:49:08Z huangbo $
*****************************************************************************/
class PagesController extends AppController {
	var $name = 'Pages';
	var $helpers = array('Html','Javascript');
	var $uses = array('ConfigI18n','Article','Operator','Operator_action','Operator_menu','Order','BookingProduct','Product','MailTemplate','Operator_log','Config');
	var $components = array('Captcha','Email','RequestHandler','Cookie');
		
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
		
		$this->Product->hasOne = array();
		//pr($_COOKIE);
		$this->Config->set_locale($this->locale);
		$shop_name = $this->Config->findbycode("shop_name");
		$this->locale = $_SESSION['Admin_Locale'];
		$this->pageTitle = "管理中心"." - ".$shop_name['ConfigI18n']['value'];
		//print_r($_SESSION);
		$this->navigations[] = array('name'=>'管理中心','url'=>'/pages/home/');
		$this->set('navigations',$this->navigations);
		
		//待发货订单
		$condition 						= 		"";
		$condition['status']			=		1;
		$condition['shipping_status']	=		3;
		$wait_shipments_order_count  	= 		$this->Order->findCount($condition,0);

		//等待支付订单
		$condition 						= 		"";
		$condition['payment_status !=']	=		2;
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
		$condition['shipping_status']	=		1;
		$order_complete_count 			= 		$this->Order->findCount($condition,0);
		$this->set("wait_shipments_order_count",$wait_shipments_order_count );//待发货订单
		$this->set("wait_pay_order_count",$wait_pay_order_count );//待发货订单
		$this->set("order_oos_count",$order_oos_count );//订单缺货登记
		$this->set("not_confirm_order_count",$not_confirm_order_count );//未确认订单
		$this->set("order_complete_count",$order_complete_count );//已成交订单数
			
			
			
		//商品总数
		$condition 										= 		"";
		$product_count 									= 		$this->Product->findCount($condition,0);
		//商品推荐数
		$condition 										= 		"";
		$condition['Product.recommand_flag =']			=		"1";
		$condition['Product.status']					=		"1";
		$product_recommend_count 						= 		$this->Product->findCount($condition,0);
		//库存警告商品数
		$condition 										= 		"";
		$condition['Product.quantity <=']				=		"3";
		$product_quantity_count 						= 		$this->Product->findCount($condition,0);
		//促销商品数
		$condition 										= 		"";
		$condition['Product.status']					=		"1";
		$condition['Product.promotion_status !=']		=		"0";
		$product_promotion_count 						= 		$this->Product->findCount($condition,0);
		
		$this->set("product_count",$product_count );//商品总数
		$this->set("product_recommend_count",$product_recommend_count );//商品推荐数
		$this->set("product_quantity_count",$product_quantity_count );//库存警告商品数
		$this->set("product_promotion_count",$product_promotion_count );//促销商品数
			
			
		//文章列表 
		$this->Article->set_locale($this->locale);
		$condition_article['title !='] = "";
		$article = $this->Article->findAll($condition_article,'',"Article.modified desc",'8');
		$this->Config->set_locale($_SESSION['Admin_Locale']);
		$ss = $this->Config->getformatcode();
	
		if(@$ss['is_guides']==1){
			$is_guides_id=$this->Config->find(array('Config.code'=>'is_guides'),'DISTINCT Config.id');
			$this->ConfigI18n->updateAll(
			              array('ConfigI18n.value' => 0),
			              array('ConfigI18n.config_id' => $is_guides_id['Config']['id'])
			           );
			$this->redirect("/guides/");
    	}
    
		$this->set("article",$article );//文章列表
		$this->set("rss_str",$this->rss_str() );
	    $this->layout = 'default';
	}
	
	function login(){
		$locales = $this->Language->findall("backend = 1");
        if(isset($_SESSION['login_is_msg']) && $_SESSION['login_is_msg'] == "1"){
        }else{
        	unset($_SESSION['login_msg']);       	
		}
		$this->Config->set_locale($this->locale);
		$shop_name = $this->Config->findbycode("shop_name");
		//pr($shop_name);
		//print($this->configs['shop_name']."111");
		unset($_SESSION['login_is_msg']);
		$this->set('locales',$locales);
		$this->pageTitle = '操作员登陆'." - ".$shop_name['ConfigI18n']['value'];
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
	        if(isset($_REQUEST['authnum']) && $this->captcha->check($_REQUEST['authnum']) == false){
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
		    			$_SESSION['Operator_Info']['Operator']['Operator_Ip'] = $_SERVER["REMOTE_ADDR"];
		    			$_SESSION['Operator_Info']['Operator']['Operator_Longin_Date'] = date("Y-m-d H:i:s");
		    			//管理员管理权限
		    			$_SESSION['Action_List']=$operator_info['Operator']['actions'];
		    			$_SESSION['Admin_Locale'] = $_REQUEST['locale'];
		    			//pr($_POST['cookie']);
		    				if(isset($_POST['cookie']) && $_POST['cookie'] != ""){
		    					//	pr("sdsds");
		    					$this->Cookie->write('SV-Cart.admin_id',$operator_info['Operator']['id'],false,time()+3600 * 24 * 365); 
		    					$this->Cookie->write('SV-Cart.admin_pass',md5($operator_info['Operator']['password']),false,time()+3600 * 24 * 365); 
		    					$this->Cookie->write('SV-Cart.locale',$_REQUEST['locale'],false,time()+3600 * 24 * 365); 
						
							}
							$result['type'] = 0;

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
			$conditions = "1=1";
			$name = trim($_REQUEST['name']);
			$email = trim($_REQUEST['email']);
			$conditions .= " and Operator.name = '$name' and Operator.email = '$email'";
			$operator = $this->Operator->find($conditions,"");
			if(is_array($operator) && count($operator)>0 && $name != "" && $email != ""){	 	 
				  $this->Config->set_locale($this->locale);
				  $configs = $this->Config->getformatcode();
				  $send_date=date('Y-m-d');
	              $user_name = $operator['Operator']['name'];
	              $shop_name = $configs['shop_name'];
	              $user_password = $operator['Operator']['password'];
	              $this->MailTemplate->set_locale($this->locale);
	  	          $template=$this->MailTemplate->find("code = 'send_password' and status = 1");
	  	          $template_str=$template['MailTemplateI18n']['html_body'];
	  	          $host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
	  	          //生成连接code  id+原密码 md5 加密
	  	          $code = md5($operator['Operator']['id'] . $operator['Operator']['password']);
	  	          $reset_email = "http://".$host.$this->webroot."pages/change_password/".$operator['Operator']['id']."/".$code."/";
				  /* 商店网址 */
				  $host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
				  $webroot = str_replace("/".WEBROOT_DIR."/","",$this->webroot);
				  $shop_url = "http://".$host.$webroot;
	              eval("\$template_str = \"$template_str\";");
	              //$template_str=str_replace(" ","",$template_str);
				  $to_email = $operator['Operator']['email'];
				  $this->set_email_config($configs);
				  $this->Email->sendAs = 'html';
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
					$rss_str[]= "<a href='".$link."' target=_blank style='color:#337E4B'>".date("Y-m-d",strtotime($pubdate))." ".$title." </a><br />";
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
		return $rss_str;
	}
}
?>