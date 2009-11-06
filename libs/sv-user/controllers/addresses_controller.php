<?php
/*****************************************************************************
 * SV-Cart 用户收货地址
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: addresses_controller.php 4887 2009-10-11 09:05:21Z huangbo $
*****************************************************************************/
uses('sanitize');		
class AddressesController extends AppController {
	var $name = 'Addresses';
	var $helpers = array('Html');
	var $uses = array("UserAddress","Region","User");
	var $components = array('RequestHandler');
		
/*------------------------------------------------------ */
//-- 我的地址簿
/*------------------------------------------------------ */
	function index(){

		//未登录转登录页
		if(!isset($_SESSION['User'])){//	echo "111111111111";exit;
				$this->redirect('/login/');
		}
		if($this->RequestHandler->isPost()){
			    //pr($this->params);
			    $this->page_init();
				$url = $this->server_host.$this->user_webroot."addresses";				
			    
			   //新增地址
                   if(isset($this->params['form']['action_type']) && $this->params['form']['action_type'] == 'insert_address'){
			  	            //pr($this->params);
			  	           	$telephone = trim($this->params['form']['user_tel0']) .'-'. trim($this->params['form']['user_tel1']) .'-'.
    						trim($this->params['form']['user_tel2']);
    						$this->data['UserAddress']['telephone']=$telephone;
    						$this->data['UserAddress']['regions']='';
    						foreach($this->data['Address']['Region'] as $k=>$val){
    							  $this->data['UserAddress']['regions'] .=$val." ";
    						}
    						//pr($this->params);
    						$this->UserAddress->save($this->data['UserAddress']);
							$this->pageTitle = $this->languages['add'].$this->languages['successfully']." - ".$this->configs['shop_title'];
    			            $this->flash($this->languages['add'].$this->languages['successfully'],$url,'');
			        }
			    //编辑指定地址
			        if(isset($this->params['form']['action_type']) && $this->params['form']['action_type'] == 'edit_address'){
			        	    foreach($this->data['UserAddress'] as $k=>$v){
			        	    	  $this->data['UserAddress'][$k]['telephone']=trim($this->params['form']['tel_0'][$k]) .'-'. trim($this->params['form']['tel_1'][$k]) .'-'.
    							  trim($this->params['form']['tel_2'][$k]);
    							  $this->data['UserAddress'][$k]['regions']='';
			        	               foreach($this->data['Address']['Region'] as $key=>$val){
    							            $this->data['UserAddress'][$k]['regions'] .=$val." ";
    						            }
    						      $this->UserAddress->save($this->data['UserAddress'][$k]);
			        	    }
							$this->pageTitle = $this->languages['edit'].$this->languages['successfully']." - ".$this->configs['shop_title'];
    			            $this->flash($this->languages['edit'].$this->languages['successfully'],$url,'');
			        }
		}
		$this->page_init();
		
		//当前位置
		$this->navigations[] = array('name'=>__($this->languages['address_book'],true),'url'=>"");
		$this->set('locations',$this->navigations);
		
		//pr($this->languages);
	    //获得我的收获地址
	    $user_id=$_SESSION['User']['User']['id'];
	    //pr($_SESSION['User']['User']);
	    $this->data['user_address']=$this->UserAddress->findAll("user_id= '".$user_id."'");
        foreach($this->data['user_address'] as $k=>$v){
        //	  $arr = explode("-",$this->data[$k]['UserAddress']['telephone']);
        //	  if(isset($arr[2]) && !empty($arr[2])){
        	         $this->data['user_address'][$k]['UserAddress']['telephone_all'] = $this->data['user_address'][$k]['UserAddress']['telephone'];
        //	  }else{
        //	  	  	if(isset($arr[1])){
        //	         $this->data[$k]['UserAddress']['telephone_all'] = $arr[0]."-".$arr[1];
       	  //    		}else{
       	  //    		 $this->data[$k]['UserAddress']['telephone_all'] = $arr[0];
       	  //    		}
       	   //   }
       	      $this->data['user_address'][$k]['UserAddress']['telephone']=split("-",$v['UserAddress']['telephone']);
        			$this->Region->set_locale($this->locale);
					$region_array = explode(" ",trim($v['UserAddress']['regions']));
					$this->data['user_address'][$k]['UserAddress']['regions_id'] = $this->data['user_address'][$k]['UserAddress']['regions'];
					$this->data['user_address'][$k]['UserAddress']['regions'] = "";
					if(is_array($region_array) && sizeof($region_array)>0){
						foreach($region_array as $a=>$b){
							if($b == $this->languages['please_choose']){
								unset($region_array[$a]);
							}
						}
					}else{
						$region_array[] = 0;
					}			
					$region_name_arr = $this->Region->find('all',array('conditions'=>array('Region.id'=>$region_array)));
					if(is_array($region_name_arr) && sizeof($region_name_arr)>0){
						foreach($region_name_arr as $kk=>$vv){
							$this->data['user_address'][$k]['UserAddress']['regions'].= isset($vv['RegionI18n']['name'])?$vv['RegionI18n']['name']." ":"";
						}
					}					
					
					/*	foreach($region_array as $kk=>$region_id){
						//	echo "$region_id<br />";
							if($region_id != $this->languages['please_choose']){
								$region_info = $this->Region->findbyid($region_id);
								if($kk < sizeof($region_array)-1){
									$this->data[$k]['UserAddress']['regions'] .= $region_info['RegionI18n']['name']." ";
								}else{
									$this->data[$k]['UserAddress']['regions'] .= $region_info['RegionI18n']['name'];
								}
							}
						}    */    
        }

        $count_addresses=$this->UserAddress->findCount("user_id= '".$user_id."'");
       	$this->pageTitle = $this->languages['address_book']." - ".$this->configs['shop_title'];
       	$js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist'],
       						"address_label_not_empty" => $this->languages['address'].$this->languages['label'].$this->languages['can_not_empty'],
				       		"invalid_email" => $this->languages['email'].$this->languages['format'].$this->languages['not_correct'],
				       		"zip_code_not_empty" => $this->languages['post_code'].$this->languages['can_not_empty'],
				       		"invalid_tel_number" => $this->languages['telephone'].$this->languages['format'].$this->languages['not_correct'],
				       		"tel_number_not_empty" => $this->languages['telephone'].$this->languages['can_not_empty'],
				       		"invalid_mobile_number" => $this->languages['mobile'].$this->languages['format'].$this->languages['not_correct'],
							"address_label_not_empty" => $this->languages['address'].$this->languages['label'].$this->languages['can_not_empty'],
				       		"mobile_phone_not_empty" => $this->languages['mobile'].$this->languages['can_not_empty'],
				       		"address_detail_not_empty" => $this->languages['address'].$this->languages['can_not_empty'],
				       		"consignee_name_not_empty" => $this->languages['consignee'].$this->languages['can_not_empty'],
							"fill_one_contact" => $this->languages['please_enter'].$this->languages['one_contact'],
							"please_choose" => $this->languages['please_choose'],
							"not_less_eight_characters" => $this->languages['not_less_eight_characters'],
							"telephone_or_mobile" => $this->languages['telephone_or_mobile'],
							"choose_area" => $this->languages['please_choose'].$this->languages['region']
       		);
		$this->set('js_languages',$js_languages);
       	
	    $this->set('user_id',$user_id);
	    $this->set('count_addresses',$count_addresses);
	}
/*------------------------------------------------------ */
//-- 删除地址
/*------------------------------------------------------ */
	function deladdress($id){
		$this->UserAddress->del($id);
		//显示的页面
		$this->redirect("/addresses/");
	}

/*------------------------------------------------------ */
//-- 获得用户所有的收货人信息
/*------------------------------------------------------ */
	function get_consignee_list($user_id){
		$consignee_list=$this->UserAddress->findAll("user_id = '".$user_id."'");
		return $consignee_list;
	}

/*------------------------------------------------------ */
//-- 地址新function
/*------------------------------------------------------ */
	function change_region($region_id,$level,$target){
		$low_region=$this->Region->findAll("Region.parent_id = '".$region_id."'");
		$this->set('level',$level);
		$this->set('targets',$target);
		$this->set('low_region',$low_region);
		$this->set('province_list',    $this->get_regions(1));
		//显示的页面
		$this->layout = 'ajax';
	}
	
	
	function checkout_address_add(){
		$result=array();
//		$result['type']=1;
		if($this->RequestHandler->isPost()){
			$url = $this->server_host.$this->user_webroot."addresses";
			$url_user = $this->server_host.$this->cart_webroot;							
			$no_error = 1;
			if(isset($_POST['data']['UserAddress']['id']) && !empty($_POST['data']['UserAddress']['id'])){
				$_POST['data']['Address']['Region'] = $_POST['data']['Address']['Region'][$_POST['data']['UserAddress']['id']];
			}
			if(isset($_SESSION['User']['User']['id'])){
				if(!isset($_POST['is_ajax'])){
			    $this->page_init();
				if(in_array($this->languages['please_choose'],$_POST['data']['Address']['Region'])){
		 		    $region_error = 1;					
				}else{
					$this->Region->set_locale($this->locale);
					$region_info = $this->Region->findbyparent_id($_POST['data']['Address']['Region'][count($_POST['data']['Address']['Region'])-1]);
					if(isset($region_info['Region'])){		
		 		    $region_error = 1;					
					}
				}		
				if(trim($_POST['data']['UserAddress']['name']) == ""){
					$this->pageTitle = "".$this->languages['address'].$this->languages['can_not_empty']."";
		 		    $this->flash($this->languages['address'].$this->languages['can_not_empty'],$url,10);	
		 		    $no_error = 0;						
				}elseif(trim($_POST['data']['UserAddress']['consignee']) == ""){
					$this->pageTitle = "".$this->languages['consignee'].$this->languages['can_not_empty']."";
		 		    $this->flash($this->languages['consignee'].$this->languages['can_not_empty'],$url,10);	
		 		    $no_error = 0;						
				}elseif(trim($_POST['data']['UserAddress']['email']) == ""){
					$this->pageTitle = "".$this->languages['email'].$this->languages['can_not_empty']."";
		 		    $this->flash($this->languages['email'].$this->languages['can_not_empty'],$url,10);	
		 		    $no_error = 0;	
				}elseif(!ereg("^[-a-zA-Z0-9_.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$_POST['data']['UserAddress']['email'])){
					$this->pageTitle = "".$this->languages['email'].$this->languages['format'].$this->languages['not_correct']."";
		 		    $this->flash($this->languages['email'].$this->languages['format'].$this->languages['not_correct'],$url,10);	
		 		    $no_error = 0;	
				}elseif(isset($region_error) && $region_error == 1){
					$this->pageTitle = "".$this->languages['please_choose'].$this->languages['region']."";
		 		    $this->flash($this->languages['please_choose'].$this->languages['region'],$url,10);	
		 		    $no_error = 0;	
				}elseif(trim($_POST['data']['UserAddress']['address']) == ""){
					$this->pageTitle = "".$this->languages['address'].$this->languages['label'].$this->languages['can_not_empty']."";
		 		    $this->flash($this->languages['address'].$this->languages['label'].$this->languages['can_not_empty'],$url,10);	
		 		    $no_error = 0;						
				}elseif(trim($_POST['tel_0']) == "" || trim($_POST['tel_1']) == ""){
					$this->pageTitle = "".$this->languages['telephone'].$this->languages['can_not_empty']."";
		 		    $this->flash($this->languages['telephone'].$this->languages['can_not_empty'],$url,10);	
		 		    $no_error = 0;						
				}elseif(trim($_POST['data']['UserAddress']['mobile']) == ""){
					$this->pageTitle = "".$this->languages['mobile'].$this->languages['can_not_empty']."";
		 		    $this->flash($this->languages['mobile'].$this->languages['can_not_empty'],$url,10);	
		 		    $no_error = 0;					
				}
				$telephone = $_POST['tel_0']."-".$_POST['tel_1'];
				if($_POST['tel_2'] != ""){
					$telephone .= "-".$_POST['tel_2'];
				}
				$regions = implode(" ",$_POST['data']['Address']['Region']);					
				$address = array(
									'id' => isset($_POST['data']['UserAddress']['id'])?$_POST['data']['UserAddress']['id']:'',
									'user_id'=> $_SESSION['User']['User']['id'],
									'name' =>$_POST['data']['UserAddress']['name'],
									'consignee' =>$_POST['data']['UserAddress']['consignee'],
									'email' =>$_POST['data']['UserAddress']['email'],
									'address' =>$_POST['data']['UserAddress']['address'],
									'sign_building' =>$_POST['data']['UserAddress']['sign_building'],
									'zipcode' =>$_POST['data']['UserAddress']['zipcode'],
									'mobile' =>$_POST['data']['UserAddress']['mobile'],
									'best_time' =>$_POST['data']['UserAddress']['best_time'],
									'telephone'=>$telephone,
									'regions'=>$regions
									);
				}else{
					$address=(array)json_decode(StripSlashes($_POST['address']));
					$address['user_id']=$_SESSION['User']['User']['id'];	
				}
				if($no_error == 1){
					$this->UserAddress->save($address);
					if(isset($address['is_default']) && $address['is_default'] == 1){
						$address_id = $this->UserAddress->id;
						$update_user = array('id'=>$_SESSION['User']['User']['id'],'address_id'=>$address_id);
						$this->User->save($update_user);
					}
				}
				$result['type']=0;
				if(isset($_POST['is_add'])){
					$result['msg']=$this->languages['add'].$this->languages['successfully'];
				}else{
					$result['msg']=$this->languages['edit'].$this->languages['successfully'];
				}
				$result['id']=$this->UserAddress->id;
				if(!isset($_POST['is_ajax']) && $no_error == 1){
					$this->pageTitle = "".$this->languages['edit'].$this->languages['successfully']."";
		 	    	$this->flash($this->languages['edit'].$this->languages['successfully'],$url,10);	
				}				
			}else{
				$result['type']=1;
				$result['msg']=$this->languages['time_out_relogin'];
				if(!isset($_POST['is_ajax'])){
					$this->pageTitle = "".$this->languages['time_out_relogin']."";
		 	    	$this->flash($this->languages['time_out_relogin'],$url_user,10);	
				}
			}
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	//add by Gin
	function show_edit(){
		if($this->RequestHandler->isPost() ){
		$address = $this->UserAddress->findbyid($_POST['id']);
	//	$telephone_arr = explode("-",$address['UserAddress']['telephone']);
	//	$address['UserAddress']['telephone'] = $telephone_arr;
		$result['type']=0;
		$result['regions']=$address['UserAddress']['regions'];
		$result['address']= $address;
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	function show_add(){
		if(!isset($_SESSION['User'])){
				$this->redirect('/login/');
		}
		if($this->RequestHandler->isPost() ){
		$result['type']=0;
		$result['id'] = $_SESSION['User']['User']['id'];
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}

	//added by zhaojingna@seevia.cn 20090817 
	function show_edit_2kbuy($id,$user_id){
	  	$this->page_init();
		    //当前位置  
		$this->navigations[] = array('name'=>$this->languages['edit'].$this->languages['address'],'url'=>"");
		$this->set('locations',$this->navigations);		
		$this->pageTitle = $this->languages['edit'].$this->languages['address']."- ".$this->configs['shop_title'];
 		if(!isset($_SESSION['User'])){
			$this->redirect('/pages/login');
		}				
		if($this->RequestHandler->isPost() ){
	//	$address = $this->UserAddress->findbyid($_POST['id']);
	//	$telephone_arr = explode("-",$address['UserAddress']['telephone']);
	//	$address['UserAddress']['telephone'] = $telephone_arr;
	//	$result['type']=0;
	//	$result['regions']=$address['UserAddress']['regions'];
	//	$result['address']= $address;
	//	pr($address);exit;
		}
		$address = $this->UserAddress->findbyid($id);
		$user = $this->User->findbyid($user_id);
       	$js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist'],
       						"address_label_not_empty" => $this->languages['address'].$this->languages['label'].$this->languages['can_not_empty'],
				       		"invalid_email" => $this->languages['email'].$this->languages['format'].$this->languages['not_correct'],
				       		"zip_code_not_empty" => $this->languages['post_code'].$this->languages['can_not_empty'],
				       		"invalid_tel_number" => $this->languages['telephone'].$this->languages['format'].$this->languages['not_correct'],
				       		"tel_number_not_empty" => $this->languages['telephone'].$this->languages['can_not_empty'],
				       		"invalid_mobile_number" => $this->languages['mobile'].$this->languages['format'].$this->languages['not_correct'],
							"address_label_not_empty" => $this->languages['address'].$this->languages['label'].$this->languages['can_not_empty'],
				       		"mobile_phone_not_empty" => $this->languages['mobile'].$this->languages['can_not_empty'],
				       		"address_detail_not_empty" => $this->languages['address'].$this->languages['can_not_empty'],
				       		"consignee_name_not_empty" => $this->languages['consignee'].$this->languages['can_not_empty'],
							"fill_one_contact" => $this->languages['please_enter'].$this->languages['one_contact'],
							"please_choose" => $this->languages['please_choose'],
							"not_less_eight_characters" => $this->languages['not_less_eight_characters'],
							"telephone_or_mobile" => $this->languages['telephone_or_mobile'],
							"choose_area" => $this->languages['please_choose'].$this->languages['region']
       		);
		$this->set('js_languages',$js_languages);
	
	
		$this->set('address',$address);
		$this->set('user_address_id',$user['User']['address_id']);
	}

}
?>