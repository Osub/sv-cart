<?php
/*****************************************************************************
 * SV-Cart 前台控制
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: app_controller.php 3276 2009-07-23 09:14:17Z huangbo $
*****************************************************************************/
class AppController extends Controller {
	var $view = 'Theme'; 
	var $locale = '';
	var $lang = '';
//	var $lang_dictionarie = '';
	var $helpers = array('Html','Javascript','Form','Svshow','Minify','Cache');
	var $uses = array('Plugin','Vote','VoteOption','Language','Config','Navigation','Brand','Category','Article','LanguageDictionary','Template','Link','Product','Order');
	var $configs = array();
	var $languages = array();
	var $navigations = array();
	var $components = array('RequestHandler','Cookie','Session');
	
	function beforeFilter(){
		$this->Session->path='/';
		//echo $this->base;die();
		/* rewrite 模块关闭特殊处理webroot */
		$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		$this->server_host = "http://".$host;
    	if(Configure::read('App.baseUrl')){
        	$this->webroot = $webroot = str_replace("index.php","",$this->base);
        	$this->root_all = $this->webroot;//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/index.php/';
        	$this->user_webroot = $this->root_all . 'user/index.php/';
        	$this->cart_webroot = $this->root_all . 'index.php/';
        }
        else{
        	$this->root_all = $this->webroot;//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/';
        	$this->user_webroot = $this->root_all . 'user/';
        	$this->cart_webroot = $this->root_all;
        }
        $this->set('root_all',$this->root_all);
        $this->set('server_host',$this->server_host);
        $this->set('admin_webroot',$this->admin_webroot);
        $this->set('user_webroot',$this->user_webroot);
        $this->set('cart_webroot',$this->cart_webroot);
        
		//pr($this->user_webroot);
		//读取语言
		$this->locale = $this->Session->read('Config.locale');
		$SVlanguages = $this->Language->findalllang();
		$this->set('languages',$SVlanguages);
		if(isset($_GET['locale'])){
			foreach($SVlanguages as $k=>$v){
				if($v['Language']['locale'] == $_GET['locale']){
					$this->locale = $_GET['locale'];
				}
			}	
		}elseif(isset($_COOKIE['locale']) && $_COOKIE['locale'] != $this->Session->read('Config.locale')){
			foreach($SVlanguages as $k=>$v){
				if($v['Language']['locale'] == $_COOKIE['locale']){
					$this->locale = $_COOKIE['locale'];
					$this->Session->write('Config.locale',$_COOKIE['locale']);
					$this->Session->write('Config.language',$_COOKIE['locale']);
				}
			}
		}else if($this->locale == ""){
			foreach($SVlanguages as $k=>$v){
				if($v['Language']['is_default'] == 1){
					$this->locale = $v['Language']['locale'];
				}
			}
			$this->Cookie->write('locale',$this->locale);
			$this->Session->write('Config.locale',$this->locale);
		}
		//商店配置
		$this->Config->set_locale($this->locale);
		$this->configs = $this->Config->getformatcode($this->locale);
		//商店是否关闭
		if($this->params['action'] !="closed"){
			if($this->configs['shop_temporal_closed'] == 1){
				$this->redirect('/closed');
				exit;
			}
		}
		
		// 判断未登录用户
		if(isset($this->configs['access_right']) && $this->configs['access_right'] == 1){
			if(!isset($_SESSION['User'])){
				$this->redirect('/user/login');
				exit;
			}
		}		
		
		//单独运费 sku 地区语言价
		if(!isset($this->configs['use_product_shipping_fee'])){
			$this->configs['use_product_shipping_fee'] = 0;
		}
		if(!isset($this->configs['mlti_currency_module'])){
			$this->configs['mlti_currency_module'] = 0;
		}
		if(!isset($this->configs['use_sku'])){
			$this->configs['use_sku'] = 0;
		}
		$this->set('SVConfigs',$this->configs);
		//取完config 设置商店配置
		ini_set('date.timezone','Etc/GMT'.$this->configs['default_timezone']);
		
		/*
		字典语言
		*/		
		$this->languages = $this->LanguageDictionary->getformatcode($this->locale);
		$this->set('SCLanguages',$this->languages);
		
		//官网文章导航
		$this->Category->set_locale($this->locale);
		$navigate = $this->Category->tree('A',0,$this->locale);
//		pr($navigate['tree']);
		$this->set('articles_tree',$navigate['tree']);
		
		//友情链接
		
		//快速搜索图片大小
		if(isset($this->configs['search_autocomplete_image_height'])){
			$search_autocomplete_image = array("search_autocomplete_image_height"=>$this->configs['search_autocomplete_image_height'],
						"search_autocomplete_image_width" => $this->configs['search_autocomplete_image_width'],
						"page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']
			);
			$this->set("search_autocomplete_image",$search_autocomplete_image);
		}

		// 订单来源
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

	function full_page_init(){
		$this->Navigation->set_locale($this->locale);
 		$this->set('navigations',$this->Navigation->get_types($this->locale));
 		$this->navigations[0]=array('name'=>$this->languages['home'],'url'=>"/");

	}
	
	function page_init(){
		// 商品销售排行
		$condition = '1=1';
 		$total = $this->Order->findCount($condition,0);
		if($total > 0 && isset($this->configs['product_top_number']) && isset($this->configs['use_product_top']) && $this->configs['use_product_top'] == 1 && $this->configs['product_top_number']>0){
			$condition = "1=1";
			$condition .= " and Product.status ='1' and Product.forsale = '1'" ;
			$this->Product->set_locale($this->locale);
			$top_products=$this->Product->top_products($this->locale,$this->configs['product_top_number']);
			if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
				foreach($top_products as $k=>$v){
					$top_products[$k]['ProductI18n']['name'] = $this->Product->sub_str($v['ProductI18n']['name'], $this->configs['products_name_length']);
				}
			}	    	
	    	$this->set('top_products',$top_products);
		}
		
		$this->Link->set_locale($this->locale);
		$link_info = $this->Link->find_link($this->locale);
		$this->set('link_info',$link_info);
		
		//导航
		$this->Navigation->set_locale($this->locale);
 		$this->set('navigations',$this->Navigation->get_types($this->locale));
 		//商品分类
 		$this->Category->set_locale($this->locale);
 		$this->Category->tree('P',0,$this->locale);
 		$this->set('categories_tree', $this->Category->allinfo['tree']);
 		$this->set('categories', $this->Category->allinfo['assoc']);
 		
 		//品牌
 		$this->Brand->set_locale($this->locale);
 		$this->set('brands',$this->Brand->findassoc($this->locale));

 		//
 		$this->Article->set_locale($this->locale);
 		$this->set('scroll_articles',$this->Article->findscroll($this->locale));
 		//定义第一级导航
 		$this->navigations[0]=array('name'=>$this->languages['home'],'url'=>"/");
 		$ucdata = "";
 		if(!empty($_SESSION["ucdata"])){
 			$ucdata = $_SESSION["ucdata"];
 			$this->set("ucdata",$ucdata);
 			$_SESSION["ucdata"] = "";
 		}
	}
	
	
	
	
	function beforeRender() {
		$plugin_union = $this->Plugin->find_union();
	//	pr($plugin_union['Plugin']['function']);
		if(isset($plugin_union['Plugin']) && isset($_GET['source'])){
			$this->requestAction($plugin_union['Plugin']['function'].$_GET['source']);
		}
		//    /union_apps/set_union_user/
		$this->set('memory_useage',number_format((memory_get_usage()/1048576), 3, '.', ''));//占用内存 			
	//	$this->webroot=WEBROOT_DIR;
		//模版信息
		$cache_key = md5("template_list_");
		
		$template_list = cache::read($cache_key);
		if (!$template_list){
			$template_list=$this->Template->find('all',array('conditions'=>array('Template.status '=>1)));
			cache::write($cache_key,$template_list);
		}
		foreach($template_list as $k=>$v){
			if($v['Template']['is_default'] == 1){
				$default_template = $v;
			}
		}
		//多模版
		if(empty($_SESSION['template_use']) && isset($default_template)){
				$template_use=$default_template['Template']['name'];
	//			$_SESSION['template_style'] = $default_template['Template']['style'];
		//		$template_style = $default_template['Template']['style'];
				$_SESSION['template_use'] = $template_use;
		}else{
			$template_use=$_SESSION['template_use'];
	//		$template_style = isset($_SESSION['template_style'])?$_SESSION['template_style']:'';
		}
		if(isset($_GET['themes'])){
	//		$_SESSION['template_use'] =	$default_template['Template']['name'];
	//		$template_use=$_SESSION['template_use'];
			foreach($template_list as $k=>$v){
				if($v['Template']['name'] == $_GET['themes']){
					$_SESSION['template_use'] = $_GET['themes'];
	//				$_SESSION['template_style'] = $v['Template']['style'];
					$template_use=$_SESSION['template_use'];
				}
			}
		}
		if(empty($_SESSION['template_use'])){
			if($default_template){
				$code = $default_template['Template']['name'];	
//				$template_style = $default_template['Template']['style'];
//				$_SESSION['template_style'] = $default_template['Template']['style'];
			}else{
				$code = "SV_DEFAULT";
	//			$_SESSION['template_style'] = "";
	//			$template_style = "";
			}
		}else{
			$code = $_SESSION['template_use'];
	//		$template_style = isset($_SESSION['template_style'])?$_SESSION['template_style']:'';
		}
		
		if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
			$cart['quantity'] =0;
			$cart['total']=0;
			foreach($_SESSION['svcart']['products'] as $k=>$v){
				$cart['quantity'] += $v['quantity'];
				$cart['total'] += $v['subtotal'];
			}
			$this->set("header_cart",$cart);
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
        $_SESSION['template_style'] = $template_style;
      	$this->set('template_style',$template_style);
      	$this->set('template_list',$template_list);
		$this->set('template_use',$code);	
		//页面压缩
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
		if(isset($this->configs['gears_setting']) && $this->configs['gears_setting'] == 1){
        $cache_key = md5("gears_file");
		$gears_file = cache::read($cache_key);
		if (!$gears_file){		
		$gears_file = array(); 
        $svcart_dir = (dirname(dirname(dirname(dirname(__FILE__)))));
        if($template_style == ""){
        	$img_dir = $svcart_dir."/themed/".$code."/img/";
//        	$user_img_dir = $svcart_dir."/user/themed/".$code."/img/";
        }else{
        	$img_dir = $svcart_dir."/themed/".$code."/img/".$template_style."/";
//        	$user_img_dir = $svcart_dir."/user/themed/".$code."/img/".$template_style."/";
        }
	    $file_js_dir        = @opendir($svcart_dir."/themed/".$code."/js/");
	    $file_css_dir        = @opendir($svcart_dir."/themed/".$code."/css/");
	    $file_img_dir        = @opendir($img_dir);
//	    $file_user_js_dir        = @opendir($svcart_dir."/user/themed/".$code."/js/");
//	    $file_user_css_dir        = @opendir($svcart_dir."/user/themed/".$code."/css/");
//	    $file_user_img_dir        = @opendir($user_img_dir);	    
	    while ($file = readdir($file_js_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn')
	        {	    	
        		$gears_file[] =  $this->root_all."themed/".$code."/js/".$file;
        	}
        }

       	while ($file = readdir($file_css_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn')
	        {	    	
        		$gears_file[] =  $this->root_all."themed/".$code."/css/".$file;
        	}
        }
      	if(Configure::read('App.baseUrl')){
			$min_url = "min/index.php?f=";
		}else{
			$min_url = "min/f=";
		}
		$gears_file[] = "/".$min_url.$this->root_all."themed/".$code."/css/layout.css,".$this->root_all."themed/".$code."/css/component.css,".$this->root_all."themed/".$code."/css/login.css,".$this->root_all."themed/".$code."/css/menu.css,".$this->root_all."themed/SV_DEFAULT/css/containers.css,".$this->root_all."themed/SV_DEFAULT/css/autocomplete.css,".$this->root_all."themed/".$code."/css/style_".$template_style.".css,".$this->root_all."themed/".$code."/css/chi.css";
		$gears_file[] =	 "/".$min_url.$this->root_all."js/yui/yahoo-dom-event.js,".$this->root_all."js/yui/container_core-min.js,".$this->root_all."js/yui/menu-min.js,".$this->root_all."js/yui/element-beta-min.js,".$this->root_all."js/yui/animation-min.js,".$this->root_all."js/yui/connection-min.js,".$this->root_all."js/yui/container-min.js,".$this->root_all."js/yui/json-min.js,".$this->root_all."themed/SV_DEFAULT/js/common.js,".$this->root_all."js/swfobject.js";
       	while ($file = readdir($file_img_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn' && $file != 'Thumbs.db' && !is_dir($svcart_dir."/themed/".$code."/img/".$template_style."/".$file))
	        {	    	
        		$gears_file[] = $this->server_host.$this->root_all."themed/".$code."/img/".$template_style."/".$file;
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
        $content = gzencode($content." \n//此页已压缩",9);
        header("Content-Encoding: gzip");
        header("Vary: Accept-Encoding");
        header("Content-Length: ".strlen($content));
    }
    	return $content;
	} 
	


?>