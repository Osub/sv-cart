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
 * $Id: profiles_controller.php 1841 2009-05-27 06:51:37Z huangbo $
*****************************************************************************/
uses('sanitize');		
class ProfilesController extends AppController {

	var $name = 'Profiles';
	var $helpers = array('Html');
    var $components = array ('RequestHandler'); // Added 
	var $uses = array("User","UserAddress","UserInfo","UserInfoValue");

/*------------------------------------------------------ */
//-- 我的信息
/*------------------------------------------------------ */
	function index(){
		  //未登录转登录页
		  if(!isset($_SESSION['User'])){
			   $this->redirect('/login/');
		  }
	     if($this->RequestHandler->isPost()){
   	     	    $this->page_init();
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
   	     
	     $this->page_init();
	 	 
		 //当前位置
		 $this->navigations[] = array('name'=>__($this->languages['my_information'],true),'url'=>"");
		 $this->set('locations',$this->navigations);
		 
	     $user_id=$_SESSION['User']['User']['id'];
	     //取得个人信息
	     $user_info=$this->User->find(" User.id = '".$user_id."'");
	     $this->data=$user_info;

	     //用户默认地址
	     $default_address=$this->UserAddress->find(" UserAddress.user_id = '".$user_id."'");
	     if(!empty($default_address)){
	          $default_address['UserAddress']['telephone']=split("-",$default_address['UserAddress']['telephone']);
	          $this->data['UserAddress']=$default_address['UserAddress'];
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
	}
	
	function edit_profiles(){
		$mrClean = new Sanitize();
		if($this->RequestHandler->isPost()){
			$address=(array)json_decode(StripSlashes($_POST['address']));
			$user=(array)json_decode(StripSlashes($_POST['user']));
			if($user['birthday'] == ''){
				unset($user['birthday']);
			}
			$info=$_POST['info'];
			$info_arr = explode(",",$info);
			$this->User->save($user); 
    		$this->UserAddress->save($address);
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
	                        $this->UserInfoValue->save($info_value);
	                      }
 		       	       }
		       }
		$result['msg']=$this->languages['edit'].$this->languages['successfully'];
		$result['type'] = 0;
		}

		$this->set('result',$result);
		$this->layout = 'ajax';
	}
}
?>