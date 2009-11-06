<?php
/*****************************************************************************
 * SV-Cart 用户我的信息
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: profiles_controller.php 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
uses('sanitize');		
class ProfilesController extends AppController {

	var $name = 'Profiles';
	var $helpers = array('Html');
    var $components = array ('RequestHandler'); // Added 
	var $uses = array("User","UserAddress","UserInfo","UserInfoValue","Region");

/*------------------------------------------------------ */
//-- 我的信息
/*------------------------------------------------------ */
	function index(){
		  //未登录转登录页
		  if(!isset($_SESSION['User'])){
			   $this->redirect('/login/');
		  }
		 $this->page_init();
	     if($this->RequestHandler->isPost()){
   	     	    $birthday = trim($this->params['form']['date']);
    			$telephone = trim($this->params['form']['Utel0']) .'-'. trim($this->params['form']['Utel1']) .'-'.
    			trim($this->params['form']['Utel2']);
    			$this->data['User']['birthday']=$birthday;
    			$this->data['UserAddress']['telephone']=$telephone;
    			$this->data['UserAddress']['regions']='';
    			foreach($this->data['Address']['Region'] as $k=>$v){
    				  $this->data['UserAddress']['regions'] .=$v." ";
    			}
    			$this->User->save($this->data['User']); 
    			$this->UserAddress->save($this->data['UserAddress']);
		       if(!empty($this->params['form']['info_value']) && is_array($this->params['form']['info_value'])){
		       	      foreach($this->params['form']['info_value'] as $k=>$v){
		       	      	      $info_value=array(
		                                     'id'=>	$this->params['form']['info_value_id'][$k],
		                                     'user_id'=>$this->data['User']['id'],
		                                     'user_info_id'=>	$k,
		                                     'value'=>	$this->params['form']['info_value'][$k]
		                      );
	                          $this->UserInfoValue->save(array('UserInfoValue'=>$info_value));
 		       	       }
		       }
		 		$this->pageTitle = $this->languages['edit'].$this->languages['successfully']." - ".$this->configs['shop_title'];
    			$this->flash($this->languages['edit'].$this->languages['successfully'],'/profiles/','');
   	     }
   		 //当前位置
		 $this->navigations[] = array('name'=>__($this->languages['my_information'],true),'url'=>"");
		 $this->set('locations',$this->navigations);
		 
	     $user_id=$_SESSION['User']['User']['id'];
	     //取得个人信息
	     $user_info=$this->User->find(" User.id = '".$user_id."'");
	     $this->data['profiles']=$user_info;
	     //用户默认地址
	     $default_address=$this->UserAddress->find(" UserAddress.user_id = '".$user_id."'");
	     if(!empty($default_address)){
	          $this->data['profiles']['UserAddress']=$default_address['UserAddress'];
	     }
	     //用户项目信息
		   $condition=" UserInfoValue.user_id=".$user_id;
		   $res=$this->UserInfoValue->findall($condition);
		   $values_id=array();
		   foreach($res as $k=>$v){
		   	   $user_info_value[$v['UserInfoValue']['user_info_id']]['UserInfoValue']=$v['UserInfoValue'];
		   	   $values_id[$k]=$v['UserInfoValue']['user_info_id'];
		   }
		   $this->UserInfo->set_locale($this->locale);
		   $user_infoarr=$this->UserInfo->findinfoassoc("");
	//	   pr($this->data);
		   if(isset($user_info_value)){
			   foreach($user_infoarr as $k=>$v){
			   	     if(isset($user_info_value[$k])){
			   	           $user_infoarr[$k]['value']=$user_info_value[$k]['UserInfoValue'];
			   	      }
			    }
		   }
		 $this->pageTitle = $this->languages['my_information']." - ".$this->configs['shop_title'];
         $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist'],
       						"address_label_not_empty" => $this->languages['address'].$this->languages['label'].$this->languages['can_not_empty'],
				       		"invalid_email" => $this->languages['email'].$this->languages['format'].$this->languages['not_correct'],
				       		"zip_code_not_empty" => $this->languages['post_code'].$this->languages['can_not_empty'],
				       		"invalid_tel_number" => $this->languages['telephone'].$this->languages['format'].$this->languages['not_correct'],
				       		"tel_number_not_empty" => $this->languages['telephone'].$this->languages['can_not_empty'],
				       		"invalid_mobile_number" => $this->languages['mobile'].$this->languages['format'].$this->languages['not_correct'],
				       		"mobile_phone_not_empty" => $this->languages['mobile'].$this->languages['can_not_empty'],
				       		"address_detail_not_empty" => $this->languages['address'].$this->languages['can_not_empty'],
				       		"consignee_name_not_empty" => $this->languages['consignee'].$this->languages['can_not_empty'],
							"fill_one_contact" => $this->languages['please_enter'].$this->languages['one_contact'],
							"please_choose" => $this->languages['please_choose'],
							"choose_area" => $this->languages['please_choose'].$this->languages['region']
       		);
		 $this->set('js_languages',$js_languages);		 
	     $this->set('user_infoarr',array_values($user_infoarr));
	     $this->set('default_address',$default_address);
	     $this->layout = 'default';
	     
	}
	
	function edit_profiles(){
		$mrClean = new Sanitize();
		if($this->RequestHandler->isPost()){
			$no_error = 1;
			$flash_url = $this->server_host.$this->user_webroot."profiles";			
			if(!isset($_POST['is_ajax'])){
			    $this->page_init();
			/*	if(trim($_POST['data']['User']['email']) == ""){
					$this->pageTitle = "".$this->languages['email'].$this->languages['can_not_empty']."";
		 		    $this->flash($this->languages['email'].$this->languages['can_not_empty'],$flash_url,10);	
		 		    $no_error = 0;	
				}else if(!ereg("^[-a-zA-Z0-9_.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$_POST['data']['User']['email'])){
					$this->pageTitle = "".$this->languages['email'].$this->languages['format'].$this->languages['not_correct']."";
		 		    $this->flash($this->languages['email'].$this->languages['format'].$this->languages['not_correct'],$flash_url,10);	
		 		    $no_error = 0;	
				}
						
				if(in_array($this->languages['please_choose'],$_POST['data']['Address']['Region'])){
					$this->pageTitle = "".$this->languages['please_choose'].$this->languages['region']."";
		 		    $this->flash($this->languages['please_choose'].$this->languages['region'],$flash_url,10);	
		 		    $no_error = 0;	
				}else{
					$this->Region->set_locale($this->locale);
					$region_info = $this->Region->findbyparent_id($_POST['data']['Address']['Region'][count($_POST['data']['Address']['Region'])-1]);
					if(isset($region_info['Region'])){		
					$this->pageTitle = "".$this->languages['please_choose'].$this->languages['region']."";
		 		    $this->flash($this->languages['please_choose'].$this->languages['region'],$flash_url,10);	
		 		    $no_error = 0;					
					}
				}
				if(trim($_POST['data']['UserAddress']['address']) == ""){
					$this->pageTitle = "".$this->languages['address'].$this->languages['can_not_empty']."";
		 		    $this->flash($this->languages['address'].$this->languages['can_not_empty'],$flash_url,10);	
		 		    $no_error = 0;						
				}	*/	
				if(trim($_POST['Utel1']) == ""  && $no_error == 1){
					$this->pageTitle = "".$this->languages['telephone'].$this->languages['can_not_empty']."";
		 		    $this->flash($this->languages['telephone'].$this->languages['can_not_empty'],$flash_url,10);	
		 		    $no_error = 0;						
				}
				if(trim($_POST['data']['UserAddress']['mobile']) == ""  && $no_error == 1){
					$this->pageTitle = "".$this->languages['mobile'].$this->languages['can_not_empty']."";
		 		    $this->flash($this->languages['mobile'].$this->languages['can_not_empty'],$flash_url,10);	
		 		    $no_error = 0;					
				}
				
				$telephone = $_POST['Utel1'];
			//	if($_POST['Utel2'] != ""){
			//		$telephone .= "-".$_POST['Utel2'];
			//	}
			//	$regions = implode(" ",$_POST['data']['Address']['Region']);
				$address = array('id'=>$_POST['data']['UserAddress']['id']/*,'address'=>$_POST['data']['UserAddress']['address']*/,'mobile'=>$_POST['data']['UserAddress']['mobile'],'telephone'=>$telephone/*,'regions'=>$regions*/);
				$user = array('id'=>$_POST['data']['User']['id'] /*,'email'=>$_POST['data']['User']['email']*/ ,'sex'=>$_POST['data']['User']['sex'] ,'birthday'=> $_POST['data']['User']['birthday']);
			}else{
				$address=(array)json_decode(StripSlashes($_POST['address']));
				$user=(array)json_decode(StripSlashes($_POST['user']));
			
			}
			if($user['birthday'] == ''){
				unset($user['birthday']);
			}
			
			if($no_error == 1){
				$address['user_id'] = $user['id'];

				$this->User->save($user); 
    			$this->UserAddress->save($address);
    		}
			if(!isset($_POST['is_ajax']) && $no_error == 1){
				if(isset($_POST['info_value_id'])){
					foreach($_POST['info_value_id'] as $k=>$v){
							if($_POST['ValueInfoType'][$k] == "checkbox" && !empty($_POST['info_value'][$k])){
								$_POST['info_value'][$k] = implode(";",$_POST['info_value'][$k]);
							}
		       	      	      $info_value=array(
		                                     'id'=>	!empty($v)?intval($v):"",
		                                     'user_id'=> intval($user['id']),
		                                     'user_info_id'=> intval($_POST['ValueInfoId'][$k]),
		                                     'value'=>	isset($_POST['info_value'][$k])?$_POST['info_value'][$k]:''
		                      );
		               	if($no_error == 1){
	                        $this->UserInfoValue->save($info_value);
	                    }						
					}
				}
						
			$this->pageTitle = "".$this->languages['edit'].$this->languages['successfully']."";
		    $this->flash($this->languages['edit'].$this->languages['successfully'],$flash_url,10);
			}else if($no_error == 1){
			$info=$_POST['info'];
			$info_arr = explode(",",$info);				
			if(!empty($info_arr) && is_array($info_arr)){
		       	      foreach($info_arr as $k=>$v){
		       	      	  if(!empty($v)){
		       	      	  	  $arr = explode(" ",$v);
		       	      	      $info_value=array(
		                                     'id'=>	!empty($arr[1])?intval($arr[1]):"",
		                                     'user_id'=> intval($user['id']),
		                                     'user_info_id'=> intval($arr[2]),
		                                     'value'=>	$arr[0]
		                      );
			               	if($no_error == 1){
		                        $this->UserInfoValue->save($info_value);
		                    }
	                      }
 		       	       }
		       }
		    }
		$result['msg']=$this->languages['edit'].$this->languages['successfully'];
		$result['type'] = 0;
		}
		if(isset($_POST['is_ajax'])){
			$this->set('result',$result);
			$this->layout = 'ajax';
		}
	}
}
?>