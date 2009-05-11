<?php
/*****************************************************************************
 * SV-Cart 后台控制
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: app_controller.php 1327 2009-05-11 11:01:20Z huangbo $
*****************************************************************************/
class AppController extends Controller {
	var $locale = '';
	var $lang = '';
	var $helpers = array('Html','Javascript','Form');
	var $uses = array('Language','Config','Operator_action','Operator_menu','Operator','LanguageDictionary');
	var $configs = array();
	var $languages = array();
	var $navigations = array();
	
	function beforeFilter(){
	
		$navigation['name']="管理员首页";
		$navigation['url']="/";
		$this->navigations[] = $navigation;
		//系统全局参数
 		$this->locale = $this->Session->read('Admin_Config.locale');
		$this->Config->set_locale($this->locale);
		$this->configs = $this->Config->getformatcode();
		//define('AUTH_KEY', 'this is a key');
		ini_set('date.timezone','Etc/GMT'.$this->configs['default_timezone']);
		$this->today = date('Y-m-d H:i:s');
		//echo 'Etc/GMT'.$this->configs['default_timezone'];
			if($this->params['action'] != "log_out"){
				if (isset($_COOKIE['CakeCookie']['SV-Cart']['admin_id']) && isset($_COOKIE['CakeCookie']['SV-Cart']['admin_pass']) && isset($_COOKIE['CakeCookie']['SV-Cart']['locale'])){
			    	$operator_info = $this->Operator->findbyid($_COOKIE['CakeCookie']['SV-Cart']['admin_id']);
			    	//$_SESSION['Operator_Info'] = $operator_info;
			    	$this->set('operatorLogin',$operator_info);
			    	$operator_info['Operator']['last_login_time'] = date("Y-m-d H:i:s");
			    	$operator_info['Operator']['last_login_ip'] = $_SERVER["REMOTE_ADDR"];
			    	$this->Operator->save($operator_info);
			    	
					$this->Session->write('Operator_Info',$operator_info);
					$this->Session->write('Operator_Info.Operator.Operator_Ip',$_SERVER["REMOTE_ADDR"]);
					$this->Session->write('Operator_Info.Operator.Operator_Longin_Date',date("Y-m-d H:i:s"));
					$this->Session->write('Action_List',$operator_info['Operator']['actions']);
					$this->Session->write('Admin_Locale',$_COOKIE['CakeCookie']['SV-Cart']['locale']);
				}
			}
		//}
	//	}
		
		if(isset($_SESSION['Admin_Locale'])){		
			$locale =$this->Language->findbylocale($_SESSION['Admin_Locale']);
			if(isset($locale['Language']['locale'])){
				$this->Session->write('Admin_Config.locale',$locale['Language']['locale']);
				$this->Session->write('Admin_Config.language',$locale['Language']['locale']);
			}
		}


		$title_arr = array("look"=>array("title"=>"查看"),"remove"=>array("title"=>"删除"),"edit"=>array("title"=>"编辑"),"copy"=>array("title"=>"复制"),"trash"=>array("title"=>"回收站"),"select_img"=>array("title"=>"选择图片"),"help"=>array("title"=>"帮助"));	
	
		$this->set('SVConfigs',$this->configs);
		$this->set('now_locale',$this->locale);
		$this->languages=$this->Language->findall("front = 1");
		$this->set('languages',$this->languages);
		$this->set('title_arr',$title_arr);
		// hobby 20090127
		if (isset($_REQUEST["PHPSESSID"]) && $this->params['controller']=="images" && $this->params['action']=="upload") {
			//pr($_SESSION);
			session_id($_REQUEST["PHPSESSID"]);
			$_SESSION['Config'] 	= unserialize(stripslashes($_REQUEST["session_config_str"]));
			$_SESSION['Operator_Info'] = unserialize(stripslashes($_REQUEST["session_operator_str"]));
			$_SESSION['Admin_Config'] = unserialize(stripslashes($_REQUEST["session_admin_config_str"]));
			$_SESSION['Action_List'] = unserialize(stripslashes($_REQUEST["session_action_list_str"]));
			$_SESSION['Admin_Locale'] = unserialize(stripslashes($_REQUEST["session_admin_locale_str"]));
			$_SESSION['cart_back_url'] = unserialize(stripslashes($_REQUEST["cart_back_url"]));
			$this->Config->set_locale($_SESSION['Admin_Locale']);
			$this->configs = $this->Config->getformatcode();
		}
		if($this->params['action'] != "login" && $this->params['action'] != "act_login" && $this->params['action'] != 'get_authnums'){
			$this->checkSession();
		}
;
		if(isset($_SESSION['Operator_Info'])){
			$this->set('Operator_Longin_Date',$_SESSION['Operator_Info']['Operator']['Operator_Longin_Date']);
			$this->set('Operator_Ip',$_SESSION['Operator_Info']['Operator']['Operator_Ip']);
			$this->set('Operator_Name',$_SESSION['Operator_Info']['Operator']['name']);	
		}

		if($this->params['action'] == "login"){
			if(isset($_SESSION['Operator_Info'])){
				$this->redirect("/pages/home");
				
			}
		}
		if($this->params['action'] == "search"||$this->params['action'] == "index"&&$this->params['controller']!="flashes"&&@$_REQUEST['status']!="1"){
			$_SESSION['cart_back_url'] = str_replace($this->webroot, "", $_SERVER['REQUEST_URI']); 
		}
	//	pr($this->locale);
	//	pr($_COOKIE);
	//	pr($_SESSION);
	}
	
	function beforeRender() {
    }
	function checkSession(){
		//
        if (!$this->Session->check('Operator_Info')){
        //	exit;
        	if($this->params['controller'] == 'authnums'){
        	}else if($this->params['action'] == 'send_email' && $this->params['controller'] == 'pages'){
        	}else if($this->params['action'] == 'forget_password' && $this->params['controller'] == 'pages'){
        	}else if($this->params['action'] == 'change_password' && $this->params['controller'] == 'pages'){
        	}else if($this->params['action'] == 'update_password' && $this->params['controller'] == 'pages'){
        	}else {
            $this->redirect('/login');
            exit();
            }
        }
    }
    //管理员权限检查
    
    function operator_privilege($privilege){
    	$Operator_Action_List='';
    	$action_list=explode(';',$_SESSION['Action_List']);
    	foreach($action_list as $k=>$v){
    		   $action_codes=$this->Operator_action->findbyid($v);
    		   $Operator_Action_List .=$action_codes['Operator_action']['code'] .",";
    	}
    	  $_SESSION['Operator_Action_List']=$Operator_Action_List;
         if (strpos(',' . $_SESSION['Operator_Action_List'] . ',', ',' . $privilege . ',') === false){
         	   return false;
         }
         else{
         	   return true;
         }
    }
}
?>