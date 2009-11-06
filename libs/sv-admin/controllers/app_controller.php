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
 * $Id: app_controller.php 5493 2009-11-03 10:47:49Z huangbo $
*****************************************************************************/
class AppController extends Controller {
	var $locale = '';
	var $lang = '';//
	var $helpers = array('Html','Javascript','Form','Minify');
	var $uses = array('Language','Config','Operator_action','Operator_menu','Operator','LanguageDictionary','Plugin','Operator_log');
	var $configs = array();
	var $languages = array();
	var $navigations = array();
	var $components = array('Cookie');
	function beforeFilter(){
		
		$this->Session->start('/sv-admin');
		/* rewrite 模块关闭特殊处理webroot */
		$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		$this->server_host = "http://".$host;
    	if(Configure::read('App.baseUrl')){
        	$this->webroot = $webroot = str_replace("index.php","",$this->base);
        	$this->root_all = str_replace( WEBROOT_DIR . '/','',$this->webroot);//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/index.php/';
        	$this->user_webroot = $this->root_all . 'user/index.php/';
        	$this->cart_webroot = $this->root_all . 'index.php/';
        }
        else{
        	$this->root_all = str_replace(WEBROOT_DIR."/","",$this->webroot);//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/';
        	$this->user_webroot = $this->root_all . 'user/';
        	$this->cart_webroot = $this->root_all;
        }
        $this->set('root_all',$this->root_all);
        $this->set('server_host',$this->server_host);
        
        $this->set('admin_webroot',$this->admin_webroot);
        $this->set('user_webroot',$this->user_webroot);
        $this->set('cart_webroot',$this->cart_webroot);
        
		$navigation['name']="管理首页";
		$navigation['url']="/";
		$this->navigations[] = $navigation;
		//系统全局参数
 		$this->locale = $this->Session->read('Admin_Locale');
		$SVlanguages = $this->Language->findalllang();
		$this->languages = $SVlanguages;
		if($this->locale == ""){
			foreach($SVlanguages as $k=>$v){
				if($v['Language']['is_default'] == 1){
					$this->locale = $v['Language']['locale'];
				}
			}
		} 		
		$configs_all = $this->Config->getformatcode_all();
		$this->configs = $configs_all[$this->locale];
		
		$this->set('memory_useage',number_format((memory_get_usage()/1048576), 3, '.', ''));//占用内存 	
		//时区设置
		$time_zone = @include ROOT."time_zone.php";
		ini_set('date.timezone',@$time_zone[@$_SESSION["Operator_Info"]["Operator"]["time_zone"]]);
		unset($time_zone);
		$this->today = date('Y-m-d H:i:s');
		if(isset($_SESSION['Admin_Locale'])){
			if(isset($locale['Language']['locale'])){
				$this->Session->write('Admin_Config.locale',$_SESSION['Admin_Locale']);
				$this->Session->write('Admin_Config.language',$_SESSION['Admin_Locale']);
			}
		}
		$this->set('config_timezone',explode("\n",$this->configs["default_timezone"]));
		//add by zhaojingna@seevia.cn 20090706
		$this->set('g_languages_count',count($SVlanguages));
    	$this->set('g_languages',$SVlanguages);//google快捷窗口需要的语言
		//pr($_SESSION);
		$title_arr = array("look"=>array("title"=>"查看"),"remove"=>array("title"=>"删除"),"edit"=>array("title"=>"编辑"),"copy"=>array("title"=>"复制"),"trash"=>array("title"=>"回收站"),"select_img"=>array("title"=>"选择图片"),"help"=>array("title"=>"帮助"));	
		$csv_charset = array("gbk"=>"chi","cht"=>"big5");	
		$this->set('SVConfigs'	,$this->configs);
		$this->set('now_locale'	,$this->locale);
		$this->set('languages'	,$SVlanguages);
		$this->set('title_arr'	,$title_arr);
		
		// hobby 20090127
		//pr($this->Session->read('Admin_Locale'));
		//pr($_SESSION);
		if (isset($_REQUEST["PHPSESSID"])) {
			//session_id($_REQUEST["PHPSESSID"]);
			
			$this->Session->write('Config',	unserialize(stripslashes($_REQUEST["session_config_str"])));
			$this->Session->write('Operator_Info',	unserialize(stripslashes($_REQUEST["session_operator_str"])));
			$this->Session->write('Admin_Config',	unserialize(stripslashes($_REQUEST["session_admin_config_str"])));
			$this->Session->write('Action_List',	unserialize(stripslashes($_REQUEST["session_action_list_str"])));
			$this->Session->write('Admin_Locale',	unserialize(stripslashes($_REQUEST["session_admin_locale_str"])));
			$this->Session->write('cart_back_url',	unserialize(stripslashes($_REQUEST["cart_back_url"])));
			
			$this->Config->set_locale($this->Session->read('Admin_Locale'));
			$this->configs = $this->Config->getformatcode();		
		}
		
		
		if($this->params['action'] != "log_out"){
			if (isset($_COOKIE['CakeCookie']['SV-Cart']['admin_id']) && isset($_COOKIE['CakeCookie']['SV-Cart']['admin_pass']) && isset($_COOKIE['CakeCookie']['SV-Cart']['locale'])){
				$operator_info = $this->Operator->findbyid($_COOKIE['CakeCookie']['SV-Cart']['admin_id']);
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
		
		
		if($this->params['action'] != "login" && $this->params['action'] != "act_login" && $this->params['action'] != 'get_authnums' && $this->params['action'] != 'test'){
			$this->checkSession();
		}
		if(isset($_SESSION['Operator_Info'])){
			$this->Session->write('Operator_Info',$_SESSION['Operator_Info']);
			$this->set('Operator_Longin_Date',$_SESSION['Operator_Info']['Operator']['Operator_Longin_Date']);
			$this->set('Operator_Ip',$_SESSION['Operator_Info']['Operator']['Operator_Ip']);
			$this->set('Operator_Name',$_SESSION['Operator_Info']['Operator']['name']);	
		}

		if($this->params['action'] == "login"){
			if(isset($_SESSION['Operator_Info'])){
				$this->redirect("/pages/home");
				
			}
		}
		if($this->params['action'] == "search"||$this->params['action'] == "index"&&$this->params['controller']!="flashes"&&@$_REQUEST['status']!="1"&&@$_REQUEST['export']!="export"){
			$this->Session->write("cart_back_url",str_replace($this->admin_webroot, "", $_SERVER['REQUEST_URI']));
		}
		//分页时cookie有读取
		$pagers_num_cookies = $this->Cookie->read('pagers_num_cookies');
    	if(!empty($pagers_num_cookies)){
    		$this->configs['show_count'] = $pagers_num_cookies;//重置分页数
    	}
    	//DAM
		if(isset($this->configs["mlti_currency_module"])&&$this->configs["mlti_currency_module"]==1){
			foreach( $configs_all as $k=>$v ){
				$this->currency_format[$k] = @$v["price_format"];
			}
			$this->set('currency_format',$this->currency_format);	
		}
		//DAM-END

	}
	
	function beforeRender() {
		if($this->action!="login"){
			$operator_menus = $this->operator_menus();
			$this->set('Operator_menu',$operator_menus);
		}
		/* 判断是否支持 Gzip 模式 */
		if ($this->gzip_enabled())
		{
			$this->set('gzip_is_start',1);
		    @ob_start('ob_gzhandler');
		}
		else
		{
			$this->set('gzip_is_start',0);
		    @ob_start();
		}
		
        $cache_key = md5("gears_file");
		$gears_file = cache::read($cache_key);
		if (!$gears_file){		
		$gears_file = array(); 
        $svcart_dir = (dirname(dirname(dirname(dirname(__FILE__)))));
        $img_dir = $svcart_dir."/sv-admin/img/";
        $js_dir = $svcart_dir."/sv-admin/js/";
        $css_dir = $svcart_dir."/sv-admin/css/";
        $yui_js_dir = $svcart_dir."/js/yui/";
	    $file_js_dir        = @opendir($js_dir);
	    $file_css_dir        = @opendir($css_dir);
	    $file_img_dir        = @opendir($img_dir); 
	    $file_yui_js_dir        = @opendir($yui_js_dir);   
	    
       	while ($file = readdir($file_img_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn' && $file != 'Thumbs.db' && $file != 'iepngfix.htc' && !is_dir($svcart_dir."/sv-admin/img/".$file))
	        {	    	
        		$gears_file[] = "/sv-admin/img/".$file;
        	}
        }	    
      	if(Configure::read('App.baseUrl')){
			$min_url = "min/index.php?f=";
		}else{
			$min_url = "min/f=";
		}
        
        $gears_file[]  =$this->root_all."sv-admin/../".$min_url.$this->root_all."sv-admin/../js/yui/yahoo-dom-event.js,".$this->root_all."sv-admin/../js/yui/container_core-min.js,".$this->root_all."sv-admin/../js/yui/menu-min.js,".$this->root_all."sv-admin/../js/yui/element-beta-min.js,".$this->root_all."sv-admin/../js/yui/animation-min.js,".$this->root_all."sv-admin/../js/yui/connection-min.js,".$this->root_all."sv-admin/../js/yui/get-min.js,".$this->root_all."sv-admin/../js/yui/container-min.js,".$this->root_all."sv-admin/../js/yui/tabview-min.js,".$this->root_all."sv-admin/../js/yui/json-min.js,".$this->root_all."sv-admin/../js/yui/calendar-min.js,".$this->root_all."sv-admin/js/common.js,".$this->root_all."sv-admin/js/calendar.js,".$this->root_all."sv-admin/../js/swfobject.js";
        $gears_file[]  =$this->root_all."sv-admin/../".$min_url.$this->root_all."sv-admin/css/layout.css,".$this->root_all."sv-admin/css/admin.css,".$this->root_all."sv-admin/css/calendar.css,".$this->root_all."sv-admin/css/menu.css,".$this->root_all."sv-admin/css/container.css,".$this->root_all."sv-admin/css/treeview.css,".$this->root_all."sv-admin/css/image.css,".$this->root_all."sv-admin/css/swfupload.css,".$this->root_all."sv-admin/css/tabview.css,".$this->root_all."sv-admin/css/style.css";
	    
	    
	    while ($file = readdir($file_js_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn'  && $file !='vendors.php' && !is_dir($svcart_dir."/sv-admin/js/".$file))
	        {	    	
        		$gears_file[] =  $this->root_all."sv-admin/js/".$file;
        	}
        }
	    while ($file = readdir($file_yui_js_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn' && $file !='vendors.php' && !is_dir($svcart_dir."/js/yui/".$file))
	        {	    	
        		 $gears_file[] =  $this->root_all."sv-admin/js/".$file;
        		 // $file_js_str .= $this->server_host."/js/".$file.",";
        	}
        }        /*

        if($file_js_str != "/sv-admin/../min/index.php?f="){
        	$file_js_str = substr($file_js_str,0,-1);
        	$gears_file[] = $file_js_str;
        }   
             
	    $file_css_str = "/sv-admin/../min/index.php?f=";*/
       	while ($file = readdir($file_css_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn' && $file != 'iepngfix.htc'&& !is_dir($svcart_dir."/sv-admin/css/".$file))
	        {	    	
        		$gears_file[] =  $this->root_all."sv-admin/css/".$file;
        	//	$file_css_str .="/themed/css/".$file.",";
        	}
        }/*
        if($file_css_str != "/sv-admin/../min/index.php?f="){
        	$file_css_str = substr($file_css_str,0,-1);
        	$gears_file[] = $file_css_str;
        }       */ 
       

			cache::write($cache_key,$gears_file);
		}
		
		//pr($this->server_host.$this->admin_webroot);
	//	pr($gears_file);
        $this->set('gears_file',$gears_file);

    }
    function afterFilter(){
    		$Operator_Info = $this->Session->read('Operator_Info');
			$this->Session->write('Operator_Info',$Operator_Info);
			$language = $this->Session->read('Admin_Config.language');
			$this->Session->write('Admin_Config.language',$language);
		    $locale = $this->Session->read('Admin_Config.locale');
			$this->Session->write('Admin_Config.locale',$locale);
			if($this->params['action'] != "log_out"){
				if (isset($_COOKIE['CakeCookie']['SV-Cart']['admin_id']) && isset($_COOKIE['CakeCookie']['SV-Cart']['admin_pass']) && isset($_COOKIE['CakeCookie']['SV-Cart']['locale'])){
					$operator_info = $this->Operator->findbyid($_COOKIE['CakeCookie']['SV-Cart']['admin_id']);
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
		
		//	$this->Session->write('Admin_Config.locale',$_SESSION['Admin_Config']['locale']);
		//	$this->Session->write('Admin_Config.language',$_SESSION['Admin_Config']['language']);			
    }
    
	function checkSession(){
        if (!$this->Session->check('Operator_Info')){
        	if($this->params['controller'] == 'authnums'){
        	}else if($this->params['action'] == 'send_email' && $this->params['controller'] == 'pages'){
        	}else if($this->params['action'] == 'forget_password' && $this->params['controller'] == 'pages'){
        	}else if($this->params['action'] == 'change_password' && $this->params['controller'] == 'pages'){
        	}else if($this->params['action'] == 'update_password' && $this->params['controller'] == 'pages'){
        	}else {
        	$_SESSION['login_back'] = $this->here;
            $this->redirect('/login');
            exit();
            }
        }
    }
    //管理员权限检查
    function operator_privilege($privilege){
    	if( $_SESSION['Action_List'] == "all" ){
    		return true;
    	}
    	$Operator_Action_List='';
    	$action_list=explode(';',$_SESSION['Action_List']);
    	foreach($action_list as $k=>$v){
    		   $action_codes=$this->Operator_action->findbyid($v);
    		   $Operator_Action_List .=$action_codes['Operator_action']['code'] .",";
    	}
		$_SESSION['Operator_Action_List']=$Operator_Action_List;
		if ($_SESSION['Action_List']!='all'&&strpos(',' . $_SESSION['Operator_Action_List'] . ',', ',' . $privilege . ',') === false){
			$this->flash("对不起,您没有执行此项操作的权限!",'./','',false);
		}else{
			return true;
		}
	}
	
    function operator_menus(){
        //获取菜单
		$cache_key = md5('Action_List_'.@$_SESSION['Action_List'].'_'.$this->locale);
		$operator_action = cache::read($cache_key);	
		$Operator_real_menus = cache::read($cache_key);
		if(!$Operator_real_menus){
	        $this->Operator_menu->set_locale($this->locale);
	        $Operator_menus=$this->Operator_menu->tree('all',$this->locale);
	        //pr($Operator_menus);
	        $sub_actions_id1=explode(';',@$_SESSION['Action_List']);
	        if($sub_actions_id1[0]!='all'){
	            //得到所有属于此操作员的action的id集合
	            $sub_actions_id2=array();
	            $condition=array("Operator_action.id" => $sub_actions_id1," Operator_action.parent_id != '0' and Operator_action.status = '1'");
	            $actions_list=$this->Operator_action->find_action($condition,$this->locale);
	            $Operator_real_menus=array();
	            foreach($Operator_menus as $k => $v){
	                $res[$k]['Operator_menu']=$v['Operator_menu'];
	                if(isset($v['SubMenu']) && is_array($v['SubMenu'])){
	                    foreach($v['SubMenu']as $key => $val){
	                        foreach($actions_list as $action_code){
	                            //echo "---------";
	                            //echo $action_code['Operator_action']['code'];
	                            if($val['Operator_menu']['operator_action_code']==$action_code['Operator_action']['code']){
	                                $res[$k]['SubMenu'][$key]['Operator_menu']=$val['Operator_menu'];
	                            }
	                        }
	                    }
	                }
	            }
	            if(isset($res) && is_array($res))
	            foreach($res as $menu_key => $menu){
	                if(isset($menu['SubMenu'])){
	                    $Operator_real_menus[$menu_key]=$menu;
	                }
	            }
	        }
	        else{
	            $Operator_real_menus=$Operator_menus;
	            //pr($Operator_real_menus);
	        }
        	cache::write($cache_key,$Operator_real_menus);
        }
        //	pr($Operator_real_menus);
        return $Operator_real_menus;
    }	
	
	
	
	
	
    //重载flash
	function flash($message, $url, $pause = 1,$type="true") {
		$this->autoRender = false;
		$this->set('url', Router::url($url));
		$this->set('message', $message);
		$this->set('pause', $pause);
		$this->set('page_title', $message);
		$this->set('type', $type);
		$this->render(false, 'flash');
	}
    //重载log
	function log($info){
		/* 增加记录post和get参数 */
		$remak = empty($_POST) ? '' : 'post|'.serialize($_POST);
		$remak .= empty($_GET) ? '' : 'get|'.serialize($_GET);
		
		$operator_logs = array(
			"operator_id"=>$_SESSION["Operator_Info"]["Operator"]["id"],
			"ipaddress"=>$this->real_ip(),
			"action_url"=>$this->AbsoluteUrl(),
			"info"=>$info,
			"type"=>1,
			"remark"=>$remak
		);
		$this->Operator_log->saveAll(array("Operator_log"=>$operator_logs));
	}
	function gzip_enabled()
	{
	    static $enabled_gzip = NULL;

	    if ($enabled_gzip === NULL)
		{
		    $enabled_gzip = ($this->configs['enable_gzip'] && function_exists('ob_gzhandler'));
		}

	    return $enabled_gzip;
	}   
        /**
     * 获得用户的真实IP地址
     *
     * @access  public
     * @return  string
     */
    function real_ip(){
        static $realip=NULL;
        if($realip!==NULL){
            return $realip;
        }
        if(isset($_SERVER)){
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $arr=explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
                /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
                foreach($arr AS $ip){
                    $ip=trim($ip);
                    if($ip!='unknown'){
                        $realip=$ip;
                        break;
                    }
                }
            }
            elseif(isset($_SERVER['HTTP_CLIENT_IP'])){
                $realip=$_SERVER['HTTP_CLIENT_IP'];
            }
            else{
                if(isset($_SERVER['REMOTE_ADDR'])){
                    $realip=$_SERVER['REMOTE_ADDR'];
                }
                else{
                    $realip='0.0.0.0';
                }
            }
        }
        else{
            if(getenv('HTTP_X_FORWARDED_FOR')){
                $realip=getenv('HTTP_X_FORWARDED_FOR');
            }
            elseif(getenv('HTTP_CLIENT_IP')){
                $realip=getenv('HTTP_CLIENT_IP');
            }
            else{
                $realip=getenv('REMOTE_ADDR');
            }
        }
        preg_match("/[\d\.]{7,15}/",$realip,$onlineip);
        $realip=!empty($onlineip[0]) ? $onlineip[0]: '0.0.0.0';
        return $realip;
    }
	function AbsoluteUrl() {
	    GLOBAL $HTTP_SERVER_VARS;
	    $HTTPS      =@$HTTP_SERVER_VARS["HTTPS"];
	    $HTTP_HOST  =$HTTP_SERVER_VARS["HTTP_HOST"];
	    $SCRIPT_URL =@$HTTP_SERVER_VARS["SCRIPT_URL"];
	    $PATH_INFO  =@$HTTP_SERVER_VARS["PATH_INFO"];
	    $REQUEST_URI=$HTTP_SERVER_VARS["REQUEST_URI"];
	    $SCRIPT_NAME=$HTTP_SERVER_VARS["SCRIPT_NAME"];

	    $QUERY_STRING=$HTTP_SERVER_VARS["QUERY_STRING"];
	    if (get_magic_quotes_gpc()==1) $QUERY_STRING=stripslashes($QUERY_STRING);
	    if ($QUERY_STRING!="") $QUERY_STRING="?".$QUERY_STRING;

	    $uri_http=(((strtolower($HTTPS)=="off")or($HTTPS==0)) ? 'http' : 'https') . '://' . $HTTP_HOST ;
	    $url="";
	    if (isset($SCRIPT_URL))
	         $url=$SCRIPT_URL;

	    else if (isset($PATH_INFO))
	            $url = $PATH_INFO;

	         else if (isset($REQUEST_URI))
	                 $url = $REQUEST_URI;

	              else if (isset($SCRIPT_NAME))
	                     $url = $SCRIPT_NAME;

	    $url=$uri_http.$url;

	    return $url;
	}
}
?>
