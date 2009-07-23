<?php
/*****************************************************************************
 * SV-Cart 用户中心控制
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * 开发人员: test $
 * $Id: app_controller.php 3276 2009-07-23 09:14:17Z huangbo $
*****************************************************************************/
class AppController extends Controller {
	var $view = 'Theme'; 
	var $locale = '';
	var $lang = '';
	var $helpers = array('Html','Javascript','Form','Svshow','Minify');
	var $uses = array('Language','Config','Navigation','Brand','Category','Article','LanguageDictionary','Template','UserConfig');
	var $configs = array();
	var $navigations = array();
	var $components = array('RequestHandler','Cookie','Session');
	
	function beforeFilter(){
		$this->Session->path='/';
		$this->Session->start();
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
        
		$this->locale = $this->Session->read('Config.locale');
		$SVlanguages = $this->Language->findalllang();
		$this->set('languages',$SVlanguages);
		if(isset($_GET['locale'])){
			foreach($SVlanguages as $k=>$v){
				if($v['Language']['locale'] == $_GET['locale']){
					$this->locale = $_GET['locale'];
				}
			}
		}elseif(isset($_COOKIE['locale']) && $_COOKIE['locale'] != $this->Session->read('Config.locale') ){
			foreach($SVlanguages as $k=>$v){
				if($v['Language']['locale'] == $_COOKIE['locale']){
					$this->locale = $_COOKIE['locale'];
					$this->Session->write('Config.locale',$_COOKIE['locale']);
					$this->Session->write('Config.language',$_COOKIE['locale']);
				}
			}
		}
		if($this->locale == ""){
			foreach($SVlanguages as $k=>$v){
				if($v['Language']['is_default'] == 1){
					$this->locale = $v['Language']['locale'];
				}
			}
			$this->Cookie->write('SV-Cart.locale',$this->locale);
			$this->Session->write('Config.locale',$this->locale);
		}
				//官网导航
		$this->Category->set_locale($this->locale);
	//	$navigate = $this->Category->tree('A',0,$this->locale);
	//	$this->set('articles_tree',$navigate['tree']);

		//系统全局参数
		$this->Config->set_locale($this->locale);
		$this->configs = $this->Config->getformatcode();
		$this->set('SVConfigs',$this->configs);
		ini_set('date.timezone','Etc/GMT'.$this->configs['default_timezone']);
	
		
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
	
		
		$this->Config->set_locale($this->locale);
		$this->languages = $this->LanguageDictionary->getformatcode($this->locale);
		$this->set('SCLanguages',$this->languages);
		
		if($this->params['action'] !="closed"){
			if($this->configs['shop_temporal_closed'] == 1){
				$this->redirect($this->server_host . $this->cart_webroot .'closed');
				exit;
			}
		}
		
		$is_url = $this->server_host.$this->user_webroot."login/";
		if(($this->params['action'] =="register" || $this->params['action'] =="login")&& isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != $is_url){
 			$_SESSION['cart_back_url'] = $_SERVER['HTTP_REFERER'];
 		}


		if(isset($_SERVER['HTTP_REFERER'])){
			$referer_arr =array();
			$referer_arr = explode('/',$_SERVER['HTTP_REFERER']);
			$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
			if(!in_array($host,$referer_arr)){
				$this->Cookie->write('referer',$_SERVER['HTTP_REFERER'],false,time()+3600 * 24 * 365);
			}
		}
		$this->set('dlocal',$this->locale);
	}
	
	function page_init(){
		
		//分类信息
 		$this->Category->set_locale($this->locale);
 		$this->Category->tree('P',0,$this->locale);
 		$this->set('categories_tree', $this->Category->allinfo['tree']);
 	//	$this->set('categories', $this->Category->allinfo['assoc']);
		
		//品牌信息
 		$this->Brand->set_locale($this->locale);
 		
 		$this->set('brands',$this->Brand->findassoc($this->locale));
		
		//导航信息
		$this->Navigation->set_locale($this->locale);
		$navigations = $this->Navigation->get_types($this->locale);
		/*
		if(isset($navigations['T']) && count($navigations['T'])>0){
			foreach($navigations['T'] as $k=>$v){
				if(substr($navigations['T'][$k]['NavigationI18n']['url'],0,4) != 'java'){
				$navigations['T'][$k]['NavigationI18n']['url'] =  $this->server_host.$this->user_webroot.$navigations['T'][$k]['NavigationI18n']['url'];
	 			}
	 		}
 		}*/
 		
 		$this->set('navigations',$navigations);
 		
 		//滚动文章
 		$this->Article->set_locale($this->locale);
 		$this->set('scroll_articles',$this->Article->findscroll($this->locale));
 		
 		//导航初始化
 		$this->navigations[0]=array('name'=>$this->languages['user_center'],'url'=>"/");
 		

	}

    function beforeRender() {
		$this->set('memory_useage',number_format((memory_get_usage()/1048576), 3, '.', ''));//占用内存 						
		if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
			$cart['quantity'] =0;
			$cart['total']=0;
			foreach($_SESSION['svcart']['products'] as $k=>$v){
				$cart['quantity'] += $v['quantity'];
				$cart['total'] += $v['subtotal'];
			}
			$this->set("header_cart",$cart);
		}
	//	$this->webroot=WEBROOT_DIR;
		//模版信息
		$cache_key = md5("template_list_");
		$template_list = cache::read($cache_key);
		if (!$template_list){
			$template_list=$this->Template->findAll("where status='1'");
			cache::write($cache_key,$template_list);
		}
		foreach($template_list as $k=>$v){
			if($v['Template']['is_default'] == 1){
				$default_template = $v;
			}
		}
		//多模版
		if(empty($_SESSION['template_use'])){
				$template_use=$default_template['Template']['name'];
				$_SESSION['template_use'] = $template_use;
		}else{
			$template_use=$_SESSION['template_use'];
		}
		if(isset($_GET['themes'])){
			$_SESSION['template_use'] =	$default_template['Template']['name'];
			$template_use=$_SESSION['template_use'];
			foreach($template_list as $k=>$v){
				if($v['Template']['name'] == $_GET['themes']){
					$_SESSION['template_use'] = $_GET['themes'];
					$template_use=$_SESSION['template_use'];
				}
			}
		}
		if(empty($_SESSION['template_use'])){
			if($default_template){
				$code = $default_template['Template']['name'];	
			}else{
				$code = "SV_DEFAULT";
			}
		}else{
			$code = $_SESSION['template_use'];	
		}			
		$template_style ="";
		foreach($template_list as $k=>$v){
				if($v['Template']['name'] == $code){
					$template_style = $v['Template']['template_style'];
				}
		}		
		
		$template_style ="";
		foreach($template_list as $k=>$v){
				if($v['Template']['name'] == $code){
					$template_style = $v['Template']['template_style'];
				}
		}
		if(isset($_GET['theme_style'])){
			$_SESSION['template_style'] = $_GET['theme_style'];
			$template_style = $_GET['theme_style'];
			$this->set("img_style_url",$_GET['theme_style']);
		}elseif(isset($_SESSION['template_style'])){
			$template_style = $_SESSION['template_style'];
			$this->set("img_style_url",$_SESSION['template_style']);
		}elseif($template_style != ""){
			$_SESSION['template_style'] = $template_style;
			$this->set("img_style_url",$template_style);
		}else{
			$_SESSION['template_style'] = 'green';
			$this->set("img_style_url","green");
		}

        $this->theme = $code;
      	$this->set('template_style',$template_style);		
		
        $this->theme = $code;
      	$this->set('template_list',$template_list);
		$this->set('template_use',$code);	
		if(isset($this->configs['gears_setting']) && $this->configs['gears_setting'] == 1){
        $cache_key = md5("gears_file");
		$gears_file = cache::read($cache_key);
		if (!$gears_file){		
		$gears_file = array(); 
        $svcart_dir = (dirname(dirname(dirname(dirname(__FILE__)))));
        if($template_style == ""){
//        	$img_dir = $svcart_dir."/themed/".$code."/img/";
        	$user_img_dir = $svcart_dir."/user/themed/".$code."/img/green/";
        }else{
//        	$img_dir = $svcart_dir."/themed/".$code."/img/".$template_style."/";
        	$user_img_dir = $svcart_dir."/user/themed/".$code."/img/".$template_style."/";
        }
        $template_style_dir = $template_style."/";
//	    $file_js_dir        = @opendir($svcart_dir."/themed/".$code."/js/");
//	    $file_css_dir        = @opendir($svcart_dir."/themed/".$code."/css/");
//	    $file_img_dir        = @opendir($img_dir);
	    $file_user_js_dir        = @opendir($svcart_dir."/user/themed/".$code."/js/");
	    $file_user_css_dir        = @opendir($svcart_dir."/user/themed/".$code."/css/");
	    $file_user_img_dir        = @opendir($user_img_dir);
	    
      	if(Configure::read('App.baseUrl')){
			$min_url = "min/index.php?f=";
		}else{
			$min_url = "min/f=";
		}	   
		$gears_file[] = "/user/../".$min_url.$this->root_all."user/themed/SV_DEFAULT/css/layout.css,".$this->root_all."user/themed/SV_DEFAULT/css/component.css,".$this->root_all."user/themed/SV_DEFAULT/css/login.css,".$this->root_all."user/themed/SV_DEFAULT/css/menu.css,".$this->root_all."user/themed/SV_DEFAULT/css/containers.css,".$this->root_all."user/themed/SV_DEFAULT/css/autocomplete.css,".$this->root_all."user/themed/SV_DEFAULT/css/calendar.css,".$this->root_all."user/themed/SV_DEFAULT/css/treeview.css,".$this->root_all."user/themed/SV_DEFAULT/css/container.css,".$this->root_all."user/themed/SV_DEFAULT/css/style_".$template_style.".css,".$this->root_all."user/themed/SV_DEFAULT/css/chi.css";
		$gears_file[] = "/user/../".$min_url.$this->root_all."user/../js/yui/yahoo-dom-event.js,".$this->root_all."user/../js/yui/container_core-min.js,".$this->root_all."user/../js/yui/menu-min.js,".$this->root_all."user/../js/yui/element-beta-min.js,".$this->root_all."user/../js/yui/animation-min.js,".$this->root_all."user/../js/yui/connection-min.js,".$this->root_all."user/../js/yui/container-min.js,".$this->root_all."user/../js/yui/json-min.js,".$this->root_all."user/../js/yui/button-min.js,".$this->root_all."user/../js/yui/calendar-min.js,".$this->root_all."user/../js/yui/yahoo-min.js,".$this->root_all."user/../js/yui/treeview-min.js,".$this->root_all."user/themed/SV_DEFAULT/js/regions.js,".$this->root_all."user/themed/SV_DEFAULT/js/common.js";
	    
	    $file_js_str = $this->server_host."/min/index.php?f=";
 
       	while ($file = readdir($file_user_img_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn' && $file != 'Thumbs.db' && !is_dir($svcart_dir."/user/themed/".$code."/img/".$template_style_dir.$file))
	        {	    	
        		$gears_file[] = $this->root_all."user/themed/".$code."/img/".$template_style_dir.$file;
        	}
        }   	    
	    
	    while ($file = readdir($file_user_js_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn')
	        {	    	
        		$gears_file[] =  $this->root_all."user/themed/".$code."/js/".$file;
        	}
        }     
        
       	while ($file = readdir($file_user_css_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn')
	        {	    	
        	    $gears_file[] =  $this->root_all."user/themed/".$code."/css/".$file;
        	}
        }
   
     
			cache::write($cache_key,$gears_file);
		}
        	$this->set('gears_file',$gears_file);
        }
    }
    
		/**
		 * 获得系统是否启用了 gzip
		 */
	function gzip_enabled()
	{
	    static $enabled_gzip = NULL;

	    if ($enabled_gzip === NULL)
		{
		    $enabled_gzip = ($this->configs['enable_gzip'] && function_exists('ob_gzhandler'));
		}

	    return $enabled_gzip;
	}    
    
}

	function ob_gzip($content){   
	
    if(    !headers_sent() &&
        extension_loaded("zlib") &&
        strstr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip"))
    {
        $content = gzencode($content,9);
        header("Content-Encoding: gzip");
        header("Vary: Accept-Encoding");
        header("Content-Length: ".strlen($content));
    }
    	return $content;
	} 


?>