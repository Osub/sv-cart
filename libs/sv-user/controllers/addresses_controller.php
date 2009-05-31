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
 * $Id: addresses_controller.php 1841 2009-05-27 06:51:37Z huangbo $
*****************************************************************************/
uses('sanitize');		
class AddressesController extends AppController {
	var $name = 'Addresses';
	var $helpers = array('Html');
	var $uses = array("UserAddress","Region");
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
    			            $this->flash($this->languages['add'].$this->languages['successfully'],'/addresses/','');
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
    			            $this->flash($this->languages['edit'].$this->languages['successfully'],'/addresses/','');
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
	    $this->data=$this->UserAddress->findAll("user_id= '".$user_id."'");
        foreach($this->data as $k=>$v){
        	  $arr = explode("-",$this->data[$k]['UserAddress']['telephone']);
        	  if(isset($arr[2]) && !empty($arr[2])){
        	         $this->data[$k]['UserAddress']['telephone_all'] = $this->data[$k]['UserAddress']['telephone'];
        	  }else{
        	  	  	if(isset($arr[1])){
        	         $this->data[$k]['UserAddress']['telephone_all'] = $arr[0]."-".$arr[1];
       	      		}else{
       	      		 $this->data[$k]['UserAddress']['telephone_all'] = $arr[0];
       	      		}
       	      }
       	      $this->data[$k]['UserAddress']['telephone']=split("-",$v['UserAddress']['telephone']);
        			$this->Region->set_locale($this->locale);
					$region_array = explode(" ",trim($v['UserAddress']['regions']));
					$this->data[$k]['UserAddress']['regions'] = "";
						foreach($region_array as $kk=>$region_id){
						//	echo "$region_id<br />";
							if(is_int($region_id)){
								$region_info = $this->Region->findbyid($region_id);
								if($kk < sizeof($region_array)-1){
									$this->data[$k]['UserAddress']['regions'] .= $region_info['RegionI18n']['name']." ";
								}else{
									$this->data[$k]['UserAddress']['regions'] .= $region_info['RegionI18n']['name'];
								}
							}
						}        
        }

        //pr($this->data);
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
		if($this->RequestHandler->isPost() ){
			if(isset($_SESSION['User']['User']['id'])){
				$address=(array)json_decode(StripSlashes($_POST['address']));
				$address['user_id']=$_SESSION['User']['User']['id'];			
				
			//	$address=(array)json_decode('{"Regions":"中国 上海 ","Name":"123","Consignee":"456","Address":"","Mobile":"","SignBuilding":"","Telephone":"","Zipcode":"","Email":"","BestTime":""}');
				$this->UserAddress->save($address);
				$result['type']=0;
				$result['msg']=$this->languages['edit'].$this->languages['successfully'];
				$result['id']=$this->UserAddress->id;
			}else{
				$result['type']=1;
				$result['msg']=$this->languages['time_out_relogin'];
			}
			

		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	//add by Gin
	function show_edit(){
		if($this->RequestHandler->isPost() ){
		$address = $this->UserAddress->findbyid($_POST['id']);
		$telephone_arr = explode("-",$address['UserAddress']['telephone']);
		$address['UserAddress']['telephone'] = $telephone_arr;
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

}
?>