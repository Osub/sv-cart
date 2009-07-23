<?php
/*****************************************************************************
 * SV-Cart 用户中心首页
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: pages_controller.php 3151 2009-07-21 08:46:39Z huangbo $
*****************************************************************************/
uses('sanitize');
class PagesController extends AppController {
	var $name = 'Pages';
	var $helpers = array('Html','Javascript');
	var $uses = array("SystemResource","Plugin","Order","User","Config","ConfigI18n","UserInfo","UserRank","MailTemplate","ProductRank","UserAddress","UserInfoValue","UserPointLog","UserFavorite","CouponType","Coupon","Article","Product","Cart");//,"UserRank"
	var $components = array('RequestHandler','Captcha','Email');
	var $cacheQueries = true;
	var $cacheAction = "1 day";
	
	function display() {
		$this->layout = 'default_full';
	}
	
	function home(){
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(true,$this->locale);
  	    if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
				$this->redirect('/login/');
		     }
		    $this->page_init();
		    //当前位置
		    $this->navigations[] = array('name'=>$this->languages['user_center'],'url'=>"");
		    $this->set('locations',$this->navigations);
		    $user_info=$this->User->findbyid($_SESSION['User']['User']['id']);
		    $coupons = $this->Coupon->findallbyuser_id($_SESSION['User']['User']['id']);
		    $this->CouponType->set_locale($this->locale);
		    $coupon_num = 0;
		    $coupon_fee = 0;
			$cache_key = md5('find_coupon_types'.'_'.$this->locale);
			$coupon_types = cache::read($cache_key);	
			if(!$coupon_types){	
				$coupon_type_arr = $this->CouponType->findall();
				$coupon_types = array();
				if(is_array($coupon_type_arr) && sizeof($coupon_type_arr)>0){
					foreach($coupon_type_arr as $k=>$v){
						$coupon_types[$v['CouponType']['id']] = $v;
					}
				}
				
				cache::write($cache_key,$coupon_types);	
			}
		    if(is_array($coupons) && sizeof($coupons)>0){
		    	foreach($coupons as $k=>$coupon){
		    		$coupon_num ++;
		    		//$coupon_type = $this->CouponType->findbyid($coupon['Coupon']['coupon_type_id']);
		    		if(isset($coupon_types[$coupon['Coupon']['coupon_type_id']])){
		    			$coupon_type = $coupon_types[$coupon['Coupon']['coupon_type_id']];
		    			$coupon_fee += $coupon_type['CouponType']['money'];
		    		}
		    	}
		    }
		    $this->set('coupon_num',$coupon_num);
		    $this->set('coupon_fee',$coupon_fee);
		 //   echo $user_info['User']['rank'];
		    //取得用户等级
		    if($user_info['User']['rank'] == 0){
 	 	         $user_rank= $this->languages['normal'].$this->languages['user'];
 	         }
 	         else{
 	         	// $user_rank=$this->requestAction("/commons/get_rank/".$user_info['User']['rank']."");
 	         	$user_rank = $this->UserRank->get_rank($user_info['User']['rank'],$this->locale);
 	         }
 	         
	        //pr($user_rank);
		    $this->set("user_info",$user_info);
			//规定时间内提交的订单
			$start_time=date("Y-m-d").' 23:59:59';
			$middle_time=(strtotime($start_time))-(30*24*60*60);
			$end_time=date("Y-m-d",$middle_time).' 00:00:00';
			
			$my_orders30=$this->Order->time_orders($start_time,$end_time);
			$this->set("my_orders30",$my_orders30);
			$this->pageTitle = $this->languages['user_center']." - ".$this->configs['shop_title'];
			$this->set("user_rank",$user_rank);
			
	}
	
	function login(){
	//			pr($_SESSION['securimage_code_value']);
				$this->navigations[] = array('name'=>$this->languages['home'],'url'=>$this->server_host.$this->cart_webroot );
				$this->navigations[] = array('name'=>$this->languages['user'].$this->languages['login'],'url'=>$this->server_host.$this->user_webroot."login");
				$this->set('locations',$this->navigations);
				$mrClean = new Sanitize();		
			    $this->page_init();
		        if($this->RequestHandler->isPost()){
		        //	pr($_POST);exit;
					 $flash_url = $this->server_host.$this->user_webroot;			   	   
		        	 $no_error = 1;
					 if(!isset($_POST['is_ajax'])){
						$_POST['captcha'] = isset($_POST['data']['User']['captcha'])?$_POST['data']['User']['captcha']:'';
						$_POST['name'] = $mrClean->html(isset($_POST['data']['User']['name'])?$_POST['data']['User']['name']:'',true);
						$_POST['password'] = $mrClean->html(isset($_POST['data']['User']['password'])?$_POST['data']['User']['password']:'',true);
					 	$result['message'] = $this->languages['login'].$this->languages['successfully'];
					 }
		        	  unset($_SESSION['User']);
				      Configure::write('debug', 0);
				      //type定义 0:没有错误 1:报错 2:其他
				      $result['type'] = 2;
						$_POST['captcha'] = $mrClean->html($_POST['captcha'],true);
						$_POST['name'] = $mrClean->html($_POST['name'],true);
						$_POST['password'] = $mrClean->html($_POST['password'],true);
						//leo20090610ucenter
						$plugin = $this->Plugin->find(array("code"=>"ucenter"));
						if( !empty($plugin)&&isset($this->configs['integrate_code'])&&$this->configs['integrate_code']=="ucenter" ){
						 	  $uid = $this->user_exist($_POST['name'],$_POST['password']);
						 	  $this->set("uid",$uid);
						}
						//
					if($this->configs['use_captcha'] == 1){
				      if(isset($_POST['captcha']) && $this->captcha->check($_POST['captcha']) == false){
				      	  	 $no_error = 0;
					         $result['type'] ="1";
					         $result['message'] ="".$this->languages['verify_code'].$this->languages['not_correct']."";
					         if(!isset($_POST['is_ajax'])){
								$this->pageTitle = "".$this->languages['verify_code'].$this->languages['not_correct']."";
							    $this->flash($this->languages['verify_code'].$this->languages['not_correct'],$flash_url,'');
					         }
							 if(isset($_POST['is_ajax'])){
					         die(json_encode($result));
					         }
				       }
			 	    }
				       if( !(isset($_POST['name']) && $_POST['name']!="")  || !(isset($_POST['password'])&& $_POST['password']!="")){
					          $no_error = 0;
					          $result['type'] ="1";
					          $result['message'] ="".$this->languages['please_enter'].$this->languages['username'].$this->languages['and'].$this->languages['password']."";
							 if(isset($_POST['is_ajax'])){
					          die(json_encode($result));
					         }
				        }
						
				       $condition = " User.name = '".$_POST['name']."' and User.password = '".md5($_POST['password'])."'";
				       $user_info = $this->User->find($condition);
				
				       if(!isset($user_info['User']['id'])){
				       	   	 $no_error = 0;
					         $result['type'] ="1";
					         $result['message'] ="".$this->languages['incorrect_username_or_password']."";
							 if(isset($_POST['is_ajax'])){
					      	   die(json_encode($result));
					         }
				        }
				        if($user_info['User']['status']!=1){
				        	$no_error = 0;
					         $result['type'] ="1";
					         $result['message'] = $this->languages['user'].$this->languages['status'].$this->languages['invalid'].":".$user_info['User']['status'];
							 if(isset($_POST['is_ajax'])){
					     	    die(json_encode($result));
					         }
				        }elseif($no_error){
					         $result['type'] = 0;
					         $_SESSION['User']=$user_info;
					         $this->set("result",$result);
					         $this->User->updateAll(array('User.last_login_time' => "'".date("Y-m-d H:i:s")."'"),
												    array('User.id' => $user_info['User']['id'] )
													);

					         $this->set("user_info",$user_info);
					         //添加会员折扣
					         if(isset($user_info['User']['rank'])){
						            $rank = $this->UserRank->findbyid($user_info['User']['rank']);
						            $_SESSION['User']['User']['rank_discount'] = $rank['UserRank']['discount'];
						            $_SESSION['User']['User']['user_rank'] = $this->UserRank->get_rank($user_info['User']['rank'],$this->locale);
					          }
					          //登录后查看是否有购买商品 使用积分
					        $this->check_point();
					    	$this->layout = "ajax";
						if(isset($_POST['is_ajax'])){
						    if($this->configs['user_login_msg'] == 0){
						        $result['type'] = "9";
						   	 	die(json_encode($result));
						    }
						    if(isset($_POST['is_ajax']) && $_POST['is_ajax']==1){
							       $this->render('/pages/login_ajax_successful');
						    }else{
							if(isset($_SESSION['back_url'])){
								$this->set("back_url",$_SESSION['back_url']);
								unset($_SESSION['back_url']);
							}
								$this->render('/pages/user_login');
						    }
					    }
				    }
				   if(!isset($_POST['is_ajax'])){
						$this->pageTitle = $result['message'];
					    $this->flash($result['message'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'','');
					}				    
				    
				if(isset($_POST['is_ajax'])){
				    if($result['type'] != 0){
					    die(json_encode($result));
				     }
				}
		     }else if(isset($_SESSION['User']['User'])){
				header("Location:".$this->webroot);
		    }else{
			      $this->page_init();
			      $this->pageTitle = $this->languages['login']." - ".$this->configs['shop_title'];
			      $this->layout = 'default_full';
		    }
		 
		
	}

	function logout(){
		unset($_SESSION['User']);
		$this->layout = "ajax";
		if(!isset($_POST['is_ajax'])){
		      $this->page_init();
		      $this->pageTitle = $this->languages['have_been_logout'];
			  $flash_url = $this->server_host.$this->user_webroot;			   	   
			  $this->flash($this->languages['have_been_logout'],$flash_url,10);	
		}else{
			$this->render('/pages/logout_ajax_successful');
		}
	}

	function register(){
		$this->navigations[] = array('name'=>$this->languages['home'],'url'=>$this->server_host.$this->cart_webroot );
		$this->navigations[] = array('name'=>$this->languages['user'].$this->languages['register'],'url'=>$this->server_host.$this->user_webroot."register");
		$this->set('locations',$this->navigations);
		
	    $flash_url = $this->server_host.$this->user_webroot;			
		if(isset($_SESSION['User']['User'])){
			//pr($this->webroot);
			header("Location:".$this->webroot);
		}
		$js_languages = array("name_can_not_be_blank" => $this->languages['name'].$this->languages['can_not_empty'],
 	 						"password_can_not_be_blank" => $this->languages['password'].$this->languages['can_not_empty'],
 	 						"retype_password_not_blank" => $this->languages['password'].$this->languages['affirm'].$this->languages['can_not_empty'],
 	 						"password_length_short" => $this->languages['password_length_short'],
 	 						"Passwords_are_not_consistent" => $this->languages['Passwords_are_not_consistent'],
 	 						"incorrect_email_format" => $this->languages['email'].$this->languages['format'].$this->languages['not_correct'],
 	 						"choose_security_answer" => $this->languages['please_choose'].$this->languages['security_question'],
 	 						"fill_security_question" => $this->languages['please_enter'].$this->languages['security_question'],
 	 						"fill_answer" => $this->languages['please_enter'].$this->languages['answer'],
 	 						"others" => $this->languages['others'],
 	 						"can_be_registered" => $this->languages['can_be_registered'],
 	 						"email_not_empity" => $this->languages['email'].$this->languages['can_not_empty'],
 	 						"length_of_cell_phone_not_correct" => $this->languages['mobile'].$this->languages['not_correct'],
 	 						"length_of_tel_not_correct" => $this->languages['telephone'].$this->languages['not_correct']
 	 						);
		$this->set('js_languages',$js_languages);
		$this->Article->set_locale($this->locale);
		$article = $this->Article->findbyid('5');
		$this->set('article',$article);
		//判断注册是否被关闭
		if(isset($this->configs['enable_registration_closed']) && $this->configs['enable_registration_closed'] == 0){
			   $this->page_init();
               //密码保护问题
               $register_question=$this->Config->findAll("Config.code = 'register_question'");
               foreach($register_question as $k=>$v){
               	     $value=explode(';',$v['ConfigI18n']['value']);
               	     $options=explode("\n",$v['ConfigI18n']['options']);
               	     foreach($options as $option){
               	     	   $options_value=explode(":",$option);
               	     	   if(in_array($options_value[0],$value)){
               	     	   	       $register_question[$k]['Config']['options_value'][]=$options_value[1];
               	     	   }
               	     	  // pr($options_value);
               	     }
               }
               //pr($register_question);
               //可选信息内容
               //用户项目信息
               $this->UserInfo->set_locale($this->locale);
		       $user_infoarr=$this->UserInfo->findinfoassoc($values_id = '');
		       // pr($user_infoarr);
	           $this->pageTitle = $this->languages['user'].$this->languages['register']." - ".$this->configs['shop_title'];
		       $this->set('user_infoarr', $user_infoarr);
               $this->set('register_question', $register_question);
		       $this->layout = 'default_full';
		}
		else{
			$this->pageTitle = $this->languages['register_functions_closed']." - ".$this->configs['shop_title'];
			    $this->flash($this->languages['register_functions_closed'],$flash_url,'');
		}
	}
/*	function newcomer() {
			$this->layout = 'default_full';
	}
*/
	 function captcha(){
	 	 $this->layout = 'blank'; //a blank layout 
	     $this->set('captcha_data', $this->captcha->show()); //dynamically creates an image 
	     exit();
	 }
	 //忘记密码页面
	 function forget_password(){
	 	 $this->page_init();
	 	 
	 	 $js_languages = array("enter_registration_username" => $this->languages['please_enter'].$this->languages['username'],
	 	 						"enter_answer_to_security_questions" => $this->languages['please_enter'].$this->languages['security_answer']);   //答案
		 $this->set('js_languages',$js_languages);
	 	 
	 	 $this->pageTitle = $this->languages['retrieve_password']." - ".$this->configs['shop_title'];
	 	 $this->layout = 'default_full';
	 }
 	 //忘记密码用户名确认
     function need_user_question($need_name=''){
     	 if($need_name == ''){
     	 	$is_ajax = 0;
     	 	$need_name = $_POST['UNickNme'];
     	 }else{
     	 	$is_ajax = 1;
     	 }
		   $mrClean = new Sanitize();		
	       $need_name = $mrClean->html($need_name,true);
     	   $condition = " User.name = '".$need_name."'";
		   $need_user_info = $this->User->find($condition);
		   if(isset($need_user_info['User']['id']) && !empty($need_user_info['User']['id'])){
		   	      $err=0;
		   	      $err_msg='';
		   	      $question=$need_user_info['User']['question'];
		   	      $old_answer=$need_user_info['User']['answer'];
		   	      $user_id=$need_user_info['User']['id'];
		   }
		   else{
		   	    $err=1;
		   	    $err_msg=$this->languages['username'].$this->languages['not_exist'];
		   	    $question='';
		   	    $old_answer='';
		   	    $user_id='';
		   }
		   $this->set("question",$question);
		   $this->set("user_id",$user_id);
		   $this->set("old_answer",$old_answer);
		   $this->set("err_msg",$err_msg);
		   $this->set('err',$err);
		   if($is_ajax == 0){
		   		if($err == 0){
					$this->pageTitle = $this->languages['retrieve_password']." - ".$this->configs['shop_title'];
					$this->page_init();
		   			
		   			$this->layout = "default_full";
		   		}else{
					$this->pageTitle = $this->languages['user'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
					$this->page_init();
		   			$this->flash($this->languages['user'].$this->languages['not_exist'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'','');
		   		}
		   }else{
		   		$this->layout = "ajax";
		   }
     } 
     
 	     //发送修改密码邮件

     function send_editpsw_email(){     	 
		if($this->RequestHandler->isPost()){
		//		if(isset($this->configs['use_ajax']) && $this->configs['use_ajax'] == 0){
		//			$user_info=$this->User->findById($_POST['user_id']);
		//			$answer = $_POST['answer'];
		//			$old_answer = $_POST['old_answer'];
		//		}else{
					$user_info=$this->User->findById($this->params['form']['user_id']);
					$answer = $this->params['form']['answer'];
					$old_answer = $this->params['form']['old_answer'];
		//		}
				if($answer != $old_answer){
				$this->pageTitle = $this->languages['security_answer'].$this->languages['not_correct']." - ".$this->configs['shop_title'];
				//security_answer not_correct
					$this->flash($this->languages['security_answer'].$this->languages['not_correct'],'/forget_password','');
				}else{
					  $send_date=date('Y-m-d');
		              $user_name = $user_info['User']['name'];
		              $shop_name = $this->configs['shop_name'];
		              $user_password = $user_info['User']['password'];
		              $this->MailTemplate->set_locale($this->locale);
		  	          $template=$this->MailTemplate->find("code = 'send_password' and status = 1");
		  	          $template_str=$template['MailTemplateI18n']['html_body'];
		  	          //生成连接code  id+原密码 md5 加密
		  	          $code = md5($user_info['User']['id'] . $user_info['User']['password']);
		  	          $reset_email = $this->server_host.$this->user_webroot."edit_password/".$user_info['User']['id']."/".$code."/";
					  /* 商店网址 */
					  $shop_url = $this->server_host.$this->cart_webroot;
		              eval("\$template_str = \"$template_str\";");
		              //$template_str=str_replace(" ","",$template_str);
					  $to_email = $user_info['User']['email'];
					  $this->set_email_config();
						$this->Email->is_ssl = $this->configs['smtp_ssl'];
		$this->Email->is_mail_smtp = $this->configs['mail_service'];
						$this->Email->smtp_port = $this->configs['smtp_port'];			
						 $this->Email->fromName = "".$shop_name."";  //标题
					  $this->Email->html_body = "".$template_str."";
				      $text_body = $template['MailTemplateI18n']['text_body'];
				      eval("\$text_body = \"$text_body\";");
				  	  $this->Email->text_body = $text_body;
					  $this->Email->to = "".$to_email."";
					  //pr($template_str);
					  $subject = $template['MailTemplateI18n']['title'];
					  eval("\$subject = \"$subject\";");
					  $this->Email->subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
			          if(@$this->Email->send()){
							$this->pageTitle = $this->languages['reset_password_sent_please_view']." - ".$this->configs['shop_title'];
			          		$this->flash($this->languages['reset_password_sent_please_view'],'/','');
			          }else{
			          	  //send_mail failed
							$this->pageTitle = $this->languages['send_mail'].$this->languages['failed']." - ".$this->configs['shop_title'];
			          		$this->flash($this->languages['send_mail'].$this->languages['failed'],'/','');
			          }
	   			}
   			}
     	}
     	
	     	 	//用户确认认证
	 	function verifyemail($user_id,$code){
	 		 $this->page_init();
	 		 $this->pageTitle = $this->languages['send_confirm_mail']." - ".$this->configs['shop_title'];
	 		 $user_info=$this->User->findbyid($user_id);
	 	     $code_confirm = md5($user_info['User']['id'] . $user_info['User']['email']);
	 	     $back_url = $this->server_host.$this->user_webroot;
	 	     //invalid
	 	     if($code <> $code_confirm){
	 	     	 	$this->set('back_url',$back_url);
					$this->flash($this->languages['invalid_url'],'/','');
	 	     }
	 		   if(!empty($user_info)){
	 		   	   if($user_info['User']['verify_status'] != 1){
	 		   	     	   $this->User->updateAll(
				               array('User.verify_status' => 1),
				               array('User.id' => $user_id)
				           );
	 	     	 	 $this->set('back_url',$back_url);
	 		   	     $this->flash($this->languages['has_been_verified'],'/','');
	 		   	   }
	 		   	   //has_been_verified

	 		   	   elseif($user_info['User']['verify_status'] == 1){
	 	     	 	   $this->set('back_url',$back_url);
	 		   	   	   $this->flash("".$this->languages['email_verified_login']."",'/','');
	 		   	   }
	 		   	}
	 		   	else{
	 	     	       $this->set('back_url',$back_url);
	 		   	   	   $this->flash($this->languages['user'].$this->languages['not_exist'],'/','');
	 		   	}
	 	}
 	

	     	 	//用户订单收货确认
	 	function order_received($order_id,$ok){
	 	    if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
				$this->redirect('/login/');
		     }
	 		 //$order_id = 2;
	 		 $this->page_init();
	 		 $this->pageTitle = $this->languages['goods_have_received']." - ".$this->configs['shop_title'];
	 	     $back_url = $this->server_host.$this->user_webroot;
	         if(!is_numeric($order_id) || $order_id<1){
		     $this->pageTitle = $this->languages['invalid_id']." - ".$this->configs['shop_title'];
			     $this->flash($this->languages['invalid_id'],"/user/orders",5);
			 }
		    //订单详细 /*****订单部分的处理********/
			$condition=" Order.id='".$order_id."' ";
			$order_info=$this->Order->find($condition);
			if(!empty($order_info)){
				$user_id=$_SESSION['User']['User']['id'];
				if ($user_id > 0 && $user_id != $order_info['Order']['user_id'])
		         {
					$this->pageTitle = $this->languages['not_your_order']." - ".$this->configs['shop_title'];
		            $this->flash($this->languages['not_your_order'],"/user/orders",5);
		         }
		         if($order_info['Order']['shipping_status']==1){
		         	$this->Order->updateAll(array("Order.shipping_status"=>2),array("Order.id"=>$order_id));
		         	$this->set('back_url',$back_url);
		 		   	$this->flash($this->languages['order'].$this->languages['delivered'].$this->languages['affirm'].$this->languages['successfully'],'/','');	         
		 		 }
		         else {
		 	     	$this->set('back_url',$back_url);
		 		   	$this->flash("".$this->languages['orders_have_no_conditions_confirmation_receipt']."",'/','');
		         }
	        }
	        else {
	 	     	$this->set('back_url',$back_url);
	 		   	$this->flash($this->languages['order'].$this->languages['not_exist'],'/','');
	        
	        }
	 	}
 	

	     //修改密码页面
	     function edit_password($id,$code){
	 	     $this->page_init();
			 $user_info=$this->User->findById($id);
	 	     $code_confirm = md5($user_info['User']['id'] . $user_info['User']['password']);
	 	     if($code <> $code_confirm){
	 	     		$this->pageTitle = $this->languages['invalid_url']." - ".$this->configs['shop_title'];
					$this->flash($this->languages['invalid_url'],'/','');
	 	     }
		     $js_languages = array("password_can_not_be_blank" => $this->languages['password'].$this->languages['can_not_empty'] ,
		   						"retype_password_not_blank" => $this->languages['retype_password_not_blank'],
		   						"Passwords_are_not_consistent" => $this->languages['Passwords_are_not_consistent']);
		   	 $this->set('js_languages',$js_languages);
	  	 	 $this->pageTitle = $this->languages['reset'].$this->languages['password']." - ".$this->configs['shop_title'];
	 	     $this->set('id',$id);
	 	     $this->layout = 'default_full';
	     }
	     
	 	//ajax修改密码
	 	function ajax_edit_password(){
			if($this->RequestHandler->isPost()){
			 	$user_info=$this->User->findById($_POST['id']);
			 	$user_info['User']['password'] = md5($_POST['password']);
			 	$this->User->save($user_info);
				$result['type'] = 0;
				$result['msg'] = $this->languages['edit'].$this->languages['successfully'];
			}
			$this->set('result',$result);
			$this->layout = 'ajax';
	 	}
     		
		function set_email_config(){
			$this->Email->smtpHostNames = "".$this->configs['smtp_host']."";
			$this->Email->smtpUserName = "".$this->configs['smtp_user']."";
			$this->Email->smtpPassword = "".$this->configs['smtp_pass']."";
			$this->Email->from = "".$this->configs['smtp_user']."";
		}     

	//检查用户输入
	function check_input(){
		$column = isset($_POST['column'])?$_POST['column']:'';
		$value =  isset($_POST['value'])?$_POST['value']:'';
		$error_msg = '';
		$error_type = '';
		$error = 0;

		switch($column){
			case 'name':{
				if(empty($value)){
					$error = 1;
							$error_type = "name";
					$error_msg = "".$this->languages['username'].$this->languages['can_not_empty']."";
					break;
				}else if(strlen($value)<3){
					$error = 1;
							$error_type = "name";
					$error_msg = "".$this->languages['username_length_short']."";
					break;
				}
				else{
					for($i=0;$i<strlen($value);$i++){
						if(ereg("[0-9A-Za-z_.]",$value[$i]) != 1){
							$error_msg = "".$this->languages['username_consist_of']."";
							$error_type = "name";
							$error = 1;
							break;
						}
					}
					if($error != 1){
						$condition = " User.".$column." = '".$value."'";
						$result = $this->User->find($condition);
						//pr($result);
						if(is_array($result)){
							$error_msg = "".$this->languages['username_exist']."";
							$error_type = "name";
							$error = 1;
							break;
						}else
							break;
					}else{
						break;
					}
				}
			}
			case 'password':{
				if(empty($value)){
					$error = 1;
					$error_msg = "".$this->languages['password'].$this->languages['can_not_empty']."";
					$error_type = "password";
					break;
				}else if(strlen($value)<6){
					$error = 1;
					$error_msg = "".$this->languages['password_length_short']."";
					$error_type = "password";
					break;
				}
				else{
					for($i=0;$i<strlen($value);$i++){
						if(ereg("[0-9A-Za-z_]",$value[$i]) != 1){
							$error_msg = "".$this->languages['password_consist_of']."";
							$error_type = "password";
							$error = 1;
							break;
						}
					}
					break;
				}
			}
			case 'password_confirm':{
				$pwd_cfm = isset($_POST['password_confirm'])?$_POST['password_confirm']:'';
				$pwd = isset($_POST['password'])?$_POST['password']:'';

				if((strcmp($pwd_cfm,$pwd)!=0)){
					$error_type = "password_confirm";
					$error_msg = "".$this->languages['Passwords_are_not_consistent']."";
					$error = 1;
					break;
				}else{
					$error = 0;
					break;
				}
					
			}
			/*
			case 'realname':{
				if(empty($value)){
					$error = 1;
					$error_msg = "真实姓名不能为空";
					break;
				}else if(strlen($value)<4){
					$error = 1;
					$error_msg = "真实姓名长度太短";
					break;
				}
				else{
					for($i=0;$i<strlen($value);$i++){
						if(ereg("[a-z0-9_]",$value[$i]) != 1){
							$error_msg = "真实姓名只能由字母、数字、下划线组成";
							$error = 1;
							break;
						}
					}
					break;
				}
			}
			*/
			case 'email':{
				if(empty($value)){
					$error = 1;
					$error_type = "email";
					$error_msg = "".$this->languages['email'].$this->languages['format'].$this->languages['not_correct']."";
					break;
				}else if(!ereg("^[-a-zA-Z0-9_.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$value)){
					$error = 1;
					$error_type = "email";
					$error_msg = "".$this->languages['email'].$this->languages['format'].$this->languages['not_correct']."";
					break;
				}
			}
			case 'question':{
				if(empty($value)){
					$error = 1;
					$error_type = "question";
					$error_msg = "".$this->languages['please_choose'].$this->languages['hint_question_to_password']."";
					break;
				}
			}
			case 'answer':{				
				if(empty($value)){
					$error = 1;
					$error_type = "answer";
					$error_msg = "".$this->languages['enter_hint_answer']."";
					break;
				}
			}
		}
//	echo $error_msg;		
		$this->set('column',$column);
		$this->set("error_type",$error_type);
		$this->set("error_msg",$error_msg);
		$this->set('error',$error);
		$this->layout = "ajax";
	}

	function check_all(){
		$column = isset($_POST['column'])?$_POST['column']:'';
		$value =  isset($_POST['value'])?$_POST['value']:'';
		$error_msg = '';
		$error_type = '';
		$error = 0;
				if(empty($_POST['name'])){
					$error = 1;
					$error_type = "name";
					$error_msg = "".$this->languages['username'].$this->languages['can_not_empty']."";
				}else if(strlen($_POST['name'])<3){
					$error = 1;
					$error_type = "name";
					$error_msg = "".$this->languages['username_length_short']."";
				}
				else{
					for($i=0;$i<strlen($_POST['name']);$i++){
						if(ereg("[0-9A-Za-z_.]",$_POST['name'][$i]) != 1){
							$error_msg = "".$this->languages['username_consist_of']."";
							$error_type = "name";
							$error = 1;
						}
					}
					if($error != 1){
						$condition = " User.name = '".$_POST['name']."'";
						$result = $this->User->find($condition);
						//pr($result);
						if(is_array($result)){
							$error_msg = "".$this->languages['username_exist']."";
							$error_type = "name";
							$error = 1;
							
						}else{
						}

					}else{
					}
				}

			if(empty($_POST['password'])){
					$error = 1;
					$error_type = "password";
					$error_msg = "".$this->languages['password'].$this->languages['can_not_empty']."";
				}else if(strlen($_POST['password'])<6){
					$error = 1;
					$error_type = "password";
					$error_msg = "".$this->languages['password_length_short']."";
				}
				else{
					for($i=0;$i<strlen($_POST['password']);$i++){
						if(ereg("[0-9A-Za-z_]",$_POST['password'][$i]) != 1){
							$error_msg = "".$this->languages['password_consist_of']."";
							$error_type = "password";
							$error = 1;
						}
					}
				}				
				
				$pwd_cfm = isset($_POST['pwd_cfm'])?$_POST['pwd_cfm']:'';

				if((strcmp($pwd_cfm,$_POST['password'])!=0)){
					$error_msg = "".$this->languages['Passwords_are_not_consistent']."";
					$error_type = "password_confirm";
					$error = 1;
				}else{
					$error = 0;
				}
				if(empty($_POST['email'])){
					$error = 1;
					$error_type = "email";
					$error_msg = "".$this->languages['email'].$this->languages['format'].$this->languages['not_correct']."";
				}else if(!ereg("^[-a-zA-Z0-9_.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$_POST['email'])){
					$error = 1;
					$error_type = "email";
					$error_msg = "".$this->languages['email'].$this->languages['format'].$this->languages['not_correct']."";
				}				
				if(empty($_POST['answer'])){
					$error = 1;
					$error_type = "answer";
					$error_msg = "".$this->languages['enter_hint_answer']."";
				}				
				if(empty($_POST['question'])){
					$error = 1;
					$error_type = "question";
					$error_msg = "".$this->languages['please_choose'].$this->languages['hint_question_to_password']."";
				}				
			

		
		$this->set('column',$column);
		$this->set("error_type",$error_type);
		$this->set("error_msg",$error_msg);
		$this->set('error',$error);
		$this->layout = "ajax";
	}


	//执行注册
	function act_register(){
		
	//	pr($this->params);exit;
		if($this->RequestHandler->isPost()){
		$error = 0;
		$this->page_init();
	//	$real_ip = $this->requestAction('/commons/real_ip/'); 
		$real_ip = $this->real_ip(); 
 	    $host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
	    $flash_url = $this->server_host.$this->user_webroot;				   	   
		$error_msg = $this->languages['register'].$this->languages['successfully'];//echo "in";exit;
		if(isset($this->configs['register_captcha']) && $this->configs['register_captcha']== 1 && $this->captcha->check($_POST['captcha']) == false){
			$error_msg = $this->languages['verify_code'].$this->languages['not_correct'];
			$error = 1;
		}
		
		//密码保护问题
		$question=isset($this->params['form']['question'])?$this->params['form']['question']:'';
		if(isset($this->params['form']['question']) && $this->params['form']['question'] == $this->languages['others']){
			  $question=isset($this->params['form']['other_question'])?$this->params['form']['other_question']:'';
		}
		//leo20090610ucenter
		$username 	= 	isset($this->params['form']['name'])?$this->params['form']['name']:'';
		$password 	= 	isset($this->params['form']['password'])?$this->params['form']['password']:'';
		$email		=	isset($this->params['form']['email'])?$this->params['form']['email']:'';
		$pwd_cfm	= 	isset($_POST['password_confirm'])?$_POST['password_confirm']:'';
		$send_email =  isset($_POST['send_register_email'])?$_POST['send_register_email']:'';
		if(isset($_POST['no_ajax'])){
		/**	if($_POST['question'] == $this->languages['others']){
				$_POST['question'] = $_POST['other_question'];
			}*/
			if(empty($_POST['name'])){
				$error = 1;
				$error_msg = "".$this->languages['username'].$this->languages['can_not_empty']."";
			}else if(strlen($_POST['name'])<3){
				$error_msg = "".$this->languages['username_length_short']."";
				$error = 1;
			}else if(!isset($error) || $error == 0){
				for($i=0;$i<strlen($_POST['name']);$i++){
					if(ereg("[0-9A-Za-z_.]",$_POST['name'][$i]) != 1){
						$error_msg = "".$this->languages['username_consist_of']."";
						$error = 1;
					}
				}
			if($error != 1){
					$condition = " User.name = '".$_POST['name']."'";
					$result = $this->User->find($condition);
		//			pr($result);exit;
					if(is_array($result)){
						$error = 1;
						$error_msg = "".$this->languages['username_exist']."";
					}
				}
			}elseif(empty($_POST['password'])){
				$error = 1;
				$error_msg = "".$this->languages['password'].$this->languages['can_not_empty']."";
			}else if(strlen($_POST['password'])<6){
				$error = 1;
				$error_msg = "".$this->languages['password_length_short']."";
			}else if(!isset($error)){
				for($i=0;$i<strlen($_POST['password']);$i++){
					if(ereg("[0-9A-Za-z_]",$_POST['password'][$i]) != 1){
						$error_msg = "".$this->languages['password_consist_of']."";
						$error = 1;
					}
				}
			}else if((strcmp($pwd_cfm,$_POST['password'])!=0)){
						$error = 1;
						$error_msg = "".$this->languages['Passwords_are_not_consistent']."";
			}else if(empty($_POST['email'])){
						$error = 1;
						$error_type = "email";
						$error_msg = "".$this->languages['email'].$this->languages['format'].$this->languages['not_correct']."";
			}else if(!ereg("^[-a-zA-Z0-9_.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$_POST['email'])){
						$error = 1;
						$error_type = "email";
						$error_msg = "".$this->languages['email'].$this->languages['format'].$this->languages['not_correct']."";
	     	}/*elseif(empty($_POST['answer'])){
						$error = 1;
						$error_type = "answer";
						$error_msg = "".$this->languages['enter_hint_answer']."";
			}elseif(empty($_POST['question'])){
						$error = 1;
						$error_type = "question";
						$error_msg = "".$this->languages['please_choose'].$this->languages['hint_question_to_password']."";
			}*/				
		}
		$user_infos = array(
			'name'			=>	$username,
			'password'		=>	md5($password),
			'email'			=>	isset($email)?$email:'',
			'question'		=>	isset($question)?$question:'',
			'answer'		=>	isset($this->params['form']['answer'])?$this->params['form']['answer']:'',
			'balance'		=>	0,
			'frozen'		=>	0,
			'login_times'	=>	1,
			'last_login_time' => date("Y-m-d H:i:s"),
			'login_ipaddr'	=>	$real_ip,
			'rank'			=>	0,
			'sex'			=>	isset($this->params['form']['prov'])?$this->params['form']['prov']:0,
			'verify_status' => 0,
			'status'		=>	1
			);
		//leo20090610ucenter
		$plugin = $this->Plugin->find(array("code"=>"ucenter"));
		if( !empty($plugin)&&isset($this->configs['integrate_code'])&&$this->configs['integrate_code']=="ucenter" ){
			$uid = $this->uc_call("uc_user_register", array($username, $password, $email));
			$user_infos["id"] = $uid;
		}		
		if(isset($this->params['form']['date']) && $this->params['form']['date'] !=''){
			$user_infos['birthday'] = $this->params['form']['date'];
		}
		if($error ==0){
		    //pr($user_info);
			$this->User->save($user_infos);
			$id=$this->User->id;
			$user_info = $this->User->findbyid($id);
			//收货地址
			if(!isset($_POST['no_ajax'])){
				$region='';
				if(isset($this->data['Address']['Region'])){
					foreach($this->data['Address']['Region'] as $k=>$v){
						  $region .=$v." ";
					}
				}
				
				$telephone = isset($this->params['form']['user_tel0'])?trim($this->params['form']['user_tel0']):'';
				//echo $region;
				$user_address = array(
					'name'			=>	isset($this->params['form']['name'])?$this->params['form']['name']:'',
					'consignee'		=>	isset($this->params['form']['name'])?$this->params['form']['name']:'',
					'user_id'		=>	$id,
					'email'			=>	isset($this->params['form']['email'])?$this->params['form']['email']:'',
					'mobile'		=>	isset($this->params['form']['mobile'])?$this->params['form']['mobile']:'',
					'regions'		=>	$region,
					'telephone'		=>	$telephone
					);
		
				if(isset($this->params['form']['address']) && $this->params['form']['address'] != $this->languages['please_choose'] && $this->params['form']['address'] != ''){
					$user_address['address'] = $this->params['form']['address'];
				}
		
				$this->UserAddress->save(array('UserAddress'=>$user_address));
				
				if($send_email == "on"){
					$email_config = $this->Config->findAll(array("code"=>"enable_members_mail_verify"));
				//	pr($email_config);exit;
					$this->ConfigI18n->updateAll(array("value" => "1"),array("id" => $email_config[0]["ConfigI18n"]["id"]));
				}
			}
		
		//可选信息新增
		if(isset($this->params['form']['info_value']) && (!empty($this->params['form']['info_value']))){
	 	        foreach($this->params['form']['info_value'] as $k=>$v){
	 	        	if(!empty($v)){
	 	        		$va = "";
	 	        		if(is_array($v) && sizeof($v)>0){
	 	        			foreach($v as $key=>$value){
	 	        				$va .=$value;
	 	        				if($key < sizeof($v) - 1){
	 	        				$va .=";";
	 	        				}
	 	        			}
	 	        		}else{
	 	        			$va = $v;
	 	        		}
	 	        		
		               $user_info_value = array(
			                 'user_id'		=>	$id,
			                 'user_info_id'=>	$k,
			                 'value'		=>	$va
			           );
		              $this->UserInfoValue->saveAll(array('UserInfoValue'=>$user_info_value));
		            }
		        }
		}
			
		$this->check_point();
		//判断注册是否送积分 
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(true,$this->locale);
		
		
		
		if(isset($this->configs['register_gift_points']) && $this->configs['register_gift_points'] == 1){
			$user_info['User']['point'] += $this->configs['first_points'];
			$user_info['User']['user_point'] += $this->configs['first_points'];
			
			$this->User->save($user_info);
			
			$user_point_log = array("id"=>"",
									"user_id" => $user_info['User']['id'],
									"point" => $this->configs['first_points'],
									"log_type" => "R",
									"system_note" => $systemresource_info['point_log_type']['R'],
									"type_id"=> '0'
									);
			$this->UserPointLog->save($user_point_log);
		}
		//判断是否送优惠券
		if(isset($this->configs['register_coupons']) && $this->configs['register_coupons'] == 1){
	       	$now = date("Y-m-d H:i:s");
	       	$this->CouponType->set_locale($this->locale);
			$coupon_type = $this->CouponType->findall("CouponType.send_type = '4' and CouponType.send_start_date <= '".$now."' and  CouponType.send_end_date >='".$now."'"); 
			if(is_array($coupon_type) && sizeof($coupon_type)>0){
			//	$coupon_arr = $this->Coupon->findall("1=1",'DISTINCT Coupon.sn_code');
				$coupon_arr_list = $this->Coupon->find('list',array('conditions'=>array("1=1"),'fields' => array('Coupon.sn_code')));
				$coupon_arr = array();
				if(is_array($coupon_arr_list) && sizeof($coupon_arr_list)>0){
					foreach($coupon_arr_list as $k=>$v){
						$coupon_arr[] = $v;
					}
				}				
				
				$coupon_count = count($coupon_arr);
				$num = 0;
				if($coupon_count > 0){
					$num = $coupon_arr[$coupon_count - 1];
				}
				foreach($coupon_type as $k=>$v){
					if(isset($coupon_sn)){
						$num = $coupon_sn;
					}
					$num = substr($num,2, 10);
					$num = $num ? floor($num / 10000) : 100000;
			        $coupon_sn = $v['CouponType']['prefix'].$num . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
			        $coupon = array(
							        'id'=>'',
							        'coupon_type_id' => $v['CouponType']['id'],
									'sn_code' => $coupon_sn,
							        'user_id' => $id,
							        );
					$this->Coupon->save($coupon);
				}
			}
		}
		
		//判断是否启用邮件验证
		if($this->configs['enable_members_mail_verify'] == 1 && !empty($user_info['User']['email'])){
			  //发送注册邮件
		      $send_date=date('Y-m-d');
			  $user_name = $user_info['User']['name'];
			  $shop_name = $this->configs['shop_name'];
			  $user_password = $user_info['User']['password'];
			  $this->MailTemplate->set_locale($this->locale);
			  $template=$this->MailTemplate->find("code = 'register_validate' and status = '1'");
			  $template_str=$template['MailTemplateI18n']['html_body'];
			  $code = md5($user_info['User']['id'] . $user_info['User']['email']);
			  $url = $this->server_host.$this->user_webroot."verifyemail/".$user_info['User']['id']."/".$code."/";
			  /* 商店网址 */
			  $shop_url = $this->server_host.$this->cart_webroot;
			  eval("\$template_str = \"$template_str\";");
			  $to_email = $user_info['User']['email'];
			  $this->set_email_config();
			  $this->Email->is_ssl = $this->configs['smtp_ssl'];
		      $this->Email->is_mail_smtp = $this->configs['mail_service'];
			  $this->Email->smtp_port = $this->configs['smtp_port'];
			  $this->Email->fromName = "".$shop_name."";  //标题
			  $this->Email->html_body = "".$template_str."";
		      $text_body = $template['MailTemplateI18n']['text_body'];
		      eval("\$text_body = \"$text_body\";");
		  	  $this->Email->text_body = $text_body;
			  $this->Email->to = "".$user_info['User']['email']."";
			  $subject = $template['MailTemplateI18n']['title'];
			  eval("\$subject = \"$subject\";");
			  $this->Email->subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
			  @$this->Email->send();
		}
		
        //用户设置初始值
        unset($_SESSION['User']);
		$_SESSION['User'] = $user_info;
		
	//	header("location:/user/");
			$this->pageTitle = $this->languages['register'].$this->languages['successfully']." - ".$this->configs['shop_title'];
		}

			if(isset($_SESSION['back_url'])){
				$url = $_SESSION['cart_back_url'] = $_SESSION['back_url'];
				
			}else if(!isset($_SESSION['cart_back_url'])){
				$url = $this->server_host.$this->user_webroot;
			}else{
				$url = "/";
	 		}
	 		//echo $error;exit;
	 		if($error == 0){
	 			$this->set('back_register',$url);
				$this->set('error_msg',$this->languages['register'].$this->languages['successfully'].",".sprintf($this->languages['welcome_to'],$this->configs['shop_name']));
		   // 	$this->flash($this->languages['register'].$this->languages['successfully'].",".sprintf($this->languages['welcome_to'],$this->configs['shop_name']),$url,'');
			}else{
				$this->set('fail',1);
				$this->set('error_msg',$error_msg);
				$this->pageTitle = $error_msg."-".$this->configs['shop_name'];
		    //	$this->flash($error_msg,$flash_url,'');
			}
		}
		$this->layout = "default_full";
	}
		//注册邮件
 	function send_verify_email($to_email,$user_id,$ajax = 1){
		$send_date=date('Y-m-d');
		$user_info=$this->User->findById($user_id);
		$user_name = $user_info['User']['name'];
		$shop_name = $this->configs['shop_name'];
		$user_password = $user_info['User']['password'];
		$this->MailTemplate->set_locale($this->locale);
		$template=$this->MailTemplate->find("code = 'register_validate' and status = '1'");
		$template_str=$template['MailTemplateI18n']['html_body'];
		$code = md5($user_info['User']['id'] . $to_email);
		$url = $this->server_host.$this->user_webroot."verifyemail/".$user_info['User']['id']."/".$code."/";	
		/* 商店网址 */
		$shop_url = $this->server_host.$this->user_webroot;
		eval("\$template_str = \"$template_str\";");
		$to_email = $user_info['User']['email'];
		$this->set_email_config();
		$this->Email->fromName = "".$shop_name."";  //标题
		$this->Email->html_body = "".$template_str."";
		$this->Email->is_ssl = $this->configs['smtp_ssl'];
		$this->Email->is_mail_smtp = $this->configs['mail_service'];
		$this->Email->smtp_port = $this->configs['smtp_port'];
		$text_body = $template['MailTemplateI18n']['text_body'];
     	eval("\$text_body = \"$text_body\";");
  	    $this->Email->text_body = $text_body;
		$this->Email->to = "".$to_email."";
		$subject = $template['MailTemplateI18n']['title'];
		eval("\$subject = \"$subject\";");
		$this->Email->subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
		if(@$this->Email->send()){
	    $message=array(
	    'msg'=>"".$this->languages['send_confirm_mail'].$this->languages['send'].$this->languages['successfully']."",
	    	'send_confirm_mail'=>"".$this->languages['send_confirm_mail']."",
	    	'confirm'=>"".$this->languages['confirm']."",
	    'url'=>''
	    );
		}else{
	    $message=array(
	    'msg'=>"".$this->languages['send_confirm_mail'].$this->languages['send'].$this->languages['failed']."",
	    	'send_confirm_mail'=>"".$this->languages['send_confirm_mail']."",
	    	'confirm'=>"".$this->languages['confirm']."",
	    'url'=>''
		);
		}
		if(isset($ajax) && $ajax == 0){
			$this->flash($message['msg'],$this->server_host.$this->user_webroot,10);
		}else{
			$this->set('result',$message);
		   	$this->layout="ajax";
		}
 	}
	
	function closed(){
		$this->page_init();
		$this->set('shop_logo',$this->configs['shop_logo']);
		$this->set('closed_reason',$this->configs['closed_reason']);
		$this->pageTitle = $this->languages['shop_closed']." - ".$this->configs['shop_title'];
		$this->flash($this->languages['shop_closed']," ","/",5);
	} 	
	
	function check_point(){
		if(isset($_SESSION['User']['User']['id']) && isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
			$user_info = $this->User->findbyid($_SESSION['User']['User']['id']);
	//		if(!isset($_SESSION['svcart']['point']['fee']) || !isset($_SESSION['svcart']['point']['point'])){
	//			$_SESSION['svcart']['point']['fee'] = 0;
	//			$_SESSION['svcart']['point']['point'] = 0;
	//		}
			$product_ranks = $this->ProductRank->findall_ranks();
			$user_rank_list=$this->UserRank->findrank();		
			
			if(isset($_SESSION['svcart']['products'])){	
				foreach($_SESSION['svcart']['products'] as $i=>$p){
					if(empty($p['Product']['extension_code'])){
						$_SESSION['svcart']['cart_info']['all_virtual'] = 0;
					}
					//获得是否有会员价
					if(isset($_SESSION['User'])){
						//$p['Product']['product_rank_price'] = 	$this->Product->user_price($i,$p,$this);
						if(isset($product_ranks[$p['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$p['Product']['id']][$_SESSION['User']['User']['rank']])){
							if(isset($product_ranks[$p['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$p['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
							  $p['Product']['user_price']= $product_ranks[$p['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
							}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
							  $p['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($p['Product']['shop_price']);			  
							}
						}					
					
					}else{
					//如果会员未登录 删除SESSION中残留的product_rank_price
						if(isset($p['Product']['product_rank_price']) || isset($_SESSION['svcart']['products'][$i]['product_rank_price'])){
							unset($p['Product']['product_rank_price']);
							unset($_SESSION['svcart']['products'][$i]['product_rank_price']);
						}
					}
					
					//有会员价
					if(isset($p['Product']['product_rank_price'])){
						$promotion_price = $p['Product']['product_rank_price'];
						$_SESSION['svcart']['products'][$i]['product_rank_price'] = $promotion_price;
						$_SESSION['svcart']['cart_info']['sum_subtotal'] += $p['Product']['product_rank_price']*$p['quantity'];
					}else{
						if($this->is_promotion($p)){
							//该商品现价
							$promotion_price = $p['Product']['promotion_price'];
							//全部商品现价合计
							
							$_SESSION['svcart']['cart_info']['sum_subtotal'] += $p['Product']['promotion_price']*$p['quantity'];
						
							$_SESSION['svcart']['products'][$i]['is_promotion'] = 1;
						}else{
							$promotion_price = $p['Product']['shop_price'];
							//总现合计
							$_SESSION['svcart']['cart_info']['sum_subtotal'] += $p['Product']['shop_price']*$p['quantity'];
							$_SESSION['svcart']['products'][$i]['is_promotion'] = 0;
						}
					}
					//该商品原价
					$_SESSION['svcart']['products'][$i]['market_subtotal'] = $p['Product']['market_price']*$p['quantity'];
					//该商品小计
					$_SESSION['svcart']['products'][$i]['subtotal'] = $promotion_price*$p['quantity'];
					$_SESSION['svcart']['cart_info']['product_subtotal'] += $promotion_price*$p['quantity'];
					//全部商品原价合计
					$_SESSION['svcart']['cart_info']['sum_market_subtotal'] += $_SESSION['svcart']['products'][$i]['market_subtotal'];
					//该商品差价
					$_SESSION['svcart']['products'][$i]['discount_price'] = $p['Product']['market_price'] - $promotion_price;
					//该商品折扣%?
					if($promotion_price > 0){
					$_SESSION['svcart']['products'][$i]['discount_rate'] = round($promotion_price/$p['Product']['market_price'],2)*100 ;
					}else{
					$_SESSION['svcart']['products'][$i]['discount_rate'] = 100;
					}
				}
			}			
			
			
			
			$point = round($_SESSION['svcart']['cart_info']['sum_subtotal']/100*$this->configs['proportion_point']);
			if($point > $user_info['User']['point']){
			$can_use_point = $user_info['User']['point'];
			}else{
			$can_use_point = $point;
			}
			$buy_point = 0;
			foreach($_SESSION['svcart']['products'] as $k=>$v){
				$this->save_cart($v,$k);
				if(isset($v['is_exchange']) && $v['is_exchange'] == 1){
					if(($buy_point + $v['Product']['point_fee']*$v['quantity']) <= $can_use_point){
						$buy_point += $v['Product']['point_fee']*$v['quantity'];
						$_SESSION['svcart']['products'][$k]['use_point'] += $v['Product']['point_fee']*$v['quantity'];
					}else{
						for($i=$v['quantity'];$i>0;$i--){
							if(($buy_point + $v['Product']['point_fee']*$i) <= $can_use_point){
								$buy_point += $v['Product']['point_fee']*$v['quantity'];
								$_SESSION['svcart']['products'][$k]['use_point'] += $v['Product']['point_fee']*$i;
								break;
							}
						}
					}
				}
			}
			if($buy_point > 0){
				$_SESSION['svcart']['point']['fee'] = round($buy_point/100*$this->configs['conversion_ratio_point']);
				$_SESSION['svcart']['point']['point'] = $buy_point;
			}
		}
	}
	
	function save_cart($product_info,$p_id){
		$product_ranks = $this->ProductRank->findall_ranks();
		$user_rank_list=$this->UserRank->findrank();	
		if(!isset($product_info['save_cart'])){
			if(isset($_SESSION['User']['User']) && (!isset($product_info['save_cart'])) && isset($this->configs['enable_out_of_stock_handle']) &&  $this->configs['enable_out_of_stock_handle'] >0){
				
				if(isset($product_ranks[$product_info['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$product_info['Product']['id']][$_SESSION['User']['User']['rank']])){
					if(isset($product_ranks[$product_info['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$product_info['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
					  $price_user= $product_ranks[$product_info['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
					}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
					  $price_user=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($product_info['Product']['shop_price']);			  
					}
				}				
				
		//		$price_user = 	$this->Product->user_price(0,$product_info,$this);
				
			if(isset($price_user) && (!empty($price_user))){
				$cart_price = $price_user;
			}else{
				if($this->is_promotion($product_info)){
					$cart_price = $product_info['Product']['promotion_price'];
				}else{
					$cart_price = $product_info['Product']['shop_price'];
				}
			}
			
			$cart = array(
				'id' => '',
				'session_id' => session_id(),
				'user_id' => $_SESSION['User']['User']['id'],
				'store_id' => 0,
				'product_id' => $product_info['Product']['id'],
				'product_code' => $product_info['Product']['code'],
				'product_name' => $product_info['ProductI18n']['name'],
				'product_price' => $cart_price,
				'product_quantity' => $product_info['quantity'],
				'product_attrbute' => isset($product_info['attributes'])?$product_info['attributes']:"",
				'extension_code' => $product_info['Product']['extension_code']
			);
			$this->Cart->save($cart);
			$_SESSION['svcart']['products'][$p_id]['save_cart'] = $this->Cart->id;			
			
			}
		}
	}
	
	function is_promotion($product_info){
		return ($product_info['Product']['promotion_status'] == '1' && $product_info['Product']['promotion_start'] <= date("Y-m-d H:i:s") && $product_info['Product']['promotion_end'] >= date("Y-m-d H:i:s"));
	}
	
function real_ip()
{
    static $realip = NULL;

    if ($realip !== NULL)
    {
        return $realip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip)
            {
                $ip = trim($ip);

                if ($ip != 'unknown')
                {
                    $realip = $ip;

                    break;
                }
            }
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '0.0.0.0';
            }
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $realip;
	} 	
	
	
	
	//leo20090610ucenter
	function user_exist($username="leoleo",$password="leoleo"){
		list($uid, $uname, $pwd, $email, $repeat) = $this->uc_call("uc_user_login", array($username, $password));
		//echo $uid;
		$uname = addslashes($uname);
        if($uid > 0)
        {	
            //检查用户是否存在,不存在直接放入用户表
            $user_exist = $this->User->find(array("name"=>"'".$uname."'"));print_r($user_exist );
            if (empty($user_exist))
            {
                $reg_date = time();
                $ip = "";
                $password = md5($password);
                $user_info = array(
                	"id"=>$uid,
                	"name"=>$uname,
                	"password"=>$password,
                	"email"=>$email
                );
                $this->User->saveAll(array("User"=>$user_info));
                
            }
           // $ucdata = $this->uc_call("uc_user_synlogin", array($uid));
        }
        return $uid;
	}
		//leo20090610ucenter
	/**
	 * 调用UCenter的函数
	 */
	function uc_call($func, $params=null)
	{	
		$cfg = unserialize($this->configs["integrate_config"]);
		if(strpos($cfg['db_pre'], '`' . $cfg['db_name'] . '`') === 0)
		{
          	$db_pre = $cfg['db_pre'];
		}
		else
		{
        	$db_pre = '`' . $cfg['db_name'] . '`.' . $cfg['db_pre'];
		}
		define('UC_CONNECT', isset($cfg['uc_connect'])?$cfg['uc_connect']:'');
		define('UC_DBHOST', isset($cfg['db_host'])?$cfg['db_host']:'');
		define('UC_DBUSER', isset($cfg['db_user'])?$cfg['db_user']:'');
	  	define('UC_DBPW', isset($cfg['db_pass'])?$cfg['db_pass']:'');
	   	define('UC_DBNAME', isset($cfg['db_name'])?$cfg['db_name']:'');
	   	define('UC_DBCHARSET', isset($cfg['db_charset'])?$cfg['db_charset']:'');
	   	define('UC_DBTABLEPRE', $db_pre);
	 	define('UC_DBCONNECT', '0');
	  	define('UC_KEY', isset($cfg['uc_key'])?$cfg['uc_key']:'');
	   	define('UC_API', isset($cfg['uc_url'])?$cfg['uc_url']:'');
	  	define('UC_CHARSET', isset($cfg['uc_charset'])?$cfg['uc_charset']:'');
	   	define('UC_IP', isset($cfg['uc_ip'])?$cfg['uc_ip']:'');
	   	define('UC_APPID', isset($cfg['uc_id'])?$cfg['uc_id']:'');
	  	define('UC_PPP', '20');	   
	    restore_error_handler();
	    if (!function_exists($func))
	    {
	        include('../uc_client/client.php');
	    }

	    $res = call_user_func_array($func, $params);
		
	    set_error_handler('exception_handler');

	    return $res;
	}
	function uclogin($uid){
		Configure::write('debug',0);
		echo $this->uc_call("uc_user_synlogin", array($uid));
		die();
	}

 }	
?>